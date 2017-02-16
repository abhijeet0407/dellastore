<?php
// Create Product Cat Meta Table
if(function_exists('arexworks_create_metadata_table')){
	arexworks_create_metadata_table('product_cat');
}

if(!function_exists('arexworks_admin_product_cat_meta_boxes')){
	function arexworks_admin_product_cat_meta_boxes() {
		global $product_cat_meta_boxes;
		arexworks_admin_show_tax_add_meta_boxes($product_cat_meta_boxes);
	}
}

if(!function_exists('arexworks_admin_edit_product_cat')){
	function arexworks_admin_edit_product_cat($tag, $taxonomy) {
		global $product_cat_meta_boxes;
		arexworks_admin_show_tax_edit_meta_boxes($tag, $taxonomy, $product_cat_meta_boxes);
	}
}

if(!function_exists('arexworks_admin_product_cat_get_postdata')){
	function arexworks_admin_product_cat_get_postdata(){
		global $product_cat_meta_boxes;
		$product_cat_meta_boxes = arexworks_metaboxes_get_default_meta_view();
	}
}

if(!function_exists('arexworks_admin_save_product_cat')){
	function arexworks_admin_save_product_cat($term_id, $tt_id) {
		if (!$term_id) return;
		$taxonomy = 'product_cat';
		global $product_cat_meta_boxes;
		arexworks_admin_product_cat_get_postdata();
		return arexworks_admin_save_taxdata( $term_id, $tt_id, $taxonomy, $product_cat_meta_boxes );
	}
}


add_action( 'admin_menu', 'arexworks_admin_product_cat_get_postdata');
add_action( 'product_cat_add_form_fields', 'arexworks_admin_product_cat_meta_boxes', 10, 2);
add_action( 'product_cat_edit_form_fields', 'arexworks_admin_edit_product_cat', 10, 2);
add_action( 'created_product_cat', 'arexworks_admin_save_product_cat', 10, 2 );
add_action( 'edit_product_cat', 'arexworks_admin_save_product_cat', 10, 2 );