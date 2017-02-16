<?php
	if( !class_exists( 'Arexworks_Widget_Css_Class' ) ) {
		class Arexworks_Widget_Css_Class{

			public static function extend_widget_form($widget, $return, $instance){
				if (!isset($instance['classes'])) $instance['classes'] = null;
				$fields = '';
				$fields .= '<p>';
				$fields .= '<label for="' . esc_attr( 'widget-' . $widget->id_base . '-' . $widget->number . '-classes' ) . '">';
				$fields .= apply_filters('arexworks_filter_widget_css_class_class', esc_html__('CSS Class', 'arw-leka'));
				$fields .= ' : ';
				$fields .= '</label>';
				$fields .= '<input type="text" name="' . esc_attr( 'widget-' . $widget->id_base . '[' . $widget->number . '][classes]' ) .'"';
				$fields .= ' id="' . esc_attr( 'widget-' . $widget->id_base . '-' . $widget->number . '-classes' ) . '"';
				$fields .= ' value="' . esc_attr( $instance['classes'] ) . '" class="widefat" />';
				$fields .= '</p>';
				do_action('arexworks_action_widget_css_class_form', $fields, $instance);
				echo $fields;
				return $instance;
			}

			public static function update_widget($instance, $new_instance){
				if ( isset( $new_instance['classes'] ) ){
					$instance['classes'] = $new_instance['classes'];
				}
				if ( isset( $new_instance['ids'] ) ){
					$instance['ids'] = $new_instance['ids'];
				}

				do_action('arexworks_action_widget_css_class_update', $instance, $new_instance);
				return $instance;
			}

			public static function add_widget_classes($params){

				global $wp_registered_widgets, $widget_number;

				$arr_registered_widgets = wp_get_sidebars_widgets(); // Get an array of ALL registered widgets
				$this_id = $params[0]['id']; // Get the id for the current sidebar we're processing
				$widget_id = $params[0]['widget_id'];
				$widget_obj = $wp_registered_widgets[$widget_id];
				$widget_num = $widget_obj['params'][0]['number'];
				$widget_opt = null;

				// if Widget Logic plugin is enabled, use it's callback
				if (in_array('widget-logic/widget_logic.php', apply_filters('active_plugins', get_option('active_plugins')))) {
					$widget_logic_options = get_option('widget_logic');
					if (isset($widget_logic_options['widget_logic-options-filter']) && 'checked' == $widget_logic_options['widget_logic-options-filter']) {
						$widget_opt = get_option($widget_obj['callback_wl_redirect'][0]->option_name);
					} else {
						$widget_opt = get_option($widget_obj['callback'][0]->option_name);
					}

					// if Widget Context plugin is enabled, use it's callback
				} elseif (in_array('widget-context/widget-context.php', apply_filters('active_plugins', get_option('active_plugins')))) {
					$callback = isset($widget_obj['callback_original_wc']) ? $widget_obj['callback_original_wc'] : null;
					$callback = !$callback && isset($widget_obj['callback']) ? $widget_obj['callback'] : null;

					if ($callback && is_array($widget_obj['callback'])) {
						$widget_opt = get_option($callback[0]->option_name);
					}
				} // Default callback
				else {
					// Check if WP Page Widget is in use
					global $post;
					$id = (isset($post->ID) ? get_the_ID() : NULL);
					if (isset($id) && get_post_meta($id, '_customize_sidebars')) {
						$custom_sidebarcheck = get_post_meta($id, '_customize_sidebars');
					}
					if (isset($custom_sidebarcheck[0]) && ($custom_sidebarcheck[0] == 'yes')) {
						$widget_opt = get_option('widget_' . $id . '_' . substr($widget_obj['callback'][0]->option_name, 7));
					} elseif (isset($widget_obj['callback'][0]->option_name)) {
						$widget_opt = get_option($widget_obj['callback'][0]->option_name);
					}
				}

				if (isset($widget_opt[$widget_num]['classes']) && !empty($widget_opt[$widget_num]['classes']))
					$params[0]['before_widget'] = preg_replace('/class="/', "class=\"{$widget_opt[$widget_num]['classes']} ", $params[0]['before_widget'], 1);

				do_action('arexworks_action_widget_css_class_add_classes', $params, $widget_id, $widget_number, $widget_opt, $widget_obj);

				return $params;
			}
		}
	}

	if( !function_exists( 'arexworks_add_action_widget_css_class_frontend_hook' ) ){
		add_action( 'wp_loaded', 'arexworks_add_action_widget_css_class_frontend_hook' );
		function arexworks_add_action_widget_css_class_frontend_hook() {
			if ( !is_admin() ) {
				add_filter( 'dynamic_sidebar_params', array( 'Arexworks_Widget_Css_Class', 'add_widget_classes' ) );
			}
		}
	}

	if( !function_exists( 'arexworks_add_action_widget_css_class_loader' ) ){
		add_action( 'init', 'arexworks_add_action_widget_css_class_loader' );
		function arexworks_add_action_widget_css_class_loader(){
			if ( is_admin() ) {
				add_action( 'in_widget_form', array( 'Arexworks_Widget_Css_Class', 'extend_widget_form' ), 10, 3 );
				add_filter( 'widget_update_callback', array( 'Arexworks_Widget_Css_Class', 'update_widget' ), 10, 2 );
			}
		}
	}