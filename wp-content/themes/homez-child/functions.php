<?php

function homez_child_enqueue_styles() {
	wp_enqueue_style( 'homez-child-style', get_stylesheet_uri() );
}

add_action( 'wp_enqueue_scripts', 'homez_child_enqueue_styles', 200 );