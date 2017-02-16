<?php

// Insert Portfolio Meta Boxes
if(!function_exists('arexworks_admin_portfolio_view_meta_boxes')){
	function arexworks_admin_portfolio_view_meta_boxes() {
		global $portfolio_view_meta_boxes;
		arexworks_admin_show_meta_boxes($portfolio_view_meta_boxes);
	}
}

if(!function_exists('arexworks_admin_portfolio_meta_boxes')){
	function arexworks_admin_portfolio_meta_boxes(){
		global $portfolio_meta_boxes;
		arexworks_admin_show_meta_boxes($portfolio_meta_boxes);
	}
}

if(!function_exists('arexworks_admin_add_portfolio_meta_box')){
	function arexworks_admin_add_portfolio_meta_box() {
		if ( function_exists('add_meta_box') ) {
			add_meta_box( 'portfolio-meta-boxes', __('Portfolio Options', 'arw-leka'), 'arexworks_admin_portfolio_meta_boxes', 'portfolio', 'normal', 'high' );
			add_meta_box( 'view-meta-boxes', __('View Options', 'arw-leka'), 'arexworks_admin_portfolio_view_meta_boxes', 'portfolio', 'normal', 'high' );
		}
	}
}

// Save portfolio Meta
if(!function_exists('arexworks_admin_portfolio_view_save_postdata')){
	function arexworks_admin_portfolio_view_save_postdata( $post_id ) {
		global $portfolio_view_meta_boxes;
		return arexworks_admin_save_postdata( $post_id, $portfolio_view_meta_boxes );
	}
}

if(!function_exists('arexworks_admin_portfolio_save_postdata')){
	function arexworks_admin_portfolio_save_postdata( $post_id ) {
		global $portfolio_meta_boxes;
		return arexworks_admin_save_postdata( $post_id, $portfolio_meta_boxes );
	}
}

// Get portfolio Meta
if(!function_exists('arexworks_admin_portfolio_get_postdata')){
	function arexworks_admin_portfolio_get_postdata() {
		global $portfolio_view_meta_boxes , $portfolio_meta_boxes;
		// Portfolio View Meta Boxes
		$portfolio_view_meta_boxes = arexworks_metaboxes_get_default_meta_view();
		$portfolio_meta_boxes = array(
			// Visit Site Link
			"portfolio_link" => array(
				"name" => "portfolio_link",
				"title" => __("Portfolio Link", 'arw-leka'),
				"type" => "text"
			),
			// Author
			"portfolio_client" => array(
				"name" => "portfolio_author",
				"title" => __("Portfolio Author", 'arw-leka'),
				"type" => "text"
			),
			"portfolio_gallery"=> array(
				"name" => "portfolio_gallery",
				"title" => __("Portfolio Gallery", 'arw-leka'),
				"type" => "gallery"
			),
			"portfolio_width" => array(
				"name" => "portfolio_width",
				"title" => __("Portfolio Width", 'arw-leka'),
				"desc" => __("Apply for Portfolio list with Masonry layout", 'arw-leka'),
				"type" => "select",
				"options" => array(
					'10_10' => __('10/10','arw-leka'),
					'9_10' => __('9/10','arw-leka'),
					'8_10' => __('8/10','arw-leka'),
					'7_10' => __('7/10','arw-leka'),
					'6_10' => __('6/10','arw-leka'),
					'5_10' => __('5/10','arw-leka'),
					'4_10' => __('4/10','arw-leka'),
					'3_10' => __('3/10','arw-leka'),
					'2_10' => __('2/10','arw-leka'),
					'1_10' => __('1/10','arw-leka')
				)
			)
		);
	}
}

add_action('add_meta_boxes', 'arexworks_admin_add_portfolio_meta_box');
add_action('admin_menu', 'arexworks_admin_portfolio_get_postdata');
add_action('save_post', 'arexworks_admin_portfolio_view_save_postdata');
add_action('save_post', 'arexworks_admin_portfolio_save_postdata');