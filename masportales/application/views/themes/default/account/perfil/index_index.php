<div id="uprofile" class="section user">
  <div class="header"><h4>Perfil de Usuario</h4></div>
  <div class="content uprofile">
  	<p>Le recomendamos que rellene todos los datos para que podamos ofrecerle los mejores servicios disponibles.</p>
  	<div class="buttons-top"><a href="<?php echo _reg('site_url'); ?>micuenta/perfil/user/edit" class="btn-acc">Editar</a></div>
  	<div class="dataset">
  		<h6>Datos del usuario</h6>
  		<p><span>Nombre de usuario</span> <?php echo $this->registry->user('username'); ?></p>
  		<p><span>Email</span> <?php echo $this->registry->user('email'); ?></p>
  	</div>
  	<div class="buttons-top"><a href="<?php echo _reg('site_url'); ?>micuenta/perfil/user/password" class="btn-acc">Cambiar contraseña</a></div>
  	<div class="dataset">
  		<h6>Datos de contacto</h6>
  		<p><span>N.I.F</span><?php echo ($this->registry->user('nif')) ? $this->registry->user('nif') : 'no indicado'; ?></p>
  		<p><span>Nombre</span><?php echo ($this->registry->user('name')) ? $this->registry->user('name') : 'no indicado'; ?></p>
  		<p><span>Apellidos</span><?php echo ($this->registry->user('surname')) ? $this->registry->user('surname') : 'no indicado'; ?></p>
  		<p><span>Dirección</span><?php echo ($this->registry->user('address')) ? $this->registry->user('address') : 'no indicado'; ?></p>
  		<p><span>Código Postal</span><?php echo ($this->registry->user('zipcode')) ? $this->registry->user('zipcode') : 'no indicado'; ?></p>
  		<p><span>Ciudad</span><?php echo ($this->registry->user('city')) ? $this->registry->user('city') : 'no indicado'; ?></p>
  		<p><span>Provincia</span><?php echo ($this->registry->user('state')) ? $this->registry->user('state') : 'no indicado'; ?></p>
  		<p><span>Pais</span><?php echo ($this->registry->user('country')) ? $this->registry->user('country') : 'no indicado'; ?></p>
  		<p><span>Teléfono</span><?php echo ($this->registry->user('phone')) ? $this->registry->user('phone') : 'no indicado'; ?></p>
  		<p><span>Web</span><?php echo ($this->registry->user('web')) ? $this->registry->user('web') : 'no indicado'; ?></p>
  	</div>
  </div><!-- .content -->
</div><!-- #uprofile .section .user -->