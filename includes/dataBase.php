<?php
	function isFecha($campo){
		list($y, $m, $d) = explode("-", $campo);

		if (is_numeric($d) && is_numeric($m) && is_numeric($y)) {
			$date = checkdate($m, $d, $y);

			if ($date == true) {
				$fecha = $d.'-'.$m.'-'.$y;
				return $fecha;
			}else{
				return $campo;
			}
		}else{
			return $campo;
		}
	}

	$host= "localhost";
	$user = "summax";
	$pass = "summax";
	$db = "summit";

	$nombre = $_POST['nombre'];

	$nombreVista = str_replace(" ", "", $nombre);

	$contenido = '';

	$mysqli = new mysqli($host, $user, $pass, $db);

	$mysqli -> query("SET NAMES 'utf8'");

	$sql = "SELECT * FROM slips3";

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
			$contenido .= "<td>".isFecha($listado[$i])."</td>";
		}

		$contenido .= "</tr>";
	}

	$contenido .= "</tbody>";

?>