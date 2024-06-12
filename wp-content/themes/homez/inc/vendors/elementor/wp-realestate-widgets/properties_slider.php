<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Homez_Elementor_RealEstate_Properties_Slider extends Elementor\Widget_Base {

    public function get_name() {
        return 'apus_element_realestate_properties_slider';
    }

    public function get_title() {
        return esc_html__( 'Apus Properties Slider', 'homez' );
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
            'property_id', [
                'label' => esc_html__( 'Property ID', 'homez' ),
                'type' => Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Enter property ID', 'homez' ),
            ]
        );

        $repeater->add_control(
            'image',
            [
                'name' => 'image',
                'label' => esc_html__( 'Image Background for Style 1', 'homez' ),
                'type' => Elementor\Controls_Manager::MEDIA,
                'placeholder'   => esc_html__( 'Upload Image Background Here', 'homez' ),
            ]
        );

        $repeater->add_control(
            'more_phone',
            [
                'label' => esc_html__( 'Phone', 'homez' ),
                'type' => \Elementor\Controls_Manager::HEADING,
            ]
        );

        $repeater->add_control(
            'phone_title',
            [
                'label' => esc_html__( 'Title Phone', 'homez' ),
                'type' => Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( 'Title Phone' , 'homez' ),
            ]
        );

        $repeater->add_control(
            'phone_value',
            [
                'label' => esc_html__( 'Value Phone', 'homez' ),
                'type' => Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( 'Value Phone' , 'homez' ),
            ]
        );

        $repeater->add_control(
            'more_support',
            [
                'label' => esc_html__( 'Mail', 'homez' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $repeater->add_control(
            'mail_title',
            [
                'label' => esc_html__( 'Title Mail', 'homez' ),
                'type' => Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( 'Title Mail' , 'homez' ),
            ]
        );

        $repeater->add_control(
            'mail_value',
            [
                'label' => esc_html__( 'Value Mail', 'homez' ),
                'type' => Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( 'Value Mail' , 'homez' ),
            ]
        );

        $this->add_control(
            'sliders',
            [
                'label' => esc_html__( 'Sliders', 'homez' ),
                'type' => Elementor\Controls_Manager::REPEATER,
                'placeholder' => esc_html__( 'Enter your property tabs here', 'homez' ),
                'fields' => $repeater->get_controls(),
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
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label'         => esc_html__( 'Autoplay', 'homez' ),
                'type'          => Elementor\Controls_Manager::SWITCHER,
                'label_on'      => esc_html__( 'Yes', 'homez' ),
                'label_off'     => esc_html__( 'No', 'homez' ),
                'return_value'  => true,
                'default'       => true,
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
                'default' => 'style1',
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
            'section_style',
            [
                'label' => esc_html__( 'Style', 'homez' ),
                'tab' => Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'bg_color',
            [
                'label' => esc_html__( 'Background Color', 'homez' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .inner-content' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        
        $this->end_controls_section();

    }

    protected function render() {
        $settings = $this->get_settings();

        extract( $settings );

        if ( !empty($sliders) ) {
            $columns = !empty($columns) ? $columns : 1;
            $columns_tablet = !empty($columns_tablet) ? $columns_tablet : 1;
            $columns_mobile = !empty($columns_mobile) ? $columns_mobile : 1;
            
            $slides_to_scroll = !empty($slides_to_scroll) ? $slides_to_scroll : $columns;
            $slides_to_scroll_tablet = !empty($slides_to_scroll_tablet) ? $slides_to_scroll_tablet : $slides_to_scroll;
            $slides_to_scroll_mobile = !empty($slides_to_scroll_mobile) ? $slides_to_scroll_mobile : 1;
        ?>
        <div class="widget-properties-slider <?php echo esc_attr($el_class.' '.$style); ?>">
            <div class="slick-carousel" 
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
            data-pagination="<?php echo esc_attr( $show_pagination ? 'true' : 'false' ); ?>" data-nav="<?php echo esc_attr( $show_nav ? 'true' : 'false' ); ?>" data-infinite="<?php echo esc_attr( $infinite_loop ? 'true' : 'false' ); ?>" data-autoplay="<?php echo esc_attr( $autoplay ? 'true' : 'false' ); ?>">
                <?php foreach ($sliders as $slider): ?>
                    <?php 
                        $img_bg_src = ( isset( $slider['image']['id'] ) && $slider['image']['id'] != 0 ) ? wp_get_attachment_url( $slider['image']['id'] ) : '';
                        $style_bg = '';
                        if ( !empty($img_bg_src) ) {
                            $style_bg = 'style="background-image:url('.esc_url($img_bg_src).')"';
                        }
                    ?>
                    <div class="item">
                            <div class="property-grid-slider-wrapper">
                                <div class="property-item m-0 property-grid-slider radius-0">
                                        <?php
                                        if ( !empty($slider['property_id']) ) {

                                            $post_object = get_post( $slider['property_id'] );
                                            if ( $post_object ) {
                                                setup_postdata( $GLOBALS['post'] =& $post_object );
                                                global $post;
                                                if(!empty($slider['image']['id'])){
                                                    $firstclass= "col-md-6";
                                                } else {
                                                    $firstclass= "";
                                                }
                                                ?>
                                                    <div class="row m-0 align-items-center">
                                                        <div class="col-12 p-0 <?php echo esc_attr($firstclass); ?>">
                                                            <div class="inner-content">
                                                                <div class="information">
                                                                    <?php $featured = homez_property_display_featured_icon($post, false);?>
                                                                    <div class="top-label d-flex">
                                                                        <?php if ( $featured ) { ?>
                                                                            <?php echo trim($featured); ?>
                                                                        <?php } ?>
                                                                        <?php homez_property_display_status_label($post, true); ?>
                                                                    </div>

                                                                    <?php the_title( sprintf( '<h2 class="title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
                                                                    <?php homez_property_display_full_location($post, 'no-icon'); ?>
                                                                    
                                                                    <?php
                                                                        $meta_obj = WP_RealEstate_Property_Meta::get_instance($post->ID);

                                                                        $beds = homez_property_display_meta($post, 'beds', 'flaticon-bed', false, $meta_obj->get_post_meta_title( 'beds' ));
                                                                        $baths = homez_property_display_meta($post, 'baths', 'flaticon-shower', false, $meta_obj->get_post_meta_title( 'baths' ));

                                                                        $suffix = wp_realestate_get_option('measurement_unit_area');
                                                                        $lot_area = homez_property_display_meta($post, 'lot_area', 'flaticon-expand', false, $suffix);

                                                                        if ( $lot_area || $beds || $baths ) {
                                                                        ?>
                                                                            <div class="property-metas d-flex flex-wrap">
                                                                                <?php
                                                                                    echo trim($beds);
                                                                                    echo trim($baths);
                                                                                    echo trim($lot_area);
                                                                                ?>
                                                                            </div>
                                                                    <?php } ?>
                                                                    <?php if(!empty($slider['phone_value']) || !empty($slider['mail_value'])) {?>
                                                                        <div class="inner-middle d-flex">
                                                                            <?php if(!empty($slider['phone_value'])) {?>
                                                                                <div class="item1">
                                                                                    <div class="slide-title"><?php echo trim($slider['phone_title']); ?></div>
                                                                                    <div class="value"><?php echo trim($slider['phone_value']); ?></div>
                                                                                </div>
                                                                            <?php } ?>
                                                                            <?php if(!empty($slider['mail_value'])) {?>
                                                                                <div class="item1">
                                                                                    <div class="slide-title"><?php echo trim($slider['mail_title']); ?></div>
                                                                                    <div class="value"><?php echo trim($slider['mail_value']); ?></div>
                                                                                </div>
                                                                            <?php } ?>
                                                                        </div>
                                                                    <?php } ?>

                                                                    <div class="d-flex align-items-center inner-bottom">
                                                                        <?php homez_property_display_price($post, 'no-icon-title', true); ?>
                                                                        <div class="ms-auto action-item d-flex align-items-center">
                                                                            <a href="<?php the_permalink(); ?>" class="btn-permalink" data-toggle="tooltip" data-original-title="<?php esc_html_e('View','homez') ?>"><i class="flaticon-fullscreen"></i></a>
                                                                            <?php
                                                                                if ( homez_get_config('listing_enable_favorite', true) ) {
                                                                                    $args = array(
                                                                                        'added_icon_class' => 'flaticon-like',
                                                                                        'add_icon_class' => 'flaticon-like',
                                                                                    );
                                                                                    WP_RealEstate_Favorite::display_favorite_btn($post->ID, $args);
                                                                                }
                                                                                if ( homez_get_config('listing_enable_compare', true) ) {
                                                                                    $args = array(
                                                                                        'added_icon_class' => 'flaticon-new-tab',
                                                                                        'add_icon_class' => 'flaticon-new-tab',
                                                                                    );
                                                                                    WP_RealEstate_Compare::display_compare_btn($post->ID, $args);
                                                                                }
                                                                            ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php
                                                        if ( !empty($slider['image']['id']) ) {
                                                        ?>
                                                            <div class="col-12 col-md-6 p-0 d-none d-md-block">
                                                                <div class="banner-image">
                                                                    <?php echo homez_get_attachment_thumbnail($slider['image']['id'], 'full'); ?>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                <?php

                                                wp_reset_postdata();
                                            }

                                        }
                                        ?>
                                </div>
                            </div>
                    </div>
                <?php endforeach; ?>
            </div>

        </div>
        <?php
        }
    }
}

Elementor\Plugin::instance()->widgets_manager->register( new Homez_Elementor_RealEstate_Properties_Slider );