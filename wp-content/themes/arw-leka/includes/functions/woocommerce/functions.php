<?php
if ( !function_exists( 'woocommerce_content' ) ) {

	function woocommerce_content() {

		if ( is_singular( 'product' ) ) {

			while ( have_posts() ) : the_post();

				wc_get_template_part( 'content', 'single-product' );

			endwhile;

		} else { ?>

			<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>

				<h1 class="page-title"><?php woocommerce_page_title(); ?></h1>

			<?php endif; ?>

			<?php do_action( 'woocommerce_archive_description' ); ?>

			<?php if ( have_posts() ) : ?>

				<?php do_action('woocommerce_before_shop_loop'); ?>
				<?php
					wc_get_template_part('product','category-list');
				?>
				<?php woocommerce_product_loop_start(); ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php wc_get_template_part( 'content', 'product' ); ?>

				<?php endwhile; // end of the loop. ?>

				<?php woocommerce_product_loop_end(); ?>

				<?php do_action('woocommerce_after_shop_loop'); ?>

			<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

				<?php wc_get_template( 'loop/no-products-found.php' ); ?>

			<?php endif;

		}
	}
}


if ( !function_exists( 'arexworks_woocommerce_placeholder_img_src' ) ) {
	function arexworks_woocommerce_placeholder_img_src($src){
		$src = arexworks_image . '/placeholder2.jpg';
		return esc_url($src);
	}
}

if ( !function_exists( 'arexworks_woocommerce_add_action_empty_cart_action' ) ) {
	function arexworks_woocommerce_add_action_empty_cart_action()
	{
		global $woocommerce;
		if ( isset( $_REQUEST[ 'clear-cart' ] ) ) {
			$woocommerce->cart->empty_cart();
		}
	}
}

if ( !function_exists( 'arexwokrs_woocommerce_add_filter_woocommerce_pagination_args' ) ) {
	function arexwokrs_woocommerce_add_filter_woocommerce_pagination_args( $args )
	{
		$args[ 'prev_text' ] = __( 'Prev', 'arw-leka' );
		$args[ 'next_text' ] = __( 'Next', 'arw-leka' );
		return $args;
	}
}

if ( !function_exists( 'arexworks_woocommerce_add_filter_woocommerce_product_get_rating_html' ) ) {
	function arexworks_woocommerce_add_filter_woocommerce_product_get_rating_html( $rating_html, $rating )
	{
		if ( $rating > 0 ) {
			$rating_html = '<div class="archive-product-rating">' . $rating_html . '</div>';
		}
		return $rating_html;
	}
}

if ( !function_exists( 'arexworks_woocommerce_add_filter_woocommerce_product_gallery_attachment_ids' ) ) {
	function arexworks_woocommerce_add_filter_woocommerce_product_gallery_attachment_ids( $array, $product )
	{
		if ( $product->is_type( 'variable' ) ) {

			foreach ( $product->get_children() as $child_id ) {
				$variation = $product->get_child( $child_id );

				// Hide out of stock variations if 'Hide out of stock items from the catalog' is checked
				if ( empty( $variation->variation_id ) || ( 'yes' === get_option( 'woocommerce_hide_out_of_stock_items' ) && !$variation->is_in_stock() ) ) {
					continue;
				}

				// Filter 'woocommerce_hide_invisible_variations' to optionally hide invisible variations (disabled variations and variations with empty price)
				if ( apply_filters( 'woocommerce_hide_invisible_variations', false, $product->id, $variation ) && !$variation->variation_is_visible() ) {
					continue;
				}
				if ( is_numeric( $variation ) ) {
					$variation = $this->get_child( $variation );
				}
				if ( has_post_thumbnail( $variation->get_variation_id() ) ) {
					$thumb_id = get_post_thumbnail_id( $variation->get_variation_id() );
					if ( !in_array( $thumb_id, $array ) ) {
						$array[ ] = $thumb_id;
					}
				}
			}
		}
		return $array;
	}
}

