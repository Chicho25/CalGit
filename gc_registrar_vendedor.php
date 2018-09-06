<?php if(!isset($_SESSION)){session_start();}?>
<?php require("conexion/conexion.php"); ?>
<?php require("funciones/funciones.php"); ?>
<?php if(isset($_SESSION['session_gc'])){ ?>
<?php $header_bar = 'base_header.php'; ?>
<?php $menu = true; ?>
<?php /* ################ AUDITORIA DE SEGUIMIENTO ############## */ ?>
<?php require("funciones/funciones_auditorias.php"); ?>
<?php $lugar_mapa = 15; ?>
<?php $dispositivo_acceso = obtener_dispositivo(); ?>
<?php insertar_log_seguimiento($conexion2, ObtenerIP(), $dispositivo_acceso, $lugar_mapa, $_SESSION['session_gc']['usua_id']); ?>
<?php /* ######################################################## */ ?>

<?php if(isset($_POST['confirmacion'])){ $sql_insertar = mysqli_query($conexion2, "insert into maestro_vendedores(ven_nombre,
                                                                                                                  ven_apellido,
                                                                                                                  ven_telefono_1,
                                                                                                                  ven_telefono_2,
                                                                                                                  ven_identidicacion,
                                                                                                                  ven_status,
                                                                                                                  ven_email
                                                                                                                  )values(
                                                                                                                  '".strtoupper($_POST['nombre'])."',
                                                                                                                  '".strtoupper($_POST['apellido'])."',
                                                                                                                  '".strtoupper($_POST['telefono_1'])."',
                                                                                                                  '".strtoupper($_POST['telefono_2'])."',
                                                                                                                  '".strtoupper($_POST['identificacion'])."',
                                                                                                                  1,
                                                                                                                  '".strtoupper($_POST['email'])."')");

                              $sql_insertar_proveedor = mysqli_query($conexion2, "insert into maestro_proveedores(pro_nombre_comercial,
                                                                                                                   pro_razon_social,
                                                                                                                   pro_status,
                                                                                                                   pro_telefono_1,
                                                                                                                   pro_telefono_2,
                                                                                                                   pro_descripcion,
                                                                                                                   pro_email,
                                                                                                                   pro_pais
                                                                                                                   )values(
                                                                                                                   '".strtoupper($_POST['nombre'])."',
                                                                                                                   '".strtoupper($_POST['apellido'])."',
                                                                                                                   1,
                                                                                                                   '".strtoupper($_POST['telefono_1'])."',
                                                                                                                   '".strtoupper($_POST['telefono_2'])."',
                                                                                                                   '".strtoupper($_POST['identificacion'])."',
                                                                                                                   '".strtoupper($_POST['email'])."',
                                                                                                                   80)");

############################# Auditoria ##############################

                                       $recuperar_id_vendedor = $conexion2 -> query("SELECT MAX(id_vendedor) AS id FROM maestro_vendedores");
                                               while($id_vendedor = $recuperar_id_vendedor -> fetch_array()){
                                                       $id_vendedor_recuperado = $id_vendedor['id'];}

                                       $tipo_operacion = 1;
                                       $comentario = "Registro de Vendedor";
                                       $sql_insertar_auditoria = $conexion2 -> query("insert into auditoria_vendedor(auv_tipo_operacion,
                                                                                                                     auv_usua_log,
                                                                                                                     auv_comentario,
                                                                                                                     auv_id_vendedor,
                                                                                                                     auv_ven_nombre,
                                                                                                                     auv_ven_apellido,
                                                                                                                     auv_ven_telefono_1,
                                                                                                                     auv_ven_telefono_2,
                                                                                                                     auv_ven_identidicacion,
                                                                                                                     auv_ven_status,
                                                                                                                     auv_ven_email
                                                                                                                     )values(
                                                                                                                     '".$tipo_operacion."',
                                                                                                                     '".$_SESSION['session_gc']['usua_id']."',
                                                                                                                     '".$comentario."',
                                                                                                                     '".$id_vendedor_recuperado."',
                                                                                                                     '".$_POST['nombre']."',
                                                                                                                     '".$_POST['apellido']."',
                                                                                                                     '".$_POST['telefono_1']."',
                                                                                                                     '".$_POST['telefono_2']."',
                                                                                                                     '".$_POST['identificacion']."',
                                                                                                                     1,
                                                                                                                     '".$_POST['email']."')");
#######################################################################
                                                                                                                                                          }elseif(isset($_POST['nombre'],
                                                                                                                                                                            $_POST['apellido'],
                                                                                                                                                                                $_POST['telefono_1'],
                                                                                                                                                                                $_POST['telefono_2'],
                                                                                                                                                                        $_POST['identificacion'])){


                                                                                                                                $sql_comprobar = $conexion2->query("select count(*) as contar
                                                                                                                                                                    from
                                                                                                                                                                    maestro_vendedores
                                                                                                                                                                    where
                                                                                                                                                                    ven_identidicacion = '".$_POST['identificacion']."'");
                                                                                                                                while($c=$sql_comprobar->fetch_array()){
                                                                                                                                      $r=$c['contar'];
                                                                                                                                }

                                                                                                                                                if($r>0){

                                                                                                                                                $existe_registro = true; }else{

                                                                                                                                $session_ven = array('nombre'=>$_POST['nombre'],
                                                                                                                                                        'apellido'=>$_POST['apellido'],
                                                                                                                                                            'telefono_1'=>$_POST['telefono_1'],
                                                                                                                                                                'telefono_2' =>$_POST['telefono_2'],
                                                                                                                                                                    'identificacion' =>$_POST['identificacion'],
                                                                                                                                                            'email'=>$_POST['email']);

                                                                                                                                $_SESSION['session_ven']=$session_ven; }} ?>

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
                  <p>El <a class="alert-link" href="javascript:void(0)">Vendedor</a> fue registrado!</p>
              </div>
      <?php }elseif(isset($existe_registro)){ ?>
            <div class="alert alert-warning alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h3 class="font-w300 push-15">Ya existe el registro</h3>
                <p>El vendedor ya esta registrado</p>
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
                    <h3 class="block-title">Registrar vendedor</h3><small> Los campos con <span class="text-danger">*</span> son obligatorios</small>
                </div>
                <div class="block-content block-content-narrow">
                    <!-- jQuery Validation (.js-validation-bootstrap class is initialized in js/pages/base_forms_validation.js) -->
                    <!-- For more examples you can check out https://github.com/jzaefferer/jquery-validation -->
                      <?php /* ?>
                    <form class="form-horizontal" action="" method="post">
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-username">Proveedor ?</label>
                            <div class="col-md-7">

                                <select class="js-select2 form-control" name="id_proveedor" style="width: 100%;" data-placeholder="Seleccionar un proveedor" onchange="this.form.submit()">
                                    <option value=""> Selecciona un proveedor</option>
                                    <?php
                                            $result = todos_proveedores($conexion2);
                                            $opciones = '<option value=""> Elige un proveedor </option>';
                                            while($fila = $result->fetch_array()){ ?>
                                                    <option value="<?php echo $fila['id_proveedores']; ?>" <?php if(isset($_POST['id_proveedor'])){
                                                                                                                    if($_POST['id_proveedor'] == $fila['id_proveedores']){
                                                                                                                        echo 'selected';}} ?> > <?php echo $fila['pro_nombre_comercial']; ?></option>
                                    <?php } ?>
                                </select>

                            </div>
                        </div>
                    </form><?php */ ?>

                    <?php if(isset($_POST['id_proveedor'])){

                                $result_proveedores = proveedores_id($conexion2, $_POST['id_proveedor']);

                                    while($fila_proveedores = $result_proveedores->fetch_array()){

                                            $id = $fila_proveedores['id_proveedores'];
                                            $nombre_comercial = $fila_proveedores['pro_nombre_comercial'];
                                            $razon_social = $fila_proveedores['pro_razon_social'];
                                            $ruc = $fila_proveedores['pro_ruc'];
                                            $stado = $fila_proveedores['pro_status'];
                                            $telefono_1 = $fila_proveedores['pro_telefono_1'];
                                            $telefono_2 = $fila_proveedores['pro_telefono_2'];
                                            $email = $fila_proveedores['pro_email'];

                                            }

                    } ?>

                    <form class="js-validation-bootstrap form-horizontal" action="" method="post">
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-username">Nombre <span class="text-danger">*</span></label>
                            <div class="col-md-7">
                               <input autocomplete="off" required="required" class="form-control" type="text" name="nombre" placeholder="Nombre" value="<?php if(isset($nombre_comercial)){ echo $nombre_comercial;}else{ if(isset( $_SESSION['session_ven'])){ echo  $_SESSION['session_ven']['nombre'];}} ?>">

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-email">Apellido<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                 <input autocomplete="off" class="form-control" type="text" name="apellido" placeholder="Apellido" required="required" value="<?php if(isset($razon_social)){ echo $razon_social;}else{ if(isset( $_SESSION['session_ven'])){ echo  $_SESSION['session_ven']['apellido'];}} ?>">

                            </div>

                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-password">Identificacion<span class="text-danger">*</span></label>
                            <div class="col-md-7">

                                <input autocomplete="off" class="form-control" type="text" name="identificacion" placeholder="Identificacion" required="required" value="<?php if(isset($ruc)){ echo $ruc;}else{ if(isset( $_SESSION['session_ven'])){ echo  $_SESSION['session_ven']['identificacion'];}} ?>">

                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-password">Telefono 1<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <input autocomplete="off" class="form-control" type="number" name="telefono_1" placeholder="Telefono 1" required="required" value="<?php if(isset($telefono_1)){ echo $telefono_1;}else{ if(isset( $_SESSION['session_ven'])){ echo  $_SESSION['session_ven']['telefono_1'];}} ?>">

                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-password">Telefono 2</label>
                            <div class="col-md-7">
                                <input autocomplete="off" class="form-control" type="number" name="telefono_2" placeholder="Telefono 2" value="<?php if(isset($telefono_2)){ echo $telefono_2;}else{ if(isset( $_SESSION['session_ven'])){ echo  $_SESSION['session_ven']['telefono_2'];}} ?>">

                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-password">Email<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <input autocomplete="off" class="form-control" type="email" name="email" placeholder="Email" required="required" value="<?php if(isset($email)){ echo $email;}else{ if(isset( $_SESSION['session_ven'])){ echo  $_SESSION['session_ven']['email'];}} ?>">

                            </div>
                        </div>
                        <?php /* ?>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-password">Estado del vendedor<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <label class="rad-inline" for="example-inline-checkbox1">
                                    <input type="radio" id="example-inline-checkbox1" name="estado" value="1" <?php if(isset( $_SESSION['session_ven'])){ if($_SESSION['session_ven']['estado'] == 1){ echo 'checked';} } ?> > Activa
                                </label>
                                <label class="rad-inline" for="example-inline-checkbox1">
                                    <input type="radio" id="example-inline-checkbox2" name="estado" value="0" <?php if(isset( $_SESSION['session_ven'])){ if($_SESSION['session_ven']['estado'] == 0){ echo 'checked';} } ?> > Inactiva
                                </label>

                            </div>
                        </div>
                        <?php */ ?>
                        <?php if(isset( $_SESSION['session_ven'])){?> <input type="hidden" name="confirmacion" value="1"> <?php } ?>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <?php if(isset($sql_insertar)){ ?> El registro fue realizado, usted sera redirecionado <?php }elseif(isset( $_SESSION['session_ven'])){?> <button class="btn btn-sm btn-primary" type="submit">Confirmar Registro</button> <?php }else{ ?> <button class="btn btn-sm btn-primary" type="submit">Registrar</button> <?php } ?>
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

        unset($_SESSION['session_ven']); ?>

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
