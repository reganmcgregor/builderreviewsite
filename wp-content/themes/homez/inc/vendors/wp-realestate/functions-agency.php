<?php

function homez_get_agencies( $params = array() ) {
	$params = wp_parse_args( $params, array(
		'limit' => -1,
		'post_status' => 'publish',
		'get_agencies_by' => 'recent',
		'orderby' => '',
		'order' => '',
		'post__in' => array(),
		'fields' => null, // ids
		'author' => null,
	));
	extract($params);

	$query_args = array(
		'post_type'         => 'agency',
		'posts_per_page'    => $limit,
		'post_status'       => $post_status,
		'orderby'       => $orderby,
		'order'       => $order,
	);

	$meta_query = array();
	switch ($get_agencies_by) {
		case 'recent':
			$query_args['orderby'] = 'date';
			$query_args['order'] = 'DESC';
			break;
		case 'featured':
			$meta_query[] = array(
				'key' => WP_REALESTATE_AGENCY_PREFIX.'featured',
	           	'value' => 'on',
	           	'compare' => '=',
			);
			break;
	}

	if ( !empty($post__in) ) {
    	$query_args['post__in'] = $post__in;
    }

    if ( !empty($fields) ) {
    	$query_args['fields'] = $fields;
    }

    if ( !empty($author) ) {
    	$query_args['author'] = $author;
    }

    if ( !empty($meta_query) ) {
    	$query_args['meta_query'] = $meta_query;
    }

	return new WP_Query( $query_args );
}

if ( !function_exists('homez_agency_content_class') ) {
	function homez_agency_content_class( $class ) {
		$prefix = 'agencies';
		if ( is_singular( 'agency' ) ) {
            $prefix = 'agency';
        }
		if ( homez_get_config($prefix.'_fullwidth') ) {
			return 'container-fluid';
		}
		return $class;
	}
}
add_filter( 'homez_agency_content_class', 'homez_agency_content_class', 1 , 1 );

if ( !function_exists('homez_get_agencies_layout_configs') ) {
	function homez_get_agencies_layout_configs() {
		$layout_type = homez_get_agencies_layout_sidebar();
		switch ( $layout_type ) {
		 	case 'left-main':
		 		$configs['left'] = array( 'sidebar' => 'agencies-filter-sidebar', 'class' => 'col-lg-4 col-sm-12 col-12'  );
		 		$configs['main'] = array( 'class' => 'col-lg-8 col-sm-12 col-12' );
		 		break;
		 	case 'main-right':
		 	default:
		 		$configs['right'] = array( 'sidebar' => 'agencies-filter-sidebar',  'class' => 'col-lg-4 col-sm-12 col-12' ); 
		 		$configs['main'] = array( 'class' => 'col-lg-8 col-sm-12 col-12' );
		 		break;
	 		case 'main':
	 			$configs['main'] = array( 'class' => 'col-md-12 col-sm-12 col-12' );
	 			break;
		}
		return $configs; 
	}
}

function homez_get_agencies_layout_sidebar() {
	global $post;
	if ( is_page() && is_object($post) ) {
		$layout_type = get_post_meta( $post->ID, 'apus_page_layout', true );
	}
	if ( empty($layout_type) ) {
		$layout_type = homez_get_config('agencies_layout_sidebar', 'main-right');
	}
	return apply_filters( 'homez_get_agencies_layout_sidebar', $layout_type );
}

function homez_get_agencies_display_mode() {
	global $post;
	if ( !empty($_GET['filter-display-mode']) ) {
		$display_mode = $_GET['filter-display-mode'];
	} else {
		if ( is_page() && is_object($post) ) {
			$display_mode = get_post_meta( $post->ID, 'apus_page_agencies_display_mode', true );
		}
		if ( empty($display_mode) ) {
			$display_mode = homez_get_config('agencies_display_mode', 'grid');
		}
	}
	return apply_filters( 'homez_get_agencies_display_mode', $display_mode );
}

function homez_get_agencies_inner_style() {
	$display_mode = homez_get_agencies_display_mode();
	if ( $display_mode == 'grid' ) {
		$inner_style = 'grid';
	} else {
		$inner_style = 'list';
	}
	return apply_filters( 'homez_get_agencies_inner_style', $inner_style );
}

function homez_get_agencies_columns() {
	global $post;
	if ( is_page() && is_object($post) ) {
		$columns = get_post_meta( $post->ID, 'apus_page_agencies_columns', true );
	}
	if ( empty($columns) ) {
		$columns = homez_get_config('agencies_columns', 3);
	}
	return apply_filters( 'homez_get_agencies_columns', $columns );
}

