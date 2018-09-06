<?php
	require("../conexion/conexion.php"); 

	$gi = $_POST['id_grupo_inmueble'];

	$in = mysqli_real_escape_string($conexion2, $gi);

	$query = "SELECT mi.id_inmueble, mi.mi_nombre FROM maestro_inmuebles mi 
		  WHERE mi.id_grupo_inmuebles = $in";

			
	

	$op = '';
	$r = mysqli_query($conexion2, $query);
	while($fila = mysqli_fetch_array($r, MYSQLI_ASSOC))
	{
	
		$op .= "<option value=".$fila['id_inmueble'].">".$fila['mi_nombre']."</option>";
	}

	echo $op;
?>



