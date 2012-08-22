<div class="buttons">
	<a href="<?php _e('module_url'); ?>banner">cancelar</a>
	<a href="#" onclick="document.getElementById('bannerform').submit();">guardar</a>
</div>
<div class="section-box">
	<div class="header">
		<h3><span>Configuración de Banners</span></h3>
	</div>
	<div class="content">
		
		<form action="<?php _e('module_url'); ?>settings/save" method="post" enctype="multipart/form-data" id="bannerform">
			
			<fieldset class="banner-content">
				<p><label for="month_price">Cuota mensual</label><input type="text" id="month_price" name="month_price" class="medium" value="<?php echo $data['banners_settings']['month_price']; ?>" /></p>
				<p><label for="clicks_price">Precio por click <span>(1.000 clicks)</span></label><input type="text" id="clicks_price" name="clicks_price" class="medium" value="<?php echo $data['banners_settings']['clicks_price']; ?>" /></p>
				<p><label for="prints_price">Precio por impresión <span>(10.000 impresiones)</span></label><input type="text" id="prints_price" name="prints_price" class="medium" value="<?php echo $data['banners_settings']['prints_price']; ?>" /></p>
			</fieldset>
		</form>
		
	</div>
</div>
<div class="buttons">
	<a href="<?php _e('module_url'); ?>banner">cancelar</a>
	<a href="#" onclick="document.getElementById('bannerform').submit();">guardar</a>
</div>