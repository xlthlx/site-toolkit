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
		if ( isset( $post->post_parent ) && ( 0 !== $post->post_parent ) ) {
			wp_redirect( get_permalink( $post->post_parent ), 301 );
		} else {
			wp_redirect( home_url(), 301 );
		}
		exit;
	}
}
