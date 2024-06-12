<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Homez_Elementor_RealEstate_Agent_Search_Form extends Elementor\Widget_Base {

	public function get_name() {
        return 'apus_element_realestate_agent_search_form';
    }

	public function get_title() {
        return esc_html__( 'Apus Agents Search Form', 'homez' );
    }
    
	public function get_categories() {
        return [ 'homez-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Search Form', 'homez' ),
                'tab' => Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => esc_html__( 'Title', 'homez' ),
                'type' => Elementor\Controls_Manager::TEXT,
                'input_type' => 'text',
                'placeholder' => esc_html__( 'Enter your title here', 'homez' ),
            ]
        );

        $fields = WP_RealEstate_Agent_Filter::get_fields();
        $search_fields = array( '' => esc_html__('Choose a field', 'homez') );
        foreach ($fields as $key => $field) {
            $name = $field['name'];
            if ( empty($field['name']) ) {
                $name = $key;
            }
            $search_fields[$key] = $name;
        }

        $repeater = new Elementor\Repeater();

        $repeater->add_control(
            'filter_field',
            [
                'label' => esc_html__( 'Filter field', 'homez' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'options' => $search_fields
            ]
        );
        
        $repeater->add_control(
            'title',
            [
                'label' => esc_html__( 'Title', 'homez' ),
                'type' => Elementor\Controls_Manager::TEXT,
                'input_type' => 'text',
            ]
        );

        $repeater->add_control(
            'placeholder',
            [
                'label' => esc_html__( 'Placeholder', 'homez' ),
                'type' => Elementor\Controls_Manager::TEXT,
                'input_type' => 'text',
            ]
        );

        $repeater->add_control(
            'enable_autocompleate_search',
            [
                'label' => esc_html__( 'Enable autocompleate search', 'homez' ),
                'type' => Elementor\Controls_Manager::SWITCHER,
                'default' => '',
                'label_on' => esc_html__( 'Yes', 'homez' ),
                'label_off' => esc_html__( 'No', 'homez' ),
                'condition' => [
                    'filter_field' => 'title',
                ],
            ]
        );

        $repeater->add_control(
            'filter_layout',
            [
                'label' => esc_html__( 'Filter Layout', 'homez' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'options' => array(
                    'select' => esc_html__('Select', 'homez'),
                    'radio' => esc_html__('Radio Button', 'homez'),
                    'check_list' => esc_html__('Check Box', 'homez'),
                ),
                'default' => 'select',
                'condition' => [
                    'filter_field' => ['category', 'location'],
                ],
            ]
        );
        
        $columns = array();
        for ($i=1; $i <= 12 ; $i++) { 
            $columns[$i] = sprintf(esc_html__('%d Columns', 'homez'), $i);
        }
        $repeater->add_responsive_control(
            'columns',
            [
                'label' => esc_html__( 'Columns', 'homez' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'options' => $columns,
                'default' => 1
            ]
        );

        $repeater->add_control(
            'icon',
            [
                'label' => esc_html__( 'Icon', 'homez' ),
                'type' => Elementor\Controls_Manager::ICON
            ]
        );

        $this->add_control(
            'main_search_fields',
            [
                'label' => esc_html__( 'Main Search Fields', 'homez' ),
                'type' => Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
            ]
        );

        $this->add_control(
            'show_advance_search',
            [
                'label'         => esc_html__( 'Show Advanced Search', 'homez' ),
                'type'          => Elementor\Controls_Manager::SWITCHER,
                'label_on'      => esc_html__( 'Show', 'homez' ),
                'label_off'     => esc_html__( 'Hide', 'homez' ),
                'return_value'  => true,
                'default'       => true,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'advance_search_layout_type',
            [
                'label' => esc_html__( 'Advanced Search Layout', 'homez' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'options' => array(
                    '' => esc_html__('Default', 'homez'),
                    'popup' => esc_html__('Popup', 'homez'),
                ),
                'default' => ''
            ]
        );

        $this->add_control(
            'advance_search_title',
            [
                'label' => esc_html__( 'Advanced Search Title', 'homez' ),
                'type' => Elementor\Controls_Manager::TEXT,
                'default' => 'Advanced Search',
                'condition' => [
                    'advance_search_layout_type' => ['popup'],
                ],
            ]
        );

        $this->add_control(
            'advance_search_btn_text',
            [
                'label' => esc_html__( 'Advanced Search Button Text', 'homez' ),
                'type' => Elementor\Controls_Manager::TEXT,
                'input_type' => 'text',
                'default' => 'Find Property',
                'condition' => [
                    'advance_search_layout_type' => ['popup'],
                ],
            ]
        );

        $this->add_control(
            'advance_search_fields',
            [
                'label' => esc_html__( 'Advanced Search Fields', 'homez' ),
                'type' => Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
            ]
        );

        $this->add_control(
            'show_button_search',
            [
                'label' => esc_html__( 'Show Button Search', 'homez' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'options' => array(
                    'yes' => esc_html__('Yes', 'homez'),
                    'no' => esc_html__('No', 'homez'),
                ),
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'filter_btn_text',
            [
                'label' => esc_html__( 'Button Text', 'homez' ),
                'type' => Elementor\Controls_Manager::TEXT,
                'input_type' => 'text',
                'default' => 'Find Property',
                'separator' => 'before',
                'condition' => [
                    'show_button_search' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'btn_columns',
            [
                'label' => esc_html__( 'Button Columns', 'homez' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'options' => $columns,
                'default' => 1,
                'condition' => [
                    'show_button_search' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'advanced_btn_text',
            [
                'label' => esc_html__( 'Advanced Text', 'homez' ),
                'type' => Elementor\Controls_Manager::TEXT,
                'input_type' => 'text',
                'default' => 'Advanced',
            ]
        );

        $this->add_control(
            'layout_type',
            [
                'label' => esc_html__( 'Layout Type', 'homez' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'options' => array(
                    'horizontal' => esc_html__('Horizontal', 'homez'),
                    'vertical' => esc_html__('Vertical', 'homez'),
                ),
                'default' => 'horizontal',
                'separator' => 'before',
            ]
        );

   		$this->add_control(
            'el_class',
            [
                'label'         => esc_html__( 'Extra class name', 'homez' ),
                'type'          => Elementor\Controls_Manager::TEXT,
                'placeholder'   => esc_html__( 'If you wish to style particular content element differently, please add a class name to this field and refer to it in your custom CSS file.', 'homez' ),
                'separator' => 'before',
            ]
        );

        $this->end_controls_section();



        $this->start_controls_section(
            'section_button_style',
            [
                'label' => esc_html__( 'Button', 'homez' ),
                'tab' => Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->start_controls_tabs( 'tabs_button_style' );

            $this->start_controls_tab(
                'tab_button_normal',
                [
                    'label' => esc_html__( 'Normal', 'homez' ),
                ]
            );
            
            $this->add_control(
                'button_color',
                [
                    'label' => esc_html__( 'Button Color', 'homez' ),
                    'type' => Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .btn-submit' => 'color: {{VALUE}};',
                    ],
                ]
            );
            $this->add_group_control(
                Elementor\Group_Control_Background::get_type(),
                [
                    'name' => 'background_button',
                    'label' => esc_html__( 'Background', 'homez' ),
                    'types' => [ 'classic', 'gradient', 'video' ],
                    'selector' => '{{WRAPPER}} .btn-submit',
                ]
            );

            $this->add_group_control(
                Elementor\Group_Control_Border::get_type(),
                [
                    'name' => 'border_button',
                    'label' => esc_html__( 'Border', 'homez' ),
                    'selector' => '{{WRAPPER}} .btn-submit',
                ]
            );

            $this->add_control(
                'padding_button',
                [
                    'label' => esc_html__( 'Padding', 'homez' ),
                    'type' => Elementor\Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .btn-submit' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_control(
                'btn_border_radius',
                [
                    'label' => esc_html__( 'Border Radius', 'homez' ),
                    'type' => Elementor\Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%' ],
                    'selectors' => [
                        '{{WRAPPER}} .btn-submit' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->end_controls_tab();

            // tab hover
            $this->start_controls_tab(
                'tab_button_hover',
                [
                    'label' => esc_html__( 'Hover', 'homez' ),
                ]
            );

            $this->add_control(
                'button_hover_color',
                [
                    'label' => esc_html__( 'Button Color', 'homez' ),
                    'type' => Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .btn-submit:hover, {{WRAPPER}} .btn-submit:focus' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_group_control(
                Elementor\Group_Control_Background::get_type(),
                [
                    'name' => 'background_button_hover',
                    'label' => esc_html__( 'Background', 'homez' ),
                    'types' => [ 'classic', 'gradient', 'video' ],
                    'selector' => '{{WRAPPER}} .btn-submit:hover, {{WRAPPER}} .btn-submit:focus',
                ]
            );

            $this->add_control(
                'button_hover_border_color',
                [
                    'label' => esc_html__( 'Border Color', 'homez' ),
                    'type' => Elementor\Controls_Manager::COLOR,
                    'condition' => [
                        'border_button_border!' => '',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .btn-submit:hover, {{WRAPPER}} .btn-submit:focus' => 'border-color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_control(
                'padding_button_hover',
                [
                    'label' => esc_html__( 'Padding', 'homez' ),
                    'type' => Elementor\Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .btn-submit:hover, {{WRAPPER}} .btn-submit:focus' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_control(
                'btn_hv_border_radius',
                [
                    'label' => esc_html__( 'Border Radius', 'homez' ),
                    'type' => Elementor\Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%' ],
                    'selectors' => [
                        '{{WRAPPER}} .btn-submit:hover, {{WRAPPER}} .btn-submit:focus' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->end_controls_tab();

        $this->end_controls_tabs();
        // end tab 

        $this->end_controls_section();


        $this->start_controls_section(
            'section_button_av_style',
            [
                'label' => esc_html__( 'Button Advanced', 'homez' ),
                'tab' => Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->start_controls_tabs( 'tabs_button_av_style' );

            $this->start_controls_tab(
                'tab_button_av_normal',
                [
                    'label' => esc_html__( 'Normal', 'homez' ),
                ]
            );
            
            $this->add_control(
                'button_av_color',
                [
                    'label' => esc_html__( 'Button Color', 'homez' ),
                    'type' => Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .content-main-inner .advance-search-btn' => 'color: {{VALUE}};',
                    ],
                ]
            );
            $this->add_group_control(
                Elementor\Group_Control_Background::get_type(),
                [
                    'name' => 'background_button_av',
                    'label' => esc_html__( 'Background', 'homez' ),
                    'types' => [ 'classic', 'gradient', 'video' ],
                    'selector' => '{{WRAPPER}} .content-main-inner .advance-search-btn',
                ]
            );

            $this->add_group_control(
                Elementor\Group_Control_Border::get_type(),
                [
                    'name' => 'border_button_av',
                    'label' => esc_html__( 'Border', 'homez' ),
                    'selector' => '{{WRAPPER}} .content-main-inner .advance-search-btn',
                ]
            );

            $this->add_control(
                'padding_button_av',
                [
                    'label' => esc_html__( 'Padding', 'homez' ),
                    'type' => Elementor\Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .content-main-inner .advance-search-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_control(
                'btn_av_border_radius',
                [
                    'label' => esc_html__( 'Border Radius', 'homez' ),
                    'type' => Elementor\Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%' ],
                    'selectors' => [
                        '{{WRAPPER}} .content-main-inner .advance-search-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->end_controls_tab();

            // tab hover
            $this->start_controls_tab(
                'tab_button_av_hover',
                [
                    'label' => esc_html__( 'Hover', 'homez' ),
                ]
            );

            $this->add_control(
                'button_av_hover_color',
                [
                    'label' => esc_html__( 'Button Color', 'homez' ),
                    'type' => Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .content-main-inner .advance-search-btn:hover, {{WRAPPER}} .content-main-inner .advance-search-btn:focus' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_group_control(
                Elementor\Group_Control_Background::get_type(),
                [
                    'name' => 'background_button_av_hover',
                    'label' => esc_html__( 'Background', 'homez' ),
                    'types' => [ 'classic', 'gradient', 'video' ],
                    'selector' => '{{WRAPPER}} .content-main-inner .advance-search-btn:hover, {{WRAPPER}} .content-main-inner .advance-search-btn:focus',
                ]
            );

            $this->add_control(
                'button_av_hover_border_color',
                [
                    'label' => esc_html__( 'Border Color', 'homez' ),
                    'type' => Elementor\Controls_Manager::COLOR,
                    'condition' => [
                        'border_button_av_border!' => '',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .content-main-inner .advance-search-btn:hover, {{WRAPPER}} .content-main-inner .advance-search-btn:focus' => 'border-color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_control(
                'padding_av_button_hover',
                [
                    'label' => esc_html__( 'Padding', 'homez' ),
                    'type' => Elementor\Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .content-main-inner .advance-search-btn:hover, {{WRAPPER}} .content-main-inner .advance-search-btn:focus' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_control(
                'btn_av_hv_border_radius',
                [
                    'label' => esc_html__( 'Border Radius', 'homez' ),
                    'type' => Elementor\Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%' ],
                    'selectors' => [
                        '{{WRAPPER}} .content-main-inner .advance-search-btn:hover, {{WRAPPER}} .content-main-inner .advance-search-btn:focus' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->end_controls_tab();

        $this->end_controls_tabs();
        // end tab 

        $this->end_controls_section();

        $this->start_controls_section(
            'section_border_style',
            [
                'label' => esc_html__( 'Box', 'homez' ),
                'tab' => Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'margin_item',
            [
                'label' => esc_html__( 'Space Item', 'homez' ),
                'type' => Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .content-main-inner .form-group' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'padding_box',
            [
                'label' => esc_html__( 'Padding', 'homez' ),
                'type' => Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .search-form-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'bg_box',
            [
                'label' => esc_html__( 'Background Color', 'homez' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .search-form-inner' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'box_shadow',
                'label' => esc_html__( 'Box Shadow', 'homez' ),
                'selector' => '{{WRAPPER}} .search-form-inner',
            ]
        );

        $this->add_control(
            'box_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'homez' ),
                'type' => Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .search-form-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_typography_style',
            [
                'label' => esc_html__( 'Main Box', 'homez' ),
                'tab' => Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs( 'tabs_typography_style' );

            $this->start_controls_tab(
                'tab_typography_normal',
                [
                    'label' => esc_html__( 'Normal', 'homez' ),
                ]
            );

                $this->add_control(
                    'text_input_color',
                    [
                        'label' => esc_html__( 'Input Color', 'homez' ),
                        'type' => Elementor\Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .content-main-inner .form-control, {{WRAPPER}} .content-main-inner .select2-selection--single .select2-selection__rendered' => 'color: {{VALUE}};',
                        ],
                    ]
                );

                $this->add_control(
                    'text_input_bg_color',
                    [
                        'label' => esc_html__( 'Input Background Color', 'homez' ),
                        'type' => Elementor\Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .content-main-inner .form-control' => 'background-color: {{VALUE}} !important;',
                        ],
                    ]
                );

                $this->add_group_control(
                    Elementor\Group_Control_Border::get_type(),
                    [
                        'name' => 'border_input',
                        'label' => esc_html__( 'Border', 'homez' ),
                        'selector' => '{{WRAPPER}} .content-main-inner .form-control, {{WRAPPER}} .content-main-inner .select2-container--default.select2-container .select2-selection--single',
                    ]
                );

            $this->end_controls_tab();

            // tab hover
            $this->start_controls_tab(
                'tab_typography_hover',
                [
                    'label' => esc_html__( 'Hover', 'homez' ),
                ]
            );

            $this->add_control(
                'text_input_focus_bg_color',
                [
                    'label' => esc_html__( 'Input Background Color', 'homez' ),
                    'type' => Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .content-main-inner .form-control:focus' => 'background-color: {{VALUE}} !important;',
                    ],
                ]
            );

            $this->add_control(
                'text_input_focus_br_color',
                [
                    'label' => esc_html__( 'Input Border Color', 'homez' ),
                    'type' => Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .content-main-inner .form-control:focus, .content-main-inner .select2-container--default.select2-container.select2-container--open .select2-selection--single' => 'border-color: {{VALUE}};',
                    ],
                ]
            );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

    }

	protected function render() {
        $settings = $this->get_settings();

        extract( $settings );
        
        $search_page_url = WP_RealEstate_Mixes::get_agents_page_url();

        homez_load_select2();

        $filter_fields = WP_RealEstate_Agent_Filter::get_fields();
        $instance = array();
        $widget_id = homez_random_key();
        $args = array( 'widget_id' => $widget_id );

        $btn_columns = !empty($btn_columns) ? $btn_columns : 12;
        $btn_columns_tablet = !empty($btn_columns_tablet) ? $btn_columns_tablet : $btn_columns;
        $btn_columns_mobile = !empty($btn_columns_mobile) ? $btn_columns_mobile : 12;

        ?>
        <div class="widget-property-search-form <?php echo esc_attr($el_class); ?>">
            
            <?php if ( $title ) { ?>
                <h2 class="title"><?php echo esc_html($title); ?></h2>
            <?php } ?>
            
            <form id="filter-listing-form-<?php echo esc_attr($widget_id); ?>" action="<?php echo esc_url($search_page_url); ?>" class="form-search filter-listing-form <?php echo esc_attr($layout_type); ?>" method="GET">
                <div class="search-form-inner position-relative">
                    <?php if ( $layout_type == 'horizontal' ) { ?>
                        <div class="main-inner clearfix">
                            <div class="content-main-inner">
                                <div class="row d-lg-flex align-items-center list-fileds">
                                    <?php
                                    $this->form_fields_display($main_search_fields, $filter_fields, $instance, $args);
                                    ?>
                                    <?php if($show_button_search == 'yes') { ?>
                                        <div class="col-<?php echo esc_attr($btn_columns_mobile); ?> col-md-<?php echo esc_attr($btn_columns_tablet); ?> col-xl-<?php echo esc_attr($btn_columns); ?> form-group-search">
                                            <div class="d-md-flex align-items-center">
                                                <?php if ( $show_advance_search && !empty($advance_search_fields) ) {
                                                    $addvance_class = '';
                                                    $href = 'javascript:void(0);';
                                                    if ( $advance_search_layout_type == 'popup' ) {
                                                        $addvance_class = 'popup';
                                                        $href = '#advance-search-wrapper-'.esc_attr($widget_id);
                                                    }
                                                ?>
                                                    <div class="advance-link">
                                                        <a href="<?php echo trim($href); ?>" class="advance-search-btn d-flex align-items-center <?php echo esc_attr($addvance_class); ?>">
                                                            <i class="flaticon-settings"></i>
                                                            <?php
                                                                if ( !empty($advanced_btn_text) ) {
                                                                    echo esc_html($advanced_btn_text);
                                                                } else {
                                                                    esc_html_e('Advanced Advanced ', 'homez');
                                                                }
                                                            ?>
                                                        </a>
                                                    </div>
                                                <?php } ?>
                                                
                                                <button class="btn-submit btn btn-theme <?php echo trim( ($filter_btn_text)?'':'no-text' ); ?>" type="submit">
                                                    <i class="flaticon-search pre"></i><?php echo trim($filter_btn_text); ?>
                                                </button>

                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <?php
                        if ( $show_advance_search && !empty($advance_search_fields) ) {
                            ?>
                            <div id="advance-search-wrapper-<?php echo esc_attr($widget_id); ?>" class="advance-search-wrapper">
                                <div class="advance-search-wrapper-fields form-theme">

                                    <?php
                                    if ( $advance_search_layout_type == 'popup' ) {
                                        ?>
                                        <div class="advance-search-top d-flex align-items-center">
                                            <?php if ( !empty($advance_search_title) ) { ?>
                                                <h4 class="advance-title"><?php echo esc_html($advance_search_title); ?></h4>
                                            <?php } ?>
                                            <div class="ms-auto">
                                                <span class="close-advance-popup"><i class="ti-close"></i></span>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    <div class="inner-search-advance">
                                        <div class="inner">
                                            <div class="row">
                                                <?php
                                                $this->form_fields_display($advance_search_fields, $filter_fields, $instance, $args);
                                                ?>
                                                
                                            </div>
                                        </div>
                                    </div>

                                    <?php
                                    if ( $advance_search_layout_type == 'popup' ) {
                                        ?>
                                        <div class="advance-search-bottom">
                                            <?php if ( !empty($advance_search_btn_text) ) { ?>
                                                <div class="row">
                                                    <div class="col-12  form-group-search">
                                                        <button class="submit-advance-search-btn btn-submit w-100 btn btn-theme <?php echo trim( ($advance_search_btn_text)?'':'no-text' ); ?>" type="submit" data-form_id="#filter-listing-form-<?php echo esc_attr($widget_id); ?>">
                                                            <i class="flaticon-search pre"></i>
                                                            <?php echo trim($advance_search_btn_text); ?>
                                                        </button>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <?php
                                    }
                                    ?>

                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    <?php } else { ?>
                        <div class="main-inner clearfix">
                            <div class="content-main-inner">
                                <div class="row">
                                    <?php
                                    $this->form_fields_display($main_search_fields, $filter_fields, $instance, $args);
                                    ?>
                                    

                                    <?php if( $show_advance_search && !empty($advance_search_fields)){
                                        $addvance_class = '';
                                        $href = 'javascript:void(0);';
                                        if ( $advance_search_layout_type == 'popup' ) {
                                            $addvance_class = 'popup';
                                            $href = '#advance-search-wrapper-'.esc_attr($widget_id);
                                        }
                                    ?>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <div class="advance-link">
                                                    <a href="<?php echo trim($href); ?>" class=" advance-search-btn d-flex align-items-center <?php echo esc_attr($addvance_class); ?>">
                                                        <i class="flaticon-settings"></i>
                                                        <?php
                                                            if ( !empty($advanced_btn_text) ) {
                                                                echo esc_html($advanced_btn_text);
                                                            } else {
                                                                esc_html_e('Advanced Search', 'homez');
                                                            }
                                                        ?>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>

                                </div>

                                <?php
                                if ( $show_advance_search && !empty($advance_search_fields) ) {
                                    ?>
                                    <div id="advance-search-wrapper-<?php echo esc_attr($widget_id); ?>" class="advance-search-wrapper">
                                        <div class="advance-search-wrapper-fields form-theme">

                                            <?php
                                            if ( $advance_search_layout_type == 'popup' ) {
                                                ?>
                                                <div class="advance-search-top d-flex align-items-center">
                                                    <?php if ( !empty($advance_search_title) ) { ?>
                                                        <h4 class="advance-title"><?php echo esc_html($advance_search_title); ?></h4>
                                                    <?php } ?>
                                                    <div class="ms-auto">
                                                        <span class="close-advance-popup"><i class="ti-close"></i></span>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                            <div class="inner-search-advance">
                                                <div class="inner">
                                                    <div class="row">
                                                        <?php
                                                        $this->form_fields_display($advance_search_fields, $filter_fields, $instance, $args);
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>

                                            <?php
                                            if ( $advance_search_layout_type == 'popup' ) {
                                                ?>
                                                <div class="advance-search-bottom">
                                                    <?php if ( !empty($advance_search_btn_text) ) { ?>
                                                        <div class="row">
                                                            <div class="col-12 form-group-search">
                                                                <button class="submit-advance-search-btn btn-submit w-100 btn btn-theme <?php echo trim( ($filter_btn_text)?'':'no-text' ); ?>" type="submit" data-form_id="#filter-listing-form-<?php echo esc_attr($widget_id); ?>">
                                                                    <i class="flaticon-search pre"></i>
                                                                    <?php echo trim($advance_search_btn_text); ?>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    <?php } ?>

                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                                <?php if($show_button_search == 'yes') { ?>
                                    <div class="row">
                                        <div class="col-<?php echo esc_attr($btn_columns_mobile); ?> col-md-<?php echo esc_attr($btn_columns_tablet); ?> col-xl-<?php echo esc_attr($btn_columns); ?> form-group-search">
                                            <button class="btn-submit w-100 btn btn-theme <?php echo trim( ($filter_btn_text)?'':'no-text' ); ?>" type="submit">
                                                <i class="flaticon-search pre"></i>
                                                <?php echo trim($filter_btn_text); ?>
                                            </button>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        
                    <?php } ?>
                </div>
            </form>
        </div>
        <?php
    }

    public function form_fields_display($search_fields, $filter_fields, $instance, $args) {
        $i = 1;
        if ( !empty($search_fields) ) {
            foreach ($search_fields as $item) {
                if ( empty($filter_fields[$item['filter_field']]['field_call_back']) ) {
                    continue;
                }
                $filter_field = $filter_fields[$item['filter_field']];
                if ( isset($item['placeholder']) ) {
                    $filter_field['placeholder'] = $item['placeholder'];
                }

                if ( isset($item['title']) ) {
                    $filter_field['name'] = $item['title'];
                    $filter_field['show_title'] = true;
                } else {
                    $filter_field['show_title'] = false;
                }

                if ( isset($item['icon']) ) {
                    $filter_field['icon'] = $item['icon'];
                }

                $columns = !empty($item['columns']) ? $item['columns'] : 12;
                $columns_tablet = !empty($item['columns_tablet']) ? $item['columns_tablet'] : $item['columns'];
                $columns_mobile = !empty($item['columns_mobile']) ? $item['columns_mobile'] : 12;
                
                if ( $item['filter_layout'] && in_array($item['filter_field'], array('category', 'location')) ) {
                    switch ($item['filter_layout']) {
                        case 'radio':
                            $filter_field['field_call_back'] = array( 'WP_RealEstate_Abstract_Filter', 'filter_field_taxonomy_hierarchical_radio_list');
                            break;
                        case 'check_list':
                            $filter_field['field_call_back'] = array( 'WP_RealEstate_Abstract_Filter', 'filter_field_taxonomy_hierarchical_check_list');
                            break;
                        default:
                            $filter_field['field_call_back'] = array( 'WP_RealEstate_Abstract_Filter', 'filter_field_taxonomy_hierarchical_select');
                            break;
                    }
                }
                ?>
                <div class="col-<?php echo esc_attr($columns_mobile); ?> col-md-<?php echo esc_attr($columns_tablet); ?> col-xl-<?php echo esc_attr($columns); ?>">
                    <?php call_user_func( $filter_field['field_call_back'], $instance, $args, $item['filter_field'], $filter_field ); ?>
                </div>
                <?php
            }
        }
    }
}

Elementor\Plugin::instance()->widgets_manager->register( new Homez_Elementor_RealEstate_Agent_Search_Form );