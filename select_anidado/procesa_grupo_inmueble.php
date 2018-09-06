<?php require("../conexion/conexion.php"); ?>
<?php
if(isset($_POST["idmarca"]))
	{
		$opciones = '<option value="0"> Elige una cuenta</option>';

		$strConsulta = "select id_proyecto, proy_nombre_proyecto from maestro_proyectos where id_empresa = '".$_POST["idmarca"]."' and proy_estado = 1" ;
		$result = $conexion2->query($strConsulta);
		

		while( $fila = $result->fetch_array() )
		{
			$opciones.='<option value="'.$fila["id_proyecto"].'">'.$fila["proy_nombre_proyecto"].'</option>';
		}

		echo $opciones;
	
	}/*elseif(isset($_SESSION['session_chq'])){

		$opciones = '<option value="0"> Elige una cuenta</option>';

		$strConsulta = "select id_cuenta_bancaria, cta_numero_cuenta from cuentas_bancarias where cta_id_banco = ".$_SESSION['session_chq']['id_cuenta'];
		$result = $conexion2->query($strConsulta);
		

		while( $fila = $result->fetch_array())
		{ ?>
			<option value="<?php echo $fila['id_cuenta_bancaria']; ?>" <?php if(isset( $_SESSION['session_chq'])){ if($_SESSION['session_chq']['id_cuenta'] == $fila['id_cuenta_bancaria']){ echo 'selected';}} ?> ><?php echo $fila['cta_numero_cuenta']; ?></option>
		<?php }

	} */
?>