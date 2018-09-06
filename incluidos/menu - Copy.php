<?php require_once('../../Connections/conexion.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}


?>

<table width="1100" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td valign="top" bgcolor="#01135D"><img src="http://grupocalpe.com/sistema/image/logo100.jpg" width="100" height="100" align="left" />
		  <div style="color:#FFF; font-size:12px; font-weight:bold; font-family:Verdana, Geneva, sans-serif" align="right"> 
		<?php if(isset($_SESSION['MM_Username'])){
			$colname_NOMBRE_USUARIO = "-1";
			if (isset($_SESSION['MM_Username'])) {
			  $colname_NOMBRE_USUARIO = $_SESSION['MM_Username'];
			}
			mysql_select_db($database_conexion, $conexion);
			$query_NOMBRE_USUARIO = sprintf("SELECT * FROM usuarios WHERE `ALIAS` = %s", GetSQLValueString($colname_NOMBRE_USUARIO, "text"));
			$NOMBRE_USUARIO = mysql_query($query_NOMBRE_USUARIO, $conexion) or die(mysql_error());
			$row_NOMBRE_USUARIO = mysql_fetch_assoc($NOMBRE_USUARIO);
			$totalRows_NOMBRE_USUARIO = mysql_num_rows($NOMBRE_USUARIO);
			
			echo $row_NOMBRE_USUARIO['NOMBRES'].' '.$row_NOMBRE_USUARIO['APELLIDOS'].' ('.$row_NOMBRE_USUARIO['ALIAS'].')  ';
        	
        }?> </div></td>
	</tr>
	<tr>
		<td bgcolor="#666666"><style media="all" type="text/css">
			@import "../css/menu_style.css";
		</style>
			<div class="menu">
				<ul>
					<li><a href="../inicio/menu.php" target="_self" >Home</a> </li>
					<li><a href="#" target="_self" >Consultas</a>
						<ul>
							<li><a href="../consultas/suma.php" target="_self">Partidas</a></li>
							<hr />
							<li><a href="../consulta_pagos/pagos_partidas.php?col=DESCRIPCION_COMPLETA&orden=1" target="_self">Pagos por Partidas</a></li>
							<li><a href="../_grafica/buscar-grafico01.php" target="_self">Relacion Ingresos y Egresos</a></li>
						</ul>
					</li>
					<li><a href="" target="_self" >Costos</a>
						<ul>
							<li><a href="../_partidas/listado.php?MONTO_ESTIMADO_DISPONIBLE=&amp;COD_PROYECTO=&amp;col=ID_PARTIDA&amp;orden=1&amp;DESCRIPCION_COMPLETA=&amp;MONTO_ESTIMADO=&amp;MONTO_ASIGNADO=&amp;MONTO_PAGADO=&amp;ESTIMADO_EXCEDIDO=&amp;ID_PARTIDA=&amp;button=Buscar">Partidas</a></li>
							<li><a href="../proveedor/listado.php?PROVEEDOR=&col=ID_PRO_CLI&orden=1&TIPO=Todos&CONTACTO=&button=Buscar" target="_self">Proveedores</a></li>
							<li><a href="../documentos/edit2.php?ID_DOCUMENTO=&elegido=&col=FECHA_DOCUMENTO_DATE&orden=asc&TIPO=0&PROYECTO=0&STATUS=Todos" target="_self">Documentos</a></li>
							<li><a href="../pago_eliminar/del01.php?ID_PAGO=&ID_DOCUMENTO=&PROYECTO=&PROVEEDOR=&TIPO=&NUMERO=&FROM=&TO=&button=Buscar" target="_self">Pagos</a></li>
							<hr color="#CCCCCC" />
							<li><a href="../_reportes/edo_proveedor.php" target="_self">Estado Cuenta Proveedor</a></li>
							<li><a href="../_reportes/listado_comision.php" target="_self">Comisiones</a></li>
							
							<!--<li><a href="../consulta_pagos/listado_documentos.php?col=ID&orden=1" target="_self">Listado Documentos</a></li>
							<li><a href="../formularios/consulta_partida.php" target="_self">Consulta Documentos</a></li>-->
						</ul>
					</li>
					<li><a href="" target="_self" >Ventas</a>
						<ul>
						<li><a href="../_inmuebles/listado.php?CODIGO_INMUEBLE=&col=NOMBRE_INMUEBLE%2CNOMBRE_GRUPO%2CNOMBRE_INMUEBLE&orden=1&PRECIO_REAL=&CANTIDAD_VENDEDORES=6&COD_PROYECTO=&ID_GRUPO=&ID_INMUEBLE=&ID_TIPO_INMUEBLE=&VENDIDO=&button=Buscar" target="_self">Inmuebles</a></li>
					<li><a href="../_precios/index.php" target="_self">Cambio de Precio por Lote</a></li>
						<li><a href="../_mantenimiento/grupo.php" target="_self">Grupos de Inmuebles</a></li>
							<li><a href="../cliente/listado.php?PROVEEDOR=&col=ID_PRO_CLI&orden=1&TIPO=Todos&CONTACTO=&button=Buscar" target="_self">Clientes</a></li>
							
							<li><a href="../_ventas/edit2.php?ID_INMUEBLES_MOV=&ID_PROYECTO=&ID_GRUPO=&FECHA_VENTA_DATE=&ID_CLIENTE=&MONTO_VENTA=&ID_INMUEBLES=&FECHA_VENTA_DATE=&FECHA_HASTA=&CODIGO_INMUEBLE=&col=FECHA_VENTA_DATE&orden=1">Contrato de Venta</a></li>
							<li><a href="../_doc_venta_listado/edit2.php?ID_DOCUMENTO=&col=FECHA_VENCIMIENTO_DATE&orden=asc&elegido=&TIPO=0&PROYECTO=0&STATUS=Todos&button=Buscar" target="_self">Documentos</a></li>
							<li><a href="../_ventas_pago/listado.php?ID_PAGO=&ID_DOCUMENTO=&PROYECTO=&PROVEEDOR=&TIPO=&NUMERO=&FROM=&TO=&button=Buscar" target="_self">Cobros</a></li>
							<hr /><li><a href="../_reportes/edo_cliente.php" target="_self">Estado Cuenta Cliente</a></li><li><a href="../_reportes/buscar_1.php" target="_self">Ventas Inmuebles</a></li><li><a href="../_reportes/buscar_2.php" target="_self">Ventas Inmuebles con Clientes</a></li>
						</ul>
					</li>
					<li><a href="" target="_self" >Banco</a>
						<ul>

							
							<li><a href="../_mov_bancarios/index.php" target="_self">Movimientos Bancarios</a></li>
                            <li><a href="../_cheque/directo.php" target="_self">Cheque Directo Automatico</a></li>
							<li><a href="../banco/cheque_anulado.php" target="_self">Anular Cheque</a></li>
							<hr color="#999999" />
							<li><a href="../_mov_bancarios/saldos.php" target="_self">Saldos Cuentas Bancarias</a></li><li><a href="../_banco/buscar_edo_cuenta.php" target="_self">Estado de Cuenta</a></li>
					<!--		<li><a href="../banco/consulta.php?p=0&col=FECHA&orden=1" target="_self">Consulta Cheques</a></li>
							<li><a href="../banco/consulta_anulados.php" target="_self">Consulta Cheques Anulados</a></li>-->
						</ul>
					</li>
					<li><a href="#" target="_self" >Mantenimientos</a>
						<ul>
							<li><a href="../_m_banco/index.php" target="_self">Bancos</a></li>							<li><a href="../_m_cuentas/index.php" target="_self">Cuentas Bancarias</a></li><li><a href="../_m_chequera/index.php" target="_self">Chequeras</a></li><hr /><li><a href="../_m_empresas/index.php" target="_self">Empresas</a></li>							<li><a href="../_mantenimiento/proyecto_add.php" target="_self">Proyectos</a></li><hr /><li><a href="#" target="_self">Usuarios</a></li>							<li><a href="#" target="_self">Roles y Permisos</a></li>

						</ul>
					</li>
<li><a href="../index.php" style="color:#FFF">Cerrar Sesion </a></li>
				</ul>
			</div></td>
	</tr>
</table>

