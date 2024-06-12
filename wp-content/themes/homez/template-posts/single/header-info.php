<?php
$post_format = get_post_format();
global $post;
?>
<div class="entry-content-detail header-info-blog">
    <div class="container">
        <?php if (get_the_title()) { ?>
            <h1 class="entry-title">
                <?php the_title(); ?>
            </h1>
        <?php } ?>
        
        <div class="top-detail-info d-flex flex-wrap align-items-center">
            <div class="author">
                <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
                    <?php echo homez_get_avatar( get_the_author_meta( 'ID' ),40 ); ?>
                    <?php echo get_the_author(); ?>
                </a>
            </div>
            <?php homez_post_categories($post); ?>
            <div class="date">
                <?php the_time( get_option('date_format', 'd M, Y') ); ?>
            </div>
        </div>
    </div>
    <?php if(has_post_thumbnail()) { ?>
        <div class="entry-thumb text-center">
            <?php
                $thumb = homez_post_thumbnail();
                echo trim($thumb);
            ?>
        </div>
    <?php } ?>
</div>