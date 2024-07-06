<?php
/**
 * Custom login.
 *
 * @package Site_Toolkit
 */

add_action( 'wp_head', 'ob_start', 1, 0 );
$wp_login_php = false;
global $stk_login;

$stk_url_login = isset( $stk_login['stk_login'] ) ? $stk_login['stk_login'] : '';

/**
 * Check if an url uses trailing slashes.
 *
 * @return bool
 */
function stk_use_trailing_slashes() {
	return '/' === substr( get_option( 'permalink_structure' ), -1, 1 );
}

/**
 * Adds trailing slashes to url.
 *
 * @param string $string The url.
 *
 * @return string
 */
function stk_user_trailingslashit( $string ) {
	return stk_use_trailing_slashes() ? trailingslashit( $string ) : untrailingslashit( $string );
}

/**
 * Check if the page is a login page.
 *
 * @return void
 */
function stk_plugins_loaded() {
	global $pagenow,$stk_url_login,$wp_login_php;

	$request = isset( $_SERVER['REQUEST_URI'] ) ? wp_parse_url( esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ) ) : '';

	if ( ! is_admin() && ( strpos( esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ), 'wp-login.php' ) !== false || ( isset( $request['path'] ) && untrailingslashit( $request['path'] ) === site_url( 'wp-login', 'relative' ) ) ) ) {
		$wp_login_php           = true;
		$_SERVER['REQUEST_URI'] = stk_user_trailingslashit(
			'/' . str_repeat(
				'-/',
				10
			)
		);
     // @codingStandardsIgnoreStart
     $pagenow = 'index.php';

	} elseif ( ( ! get_option( 'permalink_structure' ) && isset( $_GET['stk_login'] ) && empty( $_GET['stk_login'] ) ) || ( isset( $request['path'] ) && untrailingslashit( $request['path'] ) === home_url( $stk_url_login, 'relative' ) ) ) {

     $pagenow = 'wp-login.php';
     // @codingStandardsIgnoreEnd
	}
}

/**
 * Redirects to 404 the wp-admin folder if user is not logged in.
 *
 * @return void
 */
function stk_wp_loaded() {
	global $pagenow,$wp_login_php;

	if ( ! defined( 'DOING_AJAX' ) && is_admin() && ! is_user_logged_in() ) {
		global $wp_query;
		$wp_query->set_404();
		status_header( 404 );
		get_template_part( 404 );
		exit();
	}

	$request = isset( $_SERVER['REQUEST_URI'] ) ? wp_parse_url( esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ) ) : '';

	if ( 'wp-login.php' === $pagenow && stk_user_trailingslashit( $request['path'] ) !== $request['path'] && get_option( 'permalink_structure' ) ) {
		wp_safe_redirect( stk_user_trailingslashit( stk_new_login_url() ) . ( ! empty( $_SERVER['QUERY_STRING'] ) ? '?' . esc_url_raw( wp_unslash( $_SERVER['QUERY_STRING'] ) ) : '' ) );
		die;
	}

	if ( $wp_login_php ) {
		$referer   = wp_get_referer();
		$i_referer = wp_parse_url( $referer );
		if ( isset( $i_referer['query'] ) && false !== strpos( $referer, 'wp-activate.php' ) ) {
			$referer = (array) $referer;
			parse_str( $referer['query'], $referer );

			$result = wpmu_activate_signup( $referer['key'] );
			if ( ! empty( $referer['key'] ) && is_wp_error( $result ) && ( $result->get_error_code() === 'already_active'
				|| $result->get_error_code() === 'blog_taken' )
			) {
				wp_safe_redirect( stk_new_login_url() . ( ! empty( $_SERVER['QUERY_STRING'] ) ? '?' . esc_url_raw( wp_unslash( $_SERVER['QUERY_STRING'] ) ) : '' ) );
				die;
			}
		}

		stk_wp_template_loader();
	} elseif ( 'wp-login.php' === $pagenow ) {

		include ABSPATH . 'wp-login.php';
		die;
	}
}

