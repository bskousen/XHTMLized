<div class="section sales">
	<div class="header"><h4>OFERTAS</h4></div>
  <div class="content">
  	<div class="saleslist">
  		<?php if ($products = $this->registry->column_item('productos')): ?>
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
  			<li>
  				<h3><a href="<?php echo _reg('site_url'); ?>tienda/<?php echo $product['slug']; ?>"><?php echo $product['name']; ?></a></h3>
  				<a class="lightbox" href="<?php echo _reg('site_url') . 'usrs/productos/' . $product['main_image'] . '.' . $product['main_ext']; ?>" title="<?php echo $product['name']; ?>">
  					<img src="<?php echo $image; ?>" alt="<?php echo $product['name']; ?>" class="photo fleft" />
  				</a>
  				<div class="excerpt"><?php echo substr($product['description'], 0, 60); ?>…</div>
  				<div class="price"><?php echo number_format($product['price'], 2, ',', '.'); ?> €</div>
  			</li>
  			<?php endforeach; ?>
  		</ul>
  		<?php else: ?>
  		<p class="message info">No hay ningún producto en la tienda online ahora mismo.</p>
  		<?php endif; ?>
  	</div><!-- #saleslist -->
  </div><!-- .content -->
  <div class="search productsearch">
	<form method="post" action="<?php echo _reg('site_url'); ?>tienda/search" name="productsearchcolumnform">
	  <p><input name="searchquery" type="text" value="Buscar en productos..." />
	  <a href="javascript:document.productsearchcolumnform.submit();" id="search-btn"><img src="<?php echo _reg('site_url') . _reg('theme_path'); ?>images/btn_search.png" alt="buscar" /></a></p>
	</form>
	</div><!-- #productsearch -->
</div><!-- #sales .section -->