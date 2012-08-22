<div class="buttons">
  <span>
    <a href="<?php echo _reg('admin_url'); ?>ecommerce/products">lista de productos</a>
    <a href="<?php echo _reg('admin_url'); ?>ecommerce/products/edit">nuevo producto</a>
  </span>
  <a href="<?php echo _reg('admin_url'); ?>ecommerce/products">cancelar</a>
  <a href="#" onclick="document.getElementById('ecommerceform').submit();" class="btn-acc">Guardar</a>
</div>
<div class="section-box">
  <div class="header">
    <?php if ($data['products']): ?>
      <h3><span>Editar producto:</span> <?php echo $data['products']['name']; ?></h3>
    <?php else: ?>
      <h3>Nuevo producto</h3>
    <?php endif; ?>
  </div>
  <div class="content">
     <?php echo validation_errors(); ?>
     <form action="<?php echo _reg('site_url'); ?>admin/ecommerce/products/save" method="post" id="ecommerceform">
        <div class="column-right">
          <div class="section-box">
              <div class="header">
                <h3>Más información</h3>
              </div><!-- .header -->
              <div class="content">
            <label for="price">Precio *</label><input type="text" name="price" id="price" class="medium"  value="<?php echo $data['products']['price']; ?>" />
            <label for="model">Modelo</label><input type="text" name="model" id="model" class="medium" value="<?php echo $data['products']['model']; ?>" />
            <label for="status">Estado</label>
            <select name="status" id="status">
              <?php if($data["products"]["status"] == 0) :?>
              <option value="0" selected="selected">Deshabilitado</option>
              <option value="1">Habilitado</option>
            <?php else: ?>
              <option value="0">Deshabilitado</option>
              <option value="1" selected="selected">Habilitado</option>
            <?php endif; ?>
            </select>
            <label for="quantity">Cantidad *</label><input type="text" name="quantity" id="quantity" class="medium" value="<?php echo $data['products']['quantity']; ?>" />
            <label for="shipping">Coste envío *</label><input type="text" name="shipping" id="shipping" class="medium" value="<?php echo $data['products']['shipping']; ?>" />
            <label for="manufacturer">Fabricante</label><input type="text" name="manufacturer" id="manufacturer" class="medium" value="<?php echo $data['products']['manufacturer_id']; ?>" />
            </div>
          </div><!-- section-box -->
              <div class="section-box">
          <div class="header">
            <h3>Imágenes del producto</h3>
          </div><!-- .header -->
          <div class="content">
              <ul id="imglist">
              <?php if ($data['product_images']): ?>
                <?php foreach ($data['product_images'] as $image): ?>
                <li>
                 	<img src="<?php echo _reg('site_url'); ?>usrs/productos/<?php echo $image['name']; ?>_75x75.<?php echo $image['ext']; ?>" />
                  <input value="<?php echo $image['name']; ?>" name="images_name[]" type="hidden" />
                  <input value="<?php echo $image['ext']; ?>" name="images_ext[]" type="hidden" />
                  <input value="<?php echo $image['mime_type']; ?>" name="images_type[]" type="hidden" /><br />
                  <?php if ($data['products']['main_image'] == $image['name']): ?>
                  <input value="<?php echo $image['name']; ?>" name="images_main" type="radio" checked="checked" />
                  <?php else: ?>
                  <input value="<?php echo $image['name']; ?>" name="images_main" type="radio" />
                  <?php endif; ?>
                  <a href="<?php echo _reg('site_url') . 'upload/' . $image['name'] . '.' . $image['ext']; ?>" class="delete-img-icon"></a>
                </li>
                <?php endforeach; ?>
              <?php endif; ?>
            </ul><!-- #imglist -->
            <input type="hidden" name="umod" value="products" />
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
                <h3>Metadatos</h3>
              </div><!-- .header -->
              <div class="content">
                <fieldset>
                 <label for="meta_keywords">Keywords</label><textarea name="meta_keywords"><?php echo $data['products']['meta_keywords']; ?></textarea>
                  <label for="meta_description">Descripción</label><textarea name="meta_description"><?php echo $data['products']['meta_description']; ?></textarea>
                </fieldset>
              </div> <!-- content -->
          </div><!-- section box metadata -->
           </div><!-- column-right sup -->
          <fieldset class="article-content">
            <label for="company_id">Nombre de la empresa *</label>
            <select name="company_ID" id="company_ID" style="width:232px;">
            <?php foreach ($data["companies"] as $company): ?>
               <?php if ($company["company_ID"] != $data["products"]["company_ID"]): ?>
                    <option value=<?php echo $company["company_ID"] ?>>
               <?php else : ?>
                     <option value=<?php echo $company["company_ID"] ?> selected="selected">
               <?php endif; ?>
                    <?php echo $company["name"] ?>
                    </option>
            <?php endforeach; ?>
          </select>
                <label for="name">Nombre del producto *</label><input type="text" name="name" id="name" class="large big" value="<?php echo $data['products']['name']; ?>" />
                <label for="slug">URL amigable *</label><input type="text" name="slug" id="slug" class="medium" value="<?php echo $data['products']['slug']; ?>" />
                <label for="description">Descripción *</label><textarea name="description" class="wysiwyg-maxi"><?php echo $data['products']['description']; ?></textarea>
             <input type="hidden" name="umod" value="productos" />
          </fieldset>
          <input type="hidden" name="pid" value="<?php echo $data['products']['product_ID']; ?>" />
    </form>
  </div><!-- .content -->
</div><!-- section-box -->
<div class="buttons">
  <a href="../products" class="btn-acc">Cancelar</a>
  <a href="#" onclick="document.getElementById('ecommerceform').submit();" class="btn-acc">Guardar</a>
</div>
<script src="<?php echo _reg('js_url'); ?>jquery.slugit.js"></script>
<script src="<?php echo _reg('js_url'); ?>jquery.ui.widget.js"></script>
<script src="<?php echo _reg('js_url'); ?>jquery.iframe-transport.js"></script>
<script src="<?php echo _reg('js_url'); ?>jquery.fileupload.js"></script>
<script src="<?php echo _reg('js_url'); ?>jquery.wysiwyg.js"></script>
<script src="<?php echo _reg('js_url'); ?>jquery.wysiwyg/link.js"></script>
<script src="<?php echo _reg('js_url'); ?>jquery.wysiwyg/i18n.js"></script>
<script src="<?php echo _reg('js_url'); ?>jquery.wysiwyg/lang.es.js"></script>
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
                              $('<input>').attr('type', 'hidden').attr('name', 'images_name[]').attr('value', file.filename)
                         ).append(
                              $('<input>').attr('type', 'hidden').attr('name', 'images_ext[]').attr('value', file.ext)
                         ).append(
                              $('<input>').attr('type', 'hidden').attr('name', 'images_type[]').attr('value', file.type)
                         ).append(
                              $('<br>')
                         ).append(
                              $('<input>').attr('type', 'radio').attr('name', 'images_main').attr('value', file.filename)
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
          url: delete_url+'?umod=productos',
          data: {umod: 'productos'},
          type: 'DELETE',
          success: function(data, textStatus, jqXHR){
               delete_li.remove();
          }
       });
     });

     $(document).ready(function () {
      $('#name').slugIt( { output: '#slug' } );
     wysiwyg_defaults.iFrameClass = 'wysiwyg-big';
      $('.wysiwyg-maxi').wysiwyg(wysiwyg_defaults);
      wysiwyg_defaults.iFrameClass = '';
      $('.wysiwyg-mini').wysiwyg(wysiwyg_defaults);
    });
});
</script>