<div class="section basicads">
    <div class="header_individual">
        <h4>CLASIFICADOS</h4>
    </div>
    <div class="content">
        <div class="basicad">
            <?php if ($data['basicad_images']): ?>
            <div>
                <?php foreach ($data['basicad_images'] as $image): ?>
                <a href="<?php echo get_image_url($image['uri'], '', _reg('site_url') . 'usrs/clasificados/'); ?>" class="lightbox"> <img src="<?php echo get_image_url($image['uri'], '', _reg('site_url') . 'usrs/clasificados/'); ?>" alt="" class="photo"/></a>
                <?php break; ?>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
            
            <?php if ($data['basicad']): ?>
            <div class="basicad-price">
                <span class="product-price"><?php echo number_format($data['basicad']['price'], 2, ',', '.'); ?></span><span class="product-currency"> €</span>
            </div>
            
            <h3><?php echo $data['basicad']['title']; ?></h3>
            
            <div class="description">
                <?php echo $data['basicad']['content']; ?>
            </div>
            
            <div class="contacto">
                <?php echo "Email:"; ?> <?php echo($data["basicad_owner"]["email"]); ?></br>
                <?php echo "Teléfono:"; ?> <?php echo($data["basicad_owner"]["phone"]); ?></br>
            </div>
            
            <?php if ($data['basicad_images']): ?>
            <div>
                <?php foreach ($data['basicad_images'] as $image): ?>
                <a href="<?php echo get_image_url($image['uri'], '', _reg('site_url') . 'usrs/clasificados/'); ?>" class="lightbox"> <img src="<?php echo get_image_url($image['uri'], '', _reg('site_url') . 'usrs/clasificados/'); ?>" alt="" class="clasificado-images"/></a>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
            <?php /* if ($data['basicad_owner']): ?>
  		<div>
  			<h6>Contacto</h6>
  			<p><strong>Teléfono:</strong> <?php echo $data['basicad_owner']['phone']; ?></p>
  			<p><strong>Email:</strong> <?php echo $data['basicad_owner']['email']; ?></p>
  		</div>
  		<?php endif; */ ?>
            <div class="s_share clearfix">
                <!-- AddThis Button BEGIN -->
                <div class="addthis_toolbox addthis_default_style ">
                    <a class="addthis_button_preferred_1"></a> <a class="addthis_button_preferred_2"></a> <a class="addthis_button_preferred_3"></a> <a class="addthis_button_preferred_4"></a> <a class="addthis_button_preferred_10"></a> <a class="addthis_button_compact"></a> <a class="addthis_counter addthis_bubble_style"></a>
                </div>
                <script type="text/javascript">var addthis_config = {"data_track_addressbar":true};</script> 
                <script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=ra-4e7cb62614419fa9"></script> 
                <!-- AddThis Button END -->
            </div>
            <!-- .s_share -->
            <?php else: ?>
            <p class="message">No se encuentra el anuncio.</p>
            <?php endif; ?>
        </div>
        <!-- .basicad -->
    </div>
    <!-- .content --> 
    
    <img src="<?php echo _reg('site_url') . _reg('theme_path'); ?>images/6x6.jpg" alt="" />
    <div id="send-comment" class="content">
        <h4>Contactar con el usuario</h4>
        <?php if ($this->registry->message()): ?>
        <div class="message <?php echo $this->registry->message('class'); ?>">
            <div>
                <?php echo $this->registry->message('content'); ?>
            </div>
        </div>
        <?php endif; ?>
        <?php echo validation_errors(); ?>
        <?php if ($this->registry->message('class') != 'success'): ?>
        <form action="<?php echo _reg('site_url') . 'clasificados/' . $data['basicad']['slug'] . '#send-comment'; ?>" method="post">
            <?php if ($this->registry->user()): ?>
            <label for="name">Nombre</label>
            <input type="text" name="name" value="<?php echo $this->registry->user('display_name'); ?>" readonly="readonly" />
            <label for="email">Email</label>
            <input type="text" name="email" value="<?php echo $this->registry->user('email'); ?>" readonly="readonly" />
            <label for="web">Teléfono</label>
            <input type="text" name="phone" value="<?php echo $this->registry->user('phone'); ?>" readonly="readonly" />
            <?php else: ?>
            <label for="name">Nombre</label>
            <input type="text" name="name" value="<?php echo set_value('name'); ?>" />
            <label for="email">Email</label>
            <input type="text" name="email" value="<?php echo set_value('email'); ?>" />
            <label for="web">Teléfono</label>
            <input type="text" name="phone" value="<?php echo set_value('phone'); ?>" />
            <label for="captcha">Indica a continuación el texto en la imagen</label>
            <?php echo $data['captcha']['image']; ?><br />
            <input type="text" name="captcha" value="" />
            <?php endif; ?>
            <label for="message">Mensaje</label>
            <textarea name="message"><?php echo set_value('message'); ?></textarea>
            <input type="hidden" name="bid" value="<?php echo $data['basicad']['basicad_ID']; ?>" />
            <input type="submit" value="Enviar" />
        </form>
        <?php endif; ?>
    </div>
