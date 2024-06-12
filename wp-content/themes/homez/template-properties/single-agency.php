<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

?>
<section id="primary" class="content-area inner">
	<main id="main" class="site-main content" role="main">

		<?php if ( have_posts() ) : ?>
			<?php echo WP_RealEstate_Template_Loader::get_template_part( 'single-agency/header' ); ?>
			<div class="clearfix <?php echo apply_filters('homez_agent_content_class', 'container');?>">
				<?php while ( have_posts() ) : the_post();
					$latitude = WP_RealEstate_Agency::get_post_meta( $post->ID, 'map_location_latitude', true );
					$longitude = WP_RealEstate_Agency::get_post_meta( $post->ID, 'map_location_longitude', true );
				?>
					<div class="single-agency-wrapper single-listing-wrapper single-listing-agent-agency" data-latitude="<?php echo esc_attr($latitude); ?>" data-longitude="<?php echo esc_attr($longitude); ?>">
						<?php echo WP_RealEstate_Template_Loader::get_template_part( 'content-single-agency' ); ?>
					</div>
				<?php endwhile; ?>

				<?php the_posts_pagination( array(
					'prev_text'     => '<i class="ti-angle-left"></i>',
					'next_text'     => '<i class="ti-angle-right"></i>',
					'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__( 'Page', 'homez' ) . ' </span>',
				) ); ?>
			</div>
		<?php else : ?>
			<div class="clearfix <?php echo apply_filters('homez_agent_content_class', 'container');?>">
				<?php get_template_part( 'content', 'none' ); ?>
			</div>
		<?php endif; ?>

	</main><!-- .site-main -->
</section><!-- .content-area -->
<?php get_footer();
