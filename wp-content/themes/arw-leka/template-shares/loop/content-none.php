<article class="post-loop post post-grid page type-page status-publish hentry">
	<div class="grid-box">
		<div class="post-content">
			<h4 class="entry-title"><?php _e( 'Nothing Found', 'arw-leka' ); ?></h4>

			<div class="post-excerpt">

				<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

					<p><?php printf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'arw-leka' ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

				<?php elseif ( is_search() ) : ?>

					<p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'arw-leka' ); ?></p>


				<?php else : ?>

					<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'arw-leka' ); ?></p>

				<?php endif; ?>
			</div>
		</div>
	</div>
</article>