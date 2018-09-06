<?php if(!isset($_SESSION)){session_start();}?>
<?php require("conexion/conexion.php"); ?>
<?php require("funciones/funciones.php"); ?>
<?php if(isset($_SESSION['session_gc'])){ ?>
<?php $header_bar = 'base_header.php'; ?>
<?php $menu = true; ?>
<?php /* ################ AUDITORIA DE SEGUIMIENTO ############## */ ?>
<?php require("funciones/funciones_auditorias.php"); ?>
<?php $lugar_mapa = 12; ?>
<?php $dispositivo_acceso = obtener_dispositivo(); ?>
<?php insertar_log_seguimiento($conexion2, ObtenerIP(), $dispositivo_acceso, $lugar_mapa, $_SESSION['session_gc']['usua_id']); ?>
<?php /* ######################################################## */ ?>

<?php if(isset($_POST['confirmacion'])){ $sql_insertar = mysqli_query($conexion2, "insert into chequeras(chq_id_cuenta_banco,
                                                                                                         chq_estado_chequera,
                                                                                                         chq_chequera_inicial,
                                                                                                         chq_chequera_final,
                                                                                                         chq_ultimo_emitido
                                                                                                         )values(
                                                                                                         '".strtoupper($_POST['id_cuenta'])."',
                                                                                                         1,
                                                                                                         '".strtoupper($_POST['chequera_inicial'])."',
                                                                                                         '".strtoupper($_POST['chequera_final'])."',
                                                                                                         '".strtoupper($_POST['ultimo_cheque_emitido'])."')"); }elseif(isset($_POST['id_cuenta'],
                                                                                                                                                                                      $_POST['chequera_inicial'],
                                                                                                                                                                                      $_POST['chequera_final'],
                                                                                                                                                                              $_POST['ultimo_cheque_emitido'])){


                                                                                                                        $session_chq = array('id_cuenta'=>$_POST['id_cuenta'],
                                                                                                                                                    'chequera_inicial' =>$_POST['chequera_inicial'],
                                                                                                                                                        'chequera_final' =>$_POST['chequera_final'],
                                                                                                                                             'ultimo_cheque_emitido'=>$_POST['ultimo_cheque_emitido']);

                                                                                                                        $_SESSION['session_chq']=$session_chq; } ?>

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
                        <p>La <a class="alert-link" href="javascript:void(0)">chequera</a> fue registrada!</p>
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
                    <h3 class="block-title">Registrar chequera</h3><small> Los campos con <span class="text-danger">*</span> son obligatorios</small>
                </div>
                <div class="block-content block-content-narrow">
                    <!-- jQuery Validation (.js-validation-bootstrap class is initialized in js/pages/base_forms_validation.js) -->
                    <!-- For more examples you can check out https://github.com/jzaefferer/jquery-validation -->
                    <form class="js-validation-bootstrap form-horizontal" action="" method="post">
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-username">Cuenta<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <select class="js-select2 form-control" id="val-select2" name="id_cuenta" style="width: 100%;" data-placeholder="Seleccionar cuenta" required="required">
                                    <option></option>
                                    <?php   $sql_cuenta = movimiento_bancario_cuenta($conexion2); ?>
                                    <?php   while($lista_cuentas = $sql_cuenta -> fetch_array()){ ?>
                                    <option value="<?php echo $lista_cuentas['id_cuenta_bancaria']; ?>"
                                                   <?php if(isset($_SESSION['session_chq'])){ if($_SESSION['session_chq']['id_cuenta'] == $lista_cuentas['id_cuenta_bancaria']){ echo 'selected'; }} ?>
                                     ><?php echo $lista_cuentas['proy_nombre_proyecto']. ' // ' .$lista_cuentas['banc_nombre_banco']. ' // ' .$lista_cuentas['cta_numero_cuenta']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-email">Chequera inicial<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                 <input class="form-control" autocomplete="off" type="text"  name="chequera_inicial" placeholder="Chequera inicial" required="required" value="<?php if(isset( $_SESSION['session_chq'])){ echo  $_SESSION['session_chq']['chequera_inicial'];} ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-password">Chequera final<span class="text-danger">*</span></label>
                            <div class="col-md-7">

                                <input class="form-control" autocomplete="off" type="text"  name="chequera_final" placeholder="Chequera final" required="required" value="<?php if(isset( $_SESSION['session_chq'])){ echo  $_SESSION['session_chq']['chequera_final'];} ?>">

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-password">Ultimo cheque emitido<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <input class="form-control" autocomplete="off" type="text"  name="ultimo_cheque_emitido" placeholder="Ultimo cheque emitido" required="required" value="<?php if(isset( $_SESSION['session_chq'])){ echo  $_SESSION['session_chq']['ultimo_cheque_emitido'];} ?>">
                            </div>
                        </div>
                        <?php /* ?>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-password">Estado de chequera<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <label class="rad-inline" for="example-inline-checkbox1">
                                    <input type="radio" id="example-inline-checkbox1" name="estado" value="1" <?php if(isset( $_SESSION['session_chq'])){ if($_SESSION['session_chq']['estado'] == 1){ echo 'checked';} } ?> > Activa
                                </label>
                                <label class="rad-inline" for="example-inline-checkbox1">
                                    <input type="radio" id="example-inline-checkbox2" name="estado" value="0" <?php if(isset( $_SESSION['session_chq'])){ if($_SESSION['session_chq']['estado'] == 0){ echo 'checked';} } ?> > Inactiva
                                </label>
                            </div>
                        </div>
                        <?php */ ?>
                        <?php if(isset( $_SESSION['session_chq'])){?> <input type="hidden" name="confirmacion" value="1"> <?php } ?>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <?php if(isset($sql_insertar)){ ?> El registro fue realizado, usted sera redirecionado <?php }elseif(isset( $_SESSION['session_chq'])){?> <button class="btn btn-sm btn-primary" type="submit">Confirmar Registro</button> <?php }else{ ?> <button class="btn btn-sm btn-primary" type="submit">Registrar</button> <?php } ?>
                            </div>

                        </div>
                    </form>
            </div>
            <!-- Bootstrap Forms Validation -->
        </div>
    </div>
</div>


<?php if(isset($sql_insertar)){

        unset($_SESSION['session_chq']); ?>

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
            window.location="salir.php";
        </script>

<?php } ?>