</div>
<!-- .section .basicads -->
<div style="display:none">
    <div id="form-sendbyemail" class="form-lightbox">
        <form action="<?php echo _reg('site_url') . 'entrar'; ?>" method="post" id="sendbyemailform">
            <fieldset>
                <h4>Enviar a un amigo</h4>
                <p>
                    <label for="byname">Tu nombre</label>
                    <input type="text" name="byname" id="byname" value="" />
                </p>
                <span class="validation" id="bynameInfo"></span>
                <p>
                    <label for="byemail">Tu email</label>
                    <input type="text" name="byemail" id="byemail" value="" />
                </p>
                <span class="validation" id="byemailInfo"></span>
                <p>
                    <label for="toname">Nombre de tu amigo</label>
                    <input type="text" name="toname" id="toname" value="" />
                </p>
                <span class="validation" id="tonameInfo"></span>
                <p>
                    <label for="toemail">Email de tu amigo</label>
                    <input type="text" name="toemail" id="toemail" value="" />
                </p>
                <span class="validation" id="toemailInfo"></span>
                <p>
                    <label for="captcha">Indica el texto en la imagen</label>
                    <?php echo $data['captcha']['image']; ?><br />
                    <input type="text" name="captcha" id="captcha" value="" />
                </p>
                <span class="validation" id="captchaInfo"></span>
            </fieldset>
            <input type="submit" style="position: absolute; left: -9999px; width: 1px; height: 1px;"/>
            <p class="btnlog"><a href="#" class="btn" onclick="$('#sendbyemailform').submit();">Enviar</a></p>
            <p class="message error" id="sendbyemailmessage" style="display:none"></p>
        </form>
    </div>
