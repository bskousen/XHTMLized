<div class="header">
	<img src="<?php echo _reg('site_url'); ?>images/masportales_logo.png" alt="+portales" />
</div>
<div class="user-info">
	<p>Logeado como <a href="<?php echo _reg('admin_url'); ?>users/user/me"><?php echo $this->registry->user('display_name'); ?></a>.</p>
	<p><a href="<?php echo _reg('site_url') ?>admin/login/logout">desconectar</a></p>
</div>
<ul id="main-nav" class="options">
  <li><a href="<?php echo _reg('admin_url'); ?>">Dashboard</a></li>
  <?php foreach ($left_menu as $menu_op): ?>
  	<li>
  		<a href="<?php echo _reg('admin_url') . $menu_op['module_url']; ?>"><?php echo $menu_op['name']; ?></a>
  		<?php if ($menu_op['sub_menu']): ?>
  		<ul class="submenu">
  			<?php foreach ($menu_op['sub_menu'] as $menu_sub): ?>
  			<li><a href="<?php echo _reg('admin_url') . $menu_op['module_url'] . '/' . $menu_sub['module_url']; ?>"><?php echo $menu_sub['name']; ?></a></li>
  			<?php endforeach; ?>
  		</ul>
  		<?php endif; ?>
  	</li>
  <?php endforeach; ?>
</ul>