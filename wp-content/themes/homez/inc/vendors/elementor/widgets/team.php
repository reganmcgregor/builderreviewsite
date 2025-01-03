<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Homez_Elementor_Team extends Widget_Base {

    public function get_name() {
        return 'apus_element_team';
    }

    public function get_title() {
        return esc_html__( 'Apus Teams', 'homez' );
    }

    public function get_icon() {
        return 'fa fa-users';
    }

    public function get_categories() {
        return [ 'homez-elements' ];
    }

    protected function register_controls() {

        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Team', 'homez' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'title', [
                'label' => esc_html__( 'Social Title', 'homez' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Social Title' , 'homez' ),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'link',
            [
                'label' => esc_html__( 'Social Link', 'homez' ),
                'type' => Controls_Manager::TEXT,
                'input_type' => 'url',
                'placeholder' => esc_html__( 'Enter your social link here', 'homez' ),
            ]
        );

        $repeater->add_control(
            'icon',
            [
                'label' => esc_html__( 'Social Icon', 'homez' ),
                'type' => Controls_Manager::ICON,
                'default' => 'fa fa-star',
            ]
        );

        $this->add_control(
            'name', [
                'label' => esc_html__( 'Member Name', 'homez' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Member Name' , 'homez' ),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'property', [
                'label' => esc_html__( 'Member Property', 'homez' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Member Property' , 'homez' ),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'img_src',
            [
                'name' => 'image',
                'label' => esc_html__( 'Image', 'homez' ),
                'type' => Controls_Manager::MEDIA,
                'placeholder'   => esc_html__( 'Upload Image Here', 'homez' ),
            ]
        );

        $this->add_control(
            'description', [
                'label' => esc_html__( 'Member Description', 'homez' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => esc_html__( 'Member Description' , 'homez' ),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'socials',
            [
                'label' => esc_html__( 'Socials', 'homez' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
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
                'label' => esc_html__( 'Title', 'homez' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__( 'Background Hover Color', 'homez' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .social a:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

    }

    protected function render() {

        $settings = $this->get_settings();

        extract( $settings );

        ?>
        <div class="widget widget-team <?php echo esc_attr($el_class); ?>">
            <div class="team-item">
                <div class="top-image">
                    <?php
                    if ( !empty($settings['img_src']['id']) ) {
                    ?>
                        <div class="team-image">
                            <?php echo homez_get_attachment_thumbnail($settings['img_src']['id'], 'full'); ?>
                        </div>
                    <?php } ?>
                </div>
                <?php if ( !empty($socials) ) { ?>
                    <ul class="social">
                        <?php foreach ($socials as $social) { ?>
                            <?php if ( !empty($social['link']) && !empty($social['icon']) ) { ?>
                                <li>
                                    <a class="<?php echo esc_attr(explode(' ',$social['icon'])[1]); ?>" href="<?php echo esc_url($social['link']);?>" <?php echo esc_html(!empty($social['title']) ? 'title="'.$social['title'].'"' : ''); ?>>
                                        <i class="<?php echo esc_attr($social['icon']); ?>"></i>
                                    </a>
                                </li>
                            <?php } ?>
                        <?php } ?>
                    </ul>
                <?php } ?>
            </div>
            <div class="content">
                <?php if ( !empty($property) ) { ?>
                    <div class="property text-theme"><?php echo esc_html($property); ?></div>
                <?php } ?>
                <?php if ( !empty($name) ) { ?>
                    <h3 class="name-team"><?php echo esc_html($name); ?></h3>
                <?php } ?>
            </div>
        </div>
        <?php
    }

}

Plugin::instance()->widgets_manager->register( new Homez_Elementor_Team );