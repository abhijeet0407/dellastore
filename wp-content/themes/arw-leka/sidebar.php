<?php

$sidebar_primary_class      = function_exists('arexworks_get_css_class_for_sidebar_primary') ?  arexworks_get_css_class_for_sidebar_primary() : 'hide';
$sidebar_secondary_class    = function_exists('arexworks_get_css_class_for_sidebar_secondary') ?  arexworks_get_css_class_for_sidebar_secondary() : 'hide';
$site_layout                = function_exists('arexworks_get_site_layout') ? arexworks_get_site_layout() : 'col-1c';

?>
<?php if( $site_layout != 'col-1c' ): ?>
    <div id="sidebar_primary" class="<?php echo esc_attr($sidebar_primary_class);?>">
        <div class="sidebar-inner">
            <?php
            if( $site_layout == 'col-2cr' ){
                if( is_active_sidebar('sidebar-secondary') )
                {
                    dynamic_sidebar('sidebar-secondary');
                }
                else
                {
                    if( is_active_sidebar('sidebar-primary') )
                    {
                        dynamic_sidebar('sidebar-primary');
                    }
                }
            }
            else
            {
                if( is_active_sidebar('sidebar-primary') )
                {
                    dynamic_sidebar('sidebar-primary');
                }
            }
            ?>
        </div>
    </div>
<?php endif;?>
<?php if( in_array( $site_layout, array('col-3cl','col-3cm','col-3cr') ) ): ?>
    <div id="sidebar_secondary" class="<?php echo esc_attr($sidebar_secondary_class);?>">
        <div class="sidebar-inner">
            <?php
            if( is_active_sidebar('sidebar-secondary') )
            {
                dynamic_sidebar('sidebar-secondary');
            }
            ?>
        </div>
    </div>
<?php
endif;