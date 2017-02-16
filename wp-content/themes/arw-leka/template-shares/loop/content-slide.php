<?php
global $arexworks_loop, $post;
$post_layout = 'slide';
$classes = 'columns post-loop';
$thumbnail_size = 'thumbnail';
$excerpt_length = isset($arexworks_loop['excerpt_length']) && $arexworks_loop['excerpt_length'] ? $arexworks_loop['excerpt_length'] : 30;
?>

<article <?php post_class($classes . ' post post-' . $post_layout); ?>>

	<div class="grid-box clearfix">

		<?php
			$thumbnail = apply_filters( 'arexworks_filter_blog_loop_thumbnail', '', $post, $post_layout, $thumbnail_size );
			if ( $thumbnail ) echo $thumbnail;
		?>

		<div class="post-content">
			<h4 class="entry-title"><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h4>
			<?php
			echo arexworks_get_the_excerpt_with_limit( $excerpt_length );
			?>
			<div class="post-meta">
				<?php if( comments_open() ):?>
					<div class="post-meta-comment">
						<span><i class="fa fa-comments"></i> <?php comments_popup_link( '0', '1', '%' ); ?></span>
					</div>
				<?php endif;?>
			</div>
		</div>
	</div>

</article>