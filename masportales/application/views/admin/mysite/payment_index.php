<div class="section-box">
	<div class="header">
		<h3>Listado de formas de pago</h3>
	</div>
	<div class="content">
		<?php if ($data['payment_gateways']): ?>
		<table>
			<thead>
				<tr>
					<th class="column-checks"></th>
					<th class="column-title">título</th>
					<th class="column-text">estado</th>
					<th class="column-buttons"></th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th class="column-checks"></th>
					<th class="column-title">título</th>
					<th class="column-text">estado</th>
					<th class="column-buttons"></th>
				</tr>
			</tfoot>
			<tbody>
			<?php foreach($data['payment_gateways'] as $key => $row): ?>
				<tr class="<?php echo ($key % 2) ? 'odd' : 'even'; ?>">
					<td></td>
					<td class="column-title"><a href="<?php _e('module_url'); ?>payment/edit/<?php echo $row['payment_gateway_ID']; ?>"><?php echo $row['name']; ?></a></td>
					<td class="column-text tcenter"><?php echo ($row['status']) ? 'habilitado' : 'deshabilitado'; ?></td>
					<td class="column-buttons"><a href="<?php _e('module_url'); ?>payment/edit/<?php echo $row['payment_gateway_ID']; ?>">configurar</a></td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
		<?php else: ?>
		<div class="message info">No hay formas de pago.</div>
		<?php endif; ?>
	</div>
</div>