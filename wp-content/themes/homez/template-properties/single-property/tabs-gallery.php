<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;

$obj_property_meta = WP_RealEstate_Property_Meta::get_instance($post->ID);

$gallery = $obj_property_meta->get_post_meta( 'gallery' );
$latitude = $obj_property_meta->get_post_meta( 'map_location_latitude' );
$longitude = $obj_property_meta->get_post_meta( 'map_location_longitude' );

$active = homez_get_config('property_header_active_tab', 'gallery');
$map_service = wp_realestate_get_option('map_service', 'mapbox');

if ( has_post_thumbnail() || !empty( $gallery ) || (!empty($latitude) && !empty($longitude)) ) {
?>
    <div class="tabs-gallery-map">
        <div class="container">
            <div class="position-relative">
                <ul class="nav nav-tabs nav-table">
                    <?php if ( has_post_thumbnail() || !empty( $gallery ) ) : ?>
                        <li>
                            <a href="#tab-gallery-map-gallery" data-bs-toggle="tab" class="<?php echo esc_attr($active == 'gallery' ? 'active' : ''); ?>">
                                <i class="flaticon-images"></i>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if ( !empty($latitude) && !empty($longitude) ) : ?>
                        <li>
                            <a class="tab-google-map <?php echo esc_attr($active == 'map' || ( !has_post_thumbnail() && empty($gallery) && $active == 'gallery' ) ? 'active' : ''); ?>" href="#tab-gallery-map-map" data-bs-toggle="tab">
                                <i class="flaticon-map"></i>
                            </a>
                        </li>
                        <?php if ( $map_service == 'google-map' ) { ?>
                            <li>
                                <a class="tab-google-street-view-map <?php echo esc_attr($active == 'mapview' ? 'active' : ''); ?>" href="#tab-gallery-map-mapview" data-bs-toggle="tab">
                                    <i class="flaticon-maps-1"></i>
                                </a>
                            </li>
                        <?php } ?>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
        <div class="tab-content tab-content-descrip">

            <?php if ( has_post_thumbnail() || !empty( $gallery ) ) : ?>
                <div id="tab-gallery-map-gallery" class="tab-pane fade <?php echo esc_attr($active == 'gallery' ? 'show active' : ''); ?>">
                    <?php
                    $args = array();
                    if ( !empty($gallery_size) ) {
                        $args = array('gallery_size' => $gallery_size);
                    }
                    echo WP_RealEstate_Template_Loader::get_template_part('single-property/gallery-v4', $args);
                    ?>
                </div>
            <?php endif; ?>

            <?php if ( !empty($latitude) && !empty($longitude) ) : ?>
                <div id="tab-gallery-map-map" class="tab-pane fade <?php echo esc_attr($active == 'map' || ( empty($gallery) && $active == 'gallery' ) ? 'active' : ''); ?>">
                    <div id="properties-google-maps" class="single-property-map"></div>
                </div>
                <?php if ( $map_service == 'google-map' ) { ?>
                    <div id="tab-gallery-map-mapview" class="tab-pane fade <?php echo esc_attr($active == 'mapview' ? 'active' : ''); ?>">
                        <div id="single-tab-property-street-view-map"></div>
                    </div>
                <?php } ?>
            <?php endif; ?>

        </div>
    </div>
<?php } ?>