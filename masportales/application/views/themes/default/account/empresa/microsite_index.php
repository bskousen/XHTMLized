<div id="ucompany" class="section user">
  <div class="header"><h4>Mi Página</h4></div>
  <div class="content ucompany">
  	<h6>Bienvenido a la gestión de su página en +Portales</h6>
  	<p>Desde aquí podrá gestionar el contenido de su página.</p>
  	<div class="buttons-top">
  		<a href="<?php echo _reg('site_url'); ?>micuenta/empresa/microsite/banneredit" class="btn-acc">Editar banner</a>
  	</div>
  	<div id="product-list">
  		<h6>Listado de apartados en mi página</h6>
  		<?php if ($data): ?>
  			<table>
  				<tbody>	
  					<?php foreach ($data['microsites_pages'] as $microsite_page): ?>
  				  <tr>
  				  	<td class="column-title">
  				  		<p class="title"><a href="<?php echo _reg('site_url'); ?>micuenta/empresa/microsite/pageedit/<?php echo $microsite_page['microsite_page_ID']; ?>"><?php echo $microsite_page['title']; ?></a></p>
  				  		<p><?php echo substr( strip_tags($microsite_page['content']), 0, 130); ?>…</p>
  				  	</td>
  				  	<td class="column-button">
  				  		<p><a href="<?php echo _reg('site_url'); ?>micuenta/empresa/microsite/pageedit/<?php echo $microsite_page['microsite_page_ID']; ?>" class="btn">Editar</a></p>
  				  		<p><a href="<?php echo _reg('site_url'); ?>micuenta/empresa/productos/pagedelete/<?php echo $microsite_page['microsite_page_ID']; ?>" class="btn">Borrar</a></p>
  				  	</td>
  				  </tr>
  					<?php endforeach; ?>
  				</tbody>
  			</table>
  		<?php else: ?>
  			<p>No tiene aun ningún apartado en su página.</p>
  		<?php endif; ?>
  	</div>
  	<div class="buttons-bottom">
  		<a href="<?php echo _reg('site_url'); ?>micuenta/empresa/microsite/pageedit" class="btn-acc">Crear apartado</a>
  	</div>
  </div><!-- .content -->
</div><!-- #uecommerce .section .user -->