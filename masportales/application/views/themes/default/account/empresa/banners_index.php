<div id="uads" class="section user">
  <div class="header"><h4>Banners</h4></div>
  <div class="content ubanners">
  	<div class="buttons-top">
  		<a href="<?php echo _reg('site_url'); ?>micuenta/empresa/banners/edit" class="btn-acc">Nuevo banner</a>
  	</div>
  	<div>
  		<?php if ($data['banners']): ?>
  			<table>
  				<tbody>	
  					<?php foreach ($data['banners'] as $banner): ?>
  				 <tr>
  				  	<td class="column-checks"><input type="checkbox" name="banner_id[]" /></td>
  				  	<td class="column-image">
  				  		<img src="<?php echo ($banner['image_uri']) ? get_image_url($banner['image_uri'], '75x75', _reg('site_url') . 'usrs/banners/') : _reg('site_url') . 'usrs/nophoto_75x75.jpg'; ?>" alt="<?php echo $banner['name']; ?>" />
  				  	</td>
  				  	<td class="column-title">
  				  		<p class="title"><a href="<?php echo _reg('site_url'); ?>micuenta/empresa/banners/edit/<?php echo $banner['banner_ID']; ?>"><?php echo $banner['name']; ?></a></p>
  				  		<p><?php echo $banner['link']; ?>…</p>
  				  	</td>
  				  	<td class="column-button">
  				  		<p><a href="<?php echo _reg('site_url'); ?>micuenta/empresa/banners/edit/<?php echo $banner['banner_ID']; ?>" class="btn">Editar</a></p>
  				  		<p><a href="<?php echo _reg('site_url'); ?>micuenta/empresa/banners/delete/<?php echo $banner['banner_ID']; ?>" class="btn">Borrar</a></p>
  				  	</td>
  				  </tr>
  					<?php endforeach; ?>
  				</tbody>
  			</table>
  		<?php else: ?>
  			<p>No ha creado ningún banner.</p>
  		<?php endif; ?>
  	</div>
  	
  </div><!-- .content -->
</div><!-- #uads .section .user -->
