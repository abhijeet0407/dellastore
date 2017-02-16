<?php

add_filter( 'arexworks_filter_option_data', 'arexworks_add_filter_theme_options_presets');
add_action( 'init', 'arexworks_flush_rewrite_rules');
add_action( 'wp_head', 'arexworks_add_custom_header_css', 999 );
add_action( 'wp_head', 'arexworks_add_custom_header_js', 999 );
add_action( 'wp_footer', 'arexworks_add_custom_footer_js', 999 );

add_action( 'arexworks_action_before_render_main', 'arexworks_get_block_content_top' );
add_action( 'arexworks_action_before_render_main_inner', 'arexworks_get_block_content_inner_top' );
add_action( 'arexworks_action_after_render_main_inner', 'arexworks_get_block_content_inner_bottom' );
add_action( 'arexworks_action_after_render_main', 'arexworks_get_block_content_bottom' );

add_filter( 'arexworks_filter_content_type_portfolio_name', 'arexworks_add_filter_content_type_portfolio_name' );
add_filter( 'arexworks_filter_content_type_portfolio_slug', 'arexworks_add_filter_content_type_portfolio_slug' );
add_filter( 'arexworks_filter_content_type_portfolio_cat_name', 'arexworks_add_filter_content_type_portfolio_cat_name' );
add_filter( 'arexworks_filter_content_type_portfolio_cat_slug', 'arexworks_add_filter_content_type_portfolio_cat_slug' );
add_filter( 'arexworks_filter_content_type_portfolio_skill_name', 'arexworks_add_filter_content_type_portfolio_skill_name' );
add_filter( 'arexworks_filter_content_type_portfolio_skill_slug', 'arexworks_add_filter_content_type_portfolio_skill_slug' );

if(!function_exists('arexworks_add_filter_theme_options_presets')){
	function arexworks_add_filter_theme_options_presets($options){
		if($_preset = get('_preset')){
			$_file = arexworks_options_preset . '/'.$_preset.'.json';
			if ( file_exists( $_file )) {
				require_once ABSPATH . '/wp-admin/includes/class-wp-filesystem-base.php';
				require_once ABSPATH . '/wp-admin/includes/class-wp-filesystem-direct.php';
				$arw_fs = new WP_Filesystem_Direct(false);
				if(!is_wp_error($arw_fs)){
					$_content = $arw_fs->get_contents($_file);
					$_options = json_decode( $_content, true );
					$options = array_merge( $options, $_options );
				}
			}
		}
		return $options;
	}
}

if(!function_exists('arexworks_flush_rewrite_rules')){
	function arexworks_flush_rewrite_rules(){
		if(get('flush_rewrite_rules') == 'yes'){
			flush_rewrite_rules();
		}
	}
}

