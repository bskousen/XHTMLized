<div id="ucompany" class="section user">
  <div class="header"><h4>Perfil de Empresa</h4></div>
  <div class="content ucompany">
  	<p>Le recomendamos que rellene todos los datos para que podamos ofrecerle los mejores servicios disponibles.</p>
  	<div class="buttons-top"><a href="#" onclick="document.getElementById('userprofileform').submit();" class="btn-acc">Guardar</a></div>
  	<?php echo validation_errors(); ?>
  	<form action="<?php echo _reg('site_url'); ?>micuenta/empresa/perfil/save" method="post" id="userprofileform">
  		<fieldset>
  			<legend>Datos de la empresa</legend>
  			<label for="username">Denominación *</label><input type="text" name="name" id="name" value="<?php echo set_value('name', $this->registry->company('name')); ?>" />
  			<label for="display_name">N.I.F. *</label><input type="text" name="nif" id="nif" value="<?php echo set_value('nif', $this->registry->company('nif')); ?>" />
  			<label for="email">Email *</label><input type="text" name="email" id="email" value="<?php echo set_value('email', $this->registry->company('email')); ?>" />
  		</fieldset>
  		<fieldset>
  			<legend>logotipo</legend>
  			<link rel="stylesheet" href="<?php echo _reg('css_url'); ?>jquery.fileupload-ui.css" />
  			<div id="companylogo">
  				<?php if ($this->registry->company('logo')): ?>
  					<?php
  					$filename = pathinfo($this->registry->company('logo'), PATHINFO_FILENAME);
  					$fileext = strtolower(pathinfo($this->registry->company('logo'), PATHINFO_EXTENSION));
  					$logo_path = _reg('site_url') . 'usrs/empresas/' . $filename . '_96x96.' . $fileext;
  					?>
  					<img src="<?php echo $logo_path; ?>" />
  				<?php else: ?>
  					<img src="<?php echo _reg('site_url') ?>usrs/nouser_96x96.jpg" />
  				<?php endif; ?>
  			</div>
  			<span class="btn-acc btn-upload fileinput-button">
					<span>Subir logo de la empresa...</span>
					<input type="file" multiple="" name="files[]" id="fileupload">
				</span>
				<div class="message info" style="margin-right:108px;">
  				<ul>
  					<li>Puede subir imagenes jpg, png o gif.</li>
  					<li>Se redimensionará la imagen a 96x96 pixels</li>
  				</ul>
  			</div>
  		</fieldset>
  		<fieldset>
  			<legend>Datos de contacto</legend>
  			<label for="address">Dirección</label><input type="text" name="address" id="address" value="<?php echo set_value('address', $this->registry->company('address')); ?>" />
  			<label for="zipcode">Código Postal</label><input type="text" name="zipcode" id="zipcode" value="<?php echo set_value('zipcode', $this->registry->company('zipcode')); ?>" />
  			<label for="city">Ciudad</label><input type="text" name="city" id="city" value="<?php echo set_value('city', $this->registry->company('city')); ?>" />
  			<label for="state">Provincia</label><input type="text" name="state" id="state" value="<?php echo set_value('state', $this->registry->company('state')); ?>" />
  			<label for="country">Pais</label><input type="text" name="country" id="country" value="<?php echo set_value('country', $this->registry->company('country')); ?>" />
  			<label for="phone">Teléfono</label><input type="text" name="phone" id="phone" value="<?php echo set_value('phone', $this->registry->company('phone')); ?>" />
  			<label for="web">Web</label><input type="text" name="web" id="web" value="<?php echo set_value('web', $this->registry->company('web')); ?>" />
  			<label for="description">Descripción</label><textarea name="description"><?php echo set_value('description', $this->registry->company('description')); ?></textarea>
  		</fieldset>
      <fieldset>
        <legend>Mapa</legend>
          <button type="button" id="buttomMapa">Ver mapa</button>
          <div id="getMapa"></div> 
          <?php
          if (isset($data['company'])) {
        $gmap_address = urlencode($data['company']['address'] . ', ' . $data['company']['zipcode'] . ', ' . $data['company']['city'] . ', ' . $data['company']['country']);
        $gmap_icon = _reg('base_url') . 'usrs/gmap.png';
      }
        ?>
      </fieldset>
       <fieldset>
        <legend>Categorias</legend>
         <div id="company_subcategories_text">
           <?php echo "Ha seleccionado: <br />";
           if ($data["categories_name"]) {
             foreach ($data["categories_name"] as $categories_name) {
                  echo $data["company_categories"][0]["name"] ." - ". $categories_name["name"]."<br />";
                      //  var_dump($company_category);
             } 
            } else {
              $vacio = 'si';
            }?>
         </div>
         <br/> ¿Desea seleccionar más categorias? <br />
        <select id="company_categories" name="company_categories"> 

         <?php foreach ($data['company_categories'] as $category) { ?>
           <option value="<?php echo $category['category_ID'] ?>"><?php echo $category['name']?></option>
         <?php } ?>
       </select>
         <div id="company_subcategories"></div>
         <div id="categoriasgories_result"></div>
        </fieldset>
  		<fieldset>
  			<legend>Imágenes de la empresa</legend>
  			<link rel="stylesheet" href="<?php echo _reg('css_url'); ?>jquery.fileupload-ui.css" />
  			<span class="btn-acc btn-upload fileinput-button">
					<span>Subir imagen...</span>
					<input type="file" multiple="" name="files[]" id="fileupload2">
				</span>
				<div class="message info">
  				<ul>
  					<li>Puede subir hasta 4 imágenes jpg, png o gif.</li>
  					<li>Se redimensionará la imagen a:
  						<ul>
  							<li>96x96 pixels para la miniatura.</li>
  							<li>210x210 pixels para la imagen principal</li>
  						</ul>
  					</li>
  					<li>Debe seleccionar una imagen principal</li>
  				</ul>
  			</div>
  			<ul id="imglist">
  			<?php if ($data['company_images']): ?>
  				<?php foreach ($data['company_images'] as $companies_image): ?>
  				<li>
  					<img width="75" src="<?php echo get_image_url($companies_image['uri'], '96x96', _reg('site_url') . 'usrs/empresas/'); ?>" />
  					<input value="<?php echo $companies_image['name']; ?>" name="images_name[]" type="hidden" />
  					<input value="<?php echo $companies_image['uri']; ?>" name="images_uri[]" type="hidden" />
  					<input value="<?php echo $companies_image['mime_type']; ?>" name="images_type[]" type="hidden" /><br />
  					<?php if ($companies_image['main']): ?>
  					<input value="<?php echo $companies_image['name']; ?>" name="image_main" type="radio" checked="checked" />
  					<?php else: ?>
  					<input value="<?php echo $companies_image['name']; ?>" name="image_main" type="radio" />
  					<?php endif; ?>
  					<a href="<?php echo _reg('site_url') . 'upload/' . $companies_image['uri'] ?>" class="delete-img-icon"></a>
  				</li>
  				<?php endforeach; ?>
  			<?php endif; ?>
  			</ul>
  		</fieldset>
  		<fieldset>
  			<legend>Metadatos</legend>
  			<label for="meta_keywords">Keywords</label><textarea name="meta_keywords"><?php echo set_value('meta_keywords', $this->registry->company('meta_keywords')); ?></textarea>
				<label for="meta_description">Descripción</label><textarea name="meta_description"><?php echo set_value('meta_description', $this->registry->company('meta_description')); ?></textarea>
  		</fieldset>
  		<input type="hidden" name="umod" value="empresas" />
  	</form>
  	<div class="buttons-bottom"><a href="#" onclick="document.getElementById('userprofileform').submit();" class="btn-acc">Guardar</a></div>
  </div><!-- .content -->
