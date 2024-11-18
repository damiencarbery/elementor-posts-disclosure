<?php
/*
 * Plugin Name: Elementor Posts Disclosure Widget
 * Description: A simple version of the Elementor Pro Posts widget, presenting posts in details/summary disclosure elements.
 * Plugin URI:  https://www.damiencarbery.com/2024/11/elementor-posts-disclosure-widget/
 * Version:     0.1.20241118
 * Author:      Damien Carbery
 * Author URI:  https://www.damiencarbery.com/
 *
 * Elementor tested up to: 3.25.6
 */

// Elementor API docs are at: https://developers.elementor.com/docs/widgets/


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


// Register Posts Disclosure Widget.
function dcwd_register_posts_disclosure_widget( $widgets_manager ) {
	require_once( __DIR__ . '/simple-posts-disclosure.php' );

	$widgets_manager->register( new \Elementor_PostsDisclosure_Widget() );
}
add_action( 'elementor/widgets/register', 'dcwd_register_posts_disclosure_widget' );
