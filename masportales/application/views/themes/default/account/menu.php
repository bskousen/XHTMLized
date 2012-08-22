<div id="umenu" class="section">
	<div class="header"><h3>MENU DE USUARIO</h3></div>
	<ul class="content">
	  <li><a href="<?php echo _reg('site_url'); ?>micuenta" >Escritorio</a></li>
	  <li><a href="<?php echo _reg('site_url'); ?>micuenta/perfil" >Perfil</a></li>
	  <li><a href="<?php echo _reg('site_url'); ?>micuenta/comentarios" >Mis comentarios</a></li>
	  <li><a href="<?php echo _reg('site_url'); ?>micuenta/clasificados" >Anuncios clasificados</a></li>
	</ul>
	<?php if ($this->registry->company()): ?>
	<div class="header"><h3>MI EMPRESA</h3></div>
	<ul class="content">
		<li><a href="<?php echo _reg('site_url'); ?>micuenta/empresa" >Perfil de empresa</a></li>
		<?php if ($this->registry->company('premium')): ?> 
		<li><a href="<?php echo _reg('site_url'); ?>micuenta/empresa/microsite" >Mi Página</a></li>
		<?php endif; ?>
		<li><a href="<?php echo _reg('site_url'); ?>micuenta/empresa/banners" >Banners</a></li>
	</ul>
	<?php endif; ?>
	<?php if ($this->registry->company('ecommerce')): ?>
	<div class="header"><h3>MI TIENDA</h3></div>
	<ul class="content">
		<li><a href="<?php echo _reg('site_url'); ?>micuenta/ecommerce/productos" >Productos</a></li>
		<li><a href="<?php echo _reg('site_url'); ?>micuenta/ecommerce/pedidos" >Pedidos</a></li>
		<li><a href="<?php echo _reg('site_url'); ?>micuenta/ecommerce/config" >Configuración</a></li>
	</ul>
	<?php endif; ?>
</div>