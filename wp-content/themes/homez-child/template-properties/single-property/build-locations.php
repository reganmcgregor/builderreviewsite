<?php

if (!defined('ABSPATH')) {
	exit;
}
global $post;

$obj_property_meta = WP_RealEstate_Property_Meta::get_instance($post->ID);

$latitude = $obj_property_meta->get_post_meta('map_location_latitude');
$longitude = $obj_property_meta->get_post_meta('map_location_longitude');

$map_service = wp_realestate_get_option('map_service', 'mapbox');

$build_locations = get_the_terms($post->ID, 'property_location');

?>
<?php if (!empty($build_locations)) : ?>
	<div class="property-section">
		<h3 class="title"><?php esc_html_e('Build Locations', 'homez'); ?></h3>
		<ul class="list list-detail d-flex flex-wrap">
			<?php foreach ($build_locations as $build_location) : ?>
				<li class="d-flex align-items-center">
					<?php echo esc_html($build_location->name); ?>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
<?php endif; ?>