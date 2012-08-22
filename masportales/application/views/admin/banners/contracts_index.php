<div class="buttons">
	<a href="<?php _e('module_url'); ?>contracts/edit">nueva tarifa banner</a>
</div>
<div class="section-box">
	<div class="header">
	<?php if ($this->registry->request('search')): ?>
		<h3><span>Resultado para la búsqueda:</span> <?php echo $this->registry->request('search'); ?></h3>
	<?php else: ?>
		<h3>Listado de tarifas de banners</h3>
	<?php endif; ?>
	</div>
	<div class="content">
		<?php if ($data['banners_contracts']): ?>
		<table>
			<thead>
				<tr>
					<th class="column-checks"></th>
					<th class="column-title">nombre</th>
					<th class="column-text">tipo</th>
					<th class="column-number tright">precio</th>
					<th class="column-buttons"></th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th class="column-checks"></th>
					<th class="column-title">nombre</th>
					<th class="column-text tcenter">tipo</th>
					<th class="column-number tright">precio</th>
					<th class="column-buttons"></th>
				</tr>
			</tfoot>
			<tbody>
			<?php foreach($data['banners_contracts'] as $key => $row): ?>
				<tr class="<?php echo ($key % 2) ? 'odd' : 'even'; ?>">
					<td></td>
					<td class="column-title"><a href="<?php _e('module_url'); ?>contracts/edit/<?php echo $row['banner_contract_ID']; ?>"><?php echo $row['name']; ?></a></td>
					<td class="column-text tcenter"><?php echo $row['contract_name'] ?></td>
					<td class="column-currency"><?php echo number_format($row['price'], 2, ',', '.'); ?> €</td>
					<td class="column-buttons"><a href="<?php _e('module_url'); ?>contracts/edit/<?php echo $row['banner_contract_ID']; ?>">editar</a> <a href="<?php _e('module_url'); ?>contracts/delete/<?php echo $row['banner_contract_ID']; ?>">borrar</a></td>
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