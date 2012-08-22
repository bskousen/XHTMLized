<div class="buttons">
	<span>
		<a href="<?php _e('module_url'); ?>contracts">lista de tarifas de banners</a>
		<a href="<?php _e('module_url'); ?>contracts/edit">nueva tarifa de banner</a>
	</span>
	<a href="<?php _e('module_url'); ?>contracts">cancelar</a>
	<a href="#" onclick="document.getElementById('bannercontractform').submit();">guardar</a>
</div>
<div class="section-box">
	<div class="header">
		<?php if ($data['banners_contract']): ?>
			<h3><span>Editar banner:</span> <?php echo $data['banners_contract']['name']; ?></h3>
		<?php else: ?>
			<h3>Nuevo banner</h3>
		<?php endif; ?>
	</div>
	<div class="content">
		
		<form action="<?php _e('module_url'); ?>contracts/save" method="post" enctype="multipart/form-data" id="bannercontractform">
			
			<fieldset class="banner-content">
				<p><label for="name">Nombre</label><input type="text" id="name" name="name" class="medium" value="<?php echo $data['banners_contract']['name']; ?>" /></p>
				<p>
					<label for="contract_type">Tipo de tarifa</label>
				  <?php if ($data['banners_contract']): ?>
				  <input type="text" readonly="readonly" name="banner-contract-type" value="<?php echo $data['banners_contract']['contract_name']; ?>" class="medium" />
				  <input type="hidden" name="contract_type" value="<?php echo $data['banners_contract']['banner_contract_type_ID']; ?>" />
				  <?php else: ?>
				  <select id="banner-contract-type" name="contract_type" style="width:232px;">
				  <?php foreach($data['banners_contracts_types'] as $contract_type): ?>
				  	<option value="<?php echo $contract_type['banner_contract_type_ID']; ?>" title="<?php echo $contract_type['name']; ?>">
				  		<?php echo $contract_type['name']; ?>
				  	</option>
				  <?php endforeach; ?>
				  </select>
				  <?php endif; ?>
				</p>
				<p><label for="quantity">Número de clicks/impresiones</label><input type="text" id="quantity" name="quantity" class="medium" value="<?php echo $data['banners_contract']['quantity']; ?>" /></p>
				<p><label for="price">Precio</label><input type="text" id="price" name="price" class="medium" value="<?php echo $data['banners_contract']['price']; ?>" /></p>
				
			</fieldset>
			<input type="hidden" name="bid" value="<?php echo $data['banners_contract']['banner_contract_ID']; ?>" />
		</form>
		
	</div>
</div>
<div class="buttons">
	<a href="<?php _e('module_url'); ?>contracts">cancelar</a>
	<a href="#" onclick="document.getElementById('bannercontractform').submit();">guardar</a>
</div>

<script>
$(document).ready(function () {
	<?php if (!$data['banner']): ?>
	$('#umod').val($('#banner-position').children('[selected="selected"]').attr('title'));
	<?php endif; ?>
	$('#banner-position').change(function() {
		var banner_position_id = $(this).val();
		var banner_type = $(this).children('[value='+banner_position_id+']').attr('title');
		$('#umod').val(banner_type);
	});
});
</script>