<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;

$meta_obj = WP_RealEstate_Property_Meta::get_instance($post->ID);
if ( $meta_obj->check_post_meta_exist('facades_group') && ($facades = $meta_obj->get_post_meta('facades_group')) ) {
?>
    <div class="property-detail-floor-plans">
        <h3 class="title"><?php esc_html_e('Facades', 'homez'); ?></h3>
        <div class="accordion" id="accordion-floor_plans">
        <?php $i = 1; foreach ($facades as $facade) { ?>
            <div class="accordion-item floor-item">
                <div class="accordion-header">
                    <a class="accordion-button <?php echo esc_attr($i == 1 ? '' : 'collapsed'); ?>" data-bs-toggle="collapse" data-bs-target="#collapse-floor_plan<?php echo esc_attr($i); ?>" href="#collapse-floor_plan<?php echo esc_attr($i); ?>">
                        <div class="w-100 d-md-flex align-items-center">
                            <?php if ( !empty($facade['name']) ) { ?>
                            <h3><?php echo trim($facade['name']); ?></h3>
                            <?php } ?>

                            <div class="metas ms-auto d-flex align-items-center justify-content-end">
                                <?php if ( !empty($facade['price_prefix']) ) { ?>
                                    <div class="rooms"><?php echo ($facade['price_prefix']); ?></div>
                                <?php } ?>
                                <?php if ( !empty($facade['price']) ) { ?>
                                    <div class="baths"><?php echo ($facade['price']); ?></div>
                                <?php } ?>
                                <?php if ( !empty($facade['price_suffix']) ) { ?>
                                    <div class="size"><?php echo ($facade['price_suffix']); ?></div>
                                <?php } ?>
                            </div>
                        </div>
                    </a>
                </div>
                <div id="collapse-floor_plan<?php echo esc_attr($i); ?>" class="accordion-collapse collapse <?php echo esc_attr($i == 1 ? 'show' : ''); ?>">
                    <?php if ( !empty($facade['image_id']) || !empty($facade['content']) ) { ?>
                        <div class="content-accordion">
                            <?php if ( !empty($facade['image_id']) ) { ?>
                                <div class="image">
                                    <a href="<?php echo esc_url($facade['image']); ?>">
                                        <?php echo wp_get_attachment_image($facade['image_id'], 'large'); ?>
                                    </a>
                                </div>
                            <?php } ?>
                            <?php if ( !empty($facade['content']) ) { ?>
                                <div class="content"><?php echo trim($facade['content']); ?></div>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
            </div>

        <?php $i++; } ?>
        </div>

        <?php do_action('wp-realestate-single-property-facades', $post); ?>
    </div>
<?php }