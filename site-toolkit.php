<?php
/**
 * Site Toolkit
 *
 * @category  Plugin
 * @package   Site_Toolkit
 * @author    xlthlx <xlthlx@gmail.com>
 * @copyright 2022 xlthlx (email: xlthlx at gmail.com)
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL 3
 * @link      https://wordpress.org/plugins/site-toolkit/
 *
 * @wordpress-plugin
 * Plugin Name:       Site Toolkit
 * Plugin URI:        https://wordpress.org/plugins/site-toolkit/
 * Description:       Sets of tools for WordPress admin and frontend.
 * Version:           1.1.0
 * Requires at least: 5.9
 * Requires PHP:      7.4
 * Author:            xlthlx
 * Author URI:        https://profiles.wordpress.org/xlthlx/
 * License:           GPLv3+
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:       site-toolkit
 * Domain Path:       /languages
 *
 * Site Toolkit is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * Site Toolkit is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Site Toolkit. If not, see https://www.gnu.org/licenses/gpl-3.0.html.
 */

/**
 * Sets all the default values for the plugin options.
 */
$defaults = array(
	'stk_general'   => array(
		'emoji_support' => 'yes',
		'rss_feeds'     => 'no',
		'rest_api'      => 'yes',
		'links'         => 'yes',
		'wp_version'    => 'yes',
		'versions'      => 'yes',
	),
	'stk_dashboard' => array(
		'dashboard_widgets'      => 'no',
		'custom_widgets_context' => 'normal',
	),
	'stk_seo'       => array(
		'pretty_search' => 'yes',
		'header'        => 'yes',
		'images_alt'    => 'yes',
	),
	'stk_archives'  => array(
		'remove_title'    => 'yes',
		'redirect_author' => 'no',
		'redirect_date'   => 'no',
		'redirect_tag'    => 'no',
	),
	'stk_listing'   => array(
		'posts_columns' => 'yes',
		'pages_columns' => 'yes',
	),
	'stk_login'     => array(
		'stk_login' => '',
	),
	'stk_uploads'   => array(
		'clean_names' => 'yes',
	),
);

$stk_general   = ( ! get_option( 'stk_general' ) ) ? $defaults['stk_general'] : get_option( 'stk_general' );
$stk_dashboard = ( ! get_option( 'stk_dashboard' ) ) ? $defaults['stk_dashboard'] : get_option( 'stk_dashboard' );
$stk_seo       = ( ! get_option( 'stk_seo' ) ) ? $defaults['stk_seo'] : get_option( 'stk_seo' );
$stk_archives  = ( ! get_option( 'stk_archives' ) ) ? $defaults['stk_archives'] : get_option( 'stk_archives' );
$stk_listing   = ( ! get_option( 'stk_listing' ) ) ? $defaults['stk_listing'] : get_option( 'stk_listing' );
$stk_login     = ( ! get_option( 'stk_login' ) ) ? $defaults['stk_login'] : get_option( 'stk_login' );
$stk_uploads   = ( ! get_option( 'stk_uploads' ) ) ? $defaults['stk_uploads'] : get_option( 'stk_uploads' );

if ( is_admin() ) {
	include_once 'toolkit/admin/index.php';
}
require_once 'toolkit/index.php';
