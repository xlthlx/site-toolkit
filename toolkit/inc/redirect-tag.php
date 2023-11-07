<?php
/**
 * Redirect author archive.
 *
 * @package Site_Toolkit
 */

/**
 * Redirect archives author.
 */
function stk_redirect_archives_tag() {
	if ( is_tag() ) {
		wp_redirect( home_url(), 301 );

		die();
	}
}
