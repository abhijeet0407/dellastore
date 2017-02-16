<?php
if( !function_exists('arexworks_admin_options_layout_global') ){
	function arexworks_admin_options_layout_global(){
		return array(
			'col-1c'  => array('alt' => __('1 Column', 'arw-leka' ),         'img' => esc_url(arexworks_image . '/theme_options/layout/col-1c.png') ),
			'col-2cl' => array('alt' => __('2 Column Left', 'arw-leka' ),    'img' => esc_url(arexworks_image . '/theme_options/layout/col-2cl.png') ),
			'col-2cr' => array('alt' => __('2 Column Right', 'arw-leka' ),   'img' => esc_url(arexworks_image . '/theme_options/layout/col-2cr.png') ),
			'col-3cm' => array('alt' => __('3 Column Middle', 'arw-leka' ),  'img' => esc_url(arexworks_image . '/theme_options/layout/col-3cm.png') ),
			'col-3cl' => array('alt' => __('3 Column Left', 'arw-leka' ),    'img' => esc_url(arexworks_image . '/theme_options/layout/col-3cl.png') ),
			'col-3cr' => array('alt' => __('3 Column Right', 'arw-leka' ),   'img' => esc_url(arexworks_image . '/theme_options/layout/col-3cr.png') )
		);
	}
}
if( !function_exists('arexworks_admin_options_layout_inherit') ){
	function arexworks_admin_options_layout_inherit(){
		return array(
			'inherit' => array('alt' => __('Inherit','arw-leka' ),           'img' => esc_url(arexworks_image . '/theme_options/layout/layout-off.png') ),
			'col-1c'  => array('alt' => __('1 Column', 'arw-leka' ),         'img' => esc_url(arexworks_image . '/theme_options/layout/col-1c.png') ),
			'col-2cl' => array('alt' => __('2 Column Left', 'arw-leka' ),    'img' => esc_url(arexworks_image . '/theme_options/layout/col-2cl.png') ),
			'col-2cr' => array('alt' => __('2 Column Right', 'arw-leka' ),   'img' => esc_url(arexworks_image . '/theme_options/layout/col-2cr.png') ),
			'col-3cm' => array('alt' => __('3 Column Middle', 'arw-leka' ),  'img' => esc_url(arexworks_image . '/theme_options/layout/col-3cm.png') ),
			'col-3cl' => array('alt' => __('3 Column Left', 'arw-leka' ),    'img' => esc_url(arexworks_image . '/theme_options/layout/col-3cl.png') ),
			'col-3cr' => array('alt' => __('3 Column Right', 'arw-leka' ),   'img' => esc_url(arexworks_image . '/theme_options/layout/col-3cr.png') )
		);
	}
}
if( !function_exists('arexworks_admin_options_page_style') ){
	function arexworks_admin_options_page_style(){
		return array(
			'stretched' => __( 'Stretched', 'arw-leka' ),
			'boxed' => __( 'Boxed', 'arw-leka' ),
			'full-width' => __( 'Full Width', 'arw-leka' )
		);
	}
}
if( !function_exists('arexworks_admin_options_page_header_layout') ){
	function arexworks_admin_options_page_header_layout(){
		return array(
			'1' => array('alt' => __('Style 1', 'arw-leka' ),   'img' => esc_url(arexworks_image . '/theme_options/page-title/page-title-1.jpg') ),
			'2' => array('alt' => __('Style 2', 'arw-leka' ),   'img' => esc_url(arexworks_image . '/theme_options/page-title/page-title-2.jpg') )
		);
	}
}
if( !function_exists('arexworks_admin_options_header_layout') ){
	function arexworks_admin_options_header_layout(){
		return array(
			'1' => array('alt' => __('Layout 1', 'arw-leka' ),   'img' => esc_url(arexworks_image . '/theme_options/header/header-1.jpg') ),
			'2' => array('alt' => __('Layout 2', 'arw-leka' ),   'img' => esc_url(arexworks_image . '/theme_options/header/header-2.jpg') ),
			'3' => array('alt' => __('Layout 3', 'arw-leka' ),   'img' => esc_url(arexworks_image . '/theme_options/header/header-3.jpg') ),
			'4' => array('alt' => __('Layout 4', 'arw-leka' ),   'img' => esc_url(arexworks_image . '/theme_options/header/header-4.jpg') )
		);
	}
}
if( !function_exists('arexworks_admin_options_footer_layout') ){
	function arexworks_admin_options_footer_layout(){
		return array(
			'1' => array('alt' => __('Layout 1', 'arw-leka' ),   'img' => esc_url(arexworks_image . '/theme_options/footer/footer-1.jpg') ),
			'2' => array('alt' => __('Layout 2', 'arw-leka' ),   'img' => esc_url(arexworks_image . '/theme_options/footer/footer-2.jpg') )
		);
	}
}
if( !function_exists('arexworks_admin_options_breadcrumbs_type') ){
	function arexworks_admin_options_breadcrumbs_type(){
		return array(
			'1' => array('alt' => __('Layout 1', 'arw-leka' ),   'img' => esc_url(arexworks_image . '/theme_options/breadcrumbs/breadcrumbs-1.jpg') ),
			'2' => array('alt' => __('Layout 2', 'arw-leka' ),   'img' => esc_url(arexworks_image . '/theme_options/breadcrumbs/breadcrumbs-2.jpg') ),
		);
	}
}
if( !function_exists('arexworks_admin_options_blog_display_type') ){
	function arexworks_admin_options_blog_display_type(){
		return array(
			'grid'      => __( 'Grid', 'arw-leka' ),
			'isotope'      => __( 'Mansory', 'arw-leka' ),
			'full'      => __( 'Full', 'arw-leka' )
		);
	}
}

