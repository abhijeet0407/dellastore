<?php
global $post;
$post_layout = 'full';
$classes = 'post-single post-loop clearfix';
$thumbnail_size = 'full';
?>

<article <?php post_class($classes . ' post post-' . $post_layout); ?>>

	<div class="post-single-inner">

		<?php
		$thumbnail = apply_filters( 'arexworks_filter_blog_single_thumbnail', '', $post, $post_layout, $thumbnail_size );
		if ( $thumbnail ) echo $thumbnail;
		?>

		<div class="post-content">
			<h2 class="entry-title"><?php the_title() ?></h2>
			<?php
			$cats_list = arexworks_get_the_category( 1, ', ' );
			if ($cats_list) : ?>
				<span class="post-category-list"><i class="fa fa-folder-open"></i> <?php echo $cats_list ?></span>
			<?php endif; ?>

			<div class="post-meta">
				<div class="left">
					<div class="post-meta-date left"><span><?php echo get_the_date() ?></span></div>
					<div class="post-meta-author margin-left-10 left text-uppercase">
						<span><?php _e( 'By', 'arw-leka' )?></span>
						<?php printf( '<a class="url fn n text-color-primary" href="%1$s" title="%2$s" rel="author">%3$s</a>',
						              esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
						              esc_attr( sprintf( __( 'View all posts by %s', 'arw-leka' ), get_the_author() ) ),
						              get_the_author()
						);?>
					</div>
				</div>
				<div class="right">
					<?php if( comments_open() ):?>
						<div class="post-meta-comment">
							<span><i class="fa fa-comments"></i> <?php comments_popup_link( '0', '1', '%' ); ?></span>
						</div>
					<?php endif;?>
				</div>
			</div>

			<div class="entry-content">
			<?php
				the_content();
				wp_link_pages( array(
	               'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'arw-leka' ) . '</span>',
	               'after'       => '</div>',
	               'link_before' => '<span>',
	               'link_after'  => '</span>',
	               'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'arw-leka' ) . ' </span>%',
	               'separator'   => '<span class="screen-reader-text">, </span>',
               ) );
			?>
			</div>
		</div>

		<?php
		$tags_list = get_the_tag_list( sprintf( '<label>%s</label>', __('Tags', 'arw-leka' ) ), '');
		?>
		<div class="post-meta-footer">
			<div class="post-share">
				<label><?php _e( 'SHARE TO FRIENDS', 'arw-leka' )?></label>
				<?php arexworks_get_social_share_link();?>
			</div>
			<div class="post-tags">
				<?php
				if ($tags_list) : ?>
					<span><?php echo $tags_list ?></span>
				<?php endif; ?>
			</div>
		</div>
	</div>
</article>

<?php if(arexworks_get_option_data('single_show_author_bio')):?>
	<div class="author-bio row margin-bottom-60 padding-top-20">
		<div class="author-image small-3 medium-2 columns">
			<?php echo get_avatar( get_the_author_meta( 'ID'), 120 ,'' ,'' , array('class'=>'circle')); ?>
		</div>
		<div class="author-info small-9 medium-10 columns">
			<div class="author-name">
				<span><?php _e( 'Artice by', 'arw-leka' )?></span>
				<?php printf( '<a class="url fn n text-color-primary text-uppercase" href="%1$s" title="%2$s" rel="author">%3$s</a>',
				              esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
				              esc_attr( sprintf( __( 'View all posts by %s', 'arw-leka' ), get_the_author() ) ),
				              get_the_author()
				);?>
			</div>
			<div class="author-about">
				<?php echo get_the_author_meta('user_description');?>
			</div>
		</div>
	</div>
<?php endif;?>

<?php
if ( comments_open() || get_comments_number() ) :
	comments_template();
endif;