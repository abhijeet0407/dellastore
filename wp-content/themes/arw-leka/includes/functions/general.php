<?php
if ( !function_exists( 'arexworks_var_dump' ) ){
	function arexworks_var_dump($data){
		ob_start();
		echo '<pre>';
		var_dump($data);
		echo '</pre>';
		return ob_get_clean();
	}
}

if ( !function_exists( 'arexworks_print_r' ) ){
	function arexworks_print_r($data){
		ob_start();
		echo '<pre>';
		print_r($data);
		echo '</pre>';
		return ob_get_clean();
	}
}

if ( !function_exists( 'get' ) ){
	function get($var){
		return isset($_GET[$var]) ? $_GET[$var] : (isset($_REQUEST[$var]) ? $_REQUEST[$var] : '');
	}
}

if ( !function_exists( 'post' ) ){
	function post($var){
		return isset($_POST[$var]) ? $_POST[$var] : null;
	}
}

if ( !function_exists( 'cookie' ) ){
	function cookie($var){
		return isset($_COOKIE[$var]) ? $_COOKIE[$var] : null;
	}
}

if ( !function_exists( 'is_active_woocommerce' ) ){
	function is_active_woocommerce(){
		if(function_exists('WC')){
			return true;
		}else{
			return false;
		}
	}
}

if ( !function_exists( 'arexworks_get_option_data' ) ){
	function arexworks_get_option_data($id, $fallback = false, $param = false){
		global $arexworks_theme_options;
		$arexworks_theme_options = apply_filters('arexworks_filter_option_data',$arexworks_theme_options);
		if ( $fallback == false ){
			$fallback = '';
		}
		if(isset($arexworks_theme_options[$id]) && $arexworks_theme_options[$id] !== ''){
			$output = $arexworks_theme_options[$id];
		}
		else{
			$output = $fallback;
		}
		if ( !empty( $arexworks_theme_options[$id] ) && $param ) {
			if(isset($arexworks_theme_options[$id][$param])){
				$output = $arexworks_theme_options[$id][$param];
			}
			else{
				$output = $fallback;
			}
		}
		return $output;
	}
}

if ( !function_exists( 'arexworks_get_post_meta' ) ){
	function arexworks_get_post_meta( $id, $key = "", $single = true ) {
		$GLOBALS['arexworks_post_meta'] = isset( $GLOBALS['arexworks_post_meta'] ) ? $GLOBALS['arexworks_post_meta'] : array();
		if ( !isset( $id ) ) {
			return false;
		}
		if ( !is_array( $id ) ) {
			if ( ! isset( $GLOBALS['arexworks_post_meta'][ $id ] ) ) {
				$GLOBALS['arexworks_post_meta'][ $id ] = get_post_meta( $id );
			}
			if ( !empty( $key ) && isset( $GLOBALS['arexworks_post_meta'][ $id ][$key] ) && !empty( $GLOBALS['arexworks_post_meta'][ $id ][$key] ) ) {
				if ( $single ){
					return maybe_unserialize( $GLOBALS['arexworks_post_meta'][ $id ][$key][0] );
				}
				else{
					return array_map( 'maybe_unserialize', $GLOBALS['arexworks_post_meta'][ $id ][$key] );
				}
			}
			if ( $single ){
				return false;
			}
			else{
				return array();
			}
		}
		return get_post_meta( $id, $key, $single );
	}
}