function homez_get_agencies_pagination() {
	global $post;
	if ( is_page() && is_object($post) ) {
		$pagination = get_post_meta( $post->ID, 'apus_page_agencies_pagination', true );
	}
	if ( empty($pagination) ) {
		$pagination = homez_get_config('agencies_pagination', 'default');
	}
	return apply_filters( 'homez_get_agencies_pagination', $pagination );
}

function homez_is_agencies_page() {
	if ( is_page() ) {
		$page_name = basename(get_page_template());
		if ( $page_name == 'page-agencies.php' ) {
			return true;
		}
	} elseif( is_archive('agency') ) {
		return true;
	}
	return false;
}



// custom fields
add_filter( 'cmb2_meta_boxes', 'homez_is_agencies_fields', 100 );
function homez_is_agencies_fields( array $metaboxes ) {
	$prefix = WP_REALESTATE_AGENCY_PREFIX;
	if ( !empty($metaboxes[ $prefix . 'contact_details' ]['fields']) ) {
		$fields = $metaboxes[ $prefix . 'contact_details' ]['fields'];
		$rfields = array();
		foreach ($fields as $key => $field) {
			$rfields[] = $field;
			if ( !empty($field['id']) && $field['id'] == $prefix . 'phone' ) {
				$rfields[] = array(
					'id'                => $prefix . 'fax',
					'name'              => esc_html__( 'Fax', 'homez' ),
					'type'              => 'text',
				);
				$rfields[] = array(
					'id'                => $prefix . 'whatsapp',
					'name'              => esc_html__( 'Whatsapp', 'homez' ),
					'type'              => 'text',
				);
				$rfields[] = array(
					'id'                => $prefix . 'skype',
					'name'              => esc_html__( 'Skype', 'homez' ),
					'type'              => 'text',
				);
				$rfields[] = array(
					'id'                => $prefix . 'opening_hours',
					'name'              => esc_html__( 'Opening Hours', 'homez' ),
					'type'              => 'text',
				);
				$rfields[] = array(
					'id'                => $prefix . 'languages',
					'name'              => esc_html__( 'Languages', 'homez' ),
					'type'              => 'text',
				);
				$rfields[] = array(
					'id'                => $prefix . 'license',
					'name'              => esc_html__( 'License', 'homez' ),
					'type'              => 'text',
				);
				$rfields[] = array(
					'id'                => $prefix . 'tax_number',
					'name'              => esc_html__( 'Tax Number', 'homez' ),
					'type'              => 'text',
				);
			}
		}
		$metaboxes[ $prefix . 'contact_details' ]['fields'] = $rfields;
	}
	return $metaboxes;
}

add_filter( 'wp-realestate-agency-fields-front', 'homez_is_agencies_fields_front', 100 );
function homez_is_agencies_fields_front($fields) {
	$prefix = WP_REALESTATE_AGENCY_PREFIX;
	$fields[] = array(
		'id'                => $prefix . 'fax',
		'name'              => esc_html__( 'Fax', 'homez' ),
		'type'              => 'text',
		'priority'           => 7.2,
	);
	$fields[] = array(
		'id'                => $prefix . 'whatsapp',
		'name'              => esc_html__( 'Whatsapp', 'homez' ),
		'type'              => 'text',
		'priority'           => 7.3,
	);
	$fields[] = array(
		'id'                => $prefix . 'skype',
		'name'              => esc_html__( 'Skype', 'homez' ),
		'type'              => 'text',
		'priority'           => 7.4,
	);
	$fields[] = array(
		'id'                => $prefix . 'opening_hours',
		'name'              => esc_html__( 'Opening Hours', 'homez' ),
		'type'              => 'text',
		'priority'           => 7.5,
	);
	$fields[] = array(
		'id'                => $prefix . 'languages',
		'name'              => esc_html__( 'Languages', 'homez' ),
		'type'              => 'text',
		'priority'           => 7.6,
	);
	$fields[] = array(
		'id'                => $prefix . 'license',
		'name'              => esc_html__( 'License', 'homez' ),
		'type'              => 'text',
		'priority'           => 7.7,
	);
	$fields[] = array(
		'id'                => $prefix . 'tax_number',
		'name'              => esc_html__( 'Tax Number', 'homez' ),
		'type'              => 'text',
		'priority'           => 7.8,
	);
	return $fields;
}