<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post;

?>

<?php do_action( 'wp_realestate_before_agent_content', $post->ID ); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="agent-list agent-item">
        <div class="d-flex">
        	<?php if ( has_post_thumbnail() ) { ?>
                <div class="member-thumbnail-wrapper d-flex align-items-center justify-content-center">
                    <?php homez_agent_display_image( $post, 'thumbnail'); ?>
                </div>
            <?php } ?>
            
            <div class="agent-information d-flex align-items-center <?php echo esc_attr( (!has_post_thumbnail())?'no-image':''); ?>">
            	<div class="inner">
            		<?php the_title( sprintf( '<h2 class="agent-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
                    <?php homez_agent_display_job( $post ); ?>
                    <div class="metas">
                        <?php homez_agent_display_phone($post, 'title'); ?>
                        <?php homez_agent_display_meta_data($post, 'fax', esc_html__('Fax:', 'homez')); ?>
                        <?php homez_agent_display_email($post, 'title'); ?>
                    </div>
            	
                    <div class="agent-information-bottom d-flex align-items-center">
                        
                        <a href="<?php the_permalink(); ?>" class="btn-underline text-theme"><?php esc_html_e('View Profile', 'homez'); ?></a>
                        
                        <div class="ali-right hidden">
                            <?php homez_agent_display_socials($post); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</article><!-- #post-## -->

<?php do_action( 'wp_realestate_after_agent_content', $post->ID ); ?>