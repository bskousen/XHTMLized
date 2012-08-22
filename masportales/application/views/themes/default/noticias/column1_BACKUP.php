<?php if (isset($data['attachments']) and $data['attachments']): ?>
<div id="news-column1" class="section news">
	<div class="header"><h4>Galería</h4></div>
  <div class="content">
  	<div id="newsattach">
  		<ul>
  			<?php foreach ($data['attachments'] as $attachment): ?>
  			<li>
  				<img src="<?php echo get_image_url($attachment['uri'], '210x210', _reg('site_url') . 'usrs/blog/'); ?>" alt="" class="photo" />
  			</li>
  			<?php endforeach; ?>
  		</ul>
  	</div><!-- #newsattach -->
  </div><!-- .content -->
</div><!-- #news-column1 .section -->
<?php endif; ?>

<?php if (isset($data['categories']) and $data['categories']): ?>
<div id="cats-column1" class="section news">
	<div class="header"><h4>Categorías</h4></div>
  <div class="content">
  	<div id="categories">
  		<ul>
  			<?php foreach ($data['categories'] as $category): ?>
  			<li>
  				<a href="<?php echo $category['slug']; ?>" class="btn-news"><?php echo $category['name']; ?></a>
  			</li>
  			<?php endforeach; ?>
  		</ul>
  	</div><!-- #newsattach -->
  </div><!-- .content -->
</div><!-- #news-column1 .section -->
<img src="http://placehold.it/234x60/ccc/fff&text=half+banner+(234x60)" alt="half banner (234x60px)" class="halfbanner" />
<?php endif; ?>

<?php if (isset($data['categories']) and $data['categories']): ?>
<div class="section sales">
	<div class="header"><h4>OFERTAS</h4></div>
  <div class="content">  
  	<div class="saleslist">
  		<?php if ( isset($data['products']) and $data['products']): ?>
  		<ul>
  			<?php foreach($data['products'] as $product): ?>
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
  				<img src="<?php echo $image; ?>" alt="<?php echo $product['name']; ?>" class="photo fright" />
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
</div><!-- #sales .section -->
<img src="http://placehold.it/234x60/ccc/fff&text=half+banner+(234x60)" alt="half banner (234x60px)" class="halfbanner" />
<?php endif; ?>