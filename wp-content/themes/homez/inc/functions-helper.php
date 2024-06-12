<?php

if ( ! function_exists( 'homez_body_classes' ) ) {
	function homez_body_classes( $classes ) {
		global $post;
		$show_footer_mobile = homez_get_config('show_footer_mobile', true);

		if ( is_page() && is_object($post) ) {
			$class = get_post_meta( $post->ID, 'apus_page_extra_class', true );
			if ( !empty($class) ) {
				$classes[] = trim($class);
			}
			if(get_post_meta( $post->ID, 'apus_page_header_transparent',true) && get_post_meta( $post->ID, 'apus_page_header_transparent',true) == 'yes' ){
				$classes[] = 'header_transparent';
			}
			if(get_post_meta( $post->ID, 'apus_page_header_fixed',true) && get_post_meta( $post->ID, 'apus_page_header_fixed',true) == 'yes' ){
				$classes[] = 'header_fixed';
			}
			// layout
			if(get_post_meta( $post->ID, 'apus_page_layout', true )){
				$classes[] = get_post_meta( $post->ID, 'apus_page_layout', true );
			}
		}

		if ( homez_get_config('preload', true) ) {
			$classes[] = 'apus-body-loading';
		}
		if ( homez_get_config('image_lazy_loading') ) {
			$classes[] = 'image-lazy-loading';
		}
		if ( $show_footer_mobile ) {
			$classes[] = 'body-footer-mobile';
		}
		if ( homez_is_wp_realestate_activated() ) {
			if ( homez_is_properties_page() ) {
				$layout_type = homez_get_properties_layout_type();
				if ( $layout_type == 'half-map' || $layout_type == 'half-map-v2' || $layout_type == 'half-map-v3' || $layout_type == 'half-map-v4' ) {
					$classes[] = 'no-footer';
					$classes[] = 'fix-header';
				}
			}
			if ( is_singular('property') ) {
				if( homez_get_property_layout_type() ) {
		 			$classes[] = 'single-property-'.homez_get_property_layout_type();
		 		}
		 	}
		}
 		
		if ( homez_get_config('keep_header') ) {
			$classes[] = 'has-header-sticky';
		}
		
		return $classes;
	}
	add_filter( 'body_class', 'homez_body_classes' );
}

if ( !function_exists('homez_get_header_layouts') ) {
	function homez_get_header_layouts() {
		$headers = array();
		$args = array(
			'posts_per_page'   => -1,
			'offset'           => 0,
			'orderby'          => 'date',
			'order'            => 'DESC',
			'post_type'        => 'apus_header',
			'post_status'      => 'publish',
			'suppress_filters' => true 
		);
		$posts = get_posts( $args );
		foreach ( $posts as $post ) {
			$headers[$post->post_name] = $post->post_title;
		}
		return $headers;
	}
}

if ( !function_exists('homez_get_header_layout') ) {
	function homez_get_header_layout() {
		global $post;
		if ( is_page() && is_object($post) && isset($post->ID) ) {
			global $post;
			$header = get_post_meta( $post->ID, 'apus_page_header_type', true );
			if ( empty($header) || $header == 'global' ) {
				return homez_get_config('header_type');
			}
			return $header;
		}
		return homez_get_config('header_type');
	}
	add_filter( 'homez_get_header_layout', 'homez_get_header_layout' );
}

function homez_display_header_builder($header_slug) {
	$args = array(
		'name'        => $header_slug,
		'post_type'   => 'apus_header',
		'post_status' => 'publish',
		'numberposts' => 1,
		'fields' => 'ids'
	);
	$post_ids = get_posts($args);
	foreach ( $post_ids as $post_id ) {
		$post_id = homez_get_lang_post_id($post_id, 'apus_header');
		$post = get_post($post_id);

		if ( homez_get_config('keep_header') ) {
			$classes = array('apus-header d-none d-xl-block');
		}else{
			$classes = array('apus-header no_keep_header d-none d-xl-block');
		}
		$classes[] = $post->post_name.'-'.$post->ID;

		echo '<div id="apus-header" class="'.esc_attr(implode(' ', $classes)).'">';
		if ( homez_get_config('keep_header') ) {
	        echo '<div class="main-sticky-header">';
	    }
			echo apply_filters( 'homez_generate_post_builder', do_shortcode( $post->post_content ), $post, $post->ID);
		if ( homez_get_config('keep_header') ) {
			echo '</div>';
	    }
		echo '</div>';
	}
}

