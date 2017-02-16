<?php

if ( !function_exists( 'arexworks_get_theme_option_by_metadata' ) ) {
	function arexworks_get_theme_option_by_metadata( $meta_key = '' , $default_value = false ){
		global $wp_query, $post;

		if ( empty($meta_key) ){
			return $default_value;
		}
		$value = false;
		$meta_key = '_this_' . $meta_key;
		if ( is_front_page() ) {
			if ( $_value = arexworks_get_post_meta( get_option('page_on_front'), $meta_key, true ) ) {
				$value = $_value;
			}
		}
		elseif ( is_home() ) {
			if ( $_value = arexworks_get_post_meta( get_option('page_for_posts'), $meta_key, true ) ){
				$value = $_value;
			}
		}
		elseif ( is_category() ) {
			$current_category = $wp_query->get_queried_object();
			if ( $current_category && ($_value = arexworks_get_term_meta( 'category', $current_category->term_id, $meta_key, true )) ) {
				$value = $_value;
			}
		}
		elseif ( is_tag() ) {
			$current_tag = $wp_query->get_queried_object();
			if ( $current_tag && ($_value = arexworks_get_term_meta( 'post_tag', $current_tag->term_id, $meta_key, true )) ) {
				$value = $_value;
			}
		}
		elseif ( is_archive() ) {
			if ( function_exists('is_shop') && is_shop() ) {
				if ( $_value = arexworks_get_post_meta( wc_get_page_id( 'shop' ), $meta_key, true ) ) {
					$value = $_value;
				}
			}
			else{
				$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
				if ($term  &&  !is_wp_error($term) && ( $_value = arexworks_get_term_meta( $term->taxonomy, $term->term_id, $meta_key, true ) ) ) {
					$value = $_value;
				}
			}
		}
		else {
			if ( is_singular() ) {
				if ( $_value = arexworks_get_post_meta( get_the_ID(), $meta_key, true ) ) {
					$value = $_value;
				}
			}
		}

		return ( $value === false ) ? $default_value : $value;
	}
}

