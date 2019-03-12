<?php
/**
* @author pedro arrieta
*
**/
?>
<?php  /*include_once("conexion/conexion.php");*/ ?> <?php /* modificacion de 08-06-2017 */ ?>

<?php	function validar_email($conexion, $email) {

		$sql_validar_email = mysqli_query($conexion, "select count(*) as contar from usuarios where usua_usuario = '".$email."'");
			while($lista_validar_email = mysqli_fetch_array($sql_validar_email)){

					$contar = $lista_validar_email['contar'];

			}

		 return $contar;

	}?>

<?php 	function usuario_restablecer_pass($conexion, $email){


		if(is_numeric($email)){

		$sql_empleados_loguin = mysqli_query($conexion, "select
														 id_usuario
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
														id_usuario = '".$email."'");

		}else{

		$sql_empleados_loguin = mysqli_query($conexion, "select
														 id_usuario
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
														 usua_usuario = '".$email."'");
			}

				return $sql_empleados_loguin;

	} ?>

<?php 	function envio_email($conexion, $pass, $email, $nombre, $apellido, $asunto, $directorio, $id_usuario){

			$msg = null;
			$asunto =$asunto;
			if($directorio == 1){

			$mensaje = 'Su nueva password es: "'.$pass.'" ingrese nuevamente a <a href="http://198.211.116.113/grupo_calpe_mysql/src/gc_log.php">Grupo Calpes</a>';

			}else{
			$mensaje = '<a href="http://198.211.116.113/grupo_calpe_mysql/src/'.$directorio.'?id_usuario='.$id_usuario.'">Recuperar password</a>';}

			    require_once 'phpmailer/PHPMailerAutoload.php';
			    require "phpmailer/class.phpmailer.php";


			          $mail = new PHPMailer;

					  //indico a la clase que use SMTP
			          $mail->IsSMTP();

			          //permite modo debug para ver mensajes de las cosas que van ocurriendo
			          //$mail->SMTPDebug = 2;

					  //Debo de hacer autenticación SMTP
			          $mail->SMTPAuth = true;
			          $mail->SMTPSecure = "ssl";

					  //indico el servidor de Gmail para SMTP
			          $mail->Host = "staging.grupocalpe.com";

					  //indico el puerto que usa Gmail
			          $mail->Port = 587;

					  //indico un usuario / clave de un usuario de gmail
			          $mail->Username = "calpe@staging.grupocalpe.com";
			          $mail->Password = "calpe147";

			          $mail->From = "calpe@staging.grupocalpe.com";

			          $mail->FromName = "Grupo Calpe";

			          $mail->Subject = $asunto;

			          $mail->addAddress($email, $nombre);

			          $mail->MsgHTML($mensaje);

			          if($mail->Send())
			        {
			    $msg= "El mensaje ha sido enviado con exito a $email";
			    }
			        else
			        {
			    $msg = "Lo siento, ha habido un error al enviar el mensaje a $email";
			    }

			    return $msg;

	} ?>

<?php 	function restablecer_password($conexion, $pass, $id_usuario){

		$sql_update_pass = mysqli_query($conexion, "update usuarios set usua_pass = '".$pass."' where id_usuario = '".$id_usuario."'");

		if($sql_update_pass){

			$mail_enviar_confirmacion = true;

			return $mail_enviar_confirmacion;
		}

	} ?>

<?php 	function todos_usuarios($conexion){

		$sql_todos_usuarios = mysqli_query($conexion, "select
															ro.id_roll,
															ro.roll_nombre,
															us.usua_usuario,
															us.usua_nombre,
															us.usua_apellido,
															us.usua_stat,
															us.usua_imagen_usuario,
															us.id_usuario,
															us.usua_fecha_registro,
															us.usua_pass
														from
															accesos ac inner join usuarios us on ac.id_usuario_acceso = us.id_usuario
																	   inner join rolles ro on ac.id_roll_acceso = ro.id_roll
														group by
															ro.id_roll,
															ro.roll_nombre,
															us.usua_usuario,
															us.usua_nombre,
															us.usua_apellido,
															us.usua_stat,
															us.usua_imagen_usuario,
															us.id_usuario,
															us.usua_fecha_registro,
															us.usua_pass");

		return $sql_todos_usuarios;

		} ?>

<?php 	function permisos($conexion, $id_usuario){

		$sql_permisos = mysqli_query($conexion, "select * from accesos where id_usuario_acceso = '".$id_usuario."' and stat = 1");

		return $sql_permisos;
	} ?>

<?php 	function permisos_accesos($conexion, $id_usuario, $modulo, $roll){

		$sql_permisos_accesos_modulos = mysqli_query($conexion, "select id_modulo_acceso from accesos where id_usuario_acceso = '".$id_usuario."' and stat = 1 and id_modulo_acceso = '".$modulo."' and id_roll_acceso = '".$roll."'");

		while($lista_accesos_modulos = mysqli_fetch_array($sql_permisos_accesos_modulos)){

				$modulo_permitido = $lista_accesos_modulos['id_modulo_acceso'];
		}

		if(isset($modulo_permitido)){

			return $modulo_permitido;

		}

	} ?>

<?php 	function crear_usuario_eccesos($conexion){

		$sql_crear_usuario_accesos = mysqli_query($conexion, "select * from modulos_app where stat = 1 and id_modulo not in(1, 6, 7)");

		return $sql_crear_usuario_accesos;

	}?>

<?php 	function listado_roll($conexion){

		$sql_listado_roll = mysqli_query($conexion, "select * from rolles where stat = 1");

		return $sql_listado_roll;

	} ?>

<?php	function redim($ruta1,$ruta2,$ancho,$alto){

				# se obtene la dimension y tipo de imagen
				$datos=getimagesize($ruta1);

				$ancho_orig = $datos[0]; # Anchura de la imagen original
				$alto_orig = $datos[1];    # Altura de la imagen original
				$tipo = $datos[2];

				if ($tipo==1){ # GIF
					if (function_exists("imagecreatefromgif"))
						$img = imagecreatefromgif($ruta1);
					else
						return false;
				}
				else if ($tipo==2){ # JPG
					if (function_exists("imagecreatefromjpeg"))
						$img = imagecreatefromjpeg($ruta1);
					else
						return false;
				}
				else if ($tipo==3){ # PNG
					if (function_exists("imagecreatefrompng"))
						$img = imagecreatefrompng($ruta1);
					else
						return false;
				}

				# Se calculan las nuevas dimensiones de la imagen
				if ($ancho_orig>$alto_orig)
					{
					$ancho_dest=$ancho;
					$alto_dest=($ancho_dest/$ancho_orig)*$alto_orig;
					}
				else
					{
					$alto_dest=$alto;
					$ancho_dest=($alto_dest/$alto_orig)*$ancho_orig;
					}

				// imagecreatetruecolor, solo estan en G.D. 2.0.1 con PHP 4.0.6+
				$img2=@imagecreatetruecolor($ancho_dest,$alto_dest) or $img2=imagecreate($ancho_dest,$alto_dest);

				// Redimensionar
				// imagecopyresampled, solo estan en G.D. 2.0.1 con PHP 4.0.6+
				@imagecopyresampled($img2,$img,0,0,0,0,$ancho_dest,$alto_dest,$ancho_orig,$alto_orig) or imagecopyresized($img2,$img,0,0,0,0,$ancho_dest,$alto_dest,$ancho_orig,$alto_orig);

				// Crear fichero nuevo, según extensión.
				if ($tipo==1) // GIF
					if (function_exists("imagegif"))
						imagegif($img2, $ruta2);
					else
						return false;

				if ($tipo==2) // JPG
					if (function_exists("imagejpeg"))
						imagejpeg($img2, $ruta2);
					else
						return false;

				if ($tipo==3)  // PNG
					if (function_exists("imagepng"))
						imagepng($img2, $ruta2);
					else
						return false;

				return true;
    } ?>

<?php	function generarCodigo($longitud) {

		$key = '';
		 $pattern = '1234567890abcdefghijklmnopqrstuvwxyz';
		 $max = strlen($pattern)-1;
		 for($i=0;$i < $longitud;$i++) $key .= $pattern{mt_rand(0,$max)};
		 return $key;
	}?>

<?php 	function todas_empresas($conexon){


		$sql_empresas = mysqli_query($conexon, "select
												id_empresa,
												empre_nombre_comercial,
												empre_razon_social,
												empre_ruc,
												empre_dv,
												empre_empresa_principal,
												empre_excenta_itbms,
												empre_email,
												empre_telefono,
												empre_estado_empresa,
												case empre_estado_empresa
													when 1 THEN 'activa'
													when 0 THEN 'inactiva'
												END as estado
												from maestro_empresa ");

		return $sql_empresas;
	}?>

<?php 	function todas_empresas_activas($conexon){


		$sql_empresas_activas = mysqli_query($conexon, "select
														id_empresa,
														empre_nombre_comercial,
														empre_razon_social,
														empre_ruc,
														empre_dv,
														empre_empresa_principal,
														empre_excenta_itbms,
														empre_email,
														empre_telefono,
														empre_estado_empresa,
														case empre_estado_empresa
														when 1 THEN 'activa'
														when 0 THEN 'inactiva'
														END as estado
														from maestro_empresa where empre_estado_empresa = 1");

		return $sql_empresas_activas;
	}?>

<?php 	function todos_proyectos($conexon){


		$sql_proyectos = mysqli_query($conexon, "select
																						 id_proyecto,
																						 proy_nombre_proyecto,
																						 proy_tipo_proyecto,
																						 proy_promotor,
																						 proy_area,
																						 proy_estado,
																						 proy_resolucion_ambiental,
																						 proy_monto_inicial,
																						 case proy_estado
																						 when 1 THEN 'activo'
																						 when 0 THEN 'inactivo'
																						 END as estado,
																						 id_empresa
																						 from maestro_proyectos");

		return $sql_proyectos;
	}?>

<?php 	function todos_bancos($conexon){


		$sql_bamcos = mysqli_query($conexon, "select
											  id_bancos,
											  banc_nombre_banco,
											  banc_stado,
											  case banc_stado
											  when 1 THEN 'activo'
											  when 0 THEN 'inactivo'
											  END as estado
											  from maestro_bancos");

		return $sql_bamcos;
	}?>

<?php 	function todos_bancos_activos($conexon){


		$sql_bamcos_activos = mysqli_query($conexon, "select
													  id_bancos,
													  banc_nombre_banco,
													  banc_stado,
													  case banc_stado
													  when 1 THEN 'activo'
													  when 0 THEN 'inactivo'
													  END as estado
													  from maestro_bancos where banc_stado = 1");

		return $sql_bamcos_activos;
	}?>

<?php 	function tipo_cuenta($conexon){


		$sql_tipo_cuenta = mysqli_query($conexon, "select * from tipo_cuenta");

		return $sql_tipo_cuenta;
	}?>

<?php 	function todas_cuentas($conexon){


		$sql_cuentas = mysqli_query($conexon, "SELECT
												   cb.id_cuenta_bancaria,
												   cb.cta_id_banco,
											       cb.cta_numero_cuenta,
											       cb.cta_estado,
											       cb.cta_predeterminada,
											       cb.cta_tipo_cuenta,
											       cb.cta_id_empresa,
											       mb.banc_nombre_banco,
											       me.empre_nombre_comercial FROM cuentas_bancarias cb inner join maestro_bancos mb on cta_id_banco = mb.id_bancos
											       												       inner join maestro_empresa me on cb.cta_id_empresa = me.id_empresa");

		return $sql_cuentas;
	}?>

<?php 	function todas_chequeras($conexon){

				$sql_chequeras = $conexon -> query("SELECT
																							chq.id_chequeras ,
																							chq.chq_id_cuenta_banco ,
																							chq.chq_estado_chequera ,
																							case chq.chq_estado_chequera
																							when 1 THEN 'activo'
																							when 0 THEN 'inactivo'
																							END as estado,
																							chq.chq_chequera_inicial ,
																							chq.chq_chequera_final ,
																							chq.chq_log_seq_chq ,
																							chq.chq_ultimo_emitido,
																							cb.cta_id_banco,
																							cb.cta_numero_cuenta,
																							cb.cta_id_empresa,
																							mb.banc_nombre_banco,
																						  mp.proy_nombre_proyecto,
																							me.empre_nombre_comercial
																						 FROM
																							chequeras chq inner join cuentas_bancarias cb on chq.chq_id_cuenta_banco = cb.id_cuenta_bancaria
																										   			inner join maestro_bancos mb on cb.cta_id_banco = mb.id_bancos
																										   	 		inner join maestro_empresa me on cb.cta_id_empresa = me.id_empresa
																						                inner join maestro_proyectos mp on me.id_empresa = mp.id_empresa");

		return $sql_chequeras;

	} ?>

<?php 	function todos_proveedores($conexon){


		$sql_proveedores = mysqli_query($conexon, "select `mp`.`id_proveedores` AS `id_proveedores`,`mp`.`pro_nombre_comercial` AS `pro_nombre_comercial`,`mp`.`pro_razon_social` AS `pro_razon_social`,`mp`.`pro_ruc` AS `pro_ruc`,`mp`.`pro_pais` AS `pro_pais`,`mp`.`pro_status` AS `pro_status`,(case `mp`.`pro_status` when 1 then 'activo' when 0 then 'inactivo' end) AS `estado`,`mp`.`pro_telefono_1` AS `pro_telefono_1`,`mp`.`pro_telefono_2` AS `pro_telefono_2`,`mp`.`pro_email` AS `pro_email`,`mp`.`pro_descripcion` AS `pro_descripcion`,`mps`.`id_paises` AS `id_paises`,`mps`.`ps_nombre_pais` AS `ps_nombre_pais` from (`maestro_proveedores` `mp` join `maestro_paises` `mps` on((`mp`.`pro_pais` = `mps`.`id_paises`)))");

		return $sql_proveedores;
	}?>

<?php 	function proveedores_id($conexon, $id){


		$sql_proveedores = mysqli_query($conexon, "select
														mp.id_proveedores,
														mp.pro_nombre_comercial,
														mp.pro_razon_social,
														mp.pro_ruc,
														mp.pro_pais,
														mp.pro_status,
														case mp.pro_status
													    when 1 THEN 'activo'
													    when 0 THEN 'inactivo'
													    END as estado,
														mp.pro_telefono_1,
														mp.pro_telefono_2,
														mp.pro_email,
														mp.pro_descripcion,
														mps.id_paises,
														mps.ps_nombre_pais
														from
														maestro_proveedores mp inner join maestro_paises mps on mp.pro_pais = mps.id_paises
														where
														mp.id_proveedores = '".$id."'");

		return $sql_proveedores;
	}?>

<?php 	function todos_vendedores($conexion){


		$sql_vendedores = mysqli_query($conexion, "select * from maestro_vendedores");

		return $sql_vendedores;

	}?>

<?php 	function todos_clientes($conexion){


		$sql_clientes = mysqli_query($conexion, "select
													mv.id_cliente,
												   	mv.cl_nombre,
												   	mv.cl_apellido,
												   	mv.cl_identificacion,
												   	mv.cl_pais,
												   	mv.cl_direccion,
												   	mv.cl_telefono_1,
												    mv.cl_telefono_2,
												    mv.cl_status,
                            mv.cl_referencia,
												    case mv.cl_status
													    when 1 THEN 'activo'
													    when 0 THEN 'inactivo'
													END as estado,
												    mv.cl_email,
												    ps.id_paises,
												    ps.ps_nombre_pais
												   	from
												   	maestro_clientes mv inner join maestro_paises ps on mv.cl_pais = ps.id_paises");

		return $sql_clientes;

	}?>

<?php 	function todos_clientes_activos($conexion){


		$sql_clientes = mysqli_query($conexion, "select
													mv.id_cliente,
												   	mv.cl_nombre,
												   	mv.cl_apellido,
												   	mv.cl_identificacion,
												   	mv.cl_pais,
												   	mv.cl_direccion,
												   	mv.cl_telefono_1,
												    mv.cl_telefono_2,
												    mv.cl_status,
													ms.st_nombre,
												    mv.cl_email,
												    ps.id_paises,
												    ps.ps_nombre_pais
												   	from
												   	maestro_clientes mv inner join maestro_paises ps on mv.cl_pais = ps.id_paises
												   						inner join maestro_status ms on mv.cl_status = ms.st_numero
												   	where
												   	mv.cl_status = 1");

		return $sql_clientes;

	}?>

<?php 	function todos_tipos_inmuebles($conexion){

		$sql_tipos_inmuebles = $conexion -> query("select
												   id_inmuebles,
												   im_nombre_inmueble,
												   im_status,
												   case im_status
												   	when 1 then 'activo'
												   	when 0 then 'inactivo'
												   end as estado
												   from tipo_inmuebles");

		return $sql_tipos_inmuebles;

	}?>

<?php 	function todos_grupo_inmuebles($conexion){

		$sql_grupo_inmuebles = $conexion -> query("SELECT
													gi.gi_id_proyecto,
													gi.gi_nombre_grupo_inmueble,
													gi.gi_status,
													case gi.gi_status
												     when 1 then 'activo'
												   	 when 0 then 'inactivo'
												    end as estado,
													gi.id_grupo_inmuebles,
													mp.proy_nombre_proyecto
												   FROM `grupo_inmuebles` gi inner join maestro_proyectos mp on gi.gi_id_proyecto = mp.id_proyecto");

		return $sql_grupo_inmuebles;

	}?>

<?php 	function todos_inmuebles($conexion){/* vista */

		$sql_todos_inmuebles = $conexion -> query("select * from todos_inmuebles");

		return $sql_todos_inmuebles;

 	}?>

	<?php function todos_inmuebles_filtros($conexion2,
																					$id_proyecto,
																						$id_grupo_inmueble,
																							$id_inmueble,
																								$area,
																									$n_sanitarios,
																										$n_depositos,
																											$n_estacionamientos,
																												$status){
    $where="where (1=1)";
		if($id_proyecto==""){$where.="";}else{ $where.=" and id_proyecto =$id_proyecto"; }
		if($id_grupo_inmueble==""){$where.="";}else{ $where.=" and id_grupo_inmuebles =$id_grupo_inmueble"; }
		if($id_inmueble==""){$where.="";}else{ $where.=" and id_inmueble =".$id_inmueble; }
		if($area==""){$where.="";}else{ $where.=" and mi_area =".$area; }
		if($n_sanitarios==""){$where.="";}else{ $where.=" and mi_sanitarios =".$n_sanitarios; }
		if($n_depositos==""){$where.="";}else{ $where.=" and mi_depositos =".$n_depositos; }
		if($n_estacionamientos==""){$where.="";}else{ $where.=" and mi_estacionamientos =".$n_estacionamientos; }
		if($status==""){$where.="";}else{ $where.=" and mi_status =".$status; }

		$sql_todos_inmuebles = $conexion2 -> query("select * from todos_inmuebles $where");
																				/*query("select
																								maestro_proyectos.proy_nombre_proyecto,
																								grupo_inmuebles.gi_nombre_grupo_inmueble,
																								maestro_inmuebles.mi_nombre,
																								maestro_inmuebles.id_inmueble,
																								maestro_inmuebles.id_tipo_inmuebles,
																								mi_codigo_imueble,
																								mi_modelo,
																								mi_area,
																								mi_habitaciones,
																								mi_sanitarios,
																								mi_depositos,
																								mi_estacionamientos,
																								mi_precio_venta,
																								mi_precio_real,
																								mi_precio_oferta,
																								st_nombre,
																								im_nombre_inmueble
																								from
																								maestro_inmuebles inner join maestro_proyectos on maestro_proyectos.id_proyecto = maestro_inmuebles.id_grupo_inmuebles
																												  				inner join grupo_inmuebles on grupo_inmuebles.id_grupo_inmuebles = maestro_inmuebles.id_grupo_inmuebles
																								                  inner join maestro_status on maestro_status.id_status = maestro_inmuebles.mi_status
																								                  inner join tipo_inmuebles on maestro_inmuebles.id_tipo_inmuebles = tipo_inmuebles.id_inmuebles");*/

		return $sql_todos_inmuebles;

	} ?>


 <?php 	function inmuebles_activos($conexion){

		$sql_todos_inmuebles = $conexion -> query("select
																										id_inmueble,
																										id_grupo_inmuebles,
                                                    id_tipo_inmuebles,
                                                    mi_nombre,
                                                    mi_modelo,
                                                    mi_area,
                                                    mi_habitaciones,
                                                    mi_sanitarios,
                                                    mi_depositos,
                                                    mi_estacionamientos,
                                                    mi_observaciones,
                                                    mi_precio_real,
                                                    mi_disponible,
                                                    mi_id_partida_comision,
                                                    mi_porcentaje_comision,
                                                    mi_fecha_registro,
                                                    mi_status,
                                       				me.st_nombre,
                                                    mi_log_user
                                                   from
                                                    maestro_inmuebles mi inner join maestro_status me on mi.mi_status = me.st_numero
                                                   where
                                                    mi_status = 1");

		return $sql_todos_inmuebles;

 	}?>


 <?php 	function inmuebles_id($conexion, $id){

		$sql_todos_inmuebles = $conexion -> query("select
													mi.id_inmueble,
													mi.id_grupo_inmuebles,
                                                    mi.id_tipo_inmuebles,
                                                    mi.mi_nombre,
                                                    mi.mi_modelo,
                                                    mi.mi_area,
                                                    mi.mi_habitaciones,
                                                    mi.mi_sanitarios,
                                                    mi.mi_depositos,
                                                    mi.mi_estacionamientos,
                                                    mi.mi_observaciones,
                                                    mi.mi_precio_real,
                                                    mi.mi_disponible,
                                                    mi.mi_id_partida_comision,
                                                    mi.mi_porcentaje_comision,
                                                    mi.mi_fecha_registro,
                                                    mi.mi_status,
                                       				me.st_nombre,
                                                    mi.mi_log_user,
                                                    gi.gi_nombre_grupo_inmueble,
                                                    ti.im_nombre_inmueble
                                                   from
                                                    maestro_inmuebles mi inner join maestro_status me on mi.mi_status = me.st_numero
                                                    					 inner join grupo_inmuebles gi on mi.id_grupo_inmuebles = gi.id_grupo_inmuebles
                                                    					 inner join tipo_inmuebles ti on mi.id_tipo_inmuebles = ti.id_inmuebles
                                                   where
                                                    mi.id_inmueble = '".$id."'");

		return $sql_todos_inmuebles;

 	}?>

<?php 	function reservas_inmuebles($conexion){

 		$sql_reserva_inmuebles = mysqli_query($conexion, "select
																 											irv.id_rv_inmueble,
																 											irv.rv_fecha,
																 											irv.rv_observaciones,
																 											irv.rv_precio_venta,
																											irv.rv_precio_reserva,
																											irv.id_inmueble_maestro,
																 											irv.rv_status,
																 											mcl.cl_nombre,
																 											mcl.cl_apellido,
																 											mcl.cl_identificacion,
																 											mcl.cl_email,
																 											mcl.cl_telefono_1,
																 											mv.ven_nombre,
																 											mv.ven_apellido,
																 											mv.ven_telefono_1,
																 											mi.mi_nombre,
																 											mi.mi_modelo,
																 											mi.mi_area,
																 											mi.mi_habitaciones,
																 											mi.mi_sanitarios,
																 											mi.mi_depositos,
																 											mi.mi_estacionamientos,
																 											mi.id_inmueble,
																 											us.usua_nombre,
																 											us.usua_apellido
																 											from
																 											inmueble_rv irv inner join maestro_clientes mcl on irv.id_cliente = mcl.id_cliente
																 															 inner join maestro_vendedores mv on irv.id_vendedor = mv.id_vendedor
																 															 inner join maestro_inmuebles mi on irv.id_inmueble_maestro = mi.id_inmueble
																 															 inner join usuarios us on irv.rv_user_id = us.id_usuario
																 											where
																 											irv.rv_status = 1
																 											and
																 											mi.mi_status = 2");

 		return $sql_reserva_inmuebles;

 	}?>

 <?php 	function reservas_inmuebles_id($conexion, $id){

 		$sql_reserva_inmuebles = mysqli_query($conexion, "select
																												irv.id_rv_inmueble,
																												irv.rv_fecha,
																												irv.rv_observaciones,
																												irv.rv_precio_reserva,
																												irv.rv_precio_venta,
																												irv.rv_status,
																												mcl.id_cliente,
																												mcl.cl_nombre,
																												mcl.cl_apellido,
																												mcl.cl_identificacion,
																												mcl.cl_email,
																												mcl.cl_telefono_1,
																												mv.ven_nombre,
																												mv.ven_apellido,
																												mv.id_vendedor,
																												mi.mi_nombre,
																												mi.mi_modelo,
																												mi.mi_area,
																												mi.mi_habitaciones,
																												mi.mi_sanitarios,
																												mi.mi_depositos,
																												mi.mi_estacionamientos,
																												mi.id_inmueble,
																												us.usua_nombre,
																												us.usua_apellido,
																												gi.id_grupo_inmuebles,
															   												gi.gi_nombre_grupo_inmueble,
															   												mp.proy_nombre_proyecto,
																												mp.id_proyecto
																											from
																												inmueble_rv irv inner join maestro_clientes mcl on irv.id_cliente = mcl.id_cliente
																												inner join maestro_vendedores mv on irv.id_vendedor = mv.id_vendedor
																												inner join maestro_inmuebles mi on irv.id_inmueble_maestro = mi.id_inmueble
																												inner join usuarios us on irv.rv_user_id = us.id_usuario
																												inner join grupo_inmuebles gi on mi.id_grupo_inmuebles = gi.id_grupo_inmuebles
															                    								inner join maestro_proyectos mp on gi.gi_id_proyecto = mp.id_proyecto
																											where
																												irv.rv_status = 1
																												and
																												mi.mi_status = 2
																												and
																												irv.id_rv_inmueble='".$id."'");

 		return $sql_reserva_inmuebles;

 	}?>

<?php 	function ver_contratos_ventas($conexion){

				$sql_ver_contratos_ventas = $conexion -> query("select
																													  mp.proy_nombre_proyecto,
																												    mv.id_proyecto,
																												    gi.gi_nombre_grupo_inmueble,
																												    mv.id_grupo_inmueble,
																												    mi.mi_nombre,
																														mi.mi_codigo_imueble,
																												    mv.id_inmueble,
																												    mv.mv_precio_venta,
																												    mv.mv_descripcion,
																												    mv.mv_reserva,
																												    mv.mv_id_reserva,
																												    mv.mv_status,
																												    mc.cl_nombre,
																												    mc.cl_apellido,
																												    mv.id_cliente,
																														mv.id_venta,
																														mv.fecha_venta
																												from
																													maestro_ventas mv inner join maestro_proyectos mp on mv.id_proyecto = mp.id_proyecto
																																	          inner join grupo_inmuebles gi on mv.id_grupo_inmueble = gi.id_grupo_inmuebles
																											                      inner join maestro_inmuebles mi on mv.id_inmueble = mi.id_inmueble
																											                      inner join maestro_clientes mc on mv.id_cliente = mc.id_cliente
																													");

				return $sql_ver_contratos_ventas;


} ?>

<?php 	function ver_contratos_ventas_activos($conexion){

				$sql_ver_contratos_ventas = $conexion -> query("select
																													  mp.proy_nombre_proyecto,
																												    mv.id_proyecto,
																												    gi.gi_nombre_grupo_inmueble,
																												    mv.id_grupo_inmueble,
																												    mi.mi_nombre,
																														mi.mi_codigo_imueble,
																												    mv.id_inmueble,
																												    mv.mv_precio_venta,
																												    mv.mv_descripcion,
																												    mv.mv_reserva,
																												    mv.mv_id_reserva,
																												    mv.mv_status,
																												    mc.cl_nombre,
																												    mc.cl_apellido,
																												    mv.id_cliente,
																														mv.id_venta,
																														mv.fecha_venta,
																														mi_porcentaje_comision
																												from
																													maestro_ventas mv inner join maestro_proyectos mp on mv.id_proyecto = mp.id_proyecto
																																	          inner join grupo_inmuebles gi on mv.id_grupo_inmueble = gi.id_grupo_inmuebles
																											                      inner join maestro_inmuebles mi on mv.id_inmueble = mi.id_inmueble
																											                      inner join maestro_clientes mc on mv.id_cliente = mc.id_cliente
																													where
																													mv.mv_status in(1, 4)");

				return $sql_ver_contratos_ventas;


} ?>

<?php 	function ver_contratos_ventas_activos_id($conexion, $id_ventas){

				$sql_ver_contratos_ventas = $conexion -> query("select
																													  mp.proy_nombre_proyecto,
																												    mv.id_proyecto,
																												    gi.gi_nombre_grupo_inmueble,
																												    mv.id_grupo_inmueble,
																												    mi.mi_nombre,
																														mi.mi_codigo_imueble,
																												    mv.id_inmueble,
																												    mv.mv_precio_venta,
																												    mv.mv_descripcion,
																												    mv.mv_reserva,
																												    mv.mv_id_reserva,
																												    mv.mv_status,
																												    mc.cl_nombre,
																												    mc.cl_apellido,
																												    mv.id_cliente,
																														mv.id_venta,
																														mv.fecha_venta,
																														mi.mi_porcentaje_comision,
																														mi.mi_id_partida_comision
																												from
																													maestro_ventas mv inner join maestro_proyectos mp on mv.id_proyecto = mp.id_proyecto
																																	          inner join grupo_inmuebles gi on mv.id_grupo_inmueble = gi.id_grupo_inmuebles
																											                      inner join maestro_inmuebles mi on mv.id_inmueble = mi.id_inmueble
																											                      inner join maestro_clientes mc on mv.id_cliente = mc.id_cliente
																													  where
																													  mv.mv_status in(1, 4)
																													  and
																													  mv.id_venta = '".$id_ventas."'");

				return $sql_ver_contratos_ventas;

} ?>

<?php 	function suma_porcentaje($conexion, $id_contrato_venta){

				$sql_suma_porcentaje = $conexion -> query("select sum(cv_porcentaje_comision) as suma from comisiones_vendedores where id_contrato_venta ='".$id_contrato_venta."'");

				return $sql_suma_porcentaje;
} ?>

<?php 	function vendedores_asignados($conexion, $id_contrato_venta){

				$sql_vendedores_asignados = $conexion -> query("select
																												mpr.pro_nombre_comercial,
																												mpr.pro_razon_social,
																												cv.cv_porcentaje_comision,
																												cv.id_comision_vendedor
																												from
																												comisiones_vendedores cv inner join maestro_proveedores mpr on cv.id_vendedor = mpr.id_proveedores
																												where
																												cv.id_contrato_venta = '".$id_contrato_venta."'");

				return $sql_vendedores_asignados;
} ?>

<?php 	function eliminar_comision($conexion, $id_eliminar){

				$sql_eliminar_comision = $conexion -> query("delete from comisiones_vendedores where id_comision_vendedor = '".$id_eliminar."'");

} ?>

<?php 	function cuotas_contrato($conexion, $id){

				$sql_cuota_contrato = $conexion -> query("select
																									mc.id_cuota,
																									tc.tc_nombre_tipo_cuenta,
																									mc.mc_fecha_vencimiento,
																									mc.mc_monto,
																									mc.mc_monto_abonado,
																									mc.mc_numero_cuota
																									from
																									maestro_cuotas mc inner join tipo_cuota tc on mc.id_tipo_cuota = tc.id_tipo_cuota
																									where
																									mc.id_contrato_venta =".$id);

				return $sql_cuota_contrato;
} ?>

<?php 	function suma_documento($conexion, $id_contrato){

				$sql_suma = $conexion -> query("select sum(mc_monto) as suma from maestro_cuotas where id_contrato_venta =".$id_contrato);
										while($lista_suma = $sql_suma -> fetch_array()){
													return $lista_suma['suma'];
										}

} ?>

<?php 	function suma_documento_retornado($conexion, $id_contrato){

				$sql_suma = $conexion -> query("select sum(mc_monto) as suma from maestro_cuotas where id_contrato_venta =".$id_contrato);
										while($lista_suma = $sql_suma -> fetch_array()){
													$suma = $lista_suma['suma'];
										}

						return $suma;
} ?>

<?php 	function suma_documento_abonado($conexion, $id_contrato){

				$sql_suma = $conexion -> query("select sum(mc_monto_abonado) as suma from maestro_cuotas where id_contrato_venta =".$id_contrato);
										while($lista_suma = $sql_suma -> fetch_array()){
													echo $lista_suma['suma'];
										}

} ?>

<?php 	function eliminar_documento($conexion, $id_documento){

				$sql_eliminar_cuota = $conexion -> query("delete from maestro_cuotas where id_cuota = '".$id_documento."'");
} ?>

<?php 	function update_contrato_venta($conexion, $id_contrato_venta, $stat){

				$sql_update_contrato_venta = $conexion -> query("update maestro_ventas set mv_status = '".$stat."' where id_venta = '".$id_contrato_venta."'");
} ?>

<?php 	function todos_cuotas_contrato($conexion){

				$sql_todos_cuota_contrato = $conexion -> query("select
                                                        mc.id_cuota,
                                                        tc.tc_nombre_tipo_cuenta,
                                                        mc.mc_fecha_vencimiento,
                                                        mc.mc_monto,
                                                        mc.mc_monto_abonado,
                                                        mc.mc_fecha_creacion_contrato,
                                                        mc.mc_descripcion,
																												mc.id_contrato_venta,
                                                        mcl.cl_nombre,
                                                        mcl.cl_apellido,
                                                        mi.mi_nombre,
                                                        mc_status
                                                        from maestro_cuotas mc inner join tipo_cuota tc on mc.id_tipo_cuota = tc.id_tipo_cuota
                                                        					   inner join maestro_ventas mv on mc.id_contrato_venta = mv.id_venta
                                                                               inner join maestro_clientes mcl on mv.id_cliente = mcl.id_cliente
                                                                               inner join maestro_inmuebles mi on mc.id_inmueble = mi.id_inmueble");

        return $sql_todos_cuota_contrato;

} ?>

<?php 	function todos_cuotas_id_contrato($conexion, $id_venta){

				$sql_todos_cuota_id_contrato = $conexion -> query("select
		                                                        mc.id_cuota,
																														mc.id_contrato_venta,
		                                                        tc.tc_nombre_tipo_cuenta,
																														tc.id_tipo_cuota,
																														mc.mc_numero_cuota,
		                                                        mc.mc_fecha_vencimiento,
		                                                        mc.mc_monto,
		                                                        mc.mc_monto_abonado,
		                                                        mc.mc_fecha_creacion_contrato,
		                                                        mc.mc_descripcion,
																														mc.mc_numero_cuota,
		                                                        mcl.cl_nombre,
		                                                        mcl.cl_apellido,
		                                                        mi.mi_nombre,
		                                                        mc_status,
																														mv.mv_precio_venta,
																														mc.id_proyecto,
																														mp.proy_nombre_proyecto,
																														gi.id_grupo_inmuebles,
																														gi.gi_nombre_grupo_inmueble,
																														mi.mi_codigo_imueble
		                                                        from maestro_cuotas mc inner join tipo_cuota tc on mc.id_tipo_cuota = tc.id_tipo_cuota
		                                                        					   					 inner join maestro_ventas mv on mc.id_contrato_venta = mv.id_venta
		                                                                               inner join maestro_clientes mcl on mv.id_cliente = mcl.id_cliente
		                                                                               inner join maestro_inmuebles mi on mc.id_inmueble = mi.id_inmueble
																																									 inner join maestro_proyectos mp on mp.id_proyecto = mc.id_proyecto
																																									 inner join grupo_inmuebles gi on gi.id_grupo_inmuebles = mc.id_grupo
																														where
																														mv.id_venta = '".$id_venta."'");

        return $sql_todos_cuota_id_contrato;

} ?>

<?php 	function cuota_id_cuota($conexion, $id_cuota){

				$sql_todos_cuota_id_contrato = $conexion -> query("select
		                                                        mc.id_cuota,
																														mc.id_contrato_venta,
		                                                        tc.tc_nombre_tipo_cuenta,
																														tc.id_tipo_cuota,
																														mc.mc_numero_cuota,
		                                                        mc.mc_fecha_vencimiento,
		                                                        mc.mc_monto,
		                                                        mc.mc_monto_abonado,
		                                                        mc.mc_fecha_creacion_contrato,
		                                                        mc.mc_descripcion,
																														mc.mc_numero_cuota,
																														mcl.id_cliente,
		                                                        mcl.cl_nombre,
		                                                        mcl.cl_apellido,
		                                                        mi.mi_nombre,
																														mi.id_inmueble,
		                                                        mc_status,
																														mv.mv_precio_venta,
																														mc.id_proyecto,
																														mp.proy_nombre_proyecto,
																														gi.id_grupo_inmuebles,
																														gi.gi_nombre_grupo_inmueble,
																														mi.mi_codigo_imueble
		                                                        from maestro_cuotas mc inner join tipo_cuota tc on mc.id_tipo_cuota = tc.id_tipo_cuota
		                                                        					   					 inner join maestro_ventas mv on mc.id_contrato_venta = mv.id_venta
		                                                                               inner join maestro_clientes mcl on mv.id_cliente = mcl.id_cliente
		                                                                               inner join maestro_inmuebles mi on mc.id_inmueble = mi.id_inmueble
																																									 inner join maestro_proyectos mp on mp.id_proyecto = mc.id_proyecto
																																									 inner join grupo_inmuebles gi on gi.id_grupo_inmuebles = mc.id_grupo
																														where
																														mc.id_cuota = '".$id_cuota."'");

        return $sql_todos_cuota_id_contrato;

} ?>

<?php 	function comprobar_suma_cuotas($conexion, $id_contrato_venta){

				$sql_comprobar_cuotas = $conexion ->query("select
																										sum(mc_monto) as suma_monto,
																										sum(mc_monto_abonado) as suma_abonada
																									 from
																											maestro_cuotas
																										where
																											id_contrato_venta = '".$id_contrato_venta."'");
				while($lista_comprobar_suma = $sql_comprobar_cuotas-> fetch_array()){
							$monto = $lista_comprobar_suma['suma_monto'];
							$monto_abonado = $lista_comprobar_suma['suma_abonada'];
				}

							if($monto == $monto_abonado){

								$sql_monto = $conexion -> query("SELECT mv_precio_venta FROM maestro_ventas where id_venta =".$id_contrato_venta);
								while($l=$sql_monto->fetch_array()){
									$monto_venta = $l["mv_precio_venta"];
								}
								if($monto_venta == $monto_abonado){
								$update_contrato_venta = $conexion -> query("update maestro_ventas set mv_status = 6 where id_venta = '".$id_contrato_venta."'");
							}
							}

							if(isset($update_contrato_venta)){

								return true;

							}else{

									return false;

							}

} ?>

<?php 	function numero_cuotas($conexion, $id_contrato_venta){

				$sql_numero_cuotas = $conexion -> query("select count(id_cuota) as contar from maestro_cuotas where id_contrato_venta = '".$id_contrato_venta."'");
				while($lista_contar = $sql_numero_cuotas->fetch_array()){
							$contar = $lista_contar['contar'];
				}

				return $contar;

} ?>

<?php 	function suma_cuota($conexion, $id_contrato_venta){

				$sql_comprobar_cuotas = $conexion ->query("select
																										sum(mc_monto_abonado) as suma_abonada
																									from
																										maestro_cuotas
																									where
																										id_contrato_venta = '".$id_contrato_venta."'");
				while($lista_comprobar_suma = $sql_comprobar_cuotas-> fetch_array()){

							$monto_abonado = $lista_comprobar_suma['suma_abonada'];
				}

					return $monto_abonado;

} ?>

<?php 	function movimiento_bancario_cuenta($conexion){

				$sql_mb_cuenta = $conexion ->query("select
																						cb.id_cuenta_bancaria,
																						mp.proy_nombre_proyecto,
																						mb.banc_nombre_banco,
																						cb.cta_numero_cuenta
																					 from maestro_empresa me
																					  inner join maestro_proyectos mp on me.id_empresa = mp.id_empresa
																					  inner join cuentas_bancarias cb on me.id_empresa = cb.cta_id_empresa
																					  inner join maestro_bancos mb on cb.cta_id_banco = mb.id_bancos
																					 where
																						cb.cta_estado = 1");

										return $sql_mb_cuenta;

} ?>

<?php 	function tipo_movimiento_bancario($conexion){

				$sql_tipo_movimiento = $conexion ->query("select * from tipo_movimiento_bancario where tmb_stat = 1 AND id_tipo_movimiento_bancario not in(8)");

				return $sql_tipo_movimiento;

} ?>

<?php 	function ver_movimientos_bancarios($conexion){

				$sql_ver_movimiento = $conexion -> query("select
																									cb.id_cuenta_bancaria,
																									mp.proy_nombre_proyecto,
																									mb.banc_nombre_banco,
																									cb.cta_numero_cuenta,
																									mbo.mb_fecha,
																									mbo.mb_monto,
																									mbo.mb_descripcion,
																									mbo.mb_stat,
																									mbo.mb_referencia_numero,
																									mbo.id_tipo_movimiento,
																									mbo.id_movimiento_bancario,
																								  tmb.tmb_nombre,
																									mbo.movimiento_directo
																								 from maestro_empresa me
																								  inner join maestro_proyectos mp on me.id_empresa = mp.id_empresa
																								  inner join cuentas_bancarias cb on me.id_empresa = cb.cta_id_empresa
																								  inner join maestro_bancos mb on cb.cta_id_banco = mb.id_bancos
																								  inner join movimiento_bancario mbo on cb.id_cuenta_bancaria = mbo.id_cuenta
																								  inner join tipo_movimiento_bancario tmb on mbo.id_tipo_movimiento = tmb.id_tipo_movimiento_bancario");

				return $sql_ver_movimiento;

} ?>

<?php 	function emitir_cheque($conexon){

				$sql_chequeras = $conexon -> query("SELECT
																						chq.id_chequeras,
																						chq.chq_id_cuenta_banco,
																						chq.chq_estado_chequera,
																						case chq.chq_estado_chequera
																						when 1 THEN 'activo'
																						when 0 THEN 'inactivo'
																						END as estado,
																						chq.chq_chequera_inicial,
																						chq.chq_chequera_final,
																						chq.chq_log_seq_chq,
																						chq.chq_ultimo_emitido,
																						cb.cta_id_banco,
																						cb.cta_numero_cuenta,
																						cb.cta_id_empresa,
																						mb.banc_nombre_banco,
																						mp.proy_nombre_proyecto,
																						me.empre_nombre_comercial
																						FROM
																						chequeras chq  inner join cuentas_bancarias cb on  chq.chq_id_cuenta_banco = cb.id_cuenta_bancaria
																						inner join maestro_bancos mb on cb.cta_id_banco = mb.id_bancos
																						inner join maestro_empresa me on cb.cta_id_empresa = me.id_empresa
																						inner join maestro_proyectos mp on me.id_empresa = mp.id_empresa
																						inner join movimiento_bancario mbs on mbs.id_cuenta = cb.id_cuenta_bancaria
																						group by
																						chq.id_chequeras,
																						chq.chq_id_cuenta_banco,
																						chq.chq_estado_chequera,
																						chq.chq_estado_chequera,
																						chq.chq_chequera_inicial,
																						chq.chq_chequera_final,
																						chq.chq_log_seq_chq,
																						chq.chq_ultimo_emitido,
																						cb.cta_id_banco,
																						cb.cta_numero_cuenta,
																						cb.cta_id_empresa,
																						mb.banc_nombre_banco,
																						mp.proy_nombre_proyecto,
																						me.empre_nombre_comercial");

		return $sql_chequeras;

	} ?>

<?php 	function contar_cheques($conexion, $id_chequeras){

				$sql_contar_cheques = $conexion -> query("select
																										(chq_ultimo_emitido)+1 as suma_cheque
																										from
																										chequeras
																										where
																										id_chequeras = '".$id_chequeras."'");
				return $sql_contar_cheques;
	} ?>

	<?php 	/*function contar_cheques_cuenta($conexion, $id_chequeras){

					$sql_contar_cheques = $conexion -> query("select
																											count(id_movimiento_bancario)+1 as suma_cheque
																											from
																											movimiento_bancario
																											where
																											id_cuenta = '".$id_chequeras."'
																											and
																											id_tipo_movimiento = 8");
					return $sql_contar_cheques;
		}*/ ?>

<?php 	function obtenert_id_cuenta_cheque($conexion, $id_chequera){

				$sql = $conexion -> query("select chq_id_cuenta_banco from chequeras where id_chequeras = '".$id_chequera."'");

				while($ch = $sql->fetch_array()){
							return $ch['chq_id_cuenta_banco'];
				}

	} ?>
	<?php 	function obtenert_id_chequera_cuenta($conexion, $id_cuenta){

					$sql = $conexion -> query("select id_chequeras from chequeras where chq_id_cuenta_banco = '".$id_cuenta."'");

					while($ch = $sql->fetch_array()){
								return $ch['id_chequeras'];
					}

		} ?>

	<?php 	function saldo_cuentas($conexion){

					$sql_saldo_cuentas = $conexion -> query("select
																										cb.id_cuenta_bancaria,
																										mp.proy_nombre_proyecto,
																										mb.banc_nombre_banco,
																										cb.cta_numero_cuenta,
																										SUM(CASE WHEN mbo.id_tipo_movimiento = 2 THEN mbo.mb_monto ELSE 0 END) +
																										SUM(CASE WHEN mbo.id_tipo_movimiento = 3 THEN mbo.mb_monto ELSE 0 END) +
																										SUM(CASE WHEN mbo.id_tipo_movimiento = 5 THEN mbo.mb_monto ELSE 0 END) +
																										SUM(CASE WHEN mbo.id_tipo_movimiento = 7 THEN mbo.mb_monto ELSE 0 END) +
																										SUM(CASE WHEN mbo.id_tipo_movimiento = 14 THEN mbo.mb_monto ELSE 0 END) +
																										SUM(CASE WHEN mbo.id_tipo_movimiento = 17 THEN mbo.mb_monto ELSE 0 END) +
																										SUM(CASE WHEN mbo.id_tipo_movimiento = 19 THEN mbo.mb_monto ELSE 0 END) +
																										SUM(CASE WHEN mbo.id_tipo_movimiento = 20 THEN mbo.mb_monto ELSE 0 END) +
																										SUM(CASE WHEN mbo.id_tipo_movimiento = 21 THEN mbo.mb_monto ELSE 0 END) +
																										SUM(CASE WHEN mbo.id_tipo_movimiento = 22 THEN mbo.mb_monto ELSE 0 END) +
																										SUM(CASE WHEN mbo.id_tipo_movimiento = 23 THEN mbo.mb_monto ELSE 0 END) +
																										SUM(CASE WHEN mbo.id_tipo_movimiento = 24 THEN mbo.mb_monto ELSE 0 END) +
																										SUM(CASE WHEN mbo.id_tipo_movimiento = 25 THEN mbo.mb_monto ELSE 0 END) +
																										SUM(CASE WHEN mbo.id_tipo_movimiento = 13 THEN mbo.mb_monto ELSE 0 END) +
																										SUM(CASE WHEN mbo.id_tipo_movimiento = 16 THEN mbo.mb_monto ELSE 0 END) as total_credito,
																										SUM(CASE WHEN mbo.id_tipo_movimiento = 1 THEN mbo.mb_monto ELSE 0 END) +
																										SUM(CASE WHEN mbo.id_tipo_movimiento = 4 THEN mbo.mb_monto ELSE 0 END) +
																										SUM(CASE WHEN mbo.id_tipo_movimiento = 6 THEN mbo.mb_monto ELSE 0 END) +
																										SUM(CASE WHEN mbo.id_tipo_movimiento = 10 THEN mbo.mb_monto ELSE 0 END) +
																										SUM(CASE WHEN mbo.id_tipo_movimiento = 9 THEN mbo.mb_monto ELSE 0 END) +
																										SUM(CASE WHEN mbo.id_tipo_movimiento = 12 THEN mbo.mb_monto ELSE 0 END) +
																										SUM(CASE WHEN mbo.id_tipo_movimiento = 18 THEN mbo.mb_monto ELSE 0 END) +
																										SUM(CASE WHEN mbo.id_tipo_movimiento = 11 THEN mbo.mb_monto ELSE 0 END) +
																										SUM(CASE WHEN mbo.id_tipo_movimiento = 8  THEN mbo.mb_monto ELSE 0 END) as total_debito,
																										(SUM(CASE WHEN mbo.id_tipo_movimiento = 2 THEN mbo.mb_monto ELSE 0 END) +
																										SUM(CASE WHEN mbo.id_tipo_movimiento = 3 THEN mbo.mb_monto ELSE 0 END) +
																										SUM(CASE WHEN mbo.id_tipo_movimiento = 5 THEN mbo.mb_monto ELSE 0 END) +
																										SUM(CASE WHEN mbo.id_tipo_movimiento = 7 THEN mbo.mb_monto ELSE 0 END) +
																										SUM(CASE WHEN mbo.id_tipo_movimiento = 14 THEN mbo.mb_monto ELSE 0 END) +
																										SUM(CASE WHEN mbo.id_tipo_movimiento = 17 THEN mbo.mb_monto ELSE 0 END) +
																										SUM(CASE WHEN mbo.id_tipo_movimiento = 19 THEN mbo.mb_monto ELSE 0 END) +
																										SUM(CASE WHEN mbo.id_tipo_movimiento = 20 THEN mbo.mb_monto ELSE 0 END) +
																										SUM(CASE WHEN mbo.id_tipo_movimiento = 21 THEN mbo.mb_monto ELSE 0 END) +
																										SUM(CASE WHEN mbo.id_tipo_movimiento = 22 THEN mbo.mb_monto ELSE 0 END) +
																										SUM(CASE WHEN mbo.id_tipo_movimiento = 24 THEN mbo.mb_monto ELSE 0 END) +
																										SUM(CASE WHEN mbo.id_tipo_movimiento = 25 THEN mbo.mb_monto ELSE 0 END) +
																										SUM(CASE WHEN mbo.id_tipo_movimiento = 23 THEN mbo.mb_monto ELSE 0 END) +
																										SUM(CASE WHEN mbo.id_tipo_movimiento = 13 THEN mbo.mb_monto ELSE 0 END) +
																										SUM(CASE WHEN mbo.id_tipo_movimiento = 16 THEN mbo.mb_monto ELSE 0 END)) -
																										(SUM(CASE WHEN mbo.id_tipo_movimiento = 1 THEN mbo.mb_monto ELSE 0 END) +
																										SUM(CASE WHEN mbo.id_tipo_movimiento = 4 THEN mbo.mb_monto ELSE 0 END) +
																										SUM(CASE WHEN mbo.id_tipo_movimiento = 6 THEN mbo.mb_monto ELSE 0 END) +
																										SUM(CASE WHEN mbo.id_tipo_movimiento = 10 THEN mbo.mb_monto ELSE 0 END) +
																										SUM(CASE WHEN mbo.id_tipo_movimiento = 9 THEN mbo.mb_monto ELSE 0 END) +
																										SUM(CASE WHEN mbo.id_tipo_movimiento = 12 THEN mbo.mb_monto ELSE 0 END) +
																										SUM(CASE WHEN mbo.id_tipo_movimiento = 18 THEN mbo.mb_monto ELSE 0 END) +
																										SUM(CASE WHEN mbo.id_tipo_movimiento = 11 THEN mbo.mb_monto ELSE 0 END) +
																										SUM(CASE WHEN mbo.id_tipo_movimiento = 8 THEN mbo.mb_monto ELSE 0 END)) as total
																									from maestro_empresa me
																									  inner join maestro_proyectos mp on me.id_empresa = mp.id_empresa
																									  inner join cuentas_bancarias cb on me.id_empresa = cb.cta_id_empresa
																									  inner join maestro_bancos mb on cb.cta_id_banco = mb.id_bancos
																									  inner join movimiento_bancario mbo on cb.id_cuenta_bancaria = mbo.id_cuenta
																									  inner join tipo_movimiento_bancario tmb on mbo.id_tipo_movimiento = tmb.id_tipo_movimiento_bancario
																									where
																										mbo.mb_stat NOT IN(12)
																									group by
																									  cb.id_cuenta_bancaria,
																										mp.proy_nombre_proyecto,
																										mb.banc_nombre_banco,
																										cb.cta_numero_cuenta");

					return $sql_saldo_cuentas;

	} ?>

	<?php 	function estado_cuenta_bancario($conexion, $id_cuenta, $desde, $hasta){

					/*if($mes != ""){ $contenido1 = " AND MONTH(mb_fecha) = $mes";}else{ $contenido1 = "";}
					if($anio != ""){ $contenido2 = " AND YEAR(mb_fecha) = $anio";}else{ $contenido2 = "";}*/

					$wh = " AND mbo.mb_fecha >= STR_TO_DATE('".$desde."','%m/%d/%Y')
									AND mbo.mb_fecha <= STR_TO_DATE('".$hasta."','%m/%d/%Y')" . " ";

					$contenido = $wh;
					$sql = "select mbo.id_movimiento_bancario,
								   mbo.mb_fecha,
								   mbo.id_tipo_movimiento,
								   mbo.mb_numero_cheque,
									 mbo.mb_referencia_numero,
								   tmb.tmb_nombre,
									 mbo.mb_fecha as fecha_completa,
									 case tmb.id_tipo_movimiento_bancario
									  when 1 then 'Nota de Debito'
										when 2 then 'Nota Credito'
										when 3 then 'Transferencia (Entrada)'
										when 4 then 'Transferencia (Salida)'
										when 5 then 'Ajuste (Entrada)'
										when 6 then 'Ajuste (Salida)'
										when 7 then 'Prestamo Interino de socios'
										when 8 then 'Cheque'
										when 9 then 'Intercambio'
										when 10 then 'Carta de Credito'
										when 11 then 'ACH'
										when 12 then 'Cheque de Gerencia'
										when 13 then 'Deposito'
										when 14 then 'Efectivo'
										when 15 then 'Intercambio'
										when 16 then 'Ajuste'
										when 17 then 'Cheque Deposito'
										when 18 then 'Interes'
										when 19 then 'RAMPA'
										when 20 then 'DIESEL'
										when 21 then 'GASOLINA'
										when 22 then 'TARJETA DE CREDITO'
										when 24 then 'MUELLE'
										when 23 then 'CARTA DE CREDITO(INGRESO)'
										when 25 then 'SERVICIOS'
									 end as nombre_tipo,
								   mbo.mb_descripcion,
								   mc.cl_nombre,
								   mc.cl_apellido,
								   mbo.mb_monto,
								   IF(mbo.id_tipo_movimiento in (2,3,5,7,14,17,19,20,21,22,23,13,16,24,25) ,
								   	(SELECT mb1.mb_monto FROM movimiento_bancario mb1 WHERE mbo.id_movimiento_bancario = mb1.id_movimiento_bancario), (0)) AS credito,
								   IF(mbo.id_tipo_movimiento in (1,4,6,8,11,18,9,10,12) ,
								   	(SELECT mb1.mb_monto FROM movimiento_bancario mb1 WHERE mbo.id_movimiento_bancario = mb1.id_movimiento_bancario and mb1.mb_stat NOT IN(12)), (0)) AS debito,
    							   (select sum(IF(mb.id_tipo_movimiento in (2,3,5,7,14,17,19,20,21,22,23,13,16,24,25) , mb.mb_monto ,  -mb.mb_monto ))
     							    from movimiento_bancario mb
     								where mbo.mb_fecha >= mb.mb_fecha
      								and (case when mbo.mb_fecha = mb.mb_fecha then mb.id_movimiento_bancario else mbo.id_movimiento_bancario end) <= mbo.id_movimiento_bancario
     								  and mbo.id_cuenta = mb.id_cuenta and mb.mb_stat NOT IN(12)) saldo,
     								mp.pro_nombre_comercial
							from movimiento_bancario mbo
							inner join tipo_movimiento_bancario tmb on mbo.id_tipo_movimiento = tmb.id_tipo_movimiento_bancario
							left join maestro_clientes mc on mbo.id_cliente = mc.id_cliente
							left join maestro_proveedores mp on mbo.id_proveedor = mp.id_proveedores
							where mbo.id_cuenta = '$id_cuenta'
							$contenido
							order by mbo.mb_fecha, mbo.id_movimiento_bancario";
							     					//echo $sql;
 					/*"select
						mbo.id_movimiento_bancario,
						DAY(mbo.mb_fecha) AS mb_fecha,
						mbo.id_tipo_movimiento,
						mbo.mb_numero_cheque,
						tmb.tmb_nombre,
						mbo.mb_descripcion,
						mc.cl_nombre,
						mc.cl_apellido,
						mbo.mb_monto,
						IF(mbo.id_tipo_movimiento in (2,3,5,13,14,17) ,(SELECT mb1.mb_monto FROM movimiento_bancario mb1 WHERE mbo.id_movimiento_bancario = mb1.id_movimiento_bancario),
						  (0)) AS credito,
						IF(mbo.id_tipo_movimiento in (1,4,6,7,8,18) ,(SELECT mb1.mb_monto FROM movimiento_bancario mb1 WHERE mbo.id_movimiento_bancario = mb1.id_movimiento_bancario),
						  (0)) AS debito,
						(select sum(IF(mb.id_tipo_movimiento in (2,3,5,13,17,14) , mb.mb_monto , - mb.mb_monto )) from movimiento_bancario mb
						where mbo.id_movimiento_bancario >= mb.id_movimiento_bancario and mbo.id_cuenta = mb.id_cuenta and mb.mb_stat NOT IN(12)) saldo,
						mp.pro_nombre_comercial
						from movimiento_bancario mbo inner join tipo_movimiento_bancario tmb on mbo.id_tipo_movimiento = tmb.id_tipo_movimiento_bancario
													 left join maestro_clientes mc on mbo.id_cliente = mc.id_cliente
													 left join maestro_proveedores mp on mbo.id_proveedor = mp.id_proveedores
						where
						mbo.id_cuenta = '".$id_cuenta."'
						$contenido
						order by
						mbo.id_movimiento_bancario DESC"*/


					$sql_estado_cuenta_bancario = $conexion -> query($sql);

					return $sql_estado_cuenta_bancario;

	} ?>

	<?php 	function selecionar_estado_cuenta($conexion){

					$sql_selecionar_estado_cuenta = $conexion -> query("select
																															cb.id_cuenta_bancaria,
																															mp.proy_nombre_proyecto,
																															mb.banc_nombre_banco,
																															cb.cta_numero_cuenta
																															from maestro_empresa me
																															inner join maestro_proyectos mp on me.id_empresa = mp.id_empresa
																															inner join cuentas_bancarias cb on me.id_empresa = cb.cta_id_empresa
																															inner join maestro_bancos mb on cb.cta_id_banco = mb.id_bancos
																															inner join movimiento_bancario mbo on cb.id_cuenta_bancaria = mbo.id_cuenta
																															group by
																															cb.id_cuenta_bancaria,
																															mp.proy_nombre_proyecto,
																															mb.banc_nombre_banco,
																															cb.cta_numero_cuenta");
					return $sql_selecionar_estado_cuenta;

	} ?>

<?php 	function seleccionar_partida_proyecto($conexion, $id_proyecto){

					$sql_select_partida = $conexion -> query("select id, p_nombre from maestro_partidas where id_proyecto = '".$id_proyecto."' and id_categoria is not null order by id");

						return $sql_select_partida;

	} ?>

	<?php 	function seleccionar_partida_factura($conexion, $id_partidas){

						$sql_select_partida = $conexion -> query("select id, p_nombre from maestro_partidas where id = '".$id_partidas."'");

							return $sql_select_partida;

	} ?>

<?php 	function seleccionar_partida($conexion, $id_partida){

					$sql_partida = $conexion -> query("select * from maestro_partidas where id = '".$id_partida."'");

						return $sql_partida;

	} ?>

<?php 	function tipo_documentos($conexion){

					$sql_tipo_document = $conexion -> query("select * from tipo_documentos where stat = 1");

					return $sql_tipo_document;

	} ?>

<?php 	function ver_documentos_partidas($conexion){

				$sql_ver_documentos_partidas = $conexion -> query("select
																														pd.*,
																														mproy.proy_nombre_proyecto,
																														mp.p_nombre,
																														(select mpr.pro_nombre_comercial from maestro_proveedores mpr where pd.id_proveedor = mpr.id_proveedores) as pro_nombre_comercial,
																														td.nombre
																														from partida_documento pd
																														inner join maestro_partidas mp on pd.id_partida = mp.id
																														inner join tipo_documentos td on pd.tipo_documento = td.id
																														inner join maestro_proyectos mproy on mproy.id_proyecto = mp.id_proyecto");

				return $sql_ver_documentos_partidas;

	} ?>

	<?php 	function ver_documentos_emision_pago($conexion, $id_proyecto, $id_proveedor, $id){

					$sql_ver_documentos_emision_pago = $conexion -> query("select
																																	  pd.*,
																																    mproy.proy_nombre_proyecto,
																																	  mp.p_nombre,
																																    mpr.pro_nombre_comercial,
																																    td.nombre,
																																		ms.st_nombre
																																 from partida_documento pd inner join maestro_partidas mp on pd.id_partida = mp.id
																																						  						 inner join maestro_proveedores mpr on pd.id_proveedor = mpr.id_proveedores
																																                           inner join tipo_documentos td on pd.tipo_documento = td.id
																																                           inner join maestro_proyectos mproy on mproy.id_proyecto = mp.id_proyecto
																																													 inner join maestro_status ms on pd.pd_stat = ms.st_numero
																																		where
																																		mproy.id_proyecto = '".$id_proyecto."'
																																		and
																																		pd.id_proveedor = '".$id_proveedor."'
																																		and
																																		pd.id = '".$id."'
																																		and
																																		pd.pd_stat = 1");

					return $sql_ver_documentos_emision_pago;

		} ?>

		<?php 	function ver_documentos_emision_pago_pro($conexion, $id_proyecto, $id_proveedor){

						$sql_ver_documentos_emision_pago = $conexion -> query("select
																																			pd.*,
																																			mproy.proy_nombre_proyecto,
																																			mp.p_nombre,
																																			mpr.pro_nombre_comercial,
																																			td.nombre,
																																			ms.st_nombre
																																	 from partida_documento pd inner join maestro_partidas mp on pd.id_partida = mp.id
																																														 inner join maestro_proveedores mpr on pd.id_proveedor = mpr.id_proveedores
																																														 inner join tipo_documentos td on pd.tipo_documento = td.id
																																														 inner join maestro_proyectos mproy on mproy.id_proyecto = mp.id_proyecto
																																														 inner join maestro_status ms on pd.pd_stat = ms.st_numero
																																			where
																																			mproy.id_proyecto = '".$id_proyecto."'
																																			and
																																			pd.id_proveedor = '".$id_proveedor."'");

						return $sql_ver_documentos_emision_pago;

			} ?>

			<?php 	function ver_documentos_emision_pago_pro_formulario($conexion){

							$sql_ver_documentos_emision_pago = $conexion -> query("select
																																				pd.*,
																																				mproy.proy_nombre_proyecto,
																																				mp.p_nombre,
																																				mpr.pro_nombre_comercial,
																																				td.nombre,
																																				ms.st_nombre
																																		 from partida_documento pd inner join maestro_partidas mp on pd.id_partida = mp.id
																																															 inner join maestro_proveedores mpr on pd.id_proveedor = mpr.id_proveedores
																																															 inner join tipo_documentos td on pd.tipo_documento = td.id
																																															 inner join maestro_proyectos mproy on mproy.id_proyecto = mp.id_proyecto
																																															 inner join maestro_status ms on pd.pd_stat = ms.st_numero
																																			where
																																			pd.pd_stat in(13, 14, 15)");

							return $sql_ver_documentos_emision_pago;

				} ?>

		<?php 	function select_documentos_emision_pago($conexion){

						$sql_select_documentos_emision_pago = $conexion -> query("select
																																				  mproy.id_proyecto,
																																			    mproy.proy_nombre_proyecto
																																			 from partida_documento pd inner join maestro_partidas mp on pd.id_partida = mp.id
																																									  						 inner join maestro_proveedores mpr on pd.id_proveedor = mpr.id_proveedores
																																			                           inner join tipo_documentos td on pd.tipo_documento = td.id
																																			                           inner join maestro_proyectos mproy on mproy.id_proyecto = mp.id_proyecto
																																																 inner join maestro_status ms on pd.pd_stat = ms.st_numero
																																			 where
																																			 		pd.pd_stat not in(8)
																																			 group by
																																				 mproy.id_proyecto,
																																				 mproy.proy_nombre_proyecto");

						return $sql_select_documentos_emision_pago;

			} ?>

		<?php 	function select_proveedores_documentos($conexion, $id_proveedor){

						$sql_select_proveedores_documentos = $conexion -> query("select
																																			mpr.id_proveedores,
																																			mpr.pro_nombre_comercial,
																																			mpr.pro_razon_social
																																			from
																																			maestro_partidas mp inner join partida_documento pd on mp.id = pd.id_partida
																																									        inner join maestro_proveedores mpr on pd.id_proveedor = mpr.id_proveedores
																																			where
																																			mp.id_proyecto = '".$id_proveedor."'
																																			and
																																			pd.pd_stat in (13, 14, 15, 16)
																																			group by
																																			mpr.id_proveedores,
																																			mpr.pro_nombre_comercial,
																																			mpr.pro_razon_social");

						return $sql_select_proveedores_documentos;

			} ?>

			<?php 	function ver_documentos_emision_pago_detalles($conexion, $id_proyecto, $id_proveedor){

							$sql_ver_documentos_emision_pago_detalles = $conexion -> query("select
																																									mproy.proy_nombre_proyecto,
																																									mpr.pro_nombre_comercial
																																							 from partida_documento pd inner join maestro_partidas mp on pd.id_partida = mp.id
																																																				 inner join maestro_proveedores mpr on pd.id_proveedor = mpr.id_proveedores
																																																				 inner join tipo_documentos td on pd.tipo_documento = td.id
																																																				 inner join maestro_proyectos mproy on mproy.id_proyecto = mp.id_proyecto
																																																				 inner join maestro_status ms on pd.pd_stat = ms.st_numero
																																									where
																																									mproy.id_proyecto = '".$id_proyecto."'
																																									and
																																									pd.id_proveedor = '".$id_proveedor."'
																																									and
																																									pd_stat in (13, 14, 15, 16)
																																									group by
																																									mproy.proy_nombre_proyecto,
																																									mpr.pro_nombre_comercial");

							return $sql_ver_documentos_emision_pago_detalles;

				} ?>

				<?php function forma_pago($conexion){

							$sql_forma_pago = $conexion -> query("select * from tipo_movimiento_bancario where id_tipo_movimiento_bancario in(8, 9, 4, 10, 11, 6,12)");

							return $sql_forma_pago;
				}?>

<?php function movimiento_bancario_cuenta_documento($conexion, $id_proyecto){

				$sql_mb_cuenta = $conexion ->query("select
																						  cbb.id_cuenta_bancaria,
																						  mp.proy_nombre_proyecto,
																						  mb.banc_nombre_banco,
																						  cbb.cta_numero_cuenta,
																						  (select
																							(SUM(CASE WHEN mbo.id_tipo_movimiento = 2 THEN mbo.mb_monto ELSE 0 END) +
																							SUM(CASE WHEN mbo.id_tipo_movimiento = 3 THEN mbo.mb_monto ELSE 0 END) +
																							SUM(CASE WHEN mbo.id_tipo_movimiento = 5 THEN mbo.mb_monto ELSE 0 END) +
																							SUM(CASE WHEN mbo.id_tipo_movimiento = 19 THEN mbo.mb_monto ELSE 0 END) +
																							SUM(CASE WHEN mbo.id_tipo_movimiento = 20 THEN mbo.mb_monto ELSE 0 END) +
																							SUM(CASE WHEN mbo.id_tipo_movimiento = 21 THEN mbo.mb_monto ELSE 0 END) +
																							SUM(CASE WHEN mbo.id_tipo_movimiento = 22 THEN mbo.mb_monto ELSE 0 END) +
																							SUM(CASE WHEN mbo.id_tipo_movimiento = 13 THEN mbo.mb_monto ELSE 0 END) +
																							SUM(CASE WHEN mbo.id_tipo_movimiento = 14 THEN mbo.mb_monto ELSE 0 END) +
																							SUM(CASE WHEN mbo.id_tipo_movimiento = 17 THEN mbo.mb_monto ELSE 0 END)) -
																							(SUM(CASE WHEN mbo.id_tipo_movimiento = 1 THEN mbo.mb_monto ELSE 0 END) +
																							SUM(CASE WHEN mbo.id_tipo_movimiento = 4 THEN mbo.mb_monto ELSE 0 END) +
																							SUM(CASE WHEN mbo.id_tipo_movimiento = 6 THEN mbo.mb_monto ELSE 0 END) +
																							SUM(CASE WHEN mbo.id_tipo_movimiento = 7 THEN mbo.mb_monto ELSE 0 END) +
																							SUM(CASE WHEN mbo.id_tipo_movimiento = 18 THEN mbo.mb_monto ELSE 0 END) +
																							SUM(CASE WHEN mbo.id_tipo_movimiento = 11 THEN mbo.mb_monto ELSE 0 END) +
																							SUM(CASE WHEN mbo.id_tipo_movimiento = 8  THEN mbo.mb_monto ELSE 0 END)) as total
																							from maestro_empresa me
																							inner join maestro_proyectos mp on me.id_empresa = mp.id_empresa
																							inner join cuentas_bancarias cb on mp.id_empresa = cb.cta_id_empresa
																							inner join maestro_bancos mb on cb.cta_id_banco = mb.id_bancos
																							inner join movimiento_bancario mbo on cb.id_cuenta_bancaria = mbo.id_cuenta
																							inner join tipo_movimiento_bancario tmb on mbo.id_tipo_movimiento = tmb.id_tipo_movimiento_bancario
																							where
																							cb.id_cuenta_bancaria = cbb.id_cuenta_bancaria) as monto
																						from maestro_empresa me
																						  inner join maestro_proyectos mp on me.id_empresa = mp.id_empresa
																						  inner join cuentas_bancarias cbb on me.id_empresa = cbb.cta_id_empresa
																						  inner join maestro_bancos mb on cbb.cta_id_banco = mb.id_bancos
																						where
																						mp.id_proyecto = '".$id_proyecto."'
																						and
																						cbb.cta_estado = 1");

										return $sql_mb_cuenta;

} ?>

				<?php 	function monto_restante($conexion, $id_documento_partida){

								$sql_suma_restant = $conexion -> query("select sum(mb_monto) as monto_restante from movimiento_bancario where id_partida_documento = '".$id_documento_partida."'");
								while($suma_restante = $sql_suma_restant -> fetch_array()){
											$sr = $suma_restante['monto_restante'];
								}
								return $sr;
				} ?>

				<?php 	function update_documentos_pagados($conexion, $id_documento){

								$sql_update_documento = $conexion -> query("update partida_documento set pd_stat = 2 where id = '".$id_documento."' and pd_stat =1");

				} ?>

				<?php 	function ver_documentos_pagos($conexion2){

								/* para hacer update a esta funcion, se necesita sacar el id */

								/*$sql_ver_documentos = $conexion2 -> query("SELECT
																																SUM(mb_monto) as suma_monto,
																														    id_unico_insert,
																														    mb_descripcion,
																														    COUNT(*) Total,
																																id_proveedor,
																																id_proyecto,
																														    (select pro_nombre_comercial from maestro_proveedores mp where mp.id_proveedores = mb.id_proveedor) as proveedor
																														FROM
																															movimiento_bancario mb
																														where
																															id_unico_insert IS NOT NULL
																														and
																															id_unico_insert <> ''
																														and
																															mb.mb_stat = 1
																														GROUP BY
																															id_unico_insert,
																															mb_descripcion
																														HAVING Total >= 1");*/

								$sql_ver_documentos = $conexion2 -> query("select
																														pd.pd_fecha_emision,
																														(select pro_nombre_comercial from maestro_proveedores where id_proveedores = pd.id_proveedor) as pro_nombre_comercial,
																														(select ven_nombre from maestro_vendedores where id_vendedor = pd.id_vendedor) as vendedor,
																														pd.pd_descripcion,
																														pd.pd_monto_total,
																														pd.pd_monto_abonado,
																														ms.st_nombre,
																														ms.st_numero,
																														(select count(*) from partida_documento_abono pda where pd.id_partida = pda.id_partida) as contar,
																														case pd.pd_stat
																														when 13 then 'Sin pagar'
																														when 14 then 'Pagado'
																														when 15 then 'Abonado'
																														when 16 then 'Anulado'
																														end as estado,
																														pd.id_proveedor,
																														pd.id_partida
																														from
																														partida_documento pd
																														inner join
																														maestro_status ms on ms.st_numero = pd.pd_stat");

								return $sql_ver_documentos;
				} ?>

				<?php 	function ver_documentos_detalles_pagos($conexion, $id_proyecto, $id_proveedor){

								$sql_ver_documentos_emision_pago = $conexion -> query("select
																																				  pd.*,
																																			    mproy.proy_nombre_proyecto,
																																				  mp.p_nombre,
																																			    mpr.pro_nombre_comercial,
																																			    td.nombre,
																																					ms.st_nombre
																																			 from partida_documento pd inner join maestro_partidas mp on pd.id_partida = mp.id
																																									  						 inner join maestro_proveedores mpr on pd.id_proveedor = mpr.id_proveedores
																																			                           inner join tipo_documentos td on pd.tipo_documento = td.id
																																			                           inner join maestro_proyectos mproy on mproy.id_proyecto = mp.id_proyecto
																																																 inner join maestro_status ms on pd.pd_stat = ms.st_numero
																																					where
																																					mproy.id_proyecto = '".$id_proyecto."'
																																					and
																																					pd.id_proveedor = '".$id_proveedor."'");

								return $sql_ver_documentos_emision_pago;

					} ?>

			<?php 	function contar_cuotas($conexion, $id_cuotas){

							$sql = $conexion -> query("select
																					count(*) as contar
																				 from
																				  maestro_cuotas
																				 where
																				  id_contrato_venta = '".$id_cuotas."'");
							while($c = $sql->fetch_array()){
								return $c['contar'];
							}

			} ?>

<?php 	function reporte1_ver_proyecto($conexion){

				$sql = $conexion -> query("select
																	 mp.id_proyecto,
																	 mp.proy_nombre_proyecto
																	 from
																	 maestro_proyectos mp inner join maestro_ventas mv on mp.id_proyecto = mv.id_proyecto
																						  inner join maestro_cuotas mc on mc.id_contrato_venta = mv.id_venta
																	group by
																	 mp.id_proyecto,
																	 mp.proy_nombre_proyecto");
				return $sql;

}?>

<?php function ver_listado_reporte1($conexion, $id, $id_cliente, $fechaCreacion1, $fechaCreacion2){

				$where = "";
				if ($fechaCreacion1 != ''){ $where .= " and mv.fecha_venta >= '$fechaCreacion1'"; }else{ $where .= ""; }
				if ($fechaCreacion2 != ''){ $where .= " and mv.fecha_venta <= '$fechaCreacion2'"; }else{ $where .= ""; }

				$sql = $conexion -> query("select
																		mcl.cl_nombre,
																		mcl.cl_apellido,
																		mi.mi_nombre,
																		mi.mi_modelo,
																		mi.mi_observaciones,
																		mv.id_venta,
																		DATE_FORMAT(mv.fecha_venta, '%d-%m-%Y') as fecha_venta
																		from
																		maestro_clientes mcl inner join maestro_ventas mv on mcl.id_cliente = mv.id_cliente
																							 					 inner join maestro_inmuebles mi on mv.id_inmueble = mi.id_inmueble
																						     	 			 inner join maestro_proyectos mp on mp.id_proyecto = mv.id_proyecto
																	 where
																	 mp.id_proyecto = '$id'
																	 and
																	 mv.id_cliente = '$id_cliente'
																	 $where");

				return $sql;

} ?>

<?php
function seleccionar_proyecto($conexion){

				$sql_proyecto = $conexion->query("select
																			mp.id_proyecto,
																			mp.proy_nombre_proyecto
																		from
																			maestro_inmuebles mi inner join maestro_proyectos mp on mi.id_proyecto =  mp.id_proyecto
																			group by mp.proy_nombre_proyecto, mp.id_proyecto");

				return $sql_proyecto;

}

function reporte_2($conexion, $id_proyecto){

		 $sql_reporte_2 = $conexion->query('select
																				mi_nombre,
																			    mi_precio_real,
																			    (select
																					CONCAT(cl_nombre," ",cl_apellido)
																				 from
																					maestro_clientes mc inner join maestro_ventas mv on mc.id_cliente = mv.id_cliente
																				 where
																					mv.id_inmueble = maestro_inmuebles.id_inmueble) as nombre,
																				gi_nombre_grupo_inmueble,
																			    (select SUM(mc_monto_abonado)
																					from maestro_cuotas
																				 where
																					maestro_cuotas.id_inmueble = maestro_inmuebles.id_inmueble) as monto_cobrado,
																				(select SUM(mc_monto)
																					from maestro_cuotas
																				 where
																					maestro_cuotas.id_inmueble = maestro_inmuebles.id_inmueble) as monto_vendido,
																			    (select SUM(mc_monto)
																					from maestro_cuotas
																				 where
																					maestro_cuotas.id_inmueble = maestro_inmuebles.id_inmueble and maestro_cuotas.mc_fecha_vencimiento > now()) as monto_vencido,
																				((select SUM(mc_monto)
																					from maestro_cuotas
																				 where
																					maestro_cuotas.id_inmueble = maestro_inmuebles.id_inmueble) - (select SUM(mc_monto_abonado)
																					from maestro_cuotas
																				 where
																					maestro_cuotas.id_inmueble = maestro_inmuebles.id_inmueble)) as monto_restante
																			from maestro_inmuebles inner join grupo_inmuebles on grupo_inmuebles.id_grupo_inmuebles =  maestro_inmuebles.id_grupo_inmuebles
																			where
																				maestro_inmuebles.id_proyecto ='.$id_proyecto);

						return $sql_reporte_2;


}

				function reporte_3($conexion, $id_proyecto){

							$sql_reporte_3 = $conexion -> query("select
																									    mp.proy_nombre_proyecto,
																									    (select
																											gi_nombre_grupo_inmueble
																										 from maestro_inmuebles mi inner join grupo_inmuebles gi on mi.id_grupo_inmuebles = gi.id_grupo_inmuebles
																									    where
																											mi.id_inmueble = mv.id_inmueble) as grupo_inmueble,
																									    mc.cl_nombre,
																									    mc.cl_apellido,
																									    mvv.ven_nombre,
																									    mvv.ven_apellido,
																											mv.id_venta,
																											DATE_FORMAT(cv.cv_fecha_hora, '%d-%m-%Y') as cv_fecha_hora
																									from comisiones_vendedores cv
																										inner join maestro_ventas mv on mv.id_venta = cv.id_contrato_venta
																										inner join maestro_proyectos mp on mp.id_proyecto = mv.id_proyecto
																										inner join maestro_clientes mc on mv.id_cliente = mc.id_cliente
																										inner join maestro_vendedores mvv on mvv.id_vendedor = cv.id_vendedor
																									where
																									 	mp.id_proyecto = '".$id_proyecto."'
																										group by
																										mp.proy_nombre_proyecto,
																										(select
																										gi_nombre_grupo_inmueble
																									 from maestro_inmuebles mi inner join grupo_inmuebles gi on mi.id_grupo_inmuebles = gi.id_grupo_inmuebles
																										where
																										mi.id_inmueble = mv.id_inmueble),
																										mc.cl_nombre,
																										mc.cl_apellido,
																										mvv.ven_nombre,
																										mvv.ven_apellido,
																										mv.id_venta");

							return $sql_reporte_3;

				}

				function reporte_3_seleccionar_proyecto($conexion){

							$sql_reporte_3_select = $conexion -> query("select
																														mp.id_proyecto,
																														mp.proy_nombre_proyecto
																													from comisiones_vendedores cv
																														inner join maestro_ventas mv on mv.id_venta = cv.id_contrato_venta
																														inner join maestro_proyectos mp on mp.id_proyecto = mv.id_proyecto
																														inner join maestro_clientes mc on mv.id_cliente = mc.id_cliente
																														inner join maestro_proveedores mvv on mvv.id_proveedores = cv.id_vendedor
																													group by mp.proy_nombre_proyecto");

							return $sql_reporte_3_select;

				}

?>

<?php 	function reporte_4_seleccionar_proyecto($conexion){

							$sql_reporte_4_select = $conexion ->query("select
																													mp.id_proyecto,
																													mp.proy_nombre_proyecto
																												from maestro_clientes cl
																													inner join maestro_ventas mv  on cl.id_cliente = mv.id_cliente
																													inner join maestro_cuotas mcc on mcc.id_contrato_venta = mv.id_venta
																													inner join tipo_cuota tc on tc.id_tipo_cuota = mcc.id_tipo_cuota
																													inner join maestro_proyectos mp on mp.id_proyecto = mcc.id_proyecto
																												where
																													(select sum(mc_monto) from maestro_cuotas mc where mv.id_venta = mc.id_contrato_venta)
																													<>
																													(select sum(mc_monto_abonado) from maestro_cuotas mc where mv.id_venta = mc.id_contrato_venta)
																												group by
																													mp.proy_nombre_proyecto,
																													mp.id_proyecto");

							return $sql_reporte_4_select;

} ?>

<?php 	function reporte_4($conexion, $id_proyecto){

							$sql_reporte_4 = $conexion ->query("select
																									cl.cl_nombre,
																									cl.cl_apellido,
																									cl.cl_identificacion,
																									cl.cl_telefono_1,
																									cl.cl_telefono_2,
																									((select sum(mc_monto) from maestro_cuotas mc where mv.id_venta = mc.id_contrato_venta) -
																									(select sum(mc_monto_abonado) from maestro_cuotas mc where mv.id_venta = mc.id_contrato_venta)) as monto_restante,
																									mp.proy_nombre_proyecto,
																									DATE_FORMAT(mv.fecha_venta, '%d-%m-%Y') as fecha_venta
																									from maestro_clientes cl inner join maestro_ventas mv  on cl.id_cliente = mv.id_cliente
																															 inner join maestro_cuotas mcc on mcc.id_contrato_venta = mv.id_venta
																									             inner join tipo_cuota tc on tc.id_tipo_cuota = mcc.id_tipo_cuota
																									             inner join maestro_proyectos mp on mp.id_proyecto = mcc.id_proyecto
																									where
																									  (select sum(mc_monto) from maestro_cuotas mc where mv.id_venta = mc.id_contrato_venta)
																										<>
																										(select sum(mc_monto_abonado) from maestro_cuotas mc where mv.id_venta = mc.id_contrato_venta)
																									  and
																									  mp.id_proyecto = '".$id_proyecto."'
																									  group by
																									  cl.cl_nombre,
																										cl.cl_apellido,
																										cl.cl_identificacion,
																										cl.cl_telefono_1,
																										cl.cl_telefono_2,
																										((select sum(mc_monto) from maestro_cuotas mc where mv.id_venta = mc.id_contrato_venta) -
																										(select sum(mc_monto_abonado) from maestro_cuotas mc where mv.id_venta = mc.id_contrato_venta)),
																										mv.fecha_venta");

							return $sql_reporte_4;

} ?>

<?php  function reporte_5_select_proyecto($conexion){

					$sql_reporte_5_select_proyecto = $conexion -> query("select
																																mp.id_proyecto,
																																mp.proy_nombre_proyecto
																																from
																																maestro_inmuebles mi inner join grupo_inmuebles gi on mi.id_grupo_inmuebles = gi.id_grupo_inmuebles
																																					 					 inner join maestro_ventas mv on mv.id_inmueble = mi.id_inmueble
																																                     inner join maestro_clientes mc on mc.id_cliente = mv.id_cliente
																																                     inner join comisiones_vendedores cv on cv.id_contrato_venta = mv.id_venta
																																                     inner join maestro_vendedores mvd on mvd.id_vendedor = cv.id_vendedor
																																                     inner join maestro_proyectos mp on mp.id_proyecto = mv.id_proyecto");

					return $sql_reporte_5_select_proyecto;


} ?>

<?php  function reporte_5($conexion, $id_proyecto){

					$sql_reporte_5 = $conexion -> query("select
																								mi.id_inmueble,
																								mi.mi_nombre,
																								gi.gi_nombre_grupo_inmueble,
																								DATE_FORMAT(mv.fecha_venta, '%d-%m-%Y') as fecha_venta,
																								mv.mv_precio_venta,
																								mc.cl_nombre,
																								mc.cl_apellido,
																								cv.cv_porcentaje_comision,
																								mvd.ven_nombre,
																								mvd.ven_apellido,
																								((mv.mv_precio_venta * cv_porcentaje_comision)/100) as monto_porcentaje
																								from
																								maestro_inmuebles mi inner join grupo_inmuebles gi on mi.id_grupo_inmuebles = gi.id_grupo_inmuebles
																													 					 inner join maestro_ventas mv on mv.id_inmueble = mi.id_inmueble
																													 				 	 inner join maestro_clientes mc on mc.id_cliente = mv.id_cliente
																													   		 		 inner join comisiones_vendedores cv on cv.id_contrato_venta = mv.id_venta
																													 				 	 inner join maestro_vendedores mvd on mvd.id_vendedor = cv.id_vendedor
																								where
																								mv.id_proyecto = '".$id_proyecto."'");

					return $sql_reporte_5;
} ?>

<?php function ver_cheques_emitidos($conexion){

			$sql_ver_cheques = $conexion -> query("select * from cheques_emitidos");
			return $sql_ver_cheques;

} ?>

<?php 	function listado_tipo_pago($conexion){

		$sql_listado_tipo_abono = $conexion -> query("select * from tipo_pago_abono where stat = 1");

		return $sql_listado_tipo_abono;

	} ?>

	<?php 	function listado_tipo_pago_abono($conexion){

			$sql_listado_tipo_abono = $conexion -> query("select * from tipo_movimiento_bancario
																										where
																										tmb_stat = 1
																										and
																										id_tipo_movimiento_bancario in(14, 13, 15, 16, 23, 17, 22)");

			return $sql_listado_tipo_abono;

		} ?>

		<?php 	function cuenta_receptora($conexion, $id_proyecto){

						$sql_cuenta_receptora = $conexion -> query("SELECT
																												cb.id_cuenta_bancaria,
																												mp.proy_nombre_proyecto,
																												mb.banc_nombre_banco,
																												cb.cta_numero_cuenta
																												FROM cuentas_bancarias cb
																												inner join maestro_bancos mb on cb.cta_id_banco = mb.id_bancos
																												inner join maestro_empresa me on me.id_empresa = cb.cta_id_empresa
																												inner join maestro_proyectos mp on mp.id_empresa = me.id_empresa
																												where
																												mp.id_proyecto = '".$id_proyecto."'");

						return $sql_cuenta_receptora;

		} ?>

	<?php 	function numero_abono($conexion, $id_madre){

					$sql_numero_abono = $conexion -> query("SELECT
																									COUNT(*) as contar
																									FROM
																									maestro_cuota_abono
																									WHERE
																									mca_id_cuota_madre = '".$id_madre."'");
					while ($list = $sql_numero_abono -> fetch_array()){
								 $reslt_l = $list['contar'];
					}
					if($reslt_l == 0){
						return 1;
					}else{
						$sql_c = $conexion -> query("SELECT MAX(mca_numero)+1 AS id FROM maestro_cuota_abono WHERE mca_id_cuota_madre = $id_madre");
			      while($lista_c = $sql_c->fetch_array()){
			             $max_numero_cuota = $lista_c['id'];
			      }
						return $max_numero_cuota;
					}

			} ?>

<?php 	function suma_monto_cuota_abonado($conexion, $id_cuota){

				$sql_suma = $conexion -> query("SELECT SUM(monto_abonado) as suma from maestro_cuota_abono WHERE mca_id_cuota_madre = '".$id_cuota."'");
				while ($l = $sql_suma -> fetch_array()){
					    return $l['suma'];
				}
} ?>

<?php 	function cuotas_abonadas_documento_venta($conexion, $id_documento_venta){

				$sql_abonos = $conexion -> query("SELECT
																					mca.id,
																					mca.mca_numero,
																					mca.mca_id_tipo_abono,
																					tmb.tmb_nombre,
																					mca.referencia_abono_cuota,
																					mca.cuenta_receptora,
																					(select  CONCAT_WS(' ', banc_nombre_banco, cb.cta_numero_cuenta) from cuentas_bancarias cb
																					inner join maestro_bancos mb on cb.cta_id_banco = mb.id_bancos
																					where cb.id_cuenta_bancaria = mca.cuenta_receptora) as cuenta_banco,
																					mca.fecha,
																					mca.descripcion,
																					mca.monto_documento,
																					mca.monto_abonado
																					from maestro_cuota_abono mca
																					inner join tipo_movimiento_bancario tmb on tmb.id_tipo_movimiento_bancario = mca.mca_id_tipo_abono
																					where
																					mca.mca_id_cuota_madre ='".$id_documento_venta."'");
					return $sql_abonos;
} ?>

<?php 	function estado_cuentas_clientes($conexion){

				$sql= $conexion -> query("select
																	mcl.id_cliente,
																	mcl.cl_nombre,
																	mcl.cl_apellido
																	from maestro_cuotas mc inner join tipo_cuota tc on mc.id_tipo_cuota = tc.id_tipo_cuota
																	inner join maestro_ventas mv on mc.id_contrato_venta = mv.id_venta
																	inner join maestro_clientes mcl on mv.id_cliente = mcl.id_cliente
																	inner join maestro_inmuebles mi on mc.id_inmueble = mi.id_inmueble
																	inner join maestro_proyectos mp on mp.id_proyecto = mc.id_proyecto
																	inner join grupo_inmuebles gi on gi.id_grupo_inmuebles = mc.id_grupo
																	group by
																	mcl.id_cliente,
																	mcl.cl_nombre,
																	mcl.cl_apellido");

					return $sql;

} ?>

	<?php 	function factura_proveedor_id($conexion, $id_factura){

					$sql = $conexion-> query("select
																			pd.*,
																			mproy.proy_nombre_proyecto,
																			mp.p_nombre,
																			mpr.pro_nombre_comercial,
																			td.nombre,
																			ms.st_nombre,
																			mproy.id_proyecto
																	 from partida_documento pd inner join maestro_partidas mp on pd.id_partida = mp.id
																														 inner join maestro_proveedores mpr on pd.id_proveedor = mpr.id_proveedores
																														 inner join tipo_documentos td on pd.tipo_documento = td.id
																														 inner join maestro_proyectos mproy on mproy.id_proyecto = mp.id_proyecto
																														 inner join maestro_status ms on pd.pd_stat = ms.st_numero
																			where
																			pd.id = '".$id_factura."'
																			and
																			pd.pd_stat in (13, 14, 15, 16)");

					return $sql;

	} ?>

	<?php 	function numero_abono_factura($conexion, $id_factura){

					$sql_numero_abono = $conexion -> query("SELECT
																									COUNT(*) as contar
																									FROM
																									partida_documento_abono
																									WHERE
																									id_partida_documento = '".$id_factura."'");
					while ($list = $sql_numero_abono -> fetch_array()){
								 $reslt_l = $list['contar'];
					}
					if($reslt_l == 0){
						return 1;
					}else{
						$sql_c = $conexion -> query("SELECT MAX(numero)+1 AS id FROM partida_documento_abono WHERE id_partida_documento = $id_factura");
						while($lista_c = $sql_c->fetch_array()){
									 $max_numero_cuota = $lista_c['id'];
						}
						return $max_numero_cuota;
					}

			} ?>

<?php 	function obtener_numero_cheque($conexion, $id_cuenta){

				$sql_obtener_numero_cheque = $conexion -> query("select
																												 (chq_ultimo_emitido)+1 as chq_ultimo_emitido
																												 from
																												 chequeras
																												 where
																												 chq_id_cuenta_banco = '".$id_cuenta."'");
				while($lis=$sql_obtener_numero_cheque->fetch_array()){
					$ultimo_cheque_emitido = $lis['chq_ultimo_emitido'];
				}

				$ctualizar_secuencia_cheque = $conexion -> query("update
																													chequeras
																													set
																													chq_ultimo_emitido = '".$ultimo_cheque_emitido."'
																													where
 																												  chq_id_cuenta_banco = '".$id_cuenta."'");

				return $ultimo_cheque_emitido;
			}
?>

<?php 	function facturas_abonadas($conexion, $id_factura){

				$sql_facturas_abonadas = $conexion->query("select
																										id,
																										id_tipo_movimiento,
																										tmb.tmb_nombre,
																										fecha,
																										numero,
																										monto,
																										descricion,
																										id_cuenta,
																										cb.cta_numero_cuenta,
																										pda.stat,
																										pda.id_tipo_movimiento,
																										pda.numero_cheque
																										from partida_documento_abono pda
																										inner join tipo_movimiento_bancario tmb on pda.id_tipo_movimiento = tmb.id_tipo_movimiento_bancario
																										inner join cuentas_bancarias cb on cb.id_cuenta_bancaria = pda.id_cuenta
																										where
																										pda.id_partida_documento = '".$id_factura."'");

				return $sql_facturas_abonadas;
} ?>

<?php 	function crear_facturas($conexion){

				$sql_crear_facturas = $conexion -> query("SELECT
																										mp.id,
																									(select
																										mpy.proy_nombre_proyecto
																									 from
																										maestro_proyectos mpy
																									 where
																										mpy.id_proyecto = mp.id_proyecto) AS proyecto,
																										mp.p_nombre
																									 FROM
																										maestro_partidas mp
																									 WHERE
																										mp.p_monto <> mp.p_ejecutado
																									 AND
																										mp.p_monto <> mp.p_reservado
																									 AND
																										mp.id_padre is not null");

				return $sql_crear_facturas;

}  ?>

<?php 	function ver_cuentas_movimientos_filtro($conexion){

				$sql_filtro = $conexion->query("select
																				cbb.id_cuenta_bancaria,
																				mp.proy_nombre_proyecto,
																				mb.banc_nombre_banco,
																				cbb.cta_numero_cuenta
																				from maestro_empresa me
																				inner join maestro_proyectos mp on me.id_empresa = mp.id_empresa
																				inner join cuentas_bancarias cbb on me.id_empresa = cbb.cta_id_empresa
																				inner join maestro_bancos mb on cbb.cta_id_banco = mb.id_bancos");

				return $sql_filtro;

} ?>

<?php 	function ver_movimientos_bancarios_filtrados($conexion, $id_cuenta, $tipo, $id_tipo_movimiento, $numero, $desde, $hasta, $anulado, $cheque_directo, $referencia){

				if($id_cuenta != 0){$condicion1 = "id_cuenta_bancaria = '".$id_cuenta."'";}else{$condicion1 = "";}
				if($id_tipo_movimiento != 0){$condicion2 = " AND mbo.id_tipo_movimiento = '".$id_tipo_movimiento."'";}else{$condicion2 = "";}
				if($numero != 0){$condicion3 = " AND mbo.mb_referencia_numero = '".$numero."'";}else{$condicion3 = "";}
				if($desde != '' && $hasta != ''){$condicion4 = " AND mbo.mb_fecha BETWEEN '".$desde."' AND '".$hasta."'";}else{$condicion4 = "";}
				if($anulado != 0){$condicion5 = " AND mbo.mb_stat = 12";}else{$condicion5 = "";}
				if($cheque_directo != 0){$condicion6 = " AND mbo.cheque_directo = '".$cheque_directo."'";}else{$condicion6 = "";}
				if($referencia != ""){ $condicion7 =" AND mbo.id_movimiento_bancario =".$referencia; }else{$condicion7 =""; }

				$condicion = $condicion1.$condicion2.$condicion3.$condicion4.$condicion5.$condicion6.$condicion7;

				$sql_ver_movimiento_filtro = $conexion -> query("select
																									cb.id_cuenta_bancaria,
																									mp.proy_nombre_proyecto,
																									mb.banc_nombre_banco,
																									cb.cta_numero_cuenta,
																									mbo.mb_fecha,
																									mbo.mb_monto,
																									mbo.mb_descripcion,
																									mbo.mb_stat,
																									mbo.mb_referencia_numero,
																									mbo.id_tipo_movimiento,
																									mbo.id_movimiento_bancario,
																								  tmb.tmb_nombre
																								 from maestro_empresa me
																								  inner join maestro_proyectos mp on me.id_empresa = mp.id_empresa
																								  inner join cuentas_bancarias cb on me.id_empresa = cb.cta_id_empresa
																								  inner join maestro_bancos mb on cb.cta_id_banco = mb.id_bancos
																								  inner join movimiento_bancario mbo on cb.id_cuenta_bancaria = mbo.id_cuenta
																								  inner join tipo_movimiento_bancario tmb on mbo.id_tipo_movimiento = tmb.id_tipo_movimiento_bancario
																									where
																									$condicion");

				return $sql_ver_movimiento_filtro;

} ?>

<?php 	function ver_facturas($conexion, $id_documento, $partida, $proveedor, $tipo_documento, $femision_inicial, $femision_final, $fvenc_inicial, $fvenc_final, $status){

				if($id_documento != ''){$condicion1 = " AND pd.id = '".$id_documento."'";}else{$condicion1 = "";}
				if($partida != ''){$condicion2 = "mp.id_proyecto = '".$partida."'";}else{$condicion2 = "";}
				if($proveedor != ''){$condicion3 = " AND pd.id_proveedor = '".$proveedor."'";}else{$condicion3 = "";}

				/*if($desde != '' && $hasta != ''){$condicion4 = " AND mbo.mb_fecha BETWEEN '".$desde."' AND '".$hasta."'";}else{$condicion4 = "";}*/
				if($tipo_documento != ''){$condicion5 = " AND pd.tipo_documento = '".$tipo_documento."'";}else{$condicion5 = "";}
				if($femision_inicial != '' && $femision_final != ''){
					$condicion4 = " AND pd.pd_fecha_emision >= DATE_FORMAT(STR_TO_DATE('$femision_inicial', '%d-%m-%Y'), '%Y-%m-%d')
									AND pd.pd_fecha_emision <= DATE_FORMAT(STR_TO_DATE('$femision_final', '%d-%m-%Y'), '%Y-%m-%d')";}else{$condicion4 = "";}
				if($fvenc_inicial != '' && $fvenc_final != ''){
					$condicion6 = " AND pd.pd_fecha_vencimiento >= DATE_FORMAT(STR_TO_DATE('$fvenc_inicial', '%d-%m-%Y'), '%Y-%m-%d')
									AND pd.pd_fecha_vencimiento <= DATE_FORMAT(STR_TO_DATE('$fvenc_final', '%d-%m-%Y'), '%Y-%m-%d')";
				}else{$condicion6 = "";}
				if($status != ''){$condicion7 = " AND pd.pd_stat = '".$status."'";}else{$condicion7 = "";}

				$condicion = $condicion1.$condicion2.$condicion3.$condicion4.$condicion5.$condicion6.$condicion7;

				$sql_ver_documentos_partidas = $conexion -> query("select
																														  pd.*,
																													    mproy.proy_nombre_proyecto,
																														  mp.p_nombre,
																													    mpr.pro_nombre_comercial,
																													    td.nombre
																													 from partida_documento pd inner join maestro_partidas mp on pd.id_partida = mp.id
																																			  						 inner join maestro_proveedores mpr on pd.id_proveedor = mpr.id_proveedores
																													                           inner join tipo_documentos td on pd.tipo_documento = td.id
																													                           inner join maestro_proyectos mproy on mproy.id_proyecto = mp.id_proyecto
																														where
																														$condicion");

				return $sql_ver_documentos_partidas;

} ?>
<?php 	function ver_pagos_emitidos_filtros($conexion, $id_factura, $id_pago, $id_proyecto, $id_proveedor, $tipo_movimiento, $desde, $hasta, $numero_cheque, $status){

				if($id_proyecto != ''){$condicion1 = " mp.id_proyecto = '".$id_proyecto."'";}else{$condicion1 = "";}
				if($id_proveedor != ''){$condicion2 = " AND pd.id_proveedor = '".$id_proveedor."'";}else{$condicion2 = "";}
				if($id_factura != ''){$condicion3 = " AND pd.id = '".$id_factura."'";}else{$condicion3 = "";}
				if($id_pago != ''){$condicion4 = " AND pda.id = '".$id_pago."'";}else{$condicion4 = "";}
				if($tipo_movimiento != ''){$condicion5 = " AND pda.id_tipo_movimiento = '".$tipo_movimiento."'";}else{$condicion5 = "";}
				if($desde != ''){$condicion6 = " AND pda.fecha BETWEEN '".$desde."' AND '".$hasta."'";}else{$condicion6 = "";}
				if($numero_cheque != ''){$condicion7 = " AND pda.numero_cheque = '".$numero_cheque."'";}else{$condicion7 = "";}
				if($status != ''){$condicion8 = " AND pd.pd_stat = '".$status."'";}else{$condicion8 = "";}

				$condicion = $condicion1.$condicion2.$condicion3.$condicion4.$condicion5.$condicion6.$condicion7.$condicion8;

				$sql_ver_documentos_partidas = $conexion -> query("select
																														pd.*,
																														mproy.proy_nombre_proyecto,
																														mp.p_nombre,
																														mpr.pro_nombre_comercial,
																														td.nombre
																														from
																														partida_documento pd
																														inner join
																														maestro_partidas mp on pd.id_partida = mp.id
																														inner join
																														maestro_proveedores mpr on pd.id_proveedor = mpr.id_proveedores
																														inner join
																														tipo_documentos td on pd.tipo_documento = td.id
																														inner join
																														maestro_proyectos mproy on mproy.id_proyecto = mp.id_proyecto
																														where
																														$condicion");

				return $sql_ver_documentos_partidas;

} ?>

<?php 	function ver_comisiones($conexion){

				$sql_ver_documentos_emision_pago = $conexion -> query("select
																																	pd.*,
																																	mproy.proy_nombre_proyecto,
																																	mp.p_nombre,
																																	mpr.pro_nombre_comercial,
																																	td.nombre,
																																	ms.st_nombre
																															 from partida_documento pd inner join maestro_partidas mp on pd.id_partida = mp.id
																																												 inner join maestro_proveedores mpr on pd.id_proveedor = mpr.id_proveedores
																																												 inner join tipo_documentos td on pd.tipo_documento = td.id
																																												 inner join maestro_proyectos mproy on mproy.id_proyecto = mp.id_proyecto
																																												 inner join maestro_status ms on pd.pd_stat = ms.st_numero
																																where
																																pd.pd_stat in(13, 14, 15)
																																and
																																pd.comision = 1");

				return $sql_ver_documentos_emision_pago;

	} ?>
