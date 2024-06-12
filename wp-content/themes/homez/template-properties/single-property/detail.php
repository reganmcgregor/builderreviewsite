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
        <?php if ( $meta_obj->check_post_meta_exist('garages') && ($garages = $meta_obj->get_post_meta('garages')) ) { ?>
            <li class="d-flex align-items-center">
                <div class="text flex-shrink-0"><?php echo esc_html($meta_obj->get_post_meta_title( 'garages' )); ?>:</div>
                <div class="value flex-grow-1"><?php echo trim($garages); ?></div>
            </li>
        <?php } ?>
        <?php if ( $meta_obj->check_post_meta_exist('price') && ($price = $meta_obj->get_price_html()) ) { ?>
            <li class="d-flex align-items-center">
                <div class="text flex-shrink-0"><?php echo esc_html($meta_obj->get_post_meta_title( 'price' )); ?>:</div>
                <div class="value flex-grow-1"><?php echo trim($price); ?></div>
            </li>
        <?php } ?>

        <?php if ( $meta_obj->check_post_meta_exist('year_built') && ($year_built = $meta_obj->get_post_meta('year_built')) ) { ?>
            <li class="d-flex align-items-center">
                <div class="text flex-shrink-0"><?php echo esc_html($meta_obj->get_post_meta_title( 'year_built' )); ?>:</div>
                <div class="value flex-grow-1"><?php echo trim($year_built); ?></div>
            </li>
        <?php } ?>

        <?php if ( ($status = homez_property_display_status_label($post, false, false)) ) { ?>
            <li class="d-flex align-items-center">
                <div class="text flex-shrink-0"><?php echo esc_html($meta_obj->get_post_meta_title( 'status' )); ?>:</div>
                <div class="value flex-grow-1"><?php echo trim($status); ?></div>
            </li>
        <?php } ?>

        <?php do_action('wp-realestate-single-property-details', $post); ?>
    </ul>
</div>