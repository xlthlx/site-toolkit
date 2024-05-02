<?php
/**
 * Custom dashboard widgets.
 *
 * @package Site_Toolkit
 */

/**
 * Add a widget to the dashboard.
 */
function stk_add_dashboard_widgets() {
	global $stk_dashboard;

	add_meta_box(
		sanitize_title( $stk_dashboard['custom_widgets_title'] ),
		$stk_dashboard['custom_widgets_title'],
		'stk_dashboard_widget_function',
		'dashboard',
		sanitize_key( $stk_dashboard['custom_widgets_context'] ),
		'high'
	);
}

/**
 * Function to output the contents of a Dashboard Widget.
 */
function stk_dashboard_widget_function() {
	global $stk_dashboard;
	echo esc_html( $stk_dashboard['custom_widgets_content'] );
}
