<?php
/**
 * Disable RSS Feed.
 *
 * @package Site_Toolkit
 */

/**
 * Disable RSS Feed.
 *
 * @return void
 */
function stk_disable_rss_feed() {
	remove_action( 'wp_head', 'feed_links', 2 );
	remove_action( 'wp_head', 'feed_links_extra', 3 );
	add_action( 'wp_head', 'ob_start', 1, 0 );
	add_action( 'wp_head', 'stk_remove_feed_comments', 3, 0 );
}

/**
 * Removes comments feed.
 *
 * @return void
 */
function stk_remove_feed_comments() {
	$pattern = '/.*' . preg_quote( esc_url( get_feed_link( 'comments_' . get_default_feed() ) ), '/' ) . '.*[\r\n]+/';
	echo esc_url_raw( preg_replace( $pattern, '', ob_get_clean() ) );
}
