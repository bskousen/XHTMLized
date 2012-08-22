<div id="udashboard" class="section user">
  <div class="header"><h4>ESCRITORIO</h4></div>
  <div class="content udashboard">
  	<h6>Bienvenido a su panel de +Portales</h6>
  	<p>Desde aquí podrá gestionar todos los datos relacionados con su cuenta:</p>
  	<ul>
  		<li>Ver <a href="<?php echo _reg('site_url'); ?>micuenta/perfil">Mi Perfil</a></li>
  		<li>Crear un <a href="<?php echo _reg('site_url'); ?>micuenta/clasificados">Anuncio clasificado</a></li>
  		<?php if ($this->registry->company()): ?>
  		<li>Gestionar tu empresa: <a href="<?php echo _reg('site_url'); ?>micuenta/empresa"><?php echo $this->registry->company('name'); ?></a></li>
  			<?php if ($this->registry->company('ecommerce')): ?>
  			<li>Gestionar tu <a href="<?php echo _reg('site_url'); ?>micuenta/ecommerce">tienda online</a>.</li>
  			<?php else: ?>
  			<li>Crear una <a href="<?php echo _reg('site_url'); ?>micuenta/ecommerce/perfil/new">tienda online</a> para vender productos de mi empresa.</li>
  			<?php endif; ?>
  		<?php else: ?>
  		<li>Crear una empresa en la <a href="<?php echo _reg('site_url'); ?>micuenta/empresa/perfil/new">Guía Comercial.</a></li>
  		<?php endif; ?>
  		
  	</ul>
  	
  </div><!-- .content -->
</div><!-- #udashboard .section .user -->
