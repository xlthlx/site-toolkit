<?php
/**
 * Redirect author archive.
 *
 * @package Site_Toolkit
 */

/**
 * Redirect archives author.
 */
function stk_redirect_archives_author() {
	if ( is_author() ) {
		wp_redirect( home_url(), 301 );

		die();
	}
}
