<div id="signin" class="section user nolog">
  <div class="header"><h4>ENTRAR</h4></div>
  <div class="content">
  	<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.</p>
  	<?php echo validation_errors(); ?>
  	<?php if (!$data): ?>
  	<div class="message error">Nombre de usuario o contraseña incorrectos.</div>
  	<?php endif; ?>
  	<form action="<?php echo _reg('site_url') . 'entrar'; ?>" method="post">
  		<fieldset>
  			<legend>Entrar en +Portales</legend>
  			<label for="username">Nombre de usuario</label><input type="text" name="username" id="username" value="<?php echo set_value('username'); ?>" />
  			<label for="password">Contraseña</label><input type="password" name="password" id="password" value="<?php echo set_value('password'); ?>" />
  		</fieldset>
  		<input type="submit" value="Entrar" />
  	</form>
  </div><!-- .content -->
</div><!-- #signin .section -->
<?php $this->mpbanners->print_banner('column-main', 'fullbanner'); ?>