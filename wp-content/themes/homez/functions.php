<?php
/**
 * homez functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package WordPress
 * @subpackage Homez
 * @since Homez 1.0.18
 */

define( 'HOMEZ_THEME_VERSION', '1.0.18' );
define( 'HOMEZ_DEMO_MODE', false );

if ( ! isset( $content_width ) ) {
	$content_width = 660;
}

if ( ! function_exists( 'homez_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 * @since Homez 1.0
 */
function homez_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on homez, use a find and replace
	 * to change 'homez' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'homez', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	add_theme_support( 'post-thumbnails' );
	add_image_size( 'homez-property-list', 560, 480, true );
	add_image_size( 'homez-property-grid', 570, 370, true );
	add_image_size( 'homez-property-grid-lg', 770, 500, true );
	add_image_size( 'homez-agent-grid', 405, 480, true );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'homez' ),
		'agent-menu' => esc_html__( 'Agent Account Menu', 'homez' ),
		'agency-menu' => esc_html__( 'Agency Account Menu', 'homez' ),
		'user-menu' => esc_html__( 'User Account Menu', 'homez' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	add_theme_support( "woocommerce", array('gallery_thumbnail_image_width' => 410) );
	add_theme_support( 'wc-product-gallery-slider' );

	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat'
	) );

	$color_scheme  = homez_get_color_scheme();
	$default_color = trim( $color_scheme[0], '#' );

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'homez_custom_background_args', array(
		'default-color'      => $default_color,
		'default-attachment' => 'fixed',
	) ) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	// Add support for Block Styles.
	add_theme_support( 'wp-block-styles' );

	// Add support for full and wide align images.
	add_theme_support( 'align-wide' );

	// Add support for editor styles.
	add_theme_support( 'editor-styles' );

	// Add support for responsive embeds.
	add_theme_support( 'responsive-embeds' );

	// Enqueue editor styles.
	add_editor_style('css/style-editor.css');

	homez_get_load_plugins();
}
endif; // homez_setup
add_action( 'after_setup_theme', 'homez_setup' );


/**
 * Load Google Front
 */
function homez_get_fonts_url() {
    $fonts_url = '';

    $main_font = homez_get_config('main-font');
	$main_font = !empty($main_font) ? json_decode($main_font, true) : array();
	if (  !empty($main_font['fontfamily']) ) {
		$main_font_family = $main_font['fontfamily'];
		$main_font_weight = !empty($main_font['fontweight']) ? $main_font['fontweight'] : '300,400,500,600,700,800';
		$main_font_subsets = !empty($main_font['subsets']) ? $main_font['subsets'] : 'latin,latin-ext';
	} else {
		$main_font_family = 'Poppins';
		$main_font_weight = '300,400,500,600,700,800';
		$main_font_subsets = 'latin,latin-ext';
	}

	$heading_font = homez_get_config('heading-font');
	$heading_font = !empty($heading_font) ? json_decode($heading_font, true) : array();
	if (  !empty($heading_font['fontfamily']) ) {
		$heading_font_family = $heading_font['fontfamily'];
		$heading_font_weight = !empty($heading_font['fontweight']) ? $heading_font['fontweight'] : '300,400,500,600,700,800';
		$heading_font_subsets = !empty($heading_font['subsets']) ? $heading_font['subsets'] : 'latin,latin-ext';
	} else {
		$heading_font_family = 'Poppins';
		$heading_font_weight = '300,400,500,600,700,800';
		$heading_font_subsets = 'latin,latin-ext';
	}

	if ( $main_font_family == $heading_font_family ) {
		$font_weight = $main_font_weight.','.$heading_font_weight;
		$font_subsets = $main_font_subsets.','.$heading_font_subsets;
		$fonts = array(
			$main_font_family => array(
				'weight' => $font_weight,
				'subsets' => $font_subsets,
			),
		);
	} else {
		$fonts = array(
			$main_font_family => array(
				'weight' => $main_font_weight,
				'subsets' => $main_font_subsets,
			),
			$heading_font_family => array(
				'weight' => $heading_font_weight,
				'subsets' => $heading_font_subsets,
			),
		);
	}

	$font_families = array();
	$subset = array();

	foreach ($fonts as $key => $opt) {
		$font_families[] = $key.':'.$opt['weight'];
		$subset[] = $opt['subsets'];
	}

    $query_args = array(
        'family' => implode( '|', $font_families ),
        'subset' => urlencode( implode( ',', $subset ) ),
    );
		
	$protocol = is_ssl() ? 'https:' : 'http:';
    $fonts_url = add_query_arg( $query_args, $protocol .'//fonts.googleapis.com/css' );
    
 
    return esc_url( $fonts_url );
}

