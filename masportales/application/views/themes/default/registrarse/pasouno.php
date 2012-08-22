<div id="signup" class="section user nolog">
  <div class="header"><h4>REGÍSTRATE</h4></div>
  <div class="content">
  	<p></p>
  	<?php echo validation_errors(); ?>
  	<form action="<?php echo _reg('site_url') . 'registrarse/pasodos'; ?>" method="post">
  		<fieldset>
  			<legend>Datos de registro</legend>
  			<label for="nif">DNI</label><input type="text" name="nif" id="nif" value="<?php echo set_value('nif'); ?>" />
  			<label for="name">Nombre</label><input type="text" name="name" id="name" value="<?php echo set_value('name'); ?>" />
  			<label for="surname">Apellidos</label><input type="text" name="surname" id="surname" value="<?php echo set_value('surname'); ?>" />
  			<label for="email">Email</label><input type="text" name="email" id="email" value="<?php echo set_value('email'); ?>" />
  			<label for="username">Nombre de usuario</label><input type="text" name="username" id="username" value="<?php echo set_value('username'); ?>" />
  			<label for="password">Contraseña</label><input type="password" name="password" id="password" value="<?php echo set_value('password'); ?>" />
  			<label for="password2">Repite contraseña</label><input type="password" name="password2" id="password2" value="<?php echo set_value('password2'); ?>" />
  		</fieldset>
  		<input type="submit" value="Enviar" />
  	</form>
  </div><!-- .content -->
</div><!-- #signup .section -->
<img src="http://placehold.it/468x60/ccc/fff&text=full+banner+(468x60)" alt="full banner (468x60px)" class="fullbanner" />