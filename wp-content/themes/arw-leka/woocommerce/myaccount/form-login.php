<?php
/**
 * Login Form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<?php wc_print_notices(); ?>

<?php do_action( 'woocommerce_before_customer_login_form' ); ?>

<div class="row form-login-register">
    <div class="large-8 large-offset-2 columns">
        <div class="row" id="customer_login">
            <div class="large-5 columns">
                <h2 class="highlight-font-family"><?php esc_html_e( 'Sign In', 'arw-leka' ); ?></h2>
            </div>
            <div class="large-6 columns">
                <form method="post" class="login">

                    <?php do_action( 'woocommerce_login_form_start' ); ?>

                    <p class="form-row form-row-wide">
                        <label for="username"><?php esc_html_e( 'Username or email address', 'arw-leka' ); ?> <span class="required">*</span></label>
                        <input type="text" class="input-text" name="username" id="username" value="<?php if ( ! empty( $_POST['username'] ) ) echo esc_attr( $_POST['username'] ); ?>" />
                    </p>
                    <p class="form-row form-row-wide">
                        <label for="password"><?php esc_html_e( 'Password', 'arw-leka' ); ?> <span class="required">*</span></label>
                        <input class="input-text" type="password" name="password" id="password" />
                    </p>

                    <?php do_action( 'woocommerce_login_form' ); ?>
                    <p class="form-row">
                        <label for="rememberme" class="left">
                            <input name="rememberme" type="checkbox" id="rememberme" value="forever" /> <?php esc_html_e( 'Remember me', 'arw-leka' ); ?>
                        </label>
                        <label class="right"><a class="lost_password" href="<?php echo esc_url( wc_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'arw-leka' ); ?></a></label>
                    </p>
                    <p class="form-row">
                        <?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
                        <input type="submit" class="button secondary large" name="login" value="<?php esc_html_e( 'Sign In', 'arw-leka' ); ?>" />
                    </p>

                    <?php do_action( 'woocommerce_login_form_end' ); ?>

                </form>
            </div>
        </div>
        <?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>
        <div class="row" id="customer_register">
            <div class="large-5 columns">
                <h2 class="highlight-font-family"><?php esc_html_e( 'Sign Up', 'arw-leka' ); ?></h2>
                <div class="text-right">
                    <?php esc_html_e('To receive news, notfications and access to many of our features. For free, of course.','arw-leka');?>
                </div>
            </div>
            <div class="large-6 columns">
                <form method="post" class="register">

                    <?php do_action( 'woocommerce_register_form_start' ); ?>

                    <?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>

                        <p class="form-row form-row-wide">
                            <label for="reg_username"><?php esc_html_e( 'Username', 'arw-leka' ); ?> <span class="required">*</span></label>
                            <input type="text" class="input-text" name="username" id="reg_username" value="<?php if ( ! empty( $_POST['username'] ) ) echo esc_attr( $_POST['username'] ); ?>" />
                        </p>

                    <?php endif; ?>

                    <p class="form-row form-row-wide">
                        <label for="reg_email"><?php esc_html_e( 'Email address', 'arw-leka' ); ?> <span class="required">*</span></label>
                        <input type="email" class="input-text" name="email" id="reg_email" value="<?php if ( ! empty( $_POST['email'] ) ) echo esc_attr( $_POST['email'] ); ?>" />
                    </p>

                    <?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>

                        <p class="form-row form-row-wide">
                            <label for="reg_password"><?php esc_html_e( 'Password', 'arw-leka' ); ?> <span class="required">*</span></label>
                            <input type="password" class="input-text" name="password" id="reg_password" />
                        </p>

                    <?php endif; ?>

                    <!-- Spam Trap -->
                    <div style="<?php echo ( ( is_rtl() ) ? 'right' : 'left' ); ?>: -999em; position: absolute;"><label for="trap"><?php esc_html_e( 'Anti-spam', 'arw-leka' ); ?></label><input type="text" name="email_2" id="trap" tabindex="-1" /></div>

                    <?php do_action( 'woocommerce_register_form' ); ?>
                    <?php do_action( 'register_form' ); ?>

                    <p class="form-row">
                        <?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
                        <input type="submit" class="button secondary large" name="register" value="<?php esc_html_e( 'Register', 'arw-leka' ); ?>" />
                    </p>

                    <?php do_action( 'woocommerce_register_form_end' ); ?>

                </form>
            </div>
        </div>
        <?php endif;?>
    </div>
</div>
<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
