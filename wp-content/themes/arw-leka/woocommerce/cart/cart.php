<?php
/**
 * Cart Page
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.3.8
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

wc_print_notices();

do_action( 'woocommerce_before_cart' ); ?>
<div class="row section-before-cart">
	<div class="medium-10 medium-offset-1 columns">
		<div class="row">
			<div class="small-4 columns">
				<div class="arexowrks-icon-box active">
					<div class="box-icon"><i class="lnr lnr-cart"></i></div>
					<div class="box-heading">01</div>
					<div class="box-sub-heading"><?php _e( 'Shopping Cart', 'arw-leka' );?></div>
				</div>
			</div>
			<div class="small-4 columns">
				<div class="arexowrks-icon-box">
					<div class="box-icon"><i class="lnr lnr-menu"></i></div>
					<div class="box-heading">02</div>
					<div class="box-sub-heading"><?php _e( 'Check out', 'arw-leka' );?></div>
				</div>
			</div>
			<div class="small-4 columns">
				<div class="arexowrks-icon-box">
					<div class="box-icon"><i class="lnr lnr-checkmark-circle"></i></div>
					<div class="box-heading">03</div>
					<div class="box-sub-heading"><?php _e( 'Order Complete', 'arw-leka' );?></div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
    <div class="large-12 columns">
        <form id="form_cart_action_ref" action="<?php echo esc_url( WC()->cart->get_cart_url() ); ?>" method="post">

            <?php do_action( 'woocommerce_before_cart_table' ); ?>

            <table class="shop_table cart" cellspacing="0">
                <thead>
                <tr>
                    <th class="product-thumbnail">&nbsp;</th>
                    <th class="product-name"><?php _e( 'Product', 'arw-leka' ); ?></th>
                    <th class="product-price"><?php _e( 'Price', 'arw-leka' ); ?></th>
                    <th class="product-quantity"><?php _e( 'Quantity', 'arw-leka' ); ?></th>
                    <th class="product-subtotal"><?php _e( 'Total', 'arw-leka' ); ?></th>
                    <th class="product-remove">&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                <?php do_action( 'woocommerce_before_cart_contents' ); ?>

                <?php
                foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
                    $_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
                    $product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

                    if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
                        ?>
                        <tr class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

                            <td class="product-thumbnail">
                                <?php
                                $thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

                                if ( ! $_product->is_visible() ) {
                                    echo $thumbnail;
                                } else {
                                    printf( '<a href="%s">%s</a>', esc_url( $_product->get_permalink( $cart_item ) ), $thumbnail );
                                }
                                ?>
                            </td>

                            <td class="product-name">
                                <?php
                                if ( ! $_product->is_visible() ) {
                                    echo apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key ) . '&nbsp;';
                                } else {
                                    echo apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s </a>', esc_url( $_product->get_permalink( $cart_item ) ), $_product->get_title() ), $cart_item, $cart_item_key );
                                }

                                // Meta data
                                echo WC()->cart->get_item_data( $cart_item );

                                // Backorder notification
                                if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
                                    echo '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'arw-leka' ) . '</p>';
                                }
                                ?>
                            </td>

                            <td class="product-price">
                                <?php
                                echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
                                ?>
                            </td>

                            <td class="product-quantity">
                                <?php
                                if ( $_product->is_sold_individually() ) {
                                    $product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
                                } else {
                                    $product_quantity = woocommerce_quantity_input( array(
                                        'input_name'  => "cart[{$cart_item_key}][qty]",
                                        'input_value' => $cart_item['quantity'],
                                        'max_value'   => $_product->backorders_allowed() ? '' : $_product->get_stock_quantity(),
                                        'min_value'   => '0'
                                    ), $_product, false );
                                }

                                echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key );
                                ?>
                            </td>

                            <td class="product-subtotal">
                                <?php
                                echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
                                ?>
                            </td>

                            <td class="product-remove">
                                <?php
                                echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf( '<a onclick="if(confirm(\'%s\') != true){ return false; }" href="%s" class="remove" title="%s"><i class="fa fa-times"></i></a>', __('Do you want remove this item ?','arw-leka') , esc_url( WC()->cart->get_remove_url( $cart_item_key ) ), __( 'Remove this item', 'arw-leka' ) ), $cart_item_key );
                                ?>
                            </td>
                        </tr>
                    <?php
                    }
                }

                do_action( 'woocommerce_cart_contents' );
                ?>
                <tr>
                    <td colspan="6" class="actions">
                    <?php
                        $continue_shopping_url = home_url('/');
                        if( $shop_page_url  = arexworks_translate_id(wc_get_page_id( 'shop' ))){
                            $continue_shopping_url = get_permalink($shop_page_url);
                        }
                        ?>
                        <input type="button" class="button button-continue-shopping" value="<?php _e('Continue Shopping', 'arw-leka')?>" onclick="window.location.href='<?php echo $continue_shopping_url?>';"/>
                        <input onclick="if(confirm('<?php _e('Are you sure ?','arw-leka')?>') != true){ return false;}" type="submit" class="button button-clear-cart" name="clear-cart" value="<?php _e('Empty Cart', 'arw-leka'); ?>" />
	                    <input type="submit" class="button button-update-cart" name="update_cart" value="<?php _e( 'Update Cart', 'arw-leka' ); ?>" />
                        <?php do_action( 'woocommerce_cart_actions' ); ?>

                        <?php wp_nonce_field( 'woocommerce-cart' ); ?>
                    </td>
                </tr>

                <?php do_action( 'woocommerce_after_cart_contents' ); ?>
                </tbody>
            </table>

            <?php do_action( 'woocommerce_after_cart_table' ); ?>

        </form>
    </div>
</div>
<div class="row">
    <?php if ( WC()->cart->coupons_enabled() ) { ?>
    <div class="large-4 columns">
        <form action="<?php echo esc_url( WC()->cart->get_cart_url() ); ?>" method="post">
            <div class="coupon-box">
                <h4><?php _e('Discount Codes','arw-leka');?></h4>
                <div class="coupon">
                    <label for="coupon_code_duplicate"><?php _e( 'Enter your coupon code if you have one.', 'woocommerce' ); ?></label>
                    <input type="text" name="coupon_code" class="input-text" id="coupon_code_duplicate" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" />
                    <input id="coupon_code_duplicate" type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e( 'Apply Coupon', 'woocommerce' ); ?>" />
                    <?php do_action( 'woocommerce_cart_coupon' ); ?>
                </div>
            </div>
        </form>
    </div>
    <?php } ?>

	<div class="large-4 columns">
		<div class="cart-collaterals">
			<?php woocommerce_cart_totals();?>
		</div>
	</div>
</div>


<div class="cart-collaterals">
    <div class="row">
        <div class="large-12 columns">
            <?php woocommerce_cross_sell_display(10);?>
        </div>
    </div>
	<?php do_action( 'woocommerce_cart_collaterals' ); ?>

</div>

<?php do_action( 'woocommerce_after_cart' ); ?>
