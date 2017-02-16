<?php
if( class_exists( 'Arexworks_Widget_Base' ) ) {
	if ( !class_exists( 'Arexworks_Widget_Social' ) ) {
		class Arexworks_Widget_Social extends  Arexworks_Widget_Base {
			public function __construct() {
				$this->widget_cssclass    = 'arexworks_widget_social';
				$this->widget_description = __( 'Show socials media', 'arw-leka' );
				$this->widget_id          = 'arexworks_widget_social';
				$this->widget_name        = __( 'Social Media', 'arw-leka' );
				$this->settings           = array(
					'title'  => array(
						'type'  => 'text',
						'label' => __( 'Title', 'arw-leka' ),
						'std'   => ''
					)
				);
				parent::__construct();
			}
			public function widget( $args, $instance ){
				if ( $this->get_cached_widget( $args ) ) {
					return;
				}
				ob_start();
				$this->widget_start( $args, $instance );
					echo do_shortcode('[arexworks_social]');
				$this->widget_end( $args );
				$content = ob_get_clean();
				echo $content;
				$this->cache_widget( $args, $content );
			}
		}
	}
}