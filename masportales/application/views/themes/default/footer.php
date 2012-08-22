<div id="footer">
    <div class="container">
        <div class="logotipo">
            <a href="#" class="fade"><img src="../../../../images/masportales_logo.png" width="105" height="40" /></a>
        </div>
        <div class="nav">
            <p><a href="<?php echo _reg('site_url'); ?>mp/quienes-somos">Quienes somos</a> <a href="<?php echo _reg('site_url'); ?>mp/aviso-legal">Aviso Legal</a> <a href="<?php echo _reg('site_url'); ?>mp/politica-de-privacidad">Política de privacidad</a> <a href="<?php echo _reg('site_url'); ?>mp/condiciones-de-uso">Condiciones de uso</a> <a href="<?php echo _reg('site_url'); ?>mp/lopd-lssi">LOPD y LSSI</a> <a href="<?php echo _reg('site_url'); ?>mp/sitemap">Mapa Web</a> <a href="<?php echo _reg('site_url'); ?>mp/contacto">Contacto</a></p>
        </div>
        <!-- .nav -->
        
        <div class="sociales">
            <a href="https://www.facebook.com/pages/Portales/19641592611" target="_blank" class="fade icon"><img src="<?php echo _reg('site_url') . _reg('theme_path'); ?>css/images/icons_48x48/facebook.png" alt="Facebook" /></a> <a href="http://twitter.com/#!/MasPortales" target="_blank" class="fade icon"><img src="<?php echo _reg('site_url') . _reg('theme_path'); ?>css/images/icons_48x48/twitter.png" alt="Twitter" /></a> <a href="" class="fade icon"><img src="<?php echo _reg('site_url') . _reg('theme_path'); ?>css/images/icons_48x48/google.png" alt="Google" /></a> <a href="" class="fade icon"><img src="<?php echo _reg('site_url') . _reg('theme_path'); ?>css/images/icons_48x48/Tuenti.png" alt="Tuenti" /></a> <a href="" class="fade icon"><img src="<?php echo _reg('site_url') . _reg('theme_path'); ?>css/images/icons_48x48/rss.png" alt="RSS" /></a>
        </div>
        <!-- .sociales -->
        
    </div>
    <!-- .container -->
</div>
<!-- #footer -->



<div id="minisite">
    <div class="info">
        <p class="txt">+Portales es la franquicia pionera de portales de servicios en internet. Desde 2006 estamos innovando y estudiando el concepto de negocio mediante portales de servicios al usuario.</p>
        <ul>
            <li><a href="http://www.masportales.com/ique-es-portales">¿Qué es +Portales?</a></li>
            <li><a href="http://www.masportales.com/tipo-de-franquicias">Modos de franquiciarse</a></li>
            <li><a href="http://www.masportales.com/ventajas-de-portales">Ventajas de +Portales</a></li>
            <li><a href="http://www.masportales.com/pidenos-informacion">Pídenos Información</a></li>
            <li><a href="http://www.masportales.com/preguntas-frecuentes">Preguntas frecuentes</a></li>
        </ul>
    </div>
    <!-- .info -->
    
    <div id="franchises">
        <h6>Otros portales de la franquicia</h6>
        <div class="stateslist">
            <ul>
                <li>Andalucía</li>
                <li>Aragon</li>
                <li>Asturias</li>
                <li>Baleares</li>
                <li>Canarias</li>
                <li>Cantabría</li>
            </ul>
        </div>
        <div class="stateslist">
            <ul>
                <li>Castilla la Mancha</li>
                <li>Castilla y León</li>
                <li>Cataluña</li>
                <li>Ceuta y Melilla</li>
                <li>Extremadura
                    <ul>
                        <li><a href="">Miajadas</a></li>
                        <li><a href="">Olivenza</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="stateslist">
            <ul>
                <li>Galicia</li>
                <li>Madrid</li>
                <li>Murcia</li>
                <li>Navarra</li>
                <li>País Vasco</li>
                <li>La Rioja</li>
                <li>Valencia</li>
            </ul>
        </div>
    </div>
    <!-- #franchises -->
</div>
<!-- #minisite -->
<div id="copy">
    <p>+Portales, noticias, empresas, productos y servicios para tu localidad - ® 2012 todos los derechos reservados</p>
</div>


