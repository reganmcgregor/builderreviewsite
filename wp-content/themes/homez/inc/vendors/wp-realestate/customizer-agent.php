<?php

function homez_realestate_customize_agent_register( $wp_customize ) {
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

    // Agent Panel
    $wp_customize->add_panel( 'homez_settings_agent', array(
        'title' => esc_html__( 'Agent Settings', 'homez' ),
        'priority' => 4,
    ) );

    // General Section
    $wp_customize->add_section('homez_settings_agent_general', array(
        'title'    => esc_html__('General', 'homez'),
        'priority' => 1,
        'panel' => 'homez_settings_agent',
    ));

    // Breadcrumbs Setting ?
    $wp_customize->add_setting('homez_theme_options[agent_breadcrumbs_setting]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control( new Homez_WP_Customize_Heading_Control($wp_customize, 'agent_breadcrumbs_setting', array(
        'label'    => esc_html__('Breadcrumbs Settings', 'homez'),
        'section'  => 'homez_settings_agent_general',
        'settings' => 'homez_theme_options[agent_breadcrumbs_setting]',
    )));

    // Breadcrumbs
    $wp_customize->add_setting('homez_theme_options[show_agent_breadcrumbs]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'default'    => 1,
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('homez_theme_options_show_agent_breadcrumbs', array(
        'settings' => 'homez_theme_options[show_agent_breadcrumbs]',
        'label'    => esc_html__('Breadcrumbs', 'homez'),
        'section'  => 'homez_settings_agent_general',
        'type'     => 'checkbox',
    ));

    // Breadcrumbs Background Color
    $wp_customize->add_setting('homez_theme_options[agent_breadcrumb_color]', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_hex_color',
        'capability'        => 'edit_theme_options',
        'type'           => 'option',
    ));

    $wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'agent_breadcrumb_color', array(
        'label'    => esc_html__('Breadcrumbs Background Color', 'homez'),
        'section'  => 'homez_settings_agent_general',
        'settings' => 'homez_theme_options[agent_breadcrumb_color]',
    )));

    // Breadcrumbs Background
    $wp_customize->add_setting('homez_theme_options[agent_breadcrumb_image]', array(
        'default'           => '',
        'capability'        => 'edit_theme_options',
        'type'           => 'option',
        'sanitize_callback' => 'sanitize_text_field',

    ));

    $wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, 'agent_breadcrumb_image', array(
        'label'    => esc_html__('Breadcrumbs Background', 'homez'),
        'section'  => 'homez_settings_agent_general',
        'settings' => 'homez_theme_options[agent_breadcrumb_image]',
    )));


    // Listing Archives
    $wp_customize->add_section('homez_settings_agent_archive', array(
        'title'    => esc_html__('Listing Archives', 'homez'),
        'priority' => 2,
        'panel' => 'homez_settings_agent',
    ));

    // General Setting ?
    $wp_customize->add_setting('homez_theme_options[listings_general_setting]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control( new Homez_WP_Customize_Heading_Control($wp_customize, 'listings_general_setting', array(
        'label'    => esc_html__('General Settings', 'homez'),
        'section'  => 'homez_settings_agent_archive',
        'settings' => 'homez_theme_options[listings_general_setting]',
    )));

    // Is Full Width
    $wp_customize->add_setting('homez_theme_options[agents_fullwidth]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('homez_theme_options_agents_fullwidth', array(
        'settings' => 'homez_theme_options[agents_fullwidth]',
        'label'    => esc_html__('Is Full Width', 'homez'),
        'section'  => 'homez_settings_agent_archive',
        'type'     => 'checkbox',
    ));

    // layout
    $wp_customize->add_setting( 'homez_theme_options[agents_layout_sidebar]', array(
        'default'        => 'left-main',
        'type'           => 'option',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( new Homez_WP_Customize_Radio_Image_Control( 
        $wp_customize, 
        'apus_settings_agents_layout_sidebar', 
        array(
            'label'   => esc_html__('Layout Type', 'homez'),
            'section' => 'homez_settings_agent_archive',
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
            'settings' => 'homez_theme_options[agents_layout_sidebar]',
            'description' => wp_kses(__('Select a sidebar layout for layout type <strong>"Default", "Top Map"</strong>.', 'homez'), array('strong' => array())),
        ) 
    ));


    // Display Mode
    $wp_customize->add_setting( 'homez_theme_options[agents_display_mode]', array(
        'default'        => 'grid',
        'type'           => 'option',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'homez_settings_agent_archive_agents_display_mode', array(
        'label'   => esc_html__('Display Mode', 'homez'),
        'section' => 'homez_settings_agent_archive',
        'type'    => 'select',
        'choices' => array(
            'grid' => esc_html__('Grid', 'homez'),
            'list' => esc_html__('List', 'homez'),
        ),
        'settings' => 'homez_theme_options[agents_display_mode]',
    ) );

    // Grid Columns
    $wp_customize->add_setting( 'homez_theme_options[agents_columns]', array(
        'default'        => '3',
        'type'           => 'option',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'homez_settings_agent_archive_agents_columns', array(
        'label'   => esc_html__('Listings Grid Columns', 'homez'),
        'section' => 'homez_settings_agent_archive',
        'type'    => 'select',
        'choices' => $columns,
        'settings' => 'homez_theme_options[agents_columns]',
    ) );

    // Pagination
    $wp_customize->add_setting( 'homez_theme_options[agents_pagination]', array(
        'default'        => 'default',
        'type'           => 'option',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'homez_settings_agent_archive_agents_pagination', array(
        'label'   => esc_html__('Listings Pagination', 'homez'),
        'section' => 'homez_settings_agent_archive',
        'type'    => 'select',
        'choices' => array(
            'default' => esc_html__('Default', 'homez'),
            'loadmore' => esc_html__('Load More Button', 'homez'),
            'infinite' => esc_html__('Infinite Scrolling', 'homez'),
        ),
        'settings' => 'homez_theme_options[agents_pagination]',
    ) );



    // Single Agent
    $wp_customize->add_section('homez_settings_agent_single', array(
        'title'    => esc_html__('Agent Single', 'homez'),
        'priority' => 3,
        'panel' => 'homez_settings_agent',
    ));

    // General Setting ?
    $wp_customize->add_setting('homez_theme_options[agent_single_general_setting]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control( new Homez_WP_Customize_Heading_Control($wp_customize, 'agent_single_general_setting', array(
        'label'    => esc_html__('General Settings', 'homez'),
        'section'  => 'homez_settings_agent_single',
        'settings' => 'homez_theme_options[agent_single_general_setting]',
    )));

    // Is Full Width
    $wp_customize->add_setting('homez_theme_options[agent_fullwidth]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('homez_theme_options_agent_fullwidth', array(
        'settings' => 'homez_theme_options[agent_fullwidth]',
        'label'    => esc_html__('Is Full Width', 'homez'),
        'section'  => 'homez_settings_agent_single',
        'type'     => 'checkbox',
    ));

    // Show Social Share
    $wp_customize->add_setting('homez_theme_options[show_agent_social_share]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'default'       => '1',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('homez_theme_options_show_agent_social_share', array(
        'settings' => 'homez_theme_options[show_agent_social_share]',
        'label'    => esc_html__('Show Social Share', 'homez'),
        'section'  => 'homez_settings_agent_single',
        'type'     => 'checkbox',
    ));

    // Show Agent Location
    $wp_customize->add_setting('homez_theme_options[agent_location_show]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'default'       => '1',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('homez_theme_options_agent_location_show', array(
        'settings' => 'homez_theme_options[agent_location_show]',
        'label'    => esc_html__('Show Agent Location', 'homez'),
        'section'  => 'homez_settings_agent_single',
        'type'     => 'checkbox',
    ));

    // Show Agent Agent
    $wp_customize->add_setting('homez_theme_options[agent_property_show]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'default'       => '1',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('homez_theme_options_agent_property_show', array(
        'settings' => 'homez_theme_options[agent_property_show]',
        'label'    => esc_html__('Show Properties Agent', 'homez'),
        'section'  => 'homez_settings_agent_single',
        'type'     => 'checkbox',
    ));

    // Agent Per Page
    $wp_customize->add_setting( 'homez_theme_options[agent_property_per_page]', array(
        'default'        => '3',
        'type'           => 'option',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'homez_settings_agent_single_agent_property_per_page', array(
        'label'   => esc_html__('Properties Per Page', 'homez'),
        'section' => 'homez_settings_agent_single',
        'type'    => 'number',
        'settings' => 'homez_theme_options[agent_property_per_page]',
    ) );


    // Related Agent Columns
    $wp_customize->add_setting( 'homez_theme_options[agent_property_columns]', array(
        'default'        => '3',
        'type'           => 'option',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'homez_settings_agent_single_agent_property_columns', array(
        'label'   => esc_html__('Agent Columns', 'homez'),
        'section' => 'homez_settings_agent_single',
        'type'    => 'select',
        'choices' => $columns,
        'settings' => 'homez_theme_options[agent_property_columns]',
    ) );
}
add_action( 'customize_register', 'homez_realestate_customize_agent_register', 15 );