<h6>Configuración de su tienda online en +Portales</h6>
<p>Aquí podrá indicar un coste fijo para el envío de los productos de su tienda online.</p>
<div class="buttons-top">
	<a href="../shipping" class="btn-acc">Cancelar</a>
	<a href="#" onclick="document.getElementById('shippingmethodform').submit();" class="btn-acc">Guardar</a>
</div>
<?php echo validation_errors(); ?>
<form action="<?php echo _reg('site_url'); ?>micuenta/ecommerce/config/shipping/save" method="post" id="shippingmethodform">
  <fieldset>
  	<legend>Tarifa fija de envío</legend>
  	<label for="rate">Importe *</label><input type="text" name="rate" id="rate" value="<?php echo set_value('rate'); ?>" />
  	<label for="time">Tiempo estimado de entrega (en días) *</label><input type="text" name="time" id="time" value="<?php echo set_value('time'); ?>" />
  	<label for="status">Estado</label>
  	<select name="status" id="status">
  	  <option value="0" <?php echo set_select('status', '0'); ?>>Deshabilitado</option>
  	  <option value="1" <?php echo set_select('status', '1'); ?>>Habilitado</option>
  	</select>
  	<label for="message">Descripción</label>
  	<textarea name="message"><?php echo set_value('message'); ?></textarea>
  	<input type="hidden" name="shng" value="<?php echo $shipping_method; ?>" />
  </fieldset>
</form>
<div class="buttons-bottom">
	<a href="../shipping" class="btn-acc">Cancelar</a>
	<a href="#" onclick="document.getElementById('shippingmethodform').submit();" class="btn-acc">Guardar</a>
</div>

<?php //echo set_value('bankname', $data['payment_gateway']['bankname']); ?>