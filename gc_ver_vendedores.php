<?php if(!isset($_SESSION)){session_start();}?>
<?php require("conexion/conexion.php"); ?>
<?php require("funciones/funciones.php"); ?>
<?php if(isset($_SESSION['session_gc'])){ ?>
<?php $header_bar = 'base_header.php'; ?>
<?php $menu = true; ?>
<?php /* ################ AUDITORIA DE SEGUIMIENTO ############## */ ?>
<?php require("funciones/funciones_auditorias.php"); ?>
<?php $lugar_mapa = 15; ?>
<?php $dispositivo_acceso = obtener_dispositivo(); ?>
<?php insertar_log_seguimiento($conexion2, ObtenerIP(), $dispositivo_acceso, $lugar_mapa, $_SESSION['session_gc']['usua_id']); ?>
<?php /* ######################################################## */ ?>
<?php if(isset($_POST['nombre'],
                    $_POST['apellido'],
                        $_POST['identidicacion'],
                            $_POST['telefono_1'],
                                $_POST['telefono_2'],
                                    $_POST['email'],
                                $_POST['estado'])){ ?>
<?php $sql_update_proveedor = mysqli_query($conexion2, "update maestro_vendedores set ven_nombre = '".strtoupper($_POST['nombre'])."',
                                                                                       ven_apellido = '".strtoupper($_POST['apellido'])."',
                                                                                       ven_identidicacion = '".strtoupper($_POST['identidicacion'])."',
                                                                                       ven_telefono_1 = '".strtoupper($_POST['telefono_1'])."',
                                                                                       ven_telefono_2 = '".strtoupper($_POST['telefono_2'])."',
                                                                                       ven_email = '".strtoupper($_POST['email'])."',
                                                                                       ven_status = '".strtoupper($_POST['estado'])."' where id_vendedor = '".$_POST['id_vendedor']."'");

############################# Auditoria ##############################

                                      $tipo_operacion = 2;
                                      $comentario = "Actualizacion de Vendedor";
                                      $sql_insertar_auditoria = $conexion2 -> query("insert into auditoria_vendedor(auv_tipo_operacion,
                                                                                                                    auv_usua_log,
                                                                                                                    auv_comentario,
                                                                                                                    auv_id_vendedor,
                                                                                                                    auv_ven_nombre,
                                                                                                                    auv_ven_apellido,
                                                                                                                    auv_ven_telefono_1,
                                                                                                                    auv_ven_telefono_2,
                                                                                                                    auv_ven_identidicacion,
                                                                                                                    auv_ven_status,
                                                                                                                    auv_ven_email
                                                                                                                    )values(
                                                                                                                    '".$tipo_operacion."',
                                                                                                                    '".$_SESSION['session_gc']['usua_id']."',
                                                                                                                    '".$comentario."',
                                                                                                                    '".$_POST['id_vendedor']."',
                                                                                                                    '".$_POST['nombre']."',
                                                                                                                    '".$_POST['apellido']."',
                                                                                                                    '".$_POST['telefono_1']."',
                                                                                                                    '".$_POST['telefono_2']."',
                                                                                                                    '".$_POST['identificacion']."',
                                                                                                                    '".$_POST['estado']."',
                                                                                                                    '".$_POST['email']."')");
#######################################################################
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
                Ver todos los vendedores <small>ver o editar vendedores.</small>
            </h1>
        </div>
        <?php if(isset($sql_update_proveedor)){ ?>
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
            <h3 class="block-title">Tabla de vendedores del sistema <small>todos los vendedores</small></h3>
        </div>
        <div class="block-content">
            <!-- DataTables init on table by adding .js-dataTable-full class, functionality initialized in js/pages/base_tables_datatables.js -->
            <table class="table table-bordered table-striped js-dataTable-full">
                <thead>
                    <tr>
                        <th class="text-center">ID</th>
                        <th>NOMBRE </th>
                        <th class="hidden-xs">EMAIL</th>
                        <th class="hidden-xs" style="width: 15%;">ESTATUS</th>
                        <th class="text-center" style="width: 10%;">EDITAR</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $todos_vendedores = todos_vendedores($conexion2); ?>
                    <?php while($lista_todos_vendedores = mysqli_fetch_array($todos_vendedores)){ ?>
                    <tr>
                        <td class="text-center"><?php echo $lista_todos_vendedores['id_vendedor']; ?></td>
                        <td class="font-w600"><?php echo $lista_todos_vendedores['ven_nombre']; ?></td>
                        <td class="hidden-xs"><?php echo $lista_todos_vendedores['ven_email']; ?></td>
                        <td class="hidden-xs"><?php if($lista_todos_vendedores['ven_status']==1){ echo 'Activo';}else{ echo 'Inactivo';} ?></td>
                        <td class="text-center">
                            <div class="btn-group">
                                <button class="btn btn-default" data-toggle="modal" data-target="#modal-popin<?php echo $lista_todos_vendedores['id_vendedor']; ?>" type="button"><i class="fa fa-pencil"></i></button>
                            </div>
                        </td>
                    </tr>

                            <div class="modal fade" id="modal-popin<?php echo $lista_todos_vendedores['id_vendedor']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
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
                                                                                    <input class="form-control" type="text" id="register1-username" name="id_vendedor" readonly="readonly" value="<?php echo $lista_todos_vendedores['id_vendedor']; ?>">
                                                                                </div>
                                                                            </div>

                                                                            <div class="form-group">
                                                                                <label class="col-xs-12" for="register1-username">NOMBRE</label>
                                                                                <div class="col-xs-12">
                                                                                    <input class="form-control" type="text" id="register1-username" name="nombre" value="<?php echo $lista_todos_vendedores['ven_nombre']; ?>">
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="col-xs-12" for="register1-email">APELLIDO</label>
                                                                                <div class="col-xs-12">
                                                                                    <input class="form-control" type="text" id="register1-email" name="apellido" value="<?php echo $lista_todos_vendedores['ven_apellido']; ?>">
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="col-xs-12" for="register1-email">IDENTIFICACION</label>
                                                                                <div class="col-xs-12">
                                                                                    <input class="form-control" type="text" id="register1-email" name="identidicacion" value="<?php echo $lista_todos_vendedores['ven_identidicacion']; ?>">
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="col-xs-12" >TELEFONO 1</label>
                                                                                <div class="col-xs-12">
                                                                                    <input class="form-control" type="text" id="register1-email" name="telefono_1" value="<?php echo $lista_todos_vendedores['ven_telefono_1']; ?>">
                                                                                </div>
                                                                            </div>

                                                                            <div class="form-group">
                                                                                <label class="col-xs-12">TELEFONO 2</label>
                                                                                <div class="col-xs-12">
                                                                                    <input class="form-control" type="text" name="telefono_2" value="<?php echo $lista_todos_vendedores['ven_telefono_2']; ?>">
                                                                                </div>
                                                                            </div>

                                                                            <div class="form-group">
                                                                                <label class="col-xs-12">EMAIL</label>
                                                                                <div class="col-xs-12">
                                                                                    <input class="form-control" type="text" name="email" value="<?php echo $lista_todos_vendedores['ven_email']; ?>">
                                                                                </div>
                                                                            </div>

                                                                            <div class="form-group">
                                                                                <label class="col-md-4 control-label" ></label>
                                                                                <div class="col-md-7">
                                                                                    <label class="rad-inline" for="example-inline-checkbox1"></label>
                                                                                    <label class="rad-inline" for="example-inline-checkbox1"></label>
                                                                                </div>
                                                                            </div>

                                                                                <div class="form-group">
                                                                                    <label class="col-md-4 control-label" >Estado de proveedor</label>
                                                                                    <div class="col-md-7">
                                                                                        <label class="rad-inline" for="example-inline-checkbox1">
                                                                                            <input type="radio" id="example-inline-checkbox1" name="estado" value="1" <?php if($lista_todos_vendedores['ven_status'] == 1){ echo 'checked';}  ?> > Activa
                                                                                        </label>
                                                                                        <label class="rad-inline" for="example-inline-checkbox1">
                                                                                            <input type="radio" id="example-inline-checkbox2" name="estado" value="0" <?php if($lista_todos_vendedores['ven_status'] == 0){ echo 'checked';}  ?> > Inactiva
                                                                                        </label>

                                                                                    </div>
                                                                                </div>

                                                            <div class="modal-footer">
                                                                <button class="btn btn-sm btn-default" type="button" data-dismiss="modal">Cancelar</button>
                                                                <button class="btn btn-sm btn-primary" type="submit" >Guardar cambios</button>
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
<script type="text/javascript" src="bootstrap-filestyle.min.js"> </script>

<script src="<?php echo $one->assets_folder; ?>/js/plugins/datatables/jquery.dataTables.min.js"></script>

<!-- Page JS Code -->
<script src="<?php echo $one->assets_folder; ?>/js/pages/base_tables_datatables.js"></script>

<?php require 'inc/views/template_footer_end.php'; ?>
<?php }else{ ?>

        <script type="text/javascript">
            window.location="salir.php";
        </script>

<?php } ?>
