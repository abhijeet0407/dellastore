<?php

global $woocommerce_loop;


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
$mode_view = cookie('arexworks_products_mode_view') ? cookie('arexworks_products_mode_view') : 'grid';
if ( in_array( get('view'), array( 'list', 'grid' ) ) ){
	$mode_view = get('view');
}

$class_ul = "{$mode_view} products products-{$mode_view} small-block-grid-2 medium-block-grid-{$products_per_column_medium} large-block-grid-{$products_per_column_large}";
?>
<div class="wrapper-product-category wrapper-product-category-<?php echo esc_attr($mode_view)?>">
	<div class="row">
        <div class="large-12 columns">
            <ul class="<?php echo esc_attr($class_ul)?>">
	            <?php woocommerce_product_subcategories();?>
            </ul>
        </div>
	</div>
</div>