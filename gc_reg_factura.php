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
<?php require 'inc/config.php'; ?>
<?php require 'inc/views/template_head_start.php'; ?>
<!-- Page JS Plugins CSS -->
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/bootstrap-datepicker/bootstrap-datepicker3.min.css">
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/datatables/jquery.dataTables.min.css">
<?php require 'inc/views/template_head_end.php'; ?>
<?php require 'inc/views/base_head.php'; ?>

<!-- Page Header -->
<div class="content bg-gray-lighter">
    <div class="row items-push">

      <?php if(isset($sql_insert_cuota)){ ?>
              <!-- Success Alert -->
              <div class="alert alert-success alert-dismissable">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <h3 class="font-w300 push-15">Servicio  Registrado</h3>
                  <p><a class="alert-link" href="javascript:void(0)">El Servicio</a> Fue Registrado!</p>
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
      <?php if(isset($pagar_servicio)){ ?>
              <!-- Success Alert -->
              <div class="alert alert-success alert-dismissable">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <h3 class="font-w300 push-15">Servicio Pagado</h3>
                  <p><a class="alert-link" href="javascript:void(0)">El Servicio</a> Fue Pagado!</p>
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
          <script type="text/javascript">
            $(document).ready(function() {
              $("#boton_n").click(function(event) {
              $("#capa_n").load('cargas_paginas/nueva_factura.php');
              });
            });
          </script>
             <button id="boton_d<?php echo $lista_todos_contratos_ventas['id']; ?>" class="btn btn-default" data-toggle="modal" data-target="#modal-popina<?php echo $lista_todos_contratos_ventas['id']; ?>" type="button">Nueva Factura</button>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th class="text-center">ID</th>
                        <th class="text-center">CLIENTE</th>
                        <th class="text-center">FACTURA</th>
                        <th class="text-center">ELEMENTOS</th>
                        <th class="hidden-xs" >ITBMS</th>
                        <th class="hidden-xs" >TOTAL</th>
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
                        <td class="text-center"><?php echo $lista_todos_contratos_ventas['contar']; ?></td>
                        <td class="font-w600"><?php echo number_format($lista_todos_contratos_ventas['itbms'], 2, '.',','); ?></td>
                        <td class="hidden-xs"><?php echo number_format($lista_todos_contratos_ventas['monto'], 2, '.',','); ?></td>
                        <td class="hidden-xs"><?php if($lista_todos_contratos_ventas['contar'] == 1){ echo 'Sin detalle'; }
                                                      elseif($lista_todos_contratos_ventas['contar'] == 2){ echo 'Pendiente Por Pagar';}
                                                        elseif($lista_todos_contratos_ventas['contar'] == 3){ echo 'Abonado';}
                                                          elseif($lista_todos_contratos_ventas['contar'] == 4){ echo 'Pagada';} ?></td>
                        <td class="hidden-xs">
                          <div class="btn-group">
                            <script type="text/javascript">
                              $(document).ready(function() {
                                $("#boton_p<?php echo $lista_todos_contratos_ventas['id']; ?>").click(function(event) {
                                $("#capa_p<?php echo $lista_todos_contratos_ventas['id']; ?>").load('cargas_paginas/Pagar factura.php?id=<?php echo $lista_todos_contratos_ventas['id']; ?>');
                                });
                              });
                            </script>
                               <button id="boton_p<?php echo $lista_todos_contratos_ventas['id']; ?>" class="btn btn-default" data-toggle="modal" data-target="#modal-popin<?php echo $lista_todos_contratos_ventas['id']; ?>" type="button"><i class="fa fa-dollar"></i></button>
                          </div>
                        </td>
                        <td class="hidden-xs">
                          <div class="btn-group">
                               <button class="btn btn-default" type="button"><i class="fa fa-file"></i></button>
                          </div>
                        </td>
                        <td class="hidden-xs">
                          <div class="btn-group">
                            <script type="text/javascript">
                              $(document).ready(function() {
                                $("#boton_d<?php echo $lista_todos_contratos_ventas['id']; ?>").click(function(event) {
                                $("#capa_d<?php echo $lista_todos_contratos_ventas['id']; ?>").load('cargas_paginas/elininar_inmueble.php?id=<?php echo $lista_todos_contratos_ventas['id']; ?>');
                                });
                              });
                            </script>
                               <button id="boton_d<?php echo $lista_todos_contratos_ventas['id']; ?>" class="btn btn-default" data-toggle="modal" data-target="#modal-popina<?php echo $lista_todos_contratos_ventas['id']; ?>" type="button"><i class="fa fa-trash-o"></i></button>
                          </div>
                        </td>
                    </tr>
                  <?php } ?>
                </tbody>
            </table>
            <!-- Pagar -->
            <div class="modal fade" id="modal-popin<?php echo $lista_todos_contratos_ventas['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
              <div class="modal-dialog modal-dialog-popin">
                <div id="capa_p<?php echo $lista_todos_contratos_ventas['id']; ?>" class="modal-content">

                </div>
             </div>
           </div>
           <!-- Borrar -->
           <div class="modal fade" id="modal-popina<?php echo $lista_todos_contratos_ventas['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
             <div class="modal-dialog modal-dialog-popin">
               <div id="capa_d<?php echo $lista_todos_contratos_ventas['id']; ?>" class="modal-content">

               </div>
            </div>
          </div>
          <!-- Detalle -->
          <div class="modal fade" id="modal-popina<?php echo $lista_todos_contratos_ventas['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-popin">
              <div id="capa_d<?php echo $lista_todos_contratos_ventas['id']; ?>" class="modal-content">

              </div>
           </div>
         </div>
         <!-- Nueva Factura -->
         <div class="modal fade" id="modal-popina<?php echo $lista_todos_contratos_ventas['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
           <div class="modal-dialog modal-dialog-popin">
             <div id="capa_d<?php echo $lista_todos_contratos_ventas['id']; ?>" class="modal-content">

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
<script src="<?php echo $one->assets_folder; ?>/js/plugins/jquery-auto-complete/jquery.auto-complete.min.js"></script>
<script type="text/javascript" src="bootstrap-filestyle.min.js"></script>
<script src="<?php echo $one->assets_folder; ?>/js/plugins/datatables/jquery.dataTables.min.js"></script>
<!-- Page JS Code -->
<script src="<?php echo $one->assets_folder; ?>/js/pages/base_tables_datatables.js"></script>
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
