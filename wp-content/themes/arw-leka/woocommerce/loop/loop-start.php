<?php
/**
 * Product Loop Start
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

global $woocommerce_loop , $wp_rewrite , $wp_query;


$products_per_column_large = 4;
$products_per_column_medium = 4;

if ( ( isset($woocommerce_loop['columns']) && $woocommerce_loop['columns'] != "" ) ) {
	$products_per_column = $woocommerce_loop['columns'];
} else {
	$products_per_column = arexworks_get_option_data('products_per_column',3);
	if (isset($_GET["products_per_row"])) $products_per_column = $_GET["products_per_row"];
}
$products_per_column = apply_filters('arexworks_filter_products_per_row',$products_per_column);
if ($products_per_column == 6) {
	$products_per_column_large = 6;
	$products_per_column_medium = 5;
}

if ($products_per_column == 5) {
	$products_per_column_large = 5;
	$products_per_column_medium = 4;
}

if ($products_per_column == 4) {
	$products_per_column_large = 4;
	$products_per_column_medium = 3;
}

if ($products_per_column == 3) {
	$products_per_column_large = 3;
	$products_per_column_medium = 2;
}

if ($products_per_column == 2) {
	$products_per_column_large = 2;
	$products_per_column_medium = 2;
}
$woocommerce_loop['columns'] = apply_filters('loop_shop_columns',$products_per_column_large);
$mode_view = 'grid';
$class_ul = '';
$data_attribute_infinite = '';
?>
<!--infinite-container-->
<?php
if( is_archive() || is_product_taxonomy() ){
	$mode_view = apply_filters('arexworks_filter_products_mode_view','grid');
	$enable_product_infinite =  arexworks_get_option_data('shop_enable_infinite_scroll',false);

	$rand_id = arexworks_generate_rand();

	if ( $enable_product_infinite ){
		$page_num = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
		$page_link = get_pagenum_link();
		if ( !$wp_rewrite->using_permalinks() || is_admin() || strpos($page_link, '?') ) {
			if (strpos($page_link, '?') !== false)
				$page_path = apply_filters( 'get_pagenum_link', $page_link . '&amp;paged=');
			else
				$page_path = apply_filters( 'get_pagenum_link', $page_link . '?paged=');
		} else {
			$page_path = apply_filters( 'get_pagenum_link', $page_link . user_trailingslashit( $wp_rewrite->pagination_base . "/" ));
		}
		$data_attribute_infinite = 'data-page_num="' . esc_attr( $page_num ) . '" ';
		$data_attribute_infinite .= 'data-page_num_max="' . esc_attr( $wp_query->max_num_pages ) . '" ';
		$data_attribute_infinite .= 'data-path="' . esc_url( $page_path ) . '" ';

		$class_ul .= 'products-infinite-container ';
	}
	?>
<?php
}
$class_ul .= "{$mode_view} products products-{$mode_view} small-block-grid-2 medium-block-grid-{$products_per_column_medium} large-block-grid-{$products_per_column_large}";
?>
<!--/infinite-container-->
<div class="row">
	<div class="large-12 columns">
		<ul class="<?php echo esc_attr($class_ul)?>" <?php echo $data_attribute_infinite;?>>