<?php
if ( !function_exists( 'arexworks_admin_add_filter_wp_setup_nav_menu_item' ) ){
	add_filter( 'wp_setup_nav_menu_item', 'arexworks_admin_add_filter_wp_setup_nav_menu_item');
	function arexworks_admin_add_filter_wp_setup_nav_menu_item( $menu_item ){

		$array_objects = array(
			'icon'              => '_menu_item_icon',
			'nolink'            => '_menu_item_nolink',
			'hide'              => '_menu_item_hide',
			'mobile_hide'       => '_menu_item_mobile_hide',
			'cols'              => '_menu_item_cols',
			'tip_label'         => '_menu_item_tip_label',
			'tip_color'         => '_menu_item_tip_color',
			'tip_bg'            => '_menu_item_tip_bg',
			'popup_type'        => '_menu_item_popup_type',
			'popup_pos'         => '_menu_item_popup_pos',
			'popup_cols'        => '_menu_item_popup_cols',
			'popup_max_width'   => '_menu_item_popup_max_width',
			'popup_bg_image'    => '_menu_item_popup_bg_image',
			'popup_bg_pos'      => '_menu_item_popup_bg_pos',
			'popup_bg_repeat'   => '_menu_item_popup_bg_repeat',
			'popup_bg_size'     => '_menu_item_popup_bg_size',
			'popup_style'       => '_menu_item_popup_style',
			'block'             => '_menu_item_block'
		);

		foreach ( $array_objects as $key => $meta_key ){
			$menu_item->$key = get_post_meta( $menu_item->ID, $meta_key, true );
		}
		return $menu_item;
	}
}

if ( !function_exists( 'arexworks_admin_add_action_wp_update_nav_menu_item' ) ){
	add_action( 'wp_update_nav_menu_item', 'arexworks_admin_add_action_wp_update_nav_menu_item', 10, 3 );
	function arexworks_admin_add_action_wp_update_nav_menu_item( $menu_id, $menu_item_db_id, $args ){
		$array_objects = array(
			'icon'              => '_menu_item_icon',
			'nolink'            => '_menu_item_nolink',
			'hide'              => '_menu_item_hide',
			'mobile_hide'       => '_menu_item_mobile_hide',
			'cols'              => '_menu_item_cols',
			'tip_label'         => '_menu_item_tip_label',
			'tip_color'         => '_menu_item_tip_color',
			'tip_bg'            => '_menu_item_tip_bg',
			'popup_type'        => '_menu_item_popup_type',
			'popup_pos'         => '_menu_item_popup_pos',
			'popup_cols'        => '_menu_item_popup_cols',
			'popup_max_width'   => '_menu_item_popup_max_width',
			'popup_bg_image'    => '_menu_item_popup_bg_image',
			'popup_bg_pos'      => '_menu_item_popup_bg_pos',
			'popup_bg_repeat'   => '_menu_item_popup_bg_repeat',
			'popup_bg_size'     => '_menu_item_popup_bg_size',
			'popup_style'       => '_menu_item_popup_style',
			'block'             => '_menu_item_block'
		);
		foreach ( $array_objects as $key => $meta_key ) {

			if (!isset($_POST['menu-item-'.$key][$menu_item_db_id])){
				if (!isset($args['menu-item-'.$key]))
					$meta_value = "";
				else
					$meta_value = $args['menu-item-'.$key];
			} else {
				$meta_value = $_POST['menu-item-'.$key][$menu_item_db_id];
			}
			if ( !empty ( $meta_value ) ) {
				update_post_meta( $menu_item_db_id, $meta_key , $meta_value );
			}else{
				delete_post_meta( $menu_item_db_id, $meta_key );
			}
		}
	}
}

if ( !function_exists( 'arexworks_admin_add_filter_wp_edit_nav_menu_walker' ) ){
	add_filter( 'wp_edit_nav_menu_walker', 'arexworks_admin_add_filter_wp_edit_nav_menu_walker', 10, 2 );
	function arexworks_admin_add_filter_wp_edit_nav_menu_walker( $walker, $menu_id ){
		if ( class_exists( 'Arexworks_Walker_Nav_Menu_Edit_Custom' ) ){
			$walker = 'Arexworks_Walker_Nav_Menu_Edit_Custom';
		}
		return $walker;
	}
}

add_filter( 'walker_nav_menu_start_el', 'arexworks_add_icon_to_menu', 10, 4 );

if( !function_exists('arexworks_add_icon_to_menu') ){
	function arexworks_add_icon_to_menu($item_output, $item, $depth, $args){
		if ( !is_a( $args->walker, 'Arexworks_Walker_Top_Nav_Menu' ) && !is_a( $args->walker, 'Arexworks_Walker_Sidebar_Nav_Menu' ) && !is_a( $args->walker, 'Arexworks_Walker_Accordion_Nav_Menu' ) && $item->icon){
			$icon_class = 'mega-menu-item-icon fa fa-' . str_replace('fa-', '', $item->icon);
			$icon = "<i class=\"".esc_attr($icon_class)."\"></i>";
			$pattern = '/>(.*?)<\/a>/';
			$item_output = preg_replace( $pattern, '>' . $args->link_before . $icon . '$1' . $args->link_after . '</a>', $item_output );
		}
		return $item_output;
	}
}

