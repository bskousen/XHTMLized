<?php
/**
 * Template Name: blog page
 *
 * @package WordPress
 * @subpackage Besana
 * @since Besana 1.0
 */
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html <?php language_attributes(); ?>>
  <head>
  	<meta charset="<?php bloginfo( 'charset' ); ?>" />
    <title><?php
		/*
		 * Print the <title> tag based on what is being viewed.
		 */
		global $page, $paged;
		
		wp_title( '|', true, 'right' );
		
		// Add the blog name.
		bloginfo( 'name' );
		
		// Add the blog description for the home/front page.
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) )
			echo " | $site_description";
		
		// Add a page number if necessary:
		if ( $paged >= 2 || $page >= 2 )
			echo ' | ' . sprintf( __( 'Page %s', 'twentyten' ), max( $paged, $page ) );
		
		?></title>
    <link href="<?php echo get_template_directory_uri(); ?>/css/reset.css" type="text/css" rel="stylesheet" media="screen" />
		<!-- <link href="<?php echo get_template_directory_uri(); ?>/css/styles.css" type="text/css" rel="stylesheet" media="screen" /> -->
		
		<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery-1.5.1.min.js"></script>
		<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.easing.1.3.js"></script>
		<!-- <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/custom.js"></script> -->
  </head>
  <body>
  	<h1>Besana Tapas Blog</h1>
  	<p>Apartado en construcci&oacute;n.</p>
  </body>
</html>