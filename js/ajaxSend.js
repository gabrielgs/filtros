$(function(){
	var $filtro = '';
		$seleccion = '';
		filtroArr = new Array();

	function filtro(campo, condicion){
		this.campo = campo;
		this.condicion = condicion;
	}

	$('.filtro').on('input', function(){
	
		var $mensaje = $(this).val();
			$padre = $(this).parent();
			$posicionPadre = $('td').index($padre);
			$campo = $('th').eq($posicionPadre).text();
			bandera = false;
			contador = 0;
			/*debugger;
*/
		var myFiltro = new filtro($campo, $mensaje)

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
			filtroArr[contador].condicion = $mensaje
		}else{
			filtroArr.push(myFiltro);
		}

		var filtroJSON = JSON.stringify(filtroArr);
		$('#enviarFiltro').val(filtroJSON);

			/*alert(filtroJSON); */

		$filtro = $mensaje;
		$seleccion = $campo;

		$.ajax({
			cache:false,
			type:"POST",
			dataType: "json",
			url: "includes/filtrar.php",
			data: {dataSend:filtroJSON},
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