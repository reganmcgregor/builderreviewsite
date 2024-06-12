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

$loop = WP_RealEstate_Query::get_agency_agents($post->ID, array(
    'post_per_page' => get_option('posts_per_page'),
    'paged' => $paged
));

if ( !empty($loop) && $loop->have_posts() ) {
?>
    <div class="agency-detail-agents">
        <h3 class="widget-title"><?php esc_html_e('Agents', 'homez'); ?></h3>
        <div class="row">
            <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
                <div class="col-6 col-sm-6 col-md-4">
                    <?php echo WP_RealEstate_Template_Loader::get_template_part( 'agents-styles/inner-grid' ); ?>
                </div>
            <?php endwhile; ?>
        </div>

        <?php
        wp_reset_postdata();
        if ( $loop->max_num_pages > 1 ) {
        ?>
            <div class="ajax-agents-pagination">
                <a href="#" class="apus-loadmore-btn" data-paged="<?php echo esc_attr($paged + 1); ?>" data-post_id="<?php echo esc_attr($post->ID); ?>"><?php esc_html_e( 'Load more', 'homez' ); ?></a>
                <span class="apus-allproducts"><?php esc_html_e( 'All agents loaded.', 'homez' ); ?></span>
            </div>
        <?php } ?>
        
    </div>
<?php } else {
    ?>
    <div class="agency-detail-agents hidden">
        <?php esc_html_e('No agents found', 'homez'); ?>
    </div>
    <?php
}