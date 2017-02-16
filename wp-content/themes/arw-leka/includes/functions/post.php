<?php

add_filter( 'arexworks_filter_blog_loop_thumbnail', 'arexworks_add_filter_blog_loop_thumbnail', 10, 4 );
add_filter( 'arexworks_filter_blog_single_thumbnail', 'arexworks_add_filter_blog_single_thumbnail', 10, 4 );
add_filter( 'arexworks_filter_portfolio_loop_thumbnail', 'arexworks_add_filter_portfolio_loop_thumbnail', 10, 4 );
add_filter( 'post_gallery', 'arexworks_filter_post_gallery', 10, 3);

if ( !function_exists( 'arexworks_add_filter_blog_loop_thumbnail' ) ){
	function arexworks_add_filter_blog_loop_thumbnail( $output, $post, $post_layout, $thumbnail_size ){

		if ($post_layout == 'slide'){
			$post_format_icon_html = '<div class="post-meta-date">'.get_the_date('M j Y',$post).'</div>';
		}else{
			$post_format = get_post_format($post);
			switch( $post_format ) {
				case 'link':
					$post_format_icon = 'post-format-icon fa fa-link';
					break;
				case 'video':
					$post_format_icon = 'post-format-icon fa fa-film';
					break;
				case 'audio':
					$post_format_icon = 'post-format-icon fa fa-music';
					break;
				case 'gallery':
					$post_format_icon = 'post-format-icon fa fa-picture-o';
					break;
				case 'image':
					$post_format_icon = 'post-format-icon fa fa-image-o';
					break;
				case 'quote':
					$post_format_icon = 'post-format-icon fa fa-quote-right';
					break;
				default:
					$post_format_icon = 'post-format-icon fa fa-picture-o';
			}
			$post_format_icon_html = '<i class="'.esc_attr($post_format_icon).'"></i>';
		}

		if ( $images = arexworks_get_attachment( get_post_thumbnail_id( $post->ID ), $thumbnail_size ) ) {
			$output = sprintf(
				'<div class="post-thumbnail"><a href="%s" title="%s"><img src="%s" alt="%s" width="%s" height="%s" class="%s"/>%s<div class="post-overlay"></div></a></div>',
				esc_url( get_permalink( $post ) ),
				esc_attr( $post->post_title ),
				esc_url( $images['src'] ),
				esc_attr( $images['alt'] ),
				esc_attr( $images['width'] ),
				esc_attr( $images['height'] ),
				'arexworks-lazy-load',
				$post_format_icon_html
			);
		}else{
			if ($post_layout == 'slide'){
				$output = sprintf(
					'<div class="post-thumbnail"><a href="%s" title="%s"><img src="%s" alt="%s" class="%s"/>%s<div class="post-overlay"></div></a></div>',
					esc_url( get_permalink( $post ) ),
					esc_attr( $post->post_title ),
					esc_url( arexworks_image . '/placeholder2.jpg' ),
					esc_attr( $post->post_title ),
					'arexworks-lazy-load',
					$post_format_icon_html
				);
			}
		}

		return $output;
	}
}

if ( !function_exists( 'arexworks_add_filter_blog_single_thumbnail' ) ){
	function arexworks_add_filter_blog_single_thumbnail($output, $post, $post_layout, $thumbnail_size ){

		$post_format = get_post_format($post);
		switch( $post_format ) {
			case 'link':
				$post_format_icon = 'post-format-icon fa fa-link';
				break;
			case 'video':
				$post_format_icon = 'post-format-icon fa fa-film';
				break;
			case 'audio':
				$post_format_icon = 'post-format-icon fa fa-music';
				break;
			case 'gallery':
				$post_format_icon = 'post-format-icon fa fa-picture-o';
				break;
			case 'image':
				$post_format_icon = 'post-format-icon fa fa-image-o';
				break;
			case 'quote':
				$post_format_icon = 'post-format-icon fa fa-quote-right';
				break;
			default:
				$post_format_icon = 'post-format-icon fa fa-picture-o';
		}

		if ( $thumb_id = get_post_thumbnail_id( $post->ID ) ){
			if ( $images = arexworks_get_attachment( $thumb_id, $thumbnail_size ) ) {
				$output = sprintf(
					'<div class="post-thumbnail"><a href="%s" class="arexworks-fancybox" title="%s"><img src="%s" alt="%s" width="%s" height="%s" class="%s"/><i class="%s"></i><div class="post-overlay"></div></a></div>',
					esc_url( $images['src'] ),
					esc_attr( $post->post_title ),
					esc_url( $images['src'] ),
					esc_attr( $images['alt'] ),
					esc_attr( $images['width'] ),
					esc_attr( $images['height'] ),
					'arexworks-lazy-load',
					esc_attr($post_format_icon)
				);
			}
		}

		return $output;
	}
}

