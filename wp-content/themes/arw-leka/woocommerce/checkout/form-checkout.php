<?php
/**
 * Checkout Form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="row section-before-cart">
	<div class="medium-10 medium-offset-1 columns">
		<div class="row">
			<div class="small-4 columns">
				<div class="arexowrks-icon-box">
					<div class="box-icon"><i class="lnr lnr-cart"></i></div>
					<div class="box-heading">01</div>
					<div class="box-sub-heading"><?php _e( 'Shopping Cart', 'arw-leka' );?></div>
				</div>
			</div>
			<div class="small-4 columns">
				<div class="arexowrks-icon-box active">
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

<?php
wc_print_notices();

do_action( 'woocommerce_before_checkout_form', $checkout );
// If checkout registration is disabled and not logged in, the user cannot checkout
if ( ! $checkout->enable_signup && ! $checkout->enable_guest_checkout && ! is_user_logged_in() ) {
	echo apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'arw-leka' ) );
	return;
}
// filter hook for include new pages inside the payment method
$get_checkout_url = apply_filters( 'woocommerce_get_checkout_url', WC()->cart->get_checkout_url() ); ?>
<div class="row">
    <div class="large-12 columns">
        <form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( $get_checkout_url ); ?>" enctype="multipart/form-data">

            <?php if ( sizeof( $checkout->checkout_fields ) > 0 ) : ?>
                <div class="row">
                    <div class="large-6 columns">
                        <div class="wrapper-checkout-left">
                            <?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>
                            <div class="col2-set" id="customer_details">
                                <div class="col-1 clearfix">
                                    <?php do_action( 'woocommerce_checkout_billing' ); ?>
                                </div>

                                <div class="col-2 clearfix">
                                    <?php do_action( 'woocommerce_checkout_shipping' ); ?>
                                </div>
                            </div>
                            <?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>
                        </div>
                    </div>
                    <div class="large-6 columns">
                        <div class="wrapper-checkout-right">
                            <h3 id="order_review_heading"><?php _e( 'Your order', 'arw-leka' ); ?></h3>
                            <?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

                            <div id="order_review" class="woocommerce-checkout-review-order">
                                <?php do_action( 'woocommerce_checkout_order_review' ); ?>
                            </div>

                            <?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
                        </div>
                    </div>

                </div>
            <?php endif; ?>

        </form>
        <?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
    </div>
</div>
