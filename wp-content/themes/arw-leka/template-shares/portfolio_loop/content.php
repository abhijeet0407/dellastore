<?php
global $arexworks_loop, $post;
$post_layout = isset($arexworks_loop['portfolio_layout']) ? $arexworks_loop['portfolio_layout'] : 'layout_1';
$classes = 'portfolio-loop grid-item isotope-item';
$thumbnail_size = isset($arexworks_loop['portfolio_image_type']) ? $arexworks_loop['portfolio_image_type'] : 'thumbnail';
$taxonomy = 'portfolio_category';

$portfolio_width = arexworks_get_post_meta(get_the_ID(),'portfolio_width',true);
if($portfolio_width){
	$classes .= ' portfolio-width-' . $portfolio_width;
}
?>

<article <?php post_class($classes . ' post portfolio portfolio-' . $post_layout); ?>>

	<div class="portfolio-box">

		<?php
		$thumbnail = apply_filters( 'arexworks_filter_portfolio_loop_thumbnail', '', $post, $post_layout, $thumbnail_size );
		if ( $thumbnail ) echo $thumbnail;
		?>

		<div class="portfolio-content">
			<h4 class="portfolio-title"><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h4>
			<?php
			$terms = get_the_terms( get_the_ID(), $taxonomy );
			if ( $terms && ! is_wp_error( $terms ) ){
				$output = '<div class="portfolio-category-list">';
				$is_first = true;
				foreach ( $terms as $term ){
					if ( $is_first ){
						$is_first = false;
						$output .= sprintf(
							'<a href="%s" title="%s">%s</a>',
							esc_url( get_term_link( $term, $taxonomy ) ),
							esc_attr( $term->name ),
							esc_html( $term->name )
						);
					}
				}
				$output .= '</div>';
				echo $output;
			}
			?>
		</div>

	</div>

</article>