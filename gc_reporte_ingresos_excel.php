<?php if(!isset($_SESSION)){session_start();}?>
<?php require("conexion/conexion.php"); ?>
<?php require("funciones/funciones.php"); ?>
<?php if(isset($_SESSION['session_gc'])){ ?>
<?php $header_bar = 'base_header.php'; ?>
<?php $menu = true; ?>
<?php /* ################ AUDITORIA DE SEGUIMIENTO ############## */ ?>
<?php require("funciones/funciones_auditorias.php"); ?>
<?php $lugar_mapa = 45; ?>
<?php $dispositivo_acceso = obtener_dispositivo(); ?>
<?php insertar_log_seguimiento($conexion2, ObtenerIP(), $dispositivo_acceso, $lugar_mapa, $_SESSION['session_gc']['usua_id']); ?>
<?php /* ######################################################## */ ?>

<?php require 'inc/config.php'; ?>
<?php require 'inc/views/template_head_start.php'; ?>
<!-- Page JS Plugins CSS -->
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/bootstrap-datepicker/bootstrap-datepicker3.min.css">
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/select2/select2.min.css">
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/select2/select2-bootstrap.min.css">
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/sweetalert/sweetalert.min.css">
<?php require 'inc/views/template_head_end.php'; ?>
<?php require 'inc/views/base_head.php'; ?>
<div class="content content-narrow">
    <!-- Forms Row -->
    <div class="row">

        <div class="col-lg-12">
            <!-- Bootstrap Forms Validation -->
            <div class="block">
                <div class="block-header">
                    <ul class="block-options">
                        <li>

                        </li>
                    </ul>
                    <h3 class="block-title">Reporte de Ingresos</h3><small> Los campos con <span class="text-danger">*</span> son obligatorios</small>
                </div>
                <div class="block-content block-content-narrow">
                    <!-- jQuery Validation (.js-validation-bootstrap class is initialized in js/pages/base_forms_validation.js) -->
                    <!-- For more examples you can check out https://github.com/jzaefferer/jquery-validation -->
                    <form class="form-horizontal" action="gc_report_ingreso_excel.php" method="post" target="_blank">
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="val-username">Tipo<span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <select class="js-select2 form-control" name="id_termino" style="width: 100%;" data-placeholder="Seleccionar Termino">
                                    <option value="">Selecionar</option>
                                    <option value="1">Resumen</option>
                                    <option value="2">Detallado</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Fecha</label>
                            <div class="col-md-9">
                              <div class="input-group input-daterange gcreacion">
                                  <input type="text" class="js-datepicker form-control fechas1" autocomplete="off" name="fvencimiento_inicio" placeholder="Desde">
                                  <div style="min-width: 0px" class="input-group-addon"></div>
                                  <input type="text" class="js-datepicker form-control fechas1" autocomplete="off" name="fvencimiento_fin" placeholder="Hasta">
                              </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-username"><span class="text-danger"></span></label>
                            <div class="col-md-8">
                                <button class="btn btn-sm btn-primary" type="submit" style="width:250px;">Consultar</button>
                            </div>
                        </div>
                    </form>
            </div>
            <!-- Bootstrap Forms Validation -->
        </div>
    </div>
</div>
</div>

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
