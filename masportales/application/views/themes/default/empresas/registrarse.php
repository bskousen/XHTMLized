<div class="section business">
  <div class="header_individual"><h4>Ficha de empresa</h4></div>
  <div class="content">
    <div class="bizdata_individual">
    	<p>Formulario para inscribir tu empresa en la Guía Comercial</p>
    	<?php echo validation_errors(); ?>
    	<form action="<?php echo _reg('site_url') . 'empresas/confirmation'; ?>" method="post">
    		<fieldset>
    			<legend>Tus Datos</legend>
    			<p><label for="name">Tu nombre:</label><input type="text" name="name" id="cname" value="<?php echo set_value('name'); ?>" /></p>
    			<span class="validation" id="cnameInfo"></span>
    			<p><label for="surname">Tus Apellidos:</label><input type="text" name="surname" id="csurname" value="<?php echo set_value('surname'); ?>" /></p>
    			<span class="validation" id="csurnameInfo"></span>
    			<p><label for="email">Email:</label><input type="text" name="email" id="cemail" value="<?php echo set_value('email'); ?>" /></p>
    			<span class="validation" id="cemailInfo"></span>
    			<p><label for="username">Nombre de usuario:</label><input type="text" name="username" id="cusername" value="<?php echo set_value('username'); ?>" /></p>
    			<span class="validation" id="cusernameInfo"></span>
    			<p><label for="password">Contraseña:</label><input type="password" name="password" id="cpassword" value="<?php echo set_value('password'); ?>" /></p>
    			<span class="validation" id="cpasswordInfo"></span>
    			<p><label for="password2">Repite la contraseña:</label><input type="password" name="password2" id="cpassword2" value="<?php echo set_value('password2'); ?>" /></p>
    			<span class="validation" id="cpassword2Info"></span>
    		</fieldset>
    		<fieldset>
    			<legend>Datos de la Empresa</legend>
    			<p><label for="companyname">Nombre de la Empresa:</label><input type="text" name="companyname" value="<?php echo set_value('companyname'); ?>" /></p>
    			<p><label for="nif">NIF:</label><input type="text" name="nif" value="<?php echo set_value('nif'); ?>" /></p>
    			<p><label for="companyemail">Email de la empresa:</label><span>si es distinto al del usuario</span><input type="text" name="companyemail" value="<?php echo set_value('companyemail'); ?>" /></p>
    			<p><label for="address">Dirección:</label><input type="text" name="address" value="<?php echo set_value('address'); ?>" /></p>
    			<p><label for="zipcode">Código Postal:</label><input type="text" name="zipcode" value="<?php echo set_value('zipcode'); ?>" /></p>
    			<p><label for="city">Ciudad:</label><input type="text" name="city" value="<?php echo set_value('city'); ?>" /></p>
    			<p><label for="state">Provincia:</label><input type="text" name="state" value="<?php echo set_value('state'); ?>" /></p>
    			<p><label for="country">Pais:</label><input type="text" name="country" value="<?php echo set_value('country'); ?>" /></p>
    			<p><label for="phone">Teléfono:</label><input type="text" name="phone" value="<?php echo set_value('phone'); ?>" /></p>
    			<p><label for="web">Web:</label><input type="text" name="web" value="<?php echo set_value('web'); ?>" /></p>
    			<p><input type="submit" value="enviar" /></p>
    	</form>
    </div><!-- .bizdata_individual -->
  </div><!-- .content -->
  <img src="<?php echo _reg('site_url') . _reg('theme_path'); ?>images/6x6.jpg" alt="" />

</div><!-- .business .section -->

<script>
$(document).ready(function () {
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
	//registration form validation
	var name = $('#cname');
	var surname = $('#csurname');
	var email = $('#cemail');
	var username = $('#cusername');
	var password = $('#cpassword');
	var password2 = $('#cpassword2');
	
	var nameInfo = $('#cnameInfo');
	var surnameInfo = $('#csurnameInfo');
	var emailInfo = $('#cemailInfo');
	var usernameInfo = $('#cusernameInfo');
	var passwordInfo = $('#cpasswordInfo');
	var password2Info = $('#cpassword2Info');
	
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