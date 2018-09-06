<?php
sleep(1);
include('../conexion/conexion.php');
if($_REQUEST)
{
	$email 	= $_REQUEST['email'];
	$query = "select count(id_usuario) as contar from usuarios where usua_usuario = '".$email."'";
	$results = mysqli_query($conexion2, $query) or die('ok');

		while($lista_contar = mysqli_fetch_array($results)){

				$resultado_conteo = $lista_contar['contar'];

		}
	
	if($resultado_conteo > 0) // not available
	{
		echo '<div id="Error" style="z-index: 99;">Usuario ya existente</div>';
	}
	else
	{
		echo '<div id="Success" style="z-index: 99;">Disponible</div>';
	}
	
}?>