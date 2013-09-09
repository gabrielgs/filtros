
<?php  
	include('includes/dataBase.php');
?>


<!doctype html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Filtros</title>
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-combined.no-icons.min.css" />
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/3.1.1/css/font-awesome.css" />
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/vendor/datepicker.css">

</head>
<body>
	<h4 id="title">slips 3</h4>
	<table border="1px" id="contenido" class="table table-striped table-bordered table-hover table-condensed">
		<?php echo $contenido; ?>
	</table>

	<form id="filtros" action="includes/exportar.php" method="POST">
		<input type="hidden" id="enviarNombre" name="nombreReporte" value="">
		<input id="enviarFiltro" type="hidden" name="dataSend" value="">
		<input id="send" type="submit" value="Exportar"/>
	</form>

	<button id="boton">Enviar</button>

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>
	<script src="js/vendor/bootstrap-datepicker.js"></script>
	<script src="js/vendor/locales/bootstrap-datepicker.es.js"></script>
	<script src="js/ajaxSend.js"></script>
</body>
</html>