if ( !function_exists( 'arexworks_get_theme_option_by_wp_query' ) ) {
	function arexworks_get_theme_option_by_wp_query( $layout_key, $layout_default = false, $layout_compare = 'inherit' ){
		global $post, $wp_query;

		if ( ( $_layout = arexworks_get_option_data( $layout_key . '_global', $layout_default) ) && $_layout && ( $_layout != $layout_compare ) ) {
			$layout_default = $_layout;
		}elseif ( ( $_layout = arexworks_get_option_data( $layout_key, $layout_default) ) ){
			$layout_default = $_layout;
		}
		$layout_blog = $layout_default;
		if ( ( $_layout = arexworks_get_option_data( $layout_key . '_blog', $layout_default) ) && $_layout && ( $_layout != $layout_compare ) ) {
			$layout_blog = $_layout;
		}
		$layout_shop = $layout_default;
		if ( ( $_layout = arexworks_get_option_data( $layout_key . '_shop', $layout_default) ) && $_layout && ( $_layout != $layout_compare ) ) {
			$layout_shop = $_layout;
		}

		$layout = $layout_default;

		if ((class_exists('bbPress') && is_bbpress()) || (class_exists('BuddyPress') && is_buddypress()))
		{
			$_layout = $layout;
			$layout = $_layout;
		}
		if ( is_front_page() ){
			if ( ( $_layout = arexworks_get_post_meta( get_option('page_on_front'), '_this_' . $layout_key, true ) ) && $_layout && ( $_layout != $layout_compare ) ){
				$layout = $_layout;
			}else{
				$layout = $layout_default;
			}
		}
		elseif ( is_home() ){
			if ( ( $_layout = arexworks_get_post_meta( get_option('page_for_posts'), '_this_' . $layout_key, true ) ) && $_layout && ( $_layout != $layout_compare ) ){
				$layout = $_layout;
			}else{
				$layout = $layout_blog;
			}
		}
		elseif (is_404()){
			$layout = $layout_default;
		}
		elseif (is_category()){
			$layout_category_default = $layout_blog;

			if( ($_layout = arexworks_get_option_data( $layout_key . '_post_category', $layout_category_default )) && ( $_layout != $layout_compare )){
				$layout = $layout_category_default;
			}

			$current_category = $wp_query->get_queried_object();

			if ( $current_category && !is_wp_error($current_category) ){
				$layout_category = arexworks_get_term_meta( 'category', $current_category->term_id, '_this_' . $layout_key, true );
				if($layout_category  && $layout_category != $layout_compare ){
					$layout = $layout_category;
				}
			}
		}
		elseif (is_tag()) {
			$layout_tag_default = $layout_blog;
			if( ($_layout = arexworks_get_option_data( $layout_key . '_post_tag', $layout_tag_default )) && ( $_layout != $layout_compare )){
				$layout = $layout_tag_default;
			}
			$current_tag = $wp_query->get_queried_object();
			if ( $current_tag && !is_wp_error($current_tag) ){
				$layout_tag = arexworks_get_term_meta( 'post_tag', $current_tag->term_id, '_this_' . $layout_key, true );
				if($layout_tag  && $layout_tag != $layout_compare ){
					$layout = $layout_tag;
				}
			}
		}
		elseif (is_archive()){
			if (function_exists('is_shop') && is_shop()) {
				if ( ( $_layout = arexworks_get_post_meta(  wc_get_page_id( 'shop' ), '_this_' . $layout_key, true ) ) && $_layout && ( $_layout != $layout_compare ) ){
					$layout = $_layout;
				}
				else {
					$layout = $layout_shop;
				}
			}
			else {
				if (is_post_type_archive('product')) {
					$layout = $layout_shop;
				}
				elseif (is_post_type_archive('portfolio') ){
					if ( ( $_layout = arexworks_get_option_data( $layout_key . '_portfolio', $layout_default ) ) && $_layout && ( $_layout != $layout_compare) ){
						$layout = $_layout;
					}
					else{
						$layout = $layout_default;
					}
				}
				else {
					$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
					if ($term && !is_wp_error($term)) {
						if ( ( $_layout = arexworks_get_term_meta( $term->taxonomy, $term->term_id, '_this_' . $layout_key, true ) ) && $_layout && ( $_layout != $layout_compare ) ){
							$layout = $_layout;
						}
						else{
							switch ($term->taxonomy) {
								case in_array( $term->taxonomy, arexworks_get_taxonomies( 'product' ) ) :
									$layout = $layout_shop;
									break;
								case in_array( $term->taxonomy, arexworks_get_taxonomies( 'post' ) ) :
									$layout = $layout_blog;
									break;
								default:
									$layout = $layout_default;
							}
						}

					}
				}
			}
		}
		elseif (is_search()){
			$layout = $layout_blog;
		}
		else{
			if (is_singular()) {
				if ( ( $_layout = arexworks_get_post_meta( get_the_ID(), '_this_' . $layout_key, true ) ) && $_layout && ( $_layout != $layout_compare ) ){
					$layout = $_layout;
				}
				else {
					switch (get_post_type()) {
						case 'product':
							if ( ( $_layout = arexworks_get_option_data( $layout_key . '_product_single', $layout_shop ) ) && $_layout && $_layout != $layout_compare ){
								$layout = $_layout;
							}
							else{
								$layout = $layout_shop;
							}
							break;
						case 'portfolio':
							if ( ( $_layout = arexworks_get_option_data( $layout_key . '_portfolio_single', $layout_default ) ) && $_layout && $_layout != $layout_compare ){
								$layout = $_layout;
							}
							else{
								$layout = $layout_default;
							}
							break;
						case 'post':
							if ( ( $_layout = arexworks_get_option_data( $layout_key . '_single', $layout_blog ) ) && $_layout && $_layout != $layout_compare ){
								$layout = $_layout;
							}
							else{
								$layout = $layout_blog;
							}
							break;
						default:
							$layout = $layout_default;
					}
				}
			}
		}
		return apply_filters( 'arexworks_filter_get_options_' . $layout_key , $layout );
	}
}


if ( !function_exists( 'arexworks_get_header_transparency' ) ) {
	function arexworks_get_header_transparency(){
		return arexworks_get_theme_option_by_metadata('header_transparency');
	}
}

if ( !function_exists( 'arexworks_get_page_style' ) ) {
	function arexworks_get_page_style(){
		return arexworks_get_theme_option_by_wp_query( 'page_style', 'stretched', 'inherit' );
	}
}

if ( !function_exists( 'arexworks_get_site_layout' ) ) {
	function arexworks_get_site_layout(){
		return arexworks_get_theme_option_by_wp_query( 'layout', 'col-1c', 'inherit' );
	}
}

