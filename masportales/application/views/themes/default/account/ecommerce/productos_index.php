<div id="uecommerce" class="section user">
  <div class="header"><h4>Mi Tienda</h4></div>
  <div class="content uecommerce">
  	<h6>Bienvenido a su tienda online en +Portales</h6>
  	<p>Desde aquí podrá gestionar los productos, pedidos y configuración de su tienda.</p>
  	<div class="buttons-top">
  		<a href="<?php echo _reg('site_url'); ?>micuenta/ecommerce/productos/new" class="btn-acc">Crear producto</a>
  	</div>
  	<div id="product-list">
  		<h6>Listado de productos</h6>
  		<?php if ($data): ?>
  			<table>
  				<tbody>	
  					<?php foreach ($data as $product): ?>
  				  <tr>
  				  	<?php
  				  	// get the proper image filename and url
  				  	if ($product['main_image']) {
  				  		$image = _reg('site_url') . 'usrs/productos/' . $product['main_image'] . '_75x75.' . $product['main_ext'];
  				  	} else {
  				  		$image = _reg('site_url') . 'usrs/nophoto_75x75.jpg';
  				  	}
  				  	?>
  				  	<td class="column-checks"><input type="checkbox" name="product[]" /></td>
  				  	<td class="column-image"><img src="<?php echo $image; ?>" alt="<?php echo $product['name']; ?>" /></td>
  				  	<td class="column-title">
  				  		<p class="title"><a href="<?php echo _reg('site_url'); ?>micuenta/ecommerce/productos/edit/<?php echo $product['product_ID']; ?>"><?php echo $product['name']; ?></a></p>
  				  		<p><?php echo substr($product['description'], 0, 130); ?>…</p>
  				  	</td>
  				  	<td class="column-button">
  				  		<p><a href="<?php echo _reg('site_url'); ?>micuenta/ecommerce/productos/edit/<?php echo $product['product_ID']; ?>" class="btn">Editar</a></p>
  				  		<p><a href="<?php echo _reg('site_url'); ?>micuenta/ecommerce/productos/delete/<?php echo $product['product_ID']; ?>" class="btn">Borrar</a></p>
  				  	</td>
  				  </tr>
  					<?php endforeach; ?>
  				</tbody>
  			</table>
  		<?php else: ?>
  			<p>No tiene aun ningún producto en su tienda online.</p>
  		<?php endif; ?>
  	</div>
  	<div class="buttons-bottom">
  		<a href="<?php echo _reg('site_url'); ?>micuenta/ecommerce/productos/new" class="btn-acc">Crear producto</a>
  	</div>
  </div><!-- .content -->
</div><!-- #uecommerce .section .user -->