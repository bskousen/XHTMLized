<div class="columns">
	<div class="column1 fleft">
  	<?php
		  if ($this->registry->request('module') == 'home'):
		  	include_once('home.php');
		  else:
		  	if (file_exists(_reg('base_path') . _reg('theme_path') . $this->registry->request('module') . '/' . $this->registry->request('section') . '.php')) {
		  		include_once($this->registry->request('module') . '/' . $this->registry->request('section') . '.php');
		  	} else {
		  		include_once('404.php');
		  	}
		  	
		  endif;
		?>
  </div><!-- .column1 -->
  <div class="column2 fleft">
		<?php
			include_once('column1.php');
			/*
			if (file_exists(_reg('base_path') . _reg('theme_path') . $this->registry->request('module') . '/column1.php')) {
				include_once(_reg('base_path') . _reg('theme_path') . $this->registry->request('module') . '/column1.php');
			} else {
				include_once(_reg('base_path') . _reg('theme_path') . 'column1.php');
				//include_once('404.php');
			}
			*/
		?>
  </div><!-- .column2 -->
  <div class="column2 fleft">
		<?php include_once('column2.php'); ?>
  </div><!-- .column2 -->
</div><!-- .columns -->
<?php include_once('services.php'); ?>