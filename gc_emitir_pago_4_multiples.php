<?php if(!isset($_SESSION)){session_start();}?>
<?php require("conexion/conexion.php"); ?>
<?php require("funciones/funciones.php"); ?>
<?php if(isset($_SESSION['session_gc'])){ ?>
<?php if(isset($_POST['id_pago_multi'])){

      /* Variables que vienen por post */
      $_SESSION['id_factura_multi'] = $_POST['id_pago_multi'];
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

<?php if(isset($_POST['confirmacion'])){

         /* Numero de cheque */
         if($_POST['id_tipo_movimiento_bancario'] == 8){

           $cheque_no_directo = true;
           $numero_cheque = obtener_numero_cheque($conexion2, $_POST['cuenta_banco']);

         }else{
           $numero_cheque = 0;
         }

         $sql_insert = $conexion2 -> query("INSERT INTO
                                            partida_documento_abono(
                                            id_cuenta,
                                            id_tipo_movimiento,
                                            fecha,
                                            numero,
                                            monto,
                                            descricion,
                                            stat,
                                            id_proveedor,
                                            id_partida_documento,
                                            id_partida,
                                            id_proyecto,
                                            id_chequera,
                                            beneficiario,
                                            numero_cheque
                                            )VALUES(
                                            '".$_POST['cuenta_banco']."',
                                            '".$_POST['id_tipo_movimiento_bancario']."',
                                            '".date("Y-m-d", strtotime($_POST['fecha']))."',
                                            '".$_POST['numero_abono']."',
                                            '".$_POST['monto_pagar']."',
                                            '".$_POST['descripcion']."',
                                            14,
                                            '".$_SESSION['id_proveedor']."',
                                            '".$_SESSION['id_factura']."',
                                            '".$_POST['id_partida']."',
                                            '".$_POST['id_proyecto']."',
                                            '".$_POST['id_chequera']."',
                                            '".$_POST['beneficiario']."',
                                            '".$numero_cheque."')");

       /* ########## Funcion recorrer arbol ########## */

        function recorer_arbol_factura($conexion, $id_partida, $monto){

                $sql_datos_partida = $conexion -> query("select * from maestro_partidas where id = '".$id_partida."'");
                while($ld = $sql_datos_partida -> fetch_array()){
                      $id=$ld['id'];
                      $id_categoria=$ld['id_categoria'];
                      $ejecutado=$ld['p_ejecutado'];
                      $reservado=$ld['p_reservado'];
                }

                $total_ejecutado = $ejecutado + $monto;
                $resta_reservado = $reservado - $monto;

                $sql_update = $conexion ->query("UPDATE maestro_partidas SET
                                                                          p_ejecutado = '".$total_ejecutado."',
                                                                          p_reservado = '".$resta_reservado."'
                                                                         WHERE
                                                                          id = '".$id."'");

                if($id_categoria == ''){

                }else{
                recorer_arbol_factura($conexion, $id_categoria, $monto);
              }

        }

        recorer_arbol_factura($conexion2, $_POST['id_partida'], $_POST['monto_pagar']);

       /* ############## Insertar Movimiento bancario ############ */

       if($_POST['id_tipo_movimiento_bancario']== 8 ||
          $_POST['id_tipo_movimiento_bancario']== 4 ||
          $_POST['id_tipo_movimiento_bancario']== 10 ||
          $_POST['id_tipo_movimiento_bancario']== 11 ||
          $_POST['id_tipo_movimiento_bancario']== 12 ){


            /* optener el ultimo id del abono insertado */

            $sql_ultimo_id = $conexion2 -> query("SELECT max(id) as id
                                                   from
                                                   partida_documento_abono
                                                   WHERE
                                                   id_partida_documento = '".$_SESSION['id_factura']."'");

             while ($u = $sql_ultimo_id -> fetch_array()){
                    $ultimo_id_sub_factura = $u['id'];
             }


       $sql_insert = $conexion2 -> query("INSERT INTO
                                          movimiento_bancario(
                                          id_cuenta,
                                          id_tipo_movimiento,
                                          mb_fecha,
                                          mb_referencia_numero,
                                          mb_monto,
                                          mb_descripcion,
                                          mb_stat,
                                          id_proveedor,
                                          id_proyecto,
                                          id_partida,
                                          id_partida_documento,
                                          id_partida_documento_abono,
                                          id_chequera,
                                          mb_beneficiario,
                                          mb_numero_cheque
                                          )VALUES(
                                          '".$_POST['cuenta_banco']."',
                                          '".$_POST['id_tipo_movimiento_bancario']."',
                                          '".date("Y-m-d", strtotime($_POST['fecha']))."',
                                          '".$_POST['numero_abono']."',
                                          '".$_POST['monto_pagar']."',
                                          '".$_POST['descripcion']."',
                                          1,
                                          '".$_POST['id_proveedor']."',
                                          '".$_POST['id_proyecto']."',
                                          '".$_POST['id_partida']."',
                                          '".$_POST['id_factura']."',
                                          '".$ultimo_id_sub_factura."',
                                          '".$_POST['id_chequera']."',
                                          '".$_POST['beneficiario']."',
                                          '".$numero_cheque."')");}

/* Auditoria */

$tipo_operacion = 1;
$comentario = "Pago de Facturas/Documentos";

$sql_insert = $conexion2 -> query("INSERT INTO
                                   auditoria_pago_facturas(
                                   aupf_tipo_operacion,
                                   aupf_usua_log,
                                   aupf_comentario,
                                   aupf_id_cuenta,
                                   aupf_id_tipo_movimiento,
                                   aupf_fecha,
                                   aupf_numero,
                                   aupf_monto,
                                   aupf_descricion,
                                   aupf_stat,
                                   aupf_id_proveedor,
                                   aupf_id_partida_documento,
                                   aupf_id_partida,
                                   aupf_id_proyecto,
                                   aupf_id_chequera,
                                   aupf_beneficiario,
                                   aupf_numero_cheque
                                   )VALUES(
                                   '".$tipo_operacion."',
                                   '".$_SESSION['session_gc']['usua_id']."',
                                   '".$comentario."',
                                   '".$_POST['cuenta_banco']."',
                                   '".$_POST['id_tipo_movimiento_bancario']."',
                                   '".date("Y-m-d", strtotime($_POST['fecha']))."',
                                   '".$_POST['numero_abono']."',
                                   '".$_POST['monto_pagar']."',
                                   '".$_POST['descripcion']."',
                                   14,
                                   '".$_SESSION['id_proveedor']."',
                                   '".$_SESSION['id_factura']."',
                                   '".$_POST['id_partida']."',
                                   '".$_POST['id_proyecto']."',
                                   '".$_POST['id_chequera']."',
                                   '".$_POST['beneficiario']."',
                                   '".$numero_cheque."')");


       /* Actrualizar el monto de la cuota */
       $traer_monto_actual = $conexion2 -> query("SELECT pd_monto_abonado FROM partida_documento WHERE id = '".$_POST['id_factura']."'");
       while($ll = $traer_monto_actual ->fetch_array()){
             $monto_actual = $ll['pd_monto_abonado'];}
       $total_abnonado = $monto_actual + $_POST['monto_pagar'];
       $sql_actualizar_monto = $conexion2 -> query("UPDATE partida_documento SET pd_monto_abonado = '".$total_abnonado."', pd_stat = 15 WHERE id = '".$_POST['id_factura']."'");

       /* Comprobar si ya llego a su limite para cambiar de status */

       $traer_monto_actual_2 = $conexion2 -> query("SELECT pd_monto_abonado, pd_monto_total FROM partida_documento WHERE id = '".$_POST['id_factura']."'");
       while($ll_2 = $traer_monto_actual_2 ->fetch_array()){
             $monto_actual_2 = $ll_2['pd_monto_abonado'];
             $monto_total_2 = $ll_2['pd_monto_total'];}
        if($monto_actual_2 == $monto_total_2){
           $actualizar = $conexion2 -> query("UPDATE partida_documento SET pd_stat = 14 WHERE id = '".$_POST['id_factura']."'");
        }


       /* fin de las variables de session */
       /*$id_factura_pase = $_POST['id_contrato_venta'];/* pasar la variable de al listado anterior */
       unset($_SESSION['abono_factura']);
       /*unset($_SESSION['id_cuota']);*/
       /* ······························ */

       }elseif(isset($_POST['numero_abono'],
                     $_POST['cuenta_banco'],
                     $_POST['id_tipo_movimiento_bancario'],
                     $_POST['beneficiario'],
                     $_POST['descripcion'],
                     $_POST['fecha'],
                     $_POST['monto_documento'],
                     $_POST['monto_pagado'],
                     $_POST['monto_pendiente'],
                     $_POST['monto_pagar'],
                     $_POST['id_chequera'])){

                       $abono_factura = array('numero_abono'=>$_POST['numero_abono'],
                                              'cuenta_banco'=>$_POST['cuenta_banco'],
                                              'id_tipo_movimiento_bancario'=>$_POST['id_tipo_movimiento_bancario'],
                                              'beneficiario'=>$_POST['beneficiario'],
                                              'descripcion'=>$_POST['descripcion'],
                                              'fecha'=>$_POST['fecha'],
                                              'monto_documento'=>$_POST['monto_documento'],
                                              'monto_pagado'=>$_POST['monto_pagado'],
                                              'monto_pendiente'=>$_POST['monto_pendiente'],
                                              'monto_pagar'=>$_POST['monto_pagar'],
                                              'id_chequera'=>$_POST['id_chequera']);

                        $_SESSION['abono_factura']=$abono_factura;
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

                      <table class="table table-bordered">
                          <thead>
                              <tr>
                                  <th class="text-center">ID</th>
                                  <th class="text-center">PARTIDA</th>
                                  <th class="text-center">TIPO</th>
                                  <th class="hidden-xs">FECHA</th>
                                  <th class="text-center">FECHA VENCIMIENTO</th>
                                  <th class="text-center">MONTO TOTAL</th>
                                  <th class="text-center">MONTO ABONADO</th>
                                  <th class="text-center">MONTO RESTANTE</th>
                                  <th class="text-center">ABONAR MONTO</th>
                              </tr>
                          </thead>
                          <tbody>
                            <?php
                              $monto_total = 0;
                              $monto_abonado = 0;
                             ?>
                            <?php foreach ($_SESSION['id_factura_multi'] as $key => $value) { ?>
                            <?php $sql = factura_proveedor_id($conexion2, $value); ?>
                            <?php while($lc=$sql->fetch_array()){ ?>
                            <tr>
                                <th class="text-center"><?php echo $lc['id'].' '.$lc['id_partida']; ?></th>
                                <th class="text-center"><?php echo $lc['p_nombre']; ?></th>
                                <th><?php echo $lc['nombre']; ?></th>
                                <th class="hidden-xs"><?php echo date("d-m-Y", strtotime($lc['pd_fecha_emision'])); ?></th>
                                <th class="text-center"><?php echo date("d-m-Y", strtotime($lc['pd_fecha_vencimiento'])); ?></th>
                                <th class="text-center"><?php echo number_format($lc['pd_monto_total'], 2, ',','.'); ?></th>
                                <th class="text-center"><?php echo number_format($lc['pd_monto_abonado'], 2, ',','.'); ?></th>
                                <th class="text-center"><?php echo number_format($lc['pd_monto_total']-$lc['pd_monto_abonado'], 2, ',','.'); ?></th>
                                <th class="text-center"><input class="form-control" value="<?php echo $lc['pd_monto_total']-$lc['pd_monto_abonado']; ?>" name="" id=""></th>
                                <?php $id_partida = $lc['id_partida']; ?>
                                <?php $id_proyecto = $lc['id_proyecto']; ?>
                                <?php $monto_total += $lc['pd_monto_total']; ?>
                                <?php $monto_abonado += $lc['pd_monto_abonado']; ?>
                                <?php /* Para el Cheque */ ?>
                                <?php $id_impreso = $lc['id']; ?>
                                <?php $nombre_partida = $lc['p_nombre']; ?>
                                <?php $descripcion_partida_documento = $lc['pd_descripcion']; ?>

                            </tr>
                              <?php } ?>
                            <?php } ?>
                          </tbody>
                        </table>

                </div>
                <div class="block-content block-content-narrow">
                    <!-- jQuery Validation (.js-validation-bootstrap class is initialized in js/pages/base_forms_validation.js) -->
                    <!-- For more examples you can check out https://github.com/jzaefferer/jquery-validation -->
                    <form class="js-validation-bootstrap form-horizontal" action="" method="post" enctype="multipart/form-data">
                      <div class="form-group">
                          <label class="col-md-4 control-label" for="val-email">Numero de Abono <span class="text-danger">*</span>

                          </label>
                          <div class="col-md-7">
                              <?php $numero_factura_abono = numero_abono_factura($conexion2, $_SESSION['id_factura']); ?>
                              <input class="form-control" value="<?php if(isset($_SESSION['abono_factura'])){
                                                                          echo $_SESSION['abono_factura']['numero_abono'];
                                                                          }else{ echo $numero_factura_abono; } ?>" type="text" name="numero_abono" placeholder="Monto documento" readonly="readonly">
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-md-4 control-label" for="val-select2">Banco</label>
                          <div class="col-md-7">
                            <select class="form-control" id="banco" name="cuenta_banco" style="width: 100%;" data-placeholder="Seleccionar cuenta">
                                <option value="0">Seleccionar</option>
                                <?php $sql_cuenta = movimiento_bancario_cuenta_documento($conexion2, $_SESSION['id_proyecto_pago']); ?>
                                <?php while($lista_cuentas = $sql_cuenta -> fetch_array()){ ?>
                                <?php if($lista_cuentas['monto'] == '' || $lista_cuentas['monto'] <= 0){ continue; } ?>
                                <option value="<?php echo $lista_cuentas['id_cuenta_bancaria']; ?>"
                                               <?php if(isset($_SESSION['abono_factura'])){ if($_SESSION['abono_factura']['cuenta_banco'] == $lista_cuentas['id_cuenta_bancaria']){ echo 'selected'; }} ?>
                                 ><?php echo $lista_cuentas['proy_nombre_proyecto']. ' // ' .$lista_cuentas['banc_nombre_banco']. ' // ' .$lista_cuentas['cta_numero_cuenta'].' // '.number_format($lista_cuentas['monto'], 2, ',', '.').'$'; ?></option>

                                <?php } ?>
                            </select>
                          </div>
                      </div>
                        <?php if(isset($_SESSION['abono_factura'])){ ?>

                          <?php $sql_cheque_numeracion = $conexion2 -> query("select
                                                                              id_tipo_movimiento_bancario,
                                                                              tmb_nombre,
                                                                              if ((id_tipo_movimiento_bancario = 8),
                                                                                 (select chq_ultimo_emitido+1
                                                                                 from chequeras
                                                                                 where
                                                                                 chq_id_cuenta_banco = '".$_SESSION['abono_factura']['cuenta_banco']."'), (0)) as ultimo_cheque
                                                                              from
                                                                              tipo_movimiento_bancario
                                                                              where
                                                                              id_tipo_movimiento_bancario in(8, 9, 4, 10, 11, 6,12)"); ?>

                          <div class="form-group">
                              <label class="col-md-4 control-label" for="val-skill">Tipo de pago
                                <span class="text-danger">*</span></label>
                              <div class="col-md-7">
                                <select id="tipo_movimiento" class="form-control" required="required" name="id_tipo_movimiento_bancario" style="width: 100%;" data-placeholder="Seleccionar tipo de movimiento">
                                    <option value="0">Seleccionar</option>

                                    <?php while($lista_tipo_movimiento = $sql_cheque_numeracion -> fetch_array()){ ?>

                                    <option <?php if(isset($_SESSION['abono_factura'])){
                                                    if($_SESSION['abono_factura']['id_tipo_movimiento_bancario'] == $lista_tipo_movimiento['id_tipo_movimiento_bancario'])
                                                    { echo 'selected'; }}
                                     ?> value="<?php echo $lista_tipo_movimiento['id_tipo_movimiento_bancario']; ?>"><?php echo $lista_tipo_movimiento['tmb_nombre']; ?></option>

                                    <?php } ?>
                                </select>
                              </div>
                          </div>
                          <!-- Numero de chequera -->
                          <input type="hidden" name="id_chequera" value="<?php echo $_SESSION['abono_factura']['id_chequera'] ?>">

                        <?php }else{ ?>
                        <div id="select_con_cheques">
                        </div>
                        <?php } ?>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-skill">Beneficiario
                              <span class="text-danger"></span></label>
                            <div class="col-md-7">
                              <input class="form-control" type="text" name="beneficiario" value="<?php if(isset($_SESSION['abono_factura'])){
                               echo $_SESSION['abono_factura']['beneficiario'];
                              }else{ echo $_SESSION['nombre_proveedor'];} ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-email">Fecha <span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <input class="js-datepicker form-control" value="<?php if(isset($_SESSION['abono_factura']['fecha'])){
                                  echo $_SESSION['abono_factura']['fecha'];
                                } ?>" type="text" id="example-datepicker1" data-date-format="d-m-yyyy" name="fecha" placeholder="ingrese el email del usuario" required="required">

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-suggestions">Descripcion <span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <textarea class="form-control" id="val-suggestions" name="descripcion" rows="3" placeholder="Descripcion" required="required"><?php if(isset($_SESSION['abono_factura']['descripcion'])){ echo $_SESSION['abono_factura']['descripcion'];} ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-email">Monto total <span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <input class="form-control" value="<?php echo $monto_total; ?>" type="text" name="monto_documento" placeholder="Monto documento" readonly="readonly">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Monto a pagar <span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <input class="form-control" type="text" readonly value="<?php if(isset($_SESSION['abono_factura']['monto_pagar'])){ echo $_SESSION['abono_factura']['monto_pagar'];}else{ echo $monto_total;} ?>" name="monto_pagar" placeholder="Ingrese el monto" required="required">
                            </div>
                        </div>
                        <?php if(isset($_SESSION['abono_factura'])){ ?>
                                 <input type="hidden" name="confirmacion" value="1">
                        <?php } ?>
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <?php if(isset($_POST['confirmacion'])){ ?> Registro Realizado, Volver al listado de facturas <a href="gc_emitir_pago_2.php?id_proveedor=<?php echo $_SESSION['id_proveedor']; ?>&id_proyecto=<?php echo $id_proyecto; ?>">Volver</a>.
                                <?php }elseif(isset($_SESSION['abono_factura']['monto_pagar'])){ ?>
                                <button class="btn btn-sm btn-primary" type="submit">Confirmar e Imprimir Factura</button>
                                <?php }else{ ?>
                                <button class="btn btn-sm btn-primary" type="submit">Registrar</button>
                                <?php } ?>
                            </div>
                        </div>
                        <input type="hidden" name="id_partida" value="<?php echo $id_partida; ?>">
                        <input type="hidden" name="id_proyecto" value="<?php echo $id_proyecto; ?>">
                        <input type="hidden" name="id_proveedor" value="<?php echo $_SESSION['id_proveedor']; ?>">
                        <input type="hidden" name="id_factura" value="<?php echo $_SESSION['id_factura']; ?>">
                        <input type="hidden" name="nombre_proveedor" value="<?php echo $_SESSION['nombre_proveedor']; ?>">
                    </form>
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
