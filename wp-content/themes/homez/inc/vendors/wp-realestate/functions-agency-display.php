<?php

function homez_agency_display_image($post, $size = 'thumbnail') {
	?>
    <div class="agency-logo agency-thumbnail">
        <a href="<?php echo esc_url( get_permalink($post) ); ?>">
            <?php if ( has_post_thumbnail($post->ID) ) { ?>
                <?php
                $post_thumbnail_id = get_post_thumbnail_id($post->ID);
                echo homez_get_attachment_thumbnail( $post_thumbnail_id, $size );

                ?>

            <?php } ?>
        </a>
    </div>
    <?php
}

function homez_agency_display_type($post, $display_type = 'no-title', $echo = true) {
    $categories = get_the_terms( $post->ID, 'agency_category' );
    ob_start();
    $number = 1;
    if ( $categories ) {
        ?>
        <div class="agency-category">
            <?php
            if ( $display_type == 'title' ) {
                ?>
                <div class="agency-category with-title">
                    <strong><?php esc_html_e('Property Type:', 'homez'); ?></strong>
                <?php
            } elseif ($display_type == 'icon') {
                ?>
                <div class="agency-category with-icon">
                    <i class="ti-calendar"></i>
            <?php
            } else {
                ?>
                <div class="agency-category with-no-title">
                <?php
            }
                foreach ($categories as $term) {
                    ?>
                        <a class="category-agency" href="<?php echo esc_url(get_term_link($term)); ?>"><?php echo esc_html($term->name); ?></a><?php if($number < count($categories)) echo trim(', ');?>
                    <?php  $number++;
                }
            ?>
            </div>
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

function homez_agency_display_full_location($post, $display_type = 'no-icon-title', $echo = true) {
	$location = WP_RealEstate_Agency::get_post_meta( $post->ID, 'address', true );
	if ( empty($location) ) {
		$location = WP_RealEstate_Agency::get_post_meta( $post->ID, 'map_location_address', true );
	}
	ob_start();
	if ( $location ) {
		
		if ( $display_type == 'icon' ) {
			?>
			<div class="agency-location with-icon"><i class="ti-location-pin"></i> <a href="<?php echo esc_url( '//maps.google.com/maps?q=' . urlencode( strip_tags( $location ) ) . '&zoom=14&size=512x512&maptype=roadmap&sensor=false' ); ?>" target="_blank"><?php echo esc_html($location); ?></a></div>
			<?php
		} elseif ( $display_type == 'title' ) {
			?>
			<div class="agency-location with-title">
				<strong><?php esc_html_e('Location:', 'homez'); ?></strong> <span><a href="<?php echo esc_url( '//maps.google.com/maps?q=' . urlencode( strip_tags( $location ) ) . '&zoom=14&size=512x512&maptype=roadmap&sensor=false' ); ?>" target="_blank"><?php echo esc_html($location); ?></a></span>
			</div>
			<?php
		} else {
			?>
			<div class="agency-location"><a href="<?php echo esc_url( '//maps.google.com/maps?q=' . urlencode( strip_tags( $location ) ) . '&zoom=14&size=512x512&maptype=roadmap&sensor=false' ); ?>" target="_blank"><?php echo esc_html($location); ?></a></div>
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

function homez_agency_display_nb_properties($post, $display_type = 'no-title') {
    $user_id = WP_RealEstate_User::get_user_by_agency_id($post->ID);
    $args = array(
            'post_type' => 'property',
            'post_per_page' => -1,
            'post_status' => 'publish',
            'fields' => 'ids',
            'author' => $user_id
        );
    $properties = WP_RealEstate_Query::get_posts($args);
    $count_properties = $properties->found_posts;
    ?>
    <?php if($display_type == 'title') { ?>
        <div class="property-wrapper">
            <span class="with-title"><?php esc_html_e('Property: ', 'homez'); ?></span>
            <span class="nb-property">
                <?php echo sprintf(_n('%d Property', '%d Properties', intval($count_properties), 'homez'), intval($count_properties)); ?>
            </span>
        </div>
    <?php } else { ?>
        <span class="nb-property">
            <?php echo sprintf(_n('%d Property', '%d Properties', intval($count_properties), 'homez'), intval($count_properties)); ?>
        </span>
    <?php } ?>
    <?php
}

function homez_agency_display_featured_icon($post) {
	$featured = WP_RealEstate_Agency::get_post_meta( $post->ID, 'featured', true );
	if ( $featured ) { ?>
        <span class="featured featured-icon" data-toggle="tooltip" title="<?php esc_attr_e('featured', 'homez'); ?>"><i class="fas fa-star"></i></span>
    <?php }
}

function homez_agency_display_phone($post, $display_type = 'no-title', $echo = true, $always_show_phone = false) {
	$phone = WP_RealEstate_Agency::get_post_meta( $post->ID, 'phone' );
	ob_start();
	if ( $phone ) {
        $show_full = homez_get_config('listing_show_full_phone', false);
        $hide_phone = $show_full ? false : true;
        $hide_phone = apply_filters('homez_phone_hide_number', $hide_phone );
        if ( $always_show_phone ) {
            $hide_phone = false;
        }
        
        $add_class = '';
        if ( $hide_phone ) {
            $add_class = 'phone-hide';
        }
        if ( $display_type == 'title' ) {
            ?>
            <div class="phone-wrapper agency-phone <?php echo esc_attr($add_class); ?>">
                <span class="with-title"><?php esc_html_e('Phone: ', 'homez'); ?></span>
            <?php
        } elseif ($display_type == 'icon') {
            ?>
            <div class="phone-wrapper agency-phone <?php echo esc_attr($add_class); ?>">
                <span class="with-icon">
                    <i class="flaticon-call"></i>
                </span>
        <?php
        } else {
            ?>
            <div class="phone-wrapper agency-phone <?php echo esc_attr($add_class); ?>">
            <?php
        }
        ?>
            <a class="phone" href="tel:<?php echo trim($phone); ?>"><?php echo trim($phone); ?></a>
            <?php if ( $hide_phone ) {
                $dispnum = substr($phone, 0, (strlen($phone)-3) ) . str_repeat("*", 3);
            ?>
                <span class="phone-show" onclick="this.parentNode.classList.add('show');"><?php echo trim($dispnum); ?> <span><?php esc_html_e('show', 'homez'); ?></span></span>
            <?php } ?>
        </div>
    <?php }
    $output = ob_get_clean();
    if ( $echo ) {
    	echo trim($output);
    } else {
    	return $output;
    }
}

function homez_agency_display_fax($post, $display_type = 'no-title', $echo = true) {
    $fax = WP_RealEstate_Agency::get_post_meta( $post->ID, 'fax' );
    ob_start();
    if ( $fax ) {
        if ( $display_type == 'title' ) {
            ?>
            <div class="agency-fax">
                <span class="with-title"><?php esc_html_e('Fax:', 'homez'); ?></span>
            <?php
        } elseif ($display_type == 'icon') {
            ?>
            <div class="agency-fax">
                <span class="with-icon">
                    <i class="flaticon-printer"></i>
                </span>
        <?php
        } else {
            ?>
            <div class="agency-fax">
            <?php
        }
        ?>
            <span class="inner">
                <?php echo trim($fax); ?>
            </span>
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

function homez_agency_display_email($post, $display_type = 'no-title', $echo = true) {
	$email = WP_RealEstate_Agency::get_post_meta( $post->ID, 'email' );
	ob_start();
	if ( $email ) {
        if ( $display_type == 'title' ) {
            ?>
            <div class="agency-email">
                <span class="with-title"><?php esc_html_e('Email:', 'homez'); ?></span>
            <?php
        } elseif ($display_type == 'icon') {
            ?>
            <div class="agency-email">
                <i class="ti-email"></i>
        <?php
        } else {
            ?>
            <div class="agency-email">
            <?php
        }
        ?>
            <a href="mailto:<?php echo trim($email); ?>"><?php echo trim($email); ?></a>
        </div>
    <?php }
    $output = ob_get_clean();
    if ( $echo ) {
    	echo trim($output);
    } else {
    	return $output;
    }
}

function homez_agency_display_website($post, $display_type = 'no-title', $echo = true) {
    $website = WP_RealEstate_Agency::get_post_meta( $post->ID, 'website' );
    ob_start();
    if ( $website ) {
        if ( $display_type == 'title' ) {
            ?>
            <div class="agency-website">
                <span class="with-title"><?php esc_html_e('Website:', 'homez'); ?></span>
            <?php
        } elseif ($display_type == 'icon') {
            ?>
            <div class="agency-website">
                <i class="ti-world"></i>
        <?php
        } else {
            ?>
            <div class="agency-website">
            <?php
        }
        ?>
            <a href="<?php echo esc_url($website); ?>" target="_blank"><?php echo trim($website); ?></a>
        </div>
    <?php }
    $output = ob_get_clean();
    if ( $echo ) {
        echo trim($output);
    } else {
        return $output;
    }
}

function homez_agency_display_meta_data($post, $meta_key, $title = '', $icon = '', $echo = true) {
    $meta_value = WP_RealEstate_Agency::get_post_meta( $post->ID, $meta_key );
    ob_start();
    if ( $meta_value ) {
        ?>
        <div class="agency-meta">
            <?php
            if ( $title ) {
                ?>
                    <span class="with-title"><?php echo trim($title); ?></span>
                <?php
            }
            if ( $icon ) {
                ?>
                <span class="with-icon">
                    <i class="<?php echo esc_attr($icon); ?>"></i>
                </span>
            <?php } ?>
            
            <?php echo trim($meta_value); ?>
            
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


function homez_agency_display_rating_short($post) {
    if ( comments_open($post) || get_comments_number($post) ) {
        $average_rating = get_post_meta( $post->ID, '_average_rating', true );
        $nb_reviews = WP_RealEstate_Review::get_total_reviews($post->ID);
        ?>
        <?php if($average_rating > 0) { ?>
            <div class="review-author d-flex align-items-center">
                <i class="fas fa-star"></i>
                <span class="nb-pre-review"><?php echo number_format($average_rating, 1, ".",""); ?></span>
            </div>
        <?php } ?>
        <?php
    }
}

function homez_agency_display_rating($post) {
    if ( comments_open($post) || get_comments_number($post) ) {
        $average_rating = get_post_meta( $post->ID, '_average_rating', true );
        $nb_reviews = WP_RealEstate_Review::get_total_reviews($post->ID);
        ?>
        <?php if($average_rating > 0) { ?>
            <div class="review-author d-flex align-items-center">
                <i class="fas fa-star"></i>
                <span class="nb-pre-review"><?php echo number_format($average_rating, 1, ".",""); ?></span>
                <span class="space">•</span>
                <?php echo sprintf(esc_html__('%d Reviews', 'homez'), $nb_reviews); ?>
            </div>
        <?php } ?>
        <?php
    }
}

function homez_agency_display_socials($post, $display_type = 'no-title', $echo = true) {
    $socials = WP_RealEstate_Agency::get_post_meta( $post->ID, 'socials' );
    $output = '';
    if ( $socials ) {
        foreach ($socials as $social) {
            if ( !empty($social['network']) && !empty($social['url']) ) {
                $output .= '<a href="'.esc_url($social['url']).'" target="_blank"><i class="'.esc_attr($social['network']).'"></i></a>';
            }
        }
    }
    
    if ( $output ) {
        ob_start();
        if ( $display_type == 'title' ) {
            ?>
            <div class="agency-socials with-title">
                <span class="with-title"><?php esc_html_e('Socials:', 'homez'); ?></span>
            <?php
        } else {
            ?>
            <div class="agency-socials">
            <?php
        }
        ?>
            <?php echo trim($output); ?>
        </div>
        <?php
        $output = ob_get_clean();
    }

    if ( $echo ) {
        echo trim($output);
    } else {
        return $output;
    }
}

function homez_agency_display_member_since($post, $display_type = 'no-title', $echo = true) {
    $date = get_the_date(get_option('date_format'), $post);
    ob_start();
    if ( $date ) {
        if ( $display_type == 'title' ) {
            ?>
            <div class="agent-date">
                <span class="with-title"><?php esc_html_e('Member since', 'homez'); ?></span>
            <?php
        } elseif ($display_type == 'icon') {
            ?>
            <div class="agent-date">
                <i class="ti-world"></i>
        <?php
        } else {
            ?>
            <div class="agent-date">
            <?php
        }
        ?>
            <?php echo trim($date); ?>
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

function homez_agency_display_properties($post, $echo = true) {
    $count = 0;
    $agents = WP_RealEstate_Query::get_agency_agents( $post->ID, array('fields' => 'ids') );
    if ( !empty($agents->posts) ) {
        $loop = WP_RealEstate_Query::get_agents_properties(array(
            'agent_ids' => $agents->posts,
            'post_per_page' => 1,
            'fields' => 'ids'
        ));
        if ( !empty($loop) ) {
            $count = $loop->found_posts;
        }
    }
    $output = '<div class="number-properties">'.sprintf(_n('%d Property', '%d Properties', $count, 'homez'), $count).'</div>';
    if ( $echo ) {
        echo trim($output);
    } else {
        return $output;
    }
}