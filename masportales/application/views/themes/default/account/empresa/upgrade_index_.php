<div id="ucompany" class="section user">
  <div class="header"><h4>Perfil de Empresa</h4></div>
  <div class="content ucompany">
  	<p>Desde aquí puede contratar los distintos servicios que ofrecemos para su empresa.</p>
  	<div class="buttons-top"><a href="#" onclick="document.getElementById('companyupgradeform').submit();" class="btn-acc">Enviar</a></div>
  	<?php echo validation_errors(); ?>
  	<form action="<?php echo _reg('site_url'); ?>micuenta/empresa/upgrade/confirmation" method="post" id="companyupgradeform">
  		<?php if (!$this->registry->company('premium')): ?>
  		<p><input type="checkbox" name="premium" /> Contratar empresa oro.</p>
  		<?php endif; ?>
  		<?php if (!$this->registry->company('catalog')): ?>
  		<p><input type="checkbox" name="catalog" /> Contratar catalogo.</p>
  		<?php endif; ?>
  		<?php if (!$this->registry->company('ecommerce')): ?>
  		<p><input type="checkbox" name="ecommerce" /> Contratar tienda online.</p>
  		<?php endif; ?>
  		<table>
  			<tr>
	  			<td></td>
	  			<td> </td>
  			</tr>
  			<tr>
	  			<td></td>
	  			<td></td>
  			</tr>
  			<tr>
	  			<td></td>
	  			<td></td>
  			</tr>
  		</table>
  	</form>
  	<div class="buttons-bottom"><a href="#" onclick="document.getElementById('companyupgradeform').submit();" class="btn-acc">Enviar</a></div>
  </div><!-- .content -->
</div><!-- #ucompany .section .user -->