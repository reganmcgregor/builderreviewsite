<?php
/*
Plugin Name: Easy SVG Support
Plugin URI:  https://wordpress.org/plugins/easy-svg/
Description: Add SVG Support for WordPress.
Version:     3.7
Author:      Benjamin Zekavica
Requires PHP: 7.4
Requires at least: 6.0
Author URI:  https://www.benjamin-zekavica.de
Text Domain: easy-svg
Domain Path: /languages
License:     GPL2

Easy SVG is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

Easy SVG is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Easy SVG. If not, see license.txt .

Copyright by:
© 2017 - 2024 by Benjamin Zekavica. All rights reserved.

Imprint:
Benjamin Zekavica

E-Mail: info@benjamin-zekavica.de
Web: www.benjamin-zekavica.de

I don't give support by Mail. Please write in the
community forum for questions and problems.
*/

if ( !defined( 'ABSPATH' ) ) exit;

// Helpers
$composer_package =  __DIR__ .'/vendor/autoload.php'; 

// Composer
if( file_exists( $composer_package ) ) {
    require( $composer_package );
}

// SVG Sanitizer
use enshrined\svgSanitize\Sanitizer;
$sanitizer = new Sanitizer();


/* =====================================
*   Sanitizer SVG 
*
*   @filter-hook esw_svg_allowed_tags  SVG Tags
*   @filter-hook esw_svg_allowed_attributes  SVG Attributes
===============================================*/

// SVG TAGS
class esw_svg_tags extends \enshrined\svgSanitize\data\AllowedTags {

	public static function getTags() {
		return apply_filters( 'esw_svg_allowed_tags', parent::getTags() );
	}
}

// SVG Attributes
class esw_svg_attributes extends \enshrined\svgSanitize\data\AllowedAttributes {
	public static function getAttributes() {
		return apply_filters( 'esw_svg_allowed_attributes', parent::getAttributes() );
	}
}

// SVG FILE CHECKER
function esw_svg_file_checker( $file ){

	global $sanitizer;

    $sanitizer->setAllowedTags( new esw_svg_tags() );
	$sanitizer->setAllowedAttrs( new esw_svg_attributes() );

	$unclean = file_get_contents( $file );

    if ( $unclean === false ) {
        return false;
    }

	$clean = $sanitizer->sanitize( $unclean );
	if ( $clean === false ) {
		return false;
	}

    // CLEAN FILE and add new content
	file_put_contents( $file, $clean );

	return true;
}

// Sanitizing SVG on Upload –> Remove virus
function esw_svg_upload_filter_check_init( $upload ){

	if ( $upload['type'] === 'image/svg+xml' ) {
        if ( ! esw_svg_file_checker( $upload['tmp_name'] ) ) {
            $upload['error'] = __( "Sorry, please check your file", 'easy-svg' );
        }
    }

	return $upload;
}
add_filter( 'wp_handle_upload_prefilter', 'esw_svg_upload_filter_check_init' );



/* =====================================
*   Upload SVG Support
*
*   @param $svg_editing  FilePath of SVG
===============================================*/

if( !function_exists('esw_add_support') ){
    function esw_add_support ( $svg_editing ){

        $svg_editing['svg'] = 'image/svg+xml';
      
        // Echo the svg file
        return $svg_editing;
    }
    add_filter( 'upload_mimes', 'esw_add_support' );
}


/* ============================================
*   Uploading SVG Files into the Media Libary
*
*   @param $checked     Check file extension
*   @param $file        Path of file
*   @param $filename    Name of your file 
*   @param $mimes       Which type of file
*
===============================================*/

if( !function_exists('esw_upload_check') ){

    function esw_upload_check($checked, $file, $filename, $mimes){

        if(!$checked['type']){
       
            $esw_upload_check = wp_check_filetype( $filename, $mimes );
            $ext              = $esw_upload_check['ext'];
            $type             = $esw_upload_check['type'];
            $proper_filename  = $filename;
       
            if($type && 0 === strpos($type, 'image/') && $ext !== 'svg'){
               $ext = $type = false;
            }
       
            // Check the filename
            $checked = compact('ext','type','proper_filename');
        }
       
        return $checked;
    }
    add_filter('wp_check_filetype_and_ext', 'esw_upload_check', 10, 4);
}

/*========================================
    Load Text Domain for languages files
=======================================  */

if( !function_exists( 'esw_multiligual_textdomain' ) ) {
    function esw_multiligual_textdomain() {
        load_plugin_textdomain( 'easy-svg' , false, dirname( plugin_basename( __FILE__ ) ).'/languages' );
    }
    add_action( 'plugins_loaded', 'esw_multiligual_textdomain' );
}

/* ========================================
    Display SVG Files in Backend
=======================================  */

if( !function_exists( 'esw_display_svg_files_backend' ) ) {
    
    function esw_display_svg_files_backend(){

        $url = '';
        $attachmentID = isset($_REQUEST['attachmentID']) ? $_REQUEST['attachmentID'] : '';

        if($attachmentID){
            $url = wp_get_attachment_url($attachmentID);
        }
        echo $url;
        
        die();
    }
    add_action('wp_AJAX_svg_get_attachment_url', 'esw_display_svg_files_backend');
}

/* ========================================
    Media Libary  Display SVG
*
*   @param $response    Return of file
*   @param $attachment  Get file array 
*   @param $meta        Meta information
*
===============================================*/

if( !function_exists( 'esw_display_svg_media' ) ) {
    
    function esw_display_svg_media($response, $attachment, $meta){
        if($response['type'] === 'image' && $response['subtype'] === 'svg+xml' && class_exists('SimpleXMLElement')){
            try {
                
                $path = get_attached_file($attachment->ID);

                if(@file_exists($path)){
                    $svg                = new SimpleXMLElement(@file_get_contents($path));
                    $src                = $response['url'];
                    $width              = (int) $svg['width'];
                    $height             = (int) $svg['height'];
                    $response['image']  = compact( 'src', 'width', 'height' );
                    $response['thumb']  = compact( 'src', 'width', 'height' );

                    $response['sizes']['full'] = array(
                        'height'        => $height,
                        'width'         => $width,
                        'url'           => $src,
                        'orientation'   => $height > $width ? 'portrait' : 'landscape',
                    );
                }
            }
            catch(Exception $e){}
        }

        return $response;
    }
    add_filter('wp_prepare_attachment_for_js', 'esw_display_svg_media', 10, 3);
}

/* ========================================
   Load CSS in Admin Header Styles
=======================================  */

if( !function_exists( 'esw_svg_styles' ) ) {

    function esw_svg_styles() {
        echo "<style>
                /* Media LIB */
                table.media .column-title .media-icon img[src*='.svg']{
                    width: 100%;
                    height: auto;
                }
    
                /* Gutenberg Support */
                .components-responsive-wrapper__content[src*='.svg'] {
                    position: relative;
                }
    
            </style>";
    }
    add_action('admin_head', 'esw_svg_styles');
}