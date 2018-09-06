<?php if(!isset($_SESSION)){session_start();}?>
<?php require("conexion/conexion.php"); ?>
<?php require("funciones/funciones.php"); ?>
<?php if(isset($_SESSION['session_gc'])){ ?>
<?php if(isset($_POST['id_cuota'])){

      $_SESSION['id_cuota'] = $_POST['id_cuota'];

} ?>
<?php $header_bar = 'base_header.php'; ?>
<?php $menu = true; ?>
<?php /* ################ AUDITORIA DE SEGUIMIENTO ############## */ ?>
<?php require("funciones/funciones_auditorias.php"); ?>
<?php $lugar_mapa = 2; ?>
<?php $dispositivo_acceso = obtener_dispositivo(); ?>
<?php insertar_log_seguimiento($conexion2, ObtenerIP(), $dispositivo_acceso, $lugar_mapa, $_SESSION['session_gc']['usua_id']); ?>
<?php /* ######################################################## */ ?>

<?php if(isset($_POST['eliminar'])){

      $eliminar_movimiento_bancario = $conexion2 -> query("delete from movimiento_bancario where id_sub_cuota = '".$_POST['eliminar']."'");
      $sql_eliminar_cuota = $conexion2 -> query("delete from maestro_cuota_abono where id = '".$_POST['eliminar']."'");
      $restar_cuota_monto = $conexion2 -> query("SELECT mc_monto_abonado FROM maestro_cuotas WHERE id_cuota = '".$_POST['id_cuota_madre']."'");
      while($lista_retsa=$restar_cuota_monto->fetch_array()){
            $r = $lista_retsa['mc_monto_abonado'];
      }

      $resta_total = $r - $_POST['abonado'];

      if($sql_eliminar_cuota){
        $actualizar_monto = $conexion2 -> query("UPDATE maestro_cuotas set mc_monto_abonado = '".$resta_total."' WHERE id_cuota = '".$_POST['id_cuota_madre']."'");
      }

} ?>

<?php require 'inc/config.php'; ?>
<?php require 'inc/views/template_head_start.php'; ?>
<!-- Page JS Plugins CSS -->
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/select2/select2.min.css">
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/select2/select2-bootstrap.min.css">
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/sweetalert/sweetalert.min.css">
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/bootstrap-datepicker/bootstrap-datepicker3.min.css">

<?php require 'inc/views/template_head_end.php'; ?>

<script type="text/javascript">
$(document).ready(function() {
   $("#datepicker").datepicker();
});
</script>

<?php require 'inc/views/base_head.php'; ?>

<div class="content content-narrow">
    <!-- Forms Row -->
    <?php if(isset($sql_insert)){ ?>
        <div class="col-lg-12">
            <!-- Success Alert -->
            <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h3 class="font-w300 push-15">Registrado</h3>
                <p>El <a class="alert-link" href="javascript:void(0)">pago</a> fue registrado!</p>
            </div>
            <!-- END Success Alert -->
        </div>
    <?php } ?>
    <div class="row">

        <div class="col-lg-12">
            <!-- Bootstrap Forms Validation -->
            <div class="block">
                <div class="block-header">
                    <ul class="block-options">
                        <li>

                        </li>
                    </ul>
                    <h2 class="block-title">Cuota madre</h2>
                    <?php $sql = cuota_id_cuota($conexion2, $_SESSION['id_cuota']); ?>
                    <?php while($lc=$sql->fetch_array()){ ?>
                      <table class="table table-bordered">
                          <thead>
                              <tr>
                                  <th class="text-center">ID DOCUMENTO</th>
                                  <th class="text-center">PROYECTO</th>
                                  <th>GRUPO</th>
                                  <th class="hidden-xs">NOMBRE</th>
                                  <th class="text-center">CODIGO</th>
                                  <th class="text-center">CLIENTE</th>
                                  <th class="text-center">TIPO</th>
                                  <th class="text-center">NUMERO</th>
                              </tr>
                          </thead>
                          <tbody>
                            <tr>
                                <th class="text-center"><?php echo $lc['id_cuota']; ?></th>
                                <th class="text-center"><?php echo $lc['proy_nombre_proyecto']; ?></th>
                                <th><?php echo $lc['gi_nombre_grupo_inmueble']; ?></th>
                                <th class="hidden-xs"><?php echo $lc['mi_nombre']; ?></th>
                                <th class="text-center"><?php echo $lc['mi_codigo_imueble']; ?></th>
                                <th class="text-center"><?php echo $lc['cl_nombre'].' '.$lc['cl_apellido']; ?></th>
                                <th class="text-center"><?php echo $lc['tc_nombre_tipo_cuenta']; ?></th>
                                <th class="text-center"><?php echo $lc['mc_numero_cuota']; ?></th>
                            </tr>
                          </tbody>
                        </table>
                        <?php /* ################ variables para el insert ################### */ ?>
                        <?php /*$monto_cuota = $lc['mc_monto']; ?>
                        <?php $monto_cuota_abonado = $lc['mc_monto_abonado']; ?>
                        <?php $id_proyecto = $lc['id_proyecto']; ?>
                        <?php $id_codigo_inmueble = $lc['mi_codigo_imueble']; ?>
                        <?php $id_grupo_inmuebles = $lc['id_grupo_inmuebles']; ?>
                        <?php $id_inmueble = $lc['id_inmueble']; ?>
                        <?php $id_cliente = $lc['id_cliente']; ?>
                        <?php $id_contrato_venta = $lc['id_contrato_venta'];*/ ?>
                        <?php $id_cuota = $lc['id_cuota']; ?>
                  <?php } ?>

                </div>
                <div class="block-content block-content-narrow">
                    <!-- jQuery Validation (.js-validation-bootstrap class is initialized in js/pages/base_forms_validation.js) -->
                    <!-- For more examples you can check out https://github.com/jzaefferer/jquery-validation -->
                    <h1 class="block-title">Detalles de pago de cuota madre</h1>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="text-center">NUMERO</th>
                                <th class="text-center">REFERENCIA</th>
                                <th class="text-center">TIPO DE PAGO</th>
                                <th class="text-center">CUENTA RECEPTOTA</th>
                                <th class="hidden-xs">FECHA</th>
                                <th class="text-center">DESCRIPCION</th>
                                <th class="text-center">MONTO TOTAL</th>
                                <th class="text-center">MONTO ABONADO</th>
                                <th class="text-center">ELIMINAR</th>
                            </tr>
                        </thead>
                        <tbody>
                          <?php $sql =  cuotas_abonadas_documento_venta($conexion2, $_SESSION['id_cuota']); ?>
                          <?php while($lc=$sql->fetch_array()){ ?>
                          <tr>
                              <th class="text-center"><?php echo $lc['id']; ?></th>
                              <th class="text-center"><?php echo $lc['mca_numero']; ?></th>
                              <th class="text-center"><?php echo $lc['referencia_abono_cuota']; ?></th>
                              <th class="text-center"><?php echo $lc['tmb_nombre']; ?></th>
                              <th class="text-center"><?php echo $lc['cuenta_banco']; ?></th>
                              <th class="hidden-xs"><?php echo date("d-m-Y", strtotime($lc['fecha'])); ?></th>
                              <th class="text-center"><?php echo $lc['descripcion']; ?></th>
                              <th class="text-center"><?php echo number_format($lc['monto_documento'], 2, ',','.'); ?></th>
                              <th class="text-center"><?php echo number_format($lc['monto_abonado'], 2, ',','.'); ?></th>
                              <th class="text-center">
                                <div class="btn-group">
                                    <button class="btn btn-default" data-toggle="modal" data-target="#modal-popin<?php echo $lc['id']; ?>" type="submit"><i class="fa fa-trash-o"></i></button>
                                    <div class="modal fade" id="modal-popin<?php echo $lc['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-popin">
                                            <div class="modal-content">
                                                <div class="block block-themed block-transparent remove-margin-b">
                                                    <div class="block-header bg-primary-dark">
                                                        <ul class="block-options">
                                                            <li>
                                                                <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                                                            </li>
                                                        </ul>
                                                        <h3 class="block-title">Eliminar la cuota hija</h3>
                                                    </div>
                                                    <div class="block-content">
                                                        Esta seguro que desea eliminar la cuota hija ?<br>
                                                        <span style="color:red;">El movimiento bancario tambien se borrara.</span>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                  <form class="" action="" method="post">
                                                    <button class="btn btn-sm btn-default" type="button" data-dismiss="modal">Cerrar</button>
                                                    <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-check"></i> Ok</button>
                                                    <input type="hidden" name="eliminar" value="<?php echo $lc['id']; ?>">
                                                    <input type="hidden" name="abonado" value="<?php echo $lc['monto_abonado']; ?>">
                                                    <input type="hidden" name="id_cuota_madre" value="<?php echo $id_cuota; ?>">
                                                  </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                              </th>
                          </tr>
                          <?php } ?>
                        </tbody>
                      </table>

                </div>
            <!-- Bootstrap Forms Validation -->
        </div>
    </div>
</div>
</div>
<?php require 'inc/views/base_footer.php'; ?>
<?php require 'inc/views/template_footer_start.php'; ?>
<script type="text/javascript" src="bootstrap-filestyle.min.js"> </script>

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
            window.location="index.php";
        </script>
<?php } ?>
