<?php
/**
 * Remove WordPress version.
 *
 * @package Site_Toolkit
 */

/**
 * Starts buffer.
 *
 * @return void
 */
function stk_clean_meta_generators() {
	ob_start( 'stk_replace_meta_generators' );
}

/**
 * Replace <meta .* name="generator"> like tags which may contain a version.
 *
 * @param string $html Meta HTML.
 *
 * @return string
 */
function stk_replace_meta_generators( $html ) {
	$raw_html = $html;

	$pattern = '/<meta[^>]+name=["\']generator["\'][^>]+>/i';
	$html    = preg_replace( $pattern, '', $html );

	if ( empty( $html ) ) {
		return $raw_html;
	}

	return $html;
}

/**
 * Remove WordPress version.
 *
 * @return void
 */
function stk_remove_wordpress_version() {
	remove_action( 'wp_head', 'wp_generator' );
	add_filter( 'the_generator', '__return_empty_string' );

	add_action( 'wp_head', 'stk_clean_meta_generators', 100 );
}
