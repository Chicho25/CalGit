<?php if(!isset($_SESSION)){session_start();}?>
<?php require("conexion/conexion.php"); ?>
<?php require("funciones/funciones.php"); ?>
<?php if(isset($_SESSION['session_gc'])){ ?>
<?php $header_bar = 'base_header.php'; ?>
<?php $menu = true; ?>
<?php if (isset($_GET['id'])) {
      $_SESSION['id_factura'] = $_GET['id'];
} ?>
<?php if (isset($_POST['guardar_detalle'])){

  $monto = $_POST['monto'];
  $cantidad = $_POST['cantidad'];
  $itbms = (($monto * $cantidad) * 7)/100;
  $total = ($monto * $cantidad) + $itbms;

  $insertar_detalle = $conexion2 -> query("INSERT INTO factura_detalle(id_factura,
                                                                       monto,
                                                                       cantidad,
                                                                       descripcion,
                                                                       itbms,
                                                                       total)
                                                                       VALUES
                                                                       ('".$_SESSION['id_factura']."',
                                                                        '".$monto."',
                                                                        '".$cantidad."',
                                                                        '".$_POST['descripcion']."',
                                                                        '".$itbms."',
                                                                        '".$total."')");

$itbms_factura = 0;
$monto_factura = 0;

 $todos_factura = $conexion2 -> query("SELECT * FROM factura WHERE id = '".$_SESSION['id_factura']."'");
 while ($factura = $todos_factura -> fetch_array()){
      $itbms_factura = $factura['itbms'];
      $monto_factura = $factura['monto'];
    }

    $monto_up = $monto_factura + $total;
    $itbms_up = $itbms_factura + $itbms;

  $update_factura = $conexion2 -> query("UPDATE factura SET monto = '".$monto_up."',
                                                            itbms = '".$itbms_up."',
                                                            stat = 2
                                                            WHERE
                                                            id = '".$_SESSION['id_factura']."'");

}

############ Borrar #############

if (isset($_POST['id_delete'])) {

  $todos_factura = $conexion2 -> query("SELECT * FROM factura WHERE id = '".$_SESSION['id_factura']."'");
  while ($factura = $todos_factura -> fetch_array()){
       $itbms_factura = $factura['itbms'];
       $monto_factura = $factura['monto'];
     }

     $monto_up = $monto_factura - $_POST['id_delete_monto'];
     $itbms_up = $itbms_factura - $_POST['id_delete_itbms'];

   $update_factura = $conexion2 -> query("UPDATE factura SET monto = '".$monto_up."',
                                                             itbms = '".$itbms_up."',
                                                             stat = 2
                                                             WHERE
                                                             id = '".$_SESSION['id_factura']."'");

    $eliminar_detalle  = $conexion2 -> query("delete from factura_detalle where id = '".$_POST['id_delete']."'");


}

?>

<?php require 'inc/config.php'; ?>
<?php require 'inc/views/template_head_start.php'; ?>
<!-- Page JS Plugins CSS -->
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/select2/select2.min.css">
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/select2/select2-bootstrap.min.css">
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/sweetalert/sweetalert.min.css">
<?php require 'inc/views/template_head_end.php'; ?>
<?php require 'inc/views/base_head.php'; ?>

<div class="content content-narrow">
    <!-- Forms Row -->
    <div class="row">

            <?php if(isset($insertar_detalle)){ ?>

                    <div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h3 class="font-w300 push-15">Detalle Registrado</h3>
                        <p>El <a class="alert-link" href="javascript:void(0)">Detalle</a> se ha registrado!</p>
                    </div>

            <?php } ?>
            <?php if(isset($eliminar_detalle)){ ?>

                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h3 class="font-w300 push-15">Detalle Eliminado</h3>
                        <p>El <a class="alert-link" href="javascript:void(0)">Detalle</a> se ha Eliminado!</p>
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
                    <h3 class="block-title">Registrar Detalle</h3><small> Los campos con <span class="text-danger">*</span> son obligatorios</small>
                </div>
                <div class="block-content block-content-narrow">
                  <div class="form-group">
                    <a href="gc_reg_factura.php" class="btn btn-primary">Regresar</a>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="text-center">DETALLE</th>
                                <th class="text-center">CANTIDAD</th>
                                <th class="text-center">ITBMS</th>
                                <th class="hidden-xs" >MONTO</th>
                                <th class="hidden-xs" >TOTAL</th>
                                <th class="hidden-xs" >ELIMINAR</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $todos_contratos_ventas = $conexion2 -> query("SELECT * FROM factura_detalle WHERE id_factura = '".$_SESSION['id_factura']."'"); ?>
                            <?php while($lista_todos_contratos_ventas = $todos_contratos_ventas -> fetch_array()){ ?>
                            <tr>
                                <td class="text-center"><?php echo $lista_todos_contratos_ventas['id']; ?></td>
                                <td class="font-w600"><?php echo $lista_todos_contratos_ventas['descripcion']; ?></td>
                                <td class="text-center"><?php echo $lista_todos_contratos_ventas['cantidad']; ?></td>
                                <td class="text-center"><?php echo number_format($lista_todos_contratos_ventas['itbms'], 2, '.',','); ?></td>
                                <td class="font-w600"><?php echo number_format($lista_todos_contratos_ventas['monto'], 2, '.',','); ?></td>
                                <td class="font-w600"><?php echo number_format($lista_todos_contratos_ventas['total'], 2, '.',','); ?></td>
                                <td class="hidden-xs">
                                  <form class="" action="" method="post">
                                    <button type="submit" class="btn btn-danger"><i class="fa fa-trash-o"></i></button></td>
                                    <input type="hidden" name="id_delete" value="<?php echo $lista_todos_contratos_ventas['id']; ?>">
                                    <input type="hidden" name="id_delete_monto" value="<?php echo $lista_todos_contratos_ventas['monto']; ?>">
                                    <input type="hidden" name="id_delete_itbms" value="<?php echo $lista_todos_contratos_ventas['itbms']; ?>">
                                  </form>
                            </tr>
                          <?php } ?>
                            <tr>

                            </tr>
                        </tbody>
                    </table>
                  </div>
                  <?php $todos_factura = $conexion2 -> query("SELECT * FROM factura inner join maestro_clientes on factura.id_cliente = maestro_clientes.id_cliente  WHERE factura.id = '".$_SESSION['id_factura']."'"); ?>
                  <?php while ($factura = $todos_factura -> fetch_array()) {
                        $cliente = $factura['cl_nombre'].' '.$factura['cl_apellido'];
                        $fecha = $factura['fecha'];
                  } ?>
                  <form class="js-validation-bootstrap form-horizontal" action="" method="post">
                    <input type="hidden" value="0" name="reserva">
                    <div class="form-group">
                      <label class="col-md-4 control-label" for="val-username">Cliente</label>
                      <div class="col-md-6">
                        <input type="text" class="form-control" readonly name="" value="<?php echo $cliente; ?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-4 control-label" for="val-username">Fecha</label>
                      <div class="col-md-7">
                        <input type="text" class="form-control" readonly name="" value="<?php echo $fecha; ?>">
                      </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="val-username">Detalle <span class="text-danger">*</span></label>
                        <div class="col-md-7">
                          <textarea name="descripcion" class="form-control" rows="8" cols="80"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="val-username">Cantidad <span class="text-danger">*</span></label>
                        <div class="col-md-7">
                          <input type="number" name="cantidad" value="" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="val-username">Monto Excento <span class="text-danger">*</span></label>
                        <div class="col-md-7">
                          <input id="exento" type="number" name="exento" value="" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="val-username">Gravable <span class="text-danger">*</span></label>
                        <div class="col-md-7">
                          <input id="gravable" type="number" name="monto" value="" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="val-username">ITBMS <span class="text-danger">*</span></label>
                        <div class="col-md-7">
                          <input id="itbms" readonly type="number" name="itbms" value="" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="val-username">Monto <span class="text-danger">*</span></label>
                        <div class="col-md-7">
                          <input id="monto_total" type="number" readonly name="monto" value="" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="val-username"></label>
                        <div class="col-md-7">
                          <input type="submit" name="guardar_detalle" value="Guardar" class="btn btn-primary">
                        </div>
                    </div>
                </form>
            </div>
          </div>
        </div>
      </div>
    </div>
<script type="text/javascript">
  function excento(){
    document.querySelector("#monto_total").value = document.querySelector("#exento").value;
    document.querySelector("#itbms").value = 0;
  }

  function gravable(){
    document.querySelector("#monto_total").value = document.querySelector("#gravable").value + (document.querySelector("#gravable").value * 7 /100);
    document.querySelector("#itbms").value = document.querySelector("#gravable").value * 7 /100;
  }
</script>
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
