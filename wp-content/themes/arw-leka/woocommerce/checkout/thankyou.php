<?php
/**
 * Thankyou page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( $order ) : ?>

	<?php if ( $order->has_status( 'failed' ) ) : ?>

		<p><?php _e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction.', 'arw-leka' ); ?></p>

		<p><?php
			if ( is_user_logged_in() )
				_e( 'Please attempt your purchase again or go to your account page.', 'arw-leka' );
			else
				_e( 'Please attempt your purchase again.', 'arw-leka' );
		?></p>

		<p>
			<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay"><?php _e( 'Pay', 'arw-leka' ) ?></a>
			<?php if ( is_user_logged_in() ) : ?>
			<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button pay"><?php _e( 'My Account', 'arw-leka' ); ?></a>
			<?php endif; ?>
		</p>

	<?php else : ?>

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
						<div class="arexowrks-icon-box">
							<div class="box-icon"><i class="lnr lnr-menu"></i></div>
							<div class="box-heading">02</div>
							<div class="box-sub-heading"><?php _e( 'Check out', 'arw-leka' );?></div>
						</div>
					</div>
					<div class="small-4 columns">
						<div class="arexowrks-icon-box active">
							<div class="box-icon"><i class="lnr lnr-checkmark-circle"></i></div>
							<div class="box-heading">03</div>
							<div class="box-sub-heading"><?php _e( 'Order Complete', 'arw-leka' );?></div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<p><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', __( 'Thank you. Your order has been received.', 'arw-leka' ), $order ); ?></p>

		<ul class="order_details">
			<li class="order">
				<?php _e( 'Order Number:', 'arw-leka' ); ?>
				<strong><?php echo $order->get_order_number(); ?></strong>
			</li>
			<li class="date">
				<?php _e( 'Date:', 'arw-leka' ); ?>
				<strong><?php echo date_i18n( get_option( 'date_format' ), strtotime( $order->order_date ) ); ?></strong>
			</li>
			<li class="total">
				<?php _e( 'Total:', 'arw-leka' ); ?>
				<strong><?php echo $order->get_formatted_order_total(); ?></strong>
			</li>
			<?php if ( $order->payment_method_title ) : ?>
			<li class="method">
				<?php _e( 'Payment Method:', 'arw-leka' ); ?>
				<strong><?php echo $order->payment_method_title; ?></strong>
			</li>
			<?php endif; ?>
		</ul>
		<div class="clear"></div>

	<?php endif; ?>

	<?php do_action( 'woocommerce_thankyou_' . $order->payment_method, $order->id ); ?>
	<?php do_action( 'woocommerce_thankyou', $order->id ); ?>

<?php else : ?>

	<p><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', __( 'Thank you. Your order has been received.', 'arw-leka' ), null ); ?></p>

<?php endif; ?>