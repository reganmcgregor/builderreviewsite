<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;

$related_columns = homez_get_config('property_related_columns', 3);

$relate_count = apply_filters('wp_realestate_number_property_related', homez_get_config('property_related_number', 3));

$tax_query = array();
$terms = WP_RealEstate_Property::get_property_taxs( $post->ID, 'property_type' );
if ($terms) {
    $termids = array();
    foreach($terms as $term) {
        $termids[] = $term->term_id;
    }
    $tax_query[] = array(
        'taxonomy' => 'property_type',
        'field' => 'id',
        'terms' => $termids,
        'operator' => 'IN'
    );
}

$terms = WP_RealEstate_Property::get_property_taxs( $post->ID, 'property_status' );
if ($terms) {
    $termids = array();
    foreach($terms as $term) {
        $termids[] = $term->term_id;
    }
    $tax_query[] = array(
        'taxonomy' => 'property_status',
        'field' => 'id',
        'terms' => $termids,
        'operator' => 'IN'
    );
}

$author_id = $post->post_author;

if ( WP_RealEstate_User::is_agency($author_id) ) {
    $agency_id = WP_RealEstate_User::get_agency_by_user_id($author_id);
    $agency_post = get_post($agency_id);

    $a_title = get_the_title($agency_id);
    $a_title_html = '<a href="'.get_permalink($agency_id).'">'.get_the_title($agency_id).'</a>';

}

if ( empty($tax_query) ) {
    return;
}
$args = array(
    'post_type' => 'property',
    'posts_per_page' => $relate_count,
    'post__not_in' => array( $post->ID ),
    'tax_query' => array_merge(array( 'relation' => 'AND' ), $tax_query),
    'author' => $author_id
);
$relates = new WP_Query( $args );
if( $relates->have_posts() && WP_RealEstate_User::is_agency($author_id) ):
?>
    <div class="wrapper-posts-related">
        <div class="container">
            <div class="related-posts related-properties">
                <h4 class="title">
                    Similar <?php homez_property_display_type_name($post, true) ?> From <?php echo $a_title_html ?>
                </h4>
                <div class="widget-content">
                    <div class="slick-carousel" data-carousel="slick" data-large="2" data-medium="2" data-small="2" data-smallest="1" data-items="<?php echo esc_attr($related_columns); ?>" data-pagination="false" data-nav="true">
                        <?php while ( $relates->have_posts() ) : $relates->the_post(); ?>
                            <div class="item">
                                <?php echo WP_RealEstate_Template_Loader::get_template_part( 'properties-styles/inner-grid' ); ?>
                            </div>
                        <?php endwhile;
                    ?>
                    </div>
                    <?php wp_reset_postdata(); ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>