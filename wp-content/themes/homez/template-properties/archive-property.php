<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $wp_query;

if ( get_query_var( 'paged' ) ) {
    $paged = get_query_var( 'paged' );
} elseif ( get_query_var( 'page' ) ) {
    $paged = get_query_var( 'page' );
} else {
    $paged = 1;
}

$query_args = array(
	'post_type' => 'property',
    'post_status' => 'publish',
    'post_per_page' => wp_realestate_get_option('number_properties_per_page', 10),
    'paged' => $paged,
);
$params = array();
$taxs = ['type', 'status', 'location', 'amenity', 'label', 'material'];
foreach ($taxs as $tax) {
	if ( is_tax('property_'.$tax) ) {
		$term = $wp_query->queried_object;
		if ( isset( $term->term_id) ) {
			$params['filter-'.$tax] = $term->term_id;
		}
	}
}

if ( WP_RealEstate_Abstract_Filter::has_filter() ) {
	$params = array_merge($params, $_GET);
}
$properties = WP_RealEstate_Query::get_posts($query_args, $params);

if ( isset( $_REQUEST['load_type'] ) && WP_RealEstate_Mixes::is_ajax_request() ) {
	if ( 'items' !== $_REQUEST['load_type'] ) {
        echo WP_RealEstate_Template_Loader::get_template_part('archive-property-ajax-full', array('properties' => $properties));
	} else {
		echo WP_RealEstate_Template_Loader::get_template_part('archive-property-ajax-properties', array('properties' => $properties));
	}

} else {
	get_header();

	$layout_type = homez_get_properties_layout_type();

	$args = array(
		'properties' => $properties
	);

	if ( $layout_type == 'half-map' || $layout_type == 'half-map-v2' || $layout_type == 'half-map-v3' ) {
		if ( $layout_type == 'half-map' ) {
			$first_class = 'col-xl-5 col-lg-6 col-12 first_class p-0';
			$second_class = 'col-xl-7 col-lg-6 col-12 second_class p-0';
			$sidebar = 'properties-filter-top-half-map';
			$sidebar_wrapper_class = 'properties-filter-top-half-map sticky-top';
		} elseif ( $layout_type == 'half-map-v2' ) {
			$first_class = 'col-xl-5 col-lg-6 col-12 first_class p-0';
			$second_class = 'col-xl-7 col-lg-6 col-12 second_class p-0';
			$sidebar = 'properties-filter';
			$sidebar_wrapper_class = 'properties-filter-sidebar-wrapper';
		} elseif ( $layout_type == 'half-map-v3' ) {
			$first_class = 'col-xl-5 col-lg-6 col-12 first_class p-0';
			$second_class = 'col-xl-7 col-lg-6 col-12 second_class p-0';
			$sidebar = 'properties-filter-top-half-map2';
			$sidebar_wrapper_class = 'properties-filter-top-half-map3';
		}
	?>
		<section id="main-container" class="inner layout-type-<?php echo esc_attr($layout_type); ?>">

			<?php if ( is_active_sidebar( $sidebar ) && ($layout_type == 'half-map-v3' ) ){ ?>
							
				<div class="mobile-groups-button d-block d-lg-none clearfix text-center">
					<button class=" btn btn-sm btn-theme btn-view-map" type="button"><span class="pre"><i class="fas fa-map" aria-hidden="true"></i></span><?php esc_html_e( 'Map View', 'homez' ); ?></button>
					<button class=" btn btn-sm btn-theme btn-view-listing d-none" type="button"><span class="pre"><i class="fas fa-list" aria-hidden="true"></i></span><?php esc_html_e( 'Properties View', 'homez' ); ?></button>
				</div>

	   			<div class="<?php echo esc_attr($sidebar_wrapper_class); ?>">
	   				<div class="inner">
			   			<?php dynamic_sidebar( $sidebar ); ?>
			   		</div>
			   	</div>

		   	<?php } ?>

			<div class="row m-0 layout-type-<?php echo esc_attr($layout_type); ?>">

				<div id="main-content" class="<?php echo esc_attr($first_class); ?>">
					<div class="inner-left <?php echo esc_attr( is_active_sidebar( $sidebar )? 'has-sidebar':'' ); ?>">


						<?php if( is_active_sidebar( $sidebar ) && $layout_type == 'half-map-v2' ){ ?>

				   			<div class="mobile-groups-button d-block d-lg-none clearfix text-center">
								<button class=" btn btn-sm btn-theme btn-view-map" type="button"><span class="pre"><i class="fas fa-map" aria-hidden="true"></i></span><?php esc_html_e( 'Map View', 'homez' ); ?></button>
								<button class=" btn btn-sm btn-theme btn-view-listing d-none" type="button"><span class="pre"><i class="fas fa-list" aria-hidden="true"></i></span><?php esc_html_e( 'Properties View', 'homez' ); ?></button>
								<button class="btn btn-sm btn-theme btn-show-filter">
									<span class="pre"><i class="flaticon-settings"></i></span><span><?php echo esc_html__('Show Filter', 'homez'); ?></span>
								</button>
							</div>

				   			<div class="<?php echo esc_attr($sidebar_wrapper_class); ?>">
				   				<div class="inner">
						   			<?php dynamic_sidebar( $sidebar ); ?>
						   		</div>
						   	</div>
						   	<div class="over-dark-filter"></div>

						<?php } ?>


					   	<div class="content-listing">

					   		<?php if( is_active_sidebar( $sidebar ) && ($layout_type == 'half-map') ){ ?>
					   			<div class="mobile-groups-button d-block d-lg-none clearfix text-center">
									<button class=" btn btn-sm btn-theme btn-view-map" type="button"><span class="pre"><i class="fas fa-map" aria-hidden="true"></i></span><?php esc_html_e( 'Map View', 'homez' ); ?></button>
									<button class=" btn btn-sm btn-theme btn-view-listing d-none" type="button"><span class="pre"><i class="fas fa-list" aria-hidden="true"></i></span><?php esc_html_e( 'Properties View', 'homez' ); ?></button>
								</div>

					   			<div class="<?php echo esc_attr($sidebar_wrapper_class); ?>">
					   				<div class="inner">
							   			<?php dynamic_sidebar( $sidebar ); ?>
							   		</div>
							   	</div>
						   	<?php } ?>
					   		

							<main id="main" class="site-main layout-type-<?php echo esc_attr($layout_type); ?>" role="main">

								<?php
									echo WP_RealEstate_Template_Loader::get_template_part('loop/property/archive-inner', $args);

									echo WP_RealEstate_Template_Loader::get_template_part('loop/property/pagination', array('properties' => $properties));
								?>

							</main><!-- .site-main -->

						</div>
					</div>
				</div><!-- .content-area -->

				<div class="<?php echo esc_attr($second_class); ?>">
					<div id="properties-google-maps" class="fix-map d-none d-lg-block">
						<?php if ( is_active_sidebar( $sidebar ) && $layout_type == 'half-map-v2' ){ ?>
							<!-- show filter -->
							<span class="d-none d-lg-inline-flex btn-show-filter show-filter-sidebar">
								<span class="d-flex align-items-center icon-filter"><i class="flaticon-settings"></i></span><span><?php echo esc_html__('Show Filter', 'homez'); ?></span>
							</span>
						<?php } ?>
					</div>
				</div>

			</div>
		</section>
	<?php
	} else {
		$sidebar_configs = homez_get_properties_layout_configs();
		$layout_sidebar = homez_get_properties_layout_sidebar();
	?>
		
		<section id="main-container" class="inner layout-type-<?php echo esc_attr($layout_type); ?> <?php echo ((homez_get_properties_show_filter_top())?'has-filter-top':''); ?>">
			<?php if ( $layout_type == 'top-map' ) { ?>
				<?php if ( is_active_sidebar( 'properties-filter-top-map' ) && homez_get_properties_show_filter_top() ) { ?>
					<div class="properties-filter-top-sidebar-wrapper m-0">
				   		<?php dynamic_sidebar( 'properties-filter-top-map' ); ?>
				   	</div>
				<?php } ?>
				<div class="mobile-groups-button d-block d-lg-none clearfix text-center">
					<button class=" btn btn-sm btn-theme btn-view-map" type="button"><span class="pre"><i class=" fas fa-map" aria-hidden="true"></i></span><?php esc_html_e( 'Map View', 'homez' ); ?></button>
					<button class=" btn btn-sm btn-theme  btn-view-listing d-none d-md-block" type="button"><span class="pre"><i class="fas fa-list" aria-hidden="true"></i><?php esc_html_e( 'Properties View', 'homez' ); ?></span></button>
				</div>
				<div id="properties-google-maps" class="d-none d-md-block top-map"></div>
			<?php } ?>

			<?php
			$filter_top_sidebar = homez_get_properties_filter_top_sidebar();
			if ( $layout_type !== 'top-map' && is_active_sidebar( $filter_top_sidebar ) && homez_get_properties_show_filter_top() ) { ?>
				<div class="properties-filter-top-sidebar-wrapper">
			   		<?php dynamic_sidebar( $filter_top_sidebar ); ?>
			   	</div>
			<?php } ?>

			<?php
				homez_render_breadcrumbs();
			?>

			<?php if ( $layout_sidebar == 'main' && is_active_sidebar( $filter_sidebar ) && homez_get_properties_show_offcanvas_filter() ) { ?>
				<div class="properties-filter-sidebar-wrapper">
					<div class="inner">
				   		<?php dynamic_sidebar( $filter_sidebar ); ?>
				   		<span class="close-filter">
				   			<i class="ti-close"></i> 
				   		</span>
			   		</div>
			   	</div>
			   	<div class="over-dark-filter"></div>
			<?php } ?>

			<div class="main-content <?php echo apply_filters('homez_page_content_class', 'container');?> inner">
				
				<?php homez_before_content( $sidebar_configs ); ?>
				
				<div class="row">
					<?php homez_display_sidebar_left( $sidebar_configs ); ?>

					<div id="main-content" class="col-sm-12 <?php echo esc_attr($sidebar_configs['main']['class']); ?>">
						<main id="main" class="site-main layout-type-<?php echo esc_attr($layout_type); ?>" role="main">
							<?php
								echo WP_RealEstate_Template_Loader::get_template_part('loop/property/archive-inner', $args);

								echo WP_RealEstate_Template_Loader::get_template_part('loop/property/pagination', array('properties' => $properties));
							?>
						</main><!-- .site-main -->
					</div><!-- .content-area -->
					
					<?php homez_display_sidebar_right( $sidebar_configs ); ?>
				</div>

			</div>
		</section>
	<?php
	}

	get_footer();
}