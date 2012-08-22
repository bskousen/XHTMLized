<div id="uads" class="section user">
  <div class="header"><h4>Anuncios clasificados</h4></div>
  <div class="content uads">
  	<p>Rellene los siguientes datos para dar de alta su anuncio.</p>
  	
  	<?php echo validation_errors(); ?>
  	<form action="<?php echo _reg('site_url'); ?>micuenta/clasificados/ad/save" method="post" id="useraddadform">
  		<fieldset>
  			<legend>Nuevo Anuncio</legend>
  			<label for="name">Título</label><input type="text" name="title" id="title" value="<?php echo set_value('title', (isset($data['basicad']['title'])) ? $data['basicad']['title'] : ''); ?>" />
  			<label for="slug">URL amigable</label><input type="text" name="slug" id="slug" value="<?php echo set_value('slug', (isset($data['basicad']['slug'])) ? $data['basicad']['slug'] : ''); ?>" />
  			<label for="content">Contenido</label>
  			<textarea name="content" class="wysiwyg"><?php echo set_value('content', (isset($data['basicad']['content'])) ? $data['basicad']['content'] : ''); ?></textarea>
  			<label for="price">Precio</label><input type="text" name="price" id="price" value="<?php echo set_value('price', (isset($data['basicad']['price'])) ? $data['basicad']['price'] : ''); ?>" />
  			<label for="categories">Categor&iacute;a</label>
				<select name="category">
				  <?php foreach($data['categories'] as $category): ?>
				  <option value="<?php echo $category['category_ID']; ?>"><?php echo $category['name']; ?></option>
				  <?php endforeach; ?>
				</select>
				<link rel="stylesheet" href="<?php echo _reg('css_url'); ?>jquery.fileupload-ui.css" />
  			<br />
  			<span class="btn-acc btn-upload fileinput-button">
					<span>Subir imagen del producto...</span>
					<input type="file" multiple="" name="files[]" id="fileupload">
				</span>
				<div class="message info">
  				<ul>
  					<li>Puede subir hasta 4 imágenes jpg, png o gif.</li>
  					<li>Se redimensionará la imagen a:
  						<ul>
  							<li>75x75 pixels para la miniatura.</li>
  							<li>210x210 pixels para la imagen principal</li>
  						</ul>
  					</li>
  					<li>Debe seleccionar una imagen principal</li>
  				</ul>
  			</div>
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
  			</ul>
  			<label for="meta_keywords">Palabras Claves para buscadores</label>
  			<textarea name="meta_keywords"><?php echo set_value('meta_keywords', (isset($data['basicad']['meta_keywords'])) ? $data['basicad']['meta_keywords'] : ''); ?></textarea>
  			<label for="meta_description">Descripción corta para buscadores</label>
  			<textarea name="meta_description"><?php echo set_value('meta_description', (isset($data['basicad']['meta_description'])) ? $data['basicad']['meta_description'] : ''); ?></textarea>
  			<input type="hidden" name="umod" value="basicads" />
  		</fieldset>
  		<input type="hidden" name="bid" value="<?php echo $data['basicad']['basicad_ID']; ?>" />
  	</form>
  	<div class="buttons-bottom"><a href="#" onclick="document.getElementById('useraddadform').submit();" class="btn-acc">Enviar</a></div>
  </div><!-- .content -->
  <?php if ($data['basicad_contacts']): ?>
  <?php foreach ($data['basicad_contacts'] as $contact): ?>
  <div class="content comments">
  	<div>
  		<h6>Solicitud de información</h6>
  		<p><strong>Nombre:</strong> <?php echo $contact['author']; ?></p>
  		<p><strong>Email:</strong> <?php echo $contact['author_email'] ?></p>
  		<p><strong>Teléfono:</strong> <?php echo $contact['author_phone']; ?></p>
  		<p class="comment-date">Enviada el <?php echo strftime('%d/%m/%G a las %T', strtotime($contact['date_added'])); ?></p>
  		<p><strong>Mensaje</strong></p>
  		<p class="comment-content"><?php echo $contact['content'] ?></p>
  		<?php if ($contact_answers = $this->basicads_model->getBasicAdsContactAnswers($contact['basicad_contact_ID'])): ?>
  		<div>
  			<h6>Mensajes de respuesta</h6>
  			<?php foreach($contact_answers as $answer): ?>
  			<p class="comment-date"><strong>Respuesta</strong> enviada el <?php echo strftime('%d/%m/%G a las %T', strtotime($answer['date_added'])); ?></p>
  			<p class="comment-content"><?php echo $answer['content'] ?></p>
  			<?php endforeach; ?>
  		</div>
  		<?php endif; ?>
  		<form action="<?php echo _reg('site_url'); ?>micuenta/clasificados/ad/sendcontact" method="post" id="sendcontact-<?php echo $contact['basicad_contact_ID']; ?>">
  			<label for="message"><h6>Respuesta</h6></label>
  			<textarea name="message"></textarea>
  			<input type="hidden" name="cid" value="<?php echo $contact['basicad_contact_ID']; ?>" />
  		</form>
  		<div class="buttons-bottom"><a href="#" onclick="document.getElementById('sendcontact-<?php echo $contact['basicad_contact_ID']; ?>').submit();" class="btn-acc">Enviar</a></div>
  	</div>
  </div>
  <?php endforeach; ?>
  <?php endif; ?>
</div><!-- #uads .section .user -->
<script src="<?php echo _reg('js_url'); ?>jquery.ui.widget.js"></script>
<script src="<?php echo _reg('js_url'); ?>jquery.iframe-transport.js"></script>
<script src="<?php echo _reg('js_url'); ?>jquery.fileupload.js"></script>
<script src="<?php echo _reg('js_url'); ?>jquery.slugit.js"></script>
<script src="<?php echo _reg('js_url'); ?>jquery.wysiwyg.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo _reg('js_url'); ?>jquery.wysiwyg/link.js"></script>
<script type="text/javascript" src="<?php echo _reg('js_url'); ?>jquery.wysiwyg/i18n.js"></script>
<script type="text/javascript" src="<?php echo _reg('js_url'); ?>jquery.wysiwyg/lang.es.js"></script>
<link rel="stylesheet" href="<?php echo _reg('css_url'); ?>jquery.wysiwyg.css" type="text/css"/>
<script>
$(document).ready(function () {
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
    
    $('#title').slugIt( { output: '#slug' } );
    $('.wysiwyg').wysiwyg(wysiwyg_defaults);
});
</script>