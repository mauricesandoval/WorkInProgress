<?php
// new post meta data callback
function voisen_post_meta_box_callback( $post ) {
	wp_nonce_field( 'voisen_meta_box', 'voisen_meta_box_nonce' );
	$value = get_post_meta( $post->ID, 'voisen_featured_post_value', true );
	echo '<label for="voisen_post_intro">';
	esc_html_e( 'This content will be used to replace the featured image, use shortcode here', 'voisen' );
	echo '</label><br />';
	wp_editor( $value, 'voisen_post_intro', $settings = array() );
}
// register new meta box
add_action( 'add_meta_boxes', 'voisen_add_post_meta_box' );
function voisen_add_post_meta_box(){
	$screens = array( 'post' );
	foreach ( $screens as $screen ) {
		add_meta_box(
			'voisen_post_intro_section',
			esc_html__( 'Post featured content', 'voisen' ),
			'voisen_post_meta_box_callback',
			$screen
		);
	}
	add_meta_box(
		'voisen_page_config_section',
		esc_html__( 'Page config', 'voisen' ),
		'voisen_page_meta_box_callback',
		'page',
		'normal',
		'high'
	);
}
// new page meta data callback
function voisen_page_meta_box_callback( $post ) {
	wp_nonce_field( 'voisen_meta_box', 'voisen_meta_box_nonce' );
	$header_val = get_post_meta( $post->ID, 'voisen_header_page', true );
	$layout_val = get_post_meta( $post->ID, 'voisen_layout_page', true );
	$logo_val = get_post_meta( $post->ID, 'voisen_logo_page', true );
	echo '<div class="bootstrap">';
		echo '<div class="option row">';
			echo '<div class="option_label col-md-3 col-sm-12"><label for="custom_header_option">' . esc_html__('Custom header:', 'voisen') . '</label></div>';
			echo '<div class="option_field col-md-9 col-sm-12"><select id="custom_header_option" name="voisen_header_page">';
			echo '<option value="first"'. (($header_val == 'first') ? ' selected="selected"' : '') .'>'. esc_html__('Header first (Default)', 'voisen') .'</option>';
			echo '<option value="second"'. (($header_val == 'second') ? ' selected="selected"' : '') .'>'. esc_html__('Header second', 'voisen') .'</option>';
			echo '<option value="third"'. (($header_val == 'third') ? ' selected="selected"' : '') .'>'. esc_html__('Header third', 'voisen') .'</option>';
			echo '</select></div>';
		echo '</div>';
		
		echo '<div class="option row">';
			echo '<div class="option_label col-md-3 col-sm-12"><label for="custom_layout_option">' . esc_html__('Custom layout:', 'voisen') . '</label></div>';
			echo '<div class="option_field col-md-9 col-sm-12"><select id="custom_layout_option" name="voisen_layout_page">';
			echo '<option value="full"'. (($layout_val == 'full') ? ' selected="selected"' : '') .'>'. esc_html__('Full (Default)', 'voisen') .'</option>';
			echo '<option value="box"'. (($layout_val == 'box') ? ' selected="selected"' : '') .'>'. esc_html__('Box', 'voisen') .'</option>';
			echo '</select></div>';
		echo '</div>';
		
		echo '<div class="option row">';
			echo '<div class="option_label col-md-3 col-sm-12"><label for="custom_logo_option">' . esc_html__('Custom logo:', 'voisen') . '</label></div>';
			echo '<div class="option_field col-md-9 col-sm-12"><input type="hidden" name="voisen_logo_page" id="custom_logo_option" value="'. esc_attr($logo_val) . '" />';
			echo '<div class="wp-media-buttons"><button id="voisen_media_button" class="button" type="button"/>'. esc_html__('Upload Logo', 'voisen') .'</button><button id="voisen_remove_media_button" class="button" type="button">'. esc_html__('Remove', 'voisen') .'</button></div>';
			echo '<div id="voisen_page_selected_media">'. (($logo_val) ? '<img width="150" src="'. esc_url($logo_val) .'" />':'') .'</div>';
			echo '</div>';
		echo '</div>';
	echo '</div>';
	?>
	<script type = "text/javascript">
        // Uploading files
        var file_frame;
		jQuery(document).on('click', '#voisen_remove_media_button', function(e){
			e.preventDefault();
			jQuery('#custom_logo_option').val('');
			jQuery('#voisen_page_selected_media').html('');
		});
		jQuery(document).on('click', '#voisen_media_button', function(e){
			
			// If the media frame already exists, reopen it.
			if (file_frame){
				file_frame.open();
				return;
			}
			// Create the media frame.
			file_frame = wp.media.frames.file_frame = wp.media({
				title: jQuery(this).data('uploader_title'),
				button: {
					text: jQuery(this).data('uploader_button_text'),
				},
				multiple: false // Set to true to allow multiple files to be selected
			});
			// When a file is selected, run a callback.
			file_frame.on('select', function(){
				// We set multiple to false so only get one image from the uploader
				attachment = file_frame.state().get('selection').first().toJSON();
				var url = attachment.url;
				var field = document.getElementById("custom_logo_option");
				field.value = url; //set which variable you want the field to have
				jQuery('#voisen_page_selected_media').html('<img width="150" src="'+ url +'" />');
				file_frame.close();
			});
			// Finally, open the modal
			file_frame.open();
			e.preventDefault();
		});
    </script>
<?php
	function voisen_admin_scripts() {
        wp_enqueue_script('media-upload');
        wp_enqueue_script('thickbox');
    }
    function voisen_admin_styles() {
        wp_enqueue_style('thickbox');
    }
    add_action('admin_print_scripts', 'voisen_admin_scripts');
    add_action('admin_print_styles', 'voisen_admin_styles');
}
// save new meta box value
add_action( 'save_post', 'voisen_save_meta_box_data' );
function voisen_save_meta_box_data( $post_id ) {
	// Check if our nonce is set.
	if ( ! isset( $_POST['voisen_meta_box_nonce'] ) ) {
		return;
	}
	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['voisen_meta_box_nonce'], 'voisen_meta_box' ) ) {
		return;
	}
	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Check the user's permissions.
	if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return;
		}
	} else {
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
	}
	/* OK, it's safe for us to save the data now. */
	
	// Make sure that it is set.
	if ( isset( $_POST['voisen_post_intro'] ) ) {
		// Sanitize user input.
		$my_data = sanitize_text_field( $_POST['voisen_post_intro'] );
		// Update the meta field in the database.
		update_post_meta( $post_id, 'voisen_featured_post_value', $my_data );
	}
	if ( isset( $_POST['voisen_header_page'] ) ) {
		// Sanitize user input.
		$my_data = sanitize_text_field( $_POST['voisen_header_page'] );
		// Update the meta field in the database.
		update_post_meta( $post_id, 'voisen_header_page', $my_data );
	}
	if ( isset( $_POST['voisen_footer_page'] ) ) {
		// Sanitize user input.
		$my_data = sanitize_text_field( $_POST['voisen_footer_page'] );
		// Update the meta field in the database.
		update_post_meta( $post_id, 'voisen_footer_page', $my_data );
	}
	if ( isset( $_POST['voisen_layout_page'] ) ) {
		// Sanitize user input.
		$my_data = sanitize_text_field( $_POST['voisen_layout_page'] );
		// Update the meta field in the database.
		update_post_meta( $post_id, 'voisen_layout_page', $my_data );
	}
	if ( isset( $_POST['voisen_logo_page'] ) ) {
		// Sanitize user input.
		$my_data = sanitize_text_field( $_POST['voisen_logo_page'] );
		// Update the meta field in the database.
		update_post_meta( $post_id, 'voisen_logo_page', $my_data );
	}
	
	return;
}