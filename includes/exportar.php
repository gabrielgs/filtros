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

	function getSQL($filtros, $nombreVista){

		$longitud = count($filtros);
		switch ($filtros[0]->tipo) {
			case 'fecha':
				
				$buscar = strpos($filtros[0]->condicion, " - ");

				if ($buscar !== FALSE) {
					list($cadena1, $cadena2) = explode(" - ", $filtros[0]->condicion);
					list($d1, $m1, $y1 ) = explode("-", $cadena1);
					list($d2, $m2, $y2 ) = explode("-", $cadena2);

					$fecha1 = $y1."-".$m1."-".$d1;
					$fecha2 = $y2."-".$m2."-".$d2;

					
					$sql = "SELECT * FROM $nombreVista
							WHERE `".$filtros[0]->campo."` BETWEEN '".$fecha1."' AND '".$fecha2."'
						";
				}else{
					$cadena = $filtros[0]->condicion;
					list($d, $m, $y) = explode("-", $cadena);

					if ($cadena == "") {
						$fecha = $filtros[0]->condicion;
					}else{
						$fecha = $y."-".$m."-".$d;
					}

					$sql = "SELECT * FROM $nombreVista
							WHERE `".$filtros[0]->campo."` LIKE '%".$fecha."%' 
						";
				}
				break;

			case 'numero':

				$buscarMayor = strpos($filtros[0]->condicion, ">");
				$buscarMenor = strpos($filtros[0]->condicion, "<");
				$buscarRango = strpos($filtros[0]->condicion, "-");

				if ($buscarMayor !== FALSE) {
					$sql = "SELECT * FROM $nombreVista
							WHERE `".$filtros[0]->campo."` ".$filtros[0]->condicion."
						";
				}elseif ($buscarMenor !== FALSE) {
					$sql = "SELECT * FROM $nombreVista
							WHERE `".$filtros[0]->campo."` ".$filtros[0]->condicion."
						";
				}elseif ($buscarRango !== FALSE) {
					list($numero1, $numero2) = explode("-", $filtros[0]->condicion);

					$sql = "SELECT * FROM $nombreVista
							WHERE `".$filtros[0]->campo."` BETWEEN '".$numero1."' AND '".$numero2."'";
				}else{
					$sql = "SELECT * FROM $nombreVista
						WHERE `".$filtros[0]->campo."` LIKE '%".$filtros[0]->condicion."%' 
				";
				}

				break;
			
			default:
				$sql = "SELECT * FROM $nombreVista
						WHERE `".$filtros[0]->campo."` LIKE '%".$filtros[0]->condicion."%' 
				";
				break;
		}
			

		for ($i=1; $i < $longitud; $i++) {

			switch ($filtros[$i]->tipo) {
				case 'fecha':
					
					$buscar = strpos($filtros[$i]->condicion, " - ");

					if ($buscar !== FALSE) {
						list($cadena1, $cadena2) = explode(" - ", $filtros[$i]->condicion);
						list($d1, $m1, $y1 ) = explode("-", $cadena1);
						list($d2, $m2, $y2 ) = explode("-", $cadena2);

						$fecha1 = $y1."-".$m1."-".$d1;
						$fecha2 = $y2."-".$m2."-".$d2;

						$sql .= "AND `".$filtros[$i]->campo."` BETWEEN '".$fecha1."' AND '".$fecha2."'
							";
					}else{
						$cadena = $filtros[$i]->condicion;
						list($d, $m, $y) = explode("-", $cadena);

						if ($cadena == "") {
							$fecha = $filtros[$i]->condicion;
						}else{
							$fecha = $y."-".$m."-".$d;
						}

						$sql .= "AND `".$filtros[$i]->campo."` LIKE '%".$fecha."%' 
							";
					}
					break;

				case 'numero':

					$buscarMayor = strpos($filtros[$i]->condicion, ">");
					$buscarMenor = strpos($filtros[$i]->condicion, "<");
					$buscarRango = strpos($filtros[$i]->condicion, "-");

					if ($buscarMayor !== FALSE) {
						$sql .= "AND `".$filtros[$i]->campo."` ".$filtros[$i]->condicion."
							";
					}elseif ($buscarMenor !== FALSE) {
						$sql .= "AND `".$filtros[$i]->campo."` ".$filtros[$i]->condicion."
							";
					}elseif ($buscarRango !== FALSE) {
						list($numero1, $numero2) = explode("-", $filtros[$i]->condicion);

						$sql .= "AND `".$filtros[$i]->campo."` BETWEEN '".$numero1."' AND '".$numero2."'";
					}else{
						$sql .= "AND `".$filtros[$i]->campo."` LIKE '%".$filtros[$i]->condicion."%' 
					";
					}

					break;
				
				default:
					$sql .= "AND `".$filtros[$i]->campo."` LIKE '%".$filtros[$i]->condicion."%' ";
					break;
			} 
			
		}
		return $sql;
	}


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

		

	$sql = getSQL($filtros, $nombreVista);
	$query /**/= $mysqli -> query($sql);


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
			$tabla .= "<td>".utf8_decode(isFecha($listado[$i]))."</td>";
		}

		$tabla .= "</tr>";
	}

	$tabla .= "  </tbody>"; 

	$tabla .= "</table>";

	echo $tabla;

?>