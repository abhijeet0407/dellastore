<!-- footer -->
<div class="footer-wrapper">
	<footer id="site-footer">
		<!-- site-footer-first-widget-area -->
		<div class="site-footer-first-widget-area">
			<div class="row">
				<div class="column">
					<div class="site-footer-first-widget-area-content">
						<div class="row">
							<div class="medium-6 large-4 columns">
								<?php
									if(is_active_sidebar('footer-column-1')){
										dynamic_sidebar( 'footer-column-1' );
									}
								?>
							</div>
							<div class="medium-3 large-2 columns">
								<?php
									if(is_active_sidebar('footer-column-2')){
										dynamic_sidebar( 'footer-column-2' );
									}
								?>
							</div>
							<div class="medium-3 large-2 columns">
								<?php
									if(is_active_sidebar('footer-column-3')){
										dynamic_sidebar( 'footer-column-3' );
									}
								?>
							</div>
							<div class="medium-3 large-2 columns">
								<?php
									if(is_active_sidebar('footer-column-4')){
										dynamic_sidebar( 'footer-column-4' );
									}
								?>
							</div>
							<div class="medium-3 large-2 columns">
								<?php
									if(is_active_sidebar('footer-column-5')){
										dynamic_sidebar( 'footer-column-5' );
									}
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- ./site-footer-first-widget-area -->
		<!-- site-footer-copyright-area -->
		<div class="site-footer-copyright-area">
			<div class="row">
				<div class="column">
					<div class="site-footer-content">
						<div class="row">
							<!-- copyright_text -->
							<div class="copyright_text large-7 columns">
								<?php echo arexworks_get_option_data('footer_copyright_text');?>
							</div>
							<!-- ./copyright_text -->
							<!-- payment_method -->
							<div class="payment_methods large-5 columns">
								<?php echo arexworks_get_option_data('footer_copyright_right_text');?>
							</div>
							<!-- ./payment_method -->
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- ./site-footer-copyright-area -->
	</footer>
</div>
<!-- ./footer -->