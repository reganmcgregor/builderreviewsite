<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post;

?>

<?php do_action( 'wp_realestate_before_agent_content', $post->ID ); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="agent-grid agent-item">
        <div class="top-info position-relative">
            <?php homez_agent_display_image( $post, 'homez-agent-grid'); ?>
            <?php homez_agent_display_nb_properties( $post ); ?>
        </div>
        <div class="agent-information-bottom">
            <?php the_title( sprintf( '<h2 class="agent-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
            <?php homez_agent_display_job( $post ); ?>
        </div>
    </div>
</article><!-- #post-## -->

<?php do_action( 'wp_realestate_after_agent_content', $post->ID ); ?>