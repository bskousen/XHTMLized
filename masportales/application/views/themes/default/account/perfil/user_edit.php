<div id="uprofile" class="section user">
  <div class="header"><h4>Perfil de Usuario</h4></div>
  <div class="content uprofile">
  	<p>Le recomendamos que rellene todos los datos para que podamos ofrecerle los mejores servicios disponibles.</p>
  	<div class="buttons-top"><a href="#" onclick="document.getElementById('userprofileform').submit();" class="btn-acc">Guardar</a></div>
  	<?php echo validation_errors(); ?>
  	<form action="<?php echo _reg('site_url'); ?>micuenta/perfil/user/save" method="post" id="userprofileform">
  		<fieldset>
  			<legend>Datos del usuario</legend>
  			<label for="username">Nombre de usuario *</label><input type="text" name="username" id="username" value="<?php echo set_value('username', $this->registry->user('username')); ?>" />
  			<label for="email">Email *</label><input type="text" name="email" id="email" value="<?php echo set_value('email', $this->registry->user('email')); ?>" />
  		</fieldset>
  		<fieldset>
  			<legend>Datos de contacto</legend>
  			<label for="nif">N.I.F.</label><input type="text" name="nif" id="nif" value="<?php echo set_value('nif', $this->registry->user('nif')); ?>" />
  			<label for="name">Nombre</label><input type="text" name="name" id="name" value="<?php echo set_value('name', $this->registry->user('name')); ?>" />
  			<label for="surname">Apellidos</label><input type="text" name="surname" id="surname" value="<?php echo set_value('surname', $this->registry->user('surname')); ?>" />
  			<label for="address">Dirección</label><input type="text" name="address" id="address" value="<?php echo set_value('address', $this->registry->user('address')); ?>" />
  			<label for="zipcode">Código Postal</label><input type="text" name="zipcode" id="zipcode" value="<?php echo set_value('zipcode', $this->registry->user('zipcode')); ?>" />
  			<label for="city">Ciudad</label><input type="text" name="city" id="city" value="<?php echo set_value('city', $this->registry->user('city')); ?>" />
  			<label for="state">Provincia</label><input type="text" name="state" id="state" value="<?php echo set_value('state', $this->registry->user('state')); ?>" />
  			<label for="country">Pais</label><input type="text" name="country" id="country" value="<?php echo set_value('country', $this->registry->user('country')); ?>" />
  			<label for="phone">Teléfono</label><input type="text" name="phone" id="phone" value="<?php echo set_value('phone', $this->registry->user('phone')); ?>" />
  			<label for="web">Web</label><input type="text" name="web" id="web" value="<?php echo set_value('web', $this->registry->user('web')); ?>" />
  		</fieldset>
  	</form>
  	<div class="buttons-bottom"><a href="#" onclick="document.getElementById('userprofileform').submit();" class="btn-acc">Guardar</a></div>
  </div><!-- .content -->
</div><!-- #uprofile .section .user -->