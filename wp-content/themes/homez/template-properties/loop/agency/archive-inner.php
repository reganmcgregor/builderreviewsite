<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$agencies_display_mode = homez_get_agencies_display_mode();
$layout_type = homez_get_config('agencies_layout_sidebar', 'main');
if($layout_type == 'main'){
	remove_action( 'wp_realestate_before_agency_archive', array( 'WP_RealEstate_Agency', 'display_agencies_count_results' ), 10 );
}
?>
<div class="agencies-listing-wrapper main-items-wrapper" data-display_mode="<?php echo esc_attr($agencies_display_mode); ?>">
	<?php
	/**
	 * wp_realestate_before_agency_archive
	 */
	do_action( 'wp_realestate_before_agency_archive', $agencies );
	?>

	<?php
	if ( !empty($agencies) && !empty($agencies->posts) ) {

		/**
		 * wp_realestate_before_loop_agency
		 */
		do_action( 'wp_realestate_before_loop_agency', $agencies );
		?>

		<div class="agencies-wrapper items-wrapper clearfix">
			
			<?php 

			$columns = homez_get_agencies_columns();
			$bcol = $columns ? 12/$columns : 4;
			$i = 0;

			if ( $agencies_display_mode == 'grid' ) {
				
			?>
				<div class="row">
					<?php while ( $agencies->have_posts() ) : $agencies->the_post(); ?>
						<div class="col-md-6 col-xl-<?php echo esc_attr($bcol); ?> col-12">
							<?php echo WP_RealEstate_Template_Loader::get_template_part( 'agencies-styles/inner-grid' ); ?>
						</div>
					<?php $i++; endwhile; ?>
				</div>
			<?php } else { ?>
				<div class="row">
					<?php while ( $agencies->have_posts() ) : $agencies->the_post(); ?>
						<div class="col-md-<?php echo esc_attr($bcol); ?> col-xl-<?php echo esc_attr($bcol); ?> col-sm-12 col-12">
							<?php echo WP_RealEstate_Template_Loader::get_template_part( 'agencies-styles/inner-list' ); ?>
						</div>
					<?php $i++; endwhile; ?>
				</div>
			<?php } ?>

		</div>

		<?php
		/**
		 * wp_realestate_after_loop_agency
		 */
		do_action( 'wp_realestate_after_loop_agency', $agencies );
		
		

		wp_reset_postdata();
	?>

	<?php } else { ?>
		<div class="not-found text-center"><?php esc_html_e('No agency found.', 'homez'); ?></div>
	<?php } ?>

	<?php
	/**
	 * wp_realestate_after_agency_archive
	 */
	do_action( 'wp_realestate_after_agency_archive', $agencies );
	?>
</div>