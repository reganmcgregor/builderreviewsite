<?php

function homez_get_properties( $params = array() ) {
	$params = wp_parse_args( $params, array(
		'limit' => -1,
		'post_status' => 'publish',
		'get_properties_by' => 'recent',
		'orderby' => '',
		'order' => '',
		'post__in' => array(),
		'fields' => null, // ids
		'author' => null,
		'statuses' => array(),
		'types' => array(),
		'locations' => array(),
		'amenities' => array(),
		'materials' => array(),
		'labels' => array(),
	));
	extract($params);

	$query_args = array(
		'post_type'         => 'property',
		'posts_per_page'    => $limit,
		'post_status'       => $post_status,
		'orderby'       => $orderby,
		'order'       => $order,
	);

	$meta_query = array();
	switch ($get_properties_by) {
		case 'recent':
			$query_args['orderby'] = 'date';
			$query_args['order'] = 'DESC';
			break;
		case 'featured':
			$meta_query[] = array(
				'key' => WP_REALESTATE_PROPERTY_PREFIX.'featured',
	           	'value' => 'on',
	           	'compare' => '=',
			);
			break;
		case 'urgent':
			$meta_query[] = array(
				'key' => WP_REALESTATE_PROPERTY_PREFIX.'urgent',
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

    $tax_query = array();
    if ( !empty($statuses) ) {
    	$tax_query[] = array(
            'taxonomy'      => 'property_status',
            'field'         => 'slug',
            'terms'         => $statuses,
            'operator'      => 'IN'
        );
    }
    if ( !empty($types) ) {
    	$tax_query[] = array(
            'taxonomy'      => 'property_type',
            'field'         => 'slug',
            'terms'         => $types,
            'operator'      => 'IN'
        );
    }
    if ( !empty($locations) ) {
    	$tax_query[] = array(
            'taxonomy'      => 'property_location',
            'field'         => 'slug',
            'terms'         => $locations,
            'operator'      => 'IN'
        );
    }

    if ( !empty($amenities) ) {
    	$tax_query[] = array(
            'taxonomy'      => 'property_amenity',
            'field'         => 'slug',
            'terms'         => $amenities,
            'operator'      => 'IN'
        );
    }
    if ( !empty($materials) ) {
    	$tax_query[] = array(
            'taxonomy'      => 'property_material',
            'field'         => 'slug',
            'terms'         => $materials,
            'operator'      => 'IN'
        );
    }
    if ( !empty($labels) ) {
    	$tax_query[] = array(
            'taxonomy'      => 'property_label',
            'field'         => 'slug',
            'terms'         => $labels,
            'operator'      => 'IN'
        );
    }

    if ( !empty($tax_query) ) {
    	$query_args['tax_query'] = $tax_query;
    }
    
    if ( !empty($meta_query) ) {
    	$query_args['meta_query'] = $meta_query;
    }

	return new WP_Query( $query_args );
}

if ( !function_exists('homez_property_content_class') ) {
	function homez_property_content_class( $class ) {
		$prefix = 'properties';
		if ( is_singular( 'property' ) ) {
            $prefix = 'property';
        }
		if ( homez_get_config($prefix.'_fullwidth') ) {
			return 'container-fluid';
		}
		return $class;
	}
}
add_filter( 'homez_property_content_class', 'homez_property_content_class', 1 , 1  );

function homez_property_template_folder_name($folder) {
	$folder = 'template-properties';
	return $folder;
}
add_filter( 'wp-realestate-theme-folder-name', 'homez_property_template_folder_name', 10 );

if ( !function_exists('homez_get_properties_layout_configs') ) {
	function homez_get_properties_layout_configs() {
		$layout_sidebar = homez_get_properties_layout_sidebar();

		$sidebar = homez_get_properties_filter_sidebar();
		switch ( $layout_sidebar ) {
		 	case 'left-main':
		 		$configs['left'] = array( 'sidebar' => $sidebar, 'class' => 'col-lg-4 col-sm-12 col-12 sidebar-blog'  );
		 		$configs['main'] = array( 'class' => 'col-lg-8 col-sm-12 col-12' );
		 		break;
		 	case 'main-right':
		 	default:
		 		$configs['right'] = array( 'sidebar' => $sidebar,  'class' => 'col-lg-4 col-sm-12 col-12 sidebar-blog' ); 
		 		$configs['main'] = array( 'class' => 'col-lg-8 col-sm-12 col-12' );
		 		break;
	 		case 'main':
	 			$configs['main'] = array( 'class' => 'col-md-12 col-sm-12 col-12' );
	 			break;
		}
		return $configs; 
	}
}

function homez_get_properties_layout_sidebar() {
	global $post;
	if ( is_page() && is_object($post) ) {
		$layout_type = get_post_meta( $post->ID, 'apus_page_layout', true );
	}
	if ( empty($layout_type) ) {
		$layout_type = homez_get_config('properties_layout_sidebar', 'main-right');
	}
	return apply_filters( 'homez_get_properties_layout_sidebar', $layout_type );
}

function homez_get_properties_layout_type() {
	global $post;
	if ( is_page() && is_object($post) ) {
		$layout_type = get_post_meta( $post->ID, 'apus_page_layout_type', true );
	}
	if ( empty($layout_type) ) {
		$layout_type = homez_get_config('properties_layout_type', 'default');
	}
	return apply_filters( 'homez_get_properties_layout_type', $layout_type );
}

function homez_get_properties_display_mode() {
	global $post;
	if ( !empty($_GET['filter-display-mode']) ) {
		$display_mode = $_GET['filter-display-mode'];
	} else {
		if ( is_page() && is_object($post) ) {
			$display_mode = get_post_meta( $post->ID, 'apus_page_display_mode', true );
		}
		if ( empty($display_mode) ) {
			$display_mode = homez_get_config('properties_display_mode', 'grid');
		}
	}
	return apply_filters( 'homez_get_properties_display_mode', $display_mode );
}

function homez_get_properties_inner_style() {
	global $post;
	$display_mode = homez_get_properties_display_mode();
	if ( $display_mode == 'list' ) {
		if ( is_page() && is_object($post) ) {
			$inner_style = get_post_meta( $post->ID, 'apus_page_inner_list_style', true );
		}
		if ( empty($inner_style) ) {
			$inner_style = homez_get_config('properties_inner_list_style', 'list');
		}
	} else {
		if ( is_page() && is_object($post) ) {
			$inner_style = get_post_meta( $post->ID, 'apus_page_inner_grid_style', true );
		}
		if ( empty($inner_style) ) {
			$inner_style = homez_get_config('properties_inner_grid_style', 'grid');
		}
	}
	return apply_filters( 'homez_get_properties_inner_style', $inner_style );
}

function homez_get_properties_columns() {
	global $post;
	if ( is_page() && is_object($post) ) {
		$columns = get_post_meta( $post->ID, 'apus_page_properties_columns', true );
	}
	if ( empty($columns) ) {
		$columns = homez_get_config('properties_columns', 3);
	}
	return apply_filters( 'homez_get_properties_columns', $columns );
}

function homez_get_properties_pagination() {
	global $post;
	if ( is_page() && is_object($post) ) {
		$pagination = get_post_meta( $post->ID, 'apus_page_properties_pagination', true );
	}
	if ( empty($pagination) ) {
		$pagination = homez_get_config('properties_pagination', 'default');
	}
	return apply_filters( 'homez_get_properties_pagination', $pagination );
}

function homez_get_property_layout_type() {
	global $post;
	if ( defined('HOMEZ_DEMO_MODE') && HOMEZ_DEMO_MODE ) {
		$layout_type = get_post_meta($post->ID, WP_REALESTATE_PROPERTY_PREFIX.'layout_type', true);
	}
	
	if ( empty($layout_type) ) {
		$layout_type = homez_get_config('property_layout_type', 'v1');
	}
	return apply_filters( 'homez_get_property_layout_type', $layout_type );
}

function homez_property_scripts() {
	
	wp_enqueue_style( 'leaflet' );
	wp_enqueue_script( 'jquery-highlight' );
    wp_enqueue_script( 'leaflet' );
    wp_enqueue_script( 'control-geocoder' );
    wp_enqueue_script( 'esri-leaflet' );
    wp_enqueue_script( 'esri-leaflet-geocoder' );
    wp_enqueue_script( 'leaflet-markercluster' );
    wp_enqueue_script( 'leaflet-HtmlIcon' );
    
    if ( wp_realestate_get_option('map_service') == 'google-map' ) {
    	wp_enqueue_script( 'leaflet-GoogleMutant' );
    }

    wp_register_script( 'sticky-kit', get_template_directory_uri() . '/js/sticky-kit.min.js', array( 'jquery' ), '20150330', true );
    
	wp_register_script( 'homez-property', get_template_directory_uri() . '/js/property.js', array( 'jquery', 'wp-realestate-main', 'perfect-scrollbar', 'imagesloaded' ), '20150330', true );

	$currency_symbol = ! empty( wp_realestate_get_option('currency_symbol') ) ? wp_realestate_get_option('currency_symbol') : '$';
	$dec_point = ! empty( wp_realestate_get_option('money_dec_point') ) ? wp_realestate_get_option('money_dec_point') : '.';
	$thousands_separator = ! empty( wp_realestate_get_option('money_thousands_separator') ) ? wp_realestate_get_option('money_thousands_separator') : '';

	wp_localize_script( 'homez-property', 'homez_property_opts', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ),

		'dec_point' => $dec_point,
		'thousands_separator' => $thousands_separator,
		'currency' => esc_attr($currency_symbol),
		'monthly_text' => esc_html__('Monthly Payment: ', 'homez'),
		'compare_added_title' => esc_html__('Compared', 'homez'),
		'compare_title' => esc_html__('Compare', 'homez'),
		'compare_added_tooltip_title' => esc_html__('Remove Compare', 'homez'),
		'compare_add_tooltip_title' => esc_html__('Add Compare', 'homez'),
		'favorite_added_tooltip_title' => esc_html__('Remove Favorite', 'homez'),
		'favorite_add_tooltip_title' => esc_html__('Add Favorite', 'homez'),

		'template' => apply_filters( 'homez_autocompleate_search_template', '<a href="{{url}}" class="d-flex align-items-center autocompleate-media">
			<div class="flex-shrink-0">
				<img src="{{image}}" class="media-object" height="55" width="55">
			</div>
			<div class="flex-grow-1">
				<h4>{{title}}</h4>
				{{{price}}}
				{{{metas}}}
				</div></a>' ),
        'empty_msg' => apply_filters( 'homez_autocompleate_search_empty_msg', esc_html__( 'Unable to find any listing that match the currenty query', 'homez' ) ),
	));
	wp_enqueue_script( 'homez-property' );

	$here_map_api_key = '';
	$here_style = '';
	$mapbox_token = '';
	$mapbox_style = '';
	$custom_style = '';
	$googlemap_type = wp_realestate_get_option('googlemap_type', 'roadmap');
	if ( empty($googlemap_type) ) {
		$googlemap_type = 'roadmap';
	}
	$map_service = wp_realestate_get_option('map_service', '');
	if ( $map_service == 'mapbox' ) {
		$mapbox_token = wp_realestate_get_option('mapbox_token', '');
		$mapbox_style = wp_realestate_get_option('mapbox_style', 'streets-v11');
		if ( empty($mapbox_style) || !in_array($mapbox_style, array( 'streets-v11', 'light-v10', 'dark-v10', 'outdoors-v11', 'satellite-v9' )) ) {
			$mapbox_style = 'streets-v11';
		}
	} elseif ( $map_service == 'here' ) {
		$here_map_api_key = wp_realestate_get_option('here_map_api_key', '');
		$here_style = wp_realestate_get_option('here_map_style', 'normal.day');
	} else {
		$custom_style = wp_realestate_get_option('google_map_style', '');
	}

	wp_register_script( 'homez-property-map', get_template_directory_uri() . '/js/property-map.js', array( 'jquery' ), '20150330', true );
	wp_localize_script( 'homez-property-map', 'homez_property_map_opts', array(
		'map_service' => $map_service,
		'mapbox_token' => $mapbox_token,
		'mapbox_style' => $mapbox_style,
		'here_map_api_key' => $here_map_api_key,
		'here_style' => $here_style,
		'custom_style' => $custom_style,
		'googlemap_type' => $googlemap_type,
		'default_latitude' => wp_realestate_get_option('default_maps_location_latitude', '43.6568'),
		'default_longitude' => wp_realestate_get_option('default_maps_location_longitude', '-79.4512'),
		'default_pin' => wp_realestate_get_option('default_maps_pin', ''),
		
	));
	wp_enqueue_script( 'homez-property-map' );
}
add_action( 'wp_enqueue_scripts', 'homez_property_scripts', 10 );

function homez_is_properties_page() {
	if ( is_page() ) {
		$page_name = basename(get_page_template());
		if ( $page_name == 'page-properties.php' ) {
			return true;
		}
	} elseif( is_post_type_archive('property') || is_tax('property_status') || is_tax('property_type') || is_tax('property_location') || is_tax('property_tag') ) {
		return true;
	}
	return false;
}

function homez_property_metaboxes($fields) {
	// property

	if ( defined('HOMEZ_DEMO_MODE') && HOMEZ_DEMO_MODE ) {
		$prefix = WP_REALESTATE_PROPERTY_PREFIX;
		if ( !empty($fields) ) {
			$fields[ $prefix . 'tab-layout-version' ] = array(
				'id' => $prefix . 'tab-layout-version',
				'icon' => 'dashicons-admin-appearance',
				'title' => esc_html__( 'Layout Type', 'homez' ),
				'fields' => array(
					array(
						'name'              => esc_html__( 'Layout Type', 'homez' ),
						'id'                => $prefix . 'layout_type',
						'type'              => 'select',
						'options'			=> array(
			                '' => esc_html__('Global Settings', 'homez'),
			                'v1' => esc_html__('Version 1', 'homez'),
			                'v2' => esc_html__('Version 2', 'homez'),
			                'v3' => esc_html__('Version 3', 'homez'),
			                'v4' => esc_html__('Version 4', 'homez'),
			                'v5' => esc_html__('Version 5', 'homez'),
			                'v6' => esc_html__('Version 6', 'homez'),
			                'v7' => esc_html__('Version 7', 'homez'),
			                'v8' => esc_html__('Version 8', 'homez'),
			                'v9' => esc_html__('Version 9', 'homez'),
			                'v10' => esc_html__('Version 10', 'homez'),
			            ),
					)
				)
			);
		}
	}
	
	return $fields;
}
add_filter( 'wp-realestate-admin-custom-fields', 'homez_property_metaboxes' );


add_filter('wp_realestate_settings_general', 'homez_properties_settings_general', 10);
function homez_properties_settings_general($fields) {
	$rfields = array();
	foreach ($fields as $key => $field) {
		$rfields[] = $field;
		if ( $field['id'] == 'default_maps_location_longitude' ) {
			$rfields[] = array(
				'name'    => esc_html__( 'Map Pin', 'homez' ),
				'desc'    => esc_html__( 'Enter your map pin', 'homez' ),
				'id'      => 'default_maps_pin',
				'type'    => 'file',
				'options' => array(
					'url' => true,
				),
				'query_args' => array(
					'type' => array(
						'image/gif',
						'image/jpeg',
						'image/png',
					),
				),
			);
		}
	}
	return $rfields;
}

add_action( 'wre_ajax_homez_get_ajax_properties', 'homez_get_ajax_properties' );

add_action( 'wp_ajax_homez_get_ajax_properties', 'homez_get_ajax_properties' );
add_action( 'wp_ajax_nopriv_homez_get_ajax_properties', 'homez_get_ajax_properties' );
function homez_get_ajax_properties() {
	$settings = !empty($_POST['settings']) ? $_POST['settings'] : array();

    extract( $settings );

    $status_slugs = !empty($status_slugs) ? array_map('trim', explode(',', $status_slugs)) : array();
    $type_slugs = !empty($type_slugs) ? array_map('trim', explode(',', $type_slugs)) : array();
    $location_slugs = !empty($location_slugs) ? array_map('trim', explode(',', $location_slugs)) : array();
    $amenity_slugs = !empty($amenity_slugs) ? array_map('trim', explode(',', $amenity_slugs)) : array();
    $material_slugs = !empty($material_slugs) ? array_map('trim', explode(',', $material_slugs)) : array();
    $label_slugs = !empty($label_slugs) ? array_map('trim', explode(',', $label_slugs)) : array();

    $args = array(
        'limit' => $limit,
        'get_properties_by' => $get_properties_by,
        'orderby' => $orderby,
        'order' => $order,
        'statuses' => $status_slugs,
        'types' => $type_slugs,
        'locations' => $location_slugs,
        'amenities' => $amenity_slugs,
        'materials' => $material_slugs,
        'labels' => $label_slugs,
    );
    $loop = homez_get_properties($args);
    
    if ( $loop->have_posts() ) {
        while ( $loop->have_posts() ) : $loop->the_post();
        	echo WP_RealEstate_Template_Loader::get_template_part( 'properties-styles/inner-grid' );
        endwhile;
        wp_reset_postdata();
    }
    exit();
}

add_action( 'wre_ajax_homez_get_ajax_properties_load_more', 'homez_get_ajax_properties_load_more' );

add_action( 'wp_ajax_homez_get_ajax_properties_load_more', 'homez_get_ajax_properties_load_more' );
add_action( 'wp_ajax_nopriv_homez_get_ajax_properties_load_more', 'homez_get_ajax_properties_load_more' );
function homez_get_ajax_properties_load_more() {
	$paged = !empty($_POST['paged']) ? $_POST['paged'] : '';
	$post_id = !empty($_POST['post_id']) ? $_POST['post_id'] : '';
	$type = !empty($_POST['type']) ? $_POST['type'] : 'agent';


	if ( empty($paged) || empty($post_id) ) {
		$return = array(
			'paged' => 1,
			'output' => '',
			'load_more' => false
		);
		echo wp_json_encode($return);
        exit;
	}
	$return = array(
		'paged' => $paged + 1,
		'output' => '',
		'load_more' => false
	);
    if ( $type == 'agent' ) {

    	$number = homez_get_config('agent_property_per_page', 3);
		$columns = homez_get_config('agent_property_columns', 3);

    	$loop = WP_RealEstate_Query::get_agents_properties(array(
		    'agent_ids' => array($post_id),
		    'post_per_page' => $number,
		    'paged' => $paged
		));
    } else {
    	$number = homez_get_config('agency_property_per_page', 3);
		$columns = homez_get_config('agency_property_columns', 3);
    	$agents = WP_RealEstate_Query::get_agency_agents( $post_id, array('fields' => 'ids') );
		if ( !empty($agents->posts) ) {
		    $loop = WP_RealEstate_Query::get_agents_properties(array(
		        'agent_ids' => $agents->posts,
		        'post_per_page' => $number,
		        'paged' => $paged
		    ));
		}
    }
    $i = $number*$paged - $number;
    $bcol = 12/$columns;
    $output = '';
    if ( !empty($loop) && $loop->have_posts() ) {
    	$return['load_more'] = $loop->max_num_pages > $paged ? true : false;
        while ( $loop->have_posts() ) : $loop->the_post();
        	$classes = '';
            if ( $i%2 == 0 ) {
                $classes .= ' sm-clearfix';
            }
            if ( $i%$columns == 0 ) {
                $classes .= ' md-clearfix lg-clearfix';
            }
        	$output .= '<div class="col-12 col-sm-6 col-md-'.$bcol.' '.$classes.'">';
        	$output .= WP_RealEstate_Template_Loader::get_template_part( 'properties-styles/inner-grid' );
        	$output .= '</div>';
        $i++; endwhile;
        wp_reset_postdata();
    }
    $return['output'] = $output;
    echo wp_json_encode($return);
    exit();
}

add_action( 'wre_ajax_homez_get_ajax_agents_load_more', 'homez_get_ajax_agents_load_more' );

add_action( 'wp_ajax_homez_get_ajax_agents_load_more', 'homez_get_ajax_agents_load_more' );
add_action( 'wp_ajax_nopriv_homez_get_ajax_agents_load_more', 'homez_get_ajax_agents_load_more' );
function homez_get_ajax_agents_load_more() {
	$paged = !empty($_POST['paged']) ? $_POST['paged'] : '';
	$post_id = !empty($_POST['post_id']) ? $_POST['post_id'] : '';


	if ( empty($paged) || empty($post_id) ) {
		$return = array(
			'paged' => 1,
			'output' => '',
			'load_more' => false
		);
		echo wp_json_encode($return);
        exit;
	}
	$return = array(
		'paged' => $paged + 1,
		'output' => '',
		'load_more' => false
	);
	
	$loop = WP_RealEstate_Query::get_agency_agents($post_id, array(
	    'post_per_page' => get_option('posts_per_page'),
	    'paged' => $paged
	));
    
    $output = '';
    if ( !empty($loop) && $loop->have_posts() ) {
    	$return['load_more'] = $loop->max_num_pages > $paged ? true : false;
        while ( $loop->have_posts() ) : $loop->the_post();
        	$output .= '<div class="col-12 col-sm-6 list-item">';
        	$output .= WP_RealEstate_Template_Loader::get_template_part( 'agents-styles/inner-list' );
        	$output .= '</div>';
        endwhile;
        wp_reset_postdata();
    }
    $return['output'] = $output;
    echo wp_json_encode($return);
    exit();
}

remove_action( 'wp_realestate_before_property_archive', array( 'WP_RealEstate_Property', 'display_properties_results_filters' ), 5 );

function homez_display_mode_form($display_mode, $form_url) {
	ob_start();
	?>
	<div class="properties-display-mode-wrapper">
		<form class="properties-display-mode" method="get" action="<?php echo esc_url($form_url); ?>">
			<div class="inner">
				<label for="filter-display-mode-grid">
					<input id="filter-display-mode-grid" type="radio" name="filter-display-mode" value="grid" <?php checked('grid', $display_mode); ?>>
					<span><?php echo esc_html__('Grid','homez') ?></span>
				</label>
				<label for="filter-display-mode-list">
					<input id="filter-display-mode-list" type="radio" name="filter-display-mode" value="list" <?php checked('list', $display_mode); ?>>
					<span><?php echo esc_html__('List','homez') ?></span>
				</label>
			</div>
			<?php WP_RealEstate_Mixes::query_string_form_fields( null, array( 'filter-display-mode', 'submit' ) ); ?>
		</form>
	</div>
	<?php
	$output = ob_get_clean();
	return $output;
}

function homez_properties_display_mode_form() {
	$properties_page = WP_RealEstate_Mixes::get_properties_page_url();
	$display_mode = homez_get_properties_display_mode();
	$output = homez_display_mode_form($display_mode, $properties_page);
	
	echo trim($output);
}
add_action( 'wp_realestate_before_property_archive', 'homez_properties_display_mode_form', 30 );

function homez_properties_start_ordering_display_mode() {
	?>
	<div class="ordering-display-mode-wrapper d-flex align-items-center">
	<?php
}
function homez_properties_end_ordering_display_mode() {
	?>
	</div>
	<?php
}
add_action( 'wp_realestate_before_property_archive', 'homez_properties_start_ordering_display_mode', 20 );
add_action( 'wp_realestate_before_property_archive', 'homez_properties_end_ordering_display_mode', 40 );


function homez_agents_start_ordering_display_mode() {
	?>
	<div class="ordering-display-mode-wrapper">
	<?php
}
function homez_agents_end_ordering_display_mode() {
	?>
	</div>
	<?php
}

function homez_agents_filter_sidebar() {
	if ( homez_get_agents_layout_sidebar() == 'main' && is_active_sidebar( 'agents-filter-top-sidebar' ) ) {
		dynamic_sidebar( 'agents-filter-top-sidebar' );
	}
}

add_action( 'wp_realestate_before_agent_archive', 'homez_agents_start_ordering_display_mode', 12 );
add_action( 'wp_realestate_before_agent_archive', 'homez_agents_filter_sidebar', 10 );
add_action( 'wp_realestate_before_agent_archive', 'homez_agents_end_ordering_display_mode', 16 );

function homez_agencies_start_ordering_display_mode() {
	?>
	<div class="ordering-display-mode-wrapper">
	<?php
}
function homez_agencies_end_ordering_display_mode() {
	?>
	</div>
	<?php
}

function homez_agency_filter_sidebar() {
	if ( homez_get_agencies_layout_sidebar() == 'main' && is_active_sidebar( 'agencies-filter-top-sidebar' ) ) {
		dynamic_sidebar( 'agencies-filter-top-sidebar' );
	}
}

add_action( 'wp_realestate_before_agency_archive', 'homez_agencies_start_ordering_display_mode', 12 );
add_action( 'wp_realestate_before_agency_archive', 'homez_agency_filter_sidebar', 10 );
add_action( 'wp_realestate_before_agency_archive', 'homez_agencies_end_ordering_display_mode', 16 );

function homez_properties_display_filter_btn() {
	$_html = '';
	$layout_type = homez_get_properties_layout_type();
	$layout_sidebar = homez_get_properties_layout_sidebar();
	if ( $layout_type == 'default' && $layout_sidebar == 'main' && is_active_sidebar( 'properties-filter-sidebar-fixed' ) ) {

		$_html .= '<div class="show-filter-btn-wrapper">';
		$_html .= '<a class="btn btn-show-filter btn-show-filter-top" href="javascript:void(0);"><i class="flaticon-filter-results-button"></i><span>'.esc_html__('Show Filter', 'homez').'</span></a>';
		$_html .= '</div>';
	}
	echo trim($_html);
}
add_action( 'wp_realestate_before_property_archive', 'homez_properties_display_filter_btn', 2 );

function homez_properties_display_save_search($rand_key) {
	$output = WP_RealEstate_Template_Loader::get_template_part('loop/property/properties-save-search-form2', array('rand_key' => $rand_key));
	echo trim($output);
}

function homez_placeholder_img_src( $size = 'thumbnail' ) {
	$src               = get_template_directory_uri() . '/images/placeholder.png';
	$placeholder_image = homez_get_config('property_placeholder_image');
	if ( !empty($placeholder_image['id']) ) {
        if ( is_numeric( $placeholder_image['id'] ) ) {
			$image = wp_get_attachment_image_src( $placeholder_image['id'], $size );

			if ( ! empty( $image[0] ) ) {
				$src = $image[0];
			}
		} else {
			$src = $placeholder_image;
		}
    }

	return apply_filters( 'homez_job_placeholder_img_src', $src );
}

function homez_compare_footer_html() {
	if ( !homez_get_config('listing_enable_compare', true) ) {
		return;
	}
	$compare_ids = WP_RealEstate_Compare::get_compare_items(); ?>
	<div id="compare-sidebar" class="<?php echo esc_attr(count($compare_ids) > 0 ? 'active' : ''); ?>">
		<h3 class="title"><?php echo esc_html__('Compare Properties', 'homez'); ?></h3>
		<div class="compare-sidebar-inner">
			<div class="compare-list">
				<?php
					if ( count($compare_ids) > 0 ) {
						$page_id = wp_realestate_get_option('compare_properties_page_id');
	            		$submit_url = $page_id ? get_permalink($page_id) : home_url( '/' );
						
						foreach ($compare_ids as $property_id) {
							$post_object = get_post( $property_id );
	                        if ( $post_object ) {
	                            setup_postdata( $GLOBALS['post'] =& $post_object );
	                            echo WP_RealEstate_Template_Loader::get_template_part( 'properties-styles/inner-list-compare-small' );
	                        }
						}
					}
				?>
			</div>
			<?php if ( count($compare_ids) > 0 ) { ?>
				<div class="compare-actions">
					<div class="row row-20 clearfix">
						<div class="col-6">
						<a href="<?php echo esc_url($submit_url); ?>" class="btn btn-dark btn-sm w-100"><?php echo esc_html__('Compare', 'homez'); ?></a>
						</div>
						<div class="col-6">
						<a href="javascript:void(0);" class="btn-remove-compare-all btn btn-danger btn-sm w-100" data-nonce="<?php echo esc_attr(wp_create_nonce( 'wp-realestate-remove-property-compare-nonce' )); ?>"><?php echo esc_html__('Clear', 'homez'); ?></a>
						</div>
					</div>
				</div>
			<?php } ?>
		</div>
		<div class="compare-sidebar-btn">
			<?php esc_html_e( 'Compare', 'homez' ); ?> (<span class="count"><?php echo count($compare_ids); ?></span>)
		</div>
	</div><!-- .widget-area -->
<?php
}
add_action( 'wp_footer', 'homez_compare_footer_html', 10 );

function homez_add_remove_property_compare_return($return) {
	$compare_ids = WP_RealEstate_Compare::get_compare_items();
	$output = '';
	if ( !empty($compare_ids) && count($compare_ids) > 0 ) {
		ob_start();
		$page_id = wp_realestate_get_option('compare_properties_page_id');
		$submit_url = $page_id ? get_permalink($page_id) : home_url( '/' );
		?>
		<div class="compare-list">
			<?php
			foreach ($compare_ids as $property_id) {
				$post_object = get_post( $property_id );
                if ( $post_object ) {
                    setup_postdata( $GLOBALS['post'] =& $post_object );
                    echo WP_RealEstate_Template_Loader::get_template_part( 'properties-styles/inner-list-compare-small' );
                }
			}
			?>
		</div>
		<div class="compare-actions">
			<div class="row row-20 clearfix">
				<div class="col-6">
				<a href="<?php echo esc_url($submit_url); ?>" class="btn btn-dark btn-sm w-100"><?php echo esc_html__('Compare', 'homez'); ?></a>
				</div>
				<div class="col-6">
				<a href="javascript:void(0);" class="btn-remove-compare-all btn btn-danger btn-sm w-100" data-nonce="<?php echo esc_attr(wp_create_nonce( 'wp-realestate-remove-property-compare-nonce' )); ?>"><?php echo esc_html__('Clear', 'homez'); ?></a>
				</div>
			</div>
		</div>
		<?php
		$output = ob_get_clean();
	}
	$return['html_output'] = $output;
	$return['count'] = !empty($compare_ids) ? count($compare_ids) : 0;
	

	return $return;
}
add_filter( 'wp-realestate-process-add-property-compare-return', 'homez_add_remove_property_compare_return', 10, 1 );
add_filter( 'wp-realestate-process-remove-property-compare-return', 'homez_add_remove_property_compare_return', 10, 1 );


remove_action( 'wp_realestate_before_property_archive', array( 'WP_RealEstate_Property', 'display_properties_orderby_start' ), 15 );
add_action( 'wp_realestate_before_property_archive', array( 'WP_RealEstate_Property', 'display_properties_orderby_start' ), 1 );



// autocomplete search properties
add_action( 'wre_ajax_homez_autocomplete_search_properties', 'homez_autocomplete_search_properties' );

add_action( 'wp_ajax_homez_autocomplete_search_properties', 'homez_autocomplete_search_properties' );
add_action( 'wp_ajax_nopriv_homez_autocomplete_search_properties', 'homez_autocomplete_search_properties' );

function homez_autocomplete_search_properties() {
    // Query for suggestions
    $suggestions = array();
    $args = array(
		'post_type' => 'property',
		'posts_per_page' => 10,
		'fields' => 'ids'
	);
    $filter_params = isset($_REQUEST['data']) ? $_REQUEST['data'] : null;

	$properties = WP_RealEstate_Query::get_posts( $args, $filter_params );

	if ( !empty($properties->posts) ) {
		foreach ($properties->posts as $post_id) {
			$suggestion['title'] = get_the_title($post_id);
			$suggestion['url'] = get_permalink($post_id);

			if ( has_post_thumbnail( $post_id ) ) {
	            $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'thumbnail' );
	            $suggestion['image'] = $image[0];
	        } else {
	            $suggestion['image'] = homez_placeholder_img_src();
	        }
	        
	        $suggestion['price'] = homez_property_display_price($post_id, 'icon', false);

	        $post = get_post($post_id);
	        $meta_obj = WP_RealEstate_Property_Meta::get_instance($post_id);
            $beds = homez_property_display_meta($post, 'beds', '', false, $meta_obj->get_post_meta_title( 'beds' ));
            $baths = homez_property_display_meta($post, 'baths', '', false, $meta_obj->get_post_meta_title( 'baths' ));

            $suffix = wp_realestate_get_option('measurement_unit_area');
            $lot_area = homez_property_display_meta($post, 'lot_area', '', false, $suffix);

            ob_start();
            if ( $lot_area || $beds || $baths ) {
            ?>
                <div class="property-metas d-flex flex-wrap">
                    <?php
                        echo trim($beds);
                        echo trim($baths);
                        echo trim($lot_area);
                    ?>
                </div>
            <?php }
            $metas = ob_get_clean();
            $suggestion['metas'] = $metas;

        	$suggestions[] = $suggestion;
		}
		wp_reset_postdata();
	}
    echo json_encode( $suggestions );
 
    exit;
}