if( !function_exists( 'arexworks_redux_slug_field_validate_callback_function' ) ){
	function arexworks_redux_slug_field_validate_callback_function($field, $value, $existing_value){
		$error = false;
		$value = sanitize_title($value);
		if (empty($value)) {
			$error = true;
			$value = $existing_value;
		}
		$return['value'] = $value;
		if ($error == true) {
			$return['error'] = $field;
		}

		flush_rewrite_rules();

		return $return;
	}
}

if( !function_exists('arexworks_redux_register_custom_extension_loader') ){
	function arexworks_redux_register_custom_extension_loader($ReduxFramework) {
		$path    = arexworks_lib_plugin_dir . '/redux-extension/';
		$folders = scandir( $path, 1 );
		foreach ( $folders as $folder ) {
			if ( $folder === '.' or $folder === '..' or ! is_dir( $path . $folder ) ) {
				continue;
			}
			$extension_class = 'ReduxFramework_Extension_' . $folder;
			if ( ! class_exists( $extension_class ) ) {
				// In case you wanted override your override, hah.
				$class_file = $path . $folder . '/extension_' . $folder . '.php';
				$class_file = apply_filters( 'redux/extension/' . $ReduxFramework->args['opt_name'] . '/' . $folder, $class_file );
				if ( $class_file ) {
					require_once( $class_file );
				}
			}
			if ( ! isset( $ReduxFramework->extensions[ $folder ] ) ) {
				$ReduxFramework->extensions[ $folder ] = new $extension_class( $ReduxFramework );
			}
		}
	}
	add_action("redux/extensions/arexworks_theme_options/before", 'arexworks_redux_register_custom_extension_loader', 0);
}

if( !function_exists( 'arexworks_add_filter_wbc_importer_dir_path' ) ){
	add_filter( 'wbc_importer_dir_path', 'arexworks_add_filter_wbc_importer_dir_path',20 );
	function arexworks_add_filter_wbc_importer_dir_path( $path ){
		$path = arexworks_include_dir . '/demo-data/';
		return $path;
	}
}

if( !function_exists( 'arexworks_add_filter_radium_theme_import_widget_settings' ) ){
	add_filter( 'radium_theme_import_widget_settings', 'arexworks_add_filter_radium_theme_import_widget_settings',20 );
	function arexworks_add_filter_radium_theme_import_widget_settings($widgets){
		if(isset($widgets->nav_menu)){
			$nav_menu = wp_get_nav_menu_object($widgets->nav_menu);
			if(isset($nav_menu->term_id)){
				$widgets->nav_menu = $nav_menu->term_id;
			}
		}
		return $widgets;
	}
}

if( !function_exists( 'arexworks_add_filter_wbc_importer_directory_title' ) ) {
	add_filter( 'wbc_importer_directory_title', 'arexworks_add_filter_wbc_importer_directory_title', 20 );
	function arexworks_add_filter_wbc_importer_directory_title( $title ) {
		return trim( ucfirst( str_replace( "-", " ", $title ) ) );
	}
}

