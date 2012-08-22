<div class="buttons">
	<span>
		<a href="<?php _e('module_url'); ?>user">lista de usuarios</a>
		<a href="<?php _e('module_url'); ?>user/edit">nuevo usuario</a>
	</span>
	<a href="<?php _e('module_url'); ?>user/">cancelar</a>
	<a href="#" onclick="document.getElementById('usermeform').submit();">guardar</a>
</div>
<div class="section-box">
	<div class="header">
		<?php if ($data['user']): ?>
			<h3><span>Editar usuario:</span> <?php echo $data['user']['display_name']; ?></h3>
		<?php else: ?>
			<h3>Nuevo usuario</h3>
		<?php endif; ?>
	</div>
	<div class="content">
		<form action="<?php _e('module_url'); ?>user/save" method="post" enctype="multipart/form-data" id="usermeform">
			<div class="column-right">
				<div class="section-box">
					<div class="header">
						<h3>Datos del perfil</h3>
					</div><!-- .header -->
					<div class="content">
						<p>
			        <label for="status">Estado</label>
			        <select name="status">
			        	<option value="1"<?php echo ($data['user']['status'] == '1') ? ' selected="selected"' : ''; ?>>Habilitado</option>
			        	<option value="0"<?php echo ($data['user']['status'] == '0') ? ' selected="selected"' : ''; ?>>Deshabilitado</option>
			        </select>
			      </p>
			      <p>
			        <label for="roles">Perfil del usuario</label>
			        <select name="roles[]" multiple="multiple">
			        	<?php foreach($data['roles'] as $role): ?>
			        	<option value="<?php echo $role['role_ID']; ?>"<?php echo (in_array($role['role_ID'], $data['user_roles'])) ? ' selected="selected"' : ''; ?>><?php echo $role['name']; ?></option>
			        	<?php endforeach; ?>
			        </select>
			      </p>
					</div><!-- .content -->
				</div><!-- .section-box -->
			</div><!-- .column-right -->
			<fieldset>
				<p>
					<label for="username">Nombre de usuario</label>
					<input type="text" id="username" name="username" class="medium" value="<?php echo $data['user']['username']; ?>" />
				</p>
				<p>
					<label for="email">Email</label>
					<input type="text" id="email" name="email" class="medium" value="<?php echo $data['user']['email']; ?>" />
				</p>
				<p>
					<label for="pass1">Contraseña</label>
					<input type="password" id="pass1" name="pass1" class="medium" value="" />
					<span class="message">Si no desea modificar su contraseña deje este campo en blanco.</span>
				</p>
				<p>
					<label for="pass2">Repite contraseña</label>
					<input type="password" id="pass2" name="pass2" class="medium" value="" />
					<span class="message">Si no desea modificar su contraseña deje este campo en blanco.</span>
				</p>
				<p>
					<label for="nif">N.I.F.</label>
					<input type="text" id="nif" name="nif" class="medium" value="<?php echo $data['user']['nif']; ?>" />
				</p>
				<p>
					<label for="name">Nombre</label>
					<input type="text" id="name" name="name" class="medium" value="<?php echo $data['user']['name']; ?>" />
				</p>
				<p>
					<label for="surname">Apellidos</label>
					<input type="text" id="surname" name="surname" class="medium" value="<?php echo $data['user']['surname']; ?>" />
				</p>
				<p>
					<label for="address">Dirección</label>
					<input type="text" id="address" name="address" class="medium" value="<?php echo $data['user']['address']; ?>" />
				</p>
				<p>
					<label for="zipcode">Código postal</label>
					<input type="text" id="zipcode" name="zipcode" class="medium" value="<?php echo $data['user']['zipcode']; ?>" />
				</p>
				<p>
					<label for="city">Ciudad</label>
					<input type="text" id="city" name="city" class="medium" value="<?php echo $data['user']['city']; ?>" />
				</p>
				<p>
					<label for="state">Provincia</label>
					<input type="text" id="state" name="state" class="medium" value="<?php echo $data['user']['state']; ?>" />
				</p>
				<p>
					<label for="country">Pais</label>
					<input type="text" id="country" name="country" class="medium" value="<?php echo $data['user']['country']; ?>" />
				</p>
				<p>
					<label for="phone">Teléfono</label>
					<input type="text" id="phone" name="phone" class="medium" value="<?php echo $data['user']['phone']; ?>" />
				</p>
				<p>
					<label for="web">Web</label>
					<input type="text" id="web" name="web" class="medium" value="<?php echo $data['user']['web']; ?>" />
				</p>
			</fieldset>
			<input type="hidden" name="userid" value="<?php echo $data['user']['user_ID']; ?>" />
		</form>
		
	</div>
</div>
<div class="buttons">
	<a href="<?php _e('admin_url'); ?>">cancelar</a>
	<a href="#" onclick="document.getElementById('usermeform').submit();">guardar</a>
</div>