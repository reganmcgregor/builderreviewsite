<?php

if (!defined('ABSPATH')) {
    exit;
}
global $post;

$meta_obj = WP_RealEstate_Property_Meta::get_instance($post->ID);
if ($meta_obj->check_post_meta_exist('facades_group') && ($facades = $meta_obj->get_post_meta('facades_group'))) {
?>
    <!-- <h3 class="title">
        <?php // esc_html_e('Facades', 'homez'); ?>
    </h3> -->
    <style type="text/css">
        .slick-carousel .slick-dots {
            padding: 0;
        }
    </style>
    <div class="slick-carousel" data-carousel="slick" data-items="1" data-large="1" data-medium="1" data-small="1" data-smallest="1" data-slidestoscroll="1" data-slidestoscroll_large="1" data-slidestoscroll_medium="1" data-slidestoscroll_small="1" data-slidestoscroll_smallest="1" data-pagination="true" data-nav="true" data-infinite="true" style="padding: 0; background: transparent; border:0; box-shadow: unset;">
        <?php $i = 1;
        foreach ($facades as $facade) { ?>
            <article <?php post_class('map-item property-grid property-item'); ?> style="padding: 0;">
                <div class="property-thumbnail-wrapper">
                    <?php if (!empty($facade['image_id'])) { ?>
                        <div class="image-thumbnail">
                            <a class="property-image" href="<?php echo esc_url($facade['image']); ?>" data-elementor-lightbox-slideshow="facade-gallery-image" data-elementor-lightbox-title="<?php echo trim($facade['name']); ?> Facade" tabindex="-1">
                                <div class="image-wrapper">
                                    <?php echo wp_get_attachment_image($facade['image_id'], [800, 450], true , array( "alt" => trim($facade['name'])." Facacde" )); ?>
                                </div>
                            </a>
                        </div>
                    <?php } ?>
                    <div class="bottom-label">
                        <?php if (!empty($facade['price_custom'])) { ?>
                            <div class="property-price">
                                <span class="price-text"><?php echo ($facade['price_custom']); ?></span>
                            </div>
                        <?php } elseif (!empty($facade['price'])) { ?>
                            <div class="property-price">
                                <?php if (!empty($facade['price_prefix'])) { ?> <span class="prefix-text additional-text"><?php echo ($facade['price_prefix']); ?></span><?php } ?><?php if (!empty($facade['price'])) { ?><?php echo WP_RealEstate_Price::format_price($facade['price']); ?><?php } ?><?php if (!empty($facade['price_suffix'])) { ?><span class="suffix-text additional-text"><?php echo ($facade['price_suffix']); ?></span><?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="action-item d-flex align-items-center">
                        <a href="<?php echo esc_url($facade['image']); ?>" class="btn-permalink" data-elementor-lightbox-slideshow="facade-gallery" data-toggle="tooltip" data-original-title="View Facade" title="View All Facades" data-elementor-lightbox-title="<?php echo trim($facade['name']); ?> Facade" tabindex="0"><i class="ti-fullscreen"></i></a>
                    </div>
                </div>
                <div class="top-info" style="padding: 20px;">
                    <div class="property-information">
                        <?php if (!empty($facade['name'])) { ?>
                                <h4 class="property-title">
                                    <a href="<?php echo esc_url($facade['image']); ?>" data-elementor-lightbox-slideshow="facade-gallery-title" data-elementor-lightbox-title="<?php echo trim($facade['name']); ?> Facade" rel="bookmark">
                                        <?php echo trim($facade['name']); ?> Facade
                                    </a>
                                </h4>
                            <?php } ?>
                    </div>
                </div>
            </article>
        <?php $i++;
        } ?>
    </div>
<?php }
