<div class="buttons">
	<span>
		<a href="<?php echo _reg('admin_url'); ?>event/">lista de eventos</a>
		<a href="<?php echo _reg('admin_url'); ?>event/event/edit">nuevo evento</a>
	</span>
	<a href="<?php echo _reg('admin_url'); ?>event/">cancelar</a>
	<a href="#" onclick="document.getElementById('eventform').submit();">guardar</a>
</div>
<div class="section-box">
	<div class="header">
		<?php if ($data['event']): ?>
			<h3><span>Editar evento:</span> <?php echo $data['event']['title']; ?></h3>
		<?php else: ?>
			<h3>Nuevo evento</h3>
		<?php endif; ?>
	</div>
	<div class="content">
		<form action="<?php echo _reg('module_url') . $data['form_action']; ?>" method="post" enctype="multipart/form-data" id="eventform">
			<div class="column-right">
				<div class="section-box">
					<div class="header">
						<h3>Horario</h3>
					</div><!-- .header -->
					<div class="content">
						<p>
							<label for="categories">Fecha comienzo</label>
							<input type="text" name="date_nice" class="date large" value="<?php echo fecha($data['event']['event_start']); ?>" />
							<input type="hidden" name="event_start" value="<?php echo $data['event']['event_start']; ?>" />
						</p>
						<p>
							<label for="categories">Fecha fin</label>
							<input type="text" name="date_nice" class="date large" value="<?php echo fecha($data['event']['event_finish']); ?>" />
							<input type="hidden" name="event_finish" value="<?php echo $data['event']['event_finish']; ?>" />
						</p>
					</div><!-- .content -->
				</div><!-- .section-box -->
				<div class="section-box">
					<div class="header">
						<h3>Imagen</h3>
					</div><!-- .header -->
					<div class="content">
						<div id="image-container">
							<?php if ($data['event']['image']): ?>
							<img src="<?php echo get_image_url($data['event']['image'], '210x210', _reg('site_url') . 'usrs/events/'); ?>" alt="" />
							<a href="<?php echo _reg('site_url') . 'upload/' . $data['event']['image']; ?>" class="delete-img-icon"></a>
							<input type="hidden" name="image" value="<?php echo $data['event']['image']; ?>">
							<input type="hidden" name="image_mime_type" value="<?php echo $data['event']['image_mime_type']; ?>">
							<?php endif; ?>
						</div>
						<?php /* ?>
						<ul id="imglist">
  					<?php if ($data['article_attachments']): ?>
  						<?php foreach ($data['article_attachments'] as $attachment): ?>
  						<li>
  							<img src="<?php echo _reg('site_url'); ?>usrs/blog/<?php echo $attachment['filename']; ?>_75x75.<?php echo $attachment['ext']; ?>" />
  							<input value="<?php echo $attachment['filename']; ?>" name="attachments_filename[]" type="hidden" />
  							<input value="<?php echo $attachment['ext']; ?>" name="attachments_ext[]" type="hidden" />
  							<input value="<?php echo $attachment['mime_type']; ?>" name="attachments_type[]" type="hidden" />
  							<input value="<?php echo $attachment['attachment_ID']; ?>" name="attachments_id[]" type="hidden" /><br />
  							<?php if ($data['article']['attachment_uri'] == $attachment['uri']): ?>
  							<input value="<?php echo $attachment['filename']; ?>" name="attachment_main" type="radio" checked="checked" />
  							<?php else: ?>
  							<input value="<?php echo $attachment['filename']; ?>" name="attachment_main" type="radio" />
  							<?php endif; ?>
  							<a href="<?php echo _reg('site_url') . 'upload/' . $attachment['name'] . '.' . $attachment['ext']; ?>" class="delete-img"></a>
  						</li>
  						<?php endforeach; ?>
  					<?php endif; ?>
  					</ul><!-- #imglist -->
  					<?php */ ?>
  					<input type="hidden" name="umod" value="events" />
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
				<div class="section-box">
					<div class="header">
						<h3>Metadata</h3>
					</div><!-- .header -->
					<div class="content">
						<p>
							<label for="meta_keywords">Keywords</label>
							<textarea name="meta_keywords"><?php echo $data['event']['meta_keywords']; ?></textarea>
						</p>
						<p>
							<label for="meta_description">Descripción</label>
							<textarea name="meta_description"><?php echo $data['event']['meta_description']; ?></textarea>
						</p>
						
					</div><!-- .content -->
				</div><!-- .section-box -->
			</div><!-- .column-right -->
			<fieldset>
				<p>
					<label for="name">Título del evento</label>
					<input type="text" id="title" name="title" class="large big" value="<?php echo $data['event']['title']; ?>" />
				</p>
				<p>
					<label for="slug">URL amigable</label>
					<input type="text" id="slug" name="slug" class="medium" value="<?php echo $data['event']['slug']; ?>" />
				</p>
				<p>
					<label for="content">Contenido</label>
					<textarea name="content" class="wysiwyg"><?php echo $data['event']['content']; ?></textarea>
				</p>
				<p>
					<?php if($data['event']['have_comment'] == 1) {
						$checked="checked='checked'";
					} else {
						$checked="";
					}?>
					<input type="checkbox" name="have_comment" value="true" <?php echo $checked ?> /> Comentarios?
				</p>
			</fieldset>
			<input type="hidden" name="eid" value="<?php echo $data['event']['event_ID']; ?>" />
		</form>
		
	</div>
