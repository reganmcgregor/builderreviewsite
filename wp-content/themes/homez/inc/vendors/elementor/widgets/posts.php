<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Homez_Elementor_Posts extends Elementor\Widget_Base {

    public function get_name() {
        return 'apus_element_posts';
    }

    public function get_title() {
        return esc_html__( 'Apus Posts', 'homez' );
    }
    
    public function get_categories() {
        return [ 'homez-elements' ];
    }

    protected function register_controls() {

        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Posts', 'homez' ),
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

        $this->add_control(
            'number',
            [
                'label' => esc_html__( 'Number', 'homez' ),
                'type' => Elementor\Controls_Manager::NUMBER,
                'input_type' => 'number',
                'description' => esc_html__( 'Number posts to display', 'homez' ),
                'default' => 4
            ]
        );
        
        $this->add_control(
            'order_by',
            [
                'label' => esc_html__( 'Order by', 'homez' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'options' => array(
                    '' => esc_html__('Default', 'homez'),
                    'date' => esc_html__('Date', 'homez'),
                    'ID' => esc_html__('ID', 'homez'),
                    'author' => esc_html__('Author', 'homez'),
                    'title' => esc_html__('Title', 'homez'),
                    'modified' => esc_html__('Modified', 'homez'),
                    'rand' => esc_html__('Random', 'homez'),
                    'comment_count' => esc_html__('Comment count', 'homez'),
                    'menu_order' => esc_html__('Menu order', 'homez'),
                ),
                'default' => ''
            ]
        );

        $this->add_control(
            'order',
            [
                'label' => esc_html__( 'Sort order', 'homez' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'options' => array(
                    '' => esc_html__('Default', 'homez'),
                    'ASC' => esc_html__('Ascending', 'homez'),
                    'DESC' => esc_html__('Descending', 'homez'),
                ),
                'default' => ''
            ]
        );

        $this->add_control(
            'layout_type',
            [
                'label' => esc_html__( 'Layout', 'homez' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'options' => array(
                    'carousel' => esc_html__('Carousel', 'homez'),
                    'grid' => esc_html__('Grid', 'homez'),
                    'list' => esc_html__('List', 'homez'),
                    'special' => esc_html__('Special', 'homez'),
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
                'condition' => [
                    'layout_type' => ['grid', 'carousel'],
                ],
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
                'default' => 3,
            ]
        );

        $this->add_control(
            'show_nav',
            [
                'label' => esc_html__( 'Show Nav', 'homez' ),
                'type' => Elementor\Controls_Manager::SWITCHER,
                'default' => '',
                'label_on' => esc_html__( 'Hide', 'homez' ),
                'label_off' => esc_html__( 'Show', 'homez' ),
                'condition' => [
                    'layout_type' => 'carousel',
                ],
            ]
        );

        $this->add_control(
            'show_pagination',
            [
                'label' => esc_html__( 'Show Pagination', 'homez' ),
                'type' => Elementor\Controls_Manager::SWITCHER,
                'default' => '',
                'label_on' => esc_html__( 'Hide', 'homez' ),
                'label_off' => esc_html__( 'Show', 'homez' ),
                'condition' => [
                    'layout_type' => 'carousel',
                ],
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

        $this->add_group_control(
            Elementor\Group_Control_Image_Size::get_type(),
            [
                'name' => 'image', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `image_size` and `image_custom_dimension`.
                'default' => 'large',
                'separator' => 'none',
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
            'section_title_style',
            [
                'label' => esc_html__( 'Tyles', 'homez' ),
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
                    '{{WRAPPER}} .widget-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__( 'Title Typography', 'homez' ),
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .widget-title',
            ]
        );

        $this->add_control(
            'post_title_color',
            [
                'label' => esc_html__( 'Post Title Color', 'homez' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .post .title a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__( 'Post Title Typography', 'homez' ),
                'name' => 'post_title_typography',
                'selector' => '{{WRAPPER}} .post .title a',
            ]
        );

        $this->add_control(
            'post_excerpt_color',
            [
                'label' => esc_html__( 'Post Excerpt Color', 'homez' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .post .description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__( 'Post Excerpt Typography', 'homez' ),
                'name' => 'post_excerpt_typography',
                'selector' => '{{WRAPPER}} .post .description',
            ]
        );

        $this->add_control(
            'post_tag_color',
            [
                'label' => esc_html__( 'Post Tag Color', 'homez' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .post .tags' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__( 'Post Tag Typography', 'homez' ),
                'name' => 'post_tag_typography',
                'selector' => '{{WRAPPER}} .post .tags',
            ]
        );

        $this->add_control(
            'post_readmore_color',
            [
                'label' => esc_html__( 'Post Read More Color', 'homez' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .post .readmore' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__( 'Post Read More Typography', 'homez' ),
                'name' => 'post_readmore_typography',
                'selector' => '{{WRAPPER}} .post .readmore',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {

        $settings = $this->get_settings();

        extract( $settings );

        $args = array(
            'post_type' => 'post',
            'post_status' => 'publish',
            'posts_per_page' => $number,
            'orderby' => $order_by,
            'order' => $order,
        );
        $loop = new WP_Query($args);
        if ( $loop->have_posts() ) {
            if ( $image_size == 'custom' ) {
                
                if ( $image_custom_dimension['width'] && $image_custom_dimension['height'] ) {
                    $thumbsize = $image_custom_dimension['width'].'x'.$image_custom_dimension['height'];
                } else {
                    $thumbsize = 'full';
                }
            } else {
                $thumbsize = $image_size;
            }
            
            set_query_var( 'thumbsize', $thumbsize );

            $columns = !empty($columns) ? $columns : 3;
            $columns_tablet = !empty($columns_tablet) ? $columns_tablet : 2;
            $columns_mobile = !empty($columns_mobile) ? $columns_mobile : 1;
            
            $slides_to_scroll = !empty($slides_to_scroll) ? $slides_to_scroll : $columns;
            $slides_to_scroll_tablet = !empty($slides_to_scroll_tablet) ? $slides_to_scroll_tablet : $slides_to_scroll;
            $slides_to_scroll_mobile = !empty($slides_to_scroll_mobile) ? $slides_to_scroll_mobile : 1;

            ?>
            <div class="widget-blogs <?php echo esc_attr($el_class.' '.$layout_type); ?>">

                <?php if( !empty($title) || !empty($description) || $view_all == 'yes' ){ ?>
                    <div class="info-widget-top d-sm-flex align-items-end">
                        <div class="inner">
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
                        <?php if ( $view_all == 'yes' && !(empty($link_view)) && !(empty($text_view)) ) { ?>
                            <div class="ms-auto">
                                <a href="<?php echo esc_url( $link_view ); ?>" class="btn-readmore">
                                    <?php echo esc_html($text_view); ?><i class="flaticon-up-right-arrow next"></i>
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
                
                <div class="widget-content">

                    <?php if ( $layout_type == 'carousel' ): ?>
                        <div class="inner-carousel">
                            <div class="slick-carousel <?php echo esc_attr($columns < $loop->post_count?'':'hidden-dots'); ?>"
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

                                data-pagination="<?php echo esc_attr($show_pagination ? 'true' : 'false'); ?>" data-nav="<?php echo esc_attr($show_nav ? 'true' : 'false'); ?>">
                                <?php while ( $loop->have_posts() ): $loop->the_post(); ?>
                                    <div class="item">
                                        <?php get_template_part( 'template-posts/loop/inner-grid'); ?>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        </div>
                    <?php elseif ( $layout_type == 'grid' ): ?>
                        <div class="layout-blog">
                            <div class="row">
                                <?php
                                    $mdcol = 12/$columns;
                                    $smcol = 12/$columns_tablet;
                                    $xscol = 12/$columns_mobile;
                                    while ( $loop->have_posts() ) : $loop->the_post();
                                ?>
                                    <div class="col-md-<?php echo esc_attr($mdcol); ?> col-sm-<?php echo esc_attr($smcol); ?> col-xs-<?php echo esc_attr($xscol); ?>">
                                        <?php get_template_part( 'template-posts/loop/inner-grid' ); ?>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        </div>
                    <?php elseif ( $layout_type == 'special' ): $i = 1; ?>
                        <div class="layout-blog">
                            <div class="row d-block">
                                <div class="col-lg-8 float-start"><div class="row">
                                <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>

                                    <?php if( $i <= 2 ){ ?>
                                        <div class="col-sm-6 col-12">
                                            <?php get_template_part( 'template-posts/loop/inner-grid' ); ?>
                                        </div>
                                        <?php if( $i==2 || $i == ($loop->post_count) ){ ?>
                                            </div></div>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <div class="col-lg-4 col-12 float-start">
                                            <?php get_template_part( 'template-posts/loop/inner-list-v3' ); ?>
                                        </div>
                                    <?php } ?>

                                <?php $i++; endwhile; ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="layout-blog">
                            <div class="row">
                                <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
                                    <div class="col-md-12 col-sm-12 col-12">
                                        <?php get_template_part( 'template-posts/loop/inner-list' ); ?>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php wp_reset_postdata(); ?>
                </div>
            </div>
            <?php
        }
    }
}
Elementor\Plugin::instance()->widgets_manager->register( new Homez_Elementor_Posts );