if(!function_exists('arexworks_add_custom_header_css')){
	function arexworks_add_custom_header_css(){
		$style = '';
		$body_font_family = '';
		$heading_font_family = '';
		$highlight_font_family = '';

		$font_source = arexworks_get_option_data('font_source','1');

		switch($font_source){
			case "3":
				$body_font_family = arexworks_get_option_data('main_typekit_font_face','Lato');
				$heading_font_family = arexworks_get_option_data('secondary_typekit_font_face','Lato');
				$highlight_font_family = arexworks_get_option_data('highlight_typekit_font_face','Crimson Text');
				break;
			case "2":
				$body_font_family = arexworks_get_option_data('main_google_font_face','Lato');
				$heading_font_family = arexworks_get_option_data('secondary_google_font_face','Lato');
				$highlight_font_family = arexworks_get_option_data('highlight_google_font_face','Crimson Text');
				break;
			case "1":
				$body_font_family = arexworks_get_option_data('main_font','Lato','font-family');
				$heading_font_family = arexworks_get_option_data('secondary_font','Lato','font-family');
				$highlight_font_family = arexworks_get_option_data('highlight_font','Crimson Text','font-family');
				break;
		}

		$body_font_base = arexworks_get_option_data('body_font_size',13);
		$body_font_base .= 'px';
		$primary_color = arexworks_get_option_data('main_color','#7e883a');
		$secondary_color = arexworks_get_option_data('second_color','#303030');
		$border_color = arexworks_get_option_data('border_color','#e9e9e9');
		$body_font_color = arexworks_get_option_data('body_color','#747474');

		$heading_font_color = arexworks_get_option_data('heading_color','#303030');

		$menu_background = arexworks_get_option_data('main_menu_background','transparent');
		$menu_lv1_color = arexworks_get_option_data('main_menu_lv1_color','#303030');
		$menu_lv1_background = arexworks_get_option_data('main_menu_lv1_background_color','transparent');
		$menu_lv1_hover_color = arexworks_get_option_data('main_menu_lv1_hover_color',$primary_color);
		$menu_lv1_hover_background = arexworks_get_option_data('main_menu_lv1_hover_background_color','transparent');
		$submenu_background = arexworks_get_option_data('main_submenu_background_color','#fff');
		$submenu_link_color = arexworks_get_option_data('main_submenu_link_color','#303030');
		$submenu_link_hover_color = arexworks_get_option_data('main_submenu_link_hover_color',$primary_color);

		$menu_mobile_background = arexworks_get_option_data('menu_mobile_background','#1b1b1b');
		$menu_mobile_lv1_color = arexworks_get_option_data('menu_mobile_lv1_color','#676767');
		$menu_mobile_lv1_background = arexworks_get_option_data('menu_mobile_lv1_background','transparent');
		$menu_mobile_lv1_hover_color = arexworks_get_option_data('menu_mobile_lv1_hover_color','#fff');
		$menu_mobile_lv1_hover_background = arexworks_get_option_data('menu_mobile_lv1_hover_background','#2c2c2c');

		$header_sticky_background = arexworks_get_option_data('header_sticky_background','#fff');
		$header_sticky_lv1_color = arexworks_get_option_data('header_sticky_link_color','#303030');
		$header_sticky_lv1_background = arexworks_get_option_data('header_sticky_link_background_color','transparent');
		$header_sticky_lv1_hover_color = arexworks_get_option_data('header_sticky_link_hover_color',$primary_color);
		$header_sticky_lv1_hover_background = arexworks_get_option_data('header_sticky_link_hover_background_color','transparent');

		$header_text_color = arexworks_get_option_data('header_text_color','#303030');
		$header_link_color = arexworks_get_option_data('header_link_color','#303030');
		$header_link_hover_color = arexworks_get_option_data('header_link_hover_color',$primary_color);

		$page_header_title_color = arexworks_get_option_data('page_header_title_color','#fff');
		$page_header_text_color = arexworks_get_option_data('page_header_text_color','#fff');
		$page_header_link_color = arexworks_get_option_data('page_header_link_color','#fff');
		$page_header_link_hover_color = arexworks_get_option_data('page_header_link_hover_color','#fff');

		$footer_text_color = arexworks_get_option_data('footer_texts_color','#4b4a4a');
		$footer_heading_color = arexworks_get_option_data('footer_heading_color',$primary_color);
		$footer_link_color = arexworks_get_option_data('footer_links_color','#747474');
		$footer_link_hover_color = arexworks_get_option_data('footer_links_hover_color',$primary_color);

		$header_background_color = arexworks_get_option_data('main_header_background','#fff','background-color');
		$header_background_image = arexworks_get_option_data('main_header_background',false,'background-image');
		$header_background_repeat = arexworks_get_option_data('main_header_background',false,'background-repeat');
		$header_background_size = arexworks_get_option_data('main_header_background',false,'background-size');
		$header_background_attachment = arexworks_get_option_data('main_header_background',false,'background-attachment');
		$header_background_position = arexworks_get_option_data('main_header_background',false,'background-position');

		$footer_background_color = arexworks_get_option_data('main_footer_background','#fff','background-color');
		$footer_background_repeat = arexworks_get_option_data('main_footer_background',false,'background-repeat');
		$footer_background_image = arexworks_get_option_data('main_footer_background',false,'background-image');
		$footer_background_size = arexworks_get_option_data('main_footer_background',false,'background-size');
		$footer_background_attachment = arexworks_get_option_data('main_footer_background',false,'background-attachment');
		$footer_background_position = arexworks_get_option_data('main_footer_background',false,'background-position');

		$main_background_color = arexworks_get_option_data('main_background','#fff','background-color');
		$main_background_image = arexworks_get_option_data('main_background',false,'background-image');
		$main_background_repeat = arexworks_get_option_data('main_background',false,'background-repeat');
		$main_background_size = arexworks_get_option_data('main_background',false,'background-size');
		$main_background_attachment = arexworks_get_option_data('main_background',false,'background-attachment');
		$main_background_position = arexworks_get_option_data('main_background',false,'background-position');

		$main_boxed_background_color = arexworks_get_option_data('main_boxed_background','#f3f3f3','background-color');
		$main_boxed_background_image = arexworks_get_option_data('main_boxed_background',false,'background-image');
		$main_boxed_background_repeat = arexworks_get_option_data('main_boxed_background',false,'background-repeat');
		$main_boxed_background_size = arexworks_get_option_data('main_boxed_background',false,'background-size');
		$main_boxed_background_attachment = arexworks_get_option_data('main_boxed_background',false,'background-attachment');
		$main_boxed_background_position = arexworks_get_option_data('main_boxed_background',false,'background-position');

		if($header_background_image_theme_mod = get_header_image()){
			$header_background_image = $header_background_image_theme_mod;
		}
		if($header_text_color_theme_mod = get_header_textcolor()){
			$header_text_color = $header_text_color_theme_mod;
		}

		ob_start();
		include_once( trailingslashit(arexworks_function_dir) . 'dynamic_style.php');
?>
		<?php
		if($page_header_background_image = arexworks_get_theme_option_by_wp_query('page_header_title_background',false)) {
			$page_header_background_image_tmp = '';
			if ( is_array( $page_header_background_image ) ) {
				if ( isset( $page_header_background_image[ 'url' ] ) ) {
					$page_header_background_image_tmp = $page_header_background_image[ 'url' ];
				}
			}
			else {
				if(!empty($page_header_background_image)){
					$page_header_background_image_tmp = $page_header_background_image;
				}
			}
			if ( $page_header_background_image_tmp ) {
		?>
			.page-header-layout-1 .page-header-wrapper{
				background-image:url(<?php echo esc_url( $page_header_background_image_tmp ) ?>);
			}
		<?php
			}
		}
		?>
		@media only screen and (min-width: 991px) {
			.page-header-layout-1 .page-header-wrapper{
				padding-top:<?php echo esc_attr(arexworks_get_option_data('page_header_title_padding','50px','padding-top'));?>;
				padding-bottom:<?php echo esc_attr(arexworks_get_option_data('page_header_title_padding','50px','padding-bottom'));?>;
			}
		}
	body {
		background-color: <?php echo esc_html($main_background_color)?>;
		<?php if($main_background_repeat):?>
			background-repeat: <?php echo esc_html($main_background_repeat)?>;
		<?php endif;?>
		<?php if($main_background_attachment):?>
			background-attachment: <?php echo esc_html($main_background_attachment)?>;
		<?php endif;?>
		<?php if($main_background_position):?>
			background-position: <?php echo esc_html($main_background_position)?>;
		<?php endif;?>
		<?php if($main_background_size):?>
			background-size: <?php echo esc_html($main_background_size)?>;
		<?php endif;?>
		<?php if($main_background_image):?>
			background-image: url("<?php echo esc_url($main_background_image)?>");
		<?php endif;?>
	}
	.header-layout-3 .header-wrapper.header-side-nav #header:not(.active-sticky),
	#header.site-header:not(.active-sticky){
		background-color: <?php echo esc_html($header_background_color)?>;
		<?php if($header_background_repeat):?>
			background-repeat: <?php echo esc_html($header_background_repeat)?>;
		<?php endif;?>
		<?php if($header_background_attachment):?>
			background-attachment: <?php echo esc_html($header_background_attachment)?>;
		<?php endif;?>
		<?php if($header_background_position):?>
			background-position: <?php echo esc_html($header_background_position)?>;
		<?php endif;?>
		<?php if($header_background_size):?>
			background-size: <?php echo esc_html($header_background_size)?>;
		<?php endif;?>
		<?php if($header_background_image):?>
			background-image: url("<?php echo esc_url($header_background_image)?>");
		<?php endif;?>
	}
	.page-style-boxed{
		#page_wrapper{
			background-color: <?php echo esc_html($main_boxed_background_color)?>;
			<?php if($main_boxed_background_repeat):?>
				background-repeat: <?php echo esc_html($main_boxed_background_repeat)?>;
			<?php endif;?>
			<?php if($main_boxed_background_attachment):?>
				background-attachment: <?php echo esc_html($main_boxed_background_attachment)?>;
			<?php endif;?>
			<?php if($main_boxed_background_position):?>
				background-position: <?php echo esc_html($main_boxed_background_position)?>;
			<?php endif;?>
			<?php if($main_boxed_background_size):?>
				background-size: <?php echo esc_html($main_boxed_background_size)?>;
			<?php endif;?>
			<?php if($main_boxed_background_image):?>
				background-image: url("<?php echo esc_url($main_boxed_background_image)?>");
			<?php endif;?>
		}
	}
	.footer-wrapper #site-footer{
		background-color: <?php echo esc_html($footer_background_color)?>;
		<?php if($footer_background_repeat):?>
			background-repeat: <?php echo esc_html($footer_background_repeat)?>;
		<?php endif;?>
		<?php if($footer_background_attachment):?>
			background-attachment: <?php echo esc_html($footer_background_attachment)?>;
		<?php endif;?>
		<?php if($footer_background_position):?>
			background-position: <?php echo esc_html($footer_background_position)?>;
		<?php endif;?>
		<?php if($footer_background_size):?>
			background-size: <?php echo esc_html($footer_background_size)?>;
		<?php endif;?>
		<?php if($footer_background_image):?>
			background-image: url("<?php echo esc_url($footer_background_image)?>");
		<?php endif;?>
	}

