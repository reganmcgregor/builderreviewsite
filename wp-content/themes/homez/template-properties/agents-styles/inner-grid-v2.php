<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post;

?>

<?php do_action( 'wp_realestate_before_agent_content', $post->ID ); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="agent-grid agent-item v2">
        <div class="top-info position-relative d-flex align-items-center justify-content-center">
            <?php homez_agent_display_image( $post, '210x210'); ?>
        </div>
        <div class="agent-information-bottom text-center">
            <?php the_title( sprintf( '<h2 class="agent-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
            <?php homez_agent_display_job( $post ); ?>
        </div>
    </div>
</article><!-- #post-## -->

<?php do_action( 'wp_realestate_after_agent_content', $post->ID ); ?>