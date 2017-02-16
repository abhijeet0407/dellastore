<?php

include_once( trailingslashit(arexworks_function_dir) . 'widgets/arexworks_widget_css_class.php' );
include_once( trailingslashit(arexworks_function_dir) . 'widgets/arexworks_widget_base.php' );
include_once( trailingslashit(arexworks_function_dir) . 'widgets/arexworks_wc_widget_price_filter.php' );
include_once( trailingslashit(arexworks_function_dir) . 'widgets/arexwokrs_widget_social.php' );

add_action('widgets_init', 'arexworks_add_action_widgets_init');

if ( !function_exists( 'arexworks_add_action_widgets_init' ) ){
	function arexworks_add_action_widgets_init(){

		if( class_exists('Arexworks_Widget_Social')){
			register_widget('Arexworks_Widget_Social');
		}



		//default sidebar
		register_sidebar(array(
			                 'name'          => __( 'Sidebar Left', 'arw-leka' ),
			                 'id'            => 'sidebar-primary',
			                 'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			                 'after_widget'  => '</aside>',
			                 'before_title'  => '<h3 class="widget-title">',
			                 'after_title'   => '</h3>',
		                 ));
		//catalog widget area
		register_sidebar( array(
			                  'name'          => __( 'Sidebar Right', 'arw-leka' ),
			                  'id'            => 'sidebar-secondary',
			                  'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			                  'after_widget'  => '</aside>',
			                  'before_title'  => '<h3 class="widget-title">',
			                  'after_title'   => '</h3>',
		                  ) );

		if(is_active_woocommerce()){
			register_sidebar(array(
				                 'name'          => __( 'Shop filter', 'arw-leka' ),
				                 'id'            => 'shop-filter',
				                 'before_widget' => '<div class="sort-by-wrapper widget %2$s">',
				                 'after_widget'  => '</div></div>',
				                 'before_title'  => '<div class="sort-by-label">',
				                 'after_title'   => '</div><div class="sort-by-content">',
			                 ));

			if(arexworks_get_option_data('enable_sidebar_essential')){
				register_sidebar( array(
					                  'name'          => __( 'Sidebar Essential', 'arw-leka' ),
					                  'id'            => 'sidebar-essential',
					                  'desc'          => __('This sidebar next to show product detail','arw-leka'),
					                  'before_widget' => '<aside id="%1$s" class="widget %2$s">',
					                  'after_widget'  => '</aside>',
					                  'before_title'  => '<h3 class="widget-title">',
					                  'after_title'   => '</h3>',
				                  ) );
			}
			if(arexworks_get_option_data('enable_sidebar_collateral')){
				register_sidebar( array(
					                  'name'          => __( 'Sidebar Collateral', 'arw-leka' ),
					                  'id'            => 'sidebar-collateral',
					                  'desc'          => __('This sidebar next to show product tab','arw-leka'),
					                  'before_widget' => '<aside id="%1$s" class="widget %2$s">',
					                  'after_widget'  => '</aside>',
					                  'before_title'  => '<h3 class="widget-title">',
					                  'after_title'   => '</h3>',
				                  ) );
			}
		}

		register_sidebar( array(
			                  'name'          => __( 'Header 3 Bottom', 'arw-leka' ),
			                  'id'            => 'header-3-bottom',
			                  'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			                  'after_widget'  => '</aside>',
			                  'before_title'  => '<h3 class="widget-title">',
			                  'after_title'   => '</h3>',
		                  ) );

		//footer second widget area
		for ( $i = 1 ; $i <= 5 ; $i++){
			register_sidebar( array(
				                  'name'          => __( 'Footer Col', 'arw-leka' ) . ' '.$i,
				                  'id'            => 'footer-column-'.$i,
				                  'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				                  'after_widget'  => '</aside>',
				                  'before_title'  => '<h3 class="widget-title">',
				                  'after_title'   => '</h3>',
			                  ) );
		}

	}
}