<?php

function homez_realestate_customize_other_register( $wp_customize ) {
    global $wp_registered_sidebars;
    
    // General Section
    $wp_customize->add_section('homez_settings_register_form_general', array(
        'title'    => esc_html__('Register Form', 'homez'),
        'priority' => 15,
    ));

    // Enable Register Agency
    $wp_customize->add_setting('homez_theme_options[register_form_enable_agency]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'default'    => 1,
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('homez_theme_options_register_form_enable_agency', array(
        'settings' => 'homez_theme_options[register_form_enable_agency]',
        'label'    => esc_html__('Enable Register Agency', 'homez'),
        'section'  => 'homez_settings_register_form_general',
        'type'     => 'checkbox',
    ));

    // Enable Register Agent
    $wp_customize->add_setting('homez_theme_options[register_form_enable_agent]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'default'    => 1,
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('homez_theme_options_register_form_enable_agent', array(
        'settings' => 'homez_theme_options[register_form_enable_agent]',
        'label'    => esc_html__('Enable Register Agent', 'homez'),
        'section'  => 'homez_settings_register_form_general',
        'type'     => 'checkbox',
    ));
}
add_action( 'customize_register', 'homez_realestate_customize_other_register', 15 );


function homez_realestate_customize_mortgage_calculator_register( $wp_customize ) {
    global $wp_registered_sidebars;
    

    // General Section
    $wp_customize->add_section('homez_settings_mortgage_calculator_general', array(
        'title'    => esc_html__('Mortgage Calculator', 'homez'),
        'priority' => 15,
    ));

    // General
    $wp_customize->add_setting('homez_theme_options[mortgage_calculator_general_setting]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control( new Homez_WP_Customize_Heading_Control($wp_customize, 'mortgage_calculator_general_setting', array(
        'label'    => esc_html__('General', 'homez'),
        'section'  => 'homez_settings_mortgage_calculator_general',
        'settings' => 'homez_theme_options[mortgage_calculator_general_setting]',
    )));

    // Total Amount
    $wp_customize->add_setting('homez_theme_options[mortgage_calculator_total_amount]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'default'    => 70000,
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('homez_theme_options_mortgage_calculator_total_amount', array(
        'settings' => 'homez_theme_options[mortgage_calculator_total_amount]',
        'label'    => esc_html__('Total Amount', 'homez'),
        'section'  => 'homez_settings_mortgage_calculator_general',
        'type'     => 'text',
    ));

    // Down payment
    $wp_customize->add_setting('homez_theme_options[mortgage_calculator_down_payment]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'default'    => 10000,
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('homez_theme_options_mortgage_calculator_down_payment', array(
        'settings' => 'homez_theme_options[mortgage_calculator_down_payment]',
        'label'    => esc_html__('Down payment', 'homez'),
        'section'  => 'homez_settings_mortgage_calculator_general',
        'type'     => 'text',
    ));

    // Interest Rate
    $wp_customize->add_setting('homez_theme_options[mortgage_calculator_interest_rate]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'default'    => '3.5',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('homez_theme_options_mortgage_calculator_interest_rate', array(
        'settings' => 'homez_theme_options[mortgage_calculator_interest_rate]',
        'label'    => esc_html__('Interest Rate', 'homez'),
        'section'  => 'homez_settings_mortgage_calculator_general',
        'type'     => 'text',
    ));

    // Loan Terms (Years)
    $wp_customize->add_setting('homez_theme_options[mortgage_calculator_loan_terms]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'default'    => '15',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('homez_theme_options_mortgage_calculator_loan_terms', array(
        'settings' => 'homez_theme_options[mortgage_calculator_loan_terms]',
        'label'    => esc_html__('Loan Terms (Years)', 'homez'),
        'section'  => 'homez_settings_mortgage_calculator_general',
        'type'     => 'text',
    ));

    // Property Tax
    $wp_customize->add_setting('homez_theme_options[mortgage_calculator_property_tax]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'default'    => '3000',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('homez_theme_options_mortgage_calculator_property_tax', array(
        'settings' => 'homez_theme_options[mortgage_calculator_property_tax]',
        'label'    => esc_html__('Property Tax', 'homez'),
        'section'  => 'homez_settings_mortgage_calculator_general',
        'type'     => 'text',
    ));

    // Home Insurance
    $wp_customize->add_setting('homez_theme_options[mortgage_calculator_home_insurance]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'default'    => '1000',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('homez_theme_options_mortgage_calculator_home_insurance', array(
        'settings' => 'homez_theme_options[mortgage_calculator_home_insurance]',
        'label'    => esc_html__('Home Insurance', 'homez'),
        'section'  => 'homez_settings_mortgage_calculator_general',
        'type'     => 'text',
    ));

    // Home Insurance
    $wp_customize->add_setting('homez_theme_options[mortgage_calculator_home_insurance]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'default'    => '1000',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('homez_theme_options_mortgage_calculator_home_insurance', array(
        'settings' => 'homez_theme_options[mortgage_calculator_home_insurance]',
        'label'    => esc_html__('Home Insurance', 'homez'),
        'section'  => 'homez_settings_mortgage_calculator_general',
        'type'     => 'text',
    ));

    // Color Setting
    $wp_customize->add_setting('homez_theme_options[mortgage_calculator_color_setting]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control( new Homez_WP_Customize_Heading_Control($wp_customize, 'mortgage_calculator_color_setting', array(
        'label'    => esc_html__('Color Setting', 'homez'),
        'section'  => 'homez_settings_mortgage_calculator_color',
        'settings' => 'homez_theme_options[mortgage_calculator_color_setting]',
    )));

    // Principal & Interest Color
    $wp_customize->add_setting('homez_theme_options[mortgage_calculator_principal_interest_color]', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_hex_color',
        'capability'        => 'edit_theme_options',
        'type'           => 'option',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'mortgage_calculator_principal_interest_color', array(
        'label'    => esc_html__('Principal & Interest Color', 'homez'),
        'section'  => 'homez_settings_mortgage_calculator_color',
        'settings' => 'homez_theme_options[mortgage_calculator_principal_interest_color]',
    )));

    // Property Tax Color
    $wp_customize->add_setting('homez_theme_options[mortgage_calculator_property_tax_color]', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_hex_color',
        'capability'        => 'edit_theme_options',
        'type'           => 'option',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'mortgage_calculator_property_tax_color', array(
        'label'    => esc_html__('Property Tax Color', 'homez'),
        'section'  => 'homez_settings_mortgage_calculator_color',
        'settings' => 'homez_theme_options[mortgage_calculator_property_tax_color]',
    )));


    // Home Insurance Color
    $wp_customize->add_setting('homez_theme_options[mortgage_calculator_home_insurance_color]', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_hex_color',
        'capability'        => 'edit_theme_options',
        'type'           => 'option',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'mortgage_calculator_home_insurance_color', array(
        'label'    => esc_html__('Home Insurance Color', 'homez'),
        'section'  => 'homez_settings_mortgage_calculator_color',
        'settings' => 'homez_theme_options[mortgage_calculator_home_insurance_color]',
    )));
}
add_action( 'customize_register', 'homez_realestate_customize_mortgage_calculator_register', 15 );