<!-- footer -->
<div class="footer-wrapper">
	<footer id="site-footer">
		<!-- site-footer-first-widget-area -->
		<div class="site-footer-first-widget-area">
			<div class="row">
				<div class="column">
					<div class="site-footer-first-widget-area-content">
						<div class="row">
							<div class="footer-left medium-6 large-6 columns">
								<?php
								if(is_active_sidebar('footer-column-1')){
									dynamic_sidebar( 'footer-column-1' );
								}
								?>
							</div>
							<div class="footer-right medium-6 large-6 columns">
								<?php
								if(is_active_sidebar('footer-column-2')){
									dynamic_sidebar( 'footer-column-2' );
								}
								?>
								<!-- copyright_text -->
								<div class="copyright_text">
									<?php echo arexworks_get_option_data('footer_copyright_text');?>
								</div>
								<!-- ./copyright_text -->
								<!-- payment_method -->
								<div class="payment_methods">
									<?php echo arexworks_get_option_data('footer_copyright_right_text');?>
								</div>
								<!-- ./payment_method -->
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- ./site-footer-first-widget-area -->
		</div>
	</footer>
</div>
<!-- ./footer -->