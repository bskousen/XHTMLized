<div class="buttons">
	<span>
		<a href="<?php _e('module_url'); ?>banner">lista de banners</a>
		<a href="<?php _e('module_url'); ?>banner/edit">nuevo banner</a>
	</span>
	<a href="<?php _e('module_url'); ?>banner">cancelar</a>
	<a href="#" onclick="document.getElementById('bannerform').submit();">guardar</a>
</div>
<div class="section-box">
	<div class="header">
		<?php if ($data['banner']): ?>
			<h3><span>Editar banner:</span> <?php echo $data['banner']['name']; ?></h3>
		<?php else: ?>
			<h3>Nuevo banner</h3>
		<?php endif; ?>
	</div>
	<div class="content">
		<?php echo validation_errors(); ?>
		<form action="<?php _e('module_url'); ?>banner/save" method="post" enctype="multipart/form-data" id="bannerform">
			<div class="column-right">
				<div class="section-box">
					<div class="header">
						<h3>Posición</h3>
					</div><!-- .header -->
					<div class="content">
						<p>
							<label for="position">Posición del Banner</label>
								<select id="banner-position" name="banner-position" style="width:232px;">
								<option title="default" value="0">elige una posición</option>
							<?php foreach($data['banners_positions'] as $position):
							if($position["banner_position_ID"] == $data['banner']['banner_position_ID']) :?>
								<option value="<?php echo $position['banner_position_ID']; ?>" title="<?php echo $position['type_name']; ?>" alt="<?php echo $position['name']; ?>" selected="selected">
									<?php echo $position['name']; ?> <?php echo ' - ' . $position['width'] . 'x' . $position['height'] . 'px'; ?>
								</option>
							<?php else: ?>
								<option value="<?php echo $position['banner_position_ID']; ?>" title="<?php echo $position['type_name']; ?>" alt="<?php echo $position['name']; ?>">
									<?php echo $position['name']; ?> <?php echo ' - ' . $position['width'] . 'x' . $position['height'] . 'px'; ?>
								</option>
						<?php endif; ?>
							<?php endforeach; ?>
							</select>
						</p>
					</div><!-- .content -->
				</div><!-- .section-box -->
				
				<div class="section-box">
					<div class="header">
						<h3>Información</h3>
					</div><!-- .header -->
					<div class="content">
						<p>
							<label>Empresa</label>
							<p class="view">
								<select id="banner_company" name="banner_company" style="width:225px;">
								<?php
								foreach ($data["companies"] as $company) {
									if ($company["company_ID"] == $data['banner']['company_ID']): ?>
										<option value="<?php echo $company["company_ID"] ?>" title="<?php echo $company["name"] ?>" alt="<?php echo $company["name"] ?>" selected="selected"><?php echo $company["name"] ?>
										</option>
									<?php else: ?>
										<option value="<?php echo $company["company_ID"] ?>" title="<?php echo $company["name"] ?>" alt="<?php echo $company["name"] ?>"><?php echo $company["name"] ?>
										</option>
									<?php endif; ?>
								<?php } ?>
							</select>
								<?php if ($data['banner']['status'] == 'pendiente'): ?>
								<span id="active-banner" class="btn">aprobar</span>
								<?php endif; ?>
							</p>
						<p>
							<label>Estado</label>
							<p class="view">
								<select id="banner_status" name="banner_status" style="width:225px;">
								<?php $statuss = array("activo", "pendiente", "inactivo"); 
								foreach ($statuss as $status) {
									if ($status == $data['banner']['status']): ?>
										<option value="<?php echo $status ?>" title="<?php echo $status ?>" alt="<?php echo $status ?>" selected="selected"><?php echo $status ?>
										</option>
									<?php else: ?>
										<option value="<?php echo $status ?>" title="<?php echo $status ?>" alt="<?php echo $status ?>"><?php echo $status ?>
										</option>
									<?php endif; ?>
								<?php } ?>
							</select>
								<?php if ($data['banner']['status'] == 'pendiente'): ?>
								<span id="active-banner" class="btn">aprobar</span>
								<?php endif; ?>
							</p>
							<p>
							<label>Tarifa</label>
							<p class="view"><select id="banner_contract" name="banner_contract" style="width:225px;">
								<?php foreach ($data["banners_contracts"] as $contract) {
									if ($contract['banner_contract_ID'] == $data['banner']['banner_contract_ID']): ?>
										<option value="<?php echo $contract["banner_contract_ID"] ?>" title="<?php echo $contract["name"]." - ".$contract["price"] ?> €"  alt="<?php echo $contract["name"]." - ".$contract["price"] ?> €" selected="selected"><?php echo $contract["name"]." - ".$contract["price"] ?> €
										</option>
									<?php else: ?>
										<option value="<?php echo $contract["banner_contract_ID"] ?>" title="<?php echo $contract["name"]." - ".$contract["price"] ?> €" alt="<?php echo $contract["name"]." - ".$contract["price"] ?> €"><?php echo $contract["name"]." - ".$contract["price"] ?> €
										</option>
									<?php endif; ?>
								<?php } ?>
							</select>
						</p>
						<?php if ($data['banner']): ?>
						<p>
							<label>Impresiones</label>
							<p class="view"><?php echo ($data['banner']['prints']) ? $data['banner']['prints'] : '0'; ?></p>
						</p>
						<p>
							<label>Clicks</label>
							<p class="view"><?php echo ($data['banner']['clicks']) ? $data['banner']['clicks'] : '0'; ?></p>
						</p>
						<p>
							<label>Creado el</label>
							<p class="view"><?php echo fecha($data['banner']['date_added'], 'medium'); ?></p>
						</p>
						<?php endif; ?>
						
					</div><!-- .content -->
				</div><!-- .section-box -->
				
			</div><!-- .column-right -->
			
			<fieldset class="banner-content">
				<p><label for="name">Nombre</label><input type="text" id="name" name="name" class="large big" value="<?php echo set_value('name', (isset( $data['banner']['name'])) ?  $data['banner']['name'] : ''); ?>" /></p>
				<p><label for="link">Enlace del banner</label><input type="text" id="link" name="link" class="medium" value="<?php echo set_value('link', (isset( $data['banner']['link'])) ?  $data['banner']['link'] : ''); ?>" /></p>
				<p><label for="banner_image">Banner</label></p>
				<div id="image-container">
					<?php if ($data['banner']['image_uri']): ?>
				  <img src="<?php echo get_image_url($data['banner']['image_uri'], $data['banner']['width'] . 'x' . $data['banner']['height'], _reg('site_url') . 'usrs/banners/'); ?>" alt="" />
				  <input type="hidden" name="image_uri" value="<?php echo set_value('image_uri', (isset( $data['banner']['image_uri'])) ?  $data['banner']['image_uri'] : ''); ?>">
				  <input type="hidden" name="image_mime_type" value="<?php echo set_value('image_mime_type', (isset( $data['banner']['image_mime_type'])) ?  $data['banner']['image_mime_type'] : ''); ?>">
				  <?php endif; ?>
				</div><!-- #image-container -->
				<input type="hidden" id="umod" name="umod" value="<?php echo ($data['banner']) ? $data['banner']['type_name'] : ''; ?>" />
  			<span class="btn-upload">
				  <span>
				  	<?php echo ($data['banner']) ? 'Nueva imagen' : 'Subir imagen'; ?>...</span>
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
		
	</div>
</div>
<div class="buttons">
	<a href="<?php _e('module_url'); ?>banner">cancelar</a>
	<a href="#" onclick="document.getElementById('bannerform').submit();">guardar</a>
</div>
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
		/*$(this).parent().append(
			$('<input>').attr('type', 'text').attr('value', banner_position).attr('class', 'medium').attr('readonly', 'readonly').attr('name', 'banner_position')
		)
		.append(
			$('<input>').attr('type', 'hidden').attr('value', banner_position_id).attr('name', 'position')
		);*/
		position_selected = true;
		//$(this).remove();
	});
	
	$('#fileupload').fileupload({
		dataType: 'json',
		url: '<?php echo _reg('site_url'); ?>upload',
		done: function (e, data) {
			console.log('Selected: '+position_selected);
			if ($('#banner-position').val()) {
				position_selected = true;
			}
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