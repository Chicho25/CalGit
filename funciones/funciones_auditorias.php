<?php 	function obtener_dispositivo(){

				$tablet_browser = 0;
				$mobile_browser = 0;
				$body_class = 'desktop';

				if (preg_match('/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
				    $tablet_browser++;
				    $body_class = "tablet";
				}

				if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
				    $mobile_browser++;
				    $body_class = "mobile";
				}

				if ((strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml') > 0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
				    $mobile_browser++;
				    $body_class = "mobile";
				}

				$mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
				$mobile_agents = array(
				    'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
				    'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
				    'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
				    'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
				    'newt','noki','palm','pana','pant','phil','play','port','prox',
				    'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
				    'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
				    'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
				    'wapr','webc','winw','winw','xda ','xda-');

				if (in_array($mobile_ua,$mobile_agents)) {
				    $mobile_browser++;
				}

				if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'opera mini') > 0) {
				    $mobile_browser++;
				    //Check for tablets on opera mini alternative headers
				    $stock_ua = strtolower(isset($_SERVER['HTTP_X_OPERAMINI_PHONE_UA'])?$_SERVER['HTTP_X_OPERAMINI_PHONE_UA']:(isset($_SERVER['HTTP_DEVICE_STOCK_UA'])?$_SERVER['HTTP_DEVICE_STOCK_UA']:''));
				    if (preg_match('/(tablet|ipad|playbook)|(android(?!.*mobile))/i', $stock_ua)) {
				      $tablet_browser++;
				    }
				}
				if ($tablet_browser > 0) {
				// Si es tablet has lo que necesites
				   $tablet = 'Tablet';
				   return $tablet;
				}
				else if ($mobile_browser > 0) {
				// Si es dispositivo mobil has lo que necesites
				   $celular = 'Telefono Celular';
				   return $celular;
				}
				else {
				// Si es ordenador de escritorio has lo que necesites
				   $desktop = 'PC-Desktop';
				   return $desktop;
				}

			}

	?>

<?php 	function ObtenerIP(){

	       $ip = "";
	       if(isset($_SERVER))
	       {
	           if (!empty($_SERVER['HTTP_CLIENT_IP']))
	           {
	               $ip=$_SERVER['HTTP_CLIENT_IP'];
	            }
	            elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
	            {
	                $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
	            }
	            else
	            {
	                $ip=$_SERVER['REMOTE_ADDR'];
	            }
	       }
	       else
	       {
	            if ( getenv( 'HTTP_CLIENT_IP' ) )
	            {
	                $ip = getenv( 'HTTP_CLIENT_IP' );
	            }
	            elseif( getenv( 'HTTP_X_FORWARDED_FOR' ) )
	            {
	                $ip = getenv( 'HTTP_X_FORWARDED_FOR' );
	            }
	            else
	            {
	                $ip = getenv( 'REMOTE_ADDR' );
	            }
	       }
	        // En algunos casos muy raros la ip es devuelta repetida dos veces separada por coma
	       if(strstr($ip,','))
	       {
	            $ip = array_shift(explode(',',$ip));
	       }
	       return $ip;
	    }

	?>

<?php 	function insertar_log_seguimiento($conexion, $ip, $dispositivo_acceso, $lugar_mapa, $usua_log){

				$sql_inser_log_seg = $conexion -> query("insert into auditoria_mapa_seguimiento(aums_ip,
																								 aums_dispositivo_acceso,
																								 aums_lugar_mapa,
																								 aums_usua_log
																								 )values(
																								 '".$ip."',
																								 '".$dispositivo_acceso."',
																								 '".$lugar_mapa."',
																								 '".$usua_log."')");
	} ?>

