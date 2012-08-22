
<?php include_once('header.php'); ?>
		<div id="content">
			<?php
		  if ($this->registry->request('myaccount')):
		  	include_once('account.php');
		  else:
		  	include_once('content.php');
		  endif;
			?>
		</div><!-- #content -->
<?php include_once('footer.php'); ?>
