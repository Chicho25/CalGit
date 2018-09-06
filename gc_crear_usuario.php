<?php if(!isset($_SESSION)){session_start();}?>
<?php require("conexion/conexion.php"); ?>
<?php require("funciones/funciones.php"); ?>
<?php if(isset($_SESSION['session_gc'])){ ?>
<?php $header_bar = 'base_header.php'; ?>
<?php $menu = true; ?>
<?php /* ################ AUDITORIA DE SEGUIMIENTO ############## */ ?>
<?php require("funciones/funciones_auditorias.php"); ?>
<?php $lugar_mapa = 2; ?>
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

<?php $sql_insertar = mysqli_query($conexion2, "insert into usuarios(usua_usuario,
                                                                      usua_pass,
                                                                      usua_imagen_usuario,
                                                                      usua_fecha_registro,
                                                                      usua_stat,
                                                                      usua_nombre,
                                                                      usua_apellido)values(
                                                                      '".$_POST['email']."',
                                                                      '".$_POST['pass']."',
                                                                      '".$rutaDestino."',
                                                                      'NOW()',
                                                                      1,
                                                                      '".$_POST['nombre']."',
                                                                      '".$_POST['apellido']."')");

$sql_insertar_registro = mysqli_query($conexion2, "SELECT id_usuario from usuarios where usua_usuario = '".$_POST['email']."'"); ?>

<?php while($lista_ultimo_id = mysqli_fetch_array($sql_insertar_registro)){

            $id_usuario_recien_creado = $lista_ultimo_id['id_usuario'];

    } ?>
<?php foreach ($_POST['acceso'] as $value ) {

        $sql_insert = mysqli_query($conexion2, "insert into accesos(id_usuario_acceso, id_roll_acceso, stat, id_modulo_acceso)values('".$id_usuario_recien_creado."', '".$_POST['roll']."', 1, '".$value."')");
} ?>

<?php /* AUDITORIA */

      $observacion = "Registro de usuario";
      $tipo_operacion = 1;
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
                                                                           '".$id_usuario_recien_creado."',
                                                                           '".$tipo_operacion."',
                                                                           '".$observacion."',
                                                                           '".$_POST['email']."',
                                                                           '".$_POST['pass']."',
                                                                           '".$rutaDestino."',
                                                                           1,
                                                                           '".$_POST['nombre']."',
                                                                           '".$_POST['apellido']."')");

      foreach ($_POST['acceso'] as $value ) {

        $sql_insert = mysqli_query($conexion2, "insert into
                                                auditoria_usuario_acceso
                                                (auu_id_usuario_acceso,
                                                 auu_roll_acceso,
                                                 auu_stat,
                                                 auu_modulo_acceso,
                                                 auu_usua_log,
                                                 auu_tipo_operacion
                                                 )values(
                                                 '".$id_usuario_recien_creado."',
                                                 '".$_POST['roll']."',
                                                 1,
                                                 '".$value."',
                                                 '".$_SESSION['session_gc']['usua_id']."',
                                                 '".$tipo_operacion."')"); } ?>

<?php } ?>

<?php require 'inc/config.php'; ?>
<?php require 'inc/views/template_head_start.php'; ?>

<!-- Page JS Plugins CSS -->
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/select2/select2.min.css">
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/select2/select2-bootstrap.min.css">
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/sweetalert/sweetalert.min.css">

<?php require 'inc/views/template_head_end.php'; ?>
<?php require 'inc/views/base_head.php'; ?>

<div class="content content-narrow">
    <!-- Forms Row -->
    <?php if(isset($sql_insert)){ ?>
        <div class="col-lg-12">
            <!-- Success Alert -->
            <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h3 class="font-w300 push-15">Registrado</h3>
                <p>El <a class="alert-link" href="javascript:void(0)">Usuario</a> fue registrado!</p>
            </div>
            <!-- END Success Alert -->
        </div>
    <?php } ?>
    <div class="row">



        <div class="col-lg-12">
            <!-- Bootstrap Forms Validation -->
            <div class="block">
                <div class="block-header">
                    <ul class="block-options">
                        <li>

                        </li>
                    </ul>
                    <h3 class="block-title">Crear usuario</h3>
                </div>
                <div class="block-content block-content-narrow">
                    <!-- jQuery Validation (.js-validation-bootstrap class is initialized in js/pages/base_forms_validation.js) -->
                    <!-- For more examples you can check out https://github.com/jzaefferer/jquery-validation -->
                    <form class="js-validation-bootstrap form-horizontal" action="" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-username">Nombre <span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <input class="form-control" type="text" id="val-username" name="nombre" placeholder="Nombre del usuario" required="required">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-username">Apellido <span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <input class="form-control" type="text" id="val-username" name="apellido" placeholder="Apellido del usuario" required="required">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-email">Usuario / Email <span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <input class="form-control" type="text" id="email" name="email" placeholder="ingrese el email del usuario" required="required">
                            <div id="Info" style="margin-top: 10px;" ></div>
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-password">Password <span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <input class="form-control" type="password" id="val-password" name="pass" placeholder="Ingrese el password" required="required">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-confirm-password">Confirmar Password <span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <input class="form-control" type="password" id="val-confirm-password" name="val-confirm-password" placeholder="Confirme su password" required="required">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-confirm-password">Imagen <span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <input class="filestyle" data-buttonName="btn-primary" type="file" id="files" name="files" required="required">
                            </div>
                        </div>

                        <div class="form-group">
                             <label class="col-md-4 control-label" for="val-confirm-password"><span class="text-danger"></span></label>
                            <div class="col-md-7">

                                <output id="list"></output>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-select2">Seleccionar Roll</label>
                            <div class="col-md-7">
                                <select class="js-select2 form-control" id="val-select2" name="roll" style="width: 100%;" data-placeholder="Seleccionar el roll del usuario" required="required">
                                    <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                                    <?php   $sql_rolles = listado_roll($conexion2); ?>
                                    <?php   while($lista_rolles = mysqli_fetch_array($sql_rolles)){ ?>
                                    <option value="<?php echo $lista_rolles['id_roll']; ?>"><?php echo $lista_rolles['roll_nombre']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <h3 style="text-align: center;">Acceso permitidos para el usario</h3><br>

                        <?php $sql_accesos = crear_usuario_eccesos($conexion2); ?>
                        <?php while($lista_accesos = mysqli_fetch_array($sql_accesos)){?>

                        <div class="form-group">
                            <label class="col-md-4 control-label"><a data-toggle="modal" data-target="#modal-terms" href="#">Modulo <?php echo $lista_accesos['modulo_nombre']; ?></a> <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <label class="css-input css-checkbox css-checkbox-primary">
                                    <input type="checkbox" id="val-terms" name="acceso[]" value="<?php echo $lista_accesos['id_modulo']; ?>"><span></span> El usuario estara habilitado para el modulo <?php echo $lista_accesos['modulo_nombre']; ?>
                                </label>
                            </div>
                        </div>

                        <?php } ?>
                        <input type="hidden" name="acceso[]" value="7">

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button class="btn btn-sm btn-primary" type="submit">Registrar</button>
                            </div>

                        </div>
                    </form>
            </div>
            <!-- Bootstrap Forms Validation -->
        </div>
    </div>
</div>
</div>
        <script>
              function archivo(evt) {
                  var files = evt.target.files; // FileList object

                  // Obtenemos la imagen del campo "file".
                  for (var i = 0, f; f = files[i]; i++) {
                    //Solo admitimos imágenes.
                    if (!f.type.match('image.*')) {
                        continue;
                    }

                    var reader = new FileReader();

                    reader.onload = (function(theFile) {
                        return function(e) {
                          // Insertamos la imagen
                         document.getElementById("list").innerHTML = ['<img class="thumb" src="', e.target.result,'" title="', escape(theFile.name), '"/>'].join('');
                        };
                    })(f);

                    reader.readAsDataURL(f);
                  }
              }

              document.getElementById('files').addEventListener('change', archivo, false);
        </script>

<?php require 'inc/views/base_footer.php'; ?>
<?php require 'inc/views/template_footer_start.php'; ?>
<script type="text/javascript" src="bootstrap-filestyle.min.js"> </script>

<!-- Page JS Plugins -->
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
            window.location="index.php";
        </script>

<?php } ?>
