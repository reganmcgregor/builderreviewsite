<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;

$amenities = get_the_terms($post->ID, 'property_amenity');
?>

<?php if ( ! empty( $amenities ) ) : ?>
    <div class="property-section property-amenities">
        <h3 class="title"><?php esc_html_e('Features', 'homez'); ?></h3>
        <ul class="columns-gap">
            <?php foreach ( $amenities as $amenity ) : ?>
                <li class="yes">
                    <?php
                        $icon_font_value = get_term_meta( $amenity->term_id, 'apus_icon_font', true );
                        if ( !empty($icon_font_value) ) {
                            ?>
                            <i class="<?php echo esc_attr($icon_font_value); ?>"></i>
                            <?php
                        }
                        echo esc_html( $amenity->name );
                    ?>  
                </li>
            <?php endforeach; ?>
        </ul>

        <?php do_action('wp-realestate-single-property-amenities', $post); ?>
    </div><!-- /.property-amenities -->
<?php endif; ?>