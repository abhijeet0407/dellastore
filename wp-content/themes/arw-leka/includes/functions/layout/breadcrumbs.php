<?php

add_filter('wpseo_breadcrumb_output_class', 'arexworks_wpseo_breadcrumb_output_class');

if ( !function_exists( 'arexworks_wpseo_breadcrumb_output_class' ) ) {
	function arexworks_wpseo_breadcrumb_output_class($class) {
	    if ($class)
	        return $class . ' yoast-breadcrumbs';
	    else
	        return 'yoast-breadcrumbs';
	}
}

if ( !function_exists( 'arexworks_breadcrumbs' ) ) {
	function arexworks_breadcrumbs()
	{

		// use yoast breadcrumbs if enabled
		if ( function_exists( 'yoast_breadcrumb' ) ) {
			$yoast_breadcrumbs = yoast_breadcrumb( '', '', false );
			if ( $yoast_breadcrumbs ) {
				return $yoast_breadcrumbs;
			}
		}


		$post = isset( $GLOBALS[ 'post' ] ) ? $GLOBALS[ 'post' ] : null;
		$output = '';

		$blog_title = __( 'Blog', 'arw-leka' );
		if ( arexworks_get_option_data( 'blog_title' ) ) {
			$blog_title = arexworks_get_option_data( 'blog_title' );
		} else {
			if ( get_option( 'show_on_front' ) == 'page' && ( $_blog_title = get_the_title( get_option( 'page_for_posts' ) ) ) ) {
				$blog_title = $_blog_title;
			}
		}

		// add breadcrumbs prefix
		if ( !is_front_page() ) {
			if ( arexworks_get_option_data( 'breadcrumbs_prefix' ) ) {
				$output .= '<span class="breadcrumbs-prefix">' . arexworks_get_option_data( 'breadcrumbs_prefix' ) . '</span>';
			}
		}

		// breadcrumbs start wrap
		$output .= '<ul class="breadcrumb">';

		// add home link
		if ( !is_front_page() ) {
			$output .= arexworks_breadcrumbs_link( __( 'Home', 'arw-leka' ), apply_filters( 'woocommerce_breadcrumb_home_url', home_url('/') ) );
		} elseif ( is_home() ) {
			$output .= arexworks_breadcrumbs_link( $blog_title );
		}

		// add woocommerce shop page link
		if ( class_exists( 'WooCommerce' ) && ( ( is_woocommerce() && is_archive() && !is_shop() ) || is_cart() || is_checkout() || is_account_page() ) ) {
			$output .= arexworks_breadcrumbs_shop_link();
		}

		// add bbpress forums link
		if ( class_exists( 'bbPress' ) && is_bbpress() && ( bbp_is_topic_archive() || bbp_is_single_user() || bbp_is_search() || bbp_is_topic_tag() || bbp_is_edit() ) ) {
			$output .= arexworks_breadcrumbs_link( bbp_get_forum_archive_title(), get_post_type_archive_link( 'forum' ) );
		}

		if ( is_singular() ) {
			if ( isset( $post->post_type ) && get_post_type_archive_link( $post->post_type ) && arexworks_get_option_data( 'breadcrumbs_archives_link_global' ) ) {
				$output .= arexworks_breadcrumbs_archive_link();
			} elseif ( isset( $post->post_type ) && $post->post_type == 'post' && get_option( 'show_on_front' ) == 'page' && arexworks_get_option_data( 'breadcrumbs_blog_link_global' ) ) {
				$output .= arexworks_breadcrumbs_link( get_the_title( get_option( 'page_for_posts', true ) ), get_permalink( get_option( 'page_for_posts' ) ) );
			}

			if ( isset( $post->post_parent ) && $post->post_parent == 0 ) {
				$output .= arexworks_breadcrumbs_terms_link();
			} else {
				$output .= arexworks_breadcrumbs_ancestors_link();
			}

			$output .= arexworks_breadcrumb_leaf();
		} else {
			if ( is_post_type_archive() ) {
				if ( is_search() ) {
					$output .= arexworks_breadcrumbs_archive_link();
					$output .= arexworks_breadcrumb_leaf( 'search' );
				} else {
					$output .= arexworks_breadcrumbs_archive_link( false );
				}
			} elseif ( is_tax() || is_tag() || is_category() ) {
				$html = arexworks_breadcrumbs_taxonomies_link();
				$html .= arexworks_breadcrumb_leaf( 'term' );

				if ( is_tag() ) {
					if ( get_option( 'show_on_front' ) == 'page' && arexworks_get_option_data( 'breadcrumbs_blog_link_global' ) ) {
						$output .= arexworks_breadcrumbs_link( get_the_title( get_option( 'page_for_posts', true ) ), get_permalink( get_option( 'page_for_posts' ) ) );
					}
					$output .= sprintf( __( 'Tag - %s', 'arw-leka' ), $html );
				} elseif ( is_tax( 'product_tag' ) ) {
					$output .= sprintf( __( 'Product Tag - %s', 'arw-leka' ), $html );
				} else {
					if ( is_category() && get_option( 'show_on_front' ) == 'page' && arexworks_get_option_data( 'breadcrumbs_blog_link_global' ) ) {
						$output .= arexworks_breadcrumbs_link( get_the_title( get_option( 'page_for_posts', true ) ), get_permalink( get_option( 'page_for_posts' ) ) );
					}
					if ( is_tax( 'portfolio_category' ) || is_tax( 'portfolio_skill' ) ) {
						$output .= arexworks_breadcrumbs_link( arexworks_breadcrumbs_archive_name( 'portfolio' ), get_post_type_archive_link( 'portfolio' ) );
					}
					if ( is_tax( 'member_cat' ) ) {
						$output .= arexworks_breadcrumbs_link( arexworks_breadcrumbs_archive_name( 'member' ), get_post_type_archive_link( 'member' ) );
					}
					if ( is_tax( 'faq_cat' ) ) {
						$output .= arexworks_breadcrumbs_link( arexworks_breadcrumbs_archive_name( 'faq' ), get_post_type_archive_link( 'faq' ) );
					}
					$output .= $html;
				}
			} elseif ( is_date() ) {
				global $wp_locale;

				if ( get_option( 'show_on_front' ) == 'page' && arexworks_get_option_data( 'breadcrumbs_blog_link_global' ) ) {
					$output .= arexworks_breadcrumbs_link( get_the_title( get_option( 'page_for_posts', true ) ), get_permalink( get_option( 'page_for_posts' ) ) );
				}

				$year = esc_html( get_query_var( 'year' ) );
				if ( is_month() || is_day() ) {
					$month = get_query_var( 'monthnum' );
					$month_name = $wp_locale->get_month( $month );
				}

				if ( is_year() ) {
					$output .= arexworks_breadcrumb_leaf( 'year' );
				} elseif ( is_month() ) {
					$output .= arexworks_breadcrumbs_link( $year, get_year_link( $year ) );
					$output .= arexworks_breadcrumb_leaf( 'month' );
				} elseif ( is_day() ) {
					$output .= arexworks_breadcrumbs_link( $year, get_year_link( $year ) );
					$output .= arexworks_breadcrumbs_link( $month_name, get_month_link( $year, $month ) );
					$output .= arexworks_breadcrumb_leaf( 'day' );
				}
			} elseif ( is_author() ) {
				$output .= arexworks_breadcrumb_leaf( 'author' );
			} elseif ( is_search() ) {
				$output .= arexworks_breadcrumb_leaf( 'search' );
			} elseif ( is_404() ) {
				$output .= arexworks_breadcrumb_leaf( '404' );
			} elseif ( class_exists( 'bbPress' ) && is_bbpress() ) {
				if ( bbp_is_search() ) {
					$output .= arexworks_breadcrumb_leaf( 'bbpress_search' );
				} elseif ( bbp_is_single_user() ) {
					$output .= arexworks_breadcrumb_leaf( 'bbpress_user' );
				} else {
					$output .= arexworks_breadcrumb_leaf();
				}
			} else {
				if ( is_home() && !is_front_page() ) {
					if ( get_option( 'show_on_front' ) == 'page' ) {
						$output .= arexworks_breadcrumbs_link( get_the_title( get_option( 'page_for_posts', true ) ) );
					} else {
						$output .= arexworks_breadcrumbs_link( $blog_title );
					}
				}
			}
		}

		// breadcrumbs end wrap
		$output .= '</ul>';

		return $output;
	}
}

