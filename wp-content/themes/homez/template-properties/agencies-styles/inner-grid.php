<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;
?>

<?php do_action( 'wp_realestate_before_agency_content', $post->ID ); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="agency-item position-relative">
        <?php homez_agency_display_nb_properties($post); ?>
        <?php if ( has_post_thumbnail() ) { ?>
            <div class="member-thumbnail-wrapper d-flex align-items-center justify-content-center">
                <?php homez_agency_display_image($post,'medium'); ?>
            </div>
        <?php } ?>
        <div class="agency-information <?php echo esc_attr( (!has_post_thumbnail())?'no-image':''); ?>">
            <?php homez_agency_display_rating_short( $post ); ?>
            <?php the_title( sprintf( '<h2 class="agency-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
            <?php homez_agency_display_full_location( $post ); ?>
            
            <div class="agency-information-bottom">
                <a href="<?php the_permalink(); ?>" class="btn btn-dark btn-outline w-100"><?php esc_html_e('View Profile', 'homez'); ?><i class="flaticon-up-right-arrow next"></i> </a>
            </div>
        </div>  
    </div>
</article><!-- #post-## -->

<?php do_action( 'wp_realestate_after_agency_content', $post->ID ); ?>