<?php
if(is_user_logged_in()){
	echo ".show_when_login{ display:inline-block !important;}";
	echo ".hide_when_login{ display:none !important; }";
}else{
	echo ".show_when_login{ display:none !important; }";
}
?>

<?php
		echo arexworks_get_option_data( 'custom_css' );
		$style .= ob_get_clean();
		if($style != ''){
			echo '<style type="text/css">'.arexworks_compress_text($style).'</style>';
		}
	}
}

if(!function_exists('arexworks_add_custom_header_js')){
	function arexworks_add_custom_header_js(){
		if($header_js = arexworks_get_option_data('header_js')){
			$header_js = 'try{ '.$header_js.' }catch(ex){ }';
			echo '<script type="text/javascript">/* <![CDATA[ */' . $header_js . '/* ]]> */</script>';
		}
	}
}

if(!function_exists('arexworks_add_custom_footer_js')){
	function arexworks_add_custom_footer_js(){
		if($footer_js = arexworks_get_option_data('footer_js')){
			$footer_js = 'try{ '.$footer_js.' }catch(ex){ }';
			echo '<script type="text/javascript">/* <![CDATA[ */' . $footer_js . '/* ]]> */</script>';
		}
	}
}

if(!function_exists('arexworks_add_favicon_to_head')){
	if(!function_exists( 'wp_site_icon' ) ){
		add_action('wp_head','arexworks_add_favicon_to_head');
	}
	function arexworks_add_favicon_to_head(){
		$favicon_src = arexworks_get_option_data('favicon',trailingslashit( arexworks_image ) . 'favicon.png','url');
		$favicon_src = esc_url($favicon_src);
		echo "<link rel='shortcut icon' href='$favicon_src' />";
	}
}

