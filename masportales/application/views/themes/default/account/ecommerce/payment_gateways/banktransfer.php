<h6>Configuración de su tienda online en +Portales</h6>
<p>Aquí podrá indicar el número de su cuenta bancaria para habilitar el pago por transferencia.</p>
<div class="buttons-top">
	<a href="../payment" class="btn-acc">Cancelar</a>
	<a href="#" onclick="document.getElementById('paymentgatewayform').submit();" class="btn-acc">Guardar</a>
</div>
<?php echo validation_errors(); ?>
<form action="<?php echo _reg('site_url'); ?>micuenta/ecommerce/config/payment/save" method="post" id="paymentgatewayform">
  <fieldset>
  	<legend>Pago por transferencia bancaria</legend>
  	<label for="bankname">Banco *</label><input type="text" name="bankname" id="bankname" value="<?php echo set_value('bankname'); ?>" />
  	<label for="cccnumber">Número de cuenta *</label><input type="text" name="cccnumber" id="cccnumber" value="<?php echo set_value('cccnumber'); ?>" />
  	<div class="message info">
  		<p>Formato del número de cuenta: 0000 0000 00 0000000000</p>
  	</div>
  	<label for="status">Estado</label>
  	<select name="status" id="status">
  	  <option value="0" <?php echo set_select('status', '0'); ?>>Deshabilitado</option>
  	  <option value="1" <?php echo set_select('status', '1'); ?>>Habilitado</option>
  	</select>
  	<label for="message">Descripción</label>
  	<textarea name="message"><?php echo set_value('message'); ?></textarea>
  	<input type="hidden" name="pgwy" value="<?php echo $payment_gateway; ?>" />
  </fieldset>
</form>
<div class="buttons-bottom">
	<a href="../payment" class="btn-acc">Cancelar</a>
	<a href="#" onclick="document.getElementById('paymentgatewayform').submit();" class="btn-acc">Guardar</a>
</div>

<?php //echo set_value('bankname', $data['payment_gateway']['bankname']); ?>