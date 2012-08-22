<div id="uecommerce" class="section user">
  <div class="header"><h4>Mi Tienda</h4></div>
  <div class="content uecommerce">
  <?php if ($shipping_method): ?>
  	<?php include_once('shipping_methods/' . $shipping_method . '.php'); ?>
  <?php else: ?>
  	<h6>Configuración de su tienda online en +Portales</h6>
  	<p>Desde aquí podrá gestionar la configuración las formas de pago de su tienda online o dar de alta nuevas formas de pago.</p>
  	<div class="buttons-top">
  		<a href="<?php echo _reg('site_url'); ?>micuenta/ecommerce/config/shipping" class="opsbtnoff-acc" id="new-shipping-method">Nuevo método de envío</a>
  		<ul id="new-shipping-method-options" class="opsbox-acc nodisplay">
  			<li><a href="<?php echo _reg('site_url') ?>micuenta/ecommerce/config/shipping/flatrate">Tarifa fija</a></li>
  		</ul>
  	</div>
  	<div id="shipping-methods">
  		<h6>Listado métodos de envío configurados</h6>
  		<?php if ($data): ?>
  			<table>
  				<tbody>	
  					<?php foreach ($data as $shipping_method): ?>
  				  <tr>
  				  	<?php
  				  	// get the proper image filename and url
  				  	if (file_exists(_reg('base_path') . _reg('theme_path') . 'images/shipping_methods/icon_' . $shipping_method['keyword'] . '.png')) {
  				  		$image = _reg('site_url'). _reg('theme_path') . 'images/shipping_methods/icon_' . $shipping_method['keyword'] . '.png';
  				  	} else {
  				  		$image = false;
  				  	}
  				  	?>
  				  	<td class="column-image"><img src="<?php echo $image; ?>" alt="<?php echo $shipping_method['name']; ?>" /></td>
  				  	<td class="column-title">
  				  		<p class="product-title"><a href="<?php echo _reg('site_url'); ?>micuenta/ecommerce/config/shipping/<?php echo $shipping_method['keyword']; ?>"><?php echo $shipping_method['name']; ?></a></p>
  				  		<p>Precio: <?php echo number_format($shipping_method['settings']['rate'], 2, ',', '.') . '<br />Tiempo de entrega: ' . $shipping_method['settings']['time']; ?></p>
  				  	</td>
  				  	<td class="column-button">
  				  		<p><a href="<?php echo _reg('site_url'); ?>micuenta/ecommerce/config/shipping/<?php echo $shipping_method['keyword']; ?>" class="btn">Editar</a></p>
  				  		<p><a href="<?php echo _reg('site_url'); ?>micuenta/ecommerce/config/shipping/<?php echo $shipping_method['keyword']; ?>" class="btn">Borrar</a></p>
  				  	</td>
  				  </tr>
  					<?php endforeach; ?>
  				</tbody>
  			</table>
  		<?php else: ?>
  			<p>No tiene aun ninguna forma de pago configurada en su tienda online.</p>
  		<?php endif; ?>
  	</div>
  <?php endif; ?>
  </div><!-- .content -->
</div><!-- #uecommerce .section .user -->
<script>
$(document).ready(function() {

	$('#new-shipping-method').click(function(e) {
		e.preventDefault();
		$("#new-shipping-method-options").toggle();
		$(this).toggleClass("opsbtnon-acc opsbtnoff-acc");
	});

});
</script>