<?php
if ( ! class_exists( 'Arexworks_Theme_Options' ) ) {
	class Arexworks_Theme_Options {

		public $args = array();
		public $sections = array();
		public $theme;
		public $ReduxFramework;

		public function __construct() {
			if ( ! class_exists( 'ReduxFramework' ) ) {
				return;
			}
			$this->initSettings();
		}

		public function get_field_layouts($id,$title,$default,$subtitle = '',$desc = '' ){
			if(empty($desc)){
				$desc = __('Select main content and sidebar alignment. Choose between 1, 2 or 3 column layout.','arw-leka');
			}
			$layout = array(
				'id'        => 'layout_'.$id,
				'type'      => 'image_select',
				'title'     => $title,
				'subtitle'  => $subtitle,
				'desc'      => $desc,
				'options'   => arexworks_admin_options_layout_inherit(),
				'default'   => $default
			);
			return $layout;
		}

		public function initSettings() {

			// Just for demo purposes. Not needed per say.
			$this->theme = wp_get_theme();

			// Set the default arguments
			$this->setArguments();

			// Create the sections and fields
			$this->setSections();

			if ( ! isset( $this->args['opt_name'] ) ) { // No errors please
				return;
			}

			$this->ReduxFramework = new ReduxFramework( $this->sections, $this->args );
		}

		public function setSections() {


			$this->sections[] = array(
				'icon'   => 'fa fa-tachometer',
				'title'  => __( 'General', 'arw-leka' ),
				// 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
				'fields' => array(
					array(
						'id'        => 'layout_global',
						'type'      => 'image_select',
						'title'     => __('Main Layout Global', 'arw-leka'),
						'desc'      => __('Select main content and sidebar alignment. Choose between 1, 2 or 3 column layout.', 'arw-leka'),
						'options'   => arexworks_admin_options_layout_global(),
						'default'   => 'col-1c'
					),
					array(
						'id'       => 'page_style_global',
						'type'     => 'select',
						'title'    => __( 'Page Style Global', 'arw-leka' ),
						'options'  => arexworks_admin_options_page_style(),
						'default'  => 'stretched'
					),
					array (
						'title' => __('Favicon', 'arw-leka'),
						'subtitle' => __('<em>Upload your custom Favicon image. <br>.ico or .png file required.</em>', 'arw-leka'),
						'id' => 'favicon',
						'type' => 'media',
						'default' => array (
							'url' => esc_url( arexworks_image . '/favicon.png'),
						),
					),
					array(
						'id'       => 'show_popup',
						'type'     => 'select',
						'title'    => __( 'Show Popup', 'arw-leka' ),
						'options'  =>  array(
							'no'        => __('None', 'arw-leka'),
							'all'       => __('All Page', 'arw-leka'),
							'home'      => __('Home Page', 'arw-leka')
						),
						'default'  => 'no',
					),
					array (
						'title' => __('Popup Content', 'arw-leka'),
						'subtitle' => __('<em>Paste your custom HTML code here.</em>', 'arw-leka'),
						'id' => 'popup_content',
						'type' => 'ace_editor',
						'mode' => 'html',
						'required' => array('show_popup','!=','no')
					),
				),
			);

			$this->sections[] = array(
				'icon'   => 'fa fa-arrow-circle-up',
				'title'  => __( 'Header', 'arw-leka' ),
				'fields' => array(

					array(
						'id'       => 'header_layout_global',
						'type'     => 'image_select',
						'title'    => __( 'Header Layout', 'arw-leka' ),
						'subtitle' => __( "<em>Select the Layout style for the Header.</em><small><em>if it's layout 3 footer will be hidden on desktop</em></small>", 'arw-leka' ),
						'options'  => arexworks_admin_options_header_layout(),
						'default'  => '1'
					),

					array (
						'id' => 'header_bg_options',
						'icon' => true,
						'type' => 'info',
						'raw' => '<h3 style="margin: 0;"><i class="fa fa-eyedropper"></i> Header Background</h3>',
					),

					array(
						'id'       		=> 'main_header_background',
						'type'     		=> 'background',
						'title'    		=> "Header Background Color",
						'subtitle' 		=> "<em>The Main Header background.</em>",
						'default'  => array(
							'background-color' => '#fff',
						),
						'transparent' 	=> true,
					),
					array (
						'title' => __('Header Text Color', 'arw-leka'),
						'id' => 'header_text_color',
						'type' => 'color',
						'default' => '#303030',
						'transparent' => false,
					),
					array (
						'title' => __('Header Link Color', 'arw-leka'),
						'id' => 'header_link_color',
						'type' => 'color',
						'default' => '#303030',
						'transparent' => false,
					),
					array (
						'title' => __('Header Link Hover Color', 'arw-leka'),
						'id' => 'header_link_hover_color',
						'type' => 'color',
						'default' => '#7e883a',
						'transparent' => false,
					),
					array(
						'id'       		=> 'main_menu_background',
						'type'     		=> 'color',
						'title'    		=> "Main Menu Background",
						'subtitle' 		=> "<em>The Main Menu background.</em>",
						'default'       => '#fff',
						'transparent' 	=> true,
					),
					array (
						'title' => __('Main Menu Level 1 Color', 'arw-leka'),
						'id' => 'main_menu_lv1_color',
						'type' => 'color',
						'default' => '#303030',
						'transparent' 	=> false,
					),
					array (
						'title' => __('Main Menu Level 1 Background Color', 'arw-leka'),
						'id' => 'main_menu_lv1_background_color',
						'type' => 'color',
						'default' => 'transparent',
						'transparent' 	=> true,
					),
					array (
						'title' => __('Main Menu Level 1 Hover Color', 'arw-leka'),
						'id' => 'main_menu_lv1_hover_color',
						'type' => 'color',
						'default' => '#7e883a',
						'transparent' 	=> false,
					),
					array (
						'title' => __('Main Menu Level 1 Hover Background Color', 'arw-leka'),
						'id' => 'main_menu_lv1_hover_background_color',
						'type' => 'color',
						'default' => 'transparent',
						'transparent' 	=> true,
					),
					array (
						'title' => __('Main SubMenu Background Color', 'arw-leka'),
						'id' => 'main_submenu_background_color',
						'type' => 'color',
						'default' => '#fff',
						'transparent' 	=> false,
					),
					array (
						'title' => __('Main SubMenu Link Color', 'arw-leka'),
						'id' => 'main_submenu_link_color',
						'type' => 'color',
						'default' => '#303030',
						'transparent' 	=> false,
					),
					array (
						'title' => __('Main SubMenu Link Hover Color', 'arw-leka'),
						'id' => 'main_submenu_link_hover_color',
						'type' => 'color',
						'default' => '#7e883a',
						'transparent' 	=> false,
					),
				),
			);

			$this->sections[] = array(
				'icon'       => 'fa fa-angle-right',
				'title'      => __( 'Header Elements', 'arw-leka' ),
				'subsection' => true,
				'fields'     => array(

					array (
						'id' => 'bag_header_info',
						'icon' => true,
						'type' => 'info',
						'raw' => '<h3 style="margin: 0;"><i class="fa fa-shopping-cart"></i> Shopping Cart Icon</h3>',
					),

					array (
						'title' => __('Main Header Shopping Bag', 'arw-leka'),
						'subtitle' => __('<em>Enable / Disable the Shopping Bag in the Header.</em>', 'arw-leka'),
						'id' => 'main_header_shopping_bag',
						'on' => __('Enabled', 'arw-leka'),
						'off' => __('Disabled', 'arw-leka'),
						'type' => 'switch',
						'default' => 1,
					),

					array (
						'id' => 'search_header_info',
						'icon' => true,
						'type' => 'info',
						'raw' => '<h3 style="margin: 0;"><i class="fa fa-search"></i> Search Icon</h3>',
					),

					array (
						'title' => __('Main Header Search bar', 'arw-leka'),
						'subtitle' => __('<em>Enable / Disable the Search Bar in the Header.</em>', 'arw-leka'),
						'id' => 'main_header_search_bar',
						'on' => __('Enabled', 'arw-leka'),
						'off' => __('Disabled', 'arw-leka'),
						'type' => 'switch',
						'default' => 1,
					),
					array (
						'title' => __('Use search post is default', 'arw-leka'),
						'id' => 'main_header_search_default',
						'on' => __('Enabled', 'arw-leka'),
						'off' => __('Disabled', 'arw-leka'),
						'type' => 'switch',
						'default' => 0,
					),

				)
			);

			$this->sections[] = array(
				'icon'       => 'fa fa-angle-right',
				'title'      => __( 'Logo', 'arw-leka' ),
				'subsection' => true,
				'fields'     => array(

					array (
						'title' => __('Your Logo', 'arw-leka'),
						'subtitle' => __('<em>Upload your logo image.</em>', 'arw-leka'),
						'id' => 'site_logo',
						'type' => 'media',
						'default' => array (
							'url' => esc_url( arexworks_image . '/logo.png' ),
						)
					),

					array (
						'title' => __('Alternative Logo', 'arw-leka'),
						'subtitle' => __('<em>The Alternative Logo is used on the <strong>Sticky Header</strong> and <strong>Mobile Devices</strong>.</em>', 'arw-leka'),
						'id' => 'site_logo_alt',
						'type' => 'media',
						'default' => array (
							'url' => esc_url( arexworks_image . '/logo.png'),
						)
					)
				)
			);

			$this->sections[] = array(
				'icon'       => 'fa fa-angle-right',
				'title'      => __( 'Top Bar', 'arw-leka' ),
				'subsection' => true,
				'fields'     => array(
					/*
					array (
						'title' => __('Top Bar Background Color', 'arw-leka'),
						'subtitle' => __('<em>The Top Bar background color.</em>', 'arw-leka'),
						'id' => 'top_bar_background_color',
						'type' => 'color',
						'default' => '#fff',
					),

					array (
						'title' => __('Top Bar Text Color', 'arw-leka'),
						'subtitle' => __('<em>Specify the Top Bar Typography.</em>', 'arw-leka'),
						'id' => 'top_bar_text_color',
						'type' => 'color',
						'default' => '#303030',
						'transparent' => false,
					),

					array (
						'title' => __('Top Bar Link Color', 'arw-leka'),
						'subtitle' => __('<em>Specify the Top Bar Typography.</em>', 'arw-leka'),
						'id' => 'top_bar_link_color',
						'type' => 'color',
						'default' => '#303030',
						'transparent' => false,
					),
					array (
						'title' => __('Top Bar Link Hover Color', 'arw-leka'),
						'subtitle' => __('<em>Specify the Top Bar Typography.</em>', 'arw-leka'),
						'id' => 'top_bar_link_hover_color',
						'type' => 'color',
						'default' => '#7e883a',
						'transparent' => false,
					),
					*/
					array (
						'title' => __('Top Bar Custom Text', 'arw-leka'),
						'subtitle' => __('<em>Type in your Top Bar info here.</em>', 'arw-leka'),
						'id' => 'top_bar_text',
						'type' => 'textarea',
						'default' => '<ul>
	<li><i class="fa fa-phone"></i><span>+84 868.8568</span></li>
	<li><i class="fa fa-clock-o"></i><span>MON - SAT: 08 am - 17 pm</span></li>
	<li><i class="fa fa-envelope-o"></i><a href="mailto:support@wpelite.com">Support@wpelite.com</a></li>
</ul>'
					)
				)
			);

			$this->sections[] = array(
				'icon'       => 'fa fa-angle-right',
				'title'      => __( 'Sticky Header', 'arw-leka' ),
				'subsection' => true,
				'fields'     => array(

					array (
						'title' => __('Sticky Header', 'arw-leka'),
						'subtitle' => __('<em>Enable / Disable the Sticky Header.</em>', 'arw-leka'),
						'id' => 'sticky_header',
						'on' => __('Enabled', 'arw-leka'),
						'off' => __('Disabled', 'arw-leka'),
						'type' => 'switch',
						'default' => 1,
					),

					array (
						'title' => __('Hide Logo In Header Sticky', 'arw-leka'),
						'id' => 'sticky_header_hide_logo',
						'on' => __('Yes', 'arw-leka'),
						'off' => __('No', 'arw-leka'),
						'type' => 'switch',
						'default' => 0,
						'required' => array('sticky_header','=','1')
					),
					array (
						'title' => __('Hide Search Form In Header Sticky', 'arw-leka'),
						'id' => 'sticky_header_hide_search',
						'on' => __('Yes', 'arw-leka'),
						'off' => __('No', 'arw-leka'),
						'type' => 'switch',
						'default' => 0,
						'required' => array('sticky_header','=','1')
					),
					array (
						'title' => __('Hide Cart Box Header Sticky', 'arw-leka'),
						'id' => 'sticky_header_hide_cart',
						'on' => __('Yes', 'arw-leka'),
						'off' => __('No', 'arw-leka'),
						'type' => 'switch',
						'default' => 0,
						'required' => array('sticky_header','=','1')
					),
					array (
						'title' => __('Sticky Header Background Color', 'arw-leka'),
						'subtitle' => __('<em>The Sticky Header background Color.</em>', 'arw-leka'),
						'id' => 'header_sticky_background',
						'type' => 'color',
						'default' => '#fff',
						'transparent' => false,
						'required' => array('sticky_header','=','1')
					),

					array (
						'title' => __('Sticky Header Link Color', 'arw-leka'),
						'subtitle' => __('<em>The Sticky Header Link Color.</em>', 'arw-leka'),
						'id' => 'header_sticky_link_color',
						'type' => 'color',
						'default' => '#303030',
						'transparent' => false,
						'required' => array('sticky_header','=','1')
					),
					array (
						'title' => __('Sticky Header Link Background Color', 'arw-leka'),
						'subtitle' => __('<em>The Sticky Header Link Background Color.</em>', 'arw-leka'),
						'id' => 'header_sticky_link_background_color',
						'type' => 'color',
						'default' => '',
						'transparent' => true,
						'required' => array('sticky_header','=','1')
					),
					array (
						'title' => __('Sticky Header Link Hover Color', 'arw-leka'),
						'subtitle' => __('<em>The Sticky Header Link Hover Color.</em>', 'arw-leka'),
						'id' => 'header_sticky_link_hover_color',
						'type' => 'color',
						'default' => '#7e883a',
						'transparent' => false,
						'required' => array('sticky_header','=','1')
					),
					array (
						'title' => __('Sticky Header Link Hover Background Color', 'arw-leka'),
						'subtitle' => __('<em>The Sticky Header Link Hover Background Color.</em>', 'arw-leka'),
						'id' => 'header_sticky_link_hover_background_color',
						'type' => 'color',
						'default' => '',
						'transparent' => true,
						'required' => array('sticky_header','=','1')
					),
				)
			);

			$this->sections[] = array(
				'icon' => 'el-icon-website',
				'icon_class' => 'icon',
				'title' => __('Page Header', 'arw-leka'),
				'fields' => array(
					/*
					array(
						'id'=>'page_header_layout_global',
						'type' => 'image_select',
						'full_width' => true,
						'title' => __('Page Header Layout', 'arw-leka'),
						'options' => arexworks_admin_options_page_header_layout(),
						'default' => '1'
					),
					array(
						'id'=>'breadcrumbs_type_global',
						'type' => 'image_select',
						'full_width' => true,
						'title' => __('Breadcrumbs Type', 'arw-leka'),
						'options' => arexworks_admin_options_breadcrumbs_type(),
						'default' => '1'
					),
					*/
					array(
						'id'       => 'page_header_title_background_global',
						'type'     => 'media',
						'url'      => true,
						'title'    => __('Page Header Title Background',  'arw-leka'),
						'default'  => array(
							'url'=> esc_url(arexworks_image . '/bg-page-header-default.jpg')
						),
					),

					array(
						'id'             => 'page_header_title_padding',
						'type'           => 'spacing',
						'mode'           => 'padding',
						'units'          => 'px',
						'units_extended' => 'false',
						'title'          => __('Gap between page header title', 'arw-leka'),
						'left'         => false,
						'right'         => false,
						'default'            => array(
							'padding-top'     => '170px',
							'padding-bottom'  => '170px'
						)
					),

					array(
						'id'=>'show_breadcrumbs_global',
						'type' => 'switch',
						'title' => __('Show Breadcrumbs', 'arw-leka'),
						'default' => true,
						'on' => __('Yes', 'arw-leka'),
						'off' => __('No', 'arw-leka'),
					),

					array(
						'id'=>'show_page_title_global',
						'type' => 'switch',
						'title' => __('Show Page Title', 'arw-leka'),
						'default' => true,
						'on' => __('Yes', 'arw-leka'),
						'off' => __('No', 'arw-leka'),
					),

					array(
						'id'=>'breadcrumbs_blog_link_global',
						'type' => 'switch',
						'title' => __('Show Blog Link', 'arw-leka'),
						'default' => true,
						'on' => __('Yes', 'arw-leka'),
						'off' => __('No', 'arw-leka'),
					),

					array(
						'id'=>'breadcrumbs_archives_link_global',
						'type' => 'switch',
						'title' => __('Show Custom Post Type Archives Link', 'arw-leka'),
						'default' => true,
						'on' => __('Yes', 'arw-leka'),
						'off' => __('No', 'arw-leka'),
					),

					array(
						'id'=>'breadcrumbs_categories_global',
						'type' => 'switch',
						'title' => __('Show Post Categories Link', 'arw-leka'),
						'default' => true,
						'on' => __('Yes', 'arw-leka'),
						'off' => __('No', 'arw-leka'),
					),

					array(
						'id'=>'breadcrumbs_enable_google_rich_snippets',
						'type' => 'switch',
						'title' => __('Enable Google Rich Snipets', 'arw-leka'),
						'default' => true,
						'on' => __('Yes', 'arw-leka'),
						'off' => __('No', 'arw-leka'),
					),
					array (
						'title' => __('Page Header Title Color', 'arw-leka'),
						'subtitle' => __('<em>Page Header Title Color.</em>', 'arw-leka'),
						'id' => 'page_header_title_color',
						'type' => 'color',
						'default' => '#fff',
						'transparent' => false,
					),
					array (
						'title' => __('Page Header Text Color', 'arw-leka'),
						'subtitle' => __('<em>Page Header Text Color.</em>', 'arw-leka'),
						'id' => 'page_header_text_color',
						'type' => 'color',
						'default' => '#fff',
						'transparent' => false,
					),
					array (
						'title' => __('Page Header Link Color', 'arw-leka'),
						'subtitle' => __('<em>Page Header Link Color.</em>', 'arw-leka'),
						'id' => 'page_header_link_color',
						'type' => 'color',
						'default' => '#fff',
						'transparent' => false,
					),
					array (
						'title' => __('Page Header Link Hover Color', 'arw-leka'),
						'subtitle' => __('<em>Page Header Link Hover Color.</em>', 'arw-leka'),
						'id' => 'page_header_link_hover_color',
						'type' => 'color',
						'default' => '#fff',
						'transparent' => false,
					),
				)
			);


$payment_logo = '<a target="_blank" href="#"><img title="PayPal" alt="PayPal" src="'. esc_url( arexworks_image . '/payment_image_paypal.png' ) .'"/></a>';
$payment_logo .= '<a target="_blank" href="#"><img title="PayPal" alt="PayPal" src="'. esc_url( arexworks_image . '/payment_image_visa.png' ) . '"></a>';
$payment_logo .= '<a target="_blank" href="#"><img title="Master Card" alt="Master Card" src="'. esc_url( arexworks_image . '/payment_image_mastercard.png' ) . '"></a>';
$payment_logo .= '<a target="_blank" href="#"><img title="Maestro" alt="Maestro" src="'. esc_url( arexworks_image . '/payment_image_maestro.png' ) . '"></a>';
$payment_logo .= '<a target="_blank" href="#"><img title="Discover" alt="Discover" src="'. esc_url( arexworks_image . '/payment_image_discover.png' ) . '"></a>';
$payment_logo .= '<a target="_blank" href="#"><img title="Money Bookers" alt="Money Bookers" src="'. esc_url( arexworks_image . '/payment_image_moneybookers.png' ) . '"></a>';

			$this->sections[] = array(
				'icon'    => 'fa fa-arrow-circle-down',
				'title'   => __( 'Footer', 'arw-leka' ),
				'fields'  => array(
					array(
						'id'       => 'footer_layout_global',
						'type'     => 'image_select',

						'title'    => __( 'Footer Layout', 'arw-leka' ),
						'subtitle' => __( '<em>Select the Layout style for the Footer.</em>', 'arw-leka' ),
						'options'  => arexworks_admin_options_footer_layout(),
						'default'  => '1'
					),
					array (
						'title' => __('Footer Background', 'arw-leka'),
						'subtitle' => __('<em>The Footer background.</em>', 'arw-leka'),
						'id' => 'main_footer_background',
						'type' => 'background',
						'default'  => array(
							'background-color' => '#1f1f1f',
						),
						'transparent' 	=> true,
					),

					array (
						'title' => __('Footer Text', 'arw-leka'),
						'subtitle' => __('<em>Specify the Footer Text Color.</em>', 'arw-leka'),
						'id' => 'footer_texts_color',
						'type' => 'color',
						'transparent' => false,
						'default' => '#4b4a4a',
					),

					array (
						'title' => __('Footer Links', 'arw-leka'),
						'subtitle' => __('<em>Specify the Footer Links Color.</em>', 'arw-leka'),
						'id' => 'footer_links_color',
						'type' => 'color',
						'transparent' => false,
						'default' => '#747474',
					),
					array (
						'title' => __('Footer Links Hover Color', 'arw-leka'),
						'subtitle' => __('<em>Specify the Footer Links Hover Color.</em>', 'arw-leka'),
						'id' => 'footer_links_hover_color',
						'type' => 'color',
						'transparent' => false,
						'default' => '#7e883a',
					),
					array (
						'title' => __('Footer Heading', 'arw-leka'),
						'subtitle' => __('<em>Specify the Footer Heading Color.</em>', 'arw-leka'),
						'id' => 'footer_heading_color',
						'type' => 'color',
						'transparent' => false,
						'default' => '#7e883a',
					),

					array (
						'title' => __('Footer Copyright Text', 'arw-leka'),
						'subtitle' => __('<em>Enter your copyright information here.</em>', 'arw-leka'),
						'id' => 'footer_copyright_text',
						'type' => 'text',
						'default' => '&copy; 2015 ArexWorks. All Rights Reserved. <a target="_blank" href="http://www.arexworks.com">WordPress Theme</a> by <strong>ArexWorks</strong>',
					),
					array (
						'title' => __('Footer Copyright Right Text', 'arw-leka'),
						'subtitle' => __('<em>Enter your copyright right information here.</em>', 'arw-leka'),
						'id' => 'footer_copyright_right_text',
						'type' => 'textarea',
						'default' => $payment_logo
					),

				)
			);

			$this->sections[] = array(
				'icon'   => 'fa fa-list-alt',
				'title'  => __( 'Blog', 'arw-leka' ),
				'fields' => array(
					$this->get_field_layouts('blog',__('Blog Layout','arw-leka'),'col-1c'),
					$this->get_field_layouts('single',__('Single Post Layout','arw-leka'),'col-2cl'),

					array(
						'id'       => 'blog_post_display_type',
						'type'     => 'select',
						'title'    => __('Blog Post display type','arw-leka'),
						'options'  => arexworks_admin_options_blog_display_type(),
						'default'  => 'grid',
					),
					array(
						'id'       => 'blog_post_columns',
						'type'     => 'select',
						'title'    => __('Blog Post Columns','arw-leka'),
						'options'  => array(
							'1' => __('1 Column', 'arw-leka'),
							'2' => __('2 Columns', 'arw-leka'),
							'3' => __('3 Columns', 'arw-leka'),
							'4' => __('4 Columns', 'arw-leka'),
							'5' => __('5 Columns', 'arw-leka'),
							'6' => __('6 Columns', 'arw-leka')
						),
						'default'  => '3',
					),
					array (
						'title' => __('Enable Infinite Scroll', 'arw-leka'),
						'id' => 'blog_enable_infinite_scroll',
						'on' => __('Enabled', 'arw-leka'),
						'off' => __('Disabled', 'arw-leka'),
						'type' => 'switch',
						'default'  => true,
					),

					array (
						'id' => 'blog_single_info',
						'icon' => true,
						'type' => 'info',
						'raw' => __('<h3 style="margin: 0;">Single Post</h3>', 'arw-leka'),
					),
					array (
						'title' => __('Show Author Bio', 'arw-leka'),
						'id' => 'single_show_author_bio',
						'on' => __('Enabled', 'arw-leka'),
						'off' => __('Disabled', 'arw-leka'),
						'type' => 'switch',
						'default'  => true,
					),
					array (
						'title' => __('Show Related Articles', 'arw-leka'),
						'id' => 'single_show_related_articles',
						'on' => __('Enabled', 'arw-leka'),
						'off' => __('Disabled', 'arw-leka'),
						'type' => 'switch',
						'default'  => true,
					),
					array(
						'id'       => 'single_show_related_articles_by',
						'type'     => 'select',
						'title'    => __('Related Articles By','arw-leka'),
						'options'  => array(
							'tag'      => __('Tag','arw-leka'),
							'category'  => __('Category','arw-leka'),
							'both'       => __('Both', 'arw-leka')
						),
						'default'  => 'category',
						'required' => array('single_show_related_articles','=','1')
					),
					array(
						'title' => __('Number Post Related Articles', 'arw-leka'),
						'id' => 'single_show_related_articles_number',
						'type' => 'slider',
						"default" => 5,
						"min" => 1,
						"step" => 1,
						"max" => 20,
						'display_value' => 'text',
						'required' => array('single_show_related_articles','=','1')
					),
					array (
						'title' => __('Show Related Articles By Author', 'arw-leka'),
						'id' => 'single_show_related_articles_by_author',
						'on' => __('Enabled', 'arw-leka'),
						'off' => __('Disabled', 'arw-leka'),
						'type' => 'switch',
						'default'  => true,
					),
					array(
						'title' => __('Number Post Related Articles By Author', 'arw-leka'),
						'id' => 'single_show_related_articles_by_author_number',
						'type' => 'slider',
						"default" => 5,
						"min" => 1,
						"step" => 1,
						"max" => 20,
						'display_value' => 'text',
						'required' => array('single_show_related_articles_by_author','=','1')
					),
				)
			);

			$this->sections[] = array(
				'icon'   => 'fa fa-shopping-cart',
				'title'  => __( 'Shop', 'arw-leka' ),
				'fields' => array(
					$this->get_field_layouts('shop',__('Shop Layout','arw-leka'),'col-2cl'),
					array (
						'title' => __('Catalog Mode', 'arw-leka'),
						'subtitle' => __('<em>Enable / Disable the Catalog Mode.</em>', 'arw-leka'),
						'desc' => __('<em>When enabled, the feature Turns Off the shopping functionality of WooCommerce.</em>', 'arw-leka'),
						'id' => 'catalog_mode',
						'on' => __('Enabled', 'arw-leka'),
						'off' => __('Disabled', 'arw-leka'),
						'type' => 'switch',
						'default'  => false,
					),

					array(
						'id'       => 'catalog_display_type_global',
						'type'     => 'select',
						'title'    => __('Catalog Display Type','arw-leka'),
						'default' => 'grid',
						'options'  => array(
							'grid'      => __('Grid', 'arw-leka'),
							'list'      => __('List', 'arw-leka'),
						)
					),

					array (
						'title' => __('Number of Products per Column', 'arw-leka'),
						'subtitle' => __('<em>Drag the slider to set the number of products per column <br />to be listed on the shop page and catalog pages.</em>', 'arw-leka'),
						'id' => 'products_per_column',
						'min' => '2',
						'step' => '1',
						'max' => '6',
						'type' => 'slider',
						'default' => '3',
					),

					array (
						'title' => __('Products per Page on Grid Allowed Values', 'arw-leka'),
						'desc' => __('Comma-separated.','arw-leka'),
						'id' => 'products_per_page',
						'type' => 'text',
						'default' => '9,15,30'
					),
					array (
						'title' => __('Products per Page On Grid Default', 'arw-leka'),
						'id' => 'products_per_page_default',
						'min' => '1',
						'step' => '1',
						'max' => '50',
						'type' => 'slider',
						'edit' => '1',
						'default' => '9',
					),
					array (
						'title' => __('Products per Page on List Allowed Values', 'arw-leka'),
						'desc' => __('Comma-separated.','arw-leka'),
						'id' => 'products_per_page_list',
						'type' => 'text',
						'default' => '3,6,9'
					),
					array (
						'title' => __('Products per Page On List Default', 'arw-leka'),
						'id' => 'products_per_page_list_default',
						'min' => '1',
						'step' => '1',
						'max' => '50',
						'type' => 'slider',
						'edit' => '1',
						'default' => '3',
					),

					array (
						'title' => __('Enable Infinite Scroll', 'arw-leka'),
						'id' => 'shop_enable_infinite_scroll',
						'on' => __('Enabled', 'arw-leka'),
						'off' => __('Disabled', 'arw-leka'),
						'type' => 'switch',
						'default' => 1,
					),

					array (
						'title' => __('Second Image on Catalog Page (Hover)', 'arw-leka'),
						'subtitle' => __('<em>Enable / Disable the Second Image on Product Listing.</em>', 'arw-leka'),
						'id' => 'second_image_product_listing',
						'on' => __('Enabled', 'arw-leka'),
						'off' => __('Disabled', 'arw-leka'),
						'type' => 'switch',
						'default' => 1,
					),

					array (
						'title' => __('Ratings on Catalog Page', 'arw-leka'),
						'subtitle' => __('<em>Enable / Disable Ratings on Catalog Page.</em>', 'arw-leka'),
						'id' => 'ratings_catalog_page',
						'on' => __('Enabled', 'arw-leka'),
						'off' => __('Disabled', 'arw-leka'),
						'type' => 'switch',
						'default' => 1,
					),

				)
			);

			$this->sections[] = array(
				'icon'   => 'fa fa-archive',
				'title'  => __( 'Product Page', 'arw-leka' ),
				'fields' => array(
					$this->get_field_layouts('product_single',__('Product Page Layout','arw-leka'),'col-1c'),
					array (
						'title' => __('Product Gallery Zoom', 'arw-leka'),
						'subtitle' => __('<em>Enable / Disable Product Gallery Zoom.<em>', 'arw-leka'),
						'id' => 'product_gallery_zoom',
						'on' => __('Enabled', 'arw-leka'),
						'off' => __('Disabled', 'arw-leka'),
						'type' => 'switch',
						'default' => 1,
					),

					array(
						'id'       => 'custom_html_service_bellow_add_cart',
						'type'     => 'editor',
						'title'    => __('Custom HTML Service Bellow Add Cart','arw-leka'),
						'args'   => array(
							'teeny'            => true,
							'textarea_rows'    => 10
						),
						'default'=> '<ul class="custom-icon-box">
							<li><i class="fa fa-plane"></i>FREE SHIPPING WORLD WIDE</li>
							<li><i class="fa fa-whatsapp"></i>24/24 ONLINE SUPPORT CUSTOME</li>
							<li><i class="fa fa-dollar"></i>30 Days money back</li>
							</ul>',
					),

					array (
						'title' => __('Related Products', 'arw-leka'),
						'subtitle' => __('<em>Enable / Disable Related Products.<em>', 'arw-leka'),
						'id' => 'related_products',
						'on' => __('Enabled', 'arw-leka'),
						'off' => __('Disabled', 'arw-leka'),
						'type' => 'switch',
						'default' => 1,
					),
					array (
						'title' => __('Upsell Products', 'arw-leka'),
						'subtitle' => __('<em>Enable / Disable Upsell Products.<em>', 'arw-leka'),
						'id' => 'upsell_products',
						'on' => __('Enabled', 'arw-leka'),
						'off' => __('Disabled', 'arw-leka'),
						'type' => 'switch',
						'default' => 1,
					),

					array (
						'title' => __('Sharing Options', 'arw-leka'),
						'subtitle' => __('<em>Enable / Disable Sharing Options.<em>', 'arw-leka'),
						'id' => 'sharing_options',
						'on' => __('Enabled', 'arw-leka'),
						'off' => __('Disabled', 'arw-leka'),
						'type' => 'switch',
						'default' => 1,
					),

					array (
						'title' => __('Review Tab', 'arw-leka'),
						'subtitle' => __('<em>Enable / Disable Review Tab.<em>', 'arw-leka'),
						'id' => 'review_tab',
						'on' => __('Enabled', 'arw-leka'),
						'off' => __('Disabled', 'arw-leka'),
						'type' => 'switch',
						'default' => 1,
					),
					array (
						'title' => __('Custom Tab', 'arw-leka'),
						'subtitle' => __('<em>Enable / Disable Custom Tab.<em>', 'arw-leka'),
						'id' => 'custom_tab',
						'on' => __('Enabled', 'arw-leka'),
						'off' => __('Disabled', 'arw-leka'),
						'type' => 'switch',
						'default' => 1,
					),
					array(
						'id'       => 'custom_tab_title',
						'type'     => 'text',
						'title'    => __('Custom Tab Title','arw-leka'),
						'default'  => 'Custom Tab',
						'required' => array('custom_tab','=','1')
					),
					array(
						'id'       => 'custom_tab_content',
						'type'     => 'editor',
						'title'    => __('Custom Tab Content','arw-leka'),
						'args'   => array(
							'teeny'            => true,
							'textarea_rows'    => 10
						),
						'default'          => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
						'required' => array('custom_tab','=','1')
					),
					array (
						'title' => __('Enable Sidebar Essential', 'arw-leka'),
						'subtitle' => __('<em>Enable / Disable Sidebar Section Essential On Product Detail.</em>', 'arw-leka'),
						'id' => 'enable_sidebar_essential',
						'on' => __('Enabled', 'arw-leka'),
						'off' => __('Disabled', 'arw-leka'),
						'type' => 'switch',
						'default' => 0,
					),

					array (
						'title' => __('Enable Sidebar Collateral', 'arw-leka'),
						'subtitle' => __('<em>Enable / Disable Sidebar Section Collateral On Product Detail.</em>', 'arw-leka'),
						'id' => 'enable_sidebar_collateral',
						'on' => __('Enabled', 'arw-leka'),
						'off' => __('Disabled', 'arw-leka'),
						'type' => 'switch',
						'default' => 1,
					),
				)
			);

			// Portfolio

			$this->sections[] = array(
				'icon'   => 'dashicons-before dashicons-portfolio',
				'title'  => __( 'Portfolios', 'arw-leka' ),
				'fields' => array(
					array (
						'title' => __('Portfolio Name', 'arw-leka'),
						'id' => 'portfolio_name',
						'type' => 'text',
						'default' => 'Portfolio'
					),
					array (
						'title' => __('Portfolio Slug', 'arw-leka'),
						'id' => 'portfolio_slug',
						'type' => 'text',
						'default' => 'portfolio',
						'validate_callback' => 'arexworks_redux_slug_field_validate_callback_function'
					),
					array (
						'title' => __('Portfolio Category Name', 'arw-leka'),
						'id' => 'portfolio_category_name',
						'type' => 'text',
						'default' => 'Portfolio Category'
					),
					array (
						'title' => __('Portfolio Category Slug', 'arw-leka'),
						'id' => 'portfolio_category_slug',
						'type' => 'text',
						'default' => 'portfolio-category',
						'validate_callback' => 'arexworks_redux_slug_field_validate_callback_function'
					),
					array (
						'title' => __('Portfolio Skill Name', 'arw-leka'),
						'id' => 'portfolio_skill_name',
						'type' => 'text',
						'default' => 'Portfolio Skill'
					),
					array (
						'title' => __('Portfolio Skill Slug', 'arw-leka'),
						'id' => 'portfolio_skill_slug',
						'type' => 'text',
						'default' => 'portfolio-skill',
						'validate_callback' => 'arexworks_redux_slug_field_validate_callback_function'
					),
				)
			);

			// Portfolio display
			$this->sections[] = array(
				'title'  => __( 'Portfolios Display', 'arw-leka' ),
				'subsection' => true,
				'fields' => array(
					$this->get_field_layouts('portfolio',__('Portfolio Layout','arw-leka'),'col-1c'),
					$this->get_field_layouts('portfolio_single',__('Single Portfolio Layout','arw-leka'),'col-1c'),
					array(
						'id'       => 'portfolio_display_type',
						'type'     => 'select',
						'title'    => __('Portfolio display type','arw-leka'),
						'options'  => array(
							'layout_1'     => __( 'Layout 1', 'arw-leka' ),
							'layout_2'        => __( 'Layout 2', 'arw-leka' ),
							'layout_3'        => __( 'Layout 3', 'arw-leka' )
						),
						'default'  => 'layout_1',
					),
					array(
						'id'       => 'portfolio_display_image_type',
						'type'     => 'select',
						'title'    => __('Portfolio display image type','arw-leka'),
						'options'  => array(
							'thumbnail'     => __( 'Thumbnail', 'arw-leka' ),
							'medium'        => __( 'Medium', 'arw-leka' ),
							'large'         => __( 'Large', 'arw-leka' ),
							'full'          => __( 'Full', 'arw-leka' ),
						),
						'default'  => 'thumbnail',
					),
					array(
						'id'       => 'portfolio_display_columns',
						'type'     => 'select',
						'title'    => __('Portfolio Columns','arw-leka'),
						'desc'     => __('if image type is full , column will be automatic set','arw-leka'),
						'options'  => array(
							'1' => __('1 Column', 'arw-leka'),
							'2' => __('2 Columns', 'arw-leka'),
							'3' => __('3 Columns', 'arw-leka'),
							'4' => __('4 Columns', 'arw-leka'),
							'5' => __('5 Columns', 'arw-leka'),
							'6' => __('6 Columns', 'arw-leka'),
						),
						'default'  => '3',
					),
					array (
						'title' => __('Enable Infinite Scroll', 'arw-leka'),
						'id' => 'portfolio_enable_infinite_scroll',
						'on' => __('Enabled', 'arw-leka'),
						'off' => __('Disabled', 'arw-leka'),
						'type' => 'switch',
						'default'  => true,
					),
					array (
						'title' => __('Enable Mode Mansory ', 'arw-leka'),
						'id' => 'portfolio_enable_mode_isotope',
						'on' => __('Enabled', 'arw-leka'),
						'off' => __('Disabled', 'arw-leka'),
						'type' => 'switch',
						'default'  => true
					),
					array (
						'title' => __('Enable portfolio skill filter ', 'arw-leka'),
						'id' => 'portfolio_enable_skill_filter',
						'on' => __('Enabled', 'arw-leka'),
						'off' => __('Disabled', 'arw-leka'),
						'type' => 'switch',
						'default'  => true,
						'required' => array('portfolio_enable_mode_isotope','=','1')
					),
				)
			);

			$this->sections[] = array(
				'icon'   => 'fa fa-paint-brush',
				'title'  => __( 'Styling', 'arw-leka' ),
				'fields' => array(
					array(
						'title' => __('Body Font Size', 'arw-leka'),
						'subtitle' => __('<em>Drag the slider to set the Body Font Size.</em>', 'arw-leka'),
						'id' => 'body_font_size',
						'type' => 'slider',
						"default" => 13,
						"min" => 11,
						"step" => 1,
						"max" => 20,
						'display_value' => 'text'
					),

					array (
						'title' => __('Body Text Color', 'arw-leka'),
						'subtitle' => __('<em>Body Text Color of the site.</em>', 'arw-leka'),
						'id' => 'body_color',
						'type' => 'color',
						'transparent' => false,
						'default' => '#747474',
					),

					array (
						'title' => __('Heading Color', 'arw-leka'),
						'subtitle' => __('<em>Heading Color of the site.</em>', 'arw-leka'),
						'id' => 'heading_color',
						'type' => 'color',
						'transparent' => false,
						'default' => '#303030',
					),

					array (
						'title' => __('Main Theme Color', 'arw-leka'),
						'subtitle' => __('<em>The main color of the site.</em>', 'arw-leka'),
						'id' => 'main_color',
						'type' => 'color',
						'transparent' => false,
						'default' => '#7e883a',
					),
					array (
						'title' => __('Secondary Theme Color', 'arw-leka'),
						'subtitle' => __('<em>The secondary color of the site.</em>', 'arw-leka'),
						'id' => 'second_color',
						'type' => 'color',
						'transparent' => false,
						'default' => '#303030',
					),

					array (
						'title' => __('Border Theme Color', 'arw-leka'),
						'id' => 'border_color',
						'type' => 'color',
						'transparent' => false,
						'default' => '#e9e9e9',
					),

					array(
						'id'       		=> 'main_background',
						'type'     		=> 'background',
						'title'    		=> "Body Background",
						'subtitle' 		=> "<em>Body background with image, color, etc.</em>",
						'default'  => array(
							'background-color' => '#fff',
						),
						'transparent' 	=> true,
					),
					array(
						'id'       		=> 'main_boxed_background',
						'type'     		=> 'background',
						'title'    		=> "Page Background (Boxed style)",
						'subtitle' 		=> "<em>Main boxed background with image, color, etc.</em>",
						'default'  => array(
							'background-color' => '#fff',
						),
						'transparent' 	=> true,
					),
				)
			);

			$this->sections[] = array(
				'icon'   => 'fa fa-font',
				'title'  => __( 'Typography', 'arw-leka' ),
				'fields' => array(

					array (
						'id' => 'source_fonts_info',
						'icon' => true,
						'type' => 'info',
						'raw' => __('<h3 style="margin: 0;"><i class="fa fa-font"></i> Font Sources</h3>', 'arw-leka'),
					),

					array(
						'title'    => __('Font Source', 'arw-leka'),
						'subtitle' => __('<em>Choose the Font Source</em>', 'arw-leka'),
						'id'       => 'font_source',
						'type'     => 'radio',
						'options'  => array(
							'1' => 'Standard + Google Webfonts',
							'2' => 'Google Custom',
							'3' => 'Adobe Typekit'
						),
						'default' => '1'
					),

					// Google Code
					array(
						'id'=>'font_google_code',
						'type' => 'text',
						'title' => __('Google Code', 'arw-leka'),
						'subtitle' => __('<em>Paste the provided Google Code</em>', 'arw-leka'),
						'default' => '',
						'required' => array('font_source','=','2')
					),

					// Typekit ID
					array(
						'id'=>'font_typekit_kit_id',
						'type' => 'text',
						'title' => __('Typekit Kit ID', 'arw-leka'),
						'subtitle' => __('<em>Paste the provided Typekit Kit ID.</em>', 'arw-leka'),
						'default' => '',
						'required' => array('font_source','=','3')
					),

					array (
						'id' => 'main_font_info',
						'icon' => true,
						'type' => 'info',
						'raw' => __('<h3 style="margin: 0;"><i class="fa fa-font"></i> Main Font</h3>', 'arw-leka'),
					),

					// Standard + Google Webfonts
					array (
						'title' => __('Font Face', 'arw-leka'),
						'subtitle' => __('<em>Pick the Main Font for your site.</em>', 'arw-leka'),
						'id' => 'main_font',
						'type' => 'typography',
						'line-height' => false,
						'text-align' => false,
						'font-style' => false,
						'font-weight' => false,
						'all_styles'=> true,
						'font-size' => false,
						'color' => false,
						'default' => array (
							'font-family' => 'Lato',
							'subsets' => '',
						),
						'required' => array('font_source','=','1')
					),

					// Google Custom
					array (
						'title' => __('Google Font Face', 'arw-leka'),
						'subtitle' => __('<em>Enter your Google Font Name for the theme\'s Main Typography</em>', 'arw-leka'),
						'desc' => __('e.g.: open sans', 'arw-leka'),
						'id' => 'main_google_font_face',
						'type' => 'text',
						'default' => '',
						'required' => array('font_source','=','2')
					),

					// Adobe Typekit
					array (
						'title' => __('Typekit Font Face', 'arw-leka'),
						'subtitle' => __('<em>Enter your Typekit Font Name for the theme\'s Main Typography</em>', 'arw-leka'),
						'desc' => __('e.g.: futura-pt', 'arw-leka'),
						'id' => 'main_typekit_font_face',
						'type' => 'text',
						'default' => '',
						'required' => array('font_source','=','3')
					),

					array (
						'id' => 'secondary_font_info',
						'icon' => true,
						'type' => 'info',
						'raw' => __('<h3 style="margin: 0;"><i class="fa fa-font"></i> Secondary Font</h3>', 'arw-leka'),
					),

					// Standard + Google Webfonts
					array (
						'title' => __('Font Face', 'arw-leka'),
						'subtitle' => __('<em>Pick the Secondary Font for your site.</em>', 'arw-leka'),
						'id' => 'secondary_font',
						'type' => 'typography',
						'line-height' => false,
						'text-align' => false,
						'font-style' => false,
						'font-weight' => false,
						'all_styles'=> true,
						'font-size' => false,
						'color' => false,
						'default' => array (
							'font-family' => "Lato",
							'subsets' => '',
						),
						'required' => array('font_source','=','1')
					),

					// Google Custom
					array (
						'title' => __('Google Font Face', 'arw-leka'),
						'subtitle' => __('<em>Enter your Google Font Name for the theme\'s Secondary Typography</em>', 'arw-leka'),
						'desc' => __('e.g.: open sans', 'arw-leka'),
						'id' => 'secondary_google_font_face',
						'type' => 'text',
						'default' => '',
						'required' => array('font_source','=','2')
					),

					// Adobe Typekit
					array (
						'title' => __('Typekit Font Face', 'arw-leka'),
						'subtitle' => __('<em>Enter your Typekit Font Name for the theme\'s Secondary Typography</em>', 'arw-leka'),
						'desc' => __('e.g.: futura-pt', 'arw-leka'),
						'id' => 'secondary_typekit_font_face',
						'type' => 'text',
						'default' => '',
						'required' => array('font_source','=','3')
					),


					array (
						'id' => 'highlight_font_info',
						'icon' => true,
						'type' => 'info',
						'raw' => __('<h3 style="margin: 0;"><i class="fa fa-font"></i> Highlight Font</h3>', 'arw-leka'),
					),

					// Standard + Google Webfonts
					array (
						'title' => __('Font Face', 'arw-leka'),
						'subtitle' => __('<em>Pick the Highlight Font for your site.</em>', 'arw-leka'),
						'id' => 'highlight_font',
						'type' => 'typography',
						'line-height' => false,
						'text-align' => false,
						'font-style' => false,
						'font-weight' => false,
						'all_styles'=> true,
						'font-size' => false,
						'color' => false,
						'default' => array (
							'font-family' => "Crimson Text",
							'subsets' => '',
						),
						'required' => array('font_source','=','1')
					),

					// Google Custom
					array (
						'title' => __('Google Font Face', 'arw-leka'),
						'subtitle' => __('<em>Enter your Google Font Name for the theme\'s Highlight Typography</em>', 'arw-leka'),
						'desc' => __('e.g.: open sans', 'arw-leka'),
						'id' => 'highlight_google_font_face',
						'type' => 'text',
						'default' => '',
						'required' => array('font_source','=','2')
					),

					// Adobe Typekit
					array (
						'title' => __('Typekit Font Face', 'arw-leka'),
						'subtitle' => __('<em>Enter your Typekit Font Name for the theme\'s Highlight Typography</em>', 'arw-leka'),
						'desc' => __('e.g.: futura-pt', 'arw-leka'),
						'id' => 'highlight_typekit_font_face',
						'type' => 'text',
						'default' => '',
						'required' => array('font_source','=','3')
					),
				)
			);
			// Social
			$this->sections[] = array(
				'icon'      => ' fa fa-share-alt-square',
				'title'     => __('Social Share', 'arw-leka'),
				'fields'    => array(
					array(
						'id'        => 'social-share-facebook',
						'type'      => 'switch',
						'title'     => __('Facebook', 'arw-leka'),
						'default'   => 1,
						'on'        => 'Enabled',
						'off'       => 'Disabled',
					),
					array(
						'id'        => 'social-share-twitter',
						'type'      => 'switch',
						'title'     => __('Twitter', 'arw-leka'),
						'default'   => 1,
						'on'        => 'Enabled',
						'off'       => 'Disabled',
					),
					array(
						'id'        => 'social-share-linkedin',
						'type'      => 'switch',
						'title'     => __('LinkedIn', 'arw-leka'),
						'default'   => 1,
						'on'        => 'Enabled',
						'off'       => 'Disabled',
					),
					array(
						'id'        => 'social-share-email',
						'type'      => 'switch',
						'title'     => __('Email', 'arw-leka'),
						'default'   => 1,
						'on'        => 'Enabled',
						'off'       => 'Disabled',
					),
					array(
						'id'        => 'social-share-pinterest',
						'type'      => 'switch',
						'title'     => __('Pinterest', 'arw-leka'),
						'default'   => 1,
						'on'        => 'Enabled',
						'off'       => 'Disabled',
					),
					array(
						'id'        => 'social-share-google-plus',
						'type'      => 'switch',
						'title'     => __('Google Plus', 'arw-leka'),
						'default'   => 1,
						'on'        => 'Enabled',
						'off'       => 'Disabled',
					),

				),
			);
			//End
			$this->sections[] = array(
				'icon'   => 'el-icon-network',
				'title'  => __( 'Social Media', 'arw-leka' ),
				'fields' => array(

					array (
						'title' => __('<i class="fa fa-facebook"></i> Facebook', 'arw-leka'),
						'subtitle' => __('<em>Type your Facebook profile URL here.</em>', 'arw-leka'),
						'id' => 'facebook_link',
						'type' => 'text',
						'default' => '#',
					),

					array (
						'title' => __('<i class="fa fa-twitter"></i> Twitter', 'arw-leka'),
						'subtitle' => __('<em>Type your Twitter profile URL here.</em>', 'arw-leka'),
						'id' => 'twitter_link',
						'type' => 'text',
						'default' => '#',
					),

					array (
						'title' => __('<i class="fa fa-pinterest"></i> Pinterest', 'arw-leka'),
						'subtitle' => __('<em>Type your Pinterest profile URL here.</em>', 'arw-leka'),
						'id' => 'pinterest_link',
						'type' => 'text',
						'default' => '#',
					),

					array (
						'title' => __('<i class="fa fa-linkedin"></i> LinkedIn', 'arw-leka'),
						'subtitle' => __('<em>Type your LinkedIn profile URL here.</em>', 'arw-leka'),
						'id' => 'linkedin_link',
						'type' => 'text',
					),

					array (
						'title' => __('<i class="fa fa-google-plus"></i> Google+', 'arw-leka'),
						'subtitle' => __('<em>Type your Google+ profile URL here.</em>', 'arw-leka'),
						'id' => 'googleplus_link',
						'type' => 'text',
					),

					array (
						'title' => __('<i class="fa fa-rss"></i> RSS', 'arw-leka'),
						'subtitle' => __('<em>Type your RSS Feed URL here.</em>', 'arw-leka'),
						'id' => 'rss_link',
						'type' => 'text',
					),

					array (
						'title' => __('<i class="fa fa-tumblr"></i> Tumblr', 'arw-leka'),
						'subtitle' => __('<em>Type your Tumblr URL here.</em>', 'arw-leka'),
						'id' => 'tumblr_link',
						'type' => 'text',
					),

					array (
						'title' => __('<i class="fa fa-instagram"></i> Instagram', 'arw-leka'),
						'subtitle' => __('<em>Type your Instagram profile URL here.</em>', 'arw-leka'),
						'id' => 'instagram_link',
						'type' => 'text',
						'default' => '#',
					),

					array (
						'title' => __('<i class="fa fa-youtube-play"></i> Youtube', 'arw-leka'),
						'subtitle' => __('<em>Type your Youtube profile URL here.</em>', 'arw-leka'),
						'id' => 'youtube_link',
						'type' => 'text',
						'default' => '#',
					),

					array (
						'title' => __('<i class="fa fa-vimeo-square"></i> Vimeo', 'arw-leka'),
						'subtitle' => __('<em>Type your Vimeo profile URL here.</em>', 'arw-leka'),
						'id' => 'vimeo_link',
						'type' => 'text',
					),

					array (
						'title' => __('<i class="fa fa-behance"></i> Behance', 'arw-leka'),
						'subtitle' => __('<em>Type your Behance profile URL here.</em>', 'arw-leka'),
						'id' => 'behance_link',
						'type' => 'text',
					),

					array (
						'title' => __('<i class="fa fa-dribbble"></i> Dribble', 'arw-leka'),
						'subtitle' => __('<em>Type your Dribble profile URL here.</em>', 'arw-leka'),
						'id' => 'dribble_link',
						'type' => 'text',
					),

					array (
						'title' => __('<i class="fa fa-flickr"></i> Flickr', 'arw-leka'),
						'subtitle' => __('<em>Type your Flickr profile URL here.</em>', 'arw-leka'),
						'id' => 'flickr_link',
						'type' => 'text',
					),

					array (
						'title' => __('<i class="fa fa-git"></i> Git', 'arw-leka'),
						'subtitle' => __('<em>Type your Git profile URL here.</em>', 'arw-leka'),
						'id' => 'git_link',
						'type' => 'text',
					),

					array (
						'title' => __('<i class="fa fa-skype"></i> Skype', 'arw-leka'),
						'subtitle' => __('<em>Type your Skype profile URL here.</em>', 'arw-leka'),
						'id' => 'skype_link',
						'type' => 'text',
					),

					array (
						'title' => __('<i class="fa fa-weibo"></i> Weibo', 'arw-leka'),
						'subtitle' => __('<em>Type your Weibo profile URL here.</em>', 'arw-leka'),
						'id' => 'weibo_link',
						'type' => 'text',
					),

					array (
						'title' => __('<i class="fa fa-foursquare"></i> Foursquare', 'arw-leka'),
						'subtitle' => __('<em>Type your Foursquare profile URL here.</em>', 'arw-leka'),
						'id' => 'foursquare_link',
						'type' => 'text',
					),

					array (
						'title' => __('<i class="fa fa-soundcloud"></i> Soundcloud', 'arw-leka'),
						'subtitle' => __('<em>Type your Soundcloud profile URL here.</em>', 'arw-leka'),
						'id' => 'soundcloud_link',
						'type' => 'text',
					),

				)
			);

			$this->sections[] = array(
				'icon'   => 'fa fa-code',
				'title'  => __( 'Custom Code', 'arw-leka' ),
				'fields' => array(

					array (
						'title' => __('Custom CSS', 'arw-leka'),
						'subtitle' => __('<em>Paste your custom CSS code here.</em>', 'arw-leka'),
						'id' => 'custom_css',
						'type' => 'ace_editor',
						'mode' => 'css',
					),

					array (
						'title' => __('Header JavaScript Code', 'arw-leka'),
						'subtitle' => __('<em>Paste your custom JS code here. The code will be added to the header of your site.</em>', 'arw-leka'),
						'id' => 'header_js',
						'type' => 'ace_editor',
						'mode' => 'javascript',
					),

					array (
						'title' => __('Footer JavaScript Code', 'arw-leka'),
						'subtitle' => __('<em>Here is the place to paste your Google Analytics code or any other JS code you might want to add to be loaded in the footer of your website.</em>', 'arw-leka'),
						'id' => 'footer_js',
						'type' => 'ace_editor',
						'mode' => 'javascript',
					),

				)
			);

			$this->sections[] = array(
				'title'  => __( 'Import / Export', 'arw-leka' ),
				'desc'   => __( 'Import and Export your Redux Framework settings from file, text or URL.', 'arw-leka' ),
				'icon'   => 'fa fa-refresh',
				'fields' => array(
					array(
						'id'         => 'opt-import-export',
						'type'       => 'import_export',
						'title'      => 'Import Export',
						'subtitle'   => 'Save and restore your Redux options',
						'full_width' => false,
					)
				),
			);

			$this->sections[] = array(
				'id' => 'wbc_importer_section',
				'title'  => esc_html__( 'Demo Importer', 'arw-leka'),
				'desc'   => esc_html__( 'Description Goes Here', 'arw-leka' ),
				'icon'   => 'el-icon-website',
				'fields' => array(
					array(
						'id'   => 'wbc_demo_importer',
						'type' => 'wbc_importer'
					)
				)
			);

			$file_document_html = trailingslashit(arexworks_include_dir) . 'changelog.md';
			if (file_exists($file_document_html)) {
				global $wp_filesystem;
				if (empty($wp_filesystem)) {
					require_once(ABSPATH . '/wp-admin/includes/file.php');
					WP_Filesystem();
				}
				$documentHTML = $wp_filesystem->get_contents($file_document_html);
				$this->sections[] = array(
						'id' => 'section_documentation',
						'title'  => esc_html__( 'Theme Changelog', 'arw-leka'),
						'icon'   => 'el el-list-alt',
						'fields' => array(
							array(
								'id'        => 'section_documentation_row',
								'type'      => 'raw',
								'markdown'  => true,
								'content'   => $documentHTML
							),
						)
				);
			}
		}

		public function setArguments() {

			$theme = wp_get_theme(); // For use with some settings. Not necessary.

			$this->args = array(
				// TYPICAL -> Change these values as you need/desire
				'opt_name'             => 'arexworks_theme_options',
				// This is where your data is stored in the database and also becomes your global variable name.
				'display_name'         => $theme->get( 'Name' ),
				// Name that appears at the top of your panel
				'display_version'      => $theme->get( 'Version' ),
				// Version that appears at the top of your panel
				'menu_type'            => 'menu',
				//Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
				'allow_sub_menu'       => true,
				// Show the sections below the admin menu item or not
				'menu_title'           => __( 'Theme Options', 'arw-leka' ),
				'page_title'           => __( 'Theme Options', 'arw-leka' ),
				// You will need to generate a Google API key to use this feature.
				// Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
				'google_api_key'       => 'AIzaSyBFsuyEGSV3caEJFrKaShHtDjWNrO6ako4',
				// Set it you want google fonts to update weekly. A google_api_key value is required.
				'google_update_weekly' => false,
				// Must be defined to add google fonts to the typography module
				'async_typography'     => true,
				// Use a asynchronous font on the front end or font string
				//'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
				'admin_bar'            => true,
				// Show the panel pages on the admin bar
				'admin_bar_icon'     => 'dashicons-portfolio',
				// Choose an icon for the admin bar menu
				'admin_bar_priority' => 50,
				// Choose an priority for the admin bar menu
				'global_variable'      => '',
				'show_options_object'  => false,
				// Set a different name for your global variable other than the opt_name
				'dev_mode'             => false,
				'forced_dev_mode_off'  => false,
				// Show the time the page took to load, etc
				'allow_tracking'        => false,
				'use_cdn'               => false,
				'update_notice'        => true,
				// If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
				'customizer'           => false,
				// Enable basic customizer support
				//'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
				//'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

				// OPTIONAL -> Give you extra features
				'page_priority'        => 61,
				// Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
				'page_parent'          => 'themes.php',
				// For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
				'page_permissions'     => 'manage_options',
				// Permissions needed to access the options panel.
				'menu_icon'            => esc_url( arexworks_image . '/theme_options/menu-icon.png'),
				// Specify a custom URL to an icon
				'last_tab'             => '',
				// Force your panel to always open to a specific tab (by id)
				'page_icon'            => 'icon-themes',
				// Icon displayed in the admin panel next to your menu_title
				'page_slug'            => 'theme_options',
				// Page slug used to denote the panel
				'save_defaults'        => true,
				// On load save the defaults to DB before user clicks save or not
				'default_show'         => false,
				// If true, shows the default value next to each field that is not the default value.
				'default_mark'         => '',
				// What to print by the field's title if the value shown is default. Suggested: *
				'show_import_export'   => true,
				// Shows the Import/Export panel when not used as a field.

				// CAREFUL -> These options are for advanced use only
				'transient_time'       => 60 * MINUTE_IN_SECONDS,
				'output'               => true,
				// Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
				'output_tag'           => true,
				// Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
				'footer_credit'     => '&nbsp;',                   // Disable the footer credit of Redux. Please leave if you can help it.

				// FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
				'database'             => '',
				// possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
				'system_info'          => false,
				// REMOVE

				// HINTS
				'hints'                => array(
					'icon'          => 'icon-question-sign',
					'icon_position' => 'right',
					'icon_color'    => 'lightgray',
					'icon_size'     => 'normal',
					'tip_style'     => array(
						'color'   => 'light',
						'shadow'  => true,
						'rounded' => false,
						'style'   => '',
					),
					'tip_position'  => array(
						'my' => 'top left',
						'at' => 'bottom right',
					),
					'tip_effect'    => array(
						'show' => array(
							'effect'   => 'slide',
							'duration' => '500',
							'event'    => 'mouseover',
						),
						'hide' => array(
							'effect'   => 'slide',
							'duration' => '500',
							'event'    => 'click mouseleave',
						),
					),
				)
			);

			// ADMIN BAR LINKS -> Setup custom links in the admin bar menu as external items.
			$this->args['admin_bar_links'][] = array(
				'id'    => 'arexworks-docs',
				'href'   => '//docs.arw.tf/display/ARWWPLEKA/ARW+WP+LEKA',
				'title' => __( 'Documentation', 'arw-leka' ),
			);

			$this->args['admin_bar_links'][] = array(
				'id'    => 'arexworks-support',
				'href'   => '//arex.ticksy.com',
				'title' => __( 'Support', 'arw-leka' ),
			);

			// SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
			$this->args['share_icons'][] = array(
				'url'   => '//www.facebook.com/arexworks/?fref=ts',
				'title' => 'Like us on Facebook',
				'icon'  => 'el-icon-facebook'
			);

			// Panel Intro text -> before the form
			if ( ! isset( $this->args['global_variable'] ) || $this->args['global_variable'] !== false ) {
				if ( ! empty( $this->args['global_variable'] ) ) {
					$v = $this->args['global_variable'];
				} else {
					$v = str_replace( '-', '_', $this->args['opt_name'] );
				}
				$this->args['intro_text'] = "";
			} else {
				$this->args['intro_text'] = "";
			}

			// Add content after the form.
			$this->args['footer_text'] = "";
		}

	}

	global $reduxConfig;

	$reduxConfig = new Arexworks_Theme_Options();

}