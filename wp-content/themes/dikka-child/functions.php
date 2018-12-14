<?php
/**
 * Dikka Child functions file.
 */

function dikka_parent_styles() {

	// Enqueue the parent stylesheet
	wp_enqueue_style( 'main', get_template_directory_uri() . '/style.css','woo-layout-ux' );
	wp_enqueue_style( 'main-child', get_stylesheet_uri() ,'main' );

}
add_action( 'wp_enqueue_scripts', 'dikka_parent_styles',11 );
?>
