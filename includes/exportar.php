<?php  

	$host= "localhost";
	$user = "summax";
	$pass = "summax";
	$db = "summit";

	$nombre = $_POST['nombreReporte'];

	$nombreVista = str_replace(" ", "", $nombre);

	$mysqli = new mysqli($host, $user, $pass, $db);

	$mysqli -> query("SET NAMES 'utf8'");

	$contenido = '';

	$myFiltro = $_POST['dataSend'];

	$filtros = json_decode(stripslashes($myFiltro));

	$longitud = count($filtros);

	$sql = "SELECT * FROM $nombreVista
			WHERE `".$filtros[0]->campo."` LIKE '%".$filtros[0]->condicion."%' ";

	for ($i=1; $i < $longitud; $i++) { 
		$sql .= "AND `".$filtros[$i]->campo."` LIKE '%".$filtros[$i]->condicion."%' ";
	}	


	$query = $mysqli -> query($sql);


	// header("Cache-Control: no-stor,no-cache,must-revalidate");
 //    header("Cache-Control: post-check=0,pre-check=0", false);
 //    header("Cache-control: private");
 //    header("Content-type: application/vnd.ms-excel; name='excel'");
 //    header("Content-Disposition: attachment; filename=Reporte.xls");
 //    header("Content-Transfer-Encoding: binary");
 //    header("Pragma: no-cache");
 //    header("Expires: 0");
	
	$tabla = "
			<h3>$nombre</h3>
			<table border='1px'> 
				<thead>";

	while ($nameinfo = $query->fetch_field()) {
	 	$tabla .= "<th>".utf8_decode($nameinfo -> name)."</th>"; 
	 } 

	$tabla .= " </thead>
			    <tbody>
	";

	while ( $listado = $query -> fetch_row() ) {
		$count = count($listado);

		$tabla .= "<tr>";

		for ($i=0; $i < $count ; $i++) { 
			$tabla .= "<td>".utf8_decode($listado[$i])."</td>";
		}

		$tabla .= "</tr>";
	}

	$tabla .= "  </tbody>"; 

	$tabla .= "</table>";

	echo $tabla;

?>