if ( !function_exists( 'arexworks_woocommerce_add_to_cart_fragments_custom' ) ) {
	function arexworks_woocommerce_add_to_cart_fragments_custom( $array )
	{
		$array[ 'total_item' ] = count( WC()->cart->get_cart() );
		$array[ 'total_item_count' ] = WC()->cart->cart_contents_count;
		return $array;
	}
}

if ( !function_exists( 'arexworks_woocommerce_add_badge_sale_in_list' ) ) {
	function arexworks_woocommerce_add_badge_sale_in_list( $return, $post, $product )
	{

		$sale = 0;
		$return = '<span class="badge onsale-badge">';
		if ( $product->product_type == 'variable' ) {

			$prices = $product->get_variation_prices( true );
			if ( $prices ) {
				$min_price = current( $prices[ 'price' ] );
				$max_price = end( $prices[ 'price' ] );
				if ( $max_price > 0 ) {
					$sale = ( $max_price - $min_price ) / $max_price;
				}
			}

		} else {
			if($product->get_regular_price()){
				$sale = ( $product->get_regular_price() - $product->get_sale_price() ) / $product->get_regular_price();
			}else{
				$sale = 0;
			}
		}

		if ( $sale > 0 && $sale < 1 ) {
			$return .= '-' . round( ( $sale * 100 ) ) . '%';
		} else {
			$return .= __( 'Sale!', 'arw-leka' );
		}
		$return .= '</span>';

		return $return;
	}
}

if ( !function_exists( 'arexworks_woocommerce_add_badge_new_in_list' ) ) {
	function arexworks_woocommerce_add_badge_new_in_list()
	{
		global $post;
		$post_date = get_the_time( 'Y-m-d', $post );
		$post_date_stamp = strtotime( $post_date );
		$newness = 30;
		if ( ( time() - ( 60 * 60 * 24 * $newness ) ) < $post_date_stamp ) {
			$class = 'badge new-badge';
			echo '<span class="' . $class . '">' . __( 'New', 'arw-leka' ) . '</span>';
		}
	}
}

if ( !function_exists( 'arexworks_woocommerce_override_loop_shop_per_page' ) ) {
	function arexworks_woocommerce_override_loop_shop_per_page( $cols )
	{
		$products_per_page = arexworks_get_option_data( 'products_per_page', '9,15,30' );
		$mode_view = apply_filters( 'arexworks_filter_products_mode_view', 'grid' );
		if ( $mode_view == 'list' ) {
			$products_per_page = arexworks_get_option_data( 'products_per_page_list', '5,10,15' );
		}
		$array_per_page = explode( ',', $products_per_page );
		$array_per_page = array_map( 'trim', $array_per_page );
		$per_page = arexworks_get_option_data( 'products_per_page_default', 9 );
		$per_page = apply_filters( 'arexworks_filter_products_per_page', $per_page );
		if ( $per_page && in_array( $per_page, $array_per_page ) ) {
			return $per_page;
		}
		return $cols;
	}
}

