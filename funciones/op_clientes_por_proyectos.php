<?php
	require("../conexion/conexion.php");

	$pro = $_POST['id_proyecto'];

	$pro = mysqli_real_escape_string($conexion2, $pro);

	$query = "SELECT maestro_clientes.id_cliente, CONCAT_WS(' ', cl_nombre, cl_apellido) AS nombre_c FROM maestro_clientes
			  INNER JOIN maestro_ventas ON maestro_ventas.id_cliente = maestro_clientes.id_cliente
			  WHERE id_proyecto = $pro GROUP BY maestro_clientes.id_cliente,
																					maestro_clientes.cl_nombre,
																					maestro_clientes.cl_apellido";


	$op = '<option value="">Seleccionar</option>';
	$r = mysqli_query($conexion2, $query);
	while($fila = mysqli_fetch_array($r))
	{

		$op .= "<option value=".$fila['id_cliente'].">".$fila['nombre_c']."</option>";
	}

	echo $op;
?>
