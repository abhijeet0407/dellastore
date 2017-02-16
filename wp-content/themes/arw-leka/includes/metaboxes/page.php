<?php

// Insert Page Meta Boxes
if( !function_exists('arexworks_admin_page_view_meta_boxes')){
	function arexworks_admin_page_view_meta_boxes() {
		global $page_view_meta_boxes;
		arexworks_admin_show_meta_boxes($page_view_meta_boxes);
	}
}

if( !function_exists('arexworks_admin_add_page_meta_box')) {
	function arexworks_admin_add_page_meta_box() {
		if ( function_exists('add_meta_box') ) {
			add_meta_box( 'view-meta-boxes', __('View Options', 'arw-leka'), 'arexworks_admin_page_view_meta_boxes', 'page', 'normal', 'high' );
		}
	}
}

// Save Page Metas
if( !function_exists('arexworks_admin_page_view_save_postdata')){
	function arexworks_admin_page_view_save_postdata( $post_id ) {
		global $page_view_meta_boxes;
		return arexworks_admin_save_postdata( $post_id, $page_view_meta_boxes );
	}
}

// Get Page Metas
if(!function_exists('arexworks_admin_page_get_postdata')){
	function arexworks_admin_page_get_postdata() {
		global $page_view_meta_boxes;
		// Page Meta Boxes
		$page_view_meta_boxes = arexworks_metaboxes_get_default_meta_view();
	}
}

add_action('add_meta_boxes', 'arexworks_admin_add_page_meta_box');
add_action('admin_menu', 'arexworks_admin_page_get_postdata');
add_action('save_post', 'arexworks_admin_page_view_save_postdata');