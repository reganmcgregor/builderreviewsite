<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<div class="agents-pagination-wrapper main-pagination-wrapper">
	<?php
		$pagination_type = homez_get_agents_pagination();
		if ( $pagination_type == 'loadmore' || $pagination_type == 'infinite' ) {
			$next_link = get_next_posts_link( '&nbsp;', $agents->max_num_pages );
			if ( $next_link ) {
		?>
				<div class="ajax-pagination <?php echo trim($pagination_type == 'loadmore' ? 'loadmore-action' : 'infinite-action'); ?>">
					<div class="apus-pagination-next-link hidden"><?php echo trim($next_link); ?></div>
					<a href="#" class="apus-loadmore-btn"><?php esc_html_e( 'Load more', 'homez' ); ?></a>
					<span class="apus-allproducts"><?php esc_html_e( 'All agents loaded.', 'homez' ); ?></span>
				</div>
		<?php
			}
		} else {
			WP_RealEstate_Mixes::custom_pagination( array(
				'max_num_pages' => $agents->max_num_pages,
				'prev_text'     => '<i class="ti-angle-left"></i>',
				'next_text'     => '<i class="ti-angle-right"></i>',
				'wp_query' => $agents
			));
		}
	?>

	<?php
	$layout_type = homez_get_config('agents_layout_sidebar', 'main');
	if($layout_type == 'main'){ ?>
		<div class="text-center mt-3">
			<?php WP_RealEstate_Agent::display_agents_count_results($agents); ?>
		</div>
	<?php } ?>
</div>
