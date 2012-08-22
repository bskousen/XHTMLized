<div class="buttons">
	<span>
		<form action="" method="post" id="searchfrom">
			<input type="text" name="search" />
			<input type="submit" name="submit" value="buscar" />
		</form>
	</span>
	<a href="<?php _e('module_url'); ?>index/edit">nueva franquicia</a>
</div>
<div class="section-box">
	<div class="header">
	<?php if ($this->registry->request('search')): ?>
		<h3><span>Resultado para la búsqueda:</span> <?php echo $this->registry->request('search'); ?></h3>
	<?php else: ?>
		<h3>Listado de franquicias</h3>
	<?php endif; ?>
	</div>
	<div class="content">
		<?php if ($data['sites']): ?>
		<table>
			<thead>
				<tr>
					<th class="column-checks"></th>
					<th class="column-title">nombre</th>
					<th class="column-text">subdominio</th>
					<th class="column-text">dominio</th>
					<th class="column-text">estado</th>
					<th class="column-date">creado</th>
					<th class="column-buttons"></th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th class="column-checks"></th>
					<th class="column-title">nombre</th>
					<th class="column-text">subdominio</th>
					<th class="column-text">dominio</th>
					<th class="column-text">estado</th>
					<th class="column-date">creado</th>
					<th class="column-buttons"></th>
				</tr>
			</tfoot>
			<tbody>
			<?php foreach($data['sites'] as $key => $row): ?>
				<tr class="<?php echo ($key % 2) ? 'odd' : 'even'; ?>">
					<td></td>
					<td class="column-title"><a href="<?php _e('module_url'); ?>index/edit/<?php echo $row['site_ID']; ?>"><?php echo $row['name']; ?></a></td>
					<td class="column-text tcenter"><?php echo $row['subdomain'] ?></td>
					<td class="column-text tcenter"><?php echo ($row['domain']) ? $row['domain'] : '-'; ?></td>
					<td class="column-text tcenter"><?php echo ($row['status']) ? 'activo' : 'inactivo'; ?></td>
					<td class="column-date"><?php echo fecha($row['date_added']); ?></td>
					<td class="column-buttons"><a href="<?php _e('module_url'); ?>index/edit/<?php echo $row['site_ID']; ?>">editar</a> <a href="<?php _e('module_url'); ?>index/delete/<?php echo $row['site_ID']; ?>">borrar</a></td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
		<?php else: ?>
		<div class="message info">No hay franquicias<?php echo ($this->registry->request('search')) ? ' para la busqueda \'' . $this->registry->request('search') . '\'' : ''; ?>.</div>
		<?php endif; ?>
		<div class="pagination">
			<?php echo $data['pagination']; ?>
		</div>
	</div>
</div>