<?php


if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Homez_Elementor_User_Packages extends Elementor\Widget_Base {

	public function get_name() {
        return 'apus_element_user_packages';
    }

	public function get_title() {
        return esc_html__( 'Apus User Packages', 'homez' );
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
            'title',
            [
                'label' => esc_html__( 'Title', 'homez' ),
                'type' => Elementor\Controls_Manager::TEXT,
                'default' => '',
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

    }

	protected function render() {
        $settings = $this->get_settings();

        extract( $settings );
        ?>
        <?php if ($title!=''): ?>
            <h2 class="title-profile">
                <?php echo esc_attr( $title ); ?>
            </h2>
        <?php endif; ?>
        <div class="box-white-dashboard">
            <div class="inner-list">
                <?php if ( ! is_user_logged_in() ) {
                    ?>
                    <div class="not-found"><?php  esc_html_e( 'Please login to see this page.', 'homez' ); ?></div>
                    <?php
                } else {
                    $packages = WP_RealEstate_Wc_Paid_Listings_Mixes::get_packages_by_user( get_current_user_id(), false );
                    if ( !empty($packages) ) {
                    ?>
                        <div class="widget-user-packages <?php echo esc_attr($el_class); ?>">
                            <div class="widget-content table-responsive">
                                <table class="property-table">
                                    <thead>
                                        <tr>
                                            <td><?php esc_html_e('ID', 'homez'); ?></td>
                                            <td><?php esc_html_e('Package', 'homez'); ?></td>
                                            <td><?php esc_html_e('Package Type', 'homez'); ?></td>
                                            <td><?php esc_html_e('Package Info', 'homez'); ?></td>

                                            <td><?php esc_html_e('Status', 'homez'); ?></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($packages as $package) {
                                            $prefix = WP_REALESTATE_WC_PAID_LISTINGS_PREFIX;
                                            $package_type = get_post_meta($package->ID, $prefix. 'package_type', true);
                                            $package_types = WP_RealEstate_Wc_Paid_Listings_Post_Type_Packages::package_types();

                                        ?>
                                            <tr>
                                                <td class="title"><?php echo trim($package->ID); ?></td>
                                                <td class="title"><?php echo trim($package->post_title); ?></td>
                                                <td>
                                                    <?php
                                                        if ( !empty($package_types[$package_type]) ) {
                                                            echo esc_html($package_types[$package_type]);
                                                        } else {
                                                            echo '--';
                                                        }
                                                    ?>
                                                </td>
                                                <td>
                                                    <div class="package-info-wrapper">
                                                    <?php
                                                        switch ($package_type) {
                                                            case 'property_package':
                                                            default:
                                                                $feature_properties = get_post_meta($package->ID, $prefix. 'feature_properties', true);
                                                                $package_count = get_post_meta($package->ID, $prefix. 'package_count', true);
                                                                $property_limit = get_post_meta($package->ID, $prefix. 'property_limit', true);
                                                                $property_duration = get_post_meta($package->ID, $prefix. 'property_duration', true);
                                                                ?>
                                                                <ul class="lists-info">
                                                                    <li>
                                                                        <span class="title"><?php esc_html_e('Featured:', 'homez'); ?></span>
                                                                        <span class="value">
                                                                            <?php
                                                                                if ( $feature_properties == 'on' ) {
                                                                                    esc_html_e('Yes', 'homez');
                                                                                } else {
                                                                                    esc_html_e('No', 'homez');
                                                                                }
                                                                            ?>
                                                                        </span>
                                                                    </li>
                                                                    <li>
                                                                        <span class="title"><?php esc_html_e('Posted:', 'homez'); ?></span>
                                                                        <span class="value"><?php echo intval($package_count); ?></span>
                                                                    </li>
                                                                    <li>
                                                                        <span class="title"><?php esc_html_e('Limit Posts:', 'homez'); ?></span>
                                                                        <span class="value"><?php echo intval($property_limit); ?></span>
                                                                    </li>
                                                                    <li>
                                                                        <span class="title"><?php esc_html_e('Listing Duration:', 'homez'); ?></span>
                                                                        <span class="value"><?php echo intval($property_duration); ?></span>
                                                                    </li>
                                                                </ul>
                                                                <?php
                                                                break;
                                                        }
                                                    ?>
                                                    </div>
                                                </td>
                                                <td>

                                                    <?php
                                                        $valid = false;
                                                        $user_id = get_current_user_id();
                                                        switch ($package_type) {
                                                            case 'property_package':
                                                            default:
                                                                $valid = WP_RealEstate_Wc_Paid_Listings_Mixes::package_is_valid($user_id, $package->ID);
                                                                break;
                                                        }
                                                        if ( !$valid ) {
                                                            echo '<span class="status-property expired">'.esc_html__('Finished', 'homez').'</span>';
                                                        } else {
                                                            echo '<span class="status-property publish">'.esc_html__('Active', 'homez').'</span>';
                                                        }
                                                    ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="not-found"><?php esc_html_e('Don\'t have any packages', 'homez'); ?></div>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
    <?php }

}

Elementor\Plugin::instance()->widgets_manager->register( new Homez_Elementor_User_Packages );