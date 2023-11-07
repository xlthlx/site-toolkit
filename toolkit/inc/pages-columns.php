<?php
/**
 * Page columns.
 *
 * @package Site_Toolkit
 */

/**
 * Remove comments column and adds Template column for pages
 *
 * @param array $columns The pages columns.
 *
 * @return array $columns
 */
function stk_page_column_views( $columns ) {
	 unset( $columns['date'] );

	return array_merge(
		$columns,
		array(
			'page-layout' => __( 'Template', 'site-toolkit' ),
			'date'        => __( 'Date', 'site-toolkit' ),
		)
	);

}

/**
 * Sets content for Template column and date
 *
 * @param string $column_name The column name.
 * @param int    $id          The post ID.
 */
function stk_page_custom_column_views( $column_name, $id ) {
	if ( 'page-layout' === $column_name ) {
		$set_template = get_post_meta(
			get_the_ID(),
			'_wp_page_template',
			true
		);
		if ( ( 'default' === $set_template ) || ( '' === $set_template ) ) {
			$set_template = 'Default';
		}
		$templates = wp_get_theme()->get_page_templates();
		foreach ( $templates as $key => $value ) :
			if ( ( $set_template === $key ) && ( '' === $set_template ) ) {
				$set_template = $value;
			}
		endforeach;

		echo esc_html( $set_template );
	}
}
