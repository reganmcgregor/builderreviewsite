<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $post;
?>

<?php do_action( 'wp_realestate_before_agent_detail', get_the_ID() ); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<!-- Main content -->

	<?php do_action( 'wp_realestate_before_agent_content', get_the_ID() ); ?>
	
		<?php if ( is_active_sidebar( 'agent-single-sidebar' ) ): ?>
			<a href="javascript:void(0)" class="mobile-sidebar-btn d-inline-block d-lg-none btn-right"><i class="ti-menu-alt"></i> </a>
			<div class="mobile-sidebar-panel-overlay"></div>
		<?php endif; ?>

		<div class="row">
			<div class="col-12 detail-content-agent-agency col-lg-<?php echo esc_attr( is_active_sidebar( 'agent-single-sidebar' ) ? 8 : 12); ?> main-left-space">

				<div class="agent-detail-tabs property-detail-main">
			        
					<?php echo WP_RealEstate_Template_Loader::get_template_part( 'single-agent/description' ); ?>

					<?php if ( homez_get_config('agent_location_show') ) { ?>
						<?php echo WP_RealEstate_Template_Loader::get_template_part( 'single-agent/location' ); ?>
					<?php } ?>
				
					<?php if ( homez_get_config('agent_property_show') ) { ?>
						<?php echo WP_RealEstate_Template_Loader::get_template_part( 'single-agent/properties' ); ?>
					<?php } ?>

					<?php if ( WP_RealEstate_Review::review_enable() ) { ?>
							<!-- Review -->
							<?php comments_template(); ?>
					<?php } ?>
					
				</div>
			</div>
			<?php if ( is_active_sidebar( 'agent-single-sidebar' ) ): ?>
			   	<div class="col-12 col-lg-4 sidebar-wrapper sidebar-wrapper-author">
					<div class="sidebar sidebar-right">
						<div class="close-sidebar-btn d-block d-lg-none"> <i class="ti-close"></i><span><?php esc_html_e('Close', 'homez'); ?></span></div>
				   		<?php dynamic_sidebar( 'agent-single-sidebar' ); ?>
			   		</div>
			   	</div>
		   	<?php endif; ?>
		</div>
		
	<?php do_action( 'wp_realestate_after_agent_sidebar', get_the_ID() ); ?>
</article><!-- #post-## -->

<?php do_action( 'wp_realestate_after_agent_detail', get_the_ID() ); ?>