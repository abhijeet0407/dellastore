<?php
global $post;
$post_layout = 'single';
$classes = 'portfolio-loop';
$thumbnail_size = 'full';
$taxonomy = 'portfolio_category';
?>

<article <?php post_class($classes . ' post portfolio portfolio-' . $post_layout); ?>>

	<div class="post-single-inner">
		<div class="row">
			<div class="columns medium-7">
				<?php if(has_post_thumbnail()){
					if ( $images = arexworks_get_attachment( get_post_thumbnail_id( get_the_ID() ), $thumbnail_size ) ) {
						echo sprintf(
							'<div class="portfolio-thumbnail"><a href="%s" title="%s" rel="portfolio-gallery" class="arexworks-fancybox"><img src="%s" alt="%s" width="%s" height="%s" class="%s"/>%s<div class="portfolio-overlay"></div></a></div>',
							esc_url( $images['src'] ),
							esc_attr( get_the_title() ),
							esc_url( $images['src'] ),
							esc_attr( $images['alt'] ),
							esc_attr( $images['width'] ),
							esc_attr( $images['height'] ),
							'arexworks-lazy-load',
							''
						);
					}
				}?>
				<div class="portfolio-galleries">
					<?php
					if ( $portfolio_galleries = arexworks_get_post_meta( get_the_ID(), 'portfolio_gallery', true ) ){
						$portfolio_galleries = explode( ',', $portfolio_galleries );
						$portfolio_galleries = array_map( 'trim', $portfolio_galleries );
						foreach ( $portfolio_galleries as $gallery ){
							if ( $images = arexworks_get_attachment( $gallery , $thumbnail_size ) ) {
								echo sprintf(
									'<div class="portfolio-gallery"><a href="%s" title="%s" rel="portfolio-gallery" class="arexworks-fancybox"><img src="%s" alt="%s" width="%s" height="%s" class="%s"/>%s<div class="portfolio-overlay"></div></a></div>',
									esc_url( $images['src'] ),
									esc_attr( get_the_title() ),
									esc_url( $images['src'] ),
									esc_attr( $images['alt'] ),
									esc_attr( $images['width'] ),
									esc_attr( $images['height'] ),
									'arexworks-lazy-load',
									''
								);
							}
						}
					}
					?>
				</div>
			</div>
			<div class="columns medium-5">
				<div class="portfolio-content">
					<h2 class="portfolio-title"><?php the_title() ?></h2>
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
					<div class="post-meta-footer">
						<div class="post-share">
							<label><?php _e( 'SHARE TO FRIENDS', 'arw-leka' )?></label>
							<?php arexworks_get_social_share_link();?>
						</div>
					</div>
					<div class="portfolio-entry-meta entry-meta">
						<div class="entry-meta-item"><span><?php _e( 'Author:', 'arw-leka' )?><?php echo arexworks_get_post_meta(get_the_ID(),'portfolio_author')?></span></div>
						<div class="entry-meta-item"><span><?php _e( 'Date:', 'arw-leka' )?><?php the_date();?></span></div>
						<div class="entry-meta-item"><span><?php echo get_the_term_list( get_the_ID(), 'portfolio_skill', 'Skill: ', ', ' ); ?></span></div>
					</div>
					<?php if( $portfolio_link = arexworks_get_post_meta(get_the_ID(),'portfolio_link') ):?>
					<a href="<?php echo esc_url($portfolio_link);?>" class="button button-visit-portfolio-link">
						<?php _e('VISIT TO WEBSITE','arw-leka');?>
					</a>
					<?php endif;?>
				</div>
			</div>
		</div>
	</div>

</article>