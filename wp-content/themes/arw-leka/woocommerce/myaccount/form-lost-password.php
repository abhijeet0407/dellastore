<?php
/**
 * Lost password form
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<?php wc_print_notices(); ?>

<div class="row">
    <div class="column">
        <form method="post" class="woocommerce-ResetPassword lost_reset_password login">

            <p><?php echo apply_filters( 'woocommerce_lost_password_message', __( 'Lost your password? Please enter your username or email address. You will receive a link to create a new password via email.', 'arw-leka' ) ); ?></p>

            <p class="form-row">
                <label for="user_login"><?php _e( 'Username or email', 'arw-leka' ); ?></label>
                <input class="input-text" type="text" name="user_login" id="user_login" />
            </p>

            <div class="clear"></div>

            <?php do_action( 'woocommerce_lostpassword_form' ); ?>

            <p class="form-row">
                <input type="hidden" name="wc_reset_password" value="true" />
                <input type="submit" class="button" value="<?php echo 'lost_password' == $args['form'] ? __( 'Reset Password', 'arw-leka' ) : __( 'Save', 'arw-leka' ); ?>" />
            </p>

            <?php wp_nonce_field( 'lost_password' ); ?>

        </form>
    </div>
</div>
