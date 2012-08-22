<div id="uecommerce" class="section user">
  <div class="header"><h4>Mi Tienda</h4></div>
  <div class="content uecommerce">
  	<p>Va a añadir un nuevo producto a su tienda online en <span>Miajadas +Portales</span>.</p>
  	<div class="buttons-top">
  		<a href="../productos" class="btn-acc">Cancelar</a>
  		<a href="#" onclick="document.getElementById('ecommerceform').submit();" class="btn-acc">Guardar</a>
  	</div>
  	<?php echo validation_errors(); ?>
  	<form action="<?php echo _reg('site_url'); ?>micuenta/ecommerce/productos/add" method="post" id="ecommerceform">
  		<fieldset>
  			<legend>Nuevo producto</legend>
  			<label for="name">Nombre del producto *</label><input type="text" name="name" id="name" value="<?php echo set_value('name'); ?>" />
  			<label for="slug">URL amigable *</label><input type="text" name="slug" id="slug" value="<?php echo set_value('slug'); ?>" />
  			<label for="description">Descripción *</label><textarea name="description"><?php echo set_value('description'); ?></textarea>
  			
  			<link rel="stylesheet" href="<?php echo _reg('css_url'); ?>jquery.fileupload-ui.css" />
  			<span class="btn-acc btn-upload fileinput-button">
					<span>Subir imagen del producto...</span>
					<input type="file" multiple="" name="files[]" id="fileupload">
				</span>
  			<div class="message info">
  				<ul>
  					<li>Puede subir imagenes jpg, png o gif.</li>
  					<li>Se redimensionará la imagen a:
  						<ul>
  							<li>75x75 pixels para la miniatura.</li>
  							<li>220x220 pixels para la imagen principal</li>
  						</ul>
  					</li>
  					<li>Debe seleccionar una imagen principal</li>
  				</ul>
  			</div>
				<ul id="imglist"></ul>
  			
  			<label for="price">Precio *</label><input type="text" name="price" id="price" value="<?php echo set_value('price'); ?>" />
  			<label for="model">Modelo</label><input type="text" name="model" id="model" value="<?php echo set_value('model'); ?>" />
  			<label for="status">Estado</label>
  				<select name="status" id="status">
  					<option value="0">Deshabilitado</option>
  					<option value="1">Habilitado</option>
  				</select>
  			<label for="quantity">Cantidad *</label><input type="text" name="quantity" id="quantity" value="<?php echo set_value('quantity'); ?>" />
  			<label for="shipping">Coste envío *</label><input type="text" name="shipping" id="shipping" value="<?php echo set_value('shipping'); ?>" />
  			<label for="manufacturer">Fabricante</label><input type="text" name="manufacturer" id="manufacturer" value="<?php echo set_value('manufacturer'); ?>" />
  			<input type="hidden" name="umod" value="productos" />
  		</fieldset>
  		<fieldset>
  			<legend>Metadatos</legend>
  			<label for="meta_keywords">Keywords</label><textarea name="meta_keywords"><?php echo set_value('meta_keywords'); ?></textarea>
				<label for="meta_description">Descripción</label><textarea name="meta_description"><?php echo set_value('meta_description'); ?></textarea>
  		</fieldset>
  	</form>
  	<div class="buttons-bottom">
  		<a href="../productos" class="btn-acc">Cancelar</a>
  		<a href="#" onclick="document.getElementById('ecommerceform').submit();" class="btn-acc">Guardar</a>
  	</div>
  </div><!-- .content -->
</div><!-- #uecommerce .section .user -->
<script src="<?php echo _reg('js_url'); ?>jquery.ui.widget.js"></script>
<script src="<?php echo _reg('js_url'); ?>jquery.iframe-transport.js"></script>
<script src="<?php echo _reg('js_url'); ?>jquery.fileupload.js"></script>
<script>
$(function () {
	$('#fileupload').fileupload({
		dataType: 'json',
		url: '<?php echo _reg('site_url'); ?>upload',
		done: function (e, data) {
			$.each(data.result, function (index, file) {
				$('#imglist').append(
					$('<li>').append(
						$('<img>').attr('src', file.url_75x75)
					).append(
						$('<input>').attr('type', 'hidden').attr('name', 'images_name[]').attr('value', file.filename)
					).append(
						$('<input>').attr('type', 'hidden').attr('name', 'images_ext[]').attr('value', file.ext)
					).append(
						$('<input>').attr('type', 'hidden').attr('name', 'images_type[]').attr('value', file.type)
					).append(
						$('<br>')
					).append(
						$('<input>').attr('type', 'radio').attr('name', 'images_main').attr('value', file.filename)
					).append(
						$('<a>').attr('href', file.delete_url).attr('class', 'delete-img')
					)
				);
			});
		}
	});
	
	$(document).on('click', '.delete-img', function (event) {
		event.preventDefault();
		var delete_li = $(this).parent();
		var delete_url = String($(event.target).attr('href'));
		$.ajax({
	  	url: delete_url+'?umod=productos',
	  	data: {umod: 'productos'},
	  	type: 'DELETE',
	  	success: function(data, textStatus, jqXHR){
	  		delete_li.remove();
	  	}
	  });
	});
});
</script>