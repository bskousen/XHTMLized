<div id="uads" class="section user">
  <div class="header"><h4>Banners</h4></div>
  <div class="content uads">
  	<p>Rellene los siguientes datos para dar de alta su anuncio.</p>
  	
  	<?php echo validation_errors(); ?>
  	<form action="<?php echo _reg('site_url'); ?>micuenta/empresa/banners/save" method="post" id="userbannerform">
  		<?php if ($data['banner']): ?>
  		<fieldset>
  			<legend>Información del banner</legend>
  			<label>Estado</label>
				<p class="view">
				  <span id="status"><?php echo $data['banner']['status']; ?></span>
				</p>
				<label>Impresiones</label>
				<p class="view"><?php echo ($data['banner']['prints']) ? $data['banner']['prints'] : '0'; ?></p>
				<label>Clicks</label>
				<p class="view"><?php echo ($data['banner']['clicks']) ? $data['banner']['clicks'] : '0'; ?></p>
				<label>Creado el</label>
				<p class="view"><?php echo fecha($data['banner']['date_added'], 'medium'); ?></p>
  		</fieldset>
  		<?php endif; ?>
  		<fieldset>
  			<legend>Datos del Banner</legend>
  			<label for="name">Nombre</label>
  			<input type="text" name="name" id="name" value="<?php echo set_value('name', (isset($data['banner']['name'])) ? $data['banner']['name'] : ''); ?>" />
  			<label for="link">Enlace</label>
  			<input type="text" name="link" id="link" value="<?php echo set_value('link', (isset($data['banner']['link'])) ? $data['banner']['link'] : ''); ?>" />
  			<p>
  				<!-- banner position -->
  				<label for="position">Posición del Banner</label>
					<?php if ($data['banner']): ?>
					<input type="text" readonly="readonly" name="banner-position" value="<?php echo $data['banner']['position_name']; ?>" class="medium" />
					<input type="hidden" name="position" value="<?php echo $data['banner']['banner_position_ID']; ?>" />
					<?php else: ?>
					<select id="banner-position" name="position" style="width:232px;">
						<option title="default" value="0">elige una posición</option>
					<?php foreach($data['banners_positions'] as $position): ?>
					  <option value="<?php echo $position['banner_position_ID']; ?>" title="<?php echo $position['type_name']; ?>" alt="<?php echo $position['name']; ?>">
					  	<?php echo $position['name'] . ' - ' . $position['width'] . 'x' . $position['height'] . 'px'; ?>
					  </option>
					<?php endforeach; ?>
					</select>
					<?php endif; ?>
				</p>
				<!-- banner contract -->
  			<label for="position">Tarifa</label>
				<?php if ($data['banner']): ?>
				<input type="text" readonly="readonly" name="banner-position" value="<?php echo $data['banner']['contract_name']; ?>" class="medium" />
				<input type="hidden" name="position" value="<?php echo $data['banner']['banner_contract_ID']; ?>" />
				<?php else: ?>
				<select id="banner-contract" name="contract">
				<?php foreach($data['banners_contracts'] as $contract): ?>
				  <option value="<?php echo $contract['banner_contract_ID']; ?>" title="<?php echo $contract['name']; ?>">
				  	<?php echo $contract['name'] . ' - ' . $contract['price'] . ' €'; ?>
				  </option>
				<?php endforeach; ?>
				</select>
				<?php endif; ?>
  			
  			<label for="banner_image">Banner</label>
				<div id="image-container">
					<?php if ($data['banner']['image_uri']): ?>
				  <img src="<?php echo get_image_url($data['banner']['image_uri'], $data['banner']['width'] . 'x' . $data['banner']['height'], _reg('site_url') . 'usrs/banners/'); ?>" alt="" style="max-width:394px;" />
				  <input type="hidden" name="image_uri" value="<?php echo $data['banner']['image_uri']; ?>">
				  <input type="hidden" name="image_mime_type" value="<?php echo $data['banner']['image_mime_type']; ?>">
				  <?php endif; ?>
				</div><!-- #image-container -->
				<input type="hidden" id="umod" name="umod" value="<?php echo ($data['banner']) ? $data['banner']['type_name'] : ''; ?>" />
  			<link rel="stylesheet" href="<?php echo _reg('css_url'); ?>jquery.fileupload-ui.css" />
  			<span class="btn-acc btn-upload fileinput-button">
				  <span><?php echo ($data['banner']) ? 'Nueva imagen' : 'Subir imagen'; ?>...</span>
				  <input type="file" multiple="" name="files[]" id="fileupload">
				</span>
				<div class="message info">
  			  <ul>
  			  	<li>Puede subir imagenes jpg, png o gif.</li>
  			  	<li>El tamaño de la imagen debe corresponder al tamaño del tipo de banner elegido. De no ser así se redimensionará al tamaño adecuado.</li>
  			  </ul>
  			</div><!-- .message .info -->
  			
  			
  			
  			
  			
  		</fieldset>
  		<input type="hidden" name="bid" value="<?php echo $data['banner']['banner_ID']; ?>" />
  	</form>
  	<div class="buttons-bottom"><a href="#" onclick="document.getElementById('userbannerform').submit();" class="btn-acc">Enviar</a></div>
  </div><!-- .content -->
</div><!-- #uads .section .user -->
<script src="<?php echo _reg('js_url'); ?>jquery.ui.widget.js"></script>
<script src="<?php echo _reg('js_url'); ?>jquery.iframe-transport.js"></script>
<script src="<?php echo _reg('js_url'); ?>jquery.fileupload.js"></script>
<script>
$(document).ready(function () {
	var position_selected = false;
	<?php if (!$data['banner']): ?>
	$('#umod').val($('#banner-position').children('[selected="selected"]').attr('title'));
	<?php endif; ?>
	$('#banner-position').change(function() {
		var banner_position_id = $(this).val();
		var banner_type = $(this).children('[value='+banner_position_id+']').attr('title');
		var banner_position = $(this).children('[value='+banner_position_id+']').attr('alt');
		$('#umod').val(banner_type);
		console.log(banner_position_id);
		$(this).parent().append(
			$('<input>').attr('type', 'text').attr('value', banner_position).attr('class', 'medium').attr('readonly', 'readonly').attr('name', 'banner_position')
		).append(
			$('<input>').attr('type', 'hidden').attr('value', banner_position_id).attr('name', 'position')
		);
		position_selected = true;
		$(this).remove();
	});
	
	$('#fileupload').fileupload({
		dataType: 'json',
		url: '<?php echo _reg('site_url'); ?>upload',
		done: function (e, data) {
			console.log('Selected: '+position_selected);
			if (position_selected) {
				var url_banner_type = 'url_'+$('#umod').val();
				
				$.each(data.result, function (index, file) {
					$('#image-container').empty().append(
					  $('<img>').attr('src', file[url_banner_type])
					).append(
					  $('<input>').attr('type', 'hidden').attr('name', 'image_uri').attr('value', file.name)
					).append(
					  $('<input>').attr('type', 'hidden').attr('name', 'image_mime_type').attr('value', file.type)
					);
				});
			} else {
				alert('Debe seleccionar la posición del banner.');
			}
		}
  });
});
</script>