<br />
<?php
/*
echo '<pre>';
print_r($data);
echo '</pre>';
*/
?>
<div>
<form action="<?php echo _reg('module_url') . $data['form_action']; ?>" method="post" enctype="multipart/form-data" id="roleform">
	<fieldset>
		<legend>Contenido</legend>
		<p><label for="name">Nombre del perfil</label><input type="text" name="name" class="large" value="<?php echo $data['role']['name']; ?>" /></p>
		<p><label for="value">Valor</label><input type="text" name="value" class="large" value="<?php echo $data['role']['value']; ?>" /></p>
	</fieldset>
	<input type="hidden" name="roleid" value="<?php echo $data['role']['role_ID']; ?>" />
</form>
<br />
<div id="form-buttons">
<a onclick="document.getElementById('roleform').submit();" class="button">guardar</a>
</div>
<br />
</div>