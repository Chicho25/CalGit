<?php require("conexion/conexion.php"); ?>
<?php

    $sql_tipo_movimiento = $conexion2 ->query("select * from grupo_inmuebles
                                                where
                                                gi_status = 1
                                                AND
                                                gi_id_proyecto = '".$_POST["elegido"]."'"); ?>
          <option value="">Seleccionar un grupo</option>
          <option value="">Todos</option>                                                
<?php  while($lo = $sql_tipo_movimiento -> fetch_array()){ ?>

          <option value="<?php echo $lo['id_grupo_inmuebles']; ?>" ><?php echo $lo['gi_nombre_grupo_inmueble']; ?></option>

  <?php } ?>
