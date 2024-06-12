<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;

if ( get_query_var( 'paged' ) ) {
    $paged = get_query_var( 'paged' );
} elseif ( get_query_var( 'page' ) ) {
    $paged = get_query_var( 'page' );
} else {
    $paged = 1;
}

$user_ids = array(0);
$user_id = WP_RealEstate_User::get_user_by_agency_id($post->ID);
if ( $user_id ) {
    $user_ids[] = $user_id;
}

$number = homez_get_config('agency_property_per_page', 3);
$columns = homez_get_config('agency_property_columns', 3);
$bcol = 12/$columns;

$query_args = array(
    'post_type'         => 'property',
    'posts_per_page'    => $number,
    'paged'             => $paged,
    'orderby' => array(
        'menu_order' => 'ASC',
        'date'       => 'DESC',
        'ID'         => 'DESC',
    ),
    'order'             => 'DESC',
    'author__in'        => $user_ids
);

$loop = new WP_Query( $query_args );

if ( !empty($loop) && $loop->have_posts() ) {
?>
    <div class="agent-detail-properties agent-agency-detail-properties">
        <h3 class="widget-title"><?php esc_html_e('My Properties', 'homez'); ?></h3>
        <div class="row">
            <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
                <div class="col-12 col-sm-6 col-xl-<?php echo esc_attr($bcol); ?>">
                    <?php echo WP_RealEstate_Template_Loader::get_template_part( 'properties-styles/inner-grid-v1' ); ?>
                </div>
            <?php endwhile; ?>
        </div>
        <?php
        wp_reset_postdata();
        if ( $loop->max_num_pages > 1 ) {
        ?>
            <div class="ajax-properties-pagination">
                <a href="#" class="apus-loadmore-btn" data-paged="<?php echo esc_attr($paged + 1); ?>" data-post_id="<?php echo esc_attr($post->ID); ?>" data-type="agency"><?php esc_html_e( 'Load more', 'homez' ); ?></a>
                <span class="apus-allproducts"><?php esc_html_e( 'All properties loaded.', 'homez' ); ?></span>
            </div>
        <?php } ?>
    </div>
<?php } else { ?>
    <div class="agent-detail-properties hidden">
        <?php esc_html_e('No properties found', 'homez'); ?>
    </div>
    <?php
}