if ( !function_exists( 'arexworks_breadcrumbs_link' ) ) {
	function arexworks_breadcrumbs_link( $title, $link = '' )
	{

		$microdata = arexworks_get_option_data( 'breadcrumbs_enable_google_rich_snippets' );

		$microdata_itemscope = $microdata_url = $microdata_title = $separator_markup = '';

		if ( $microdata ) {
			$microdata_itemscope = 'itemscope itemtype="http://data-vocabulary.org/Breadcrumb"';
			$microdata_url = 'itemprop="url"';
			$microdata_title = 'itemprop="title"';
		}

		$output = sprintf( '<span %s>%s</span>', $microdata_title, $title );
		$delimiter = '';
		if ( $link ) {
			$output = sprintf( '<a %s href="%s" >%s</a>', $microdata_url, $link, $output );
			$delimiter = '<i class="delimiter"></i>';
			$before = sprintf( '<li %s>', $microdata_itemscope );
		} else {
			$before = '<li>';
		}
		$after = '</li>';

		return $before . $output . $delimiter . $after;
	}
}

if ( !function_exists( 'arexworks_breadcrumbs_simple_link' ) ) {
	function arexworks_breadcrumbs_simple_link( $title, $link = '' )
	{

		$microdata = arexworks_get_option_data( 'rich_snippets' );

		$microdata_itemscope = $microdata_url = $microdata_title = $separator_markup = '';

		if ( $microdata ) {
			$microdata_itemscope = 'itemscope itemtype="http://data-vocabulary.org/Breadcrumb"';
			$microdata_url = 'itemprop="url"';
			$microdata_title = 'itemprop="title"';
		}

		$output = sprintf( '<span %s>%s</span>', $microdata_title, $title );

		if ( $link ) {
			$output = sprintf( '<a %s href="%s" >%s</a>', $microdata_url, $link, $output );
		}

		$before = sprintf( '<span %s>', $microdata_itemscope );
		$after = '</span>';

		return $before . $output . $after;
	}
}

