<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Homez_Elementor_RealEstate_Properties_Tabs extends Elementor\Widget_Base {

	public function get_name() {
        return 'apus_element_realestate_properties_tabs';
    }

	public function get_title() {
        return esc_html__( 'Apus Properties Tabs', 'homez' );
    }
    
	public function get_categories() {
        return [ 'homez-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Properties', 'homez' ),
                'tab' => Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'title', [
                'label' => esc_html__( 'Tab Title', 'homez' ),
                'type' => Elementor\Controls_Manager::TEXT
            ]
        );

        $repeater->add_control(
            'status_slugs',
            [
                'label' => esc_html__( 'Statuses Slug', 'homez' ),
                'type' => Elementor\Controls_Manager::TEXTAREA,
                'rows' => 2,
                'default' => '',
                'placeholder' => esc_html__( 'Enter slugs spearate by comma(,)', 'homez' ),
            ]
        );

        $repeater->add_control(
            'type_slugs',
            [
                'label' => esc_html__( 'Types Slug', 'homez' ),
                'type' => Elementor\Controls_Manager::TEXTAREA,
                'rows' => 2,
                'default' => '',
                'placeholder' => esc_html__( 'Enter slugs spearate by comma(,)', 'homez' ),
            ]
        );

        $repeater->add_control(
            'location_slugs',
            [
                'label' => esc_html__( 'Location Slug', 'homez' ),
                'type' => Elementor\Controls_Manager::TEXTAREA,
                'rows' => 2,
                'default' => '',
                'placeholder' => esc_html__( 'Enter slugs spearate by comma(,)', 'homez' ),
            ]
        );

        $repeater->add_control(
            'amenity_slugs',
            [
                'label' => esc_html__( 'Amenities Slug', 'homez' ),
                'type' => Elementor\Controls_Manager::TEXTAREA,
                'rows' => 2,
                'default' => '',
                'placeholder' => esc_html__( 'Enter slugs spearate by comma(,)', 'homez' ),
            ]
        );

        $repeater->add_control(
            'material_slugs',
            [
                'label' => esc_html__( 'Materials Slug', 'homez' ),
                'type' => Elementor\Controls_Manager::TEXTAREA,
                'rows' => 2,
                'default' => '',
                'placeholder' => esc_html__( 'Enter slugs spearate by comma(,)', 'homez' ),
            ]
        );

        $repeater->add_control(
            'label_slugs',
            [
                'label' => esc_html__( 'Label Slug', 'homez' ),
                'type' => Elementor\Controls_Manager::TEXTAREA,
                'rows' => 2,
                'default' => '',
                'placeholder' => esc_html__( 'Enter slugs spearate by comma(,)', 'homez' ),
            ]
        );

        $repeater->add_control(
            'orderby',
            [
                'label' => esc_html__( 'Order by', 'homez' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'options' => array(
                    '' => esc_html__('Default', 'homez'),
                    'date' => esc_html__('Date', 'homez'),
                    'ID' => esc_html__('ID', 'homez'),
                    'author' => esc_html__('Author', 'homez'),
                    'title' => esc_html__('Title', 'homez'),
                    'modified' => esc_html__('Modified', 'homez'),
                    'rand' => esc_html__('Random', 'homez'),
                    'comment_count' => esc_html__('Comment count', 'homez'),
                    'menu_order' => esc_html__('Menu order', 'homez'),
                ),
                'default' => ''
            ]
        );

        $repeater->add_control(
            'order',
            [
                'label' => esc_html__( 'Sort order', 'homez' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'options' => array(
                    '' => esc_html__('Default', 'homez'),
                    'ASC' => esc_html__('Ascending', 'homez'),
                    'DESC' => esc_html__('Descending', 'homez'),
                ),
                'default' => ''
            ]
        );

        $repeater->add_control(
            'get_properties_by',
            [
                'label' => esc_html__( 'Get Properties By', 'homez' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'options' => array(
                    'featured' => esc_html__('Featured Properties', 'homez'),
                    'urgent' => esc_html__('Urgent Properties', 'homez'),
                    'recent' => esc_html__('Recent Properties', 'homez'),
                ),
                'default' => 'recent'
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
        $this->add_control(
            'description',
            [
                'label' => esc_html__( 'Description', 'homez' ),
                'type' => Elementor\Controls_Manager::TEXTAREA,
                'placeholder' => esc_html__( 'Enter your description here', 'homez' ),
            ]
        );

        $this->add_control(
            'tabs',
            [
                'label' => esc_html__( 'Tabs', 'homez' ),
                'type' => Elementor\Controls_Manager::REPEATER,
                'placeholder' => esc_html__( 'Enter your property tabs here', 'homez' ),
                'fields' => $repeater->get_controls(),
            ]
        );

        $this->add_control(
            'limit',
            [
                'label' => esc_html__( 'Limit', 'homez' ),
                'type' => Elementor\Controls_Manager::NUMBER,
                'input_type' => 'number',
                'description' => esc_html__( 'Limit properties to display', 'homez' ),
                'default' => 4
            ]
        );
        
        $this->add_control(
            'property_item_style',
            [
                'label' => esc_html__( 'Property Item Style', 'homez' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'options' => array(
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
                'default' => 'grid'
            ]
        );

        $this->add_control(
            'layout_type',
            [
                'label' => esc_html__( 'Layout', 'homez' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'options' => array(
                    'grid' => esc_html__('Grid', 'homez'),
                    'carousel' => esc_html__('Carousel', 'homez'),
                ),
                'default' => 'grid'
            ]
        );

        $columns = range( 1, 12 );
        $columns = array_combine( $columns, $columns );

        $this->add_responsive_control(
            'columns',
            [
                'label' => esc_html__( 'Columns', 'homez' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'options' => $columns,
                'frontend_available' => true,
                'default' => 3,
            ]
        );

        $this->add_responsive_control(
            'slides_to_scroll',
            [
                'label' => esc_html__( 'Slides to Scroll', 'homez' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'description' => esc_html__( 'Set how many slides are scrolled per swipe.', 'homez' ),
                'options' => $columns,
                'condition' => [
                    'columns!' => '1',
                    'layout_type' => 'carousel',
                ],
                'frontend_available' => true,
                'default' => 3,
            ]
        );

        $this->add_control(
            'rows',
            [
                'label' => esc_html__( 'Rows', 'homez' ),
                'type' => Elementor\Controls_Manager::TEXT,
                'input_type' => 'number',
                'placeholder' => esc_html__( 'Enter your rows number here', 'homez' ),
                'default' => 1,
                'condition' => [
                    'layout_type' => 'carousel',
                ],
            ]
        );

        $this->add_control(
            'show_nav',
            [
                'label'         => esc_html__( 'Show Navigation', 'homez' ),
                'type'          => Elementor\Controls_Manager::SWITCHER,
                'label_on'      => esc_html__( 'Show', 'homez' ),
                'label_off'     => esc_html__( 'Hide', 'homez' ),
                'return_value'  => true,
                'default'       => true,
                'condition' => [
                    'layout_type' => 'carousel',
                ],
            ]
        );

        $this->add_control(
            'show_pagination',
            [
                'label'         => esc_html__( 'Show Pagination', 'homez' ),
                'type'          => Elementor\Controls_Manager::SWITCHER,
                'label_on'      => esc_html__( 'Show', 'homez' ),
                'label_off'     => esc_html__( 'Hide', 'homez' ),
                'return_value'  => true,
                'default'       => true,
                'condition' => [
                    'layout_type' => 'carousel',
                ],
            ]
        );

        $this->add_control(
            'style_action',
            [
                'label' => esc_html__( 'Style Pagination, Navigation', 'homez' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'options' => array(
                    '' => esc_html__('Default', 'homez'),
                    'st_white' => esc_html__('White', 'homez'),
                ),
                'default' => '',
                'condition' => [
                    'layout_type' => 'carousel',
                ],
            ]
        );

        $this->add_control(
            'slider_autoplay',
            [
                'label'         => esc_html__( 'Autoplay', 'homez' ),
                'type'          => Elementor\Controls_Manager::SWITCHER,
                'label_on'      => esc_html__( 'Yes', 'homez' ),
                'label_off'     => esc_html__( 'No', 'homez' ),
                'return_value'  => true,
                'default'       => true,
                'condition' => [
                    'layout_type' => 'carousel',
                ],
            ]
        );

        $this->add_control(
            'infinite_loop',
            [
                'label'         => esc_html__( 'Infinite Loop', 'homez' ),
                'type'          => Elementor\Controls_Manager::SWITCHER,
                'label_on'      => esc_html__( 'Yes', 'homez' ),
                'label_off'     => esc_html__( 'No', 'homez' ),
                'return_value'  => true,
                'default'       => true,
                'condition' => [
                    'layout_type' => 'carousel',
                ],
            ]
        );

        $this->add_control(
            'view_more_text',
            [
                'label' => esc_html__( 'View More Button Text', 'homez' ),
                'type' => Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Enter your view more text here', 'homez' ),
            ]
        );

        $this->add_control(
            'view_more_url',
            [
                'label' => esc_html__( 'View More URL', 'homez' ),
                'type' => Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__( 'Enter your view more url here', 'homez' ),
            ]
        );

   		$this->add_control(
            'el_class',
            [
                'label'         => esc_html__( 'Extra class name', 'homez' ),
                'type'          => Elementor\Controls_Manager::TEXT,
                'placeholder'   => esc_html__( 'If you wish to style particular content element differently, please add a class name to this field and refer to it in your custom CSS file.', 'homez' ),
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'section_button_style',
            [
                'label' => esc_html__( 'Tabs', 'homez' ),
                'tab' => Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'title_color',
            [
                'label' => esc_html__( 'Title Color', 'homez' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .widgettitle' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'des_color',
            [
                'label' => esc_html__( 'Description Color', 'homez' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .des' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'more_options',
            [
                'label' => esc_html__( 'Tabs', 'homez' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
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
                'tab_color',
                [
                    'label' => esc_html__( 'Tab Color', 'homez' ),
                    'type' => Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .tabs-properties > li > a' => 'color: {{VALUE}};',
                    ],
                ]
            );
            $this->add_group_control(
                Elementor\Group_Control_Background::get_type(),
                [
                    'name' => 'background_tab',
                    'label' => esc_html__( 'Background', 'homez' ),
                    'types' => [ 'classic', 'gradient', 'video' ],
                    'selector' => '{{WRAPPER}} .tabs-properties > li > a',
                ]
            );

            $this->add_group_control(
                Elementor\Group_Control_Border::get_type(),
                [
                    'name' => 'border_tab',
                    'label' => esc_html__( 'Border', 'homez' ),
                    'selector' => '{{WRAPPER}} .tabs-properties > li > a',
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
                    'label' => esc_html__( 'Tab Color', 'homez' ),
                    'type' => Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .tabs-properties > li > a.active' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_group_control(
                Elementor\Group_Control_Background::get_type(),
                [
                    'name' => 'background_tab_hover',
                    'label' => esc_html__( 'Background', 'homez' ),
                    'types' => [ 'classic', 'gradient', 'video' ],
                    'selector' => '{{WRAPPER}} .tabs-properties > li > a.active',
                ]
            );

            $this->add_control(
                'tab_hover_border_color',
                [
                    'label' => esc_html__( 'Border Color', 'homez' ),
                    'type' => Elementor\Controls_Manager::COLOR,
                    'condition' => [
                        'border_tab_border!' => '',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .tabs-properties > li > a.active' => 'border-color: {{VALUE}};',
                    ],
                ]
            );

            $this->end_controls_tab();

        $this->end_controls_tabs();
        // end tab 

        $this->end_controls_section();

        $this->start_controls_section(
            'section_button_more_style',
            [
                'label' => esc_html__( 'View More', 'homez' ),
                'tab' => Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs( 'button_more_style' );

            $this->start_controls_tab(
                'button_more_normal',
                [
                    'label' => esc_html__( 'Normal', 'homez' ),
                ]
            );
            
            $this->add_control(
                'button_more_color',
                [
                    'label' => esc_html__( 'Color', 'homez' ),
                    'type' => Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .bottom-remore .btn' => 'color: {{VALUE}};',
                    ],
                ]
            );
            $this->add_group_control(
                Elementor\Group_Control_Background::get_type(),
                [
                    'name' => 'background_button_more',
                    'label' => esc_html__( 'Background', 'homez' ),
                    'types' => [ 'classic', 'gradient', 'video' ],
                    'selector' => '{{WRAPPER}} .bottom-remore .btn',
                ]
            );

            $this->add_group_control(
                Elementor\Group_Control_Border::get_type(),
                [
                    'name' => 'border_button_more',
                    'label' => esc_html__( 'Border', 'homez' ),
                    'selector' => '{{WRAPPER}} .bottom-remore .btn',
                ]
            );

            $this->end_controls_tab();

            // tab hover
            $this->start_controls_tab(
                'button_more_hover',
                [
                    'label' => esc_html__( 'Hover', 'homez' ),
                ]
            );

            $this->add_control(
                'button_more_hover_color',
                [
                    'label' => esc_html__( 'Color', 'homez' ),
                    'type' => Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .bottom-remore .btn:hover, {{WRAPPER}} .bottom-remore .btn:focus' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_group_control(
                Elementor\Group_Control_Background::get_type(),
                [
                    'name' => 'background_button_more_hover',
                    'label' => esc_html__( 'Background', 'homez' ),
                    'types' => [ 'classic', 'gradient', 'video' ],
                    'selector' => '{{WRAPPER}} .bottom-remore .btn:hover, {{WRAPPER}} .bottom-remore .btn:focus',
                ]
            );

            $this->add_control(
                'button_more_hover_border_color',
                [
                    'label' => esc_html__( 'Border Color', 'homez' ),
                    'type' => Elementor\Controls_Manager::COLOR,
                    'condition' => [
                        'border_button_more_border!' => '',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .bottom-remore .btn:hover, {{WRAPPER}} .bottom-remore .btn:focus' => 'border-color: {{VALUE}};',
                    ],
                ]
            );

            $this->end_controls_tab();

        $this->end_controls_tabs();
        // end tab 

        $this->add_control(
            'button_more_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'homez' ),
                'type' => Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .bottom-remore .btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

    }

	protected function render() {
        $settings = $this->get_settings();

        extract( $settings );
        $_id = homez_random_key();
        ?>
        <div class="widget-properties-tabs <?php echo esc_attr($layout_type); ?> <?php echo esc_attr($el_class); ?>">

            <div class="d-sm-flex info-widget-top align-items-end">
                <?php if( !empty($title) || !empty($description) ){ ?>
                    <div class="inner-left">
                        <?php if( !empty($title) ) { ?>
                            <h2 class="widgettitle" >
                               <?php echo trim( $title ); ?>
                            </h2>
                        <?php } ?>
                        <?php if ( !empty($description) ) { ?>
                            <div class="des">
                                <?php echo trim( $description ); ?>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
                <div class="ms-auto">
                    <ul class="nav nav-tabs tabs-properties">
                        <?php $tab_count = 0; foreach ($tabs as $tab) : ?>
                            <li>
                                <a href="#tab-<?php echo esc_attr($_id);?>-<?php echo esc_attr($tab_count); ?>" class="<?php echo esc_attr($tab_count == 0 ? 'active' : '');?>" data-bs-toggle="tab">
                                    <?php if ( !empty($tab['title']) ) { ?>
                                        <?php echo trim($tab['title']); ?>
                                    <?php } ?>
                                </a>
                            </li>
                        <?php $tab_count++; endforeach; ?>
                    </ul>
                </div>
            </div>
            <div class="tab-content">
                <?php
                    $columns = !empty($columns) ? $columns : 3;
                    $columns_tablet = !empty($columns_tablet) ? $columns_tablet : $columns;
                    $columns_mobile = !empty($columns_mobile) ? $columns_mobile : 1;
                    
                    $slides_to_scroll = !empty($slides_to_scroll) ? $slides_to_scroll : $columns;
                    $slides_to_scroll_tablet = !empty($slides_to_scroll_tablet) ? $slides_to_scroll_tablet : $slides_to_scroll;
                    $slides_to_scroll_mobile = !empty($slides_to_scroll_mobile) ? $slides_to_scroll_mobile : 1;

                    $tab_count = 0; foreach ($tabs as $tab) : ?>
                    <div id="tab-<?php echo esc_attr($_id);?>-<?php echo esc_attr($tab_count); ?>" class="tab-pane fade <?php echo esc_attr($tab_count == 0 ? 'show active' : ''); ?>">
                        <?php

                        $status_slugs = !empty($tab['status_slugs']) ? array_map('trim', explode(',', $tab['status_slugs'])) : array();
                        $category_slugs = !empty($tab['category_slugs']) ? array_map('trim', explode(',', $tab['category_slugs'])) : array();
                        $type_slugs = !empty($tab['type_slugs']) ? array_map('trim', explode(',', $tab['type_slugs'])) : array();
                        $location_slugs = !empty($tab['location_slugs']) ? array_map('trim', explode(',', $tab['location_slugs'])) : array();
                        $amenity_slugs = !empty($tab['amenity_slugs']) ? array_map('trim', explode(',', $tab['amenity_slugs'])) : array();
                        $material_slugs = !empty($tab['material_slugs']) ? array_map('trim', explode(',', $tab['material_slugs'])) : array();
                        $label_slugs = !empty($tab['label_slugs']) ? array_map('trim', explode(',', $tab['label_slugs'])) : array();

                        $args = array(
                            'limit' => $limit,
                            'get_properties_by' => !empty($tab['get_properties_by']) ? $tab['get_properties_by'] : 'recent',
                            'orderby' => !empty($tab['orderby']) ? $tab['orderby'] : '',
                            'order' => !empty($tab['order']) ? $tab['order'] : '',
                            'statuses' => $status_slugs,
                            'categories' => $category_slugs,
                            'types' => $type_slugs,
                            'locations' => $location_slugs,
                            'amenities' => $amenity_slugs,
                            'materials' => $material_slugs,
                            'labels' => $label_slugs,
                        );
                        $loop = homez_get_properties($args);
                        if ( $loop->have_posts() ) {
                            ?>
                            <?php if ( $layout_type == 'carousel' ): ?>
                                <div class="slick-carousel <?php echo esc_attr($style_action); ?>"
                                    data-items="<?php echo esc_attr($columns); ?>"
                                    data-large="<?php echo esc_attr( $columns_tablet ); ?>"
                                    data-medium="<?php echo esc_attr( $columns_tablet ); ?>"
                                    data-small="<?php echo esc_attr($columns_mobile); ?>"
                                    data-smallest="<?php echo esc_attr($columns_mobile); ?>"

                                    data-slidestoscroll="<?php echo esc_attr($slides_to_scroll); ?>"
                                    data-slidestoscroll_large="<?php echo esc_attr( $slides_to_scroll_tablet ); ?>"
                                    data-slidestoscroll_medium="<?php echo esc_attr( $slides_to_scroll_tablet ); ?>"
                                    data-slidestoscroll_small="<?php echo esc_attr($slides_to_scroll_mobile); ?>"
                                    data-slidestoscroll_smallest="<?php echo esc_attr($slides_to_scroll_mobile); ?>"

                                    data-pagination="<?php echo esc_attr( $show_pagination ? 'true' : 'false' ); ?>" data-nav="<?php echo esc_attr( $show_nav ? 'true' : 'false' ); ?>" data-rows="<?php echo esc_attr( $rows ); ?>" data-infinite="<?php echo esc_attr( $infinite_loop ? 'true' : 'false' ); ?>" data-autoplay="<?php echo esc_attr( $slider_autoplay ? 'true' : 'false' ); ?>">
                                    <?php while ( $loop->have_posts() ): $loop->the_post(); ?>
                                        <div class="cl-inner">
                                            <?php echo WP_RealEstate_Template_Loader::get_template_part( 'template-properties/properties-styles/inner-'.$property_item_style ); ?>
                                        </div>
                                    <?php endwhile; ?>
                                </div>
                            <?php else: ?>
                                <?php
                                    $mdcol = 12/$columns;
                                    $smcol = 12/$columns_tablet;
                                    $xscol = 12/$columns_mobile;
                                ?>
                                <div class="row">
                                    <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
                                        <div class="col-lg-<?php echo esc_attr($mdcol); ?> col-md-<?php echo esc_attr($smcol); ?> col-<?php echo esc_attr( $xscol ); ?>">
                                            <?php echo WP_RealEstate_Template_Loader::get_template_part( 'template-properties/properties-styles/inner-'.$property_item_style ); ?>
                                        </div>
                                    <?php endwhile; ?>
                                </div>
                            <?php endif; ?>
                            <?php wp_reset_postdata(); ?>
                        <?php } ?>
                    </div>
                <?php $tab_count++; endforeach; ?>
            </div>
            <?php 
            if ( $view_more_text ) { ?>
                <div class="bottom-remore text-center">
                    <?php
                    $view_more_html = '<a class="btn btn-theme" href="'.esc_url($view_more_url['url']).'" target="'.esc_attr($view_more_url['is_external'] ? '_blank' : '_self').'" '.($view_more_url['nofollow'] ? 'rel="nofollow"' : '').'>' . $view_more_text . '<i class="flaticon-up-right-arrow next"></i></a>';
                    echo trim($view_more_html);
                    ?>
                </div>
            <?php } ?>
        </div>
        <?php
    }
}

Elementor\Plugin::instance()->widgets_manager->register( new Homez_Elementor_RealEstate_Properties_Tabs );