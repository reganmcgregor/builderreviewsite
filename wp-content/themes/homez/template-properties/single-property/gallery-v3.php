<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;

$obj_property_meta = WP_RealEstate_Property_Meta::get_instance($post->ID);

$gallery = $obj_property_meta->get_post_meta( 'gallery' );
if ( has_post_thumbnail() || ($gallery && is_array($gallery)) ) {
    $gallery_size = !empty($gallery_size) ? $gallery_size : '580x552';
    $gallery_second_size = !empty($gallery_second_size) ? $gallery_second_size : '200x190';
    $first_class = 'col-12';
    $second_class = 'col-sm-4 col-4';
    if ( $gallery && is_array($gallery) ) {
        $first_class = 'col-sm-6 c1 col-12';
        if ( count($gallery) == 1 ) {
            $second_class = 'col-12';
            $gallery_second_size = '580x552';
        } elseif ( count($gallery) == 2 ) {
            $second_class = 'col-12';
            $gallery_second_size = '548x271';
        }
    } else {
        $gallery_size = '1170x550';
    }
?>
<div class="property-detail-gallery v3">
    <div class="row row-10 wrapper">
        <?php if ( has_post_thumbnail() ) {
            $thumbnail_id = get_post_thumbnail_id($post);
        ?>
            <div class="<?php echo esc_attr($first_class); ?>">
                <div class="gallery-property-main-detail">
                    <a href="<?php echo esc_url( get_the_post_thumbnail_url($post, 'full') ); ?>" data-elementor-lightbox-slideshow="homez-gallery" class="p-popup-image">
                        <?php echo homez_get_attachment_thumbnail($thumbnail_id, $gallery_size);?>
                    </a>
                    <div class="gallery-metas d-flex">
                        <?php homez_property_display_featured_icon($post, true); ?>
                        <?php homez_property_display_label($post, true); ?>
                    </div>
                </div>
            </div>
        <?php } ?>

        <?php if ( $gallery && is_array($gallery) ) { ?>
            <div class="col-sm-6 c2 col-12">
                <div class="row row-10">
                    <?php $i=1; foreach ( $gallery as $id => $src ) {
                        
                        $additional_class = '';
                        if ( $i > 9 ) {
                            $additional_class = 'hidden';
                        }

                        $more_image_class = $more_image_html = '';
                        if ( $i == 9 && count($gallery) > 9 ) {
                            $more_image_html = '<div class="view-more-gallery circle">+'.(count($gallery) - 9).'</div>';
                            $more_image_class = 'view-more-image';
                        }
                    ?>
                        <div class="<?php echo esc_attr($second_class.' '.$additional_class); ?>">
                            <a href="<?php echo esc_url( $src ); ?>" data-elementor-lightbox-slideshow="homez-gallery" class="p-popup-image <?php echo esc_attr($more_image_class); ?>">
                                <?php
                                if ( $i <= 9 ) {
                                    echo homez_get_attachment_thumbnail( $id, $gallery_second_size );
                                    echo trim($more_image_html);
                                }
                                ?>
                            </a>
                        </div>
                    <?php $i++; } ?>
                </div>
            </div>
        <?php } ?>
    </div>

</div>
<?php }