<!-- This contains the hidden content for inline calls -->
<div style="display:none">
    <div id="form-login" class="form-lightbox">
        <form action="<?php echo _reg('site_url') . 'entrar'; ?>" method="post" id="loginform">
            <fieldset>
                <h4>Entrar en +Portales</h4>
                <p>
                    <label for="username">Nombre de usuario</label>
                    <input type="text" name="username" id="username" value="" />
                </p>
                <p>
                    <label for="password">Contraseña</label>
                    <input type="password" name="password" id="password" value="" />
                </p>
            </fieldset>
            <input type="submit" style="position: absolute; left: -9999px; width: 1px; height: 1px;"/>
            <p class="btnlog"><a href="#" class="btn" onclick="$('#loginform').submit();">Entrar</a></p>
            <p><a href="" class="btn" id="forgotpsw">He olvidado mi contraseña…</a></p>
            <p class="message error" id="loginmessage" style="display:none"></p>
        </form>
    </div>
    <div id="form-registration" class="form-lightbox">
        <form action="<?php echo _reg('site_url') . 'registrarse/pasodos'; ?>" method="post" id="registrationform">
            <fieldset>
                <h4>Regístrate en +Portales</h4>
                <p>
                    <label for="name">Nombre</label>
                    <input type="text" name="name" id="regname" value="" />
                </p>
                <span class="validation" id="nameInfo"></span>
                <p>
                    <label for="surname">Apellidos</label>
                    <input type="text" name="surname" id="regsurname" value="" />
                </p>
                <span class="validation" id="surnameInfo"></span>
                <p>
                    <label for="email">Email</label>
                    <input type="text" name="email" id="regemail" value="" />
                </p>
                <span class="validation" id="emailInfo"></span>
                <p>
                    <label for="username">Nombre de usuario</label>
                    <input type="text" name="username" id="regusername" value="" />
                </p>
                <span class="validation" id="usernameInfo"></span>
                <p>
                    <label for="password">Contraseña</label>
                    <input type="password" name="password" id="regpassword" value="" />
                </p>
                <span class="validation" id="passwordInfo"></span>
                <p>
                    <label for="password2">Repite contraseña</label>
                    <input type="password" name="password2" id="regpassword2" value="" />
                </p>
                <span class="validation" id="password2Info"></span>
                <p style="margin:24px 0 0 0;">
                    <input type="checkbox" name="condiciones" id="condiciones" value="" />
                    Acepto las <a href="<?php echo _reg('site_url'); ?>mp/condiciones-de-uso" target="_blank">Condiciones de Uso</a> y la <a href="<?php echo _reg('site_url'); ?>mp/politica-de-privacidad" target="_blank">Política de privacidad</a> de <?php echo $this->registry->site('name'); ?>+Portales</p>
                <span class="validation" id="condicionesInfo"></span>
            </fieldset>
            <input type="submit" style="position: absolute; left: -9999px; width: 1px; height: 1px;"/>
            <p class="btnlog"><a href="#" class="btn" onclick="$('#registrationform').submit();">Enviar</a></p>
            <p class="message error" id="registrationmessage" style="display:none"></p>
        </form>
    </div>
