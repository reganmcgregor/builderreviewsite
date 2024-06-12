<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;

$meta_obj = WP_RealEstate_Property_Meta::get_instance($post->ID);

$gallery = $meta_obj->get_post_meta( 'gallery' );
$property_layout = homez_get_property_layout_type();
if ($property_layout == 'v8'){
    $items = 12;
} else {
    $items = 8;
}
?>
<div class="property-detail-gallery v6">
<?php
if ( has_post_thumbnail() || ($gallery && is_array($gallery)) ) {
    $gallery_size = !empty($gallery_size) ? $gallery_size : '770x500';
    $gallery_second_size = !empty($gallery_second_size) ? $gallery_second_size : '90x82';
?>

    <div class="slick-carousel slick-carousel-gallery-main no-gap" data-carousel="slick" data-items="1" data-medium="1" data-small="1" data-smallest="1" data-pagination="false" data-nav="false" data-autoplay="false" data-slickparent="true">
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
    
    <div class="slick-carousel gap-10 bottom-gallery" data-carousel="slick" data-items="<?php echo esc_attr($items); ?>" data-medium="6" data-small="5" data-smallest="5" data-pagination="false" data-nav="false" data-autoplay="false" data-asnavfor=".slick-carousel-gallery-main" data-slidestoscroll="1" data-focusonselect="true">
        <?php if ( has_post_thumbnail() ) {
            $thumbnail_id = get_post_thumbnail_id($post); ?>
            <div class="item">
                <?php echo homez_get_attachment_thumbnail($thumbnail_id, $gallery_second_size); ?>
            </div>
        <?php } ?>

        <?php
        if ( $gallery && is_array($gallery) ) {
            foreach ( $gallery as $id => $src ) { ?>
                <div class="item">
                   <?php echo homez_get_attachment_thumbnail( $id, $gallery_second_size ); ?>
                </div>
            <?php }
        } ?>
    </div>

<?php } ?>

</div>