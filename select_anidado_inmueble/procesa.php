<?php require("../conexion/conexion.php");

if(isset($_POST["idmarca"])){

		$opciones = '<option value="0"> Elige un proyecto</option>';

		$strConsulta = "select id_cuenta_bancaria, cta_numero_cuenta from cuentas_bancarias where cta_id_banco = '".$_POST["idmarca"]."' and cta_estado = 1" ;
		$result = $conexion2->query($strConsulta);

		while( $fila = $result->fetch_array()){
			$opciones.='<option value="'.$fila["id_cuenta_bancaria"].'">'.$fila["cta_numero_cuenta"].'</option>';
		}

		echo $opciones;

	}?>