if ( !class_exists( 'Arexworks_Walker_Nav_Menu_Edit_Custom' ) ){
	class Arexworks_Walker_Nav_Menu_Edit_Custom extends Walker_Nav_Menu  {
		/**
		 * @see Walker_Nav_Menu::start_lvl()
		 * @since 3.0.0
		 *
		 * @param string $output Passed by reference.
		 */
		function start_lvl( &$output, $depth = 0, $args = array() ) {
		}

		/**
		 * @see Walker_Nav_Menu::end_lvl()
		 * @since 3.0.0
		 *
		 * @param string $output Passed by reference.
		 */
		function end_lvl( &$output, $depth = 0, $args = array() ) {
		}

		/**
		 * @see Walker::start_el()
		 * @since 3.0.0
		 *
		 * @param string $output Passed by reference. Used to append additional content.
		 * @param object $item Menu item data object.
		 * @param int $depth Depth of menu item. Used for padding.
		 * @param object $args
		 */
		function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
			global $_wp_nav_menu_max_depth;

			$_wp_nav_menu_max_depth = $depth > $_wp_nav_menu_max_depth ? $depth : $_wp_nav_menu_max_depth;

			$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

			$item_id = esc_attr( $item->ID );
			$removed_args = array(
				'action',
				'customlink-tab',
				'edit-menu-item',
				'menu-item',
				'page-tab',
				'_wpnonce',
			);
			ob_start();
			$original_title = '';
			if ( 'taxonomy' == $item->type ) {
				$original_title = get_term_field( 'name', $item->object_id, $item->object, 'raw' );
				if ( is_wp_error( $original_title ) )
					$original_title = false;
			} elseif ( 'post_type' == $item->type ) {
				$original_object = get_post( $item->object_id );
				$original_title = $original_object->post_title;
			}

			$classes = array(
				'menu-item menu-item-depth-' . $depth,
				'menu-item-' . esc_attr( $item->object ),
				'menu-item-edit-' . ( ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? 'active' : 'inactive'),
			);

			$title = $item->title;

			if ( ! empty( $item->_invalid ) ) {
				$classes[] = 'menu-item-invalid';
				/* translators: %s: title of menu item which is invalid */
				$title = sprintf( __( '%s (Invalid)', 'arw-leka' ), $item->title );
			} elseif ( isset( $item->post_status ) && 'draft' == $item->post_status ) {
				$classes[] = 'pending';
				/* translators: %s: title of menu item in draft status */
				$title = sprintf( __( '%s (Pending)', 'arw-leka' ), $item->title );
			}

			$title = empty( $item->label ) ? $title : $item->label;

			?>
			<li id="menu-item-<?php echo $item_id; ?>" class="<?php echo implode(' ', $classes ); ?>">
				<dl class="menu-item-bar">
					<dt class="menu-item-handle">
						<span class="item-title"><?php echo esc_html( $title ); ?></span>
            <span class="item-controls">
                <span class="item-type"><?php echo esc_html( $item->type_label ); ?></span>
                <span class="item-order hide-if-js">
                    <a href="<?php
                    echo wp_nonce_url(
	                    esc_url( add_query_arg(
		                             array(
			                             'action' => 'move-up-menu-item',
			                             'menu-item' => $item_id,
		                             ),
		                             esc_url( remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) ) )
	                             ) ),
	                    'move-menu_item'
                    );
                    ?>" class="item-move-up"><abbr title="Move up">&#8593;</abbr></a>
                    |
                    <a href="<?php
                    echo wp_nonce_url(
	                    esc_url( add_query_arg(
		                             array(
			                             'action' => 'move-down-menu-item',
			                             'menu-item' => $item_id,
		                             ),
		                             esc_url( remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) ) )
	                             ) ),
	                    'move-menu_item'
                    );
                    ?>" class="item-move-down"><abbr title="Move down">&#8595;</abbr></a>
                </span>
                <a class="item-edit" id="edit-<?php echo $item_id; ?>" title="Edit Menu Item" href="<?php
                echo ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] )
	                ? admin_url( 'nav-menus.php' )
	                : esc_url( add_query_arg( 'edit-menu-item', $item_id,
	                                          esc_url( remove_query_arg( $removed_args, admin_url( 'nav-menus.php#menu-item-settings-' . $item_id ) ) ) ) );
                ?>"><?php _e( 'Edit Menu Item', 'arw-leka' ); ?></a>
            </span>
					</dt>
				</dl>

				<div class="menu-item-settings" id="menu-item-settings-<?php echo $item_id; ?>">
					<?php if( 'custom' == $item->type ) : ?>
						<p class="description description-wide">
							<label for="edit-menu-item-url-<?php echo $item_id; ?>">
								<?php _e( 'URL', 'arw-leka' ); ?><br />
								<input type="text" id="edit-menu-item-url-<?php echo $item_id; ?>" class="widefat code edit-menu-item-url"
									<?php if (esc_attr( $item->url )) : ?>
										name="menu-item-url[<?php echo $item_id; ?>]"
									<?php endif; ?>
									   data-name="menu-item-url[<?php echo $item_id; ?>]"
									   value="<?php echo esc_attr( $item->url ); ?>" />
							</label>
						</p>
					<?php endif; ?>
					<p class="description description-wide">
						<label for="edit-menu-item-title-<?php echo $item_id; ?>">
							<?php _e( 'Navigation Label', 'arw-leka' ); ?><br />
							<input type="text" id="edit-menu-item-title-<?php echo $item_id; ?>" class="widefat edit-menu-item-title"
								<?php if (esc_attr( $item->title )) : ?>
									name="menu-item-title[<?php echo $item_id; ?>]"
								<?php endif; ?>
								   data-name="menu-item-title[<?php echo $item_id; ?>]"
								   value="<?php echo esc_attr( $item->title ); ?>" />
						</label>
					</p>
					<p class="description">
						<label for="edit-menu-item-target-<?php echo $item_id; ?>">
							<input type="checkbox" id="edit-menu-item-target-<?php echo $item_id; ?>" value="_blank"
								<?php if ($item->target == '_blank') : ?>
									name="menu-item-target[<?php echo $item_id; ?>]"
								<?php endif; ?>
								   data-name="menu-item-target[<?php echo $item_id; ?>]"
								<?php checked( $item->target, '_blank' ); ?> />
							<?php _e( 'Open link in a new window/tab', 'arw-leka' ); ?>
						</label>
					</p>
					<?php
					/* New fields insertion starts here */
					?>
					<p class="description description-wide">
						<label for="edit-menu-item-icon-<?php echo $item_id; ?>">
							<?php _e( 'Font Awesome Icon Class', 'arw-leka' ); ?><br />
							<input type="text" id="edit-menu-item-icon-<?php echo $item_id; ?>" class="widefat code edit-menu-item-icon"
								<?php if (esc_attr( $item->icon )) : ?>
									name="menu-item-icon[<?php echo $item_id; ?>]"
								<?php endif; ?>
								   data-name="menu-item-icon[<?php echo $item_id; ?>]"
								   value="<?php echo esc_attr( $item->icon ); ?>" />
							<span><?php echo __('Input font awesome icon or icon class. You can see <a target="_blank" href="//fortawesome.github.io/Font-Awesome/icons/">Font Awesome Icons in here</a>.', 'arw-leka') ?></span>
						</label>
					</p>
					<p class="description">
						<label for="edit-menu-item-nolink-<?php echo $item_id; ?>">
							<input type="checkbox" id="edit-menu-item-nolink-<?php echo $item_id; ?>" class="code edit-menu-item-custom" value="nolink"
								<?php if ($item->nolink == 'nolink') : ?>
									name="menu-item-nolink[<?php echo $item_id; ?>]"
								<?php endif; ?>
								   data-name="menu-item-nolink[<?php echo $item_id; ?>]"
								<?php checked( $item->nolink, 'nolink' ); ?> />
							<?php _e( "Don't link", 'arw-leka'); ?>
						</label>
					</p>
					<p class="description">
						<label for="edit-menu-item-hide-<?php echo $item_id; ?>">
							<input type="checkbox" id="edit-menu-item-hide-<?php echo $item_id; ?>" class="code edit-menu-item-custom" value="hide"
								<?php if ($item->hide == 'hide') : ?>
									name="menu-item-hide[<?php echo $item_id; ?>]"
								<?php endif; ?>
								   data-name="menu-item-hide[<?php echo $item_id; ?>]"
								<?php checked( $item->hide, 'hide' ); ?> />
							<?php _e( "Don't show item", 'arw-leka' ); ?>
						</label>
					</p>
					<p class="description">
						<label for="edit-menu-item-mobile_hide-<?php echo $item_id; ?>">
							<input type="checkbox" id="edit-menu-item-mobile_hide-<?php echo $item_id; ?>" class="code edit-menu-item-custom" value="hide"
								<?php if ($item->mobile_hide == 'hide') : ?>
									name="menu-item-mobile_hide[<?php echo $item_id; ?>]"
								<?php endif; ?>
								   data-name="menu-item-mobile_hide[<?php echo $item_id; ?>]"
								<?php checked( $item->mobile_hide, 'hide' ); ?> />
							<?php _e( "Don't show item on mobile panel", 'arw-leka' ); ?>
						</label>
					</p>
					<div class="edit-menu-item-level0-<?php echo $item_id; ?>" style="<?php if ($depth == 0) echo 'display:block;'; else echo 'display:none;' ?>">
						<div style="clear:both;"></div>
						<p class="description description-thin description-thin-custom">
							<label for="edit-menu-item-type-menu-<?php echo $item_id; ?>">
								<?php _e( 'Menu Type', 'arw-leka' ); ?><br />
								<select id="edit-menu-item-type-menu-<?php echo $item_id; ?>"
									<?php if (esc_attr($item->popup_type)) : ?>
										name="menu-item-popup_type[<?php echo $item_id; ?>]"
									<?php endif; ?>
									    data-name="menu-item-popup_type[<?php echo $item_id; ?>]"
									>
									<option value="" <?php if(esc_attr($item->popup_type) == ""){echo 'selected="selected"';} ?>><?php esc_html_e( 'Narrow', 'arw-leka' ) ?></option>
									<option value="wide" <?php if(esc_attr($item->popup_type) == "wide"){echo 'selected="selected"';} ?>><?php esc_html_e( 'Wide', 'arw-leka' ) ?></option>
								</select>
							</label>
						</p>
						<p class="description description-thin description-thin-custom">
							<label for="edit-menu-item-popup_pos-<?php echo $item_id; ?>">
								<?php _e( 'Popup Position', 'arw-leka' ); ?><br />
								<select id="edit-menu-item-popup_pos-<?php echo $item_id; ?>"
									<?php if (esc_attr($item->popup_pos)) : ?>
										name="menu-item-popup_pos[<?php echo $item_id; ?>]"
									<?php endif; ?>
									    data-name="menu-item-popup_pos[<?php echo $item_id; ?>]"
									>
									<option value="pos-left" <?php if(esc_attr($item->popup_pos) == "pos-left"){echo 'selected="selected"';} ?>><?php esc_html_e( 'Left' , 'arw-leka') ?></option>
									<option value="pos-right" <?php if(esc_attr($item->popup_pos) == "pos-right"){echo 'selected="selected"';} ?>><?php esc_html_e( 'Right', 'arw-leka' ) ?></option>
									<option value="" <?php if(esc_attr($item->popup_pos) == ""){echo 'selected="selected"';} ?>><?php esc_html_e( 'Justify (only wide)', 'arw-leka' ) ?></option>
									<option value="pos-center" <?php if(esc_attr($item->popup_pos) == "pos-center"){echo 'selected="selected"';} ?>><?php esc_html_e( 'Center (only wide)', 'arw-leka' ) ?></option>
								</select>
							</label>
						</p>
						<div style="clear:both;"></div>
						<p class="description description-wide">
							<label for="edit-menu-item-popup_cols-<?php echo $item_id; ?>">
								<?php echo 'Popup Columns (only wide)'; ?><br />
								<select id="edit-menu-item-popup_cols-<?php echo $item_id; ?>"
									<?php if ($item->popup_cols) : ?>
										name="menu-item-popup_cols[<?php echo $item_id; ?>]"
									<?php endif; ?>
									    data-name="menu-item-popup_cols[<?php echo $item_id; ?>]"
									>
									<option value="" <?php if(esc_attr($item->popup_cols) == ""){echo 'selected="selected"';} ?>><?php esc_html_e( 'Select', 'arw-leka' ) ?></option>
									<option value="col-4" <?php if(esc_attr($item->popup_cols) == "col-4"){echo 'selected="selected"';} ?>><?php esc_html_e( '4 Columns', 'arw-leka' ) ?></option>
									<option value="col-3" <?php if(esc_attr($item->popup_cols) == "col-3"){echo 'selected="selected"';} ?>><?php esc_html_e( '3 Columns', 'arw-leka' ) ?></option>
									<option value="col-2" <?php if(esc_attr($item->popup_cols) == "col-2"){echo 'selected="selected"';} ?>><?php esc_html_e( '2 Columns', 'arw-leka' ) ?></option>
									<option value="col-5" <?php if(esc_attr($item->popup_cols) == "col-5"){echo 'selected="selected"';} ?>><?php esc_html_e( '5 Columns', 'arw-leka' ) ?></option>
									<option value="col-6" <?php if(esc_attr($item->popup_cols) == "col-6"){echo 'selected="selected"';} ?>><?php esc_html_e( '6 Columns', 'arw-leka') ?></option>
								</select>
							</label>
						</p>
						<p class="description description-wide">
							<label for="edit-menu-item-popup_max_width-<?php echo $item_id; ?>">
								<?php _e( 'Popup Max Width (only wide)', 'arw-leka' ); ?><br />
								<input type="text" id="edit-menu-item-popup_max_width-<?php echo $item_id; ?>" class="widefat code edit-menu-item-popup_max_width"
									<?php if (esc_attr( $item->popup_max_width )) : ?>
										name="menu-item-popup_max_width[<?php echo $item_id; ?>]"
									<?php endif; ?>
									   data-name="menu-item-popup_max_width[<?php echo $item_id; ?>]"
									   value="<?php echo esc_attr( $item->popup_max_width ); ?>" />
							</label>
						</p>
						<br/>
					</div>
					<div class="edit-menu-item-level1-<?php echo $item_id; ?>" style="<?php if ($depth == 1) echo 'display:block;'; else echo 'display:none;' ?>">
						<div style="clear:both;"></div>
						<p class="description description-wide">
							<label for="edit-menu-item-cols-<?php echo $item_id; ?>">
								<?php _e( 'Columns (only wide)', 'arw-leka' ); ?><br />
								<input type="text" id="edit-menu-item-cols-<?php echo $item_id; ?>" class="widefat code edit-menu-item-cols"
									<?php if (esc_attr( $item->cols )) : ?>
										name="menu-item-cols[<?php echo $item_id; ?>]"
									<?php endif; ?>
									   data-name="menu-item-cols[<?php echo $item_id; ?>]"
									   value="<?php echo esc_attr( $item->cols?$item->cols:1 ); ?>" />
								<span class="description"><?php echo 'will occupy x columns of parent popup columns' ?></span>
							</label>
						</p>
						<?php if(post_type_exists('static_block') && $posts_block = get_posts(array('posts_per_page'=>-1,'post_type'=>'static_block'))):?>
							<p class="description description-thin">
								<label for="edit-menu-item-block-<?php echo $item_id; ?>">
									<?php _e( 'Block Name', 'arw-leka' ); ?><br />
									<select class="widefat" id="edit-menu-item_block-<?php echo $item_id; ?>"
										<?php if (esc_attr( $item->block )) : ?>
											name="menu-item-block[<?php echo $item_id; ?>]"
										<?php endif; ?>
										    data-name="menu-item-block[<?php echo $item_id; ?>]"
										>
										<option value="" <?php selected($item->block,"");?>><?php esc_html_e( 'Select', 'arw-leka' )?></option>
										<?php foreach($posts_block as $p_b):?>
											<option <?php selected($item->block,$p_b->ID);?> value="<?php echo $p_b->ID?>"><?php echo esc_html($p_b->post_title);?></option>
										<?php endforeach;?>
									</select>
								</label>
							</p>
						<?php endif;?>
						<br/>
					</div>
					<div class="edit-menu-item-level01-<?php echo $item_id; ?>" style="<?php if ($depth == 0 || $depth == 1) echo 'display:block;'; else echo 'display:none;' ?>">
						<p class="description description-wide">
							<label for="edit-menu-item-popup_bg_image-<?php echo $item_id; ?>">
								<?php _e( 'Background Image (only wide)', 'arw-leka' ); ?><br />
								<input type="text" id="edit-menu-item-popup_bg_image-<?php echo $item_id; ?>" class="widefat code edit-menu-item-popup_bg_image"
									<?php if (esc_attr( $item->popup_bg_image )) : ?>
										name="menu-item-popup_bg_image[<?php echo $item_id; ?>]"
									<?php endif; ?>
									   data-name="menu-item-popup_bg_image[<?php echo $item_id; ?>]"
									   value="<?php echo esc_attr( $item->popup_bg_image ); ?>" />
								<br/>
								<input class="button_upload_image button" data-id="edit-menu-item-popup_bg_image-<?php echo $item_id; ?>" type="button" value="Upload Image" />&nbsp;
								<input class="button_remove_image button" data-id="edit-menu-item-popup_bg_image-<?php echo $item_id; ?>" type="button" value="Remove Image" />
							</label>
						</p>
						<p class="description description-wide">
							<label for="edit-menu-item-popup_bg_pos-<?php echo $item_id; ?>">
								<?php echo 'Background Position (only wide)'; ?><br />
								<select id="edit-menu-item-popup_bg_pos-<?php echo $item_id; ?>"
									<?php if ($item->popup_bg_pos) : ?>
										name="menu-item-popup_bg_pos[<?php echo $item_id; ?>]"
									<?php endif; ?>
									    data-name="menu-item-popup_bg_pos[<?php echo $item_id; ?>]"
									>
									<option value="" <?php if(esc_attr($item->popup_bg_pos) == ""){echo 'selected="selected"';} ?>><?php esc_html_e( 'Select', 'arw-leka' ) ?></option>
									<option value="left top" <?php if(esc_attr($item->popup_bg_pos) == "left top"){echo 'selected="selected"';} ?>><?php esc_html_e( 'Left Top', 'arw-leka' ) ?></option>
									<option value="left center" <?php if(esc_attr($item->popup_bg_pos) == "left center"){echo 'selected="selected"';} ?>><?php esc_html_e( 'Left Center' , 'arw-leka') ?></option>
									<option value="left center" <?php if(esc_attr($item->popup_bg_pos) == "left center"){echo 'selected="selected"';} ?>><?php esc_html_e( 'Left Center', 'arw-leka' ) ?></option>
									<option value="left bottom" <?php if(esc_attr($item->popup_bg_pos) == "left bottom"){echo 'selected="selected"';} ?>><?php esc_html_e( 'Left Bottom', 'arw-leka' ) ?></option>
									<option value="center top" <?php if(esc_attr($item->popup_bg_pos) == "center top"){echo 'selected="selected"';} ?>><?php esc_html_e( 'Center Top', 'arw-leka' ) ?></option>
									<option value="center center" <?php if(esc_attr($item->popup_bg_pos) == "center center"){echo 'selected="selected"';} ?>><?php esc_html_e( 'Center Center', 'arw-leka' ) ?></option>
									<option value="center bottom" <?php if(esc_attr($item->popup_bg_pos) == "center bottom"){echo 'selected="selected"';} ?>><?php esc_html_e( 'Center Bottom', 'arw-leka' ) ?></option>
									<option value="right top" <?php if(esc_attr($item->popup_bg_pos) == "right top"){echo 'selected="selected"';} ?>><?php esc_html_e( 'Right Top', 'arw-leka' ) ?></option>
									<option value="right center" <?php if(esc_attr($item->popup_bg_pos) == "right center"){echo 'selected="selected"';} ?>><?php esc_html_e( 'Right Center', 'arw-leka' ) ?></option>
									<option value="right bottom" <?php if(esc_attr($item->popup_bg_pos) == "right bottom"){echo 'selected="selected"';} ?>><?php esc_html_e( 'Right Bottom', 'arw-leka' ) ?></option>
									);
								</select>
							</label>
						</p>
						<p class="description description-wide">
							<label for="edit-menu-item-popup_bg_repeat-<?php echo $item_id; ?>">
								<?php echo 'Background Repeat (only wide)'; ?><br />
								<select id="edit-menu-item-popup_bg_repeat-<?php echo $item_id; ?>"
									<?php if ($item->popup_bg_repeat) : ?>
										name="menu-item-popup_bg_repeat[<?php echo $item_id; ?>]"
									<?php endif; ?>
									    data-name="menu-item-popup_bg_repeat[<?php echo $item_id; ?>]"
									>
									<option value="" <?php if(esc_attr($item->popup_bg_repeat) == ""){echo 'selected="selected"';} ?>><?php esc_html_e( 'Select', 'arw-leka' ) ?></option>
									<option value="no-repeat" <?php if(esc_attr($item->popup_bg_repeat) == "no-repeat"){echo 'selected="selected"';} ?>><?php esc_html_e( 'No Repeat', 'arw-leka' ) ?></option>
									<option value="repeat" <?php if(esc_attr($item->popup_bg_repeat) == "repeat"){echo 'selected="selected"';} ?>><?php esc_html_e( 'Repeat All', 'arw-leka' ) ?></option>
									<option value="repeat-x" <?php if(esc_attr($item->popup_bg_repeat) == "repeat-x"){echo 'selected="selected"';} ?>><?php esc_html_e( 'Repeat Horizontally', 'arw-leka' ) ?></option>
									<option value="repeat-y" <?php if(esc_attr($item->popup_bg_repeat) == "repeat-y"){echo 'selected="selected"';} ?>><?php esc_html_e( 'Repeat Vertically', 'arw-leka' ) ?></option>
									<option value="inherit" <?php if(esc_attr($item->popup_bg_repeat) == "inherit"){echo 'selected="selected"';} ?>><?php esc_html_e( 'Inherit', 'arw-leka' ) ?></option>
								</select>
							</label>
						</p>
						<p class="description description-wide">
							<label for="edit-menu-item-popup_bg_size-<?php echo $item_id; ?>">
								<?php esc_html_e( 'Background Size (only wide)' , 'arw-leka' ); ?><br />
								<select id="edit-menu-item-popup_bg_size-<?php echo $item_id; ?>"
									<?php if ($item->popup_bg_size) : ?>
										name="menu-item-popup_bg_size[<?php echo $item_id; ?>]"
									<?php endif; ?>
									    data-name="menu-item-popup_bg_size[<?php echo $item_id; ?>]"
									>
									<option value="" <?php if(esc_attr($item->popup_bg_size) == ""){echo 'selected="selected"';} ?>><?php esc_html_e( 'Select', 'arw-leka' ) ?></option>
									<option value="inherit" <?php if(esc_attr($item->popup_bg_size) == "inherit"){echo 'selected="selected"';} ?>><?php esc_html_e( 'Inherit', 'arw-leka' ) ?></option>
									<option value="cover" <?php if(esc_attr($item->popup_bg_size) == "cover"){echo 'selected="selected"';} ?>><?php esc_html_e( 'Cover', 'arw-leka' ) ?></option>
									<option value="contain" <?php if(esc_attr($item->popup_bg_size) == "contain"){echo 'selected="selected"';} ?>><?php esc_html_e( 'Contain', 'arw-leka' ) ?></option>
								</select>
							</label>
						</p>
						<p class="description description-wide">
							<label for="edit-menu-item-popup_style-<?php echo $item_id; ?>">
								<?php _e( 'Custom Styles (only wide)', 'arw-leka' ); ?><br />
                <textarea id="edit-menu-item-popup_style-<?php echo $item_id; ?>" class="widefat edit-menu-item-popup_style" rows="3" cols="20"
	                <?php if (esc_html( $item->popup_style )) : ?>
		                name="menu-item-popup_style[<?php echo $item_id; ?>]"
	                <?php endif; ?>
	                      data-name="menu-item-popup_style[<?php echo $item_id; ?>]"
	                ><?php echo esc_html( $item->popup_style ); ?></textarea>
							</label>
						</p>
						<br/>
					</div>
					<p class="description description-thin">
						<label for="edit-menu-item-tip_label-<?php echo $item_id; ?>">
							<?php _e( 'Tip Label', 'arw-leka' ); ?><br />
							<input type="text" id="edit-menu-item-tip_label-<?php echo $item_id; ?>" class="widefat code edit-menu-item-tip_label"
								<?php if (esc_attr( $item->tip_label )) : ?>
									name="menu-item-tip_label[<?php echo $item_id; ?>]"
								<?php endif; ?>
								   data-name="menu-item-tip_label[<?php echo $item_id; ?>]"
								   value="<?php echo esc_attr( $item->tip_label ); ?>" />
						</label>
					</p>
					<p class="description description-thin">
						<label for="edit-menu-item-tip_color-<?php echo $item_id; ?>">
							<?php _e(  'Tip Text Color', 'arw-leka' ); ?><br />
							<input type="text" id="edit-menu-item-tip_color-<?php echo $item_id; ?>" class="widefat code edit-menu-item-tip_color"
								<?php if (esc_attr( $item->tip_color )) : ?>
									name="menu-item-tip_color[<?php echo $item_id; ?>]"
								<?php endif; ?>
								   data-name="menu-item-tip_color[<?php echo $item_id; ?>]"
								   value="<?php echo esc_attr( $item->tip_color ); ?>" />
						</label>
					</p>
					<p class="description description-thin">
						<label for="edit-menu-item-tip_bg-<?php echo $item_id; ?>">
							<?php _e( 'Tip BG Color', 'arw-leka' ); ?><br />
							<input type="text" id="edit-menu-item-tip_bg-<?php echo $item_id; ?>" class="widefat code edit-menu-item-tip_bg"
								<?php if (esc_attr( $item->tip_bg )) : ?>
									name="menu-item-tip_bg[<?php echo $item_id; ?>]"
								<?php endif; ?>
								   data-name="menu-item-tip_bg[<?php echo $item_id; ?>]"
								   value="<?php echo esc_attr( $item->tip_bg ); ?>" />
						</label>
					</p><br/>
					<?php
					/* New fields insertion ends here */
					?><div style="clear:both;"></div>
					<p class="description description-wide">
						<label for="edit-menu-item-attr-title-<?php echo $item_id; ?>">
							<?php _e( 'Title Attribute', 'arw-leka' ); ?><br />
							<input type="text" id="edit-menu-item-attr-title-<?php echo $item_id; ?>" class="widefat edit-menu-item-attr-title"
								<?php if (esc_attr( $item->post_excerpt )) : ?>
									name="menu-item-attr-title[<?php echo $item_id; ?>]"
								<?php endif; ?>
								   data-name="menu-item-attr-title[<?php echo $item_id; ?>]"
								   value="<?php echo esc_attr( $item->post_excerpt ); ?>" />
						</label>
					</p>
					<p class="description description-thin">
						<label for="edit-menu-item-classes-<?php echo $item_id; ?>">
							<?php _e( 'CSS Classes (optional)', 'arw-leka' ); ?><br />
							<input type="text" id="edit-menu-item-classes-<?php echo $item_id; ?>" class="widefat code edit-menu-item-classes"
								<?php if (esc_attr( implode(' ', $item->classes ) )) : ?>
									name="menu-item-classes[<?php echo $item_id; ?>]"
								<?php endif; ?>
								   data-name="menu-item-classes[<?php echo $item_id; ?>]"
								   value="<?php echo esc_attr( implode(' ', $item->classes ) ); ?>" />
						</label>
					</p>
					<p class="description description-thin">
						<label for="edit-menu-item-xfn-<?php echo $item_id; ?>">
							<?php _e( 'Link Relationship (XFN)', 'arw-leka' ); ?><br />
							<input type="text" id="edit-menu-item-xfn-<?php echo $item_id; ?>" class="widefat code edit-menu-item-xfn"
								<?php if (esc_attr( $item->xfn )) : ?>
									name="menu-item-xfn[<?php echo $item_id; ?>]"
								<?php endif; ?>
								   data-name="menu-item-xfn[<?php echo $item_id; ?>]"
								   value="<?php echo esc_attr( $item->xfn ); ?>" />
						</label>
					</p>
					<p class="description description-wide">
						<label for="edit-menu-item-description-<?php echo $item_id; ?>">
							<?php _e( 'Description', 'arw-leka' ); ?><br />
            <textarea id="edit-menu-item-description-<?php echo $item_id; ?>" class="widefat edit-menu-item-description" rows="3" cols="20"
	            <?php if (esc_html( $item->description )) : ?>
		            name="menu-item-description[<?php echo $item_id; ?>]"
	            <?php endif; ?>
	                  data-name="menu-item-description[<?php echo $item_id; ?>]"
	            ><?php echo esc_html( $item->description ); // textarea_escaped ?></textarea>
							<span class="description"><?php echo 'The description will be displayed in the menu if the current theme supports it.'; ?></span>
						</label>
					</p>
					<div class="menu-item-actions description-wide submitbox">
						<?php if( 'custom' != $item->type && $original_title !== false ) : ?>
							<p class="link-to-original">
								<?php printf( __( 'Original: %s', 'arw-leka' ), '<a href="' . esc_attr( $item->url ) . '">' . esc_html( $original_title ) . '</a>' ); ?>
							</p>
						<?php endif; ?>
						<a class="item-delete submitdelete deletion" id="delete-<?php echo $item_id; ?>" href="<?php
						echo wp_nonce_url(
							esc_url( add_query_arg(
								         array(
									         'action' => 'delete-menu-item',
									         'menu-item' => $item_id,
								         ),
								         esc_url( remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) ) )
							         ) ),
							'delete-menu_item_' . $item_id
						); ?>"><?php esc_html_e( 'Remove', 'arw-leka' ); ?></a> <span class="meta-sep"> | </span> <a class="item-cancel submitcancel" id="cancel-<?php echo $item_id; ?>" href="<?php echo esc_url( add_query_arg( array('edit-menu-item' => $item_id, 'cancel' => time()), esc_url( remove_query_arg( $removed_args, admin_url( 'nav-menus.php' ) ) ) ) );
						?>#menu-item-settings-<?php echo $item_id; ?>"><?php _e( 'Cancel', 'arw-leka' ); ?></a>
					</div>

					<input class="menu-item-data-db-id" type="hidden" name="menu-item-db-id[<?php echo $item_id; ?>]" value="<?php echo $item_id; ?>" />
					<input class="menu-item-data-object-id" type="hidden" name="menu-item-object-id[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->object_id ); ?>" />
					<input class="menu-item-data-object" type="hidden" name="menu-item-object[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->object ); ?>" />
					<input class="menu-item-data-parent-id" type="hidden" name="menu-item-parent-id[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->menu_item_parent ); ?>" />
					<input class="menu-item-data-position" type="hidden" name="menu-item-position[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->menu_order ); ?>" />
					<input class="menu-item-data-type" type="hidden" name="menu-item-type[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->type ); ?>" />
				</div><!-- .menu-item-settings-->
				<ul class="menu-item-transport"></ul>
			</li>
			<?php
			$output .= ob_get_clean();
		}
	}
}

