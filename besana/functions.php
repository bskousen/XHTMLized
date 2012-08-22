<?php
/**
 * BesanaTapas theme functions and definitions
 *
 * @package WordPress
 * @subpackage Besana
 * @since Besana 1.0
 */

add_action( 'after_setup_theme', 'besana_setup' );

if ( ! function_exists( 'besana_setup' ) ):

function besana_setup() {

	add_theme_support( 'post-thumbnails' );

	add_theme_support( 'automatic-feed-links' );

	load_theme_textdomain( 'besana', TEMPLATEPATH . '/languages' );

	$locale = get_locale();
	$locale_file = TEMPLATEPATH . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );

	// This theme allows users to set a custom background
	add_custom_background();

}

endif;