function homez_user_display_phone($phone, $display_type = 'no-title', $echo = true, $always_show_phone = false) {
    ob_start();
    if ( $phone ) {
        $show_full = homez_get_config('listing_show_full_phone', false);
        $hide_phone = $show_full ? false : true;
        $hide_phone = apply_filters('homez_phone_hide_number', $hide_phone );
        if ( $always_show_phone ) {
        	$hide_phone = false;
        }
        $add_class = '';
        if ( $hide_phone ) {
            $add_class = 'phone-hide';
        }
        if ( $display_type == 'title' ) {
            ?>
            <div class="phone-wrapper agent-phone with-title <?php echo esc_attr($add_class); ?>">
                <span><?php esc_html_e('Phone: ', 'homez'); ?></span>
            <?php
        } elseif ($display_type == 'icon') {
            ?>
            <div class="phone-wrapper agent-phone with-icon <?php echo esc_attr($add_class); ?>">
                <i class="ti-headphone-alt"></i>
        <?php
        } else {
            ?>
            <div class="phone-wrapper agent-phone <?php echo esc_attr($add_class); ?>">
            <?php
        }

        ?>
            <a class="phone" href="tel:<?php echo trim($phone); ?>"><?php echo trim($phone); ?></a>
            <?php if ( $hide_phone ) {
                $dispnum = substr($phone, 0, (strlen($phone)-3) ) . str_repeat("*", 3);
            ?>
                <span class="phone-show" onclick="this.parentNode.classList.add('show');"><?php echo trim($dispnum); ?> <span><?php esc_html_e('show', 'homez'); ?></span></span>
            <?php } ?>
        </div>
        <?php
    }
    $output = ob_get_clean();
    if ( $echo ) {
        echo trim($output);
    } else {
        return $output;
    }
}