if ( !function_exists( 'arexworks_woocommerce_setcookie_default' ) ) {
	function arexworks_woocommerce_setcookie_default()
	{
		$default_cookie_expire = time() + 3600 * 24 * 30;

		if ( !isset( $_COOKIE[ 'arexworks_products_list_per_page' ] ) ) {
			setcookie(
				'arexworks_products_list_per_page',
				arexworks_get_option_data( 'products_per_page_list_default', 5 ),
				$default_cookie_expire,
				COOKIEPATH
			);
		}
		if ( !isset( $_COOKIE[ 'arexworks_products_grid_per_page' ] ) ) {
			setcookie(
				'arexworks_products_grid_per_page',
				arexworks_get_option_data( 'products_per_page_default', 9 ),
				$default_cookie_expire,
				COOKIEPATH
			);
		}
		if ( !isset( $_COOKIE[ 'arexworks_products_mode_view' ] ) ) {
			setcookie(
				'arexworks_products_mode_view',
				'grid',
				$default_cookie_expire,
				COOKIEPATH
			);
		}

		// check mode_view
		if ( in_array( cookie( 'arexworks_products_mode_view' ), array( 'list', 'grid' ) ) ) {
			add_filter(
				'arexworks_filter_products_mode_view', function ( $per_row ) {
				return cookie( 'arexworks_products_mode_view' );
			}, 99 );
		}
		if ( in_array( get( 'view' ), array( 'list', 'grid' ) ) ) {
			add_filter(
				'arexworks_filter_products_mode_view', function ( $mode ) {
				return get( 'view' );
			}, 99 );
			setcookie(
				'arexworks_products_mode_view',
				get( 'view' ),
				$default_cookie_expire,
				COOKIEPATH
			);
		}

		// Check per_row
		if ( absint( cookie( 'arexworks_products_per_row' ) ) ) {
			add_filter(
				'arexworks_filter_products_per_row', function ( $per_row ) {
				return absint( cookie( 'arexworks_products_per_row' ) );
			}, 99 );
		}
		if ( absint( get( 'per_row' ) ) ) {
			add_filter(
				'arexworks_filter_products_per_row', function ( $per_row ) {
				return absint( get( 'per_row' ) );
			}, 99 );
			setcookie(
				'arexworks_products_per_row',
				absint( get( 'per_row' ) ),
				$default_cookie_expire,
				COOKIEPATH
			);
		}

		// check per_page
		$mode_view = in_array( cookie( 'arexworks_products_mode_view' ), array( 'list', 'grid' ) ) ? cookie( 'arexworks_products_mode_view' ) : 'grid';
		if ( in_array( get( 'view' ), array( 'list', 'grid' ) ) ) {
			$mode_view = get( 'view' );
		}

		if ( $mode_view == 'list' ) {
			if ( absint( cookie( 'arexworks_products_list_per_page' ) ) ) {
				add_filter(
					'arexworks_filter_products_per_page', function ( $per_row ) {
					return absint( cookie( 'arexworks_products_list_per_page' ) );
				}, 99 );
			}
			if ( absint( get( 'per_page' ) ) ) {
				add_filter(
					'arexworks_filter_products_per_page', function ( $per_page ) {
					return absint( get( 'per_page' ) );
				}, 99 );
				setcookie(
					'arexworks_products_list_per_page',
					absint( get( 'per_page' ) ),
					$default_cookie_expire,
					COOKIEPATH
				);
			}
		} else {
			if ( absint( cookie( 'arexworks_products_grid_per_page' ) ) ) {
				add_filter(
					'arexworks_filter_products_per_page', function ( $per_row ) {
					return absint( cookie( 'arexworks_products_grid_per_page' ) );
				}, 99 );
			}
			if ( absint( get( 'per_page' ) ) ) {
				add_filter(
					'arexworks_filter_products_per_page', function ( $per_page ) {
					return absint( get( 'per_page' ) );
				}, 99 );
				setcookie(
					'arexworks_products_grid_per_page',
					absint( get( 'per_page' ) ),
					$default_cookie_expire,
					COOKIEPATH
				);
			}
		}

		// check catalog_orderby
		$catalog_orderby_options = apply_filters(
			'woocommerce_catalog_orderby', array(
			'menu_order' => __( 'Default sorting', 'arw-leka' ),
			'popularity' => __( 'Sort by popularity', 'arw-leka' ),
			'rating'     => __( 'Sort by average rating', 'arw-leka' ),
			'date'       => __( 'Sort by newness', 'arw-leka' ),
			'price'      => __( 'Sort by price: low to high', 'arw-leka' ),
			'price-desc' => __( 'Sort by price: high to low', 'arw-leka' )
		) );
		if ( array_key_exists( cookie( 'woocommerce_default_catalog_orderby' ), $catalog_orderby_options ) ) {
			add_filter(
				'woocommerce_default_catalog_orderby', function ( $orderby ) {
				return cookie( 'woocommerce_default_catalog_orderby' );
			}, 99 );
		}
		if ( array_key_exists( get( 'orderby' ), $catalog_orderby_options ) ) {
			add_filter(
				'woocommerce_default_catalog_orderby', function ( $orderby ) {
				return get( 'orderby' );
			}, 99 );
			setcookie(
				'woocommerce_default_catalog_orderby',
				get( 'orderby' ),
				$default_cookie_expire,
				COOKIEPATH
			);
		}
	}
}

