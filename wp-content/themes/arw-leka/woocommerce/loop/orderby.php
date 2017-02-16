<?php
/**
 * Show options for ordering
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$link = arexwoks_get_current_page_url();


?>
<div class="sort-by-wrapper sort-by-orderby">
	<div class="sort-by-label"><?php _e( 'Sort By', 'arw-leka' )?></div>
	<div class="sort-by-content">
		<ul>
			<?php foreach ( $catalog_orderby_options as $id => $name ) : ?>
				<?php
				$active = '';
				if ( $orderby == $id ){
					$active = ' active';
				}
				?>
				<li class="<?php echo esc_attr( $active )?>">
					<a href="<?php echo add_query_arg( 'orderby', $id , $link )?>"><?php echo esc_html( $name ); ?></a>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>
