<?php if(!isset($_SESSION)){session_start();}?>
<?php require("conexion/conexion.php"); ?>
<?php require("funciones/funciones.php"); ?>
<?php if(isset($_SESSION['session_gc'])){ ?>
<?php $header_bar = 'base_header.php'; ?>
<?php $menu = true; ?>
<?php /* ################ AUDITORIA DE SEGUIMIENTO ############## */ ?>
<?php require("funciones/funciones_auditorias.php"); ?>
<?php $lugar_mapa = 4; ?>
<?php $dispositivo_acceso = obtener_dispositivo(); ?>
<?php insertar_log_seguimiento($conexion2, ObtenerIP(), $dispositivo_acceso, $lugar_mapa, $_SESSION['session_gc']['usua_id']); ?>
<?php /* ######################################################## */ ?>
<?php if(isset($_POST['confirmacion'])){ $sql_insertar = mysqli_query($conexion2, "insert into maestro_empresa(empre_nombre_comercial,
                                                                                                                empre_razon_social,
                                                                                                                empre_ruc,
                                                                                                                empre_dv,
                                                                                                                empre_estado_empresa,
                                                                                                                empre_empresa_principal,
                                                                                                                empre_excenta_itbms,
                                                                                                                empre_email,
                                                                                                                empre_telefono
                                                                                                                )values(
                                                                                                                '".strtoupper($_POST['nombre_comercial'])."',
                                                                                                                '".strtoupper($_POST['razon_social'])."',
                                                                                                                '".strtoupper($_POST['ruc'])."',
                                                                                                                '".strtoupper($_POST['dv'])."',
                                                                                                                1,
                                                                                                                '".strtoupper($_POST['empresa_principal'])."',
                                                                                                                '".strtoupper($_POST['excenta_itbms'])."',
                                                                                                                '".strtoupper($_POST['email'])."',
                                                                                                                '".strtoupper($_POST['telefono'])."')");

############################# Auditoria ##############################

                                            $recuperar_id_empresa = $conexion2 -> query("select id_empresa from maestro_empresa where empre_ruc = '".$_POST['ruc']."'");
                                                    while($id_empresa = $recuperar_id_empresa -> fetch_array()){
                                                            $id_empresa_recuperado = $id_empresa['id_empresa'];}

                                            $tipo_operacion = 1;
                                            $comentario = "Registro de empresa";

                                            $sql_insertar_auditoria = $conexion2 -> query("insert into auditoria_empresa(aue_tipo_operacion,
                                                                                                                         aue_usua_log,
                                                                                                                         aue_comentario,
                                                                                                                         aue_id_empresa,
                                                                                                                         aue_empre_nombre_comercial,
                                                                                                                         aue_empre_razon_social,
                                                                                                                         aue_empre_ruc,
                                                                                                                         aue_empre_dv,
                                                                                                                         aue_empre_estado_empresa,
                                                                                                                         aue_empre_empresa_principal,
                                                                                                                         aue_empre_excenta_itbms,
                                                                                                                         aue_empre_email,
                                                                                                                         aue_empre_telefono
                                                                                                                         )values(
                                                                                                                         '".$tipo_operacion."',
                                                                                                                         '".$_SESSION['session_gc']['usua_id']."',
                                                                                                                         '".$comentario."',
                                                                                                                         '".$id_empresa_recuperado."',
                                                                                                                         '".$_POST['nombre_comercial']."',
                                                                                                                         '".$_POST['razon_social']."',
                                                                                                                         '".$_POST['ruc']."',
                                                                                                                         '".$_POST['dv']."',
                                                                                                                         1,
                                                                                                                         '".$_POST['empresa_principal']."',
                                                                                                                         '".$_POST['excenta_itbms']."',
                                                                                                                         '".$_POST['email']."',
                                                                                                                         '".$_POST['telefono']."')");
######################################################################

                                                                                                                                             }elseif(isset($_POST['nombre_comercial'],
                                                                                                                                                                $_POST['razon_social'],
                                                                                                                                                                        $_POST['ruc'],
                                                                                                                                                                        $_POST['dv'],
                                                                                                                                                                $_POST['empresa_principal'],
                                                                                                                                                            $_POST['excenta_itbms'])){

                                                                                                                        $sql_comprobar = $conexion2->query("select count(*) as contar
                                                                                                                                                            from
                                                                                                                                                            maestro_empresa
                                                                                                                                                            where
                                                                                                                                                            empre_ruc = '".$_POST['ruc']."'");
                                                                                                                        while($c=$sql_comprobar->fetch_array()){
                                                                                                                              $r=$c['contar'];
                                                                                                                        }

                                                                                                                                        if($r>0){

                                                                                                                                            $existe_registro = true; }else{


                                                                                                                        $session_empresa = array('nombre_comercial'=>$_POST['nombre_comercial'],
                                                                                                                                                        'razon_social'=>$_POST['razon_social'],
                                                                                                                                                            'ruc' =>$_POST['ruc'],
                                                                                                                                                                'dv'=>$_POST['dv'],
                                                                                                                                                            'telefono'=>$_POST['telefono'],
                                                                                                                                                        'empresa_principal'=>$_POST['empresa_principal'],
                                                                                                                                                    'excenta_itbms' =>$_POST['excenta_itbms'],
                                                                                                                                                'email' =>$_POST['email'] );

                                                                                                                        $_SESSION['session_empresa']=$session_empresa; }} ?>

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
                  <h3 class="font-w300 push-15">Registrada</h3>
                  <p>El <a class="alert-link" href="javascript:void(0)">La empresa</a> fue registrada!</p>
              </div>
      <?php }elseif(isset($existe_registro)){ ?>
            <div class="alert alert-warning alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h3 class="font-w300 push-15">Ya existe el registro</h3>
                <p>La empresa ya esta registrada</p>
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
                    <h3 class="block-title">Crear Empresa</h3><small> Los campos con <span class="text-danger">*</span> son obligatorios</small>
                </div>
                <div class="block-content block-content-narrow">
                    <!-- jQuery Validation (.js-validation-bootstrap class is initialized in js/pages/base_forms_validation.js) -->
                    <!-- For more examples you can check out https://github.com/jzaefferer/jquery-validation -->
                    <form class="js-validation-bootstrap form-horizontal" action="" method="post">
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-username">Nombre comercial<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <input class="form-control" autocomplete="off" type="text" id="val-username" name="nombre_comercial" placeholder="Nombre comercial" required="required" value="<?php if(isset( $_SESSION['session_empresa'])){ echo  $_SESSION['session_empresa']['nombre_comercial'];} ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-username">Razon social <span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <input class="form-control" autocomplete="off" type="text" id="val-username" name="razon_social" placeholder="Razon social" required="required" value="<?php if(isset( $_SESSION['session_empresa'])){ echo  $_SESSION['session_empresa']['razon_social'];} ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-email">RUC <span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <input class="form-control" autocomplete="off" type="text" name="ruc" placeholder="RUC" required="required" value="<?php if(isset( $_SESSION['session_empresa'])){ echo  $_SESSION['session_empresa']['ruc'];} ?>">
                            <div id="Info" style="margin-top: 10px;" ></div>
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-password">DV<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <input class="form-control" autocomplete="off" type="text" name="dv" placeholder="DV" required="required" value="<?php if(isset( $_SESSION['session_empresa'])){ echo  $_SESSION['session_empresa']['dv'];} ?>">
                            </div>
                        </div>
                        <?php /* ?>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-password">Estado de empresa<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <label class="rad-inline" for="example-inline-checkbox1">
                                    <input type="radio" id="example-inline-checkbox1" name="estado_empresa" value="1" <?php if(isset( $_SESSION['session_empresa'])){ if($_SESSION['session_empresa']['estado_empresa'] == 1){ echo 'checked';} } ?> > Activa
                                </label>
                                <label class="rad-inline" for="example-inline-checkbox1">
                                    <input type="radio" id="example-inline-checkbox2" name="estado_empresa" value="0" <?php if(isset( $_SESSION['session_empresa'])){ if($_SESSION['session_empresa']['estado_empresa'] == 0){ echo 'checked';} } ?> > Inactiva
                                </label>

                            </div>
                        </div>
                        <?php */ ?>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-password">Empresa princpal ?<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <label class="rad-inline" for="example-inline-checkbox1">
                                    <input type="radio" id="example-inline-checkbox1" name="empresa_principal" value="1" <?php if(isset( $_SESSION['session_empresa'])){ if($_SESSION['session_empresa']['empresa_principal'] == 1){ echo 'checked';} } ?> > Si
                                </label>
                                <label class="rad-inline" for="example-inline-checkbox1">
                                    <input type="radio" id="example-inline-checkbox2" name="empresa_principal" value="0" <?php if(isset( $_SESSION['session_empresa'])){ if($_SESSION['session_empresa']['empresa_principal'] == 0){ echo 'checked';} } ?> > No
                                </label>

                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-password">Excenta ITBMS ?<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <label class="rad-inline" for="example-inline-checkbox1">
                                    <input type="radio" id="example-inline-checkbox1" name="excenta_itbms" value="1" <?php if(isset( $_SESSION['session_empresa'])){ if($_SESSION['session_empresa']['excenta_itbms'] == 1){ echo 'checked';} } ?> > Si
                                </label>
                                <label class="rad-inline" for="example-inline-checkbox1">
                                    <input type="radio" id="example-inline-checkbox2" name="excenta_itbms" value="0" <?php if(isset( $_SESSION['session_empresa'])){ if($_SESSION['session_empresa']['excenta_itbms'] == 0){ echo 'checked';} } ?> > No
                                </label>

                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-confirm-password">Email</label>
                            <div class="col-md-7">
                                <input class="form-control" autocomplete="off" type="email" placeholder="Email" name="email" required="required" value="<?php if(isset( $_SESSION['session_empresa'])){ echo  $_SESSION['session_empresa']['email'];} ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-confirm-password">Telefono</label>
                            <div class="col-md-7">
                                <input class="form-control" autocomplete="off" type="number" placeholder="Telefono" name="telefono" required="required" value="<?php if(isset( $_SESSION['session_empresa'])){ echo  $_SESSION['session_empresa']['telefono'];} ?>">
                            </div>
                        </div>
                        <?php if(isset( $_SESSION['session_empresa'])){?> <input type="hidden" name="confirmacion" value="1"> <?php } ?>


                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <?php if(isset($sql_insertar)){ ?> El registro fue realizado, usted sera redirecionado <?php }elseif(isset( $_SESSION['session_empresa'])){?> <button class="btn btn-sm btn-primary" type="submit">Confirmar Registro</button> <?php }else{ ?> <button class="btn btn-sm btn-primary" type="submit">Registrar</button> <?php } ?>
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

        unset($_SESSION['session_empresa']); ?>

        <script type="text/javascript">
            function redireccionarPagina() {
              window.location = "gc_principal.php";
            }
            setTimeout("redireccionarPagina()", 5000);
        </script>

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
            window.location="index.php";
        </script>

<?php } ?>