if ( !function_exists( 'arexworks_woocommerce_add_filter_woocommerce_subcategory_count_html' ) ) {
	function arexworks_woocommerce_add_filter_woocommerce_subcategory_count_html( $output, $category )
	{
		return '';
	}
}

if ( !function_exists( 'arexworks_woocommerce_add_toolbar' ) ) {
	function arexworks_woocommerce_add_toolbar()
	{
		wc_get_template( 'loop/toolbar.php' );
	}
}

if ( !function_exists( 'arexworks_woocommerce_add_toolbar_per_page' ) ) {
	function arexworks_woocommerce_add_toolbar_per_page()
	{
		$link = arexwoks_get_current_page_url();
		$link = preg_replace('/\/page\/\d+/','',$link);
		$mode_view = apply_filters( 'arexworks_filter_products_mode_view', 'grid' );
		$products_per_page = arexworks_get_option_data( 'products_per_page', '9,15,30' );
		$per_page = arexworks_get_option_data( 'products_per_page_default', 9 );
		if ( $mode_view == 'list' ) {
			$products_per_page = arexworks_get_option_data( 'products_per_page_list', '5,10,15' );
			$per_page = arexworks_get_option_data( 'products_per_page_list_default', 5 );
		}
		$products_per_page = explode( ',', $products_per_page );
		$products_per_page = array_map( 'trim', $products_per_page );
		$per_page = apply_filters( 'arexworks_filter_products_per_page', $per_page );
		if ( count( $products_per_page ) > 1 ) {
			?>
			<div class="sort-by-wrapper sort-by-per-page">
				<div class="sort-by-label"><?php _e( 'View', 'arw-leka' )?></div>
				<div class="sort-by-content">
					<ul>
						<?php foreach ( $products_per_page as $num ) : ?>
							<li<?php if ( $per_page == $num ) echo ' class="active"'; ?>>
								<a href="<?php echo add_query_arg( 'per_page', $num, $link ) ?>"><?php echo esc_html( $num ); ?></a>
							</li>
						<?php endforeach;?>
					</ul>
				</div>
			</div>
		<?php
		}
	}
}

if ( !function_exists( 'arexworks_woocommerce_add_toolbar_position' ) ) {
	function arexworks_woocommerce_add_toolbar_position()
	{
		$link = arexwoks_get_current_page_url();
		?>
		<div class="sort-by-wrapper sort-by-order">
			<div class="sort-by-label"><?php _e( 'Position', 'arw-leka' )?></div>
			<div class="sort-by-content">
				<ul>
					<li<?php if ( strtolower( get( 'order' ) ) == 'asc' ) echo ' class="active"'; ?>>
						<a href="<?php echo add_query_arg( 'order', 'asc', $link )?>"><?php _e( 'Ascending', 'arw-leka' )?></a>
					</li>
					<li<?php if ( strtolower( get( 'order' ) ) == 'desc' ) echo ' class="active"'; ?>>
						<a href="<?php echo add_query_arg( 'order', 'desc', $link )?>"><?php _e( 'Descending', 'arw-leka' )?></a>
					</li>
				</ul>
			</div>
		</div>
	<?php
	}
}

if ( !function_exists( 'arexworks_woocommerce_add_gridlist_toggle_button' ) ) {
	function arexworks_woocommerce_add_gridlist_toggle_button()
	{
		$mode_views = array(
			'grid' => array(
				__( 'Grid view', 'arw-leka' ),
				'<span><i class="fa fa-th-large"></i></span>'
			),
			'list' => array(
				__( 'List view', 'arw-leka' ),
				'<span><i class="fa fa-th-list"></i></span>'
			)
		);
		$active = apply_filters( 'arexworks_filter_products_mode_view', 'grid' );

		$form_action = arexwoks_get_current_page_url();
		$form_action = remove_query_arg( array( 'per_page', 'page', 'paged' ) , $form_action );
		$form_action = preg_replace('/\/page\/\d+/','',$form_action);
		?>
		<div class="gridlist-toggle-wrapper">
			<nav class="gridlist_toggle">
				<?php foreach ( $mode_views as $k => $v ) { ?>
					<a id="<?php echo esc_attr( $k ); ?>" <?php echo ( $active == $k ) ? 'class="active" href="javascript:;"' : 'href="' . add_query_arg( 'view', $k, $form_action ) . '"' ?>
					   title="<?php echo esc_attr( $v[ 0 ] ) ?>"><?php echo $v[ 1 ] ?></a>
				<?php }?>
			</nav>
		</div>
	<?php
	}
}

