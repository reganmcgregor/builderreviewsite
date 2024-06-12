<?php

function homez_property_display_image($post, $size = 'thumbnail') {
	?>
    <div class="image-thumbnail">
        <a class="property-image" href="<?php echo esc_url( get_permalink($post) ); ?>">
        	<?php
        	if ( has_post_thumbnail($post->ID) ) {
        		$post_thumbnail_id = get_post_thumbnail_id($post->ID);
        		echo homez_get_attachment_thumbnail( $post_thumbnail_id, $size );
        	} else {
        		?>
        		<img src="<?php echo esc_url(homez_placeholder_img_src()); ?>" alt="<?php echo esc_attr($post->post_title); ?>">
        		<?php
        	}
        	?>
        </a>
    </div>
    <?php
}

function homez_property_display_gallery($post, $size = 'thumbnail') {
	if ( !homez_get_config('properties_gallery', true) ) {
		return;
	}
	$obj_property_meta = WP_RealEstate_Property_Meta::get_instance($post->ID);

	$gallery = $obj_property_meta->get_post_meta( 'gallery' );
	if ( has_post_thumbnail() || ($gallery && is_array($gallery)) ) {
		$images = [];
		if ( has_post_thumbnail() ) {
            $images[] = get_the_post_thumbnail_url($post, $size);
        }

        if ( empty($gallery) || !is_array($gallery) ) {
        	return;
        }
        foreach ( $gallery as $id => $src ) {
        	$img = wp_get_attachment_image_url($id, $size);
        	if ( $img ) {
        		$images[] = $img;
        	}
        }

        echo 'data-images="'.esc_attr(json_encode($images)).'"';
	}
}

