<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Homez_Elementor_Mailchimp extends Widget_Base {

	public function get_name() {
        return 'apus_element_mailchimp';
    }

	public function get_title() {
        return esc_html__( 'Apus MailChimp Sign-Up Form', 'homez' );
    }
    
	public function get_categories() {
        return [ 'homez-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'MailChimp Sign-Up Form', 'homez' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => esc_html__( 'Title', 'homez' ),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Enter your title here', 'homez' ),
            ]
        );
        
        $this->add_control(
            'style',
            [
                'label' => esc_html__( 'Style', 'homez' ),
                'type' => Controls_Manager::SELECT,
                'options' => array(
                    'style1' => esc_html__('Style 1', 'homez'),
                    'style2' => esc_html__('Style 2', 'homez'),
                    'style3' => esc_html__('Style 3', 'homez'),
                ),
                'default' => 'style1'
            ]
        );

   		$this->add_control(
            'el_class',
            [
                'label'         => esc_html__( 'Extra class name', 'homez' ),
                'type'          => Controls_Manager::TEXT,
                'placeholder'   => esc_html__( 'If you wish to style particular content element differently, please add a class name to this field and refer to it in your custom CSS file.', 'homez' ),
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_box_style',
            [
                'label' => esc_html__( 'Box', 'homez' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'box_bg_color',
            [
                'label' => esc_html__( 'Background Color', 'homez' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} form.mc4wp-form' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'border',
                'label' => esc_html__( 'Border', 'homez' ),
                'selector' => '{{WRAPPER}} form.mc4wp-form',
            ]
        );

        $this->add_control(
            'box_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'homez' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} form.mc4wp-form' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_title_style',
            [
                'label' => esc_html__( 'Information', 'homez' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__( 'Title Color', 'homez' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .widget-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__( 'Title Typography', 'homez' ),
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .widget-title',
            ]
        );

        $this->add_control(
            'input_color',
            [
                'label' => esc_html__( 'Input Color', 'homez' ),
                'type' => Controls_Manager::COLOR,
                
                'selectors' => [
                    '{{WRAPPER}} input' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'input_placeholder_color',
            [
                'label' => esc_html__( 'Input Placeholder Color', 'homez' ),
                'type' => Controls_Manager::COLOR,
                
                'selectors' => [
                    '{{WRAPPER}} input::-webkit-input-placeholder' => 'color: {{VALUE}};',
                    '{{WRAPPER}} input::-moz-placeholder' => 'color: {{VALUE}};',
                    '{{WRAPPER}} input:-ms-input-placeholder' => 'color: {{VALUE}};',
                    '{{WRAPPER}} input:-moz-placeholder' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'input_bg_color',
            [
                'label' => esc_html__( 'Input Background', 'homez' ),
                'type' => Controls_Manager::COLOR,
                
                'selectors' => [
                    '{{WRAPPER}} input' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'section_button_style',
            [
                'label' => esc_html__( 'Button', 'homez' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            $this->start_controls_tabs(
                'style_tabs'
            );
                $this->start_controls_tab(
                    'button_normal_tab',
                        [
                            'label' => esc_html__( 'Normal', 'homez' ),
                        ]
                    );
                    $this->add_control(
                        'btn_color',
                        [
                            'label' => esc_html__( 'Color', 'homez' ),
                            'type' => Controls_Manager::COLOR,
                            
                            'selectors' => [
                                '{{WRAPPER}} [type="submit"]' => 'color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_control(
                        'btn_bg_color',
                        [
                            'label' => esc_html__( 'Background', 'homez' ),
                            'type' => Controls_Manager::COLOR,
                            
                            'selectors' => [
                                '{{WRAPPER}} [type="submit"]' => 'background: {{VALUE}};',
                            ],
                        ]
                    );
                    $this->add_control(
                        'btn_br_color',
                        [
                            'label' => esc_html__( 'Border', 'homez' ),
                            'type' => Controls_Manager::COLOR,
                            
                            'selectors' => [
                                '{{WRAPPER}} [type="submit"]' => 'border-color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_control(
                        'button_border_radius',
                        [
                            'label' => esc_html__( 'Border Radius', 'homez' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%' ],
                            'selectors' => [
                                '{{WRAPPER}} [type="submit"]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );

                $this->end_controls_tab();

                $this->start_controls_tab(
                    'button_hover_tab',
                        [
                            'label' => esc_html__( 'Hover', 'homez' ),
                        ]
                    );
                    $this->add_control(
                        'btn_hover_color',
                        [
                            'label' => esc_html__( 'Color', 'homez' ),
                            'type' => Controls_Manager::COLOR,
                            
                            'selectors' => [
                                '{{WRAPPER}} [type="submit"]:hover' => 'color: {{VALUE}};',
                                '{{WRAPPER}} [type="submit"]:focus' => 'color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_control(
                        'btn_hover_bg_color',
                        [
                            'label' => esc_html__( 'Background', 'homez' ),
                            'type' => Controls_Manager::COLOR,
                            
                            'selectors' => [
                                '{{WRAPPER}} [type="submit"]:hover' => 'background: {{VALUE}};',
                                '{{WRAPPER}} [type="submit"]:focus' => 'background: {{VALUE}};',
                            ],
                        ]
                    );
                    $this->add_control(
                        'btn_hover_br_color',
                        [
                            'label' => esc_html__( 'Border', 'homez' ),
                            'type' => Controls_Manager::COLOR,
                            
                            'selectors' => [
                                '{{WRAPPER}} [type="submit"]:hover' => 'border-color: {{VALUE}};',
                                '{{WRAPPER}} [type="submit"]:focus' => 'border-color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_control(
                        'button_hv_border_radius',
                        [
                            'label' => esc_html__( 'Border Radius', 'homez' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%' ],
                            'selectors' => [
                                '{{WRAPPER}} [type="submit"]:hover, {{WRAPPER}} [type="submit"]:focus' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );

                $this->end_controls_tab();

            $this->end_controls_tabs();

        $this->end_controls_section();
        // end tab for button
    }

	protected function render() {

        $settings = $this->get_settings();

        extract( $settings );

        ?>
        <div class="widget-mailchimp widget m-0 <?php echo esc_attr($el_class.' '.$style); ?>">
            <?php if ( !empty($title) ) { ?>
                <h2 class="widget-title"><?php echo esc_html($title); ?></h2>
            <?php } ?>
            <?php mc4wp_show_form(''); ?>
        </div>
        <?php
    }
}
Plugin::instance()->widgets_manager->register( new Homez_Elementor_Mailchimp );