</div><!-- #ucompany .section .user -->
<script src="<?php echo _reg('js_url'); ?>jquery.ui.widget.js"></script>
<script src="<?php echo _reg('js_url'); ?>jquery.iframe-transport.js"></script>
<script src="<?php echo _reg('js_url'); ?>jquery.fileupload.js"></script>
<script src="<?php echo _reg('js_url'); ?>jquery.slugit.js"></script>
<script>
$(function () {
  var x=1;
	$('#fileupload').fileupload({
		dataType: 'json',
		url: '<?php echo _reg('site_url'); ?>upload',
		done: function (e, data) {
			$.each(data.result, function (index, file) {
				$('#companylogo').empty().append(
        	$('<img>').attr('src', file.url_96x96)
        ).append(
					$('<input>').attr('type', 'hidden').attr('name', 'logo').attr('value', file.name)
				).append(
					$('<input>').attr('type', 'hidden').attr('name', 'logo_mime_type').attr('value', file.type)
				);
			});
		}
	});
	
	var n_images = Number(<?php echo count($data['company_images']); ?>);
	
	$('#fileupload2').fileupload({
	    dataType: 'json',
	    url: '<?php echo _reg('site_url'); ?>upload',
	    done: function (e, data) {
	    	$.each(data.result, function (index, file) {
	    		if (n_images < 5) {
	    		$('#imglist').append(
	    		  $('<li>').append(
	    		  	$('<img>').attr('src', file.url_96x96).attr('width', 75)
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
<?php if (isset($data['company'])) { ?>
  $(document).on('click', '#buttomMapa', function (event) {
    event.preventDefault();
    $("#getMapa").empty();
    $("#getMapa").append('<img src="http://maps.google.com/maps/api/staticmap?zoom=14&size=418x216&maptype=roadmap&markers=color:0xCC3399%7C<?php echo $gmap_address; ?>&sensor=false" alt="" />');
    //$("#buttomMapa").css("display", "none");
  });
<?php } ?>
	$('#title').slugIt( { output: '#slug' } );

   $(document).on('change', '#company_categories', function (event) {
  //   event.preventDefault();
      var selected = $("#company_categories").val();
//alert(selected);
 

     $.post("/micuenta/empresa/perfil/subcategories", { id: selected},
   function(data) {
     data = JSON.parse(data);
     var res = "<select id='company_subcategories"+x+"' name='company_subcategories'>";
     for (d in data) {
        res += "<option value="+data[d].category_ID+">"+data[d].name+"</option>";
      }
      res += '</select>';
      console.log(res);
     $("#company_subcategories").empty().append(res);
   });
   });
$("#company_subcategories").change(function() {
     var selected_category = $("#company_categories option:selected").text();
     var selected_subcategory = $("#company_subcategories option:selected").text();
     selected_subcategory = selected_subcategory.replace("áéíóú","aeiou");
     $("#categories_result").append("<input type='hidden' name='category"+x+"' value='"+selected_subcategory+"'>");
     $("#categories_result").append("<input type='hidden' name='category_contador' value='"+x+"'>");
     var res = null;
     <?php if (isset($vacio)) ?> res= "Ha seleccionado: <br/>";
     res = selected_category + "-" + selected_subcategory;
     $("#company_subcategories_text").append(res);
     x=x+1;
    });

});
</script>