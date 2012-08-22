<div id="uads" class="section user">
  <div class="header"><h4>Anuncios clasificados</h4></div>
  <div class="content uads">
  	<div class="buttons-top">
  		<a href="<?php echo _reg('site_url'); ?>micuenta/clasificados/ad/edit" class="btn-acc">Nuevo</a>
  	</div>
  	<div>
  		<?php if ($data): ?>
  			<table>
  				<tbody>	
  					<?php foreach ($data as $basicad): ?>
  				 <tr>
  				  	<td class="column-checks"><input type="checkbox" name="basicad_id[]" /></td>
  				  	<td class="column-image">
  				  		<img src="<?php echo ($basicad['uri']) ? get_image_url($basicad['uri'], '75x75', _reg('site_url') . 'usrs/clasificados/') : _reg('site_url') . 'usrs/nophoto_75x75.jpg'; ?>" alt="<?php echo $basicad['title']; ?>" />
  				  	</td>
  				  	<td class="column-title">
  				  		<p class="title"><a href="<?php echo _reg('site_url'); ?>micuenta/clasificados/ad/edit/<?php echo $basicad['basicad_ID']; ?>"><?php echo $basicad['title']; ?></a></p>
  				  		<p><?php echo substr( strip_tags($basicad['content']), 0, 130); ?>…</p>
  				  		<?php if ($basicad['n_contacts']): ?>
  				  		<p>(<?php echo $basicad['n_contacts']; ?> mensajes)</p>
  				  		<?php endif; ?>
  				  	</td>
  				  	<td class="column-button">
  				  		<p><a href="<?php echo _reg('site_url'); ?>micuenta/clasificados/ad/edit/<?php echo $basicad['basicad_ID']; ?>" class="btn">Editar</a></p>
  				  		<p><a href="<?php echo _reg('site_url'); ?>micuenta/clasificados/ad/delete/<?php echo $basicad['basicad_ID']; ?>" class="btn">Borrar</a></p>
  				  	</td>
  				  </tr>
  					<?php endforeach; ?>
  				</tbody>
  			</table>
  		<?php else: ?>
  			<p>No ha creado ningún anuncio.</p>
  		<?php endif; ?>
  	</div>
  	
  </div><!-- .content -->
</div><!-- #uads .section .user -->
