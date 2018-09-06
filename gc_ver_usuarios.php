<?php if(!isset($_SESSION)){session_start();}?>
<?php require("conexion/conexion.php"); ?>
<?php require("funciones/funciones.php"); ?>
<?php if(isset($_SESSION['session_gc'])){ ?>
<?php $header_bar = 'base_header.php'; ?>
<?php $menu = true; ?>
<?php /* ################ AUDITORIA DE SEGUIMIENTO ############## */ ?>
<?php require("funciones/funciones_auditorias.php"); ?>
<?php $lugar_mapa = 3; ?>
<?php $dispositivo_acceso = obtener_dispositivo(); ?>
<?php insertar_log_seguimiento($conexion2, ObtenerIP(), $dispositivo_acceso, $lugar_mapa, $_SESSION['session_gc']['usua_id']); ?>
<?php /* ######################################################## */ ?>
<?php if(isset($_POST['acceso'])){ ?>

<?php   if($_FILES["files"]['tmp_name'] != ''){

                $rutaEnServidor = "imagenes_gc";
                $ruraTemporal = $_FILES['files']['tmp_name'];
                $nombreImagen = $_FILES['files']['name'];

                $re_nombre = generarCodigo(7);

                $rutaDestino = $rutaEnServidor.'/'.$re_nombre.$nombreImagen;
                move_uploaded_file($ruraTemporal, $rutaDestino);
                $imagen = $rutaDestino;

                $imagen_final = $rutaDestino;
                $ancho_nuevo = 300;
                $alto_nuevo = 300;

                redim($imagen,$imagen_final,$ancho_nuevo,$alto_nuevo);
                }else{ $rutaDestino = '';} ?>

<?php if($_POST['stat'] == 'on'){ $stat = 1;}else{ $stat = 0;} ?>
<?php if($rutaDestino == ''){

            $sql_insertar = mysqli_query($conexion2, "update usuarios set usua_usuario = '".$_POST['email']."',
                                                                          usua_pass = '".$_POST['pass']."',
                                                                          usua_stat = '".$_POST['stat']."',
                                                                          usua_nombre = '".$_POST['nombre']."',
                                                                          usua_apellido = '".$_POST['apellido']."'
                                                                          where
                                                                          id_usuario = '".$_POST['id_usuario']."'");
            /* ############### AUDITORIA ################ */

                  $observacion = "Actualizacion de usuario";
                  $tipo_operacion = 2;
                  $sql_auditoria =  $conexion2 -> query("insert into auditoria_usuario(auu_usua_log,
                                                                                       auu_id_user,
                                                                                       auu_tipo_operacion,
                                                                                       auu_comentario,
                                                                                       auu_usua_usuario,
                                                                                       auu_usua_pass,
                                                                                       auu_usua_imagen_usuario,
                                                                                       auu_usua_stat,
                                                                                       auu_usua_nombre,
                                                                                       auu_usua_apellido
                                                                                       )values(
                                                                                       '".$_SESSION['session_gc']['usua_id']."',
                                                                                       '".$_POST['id_usuario']."',
                                                                                       '".$tipo_operacion."',
                                                                                       '".$observacion."',
                                                                                       '".$_POST['email']."',
                                                                                       '".$_POST['pass']."',
                                                                                       '".$_POST['foto_usuario']."',
                                                                                       '".$_POST['stat']."',
                                                                                       '".$_POST['nombre']."',
                                                                                       '".$_POST['apellido']."')");

            /* ########################################### */


        }else{

            $sql_insertar = mysqli_query($conexion2, "update usuarios set usua_usuario = '".$_POST['email']."',
                                                                             usua_pass = '".$_POST['pass']."',
                                                                             usua_imagen_usuario = '".$rutaDestino."',
                                                                             usua_stat = '".$_POST['stat']."',
                                                                             usua_nombre = '".$_POST['nombre']."',
                                                                             usua_apellido = '".$_POST['apellido']."'
                                                                             where
                                                                             id_usuario = '".$_POST['id_usuario']."'");

            /* ############### AUDITORIA ################ */

                  $observacion = "Actualizacion de usuario";
                  $tipo_operacion = 2;
                  $sql_auditoria =  $conexion2 -> query("insert into auditoria_usuario(auu_usua_log,
                                                                                       auu_id_user,
                                                                                       auu_tipo_operacion,
                                                                                       auu_comentario,
                                                                                       auu_usua_usuario,
                                                                                       auu_usua_pass,
                                                                                       auu_usua_imagen_usuario,
                                                                                       auu_usua_stat,
                                                                                       auu_usua_nombre,
                                                                                       auu_usua_apellido
                                                                                       )values(
                                                                                       '".$_SESSION['session_gc']['usua_id']."',
                                                                                       '".$_POST['id_usuario']."',
                                                                                       '".$tipo_operacion."',
                                                                                       '".$observacion."',
                                                                                       '".$_POST['email']."',
                                                                                       '".$_POST['pass']."',
                                                                                       '".$rutaDestino."',
                                                                                       '".$_POST['stat']."''',
                                                                                       '".$_POST['nombre']."',
                                                                                       '".$_POST['apellido']."')");

            /* ########################################### */



                                                                              }

$sql_borrar_registros_accesos = mysqli_query($conexion2, "delete from accesos where id_usuario_acceso = '".$_POST['id_usuario']."'"); ?>

<?php foreach ( $_POST['acceso'] as $value ) {

        $sql_insert = mysqli_query($conexion2, "insert into accesos(id_usuario_acceso, id_roll_acceso, stat, id_modulo_acceso)values('".$_POST['id_usuario']."', '".$_POST['roll']."', 1, '".$value."')");
} ?>

<?php   /* ############### AUDITORIA ################ */  ?>
<?php   foreach ($_POST['acceso'] as $value ) {

        $sql_insert = mysqli_query($conexion2, "insert into
                                                auditoria_usuario_acceso
                                                (auu_id_usuario_acceso,
                                                 auu_roll_acceso,
                                                 auu_stat,
                                                 auu_modulo_acceso,
                                                 auu_usua_log,
                                                 auu_tipo_operacion
                                                 )values(
                                                 '".$_POST['id_usuario']."',
                                                 '".$_POST['roll']."',
                                                 1,
                                                 '".$value."',
                                                 '".$_SESSION['session_gc']['usua_id']."',
                                                 '".$tipo_operacion."')"); } ?>

<?php   /* ########################################### */  ?>

<?php } ?>


<?php require 'inc/config.php'; ?>
<?php require 'inc/views/template_head_start.php'; ?>
<!-- Page JS Plugins CSS -->
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/datatables/jquery.dataTables.min.css">
<?php require 'inc/views/template_head_end.php'; ?>
<?php require 'inc/views/base_head.php'; ?>



<!-- Page Header -->
<div class="content bg-gray-lighter">
    <div class="row items-push">


            <?php if(isset($sql_insertar)){ ?>
                <div class="col-sm-3 col-lg-3" style="position: absolute; right: 0px;">
                    <!-- Success Alert -->
                    <div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h3 class="font-w300 push-15">Registrado</h3>
                        <p>El <a class="alert-link" href="javascript:void(0)">Usuario</a> fue registrado!</p>
                    </div>
                    <!-- END Success Alert -->
                </div>
            <?php } ?>



        <div class="col-sm-7">
            <h1 class="page-heading">
                Ver todos los usuarios <small>ver o editar usuarios.</small>
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
            <h3 class="block-title">Tabla de usuarios del sistema <small>todos los usuarios</small></h3>
        </div>
        <div class="block-content">
            <!-- DataTables init on table by adding .js-dataTable-full class, functionality initialized in js/pages/base_tables_datatables.js -->
            <table class="table table-bordered table-striped js-dataTable-full">
                <thead>
                    <tr>
                        <th class="text-center">Imagen</th>
                        <th>Nombre</th>
                        <th class="hidden-xs">Email</th>
                        <th class="hidden-xs" style="width: 15%;">Roll</th>
                        <th class="text-center" style="width: 10%;">Editar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $todos_usuarios = todos_usuarios($conexion2); ?>
                    <?php while($lista_todos_usuarios = mysqli_fetch_array($todos_usuarios)){ ?>
                    <tr>
                        <td class="text-center"><img src="<?php echo $lista_todos_usuarios['usua_imagen_usuario']; ?>" width = "40"/></td>
                        <td class="font-w600"><?php echo $lista_todos_usuarios['usua_nombre'].' '.$lista_todos_usuarios['usua_apellido']; ?></td>
                        <td class="hidden-xs"><?php echo $lista_todos_usuarios['usua_usuario']; ?></td>
                        <td class="hidden-xs"><?php echo $lista_todos_usuarios['roll_nombre']; ?></td>
                        <td class="text-center">
                            <div class="btn-group">
                                <button class="btn btn-default" data-toggle="modal" data-target="#modal-popin<?php echo $lista_todos_usuarios['id_usuario']; ?>" type="button"><i class="fa fa-pencil"></i></button>
                            </div>
                        </td>
                    </tr>

                            <div class="modal fade" id="modal-popin<?php echo $lista_todos_usuarios['id_usuario']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
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
                                                                                <label class="col-xs-12" for="register1-username">Nombre</label>
                                                                                <div class="col-xs-12">
                                                                                    <input class="form-control" type="text" id="register1-username" name="nombre" value="<?php echo $lista_todos_usuarios['usua_nombre']; ?>">
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="col-xs-12" for="register1-username">Apellido</label>
                                                                                <div class="col-xs-12">
                                                                                    <input class="form-control" type="text" id="register1-username" name="apellido" value="<?php echo $lista_todos_usuarios['usua_apellido']; ?>">
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="col-xs-12" for="register1-email">Email</label>
                                                                                <div class="col-xs-12">
                                                                                    <input class="form-control" type="email" id="register1-email" name="email" value="<?php echo $lista_todos_usuarios['usua_usuario']; ?>">
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="col-xs-12" for="register1-email">Fecha de registro</label>
                                                                                <div class="col-xs-12">
                                                                                    <input class="form-control" readonly="readonly" type="text" id="register1-email" name="fecha_registro" value="<?php echo $lista_todos_usuarios['usua_fecha_registro']; ?>">
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="col-xs-12" for="register1-email">Password</label>
                                                                                <div class="col-xs-12">
                                                                                    <input class="form-control" type="text" id="register1-email" name="pass" value="<?php echo $lista_todos_usuarios['usua_pass']; ?>">
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="col-xs-12" for="register1-email">Imagen</label>
                                                                                <div class="col-xs-12">
                                                                                    <img width="200" height="200" style="padding-bottom: 5px;" src="<?php echo $lista_todos_usuarios['usua_imagen_usuario']; ?>">

                                                                                    <input type="file" class="filestyle" data-buttonName="btn-primary"  name="files">

                                                                                </div>

                                                                            </div>

                                                                            <input type="hidden" value="<?php echo $lista_todos_usuarios['usua_imagen_usuario']; ?>" name="foto_usuario">

                                                                            <div class="form-group">
                                                                                <label class="col-xs-12" for="register1-password2">Roll</label>
                                                                                <div class="col-xs-12">
                                                                                    <select class="form-control" id="contact1-subject" name="roll" size="1">
                                                                                        <option value="">Seleccionar</option>
                                                                                        <?php $listado_roles = listado_roll($conexion2); ?>
                                                                                        <?php while($lisa_roles = mysqli_fetch_array($listado_roles)){ ?>
                                                                                        <option value="<?php echo $lisa_roles['id_roll']; ?>"
                                                                                        <?php if($lista_todos_usuarios['id_roll'] == $lisa_roles['id_roll'])

                                                                                        { echo 'selected';}?> > <?php echo $lisa_roles['roll_nombre']; ?></option> <?php } ?>

                                                                                    </select>
                                                                                </div>
                                                                            </div>

                                                                             <div class="form-group">
                                                                                <label class="col-xs-12" for="register1-email" >Status</label>
                                                                                <div class="col-xs-12">
                                                                                    <label class="rad-inline" for="example-inline-checkbox1">
                                                                                        <input type="radio" id="example-inline-checkbox1" name="stat" value="1" <?php if($lista_todos_usuarios['usua_stat'] == 1){ echo 'checked';}  ?> > Activo
                                                                                    </label>
                                                                                    <label class="rad-inline" for="example-inline-checkbox1">
                                                                                        <input type="radio" id="example-inline-checkbox2" name="stat" value="0" <?php if($lista_todos_usuarios['usua_stat'] == 0){ echo 'checked';}  ?> > Inactivo
                                                                                    </label>
                                                                                </div>
                                                                            </div>

                                                                            <div class="form-group">
                                                                                <label class="col-xs-12" for="register1-email">Accesos permitidos</label>
                                                                                <div class="col-xs-12">

                                                                                <?php $sql_accesos = crear_usuario_eccesos($conexion2); ?>
                                                                                <?php while($lista_accesos = mysqli_fetch_array($sql_accesos)){?>

                                                                                <div class="form-group">

                                                                                    <div class="col-md-8">
                                                                                        <label class="css-input css-checkbox css-checkbox-primary">
                                                                                            <input type="checkbox" id="val-terms" name="acceso[]" <?php $check = permisos_accesos($conexion2, $lista_todos_usuarios['id_usuario'], $lista_accesos['id_modulo'], $lista_todos_usuarios['id_roll']); if($check == true){ echo 'checked';} ?> value="<?php echo $lista_accesos['id_modulo']; ?>"><span></span> <?php echo $lista_accesos['modulo_nombre']; ?>
                                                                                        </label>
                                                                                    </div>
                                                                                </div>


                                                                                <?php } ?>
                                                                                <input type="hidden" name="acceso[]" value="7">
                                                                                <input type="hidden" value="<?php echo $lista_todos_usuarios['id_usuario']; ?>" name="id_usuario"/>

                                                                                </div>
                                                                            </div>


                                                                    </div>
                                                                </div>


                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-sm btn-default" type="button" data-dismiss="modal">Cancelar</button>

                                            <button class="btn btn-sm btn-default" type="submit" >Guardar cambios</button>
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

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>





<!-- Page JS Code -->
<script src="<?php echo $one->assets_folder; ?>/js/pages/base_tables_datatables.js"></script>



<?php require 'inc/views/template_footer_end.php'; ?>
<?php }else{ ?>

        <script type="text/javascript">
            window.location="index.php";
        </script>

<?php } ?>
