<?php if (isset($data['products']) and $data['products']): ?>
<div class="section sales">
	<div class="header"><h4>OFERTAS</h4></div>
  <div class="content">
  	<div class="saleslist">
  		<?php if (isset($data['products']) and $data['products']): ?>
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
  				<h3><a href="<?php echo _reg('module_url') . $product['slug']; ?>"><?php echo $product['name']; ?></a></h3>
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

<?php if (isset($data['articles']) and $data['articles']): ?>
<div id="news" class="section news">
  <div class="header"><h4>NOTICIAS</h4></div>
  <div class="content">
  	<div id="newslist">
  		<?php if ($data['articles']): ?>
  			<ul>
  				<?php foreach ($data['articles'] as $article): ?>
  				<li>
  				  <h2><a href="<?php echo _reg('site_url') . 'noticias/' . $article['slug']; ?>"><?php echo $article['title']; ?></a></h2>
  				  <p class="article-date"><?php echo strftime('%d/%m/%G', strtotime($article['date_added'])); ?></p>
  				  <?php if (isset($article['photo_uri'])): ?>
  						<img src="<?php echo get_image_url($article['photo_uri'], '96x96', _reg('site_url') . 'usrs/blog/'); ?>" alt="<?php echo $article['photo_name']; ?>" class="photo fleft" />
  					<?php endif; ?>
  				  <div class="excerpt"><?php echo $article['excerpt']; ?></div>
  				  <a href="<?php echo _reg('site_url') . 'noticias/' . $article['slug'] . '#comments'; ?>" class="comments">(<?php echo $article['comment_count'] ?> comentarios)</a>
  				</li>
  				<?php endforeach; ?>
  			</ul>
  		<?php else: ?>
  			<p>No hay noticias.</p>
  		<?php endif; ?>
  	</div><!-- #newslist -->
  </div><!-- .content -->
</div><!-- #news .section -->
<img src="http://placehold.it/234x60/ccc/fff&text=half+banner+(234x60)" alt="half banner (234x60px)" class="halfbanner" />
<?php endif; ?>