if ( !function_exists( 'arexworks_get_header_layout' ) ){
	function arexworks_get_header_layout(){
		$type = arexworks_get_theme_option_by_wp_query( 'header_layout' ,'1', 'inherit' );
		$template_folder = 'template-shares/header/header';
		if (locate_template( $template_folder .'-' . $type . '.php') == '') {
			$type = 1;
		}
		return $type;
	}
}

if ( !function_exists( 'arexworks_enable_show_page_title') ) {
	function arexworks_enable_show_page_title(){
		$show = arexworks_get_theme_option_by_wp_query( 'show_page_title' , 'no' );
		if ( !empty( $show ) && $show != 'no' ){
			return true;
		}else{
			return false;
		}
	}
}

if ( !function_exists( 'arexworks_enable_show_breadcrumbs') ) {
	function arexworks_enable_show_breadcrumbs(){
		$show = arexworks_get_theme_option_by_wp_query( 'show_breadcrumbs' , 'no' );
		if ( !empty( $show ) && $show != 'no' ){
			return true;
		}else{
			return false;
		}
	}
}

if ( !function_exists( 'arexworks_get_page_header_layout' ) ){
	function arexworks_get_page_header_layout(){
		$type = arexworks_get_theme_option_by_wp_query( 'page_header_layout' ,'1', 'inherit' );
		$template_folder = 'template-shares/page_header/page_header';
		if (locate_template( $template_folder .'-' . $type . '.php') == '') {
			$type = 1;
		}
		return $type;
	}
}

if ( !function_exists( 'arexworks_get_footer_layout' ) ){
	function arexworks_get_footer_layout(){
		$type = arexworks_get_theme_option_by_wp_query( 'footer_layout' ,'1', 'inherit' );
		$template_folder = 'template-shares/footer/footer';
		if (locate_template( $template_folder .'-' . $type . '.php') == '') {
			$type = 1;
		}
		return $type;
	}
}

if ( !function_exists( 'arexworks_get_header_template' ) ){
	function arexworks_get_header_template(){
		$type = arexworks_get_header_layout();
		$template_folder = 'template-shares/header/header';
		get_template_part( $template_folder , $type );
	}
}

if ( !function_exists( 'arexworks_get_page_header_template' ) ){
	function arexworks_get_page_header_template(){
		if (is_front_page() || is_404())
			return;

		$type = arexworks_get_page_header_layout();

		$template_folder = 'template-shares/page_header/page_header';
		get_template_part( $template_folder , $type );
	}
}

if ( !function_exists( 'arexworks_get_footer_template' ) ){
	function arexworks_get_footer_template(){
		$type = arexworks_get_footer_layout();
		$template_folder = 'template-shares/footer/footer';
		get_template_part( $template_folder , $type );
	}
}

if ( !function_exists( 'arexworks_get_top_bar_menu' ) ){
	function arexworks_get_top_bar_menu(){
		$arg_default = array(
			'fallback_cb'     => false,
			'container'       => false,
		);
		$args = array_merge($arg_default , apply_filters( 'arexworks_get_top_bar_menu_location' , array(
			'theme_location'  => 'top-bar-navigation',
		)) );

		wp_nav_menu($args);
	}
}

if( !function_exists('arexworks_main_menu_fallback') ){
	function arexworks_main_menu_fallback(){
		$output = '<ul class="main-menu mega-menu show-arrow effect-fadein-up subeffect-fadein-left">';
		$menu_fallback = wp_list_pages('number=5&depth=2&echo=0&title_li=');
		$menu_fallback = str_replace('page_item','page_item menu-item',$menu_fallback);
		$menu_fallback = str_replace("<ul class='children'>","<ul class='sub-menu'>",$menu_fallback);
		$output .= $menu_fallback;
		$output .= '</ul>';
		echo $output;
	}
}

if( !function_exists('arexworks_main_mobile_menu_fallback') ){
	function arexworks_main_mobile_menu_fallback(){
		$output = '<ul class="mobile-main-menu accordion-menu">';
		$menu_fallback = wp_list_pages('echo=0&title_li=');
		$menu_fallback = str_replace('page_item','page_item menu-item',$menu_fallback);
		$menu_fallback = str_replace("<ul class='children'>","<span class='arrow'></span><ul class='sub-menu'>",$menu_fallback);
		$output .= $menu_fallback;
		$output .= '</ul>';
		echo $output;
	}
}

