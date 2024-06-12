<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $post;

?>

<?php do_action( 'wp_realestate_before_property_detail', $post->ID ); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class('property-single-layout property-single-v9'); ?>>
	
	<?php
		$amenities = $materials = $location = $floor_plans = $video_virtual = $facilities = $valuation = $stats_graph = $nearby_yelp = $walk_score = $subproperties = $related = $mortgage_calculator = $google_places = '';
		if ( homez_get_config('show_property_amenities', true) ) {
			$amenities = WP_RealEstate_Template_Loader::get_template_part( 'single-property/amenities' );
		}
		if ( homez_get_config('show_property_materials', false) ) {
			$materials = WP_RealEstate_Template_Loader::get_template_part( 'single-property/materials' );
		}
		if ( homez_get_config('show_property_location', true) ) {
			$location = WP_RealEstate_Template_Loader::get_template_part( 'single-property/location' );
		}
		if ( homez_get_config('show_property_floor-plans', true) ) {
			$floor_plans = WP_RealEstate_Template_Loader::get_template_part( 'single-property/floor-plans' );
		}
		if ( homez_get_config('show_property_tabs-virtual', true) ) {
			$virtual = WP_RealEstate_Template_Loader::get_template_part( 'single-property/virtual' );
		}
		if ( homez_get_config('show_property_tabs-video', true) ) {
			$video = WP_RealEstate_Template_Loader::get_template_part( 'single-property/video' );
		}
		if ( homez_get_config('show_property_schedule-tour', true) ) {
			$schedule_tour = WP_RealEstate_Template_Loader::get_template_part( 'single-property/schedule-tour' );
		}
		if ( homez_get_config('show_property_mortgage-calculator', true) ) {
			$mortgage_calculator = WP_RealEstate_Template_Loader::get_template_part( 'single-property/mortgage-calculator' );
		}
		if ( homez_get_config('show_property_facilities', true) ) {
			$facilities = WP_RealEstate_Template_Loader::get_template_part( 'single-property/facilities' );
		}
		if ( homez_get_config('show_property_valuation', true) ) {
			$valuation = WP_RealEstate_Template_Loader::get_template_part( 'single-property/valuation' );
		}
		if ( homez_get_config('show_property_stats_graph', true) ) {
			$stats_graph = WP_RealEstate_Template_Loader::get_template_part( 'single-property/stats_graph' );
		}
		if ( homez_get_config('show_property_nearby_yelp', true) ) {
			$nearby_yelp = WP_RealEstate_Template_Loader::get_template_part( 'single-property/nearby_yelp' );
		}
		if ( homez_get_config('show_property_walk_score', true) ) {
			$walk_score = WP_RealEstate_Template_Loader::get_template_part( 'single-property/walk_score' );
		}

		if ( homez_get_config('show_property_google_places', true) ) {
			$google_places = WP_RealEstate_Template_Loader::get_template_part( 'single-property/google-places' );
		}


		global $property_preview;
		if ( $property_preview ) {
			$post = $property_preview;
		}
	?>
	<div class="<?php echo apply_filters('homez_property_content_class', 'container');?>">

		<?php echo WP_RealEstate_Template_Loader::get_template_part( 'single-property/header' ); ?>

		<div class="position-relative">
			<div class="d-none d-xl-block">
				<?php echo WP_RealEstate_Template_Loader::get_template_part( 'single-property/property-contact-form' ); ?>
			</div>
			<?php echo WP_RealEstate_Template_Loader::get_template_part( 'single-property/tabs-gallery-v4' ); ?>
		</div>
		<!-- Main content -->
		<div class="content-property-detail">

			<div class="row property-v-wrapper">
				<div class="col-12 col-lg-<?php echo esc_attr( is_active_sidebar( 'property-single-v4-sidebar' ) ? 8 : 12); ?>">

					<div class="wrapper-tab-v9">
						<?php do_action( 'wp_realestate_before_property_content', $post->ID ); ?>
						
						<ul class="tabs-list nav nav-tabs flex-nowrap nav-detail-center">
					
							<li><a class="active" data-bs-toggle="tab" href="#property-single-details"><?php esc_html_e('Overview', 'homez'); ?></a></li>
	
							<?php if ( $floor_plans || $virtual || $video ) { ?>
								<li><a data-bs-toggle="tab" href="#property-single-media"><?php esc_html_e('Media', 'homez'); ?></a></li>
							<?php } ?>

							<?php if ( $location ) { ?>
								<li><a data-bs-toggle="tab" href="#property-single-location"><?php esc_html_e('Locations', 'homez'); ?></a></li>
							<?php } ?>

							<?php if ( $amenities ) { ?>
								<li><a data-bs-toggle="tab" href="#property-single-amenities"><?php esc_html_e('Amenities', 'homez'); ?></a></li>
							<?php } ?>

							<?php if ( $mortgage_calculator || $valuation || $facilities) { ?>
								<li><a data-bs-toggle="tab" href="#property-single-addon"><?php esc_html_e('Addons', 'homez'); ?></a></li>
							<?php } ?>

							<?php if ( $stats_graph || $nearby_yelp || $walk_score || $google_places ) { ?>
								<li><a data-bs-toggle="tab" href="#property-single-nearby"><?php esc_html_e('Nearby', 'homez'); ?></a></li>
							<?php } ?>

							<?php if ( WP_RealEstate_Review::review_enable() ) { ?>
								<li><a data-bs-toggle="tab" href="#property-single-reviews"><?php esc_html_e('Reviews', 'homez'); ?></a></li>
							<?php } ?>
						</ul>
						<div class="tab-content">
							<div id="property-single-details" class="tab-pane fade active show">
								<div class="list-detail-v9">

									<?php
									if ( homez_get_config('show_property_overview', true) ) {
										echo WP_RealEstate_Template_Loader::get_template_part( 'single-property/overview' );
									}
									?>

									<?php
									if ( homez_get_config('show_property_description', true) ) {
										echo WP_RealEstate_Template_Loader::get_template_part( 'single-property/description' );
									}
									
									?>

									<?php
									if ( homez_get_config('show_property_detail', true) ) {
										echo WP_RealEstate_Template_Loader::get_template_part( 'single-property/detail' );
									}
									?>
								</div>
							</div>
							
							<?php if ( $floor_plans || $virtual || $video ) { ?>
								<div id="property-single-media" class="tab-pane fade fade">
									<div class="list-detail-v9">
										<?php 
										if ( homez_get_config('show_property_floor-plans', true) ) {
											echo WP_RealEstate_Template_Loader::get_template_part( 'single-property/floor-plans' );
										}
										if ( homez_get_config('show_property_tabs-virtual', true) ) {
											echo WP_RealEstate_Template_Loader::get_template_part( 'single-property/virtual' );
										}
										if ( homez_get_config('show_property_tabs-video', true) ) {
											echo WP_RealEstate_Template_Loader::get_template_part( 'single-property/video' );
										}
										?>
									</div>
								</div>
							<?php } ?>

							<?php if ( $location ) { ?>
								<div id="property-single-location" class="tab-pane fade">
									<?php echo trim($location); ?>
								</div>
							<?php } ?>

							<?php if ( $amenities ) { ?>
								<div id="property-single-amenities" class="tab-pane fade">
									<?php echo trim($amenities); ?>
								</div>
							<?php } ?>

							<?php if ( $mortgage_calculator || $valuation || $facilities ) { ?>
								<div id="property-single-addon" class="tab-pane fade">
									<div class="list-detail-v9">
										<?php
										if ( homez_get_config('show_property_mortgage-calculator', true) ) {
											echo WP_RealEstate_Template_Loader::get_template_part( 'single-property/mortgage-calculator' );
										}
										?>
										
										<?php
										if ( homez_get_config('show_property_facilities', true) ) {
											echo WP_RealEstate_Template_Loader::get_template_part( 'single-property/facilities' );
										}
										?>

										<?php
										if ( homez_get_config('show_property_valuation', true) ) {
											echo WP_RealEstate_Template_Loader::get_template_part( 'single-property/valuation' );
										}
										?>
									</div>
								</div>
							<?php } ?>
							
							<?php if ( $stats_graph || $nearby_yelp || $walk_score || $google_places ) { ?>
								<div id="property-single-nearby" class="tab-pane fade">
									<div class="list-detail-v9">
										<?php echo trim($stats_graph); ?>
										<?php echo trim($nearby_yelp); ?>
										<?php echo trim($walk_score); ?>
										<?php echo trim($google_places); ?>
									</div>
								</div>
							<?php } ?>

							<?php if ( WP_RealEstate_Review::review_enable() ) { ?>
								<div id="property-single-reviews" class="tab-pane fade">
									<?php comments_template(); ?>
								</div>
							<?php } ?>

						</div>
						<?php do_action( 'wp_realestate_after_property_content', $post->ID ); ?>
					</div>

					<?php if ( is_active_sidebar( 'property-single-v4-sidebar' ) ): ?>
						<div class="sidebar-mobile d-block d-lg-none box-white-mobile">
							<div class="widget">
								<?php echo WP_RealEstate_Template_Loader::get_template_part( 'single-property/property-contact-form' ); ?>
							</div>
						   	<?php dynamic_sidebar( 'property-single-v4-sidebar' ); ?>
					   	</div>
				   	<?php endif; ?>

				</div>
				
				<?php if ( is_active_sidebar( 'property-single-v4-sidebar' ) ): ?>
					<div class="col-12 col-lg-4 sidebar-wrapper d-none d-lg-block">
				   		<div class="sidebar sidebar-right sticky-top sidebar-property">
				   			<?php dynamic_sidebar( 'property-single-v4-sidebar' ); ?>
				   			<div class="d-block d-xl-none widget">
								<?php echo WP_RealEstate_Template_Loader::get_template_part( 'single-property/property-contact-form' ); ?>
							</div>
				   		</div>
				   	</div>
			   	<?php endif; ?>
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