<?php
namespace Jet_Reviews\Endpoints;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
/**
 * Define Posts class
 */
class Plugin_Settings extends Base {

	/**
	 * [get_method description]
	 * @return [type] [description]
	 */
	public function get_method() {
		return 'POST';
	}

	/**
	 * Returns route name
	 *
	 * @return string
	 */
	public function get_name() {
		return 'plugin-settings';
	}

	/**
	 * Check user access to current end-popint
	 *
	 * @return string|bool
	 */
	public function permission_callback( $request ) {
		return current_user_can( 'manage_options' );
	}

	/**
	 * [callback description]
	 * @param  [type]   $request [description]
	 * @return function          [description]
	 */
	public function callback( $request ) {

		$data = $request->get_params();

		$current = get_option( jet_reviews()->settings->key, array() );

		if ( is_wp_error( $current ) ) {
			return rest_ensure_response( [
				'status'  => 'error',
				'message' => __( 'Server Error', 'jet-reviews' ),
			] );
		}

		foreach ( $data as $key => $value ) {
			$current[ $key ] = is_array( $value ) ? $value : esc_attr( $value );
		}

		update_option( jet_reviews()->settings->key, $current );

		return rest_ensure_response( [
			'status'  => 'success',
			'message' => __( 'Settings have been saved', 'jet-reviews' ),
		] );
	}

}
