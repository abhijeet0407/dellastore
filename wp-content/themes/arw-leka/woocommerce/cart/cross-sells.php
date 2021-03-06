<?php
/**
 * Cross-sells
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $woocommerce_loop;

$crosssells = WC()->cart->get_cross_sells();

if ( sizeof( $crosssells ) == 0 ) return;

$meta_query = WC()->query->get_meta_query();

$args = array(
	'post_type'           => 'product',
	'ignore_sticky_posts' => 1,
	'no_found_rows'       => 1,
	'posts_per_page'      => apply_filters( 'woocommerce_cross_sells_total', $posts_per_page ),
	'orderby'             => $orderby,
	'post__in'            => $crosssells,
	'meta_query'          => $meta_query
);

$products = new WP_Query( $args );

$woocommerce_loop['columns'] = apply_filters( 'woocommerce_cross_sells_columns', $columns );

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
    <div class="woo_cross_sell_products">
        <div class="row">
            <div class="large-centered columns carousel-control-style-2">
	            <div class="related-heading">
		            <h2><?php _e( 'You may be interested in&hellip;', 'arw-leka' ) ?></h2>
	            </div>
                <div data-slider_config="<?php echo esc_attr(json_encode($slide_config));?>" id="cross-sell-products-carousel" class="cross-sells products products products-grid product-carousel arexworks-slick-slider">
                    <?php while ( $products->have_posts() ) : $products->the_post(); ?>
                        <ul class="slick-inner-item"><?php wc_get_template_part( 'content', 'product' ); ?></ul>
                    <?php endwhile; // end of the loop. ?>
                </div>
            </div>
        </div>
    </div>
<?php endif;

wp_reset_postdata();
