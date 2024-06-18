<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;
$meta_obj = WP_RealEstate_Property_Meta::get_instance($post->ID);
?>
<div class="property-detail-detail">
    <h3 class="title"><?php esc_html_e('Details', 'homez'); ?></h3>
    <ul class="list list-detail d-flex flex-wrap">
        <?php if ( $meta_obj->check_post_meta_exist('property_id') && ($property_id = $meta_obj->get_post_meta('property_id')) ) { ?>
            <li class="d-flex align-items-center">
                <div class="text flex-shrink-0"><?php echo esc_html($meta_obj->get_post_meta_title( 'property_id' )); ?>:</div>
                <div class="value flex-grow-1"><?php echo trim($property_id); ?></div>
            </li>
        <?php } ?>
        <?php if ( $meta_obj->check_post_meta_exist('lot_area') && ($lot_area = $meta_obj->get_post_meta('lot_area')) ) { ?>
            <li class="d-flex align-items-center">
                <div class="text flex-shrink-0"><?php echo esc_html($meta_obj->get_post_meta_title( 'lot_area' )); ?>:</div>
                <div class="value flex-grow-1"><?php echo trim($lot_area); ?> <?php echo wp_realestate_get_option('measurement_unit_area'); ?></div>
            </li>
        <?php } ?>
        <?php if ( $meta_obj->check_post_meta_exist('home_area') && ($home_area = $meta_obj->get_post_meta('home_area')) ) { ?>
            <li class="d-flex align-items-center">
                <div class="text flex-shrink-0"><?php echo esc_html($meta_obj->get_post_meta_title( 'home_area' )); ?>:</div>
                <div class="value flex-grow-1"><?php echo trim($home_area); ?> <?php echo wp_realestate_get_option('measurement_unit_area'); ?></div>
            </li>
        <?php } ?>
        <?php if ( $meta_obj->check_post_meta_exist('lot_dimensions') && ($lot_dimensions = $meta_obj->get_post_meta('lot_dimensions')) ) { ?>
            <li class="d-flex align-items-center">
                <div class="text flex-shrink-0"><?php echo esc_html($meta_obj->get_post_meta_title( 'lot_dimensions' )); ?>:</div>
                <div class="value flex-grow-1"><?php echo trim($lot_dimensions); ?></div>
            </li>
        <?php } ?>
        <?php if ( $meta_obj->check_post_meta_exist('rooms') && ($rooms = $meta_obj->get_post_meta('rooms')) ) { ?>
            <li class="d-flex align-items-center">
                <div class="text flex-shrink-0"><?php echo esc_html($meta_obj->get_post_meta_title( 'rooms' )); ?>:</div>
                <div class="value flex-grow-1"><?php echo trim($rooms); ?></div>
            </li>
        <?php } ?>
        <?php if ( $meta_obj->check_post_meta_exist('beds') && ($beds = $meta_obj->get_post_meta('beds')) ) { ?>
            <li class="d-flex align-items-center">
                <div class="text flex-shrink-0"><?php echo esc_html($meta_obj->get_post_meta_title( 'beds' )); ?>:</div>
                <div class="value flex-grow-1"><?php echo trim($beds); ?></div>
            </li>
        <?php } ?>
        <?php if ( $meta_obj->check_post_meta_exist('baths') && ($baths = $meta_obj->get_post_meta('baths')) ) { ?>
            <li class="d-flex align-items-center">
                <div class="text flex-shrink-0"><?php echo esc_html($meta_obj->get_post_meta_title( 'baths' )); ?>:</div>
                <div class="value flex-grow-1"><?php echo trim($baths); ?></div>
            </li>
        <?php } ?>
        <!-- Add Living Spaces -->
        <?php if ( $meta_obj->check_custom_post_meta_exist('living-spaces') && ($living_spaces = $meta_obj->get_custom_post_meta('living-spaces')) ) { ?>
            <li class="d-flex align-items-center">
                <div class="text flex-shrink-0"><?php echo esc_html($meta_obj->get_custom_post_meta_title( 'living-spaces' )); ?>:</div>
                <div class="value flex-grow-1"><?php echo trim($living_spaces); ?></div>
            </li>
        <?php } ?>
        <?php if ( $meta_obj->check_post_meta_exist('garages') && ($garages = $meta_obj->get_post_meta('garages')) ) { ?>
            <li class="d-flex align-items-center">
                <div class="text flex-shrink-0"><?php echo esc_html($meta_obj->get_post_meta_title( 'garages' )); ?>:</div>
                <div class="value flex-grow-1"><?php echo trim($garages); ?></div>
            </li>
        <?php } ?>
        <!-- Add Storeys -->
        <?php if ( $meta_obj->check_custom_post_meta_exist('storeys') && ($storeys = $meta_obj->get_custom_post_meta('storeys')) ) { ?>
            <li class="d-flex align-items-center">
                <div class="text flex-shrink-0"><?php echo esc_html($meta_obj->get_custom_post_meta_title( 'storeys' )); ?>:</div>
                <div class="value flex-grow-1"><?php echo trim($storeys); ?></div>
            </li>
        <?php } ?>
        <!-- Add Study -->
        <?php if ( $meta_obj->check_custom_post_meta_exist('study') && ($study = $meta_obj->get_custom_post_meta('study')) ) { ?>
            <li class="d-flex align-items-center">
                <div class="text flex-shrink-0"><?php echo esc_html($meta_obj->get_custom_post_meta_title( 'study' )); ?>:</div>
                <div class="value flex-grow-1"><?php echo trim($study); ?></div>
            </li>
        <?php } ?>
        <!-- Add Alfresco -->
        <?php if ( $meta_obj->check_custom_post_meta_exist('alfresco') && ($alfresco = $meta_obj->get_custom_post_meta('alfresco')) ) { ?>
            <li class="d-flex align-items-center">
                <div class="text flex-shrink-0"><?php echo esc_html($meta_obj->get_custom_post_meta_title( 'alfresco' )); ?>:</div>
                <div class="value flex-grow-1"><?php echo trim($alfresco); ?></div>
            </li>
        <?php } ?>
        <!-- Add Dual Occupancy -->
        <?php if ( $meta_obj->check_custom_post_meta_exist('dual-occupancy') && ($dual_occupancy = $meta_obj->get_custom_post_meta('dual-occupancy')) ) { ?>
            <li class="d-flex align-items-center">
                <div class="text flex-shrink-0"><?php echo esc_html($meta_obj->get_custom_post_meta_title( 'dual-occupancy' )); ?>:</div>
                <div class="value flex-grow-1"><?php echo trim($dual_occupancy); ?></div>
            </li>
        <?php } ?>
        <!-- Add Min Block Width -->
        <?php if ( $meta_obj->check_custom_post_meta_exist('min-block-width') && ($min_block_width = $meta_obj->get_custom_post_meta('min-block-width')) ) { ?>
            <li class="d-flex align-items-center">
                <div class="text flex-shrink-0"><?php echo esc_html($meta_obj->get_custom_post_meta_title( 'min-block-width' )); ?>:</div>
                <div class="value flex-grow-1"><?php echo trim($min_block_width); ?> <?php echo wp_realestate_get_option('measurement_distance_unit'); ?></div>
            </li>
        <?php } ?>
        <!-- Add Min Block Length -->
        <?php if ( $meta_obj->check_custom_post_meta_exist('min-block-length') && ($min_block_length = $meta_obj->get_custom_post_meta('min-block-length')) ) { ?>
            <li class="d-flex align-items-center">
                <div class="text flex-shrink-0"><?php echo esc_html($meta_obj->get_custom_post_meta_title( 'min-block-length' )); ?>:</div>
                <div class="value flex-grow-1"><?php echo trim($min_block_length); ?> <?php echo wp_realestate_get_option('measurement_distance_unit'); ?></div>
            </li>
        <?php } ?>
        <!-- Remove Status (Theme Override) -->
        <!-- <?php if ( ($status = homez_property_display_status_label($post, false, false)) ) { ?>
            <li class="d-flex align-items-center">
                <div class="text flex-shrink-0"><?php echo esc_html($meta_obj->get_post_meta_title( 'status' )); ?>:</div>
                <div class="value flex-grow-1"><?php echo trim($status); ?></div>
            </li>
        <?php } ?> -->

        <!-- <?php do_action('wp-realestate-single-property-details', $post); ?> -->
    </ul>
</div>