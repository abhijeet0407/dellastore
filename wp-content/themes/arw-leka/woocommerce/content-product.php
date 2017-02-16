<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see     http://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.6.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $woocommerce_loop;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) ) {
	$woocommerce_loop['loop'] = 0;
}

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) ) {
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 3 );
}

// Ensure visibility
if ( ! $product || ! $product->is_visible() ) {
	return;
}

// Increase loop count
$woocommerce_loop['loop']++;

// Extra post classes
$classes = array();
if ( 0 === ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 === $woocommerce_loop['columns'] ) {
	$classes[] = 'first';
}
if ( 0 === $woocommerce_loop['loop'] % $woocommerce_loop['columns'] ) {
	$classes[] = 'last';
}

if ( $woocommerce_loop['loop'] % 2 == 0 ){
	$classes[] = 'even';
}else{
	$classes[] = 'odd';
}


$mode_view = 'grid';
if ( isset ( $woocommerce_loop['mode_view'] ) && !empty( $woocommerce_loop['mode_view'] ) ){
	$mode_view = $woocommerce_loop['mode_view'];
}
$array_attachment = array();
$attachment_ids = $product->get_gallery_attachment_ids();
$thumb_image = $large_image = $alt_image = '';

if ( $mode_view != 'list-mini' && $mode_view != 'list2' &&  $attachment_ids && arexworks_get_option_data('second_image_product_listing')) {
    foreach ( $attachment_ids as $attachment_id ) {
        $image = wp_get_attachment_image( $attachment_id, apply_filters( 'loop_product_catalog_thumbnail_size', 'shop_catalog' ) ,false , array('class'=>'alt_img'));
        if($image){
            $alt_image = $image;
            break;
        }
    }
}

if ( $mode_view == 'list2' ){
	if ( has_post_thumbnail() ){
		$image_shop_single = wp_get_attachment_image_src( get_post_thumbnail_id(), apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ) );
		$image_shop_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id(), apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ) );
		if ( isset( $image_shop_single[0] ) && isset( $image_shop_thumbnail[0] ) ){
			$array_attachment[] = array(
				'shop_single' => $image_shop_single[0],
				'shop_thumbnail' => $image_shop_thumbnail[0]
			);
		}
	}
	if ( $attachment_ids ){
		foreach ( $attachment_ids as $attachment_id ) {
			$image_shop_single = wp_get_attachment_image_src( $attachment_id, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ) );
			$image_shop_thumbnail = wp_get_attachment_image_src( $attachment_id, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ) );
			if ( isset( $image_shop_single[0] ) && isset( $image_shop_thumbnail[0] ) ){
				$array_attachment[] = array(
					'shop_single' => $image_shop_single[0],
					'shop_thumbnail' => $image_shop_thumbnail[0]
				);
			}
		}
	}
	if( !empty($array_attachment) && isset( $array_attachment[0]['shop_single'] ) ){
		$large_image = sprintf(
			'<img src="%s" alt="%s" class="%s"/>',
			esc_url( $array_attachment[0]['shop_single'] ),
			esc_attr(get_the_title()),
			"attachment-shop_catalog_large wp-post-image"
		);
	}

	if( !empty($array_attachment) ){
		foreach( $array_attachment as $attachment ){
			$thumb_image .= sprintf(
				'<a href="%s"><img src="%s" alt="%s"/></a>',
				esc_url( $attachment['shop_single'] ),
				esc_url( $attachment['shop_thumbnail'] ),
				esc_attr(get_the_title())
			);
		}
	}
}
?>
<li <?php post_class( $classes ); ?>>
    <div class="product-inner">
        <?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
        <div class="product_images_wrapper<?php echo $alt_image ? ' has-alt-image' : ''?>">
            <div class="product_thumbnail">
                <div class="product_images_hover">
                    <div class="product_actions">
                        <?php
                        /**
                         * @hooked arexworks_woocommerce_add_button_compare_in_list - 10
                         * @hooked arexworks_woocommerce_add_button_wishlist_in_list - 15
                         * @hooked arexworks_woocommerce_add_button_quick_view_in_list - 20
                         */
                        do_action( 'arexworks_shop_loop_item_action' );
                        ?>
                    </div>
                </div>
                <?php
	                /**
	                 * @hooked woocommerce_template_loop_product_thumbnail - 10
	                 * @hooked arexworks_woocommerce_add_badge_new_in_list - 15
	                 */
                    do_action( 'woocommerce_before_shop_loop_item_title' );
                    echo $alt_image . $large_image;
                ?>
                <a href="<?php the_permalink()?>" rel="nofollow" class="product_link"></a>
            </div>
        </div>
        <div class="product-item-info">
	        <h3><a class="product-title-link" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
	        <?php
		        /**
		         * @hooked woocommerce_template_loop_rating - 5
		         * @hooked wrap-price - 9
		         * @hooked woocommerce_template_loop_price - 10
		         * @hooked wrap-price - 11
		         * @hooked arexworks_woocommerce_add_short_description_in_list - 20
		         */
	            do_action( 'woocommerce_after_shop_loop_item_title' );
	        ?>

	        <div class="product_actions_list">
		        <?php
		        do_action( 'woocommerce_after_shop_loop_item' );
		        do_action( 'arexworks_shop_loop_item_action' );
		        ?>
	        </div>

	        <?php
	        /**
	         * @hooked woocommerce_template_loop_add_to_cart - 10
	         */
	            do_action( 'woocommerce_after_shop_loop_item' );
	        ?>

	        <?php
	        if( !empty( $thumb_image ) ){
		        echo '<div class="product_actions_images"><div class="product_actions_images-wrapper">' . $thumb_image . '</div></div>';
	        }
	        ?>
        </div>
    </div>
</li>
