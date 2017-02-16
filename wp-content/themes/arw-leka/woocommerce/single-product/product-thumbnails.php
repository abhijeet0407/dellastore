<?php
/**
 * Single Product Thumbnails
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

global $post, $product, $woocommerce;

$attachment_ids = $product->get_gallery_attachment_ids();

if ( $attachment_ids ) { ?>
    <?php if ( has_post_thumbnail() ) { ?>
		<div id="main_product_single_thumbnail_image">
			<div class="main_product_single_thumbnail_image_slider">
				<?php
				$image_title 		= esc_attr( get_the_title( get_post_thumbnail_id() ) );
				$image       		= get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ), array(
					'title' => $image_title
				) );
				echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '<div class="thumbnail-images"><div>%s</div></div>', $image ), $post->ID );

				foreach ( $attachment_ids as $attachment_id ) {
					$image_title = esc_attr( get_the_title( $attachment_id ) );
					$image       = wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ), array(
						'title' => $image_title
					) );
					if ( empty( $image ) )
						continue;

					echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '<div class="thumbnail-images"><div>%s</div></div>', $image ), $attachment_id, $post->ID );
				}
				?>
			</div>
		</div>
        <?php
    }
}