if ( !class_exists( 'Arexworks_Walker_Top_Nav_Menu' ) ) {
	class Arexworks_Walker_Top_Nav_Menu extends Walker_Nav_Menu {

		protected $count_lv_0 = 0;
		protected $counter = 0;

		// add classes to ul sub menus
		function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {
			$id_field = $this->db_fields['id'];
			if ( is_object( $args[0] ) ) {
				$args[0]->has_children = ! empty( $children_elements[$element->$id_field] );
			}

			if($depth == 0){
				$this->counter++;
				if(is_object( $args[0] ) && isset($args[0]->display_logo) && $args[0]->display_logo){
					$order_before_add = ceil($this->count_lv_0 / 2);
					if($order_before_add%2==0){
						$order_before_add = $order_before_add + 1;
					}
					if($this->counter == $order_before_add){
						if(isset( $args[0]->logo_menu )){
							$output .= $args[0]->logo_menu;
						}
					}
				}
			}

			return parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
		}

		// add popup class to ul sub-menus
		function start_lvl( &$output, $depth = 0, $args = array() ) {
			$indent = str_repeat("\t", $depth);

			if ( $depth == 0 ) {
				$out_div = '<div class="popup"><div class="inner" style="'.esc_attr($args->popup_style).'">';
			} else {
				$out_div = '';
			}
			$output .= "\n$indent$out_div<ul class=\"sub-menu\">\n";
		}

		function end_lvl( &$output, $depth = 0, $args = array() ) {
			$indent = str_repeat("\t", $depth);
			if ( $depth == 0 ) {
				$out_div = '</div></div>';
			} else {
				$out_div = '';
			}
			$output .= "$indent</ul>$out_div\n";
		}

		// add main/sub classes to li's and links
		function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
			global $wp_query;

			$sub = "";
			$indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent
			if ( $depth == 0 && $args->has_children )
				$sub = ' has-sub';

			if ( $depth == 1 && $args->has_children )
				$sub = ' sub';

			$active = "";

			// depth dependent classes
			if ( $item->current || $item->current_item_ancestor || $item->current_item_parent )
				$active = 'active';

			// passed classes
			$classes = empty( $item->classes ) ? array() : (array)$item->classes;

			$class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ) );

			// menu type, type, column class, popup style
			$menu_type = "";
			$popup_pos = "";
			$popup_cols = "";
			$popup_style = "";
			$cols = 1;

			if ($depth == 0) {

				if ($item->popup_type == "wide") {
					$menu_type = " wide";
					if ($item->popup_cols == "")
						$item->popup_cols = 'col-4';
					$popup_cols = " ". $item->popup_cols;

					$popup_bg_image = '';
					if($item->popup_bg_image){
						$arr_need_replace = array('http://','https://');
						$arr_replace = array('//','//');
						$mm_bg_image = str_replace($arr_need_replace,$arr_replace,$item->popup_bg_image);
						$popup_bg_image = 'background-image:url('.esc_url($mm_bg_image).');';
					}
					$popup_bg_pos = $item->popup_bg_pos ? ';background-position:'.$item->popup_bg_pos.';' : '';
					$popup_bg_repeat = $item->popup_bg_repeat ? ';background-repeat:'.$item->popup_bg_repeat.';' : '';
					$popup_bg_size = $item->popup_bg_size ? ';background-size:'.$item->popup_bg_size.';' : '';
					$popup_max_width = $item->popup_max_width ? ';max-width:'.(int)$item->popup_max_width.'px;' : '';

					$popup_style = str_replace('"', '\'', $item->popup_style . $popup_bg_image . $popup_bg_pos . $popup_bg_repeat . $popup_bg_size . $popup_max_width);
				} else {
					$menu_type = " narrow";
				}
				$popup_pos = " ". $item->popup_pos;

			}

			// build html
			if ($depth == 1) {
				$sub_popup_style = '';
				if ($item->popup_style || $item->popup_bg_image || $item->popup_bg_pos || $item->popup_bg_repeat || $item->popup_bg_size) {
					$sub_popup_image = '';
					if($item->popup_bg_image){
						$arr_need_replace = array('http://','https://');
						$arr_replace = array('//','//');
						$mm_bg_image = str_replace($arr_need_replace,$arr_replace,$item->popup_bg_image);
						$sub_popup_image = 'background-image:url('.esc_url($mm_bg_image).');';
					}
					$sub_popup_pos = $item->popup_bg_pos ? ';background-position:'.$item->popup_bg_pos.';' : '';;
					$sub_popup_repeat = $item->popup_bg_repeat ? ';background-repeat:'.$item->popup_bg_repeat.';' : '';;
					$sub_popup_size = $item->popup_bg_size ? ';background-size:'.$item->popup_bg_size.';' : '';;
					$sub_popup_style = ' style="'.esc_attr(str_replace('"', '\'', $item->popup_style).$sub_popup_image.$sub_popup_pos.$sub_popup_repeat.$sub_popup_size).'"';
				}
				if ($item->cols > 1) {
					$cols = (int)$item->cols;
				}
				if ($item->block)
					$class_names .= ' menu-block-item ';
				$output .= $indent . '<li id="nav-menu-item-'. $item->ID . '" class="' . esc_attr( $class_names . ' ' . $active . $sub . $menu_type . $popup_pos . $popup_cols ) . '" data-cols="'.$cols.'"'.$sub_popup_style.'>';
			} else {
				$output .= $indent . '<li id="nav-menu-item-'. $item->ID . '" class="' . esc_attr( $class_names . ' ' . $active . $sub . $menu_type . $popup_pos . $popup_cols ) . '">';
			}

			$current_a = "";

			// link attributes
			$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
			$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
			$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
			$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

			if ( ( $item->current && $depth == 0 ) ||  ( $item->current_item_ancestor && $depth == 0 ) )
				$current_a .= ' current ';

			$attributes .= ' class="'. $current_a . '"';
			$item_output = $args->before;
			if ( $item->hide == "" ) {
				if ( $item->nolink == "" ) {
					$item_output .= '<a'. $attributes .'>';
				} else{
					$item_output .= '<h5>';
				}
				$item_output .= $args->link_before . ($item->icon ? '<i class="fa fa-' . str_replace('fa-', '', $item->icon) . '"></i>' : '') . apply_filters( 'the_title', $item->title, $item->ID );
				$item_output .= $args->link_after;
				if ($item->tip_label) {
					$item_style = '';
					$item_arrow_style = '';
					if ($item->tip_color) {
						$item_style .= 'color:'.$item->tip_color.';';
					}
					if ($item->tip_bg) {
						$item_style .= 'background:'.$item->tip_bg.';';
						$item_arrow_style .= 'color:'.$item->tip_bg.';';
					}
					$item_output .= '<span class="tip" style="'.esc_attr( $item_style ).'"><span class="tip-arrow" style="'.esc_attr( $item_arrow_style ).'"></span>'. esc_html( $item->tip_label ) .'</span>';
				}
				if ( $item->nolink == "" ) {
					$item_output .= '</a>';
				} else {
					$item_output .= '</h5>';
				}
			}
			if ($item->block)
				$item_output .= '<div class="menu-block menu-block-after">'.do_shortcode('[arexworks_static_block id="'.esc_attr($item->block).'"]').'</div>';
			$item_output .= $args->after;
			$args->popup_style = $popup_style;

			// build html
			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}

		function walk( $elements, $max_depth ) {
			$args = array_slice(func_get_args(), 2);
			$output = '';

			//invalid parameter or nothing to walk
			if ( $max_depth < -1 || empty( $elements ) ) {
				return $output;
			}

			$parent_field = $this->db_fields['parent'];

			// flat display
			if ( -1 == $max_depth ) {
				$empty_array = array();
				foreach ( $elements as $e )
					$this->display_element( $e, $empty_array, 1, 0, $args, $output );
				return $output;
			}

			/*
			 * Need to display in hierarchical order.
			 * Separate elements into two buckets: top level and children elements.
			 * Children_elements is two dimensional array, eg.
			 * Children_elements[10][] contains all sub-elements whose parent is 10.
			 */
			$top_level_elements = array();
			$children_elements  = array();
			foreach ( $elements as $e) {
				if ( 0 == $e->$parent_field )
					$top_level_elements[] = $e;
				else
					$children_elements[ $e->$parent_field ][] = $e;
			}

			/*
			 * When none of the elements is top level.
			 * Assume the first one must be root of the sub elements.
			 */
			if ( empty($top_level_elements) ) {

				$first = array_slice( $elements, 0, 1 );
				$root = $first[0];

				$top_level_elements = array();
				$children_elements  = array();
				foreach ( $elements as $e) {
					if ( $root->$parent_field == $e->$parent_field )
						$top_level_elements[] = $e;
					else
						$children_elements[ $e->$parent_field ][] = $e;
				}
			}
			$this->count_lv_0 = count($top_level_elements);
			foreach ( $top_level_elements as $e )
			{
				$this->display_element( $e, $children_elements, $max_depth, 0, $args, $output );
			}

			/*
			 * If we are displaying all levels, and remaining children_elements is not empty,
			 * then we got orphans, which should be displayed regardless.
			 */
			if ( ( $max_depth == 0 ) && count( $children_elements ) > 0 ) {
				$empty_array = array();
				foreach ( $children_elements as $orphans ){
					foreach( $orphans as $op ){
						$this->display_element( $op, $empty_array, 1, 0, $args, $output );
					}
				}
			}

			return $output;
		}
	}
}

