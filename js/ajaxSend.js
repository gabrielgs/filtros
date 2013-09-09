$(function(){
	// Arreglo donde se guarda los datos a enviar
	var filtroArr = [];

		// Funcion para comprobar si la cadena es una fecha
		isFecha = function(cadena){

			// asignamos a una variable numero el valor de la cadena sin el signo "-"
			numeros = cadena.split("-");

			// separamos los numeros en dia, mes, año
			dia = numeros[2];
			mes = (numeros[1]-1);
			ano = numeros[0];

			// Generamos una nueva fecha
			fecha = new Date(ano, mes, dia);

			// Obtenemos los valores de dia, mes, y el año completo para poder compararlos.
			fechaDia = fecha.getDate();
			fechaMes = fecha.getMonth();
			fechaAno = fecha.getFullYear();

			// Comparamos nuestros valores de nuestra nueva fecha con los primero
			// Si todos los valores coinciden la funcion nos regresara true.
			if (fechaDia == dia && fechaMes == mes && fechaAno == ano) {
				return true;
			}
		};

		isNumeric = function(cadena){
			if(!isNaN(cadena)){
				return true;
			}
		};

	// Constructor que me permite crear nuevos objetos filtro que contienen los datos a enviar
	function filtro(campo, condicion, tipo){
		this.campo = campo;
		this.condicion = condicion;
		this.tipo = tipo;
	}


	/*Si pasamos el mouse sobre el input para filtrar*/
    $('.filtro').mouseover(function(){
		// variable que contiene el tr padre del input sobre el cual escribimos
		var $columna = $(this).closest('tr');

			// varable que contiene e padre directo del input
			$padre = $(this).parent();
			
			// La posicion del elemento padre del input
			$posicionPadre = $('td').index($padre);

			// La columna que esta debajo del elemento 
			$columnaSiguiente = $columna.siblings('tr:eq(0)');

			// El texto que tiene la columna que nos servira para comprobar si es una fecha.
			valorColumnaSig = $columnaSiguiente.children('td:eq('+$posicionPadre+')').text();
			existElem = $(this).siblings('.rango').length;

		// debugger;

		/*Si la función isFecha() nos devuelve verdadero, es decir, si es una fecha*/
		if( isFecha(valorColumnaSig) ){

			// Haremos que el input sobre el cual se escribe se convierta en un datepicker
			// lo que hara que aparezca un calendario.
			$(this).datepicker({
				format: "yyyy-mm-dd",
				language: "es",
				autoclose: true,
			});

			// agregamos el atributo id = fecha para diferenciarlo de los demás
			$(this).attr('id', 'fecha');

			//Comprobamos que el elemento con clase rango no exista para crearlo. 
			if(!existElem){
				$padre.append('<input class="rango" type="button" value="Rango"/>');

			}
		}

	});

    $('tr:eq(1) td').on('click', '.rango', function(){
		var html = '<div class="filtro input-daterange" id="datepicker"><input type="text" class="input-small start" name="start" /><span class="add-on">a</span><input id="end" type="text" class="input-small" name="end" /></div>';

			$padre = $(this).parent();

		$(this).siblings('#fecha').css('display', 'none');
		$($padre).append(html);

		$('.input-daterange').datepicker({
			format: "yyyy-mm-dd",
			language: "es",
			autoclose: true,
		});

		$(this).remove();
		// debugger;
		$('.input-daterange').css('width', '250');
		$('.input-daterange .add-on').css('margin', '0');
    });


    $('tr:eq(1) td').on('mouseover', '.input-daterange', function(){
		var $padre = $(this).parent();
			// debugger;
			existElem = $(this).siblings('.normal').length;

		if(!existElem){
			$padre.append('<input class="normal" type="button" value="Normal"/>');

		}
    });


    /* Para rangos de fecha*/
    $('tr:eq(1) td').on('change', '#end', function(){
    	debugger;
		var $fecha1 = $(this).siblings('.start').val();
			$fecha2 = $(this).val();
			$condicion = $fecha1+" - "+$fecha2;
			// variable que contiene el tr padre del input sobre el cual escribimos
			$columna = $(this).closest('tr');
			$padre = $(this).closest('td');
			$posicionPadre = $('td').index($padre);
			$campo = $('th').eq($posicionPadre).text();
			// La columna que esta debajo del elemento 
			$columnaSiguiente = $columna.siblings('tr:eq(0)');
			// El texto que tiene la columna que nos servira para comprobar si es una fecha.
			valorColumnaSig = $columnaSiguiente.children('td:eq('+$posicionPadre+')').text();
			$nombreReporte = $('#title').text();
			tipoDato = '';
			bandera = false;
			contador = 0;

		if( isFecha(valorColumnaSig) ){
			tipoDato = 'fecha';
		}else if( isNumeric(valorColumnaSig) ){
			tipoDato = 'numero';
		}else{
			tipoDato = 'texto';
		}


		var myFiltro = new filtro($campo, $condicion, tipoDato);

		if (filtroArr.length > 0) {
			for(var i in filtroArr){
				if(filtroArr[i].campo === $campo){
					bandera = true;
					if(bandera === true){
						contador = i;
					}
				}
			}
		}

		if (bandera === true) {
			filtroArr[contador].condicion = $condicion;
		}else{
			filtroArr.push(myFiltro);
		}

		var filtroJSON = JSON.stringify(filtroArr);
		$('#enviarFiltro').val(filtroJSON);
		$('#enviarNombre').val($nombreReporte);
    });

    $('tr:eq(1) td').on('click', '.normal', function(){
		var html = '<input class="filtro" type="text" id="fecha">';
			// debugger;
			$padre = $(this).parent();

		$(this).siblings('.input-daterange').css('display', 'none');
		$(this).siblings('#fecha').css('display', 'block');

		$('#fecha').datepicker({
			format: "yyyy-mm-dd",
			language: "es",
			autoclose: true,
		});

		$(this).remove();
	
    });

	$('tr:eq(1) td').mouseleave(function(){
		$(this).find('.rango').remove();
		$(this).find('.normal').remove();
	});



	$('.filtro').on('change', function(){
	
		var $condicion = $(this).val();
			// variable que contiene el tr padre del input sobre el cual escribimos
			$columna = $(this).closest('tr');
			$padre = $(this).parent();
			$posicionPadre = $('td').index($padre);
			$campo = $('th').eq($posicionPadre).text();
			// La columna que esta debajo del elemento 
			$columnaSiguiente = $columna.siblings('tr:eq(0)');
			// El texto que tiene la columna que nos servira para comprobar si es una fecha.
			valorColumnaSig = $columnaSiguiente.children('td:eq('+$posicionPadre+')').text();
			$nombreReporte = $('#title').text();
			tipoDato = '';
			bandera = false;
			contador = 0;

		// debugger;
		if( isFecha(valorColumnaSig) ){
			tipoDato = 'fecha';
		}else if( isNumeric(valorColumnaSig) ){
			tipoDato = 'numero';
		}else{
			tipoDato = 'texto';
		}

		var myFiltro = new filtro($campo, $condicion, tipoDato);

		if (filtroArr.length > 0) {
			for(var i in filtroArr){
				if(filtroArr[i].campo === $campo){
					bandera = true;
					if(bandera === true){
						contador = i;
					}
				}
			}
		}

		if (bandera === true) {
			filtroArr[contador].condicion = $condicion;
		}else{
			filtroArr.push(myFiltro);
		}

		var filtroJSON = JSON.stringify(filtroArr);
		$('#enviarFiltro').val(filtroJSON);
		$('#enviarNombre').val($nombreReporte);

		$.ajax({
			cache:false,
			type:"POST",
			dataType: "json",
			url: "includes/filtrar.php",
			data: {dataSend:filtroJSON, nombreReporte:$nombreReporte},
			success: function(response){
				$('#contenido tbody tr:eq(0)').siblings().remove();
				$(response).appendTo('#contenido tbody');

			}
		});
	});

	$('#boton').on('click', function(){

		$.ajax({
			cache:false,
			type:"POST",
			dataType:"json",
			url:"includes/exportar.php",
			data:{campo:$seleccion, valor:$filtro},
			success: function(response){
				alert(response);
			}
		});
	});

	/*$('#send').on('click', function(e){
		e.preventDefault();

		debugger;
		var filtroJSON = JSON.stringify(filtroArr);

		console.log(filtroJSON);

		$('#filtros').submit();

		$.ajax({
			cache:false,
			type:"POST",
			dataType: "json",
			url: "includes/exportar.php",
			data:{dataSend:filtroJSON},
			success:function(response){
				alert('exitooooo');
			}
		});
	});*/
});