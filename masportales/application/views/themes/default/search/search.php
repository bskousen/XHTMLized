<?php if ($articles or $events or $products or $companies or $basicads): ?>
<?php if ($articles): ?>

<div id="news" class="section news">
    <div class="header">
        <h4>NOTICIAS</h4>
    </div>
    <div class="content">
        <div id="newscats">
            <p>Resultados de la búsqueda en <strong>Noticias</strong> para: <?php echo $s_query; ?></p>
            </br>
        </div>
        <div id="newslist">
            <ul>
                <?php foreach ($articles as $article): ?>
                <li>
                    <h2><a href="<?php echo _reg('site_url') . 'noticias/' . $article['slug']; ?>"><?php echo $article['title']; ?></a></h2>
                    <p class="article-date"><?php echo strftime('%d/%m/%G', strtotime($article['date_added'])); ?></p>
                    <a href="<?php echo _reg('site_url') . 'noticias/' . $article['slug'] . '#comments'; ?>" class="comments"> <img src="<?php _e('site_url'); ?>/images/icon_comments.png" alt="comentarios" /> <span>(<?php echo $article['comment_count'] ?> comentarios)</span> </a>
                    <?php if (isset($article['photo_uri'])): ?>
                    <a class="lightbox" href="<?php echo get_image_url($article['photo_uri'], false, _reg('site_url') . 'usrs/blog/'); ?>" title="<?php echo $article['title']; ?>"><img src="<?php echo get_image_url($article['photo_uri'], '210x210', _reg('site_url') . 'usrs/blog/'); ?>" alt="<?php echo $article['photo_name']; ?>" class="photo fleft" /></a>
                    <?php endif; ?>
                    <div class="excerpt">
                        <?php echo $article['excerpt']; ?>
                    </div>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>
<?php endif; ?>
<?php if ($events): ?>
<div id="events" class="section">
    <div class="header">
        <h4>AGENDA</h4>
    </div>
    <div class="content">
        <div id="newscats">
            <p>Resultados de la búsqueda en <strong>Agenda</strong> para: <?php echo $s_query; ?></p>
            </br>
        </div>
        <div id="eventslist">
            <?php foreach($events as $day => $events_per_day): ?>
            <div class="events-column">
                <div class="date-column">
                    <?php echo fecha($day, 'day'); ?> <?php echo fecha($day, 'shortmonthname'); ?>
                </div>
                <ul>
                    <?php foreach ($events_per_day as $event_id => $event): ?>
                    <li>
                        <?php if ($event['image']): ?>
                        <img src="<?php echo get_image_url($event['image'], '96x96', _reg('site_url') . 'usrs/events/'); ?>" alt="<?php echo $event['title']; ?>" class="photo fleft" />
                        <?php endif; ?>
                        <h3><a href="<?php echo _reg('site_url'); ?>agenda/<?php echo $event['slug']; ?>"><?php echo $event['title']; ?></a></h3>
                        <div class="excerpt">
                            <?php echo character_limiter($event['content'], 160); ?>
                        </div>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php endif; ?>
<?php if ($products): ?>
<div class="section sales">
    <div class="header_individual">
        <h4>PRODUCTOS</h4>
    </div>
    <div class="content" id="sales">
        <div >
            <p>Resultados de la búsqueda en <strong>Productos</strong> para: <?php echo $s_query; ?></p>
            </br>
        </div>
        <ul>
            <?php foreach($products as $product): ?>
            <?php
  	  // get the proper image filename and url
  	  if ($product['main_image']) {
  	    $image = _reg('site_url') . 'usrs/productos/' . $product['main_image'] . '_75x75.' . $product['main_ext'];
  	  } else {
  	    $image = _reg('site_url') . 'usrs/nophoto_75x75.jpg';
  	  }
  	  ?>
            <li> <a href="<?php echo _reg('module_url') . $product['slug']; ?>"><img src="<?php echo $image; ?>" alt="<?php echo $product['name']; ?>" class="photo fleft" /></a>
                <h3><a href="<?php echo _reg('module_url') . $product['slug']; ?>"><?php echo $product['name']; ?></a></h3>
                <div class="excerpt">
                    <?php echo substr($product['description'], 0, 60); ?>…
                </div>
                <div class="price">
                    <?php echo number_format($product['price'], 2, ',', '.'); ?> €
                </div>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
<?php endif; ?>
<?php if ($companies): ?>
<div class="section business">
    <div class="header_individual">
        <h4>EMPRESAS</h4>
    </div>
    <div class="content">
        <div id="newscats">
            <p>Resultados de la búsqueda en la <strong>Guía Comercial</strong> para: <?php echo $s_query; ?></p>
            </br>
        </div>
        <?php foreach($companies as $company): ?>
        <div id="bizdata_listado">
            <?php if ($company['logo']): ?>
            <?php
            // get the filename for the logo image:
            // slice the filename in name and extension, add file size suffix at the en of the name and stick it again
            $filename = pathinfo($company['logo'], PATHINFO_FILENAME);
            $fileext = strtolower(pathinfo($company['logo'], PATHINFO_EXTENSION));
            $logo_path = _reg('site_url') . 'usrs/empresas/' . $filename . '.' . $fileext;
            ?>
            <img src="<?php echo $logo_path; ?>" class="photo2" />
            <?php endif; ?>
            <h2><a href="<?php echo _reg('site_url'); ?>empresas/<?php echo $company['slug']; ?>"><?php echo $company['name']; ?></a></h2>
            <div class="excerpt">
                <?php echo substr($company['description'], 0, 180); ?>...
            </div>
            <div class="address">
                <p><?php echo $company['address']; ?><br />
                    <?php echo $company['zipcode']; ?> <?php echo $company['city']; ?> (<?php echo $company['state']; ?>)</p>
                <p>(T) <?php echo $company['phone']; ?></p>
                <p>(web) <?php echo $company['web']; ?></p>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>
<?php if ($basicads): ?>
<div class="section basicads">
    <div class="header_individual">
        <h4>CLASIFICADOS</h4>
    </div>
    <div class="content">
        <div class="basicadslist_seccion">
            <div id="newscats">
                <p>Resultados de la búsqueda en los <strong>Anuncios Clasificados</strong> para: <?php echo $s_query; ?></p>
                </br>
            </div>
            <ul>
                <?php foreach($basicads as $basicad): ?>
                <?php
  			// get the proper image filename and url
  			if ($basicad['uri']) {
  			  $image = get_image_url($basicad['uri'], '75x75', _reg('site_url') . 'usrs/clasificados/');
  			} else {
  			  $image = _reg('site_url') . 'usrs/nophoto_75x75.jpg';
  			}
  			?>
                <li> <img src="<?php echo $image; ?>" alt="<?php echo $basicad['title']; ?>" class="photo fleft" />
                    <div class="bacontent">
                        <h3><a href="<?php echo _reg('site_url'); ?>clasificados/<?php echo $basicad['slug']; ?>"><?php echo $basicad['title']; ?></a></h3>
                        <div class="excerpt">
                            <?php echo substr($basicad['content'], 0, 80); ?>…
                        </div>
                    </div>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>
<?php endif; ?>
<?php else: ?>
<div id="news" class="section news">
    <div class="header">
        <h4>LO SIENTO, NO SE ENCONTRÓ NADA RELACIONADO</h4>
    </div>
    <div id="newscats">
        <p>No hemos encontrado nada por su término de búsqueda <?php echo $s_query; ?>. Por favor, inténtelo de nuevo con otra búsqueda.</p>
        </br>
    </div>
</div>
<?php endif; ?>
