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

function formatDateDB (input) {
  var datePart = input.match(/\d+/g),
  year = datePart[2],
  month = datePart[1], day = datePart[0];

  return year+'-'+month+'-'+day+' 00:00:00';
}

$(document).ready(function () {
	
	//Close button:
	$(".close").click(
	  function () {
	  	$(this).parent().fadeTo(400, 0, function () { // Links with the class "close" will close parent
	  		$(this).slideUp(400);
	  	});
	  	return false;
	  }
	);
});
