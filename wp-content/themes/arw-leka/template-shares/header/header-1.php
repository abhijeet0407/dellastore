<?php
global $woocommerce;
$_logo_default = trailingslashit(get_template_directory_uri()) . 'assets/images/logo.png';
$_logo_src = arexworks_get_option_data('site_logo',$_logo_default,'url');
$_logo_alt_src = arexworks_get_option_data('site_logo_alt',$_logo_default,'url');
$_site_name = get_bloginfo('name');
$_site_description = get_bloginfo('description');
$_show_search = arexworks_get_option_data("main_header_search_bar", false) ? true : false;
$_show_cart = (function_exists('is_active_woocommerce') && is_active_woocommerce() && arexworks_get_option_data("main_header_shopping_bag",false) && ! arexworks_get_option_data("catalog_mode",false)) ? true : false;
?>
<div class="header-wrapper">
	<header id="header" class="site-header sticky-menu-header">
		<div class="header-top">
			<div class="row">
				<div class="large-6 columns header-left">
					<div class="site-top-bar-text">
						<?php
						$top_bar_text = arexworks_get_option_data('top_bar_text');
						echo function_exists('arexworks_add_formatting') ? arexworks_add_formatting($top_bar_text) : $top_bar_text;
						?>
					</div>
				</div>
				<div class="large-6 columns header-right">
					<div id="site-navigation-top-bar" class="top-bar-navigation">
						<?php
						arexworks_get_top_bar_menu();
						?>
					</div>
				</div>
			</div>
		</div>
		<div class="header-main">
			<div class="header-left">
				<div class="row">
					<div class="large-12 columns">
					<?php echo (is_front_page() && is_home()) ? '<h1 class="site-logo">' : '<div class="site-logo">' ;?>
					<a href="<?php echo home_url("/")?>">
						<img src="<?php echo esc_url($_logo_src);?>" alt="<?php echo esc_attr($_site_name);?>" title="<?php echo esc_attr($_site_description);?>" class="site-logo-image"/>
					</a>
					<?php echo (is_front_page() && is_home()) ? '</h1>' : '</div>' ;?>
					</div>
				</div>
			</div>
			<div class="header-right">
				<div class="main-menu-wrap">
					<div class="row">
						<div class="large-12 columns">
							<div id="main-menu">
								<div class="sticky-logo">
									<a href="<?php echo home_url("/")?>">
										<img src="<?php echo esc_url($_logo_alt_src);?>" alt="<?php echo esc_attr($_site_name);?>" title="<?php echo esc_attr($_site_description);?>" class="site-logo-image"/>
									</a>
								</div>
								<?php arexworks_get_main_menu();?>
								<div class="header-actions">
									<ul>
										<li class="toggle-menu-mobile hide-for-large-up">
											<a href="#" class="toggle-menu-mobile-button tools_button">
												<span class="tools_button_icon"><i class="lnr lnr-menu"></i></span>
											</a>
										</li>
										<?php if($_show_cart):?>
											<li class="shopping-bag-button">
												<a aria-expanded="false" data-dropdown="header-mini-cart" class="tools_button" href="<?php echo esc_url($woocommerce->cart->get_cart_url()); ?>">
													<span class="tools_button_icon"><i class="lnr lnr-cart"></i></span>
													<span class="cart-items"><?php echo $woocommerce->cart->cart_contents_count ? $woocommerce->cart->cart_contents_count : "0"; ?></span>
												</a>
											</li>
										<?php endif;?>
										<?php if($_show_search):?>
											<li class="search-button">
												<a class="tools_button" aria-expanded="false" data-dropdown="header-search-form" data-options="" href="#"><span class="tools_button_icon"><i class="lnr lnr-magnifier"></i></span></a>
											</li>
										<?php endif;?>
									</ul>
									<?php if($_show_search):?>
										<div id="header-search-form" class="small f-dropdown" data-dropdown-content><?php
											if(function_exists('get_product_search_form') && !arexworks_get_option_data('main_header_search_default',false)){
												get_product_search_form();
											}else{
												get_search_form();
											}
										?></div>
									<?php endif;?>
									<?php if($_show_cart):?>
										<div id="header-mini-cart" class="small f-dropdown mini-cart" data-dropdown-content>
											<div class="widget_shopping_cart">
												<div class="widget_shopping_cart_content">
													<div class="cart-loading"></div>
												</div>
											</div>
										</div>
									<?php endif;?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</header>
</div>