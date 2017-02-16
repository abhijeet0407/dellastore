<?php

/**
 * Add Filter
 */

add_filter( 'woocommerce_add_to_cart_fragments', 'arexworks_woocommerce_add_to_cart_fragments_custom' );
add_filter( 'woocommerce_placeholder_img_src', 'arexworks_woocommerce_placeholder_img_src' );
add_filter( 'woocommerce_sale_flash', 'arexworks_woocommerce_add_badge_sale_in_list', 20, 3 );
add_filter( 'loop_shop_per_page', 'arexworks_woocommerce_override_loop_shop_per_page', 20 );
add_filter( 'woocommerce_show_page_title', 'arexworks_return_false' );
add_filter( 'woocommerce_get_catalog_ordering_args', 'arexworks_woocommerce_get_catalog_ordering_args' );
//add_filter( 'woocommerce_stock_html', 'arexworks_return_false' );
add_filter( 'woocommerce_product_description_heading', 'arexworks_return_false' );
add_filter( 'woocommerce_product_additional_information_heading', 'arexworks_return_false' );

add_filter( 'woocommerce_product_tabs', 'arexworks_woocommerce_add_filter_product_tabs' );

add_filter( 'woocommerce_loop_add_to_cart_link', 'arexworks_woocommerce_add_filter_woocommerce_loop_add_to_cart_link', 10, 2 );
add_filter( 'woocommerce_product_get_rating_html', 'arexworks_woocommerce_add_filter_woocommerce_product_get_rating_html', 10, 2 );
add_filter( 'woocommerce_pagination_args', 'arexwokrs_woocommerce_add_filter_woocommerce_pagination_args', 10, 1 );

add_filter( 'woocommerce_product_gallery_attachment_ids', 'arexworks_woocommerce_add_filter_woocommerce_product_gallery_attachment_ids', 10, 2 );
add_filter( 'woocommerce_subcategory_count_html', 'arexworks_woocommerce_add_filter_woocommerce_subcategory_count_html', 20, 2);
/**
 * Add Action
 */

add_action( 'init', 'arexworks_woocommerce_setcookie_default' );

add_action( 'init', 'arexworks_woocommerce_add_action_empty_cart_action' );
add_action( 'woocommerce_before_shop_loop', 'wc_print_notices', 0 );

add_action( 'woocommerce_before_shop_loop_item_title', 'arexworks_woocommerce_add_badge_new_in_list', 15 );

add_action( 'arexworks_woocommerce_toolbar', create_function("","echo '<div class=\"toolbar-left\">';"),10);
add_action( 'arexworks_woocommerce_toolbar', 'arexworks_woocommerce_add_toolbar_per_page', 20 );
add_action( 'arexworks_woocommerce_toolbar', 'woocommerce_catalog_ordering', 30 );
add_action( 'arexworks_woocommerce_toolbar', 'arexworks_woocommerce_add_toolbar_position', 40 );
add_action( 'arexworks_woocommerce_toolbar', 'arexworks_woocommerce_add_gridlist_toggle_button', 50 );
add_action( 'arexworks_woocommerce_toolbar', create_function("","echo '</div>';"),60);
add_action( 'arexworks_woocommerce_toolbar', create_function("","echo '<div class=\"toolbar-right\">';"),70);
add_action( 'arexworks_woocommerce_toolbar', 'arexworks_woocommerce_add_filter_attribute_on_toolbar', 80 );
add_action( 'arexworks_woocommerce_toolbar', 'woocommerce_result_count', 90 );
add_action( 'arexworks_woocommerce_toolbar', create_function("","echo '</div>';"),100);

add_action( 'woocommerce_before_shop_loop', 'arexworks_woocommerce_add_toolbar' );

add_action( 'woocommerce_after_shop_loop_item_title', 'arexworks_woocommerce_add_short_description_in_list', 20 );
add_action( 'woocommerce_after_shop_loop_item_title', create_function("","echo '<div class=\"product_list_price\">';"), 9 );
add_action( 'woocommerce_after_shop_loop_item_title', create_function("","echo '</div>';"), 11 );

add_action( 'arexworks_shop_loop_item_action', 'arexworks_woocommerce_add_button_compare_in_list', 10 );
add_action( 'arexworks_shop_loop_item_action', 'arexworks_woocommerce_add_button_wishlist_in_list', 15 );
add_action( 'arexworks_shop_loop_item_action', 'arexworks_woocommerce_add_button_quick_view_in_list', 20 );


add_action( 'woocommerce_single_product_summary', 'arexworks_woocommerce_custom_stock_html', 6 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 7 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 8 );
add_action( 'woocommerce_single_product_summary', 'arexworks_woocommerce_add_button_compare_in_detail', 30 );
add_action( 'woocommerce_single_product_summary', 'arexworks_woocommerce_add_button_wishlist_in_detail', 31 );
add_action( 'woocommerce_single_product_summary', 'arexworks_woocommerce_custom_html_service_bellow_add_cart', 45 );

add_action( 'woocommerce_review_order_before_payment','arexworks_woocommerce_review_order_before_payment' );

add_action( 'wp_head', 'arexworks_woocommerce_show_upsell_related_products' );

add_action( 'woocommerce_before_checkout_form', 'arexworks_woocommerce_before_checkout_form', 10 );



/**
 * Remove Filter
 */

/**
 * Remove Action
 */
remove_action( 'woocommerce_before_shop_loop', 'wc_print_notices', 10 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );

remove_all_actions( 'woocommerce_after_shop_loop_item', 20 );
remove_all_actions( 'woocommerce_single_product_summary', 35 );

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );

remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display', 10 );
remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cart_totals', 10 );

remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_login_form', 10 );
remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );


if(arexworks_get_option_data('catalog_mode',false)){
	// In Loop
	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
	add_filter( 'woocommerce_loop_add_to_cart_link', '__return_empty_string', 10 );
	// In Single
	remove_action('woocommerce_single_product_summary','woocommerce_template_single_add_to_cart',30);
	// In Page
	add_action( 'wp', 'arexworks_check_pages_redirect_catalog_mode');
}