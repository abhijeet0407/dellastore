<?php
/*
Page 404
*/
?>
<?php get_header();?>
    <div class="main"">
        <div id="site-content" class="site-content">
            <div class="site-content-inner">
                <div class="entry-content entry-content-404">
                    <div class="row">
                        <div class="medium-6 columns">
                            <div class="text-center">
                                <h3 class="letter-spacing-5"><?php esc_html_e('OOPS, SORRY!','arw-leka')?></h3>
                                <h1 class="text-color-primary highlight-font-family letter-spacing-10"><?php esc_html_e('404','arw-leka')?></h1>
                                <h3 class="letter-spacing-5"><?php esc_html_e('PAGE NOT FOUND','arw-leka')?></h3>
                            </div>
                        </div>
                        <div class="medium-6 columns">
                            <p><a href="<?php echo home_url('/')?>" class="button"><i class="fa fa-angle-left"></i><?php esc_html_e('Go back','arw-leka')?></a></p>
                            <p>
	                            <?php esc_html_e('OR TAKE A MOMENT','arw-leka')?>
	                            <br/>
	                            <?php esc_attr_e('AND DO A SEARCH BELOW','arw-leka')?>
                            </p>
                            <?php get_search_form();?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php get_footer();?>