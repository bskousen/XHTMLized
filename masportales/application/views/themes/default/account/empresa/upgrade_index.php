<div id="ucompany" class="section user">
  <div class="header"><h4>Perfil de Empresa</h4></div>
  <div class="content ucompany">
  	<p>Seleccione los servicios que desea contratar para su empresa y la forma de pago.</p>
  	<div class="buttons-top"><a href="#" onclick="document.getElementById('companyupgradeform').submit();" class="btn-acc">Continuar</a></div>
  	<?php echo validation_errors(); ?>
  	<form action="<?php echo _reg('site_url'); ?>micuenta/empresa/upgrade/confirmation" method="post" id="companyupgradeform">
  		<div>
  			<h6>Servicios que va a contratar</h6>
  			<?php if (!$this->registry->company('premium')): ?>
  			<p><input type="checkbox" name="premium" <?php echo ($this->input->post('premium')) ? 'checked="checked"' : ''; ?> /> Contratar empresa oro.</p>
  			<?php endif; ?>
  			<?php if (!$this->registry->company('catalog')): ?>
  			<p><input type="checkbox" name="catalog" <?php echo ($this->input->post('catalog')) ? 'checked="checked"' : ''; ?> /> Contratar catalogo.</p>
  			<?php endif; ?>
  			<?php if (!$this->registry->company('ecommerce')): ?>
  			<p><input type="checkbox" name="ecommerce" <?php echo ($this->input->post('ecommerce')) ? 'checked="checked"' : ''; ?> /> Contratar tienda online.</p>
  			<?php endif; ?>
  		</div>
  		<?php // Check if there are payment gateways ?>
			<?php if ($data['payment']): ?>
			<div>
			  <h6>Forma de pago</h6>
			  <ul>
			  <?php foreach ($data['payment'] as $payment_gateway): ?>
			  	<li>
			  		<?php $pgid = $payment_gateway['payment_gateway_ID']; ?>
			  		<input type="radio" name="payment_gateway" value="<?php echo $pgid; ?>" <?php echo set_radio('payment', $pgid); ?> />
			  		<?php echo $payment_gateway['name']; ?>
			  	</li>
			  <?php endforeach; ?>
			  </ul>
			</div>
			<?php else: // !$data['payment'] ?>
			<div class="content">
			  <h6>Forma de pago</h6>
			  <p class="message">No se puede recuperar la información de las formas de pago disponibles en este momento. Vuelva a intentarlo más tarde.</p>
			  <input type="hidden" name="payment_gateway" value="0" />
			</div>
			<?php endif; // end ($data['payment']) ?>
  	</form>
  	<div class="buttons-bottom"><a href="#" onclick="document.getElementById('companyupgradeform').submit();" class="btn-acc">Continuar</a></div>
  </div><!-- .content -->
</div><!-- #ucompany .section .user -->
<?php
echo '<pre>';
print_r($this->_ci_cached_vars);
echo '</pre>';
?>