/**
 * Enqueue styles.
 *
 * @since Homez 1.0
 */
function homez_enqueue_styles() {
	// load font
	wp_enqueue_style( 'homez-theme-fonts', homez_get_fonts_url(), array(), null );

	//load font awesome
	wp_enqueue_style( 'all-awesome', get_template_directory_uri() . '/css/all-awesome.css', array(), '5.11.2' );

	//load font flaticon
	wp_enqueue_style( 'flaticon', get_template_directory_uri() . '/css/flaticon.css', array(), '1.0.0' );

	// load font themify icon
	wp_enqueue_style( 'themify-icons', get_template_directory_uri() . '/css/themify-icons.css', array(), '1.0.0' );
			
	// load animate version 3.6.0
	wp_enqueue_style( 'animate', get_template_directory_uri() . '/css/animate.css', array(), '3.6.0' );

	// load bootstrap style
	if( is_rtl() ){
		wp_enqueue_style( 'bootstrap-rtl', get_template_directory_uri() . '/css/bootstrap.rtl.css', array(), '3.2.0' );
	} else {
		wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.css', array(), '3.2.0' );
	}
	// slick
	wp_enqueue_style( 'slick', get_template_directory_uri() . '/css/slick.css', array(), '1.8.0' );
	// magnific-popup
	wp_enqueue_style( 'magnific-popup', get_template_directory_uri() . '/css/magnific-popup.css', array(), '1.1.0' );
	// perfect scrollbar
	wp_enqueue_style( 'perfect-scrollbar', get_template_directory_uri() . '/css/perfect-scrollbar.css', array(), '0.6.12' );
	
	// mobile menu
	wp_enqueue_style( 'jquery-mmenu', get_template_directory_uri() . '/css/jquery.mmenu.css', array(), '0.6.12' );

	// main style
	if( is_rtl() ){
		wp_enqueue_style( 'homez-template', get_template_directory_uri() . '/css/template.rtl.css', array(), '1.0' );
	} else {
		wp_enqueue_style( 'homez-template', get_template_directory_uri() . '/css/template.css', array(), '1.0' );
	}
	
	$custom_style = homez_custom_styles();
	if ( !empty($custom_style) ) {
		wp_add_inline_style( 'homez-template', $custom_style );
	}
	wp_enqueue_style( 'homez-style', get_template_directory_uri() . '/style.css', array(), '1.0' );
}
add_action( 'wp_enqueue_scripts', 'homez_enqueue_styles', 100 );

function homez_admin_enqueue_styles() {

	//load font awesome
	wp_enqueue_style( 'all-awesome', get_template_directory_uri() . '/css/all-awesome.css', array(), '5.11.2' );

	//load font flaticon
	wp_enqueue_style( 'flaticon', get_template_directory_uri() . '/css/flaticon.css', array(), '1.0.0' );

	// load font themify icon
	wp_enqueue_style( 'themify-icons', get_template_directory_uri() . '/css/themify-icons.css', array(), '1.0.0' );
}
add_action( 'admin_enqueue_scripts', 'homez_admin_enqueue_styles', 100 );

function homez_login_enqueue_styles() {
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.css', array(), '4.5.0' );
	wp_enqueue_style( 'homez-login-style', get_template_directory_uri() . '/css/login-style.css', array(), '1.0' );
}
add_action( 'login_enqueue_scripts', 'homez_login_enqueue_styles', 10 );
/**
 * Enqueue scripts.
 *
 * @since Homez 1.0
 */