if ( !function_exists( 'arexworks_woocommerce_add_filter_attribute_on_toolbar' ) ) {
	function arexworks_woocommerce_add_filter_attribute_on_toolbar()
	{
		ob_start();
		if ( is_active_sidebar( 'shop-filter' ) ) {
			dynamic_sidebar( 'shop-filter' );
		}
		$return = ob_get_clean();
		echo balanceTags( $return, true );
	}
}

if ( !function_exists( 'arexworks_woocommerce_get_catalog_ordering_args' ) ) {
	function arexworks_woocommerce_get_catalog_ordering_args( $args )
	{
		$orderby_value = isset( $_GET[ 'orderby' ] ) ? wc_clean( $_GET[ 'orderby' ] ) : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );
		$orderby_value = explode( '-', $orderby_value );
		$orderby = esc_attr( $orderby_value[ 0 ] );

		if ( in_array( strtoupper( get( 'order' ) ), array( 'DESC', 'ASC' ) ) ) {
			$order = strtoupper( get( 'order' ) );
		} else {
			$order = !empty( $orderby_value[ 1 ] ) ? $orderby_value[ 1 ] : 'ASC';
		}
		$args[ 'order' ] = $order;
		switch ( $orderby ) {
			case 'popularity' :
				add_filter( 'posts_clauses', 'arexworks_woocommerce_add_filter_order_by_popularity_post_clauses' );
				break;
			case 'rating' :
				add_filter( 'posts_clauses', 'arexworks_woocommerce_add_filter_order_by_rating_post_clauses' );
				break;
		}

		return $args;
	}
}

if ( !function_exists( 'arexworks_woocommerce_add_filter_order_by_popularity_post_clauses' ) ) {
	function arexworks_woocommerce_add_filter_order_by_popularity_post_clauses( $args )
	{
		global $wpdb;
		$order = in_array( strtoupper( get( 'order' ) ), array( 'DESC', 'ASC' ) ) ? strtoupper( get( 'order' ) ) : 'DESC';
		if(isset($args[ 'orderby' ])){
			if( strpos($args['orderby'], "$wpdb->postmeta.meta_value+0") !== FALSE ){
				$args[ 'orderby' ] = "$wpdb->postmeta.meta_value+0 $order, $wpdb->posts.post_date DESC";
			}
		}

		return $args;
	}
}

if ( !function_exists( 'arexworks_woocommerce_add_filter_order_by_rating_post_clauses' ) ) {
	function arexworks_woocommerce_add_filter_order_by_rating_post_clauses( $args )
	{
		global $wpdb;
		$order = in_array( strtoupper( get( 'order' ) ), array( 'DESC', 'ASC' ) ) ? strtoupper( get( 'order' ) ) : 'DESC';
		if(isset($args[ 'orderby' ])) {
			if( strpos($args['orderby'], "average_rating") !== FALSE ){
				$args['orderby'] = "average_rating $order, $wpdb->posts.post_date DESC";
			}
		}
		return $args;
	}
}

if ( !function_exists( 'arexworks_woocommerce_add_filter_woocommerce_loop_add_to_cart_link' ) ) {
	function arexworks_woocommerce_add_filter_woocommerce_loop_add_to_cart_link( $output, $product )
	{
		$add_to_cart_text = '<span><span><span class="icon"><i class="fa fa-cart-plus"></i></span><span class="text">' . esc_html( $product->add_to_cart_text() ) . '</span></span></span>';
		$class = implode( ' ', array_filter( array(
				'button',
				'product_type_' . $product->product_type,
				$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : 'add_to_cart_button',
				(method_exists($product,'supports') && $product->supports( 'ajax_add_to_cart' ) ? 'ajax_add_to_cart' : '' )
		) ) );

		$output = sprintf(
			'<div class="button-wrapper"><a href="%s" rel="nofollow" data-product_title="%s" data-product_id="%s" data-product_sku="%s" data-quantity="%s" class="%s">%s</a></div>',
			esc_url( $product->add_to_cart_url() ),
			esc_attr( $product->get_title() ),
			esc_attr( $product->id ),
			esc_attr( $product->get_sku() ),
			esc_attr( isset( $quantity ) ? $quantity : 1 ),
			esc_attr( $class ),
			$add_to_cart_text
		);
		return $output;
	}
}

