<?php
    $relate_count = homez_get_config('number_blog_related', 3);
    $relate_columns = homez_get_config('related_blog_columns', 3);
    $terms = get_the_terms( get_the_ID(), 'category' );
    $termids =array();

    if ($terms) {
        foreach($terms as $term) {
            $termids[] = $term->term_id;
        }
    }

    $args = array(
        'post_type' => 'post',
        'posts_per_page' => $relate_count,
        'post__not_in' => array( get_the_ID() ),
        'tax_query' => array(
            'relation' => 'AND',
            array(
                'taxonomy' => 'category',
                'field' => 'id',
                'terms' => $termids,
                'operator' => 'IN'
            )
        )
    );
    $relates = new WP_Query( $args );
    if( $relates->have_posts() ):
?>
<div class="wrapper-posts-related">
    <div class="<?php echo apply_filters( 'homez_blog_content_class', 'container' ); ?>">
        <div class="related-posts">
            <h4 class="title text-center">
                <?php esc_html_e( 'Related Posts', 'homez' ); ?>
            </h4>
            <div class="related-posts-content  widget-content">
                <div class="slick-carousel" data-carousel="slick" data-large="3" data-medium="2" data-small="2" data-smallest="1" data-items="<?php echo esc_attr($relate_columns); ?>" data-pagination="false" data-nav="true">
                    <?php while ( $relates->have_posts() ) : $relates->the_post(); ?>
                        <div class="item">
                            <?php get_template_part( 'template-posts/loop/inner-grid' ); ?>
                        </div>
                    <?php endwhile; ?>
                    <?php wp_reset_postdata(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>