if ( !function_exists( 'arexworks_get_term_meta' ) ){
	function arexworks_get_term_meta( $taxonomy, $id, $key = "", $single = true ) {
		$GLOBALS['arexworks_term_meta'] = isset( $GLOBALS['arexworks_term_meta'] ) ? $GLOBALS['arexworks_term_meta'] : array();
		if ( !isset( $id ) ) {
			return false;
		}
		if ( !is_array( $id ) ) {
			if ( ! isset( $GLOBALS['arexworks_term_meta'][ $id ] ) ) {
				if(function_exists('get_term_meta')){
					$GLOBALS['arexworks_term_meta'][ $id ] = get_term_meta($id );
				}else{
					$GLOBALS['arexworks_term_meta'][ $id ] = get_metadata($taxonomy,$id);
				}
			}
			if(!empty($key) && !isset($GLOBALS['arexworks_term_meta'][$id][$key])){
				$meta_tmp = get_metadata($taxonomy,$id);
				$GLOBALS['arexworks_term_meta'][$id][$key] = isset($meta_tmp[$key]) ? $meta_tmp[$key] : '';
			}
			if ( !empty( $key ) && isset( $GLOBALS['arexworks_term_meta'][ $id ][$key] ) && !empty( $GLOBALS['arexworks_term_meta'][ $id ][$key] ) ) {
				if ( $single ){
					return maybe_unserialize( $GLOBALS['arexworks_term_meta'][ $id ][$key][0] );
				}
				else{
					return array_map( 'maybe_unserialize', $GLOBALS['arexworks_term_meta'][ $id ][$key] );
				}
			}
			if ( $single ){
				return false;
			}
			else{
				return array();
			}
		}
		if(function_exists('get_term_meta')){
			return get_term_meta($id, $key, $single);
		}else{
			return get_metadata( $taxonomy, $id, $key, $single );
		}

	}
}

if ( !function_exists( 'arexworks_get_taxonomies' ) ){
	function arexworks_get_taxonomies($taxonomy){
		$args = array(
			'object_type' => array($taxonomy)
		);
		$output = 'names'; // or objects
		$operator = 'and'; // 'and' or 'or'
		$taxonomies = get_taxonomies($args, $output, $operator);
		return $taxonomies;
	}
}

if ( !function_exists( 'arexwoks_get_current_page_url' ) ){
	function arexwoks_get_current_page_url() {
		return add_query_arg(null,null);
	}
}

if ( !function_exists( 'arexworks_translate_id' ) ){
	function arexworks_translate_id($base_id, $type = 'page'){
		global $sitepress;

		if( !defined( 'ICL_LANGUAGE_CODE' ) || !function_exists( 'icl_object_id' ) ) {
			return $base_id;
		}

		$default_language = $sitepress->get_default_language();
		$current_language = ICL_LANGUAGE_CODE;

		if($current_language != $default_language){
			return icl_object_id($base_id, $type);
		}
		return $base_id;
	}
}

if ( !function_exists( 'arexworks_get_logout_url' ) ){
	function arexworks_get_logout_url( $url_redirect = false){
		$logout_nonce = wp_create_nonce("arexworks-logout");
		$link = home_url('/');
		$query_args = array(
			"logout-nonce" => $logout_nonce,
			"to" => urlencode($url_redirect ? $url_redirect : $link)
		);
		if (is_active_woocommerce()) {
			$query_args[get_option("woocommerce_logout_endpoint")] = "true";
		}
		return esc_url(add_query_arg($query_args, $link));
	}
}

if ( !function_exists( 'arexworks_generate_rand' ) ){
	function arexworks_generate_rand() {
		$validCharacters = 'abcdefghijklmnopqrstuvwxyz0123456789';
		$rand = '';
		$length = 32;
		for ($n = 1; $n < $length; $n++) {
			$whichCharacter = rand(0, strlen($validCharacters)-1);
			$rand .= $validCharacters{$whichCharacter};
		}

		return $rand;
	}
}

if ( !function_exists( 'arexworks_return_false' ) ) {
	function arexworks_return_false(){
		return '';
	}
}

if ( !function_exists( 'write_log' ) ) {
	function write_log ( $log )  {
		if ( true === WP_DEBUG ) {
			if ( is_array( $log ) || is_object( $log ) ) {
				error_log( print_r( $log, true ) );
			} else {
				error_log( $log );
			}
		}
	}
}

if ( !function_exists( 'arexworks_get_attachment' ) ) {
	function arexworks_get_attachment( $attachment_id, $size = 'full' )
	{
		if ( !$attachment_id ){
			return false;
		}
		$attachment = get_post( $attachment_id );

		if ( !$attachment ){
			return false;
		}

		$image = wp_get_attachment_image_src( $attachment_id, $size );

		if ( !$image ){
			return false;
		}

		return array(
			'alt'         => esc_attr( arexworks_get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ) ),
			'caption'     => esc_attr( $attachment->post_excerpt ),
			'description' => balanceTags( $attachment->post_content ),
			'href'        => get_permalink( $attachment->ID ),
			'src'         => esc_url( $image[ 0 ] ),
			'title'       => esc_attr( $attachment->post_title ),
			'width'       => esc_attr( $image[ 1 ] ),
			'height'      => esc_attr( $image[ 2 ] )
		);
	}
}

