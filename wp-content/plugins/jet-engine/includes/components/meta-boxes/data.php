<?php
/**
 * CPT data controller class
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Jet_Engine_Meta_Boxes_Data' ) ) {

	/**
	 * Define Jet_Engine_Meta_Boxes_Data class
	 */
	class Jet_Engine_Meta_Boxes_Data extends Jet_Engine_Base_Data {

		/**
		 * Edit slug
		 *
		 * @var string
		 */
		public $edit        = 'edit';
		public $option_name = 'jet_engine_meta_boxes';

		/**
		 * Update post post type
		 *
		 * @return void
		 */
		public function delete_item( $redirect = true ) {

			if ( ! current_user_can( 'manage_options' ) ) {
				$this->parent->add_notice(
					'error',
					__( 'You don\'t have permissions to do this', 'jet-engine' )
				);
				return;
			}

			$id = isset( $this->request['id'] ) ? esc_attr( $this->request['id'] ) : false;

			if ( ! $id ) {
				$this->parent->add_notice(
					'error',
					__( 'Please provide item ID to delete', 'jet-engine' )
				);
				return;
			}

			$this->before_item_delete( $id );

			$raw = $this->get_raw();

			if ( isset( $raw[ $id ] ) ) {
				unset( $raw[ $id ] );
				update_option( $this->option_name, $raw );
			}

			if ( $redirect ) {
				wp_redirect( $this->parent->get_page_link() );
				die();
			} else {
				return true;
			}

		}

		/**
		 * Update item in DB
		 *
		 * @param  [type] $item [description]
		 * @return [type]       [description]
		 */
		public function update_item_in_db( $item ) {

			$raw        = $this->get_raw();
			$id         = isset( $item['id'] ) ? $item['id'] : 'meta-' . $this->get_numeric_id();
			$item['id'] = $id;
			$raw[ $id ] = $item;

			update_option( $this->option_name, $raw );

			return $id;

		}

		/**
		 * Returns actual numeric ID
		 * @return [type] [description]
		 */
		public function get_numeric_id() {

			$raw  = $this->get_raw();
			$keys = array_keys( $raw );
			$last = end( $keys );

			if ( ! $last ) {
				return 1;
			}

			$num = absint( str_replace( 'meta-', '', $last ) );

			return $num + 1;

		}

		/**
		 * Sanitizr post type request
		 *
		 * @return void
		 */
		public function sanitize_item_request() {

			$valid = true;
			return $valid;

		}

		/**
		 * Prepare post data from request to write into database
		 *
		 * @return array
		 */
		public function sanitize_item_from_request() {

			$request = $this->request;
			$args    = array();

			if ( ! empty( $request['args'] ) ) {
				foreach ( $request['args'] as $arg => $value ) {
					if ( in_array( $arg, array( 'show_edit_link', 'hide_field_names', 'delete_metadata' ) ) ) {
						$args[ $arg ] = filter_var( $value, FILTER_VALIDATE_BOOLEAN );
					} else if ( in_array( $arg, array( 'name' ) ) ) {
						$args[ $arg ] = sanitize_text_field( $value );
					} else {
						$args[ $arg ] = ! is_array( $value ) ? esc_attr( $value ) : $value;
					}

				}
			}

			$meta_fields = ! empty( $request['meta_fields'] ) ? $request['meta_fields'] : array();

			$result['args']        = $args;
			$result['meta_fields'] = $this->sanitize_meta_fields( $meta_fields );

			return $result;

		}

		/**
		 * Retrieve post for edit
		 *
		 * @return array
		 */
		public function get_item_for_edit( $id ) {

			$raw      = $this->get_raw();
			$meta_box = isset( $raw[ $id ] ) ? $raw[ $id ] : array();

			if ( empty( $meta_box ) ) {
				return array(
					'general_settings' => array(),
					'meta_fields'      => array(),
				);
			}

			if ( ! empty( $meta_box['meta_fields'] ) ) {
				$meta_box['meta_fields'] = array_values( $meta_box['meta_fields'] );
			}

			$settings = $meta_box['args'];

			/**
			 * Start - Legacy code for compatibility previously created meta boxes with new conditions
			 */
			if ( ! isset( $settings['active_conditions'] ) ) {
				$settings['active_conditions'] = array();
			}

			if ( ! empty( $settings['allowed_posts'] ) && ! in_array( 'allowed_posts', $settings['active_conditions'] ) ) {
				$settings['active_conditions'][] = 'allowed_posts';
			}

			if ( ! empty( $settings['excluded_posts'] ) && ! in_array( 'excluded_posts', $settings['active_conditions'] ) ) {
				$settings['active_conditions'][] = 'excluded_posts';
			}
			/**
			 * End - Legacy code for compatibility previously created meta boxes with new conditions
			 */

			$result = array(
				'general_settings' => $settings,
				'meta_fields'      => $this->sanitize_repeater_fields( $meta_box['meta_fields'] ),
			);

			return $result;
		}

		/**
		 * Return sanitized repeater field
		 *
		 * @param  [type] $fields [description]
		 * @return [type]         [description]
		 */
		public function sanitize_repeater_fields( $fields ) {

			return array_map( function( $item ) {

				if ( isset( $item['collapsed'] ) ) {
					unset( $item['collapsed'] );
				}

				if ( empty( $item['object_type'] ) ) {
					$item['object_type'] = 'field';
				}

				if ( ! empty( $item['repeater-fields'] ) ) {
					$item['repeater-fields'] = array_values( $item['repeater-fields'] );
					$item['repeater-fields'] = $this->unset_collapsed( $item['repeater-fields'] );
				}

				if ( empty( $item['options'] ) ) {
					$item['options'] = array();
				} else {
					$item['options'] = array_values( $item['options'] );
					$item['options'] = $this->unset_collapsed( $item['options'] );
				}

				if ( ! empty( $item['conditions'] ) ) {
					$item['conditions'] = array_values( $item['conditions'] );
					$item['conditions'] = $this->unset_collapsed( $item['conditions'] );
				}

				return $item;

			}, $fields );

		}

		/**
		 * Unset collapsed value
		 *
		 * @param  [type] $collapsed [description]
		 * @return [type]            [description]
		 */
		public function unset_collapsed( $list ) {
			return array_map( function( $item ) {

				if ( isset( $item['collapsed'] ) ) {
					unset( $item['collapsed'] );
				}

				if ( ! empty( $item['options'] ) ) {
					$item['options'] = array_values( $item['options'] );
					$item['options'] = $this->unset_collapsed( $item['options'] );
				}

				return $item;
			}, $list );
		}

		/**
		 * Returns post type in prepared for register format
		 *
		 * @return array
		 */
		public function get_item_for_register() {
			return $this->get_raw();
		}

		/**
		 * Returns items by args without filtering
		 *
		 * @return array
		 */
		public function get_raw( $args = array() ) {

			if ( ! $this->raw ) {
				$this->raw = get_option( $this->option_name, array() );
			}

			return $this->raw;
		}

		/**
		 * Query post types
		 *
		 * @return array
		 */
		public function get_items() {
			return $this->get_raw();
		}

		/**
		 * Return totals post types count
		 *
		 * @return int
		 */
		public function total_items() {
			return count( $this->get_raw() );
		}

		/**
		 * Stored in wp_options, so always true
		 *
		 * @return [type] [description]
		 */
		public function ensure_db_table() {
			return true;
		}

		/**
		 * Filter post type for register
		 *
		 * @return array
		 */
		public function filter_item_for_register( $item ) {
			return $item;
		}

		/**
		 * Filter post type for edit
		 *
		 * @return array
		 */
		public function filter_item_for_edit( $item ) {
			return $item;
		}

		/**
		 * Return blacklisted items names
		 *
		 * @return array
		 */
		public function items_blacklist() {
			return array();
		}

		/**
		 * Before item update
		 */
		public function before_item_update( $item = array() ) {
			$this->delete_metadata_on_update( $item );
		}

		/**
		 * Before item delete
		 */
		public function before_item_delete( $id = null ) {
			$item = $this->get_item_for_edit( $id );

			if ( $item ) {
				$this->delete_metadata( $item, array(), true );
			}
		}

		/**
		 * Maybe delete metadata on update item
		 */
		public function delete_metadata_on_update( $item = array() ) {

			$args = ! empty( $item['args'] ) ? $item['args'] : array();

			if ( empty( $args['delete_metadata'] ) ) {
				return;
			}

			if ( empty( $item['id'] ) ) {
				return;
			}

			$prev_item = $this->get_item_for_edit( $item['id'] );

			if ( ! $prev_item ) {
				return;
			}

			$prev_meta_fields = ! empty( $prev_item['meta_fields'] ) ? $prev_item['meta_fields'] : array();
			$new_meta_fields  = ! empty( $item['meta_fields'] ) ? $item['meta_fields'] : array();

			if ( empty( $prev_meta_fields ) ) {
				return;
			}

			$prev_meta_names = wp_list_pluck( $prev_meta_fields, 'name' );
			$new_meta_names  = wp_list_pluck( $new_meta_fields, 'name' );

			$to_delete = array_diff( $prev_meta_names, $new_meta_names );

			if ( empty( $to_delete ) ) {
				return;
			}

			$this->delete_metadata( $prev_item, $to_delete );
		}

		/**
		 * Delete metadata of MetaBox
		 */
		public function delete_metadata( $item = array(), $keys_to_delete = array(), $on_delete = false ) {

			$args = ! empty( $item['general_settings'] ) ? $item['general_settings'] : array();

			if ( $on_delete && empty( $args['delete_metadata'] ) ) {
				return;
			}

			$meta_fields = ! empty( $item['meta_fields'] ) ? $item['meta_fields'] : array();

			if ( empty( $meta_fields ) ) {
				return;
			}

			$meta_names  = wp_list_pluck( $meta_fields, 'name' );
			$meta_fields = array_combine( $meta_names, $meta_fields );

			if ( $on_delete ) {
				$keys_to_delete = $meta_names;
			}

			$to_delete = array_filter( $keys_to_delete, function ( $name ) use ( $meta_fields ) {

				if ( ! empty( $meta_fields[ $name ]['object_type'] ) && 'field' !== $meta_fields[ $name ]['object_type'] ) {
					return false;
				}

				if ( ! empty( $meta_fields[ $name ]['type'] ) && 'html' === $meta_fields[ $name ]['type'] ) {
					return false;
				}

				return true;
			} );

			if ( empty( $to_delete ) ) {
				return;
			}

			if ( empty( $args['object_type'] ) ) {
				return;
			}

			switch ( $args['object_type'] ) {
				case 'post':

					Jet_Engine_Tools::delete_metadata_by_object_where(
						'post',
						$to_delete,
						array(
							'post_type' => $args['allowed_post_type'],
						)
					);

					break;

				case 'taxonomy':

					Jet_Engine_Tools::delete_metadata_by_object_where(
						'term',
						$to_delete,
						array(
							'taxonomy' => $args['allowed_tax'],
						)
					);

					break;

				case 'user':

					foreach ( $to_delete as $meta_key ) {
						delete_metadata( 'user', null, $meta_key, null, true );
					}

					break;

				default:
					do_action( 'jet-engine/meta-boxes/data/delete-metadata/' . $args['object_type'], $to_delete, $item );
			}

		}
	}

}