if ( !function_exists( 'arexworks_add_filter_portfolio_loop_thumbnail' ) ) {
	function arexworks_add_filter_portfolio_loop_thumbnail( $output, $post, $post_layout, $thumbnail_size ){
		if ( $images = arexworks_get_attachment( get_post_thumbnail_id( $post->ID ), $thumbnail_size ) ) {
			$output = sprintf(
				'<div class="portfolio-thumbnail"><a href="%s" title="%s"><img src="%s" alt="%s" width="%s" height="%s" class="%s"/>%s<div class="portfolio-overlay"></div></a></div>',
				esc_url( get_permalink( $post ) ),
				esc_attr( $post->post_title ),
				esc_url( $images['src'] ),
				esc_attr( $images['alt'] ),
				esc_attr( $images['width'] ),
				esc_attr( $images['height'] ),
				'arexworks-lazy-load',
				''
			);
		}else{
			$output = sprintf(
				'<div class="portfolio-thumbnail"><a href="%s" title="%s"><img src="%s" alt="%s" class="%s"/>%s<div class="portfolio-overlay"></div></a></div>',
				esc_url( get_permalink( $post ) ),
				esc_attr( $post->post_title ),
				esc_url( arexworks_image . '/placeholder2.jpg' ),
				esc_attr( $post->post_title ),
				'arexworks-lazy-load',
				''
			);
		}

		return $output;
	}
}

if ( !function_exists( 'arexworks_get_url_in_post_content' ) ){
	function arexworks_get_link_url_in_post_content( $content = '') {
		if( empty( $content ) ){
			global $post;
			$content = get_the_content();
		}
		$has_url = get_url_in_content( $content );

		return ( $has_url ) ? esc_url($has_url) : apply_filters( 'the_permalink', get_permalink() );
	}
}

if ( !function_exists( 'arexworks_get_query_related_posts' ) ){
	function arexworks_get_query_related_posts($by_cat = true , $by_tag = false , $by_author = false ,$exclude = array() , $posts_per_page = 5){
		wp_reset_postdata();
		global $post;
		$exclude[] = $post->ID;
		$args =  array(
			'posts_per_page'            => $posts_per_page,
			'no_found_rows'             => true,
			'update_post_meta_cache'    => false,
			'update_post_term_cache'    => false,
			'ignore_sticky_posts'       => 1,
			'post__not_in'              => $exclude
		);

		/*  Related post by categories */

		if($by_cat){
			$cats = get_post_meta($post->ID,'related-cat',true);
			if(!$cats){
				$cats = wp_get_post_categories($post->ID,array('fields'=> 'ids'));
				$args['category__in'] = $cats;
			}else{
				$args['cat'] = $cats;
			}
			if(!$cats){
				$break = true;
			}
		}

		/*  Related post by tags */

		if($by_tag){
			$tags = get_post_meta($post->ID,'related-tag',true);
			if(!$tags){
				$tags = wp_get_post_tags($post->ID,array('fields'=> 'ids'));
				$args['tag__in'] = $tags;
			}else{
				$args['tag_slug__in'] = explode(',',$tags);
			}
			if(!$tags){
				$break = true;
			}
		}

		if($by_author){
			$args['author'] = $post->post_author;
		}
		$query = !isset($break) ? new WP_Query($args) : new WP_Query ;
		return $query;
	}
}

if ( !function_exists( 'arexworks_get_post_date' ) ){
	function arexworks_get_post_date($post = null) {
		if($post == null){
			global $post;
		}
		?>
		<span class="day"><?php echo get_the_time('d', $post->ID); ?></span>
		<span class="month"><?php echo get_the_time('M', $post->ID); ?></span>
	<?php
	}
}

if ( !function_exists( 'arexworks_get_the_category' ) ) {
	function arexworks_get_the_category( $number = 1, $separator = '', $id = false ){
		$i = 0;
		$output = '';
		if ( $number == 0 ){
			return $output;
		}
		$categories = get_the_category( $id );

		if ( $categories && ! is_wp_error( $categories ) ){
			foreach( $categories as $category ) {
				$output .= '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" title="' . esc_attr( sprintf( __( 'View all posts in %s', 'arw-leka' ), $category->name ) ) . '">' . esc_html( $category->name ) . '</a>' . $separator;
				$i++;
				if ( $i == absint( $number ) )
					break;
			}
			return trim( $output, $separator );
		}
	}
}

