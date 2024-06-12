<?php 
global $post;
$thumbsize = !isset($thumbsize) ? homez_get_config( 'blog_item_thumbsize', '770x450' ) : $thumbsize;
$thumb = homez_display_post_thumb($thumbsize);
?>
<article <?php post_class('post post-layout post-grid'); ?>>
    <div class="list-inner">
        <?php
            if ( !empty($thumb) ) {
                ?>
                <div class="top-image">
                    <?php
                        echo trim($thumb);
                    ?>
                 </div>
                <?php
            }
        ?>
        <div class="col-content position-relative">
            <div class="date flex-column d-inline-flex align-items-center justify-content-center">
                <div class="date-m"><?php the_time('M'); ?></div>
                <div class="date-d"><?php the_time('d'); ?></div>
            </div>
            <?php homez_post_categories_first($post); ?>
            <?php if (get_the_title()) { ?>
                <h4 class="entry-title">
                    <?php if ( is_sticky() && is_home() && ! is_paged() ) : ?>
                        <div class="stick-icon text-theme"><i class="ti-pin2"></i></div>
                    <?php endif; ?>
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h4>
            <?php } ?>
        </div>
    </div>
</article>