function homez_enqueue_scripts() {
	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	// bootstrap
	wp_enqueue_script( 'bootstrap-bundle', get_template_directory_uri() . '/js/bootstrap.bundle.min.js', array( 'jquery' ), '5.0.2', true );
	// slick
	wp_enqueue_script( 'slick', get_template_directory_uri() . '/js/slick.min.js', array( 'jquery' ), '1.8.0', true );
	// countdown
	wp_register_script( 'countdown', get_template_directory_uri() . '/js/countdown.js', array( 'jquery' ), '20150315', true );
	wp_localize_script( 'countdown', 'homez_countdown_opts', array(
		'days' => esc_html__('Days', 'homez'),
		'hours' => esc_html__('Hrs', 'homez'),
		'mins' => esc_html__('Mins', 'homez'),
		'secs' => esc_html__('Secs', 'homez'),
	));
	wp_enqueue_script( 'countdown' );
	// popup
	wp_enqueue_script( 'jquery-magnific-popup', get_template_directory_uri() . '/js/jquery.magnific-popup.min.js', array( 'jquery' ), '1.1.0', true );
	// unviel
	wp_enqueue_script( 'jquery-unveil', get_template_directory_uri() . '/js/jquery.unveil.js', array( 'jquery' ), '1.1.0', true );
	
	// perfect scrollbar
	wp_enqueue_script( 'perfect-scrollbar', get_template_directory_uri() . '/js/perfect-scrollbar.min.js', array( 'jquery' ), '1.5.0', true );
	
	if ( homez_get_config('keep_header') ) {
		wp_enqueue_script( 'sticky', get_template_directory_uri() . '/js/sticky.min.js', array( 'jquery', 'elementor-waypoints' ), '4.0.1', true );
	}

	// mobile menu script
	wp_enqueue_script( 'jquery-mmenu', get_template_directory_uri() . '/js/jquery.mmenu.js', array( 'jquery' ), '0.6.12', true );

	// main script
	wp_register_script( 'homez-functions', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), '20150330', true );
	wp_localize_script( 'homez-functions', 'homez_ajax', array(
		'ajaxurl' => esc_url(admin_url( 'admin-ajax.php' )),
		'previous' => esc_html__('Previous', 'homez'),
		'next' => esc_html__('Next', 'homez'),
		'mmenu_title' => esc_html__('Menu', 'homez')
	));
	wp_enqueue_script( 'homez-functions' );
	
	wp_add_inline_script( 'homez-functions', "(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);" );
}
add_action( 'wp_enqueue_scripts', 'homez_enqueue_scripts', 1 );

/**
 * Add a `screen-reader-text` class to the search form's submit button.
 *
 * @since Homez 1.0
 *
 * @param string $html Search form HTML.
 * @return string Modified search form HTML.
 */
function homez_search_form_modify( $html ) {
	return str_replace( 'class="search-submit"', 'class="search-submit screen-reader-text"', $html );
}
add_filter( 'get_search_form', 'homez_search_form_modify' );

/**
 * Function get opt_name
 *
 */
function homez_get_opt_name() {
	return 'homez_theme_options';
}
add_filter( 'apus_framework_get_opt_name', 'homez_get_opt_name' );


function homez_get_config($name, $default = '') {
	global $homez_theme_options;
	
	if ( empty($homez_theme_options) ) {
		$homez_theme_options = get_option('homez_theme_options');
	}

    if ( isset($homez_theme_options[$name]) ) {
        return $homez_theme_options[$name];
    }
    return $default;
}

function homez_set_exporter_ocdi_settings_option_keys($option_keys) {
	return array(
		'homez_theme_options',
		'elementor_disable_color_schemes',
		'elementor_disable_typography_schemes',
		'elementor_allow_tracking',
		'elementor_cpt_support',
		'wp_realestate_settings',
		'wp_realestate_fields_data',
	);
}
add_filter( 'apus_exporter_ocdi_settings_option_keys', 'homez_set_exporter_ocdi_settings_option_keys' );

function homez_disable_one_click_import() {
	return false;
}
add_filter('apus_frammework_enable_one_click_import', 'homez_disable_one_click_import');

