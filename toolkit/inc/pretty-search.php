<?php
/**
 * Pretty search.
 *
 * @package Site_Toolkit
 */

/**
 * Pretty permalink for search.
 *
 * @return void.
 */
function stk_search_url_rewrite() {
	global $wp_rewrite;
	if ( ! isset( $wp_rewrite ) || ! is_object( $wp_rewrite ) || ! $wp_rewrite->get_search_permastruct() ) {
		return;
	}

	$search_base = $wp_rewrite->search_base;
	$needle      = '/' . $search_base . '/';
	$uri         = isset( $_SERVER['REQUEST_URI'] ) ? esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '';

	if ( is_search() && strpos( $uri, $needle ) === false && strpos( $uri, '&' ) === false ) {
		wp_redirect( get_search_link() );
		exit();
	}

}
