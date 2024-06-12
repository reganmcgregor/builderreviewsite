<?php
$post_format = get_post_format();
global $post;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="inner">
    	<div class="entry-content-detail <?php echo esc_attr((!has_post_thumbnail())?'not-img-featured':'' ); ?>">
            <?php homez_post_categories_first($post); ?>
            <div class="top-detail-info clearfix">
                <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
                    <?php echo get_the_author(); ?>
                </a>
                <span class="date">
                    <?php the_time( get_option('date_format', 'd M, Y') ); ?>
                </span>
                <span class="comments"><i class="flaticon-customer-reviews"></i><?php comments_number( esc_html__('0 Comments', 'homez'), esc_html__('1 Comment', 'homez'), esc_html__('% Comments', 'homez') ); ?></span>
            </div>

            <?php if (get_the_title()) { ?>
                <h1 class="entry-title">
                    <?php the_title(); ?>
                </h1>
            <?php } ?>

            <?php if(has_post_thumbnail()) { ?>
                <div class="entry-thumb">
                    <?php
                        $thumb = homez_post_thumbnail();
                        echo trim($thumb);
                    ?>
                </div>
            <?php } ?>

        	<div class="single-info info-bottom">
                <div class="entry-description clearfix">
                    <?php
                        the_content();
                    ?>
                </div><!-- /entry-content -->
        		<?php
        		wp_link_pages( array(
        			'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'homez' ) . '</span>',
        			'after'       => '</div>',
        			'link_before' => '<span>',
        			'link_after'  => '</span>',
        			'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'homez' ) . ' </span>%',
        			'separator'   => '',
        		) );
        		?>
                <?php  
                    $posttags = get_the_tags();
                ?>
                <?php if( !empty($posttags) || homez_get_config('show_blog_social_share', false) ){ ?>
            		<div class="tag-social flex-middle-lg">
                        <?php if(!empty($posttags)){ ?>
                            <?php homez_post_tags(); ?>
                        <?php } ?>

                        <?php if( homez_get_config('show_blog_social_share', false) ) { ?>
                            <div class="ali-right">
                                 <?php get_template_part( 'template-parts/sharebox' ); ?>
                            </div>
                        <?php } ?>
            		</div>
                <?php } ?>
        	</div>

        </div>
    </div>
    <?php
        //Previous/next post navigation.
        the_post_navigation( array(
            'next_text' => 
                '<div class="inner">'.
                '<div class="navi">' . esc_html__( 'Next', 'homez' ) . ' <i class="flaticon-right-arrow"></i></div>'.
                '<span class="title-direct">%title</span></div>',
            'prev_text' => 
                '<div class="inner">'.
                '<div class="navi"><i class="flaticon-left-arrow"></i> ' . esc_html__( 'Prev', 'homez' ) . '</div>'.
                '<span class="title-direct">%title</span></div>',
        ) );
    ?>
</article>