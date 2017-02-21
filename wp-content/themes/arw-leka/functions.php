<?php
/**
 * Define variables
 */
 
@ini_set( 'upload_max_size' , '64M' );
@ini_set( 'post_max_size', '64M');
@ini_set( 'max_execution_time', '300' );

defined( 'arexworks_theme_dir' )        or   define( 'arexworks_theme_dir',          get_template_directory() );
defined( 'arexworks_theme_uri' )        or   define( 'arexworks_theme_uri',          get_template_directory_uri() );
defined( 'arexworks_include_dir' )      or   define( 'arexworks_include_dir',        arexworks_theme_dir . '/includes' );
defined( 'arexworks_lib_plugin_dir' )   or   define( 'arexworks_lib_plugin_dir',     arexworks_include_dir . '/plugins' );
defined( 'arexworks_function_dir' )     or   define( 'arexworks_function_dir',       arexworks_include_dir . '/functions' );
defined( 'arexworks_metabox_dir' )      or   define( 'arexworks_metabox_dir',        arexworks_include_dir . '/metaboxes' );
defined( 'arexworks_js' )               or   define( 'arexworks_js',                 arexworks_theme_uri  . '/assets/js' );
defined( 'arexworks_css' )              or   define( 'arexworks_css',                arexworks_theme_uri . '/assets/css' );
defined( 'arexworks_image' )            or   define( 'arexworks_image',              arexworks_theme_uri . '/assets/images' );
defined( 'arexworks_demo_data' )        or   define( 'arexworks_demo_data',          arexworks_include_dir . '/demo-data' );
defined( 'arexworks_options_preset' )   or   define( 'arexworks_options_preset',     arexworks_include_dir . '/presets' );
defined( 'arexworks_theme_version' )    or   define( 'arexworks_theme_version',      wp_get_theme()->get('Version') );

include_once( trailingslashit(arexworks_include_dir) . 'lib/aq_resize.1x.php');
include_once( trailingslashit(arexworks_include_dir) . 'lib/arexworks_mega_menu.php');

require_once( trailingslashit(arexworks_lib_plugin_dir) . 'tgm_plugin_activation.php');
require_once( trailingslashit(arexworks_lib_plugin_dir) . 'plugins.php');

// include redux framework core functions
if ( !class_exists( 'ReduxFramework' ) ) {

	if ( file_exists( trailingslashit(arexworks_lib_plugin_dir) . 'redux-framework/ReduxCore/framework.php' ) ){
		require_once( trailingslashit(arexworks_lib_plugin_dir) . 'redux-framework/ReduxCore/framework.php' );
	}
	else{
		add_action( 'admin_notices', 'arexworks_add_admin_notices_for_redux_not_install' );
		function arexworks_add_admin_notices_for_redux_not_install(){
			?>
			<div class="error">
				<p><?php echo wp_kses(
						__( 'Please install Plugin <a href="//wordpress.org/plugins/redux-framework/" target="_blank">Redux Framework</a>',
						            'arw-leka'
						),
						array(
							'a' => array(
								'href' => array(),
								'target' => array()
							),
						));
					?></p>
			</div>
		<?php
		}
	}
}
include_once( trailingslashit(arexworks_include_dir) . 'admin/functions.php' );
include_once( trailingslashit(arexworks_include_dir) . 'admin/settings.php' );


/**
 * Load Metabox
*/
include_once( trailingslashit(arexworks_include_dir) . 'lib/metaboxes.php');
include_once( trailingslashit(arexworks_metabox_dir) . 'functions.php' );
include_once( trailingslashit(arexworks_metabox_dir) . 'page.php' );
include_once( trailingslashit(arexworks_metabox_dir) . 'post.php' );

include_once( trailingslashit(arexworks_metabox_dir) . 'portfolio.php' );
include_once( trailingslashit(arexworks_metabox_dir) . 'portfolio_category.php' );
include_once( trailingslashit(arexworks_metabox_dir) . 'portfolio_skill.php' );

include_once( trailingslashit(arexworks_metabox_dir) . 'product.php' );
include_once( trailingslashit(arexworks_metabox_dir) . 'product_cat.php' );

/**
 * Load Theme function
 */
include_once( trailingslashit(arexworks_function_dir) . 'general.php');
include_once( trailingslashit(arexworks_function_dir) . 'shortcodes.php');
include_once( trailingslashit(arexworks_function_dir) . 'formatting.php');
include_once( trailingslashit(arexworks_function_dir) . 'widgets.php');
include_once( trailingslashit(arexworks_function_dir) . 'post.php');
if(function_exists( 'WC' )){
	include_once( trailingslashit(arexworks_function_dir) . 'woocommerce.php');
}
include_once( trailingslashit(arexworks_function_dir) . 'layout/page-title.php');
include_once( trailingslashit(arexworks_function_dir) . 'layout/breadcrumbs.php');
include_once( trailingslashit(arexworks_function_dir) . 'layout.php');
include_once( trailingslashit(arexworks_function_dir) . 'extra.php');


/**
 * Theme support & Theme setup
 */