add_action( 'wp_ajax_nopriv_homez_ajax_print_property', 'homez_ajax_print_property' );
add_action( 'wp_ajax_homez_ajax_print_property', 'homez_ajax_print_property' );

add_action( 'wre_ajax_homez_ajax_print_property', 'homez_ajax_print_property' );

function homez_ajax_print_property () {
	if ( !isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'homez-printer-property-nonce' )  ) {
		exit();
	}
	if( !isset($_POST['property_id'])|| !is_numeric($_POST['property_id']) ){
        exit();
    }

    $property_id = intval($_POST['property_id']);
    $the_post = get_post( $property_id );

    if( $the_post->post_type != 'property' || $the_post->post_status != 'publish' ) {
        exit();
    }
    setup_postdata( $GLOBALS['post'] =& $the_post );
    global $post;

    $dir = '';
    $body_class = '';
    if ( is_rtl() ) {
    	$dir = 'dir="rtl"';
    	$body_class = 'rtl';
    }

    print  '<html '.$dir.'><head><link href="'.get_stylesheet_uri().'" rel="stylesheet" type="text/css" />';
    if( is_rtl() ) {
    	print '<link href="'.get_template_directory_uri().'/css/bootstrap.rtl.css" rel="stylesheet" type="text/css" />';
    	print  '<html><head><link href="'.get_template_directory_uri().'/css/template.rtl.css" rel="stylesheet" type="text/css" />';
    } else {
	    print  '<html><head><link href="'.get_template_directory_uri().'/css/bootstrap.css" rel="stylesheet" type="text/css" />';
	    print  '<html><head><link href="'.get_template_directory_uri().'/css/template.css" rel="stylesheet" type="text/css" />';
	}
    print  '<html><head><link href="'.get_template_directory_uri().'/css/all-awesome.css" rel="stylesheet" type="text/css" />';
    print  '<html><head><link href="'.get_template_directory_uri().'/css/flaticon.css" rel="stylesheet" type="text/css" />';
    print  '<html><head><link href="'.get_template_directory_uri().'/css/themify-icons.css" rel="stylesheet" type="text/css" />';

    print '</head>';
    print '<script>window.onload = function() { window.print(); }</script>';
    print '<body class="'.$body_class.'">';

    $logo_url = homez_get_config('print-logo');
    if( isset($logo_url) && !empty($logo_url) ) {
    	$print_logo = $logo_url;
    } else {
    	$print_logo = get_template_directory_uri().'/images/logo.svg';
    }
    $title = get_the_title( $property_id );

    $image_id = get_post_thumbnail_id( $property_id );
    $full_img = wp_get_attachment_image_src($image_id, 'full');
    $full_img = $full_img [0];

    ?>

    <section id="section-body">
        <!--start detail content-->
        <section class="section-detail-content">
            <div class="detail-bar print-detail">
                
                <?php if ( homez_get_config('show_print_header', true) ) { ?>
	            	<div class="print-header-top">
	                    <div class="inner">
	                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="print-logo">
	                            <img src="<?php echo esc_url($print_logo); ?>" alt="<?php esc_attr_e('Logo', 'homez'); ?>">
	                            <span class="tag-line"><?php bloginfo( 'description' ); ?></span>
	                        </a>
	                    </div>
	                </div>
	            <?php } ?>

                <div class="print-header-middle">
                    <div class="print-header-middle-left">
                        <h1><?php echo esc_attr($title); ?></h1>
                        <?php homez_property_display_full_location($post,'no-icon-title',true); ?>
                    </div>
                    <div class="print-header-middle-right">
                        <?php homez_property_display_price($post); ?>
                    </div>
                </div>

                <?php if( !empty($full_img) ) { ?>
	                <div class="print-banner">
	                    <div class="print-main-image">
                            <img src="<?php echo esc_url( $full_img ); ?>" alt="<?php echo esc_attr($title); ?>">
                            <?php if ( homez_get_config('show_print_qrcode', true) ) { ?>
	                            <img class="qr-image" src="https://chart.googleapis.com/chart?chs=105x104&cht=qr&chl=<?php echo esc_url( get_permalink($property_id) ); ?>&choe=UTF-8" title="<?php echo esc_attr($title); ?>" />
	                        <?php } ?>
	                    </div>
	                </div>
                <?php } ?>
                <?php
                
                if ( homez_get_config('show_print_agent', true) ) {
                	$author_id = $post->post_author;
					$avatar = $a_phone = $a_website = $a_title = '';
					if ( WP_RealEstate_User::is_agency($author_id) ) {
						$agency_id = WP_RealEstate_User::get_agency_by_user_id($author_id);
						$agency_post = get_post($agency_id);
						$author_email = homez_agency_display_email($agency_post, 'no-title', false);
						
						$post_thumbnail_id = get_post_thumbnail_id($agency_id);
	            		$avatar = wp_get_attachment_image( $post_thumbnail_id, 'thumbnail' );

						$a_title = get_the_title($agency_id);
						$a_phone = homez_agency_display_phone($agency_post, 'no-title', false, true);
						$a_website = homez_agency_display_website($agent_post, 'no-title', false);
					} elseif ( WP_RealEstate_User::is_agent($author_id) ) {
						$agent_id = WP_RealEstate_User::get_agent_by_user_id($author_id);
						$agent_post = get_post($agent_id);
						$author_email = homez_agent_display_email($agent_post, 'no-title', false);

						$post_thumbnail_id = get_post_thumbnail_id($agent_id);
	            		$avatar = wp_get_attachment_image( $post_thumbnail_id, 'thumbnail' );

						$a_title = get_the_title($agent_id);
						$a_phone = homez_agent_display_phone($agent_post, 'no-title', false, true);
						$a_website = homez_agent_display_website($agent_post, 'no-title', false);
					} else {
						$user_id = $post->post_author;
						$author_email = get_the_author_meta('user_email');
						$a_title = get_the_author_meta('display_name');
						$a_phone = get_user_meta($user_id, '_phone', true);
						$a_phone = homez_user_display_phone($a_phone, 'no-title', false, true);
						$a_website = get_user_meta($user_id, '_url', true);
					}
            	?>
                    <div class="print-block">
                    	<h3><?php esc_html_e( 'Contact Agent', 'homez' ); ?></h3>
                        <div class="agent-media">
                            <div class="media-image-left">
                                <?php if ( !empty($avatar) ) {
									echo trim($avatar);
								} else {
							        echo homez_get_avatar($post->post_author, 180);
								} ?>
                            </div>
                            <div class="media-body-right">
                                
                                <h4 class="title"><?php echo trim($a_title); ?></h4>
								<div class="phone"><?php echo trim($a_phone); ?></div>
								<div class="email"><?php echo trim($author_email); ?></div>
								<div class="website"><?php echo trim($a_website); ?></div>

                            </div>
                        </div>
                    </div>
                <?php } ?>

                <div id="property-single-details">
					<?php
					if ( homez_get_config('show_print_description', true) ) {
						?>
						<div class="description inner">
						    <h3 class="title"><?php esc_html_e('Overview', 'homez'); ?></h3>
						    <div class="description-inner">
						        <?php the_content(); ?>
						        <?php do_action('wp-realestate-single-property-description', $post); ?>
						    </div>
						</div>
						<?php
					}
					
					if ( homez_get_config('show_print_energy', true) ) {
						echo WP_RealEstate_Template_Loader::get_template_part( 'single-property/energy' );
					}
					
					?>

					<?php
					if ( homez_get_config('show_print_detail', true) ) {
						echo WP_RealEstate_Template_Loader::get_template_part( 'single-property/detail' );
					}
					?>

				</div>

				<?php
				if ( homez_get_config('show_print_amenities', true) ) {
					echo WP_RealEstate_Template_Loader::get_template_part( 'single-property/amenities' );
				}
				?>

				<?php
				if ( homez_get_config('show_print_floor-plans', true) ) {
					echo WP_RealEstate_Template_Loader::get_template_part( 'single-property/floor-plans-print' );
				}
				?>
				
				<?php
				if ( homez_get_config('show_print_facilities', true) ) {
					echo WP_RealEstate_Template_Loader::get_template_part( 'single-property/facilities' );
				}
				?>

				<?php
				if ( homez_get_config('show_print_valuation', true) ) {
					echo WP_RealEstate_Template_Loader::get_template_part( 'single-property/valuation' );
				}

				$obj_property_meta = WP_RealEstate_Property_Meta::get_instance($post->ID);
				$gallery = $obj_property_meta->get_post_meta( 'gallery' );
				if ( homez_get_config('show_print_gallery', true) && $gallery ) {
				?>
					<div class="print-gallery">
						<div class="detail-title-inner">
                            <h4 class="title-inner"><?php esc_html_e('Property images', 'homez'); ?></h4>
                        </div>
                        <div class="row">
							<?php foreach ( $gallery as $id => $src ) { ?>
				                <div class="print-gallery-image col-12 col-sm-6">
				                    <?php echo wp_get_attachment_image( $id, 'full' ); ?>
				                </div>
			                <?php } ?>
		                </div>
		          	</div>
	          	<?php } ?>
				
            </div>
        </section>
    </section>


    <?php
    
    wp_reset_postdata();

    print '</body></html>';
    wp_die();
}


