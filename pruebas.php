<?php require("conexion/conexion.php"); ?>
<?php require("funciones/funciones.php");

$seleccionar_servicios = $conexion2 -> query("SELECT * FROM servicios WHERE stat not in(2)");
while ($lista_servi = $seleccionar_servicios -> fetch_array()) {

  $datos_cliente0 = $conexion2 -> query("SELECT id_cliente FROM maestro_ventas where id_venta = '".$lista_servi['id_ventas']."'");

  while ($lista_cliente0 = $datos_cliente0 -> fetch_array()) {
         $id_cliente0 = $lista_cliente0['id_cliente'];
  }

  $movimiento_bancario = $conexion2 -> query("INSERT INTO
                                              movimiento_bancario(id_cuenta,
                                                                  id_tipo_movimiento,
                                                                  mb_fecha,
                                                                  mb_monto,
                                                                  mb_descripcion,
                                                                  mb_stat,
                                                                  id_proyecto,
                                                                  id_contrato_venta,
                                                                  id_cliente
                                                                  )VALUES(
                                                                  13,
                                                                  26,
                                                                  '".$lista_servi['date_time']."',
                                                                  '".$lista_servi['monto']."',
                                                                  '".$lista_servi['descripcion']."',
                                                                  1,
                                                                  13,
                                                                  '".$lista_servi['id_ventas']."',
                                                                  '".$id_cliente0."')");

}
