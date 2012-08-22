<div id="ucompany" class="section user">
  <div class="header"><h4>Mi Página</h4></div>
  <div class="content ucompany">
  	<p>Formulario de edición del banner principal de su página dentro de <?php echo $this->registry->site_name(); ?>.</p>
  	
  	<?php echo validation_errors(); ?>
  	<form action="<?php echo _reg('site_url'); ?>micuenta/empresa/microsite/bannersave" method="post" id="userbannereditform">
  		<fieldset>
  			<legend>Editar banner</legend>
  			<label for="name">Nombre</label><input type="text" name="name" id="name" value="<?php echo set_value('name', (isset($data['microsite_banner']['name'])) ? $data['microsite_banner']['name'] : ''); ?>" />
  			<!-- banner upload -->
  			<label>Banner</label>
  			<link rel="stylesheet" href="<?php echo _reg('css_url'); ?>jquery.fileupload-ui.css" />
  			<div id="bannerimage">
  				<?php if ($data['microsite_banner']): ?>
  					<?php
  					$filename = pathinfo($this->registry->company('logo'), PATHINFO_FILENAME);
  					$fileext = strtolower(pathinfo($this->registry->company('logo'), PATHINFO_EXTENSION));
  					$logo_path = _reg('site_url') . 'usrs/empresas/' . $filename . '_96x96.' . $fileext;
  					?>
  					<img width="394" src="<?php echo get_image_url($data['microsite_banner']['uri'], '', _reg('site_url') . 'usrs/empresas/'); ?>" />
  				<?php else: ?>
  					<img src="<?php echo _reg('site_url') ?>usrs/nouser_96x96.jpg" />
  				<?php endif; ?>
  			</div>
  			<span class="btn-acc btn-upload fileinput-button">
					<span>Subir imagen...</span>
					<input type="file" multiple="" name="files[]" id="fileupload">
				</span>
				<div class="message info" style="margin-right:108px;">
  				<ul>
  					<li>Puede subir imagenes jpg, png o gif.</li>
  					<li>Se redimensionará la imagen a 960x360 pixels</li>
  				</ul>
  			</div>
  			<!-- banner upload -->
  		</fieldset>
  		<input type="hidden" name="umod" value="micrositebanner" />
  		<input type="hidden" name="ubid" value="<?php echo $data['microsite_banner']['microsite_banner_ID']; ?>" />
  	</form>
  	<div class="buttons-bottom"><a href="#" onclick="document.getElementById('userbannereditform').submit();" class="btn-acc">Guardar</a></div>
  </div><!-- .content -->
</div><!-- #uads .section .user -->
<script src="<?php echo _reg('js_url'); ?>jquery.ui.widget.js"></script>
<script src="<?php echo _reg('js_url'); ?>jquery.iframe-transport.js"></script>
<script src="<?php echo _reg('js_url'); ?>jquery.fileupload.js"></script>
<script>
$(document).ready(function () {
	$('#fileupload').fileupload({
		dataType: 'json',
		url: '<?php echo _reg('site_url'); ?>upload',
		done: function (e, data) {
			$.each(data.result, function (index, file) {
				$('#bannerimage').empty().append(
        	$('<img>').attr('src', file.url_960x360).css('width', '394')
        ).append(
					$('<input>').attr('type', 'hidden').attr('name', 'uri').attr('value', file.name)
				).append(
					$('<input>').attr('type', 'hidden').attr('name', 'mime_type').attr('value', file.type)
				);
			});
		}
	});
});
</script>