<?php
/**
 * Post columns.
 *
 * @package Site_Toolkit
 */

/**
 * Adds Thumbnail column for posts
 *
 * @param array $columns The post columns.
 *
 * @return array
 */
function stk_posts_columns( $columns ) {
	 $post_type = get_post_type();
	if ( 'post' === $post_type ) {
		unset( $columns['date'] );

		$columns = array_merge(
			$columns,
			array(
				'thumbs' => __( 'Thumbnail', 'site-toolkit' ),
				'date'   => __( 'Date', 'site-toolkit' ),
			)
		);
	}

	return $columns;
}

/**
 * Sets content for Thumbnail column and date
 *
 * @param string $column_name The column name.
 * @param int    $id          The post ID.
 */
function stk_posts_custom_columns( $column_name, $id ) {
	if ( 'thumbs' === $column_name ) {
		echo get_the_post_thumbnail( $id, array( 100, 100 ) );
	}
}
