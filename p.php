<?php require("conexion/conexion.php"); ?>
<?php $sql = $conexion2 -> query("select * from maestro_partidas"); ?>

<?php function recorer($conexion, $id_categoria){

 $sql_inter = $conexion -> query("select * from maestro_partidas where id = '".$id_categoria."'");
   while($l2=$sql_inter->fetch_array()){
          echo recorer($conexion, $l2['id_categoria']).' // '.$l2['p_nombre'].' // ';
  }

} ?>

<?php function inter($conexion, $id){ ?>
<?php $sql_inter = $conexion -> query("select * from maestro_partidas where id_categoria = '".$id."'"); ?>
<?php $contar=$sql_inter->num_rows; ?>

<?php if($contar==0){ return true; }else{ return false; } }?>

<?php while($l=$sql->fetch_array()){
            $var = inter($conexion2, $l['id']);
            if($var==true){
            echo recorer($conexion2, $l['id_categoria']).' // '.$l['id'].' // '.$l['p_nombre'].' // <br>';
          }

} ?>
