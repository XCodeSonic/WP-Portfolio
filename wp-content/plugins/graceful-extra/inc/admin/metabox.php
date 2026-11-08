<?php
/**
 * Graceful Extra Post & Page Display Metaboxes
 *
 * @package Graceful_Extra
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register post/page display settings meta box.
 */
function graceful_extra_add_meta_boxes() {
	$screens = array( 'post', 'page' );
	foreach ( $screens as $screen ) {
		add_meta_box(
			'graceful_extra_post_settings',
			esc_html__( 'Graceful Display Settings', 'graceful-extra' ),
			'graceful_extra_render_meta_box',
			$screen,
			'side',
			'default'
		);
	}
}
add_action( 'add_meta_boxes', 'graceful_extra_add_meta_boxes' );

/**
 * Render display settings meta box HTML.
 *
 * @param WP_Post $post Current post object.
 */
function graceful_extra_render_meta_box( $post ) {
	wp_nonce_field( 'graceful_extra_metabox_nonce_action', 'graceful_extra_metabox_nonce' );

	$hide_title      = get_post_meta( $post->ID, '_graceful_extra_hide_title', true );
	$disable_sidebar = get_post_meta( $post->ID, '_graceful_extra_disable_sidebar', true );
	?>
	<div class="graceful-extra-metabox-wrapper" style="padding: 6px 0;">
		<p style="margin: 0 0 12px;">
			<label for="graceful_extra_hide_title">
				<input type="checkbox" name="graceful_extra_hide_title" id="graceful_extra_hide_title" value="yes" <?php checked( $hide_title, 'yes' ); ?>>
				<strong><?php esc_html_e( 'Hide Title', 'graceful-extra' ); ?></strong>
			</label>
			<br>
			<span class="description" style="display:block; margin-left: 20px; font-size: 12px; color: #666;">
				<?php esc_html_e( 'Hides the main page/post heading on this single view.', 'graceful-extra' ); ?>
			</span>
		</p>

		<p style="margin: 0;">
			<label for="graceful_extra_disable_sidebar">
				<input type="checkbox" name="graceful_extra_disable_sidebar" id="graceful_extra_disable_sidebar" value="yes" <?php checked( $disable_sidebar, 'yes' ); ?>>
				<strong><?php esc_html_e( 'Disable Sidebar (Full Width)', 'graceful-extra' ); ?></strong>
			</label>
			<br>
			<span class="description" style="display:block; margin-left: 20px; font-size: 12px; color: #666;">
				<?php esc_html_e( 'Removes sidebars and expands content to full width.', 'graceful-extra' ); ?>
			</span>
		</p>
	</div>
	<?php
}

/**
 * Save meta box values.
 *
 * @param int $post_id Post ID.
 */
function graceful_extra_save_meta_boxes( $post_id ) {
	// Check nonce.
	if ( ! isset( $_POST['graceful_extra_metabox_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['graceful_extra_metabox_nonce'] ), 'graceful_extra_metabox_nonce_action' ) ) {
		return;
	}

	// Avoid autosave.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// Check permissions.
	if ( isset( $_POST['post_type'] ) && 'page' === $_POST['post_type'] ) {
		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return;
		}
	} else {
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
	}

	// Save Hide Title.
	if ( isset( $_POST['graceful_extra_hide_title'] ) && 'yes' === $_POST['graceful_extra_hide_title'] ) {
		update_post_meta( $post_id, '_graceful_extra_hide_title', 'yes' );
	} else {
		delete_post_meta( $post_id, '_graceful_extra_hide_title' );
	}

	// Save Disable Sidebar.
	if ( isset( $_POST['graceful_extra_disable_sidebar'] ) && 'yes' === $_POST['graceful_extra_disable_sidebar'] ) {
		update_post_meta( $post_id, '_graceful_extra_disable_sidebar', 'yes' );
	} else {
		delete_post_meta( $post_id, '_graceful_extra_disable_sidebar' );
	}
}
add_action( 'save_post', 'graceful_extra_save_meta_boxes' );
