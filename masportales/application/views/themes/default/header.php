<!DOCTYPE html>
<html lang="es" xmlns:og="http://ogp.me/ns#" xmlns:fb="http://www.facebook.com/2008/fbml">
   <head>
   <meta charset="utf-8">
   <title><?php echo $this->registry->get_meta('title'); ?></title>
   <meta name="keywords" content="<?php echo $this->registry->get_meta('keywords'); ?>" />
   <meta name="description" content="<?php echo $this->registry->get_meta('description'); ?>" />
   <?php if ($this->registry->get_meta('open_graph')): ?>
   <meta property="og:title" content="<?php echo $this->registry->get_meta('og_title'); ?>" />
   <meta property="og:type" content="<?php echo $this->registry->get_meta('og_type'); ?>" />
   <meta property="og:url" content="<?php echo $this->registry->get_meta('og_url'); ?>" />
   <meta property="og:image" content="<?php echo $this->registry->get_meta('og_image'); ?>" />
   <meta property="og:site_name" content="<?php echo $this->registry->get_meta('og_site_name'); ?>" />
   <?php endif; ?>
   <link rel="stylesheet" href="<?php echo _reg('css_url'); ?>reset.css" />
   <link rel="stylesheet" href="<?php echo _reg('css_url'); ?>styles.css" />
   <link rel="stylesheet" href="<?php echo _reg('css_url'); ?>jquery-ui.custom.css" />
   <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
   <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.5/jquery-ui.min.js"></script>
   <script src="//ajax.aspnetcdn.com/ajax/jquery.templates/beta1/jquery.tmpl.min.js"></script>
   <script type="text/javascript" src="<?php echo _reg('js_url'); ?>jquery-ui.custom.min.js"></script>
   <script type="text/javascript" src="<?php echo _reg('js_url'); ?>jquery.colorbox-min.js"></script>
   <script type="text/javascript" src="https://apis.google.com/js/plusone.js">
		  {lang: 'es'}
		</script>
   <script>
			var cart_display = Boolean(<?php echo $this->registry->cart('n_items'); ?>);
			var cart_n_items = Number(<?php echo $this->cart->total_items(); ?>);
			var cart_total = Number(<?php echo $this->cart->total(); ?>);
			function formatDateDB (input) {
			  var datePart = input.match(/\d+/g),
			  year = datePart[2],
			  month = datePart[1], day = datePart[0];
			
			  return year+'-'+month+'-'+day+' 00:00:00';
			}
			
			wysiwyg_defaults = {
				controls: {
			  	insertHorizontalRule: { visible: false },
			  	insertImage: { visible: false },
			  	insertTable: { visible: false },
			  	code: { visible: false },
			  	strikeThrough: {visible: false },
			  	indent: {visible: false },
			  	outdent: {visible: false },
			  	subscript: {visible: false },
			  	superscript: {visible: false },
			  	createLink: {visible: false },
			  	paragraph: {visible: true},
			  	h1: {visible: false},
			  	h2: {visible: false},
			  	h3: {visible: false}
			  },
			  initialContent: '',
			  plugins: {
			  	i18n: { lang: 'es' }
			  },
			  iFrameClass: 'wysiwyg-normal',
			  css: '<?php echo _reg('css_url'); ?>jquery.wysiwyg.editor.css'
			};
			
			$.datepicker.setDefaults({
				dateFormat: 'dd/mm/yy',
				dayNames: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sábado'],
				dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
				dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
				firstDay: 1,
				monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
				monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
				nextText: 'Próximo',
				prevText: 'Anterior'
			});
			$(document).ready(function(){
				$(".lightbox").colorbox({maxHeight:'80%', maxWidth:'80%'});
				$('.btn-lightbox').colorbox({inline:true, width:'340px'});
				$('.sendemailbtn').colorbox({inline:true, width:'340px'});
			});
		</script>
   <script>      