if (!function_exists('arexworks_add_filter_content_type_portfolio_name')){
	function arexworks_add_filter_content_type_portfolio_name( $output ){
		return arexworks_get_option_data('portfolio_name' , $output);
	}
}
if (!function_exists('arexworks_add_filter_content_type_portfolio_slug')){
	function arexworks_add_filter_content_type_portfolio_slug( $output ){
		return arexworks_get_option_data('portfolio_slug' , $output);
	}
}
if (!function_exists('arexworks_add_filter_content_type_portfolio_cat_name')){
	function arexworks_add_filter_content_type_portfolio_cat_name( $output ){
		return arexworks_get_option_data('portfolio_category_name' , $output);
	}
}
if (!function_exists('arexworks_add_filter_content_type_portfolio_cat_slug')){
	function arexworks_add_filter_content_type_portfolio_cat_slug( $output ){
		return arexworks_get_option_data('portfolio_category_slug' , $output);
	}
}
if (!function_exists('arexworks_add_filter_content_type_portfolio_skill_name')){
	function arexworks_add_filter_content_type_portfolio_skill_name( $output ){
		return arexworks_get_option_data('portfolio_skill_name' , $output);
	}
}
if (!function_exists('arexworks_add_filter_content_type_portfolio_skill_slug')){
	function arexworks_add_filter_content_type_portfolio_skill_slug( $output ){
		return arexworks_get_option_data('portfolio_skill_slug' , $output);
	}
}