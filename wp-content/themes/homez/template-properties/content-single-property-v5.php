<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $post;

wp_enqueue_script( 'isotope-pkgd', get_template_directory_uri().'/js/isotope.pkgd.min.js', array( 'jquery', 'imagesloaded' ) );
?>

<?php do_action( 'wp_realestate_before_property_detail', $post->ID ); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class('property-single-layout property-single-v5'); ?>>
	
	<div class="property-detail-header-wrapper position-relative">
		<?php echo WP_RealEstate_Template_Loader::get_template_part( 'single-property/tabs-gallery-v2' ); ?>

		<!-- Content header -->
		<div class="top-header-info">
			<div class="container">
				<?php echo WP_RealEstate_Template_Loader::get_template_part( 'single-property/header-v2' ); ?>
			</div>
		</div>
	</div>
	

	<div class="<?php echo apply_filters('homez_property_content_class', 'container');?>">
		
		<!-- Main content -->
		<div class="content-property-detail">

			<div class="property-detail-main isotope-items row" data-isotope-duration="400" data-columnwidth=".col-md-6">
				
				<?php do_action( 'wp_realestate_before_property_content', $post->ID ); ?>

				<?php if ( homez_get_config('show_property_description', true) ) { ?>
					<div class="item-wrapper col-12 col-md-6 isotope-item">
						<?php echo WP_RealEstate_Template_Loader::get_template_part( 'single-property/description' ); ?>
					</div>
				<?php } ?>
									
				<?php if ( is_active_sidebar( 'property-single-v3-sidebar' ) ): ?>
					<div class="item-wrapper col-12 col-md-6 isotope-item">
						<?php dynamic_sidebar( 'property-single-v3-sidebar' ); ?>
					</div>
			   	<?php endif; ?>

				<?php
				if ( homez_get_config('show_property_detail', true) ) { ?>
					<div class="item-wrapper col-12 col-md-6 isotope-item">
					<?php echo WP_RealEstate_Template_Loader::get_template_part( 'single-property/detail' ); ?>
					</div>
				<?php } ?>

				<?php
				if ( homez_get_config('show_property_attachments', true) ) { ?>
					<div class="item-wrapper col-12 col-md-6 isotope-item">
					<?php echo WP_RealEstate_Template_Loader::get_template_part( 'single-property/attachments' ); ?>
					</div>
				<?php } ?>


				<?php
				if ( homez_get_config('show_property_amenities', true) ) { ?>
					<div class="item-wrapper col-12 col-md-6 isotope-item">
					<?php echo WP_RealEstate_Template_Loader::get_template_part( 'single-property/amenities' ); ?>
					</div>
				<?php } ?>

				<?php
				if ( homez_get_config('show_property_materials', false) ) { ?>
					<div class="item-wrapper col-12 col-md-6 isotope-item">
					<?php echo WP_RealEstate_Template_Loader::get_template_part( 'single-property/materials' ); ?>
					</div>
				<?php } ?>

				<?php
				if ( homez_get_config('show_property_location', true) ) { ?>
					<div class="item-wrapper col-12 col-md-6 isotope-item">
					<?php echo WP_RealEstate_Template_Loader::get_template_part( 'single-property/location' ); ?>
					</div>
				<?php } ?>

				<?php
				if ( homez_get_config('show_property_floor-plans', true) ) { ?>
					<div class="item-wrapper col-12 col-md-6 isotope-item">
					<?php echo WP_RealEstate_Template_Loader::get_template_part( 'single-property/floor-plans' ); ?>
					</div>
				<?php } ?>
				
				<?php
				if ( homez_get_config('show_property_tabs-video-virtual', true) ) { ?>
					<div class="item-wrapper col-12 col-md-6 isotope-item">
					<?php echo WP_RealEstate_Template_Loader::get_template_part( 'single-property/tabs-video-virtual' ); ?>
					</div>
				<?php } ?>

				<?php
				if ( homez_get_config('show_property_schedule-tour', true) ) { ?>
					<div class="item-wrapper col-12 col-md-6 isotope-item">
					<?php echo WP_RealEstate_Template_Loader::get_template_part( 'single-property/schedule-tour' ); ?>
					</div>
				<?php } ?>
				
				<?php
				if ( homez_get_config('show_property_mortgage-calculator', true) ) { ?>
					<div class="item-wrapper col-12 col-md-6 isotope-item">
					<?php echo WP_RealEstate_Template_Loader::get_template_part( 'single-property/mortgage-calculator' ); ?>
					</div>
				<?php } ?>
				
				<?php
				if ( homez_get_config('show_property_facilities', true) ) { ?>
					<div class="item-wrapper col-12 col-md-6 isotope-item">
					<?php echo WP_RealEstate_Template_Loader::get_template_part( 'single-property/facilities' ); ?>
					</div>
				<?php } ?>

				<?php
				if ( homez_get_config('show_property_valuation', true) ) { ?>
					<div class="item-wrapper col-12 col-md-6 isotope-item">
					<?php echo WP_RealEstate_Template_Loader::get_template_part( 'single-property/valuation' ); ?>
					</div>
				<?php } ?>

				<?php if ( homez_get_config('show_property_energy', true) ) { ?>
					<div class="item-wrapper col-12 col-md-6 isotope-item">
					<?php echo WP_RealEstate_Template_Loader::get_template_part( 'single-property/energy' ); ?>
					</div>
				<?php } ?>
				
				<?php
				if ( homez_get_config('show_property_stats_graph', true) ) { ?>
					<div class="item-wrapper col-12 col-md-6 isotope-item">
					<?php echo WP_RealEstate_Template_Loader::get_template_part( 'single-property/stats_graph' ); ?>
					</div>
				<?php } ?>
				
				<?php
				if ( homez_get_config('show_property_nearby_yelp', true) ) { ?>
					<div class="item-wrapper col-12 col-md-6 isotope-item">
					<?php echo WP_RealEstate_Template_Loader::get_template_part( 'single-property/nearby_yelp' ); ?>
					</div>
				<?php } ?>

				<?php
				if ( homez_get_config('show_property_walk_score', true) ) { ?>
					<div class="item-wrapper col-12 col-md-6 isotope-item">
						<?php echo WP_RealEstate_Template_Loader::get_template_part( 'single-property/walk_score' ); ?>
					</div>
				<?php } ?>
				
				<?php
				if ( homez_get_config('show_property_google_places', true) ) { ?>
					<div class="item-wrapper col-12 col-md-6 isotope-item">
					<?php echo WP_RealEstate_Template_Loader::get_template_part( 'single-property/google-places' ); ?>
					</div>
				<?php } ?>
				
				<?php if ( WP_RealEstate_Review::review_enable() ) { ?>
					<div class="item-wrapper col-12 col-md-6 isotope-item">
						<?php comments_template(); ?>
					</div>
				<?php } ?>
				
				<?php do_action( 'wp_realestate_after_property_content', $post->ID ); ?>
			</div>
				
		</div>

	</div>
	
	<?php
	if ( homez_get_config('show_property_related', true) ) {
		echo WP_RealEstate_Template_Loader::get_template_part( 'single-property/related' );
	}
	?>

	<?php
	if ( homez_get_config('show_property_subproperties', true) ) {
		echo WP_RealEstate_Template_Loader::get_template_part( 'single-property/subproperties' );
	}
	?>
</article><!-- #post-## -->

<?php do_action( 'wp_realestate_after_property_detail', $post->ID ); ?>