function homez_load_select2(){
	if ( version_compare(WP_REALESTATE_PLUGIN_VERSION, '1.5.3', '>=') ) {
		wp_enqueue_script('wre-select2');
		wp_enqueue_style('wre-select2');
	} else {
		wp_enqueue_script('select2');
		wp_enqueue_style('select2');
	}
}

function homez_get_properties_show_filter_top() {
	global $post;
	if ( is_page() && is_object($post) ) {
		$show_filter_top = get_post_meta( $post->ID, 'apus_page_properties_show_filter_top', true );
	}
	if ( empty($show_filter_top) ) {
		$show_filter_top = homez_get_config('properties_show_filter_top');
	} else {
		if ( $show_filter_top == 'yes' ) {
			$show_filter_top = true;
		} else {
			$show_filter_top = false;
		}
	}
	return apply_filters( 'homez_get_properties_show_filter_top', $show_filter_top );
}

function homez_get_properties_show_offcanvas_filter() {
	global $post;
	if ( is_page() && is_object($post) ) {
		$show_offcanvas_filter = get_post_meta( $post->ID, 'apus_page_properties_show_offcanvas_filter', true );
	}
	if ( empty($show_offcanvas_filter) ) {
		$show_offcanvas_filter = homez_get_config('properties_show_offcanvas_filter');
	} else {
		if ( $show_offcanvas_filter == 'yes' ) {
			$show_offcanvas_filter = true;
		} else {
			$show_offcanvas_filter = false;
		}
	}
	return apply_filters( 'homez_get_properties_show_offcanvas_filter', $show_offcanvas_filter );
}