if ( ! isset( $content_width ) ) {
	$content_width = 1170;
}

if ( !function_exists( 'arexworks_add_action_after_setup_theme' ) ){

	add_action( 'after_setup_theme', 'arexworks_add_action_after_setup_theme' );
	function arexworks_add_action_after_setup_theme(){

		load_theme_textdomain( 'arw-leka', trailingslashit(arexworks_theme_dir) . 'languages' );
		load_child_theme_textdomain( 'arw-leka', trailingslashit(get_stylesheet_directory()) . 'languages' );


		// woocommerce support
		add_theme_support( 'woocommerce');
		if(defined('WOOCOMMERCE_VERSION')){
			if(version_compare( WOOCOMMERCE_VERSION, "2.1" ) >= 0){
				add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
			} else {
				define( 'WOOCOMMERCE_USE_CSS', false );
			}
		}
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'custom-header' );
		add_theme_support( 'custom-background' );

		// add support for post thumbnails
		add_theme_support( 'post-thumbnails' );
		// add post formats
		add_theme_support( 'post-formats', array(
			'quote',
			'image',
			'video',
			'link',
			'audio'
		) );

		// add image sizes
		set_post_thumbnail_size( 370 , 260 , array( 'center', 'center'));
		// register menus
		add_theme_support( 'menus' );
		register_nav_menus( array(
            'top-bar-navigation'    => esc_attr__( 'Top Bar Navigation', 'arw-leka' ),
            'main-navigation'       => esc_attr__( 'Main Navigation', 'arw-leka' )
        ) );
	}
}

/**
 * Enqueue css, js files
 */

if ( !function_exists( 'arexworks_add_action_wp_enqueue_scripts' ) ){
	add_action( 'wp_enqueue_scripts', 'arexworks_add_action_wp_enqueue_scripts', 9999 );
	function arexworks_add_action_wp_enqueue_scripts(){
		$handles_style_remove = array(
			'yith-woocompare-widget',
			'woocommerce_prettyPhoto_css',
			'yith-wcwl-font-awesome',
			'woocomposer-front-slick',
			'jquery-colorbox',
			'font-awesome'
		);
		$handles_script_remove = array(
			'woocomposer-slick',
			'prettyPhoto',
			'prettyPhoto-init'
		);
		foreach ($handles_style_remove as $style) {
			if ( wp_style_is( $style, $list = 'registered' ) ) {
				wp_deregister_style( $style );
			}
		}
		foreach ($handles_script_remove as $script) {
			if ( wp_script_is( $script, $list = 'enqueued' ) ) {
				wp_dequeue_script( $script );
			}
		}

		/*
		 * Stylesheet
		 */
		if(wp_style_is('js_composer_front','registered')){
			wp_enqueue_style('js_composer_front');
		}
		wp_enqueue_style('arexworks-foundation', trailingslashit(arexworks_css).'foundation.css', array(), '5.0', 'all' );
		wp_enqueue_style('arexworks-wordpress-stylesheet', get_stylesheet_uri() );
		wp_enqueue_style('arexworks-theme-stylesheet', trailingslashit( arexworks_css ) . 'theme.css', array(), arexworks_theme_version, 'all');
		if(function_exists('WC')){
			wp_enqueue_style('arexworks-theme-ecommerce', trailingslashit( arexworks_css ) . 'ecommerce.css', array(), arexworks_theme_version, 'all');
		}
		wp_enqueue_style('arexworks-theme-responsive', trailingslashit( arexworks_css ) . 'responsive.css', array(), arexworks_theme_version, 'all');

		if ( arexworks_get_option_data('font_source',false) == "2" && ($font_google_code = arexworks_get_option_data('font_google_code',false)) ) {
			wp_enqueue_style('arexworks-font_google_code', esc_url($font_google_code), array(), arexworks_theme_version, 'all' );
		}

		/*
		 * Scripts
		 */
		if ( arexworks_get_option_data('font_source',false) == "3" && ($font_typekit_kit_id = arexworks_get_option_data('font_typekit_kit_id',false)) ) {
			wp_enqueue_script('arexworks-font_typekit', esc_url('//use.typekit.net/' . $font_typekit_kit_id .'.js'), array(), NULL, FALSE );
			wp_enqueue_script('arexworks-font_typekit_exec', trailingslashit(arexworks_js) . 'typekit.js', array(), NULL, FALSE );
		}
		wp_enqueue_script( 'arexworks-jquery-plugins', trailingslashit(arexworks_js) . 'plugins.js', array( 'jquery' ), arexworks_theme_version, TRUE );
		wp_enqueue_script('wc-add-to-cart-variation');
		wp_enqueue_script( 'arexworks-theme-js', trailingslashit( arexworks_js ) . 'theme.js', array( 'jquery' ), arexworks_theme_version, TRUE );
		wp_localize_script( 'arexworks-theme-js', 'arexworks_global_message', apply_filters( 'arexworks_filter_global_message_js', array(
			'compare' => array(
				'view' => esc_attr__('View List Compare','arw-leka'),
				'success' => esc_attr__('has been added to comparison list.','arw-leka'),
				'error' => esc_attr__('An error occurred ,Please try again !','arw-leka')
			),
			'wishlist' => array(
				'view' => esc_attr__('View List Wishlist','arw-leka'),
				'success' => esc_attr__('has been added to wishlist.','arw-leka'),
				'error' => esc_attr__('An error occurred ,Please try again !','arw-leka')
			),
			'addcart' => array(
				'view' => esc_attr__('View Cart','arw-leka'),
				'success' => esc_attr__('has been added to cart','arw-leka'),
				'error' => esc_attr__('An error occurred ,Please try again !','arw-leka')
			),
			'global' => array(
				'error' => esc_attr__('An error occurred ,Please try again !','arw-leka'),
				'comment_author'    => esc_attr__('Please enter Name !','arw-leka'),
				'comment_email'     => esc_attr__('Please enter Email Address !','arw-leka'),
				'comment_rating'    => esc_attr__('Please select a rating !','arw-leka'),
				'comment_content'   => esc_attr__('Please enter Comment !','arw-leka')
			),
			'enable_sticky_header' => arexworks_get_option_data('sticky_header',false)
		) ) );
		if ( is_singular() ) wp_enqueue_script( "comment-reply" );
	}
}

