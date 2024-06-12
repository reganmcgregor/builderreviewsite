<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Homez_Elementor_RealEstate_Property_Banner extends Elementor\Widget_Base {

	public function get_name() {
        return 'apus_element_realestate_property_banner';
    }

	public function get_title() {
        return esc_html__( 'Apus Property Banner', 'homez' );
    }
    
	public function get_categories() {
        return [ 'homez-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Property Banner', 'homez' ),
                'tab' => Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'tagline',
            [
                'label' => esc_html__( 'Tagline', 'homez' ),
                'type' => Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Enter your title here', 'homez' ),
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => esc_html__( 'Property Title', 'homez' ),
                'type' => Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Enter your title here', 'homez' ),
            ]
        );

        $this->add_control(
            'property_id',
            [
                'label' => esc_html__( 'Property ID', 'homez' ),
                'type' => Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Enter your Property ID here', 'homez' ),
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
            'btn_text',
            [
                'label'         => esc_html__( 'Button Text', 'homez' ),
                'type'          => Elementor\Controls_Manager::TEXT,
                'default'   => 'View Property'
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
                'selector' => '{{WRAPPER}} .property-banner-inner:before',
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'section_border',
            [
                'label' => esc_html__( 'Border Radius', 'homez' ),
                'tab' => Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_control(
            'border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'homez' ),
                'type' => Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .property-banner-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    // Stronger selector to avoid section style from overwriting
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
                    // Stronger selector to avoid section style from overwriting
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
        <div class="widget-property-banner <?php echo esc_attr($el_class); ?>">

            <?php
            $post = get_post($property_id);

            $img_bg_src = ( isset( $img_bg_src['id'] ) && $img_bg_src['id'] != 0 ) ? wp_get_attachment_url( $img_bg_src['id'] ) : '';
            $style_bg = '';
            if ( !empty($img_bg_src) ) {
                $style_bg = 'style="background-image:url('.esc_url($img_bg_src).')"';
            }
            ?>

            <div class="property-banner-inner" <?php echo trim($style_bg); ?>>
                
                    <?php if ( !empty($tagline) ) { ?>
                        <div class="tagline">
                            <?php echo trim($tagline); ?>
                        </div>
                    <?php } ?>
                    
                    <?php
                    if ( empty($title) ) {
                        $title = !empty($post->post_title) ? $post->post_title : '';
                    }
                    ?>

                    <h4 class="title">
                        <?php echo trim($title); ?>
                    </h4>

                    <?php
                    $link = $custom_url;
                    if ( !empty($post) ) {
                        if ( empty($link) ) {
                            $link = get_permalink($post);
                        }
                        $meta_obj = WP_RealEstate_Property_Meta::get_instance($post->ID);

                        $beds = homez_property_display_meta($post, 'beds', 'flaticon-bed', false, $meta_obj->get_post_meta_title( 'beds' ));
                        $baths = homez_property_display_meta($post, 'baths', 'flaticon-bath', false, $meta_obj->get_post_meta_title( 'baths' ));
                        $garages = homez_property_display_meta($post, 'garages', 'flaticon-car', false, $meta_obj->get_post_meta_title( 'garages' ));

                        $suffix = wp_realestate_get_option('measurement_unit_area');
                        $lot_area = homez_property_display_meta($post, 'lot_area', 'flaticon-ruler', false, $suffix);

                        if ( $lot_area || $beds || $baths || $garages ) {
                        ?>
                            <div class="property-metas flex-middle justify-content-center flex-wrap">
                                <?php
                                    echo trim($beds);
                                    echo trim($baths);
                                    echo trim($garages);
                                    echo trim($lot_area);
                                ?>
                            </div>
                        <?php } ?>
                    <?php } ?>
                    <div class="inner-bottom">
                        <a class="btn btn-white" href="<?php echo esc_url($link); ?>">
                            <?php
                            if ( !empty($btn_text) ) {
                                echo trim($btn_text);
                            } else {
                                esc_html_e('VIEW PROPERTY', 'homez');
                            }
                            ?>
                        </a>
                    </div>
            </div>

        </div>
        <?php
    }
}
Elementor\Plugin::instance()->widgets_manager->register( new Homez_Elementor_RealEstate_Property_Banner );