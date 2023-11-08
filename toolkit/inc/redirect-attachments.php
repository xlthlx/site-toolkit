<?php
/**
 * Redirect attachment pages.
 *
 * @package Site_Toolkit
 */

/**
 * Attachment pages redirect.
 */
function stk_attachment_pages_redirect() {
	global $post;

	if ( is_attachment() ) {
		wp_redirect( wp_get_attachment_image_url( $post->ID, 'full' ), 301 );
		exit;
	}
}