/**
 * Sets the correct template.
 *
 * @return void
 */
function stk_wp_template_loader() {
	global $pagenow;

	// @codingStandardsIgnoreStart
	$pagenow = 'index.php';
	// @codingStandardsIgnoreEnd

	if ( ! defined( 'WP_USE_THEMES' ) ) {
		define( 'WP_USE_THEMES', true );
	}

	wp();

	if ( isset( $_SERVER['REQUEST_URI'] ) && stk_user_trailingslashit( str_repeat( '-/', 10 ) ) === $_SERVER['REQUEST_URI'] ) {
		$_SERVER['REQUEST_URI'] = stk_user_trailingslashit( '/wp-login-php/' );
	}

	include_once ABSPATH . WPINC . '/template-loader.php';

	die;
}

/**
 * Filter login.
 *
 * @param string      $url    The complete site URL including scheme and path.
 * @param string|null $scheme Scheme to give the site URL context. Accepts 'http', 'https', 'login', 'login_post', 'admin', 'relative' or null.
 *
 * @return string
 */
function stk_filter_wp_login_php( $url, $scheme = null ) {
	if ( strpos( $url, 'wp-login.php' ) !== false ) {
		if ( is_ssl() ) {
			$scheme = 'https';
		}

		$args = explode( '?', $url );

		if ( isset( $args[1] ) ) {
			parse_str( $args[1], $args );
			$url = add_query_arg( $args, stk_new_login_url( $scheme ) );
		} else {
			$url = stk_new_login_url( $scheme );
		}
	}

	return $url;
}

/**
 * Filters the site URL.
 *
 * @param string      $url    The complete site URL including scheme and path.
 * @param string      $path   Path relative to the site URL. Blank string if no path is specified.
 * @param string|null $scheme Scheme to give the site URL context. Accepts 'http', 'https', 'login', 'login_post', 'admin', 'relative' or null.
 *
 * @return string
 */
function stk_site_url( $url, $path, $scheme ) {
	return stk_filter_wp_login_php( $url, $scheme );
}

/**
 * Redirects to the login.
 *
 * @param string $location The path or URL to redirect to.
 *
 * @return string
 */
function stk_wp_redirect( $location ) {
	return stk_filter_wp_login_php( $location );
}

/**
 * Sets new login url.
 *
 * @param string|null $scheme Scheme to give the site URL context.
 *
 * @return string
 */
function stk_new_login_url( $scheme = null ) {
	global $stk_url_login;
	if ( get_option( 'permalink_structure' ) ) {
		return stk_user_trailingslashit(
			home_url(
				'/',
				$scheme
			) . $stk_url_login
		);
	}

	// @codingStandardsIgnoreStart
	if ( isset( $_GET['stk_login'] ) ) {
		return home_url( '/', $scheme ) . '?' . esc_url_raw( wp_unslash( $_GET['stk_login'] ) );
	}
	// @codingStandardsIgnoreEnd
}

/**
 * Replace the url into the welcome email.
 *
 * @param string $value Value of network option.
 *
 * @return string|string[]
 */
function stk_welcome_email( $value ) {
	global $stk_url_login;

	return str_replace(
		'wp-login.php',
		trailingslashit( $stk_url_login ),
		$value
	);
}

/**
 * Removes the 'admin-bar' class from body.
 *
 * @param string[] $wp_classes    An array of body class names.
 * @param string[] $extra_classes An array of additional class names added to the body.
 *
 * @return array
 */
function stk_admin_bar_body_class( $wp_classes, $extra_classes ) {
	if ( ( is_404() ) && ( ! is_user_logged_in() ) ) {
		$wp_nobar_classes = array_diff( $wp_classes, array( 'admin-bar' ) );

		// Add the extra classes back untouched.
		return array_merge( $wp_nobar_classes, (array) $extra_classes );
	}

	return $wp_classes;
}
