<div class="buttons">
	<span>
		<a href="<?php _e('module_url'); ?>">lista de anuncios</a>
		<a href="<?php _e('module_url'); ?>index/edit">nuevo anuncio</a>
	</span>
	<a href="<?php _e('module_url'); ?>">cancelar</a>
	<a href="#" onclick="document.getElementById('basicadform').submit();">guardar</a>
</div>
<div class="section-box">
	<div class="header">
		<?php if ($data['basicad']): ?>
			<h3><span>Editar anuncio:</span> <?php echo $data['basicad']['title']; ?></h3>
		<?php else: ?>
			<h3>Nuevo anuncio</h3>
		<?php endif; ?>
	</div>
	<div class="content">
		
		<form action="<?php _e('module_url'); ?>index/save" method="post" enctype="multipart/form-data" id="basicadform">
			<div class="column-right">
				<div class="section-box">
					<div class="header">
						<h3>Extras</h3>
					</div><!-- .header -->
					<div class="content">
						<p><label for="price">Precio</label><input type="text" name="price" id="price" value="<?php echo $data['basicad']['price']; ?>" /></p>
						<p>
							<label for="status">Estado</label>
							<select name="status">
								<option value="publicado"<?php echo ($data['basicad']['status'] == 'publicado') ? ' selected="selected"' : ''; ?>>Publicado</option>
								<option value="pendiente"<?php echo ($data['basicad']['status'] == 'pendiente') ? ' selected="selected"' : ''; ?>>Borrador</option>
							</select>
						</p>
						<p>
							<label for="categories">Categor&iacute;a</label>
							<select name="category">
							  <?php foreach($data['categories'] as $category): ?>
							  <option value="<?php echo $category['category_ID']; ?>"><?php echo $category['name']; ?></option>
							  <?php endforeach; ?>
							</select>
						</p>
					</div><!-- .content -->
				</div><!-- .section-box -->
				<div class="section-box">
					<div class="header">
						<h3>Imagenes</h3>
					</div><!-- .header -->
					<div class="content">
						<ul id="imglist">
  					<?php if ($data['basicad_images']): ?>
  						<?php foreach ($data['basicad_images'] as $basicads_image): ?>
  						<li>
  							<img src="<?php echo get_image_url($basicads_image['uri'], '75x75', _reg('site_url') . 'usrs/clasificados/'); ?>" />
  							<input value="<?php echo $basicads_image['name']; ?>" name="images_name[]" type="hidden" />
  							<input value="<?php echo $basicads_image['uri']; ?>" name="images_uri[]" type="hidden" />
  							<input value="<?php echo $basicads_image['mime_type']; ?>" name="images_type[]" type="hidden" /><br />
  							<?php if ($basicads_image['main']): ?>
  							<input value="<?php echo $basicads_image['name']; ?>" name="image_main" type="radio" checked="checked" />
  							<?php else: ?>
  							<input value="<?php echo $basicads_image['name']; ?>" name="image_main" type="radio" />
  							<?php endif; ?>
  							<a href="<?php echo _reg('site_url') . 'upload/' . $basicads_image['uri'] ?>" class="delete-img-icon"></a>
  						</li>
  						<?php endforeach; ?>
  					<?php endif; ?>
  					</ul><!-- #imglist -->
  					<input type="hidden" name="umod" value="basicads" />
  					<span class="btn-upload">
							<span>Subir imagen...</span>
							<input type="file" multiple="" name="files[]" id="fileupload">
						</span>
						<div class="message info">
  						<ul>
  							<li>Puede subir imagenes jpg, png o gif.</li>
  							<li>Se redimensionará la imagen a:
  								<ul>
  									<li>96x96 pixels para la miniatura.</li>
  									<li>210x210 pixels para la imagen principal</li>
  								</ul>
  							</li>
  							<li>Debe seleccionar una imagen principal</li>
  						</ul>
  					</div><!-- .message .info -->
  				</div><!-- .content -->
				</div><!-- .section-box -->
			</div><!-- .column-right -->
			
			<fieldset class="basicad-content">
				<p><label for="title">T&iacute;tulo</label><input type="text" id="title" name="title" class="large big" value="<?php echo $data['basicad']['title']; ?>" /></p>
				<p><label for="slug">URL amigable</label><input type="text" id="slug" name="slug" class="medium" value="<?php echo $data['basicad']['slug']; ?>" /></p>
				<p><label for="content">Contenido</label><textarea name="content" class="wysiwyg"><?php echo $data['basicad']['content']; ?></textarea></p>
			</fieldset>
			<input type="hidden" name="bid" value="<?php echo $data['basicad']['basicad_ID']; ?>" />
		</form>
		
	</div>