if( !function_exists( 'arexworks_add_action_wbc_importer_after_content_import' ) ) {
	add_action( 'wbc_importer_after_content_import', 'arexworks_add_action_wbc_importer_after_content_import', 20, 2 );
	function arexworks_add_action_wbc_importer_after_content_import( $demo_active_import , $demo_directory_path ) {

		reset( $demo_active_import );
		$current_key = key( $demo_active_import );

		/************************************************************************
		 * Import slider(s) for the current demo being imported
		 *************************************************************************/

		if ( class_exists( 'RevSlider' ) ) {

			$wbc_sliders_array = array(
				'demo-1' => 'slider-main-fashion-1.zip',
				'demo-2' => 'slider-main-fashion-2.zip',
				'demo-3' => 'slider-main-fashion-3.zip',
				'demo-5' => 'slider-main-fashion-5.zip',
				'demo-6' => 'slider-main-fashion-6.zip',
				'demo-7' => 'slider-main-fashion-7.zip',
			);

			if ( isset( $demo_active_import[$current_key]['directory'] ) && !empty( $demo_active_import[$current_key]['directory'] ) && array_key_exists( $demo_active_import[$current_key]['directory'], $wbc_sliders_array ) ) {
				$wbc_slider_import = $wbc_sliders_array[$demo_active_import[$current_key]['directory']];

				if ( file_exists( $demo_directory_path.$wbc_slider_import ) ) {
					$slider = new RevSlider();
					$slider->importSliderFromPost( true, true, $demo_directory_path.$wbc_slider_import );
				}
			}
		}

		/************************************************************************
		 * Setting Menus
		 *************************************************************************/

		$wbc_menu_array = array( 'demo-1', 'demo-2', 'demo-3', 'demo-4', 'demo-5', 'demo-6', 'demo-7' );

		if ( isset( $demo_active_import[$current_key]['directory'] ) && !empty( $demo_active_import[$current_key]['directory'] ) && in_array( $demo_active_import[$current_key]['directory'], $wbc_menu_array ) ) {

			$tmp_menu_object = get_term_by( 'name', 'Temp Menu', 'nav_menu' );
			$main_menu_object = get_term_by( 'name', 'Main Navigation', 'nav_menu' );
			$top_menu_object = get_term_by( 'name', 'Header Top Navigation', 'nav_menu' );

			$nav_menu_locations = array(
				'main-navigation'       => '',
				'top-bar-navigation'    => ''
			);
			if ( isset( $tmp_menu_object->term_id ) ) {
				$nav_menu_locations['main-navigation'] = $tmp_menu_object->term_id;
				$nav_menu_locations['top-bar-navigation'] = $tmp_menu_object->term_id;
			}
			if(isset($main_menu_object->term_id)) {
				$nav_menu_locations['main-navigation'] = $main_menu_object->term_id;
			}
			if(isset($top_menu_object->term_id)){
				$nav_menu_locations['top-bar-navigation'] = $top_menu_object->term_id;
			}

			set_theme_mod( 'nav_menu_locations',$nav_menu_locations);

		}

		/************************************************************************
		 * Set HomePage
		 *************************************************************************/

		// array of demos/homepages to check/select from
		$wbc_home_pages = array(
			'demo-1' => 'Home 1',
			'demo-2' => 'Home 2',
			'demo-3' => 'Home 3',
			'demo-4' => 'Home 4',
			'demo-5' => 'Home 5',
			'demo-6' => 'Home 6',
			'demo-7' => 'Home 7'
		);
		$wbc_blog_pages = array(
			'demo-1' => 'Blog',
			'demo-2' => 'Blog',
			'demo-3' => 'Blog',
			'demo-4' => 'Blog',
			'demo-5' => 'Blog',
			'demo-6' => 'Blog',
			'demo-7' => 'Blog'
		);
		if ( isset( $demo_active_import[$current_key]['directory'] ) && !empty( $demo_active_import[$current_key]['directory'] ) && array_key_exists( $demo_active_import[$current_key]['directory'], $wbc_home_pages ) ) {
			$page = get_page_by_title( $wbc_home_pages[$demo_active_import[$current_key]['directory']] );
			if ( isset( $page->ID ) ) {
				update_option( 'page_on_front', $page->ID );
				update_option( 'show_on_front', 'page' );
			}
		}
		if ( isset( $demo_active_import[$current_key]['directory'] ) && !empty( $demo_active_import[$current_key]['directory'] ) && array_key_exists( $demo_active_import[$current_key]['directory'], $wbc_blog_pages ) ) {
			$blog = get_page_by_title( $wbc_blog_pages[$demo_active_import[$current_key]['directory']] );
			if ( isset( $blog->ID ) ) {
				update_option( 'page_for_posts', $blog->ID );
				update_option( 'show_on_front', 'page' );
			}
		}

	}
}

if( !function_exists( 'arexworks_admin_add_plugin_import')){
	//add_action( 'admin_init', 'arexworks_admin_add_plugin_import' );
	function arexworks_admin_add_plugin_import() {
		if ( !class_exists( 'WP_Import' ) && !arexworks_is_wp_ajax() ) {
			$class_wp_import = arexworks_lib_plugin_dir .'/redux-extension/wbc_importer/inc/importer/wordpress-importer.php';
			if ( file_exists( $class_wp_import ) ){
				require $class_wp_import;
				if(class_exists('WP_Import')){
					$GLOBALS['wp_import'] = new WP_Import();
					register_importer( 'wordpress', 'WordPress', __('Import posts, pages, comments, custom fields, categories, and tags from a WordPress export file.', 'arw-leka'), array( $GLOBALS['wp_import'], 'dispatch' ) );
				}
			}
		}

	}
}