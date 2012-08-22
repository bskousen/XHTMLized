<div id="ucompany" class="section user">
  <div class="header"><h4>Su Empresa</h4></div>
  <div class="content ucompany">
  	<p>Va a crear una empresa que se mostrará en la Guía Comercial de <span>Miajadas +Portales</span>.</p>
  	<div class="buttons-top"><a href="#" onclick="document.getElementById('userprofileform').submit();" class="btn-acc">Guardar</a></div>
  	<?php echo validation_errors(); ?>
  	<form action="<?php echo _reg('site_url'); ?>micuenta/empresa/perfil/add" method="post" id="userprofileform">
  		<fieldset>
  			<legend>Datos de la empresa</legend>
  			<label for="name">Denominación *</label><input type="text" name="name" id="name" value="<?php echo set_value('name'); ?>" />
  			<label for="nif">N.I.F. *</label><input type="text" name="nif" id="nif" value="<?php echo set_value('nif'); ?>" />
  			<label for="emal">Email *</label><input type="text" name="email" id="email" value="<?php echo set_value('email'); ?>" />
  		</fieldset>
  		<fieldset>
  			<legend>logotipo</legend>
  			<link rel="stylesheet" href="<?php echo _reg('css_url'); ?>jquery.fileupload-ui.css" />
  			<div id="companylogo">
  				<img src="<?php echo _reg('site_url') ?>usrs/nouser_96x96.jpg" />
  			</div>
  			<span class="btn btn-pink fileinput-button">
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
  			<label for="address">Dirección</label><input type="text" name="address" id="address" value="<?php echo set_value('address'); ?>" />
  			<label for="zipcode">Código Postal</label><input type="text" name="zipcode" id="zipcode" value="<?php echo set_value('zipcode'); ?>" />
  			<label for="city">Ciudad</label><input type="text" name="city" id="city" value="<?php echo set_value('city'); ?>" />
  			<label for="state">Provincia</label><input type="text" name="state" id="state" value="<?php echo set_value('state'); ?>" />
  			<label for="country">Pais</label><input type="text" name="country" id="country" value="<?php echo set_value('country'); ?>" />
  			<label for="phone">Teléfono</label><input type="text" name="phone" id="phone" value="<?php echo set_value('phone'); ?>" />
  			<label for="web">Web</label><input type="text" name="web" id="web" value="<?php echo set_value('web'); ?>" />
  			<label for="description">Descripción</label><textarea name="description"><?php echo set_value('description'); ?></textarea>
  		</fieldset>
     <fieldset>
        <legend>Mapa</legend>
          <button type="button" id="buttomMapa">Ver mapa</button>
          <div id="getMapa"></div> 
          <?php
       // $gmap_address = urlencode($data['company']['address'] . ', ' . $data['company']['zipcode'] . ', ' . $data['company']['city'] . ', ' . $data['company']['country']);
        ?>
      </fieldset>
       <fieldset>
        <legend>Categorias</legend>
         <div id="company_subcategories_text"></div>
         <br/> ¿Desea seleccionar categorias?"
        <select id="company_categories" name="company_categories"> 
         <?php foreach ($data['company_categories'] as $category) { ?>
           <option value="<?php echo $category['category_ID'] ?>"><?php echo $category['name']?></option>
         <?php } ?>
       </select>
         <div id="company_subcategories"></div>
         <div id="categories_result"></div>
        </fieldset>
  		<input type="hidden" name="umod" value="empresas" />
  	</form>
  	<div class="buttons-bottom"><a href="#" onclick="document.getElementById('userprofileform').submit();" class="btn-acc">Guardar</a></div>
  </div><!-- .content -->
</div><!-- #ucompany .section .user -->
<script src="<?php echo _reg('js_url'); ?>jquery.ui.widget.js"></script>
<script src="<?php echo _reg('js_url'); ?>jquery.iframe-transport.js"></script>
<script src="<?php echo _reg('js_url'); ?>jquery.fileupload.js"></script>
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
     var res = "";
     if (x == 1) { res += "Ha seleccionado: "; }
     res +=  "<br/>"+selected_category + "-" + selected_subcategory;
     $("#company_subcategories_text").append(res);
     x=x+1;
    });


});
</script>