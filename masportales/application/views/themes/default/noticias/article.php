<div id="news" class="section news">
    <div class="header">
        <h4>NOTICIAS</h4>
    </div>
    <div class="content">
        <div id="newslist">
            <div class="espacio15"> </div>
            <div class="article-header">
                <h2><a href="<?php echo _reg('site_url') . 'noticias/' . $data['article']['slug']; ?>"><?php echo $data['article']['title']; ?></a></h2>
                <p class="article-date"><?php echo strftime('%d/%m/%G a las %T', strtotime($data['article']['date_added'])); ?></p>
                <a href="<?php echo _reg('site_url') . 'noticias/' . $data['article']['slug'] . '#comments'; ?>" class="comments"> <img src="<?php _e('site_url'); ?>/images/icon_comments.png" alt="comentarios" /> <span>(<?php echo $data['article']['comment_count'] ?> comentarios)</span> </a> </div>
            <div class="s_share clearfix"> 
                <!-- AddThis Button BEGIN -->
                <div class="addthis_toolbox addthis_default_style "> <a class="addthis_button_preferred_1"></a> <a class="addthis_button_preferred_2"></a> <a class="addthis_button_preferred_3"></a> <a class="addthis_button_preferred_4"></a> <a class="addthis_button_preferred_10"></a> <a class="addthis_button_compact"></a> <a class="addthis_counter addthis_bubble_style"></a> </div>
                <script type="text/javascript">var addthis_config = {"data_track_addressbar":true};</script> 
                <script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=ra-4e7cb62614419fa9"></script> 
                <!-- AddThis Button END --> 
            </div>
            <!-- .s_share -->
            <div class="espacio15"> </div>
            
            <?php if ($attachments = $this->registry->column_item('blog_attachments')): ?>
            <?php foreach ($attachments as $attachment): ?>
            <a class="lightbox" href="<?php echo get_image_url($attachment['uri'], '', _reg('site_url') . 'usrs/blog/'); ?>" title="#"><img src="<?php echo get_image_url($attachment['uri'], '', _reg('site_url') . 'usrs/blog/'); ?>" alt="" class="photo2 fleft" /></a>
            <?php break; ?>
			<?php endforeach; ?>
            <?php endif; ?>
            
            <div class="article-content excerpt linea"> <?php echo $data['article']['content']; ?> </div>
            <?php if ($attachments = $this->registry->column_item('blog_attachments')): ?>
            <?php foreach ($attachments as $attachment): ?>
            <a class="lightbox" href="<?php echo get_image_url($attachment['uri'], '', _reg('site_url') . 'usrs/blog/'); ?>" title="#"><img src="<?php echo get_image_url($attachment['uri'], '210x210', _reg('site_url') . 'usrs/blog/'); ?>" alt="" class="photo3 fleft" /></a>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <!-- #newslist --> 
    </div>
    <!-- .content -->
    <?php if ($data['comments']): ?>
    <img src="<?php echo _reg('site_url') . _reg('theme_path'); ?>images/6x6.jpg" alt="" />
    <div id="comments" class="content">
        <h4>Comentarios</h4>
        <ul>
            <?php foreach ($data['comments'] as $comment): ?>
            <?php $comment_author = ($comment['author_url'] != '') ? '<a href="'.$comment['author_url'].'">'.$comment['author'].'</a>' : $comment['author'] ; ?>
            <li>
                <h6>Comentario enviado por <?php echo $comment_author; ?></h6>
                <p class="comment-date">el <?php echo strftime('%d/%m/%G a las %T', strtotime($comment['date_added'])); ?></p>
                <p class="comment-content"><?php echo $comment['content'] ?></p>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>
    <img src="<?php echo _reg('site_url') . _reg('theme_path'); ?>images/6x6.jpg" alt="" />
    <div id="send-comment" class="content">
        <h4>Enviar comentario</h4>
        <?php echo validation_errors(); ?>
        <form action="<?php echo _reg('site_url') . 'noticias/' . $data['article']['slug'] . '#send-comment'; ?>" method="post">
            <?php if ($this->registry->user()): ?>
            <label for="name">Nombre</label>
            <input type="text" name="name" value="<?php echo $this->registry->user('display_name'); ?>" readonly="readonly" />
            <label for="email">Email</label>
            <input type="text" name="email" value="<?php echo $this->registry->user('email'); ?>" readonly="readonly" />
            <label for="web">Web</label>
            <input type="text" name="web" value="<?php echo $this->registry->user('web'); ?>" readonly="readonly" />
            <?php else: ?>
            <label for="name">Nombre</label>
            <input type="text" name="name" value="<?php echo set_value('name'); ?>" />
            <label for="email">Email</label>
            <input type="text" name="email" value="<?php echo set_value('email'); ?>" />
            <label for="web">Web</label>
            <input type="text" name="web" value="<?php echo set_value('web'); ?>" />
            <label for="captcha">Indica a continuación el texto en la imagen</label>
            <?php echo $data['captcha']['image']; ?><br />
            <input type="text" name="captcha" value="" />
            <?php endif; ?>
            <label for="message">Mensaje</label>
            <textarea name="message"><?php echo set_value('message'); ?></textarea>
            <input type="hidden" name="aid" value="<?php echo $data['article']['article_ID']; ?>" />
            <input type="submit" value="Enviar" class="btn" />
        </form>
    </div>
</div>
<!-- #news .section -->
<?php $this->mpbanners->print_banner('column-main', 'fullbanner'); ?>
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