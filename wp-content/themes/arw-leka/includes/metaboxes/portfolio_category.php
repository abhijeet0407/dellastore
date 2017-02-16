<?php

// Create Product Cat Meta Table
if(function_exists('arexworks_create_metadata_table')){
	arexworks_create_metadata_table('portfolio_category');
}

if(!function_exists('arexworks_admin_portfolio_category_meta_boxes')){
	function arexworks_admin_portfolio_category_meta_boxes() {
		global $portfolio_category_meta_boxes;
		arexworks_admin_show_tax_add_meta_boxes($portfolio_category_meta_boxes);
	}
}

if(!function_exists('arexworks_admin_edit_portfolio_category')){
	function arexworks_admin_edit_portfolio_category($tag, $taxonomy) {
		global $portfolio_category_meta_boxes;
		arexworks_admin_show_tax_edit_meta_boxes($tag, $taxonomy, $portfolio_category_meta_boxes);
	}
}

if(!function_exists('arexworks_admin_portfolio_category_get_postdata')){
	function arexworks_admin_portfolio_category_get_postdata(){
		global $portfolio_category_meta_boxes;
		$portfolio_category_meta_boxes = arexworks_metaboxes_get_default_meta_view();
	}
}

if(!function_exists('arexworks_admin_save_portfolio_category')){
	function arexworks_admin_save_portfolio_category($term_id, $tt_id) {
		if (!$term_id) return;
		$taxonomy = 'portfolio_category';
		global $portfolio_category_meta_boxes;
		arexworks_admin_portfolio_category_get_postdata();
		return arexworks_admin_save_taxdata( $term_id, $tt_id, $taxonomy, $portfolio_category_meta_boxes );
	}
}


add_action( 'admin_menu', 'arexworks_admin_portfolio_category_get_postdata');
add_action( 'portfolio_category_add_form_fields', 'arexworks_admin_portfolio_category_meta_boxes', 10, 2);
add_action( 'portfolio_category_edit_form_fields', 'arexworks_admin_edit_portfolio_category', 10, 2);
add_action( 'created_portfolio_category', 'arexworks_admin_save_portfolio_category', 10, 2 );
add_action( 'edit_portfolio_category', 'arexworks_admin_save_portfolio_category', 10, 2 );
