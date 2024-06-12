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

if ( empty($tax_query) ) {
    return;
}
$args = array(
    'post_type' => 'property',
    'posts_per_page' => $relate_count,
    'post__not_in' => array( $post->ID ),
    'tax_query' => array_merge(array( 'relation' => 'AND' ), $tax_query)
);
$relates = new WP_Query( $args );
if( $relates->have_posts() ):
?>
    <div class="wrapper-posts-related">
        <div class="container">
            <div class="related-posts related-properties">
                <h4 class="title">
                    <?php esc_html_e( 'Related Properties', 'homez' ); ?>
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