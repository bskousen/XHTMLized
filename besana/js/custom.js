// variables iniciales
var config = {
	'last_click': -1,
	'nav_height': 52,
	'content_hide': true,
	'aboutus_hide': true,
	'width': $(window).width(),
	'height': $(window).height(),
	'center_x': ($(window).width() / 2),
	'center_y': ($(window).height() / 2),
	'background_image': {'width': 500, 'height': 500}
};

$(document).ready(function () {
	// obtenemos los valores iniciales
	config.container_height = $('#container').height() - 40;
	config.logo_btn_height = $('#logo-btn img').height();
	//config.aboutus_height = $('#aboutus_container').innerHeight();
	config.header_height = $('#header').height();
	config.more_aboutus_height = $('#more-aboutus').innerHeight();
	config.aboutus_height = config.header_height - config.logo_btn_height;
	config.content_y = config.height - config.container_height;
	
	// posicionamos la capa del fondo
	$('#background').css('left', config.center_x)
									.css('top', config.center_y);
	// posicionamos la capa contenedora
	$('#container').css('top', config.height - config.nav_height)
								 .width(config.width * 3);
	// posicionamos la cabecera
	$('#header').css('top', - config.aboutus_height);
	// ancho de las capas 'nav' y 'content'
	$('#nav').width(config.width);
	$('.content-container').width(config.width);
	// colocamos la primera imagen de background
	bg_x = config.center_x - (config.background_image.width / 2);
	bg_y = config.center_y - (config.background_image.height / 2);
	$('#background').css('left', bg_x).css('top', bg_y);
	
	// cada vez que se redimensione la ventana del navegador
	$(window).resize(function() {
		// volvemos a obtener el alto y ancho de la ventana
		config.width = $(window).width();
		config.height = $(window).height();
		config.center_x = (config.width / 2);
		config.center_y = (config.height / 2);
		config.content_y = config.height - config.container_height;
		config.header_height = $('#header').height();
		config.more_aboutus_height = $('#more-aboutus').innerHeight();
		config.logo_btn_height = 96;
		config.aboutus_height = config.header_height - config.logo_btn_height;
		
		// posicionamos la capa del fondo
		bg_x = config.center_x - (config.background_image.width / 2);
		bg_y = config.center_y - (config.background_image.height / 2);
		$('#background').css('left', bg_x).css('top', bg_y);
		// posicionamos la capa del contenido
		if (config.content_hide) {
			$('#container').css('top', config.height - config.nav_height);
		} else {
			$('#container').css('top', config.content_y);
		}
		$('#container').width(config.width * 3);
		// ancho de las capas 'nav' y 'content'
		$('#nav').width(config.width);
		$('.content-container').width(config.width);
		// posicionamos la cabecera
		if (config.aboutus_hide) {
			$('#header').css('top', - config.aboutus_height);
		}
	});
	
	// click en las opciones de navegacion
	$('#nav a').click( function (event) {
		// cancelamos el comportamient predeterminado del tag html <a>
		event.preventDefault();
		// obtenemos el indice del elemento que hemos pulsado
		var current_click = $(this).parent().index();
		// obtenemos la altura de la capa a mostrar
		var current_div = $('#content'+current_click).parent().height() + config.nav_height;
		config.content_y = config.height - current_div;
		// comprobamos si se esta mostrando el 'about us' en la cabecera
		if (!config.aboutus_hide) {
			// si esta mostrada la ocultamos en primer lugar
			config.aboutus_hide = true;
			$('#header').animate({'top': - config.aboutus_height}, 1000);
		}
		// comprobamos si la capa del contenido se esta mostrando
		if (config.content_hide) {
			// si la capa del contenido esta oculta
			config.content_hide = false;
			$('.hided').removeClass('hided');
			$('#nav ul li').each(function (index, element) {
				if (index != current_click) {
					$(this).children().addClass('unselected');
				}
			});
			config.last_click = current_click;
			// desplazamos a izq. o der. para mostrar el contenido de la seccion pulsada
			$('#horizontal-slider').css('left', - (config.width * current_click));
			// desplazamos la capa del contenido hacia arriba para mostrarla
			$('#container').animate({'top': config.content_y}, 1000, 'easeOutBack');
		} else {
			// si la capa del contenido esta visible
			// comprobamos si hemos pulsado el boton del contenido que estamos mostrando
			if (config.last_click == current_click) {
				// si hemos pulsado el mismo elemento del menu
				config.content_hide = true;
				$('.unselected').removeClass('unselected');
				// desplazamos la capa del contenido hacia abajo para ocultarla
				$('#container').animate({'top': config.height - config.nav_height}, 1000);
				$('#nav ul li a').addClass('hided');
			} else {
				// si hemos pulsado un elemento distinto
				config.last_click = current_click;
				$(this).removeClass('unselected');
				$('#nav ul li').each(function (index, element) {
					if (index != current_click) {
						$(this).children().addClass('unselected');
					}
				});
				$('#container').animate({'top': config.content_y}, 1000, 'easeOutBack');
				// desplazamos a izq. o der. para mostrar el contenido de la seccion pulsada
				$('#horizontal-slider').animate({'left': - config.width * current_click}, 2000, 'easeOutBack');
			}
		}
	});
	
	// comportamiento del logo en 'mouseover'
	$('#logo-btn').mouseover( function (event) {
		if (config.aboutus_hide) {
			$('#header').animate({'top': - config.aboutus_height + config.more_aboutus_height}, 400, 'easeOutBack');
			$('#header #logo-btn img').addClass('over');
		} else {
			$('#header #logo-btn img').addClass('over');
		}
	});
	// comportamiento del logo en 'mouseout'
	$('#logo-btn').mouseout( function (event) {
		mouseout_y = event.clientY;
		if (mouseout_y > config.more_aboutus_height && config.aboutus_hide) {
			$('#header').animate({'top': - config.aboutus_height}, 400);
			$('#header #logo-btn img').removeClass('over');
		} else {
			$('#header #logo-btn img').removeClass('over');
		}
	});
	// click en el logo para mostrar 'about us'
	$('#logo-btn').click( function (event) {
		event.preventDefault();
		//comprobamos si se esta mostrando la capa inferior del contenido
		if (!config.content_hide) {
			//si esta mostrada la ocultamos en primer lugar
			config.content_hide = true;
			$('.unselected').removeClass('unselected');
			// desplazamos la capa del contenido hacia abajo para ocultarla
			$('#container').animate({'top': config.height - config.nav_height}, 1000);
			$('#nav ul li a').addClass('hided');
		}
		if (config.aboutus_hide) {
			config.aboutus_hide = false;
			$('#header').animate({'top': -36}, 1000, 'easeOutBack');
			$('#header #logo-btn img').removeClass('over');
		} else {
			config.aboutus_hide = true;
			$('#header').animate({'top': - config.aboutus_height}, 1000);
		}
	});
	
	// click para las tapas y los vinos
	$('.element').click( function (event) {
		event.preventDefault();
		
		Besana.post = {
			ID: String($(event.target).attr('tabindex')),
			link: String($(event.target).attr('href'))
		};
		
		$.ajax({
			url: Besana.site_url + '/callback',
			type: 'POST',
			dataType: 'json',
			data: 'post_id=' + Besana.post.ID,
			success: function (data) {
				Besana.post.title = data.title;
				Besana.post.content = data.content;
				Besana.post.image_path = data.image_path;
				
				var cropratio = '1:' + (config.height / config.width);
				var html = String('<div id="fullscreenphoto"><div id="phototxt"><h3>' + Besana.post.title + '</h3>' + Besana.post.content + '</div><div id="closephoto"><a href="">cerrar x</a></div><img src="wp-content/uploads/image.php/besana_' + Besana.post.ID + '.jpg?width=' + config.width + '&amp;cropratio=' + cropratio + '&amp;image=' + Besana.post.image_path + '" /></div>');
				$('body').append(html);
				$('#fullscreenphoto').css('left', config.width).height(config.height).width(config.width);
				$('#fullscreenphoto').animate({'left': 0}, 1000);
			}
		});
		
	});
	
	$('#closephoto a').live('click', function (event) {
		event.preventDefault();
		$('#fullscreenphoto').animate({'left': - config.width}, 1000, function () {
			$(this).remove();
		});
	});
	
});