</div>
<script>
$(document).ready(function () {
  //shopping cart. delete items
  $(document).on('click', '.shoppingcart > li > .btn-delete', function (event) {
  	event.preventDefault();
  	var rowid = $(this).parent().attr('id');
  	var delete_li = $(this).parent();
  	var product_price = $(this).parent().children('p').children('.product-price').text();
  	$.ajax({
  	  url: '<?php echo _reg('site_url'); ?>cart/delete',
  	  data: {rid: rowid},
  	  type: 'post',
  	  success: function(data, textStatus, jqXHR){
  	  	delete_li.remove();
  	  	cart_n_items = cart_n_items - 1;
  	  	cart_total = parseFloat(data.cart_total);
      	$('.cart-totals > p > .product-price').text(data.cart_total);
      	
  	  	if (cart_n_items == 0) {
  	  		$('#column2cart').hide();
  	  		cart_display = false;
  	  	}
  	  }
  	});
    
  });
  //loginform. submit
  $('#loginform').submit( function (event) {
  	event.preventDefault();
    var usr = $('#username').val();
    var psw = $('#password').val();
    $.ajax({
  	  url: '<?php echo _reg('site_url'); ?>login',
  	  data: {usr: usr, psw: psw},
  	  type: 'post',
  	  dataType: 'json',
  	  success: function(data, textStatus, jqXHR){
  	  	if (data.login) {
  	  		window.location.replace('<?php echo _reg('site_url'); ?>micuenta');
  	  	} else {
  	  		$('#loginmessage').css('display', 'block');
  	  		$('#loginmessage').text(data.message);
  	  		$.colorbox.resize();
  	  	}
  	  }
  	});
  });
  //registrationform. submit
  $('#registrationform').submit( function (event) {
  	event.preventDefault();
  	validateName();
  	validateSurname();
  	validateEmail();
  	validateUsername();
  	validatePassword();
  	validatePassword2();
  	validateCondiciones();
  	
    if(validName & validSurname & validEmail & validUsername & validPassword & validPassword2 & validCondiciones){
  		
  		$.ajax({
  			url: '<?php echo _reg('site_url'); ?>login/register',
  			data: {name: name.val(), surname: surname.val(), email: email.val(), username: username.val(), password: password.val(), password2: password2.val()},
  			type: 'post',
  			dataType: 'json',
  			success: function (data, textStatus, jqXHR) {
  				console.log(data);
  				if (data.registered) {
  					$('#registrationmessage').css('display', 'block');
  					$('#registrationmessage').removeClass('error').addClass('success');
  					$('#registrationmessage').text(data.message);
  				} else {
  					$('#registrationmessage').css('display', 'block');
  					$('#registrationmessage').removeClass('success').addClass('error');
  					$('#registrationmessage').text(data.message);
  				}
  				$.colorbox.resize();
  			}
  		});
  	}else{
  	}
  	
    
  });
  //forgot password
  $('#forgotpsw').click( function (event) {
  	event.preventDefault();
  	var usr = $('#username').val();
  	
  	if (usr == '') {
  		$('#loginmessage').text('Debe indicar el usuario para el que no recuerda la contraseña');
  		$('#loginmessage').css('display', 'block');
  	  $.colorbox.resize();
  	} else {
  		$.ajax({
  		  url: '<?php echo _reg('site_url'); ?>login/forgotpsw',
  		  data: {usr: usr},
  		  type: 'post',
  		  dataType: 'json',
  		  success: function(data, textStatus, jqXHR){
  		  	$('#loginmessage').css('display', 'block');
  		  	$('#loginmessage').text(data.message);
  	  		$.colorbox.resize();
  		  }
  		});
  	}
  });
  //registration form validation
  var name = $('#regname');
  var surname = $('#regsurname');
  var email = $('#regemail');
  var username = $('#regusername');
  var password = $('#regpassword');
  var password2 = $('#regpassword2');
  var condiciones = $('#condiciones');
  
  var nameInfo = $('#nameInfo');
  var surnameInfo = $('#surnameInfo');
  var emailInfo = $('#emailInfo');
  var usernameInfo = $('#usernameInfo');
  var passwordInfo = $('#passwordInfo');
  var password2Info = $('#password2Info');
  var condicionesInfo = $('#condicionesInfo');
  
  var validName = false;
  var validSurname = false;
  var validEmail = false;
  var validUsername = false;
  var validPassword = false;
  var validPassword2 = false;
  var validCondiciones = false;
  
  name.blur(validateName);
  surname.blur(validateSurname);
  email.blur(validateEmail);
  username.blur(validateUsername);
  password.blur(validatePassword);
  password2.blur(validatePassword2);
  condiciones.blur(validateCondiciones);
  
  function validateName(){
  	//if it's NOT valid
  	if(name.val().length < 3){
  		name.addClass("error");
  		nameInfo.text("Debe introducir un nombre para registrarse.");
  		nameInfo.addClass("error");
  		validName = false;
  		$.colorbox.resize();
  		return false;
  	}else{
  		name.removeClass("error");
  		nameInfo.text('');
  		nameInfo.removeClass("error");
  		validName = true;
  		$.colorbox.resize();
  		return true;
  	}
  }
  function validateSurname(){
  	//if it's NOT valid
  	if(surname.val().length < 3){
  		surname.addClass("error");
  		surnameInfo.text("Debe introducir un apellido para registrarse.");
  		surnameInfo.addClass("error");
  		validSurname = false;
  		$.colorbox.resize();
  		return false;
  	}
  	//if it's valid
  	else{
  		surname.removeClass("error");
  		surnameInfo.text('');
  		surnameInfo.removeClass("error");
  		$.colorbox.resize();
  		validSurname = true;
  		return true;
  	}
  }
  function validateEmail(){
  	//testing regular expression
  	var a = email.val();
  	var exists = Boolean(false);
  	var filter = /^[a-zA-Z0-9]+[a-zA-Z0-9_.-]+[a-zA-Z0-9_-]+@[a-zA-Z0-9]+[a-zA-Z0-9.-]+[a-zA-Z0-9]+.[a-z]{2,4}$/;
  	//if it's valid email
  	if(filter.test(a)){
  		//check if already exists
  		$.ajax({
  			url: '<?php _e('site_url'); ?>login/validemail',
  			data: {email: a},
  			type: 'post',
  			dataType: 'json',
  			async: false,
  			success: function (data, textStatus, jqXHR) {
  				if(data.registered){
  					email.addClass("error").removeClass('success');
  					emailInfo.text("Este email ya esta registrado.");
  					emailInfo.addClass("error").removeClass('success');
  					validEmail = false;
  					$.colorbox.resize();
  					return false;
  				}else{
  					email.removeClass("error").addClass('success');
  					emailInfo.text('Email válido.');
  					emailInfo.removeClass("error").addClass('success');
  					validEmail = true;
  					$.colorbox.resize();
  					return true;
  				}
  			}
  		});
  		$.colorbox.resize();
  	}else{
  		email.addClass("error").removeClass('success');
  		emailInfo.text("Debe indicar un email válido.");
  		emailInfo.addClass("error").removeClass('success');
  		validEmail = false;
  		$.colorbox.resize();
  		return false;
  	}
  }
  function validateUsername(){
  	var a = username.val();
  	//if it's NOT valid
  	if(username.val().length < 6){
  		username.addClass("error").removeClass('success');
  		usernameInfo.text("El nombre de usuario debe tener al menos 6 letras.");
  		usernameInfo.addClass("error").removeClass('success');
  		validUsername = false;
  		$.colorbox.resize();
  		return false;
  	}else{
  		//check if already exists
  		$.ajax({
  			url: '<?php _e('site_url'); ?>login/validusername',
  			data: {username: a},
  			type: 'post',
  			dataType: 'json',
  			async: false,
  			success: function (data, textStatus, jqXHR) {
  				if(data.registered){
  					username.addClass("error").removeClass('success');
  					usernameInfo.text("Ya existe un usuario con este nombre de usuario.");
  					usernameInfo.addClass("error").removeClass('success');
  					validUsername = false;
  					$.colorbox.resize();
  					return false;
  				}else{
  					username.removeClass("error").addClass('success');
  					usernameInfo.text('Nombre de usuario válido.');
  					usernameInfo.removeClass("error").addClass('success');
  					validUsername = true;
  					$.colorbox.resize();
  					return true;
  				}
  			}
  		});
  		$.colorbox.resize();
  	}
  }
  function validatePassword(){
  	//it's NOT valid
  	if(password.val().length < 6){
  		password.addClass('error');
  		passwordInfo.text('La contraseña debe tener al menos 6 caracteres.');
  		passwordInfo.addClass("error");
  		validPassword = false;
  		$.colorbox.resize();
  		return false;
  	}
  	//it's valid
  	else{			
  		password.removeClass("error");
  		passwordInfo.text('');
  		passwordInfo.removeClass("error");
  		validPassword = true;
  		$.colorbox.resize();
  		return true;
  	}
  }
  function validatePassword2(){
  	//it's NOT valid
  	if(password.val() != password2.val()){
  		password2.addClass('error');
  		password2Info.text('Las contraseñas no coinciden.');
  		password2Info.addClass("error");
  		validPassword2 = false;
  		$.colorbox.resize();
  		return false;
  	}
  	//it's valid
  	else{			
  		password2.removeClass("error");
  		password2Info.text('');
  		password2Info.removeClass("error");
  		validPassword2 = true;
  		$.colorbox.resize();
  		return true;
  	}
  }
  function validateCondiciones(){
  	//it's NOT valid
  	if(!condiciones.is(':checked')){
  		condiciones.addClass('error');
  		condicionesInfo.text('Debe aceptar las condiciones de uso y política de privacidad para poder registrarse.');
  		condicionesInfo.addClass("error");
  		validCondiciones = false;
  		$.colorbox.resize();
  		return false;
  	}
  	//it's valid
  	else{			
  		condiciones.removeClass("error");
  		condicionesInfo.text('');
  		condicionesInfo.removeClass("error");
  		validCondiciones = true;
  		$.colorbox.resize();
  		return true;
  	}
  }
});
</script>
<script type="text/javascript" src="http://www.eltiempo.es/widget/widget_loader/357a71a7bb1f0c7843df581efa3b272b"></script>
</body></html>