(function($) {
    function toggleLabel() {
        var input = $(this);
        setTimeout(function() {
            var def = input.attr('title');
            if (!input.val() || (input.val() == def)) {
                input.prev('span').css('visibility', '');
                if (def) {
                    var dummy = $('<label></label>').text(def).css('visibility','hidden').appendTo('body');
                    input.prev('span').css('margin-left', dummy.width() + 3 + 'px');
                    dummy.remove();
                }
            } else {
                input.prev('span').css('visibility', 'hidden');
            }
        }, 0);
    };

    function resetField() {
        var def = $(this).attr('title');
        if (!$(this).val() || ($(this).val() == def)) {
            $(this).val(def);
            $(this).prev('span').css('visibility', '');
        }
    };

    $('input, textarea').live('keydown', toggleLabel);
    $('input, textarea').live('paste', toggleLabel);
    $('select').live('change', toggleLabel);

    $('input, textarea').live('focusin', function() {
        $(this).prev('span').css('color', '#ccc');
    });
    $('input, textarea').live('focusout', function() {
        $(this).prev('span').css('color', '#999');
    });

    $(function() {
        $('input, textarea').each(function() { toggleLabel.call(this); });
    });

})(jQuery);
   </script>
   </head>

   <body>
   <div class="wrapper">
       <div id="header">
           <?php $this->mpbanners->print_banner('mp-banner', 'centralbanner'); ?>
           <div id="social">
               <?php echo fecha(date('Y-m-d H:i:s'), 'large'); ?> - <a href="https://www.facebook.com/pages/Portales/19641592611" target="_blank"><img src="/images/facebook.png" alt="Facebook" width="25" height="25" align="absmiddle" class="fade"></a> <a href="http://twitter.com/#!/MasPortales" target="_blank"><img src="/images/twitter.png" alt="Twitter" width="25" height="25" align="absmiddle" class="fade"></a> <a href="#" target="_blank"><img src="/images/google.png" alt="Google+" width="25" height="25" align="absmiddle" class="fade"></a> <a href="#" target="_blank"><img src="/images/1339537950_Tuenti 02.png" alt="Tuenti" width="25" height="25" align="absmiddle" class="fade"></a> <a href="#" target="_blank"><img src="/images/rss.png" alt="RSS" width="25" height="25" align="absmiddle" class="fade"></a>
           </div>
           <!-- #social -->
           <div id="idiomas">
           </div>
           <!-- #idiomas -->
           <div id="users">
               <ul>
                   <?php if ($this->registry->user()): ?>
                   <li><a href="<?php echo _reg('site_url'); ?>micuenta"><?php echo $this->registry->user('display_name'); ?></a></li>
                   <li><a href="<?php echo _reg('site_url'); ?>entrar/logout">salir</a></li>
                   <?php else: ?>
                   <li><a href="#form-login" class="btn-lightbox">Entrar</a></li>
                   <li><a href="#form-registration" class="btn-lightbox">Registrarse</a></li>
                   <?php endif; ?>
               </ul>
           </div>
           <!-- #users -->
           <div id="globalsearch" class="search">
               <form method="post" action="<?php echo _reg('site_url'); ?>search" name="globalsearchform">
                   <p><label class="input"> <span>Buscar...</span>
                       <input name="searchquery" type="text" class="input-text" /></label>
                       <a href="javascript:document.globalsearchform.submit();" id="search-btn"><img src="<?php echo _reg('site_url') . _reg('theme_path'); ?>images/btn_search.png" alt="buscar" /></a></p>
               </form>
           </div>
           <!-- #search -->
           <div id="brand">
               <a href="<?php echo _reg('site_url'); ?>"><img src="<?php _e('site_url'); ?>images/mp_demologo.png" alt="demo+portales" class="fade"/></a>
           </div>
           <!-- #brand -->
           <div id="nav">
               <ul>
                   <li><a href="<?php echo _reg('site_url'); ?>noticias" id="current">Noticias</a></li>
                   <li><a href="<?php echo _reg('site_url'); ?>empresas">Guía de empresas</a></li>
                   <li><a href="<?php echo _reg('site_url'); ?>tienda">Productos</a></li>
                   <li><a href="<?php echo _reg('site_url'); ?>clasificados">Clasificados</a></li>
                   <li><a href="<?php echo _reg('site_url'); ?>agenda">Agenda</a></li>
                   <!-- <li><a href="">FOROS</a></li>  --> 
                   <!-- <li><a href="">SERVICIOS</a></li>  -->
               </ul>
           </div>
           <!-- #nav -->
           <div id="hads">
               <?php $this->mpbanners->print_banner('subheader', 'halfbanner fleft'); ?>
               <?php $this->mpbanners->print_banner('subheader', 'halfbanner fleft'); ?>
               <?php $this->mpbanners->print_banner('subheader', 'halfbanner fleft'); ?>
               <?php $this->mpbanners->print_banner('subheader', 'halfbanner fleft'); ?>
           </div>
           <!-- hads -->
       </div>
       <!-- #header -->
   </div>
