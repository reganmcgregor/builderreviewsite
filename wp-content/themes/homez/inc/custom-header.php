<?php
/**
 * Custom Header functionality for Homez
 *
 * @package WordPress
 * @subpackage Homez
 * @since Homez 1.0
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses homez_header_style()
 */
function homez_custom_header_setup() {
	$color_scheme        = homez_get_color_scheme();
	$default_text_color  = trim( $color_scheme[4], '#' );

	/**
	 * Filter Homez custom-header support arguments.
	 *
	 * @since Homez 1.0
	 *
	 * @param array $args {
	 *     An array of custom-header support arguments.
	 *
	 *     @type string $default_text_color     Default color of the header text.
	 *     @type int    $width                  Width in pixels of the custom header image. Default 954.
	 *     @type int    $height                 Height in pixels of the custom header image. Default 1300.
	 *     @type string $wp-head-callback       Callback function used to styles the header image and text
	 *                                          displayed on the blog.
	 * }
	 */
	add_theme_support( 'custom-header', apply_filters( 'homez_custom_header_args', array(
		'default-text-color'     => $default_text_color,
		'width'                  => 954,
		'height'                 => 1300,
		'wp-head-callback'       => 'homez_header_style',
	) ) );
}
add_action( 'after_setup_theme', 'homez_custom_header_setup' );

if ( ! function_exists( 'homez_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog.
 *
 * @since Homez 1.0
 *
 * @see homez_custom_header_setup()
 */
function homez_header_style() {
	return '';
}
endif; // homez_header_style

