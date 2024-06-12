<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Homez_Elementor_Packages extends Elementor\Widget_Base {

	public function get_name() {
        return 'apus_element_packages';
    }

	public function get_title() {
        return esc_html__( 'Apus Packages', 'homez' );
    }
    
	public function get_categories() {
        return [ 'homez-elements' ];
    }

	protected function register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Content', 'homez' ),
                'tab' => Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        
        $this->add_control(
            'orderby',
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
            'number',
            [
                'label' => esc_html__( 'Number Product', 'homez' ),
                'type' => Elementor\Controls_Manager::NUMBER,
                'input_type' => 'number',
                'description' => esc_html__( 'Number Product to display', 'homez' ),
                'default' => 3
            ]
        );
        $this->add_control(
            'columns',
            [
                'label' => esc_html__( 'Columns', 'homez' ),
                'type' => Elementor\Controls_Manager::TEXT,
                'input_type' => 'number',
                'default' => 3,
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
                'label' => esc_html__( 'Style', 'homez' ),
                'tab' => Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'bg_color',
            [
                'label' => esc_html__( 'Background for Highlight', 'homez' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .subwoo-inner.is_featured .header-sub' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_section();
    }

	protected function render() {
        $settings = $this->get_settings();

        extract( $settings );

        $loop = homez_get_products( array('product_type' => 'property_package', 'post_per_page' => $number, 'orderby' => $orderby, 'order' => $order));
        ?>
        <div class="woocommerce widget-subwoo <?php echo esc_attr($el_class); ?>">
            <?php if ($loop->have_posts()): ?>
                <div class="row">
                    <?php while ( $loop->have_posts() ) : $loop->the_post(); global $product;
                        $package_icon = get_post_meta($product->get_id(), 'apus_product_package_icon_id', true);
                    ?>
                        <div class="col-12 col-sm-6 col-md-<?php echo esc_attr(12/$columns); ?>">
                            <div class="subwoo-inner <?php echo esc_attr($product->is_featured()?'is_featured':''); ?>">
                                <div class="item">
                                    <div class="header-sub d-flex">
                                        <div class="flex-grow-1">
                                            <h3 class="title"><?php the_title(); ?></h3>
                                            <div class="price"><?php echo (!empty($product->get_price())) ? $product->get_price_html() : esc_html__('Free','homez'); ?></div>
                                        </div>
                                        <div class="ms-auto package_icon">
                                            <?php
                                            if ( $package_icon ) {
                                                echo homez_get_attachment_thumbnail($package_icon, 'full');
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="content">
                                        <?php the_content(); ?>
                                    </div>
                                    <div class="bottom-sub">
                                        <?php if ( has_excerpt() ) { ?>
                                            <div class="short-des"><?php the_excerpt(); ?></div>
                                        <?php } ?>
                                        <div class="button-action"><?php do_action( 'woocommerce_after_shop_loop_item' ); ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>  
                    <?php endwhile; ?>
                </div>
                <?php wp_reset_postdata(); ?>
            <?php endif; ?>
        </div>
        <?php
    }
}

Elementor\Plugin::instance()->widgets_manager->register( new Homez_Elementor_Packages );