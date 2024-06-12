<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Homez_Elementor_RealEstate_Location_Banner_List extends Elementor\Widget_Base {

	public function get_name() {
        return 'apus_element_realestate_location_banner_list';
    }

	public function get_title() {
        return esc_html__( 'Apus Location Banner List', 'homez' );
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

        $repeater = new Elementor\Repeater();

        $repeater->add_control(
            'title',
            [
                'label' => esc_html__( 'Location Title', 'homez' ),
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
            'image',
            [
                'name' => 'image',
                'label' => esc_html__( 'Image', 'homez' ),
                'type' => Elementor\Controls_Manager::MEDIA,
                'placeholder'   => esc_html__( 'Upload Image Here', 'homez' ),
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
            'median_price',
            [
                'label' => esc_html__( 'Median Price', 'homez' ),
                'type' => Elementor\Controls_Manager::TEXT,
                'input_type' => 'text',
                'placeholder' => esc_html__( 'Enter your median price here', 'homez' ),
            ]
        );

        $repeater->add_control(
            'median_title',
            [
                'label' => esc_html__( 'Median Title', 'homez' ),
                'type' => Elementor\Controls_Manager::TEXT,
                'input_type' => 'text',
                'placeholder' => esc_html__( 'Enter your median price here', 'homez' ),
                'default' => 'Median listing price',
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
            'el_class',
            [
                'label'         => esc_html__( 'Extra class name', 'homez' ),
                'type'          => Elementor\Controls_Manager::TEXT,
                'placeholder'   => esc_html__( 'If you wish to style particular content element differently, please add a class name to this field and refer to it in your custom CSS file.', 'homez' ),
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
                    '{{WRAPPER}} .location-banner-inner-list' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

        if ( !empty($locations) ) {

            $columns = !empty($columns) ? $columns : 3;
            $columns_tablet = !empty($columns_tablet) ? $columns_tablet : 2;
            $columns_mobile = !empty($columns_mobile) ? $columns_mobile : 1;
            
            $slides_to_scroll = !empty($slides_to_scroll) ? $slides_to_scroll : $columns;
            $slides_to_scroll_tablet = !empty($slides_to_scroll_tablet) ? $slides_to_scroll_tablet : $slides_to_scroll;
            $slides_to_scroll_mobile = !empty($slides_to_scroll_mobile) ? $slides_to_scroll_mobile : 1;

            ?>
            <div class="widget-property-location-banner-list <?php echo esc_attr($el_class); ?>">
                <?php if ( $layout_type == 'carousel' ): ?>
                    <div class="slick-carousel"
                            data-items="<?php echo esc_attr($columns); ?>"
                            data-smallmedium="<?php echo esc_attr( $columns_tablet ); ?>"
                            data-extrasmall="<?php echo esc_attr($columns_mobile); ?>"

                            data-slidestoscroll="<?php echo esc_attr($slides_to_scroll); ?>"
                            data-slidestoscroll_smallmedium="<?php echo esc_attr( $slides_to_scroll_tablet ); ?>"
                            data-slidestoscroll_extrasmall="<?php echo esc_attr($slides_to_scroll_mobile); ?>"

                            data-pagination="<?php echo esc_attr( $show_pagination ? 'true' : 'false' ); ?>" data-nav="<?php echo esc_attr( $show_nav ? 'true' : 'false' ); ?>" data-rows="<?php echo esc_attr( $rows ); ?>" data-infinite="<?php echo esc_attr( $infinite_loop ? 'true' : 'false' ); ?>" data-autoplay="<?php echo esc_attr( $slider_autoplay ? 'true' : 'false' ); ?>">
                        <?php foreach ($locations as $location) {
                            $slug = !empty($location['slug']) ? $location['slug'] : '';
                            $term = get_term_by( 'slug', $slug, 'property_location' );
                            $link = !empty($location['custom_url']) ? $location['custom_url'] : '';
                            $title = !empty($location['title']) ? $location['title'] : '';
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
                                <a class="location-banner-inner-list" href="<?php echo esc_url($link); ?>">
                                    
                                    <?php if ( !empty($location['image']['id']) ) { ?>
                                        <div class="wrapper-top">
                                            <div class="location-banner-inner-item">
                                                <?php echo homez_get_attachment_thumbnail($location['image']['id'], 'full'); ?>
                                            </div>
                                        </div>
                                    <?php } ?>

                                    <div class="inner">
                                        <div class="info-city">
                                            <?php if ( !empty($title) ) { ?>
                                                <h4 class="title">
                                                    <?php echo trim($title); ?>
                                                </h4>
                                            <?php } ?>
                                            <?php if ( $show_nb_properties ) {
                                                    $args = array(
                                                        'fields' => 'ids',
                                                        'locations' => array($slug),
                                                        'limit' => 1
                                                    );
                                                    $query = homez_get_properties($args);
                                                    $count = $query->found_posts;
                                                    $number_properties = $count ? WP_RealEstate_Mixes::format_number($count) : 0;
                                                ?>
                                                <div class="number"><?php echo sprintf(_n('<span>%d</span> Property', '<span>%d</span> Properties', $count, 'homez'), $number_properties); ?></div>
                                            <?php } ?>

                                            <?php if ( !empty($location['median_price']) || !empty($location['median_title']) ) { ?>
                                                <div class="median-price">
                                                    <?php echo trim($location['median_title']); ?> <span><?php echo trim($location['median_price']); ?></span>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                <?php else: ?>
                    <?php
                        $mdcol = 12/$columns;
                        $smcol = 12/$columns_tablet;
                        $xscol = 12/$columns_mobile;
                    ?>
                    <div class="row">
                        <?php $i=1; foreach ($locations as $location) {
                            $slug = !empty($location['slug']) ? $location['slug'] : '';
                            $term = get_term_by( 'slug', $slug, 'property_location' );
                            $link = !empty($location['custom_url']) ? $location['custom_url'] : '';
                            $title = !empty($location['title']) ? $location['title'] : '';
                            if ($term) {
                                if ( empty($link) ) {
                                    $link = get_term_link( $term, 'property_location' );
                                }
                                if ( empty($title) ) {
                                    $title = $term->name;
                                }
                            }


                            $classes = '';
                            if ( $i%$columns == 1 ) {
                                $classes .= ' md-clearfix lg-clearfix';
                            }
                            if ( $i%$columns_tablet == 1 ) {
                                $classes .= ' sm-clearfix';
                            }
                            if ( $i%$columns_mobile == 1 ) {
                                $classes .= ' xs-clearfix';
                            }
                            ?>
                            <div class="col-md-<?php echo esc_attr($mdcol); ?> col-sm-<?php echo esc_attr($smcol); ?> col-xs-<?php echo esc_attr( $xscol ); ?> <?php echo esc_attr($classes); ?>">
                                <a class="location-banner-inner-list" href="<?php echo esc_url($link); ?>">
                                    
                                    <?php if ( !empty($location['image']['id']) ) { ?>
                                        <div class="wrapper-top">
                                            <div class="location-banner-inner-item">
                                                <?php echo homez_get_attachment_thumbnail($location['image']['id'], 'full'); ?>
                                            </div>
                                        </div>
                                    <?php } ?>

                                    <div class="inner">
                                        <div class="info-city">
                                            <?php if ( !empty($title) ) { ?>
                                                <h4 class="title">
                                                    <?php echo trim($title); ?>
                                                </h4>
                                            <?php } ?>
                                            <?php if ( $show_nb_properties ) {
                                                    $args = array(
                                                        'fields' => 'ids',
                                                        'locations' => array($slug),
                                                        'limit' => 1
                                                    );
                                                    $query = homez_get_properties($args);
                                                    $count = $query->found_posts;
                                                    $number_properties = $count ? WP_RealEstate_Mixes::format_number($count) : 0;
                                                ?>
                                                <div class="number"><?php echo sprintf(_n('<span>%d</span> Property', '<span>%d</span> Properties', $count, 'homez'), $number_properties); ?></div>
                                            <?php } ?>

                                            <?php if ( !empty($location['median_price']) || !empty($location['median_title']) ) { ?>
                                                <div class="median-price">
                                                    <?php echo trim($location['median_title']); ?> <span><?php echo trim($location['median_price']); ?></span>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php $i++; } ?>
                    </div>
                <?php endif; ?>
            </div>
            <?php
        }
    }
}
Elementor\Plugin::instance()->widgets_manager->register( new Homez_Elementor_RealEstate_Location_Banner_List );