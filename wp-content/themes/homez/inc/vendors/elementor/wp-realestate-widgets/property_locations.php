<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Homez_Elementor_RealEstate_Property_Locations extends Elementor\Widget_Base {

	public function get_name() {
        return 'apus_element_realestate_property_locations';
    }

	public function get_title() {
        return esc_html__( 'Apus Property Locations', 'homez' );
    }
    
	public function get_categories() {
        return [ 'homez-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Location Banner', 'homez' ),
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
        $this->add_control(
            'description',
            [
                'label' => esc_html__( 'Description', 'homez' ),
                'type' => Elementor\Controls_Manager::TEXTAREA,
                'placeholder' => esc_html__( 'Enter your description here', 'homez' ),
            ]
        );

        $repeater = new Elementor\Repeater();

        $repeater->add_control(
            'title',
            [
                'label' => esc_html__( 'Title', 'homez' ),
                'type' => Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Enter your title here', 'homez' ),
            ]
        );

        $repeater->add_control(
            'slug',
            [
                'label' => esc_html__( 'Location Slug', 'homez' ),
                'type' => Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Enter your Location Slug here', 'homez' ),
            ]
        );

        $repeater->add_control(
            'custom_url',
            [
                'label' => esc_html__( 'Custom URL', 'homez' ),
                'type' => Elementor\Controls_Manager::TEXT,
                'input_type' => 'url',
                'placeholder' => esc_html__( 'Enter your custom url here', 'homez' ),
            ]
        );

        $repeater->add_control(
            'img_bg_src',
            [
                'name' => 'image',
                'label' => esc_html__( 'Image', 'homez' ),
                'type' => Elementor\Controls_Manager::MEDIA,
                'placeholder'   => esc_html__( 'Upload Image Here', 'homez' ),
            ]
        );

        $this->add_control(
            'locations',
            [
                'label' => esc_html__( 'Locations Box', 'homez' ),
                'type' => Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
            ]
        );

        $this->add_group_control(
            Elementor\Group_Control_Image_Size::get_type(),
            [
                'name' => 'image', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
                'default' => 'full',
                'separator' => 'none',
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

        $this->add_control(
            'style',
            [
                'label' => esc_html__( 'Style', 'homez' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'options' => array(
                    'style1' => esc_html__('Style 1', 'homez'),
                    'style2' => esc_html__('Style 2', 'homez'),
                    'style3' => esc_html__('Style 3', 'homez'),
                    'style4' => esc_html__('Style 4', 'homez'),
                ),
                'default' => 'style1',
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
                'default' => 1,
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
            'fullscreen',
            [
                'label'         => esc_html__( 'Full Screen', 'homez' ),
                'type'          => Elementor\Controls_Manager::SWITCHER,
                'label_on'      => esc_html__( 'Yes', 'homez' ),
                'label_off'     => esc_html__( 'No', 'homez' ),
                'return_value'  => true,
                'default'       => false,
            ]
        );

        $this->add_control(
            'view_all',
            [
                'label' => esc_html__( 'View All', 'homez' ),
                'type' => Elementor\Controls_Manager::SWITCHER,
                'default' => '',
                'label_on' => esc_html__( 'Hide', 'homez' ),
                'label_off' => esc_html__( 'Show', 'homez' ),
            ]
        );

        $this->add_control(
            'text_view',
            [
                'label' => esc_html__( 'Text View All', 'homez' ),
                'type' => Elementor\Controls_Manager::TEXT,
                'input_type' => 'text',
                'default' => 'Browse All News',
                'condition' => [
                    'view_all' => ['yes'],
                ]
            ]
        );

        $this->add_control(
            'link_view',
            [
                'label' => esc_html__( 'View Link', 'homez' ),
                'type' => Elementor\Controls_Manager::TEXT,
                'input_type' => 'url',
                'placeholder' => esc_html__( 'Enter your Link here', 'homez' ),
                'condition' => [
                    'view_all' => ['yes'],
                ]
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
            'section_box',
            [
                'label' => esc_html__( 'Box Style', 'homez' ),
                'tab' => Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'background_overlay',
                'selector' => '{{WRAPPER}} .item-location::before',
            ]
        );
        
        $this->add_responsive_control(
            'box_padding',
            [
                'label' => esc_html__( 'Padding Widget', 'homez' ),
                'type' => Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .widget-property-locations .slick-list' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'homez' ),
                'type' => Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .item-location' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

        if ( !empty($locations) ) {
            if ( $image_size == 'custom' ) {
                
                if ( $image_custom_dimension['width'] && $image_custom_dimension['height'] ) {
                    $thumbsize = $image_custom_dimension['width'].'x'.$image_custom_dimension['height'];
                } else {
                    $thumbsize = 'full';
                }
            } else {
                $thumbsize = $image_size;
            }
            
            $columns = !empty($columns) ? $columns : 3;
            $columns_tablet = !empty($columns_tablet) ? $columns_tablet : 2;
            $columns_mobile = !empty($columns_mobile) ? $columns_mobile : 1;
        ?>
            <div class="widget-property-locations <?php echo esc_attr( $fullscreen ? 'fullscreen' : 'nofullscreen' ); ?> <?php echo esc_attr($el_class); ?>">

                <?php if( !empty($title) || !empty($description) || ($view_all == 'yes' && !(empty($link_view)) && !(empty($text_view))) ){ ?>
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

                        <?php if ( $view_all == 'yes' && !(empty($link_view)) && !(empty($text_view)) ) { ?>
                            <div class="ms-auto">
                                <a href="<?php echo esc_url( $link_view ); ?>" class="btn-readmore">
                                    <?php echo esc_html($text_view); ?><i class="flaticon-up-right-arrow next"></i>
                                </a>
                            </div>
                        <?php } ?>
                    </div>  
                <?php } ?>

                <?php if ( $layout_type == 'carousel' ) {
                    
                    $slides_to_scroll = !empty($slides_to_scroll) ? $slides_to_scroll : $columns;
                    $slides_to_scroll_tablet = !empty($slides_to_scroll_tablet) ? $slides_to_scroll_tablet : $slides_to_scroll;
                    $slides_to_scroll_mobile = !empty($slides_to_scroll_mobile) ? $slides_to_scroll_mobile : 1;
                ?>
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

                        data-pagination="<?php echo esc_attr( $show_pagination ? 'true' : 'false' ); ?>" data-nav="<?php echo esc_attr( $show_nav ? 'true' : 'false' ); ?>" data-rows="<?php echo esc_attr( $rows ); ?>" data-infinite="<?php echo esc_attr( $infinite_loop ? 'true' : 'false' ); ?>" data-autoplay="<?php echo esc_attr( $slider_autoplay ? 'true' : 'false' ); ?>">

                        <?php foreach ($locations as $item) {
                            $term = get_term_by( 'slug', $item['slug'], 'property_location' );
                            $link = $item['custom_url'];
                            $title = $item['title'];
                            if ($term) {
                                if ( empty($link) ) {
                                    $link = get_term_link( $term, 'property_location' );
                                }
                                if ( empty($title) ) {
                                    $title = $term->name;
                                }
                            }
                            ?>
                            <div class="item">
                                <a class="item-location position-relative <?php echo esc_attr($style); ?>" href="<?php echo esc_url($link); ?>">
                                    
                                    <?php
                                    if ( !empty($item['img_bg_src']['id']) ) {
                                    ?>
                                        <div class="banner-image">
                                            <?php echo homez_get_attachment_thumbnail($item['img_bg_src']['id'], $thumbsize); ?>
                                        </div>
                                    <?php } ?>

                                    <div class="inner d-flex flex-column">
                                        <?php if ( !empty($title) ) { ?>
                                            <h4 class="title">
                                                <?php echo trim($title); ?>
                                            </h4>
                                        <?php } ?>
                                        <?php if ( $show_nb_properties ) {
                                                $args = array(
                                                    'fields' => 'ids',
                                                    'locations' => array($item['slug']),
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
                        <?php } ?>
                    </div>
                <?php } else { ?>
                    <div class="row">
                        <?php
                            $mdcol = 12/$columns;
                            $smcol = 12/$columns_tablet;
                            $xscol = 12/$columns_mobile;
                        ?>
                        <?php foreach ($locations as $item) {
                            
                            $term = get_term_by( 'slug', $item['slug'], 'property_location' );
                            $link = $item['custom_url'];
                            $title = $item['title'];
                            if ($term) {
                                if ( empty($link) ) {
                                    $link = get_term_link( $term, 'property_location' );
                                }
                                if ( empty($title) ) {
                                    $title = $term->name;
                                }
                            }
                            ?>
                            <div class="col-lg-<?php echo esc_attr($mdcol); ?> col-md-<?php echo esc_attr($smcol); ?> col-<?php echo esc_attr( $xscol ); ?> list-item">
                                <a class="item-location position-relative <?php echo esc_attr($style); ?>" href="<?php echo esc_url($link); ?>">
                                    
                                    <?php
                                    if ( !empty($item['img_bg_src']['id']) ) {
                                    ?>
                                        <div class="banner-image">
                                            <?php echo homez_get_attachment_thumbnail($item['img_bg_src']['id'], $thumbsize); ?>
                                        </div>
                                    <?php } ?>

                                    <div class="inner d-flex flex-column">
                                        <?php if ( !empty($title) ) { ?>
                                            <h4 class="title">
                                                <?php echo trim($title); ?>
                                            </h4>
                                        <?php } ?>
                                        <?php if ( $show_nb_properties ) {
                                                $args = array(
                                                    'fields' => 'ids',
                                                    'locations' => array($item['slug']),
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
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        <?php
        }
    }
}
Elementor\Plugin::instance()->widgets_manager->register( new Homez_Elementor_RealEstate_Property_Locations );