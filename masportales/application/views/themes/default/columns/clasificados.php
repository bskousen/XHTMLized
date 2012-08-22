<div class="section basicads">
	<div class="header"><h4>CLASIFICADOS</h4></div>
  <div class="content">
  	<div class="basicadslist">
  		<?php if ($basicads = $this->registry->column_item('clasificados')): ?>
  		<ul>
  			<?php foreach($basicads as $basicad): ?>
  		  <?php
  			// get the proper image filename and url
  			if ($basicad['uri']) {
  			  $image = get_image_url($basicad['uri'], '75x75', _reg('site_url') . 'usrs/clasificados/');
  			} else {
  			  $image = _reg('site_url') . 'usrs/nophoto_75x75.jpg';
  			}
  			?>
  			<li>
  				<img src="<?php echo $image; ?>" alt="<?php echo $basicad['title']; ?>" class="photo fleft" />
  				<div class="bacontent">
  					<h3><a href="<?php echo _reg('site_url'); ?>clasificados/<?php echo $basicad['slug']; ?>"><?php echo $basicad['title']; ?></a></h3>
  					<div class="excerpt"><?php echo substr( strip_tags( $basicad['content'] ), 0, 80 ); ?>…</div>
  				</div>
  			</li>
  			<?php endforeach; ?>
  		</ul>
  		<?php else: ?>
  		<p class="message info">No hay ningún anuncio clasificado ahora mismo.</p>
  		<?php endif; ?>
        <div class="search-btn">
  	<form method="post" action="<?php echo _reg('site_url'); ?>clasificados/search" name="clasificadossearchcolumnform">
	  <p><label class="input"> <span>Buscar en clasificados</span>
      <input name="searchquery" type="text" class="input-text" id="searchquery"/></label>
	  <a href="javascript:document.clasificadossearchcolumnform.submit();" id="search-btn"><img src="<?php echo _reg('site_url') . _reg('theme_path'); ?>images/btn_search.png" alt="buscar" /></a></p>
	</form></div>
    </div><!-- #basicadslist -->
  </div><!-- .content -->
  <div class="search clasificadossearch">
	
	</div><!-- .clasificadossearch -->
</div><!-- .section .basicads -->
