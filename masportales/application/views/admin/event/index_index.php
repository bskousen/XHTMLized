<div class="buttons">
	<span>
		<form action="" method="post" id="searchfrom">
			<input type="text" name="search" />
			<input type="submit" name="submit" value="buscar" />
		</form>
	</span>
	<a href="<?php echo _reg('site_url'); ?>admin/event/event/edit">nuevo evento</a>
</div>
<div class="section-box">
	<div class="header">
	<?php if ($this->registry->request('search')): ?>
		<h3><span>Resultado para la búsqueda:</span> <?php echo $this->registry->request('search'); ?></h3>
	<?php else: ?>
		<h3>Listado de eventos</h3>
	<?php endif; ?>
	</div>
	<div class="content">
		<?php if ($data['events']): ?>
		<table>
			<thead>
				<tr>
					<th class="column-checks"></th>
					<th class="column-title">titulo</th>
					<th class="column-date">fecha inicio</th>
					<th class="column-date">fecha fin</th>
					<th class="column-date">fecha creación</td>
					<th></th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th class="column-checks"></th>
					<th class="column-title">titulo</th>
					<th class="column-date">fecha inicio</th>
					<th class="column-date">fecha fin</th>
					<th class="column-date">fecha creación</td>
					<th></th>
				</tr>
			</tfoot>
			<tbody>
			<?php foreach($data['events'] as $key => $row): ?>
				<tr class="<?php echo ($key % 2) ? 'odd' : 'even'; ?>">
					<td></td>
					<td class="column-title"><a href="<?php _e('module_url'); ?>event/edit/<?php echo $row['event_ID']; ?>"><?php echo $row['title']; ?></a></td>
					<td class="column-date"><?php echo fecha($row['event_start']); ?></td>
					<td class="column-date"><?php echo fecha($row['event_finish']); ?></td>
					<td class="column-date"><?php echo fecha($row['date_added']); ?></td>
					<td class="column-buttons"><a href="<?php _e('module_url'); ?>event/edit/<?php echo $row['event_ID']; ?>">editar</a> <a href="<?php _e('module_url'); ?>event/delete/<?php echo $row['event_ID']; ?>">borrar</a></td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
		<?php else: ?>
		<div class="message info">No hay eventos<?php echo ($this->registry->request('search')) ? ' para la busqueda \'' . $this->registry->request('search') . '\'' : ''; ?>.</div>
		<?php endif; ?>
		<div class="pagination">
			<?php echo $data['pagination']; ?>
		</div>
	</div>
</div>