if ( !function_exists('homez_get_footer_layouts') ) {
	function homez_get_footer_layouts() {
		$footers = array();
		$args = array(
			'posts_per_page'   => -1,
			'offset'           => 0,
			'orderby'          => 'date',
			'order'            => 'DESC',
			'post_type'        => 'apus_footer',
			'post_status'      => 'publish',
			'suppress_filters' => true 
		);
		$posts = get_posts( $args );
		foreach ( $posts as $post ) {
			$footers[$post->post_name] = $post->post_title;
		}
		return $footers;
	}
}

if ( !function_exists('homez_get_footer_layout') ) {
	function homez_get_footer_layout() {
		if ( is_page() ) {
			global $post;
			$footer = '';
			if ( is_object($post) && isset($post->ID) ) {
				$footer = get_post_meta( $post->ID, 'apus_page_footer_type', true );
				if ( empty($footer) || $footer == 'global' ) {
					return homez_get_config('footer_type', '');
				}
			}
			return $footer;
		}
		return homez_get_config('footer_type', '');
	}
	add_filter('homez_get_footer_layout', 'homez_get_footer_layout');
}

function homez_display_footer_builder($footer_slug) {
	$show_footer_desktop_mobile = homez_get_config('show_footer_desktop_mobile', false);
	$args = array(
		'name'        => $footer_slug,
		'post_type'   => 'apus_footer',
		'post_status' => 'publish',
		'numberposts' => 1,
		'fields' => 'ids'
	);
	$post_ids = get_posts($args);
	foreach ( $post_ids as $post_id ) {
		$post_id = homez_get_lang_post_id($post_id, 'apus_footer');
		$post = get_post($post_id);

		$classes = array('apus-footer footer-builder-wrapper');
		if ( !$show_footer_desktop_mobile ) {
			$classes[] = '';
		}
		$classes[] = $post->post_name;


		echo '<div id="apus-footer" class="'.esc_attr(implode(' ', $classes)).'">';
		echo '<div class="apus-footer-inner">';
		echo apply_filters( 'homez_generate_post_builder', do_shortcode( $post->post_content ), $post, $post->ID);
		echo '</div>';
		echo '</div>';
	}
}

if ( !function_exists('homez_blog_content_class') ) {
	function homez_blog_content_class( $class ) {
		$page = 'archive';
		if ( is_singular( 'post' ) ) {
            $page = 'single';
        }
		if ( homez_get_config('blog_'.$page.'_fullwidth') ) {
			return 'container-fluid';
		}
		return $class;
	}
}
add_filter( 'homez_blog_content_class', 'homez_blog_content_class', 1 , 1  );


if ( !function_exists('homez_get_blog_layout_configs') ) {
	function homez_get_blog_layout_configs() {
		$page = 'archive';
		if ( is_singular( 'post' ) ) {
            $page = 'single';
        }
		$left = homez_get_config('blog_'.$page.'_left_sidebar');
		$right = homez_get_config('blog_'.$page.'_right_sidebar');
		switch ( homez_get_config('blog_'.$page.'_layout') ) {
		 	case 'left-main':
			 	if ( is_active_sidebar( $left ) ) {
			 		$configs['left'] = array( 'sidebar' => $left, 'class' => 'col-lg-4 col-sm-12 col-12 sidebar-blog'  );
			 		$configs['main'] = array( 'class' => 'col-lg-8 col-sm-12 col-12' );
			 	}
		 		break;
		 	case 'main-right':
		 		if ( is_active_sidebar( $right ) ) {
			 		$configs['right'] = array( 'sidebar' => $right,  'class' => 'col-lg-4 col-sm-12 col-12 sidebar-blog' ); 
			 		$configs['main'] = array( 'class' => 'col-lg-8 col-sm-12 col-12' );
			 	}
		 		break;
	 		case 'main':
	 			$configs['main'] = array( 'class' => 'col-12' );
	 			break;
		 	default:
		 		if ( is_active_sidebar( 'sidebar-default' ) ) {
			 		$configs['right'] = array( 'sidebar' => 'sidebar-default',  'class' => 'col-lg-4 col-12' ); 
			 		$configs['main'] = array( 'class' => 'col-lg-8 col-12' );
			 	} else {
			 		$configs['main'] = array( 'class' => 'col-12' );
			 	}
		 		break;
		}
		if ( empty($configs) ) {
			if ( is_active_sidebar( 'sidebar-default' ) ) {
		 		$configs['right'] = array( 'sidebar' => 'sidebar-default',  'class' => 'col-lg-4 col-12 sidebar-blog' ); 
		 		$configs['main'] = array( 'class' => 'col-lg-8 col-12' );
		 	} else {
		 		$configs['main'] = array( 'class' => 'col-12' );
		 	}
		}
		return $configs; 
	}
}

