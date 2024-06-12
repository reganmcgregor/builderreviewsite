<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Homez_Elementor_RealEstate_Type_Banner extends Elementor\Widget_Base {

	public function get_name() {
        return 'apus_element_realestate_type_banner';
    }

	public function get_title() {
        return esc_html__( 'Apus Type Banner', 'homez' );
    }
    
	public function get_categories() {
        return [ 'homez-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Type Banner', 'homez' ),
                'tab' => Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => esc_html__( 'Title', 'homez' ),
                'type' => Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Enter your title here', 'homez' ),
            ]
        );

        $this->add_control(
            'slug',
            [
                'label' => esc_html__( 'Type Slug', 'homez' ),
                'type' => Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Enter your Type Slug here', 'homez' ),
            ]
        );

        $this->add_control(
            'show_nb_properties',
            [
                'label' => esc_html__( 'Show Number Properties', 'homez' ),
                'type' => Elementor\Controls_Manager::SWITCHER,
                'default' => '',
                'label_on' => esc_html__( 'Hide', 'homez' ),
                'label_off' => esc_html__( 'Show', 'homez' ),
            ]
        );

        $this->add_control(
            'custom_url',
            [
                'label' => esc_html__( 'Custom URL', 'homez' ),
                'type' => Elementor\Controls_Manager::TEXT,
                'input_type' => 'url',
                'placeholder' => esc_html__( 'Enter your custom url here', 'homez' ),
            ]
        );

        $this->add_control(
            'img_bg_src',
            [
                'name' => 'image',
                'label' => esc_html__( 'Image', 'homez' ),
                'type' => Elementor\Controls_Manager::MEDIA,
                'placeholder'   => esc_html__( 'Upload Image Here', 'homez' ),
            ]
        );

        $this->add_control(
            'style',
            [
                'label' => esc_html__( 'Style', 'homez' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'options' => array(
                    'style1' => esc_html__('Style 1', 'homez'),
                    'style2' => esc_html__('Style 2', 'homez'),
                ),
                'default' => 'style1'
            ]
        );

        $this->add_responsive_control(
            'height',
            [
                'label' => esc_html__( 'Height', 'homez' ),
                'type' => Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 1440,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .type-banner-image' => 'height: {{SIZE}}{{UNIT}};',
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
            'section_overlay',
            [
                'label' => esc_html__( 'Background Overlay', 'homez' ),
                'tab' => Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'background_overlay',
                'selector' => '{{WRAPPER}} .type-banner-image::before',
            ]
        );

        $this->add_control(
            'box_radius',
            [
                'label' => esc_html__( 'Border Radius', 'homez' ),
                'type' => Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .type-banner-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'section_title_style',
            [
                'label' => esc_html__( 'Typography', 'homez' ),
                'tab' => Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__( 'Title Color', 'homez' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__( 'Title Typography', 'homez' ),
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .title',
            ]
        );

        $this->add_control(
            'number_color',
            [
                'label' => esc_html__( 'Number Color', 'homez' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .number' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__( 'Number Typography', 'homez' ),
                'name' => 'number_typography',
                'selector' => '{{WRAPPER}} .number',
            ]
        );

        $this->end_controls_section();
    }

	protected function render() {
        $settings = $this->get_settings();

        extract( $settings );

        ?>
        <div class="widget-property-type-banner <?php echo esc_attr($el_class); ?>">

            <?php
            $term = get_term_by( 'slug', $slug, 'property_type' );
            $link = $custom_url;
            if ($term) {
                if ( empty($link) ) {
                    $link = get_term_link( $term, 'property_type' );
                }
                if ( empty($title) ) {
                    $title = $term->name;
                }
            }
            ?>

            <a class="type-banner-image position-relative <?php echo esc_attr($style); ?>" href="<?php echo esc_url($link); ?>">
                
                <?php
                if ( !empty($img_bg_src['id']) ) {
                ?>
                    <div class="banner-image">
                        <?php echo homez_get_attachment_thumbnail($img_bg_src['id'], 'full'); ?>
                    </div>
                <?php } ?>

                <div class="inner d-flex flex-column">
                    <?php if ( $type_icon ) { ?>
                        <div class="type-icon"><i class="<?php echo esc_attr($type_icon); ?>"></i></div>
                    <?php } ?>
                    
                    <?php if ( !empty($title) ) { ?>
                        <h4 class="title">
                            <?php echo trim($title); ?>
                        </h4>
                    <?php } ?>
                    <?php if ( $show_nb_properties ) {
                            $args = array(
                                'fields' => 'ids',
                                'types' => array($slug),
                                'limit' => 1
                            );
                            $query = homez_get_properties($args);
                            $count = $query->found_posts;
                            $number_properties = $count ? WP_RealEstate_Mixes::format_number($count) : 0;
                    ?>
                    <div class="number"><?php echo sprintf(_n('<span>%d</span> Property', '<span>%d</span> Properties', $count, 'homez'), $number_properties); ?></div>
                    <?php } ?>
                    <span class="more"><?php echo esc_html__('More Details','homez'); ?><i class="flaticon-up-right-arrow"></i></span>
                </div>
            </a>

        </div>
        <?php
    }
}
Elementor\Plugin::instance()->widgets_manager->register( new Homez_Elementor_RealEstate_Type_Banner );