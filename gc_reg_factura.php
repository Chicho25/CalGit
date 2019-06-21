<?php if(!isset($_SESSION)){session_start();}?>
<?php require("conexion/conexion.php"); ?>
<?php require("funciones/funciones.php"); ?>
<?php if(isset($_SESSION['session_gc'])){ ?>
<?php $header_bar = 'base_header.php'; ?>
<?php $menu = true; ?>
<?php require 'inc/config.php'; ?>
<?php require 'inc/views/template_head_start.php'; ?>

<?php

  /*

  detalle
  monto
  customer

  */

if(isset($_POST['modal_detalle'])){

  if(isset($_SESSION['detalle'])){
    $array_detalle = array("detalle"=>$_POST['detalle'],
                           "monto"=>$_POST['monto']);
    $array = array_push($_SESSION['detalle'],
                        $array_detalle);
    $_SESSION['detalle'] = $array;
  }else{
    $array_detalle = array("detalle"=>$_POST['detalle'],
                           "monto"=>$_POST['monto']);

    $_SESSION['detalle'] = $array_detalle;
    $_SESSION['cliente'] = $_POST['id_cliente'];
    }
}





 ?>

<!-- Page JS Plugins CSS -->
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/select2/select2.min.css">
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/select2/select2-bootstrap.min.css">
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/sweetalert/sweetalert.min.css">
<?php require 'inc/views/template_head_end.php'; ?>
<?php require 'inc/views/base_head.php'; ?>

<div class="content content-narrow">
    <!-- Forms Row -->
    <div class="row">
      <?php if(isset($sql_insertar)){ ?>
              <div class="alert alert-success alert-dismissable">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <h3 class="font-w300 push-15">Factura</h3>
                  <p>El <a class="alert-link" href="javascript:void(0)">Factura</a> registrado!</p>
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
                    <h3 class="block-title">Registrar Factura</h3><small> Los campos con <span class="text-danger">*</span> son obligatorios</small>
                </div>
                <?php
                print_r($_SESSION['detalle']);
                print_r($_SESSION['cliente']);
                 ?>
                <div class="block-content block-content-narrow">
                  <div class="form-group">
                      <label class="col-md-4 control-label" for="val-username">Cliente</label>
                      <div class="col-md-6">
                          <select class="form-control" id="cliente" name="id_cliente" data-placeholder="Seleccionar un Cliente">
                              <option value=""> Selecciona un Cliente</option>
                              <?php
                                $result = todos_clientes_activos($conexion2);
                                while($fila = $result->fetch_array()){ ?>
                                        <option value="<?php echo $fila['id_cliente']; ?>"
                                          <?php if(isset($_SESSION['cliente'])){ echo 'selected';} ?>
                                          >
                                          <?php echo $fila['cl_nombre'].' '.$fila['cl_apellido']; ?>
                                        </option>
                              <?php  } ?>
                          </select>
                      </div>
                  </div>
                  <div class="form-group">
                      <button class="btn btn-default" style="float:left;" data-toggle="modal" data-target="#modal-popin" type="button"><i class="fa fa-user-plus"></i></button>
                  </div>
                  <div class="form-group">
                    <table class="table table-bordered table-striped js-dataTable-full">
                        <thead>
                            <tr>
                                <th class="text-center">Detalle</th>
                                <th>Monto</th>
                                <th class="hidden-xs">Accion</th>
                            </tr>
                        </thead>
                        <tbody>
                          <?php if(isset($_SESSION['detalle'])){ ?>
                          <?php foreach ($_SESSION['detalle'] as $value) { ?>
                            <tr>
                                <td class="text-center"><?php echo $value['detalle']; ?></td>
                                <td class="font-w600"><?php echo $value['monto']; ?></td>
                                <td class="hidden-xs"></td>
                            </tr>
                          <?php }
                              } ?>
                          </tbody>
                        </table>
                  </div>
                  <div class="form-group">
                    <div class="col-md-8 col-md-offset-4">
                      <button class="btn btn-sm btn-primary" type="submit">Registrar</button>
                    </div>
                  </div>
                </form>
              </div>
              <script type="text/javascript">

              var select = document.getElementById('cliente');
              select.addEventListener('change',
                function(){
                  var selectedOption = this.options[select.selectedIndex];
                  console.log(selectedOption.value + ': ' + selectedOption.text);
                  document.querySelector("#customer").value = selectedOption.value;
                });

              </script>
            <!-- Bootstrap Forms Validation -->
            <div class="modal fade" id="modal-popin" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-popin">
                    <div class="modal-content">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="block block-themed block-transparent remove-margin-b">
                                <div class="block-header bg-primary-dark">
                                    <ul class="block-options">
                                        <li>
                                            <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                                        </li>
                                    </ul>
                                    <h3 class="block-title">Agregar Detalle</h3>
                                </div>
                                <div class="block-content">
                                    <!-- Bootstrap Register -->
                                    <div class="block block-themed">
                                      <div class="block-content">
                                        <div class="form-group">
                                            <label class="col-xs-12" for="register1-username">Detalle</label>
                                            <div class="col-xs-12">
                                                <input class="form-control" type="text" id="register1-username" name="detalle" value="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-xs-12" for="register1-email">Monto</label>
                                            <div class="col-xs-12">
                                                <input class="form-control" type="text" id="register1-email" name="monto" value="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-xs-12" ></label>
                                            <div class="col-xs-12">
                                            </div>
                                        </div>
                                    <div class="modal-footer">
                                        <input type="hidden" name="id_cliente" id="customer" value="">
                                        <button class="btn btn-sm btn-default" type="button" data-dismiss="modal">Cancelar</button>
                                        <button class="btn btn-sm btn-primary" type="submit" name="modal_detalle">Registrar</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<script language="javascript">
$(document).ready(function(){
   $("#proyecto").change(function () {
           $("#proyecto option:selected").each(function () {
            elegido=$(this).val();
            $.post("select_movimientos.php", { elegido: elegido }, function(data){
            $("#grupo").html(data);
            });
        });
   })
});
</script>

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
        unset($_SESSION['session_ventas_reserva']);
        unset($_SESSION['session_ventas']); ?>
        <script type="text/javascript">
            function redireccionarPagina() {
              window.location = "gc_asignar_comision.php";
            }
            setTimeout("redireccionarPagina()", 5000);
        </script>
<?php  } ?>

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
<?php require 'inc/views/template_footer_end.php'; ?>
<?php }else{ ?>
        <script type="text/javascript">
            window.location="salir.php";
        </script>
<?php } ?>
