<?php get_header();?>
<?php
global $wp_rewrite, $arexworks_loop, $wp_query;
$class_main = 'site-content ';
$class_main .= function_exists('arexworks_get_css_class_for_main') ?  arexworks_get_css_class_for_main() : 'large-12 columns';


$rand_id = arexworks_generate_rand();

$portfolio_layout = arexworks_get_option_data('portfolio_display_type','layout_1');
$portfolio_image_type = arexworks_get_option_data('portfolio_display_image_type','thumbnail');
$columns = arexworks_get_option_data('portfolio_display_columns','3');

$enable_portfolio_filter = arexworks_get_option_data('portfolio_enable_skill_filter',false);
$enable_portfolio_isotope = arexworks_get_option_data('portfolio_enable_mode_isotope',false);
$enable_portfolio_infinite = arexworks_get_option_data('portfolio_enable_infinite_scroll',false);

$portfolio_filter_by = array(
	'portfolio_skill'
);
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
if ( $enable_portfolio_infinite ){
	$class_block_grid .= ' portfolios-infinite-container';
}
if ( $enable_portfolio_isotope ){
	$class_block_grid .= ' arexworks-isotope-container';
}
$class_block_grid .= ' arexworks-portfolio-container';
$class_block_grid .= ' arexworks-portfolio-container-'.esc_attr($portfolio_layout);
$class_block_grid .= ' arexworks-portfolio-container-image-'.esc_attr($portfolio_image_type);

?>
<?php do_action( 'arexworks_action_before_render_main' );?>
	<div class="main">
		<div class="row">
			<div id="site-content" class="<?php echo esc_attr($class_main);?>">
				<div class="site-content-inner">
					<?php do_action( 'arexworks_action_before_render_main_inner' );?>
					<div id="arexworks_blog_content_container">
						<?php
						if(have_posts())
						{
							$data_attribute_infinite = '';
							if ( $enable_portfolio_infinite ){
								$page_num = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
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

							if( $enable_portfolio_isotope ){
								$config_isotope = array(
									'layoutMode' => 'packery'
								);
								$data_attribute_infinite .= ' data-config_isotope="'.esc_attr(json_encode($config_isotope)).'" ';
							}

							$open_wrapper = '<div id="arexworks_portfolio_container_'.esc_attr($rand_id).'" class="'.esc_attr($class_block_grid).'" ' . $data_attribute_infinite . '>';
							$close_wrapper = '</div>';

							if( $enable_portfolio_isotope ){
								$portfolio_filter_html = '';
								if ( $enable_portfolio_filter ){
									$portfolio_filter_html = '<div class="portfolio-filter-wrapper isotope-filter-wrapper" data-isotope_container="#arexworks_portfolio_container_'.esc_attr($rand_id).'">';
									$portfolio_filter_html .= '<ul>';
									$portfolio_filter_html .= '<li data-filter="*" class="active"><a href="#">' . esc_html__('All', 'arw-leka') . '</a></li>';
									$terms = get_terms($portfolio_filter_by);
									if( $terms && ! is_wp_error($terms)){
										foreach ( $terms as $term ){
											$term_class = $term->taxonomy . '-' . $term->slug;
											$portfolio_filter_html .=  '<li data-filter="' . esc_attr( $term_class ) . '"><a href="#">' . esc_html($term->name) . '</a></li>';
										}
									}
									$portfolio_filter_html .= '</ul>';
									$portfolio_filter_html .= '</div>';
								}
								$open_wrapper = '<div class="arexworks-isotope">' . $portfolio_filter_html . $open_wrapper;
								$isotope_loading_html = '<div class="arexworks-isotope-loading"><div></div></div>';
								$close_wrapper = $isotope_loading_html . '</div>' . $close_wrapper;
							}

							$arexworks_loop['columns'] = $columns;
		                    $arexworks_loop['portfolio_image_type'] = $portfolio_image_type;
							$arexworks_loop['portfolio_layout'] = $portfolio_layout;
							$arexworks_loop['rand_id'] = $rand_id;

							echo $open_wrapper;

							do_action( 'arexworks_action_before_render_main_loop' );
							while(have_posts())
							{
								the_post();
	                            get_template_part('template-shares/portfolio_loop/content');
							}
							do_action( 'arexworks_action_after_render_main_loop' );

							echo $close_wrapper;

						}
						arexworks_display_pagination();
						$arexworks_loop = array();
						wp_reset_postdata();
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