if ( !function_exists( 'arexworks_breadcrumb_leaf' ) ) {
	function arexworks_breadcrumb_leaf( $object_type = '' )
	{
		global $wp_query, $wp_locale;

		$post = isset( $GLOBALS[ 'post' ] ) ? $GLOBALS[ 'post' ] : null;

		switch ( $object_type ) {
			case 'term':
				$term = $wp_query->get_queried_object();
				$title = $term->name;
				break;
			case 'year':
				$title = esc_html( get_query_var( 'year' ) );
				break;
			case 'month':
				$title = $wp_locale->get_month( get_query_var( 'monthnum' ) );
				break;
			case 'day':
				$title = get_query_var( 'day' );
				break;
			case 'author':
				$user = $wp_query->get_queried_object();
				$title = $user->display_name;
				break;
			case 'search':
				$title = sprintf( __( 'Search - %s', 'arw-leka' ), esc_html( get_search_query() ) );
				break;
			case '404':
				$title = __( '404', 'arw-leka' );
				break;
			case 'bbpress_search':
				$title = sprintf( __( 'Search - %s', 'arw-leka' ), esc_html( get_query_var( 'bbp_search' ) ) );
				break;
			case 'bbpress_user':
				$current_user = wp_get_current_user();
				$title = $current_user->user_nicename;
				break;
			default:
				$title = get_the_title( $post->ID );
				break;
		}

		$before = '<li>';
		$after = '</li>';

		return $before . $title . $after;
	}
}

if ( !function_exists( 'arexworks_breadcrumbs_links' ) ) {
	function arexworks_breadcrumbs_links( $output )
	{
		$delimiter = '<i class="delimiter"></i>';
		$before = '<li>';
		$after = '</li>';
		return $before . $output . $delimiter . $after;
	}
}

if ( !function_exists( 'arexworks_breadcrumbs_shop_link' ) ) {
	function arexworks_breadcrumbs_shop_link( $linked = true )
	{
		$post_type = 'product';
		$post_type_object = get_post_type_object( $post_type );
		$link = '';

		$output = '';
		if ( is_object( $post_type_object ) && class_exists( 'WooCommerce' ) && ( is_woocommerce() || is_cart() || is_checkout() || is_account_page() ) ) {
			$shop_page_id = wc_get_page_id( 'shop' );
			$shop_page_name = $shop_page_id ? get_the_title( $shop_page_id ) : '';

			if ( !$shop_page_name ) {
				$shop_page_name = $post_type_object->labels->name;
			}
			if ( $linked ) $link = get_post_type_archive_link( $post_type );
			$output .= arexworks_breadcrumbs_link( $shop_page_name, $link );
		}

		return $output;
	}
}

