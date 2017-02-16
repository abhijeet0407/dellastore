;var file_frame;
(function($) {
    "use strict";

    $(document).ready(function(){
        $('#arexworks_theme_options-section_documentation_row a').attr('target','_blank');
        $(document)
            // Upload Single Image
            .on( 'click', '.button_upload_image', function( event ){

                event.preventDefault();

                // If the media frame already exists, reopen it.
                if ( file_frame ) {
                    file_frame.open();
                    return;
                }

                var clickedID = $(this).attr('data-id');

                // Create the media frame.
                file_frame = wp.media.frames.downloadable_file = wp.media({
                    title: 'Choose an image',
                    button: {
                        text: 'Use image'
                    },
                    multiple: false
                });

                // When an image is selected, run a callback.
                file_frame.on( 'select', function() {
                    var attachment = file_frame.state().get('selection').first().toJSON();
                    $('#' + clickedID).val( attachment.url );
                    if ($('#' + clickedID).attr('data-name'))
                        $('#' + clickedID).attr('name', jQuery('#' + clickedID).attr('data-name'));
                });

                // Finally, open the modal.
                file_frame.open();
            })
            // Upload Multi image
            .on( 'click', '.button_upload_gallery', function( event ) {
                var $el = $( this),
                    $gallery_ids = $('#' + $el.data('id')),
                    $preview = $el.closest('.gallery-field').find('.gallery-preview');

                event.preventDefault();

                if ( file_frame ) {
                    file_frame.open();
                    return;
                }
                // Create the media frame.
                file_frame = wp.media.frames.product_gallery = wp.media({
                    // Set the title of the modal.
                    title: 'Add Images to Gallery',
                    button: {
                        text: 'Add to gallery'
                    },
                    states: [
                        new wp.media.controller.Library({
                            title: 'Add Images to Gallery',
                            filterable: 'all',
                            multiple: true
                        })
                    ]
                });

                // When an image is selected, run a callback.
                file_frame.on( 'select', function() {
                    var selection = file_frame.state().get( 'selection' );
                    var attachment_ids = $gallery_ids.val();

                    selection.map( function( attachment ) {
                        attachment = attachment.toJSON();

                        if ( attachment.id ) {
                            attachment_ids   = attachment_ids ? attachment_ids + ',' + attachment.id : attachment.id;
                            var attachment_image = attachment.sizes && attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url;

                            $preview.append( '<div class="arexworks-image" data-attachment_id="' + attachment.id + '"><img src="' + attachment_image + '" /><a href="#" class="delete" title="' + 'Delete image' + '">' + 'Delete' + '</a></div>' );
                        }
                    });

                    $gallery_ids.val( attachment_ids );
                });

                // Finally, open the modal.
                file_frame.open();
            } )
            .on( 'click', '.arexworks-image .delete', function(e){
                e.preventDefault();
                var $parent = $(this).closest('.gallery-field');
                var $image_gallery_ids = $('#' + $parent.find('.button').data('id'));
                var attachment_ids = '';
                $( this ).closest( 'div.arexworks-image' ).remove();
                $parent.find( 'div.arexworks-image' ).css( 'cursor', 'default' ).each( function() {
                    var attachment_id = $( this ).attr( 'data-attachment_id' );
                    attachment_ids = attachment_ids + attachment_id + ',';
                });
                $image_gallery_ids.val( attachment_ids.replace(/,+$/,'') );

            })
            // Remove Single Image
            .on( 'click', '.button_remove_image', function( event ){

                var clickedID = $(this).attr('data-id');
                $('#' + clickedID).val( '' );

                return false;
            });

        try {
            $('.box-option .gallery-field .gallery-preview').sortable({
                items: 'div.arexworks-image',
                cursor: 'move',
                scrollSensitivity: 40,
                forcePlaceholderSize: true,
                forceHelperSize: false,
                helper: 'clone',
                opacity: 0.65,
                placeholder: 'arexworks-metabox-sortable-placeholder',
                start: function( event, ui ) {
                    ui.item.css( 'background-color', '#f6f6f6' );
                },
                stop: function( event, ui ) {
                    ui.item.removeAttr( 'style' );
                },
                update: function( event, ui ) {
                    var $preview = $(event.target),
                        $gallery_ids = $('#' + $preview.closest('.gallery-field').find('.button').data('id')),
                        attachment_ids = '';

                    $preview.find( 'div.arexworks-image' ).css( 'cursor', 'default' ).each( function() {
                        var attachment_id = $( this ).attr( 'data-attachment_id' );
                        attachment_ids = attachment_ids + attachment_id + ',';
                    });

                    $gallery_ids.val( attachment_ids );
                }
            });
        }catch (ex){}

        $('.label-image-select input').on('change',function(){
            var $label_parent = $(this).parent().parent();
            $label_parent.find('.label-image-select').removeClass('selected');
            if($(this).is(':checked')){
                $(this).closest('.label-image-select').addClass('selected');
            }
        });

        function updateMegaMenuOptions(elem, shift) {
            var current_elem = elem;
            var depth_shift = shift;
            var classNames = current_elem.attr('class').split(' ');

            for (var i = 0; i < classNames.length; i+=1) {
                if (classNames[i].indexOf('menu-item-depth-') >= 0) {
                    var depth = classNames[i].split('menu-item-depth-');
                    var id = current_elem.attr('id');

                    depth = parseInt(depth[1]) + depth_shift;
                    id = id.replace('menu-item-', '');

                    if (depth == 0) {
                        current_elem.find('.edit-menu-item-level1-' + id).hide().find('select, input, textarea').each(function() {
                            $(this).removeAttr('name');
                        });
                        current_elem.find('.edit-menu-item-level0-'+id).show().find('select, input[type="text"], textarea').each(function() {
                            if ($(this).val()) {
                                $(this).attr('name', $(this).attr('data-name'));
                            } else {
                                $(this).removeAttr('name');
                            }
                        });
                        current_elem.find('.edit-menu-item-level0-'+id).find('input[type="checkbox"]').each(function() {
                            if ($(this).is(':checked')) {
                                $(this).attr('name', $(this).attr('data-name'));
                            } else {
                                $(this).removeAttr('name');
                            }
                        });
                        current_elem.find('.edit-menu-item-level01-'+id).show().find('select, input[type="text"], textarea').each(function() {
                            if ($(this).val()) {
                                $(this).attr('name', $(this).attr('data-name'));
                            } else {
                                $(this).removeAttr('name');
                            }
                        });
                        current_elem.find('.edit-menu-item-level01-'+id).find('input[type="checkbox"]').each(function() {
                            if ($(this).is(':checked')) {
                                $(this).attr('name', $(this).attr('data-name'));
                            } else {
                                $(this).removeAttr('name');
                            }
                        });
                    } else if (depth == 1) {
                        current_elem.find('.edit-menu-item-level0-' + id).hide().find('select, input, textarea').each(function() {
                            $(this).removeAttr('name');
                        });
                        current_elem.find('.edit-menu-item-level1-'+id).show().find('select, input[type="text"], textarea').each(function() {
                            if ($(this).val()) {
                                $(this).attr('name', $(this).attr('data-name'));
                            } else {
                                $(this).removeAttr('name');
                            }
                        });
                        current_elem.find('.edit-menu-item-level1-'+id).find('input[type="checkbox"]').each(function() {
                            if ($(this).is(':checked')) {
                                $(this).attr('name', $(this).attr('data-name'));
                            } else {
                                $(this).removeAttr('name');
                            }
                        });
                        current_elem.find('.edit-menu-item-level01-'+id).show().find('select, input[type="text"], textarea').each(function() {
                            if ($(this).val()) {
                                $(this).attr('name', $(this).attr('data-name'));
                            } else {
                                $(this).removeAttr('name');
                            }
                        });
                        current_elem.find('.edit-menu-item-level01-'+id).find('input[type="checkbox"]').each(function() {
                            if ($(this).is(':checked')) {
                                $(this).attr('name', $(this).attr('data-name'));
                            } else {
                                $(this).removeAttr('name');
                            }
                        });
                    } else {
                        current_elem.find('.edit-menu-item-level0-'+id).hide().find('select, input, textarea').each(function() {
                            $(this).removeAttr('name');
                        });
                        current_elem.find('.edit-menu-item-level1-'+id).hide().find('select, input, textarea').each(function() {
                            $(this).removeAttr('name');
                        });
                        current_elem.find('.edit-menu-item-level01-'+id).hide().find('select, input, textarea').each(function() {
                            $(this).removeAttr('name');
                        });
                    }
                }
            }
        }

        $(document).on('change', '.menu-item select, .menu-item textarea, .menu-item input[type="text"]', function() {
            var that = $(this),
            value = that.val();
            if (value) {
                that.attr('name', $(this).attr('data-name'));
            } else {
                that.removeAttr('name');
            }
        });

        $(document).on('change', '.menu-item input[type="checkbox"]', function() {
            var that = $(this),
            value = that.is(':checked');
            if (value) {
                that.attr('name', $(this).attr('data-name'));
            } else {
                that.removeAttr('name');
            }
        });

        $('#update-nav-menu').on('click', function(e) {
            if ( e.target && e.target.className ) {
                if ( -1 != e.target.className.indexOf('item-delete') ) {
                    var clickedEl = e.target;
                    var itemID = parseInt(clickedEl.id.replace('delete-', ''), 10);
                    var menu_item = $('#menu-item-' + itemID);
                    var children = menu_item.childMenuItems();
                    children.each(function() {
                        updateMegaMenuOptions($(this), -1);
                    });
                }
            }
        });

        $( "#menu-to-edit" ).on( "sortstop", function( event, ui ) {
            var menu_item = ui.item;
            setTimeout(function() {
                updateMegaMenuOptions(menu_item, 0);
                var children = menu_item.childMenuItems();
                children.each(function() {
                    updateMegaMenuOptions($(this), 0);
                })
            }, 200);
        } );
    })

})(jQuery);