<?php 	function auditoria_general($conexion){

				$sql_auditoria_geeral = $conexion ->query("select
														   ams.id_auditoria_mapa_seguimiento,
														   ams.aums_ip,
														   ams.aums_dispositivo_acceso,
														   ams.aums_fecha_hora,
														   amsi.ams_nombre,
														   u.usua_nombre,
														   u.usua_apellido,
														   u.usua_imagen_usuario
														   from
														   auditoria_mapa_seguimiento ams inner join auditoria_mapa_sitio amsi on ams.aums_lugar_mapa = amsi.id_auditoria_mapa_sitio
																					      inner join usuarios u on ams.aums_usua_log = u.id_usuario
														   order by
														   ams.id_auditoria_mapa_seguimiento desc");

				return $sql_auditoria_geeral;

	} ?>

<?php 	function auditoria_usuarios($conexion){

				$sql_auditoria_usuarios = $conexion -> query("select
																	u.usua_nombre,
																	u.usua_apellido,
																	u.usua_imagen_usuario,
																	auu.id_auditoria_usuario,
																	auu.auu_tipo_operacion,
																	auu.auu_fecha_operacion,
																	auu.auu_comentario,
																	auu.auu_id_user,
																	auu.auu_usua_usuario,
																	auu.auu_usua_pass,
																	auu.auu_usua_imagen_usuario,
																	auu.auu_usua_stat,
																	auu.auu_usua_nombre,
																	auu.auu_usua_apellido,
																	acc.auu_roll_acceso
																from
																	auditoria_usuario auu inner join usuarios u on auu.auu_usua_log = u.id_usuario
																						  inner join auditoria_usuario_acceso acc on auu.auu_id_user = acc.auu_id_usuario_acceso
																						  inner join rolles ro on acc.auu_roll_acceso = ro.id_roll
																group by
																	u.usua_nombre,
																	u.usua_apellido,
																	u.usua_imagen_usuario,
																	auu.id_auditoria_usuario,
																	auu.auu_tipo_operacion,
																	auu.auu_fecha_operacion,
																	auu.auu_comentario,
																	auu.auu_id_user,
																	auu.auu_usua_usuario,
																	auu.auu_usua_pass,
																	auu.auu_usua_imagen_usuario,
																	auu.auu_usua_stat,
																	auu.auu_usua_nombre,
																	auu.auu_usua_apellido,
																	acc.auu_roll_acceso
																order by auu.id_auditoria_usuario desc");

				return $sql_auditoria_usuarios;

	} ?>

<?php 	function auditoria_accesos($conexion, $id_usuario, $fecha){

				$sql_crear_usuario_accesos = mysqli_query($conexion, "select * from auditoria_usuario_acceso aua
																					 inner join modulos_app app
																			         on
																			         aua.auu_modulo_acceso = app.id_modulo
																			         where
																			         aua.auu_id_usuario_acceso = '".$id_usuario."'
																			         and
																			         auu_modulo_acceso not in(1, 6, 7)
																			         and
																			         UNIX_TIMESTAMP(aua.auu_fecha_hora) = UNIX_TIMESTAMP('".$fecha."')");

				return $sql_crear_usuario_accesos;

	}?>

<?php 	function auditoria_empresa($conexion){

				$sql_auditoria_empresa = $conexion -> query("select
													    aue.id_auditoria_empresa,
													    aue.aue_fecha_operacion,
													    aue.aue_comentario,
													    aue.aue_id_empresa,
													    aue.aue_empre_nombre_comercial,
													    aue.aue_empre_razon_social,
													    aue.aue_empre_ruc,
													    aue.aue_empre_dv,
													    aue.aue_empre_estado_empresa,
													    aue.aue_empre_empresa_principal,
													    aue.aue_empre_excenta_itbms,
													    aue.aue_empre_email,
													    aue.aue_empre_telefono,
													    u.usua_imagen_usuario,
													    u.usua_nombre,
													    u.usua_apellido
													    from
													    auditoria_empresa aue inner join usuarios u on aue.aue_usua_log = u.id_usuario
													    order by aue.id_auditoria_empresa desc");

			return $sql_auditoria_empresa;

	}?>

<?php 	function auditoria_proyecto($conexion){

				$sql_auditoria_proyecto = $conexion -> query("select
															  	ap.id_auditoria_proyecto,
															  	ap.aup_usua_log,
															  	ap.aup_tipo_operacion,
															  	ap.aup_fecha_operacion,
															  	ap.aup_comentario,
															  	ap.aup_id_proyecto,
															  	ap.aup_nombre_proyecto,
															  	ap.aup_tipo_proyecto,
															  	ap.aup_promotor,
															  	ap.aup_area,
															  	ap.aup_estado,
															  	ap.aup_resolucion_ambiental,
															  	ap.aup_id_empresa,
															  	u.usua_imagen_usuario,
															    u.usua_nombre,
															    u.usua_apellido
															  	from
															  	auditoria_proyecto ap inner join usuarios u on ap.aup_usua_log = u.id_usuario
															  	order by ap.id_auditoria_proyecto desc");

				return $sql_auditoria_proyecto;

		}?>

<?php 	function auditoria_bancos($conexion){

				$sql_auditoria_bancos = $conexion -> query("select
																										ab.id_auditoria_bancos,
																										ab.aub_tipo_operacion,
																										ab.aub_usua_log,
																										ab.aub_fecha_operacion,
																										ab.aub_comentario,
																										ab.aub_id_banco,
																										ab.aub_banc_nombre_banco,
																										ab.aub_stat,
																										u.usua_imagen_usuario,
																										u.usua_nombre,
																										u.usua_apellido
																										from
																										auditoria_banco ab inner join usuarios u on ab.aub_usua_log = u.id_usuario
																										order by ab.id_auditoria_bancos desc");

				return $sql_auditoria_bancos;

		} ?>

<?php 	function auditoria_vendedores($conexion){

				$sql_auditoria_vendedores = $conexion -> query("select
																													av.id_auditoria_vendedoes,
																													av.auv_tipo_operacion,
																													av.auv_usua_log,
																													av.auv_fecha_operacion,
																													av.auv_comentario,
																													av.auv_id_vendedor,
																													av.auv_ven_nombre,
																													av.auv_ven_apellido,
																													av.auv_ven_telefono_1,
																													av.auv_ven_telefono_2,
																													av.auv_ven_identidicacion,
																													av.auv_ven_status,
																													av.auv_ven_email,
																													u.usua_imagen_usuario,
																													u.usua_nombre,
																													u.usua_apellido
																													from
																													auditoria_vendedor av inner join usuarios u on av.auv_usua_log = u.id_usuario
																													order by av.id_auditoria_vendedoes desc");

				return $sql_auditoria_vendedores;

		} ?>

<?php 	function auditoria_clienets($conexion){

				$sql_auditoria_clientes = $conexion -> query("select
																												ac.id_auditoria_clientes,
																												ac.auc_tipo_operacion,
																												ac.auc_usua_log,
																												ac.auc_comentario,
																												ac.auc_id_cliente,
																												ac.auc_nombre,
																												ac.auc_apellido,
																												ac.auc_telefono_1,
																												ac.auc_telefono_2,
																												ac.auc_identificacion,
																												ac.auc_pais,
																												ac.auc_direccion,
																												ac.auc_status,
																												ac.auc_email,
																												ac.auc_fecha_hora,
																												ac.auc_referencia,
																												u.usua_imagen_usuario,
																												u.usua_nombre,
																												u.usua_apellido,
																												mp.ps_nombre_pais
																												from
																												auditoria_clientes ac inner join usuarios u on ac.auc_usua_log = u.id_usuario
																																	  inner join maestro_paises mp on ac.auc_pais = mp.id_paises
																												order by ac.id_auditoria_clientes desc");

				return $sql_auditoria_clientes;

			} ?>

<?php 	function auditoria_inmuebles($conexion){

				$sql_auditoria_inmuebles = $conexion -> query("select
																													ai.id_auditoria_inmueble,
																													ai.aui_tipo_operacion,
																													ai.aui_usua_log,
																													ai.aui_comentario,
																													ai.aui_fecha_hora,
																													ai.aui_id_inmueble,
																													ai.aui_id_grupo_inmuebles,
																													ai.aui_id_tipo_inmuebles,
																													ai.aui_mi_nombre,
																													ai.aui_mi_modelo,
																													ai.aui_mi_area,
																													ai.aui_mi_habitaciones,
																													ai.aui_mi_sanitarios,
																													ai.aui_mi_depositos,
																													ai.aui_mi_estacionamientos,
																													ai.aui_mi_observaciones,
																													ai.aui_mi_precio_venta,
																													ai.aui_mi_precio_oferta,
																													ai.aui_mi_precio_real,
																													ai.aui_mi_disponible,
																													ai.aui_mi_id_partida_comision,
																													ai.aui_mi_porcentaje_comision,
																													ai.aui_mi_status,
																													u.usua_imagen_usuario,
																													u.usua_nombre,
																													u.usua_apellido
																													from
																													auditoria_inmueble ai inner join usuarios u on ai.aui_usua_log = u.id_usuario
																													order by ai.id_auditoria_inmueble desc");

				return $sql_auditoria_inmuebles;

			} ?>

<?php 	function auditoria_proveedores($conexion){

				$sql_auditoria_proveedores = $conexion -> query("select
																													ap.id_auditoria_proveedores,
																													ap.aup_tipo_operacion,
																													ap.aup_usua_log,
																													ap.aup_fecha_hora,
																													ap.aup_comentario,
																													ap.aup_id_proveedores,
																													ap.aup_pro_nombre_comercial,
																													ap.aup_pro_razon_social,
																													ap.aup_pro_ruc,
																													ap.aup_pro_pais,
																													ap.aup_pro_status,
																													ap.aup_pro_telefono_1,
																													ap.aup_pro_telefono_2,
																													ap.aup_pro_descripcion,
																													ap.aup_pro_email,
																													u.usua_imagen_usuario,
																													u.usua_nombre,
																													u.usua_apellido
																													from
																													auditoria_proveedores ap inner join usuarios u on ap.aup_usua_log = u.id_usuario
																													order by ap.id_auditoria_proveedores desc");

				return $sql_auditoria_proveedores;

			} ?>

<?php 	function auditoria_cuentas_bancarias($conexion){

				$sql_au_cb = $conexion -> query("SELECT acb.*,
																					(select mb.banc_nombre_banco from maestro_bancos mb where mb.id_bancos = acb.aucb_cta_id_banco) as banco,
																					(SELECT tdc.tdc_nombre FROM tipo_cuenta tdc WHERE tdc.id_tipo_cuenta = aucb_cta_tipo_cuenta) as tipo_cuenta,
																					(SELECT me.empre_nombre_comercial FROM maestro_empresa me WHERE me.id_empresa = aucb_cta_id_empresa) as empresa,
																					u.usua_imagen_usuario,
																					u.usua_nombre,
																					u.usua_apellido
																				 FROM
																					auditoria_cuenta_bancaria acb INNER JOIN usuarios u ON acb.aucb_usua_log = u.id_usuario");

				return $sql_au_cb;

} ?>

<?php 	function auditoria_movimiento_bancario($conexion){

				$sql_au_mb = $conexion -> query("SELECT amb.*,
																				(SELECT cb.cta_numero_cuenta FROM cuentas_bancarias cb WHERE cb.id_cuenta_bancaria = amb.amb_id_cuenta) as cuenta,
																				(SELECT tmb.tmb_nombre FROM tipo_movimiento_bancario tmb WHERE tmb.id_tipo_movimiento_bancario = amb.amb_id_tipo_movimiento) as tipo_movimiento,
																				u.usua_imagen_usuario,
																				u.usua_nombre,
																				u.usua_apellido
																			 FROM
																				auditoria_movimiento_bancario amb INNER JOIN usuarios u ON amb.amb_log_user = u.id_usuario");

				return $sql_au_mb;

} ?>

<?php 	function auditoria_cheque_directo($conexion){

				$sql_au_chd = $conexion -> query("SELECT achd.*,
																				  (SELECT cb.cta_numero_cuenta FROM cuentas_bancarias cb WHERE cb.id_cuenta_bancaria = achd.auchd_id_cuenta) as cuenta,
																					u.usua_imagen_usuario,
																					u.usua_nombre,
																					u.usua_apellido
																				 FROM
																					auditoria_cheques_directos achd INNER JOIN usuarios u ON achd.auchd_usua_log = u.id_usuario");

				return $sql_au_chd;

} ?>

<?php 	function auditoria_partidas($conexion){

				$sql_au_cp = $conexion -> query("SELECT acp.*,
																					u.usua_imagen_usuario,
																					u.usua_nombre,
																					u.usua_apellido
																				 FROM
																					auditoria_crear_partida acp INNER JOIN usuarios u ON acp.aucp_usua_log = u.id_usuario");

				return $sql_au_cp;

} ?>

<?php 	function auditoria_facturas_documentos($conexion){

				$sql_au_mb = $conexion -> query("SELECT arf.*,
																				(SELECT mpp.p_nombre FROM maestro_partidas mpp WHERE mpp.id = arf.aurf_id_partida) as partida,
																				(SELECT td.nombre FROM tipo_documentos td WHERE td.id = arf.aurf_tipo_documento) as tipo_documento,
																				(SELECT mp.pro_nombre_comercial FROM maestro_proveedores mp WHERE mp.id_proveedores = arf.aurf_id_proveedor) as proveedor,
																				u.usua_imagen_usuario,
																				u.usua_nombre,
																				u.usua_apellido
																			 FROM
																				auditoria_registro_factura arf INNER JOIN usuarios u ON arf.aurf_usua_log = u.id_usuario");

				return $sql_au_mb;

} ?>

<?php 	function auditoria_pago_facturas($conexion){

				$sql_au_pf = $conexion -> query("SELECT
																					apf.*,
																					u.usua_imagen_usuario,
																					u.usua_nombre,
																					u.usua_apellido,
																					(SELECT cb.cta_numero_cuenta FROM cuentas_bancarias cb WHERE cb.id_cuenta_bancaria = apf.aupf_id_cuenta) AS cuentas,
																					(SELECT tmb.tmb_nombre FROM tipo_movimiento_bancario tmb WHERE tmb.id_tipo_movimiento_bancario = apf.aupf_id_tipo_movimiento) AS tipo_movimiento,
																					(SELECT mp.pro_nombre_comercial FROM maestro_proveedores mp WHERE mp.id_proveedores = apf.aupf_id_proveedor) AS proveedor,
																					(SELECT mpp.p_nombre FROM maestro_partidas mpp WHERE mpp.id = apf.aupf_id_partida) as partida,
																					(SELECT mpy.proy_nombre_proyecto FROM maestro_proyectos mpy WHERE mpy.id_proyecto = apf.aupf_id_proyecto) as proyecto
																				 FROM auditoria_pago_facturas apf INNER JOIN usuarios u ON apf.aupf_usua_log = u.id_usuario");

				return $sql_au_pf;

} ?>
