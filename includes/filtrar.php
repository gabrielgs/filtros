<?php  
	$host= "localhost";
	$user = "summax";
	$pass = "summax";
	$db = "summit";

	$mysqli = new mysqli($host, $user, $pass, $db);

	$mysqli -> query("SET NAMES 'utf8'");

	$contenido = '';

	$myFiltro = $_POST['dataSend'];

	$filtros = json_decode(stripslashes($myFiltro));

	$longitud = count($filtros);

	$sql = "SELECT * FROM filtros1
			WHERE `".$filtros[0]->campo."` LIKE '%".$filtros[0]->condicion."%' ";

	for ($i=1; $i < $longitud; $i++) { 
		$sql .= "AND `".$filtros[$i]->campo."` LIKE '%".$filtros[$i]->condicion."%' ";
	}	


	$query = $mysqli -> query($sql);

	while ( $listado = $query -> fetch_row() ) {

		$contenido .= "<tr>";

		$count = count($listado);

		for ($i=0; $i < $count; $i++) { 
			$contenido .= "<td>".$listado[$i]."</td>";
		}

		$contenido .= "</tr>";
	}

	echo json_encode($contenido);
	// echo json_encode($sql);
?>