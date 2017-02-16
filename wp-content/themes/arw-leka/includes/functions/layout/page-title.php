<?php

if ( !function_exists( 'arexworks_page_title' ) ) {
	function arexworks_page_title()
	{

		$post = isset( $GLOBALS[ 'post' ] ) ? $GLOBALS[ 'post' ] : null;
		$output = '';

		if ( !is_front_page() ) {

		} elseif ( is_home() ) {
			if ( ( $blog_title = arexworks_get_option_data( 'blog_title' ) ) && $blog_title ) {
				$output .= $blog_title;
			} else {
				if ( get_option( 'show_on_front' ) == 'page' && ( $blog_title = get_the_title( get_option( 'page_for_posts' ) ) ) ) {
					$output .= $blog_title;
				} else {
					$output .= __( 'Blog', 'arw-leka' );
				}
			}
		}

		if ( is_singular() ) {
			$output .= arexworks_page_title_leaf();
		} else {
			if ( is_post_type_archive() ) {
				if ( is_search() ) {
					$output .= arexworks_page_title_leaf( 'search' );
				} else {
					$output .= arexworks_page_title_archive();
				}
			} elseif ( is_tax() || is_tag() || is_category() ) {
				$html = arexworks_page_title_leaf( 'term' );

				if ( is_tag() ) {
					$output .= sprintf( __( 'Tag - %s', 'arw-leka' ), $html );
				} elseif ( is_tax( 'product_tag' ) ) {
					$output .= sprintf( __( 'Product Tag - %s', 'arw-leka' ), $html );
				} else {
					$output .= $html;
				}
			} elseif ( is_date() ) {
				if ( is_year() ) {
					$output .= arexworks_page_title_leaf( 'year' );
				} elseif ( is_month() ) {
					$output .= arexworks_page_title_leaf( 'month' );
				} elseif ( is_day() ) {
					$output .= arexworks_page_title_leaf( 'day' );
				}
			} elseif ( is_author() ) {
				$output .= arexworks_page_title_leaf( 'author' );
			} elseif ( is_search() ) {
				$output .= arexworks_page_title_leaf( 'search' );
			} elseif ( is_404() ) {
				$output .= arexworks_page_title_leaf( '404' );
			} elseif ( class_exists( 'bbPress' ) && is_bbpress() ) {
				if ( bbp_is_search() ) {
					$output .= arexworks_page_title_leaf( 'bbpress_search' );
				} elseif ( bbp_is_single_user() ) {
					$output .= arexworks_page_title_leaf( 'bbpress_user' );
				} else {
					$output .= arexworks_page_title_leaf();
				}
			} else {
				if ( is_home() && !is_front_page() ) {
					if ( get_option( 'show_on_front' ) == 'page' ) {
						$output .= get_the_title( get_option( 'page_for_posts', true ) );
					} else {
						if ( ( $blog_title = arexworks_get_option_data( 'blog_title' ) ) && $blog_title ) {
							$output .= $blog_title;
						} else {
							$output .= __( 'Blog', 'arw-leka' );
						}
					}
				}
			}
		}

		return $output;
	}
}

if ( !function_exists( 'arexworks_page_title_leaf' ) ) {
	function arexworks_page_title_leaf( $object_type = '' )
	{
		global $wp_query;

		$post = isset( $GLOBALS[ 'post' ] ) ? $GLOBALS[ 'post' ] : null;

		switch ( $object_type ) {
			case 'term':
				$term = $wp_query->get_queried_object();
				$title = $term->name;
				break;
			case 'year':
				$title = sprintf( __( 'Yearly Archives - %s', 'arw-leka' ), get_the_date( _x( 'Y', 'yearly archives date format', 'arw-leka' ) ) );
				break;
			case 'month':
				$title = sprintf( __( 'Monthly Archives - %s', 'arw-leka' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'arw-leka' ) ) );
				break;
			case 'day':
				$title = sprintf( __( 'Daily Archives - %s', 'arw-leka' ), get_the_date() );
				break;
			case 'author':
				$user = $wp_query->get_queried_object();
				$title = sprintf( __( 'Author - %s', 'arw-leka' ), $user->display_name );
				break;
			case 'search':
				$title = sprintf( __( 'Search Results - %s', 'arw-leka' ), esc_html( get_search_query() ) );
				break;
			case '404':
				$title = __( '404 - Page Not Found', 'arw-leka' );
				break;
			case 'bbpress_search':
				$title = sprintf( __( 'Search Results - %s', 'arw-leka' ), esc_html( get_query_var( 'bbp_search' ) ) );
				break;
			case 'bbpress_user':
				$current_user = wp_get_current_user();
				$title = $current_user->user_nicename;
				break;
			default:
				$title = get_the_title( $post->ID );
				break;
		}

		return $title;
	}
}

if ( !function_exists( 'arexworks_page_title_shop' ) ) {
	function arexworks_page_title_shop()
	{
		$post_type = 'product';
		$post_type_object = get_post_type_object( $post_type );

		$output = '';
		if ( is_object( $post_type_object ) && class_exists( 'WooCommerce' ) && ( is_woocommerce() || is_cart() || is_checkout() || is_account_page() ) ) {
			$shop_page_id = wc_get_page_id( 'shop' );
			$shop_page_name = $shop_page_id ? get_the_title( $shop_page_id ) : '';

			if ( !$shop_page_name ) {
				$shop_page_name = $post_type_object->labels->name;
			}
			$output .= $shop_page_name;
		}

		return $output;
	}
}

if ( !function_exists( 'arexworks_page_title_archive' ) ) {
	function arexworks_page_title_archive()
	{
		global $wp_query;

		$post_type = $wp_query->query_vars[ 'post_type' ];
		$post_type_object = get_post_type_object( $post_type );

		if ( is_object( $post_type_object ) ) {

			// woocommerce
			if ( $post_type == 'product' && $shop_title = arexworks_page_title_shop() ) {
				return $shop_title;
			}

			// bbpress
			if ( class_exists( 'bbPress' ) && $post_type == 'topic' ) {
				$archive_title = bbp_get_topic_archive_title();

				return $archive_title;
			}

			// default
			if ( isset( $post_type_object->label ) && $post_type_object->label !== '' ) {
				$archive_title = $post_type_object->label;
			} elseif ( isset( $post_type_object->labels->menu_name ) && $post_type_object->labels->menu_name !== '' ) {
				$archive_title = $post_type_object->labels->menu_name;
			} else {
				$archive_title = $post_type_object->name;
			}
		}

		return $archive_title;
	}
}
