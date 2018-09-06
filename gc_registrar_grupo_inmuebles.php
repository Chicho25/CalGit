<?php if(!isset($_SESSION)){session_start();}?>
<?php require("conexion/conexion.php"); ?>
<?php require("funciones/funciones.php"); ?>
<?php $nombre_pagina = "grupos de inmuebles"; ?>
<?php if(isset($_SESSION['session_gc'])){ ?>
<?php $header_bar = 'base_header.php'; ?>
<?php $menu = true; ?>
<?php /* ################ AUDITORIA DE SEGUIMIENTO ############## */ ?>
<?php require("funciones/funciones_auditorias.php"); ?>
<?php $lugar_mapa = 20; ?>
<?php $dispositivo_acceso = obtener_dispositivo(); ?>
<?php insertar_log_seguimiento($conexion2, ObtenerIP(), $dispositivo_acceso, $lugar_mapa, $_SESSION['session_gc']['usua_id']); ?>
<?php /* ######################################################## */ ?>

<?php if(isset($_POST['confirmacion'])){$sql_insertar = $conexion2 -> query("insert into grupo_inmuebles(gi_id_proyecto,
                                                                                                         gi_nombre_grupo_inmueble,
                                                                                                         gi_status,
                                                                                                         id_empresa,
                                                                                                         log_user
                                                                                                         )values(
                                                                                                         '".strtoupper($_POST['id_proyecto'])."',
                                                                                                         '".strtoupper($_POST['nombre_grupo_inmueble'])."',
                                                                                                         1,
                                                                                                         '".$_POST['id_empresa']."',
                                                                                                         '".$_SESSION['session_gc']['usua_id']."')");}elseif(isset($_POST['id_proyecto'],
                                                                                                                                                                   $_POST['nombre_grupo_inmueble'])){

                                                                                                        $sql_comprobar = $conexion2->query("select count(*) as contar
                                                                                                                                            from
                                                                                                                                            grupo_inmuebles
                                                                                                                                            where
                                                                                                                                            gi_nombre_grupo_inmueble = '".$_POST['nombre_grupo_inmueble']."'");
                                                                                                        while($c=$sql_comprobar->fetch_array()){
                                                                                                              $r=$c['contar'];
                                                                                                        }

                                                                                                                        if($r>0){

                                                                                                                            $existe_registro = true; }else{

                                                                                                                        $session_grupo_inmueble = array('id_proyecto'=>$_POST['id_proyecto'],
                                                                                                                                                        'nombre_grupo_inmueble'=>$_POST['nombre_grupo_inmueble'],
                                                                                                                                                        'id_empresa'=>$_POST['id_empresa']);

                                                                                                                        $_SESSION['session_grupo_inmueble']=$session_grupo_inmueble; }} ?>

<?php require 'inc/config.php'; ?>
<?php require 'inc/views/template_head_start.php'; ?>

<!-- Page JS Plugins CSS -->
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/select2/select2.min.css">
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/select2/select2-bootstrap.min.css">
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/sweetalert/sweetalert.min.css">

<?php require 'inc/views/template_head_end.php'; ?>

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                $("#marca").change(function(){
                    $.ajax({
                        url:"select_anidado/procesa_grupo_inmueble.php",
                        type: "POST",
                        data:"idmarca="+$("#marca").val(),
                        success: function(opciones){
                            $("#modelo").html(opciones);
                        }
                    })
                });
            });
    </script>

<?php require 'inc/views/base_head.php'; ?>

