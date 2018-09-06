<?php if(!isset($_SESSION)){session_start();}?>
<?php require("conexion/conexion.php"); ?>
<?php require("funciones/funciones.php"); ?>
<?php if(isset($_SESSION['session_gc'])){ ?>
<?php $header_bar = 'base_header.php'; ?>
<?php $menu = true; ?>
<?php /* ################ AUDITORIA DE SEGUIMIENTO ############## */ ?>
<?php require("funciones/funciones_auditorias.php"); ?>
<?php $lugar_mapa = 27; ?>
<?php $dispositivo_acceso = obtener_dispositivo(); ?>
<?php insertar_log_seguimiento($conexion2, ObtenerIP(), $dispositivo_acceso, $lugar_mapa, $_SESSION['session_gc']['usua_id']); ?>
<?php /* ######################################################## */ ?>
<?php if(isset($_POST['eliminar'])){

        $eliminar_facturas_cuotas = $conexion2 ->query("delete from inmueble_rv where id_rv_inmueble = '".$_POST['eliminar']."'");

        $update_inmueble = $conexion2 -> query("update maestro_inmuebles set mi_status = 1 where id_inmueble = '".$_POST['id_inmueble']."'");

} ?>
<?php $nombre_pagina = "Reservas"; ?>
<?php if(isset($_POST['precio'],
                    $_POST['estado'],
                        $_POST['id_reserva'])){ ?>
<?php $sql_update_inmueble = mysqli_query($conexion2, "update inmueble_rv set rv_precio_venta = '".$_POST['precio']."',
                                                                              rv_precio_reserva = '".$_POST['precio_reserva']."',
                                                                              rv_status = '".$_POST['estado']."'
                                                                              where
                                                                              id_rv_inmueble = '".$_POST['id_reserva']."'");
                            if($_POST['estado'] == 0){
                                $sql_devolver_inmueble = $conexion2 -> query("update maestro_inmuebles set mi_status = 1 where id_inmueble = '".$_POST['id_inmueble']."'");
                            }
                         } ?>
<?php require 'inc/config.php'; ?>
<?php require 'inc/views/template_head_start.php'; ?>
<!-- Page JS Plugins CSS -->
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/datatables/jquery.dataTables.min.css">
<?php require 'inc/views/template_head_end.php'; ?>
<?php require 'inc/views/base_head.php'; ?>

<!-- Page Header -->
<div class="content bg-gray-lighter">
    <div class="row items-push">
        <div class="col-sm-7">
            <h1 class="page-heading">
                Ver todos los <?php echo $nombre_pagina; ?> <small>ver o editar <?php echo $nombre_pagina; ?>.</small>
            </h1>
        </div>
        <?php if(isset($sql_update_inmueble)){ ?>
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
            <h3 class="block-title">Tabla de <?php echo $nombre_pagina; ?> del sistema <small>todos los <?php echo $nombre_pagina; ?></small></h3>
        </div>
        <div class="block-content">
            <!-- DataTables init on table by adding .js-dataTable-full class, functionality initialized in js/pages/base_tables_datatables.js -->
            <table class="table table-bordered table-striped js-dataTable-full">
                <thead>
                    <tr>
                        <th class="text-center">ID</th>
                        <th>NOMBRE INMUEBLE</th>
                        <th class="text-center">CLIENTE</th>
                        <th class="hidden-xs" style="width: 15%;">VENDEDOR</th>
                        <th class="text-center" style="width: 10%;">EDITAR</th>
                        <th class="text-center" style="width: 10%;">ELIMINAR</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $todos_inmuebles_reservado = reservas_inmuebles($conexion2); ?>
                    <?php while($lista_todos_inmuebles_reservado = mysqli_fetch_array($todos_inmuebles_reservado)){ ?>
                    <tr>
                        <td class="text-center"><?php echo $lista_todos_inmuebles_reservado['id_rv_inmueble']; ?></td>
                        <td class="font-w600"><?php echo $lista_todos_inmuebles_reservado['mi_nombre']; ?></td>
                        <td class="font-w600"><?php echo $lista_todos_inmuebles_reservado['cl_nombre'].' '.$lista_todos_inmuebles_reservado['cl_apellido']; ?></td>
                        <td class="hidden-xs"><?php echo $lista_todos_inmuebles_reservado['ven_nombre'].' '.$lista_todos_inmuebles_reservado['ven_apellido']; ?></td>
                        <td class="text-center">
                            <div class="btn-group">
                                <button class="btn btn-default" data-toggle="modal" data-target="#modal-popin<?php echo $lista_todos_inmuebles_reservado['id_rv_inmueble']; ?>" type="button"><i class="fa fa-pencil"></i></button>
                            </div>
                        </td>
                        <td class="text-center">
                          <div class="btn-group">

                               <button class="btn btn-default" data-toggle="modal" data-target="#modal-popina<?php echo $lista_todos_inmuebles_reservado['id_rv_inmueble']; ?>" type="button"><i class="fa fa-trash-o"></i></button>


                               <div class="modal fade" id="modal-popina<?php echo $lista_todos_inmuebles_reservado['id_rv_inmueble']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                   <div class="modal-dialog modal-dialog-popin">
                                       <div class="modal-content">
                                           <div class="block block-themed block-transparent remove-margin-b">
                                               <div class="block-header bg-primary-dark">
                                                   <ul class="block-options">
                                                       <li>
                                                           <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                                                       </li>
                                                   </ul>
                                                   <h3 class="block-title">Eliminar la reserva</h3>
                                               </div>
                                               <div class="block-content">
                                                   Esta seguro que desea eliminar la reserva ?
                                               </div>
                                           </div>
                                           <div class="modal-footer">
                                             <form class="" action="" method="post">
                                               <button class="btn btn-sm btn-default" type="button" data-dismiss="modal">Cerrar</button>
                                               <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-check"></i> Ok</button>
                                               <input type="hidden" name="eliminar" value="<?php echo $lista_todos_inmuebles_reservado['id_rv_inmueble']; ?>">
                                               <input type="hidden" name="id_inmueble" value="<?php echo $lista_todos_inmuebles_reservado['id_inmueble_maestro']; ?>">
                                             </form>
                                           </div>
                                       </div>
                                   </div>
                               </div>

                          </div>
                        </td>
                    </tr>

                    <input class="form-control" type="hidden" id="register1-username" name="id_inmueble" readonly="readonly" value="<?php echo $lista_todos_inmuebles_reservado['id_inmueble']; ?>">

                            <div class="modal fade" id="modal-popin<?php echo $lista_todos_inmuebles_reservado['id_rv_inmueble']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
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
                                                                    <input class="form-control" type="text" id="register1-username" name="id_reserva" readonly="readonly" value="<?php echo $lista_todos_inmuebles_reservado['id_rv_inmueble']; ?>"></input>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-xs-12" for="register1-username">Fecha de reserva</label>
                                                                <div class="col-xs-12">
                                                                     <input class="form-control" type="text" id="register1-username" name="id_inmueble" readonly="readonly" value="<?php echo $lista_todos_inmuebles_reservado['rv_fecha']; ?>">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-xs-12" for="register1-username">Observaciones de la reserva</label>
                                                                <div class="col-xs-12">
                                                                    <textarea class="form-control" type="text" name="observaciones" readonly="readonly"><?php echo $lista_todos_inmuebles_reservado['rv_observaciones']; ?>"</textarea>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-xs-12" for="register1-username">Precio</label>
                                                                <div class="col-xs-12">
                                                                     <input class="form-control" type="number" name="precio" placeholder="Precio" required="required" value="<?php echo $lista_todos_inmuebles_reservado['rv_precio_venta']; ?>"></input>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-xs-12" for="register1-username">Precio de reserva</label>
                                                                <div class="col-xs-12">
                                                                     <input class="form-control" type="number" max="<?php echo $lista_todos_inmuebles_reservado['rv_precio_venta']; ?>" name="precio_reserva" placeholder="Precio reserva" required="required" value="<?php echo $lista_todos_inmuebles_reservado['rv_precio_reserva']; ?>"></input>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-xs-12" for="register1-username">Nombre del cliente</label>
                                                                <div class="col-xs-12">
                                                                     <input class="form-control" type="text" name="modelo" placeholder="Modelo" readonly="readonly" value="<?php echo $lista_todos_inmuebles_reservado['cl_nombre'].' '.$lista_todos_inmuebles_reservado['cl_apellido']; ?>"></input>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-xs-12" for="register1-username">Identificacion del cliente</label>
                                                                <div class="col-xs-12">
                                                                    <input class="form-control" type="text" name="area" placeholder="Area" readonly="readonly" value="<?php echo $lista_todos_inmuebles_reservado['cl_identificacion']; ?>"></input>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-xs-12" for="register1-username">Email del cliente</label>
                                                                <div class="col-xs-12">
                                                                    <input class="form-control" type="text" name="area" placeholder="Area" readonly="readonly" value="<?php echo $lista_todos_inmuebles_reservado['cl_email']; ?>"></input>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-xs-12" for="register1-username">Telefono del cliente</label>
                                                                <div class="col-xs-12">
                                                                    <input class="form-control" type="text" name="area" placeholder="Area" readonly="readonly" value="<?php echo $lista_todos_inmuebles_reservado['cl_telefono_1']; ?>"></input>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-xs-12" for="register1-username">Nombre del vendedor</label>
                                                                <div class="col-xs-12">
                                                                    <input class="form-control" type="text" name="area" placeholder="Area" readonly="readonly" value="<?php echo $lista_todos_inmuebles_reservado['ven_nombre'].' '.$lista_todos_inmuebles_reservado['ven_apellido']; ?>"></input>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-xs-12" for="register1-username">Telefono del vendedor</label>
                                                                <div class="col-xs-12">
                                                                    <input class="form-control" type="text" name="area" placeholder="Area" readonly="readonly" value="<?php echo $lista_todos_inmuebles_reservado['ven_telefono_1']; ?>"></input>
                                                                </div>
                                                            </div>


                                                            <div class="form-group">
                                                                <label class="col-xs-12" for="register1-username">Nombre del Inmueble</label>
                                                                <div class="col-xs-12">
                                                                    <input class="form-control" type="text" name="area" placeholder="Area" readonly="readonly" value="<?php echo $lista_todos_inmuebles_reservado['mi_nombre']; ?>"></input>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-xs-12" for="register1-username">Modelo</label>
                                                                <div class="col-xs-12">
                                                                    <input class="form-control" type="text" name="area" placeholder="Area" readonly="readonly" value="<?php echo $lista_todos_inmuebles_reservado['mi_modelo']; ?>"></input>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-xs-12" for="register1-username">Area</label>
                                                                <div class="col-xs-12">
                                                                    <input class="form-control" type="text" name="area" placeholder="Area" readonly="readonly" value="<?php echo $lista_todos_inmuebles_reservado['mi_area']; ?>"></input>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-xs-12" for="register1-username">Habitaciones</label>
                                                                <div class="col-xs-12">
                                                                    <input class="form-control" type="text" name="area" placeholder="Area" readonly="readonly" value="<?php echo $lista_todos_inmuebles_reservado['mi_habitaciones']; ?>"></input>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-xs-12" for="register1-username">Sanitarios</label>
                                                                <div class="col-xs-12">
                                                                    <input class="form-control" type="text" name="area" placeholder="Area" readonly="readonly" value="<?php echo $lista_todos_inmuebles_reservado['mi_sanitarios']; ?>"></input>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-xs-12" for="register1-username">Depositos</label>
                                                                <div class="col-xs-12">
                                                                    <input class="form-control" type="text" name="area" placeholder="Area" readonly="readonly" value="<?php echo $lista_todos_inmuebles_reservado['mi_depositos']; ?>"></input>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-xs-12" for="register1-username">Estacionamientos</label>
                                                                <div class="col-xs-12">
                                                                    <input class="form-control" type="text" name="area" placeholder="Area" readonly="readonly" value="<?php echo $lista_todos_inmuebles_reservado['mi_estacionamientos']; ?>"></input>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-xs-12" for="register1-username">Usuario del sistema</label>
                                                                <div class="col-xs-12">
                                                                    <input class="form-control" type="text" name="area" placeholder="Area" readonly="readonly" value="<?php echo $lista_todos_inmuebles_reservado['usua_nombre'].' '.$lista_todos_inmuebles_reservado['usua_apellido']; ?>"></input>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-md-4 control-label" >ESTADO</label>
                                                                <div class="col-md-7">
                                                                    <label class="rad-inline" for="example-inline-checkbox1">
                                                                        <input type="radio" id="example-inline-checkbox1" name="estado" value="1" <?php if($lista_todos_inmuebles_reservado['rv_status'] == 1){ echo 'checked';}  ?> ></input> Activa
                                                                    </label>
                                                                    <label class="rad-inline" for="example-inline-checkbox1">
                                                                        <input type="radio" id="example-inline-checkbox2" name="estado" value="0" <?php if($lista_todos_inmuebles_reservado['rv_status'] == 0){ echo 'checked';}  ?> ></input> Inactiva
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
<script type="text/javascript" src="bootstrap-filestyle.min.js"></script>

<script src="<?php echo $one->assets_folder; ?>/js/plugins/datatables/jquery.dataTables.min.js"></script>

<!-- Page JS Code -->
<script src="<?php echo $one->assets_folder; ?>/js/pages/base_tables_datatables.js"></script>

<?php require 'inc/views/template_footer_end.php'; ?>
<?php }else{ ?>

        <script type="text/javascript">
            window.location="salir.php";
        </script>

<?php } ?>
