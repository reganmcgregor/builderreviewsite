<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Homez_Elementor_Nav_Bar extends Widget_Base {

	public function get_name() {
        return 'apus_element_nav_bar';
    }

	public function get_title() {
        return esc_html__( 'Apus Header NavBar', 'homez' );
    }
    
	public function get_categories() {
        return [ 'voiture-header-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Content', 'homez' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $ele_obj = Plugin::$instance;
        $templates = $ele_obj->templates_manager->get_source( 'local' )->get_items();

        if ( empty( $templates ) ) {

            $this->add_control(
                'no_templates',
                array(
                    'label' => false,
                    'type'  => Controls_Manager::RAW_HTML,
                    'raw'   => $this->empty_templates_message(),
                )
            );

            return;
        }

        $options = [
            '0' => '— ' . esc_html__( 'Select', 'homez' ) . ' —',
        ];

        $types = [];

        foreach ( $templates as $template ) {
            $options[ $template['template_id'] ] = $template['title'] . ' (' . $template['type'] . ')';
            $types[ $template['template_id'] ] = $template['type'];
        }

        $this->add_control(
            'title',
            [
                'label' => esc_html__( 'Title', 'homez' ),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Enter your title here', 'homez' ),
            ]
        );

        $this->add_control(
            'item_template_id',
            [
                'label'       => esc_html__( 'Choose Template', 'homez' ),
                'type'        => Controls_Manager::SELECT,
                'default'     => '0',
                'options'     => $options,
                'types'       => $types,
                'label_block' => 'true',
            ]
        );

        $this->add_responsive_control(
            'style',
            [
                'label' => esc_html__( 'Style', 'homez' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'st_right' => esc_html__( 'Right', 'homez' ),
                    'st_left' => esc_html__( 'Left', 'homez' ),
                ],
                'default' => 'st_right'
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
            'section_icon_style',
            [
                'label' => esc_html__( 'Icon', 'homez' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__( 'Color Icon', 'homez' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .vertical-icon::before' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .vertical-icon::after' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'icon_hv_color',
            [
                'label' => esc_html__( 'Color Hover Icon', 'homez' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .vertical-icon:hover:before' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .vertical-icon:hover:after' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

	protected function render() {

        $settings = $this->get_settings();

        extract( $settings );

        ?>
        <div class="navbar-wrapper <?php echo esc_attr($el_class.' '.$style); ?>">
            <span class="show-navbar-sidebar"><i class="vertical-icon"></i></span>
            <div class="navbar-sidebar-wrapper">
                <div class="navbar-header d-flex align-items-center">
                    <?php if ( !empty($title) ) { ?>
                        <h3 class="title-navbar"><?php echo esc_html($title); ?></h3>
                    <?php } ?>
                    <div class="ms-auto"><a href="javascript:void(0);" class="close-navbar-sidebar"><i class="ti-close"></i></a></div>
                </div>
                <?php
                $ele_obj = Plugin::$instance;
                $content_html = '';
                
                if ( '0' !== $item_template_id ) {

                    $template_content = $ele_obj->frontend->get_builder_content_for_display( $item_template_id );

                    if ( ! empty( $template_content ) ) {
                        $content_html .= $template_content;

                        if ( Plugin::$instance->editor->is_edit_mode() ) {
                            $link = add_query_arg(
                                array(
                                    'elementor' => '',
                                ),
                                get_permalink( $item_template_id )
                            );

                            $content_html .= sprintf( '<div class="homez__edit-cover" data-template-edit-link="%s"><i class="fa fa-pencil"></i><span>%s</span></div>', $link, esc_html__( 'Edit Template', 'homez' ) );
                        }
                    } else {
                        $content_html = $this->no_template_content_message();
                    }
                } else {
                    $content_html = $this->no_templates_message();
                }

                echo trim($content_html);
                ?>
            </div>
            <div class="navbar-sidebar-overlay"></div>
        </div>
        <?php
    }

    public function no_templates_message() {
        return '<div class="no-template-message"><span>' . esc_html__( 'Template is not defined.', 'homez' ) . '</span></div>';
    }

    public function no_template_content_message() {
        return '<div class="no-template-message"><span>' . esc_html__( 'The tabs are working. Please, note, that you have to add a template to the library in order to be able to display it inside the tabs.', 'homez' ) . '</span></div>';
    }

    public function empty_templates_message() {
        $output = '<div id="elementor-widget-template-empty-templates">';
            $output .= '<div class="elementor-widget-template-empty-templates-icon"><i class="eicon-nerd"></i></div>';
            $output .= '<div class="elementor-widget-template-empty-templates-title">' . esc_html__( 'You Haven’t Saved Templates Yet.', 'homez' ) . '</div>';
            $output .= '<div class="elementor-widget-template-empty-templates-footer">';
                $output .= esc_html__( 'What is Library?', 'homez' );
                $output .= '<a class="elementor-widget-template-empty-templates-footer-url" href="https://go.elementor.com/docs-library/" target="_blank">' . esc_html__( 'Read our tutorial on using Library templates.', 'homez' ) . '</a>';
            $output .= '</div>';
        $output .= '</div>';

        return $output;
    }
}

Plugin::instance()->widgets_manager->register( new Homez_Elementor_Nav_Bar );