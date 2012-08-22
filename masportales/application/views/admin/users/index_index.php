<br />
<p><a href="<?php echo _reg('site_url'); ?>admin/users/user/edit">nuevo usuario</a></p>
<br />
<h4>Listado de usuarios</h4>
<br />
<table>
	<thead>
		<tr>
			<td></td>
			<td>nombre de usuario</td>
			<td>email</td>
			<td>fecha alta</td>
		</tr>
	</thead>
	<tbody>
	<?php foreach($data as $row): ?>
		<?php
		$datestring = "%d/%m/%Y"; // %h:%i";
		$date_added = mdate($datestring, human_to_unix($row['date_added']));
		//echo $date_modified;
		?>
		<tr>
			<td><a href="<?php _e('module_url'); ?>user/edit/<?php echo $row['user_ID']; ?>">editar</a> <a href="<?php _e('module_url'); ?>users/delete/<?php echo $row['user_ID']; ?>">borrar</a></td>
			<td><?php echo $row['username']; ?></td>
			<td><?php echo $row['email']; ?></td>
			<td><?php echo $date_added; ?></td>
		</tr>
	<?php endforeach; ?>
	</tbody>
	<tfoot>
		<tr>
			<td></td>
			<td>nombre de usuario</td>
			<td>email</td>
			<td>fecha alta</td>
		</tr>
	</tfoot>
</table>