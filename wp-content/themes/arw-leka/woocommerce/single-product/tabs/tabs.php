<?php
/**
 * Single Product tabs
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Filter tabs and allow third parties to add their own
 *
 * Each tab is an array containing title, callback and priority.
 * @see woocommerce_default_product_tabs()
 */
$tabs = apply_filters( 'woocommerce_product_tabs', array() );

if ( ! empty( $tabs ) ) : ?>
<div class="row">
    <div class="large-12 columns">
        <div id="woocommerce-tabs">
            <ul class="resp-tabs-list detail_tab_1">
                <?php foreach ( $tabs as $key => $tab ) : ?>
                    <li class="<?php echo esc_attr( $key ); ?>_tab"><?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', esc_html( $tab['title'] ), $key ); ?></li>
                <?php endforeach; ?>
            </ul>
            <div class="resp-tabs-container detail_tab_1">
                <?php $i = 0;?>
                <?php foreach ( $tabs as $key => $tab ) : $i++;?>
                    <div class="resp-tab-content"<?php echo $i==1 ? ' style="display:block"' : ' style="display:none"' ?>><?php call_user_func( $tab['callback'], $key, $tab ); ?></div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
