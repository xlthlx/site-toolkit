<?php
/**
 * Remove version and add file version to js/css.
 *
 * @package Site_Toolkit
 */

/**
 * Remove version and add file version to js/css.
 *
 * @param string $src Resource url.
 *
 * @return string
 */
function stk_change_version_from_style_js( $src ) {
	if ( ! is_admin() ) {

		$clean_src  = $src ? esc_url( remove_query_arg( 'ver', $src ) ) : false;
		$clean_path = str_replace( site_url(), ABSPATH, $clean_src );
		// Default to root.

		if ( strpos( $clean_src, 'wp-content/plugins' ) !== false ) {
			$clean_path = str_replace(
				site_url() . '/wp-content/plugins',
				ABSPATH . 'wp-content/plugins',
				$clean_src
			);
		}

		if ( strpos( $clean_src, 'wp-content/themes' ) !== false ) {
			$clean_path = str_replace(
				get_theme_root_uri(),
				get_theme_root(),
				$clean_src
			);
		}

		if ( strpos( $clean_src, 'wp-includes' ) !== false ) {
			$clean_path = str_replace(
				site_url() . '/wp-includes/',
				ABSPATH . 'wp-includes/',
				$clean_src
			);
		}

		if ( 0 === strpos( $clean_src, '/wp-includes/' ) ) {
			$clean_path = str_replace(
				'/wp-includes/',
				ABSPATH . 'wp-includes/',
				$clean_src
			);
		}

		$return = file_exists( $clean_path ) ? add_query_arg(
			'ver',
			filemtime( $clean_path ),
			$clean_src
		) : add_query_arg(
			'ver',
			'file-not-found',
			$clean_src
		);

		// External script/css.
		if ( strpos( $clean_src, site_url() ) === false ) {
			$return = preg_replace( '~(\?)ver=[^&]*~', '', $src );

			if ( false === preg_replace( '~(\?)ver=[^&]*~', '', $src ) ) {
				$return = preg_replace( '~&ver=[^&]*~', '', $src );
			}
		}

		// Internal wp-admin.
		if ( strpos( $clean_src, 'wp-admin' ) !== false ) {
			$return = $clean_src;
		}

		return $return;
	}

	return $src;

}
