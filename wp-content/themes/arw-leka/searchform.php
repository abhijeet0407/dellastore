<form method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <label class="screen-reader-text"><?php esc_html_e( 'Search for:', 'arw-leka' ); ?></label>
    <input type="search" class="search-field" placeholder="<?php esc_attr_e( 'Search &hellip;', 'arw-leka' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="s">
    <button type="submit" class="search-submit"><?php esc_html_e( 'Search', 'arw-leka' ); ?></button>
</form>