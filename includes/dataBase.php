<?php  
	$host= "localhost";
	$user = "summax";
	$pass = "summax";
	$db = "summit";

	$contenido = '';

	$mysqli = new mysqli($host, $user, $pass, $db);

	$mysqli -> query("SET NAMES 'utf8'");

	$sql = "SELECT * FROM filtros1";

	$query = $mysqli -> query($sql);

	$contador = $query->field_count;

	$contenido = "<thead>";

	while ($nameinfo = $query -> fetch_field()) {


		$contenido .= "<th>".$nameinfo -> name."</th>";


	}

	$contenido .= "</thead>
				   <tbody>
	";

	$contenido .= "<tr>";
	for ($j=0; $j < $contador ; $j++) { 
		$contenido .= "<td><input class='filtro' type='text' /></td>";
	}
	$contenido .= "</tr>";

	while ( $listado = $query -> fetch_row() ) {

		$contenido .= "<tr>";

		$count = count($listado);

		for ($i=0; $i < $count; $i++) { 
			$contenido .= "<td>".$listado[$i]."</td>";
		}

		$contenido .= "</tr>";
	}

	$contenido .= "</tbody>";

?>