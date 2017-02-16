<?php
/**
 * Related Products
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $woocommerce_loop;

if ( empty( $product ) || ! $product->exists() ) {
	return;
}

$related = $product->get_related( $posts_per_page );

if ( sizeof( $related ) == 0 ) return;

$args = apply_filters( 'woocommerce_related_products_args', array(
	'post_type'            => 'product',
	'ignore_sticky_posts'  => 1,
	'no_found_rows'        => 1,
	'posts_per_page'       => $posts_per_page,
	'orderby'              => $orderby,
	'post__in'             => $related,
	'post__not_in'         => array( $product->id )
) );

$products = new WP_Query( $args );

$woocommerce_loop['columns'] = $columns;

$slide_config = array(
	'infinite'          => true,
	'slidesToShow'      => 4,
	'slidesToScroll'    => 1,
	'dots'              => false,
	'slide'             => 'ul',
	'responsive'        => array(
		array(
			'breakpoint'    => 1440,
			'settings'      => array(
				'slidesToShow'      => 4,
				'slidesToScroll'    => 1,
				'slide'             => 'ul',
			)
		),
		array(
			'breakpoint'    => 992,
			'settings'      => array(
				'slidesToShow'      => 3,
				'slidesToScroll'    => 1,
				'slide'             => 'ul',
			)
		),
		array(
			'breakpoint'    => 768,
			'settings'      => array(
				'slidesToShow'      => 2,
				'slidesToScroll'    => 1,
				'slide'             => 'ul',
			)
		),
		array(
			'breakpoint'    => 480,
			'settings'      => array(
				'slidesToShow'      => 1,
				'slidesToScroll'    => 1,
				'slide'             => 'ul',
			)
		)
	)
);

if ( $products->have_posts() ) : ?>
<div class="woo_related_products">
    <div class="row">
        <div class="large-centered columns carousel-control-style-2">
            <div class="related-heading"><h2><?php esc_html_e( 'Related Products', 'arw-leka' ); ?></h2></div>
            <div data-slider_config="<?php echo esc_attr(json_encode($slide_config));?>" id="related-products-carousel" class="arexworks-slick-slider related products products-grid product-carousel">
                <?php while ( $products->have_posts() ) : $products->the_post(); ?>
                    <ul class="slick-inner-item"><?php wc_get_template_part( 'content', 'product' ); ?></ul>
                <?php endwhile; // end of the loop. ?>
            </div>
        </div>
    </div>
</div>
<?php endif;

wp_reset_postdata();