if ( !function_exists( 'arexworks_get_image_resize' ) ) {
	function arexworks_get_image_resize( $attach_id = null, $img_url = null, $width, $height, $crop = false )
	{
		// this is an attachment, so we have the ID
		$image_src = array();
		if ( $attach_id ) {
			$image_src = wp_get_attachment_image_src( $attach_id, 'full' );
			$actual_file_path = get_attached_file( $attach_id );
			// this is not an attachment, let's use the image url
		} else if ( $img_url ) {
			$file_path = parse_url( $img_url );
			$actual_file_path = $_SERVER[ 'DOCUMENT_ROOT' ] . $file_path[ 'path' ];
			$actual_file_path = ltrim( $file_path[ 'path' ], '/' );
			$actual_file_path = rtrim( ABSPATH, '/' ) . $file_path[ 'path' ];
			$orig_size = getimagesize( $actual_file_path );
			$image_src[ 0 ] = $img_url;
			$image_src[ 1 ] = $orig_size[ 0 ];
			$image_src[ 2 ] = $orig_size[ 1 ];
		}
		if ( !empty( $actual_file_path ) ) {
			$file_info = pathinfo( $actual_file_path );
			$extension = '.' . $file_info[ 'extension' ];

			// the image path without the extension
			$no_ext_path = $file_info[ 'dirname' ] . '/' . $file_info[ 'filename' ];

			$cropped_img_path = $no_ext_path . '-' . $width . 'x' . $height . $extension;

			// checking if the file size is larger than the target size
			// if it is smaller or the same size, stop right here and return
			if ( $image_src[ 1 ] > $width || $image_src[ 2 ] > $height ) {

				// the file is larger, check if the resized version already exists (for $crop = true but will also work for $crop = false if the sizes match)
				if ( file_exists( $cropped_img_path ) ) {
					$cropped_img_url = str_replace( basename( $image_src[ 0 ] ), basename( $cropped_img_path ), $image_src[ 0 ] );
					$vt_image = array(
						'url'    => $cropped_img_url,
						'width'  => $width,
						'height' => $height
					);

					return $vt_image;
				}

				// $crop = false
				if ( $crop == false ) {
					// calculate the size proportionaly
					$proportional_size = wp_constrain_dimensions( $image_src[ 1 ], $image_src[ 2 ], $width, $height );
					$resized_img_path = $no_ext_path . '-' . $proportional_size[ 0 ] . 'x' . $proportional_size[ 1 ] . $extension;

					// checking if the file already exists
					if ( file_exists( $resized_img_path ) ) {
						$resized_img_url = str_replace( basename( $image_src[ 0 ] ), basename( $resized_img_path ), $image_src[ 0 ] );

						$vt_image = array(
							'url'    => $resized_img_url,
							'width'  => $proportional_size[ 0 ],
							'height' => $proportional_size[ 1 ]
						);

						return $vt_image;
					}
				}

				// no cache files - let's finally resize it
				$img_editor = wp_get_image_editor( $actual_file_path );

				if ( is_wp_error( $img_editor ) || is_wp_error( $img_editor->resize( $width, $height, $crop ) ) ) {
					return array(
						'url'    => '',
						'width'  => '',
						'height' => ''
					);
				}

				$new_img_path = $img_editor->generate_filename();

				if ( is_wp_error( $img_editor->save( $new_img_path ) ) ) {
					return array(
						'url'    => '',
						'width'  => '',
						'height' => ''
					);
				}
				if ( !is_string( $new_img_path ) ) {
					return array(
						'url'    => '',
						'width'  => '',
						'height' => ''
					);
				}

				$new_img_size = getimagesize( $new_img_path );
				$new_img = str_replace( basename( $image_src[ 0 ] ), basename( $new_img_path ), $image_src[ 0 ] );

				// resized output
				$vt_image = array(
					'url'    => $new_img,
					'width'  => $new_img_size[ 0 ],
					'height' => $new_img_size[ 1 ]
				);

				return $vt_image;
			}

			// default output - without resizing
			$vt_image = array(
				'url'    => $image_src[ 0 ],
				'width'  => $image_src[ 1 ],
				'height' => $image_src[ 2 ]
			);

			return $vt_image;
		}
		return false;
	}
}

