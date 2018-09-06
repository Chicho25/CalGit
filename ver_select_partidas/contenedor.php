<?php require("../conexion/conexion.php"); ?>

<?php $sql = $conexion2 -> query("select
                                  *
                                  from maestro_partidas where id_categoria ='".$_GET['id']."'"); ?>

<?php /* function monto_pago($conexion, $id_partida){
      $sql = $conexion -> query("select
                                  sum(pd_monto_total) as monto
                                from
                                  partida_documento
                                where
                                  id_partida = '".$id_partida."'");
        while($l=$sql->fetch_array()){
              return $l['monto'];
        }
      } */
?>
<table border="1" class="table table-striped js-dataTable-full" style="font-size: 10px">
    <tr>
      <td><b>Partida</b></td>
      <td><b>Estimado</b></td>
      <!--<td><b>Distribuido</b></td>-->
      <td><b>Comprometido</b></td>
      <td><b>Pagado</b></td>
      <td><b>Restante</b></td>
    </tr>
    <?php $asignado = 0; ?>
    <?php $distribuido = 0; ?>
    <?php $reservado = 0; ?>
    <?php $ejecutado = 0; ?>
    <?php $row_cnt = $sql->num_rows; /* funcion nativa de php para contar las filas de un query */ ?>
    <?php if($row_cnt==0){

          $sql = $conexion2 -> query("select
                                      *
                                      from maestro_partidas where id ='".$_GET['id']."'");

    } ?>
    <?php while($q=$sql->fetch_array()){ ?>
    <tr>
      <td><?php if($q['p_nombre']){ echo $q['p_nombre']; }else{ echo 'algo';}; ?></td>
      <td><?php echo number_format($q['p_monto'], 2, ',', '.'); ?></td>
      <?php /* ?><td><?php echo number_format($q['p_distribuido'], 2, ',', '.'); ?></td> */ ?>
      <td><?php echo number_format($q['p_reservado'], 2, ',', '.'); ?></td>
      <td><?php echo number_format($q['p_ejecutado'], 2, ',', '.'); ?></td>
      <td><?php echo number_format($q['p_monto'] - $q['p_ejecutado'], 2, ',', '.'); ?></td>
    </tr>
    <?php $asignado += $q['p_monto']; ?>
    <?php /* $distribuido += $q['p_distribuido']; */ ?>
    <?php $reservado += $q['p_reservado']; ?>
    <?php $ejecutado += $q['p_ejecutado']; ?>
    <?php } ?>
    <tr>
      <td><b>Total</b></td>
      <td><b><?php echo number_format($asignado, 2, ',', '.'); ?></b></td>
      <?php /* ?><td><b><?php echo number_format($distribuido, 2, ',', '.'); ?></b></td> <?php */ ?>
      <td><b><?php echo number_format($reservado, 2, ',', '.'); ?></b></td>
      <td><b><?php echo number_format($ejecutado, 2, ',', '.'); ?></b></td>
      <td><b><?php echo number_format($asignado - $ejecutado, 2, ',', '.'); ?></b></td>
    </tr>
</table>
