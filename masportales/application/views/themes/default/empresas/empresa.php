<div class="section business">
  <div class="header_individual"><h4>Ficha de empresa</h4></div>
  <div class="content cartshop">
    
    <div id="bizdata_individual">
    	<?php if ($data['company']['logo']): ?>
      	<?php
      	// get the filename for the logo image:
      	// slice the filename in name and extension, add file size suffix at the en of the name and stick it again
      	$filename = pathinfo($data['company']['logo'], PATHINFO_FILENAME);
      	$fileext = strtolower(pathinfo($data['company']['logo'], PATHINFO_EXTENSION));
      	$logo_path = _reg('site_url') . 'usrs/empresas/' . $filename . '.' . $fileext;
      	?>
      	<img src="<?php echo $logo_path; ?>" class="photo2"/>
      <?php endif; ?>
      <h2><?php echo $data['company']['name']; ?></h2>
      <div class="excerpt"><?php echo substr($data['company']['description'], 0, 180); ?>...</div>
      <div class="address">
      	<p><?php echo $data['company']['address']; ?><br /><?php echo $data['company']['zipcode']; ?> <?php echo $data['company']['city']; ?> (<?php echo $data['company']['state']; ?>)</p>
      	<p>(T) <?php echo $data['company']['phone']; ?></p>
      	<p>(web) <?php echo $data['company']['web']; ?></p>
      </div><!-- .address -->
            	<?php
  			$gmap_address = urlencode($data['company']['address'] . ', ' . $data['company']['zipcode'] . ', ' . $data['company']['city'] . ', ' . $data['company']['country']);
  			$gmap_icon = _reg('base_url') . 'usrs/gmap.png';
  			?>
  			<img src="http://maps.google.com/maps/api/staticmap?zoom=14&size=432x216&maptype=roadmap&markers=color:0xCC3399%7C<?php echo $gmap_address; ?>&sensor=false" alt="" />
  			<p><a href="http://maps.google.es/maps?q=<?php echo $gmap_address; ?>" target="_blank">ver en Google Maps</a></p>
    </div><!-- #bizdata -->
    <div class="s_share clearfix">
        <!-- AddThis Button BEGIN -->
        <div class="addthis_toolbox addthis_default_style ">
        <a class="addthis_button_preferred_1"></a>
        <a class="addthis_button_preferred_2"></a>
        <a class="addthis_button_preferred_3"></a>
        <a class="addthis_button_preferred_4"></a>
        <a class="addthis_button_preferred_10"></a>
        <a class="addthis_button_compact"></a>
        <a class="addthis_counter addthis_bubble_style"></a>
        </div>
        <script type="text/javascript">var addthis_config = {"data_track_addressbar":true};</script>
        <script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=ra-4e7cb62614419fa9"></script>
        <!-- AddThis Button END -->
  	</div><!-- .s_share -->
  </div><!-- .content -->
  <img src="<?php echo _reg('site_url') . _reg('theme_path'); ?>images/6x6.jpg" alt="" />

</div><!-- .business .section -->
<div style="display:none">
	<div id="form-sendbyemail" class="form-lightbox">
		<form action="<?php echo _reg('site_url') . 'entrar'; ?>" method="post" id="sendbyemailform">
    	<fieldset>
    		<h4>Enviar a un amigo</h4>
    		<p><label for="byname">Tu nombre</label><input type="text" name="byname" id="byname" value="" /></p>
    		<span class="validation" id="bynameInfo"></span>
    		<p><label for="byemail">Tu email</label><input type="text" name="byemail" id="byemail" value="" /></p>
    		<span class="validation" id="byemailInfo"></span>
    		<p><label for="toname">Nombre de tu amigo</label><input type="text" name="toname" id="toname" value="" /></p>
    		<span class="validation" id="tonameInfo"></span>
    		<p><label for="toemail">Email de tu amigo</label><input type="text" name="toemail" id="toemail" value="" /></p>
    		<span class="validation" id="toemailInfo"></span>
    		<p><label for="captcha">Indica el texto en la imagen</label><?php echo $data['captcha']['image']; ?><br /><input type="text" name="captcha" id="captcha" value="" /></p>
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