if ( !function_exists( 'arexworks_woocommerce_add_button_compare_in_list' ) ) {
	function arexworks_woocommerce_add_button_compare_in_list()
	{
		global $yith_woocompare, $product;
		$button = '';
		if ( is_object($yith_woocompare) ) {

			$action_add = 'yith-woocompare-add-product';
			if(is_object($yith_woocompare->obj) && get_class($yith_woocompare->obj) == 'YITH_Woocompare_Frontend'){
				$action_add = $yith_woocompare->obj->action_add;
			}
			$url_args = array(
					'action' => $action_add,
					'id' => $product->id
			);
			$add_product_url = apply_filters( 'yith_woocompare_add_product_url', wp_nonce_url( add_query_arg( $url_args  ), $action_add ) );

			$button = sprintf(
				'<div class="%s"><a class="%s" href="%s" title="%s" rel="nofollow" data-product_title="%s" data-product_id="%s"><span><span>%s</span></span></a></div>',
				"button-wrapper",
				"add_compare button",
				esc_url($add_product_url),
				__( 'Add to Compare', 'arw-leka' ),
				esc_attr( $product->get_title() ),
				esc_attr( $product->id ),
				'<span class="icon"><i class="fa fa-random"></i></span><span class="text">' . __( 'Compare', 'arw-leka' ) . '</span>'
			);
		}
		echo $button;
	}
}

if ( !function_exists( 'arexworks_woocommerce_add_button_wishlist_in_list' ) ) {
	function arexworks_woocommerce_add_button_wishlist_in_list()
	{
		global $yith_wcwl, $product;
		$button = '';
		if ( function_exists('YITH_WCWL') ) {
			$default_wishlists = is_user_logged_in() ? YITH_WCWL()->get_wishlists( array( 'is_default' => true ) ) : false;
			if( ! empty( $default_wishlists ) ){
				$default_wishlist = $default_wishlists[0]['ID'];
			}
			else{
				$default_wishlist = false;
			}
			$exists = YITH_WCWL()->is_product_in_wishlist( $product->id, $default_wishlist );

			if($exists){
				$text = __('View Wishlist', 'arw-leka');
				$class = 'add_wishlist button added';
				$url = YITH_WCWL()->get_wishlist_url();
			}else{
				$text = __('Add Wishlist', 'arw-leka');
				$class = 'add_wishlist button';
				$url = add_query_arg( 'add_to_wishlist', $product->id , YITH_WCWL()->get_wishlist_url() );
			}
			$button = sprintf(
				'<div class="%s"><a class="%s" href="%s" title="%s" data-product-type="%s" rel="nofollow" data-product_title="%s" data-product_id="%s"><span><span>%s</span></span></a></div>',
				"button-wrapper",
				esc_attr( $class ),
				esc_url( $url ),
				esc_attr( $text ),
				esc_attr( $product->product_type ),
				esc_attr( $product->get_title() ),
				esc_attr( $product->id ),
				'<span class="icon"><i class="fa fa-heart-o"></i></span><span class="text">' . esc_html($text) . '</span>'
			);
		}
		echo $button;
	}
}

