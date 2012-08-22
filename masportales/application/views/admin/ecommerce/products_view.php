<div class="buttons">
	<span>
		<a href="<?php _e('module_url'); ?>products">lista de productos</a>
	</span>
	<a href="<?php _e('module_url'); ?>products/">volver</a>
	<a href="<?php _e('module_url'); ?>products/delete/<?php echo $data['product']['product_ID']; ?>">borrar</a>
</div>
<div class="section-box">
	<div class="header">
		<?php if ($data['product']): ?>
			<h3><span>Ver producto:</span> <?php echo $data['product']['name']; ?></h3>
		<?php else: ?>
			<h3>Nuevo producto</h3>
		<?php endif; ?>
	</div>
	<div class="content">
		<form action="<?php _e('module_url'); ?>products/save" method="post" enctype="multipart/form-data" id="productform">
			<div class="column-right">
				<div class="section-box">
					<div class="header">
						<h3>Más Información</h3>
					</div><!-- .header -->
					<div class="content">
						<p>
							<label for="price">Precio</label>
							<p class="view title"><?php echo number_format($data['product']['price'], 2, ',', '.'); ?> €</p>
						</p>
						<p>
							<label for="sku">Núm. Referencia</label>
							<p class="view"><?php echo $data['product']['sku']; ?></p>
						</p>
						<p>
							<label for="model">Modelo</label>
							<p class="view"><?php echo $data['product']['model']; ?></p>
						</p>
						<p>
							<label for="date_added">Creado el</label>
							<p class="view"><?php echo fecha($data['product']['date_added'], 'medium'); ?></p>
						</p>
					</div><!-- .content -->
				</div><!-- .section-box -->
				<div class="section-box">
					<div class="header">
						<h3>Imágenes del producto</h3>
					</div><!-- .header -->
					<div class="content">
						<ul id="imglist">
  					<?php if ($data['product_images']): ?>
  						<?php foreach ($data['product_images'] as $image): ?>
  						<li>
  							<img src="<?php echo _reg('site_url'); ?>usrs/productos/<?php echo $image['name']; ?>_75x75.<?php echo $image['ext']; ?>" />
  						</li>
  						<?php endforeach; ?>
  					<?php endif; ?>
  					</ul><!-- #imglist -->
  				</div><!-- .content -->
				</div><!-- .section-box -->
			</div><!-- .column-right -->
			<fieldset>
				<p>
					<label for="name">Nombre del producto</label>
					<p class="view title"><?php echo $data['product']['name']; ?></p>
				</p>
				<p>
					<label for="slug">URL amigable</label>
					<p class="view"><?php echo $data['product']['slug']; ?></p>
				</p>
				<p>
					<label for="description">Descripción</label>
					<div class="view description">
						<?php echo $data['product']['description']; ?>
					</div>
				</p>
			</fieldset>
			<input type="hidden" name="cid" value="<?php echo $data['product']['product_ID']; ?>" />
		</form>
		
	</div>
</div>
<div class="buttons">
	<a href="<?php _e('module_url'); ?>products/">volver</a>
	<a href="<?php _e('module_url'); ?>products/delete/<?php echo $data['product']['product_ID']; ?>">borrar</a>
</div>