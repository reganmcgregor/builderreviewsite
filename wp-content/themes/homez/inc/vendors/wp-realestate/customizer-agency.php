<?php

function homez_realestate_customize_agency_register( $wp_customize ) {
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

    // Agencies Panel
    $wp_customize->add_panel( 'homez_settings_agency', array(
        'title' => esc_html__( 'Agency Settings', 'homez' ),
        'priority' => 4,
    ) );

    // General Section
    $wp_customize->add_section('homez_settings_agency_general', array(
        'title'    => esc_html__('General', 'homez'),
        'priority' => 1,
        'panel' => 'homez_settings_agency',
    ));

    // Breadcrumbs Setting ?
    $wp_customize->add_setting('homez_theme_options[agency_breadcrumbs_setting]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control( new Homez_WP_Customize_Heading_Control($wp_customize, 'agency_breadcrumbs_setting', array(
        'label'    => esc_html__('Breadcrumbs Settings', 'homez'),
        'section'  => 'homez_settings_agency_general',
        'settings' => 'homez_theme_options[agency_breadcrumbs_setting]',
    )));

    // Breadcrumbs
    $wp_customize->add_setting('homez_theme_options[show_agency_breadcrumbs]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'default'    => 1,
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('homez_theme_options_show_agency_breadcrumbs', array(
        'settings' => 'homez_theme_options[show_agency_breadcrumbs]',
        'label'    => esc_html__('Breadcrumbs', 'homez'),
        'section'  => 'homez_settings_agency_general',
        'type'     => 'checkbox',
    ));

    // Breadcrumbs Background Color
    $wp_customize->add_setting('homez_theme_options[agency_breadcrumb_color]', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_hex_color',
        'capability'        => 'edit_theme_options',
        'type'           => 'option',
    ));

    $wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'agency_breadcrumb_color', array(
        'label'    => esc_html__('Breadcrumbs Background Color', 'homez'),
        'section'  => 'homez_settings_agency_general',
        'settings' => 'homez_theme_options[agency_breadcrumb_color]',
    )));

    // Breadcrumbs Background
    $wp_customize->add_setting('homez_theme_options[agency_breadcrumb_image]', array(
        'default'           => '',
        'capability'        => 'edit_theme_options',
        'type'           => 'option',
        'sanitize_callback' => 'sanitize_text_field',

    ));

    $wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, 'agency_breadcrumb_image', array(
        'label'    => esc_html__('Breadcrumbs Background', 'homez'),
        'section'  => 'homez_settings_agency_general',
        'settings' => 'homez_theme_options[agency_breadcrumb_image]',
    )));


    // Listing Archives
    $wp_customize->add_section('homez_settings_agency_archive', array(
        'title'    => esc_html__('Agency Archives', 'homez'),
        'priority' => 2,
        'panel' => 'homez_settings_agency',
    ));

    // General Setting ?
    $wp_customize->add_setting('homez_theme_options[listings_general_setting]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control( new Homez_WP_Customize_Heading_Control($wp_customize, 'listings_general_setting', array(
        'label'    => esc_html__('General Settings', 'homez'),
        'section'  => 'homez_settings_agency_archive',
        'settings' => 'homez_theme_options[listings_general_setting]',
    )));

    // Is Full Width
    $wp_customize->add_setting('homez_theme_options[agencies_fullwidth]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('homez_theme_options_agencies_fullwidth', array(
        'settings' => 'homez_theme_options[agencies_fullwidth]',
        'label'    => esc_html__('Is Full Width', 'homez'),
        'section'  => 'homez_settings_agency_archive',
        'type'     => 'checkbox',
    ));

    // layout
    $wp_customize->add_setting( 'homez_theme_options[agencies_layout_sidebar]', array(
        'default'        => 'left-main',
        'type'           => 'option',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( new Homez_WP_Customize_Radio_Image_Control( 
        $wp_customize, 
        'apus_settings_agencies_layout_sidebar', 
        array(
            'label'   => esc_html__('Layout Type', 'homez'),
            'section' => 'homez_settings_agency_archive',
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
            'settings' => 'homez_theme_options[agencies_layout_sidebar]',
            'description' => wp_kses(__('Select a sidebar layout for layout type <strong>"Default", "Top Map"</strong>.', 'homez'), array('strong' => array())),
        ) 
    ));


    // Display Mode
    $wp_customize->add_setting( 'homez_theme_options[agencies_display_mode]', array(
        'default'        => 'grid',
        'type'           => 'option',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'homez_settings_agency_archive_agencies_display_mode', array(
        'label'   => esc_html__('Display Mode', 'homez'),
        'section' => 'homez_settings_agency_archive',
        'type'    => 'select',
        'choices' => array(
            'grid' => esc_html__('Grid', 'homez'),
            'list' => esc_html__('List', 'homez'),
        ),
        'settings' => 'homez_theme_options[agencies_display_mode]',
    ) );

    // Grid Columns
    $wp_customize->add_setting( 'homez_theme_options[agencies_columns]', array(
        'default'        => '3',
        'type'           => 'option',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'homez_settings_agency_archive_agencies_columns', array(
        'label'   => esc_html__('Listings Grid Columns', 'homez'),
        'section' => 'homez_settings_agency_archive',
        'type'    => 'select',
        'choices' => $columns,
        'settings' => 'homez_theme_options[agencies_columns]',
    ) );

    // Pagination
    $wp_customize->add_setting( 'homez_theme_options[agencies_pagination]', array(
        'default'        => 'default',
        'type'           => 'option',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'homez_settings_agency_archive_agencies_pagination', array(
        'label'   => esc_html__('Listings Pagination', 'homez'),
        'section' => 'homez_settings_agency_archive',
        'type'    => 'select',
        'choices' => array(
            'default' => esc_html__('Default', 'homez'),
            'loadmore' => esc_html__('Load More Button', 'homez'),
            'infinite' => esc_html__('Infinite Scrolling', 'homez'),
        ),
        'settings' => 'homez_theme_options[agencies_pagination]',
    ) );



    // Single Agency
    $wp_customize->add_section('homez_settings_agency_single', array(
        'title'    => esc_html__('Agency Single', 'homez'),
        'priority' => 3,
        'panel' => 'homez_settings_agency',
    ));

    // General Setting ?
    $wp_customize->add_setting('homez_theme_options[agency_single_general_setting]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control( new Homez_WP_Customize_Heading_Control($wp_customize, 'agency_single_general_setting', array(
        'label'    => esc_html__('General Settings', 'homez'),
        'section'  => 'homez_settings_agency_single',
        'settings' => 'homez_theme_options[agency_single_general_setting]',
    )));

    // Is Full Width
    $wp_customize->add_setting('homez_theme_options[agency_fullwidth]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('homez_theme_options_agency_fullwidth', array(
        'settings' => 'homez_theme_options[agency_fullwidth]',
        'label'    => esc_html__('Is Full Width', 'homez'),
        'section'  => 'homez_settings_agency_single',
        'type'     => 'checkbox',
    ));

    // Show Social Share
    $wp_customize->add_setting('homez_theme_options[show_agency_social_share]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'default'       => '1',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('homez_theme_options_show_agency_social_share', array(
        'settings' => 'homez_theme_options[show_agency_social_share]',
        'label'    => esc_html__('Show Social Share', 'homez'),
        'section'  => 'homez_settings_agency_single',
        'type'     => 'checkbox',
    ));

    // Show Agency Location
    $wp_customize->add_setting('homez_theme_options[agency_location_show]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'default'       => '1',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('homez_theme_options_agency_location_show', array(
        'settings' => 'homez_theme_options[agency_location_show]',
        'label'    => esc_html__('Show Agency Location', 'homez'),
        'section'  => 'homez_settings_agency_single',
        'type'     => 'checkbox',
    ));

    // Show Agency Location
    $wp_customize->add_setting('homez_theme_options[agency_agent_show]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'default'       => '1',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('homez_theme_options_agency_agent_show', array(
        'settings' => 'homez_theme_options[agency_agent_show]',
        'label'    => esc_html__('Show Agency Agents', 'homez'),
        'section'  => 'homez_settings_agency_single',
        'type'     => 'checkbox',
    ));

    // Show Agency Agencies
    $wp_customize->add_setting('homez_theme_options[agency_property_show]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'default'       => '1',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('homez_theme_options_agency_property_show', array(
        'settings' => 'homez_theme_options[agency_property_show]',
        'label'    => esc_html__('Show Agency Agencies', 'homez'),
        'section'  => 'homez_settings_agency_single',
        'type'     => 'checkbox',
    ));

    // Agencies Per Page
    $wp_customize->add_setting( 'homez_theme_options[agency_property_per_page]', array(
        'default'        => '3',
        'type'           => 'option',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'homez_settings_agency_single_agency_property_per_page', array(
        'label'   => esc_html__('Properties Per Page', 'homez'),
        'section' => 'homez_settings_agency_single',
        'type'    => 'number',
        'settings' => 'homez_theme_options[agency_property_per_page]',
    ) );


    // Related Agencies Columns
    $wp_customize->add_setting( 'homez_theme_options[agency_property_columns]', array(
        'default'        => '3',
        'type'           => 'option',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'homez_settings_agency_single_agency_property_columns', array(
        'label'   => esc_html__('Properties Columns', 'homez'),
        'section' => 'homez_settings_agency_single',
        'type'    => 'select',
        'choices' => $columns,
        'settings' => 'homez_theme_options[agency_property_columns]',
    ) );
}
add_action( 'customize_register', 'homez_realestate_customize_agency_register', 15 );