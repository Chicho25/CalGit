<?php if(!isset($_SESSION)){session_start();}?>
<?php require("conexion/conexion.php"); ?>
<?php require("funciones/funciones.php"); ?>
<?php $nombre_pagina = "Tipo de Inmueble"; ?>
<?php if(isset($_SESSION['session_gc'])){ ?>
<?php $header_bar = 'base_header.php'; ?>
<?php $menu = true; ?>
<?php /* ################ AUDITORIA DE SEGUIMIENTO ############## */ ?>
<?php require("funciones/funciones_auditorias.php"); ?>
<?php $lugar_mapa = 25; ?>
<?php $dispositivo_acceso = obtener_dispositivo(); ?>
<?php insertar_log_seguimiento($conexion2, ObtenerIP(), $dispositivo_acceso, $lugar_mapa, $_SESSION['session_gc']['usua_id']); ?>
<?php /* ######################################################## */ ?>
<?php if(isset($_POST['nombre_tipo_inmueble'], 
                    $_POST['estado_tipo_inmueble'], 
                        $_POST['id_tipo_inmuebles'])){ ?>
<?php $sql_update_tipo_inmueble = mysqli_query($conexion2, "update tipo_inmuebles set im_nombre_inmueble = '".strtoupper($_POST['nombre_tipo_inmueble'])."', 
                                                                                      im_status = '".strtoupper($_POST['estado_tipo_inmueble'])."' where id_inmuebles = '".$_POST['id_tipo_inmuebles']."'"); } ?>
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
                    <?php if(isset($sql_update_tipo_inmueble)){ ?>
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
                        <th>NOMBRE DEL TIPO DE INMUEBLE</th>
                        <th class="hidden-xs" style="width: 15%;">ESTATUS DEL TIPO DE INMUEBLE</th>
                        <th class="hidden-xs" style="width: 15%;">DESCRIPCION</th>
                        <th class="text-center" style="width: 10%;">EDITAR</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $todos_tipo_inmuebles = todos_tipos_inmuebles($conexion2); ?>
                    <?php while($lista_todos_tipos_inmuebles = $todos_tipo_inmuebles -> fetch_array()){ ?>
                    <tr>
                        <td class="text-center"><?php echo $lista_todos_tipos_inmuebles['id_inmuebles']; ?></td>
                        <td class="font-w600"><?php echo $lista_todos_tipos_inmuebles['im_nombre_inmueble']; ?></td>
                        <td class="hidden-xs"><?php echo $lista_todos_tipos_inmuebles['estado']; ?></td>
                        <td class="hidden-xs"><?php echo $lista_todos_tipos_inmuebles['im_nombre_inmueble']; ?></td>
                        <td class="text-center">
                            <div class="btn-group">
                                <button class="btn btn-default" data-toggle="modal" data-target="#modal-popin<?php echo $lista_todos_tipos_inmuebles['id_inmuebles']; ?>" type="button"><i class="fa fa-pencil"></i></button>
                            </div>
                        </td>
                    </tr>
                            
                            <div class="modal fade" id="modal-popin<?php echo $lista_todos_tipos_inmuebles['id_inmuebles']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-popin">
                                    <div class="modal-content">
                                        
                                        <form action="" method="post" >

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
                                                                                    <input class="form-control" type="text" id="register1-username" name="id_tipo_inmuebles" readonly="readonly" value="<?php echo $lista_todos_tipos_inmuebles['id_inmuebles']; ?>">
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="col-xs-12" for="register1-username">NOMBRE TIPO DE INMUEBLE</label>
                                                                                <div class="col-xs-12">
                                                                                    <input class="form-control" type="text" id="register1-username" name="nombre_tipo_inmueble" value="<?php echo $lista_todos_tipos_inmuebles['im_nombre_inmueble']; ?>">
                                                                                </div>
                                                                            </div>
                                                                                <div class="form-group">
                                                                                    <label class="col-md-4 control-label" >ESTADO TIPO DE INMUEBLE</label>
                                                                                    <div class="col-md-7">
                                                                                        <label class="rad-inline" for="example-inline-checkbox1">
                                                                                            <input type="radio" id="example-inline-checkbox1" name="estado_tipo_inmueble" value="1" <?php if($lista_todos_tipos_inmuebles['im_status'] == 1){ echo 'checked';}  ?> > Activa
                                                                                        </label>
                                                                                        <label class="rad-inline" for="example-inline-checkbox1">
                                                                                            <input type="radio" id="example-inline-checkbox2" name="estado_tipo_inmueble" value="0" <?php if($lista_todos_tipos_inmuebles['im_status'] == 0){ echo 'checked';}  ?> > Inactiva
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