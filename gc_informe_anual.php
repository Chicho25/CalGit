<?php if(!isset($_SESSION)){session_start();}?>
<?php require("conexion/conexion.php"); ?>
<?php require("funciones/funciones.php"); ?>
<?php if(isset($_SESSION['session_gc'])){ ?>
<?php $header_bar = 'base_header.php'; ?>
<?php $menu = true; ?>

<?php require 'inc/config.php'; ?>
<?php require 'inc/views/template_head_start.php'; ?>
<?php require 'inc/views/template_head_end.php'; ?>
<?php require 'inc/views/base_head.php'; ?>

<?php if(isset($_POST['proyecto'],
                  $_POST['partida'])){

                    if($_POST['proyecto'] != ''){$condicion1 = " where id_proyecto = '".$_POST['proyecto']."'";}else{$condicion1 = "";}
                    if($_POST['partida'] != ''){$condicion2 = " where id = '".$_POST['partida']."'";}else{ $condicion2 = "";}

                    if($condicion1 != '' && $condicion2 != ''){

                      $condicion1 = $condicion1;
                      $condicion2 = '';
                    }

                  } ?>

                  <?php if(isset($condicion1, $condicion2)){
                        $condiciones = $condicion1.$condicion2;

                    $sql = $conexion2 -> query("select *, (p_monto - p_ejecutado) as resta from maestro_partidas $condiciones");

                        }else{ ?>

<?php $sql = $conexion2 -> query("select *, (p_monto - p_ejecutado) as resta from maestro_partidas");} ?>

<?php function recorer($conexion, $id_categoria){

 $sql_inter = $conexion -> query("select * from maestro_partidas where id = '".$id_categoria."'");
   while($l2=$sql_inter->fetch_array()){
          echo recorer($conexion, $l2['id_categoria']).' '.$l2['p_nombre'].' // ';
  }

} ?>

<?php function inter($conexion, $id){ ?>
<?php $sql_inter = $conexion -> query("select * from maestro_partidas where id_categoria = '".$id."'"); ?>
<?php $contar=$sql_inter->num_rows; ?>

<?php if($contar==0){ return true; }else{ return false; } }?>

<?php /* while($l=$sql->fetch_array()){
            $var = inter($conexion2, $l['id']);
            if($var==true){ ?>
          <?php echo recorer($conexion2, $l['id_categoria']).' // '.$l['p_nombre'].' // '.$l['p_monto'].' // '
          .$l['p_ejecutado'].' // '.$l['resta'].'<br>'; ?>
    <?php      }
  } */ ?>

      <div class="block">
          <div class="block-header">
              <h3 class="block-title">Informe Anual</h3>
          </div>
          <div class="block-content">
              <table class="table table-borderless">
                  <thead>
                      <tr>
                          <th class="text-center">Partidas</th>
                          <th>Monto</th>
                          <th class="hidden-xs" style="">Ejecutado</th>
                          <th class="text-center" style="">Saldo</th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php while($l=$sql->fetch_array()){

                                $var = inter($conexion2, $l['id']);
                                if($var==true){ ?>

                                  <?php
                                    if(isset($_POST['status'])){
                                      if($_POST['status'] ==2){

                                          if($l['resta']>-1){
                                            continue;
                                          }

                                   }} ?>

                      <tr <?php if($l['p_monto'] == $l['p_ejecutado']){ echo 'class="info"'; }
                                  elseif($l['resta'] < 0){ echo 'class="danger"';}
                                      else{ echo 'class="active"';}
                                      ?> >
                          <td class="text-center"><?php echo recorer($conexion2, $l['id_categoria']).' // '.$l['p_nombre']; ?> </td>
                          <td><?php echo $l['p_monto']; ?></td>
                          <td class="hidden-xs">
                              <?php echo $l['p_ejecutado']; ?>
                          </td>
                          <td class="text-center">
                              <?php echo $l['resta']; ?>
                          </td>
                      </tr>
                      <?php  }
                        } ?>
                  </tbody>
              </table>
          </div>
      </div>
      <?php require 'inc/views/base_footer.php'; ?>
      <?php require 'inc/views/template_footer_start.php'; ?>
      <?php require 'inc/views/template_footer_end.php'; ?>
      <?php }else{ ?>
              <script type="text/javascript">
                  window.location="salir.php";
              </script>
      <?php } ?>