if(function_exists('vc_woocommerce_add_to_cart_script')){
	remove_action( 'wp_enqueue_scripts', 'vc_woocommerce_add_to_cart_script' );
}

if ( !function_exists( 'arexworks_admin_enqueue_scripts' ) ){
	add_action( 'admin_enqueue_scripts', 'arexworks_admin_enqueue_scripts' );
	function arexworks_admin_enqueue_scripts(){
		wp_enqueue_style( 'arexworks-admin-stylesheet', trailingslashit(arexworks_css) . 'admin.css', array(), arexworks_theme_version, 'all');
		wp_enqueue_media();
		wp_enqueue_script( 'arexworks-admin-script', trailingslashit(arexworks_js) . 'admin.js', array('jquery'), arexworks_theme_version, FALSE);
		if(wp_script_is('ultimate-smooth-scroll','registered')){
			wp_deregister_script('ultimate-smooth-scroll');
		}
	}
}

if ( !function_exists( 'arexworks_add_filter_wp_title' ) ){
	add_filter( 'wp_title', 'arexworks_add_filter_wp_title' );
	function arexworks_add_filter_wp_title( $title ){
		return $title;
	}
}

// Disable the WordPress Admin Bar for all but admins
if (! current_user_can('edit_posts')){
	show_admin_bar(false);
}
if(function_exists('vc_disable_frontend')){
	vc_disable_frontend();
}
if(function_exists('vc_set_as_theme')){
	vc_set_as_theme(true);
}

if ( !function_exists( 'arexworks_add_action_wp_head_override_style_loader_tag' ) ){
	add_action('wp_head', 'arexworks_add_action_wp_head_override_style_loader_tag', 1);
	function arexworks_add_action_wp_head_override_style_loader_tag() {
		add_filter('style_loader_tag', 'arexworks_add_filter_style_loader_tag_head');
	}
}

if ( !function_exists( 'arexworks_add_action_wp_footer_override_style_loader_tag' ) ){
	add_action('wp_footer', 'arexworks_add_action_wp_footer_override_style_loader_tag', 1);
	function arexworks_add_action_wp_footer_override_style_loader_tag() {
		add_filter('style_loader_tag', 'arexworks_add_filter_style_loader_tag_footer');
	}
}


if ( !function_exists( 'arexworks_add_filter_style_loader_tag_head' ) ){
	function arexworks_add_filter_style_loader_tag_head($tag) {
		$tag = str_replace("media=''", "media='all'", $tag);
		return $tag;
	}
}
if ( !function_exists( 'arexworks_add_filter_style_loader_tag_footer' ) ){
	function arexworks_add_filter_style_loader_tag_footer($tag) {
		$tag = str_replace("rel='stylesheet'", "rel='stylesheet' property='stylesheet'", $tag);
		$tag = str_replace("media=''", "media='all'", $tag);
		return $tag;
	}
}

if ( !function_exists('arexworks_remove_ver_css_js') ){
	add_filter( 'style_loader_src', 'arexworks_remove_ver_css_js', 9999 );
	add_filter( 'script_loader_src', 'arexworks_remove_ver_css_js', 9999 );
	function arexworks_remove_ver_css_js( $src ) {
		$src = remove_query_arg( 'ver', $src );
		return esc_url($src);
	}
}
if(class_exists('RevSliderBaseAdmin')){
	remove_action('add_meta_boxes', array('RevSliderBaseAdmin', 'onAddMetaboxes'));
}

function arexworks_search_post_by_only_post($query){
	if ( !is_admin() && $query->is_main_query() ) {
		if ($query->is_search && !isset($_GET['post_type'])){
			$query->set('post_type','post');
		}
	}
	return $query;
}
add_action('pre_get_posts','arexworks_search_post_by_only_post');