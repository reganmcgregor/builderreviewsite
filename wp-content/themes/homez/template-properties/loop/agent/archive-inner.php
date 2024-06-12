<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$agents_display_mode = homez_get_agents_display_mode();
$layout_type = homez_get_config('agents_layout_sidebar', 'main');
if($layout_type == 'main'){
	remove_action( 'wp_realestate_before_agent_archive', array( 'WP_RealEstate_Agent', 'display_agents_count_results' ), 10 );
}
?>
<div class="agents-listing-wrapper main-items-wrapper" data-display_mode="<?php echo esc_attr($agents_display_mode); ?>">
	<?php
	/**
	 * wp_realestate_before_agent_archive
	 */
	do_action( 'wp_realestate_before_agent_archive', $agents );
	?>

	<?php
	if ( !empty($agents) && !empty($agents->posts) ) {

		/**
		 * wp_realestate_before_loop_agent
		 */
		do_action( 'wp_realestate_before_loop_agent', $agents );
		?>

		<div class="agents-wrapper items-wrapper">
			
			<?php 
			$i = 0;
			$columns = homez_get_agents_columns();
			$bcol = $columns ? 12/$columns : 4;
			if( $columns == 5){
				$bcol = 'c5';
			}
			if ( $agents_display_mode == 'grid' ) {
			?>
				<div class="row">
					<?php while ( $agents->have_posts() ) : $agents->the_post(); ?>
						<div class="col-6 col-md-4 col-xl-<?php echo esc_attr($bcol); ?>">
							<?php echo WP_RealEstate_Template_Loader::get_template_part( 'agents-styles/inner-grid' ); ?>
						</div>
					<?php $i++; endwhile; ?>
				</div>
			<?php } else { ?>
				<div class="row">
					<?php while ( $agents->have_posts() ) : $agents->the_post(); ?>
						<div class="col-12 col-sm-12 col-md-<?php echo esc_attr($bcol); ?> col-xl-<?php echo esc_attr($bcol); ?>">
							<?php echo WP_RealEstate_Template_Loader::get_template_part( 'agents-styles/inner-list' ); ?>
						</div>
					<?php $i++; endwhile; ?>
				</div>
			<?php } ?>
			

		</div>

		<?php
		/**
		 * wp_realestate_after_loop_agent
		 */
		do_action( 'wp_realestate_after_loop_agent', $agents );
		
		
		
		wp_reset_postdata();
	?>

	<?php } else { ?>
		<div class="not-found text-center"><?php esc_html_e('No agent found.', 'homez'); ?></div>
	<?php } ?>

	<?php
	/**
	 * wp_realestate_after_agent_archive
	 */
	do_action( 'wp_realestate_after_agent_archive', $agents );
	?>
</div>