if ( !class_exists( 'Arexworks_Walker_Sidebar_Nav_Menu' ) ) {
	class Arexworks_Walker_Sidebar_Nav_Menu extends Walker_Nav_Menu {

		// add classes to ul sub menus
		function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {
			$id_field = $this->db_fields['id'];
			if ( is_object( $args[0] ) ) {
				$args[0]->has_children = ! empty( $children_elements[$element->$id_field] );
			}
			return parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
		}

		// add popup class to ul sub-menus
		function start_lvl( &$output, $depth = 0, $args = array() ) {
			$indent = str_repeat("\t", $depth);
			$out_div = '';
			if ( $depth == 0 ) {
				$out_div = '<span class="arrow"></span><div class="popup"><div class="inner" style="'.esc_attr($args->popup_style).'">';
			} else {
				$out_div = '';
			}
			$output .= "\n$indent$out_div<ul class=\"sub-menu\">\n";
		}

		function end_lvl( &$output, $depth = 0, $args = array() ) {
			$indent = str_repeat("\t", $depth);
			if ( $depth == 0 ) {
				$out_div = '</div></div>';
			} else {
				$out_div = '';
			}
			$output .= "$indent</ul>$out_div\n";
		}

		// add main/sub classes to li's and links
		function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
			global $wp_query;

			$sub = "";
			$indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent
			if ( $depth == 0 && $args->has_children )
				$sub = ' has-sub';

			if ( $depth == 1 && $args->has_children )
				$sub = ' sub';

			$active = "";

			// depth dependent classes
			if ( $item->current || $item->current_item_ancestor || $item->current_item_parent )
				$active = 'active';

			// passed classes
			$classes = empty( $item->classes ) ? array() : (array)$item->classes;

			$class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ) );

			// menu type, type, column class, popup style
			$menu_type = "";
			$popup_pos = "";
			$popup_cols = "";
			$popup_style = "";
			$cols = 1;

			if ($depth == 0) {
				if ($item->popup_type == "wide") {
					$menu_type = " wide";
					if ($item->popup_cols == "")
						$item->popup_cols = 'col-4';
					$popup_cols = " ". $item->popup_cols;

					$popup_bg_image = '';
					if($item->popup_bg_image){
						$arr_need_replace = array('http://','https://');
						$arr_replace = array('//','//');
						$mm_bg_image = str_replace($arr_need_replace,$arr_replace,$item->popup_bg_image);
						$popup_bg_image = 'background-image:url('.esc_url($mm_bg_image).');';
					}
					$popup_bg_pos = $item->popup_bg_pos ? ';background-position:'.$item->popup_bg_pos.';' : '';
					$popup_bg_repeat = $item->popup_bg_repeat ? ';background-repeat:'.$item->popup_bg_repeat.';' : '';
					$popup_bg_size = $item->popup_bg_size ? ';background-size:'.$item->popup_bg_size.';' : '';
					$popup_max_width = $item->popup_max_width ? ';max-width:'.(int)$item->popup_max_width.'px;' : '';

					$popup_style = str_replace('"', '\'', $item->popup_style . $popup_bg_image . $popup_bg_pos . $popup_bg_repeat . $popup_bg_size . $popup_max_width);
				} else {
					$menu_type = " narrow";
				}
				$popup_pos = " ". $item->popup_pos;
			}

			// build html
			if ($depth == 1) {
				$sub_popup_style = '';
				if ($item->popup_style || $item->popup_bg_image || $item->popup_bg_pos || $item->popup_bg_repeat || $item->popup_bg_size) {
					$sub_popup_image = '';
					if($item->popup_bg_image){
						$arr_need_replace = array('http://','https://');
						$arr_replace = array('//','//');
						$mm_bg_image = str_replace($arr_need_replace,$arr_replace,$item->popup_bg_image);
						$sub_popup_image = 'background-image:url('.esc_url($mm_bg_image).');';
					}

					$sub_popup_pos = $item->popup_bg_pos ? ';background-position:'.$item->popup_bg_pos.';' : '';;
					$sub_popup_repeat = $item->popup_bg_repeat ? ';background-repeat:'.$item->popup_bg_repeat.';' : '';;
					$sub_popup_size = $item->popup_bg_size ? ';background-size:'.$item->popup_bg_size.';' : '';;
					$sub_popup_style = ' style="'.esc_attr(str_replace('"', '\'', $item->popup_style).$sub_popup_image.$sub_popup_pos.$sub_popup_repeat.$sub_popup_size).'"';
				}
				if ($item->cols > 1)
					$cols = (int)$item->cols;
				if ($item->block)
					$class_names .= ' menu-block-item ';
				$output .= $indent . '<li id="nav-menu-item-'. $item->ID . '" class="' . esc_attr( $class_names . ' ' . $active . $sub . $menu_type . $popup_pos . $popup_cols ) . '" data-cols="'.$cols.'"'.$sub_popup_style.'>';
			} else {
				$output .= $indent . '<li id="nav-menu-item-'. $item->ID . '" class="' . esc_attr( $class_names . ' ' . $active . $sub . $menu_type . $popup_pos . $popup_cols ) . '">';
			}

			$current_a = "";

			// link attributes
			$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
			$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
			$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
			$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

			if ( ( $item->current && $depth == 0 ) ||  ( $item->current_item_ancestor && $depth == 0 ) )
				$current_a .= ' current ';

			$attributes .= ' class="'. $current_a . '"';
			$item_output = $args->before;
			if ( $item->hide == "" ) {
				if ( $item->nolink == "" ) {
					$item_output .= '<a'. $attributes .'>';
				} else{
					$item_output .= '<h5>';
				}
				$item_output .= $args->link_before . ($item->icon ? '<i class="fa fa-' . str_replace('fa-', '', $item->icon) . '"></i>' : '') . apply_filters( 'the_title', $item->title, $item->ID );
				$item_output .= $args->link_after;
				if ($item->tip_label) {
					$item_style = '';
					$item_arrow_style = '';
					if ($item->tip_color) {
						$item_style .= 'color:'.$item->tip_color.';';
					}
					if ($item->tip_bg) {
						$item_style .= 'background:'.$item->tip_bg.';';
						$item_arrow_style .= 'color:'.$item->tip_bg.';';
					}
					$item_output .= '<span class="tip" style="'.esc_attr( $item_style ).'"><span class="tip-arrow" style="'. esc_attr( $item_arrow_style ) .'"></span>'. esc_html( $item->tip_label ) .'</span>';
				}
				if ( $item->nolink == "" ) {
					$item_output .= '</a>';
				} else {
					$item_output .= '</h5>';
				}
			}
			if ($item->block)
				$item_output .= '<div class="menu-block menu-block-after">'.do_shortcode('[arexworks_static_block name="'. esc_attr( $item->block ) .'"]').'</div>';
			$item_output .= $args->after;
			$args->popup_style = $popup_style;

			// build html
			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}

	}
}

