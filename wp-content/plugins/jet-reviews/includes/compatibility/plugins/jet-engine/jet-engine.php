<?php
namespace Jet_Reviews\Compatibility;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Compatibility Manager
 */
class Jet_Engine {

	/**
	 * A reference to an instance of this class.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    object
	 */
	private static $instance = null;

	/**
	 * [__construct description]
	 */
	public function __construct() {

		if ( ! function_exists( 'jet_engine' ) ) {
			return;
		}

		add_action( 'init', array( $this, 'init' ), 0 );

		add_filter( 'jet-reviews/elementor/registered-dynamic-tags', array( $this, 'register_dynamic_tags' ) );

		add_filter( 'jet-reviews/source/source-post/current-id', array( $this, 'source_post_current_id_modify' ), 10, 2 );

		add_filter( 'jet-reviews/source/source-user/current-id', array( $this, 'source_user_current_id_modify' ), 10, 2 );

		add_filter( 'jet-reviews/public/localized-data', array( $this, 'maybe_modify_public_localized_data' ), 10, 2 );

	}

	/**
	 * Inin Module
	 */
	public function init() {
		require_once $this->get_file_path( 'listings/manager.php' );
		new Jet_Engine\Listings\Manager();

		require_once $this->get_file_path( 'query-builder/manager.php' );
		new Jet_Engine\Query_Builder\Manager();
	}

	/**
	 * Returnbs path inside current folder
	 * @param  string $relative_path [description]
	 * @return [type]               [description]
	 */
	public function get_file_path( $relative_path = '' ) {
		return jet_reviews()->plugin_path( 'includes/compatibility/plugins/jet-engine/' . $relative_path );
	}

	/**
	 * @param string $relative_path
	 *
	 * @return string
	 */
	public function get_file_url( $relative_path = '' ) {
		return jet_reviews()->plugin_url( 'includes/compatibility/plugins/jet-engine/' . $relative_path );
	}

	/**
	 * @param $registered_tags
	 *
	 * @return mixed
	 */
	public function register_dynamic_tags( $registered_tags ) {

		$registered_tags = array_merge( $registered_tags, array(
			'\\Jet_Reviews\\Elementor\\Dynamic_Tags\\Review_Average_Rating' => jet_reviews()->plugin_path( 'includes/compatibility/plugins/jet-engine/dynamic-tags/review-average-rating.php' ),
			'\\Jet_Reviews\\Elementor\\Dynamic_Tags\\Review_Author_Avatar' => jet_reviews()->plugin_path( 'includes/compatibility/plugins/jet-engine/dynamic-tags/review-author-avatar.php' ),
			'\\Jet_Reviews\\Elementor\\Dynamic_Tags\\Review_Property' => jet_reviews()->plugin_path( 'includes/compatibility/plugins/jet-engine/dynamic-tags/review-property.php' ),
		) );

		return $registered_tags;
	}

	/**
	 * @param $current_id
	 * @param $source
	 *
	 * @return int
	 */
	public function source_post_current_id_modify( $current_id, $source ) {

		$current_object = jet_engine()->listings->data->get_current_object();

		if ( $current_object && 'WP_Post' === get_class( $current_object ) ) {
			return $current_object->ID;
		}

		return apply_filters( 'jet-reviews/compatibility/listing/post/current-id', $current_id, $current_object );
	}

	/**
	 * @param $current_id
	 * @param $source
	 *
	 * @return mixed
	 */
	public function source_user_current_id_modify( $current_id, $source ) {

		$current_object = jet_engine()->listings->data->get_current_object();

		if ( $current_object ) {
			return $current_object->ID;
		}

		return $current_id;
	}

	/**
	 * @param $data
	 * @return mixed
	 */
	public function maybe_modify_public_localized_data( $data ) {

		if ( ! jet_engine()->modules->is_module_active( 'profile-builder' ) ) {
			return $data;
		}

		if ( ! \Jet_Engine\Modules\Profile_Builder\Module::instance()->query->is_single_user_page() ) {
			return $data;
		}

		$user_type_data = jet_reviews()->settings->get_source_settings_data( 'user', 'wp-user' );
		$review_type_data = \Jet_Reviews\Reviews\Data::get_instance()->get_review_type( $user_type_data['review_type'] );

		if ( ! empty( $review_type_data ) ) {
			$review_type_data = $review_type_data[0];
			$review_type_data['fields'] = maybe_unserialize( $review_type_data['fields'] );
		}

		$data['reviewTypeData'] = ! empty( $review_type_data ) ? $review_type_data : $data['reviewTypeData'];

		return $data;
	}

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

}

Jet_Engine::instance();
