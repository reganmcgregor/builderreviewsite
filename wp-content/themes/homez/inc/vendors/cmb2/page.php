<?php

if ( !function_exists( 'homez_page_metaboxes' ) ) {
	function homez_page_metaboxes(array $metaboxes) {
		global $wp_registered_sidebars;
        $sidebars = array();

        if ( !empty($wp_registered_sidebars) ) {
            foreach ($wp_registered_sidebars as $sidebar) {
                $sidebars[$sidebar['id']] = $sidebar['name'];
            }
        }
        $headers = array_merge( array('global' => esc_html__( 'Global Setting', 'homez' )), homez_get_header_layouts() );
        $footers = array_merge( array('global' => esc_html__( 'Global Setting', 'homez' )), homez_get_footer_layouts() );

		$prefix = 'apus_page_';

        $columns = array(
            '' => esc_html__( 'Global Setting', 'homez' ),
            '1' => esc_html__('1 Column', 'homez'),
            '2' => esc_html__('2 Columns', 'homez'),
            '3' => esc_html__('3 Columns', 'homez'),
            '4' => esc_html__('4 Columns', 'homez'),
            '6' => esc_html__('6 Columns', 'homez')
        );

        // Properties Page
        $fields = array(
            array(
                'name' => esc_html__( 'Properties Layout', 'homez' ),
                'id'   => $prefix.'layout_type',
                'type' => 'select',
                'options' => array(
                    '' => esc_html__( 'Global Setting', 'homez' ),
                    'default' => esc_html__('Default', 'homez'),
                    'half-map' => esc_html__('Half Map - v1', 'homez'),
                    'half-map-v2' => esc_html__('Half Map - v2', 'homez'),
                    'half-map-v3' => esc_html__('Half Map - v3', 'homez'),
                    'top-map' => esc_html__('Top Map', 'homez'),
                )
            ),
            array(
                'id' => $prefix.'display_mode',
                'type' => 'select',
                'name' => esc_html__('Default Display Mode', 'homez'),
                'options' => array(
                    '' => esc_html__( 'Global Setting', 'homez' ),
                    'grid' => esc_html__('Grid', 'homez'),
                    'list' => esc_html__('List', 'homez'),
                )
            ),
            array(
                'id' => $prefix.'inner_list_style',
                'type' => 'select',
                'name' => esc_html__('Properties list style', 'homez'),
                'options' => array(
                    '' => esc_html__( 'Global Setting', 'homez' ),
                    'list' => esc_html__('List Default', 'homez'),
                ),
            ),
            array(
                'id' => $prefix.'inner_grid_style',
                'type' => 'select',
                'name' => esc_html__('Properties grid style', 'homez'),
                'options' => array(
                    '' => esc_html__( 'Global Setting', 'homez' ),
                    'grid' => esc_html__('Grid Default', 'homez'),
                    'grid-v1' => esc_html__('Grid V1', 'homez'),
                    'grid-v2' => esc_html__('Grid V2', 'homez'),
                    'grid-v3' => esc_html__('Grid V3', 'homez'),
                    'grid-v4' => esc_html__('Grid V4', 'homez'),
                    'grid-v5' => esc_html__('Grid V5', 'homez'),
                    'grid-v6' => esc_html__('Grid V6', 'homez'),
                    'grid-v7' => esc_html__('Grid V7', 'homez'),
                    'grid-v8' => esc_html__('Grid V8', 'homez'),
                    'grid-v9' => esc_html__('Grid V9', 'homez'),
                    'grid-v10' => esc_html__('Grid V10', 'homez'),
                    'list' => esc_html__('List Default', 'homez'),
                ),
            ),
            array(
                'id' => $prefix.'properties_columns',
                'type' => 'select',
                'name' => esc_html__('Grid Listing Columns', 'homez'),
                'options' => $columns,
            ),
            array(
                'id' => $prefix.'properties_pagination',
                'type' => 'select',
                'name' => esc_html__('Pagination Type', 'homez'),
                'options' => array(
                    '' => esc_html__( 'Global Setting', 'homez' ),
                    'default' => esc_html__('Default', 'homez'),
                    'loadmore' => esc_html__('Load More Button', 'homez'),
                    'infinite' => esc_html__('Infinite Scrolling', 'homez'),
                ),
            ),

            array(
                'id' => $prefix.'properties_show_filter_top',
                'type' => 'select',
                'name' => esc_html__('Show Filter Top', 'homez'),
                'options' => array(
                    '' => esc_html__( 'Global Setting', 'homez' ),
                    'no' => esc_html__('No', 'homez'),
                    'yes' => esc_html__('Yes', 'homez')
                ),
            ),
            array(
                'id' => $prefix.'properties_filter_top_sidebar',
                'type' => 'select',
                'name' => esc_html__('Properties Filter Top Sidebar', 'homez'),
                'description' => esc_html__('Choose a filter top sidebar for your website.', 'homez'),
                'options' => array(
                    '' => esc_html__('Global Setting', 'homez'),
                    'properties-filter-top' => esc_html__('Properties Filter Top Sidebar', 'homez'),
                    'properties-filter-top2' => esc_html__('Properties Filter Top 2 Sidebar', 'homez'),
                ),
                'default' => ''
            ),

            array(
                'id' => $prefix.'properties_show_offcanvas_filter',
                'type' => 'select',
                'name' => esc_html__('Show Offcanvas Filter', 'homez'),
                'options' => array(
                    '' => esc_html__( 'Global Setting', 'homez' ),
                    'no' => esc_html__('No', 'homez'),
                    'yes' => esc_html__('Yes', 'homez')
                ),
            ),

            array(
                'id' => $prefix.'properties_filter_sidebar',
                'type' => 'select',
                'name' => esc_html__('Properties Filter Sidebar', 'homez'),
                'description' => esc_html__('Choose a filter sidebar for your website.', 'homez'),
                'options' => array(
                    '' => esc_html__('Global Setting', 'homez'),
                    'properties-filter' => esc_html__('Properties Filter Sidebar', 'homez'),
                    'properties-filter2' => esc_html__('Properties Filter 2 Sidebar', 'homez'),
                    'properties-filter3' => esc_html__('Properties Filter 3 Sidebar', 'homez'),
                ),
                'default' => ''
            ),
        );
        
        $metaboxes[$prefix . 'properties_setting'] = array(
            'id'                        => $prefix . 'properties_setting',
            'title'                     => esc_html__( 'Properties Settings', 'homez' ),
            'object_types'              => array( 'page' ),
            'context'                   => 'normal',
            'priority'                  => 'high',
            'show_names'                => true,
            'fields'                    => $fields
        );


        // Agents Page
        $fields = array(
            array(
                'id' => $prefix.'agents_columns',
                'type' => 'select',
                'name' => esc_html__('Agent Columns', 'homez'),
                'options' => $columns,
                'description' => esc_html__('Apply for display mode is grid and simple.', 'homez'),
            ),
            array(
                'id' => $prefix.'agents_display_mode',
                'type' => 'select',
                'name' => esc_html__('Default Display Mode', 'homez'),
                'options' => array(
                    '' => esc_html__( 'Global Setting', 'homez' ),
                    'grid' => esc_html__('Grid', 'homez'),
                    'list' => esc_html__('List', 'homez'),
                )
            ),
            array(
                'id' => $prefix.'agents_pagination',
                'type' => 'select',
                'name' => esc_html__('Pagination Type', 'homez'),
                'options' => array(
                    '' => esc_html__( 'Global Setting', 'homez' ),
                    'default' => esc_html__('Default', 'homez'),
                    'loadmore' => esc_html__('Load More Button', 'homez'),
                    'infinite' => esc_html__('Infinite Scrolling', 'homez'),
                ),
            ),
        );
        $metaboxes[$prefix . 'agents_setting'] = array(
            'id'                        => $prefix . 'agents_setting',
            'title'                     => esc_html__( 'Agents Settings', 'homez' ),
            'object_types'              => array( 'page' ),
            'context'                   => 'normal',
            'priority'                  => 'high',
            'show_names'                => true,
            'fields'                    => $fields
        );

        // Agencies Page
        $fields = array(
            array(
                'id' => $prefix.'agencies_columns',
                'type' => 'select',
                'name' => esc_html__('Agency Columns', 'homez'),
                'options' => $columns,
                'description' => esc_html__('Apply for display mode is grid.', 'homez'),
            ),
            array(
                'id' => $prefix.'agencies_display_mode',
                'type' => 'select',
                'name' => esc_html__('Default Display Mode', 'homez'),
                'options' => array(
                    '' => esc_html__( 'Global Setting', 'homez' ),
                    'grid' => esc_html__('Grid', 'homez'),
                    'list' => esc_html__('List', 'homez'),
                )
            ),
            array(
                'id' => $prefix.'agencies_pagination',
                'type' => 'select',
                'name' => esc_html__('Pagination Type', 'homez'),
                'options' => array(
                    '' => esc_html__( 'Global Setting', 'homez' ),
                    'default' => esc_html__('Default', 'homez'),
                    'loadmore' => esc_html__('Load More Button', 'homez'),
                    'infinite' => esc_html__('Infinite Scrolling', 'homez'),
                ),
            ),
        );
        $metaboxes[$prefix . 'agencies_setting'] = array(
            'id'                        => $prefix . 'agencies_setting',
            'title'                     => esc_html__( 'Agencies Settings', 'homez' ),
            'object_types'              => array( 'page' ),
            'context'                   => 'normal',
            'priority'                  => 'high',
            'show_names'                => true,
            'fields'                    => $fields
        );

        // General
	    $fields = array(
			array(
				'name' => esc_html__( 'Select Layout', 'homez' ),
				'id'   => $prefix.'layout',
				'type' => 'select',
				'options' => array(
					'main' => esc_html__('Main Content Only', 'homez'),
					'left-main' => esc_html__('Left Sidebar - Main Content', 'homez'),
					'main-right' => esc_html__('Main Content - Right Sidebar', 'homez')
				)
			),
			array(
                'id' => $prefix.'fullwidth',
                'type' => 'select',
                'name' => esc_html__('Is Full Width?', 'homez'),
                'default' => 'no',
                'options' => array(
                    'no' => esc_html__('No', 'homez'),
                    'yes' => esc_html__('Yes', 'homez')
                )
            ),
            array(
                'id' => $prefix.'left_sidebar',
                'type' => 'select',
                'name' => esc_html__('Left Sidebar', 'homez'),
                'options' => $sidebars
            ),
            array(
                'id' => $prefix.'right_sidebar',
                'type' => 'select',
                'name' => esc_html__('Right Sidebar', 'homez'),
                'options' => $sidebars
            ),
            array(
                'id' => $prefix.'show_breadcrumb',
                'type' => 'select',
                'name' => esc_html__('Show Breadcrumb?', 'homez'),
                'options' => array(
                    'no' => esc_html__('No', 'homez'),
                    'yes' => esc_html__('Yes', 'homez')
                ),
                'default' => 'yes',
            ),
            array(
                'id' => $prefix.'breadcrumb_text_color',
                'type' => 'colorpicker',
                'name' => esc_html__('Breadcrumb Color ( with background color )', 'homez')
            ),
            array(
                'id' => $prefix.'breadcrumb_color',
                'type' => 'colorpicker',
                'name' => esc_html__('Breadcrumb Background Color', 'homez')
            ),
            array(
                'id' => $prefix.'breadcrumb_image',
                'type' => 'file',
                'name' => esc_html__('Breadcrumb Background Image', 'homez')
            ),

            array(
                'id' => $prefix.'header_type',
                'type' => 'select',
                'name' => esc_html__('Header Layout Type', 'homez'),
                'description' => esc_html__('Choose a header for your website.', 'homez'),
                'options' => $headers,
                'default' => 'global'
            ),
            array(
                'id' => $prefix.'header_transparent',
                'type' => 'select',
                'name' => esc_html__('Header Transparent', 'homez'),
                'description' => esc_html__('Choose a header for your website.', 'homez'),
                'options' => array(
                    'no' => esc_html__('No', 'homez'),
                    'yes' => esc_html__('Yes', 'homez')
                ),
                'default' => 'global'
            ),
            array(
                'id' => $prefix.'header_fixed',
                'type' => 'select',
                'name' => esc_html__('Header Fixed Top', 'homez'),
                'description' => esc_html__('Choose a header position', 'homez'),
                'options' => array(
                    'no' => esc_html__('No', 'homez'),
                    'yes' => esc_html__('Yes', 'homez')
                ),
                'default' => 'no'
            ),
            array(
                'id' => $prefix.'footer_type',
                'type' => 'select',
                'name' => esc_html__('Footer Layout Type', 'homez'),
                'description' => esc_html__('Choose a footer for your website.', 'homez'),
                'options' => $footers,
                'default' => 'global'
            ),
            array(
                'id' => $prefix.'extra_class',
                'type' => 'text',
                'name' => esc_html__('Extra Class', 'homez'),
                'description' => esc_html__('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'homez')
            )
    	);
		
	    $metaboxes[$prefix . 'display_setting'] = array(
			'id'                        => $prefix . 'display_setting',
			'title'                     => esc_html__( 'Display Settings', 'homez' ),
			'object_types'              => array( 'page' ),
			'context'                   => 'normal',
			'priority'                  => 'high',
			'show_names'                => true,
			'fields'                    => $fields
		);

        $prefix = 'apus_product_';
        // Properties Page
        $fields = array(
            array(
                'name'    => esc_html__( 'Package Icon', 'homez' ),
                'id'      => $prefix . 'package_icon',
                'type'    => 'file',
                'text'    => array(
                    'add_upload_file_text' => esc_html__( 'Add Icon', 'homez' ),
                ),
                'query_args' => array(
                    'type' => array(
                        'image/gif',
                        'image/jpeg',
                        'image/png',
                    ),
                ),
                'preview_size' => 'large', // Image size to use when previewing in the admin
            )
        );
        $metaboxes[$prefix . 'package_setting'] = array(
            'id'                        => $prefix . 'package_setting',
            'title'                     => esc_html__( 'Package Settings', 'homez' ),
            'object_types'              => array( 'product' ),
            'context'                   => 'normal',
            'priority'                  => 'high',
            'show_names'                => true,
            'fields'                    => $fields
        );

	    return $metaboxes;
	}
}
add_filter( 'cmb2_meta_boxes', 'homez_page_metaboxes' );

if ( !function_exists( 'homez_cmb2_style' ) ) {
	function homez_cmb2_style() {
        wp_enqueue_style( 'homez-cmb2-style', get_template_directory_uri() . '/inc/vendors/cmb2/assets/style.css', array(), '1.0' );
		wp_enqueue_script( 'homez-admin', get_template_directory_uri() . '/js/admin.js', array( 'jquery' ), '20150330', true );
	}
}
add_action( 'admin_enqueue_scripts', 'homez_cmb2_style' );