function homez_get_properties_filter_sidebar() {
	global $post;
	if ( is_page() && is_object($post) ) {
		$properties_filter_sidebar = get_post_meta( $post->ID, 'apus_page_properties_filter_sidebar', true );
	}
	if ( empty($properties_filter_sidebar) ) {
		$properties_filter_sidebar = homez_get_config('properties_filter_sidebar', 'properties-filter-sidebar');
	}
	return apply_filters( 'homez_get_properties_filter_sidebar', $properties_filter_sidebar );
}

function homez_get_properties_filter_top_sidebar() {
	global $post;
	if ( is_page() && is_object($post) ) {
		$properties_filter_top_sidebar = get_post_meta( $post->ID, 'apus_page_properties_filter_top_sidebar', true );
	}
	if ( empty($properties_filter_top_sidebar) ) {
		$properties_filter_top_sidebar = homez_get_config('properties_filter_top_sidebar', 'properties-filter-top-sidebar');
	}
	return apply_filters( 'homez_get_properties_filter_top_sidebar', $properties_filter_top_sidebar );
}


add_action( 'wre_ajax_homez_ajax_send_a_schedule', 'homez_ajax_send_a_schedule' );
function homez_ajax_send_a_schedule() {
	if ( WP_RealEstate_Recaptcha::is_recaptcha_enabled() ) {
		$is_recaptcha_valid = array_key_exists( 'g-recaptcha-response', $_POST ) ? WP_RealEstate_Recaptcha::is_recaptcha_valid( sanitize_text_field( $_POST['g-recaptcha-response'] ) ) : false;
		if ( !$is_recaptcha_valid ) {
			$error = esc_html__( 'Captcha is not valid', 'homez' );

			echo json_encode(array('status' => false, 'msg' => $error));
			wp_die();
		}
	}

	$post_id = !empty($_POST['post_id']) ? $_POST['post_id'] : '';
	$date = !empty($_POST['date']) ? $_POST['date'] : '';
	$time = !empty($_POST['time']) ? $_POST['time'] : '';
	$name = !empty($_POST['name']) ? $_POST['name'] : '';
	$phone = !empty($_POST['phone']) ? $_POST['phone'] : '';
	$email = !empty($_POST['email']) ? $_POST['email'] : '';
	$message = !empty($_POST['message']) ? $_POST['message'] : '';
	if ( empty($post_id) || empty($date) || empty($time) || empty($name) || empty($phone) || empty($email) ) {
		echo json_encode(array('status' => false, 'msg' => esc_html__( 'Enter all data', 'homez' )));
		wp_die();
	}

	$property_title = get_post_field('post_title', $post_id);
	$property_url = get_permalink($post_id);

	$subject = wp_realestate_get_option('property_schedule_notice_subject');
	$subject = str_replace('{{property_title}}', $property_title, $subject);

	$content = wp_realestate_get_option('property_schedule_notice_content');
	$content = str_replace('{{property_title}}', $property_title, $content);
	$content = str_replace('{{property_url}}', $property_url, $content);
	$content = str_replace('{{date}}', $date, $content);
	$content = str_replace('{{time}}', $time, $content);
	$content = str_replace('{{name}}', $name, $content);
	$content = str_replace('{{phone}}', $phone, $content);
	$content = str_replace('{{email}}', $email, $content);
	$content = str_replace('{{message}}', $message, $content);

	$content = str_replace('{{website_name}}', get_bloginfo( 'name' ), $content);
	$content = str_replace('{{website_url}}', home_url(), $content);

	$headers = sprintf( "From: %s <%s>\r\n Content-type: text/html", get_bloginfo('name'), $email );
	
	$author_id = get_post_field('post_author', $post_id );
	if ( WP_RealEstate_User::is_agent($author_id) ) {
		$agent_id = WP_RealEstate_User::get_agent_by_user_id($author_id);
		$author_email = get_post_meta( $agent_id, WP_REALESTATE_AGENT_PREFIX.'email', true );
	} elseif ( WP_RealEstate_User::is_agency($author_id) ) {
		$agency_id = WP_RealEstate_User::get_agency_by_user_id($author_id);
		$author_email = get_post_meta( $agency_id, WP_REALESTATE_AGENCY_PREFIX.'email', true );
	} else {
		$author_email = get_the_author_meta( 'user_email' , $author_id );
	}
		
	$mail = call_user_func(array('WP_RealEstate_Email', implode('_', array('wp', 'mail'))), $author_email, $subject, $content, $headers );

	if( $mail ) {
		$success = esc_html__( 'Your message has been successfully sent.', 'homez' );
	} else {
		$error = esc_html__( 'An error occurred when sending an email.', 'homez' );						
	}

	if ( ! empty( $error ) ) {
		echo json_encode( array('status'=> false, 'msg'=> $error) );
	}

	if ( ! empty( $success ) ) {
		echo json_encode( array('status' => true, 'msg'=> $success ) );	
	}
	die();
}

