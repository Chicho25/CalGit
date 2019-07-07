<?php if(!isset($_SESSION)){session_start();}?>
<?php require("conexion/conexion.php"); ?>
<?php require("funciones/funciones.php"); ?>
<?php if(isset($_SESSION['session_gc'])){ ?>
<?php $header_bar = 'base_header.php'; ?>
<?php $menu = true; ?>

<?php if(isset($_POST['eliminar'])){
$eliminar_detalle  = $conexion2 -> query("delete from factura_detalle where id_factura = '".$_POST['eliminar']."'");
$eliminar_factura = $conexion2 -> query("delete from factura where id = '".$_POST['eliminar']."'");
 } ?>
<?php if (isset($_POST['reg_factura'])) {

$resgitrar_factura = $conexion2-> query("INSERT INTO factura(id_cliente, fecha, stat, id_user)VALUES('".$_POST['id_cliente']."',
                                                                                                     '".$_POST['fecha']."',
                                                                                                      1,
                                                                                                      '".$_SESSION['session_gc']['usua_id']."')");

} ?>

<?php if (isset($_POST['pagar_factura'])) {

    $todos_factura = $conexion2 -> query("SELECT * FROM factura WHERE id = '".$_POST['id']."'");
    while ($factura = $todos_factura -> fetch_array()){

         $monto_factura = $factura['monto'];
         $monto_pagado = $factura['monto_pagado'];
         $id_cliente = $factura['id_cliente'];
       }

       $monto_por_pagar = $monto_factura - $_POST['monto'];
       $monto_pagado_total = $monto_pagado + $_POST['monto'];

     $update_factura = $conexion2 -> query("UPDATE factura SET monto = '".$monto_por_pagar."',
                                                               monto_pagado = '".$monto_pagado_total."',
                                                               stat = 3
                                                               WHERE
                                                               id = '".$_POST['id']."'");

/* Insertar en las tablas de facturas */
$pagar_factura = $conexion2-> query("INSERT INTO factura_pago(id_cliente, id_factura, monto, fecha, id_user)
                                                            VALUES
                                                            ('".$id_cliente."',
                                                              '".$_POST['id']."',
                                                              '".$_POST['monto']."',
                                                              '".date('d/m/Y')."',
                                                              '".$_SESSION['session_gc']['usua_id']."')");
/* Movimiento bancario */
$pagar_movimiento = $conexion2-> query("INSERT INTO movimiento_bancario(id_tipo_movimiento,
                                                            mb_fecha,
                                                            mb_monto,
                                                            mb_descripcion,
                                                            mb_stat,
                                                            id_cliente)
                                                            VALUES
                                                            (29,
                                                             '".date('d/m/Y')."',
                                                             '".$_POST['monto']."',
                                                             'PAGO A FACTURA DE LA MARINA',
                                                              1,
                                                             '".$id_cliente."')");

/* Comprobar si se pago la factura */

$todos_factura = $conexion2 -> query("SELECT * FROM factura WHERE id = '".$_POST['id']."'");
while ($factura = $todos_factura -> fetch_array()){
     $monto_factura = $factura['monto'];
   }

if ($monto_factura == 0) {

  $update_factura_pagada = $conexion2 -> query("UPDATE factura SET stat = 4
                                                            WHERE
                                                            id = '".$_POST['id']."'");

}


} ?>

<?php require 'inc/config.php'; ?>
<?php require 'inc/views/template_head_start.php'; ?>
<!-- Page JS Plugins CSS -->
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/select2/select2.min.css">
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/select2/select2-bootstrap.min.css">
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/bootstrap-datepicker/bootstrap-datepicker3.min.css">
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/datatables/jquery.dataTables.min.css">
<?php require 'inc/views/template_head_end.php'; ?>
<?php require 'inc/views/base_head.php'; ?>

<!-- Page Header -->
<div class="content bg-gray-lighter">
    <div class="row items-push">

      <?php if(isset($resgitrar_factura)){ ?>
              <!-- Success Alert -->
              <div class="alert alert-success alert-dismissable">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <h3 class="font-w300 push-15">Factura  Registrada</h3>
                  <p><a class="alert-link" href="javascript:void(0)">La Factura</a> Fue Registrada!</p>
              </div>
              <!-- END Success Alert -->
      <?php } ?>
      <?php if(isset($eliminar_factura)){ ?>
      <div class="alert alert-danger alert-dismissable">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <h3 class="font-w300 push-15">Factura Eliminada</h3>
          <p><a class="alert-link" href="javascript:void(0)">La Factura</a> Fue Eliminada!</p>
      </div>
      <?php } ?>
      <?php if(isset($pagar_factura)){ ?>
              <!-- Success Alert -->
              <div class="alert alert-success alert-dismissable">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <h3 class="font-w300 push-15">Factura Pagada</h3>
                  <p><a class="alert-link" href="javascript:void(0)">La factura</a> Fue Pagada!</p>
              </div>
              <!-- END Success Alert -->
      <?php } ?>
        <div class="col-sm-7">
            <h1 class="page-heading">
                Facturas
            </h1>
        </div>

    </div>
</div>
<!-- END Page Header -->
<!-- Page Content -->
<div class="content">
    <!-- Dynamic Table Full -->
    <div class="block">
        <div class="block-header">
            <h3 class="block-title">FACTURAS</h3>
        </div>
        <div class="block-content">
             <button class="btn btn-primary" data-toggle="modal" data-target="#modal-popin_n" type="button">Nueva Factura</button>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th class="text-center">ID</th>
                        <th class="text-center">CLIENTE</th>
                        <th class="text-center">FACTURA</th>
                        <th class="text-center">ELEMENTOS</th>
                        <th class="hidden-xs" >ITBMS</th>
                        <th class="hidden-xs" >TOTAL POR PAGAR</th>
                        <th class="hidden-xs" >TOTAL PAGADO</th>
                        <th class="hidden-xs" >ESTADO</th>
                        <th class="hidden-xs" >PAGAR</th>
                        <th class="hidden-xs" >PDF</th>
                        <th class="hidden-xs" >ELIMINAR</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $todos_contratos_ventas = $conexion2 -> query("SELECT
                                                                          factura.id,
                                                                          factura.id_cliente,
                                                                          factura.monto,
                                                                          factura.fecha,
                                                                          factura.stat,
                                                                          factura.itbms,
                                                                          factura.monto_pagado,
                                                                          maestro_clientes.cl_nombre,
                                                                          maestro_clientes.cl_apellido,
                                                                        (select count(*)
                                                                         from
                                                                         factura_detalle
                                                                         where
                                                                         id_factura = factura.id) as contar
                                                                         FROM factura inner join maestro_clientes on factura.id_cliente = maestro_clientes.id_cliente"); ?>
                    <?php while($lista_todos_contratos_ventas = $todos_contratos_ventas -> fetch_array()){ ?>
                    <tr>
                        <td class="text-center"><?php echo $lista_todos_contratos_ventas['id']; ?></td>
                        <td class="font-w600"><?php echo $lista_todos_contratos_ventas['cl_nombre'].' '.$lista_todos_contratos_ventas['cl_apellido']; ?></td>
                        <td class="text-center"><?php echo date("d-m-Y", strtotime($lista_todos_contratos_ventas['fecha'])); ?></td>
                        <td class="text-center">
                          <?php if($lista_todos_contratos_ventas['stat'] == 3 || $lista_todos_contratos_ventas['stat'] == 4){echo $lista_todos_contratos_ventas['contar']; }else{  ?>
                          <form class="" action="agregar_detalle_factura.php?id=<?php echo $lista_todos_contratos_ventas['id']; ?>" method="post">
                            <button class="btn btn-primary"><?php echo $lista_todos_contratos_ventas['contar']; ?></button>
                          </form>
                          <?php } ?>
                        </td>
                        <td class="font-w600"><?php echo number_format($lista_todos_contratos_ventas['itbms'], 2, '.',','); ?></td>
                        <td class="hidden-xs"><?php echo number_format($lista_todos_contratos_ventas['monto'], 2, '.',','); ?></td>
                        <td class="hidden-xs"><?php echo number_format($lista_todos_contratos_ventas['monto_pagado'], 2, '.',','); ?></td>
                        <td class="hidden-xs"><?php if($lista_todos_contratos_ventas['stat'] == 1){ echo 'Sin detalle'; }
                                                      elseif($lista_todos_contratos_ventas['stat'] == 2){ echo 'Pendiente Por Pagar';}
                                                        elseif($lista_todos_contratos_ventas['stat'] == 3){ echo 'Abonado';}
                                                          elseif($lista_todos_contratos_ventas['stat'] == 4){ echo 'Pagada';} ?></td>
                        <td class="hidden-xs">
                          <div class="btn-group">
                            <script type="text/javascript">
                              $(document).ready(function() {
                                $("#boton_p<?php echo $lista_todos_contratos_ventas['id']; ?>").click(function(event) {
                                $("#capa_p<?php echo $lista_todos_contratos_ventas['id']; ?>").load('cargas_paginas/pagar_factura.php?id=<?php echo $lista_todos_contratos_ventas['id']; ?>&monto_max=<?php echo $lista_todos_contratos_ventas['monto']; ?>');
                                });
                              });
                            </script>
                                <?php if($lista_todos_contratos_ventas['stat'] == 1 || $lista_todos_contratos_ventas['stat'] == 4){ }else{  ?>
                               <button id="boton_p<?php echo $lista_todos_contratos_ventas['id']; ?>" class="btn btn-default" data-toggle="modal" data-target="#modal-popin<?php echo $lista_todos_contratos_ventas['id']; ?>" type="button"><i class="fa fa-dollar"></i></button>
                                <?php } ?>
                          </div>
                        </td>
                        <td class="hidden-xs">
                          <div class="btn-group">
                            <?php if($lista_todos_contratos_ventas['stat'] == 1){ }else{  ?>
                               <a class="btn btn-default" href="reportes/gc_factura.php?id=<?php echo $lista_todos_contratos_ventas['id']; ?>" target="_blank" type="button"><i class="fa fa-file"></i></a>
                            <?php } ?>
                          </div>
                        </td>
                        <td class="hidden-xs">
                          <div class="btn-group">
                            <script type="text/javascript">
                              $(document).ready(function() {
                                $("#boton_d<?php echo $lista_todos_contratos_ventas['id']; ?>").click(function(event) {
                                $("#capa_d<?php echo $lista_todos_contratos_ventas['id']; ?>").load('cargas_paginas/elininar_factura.php?id=<?php echo $lista_todos_contratos_ventas['id']; ?>');
                                });
                              });
                            </script>
                               <button id="boton_d<?php echo $lista_todos_contratos_ventas['id']; ?>" class="btn btn-default" data-toggle="modal" data-target="#modal-popind<?php echo $lista_todos_contratos_ventas['id']; ?>"><i class="fa fa-trash-o"></i></button>
                          </div>
                        </td>
                    </tr>
                    <!-- Pagar -->
                    <div class="modal fade" id="modal-popin<?php echo $lista_todos_contratos_ventas['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-popin">
                        <div id="capa_p<?php echo $lista_todos_contratos_ventas['id']; ?>" class="modal-content">

                        </div>
                     </div>
                   </div>
                   <!-- Borrar -->
                   <div class="modal fade" id="modal-popind<?php echo $lista_todos_contratos_ventas['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                     <div class="modal-dialog modal-dialog-popin">
                       <div id="capa_d<?php echo $lista_todos_contratos_ventas['id']; ?>" class="modal-content">

                       </div>
                    </div>
                  </div>
                  <!-- Detalle -->
                  <div class="modal fade" id="modal-popina<?php echo $lista_todos_contratos_ventas['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-popin">
                      <div id="capa_<?php echo $lista_todos_contratos_ventas['id']; ?>" class="modal-content">

                      </div>
                   </div>
                 </div>
                  <?php } ?>
                </tbody>
            </table>

         <!-- Nueva Factura -->
         <div class="modal fade" id="modal-popin_n" tabindex="-1" role="dialog" aria-hidden="true">
           <div class="modal-dialog modal-dialog-popin">
             <div id="capa_n" class="modal-content">
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
                   </div>
                 </div>
               </div>
             </div>
           </div>
    <!-- END Dynamic Table Full -->
    <!-- Dynamic Table Simple -->
    <!-- END Dynamic Table Simple -->
</div>
<!-- END Page Content -->
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
<?php require 'inc/views/template_footer_end.php'; ?>
<?php }else{ ?>

        <script type="text/javascript">
            window.location="salir.php";
        </script>

<?php } ?>
