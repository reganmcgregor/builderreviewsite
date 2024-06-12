<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;

$meta_obj = WP_RealEstate_Property_Meta::get_instance($post->ID);

$gallery = $meta_obj->get_post_meta( 'gallery' );
if ( has_post_thumbnail() || ($gallery && is_array($gallery)) ) {
    $gallery_size = !empty($gallery_size) ? $gallery_size : '1170x600';
?>
<div class="property-detail-gallery v4">
    <div class="inner">
        <div class="slick-carousel gap-10" data-carousel="slick" data-items="1" data-large="1" data-medium="1" data-small="1" data-smallest="1" data-pagination="false" data-nav="true" data-infinite="true" data-autoplay="true">
            <?php if ( has_post_thumbnail() ) {
                $thumbnail_id = get_post_thumbnail_id($post);
            ?>
            <div class="item">
                <a href="<?php echo esc_url( get_the_post_thumbnail_url($post, 'full') ); ?>" data-elementor-lightbox-slideshow="homez-gallery" class="p-popup-image">
                    <?php echo homez_get_attachment_thumbnail($thumbnail_id, $gallery_size);?>
                </a>
            </div>
            <?php } ?>

            <?php
            if ( $gallery && is_array($gallery) ) {
                foreach ( $gallery as $id => $src ) { ?>
                    <div class="item">
                        <a href="<?php echo esc_url( $src ); ?>" data-elementor-lightbox-slideshow="homez-gallery" class="p-popup-image">
                            <?php echo homez_get_attachment_thumbnail( $id, $gallery_size );?>
                        </a>
                    </div>
                <?php } 
            } ?>
        </div>
    </div>
</div>
<?php }