function homez_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar Default', 'homez' ),
		'id'            => 'sidebar-default',
		'description'   => esc_html__( 'Add widgets here to appear in your Sidebar.', 'homez' ),
		'before_widget' => '<aside class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar Fixed', 'homez' ),
		'id'            => 'sidebar-fixed',
		'description'   => esc_html__( 'Add widgets here to appear in your home 8.', 'homez' ),
		'before_widget' => '<aside class="%2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	
	register_sidebar( array(
		'name'          => esc_html__( 'Properties filter sidebar', 'homez' ),
		'id'            => 'properties-filter',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'homez' ),
		'before_widget' => '<aside class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Properties filter sidebar 2', 'homez' ),
		'id'            => 'properties-filter2',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'homez' ),
		'before_widget' => '<aside class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Properties filter sidebar 3', 'homez' ),
		'id'            => 'properties-filter3',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'homez' ),
		'before_widget' => '<aside class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Properties filter Top sidebar', 'homez' ),
		'id'            => 'properties-filter-top',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'homez' ),
		'before_widget' => '<aside class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Properties filter Top sidebar 2', 'homez' ),
		'id'            => 'properties-filter-top2',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'homez' ),
		'before_widget' => '<aside class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Properties filter Top Map', 'homez' ),
		'id'            => 'properties-filter-top-map',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'homez' ),
		'before_widget' => '<aside class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Properties filter Top Half Map', 'homez' ),
		'id'            => 'properties-filter-top-half-map',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'homez' ),
		'before_widget' => '<aside class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Properties filter Top Half Map 2', 'homez' ),
		'id'            => 'properties-filter-top-half-map2',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'homez' ),
		'before_widget' => '<aside class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Property single 1 sidebar', 'homez' ),
		'id'            => 'property-single-sidebar',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'homez' ),
		'before_widget' => '<aside class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Property single 2 sidebar', 'homez' ),
		'id'            => 'property-single-v2-sidebar',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'homez' ),
		'before_widget' => '<aside class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Property single 3 sidebar', 'homez' ),
		'id'            => 'property-single-v3-sidebar',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'homez' ),
		'before_widget' => '<div class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Property single 4 sidebar', 'homez' ),
		'id'            => 'property-single-v4-sidebar',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'homez' ),
		'before_widget' => '<div class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Agents filter sidebar', 'homez' ),
		'id'            => 'agents-filter-sidebar',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'homez' ),
		'before_widget' => '<aside class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Agents filter top sidebar', 'homez' ),
		'id'            => 'agents-filter-top-sidebar',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'homez' ),
		'before_widget' => '<aside class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Agent single sidebar', 'homez' ),
		'id'            => 'agent-single-sidebar',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'homez' ),
		'before_widget' => '<aside class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Agencies filter sidebar', 'homez' ),
		'id'            => 'agencies-filter-sidebar',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'homez' ),
		'before_widget' => '<aside class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Agencies filter top sidebar', 'homez' ),
		'id'            => 'agencies-filter-top-sidebar',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'homez' ),
		'before_widget' => '<aside class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Agency single sidebar', 'homez' ),
		'id'            => 'agency-single-sidebar',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'homez' ),
		'before_widget' => '<aside class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'User Profile sidebar', 'homez' ),
		'id'            => 'user-profile-sidebar',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'homez' ),
		'before_widget' => '<aside class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Blog sidebar', 'homez' ),
		'id'            => 'blog-sidebar',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'homez' ),
		'before_widget' => '<aside class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Shop sidebar', 'homez' ),
		'id'            => 'shop-sidebar',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'homez' ),
		'before_widget' => '<aside class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );

}
add_action( 'widgets_init', 'homez_widgets_init' );

function homez_get_load_plugins() {
	$plugins[] = array(
		'name'                     => esc_html__( 'Apus Framework For Themes', 'homez' ),
        'slug'                     => 'apus-frame',
        'required'                 => true ,
        'source'				   => get_template_directory() . '/inc/plugins/apus-frame.zip'
	);

	$plugins[] = array(
		'name'                     => esc_html__( 'Revolution Slider', 'homez' ),
        'slug'                     => 'revslider',
        'required'                 => true ,
        'source'				   => get_template_directory() . '/inc/plugins/revslider.zip'
	);
	
	$plugins[] = array(
		'name'                     => esc_html__( 'Elementor Page Builder', 'homez' ),
	    'slug'                     => 'elementor',
	    'required'                 => true,
	);
	
	$plugins[] = array(
		'name'                     => esc_html__( 'Cmb2', 'homez' ),
	    'slug'                     => 'cmb2',
	    'required'                 => true,
	);

	$plugins[] = array(
		'name'                     => esc_html__( 'MailChimp for WordPress', 'homez' ),
	    'slug'                     => 'mailchimp-for-wp',
	    'required'                 =>  true
	);

	$plugins[] = array(
		'name'                     => esc_html__( 'Contact Form 7', 'homez' ),
	    'slug'                     => 'contact-form-7',
	    'required'                 => true,
	);

	// woocommerce plugins
	$plugins[] = array(
		'name'                     => esc_html__( 'Woocommerce', 'homez' ),
	    'slug'                     => 'woocommerce',
	    'required'                 => true,
	);
	
	// Property plugins
	$plugins[] = array(
		'name'                     => esc_html__( 'WP RealEstate', 'homez' ),
        'slug'                     => 'wp-realestate',
        'required'                 => true ,
        'source'				   => get_template_directory() . '/inc/plugins/wp-realestate.zip'
	);

	$plugins[] = array(
		'name'                     => esc_html__( 'WP RealEstate - WooCommerce Paid Listings', 'homez' ),
        'slug'                     => 'wp-realestate-wc-paid-listings',
        'required'                 => true ,
        'source'				   => get_template_directory() . '/inc/plugins/wp-realestate-wc-paid-listings.zip'
	);

	$plugins[] = array(
		'name'                     => esc_html__( 'WP Private Message', 'homez' ),
        'slug'                     => 'wp-private-message',
        'required'                 => true ,
        'source'				   => get_template_directory() . '/inc/plugins/wp-private-message.zip'
	);
	
	$plugins[] = array(
        'name'                  => esc_html__( 'One Click Demo Import', 'homez' ),
        'slug'                  => 'one-click-demo-import',
        'required'              => false,
    );

	$plugins[] = array(
        'name'                  => esc_html__( 'Easy SVG Support', 'homez' ),
        'slug'                  => 'easy-svg',
        'required'              => false,
        'force_activation'      => false,
        'force_deactivation'    => false,
    );
    
	tgmpa( $plugins );
}