if ( !function_exists( 'arexworks_get_main_menu' ) ){
	function arexworks_get_main_menu(){
		if(class_exists('Arexworks_Walker_Top_Nav_Menu')) {
			$arg_default = array(
				'container' => false,
				'menu_class' => 'main-menu mega-menu show-arrow effect-fadein-up subeffect-fadein-left',
				'fallback_cb' => 'arexworks_main_menu_fallback',
				'walker' => new Arexworks_Walker_Top_Nav_Menu
			);
			$args = array_merge($arg_default , apply_filters( 'arexworks_filter_main_menu_location' , array(
				'theme_location' => 'main-navigation',
			)) );
			wp_nav_menu($args);
		}
	}
}

if ( !function_exists( 'arexworks_get_mobile_main_menu' ) ){
	function arexworks_get_mobile_main_menu(){
		if(class_exists('Arexworks_Walker_Accordion_Nav_Menu')) {
			$arg_default = array(
				'container' => false,
				'menu_class' => 'mobile-main-menu accordion-menu',
				'fallback_cb' => 'arexworks_main_mobile_menu_fallback',
				'walker' => new Arexworks_Walker_Accordion_Nav_Menu
			);
			$args = array_merge($arg_default , apply_filters( 'arexworks_filter_main_menu_location' , array(
				'theme_location' => 'main-navigation',
			)) );
			wp_nav_menu($args);
		}
	}
}

if ( !function_exists( 'arexworks_add_global_message_in_footer')){
	add_action('arexworks_action_after_render_body_tag', 'arexworks_add_global_message_in_footer');
	add_action('yith_woocompare_after_main_table', 'arexworks_add_global_message_in_footer');
	function arexworks_add_global_message_in_footer(){
		?>
		<div class="arexworks-global-message">
			<div class="wrapper-content">
				<span class="close-message"><i class="fa fa-times"></i></span>
				<div class="inner-content-message">
					<?php if(is_active_woocommerce() && !is_woocommerce()) : ?>
						<script type="text/javascript">
							/* <![CDATA[ */
							(function($) {
								"use strict";
								$(document).ready(function(){
									try {
										if ( $('.woocommerce-message').length ){
											$('.woocommerce-message').hide();
											arexworks.helpers.show_message($('.woocommerce-message').html());
										}
									}catch (ex) {}
								})
							})(jQuery);
							/* ]]> */
						</script>
					<?php endif;?>
				</div>
				<div class="close-message-text"><span><?php echo sprintf(__('The message will be closed after %s s','arw-leka'),'<i>20</i>')?></span></div>
			</div>
		</div>
		<div class="arexworks-overlay"></div>
		<div class="arexworks-ajax-loading"><div class="content"><img src="<?php echo arexworks_image . '/ajax-loader.gif'?>" alt="<?php _e('Ajax Loading','arw-leka')?>"/></div></div>
		<div class="arexworks-modal reveal-modal" data-reveal aria-hidden="true" role="dialog"><div class="modal-content"></div><a class="close-reveal-modal" aria-label="Close">&#215;</a></div>
<?php
	}
}

if ( !function_exists( 'arexworks_get_css_class_for_main' ) ) {
	function arexworks_get_css_class_for_main(){
		$_site_layout = arexworks_get_site_layout();
		switch ( $_site_layout ){
			case 'col-2cl':
				$_class = 'large-9 large-push-3 medium-8 medium-push-4 columns';
				break;
			case 'col-2cr':
				$_class = 'large-9 medium-8 columns';
				break;
			case 'col-3cl':
				$_class = 'large-6 large-push-6 medium-8 medium-push-4 columns';
				break;
			case 'col-3cm':
				$_class = 'large-6 large-push-3 medium-8 medium-push-4 columns';
				break;
			case 'col-3cr':
				$_class = 'large-6 medium-8 columns';
				break;
			default:
				$_class = 'large-12 columns';
		}
		return $_class;
	}
}

if ( !function_exists( 'arexworks_get_css_class_for_sidebar_primary' ) ){
	function arexworks_get_css_class_for_sidebar_primary(){
		$_site_layout = arexworks_get_site_layout();
		switch ( $_site_layout ){
			case 'col-2cl':
				$_class = 'large-3 large-pull-9 medium-4 medium-pull-8 columns';
				break;
			case 'col-2cr':
				$_class = 'large-3 medium-4 columns';
				break;
			case 'col-3cl':
				$_class = 'large-3 large-pull-6 medium-4 medium-pull-8 columns';
				break;
			case 'col-3cm':
				$_class = 'large-3 large-pull-6 medium-4 medium-pull-8 columns';
				break;
			case 'col-3cr':
				$_class = 'large-3 medium-4 columns';
				break;
			default:
				$_class = 'hide';
		}
		return $_class;
	}
}

