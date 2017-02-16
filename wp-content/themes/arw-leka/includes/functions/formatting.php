<?php

add_filter( 'widget_text', 'do_shortcode');

/**
 * Filter
 */
add_filter( 'excerpt_length', 'arexworks_new_excerpt_length',99);
add_filter( 'widget_tag_cloud_args', 'arexworks_tag_cloud_args' );
add_filter( 'wp_list_categories', 'arexworks_category_widget_mod');
add_filter( 'wp_get_archives', 'arexworks_archives_widget_mod');
add_filter( 'wp_nav_menu_args', 'arexworks_add_filter_wp_nav_menu_args' );
add_filter( 'embed_oembed_html', 'arexworks_add_wrapper_for_player', 99, 4);


if ( defined( 'VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG' ) ){
	add_filter( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG , 'arexworks_add_filter_vc_shortcode_custom_css_filter_tag', 10, 3 );
}

if ( !function_exists( 'arexworks_add_filter_vc_shortcode_custom_css_filter_tag' ) ) {
	function arexworks_add_filter_vc_shortcode_custom_css_filter_tag( $css_classes, $shortcode_name, $atts ){
		if ( $shortcode_name == 'vc_column' || $shortcode_name == 'vc_column_inner' ){
			$css_classes = str_replace( 'vc_col-xs', 'small', $css_classes );
			$css_classes = str_replace( 'vc_col-sm', 'medium', $css_classes );
			$css_classes = str_replace( 'vc_col-md', 'large', $css_classes );
			$css_classes = str_replace( 'vc_col-lg', 'xlarge', $css_classes );
			$css_classes .= ' columns';
		}
		if ( $shortcode_name == 'vc_row' || $shortcode_name == 'vc_row_inner' ){
			$css_classes .= ' row';
		}

		if ( $shortcode_name == 'vc_progress_bar' ){
			if( isset($atts['display_type']) ){
				$css_classes .= ' vc_progress_bar_' . esc_attr($atts['display_type']);
			}
		}
		return $css_classes;
	}
}

if ( !function_exists( 'arexworks_new_excerpt_length' ) ){
	function arexworks_new_excerpt_length($length) {
		return 50;
	}
}

if ( !function_exists( 'arexworks_tag_cloud_args' ) ){
	function arexworks_tag_cloud_args( $args ) {
		$args['largest'] = 12;
		$args['smallest'] = 9;
		$args['unit'] = 'px';
		$args['format'] = 'list';
		return $args;
	}
}

if ( !function_exists( 'arexworks_category_widget_mod' ) ){
	function arexworks_category_widget_mod($output) {
		$output = str_replace('</a> (',' <span>(',$output);
		$output = str_replace(')',')</span></a> ',$output);
		return $output;
	}
}

if ( !function_exists( 'arexworks_archives_widget_mod' ) ){
	function arexworks_archives_widget_mod($output) {
		$output = str_replace('</a> (',' <span>(',$output);
		$output = str_replace(')',')</span></a> ',$output);
		return $output;
	}
}

if ( !function_exists( 'arexworks_add_filter_wp_nav_menu_args' ) ) {
	function arexworks_add_filter_wp_nav_menu_args( $args ){
		$args['container'] = false;
		return $args;
	}
}

if ( !function_exists( 'arexworks_add_wrapper_for_player' ) ){
	function arexworks_add_wrapper_for_player($html, $url, $attr, $post_id){
		return '<div class="flex-video widescreen">' . $html . '</div>';
	}
}

if ( !function_exists( 'arexworks_add_data_src_image_attributes' ) ){
	function arexworks_add_data_src_image_attributes( $attr, $attachment, $size ){
		$image = wp_get_attachment_image_src($attachment->ID, $size);
		if($image){
			list($src, $width, $height) = $image;
			$attr['data-src'] = $src;
		}
		return $attr;
	}
}

if ( !function_exists( 'arexworks_compress_text' ) ){
	function arexworks_compress_text($buffer){
		$buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
		$buffer = str_replace(array("\r\n", "\r", "\n", "\t", '	', '	', '	'), '', $buffer);
		return $buffer;
	}
}

if ( !function_exists( 'arexworks_get_the_content_with_formatting' ) ){
	function arexworks_get_the_content_with_formatting() {
		$content = get_the_content();
		$content = apply_filters('the_content', $content);
		$content = do_shortcode($content);
		return $content;
	}
}

if ( !function_exists( 'arexworks_add_formatting' ) ) {
	function arexworks_add_formatting($content){
		$content = do_shortcode($content);
		return $content;
	}
}

if ( !function_exists( 'arexworks_get_the_excerpt_with_limit' ) ) {
	function arexworks_get_the_excerpt_with_limit($limit = 80 ,$more_link = false){
		$limit = (int) $limit;
		if (has_excerpt()) {
			$excerpt = strip_tags( strip_shortcodes(get_the_excerpt()) );
		} else {
			$excerpt = strip_tags( strip_shortcodes(get_the_content()) );
		}
		$excerpt = explode(' ', $excerpt, $limit);
		if (count($excerpt) >= $limit) {
			array_pop($excerpt);
			if ($more_link)
				$excerpt = implode(" ", $excerpt) . '...';
			else
				$excerpt = implode(" ", $excerpt) . '[...]';
		} else {
			$excerpt = implode(" ", $excerpt);
		}
		$excerpt = preg_replace('`\[[^\]]*\]`', '', $excerpt);

		if ($more_link)
			$excerpt .= ' <a class="read-more" href="'.esc_url( apply_filters( 'the_permalink', get_permalink() ) ).'">'.__('read more', 'arw-leka').' <i class="fa fa-angle-right"></i></a>';

		return '<div class="post-excerpt">' . $excerpt . '</div>';
	}
}

