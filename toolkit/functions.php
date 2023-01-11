<?php
/**
 * Toolkit.
 *
 * @package Site_Toolkit
 */

/**
 * Includes all files from inc directory.
 */
foreach ( glob( dirname( __FILE__ ) . '/inc/*.php' ) as $filename ) {
	include_once $filename;
}
