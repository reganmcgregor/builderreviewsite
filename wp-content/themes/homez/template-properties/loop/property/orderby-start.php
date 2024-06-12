<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$classes = '';
$layout_type = homez_get_properties_layout_type();
$layout_sidebar = homez_get_properties_layout_sidebar();
$filter_sidebar = homez_get_properties_filter_sidebar();
if (($layout_type == 'half-map-v3' || ($layout_type == 'default' && $layout_sidebar == 'main' && homez_get_properties_show_offcanvas_filter() ) || ($layout_type == 'top-map' && $layout_sidebar == 'main' && homez_get_properties_show_offcanvas_filter())) && is_active_sidebar( $filter_sidebar ) ) {
	$classes = 'has-filter-btn';
}
?>
<div class="properties-ordering-wrapper <?php echo esc_attr($classes); ?>">
