<?php if(!isset($_SESSION)){session_start();}?>
<?php require("conexion/conexion.php"); ?>
<?php require("funciones/funciones.php"); ?>
<?php if(isset($_SESSION['session_gc'])){ ?>
<?php $header_bar = 'base_header.php'; ?>
<?php $menu = true; ?>
<?php /* ################ AUDITORIA DE SEGUIMIENTO ############## */ ?>
<?php require("funciones/funciones_auditorias.php"); ?>
<?php $lugar_mapa = 64; ?>
<?php $dispositivo_acceso = obtener_dispositivo(); ?>
<?php insertar_log_seguimiento($conexion2, ObtenerIP(), $dispositivo_acceso, $lugar_mapa, $_SESSION['session_gc']['usua_id']); ?>
<?php /* ######################################################## */ ?>
<?php require 'inc/config.php'; ?>
<?php require 'inc/views/template_head_start.php'; ?>
<!-- Page JS Plugins CSS -->
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/select2/select2.min.css">
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/select2/select2-bootstrap.min.css">
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/datatables/jquery.dataTables.min.css">
<?php require 'inc/views/template_head_end.php'; ?>
<script language="javascript">
$(document).ready(function(){
   $("#marca").change(function () {
           $("#marca option:selected").each(function () {
            elegido=$(this).val();
            $.post("select_grupos.php", { elegido: elegido }, function(data){
            $("#modelo").html(data);
            });
        });
   })
});
</script>
<?php require 'inc/views/base_head.php'; ?>

<div class="content content-narrow">
      <div class="row">

          <div class="col-lg-12">
              <div class="block">
                  <div class="block-header">

                      <ul class="block-options">
                          <li>
                            <code></code>
                          </li>
                      </ul>
                      <h3 class="block-title">seleccione un proyecto</h3><small></small>
                  </div>
                  <div class="block-content block-content-narrow">
                      <form class="js-validation-bootstrap form-horizontal" action="reportes/gc_reporte_2.php" method="post" target="_blank">
                          <div class="form-group">
                              <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="val-username">Proyecto</label>
                                    <div class="col-md-7">
                                  <select class="js-select2 form-control" id="marca" name="id_proyecto" style="width: 100%;" data-placeholder="Seleccionar Proyecto" required="required">
                                      <option></option>
                                      <?php $sql_proyecto = seleccionar_proyecto($conexion2); ?>
                                      <?php while($lista_proyecto = $sql_proyecto -> fetch_array()){ ?>
                                      <option value="<?php echo $lista_proyecto['id_proyecto']; ?>" <?php if(isset($_POST['id_proyecto'])){
                                        if($lista_proyecto['id_proyecto'] == $_POST['id_proyecto']){ echo "selected";}
                                      } ?>><?php echo $lista_proyecto['proy_nombre_proyecto']; ?></option>
                                      <?php } ?>
                                  </select>
                                </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="val-username">Grupo inmuebles</label>
                                    <div class="col-md-7">
                                        <select class="form-control" id="modelo" name="grupo_inmueble" style="width: 100%;" data-placeholder="Seleccionar tipo de movimiento">


                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="val-username">Tipo</label>
                                    <div class="col-md-7">
                                        <select class="form-control" name="tipo_reporte" style="width: 100%;">
                                          <option value="">Seleccionar</option>
                                          <option value="1">Detallado</option>
                                          <option value="2">No Detallado</option>
                                        </select>
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

                      <?php if(isset($_POST['id_proyecto'])){ ?>
                        <table class="table table-bordered table-striped js-dataTable-full">
                            <thead>
                                <tr>
                                    <th class="text-center">Grupo del Inmueble</th>
                                    <th class="text-center">Nombre del Inmueble </th>
                                    <th class="hidden-xs">Nombre del Cliente</th>
                                    <th class="hidden-xs" style="width: 15%;">Vendido</th>
                                    <th class="text-center" style="width: 10%;">Ver Reporte</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $reporte1 = reporte_2($conexion2, $_POST['id_proyecto']); ?>
                                <?php while($r1 = $reporte1->fetch_array()){ ?>
                                <tr>
                                    <td class="text-center"><?php echo $r1['gi_nombre_grupo_inmueble']; ?></td>
                                    <td class="font-w600"><?php echo $r1['mi_nombre']; ?></td>
                                    <td class="hidden-xs"><?php echo $r1['nombre']; ?></td>
                                    <td class="hidden-xs"><?php echo $r1['monto_vendido']; ?></td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                          <form class="" action="reportes/gc_reporte_2.php" method="post" target="_blank">
                                           <input type="hidden" name="id_proyecto" value="<?php echo $_POST['id_proyecto']; ?>">
                                          <?php /*  <input type="hidden" name="inmueble" value="<?php echo $r1['mi_nombre']; ?>">
                                            <input type="hidden" name="cliente" value="<?php echo $r1['cl_nombre'].' '.$r1['cl_apellido']; ?>">
                                            <input type="hidden" name="modelo" value="<?php echo $r1['mi_modelo']; ?>"> */ ?>
                                            <button class="btn btn-default" type="submit"><i class="fa fa-file-pdf-o"></i></button>
                                          </form>
                                        </div>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                      <?php } ?>

                  </div>
              <!-- Bootstrap Forms Validation -->
              </div>
          </div>
      </div>
</div>

<?php require 'inc/views/base_footer.php'; ?>
<?php require 'inc/views/template_footer_start.php'; ?>
<!-- Page JS Plugins -->

<script src="<?php echo $one->assets_folder; ?>/js/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo $one->assets_folder; ?>/js/pages/base_tables_datatables.js"></script>

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
