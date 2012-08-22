<?php
/**
 * Template Name: home page
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
		<link href="<?php echo get_template_directory_uri(); ?>/css/styles.css" type="text/css" rel="stylesheet" media="screen" />
		
		<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery-1.5.1.min.js"></script>
		<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.easing.1.3.js"></script>
		<?php wp_enqueue_script('custom-besana', get_template_directory_uri() . '/js/custom.js'); ?>
		<?php wp_localize_script('custom-besana', 'Besana', array('site_url' => site_url())); ?>
		<?php wp_head(); ?>
  </head>
  <body>
  	<div id="background">
  		<img src="<?php echo get_template_directory_uri(); ?>/images/bg_logo.jpg">
  	</div>
  	<div id="header">
  		<div id="aboutus_container">
  			<div id="aboutus">
  				<img src="<?php echo get_template_directory_uri(); ?>/images/aboutus_foto.jpg" />
  				<h1>Algo sobre Besana</h1>
  				<p><strong>Besana</strong> significa hacer surcos paralelos con el arado en la tierra. <strong>Besana Tapas</strong> quiere conservar algo de esta labor ya perdida: hacer un trabajo recto, lineal, sin desv&iacute;os, que, como un fruto maduro, d&eacute; a la tierra lo que es de la tierra. Tambi&eacute;n arar es producir con esfuerzo; tambi&eacute;n <strong>Besana</strong> se sostiene bajo los pilares del trabajo constante y de la vocaci&oacute;n.</p>
  				<p>Javier, Mario y Curro forman un tri&aacute;ngulo perfecto: <strong>Besana</strong>, palabra tris&iacute;laba; tres, n&uacute;mero simb&oacute;lico de la perfecci&oacute;n. Si faltara uno de ellos no ser&iacute;a lo mismo. T&eacute;cnica, organizaci&oacute;n, promoci&oacute;n&hellip;, todo es puesto en com&uacute;n. La diversidad de opini&oacute;n, contrastes y coincidencias, producen el enriquecimiento que luego comprueba el comensal. Sin este di&aacute;logo, en el que se a&uacute;nan acci&oacute;n y reflexi&oacute;n, no ser&iacute;a posible la satisfacci&oacute;n del trabajo bien hecho ni la conversaci&oacute;n salubre de su cocina.</p>
  				<p><strong>Besana</strong> es un sue&ntilde;o consciente hecho materia, una realidad o un deseo murmurado lentamente desde hace mucho tiempo. Y es que no tiene nada de improvisado o de inconsciente. Las tapas propuestas no son ilusiones, no son trucos de magia ―de los de nada por aqu&iacute;, nada por all&aacute;―, sino largos a&ntilde;os de formaci&oacute;n bajo el calor del Celler de Can Roca. Son productos meditados, en los que el consumidor adquiere todo el protagonismo. Desaparece de esta cocina el protagonismo del cocinero y se da paso en <strong>Besana</strong> a la prioridad de los clientes, as&iacute; como a los medios para conseguir una sensaci&oacute;n placentera a trav&eacute;s de un producto, un ambiente y unos sentimientos: hedonismo. <strong>Besana</strong>, frente a la filosof&iacute;a del psicoan&aacute;lisis, propone estudiar desde la meditaci&oacute;n y la cultura gastron&oacute;mica de la zona las recetas del placer.</p>
				</div>
				<div id="more-aboutus">Quieres conocernos?... Clicka nuestro logo.</div>
  		</div>
  		<a href="" id="logo-btn"><img src="<?php echo get_template_directory_uri(); ?>/images/logo_up.png" alt="besana tapas" /></a>

  	</div>
  	<div id="container">
  		<div id="nav">
  			<ul>
  		  	<li><a href="" id="nav-0" class="hided">comer</a></li>
  		  	<li><a href="" id="nav-1" class="hided">beber</a></li>
  		  	<li><a href="" id="nav-2" class="hided">encu&eacute;ntranos</a></li>
  		  </ul>
  		</div>
  		<div id="content">
  			<div id="horizontal-slider">
  				<div class="content-container">
  					<div id="content0" class="content-box">
  						<?php if (count($eating_posts_by_cats) > 0): ?>
  							<?php foreach ($eating_posts_by_cats as $category): ?>
  							<ul>
  								<h2><?php echo $category['name']; ?></h2>
  								<?php foreach ($category['posts'] as $post): ?>
  								<li><a href="<?php echo $post->post_name ?>" class="element" title="<?php echo $post->post_title ?>" tabindex="<?php echo $post->ID ?>"><?php echo $post->post_title ?></a></li>
  								<?php endforeach; ?>
  							</ul>
  							<?php endforeach; ?>
  						<?php else: ?>
  							<h3>Disculpe las molestias.<br />En este momento podemos mostrar el menu en nuestra web.<br />Vuelva a intentarlo más tarde.</h3>
  						<?php endif; ?>
  					</div>
  				</div>
  				<div class="content-container">
  					<div id="content1" class="content-box">
  						<?php if (count($drinking_posts_by_cats) > 0): ?>
  							<?php foreach ($eating_posts_by_cats as $category): ?>
  							<ul>
  								<h2><?php echo $category['name']; ?></h2>
  								<?php foreach ($category['posts'] as $post): ?>
  								<li><a href="<?php echo $post->post_name ?>" class="element" title="<?php echo $post->post_title ?>" tabindex="<?php echo $post->ID ?>"><?php echo $post->post_title ?></a></li>
  								<?php endforeach; ?>
  							</ul>
  							<?php endforeach; ?>
  						<?php else: ?>
  							<h3>Disculpe las molestias.<br />En este momento podemos mostrar la carta de bebidas en nuestra web.<br />Vuelva a intentarlo más tarde.</h3>
  						<?php endif; ?>
  					</div>
  				</div>
  				<div class="content-container">
  					<div id="content2" class="content-box">
  						<div id="whereweare" class="float-left">
  							<h2>D&oacute;nde estamos</h2>
  							<p>Puedes encontrarnos en el callej&oacute;n del Ni&ntilde;o Perd&iacute;o, en Utrera (Sevilla).</p>
  							<p>Puedes llamarnos al tel&eacute;fono 955 863 804</p>
  							<p>Tambi&eacute;n nos puedes encontrar en <a href="http://maps.google.es/maps/place?q=besana+tapas&hl=es&cid=11320423558058977300" lang="es" title="Besana Tapas en Google Maps">Google Maps&reg;</a></p>
  						</div>
  						<div id="writeus" class="float-left">
  							<h2>Escr&iacute;benos un mensaje</h2>
  							<form action="" method="post">
  								<div class="float-left">
  									<p><label for="name">Nombre</label><input type="text" name="name" value="" /></p>
  									<p><label for="email">Email</label><input type="text" name="email" value="" /></p>
  									<p><label for="city">Ciudad</label><input type="text" name="city" value="" /></p>
  									<p><label for="country">Pais</label><input type="text" name="country" value="" /></p>
  								</div>
  								<div class="float-left" style="margin-left:20px;">
  									<p><label for="message">Mensaje</label><textarea name="message"></textarea></p>
  								</div>
  								<p><input type="button" name="submit" value="enviar" /></p>
  							</form>
  						</div>
  					</div>
  				</div>
  			</div>
  		</div>
  	</div>
  </body>
</html>