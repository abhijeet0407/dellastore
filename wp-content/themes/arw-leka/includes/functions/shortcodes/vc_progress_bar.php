<?php

if(!function_exists('arexworks_override_vc_progress_bar')){

	add_action( 'vc_after_init', 'arexworks_override_vc_progress_bar' );

	function arexworks_override_vc_progress_bar(){
		if ( function_exists('vc_map') ) {
			$shortcode_name = 'vc_progress_bar';
			$category = __('Arexworks', 'arw-leka');
			$desc = __(' with arexworks style','arw-leka');
			vc_add_param( $shortcode_name , array(
				'type'        => 'dropdown',
				'heading'     => __( 'Display Type', 'arw-leka' ),
				'param_name'  => 'display_type',
				'std'         => '',
				'value'       =>  array(
					__('Default', 'arw-leka' ) => 'default',
					__('Style 1', 'arw-leka' ) => 'style_1'
				),
			));

			vc_map_update($shortcode_name , array(
				'category' => $category,
				'description' => __( 'Animated progress bar', 'arw-leka' ) . $desc
			));
		}
	}
}
