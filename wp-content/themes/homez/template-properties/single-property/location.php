<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;

$obj_property_meta = WP_RealEstate_Property_Meta::get_instance($post->ID);

$latitude = $obj_property_meta->get_post_meta( 'map_location_latitude' );
$longitude = $obj_property_meta->get_post_meta( 'map_location_longitude' );

$map_service = wp_realestate_get_option('map_service', 'mapbox');

?>
<?php if ( !empty($latitude) && !empty($longitude) ) : ?>
	<div class="property-detail-map-street">
		<div class="widget-title-wrapper d-md-flex align-items-center">
    		<h3 class="title"><?php esc_html_e('Location', 'homez'); ?></h3>
    		<div class="ms-auto">
    			<?php homez_property_display_full_location($post, false, true); ?>
    		</div>
    	</div>

    	<div class="single-property-google-maps-wrapper">
		    <div id="single-property-google-maps" class="single-property-map"></div>
		    <?php if ( $map_service == 'google-map' ) { ?>
                <div id="single-property-street-view-map"></div>
                <a href="#maps-street" class="btn location-street-view"><?php esc_html_e('Street View', 'homez'); ?></a>
	        <?php } ?>
			<a href="#maps" class="btn location-map-view hidden"><?php esc_html_e('Map View', 'homez'); ?></a>
		</div>
	</div>
<?php endif; ?>