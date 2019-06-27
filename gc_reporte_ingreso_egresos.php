<?php if(!isset($_SESSION)){session_start();}?>
<?php require("conexion/conexion.php"); ?>
<?php require("funciones/funciones.php"); ?>
<?php if(isset($_SESSION['session_gc'])){ ?>
<?php $header_bar = 'base_header.php'; ?>
<?php $menu = true; ?>
<?php /* ################ AUDITORIA DE SEGUIMIENTO ############## */ ?>
<?php require("funciones/funciones_auditorias.php"); ?>
<?php $lugar_mapa = 57; ?>
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
      <div class="row">
          <div class="col-lg-12">
              <div class="block">
                  <div class="block-header">
                      <h3 class="block-title">Reporte de Egresos Excel Marina</h3>
                  </div>
                  <div class="block-content block-content-narrow">
                      <form class="js-validation-bootstrap form-horizontal" action="reportes/pc_reporte_egresos.php" method="post" target="_blank">
                          <div class="form-group">
                              <div class="col-md-12">
                                <div class="form-group">
                                      <label class="col-md-4 control-label" for="val-username">Proyecto</label>
                                      <div class="col-md-7">
                                        <?php $sql = $conexion2 -> query("select * from maestro_proyectos where id_proyecto = 36"); ?>
                                        <select class="form-control" style="width: 100%;" name="id_proyecto">
                                            <option value="">Seleccionar Proyecto</option>
                                            <?php while($q=$sql->fetch_array()){ ?>
                                            <option value="<?php echo $q['id_proyecto']; ?>"><?php echo $q['proy_nombre_proyecto']; ?></option>
                                            <?php } ?>
                                        </select>
                                  </div>
                                </div>


                                  <div class="form-group">
                                      <label class="col-md-4 control-label" for="val-username">Partida <span class="text-danger"></span></label>
                                      <div class="col-md-7">

                                          <select class="form-control"
                                                  name="id_partida"
                                                  style="width: 100%;"
                                                  data-placeholder="Seleccionar Partida">
                                              <option>Seleccionar</option>
                                              <option value="resumen">Resumido</option>
                                              <option value="todos">Detallado</option>
                                          </select>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label class="col-md-4 control-label" for="val-password">Fecha Doc.</label>
                                      <div class="col-md-7">
                                        <div class="input-group input-daterange doc">
                                            <input type="text" class="js-datepicker form-control fechas1" name="fecha_a_ini" placeholder="Desde" autocomplete="off">
                                            <div style="min-width: 0px" class="input-group-addon"></div>
                                            <input type="text" class="js-datepicker form-control fechas1" name="fecha_a_fin" placeholder="Hasta" autocomplete="off">
                                        </div>
                                        <!--<input class="js-datepicker form-control" autocomplete="off" type="text" name="fecha_emision" id="example-datepicker1"  placeholder="Desde" value="">-->
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <div class="col-md-8 col-md-offset-4">
                                        <button class="btn btn-sm btn-primary" type="submit">Buscar</button>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </form>
                </div>
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
        App.initHelpers(['datetimepicker', 'colorpicker', 'maxlength', 'select2', 'rangeslider',]); // 'masked-inputs',  'tags-inputs'
    });
    function init()
    {
      $(".doc").datepicker({
        input: $(".fechas1"),
        format: 'yyyy-mm-dd'
      });
      $(".venc").datepicker({
        input: $(".fechas2"),
        format: 'yyyy-mm-dd'
      });
    }
    window.onload = init;
</script>
<?php require 'inc/views/template_footer_end.php'; ?>
<?php }else{ ?>
        <script type="text/javascript">
            window.location="salir.php";
        </script>
<?php } ?>
