<?php
/**
 * Remove archive title.
 *
 * @package Site_Toolkit
 */

/**
 * Remove archives title.
 *
 * @param string $title The title.
 *
 * @return string The modified title.
 */
function stk_remove_archive_title_prefix( $title ) {
	$single_cat_title = single_term_title( '', false );
	if ( is_category() || is_tag() || is_tax() || is_date() ) {
		return esc_html( $single_cat_title );
	}

	return $title;
}
