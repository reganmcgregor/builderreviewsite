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
	'post_type' => 'agent',
    'post_status' => 'publish',
    'post_per_page' => wp_realestate_get_option('number_agents_per_page', 10),
    'paged' => $paged,
);
$params = array();
$taxs = ['category', 'location'];
foreach ($taxs as $tax) {
	if ( is_tax('agent_'.$tax) ) {
		$term = $wp_query->queried_object;
		if ( isset( $term->term_id) ) {
			$params['filter-'.$tax] = $term->term_id;
		}
	}
}

if ( WP_RealEstate_Abstract_Filter::has_filter() ) {
	$params = array_merge($params, $_GET);
}
$agents = WP_RealEstate_Query::get_posts($query_args, $params);

if ( isset( $_REQUEST['load_type'] ) && WP_RealEstate_Mixes::is_ajax_request() ) {
	if ( 'items' !== $_REQUEST['load_type'] ) {
        echo WP_RealEstate_Template_Loader::get_template_part('archive-agent-ajax-full', array('agents' => $agents));
	} else {
		echo WP_RealEstate_Template_Loader::get_template_part('archive-agent-ajax-agents', array('agents' => $agents));
	}

} else {
	get_header();
	$sidebar_configs = homez_get_agents_layout_configs();

	homez_render_breadcrumbs();
	?>
	<section id="main-container" class="main-content <?php echo apply_filters('homez_agent_content_class', 'container');?> inner">
		
		<?php homez_before_content( $sidebar_configs ); ?>
		<div class="row">
			<?php homez_display_sidebar_left( $sidebar_configs ); ?>

			<div id="main-content" class="<?php echo esc_attr($sidebar_configs['main']['class']); ?>">
				<div id="main" class="site-main layout-type-grid" role="main">

					<?php
						echo WP_RealEstate_Template_Loader::get_template_part('loop/agent/archive-inner', array('agents' => $agents));
						
						echo WP_RealEstate_Template_Loader::get_template_part('loop/agent/pagination', array('agents' => $agents));
					?>

				</div><!-- .site-main -->
			</div><!-- .content-area -->
			
			<?php homez_display_sidebar_right( $sidebar_configs ); ?>
			
		</div>
	</section>
	<?php get_footer();
}