add_filter( 'wp_realestate_settings_email_notification', 'homez_settings_email_notification', 10 );
function homez_settings_email_notification($fields) {
	// schedule form Property
	$fields[] = array(
		'name' => esc_html__( 'Property Schedule Form', 'homez' ),
		'desc' => '',
		'type' => 'wp_realestate_title',
		'id'   => 'wp_realestate_title_schedule_form_property',
		'before_row' => '<hr>',
		'after_row'  => '<hr>'
	);

	$fields[] = array(
		'name'    => esc_html__( 'Property Schedule Form Subject', 'homez' ),
		'desc'    => sprintf(esc_html__( 'Enter email subject. You can add variables: %s', 'homez' ), WP_RealEstate_Email::display_email_vars('property_schedule_notice', 'subject') ),
		'id'      => 'property_schedule_notice_subject',
		'type'    => 'text',
		'default' => esc_html__( 'Schedule Form', 'homez' ),
	);

	$fields[] = array(
		'name'    => esc_html__( 'Property Schedule Form Content', 'homez' ),
		'desc'    => sprintf(esc_html__( 'Enter email content. You can add variables: %s', 'homez' ), WP_RealEstate_Email::display_email_vars('property_schedule_notice', 'content') ),
		'id'      => 'property_schedule_notice_content',
		'type'    => 'wysiwyg',
		'default' => '',
	);

	return $fields;
}