if ( !function_exists( 'arexworks_get_the_content_with_limit' ) ) {
	function arexworks_get_the_content_with_limit($limit, $more = '...'){
		$limit = (int) $limit;
		$content = explode(' ', strip_tags( strip_shortcodes(get_the_content()) ), $limit);
		if (count($content) >= $limit) {
			array_pop($content);
			$content = implode(" ", $content) . $more;
		} else {
			$content = implode(" ", $content) . '';
		}

		$content = apply_filters('the_content', $content);
		$content = do_shortcode($content);
		return $content;
	}
}

if ( !function_exists( 'arexworks_get_custom_content_with_limit' ) ) {
	function arexworks_get_custom_content_with_limit($custom_content, $limit, $more = '...'){
		$limit = (int) $limit;
		$content = explode(' ', strip_tags( strip_shortcodes( $custom_content ) ), $limit);
		if (count($content) >= $limit) {
			array_pop($content);
			$content = implode(" ", $content) . $more;
		} else {
			$content = implode(" ", $content) . '';
		}

		$content = apply_filters('the_content', $content);
		$content = do_shortcode($content);
		return $content;
	}
}

if ( !function_exists( 'arexworks_add_element_to_first_array' ) ) {
	function arexworks_add_element_to_first_array( $key, $first = array(), $array ){
		$tmp = array();
		if( $key != '' &&  isset( $array[$key] ) ){
			unset($array[$key]);
		}
		$tmp[$key] = $first;
		foreach ($array as $idx => $value ){
			$tmp[$idx] = $value;
		}
		return $tmp;
	}
}

/******************************************************************************
Helper Class For Visual Composer
 ******************************************************************************/

if ( !function_exists( 'arexworks_translate_width_to_class' ) ) {
	function arexworks_translate_width_to_class($width, $front = true){
		if ( function_exists( 'vc_settings' ) ) {
			preg_match('/(\d+)\/(\d+)/', $width, $matches);
			$w = $width;
			if (!empty($matches)) {
				$part_x = (int)$matches[1];
				$part_y = (int)$matches[2];
				if ($part_x > 0 && $part_y > 0) {
					$value = ceil($part_x / $part_y * 12);
					if ($value > 0 && $value <= 12) {
						$w = 'vc_col-md-' . $value;
					}
				}
			}
			$custom = false;
			if($front){
				if( function_exists('get_custom_column_class' ) ){
					$custom = get_custom_column_class($w);
				}
			}
			return $custom ? $custom : $w;
		}
	}
}

if ( !function_exists( 'arexworks_column_offset_class_merge' ) ) {
	function arexworks_column_offset_class_merge($column_offset, $width){
		if ( function_exists( 'vc_settings' ) ) {
			if (vc_settings()->get('not_responsive_css') === '1') {
				$column_offset = preg_replace('/vc_col\-(lg|sm|xs)[^\s]*/', '', $column_offset);
			}
			if (preg_match('/vc_col\-md\-\d+/', $column_offset)) {
				return $column_offset;
			}

			return $width . (empty($column_offset) ? '' : ' ' . $column_offset);
		}
	}
}

if ( !function_exists( 'arexworks_shortcode_extract_class' ) ) {
	function arexworks_shortcode_extract_class($el_class){
		$output = '';
		if ($el_class != '') {
			$output = " " . str_replace(".", "", $el_class);
		}
		return $output;
	}
}

if ( !function_exists( 'arexworks_shortcode_end_block_comment' ) ) {
	function arexworks_shortcode_end_block_comment($string){
		return WP_DEBUG ? '<!-- END ' . $string . ' -->' : '';
	}
}

if ( !function_exists( 'arexworks_parse_multi_attribute' ) ) {
	function arexworks_parse_multi_attribute($value, $default = array()){
		$result = $default;
		$params_pairs = explode('|', $value);
		if (!empty($params_pairs)) {
			foreach ($params_pairs as $pair) {
				$param = preg_split('/\:/', $pair);
				if (!empty($param[0]) && isset($param[1])) {
					$result[$param[0]] = rawurldecode($param[1]);
				}
			}
		}
		return $result;
	}
}

if ( !function_exists( 'arexworks_param_remove_from_array' ) ) {
	function arexworks_param_remove_from_array($array, $attr){
		return array_filter($array, create_function('$el', 'if($el["param_name"] == "' . $attr . '") return false; return true;'));
	}
}

if ( !function_exists( 'arexworks_get_param_index' ) ) {
	function arexworks_get_param_index($array, $attr){
		foreach ($array as $index => $entry) {
			if ($entry['param_name'] == $attr) {
				return $index;
			}
		}
		return -1;
	}
}

if ( !function_exists( 'arexworks_move_array_index_after' ) ) {
	function arexworks_move_array_index_after(&$array, $index, $after_index){
		$new_array = array();
		$element_to_move = null;
		foreach ($array as $i => $el) {
			if ($i == $index)
				$element_to_move = $el;
		}
		foreach ($array as $i => $el) {
			if ($i != $index) {
				$new_array[] = $el;

				if ($i == $after_index)
					$new_array[] = $element_to_move;
			}
		}
		$array = $new_array;
	}
}

if ( !function_exists( 'arexworks_remove_element_in_array' ) ){
	function arexworks_remove_element_in_array( $value , &$array , $remove_all = false ){
		foreach ( $array as $idx => $el ){
			if ( $el == $value ){
				unset($array[$idx]);
				if ( !$remove_all ){
					break;
				}
			}
		}
		return $array;
	}
}
