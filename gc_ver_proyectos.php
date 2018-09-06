<?php if(!isset($_SESSION)){session_start();}?>
<?php require("conexion/conexion.php"); ?>
<?php require("funciones/funciones.php"); ?>
<?php if(isset($_SESSION['session_gc'])){ ?>
<?php $header_bar = 'base_header.php'; ?>
<?php $menu = true; ?>
<?php /* ################ AUDITORIA DE SEGUIMIENTO ############## */ ?>
<?php require("funciones/funciones_auditorias.php"); ?>
<?php $lugar_mapa = 7; ?>
<?php $dispositivo_acceso = obtener_dispositivo(); ?>
<?php insertar_log_seguimiento($conexion2, ObtenerIP(), $dispositivo_acceso, $lugar_mapa, $_SESSION['session_gc']['usua_id']); ?>
<?php /* ######################################################## */ ?>
<?php if(isset($_POST['nombre_proyecto'],
                    $_POST['tipo_proyecto'],
                        $_POST['promotor'],
                            $_POST['area'],
                                $_POST['estado_proyecto'],
                                    $_POST['resolucion_ambiental'],
                                        $_POST['id_proyecto'])){ ?>
<?php $sql_update_proyecto = mysqli_query($conexion2, "update maestro_proyectos set proy_nombre_proyecto = '".strtoupper($_POST['nombre_proyecto'])."',
                                                                                    proy_tipo_proyecto = '".strtoupper($_POST['tipo_proyecto'])."',
                                                                                    proy_promotor = '".strtoupper($_POST['promotor'])."',
                                                                                    proy_area = '".strtoupper($_POST['area'])."',
                                                                                    proy_monto_inicial = '".$_POST['monto_inicial']."',
                                                                                    proy_estado = '".strtoupper($_POST['estado_proyecto'])."',
                                                                                    proy_resolucion_ambiental = '".strtoupper($_POST['resolucion_ambiental'])."' where id_proyecto = '".$_POST['id_proyecto']."'");

     $sql_update_partida = $conexion2 -> query("update maestro_partidas set p_monto = '".$_POST['monto_inicial']."' where id_proyecto = '".$_POST['id_proyecto']."' and id_padre IS NULL");


############################# Auditoria ##############################

                                            $tipo_operacion = 2;
                                            $comentario = "Actualizacion de Proyecto";

                                            $sql_insertar_auditoria = $conexion2 -> query("insert into auditoria_proyecto(aup_tipo_operacion,
                                                                                                                          aup_usua_log,
                                                                                                                          aup_comentario,
                                                                                                                          aup_id_proyecto,
                                                                                                                          aup_nombre_proyecto,
                                                                                                                          aup_tipo_proyecto,
                                                                                                                          aup_promotor,
                                                                                                                          aup_area,
                                                                                                                          aup_estado,
                                                                                                                          aup_resolucion_ambiental,
                                                                                                                          aup_id_empresa
                                                                                                                          )values(
                                                                                                                          '".$tipo_operacion."',
                                                                                                                          '".$_SESSION['session_gc']['usua_id']."',
                                                                                                                          '".$comentario."',
                                                                                                                          '".$_POST['id_proyecto']."',
                                                                                                                          '".$_POST['nombre_proyecto']."',
                                                                                                                          '".$_POST['tipo_proyecto']."',
                                                                                                                          '".$_POST['promotor']."',
                                                                                                                          '".$_POST['area']."',
                                                                                                                          '".$_POST['estado_proyecto']."',
                                                                                                                          '".$_POST['resolucion_ambiental']."',
                                                                                                                          '".$_POST['id_empresa']."')");
######################################################################
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
                Ver todos los proyectos <small>ver o editar proyectos.</small>

            </h1>
        </div>
                    <?php if(isset($sql_update_proyecto)){ ?>
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
            <h3 class="block-title">Tabla de proyectos del sistema <small>todos los proyectos</small></h3>
        </div>
        <div class="block-content">
            <!-- DataTables init on table by adding .js-dataTable-full class, functionality initialized in js/pages/base_tables_datatables.js -->
            <table class="table table-bordered table-striped js-dataTable-full">
                <thead>
                    <tr>
                        <th class="text-center">ID</th>
                        <th>NOMBRE DEL PROYECTO</th>
                        <th class="hidden-xs">TIPO DE PROYECTO</th>
                        <th class="hidden-xs">MONTO INICIAL</th>
                        <th class="hidden-xs" style="width: 15%;">ESTATUS DEL PROYECTO</th>
                        <th class="text-center" style="width: 10%;">EDITAR</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $todos_proyectos = todos_proyectos($conexion2); ?>
                    <?php while($lista_todos_proyectos = mysqli_fetch_array($todos_proyectos)){ ?>
                    <tr>
                        <td class="text-center"><?php echo $lista_todos_proyectos['id_proyecto']; ?></td>
                        <td class="font-w600"><?php echo $lista_todos_proyectos['proy_nombre_proyecto']; ?></td>
                        <td class="hidden-xs"><?php echo $lista_todos_proyectos['proy_tipo_proyecto']; ?></td>
                        <td class="hidden-xs"><?php echo number_format($lista_todos_proyectos['proy_monto_inicial'], 2, '.', ','); ?></td>
                        <td class="hidden-xs"><?php echo $lista_todos_proyectos['estado']; ?></td>
                        <td class="text-center">
                            <div class="btn-group">
                                <button class="btn btn-default" data-toggle="modal" data-target="#modal-popin<?php echo $lista_todos_proyectos['id_proyecto']; ?>" type="button"><i class="fa fa-pencil"></i></button>
                            </div>
                        </td>
                    </tr>

                            <div class="modal fade" id="modal-popin<?php echo $lista_todos_proyectos['id_proyecto']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
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
                                                                                    <input class="form-control" type="text" id="register1-username" name="id_proyecto" readonly="readonly" value="<?php echo $lista_todos_proyectos['id_proyecto']; ?>">
                                                                                </div>
                                                                            </div>

                                                                            <div class="form-group">
                                                                                <label class="col-xs-12" for="register1-username">NOMBRE DE EMPRESA</label>
                                                                                <div class="col-xs-12">

                                                                                    <select class="js-select2 form-control" id="val-select2" name="id_empresa" style="width: 100%;" data-placeholder="Seleccionar empresa" required="required">
                                                                                        <option></option>
                                                                                        <?php   $sql_empresas = todas_empresas_activas($conexion2); ?>
                                                                                        <?php   while($lista_empresas = mysqli_fetch_array($sql_empresas)){ ?>
                                                                                        <option value="<?php echo $lista_empresas['id_empresa']; ?>"
                                                                                                       <?php if($lista_todos_proyectos['id_empresa'] == $lista_empresas['id_empresa']){ echo 'selected'; } ?>
                                                                                         ><?php echo $lista_empresas['empre_nombre_comercial']; ?></option>
                                                                                        <?php } ?>
                                                                                    </select>

                                                                            </div>

                                                                            </div>

                                                                            <div class="form-group">
                                                                                <label class="col-xs-12" for="register1-username">NOMBRE DEL PROYECTO</label>
                                                                                <div class="col-xs-12">
                                                                                    <input class="form-control" type="text" id="register1-username" name="nombre_proyecto" value="<?php echo $lista_todos_proyectos['proy_nombre_proyecto']; ?>">
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="col-xs-12" for="register1-email">TIPO DE PROYECTO</label>
                                                                                <div class="col-xs-12">
                                                                                    <input class="form-control" type="text" id="register1-email" name="tipo_proyecto" value="<?php echo $lista_todos_proyectos['proy_tipo_proyecto']; ?>">
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="col-xs-12" for="register1-email">PROMOTOR</label>
                                                                                <div class="col-xs-12">
                                                                                    <input class="form-control" type="text" id="register1-email" name="promotor" value="<?php echo $lista_todos_proyectos['proy_promotor']; ?>">
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="col-xs-12" >AREA</label>
                                                                                <div class="col-xs-12">
                                                                                    <input class="form-control" type="text" id="register1-email" name="area" value="<?php echo $lista_todos_proyectos['proy_area']; ?>">
                                                                                </div>
                                                                            </div>

                                                                            <div class="form-group">
                                                                                <label class="col-xs-12" for="register1-email">RESOLUCION AMBIENTAL</label>
                                                                                <div class="col-xs-12">
                                                                                    <input class="form-control" type="text" name="resolucion_ambiental" value="<?php echo $lista_todos_proyectos['proy_resolucion_ambiental']; ?>" />
                                                                                </div>
                                                                            </div>

                                                                            <div class="form-group">
                                                                                <label class="col-xs-12" for="register1-email">MONTO INICIAL</label>
                                                                                <div class="col-xs-12">
                                                                                    <input class="form-control" type="text" name="monto_inicial" value="<?php echo number_format($lista_todos_proyectos['proy_monto_inicial'], 2, '.', ','); ?>" />
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
                                                                                    <label class="col-md-4 control-label" >Estado de empresa</label>
                                                                                    <div class="col-md-7">
                                                                                        <label class="rad-inline" for="example-inline-checkbox1">
                                                                                            <input type="radio" id="example-inline-checkbox1" name="estado_proyecto" value="1" <?php if($lista_todos_proyectos['proy_estado'] == 1){ echo 'checked';}  ?> > Activo
                                                                                        </label>
                                                                                        <label class="rad-inline" for="example-inline-checkbox1">
                                                                                            <input type="radio" id="example-inline-checkbox2" name="estado_proyecto" value="0" <?php if($lista_todos_proyectos['proy_estado'] == 0){ echo 'checked';}  ?> > Inactivo
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