if ( !function_exists( 'arexworks_get_social_share_link' ) ){
	function arexworks_get_social_share_link( $post_id = false ){
		if($post_id === false){
			global $post;
			$post_id = $post->ID;
		}

		echo '<div class="share-links">';

		$nofollow = 'rel="nofollow"';
		$image = esc_url(wp_get_attachment_url( get_post_thumbnail_id($post_id) ));
		$permalink = esc_url( apply_filters( 'the_permalink', get_permalink($post_id) ) );
		$title = esc_attr(get_the_title($post_id));

		$extra_attr = 'target="_blank" ' . $nofollow;

		if ( arexworks_get_option_data('social-share-facebook') ) :
			?><a href="http://www.facebook.com/sharer.php?u=<?php echo $permalink ?>&amp;text=<?php echo $title ?>&amp;images=<?php echo $image ?>" <?php echo $extra_attr ?> title="<?php echo __('Facebook', 'arw-leka') ?>" class="share-facebook"><i class="fa fa-facebook"></i></a><?php
		endif;

		if ( arexworks_get_option_data('social-share-twitter') ) :
			?><a href="https://twitter.com/intent/tweet?text=<?php echo $title ?>&amp;url=<?php echo $permalink ?>" <?php echo $extra_attr ?> title="<?php echo __('Twitter', 'arw-leka') ?>" class="share-twitter"><i class="fa fa-twitter"></i></a><?php
		endif;

		if ( arexworks_get_option_data('social-share-linkedin') ) :
			?><a href="https://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo $permalink ?>&amp;title=<?php echo $title ?>" <?php echo $extra_attr ?> title="<?php echo __('LinkedIn', 'arw-leka') ?>" class="share-linkedin"><i class="fa fa-linkedin"></i></a><?php
		endif;

		if ( arexworks_get_option_data('social-share-google-plus') ) :
			?><a href="https://plus.google.com/share?url=<?php echo $permalink ?>" <?php echo $extra_attr ?> title="<?php echo __('Google +', 'arw-leka') ?>" class="share-googleplus"><i class="fa fa-google-plus"></i></a><?php
		endif;

		if ( arexworks_get_option_data('social-share-pinterest') ) :
			?><a href="https://pinterest.com/pin/create/button/?url=<?php echo $permalink ?>&amp;media=<?php echo $image ?>" <?php echo $extra_attr ?> title="<?php echo __('Pinterest', 'arw-leka') ?>" class="share-pinterest"><i class="fa fa-pinterest-p"></i></a><?php
		endif;

		if ( arexworks_get_option_data('social-share-email') ) :
			?><a href="mailto:?subject=<?php echo $title ?>&amp;body=<?php echo $permalink ?>" <?php echo $extra_attr ?> title="<?php echo __('Email', 'arw-leka') ?>" class="share-email"><i class="fa fa-envelope"></i></a><?php
		endif;

		echo '</div>';
	}
}

if ( !function_exists( 'arexworks_is_wp_ajax')){
	function arexworks_is_wp_ajax(){
		if (defined('DOING_AJAX') && DOING_AJAX) {
			return true;
		}else{
			return false;
		}
	}
}

if(!function_exists('arexworks_wp_filesystem')){
	function arexworks_wp_filesystem(){
		if(class_exists('WP_Filesystem_Direct')){
			global $wp_filesystem;
			return $wp_filesystem;
		}else{
			require_once ABSPATH . '/wp-admin/includes/class-wp-filesystem-base.php';
			require_once ABSPATH . '/wp-admin/includes/class-wp-filesystem-direct.php';
			$wp_filesystem_direct = new WP_Filesystem_Direct(false);
			return $wp_filesystem_direct;
		}
	}
}
