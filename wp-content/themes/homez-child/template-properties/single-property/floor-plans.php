<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;

$meta_obj = WP_RealEstate_Property_Meta::get_instance($post->ID);
if ( $meta_obj->check_post_meta_exist('floor_plans_group') && ($floor_plans = $meta_obj->get_post_meta('floor_plans_group')) ) {
?>
    <div class="property-detail-floor-plans">
        <h3 class="title"><?php esc_html_e('Floor Plans', 'homez'); ?></h3>
        <div class="accordion" id="accordion-floor_plans">
        <?php $i = 1; foreach ($floor_plans as $floor_plan) { ?>
            <div class="accordion-item floor-item">
                <div class="accordion-header">
                    <a class="accordion-button <?php echo esc_attr($i == 1 ? '' : 'collapsed'); ?>" data-bs-toggle="collapse" data-bs-target="#collapse-floor_plan<?php echo esc_attr($i); ?>" href="#collapse-floor_plan<?php echo esc_attr($i); ?>">
                        <div class="w-100 d-md-flex align-items-center">
                            <?php if ( !empty($floor_plan['name']) ) { ?>
                            <h3><?php echo trim($floor_plan['name']); ?></h3>
                            <?php } ?>

                            <div class="metas ms-auto d-flex align-items-center justify-content-end">
                                <?php if ( !empty($floor_plan['rooms']) ) { ?>
                                    <div class="rooms"><span class="subtitle"><?php esc_html_e('Rooms:', 'homez'); ?></span> <?php echo trim($floor_plan['rooms']); ?></div>
                                <?php } ?>
                                <?php if ( !empty($floor_plan['baths']) ) { ?>
                                    <div class="baths"><span class="subtitle"><?php esc_html_e('Baths:', 'homez'); ?></span> <?php echo trim($floor_plan['baths']); ?></div>
                                <?php } ?>
                                <?php if ( !empty($floor_plan['size']) ) { ?>
                                    <div class="size"><span class="subtitle"><?php esc_html_e('Size:', 'homez'); ?></span> <?php echo trim($floor_plan['size']); ?></div>
                                <?php } ?>
                            </div>
                        </div>
                    </a>
                </div>
                <div id="collapse-floor_plan<?php echo esc_attr($i); ?>" class="accordion-collapse collapse <?php echo esc_attr($i == 1 ? 'show' : ''); ?>">
                    <?php if ( !empty($floor_plan['image_id']) || !empty($floor_plan['content']) ) { ?>
                        <div class="content-accordion">
                            <?php if ( !empty($floor_plan['image_id']) ) { ?>
                                <div class="image">
                                    <a href="<?php echo esc_url($floor_plan['image']); ?>">
                                        <?php echo wp_get_attachment_image($floor_plan['image_id'], 'large'); ?>
                                    </a>
                                </div>
                            <?php } ?>
                            <?php if ( !empty($floor_plan['content']) ) { ?>
                                <div class="content"><?php echo trim($floor_plan['content']); ?></div>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
            </div>

        <?php $i++; } ?>
        </div>

        <?php do_action('wp-realestate-single-property-floor-plans', $post); ?>
    </div>
<?php }