<?php
/**
 * Template Name: Blog Grid 2 Columns
 */
?>
<?php
add_filter('arexworks_filter_get_options_layout',function($layout){
	return 'col-1c';
});
?>
<?php get_header();?>
<?php
global $wp_rewrite, $arexworks_loop, $wp_query;
$class_main = 'site-content ';
$class_main .= function_exists('arexworks_get_css_class_for_main') ?  arexworks_get_css_class_for_main() : 'large-12 columns';

$rand_id = arexworks_generate_rand();

$post_layout = 'grid';
$columns = 2;
$enable_post_infinite = arexworks_get_option_data('blog_enable_infinite_scroll',false);

switch($columns){
	case '1':
		$class_block_grid = 'small-block-grid-1 medium-block-grid-1';
		break;
	case '2':
		$class_block_grid = 'small-block-grid-2 medium-block-grid-2';
		break;
	case '3':
		$class_block_grid = 'small-block-grid-2 medium-block-grid-3';
		break;
	case '4':
		$class_block_grid = 'small-block-grid-2 medium-block-grid-3 large-block-grid-4';
		break;
	case '5':
		$class_block_grid = 'small-block-grid-2 medium-block-grid-4 large-block-grid-5';
		break;
	case '6':
		$class_block_grid = 'small-block-grid-2 medium-block-grid-4 large-block-grid-6';
		break;
	default:
		$class_block_grid = 'small-block-grid-2 medium-block-grid-3';
}

if ( $enable_post_infinite ){
	$class_block_grid .= ' posts-infinite-container';
}
if ( $post_layout == 'isotope' ){
	$class_block_grid .= ' arexworks-isotope-container';
}
$class_block_grid .= ' arexworks-posts-container';
$class_block_grid .= ' arexworks-posts-container-'.esc_attr($post_layout);

?>
<?php do_action( 'arexworks_action_before_render_main' );?>
	<div class="main">
		<div class="row">
			<div id="site-content" class="<?php echo esc_attr($class_main);?>">
				<div class="site-content-inner">
					<?php do_action( 'arexworks_action_before_render_main_inner' );?>
					<div id="arexworks_blog_content_container">
						<?php
						$data_attribute_infinite = '';
						$page_num = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;

						if(!is_home()){
							query_posts(array( 'post_type' => 'post', 'paged' => $page_num ));
						}

						if ( $enable_post_infinite ){

							$page_link = get_pagenum_link();
							if ( !$wp_rewrite->using_permalinks() || is_admin() || strpos($page_link, '?') ) {
								if (strpos($page_link, '?') !== false)
									$page_path = apply_filters( 'get_pagenum_link', $page_link . '&amp;paged=');
								else
									$page_path = apply_filters( 'get_pagenum_link', $page_link . '?paged=');
							} else {
								$page_path = apply_filters( 'get_pagenum_link', $page_link . user_trailingslashit( $wp_rewrite->pagination_base . "/" ));
							}
							$data_attribute_infinite = 'data-page_num="' . esc_attr( $page_num ) . '" ';
							$data_attribute_infinite .= 'data-page_num_max="' . esc_attr( $wp_query->max_num_pages ) . '" ';
							$data_attribute_infinite .= 'data-path="' . esc_url( $page_path ) . '" ';
						}

						$open_wrapper = '<div id="arexworks_posts_container_'.esc_attr($rand_id).'" class="'.esc_attr($class_block_grid).'" ' . $data_attribute_infinite . '>';
						$close_wrapper = '</div>';

						if(have_posts())
						{
							if ( $post_layout == 'isotope' ){
								$open_wrapper = '<div class="arexworks-isotope">' . $open_wrapper;
								$isotope_loading_html = '<div class="arexworks-isotope-loading"><div></div></div>';
								$close_wrapper = $isotope_loading_html . '</div>' . $close_wrapper;
							}

							$arexworks_loop['columns'] = $columns;
							$arexworks_loop['post_layout'] = $post_layout;
							$arexworks_loop['rand_id'] = $rand_id;
							$arexworks_loop['excerpt_length'] = 60;

							echo $open_wrapper;

							do_action( 'arexworks_action_before_render_main_loop' );
							while(have_posts())
							{
								the_post();
								get_template_part('template-shares/loop/content', $post_layout);
							}
							do_action( 'arexworks_action_after_render_main_loop' );

							echo $close_wrapper;
						}
						else{
							get_template_part('template-shares/loop/content', 'none');
						}
						arexworks_display_pagination();
						$arexworks_loop = array();
						if(!is_home()){
							wp_reset_query();
						}else{
							wp_reset_postdata();
						}

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
<?php do_action( 'arexworks_action_after_render_main' );?>
<?php get_footer();?>