<?php require("conexion/conexion.php"); ?>
<?php

if ($_POST["elegido"]==1) {

    $sql_tipo_movimiento = $conexion2 ->query("select * from tipo_movimiento_bancario
                                                where
                                                tmb_stat = 1
                                                AND
                                                id_tipo_movimiento_bancario in(8, 1, 4, 6)");
      ?> <option value=""></option><?php
    while($lo = $sql_tipo_movimiento -> fetch_array()){ ?>
          <option value="<?php echo $lo['id_tipo_movimiento_bancario']; ?>" ><?php echo $lo['tmb_nombre']; ?></option>
  <?php }

}
if ($_POST["elegido"]==2) {

  $sql_tipo_movimiento = $conexion2 ->query("select * from tipo_movimiento_bancario
                                              where
                                              tmb_stat = 1
                                              AND
                                              id_tipo_movimiento_bancario in(13, 2, 3, 5, 7, 19, 20, 21, 22, 24)");
    ?> <option value=""></option><?php
    while($lo = $sql_tipo_movimiento -> fetch_array()){ ?>

          <option value="<?php echo $lo['id_tipo_movimiento_bancario']; ?>" ><?php echo $lo['tmb_nombre']; ?></option>

  <?php }

} ?>
