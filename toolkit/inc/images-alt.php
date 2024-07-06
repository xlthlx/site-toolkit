<?php
/**
 * Sets images alt attribute.
 *
 * @package Site_Toolkit
 */

/**
 * Sets images alt attribute.
 *
 * @param string $content The post content.
 *
 * @return string The post content filtered.
 */
function stk_add_image_alt( $content ) {
	 global $post;

	if ( null === $post ) {
		return $content;
	}

	$old_content = $content;
	preg_match_all( '/<img[^>]+>/', $content, $images );

	if ( null !== $images ) {
		foreach ( $images[0] as $index => $value ) {
			if ( ! preg_match( '/alt=/', $value ) ) {
				global $wpdb;

				preg_match_all( '/<img [^>]*src="([^"]+)"[^>]*>/m', $value, $urls, PREG_SET_ORDER );

				// @codingStandardsIgnoreStart
				$attachment_id = $wpdb->get_col(
					$wpdb->prepare(
						"SELECT ID FROM $wpdb->posts WHERE guid=%s;",
						$urls[0][1]
					)
				);
				// @codingStandardsIgnoreEnd
				$attachment    = get_post( $attachment_id[0] );
				$alt           = get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true );
				$title         = $attachment->post_title;
				$post_title    = get_post_field( 'post_title', $post->ID );

				$new_img = str_replace( '<img', '<img alt="' . $post_title . '"', $images[0][ $index ] );

				if ( '' !== $alt ) {
					$new_img = str_replace(
						'<img',
						'<img alt="' . $alt . '"',
						$images[0][ $index ]
					);
				}

				if ( '' === $alt && '' !== $title ) {
					$new_img = str_replace(
						'<img',
						'<img alt="' . $title . '"',
						$images[0][ $index ]
					);
				}

				$content = str_replace( $images[0][ $index ], $new_img, $content );
			}
		}
	}

	if ( empty( $content ) ) {
		return $old_content;
	}

	return $content;
}

/**
 * Sets alt attribute for post thumbnails.
 *
 * @param array   $attr       Array of attribute values for the image markup, keyed by attribute name.
 * @param WP_Post $attachment Image attachment post.
 *
 * @return array The attributes filtered.
 */
function stk_change_image_attr( $attr, $attachment ) {
	$parent = get_post_field( 'post_parent', $attachment );
	$title  = get_post_field( 'post_title', $parent );

	if ( ! isset( $attr['alt'] ) || '' === $attr['alt'] ) {
		if ( isset( $attr['title'] ) && '' !== $attr['title'] ) {
			$attr['alt'] = $attr['title'];
		} else {
			$attr['alt'] = $title;
		}
	}

	return $attr;
}
