<?php
/**
 * Woocommerce Compare page
 *
 * @author Your Inspiration Themes
 * @package YITH Woocommerce Compare
 * @version 1.1.4
 */

// remove the style of woocommerce
if( defined('WOOCOMMERCE_USE_CSS') && WOOCOMMERCE_USE_CSS ) wp_dequeue_style('woocommerce_frontend_styles');

$is_iframe = (bool)( isset( $_REQUEST['iframe'] ) && $_REQUEST['iframe'] );

wp_enqueue_script( 'jquery-fixedheadertable', trailingslashit(YITH_WOOCOMPARE_ASSETS_URL) . 'js/jquery.dataTables.min.js', array('jquery'), '1.3', true );
wp_enqueue_script( 'jquery-fixedcolumns', trailingslashit(YITH_WOOCOMPARE_ASSETS_URL) . 'js/FixedColumns.min.js', array('jquery', 'jquery-fixedheadertable'), '1.3', true );

$widths = array();
foreach( $products as $product ) $widths[] = '{ "sWidth": "205px", resizeable:true }';

/** FIX WOO 2.1 */
$wc_get_template = function_exists('wc_get_template') ? 'wc_get_template' : 'woocommerce_get_template';

$table_text = get_option( 'yith_woocompare_table_text' );
$localized_table_text = function_exists( 'icl_translate' ) ? icl_translate( 'Plugins', 'plugin_yit_compare_table_text', $table_text ) : $table_text;

?><!DOCTYPE html>
<!--[if IE 6]>
<html id="ie6" class="ie"<?php language_attributes() ?>>
<![endif]-->
<!--[if IE 7]>
<html id="ie7" class="ie"<?php language_attributes() ?>>
<![endif]-->
<!--[if IE 8]>
<html id="ie8" class="ie"<?php language_attributes() ?>>
<![endif]-->
<!--[if IE 9]>
<html id="ie9" class="ie"<?php language_attributes() ?>>
<![endif]-->
<!--[if gt IE 9]>
<html class="ie"<?php language_attributes() ?>>
<![endif]-->
<!--[if !IE]>
<html <?php language_attributes() ?>>
<![endif]-->

<!-- START HEAD -->
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta name="viewport" content="width=device-width" />
    <title><?php esc_html_e( 'Product Comparison', 'arw-leka' ) ?></title>
    <link rel="profile" href="http://gmpg.org/xfn/11" />

	<link rel="stylesheet" href="<?php echo trailingslashit(get_template_directory_uri()) ?>assets/css/compare.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo trailingslashit(get_template_directory_uri()) ?>assets/css/font-awesome.min.css" type="text/css" />

    <?php wp_head() ?>

    <style type="text/css">
        body.loading {
            background: url("<?php echo YITH_WOOCOMPARE_URL ?>assets/images/colorbox/loading.gif") no-repeat scroll center center transparent;
        }
    </style>
</head>
<!-- END HEAD -->

<?php global $product; ?>

<!-- START BODY -->
<body <?php body_class('woocommerce woocommerce-yith-compare') ?>>

<h1>
    <?php echo $localized_table_text ?>
    <?php if ( ! $is_iframe ) : ?><a class="close" href="#"><?php esc_html_e( 'Close window [X]', 'arw-leka' ) ?></a><?php endif; ?>
</h1>

<?php do_action( 'yith_woocompare_before_main_table' ); ?>