</div>
<div class="buttons">
	<a href="<?php _e('module_url'); ?>">cancelar</a>
	<a href="#" onclick="document.getElementById('basicadform').submit();">guardar</a>
</div>
<script src="<?php echo _reg('js_url'); ?>jquery.slugit.js"></script>
<script src="<?php echo _reg('js_url'); ?>jquery.ui.widget.js"></script>
<script src="<?php echo _reg('js_url'); ?>jquery.iframe-transport.js"></script>
<script src="<?php echo _reg('js_url'); ?>jquery.fileupload.js"></script>
<script src="<?php echo _reg('js_url'); ?>jquery.wysiwyg.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo _reg('js_url'); ?>jquery.wysiwyg/link.js"></script>
<script type="text/javascript" src="<?php echo _reg('js_url'); ?>jquery.wysiwyg/i18n.js"></script>
<script type="text/javascript" src="<?php echo _reg('js_url'); ?>jquery.wysiwyg/lang.es.js"></script>
<link rel="stylesheet" href="<?php echo _reg('css_url'); ?>jquery.wysiwyg.css" type="text/css"/>
<script>
$(function () {
	var n_images = Number(<?php echo count($data['basicad_images']); ?>);
  
  $('#fileupload').fileupload({
      dataType: 'json',
      url: '<?php echo _reg('site_url'); ?>upload',
      done: function (e, data) {
      	$.each(data.result, function (index, file) {
      		if (n_images < 5) {
      		$('#imglist').append(
      		  $('<li>').append(
      		  	$('<img>').attr('src', file.url_75x75)
      		  ).append(
      		  	$('<input>').attr('type', 'hidden').attr('name', 'images_uri[]').attr('value', file.name)
      		  ).append(
      		  	$('<input>').attr('type', 'hidden').attr('name', 'images_name[]').attr('value', file.filename)
      		  ).append(
      		  	$('<input>').attr('type', 'hidden').attr('name', 'images_type[]').attr('value', file.type)
      		  ).append(
      		  	$('<br>')
      		  ).append(
      		  	$('<input>').attr('type', 'radio').attr('name', 'image_main').attr('value', file.filename)
      		  ).append(
      		  	$('<a>').attr('href', file.delete_url).attr('class', 'delete-img-icon')
      		  )
      		);
      		n_images++;
      		} else {
      			$.ajax({
	  					url: '<?php echo _reg('site_url'); ?>upload/'+file.name+'?umod=basicads',
	  					data: {umod: 'basicads'},
	  					type: 'DELETE',
	  					success: function(data, textStatus, jqXHR){
	  				  	
	  					}
	  				});
      			alert('Ha alcanzado el límite de 4 imágenes para el anuncio.');
      		}
      	});
      }
  });
  
  $(document).on('click', '.delete-img-icon', function (event) {
  	event.preventDefault();
  	var delete_li = $(this).parent();
  	var delete_url = String($(event.target).attr('href'));
  	$.ajax({
	  	url: delete_url+'?umod=basicads',
	  	data: {umod: 'basicads'},
	  	type: 'DELETE',
	  	success: function(data, textStatus, jqXHR){
	    	delete_li.remove();
	    	n_images--;
	  	}
	  });
  });
});


$(document).ready(function () {
	$('#title').slugIt( { output: '#slug' } );
	$('.wysiwyg').wysiwyg(wysiwyg_defaults);
});
</script>