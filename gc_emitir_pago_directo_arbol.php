<?php if(!isset($_SESSION)){session_start();}?>
<?php require("conexion/conexion.php"); ?>
<?php require("funciones/funciones.php"); ?>
<?php $nombre_pagina = "Emitir Pagos"; ?>
<?php if(isset($_SESSION['session_gc'])){ ?>
<?php $header_bar = 'base_header.php'; ?>
<?php $menu = true; ?>
<?php if(isset($_GET['id_proyecto'])){

    /* agregado 09/11/2016 */
    /* funcion para obtener el id de la partida inicial */
    function obtener_id_partida_inicial($conexion2, $id_partida){

      $sql = $conexion2 -> query("select id_proyecto from maestro_partidas where id = '".$id_partida."'");
      while($r=$sql->fetch_array()){
            return $r['id_proyecto'];
      }
      /* $sql2 = $conexion2 -> query("select min(id) as id_partida from maestro_partidas where id_proyecto = '".$proyecto."'");
      while($r2=$sql2->fetch_array()){
            return $r2['id_partida'];
      } */
    }

    /* fin del agregado */

      $id_proyecto_arbol = obtener_id_partida_inicial($conexion2, $_GET['id_proyecto']);

      /*echo $id_proyecto_arbol;*/

      $_SESSION['id_proyecto_pago'] = $id_proyecto_arbol;
      $_SESSION['id_proveedor'] = $_GET['id_proveedor'];
      $_SESSION['id'] = $_GET['id'];

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
                $sql_contar_cheques = contar_cheques($conexion2, $_POST['id_cuenta']);
                while($lista_contar_cheque = $sql_contar_cheques-> fetch_array()){
                      $referencia = $lista_contar_cheque['suma_cheque'];
                }
             }

      /* ######################################################################################################### */

        $id_documento_pago = $_POST['id'];
        $monto_abono = $_POST['monto_abono'];
        $id_unico = generarCodigo(6);

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
                                                                               id_unico_insert
                                                                               )VALUES(
                                                                                '".$_POST['id_cuenta']."',
                                                                                '".$_POST['id_tipo_movimiento_bancario']."',
                                                                                '".$_POST['fecha']."',
                                                                                '".$referencia."',
                                                                                '".$monto_abono[$index]."',
                                                                                '".$_POST['descripcion']."',
                                                                                1,
                                                                                '".$_SESSION['id_proveedor']."',
                                                                                '".$id_pago."',
                                                                                '".$_POST['id_partida'][$index]."',
                                                                                '".$_SESSION['id_proyecto_pago']."',
                                                                                '".$id_unico."')");
        }

          /* ####################### Comprobar si el monto ya fue pagado ###################################################### */
          $documento_partida = ver_documentos_emision_pago($conexion2, $_SESSION['id_proyecto_pago'], $_SESSION['id_proveedor'], $_SESSION['id']);
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

<?php if(isset($sql_insert)){ ?>
    <div class="col-sm-3 col-lg-3" style="position: absolute; right: 0px;">

        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h3 class="font-w300 push-15">Registrados</h3>
            <p><a class="alert-link" href="javascript:void(0)">Documentos</a> registrados!</p>
        </div>

    </div>
<?php } ?>

