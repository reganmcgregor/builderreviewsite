<?php
get_header();
$sidebar_configs = homez_get_blog_layout_configs();
$columns = homez_get_config('blog_columns', 1);
$layout = homez_get_config( 'blog_display_mode', 'list' );
homez_render_breadcrumbs();
$thumbsize = !isset($thumbsize) ? homez_get_config( 'blog_item_thumbsize', '770x450' ) : $thumbsize;
$get_style = '';
if ( defined('HOMEZ_DEMO_MODE') && HOMEZ_DEMO_MODE ) {
	if (!empty($_GET['style']) && ($_GET['style'] =='list') ){
	    $columns = 1;
	    $layout = 'list';
	} elseif (!empty($_GET['style']) && ($_GET['style'] =='gridfull') ){
		$columns = 3;
	    $layout = 'grid';
	    $sidebar_configs['main'] = array( 'class' => 'col-12' );
	    $sidebar_configs['right']['class'] = $sidebar_configs['left']['class'] = 'hidden';
	    $thumbsize = '370x260';
	} elseif (!empty($_GET['style']) && ($_GET['style'] =='list2') ){
		$columns = 1;
	    $layout = 'list-v2';
	} else {
		$_GET['style']="";
	}
}
if ( isset($_GET['style']) ) {
	$get_style = $_GET['style'];
}
?>
<section id="main-container" class="main-content home-page-default <?php echo apply_filters('homez_blog_content_class', 'container');?> inner">
	<?php homez_before_content( $sidebar_configs ); ?>
	<div class="row responsive-medium">
		<?php homez_display_sidebar_left( $sidebar_configs ); ?>

		<div id="main-content" class="col-12 <?php echo esc_attr($sidebar_configs['main']['class']); ?>">
			<div id="main" class="site-main layout-blog" role="main">

			<?php if ( have_posts() ) : ?>

				<header class="page-header d-none">
					<?php
						the_archive_title( '<h1 class="page-title">', '</h1>' );
						the_archive_description( '<div class="taxonomy-description">', '</div>' );
					?>
				</header><!-- .page-header -->

				<?php
				if ( (empty($sidebar_configs['left']) && empty($sidebar_configs['right']) && homez_get_config('blog_archive_top_categories', false)) || ($get_style =='gridfull') )	{
				?>
					<div class="blog-header-categories">
						<?php
						$terms = get_terms(array(
							'taxonomy' => 'category',
							'hide_empty' => true,
						));
						if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
							$selected = '';
							if ( is_category() ) {
								global $wp_query;
								$term =	$wp_query->queried_object;
								if ( isset( $term->term_id) ) {
									$selected = $term->term_id;
								}
							}
							?>
						    <ul class="categories-blog-list">
							    <?php foreach ( $terms as $term ) { ?>
							        <li><a href="<?php echo get_term_link($term); ?>" class="<?php echo esc_attr($term->term_id == $selected ? 'active' : ''); ?>"><?php echo esc_html($term->name); ?></a></li>
							    <?php } ?>
						    </ul>
						<?php } ?>
					</div>
				<?php } ?>

				<?php
				get_template_part( 'template-posts/layouts/'.$layout, null, array('columns' => $columns, 'thumbsize' => $thumbsize) );

				// Previous/next page navigation.
				homez_paging_nav();

			// If no content, include the "No posts found" template.
			else :
				get_template_part( 'template-posts/content', 'none' );

			endif;
			?>

			</div><!-- .site-main -->
		</div><!-- .content-area -->
		
		<?php homez_display_sidebar_right( $sidebar_configs ); ?>
		
	</div>
</section>
<?php get_footer(); ?>