<table class="compare-list" cellpadding="0" cellspacing="0"<?php if ( empty( $products ) ) echo ' style="width:100%"' ?>>
    <thead>
    <tr>
        <th>&nbsp;</th>
        <?php foreach( $products as $i => $product ) : ?>
            <td></td>
        <?php endforeach; ?>
    </tr>
    </thead>
    <tfoot>
    <tr>
        <th>&nbsp;</th>
        <?php foreach( $products as $i => $product ) : ?>
            <td></td>
        <?php endforeach; ?>
    </tr>
    </tfoot>
    <tbody>

    <?php if ( empty( $products ) ) : ?>

        <tr class="no-products">
            <td><?php esc_html_e( 'No products added in the compare table.', 'arw-leka' ) ?></td>
        </tr>

    <?php else : ?>
        <tr class="remove">
            <th>&nbsp;</th>
            <?php foreach( $products as $i => $product ) : $product_class = ( $i % 2 == 0 ? 'odd' : 'even' ) . ' product_' . $product->id ?>
                <td class="<?php echo $product_class; ?>">
                    <a href="<?php echo esc_url(add_query_arg( 'redirect', 'view', $this->remove_product_url( $product->id ) )) ?>" data-product_id="<?php echo $product->id; ?>"><?php esc_html_e( 'Remove', 'arw-leka' ) ?> <i class="fa fa-trash-o"></i></a>
                </td>
            <?php endforeach ?>
        </tr>

        <?php foreach ( $fields as $field => $name ) : ?>

            <tr class="<?php echo $field ?>">

                <th>
                    <?php echo $name ?>
                    <?php if ( $field == 'image' ) echo '<div class="fixed-th"></div>'; ?>
                </th>

                <?php foreach( $products as $i => $product ) : $product_class = ( $i % 2 == 0 ? 'odd' : 'even' ) . ' product_' . $product->id; ?>
                    <td class="<?php echo $product_class; ?>"><?php
                        switch( $field ) {

                            case 'image':
                                echo '<div class="image-wrap">' . wp_get_attachment_image( $product->fields[$field], 'shop_catalog' ) . '</div>';
                                break;

                            case 'add-to-cart':
	                            if(!arexworks_get_option_data('catalog_mode',false)) {
		                            $wc_get_template('loop/add-to-cart.php');
	                            }
                                break;

                            default:
                                echo empty( $product->fields[$field] ) ? '&nbsp;' : $product->fields[$field];
                                break;
                        }
                        ?>
                    </td>
                <?php endforeach ?>

            </tr>

        <?php endforeach; ?>

        <?php if ( $repeat_price == 'yes' && isset( $fields['price'] ) ) : ?>
            <tr class="price repeated">
                <th><?php echo $fields['price'] ?></th>

                <?php foreach( $products as $i => $product ) : $product_class = ( $i % 2 == 0 ? 'odd' : 'even' ) . ' product_' . $product->id ?>
                    <td class="<?php echo $product_class ?>"><?php echo $product->fields['price'] ?></td>
                <?php endforeach; ?>

            </tr>
        <?php endif; ?>

        <?php if ( $repeat_add_to_cart == 'yes' && isset( $fields['add-to-cart'] ) && !arexworks_get_option_data('catalog_mode',false) ) : ?>
            <tr class="add-to-cart repeated">
                <th><?php echo $fields['add-to-cart'] ?></th>

                <?php foreach( $products as $i => $product ) : $product_class = ( $i % 2 == 0 ? 'odd' : 'even' ) . ' product_' . $product->id ?>
                    <td class="<?php echo $product_class ?>"><?php $wc_get_template( 'loop/add-to-cart.php' ); ?></td>
                <?php endforeach; ?>

            </tr>
        <?php endif; ?>

    <?php endif; ?>

    </tbody>
</table>

<?php do_action( 'yith_woocompare_after_main_table' ); ?>

<?php if( wp_script_is( 'responsive-theme', 'enqueued' ) ) wp_dequeue_script( 'responsive-theme' ) ?><?php if( wp_script_is( 'responsive-theme', 'enqueued' ) ) wp_dequeue_script( 'responsive-theme' ) ?>
<?php do_action('wp_print_footer_scripts'); ?>

