;window.arexworks = {};
function get_ajax_loading(){
    return jQuery('.arexworks-ajax-loading');
}
function get_message_box(){
    return jQuery('.arexworks-global-message');
}
function get_overlay(){
    return jQuery('.arexworks-overlay');
}
function arexworks_get_container_width(){
    var container_width = jQuery('#page_wrapper > .main > .row').innerWidth() - 30;
    if(jQuery('body').is('.header-layout-3') || jQuery('body').is('.header-layout-4')){
        if(jQuery(window).width() < 1300){
            container_width = jQuery(window).width();
        }
    }
    return container_width;
}
function arexworks_generate_rand(){
    return Math.round(new Date().getTime() + (Math.random() * 1000));
}
function addStyleSheet( css ) {
    var head, styleElement;
    head = document.getElementsByTagName('head')[0];
    styleElement = document.createElement('style');
    styleElement.setAttribute('type', 'text/css');
    if (styleElement.styleSheet) {
        styleElement.styleSheet.cssText = css;
    } else {
        styleElement.appendChild(document.createTextNode(css));
    }
    head.appendChild(styleElement);
    return styleElement;
}

// jQuery fn extend
(function(arexworks, $) {

    arexworks = arexworks || {};

    $.extend( arexworks, {
        options : {
            debug : true,
            show_sticky_header : arexworks_global_message.enable_sticky_header == '1' ? true : false,
            default_timer : 20,
            show_ajax_overlay : true,
            infiniteConfig : {
                navSelector  : "div.pagination",
                nextSelector : "div.pagination a.next",
                loading      : {
                    finished: function(){
                        $('.arexworks-infinite-loading').hide();
                    },
                    finishedMsg: "xx",
                    msg: $("<div class='arexworks-infinite-loading'><div></div></div>")
                }
            }
        },
        helpers : {
            is_email : function(email){
                var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(email);
            },
            is_cookie_enabled : function(){
                if (navigator.cookieEnabled) return true;
                // set and read cookie
                document.cookie = "cookietest=1";
                var ret = document.cookie.indexOf("cookietest=") != -1;
                // delete cookie
                document.cookie = "cookietest=1; expires=Thu, 01-Jan-1970 00:00:01 GMT";
                return ret;
            },
            is_touch_device : function(){
                return !!('ontouchstart' in window) // works on most browsers
                    || !!('onmsgesturechange' in window); // works on ie10
            },
            arw_add_query_arg : function(key, value){
                key = escape(key); value = escape(value);

                var s = document.location.search;
                var kvp = key+"="+value;

                var r = new RegExp("(&|\\?)"+key+"=[^\&]*");

                s = s.replace(r,"$1"+kvp);

                if(!RegExp.$1) {s += (s.length>0 ? '&' : '?') + kvp;};

                //again, do what you will here
                return s;
            },
            show_message: function ( message ) {
                var $message_box = get_message_box(),
                    $close_button = $message_box.find('.close-message'),
                    $message_box_content = $message_box.find('.inner-content-message'),
                    $counter_element = $message_box.find('.close-message-text span i'),
                    timer = arexworks.options.default_timer;
                if ( message ){
                    $message_box_content.html( message );
                }
                $message_box.show();


                if ( typeof window['global_interval'] === 'undefined' ){
                    window['global_interval'] = 1;
                }
                if ( typeof window['global_timer'] === 'undefined' ){
                    window['global_timer'] = 1;
                }

                clearInterval(global_interval);
                clearTimeout(global_timer);

                $counter_element.stop().html(timer);
                global_interval = setInterval(function(){

                    var timer_tmp = parseInt($counter_element.text()) - 1;
                    $counter_element.html( timer_tmp );
                    if ( timer_tmp == 0 ){
                        $message_box.hide();
                        clearInterval(global_interval);
                    }
                },1000);

                global_timer = setTimeout(function(){
                    $message_box.hide();
                }, parseInt(timer * 1000) );

                $close_button.on( 'click', function(e){
                    e.preventDefault();
                    clearTimeout(global_timer);
                    clearInterval(global_interval);
                    $message_box.hide();
                    get_overlay().hide();
                });
            },
            wc_variation_form_matcher : function ( product_variations, settings ){
                function variations_match( attrs1, attrs2 ){
                    var match = true;
                    for ( var attr_name in attrs1 ) {
                        if ( attrs1.hasOwnProperty( attr_name ) ) {
                            var val1 = attrs1[ attr_name ];
                            var val2 = attrs2[ attr_name ];
                            if ( val1 !== undefined && val2 !== undefined && val1.length !== 0 && val2.length !== 0 && val1 !== val2 ) {
                                match = false;
                            }
                        }
                    }
                    return match;
                }
                var matching = [];
                for ( var i = 0; i < product_variations.length; i++ ) {
                    var variation    = product_variations[i];

                    if ( variations_match( variation.attributes, settings ) ) {
                        matching.push( variation );
                    }
                }
                return matching;
            }
        }
    });

}).apply(this, [window.arexworks, jQuery]);

function log_js(){
    if ( typeof arexworks.options.debug !== 'undefined' && arexworks.options.debug ){
        try{
            console.log.apply(this, arguments)
        } catch(e) {}
    }
}

