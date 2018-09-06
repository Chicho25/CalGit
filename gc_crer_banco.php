<?php if(!isset($_SESSION)){session_start();}?>
<?php require("conexion/conexion.php"); ?>
<?php require("funciones/funciones.php"); ?>
<?php if(isset($_SESSION['session_gc'])){ ?>
<?php $header_bar = 'base_header.php'; ?>
<?php $menu = true; ?>
<?php /* ################ AUDITORIA DE SEGUIMIENTO ############## */ ?>
<?php require("funciones/funciones_auditorias.php"); ?>
<?php $lugar_mapa = 8; ?>
<?php $dispositivo_acceso = obtener_dispositivo(); ?>
<?php insertar_log_seguimiento($conexion2, ObtenerIP(), $dispositivo_acceso, $lugar_mapa, $_SESSION['session_gc']['usua_id']); ?>
<?php /* ######################################################## */ ?>

<?php if(isset($_POST['confirmacion'])){$sql_insertar = mysqli_query($conexion2, "insert into maestro_bancos(banc_nombre_banco,
                                                                                                             banc_stado
                                                                                                             )values(
                                                                                                             '".strtoupper($_POST['nombre_banco'])."',
                                                                                                             1)");
############################# Auditoria ##############################

                                       $recuperar_id_bancos = $conexion2 -> query("SELECT MAX(id_bancos) AS id FROM maestro_bancos");
                                               while($id_banco = $recuperar_id_bancos -> fetch_array()){
                                                       $id_banco_recuperado = $id_banco['id'];}

                                       $tipo_operacion = 1;
                                       $comentario = "Registro de Banco";
                                       $sql_insertar_auditoria = $conexion2 -> query("insert into auditoria_banco(aub_tipo_operacion,
                                                                                                                  aub_usua_log,
                                                                                                                  aub_comentario,
                                                                                                                  aub_id_banco,
                                                                                                                  aub_banc_nombre_banco,
                                                                                                                  aub_stat
                                                                                                                  )values(
                                                                                                                  '".$tipo_operacion."',
                                                                                                                  '".$_SESSION['session_gc']['usua_id']."',
                                                                                                                  '".$comentario."',
                                                                                                                  '".$id_banco_recuperado."',
                                                                                                                  '".$_POST['nombre_banco']."',
                                                                                                                  1)");
#######################################################################

                                                                                                            }elseif(isset($_POST['nombre_banco'])){

                                                                                                              $sql_comprobar = $conexion2->query("select count(*) as contar
                                                                                                                                                  from
                                                                                                                                                  maestro_bancos
                                                                                                                                                  where
                                                                                                                                                  banc_nombre_banco = '".$_POST['nombre_banco']."'");
                                                                                                              while($c=$sql_comprobar->fetch_array()){
                                                                                                                    $r=$c['contar'];
                                                                                                              }

                                                                                                                              if($r>0){

                                                                                                                              $existe_registro = true; }else{

                                                                                                                            $session_bancos = array('nombre_banco'=>$_POST['nombre_banco']);

                                                                                                                        $_SESSION['session_bancos']=$session_bancos;}} ?>

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
    <div class="row">

      <?php if(isset($sql_insertar)){ ?>
              <div class="alert alert-success alert-dismissable">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <h3 class="font-w300 push-15">Registrado</h3>
                  <p>El <a class="alert-link" href="javascript:void(0)">Banco</a> registrado!</p>
              </div>
      <?php }elseif(isset($existe_registro)){ ?>
            <div class="alert alert-warning alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h3 class="font-w300 push-15">Ya existe el registro</h3>
                <p>Ya existe un banco con ese nombre</p>
            </div>
      <?php } ?>

        <div class="col-lg-12">
            <!-- Bootstrap Forms Validation -->
            <div class="block">
                <div class="block-header">
                    <ul class="block-options">
                        <li>

                        </li>
                    </ul>
                    <h3 class="block-title">Crear Banco</h3><small> Los campos con <span class="text-danger">*</span> son obligatorios</small>
                </div>
                <div class="block-content block-content-narrow">
                    <!-- jQuery Validation (.js-validation-bootstrap class is initialized in js/pages/base_forms_validation.js) -->
                    <!-- For more examples you can check out https://github.com/jzaefferer/jquery-validation -->
                    <form class="js-validation-bootstrap form-horizontal" action="" method="post">
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-username">Nombre del Banco<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <input class="form-control" autocomplete="off" type="text" id="val-username" name="nombre_banco" placeholder="Nombre del banco" required="required" value="<?php if(isset($_SESSION['session_bancos'])){ echo $_SESSION['session_bancos']['nombre_banco'];} ?>">
                            </div>
                        </div>
                        <?php /* ?>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-password">Estado del Banco<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <label class="rad-inline" for="example-inline-checkbox1">
                                    <input type="radio" id="example-inline-checkbox1" name="estado_banco" value="1" <?php if(isset($_SESSION['session_bancos'])){ if($_SESSION['session_bancos']['estado_banco'] == 1){ echo 'checked';} } ?> > Activo
                                </label>
                                <label class="rad-inline" for="example-inline-checkbox1">
                                    <input type="radio" id="example-inline-checkbox2" name="estado_banco" value="0" <?php if(isset($_SESSION['session_bancos'])){ if($_SESSION['session_bancos']['estado_banco'] == 0){ echo 'checked';} } ?> > Inactivo
                                </label>

                            </div>
                        </div>
                        <?php */ ?>


                        <?php if(isset($_SESSION['session_bancos'])){?> <input type="hidden" name="confirmacion" value="1"> <?php } ?>


                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <?php if(isset($sql_insertar)){ ?> El registro fue realizado, usted sera redirecionado <?php }elseif(isset($_SESSION['session_bancos'])){?> <button class="btn btn-sm btn-primary" type="submit">Confirmar Registro</button> <?php }else{ ?> <button class="btn btn-sm btn-primary" type="submit">Registrar</button> <?php } ?>
                            </div>

                        </div>
                    </form>
            </div>
            <!-- Bootstrap Forms Validation -->
        </div>
    </div>
</div>
</div>


<?php if(isset($sql_insertar)){

        unset($_SESSION['session_bancos']); ?>

        <!--<script type="text/javascript">
            function redireccionarPagina() {
              window.location = "gc_principal.php";
            }
            setTimeout("redireccionarPagina()", 5000);
        </script>-->

<?php } ?>

<?php require 'inc/views/base_footer.php'; ?>
<?php require 'inc/views/template_footer_start.php'; ?>

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
            window.location="salir.php";
        </script>

<?php } ?>
