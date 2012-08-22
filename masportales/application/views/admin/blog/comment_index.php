<div class="section-box">
	<div class="header">
		<h3>Comentarios pendientes de aprobación</h3>
	</div>
	<div class="content">
		<?php if ($data['notapproved']) : ?>
			<table>
				<thead>
					<tr>
						<th class="column-title">sobre artículo</th>
						<th class="column-longtext">comentario</th>
						<th class="column-text">usuario</th>
						<th class="column-buttons"></th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th class="column-title">sobre artículo</th>
						<th class="column-longtext">comentario</th>
						<th class="colun-text">usuario</th>
						<th class="column-buttons"></th>
					</tr>
				</tfoot>
				<tbody>
				<?php var_dump($data['notapproved']);echo "aaa"; foreach($data['notapproved'] as $key => $notapproved): 
				echo "pasa";?>
				<tr class="<?php echo ($key % 2) ? 'odd' : 'even'; ?>">
					<td class="column-title"><a href="<?php _e('module_url'); ?>event/edit/<?php echo $notapproved['event_ID']; ?>"><?php echo $notapproved['article_title']; ?></a></td>
					<td class="column-longtext"><?php echo $notapproved['content']; ?></td>
					<td class="column-text tcenter"><?php echo $notapproved['author']; ?></td>
					<td class="column-buttons"><a href="<?php _e('module_url'); ?>comment/approve/<?php echo $notapproved['comment_ID'] . '/' . $notapproved['article_ID']; ?>">aprobar</a> <a href="<?php _e('module_url'); ?>comment/delete/<?php echo $notapproved['comment_ID']; ?>">borrar</a></td>
				</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
		<?php else: ?>
			<div class="message info">No hay comentarios pendiente de aprobación.</div>
		<?php endif; ?>
	</div>
</div>

<div class="section-box">
	<div class="header">
		<h3>Todos los comentarios</h3>
	</div>
	<div class="content">
		<?php if ($data['all_comments']): ?>
			<table>
				<thead>
					<tr>
						<th class="column-title">sobre artículo</th>
						<th class="column-longtext">comentario</th>
						<th class="column-text">usuario</th>
						<th class="column-buttons"></th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th class="column-title">sobre artículo</th>
						<th class="column-longtext">comentario</th>
						<th class="colun-text">usuario</th>
						<th class="column-buttons"></th>
					</tr>
				</tfoot>
				<tbody>
					<?php foreach($data['all_comments'] as $key => $comment): ?>
					<tr class="<?php echo ($key % 2) ? 'odd' : 'even'; ?>">
						<td class="column-title"><a href="<?php _e('module_url'); ?>article/edit/<?php echo $comment['article_ID']; ?>"><?php echo $comment['article_title']; ?></a></td>
						<td class="column-longtext"><?php echo $comment['content']; ?></td>
						<td class="column-text tcenter"><?php echo $comment['author']; ?></td>
						<td class="column-buttons">
							<?php if ($comment['approved']) : ?>
								<a href="<?php _e('module_url'); ?>comment/desapprove/<?php echo $comment['comment_ID'] . '/' . $comment['article_ID']; ?>">desaprobar</a>
							<?php else: ?>
								<a href="<?php _e('module_url'); ?>comment/approve/<?php echo $comment['comment_ID'] . '/' . $comment['article_ID']; ?>">aprobar</a>
							<?php endif; ?>
							<a href="<?php _e('module_url'); ?>comment/delete/<?php echo $comment['comment_ID']; ?>">borrar</a>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		<?php else: ?>
			<div class="message info">No hay comentarios.</div>
		<?php endif; ?>
		<div class="pagination">
			<?php echo $data['pagination']; ?>
		</div>
	</div>
</div>