<div class="buttons">
	<a href="<?php _e('module_url'); ?>settings">cancelar</a>
	<a href="#" onclick="document.getElementById('settingsform').submit();">guardar</a>
</div>
<form action="<?php echo _reg('module_url') . $data['form_action']; ?>" method="post" enctype="multipart/form-data" id="settingsform">

<div class="section-box">
	<div class="header">
		<h3>Datos de la franquicia</h3>
	</div>
	<div class="content">
		<p>
			<label for="name">Nombre del portal</label>
		  <input type="text" id="name" name="name" class="large big" value="<?php echo $this->registry->site('name'); ?>" />
		</p>
		<p>
			<label for="address">Dirección</label>
		  <input type="text" id="address" name="address" class="large" value="<?php echo $this->registry->site('owner', 'address'); ?>" />
		</p>
		<p>
		  <label for="zipcode">Código Postal</label>
		  <input type="text" id="zipcode" name="zipcode" class="medium" value="<?php echo $this->registry->site('owner', 'zipcode'); ?>" />
		</p>
		<p>
		  <label for="city">Ciudad</label>
		  <input type="text" id="city" name="city" class="medium" value="<?php echo $this->registry->site('owner', 'city'); ?>" />
		</p>
		<p>
		  <label for="state">Provincia</label>
		  <input type="text" id="state" name="state" class="medium" value="<?php echo $this->registry->site('owner', 'state'); ?>" />
		</p>
		<p>
		  <label for="country">Pais</label>
		  <input type="text" id="country" name="country" class="medium" value="<?php echo $this->registry->site('owner', 'country'); ?>" />
		</p>
		<p>
		  <label for="phone">Teléfono</label>
		  <input type="text" id="phone" name="phone" class="medium" value="<?php echo $this->registry->site('owner', 'phone'); ?>" />
		</p>
	</div><!-- .content -->
</div><!-- .section-box -->

</form>
<div class="buttons">
	<a href="<?php _e('module_url'); ?>settings">cancelar</a>
	<a href="#" onclick="document.getElementById('settingsform').submit();">guardar</a>
</div>