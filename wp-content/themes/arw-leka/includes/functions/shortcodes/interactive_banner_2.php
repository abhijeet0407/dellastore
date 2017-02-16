<?php

if( !function_exists('arexworks_override_interactive_banner_2') ){

	add_action( 'init', 'arexworks_override_interactive_banner_2', 100 );

	function arexworks_override_interactive_banner_2(){
		if ( function_exists('vc_map') && class_exists('Ultimate_VC_Addons') ) {
			$shortcode_name = 'interactive_banner_2';
			$category = __('Arexworks', 'arw-leka');
			$desc = __(' with arexworks style','arw-leka');

			if(shortcode_exists($shortcode_name)){
				$param_banner_style = WPBMap::getParam( $shortcode_name, 'banner_style' );
				if($param_banner_style && isset($param_banner_style['json']) ){
					$param_banner_style['json'] = '{
					"Custom_Style":{
						"Custom_1":"custom1",
						"Custom_2":"custom2",
						"Custom_3":"custom3"
					},
					"Long_Text":{
						"Style_1":"style1",
						"Style_2":"style5",
						"Style_3":"style13"
					},
					"Medium_Text":{
						"Style_4":"style2",
						"Style_5":"style4",
						"Style_6":"style6",
						"Style_7":"style7",
						"Style_8":"style10",
						"Style_9":"style14"
					},
					"Short_Description":{
						"Style_10":"style9",
						"Style_11":"style11",
						"Style_12":"style15"
					}
				}';
					vc_update_shortcode_param($shortcode_name,$param_banner_style);
					vc_map_update($shortcode_name , array(
						'category' => $category,
						'description' => __( 'Displays the banner image', 'arw-leka' ) . $desc
					));
				}
			}

		}
	}
}
