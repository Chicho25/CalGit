<?php if(!isset($_SESSION)){session_start();}?>
<?php require("conexion/conexion.php"); ?>
<?php require("funciones/funciones.php"); ?>
<?php if(isset($_SESSION['session_gc'])){ ?>
<?php $header_bar = 'base_header.php'; ?>
<?php $menu = true; ?>

<?php $nombre_pagina = "Servicios"; ?>

<?php if(isset($_POST['id_venta_contrato'])){
               $_SESSION['id_venta_contrato']=$_POST['id_venta_contrato'];
        }elseif(isset($_GET['id_venta'])){
          $_SESSION['id_venta_contrato']=$_GET['id_venta'];
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
        <div class="col-sm-7">
            <h1 class="page-heading">
                Ver todos los <?php echo $nombre_pagina; ?> por contrato de alquiler <small>ver o editar <?php echo $nombre_pagina; ?>.</small>
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
            <h3 class="block-title">Tabla de <?php echo $nombre_pagina; ?> por contrato de alquileres del sistema <small>todos los <?php echo $nombre_pagina; ?> por contrato de Alquiler</small></h3>
        </div>
        <div class="block-content">
            <button class="btn btn-sm btn-primary" type="submit" name="PDF">PDF</button>
             <a class="btn btn-sm btn-primary" style="float:left; padding-left: 10px;" href="">EXCEL</a>

            <!-- DataTables init on table by adding .js-dataTable-full class, functionality initialized in js/pages/base_tables_datatables.js -->
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th class="text-center">CLIENTE</th>
                        <th class="text-center">SLIP</th>
                        <th class="hidden-xs" >FECHA REGISTRO</th>
                        <th class="hidden-xs" >FECHA PAGO</th>
                        <th class="hidden-xs" >DESCRIPCION</th>
                        <th class="hidden-xs" >MONTO A PAGAR</th>
                        <th class="hidden-xs" >MONTO PAGADO</th>
                        <th class="hidden-xs" >STATUS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $total_monto_a_pagar = 0; ?>
                    <?php $total_monto_pago = 0; ?>
                    <?php $total_cuotas = 0; ?>
                    <?php $todos_contratos_ventas = $conexion2 -> query("SELECT
                              s.monto,
                              s.descripcion,
                              s.stat,
                              case
                              when s.stat = 1 then 'Por Pagar'
                              when s.stat = 3 then 'Pagado'
                              end as status_des,
                              s.date_time,
                              s.fecha_pago,
                              mi.mi_codigo_imueble,
                              mi.mi_nombre,
                              mc.cl_nombre,
                              mc.cl_apellido
                              FROM servicios s inner join maestro_ventas mv on s.id_ventas = mv.id_venta
                              inner join maestro_inmuebles mi on mv.id_inmueble = mi.id_inmueble
                              inner join maestro_clientes mc on mv.id_cliente = mc.id_cliente"); ?>

                    <?php while($lista_todos_contratos_ventas = $todos_contratos_ventas -> fetch_array()){?>
                    <tr>
                        <td class="font-w600"><?php echo $lista_todos_contratos_ventas['cl_nombre'].' '.$lista_todos_contratos_ventas['cl_apellido']; ?></td>
                        <td class="text-center"><?php echo $lista_todos_contratos_ventas['mi_codigo_imueble']; ?></td>
                        <td class="font-w600"><?php echo date("d-m-Y", strtotime($lista_todos_contratos_ventas['date_time'])); ?></td>
                        <td class="font-w600"><?php echo date("d-m-Y", strtotime($lista_todos_contratos_ventas['fecha_pago'])); ?></td>
                        <td class="hidden-xs"><?php echo $lista_todos_contratos_ventas['descripcion']; ?></td>
                        <td class="hidden-xs"><?php echo number_format($por_pagar, 2, '.',','); ?></td>
                        <td class="hidden-xs"><?php echo number_format($pagado, 2, '.',','); ?></td>
                        <td class="hidden-xs"><?php echo $lista_todos_contratos_ventas['status_des']; ?></td>
                    </tr>
                    <input class="form-control" type="hidden" id="register1-username" name="id_cuota" readonly="readonly" value="<?php echo $lista_todos_contratos_ventas['id']; ?>">
                    <?php
                      $total_cuotas++;
                      }
                      ?>
                        <tr>
                          <td class="text-center font-w600" colspan="3">Total Numero de cuotas: <?php echo $total_cuotas; ?></td>
                          <td class="text-center font-w600" colspan="2">Total Monto a Pagar: <?php echo number_format($total_monto_a_pagar, 2, '.',','); ?> </td>
                          <td class="text-center font-w600" colspan="2">Total Monto Pagado: <?php echo number_format($total_monto_pago, 2, '.',','); ?> </td>
                        </tr>
                </tbody>
            </table>
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