if ( !function_exists('homez_page_content_class') ) {
	function homez_page_content_class( $class ) {
		global $post;
		if (is_object($post)) {
			$fullwidth = get_post_meta( $post->ID, 'apus_page_fullwidth', true );
			if ( !$fullwidth || $fullwidth == 'no' ) {
				return $class;
			}
		}
		return 'container-fluid';
	}
}
add_filter( 'homez_page_content_class', 'homez_page_content_class', 1 , 1  );

if ( !function_exists('homez_get_page_layout_configs') ) {
	function homez_get_page_layout_configs() {
		global $post;
		if ( is_object($post) ) {
			$left = get_post_meta( $post->ID, 'apus_page_left_sidebar', true );
			$right = get_post_meta( $post->ID, 'apus_page_right_sidebar', true );

			switch ( get_post_meta( $post->ID, 'apus_page_layout', true ) ) {
			 	case 'left-main':
			 		if ( is_active_sidebar( $left ) ) {
				 		$configs['left'] = array( 'sidebar' => $left, 'class' => ' col-lg-3 col-sm-12 col-12'  );
				 		$configs['main'] = array( 'class' => 'col-lg-9 col-sm-12 col-12' );
				 	}
			 		break;
			 	case 'main-right':
			 		if ( is_active_sidebar( $right ) ) {
				 		$configs['right'] = array( 'sidebar' => $right,  'class' => ' col-lg-3 col-sm-12 col-12' ); 
				 		$configs['main'] = array( 'class' => 'col-lg-9 col-sm-12 col-12' );
				 	}
			 		break;
		 		case 'main':
		 			$configs['main'] = array( 'class' => 'col-12 p-0' );
		 			break;
			 	default:
			 		if ( homez_is_woocommerce_activated() && (is_cart() || is_checkout()) ) {
			 			$configs['main'] = array( 'class' => 'col-12 p-0' );
			 		} elseif ( is_active_sidebar( 'sidebar-default' ) ) {
				 		$configs['right'] = array( 'sidebar' => 'sidebar-default',  'class' => ' col-lg-3 col-sm-12 col-12' ); 
				 		$configs['main'] = array( 'class' => 'col-lg-9 col-sm-12 col-12' );
				 	} else {
				 		$configs['main'] = array( 'class' => 'col-12 p-0 full-default' );
				 	}
			 		break;
			}

			if ( empty($configs) ) {
				if ( is_active_sidebar( 'sidebar-default' ) ) {
			 		$configs['right'] = array( 'sidebar' => 'sidebar-default',  'class' => 'col-lg-3 col-sm-12 col-12' ); 
			 		$configs['main'] = array( 'class' => 'col-lg-9 col-sm-12 col-12' );
			 	} else {
			 		$configs['main'] = array( 'class' => 'col-12 p-0 full-default' );
			 	}
			}
		} else {
			$configs['main'] = array( 'class' => 'col-12' );
		}
		return $configs; 
	}
}

if ( !function_exists( 'homez_random_key' ) ) {
    function homez_random_key($length = 5) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $return = '';
        for ($i = 0; $i < $length; $i++) {
            $return .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $return;
    }
}

