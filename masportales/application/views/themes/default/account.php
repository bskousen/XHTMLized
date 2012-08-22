<div class="columns">
	<div id="menu-column" class="column2 fleft">
		<?php include_once('account/menu.php'); ?>
  </div><!-- .column2 -->
	<div class="column1 fleft">
  	<?php
		  if ($this->registry->request('module') == 'dashboard'):
		  	include_once('account/dashboard.php');
		  else:
		  	if (file_exists(_reg('base_path') . _reg('theme_path') . 'account/' . $this->registry->request('module') . '/' . _reg('section') . '_' . _reg('action') . '.php')) {
		  		include_once('account/' . $this->registry->request('module') . '/' . _reg('section') . '_' . _reg('action') . '.php');
		  	} else {
		  		include_once('account/404.php');
		  	}
		  	
		  endif;
		?>
  </div><!-- .column1 -->
  <div class="column2 fleft">
		<?php include_once('column2.php'); ?>
  </div><!-- .column2 -->
</div><!-- .columns -->