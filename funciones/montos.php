<?php
	require("../conexion/conexion.php"); 

	$id = $_POST['id_partida'];

	$id = mysqli_real_escape_string($conexion2, $id);

	$query = "SELECT p_monto, p_distribuido, p_reservado, p_ejecutado FROM maestro_partidas WHERE id = $id"; 
	$r = mysqli_query($conexion2, $query);	
	$fila = mysqli_fetch_array($r, MYSQLI_ASSOC);

	$total = $fila['p_monto'] - $fila['p_reservado'];

	echo $total;

?>



