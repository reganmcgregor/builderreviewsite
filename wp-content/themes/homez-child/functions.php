<?php

function homez_child_enqueue_styles() {
	wp_enqueue_style( 'homez-child-style', get_stylesheet_uri() );
}

add_action( 'wp_enqueue_scripts', 'homez_child_enqueue_styles', 200 );

function homez_property_display_type_label($post, $echo = true, $color = true) {
    $types = get_the_terms( $post->ID, 'property_type' );
    ob_start();
    if ( $types ) {
        foreach ($types as $term) {
            $text_color = get_term_meta( $term->term_id, 'text_color', true );
            $bg_color = get_term_meta( $term->term_id, 'bg_color', true );
            $style = '';
            if ( $color ) {
                if ( $bg_color ) {
                    $style .= 'background: '.$bg_color.';';
                }
                if ( $text_color ) {
                    $style .= 'color: '.$text_color.';';
                }
            }
            ?>
                <a class="type-property-label" href="<?php echo esc_url(get_term_link($term)); ?>" style="<?php echo esc_attr($style); ?>"><?php echo esc_html($term->name); ?></a>
            <?php
        }
    }
    $output = ob_get_clean();
    if ( $echo ) {
        echo trim($output);
    } else {
        return $output;
    }
}