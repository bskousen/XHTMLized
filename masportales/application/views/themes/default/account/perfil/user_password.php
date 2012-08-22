<div id="uprofile" class="section user">
  <div class="header"><h4>Perfil de Usuario</h4></div>
  <div class="content uprofile">
  	<p>Para cambiar su contraseña debe introducir su actual contraseña y dos veces la nueva contraseña.</p>
  	<div class="buttons-top"><a href="#" onclick="document.getElementById('userprofileform').submit();" class="btn-acc">Cambiar contraseña</a></div>
  	<?php echo validation_errors(); ?>
  	<form action="<?php echo _reg('site_url'); ?>micuenta/perfil/user/savepsw" method="post" id="userprofileform">
  		<fieldset>
  			<legend>Cambiar Contraseña</legend>
  			<label for="old_psw">Contraseña actual *</label><input type="password" name="old_psw" id="old_psw" value="<?php echo set_value('old_psw'); ?>" />
  			<label for="new_psw1">Nueva contraseña *</label><input type="password" name="new_psw1" id="new_psw1" value="<?php echo set_value('new_psw1'); ?>" />
  			<label for="new_psw2">Nueva contraseña *</label><input type="password" name="new_psw2" id="new_psw2" value="<?php echo set_value('new_psw2'); ?>" />
  		</fieldset>
  	</form>
  	<div class="buttons-bottom"><a href="#" onclick="document.getElementById('userprofileform').submit();" class="btn-acc">Cambiar contraseña</a></div>
  </div><!-- .content -->
</div><!-- #uprofile .section .user -->