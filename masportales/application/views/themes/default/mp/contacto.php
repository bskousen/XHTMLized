<div id="news" class="section user">
  <div class="header"><h4>Contacto</h4></div>
  <div class="content">
  	<div class="contact">
  		<h4><?php echo $this->registry->site('name'); ?>+Portales</h4>
  		<h6>Dirección</h6>
  		<p><?php echo $this->registry->site('owner', 'address'); ?></p>
  		<p><?php echo $this->registry->site('owner', 'zipcode'); ?>, <?php echo $this->registry->site('owner', 'city'); ?></p>
  		<p><?php echo $this->registry->site('owner', 'state'); ?></p>
  		<p><?php echo $this->registry->site('owner', 'country'); ?></p>
  		<h6>Teléfono</h6>
  		<p><?php echo $this->registry->site('owner', 'phone'); ?></p>
  		<p></p>
  	</div><!-- .contact -->
  </div><!-- .content -->
</div><!-- #news .section -->
<?php $this->mpbanners->print_banner('column-main', 'fullbanner'); ?>