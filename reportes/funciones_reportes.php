<?php

############################ Reporte 1: Estado de cuenta de los clientes ###########################

function numero_cuotas($conexion, $id_contrato_venta){

				$sql_numero_cuotas = $conexion -> query("select count(id_cuota) as contar from maestro_cuotas where id_contrato_venta = '".$id_contrato_venta."'");
				while($lista_contar = $sql_numero_cuotas->fetch_array()){
							$contar = $lista_contar['contar'];
				}

				return $contar;

}

function suma_cuota($conexion, $id_contrato_venta){

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

}

function todos_cuotas_id_contrato($conexion, $id_venta, $fcreacion_inicio, $fcreacion_fin, $fvenc_inicio, $fvenc_fin){
				$wh = "";
				if($fcreacion_inicio == '' && $fcreacion_fin == ''){
					$wh .= "";
				}else{
					$wh .= " AND mc.mc_fecha_creacion_contrato >= DATE_FORMAT(STR_TO_DATE('$fcreacion_inicio', '%d-%m-%Y'), '%Y-%m-%d')
							 AND mc.mc_fecha_creacion_contrato <= DATE_FORMAT(STR_TO_DATE('$fcreacion_fin', '%d-%m-%Y'), '%Y-%m-%d')";

				}
				if($fvenc_inicio == '' && $fvenc_fin == ''){
					$wh .= "";
				}else{
					$wh .= " AND mc.mc_fecha_vencimiento >= DATE_FORMAT(STR_TO_DATE('$fvenc_inicio', '%d-%m-%Y'), '%Y-%m-%d')
							 AND mc.mc_fecha_vencimiento <= DATE_FORMAT(STR_TO_DATE('$fvenc_fin', '%d-%m-%Y'), '%Y-%m-%d')";
				}

				$sql_todos_cuota_id_contrato = $conexion -> query("select
																														mc.id_cuota,
																														tc.tc_nombre_tipo_cuenta,
																														DATE_FORMAT(mc_fecha_vencimiento, '%d - %m - %Y') as mc_fecha_vencimiento,
																														mc.mc_monto,
																														mc.mc_monto_abonado,
																														DATE_FORMAT(mc_fecha_creacion_contrato, '%d - %m - %Y') as mc_fecha_creacion_contrato,
																														mc.mc_descripcion,
																														mcl.cl_nombre,
																														mcl.cl_apellido,
																														mi.mi_nombre,
																														mc_status,
																														mv.mv_precio_venta
																														from maestro_cuotas mc inner join tipo_cuota tc on mc.id_tipo_cuota = tc.id_tipo_cuota
																																			   inner join maestro_ventas mv on mc.id_contrato_venta = mv.id_venta
																																			   inner join maestro_clientes mcl on mv.id_cliente = mcl.id_cliente
																																			   inner join maestro_inmuebles mi on mc.id_inmueble = mi.id_inmueble
																														where
																														mv.id_venta = '".$id_venta."' $wh");

        return $sql_todos_cuota_id_contrato;

}

function obtener_precio_contrato_venta($conexion, $id_venta){

          $sql = $conexion -> query("select mv_precio_venta from maestro_ventas where id_venta = '".$id_venta."'");
          while($r=$sql->fetch_array()){
            $precio = $r['mv_precio_venta'];
          }
          return $precio;

}

function resta_reporte_1($conexion, $id_contrato_ventas){

  $resta =  obtener_precio_contrato_venta($conexion, $id_contrato_ventas) - suma_cuota($conexion, $id_contrato_ventas);

  return $resta;

}

############################ Reporte 2: ventas de inmuebles ###########################

function reporte_2($conexion, $id_proyecto, $tipo, $grupo){


				if($tipo == 2){ $where1 = " and maestro_inmuebles.mi_status in(3,4)";}else{ $where1 = "";}
				if($grupo != ""){ $where2 = " and grupo_inmuebles.id_grupo_inmuebles ='".$grupo."'";}else{$where2 = "";}

				$sql_reporte_2 = $conexion->query('select
																						mi_codigo_imueble,
																						mi_nombre,
																						mi_precio_real,
																						(select
																						CONCAT(cl_nombre," ",cl_apellido)
																						from
																						maestro_clientes mc inner join maestro_ventas mv on mc.id_cliente = mv.id_cliente
																						where
																						mv.id_inmueble = maestro_inmuebles.id_inmueble and maestro_inmuebles.mi_status not in(17) and mv.mv_status not in(17)) as nombre,
																						gi_nombre_grupo_inmueble,
																						(select SUM(mc_monto_abonado)
																						from maestro_cuotas
																						where
																						maestro_cuotas.id_inmueble = maestro_inmuebles.id_inmueble and maestro_inmuebles.mi_status not in(17) and maestro_cuotas.mc_status not in (17)) as monto_cobrado,
																						(select mi_precio_real
																						from maestro_inmuebles min
																						where
																						maestro_inmuebles.id_inmueble = min.id_inmueble and maestro_inmuebles.mi_status in(3, 4) and maestro_inmuebles.mi_status not in(17)) as monto_vendido,
																						(select mi_precio_real
																						from maestro_inmuebles min
																						where
																						 maestro_inmuebles.id_inmueble = min.id_inmueble and maestro_inmuebles.mi_status in(1, 2) and maestro_inmuebles.mi_status not in(17)) as por_vender,

																						(select rv.rv_precio_reserva from inmueble_rv rv where rv.id_inmueble_maestro = maestro_inmuebles.id_inmueble and maestro_inmuebles.mi_status not in(17)) as monto_reservado,

																						(select SUM(mc_monto) - SUM(mc_monto_abonado)
																						from maestro_cuotas
																						where
																						maestro_cuotas.id_inmueble = maestro_inmuebles.id_inmueble and maestro_inmuebles.mi_status not in(17) and maestro_cuotas.mc_status not in (17) and maestro_cuotas.mc_fecha_vencimiento < now()) as monto_vencido,

																						((select SUM(mc_monto)
																						from maestro_cuotas
																						where
																						maestro_cuotas.id_inmueble = maestro_inmuebles.id_inmueble and maestro_cuotas.mc_status not in (17) and maestro_inmuebles.mi_status not in(17)) - (select SUM(mc_monto_abonado)
																						from maestro_cuotas
																						where
																						maestro_cuotas.id_inmueble = maestro_inmuebles.id_inmueble and maestro_cuotas.mc_status not in (17) and maestro_inmuebles.mi_status not in(17))) as monto_restante

																						from maestro_inmuebles inner join grupo_inmuebles on grupo_inmuebles.id_grupo_inmuebles =  maestro_inmuebles.id_grupo_inmuebles
																						where
																						maestro_inmuebles.id_proyecto = '.$id_proyecto.$where1.$where2.'
																						and maestro_inmuebles.mi_status not in(17)
																						order by 1');

						return $sql_reporte_2;


			}

			function reporte_2_2($conexion, $id_proyecto){

			$sql_reporte_2 = $conexion->query("select
gi_nombre_grupo_inmueble,
(select SUM(mc_monto_abonado)
from maestro_cuotas
where
maestro_cuotas.id_grupo = maestro_inmuebles.id_grupo_inmuebles and maestro_inmuebles.mi_status not in(17) and maestro_cuotas.mc_status not in (17)) as monto_cobrado,

(select sum(mi_precio_real)
from maestro_inmuebles min
where
maestro_inmuebles.id_grupo_inmuebles = min.id_grupo_inmuebles and min.mi_status in(3, 4) and maestro_inmuebles.mi_status not in(17)) as monto_vendido,

(select sum(mi_precio_real)
from maestro_inmuebles min
where
maestro_inmuebles.id_grupo_inmuebles = min.id_grupo_inmuebles and min.mi_status in(1, 2) and maestro_inmuebles.mi_status not in(17) and min.mi_status not in(17)) as por_vender,

(select rv.rv_precio_reserva from inmueble_rv rv where rv.id_inmueble_maestro = maestro_inmuebles.id_inmueble) as monto_reservado,
(select SUM(mc_monto) - SUM(mc_monto_abonado)
from maestro_cuotas
where
maestro_cuotas.id_grupo = maestro_inmuebles.id_grupo_inmuebles and maestro_cuotas.mc_fecha_vencimiento < now() and maestro_inmuebles.mi_status not in(17) and maestro_cuotas.mc_status not in(17)) as monto_vencido,
((select SUM(mc_monto)
from maestro_cuotas
where
maestro_cuotas.id_grupo = maestro_inmuebles.id_grupo_inmuebles
and
maestro_cuotas.mc_status not in (17)
and
maestro_inmuebles.mi_status not in(17))
-
(select SUM(mc_monto_abonado)
from maestro_cuotas
where
maestro_cuotas.id_grupo = maestro_inmuebles.id_grupo_inmuebles
and
maestro_inmuebles.mi_status not in(17)
and
maestro_cuotas.mc_status not in(17))) as monto_restante
from maestro_inmuebles inner join grupo_inmuebles on grupo_inmuebles.id_grupo_inmuebles =  maestro_inmuebles.id_grupo_inmuebles
where
maestro_inmuebles.id_proyecto = $id_proyecto
group by
gi_nombre_grupo_inmueble
order by
1");

									return $sql_reporte_2;

						}

#################################### Reporte:3 Ventas y comisiones ###########################################

		function reporte_3($conexion, $id_contrato){

									$sql_reporte_3 = $conexion ->query("select
																									cv.id_comision_vendedor,
																								    mp.proy_nombre_proyecto,
																								    (select
																										gi_nombre_grupo_inmueble
																									 from maestro_inmuebles mi inner join grupo_inmuebles gi on mi.id_grupo_inmuebles = gi.id_grupo_inmuebles
																								     where
																										mi.id_inmueble = mv.id_inmueble) as grupo_inmueble,
																										DATE_FORMAT(cv.cv_fecha_hora, '%d - %m - %Y') as cv_fecha_hora,
																								    mc.cl_nombre,
																								    mc.cl_apellido,
																								    mvv.ven_nombre,
																								    mvv.ven_apellido,
																								    cv_porcentaje_comision,
																								    mv.mv_precio_venta,
																								    ((cv_porcentaje_comision * mv.mv_precio_venta) / 100) as monto_comision
																								from comisiones_vendedores cv
																								inner join maestro_ventas mv on mv.id_venta = cv.id_contrato_venta
																								inner join maestro_proyectos mp on mp.id_proyecto = mv.id_proyecto
																								inner join maestro_clientes mc on mv.id_cliente = mc.id_cliente
																								inner join maestro_vendedores mvv on mvv.id_vendedor = cv.id_vendedor
																								where
																									mv.id_venta = '".$id_contrato."'");
									return $sql_reporte_3;
						}

################################ Reporte:4 Cobranza ##############################################################

function reporte_4($conexion, $id_proyecto){

							$sql_reporte_4 = $conexion ->query("select
																									cl.cl_nombre,
																									cl.cl_apellido,
																									cl.cl_identificacion,
																									cl.cl_telefono_1,
																									cl.cl_telefono_2,
																									(select sum(mc_monto) from maestro_cuotas mc where mv.id_venta = mc.id_contrato_venta) as suma_monto,
																									(select sum(mc_monto_abonado) from maestro_cuotas mc where mv.id_venta = mc.id_contrato_venta) as suma_monto_abonado,
																									mcc.mc_monto,
																									mcc.mc_monto_abonado,
																									tc.tc_nombre_tipo_cuenta,
																									mp.proy_nombre_proyecto,
																									mp.id_proyecto,
																									DATE_FORMAT(mc_fecha_creacion_contrato, '%d - %m - %Y') as mc_fecha_creacion_contrato,
																									DATE_FORMAT(mc_fecha_vencimiento, '%d - %m - %Y') as mc_fecha_vencimiento
																									from maestro_clientes cl inner join maestro_ventas mv  on cl.id_cliente = mv.id_cliente
																															             inner join maestro_cuotas mcc on mcc.id_contrato_venta = mv.id_venta
																									                         inner join tipo_cuota tc on tc.id_tipo_cuota = mcc.id_tipo_cuota
																									                         inner join maestro_proyectos mp on mp.id_proyecto = mcc.id_proyecto
																									                         where
																									                         (select sum(mc_monto) from maestro_cuotas mc where mv.id_venta = mc.id_contrato_venta)
																															 					 		<>
																															 						 (select sum(mc_monto_abonado) from maestro_cuotas mc where mv.id_venta = mc.id_contrato_venta)
																									                         and
																									                         mp.id_proyecto = '".$id_proyecto."'");

							return $sql_reporte_4;
		}

		function reporte_5($conexion, $id_inmueble){

							$sql_reporte_5 = $conexion -> query("select
																										mi.id_inmueble,
																										mi.mi_nombre,
																										gi.gi_nombre_grupo_inmueble,
																										DATE_FORMAT(mv.fecha_venta, '%d - %m - %Y') as fecha_venta,
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
																										mi.id_inmueble = '".$id_inmueble."'");

							return $sql_reporte_5;
		}
?>

<?php  	function estado_cuentas_cliente_cuotas_madre($conexion, $id_cliente, $fecha1, $fecha2, $fecha3, $fecha4){

					$where = "where (1=1)";
					if ($fecha1 != ''){ $where .=" and mc.mc_fecha_creacion_contrato >= '".date('Y-m-d',strtotime($fecha1))."'"; }else{  $where .=""; }
					if ($fecha2 != ''){ $where .=" and mc.mc_fecha_creacion_contrato <= '".date('Y-m-d',strtotime($fecha2))."'"; }else{  $where .=""; }
					if ($fecha3 != ''){ $where .=" and mc.mc_fecha_vencimiento >= '".date('Y-m-d',strtotime($fecha3))."'"; }else{  $where .=""; }
					if ($fecha4 != ''){ $where .=" and mc.mc_fecha_vencimiento <= '".date('Y-m-d',strtotime($fecha4))."'"; }else{  $where .=""; }


				$sql_edo_cuenta_madre = $conexion -> query("select
																							id_cuota as id,
																							'DOCUMENTO' as concepto,
																							tc.tc_nombre_tipo_cuenta as tipo,
																							mc.mc_numero_cuota as numero,
																							mi.mi_codigo_imueble as inmueble,
																							mc.mc_fecha_creacion_contrato as emision,
																							mc.mc_fecha_vencimiento as vencimiento,
																							mc.mc_descripcion as descripcion,
																							mc.mc_monto as debito,
																							0 as credito,
																							(select sum(mc2.mc_monto) from maestro_cuotas mc2 where mc.id_cuota >= mc2.id_cuota and mc.id_contrato_venta = mc2.id_contrato_venta) as saldo
																							from
																							maestro_cuotas mc inner join tipo_cuota tc on tc.id_tipo_cuota = mc.id_tipo_cuota
																							inner join maestro_inmuebles mi on mi.id_inmueble = mc.id_inmueble
																							inner join maestro_ventas mv on mv.id_venta = mc.id_contrato_venta
																							$where
																							and mv.id_cliente = '".$id_cliente."'
																							order by
																							id_cuota");

					return $sql_edo_cuenta_madre;

} ?>

<?php  	function estado_cuentas_cliente_cuotas_hija($conexion, $id_cliente, $fecha1, $fecha2){

				$where = "where (1=1)";
				if ($fecha1!=''){ $where .=" and mca.fecha >= ".date('Y-m-d',strtotime($fecha1)); }else{  $where .=""; }
				if ($fecha2!=''){ $where .=" and mca.fecha <= ".date('Y-m-d',strtotime($fecha2));; }else{  $where .=""; }

				$sql_edo_cuenta_hija = $conexion -> query("select
																										mca.id,
																										'PAGO' as concepto,
																										tmb.tmb_nombre as tipo,
																										mca.mca_numero as numero,
																										mi.mi_codigo_imueble as inmueble,
																										mca.fecha as emision,
																										'-' as vencimiento,
																										mca.descripcion as descripcion,
																										0 as debito,
																										mca.monto_abonado as credito,
																										mca.referencia_abono_cuota,
																										(select sum(mca2.monto_abonado) from maestro_cuota_abono mca2 where mca.id >= mca2.id and mca.mca_id_documento_venta =  mca2.mca_id_documento_venta) as saldo
																										from
																										maestro_cuota_abono mca inner join tipo_movimiento_bancario tmb on mca.mca_id_tipo_abono = tmb.id_tipo_movimiento_bancario
																																						inner join maestro_inmuebles mi on mi.id_inmueble = mca.mca_id_inmueble
																										$where
																										and mca.mca_id_cliente = '".$id_cliente."'
																										order by
																										mca.id");

					return $sql_edo_cuenta_hija;

} ?>

<?php  	function cliente($conexion, $id_cliente){

				$sql_cliente = $conexion -> query("select
																							cl_nombre,
																							cl_apellido
																							from
																							maestro_clientes
																							where
																							id_cliente ='".$id_cliente."'");

					return $sql_cliente;

} ?>

<?php function todos_proveedores($conexion, $id_proveedor){

		$sql_proveedores = $conexion -> query("select * from maestro_proveedores
																					where
																					id_proveedores = '".$id_proveedor."'");

		return $sql_proveedores;
	} ?>

	<?php function todos_proyectos($conexion, $id_proyecto){


			$sql_proyectos = $conexion -> query("select
																							 id_proyecto,
																							 proy_nombre_proyecto
																							 from
																							 maestro_proyectos
																							 where
																							 id_proyecto = '".$id_proyecto."'");

			return $sql_proyectos;
		} ?>

	<?php

	############################ Reporte 5: historial  alquileres ###########################

	function reporte_alquileres($conexion, $id_proyecto, $tipo, $grupo){


					if($tipo == 2){ $where1 = " and maestro_inmuebles.mi_status in(3,4)";}else{ $where1 = "";}
					if($grupo != ""){ $where2 = " and grupo_inmuebles.id_grupo_inmuebles ='".$grupo."'";}else{$where2 = "";}

					$sql_reporte_2 = $conexion->query('select
																							mi_codigo_imueble,
																							mi_nombre,
																							mi_precio_real,
																							(select
																							CONCAT(cl_nombre," ",cl_apellido)
																							from
																							maestro_clientes mc inner join maestro_ventas mv on mc.id_cliente = mv.id_cliente
																							where
																							mv.id_inmueble = maestro_inmuebles.id_inmueble and maestro_inmuebles.mi_status in(17) and mv.mv_status in(17)) as nombre,
																							gi_nombre_grupo_inmueble,
																							(select SUM(mc_monto_abonado)
																							from maestro_cuotas
																							where
																							maestro_cuotas.id_inmueble = maestro_inmuebles.id_inmueble and maestro_inmuebles.mi_status in(17) and maestro_cuotas.mc_status in (17)) as monto_cobrado,
																							(select mi_precio_real
																							from maestro_inmuebles min
																							where
																							maestro_inmuebles.id_inmueble = min.id_inmueble and maestro_inmuebles.mi_status in(3, 4) and maestro_inmuebles.mi_status in(17)) as monto_vendido,
																							(select mi_precio_real
																							from maestro_inmuebles min
																							where
																							 maestro_inmuebles.id_inmueble = min.id_inmueble and maestro_inmuebles.mi_status in(1, 2) and maestro_inmuebles.mi_status in(17)) as por_vender,

																							(select rv.rv_precio_reserva from inmueble_rv rv where rv.id_inmueble_maestro = maestro_inmuebles.id_inmueble and maestro_inmuebles.mi_status in(17)) as monto_reservado,

																							(select SUM(mc_monto) - SUM(mc_monto_abonado)
																							from maestro_cuotas
																							where
																							maestro_cuotas.id_inmueble = maestro_inmuebles.id_inmueble and maestro_inmuebles.mi_status in (17) and maestro_cuotas.mc_status in (17) and maestro_cuotas.mc_fecha_vencimiento < now()) as monto_vencido,

																							((select SUM(mc_monto)
																							from maestro_cuotas
																							where
																							maestro_cuotas.id_inmueble = maestro_inmuebles.id_inmueble and maestro_cuotas.mc_status in (17) and maestro_inmuebles.mi_status in (17)) - (select SUM(mc_monto_abonado)
																							from maestro_cuotas
																							where
																							maestro_cuotas.id_inmueble = maestro_inmuebles.id_inmueble and maestro_cuotas.mc_status in (17) and maestro_inmuebles.mi_status in (17))) as monto_restante

																							from maestro_inmuebles inner join grupo_inmuebles on grupo_inmuebles.id_grupo_inmuebles =  maestro_inmuebles.id_grupo_inmuebles
																							where
																							maestro_inmuebles.id_proyecto = '.$id_proyecto.$where1.$where2.'
																							and maestro_inmuebles.mi_status in(17)
																							order by 1');

							return $sql_reporte_2;


				}

				function reporte_alquileres_2($conexion, $id_proyecto){

				$sql_reporte_2 = $conexion->query("select
	gi_nombre_grupo_inmueble,
	(select SUM(mc_monto_abonado)
	from maestro_cuotas
	where
	maestro_cuotas.id_grupo = maestro_inmuebles.id_grupo_inmuebles and maestro_cuotas.mc_status in (17)) as monto_cobrado,

	(select sum(mi_precio_real)
	from maestro_inmuebles min
	where
	maestro_inmuebles.id_grupo_inmuebles = min.id_grupo_inmuebles and min.mi_status in(17)) as monto_vendido,
	'-' as por_vender,
	'-' as monto_reservado,
	'-' as monto_vencido,
	'-' monto_restante
	from maestro_inmuebles inner join grupo_inmuebles on grupo_inmuebles.id_grupo_inmuebles =  maestro_inmuebles.id_grupo_inmuebles
	where
	maestro_inmuebles.id_proyecto = $id_proyecto
	group by
	gi_nombre_grupo_inmueble
	order by
	1");

	return $sql_reporte_2;

	}	 ?>
