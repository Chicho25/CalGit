<?php $header_bar = ''; ?>
<?php $menu = false; ?>
<?php include_once('conexion/conexion.php'); ?>
<?php include_once('funciones/funciones.php'); ?>
<?php   if(isset($_POST['email'])){ ?>
<?php       if($_POST['email']<>''){ ?>
<?php           $email = validar_email($conexion2, $_POST['email']); ?>
<?php           if($email >= 1){ $mensaje = 'Se ha enviado un email a su direccion de correo electronico, por favor ingrese a su correo electronico para reestablecer su password';

                                        $datos_usuario = usuario_restablecer_pass($conexion2, $_POST['email']);

                                            while($lista_datos_usuario = mysqli_fetch_array($datos_usuario)){

                                                    $pass = 2;
                                                    $id_usuario = $lista_datos_usuario['id_usuario'];
                                                    $nombre = $lista_datos_usuario['usua_nombre'];
                                                    $apellido = $lista_datos_usuario['usua_apellido'];
                                                    $stat = $lista_datos_usuario['usua_stat'];
                                            }

                                                $asunto = 'Reestablecer Password';
                                                $directorio = 'gc_formulario_restablecer_password.php';

                                                $mensajeMail = 'http://198.211.116.113/grupo_calpe_mysql/src/'.$directorio.'?id_usuario='.$id_usuario.'';

                                                 envio_email($conexion2, $pass, $_POST['email'], $nombre, $apellido, $asunto, $directorio, $id_usuario);

                                                 /*mail($_POST['email'], $asunto, $mensajeMail); */

                                 }else{  ?>
<?php                            $mensaje = 'La direccion email ingresada no se ecuentra registrada en nuestras bases de datos, contacte con el administrador del sistema'; } } } ?>


<?php require 'inc/config.php'; ?>
<?php require 'inc/views/template_head_start.php'; ?>
<?php require 'inc/views/template_head_end.php'; ?>

<!-- Reminder Content -->
<div class="content overflow-hidden">
    <div class="row">
        <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
            <!-- Reminder Block -->
            <div class="block block-themed animated fadeIn">
                <div class="block-header bg-primary">
                    <ul class="block-options">
                        <li>
                            <a href="index.php" data-toggle="tooltip" data-placement="left" title="LOGIN"><i class="si si-login"></i></a>
                        </li>
                    </ul>
                    <h3 class="block-title">Restablecer Password</h3>
                </div>
                <div class="block-content block-content-full block-content-narrow">
                    <!-- Reminder Title -->
                    <h1 class="h2 font-w600 push-30-t push-5"><?php echo $one->name; ?></h1>
                    <p>Por favor introdusca su correo electronico para restablecer su password</p>
                    <!-- END Reminder Title -->

                    <!-- Reminder Form -->
                    <!-- jQuery Validation (.js-validation-reminder class is initialized in js/pages/base_pages_reminder.js) -->
                    <!-- For more examples you can check out https://github.com/jzaefferer/jquery-validation -->
                    <form class="js-validation-reminder form-horizontal push-30-t push-50" action="" method="post">
                        <div class="form-group">
                            <div class="col-xs-12">
                                <div class="form-material form-material-primary floating">
                                    <input class="form-control" type="email" id="reminder-email" name="email">
                                    <label for="reminder-email">Email</label>
                                    <br>
                                    <em><?php if(isset($mensaje)){ echo $mensaje; } ?></em>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12 col-sm-6 col-md-5">
                                <button class="btn btn-block btn-primary" type="submit"><i class="si si-envelope-open pull-right"></i> Enviar Mail</button>
                            </div>
                        </div>
                    </form>
                    <!-- END Reminder Form -->
                </div>
            </div>
            <!-- END Reminder Block -->
        </div>
    </div>
</div>
<!-- END Reminder Content -->

<!-- Reminder Footer -->
<div class="push-10-t text-center animated fadeInUp">
    <small class="text-muted font-w600"><span class="js-year-copy"></span> &copy; <?php echo $one->name . ' ' . $one->version; ?></small>
</div>
<!-- END Reminder Footer -->

<?php require 'inc/views/template_footer_start.php'; ?>

<!-- Page JS Plugins -->
<script src="<?php echo $one->assets_folder; ?>/js/plugins/jquery-validation/jquery.validate.min.js"></script>

<!-- Page JS Code -->
<script src="<?php echo $one->assets_folder; ?>/js/pages/base_pages_reminder.js"></script>

<?php require 'inc/views/template_footer_end.php'; ?>
