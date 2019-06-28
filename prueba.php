<?php require('conexion/conexion.php'); /* ?>
<?php function nombre_partidas($conexion, $id_partida){
 $recorrerPartidas = $conexion -> query("SELECT p_nombre FROM maestro_partidas where id = '".$id_partida."'");
 while ($r = $recorrerPartidas -> fetch_array()) {
        return $r['p_nombre'];
  }
} ?>

<?php function recorrer_partidas_documento($conecion, $id_partida_documento, $monto){ ?>
<?php $recorrerPartidas = $conecion -> query("SELECT id_categoria FROM maestro_partidas where id = '".$id_partida_documento."'"); ?>
<?php while ($r = $recorrerPartidas -> fetch_array()) {
      if ($r['id_categoria'] == 2424) {
        break;
      }
      if($r['id_categoria'] == 2443){

      //echo $r['id_categoria'].' / '.nombre_partidas($conecion, $r['id_categoria']).' /'.$monto.' / <br>';
      echo $monto;

      }

      return recorrer_partidas_documento($conecion, $r['id_categoria'], $monto);
      }
     } ?>

<?php $suma = 0; ?>
<?php $partida_abono = $conexion2 -> query("select * from partida_documento_abono where id_proyecto = 36"); ?>
<?php while($list = $partida_abono -> fetch_array()){ ?>
<?php $suma += (float)recorrer_partidas_documento($conexion2, $list['id_partida'], $list['monto']); ?>
<?php } ?>
<?php echo $suma; */ ?>
<?php function nombre_partidas($conexion, $id_partida){
 $recorrerPartidas = $conexion -> query("SELECT p_nombre FROM maestro_partidas where id = '".$id_partida."'");
 while ($r = $recorrerPartidas -> fetch_array()) {
        return $r['p_nombre'];
  }
} ?>
<?php function monto_abono($conexion, $id_partida){
  $recorrerPartidas = $conexion -> query("select sum(monto) as monto from partida_documento_abono where id_partida = '".$id_partida."'");
  while ($r = $recorrerPartidas -> fetch_array()) {
         return $r['monto'];
   }
} ?>

<?php function recorrer_partidas_documento($conecion, $id_partida, $monto){ ?>
<?php $recorrerPartidas = $conecion -> query("SELECT id FROM maestro_partidas where id_categoria = '".$id_partida."'"); ?>
<?php while ($r = $recorrerPartidas -> fetch_array()) {
      $suma = $monto + monto_abono($conecion, $r['id']);
      echo nombre_partidas($conecion, $r['id']).' , '.monto_abono($conecion, $r['id']).' , '.$suma;

      recorrer_partidas_documento($conecion, $r['id'], $suma);
  }
}
$recorrerPartidas = $conexion2 -> query("SELECT id, p_nombre FROM maestro_partidas where id_proyecto = 36 and id_categoria = 2424");
while ($r = $recorrerPartidas -> fetch_array()) {
echo $r['p_nombre'].' , '.recorrer_partidas_documento($conexion2, $r['id'], 0);
echo '<br>';
}
?>





















//
