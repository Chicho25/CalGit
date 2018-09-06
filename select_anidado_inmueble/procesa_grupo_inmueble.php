<?php require("../conexion/conexion.php");

if(isset($_POST["idmarca"])){

		$opciones = '<option value="0"> Elige una cuenta</option>';

		$strConsulta = "select id_grupo_inmuebles, gi_nombre_grupo_inmueble from grupo_inmuebles where 	gi_id_proyecto = '".$_POST["idmarca"]."' and gi_status = 1" ;
		$result = $conexion2->query($strConsulta);

		while( $fila = $result->fetch_array() ){

			$opciones.='<option value="'.$fila["id_grupo_inmuebles"].'">'.$fila["gi_nombre_grupo_inmueble"].'</option>';
		}

		echo $opciones; }?>
