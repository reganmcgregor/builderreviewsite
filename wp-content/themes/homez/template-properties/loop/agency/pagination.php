<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<div class="agencies-pagination-wrapper main-pagination-wrapper">
	<?php
		$pagination_type = homez_get_agencies_pagination();
		if ( $pagination_type == 'loadmore' || $pagination_type == 'infinite' ) {
			$next_link = get_next_posts_link( '&nbsp;', $agencies->max_num_pages );
			if ( $next_link ) {
		?>
				<div class="ajax-pagination <?php echo trim($pagination_type == 'loadmore' ? 'loadmore-action' : 'infinite-action'); ?>">
					<div class="apus-pagination-next-link hidden"><?php echo trim($next_link); ?></div>
					<a href="#" class="apus-loadmore-btn"><?php esc_html_e( 'Load more', 'homez' ); ?></a>
					<span class="apus-allproducts"><?php esc_html_e( 'All agencies loaded.', 'homez' ); ?></span>
				</div>
		<?php
			}
		} else {
			WP_RealEstate_Mixes::custom_pagination( array(
				'max_num_pages' => $agencies->max_num_pages,
				'prev_text'     => '<i class="ti-angle-left"></i>',
				'next_text'     => '<i class="ti-angle-right"></i>',
				'wp_query' => $agencies
			));
		}
	?>

	<?php
	$layout_type = homez_get_config('agencies_layout_sidebar', 'main');
	if($layout_type == 'main'){ ?>
		<div class="text-center mt-3">
			<?php WP_RealEstate_Agency::display_agencies_count_results($agencies); ?>
		</div>
	<?php } ?>
</div>
