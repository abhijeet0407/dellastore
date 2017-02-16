<?php
global $arexworks_loop, $post;
$post_layout = 'isotope';
$columns = 3;
if ( isset( $arexworks_loop['columns'] ) && $arexworks_loop['columns'] )
	$columns = $arexworks_loop['columns'];
$excerpt_length = isset($arexworks_loop['excerpt_length']) && $arexworks_loop['excerpt_length'] ? $arexworks_loop['excerpt_length'] : 30;
$classes = 'post-loop grid-item isotope-item';

$array_thumb_size = array('thumbnail','medium','large','full','thumbnail');
$array_keys = array_rand($array_thumb_size,2);
$thumbnail_size = $array_thumb_size[$array_keys[0]];
?>

<article <?php post_class($classes . ' post post-' . $post_layout); ?>>

	<div class="grid-box">

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

			<?php
			echo arexworks_get_the_excerpt_with_limit( $excerpt_length );
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