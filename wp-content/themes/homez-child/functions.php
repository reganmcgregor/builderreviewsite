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

function homez_property_display_author_name($post, $prefix, $echo = true) {
	$author_id = $post->post_author;
	ob_start();
	if ( $author_id ) {
		$author_url = '';
		if ( WP_RealEstate_User::is_agent($author_id) ) {
		    $agent_id = WP_RealEstate_User::get_agent_by_user_id($author_id);
		    $title = get_the_title($agent_id);
		    $author_url = get_permalink($agent_id);
		} elseif ( WP_RealEstate_User::is_agency($author_id) ) {
		    $agency_id = WP_RealEstate_User::get_agency_by_user_id($author_id);
		    $title = get_the_title($agency_id);
		    $author_url = get_permalink($agency_id);
		} else {
			$user_info = get_userdata($author_id);

		    $title = $user_info->display_name;
		}
		?>
        <div class="name-author">
            <?php if ($prefix) { ?>
                <?php echo esc_html($prefix);?>
            <?php  }?>
            <?php if ( $author_url ) { ?>
                <a href="<?php echo esc_url($author_url); ?>">
            <?php } ?>
                <?php echo trim($title); ?>
            <?php if ( $author_url ) { ?>
                </a>
            <?php } ?>
        </div>


	    <?php
	}
	$output = ob_get_clean();
    if ( $echo ) {
    	echo trim($output);
    } else {
    	return $output;
    }
}