if ( !function_exists( 'arexworks_woocommerce_add_button_quick_view_in_list' ) ) {
	function arexworks_woocommerce_add_button_quick_view_in_list()
	{
		global $product;
		echo $button = sprintf(
			'<div class="%s"><a class="%s" data-href="%s" href="%s" title="%s" rel="nofollow"  data-product_title="%s" data-product-id="%s"><span><span>%s</span></span></a></div>',
			"button-wrapper",
			"quickview button arexworks-quickview-button",
			esc_url( add_query_arg( 'product_quickview', $product->id, get_permalink( $product->id ) ) ),
			get_permalink( $product->id ),
			__( 'Quick View', 'arw-leka' ),
			esc_attr( $product->get_title() ),
			esc_attr( $product->id ),
			'<span class="icon"><i class="fa fa-eye"></i></span><span class="text">' . __( 'Quick View', 'arw-leka' ) . '</span>'
		);
	}
}

if ( !function_exists( 'arexworks_woocommerce_add_short_description_in_list' ) ) {
	function arexworks_woocommerce_add_short_description_in_list()
	{
		global $post;
		if ( $post->post_excerpt ) {
			echo '<div class="product_description">' . apply_filters( 'woocommerce_short_description', $post->post_excerpt ) . '</div>';
		}
	}
}

if ( !function_exists( 'arexworks_woocommerce_add_button_compare_in_detail' ) ) {
	function arexworks_woocommerce_add_button_compare_in_detail()
	{
		global $yith_woocompare, $product;
		$button = '';
        if ( is_object($yith_woocompare) ) {
            $action_add = 'yith-woocompare-add-product';
            if(is_object($yith_woocompare->obj) && get_class($yith_woocompare->obj) == 'YITH_Woocompare_Frontend'){
                $action_add = $yith_woocompare->obj->action_add;
            }
            $url_args = array(
                'action' => $action_add,
                'id' => $product->id
            );
            $add_product_url = apply_filters( 'yith_woocompare_add_product_url', wp_nonce_url( add_query_arg( $url_args  ), $action_add ) );

			$button = sprintf(
				'<div class="%s"><a class="%s" href="%s" title="%s" rel="nofollow" data-product_title="%s" data-product_id="%s"><span><span>%s</span></span></a></div>',
				"button-wrapper",
				"add_compare",
                esc_url( $add_product_url ),
				__( 'Add to Compare', 'arw-leka' ),
				esc_attr( $product->get_title() ),
				esc_attr( $product->id ),
				'<span class="icon"><i class="fa fa-random"></i></span><span class="text">' . __( 'Add to Compare', 'arw-leka' ) . '</span>'
			);
		}
		echo $button;
	}
}

if ( !function_exists( 'arexworks_woocommerce_add_button_wishlist_in_detail' ) ) {
	function arexworks_woocommerce_add_button_wishlist_in_detail()
	{
		global $yith_wcwl, $product;
		$button = '';
        if ( function_exists('YITH_WCWL') ) {

            $default_wishlists = is_user_logged_in() ? YITH_WCWL()->get_wishlists( array( 'is_default' => true ) ) : false;
            if( ! empty( $default_wishlists ) ){
                $default_wishlist = $default_wishlists[0]['ID'];
            }
            else{
                $default_wishlist = false;
            }
            $exists = YITH_WCWL()->is_product_in_wishlist( $product->id, $default_wishlist );

            if($exists){
                $text = __('View Wishlist', 'arw-leka');
                $class = 'add_wishlist added';
                $url = YITH_WCWL()->get_wishlist_url();
            }else{
                $text = __('Add to Wishlist', 'arw-leka');
                $class = 'add_wishlist';
                $url = add_query_arg( 'add_to_wishlist', $product->id , YITH_WCWL()->get_wishlist_url() );
            }

			$button = sprintf(
				'<div class="%s"><a class="%s" href="%s" title="%s" data-product-type="%s" rel="nofollow" data-product_title="%s" data-product_id="%s"><span><span>%s</span></span></a></div>',
				"button-wrapper",
				esc_attr( $class ),
				esc_url( $url ),
				esc_attr( $text ),
				esc_attr( $product->product_type ),
				esc_attr( $product->get_title() ),
				esc_attr( $product->id ),
				'<span class="icon"><i class="fa fa-heart-o"></i></span><span class="text">' . esc_html($text) . '</span>'
			);
		}
		echo $button;
	}
}