add_filter( 'wp-realestate-emails-vars', 'homez_emails_vars', 10);
function homez_emails_vars($fields) {
	$fields['property_schedule_notice'] = array(
		'subject' => array( 'name', 'property_title' ),
		'content' => array( 'property_title', 'property_url', 'name', 'date', 'time', 'message', 'email', 'phone', 'website_url', 'website_name' )
	);

	return $fields;
}

add_filter('wp-realestate-property-stats-bg-color', 'homez_property_stats_bg_color');
add_filter('wp-realestate-property-stats-border-color', 'homez_property_stats_bg_color');
function homez_property_stats_bg_color($color) {
	if ( homez_get_config('main_color') != "" ) {
		$color = homez_get_config('main_color');
	} else {
		$color = '#0061DF';
	}
	return $color;
}

add_filter('wp-realestate-process-change-profile-normal-keys', 'homez_property_process_change_profile_normal_keys', 100);
function homez_property_process_change_profile_normal_keys($keys) {
	$keys[] = 'whatsapp';
	return $keys;
}

add_filter( 'wp-realestate-create-attachment-remove-image-sizes', 'homez_property_create_attachment_remove_image_sizes', 100);
function homez_property_create_attachment_remove_image_sizes($sizes) {
	$layout_type = homez_get_config('property_layout_type', 'v1');
	$sizes[] = 'large';
	$sizes[] = 'medium_large';
	$sizes[] = 'medium';
	$sizes[] = 'homez-agent-grid';
	return $sizes;
}

