<?php
/**
 * Disable REST API.
 *
 * @package Site_Toolkit
 */

/**
 * Disable REST API only for non-logged-in users.
 *
 * @param WP_Error|null|true $error WP_Error if authentication error, null if authentication method wasn't used, true if authentication succeeded.
 *
 * @return WP_Error|null|true
 */
function stk_disable_wp_rest_api( $error ) {
	if ( ! is_user_logged_in() ) {
		$message = apply_filters(
			'disable_wp_rest_api_error',
			__( 'REST API restricted to authenticated users.', 'site-toolkit' )
		);

		return new WP_Error(
			'rest_login_required',
			$message,
			array( 'status' => rest_authorization_required_code() )
		);
	}

	return $error;
}

/**
 * Disable WordPress REST API.
 *
 * @return void
 */
function stk_disable_rest_api() {
	remove_action( 'template_redirect', 'rest_output_link_header', 11 );
	remove_action( 'wp_head', 'rest_output_link_wp_head' );
	remove_action( 'xmlrpc_rsd_apis', 'rest_output_rsd' );

	add_filter( 'rest_authentication_errors', 'stk_disable_wp_rest_api' );
}
