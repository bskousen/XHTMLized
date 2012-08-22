<div class="buttons">
	<span>
		<a href="<?php _e('module_url'); ?>companies">lista de empresas</a>
		<a href="<?php _e('module_url'); ?>companies/edit">nueva empresa</a>
	</span>
	<a href="<?php _e('module_url'); ?>companies/">cancelar</a>
	<a href="#" onclick="document.getElementById('companyform').submit();">guardar</a>
</div>
<div class="section-box">
	<div class="header">
		<?php if ($data['company']): ?>
			<h3><span>Editar empresa:</span> <?php echo $data['company']['name']; ?></h3>
		<?php else: ?>
			<h3>Nueva empresa</h3>
		<?php endif; ?>
	</div>
	<div class="content">
		<form action="<?php _e('module_url'); ?>companies/save" method="post" enctype="multipart/form-data" id="companyform">
			<div class="column-right">
				<div class="section-box">
					<div class="header">
						<h3>Logo de la empresa</h3>
					</div><!-- .header -->
					<div class="content">
						<div id="image-container">
							<?php if ($data['company']['logo']): ?>
							<img src="<?php echo get_image_url($data['company']['logo'], '210x210', _reg('site_url') . 'usrs/empresas/'); ?>" alt="" />
							<a href="<?php echo _reg('site_url') . 'upload/' . $data['company']['logo']; ?>" class="delete-img-icon"></a>
							<input type="hidden" name="logo" value="<?php echo $data['company']['logo']; ?>">
							<input type="hidden" name="logo_mime_type" value="<?php echo $data['company']['logo_mime_type']; ?>">
							<?php endif; ?>
						</div><!-- #image-container -->
						<input type="hidden" name="umod" value="empresas" />
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
							<textarea name="meta_keywords"><?php echo $data['company']['meta_keywords']; ?></textarea>
						</p>
						<p>
							<label for="meta_description">Descripción</label>
							<textarea name="meta_description"><?php echo $data['company']['meta_description']; ?></textarea>
						</p>
					</div><!-- .content -->
				</div><!-- .section-box -->
			</div><!-- .column-right -->
			<fieldset>
				<p>
					<label for="name">Nombre de la empresa</label>
					<input type="text" id="name" name="name" class="large big" value="<?php echo $data['company']['name']; ?>" />
				</p>
				<p>
					<label for="slug">URL amigable</label>
					<input type="text" id="slug" name="slug" class="medium" value="<?php echo $data['company']['slug']; ?>" />
				</p>
				<p>
					<label for="description">Descripción</label>
					<textarea name="description" class="wysiwyg"><?php echo $data['company']['description']; ?></textarea>
				</p>
				<p>
					<label for="nif">N.I.F.</label>
					<input type="text" id="nif" name="nif" class="medium" value="<?php echo $data['company']['nif']; ?>" />
				</p>
				<p>
					<label for="email">Email</label>
					<input type="text" id="email" name="email" class="medium" value="<?php echo $data['company']['email']; ?>" />
				</p>
				<p>
					<label for="address">Dirección</label>
					<input type="text" id="address" name="address" class="large" value="<?php echo $data['company']['address']; ?>" />
				</p>
				<p>
					<label for="zipcode">Código Postal</label>
					<input type="text" id="zipcode" name="zipcode" class="medium" value="<?php echo $data['company']['zipcode']; ?>" />
				</p>
				<p>
					<label for="city">Ciudad</label>
					<input type="text" id="city" name="city" class="medium" value="<?php echo $data['company']['city']; ?>" />
				</p>
				<p>
					<label for="state">Provincia</label>
					<input type="text" id="state" name="state" class="medium" value="<?php echo $data['company']['state']; ?>" />
				</p>
				<p>
					<label for="country">Pais</label>
					<input type="text" id="country" name="country" class="medium" value="<?php echo $data['company']['country']; ?>" />
				</p>
				<p>
					<label for="phone">Teléfono</label>
					<input type="text" id="phone" name="phone" class="medium" value="<?php echo $data['company']['phone']; ?>" />
				</p>
				<p>
					<label for="web">Web</label>
					<input type="text" id="web" name="web" class="medium" value="<?php echo $data['company']['web']; ?>" />
				</p>
			</fieldset>
			<fieldset>
		        <label for="mapa">Mapa</label>
		          <button type="button" id="buttomMapa">Ver mapa</button>
		          <div id="getMapa"></div> 
		          <?php
		        $gmap_address = urlencode($data['company']['address'] . ', ' . $data['company']['zipcode'] . ', ' . $data['company']['city'] . ', ' . $data['company']['country']);
		        $gmap_icon = _reg('base_url') . 'usrs/gmap.png';
		        ?>
	      </fieldset>
			<input type="hidden" name="cid" value="<?php echo $data['company']['company_ID']; ?>" />
		</form>
		
	</div>
</div>
<div class="buttons">
	<a href="<?php _e('module_url'); ?>companies/">cancelar</a>
	<a href="#" onclick="document.getElementById('companyform').submit();">guardar</a>
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
              	$('<input>').attr('type', 'hidden').attr('name', 'logo').attr('value', file.name)
              ).append(
              	$('<input>').attr('type', 'hidden').attr('name', 'logo_mime_type').attr('value', file.type)
              ).append(
              	$('<a>').attr('href', file.delete_url).attr('class', 'delete-img-icon')
              );
          });
      }
  });
  
  $(document).on('click', '.delete-img-icon', function (event) {
  	event.preventDefault();
  	var delete_li = $(this).parent();
  	var delete_url = String($(event.target).attr('href'));
  	$.ajax({
	  	url: delete_url+'?umod=empresas',
	  	data: {umod: 'empresas'},
	  	type: 'DELETE',
	  	success: function(data, textStatus, jqXHR){
	    	delete_li.remove();
	  	}
	  });
  });

   /*$(document).on('click', '#buttomMapa', function (event) {
    event.preventDefault();
    $("#getMapa").empty();
    $("#getMapa").append('<img src="http://maps.google.com/maps/api/staticmap?zoom=14&size=418x216&maptype=roadmap&markers=color:0xCC3399%7C<?php echo $gmap_address; ?>&sensor=false" alt="" />');
    //$("#buttomMapa").css("display", "none");
  });*/

   $(document).on('click', '#buttomMapa', function (event) {
    event.preventDefault();
    var address = $("input#address").val();
    var zipcode = $("input#zipcode").val();
    var city = $("input#city").val();
    var state = $("input#state").val();
    var gmap_address;
    if(address && zipcode && city && state) { 
      gmap_address = address + ', ' + zipcode + ', ' + city + ', ' + state;
      $("#getMapa").empty();
      $("#getMapa").append('<img src="http://maps.google.com/maps/api/staticmap?zoom=14&size=418x216&maptype=roadmap&markers=color:0xCC3399%7C'+gmap_address+'&sensor=false" alt="" />');
    } else {
      $("#getMapa").empty();
      $("#getMapa").append('Para que aparezca el mapa tiene que tener rellenados los campos de dirección, código postal, ciudad y provincia.');
    }
  });
});

$(document).ready(function () {

	$('#name').slugIt( { output: '#slug' } );
	
	$('.wysiwyg').wysiwyg(wysiwyg_defaults);
});
</script>