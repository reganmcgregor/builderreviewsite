<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package WordPress
 * @subpackage Homez
 * @since Homez 1.0
 */
/*
*Template Name: 404 Page
*/
get_header();

$icon_url = homez_get_config('404_icon_img');
$bg_url = homez_get_config('404_bg_img');

?>
<section class="page-404">
	<div id="main-container" class="inner">
		<div id="main-content" class="main-page">
			<section class="error-404 not-found">
				<div class="container">
					<div class="content-inner row d-md-flex align-items-center">
						<div class="col-12 col-md-7">
							<div class="top-image">
								<?php if( !empty($bg_url) ) { ?>
									<img src="<?php echo esc_url( $bg_url); ?>" alt="<?php bloginfo( 'name' ); ?>">
								<?php }else{ ?>
									<img src="<?php echo esc_url( get_template_directory_uri().'/images/error.jpg'); ?>" alt="<?php bloginfo( 'name' ); ?>">
								<?php } ?>
							</div>
						</div>
						<div class="col-12 col-md-5">
							<div class="slogan">
								<div class="image-icon">
									<?php if( !empty($icon_url) ) { ?>
										<img src="<?php echo esc_url( $icon_url); ?>" alt="<?php bloginfo( 'name' ); ?>">
									<?php }else{ ?>
										<img src="<?php echo esc_url( get_template_directory_uri().'/images/icon-error.jpg'); ?>" alt="<?php bloginfo( 'name' ); ?>">
									<?php } ?>
								</div>
								<h4 class="title-big">
									<?php
									$title = homez_get_config('404_title');
									if ( !empty($title) ) {
										echo esc_html($title);
									} else {
										esc_html_e('Oh! Page Not Found', 'homez');
									}
									?>
								</h4>
							</div>
							<div class="description">
								<?php
								$description = homez_get_config('404_description');
								if ( !empty($description) ) {
									echo esc_html($description);
								} else {
									esc_html_e('The page you’re looking for isn’t available. Try to search again or use the go to.', 'homez');
								}
								?>
							</div>
							<div class="page-content">
								<div class="return">
									<a class="btn btn-dark" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e('Go back to Homepage','homez') ?><i class="flaticon-up-right-arrow next"></i></a>
								</div>
							</div><!-- .page-content -->
						</div>
					</div>
				</div>
			</section><!-- .error-404 -->
		</div><!-- .content-area -->
	</div>
</section>
<?php get_footer(); ?>