<?php
/**
 * Remove header links.
 *
 * @package Site_Toolkit
 */

/**
 * Remove default style for comments widget.
 *
 * @return void
 */
function stk_remove_comments_style() {
	global $wp_widget_factory;

	$widget_recent_comments = isset( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'] ) ? $wp_widget_factory->widgets['WP_Widget_Recent_Comments'] : null;

	if ( ! empty( $widget_recent_comments ) ) {
		remove_action(
			'wp_head',
			array(
				$wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
				'recent_comments_style',
			)
		);
	}
}

/**
 * Remove RSD link, wlwmanifest Link, Shortlink, Previous/Next Post Link in the header.
 *
 * @return void
 */
function stk_disable_links() {
	remove_action( 'wp_head', 'adjacent_posts_rel_link' );
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head' );
	remove_action( 'template_redirect', 'wp_shortlink_header', 11 );
	remove_action( 'wp_head', 'rsd_link' );
	remove_action( 'wp_head', 'wlwmanifest_link' );
	remove_action( 'wp_head', 'wp_shortlink_wp_head' );
	remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );

	add_action( 'widgets_init', 'stk_remove_comments_style' );
}