if ( !function_exists('homez_substring') ) {
    function homez_substring($string, $limit, $afterlimit = '[...]') {
        if ( empty($string) ) {
        	return $string;
        }
       	$string = explode(' ', wp_strip_all_tags( $string ), $limit);

        if (count($string) >= $limit) {
            array_pop($string);
            $string = implode(" ", $string) .' '. $afterlimit;
        } else {
            $string = implode(" ", $string);
        }
        $string = preg_replace('`[[^]]*]`','',$string);
        return strip_shortcodes( $string );
    }
}

function homez_hex2rgb( $color ) {
	$color = trim( $color, '#' );

	if ( strlen( $color ) == 3 ) {
		$r = hexdec( substr( $color, 0, 1 ).substr( $color, 0, 1 ) );
		$g = hexdec( substr( $color, 1, 1 ).substr( $color, 1, 1 ) );
		$b = hexdec( substr( $color, 2, 1 ).substr( $color, 2, 1 ) );
	} else if ( strlen( $color ) == 6 ) {
		$r = hexdec( substr( $color, 0, 2 ) );
		$g = hexdec( substr( $color, 2, 2 ) );
		$b = hexdec( substr( $color, 4, 2 ) );
	} else {
		return array();
	}

	return array( 'r' => $r, 'g' => $g, 'b' => $b );
}

function homez_generate_rgba( $rgb, $opacity ) {
	$output = 'rgba('.$rgb['r'].', '.$rgb['g'].', '.$rgb['b'].', '.$opacity.');';

	return $output;
}

function homez_is_apus_framework_activated() {
	return defined('APUS_FRAMEWORK_VERSION') ? true : false;
}

function homez_is_cmb2_activated() {
	return defined('CMB2_LOADED') ? true : false;
}

function homez_is_woocommerce_activated() {
	return class_exists( 'woocommerce' ) ? true : false;
}

function homez_is_revslider_activated() {
	return class_exists( 'RevSlider' ) ? true : false;
}

function homez_is_mailchimp_activated() {
	return class_exists( 'MC4WP_Form_Manager' ) ? true : false;
}

function homez_is_wp_realestate_activated() {
	return class_exists( 'WP_RealEstate' ) ? true : false;
}

function homez_is_wp_realestate_wc_paid_listings_activated() {
	return class_exists( 'WP_RealEstate_Wc_Paid_Listings' ) ? true : false;
}

function homez_is_wp_private_message() {
	return class_exists( 'WP_Private_Message' ) ? true : false;
}

function homez_header_footer_templates( $template ) {
	$post_type = get_post_type();
	if ( $post_type ) {
		$custom_post_types = array( 'apus_footer', 'apus_header', 'apus_megamenu', 'elementor_library' );
		if ( in_array( $post_type, $custom_post_types ) ) {
			if ( is_single() ) {
				$post_type = str_replace('_', '-', $post_type);
				return get_template_directory() . '/single-apus-elementor.php';
			}
		}
	}

	return $template;
}
add_filter( 'template_include', 'homez_header_footer_templates' );

function homez_get_lang_post_id($post_id, $post_type = 'page') {
    return apply_filters( 'wp-realestate-post-id', $post_id, $post_type);
}

function homez_get_shortcode_atts($post_content, $shortcode_key) {
	$result = array();
	//get shortcode regex pattern wordpress function
	$pattern = get_shortcode_regex();

	if (   preg_match_all( '/'. $pattern .'/s', $post_content, $matches ) )
	{
	    $keys = array();
	    $result = array();
	    foreach( $matches[0] as $key => $value) {
	    	if ( has_shortcode( $value, $shortcode_key ) ) {
	    		// $matches[3] return the shortcode attribute as string
		        // replace space with '&' for parse_str() function
		        $get = str_replace(" ", "&" , $matches[3][$key] );
		        parse_str($get, $output);

		        //get all shortcode attribute keys
		        $keys = array_unique( array_merge(  $keys, array_keys($output)) );
		        $result[] = $output;
	    	}
	    }
	    if( $keys && $result ) {
	        // Loop the result array and add the missing shortcode attribute key
	        foreach ($result as $key => $value) {
	            // Loop the shortcode attribute key
	            foreach ($keys as $attr_key) {
	                $result[$key][$attr_key] = isset( $result[$key][$attr_key] ) ? $result[$key][$attr_key] : NULL;
	            }
	            //sort the array key
	            ksort( $result[$key]);              
	        }
	    }
	}

	return $result;
}