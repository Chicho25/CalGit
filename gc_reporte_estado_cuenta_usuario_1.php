<?php if(!isset($_SESSION)){session_start();}?>
<?php require("conexion/conexion.php"); ?>
<?php require("funciones/funciones.php"); ?>
<?php if(isset($_SESSION['session_gc'])){ ?>
<?php $header_bar = 'base_header.php'; ?>
<?php $menu = true; ?>
<?php /* ################ AUDITORIA DE SEGUIMIENTO ############## */ ?>
<?php require("funciones/funciones_auditorias.php"); ?>
<?php $lugar_mapa = 63; ?>
<?php $dispositivo_acceso = obtener_dispositivo(); ?>
<?php insertar_log_seguimiento($conexion2, ObtenerIP(), $dispositivo_acceso, $lugar_mapa, $_SESSION['session_gc']['usua_id']); ?>
<?php /* ######################################################## */ ?>
<?php require 'inc/config.php'; ?>
<?php require 'inc/views/template_head_start.php'; ?>
<!-- Page JS Plugins CSS -->
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/bootstrap-datepicker/bootstrap-datepicker3.min.css">
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/select2/select2.min.css">
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/select2/select2-bootstrap.min.css">
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/datatables/jquery.dataTables.min.css">
<?php require 'inc/views/template_head_end.php'; ?>
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
                      <h3 class="block-title">seleccione un proyecto</h3><small> </small>
                  </div>
                  <div class="block-content block-content-narrow">
                      <form class="js-validation-bootstrap form-horizontal" action="" method="post">
                          <div class="form-group">
                              <label class="col-md-4 control-label" for="val-select2">Seleccione un proyecto</label>
                              <div class="col-md-7">
                                  <select class="js-select2 form-control" id="val-select2" name="id_proyecto" style="width: 100%;" data-placeholder="Seleccionar Proyecto" required="required">
                                      <option></option>
                                      <?php $sql_proyecto = reporte1_ver_proyecto($conexion2); ?>
                                      <?php while($lista_proyecto = $sql_proyecto -> fetch_array()){ ?>
                                      <option value="<?php echo $lista_proyecto['id_proyecto']; ?>" <?php if(isset($_POST['id_proyecto'])){
                                        if($lista_proyecto['id_proyecto'] == $_POST['id_proyecto']){ echo "selected";}
                                      } ?>><?php echo $lista_proyecto['proy_nombre_proyecto']; ?></option>
                                      <?php } ?>
                                  </select>
                              </div>
                          </div>

                           <div class="form-group">
                                <label class="col-md-4 control-label">Seleccione un Cliente</label>
                                <div class="col-md-7">
                                  <select class="js-select2 form-control" id="sel-cliente" name="id_cliente" style="width: 100%;" data-placeholder="Selecionar un Cliente" required="required">
                                    <?php if(isset($_POST['id_proyecto'])){
                                        $query = "SELECT maestro_clientes.id_cliente, CONCAT_WS(' ', cl_nombre, cl_apellido) AS nombre_c FROM maestro_clientes
                                                  INNER JOIN maestro_ventas ON maestro_ventas.id_cliente = maestro_clientes.id_cliente
                                                  WHERE id_proyecto = ".$_POST['id_proyecto']." GROUP BY maestro_clientes.id_cliente";
                                        $r = mysqli_query($conexion2, $query);
                                        while($fila = mysqli_fetch_array($r, MYSQLI_ASSOC))
                                        {
                                         ?><option value="<?php echo $fila['id_cliente'] ?>" <?php if($_POST['id_cliente'] == $fila['id_cliente']) echo 'selected' ?>><?php echo $fila['nombre_c'] ?></option><?php
                                        }
                                      }
                                    ?>
                                  </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Fecha de Creación</label>
                                <div class="col-md-7">
                                  <div class="input-group input-daterange gcreacion">
                                      <input type="text" class="js-datepicker form-control fechas1" name="fcreacion_inicio" placeholder="Desde">
                                      <div style="min-width: 0px" class="input-group-addon"></div>
                                      <input type="text" class="js-datepicker form-control fechas1" name="fcreacion_fin" placeholder="Hasta">
                                  </div>
                                </div>
                            </div>

                            <!--<div class="form-group">
                                <label class="col-md-4 control-label">Fecha de Vencimiento</label>
                                 <div class="col-md-7">
                                    <div class="input-group input-daterange gvencimiento">
                                        <input type="text" class="js-datepicker form-control fechas2" name="fvenc_inicio" placeholder="Desde">
                                        <div style="min-width: 0px" class="input-group-addon"></div>
                                        <input type="text" class="js-datepicker form-control fechas2" name="fvenc_fin" placeholder="Hasta">
                                    </div>
                                  </div>
                            </div>-->

                             <div class="form-group">
                                  <div class="col-md-8 col-md-offset-5">
                                    <button class="btn btn-sm btn-primary" type="submit">Buscar</button>
                                  </div>
                              </div>

                      </form>

                      <?php if(isset($_POST['id_proyecto'])){ ?>
                        <table class="table table-bordered table-striped js-dataTable-full">
                            <thead>
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">NOMBRE </th>
                                    <th class="hidden-xs">Nombre Inmueble</th>
                                    <th class="hidden-xs" style="width: 15%;">Modelo</th>
                                    <th class="hidden-xs" style="width: 15%;">Observaciones</th>
                                    <th class="hidden-xs" style="width: 15%;">Fecha de venta</th>
                                    <th class="text-center" style="width: 10%;">Ver Reporte</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $reporte1 = ver_listado_reporte1($conexion2, $_POST['id_proyecto'], $_POST['id_cliente'], $_POST['fcreacion_inicio'], $_POST['fcreacion_fin']); ?>
                                <?php while($r1 = $reporte1->fetch_array()){ ?>
                                <tr>
                                    <td class="text-center"><?php echo $r1['id_venta']; ?></td>
                                    <td class="font-w600"><?php echo $r1['cl_nombre'].' '.$r1['cl_apellido']; ?></td>
                                    <td class="hidden-xs"><?php echo $r1['mi_nombre']; ?></td>
                                    <td class="hidden-xs"><?php echo $r1['mi_modelo']; ?></td>
                                    <td class="hidden-xs"><?php echo $r1['mi_observaciones']; ?></td>
                                    <td class="hidden-xs"><?php echo $r1['fecha_venta']; ?></td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                          <form class="" action="reportes/gc_reporte_1.php" method="post" target="_blank">
                                            <input type="hidden" name="id_contrato_ventas" value="<?php echo $r1['id_venta']; ?>">
                                            <input type="hidden" name="inmueble" value="<?php echo $r1['mi_nombre']; ?>">
                                            <input type="hidden" name="cliente" value="<?php echo $r1['cl_nombre'].' '.$r1['cl_apellido']; ?>">
                                            <input type="hidden" name="modelo" value="<?php echo $r1['mi_modelo']; ?>">

                                            <input type="hidden" name="fcreacion_inicio" value="<?php echo $_POST['fcreacion_inicio'] ?>">
                                            <input type="hidden" name="fcreacion_fin" value="<?php echo $_POST['fcreacion_fin'] ?>">
                                            <input type="hidden" name="fvenc_inicio" value="<?php echo $_POST['fvenc_inicio'] ?>">
                                            <input type="hidden" name="fvenc_fin" value="<?php echo $_POST['fvenc_fin'] ?>">
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
<script src="<?php echo $one->assets_folder; ?>/js/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
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
    function init()
    {
      $("#val-select2").change(function(e){
         $.ajax({
            type: 'POST',
            url: 'funciones/op_clientes_por_proyectos.php',
            data: {
              id_proyecto: e.target.value
            },
            success: function(data){
              $("#sel-cliente").empty();
              $("#sel-cliente").append(data);
            },
            error: function(xhr, type, exception) {
              // if ajax fails display error alert
              alert("ajax error response type "+type);
            }
          });
        });

      $(".gcreacion").datepicker({
        input: $(".fechas1"),
        format: 'yyyy-mm-dd'
      });
      $(".gvencimiento").datepicker({
        input: $(".fechas2"),
        format: 'yyyy-mm-dd'
      });
    }
    window.onload = init;
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
        App.initHelpers(['datetimepicker', 'colorpicker', 'maxlength', 'select2', 'rangeslider']);
    });
</script>
<?php require 'inc/views/template_footer_end.php'; ?>
<?php }else{ ?>
        <script type="text/javascript">
            window.location="salir.php";
        </script>
<?php } ?>