if ( !class_exists( 'Arexworks_Walker_Accordion_Nav_Menu' ) ) {
	class Arexworks_Walker_Accordion_Nav_Menu extends Walker_Nav_Menu {

		// add classes to ul sub menus
		function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {
			$id_field = $this->db_fields['id'];
			if ( is_object( $args[0] ) ) {
				$args[0]->has_children = ! empty( $children_elements[$element->$id_field] );
			}
			return parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
		}

		// add main/sub classes to li's and links
		function start_lvl( &$output, $depth = 0, $args = array() ) {
			$indent = str_repeat("\t", $depth);
			$output .= "\n$indent<span class=\"arrow\"></span><ul class=\"sub-menu\">\n";
		}

		function end_lvl( &$output, $depth = 0, $args = array() ) {
			$indent = str_repeat("\t", $depth);
			$output .= "$indent</ul>\n";
		}

		// add main/sub classes to li's and links
		function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

			$item_output = '';
			if ( $item->mobile_hide == "" ) {

			$sub = "";
			$indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent
			if ( ( $depth >= 0 && $args->has_children ) || ( $depth >= 0 && $item->recentpost != "" ) )
				$sub = ' has-sub';

			$active = "";

			if ( $item->current || $item->current_item_ancestor || $item->current_item_parent )
				$active = 'active';

			// passed classes
			$classes = empty( $item->classes ) ? array() : (array) $item->classes;

			$class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ) );

			// build html
			$output .= $indent . '<li id="accordion-menu-item-'. $item->ID . '" class="' . esc_attr( $class_names . ' ' . $active . $sub  ) .'">';

			$current_a = "";

			// link attributes
			$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
			$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
			$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
			$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
			if ( ( $item->current && $depth == 0 ) || ( $item->current_item_ancestor && $depth == 0 ) )
				$current_a .= ' current ';

			$attributes .= ' class="'. $current_a . '"';
			$item_output = $args->before;


				if ( $item->nolink == "" ) {
					$item_output .= '<a'. $attributes .'>';
				} else {
					$item_output .= '<h5>';
				}
				$item_output .= $args->link_before . ($item->icon ? '<i class="fa fa-' . str_replace('fa-', '', $item->icon) . '"></i>' : '') . apply_filters( 'the_title', $item->title, $item->ID );
				$item_output .= $args->link_after;
				if ($item->tip_label) {
					$item_style = '';
					$item_arrow_style = '';
					if ($item->tip_color) {
						$item_style .= 'color:'.$item->tip_color.';';
					}
					if ($item->tip_bg) {
						$item_style .= 'background:'.$item->tip_bg.';';
						$item_arrow_style .= 'color:'.$item->tip_bg.';';
					}
					$item_output .= '<span class="tip" style="'.esc_attr( $item_style ).'"><span class="tip-arrow" style="'.esc_attr($item_arrow_style).'"></span>'.esc_html($item->tip_label).'</span>';
				}
				if ( $item->nolink == "" ) {
					$item_output .= '</a>';
				} else {
					$item_output .= '</h5>';
				}
				$item_output .= $args->after;
			}


			// build html
			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}

	}
}