<?php
/**
 * Template Name: safari mobile
 *
 * @package WordPress
 * @subpackage Besana
 * @since Besana 1.0
 */
?>

<?php

/**
 * Processing data before load page
 */

$eating_category_args = array(
	'type'					=> 'post',
	'child_of'			=> 0,
	'parent'				=> get_cat_ID('comer'),
	'orderby'				=> 'description',
	'order'					=> 'ASC',
	'hide_empty'		=> 1,
	'hierarchical'	=> 1,
	'taxonomy'			=> 'category',
	'pad_counts'		=> false
);

$drinking_category_args = array(
	'type'					=> 'post',
	'child_of'			=> 0,
	'parent'				=> get_cat_ID('beber'),
	'orderby'				=> 'name',
	'order'					=> 'ASC',
	'hide_empty'		=> 1,
	'hierarchical'	=> 1,
	'taxonomy'			=> 'category',
	'pad_counts'		=> false
);

$eating_categories = get_categories($eating_category_args);
$drinking_categories = get_categories($drinking_category_args);

$eating_posts_by_cats = array();

foreach ($eating_categories as $eating_category) {
	$post_by_cat_args = array(
		'numberposts'     => 10,
		'offset'          => 0,
		'category'        => $eating_category->term_id,
		'orderby'         => 'post_date',
		'order'           => 'DESC',
		'post_type'       => 'post',
		'post_status'     => 'publish'
	);
	
	$post_by_cats = get_posts($post_by_cat_args);
	$posts_by_cats_in_menu = array();
	
	foreach ($post_by_cats as $post) {
		if (has_tag('en carta', $post)) {
			$posts_by_cats_in_menu[] = $post;
		}
	}
	
	$eating_posts_by_cats[] = array(
		'ID' => $eating_category->term_id,
		'name' => $eating_category->name,
		'slug' => $eating_category->slug,
		'posts' => $posts_by_cats_in_menu
	);
}

$drinking_posts_by_cats = array();

foreach ($drinking_categories as $drinking_category) {
	$post_by_cat_args = array(
		'numberposts'     => 10,
		'offset'          => 0,
		'category'        => $drinking_category->term_id,
		'orderby'         => 'post_date',
		'order'           => 'DESC',
		'post_type'       => 'post',
		'post_status'     => 'publish'
	);
	
	$post_by_cats = get_posts($post_by_cat_args);
	$posts_by_cats_in_menu = array();
	
	foreach ($post_by_cats as $post) {
		if (has_tag('en carta', $post)) {
			$posts_by_cats_in_menu[] = $post;
		}
	}
	
	$drinking_posts_by_cats[] = array(
		'ID' => $drinking_category->term_id,
		'name' => $drinking_category->name,
		'slug' => $drinking_category->slug,
		'posts' => $posts_by_cats_in_menu
	);
}

?>

<!DOCTYPE html>
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
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
		<meta name="apple-mobile-web-app-capable" content="yes">
    
    <link href="<?php echo get_template_directory_uri(); ?>/css/sm.css?version=<?php echo time(); ?>" type="text/css" rel="stylesheet" />
  </head>
  <body>
  	<div id="container">
  		<img src="<?php echo get_template_directory_uri(); ?>/images/logo_sm.png" alt="Besana Tapas" />
  	</div>
  </body>
</html>