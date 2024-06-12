<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Homez_Elementor_Popup_Video extends Widget_Base {

	public function get_name() {
        return 'apus_element_popup_video';
    }

	public function get_title() {
        return esc_html__( 'Apus Popup Video', 'homez' );
    }

	public function get_icon() {
        return 'eicon-youtube';
    }

	public function get_categories() {
        return [ 'homez-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Content', 'homez' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => esc_html__( 'Title', 'homez' ),
                'type' => Controls_Manager::TEXT,
            ]
        );

        $this->add_control(
            'video_link',
            [
                'label' => esc_html__( 'Youtube Video Link', 'homez' ),
                'type' => Controls_Manager::TEXT,
                'input_type' => 'url',
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
            'section_title_style',
            [
                'label' => esc_html__( 'Tyles', 'homez' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__( 'Title Color', 'homez' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .title-video' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__( 'Title Typography', 'homez' ),
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .title-video',
            ]
        );

        $this->add_control(
            'desc_color',
            [
                'label' => esc_html__( 'Description Color', 'homez' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__( 'Description Typography', 'homez' ),
                'name' => 'desc_typography',
                'selector' => '{{WRAPPER}} .description',
            ]
        );

        $this->end_controls_section();
    }

	protected function render() {

        $settings = $this->get_settings();

        extract( $settings );

        ?>
        <div class="widget-video <?php echo esc_attr($el_class);?>">
            <div class="video-wrapper-inner">
                <?php
                if ( !empty($img_src['id']) ) {
                ?>
                    <?php echo homez_get_attachment_thumbnail($img_src['id'], 'full'); ?>
                <?php } ?>
                <a class="popup-video d-flex align-items-center <?php echo esc_attr($style);?>" href="<?php echo esc_url($video_link); ?>">
                    <span class="popup-video-inner d-flex align-items-center justify-content-center">
                        <i class="flaticon-play"></i>
                    </span>
                    <?php if ( !empty($title) ) { ?>
                        <h2 class="title-video">
                            <?php echo esc_html($title); ?>
                        </h2>
                    <?php } ?>
                </a>
            </div>
        </div>
        <?php
    }
}

Plugin::instance()->widgets_manager->register( new Homez_Elementor_Popup_Video );