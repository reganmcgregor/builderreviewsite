<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;

$meta_obj = WP_RealEstate_Property_Meta::get_instance($post->ID);

$beds = homez_property_display_meta($post, 'beds', 'flaticon-bed', false);
$baths = homez_property_display_meta($post, 'baths', 'flaticon-shower', false);
$lot_area = homez_property_display_meta($post, 'lot_area', 'flaticon-expand', false);
?>
<article <?php post_class('property-list-simple property-item'); ?>>
    <div class="d-flex align-items-center">
        <?php if ( has_post_thumbnail() ) { ?>
            <div class="property-thumbnail-wrapper flex-shrink-0">
                <?php homez_property_display_image( $post, 'thumbnail' ); ?>
            </div>
        <?php } ?>
        <div class="property-information flex-grow-1">
            <?php homez_property_display_price($post, 'no-icon-title', true); ?>
            <?php the_title( sprintf( '<h2 class="property-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
            <div class="property-metas d-flex flex-wrap">
                <?php 
                    echo trim($beds);
                    echo trim($baths);
                    echo trim($lot_area);
                ?>
            </div>
        </div>
    </div>
</article>