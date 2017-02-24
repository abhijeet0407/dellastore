<script src="http://masonry.desandro.com/masonry.pkgd.js"></script>
<script src="http://imagesloaded.desandro.com/imagesloaded.pkgd.js"></script>

<script>
	// external js: masonry.pkgd.js, imagesloaded.pkgd.js
	// init Masonry
	jQuery(window).load(function() {
		var $grid = jQuery('.grid').masonry({
			itemSelector: '.grid-item',
			percentPosition: true,
			columnWidth: '.grid-sizer'
		});
		// layout Isotope after each image loads
		$grid.imagesLoaded().progress(function() {
			$grid.masonry();
		});
	});
</script>
<style>
* { box-sizing: border-box; }

/* force scrollbar */
html { overflow-y: scroll; }
body { font-family: sans-serif; }

/* ---- grid ---- */
.grid { background: #DDD; }

/* clear fix */
.grid:after { content: ''; display: block; clear: both; }

/* ---- .grid-item ---- */
.grid-sizer,.grid-item { width: 33.333%; }
.grid-item { float: left; }
.grid-item img { display: block; max-width: 100%; }

</style>
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
$image_link=wp_get_attachment_url( get_post_thumbnail_id() );
if ( $attachment_ids ) { ?>
    <?php if ( has_post_thumbnail() ) { ?>
		<!-- <div id="main_product_single_thumbnail_image">
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
		</div> -->
		<div class="grid">
		  <div class="grid-sizer"></div>
		    <div class="grid-item">
				<img src="<?php echo $image_link; ?>" />
						<?php //print_r($image); ?>
			</div>
		 
		  <?php foreach ( $attachment_ids as $attachment_id ) {
					$image_title = esc_attr( get_the_title( $attachment_id ) );
					$image       = wp_get_attachment_image_url( $attachment_id );
					?>
					  <div class="grid-item">
					  <img src="<?php echo $image; ?>" />
						<?php //print_r($image); ?>
					  </div>
					<?php
					if (empty( $image ))
						continue;
				} ?>
		  
		</div>
		<?php 		
			/* echo '<div id="container" class="photos clearfix">';
				foreach ( $attachment_ids as $attachment_id ) {
					$image_title = esc_attr( get_the_title( $attachment_id ) );
					$image       = wp_get_attachment_image_url( $attachment_id );
					?>
					  <div class="photo">
					  <img class="small-image" src="<?php echo $image; ?>" />
						<?php //print_r($image); ?>
					  </div>
					<?php
					if (empty( $image ))
						continue;
				}
			echo ' </div> '; */
		?>
        <?php
    }
}