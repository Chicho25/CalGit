<?php if(!isset($_SESSION)){session_start();}?>
<?php require("conexion/conexion.php"); ?>
<?php require("funciones/funciones.php"); ?>
<?php $nombre_pagina = "grupos de inmuebles"; ?>
<?php if(isset($_SESSION['session_gc'])){ ?>
<?php $header_bar = 'base_header.php'; ?>
<?php $menu = true; ?>
<?php /* ################ AUDITORIA DE SEGUIMIENTO ############## */ ?>
<?php require("funciones/funciones_auditorias.php"); ?>
<?php $lugar_mapa = 21; ?>
<?php $dispositivo_acceso = obtener_dispositivo(); ?>
<?php insertar_log_seguimiento($conexion2, ObtenerIP(), $dispositivo_acceso, $lugar_mapa, $_SESSION['session_gc']['usua_id']); ?>
<?php /* ######################################################## */ ?>
<?php if(isset($_POST['nombre_grupo_inmueble'], 
                    $_POST['id_proyecto'], 
                        $_POST['estado_grupo_inmueble'])){ ?>
<?php $sql_update_grupo_inmueble = mysqli_query($conexion2, "update grupo_inmuebles set gi_nombre_grupo_inmueble = '".strtoupper($_POST['nombre_grupo_inmueble'])."',
                                                                                        gi_id_proyecto = '".strtoupper($_POST['id_proyecto'])."',
                                                                                        gi_status = '".strtoupper($_POST['estado_grupo_inmueble'])."' where id_grupo_inmuebles = '".$_POST['id_grupo_inmuebles']."'"); } ?>
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
                    <?php if(isset($sql_update_grupo_inmueble)){ ?>
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
                        <th class="text-center">NOMBRE DEL TIPO DE INMUEBLE</th>
                        <th class="text-center">PROYECTO</th>
                        <th class="text-center">ESTATUS DEL TIPO DE INMUEBLE</th>
                        <th class="text-center" style="width: 10%;">EDITAR</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $todos_grupo_inmuebles = todos_grupo_inmuebles($conexion2); ?>
                    <?php while($lista_todos_grupo_inmuebles = $todos_grupo_inmuebles -> fetch_array()){ ?>
                    <tr>
                        <td class="text-center"><?php echo $lista_todos_grupo_inmuebles['id_grupo_inmuebles']; ?></td>
                        <td class="text-center"><?php echo $lista_todos_grupo_inmuebles['gi_nombre_grupo_inmueble']; ?></td>
                        <td class="text-center"><?php echo $lista_todos_grupo_inmuebles['proy_nombre_proyecto']; ?></td>
                        <td class="text-center"><?php echo $lista_todos_grupo_inmuebles['estado']; ?></td>
                        <td class="text-center">
                            <div class="btn-group">
                                <button class="btn btn-default" data-toggle="modal" data-target="#modal-popin<?php echo $lista_todos_grupo_inmuebles['id_grupo_inmuebles']; ?>" type="button"><i class="fa fa-pencil"></i></button>
                            </div>
                        </td>
                    </tr>
                            
                            <div class="modal fade" id="modal-popin<?php echo $lista_todos_grupo_inmuebles['id_grupo_inmuebles']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
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
                                                                                    <input class="form-control" type="text" id="register1-username" name="id_grupo_inmuebles" readonly="readonly" value="<?php echo $lista_todos_grupo_inmuebles['id_grupo_inmuebles']; ?>">
                                                                                </div>
                                                                            </div>
                                                                            
                                                                            <div class="form-group">
                                                                            <label class="col-xs-12" for="register1-username">PROYECTO<span class="text-danger">*</span></label>
                                                                               <div class="col-xs-12">
                                                                                    <select class="js-select2 form-control" name="id_proyecto" style="width: 100%;" data-placeholder="Seleccionar proyecto" required="required">
                                                                                        <option value="0"> Selecciona un proyecto</option>    
                                                                                        <?php   
                                                                                                $strConsulta = "select id_proyecto, proy_nombre_proyecto from maestro_proyectos where proy_estado = 1";
                                                                                                $result = $conexion2->query($strConsulta);
                                                                                                $opciones = '<option value="0"> Elige un proyecto </option>';
                                                                                                while($fila = $result->fetch_array()){ ?> 
                                                                                                        <option value="<?php echo $fila['id_proyecto']; ?>" <?php if($lista_todos_grupo_inmuebles['gi_id_proyecto'] == $fila['id_proyecto']){ echo 'selected';} ?> ><?php echo $fila['proy_nombre_proyecto']; ?></option>
                                                                                        <?php  } ?>
                                                                                    </select>
                                                                                </div>
                                                                            </div>

                                                                            <div class="form-group">
                                                                                <label class="col-xs-12" for="register1-username">NOMBRE</label>
                                                                                <div class="col-xs-12">
                                                                                    <input class="form-control" type="text" id="register1-username" name="nombre_grupo_inmueble" value="<?php echo $lista_todos_grupo_inmuebles['gi_nombre_grupo_inmueble']; ?>">
                                                                                </div>
                                                                            </div>
                                                                                <div class="form-group">
                                                                                    <label class="col-md-4 control-label" >ESTADO</label>
                                                                                    <div class="col-md-7">
                                                                                        <label class="rad-inline" for="example-inline-checkbox1">
                                                                                            <input type="radio" id="example-inline-checkbox1" name="estado_grupo_inmueble" value="1" <?php if($lista_todos_grupo_inmuebles['gi_status'] == 1){ echo 'checked';}  ?> > Activa
                                                                                        </label>
                                                                                        <label class="rad-inline" for="example-inline-checkbox1">
                                                                                            <input type="radio" id="example-inline-checkbox2" name="estado_grupo_inmueble" value="0" <?php if($lista_todos_grupo_inmuebles['gi_status'] == 0){ echo 'checked';}  ?> > Inactiva
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