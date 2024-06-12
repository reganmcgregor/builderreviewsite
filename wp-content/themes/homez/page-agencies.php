<?php
/**
 * The template for displaying pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Homez
 * @since Homez 1.0
 */
/*
*Template Name: Agencies Template
*/

if ( isset( $_REQUEST['load_type'] ) && WP_RealEstate_Mixes::is_ajax_request() ) {
	if ( get_query_var( 'paged' ) ) {
	    $paged = get_query_var( 'paged' );
	} elseif ( get_query_var( 'page' ) ) {
	    $paged = get_query_var( 'page' );
	} else {
	    $paged = 1;
	}

	$query_args = array(
		'post_type' => 'agency',
	    'post_status' => 'publish',
	    'post_per_page' => wp_realestate_get_option('number_agencies_per_page', 10),
	    'paged' => $paged,
	);
	
	global $wp_query;
	$atts = array();
	if ( !empty($wp_query->post->post_content) ) {
		$shortcode_atts = homez_get_shortcode_atts($wp_query->post->post_content, 'wp_realestate_agencies');
		if ( !empty($shortcode_atts[0]) ) {
			foreach ($shortcode_atts[0] as $key => $value) {
				$atts[$key] = trim($value, '"');
			}
			
		}
	}

	$params = array();
	if (WP_RealEstate_Abstract_Filter::has_filter($atts)) {
		$params = $atts;
	}
	if ( WP_RealEstate_Abstract_Filter::has_filter() ) {
		$params = array_merge($params, $_GET);
	}

	$agencies = WP_RealEstate_Query::get_posts($query_args, $params);
	
	if ( 'items' !== $_REQUEST['load_type'] ) {
		echo WP_RealEstate_Template_Loader::get_template_part('archive-agency-ajax-full', array('agencies' => $agencies));
	} else {
		echo WP_RealEstate_Template_Loader::get_template_part('archive-agency-ajax-agencies', array('agencies' => $agencies));
	}
} else {
	get_header();

	$sidebar_configs = homez_get_agencies_layout_configs();
	
	homez_render_breadcrumbs();

	?>

		<section id="main-container" class="inner">
			
			<div class="main-content <?php echo apply_filters('homez_page_content_class', 'container');?> inner">
				
				<?php homez_before_content( $sidebar_configs ); ?>
				
				<div class="row">
					<?php homez_display_sidebar_left( $sidebar_configs ); ?>

					<div id="main-content" class="col-sm-12 <?php echo esc_attr($sidebar_configs['main']['class']); ?>">
						<main id="main" class="site-main" role="main">

							<?php
							// Start the loop.
							while ( have_posts() ) : the_post();
								
								// Include the page content template.
								the_content();

								// If comments are open or we have at least one comment, load up the comment template.
								if ( comments_open() || get_comments_number() ) :
									comments_template();
								endif;

							// End the loop.
							endwhile;
							?>


						</main><!-- .site-main -->
					</div><!-- .content-area -->
					
					<?php homez_display_sidebar_right( $sidebar_configs ); ?>
				</div>

			</div>
		</section>


	<?php

	get_footer();
}