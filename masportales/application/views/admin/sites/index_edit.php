<div class="buttons">
	<span>
		<a href="<?php _e('module_url'); ?>index">lista de franquicias</a>
		<a href="<?php _e('module_url'); ?>index/edit">nueva franquicia</a>
	</span>
	<a href="<?php _e('module_url'); ?>">cancelar</a>
	<a href="#" onclick="document.getElementById('siteform').submit();">guardar</a>
</div>
<form action="<?php _e('module_url'); ?>index/save" method="post" enctype="multipart/form-data" id="siteform">
<div class="section-box">
	<div class="header">
		<?php if ($data['site']): ?>
			<h3><span>Editar franquicia:</span> <?php echo $data['site']['name']; ?></h3>
		<?php else: ?>
			<h3>Nueva franquicia</h3>
		<?php endif; ?>
	</div>
	<div class="content">
		
		<div class="column-right">
		  <div class="section-box">
		  	<div class="header">
		  		<h3>Datos del perfil</h3>
		  	</div><!-- .header -->
		  	<div class="content">
		  		<p>
		        <label for="status">Estado</label>
		        <select name="status">
		        	<option value="1"<?php echo ($data['site']['status'] == '1') ? ' selected="selected"' : ''; ?>>Habilitado</option>
		        	<option value="0"<?php echo ($data['site']['status'] == '0') ? ' selected="selected"' : ''; ?>>Deshabilitado</option>
		        </select>
		      </p>
		  	</div><!-- .content -->
		  </div><!-- .section-box -->
		</div><!-- .column-right -->
		<fieldset>
		  <p>
		  	<label for="name">Nombre de la franquicia</label>
		  	<input type="text" id="name" name="name" class="medium" value="<?php echo $data['site']['name']; ?>" />
		  </p>
		  <p>
		  	<label for="subdomain">Subdominio</label>
		  	<input type="text" id="subdomain" name="subdomain" class="medium" value="<?php echo $data['site']['subdomain']; ?>" />
		  </p>
		  <p>
		  	<label for="domain">Dominio</label>
		  	<input type="text" id="domain" name="domain" class="medium" value="<?php echo $data['site']['domain']; ?>" />
		  </p>
		</fieldset>
		<input type="hidden" name="siteid" value="<?php echo $data['site']['site_ID']; ?>" />
	</div>
</div><!-- .section-box -->
<div class="section-box">
	<div class="header">
		<h3>Datos del franquiciado</h3>
	</div>
	<div class="content">
		<fieldset>
		  <p>
				<label for="fusername">Nombre de usuario</label>
			  <input type="text" id="fusername" name="fusername" class="medium" value="<?php echo $data['user']['username']; ?>" />
			</p>
			<p>
			  <label for="femail">Email</label>
			  <input type="text" id="femail" name="femail" class="medium" value="<?php echo $data['user']['email']; ?>" />
			</p>
			<p>
			  <label for="fpass1">Contraseña</label>
			  <input type="password" id="fpass1" name="fpass1" class="medium" value="" />
			  <span class="message">Si no desea modificar su contraseña deje este campo en blanco.</span>
			</p>
			<p>
			  <label for="fpass2">Repite contraseña</label>
			  <input type="password" id="fpass2" name="fpass2" class="medium" value="" />
			  <span class="message">Si no desea modificar su contraseña deje este campo en blanco.</span>
			</p>
		  <p>
		  	<label for="fnif">N.I.F.</label>
		  	<input type="text" id="fnif" name="fnif" class="medium" value="<?php echo $data['user']['nif']; ?>" />
		  </p>
		  <p>
		  	<label for="fname">Nombre</label>
		  	<input type="text" id="fname" name="fname" class="medium" value="<?php echo $data['user']['name']; ?>" />
		  </p>
		  <p>
		  	<label for="fsurname">Apellidos</label>
		  	<input type="text" id="fsurname" name="fsurname" class="medium" value="<?php echo $data['user']['surname']; ?>" />
		  </p>
		  <p>
		  	<label for="faddress">Dirección</label>
		  	<input type="text" id="faddress" name="faddress" class="medium" value="<?php echo $data['user']['address']; ?>" />
		  </p>
		  <p>
		  	<label for="fzipcode">Código postal</label>
		  	<input type="text" id="fzipcode" name="fzipcode" class="medium" value="<?php echo $data['user']['zipcode']; ?>" />
		  </p>
		  <p>
		  	<label for="fcity">Ciudad</label>
		  	<input type="text" id="fcity" name="fcity" class="medium" value="<?php echo $data['user']['city']; ?>" />
		  </p>
		  <p>
		  	<label for="fstate">Provincia</label>
		  	<input type="text" id="fstate" name="fstate" class="medium" value="<?php echo $data['user']['state']; ?>" />
		  </p>
		  <p>
		  	<label for="fcountry">Pais</label>
		  	<input type="text" id="fcountry" name="fcountry" class="medium" value="<?php echo $data['user']['country']; ?>" />
		  </p>
		  <p>
		  	<label for="fphone">Teléfono</label>
		  	<input type="text" id="fphone" name="fphone" class="medium" value="<?php echo $data['user']['phone']; ?>" />
		  </p>
		  <p>
		  	<label for="fweb">Web</label>
		  	<input type="text" id="fweb" name="fweb" class="medium" value="<?php echo $data['user']['web']; ?>" />
		  </p>
		</fieldset>
		<input type="hidden" name="userid" value="<?php echo $data['user']['user_ID']; ?>" />
		
	</div>
</div><!-- .section-box -->
</form>
<div class="buttons">
	<a href="<?php _e('admin_url'); ?>">cancelar</a>
	<a href="#" onclick="document.getElementById('siteform').submit();">guardar</a>
</div>