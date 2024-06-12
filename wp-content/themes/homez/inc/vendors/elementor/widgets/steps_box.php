<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Homez_Elementor_Steps_Box extends Widget_Base {

	public function get_name() {
        return 'apus_element_steps_box';
    }

	public function get_title() {
        return esc_html__( 'Apus Steps Box', 'homez' );
    }

	public function get_icon() {
        return 'eicon-image-box';
    }

	public function get_categories() {
        return [ 'homez-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Steps Box', 'homez' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'image_icon',
            [
                'label' => esc_html__( 'Image or Icon', 'homez' ),
                'type' => Controls_Manager::SELECT,
                'options' => array(
                    'icon' => esc_html__('Icon', 'homez'),
                    'image' => esc_html__('Image', 'homez'),
                ),
                'default' => 'image'
            ]
        );

        $repeater->add_control(
            'icon',
            [
                'label' => esc_html__( 'Icon', 'homez' ),
                'type' => Controls_Manager::ICON,
                'default' => 'fa fa-star',
                'condition' => [
                    'image_icon' => 'icon',
                ],
            ]
        );

        $repeater->add_control(
            'image',
            [
                'label' => esc_html__( 'Choose Image', 'homez' ),
                'type' => Controls_Manager::MEDIA,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'image_icon' => 'image',
                ],
            ]
        );

        $repeater->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'thumbnail', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
                'default' => 'full',
                'separator' => 'none',
                'condition' => [
                    'image_icon' => 'image',
                ],
            ]
        );

        $repeater->add_control(
            'number',
            [
                'label' => esc_html__( 'Number', 'homez' ),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'placeholder' => '',
            ]
        );

        $repeater->add_control(
            'title_text',
            [
                'label' => esc_html__( 'Title', 'homez' ),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'placeholder' => '',
            ]
        );

        $repeater->add_control(
            'description_text',
            [
                'label' => esc_html__( 'Content', 'homez' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => '',
                'placeholder' => '',

            ]
        );

        $repeater->add_control(
            'link',
            [
                'label' => esc_html__( 'Link to', 'homez' ),
                'type' => Controls_Manager::URL,
                'placeholder' => esc_html__( 'https://your-link.com', 'homez' ),
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'features',
            [
                'label' => esc_html__( 'Steps Box', 'homez' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
            ]
        );
        
        $this->add_control(
            'columns',
            [
                'label' => esc_html__( 'Columns', 'homez' ),
                'type' => Controls_Manager::TEXT,
                'input_type' => 'number',
                'default' => '3',
            ]
        );

        $this->add_control(
            'style',
            [
                'label' => esc_html__( 'Style', 'homez' ),
                'type' => Controls_Manager::SELECT,
                'options' => array(
                    'style1' => esc_html__('Horizontal', 'homez'),
                    'style2' => esc_html__('Vertical', 'homez'),
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
            'section_box_style',
            [
                'label' => esc_html__( 'Box Style', 'homez' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__( 'Icon Color', 'homez' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .features-box-image ' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__( 'Icon Typography', 'homez' ),
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .features-box-image',
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__( 'Title Color', 'homez' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__( 'Title Typography', 'homez' ),
                'name' => 'title2_typography',
                'selector' => '{{WRAPPER}} .title',
            ]
        );

        $this->add_control(
            'des_color',
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
                'name' => 'description_typography',
                'selector' => '{{WRAPPER}} .description',
            ]
        );

        $this->end_controls_section();

    }

	protected function render() {

        $settings = $this->get_settings();

        extract( $settings );

        if ( !empty($features) ) {
            ?>
            <div class="widget-address-box <?php echo esc_attr($el_class.' '.$alignment.' '.$style); ?>">
                <div class="row">
                    <?php foreach ($features as $item): ?>
                        <div class="item col-12 col-sm-<?php echo esc_attr(12/$columns);?>">
                            <div class="item-step position-relative <?php echo trim($style); ?>">
                                 <div class="top-inner">
                                    <?php
                                    $has_content = ! empty( $item['title_text'] ) || ! empty( $item['description_text'] );
                                    $html = '';

                                    if ( $item['image_icon'] == 'image' ) {
                                        if ( ! empty( $item['image']['url'] ) ) {
                                            $this->add_render_attribute( 'image', 'src', $item['image']['url'] );
                                            $this->add_render_attribute( 'image', 'alt', Control_Media::get_image_alt( $item['image'] ) );
                                            $this->add_render_attribute( 'image', 'title', Control_Media::get_image_title( $item['image'] ) );


                                            $image_html = Group_Control_Image_Size::get_attachment_image_html( $item, 'thumbnail', 'image' );

                                            if ( ! empty( $item['link']['url'] ) ) {
                                                $image_html = '<a href="'.esc_url($item['link']['url']).'" target="'.esc_attr($item['link']['is_external'] ? '_blank' : '_self').'" '.($item['link']['nofollow'] ? 'rel="nofollow"' : '').'>' . $image_html . '</a>';
                                            }

                                            $html .= '<div class="step-box-image img">' . $image_html . '</div>';
                                        }
                                    } elseif ( $item['image_icon'] == 'icon' && !empty($item['icon'])) {
                                        $html .= '<div class="step-box-image icon"><i class="'.$item['icon'].'"></i></div>';
                                    }
                                $html .= '</div>';
                                if ( $has_content ) {
                                    $html .= '<div class="step-box-content">';

                                    if ( ! empty( $item['number'] ) ) {
                                        $html .= sprintf( '<div class="number">%1$s</div>', $item['number'] );
                                    }

                                    if ( ! empty( $item['title_text'] ) ) {
                                        
                                        $title_html = $item['title_text'];

                                        if ( ! empty( $item['link']['url'] ) ) {
                                            $html .= '<a href="'.esc_url($item['link']['url']).'" target="'.esc_attr($item['link']['is_external'] ? '_blank' : '_self').'" '.($item['link']['nofollow'] ? 'rel="nofollow"' : '').'><h3 class="title">'.$title_html.'</h3></a>';
                                        } else {
                                            $html .= sprintf( '<h3 class="title">%1$s</h3>', $title_html );
                                        }
                                    }

                                    if ( ! empty( $item['description_text'] ) ) {
                                        $html .= sprintf( '<div class="description">%1$s</div>', $item['description_text'] );
                                    }

                                    $html .= '</div>';
                                }

                                echo trim($html);
                                ?>

                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php
        }
    }
}

Plugin::instance()->widgets_manager->register( new Homez_Elementor_Steps_Box );