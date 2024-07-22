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

function print_taxonomy_with_parent($terms){

    if ( ! is_array( $terms ) || empty( $terms ) ) {
        return false;
    }

    $parent_terms = array();

    // get only parents
    foreach ( $terms as $term ) {
        if ($term->parent === 0) {
            $term->child = Array();
            $parent_terms[] = $term;
        }
    }

    // compare and nested
    foreach ( $terms as $term ) {
        if ($term->parent != 0) {
            foreach ($parent_terms as $key => $value) {
                if ($term->parent === $value->term_id) {
                    $parent_terms[$key]->child[] = $term;
                }
            }
        }
    }

    // output results
    foreach ( $parent_terms as $term ) {

        //parent term
		echo '<ul class="list list-detail d-flex flex-wrap">';
        echo '<li class="d-flex align-items-center" style="width: 100%;"><div class="text">'.$term->name.'</div>';

        if ($term->child) {
            foreach ( $term->child as $child ) {
                echo '<li class="d-flex align-items-center text">'.$child->name.'</li>';                
            }          
        }
		echo '</li>';
        echo '</ul>';
    }
}
?>
<?php if (!empty($build_locations)) : ?>
	<div class="property-section">
		<h3 class="title"><?php esc_html_e('Build Locations', 'homez'); ?></h3>
		<?php print_taxonomy_with_parent($build_locations); ?>
	</div>
<?php endif; ?>