<div id="uads" class="section user">
  <div class="header"><h4>Anuncios clasificados</h4></div>
  <div class="content uads">
  	<div>
  		<h6><?php echo $this->registry->message('content') ?></h6>
  		<p class="comment-content"><?php echo $data['content']; ?></p>
  	</div>
  	<div class="buttons-bottom">
  		<a href="<?php echo _reg('site_url'); ?>micuenta/clasificados/ad/edit/<?php echo $data['basicad_ID']; ?>" class="btn-acc">volver</a>
  	</div>
  </div><!-- .content -->
</div><!-- #uads .section .user -->