if ( !function_exists( 'arexworks_comment_callback' ) ){
	function arexworks_comment_callback( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		switch ( $comment->comment_type ) :
			case 'pingback' :
			case 'trackback' :
				?>
				<li id="pingback-comment-<?php comment_ID(); ?>">
				<p class="cmt-pingback"><?php esc_html_e( 'Pingback:', 'arw-leka' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( 'Edit', 'arw-leka' ), '<span class="ping-meta"><span class="edit-link">', '</span></span>' ); ?></p>
				<?php
				break;
			default :
				// Proceed with normal comments.
				?>
				<li class="comment-loop comment-loop-depth-<?php echo esc_attr($depth)?>" id="li-comment-<?php echo esc_attr(get_comment_ID()); ?>">
				<article id="comment-<?php echo esc_attr(get_comment_ID()); ?>" <?php comment_class('clearfix'); ?>>

					<div class="comment-author">
						<?php echo get_avatar( $comment, $args['avatar_size'] ); ?>
					</div>
					<div class="comment-details clearfix">
						<div class="comment-content">
							<?php comment_text(); ?>
						</div>
						<header class="comment-meta">
							<cite class="fn"><?php comment_author_link(); ?></cite>
							<div class="comment-date">
								<?php
								printf( '<time datetime="%1$s">%2$s</time>',
								        get_comment_time( 'c' ),
								        sprintf( _x( '%1$s', '1: date', 'arw-leka' ), get_comment_date() )
								);
								edit_comment_link( __( 'Edit', 'arw-leka' ), ' <span class="edit-link">', '</span>' ); ?>
							</div>
							<?php if ( '0' == $comment->comment_approved ) : ?>
								<em class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'arw-leka' ); ?></em>
							<?php endif; ?>
							<div class="reply">
								<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
							</div>
						</header>

					</div>
				</article>
				<?php
				break;
		endswitch;
	}
}

if ( !function_exists( 'arexworks_display_pagination' ) ){
	function arexworks_display_pagination($args = array()) {
		$output = '<div class="pagination">';
			$output .= paginate_links(
				array_merge(
					array(
						'prev_text'    => __( 'Prev', 'arw-leka' ),
						'next_text'    => __( 'Next', 'arw-leka' ),
						'type'         => 'list'
					),
					$args
				)
			);
		$output .= '</div>';
		echo $output;
	}
}

if( !function_exists( 'arexworks_filter_post_gallery' ) ){
	function arexworks_filter_post_gallery($output, $attr , $instance) {
		$post = get_post();
		$html5 = current_theme_supports( 'html5', 'gallery' );
		$atts = shortcode_atts( array(
			                        'order'      => 'ASC',
			                        'orderby'    => 'menu_order ID',
			                        'id'         => $post ? $post->ID : 0,
			                        'itemtag'    => $html5 ? 'figure'     : 'dl',
			                        'icontag'    => $html5 ? 'div'        : 'dt',
			                        'captiontag' => $html5 ? 'figcaption' : 'dd',
			                        'columns'    => 3,
			                        'size'       => 'thumbnail',
			                        'include'    => '',
			                        'exclude'    => '',
			                        'link'       => ''
		                        ), $attr, 'gallery' );

		$id = intval( $atts['id'] );

		if ( ! empty( $atts['include'] ) ) {
			$_attachments = get_posts( array( 'include' => $atts['include'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );

			$attachments = array();
			foreach ( $_attachments as $key => $val ) {
				$attachments[$val->ID] = $_attachments[$key];
			}
		} elseif ( ! empty( $atts['exclude'] ) ) {
			$attachments = get_children( array( 'post_parent' => $id, 'exclude' => $atts['exclude'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );
		} else {
			$attachments = get_children( array( 'post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );
		}

		if ( empty( $attachments ) ) {
			return '';
		}

		if ( is_feed() ) {
			$output = "\n";
			foreach ( $attachments as $att_id => $attachment ) {
				$output .= wp_get_attachment_link( $att_id, $atts['size'], true ) . "\n";
			}
			return $output;
		}

		// Here's your actual output, you may customize it to your need
		$small_columns = (($atts['columns'] - 2) > 2) ? ($atts['columns'] - 2) : 2;
		$output .= "<div class=\"row\"><ul class=\"no-margin clearing-thumbs small-block-grid-$small_columns medium-block-grid-{$atts['columns']}\" data-clearing>";

		// Now you loop through each attachment
		foreach ($attachments as $id => $attachment) {
			$img = wp_get_attachment_image_src($id, 'full');
			$caption_des = wptexturize($attachment->post_excerpt);
			$output .= '<li><a class="gallery th" href="'.esc_attr($img[0]).'">'.wp_get_attachment_image($id,$atts['size'],false,array('class'=>'','data-caption'=>$caption_des)). ( $caption_des ? '<span class="gallery-caption">'.$caption_des.'</span>' : '' ) .'</a></li>';
		}
		$output .= "</ul></div>\n";

		return $output;
	}
}