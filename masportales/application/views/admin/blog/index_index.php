<div class="buttons">
	<span>
		<form action="" method="post" id="searchfrom">
			<input type="text" name="search" />
			<input type="submit" name="submit" value="buscar" />
		</form>
	</span>
	<a href="<?php echo _reg('site_url'); ?>admin/blog/article/edit">nuevo articulo</a>
</div>
<div class="section-box">
	<div class="header">
	<?php if ($this->registry->request('search')): ?>
		<h3><span>Resultado para la búsqueda:</span> <?php echo $this->registry->request('search'); ?></h3>
	<?php else: ?>
		<h3>Listado de artículos</h3>
	<?php endif; ?>
	</div>
	<div class="content">
		<?php if ($data['articles']): ?>
		<table>
			<thead>
				<tr>
					<th class="column-checks"></th>
					<th class="column-title">título</th>
					<th class="column-text">autor</th>
					<th class="column-number">commentarios</th>
					<th class="column-date">creado</th>
					<th class="column-buttons"></th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th class="column-checks"></th>
					<th class="column-title">título</th>
					<th class="column-text">autor</th>
					<th class="column-number">commentarios</th>
					<th class="column-date">creado</th>
					<th class="column-buttons"></th>
				</tr>
			</tfoot>
			<tbody>
			<?php foreach($data['articles'] as $key => $row): ?>
				<tr class="<?php echo ($key % 2) ? 'odd' : 'even'; ?>">
					<td></td>
					<td class="column-title"><a href="<?php _e('module_url'); ?>article/edit/<?php echo $row['article_ID']; ?>"><?php echo $row['title']; ?></a></td>
					<td class="column-text tcenter"><?php echo $row['author_name'] ?></td>
					<td class="column-number"><?php echo $row['comment_count']; ?></td>
					<td class="column-date"><?php echo fecha($row['date_added']); ?></td>
					<td class="column-buttons"><a href="<?php _e('module_url'); ?>article/edit/<?php echo $row['article_ID']; ?>">editar</a> <a href="<?php _e('module_url'); ?>article/delete/<?php echo $row['article_ID']; ?>">borrar</a></td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
		<?php else: ?>
		<div class="message info">No hay noticias<?php echo ($this->registry->request('search')) ? ' para la busqueda \'' . $this->registry->request('search') . '\'' : ''; ?>.</div>
		<?php endif; ?>
		<div class="pagination">
			<?php echo $data['pagination']; ?>
		</div>
	</div>
</div>