if ( !function_exists( 'arexworks_woocommerce_custom_stock_html' ) ) {
	function arexworks_woocommerce_custom_stock_html()
	{
		if ( is_product() ) {
			global $product;
			// Availability
			$availability = $product->get_availability();
			$availability_html = empty( $availability[ 'availability' ] ) ? '' : '<p class="stock ' . esc_attr( $availability[ 'class' ] ) . '"><span>' . __( 'Availability:', 'arw-leka' ) . '</span> ' . esc_html( $availability[ 'availability' ] ) . '</p>';
			echo $availability_html;
		}
	}
}

if ( !function_exists( 'arexworks_woocommerce_custom_html_service_bellow_add_cart' ) ) {
	function arexworks_woocommerce_custom_html_service_bellow_add_cart()
	{
		if ( is_product() ) {
			$content = arexworks_get_option_data( 'custom_html_service_bellow_add_cart' );
			echo '<div class="custom_html_service_bellow_add_cart">';
			echo balanceTags( arexworks_add_formatting( $content ) );
			echo '</div>';
		}
	}
}

if ( !function_exists( 'arexworks_woocommerce_show_upsell_related_products' ) ) {
	function arexworks_woocommerce_show_upsell_related_products()
	{
		if ( !arexworks_get_option_data( 'related_products' ) ) {
			remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
		}
		if ( !arexworks_get_option_data( 'upsell_products' ) ) {
			remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
		}
	}
}

if ( !function_exists( 'arexworks_woocommerce_add_filter_product_tabs' ) ) {
	function arexworks_woocommerce_add_filter_product_tabs( $tabs )
	{
		global $product, $post;
		if ( arexworks_get_option_data( 'custom_tab' ) ) {
			$tabs[ 'custom_tab' ] = array(
				'title'    => arexworks_get_option_data( 'custom_tab_title', 'Custom Tab' ),
				'priority' => 50,
				'callback' => 'arexworks_woocommerce_add_custom_product_tab_callback'
			);
		}
		if ( !arexworks_get_option_data( 'review_tab' ) ) {
			if ( isset( $tabs[ 'reviews' ] ) ) {
				unset( $tabs[ 'reviews' ] );
			}
		}
		return $tabs;
	}
}

if ( !function_exists( 'arexworks_woocommerce_add_custom_product_tab_callback' ) ) {
	function arexworks_woocommerce_add_custom_product_tab_callback()
	{
		echo arexworks_add_formatting( arexworks_get_option_data( 'custom_tab_content' ) );
	}
}

if ( !function_exists( 'arexworks_woocommerce_before_checkout_form' ) ) {
	function arexworks_woocommerce_before_checkout_form(){
		?>
		<div class="row">
			<div class="large-6 columns"><?php woocommerce_checkout_login_form();?></div>
			<div class="large-6 columns"><?php woocommerce_checkout_coupon_form();?></div>
		</div>
<?php
	}
}

if ( !function_exists( 'arexworks_woocommerce_review_order_before_payment' ) ) {
	function arexworks_woocommerce_review_order_before_payment(){
		echo sprintf(
			'<h3 class="%s">%s</h3>',
			'woocommerce-checkout-payment-heading',
			__( 'Payment Methods', 'arw-leka' )
		);
	}
}

if ( !function_exists( 'arexworks_woocommerce_init_sortable_taxonomies_brand' ) ) {
	add_filter('woocommerce_sortable_taxonomies','arexworks_woocommerce_init_sortable_taxonomies_brand');
	function arexworks_woocommerce_init_sortable_taxonomies_brand( $return )
	{
		global $current_screen;
		$return[ ] = 'product_brand';
		if ( is_object( $current_screen ) && in_array( $current_screen->id, array( 'edit-product_brand' ) ) ) {
			wp_enqueue_media();
		}
		return $return;
	}
}

// Check catalog Mode
if( !function_exists('arexworks_check_pages_redirect_catalog_mode')) {
	function arexworks_check_pages_redirect_catalog_mode(){
		wp_reset_postdata();
		if (is_cart() || is_checkout()) {
			wp_redirect(($shop_page_url = wc_get_page_id('shop')) ? get_permalink($shop_page_url) : home_url('/'));
			exit;
		}
	}
}
