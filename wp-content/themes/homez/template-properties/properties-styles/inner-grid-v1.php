<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;
?>

<?php do_action( 'wp_realestate_before_property_content', $post->ID ); ?>

<article <?php post_class('map-item property-grid v1 property-item'); ?> <?php homez_property_item_map_meta($post); ?> <?php homez_property_display_gallery($post, 'homez-property-grid'); ?>>

    <div class="property-thumbnail-wrapper">
            <?php homez_property_display_image( $post, 'homez-property-grid' ); ?>
            <?php
                $featured = homez_property_display_featured_icon($post, false);
                $labels = homez_property_display_label($post, false);
                if ( $featured || $labels ) {
                    ?>
                    <div class="top-label d-flex align-items-center">
                        <?php if ( $featured ) { ?>
                            <?php echo trim($featured); ?>
                        <?php } ?>
                        <?php if ( $labels ) { ?>
                            <?php echo trim($labels); ?>
                        <?php } ?>
                    </div>
                    <?php
                }
            ?>
            <div class="bottom-label">
                <?php homez_property_display_price($post, 'no-icon-title', true); ?>
            </div>
        </div>

    <div class="top-info">
        <div class="property-information">
            <?php the_title( sprintf( '<h2 class="property-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
            <?php homez_property_display_full_location($post, 'no-icon'); ?>

            <?php
            $meta_obj = WP_RealEstate_Property_Meta::get_instance($post->ID);

            $beds = homez_property_display_meta($post, 'beds', 'flaticon-bed', false, $meta_obj->get_post_meta_title( 'beds' ));
            $baths = homez_property_display_meta($post, 'baths', 'flaticon-shower', false, $meta_obj->get_post_meta_title( 'baths' ));

            $suffix = wp_realestate_get_option('measurement_unit_area');
            $lot_area = homez_property_display_meta($post, 'lot_area', 'flaticon-expand', false, $suffix);

            if ( $lot_area || $beds || $baths || $garages ) {
            ?>
                <div class="property-metas d-flex flex-wrap">
                    <?php
                        echo trim($beds);
                        echo trim($baths);
                        echo trim($lot_area);
                    ?>
                </div>
            <?php } ?>
        </div>
    
    
        <div class="property-metas-bottom d-flex align-items-center">
            <div class="ali-left">
                <?php homez_property_display_status_label($post, true); ?>
            </div>
            <div class="ms-auto action-item d-flex align-items-center">
                <a href="<?php the_permalink(); ?>" class="btn-permalink" data-toggle="tooltip" data-original-title="<?php esc_html_e('View','homez') ?>"><i class="flaticon-fullscreen"></i></a>
                <?php
                    if ( homez_get_config('listing_enable_favorite', true) ) {
                        $args = array(
                            'added_icon_class' => 'flaticon-like',
                            'add_icon_class' => 'flaticon-like',
                        );
                        WP_RealEstate_Favorite::display_favorite_btn($post->ID, $args);
                    }
                    if ( homez_get_config('listing_enable_compare', true) ) {
                        $args = array(
                            'added_icon_class' => 'flaticon-new-tab',
                            'add_icon_class' => 'flaticon-new-tab',
                        );
                        WP_RealEstate_Compare::display_compare_btn($post->ID, $args);
                    }
                ?>
            </div>
        </div>
    </div>
</article><!-- #post-## -->

<?php do_action( 'wp_realestate_after_property_content', $post->ID ); ?>