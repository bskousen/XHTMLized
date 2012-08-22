<div class="section business">
	<div class="header"><h4>EMPRESAS</h4></div>
<?php if ($companies = $this->registry->column_item('empresas')): ?>
  	<?php foreach ($companies as $company): ?>
  	<div class="content">
  		<div id="bizdata">
  			<?php if ($company['logo']): ?>
  				<?php
  				// get the filename for the logo image:
  				// slice the filename in name and extension, add file size suffix at the en of the name and stick it again
  				$filename = pathinfo($company['logo'], PATHINFO_FILENAME);
  				$fileext = strtolower(pathinfo($company['logo'], PATHINFO_EXTENSION));
  				$logo_path = _reg('site_url') . 'usrs/empresas/' . $filename . '.' . $fileext;
  				?>
  				<img src="<?php echo $logo_path; ?>" class="photo" />
  			<?php endif; ?>
  			<h2><a href="<?php echo _reg('site_url'); ?>empresas/<?php echo $company['slug']; ?>"><?php echo $company['name']; ?></a></h2>
  			<div class="excerpt"><?php echo substr($company['description'], 0, 180); ?>...</div>
  			<div class="address">
  				<p><?php echo $company['address']; ?>, <?php echo $company['zipcode']; ?> <?php echo $company['city']; ?> (<?php echo $company['state']; ?>)</p>
  				<p><?php echo $company['phone']; ?></p>
  				<p><?php echo $company['web']; ?></p>
  				<?php
  				$gmap_address = urlencode($company['address'] . ', ' . $company['zipcode'] . ', ' . $company['city'] . ', ' . $company['country']);
  				?>
  				<p><a href="http://maps.google.es/maps?q=<?php echo $gmap_address; ?>" target="_blank">Ver en mapa</a></p>
  			</div><!-- .address -->
  		</div><!-- #bizdata -->
  	</div><!-- .content -->
  	<?php endforeach; ?>
  <?php else: ?>
  <div class="content">
  	<p class="message info">No hay ninguna empresa en la Guía de Empresas.</p>
  	<p><a href="<?php echo _reg('site_url'); ?>registrarse">De de alta su empresa…</a></p>
  </div>
  <?php endif; ?>
  <div class="search companiessearch"><div class="search-btn">
	<form method="post" action="<?php echo _reg('site_url'); ?>empresas/search" name="companiessearchcolumnform">
	  <p><label class="input"> <span>Buscar en empresas</span><input name="searchquery" type="text" /></label>
	  <a href="javascript:document.companiessearchcolumnform.submit();" id="search-btn"><img src="<?php echo _reg('site_url') . _reg('theme_path'); ?>images/btn_search.png" alt="buscar" /></a></p>
	</form></div>
	</div><!-- .companiessearch -->
</div><!-- #business .section -->