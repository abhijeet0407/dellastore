<?php

// Insert Product Meta Boxes
if(!function_exists('arexworks_admin_product_view_meta_boxes')){
	function arexworks_admin_product_view_meta_boxes() {
		global $product_view_meta_boxes;
		arexworks_admin_show_meta_boxes($product_view_meta_boxes);
	}
}

if(!function_exists('arexworks_admin_add_product_meta_box')){
	function arexworks_admin_add_product_meta_box() {
		if ( function_exists('add_meta_box') ) {
			add_meta_box( 'view-meta-boxes', __('View Options', 'arw-leka'), 'arexworks_admin_product_view_meta_boxes', 'product', 'normal', 'high' );
		}
	}
}


// Save Product Meta
if(!function_exists('arexworks_admin_product_view_save_postdata')){
	function arexworks_admin_product_view_save_postdata( $post_id ) {
		global $product_view_meta_boxes;
		return arexworks_admin_save_postdata( $post_id, $product_view_meta_boxes );
	}
}


// Get Product Meta
if(!function_exists('arexworks_admin_product_get_postdata')){
	function arexworks_admin_product_get_postdata() {
		global $product_view_meta_boxes;
		// Product Meta Boxes
		$product_view_meta_boxes = arexworks_metaboxes_get_default_meta_view();
	}
}


add_action('add_meta_boxes', 'arexworks_admin_add_product_meta_box');
add_action('admin_menu', 'arexworks_admin_product_get_postdata');
add_action('save_post', 'arexworks_admin_product_view_save_postdata');