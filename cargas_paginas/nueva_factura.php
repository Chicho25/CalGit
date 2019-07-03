<?php include('../conexion/conexion2.php'); ?>
<?php include('../funciones/funciones.php'); ?>
<form action="" method="post">

<div class="block block-themed block-transparent remove-margin-b">
    <div class="block-header bg-primary-dark">
        <ul class="block-options">
            <li>
                <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
            </li>
        </ul>
        <h3 class="block-title">Actualizar Datos</h3>
    </div>
    <div class="block-content">
              <!-- Bootstrap Register -->
        <div class="block block-themed">
            <div class="block-content">
                <div class="form-group">
                    <label class="col-xs-12" for="register1-username">Cliente</label>
                    <div class="col-xs-12">
                      <select class="js-select2 form-control" name="id_cliente" style="width: 100%;" require="require" data-placeholder="Seleccionar un Cliente">
                          <option value=""> Selecciona un Cliente</option>
                          <?php
                                  $result = todos_clientes_activos($conexion2);
                                  $opciones = '<option value=""> Elige un Cliente </option>';
                                  while($fila = $result->fetch_array()){ ?>
                                    <option value="<?php echo $fila['id_cliente']; ?>"><?php echo $fila['cl_nombre'].' '.$fila['cl_apellido']; ?></option>
                          <?php  } ?>
                      </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12" for="register1-username">Fecha</label>
                    <div class="col-xs-12">
                        <input class="form-control" type="date" name="fecha" required value="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12" for="register1-username"></label>
                    <div class="col-xs-12">
                    </div>
                </div>
          <div class="modal-footer">
              <button class="btn btn-sm btn-default" type="button" data-dismiss="modal">Cancelar</button>
              <button class="btn btn-sm btn-primary" name="reg_factura" type="submit" >Guardar</button>
          </div>
        </div>
    </div>
  </div>
</div>
</form>

<?php require 'inc/views/base_footer.php'; ?>
<?php require 'inc/views/template_footer_start.php'; ?>

<!-- Page JS Plugins -->
<script src="<?php echo $one->assets_folder; ?>/js/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
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
