<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;
$meta_obj = WP_RealEstate_Property_Meta::get_instance($post->ID);
?>
<div class="property-detail-detail">
    <h3 class="title"><?php esc_html_e('Details', 'homez'); ?></h3>
    <ul class="list list-overview d-flex flex-wrap">
       
        <?php if ( $meta_obj->check_post_meta_exist('beds') && ($beds = $meta_obj->get_post_meta('beds')) ) { ?>
            <li class="d-flex align-items-center">
                <div class="icon flex-shrink-0 d-flex align-items-center justify-content-center">
                    <i class="flaticon-bed"></i>
                </div>
                <div class="details flex-grow-1">
                    <div class="text"><?php echo esc_html($meta_obj->get_post_meta_title( 'beds' )); ?></div>
                    <div class="value"><?php echo trim($beds); ?></div>
                </div>
            </li>
        <?php } ?>
        <?php if ( $meta_obj->check_post_meta_exist('baths') && ($baths = $meta_obj->get_post_meta('baths')) ) { ?>
            <li class="d-flex align-items-center">
                <div class="icon flex-shrink-0 d-flex align-items-center justify-content-center">
                    <i class="flaticon-shower"></i>
                </div>
                <div class="details flex-grow-1">
                    <div class="text"><?php echo esc_html($meta_obj->get_post_meta_title( 'baths' )); ?></div>
                    <div class="value"><?php echo trim($baths); ?></div>
                </div>
            </li>
        <?php } ?>
        <?php if ( $meta_obj->check_post_meta_exist('year_built') && ($year_built = $meta_obj->get_post_meta('year_built')) ) { ?>
            <li class="d-flex align-items-center">
                <div class="icon flex-shrink-0 d-flex align-items-center justify-content-center">
                    <i class="flaticon-event"></i>
                </div>
                <div class="details flex-grow-1">
                    <div class="text"><?php echo esc_html($meta_obj->get_post_meta_title( 'year_built' )); ?></div>
                    <div class="value"><?php echo trim($year_built); ?></div>
                </div>
            </li>
        <?php } ?>
        <?php if ( $meta_obj->check_post_meta_exist('garages') && ($garages = $meta_obj->get_post_meta('garages')) ) { ?>
            <li class="d-flex align-items-center">
                <div class="icon flex-shrink-0 d-flex align-items-center justify-content-center">
                    <i class="flaticon-garage"></i>
                </div>
                <div class="details flex-grow-1">
                    <div class="text"><?php echo esc_html($meta_obj->get_post_meta_title( 'garages' )); ?></div>
                    <div class="value"><?php echo trim($garages); ?></div>
                </div>
            </li>
        <?php } ?>
        <?php if ( $meta_obj->check_post_meta_exist('lot_area') && ($lot_area = $meta_obj->get_post_meta('lot_area')) ) { ?>
            <li class="d-flex align-items-center">
                <div class="icon flex-shrink-0 d-flex align-items-center justify-content-center">
                    <i class="flaticon-expand"></i>
                </div>
                <div class="details flex-grow-1">
                    <div class="text"><?php echo esc_html($meta_obj->get_post_meta_title( 'lot_area' )); ?></div>
                    <div class="value"><?php echo trim($lot_area); ?> <?php echo wp_realestate_get_option('measurement_unit_area'); ?></div>
                </div>
            </li>
        <?php } ?>
        

        <?php if ( ($type = homez_property_display_type($post, false, false)) ) { ?>
            <li class="d-flex align-items-center">
                <div class="icon flex-shrink-0 d-flex align-items-center justify-content-center">
                    <i class="flaticon-home"></i>
                </div>
                <div class="details flex-grow-1">
                    <div class="text"><?php echo esc_html($meta_obj->get_post_meta_title( 'type' )); ?></div>
                    <div class="value"><?php echo trim($type); ?></div>
                </div>
            </li>
        <?php } ?>

        <?php do_action('wp-realestate-single-property-overview', $post); ?>
    </ul>
</div>