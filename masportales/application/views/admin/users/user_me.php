<div class="buttons">
	<a href="<?php _e('admin_url'); ?>">cancelar</a>
	<a href="#" onclick="document.getElementById('usermeform').submit();">guardar</a>
</div>
<div class="section-box">
	<div class="header">
		<h3>Editar mi usuario</h3>
	</div>
	<div class="content">
		<form action="<?php _e('module_url'); ?>user/update" method="post" enctype="multipart/form-data" id="usermeform">
			<fieldset>
				<p>
					<label for="username">Nombre de usuario</label>
					<input type="text" id="username" name="username" class="medium" value="<?php echo $this->registry->user('username'); ?>" />
				</p>
				<p>
					<label for="email">Email</label>
					<input type="text" id="email" name="email" class="medium" value="<?php echo $this->registry->user('email'); ?>" />
				</p>
				<p>
					<label for="pass1">Contraseña</label>
					<input type="password" id="pass1" name="pass1" class="medium" value="<?php echo $this->registry->user('pass1'); ?>" />
					<span class="message">Si no desea modificar su contraseña deje este campo en blanco.</span>
				</p>
				<p>
					<label for="pass2">Repite contraseña</label>
					<input type="password" id="pass2" name="pass2" class="medium" value="<?php echo $this->registry->user('pass2'); ?>" />
					<span class="message">Si no desea modificar su contraseña deje este campo en blanco.</span>
				</p>
				<p>
					<label for="nif">N.I.F.</label>
					<input type="text" id="nif" name="nif" class="medium" value="<?php echo $this->registry->user('nif'); ?>" />
				</p>
				<p>
					<label for="name">Nombre</label>
					<input type="text" id="name" name="name" class="medium" value="<?php echo $this->registry->user('name'); ?>" />
				</p>
				<p>
					<label for="surname">Apellidos</label>
					<input type="text" id="surname" name="surname" class="medium" value="<?php echo $this->registry->user('surname'); ?>" />
				</p>
				<p>
					<label for="address">Dirección</label>
					<input type="text" id="address" name="address" class="medium" value="<?php echo $this->registry->user('address'); ?>" />
				</p>
				<p>
					<label for="zipcode">Código postal</label>
					<input type="text" id="zipcode" name="zipcode" class="medium" value="<?php echo $this->registry->user('zipcode'); ?>" />
				</p>
				<p>
					<label for="city">Ciudad</label>
					<input type="text" id="city" name="city" class="medium" value="<?php echo $this->registry->user('city'); ?>" />
				</p>
				<p>
					<label for="state">Provincia</label>
					<input type="text" id="state" name="state" class="medium" value="<?php echo $this->registry->user('state'); ?>" />
				</p>
				<p>
					<label for="country">Pais</label>
					<input type="text" id="country" name="country" class="medium" value="<?php echo $this->registry->user('country'); ?>" />
				</p>
				<p>
					<label for="phone">Teléfono</label>
					<input type="text" id="phone" name="phone" class="medium" value="<?php echo $this->registry->user('phone'); ?>" />
				</p>
				<p>
					<label for="web">Web</label>
					<input type="text" id="web" name="web" class="medium" value="<?php echo $this->registry->user('web'); ?>" />
				</p>
			</fieldset>
		</form>
		
	</div>
</div>
<div class="buttons">
	<a href="<?php _e('admin_url'); ?>">cancelar</a>
	<a href="#" onclick="document.getElementById('usermeform').submit();">guardar</a>
</div>