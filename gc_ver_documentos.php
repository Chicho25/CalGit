<?php if(!isset($_SESSION)){session_start();}?>
<?php require("conexion/conexion.php"); ?>
<?php require("funciones/funciones.php"); ?>
<?php if(isset($_SESSION['session_gc'])){ ?>
<?php $header_bar = 'base_header.php'; ?>
<?php $menu = true; ?>
<?php /* ################ AUDITORIA DE SEGUIMIENTO ############## */ ?>
<?php require("funciones/funciones_auditorias.php"); ?>
<?php $lugar_mapa = 46; ?>
<?php $dispositivo_acceso = obtener_dispositivo(); ?>
<?php insertar_log_seguimiento($conexion2, ObtenerIP(), $dispositivo_acceso, $lugar_mapa, $_SESSION['session_gc']['usua_id']); ?>
<?php /* ######################################################## */ ?>
<?php if(isset($_POST['eliminar'])){

        $eliminar_facturas_cuotas = $conexion2 ->query("delete from maestro_cuotas where id_cuota = '".$_POST['eliminar']."'");
        $update_inmueble = $conexion2 -> query("update maestro_ventas set mv_status = 4 where id_venta = '".$_POST['contrato_venta']."'");

} ?>
<?php $nombre_pagina = "Cuotas"; ?>
<?php if(isset($_POST['monto'],
                    $_POST['estado'],
                        $_POST['id_cuota'],
                            $_POST['monto_abonado'],
                                $_POST['fecha_vencimiento'])){ ?>
<?php $sql_update_cuota = mysqli_query($conexion2, "update maestro_cuotas set mc_fecha_vencimiento = '".date("Y-m-d", strtotime($_POST['fecha_vencimiento']))."',
                                                                              mc_monto = '".$_POST['monto']."',
                                                                              mc_monto_abonado = '".$_POST['monto_abonado']."',
                                                                              mc_status = '".$_POST['estado']."'
                                                                              where
                                                                              id_cuota = '".$_POST['id_cuota']."'"); } ?>
<?php require 'inc/config.php'; ?>
<?php require 'inc/views/template_head_start.php'; ?>
<!-- Page JS Plugins CSS -->
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/bootstrap-datepicker/bootstrap-datepicker3.min.css">
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/datatables/jquery.dataTables.min.css">
<?php require 'inc/views/template_head_end.php'; ?>
<?php require 'inc/views/base_head.php'; ?>

<!-- Page Header -->
<div class="content bg-gray-lighter">
    <?php echo $_POST['monto'] ?>
    <div class="row items-push">
        <div class="col-sm-7">
            <h1 class="page-heading">
                Ver todos las <?php echo $nombre_pagina; ?> <small>ver o editar <?php echo $nombre_pagina; ?>.</small>
            </h1>
        </div>
        <?php if(isset($sql_update_cuota)){ ?>
            <div class="col-sm-3 col-lg-3" style="position: absolute; right: 0px;">
                <!-- Success Alert -->
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h3 class="font-w300 push-15">Datos Actualizados</h3>
                    <p><a class="alert-link" href="javascript:void(0)">Los datos</a> fueron actualizados!</p>
                </div>
                <!-- END Success Alert -->
            </div>
        <?php } ?>
    </div>
</div>
<!-- END Page Header -->
<!-- Page Content -->
<div class="content">
    <!-- Dynamic Table Full -->
    <div class="block">
        <div class="block-header">
            <h3 class="block-title">Tabla de <?php echo $nombre_pagina; ?> del sistema <small>todos las <?php echo $nombre_pagina; ?></small></h3>
        </div>
        <div class="block-content">
            <!-- DataTables init on table by adding .js-dataTable-full class, functionality initialized in js/pages/base_tables_datatables.js -->
            <table class="table table-bordered table-striped js-dataTable-full">
                <thead>
                    <tr>
                        <th class="text-center">ID</th>
                        <th>TIPO DE CUOTA</th>
                        <th class="text-center">CLIENTE</th>
                        <th class="hidden-xs" style="width: 15%;">FECHA VENCIMIENTO</th>
                        <th class="text-center" style="width: 10%;">EDITAR</th>
                        <th class="text-center" style="width: 10%;">ELIMINAR</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $todos_contratos_ventas = todos_cuotas_contrato($conexion2); ?>
                    <?php while($lista_todos_contratos_ventas = mysqli_fetch_array($todos_contratos_ventas)){ ?>
                    <tr>
                        <td class="text-center"><?php echo $lista_todos_contratos_ventas['id_cuota']; ?></td>
                        <td class="font-w600"><?php echo $lista_todos_contratos_ventas['tc_nombre_tipo_cuenta']; ?></td>
                        <td class="font-w600"><?php echo $lista_todos_contratos_ventas['cl_nombre'].' '.$lista_todos_contratos_ventas['cl_apellido']; ?></td>
                        <td class="hidden-xs"><?php echo date("d-m-Y", strtotime($lista_todos_contratos_ventas['mc_fecha_vencimiento'])); ?></td>
                        <td class="text-center">
                            <div class="btn-group">
                                <button class="btn btn-default" data-toggle="modal" data-target="#modal-popin<?php echo $lista_todos_contratos_ventas['id_cuota']; ?>" type="button"><i class="fa fa-pencil"></i></button>
                            </div>
                        </td>
                        <td class="text-center">
                        <div class="btn-group">

                             <button class="btn btn-default" data-toggle="modal" data-target="#modal-popina<?php echo $lista_todos_contratos_ventas['id_cuota']; ?>" type="button"><i class="fa fa-trash-o"></i></button>


                             <div class="modal fade" id="modal-popina<?php echo $lista_todos_contratos_ventas['id_cuota']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                 <div class="modal-dialog modal-dialog-popin">
                                     <div class="modal-content">
                                         <div class="block block-themed block-transparent remove-margin-b">
                                             <div class="block-header bg-primary-dark">
                                                 <ul class="block-options">
                                                     <li>
                                                         <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                                                     </li>
                                                 </ul>
                                                 <h3 class="block-title">Eliminar el contrato de venta</h3>
                                             </div>
                                             <div class="block-content">
                                                 Esta seguro que desea eliminar el contrato de venta ?
                                             </div>
                                         </div>
                                         <div class="modal-footer">
                                           <form class="" action="" method="post">
                                             <button class="btn btn-sm btn-default" type="button" data-dismiss="modal">Cerrar</button>
                                             <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-check"></i> Ok</button>
                                             <input type="hidden" name="eliminar" value="<?php echo $lista_todos_contratos_ventas['id_cuota']; ?>">
                                             <input type="hidden" name="contrato_venta" value="<?php echo $lista_todos_contratos_ventas['id_contrato_venta']; ?>">
                                           </form>
                                         </div>
                                     </div>
                                 </div>
                             </div>

                        </div>
                        </td>
                    </tr>

                    <input class="form-control" type="hidden" id="register1-username" name="id_cuota" readonly="readonly" value="<?php echo $lista_todos_contratos_ventas['id_cuota']; ?>">

                            <div class="modal fade" id="modal-popin<?php echo $lista_todos_contratos_ventas['id_cuota']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
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
                                                    <h3 class="block-title">Actualizar Datos</h3>
                                                </div>
                                                <div class="block-content">
                                                    <!-- Bootstrap Register -->
                                                    <div class="block block-themed">
                                                        <div class="block-content">
                                                            <div class="form-group">
                                                                <label class="col-xs-12" for="register1-username">ID</label>
                                                                <div class="col-xs-12">
                                                                    <input class="form-control" type="text" id="register1-username" name="id_cuota" readonly="readonly" value="<?php echo $lista_todos_contratos_ventas['id_cuota']; ?>"></input>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-xs-12" for="register1-username">Fecha de creacion</label>
                                                                <div class="col-xs-12">
                                                                    <input class="form-control" type="text" id="register1-username" readonly="readonly" value="<?php  echo date("d-m-Y", strtotime($lista_todos_contratos_ventas['mc_fecha_creacion_contrato'])); ?>"></input>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-xs-12" for="register1-username">Fecha de vencimiento</label>
                                                                <div class="col-xs-12">
                                                                     <input class="js-datepicker form-control" type="text" id="example-datepicker1" name="fecha_vencimiento" data-date-format="dd-mm-yyyy" value="<?php echo date("d-m-Y", strtotime($lista_todos_contratos_ventas['mc_fecha_vencimiento'])); ?>">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-xs-12" for="register1-username">Monto </label>
                                                                <div class="col-xs-12">
                                                                    <input class="form-control" type="text" name="monto" placeholder="Precio" required="required" 
                                                                           value="<?php echo number_format($lista_todos_contratos_ventas['mc_monto'], 2, ".",",") ?>"></input>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-xs-12" for="register1-username">Monto abonado</label>
                                                                <div class="col-xs-12">
                                                                     <input class="form-control" type="text" name="monto_abonado" placeholder="Precio" required="required" 
                                                                            value="<?php echo number_format($lista_todos_contratos_ventas['mc_monto_abonado'], 2, ".", ",") ?>"></input>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-xs-12" for="register1-username">Nombre del cliente</label>
                                                                <div class="col-xs-12">
                                                                     <input class="form-control" type="text" placeholder="Modelo" readonly="readonly" value="<?php echo $lista_todos_contratos_ventas['cl_nombre'].' '.$lista_todos_contratos_ventas['cl_apellido']; ?>"></input>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-xs-12" for="register1-username">Inmueble</label>
                                                                <div class="col-xs-12">
                                                                    <input class="form-control" type="text" placeholder="Area" readonly="readonly" value="<?php echo $lista_todos_contratos_ventas['mi_nombre']; ?>"></input>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-xs-12" for="register1-username"></label>
                                                                <div class="col-xs-12">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-md-4 control-label" >ESTADO</label>
                                                                <div class="col-md-7">
                                                                    <label class="rad-inline" for="example-inline-checkbox1">
                                                                        <input type="radio" id="example-inline-checkbox1" name="estado" value="1" <?php if($lista_todos_contratos_ventas['mc_status'] == 1){ echo 'checked';}  ?> ></input> Activa
                                                                    </label>
                                                                    <label class="rad-inline" for="example-inline-checkbox1">
                                                                        <input type="radio" id="example-inline-checkbox2" name="estado" value="0" <?php if($lista_todos_contratos_ventas['mc_status'] == 0){ echo 'checked';}  ?> ></input> Inactiva
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button class="btn btn-sm btn-default" type="button" data-dismiss="modal">Cancelar</button>
                                                                <button class="btn btn-sm btn-primary" type="submit" >Guardar cambios</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
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
