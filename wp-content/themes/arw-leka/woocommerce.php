<?php
if ( is_product() && ( isset($_GET['product_quickview']) || isset($_REQUEST['product_quickview'])) ) :
	while ( have_posts() ) : the_post();
		wc_get_template_part( 'content', 'single-quickview' );
	endwhile;
else :
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
						woocommerce_content();
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

endif;