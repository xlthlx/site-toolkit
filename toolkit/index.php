<?php
/**
 * Options.
 *
 * @package Site_Toolkit
 */

/**
 * Sets the correct associations between functions and options.
 */
require_once 'functions.php';
global $stk_general, $stk_dashboard, $stk_seo, $stk_archives, $stk_listing, $stk_login, $stk_uploads;

if ( isset( $stk_general ) ) {
	foreach ( $stk_general as $key => $value ) {
		// Radio fields yes/no.
		if ( 'yes' === $value ) {
			switch ( $key ) {
				case 'emoji_support':
					add_action( 'init', 'stk_disable_emoji_support' );
					break;
				case 'rss_feeds':
					if ( ! is_admin() ) {
						add_action( 'init', 'stk_disable_rss_feed' );
					}
					break;
				case 'rest_api':
					if ( ! is_admin() ) {
						add_action( 'init', 'stk_disable_rest_api' );
					}
					break;
				case 'links':
					if ( ! is_admin() ) {
						 add_action( 'init', 'stk_disable_links' );
					}
					break;
				case 'wp_version':
					if ( ! is_admin() ) {
						 add_action( 'init', 'stk_remove_wordpress_version' );
					}
					break;
				case 'versions':
					if ( ! is_admin() ) {
						 add_filter( 'style_loader_src', 'stk_change_version_from_style_js', 9999 );
						 add_filter( 'script_loader_src', 'stk_change_version_from_style_js', 9999 );
					}
					break;
			}
		}
	}
}

/**
 * Dashboard options
 */
if ( isset( $stk_dashboard ) ) {
	foreach ( $stk_dashboard as $key => $value ) {
		// Radio fields yes/no.
		if ( ( 'yes' === $value ) && ( 'dashboard_widgets' === $key ) ) {
			add_action( 'wp_dashboard_setup', 'stk_disable_dashboard_widgets', 999 );
		}
		if ( $value && ( 'custom_widgets_title' === $key ) ) {
			add_action( 'wp_dashboard_setup', 'stk_add_dashboard_widgets' );
		}
	}
}

/**
 * SEO options
 */
if ( isset( $stk_seo ) ) {
	foreach ( $stk_seo as $key => $value ) {
		// Radio fields yes/no.
		if ( 'yes' === $value ) {
			switch ( $key ) {
				case 'pretty_search':
					add_action( 'template_redirect', 'stk_search_url_rewrite' );
					break;
				case 'header':
					add_action( 'wp_headers', 'stk_last_mod_header' );
					break;
				case 'images_alt':
					   add_filter( 'the_content', 'stk_add_image_alt', 9999 );
					   add_filter( 'wp_get_attachment_image_attributes', 'stk_change_image_attr', 20, 2 );
					break;
			}
		}
	}
}

/**
 * Archive options
 */
if ( isset( $stk_archives ) ) {
	foreach ( $stk_archives as $key => $value ) {
		// Radio fields yes/no.
		if ( 'yes' === $value ) {
			switch ( $key ) {
				case 'remove_title':
					add_filter( 'get_the_archive_title', 'stk_remove_archive_title_prefix' );
					break;
				case 'redirect_author':
					   add_action( 'template_redirect', 'stk_redirect_archives_author' );
					break;
				case 'redirect_date':
					add_action( 'template_redirect', 'stk_redirect_archives_date' );
					break;
				case 'redirect_tag':
					add_action( 'template_redirect', 'stk_redirect_archives_tag' );
					break;
			}
		}
	}
}

/**
 * Listing options
 */
if ( isset( $stk_listing ) ) {
	foreach ( $stk_listing as $key => $value ) {
		// Radio fields yes/no.
		if ( 'yes' === $value ) {
			switch ( $key ) {
				case 'posts_columns':
					if ( is_admin() ) {
						add_filter( 'manage_posts_columns', 'stk_posts_columns', 999999 );
						add_action( 'manage_posts_custom_column', 'stk_posts_custom_columns', 999999, 2 );
					}
					break;
				case 'pages_columns':
					if ( is_admin() ) {
						add_filter( 'manage_pages_columns', 'stk_page_column_views', 999999 );
						add_action( 'manage_pages_custom_column', 'stk_page_custom_column_views', 999999, 2 );
					}
					break;
			}
		}
	}
}

/**
 * Login options
 */
if ( isset( $stk_login ) ) {
	foreach ( $stk_login as $key => $value ) {
		if ( ( '' !== $value ) && ( 'stk_login' === $key ) ) {
			add_action( 'plugins_loaded', 'stk_plugins_loaded', 1 );
			add_action( 'wp_loaded', 'stk_wp_loaded' );

			add_filter( 'site_url', 'stk_site_url', 10, 4 );
			add_filter( 'wp_redirect', 'stk_wp_redirect' );

			add_filter( 'site_option_welcome_email', 'stk_welcome_email' );
			add_filter( 'body_class', 'stk_admin_bar_body_class', 10, 2 );

			remove_action( 'template_redirect', 'wp_redirect_admin_locations', 1000 );
		}
	}
}

/**
 * Uploads options
 */
if ( isset( $stk_uploads ) ) {
	foreach ( $stk_uploads as $key => $value ) {
		// Radio fields yes/no.
		if ( ( 'yes' === $value ) && ( 'clean_names' === $key ) && is_admin() ) {
			add_action( 'wp_handle_upload_prefilter', 'stk_upload_filter' );
			add_action( 'add_attachment', 'stk_update_attachment_title' );
		}
	}
}