get_template_part( '/inc/plugins/class-tgm-plugin-activation' );
get_template_part( '/inc/functions-helper' );
get_template_part( '/inc/functions-frontend' );

/**
 * Implement the Custom Header feature.
 *
 */
get_template_part( '/inc/custom-header' );
get_template_part( '/inc/classes/megamenu' );
get_template_part( '/inc/classes/mobilemenu' );

/**
 * Custom template tags for this theme.
 *
 */
get_template_part( '/inc/template-tags' );

/**
 * Customizer additions.
 *
 */
get_template_part( '/inc/customizer/font/custom-controls' );
get_template_part( '/inc/customizer/customizer-custom-control' );
get_template_part( '/inc/customizer/customizer' );

if( homez_is_cmb2_activated() ) {
	get_template_part( '/inc/vendors/cmb2/page' );
}

if( homez_is_woocommerce_activated() ) {
	get_template_part( '/inc/vendors/woocommerce/functions' );
	get_template_part( '/inc/vendors/woocommerce/customizer' );
}

if( homez_is_wp_realestate_activated() ) {
	get_template_part( '/inc/vendors/wp-realestate/customizer-property' );
	get_template_part( '/inc/vendors/wp-realestate/customizer-agent' );
	get_template_part( '/inc/vendors/wp-realestate/customizer-agency' );
	get_template_part( '/inc/vendors/wp-realestate/customizer-other' );
	get_template_part( '/inc/vendors/wp-realestate/functions' );
	get_template_part( '/inc/vendors/wp-realestate/functions-agent' );
	get_template_part( '/inc/vendors/wp-realestate/functions-agency' );
	get_template_part( '/inc/vendors/wp-realestate/functions-taxonomies' );

	get_template_part( '/inc/vendors/wp-realestate/functions-property-display' );
	get_template_part( '/inc/vendors/wp-realestate/functions-agent-display' );
	get_template_part( '/inc/vendors/wp-realestate/functions-agency-display' );
}

if ( homez_is_wp_realestate_wc_paid_listings_activated() ) {
	get_template_part( '/inc/vendors/wp-realestate-wc-paid-listings/functions' );
}

function homez_register_load_widget() {
	get_template_part( '/inc/widgets/custom_menu' );
	get_template_part( '/inc/widgets/recent_post' );
	get_template_part( '/inc/widgets/search' );
	get_template_part( '/inc/widgets/socials' );
	
	get_template_part( '/inc/widgets/elementor-template' );
	
	if ( homez_is_wp_realestate_activated() ) {
		get_template_part( '/inc/widgets/contact-form' );
		get_template_part( '/inc/widgets/property-contact-form' );
		get_template_part( '/inc/widgets/property-schedule-tour' );
		
		get_template_part( '/inc/widgets/property-list' );

		get_template_part( '/inc/widgets/user-short-profile' );
		get_template_part( '/inc/widgets/property-taxonomies' );
		
		get_template_part( '/inc/widgets/mortgage_calculator' );
		get_template_part( '/inc/widgets/agent-info' );
		get_template_part( '/inc/widgets/agency-info' );
		
		if ( homez_is_wp_private_message() ) {
			get_template_part( '/inc/widgets/private-message-form' );
		}
	}
}
add_action( 'widgets_init', 'homez_register_load_widget' );

if ( homez_is_wp_private_message() ) {
	get_template_part( '/inc/vendors/wp-private-message/functions' );
}

get_template_part( '/inc/vendors/elementor/functions' );
get_template_part( '/inc/vendors/one-click-demo-import/functions' );

/**
 * Custom Styles
 *
 */
get_template_part( '/inc/custom-styles' );