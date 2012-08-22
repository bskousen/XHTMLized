<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
		<title>+Portales Admin Panel</title>
		<link rel="stylesheet" href="<?php echo _reg('css_url'); ?>reset.css" type="text/css" />
		<link rel="stylesheet" href="<?php echo _reg('css_url'); ?>login.css" type="text/css" />
	</head>
	<body>
		<div class="logo"><img src="<?php echo _reg('site_url') ?>images/masportales_logo.png" alt="+portales" /></div>
		<div class="container">
			<h1>Panel Administraci&oacute;n +Portales</h1>
			<form action="<?php echo $form_action; ?>" method="post" enctype="multipart/form-data" id="loginform">
				<label for="user_login">usuario</label>
				<input type="text" name="user_login" value="" />
				<label for="password">contrase&ntilde;a</label>
				<input type="password" name="password" value="" />
				<input type="submit" style="position: absolute; left: -9999px; width: 1px; height: 1px;"/>
			</form>
			<div class="buttons">
				<a href="#" onclick="document.getElementById('loginform').submit();">ingresar</a>
			</div>
		</div>
		<?php if ($this->session->flashdata('login_error')): ?>
		<div class="error">
			<p><?php echo $this->session->flashdata('login_error'); ?></p>
		</div>
		<?php endif; ?>
	</body>
</html>