<?php
	require("../conexion/conexion.php"); 

	$id = $_POST['id_proyecto'];

	$id = mysqli_real_escape_string($conexion2, $id);

	$query = "SELECT id_grupo_inmuebles, gi_nombre_grupo_inmueble FROM grupo_inmuebles WHERE gi_id_proyecto = $id";

	$op = '';
	$r = mysqli_query($conexion2, $query);
	while($fila = mysqli_fetch_array($r, MYSQLI_ASSOC))
	{
	
		$op .= "<option value=".$fila['id_grupo_inmuebles'].">".$fila['gi_nombre_grupo_inmueble']."</option>";
	}

	echo $op;
?>



