<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;
$subproperties_columns = homez_get_config('property_subproperties_number',4);

$args = array(
    'post_per_page' => -1,
    'meta_query' => array(
        array(
            'key'       => WP_REALESTATE_PROPERTY_PREFIX . 'parent_property',
            'value'     => $post->ID,
            'compare'   => '==',
        )
    )
);
$loop = WP_RealEstate_Query::get_posts($args);
if ( $loop->have_posts() ) {
?>
<div class="wrapper-posts-related subproperties">
    <div class="container">
        <div class="related-posts property-subproperties">
            <h3 class="title"><?php esc_html_e('Subproperties', 'homez'); ?></h3>
            <div class="widget-content">
                <div class="slick-carousel" data-carousel="slick" data-smallmedium="2" data-extrasmall="1" data-items="<?php echo esc_attr($subproperties_columns); ?>" data-pagination="false" data-nav="true">
                    <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
                        <div class="item">
                            <?php echo WP_RealEstate_Template_Loader::get_template_part( 'properties-styles/inner-grid' ); ?>
                        </div>
                    <?php endwhile; ?>
                </div>
                <?php wp_reset_postdata(); ?>
            </div>
        </div>
    </div>
</div>
<?php }