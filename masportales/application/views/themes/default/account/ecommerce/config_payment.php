<div id="uecommerce" class="section user">
  <div class="header"><h4>Mi Tienda</h4></div>
  <div class="content uecommerce">
  <?php if ($payment_gateway): ?>
  	<?php include_once('payment_gateways/' . $payment_gateway . '.php'); ?>
  <?php else: ?>
  	<h6>Configuración de su tienda online en +Portales</h6>
  	<p>Desde aquí podrá gestionar la configuración las formas de pago de su tienda online o dar de alta nuevas formas de pago.</p>
  	<div class="buttons-top">
  		<a href="<?php echo _reg('site_url'); ?>micuenta/ecommerce/config/payment" class="opsbtnoff-acc" id="new-payment-gateway">Nueva forma de pago</a>
  		<ul id="new-payment-gateway-options" class="opsbox-acc nodisplay">
  			<li><a href="payment/banktransfer">Transferencia bancaria</a></li>
  			<li><a href="payment/paypal">Paypal</a></li>
  		</ul>
  	</div>
  	<div id="payment-gateways">
  		<h6>Listado formas de pago configuradas</h6>
  		<?php if ($data): ?>
  			<table>
  				<tbody>	
  					<?php foreach ($data as $payment_gateway): ?>
  				  <tr>
  				  	<?php
  				  	// get the proper image filename and url
  				  	if (file_exists(_reg('base_path') . _reg('theme_path') . 'images/payment_gateways/icon_' . $payment_gateway['keyword'] . '.png')) {
  				  		$image = _reg('site_url'). _reg('theme_path') . 'images/payment_gateways/icon_' . $payment_gateway['keyword'] . '.png';
  				  	} else {
  				  		$image = false;
  				  	}
  				  	?>
  				  	<td class="column-image"><img src="<?php echo $image; ?>" alt="<?php echo $payment_gateway['name']; ?>" /></td>
  				  	<td class="column-title">
  				  		<p class="product-title"><a href="<?php echo _reg('site_url'); ?>micuenta/ecommerce/config/payment/<?php echo $payment_gateway['keyword']; ?>"><?php echo $payment_gateway['name']; ?></a></p>
  				  		<p><?php echo $payment_gateway['settings']['bankname'] . ' - ' . $payment_gateway['settings']['cccnumber']; ?></p>
  				  	</td>
  				  	<td class="column-button">
  				  		<p><a href="<?php echo _reg('site_url'); ?>micuenta/ecommerce/config/payment/<?php echo $payment_gateway['keyword']; ?>" class="btn">Editar</a></p>
  				  		<p><a href="<?php echo _reg('site_url'); ?>micuenta/ecommerce/config/payment/<?php echo $payment_gateway['keyword']; ?>" class="btn">Borrar</a></p>
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

	$('#new-payment-gateway').click(function(e) {
		e.preventDefault();
		$("#new-payment-gateway-options").toggle();
		$(this).toggleClass("opsbtnon-acc opsbtnoff-acc");
	});

});
</script>