// jQuery fn extend
(function(arexworks, $) {
    "use strict";

    arexworks = arexworks || {};

    // Default Extend

    $.extend(arexworks, {
        DefaultExtend : {
             initialize : function(){
                 var self = this;
                 self.build()
                     .events();
                 return self;
             },
             build : function(){
                 var self = this;

                 /**
                  * Build-in Toggle Menu widget
                  */
                 var $array_widget_menu = $('.widget_categories,.widget_pages,.widget_product_categories,.widget_nav_menu,.widget_archive');
                 $array_widget_menu.each(function(){
                     $(this).find('li > ul').each(function(){
                         $(this).closest('li').prepend('<i class="control-menu-toggle-widget"></i>');
                     })
                 });

                 $('.sidebar-inner .widget .widget-title').each(function(){
                     if($(this).next().length){
                         if($(window).width() < 768){
                             $(this).addClass('toggle-widget-mobile').removeClass('open-widget-content');
                         }
                     }
                 });

                 try {
                     $('.arexworks-slick-slider').each(function(){
                         var $this = $(this),
                             slider_config = $this.data('slider_config') || {};

                         if($('body').is('.header-layout-3')){
                             if(slider_config.responsive){
                                 $.each(slider_config.responsive,function(key,value){
                                     if(value.breakpoint == 992){
                                         value.breakpoint = 1440;
                                     }
                                 });
                             }
                         }
                         $this.slick($.extend({
                             prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-angle-left"></i></button>',
                             nextArrow: '<button type="button" class="slick-next"><i class="fa fa-angle-right"></i></button>'
                         }, slider_config));
                     });

                     $('.ult-carousel-wrapper > div').each(function(){
                         if($('body').is('.header-layout-3')){
                             var $slick = $(this);
                             var slick_config_responsive = $slick.slick('slickGetOption','responsive');
                             var slick_config_responsive_new = new Array();
                             var slick_config_responsive_1440 = {
                                 breakpoint : 1440
                             };
                             var slick_config_responsive_1025 = {
                                 breakpoint : 1025
                             };
                             $.each(slick_config_responsive,function(key,value){
                                 if(value.breakpoint != 1025){
                                     slick_config_responsive_new.push(value);
                                 }
                                 if(value.breakpoint == 769){
                                     $.each(value,function(k,v){
                                         if(k == 'settings'){
                                             slick_config_responsive_1440.settings = v;
                                             slick_config_responsive_1025.settings = v;
                                         }
                                     });
                                 }
                             });

                             slick_config_responsive_new.unshift(slick_config_responsive_1025);
                             slick_config_responsive_new.unshift(slick_config_responsive_1440);
                             $slick.attr('data-slick_responsive', JSON.stringify(slick_config_responsive_new));
                         }
                     });
                     $('.ult-carousel-wrapper > div').each(function(){
                         var $slick = $(this),
                             slick_responsive = ($slick.data('slick_responsive') || false);
                         if(slick_responsive){
                             $slick
                                 .slick(
                                 'slickSetOption',
                                 'responsive',
                                 slick_responsive,
                                 true
                             )
                                 //.slick('slickSetOption','responsive',$slick.data('slick_responsive'),true)
                                 .slick("setPosition");
                         }
                     })
                 }
                 catch (ex){
                     log_js(ex)
                 }

                 return self;
             },
             events : function(){
                 var self = this;
                 /**
                  * Comment Form
                  */
                 try {
                     $('#commentform').on('submit',function(){
                         if($('#commentform #author').length > 0 &&  $('#commentform #author').val() == ''){
                             alert(arexworks_global_message.global.comment_author);
                             $('#commentform #author').focus();
                             return false;
                         }
                         if($('#commentform #email').length > 0 && !arexworks.helpers.is_email($('#commentform #email').val())){
                             alert(arexworks_global_message.global.comment_email);
                             $('#commentform #email').focus();
                             return false;
                         }
                         if($('#commentform #rating').length > 0 && $('#commentform #rating').val() == ''){
                             alert(arexworks_global_message.global.comment_rating);
                             return false;
                         }
                         if($('#commentform #comment').length > 0 && $('#commentform #comment').val() == ''){
                             alert(arexworks_global_message.global.comment_content);
                             $('#commentform #comment').focus();
                             return false;
                         }
                     });
                 } catch (ex) { log_js(ex); }

                 /**
                  * Auto Fancybox
                  */
                 try {
                     $(".arexworks-fancybox").fancybox({
                         helpers: {
                             overlay: {
                                 locked: false
                             }
                         }
                     });
                 } catch ( ex ) { log_js( ex ); }

                 $(document).on('click', '.sidebar-inner .widget .widget-title.toggle-widget-mobile', function(e){
                     $(this).toggleClass('open-widget-content');
                 })
                 /**
                  * Toggle Menu widget
                  */
                 $(document).on('click','.control-menu-toggle-widget',function(e){
                     e.preventDefault();
                     $(this).closest('li').toggleClass('active');
                     $(this).closest('li').children('ul').animate({
                         height : 'toggle'
                     })
                 });

                 try {
                     $( 'body' ).on( 'adding_to_cart', function ( event, $button, data ) {
                         $button && $button.hasClass( 'vc_gitem-link' ) && $button
                             .addClass( 'vc-gitem-add-to-cart-loading-btn' )
                             .parents( '.vc_grid-item-mini' )
                             .addClass( 'vc-woocommerce-add-to-cart-loading' )
                             .append( $( '<div class="vc_wc-load-add-to-loader-wrapper"><div class="vc_wc-load-add-to-loader"></div></div>' ) );
                     } ).on( 'added_to_cart', function ( event, fragments, cart_hash, $button ) {
                         if ( 'undefined' === typeof($button) ) {
                             $button = $( '.vc-gitem-add-to-cart-loading-btn' );
                         }
                         $button && $button.hasClass( 'vc_gitem-link' ) && $button
                             .removeClass( 'vc-gitem-add-to-cart-loading-btn' )
                             .parents( '.vc_grid-item-mini' )
                             .removeClass( 'vc-woocommerce-add-to-cart-loading' )
                             .find( '.vc_wc-load-add-to-loader-wrapper' ).remove();
                     } );
                 } catch (ex) { log_js(ex); }
                 return self;
             }
         },
        ScrollToTop: {

            defaults: {
                html: '<button><i class="fa-2x fa fa-angle-double-up"></i></button>',
                offsetx: 10,
                offsety: 0
            },

            initialize: function(html, offsetx, offsety) {
                this.html = (html || this.defaults.html);
                this.offsetx = (offsetx || this.defaults.offsetx);
                this.offsety = (offsety || this.defaults.offsety);

                this.build();

                return this;
            },

            build: function() {
                var self = this;

                if (typeof scrolltotop !== 'undefined') {
                    // scroll top control
                    scrolltotop.controlHTML = self.html;
                    scrolltotop.controlattrs = {offsetx: self.offsetx, offsety: self.offsety};
                    scrolltotop.init();
                }

                return self;
            }
        }
    });

    // Posts Infinite
    $.extend(arexworks, {
        PostsInfinite: {

            defaults: {
                elements: '.posts-infinite-container',
                itemSelector: '.posts-infinite-container .post-loop',
                infiniteConfig : $.extend( arexworks.options.infiniteConfig, {})
            },

            initialize: function($elements, itemSelector, infiniteConfig) {

                this.$elements = $($elements || this.defaults.elements);
                this.itemSelector = (itemSelector || this.defaults.itemSelector);
                this.infiniteConfig = (infiniteConfig || this.defaults.infiniteConfig);

                this.build().events();

                return this;
            },

            build: function() {
                var self = this;
                self.$elements.each(function() {
                    var $this = $(this);
                    var curr_page = $this.attr('data-page_num');
                    var page_path = $this.attr('data-path');
                    var max_page = $this.attr('data-page_num_max');
                    $this.infinitescroll(
                        $.extend( self.infiniteConfig, {
                            navSelector  : "div.pagination",
                            nextSelector : "div.pagination a.next",
                            itemSelector : self.itemSelector,
                            state : {
                                currPage: curr_page
                            },
                            pathParse : function(a, b) {
                                return [page_path, '/'];
                            },
                            dataType : 'html+callback',
                            maxPage : max_page,
                            appendCallback: false
                        }),
                        function(data) {
                            var $data = $(data).find(self.itemSelector);
                            $data.hide();
                            $data.find('.twitter-tweet').parent().removeClass('flex-video').removeClass('widescreen').addClass('twitter-tweet-iframe');
                            $this.append($data);
                            $data.imagesLoaded(function() {
                                $data.show();
                                if ($().isotope) {
                                    if ($this.data('isotope')) {
                                        $this.isotope('appended', $data).isotope('layout');
                                        $this.isotope('layout');
                                    }
                                }
                            });
                        }
                    );
                });

                return self;
            },

            events: function(){
                var self = this;

                return self;
            }
        }
    });

    // Portfolios Infinite
    $.extend(arexworks, {
        PortfoliosInfinite: {

            defaults: {
                elements: '.portfolios-infinite-container',
                itemSelector: '.portfolios-infinite-container .portfolio-loop',
                infiniteConfig : $.extend( arexworks.options.infiniteConfig, {})
            },

            initialize: function($elements, itemSelector, infiniteConfig) {

                this.$elements = $($elements || this.defaults.elements);
                this.itemSelector = (itemSelector || this.defaults.itemSelector);
                this.infiniteConfig = (infiniteConfig || this.defaults.infiniteConfig);

                this.build().events();

                return this;
            },

            build: function() {
                var self = this;
                self.$elements.each(function() {
                    var $this = $(this);
                    var curr_page = $this.attr('data-page_num');
                    var page_path = $this.attr('data-path');
                    var max_page = $this.attr('data-page_num_max');
                    $this.infinitescroll(
                        $.extend( self.infiniteConfig, {
                            navSelector  : "div.pagination",
                            nextSelector : "div.pagination a.next",
                            itemSelector : self.itemSelector,
                            state : {
                                currPage: curr_page
                            },
                            pathParse : function(a, b) {
                                return [page_path, '/'];
                            },
                            dataType : 'html+callback',
                            maxPage : max_page,
                            appendCallback: false
                        }),
                        function(data) {
                            var $data = $(data).find(self.itemSelector);
                            $data.hide();
                            $data.find('.twitter-tweet').parent().removeClass('flex-video').removeClass('widescreen').addClass('twitter-tweet-iframe');
                            $this.append($data);
                            $data.imagesLoaded(function() {
                                $data.show();
                                if ($().isotope) {
                                    if ($this.data('isotope')) {
                                        $this.isotope('appended', $data).isotope('layout');
                                        $this.isotope('layout');
                                    }
                                }
                            });
                        }
                    );
                });

                return self;
            },

            events: function(){
                var self = this;

                return self;
            }
        }
    });

    // Comments Infinite
    $.extend(arexworks, {

        CommentsInfinite: {

            defaults: {
                elements: $('.comments-infinite-container'),
                itemSelector: '.comments-infinite-container .comment-loop-depth-1'
            },

            initialize: function($elements, itemSelector) {
                this.$elements = ($elements || this.defaults.elements);
                this.itemSelector = (itemSelector || this.defaults.itemSelector);

                this.build().events();

                return this;
            },

            build: function() {
                var self = this;

                self.$elements.each(function() {
                    var $this = $(this);
                    var curr_page = $this.attr('data-page_num');
                    var max_page = $this.attr('data-page_num_max');
                    var path = $this.attr('data-path');
                    $this.infinitescroll(
                        $.extend( arexworks.options.infiniteConfig, {
                            navSelector  : "div.pagination",
                            nextSelector : "div.pagination a.next",
                            itemSelector : self.itemSelector,
                            state : {
                                currPage: curr_page
                            },
                            path : function( a ){
                                return path.replace('%#%',a);
                            },
                            maxPage : max_page,
                            animate : true
                        }),
                        function ( comments, options, url ){
                            if ( options.state.currPage == max_page ){
                                $('.load-more-comments').hide();
                            }
                        }
                    );
                });

                return self;
            },

            events: function(){
                var self = this;

                self.$elements.infinitescroll('pause');
                $(document).on( 'click', '.load-more-comments', function(e){
                    self.$elements.infinitescroll('retrieve');
                });

                return self;
            }
        }
    });

    // Products Infinite

    $.extend(arexworks, {
        ProductsInfinite : {
            defaults: {
                elements: '.products.products-infinite-container',
                itemSelector: '.products.products-infinite-container li.type-product',
                infiniteConfig : $.extend( arexworks.options.infiniteConfig, {})
            },

            initialize: function($elements, itemSelector, infiniteConfig) {

                this.$elements = $($elements || this.defaults.elements);
                this.itemSelector = (itemSelector || this.defaults.itemSelector);
                this.infiniteConfig = (infiniteConfig || this.defaults.infiniteConfig);

                this.build().events();

                return this;
            },

            build: function() {
                var self = this;
                self.$elements.each(function() {
                    var $this = $(this);
                    var curr_page = $this.attr('data-page_num');
                    var page_path = $this.attr('data-path');
                    var max_page = $this.attr('data-page_num_max');
                    $this.infinitescroll(
                        $.extend( self.infiniteConfig, {
                            navSelector  : ".woocommerce-pagination",
                            nextSelector : ".woocommerce-pagination a.next",
                            itemSelector : self.itemSelector,
                            state : {
                                currPage: curr_page
                            },
                            pathParse : function(a, b) {
                                return [page_path, '/'];
                            },
                            maxPage : max_page
                        }),
                        function(data) {
                        }
                    );
                });

                return self;
            },

            events: function(){
                var self = this;

                return self;
            }
        }
    });
    // Mega Menu
    $.extend(arexworks, {
        MegaMenu: {
            defaults: {
                menu: $('.mega-menu'),
                hoverIntentConfig : {
                    sensitivity: 2,
                    interval: 0,
                    timeout: 0
                },
                rtl:false
            },

            initialize: function(options) {

                this.$setting = $.extend(this.defaults,options);

                this.$menu = this.$setting.menu;

                this.build()
                    .events();

                return this;
            },

            IsSidebarMenu : function( $menu ){
                return $menu.closest('.mega-menu-sidebar').length;
            },
            IsRightMenu : function( $menu ){
                return false;
            },
            popupWidth : function(){
                var winWidth = $(window).width();

                if (winWidth >= arexworks_get_container_width())
                    return arexworks_get_container_width();
                if (winWidth >= 992)
                    return 940;
                if (winWidth >= 768)
                    return 720;

                return $(window).width() - 30;
            },
            build: function() {
                var self = this;

                self.$menu.each( function() {
                    var $menu = $(this);
                    var is_sidebar_menu = self.IsSidebarMenu( $menu );
                    var is_right_menu = self.IsRightMenu( $menu );

                    if ( is_sidebar_menu ){
                        self._side_menu( self, $menu );
                    }else{
                        self._normal_menu( self, $menu );
                    }
                });

                return self;
            },
            _normal_menu : function( self, $menu ) {
                var $menu_container = $menu.closest('.columns');
                var container_width = self.popupWidth();
                var offset = 0;


                if($(window).width() >= $menu_container.width()){
                    container_width = $menu_container.width();
                }

                if ($menu_container.length) {
                    if (self.$setting.rtl) {
                        offset = ($menu_container.offset().left + $menu_container.width()) - ($menu.offset().left + $menu.width()) + parseInt($menu_container.css('padding-right'));
                    } else {
                        offset = $menu.offset().left - $menu_container.offset().left - parseInt($menu_container.css('padding-left'));
                    }
                    offset = (offset == 1) ? 0 : offset;
                }

                var $menu_items = $menu.find('> li');

                $menu_items.each( function() {
                    var $menu_item = $(this);
                    var $popup = $menu_item.find('> .popup');
                    if ($popup.length > 0) {
                        $popup.css('display', 'block');
                        if ($menu_item.hasClass('wide')) {
                            $popup.css('left', 0);
                            var padding = parseInt($popup.css('padding-left')) + parseInt($popup.css('padding-right')) +
                                parseInt($popup.find('> .inner').css('padding-left')) + parseInt($popup.find('> .inner').css('padding-right'));

                            var row_number = 4;

                            if ($menu_item.hasClass('col-2')) row_number = 2;
                            if ($menu_item.hasClass('col-3')) row_number = 3;
                            if ($menu_item.hasClass('col-4')) row_number = 4;
                            if ($menu_item.hasClass('col-5')) row_number = 5;
                            if ($menu_item.hasClass('col-6')) row_number = 6;

                            if ($(window).width() < 992)
                                row_number = 1;

                            var col_length = 0;
                            $popup.find('> .inner > ul > li').each(function() {
                                var cols = parseInt($(this).attr('data-cols'));
                                if (cols < 1)
                                    cols = 1;

                                if (cols > row_number)
                                    cols = row_number;

                                col_length += cols;
                            });

                            if (col_length > row_number) col_length = row_number;

                            var popup_max_width = $popup.find('.inner').css('max-width');

                            var col_width = container_width / row_number;

                            if (popup_max_width != 'none' && parseInt(popup_max_width) < container_width) {

                                col_width = parseInt(popup_max_width) / row_number;
                            }

                            $popup.find('> .inner > ul > li').each(function() {
                                var cols = parseFloat($(this).attr('data-cols'));
                                if (cols < 1)
                                    cols = 1;

                                if (cols > row_number)
                                    cols = row_number;

                                if ($menu_item.hasClass('pos-center') || $menu_item.hasClass('pos-left') || $menu_item.hasClass('pos-right'))
                                    $(this).css('width', (100 / col_length * cols) + '%');
                                else
                                    $(this).css('width', (100 / row_number * cols) + '%');
                            });

                            if ($menu_item.hasClass('pos-center')) { // position center
                                $popup.find('> .inner > ul').width(col_width * col_length - padding);
                                var left_position = $popup.offset().left - ($(window).width() - col_width * col_length) / 2;
                                $popup.css({
                                    'left': -left_position
                                });
                            } else if ($menu_item.hasClass('pos-left')) { // position left
                                $popup.find('> .inner > ul').width(col_width * col_length - padding);
                                $popup.css({
                                    'left': 0
                                });
                            } else if ($menu_item.hasClass('pos-right')) { // position right
                                $popup.find('> .inner > ul').width(col_width * col_length - padding);
                                $popup.css({
                                    'left': 'auto',
                                    'right': 0
                                });
                            } else { // position justify
                                $popup.find('> .inner > ul').width(container_width - padding);
                                if (self.$setting.rtl) {
                                    $popup.css({
                                        'right': 0,
                                        'left': 'auto'
                                    });
                                    var right_position = ($popup.offset().left + $popup.width()) - ($menu.offset().left + $menu.width()) - offset;
                                    $popup.css({
                                        'right': right_position,
                                        'left': 'auto'
                                    });
                                } else {
                                    $popup.css({
                                        'left': 0,
                                        'right': 'auto'
                                    });
                                    var left_position = $popup.offset().left - $menu.offset().left + offset;
                                    $popup.css({
                                        'left': -left_position,
                                        'right': 'auto'
                                    });
                                }
                            }
                        }
                        if (!($menu.hasClass('effect-down')))
                            $popup.css('display', 'none');

                        $menu_item.hoverIntent(
                            $.extend({}, self.$setting.hoverIntentConfig, {
                                over: function(){
                                    if (!($menu.hasClass('effect-down')))
                                        $menu_items.find('.popup').hide();
                                    $popup.show();
                                },
                                out: function(){
                                    if (!($menu.hasClass('effect-down')))
                                        $popup.hide();
                                }
                            })
                        );
                    }
                });
            },
            _side_menu : function( self, $menu ) {
                var $menu_container = $menu.closest('.container');
                var container_width;
                if ($(window).width() < 992 ){
                    container_width = self.popupWidth();
                }
                else{
                    container_width = self.popupWidth() - 45;
                    if( $menu.closest('body').hasClass('header-layout-3') || $menu.closest('body').hasClass('header-layout-4') ){
                        container_width = container_width - $menu.width() - 40;
                    }
                }

                var is_right_sidebar = self.IsRightMenu($menu);

                var $menu_items = $menu.find('> li');

                $menu_items.each( function() {
                    var $menu_item = $(this);
                    var $popup = $menu_item.find('> .popup');
                    if ($popup.length > 0) {
                        $popup.css('display', 'block');
                        if ($menu_item.hasClass('wide')) {
                            $popup.css('left', 0);
                            var padding = parseInt($popup.css('padding-left')) + parseInt($popup.css('padding-right')) +
                                parseInt($popup.find('> .inner').css('padding-left')) + parseInt($popup.find('> .inner').css('padding-right'));

                            var row_number = 4;

                            if ($menu_item.hasClass('col-2')) row_number = 2;
                            if ($menu_item.hasClass('col-3')) row_number = 3;
                            if ($menu_item.hasClass('col-4')) row_number = 4;
                            if ($menu_item.hasClass('col-5')) row_number = 5;
                            if ($menu_item.hasClass('col-6')) row_number = 6;

                            if ($(window).width() < 992)
                                row_number = 1;

                            var col_length = 0;
                            $popup.find('> .inner > ul > li').each(function() {
                                var cols = parseInt($(this).attr('data-cols'));
                                if (cols < 1)
                                    cols = 1;

                                if (cols > row_number)
                                    cols = row_number;

                                col_length += cols;
                            });

                            if (col_length > row_number) col_length = row_number;

                            var popup_max_width = $popup.find('.inner').css('max-width');
                            var col_width = container_width / row_number;
                            if ('none' !== popup_max_width && popup_max_width < container_width) {
                                col_width = parseInt(popup_max_width) / row_number;
                            }

                            $popup.find('> .inner > ul > li').each(function() {
                                var cols = parseFloat($(this).attr('data-cols'));
                                if (cols < 1)
                                    cols = 1;

                                if (cols > row_number)
                                    cols = row_number;

                                if ($menu_item.hasClass('pos-center') || $menu_item.hasClass('pos-left') || $menu_item.hasClass('pos-right'))
                                    $(this).css('width', (100 / col_length * cols) + '%');
                                else
                                    $(this).css('width', (100 / row_number * cols) + '%');
                            });

                            $popup.find('> .inner > ul').width(col_width * col_length + 1);
                            if (is_right_sidebar) {
                                $popup.css({
                                    'left': 'auto',
                                    'right': $(this).width()
                                });
                            } else {
                                $popup.css({
                                    'left': $(this).width(),
                                    'right': 'auto'
                                });
                            }
                        }
                        if (!($menu.hasClass('subeffect-down')))
                            $popup.css('display', 'none');

                        $menu_item.hoverIntent(
                            $.extend({}, self.$setting.hoverIntentConfig, {
                                over: function(){
                                    if (!($menu.hasClass('subeffect-down')))
                                        $menu_items.find('.popup').hide();
                                    $popup.show();
                                    $popup.parent().addClass('open');
                                },
                                out: function(){
                                    if (!($menu.hasClass('subeffect-down')))
                                        $popup.hide();
                                    $popup.parent().removeClass('open');
                                }
                            })
                        );
                    }
                });
            },
            events: function() {
                var self = this;

                $('.header-toogle-menu-button').on('click',function(){
                    if($(this).hasClass('active')){
                        $('.header-toogle-menu-button').removeClass('active');
                    }else{
                        $('.header-toogle-menu-button').addClass('active');
                    }
                    $('.header-wrapper .mega-menu-sidebar').toggleClass('open-menu');
                });


                $(window).on('resize', function() {
                    self.build();
                });

                setTimeout(function() {
                    self.build();
                }, 400);

                return self;
            }
        }
    });


    // Accordion Menu
    $.extend(arexworks, {

        AccordionMenu: {

            defaults: {
                menu: $('.accordion-menu')
            },

            initialize: function($menu) {
                this.$menu = ($menu || this.defaults.menu);

                this.events()
                    .build();

                return this;
            },

            build: function() {
                var self = this;

                self.$menu.find('li.menu-item.active').each(function() {
                    if ($(this).find('> .arrow').length)
                        $(this).find('> .arrow').trigger('click');
                });

                return self;
            },

            events: function() {
                var self = this;

                self.$menu.find('.arrow').on('click',function() {
                    var $parent = $(this).parent();
                    $(this).next().stop().slideToggle();
                    if ($parent.hasClass('open')) {
                        $parent.removeClass('open');
                    } else {
                        $parent.addClass('open');
                    }
                });

                $(document).on('click', '.toggle-menu-mobile-button, #mobile_menu_wrapper_overlay', function(e){
                    e.preventDefault();
                    $('body').toggleClass('open-mobile-menu');
                });

                $(window).resize(function(){
                    if($(window).width() > 992){
                        $('body').removeClass('open-mobile-menu');
                    }
                })

                return self;
            }
        }

    });

    // StickyHeader
    $.extend(arexworks, {
        StickyHeader: {

            defaults: {
                header: $('#header')
            },

            initialize: function($header) {
                this.$header = ($header || this.defaults.header);
                this.sticky_height = 0;
                this.sticky_offset = 0;
                this.sticky_pos = 0;

                this.$header = ($header || this.defaults.header);

                if (!arexworks.options.show_sticky_header || !this.$header.length)
                    return this;

                var self = this;

                self.reset()
                    .build()
                    .events();
                return self;
            },

            build: function() {
                var self = this;

                var scroll_top = $(window).scrollTop(),
                    $this_header_sticky = self.$header;

                if(self.$header.css('position') == 'fixed'){
                    $this_header_sticky = self.$header;
                }
                if(self.$header.find('.header-main').css('position') == 'fixed'){
                    $this_header_sticky = self.$header.find('.header-main');
                }
                if(self.$header.find('.main-menu-wrap').css('position') == 'fixed'){
                    $this_header_sticky = self.$header.find('.main-menu-wrap');
                }

                if (scroll_top > self.sticky_pos) {
                    self.$header.addClass('active-sticky');
                    $this_header_sticky.css({
                        'top' : self.adminbar_height
                    });
                }else{
                    self.$header.removeClass('active-sticky');
                    $this_header_sticky.removeAttr('style');
                }

                return self;
            },

            reset: function() {
                var self = this;

                var $admin_bar = $('#wpadminbar');
                var height = 0;
                if ($admin_bar.length) {
                    height = $('#wpadminbar').css('position') == 'fixed' ? $('#wpadminbar').height() : 0;
                }
                self.adminbar_height = height;

                if( self.$header.closest('body').is('.header-layout-3')){
                    self.sticky_pos = self.$header.find('.header-main').height() + self.adminbar_height;
                }else{
                    self.sticky_pos = self.$header.height() + self.adminbar_height;
                }

                self.$header.removeAttr('style');

                return self;
            },

            events: function() {
                var self = this;

                $(window).on('resize', function() {
                    self.reset()
                        .build();
                });

                $(window).on('scroll', function() {
                    self.build();
                });

                return self;
            }
        }
    });

    // Product Zoom
    $.extend(arexworks, {
        ProductZoom : {
            defaults: {
                images : '#main_product_single_image .main_product_single_image_slider',
                thumbnails : '#main_product_single_thumbnail_image .main_product_single_thumbnail_image_slider'
            },
            initialize : function(options){
                this.options = $.extend(this.defaults , options);
                this.$images = $(this.options.images);
                this.$thumbnails = $(this.options.thumbnails);
                this.enable_zoom = false;
                this.enable_popup = false;
                if ( this.$images.length == 0 ) {
                    return this;
                }
                var self = this;
                if ( self.$images.data('zoom') == 'yes' ){
                    self.enable_zoom = true;
                }
                if ( self.$images.data('popup') == 'yes' ){
                    self.enable_popup = true;
                }

                if ( self.$images.closest('.arexworks-modal').length > 0 ){
                    self.enable_popup = false;
                }

                self.build()
                    .events();
                return self;
            },
            build: function(){
                var self = this;
                if ( self.$images.length == 0 ){
                    return self;
                }
                try{
                    self.$images.slick({
                        prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-angle-left"></i></button>',
                        nextArrow: '<button type="button" class="slick-next"><i class="fa fa-angle-right"></i></button>',
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        arrows: false,
                        dots: false,
                        fade: true,
                        asNavFor: self.options.thumbnails
                    });
                }catch (ex){
                    log_js(ex);
                }
                try{
                    self.$thumbnails.slick({
                        prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-angle-left"></i></button>',
                        nextArrow: '<button type="button" class="slick-next"><i class="fa fa-angle-right"></i></button>',
                        slidesToShow: 4,
                        slidesToScroll: 1,
                        arrows: true,
                        dots: false,
                        focusOnSelect: true,
                        asNavFor: self.options.images
                    });
                    self.$thumbnails.find('.slick-active').first().addClass('slick-current');
                }catch (ex){
                    log_js(ex);
                }

                return self;

            },
            events: function(){
                var self = this;
                if ( self.$images.length == 0 ){
                    return self;
                }

                var zoom_image = self.options.images + ' .product-image-main';
                if ( self.enable_zoom ){
                    try {
                        $(zoom_image).easyZoom({
                            preventClicks: false
                        });
                        $(document).on('click', zoom_image + ' .easyzoom-flyout' ,function(){
                            $(this).prev('a').trigger('click');
                        })

                    }catch (ex){
                        log_js(ex);
                    }
                }

                var link_image = self.options.images + ' .slick-slide a';
                if ( self.enable_popup ){
                    $(link_image)
                        .attr('rel','product-single-gallery')
                        .fancybox({
                            helpers: {
                                overlay: {
                                    locked: false
                                }
                            }
                        });
                }else {

                    $(document).on('click', link_image, function( e ){
                        return false;
                    });
                }
                self.$thumbnails.on('afterChange', function(event, slick, currentSlide){
                    slick.$slides.removeClass('slick-current');
                    slick.$slides.eq(currentSlide).addClass('slick-current');
                });
                var thumb_link = self.options.thumbnails + ' .thumbnail-images';
                $(document).on('click', thumb_link ,function(e){
                    $(thumb_link).removeClass('slick-current');
                    $(this).addClass('slick-current');
                    var total_item = self.$thumbnails.slick('getSlick').$slides.length;
                    var currentSlide = $(this).data('slickIndex');

                    if(currentSlide >= total_item){
                        currentSlide = currentSlide - total_item;
                    }

                    self.$thumbnails.slick('slickGoTo',currentSlide,false);
                    self.$images.slick('slickGoTo',currentSlide,false);
                });

                return self;
            }
        }
    });

    // WooCommerce
    $.extend(arexworks, {
        WooEcommerce : {
            initialize : function(){
                var self = this;

                self.build()
                    .events();

                return self;
            },
            build : function(){
                var self = this;
                return self;
            },
            events : function(){
                var self = this;
                /**
                 * Add to cart
                 */
                try {
                    $(document)
                        .on( 'adding_to_cart', function ( e, $button, data ) {
                            var $loading = get_ajax_loading(),
                                $overlay = get_overlay();
                            if (arexworks.options.show_ajax_overlay)
                                $overlay.show();
                            $loading.show();
                        } )
                        .on( 'added_to_cart', function( e, fragments, cart_hash, $button ){
                            var $button_view_cart = $button.parent().find('.added_to_cart'),
                                $loading = get_ajax_loading(),
                                $overlay = get_overlay(),
                                $product_image = $button.closest('.product').find('.product_thumbnail img:eq(0)'),
                                target_attribute = $('body').is('.woocommerce-yith-compare') ? ' target="_parent"' : '',
                                product_name;

                            if( $product_image.length == 0 ){
                                $product_image = $button.closest('tr').find('.product-thumbnail img:eq(0)');
                            }
                            if( $product_image.length == 0 && $button.closest('table').is('.compare-list')){
                                $product_image = $button.closest('table').find('tr.image .image-wrap img:eq(0)');
                            }

                            if ( $button.data('product_title') != '')
                                product_name = $button.data('product_title');
                            else
                                product_name = $button.closest('.product').find('.product-title-link').first().text();

                            if (product_name == '')
                                product_name = 'Product';

                            $overlay.hide();
                            $loading.hide();

                            var custom_view_cart_html = '<span>';
                            custom_view_cart_html += '<span class="icon"><i class="fa fa-check"></i></span>';
                            custom_view_cart_html += '<span class="text">' + $button_view_cart.text() + '</span>';
                            custom_view_cart_html += '</span>';

                            $button_view_cart.addClass('button').html(custom_view_cart_html);

                            var html = '<div class="popup-icon"><i class="fa fa-check-circle-o"></i></div>';
                                html += '<div class="popup-message">' + arexworks_global_message.addcart.success + '</div>';
                                html += '<div class="popup-product">';
                                    if ($product_image.length){
                                        html += $('<div>').append($product_image.clone()).html();
                                    }
                                    html += '<h5>' + product_name + '</h5>';
                                html += '</div>';
                                html += '<a class="button view-popup-addcart" ' + target_attribute + ' href="' + wc_add_to_cart_params.cart_url + '">' + wc_add_to_cart_params.i18n_view_cart + '</a>';

                            $('.shopping-bag-button .cart-items').html(fragments.total_item_count);

                            arexworks.helpers.show_message(html);

                        } );
                } catch ( ex ) { log_js( ex ); }

                /**
                 * Add to wishlist
                 */

                try {
                    $(document).on('click','.product a.add_wishlist',function(e){
                        if(!$(this).hasClass('added')) {
                            e.preventDefault();
                            var $button = $(this),
                                $overlay = get_overlay(),
                                $loading = get_ajax_loading();

                            var product_id = $button.data('product_id'),
                                data = {
                                    add_to_wishlist: product_id,
                                    product_type: $button.data('product-type'),
                                    action: yith_wcwl_l10n.actions.add_to_wishlist_action
                                };

                            if (yith_wcwl_l10n.multi_wishlist && yith_wcwl_l10n.is_user_logged_in) {
                                var wishlist_popup_container = $button.parents('.yith-wcwl-popup-footer').prev('.yith-wcwl-popup-content'),
                                    wishlist_popup_select = wishlist_popup_container.find('.wishlist-select'),
                                    wishlist_popup_name = wishlist_popup_container.find('.wishlist-name'),
                                    wishlist_popup_visibility = wishlist_popup_container.find('.wishlist-visibility');

                                data.wishlist_id = wishlist_popup_select.val();
                                data.wishlist_name = wishlist_popup_name.val();
                                data.wishlist_visibility = wishlist_popup_visibility.val();
                            }

                            if (!arexworks.helpers.is_cookie_enabled()) {
                                alert(yith_wcwl_l10n.labels.cookie_disabled);
                                return;
                            }

                            $.ajax({
                                type: 'POST',
                                url: yith_wcwl_l10n.ajax_url,
                                data: data,
                                dataType: 'json',
                                beforeSend: function () {
                                    if (arexworks.options.show_ajax_overlay) $overlay.show();
                                    $loading.show();
                                },
                                complete: function () {
                                    if (arexworks.options.show_ajax_overlay) $overlay.hide();
                                    $loading.hide();
                                },
                                success: function (response) {
                                    var msg = $('#yith-wcwl-popup-message'),
                                        response_result = response.result,
                                        response_message = response.message;

                                    if (yith_wcwl_l10n.multi_wishlist && yith_wcwl_l10n.is_user_logged_in) {
                                        var wishlist_select = $('select.wishlist-select');
                                        $.prettyPhoto.close();
                                        wishlist_select.each(function (index) {
                                            var t = $(this),
                                                wishlist_options = t.find('option');

                                            wishlist_options = wishlist_options.slice(1, wishlist_options.length - 1);
                                            wishlist_options.remove();

                                            if (typeof( response.user_wishlists ) != 'undefined') {
                                                var i = 0;
                                                for (i in response.user_wishlists) {
                                                    if (response.user_wishlists[i].is_default != "1") {
                                                        $('<option>')
                                                            .val(response.user_wishlists[i].ID)
                                                            .html(response.user_wishlists[i].wishlist_name)
                                                            .insertBefore(t.find('option:last-child'))
                                                    }
                                                }
                                            }
                                        });

                                    }
                                    var html = response_message;
                                    html += '<a class="view-popup-wishlish button" href="' + response.wishlist_url.replace('/view', '') + '">' + arexworks_global_message.wishlist.view + '</a>';
                                    arexworks.helpers.show_message(html);
                                    $('body').trigger('added_to_wishlist');
                                }

                            });
                        }
                    })
                } catch (ex){ log_js(ex); }

                /**
                 * Add to compare
                 */
                try {
                    $(document).on('click','.view-popup-compare', function(e){
                        e.preventDefault();
                        $('.reveal-modal').foundation('reveal', 'close');
                        $('body').trigger('yith_woocompare_open_popup', { response: arexworks.helpers.arw_add_query_arg('action', yith_woocompare.actionview) + '&iframe=true' });
                        get_message_box().hide();
                    });
                    $(document).on( 'click', '.product a.add_compare', function(e){
                        e.preventDefault();
                        var $button     = $(this),
                            $loading    = get_ajax_loading(),
                            $overlay    = get_overlay(),
                            widget_list = $('.yith-woocompare-widget ul.products-list'),
                            data        = {
                                action: yith_woocompare.actionadd,
                                id: $button.data('product_id'),
                                context: 'frontend'
                            },
                            product_name;

                        if($button.data('product_title') != ''){
                            product_name = $button.data('product_title');
                        }else{
                            product_name = $button.closest('.product').find('.product-title-link').first().text();
                        }
                        if (product_name == '') product_name = 'Product';

                        $.ajax({
                            type: 'post',
                            url: yith_woocompare.ajaxurl.toString().replace( '%%endpoint%%', yith_woocompare.actionadd ),
                            data: data,
                            dataType: 'json',
                            beforeSend: function(){
                                if(arexworks.options.show_ajax_overlay) $overlay.show();
                                $loading.show();
                            },
                            complete: function(){
                                if(arexworks.options.show_ajax_overlay) $overlay.hide();
                                $loading.hide();
                            },
                            success: function(response){
                                if( typeof $.fn.block != 'undefined' ) {
                                    widget_list.unblock()
                                }
                                var html = product_name + ' ' + arexworks_global_message.compare.success;
                                html += '<a class="button view-popup-compare" href="'+response.table_url+'">'+arexworks_global_message.compare.view+'</a>';
                                arexworks.helpers.show_message(html);
                                widget_list.html( response.widget_table );
                            }
                        });
                    });
                } catch (ex){ log_js(ex); }

                /**
                 * Quickview Product
                 */
                try {
                    $(document).on('click','.arexworks-quickview-button',function(e){
                        e.preventDefault();
                        var $button = $(this),
                            $loading = get_ajax_loading(),
                            $overlay = get_overlay();

                        $loading.show();
                        $overlay.show();
                        $('.arexworks-modal').foundation('reveal', 'open', {
                            url: $button.data('href'),
                            success: function(data) {
                                if (typeof arexworks.ProductZoom !== 'undefined') {
                                    setTimeout(function(){
                                        $('.arexworks-modal').trigger('rezize');
                                        arexworks.ProductZoom.initialize({
                                            images : '.arexworks-modal #main_product_single_image .main_product_single_image_slider',
                                            thumbnails : '.arexworks-modal #main_product_single_thumbnail_image .main_product_single_thumbnail_image_slider'
                                        });
                                    },500);
                                }
                                setTimeout(function(){
                                    if ( typeof wc_add_to_cart_variation_params !== 'undefined' ) {
                                        jQuery('.arexworks-modal .variations_form').wc_variation_form().find('.variations select:eq(0)').change();
                                    }
                                },500);
                                $loading.hide();
                                $overlay.hide();
                            },
                            error: function() {
                                alert(arexworks_global_message.global.error);
                                $loading.hide();
                                $overlay.hide();
                            }
                        });
                    });
                } catch (ex) { log_js(ex); }

                /**
                 * Custom Orderby
                 */
                $(document).on('change','.arexworks-woocommerce-toolbar select.per_page',function(){
                    var url = window.location.href;
                    url = url.replace(/page\/\d+\//gi,'');
                    $('.arexworks-woocommerce-toolbar select.per_page').removeAttr('name');
                    $(this).attr('name','per_page');
                    $(this).closest('.woocommerce-ordering').attr('action',url);
                });


                /**
                 * Quantity
                 */
                $(document)
                    .on('click','.quantity .desc-qty',function(e){
                        e.preventDefault();
                        var $qty = $(this).closest('.quantity').find('.qty'),
                            min_val = 0,
                            max_val = 0,
                            default_val = 1,
                            old_val = parseInt($qty.val());
                        if( $qty.attr('min') )  min_val = parseInt( $qty.attr('min') );
                        if( $qty.attr('max') )  max_val = parseInt( $qty.attr('max') );
                        if( min_val ) default_val = min_val;
                        if( max_val > 0 ) default_val = max_val;
                        if( max_val ){
                            $qty.val( (old_val && max_val > old_val) ? old_val + 1 : default_val);
                        }else{
                            $qty.val( (old_val) ? old_val + 1 : default_val);
                        }
                    })
                    .on('click','.quantity .inc-qty',function(e){
                        e.preventDefault();
                        var $qty = $(this).closest('.quantity').find('.qty'),
                            min_val = 0,
                            old_val = parseInt($qty.val());
                        if( $qty.attr('min') )  min_val = parseInt( $qty.attr('min') );
                        $qty.val((old_val > 0 && old_val > min_val) ? old_val - 1 : min_val);
                    });

                try {
                    $('.variations_form.cart .variations td.label').addClass('open');
                    $(document).on( 'click', '.variations_form.cart .variations td.label', function(e){
                        e.preventDefault();
                        $(this).toggleClass('open');
                    });
                    $(document).on( 'show_variation', '.variations_form .single_variation_wrap', function( event, variation ) {
                        if ( variation.image_link ){
                            var $parent = $(this).closest('.product.type-product');
                            var $_target = $parent.find('.product-image-main [href="' + variation.image_link + '"]' );
                            if ( $_target.length > 0 ){
                                $parent.find('.main_product_single_image_slider').eq(0).slick('slickGoTo',$_target.parent().data('slick-index'),false);
                            }
                        }
                    } )
                } catch ( ex ) { log_js( ex ); }

                /**
                 * Product List 2 image handler click
                 */
                try {
                    $('.product-item-info .product_actions_images').each(function(){
                        $(this).find('a').eq(0).addClass('active');
                    });
                    $(document).on('click','.product-item-info .product_actions_images a',function(e){
                        e.preventDefault();
                        var $this = $(this);
                        var $parent = $this.closest('li.product');
                        var $image_rel = $parent.find('img.attachment-shop_catalog_large');
                        $parent.find('.product_images_wrapper').addClass('waitting-image-load');
                        $parent.find('.product-item-info .product_actions_images a').removeClass('active');
                        var $image = $('<img />');
                        $image.attr( 'src', $this.attr('href') );
                        imagesLoaded( $image, function() {
                            $parent.find('.product_images_wrapper').removeClass('waitting-image-load');
                            $image_rel.attr('src',$this.attr('href'));
                            $this.addClass('active');
                        });
                    });
                } catch ( ex ) { log_js( ex ) ;}

                /**
                 * Wooecommer Tabs
                 * */
                try {
                    $(window).load(function(){
                        var comment_id = window.location.hash.split('|');
                        var $comment_elm = $(comment_id[0]);
                        if($comment_elm.length > 0){
                            $('#woocommerce-tabs li.reviews_tab').trigger('click');
                            $('body,html').animate({
                                scrollTop:$comment_elm.offset().top
                            },800);
                        }
                    });
                    $(document).on('click','.single-product .woocommerce-review-link',function(e){
                        e.preventDefault();
                        $('#woocommerce-tabs li.reviews_tab').trigger('click');
                        $('body,html').animate({
                            scrollTop:$('#woocommerce-tabs #comments').offset().top
                        },800);
                    });
                    $("#woocommerce-tabs .resp-tab-content").hide();
                    $("#woocommerce-tabs").easyResponsiveTabs({
                        type: 'default', //Types: default, vertical, accordion
                        width: 'auto', //auto or any custom width
                        fit: true,   // 100% fits in a container
                        tabidentify:'detail_tab_1',
                        closed: 'accordion', // Close the panels on start, the options 'accordion' and 'tabs' keep them closed in there respective view types
                        activetab_bg: '', // background color for active tabs in this group
                        inactive_bg: '', // background color for inactive tabs in this group
                        active_border_color: '', // border color for active tabs heads in this group
                        active_content_border_color: '' // border color for active tabs contect in this group so that it matches the tab head border
                    });
                }
                catch (ex){
                    log_js(ex);
                }

                return self;
            }
        }
    });

    // Ultimate_VC_Addons
    $.extend(arexworks, {
        Ultimate_VC_Addons : {
            initialize : function(){
                var self = this;

                self.reset()
                    .build()
                    .events();

                return self;
            },

            build : function(){
                var self = this;

                /*
                 Fix interactive_banner_2
                 */
                try {
                    $('.ult-new-ib-desc').wrapInner("<div class='ult-new-ib-desc-inner'><div class='ult-new-ib-desc-inner2'></div></div>");
                }catch ( ex ) { log_js( ex ); }

                /**
                 * Slick for testimonial
                 */
                setTimeout(function(){
                    $('.testimonial-slide-special-1 .slick-slider').each(function(){
                        var $slick = $(this);
                        var $slick_items = $slick.find('.slick-slide');

                        $slick_items.each(function(){
                            var $prev = $(this).prev('.slick-slide').length ? $(this).prev('.slick-slide') : $slick_items.last(),
                                $next = $(this).next('.slick-slide').length ? $(this).next('.slick-slide') : $slick_items.first(),
                                $img_prev = $prev.find('img.testimonial-author-thumbnail').clone().removeClass('testimonial-author-thumbnail').addClass('testimonial-author-thumbnail-clone clone-prev').attr('data-slick-index',$prev.attr('data-slick-index')),
                                $img_next = $next.find('img.testimonial-author-thumbnail').clone().removeClass('testimonial-author-thumbnail').addClass('testimonial-author-thumbnail-clone clone-next').attr('data-slick-index',$next.attr('data-slick-index'));

                            var $wrapper = $(this).find('.testimonial-author-thumbnail-wrapper');
                            $img_prev.prependTo($wrapper);
                            $img_next.appendTo($wrapper);
                        });
                    });
                },600);

                /**
                 * Tabs Shortcode Fix
                 * */
                try{
                    $('.vc_tta-container .vc_tta-tabs-container').each(function(){
                        $('<div class="slider-tab-toggle"><span><span></span></span></div><div class="clear"></div>').prependTo($(this));
                    });
                    setTimeout(function(){
                        $('.vc_tta-container .vc_tta-tabs-list').each(function(){
                            var $new_control = $(this).closest('.vc_tta-tabs-container').find('.slider-tab-toggle');
                            if($(this).children('li').length > 1){
                                $new_control.addClass('has-trigger');
                            }
                            $new_control.find('span span').html($(this).children('li.vc_active').text());
                        });
                    },200);
                    $(document).on('click','.slider-tab-toggle.has-trigger',function(){
                        $(this).toggleClass('open-tab');
                    });
                    /**/
                    $( document ).on( 'click.vc.tabs.data-api', '[data-vc-tabs]', function(e){
                        var $this, plugin_tabs, $slick_slider, $selector;
                        $this = $( this );
                        plugin_tabs = $this.data('vc.tabs');
                        $selector = $( plugin_tabs.getSelector() );
                        $slick_slider = $selector.find('.slick-slider');
                        e.preventDefault();
                        //plugin_tabs.$container.css('min-height',plugin_tabs.$container.innerHeight());
                        plugin_tabs.$container.find('.slider-tab-toggle').removeClass('open-tab').find('span span').html($this.text());
                        if( $slick_slider.length > 0 ){
                            $slick_slider.css('opacity','0').slick("setPosition").css('opacity','1');
                        }

                    } );
                    /**/
                }
                catch (ex){
                    log_js(ex);
                }
                return self;
            },
            reset : function(){
                var self = this;

                return self;
            },
            events : function(){
                var self = this;

                /**
                 * Slick for testimonial
                 */
                $(document).on( 'click', '.testimonial-slide-special-1 .slick-slider img.testimonial-author-thumbnail-clone', function( e ){
                    e.preventDefault();
                    var $slick = $(this).closest('.slick-slider'),
                        idx =  parseInt($(this).attr('data-slick-index'));
                    $slick.removeClass('running running-right-to-left running-left-to-right');

                    $slick.slick( 'slickGoTo', idx, true );

                    if($(this).hasClass('clone-prev')){
                        $slick.addClass('running running-left-to-right');
                    }else{
                        $slick.addClass('running running-right-to-left');
                    }
                } );

                $(document).on('click','.vc_toggle .vc_toggle_title',function(e){
                    e.preventDefault();
                    var $toggle = $(this).closest('.vc_toggle'),
                        $panel = $toggle.closest('.vc_tta-panel-body'),
                        id = $toggle.attr('id');
                    if($panel.length > 0){
                        $panel.find('.vc_toggle_active:not(#'+ id +') .vc_toggle_title').trigger('click');
                    }
                });

                return self;
            }
        }
    });

    // Isotope
    $.extend(arexworks, {
        Isotope: {
            defaults: {
                elements: null,
                itemSelector: null,
                callback: null
            },

            initialize: function($elements, itemSelector, callback) {
                this.$elements = ($elements || this.defaults.elements);
                this.itemSelector = (itemSelector || this.defaults.itemSelector);
                this.callback = (callback || this.defaults.callback);

                this.build();

                return this;
            },

            build: function() {
                var self = this;
                var itemSelector = self.itemSelector;
                var callback = self.callback;

                if (self.$elements && self.$elements.length && self.itemSelector) {
                    self.$elements.each(function() {
                        var $this = $(this);
                        var data_isotope = ( $this.data('config_isotope') || {} );
                        if ($().isotope) {
                            $this.find('.arexworks-isotope-loading').show();
                            $this.imagesLoaded(function() {
                                $this.isotope(
                                    $.extend({
                                        itemSelector : itemSelector
                                    },data_isotope)
                                ).isotope('layout').find('.arexworks-isotope-loading').hide();
                                if (callback)
                                    $this.isotope('on', 'layoutComplete', callback);
                            });
                        }
                    });
                }

                return self;
            }
        }
    });

    // Isotope Filter
    $.extend(arexworks, {
        IsotopeFilter : {

            defaults: {
                elements: null,
                options: null
            },

            initialize: function($elements,options) {
                this.$elements = ($elements || this.defaults.elements);
                this.options = (options || this.defaults.options);

                this.build();

                return this;
            },

            build: function() {
                var self = this;
                if (self.$elements && self.$elements.length) {
                    self.$elements.each(function () {
                        var $this = $(this);
                        var $isotope = $($this.data('isotope_container'));

                        $this.find('li').on('click', function (e) {
                            e.preventDefault();

                            var selector = $(this).attr('data-filter');
                            $this.find('.active').removeClass('active');

                            if (selector != '*')
                                selector = '.' + selector;
                            if ($isotope){
                                $isotope.isotope(
                                    $.extend(self.options,{
                                        filter: selector
                                    })
                                );
                            }
                            $(this).addClass('active');
                        });
                    });
                }

                return self;
            }
        }
    })

}).apply(this, [window.arexworks, jQuery]);

(function(arexworks, $) {
    "use strict";

    $(document).foundation({
        reveal : {
            animation : 'fade'
        },
        dropdown: {
            opened : function () {
                var $this = jQuery(this);
                $this.removeClass('animated fadeOutDown').addClass('animated fadeInUp');
            },
            closed : function () {
                var $this = jQuery(this);
                $this.removeClass('animated fadeInUp').addClass('animated fadeOutDown');
                setTimeout(function(){
                    $this.removeClass('animated fadeOutDown');
                },200);
            }
        }
    });

    function arexworks_init(){

        if (typeof arexworks.DefaultExtend !== 'undefined') {
            arexworks.DefaultExtend.initialize();
        }

        // Mega Menu
        if (typeof arexworks.MegaMenu !== 'undefined') {
            arexworks.MegaMenu.initialize();
        }

        // Mega Menu
        if (typeof arexworks.AccordionMenu !== 'undefined') {
            arexworks.AccordionMenu.initialize();
        }

        // Sticky Header
        if (typeof arexworks.StickyHeader !== 'undefined') {
            arexworks.StickyHeader.initialize();
        }

        // Override WooEcommerce
        if (typeof arexworks.WooEcommerce !== 'undefined') {
            arexworks.WooEcommerce.initialize();
        }

        // Product Zoom
        if (typeof arexworks.ProductZoom !== 'undefined') {
            arexworks.ProductZoom.initialize();
        }

        // Scroll to Top
        if (typeof arexworks.ScrollToTop !== 'undefined') {
            arexworks.ScrollToTop.initialize();
        }

        // Ultimate_VC_Addons
        if (typeof arexworks.Ultimate_VC_Addons !== 'undefined') {
            arexworks.Ultimate_VC_Addons.initialize();
        }

        // Blog Isotope
        if (typeof arexworks.Isotope !== 'undefined') {
            arexworks.Isotope.initialize( $('.arexworks-isotope .arexworks-isotope-container'), '.post' );
        }
        // Blog Isotope Filter
        if (typeof arexworks.IsotopeFilter !== 'undefined') {
            arexworks.IsotopeFilter.initialize( $('.isotope-filter-wrapper') );
        }

        // Post infinite
        if (typeof arexworks.PostsInfinite !== 'undefined') {
            arexworks.PostsInfinite.initialize();
        }

        // Portfolios infinite
        if (typeof arexworks.PortfoliosInfinite !== 'undefined') {
            arexworks.PortfoliosInfinite.initialize();
        }

        // Comment infinite
        if (typeof arexworks.CommentsInfinite !== 'undefined') {
            arexworks.CommentsInfinite.initialize();
        }

        // Products infinite
        if (typeof arexworks.ProductsInfinite !== 'undefined') {
            arexworks.ProductsInfinite.initialize();
        }
        $('.slick-slider').trigger('resize');
        setTimeout(function(){
            $('.slick-slider').trigger('resize');
        },200);

    }
    $(document).ready(function() {
        arexworks_init();
        $(window).on('vc_reload', function() {
            arexworks_init();
        });
    });

}).apply(this, [window.arexworks, jQuery]);

(function($) {
    'use strict';

    $( 'form.variations_form').on('wc_additional_variation_images_frontend_ajax_response_callback', function(e , response){

        var $main_img = $('.main_product_single_image_slider'),
            $gal_img = $('.main_product_single_thumbnail_image_slider'),
            $main_images_response = $(response.main_images),
            $gallery_images_response = $(response.gallery_images),
            tmp1 = '',
            tmp2 = '';

        $main_images_response.each(function(){
            var div = $('<div/>');
            div.append($(this));
            tmp1 += '<div class="product-image-main">';
            tmp1 += div.html();
            tmp1 += '</div>';
        });

        $gallery_images_response.each(function(){
            tmp2 += '<div class="thumbnail-images"><div>';
            tmp2 += $(this).html();
            tmp2 += '</div></div>';
        });


        if(tmp1 && tmp2){
            $main_img.slick('unslick');
            $gal_img.slick('unslick');
            $main_img.html(tmp1);
            $gal_img.html(tmp2);
            arexworks.ProductZoom.initialize();
        }

    });


    $(document).ready(function(){
        function fixMenuHeader4(){
            if($('body').is('.header-layout-4')){
                var $menu = $('.header-wrapper .mega-menu-sidebar .main-menu-wrap');
                if($(window).height() > $menu.innerHeight()){
                    $menu.css({
                        'margin-top' : parseInt( ($(window).height() - $menu.innerHeight()) / 2 )
                    });
                }else{
                    $menu.css({
                        'margin-top': 0
                    });
                }
            }
        }
        fixMenuHeader4();

        $(window).scroll(function(){
            if($('body').is('.header-layout-4')){
                var scroll_top = $(window).scrollTop(),
                    $menu = $('.header-wrapper .mega-menu-sidebar .main-menu-wrap');
                if($('#header').is('.active-sticky')){
                    $('.header-wrapper').css('position','static');
                    $menu.css({
                        'margin-top' : 0,
                        'top': scroll_top + parseInt( ($(window).height() - $menu.innerHeight()) / 4 )
                    })
                }else{
                    $('.header-wrapper').removeAttr('style');
                    $menu.css({
                        'margin-top' : parseInt( ($(window).height() - $menu.innerHeight()) / 3 ),
                        'top': 0
                    })
                }
            }
        });

        function fixBannerTitle(){
            var body_font_size = parseInt($('body').css('font-size').match(/\d+/gi));
            $('.ult-new-ib-title,.ult-new-ib-content').each(function(){
                var random_class = 'ult-new-ib-title-' + arexworks_generate_rand(),
                    prefix = $(this).css('font-size').replace(/\d+/gi,''),
                    this_font_size = parseInt($(this).css('font-size').match(/\d+/gi)),
                    md_size = (this_font_size / 992) * 800,
                    xs_size = (this_font_size / 992) * 500,
                    style_html = '';
                $(this).addClass(random_class);

                style_html += '@media only screen and ( max-width:992px ) and ( min-width:768px ){';
                style_html += '.' + random_class + '{';
                style_html += 'font-size:' + (md_size > body_font_size ? md_size : parseInt(body_font_size + 2) ) + prefix +' !important;';
                style_html += '}';
                style_html += '}';
                style_html += '@media only screen and ( max-width:768px ){';
                style_html += '.' + random_class + '{';
                style_html += 'font-size:' + (xs_size > body_font_size ? xs_size : parseInt(body_font_size + 2) ) + prefix + ' !important;';
                style_html += '}';
                style_html += '}';
                addStyleSheet(style_html);
            });
        }
        fixBannerTitle();


        if(arexworks.helpers.is_touch_device()){
            var elements = '.arexworks-block-banner a';
            $(document).on('click',elements,function(e){
                if(!$(this).hasClass('click-go-go')){
                    e.preventDefault();
                    $(this).addClass('click-go-go');
                }
            });
            $('.products .product_link').each(function(){
                $(this).closest('.product_images_wrapper').addClass('is_touch_devices');
            })
        }

        try{
            var show_popup = false;
            if($.cookie('leka_disable_popup')){
                show_popup = false;
            }else{
                show_popup = true;
            }
            if($(window).innerWidth() < 768){
                show_popup = false;
            }
            if($('#arw_window_popup').length  && show_popup){
                setTimeout(function(){
                    $.fancybox({
                        type        : 'inline',
                        href        : '#arw_window_popup',
                        maxWidth	: 650,
                        maxHeight	: 300,
                        padding     : 0,
                        fitToView	: false,
                        width		: '90%',
                        height		: '70%',
                        autoSize	: false,
                        closeClick	: false,
                        openSpeed   : 350,
                        tpl         : {
                            wrap        : '<div class="fancybox-wrap wrap-arw-popup-inline" tabIndex="-1"><div class="fancybox-skin"><div class="fancybox-outer"><div class="fancybox-inner"></div></div></div></div>'
                        },
                        beforeClose : function(){
                            if($('#arw_window_popup #arw_dont_show_popup').length > 0 && $('#arw_window_popup #arw_dont_show_popup').is(':checked') && $.cookie('leka_disable_popup') != 'yes'){
                                $.cookie('leka_disable_popup', 'yes', { expires: 7 });
                            }
                        }
                    });
                },1000);
            }
        }catch (ex){}
    });
})(jQuery);