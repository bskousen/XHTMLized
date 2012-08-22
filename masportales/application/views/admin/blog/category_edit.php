<div class="buttons">
	<span>
		<a href="<?php echo _reg('admin_url'); ?>blog/category">lista de categoría</a>
		<a href="<?php echo _reg('admin_url'); ?>blog/category/edit">nueva categoría</a>
	</span>
	<a href="<?php echo _reg('admin_url'); ?>blog/category/">cancelar</a>
	<a href="#" onclick="document.getElementById('categoryform').submit();">guardar</a>
</div>
<div class="section-box">
	<div class="header">
		<?php if ($data['category']): ?>
			<h3><span>Editar categoría:</span> <?php echo $data['category']['name']; ?></h3>
		<?php else: ?>
			<h3>Nueva categoría</h3>
		<?php endif; ?>
	</div>
	<div class="content">
		<form action="<?php echo _reg('module_url') . $data['form_action']; ?>" method="post" enctype="multipart/form-data" id="categoryform">
			<div class="column-right">
				<div class="section-box">
					<div class="header">
						<h3>Extras</h3>
					</div><!-- .header -->
					<div class="content">
						<p>
							<label for="categories">Categoría padre</label>
							<select name="parent">
								<option value="0">Ninguna</option>
								<?php foreach($data['categories'] as $category): ?>
								<option value="<?php echo $category['category_ID']; ?>"<?php echo ($category['category_ID'] == $data['category']['parent']) ? ' selected="selected"' : ''; ?>><?php echo $category['name']; ?></option>
								<?php endforeach; ?>
							</select>
						</p>
					</div><!-- .content -->
				</div><!-- .section-box -->
				<div class="section-box">
					<div class="header">
						<h3>Metadata</h3>
					</div><!-- .header -->
					<div class="content">
						<p>
							<label for="meta_keywords">Keywords</label>
							<textarea name="meta_keywords"><?php echo $data['category']['meta_keywords']; ?></textarea>
						</p>
						<p>
							<label for="meta_description">Descripción</label>
							<textarea name="meta_description"><?php echo $data['category']['meta_description']; ?></textarea>
						</p>
					</div><!-- .content -->
				</div><!-- .section-box -->
			</div><!-- .column-right -->
			<fieldset>
				<p><label for="name">Nombre de la categoría</label><input type="text" id="title" name="name" class="large big" value="<?php echo $data['category']['name']; ?>" /></p>
				<p><label for="slug">URL amigable</label><input type="text" id="slug" name="slug" class="large" value="<?php echo $data['category']['slug']; ?>" /></p>
			</fieldset>
			<input type="hidden" name="categoryid" value="<?php echo $data['category']['category_ID']; ?>" />
		</form>
		
	</div>
</div>
<div class="buttons">
	<a href="<?php echo _reg('admin_url'); ?>blog/category/">cancelar</a>
	<a href="#" onclick="document.getElementById('categoryform').submit();">guardar</a>
</div>
<script src="<?php echo _reg('js_url'); ?>jquery.slugit.js"></script>
<script>
$(document).ready(function () {

	$('#title').slugIt( { output: '#slug' } );
	
	//Close button:
	
	$(".close").click(
	  function () {
	  	$(this).parent().fadeTo(400, 0, function () { // Links with the class "close" will close parent
	  		$(this).slideUp(400);
	  	});
	  	return false;
	  }
	);
});
</script>