</div>
<script>
$(document).ready(function () {
	//sendbyemailform. submit
  $('#sendbyemailform').submit( function (event) {
  	event.preventDefault();
  	validatebyName();
  	validatebyEmail();
  	validatetoName();
  	validatetoEmail();
  	validateCaptcha();
  	
    if(validbyname & validbyemail & validtoname & validtoemail & validcaptcha){
  		
  		$.ajax({
  			url: '<?php echo _reg('site_url'); ?>callback/sendbyemail',
  			data: {byname: byname.val(), byemail: byemail.val(), toname: toname.val(), toemail: toemail.val(), captcha: captcha.val(), title: '<?php echo $title; ?>', permalink: '<?php echo $permalink; ?>'},
  			type: 'post',
  			dataType: 'json',
  			success: function (data, textStatus, jqXHR) {
  				//console.log(data);
  				if (data.sentemail) {
  					$('#sendbyemailmessage').css('display', 'block');
  					$('#sendbyemailmessage').removeClass('error').addClass('success');
  					$('#sendbyemailmessage').text(data.message);
  				} else {
  					$('#sendbyemailmessage').css('display', 'block');
  					$('#sendbyemailmessage').removeClass('success').addClass('error');
  					$('#sendbyemailmessage').text(data.message);
  				}
  				$.colorbox.resize();
  			}
  		});
  	}else{
  	}
  	
    
  });
  
  //sendbyemail form validation
  var byname = $('#byname');
  var byemail = $('#byemail');
  var toname = $('#toname');
  var toemail = $('#toemail');
  var captcha = $('#captcha');
  
  var bynameInfo = $('#bynameInfo');
  var byemailInfo = $('#byemailInfo');
  var tonameInfo = $('#tonameInfo');
  var toemailInfo = $('#toemailInfo');
  var captchaInfo = $('#captchaInfo');
  
  var validbyname = false;
  var validbyemail = false;
  var validtoname = false;
  var validtoemail = false;
  var validcaptcha = false;
  
  byname.blur(validatebyName);
  byemail.blur(validatebyEmail);
  toname.blur(validatetoName);
  toemail.blur(validatetoEmail);
  captcha.blur(validateCaptcha);
  
  function validatebyName(){
  	//if it's NOT valid
  	if(byname.val().length < 3){
  		byname.addClass("error");
  		bynameInfo.text("Debe introducir su nombre.");
  		bynameInfo.addClass("error");
  		validbyname = false;
  		$.colorbox.resize();
  		return false;
  	}else{
  		byname.removeClass("error");
  		bynameInfo.text('');
  		bynameInfo.removeClass("error");
  		validbyname = true;
  		$.colorbox.resize();
  		return true;
  	}
  }
  function validatetoName(){
  	//if it's NOT valid
  	if(toname.val().length < 3){
  		toname.addClass("error");
  		tonameInfo.text("Debe introducir el nombre de su amigo.");
  		tonameInfo.addClass("error");
  		validtoname = false;
  		$.colorbox.resize();
  		return false;
  	}
  	//if it's valid
  	else{
  		toname.removeClass("error");
  		tonameInfo.text('');
  		tonameInfo.removeClass("error");
  		$.colorbox.resize();
  		validtoname = true;
  		return true;
  	}
  }
  function validatebyEmail(){
  	//testing regular expression
  	var a = byemail.val();
  	var exists = Boolean(false);
  	var filter = /^[a-zA-Z0-9]+[a-zA-Z0-9_.-]+[a-zA-Z0-9_-]+@[a-zA-Z0-9]+[a-zA-Z0-9.-]+[a-zA-Z0-9]+.[a-z]{2,4}$/;
  	//if it's valid email
  	if(filter.test(a)){
  		//check if already exists
  		byemail.removeClass("error");
  		byemailInfo.text('');
  		byemailInfo.removeClass("error");
  		validbyemail = true;
  		$.colorbox.resize();
  		return true;
  		$.colorbox.resize();
  	}else{
  		byemail.addClass("error");
  		byemailInfo.text("Debe indicar un email válido.");
  		byemailInfo.addClass("error");
  		validbyemail = false;
  		$.colorbox.resize();
  		return false;
  	}
  }
  function validatetoEmail(){
  	//testing regular expression
  	var a = toemail.val();
  	var exists = Boolean(false);
  	var filter = /^[a-zA-Z0-9]+[a-zA-Z0-9_.-]+[a-zA-Z0-9_-]+@[a-zA-Z0-9]+[a-zA-Z0-9.-]+[a-zA-Z0-9]+.[a-z]{2,4}$/;
  	//if it's valid email
  	if(filter.test(a)){
  		//check if already exists
  		toemail.removeClass("error");
  		toemailInfo.text('');
  		toemailInfo.removeClass("error");
  		validtoemail = true;
  		$.colorbox.resize();
  		return true;
  		$.colorbox.resize();
  	}else{
  		toemail.addClass("error");
  		toemailInfo.text("Debe indicar un email válido.");
  		toemailInfo.addClass("error");
  		validtoemail = false;
  		$.colorbox.resize();
  		return false;
  	}
  }
  function validateCaptcha(){
  	//if it's NOT valid
  	if(captcha.val().length < 8){
  		captcha.addClass("error");
  		captchaInfo.text("Debe indicar el texto de la imagen.");
  		captchaInfo.addClass("error");
  		validcaptcha = false;
  		$.colorbox.resize();
  		return false;
  	}
  	//if it's valid
  	else{
  		captcha.removeClass("error");
  		captchaInfo.text('');
  		captchaInfo.removeClass("error");
  		$.colorbox.resize();
  		validcaptcha = true;
  		return true;
  	}
  }
});
</script>