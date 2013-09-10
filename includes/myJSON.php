<?php  
	/*$myJSON = '[{"campo":"plantilla", "condicion":"asadasd"}, {"campo":"plantilla", "condicion":"asadasd"}, {"campo":"referencia", "condicion":"GMX-WER"}]';

	$filtros = json_decode($myJSON);

	 echo var_dump($filtros);

	 $lon = count($filtros);

	 $sql = "SELECT * FROM slips
	 		WHERE `".$filtros[0]->campo."` LIKE '%".$filtros[0]->condicion."%' ";

	 for ($i=1; $i < $lon ; $i++) { 
	 	$sql .= "AND `".$filtros[$i]->campo."` LIKE '%".$filtros[$i]->condicion."%' ";
	 }

	echo "<br>".$sql."<br>";
	foreach ($filtros as $key){
		echo $lon;
		echo $key->campo.' ';
		echo $key->condicion.'<br>';
	}*/

	$fecha = "10-02-2013";
	list($d, $m, $y) = explode("-", $fecha);

	$fecha2 = $y."-".$m."-".$d;
	echo $fecha2;

?>