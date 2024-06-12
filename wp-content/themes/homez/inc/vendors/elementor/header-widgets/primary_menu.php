<?php

//namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Homez_Elementor_Primary_Menu extends Elementor\Widget_Base {

	public function get_name() {
        return 'apus_element_primary_menu';
    }

	public function get_title() {
        return esc_html__( 'Apus Header Primary Menu', 'homez' );
    }
    
	public function get_categories() {
        return [ 'homez-header-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Content', 'homez' ),
                'tab' => Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_responsive_control(
            'align',
            [
                'label' => esc_html__( 'Alignment', 'homez' ),
                'type' => Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'homez' ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'homez' ),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'homez' ),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}' => 'text-align: {{VALUE}};',
                ],
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
            'section_title_style',
            [
                'label' => esc_html__( 'Style', 'homez' ),
                'tab' => Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'effect',
            [
                'label' => esc_html__( 'Effect Dropdown Menu', 'homez' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'options' => array(
                    'effect1' => esc_html__('Effect 1', 'homez'),
                    'effect2' => esc_html__('Effect 2', 'homez'),
                    'effect3' => esc_html__('Effect 3', 'homez'),
                ),
                'default' => 'effect1'
            ]
        );

        $this->add_responsive_control(
            'menu_padding',
            [
                'label' => esc_html__( 'Padding Menu', 'homez' ),
                'type' => Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .megamenu > li > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'menu_margin',
            [
                'label' => esc_html__( 'Margin Menu', 'homez' ),
                'type' => Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .megamenu > li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'menu_border_radius',
            [
                'label' => esc_html__( 'Border Radius Menu', 'homez' ),
                'type' => Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .megamenu > li > a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'menu_color',
            [
                'label' => esc_html__( 'Color Menu', 'homez' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .megamenu > li > a' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'menu_hover_color',
            [
                'label' => esc_html__( 'Color Hover Menu', 'homez' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .megamenu > li:hover > a,{{WRAPPER}} .megamenu > li.active > a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'menu_bg_ac_color',
            [
                'label' => esc_html__( 'Background Color Hover Menu', 'homez' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .megamenu > li:hover > a, {{WRAPPER}} .megamenu > li.active > a' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'menu_line_ac_color',
            [
                'label' => esc_html__( 'Color Underline', 'homez' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .megamenu > li::before' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__( 'Typography', 'homez' ),
                'name' => 'menu_typography',
                'selector' => '{{WRAPPER}} .megamenu > li > a',
            ]
        );

        $this->add_control(
            'dp_color',
            [
                'label' => esc_html__( 'Color Dropdown Menu', 'homez' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .megamenu .dropdown-menu li > a' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'dp_hover_color',
            [
                'label' => esc_html__( 'Color Hover Dropdown Menu', 'homez' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .megamenu .dropdown-menu li.current-menu-item > a,
                    {{WRAPPER}} .megamenu .dropdown-menu li.open > a,
                    {{WRAPPER}}  .megamenu .dropdown-menu li.active > a,
                    {{WRAPPER}} .megamenu .dropdown-menu li:hover > a' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'bg_dp_color',
            [
                'label' => esc_html__( 'Background Color Dropdown Menu', 'homez' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .megamenu .dropdown-menu' => 'background-color: {{VALUE}};',
                ],
            ]
        );
    

        $this->end_controls_section();

    }

	protected function render() {

        $settings = $this->get_settings();

        extract( $settings );

        if ( has_nav_menu( 'primary' ) ) {
            $add_class = '';
            if ( !empty($align) ) {
                $add_class = 'menu-'.$align;
            }
            ?>
            <div class="main-menu <?php echo esc_attr($add_class.' '.$el_class); ?>">
                <nav data-duration="400" class="apus-megamenu animate navbar navbar-expand-lg p-0" role="navigation">
                <?php
                    $args = array(
                        'theme_location' => 'primary',
                        'container_class' => 'collapse navbar-collapse no-padding',
                        'menu_class' => 'nav navbar-nav megamenu '.$effect,
                        'fallback_cb' => '',
                        'menu_id' => 'primary-menu',
                        'walker' => new Homez_Nav_Menu()
                    );
                    wp_nav_menu($args);
                ?>
                </nav>
            </div>
            <?php
        }
    }

}

Elementor\Plugin::instance()->widgets_manager->register( new Homez_Elementor_Primary_Menu );