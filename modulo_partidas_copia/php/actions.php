<?php

if(isset($_GET["do"]) && $_GET["do"]!=""){
	include "conexion2.php";
	include "functions.php";
		$action = $_GET["do"];
		if($action=="new"){
			if(!empty($_POST)){
				$con = Db::connect();
				$name = $_POST["nombre_partida"];
				$category_id = $_POST["id"]!=""? $_POST["id"]:"NULL";
				$id_proyecto = obtener_id($category_id);
				$id_padre = obtener_id_padre($category_id);
				$monto = $_POST["monto_asignado"]!=""? $_POST["monto_asignado"]:"NULL";
				$sql = "insert into maestro_partidas(p_nombre,id_categoria,p_monto,p_status, id_proyecto, id_padre) value (\"$name\",$category_id, $monto, 1, $id_proyecto, $id_padre)";
				$con->query($sql);
				$total = $monto+$_POST['distribuido'];
				$sql_actualizar_padre = $con->query("UPDATE maestro_partidas SET p_distribuido = $total where id = '".$id_padre."'");
				/* Auditoria */
				$tipo_operacion = 1;
				$comentario = "Registro de Partida";
				$sql_auditoria = $con ->query("INSERT INTO auditoria_crear_partida(aucp_tipo_operacion,
																																					 aucp_usua_log,
																																				   aucp_comentario,
																																				   aucp_n_partida,
																																				   aucp_monto,
																																				   aucp_p_status
																																				   )VALUES(
																																					'".$tipo_operacion."',
																																					'".$_POST['user']."',
																																					'".$comentario."',
																																					'".$name."',
																																					'".$monto."',
																																					1)");

			}
			header("Location: ../../gc_partidas_copia.php");
		}elseif($action=="new_copia"){
					if(!empty($_POST)){
						$con = Db::connect();
						$name = $_POST["nombre_partida"];
						$id_proyecto = obtener_id($_POST["id"]);
						$id_padre = $_POST["id"];
						$category_id = $_POST["id"];
						$monto = $_POST["monto_asignado"]!=""? $_POST["monto_asignado"]:"NULL";
						$sql = "insert into maestro_partidas(p_nombre,
																								 id_categoria,
																								 p_monto,
																								 p_status,
																								 id_proyecto,
																								 id_padre)
																								 value
																								 (\"$name\",$category_id, $monto, 1, $id_proyecto, $id_padre)";
						$con->query($sql);
						/* Buscar el monto distrubido y actualizarlo */
						$sql_monto_distribuido = $con -> query("select p_distribuido from maestro_partidas where id = '".$id_padre."'");
						while($l=$sql_monto_distribuido->fetch_array()){
							$distribuido = $l['p_distribuido'];
						}

						$suma_distribuido = $distribuido + $monto;

						$sql_actualizar_padre = $con->query("UPDATE maestro_partidas SET p_distribuido = $suma_distribuido where id = '".$id_padre."'");

					}
					/* Auditoria */
					$tipo_operacion = 1;
					$comentario = "Registro de Partida";
					$sql_auditoria = $con ->query("INSERT INTO auditoria_crear_partida(aucp_tipo_operacion,
																																						 aucp_usua_log,
																																					   aucp_comentario,
																																					   aucp_n_partida,
																																					   aucp_monto,
																																					   aucp_p_status
																																					   )VALUES(
																																						'".$tipo_operacion."',
																																						'".$_POST['user']."',
																																						'".$comentario."',
																																						'".$name."',
																																						'".$monto."',
																																						1)");
					header("Location: ../../gc_partidas_copia.php");
				}else if($action=="delete"){
			$con = Db::connect();

			$sql_monto_distribuido = $con -> query("select p_distribuido from maestro_partidas where id = '".$_GET['id_padre']."'");
			while($l=$sql_monto_distribuido->fetch_array()){
				$distribuido = $l['p_distribuido'];
			}

			$resta_distribuido = $distribuido - $_GET['monto'];

			$sql_actualizar_padre = $con->query("UPDATE maestro_partidas SET p_distribuido = $resta_distribuido where id = '".$_GET['id_padre']."'");

			$sql = "delete from maestro_partidas where id=$_GET[id]";
			$con->query($sql);

			header("Location: ../../gc_partidas_copia.php");
		}else if($action=="update"){
			if(!empty($_POST)){
				$con = Db::connect();
				$id = $_POST["id"];
				$name = $_POST["nombre_partida"];
				$monto = $_POST["monto_asignado"];
				$category_id = $_POST["category_id"]!=""? $_POST["category_id"]:"NULL";

				$sql_monto_distribuido = $con -> query("select
																								p_distribuido
																								from
																								maestro_partidas
																								where
																								id = '".$_POST['id_padre']."'");
				while($l=$sql_monto_distribuido->fetch_array()){
					$distribuido = $l['p_distribuido'];
				}

				$monto_actualizar = $_POST['monto_asignado'] - $_POST['monto_actual'];
				$suma_total = $distribuido + $monto_actualizar;

				$sql_actualizar_padre = $con->query("UPDATE maestro_partidas SET p_distribuido = $suma_total where id = '".$_POST['id_padre']."'");

				$sql = "update maestro_partidas set p_nombre=\"$name\", p_monto=$monto where id=$id";
				$con->query($sql);

				$tipo_operacion = 2;
				$comentario = "Actualizacion de Partida";
				$sql_auditoria = $con ->query("INSERT INTO auditoria_crear_partida(aucp_tipo_operacion,
																																					 aucp_usua_log,
																																					 aucp_comentario,
																																					 aucp_n_partida,
																																					 aucp_monto,
																																					 aucp_p_status
																																					 )VALUES(
																																					'".$tipo_operacion."',
																																					'".$_POST['user']."',
																																					'".$comentario."',
																																					'".$name."',
																																					'".$monto."',
																																					1)");

			}

			header("Location: ../../gc_partidas_copia.php");
		}

}


?>
