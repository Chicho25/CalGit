<?php if(!isset($_SESSION)){session_start();}?>
<?php require("conexion/conexion.php"); ?>
<?php require("funciones/funciones.php"); ?>
<?php $sql = $conexion2 -> query("select * from maestro_partidas where id_proyecto = '".$_POST['elegido']."'"); ?>

<?php function recorer2($conexion, $id_categoria){

$sql_inter = $conexion -> query("select * from maestro_partidas where id = '".$id_categoria."'");
while($l2=$sql_inter->fetch_array()){
   echo recorer($conexion, $l2['id_categoria']).' '.$l2['p_nombre'].' // ';
}

} ?>

<?php function inter2($conexion, $id){ ?>
<?php $sql_inter = $conexion -> query("select * from maestro_partidas where id_categoria = '".$id."'"); ?>
<?php $contar=$sql_inter->num_rows; ?>

<?php if($contar==0){ return true; }else{ return false; } }?>

<?php function recorer($conexion, $id_categoria){

 $sql_inter = $conexion -> query("select * from maestro_partidas where id = '".$id_categoria."'");
   while($l2=$sql_inter->fetch_array()){
          echo recorer($conexion, $l2['id_categoria']).' '.$l2['p_nombre'].' // ';
  }

} ?>
<option>Seleccionar Partida</option>
<?php while($l=$sql->fetch_array()){
     $var = inter2($conexion2, $l['id']);
     if($var==true){ ?>
     <option value="<?php echo $l['id']; ?>" > <?php echo recorer2($conexion2, $l['id_categoria']).' // '.$l['p_nombre']; ?> </option>
<?php } } ?>
