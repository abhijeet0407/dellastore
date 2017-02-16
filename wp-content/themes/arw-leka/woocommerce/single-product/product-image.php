<?php
/**
 * Single Product Image
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.14
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $woocommerce, $product;

$_show_popup_image = false;
$_enable_zoom = false;
if (get_option('woocommerce_enable_lightbox') == "yes") {
	$_show_popup_image = true;
}
if ( arexworks_get_option_data( 'product_gallery_zoom', false ) ){
	$_enable_zoom = true;
}

?>

<?php

//Featured

$image_title 				= esc_attr( get_the_title( get_post_thumbnail_id() ) );
$image_link  				= wp_get_attachment_url( get_post_thumbnail_id() );
$image       				= get_the_post_thumbnail( $post->ID,
                                                    apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ) ,
                                                    array(
	                                                    'itemprop'=>'image'
                                                    ) );
$attachment_count   		= count( $product->get_gallery_attachment_ids() );
?>

<div id="main_product_single_image">

    <?php if ( has_post_thumbnail() ) { ?>

	    <div data-popup="<?php echo esc_attr( $_show_popup_image ? 'yes' : 'no' ); ?>" data-zoom="<?php echo esc_attr( $_enable_zoom ? 'yes' : 'no' );?>" class="main_product_single_image_slider">
		    <div class="product-image-main">
			    <a href="<?php echo $image_link?>">
				    <?php echo $image;?>
			    </a>
		    </div>
		    <?php
		    $attachment_ids = $product->get_gallery_attachment_ids();
		    if ( $attachment_ids ) {
			    foreach ( $attachment_ids as $attachment_id ) {
				    $image_link     = wp_get_attachment_url( $attachment_id );
				    if ( !$image_link ) continue;
				    $image_title    = esc_attr( get_the_title( $attachment_id ) );
				    $image          = wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ) );
				    ?>
	            <div class="product-image-main">
				    <a href="<?php echo $image_link ?>">
					    <?php echo $image; ?>
				    </a>
			    </div>
			    <?php
			    }
		    }
		    ?>
	    </div>

    <?php

    } else {

        echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="Placeholder" />', wc_placeholder_img_src() ), $post->ID );

    }

    ?>

</div>

<?php do_action( 'woocommerce_product_thumbnails' ); ?>
