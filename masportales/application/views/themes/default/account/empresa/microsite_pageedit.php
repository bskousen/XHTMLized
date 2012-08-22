<div id="ucompany" class="section user">
  <div class="header"><h4>Mi Página</h4></div>
  <div class="content ucompany">
  	<p>Formulario de edición de los apartados de su página dentro de <?php echo $this->registry->site_name(); ?>.</p>
  	
  	<?php echo validation_errors(); ?>
  	<form action="<?php echo _reg('site_url'); ?>micuenta/empresa/microsite/pagesave" method="post" id="userpageeditform">
  		<fieldset>
  			<?php if ($data['microsite_page']): ?>
			    <legend><span>Editar apartado:</span> <?php echo $data['microsite_page']['title']; ?></legend>
			  <?php else: ?>
			    <legend>Nuevo apartado</legend>
			  <?php endif; ?>
  			<label for="name">Título</label><input type="text" name="title" id="title" value="<?php echo set_value('title', (isset($data['microsite_page']['title'])) ? $data['microsite_page']['title'] : ''); ?>" />
  			<label for="slug">URL amigable</label><input type="text" name="slug" id="slug" value="<?php echo set_value('slug', (isset($data['microsite_page']['slug'])) ? $data['microsite_page']['slug'] : ''); ?>" />
  			<label for="content">Contenido</label>
  			<textarea name="content" class="wysiwyg"><?php echo set_value('content', (isset($data['microsite_page']['content'])) ? $data['microsite_page']['content'] : ''); ?></textarea>
  			<label for="meta_keywords">Palabras Claves para buscadores</label>
  			<textarea name="meta_keywords"><?php echo set_value('meta_keywords', (isset($data['microsite_page']['meta_keywords'])) ? $data['microsite_page']['meta_keywords'] : ''); ?></textarea>
  			<label for="meta_description">Descripción corta para buscadores</label>
  			<textarea name="meta_description"><?php echo set_value('meta_description', (isset($data['microsite_page']['meta_description'])) ? $data['microsite_page']['meta_description'] : ''); ?></textarea>
  		</fieldset>
  		<input type="hidden" name="upid" value="<?php echo $data['microsite_page']['microsite_page_ID']; ?>" />
  	</form>
  	<div class="buttons-bottom"><a href="#" onclick="document.getElementById('userpageeditform').submit();" class="btn-acc">Guardar</a></div>
  </div><!-- .content -->
</div><!-- #uads .section .user -->
<script src="<?php echo _reg('js_url'); ?>jquery.slugit.js"></script>
<script src="<?php echo _reg('js_url'); ?>jquery.wysiwyg.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo _reg('js_url'); ?>jquery.wysiwyg/link.js"></script>
<script type="text/javascript" src="<?php echo _reg('js_url'); ?>jquery.wysiwyg/i18n.js"></script>
<script type="text/javascript" src="<?php echo _reg('js_url'); ?>jquery.wysiwyg/lang.es.js"></script>
<link rel="stylesheet" href="<?php echo _reg('css_url'); ?>jquery.wysiwyg.css" type="text/css"/>
<script>
$(document).ready(function () {
	$('#title').slugIt( { output: '#slug' } );
	$('.wysiwyg').wysiwyg(wysiwyg_defaults);
});
</script>