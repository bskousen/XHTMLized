<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $this->registry->get_meta('title'); ?></title>
<meta name="keywords" content="<?php echo $this->registry->get_meta('keywords'); ?>" />
<meta name="description" content="<?php echo $this->registry->get_meta('description'); ?>" />
<link rel="stylesheet" href="<?php echo _reg('microsite_css_url'); ?>reset.css" />
<link rel="stylesheet" href="<?php echo _reg('microsite_css_url'); ?>styles.css" />
</head>
<body>
<div id="container">
<div id="header">
    <div id="logo">
        <?php if ($company['logo']): ?>
        <?php
            // get the filename for the logo image:
            // slice the filename in name and extension, add file size suffix at the en of the name and stick it again
            $filename = pathinfo($company['logo'], PATHINFO_FILENAME);
            $fileext = strtolower(pathinfo($company['logo'], PATHINFO_EXTENSION));
            $logo_path = _reg('site_url') . 'usrs/empresas/' . $filename . '.' . $fileext;
            ?>
        <img src="<?php echo $logo_path; ?>" class="fade" />
        <?php endif; ?>
    </div>
    <div id="regreso">
        <a href="http://demo.masportales.es/">Regreso a +portales</a>
    </div>
    <div id="social">
        Teléfonos y emails de contacto de la empresa - <a href="https://www.facebook.com/pages/Portales/19641592611" target="_blank"><img src="/images/facebook.png" alt="Facebook" width="25" height="25" align="absmiddle" class="fade"></a> <a href="http://twitter.com/#!/MasPortales" target="_blank"><img src="/images/twitter.png" alt="Twitter" width="25" height="25" align="absmiddle" class="fade"></a> <a href="#" target="_blank"><img src="/images/google.png" alt="Google+" width="25" height="25" align="absmiddle" class="fade"></a> <a href="#" target="_blank"><img src="/images/1339537950_Tuenti 02.png" alt="Tuenti" width="25" height="25" align="absmiddle" class="fade"></a> <a href="#" target="_blank"><img src="/images/rss.png" alt="RSS" width="25" height="25" align="absmiddle" class="fade"></a>
    </div>
    <div id="nav">
        <ul>
            <li><a href="">Inicio</a></li>
            <li> <a href="">Secciones</a>
                <?php if ($microsite_pages): ?>
                <ul>
                    <?php foreach($microsite_pages as $pages): ?>
                    <li><a href="<?php echo _reg('site_url') . 'web/' . $company['slug'] . '/' . $pages['slug']; ?>"><?php echo $pages['title']; ?></a></li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
            </li>
            <?php if ($company_images): ?>
            <li><a href="">Galería de imágenes</a></li>
            <?php endif; ?>
            <?php if ($company['catalog']): ?>
            <li><a href="">Catálogo de productos</a></li>
            <?php endif; ?>
            <li><a href="">Contacto</a></li>
        </ul>
    </div>
    <!--nav-->
</div>
<!--header-->

