<?php
/**
 * Class: Jet_Smart_Filters_Provider_Jet_Woo_Grid
 * Name: JetWooBuilder Products Grid
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Jet_Smart_Filters_Provider_Jet_Woo_Grid' ) ) {
	/**
	 * Define Jet_Smart_Filters_Provider_Jet_Woo_Grid class
	 */
	class Jet_Smart_Filters_Provider_Jet_Woo_Grid extends Jet_Smart_Filters_Provider_Base {

		/**
		 * Watch for default query
		 */
		public function __construct() {

			if ( ! jet_smart_filters()->query->is_ajax_filter() ) {
				add_filter(
					'jet-woo-builder/shortcodes/jet-woo-products/query-args',
					array( $this, 'filters_trigger' ),
					10, 2
				);

				add_action( 'jet-woo-builder/shortcodes/jet-woo-products/final-query-args',
					array( $this, 'store_default_query' ),
					10, 2
				);

				add_filter(
					'shortcode_atts_jet-woo-products',
					array( $this, 'store_default_atts' ),
					0, 2
				);

				add_action(
					'elementor/widget/before_render_content',
					array( $this, 'store_default_settings' ),
					0
				);

				add_filter(
					'jet-woo-builder/tools/carousel/pre-options',
					array( $this, 'store_carousel_options' ),
					10, 2
				);
			}
		}

		/**
		 * Returns widget name
		 */
		public function widget_name() {

			return 'jet-woo-products';
		}

		/**
		 * Get provider name
		 */
		public function get_name() {

			return __( 'JetWooBuilder Products Grid', 'jet-smart-filters' );
		}

		/**
		 * Get provider ID
		 */
		public function get_id() {
			
			return 'jet-woo-products-grid';
		}

		/**
		* Store default query args
		*/
		public function store_default_query( $query_atts, $shortcode ) {

			$default_query = array();
			$query_id      = ! empty( $shortcode->get_attr( '_element_id' ) )
				? $shortcode->get_attr( '_element_id' )
				: 'default';

			foreach ( array(
				'post_type',
				'wc_query',
				'tax_query',
				'meta_query',
				'orderby',
				'order',
				'posts_per_page',
				'post__in',
				'taxonomy',
				'term',
				's'
			) as $value ) {
				if ( isset( $query_atts[ $value ] ) ) {
					$default_query[ $value ] = $query_atts[ $value ];
				}
			}

			jet_smart_filters()->query->store_provider_default_query( $this->get_id(), $default_query, $query_id );

			return $query_atts;
		}

		/**
		 * Save default carousel options
		 */
		public function store_carousel_options( $options = array(), $all_settings = array() ) {

			$query_id = ! empty( $all_settings['_element_id'] )
				? $all_settings['_element_id']
				: 'default';

			jet_smart_filters()->providers->add_provider_settings(
				$this->get_id(),
				array(
					'carousel_options' => $options,
				),
				$query_id
			);

			return $options;
		}

		/**
		 * Store default query args
		 */
		public function store_default_atts( $atts = array() ) {

			$query_id = ! empty( $atts['_element_id'] )
				? $atts['_element_id']
				: 'default';

			jet_smart_filters()->providers->add_provider_settings( $this->get_id(), $atts, $query_id );

			return $atts;
		}

		/**
		 * Save default widget settings
		 */
		public function store_default_settings( $widget ) {

			if ( $this->widget_name() !== $widget->get_name() ) {
				return;
			}

			$settings         = $widget->get_settings();
			$store_settings   = $this->settings_to_store();
			$default_settings = array();
			$query_id         = ! empty( $settings['_element_id'] )
				? $settings['_element_id']
				: 'default';

			foreach ( $store_settings as $key ) {
				if ( false !== strpos( $key, 'selected_' ) ) {
					$default_settings[ $key ] = isset( $settings[ $key ] ) ? htmlspecialchars( $widget->__render_icon( str_replace( 'selected_', '', $key ), '%s', '', false ) ) : '';
				} else {
					$default_settings[ $key ] = isset( $settings[ $key ] ) ? $settings[ $key ] : '';
				}
			}

			$default_settings['_el_widget_id'] = $widget->get_id();

			// Compatibility with compare and wishlist plugin.
			$default_settings['_widget_id'] = $widget->get_id();

			jet_smart_filters()->providers->store_provider_settings( $this->get_id(), $default_settings, $query_id );
		}

		/**
		 * Returns settings to store list
		 */
		public function settings_to_store() {

			return apply_filters( 'jet-smart-filters/providers/jet-woo-products-grid/settings-list', [
				'show_compare',
				'compare_button_order',
				'compare_button_order_tablet',
				'compare_button_order_mobile',
				'compare_button_icon_normal',
				'selected_compare_button_icon_normal',
				'compare_button_label_normal',
				'compare_button_icon_added',
				'selected_compare_button_icon_added',
				'compare_button_label_added',
				'compare_use_button_icon',
				'compare_button_icon_position',
				'compare_use_as_remove_button',
				'show_wishlist',
				'wishlist_button_order',
				'wishlist_button_order_tablet',
				'wishlist_button_order_mobile',
				'wishlist_button_icon_normal',
				'selected_wishlist_button_icon_normal',
				'wishlist_button_label_normal',
				'wishlist_button_icon_added',
				'selected_wishlist_button_icon_added',
				'wishlist_button_label_added',
				'wishlist_use_button_icon',
				'wishlist_button_icon_position',
				'wishlist_use_as_remove_button',
				'show_quickview',
				'quickview_button_order',
				'quickview_button_icon_normal',
				'selected_quickview_button_icon_normal',
				'quickview_button_label_normal',
				'quickview_use_button_icon',
				'quickview_button_icon_position',
				'jet_woo_builder_qv',
				'jet_woo_builder_qv_template',
				'jet_woo_builder_cart_popup',
				'jet_woo_builder_cart_popup_template',
				'carousel_enabled',
				'carousel_direction',
				'prev_arrow',
				'selected_prev_arrow',
				'next_arrow',
				'selected_next_arrow',
				'enable_custom_query',
				'custom_query_id',
			] );
		}

		public function filters_trigger( $args, $shortcode ) {

			$query_id = ! empty( $shortcode->get_attr( '_element_id' ) )
				? $shortcode->get_attr( '_element_id' )
				: 'default';

			$args['no_found_rows']     = false;
			$args['jet_smart_filters'] = jet_smart_filters()->query->encode_provider_data(
				$this->get_id(),
				$query_id
			);

			return $args;
		}

		/**
		 * Get filtered provider content
		 */
		public function ajax_get_content() {

			if ( ! function_exists( 'wc' ) || ! function_exists( 'jet_woo_builder' ) ) {
				return;
			}

			add_filter(
				'jet-woo-builder/shortcodes/jet-woo-products/query-args',
				array( $this, 'filters_trigger' ),
				10, 2
			);

			add_filter( 'jet-woo-builder/shortcodes/jet-woo-products/final-query-args',
				array( $this, 'add_query_args' )
			);

			$attributes = jet_smart_filters()->query->get_query_settings();

			if( isset( $attributes['use_current_query'] ) && 'yes' === $attributes['use_current_query']  ){
				global $wp_query;
				$wp_query = new WP_Query( jet_smart_filters()->query->get_query_args() );
			}

			if ( ! empty( $attributes['carousel_options'] ) ) {
				$settings = $attributes['carousel_options'];
				$settings['carousel_enabled'] = 'yes';
			} else {
				$settings['carousel_enabled'] = '';
			}

			$shortcode = jet_woo_builder_shortcodes()->get_shortcode( 'jet-woo-products' );

			$shortcode->set_settings( $attributes );

			echo jet_woo_builder_tools()->get_carousel_wrapper_atts(
				$shortcode->do_shortcode( $attributes ),
				$this->sanitize_settings( $settings )
			);
		}

		/**
		 * Get provider wrapper selector
		 */
		public function get_wrapper_selector() {

			return '.elementor-jet-woo-products.jet-woo-builder';
		}

		/**
		 * Get provider list selector
		 */
		public function get_list_selector() {

			return '.jet-woo-products';
		}

		/**
		 * Get provider list item selector
		 */
		public function get_item_selector() {

			return '.jet-woo-builder-product';
		}

		/**
		 * If added unique ID this paramter will determine - search selector inside this ID, or is the same element
		 */
		public function in_depth() {

			return true;
		}

		/**
		 * Pass args from reuest to provider
		 */
		public function apply_filters_in_request() {

			$args = jet_smart_filters()->query->get_query_args();

			if ( ! $args ) {
				return;
			}

			add_filter(
				'jet-woo-builder/shortcodes/jet-woo-products/query-args',
				array( $this, 'filters_trigger' ),
				10, 2
			);

			add_filter( 'jet-woo-builder/shortcodes/jet-woo-products/final-query-args',
				array( $this, 'add_query_args' )
			);
		}

		/**
		 * Add custom query arguments
		 */
		public function add_query_args( $query_atts ) {

			if (
				empty( $query_atts[ 'jet_smart_filters' ] )
				||
				$query_atts[ 'jet_smart_filters' ] !== jet_smart_filters()->render->request_provider( 'raw' ) )
			{
				return;
			}

			foreach ( jet_smart_filters()->query->get_query_args() as $query_var => $value ) {
				if ( in_array( $query_var, array( 'tax_query', 'meta_query' ) ) ) {
					$current = $query_atts[ $query_var ];

					if ( ! empty( $current ) ) {
						$value = array_merge( $current, $value );
					}

					$query_atts[ $query_var ] = $value;
				} else {
					$query_atts[ $query_var ] = $value;
				}
			}

			return $query_atts;
		}
	}
}