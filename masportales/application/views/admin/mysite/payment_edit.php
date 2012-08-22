<div class="buttons">
	<span>
		<a href="<?php _e('module_url'); ?>payment">lista de formas de pago</a>
	</span>
	<a href="<?php _e('module_url'); ?>payment">cancelar</a>
	<a href="#" onclick="document.getElementById('paymentform').submit();">guardar</a>
</div>
<div class="section-box">
	<div class="header">
		<h3><span>Editar forma de pago:</span> <?php echo $data['payment_gateway']['name']; ?></h3>
	</div>
	<div class="content">
		
		<form action="<?php _e('module_url'); ?>payment/save" method="post" enctype="multipart/form-data" id="paymentform">
			<?php
			if (file_exists(_reg('base_path') . APPPATH . '/views/admin/mysite/payment_gateways/' . $data['payment_gateway']['keyword'] . '.php')) {
		  	include_once('payment_gateways/'. $data['payment_gateway']['keyword'] . '.php');
		  } else {
		    echo '<div class="message error"><p>No se encuentra la plantilla de edición de la forma de pago.</p></div>';
		  }
			?>
			<input type="hidden" name="bid" value="<?php echo $data['payment_gateway']['payment_gateway_ID']; ?>" />
		</form>
		
	</div>
</div>
<div class="buttons">
	<a href="<?php _e('module_url'); ?>payment">cancelar</a>
	<a href="#" onclick="document.getElementById('paymentform').submit();">guardar</a>
</div>