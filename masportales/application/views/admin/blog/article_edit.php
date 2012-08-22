<div class="buttons">
	<span>
		<a href="<?php echo _reg('admin_url'); ?>blog/article">lista de artículos</a>
		<a href="<?php echo _reg('admin_url'); ?>blog/article/edit">nuevo artículo</a>
	</span>
	<a href="<?php echo _reg('admin_url'); ?>blog/article/">cancelar</a>
	<a href="#" onclick="document.getElementById('articleform').submit();">guardar</a>
</div>
<div class="section-box">
	<div class="header">
		<?php if ($data['article']): ?>
			<h3><span>Editar artículo:</span> <?php echo $data['article']['title']; ?></h3>
		<?php else: ?>
			<h3>Nuevo artículo</h3>
		<?php endif; ?>
	</div>
	<div class="content">
		
		<form action="<?php echo _reg('module_url') . $data['form_action']; ?>" method="post" enctype="multipart/form-data" id="articleform">
			<div class="column-right">
				<div class="section-box">
					<div class="header">
						<h3>Ficheros adjuntos</h3>
					</div><!-- .header -->
					<div class="content">
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
  							<a href="<?php echo _reg('site_url') . 'upload/' . $attachment['filename'] . '.' . $attachment['ext']; ?>" class="delete-img-icon"></a>
  						</li>
  						<?php endforeach; ?>
  					<?php endif; ?>
  					</ul><!-- #imglist -->
  					<input type="hidden" name="umod" value="articles" />
  					<span class="btn-upload">
							<span>Subir imagen...</span>
							<input type="file" multiple="" name="files[]" id="fileupload">
						</span>
						<div class="message info">
							Seleccione una imagen como destacada para que se muestre en el resumen de noticia que aparece en los diferentes listados.
						</div>
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
						<h3>Extras</h3>
					</div><!-- .header -->
					<div class="content">
						<p>
							<label for="status">Estado</label>
							<select name="status">
								<option value="publish"<?php echo ($data['article']['status'] == 'publish') ? ' selected="selected"' : ''; ?>>Publicado</option>
								<option value="draft"<?php echo ($data['article']['status'] == 'draft') ? ' selected="selected"' : ''; ?>>Borrador</option>
							</select>
						</p>
						<p>
							<label for="categories">Categor&iacute;a</label>
							<select name="categories[]" multiple="multiple">
								<?php foreach($data['categories'] as $category): ?>
								<option value="<?php echo $category['category_ID']; ?>"<?php echo (in_array($category['category_ID'], $data['article_categories'])) ? ' selected="selected"' : ''; ?>><?php echo $category['name']; ?></option>
								<?php endforeach; ?>
							</select>
						</p>
						<p>
							<label for="commentstatus">Permitir comentarios</label>
							<input type="radio" name="commentstatus" value="1" <?php echo ($data['article']['comment_status'] == 1) ? ' checked="checked"' : ''; ?>/> Si <br />
							<input type="radio" name="commentstatus" value="0" <?php echo ($data['article']['comment_status'] == 0) ? ' checked="checked"' : ''; ?>/> No
						</p>
					</div><!-- .content -->
				</div><!-- .section-box -->
				<div class="section-box">
					<div class="header">
						<h3>Metadata</h3>
					</div><!-- .header -->
					<div class="content">
						<p>
							<label for="meta_keywords">Keywords</label>
							<textarea name="meta_keywords"><?php echo $data['article']['meta_keywords']; ?></textarea>
						</p>
						<p>
							<label for="meta_description">Descripción</label>
							<textarea name="meta_description"><?php echo $data['article']['meta_description']; ?></textarea>
						</p>
					</div><!-- .content -->
				</div><!-- .section-box -->
			</div><!-- .column-right -->
			
			<fieldset class="article-content">
				<p><label for="title">T&iacute;tulo</label><input type="text" id="title" name="title" class="large big" value="<?php echo $data['article']['title']; ?>" /></p>
				<p><label for="slug">URL amigable</label><input type="text" id="slug" name="slug" class="medium" value="<?php echo $data['article']['slug']; ?>" /></p>
				<p><label for="content">Contenido</label><textarea name="content" class="wysiwyg-maxi"><?php echo $data['article']['content']; ?></textarea></p>
				<p><label for="excerpt">Resumen</label><textarea name="excerpt"class="wysiwyg-mini"><?php echo $data['article']['excerpt']; ?></textarea></p>
			</fieldset>
			<input type="hidden" name="articleid" value="<?php echo $data['article']['article_ID']; ?>" />
		</form>
		
	</div>
</div>
<div class="buttons">
	<a href="<?php echo _reg('admin_url'); ?>blog/article/">cancelar</a>
	<a href="#" onclick="document.getElementById('articleform').submit();">guardar</a>
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
              		$('<a>').attr('href', file.delete_url).attr('class', 'delete-img-icon')
              	)
              );
          });
      }
  });
  
  $(document).on('click', '.delete-img-icon', function (event) {
  	event.preventDefault();
  	var delete_li = $(this).parent();
  	var delete_url = String($(event.target).attr('href'));
  	$.ajax({
	  	url: delete_url+'?umod=articles',
	  	data: {umod: 'articles'},
	  	type: 'DELETE',
	  	success: function(data, textStatus, jqXHR){
	    	delete_li.remove();
	  	}
	  });
  });
});


$(document).ready(function () {
	$('#title').slugIt( { output: '#slug' } );
	wysiwyg_defaults.iFrameClass = 'wysiwyg-big';
	$('.wysiwyg-maxi').wysiwyg(wysiwyg_defaults);
	wysiwyg_defaults.iFrameClass = '';
	$('.wysiwyg-mini').wysiwyg(wysiwyg_defaults);
});
</script>