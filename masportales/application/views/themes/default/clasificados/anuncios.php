<div class="section basicads">
	<div class="header_individual"><h4>CLASIFICADOS</h4></div>
	<?php if ($data['search_query'] and $data['basicads']): ?>
  <div>
    <p class="message">Resultados para la búsqueda: <?php echo $data['search_query']; ?></p>
  </div>
  <?php endif; ?>
  <div class="content">
  	<div class="basicadslist_seccion">
  		<?php if ($data['basicads']): ?>
  		<ul>
  			<?php foreach($data['basicads'] as $basicad): ?>
  		  <?php
  			// get the proper image filename and url
  			if ($basicad['uri']) {
  			  $image = get_image_url($basicad['uri'], '75x75', _reg('site_url') . 'usrs/clasificados/');
  			} else {
  			  $image = _reg('site_url') . 'usrs/nophoto_75x75.jpg';
  			}
  			?>
  			<li>
  				<img src="<?php echo $image; ?>" alt="<?php echo $basicad['title']; ?>" class="photo fleft" />
  				<div class="bacontent">
  					<h3><a href="<?php echo _reg('site_url'); ?>clasificados/<?php echo $basicad['slug']; ?>"><?php echo $basicad['title']; ?></a></h3>
  					<div class="excerpt2"><?php echo substr( strip_tags($basicad['content']), 0, 80); ?>…</div>
  				</div>
  			</li>
  			<?php endforeach; ?>
  		</ul>
  		<?php else: ?>
  		<p class="message">No hay ningún anuncio clasificado<?php echo ($data['search_query']) ? ' para la busqueda \'' . $data['search_query'] . '\'' : ''; ?>.</p>
  		<?php endif; ?>
  	</div><!-- #basicadslist -->
  </div><!-- .content -->
  <div class="search clasificadossearch">
	<form method="post" action="<?php echo _reg('site_url'); ?>clasificados/search" name="clasificadossearchform">
	  <p><input name="searchquery" type="text" value="Buscar clasificados..." />
	  <a href="javascript:document.clasificadossearchform.submit();" id="search-btn"><img src="<?php echo _reg('site_url') . _reg('theme_path'); ?>images/btn_search.png" alt="buscar" /></a></p>
	</form>
	</div><!-- .clasificadossearch -->
</div><!-- .section .basicads -->