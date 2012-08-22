<br />
<?php
/*
echo '<pre>';
print_r($data);
echo '</pre>';
*/
?>
<p><a href="<?php _e('module_url'); ?>/role/edit">nuevo perfil</a></p>
<br />
<h4>Listado de perfiles</h4>
<br />
<table>
	<thead>
		<tr>
			<td></td>
			<td>nombre perfil</td>
		</tr>
	</thead>
	<tbody>
	<?php foreach($data as $row): ?>
		<tr>
			<td><a href="<?php _e('module_url'); ?>role/edit/<?php echo $row['role_ID']; ?>">editar</a> <a href="<?php _e('module_url'); ?>role/delete/<?php echo $row['role_ID']; ?>">borrar</a></td>
			<td><?php echo $row['name']; ?></td>
		</tr>
	<?php endforeach; ?>
	</tbody>
	<tfoot>
		<tr>
			<td></td>
			<td>nombre perfil</td>
		</tr>
	</tfoot>
</table>