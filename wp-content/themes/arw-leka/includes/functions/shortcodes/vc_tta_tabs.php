<?php

if( !function_exists('arexworks_override_vc_tta_tabs') ){

	add_action( 'vc_after_init', 'arexworks_override_vc_tta_tabs' );

	function arexworks_override_vc_tta_tabs(){
		if ( function_exists('vc_map') ) {
			$shortcode_name = 'vc_tta_tabs';
			$category = __('Arexworks', 'arw-leka');
			$desc = __(' with arexworks style','arw-leka');

			$param_style = WPBMap::getParam( $shortcode_name, 'style' );
			$param_shape = WPBMap::getParam( $shortcode_name, 'shape' );
			$param_color = WPBMap::getParam( $shortcode_name, 'color' );

			$dependency = array(
				'element' => 'style',
				'value' => array(
					'classic','modern','flat','outline'
				),
			);
			$array = array(
				__( 'Style 1', 'arw-leka' ) => 'style-1',
				__( 'Style 2', 'arw-leka' ) => 'style-2',
				__( 'Classic', 'arw-leka' ) => 'classic',
				__( 'Modern', 'arw-leka' ) => 'modern',
				__( 'Flat', 'arw-leka' ) => 'flat',
				__( 'Outline', 'arw-leka' ) => 'outline',
			);
			$param_style['std'] = 'style-1';
			$param_style['value'] = $array;
			$param_shape['dependency'] = $dependency;
			$param_color['dependency'] = $dependency;

			vc_update_shortcode_param($shortcode_name,$param_style);
			vc_update_shortcode_param($shortcode_name,$param_shape);
			vc_update_shortcode_param($shortcode_name,$param_color);

			vc_map_update($shortcode_name , array(
				'category' => $category,
				'description' => __( 'Displays the banner image with Information', 'arw-leka' ) . $desc
			));
		}
	}
}
