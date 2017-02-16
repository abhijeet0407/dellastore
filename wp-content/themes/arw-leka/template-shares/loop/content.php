<?php
global $arexworks_loop, $post;
$post_layout = 'full';
$classes = 'post-loop grid-item';
$thumbnail_size = 'full';
$excerpt_length = isset($arexworks_loop['excerpt_length']) && $arexworks_loop['excerpt_length'] ? $arexworks_loop['excerpt_length'] : 80;
?>

<article <?php post_class($classes . ' post post-' . $post_layout); ?>>

	<div class="post-loop-inner">

		<?php
			$thumbnail = apply_filters( 'arexworks_filter_blog_loop_thumbnail', '', $post, $post_layout, $thumbnail_size );
			if ( $thumbnail ) echo $thumbnail;
		?>

		<div class="post-content">

			<h4 class="entry-title"><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h4>
			<?php
			$cats_list = arexworks_get_the_category( 1, ', ' );
			if ($cats_list) : ?>
				<span class="post-category-list"><i class="fa fa-folder-open"></i> <?php echo $cats_list ?></span>
			<?php endif; ?>

			<?php if (get_option('rss_use_excerpt') || is_search()){
				echo arexworks_get_the_excerpt_with_limit( $excerpt_length );
			} else {
				echo '<div class="entry-content">';
				the_content();
				wp_link_pages( array(
					               'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'arw-leka' ) . '</span>',
					               'after'       => '</div>',
					               'link_before' => '<span>',
					               'link_after'  => '</span>',
					               'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'arw-leka' ) . ' </span>%',
					               'separator'   => '<span class="screen-reader-text">, </span>',
				               ) );
				echo '</div>';
			}
			?>

		</div>

		<div class="post-meta">
			<div class="left">
				<div class="post-meta-date"><span><?php echo get_the_date() ?></span></div>
			</div>
			<div class="right">
				<?php if( comments_open() ):?>
					<div class="post-meta-comment">
						<span><i class="fa fa-comments"></i> <?php comments_popup_link( '0', '1', '%' ); ?></span>
					</div>
				<?php endif;?>
			</div>
		</div>

	</div>

</article>