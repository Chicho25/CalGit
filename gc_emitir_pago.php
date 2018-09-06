<?php if(!isset($_SESSION)){session_start();}?>
<?php require("conexion/conexion.php"); ?>
<?php require("funciones/funciones.php"); ?>
<?php $nombre_pagina = "Emitir Pagos"; ?>
<?php if(isset($_SESSION['session_gc'])){ ?>
<?php $header_bar = 'base_header.php'; ?>
<?php $menu = true; ?>
<?php if(isset($_POST['id_proyecto'])){

      $_SESSION['id_proyecto_pago'] = $_POST['id_proyecto'];
      $_SESSION['id_proveedor'] = $_POST['id_proveedor'];

} ?>
<?php /* ################### Insert del registro ################ */ ?>

<?php
      if(isset($_POST['id'],
                  $_POST['monto_abono'],
                      $_POST['id_cuenta'],
                          $_POST['id_tipo_movimiento_bancario'],
                              $_POST['fecha'],
                                  $_POST['referencia'],
                                      $_POST['monto_abono'],
                                          $_POST['descripcion'])){

      /* ################## en caso de que sea cheque el numero de secuencia se auto genera solo ################# */

        $referencia = $_POST['referencia'];



        if($_POST['id_tipo_movimiento_bancario'] == 8){

                $id_chequera_obtener = obtenert_id_chequera_cuenta($conexion2, $_POST['id_cuenta']);

                $sql_contar_cheques = contar_cheques($conexion2, $id_chequera_obtener);
                while($lista_contar_cheque = $sql_contar_cheques-> fetch_array()){
                      $referencia = $lista_contar_cheque['suma_cheque'];
                      $cheque_no_directo = true;
                      $stat = 11;
                    }
                  }else{$id_chequera_obtener=0;
                        $stat = 1;
                      }

      /* ######################################################################################################### */

        $id_documento_pago = $_POST['id'];
        $monto_abono = $_POST['monto_abono'];
        $id_unico = generarCodigo(6);
        $monto_total = 0;

        foreach($id_documento_pago as $index => $id_pago){

            $sql_insert = $conexion2 -> query("INSERT INTO movimiento_bancario(id_cuenta,
                                                                               id_tipo_movimiento,
                                                                               mb_fecha,
                                                                               mb_referencia_numero,
                                                                               mb_monto,
                                                                               mb_descripcion,
                                                                               mb_stat,
                                                                               id_proveedor,
                                                                               id_partida_documento,
                                                                               id_partida,
                                                                               id_proyecto,
                                                                               id_unico_insert,
                                                                               id_chequera
                                                                               )VALUES(
                                                                                '".$_POST['id_cuenta']."',
                                                                                '".$_POST['id_tipo_movimiento_bancario']."',
                                                                                '".$_POST['fecha']."',
                                                                                '".$referencia."',
                                                                                '".$monto_abono[$index]."',
                                                                                '".$_POST['descripcion']."',
                                                                                '".$stat."',
                                                                                '".$_SESSION['id_proveedor']."',
                                                                                '".$id_pago."',
                                                                                '".$_POST['id_partida'][$index]."',
                                                                                '".$_SESSION['id_proyecto_pago']."',
                                                                                '".$id_unico."',
                                                                                '".$id_chequera_obtener."')");
          $monto_total += $monto_abono[$index];
        }

          /* ####################### Comprobar si el monto ya fue pagado ###################################################### */
          $documento_partida = ver_documentos_emision_pago_pro($conexion2, $_SESSION['id_proyecto_pago'], $_SESSION['id_proveedor']);
          while($lista_documento_partida = $documento_partida -> fetch_array()){

                 $comprobar_monto_total = $lista_documento_partida['pd_monto_total'];
                 $comprobar_restante = $lista_documento_partida['pd_monto_total'] - $monto_restante = monto_restante($conexion2, $lista_documento_partida['id']);

                   if($comprobar_restante <= 0){
                           update_documentos_pagados($conexion2, $lista_documento_partida['id']);
                  }
                  /*echo $comprobar_monto_total.' monto total<br>';
                  echo $comprobar_restante.' monto restante<br>';
                  echo $comprobar_resultado.' Resultado<br>';
                  echo "#####################################";*/
              }
          /* ################################################################################################################### */

      }

 ?>

<?php /* ################ AUDITORIA DE SEGUIMIENTO ############## */ ?>
<?php require("funciones/funciones_auditorias.php"); ?>
<?php $lugar_mapa = 59; ?>
<?php $dispositivo_acceso = obtener_dispositivo(); ?>
<?php insertar_log_seguimiento($conexion2, ObtenerIP(), $dispositivo_acceso, $lugar_mapa, $_SESSION['session_gc']['usua_id']); ?>
<?php /* ######################################################## */ ?>
<?php require 'inc/config.php'; ?>
<?php require 'inc/views/template_head_start.php'; ?>
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/bootstrap-datepicker/bootstrap-datepicker3.min.css">
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/select2/select2.min.css">
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/select2/select2-bootstrap.min.css">
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/sweetalert/sweetalert.min.css">
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/datatables/jquery.dataTables.min.css">
<style>/*
.elemnto1{
    display: none;
}

.elemento2:hover + .elemnto1{
    display: block;
    width: 300px;
    height: 110px;
    border: 2px solid black;
    position: absolute;
    margin-left: -300px;
    margin-top: -110px;
    z-index: 99;
    background-color: #F9FEA1;
}*/
</style>

<script type="text/javascript">
  function suma_campos(){

    <?php $obtener_id_suma = ver_documentos_emision_pago($conexion2, $_SESSION['id_proyecto_pago'], $_SESSION['id_proveedor']); ?>
    var suma_total = 0;
    <?php while($lista_obtener_id_suma = $obtener_id_suma->fetch_array()){ ?>

    var elem_<?php echo $lista_obtener_id_suma['id']; ?> = (isNaN(document.getElementById("t<?php echo $lista_obtener_id_suma['id']; ?>").value) || document.getElementById("t<?php echo $lista_obtener_id_suma['id']; ?>").value == "") ? "0" : document.getElementById("t<?php echo $lista_obtener_id_suma['id']; ?>").value;

     suma_total += parseInt(elem_<?php echo $lista_obtener_id_suma['id']; ?>);

    <?php } ?>
    document.getElementById("res").value = suma_total;
}
</script>
<?php require 'inc/views/template_head_end.php'; ?>
<?php require 'inc/views/base_head.php'; ?>
<!-- Page Header -->
<?php /* ?>
<div class="content bg-gray-lighter">
    <div class="row items-push">
        <div class="col-sm-7">
            <h1 class="page-heading">
                <?php echo $nombre_pagina; ?> <small> <?php echo $nombre_pagina; ?>.</small>
            </h1>
        </div>
    </div>
</div>
<php */ ?>
<!-- END Page Header -->
<?php if(isset($sql_insert)){ ?>
    <div class="col-sm-3 col-lg-3" style="position: absolute; right: 0px;">
        <!-- Success Alert -->
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h3 class="font-w300 push-15">Registrados</h3>
            <p><a class="alert-link" href="javascript:void(0)">Documentos</a> registrados!</p>
        </div>
        <!-- END Success Alert -->
    </div>
<?php } ?>

<div class="content">
    <div class="block">
        <div class="block-header">
            <h3 class="block-title"><?php echo $nombre_pagina; ?> Proveedores <small><?php echo $nombre_pagina; ?></small></h3>
            <ul class="block-options">
                <li>
                  <!--<div class="elemento2 si si-question"></div>
                  <div class="elemnto1">

                    <!--<table style="width:100%" border="2">
                      <tr>
                        <td colspan="2" style="text-align:center"><b>Informacion General</b></td>
                      </tr>
                      <tr>
                        <td>Pagado</td>
                        <td style="Background-color:#21C15C; width:140px;">&nbsp;</td>
                      </tr>
                      <tr>
                        <td>Pendiente / Abonado</td>
                        <td style="Background-color:#EEF581;">&nbsp;</td>
                      </tr>
                      <tr>
                        <td>Vencido</td>
                        <td style="Background-color:#E66666;">&nbsp;</td>
                      </tr>
                      <tr>
                        <td>Pendiente sin abonar</td>
                        <td style="text-align:center">Activo</td>
                      </tr>
                    </table>
                  </div>-->
                </li>
            </ul>
          <?php $detalles_documentos = ver_documentos_emision_pago_detalles($conexion2, $_SESSION['id_proyecto_pago'], $_SESSION['id_proveedor']); ?>
          <?php while($lista_detalles_documento = $detalles_documentos -> fetch_array()){ ?>
          <b>Proyecto:</b> <?php echo $lista_detalles_documento['proy_nombre_proyecto']; ?></br>
          <b>Proveedor:</b> <?php echo $lista_detalles_documento['pro_nombre_comercial']; ?></br>
          <?php
            $proveedor = $lista_detalles_documento['pro_nombre_comercial'];
         } ?>
        </div>
        <div class="block-content">
            <!-- DataTables init on table by adding .js-dataTable-full class, functionality initialized in js/pages/base_tables_datatables.js -->
            <form class="js-validation-bootstrap form-horizontal push-10-t" action="" method="post">
            <div class="table-responsive">
            <table class="table table-bordered table-striped js-dataTable-full">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 2%;">ID</th>
                        <th class="text-center" style="width: 7%;">PARTIDA</th>
                        <th class="text-center" style="width: 5%;">TIPO</th>
                        <th class="text-center" style="width: 5%;">FECHA</th>
                        <th class="text-center" style="width: 5%;">FECHA VENCIMIENTO</th>
                        <th class="text-center" style="width: 5%;">STATUS</th>
                        <th class="text-center" style="width: 5%;">MONTO TOTAL</th>
                        <th class="text-center" style="width: 5%;">MONTO RESTANTE</th>
                        <th class="text-center" style="width: 10%;">MONTO A PAGAR</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $documento_partida = ver_documentos_emision_pago_pro($conexion2, $_SESSION['id_proyecto_pago'], $_SESSION['id_proveedor']); ?>
                    <?php while($lista_documento_partida = $documento_partida -> fetch_array()){ ?>

                    <tr>
                        <input type="hidden" name="id_partida[]" value="<?php echo $lista_documento_partida['id_partida']; ?>">
                        <td class="text-center"><?php echo $lista_documento_partida['id']; ?><input type="hidden" name="id[]" value="<?php echo $lista_documento_partida['id']; ?>"></td>
                        <td class="text-center"><?php echo $lista_documento_partida['p_nombre']; ?></td>
                        <td class="font-w600 text-center"><?php echo $lista_documento_partida['nombre']; ?></td>
                        <td class="text-center"><?php echo $lista_documento_partida['pd_fecha_emision']; ?></td>
                        <td class="text-center"><?php echo $lista_documento_partida['pd_fecha_vencimiento']; ?></td>
                        <td class="text-center"><?php echo $lista_documento_partida['st_nombre']; ?></td>
                        <td class="text-center"><?php echo $lista_documento_partida['pd_monto_total']; ?></td>
                        <td class="text-center">
                          <?php echo $lista_documento_partida['pd_monto_total'] - $monto_restante = monto_restante($conexion2, $lista_documento_partida['id']); ?></td>
                          <?php @$total_monto_restante += $lista_documento_partida['pd_monto_total'] - $monto_restante = monto_restante($conexion2, $lista_documento_partida['id']); ?>
                          <?php $max_input = $lista_documento_partida['pd_monto_total'] - $monto_restante = monto_restante($conexion2, $lista_documento_partida['id']); ?>

                        <td class="text-center">
                          <div class="form-group">
                              <input class="form-control" id="t<?php echo $lista_documento_partida['id']; ?>" onkeyup="suma_campos()" type="text" name="monto_abono[]" min="0" max="<?php echo $max_input; ?>" value="">
                          </div>
                        </td>
                    </tr>
                    <?php @$suma+= ($lista_documento_partida['pd_monto_total']); ?>
                    <?php } ?>
               </tbody>
                    <tr>
                        <th class="text-right" colspan="6">Total</th>
                        <th class="text-center"><?php if(isset($suma)){echo $suma;} ?></th>
                        <th class="text-center"><?php if(isset($total_monto_restante)){echo $total_monto_restante;} ?></th>
                        <th class="text-center"><input class="form-control" id="res" type="text" name="total" value="" readonly> Totales</th>
                    </tr>
            </table>
          </div>
          <div class="form-group">
              <label class="col-md-4 control-label" for="val-username"><span class="text-danger"></span></label>
              <div class="col-md-7">
              </div>
          </div>
            <div class="form-group">
                <label class="col-md-4 control-label" for="val-username">Cuenta<span class="text-danger">*</span></label>
                <div class="col-md-7">


                  <select class="form-control" id="val-select2" name="id_cuenta" style="width: 100%;" data-placeholder="Seleccionar cuenta">
                      <option value="0">Seleccionar</option>
                      <?php $sql_cuenta = movimiento_bancario_cuenta_documento($conexion2, $_SESSION['id_proyecto_pago']); ?>
                      <?php while($lista_cuentas = $sql_cuenta -> fetch_array()){ ?>
                      <?php if($lista_cuentas['monto'] == '' || $lista_cuentas['monto'] <= 0){ continue; } ?>
                      <option value="<?php echo $lista_cuentas['id_cuenta_bancaria']; ?>"
                                     <?php if(isset($_SESSION['session_mb'])){ if($_SESSION['session_mb']['id_cuenta'] == $lista_cuentas['id_cuenta_bancaria']){ echo 'selected'; }} ?>
                       ><?php echo $lista_cuentas['proy_nombre_proyecto']. ' // ' .$lista_cuentas['banc_nombre_banco']. ' // ' .$lista_cuentas['cta_numero_cuenta'].' // '.number_format($lista_cuentas['monto'], 2, ',', '.').'$'; ?></option>

                      <?php } ?>
                  </select>

                    <?php /* ?><select class="js-select2 form-control" id="val-select2" name="id_cuenta" style="width: 100%;" data-placeholder="Seleccionar cuenta" required="required">
                        <option value="0">Seleccionar</option>
                        <?php   $sql_cuenta = movimiento_bancario_cuenta_documento($conexion2, $_SESSION['id_proyecto_pago']); ?>
                        <?php   while($lista_cuentas = $sql_cuenta -> fetch_array()){ ?>
                        <option value="<?php echo $lista_cuentas['id_cuenta_bancaria']; ?>"
                                       <?php if(isset($_SESSION['session_mb'])){ if($_SESSION['session_mb']['id_cuenta'] == $lista_cuentas['id_cuenta_bancaria']){ echo 'selected'; }} ?>
                         ><?php echo $lista_cuentas['proy_nombre_proyecto']. ' // ' .$lista_cuentas['banc_nombre_banco']. ' // ' .$lista_cuentas['cta_numero_cuenta']; ?></option>
                        <?php } ?>
                    </select> */ ?>

                </div>

            </div>
            <div class="form-group">
                <label class="col-md-4 control-label" for="val-username">Tipo <span class="text-danger">*</span></label>
                <div class="col-md-7">
                    <select class="js-select2 form-control" required="required" name="id_tipo_movimiento_bancario" style="width: 100%;" data-placeholder="Seleccionar tipo de movimiento">
                        <option value="0">Seleccionar</option>
                        <?php   $sql_tipo_movimiento = forma_pago($conexion2); ?>
                        <?php   while($lista_tipo_movimiento = $sql_tipo_movimiento -> fetch_array()){ ?>
                                      <?php /* if($lista_tipo_movimiento['id_tipo_movimiento_bancario'] == 8){continue;}*/ ?>
                        <option value="<?php echo $lista_tipo_movimiento['id_tipo_movimiento_bancario']; ?>"
                                       <?php if(isset($_SESSION['session_mb'])){ if($_SESSION['session_mb']['id_tipo_movimiento_bancario'] == $lista_tipo_movimiento['id_tipo_movimiento_bancario']){ echo 'selected'; }} ?>
                         ><?php echo $lista_tipo_movimiento['tmb_nombre']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label" for="val-email">Fecha <span class="text-danger">*</span></label>
                <div class="col-md-7">
                    <input class="js-datepicker form-control" type="text" name="fecha" id="example-datepicker1" data-date-format="yy-mm-dd" required="required" placeholder="Fecha" value="<?php if(isset($_SESSION['session_mb'])){ echo $_SESSION['session_mb']['fecha'];} ?>">

                </div>

            </div>
            <div class="form-group">
                <label class="col-md-4 control-label" for="val-password">Referencia<span class="text-danger">*</span></label>
                <div class="col-md-7">

                  <input class="form-control" type="text" required="required" name="referencia" placeholder="Referencia" value="<?php if(isset($_SESSION['session_mb'])){
                                                                                                                                                      echo $_SESSION['session_mb']['referencia'];} ?>">

                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label" for="val-email">Descripcion <span class="text-danger">*</span></label>
                <div class="col-md-7">
                    <textarea class="form-control" name="descripcion" required="required" placeholder="Descripcion" ><?php if(isset($_SESSION['session_mb'])){ echo $_SESSION['session_mb']['descripcion'];} ?></textarea>
                </div>

            </div>
            <div class="form-group">
                <label class="col-md-4 control-label" for="val-email"> <span class="text-danger"></span></label>
                <div class="col-md-7">
                    <input value="Enviar" type="submit" class="btn btn-primary">
                </div>
            </div>
          </form>
          <?php if(isset($cheque_no_directo) && $cheque_no_directo == true){ ?>
            <center>
              <?php include_once("letras.php"); ?>
              <?php $letras = num2letras($monto_total); ?>
            <iframe height="400" width="1000" src="incluidos/print.php?ID_PAGO=<?php echo $referencia; ?>&BENEFICIARIO=<?php echo $proveedor; ?>&DESCRIPCION=<?php echo $_POST['descripcion']; ?>&MONTO=<?php echo $monto_total; ?>&MONTO_LETRAS=<?php echo $letras; ?>"></iframe>
            </center>
          <?php } ?>
        </div>
    </div>
</div>


<?php require 'inc/views/base_footer.php'; ?>
<?php require 'inc/views/template_footer_start.php'; ?>
<!-- Page JS Plugins -->

<script src="<?php echo $one->assets_folder; ?>/js/plugins/select2/select2.full.min.js"></script>
<script src="<?php echo $one->assets_folder; ?>/js/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="<?php echo $one->assets_folder; ?>/js/plugins/jquery-validation/additional-methods.min.js"></script>

<script type="text/javascript" src="bootstrap-filestyle.min.js"></script>
<script src="<?php echo $one->assets_folder; ?>/js/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo $one->assets_folder; ?>/js/pages/base_tables_datatables.js"></script>

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
        // Init page helpers (Select2 plugin)
        App.initHelpers('select2');
    });
</script>
<script src="<?php echo $one->assets_folder; ?>/js/pages/base_forms_validation.js"></script>
<!-- Page JS Code -->
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
            window.location="salir.php";
        </script>

<?php } ?>
