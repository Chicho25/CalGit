<?php if(!isset($_SESSION)){session_start();}?>
<?php require("conexion/conexion.php"); ?>
<?php require("funciones/funciones.php"); ?>
<?php if(isset($_SESSION['session_gc'])){ ?>
<?php $header_bar = 'base_header.php'; ?>
<?php $menu = true; ?>
<?php /* ################ AUDITORIA DE SEGUIMIENTO ############## */ ?>
<?php require("funciones/funciones_auditorias.php"); ?>
<?php $lugar_mapa = 48; ?>
<?php $dispositivo_acceso = obtener_dispositivo(); ?>
<?php insertar_log_seguimiento($conexion2, ObtenerIP(), $dispositivo_acceso, $lugar_mapa, $_SESSION['session_gc']['usua_id']); ?>
<?php /* ######################################################## */ ?>

<?php if(isset($_POST['confirmacion'])){
      $sql_insertar = $conexion2 -> query("insert into movimiento_bancario(
                                                  id_cuenta,
                                                  id_tipo_movimiento,
                                                  mb_fecha,
                                                  mb_referencia_numero,
                                                  mb_monto,
                                                  mb_descripcion,
                                                  mb_stat,
                                                  movimiento_directo
                                                  )values(
                                                  '".$_POST['id_cuenta']."',
                                                  '".$_POST['id_tipo_movimiento_bancario']."',
                                                  '".date("Y-m-d", strtotime($_POST['fecha']))."',
                                                  '".$_POST['referencia']."',
                                                  '".$_POST['monto']."',
                                                  '".strtoupper($_POST['descripcion'])."',
                                                   1,
                                                   1)");

       /* Auditoria  */
       $tipo_operacion = 1;
       $comentario = "Registro de Movimiento Bancario";
       $sql_auditoria = $conexion2 -> query("INSERT INTO auditoria_movimiento_bancario(
                                                         amb_tipo_operacion,
                                                         amb_comentario,
                                                         amb_log_user,
                                                         amb_id_cuenta,
                                                         amb_id_tipo_movimiento,
                                                         amb_mb_fecha,
                                                         amb_mb_referencia_numero,
                                                         amb_mb_monto,
                                                         amb_mb_descripcion,
                                                         amb_mb_stat
                                                         )VALUES(
                                                         '".$tipo_operacion."',
                                                         '".$comentario."',
                                                         '".$_SESSION['session_gc']['usua_id']."',
                                                         '".$_POST['id_cuenta']."',
                                                         '".$_POST['id_tipo_movimiento_bancario']."',
                                                         '".date("Y-m-d", strtotime($_POST['fecha']))."',
                                                         '".$_POST['referencia']."',
                                                         '".$_POST['monto']."',
                                                         '".strtoupper($_POST['descripcion'])."',
                                                          1)");

                                                 } ?>

<?php require 'inc/config.php'; ?>
<?php require 'inc/views/template_head_start.php'; ?>

<!-- Page JS Plugins CSS -->
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/bootstrap-datepicker/bootstrap-datepicker3.min.css">
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/select2/select2.min.css">
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/select2/select2-bootstrap.min.css">
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/sweetalert/sweetalert.min.css">
<?php require 'inc/views/template_head_end.php'; ?>
<script type="text/javascript">
$(document).ready(function() {
   $("#datepicker").datepicker();
});
</script>
<?php require 'inc/views/base_head.php'; ?>
<div class="content content-narrow">
    <!-- Forms Row -->
    <div class="row">
      <?php if(isset($sql_insertar)){ ?>
              <div class="alert alert-success alert-dismissable">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <h3 class="font-w300 push-15">Registrado</h3>
                  <p>El <a class="alert-link" href="javascript:void(0)">Movimiento Bancario</a> registrado!</p>
              </div>
      <?php }elseif(isset($existe_registro)){ ?>
            <div class="alert alert-warning alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h3 class="font-w300 push-15">Ya existe el registro</h3>
                <p>Ya existe un registro con esa referencia</p>
            </div>
      <?php } ?>
        <div class="col-lg-12">
            <!-- Bootstrap Forms Validation -->
            <div class="block">
                <div class="block-header">
                    <ul class="block-options">
                        <li>
                        </li>
                    </ul>
                    <h3 class="block-title">Registrar movimiento bancario</h3><small> Los campos con <span class="text-danger">*</span> son obligatorios</small>
                </div>
                <div class="block-content block-content-narrow">
                    <!-- jQuery Validation (.js-validation-bootstrap class is initialized in js/pages/base_forms_validation.js) -->
                    <!-- For more examples you can check out https://github.com/jzaefferer/jquery-validation -->
                    <form class="js-validation-bootstrap form-horizontal" action="" method="post">
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-username">Cuenta<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <select class="js-select2 form-control" id="val-select2" name="id_cuenta" style="width: 100%;" data-placeholder="Seleccionar cuenta" required="required">
                                    <option></option>
                                    <?php   $sql_cuenta = movimiento_bancario_cuenta($conexion2); ?>
                                    <?php   while($lista_cuentas = $sql_cuenta -> fetch_array()){ ?>
                                    <option value="<?php echo $lista_cuentas['id_cuenta_bancaria']; ?>"
                                                   <?php if(isset($_SESSION['session_mb'])){ if($_SESSION['session_mb']['id_cuenta'] == $lista_cuentas['id_cuenta_bancaria']){ echo 'selected'; }} ?>
                                     ><?php echo $lista_cuentas['proy_nombre_proyecto']. ' // ' .$lista_cuentas['banc_nombre_banco']. ' // ' .$lista_cuentas['cta_numero_cuenta']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-email">Tipo</label>
                            <div class="col-md-7">
                              <select class="js-select2 form-control" id="marca" name="tipo" style="width: 100%;" data-placeholder="Seleccionar tipo">
                                  <option></option>
                                  <option value="1">Debito</option>
                                  <option value="2">Credito</option>
                              </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-username">Tipo de Movimiento</label>
                            <div class="col-md-7">
                                <select class="js-select2 form-control" id="modelo" name="id_tipo_movimiento_bancario" style="width: 100%;" data-placeholder="Seleccionar tipo de movimiento">
                                </select>
                            </div>
                        </div>
                        <?php /* ?>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-username">Tipo <span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <select class="js-select2 form-control" id="val-select2" name="id_tipo_movimiento_bancario" style="width: 100%;" data-placeholder="Seleccionar tipo de movimiento" required="required">
                                    <option></option>
                                    <?php   $sql_tipo_movimiento = tipo_movimiento_bancario($conexion2); ?>
                                    <?php   while($lista_tipo_movimiento = $sql_tipo_movimiento -> fetch_array()){ ?>
                                    <option value="<?php echo $lista_tipo_movimiento['id_tipo_movimiento_bancario']; ?>"
                                                   <?php if(isset($_SESSION['session_mb'])){ if($_SESSION['session_mb']['id_tipo_movimiento_bancario'] == $lista_tipo_movimiento['id_tipo_movimiento_bancario']){ echo 'selected'; }} ?>
                                     ><?php echo $lista_tipo_movimiento['tmb_nombre']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <?php */ ?>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-email">Fecha <span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <input class="js-datepicker form-control" autocomplete="off" type="text" name="fecha" id="example-datepicker1" data-date-format="dd-mm-yyyy" required="required" placeholder="Fecha" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-password">Referencia<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                              <input class="form-control" type="text" id="val-username" autocomplete="off" name="referencia" required="required" placeholder="Referencia" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-password">Monto<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                              <input class="form-control" autocomplete="off" type="number" id="val-username" name="monto" required="required" placeholder="Monto" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-email">Descripcion <span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <textarea class="form-control" name="descripcion" required="required" placeholder="Descripcion" ></textarea>
                            </div>
                        </div>
                        <input type="hidden" name="confirmacion" value="1">
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <?php if(isset($sql_insertar)){ ?> El registro fue realizado, usted sera redirecionado <?php }elseif(isset($_SESSION['session_mb'])){?> <button class="btn btn-sm btn-primary" type="submit">Confirmar Registro</button> <?php }else{ ?> <button class="btn btn-sm btn-primary" type="submit">Registrar</button> <?php } ?>
                            </div>
                        </div>
                    </form>
            </div>
            <!-- Bootstrap Forms Validation -->
        </div>
    </div>
</div>
</div>
<script language="javascript">
$(document).ready(function(){
   $("#marca").change(function () {
           $("#marca option:selected").each(function () {
            elegido=$(this).val();
            $.post("select_movimientos.php", { elegido: elegido }, function(data){
            $("#modelo").html(data);
            });
        });
   })
});
</script>

<?php if(isset($sql_insertar)){

        unset($_SESSION['session_mb']); ?>

        <script type="text/javascript">
            function redireccionarPagina() {
              /*window.location = "gc_principal.php";*/
            }
            setTimeout("redireccionarPagina()", 5000);
        </script>

<?php } ?>

<?php require 'inc/views/base_footer.php'; ?>
<?php require 'inc/views/template_footer_start.php'; ?>
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
            window.location="salir.php";
        </script>

<?php } ?>
