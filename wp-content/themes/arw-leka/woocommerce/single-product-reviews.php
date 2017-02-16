<?php
/**
 * Display single product reviews (comments)
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.2
 */
global $product;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! comments_open() ) {
	return;
}

?>
<div id="comments" class="comments-area clearfix">
    <?php if ( have_comments() ) : ?>
	    <div class="comments-title">
		    <h2>
			    <?php
			    if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' && ( $count = $product->get_review_count() ) )
				    printf( _n( '%s review for %s', '%s reviews for %s', $count, 'arw-leka' ), $count, get_the_title() );
			    else
				    _e( 'Reviews', 'arw-leka' );
			    ?>
		    </h2>
	    </div>
        <div class="comments-container">
            <ul class="comments-list">
                <?php wp_list_comments( apply_filters( 'woocommerce_product_review_list_args', array( 'callback' => 'woocommerce_comments' ) ) ); ?>
            </ul><!-- .comment-list -->
            <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
                echo '<nav class="woocommerce-pagination">';
                paginate_comments_links( apply_filters( 'woocommerce_comment_pagination_args', array(
                    'prev_text' => '&larr;',
                    'next_text' => '&rarr;',
                    'type'      => 'list',
                ) ) );
                echo '</nav>';
            endif; ?>
        </div>
    <?php else:?>
        <p class="woocommerce-noreviews"><?php _e( 'There are no reviews yet.', 'arw-leka' ); ?></p>
    <?php endif; // have_comments() ?>
    <?php if ( get_option( 'woocommerce_review_rating_verification_required' ) === 'no' || wc_customer_bought_product( '', get_current_user_id(), $product->id ) ) : ?>
	    <div id="review_form">
		    <?php
		    $commenter = wp_get_current_commenter();

		    $comment_form = array(
			    'title_reply'          => have_comments() ? esc_html__( 'Add a review', 'arw-leka' ) : esc_html__( 'Be the first to review', 'arw-leka' ) . ' &ldquo;' . get_the_title() . '&rdquo;',
			    'title_reply_to'       => __( 'Leave a Reply to %s', 'arw-leka' ),
			    'comment_notes_before' => '',
			    'comment_notes_after'  => '',
			    'fields'               => array(
				    'author' => '<p class="comment-form-author">' . '<label for="author">' . esc_html__( 'Name', 'arw-leka' ) . ' <span class="required">*</span></label> ' .
					    '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" aria-required="true" /></p>',
				    'email'  => '<p class="comment-form-email"><label for="email">' . esc_html__( 'Email', 'arw-leka' ) . ' <span class="required">*</span></label> ' .
					    '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" aria-required="true" /></p>',
			    ),
			    'id_submit'            => 'comment_form_submit',
			    'class_submit'         => 'button',
			    'submit_button'        => '<button name="%1$s" type="submit" id="%2$s" class="%3$s" >%4$s</button>',
			    'label_submit'  => esc_html__( 'Submit', 'arw-leka' ),
			    'logged_in_as'  => '',
			    'comment_field' => ''
		    );

		    if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' ) {
			    $comment_form['comment_field'] = '<p class="comment-form-rating"><label for="rating" >' . esc_html__( 'Your Rating', 'arw-leka' ) .'</label><select name="rating" id="rating">
							<option value="">' . esc_html__( 'Rate&hellip;', 'arw-leka' ) . '</option>
							<option value="5">' . esc_html__( 'Perfect', 'arw-leka' ) . '</option>
							<option value="4">' . esc_html__( 'Good', 'arw-leka' ) . '</option>
							<option value="3">' . esc_html__( 'Average', 'arw-leka' ) . '</option>
							<option value="2">' . esc_html__( 'Not that bad', 'arw-leka' ) . '</option>
							<option value="1">' . esc_html__( 'Very Poor', 'arw-leka' ) . '</option>
						</select></p>';
		    }

		    $comment_form['comment_field'] .= '<p class="comment-form-comment"><label for="comment">' . esc_html__( 'Your Review', 'arw-leka' ) . '</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>';

		    comment_form( apply_filters( 'woocommerce_product_review_comment_form_args', $comment_form ) );
		    ?>
	    </div>

    <?php else : ?>

        <p class="woocommerce-verification-required"><?php esc_html_e( 'Only logged in customers who have purchased this product may leave a review.', 'arw-leka' ); ?></p>

    <?php endif; ?>
</div><!-- #comments -->