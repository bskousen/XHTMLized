<div id="signup" class="section user nolog">
  <div class="header"><h4>REGÍSTRATE</h4></div>
  <div class="content">
  	<p></p>
  	<?php if ($data['confirmed']): ?>
  	<p class="message success">Cuenta activada correctamente correctamente.</p>
  	<p>Gracias por registrarte.</p>
  	<p>Ya puedes acceder a todas nuestras funcionalidades.</p>
  	<?php else: ?>
  	<p class="message error">Se ha producido un error al activar la cuenta.</p>
  	<p>Esto puede error puede deberse a:</p>
  	<ul>
  		<li>La cuenta ya ha sido confirmada y el enlace de confirmación ya no es válido.</li>
  		<li>El enlace de confirmación está incorrecto.</li>
  		<li>Hay algún tipo de incidencia en nuestros sistemas.</li>
  	</ul>
  	<p>Inténtelo más tarde o póngase en contacto con nosotros.</p>
  	<?php endif; ?>
  </div><!-- .content -->
</div><!-- #news .section -->
<img src="http://placehold.it/468x60/ccc/fff&text=full+banner+(468x60)" alt="full banner (468x60px)" class="fullbanner" />