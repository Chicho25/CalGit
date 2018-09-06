<?php if(!isset($_SESSION)){session_start();}?>
<?php require("conexion/conexion.php"); ?>
<?php require("funciones/funciones.php"); ?>
<?php if(isset($_SESSION['session_gc'])){ ?>
<?php if(isset($_POST['id_factura'])){

/* Variables que vienen por post */
$_SESSION['id_factura'] = $_POST['id_factura'];
$_SESSION['nombre_proveedor'] = $_POST['nombre_proveedor'];
$_SESSION['id_proveedor'] = $_POST['id_proveedor'];
/* fin de las variables por post */

} ?>
<?php $header_bar = 'base_header.php'; ?>
<?php $menu = true; ?>
<?php /* ################ AUDITORIA DE SEGUIMIENTO ############## */ ?>
<?php require("funciones/funciones_auditorias.php"); ?>
<?php $lugar_mapa = 59; ?>
<?php $dispositivo_acceso = obtener_dispositivo(); ?>
<?php insertar_log_seguimiento($conexion2, ObtenerIP(), $dispositivo_acceso, $lugar_mapa, $_SESSION['session_gc']['usua_id']); ?>
<?php /* ######################################################## */ ?>
<?php /* ################## anular pago ######################### */ ?>
<?php if(isset($_POST['anular'])){

  /* Borrar los pagos ejecutados del arbol */

  function recorer_arbol_factura_resta_ejecutado($conexion, $id_partida, $monto_anterior){


          $resta = $monto_anterior;

          $sql_datos_partida = $conexion -> query("select * from maestro_partidas where id = '".$id_partida."'");
          while($ld = $sql_datos_partida -> fetch_array()){
                $id=$ld['id'];
                $id_categoria=$ld['id_categoria'];
                $ejecutado=$ld['p_ejecutado'];
                $monto_con = $ld['p_monto'];
                $reservado = $ld['p_reservado'];
          }


          $total_ejecutado = $ejecutado - $resta;
          $total_reservado = $reservado + $resta;

          $sql_ejecutado = $conexion ->query("UPDATE maestro_partidas SET p_ejecutado = '".$total_ejecutado."' WHERE id = '".$id."'");
          $sql_reservado = $conexion ->query("UPDATE maestro_partidas SET p_reservado = '".$total_reservado."' WHERE id = '".$id."'");

          /* comprovar si llego a su totalidad de monto */
          /*if($sql_insert){
              $sql_up = $conexion ->query("UPDATE maestro_partidas SET tiene_pagos = 0 WHERE id = '".$id."'");
          }*/

          if($id_categoria == ''){

          }else{
          recorer_arbol_factura_resta_ejecutado($conexion, $id_categoria, $monto_anterior);
        }

  }


  recorer_arbol_factura_resta_ejecutado($conexion2, $_POST['id_partida'], $_POST['abonado']);

  /* Eliminar Documento de abono */

  if($_POST['tipe_mov_bank']==8) {
    echo 'Entro al paso 1 </br>';
    $actualizar_pda = $conexion2 -> query("UPDATE partida_documento_abono SET stat = 16, monto = 0 WHERE id = '".$_POST['anular']."'");
    $actualizar_mb = $conexion2 -> query("UPDATE movimiento_bancario SET mb_stat = 13, mb_monto = 0 WHERE id_partida_documento_abono = '".$_POST['anular']."'");

  }else{
    echo "entro a eliminar ocumento</br>";
    $sql_eliminar_documento_abono = $conexion2 -> query("DELETE FROM partida_documento_abono WHERE id = '".$_POST['anular']."'");
  }
  echo 'entro a la suma de los documentos abonados</br>';
  $sql_obtener_ejecutado = $conexion2 -> query("SELECT sum(monto) as monto FROM partida_documento_abono WHERE id_partida_documento = '".$_POST['id_cuota_madre']."' and stat not in(16)");
  while($lista_ejecutado = $sql_obtener_ejecutado -> fetch_array()){
      $monto_ejecutado = $lista_ejecutado['monto'];
      echo "la suma documentos abonados es ".$monto_ejecutado."</br>";
  }

  if($monto_ejecutado==''){
    echo "entro en monto ejecutado 0 ";
    $actualizar_stat = $conexion2 -> query("UPDATE partida_documento SET pd_stat = 13, pd_monto_abonado = 0 WHERE id = '".$_POST['id_cuota_madre']."'");

    $sql_up = $conexion2 ->query("UPDATE maestro_partidas SET tiene_pagos = 0 WHERE id = '".$_POST['id_partida']."'");

  }else{
    $sql_obtener_documento = $conexion2 -> query("SELECT pd_monto_abonado FROM partida_documento WHERE id = '".$_POST['id_cuota_madre']."'");
    while($lista_ejecutado = $sql_obtener_documento -> fetch_array()){
        $monto_abonado = $lista_ejecutado['pd_monto_abonado'];
    }
    $resta_abonado = $monto_abonado - $_POST['abonado'];
    $actualizar_stat = $conexion2 -> query("UPDATE partida_documento SET pd_stat = 15, pd_monto_abonado = '".$resta_abonado."' WHERE id = '".$_POST['id_cuota_madre']."'");
    echo "entro en monto ejecutado !=0 ";
  }

/*
         $actualizar_status = $conexion2 -> query("UPDATE partida_documento_abono SET stat = 16 where id = '".$_POST['anular']."'");

*/
} ?>
<?php require 'inc/config.php'; ?>
<?php require 'inc/views/template_head_start.php'; ?>
<!-- Page JS Plugins CSS -->
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/select2/select2.min.css">
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/select2/select2-bootstrap.min.css">
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/sweetalert/sweetalert.min.css">
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/bootstrap-datepicker/bootstrap-datepicker3.min.css">

<?php require 'inc/views/template_head_end.php'; ?>

<script type="text/javascript">
$(document).ready(function() {
   $("#datepicker").datepicker();
});
</script>

<script type="text/javascript" src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
      $('#banco').change(function(){
        var id=$('#banco').val();
        $('#select_con_cheques').load('chequera/select_con_cheques.php?cuenta_banco='+id);
      });
  });
