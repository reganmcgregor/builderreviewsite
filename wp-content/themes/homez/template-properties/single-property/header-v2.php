<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;

$meta_obj = WP_RealEstate_Property_Meta::get_instance($post->ID);
?>
<div class="property-detail-header top-header-detail-property v2">
    <div class="d-md-flex align-items-center">
        <div class="left-infor">
            <div class="title-wrapper">
                <?php the_title( '<h1 class="property-title">', '</h1>' ); ?>
            </div>
            <div class="property-detail-middle d-flex align-items-center flex-wrap">
                <?php homez_property_display_full_location($post, 'no-icon-title',true); ?>
            </div>

            <div class="property-metas d-flex align-items-center flex-wrap">
                <?php homez_property_display_status_label($post, true, true); ?>
                <?php homez_property_display_postdate($post, 'icon', 'ago'); ?>
                <?php homez_property_property_id($post, 'icon'); ?>
                <?php
                    $suffix = wp_realestate_get_option('measurement_unit_area');
                    homez_property_display_meta($post, 'lot_area', 'flaticon-expand', false, $suffix, true);
                ?>
            </div>
        </div>
        <div class="property-action-detail ms-auto">
            <div class="d-flex align-items-center action-item">
                
                <?php
                    if ( homez_get_config('listing_enable_favorite', true) ) {
                        $args = array(
                            'added_icon_class' => 'flaticon-like',
                            'add_icon_class' => 'flaticon-like',
                            'show_text' => false,
                            'add_text' => esc_html__('Save', 'homez'),
                            'added_text' => esc_html__('Saved', 'homez'),
                        );
                        WP_RealEstate_Favorite::display_favorite_btn($post->ID, $args);
                    }

                    if ( homez_get_config('listing_enable_compare', true) ) {
                        $args = array(
                            'added_icon_class' => 'flaticon-new-tab',
                            'add_icon_class' => 'flaticon-new-tab',
                            'show_text' => false,
                            'add_text' => esc_html__('Compare', 'homez'),
                            'added_text' => esc_html__('Compared', 'homez'),
                        );
                        WP_RealEstate_Compare::display_compare_btn($post->ID, $args);
                    }
                ?>
                <?php get_template_part('template-parts/sharebox-property'); ?>
                <?php
                if ( homez_get_config('property_enable_printer', false) ) {
                    homez_property_print_btn($post, false);
                }
                ?>
            </div>
            <?php homez_property_display_price($post); ?>
        </div>
    </div>
</div>