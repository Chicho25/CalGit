<?php if(!isset($_SESSION)){session_start();}?>
<?php include_once('conexion/conexion.php'); ?>
<?php include_once('funciones/funciones.php'); ?>
<?php if(isset($_POST['passUno'], $_POST['passDos'], $_SESSION['id_usuario'])){ ?>

<?php  restablecer_password($conexion2, $_POST['passDos'], $_SESSION['id_usuario']); ?>
<?php  $confirmacion = restablecer_password($conexion2, $_POST['passDos'], $_SESSION['id_usuario']); ?>
<?php  if($confirmacion == true){

            $asunto = 'Password restablecida';
            $directorio = 1;
            $pass = $_POST['passDos'];

            /*envio_email($conexion2, $pass, $_POST['email'], $_POST['nombre'], $_POST['apellido'], $asunto, $directorio, $_SESSION['id_usuario']);*/

                $mensajeMail = 'Su nueva password es: "'.$pass.'" ingrese nuevamente a http://198.211.116.113/grupo_calpe_mysql/src/index.php';

                 envio_email($conexion2, $pass, $_POST['email'], $nombre, $apellido, $asunto, $directorio, $id_usuario);

                mail($_POST['email'], $asunto, $mensajeMail);

} } ?>

<?php if(isset($_GET['id_usuario'])){$_SESSION['id_usuario'] = $_REQUEST['id_usuario'];} ?>

<?php if(isset($_SESSION['id_usuario'])){

           $sql_crear_pass = usuario_restablecer_pass($conexion2, $_SESSION['id_usuario']);


                while($lista_crear_pass = mysqli_fetch_array($sql_crear_pass)){  ?>


<?php $header_bar = ''; ?>
<?php $menu = false; ?>
<?php require 'inc/config.php'; ?>
<?php require 'inc/views/template_head_start.php'; ?>
<?php require 'inc/views/template_head_end.php'; ?>
<?php require 'inc/views/base_head.php'; ?>

<!-- Page Header -->
<div class="content bg-gray-lighter">
    <div class="row items-push">
        <div class="col-sm-7">
            <h1 class="page-heading">
                Restablecer Password <small>Restablesca su password para poder acceder al sistema.</small>
            </h1>
        </div>
        <div class="col-sm-5 text-right hidden-xs">
            <ol class="breadcrumb push-10-t">
                <li>Grupo Calpes</li>
                <li><a class="link-effect" href="#">V- 1.0</a></li>
            </ol>
        </div>
    </div>
</div>
<!-- END Page Header -->

<!-- Page Content -->
<div class="content content-narrow">
    <!-- Lock Forms -->
    <div class="row">
        <div class="col-lg-4"></div>
        <div class="col-lg-4">
            <!-- Bootstrap Lock -->
            <div class="block block-themed">
                <div class="block-header bg-primary">
                    <ul class="block-options">
                        <li>
                            <button type="button" data-toggle="block-option" data-action="refresh_toggle" data-action-mode="demo"></button>
                        </li>
                        <li>
                            <button type="button" data-toggle="block-option" data-action="content_toggle"></button>
                        </li>
                    </ul>
                    <h3 class="block-title"><?php echo $lista_crear_pass['usua_nombre'].' '.$lista_crear_pass['usua_apellido']; ?></h3>
                </div>
                <div class="block-content">
                    <div class="text-center push-10-t push-30">
                        <img src="<?php echo $lista_crear_pass["usua_imagen_usuario"]; ?>" class="img-avatar img-avatar96"/>
                    </div>
                    <form class="form-horizontal" action="" method="post">
                        <div class="form-group">
                            <label class="col-xs-12" for="lock1-password">Nueva Password</label>
                            <div class="col-xs-12">
                                <input id="pass_1" class="form-control" type="password" name="passUno" placeholder="Ingresa tu nueva password.." >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-12" for="lock1-password">Confirmar Nueva Password</label>
                            <div class="col-xs-12">
                                <input id="pass_2" class="form-control" type="password" name="passDos" placeholder="Confirma tu nueva password.." >
                            </div>
                        </div>
                        <div class="form-group">
                           <?php if(isset($asunto)){ echo 'Password cambiada presione <a href="http://grupocalpe.canalzon.com/grupo_calpe_mysql/src/index.php">aqui</a> para entrar al sistema';}else{ ?>
                            <div class="col-xs-12">

                                <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-unlock push-5-r"></i> Restablecer Password</button>
                            </div>
                            <?php } ?>
                        </div>
                        <input type="hidden" name="email" value="<?php echo $lista_crear_pass['usua_usuario']; ?>"  >
                        <input type="hidden" name="nombre" value="<?php echo $lista_crear_pass['usua_nombre']; ?>"  >
                        <input type="hidden" name="apellido" value="<?php echo $lista_crear_pass['usua_apellido']; ?>"  >
                    </form>
                </div>
            </div>
            <!-- END Bootstrap Lock -->
        </div>

    </div>
    <!-- END Lock Forms -->
</div>

    <script type="text/javascript" />
    $(function(){

        $('#pass_1').keyup(function(){
            var _this = $('#pass_1');
            var pass_1 = $('#pass_1').val();
            _this.attr('style', 'background:white');
            if(pass_1.charAt(0) == ' '){
                _this.attr('style', 'background:#FF4A4A');
            }

            if(_this.val() == ''){
                _this.attr('style', 'background:#FF4A4A');
            }
        });

        $('#pass_2').keyup(function(){
            var pass_1 = $('#pass_1').val();
            var pass_2 = $('#pass_2').val();
            var _this = $('#pass_2');
            _this.attr('style', 'background:#04B404');
            if(pass_1 != pass_2 && pass_2 != ''){
                _this.attr('style', 'background:#FF4A4A');
            }
        });

    });
    </script>

<?php require 'inc/views/base_footer.php'; ?>
<?php require 'inc/views/template_footer_start.php'; ?>
<?php require 'inc/views/template_footer_end.php'; ?>

<?php } }else{ echo 'no se ha seleccionado un link';} ?>
