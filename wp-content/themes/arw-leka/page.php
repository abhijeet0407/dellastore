<?php
get_header();

$class_main = 'site-content ';
$class_main .= function_exists('arexworks_get_css_class_for_main') ?  arexworks_get_css_class_for_main() : 'large-12 columns';

do_action( 'arexworks_action_before_render_main' );
?>
	<div class="main">
		<div class="row">
			<div id="site-content" class="<?php echo esc_attr($class_main);?>">
				<div class="site-content-inner">

					<?php do_action( 'arexworks_action_before_render_main_inner' );?>

					<div class="entry-content">
						<?php
						do_action( 'arexworks_action_before_render_main_content' );
						if( have_posts() ):  the_post();
							the_content();
							wp_link_pages( array(
								               'before' => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'arw-leka' ) . '</span>',
								               'after' => '</div>',
								               'link_before' => '<span>',
								               'link_after' => '</span>'
							               ) );
							if ( !is_front_page() && !is_home() && ( comments_open() || get_comments_number() ) ){
								comments_template();
							}
						endif;
						do_action( 'arexworks_action_after_render_main_content' );
						?>
					</div>

					<?php do_action( 'arexworks_action_after_render_main_inner' );?>

				</div>
			</div>
			<?php
			do_action( 'arexworks_action_before_render_sidebar' );
			get_sidebar();
			do_action( 'arexworks_action_after_render_sidebar' );
			?>
		</div>
	</div>
<?php
do_action( 'arexworks_action_after_render_main' );

get_footer();