function homez_filter_field_location_select($instance, $args, $key, $field) {
	$name = WP_RealEstate_Abstract_Filter::filter_get_name($key, $field);
    $selected = !empty( $_GET[$name] ) ? $_GET[$name] : '';

    include WP_RealEstate_Template_Loader::locate( 'widgets/filter-fields/number_choose' );
}


add_filter( 'wp_realestate_display_field_data', 'homez_display_hook_custom_field_data', 10, 6 );
function homez_display_hook_custom_field_data($html, $custom_field, $post, $field_name, $output_value, $current_hook) {
	if ( $current_hook === 'wp-realestate-single-property-details' ) {
		ob_start();
        ?>
        <li class="d-flex align-items-center">
            <?php if ( $field_name ) { ?>
                <div class="text flex-shrink-0"><?php echo trim($field_name); ?>:</div>
            <?php } ?>
            <div class="value flex-grow-1"><?php echo trim($output_value); ?></div>
        </li>
        <?php
        $html = ob_get_clean();
    }

    return $html;
}

// demo function
function homez_check_demo_account() {
	if ( defined('HOMEZ_DEMO_MODE') && HOMEZ_DEMO_MODE ) {
		$user_id = get_current_user_id();
		$user_obj = get_user_by('ID', $user_id);
		if ( strtolower($user_obj->data->user_login) == 'agency' || strtolower($user_obj->data->user_login) == 'agent' ) {
			$return = array( 'status' => false, 'msg' => esc_html__('Demo users are not allowed to modify information.', 'homez') );
		   	echo wp_json_encode($return);
		   	exit;
		}
	}
}

add_action('wp-realestate-process-forgot-password', 'homez_check_demo_account', 10);
add_action('wp-realestate-process-change-password', 'homez_check_demo_account', 10);
add_action('wp-realestate-before-delete-profile', 'homez_check_demo_account', 10);
add_action('wp-realestate-before-remove-property-alert', 'homez_check_demo_account', 10 );
add_action('wp-realestate-before-change-profile-normal', 'homez_check_demo_account', 10 );
add_action('wp-realestate-process-add-agent', 'homez_check_demo_account', 10 );
add_action('wp-realestate-process-remove-agent', 'homez_check_demo_account', 10 );
add_action('wp-realestate-process-remove-before-save', 'homez_check_demo_account', 10);

function homez_check_demo_account2($error) {
	if ( defined('HOMEZ_DEMO_MODE') && HOMEZ_DEMO_MODE ) {
		$user_id = get_current_user_id();
		$user_obj = get_user_by('ID', $user_id);
		if ( strtolower($user_obj->data->user_login) == 'agency' || strtolower($user_obj->data->user_login) == 'agent' ) {
			$error[] = esc_html__('Demo users are not allowed to modify information.', 'homez');
		}
	}
	return $error;
}
add_filter('wp-realestate-submission-validate', 'homez_check_demo_account2', 10, 2);
add_filter('wp-realestate-edit-validate', 'homez_check_demo_account2', 10, 2);

function homez_check_demo_account3($post_id, $prefix) {
	if ( defined('HOMEZ_DEMO_MODE') && HOMEZ_DEMO_MODE ) {
		$user_id = get_current_user_id();
		$user_obj = get_user_by('ID', $user_id);
		if ( strtolower($user_obj->data->user_login) == 'agency' || strtolower($user_obj->data->user_login) == 'agent' ) {
			$_SESSION['messages'][] = array( 'danger', esc_html__('Demo users are not allowed to modify information.', 'homez') );
			$redirect_url = get_permalink( wp_realestate_get_option('edit_profile_page_id') );
			WP_RealEstate_Mixes::redirect( $redirect_url );
			exit();
		}
	}
}
add_action('wp-realestate-process-profile-before-change', 'homez_check_demo_account3', 10, 2);

function homez_check_demo_account4() {
	if ( defined('HOMEZ_DEMO_MODE') && HOMEZ_DEMO_MODE ) {
		$user_id = get_current_user_id();
		$user_obj = get_user_by('ID', $user_id);
		if ( strtolower($user_obj->data->user_login) == 'agency' || strtolower($user_obj->data->user_login) == 'agent' ) {
			$return['msg'] = esc_html__('Demo users are not allowed to modify information.', 'homez');
			$return['status'] = false;
			echo json_encode($return); exit;
		}
	}
}
add_action('wp-private-message-before-reply-message', 'homez_check_demo_account4');
add_action('wp-private-message-before-add-message', 'homez_check_demo_account4');
add_action('wp-private-message-before-delete-message', 'homez_check_demo_account4');