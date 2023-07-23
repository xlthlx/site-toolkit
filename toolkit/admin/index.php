<?php
/**
 * Admin functions
 *
 * @package Site_Toolkit
 */

global $defaults;

/**
 * Init the option page class.
 */
require_once 'class-site-toolkit-options-page.php';
add_action( 'plugins_loaded', array( 'Site_Toolkit_Options_Page', 'stk_get_instance' ) );
add_action( 'admin_init', 'stk_plugin_settings' );
add_action( 'init', 'stk_language_settings' );


/**
 * Attach settings in WordPress Plugins list.
 */
function stk_plugin_settings() {
	 add_action( 'plugin_action_links', 'stk_add_plugin_settings', 10, 4 );
}

/**
 * Add settings link to plugin actions.
 *
 * @param array  $plugin_actions The plugin actions.
 * @param string $plugin_file The plugin file path.
 *
 * @return array
 */
function stk_add_plugin_settings( $plugin_actions, $plugin_file ) {
	$new_actions = array();

	if ( 'site-toolkit/site-toolkit.php' === $plugin_file ) {
		$new_actions['stk_settings'] = '<a href="' . esc_url( admin_url( 'admin.php?page=stk-settings' ) ) . '">' . __( 'Settings', 'site-toolkit' ) . '</a>';
	}

	return array_merge( $new_actions, $plugin_actions );
}

/**
 * Load localisation.
 *
 * @return void
 */
function stk_language_settings() {
	/**
	 * Load localizations if available.
	 */
	load_plugin_textdomain( 'site-toolkit', false, 'site-toolkit/languages' );
}
