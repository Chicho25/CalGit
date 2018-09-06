<?php if(!isset($_SESSION)){session_start();}?>
<?php require("conexion/conexion.php"); ?>
<?php require("funciones/funciones.php"); ?>
<?php if(isset($_SESSION['session_gc'])){ ?>
<?php $header_bar = 'base_header.php'; ?>
<?php $menu = true; ?>
<?php /* ################ AUDITORIA DE SEGUIMIENTO ############## */ ?>
<?php require("funciones/funciones_auditorias.php"); ?>
<?php $lugar_mapa = 6; ?>
<?php $dispositivo_acceso = obtener_dispositivo(); ?>
<?php insertar_log_seguimiento($conexion2, ObtenerIP(), $dispositivo_acceso, $lugar_mapa, $_SESSION['session_gc']['usua_id']); ?>
<?php /* ######################################################## */ ?>

<?php if(isset($_POST['confirmacion'])){ $sql_insertar = mysqli_query($conexion2, "insert into maestro_proyectos(proy_nombre_proyecto,
                                                                                                                 proy_tipo_proyecto,
                                                                                                                 proy_promotor,
                                                                                                                 proy_area,
                                                                                                                 proy_estado,
                                                                                                                 proy_resolucion_ambiental,
                                                                                                                 id_empresa,
                                                                                                                 proy_monto_inicial
                                                                                                                 )values(
                                                                                                                '".strtoupper($_POST['nombre_proyecto'])."',
                                                                                                                '".strtoupper($_POST['tipo_proyecto'])."',
                                                                                                                '".strtoupper($_POST['promotor'])."',
                                                                                                                '".strtoupper($_POST['area'])."',
                                                                                                                1,
                                                                                                                '".strtoupper($_POST['resolucion_ambiental'])."',
                                                                                                                '".$_POST['id_empresa']."',
                                                                                                                '".$_POST['monto_inicial']."')");
## creacion de partidas al momento de crear un proyecto, esta es la partida inicial ##
$sql_ultimo_id = $conexion2 -> query("select max(id_proyecto) as ultimo_id from maestro_proyectos");
while($lista_ultimo_id = $sql_ultimo_id->fetch_array()){
      $ultimo_id = $lista_ultimo_id['ultimo_id'];
}
$sql_insertar_partida = $conexion2 -> query("INSERT INTO maestro_partidas(p_nombre,
                                                                          id_proyecto,
                                                                          p_status,
                                                                          p_monto
                                                                          )VALUES(
                                                                          '".strtoupper($_POST['nombre_proyecto'])."',
                                                                          '".$ultimo_id."',
                                                                          1,
                                                                          '".$_POST['monto_inicial']."')");
############################# Auditoria ##############################

$recuperar_id_proyecto = $conexion2 -> query("SELECT MAX(id_proyecto) AS id FROM maestro_proyectos");
        while($id_proyecto = $recuperar_id_proyecto -> fetch_array()){
                $id_proyecto_recuperado = $id_proyecto['id'];}

$tipo_operacion = 1;
$comentario = "Registro de Proyecto";

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
                                                                              aup_id_empresa,
                                                                              aup_monto
                                                                              )values(
                                                                              '".$tipo_operacion."',
                                                                              '".$_SESSION['session_gc']['usua_id']."',
                                                                              '".$comentario."',
                                                                              '".$id_proyecto_recuperado."',
                                                                              '".$_POST['nombre_proyecto']."',
                                                                              '".$_POST['tipo_proyecto']."',
                                                                              '".$_POST['promotor']."',
                                                                              '".$_POST['area']."',
                                                                              1,
                                                                              '".$_POST['resolucion_ambiental']."',
                                                                              '".$_POST['id_empresa']."',
                                                                              '".$_POST['monto_inicial']."')");
######################################################################



                     }elseif(isset($_POST['nombre_proyecto'],
                                        $_POST['tipo_proyecto'],
                                                $_POST['promotor'],
                                                $_POST['area'],
                                        $_POST['resolucion_ambiental'],
                                    $_POST['id_empresa'],
                                  $_POST['monto_inicial'])){

$sql_comprobar = $conexion2->query("select count(*) as contar
                                    from
                                    maestro_proyectos
                                    where
                                    proy_nombre_proyecto = '".$_POST['nombre_proyecto']."'");
while($c=$sql_comprobar->fetch_array()){
      $r=$c['contar'];
}

                if($r>0){

                $existe_registro = true; }else{

$session_proyecto = array('nombre_proyecto'=>$_POST['nombre_proyecto'],
                                'tipo_proyecto'=>$_POST['tipo_proyecto'],
                                    'promotor' =>$_POST['promotor'],
                                        'area' =>$_POST['area'],
                                    'resolucion_ambiental'=>$_POST['resolucion_ambiental'],
                                'id_empresa'=>$_POST['id_empresa'],
                              'monto_inicial'=>$_POST['monto_inicial']);

$_SESSION['session_proyecto']=$session_proyecto; }} ?>

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
                  <p>El <a class="alert-link" href="javascript:void(0)">proyecto</a> fue registrado!</p>
              </div>
      <?php }elseif(isset($existe_registro)){ ?>
            <div class="alert alert-warning alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h3 class="font-w300 push-15">Ya existe el registro</h3>
                <p>Ya existe un proyecto con ese nombre</p>
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
                    <h3 class="block-title">Crear proyecto</h3><small> Los campos con <span class="text-danger">*</span> son obligatorios</small>
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
                                                   <?php if(isset($_SESSION['session_proyecto'])){ if($_SESSION['session_proyecto']['id_empresa'] == $lista_empresas['id_empresa']){ echo 'selected'; }} ?>
                                     ><?php echo $lista_empresas['empre_nombre_comercial']; ?></option>
                                    <?php } ?>
                                </select>

                            </div>

                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-username">Nombre del proyecto<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <input class="form-control" autocomplete="off" type="text" id="val-username" name="nombre_proyecto" placeholder="Nombre del proyecto" required="required" value="<?php if(isset( $_SESSION['session_proyecto'])){ echo  $_SESSION['session_proyecto']['nombre_proyecto'];} ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-username">Tipo de proyecto <span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <input class="form-control" autocomplete="off" type="text" id="val-username" name="tipo_proyecto" placeholder="Tipo de proyecto" required="required" value="<?php if(isset( $_SESSION['session_proyecto'])){ echo  $_SESSION['session_proyecto']['tipo_proyecto'];} ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-email">Promotor <span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <input class="form-control" autocomplete="off" type="text" name="promotor" placeholder="Promotor" required="required" value="<?php if(isset( $_SESSION['session_proyecto'])){ echo  $_SESSION['session_proyecto']['promotor'];} ?>">
                            <div id="Info" style="margin-top: 10px;" ></div>
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-password">Area<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <input class="form-control" autocomplete="off" type="text" name="area" placeholder="Area" required="required" value="<?php if(isset( $_SESSION['session_proyecto'])){ echo  $_SESSION['session_proyecto']['area'];} ?>">
                            </div>
                        </div>
                        <?php /* ?>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-password">Estado del proyecto<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <label class="rad-inline" for="example-inline-checkbox1">
                                    <input type="radio" id="example-inline-checkbox1" name="estado_proyecto" value="1" <?php if(isset( $_SESSION['session_proyecto'])){ if($_SESSION['session_proyecto']['estado_proyecto'] == 1){ echo 'checked';} } ?> > Activo
                                </label>
                                <label class="rad-inline" for="example-inline-checkbox1">
                                    <input type="radio" id="example-inline-checkbox2" name="estado_proyecto" value="0" <?php if(isset( $_SESSION['session_proyecto'])){ if($_SESSION['session_proyecto']['estado_proyecto'] == 0){ echo 'checked';} } ?> > Inactivo
                                </label>

                            </div>
                        </div>
                        <?php */ ?>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-confirm-password">Resolucion ambiental</label>
                            <div class="col-md-7">
                                <input class="form-control" autocomplete="off" type="text" placeholder="Resolucion ambiental" name="resolucion_ambiental" required="required" value="<?php if(isset($_SESSION['session_proyecto'])){ echo $_SESSION['session_proyecto']['resolucion_ambiental'];} ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-confirm-password">Monto Inicial</label>
                            <div class="col-md-7">
                                <input class="form-control" autocomplete="off" type="number" placeholder="Monto Inicial" name="monto_inicial" required="required" value="<?php if(isset($_SESSION['session_proyecto'])){ echo $_SESSION['session_proyecto']['monto_inicial'];} ?>">
                            </div>
                        </div>
                        <?php if(isset( $_SESSION['session_proyecto'])){?> <input type="hidden" name="confirmacion" value="1"> <?php } ?>


                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <?php if(isset($sql_insertar)){ ?> El registro fue realizado, usted sera redirecionado <?php }elseif(isset($_SESSION['session_proyecto'])){?> <button class="btn btn-sm btn-primary" type="submit">Confirmar Registro</button> <?php }else{ ?> <button class="btn btn-sm btn-primary" type="submit">Registrar</button> <?php } ?>
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

        unset($_SESSION['session_proyecto']); ?>

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
            window.location="index.php";
        </script>

<?php } ?>
