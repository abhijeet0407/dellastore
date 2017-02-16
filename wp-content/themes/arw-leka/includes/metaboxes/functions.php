<?php
if ( !function_exists( 'arexworks_metaboxes_get_default_meta_view' ) ) {
	function arexworks_metaboxes_get_default_meta_view(){
		$theme_layouts          = arexworks_admin_options_layout_inherit();
		$page_style             = arexworks_admin_options_page_style();
		$page_header_layouts    = arexworks_admin_options_page_header_layout();
		$header_layouts         = arexworks_admin_options_header_layout();
		$footer_layouts         = arexworks_admin_options_footer_layout();
		$inherit_image          = array(
			'alt' => __('Inherit','arw-leka' ),
			'img' => esc_url( arexworks_image . '/theme_options/layout/layout-off.png')
		);
		$page_style = arexworks_add_element_to_first_array('inherit',$inherit_image,$page_style);
		$page_header_layouts = arexworks_add_element_to_first_array('inherit',$inherit_image,$page_header_layouts);
		$header_layouts = arexworks_add_element_to_first_array('inherit',$inherit_image,$header_layouts);
		$footer_layouts = arexworks_add_element_to_first_array('inherit',$inherit_image,$footer_layouts);

		$yes_no_options = array(
			"" => __("Inherit", 'arw-leka'),
			"yes" => __("Yes", 'arw-leka'),
			"no" => __("no", 'arw-leka')
		);

		$block_data_options = array();

		return array(
			// Layout
			"_this_layout" => array(
				"name" => "_this_layout",
				"title" => __("Layout", 'arw-leka'),
				"desc" => __("Select layout.", 'arw-leka'),
				"type" => "image_select",
				"default" => "inherit",
				"options" => $theme_layouts
			),
			// Page Style
			"_this_page_style" => array(
				"name" => "_this_page_style",
				"title" => __("Page Style", 'arw-leka'),
				"desc" => __("Select Page Style.", 'arw-leka'),
				"type" => "select",
				"default" => "inherit",
				"options" => $page_style
			),
			// Header Layout
			"_this_header_layout" => array(
				"name" => "_this_header_layout",
				"title" => __("Header Layout", 'arw-leka'),
				"desc" => __("Select header layout.", 'arw-leka'),
				"type" => "select",
				"default" => "inherit",
				"options" => $header_layouts
			),
			"_this_header_transparency" => array(
				"name" => "_this_header_transparency",
				"title" => __("Header Transparency ?", 'arw-leka'),
				"desc" => __("Enable header transparency.", 'arw-leka'),
				"type" => "checkbox",
			),
			/*
			// Page Header Layout
			"_this_page_header_layout" => array(
				"name" => "_this_page_header_layout",
				"title" => __("Page Header Layout", 'arw-leka'),
				"desc" => __("Select page header layout.", 'arw-leka'),
				"type" => "select",
				"default" => "inherit",
				"options" => $page_header_layouts
			),
			*/
			"_this_page_header_title_background" => array(
				"name" => "_this_page_header_title_background",
				"title" => __("Page Header Title Background", 'arw-leka'),
				"desc" => __("Select image.", 'arw-leka'),
				"type" => "upload",
			),
			"_this_show_page_title" => array(
				"name" => "_this_show_page_title",
				"title" => __("Show Page Title ?", 'arw-leka' ),
				"type" => "radio",
				"options" => $yes_no_options
			),
			"_this_show_breadcrumbs" => array(
				"name" => "_this_show_breadcrumbs",
				"title" => __("Show breadcrumbs ?", 'arw-leka' ),
				"type" => "radio",
				"options" => $yes_no_options
			),
			"_this_hide_footer" => array(
				"name" => "_this_hide_footer",
				"title" => __("Hide Footer ?", 'arw-leka' ),
				"type" => "radio",
				"default" => "no",
				"options" => array(
					"yes" => __("Yes", 'arw-leka'),
					"no" => __("no", 'arw-leka')
				)
			),

			// Footer Layout
			"_this_footer_layout" => array(
				"name" => "_this_footer_layout",
				"title" => __("Footer Layout", 'arw-leka'),
				"desc" => __("Select footer layout.", 'arw-leka'),
				"type" => "select",
				"default" => "inherit",
				"options" => $footer_layouts
			),

			// Content Top
			"_this_block_content_top" => array(
				"name" => "_this_block_content_top",
				"title" => __("Block Content Top", 'arw-leka'),
				"desc" => __("You should input block slug name. You can create a block in Blocks/Add New.", 'arw-leka'),
				"type" => "text",
			),

			// Content Inner Top
			"_this_block_content_inner_top" => array(
				"name" => "_this_block_content_inner_top",
				"title" => __("Block Content Inner Top", 'arw-leka'),
				"desc" => __("You should input block slug name. You can create a block in Blocks/Add New.", 'arw-leka'),
				"type" => "text",
			),

			// Content Bottom
			"_this_block_content_bottom" => array(
				"name" => "_this_block_content_bottom",
				"title" => __("Block Content Bottom", 'arw-leka'),
				"desc" => __("You should input block slug name. You can create a block in Blocks/Add New.", 'arw-leka'),
				"type" => "text",
			),

			// Content inner Bottom
			"_this_block_content_inner_bottom" => array(
				"name" => "_this_block_content_inner_bottom",
				"title" => __("Block Content Inner Bottom", 'arw-leka'),
				"desc" => __("You should input block slug name. You can create a block in Blocks/Add New.", 'arw-leka'),
				"type" => "text",
			),
		);
	}
}

if ( !function_exists( 'arexworks_metaboxes_get_default_meta_skin' ) ) {
	function arexworks_metaboxes_get_default_meta_skin(){
		return array();
	}
}