</div>
<div class="buttons">
	<a href="<?php echo _reg('admin_url'); ?>event/">cancelar</a>
	<a href="#" onclick="document.getElementById('eventform').submit();">guardar</a>
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
	$('#fileupload').fileupload({
      dataType: 'json',
      url: '<?php echo _reg('site_url'); ?>upload',
      done: function (e, data) {
          $.each(data.result, function (index, file) {
              $('#image-container').empty().append(
              	$('<img>').attr('src', file.url_210x210)
              ).append(
              	$('<input>').attr('type', 'hidden').attr('name', 'image').attr('value', file.name)
              ).append(
              	$('<input>').attr('type', 'hidden').attr('name', 'image_mime_type').attr('value', file.type)
              ).append(
              	$('<a>').attr('href', file.delete_url).attr('class', 'delete-img-icon')
              );
              /*
              $('#imglist').append(
              	$('<li>').append(
              		$('<img>').attr('src', file.url_75x75)
              	).append(
              		$('<input>').attr('type', 'hidden').attr('name', 'attachments_filename[]').attr('value', file.filename)
              	).append(
              		$('<input>').attr('type', 'hidden').attr('name', 'attachments_ext[]').attr('value', file.ext)
              	).append(
              		$('<input>').attr('type', 'hidden').attr('name', 'attachments_type[]').attr('value', file.type)
              	).append(
              		$('<input>').attr('type', 'hidden').attr('name', 'attachments_id[]').attr('value', 0)
              	).append(
              		$('<br>')
              	).append(
              		$('<input>').attr('type', 'radio').attr('name', 'attachment_main').attr('value', file.filename)
              	).append(
              		$('<a>').attr('href', file.delete_url).attr('class', 'delete-img')
              	)
              );
              */
          });
      }
  });
  
  $(document).on('click', '.delete-img-icon', function (event) {
  	event.preventDefault();
  	var delete_li = $(this).parent();
  	var delete_url = String($(event.target).attr('href'));
  	$.ajax({
	  	url: delete_url+'?umod=events',
	  	data: {umod: 'events'},
	  	type: 'DELETE',
	  	success: function(data, textStatus, jqXHR){
	    	delete_li.remove();
	  	}
	  });
  });
});

$(document).ready(function () {

	$('#title').slugIt( { output: '#slug' } );
	
	/*
	$('.date').datepicker({
		altField: $(this).parent().find('.dbdate'),
		altFormat: 'yy-mm-dd'
	});
	*/
	
	$('.date').datepicker({
		onSelect: function (dateText, inst) {
			$(this).parent().children('input[type="hidden"]').val(formatDateDB(dateText));
		}
	});
	
	$('.wysiwyg').wysiwyg(wysiwyg_defaults);
});
</script>