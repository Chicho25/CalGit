<?php require("../conexion/conexion.php");

	session_start();
      $_SESSION['id_sub_partida_padre'] = $_GET['id'];
      if(isset($_SESSION['id_sub_partida_padre'])){
        $update = $conexion2 -> query("update partida_documento_abono set id_sup_padre = '".$_SESSION['id_sub_partida_padre']."' where id_partida = '".$_GET['id']."'");
      }

      $sql = $conexion2 -> query("select * from maestro_partidas where id_categoria='".$_GET['id']."'"); ?>

      <?php while($q=$sql->fetch_array()){ ?>
      <option value="<?php echo $q['id']; ?>"><?php echo $q['p_nombre']; ?></option>
      <?php } ?>
