<div id="ucompany" class="section user">
  <div class="header"><h4>Su Empresa</h4></div>
  <div class="content ucompany">
  	<div class="buttons-top">
  		<?php if ($this->registry->company()): ?>
  			<a href="<?php echo _reg('site_url'); ?>micuenta/empresa/perfil/edit" class="btn-acc">Editar</a>
  		<?php else: ?>
  			<a href="<?php echo _reg('site_url'); ?>micuenta/empresa/perfil/new" class="btn-acc">Crear empresa</a>
  		<?php endif; ?>
  	</div>
  	<?php if ($this->registry->company()): ?>
  		<div class="dataset">
  			<h6>Datos de la empresa</h6>
  			<div id="companylogo">
  				<?php if ($this->registry->company('logo')): ?>
  					<?php
  					$filename = pathinfo($this->registry->company('logo'), PATHINFO_FILENAME);
  					$fileext = strtolower(pathinfo($this->registry->company('logo'), PATHINFO_EXTENSION));
  					$logo_path = _reg('site_url') . 'usrs/empresas/' . $filename . '_96x96.' . $fileext;
  					?>
  					<img src="<?php echo $logo_path; ?>" />
  				<?php else: ?>
  					<img src="<?php echo _reg('site_url') ?>usrs/nouser_96x96.jpg" />
  				<?php endif; ?>
  			</div>
  			<p><span>Denominación</span> <?php echo $this->registry->company('name'); ?></p>
  			<p><span>Email</span> <?php echo $this->registry->company('email'); ?></p>
  			<!-- <p><span>Nombre a mostrar</span> <?php echo $user_data['display_name']; ?></p> -->
  			<p><span>N.I.F</span> <?php echo $this->registry->company('nif'); ?></p>
  			<p><span>Descripción</span><?php echo $this->registry->company('description'); ?></p>
  			<p><span>Dirección</span><?php echo $this->registry->company('address'); ?></p>
  			<p><span>Código Postal</span><?php echo $this->registry->company('zipcode'); ?></p>
  			<p><span>Ciudad</span><?php echo $this->registry->company('city'); ?></p>
  			<p><span>Provincia</span><?php echo $this->registry->company('state'); ?></p>
  			<p><span>Pais</span><?php echo $this->registry->company('country'); ?></p>
  			<p><span>Teléfono</span><?php echo $this->registry->company('phone'); ?></p>
  			<p><span>Web</span><?php echo $this->registry->company('web'); ?></p>
  		</div>
  		<div class="dataset">
	  		<h6>Tipo de empresa</h6>
	  		<?php $company_type = ($this->registry->company('premium')) ? 'oro' : 'basica'; ?>
	  		<p><span>Tipo de la empresa:</span> <?php echo $company_type; ?></p>
	  		<p><span>Catálogo contratado:</span> <?php echo ($this->registry->company('catalog')) ? 'si' : 'no'; ?>
	  		<p><span>Tienda contratada:</span> <?php echo ($this->registry->company('ecommerce')) ? 'si' : 'no'; ?>
	  		<p><a href="<?php echo _reg('site_url'); ?>micuenta/empresa/upgrade">Contratar servicios para mi empresa</a></p>
  		</div>
  	<?php else: ?>
  		<p class="message error">No ha creado ninguna empresa.</p>
  	<?php endif; ?>
  	
  </div><!-- .content -->
</div><!-- #ucompany .section .user -->