</script>

<?php require 'inc/views/base_head.php'; ?>

<div class="content content-narrow">
    <!-- Forms Row -->
    <?php if(isset($sql_insert)){ ?>
        <div class="col-lg-12">
            <!-- Success Alert -->
            <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h3 class="font-w300 push-15">Registrado</h3>
                <p>El <a class="alert-link" href="javascript:void(0)">pago</a> fue registrado!</p>
            </div>
            <!-- END Success Alert -->
        </div>
    <?php } ?>
    <div class="row">

        <div class="col-lg-12">
            <!-- Bootstrap Forms Validation -->
            <div class="block">
                <div class="block-header">
                    <ul class="block-options">
                        <li>

                        </li>
                    </ul>
                    <h2 class="block-title">Registrar pago de factura o abono a la factura del proveedor</h2>
                    <h2 class="block-title">Proveedor:  <?php echo $_SESSION['nombre_proveedor']; ?></h2>
                    <?php $sql = factura_proveedor_id($conexion2, $_SESSION['id_factura']); ?>
                    <?php while($lc=$sql->fetch_array()){ ?>
                      <table class="table table-bordered">
                          <thead>
                              <tr>
                                  <th class="text-center">ID</th>
                                  <th class="text-center">PARTIDA</th>
                                  <th class="text-center">TIPO</th>
                                  <th class="text-center">DESCRIPCION</th>
                                  <th class="hidden-xs">FECHA</th>
                                  <th class="text-center">STATUS</th>
                                  <th class="text-center">FECHA VENCIMIENTO</th>
                                  <th class="text-center">MONTO TOTAL</th>
                                  <th class="text-center">MONTO ABONADO</th>
                                  <th class="text-center">MONTO RESTANTE</th>
                              </tr>
                          </thead>
                          <tbody>
                            <tr>
                                <th class="text-center"><?php echo $lc['id']; ?></th>
                                <th class="text-center"><?php echo $lc['p_nombre']; ?></th>
                                <th><?php echo $lc['nombre']; ?></th>
                                <th><?php echo $lc['pd_descripcion']; ?></th>
                                <th class="hidden-xs"><?php echo date("d-m-Y", strtotime($lc['pd_fecha_emision'])); ?></th>
                                <td class="text-center"
                                    <?php if($lc['pd_stat']==13){ echo 'style="background-color:red; color:white;"';}
                                            elseif($lc['pd_stat']==15){ echo 'style="background-color:orange;"';}
                                              elseif($lc['pd_stat']==14){ echo 'style="background-color:green; color:white;"';}
                                                elseif($lc['pd_stat']==16){ echo 'style="background-color:black; color:white;"';}?>
                                ><?php if($lc['pd_stat']==13){ echo 'Pendiente por pagar';}
                                        elseif($lc['pd_stat']==15){ echo 'Abonada';}
                                          elseif($lc['pd_stat']==14){ echo 'Pagada';}
                                            elseif($lc['pd_stat']==16){ echo 'Anulada';}?></td>
                                <th class="text-center"><?php echo date("d-m-Y", strtotime($lc['pd_fecha_vencimiento'])); ?></th>
                                <th class="text-center"><?php echo number_format($lc['pd_monto_total'], 2, ',','.'); ?></th>
                                <th class="text-center"><?php echo number_format($lc['pd_monto_abonado'], 2, ',','.'); ?></th>
                                <th class="text-center"><?php echo number_format($lc['pd_monto_total']-$lc['pd_monto_abonado'], 2, ',','.'); ?></th>
                                <?php $id_partida = $lc['id_partida']; ?>
                                <?php $id_proyecto = $lc['id_proyecto']; ?>
                                <?php $monto_total = $lc['pd_monto_total']; ?>
                                <?php $monto_abonado = $lc['pd_monto_abonado']; ?>
                            </tr>
                          </tbody>
                        </table>
                    <?php } ?>
                </div>
                <div class="block-content block-content-narrow">
                  <h1 class="block-title">Detalles de pago de cuota madre</h1>
                  <table class="table table-bordered">
                      <thead>
                          <tr>
                              <th class="text-center">ID</th>
                              <th class="text-center">NUMERO</th>
                              <th class="text-center">TIPO DE PAGO</th>
                              <th class="text-center"># CHEQUE</th>
                              <th class="text-center">CUENTA</th>
                              <th class="hidden-xs">FECHA</th>
                              <th class="text-center">STATUS</th>
                              <th class="text-center">DESCRIPCION</th>
                              <th class="text-center">MONTO ABONADO</th>
                              <th class="text-center">ANULAR</th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php $sql = facturas_abonadas($conexion2, $_SESSION['id_factura']) ?>
                        <?php while($lc=$sql->fetch_array()){ ?>
                        <tr>
                            <th class="text-center"><?php echo $lc['id']; ?></th>
                            <th class="text-center"><?php echo $lc['numero']; ?></th>
                            <th class="text-center"><?php echo $lc['tmb_nombre']; ?></th>
                            <th class="text-center"><?php if($lc['numero_cheque']==0){ echo '0'; }else{ echo $lc['numero_cheque']; } ?></th>
                            <th class="text-center"><?php echo $lc['cta_numero_cuenta']; ?></th>
                            <th class="hidden-xs"> <?php echo  date("d-m-Y", strtotime($lc['fecha']));; ?></th>
                            <td class="text-center"
                                <?php if($lc['stat']==13){ echo 'style="background-color:red; color:white;"';}
                                        elseif($lc['stat']==15){ echo 'style="background-color:orange;"';}
                                          elseif($lc['stat']==14){ echo 'style="background-color:green; color:white;"';}
                                            elseif($lc['stat']==16){ echo 'style="background-color:black; color:white;"';}?>
                            ><?php if($lc['stat']==13){ echo 'Pendiente por pagar';}
                                    elseif($lc['stat']==15){ echo 'Abonada';}
                                      elseif($lc['stat']==14){ echo 'Pagada';}
                                        elseif($lc['stat']==16){ echo 'Anulada';}?></td>
                            <th class="text-center"><?php echo $lc['descricion']; ?></th>
                            <th class="text-center"><?php echo number_format($lc['monto'], 2, ',','.'); ?></th>
                            <th class="text-center">
                              <div class="btn-group">
                                <?php if ($lc['stat']==16) { ?>

                                <?php }else{ ?>
                                  <button class="btn btn-default" data-toggle="modal" data-target="#modal-popin<?php echo $lc['id']; ?>" type="submit"><i class="fa fa-trash-o"></i></button>

                                  <div class="modal fade" id="modal-popin<?php echo $lc['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                      <div class="modal-dialog modal-dialog-popin">
                                          <div class="modal-content">
                                              <div class="block block-themed block-transparent remove-margin-b">
                                                  <div class="block-header bg-primary-dark">
                                                      <ul class="block-options">
                                                          <li>
                                                              <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                                                          </li>
                                                      </ul>
                                                      <h3 class="block-title">ANULAR la cuota hija</h3>
                                                  </div>
                                                  <div class="block-content">
                                                      Esta seguro que desea anular la cuota hija ?<br>
                                                      <span style="color:red;"></span>
                                                  </div>
                                              </div>
                                              <div class="modal-footer">
                                                <form class="" action="" method="post">
                                                  <button class="btn btn-sm btn-default" type="button" data-dismiss="modal">Cerrar</button>
                                                  <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-check"></i> Ok</button>
                                                  <input type="hidden" name="anular" value="<?php echo $lc['id']; ?>">
                                                  <input type="hidden" name="abonado" value="<?php echo $lc['monto']; ?>">
                                                  <input type="hidden" name="id_cuota_madre" value="<?php echo $_SESSION['id_factura']; ?>">
                                                  <input type="hidden" name="id_partida" value="<?php echo $id_partida; ?>">
                                                  <input type="hidden" name="tipe_mov_bank" value="<?php echo $lc['id_tipo_movimiento']; ?>">
                                                </form>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                                <?php } ?>
                              </div>
                            </th>
                        </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                </div>
            <!-- Bootstrap Forms Validation -->
        </div>
    </div>
</div>
</div>
<?php require 'inc/views/base_footer.php'; ?>
<?php require 'inc/views/template_footer_start.php'; ?>
<script type="text/javascript" src="bootstrap-filestyle.min.js"> </script>

<!-- Page JS Plugins -->
<script src="<?php echo $one->assets_folder; ?>/js/plugins/select2/select2.full.min.js"></script>
<script src="<?php echo $one->assets_folder; ?>/js/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="<?php echo $one->assets_folder; ?>/js/plugins/jquery-validation/additional-methods.min.js"></script>
<!-- Page JS Code -->
<script>
    jQuery(function(){
        // Init page helpers (Select2 plugin)
        App.initHelpers('select2');
    });
</script>
<script src="<?php echo $one->assets_folder; ?>/js/pages/base_forms_validation.js"></script>

<!-- Page JS Plugins -->
<script src="<?php echo $one->assets_folder; ?>/js/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<script src="<?php echo $one->assets_folder; ?>/js/plugins/jquery-auto-complete/jquery.auto-complete.min.js"></script>
<script src="<?php echo $one->assets_folder; ?>/js/plugins/bootstrap-notify/bootstrap-notify.min.js"></script>
<script src="<?php echo $one->assets_folder; ?>/js/plugins/sweetalert/sweetalert.min.js"></script>

<!-- Page JS Code -->
<script src="<?php echo $one->assets_folder; ?>/js/pages/base_ui_activity.js"></script>
<script>
    jQuery(function(){
        // Init page helpers (BS Notify Plugin)
        App.initHelpers('notify');
    });
</script>
<script src="<?php echo $one->assets_folder; ?>/js/pages/base_forms_pickers_more.js"></script>
<script>
    jQuery(function(){
        // Init page helpers (BS Datepicker + BS Datetimepicker + BS Colorpicker + BS Maxlength + Select2 + Masked Input + Range Sliders + Tags Inputs plugins)
        App.initHelpers(['datepicker', 'datetimepicker', 'colorpicker', 'maxlength', 'select2', 'masked-inputs', 'rangeslider', 'tags-inputs']);
    });
</script>

<?php require 'inc/views/template_footer_end.php'; ?>
<?php }else{ ?>
        <script type="text/javascript">
            window.location="index.php";
        </script>
<?php } ?>
