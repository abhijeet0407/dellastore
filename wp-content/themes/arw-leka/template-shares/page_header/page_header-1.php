<?php if ( arexworks_enable_show_page_title() || arexworks_enable_show_breadcrumbs() ) : ?>
	<div class="page-header-wrapper">
		<div class="row">
			<div class="columns">
				<?php if ( arexworks_enable_show_page_title() ) :?>
				<div class="page_header_title">
					<h1><?php echo arexworks_page_title();?></h1>
				</div>
				<?php endif;?>
				<?php if ( arexworks_enable_show_breadcrumbs() ) :?>
				<div class="page_header_breadcrumbs">
					<?php echo arexworks_breadcrumbs();?>
				</div>
				<?php endif;?>
			</div>
		</div>
	</div>
<?php endif; ?>