if ( !function_exists( 'arexworks_get_css_class_for_sidebar_secondary' ) ){
	function arexworks_get_css_class_for_sidebar_secondary(){
		$_site_layout = arexworks_get_site_layout();
		switch ( $_site_layout ){
			case 'col-3cl':
				$_class = 'large-3 large-pull-6 medium-4 medium-pull-8 columns';
				break;
			case 'col-3cm':
				$_class = 'large-3 large-pull-0 medium-4 medium-pull-8 columns';
				break;
			case 'col-3cr':
				$_class = 'large-3 medium-6 columns';
				break;
			default:
				$_class = 'hide';
		}
		return $_class;
	}
}

if ( !function_exists( 'arexworks_add_filter_body_class' ) ){
	add_filter( 'body_class', 'arexworks_add_filter_body_class',1000 );
	function arexworks_add_filter_body_class( $classes ){
		$_site_layout = arexworks_get_site_layout();
		$_page_style = arexworks_get_page_style();
		$_header_layout = arexworks_get_header_layout();
		$_enable_header_transparency = arexworks_get_header_transparency();
		$_page_header_layout = arexworks_get_page_header_layout();
		$_footer_layout = arexworks_get_footer_layout();

		$classes[] = 'page-style-' . $_page_style;
		$classes[] = 'site-layout-' . $_site_layout;
		$classes[] = 'header-layout-' . $_header_layout;
		if ( $_enable_header_transparency ) $classes[] = 'header-transparency';
		$classes[] = 'page-header-layout-' . $_page_header_layout;

		if ( arexworks_get_theme_option_by_metadata('hide_footer') == 'yes' || $_header_layout == '3'){
			$classes[] = 'hide-footer-layout';
		}
		$classes[] = 'footer-layout-' . $_footer_layout;

		if(arexworks_get_option_data('sticky_header_hide_logo',false)){
			$classes[] = 'sticky-header-hide-logo';
		}
		if(arexworks_get_option_data('sticky_header_hide_search',false)){
			$classes[] = 'sticky-header-hide-search';
		}
		if(arexworks_get_option_data('sticky_header_hide_cart',false)){
			$classes[] = 'sticky-header-hide-cart';
		}

		return $classes;
	}
}

if ( !function_exists( 'arexworks_get_block_content_top') ){
	function arexworks_get_block_content_top(){
		$block_slug = arexworks_get_theme_option_by_wp_query('block_content_top',false,'');
		if($block_slug){
			echo '<div class="arexworks-block-content-top">';
			echo do_shortcode('[arexworks_static_block name="'.sanitize_title($block_slug).'"]');
			echo '</div>';
		}
	}
}

if ( !function_exists( 'arexworks_get_block_content_bottom') ){
	function arexworks_get_block_content_bottom(){
		$block_slug = arexworks_get_theme_option_by_wp_query('block_content_bottom',false,'');
		if($block_slug){
			echo '<div class="arexworks-block-content-bottom">';
			echo do_shortcode('[arexworks_static_block name="'.sanitize_title($block_slug).'"]');
			echo '</div>';
		}
	}
}

if ( !function_exists( 'arexworks_get_block_content_inner_top') ){
	function arexworks_get_block_content_inner_top(){
		$block_slug = arexworks_get_theme_option_by_wp_query('block_content_inner_top',false,'');
		if($block_slug){
			echo '<div class="arexworks-block-content-inner-top">';
			echo do_shortcode('[arexworks_static_block name="'.sanitize_title($block_slug).'"]');
			echo '</div>';
		}
	}
}

if ( !function_exists( 'arexworks_get_block_content_inner_bottom') ){
	function arexworks_get_block_content_inner_bottom(){
		$block_slug = arexworks_get_theme_option_by_wp_query('block_content_inner_bottom',false,'');
		if($block_slug){
			echo '<div class="arexworks-block-content-inner-bottom">';
			echo do_shortcode('[arexworks_static_block name="'.sanitize_title($block_slug).'"]');
			echo '</div>';
		}
	}
}