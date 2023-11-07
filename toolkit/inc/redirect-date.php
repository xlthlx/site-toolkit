<?php
/**
 * Date redirect.
 *
 * @package Site_Toolkit
 */

/**
 * Redirect date page.
 *
 * @return void
 */
function stk_redirect_archives_date() {
	if ( is_date() ) {
		wp_redirect( home_url(), 301 );

		die();
	}
}
