<?php

function homez_realestate_customize_property_register( $wp_customize ) {
    global $wp_registered_sidebars;
    $sidebars = array();

    if ( is_admin() && !empty($wp_registered_sidebars) ) {
        foreach ($wp_registered_sidebars as $sidebar) {
            $sidebars[$sidebar['id']] = $sidebar['name'];
        }
    }

    $columns = array( '1' => esc_html__('1 Column', 'homez'),
        '2' => esc_html__('2 Columns', 'homez'),
        '3' => esc_html__('3 Columns', 'homez'),
        '4' => esc_html__('4 Columns', 'homez'),
        '5' => esc_html__('5 Columns', 'homez'),
        '6' => esc_html__('6 Columns', 'homez'),
        '7' => esc_html__('7 Columns', 'homez'),
        '8' => esc_html__('8 Columns', 'homez'),
    );

    // Properties Panel
    $wp_customize->add_panel( 'homez_settings_property', array(
        'title' => esc_html__( 'Properties Settings', 'homez' ),
        'priority' => 4,
    ) );

    // General Section
    $wp_customize->add_section('homez_settings_properties_general', array(
        'title'    => esc_html__('General', 'homez'),
        'priority' => 1,
        'panel' => 'homez_settings_property',
    ));

    // Breadcrumbs Setting ?
    $wp_customize->add_setting('homez_theme_options[property_breadcrumbs_setting]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control( new Homez_WP_Customize_Heading_Control($wp_customize, 'property_breadcrumbs_setting', array(
        'label'    => esc_html__('Breadcrumbs Settings', 'homez'),
        'section'  => 'homez_settings_properties_general',
        'settings' => 'homez_theme_options[property_breadcrumbs_setting]',
    )));

    // Breadcrumbs
    $wp_customize->add_setting('homez_theme_options[show_property_breadcrumbs]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'default'    => 1,
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('homez_theme_options_show_property_breadcrumbs', array(
        'settings' => 'homez_theme_options[show_property_breadcrumbs]',
        'label'    => esc_html__('Breadcrumbs', 'homez'),
        'section'  => 'homez_settings_properties_general',
        'type'     => 'checkbox',
    ));

    // Breadcrumbs Background Color
    $wp_customize->add_setting('homez_theme_options[property_breadcrumb_color]', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_hex_color',
        'capability'        => 'edit_theme_options',
        'type'           => 'option',
    ));

    $wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'property_breadcrumb_color', array(
        'label'    => esc_html__('Breadcrumbs Background Color', 'homez'),
        'section'  => 'homez_settings_properties_general',
        'settings' => 'homez_theme_options[property_breadcrumb_color]',
    )));

    // Breadcrumbs Background
    $wp_customize->add_setting('homez_theme_options[property_breadcrumb_image]', array(
        'default'           => '',
        'capability'        => 'edit_theme_options',
        'type'           => 'option',
        'sanitize_callback' => 'sanitize_text_field',

    ));

    $wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, 'property_breadcrumb_image', array(
        'label'    => esc_html__('Breadcrumbs Background', 'homez'),
        'section'  => 'homez_settings_properties_general',
        'settings' => 'homez_theme_options[property_breadcrumb_image]',
    )));

    // Other Setting ?
    $wp_customize->add_setting('homez_theme_options[property_other_setting]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control( new Homez_WP_Customize_Heading_Control($wp_customize, 'property_other_setting', array(
        'label'    => esc_html__('Other Settings', 'homez'),
        'section'  => 'homez_settings_properties_general',
        'settings' => 'homez_theme_options[property_other_setting]',
    )));
    
    // Show Full Phone Number
    $wp_customize->add_setting('homez_theme_options[listing_show_full_phone]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'default'    => '0',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('homez_theme_options_listing_show_full_phone', array(
        'settings' => 'homez_theme_options[listing_show_full_phone]',
        'label'    => esc_html__('Show Full Phone Number', 'homez'),
        'section'  => 'homez_settings_properties_general',
        'type'     => 'checkbox',
    ));

    // Enable Favorite
    $wp_customize->add_setting('homez_theme_options[listing_enable_favorite]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'default'    => '1',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('homez_theme_options_listing_enable_favorite', array(
        'settings' => 'homez_theme_options[listing_enable_favorite]',
        'label'    => esc_html__('Enable Favorite', 'homez'),
        'section'  => 'homez_settings_properties_general',
        'type'     => 'checkbox',
    ));

    // Enable Compare
    $wp_customize->add_setting('homez_theme_options[listing_enable_compare]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'default'    => '1',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('homez_theme_options_listing_enable_compare', array(
        'settings' => 'homez_theme_options[listing_enable_compare]',
        'label'    => esc_html__('Enable Compare', 'homez'),
        'section'  => 'homez_settings_properties_general',
        'type'     => 'checkbox',
    ));



    // Property Archives
    $wp_customize->add_section('homez_settings_property_archive', array(
        'title'    => esc_html__('Property Archives', 'homez'),
        'priority' => 2,
        'panel' => 'homez_settings_property',
    ));

    // General Setting ?
    $wp_customize->add_setting('homez_theme_options[listings_general_setting]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control( new Homez_WP_Customize_Heading_Control($wp_customize, 'listings_general_setting', array(
        'label'    => esc_html__('General Settings', 'homez'),
        'section'  => 'homez_settings_property_archive',
        'settings' => 'homez_theme_options[listings_general_setting]',
    )));

    // Is Full Width
    $wp_customize->add_setting('homez_theme_options[properties_fullwidth]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('homez_theme_options_properties_fullwidth', array(
        'settings' => 'homez_theme_options[properties_fullwidth]',
        'label'    => esc_html__('Is Full Width', 'homez'),
        'section'  => 'homez_settings_property_archive',
        'type'     => 'checkbox',
    ));

    // layout
    $wp_customize->add_setting( 'homez_theme_options[properties_layout_type]', array(
        'default'        => 'default',
        'type'           => 'option',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'homez_settings_property_archive_layout', array(
        'label'   => esc_html__('Properties Layout Style', 'homez'),
        'section' => 'homez_settings_property_archive',
        'type'    => 'select',
        'choices' => array(
            'default' => esc_html__('Default', 'homez'),
            'half-map' => esc_html__('Half Map - v1', 'homez'),
            'half-map-v2' => esc_html__('Half Map - v2', 'homez'),
            'half-map-v3' => esc_html__('Half Map - v3', 'homez'),
            'top-map' => esc_html__('Top Map', 'homez'),
        ),
        'settings' => 'homez_theme_options[properties_layout_type]',
        'description' => esc_html__('Select the variation you want to apply on your properties.', 'homez'),
    ) );

    // layout
    $wp_customize->add_setting( 'homez_theme_options[properties_layout_sidebar]', array(
        'default'        => 'left-main',
        'type'           => 'option',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( new Homez_WP_Customize_Radio_Image_Control( 
        $wp_customize, 
        'apus_settings_properties_layout_sidebar', 
        array(
            'label'   => esc_html__('Layout Type', 'homez'),
            'section' => 'homez_settings_property_archive',
            'type'    => 'select',
            'choices' => array(
                'main' => array(
                    'title' => esc_html__('Main Only', 'homez'),
                    'img' => get_template_directory_uri() . '/inc/assets/images/screen1.png'
                ),
                'left-main' => array(
                    'title' => esc_html__('Left - Main Sidebar', 'homez'),
                    'img' => get_template_directory_uri() . '/inc/assets/images/screen2.png'
                ),
                'main-right' => array(
                    'title' => esc_html__('Main - Right Sidebar', 'homez'),
                    'img' => get_template_directory_uri() . '/inc/assets/images/screen3.png'
                ),
            ),
            'settings' => 'homez_theme_options[properties_layout_sidebar]',
            'description' => wp_kses(__('Select a sidebar layout for layout type <strong>"Default", "Top Map"</strong>.', 'homez'), array('strong' => array())),
        ) 
    ));


    // Show Filter Top
    $wp_customize->add_setting('homez_theme_options[properties_show_filter_top]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('homez_theme_options_properties_show_filter_top', array(
        'settings' => 'homez_theme_options[properties_show_filter_top]',
        'label'    => esc_html__('Show Filter Top', 'homez'),
        'section'  => 'homez_settings_property_archive',
        'type'     => 'checkbox',
    ));

    // Properties Filter Top Sidebar
    $wp_customize->add_setting( 'homez_theme_options[properties_filter_top_sidebar]', array(
        'default'        => 'listings-filter-top',
        'type'           => 'option',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'homez_settings_property_archive_filter_top_sidebar', array(
        'label'   => esc_html__('Properties Filter Top Sidebar', 'homez'),
        'section' => 'homez_settings_property_archive',
        'type'    => 'select',
        'choices' => array(
            'listings-filter-top' => esc_html__('Properties Filter Top', 'homez'),
            'listings-filter-top2' => esc_html__('Properties Filter Top 2', 'homez'),
            'listings-filter-top-map' => esc_html__('Properties Filter Top Map', 'homez'),
        ),
        'settings' => 'homez_theme_options[properties_filter_top_sidebar]',
    ) );

    // Properties Filter Sidebar
    $wp_customize->add_setting( 'homez_theme_options[properties_filter_sidebar]', array(
        'default'        => 'properties-filter',
        'type'           => 'option',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'homez_settings_property_archive_properties_filter_sidebar', array(
        'label'   => esc_html__('Properties Filter Sidebar', 'homez'),
        'section' => 'homez_settings_property_archive',
        'type'    => 'select',
        'choices' => array(
            'properties-filter' => esc_html__('Properties Filter Sidebar', 'homez'),
            'properties-filter2' => esc_html__('Properties Filter Sidebar 2', 'homez'),
            'properties-filter3' => esc_html__('Properties Filter 3 Sidebar', 'homez'),
        ),
        'settings' => 'homez_theme_options[properties_filter_sidebar]',
    ) );



    // Display Mode
    $wp_customize->add_setting( 'homez_theme_options[properties_display_mode]', array(
        'default'        => 'grid',
        'type'           => 'option',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'homez_settings_property_archive_properties_display_mode', array(
        'label'   => esc_html__('Display Mode', 'homez'),
        'section' => 'homez_settings_property_archive',
        'type'    => 'select',
        'choices' => array(
            'grid' => esc_html__('Grid', 'homez'),
            'list' => esc_html__('List', 'homez'),
        ),
        'settings' => 'homez_theme_options[properties_display_mode]',
    ) );

    // Properties List Style
    $wp_customize->add_setting( 'homez_theme_options[properties_inner_list_style]', array(
        'default'        => 'grid',
        'type'           => 'option',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'homez_settings_property_archive_properties_inner_list_style', array(
        'label'   => esc_html__('Properties List Style', 'homez'),
        'section' => 'homez_settings_property_archive',
        'type'    => 'select',
        'choices' => array(
            'list' => esc_html__('List style default', 'homez'),
        ),
        'settings' => 'homez_theme_options[properties_inner_list_style]',
    ) );

    // Properties List Style
    $wp_customize->add_setting( 'homez_theme_options[properties_inner_grid_style]', array(
        'default'        => 'grid',
        'type'           => 'option',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'homez_settings_property_archive_properties_inner_grid_style', array(
        'label'   => esc_html__('Properties Grid Style', 'homez'),
        'section' => 'homez_settings_property_archive',
        'type'    => 'select',
        'choices' => array(
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
        'settings' => 'homez_theme_options[properties_inner_grid_style]',
    ) );

    // Grid Columns
    $wp_customize->add_setting( 'homez_theme_options[properties_columns]', array(
        'default'        => '3',
        'type'           => 'option',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'homez_settings_property_archive_properties_columns', array(
        'label'   => esc_html__('Properties Grid Columns', 'homez'),
        'section' => 'homez_settings_property_archive',
        'type'    => 'select',
        'choices' => $columns,
        'settings' => 'homez_theme_options[properties_columns]',
    ) );

    // Pagination
    $wp_customize->add_setting( 'homez_theme_options[properties_pagination]', array(
        'default'        => 'default',
        'type'           => 'option',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'homez_settings_property_archive_properties_pagination', array(
        'label'   => esc_html__('Properties Pagination', 'homez'),
        'section' => 'homez_settings_property_archive',
        'type'    => 'select',
        'choices' => array(
            'default' => esc_html__('Default', 'homez'),
            'loadmore' => esc_html__('Load More Button', 'homez'),
            'infinite' => esc_html__('Infinite Scrolling', 'homez'),
        ),
        'settings' => 'homez_theme_options[properties_pagination]',
    ) );

    // Placeholder Image
    $wp_customize->add_setting('homez_theme_options[property_placeholder_image]', array(
        'default'           => '',
        'capability'        => 'edit_theme_options',
        'type'           => 'option',
        'sanitize_callback' => 'sanitize_text_field',

    ));

    $wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, 'property_placeholder_image', array(
        'label'    => esc_html__('Placeholder Image', 'homez'),
        'section'  => 'homez_settings_property_general',
        'settings' => 'homez_theme_options[property_placeholder_image]',
    )));




    // Single Property
    $wp_customize->add_section('homez_settings_property_single', array(
        'title'    => esc_html__('Property Single', 'homez'),
        'priority' => 3,
        'panel' => 'homez_settings_property',
    ));

    // General Setting ?
    $wp_customize->add_setting('homez_theme_options[listing_single_general_setting]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control( new Homez_WP_Customize_Heading_Control($wp_customize, 'listing_single_general_setting', array(
        'label'    => esc_html__('General Settings', 'homez'),
        'section'  => 'homez_settings_property_single',
        'settings' => 'homez_theme_options[listing_single_general_setting]',
    )));

    // Is Full Width
    $wp_customize->add_setting('homez_theme_options[property_fullwidth]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('homez_theme_options_property_fullwidth', array(
        'settings' => 'homez_theme_options[property_fullwidth]',
        'label'    => esc_html__('Is Full Width', 'homez'),
        'section'  => 'homez_settings_property_single',
        'type'     => 'checkbox',
    ));

    // Property Layout
    $wp_customize->add_setting( 'homez_theme_options[property_layout_type]', array(
        'default'        => 'v1',
        'type'           => 'option',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'homez_settings_property_single_property_layout_type', array(
        'label'   => esc_html__('Property Layout', 'homez'),
        'section' => 'homez_settings_property_single',
        'type'    => 'select',
        'choices' => array(
            'v1' => esc_html__('Layout 1', 'homez'),
            'v2' => esc_html__('Layout 2', 'homez'),
            'v3' => esc_html__('Layout 3', 'homez'),
            'v4' => esc_html__('Layout 4', 'homez'),
            'v5' => esc_html__('Layout 5', 'homez'),
            'v6' => esc_html__('Layout 6', 'homez'),
            'v7' => esc_html__('Layout 7', 'homez'),
            'v8' => esc_html__('Layout 8', 'homez'),
            'v9' => esc_html__('Layout 9', 'homez'),
            'v10' => esc_html__('Layout 10', 'homez'),
        ),
        'settings' => 'homez_theme_options[property_layout_type]',
    ) );

    // Show Social Share
    $wp_customize->add_setting('homez_theme_options[show_property_social_share]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'default'       => '1',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('homez_theme_options_show_property_social_share', array(
        'settings' => 'homez_theme_options[show_property_social_share]',
        'label'    => esc_html__('Show Social Share', 'homez'),
        'section'  => 'homez_settings_property_single',
        'type'     => 'checkbox',
    ));

    $contents = apply_filters('homez_listing_single_sort_content', array(
        'description' => esc_html__('Description', 'homez'),
        'energy' => esc_html__('EU Energy', 'homez'),
        'detail' => esc_html__('Detail', 'homez'),
        'attachments' => esc_html__('Attachments', 'homez'),
        'amenities' => esc_html__('Amenities', 'homez'),
        'materials' => esc_html__('Materials', 'homez'),
        'location' => esc_html__('Location', 'homez'),
        'floor-plans' => esc_html__('Floor plans', 'homez'),
        'video' => esc_html__('Video', 'homez'),
        'virtual' => esc_html__('Virtual tour', 'homez'),
        'facilities' => esc_html__('Facilities', 'homez'),
        'valuation' => esc_html__('Valuation', 'homez'),
        'stats_graph' => esc_html__('Stats graph', 'homez'),
        'nearby_yelp' => esc_html__('Yelp Nearby', 'homez'),
        'walk_score' => esc_html__('Walk Score', 'homez'),
        'google_places' => esc_html__('Google Places', 'homez'),
        'subproperties' => esc_html__('Subproperties', 'homez'),
        'related' => esc_html__('Related', 'homez'),
        'schedule-tour' => esc_html__('Schedule Tour', 'homez'),
        'mortgage-calculator' => esc_html__('Mortgage Calculator', 'homez'),
    ));
    foreach ($contents as $key => $value) {
        // Show Social Share
        $wp_customize->add_setting('homez_theme_options[show_property_'.$key.']', array(
            'capability' => 'edit_theme_options',
            'type'       => 'option',
            'default'       => '1',
            'sanitize_callback' => 'sanitize_text_field',
        ));

        $wp_customize->add_control('homez_theme_options_show_property_'.$key, array(
            'settings' => 'homez_theme_options[show_property_'.$key.']',
            'label'    => sprintf(esc_html__('Show %s', 'homez'), $value),
            'section'  => 'homez_settings_property_single',
            'type'     => 'checkbox',
        ));
    }

    // Show Description View More
    $wp_customize->add_setting('homez_theme_options[show_property_desc_view_more]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'default'       => '1',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('homez_theme_options_show_property_desc_view_more', array(
        'settings' => 'homez_theme_options[show_property_desc_view_more]',
        'label'    => esc_html__('Show Description View More', 'homez'),
        'section'  => 'homez_settings_property_single',
        'type'     => 'checkbox',
    ));

    // Property Layout
    $wp_customize->add_setting( 'homez_theme_options[property_stats_graph_for]', array(
        'default'        => 'v1',
        'type'           => 'option',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'homez_settings_property_single_property_stats_graph_for', array(
        'label'   => esc_html__('Property Show Stats graph for user', 'homez'),
        'section' => 'homez_settings_property_single',
        'type'    => 'select',
        'choices' => array(
            '' => esc_html__('All', 'homez'),
            'registered' => esc_html__('Registered user', 'homez'),
            'author' => esc_html__('Author + Administrator', 'homez'),
        ),
        'settings' => 'homez_theme_options[property_stats_graph_for]',
    ) );


    // Number subproperties listings
    $wp_customize->add_setting( 'homez_theme_options[property_subproperties_number]', array(
        'default'        => '4',
        'type'           => 'option',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'homez_settings_property_single_property_subproperties_number', array(
        'label'   => esc_html__('Number of Subproperties per row', 'homez'),
        'section' => 'homez_settings_property_single',
        'type'    => 'number',
        'settings' => 'homez_theme_options[property_subproperties_number]',
    ) );

    // Number related listings
    $wp_customize->add_setting( 'homez_theme_options[property_related_number]', array(
        'default'        => '4',
        'type'           => 'option',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'homez_settings_property_single_property_related_number', array(
        'label'   => esc_html__('Number of related properties to show', 'homez'),
        'section' => 'homez_settings_property_single',
        'type'    => 'number',
        'settings' => 'homez_theme_options[property_related_number]',
    ) );


    // Related Properties Columns
    $wp_customize->add_setting( 'homez_theme_options[property_related_columns]', array(
        'default'        => '3',
        'type'           => 'option',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'homez_settings_property_single_property_related_columns', array(
        'label'   => esc_html__('Related Properties Columns', 'homez'),
        'section' => 'homez_settings_property_single',
        'type'    => 'select',
        'choices' => $columns,
        'settings' => 'homez_theme_options[property_related_columns]',
    ) );


    // Print Property
    $wp_customize->add_section('homez_settings_listing_print', array(
        'title'    => esc_html__('Property Print', 'homez'),
        'priority' => 4,
        'panel' => 'homez_settings_property',
    ));

    // Show Print Button
    $wp_customize->add_setting('homez_theme_options[property_enable_printer]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'default'       => '1',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('homez_theme_options_property_enable_printer', array(
        'settings' => 'homez_theme_options[property_enable_printer]',
        'label'    => esc_html__('Show Print Button', 'homez'),
        'section'  => 'homez_settings_listing_print',
        'type'     => 'checkbox',
    ));

    // Print Logo
    $wp_customize->add_setting('homez_theme_options[print-logo]', array(
        'default'           => '',
        'capability'        => 'edit_theme_options',
        'type'           => 'option',
        'sanitize_callback' => 'sanitize_text_field',

    ));

    $wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, 'print-logo', array(
        'label'    => esc_html__('Print Logo', 'homez'),
        'section'  => 'homez_settings_listing_print',
        'settings' => 'homez_theme_options[print-logo]',
    )));

    $contents = apply_filters('homez_listing_single_print_content', array(
        'header' => esc_html__('Print Header', 'homez'),
        'qrcode' => esc_html__('Qrcode', 'homez'),
        'agent' => esc_html__('Agent Info', 'homez'),
        'description' => esc_html__('Description', 'homez'),
        'energy' => esc_html__('EU Energy', 'homez'),
        'detail' => esc_html__('Detail', 'homez'),
        'amenities' => esc_html__('Amenities', 'homez'),
        'floor-plans' => esc_html__('Floor plans', 'homez'),
        'facilities' => esc_html__('Facilities', 'homez'),
        'valuation' => esc_html__('Valuation', 'homez'),
        'gallery' => esc_html__('Gallery', 'homez'),
    ));

    foreach ($contents as $key => $value) {
        // Show Social Share
        $wp_customize->add_setting('homez_theme_options[show_print_'.$key.']', array(
            'capability' => 'edit_theme_options',
            'type'       => 'option',
            'default'       => '1',
            'sanitize_callback' => 'sanitize_text_field',
        ));

        $wp_customize->add_control('homez_theme_options_show_print_'.$key, array(
            'settings' => 'homez_theme_options[show_print_'.$key.']',
            'label'    => sprintf(esc_html__('Show %s', 'homez'), $value),
            'section'  => 'homez_settings_listing_print',
            'type'     => 'checkbox',
        ));
    }
}
add_action( 'customize_register', 'homez_realestate_customize_property_register', 15 );