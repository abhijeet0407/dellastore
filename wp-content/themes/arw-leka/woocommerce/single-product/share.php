<?php
/**
 * Single Product Share
 *
 * Sharing plugins can hook into here or you can add your own code directly.
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<?php do_action( 'woocommerce_share' ); // Sharing plugins can hook into here ?>

<div class="arexworks-single-product-sharing">
	<label><?php esc_html_e( 'Share : ', 'arw-leka' )?></label>
	<?php arexworks_get_social_share_link();?>
</div>