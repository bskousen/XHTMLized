<div class="buttons">
	<a href="<?php _e('module_url'); ?>settings">cancelar</a>
	<a href="#" onclick="document.getElementById('settingsform').submit();">guardar</a>
</div>
<form action="<?php echo _reg('module_url') . $data['form_action']; ?>" method="post" enctype="multipart/form-data" id="settingsform">

<div class="section-box">
	<div class="header">
  	<h3>Metadata para las Noticias</h3>
  </div><!-- .header -->
  <div class="content">
  	<p>
  		<label for="site[blog_keywords]">Keywords</label>
  		<textarea name="site[blog_keywords]"><?php echo $this->registry->site('blog_keywords'); ?></textarea>
  	</p>
  	<p>
  		<label for="site[blog_description]">Descripción</label>
  		<textarea name="site[blog_description]"><?php echo $this->registry->site('blog_description'); ?></textarea>
  	</p>
  </div><!-- .content -->
</div><!-- .section-box -->
<div class="section-box">
	<div class="header">
  	<h3>Metadata para la Guía Comercial</h3>
  </div><!-- .header -->
  <div class="content">
  	<p>
  		<label for="site[companies_keywords]">Keywords</label>
  		<textarea name="site[companies_keywords]"><?php echo $this->registry->site('companies_keywords'); ?></textarea>
  	</p>
  	<p>
  		<label for="site[companies_description]">Descripción</label>
  		<textarea name="site[companies_description]"><?php echo $this->registry->site('companies_description'); ?></textarea>
  	</p>
  </div><!-- .content -->
</div><!-- .section-box -->
<div class="section-box">
	<div class="header">
  	<h3>Metadata para los Productos</h3>
  </div><!-- .header -->
  <div class="content">
  	<p>
  		<label for="site[ecommerce_keywords]">Keywords</label>
  		<textarea name="site[ecommerce_keywords]"><?php echo $this->registry->site('ecommerce_keywords'); ?></textarea>
  	</p>
  	<p>
  		<label for="site[ecommerce_description]">Descripción</label>
  		<textarea name="site[ecommerce_description]"><?php echo $this->registry->site('ecommerce_description'); ?></textarea>
  	</p>
  </div><!-- .content -->
</div><!-- .section-box -->
<div class="section-box">
	<div class="header">
  	<h3>Metadata para los Clasificados</h3>
  </div><!-- .header -->
  <div class="content">
  	<p>
  		<label for="site[basicads_keywords]">Keywords</label>
  		<textarea name="site[basicads_keywords]"><?php echo $this->registry->site('basicads_keywords'); ?></textarea>
  	</p>
  	<p>
  		<label for="site[basicads_description]">Descripción</label>
  		<textarea name="site[basicads_description]"><?php echo $this->registry->site('basicads_description'); ?></textarea>
  	</p>
  </div><!-- .content -->
</div><!-- .section-box -->
<div class="section-box">
	<div class="header">
  	<h3>Metadata para la Agenda</h3>
  </div><!-- .header -->
  <div class="content">
  	<p>
  		<label for="site[event_keywords]">Keywords</label>
  		<textarea name="site[event_keywords]"><?php echo $this->registry->site('event_keywords'); ?></textarea>
  	</p>
  	<p>
  		<label for="site[event_description]">Descripción</label>
  		<textarea name="site[event_description]"><?php echo $this->registry->site('event_description'); ?></textarea>
  	</p>
  </div><!-- .content -->
</div><!-- .section-box -->

</form>
<div class="buttons">
	<a href="<?php _e('module_url'); ?>settings">cancelar</a>
	<a href="#" onclick="document.getElementById('settingsform').submit();">guardar</a>
</div>