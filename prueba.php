<?php require('conexion/conexion.php'); ?>
<?php function nombre_partidas($conexion, $id_partida){
 $recorrerPartidas = $conexion -> query("SELECT p_nombre FROM maestro_partidas where id = '".$id_partida."'");
 while ($r = $recorrerPartidas -> fetch_array()) {
        return $r['p_nombre'];
  }
} ?>

<?php function recorrer_partidas_documento($conecion, $id_partida_documento){ ?>
<?php $recorrerPartidas = $conecion -> query("SELECT id_categoria FROM maestro_partidas where id = '".$id_partida_documento."'"); ?>
<?php while ($r = $recorrerPartidas -> fetch_array()) {
      if ($r['id_categoria'] == 2424) {
        break;
      }
      echo $r['id_categoria'].' / '.nombre_partidas($conecion, $r['id_categoria']).' /';
      return recorrer_partidas_documento($conecion, $r['id_categoria']);
      }
     } ?>

<?php echo recorrer_partidas_documento($conexion2, 2452); ?>