<div class="content content-narrow">
    <!-- Forms Row -->
    <div class="row">

            <?php if(isset($sql_insertar)){ ?>
                    <div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h3 class="font-w300 push-15">Registrado</h3>
                        <p>El <a class="alert-link" href="javascript:void(0)"><?php echo $nombre_pagina; ?></a> fue registrado!</p>
                    </div>
            <?php }elseif(isset($existe_registro)){ ?>
                  <div class="alert alert-warning alert-dismissable">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                      <h3 class="font-w300 push-15">Ya existe el registro</h3>
                      <p>El grupo de inmueble ya esta registrado</p>
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
                    <h3 class="block-title">Crear <?php echo $nombre_pagina; ?></h3><small> Los campos con <span class="text-danger">*</span> son obligatorios</small>
                </div>
                <div class="block-content block-content-narrow">
                    <!-- jQuery Validation (.js-validation-bootstrap class is initialized in js/pages/base_forms_validation.js) -->
                    <!-- For more examples you can check out https://github.com/jzaefferer/jquery-validation -->
                    <form class="js-validation-bootstrap form-horizontal" action="" method="post">

                         <div class="form-group">
                            <label class="col-md-4 control-label" for="val-username">Empresa<span class="text-danger">*</span></label>
                            <div class="col-md-7">

                                <select id="marca" class="js-select2 form-control" name="id_empresa" style="width: 100%;" data-placeholder="Seleccionar proyecto" required="required">
                                    <option value="0"> Selecciona una empresa</option>
                                    <?php
                                            $strConsulta = "select id_empresa, empre_nombre_comercial from maestro_empresa where empre_estado_empresa = 1";
                                            $result = $conexion2->query($strConsulta);
                                            $opciones = '<option value="0"> Elige una empresa </option>';
                                            while($fila = $result->fetch_array()){ ?>
                                                    <option value="<?php echo $fila['id_empresa']; ?>" <?php if(isset($_SESSION['session_grupo_inmueble'])){ if($_SESSION['session_grupo_inmueble']['id_empresa'] == $fila['id_empresa']){ echo 'selected';}} ?> ><?php echo $fila['empre_nombre_comercial']; ?></option>
                                    <?php  } ?>

                                </select>

                            </div>

                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-username">Proyecto<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                 <select id="modelo" class="js-select2 form-control" name="id_proyecto" style="width: 100%;" data-placeholder="Seleccionar proyecto" required="required">
                                 <?php if(isset($_SESSION['session_grupo_inmueble'])){
                                        $opciones = '<option value="0"> Elige un proyecto</option>';
                                        $strConsulta = "select id_proyecto, proy_nombre_proyecto from maestro_proyectos where id_proyecto = '".$_SESSION['session_grupo_inmueble']['id_proyecto']."' and proy_estado = 1";
                                        $result = $conexion2->query($strConsulta);
                                        while( $fila = $result->fetch_array()){ ?>
                                        <option value="<?php echo $fila['id_proyecto']; ?>" <?php if(isset($_SESSION['session_grupo_inmueble'])){ if($_SESSION['session_grupo_inmueble']['id_proyecto'] == $fila['id_proyecto']){ echo 'selected';}} ?> ><?php echo $fila['proy_nombre_proyecto']; ?></option>
                                        <?php } ?>
                                </select>
                                            <?php }else{ ?>

                                                     <select id="modelo" class="js-select2 form-control" name="id_proyecto" style="width: 100%;" data-placeholder="Seleccionar proyecto" required="required">
                                                        <option value="0"></option>
                                                    </select>
                                            <?php } ?>


                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-username">Nombre grupo de inmueble<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <input autocomplete="off" class="form-control" type="text" id="val-username" name="nombre_grupo_inmueble" placeholder="Nombre grupo de inmueble" required="required" value="<?php if(isset($_SESSION['session_grupo_inmueble'])){ echo $_SESSION['session_grupo_inmueble']['nombre_grupo_inmueble'];} ?>">
                            </div>
                        </div>
                        <?php /* ?>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-password">Estado grupo de inmueble<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <label class="rad-inline" for="example-inline-checkbox1">
                                    <input type="radio" id="example-inline-checkbox1" name="estado" value="1" <?php if(isset($_SESSION['session_grupo_inmueble'])){ if($_SESSION['session_grupo_inmueble']['estado'] == 1){ echo 'checked';} } ?> > Activo
                                </label>
                                <label class="rad-inline" for="example-inline-checkbox1">
                                    <input type="radio" id="example-inline-checkbox2" name="estado" value="0" <?php if(isset($_SESSION['session_grupo_inmueble'])){ if($_SESSION['session_grupo_inmueble']['estado'] == 0){ echo 'checked';} } ?> > Inactivo
                                </label>

                            </div>
                        </div>
                        <?php */ ?>


                        <?php if(isset($_SESSION['session_grupo_inmueble'])){?> <input type="hidden" name="confirmacion" value="1"> <?php } ?>


                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <?php if(isset($sql_insertar)){ ?> El registro fue realizado, usted sera redirecionado <?php }elseif(isset($_SESSION['session_grupo_inmueble'])){?> <button class="btn btn-sm btn-primary" type="submit">Confirmar Registro</button> <?php }else{ ?> <button class="btn btn-sm btn-primary" type="submit">Registrar</button> <?php } ?>
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

        unset($_SESSION['session_grupo_inmueble']); ?>

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