if ( !function_exists( 'arexworks_breadcrumbs_archive_link' ) ) {
	function arexworks_breadcrumbs_archive_link( $linked = true )
	{
		global $wp_query;

		$post_type = $wp_query->query_vars[ 'post_type' ];
		$post_type_object = get_post_type_object( $post_type );
		$link = '';

		if ( is_object( $post_type_object ) ) {

			// woocommerce
			if ( $post_type == 'product' && $shop_link = arexworks_breadcrumbs_shop_link( $linked ) ) {
				return $shop_link;
			}

			// bbpress
			if ( class_exists( 'bbPress' ) && $post_type == 'topic' ) {
				if ( $linked ) {
					$archive_title = bbp_get_forum_archive_title();
					$link = get_post_type_archive_link( bbp_get_forum_post_type() );
				} else {
					$archive_title = bbp_get_topic_archive_title();
				}

				return arexworks_breadcrumbs_link( $archive_title, $link );
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

		if ( $linked ) {
			$link = get_post_type_archive_link( $post_type );
		}

		return arexworks_breadcrumbs_link( $archive_title, $link );
	}
}

if ( !function_exists( 'arexworks_breadcrumbs_archive_name' ) ) {
	function arexworks_breadcrumbs_archive_name( $post_type )
	{
		$post_type_object = get_post_type_object( $post_type );

		if ( is_object( $post_type_object ) ) {

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

if ( !function_exists( 'arexworks_breadcrumbs_terms_link' ) ) {
	function arexworks_breadcrumbs_terms_link()
	{
		$output = '';
		$post = isset( $GLOBALS[ 'post' ] ) ? $GLOBALS[ 'post' ] : null;

		if ( !arexworks_get_option_data( 'breadcrumbs_categories_global' ) ) {
			return $output;
		}

		if ( $post->post_type == 'post' ) {
			$taxonomy = 'category';
		} elseif ( $post->post_type == 'portfolio' ) {
			$taxonomy = 'portfolio_category';
		} elseif ( $post->post_type == 'product' && class_exists( 'WooCommerce' ) && is_woocommerce() ) {
			$taxonomy = 'product_cat';
		} else {
			return $output;
		}

		$terms = wp_get_object_terms( $post->ID, $taxonomy );

		if ( empty( $terms ) ) {
			return $output;
		}

		$terms_by_id = array();
		foreach ( $terms as $term ) {
			$terms_by_id[ $term->term_id ] = $term;
		}

		foreach ( $terms as $term ) {
			unset( $terms_by_id[ $term->parent ] );
		}

		if ( count( $terms_by_id ) == 1 ) {
			unset( $terms );
			$terms[ 0 ] = array_shift( $terms_by_id );
		}

		if ( count( $terms ) == 1 ) {
			$term_parent = $terms[ 0 ]->parent;

			if ( $term_parent ) {
				$term_tree = get_ancestors( $terms[ 0 ]->term_id, $taxonomy );
				$term_tree = array_reverse( $term_tree );
				$term_tree[ ] = get_term( $terms[ 0 ]->term_id, $taxonomy );

				$i = 0;
				foreach ( $term_tree as $term_id ) {
					$term_object = get_term( $term_id, $taxonomy );
					if ( $i++ == 0 ) {
						$output .= arexworks_breadcrumbs_simple_link( $term_object->name, get_term_link( $term_object ) );
					} else {
						$output .= ', ' . arexworks_breadcrumbs_simple_link( $term_object->name, get_term_link( $term_object ) );
					}
				}
				$output = arexworks_breadcrumbs_links( $output );
			} else {
				$output = arexworks_breadcrumbs_link( $terms[ 0 ]->name, get_term_link( $terms[ 0 ] ) );
			}
		} else {
			$output = arexworks_breadcrumbs_simple_link( $terms[ 0 ]->name, get_term_link( $terms[ 0 ] ) );
			array_shift( $terms );
			foreach ( $terms as $term ) {
				$output .= ', ' . arexworks_breadcrumbs_simple_link( $term->name, get_term_link( $term ) );
			}
			$output = arexworks_breadcrumbs_links( $output );
		}

		return $output;
	}
}

if ( !function_exists( 'arexworks_breadcrumbs_ancestors_link' ) ) {
	function arexworks_breadcrumbs_ancestors_link()
	{
		$output = '';

		$post = isset( $GLOBALS[ 'post' ] ) ? $GLOBALS[ 'post' ] : null;
		$post_ancestor_ids = array_reverse( get_post_ancestors( $post ) );

		foreach ( $post_ancestor_ids as $post_ancestor_id ) {
			$post_ancestor = get_post( $post_ancestor_id );
			$output .= arexworks_breadcrumbs_link( $post_ancestor->post_title, get_permalink( $post_ancestor->ID ) );
		}

		return $output;
	}
}

if ( !function_exists( 'arexworks_breadcrumbs_taxonomies_link' ) ) {
	function arexworks_breadcrumbs_taxonomies_link()
	{
		global $wp_query;
		$term = $wp_query->get_queried_object();
		$output = '';

		if ( $term->parent != 0 && is_taxonomy_hierarchical( $term->taxonomy ) ) {
			$term_ancestors = get_ancestors( $term->term_id, $term->taxonomy );
			$term_ancestors = array_reverse( $term_ancestors );

			foreach ( $term_ancestors as $term_ancestor ) {
				$term_object = get_term( $term_ancestor, $term->taxonomy );
				$output .= arexworks_breadcrumbs_link( $term_object->name, get_term_link( $term_object->term_id, $term->taxonomy ) );
			}
		}

		return $output;
	}
}
