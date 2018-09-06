<?php if(!isset($_SESSION)){session_start();}?>
<?php require("conexion/conexion.php"); ?>
<?php require("funciones/funciones.php"); ?>
<?php if(isset($_SESSION['session_gc'])){ ?>
<?php $header_bar = 'base_header.php'; ?>
<?php $menu = true; ?>
<?php /* ################ AUDITORIA DE SEGUIMIENTO ############## */ ?>
<?php require("funciones/funciones_auditorias.php"); ?>
<?php $lugar_mapa = 10; ?>
<?php $dispositivo_acceso = obtener_dispositivo(); ?>
<?php insertar_log_seguimiento($conexion2, ObtenerIP(), $dispositivo_acceso, $lugar_mapa, $_SESSION['session_gc']['usua_id']); ?>
<?php /* ######################################################## */ ?>

<?php if(isset($_POST['confirmacion'])){ $sql_insertar = mysqli_query($conexion2, "insert into cuentas_bancarias(cta_id_banco,
                                                                                                                 cta_numero_cuenta,
                                                                                                                 cta_estado,
                                                                                                                 cta_predeterminada,
                                                                                                                 cta_tipo_cuenta,
                                                                                                                 cta_id_empresa,
                                                                                                                 cta_descripcion
                                                                                                                 )values(
                                                                                                                '".$_POST['id_banco']."',
                                                                                                                '".$_POST['numero_cuenta']."',
                                                                                                                1,
                                                                                                                '".$_POST['predeterminada']."',
                                                                                                                '".$_POST['tipo_cuenta']."',
                                                                                                                '".$_POST['id_empresa']."',
                                                                                                                '".strtoupper($_POST['descripcion'])."')");

                                          /* Aunditoria */
                                          $tipo_operacion = 1;
                                          $comentario = "Registro de Cuenta bancaria";
                                          $sql_insertar_auditoria = $conexion2 -> query("INSERT INTO auditoria_cuenta_bancaria(aucb_tipo_operacion,
                                                                                                                               aucb_usua_log,
                                                                                                                               aucb_comentarios,
                                                                                                                               aucb_cta_id_banco,
                                                                                                                               aucb_cta_numero_cuenta,
                                                                                                                               aucb_cta_estado,
                                                                                                                               aucb_cta_predeterminada,
                                                                                                                               aucb_cta_tipo_cuenta,
                                                                                                                               aucb_cta_id_empresa,
                                                                                                                               aucb_cta_descripcion
                                                                                                                              )VALUES(
                                                                                                                               '".$tipo_operacion."',
                                                                                                                               '".$_SESSION['session_gc']['usua_id']."',
                                                                                                                               '".$comentario."',
                                                                                                                               '".$_POST['id_banco']."',
                                                                                                                               '".$_POST['numero_cuenta']."',
                                                                                                                               1,
                                                                                                                               '".$_POST['predeterminada']."',
                                                                                                                               '".$_POST['tipo_cuenta']."',
                                                                                                                               '".$_POST['id_empresa']."',
                                                                                                                               '".strtoupper($_POST['descripcion'])."')");

                                                                                                              }elseif(isset($_POST['id_banco'],
                                                                                                                                $_POST['numero_cuenta'],
                                                                                                                                    $_POST['predeterminada'],
                                                                                                                                $_POST['tipo_cuenta'],
                                                                                                                            $_POST['id_empresa'],
                                                                                                                                $_POST['descripcion'])){

                                                                                                                        $sql_comprobar = $conexion2->query("select count(*) as contar
                                                                                                                                                            from
                                                                                                                                                            cuentas_bancarias
                                                                                                                                                            where
                                                                                                                                                            cta_numero_cuenta = '".$_POST['numero_cuenta']."'");
                                                                                                                        while($c=$sql_comprobar->fetch_array()){
                                                                                                                              $r=$c['contar'];
                                                                                                                        }

                                                                                                                        if($r>0){

                                                                                                                        $existe_registro = true; }else{


                                                                                                                        $session_cta = array('id_banco'=>$_POST['id_banco'],
                                                                                                                                                'numero_cuenta'=>$_POST['numero_cuenta'],
                                                                                                                                                        'predeterminada' =>$_POST['predeterminada'],
                                                                                                                                                    'tipo_cuenta'=>$_POST['tipo_cuenta'],
                                                                                                                                                'id_empresa'=>$_POST['id_empresa'],
                                                                                                                                            'descripcion'=>$_POST['descripcion']);

                                                                                                                        $_SESSION['session_cta']=$session_cta; }} ?>

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
                  <p>La <a class="alert-link" href="javascript:void(0)">Cuenta Bancaria</a> registrada!</p>
              </div>
      <?php }elseif(isset($existe_registro)){ ?>
            <div class="alert alert-warning alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h3 class="font-w300 push-15">Ya existe el registro</h3>
                <p>Ya existe una cuenta bancaria con ese numero</p>
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
                    <h3 class="block-title">Registrar cuenta</h3><small> Los campos con <span class="text-danger">*</span> son obligatorios</small>
                </div>
                <div class="block-content block-content-narrow">
                    <!-- jQuery Validation (.js-validation-bootstrap class is initialized in js/pages/base_forms_validation.js) -->
                    <!-- For more examples you can check out https://github.com/jzaefferer/jquery-validation -->
                    <form class="js-validation-bootstrap form-horizontal" action="" method="post">
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-username">Nombre de la empresa<span class="text-danger">*</span></label>
                            <div class="col-md-7">

                                <select class="js-select2 form-control" id="val-select2" name="id_empresa" style="width: 100%;" data-placeholder="Seleccionar empresa" required="required">
                                    <option></option>
                                    <?php   $sql_empresas = todas_empresas_activas($conexion2); ?>
                                    <?php   while($lista_empresas = mysqli_fetch_array($sql_empresas)){ ?>
                                    <option value="<?php echo $lista_empresas['id_empresa']; ?>"
                                                   <?php if(isset( $_SESSION['session_cta'])){ if($_SESSION['session_cta']['id_empresa'] == $lista_empresas['id_empresa']){ echo 'selected'; }} ?>
                                     ><?php echo $lista_empresas['empre_nombre_comercial']; ?></option>
                                    <?php } ?>
                                </select>

                            </div>

                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-username">Nombre del Banco <span class="text-danger">*</span></label>
                            <div class="col-md-7">

                                <select class="js-select2 form-control" id="val-select2" name="id_banco" style="width: 100%;" data-placeholder="Seleccionar banco" required="required">
                                    <option></option>
                                    <?php   $sql_bancos = todos_bancos_activos($conexion2); ?>
                                    <?php   while($lista_bancos = mysqli_fetch_array($sql_bancos)){ ?>
                                    <option value="<?php echo $lista_bancos['id_bancos']; ?>"
                                                   <?php if(isset( $_SESSION['session_cta'])){ if($_SESSION['session_cta']['id_banco'] == $lista_bancos['id_bancos']){ echo 'selected'; }} ?>
                                     ><?php echo $lista_bancos['banc_nombre_banco']; ?></option>
                                    <?php } ?>
                                </select>


                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-email">Numero de cuenta <span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <input class="form-control" autocomplete="off" type="number"  name="numero_cuenta" placeholder="Numero de cuenta" required="required" value="<?php if(isset( $_SESSION['session_cta'])){ echo  $_SESSION['session_cta']['numero_cuenta'];} ?>">
                            <div id="Info" style="margin-top: 10px;" ></div>
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-password">Tipo de cuenta<span class="text-danger">*</span></label>
                            <div class="col-md-7">

                                <select class="js-select2 form-control" id="val-select2" name="tipo_cuenta" style="width: 100%;" data-placeholder="Tipo de cuenta" required="required">
                                    <option></option>
                                    <?php   $sql_tipo_cuenta = tipo_cuenta($conexion2); ?>
                                    <?php   while($lista_tipo_cuenta = mysqli_fetch_array($sql_tipo_cuenta)){ ?>
                                    <option value="<?php echo $lista_tipo_cuenta['id_tipo_cuenta']; ?>"
                                                   <?php if(isset( $_SESSION['session_cta'])){ if($_SESSION['session_cta']['tipo_cuenta'] == $lista_tipo_cuenta['id_tipo_cuenta']){ echo 'selected'; }} ?>
                                     ><?php echo $lista_tipo_cuenta['tdc_nombre']; ?></option>
                                    <?php } ?>
                                </select>

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-email">Descripcion <span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <textarea class="form-control" name="descripcion" required="required" ><?php if(isset( $_SESSION['session_cta'])){ echo  $_SESSION['session_cta']['descripcion'];} ?></textarea>
                            <div id="Info" style="margin-top: 10px;" ></div>
                            </div>

                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-password">Predeterminada?<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <label class="rad-inline" for="example-inline-checkbox1">
                                    <input type="radio" id="example-inline-checkbox1" name="predeterminada" value="1" <?php if(isset( $_SESSION['session_cta'])){ if($_SESSION['session_cta']['predeterminada'] == 1){ echo 'checked';} } ?> > Si
                                </label>
                                <label class="rad-inline" for="example-inline-checkbox1">
                                    <input type="radio" id="example-inline-checkbox2" name="predeterminada" value="0" <?php if(isset( $_SESSION['session_cta'])){ if($_SESSION['session_cta']['predeterminada'] == 0){ echo 'checked';} } ?> > No
                                </label>

                            </div>
                        </div>
                        <?php /* ?>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-password">Estado de la cuenta<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <label class="rad-inline" for="example-inline-checkbox1">
                                    <input type="radio" id="example-inline-checkbox1" name="estado" value="1" <?php if(isset( $_SESSION['session_cta'])){ if($_SESSION['session_cta']['estado'] == 1){ echo 'checked';} } ?> > Activo
                                </label>
                                <label class="rad-inline" for="example-inline-checkbox1">
                                    <input type="radio" id="example-inline-checkbox2" name="estado" value="0" <?php if(isset( $_SESSION['session_cta'])){ if($_SESSION['session_cta']['estado'] == 0){ echo 'checked';} } ?> > Inactivo
                                </label>

                            </div>
                        </div>
                        <?php */ ?>

                        <?php if(isset( $_SESSION['session_cta'])){?> <input type="hidden" name="confirmacion" value="1"> <?php } ?>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <?php if(isset($sql_insertar)){ ?> El registro fue realizado, usted sera redirecionado <?php }elseif(isset( $_SESSION['session_cta'])){?> <button class="btn btn-sm btn-primary" type="submit">Confirmar Registro</button> <?php }else{ ?> <button class="btn btn-sm btn-primary" type="submit">Registrar</button> <?php } ?>
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

        unset($_SESSION['session_cta']); ?>

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
