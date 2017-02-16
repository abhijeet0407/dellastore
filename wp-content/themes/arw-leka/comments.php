<?php
/*
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
global $wp_rewrite;
?>

<div id="comments" class="comments-area clearfix">
    <?php if ( have_comments() ) : ?>
	    <div class="comments-title">
	        <h2><?php esc_html_e('Comments','arw-leka')?>(<?php echo get_comments_number();?>)</h2>
	    </div>
	    <div class="comments-container">
	        <ul class="comments-list comments-infinite-container" data-path="<?php echo esc_url( $wp_rewrite->using_permalinks() ? user_trailingslashit(trailingslashit(get_permalink()) . $wp_rewrite->comments_pagination_base . '-%#%', 'commentpaged') : esc_url(add_query_arg( 'cpage', '%#%' ) ))?>" data-page_num_max="<?php echo esc_attr( get_comment_pages_count() );?>" data-page_num="<?php echo esc_attr( !get_query_var('cpage') ? 1 : get_query_var('cpage') )?>">
	            <?php
	            wp_list_comments( array(
	                'callback' => 'arexworks_comment_callback',
	                'style'      => 'ul',
	                'avatar_size'=> 70,
	            ) );
	            ?>
	        </ul><!-- .comment-list -->
	        <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
		        echo '<div class="load-more-comments"><span>' . esc_html_e('LOAD MORE COMMENT','arw-leka') . '<i class="fa fa-angle-down"></i></span></div>';
	            echo '<div class="pagination">';
	            paginate_comments_links( array(
	                  'prev_text' => '&larr;',
	                  'next_text' => '&rarr;',
	                  'type'      => 'list'
	              ));
	            echo '</div>';
	        endif; ?>
	    </div>
    <?php else:?>
        <p class="woocommerce-noreviews"><?php esc_html_e( 'There are no reviews yet.','arw-leka' ); ?></p>
    <?php endif;?>
	<?php
	if ( comments_open() ){
		comment_form(array(
             'id_submit'            => 'comment_form_submit',
             'class_submit'         => 'button',
             'submit_button'        => '<button name="%1$s" type="submit" id="%2$s" class="%3$s" >%4$s</button>',
         ));
	}else{
		echo '<div class="clearfix"></div><p class="no-comments">'. esc_html__( 'Comments are closed.', 'arw-leka' ) .'</p>';
	}?>

</div><!-- #comments -->
