<?php
/**
 * Remove emoji support.
 *
 * @package Site_Toolkit
 */

/**
 * Remove emoji CDN hostname from DNS prefetch hints.
 *
 * @param array  $urls          URLs to print for resource hints.
 * @param string $relation_type The relation type the URLs are printed for.
 *
 * @return array Difference between the two arrays.
 */
function stk_disable_emojis_remove_dns_prefetch( $urls, $relation_type ) {
	if ( 'dns-prefetch' === $relation_type ) {
		$emoji_svg_url_bit = 'https://s.w.org/images/core/emoji/';
		foreach ( $urls as $key => $url ) {
			if ( strpos( $url, $emoji_svg_url_bit ) !== false ) {
				unset( $urls[ $key ] );
			}
		}
	}

	return $urls;
}

/**
 * Remove Emoji support
 */
function stk_disable_emoji_support() {

	$has_emoji_styles = has_action( 'wp_print_styles', 'print_emoji_styles' );
	if ( $has_emoji_styles ) {
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
	}

	remove_action( 'wp_print_styles', 'wp_enqueue_emoji_styles' );
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );

	add_filter( 'wp_resource_hints', 'stk_disable_emojis_remove_dns_prefetch', 10, 2 );
}