<script type="text/javascript">
	(function($) {
		"use strict";
		$(document).ready(function(){
			<?php if ( $is_iframe ) : ?>$('a').attr('target', '_parent');<?php endif; ?>

			var oTable;
			$('body').on( 'yith_woocompare_render_table', function(){
				if( $( window ).width() > 767  && $('table.compare-list tr.no-products').length == 0) {
					oTable = $('table.compare-list').dataTable( {
						"sScrollX": "100%",
						//"sScrollXInner": "150%",
						"bScrollInfinite": true,
						"bScrollCollapse": true,
						"bPaginate": false,
						"bSort": false,
						"bInfo": false,
						"bFilter": false,
						"bAutoWidth": false
					} );

					new FixedColumns( oTable );
					$('<table class="compare-list" />').insertAfter( $('h1') ).hide();
				}
			});

			<?php if (!empty( $products ) ) : ?>
			$('body').trigger('yith_woocompare_render_table');
			<?php endif;?>

			// remove add to cart button after added
			$('body').on('added_to_cart', function( ev, fragments, cart_hash, button ){

				<?php if ( $is_iframe ) : ?>

				// Replace fragments
				if ( fragments ) {
					$('.shopping-bag-button .cart-items',window.parent.document).html(fragments.total_item_count);
					$.each(fragments, function(key, value) {
						$(key, window.parent.document).replaceWith(value);
					});
				}
				// Cart page elements
				$( '.shop_table.cart' ,window.parent.document).load( window.parent.location.toString() + ' .shop_table.cart:eq(0) > *', function() {

					$( '.shop_table.cart' , window.parent.document).stop( true ).css( 'opacity', '1' ).unblock();

					$( 'body' , window.parent.document).trigger( 'cart_page_refreshed' );
				});

				$( '.cart_totals' ,window.parent.document).load( window.parent.location.toString() + ' .cart_totals:eq(0) > *', function() {
					$( '.cart_totals' , window.parent.document).stop( true ).css( 'opacity', '1' ).unblock();
				});

				<?php endif; ?>
			});

			// close window
			$(document).on( 'click', 'a.close', function(e){
				e.preventDefault();
				window.close();
			});

			$(window).on( 'yith_woocompare_product_removed', function(){
				if( $( window ).width() > 767 ) {
					oTable.fnDestroy(true);
				}
				$('body').trigger('yith_woocompare_render_table');
			});


			if ( typeof wc_add_to_cart_params === 'undefined' ) {
				return false;
			}else{
				$('.add_to_cart_button').unbind('click').on('click',function(e){

					// AJAX add to cart request
					var $thisbutton = $( this );

					if ( $thisbutton.is( '.product_type_simple' ) ) {

						if ( ! $thisbutton.attr( 'data-product_id' ) ) {
							return true;
						}

						$thisbutton.removeClass( 'added' );
						$thisbutton.addClass( 'loading' );

						var data = {};

						$.each( $thisbutton.data(), function( key, value ) {
							data[key] = value;
						});

						// Trigger event
						$( document.body ).trigger( 'adding_to_cart', [ $thisbutton, data ] );

						// Ajax action
						$.post( wc_add_to_cart_params.wc_ajax_url.toString().replace( '%%endpoint%%', 'add_to_cart' ), data, function( response ) {

							if ( ! response ) {
								return;
							}

							var this_page = window.location.toString();

							this_page = this_page.replace( 'add-to-cart', 'added-to-cart' );

							if ( response.error && response.product_url ) {
								<?php if ( $is_iframe ) : ?>
								window.parent.location = response.product_url;
								<?php else: ?>
								window.location = response.product_url;
								<?php endif;?>
								return;
							}

							// Redirect to cart option
							if ( wc_add_to_cart_params.cart_redirect_after_add === 'yes' ) {
								<?php if ( $is_iframe ) : ?>
								window.parent.location = wc_add_to_cart_params.cart_url;
								<?php else: ?>
								window.location = wc_add_to_cart_params.cart_url;
								<?php endif;?>
								return;

							} else {

								$thisbutton.removeClass( 'loading' );

								var fragments = response.fragments;
								var cart_hash = response.cart_hash;

								// Block fragments class
								if ( fragments ) {
									$.each( fragments, function( key ) {
										$( key ).addClass( 'updating' );
									});
								}

								// Block widgets and fragments
								$( '.shop_table.cart, .updating, .cart_totals' ).fadeTo( '400', '0.6' ).block({
									message: null,
									overlayCSS: {
										opacity: 0.6
									}
								});

								// Changes button classes
								$thisbutton.addClass( 'added' );

								// View cart text
								if ( ! wc_add_to_cart_params.is_cart && $thisbutton.parent().find( '.added_to_cart' ).size() === 0 ) {
									$thisbutton.after( ' <a href="' + wc_add_to_cart_params.cart_url + '" class="added_to_cart wc-forward" title="' +
									wc_add_to_cart_params.i18n_view_cart + '">' + wc_add_to_cart_params.i18n_view_cart + '</a>' );
								}

								// Replace fragments
								if ( fragments ) {
									$.each( fragments, function( key, value ) {
										$( key ).replaceWith( value );
									});
								}

								// Unblock
								$( '.widget_shopping_cart, .updating' ).stop( true ).css( 'opacity', '1' ).unblock();

								// Cart page elements
								$( '.shop_table.cart' ).load( this_page + ' .shop_table.cart:eq(0) > *', function() {

									$( '.shop_table.cart' ).stop( true ).css( 'opacity', '1' ).unblock();

									$( document.body ).trigger( 'cart_page_refreshed' );
								});

								$( '.cart_totals' ).load( this_page + ' .cart_totals:eq(0) > *', function() {
									$( '.cart_totals' ).stop( true ).css( 'opacity', '1' ).unblock();
								});

								// Trigger event so themes can refresh other areas
								$( document.body ).trigger( 'added_to_cart', [ fragments, cart_hash, $thisbutton ] );
							}
						});

						return false;

					}

					return true;
				});
			}

		});
	})(jQuery);
</script>

</body>
</html>