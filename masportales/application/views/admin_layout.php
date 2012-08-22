<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
		<title>+Portales Admin Panel</title>
		<link rel="stylesheet" href="<?php echo _reg('css_url'); ?>reset.css" type="text/css" />
		<link rel="stylesheet" href="<?php echo _reg('css_url'); ?>styles.css" type="text/css" />
		<link type="text/css" href="<?php echo _reg('css_url'); ?>jquery-ui.custom.css" rel="stylesheet" />
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
		<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.13/jquery-ui.min.js"></script>
		<script src="//ajax.aspnetcdn.com/ajax/jquery.templates/beta1/jquery.tmpl.min.js"></script>
		<script type="text/javascript" src="<?php echo _reg('js_url'); ?>jquery-ui.custom.min.js"></script>
		<script type="text/javascript" src="<?php echo _reg('js_url'); ?>mp.date.js"></script>
		<script type="text/javascript" src="<?php echo _reg('js_url'); ?>mp.custom.js"></script>
		<script>
			wysiwyg_defaults = {
				controls: {
			  	insertHorizontalRule: { visible: false },
			  	insertImage: { visible: false },
			  	insertTable: { visible: false },
			  	code: { visible: false },
			  	html: { visible: true },
			  	paragraph: { visible: true}
			  },
			  initialContent: '',
			  plugins: {
			  	i18n: { lang: 'es' }
			  },
			  iFrameClass: 'wysiwyg-normal',
			  css: '<?php echo _reg('css_url'); ?>jquery.wysiwyg.editor.css'
			};
		</script>
	</head>
	<body>
		<div id="container">
			<div id="left"><?php include_once('admin/menu.php'); ?></div>
			<div id="right">
				<div class="header">
				<?php if ($this->registry->request('module') == 'dashboard'): ?>
					<h1>Dashboard</h1>
				<?php else: ?>
					<h1><?php echo ($this->registry->module('parent_name')) ? $this->registry->module('parent_name') : $this->registry->module('name'); ?></h1>
					<h2><?php echo $this->registry->module('name'); ?></h2>
				<?php endif; ?>
				</div>
				<div class="content">
					<?php if ($this->registry->message()): ?>
					<div class="message <?php echo $this->registry->message('class'); ?>">
						<a class="close" href="#"><img alt="close" title="Cerrar mensaje" src="<?php echo _reg('site_url'); ?>images/cross_grey_small.png"></a>
						<div><?php echo $this->registry->message('content'); ?></div>
					</div>
					<?php endif; ?>
					<?php 
						if ($this->registry->request('module') == 'dashboard'):
							include_once('admin/dashboard.php');
						else:
							include_once('admin/' . $this->registry->request('module') . '/' . _reg('section') . '_' . _reg('action') . '.php');
						endif;
					?>
<?php
echo '<pre>';
print_r($this->session->all_userdata());
echo '</pre>';
echo '<p>Request</p>';
echo '<pre>';
print_r($this->registry->request());
echo '</pre>';
echo '<p>Core</p>';
echo '<pre>';
print_r($this->registry->core());
echo '</pre>';
echo '<p>Site</p>';
echo '<pre>';
print_r($this->registry->site());
echo '</pre>';
echo '<p>Module</p>';
echo '<pre>';
print_r($this->registry->module());
echo '</pre>';
echo '<p>Message</p>';
echo '<pre>';
print_r($this->registry->message());
echo '</pre>';
echo '<p>User</p>';
echo '<pre>';
print_r($this->registry->user());
echo '</pre>';
echo '<p>Company</p>';
echo '<pre>';
print_r($this->registry->company());
echo '</pre>';
echo '<pre>';
print_r($this->_ci_cached_vars);
echo '</pre>';
?>
				</div>
			</div>
		</div>
	</body>
</html>
