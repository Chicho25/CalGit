<?php	require("conexion/conexion.php");

		$usuarioIng=$_POST['username'];
		$passIng=$_POST['password'];

		session_start();


		$sql_comprobar_usuario = mysqli_query($conexion2, "select count(id_usuario) as contar
														      ,id_usuario
														      ,usua_usuario
														      ,usua_pass
														      ,usua_imagen_usuario
														      ,usua_fecha_registro
														      ,usua_stat
														      ,usua_nombre
														      ,usua_apellido
															from
															   usuarios
															where
															   usua_usuario = '".$usuarioIng."'
															   and
															   usua_pass = '".$passIng."'
															   and
															   usua_stat = 1
															group by
															   id_usuario
														      ,usua_usuario
														      ,usua_pass
														      ,usua_imagen_usuario
														      ,usua_fecha_registro
														      ,usua_stat
														      ,usua_nombre
														      ,usua_apellido") or die("Error " . mysqli_error($sql_comprobar_usuario));


								while($lista_usuario = mysqli_fetch_array($sql_comprobar_usuario)) {

										$contar = $lista_usuario['contar'];
										$id_user = $lista_usuario['id_usuario'];
										$nombre = $lista_usuario['usua_nombre'];
										$apellido = $lista_usuario['usua_apellido'];
										$foto = $lista_usuario['usua_imagen_usuario'];
										$email = $lista_usuario['usua_usuario'];


								}


	if(isset($contar)){
		if($contar == 1){

			$session_gc = array('usua_id'=>$id_user,
						   	           'usua_nombre'=>$nombre,
							             'usua_apellido'=>$apellido,
							             'usua_imagen_usuario' =>$foto,
							             'usua_usuario' =>$email);

			$_SESSION['session_gc']=$session_gc;

				require("funciones/funciones_auditorias.php");
				$lugar_mapa = 31;
			    $dispositivo_acceso = obtener_dispositivo();
			    insertar_log_seguimiento($conexion2, ObtenerIP(), $dispositivo_acceso, $lugar_mapa, $_SESSION['session_gc']['usua_id']); ?>

				<script type="text/javascript">
					window.location="gc_principal.php";
				</script>

			<?php }else{ ?>

				<script type="text/javascript">
					window.location="salir.php";
				</script>

			<?php }}else{ ?>

				<script type="text/javascript">
					window.location="salir.php";
				</script>

			<?php  } ?>
