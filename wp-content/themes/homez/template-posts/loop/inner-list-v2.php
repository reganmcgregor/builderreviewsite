<?php 
global $post;
$thumbsize = !isset($thumbsize) ? homez_get_config( 'blog_item_thumbsize', '280x240' ) : $thumbsize;
$thumb = homez_display_post_thumb($thumbsize);
?>
<article <?php post_class('post post-layout post-list-item v2'); ?>>
    <div class="list-inner d-flex align-items-center">
        <?php
            if ( !empty($thumb) ) {
                ?>
                <div class="top-image flex-shrink-0 position-relative">
                    <?php
                        echo trim($thumb);
                    ?>
                    <div class="date flex-column d-inline-flex align-items-center justify-content-center">
                        <div class="date-m"><?php the_time('M'); ?></div>
                        <div class="date-d"><?php the_time('d'); ?></div>
                    </div>
                 </div>
                <?php
            }
        ?>
        <div class="col-content position-relative flex-grow-1">
            <?php if ( empty($thumb) ) { ?>
                <div class="date flex-column d-inline-flex align-items-center justify-content-center">
                    <div class="date-m"><?php the_time('M'); ?></div>
                    <div class="date-d"><?php the_time('d'); ?></div>
                </div>
            <?php } ?>
            <?php homez_post_categories_first($post); ?>
            <?php if (get_the_title()) { ?>
                <h4 class="entry-title">
                    <?php if ( is_sticky() && is_home() && ! is_paged() ) : ?>
                        <div class="stick-icon text-theme"><i class="ti-pin2"></i></div>
                    <?php endif; ?>
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h4>
            <?php } ?>
            <div class="description"><?php echo homez_substring( get_the_excerpt(),15, '...' ); ?></div>
        </div>
    </div>
</article>