function homez_property_display_author($post, $display_type = 'logo', $echo = true) {
	$author_id = $post->post_author;
	ob_start();
	if ( $author_id ) {
		$author_url = '';
		if ( WP_RealEstate_User::is_agent($author_id) ) {
		    $agent_id = WP_RealEstate_User::get_agent_by_user_id($author_id);
		    if ( has_post_thumbnail($agent_id) ) {
		        $post_thumbnail_id = get_post_thumbnail_id($agent_id);
        		$logo = homez_get_attachment_thumbnail( $post_thumbnail_id, 'thumbnail' );
		    }
		    $title = get_the_title($agent_id);
		    $author_url = get_permalink($agent_id);
		} elseif ( WP_RealEstate_User::is_agency($author_id) ) {
		    $agency_id = WP_RealEstate_User::get_agency_by_user_id($author_id);
		    if ( has_post_thumbnail($agency_id) ) {
		        $post_thumbnail_id = get_post_thumbnail_id($agency_id);
        		$logo = homez_get_attachment_thumbnail( $post_thumbnail_id, 'thumbnail' );
		    }
		    $title = get_the_title($agency_id);
		    $author_url = get_permalink($agency_id);
		} else {
			$user_info = get_userdata($author_id);
			
			$logo = homez_get_avatar( $author_id, 80 );

		    $title = $user_info->display_name;
		}
		?>
	        <div class="avatar-wrapper d-flex align-items-center">
            	<?php if ($display_type == 'logo' || $display_type == 'all') { ?>
					<div class="avatar-img flex-shrink-0">
						<?php if ( $author_url ) { ?>
							<a href="<?php echo esc_url($author_url); ?>">
						<?php } ?>
							<?php echo trim($logo); ?>
						<?php if ( $author_url ) { ?>
							</a>
						<?php } ?>
					</div>
				<?php } ?>
				<?php if ($display_type == 'all') { ?>
					<div class="name-author flex-grow-1">
						<?php if ( $author_url ) { ?>
							<a href="<?php echo esc_url($author_url); ?>">
						<?php } ?>
	                		<?php echo trim($title); ?>
	                	<?php if ( $author_url ) { ?>
							</a>
						<?php } ?>
	                </div>
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

function homez_property_display_label($post, $echo = true) {
	$labels = get_the_terms( $post->ID, 'property_label' );
	ob_start();
	if ( $labels ) {
		foreach ($labels as $term) {
			$text_color = get_term_meta( $term->term_id, 'text_color', true );
			$bg_color = get_term_meta( $term->term_id, 'bg_color', true );
			$style = '';
			if ( $bg_color ) {
				$style .= 'background: '.$bg_color.';';
			}
			if ( $text_color ) {
				$style .= 'color: '.$text_color.';';
			}
			?>
            	<a class="label-property-label" href="<?php echo esc_url(get_term_link($term)); ?>" style="<?php echo esc_attr($style); ?>"><?php echo esc_html($term->name); ?></a>
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

function homez_property_display_status_label($post, $echo = true, $color = true) {
	$statuses = get_the_terms( $post->ID, 'property_status' );
	ob_start();
	if ( $statuses ) {
		foreach ($statuses as $term) {
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
            	<a class="status-property-label" href="<?php echo esc_url(get_term_link($term)); ?>" style="<?php echo esc_attr($style); ?>"><?php echo esc_html($term->name); ?></a>
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

function homez_property_display_status($post, $display_type = 'no-title', $echo = true) {
	$statuses = get_the_terms( $post->ID, 'property_status' );
	ob_start();
	$i = 1;
	if ( $statuses ) {
		?>
		<div class="status-property">
			<?php
			if ( $display_type == 'title' ) {
				$title = $obj_property_meta->get_post_meta_title( 'status' );
				?>
				<div class="property-status with-title">
					<strong><?php echo trim($title); ?>:</strong>
				<?php
			} elseif ($display_type == 'icon') {
				?>
				<div class="property-status with-icon">
					<i class="ti-home"></i>
			<?php
			} else {
				?>
				<div class="property-status">
				<?php
			}
				foreach ($statuses as $term) {
					$text_color = get_term_meta( $term->term_id, 'text_color', true );
					$bg_color = get_term_meta( $term->term_id, 'bg_color', true );
					$style = '';
					if ( $bg_color ) {
						$style .= 'background: '.$bg_color.';';
					}
					if ( $text_color ) {
						$style .= 'color: '.$text_color.';';
					}
					?>
		            	<a class="status-property" href="<?php echo esc_url(get_term_link($term)); ?>" style="<?php echo esc_attr($style); ?>"><?php echo esc_html($term->name); ?></a><?php if( $i < count($statuses) ) { ?> ,<?php } ?>
		        	<?php
		        	$i++;
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

function homez_property_display_type($post, $display_type = 'no-title', $echo = true) {
	$types = get_the_terms( $post->ID, 'property_type' );
	ob_start();
	$number = 1;
	if ( $types && ! is_wp_error( $types ) ) {
		?>
		<div class="property-type">
			<?php
			if ( $display_type == 'title' ) {
				$title = $obj_property_meta->get_post_meta_title( 'type' );
				?>
				<div class="property-type with-title">
					<strong><?php echo trim($title); ?>:</strong>
				<?php
			} elseif ($display_type == 'icon') {
				?>
				<div class="property-type with-icon">
					<i class="ti-calendar"></i>
			<?php
			} else {
				?>
				<div class="property-type with-no-title">
				<?php
			}
				foreach ($types as $term) {
					$color = get_term_meta( $term->term_id, '_color', true );
					$style = '';
					if ( $color ) {
						$style = 'color: '.$color;
					}
					?>
		            	<a class="type-property" href="<?php echo esc_url(get_term_link($term)); ?>" style="<?php echo esc_attr($style); ?>"><?php echo esc_html($term->name); ?></a><?php if($number < count($types)) echo trim(', ');?>
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

function homez_property_display_short_location($post, $echo = true) {
	$locations = get_the_terms( $post->ID, 'property_location' );
	ob_start();
	if ( $locations ) {
		?>
		<div class="property-location">
            <i class="flaticon-location-pin"></i>
            <?php $i=1; foreach ($locations as $term) { ?>
                <a href="<?php echo esc_url(get_term_link($term)); ?>"><?php echo esc_html($term->name); ?></a><?php echo esc_html( $i < count($locations) ? ', ' : '' ); ?>
            <?php $i++; } ?>
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

function homez_property_display_full_location($post, $display_type = 'no-icon-title', $echo = true) {
	$obj_property_meta = WP_RealEstate_Property_Meta::get_instance($post->ID);

	$location = $obj_property_meta->get_post_meta( 'address' );
	if ( empty($location) ) {
		$location = $obj_property_meta->get_post_meta( 'map_location_address' );
	}
	ob_start();
	if ( $location ) {
		if ( $display_type == 'icon' ) {
			?>
			<div class="property-location with-icon"><i class="flaticon-map"></i> <a href="<?php echo esc_url( '//maps.google.com/maps?q=' . urlencode( strip_tags( $location ) ) . '&zoom=14&size=512x512&maptype=roadmap&sensor=false' ); ?>" target="_blank"><?php echo esc_html($location); ?></a></div>
			<?php
		} elseif ( $display_type == 'title' ) {
			?>
			<div class="property-location with-title">
				<strong><?php esc_html_e('Location:', 'homez'); ?></strong> <a href="<?php echo esc_url( '//maps.google.com/maps?q=' . urlencode( strip_tags( $location ) ) . '&zoom=14&size=512x512&maptype=roadmap&sensor=false' ); ?>" target="_blank"><?php echo esc_html($location); ?></a>
			</div>
			<?php
		} else {
			?>
			<div class="property-location"><a href="<?php echo esc_url( '//maps.google.com/maps?q=' . urlencode( strip_tags( $location ) ) . '&zoom=14&size=512x512&maptype=roadmap&sensor=false' ); ?>" target="_blank"><?php echo esc_html($location); ?></a></div>
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

function homez_property_display_full_location_without_url($post_id, $display_type = 'no-icon-title', $echo = true) {
	if ( is_object($post_id) ) {
		$post_id = $post_id->ID;
	}
	$obj_property_meta = WP_RealEstate_Property_Meta::get_instance($post_id);

	$location = $obj_property_meta->get_post_meta( 'address' );
	if ( empty($location) ) {
		$location = $obj_property_meta->get_post_meta( 'map_location_address' );
	}
	ob_start();
	if ( $location ) {
		if ( $display_type == 'icon' ) {
			?>
			<div class="property-location with-icon"><i class="flaticon-map"></i> <?php echo esc_html($location); ?></div>
			<?php
		} elseif ( $display_type == 'title' ) {
			?>
			<div class="property-location with-title">
				<strong><?php esc_html_e('Location:', 'homez'); ?></strong> <?php echo esc_html($location); ?>
			</div>
			<?php
		} else {
			?>
			<div class="property-location"><<?php echo esc_html($location); ?></div>
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

function homez_property_display_location_map_icon($post, $echo = true) {
	$obj_property_meta = WP_RealEstate_Property_Meta::get_instance($post->ID);

	$location = $obj_property_meta->get_post_meta( 'address' );
	if ( empty($location) ) {
		$location = $obj_property_meta->get_post_meta( 'map_location_address' );
	}
	ob_start();
	if ( $location ) {
		?>
		<a class="btn-location" href="<?php echo esc_url( '//maps.google.com/maps?q=' . urlencode( strip_tags( $location ) ) . '&zoom=14&size=512x512&maptype=roadmap&sensor=false' ); ?>">
			<i class="flaticon-map"></i>
		</a>
		<?php
    }
    $output = ob_get_clean();
    if ( $echo ) {
    	echo trim($output);
    } else {
    	return $output;
    }
}

function homez_property_display_price($post_id, $display_type = 'no-icon-title', $echo = true) {
	if ( is_object($post_id) ) {
		$post_id = $post_id->ID;
	}
	$obj_property_meta = WP_RealEstate_Property_Meta::get_instance($post_id);
	$price = $obj_property_meta->get_price_html();
	ob_start();
	if ( $price ) {
		if ( $display_type == 'icon' ) {
			?>
			<div class="property-price with-icon"><i class="ti-credit-card"></i> <?php echo trim($price); ?></div>
			<?php
		} elseif ( $display_type == 'title' ) {
			$title = $obj_property_meta->get_post_meta_title( 'price' );
			?>
			<div class="property-price with-title">
				<strong><?php echo trim($title); ?>:</strong> <span><?php echo trim($price); ?></span>
			</div>
			<?php
		} else {
			?>
			<div class="property-price"><?php echo trim($price); ?></div>
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

function homez_property_display_postdate($post, $display_type = 'no-icon-title', $format = 'normal', $echo = true) {
	ob_start();
	if ( $format == 'ago' ) {
		$post_date = sprintf(esc_html__('%s ago', 'homez'), human_time_diff(get_the_time('U'), current_time('timestamp')) );
	} else {
		$post_date = get_the_time(get_option('date_format'));
	}
	if ( $display_type == 'icon' ) {
		?>
		<div class="property-postdate with-icon"><i class="flaticon-clock"></i> <?php echo trim($post_date); ?></div>
		<?php
	} elseif ( $display_type == 'title' ) {
		?>
		<div class="property-postdate with-title">
			<strong><?php esc_html_e('Date:', 'homez'); ?></strong> <?php echo trim($post_date); ?>
		</div>
		<?php
	} else {
		?>
		<div class="property-postdate"><?php echo trim($post_date); ?></div>
		<?php
	}
	$output = ob_get_clean();
    if ( $echo ) {
    	echo trim($output);
    } else {
    	return $output;
    }
}

function homez_property_gallery_icon($post, $display_type = 'icon', $echo = true) {
	
	$obj_property_meta = WP_RealEstate_Property_Meta::get_instance($post->ID);

	$gallery = $obj_property_meta->get_post_meta( 'gallery' );
	$count = 0;
	if ( $gallery && is_array($gallery) ) {
		$count = count($gallery);
	}
	if ( has_post_thumbnail($post) ) {
		$count++;
	}
	if ( $count == 0 ) {
		return '';
	}
	ob_start();
	if ( $display_type == 'icon' ) {
		?>
		<div class="property-gallery-count with-icon"><i class="flaticon-photo-camera"></i> <?php echo trim($count); ?></div>
		<?php
	} else {
		?>
		<div class="property-gallery-count"><?php echo trim($count); ?></div>
		<?php
	}
	$output = ob_get_clean();
    if ( $echo ) {
    	echo trim($output);
    } else {
    	return $output;
    }
}

function homez_property_video_icon($post, $display_type = 'icon', $echo = true) {
	
	$obj_property_meta = WP_RealEstate_Property_Meta::get_instance($post->ID);

	$video = $obj_property_meta->get_post_meta('video');
	$count = 0;
	if ( $video ) {
		$count = 1;
	}

	if ( $count == 0 ) {
		return '';
	}
	ob_start();
	if ( $display_type == 'icon' ) {
		?>
		<div class="property-gallery-count with-icon"><i class="flaticon-play-button"></i> <?php echo trim($count); ?></div>
		<?php
	} else {
		?>
		<div class="property-gallery-count"><?php echo trim($count); ?></div>
		<?php
	}
	$output = ob_get_clean();
    if ( $echo ) {
    	echo trim($output);
    } else {
    	return $output;
    }
}

function homez_property_property_id($post, $display_type = 'icon', $echo = true) {
	
	$obj_property_meta = WP_RealEstate_Property_Meta::get_instance($post->ID);

	$property_id = $obj_property_meta->get_post_meta('property_id');
	
	if ( empty($property_id) ) {
		return '';
	}
	ob_start();
	if ( $display_type == 'icon' ) {
		?>
		<div class="property-property-id with-icon"><i class="flaticon-fullscreen"></i> <?php echo trim($property_id); ?></div>
		<?php
	} else {
		?>
		<div class="property-property-id"><?php echo trim($property_id); ?></div>
		<?php
	}
	$output = ob_get_clean();
    if ( $echo ) {
    	echo trim($output);
    } else {
    	return $output;
    }
}

function homez_property_display_featured_icon($post, $echo = true, $add_class = '') {
	$obj_property_meta = WP_RealEstate_Property_Meta::get_instance($post->ID);

	$featured = $obj_property_meta->get_post_meta( 'featured' );
	ob_start();
	if ( $featured ) {
		?>
        <span class="featured-property <?php echo esc_attr($add_class); ?>"><i class="flaticon-electricity"></i><?php esc_html_e('Featured', 'homez'); ?></span>
	    <?php
	}

    $output = ob_get_clean();
    if ( $echo ) {
    	echo trim($output);
    } else {
    	return $output;
    }
}

function homez_property_item_map_meta($post) {
	$obj_property_meta = WP_RealEstate_Property_Meta::get_instance($post->ID);

	$latitude = $obj_property_meta->get_post_meta( 'map_location_latitude' );
	$longitude = $obj_property_meta->get_post_meta( 'map_location_longitude' );

	$thumbnail_url = '';
	if ( has_post_thumbnail($post->ID) ) {
		$thumbnail_url = get_the_post_thumbnail_url( $post, 'homez-property-grid' );
	}
	
	echo 'data-latitude="'.esc_attr($latitude).'" data-longitude="'.esc_attr($longitude).'" data-img="'.esc_url($thumbnail_url).'"';
}

function homez_property_author_phone($post, $display_type = 'no-title', $echo = true, $always_show_phone = false) {
	$author_id = $post->post_author;
	$avatar = $a_phone = '';
	if ( WP_RealEstate_User::is_agency($author_id) ) {
		$agency_id = WP_RealEstate_User::get_agency_by_user_id($author_id);
		$agency_post = get_post($agency_id);
		
		$a_phone = homez_agency_display_phone($agency_post, $display_type, false, $always_show_phone);
	} elseif ( WP_RealEstate_User::is_agent($author_id) ) {
		$agent_id = WP_RealEstate_User::get_agent_by_user_id($author_id);
		$agent_post = get_post($agent_id);

		$a_phone = homez_agent_display_phone($agent_post, $display_type, false, $always_show_phone);
	} else {
		$user_id = $post->post_author;

		$a_phone = get_user_meta($user_id, '_phone', true);
		$a_phone = homez_user_display_phone($a_phone, $display_type, false, $always_show_phone);
	}

	if ( $echo ) {
		echo trim($a_phone);
	} else {
		return $a_phone;
	}
}

function homez_property_display_meta($post, $meta_key, $icon = '', $show_title = false, $suffix = '', $echo = false) {
	$obj_property_meta = WP_RealEstate_Property_Meta::get_instance($post->ID);

	ob_start();
	if ( $obj_property_meta->check_post_meta_exist($meta_key) && ($value = $obj_property_meta->get_post_meta( $meta_key )) ) {
		?>
		<div class="property-meta with-<?php echo esc_attr($show_title ? 'icon-title' : 'icon'); ?>">

				
			<?php if ( !empty($icon) ) { ?>
				<i class="<?php echo esc_attr($icon); ?>"></i>
			<?php } ?>

			<?php if ( !empty($show_title) ) {
				$title = $obj_property_meta->get_post_meta_title( $meta_key );
			?>
				<span class="title-meta"><?php echo esc_html($title); ?>:</span>
			<?php } ?>

			<span class="value-suffix">
				<?php echo esc_html($value); ?>
				<?php echo trim($suffix); ?>
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

function homez_property_display_custom_field_meta($post, $meta_key, $icon = '', $show_title = false, $suffix = '', $echo = false) {
	$obj_property_meta = WP_RealEstate_Property_Meta::get_instance($post->ID);

	ob_start();
	if ( $obj_property_meta->check_custom_post_meta_exist($meta_key) && ($value = $obj_property_meta->get_custom_post_meta( $meta_key )) ) {
		?>
		<div class="property-meta with-<?php echo esc_attr($show_title ? 'icon-title' : 'icon'); ?>">

			<div class="property-meta">

				<?php if ( !empty($show_title) ) {
					$title = $obj_property_meta->get_custom_post_meta_title( $meta_key );
				?>
					<span class="title-meta">
						<?php echo esc_html($title); ?>
					</span>
				<?php } ?>

				<?php if ( !empty($icon) ) { ?>
					<i class="<?php echo esc_attr($icon); ?>"></i>
				<?php } ?>
				<span class="value-suffix">
					<?php echo esc_html($value); ?>
					<?php echo trim($suffix); ?>
				</span>
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

function homez_property_compare_field_featured($value, $key, $post_id) {
	switch ($key) {
	 	case 'featured':
	 		$classes = 'no';
	 		$val = esc_html__('No','homez');
			if ( $value == 'on' ) {
				$classes = 'yes';
				$val = esc_html__('Yes','homez');
			}
			$value = '<span class="'.$classes.'">'.$val.'<span>';
	 		break;
 		case 'valuation_group':
			if ( is_array( $value ) && count( $value[0] ) > 0 ) {
				ob_start();
			?>
			    <div class="property-section property-valuation">
			        <?php foreach ( $value as $group ) : ?>
			            <div class="valuation-item clearfix">
			                <div class="clearfix">
			                    <div class="valuation-label pull-left"><?php echo empty( $group['valuation_key'] ) ? '' : esc_attr( $group['valuation_key'] ); ?></div>
			                    <span class="percentage-valuation pull-right"><?php echo empty( $group['valuation_value'] ) ? '' : esc_attr( $group['valuation_value'] ); ?> <?php esc_html_e('%', 'homez'); ?></span>
			                </div>
			                <div class="property-valuation-item progress" >
			                    <div class="bar-valuation progress-bar progress-bar-success progress-bar-striped"
			                         style="width: <?php echo esc_attr( $group[ 'valuation_value' ] ); ?>%"
			                         data-percentage="<?php echo empty( $group['valuation_value'] ) ? '' : esc_attr( $group['valuation_value'] ); ?>">
			                    </div>
			                </div><!-- /.property-valuation-item -->
			                
			            </div>
			        <?php endforeach; ?>
			    </div><!-- /.property-valuation -->
			<?php
				$value = ob_get_clean();
			}
	 		break;
 		case 'public_facilities_group':
			if ( $value ) {
				ob_start();
			?>
			    <div class="property-section property-public-facilities">
			        <div class="clearfix">
			            <?php foreach ( $value as $facility ) : ?>
			                <div class="property-public-facility-wrapper">
			                    <div class="property-public-facility">
			                        <div class="property-public-facility-title">
			                            <span><?php echo empty( $facility['public_facilities_key'] ) ? '' : esc_attr( $facility['public_facilities_key'] ); ?></span>
			                        </div>
			                        <div class="property-public-facility-info">
			    						<?php echo empty( $facility['public_facilities_value'] ) ? '' : esc_attr( $facility['public_facilities_value'] ); ?>
			                        </div>
			                    </div>
			                </div>
			            <?php endforeach; ?>
			        </div>
			    </div>
			<?php
				$value = ob_get_clean();
			}
	 		break;
	 }
	return $value;
}
add_filter('wp-realestate-compare-field-value', 'homez_property_compare_field_featured', 10, 3);


function homez_property_print_btn($post, $show_title = false) {
	if ( homez_get_config('property_enable_printer', true) ) {
        ?>
        <a href="javascript:void(0);" class="btn-print-property" data-property_id="<?php echo esc_attr($post->ID); ?>" data-nonce="<?php echo esc_attr(wp_create_nonce( 'homez-printer-property-nonce' )); ?>" data-toggle="tooltip" title="<?php esc_attr_e('Print', 'homez'); ?>"><i class=" ti-printer"></i>
        	<?php if ( $show_title ) { ?>
        		<span><?php esc_html_e('Print', 'homez'); ?></span>
        	<?php } ?>
        </a>
        <?php
    }
}

function homez_property_display_filter_btn() {
    $layout_type = homez_get_properties_layout_type();
    $layout_sidebar = homez_get_properties_layout_sidebar();
    $filter_sidebar = homez_get_properties_filter_sidebar();
    if ( (($layout_type == 'default' && $layout_sidebar == 'main' && homez_get_properties_show_offcanvas_filter() ) || ($layout_type == 'top-map' && $layout_sidebar == 'main' && homez_get_properties_show_offcanvas_filter())) && is_active_sidebar( $filter_sidebar ) ) {
        ?>
        <div class="filter-in-sidebar-wrapper">
            <span class="filter-in-sidebar"><span class="text"><i class="flaticon-settings pre"></i><?php esc_html_e('More Filter', 'homez'); ?></span></span>
        </div>
        <?php
    }
}