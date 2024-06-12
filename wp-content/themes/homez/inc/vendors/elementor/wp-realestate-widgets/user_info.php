<?php

//namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Homez_Elementor_User_Info extends Elementor\Widget_Base {

    public function get_name() {
        return 'apus_element_user_info';
    }

    public function get_title() {
        return esc_html__( 'Apus Header User Info', 'homez' );
    }
    
    public function get_categories() {
        return [ 'homez-header-elements' ];
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
            'icon',
            [
                'label' => esc_html__( 'Icon', 'homez' ),
                'type' =>  Elementor\Controls_Manager::ICON,
                'default' => 'flaticon-user'
            ]
        );

        $this->add_control(
            'btn_title',
            [
                'label' => esc_html__( 'Button Title', 'homez' ),
                'type' => Elementor\Controls_Manager::TEXT,
                'placeholder'   => esc_html__( 'Enter title here', 'homez' ),
                'default' => 'Login / Register'
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => esc_html__( 'Title', 'homez' ),
                'type' => Elementor\Controls_Manager::TEXT,
                'placeholder'   => esc_html__( 'Enter title here', 'homez' ),
                'default' => 'Welcome to Homez'
            ]
        );

        $this->add_control(
            'reset_password_title',
            [
                'label' => esc_html__( 'Reset Password Title', 'homez' ),
                'type' => Elementor\Controls_Manager::TEXT,
                'placeholder'   => esc_html__( 'Enter title here', 'homez' ),
                'default' => 'Reset Password'
            ]
        );

        $this->add_control(
            'layout_type',
            [
                'label' => esc_html__( 'Layout Type', 'homez' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'options' => array(
                    'popup' => esc_html__('Popup', 'homez'),
                    'page' => esc_html__('Page', 'homez'),
                ),
                'default' => 'popup'
            ]
        );

        $this->add_control(
            'tab_login_title',
            [
                'label' => esc_html__( 'Login Title', 'homez' ),
                'type' => Elementor\Controls_Manager::TEXT,
                'placeholder'   => esc_html__( 'Enter title here', 'homez' ),
                'default' => 'Login',
                'condition' => [
                    'layout_type' => 'popup',
                ],
            ]
        );

        $this->add_control(
            'tab_register_title',
            [
                'label' => esc_html__( 'Register Title', 'homez' ),
                'type' => Elementor\Controls_Manager::TEXT,
                'placeholder'   => esc_html__( 'Enter title here', 'homez' ),
                'default' => 'Register',
                'condition' => [
                    'layout_type' => 'popup',
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

        $this->add_responsive_control(
            'align',
            [
                'label' => esc_html__( 'Alignment', 'homez' ),
                'type' => Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'homez' ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'homez' ),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'homez' ),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_title_style',
            [
                'label' => esc_html__( 'Color', 'homez' ),
                'tab' => Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => esc_html__( 'Color Text', 'homez' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .name-acount' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .btn-login' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .login-icon.st_full' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'text_hover_color',
            [
                'label' => esc_html__( 'Color Hover Link', 'homez' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .btn-login:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .btn-login:focus' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_section();

    }

    protected function render() {
        $settings = $this->get_settings();

        extract( $settings );

        if ( is_user_logged_in() ) {
            $user_id = get_current_user_id();
            $userdata = get_userdata($user_id);
            $user_name = $userdata->display_name;
            
            $menu_nav = 'user-menu';

            if ( WP_RealEstate_User::is_agency($user_id) ) {
                $menu_nav = 'agency-menu';
                $agency_id = WP_RealEstate_User::get_agency_by_user_id($user_id);
                $user_name = get_post_field('post_title', $agency_id);
                $post_thumbnail_id = get_post_thumbnail_id($agency_id);
                $avatar = homez_get_attachment_thumbnail( $post_thumbnail_id, 'thumbnail' );
            } elseif ( WP_RealEstate_User::is_agent($user_id) ) {
                $menu_nav = 'agent-menu';
                $agent_id = WP_RealEstate_User::get_agent_by_user_id($user_id);
                $user_name = get_post_field('post_title', $agent_id);
                $post_thumbnail_id = get_post_thumbnail_id($agent_id);
                $avatar = homez_get_attachment_thumbnail( $post_thumbnail_id, 'thumbnail' );
            } else {
                $user_name = get_user_meta( $user_id, 'first_name', true ).' '.get_user_meta( $user_id, 'last_name', true );
            }
            ?>
            <div class="top-wrapper-menu author-verify <?php echo esc_attr($el_class); ?>">
                <a class="drop-dow" href="javascript:void(0);">
                    <div class="infor-account">
                        <div class="avatar-wrapper">
                            <?php if ( !empty($avatar)) {
                                echo trim($avatar);
                            } else {
                                echo homez_get_avatar($user_id, 45);
                            } ?>
                        </div>
                    </div>
                </a>
                <?php
                    if ( !empty($menu_nav) && has_nav_menu( $menu_nav ) ) {
                        $args = array(
                            'theme_location' => $menu_nav,
                            'container_class' => 'inner-top-menu',
                            'menu_class' => 'nav navbar-nav topmenu-menu',
                            'fallback_cb' => '',
                            'menu_id' => '',
                            'walker' => new Homez_Nav_Menu()
                        );
                        wp_nav_menu($args);
                    }
                ?>
            </div>
        <?php } else {
            $login_register_page_id = wp_realestate_get_option('login_register_page_id');
        ?>
            <div class="top-wrapper-menu <?php echo esc_attr($el_class); ?>">
                <?php if ( $layout_type == 'page' ) { ?>
                    
                    
                        <a class="btn-login" href="<?php echo esc_url( get_permalink( $login_register_page_id ) ); ?>" title="<?php esc_attr_e('Sign in','homez'); ?>">
                            <?php if ( $icon ) { ?>
                                <span class="login-icon"><i class="<?php echo esc_attr($icon); ?>"></i></span>
                            <?php } ?>
                            <?php if ( $btn_title ) {
                                echo '<span>'.esc_html($btn_title).'</span>';
                            } ?>
                        </a>

                <?php } else { ?>

                        <a class="btn-login apus-user-login" href="#apus_login_register_tabs_form" title="<?php esc_attr_e('Login','homez'); ?>">
                            <?php if ( $icon ) { ?>
                                <span class="login-icon"><i class="<?php echo esc_attr($icon); ?>"></i></span>
                            <?php } ?>
                            <?php if ( $btn_title ) {
                                echo '<span>'.esc_html($btn_title).'</span>';
                            } ?>
                        </a>


                    <div id="apus_login_register_tabs_form" class="apus_login_register_form mfp-hide" data-effect="fadeIn">
                        <div class="advance-search-top d-flex align-items-center">
                            <h4 class="advance-title"><?php echo trim($title); ?></h4>
                            <div class="ms-auto">
                                <span class="close-advance-popup"><i class="ti-close"></i></span>
                            </div>
                        </div>
                        <div class="wrapper-tab-account">
                            <ul class="tabs-account nav nav-tabs">
                                <li>
                                    <a data-bs-toggle="tab" href="#login-register-tab-login" class="active"><?php echo trim($tab_login_title); ?></a>
                                </li>
                                <li>
                                    <a data-bs-toggle="tab" href="#login-register-tab-register"><?php echo trim($tab_register_title); ?></a>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane active in apus_login_register_form" id="login-register-tab-login">
                                <?php echo do_shortcode( '[wp_realestate_login reset_password_title="'.$reset_password_title.'"]' ); ?>
                            </div>

                            <div class="tab-pane in apus_login_register_form" id="login-register-tab-register">
                                <?php echo do_shortcode( '[wp_realestate_register]' ); ?>
                            </div>
                        </div>
                    </div>
                    
                <?php } ?>
            </div>
        <?php }
    }
}

Elementor\Plugin::instance()->widgets_manager->register( new Homez_Elementor_User_Info );