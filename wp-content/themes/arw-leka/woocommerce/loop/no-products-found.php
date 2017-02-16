<?php
/**
 * Displayed when no products are found matching the current query.
 *
 * Override this template by copying it to yourtheme/woocommerce/loop/no-products-found.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>
<article class="post-loop post post-grid page type-page status-publish hentry">
	<div class="grid-box">
		<div class="post-content">
			<h4 class="entry-title"><?php esc_html_e('Nothing Found','arw-leka')?></h4>
			<div class="post-excerpt">
				<p><?php esc_html_e( 'No products were found matching your selection.', 'arw-leka' ); ?></p>
			</div>
		</div>
	</div>
</article>
