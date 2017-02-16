<?php
add_action( 'tgmpa_register', 'arexworks_theme_register_required_plugins' );
function arexworks_theme_register_required_plugins() {

	$plugins = array(

			array(
					'name'     				=> 'Envato Toolkit',
					'slug'     				=> 'envato-wordpress-toolkit',
					'source'   				=> arexworks_lib_plugin_dir . '/envato-wordpress-toolkit.zip',
					'required' 				=> false,
					'version' 				=> '1.7.3',
					'force_activation' 		=> false,
					'force_deactivation' 	=> false,
					'external_url' 			=> '',
			),

			array(
					'name'					=> 'Ultimate Addons for Visual Composer',
					'slug'					=> 'Ultimate_VC_Addons',
					'source'				=> arexworks_lib_plugin_dir . '/Ultimate_VC_Addons.zip',
					'required'				=> true,
					'version'				=> '3.16.5',
					'force_activation'		=> false,
					'force_deactivation'	=> false,
					'external_url'			=> '',
			),

			array(
					'name'					=> 'Visual Composer',
					'slug'					=> 'js_composer',
					'source'				=> arexworks_lib_plugin_dir . '/js_composer.zip',
					'required'				=> true,
					'version'				=> '4.12',
					'force_activation'		=> false,
					'force_deactivation'	=> false,
					'external_url'			=> '',
			),

			array(
					'name'					=> 'Slider Revolution',
					'slug'					=> 'revslider',
					'source'				=> arexworks_lib_plugin_dir . '/revslider.zip',
					'required'				=> true,
					'version'				=> '5.2.5.4',
					'force_activation'		=> false,
					'force_deactivation'	=> false,
					'external_url'			=> '',
			),

			array(
					'name'					=> 'Arexworks content types',
					'slug'					=> 'arexworks-content-types',
					'source'				=> arexworks_lib_plugin_dir . '/arexworks-content-types.zip',
					'required'				=> true,
					'version'				=> '1.0',
					'force_activation'		=> false,
					'force_deactivation'	=> false,
					'external_url'			=> '',
			),

			array(
					'name'					=> 'Arexworks Shortcodes',
					'slug'					=> 'arexworks-shortcodes',
					'source'				=> arexworks_lib_plugin_dir . '/arexworks-shortcodes.zip',
					'required'				=> true,
					'version'				=> '1.0.1',
					'force_activation'		=> false,
					'force_deactivation'	=> false,
					'external_url'			=> '',
			),

		//from WP repository

			array(
					'name'     				=> 'WooCommerce',
					'slug'     				=> 'woocommerce',
					'source'   				=> 'http://downloads.wordpress.org/plugin/woocommerce.2.6.1.zip',
					'required' 				=> false,
					'version' 				=> '2.6.1',
					'force_activation' 		=> false,
					'force_deactivation' 	=> false,
					'external_url' 			=> '',
			),

			array(
					'name'     				=> 'WooSidebars',
					'slug'     				=> 'woosidebars',
					'source'   				=> 'https://downloads.wordpress.org/plugin/woosidebars.1.4.3.zip',
					'required' 				=> false,
					'version' 				=> '1.4.3',
					'force_activation' 		=> false,
					'force_deactivation' 	=> false,
					'external_url' 			=> '',
			),

			array(
					'name'     				=> 'YITH WooCommerce Wishlist',
					'slug'     				=> 'yith-woocommerce-wishlist',
					'source'   				=> 'https://downloads.wordpress.org/plugin/yith-woocommerce-wishlist.2.0.16.zip',
					'required' 				=> false,
					'version' 				=> '2.0.16',
					'force_activation' 		=> false,
					'force_deactivation' 	=> false,
					'external_url' 			=> '',
			),

			array(
					'name'     				=> 'YITH WooCommerce Compare',
					'slug'     				=> 'yith-woocommerce-compare',
					'source'   				=> 'http://downloads.wordpress.org/plugin/yith-woocommerce-compare.2.0.9.zip',
					'required' 				=> false,
					'version' 				=> '2.0.9',
					'force_activation' 		=> false,
					'force_deactivation' 	=> false,
					'external_url' 			=> '',
			),

			array(
					'name'     				=> 'Newsletter Sign-Up',
					'slug'     				=> 'newsletter-sign-up',
					'source'   				=> 'http://downloads.wordpress.org/plugin/newsletter-sign-up.2.0.5.zip',
					'required' 				=> false,
					'version' 				=> '2.0.6',
					'force_activation' 		=> false,
					'force_deactivation' 	=> false,
					'external_url' 			=> '',
			),
			array(
					'name'     				=> 'Regenerate Thumbnails',
					'slug'     				=> 'regenerate-thumbnails',
					'source'   				=> 'https://downloads.wordpress.org/plugin/regenerate-thumbnails.2.2.6.zip',
					'required' 				=> false,
					'version' 				=> '2.2.6',
					'force_activation' 		=> false,
					'force_deactivation' 	=> false,
					'external_url' 			=> '',
			),
			array(
					'name' 		=> 'Contact Form 7',
					'slug' 		=> 'contact-form-7',
					'required' 	=> false,
					'version' 	=> '4.4.2',
			),

	);

	$config = array(
			'default_path' => '',                      // Default absolute path to pre-packaged plugins.
			'menu'         => 'tgmpa-install-plugins', // Menu slug.
			'has_notices'  => true,                    // Show admin notices or not.
			'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
			'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
			'is_automatic' => false,                   // Automatically activate plugins after installation or not.
			'message'      => '',                      // Message to output right before the plugins table.
			'strings'      => array(
					'page_title'                      => __( 'Install Required Plugins', 'arw-leka' ),
					'menu_title'                      => __( 'Install Plugins', 'arw-leka' ),
					'installing'                      => __( 'Installing Plugin: %s', 'arw-leka' ), // %s = plugin name.
					'oops'                            => __( 'Something went wrong with the plugin API.', 'arw-leka' ),
					'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.','arw-leka' ), // %1$s = plugin name(s).
					'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.','arw-leka' ), // %1$s = plugin name(s).
					'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.','arw-leka' ), // %1$s = plugin name(s).
					'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.','arw-leka' ), // %1$s = plugin name(s).
					'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.','arw-leka' ), // %1$s = plugin name(s).
					'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.','arw-leka' ), // %1$s = plugin name(s).
					'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ,'arw-leka'), // %1$s = plugin name(s).
					'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.','arw-leka' ), // %1$s = plugin name(s).
					'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins','arw-leka' ),
					'activate_link'                   => _n_noop( 'Begin activating plugin', 'Begin activating plugins','arw-leka' ),
					'return'                          => __( 'Return to Required Plugins Installer', 'arw-leka' ),
					'plugin_activated'                => __( 'Plugin activated successfully.', 'arw-leka' ),
					'complete'                        => __( 'All plugins installed and activated successfully. %s', 'arw-leka' ), // %s = dashboard link.
					'nag_type'                        => 'updated' // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
			)
	);

	tgmpa( $plugins, $config );

}