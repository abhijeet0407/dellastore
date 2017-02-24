<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * Override this template by copying it to yourtheme/woocommerce/content-single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<?php
	/**
	 * woocommerce_before_single_product hook
	 *
	 * @hooked wc_print_notices - 10
	 */
	 do_action( 'woocommerce_before_single_product' );

	 if ( post_password_required() ) {
	 	echo get_the_password_form();
	 	return;
	 }
?>
<?php
//$class_essential_media = 'large-5 medium-6 columns';
$class_essential_media = 'large-12 medium-6 columns';
$class_essential_detail = 'large-7 medium-6 columns';
$class_essential_sidebar = '';
$show_essential_sidebar = false;
if(arexworks_get_option_data('enable_sidebar_essential') && is_active_sidebar('sidebar-essential')){
    $show_essential_sidebar = true;
    $class_essential_media = 'large-5 medium-5 columns';
    $class_essential_detail = 'large-5 medium-5 columns';
    $class_essential_sidebar = 'class_essential_sidebar large-2 medium-2 columns';
}

$class_collateral_tab = 'large-12 medium-12 columns';
$class_collateral_sidebar = '';
$show_collateral_sidebar = false;
if(arexworks_get_option_data('enable_sidebar_collateral') && is_active_sidebar('sidebar-collateral')){
    $show_collateral_sidebar = true;
    $class_collateral_tab = 'large-9 medium-8 columns';
    $class_collateral_sidebar = 'class_collateral_sidebar large-3 medium-4 columns';
}
?>
<div itemscope itemtype="<?php echo esc_attr(woocommerce_get_product_schema()); ?>" id="product-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="row product-essential">
        <div class="<?php echo esc_attr($class_essential_media);?>">
            <div class="product-images-wrapper">
                <?php
                /**
                 * woocommerce_before_single_product_summary hook
                 *
                 * @hooked woocommerce_show_product_sale_flash - 10
                 * @hooked woocommerce_show_product_images - 20
                 */
                do_action( 'woocommerce_before_single_product_summary' );
                ?>
            </div>
			<br><hr class="product_hr />
        </div>
        <div class="<?php echo esc_attr($class_essential_detail);?>">
            <div class="summary entry-summary">

                <?php
                /**
                 * woocommerce_single_product_summary hook
                 *
                 * @hooked woocommerce_template_single_title - 5
                 * @hooked arexworks_woocommerce_custom_stock_html - 6
                 * @hooked woocommerce_template_single_rating - 7
                 * @hooked woocommerce_template_single_excerpt - 8
                 * @hooked woocommerce_template_single_price - 10
                 * @hooked woocommerce_template_single_add_to_cart - 30
                 * @hooked arexworks_woocommerce_add_button_compare_in_detail - 30
                 * @hooked arexworks_woocommerce_add_button_wishlist_in_detail - 31
                 * @hooked woocommerce_template_single_meta - 40
                 * @hooked arexworks_woocommerce_custom_html_service_bellow_add_cart - 45
                 * @hooked woocommerce_template_single_sharing - 50

                 */
                do_action( 'woocommerce_single_product_summary' );
                ?>

            </div><!-- .summary -->
        </div>
        <?php if($show_essential_sidebar):?>
            <div class="<?php echo esc_attr($class_essential_sidebar)?>">
	            <?php if(is_active_sidebar('sidebar-essential')) { dynamic_sidebar('sidebar-essential'); } ?>
            </div>
        <?php endif;?>
    </div>
    <div class="product-collateral">
        <?php remove_action('woocommerce_after_single_product_summary','woocommerce_output_product_data_tabs',10);?>
		<br><hr class="product_hr" />
	<?php
		/**
		 * woocommerce_after_single_product_summary hook
		 *
		 * @hooked woocommerce_output_product_data_tabs - 10
		 * @hooked woocommerce_upsell_display - 15
		 * @hooked woocommerce_output_related_products - 20
		 */
		do_action( 'woocommerce_after_single_product_summary' );
	?>
    </div>
	<meta itemprop="url" content="<?php the_permalink(); ?>" />
		<br><hr class="product_hr" />
        <div class="row">
            <div class="<?php echo esc_attr($class_collateral_tab)?>"><?php echo woocommerce_output_product_data_tabs();?></div>
            <?php if($show_collateral_sidebar):?>
            <div class="<?php echo esc_attr($class_collateral_sidebar)?>">
                <?php if(is_active_sidebar('sidebar-collateral')) { dynamic_sidebar('sidebar-collateral'); }?>
            </div>
            <?php endif;?>
        </div>

</div><!-- #product-<?php the_ID(); ?> -->

<?php do_action( 'woocommerce_after_single_product' ); ?>
