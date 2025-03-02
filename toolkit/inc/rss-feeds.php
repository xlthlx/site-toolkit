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
}
