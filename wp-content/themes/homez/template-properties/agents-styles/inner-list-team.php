<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post;

?>

<?php do_action( 'wp_realestate_before_agent_content', $post->ID ); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class('agent-team'); ?>>
    <div class="d-flex align-items-center">
    	<?php if ( has_post_thumbnail() ) { ?>
            <div class="agent-thumbnail">
                <?php
                homez_agent_display_image( $post, 'thumbnail' );
                ?>
            </div>
        <?php } ?>
        <div class="right-inner d-flex align-items-center">
            <div class="agent-information">
            	
        		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

                <?php homez_agent_display_full_location($post) ?>

        	</div>
            <div class="agent-info hidden-xs">
                <?php homez_agent_display_phone($post); ?>
                <?php homez_agent_display_email($post); ?>
            </div>
            <div class="ms-auto">
                <a href="javascript:void(0);" class="btn-agency-remove-agent btn-action-icon" data-agent_id="<?php echo esc_attr($post->ID); ?>" data-nonce="<?php echo esc_attr(wp_create_nonce( 'wp-realestate-agency-remove-agent-nonce' )); ?>"><i class="flaticon-bin"></i></a>
            </div>
        </div>
    </div>
</article><!-- #post-## -->

<?php do_action( 'wp_realestate_after_agent_content', $post->ID ); ?>