<?php
get_header();
$sidebar_configs = homez_get_blog_layout_configs();
?>
	<?php 
    	$checksidebar = homez_get_config('blog_single_layout');
    	if($checksidebar == 'main'){
    ?>
		<section id="main-container" class="main-content-detail inner">
				<div id="main-content" class="clearfix">
					<div id="primary" class="content-area">
						<div id="content" class="site-content detail-post" role="main">
							<?php
								// Start the Loop.
								while ( have_posts() ) : the_post();

									/*
									 * Include the post format-specific template for the content. If you want to
									 * use this in a child theme, then include a file called called content-___.php
									 * (where ___ is the post format) and that will be used instead.
									 */
									get_template_part( 'template-posts/single/header-info' );?>
									<div class="max-800 container">
										<?php get_template_part( 'template-posts/single/inner-v2' );
										
						                // If comments are open or we have at least one comment, load up the comment template.
										if ( comments_open() || get_comments_number() ) :
											comments_template();
										endif;
									echo '</div>';
									// End the loop.
							    	endwhile;
							?>
						</div><!-- #content -->
					</div><!-- #primary -->
				</div>	
		</section>
	<?php }else{ ?>
		<?php homez_render_breadcrumbs(); ?>
		<section id="main-container" class="main-content-detail <?php echo apply_filters( 'homez_blog_content_class', 'container' ); ?> inner <?php echo trim($checksidebar); ?>">
			<?php homez_before_content( $sidebar_configs ); ?>
			<div class="row responsive-medium">

				<?php homez_display_sidebar_left( $sidebar_configs ); ?>

				<div id="main-content" class="col-xs-12 <?php echo esc_attr($sidebar_configs['main']['class']); ?> ">
					<div id="primary" class="content-area">
						<div id="content" class="site-content detail-post" role="main">
							<?php
								// Start the Loop.
								while ( have_posts() ) : the_post();

									/*
									 * Include the post format-specific template for the content. If you want to
									 * use this in a child theme, then include a file called called content-___.php
									 * (where ___ is the post format) and that will be used instead.
									 */
									get_template_part( 'template-posts/single/header-info-v2' );?>
									<div class="clearfix">
										<?php get_template_part( 'template-posts/single/inner-v2' );
										
						                // If comments are open or we have at least one comment, load up the comment template.
										if ( comments_open() || get_comments_number() ) :
											comments_template();
										endif;
									echo '</div>';

								// End the loop.
								endwhile;
							?>
						</div><!-- #content -->
					</div><!-- #primary -->
				</div>	
				
				<?php homez_display_sidebar_right( $sidebar_configs ); ?>
				
			</div>	
		</section>
	<?php } ?>

	<?php if ( homez_get_config('show_blog_related', false) ): ?>
		<?php get_template_part( 'template-parts/posts-related' ); ?>
	<?php endif; ?>
<?php get_footer(); ?>