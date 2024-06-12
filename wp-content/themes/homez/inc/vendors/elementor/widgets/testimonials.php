<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Homez_Elementor_Testimonials extends Widget_Base {

    public function get_name() {
        return 'apus_element_testimonials';
    }

    public function get_title() {
        return esc_html__( 'Apus Testimonials', 'homez' );
    }

    public function get_icon() {
        return 'eicon-testimonial';
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
                'input_type' => 'text',
                'placeholder' => esc_html__( 'Enter your title here', 'homez' ),
            ]
        );
        $this->add_control(
            'description',
            [
                'label' => esc_html__( 'Description', 'homez' ),
                'type' => Controls_Manager::TEXTAREA,
                'placeholder' => esc_html__( 'Enter your description here', 'homez' ),
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'img_src',
            [
                'name' => 'image',
                'label' => esc_html__( 'Choose Image', 'homez' ),
                'type' => Controls_Manager::MEDIA,
                'placeholder'   => esc_html__( 'Upload Brand Image', 'homez' ),
            ]
        );

        $repeater->add_control(
            'name',
            [
                'label' => esc_html__( 'Name', 'homez' ),
                'type' => Controls_Manager::TEXT,
                'default' => '',
            ]
        );

        $repeater->add_control(
            'title',
            [
                'label' => esc_html__( 'Title', 'homez' ),
                'type' => Controls_Manager::TEXT,
                'default' => '',
            ]
        );


        $repeater->add_control(
            'content', [
                'label' => esc_html__( 'Content', 'homez' ),
                'type' => Controls_Manager::TEXTAREA
            ]
        );

        $repeater->add_control(
            'job',
            [
                'label' => esc_html__( 'Job', 'homez' ),
                'type' => Controls_Manager::TEXT,
                'default' => '',
            ]
        );

        $repeater->add_control(
            'star',
            [
                'label' => esc_html__( 'Star Scores', 'homez' ),
                'type' => Controls_Manager::TEXT,
                'default' => '',
            ]
        );

        $repeater->add_control(
            'link',
            [
                'label' => esc_html__( 'Link To', 'homez' ),
                'type' => Controls_Manager::URL,
                'placeholder' => esc_html__( 'Enter your social link here', 'homez' ),
                'placeholder' => esc_html__( 'https://your-link.com', 'homez' ),
            ]
        );

        $this->add_control(
            'testimonials',
            [
                'label' => esc_html__( 'Testimonials', 'homez' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
            ]
        );

        $columns = range( 1, 12 );
        $columns = array_combine( $columns, $columns );

        $this->add_responsive_control(
            'columns',
            [
                'label' => esc_html__( 'Columns', 'homez' ),
                'type' => Controls_Manager::SELECT,
                'options' => $columns,
                'frontend_available' => true,
                'default' => 1,
            ]
        );

        $this->add_control(
            'show_nav',
            [
                'label' => esc_html__( 'Show Nav', 'homez' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => '',
                'label_on' => esc_html__( 'Hide', 'homez' ),
                'label_off' => esc_html__( 'Show', 'homez' ),
            ]
        );

        $this->add_control(
            'show_pagination',
            [
                'label' => esc_html__( 'Show Pagination', 'homez' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => '',
                'label_on' => esc_html__( 'Hide', 'homez' ),
                'label_off' => esc_html__( 'Show', 'homez' ),
            ]
        );

        $this->add_control(
            'layout_type',
            [
                'label' => esc_html__( 'Layout', 'homez' ),
                'type' => Controls_Manager::SELECT,
                'options' => array(
                    'style1' => esc_html__('Style 1', 'homez'),
                    'style2' => esc_html__('Style 2', 'homez'),
                    'style3' => esc_html__('Style 3', 'homez'),
                    'style4' => esc_html__('Style 4', 'homez'),
                ),
                'default' => 'style1'
            ]
        );

        $this->add_control(
            'fullscreen',
            [
                'label'         => esc_html__( 'Full Screen', 'homez' ),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => esc_html__( 'Yes', 'homez' ),
                'label_off'     => esc_html__( 'No', 'homez' ),
                'return_value'  => true,
                'default'       => false,
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
                'label' => esc_html__( 'Style Box', 'homez' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs( 'tabs_box_style' );

            $this->start_controls_tab(
                'tab_box_normal',
                [
                    'label' => esc_html__( 'Normal', 'homez' ),
                ]
            );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name' => 'border_box',
                        'label' => esc_html__( 'Border Box', 'homez' ),
                        'selector' => '{{WRAPPER}} [class*="testimonials-item"]',
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name' => 'box_shadow',
                        'label' => esc_html__( 'Box Shadow', 'homez' ),
                        'selector' => '{{WRAPPER}} [class*="testimonials-item"]',
                    ]
                );

            $this->end_controls_tab();

            // tab hover
            $this->start_controls_tab(
                'tab_box_hover',
                [
                    'label' => esc_html__( 'Hover', 'homez' ),
                ]
            );

                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name' => 'border_hv_box',
                        'label' => esc_html__( 'Border Box', 'homez' ),
                        'selector' => '{{WRAPPER}} [class*="testimonials-item"]:hover',
                    ]
                );

                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name' => 'box_hv_shadow',
                        'label' => esc_html__( 'Box Shadow', 'homez' ),
                        'selector' => '{{WRAPPER}} [class*="testimonials-item"]:hover',
                    ]
                );

            $this->end_controls_tab();

        $this->end_controls_tabs();
        // end tab normal and hover

        $this->end_controls_section();

        $this->start_controls_section(
            'section_title_style',
            [
                'label' => esc_html__( 'Style Info', 'homez' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__( 'Title Color', 'homez' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .title' => 'color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__( 'Title Typography', 'homez' ),
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .title',
            ]
        );

        $this->add_control(
            'test_title_color',
            [
                'label' => esc_html__( 'Name Color', 'homez' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .name-client' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .name-client a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__( 'Name Typography', 'homez' ),
                'name' => 'test_title_typography',
                'selector' => '{{WRAPPER}} .name-client',
            ]
        );

        $this->add_control(
            'content_color',
            [
                'label' => esc_html__( 'Content Color', 'homez' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__( 'Content Typography', 'homez' ),
                'name' => 'content_typography',
                'selector' => '{{WRAPPER}} .description',
            ]
        );

        $this->add_control(
            'listing_color',
            [
                'label' => esc_html__( 'Listing Color', 'homez' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .job' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__( 'Listing Typography', 'homez' ),
                'name' => 'listing_typography',
                'selector' => '{{WRAPPER}} .job',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'border_img',
                'label' => esc_html__( 'Border Image Active', 'homez' ),
                'selector' => '{{WRAPPER}} .slick-current .avarta',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_dots_style',
            [
                'label' => esc_html__( 'Style Dots', 'homez' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'dots_color',
            [
                'label' => esc_html__( 'Color', 'homez' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .slick-carousel .slick-dots li button' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'dots_active_color',
            [
                'label' => esc_html__( 'Color Active', 'homez' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .slick-carousel .slick-dots .slick-active button' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

    }

    protected function render() {

        $settings = $this->get_settings();

        extract( $settings );

        $columns = !empty($columns) ? $columns : 1;
        $columns_tablet = !empty($columns_tablet) ? $columns_tablet : 1;
        $columns_mobile = !empty($columns_mobile) ? $columns_mobile : 1;
        
        if ( !empty($testimonials) ) {
            ?>
            <div class="widget-testimonials position-relative <?php echo esc_attr($el_class.' '.$layout_type); ?> <?php echo esc_attr($show_nav ? 'show_nav' : ''); ?> <?php echo esc_attr( $fullscreen ? 'fullscreen' : 'nofullscreen' ); ?>">

                <?php if( !empty($title) || !empty($description) ){ ?>
                    <div class="info-top">
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

                <?php if($layout_type == 'style2') { ?>

                    <div class="slick-carousel v1 testimonial-main" data-items="1" data-large="1" data-medium="1" data-small="1" data-smallest="1" data-pagination="false" data-nav="false" data-asnavfor=".testimonial-thumbnail" data-slickparent="true">
                        <?php foreach ($testimonials as $item) { ?>
                            <?php $img_src = ( isset( $item['img_src']['id'] ) && $item['img_src']['id'] != 0 ) ? wp_get_attachment_url( $item['img_src']['id'] ) : ''; ?>
                            
                            <div class="testimonials-item2 text-center">
                                <?php if ( !empty($item['content']) ) { ?>
                                    <div class="description"><?php echo trim($item['content']); ?></div>
                                <?php } ?>
                                <?php if ( !empty($item['name']) ) {
                                    $title = '<h3 class="name-client">'.$item['name'].'</h3>';
                                    if ( ! empty( $item['link']['url'] ) ) {
                                        $title = sprintf( '<h3 class="name-client"><a href="'.esc_url($item['link']['url']).'" target="'.esc_attr($item['link']['is_external'] ? '_blank' : '_self').'" '.($item['link']['nofollow'] ? 'rel="nofollow"' : '').'>%1$s</a></h3>', $item['name'] );
                                    }
                                    echo trim($title);
                                ?>
                                <?php } ?>
                                <?php if ( !empty($item['job']) ) { ?>
                                    <div class="job"><?php echo esc_html($item['job']); ?></div>
                                <?php } ?>

                            </div>
                        <?php } ?>
                    </div>

                    <div class="wrapper-testimonial-thumbnail">
                        <div class="slick-carousel testimonial-thumbnail" data-centerpadding='0px' data-centermode="true" data-items="5" data-large="5" data-medium="5" data-small="3" data-smallest="3" data-pagination="false" data-nav="false" data-asnavfor=".testimonial-main" data-slidestoscroll="1" data-focusonselect="true" data-infinite="true">
                            <?php foreach ($testimonials as $item) { ?>
                                <?php $img_src = ( isset( $item['img_src']['id'] ) && $item['img_src']['id'] != 0 ) ? wp_get_attachment_url( $item['img_src']['id'] ) : ''; ?>
                                <?php if ( $img_src ) { ?>
                                    <div class="wrapper-avarta">
                                        <div class="avarta">
                                            <img src="<?php echo esc_url($img_src); ?>" alt="<?php echo esc_attr(!empty($item['name']) ? $item['name'] : ''); ?>">
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    </div>

                <?php } elseif($layout_type == 'style1' ) { ?>

                    <div class="slick-carousel testimonial-main <?php echo trim( ($columns >= count($testimonials))?'hidden-dots':'' ); ?>" data-items="<?php echo esc_attr($columns); ?>" data-large="<?php echo esc_attr( $columns_tablet ); ?>" data-medium="<?php echo esc_attr( $columns_tablet ); ?>" data-small="<?php echo esc_attr($columns_mobile); ?>" data-smallest="<?php echo esc_attr($columns_mobile); ?>" data-pagination="<?php echo esc_attr($show_pagination ? 'true' : 'false'); ?>" data-nav="<?php echo esc_attr($show_nav ? 'true' : 'false'); ?>" data-infinite="true"
                        data-slidestoscroll="1"
                        data-slidestoscroll_smallmedium="1"
                        data-slidestoscroll_extrasmall="1"
                        >
                        <?php foreach ($testimonials as $item) { ?>
                        <div class="item">

                            <div class="testimonials-item">
                                <div class="top-inner d-flex align-items-center">
                                    <?php if ( !empty($item['title']) ) { ?>
                                        <h3 class="title"><?php echo esc_html($item['title']); ?></h3>
                                    <?php } ?>
                                    <div class="icon-top ms-auto">
                                        <svg width="37" height="26" viewBox="0 0 37 26" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path opacity="0.15" d="M9.1 25.8C6.76667 25.8 4.66667 24.8667 2.8 23C0.933334 21.0667 0 18.2333 0 14.5C0 10.2333 1.13333 6.76666 3.4 4.1C5.73333 1.36667 9.03333 0 13.3 0C14.8333 0 16.0333 0.099998 16.9 0.299995V4.9C15.9667 4.76666 14.7667 4.7 13.3 4.7C11.0333 4.7 9.2 5.46666 7.8 7C6.46667 8.33333 5.7 10.1 5.5 12.3C6.36667 11.2333 7.76667 10.7 9.7 10.7C11.7 10.7 13.4 11.4 14.8 12.8C16.2 14.1333 16.9 15.9 16.9 18.1C16.9 20.3667 16.1667 22.2333 14.7 23.7C13.2333 25.1 11.3667 25.8 9.1 25.8ZM29 25.8C26.6667 25.8 24.5667 24.8667 22.7 23C20.8333 21.0667 19.9 18.2333 19.9 14.5C19.9 10.2333 21.0333 6.76666 23.3 4.1C25.6333 1.36667 28.9333 0 33.2 0C34.7333 0 35.9333 0.099998 36.8 0.299995V4.9C35.8667 4.76666 34.6667 4.7 33.2 4.7C30.9333 4.7 29.1 5.46666 27.7 7C26.3667 8.33333 25.6 10.1 25.4 12.3C26.2667 11.2333 27.6667 10.7 29.6 10.7C31.6 10.7 33.3 11.4 34.7 12.8C36.1 14.1333 36.8 15.9 36.8 18.1C36.8 20.3667 36.0667 22.2333 34.6 23.7C33.1333 25.1 31.2667 25.8 29 25.8Z" fill="currentColor"/>
                                        </svg>
                                    </div>
                                </div>

                                <?php if ( !empty($item['content']) ) { ?>
                                    <div class="description"><?php echo trim($item['content']); ?></div>
                                <?php } ?>
                                <?php if ( !empty($item['star']) ) { ?>
                                    <div class="star">
                                        <div class="inner">
                                            <div class="w-percent" style="width: <?php echo trim($item['star']*20)?>%;"></div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="inner-bottom">
                                    <div class="d-flex align-items-center">

                                        <?php if ( isset( $item['img_src']['id'] ) ) { ?>
                                        <div class="wrapper-avarta flex-shrink-0">
                                            <div class="avarta d-flex justify-content-center align-items-center">
                                                <?php echo homez_get_attachment_thumbnail($item['img_src']['id'], 'full'); ?>
                                            </div>
                                        </div>
                                        <?php } ?>
                                        
                                        <div class="info-testimonials flex-grow-1">
                                            <?php if ( !empty($item['name']) ) {

                                                $title = '<h3 class="name-client">'.$item['name'].'</h3>';
                                                if ( ! empty( $item['link']['url'] ) ) {
                                                    $title = sprintf( '<h3 class="name-client"><a href="'.esc_url($item['link']['url']).'" target="'.esc_attr($item['link']['is_external'] ? '_blank' : '_self').'" '.($item['link']['nofollow'] ? 'rel="nofollow"' : '').'>%1$s</a></h3>', $item['name'] );
                                                }
                                                echo trim($title);
                                            ?>
                                            <?php } ?>

                                            <?php if ( !empty($item['job']) ) { ?>
                                                <div class="job"><?php echo esc_html($item['job']); ?></div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <?php } ?>
                    </div>
                <?php } elseif($layout_type == 'style3' ) { ?>

                    <div class="slick-carousel testimonial-main <?php echo trim( ($columns >= count($testimonials))?'hidden-dots':'' ); ?>" data-items="<?php echo esc_attr($columns); ?>" data-large="<?php echo esc_attr( $columns_tablet ); ?>" data-medium="<?php echo esc_attr( $columns_tablet ); ?>" data-small="<?php echo esc_attr($columns_mobile); ?>" data-smallest="<?php echo esc_attr($columns_mobile); ?>" data-pagination="<?php echo esc_attr($show_pagination ? 'true' : 'false'); ?>" data-nav="<?php echo esc_attr($show_nav ? 'true' : 'false'); ?>" data-infinite="true"
                        data-slidestoscroll="1"
                        data-slidestoscroll_smallmedium="1"
                        data-slidestoscroll_extrasmall="1"
                        >
                        <?php foreach ($testimonials as $item) { ?>
                        <div class="item">

                            <div class="testimonials-item3 position-relative">
                                <div class="icon-top">
                                    <svg width="37" height="26" viewBox="0 0 37 26" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.15" d="M9.1 25.8C6.76667 25.8 4.66667 24.8667 2.8 23C0.933334 21.0667 0 18.2333 0 14.5C0 10.2333 1.13333 6.76666 3.4 4.1C5.73333 1.36667 9.03333 0 13.3 0C14.8333 0 16.0333 0.099998 16.9 0.299995V4.9C15.9667 4.76666 14.7667 4.7 13.3 4.7C11.0333 4.7 9.2 5.46666 7.8 7C6.46667 8.33333 5.7 10.1 5.5 12.3C6.36667 11.2333 7.76667 10.7 9.7 10.7C11.7 10.7 13.4 11.4 14.8 12.8C16.2 14.1333 16.9 15.9 16.9 18.1C16.9 20.3667 16.1667 22.2333 14.7 23.7C13.2333 25.1 11.3667 25.8 9.1 25.8ZM29 25.8C26.6667 25.8 24.5667 24.8667 22.7 23C20.8333 21.0667 19.9 18.2333 19.9 14.5C19.9 10.2333 21.0333 6.76666 23.3 4.1C25.6333 1.36667 28.9333 0 33.2 0C34.7333 0 35.9333 0.099998 36.8 0.299995V4.9C35.8667 4.76666 34.6667 4.7 33.2 4.7C30.9333 4.7 29.1 5.46666 27.7 7C26.3667 8.33333 25.6 10.1 25.4 12.3C26.2667 11.2333 27.6667 10.7 29.6 10.7C31.6 10.7 33.3 11.4 34.7 12.8C36.1 14.1333 36.8 15.9 36.8 18.1C36.8 20.3667 36.0667 22.2333 34.6 23.7C33.1333 25.1 31.2667 25.8 29 25.8Z" fill="currentColor"/>
                                    </svg>
                                </div>
                                <div class="d-flex align-items-center">
                                    <?php if ( isset( $item['img_src']['id'] ) && !empty($item['img_src']['id']) ) { ?>
                                        <div class="flex-shrink-0">
                                            <div class="wrapper-avarta position-relative">
                                                <div class="avarta d-flex justify-content-center align-items-center">
                                                    <?php echo homez_get_attachment_thumbnail($item['img_src']['id'], 'full'); ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div class="info-testimonials flex-grow-1">
                                        <?php if ( !empty($item['star']) ) { ?>
                                            <div class="star d-flex align-items-center">
                                                <span class="text"><?php echo number_format($item['star'], 1, '.', ''); ?> </span>
                                                <div class="inner">
                                                    <div class="w-percent" style="width: <?php echo trim($item['star']*20)?>%;"></div>
                                                </div>
                                            </div>
                                        <?php } ?>

                                        <?php if ( !empty($item['title']) ) { ?>
                                            <h3 class="title"><?php echo esc_html($item['title']); ?></h3>
                                        <?php } ?>
                                        <?php if ( !empty($item['name']) ) {
                                            $title = '<h3 class="name-client">'.$item['name'].'</h3>';
                                            if ( ! empty( $item['link']['url'] ) ) {
                                                $title = sprintf( '<h3 class="name-client"><a href="'.esc_url($item['link']['url']).'" target="'.esc_attr($item['link']['is_external'] ? '_blank' : '_self').'" '.($item['link']['nofollow'] ? 'rel="nofollow"' : '').'>%1$s</a></h3>', $item['name'] );
                                            }
                                            echo trim($title);
                                        ?>
                                        <?php } ?>
                                        <?php if ( !empty($item['job']) ) { ?>
                                            <div class="job"><?php echo esc_html($item['job']); ?></div>
                                        <?php } ?>

                                    </div>
                                </div>
                                <?php if ( !empty($item['content']) ) { ?>
                                    <div class="description"><?php echo trim($item['content']); ?></div>
                                <?php } ?>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                <?php } elseif($layout_type == 'style4' ) { ?>

                    <div class="slick-carousel testimonial-main <?php echo trim( ($columns >= count($testimonials))?'hidden-dots':'' ); ?>" data-items="<?php echo esc_attr($columns); ?>" data-large="<?php echo esc_attr( $columns_tablet ); ?>" data-medium="<?php echo esc_attr( $columns_tablet ); ?>" data-small="<?php echo esc_attr($columns_mobile); ?>" data-smallest="<?php echo esc_attr($columns_mobile); ?>" data-pagination="<?php echo esc_attr($show_pagination ? 'true' : 'false'); ?>" data-nav="<?php echo esc_attr($show_nav ? 'true' : 'false'); ?>" data-infinite="true">
                        <?php foreach ($testimonials as $item) { ?>
                        <div class="item">

                            <div class="testimonials-item4 position-relative">
                                
                                <div class="top-inner d-flex align-items-center">
                                    <?php if ( !empty($item['title']) ) { ?>
                                        <h3 class="title"><?php echo esc_html($item['title']); ?></h3>
                                    <?php } ?>
                                    <div class="icon-top ms-auto">
                                        <svg width="37" height="26" viewBox="0 0 37 26" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path opacity="0.15" d="M9.1 25.8C6.76667 25.8 4.66667 24.8667 2.8 23C0.933334 21.0667 0 18.2333 0 14.5C0 10.2333 1.13333 6.76666 3.4 4.1C5.73333 1.36667 9.03333 0 13.3 0C14.8333 0 16.0333 0.099998 16.9 0.299995V4.9C15.9667 4.76666 14.7667 4.7 13.3 4.7C11.0333 4.7 9.2 5.46666 7.8 7C6.46667 8.33333 5.7 10.1 5.5 12.3C6.36667 11.2333 7.76667 10.7 9.7 10.7C11.7 10.7 13.4 11.4 14.8 12.8C16.2 14.1333 16.9 15.9 16.9 18.1C16.9 20.3667 16.1667 22.2333 14.7 23.7C13.2333 25.1 11.3667 25.8 9.1 25.8ZM29 25.8C26.6667 25.8 24.5667 24.8667 22.7 23C20.8333 21.0667 19.9 18.2333 19.9 14.5C19.9 10.2333 21.0333 6.76666 23.3 4.1C25.6333 1.36667 28.9333 0 33.2 0C34.7333 0 35.9333 0.099998 36.8 0.299995V4.9C35.8667 4.76666 34.6667 4.7 33.2 4.7C30.9333 4.7 29.1 5.46666 27.7 7C26.3667 8.33333 25.6 10.1 25.4 12.3C26.2667 11.2333 27.6667 10.7 29.6 10.7C31.6 10.7 33.3 11.4 34.7 12.8C36.1 14.1333 36.8 15.9 36.8 18.1C36.8 20.3667 36.0667 22.2333 34.6 23.7C33.1333 25.1 31.2667 25.8 29 25.8Z" fill="currentColor"/>
                                        </svg>
                                    </div>
                                </div>

                                <?php if ( !empty($item['content']) ) { ?>
                                    <div class="description"><?php echo trim($item['content']); ?></div>
                                <?php } ?>
                                <div class="d-flex align-items-center">
                                    <?php if ( isset( $item['img_src']['id'] ) && !empty($item['img_src']['id']) ) { ?>
                                        <div class="flex-shrink-0">
                                            <div class="wrapper-avarta position-relative">
                                                <div class="avarta d-flex justify-content-center align-items-center">
                                                    <?php echo homez_get_attachment_thumbnail($item['img_src']['id'], 'full'); ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div class="info-testimonials flex-grow-1">
                                        <?php if ( !empty($item['star']) ) { ?>
                                            <div class="star d-flex align-items-center">
                                                <span class="text"><?php echo number_format($item['star'], 1, '.', ''); ?> </span>
                                                <div class="inner">
                                                    <div class="w-percent" style="width: <?php echo trim($item['star']*20)?>%;"></div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        
                                        <?php if ( !empty($item['name']) ) {
                                            $title = '<h3 class="name-client">'.$item['name'].'</h3>';
                                            if ( ! empty( $item['link']['url'] ) ) {
                                                $title = sprintf( '<h3 class="name-client"><a href="'.esc_url($item['link']['url']).'" target="'.esc_attr($item['link']['is_external'] ? '_blank' : '_self').'" '.($item['link']['nofollow'] ? 'rel="nofollow"' : '').'>%1$s</a></h3>', $item['name'] );
                                            }
                                            echo trim($title);
                                        ?>
                                        <?php } ?>
                                        <?php if ( !empty($item['job']) ) { ?>
                                            <div class="job"><?php echo esc_html($item['job']); ?></div>
                                        <?php } ?>

                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                <?php } elseif($layout_type == 'style5' ) { ?>

                    <div class="slick-carousel testimonial-main" data-items="1" data-large="1" data-medium="1" data-small="1" data-smallest="1" data-pagination="false" data-nav="false" data-asnavfor=".testimonial-thumbnail" data-slickparent="true">
                        <?php foreach ($testimonials as $item) { ?>
                            <?php $img_src = ( isset( $item['img_src']['id'] ) && $item['img_src']['id'] != 0 ) ? wp_get_attachment_url( $item['img_src']['id'] ) : ''; ?>
                            
                            <div class="testimonials-item4 text-center">
                                <?php if ( !empty($item['content']) ) { ?>
                                    <div class="description"><?php echo trim($item['content']); ?></div>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="wrapper-testimonial-thumbnail4">
                        <div class="slick-carousel testimonial-thumbnail" data-centerpadding='0px' data-centermode="true" data-items="3" data-large="3" data-medium="3" data-small="3" data-smallest="1" data-pagination="false" data-nav="false" data-asnavfor=".testimonial-main" data-slidestoscroll="1" data-focusonselect="true" data-infinite="true">
                            <?php foreach ($testimonials as $item) { ?>
                                <div class="item">
                                    <div class="item-testimonials4 d-flex align-items-center justify-content-center">
                                        <?php $img_src = ( isset( $item['img_src']['id'] ) && $item['img_src']['id'] != 0 ) ? wp_get_attachment_url( $item['img_src']['id'] ) : ''; ?>
                                        <?php if ( $img_src ) { ?>
                                            <div class="wrapper-avarta flex-shrink-0">
                                                <div class="avarta">
                                                    <img src="<?php echo esc_url($img_src); ?>" alt="<?php echo esc_attr(!empty($item['name']) ? $item['name'] : ''); ?>">
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <div class="inner-right flex-grow-1">
                                            <?php if ( !empty($item['name']) ) {
                                                $title = '<h3 class="name-client">'.$item['name'].'</h3>';
                                                if ( ! empty( $item['link']['url'] ) ) {
                                                    $title = sprintf( '<h3 class="name-client"><a href="'.esc_url($item['link']['url']).'" target="'.esc_attr($item['link']['is_external'] ? '_blank' : '_self').'" '.($item['link']['nofollow'] ? 'rel="nofollow"' : '').'>%1$s</a></h3>', $item['name'] );
                                                }
                                                echo trim($title);
                                            ?>
                                            <?php } ?>
                                            <?php if ( !empty($item['job']) ) { ?>
                                                <div class="job"><?php echo esc_html($item['job']); ?></div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                <?php } ?>
            </div>
            <?php
        }
    }
}

if ( version_compare(ELEMENTOR_VERSION, '3.5.0', '<') ) {
    Plugin::instance()->widgets_manager->register( new Homez_Elementor_Testimonials );
} else {
    Plugin::instance()->widgets_manager->register( new Homez_Elementor_Testimonials );
}