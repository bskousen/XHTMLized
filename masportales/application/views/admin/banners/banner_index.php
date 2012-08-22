<div class="buttons">
	<span>
		<form action="" method="post" id="searchfrom">
			<input type="text" name="search" />
			<input type="submit" name="submit" value="buscar" />
		</form>
	</span>
	<a href="<?php _e('module_url'); ?>banner/edit">nuevo banner</a>
</div>
<div class="section-box">
	<div class="header">
	<?php if ($this->registry->request('search')): ?>
		<h3><span>Resultado para la búsqueda:</span> <?php echo $this->registry->request('search'); ?></h3>
	<?php else: ?>
		<h3>Listado de banners</h3>
	<?php endif; ?>
	</div>
	<div class="content">
		<?php if ($data['banners']): ?>
		<table>
			<thead>
				<tr>
					<th class="column-checks"></th>
					<th class="column-title">título</th>
					<th class="column-text">enlace</th>
					<th class="column-text">posición</th>
					<th class="column-text">estado</th>
					<th class="column-date">creado</th>
					<th class="column-buttons"></th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th class="column-checks"></th>
					<th class="column-title">título</th>
					<th class="column-text">enlace</th>
					<th class="column-text">posición</th>
					<th class="column-text">estado</th>
					<th class="column-date">creado</th>
					<th class="column-buttons"></th>
				</tr>
			</tfoot>
			<tbody>
			<?php foreach($data['banners'] as $key => $row): ?>
				<tr class="<?php echo ($key % 2) ? 'odd' : 'even'; ?>">
					<td></td>
					<td class="column-title"><a href="<?php _e('module_url'); ?>banner/edit/<?php echo $row['banner_ID']; ?>"><?php echo $row['name']; ?></a></td>
					<td class="column-text">
						<?php echo $row['link'] ?>
						<?php /*
						<a href="<?php echo $row['link'] ?>" target="_blank">
							<img src="<?php echo get_image_url($row['image_uri'], $row['width'] . 'x' . $row['height'], _reg('site_url') . 'usrs/banners/'); ?>" />
						</a>
						*/ ?>
					</td>
					<td class="column-text tcenter"><?php echo $row['position_name']; ?></td>
					<td class="column-text tcenter">
						<?php if ($row['status'] == 'activo') {
							$img = '/images/check-alt.png';
							$alt = 'activo';	
						} else {
							$img = '/images/cancel.png';
							$alt = 'desactivo';	
						} ?>
						<img src="<?php echo $img ?>" alt="<?php echo $alt ?>" title="<?php echo $alt ?>">
					</td>
					<td class="column-date"><?php echo fecha($row['date_added']); ?></td>
					<td class="column-buttons"> <a href="<?php _e('module_url'); ?>banner/copiar/<?php echo $row['banner_ID']; ?>">copiar</a><a href="<?php _e('module_url'); ?>banner/edit/<?php echo $row['banner_ID']; ?>">editar</a> <a href="<?php _e('module_url'); ?>banner/delete/<?php echo $row['banner_ID']; ?>">borrar</a></td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
		<?php else: ?>
		<div class="message info">No hay banners<?php echo ($this->registry->request('search')) ? ' para la busqueda \'' . $this->registry->request('search') . '\'' : ''; ?>.</div>
		<?php endif; ?>
		<div class="pagination">
			<?php echo $data['pagination']; ?>
		</div>
	</div>
</div>