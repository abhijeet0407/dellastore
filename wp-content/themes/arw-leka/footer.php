<?php
do_action('arexworks_action_before_render_header_template');

	arexworks_get_footer_template();

do_action('arexworks_action_after_render_header_template');
?>
		</div>
		<!-- ./page_wrapper -->
		<div id="mobile_menu_wrapper_overlay"></div>
		<div id="mobile_menu_wrapper" class="hide-for-large-up">
			<?php
				do_action('arexwokrs_action_before_render_mobile_menu');
					arexworks_get_mobile_main_menu();
				do_action('arexwokrs_action_after_render_mobile_menu');
			?>
		</div>
	</div>
</div>

<?php
$show_popup = arexworks_get_option_data('show_popup','no');
if($show_popup != 'no'){
	$popup_content = arexworks_get_option_data('popup_content');
	if($popup_content){
		if($show_popup == 'all'){
			echo '<div id="arw_window_popup">'.arexworks_shortcode_js_remove_wpautop($popup_content).'</div>';
		}
		if($show_popup == 'home' && is_front_page()){
			echo '<div id="arw_window_popup">'.arexworks_shortcode_js_remove_wpautop($popup_content).'</div>';
		}
	}
}
?>

<!--[if lt IE 9]>
<script src="<?php echo esc_url(trailingslashit(arexworks_js) . 'html5shiv.min.js'); ?>"></script>
<script src="<?php echo esc_url(trailingslashit(arexworks_js) . 'respond.min.js') ?>"></script>
<![endif]-->
<?php
	wp_footer();
	do_action('arexworks_action_after_render_body_tag');
?>
    </body>
</html>