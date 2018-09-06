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
<?php require 'inc/views/base_head.php'; ?>

<div class="content content-narrow">
      <div class="row">
          <div class="col-lg-12">
              <div class="block">
                  <div class="block-header">
                      <h3 class="block-title">seleccione un proyecto</h3>
                  </div>
                  <div class="block-content block-content-narrow">
                      <form class="js-validation-bootstrap form-horizontal" action="gc_ver_pagos_filtrados_resultado.php" method="post">
                          <div class="form-group">
                              <div class="col-md-12">

                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="val-password">ID del documento</label>
                                    <div class="col-md-7">
                                      <input class="form-control" type="number" autocomplete="off" name="id_factura" placeholder="ID del documento" value="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="val-password">ID del Pago</label>
                                    <div class="col-md-7">
                                      <input class="form-control" type="number" autocomplete="off" name="id_pago" placeholder="ID del Pago" value="">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="val-username">Proyecto<span class="text-danger">*</span></label>
                                    <div class="col-md-7">
                                      <?php $sql = $conexion2 -> query("select * from maestro_proyectos"); ?>
                                        <select id="partida" class="form-control" style="width: 100%;" name="proyecto" required="required">
                                            <option value="">Seleccionar Proyecto</option>
                                            <?php while($q=$sql->fetch_array()){ ?>
                                            <option value="<?php echo $q['id_proyecto']; ?>"><?php echo $q['proy_nombre_proyecto']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                  <div class="form-group">
                                      <label class="col-md-4 control-label" for="val-email">Proveedor</label>
                                      <div class="col-md-7">
                                        <select class="js-select2 form-control" id="val-select2" name="id_proveedor" style="width: 100%;" data-placeholder="Seleccionar tipo de movimiento" required="required">
                                            <option></option>
                                            <?php $sql_proveedores = todos_proveedores($conexion2); ?>
                                            <?php while($lista_proveedores = $sql_proveedores -> fetch_array()){ ?>
                                            <option value="<?php echo $lista_proveedores['id_proveedores']; ?>"
                                                           <?php if(isset($_SESSION['partida_documento'])){ if($_SESSION['partida_documento']['id_proveedor'] == $lista_proveedores['id_proveedores']){ echo 'selected'; }} ?>
                                             ><?php echo utf8_encode($lista_proveedores['pro_nombre_comercial']); ?></option>
                                            <?php } ?>
                                        </select>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label class="col-md-4 control-label" for="val-username">Tipo</label>
                                      <div class="col-md-7">
                                        <select class="js-select2 form-control" id="val-select2" name="tipo_movimiento" style="width: 100%;" data-placeholder="Seleccionar tipo de movimiento">
                                            <option value="">Seleccionar</option>
                                            <?php $sql_tipo_documentos = $conexion2 -> query("select * from tipo_movimiento_bancario where id_tipo_movimiento_bancario in(4,6,8,9,10,11,12)"); ?>
                                            <?php while($lista_tipo_documentos = $sql_tipo_documentos -> fetch_array()){ ?>
                                            <option value="<?php echo $lista_tipo_documentos['id_tipo_movimiento_bancario']; ?>"
                                                           <?php if(isset($_SESSION['partida_documento'])){ if($_SESSION['partida_documento']['tipo_documento'] == $lista_tipo_documentos['id']){ echo 'selected'; }} ?>
                                             ><?php echo $lista_tipo_documentos['tmb_nombre']; ?></option>
                                            <?php } ?>
                                        </select>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label class="col-md-4 control-label" for="val-password">Desde.</label>
                                      <div class="col-md-7">
                                        <input class="js-datepicker form-control" autocomplete="off" type="text" name="desde" id="example-datepicker1" data-date-format="yyyy-mm-dd" placeholder="Desde" value="">
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label class="col-md-4 control-label" for="val-password">Hasta</label>
                                      <div class="col-md-7">
                                        <input class="js-datepicker form-control" autocomplete="off" type="text" name="hasta" id="example-datepicker1" data-date-format="yyyy-mm-dd" placeholder="Hasta" value="">
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label class="col-md-4 control-label" for="val-password">Numero de cheque</label>
                                      <div class="col-md-7">
                                        <input class="form-control" type="number" autocomplete="off" name="numero_cheque" placeholder="ID del documento" value="">
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label class="col-md-4 control-label" for="val-username">Estatus</label>
                                      <div class="col-md-7">
                                        <select class="js-select2 form-control" id="val-select2" name="status" style="width: 100%;" data-placeholder="Seleccionar tipo de movimiento">
                                            <option value="">Seleccionar</option>
                                            <?php $sql_tipo_documentos = $conexion2->query("select * from maestro_status where st_numero in(15,14,13)"); ?>
                                            <?php while($lista_tipo_documentos = $sql_tipo_documentos -> fetch_array()){ ?>
                                            <option value="<?php echo $lista_tipo_documentos['st_numero']; ?>"
                                                           <?php if(isset($_SESSION['partida_documento'])){ if($_SESSION['partida_documento']['tipo_documento'] == $lista_tipo_documentos['id']){ echo 'selected'; }} ?>
                                             ><?php if($lista_tipo_documentos['st_numero']==13){ echo 'Pendiente por pagar';}elseif($lista_tipo_documentos['st_numero']==14){ echo 'Pagado';}elseif($lista_tipo_documentos['st_numero']==15){ echo 'Abonado';} ?></option>
                                            <?php } ?>
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
        App.initHelpers(['datepicker', 'datetimepicker', 'colorpicker', 'maxlength', 'select2', 'masked-inputs', 'rangeslider', 'tags-inputs']);
    });
</script>
<?php require 'inc/views/template_footer_end.php'; ?>
<?php }else{ ?>
        <script type="text/javascript">
            window.location="salir.php";
        </script>
<?php } ?>