<div class="content">
    <div class="block">
        <div class="block-header">
            <h3 class="block-title"><?php echo $nombre_pagina; ?> Proveedores <small><?php echo $nombre_pagina; ?></small></h3>
            <?php /* ?><ul class="block-options">
                <li>

                  <div class="elemento2 si si-question"></div>
                  <div class="elemnto1">

                    <table style="width:100%" border="2">
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
                  </div>
                </li>
            </ul>*/ ?>
          <?php $detalles_documentos = ver_documentos_emision_pago_detalles($conexion2, $_SESSION['id_proyecto_pago'], $_SESSION['id_proveedor']); ?>
          <?php while($lista_detalles_documento = $detalles_documentos -> fetch_array()){ ?>
          <b>Proyecto:</b> <?php echo $lista_detalles_documento['proy_nombre_proyecto']; ?></br>
          <b>Proveedor:</b> <?php echo $lista_detalles_documento['pro_nombre_comercial']; ?></br>
          <?php } ?>
        </div>
        <div class="block-content">

            <form class="form-horizontal push-10-t" action="" method="post">
            <div class="table-responsive">
            <table class="table table-bordered table-striped js-dataTable-full">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 2%;">ID</th>
                        <th class="text-center" style="width: 7%;">PARTIDA</th>
                        <th class="text-center" style="width: 7%;">DETALLE</th>
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
                    <?php $documento_partida = ver_documentos_emision_pago($conexion2, $_SESSION['id_proyecto_pago'], $_SESSION['id_proveedor'], $_SESSION['id']); ?>
                    <?php while($lista_documento_partida = $documento_partida -> fetch_array()){ ?>

                    <tr>
                        <input type="hidden" name="id_partida[]" value="<?php echo $lista_documento_partida['id_partida']; ?>">
                        <td class="text-center"><?php echo $lista_documento_partida['id']; ?><input type="hidden" name="id[]" value="<?php echo $lista_documento_partida['id']; ?>"></td>
                        <td class="text-center"><?php echo $lista_documento_partida['p_nombre']; ?></td>
                        <td class="text-center"><?php echo $lista_documento_partida['pd_descripcion']; ?></td>
                        <td class="font-w600 text-center"><?php echo $lista_documento_partida['nombre']; ?></td>
                        <td class="text-center"><?php echo $lista_documento_partida['pd_fecha_emision']; ?></td>
                        <td class="text-center"><?php echo $lista_documento_partida['pd_fecha_vencimiento']; ?></td>
                        <td class="text-center"><?php echo $lista_documento_partida['st_nombre']; ?></td>
                        <td class="text-center"><?php echo number_format($lista_documento_partida['pd_monto_total'], 2, ',', '.'); ?></td>
                        <td class="text-center">

                          <?php echo number_format($lista_documento_partida['pd_monto_total'] - $monto_restante = monto_restante($conexion2, $lista_documento_partida['id']), 2, ',', '.'); ?></td>
                          <?php @$total_monto_restante += $lista_documento_partida['pd_monto_total'] - $monto_restante = monto_restante($conexion2, $lista_documento_partida['id']); ?>
                          <?php $max_input = $lista_documento_partida['pd_monto_total'] - $monto_restante = monto_restante($conexion2, $lista_documento_partida['id']);  ?>

                        <td class="text-center">
                          <div class="form-group">
                              <input class="form-control" id="t<?php echo $lista_documento_partida['id']; ?>" onkeyup="suma_campos()" type="text" autocomplete="off" name="monto_abono[]" min="0" max="<?php echo $max_input; ?>" value="">
                          </div>
                        </td>
                    </tr>
                    <?php @$suma+= ($lista_documento_partida['pd_monto_total']); ?>
                    <?php } ?>
               </tbody>
                    <tr>
                        <th class="text-right" colspan="7">Total</th>
                        <th class="text-center"><?php if(isset($suma)){echo number_format($suma, 2, ',', '.');} ?></th>
                        <th class="text-center"><?php if(isset($total_monto_restante)){echo number_format($total_monto_restante, 2, ',', '.');} ?></th>
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

                    <select class="js-select2 form-control" id="val-select2" name="id_cuenta" style="width: 100%;" data-placeholder="Seleccionar cuenta" required="required">
                        <option value="0">Seleccionar</option>
                        <?php $sql_cuenta = movimiento_bancario_cuenta_documento($conexion2, $_SESSION['id_proyecto_pago']); ?>
                        <?php while($lista_cuentas = $sql_cuenta -> fetch_array()){ ?>
                        <?php if($lista_cuentas['monto'] == '' || $lista_cuentas['monto'] <= 0){ continue; } ?>
                        <option value="<?php echo $lista_cuentas['id_cuenta_bancaria']; ?>"
                                       <?php if(isset($_SESSION['session_mb'])){ if($_SESSION['session_mb']['id_cuenta'] == $lista_cuentas['id_cuenta_bancaria']){ echo 'selected'; }} ?>
                         ><?php echo $lista_cuentas['proy_nombre_proyecto']. ' // ' .$lista_cuentas['banc_nombre_banco']. ' // ' .$lista_cuentas['cta_numero_cuenta'].' // '.number_format($lista_cuentas['monto'], 2, ',', '.').'$'; ?></option>

                        <?php } ?>
                    </select>

                </div>

            </div>
            <div class="form-group">
                <label class="col-md-4 control-label" for="val-username">Tipo <span class="text-danger">*</span></label>
                <div class="col-md-7">

                    <select class="js-select2 form-control" id="val-select2" name="id_tipo_movimiento_bancario" style="width: 100%;" data-placeholder="Seleccionar tipo de movimiento" required="required">
                        <option value="0">Seleccionar</option>
                        <?php   $sql_tipo_movimiento = forma_pago($conexion2); ?>
                        <?php   while($lista_tipo_movimiento = $sql_tipo_movimiento -> fetch_array()){ ?>
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
                    <input class="js-datepicker form-control" autocomplete="off" type="text" name="fecha" id="example-datepicker1" data-date-format="yy-mm-dd" required="required" placeholder="Fecha" value="<?php if(isset($_SESSION['session_mb'])){ echo $_SESSION['session_mb']['fecha'];} ?>">

                </div>

            </div>
            <div class="form-group">
                <label class="col-md-4 control-label" for="val-password">Referencia<span class="text-danger">*</span></label>
                <div class="col-md-7">

                  <input class="form-control" autocomplete="off" type="text" id="val-username" name="referencia" placeholder="Referencia" value="<?php if(isset($_SESSION['session_mb'])){
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
