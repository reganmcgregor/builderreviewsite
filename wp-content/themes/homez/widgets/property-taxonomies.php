<?php
extract( $args );

extract( $args );
extract( $instance );

echo trim($before_widget);
$title = apply_filters('widget_title', $instance['title']);
if ( $title ) {
    echo trim($before_title)  . trim( $title ) . $after_title;
}

global $wp_query, $post;

$current_cat   = false;
$cat_ancestors = array();

if ( is_tax( $taxonomy ) ) {
    $current_cat   = $wp_query->queried_object;
    $cat_ancestors = get_ancestors( $current_cat->term_id, 'product_cat' );

}

$list_args = array(
    'show_count'   => $show_count,
    'hierarchical' => $show_hierarchy,
    'taxonomy'     => $taxonomy,
    'hide_empty'   => $hide_empty,
);
$max_depth          = absint( $max_depth );

$list_args['menu_order'] = false;
$list_args['depth']      = $max_depth;

if ( 'menu_order' === $orderby ) {
    $list_args['orderby']      = 'meta_value_num';
    $list_args['meta_key']     = 'order';
}

include_once get_template_directory() . '/inc/vendors/wp-realestate/class-property-tax-list-walker.php';

$list_args['walker']                     = new Homez_Property_Tax_List_Walker();
$list_args['title_li']                   = '';
$list_args['pad_counts']                 = 1;
$list_args['show_option_none']           = esc_html__( 'No product categories exist.', 'homez' );
$list_args['current_category']           = ( $current_cat ) ? $current_cat->term_id : '';
$list_args['current_category_ancestors'] = $cat_ancestors;
$list_args['max_depth']                  = $max_depth;

?>
<div class="widget_categories">
	<ul class="properties-taxonomy">
	<?php wp_list_categories( $list_args ); ?>
	</ul>
</div>
<?php
echo trim($after_widget);