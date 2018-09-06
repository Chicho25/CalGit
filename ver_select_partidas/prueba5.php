<?php require("../conexion/conexion.php");
      $sql = $conexion2 -> query("select * from maestro_partidas where id_categoria='".$_GET['id']."'"); ?>

      <?php while($q=$sql->fetch_array()){ ?>
      <option value="<?php echo $q['id']; ?>"><?php echo $q['p_nombre']; ?></option>
      <?php } ?>
