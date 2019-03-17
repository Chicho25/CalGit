<?php require('conexion/conexion.php'); ?>
<?php //require("funciones/funciones.php"); ?>
<?php $select_id = $conexion2 -> query("select
                                        partida_documento.id
                                        from partida_documento_abono right join partida_documento
                                        on partida_documento.id = partida_documento_abono.id_partida_documento
                                        where
                                        partida_documento_abono.id_proyecto = 8
                                        group by
                                        partida_documento.id"); ?>
<?php while ($array_id[] = $select_id -> fetch_array()){} ?>
<?php foreach ($array_id as $key => $value) {
      echo $value['id'].'<br>';
      $borrar_partida_documento = $conexion2 -> query("delete from partida_documento where id =".$value['id']);
} ?>
<?php $borrar_partida_documento_abono = $conexion2 -> query("delete from partida_documento_abono where id_proyecto = 8"); ?>
<?php $borrar_movimiento_bancario = $conexion2 -> query("delete from movimiento_bancario where id_proyecto = 8"); ?>
<?php $borrar_proyecto = $conexion2 -> query("delete from maestro_proyectos where id_proyecto = 8"); ?>
<?php $borrar_partidas = $conexion2 -> query("delete from maestro_partidas where id_proyecto = 8"); ?>
<?php $borrar_inmuebles = $conexion2 -> query("delete from maestro_inmuebles where id_proyecto = 8"); ?>
<?php $maestro_cuotas = $conexion2 -> query("delete from maestro_cuotas where id_proyecto = 8"); ?>
<?php $maestro_cuotas_abono = $conexion2 -> query("delete from maestro_cuota_abono where mca_id_proyecto = 8"); ?>
<?php $maestro_ventas = $conexion2 -> query("delete from maestro_ventas where id_proyecto = 8"); ?>
