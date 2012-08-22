<fieldset>
	<p><label for="bankname">Banco</label><input type="text" name="bankname" class="medium" value="<?php echo (isset($data['payment_gateway']['bankname'])) ? $data['payment_gateway']['bankname'] : ''; ?>" /></p>
  <p>
  	<label for="cccnumber">Número de la cuenta</label>
  	<input type="text" id="cccnumber" name="cccnumber" class="medium" value="<?php echo (isset($data['payment_gateway']['cccnumber'])) ? $data['payment_gateway']['cccnumber'] : ''; ?>" />
  	<span class="message info">Formato del número de cuenta: 0000 0000 00 0000000000</span>
  </p>
  <p>
  	<label for="message">Comentarios</label>
  	<textarea name="message"><?php echo (isset($data['payment_gateway']['message'])) ? $data['payment_gateway']['message'] : ''; ?></textarea>
  </p>
  <p>
  <label for="status">Estado</label>
  <select name="status" id="status">
    <option value="deshabilitado" <?php echo (isset($data['payment_gateway']['status']) and $data['payment_gateway']['status'] == 'deshabilitado') ? 'selected="selected"' : ''; ?>>Deshabilitado</option>
    <option value="habilitado" <?php echo (isset($data['payment_gateway']['status']) and $data['payment_gateway']['status'] == 'habilitado') ? 'selected="selected"' : ''; ?>>Habilitado</option>
  </select>
  </p>
</fieldset>