<div id="contenido">
    <div id="slide">
        <img src="<?php echo get_image_url($banner['uri'], '', _reg('site_url') . 'usrs/empresas/'); ?>" alt="<?php echo $banner['name']; ?>"width="960" height="361" />
    </div>
    <!--slide-->
    
    <div id="seccion1">
        <h1><?php echo $company['name']; ?></h1>
        <p> <?php echo $company['description']; ?> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam rutrum justo nec urna convallis pulvinar. Suspendisse potenti. Nulla dignissim, elit in volutpat sollicitudin, orci felis dictum arcu, vulputate mollis sem mauris nec tortor. In sit amet eros ac lectus lacinia mollis. Ut turpis ipsum, feugiat non consequat vel, bibendum eget elit. Nam orci justo, varius nec gravida ut, adipiscing sit amet lorem. Nam eget enim sit amet ipsum euismod ultrices. Proin egestas pellentesque tincidunt. Nam vel metus urna, id fermentum mi.
            
            Mauris est magna, hendrerit at eleifend eget, pulvinar at nulla. Nulla ut interdum libero. Nunc tempus tempor venenatis. Pellentesque nec vehicula ipsum. Sed posuere fermentum dolor vel sollicitudin. Donec eget interdum libero. Nullam nulla odio, auctor id tristique quis, ultrices placerat massa. Pellentesque lectus nulla, tincidunt sit amet lobortis vitae, facilisis vel velit. Ut ultricies cursus tempus. Cras a odio dictum lorem pretium semper vel vel purus. Curabitur ut velit id dolor tincidunt pulvinar. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Pellentesque luctus, massa at venenatis dignissim, lectus justo lacinia ligula, id sodales dolor mi id lorem. Vivamus eleifend sodales tortor, eget pellentesque quam tincidunt et. </p>
    </div>
    <!--seccion1-->
    
    <div id="seccion2">
        <!-- mapa de google maps -->
        <?php
					$gmap_address = urlencode($company['address'] . ', ' . $company['zipcode'] . ', ' . $company['city'] . ', ' . $company['country']);
					$gmap_icon = _reg('base_url') . 'usrs/gmap.png';
					?>
        <img src="http://maps.google.com/maps/api/staticmap?zoom=14&size=234x216&maptype=roadmap&markers=color:0xCC3399%7C<?php echo $gmap_address; ?>&sensor=false" alt="" />
        <p><a href="http://maps.google.es/maps?q=<?php echo $gmap_address; ?>" target="_blank">ver en Google Maps</a></p>
    </div>
    <!--seccion2-->
    
    <div id="seccion3">
        <div class="bizdata">
            <!-- datos de contacto -->
            <p><?php echo $company['address']; ?><br />
                <?php echo $company['zipcode']; ?> <?php echo $company['city']; ?> (<?php echo $company['state']; ?>)</p>
            <p>(T) <?php echo $company['phone']; ?></p>
            <p>(web) <?php echo $company['web']; ?></p>
        </div>
    </div>
</div>
</div>
<div id="footer">
    <div class="container">
        <div class="logotipo">
            <a href="#" class="fade"><img src="../../../../images/masportales_logo.png" width="105" height="40" /></a>
        </div>
        <div class="nav">
            <p><a href="<?php echo _reg('site_url'); ?>noticias">Noticias</a> <a href="<?php echo _reg('site_url'); ?>empresas">Guía de empresas</a> <a href="<?php echo _reg('site_url'); ?>tienda">Productos</a> <a href="<?php echo _reg('site_url'); ?>agenda">Agenda</a> <a href="<?php echo _reg('site_url'); ?>">¿Quiere una web como esta?</a></p>
        </div>
        <!-- .nav -->
        
        <div class="sociales">
            <a href="https://www.facebook.com/pages/Portales/19641592611" target="_blank" class="fade icon"><img src="<?php echo _reg('site_url') . _reg('theme_path'); ?>css/images/icons_48x48/facebook.png" alt="Facebook" /></a> <a href="http://twitter.com/#!/MasPortales" target="_blank" class="fade icon"><img src="<?php echo _reg('site_url') . _reg('theme_path'); ?>css/images/icons_48x48/twitter.png" alt="Twitter" /></a> <a href="" class="fade icon"><img src="<?php echo _reg('site_url') . _reg('theme_path'); ?>css/images/icons_48x48/google.png" alt="Google" /></a> <a href="" class="fade icon"><img src="<?php echo _reg('site_url') . _reg('theme_path'); ?>css/images/icons_48x48/Tuenti.png" alt="Tuenti" /></a> <a href="" class="fade icon"><img src="<?php echo _reg('site_url') . _reg('theme_path'); ?>css/images/icons_48x48/rss.png" alt="RSS" /></a>
        </div>
        <!-- .sociales -->
        
    </div>
</div>
</body>
</html>
