<?php if(!isset($_SESSION)){session_start();}?>
<?php require("conexion/conexion.php"); ?>
<?php require("funciones/funciones.php"); ?>
<?php if(isset($_SESSION['session_gc'])){ ?>
<?php $header_bar = 'base_header.php'; ?>
<?php $menu = true; ?>
<?php /* ################ AUDITORIA DE SEGUIMIENTO ############## */ ?>
<?php require("funciones/funciones_auditorias.php"); ?>
<?php $lugar_mapa = 42; ?>
<?php $dispositivo_acceso = obtener_dispositivo(); ?>
<?php insertar_log_seguimiento($conexion2, ObtenerIP(), $dispositivo_acceso, $lugar_mapa, $_SESSION['session_gc']['usua_id']); ?>
<?php /* ######################################################## */ ?>
<?php if(isset($_POST['confirmacion'])){ $sql_insertar = mysqli_query($conexion2, "insert into maestro_proveedores(pro_nombre_comercial,
                                                                                                                   pro_razon_social,
                                                                                                                   pro_ruc,
                                                                                                                   pro_pais,
                                                                                                                   pro_status,
                                                                                                                   pro_telefono_1,
                                                                                                                   pro_telefono_2,
                                                                                                                   pro_descripcion,
                                                                                                                   pro_email
                                                                                                                   )values(
                                                                                                                   '".strtoupper($_POST['nombre_comercial'])."',
                                                                                                                   '".strtoupper($_POST['razon_social'])."',
                                                                                                                   '".strtoupper($_POST['ruc'])."',
                                                                                                                   '".strtoupper($_POST['id_pais'])."',
                                                                                                                   1,
                                                                                                                   '".strtoupper($_POST['telefono_1'])."',
                                                                                                                   '".strtoupper($_POST['telefono_2'])."',
                                                                                                                   '".strtoupper($_POST['descripcion'])."',
                                                                                                                   '".strtoupper($_POST['email'])."')");

############################# Auditoria ##############################

                                    $recuperar_id_proveedor = $conexion2 -> query("SELECT MAX(id_proveedores) AS id FROM maestro_proveedores");
                                            while($id_proveedor = $recuperar_id_proveedor -> fetch_array()){
                                                    $id_proveedor_recuperado = $id_proveedor['id'];}

                                    $tipo_operacion = 1;
                                    $comentario = "Registro de Proveedor";
                                    $sql_insertar_auditoria = $conexion2 -> query("insert into auditoria_proveedores(aup_tipo_operacion,
                                                                                                                     aup_usua_log,
                                                                                                                     aup_fecha_hora,
                                                                                                                     aup_comentario,
                                                                                                                     aup_id_proveedores,
                                                                                                                     aup_pro_nombre_comercial,
                                                                                                                     aup_pro_razon_social,
                                                                                                                     aup_pro_ruc,
                                                                                                                     aup_pro_pais,
                                                                                                                     aup_pro_status,
                                                                                                                     aup_pro_telefono_1,
                                                                                                                     aup_pro_telefono_2,
                                                                                                                     aup_pro_descripcion,
                                                                                                                     aup_pro_email
                                                                                                                     )values(
                                                                                                                     '".$tipo_operacion."',
                                                                                                                     '".$_SESSION['session_gc']['usua_id']."',
                                                                                                                     '".$comentario."',
                                                                                                                     '".$id_proveedor_recuperado."',
                                                                                                                     '".$_POST['nombre_comercial']."',
                                                                                                                     '".$_POST['razon_social']."',
                                                                                                                     '".$_POST['ruc']."',
                                                                                                                     '".$_POST['id_pais']."',
                                                                                                                     1,
                                                                                                                     '".$_POST['id_pais']."',
                                                                                                                     '".$_POST['telefono_1']."',
                                                                                                                     '".$_POST['telefono_2']."',
                                                                                                                     '".$_POST['descripcion']."',
                                                                                                                     '".$_POST['email']."')");
#######################################################################

                                                                                                        }elseif(isset($_POST['nombre_comercial'],
                                                                                                                          $_POST['razon_social'],
                                                                                                                              $_POST['ruc'],
                                                                                                                              $_POST['id_pais'],
                                                                                                                      $_POST['telefono_1'])){


                                                                                                                        $sql_comprobar = $conexion2->query("select count(*) as contar
                                                                                                                                                            from
                                                                                                                                                            maestro_proveedores
                                                                                                                                                            where
                                                                                                                                                            pro_ruc = '".$_POST['ruc']."'");
                                                                                                                        while($c=$sql_comprobar->fetch_array()){
                                                                                                                              $r=$c['contar'];
                                                                                                                        }

                                                                                                                                        if($r>0){

                                                                                                                                        $existe_registro = true; }else{


                                                                                                                        $session_pro = array('nombre_comercial'=>$_POST['nombre_comercial'],
                                                                                                                                                'razon_social'=>$_POST['razon_social'],
                                                                                                                                                    'ruc'=>$_POST['ruc'],
                                                                                                                                                        'id_pais' =>$_POST['id_pais'],
                                                                                                                                                        'telefono_1'=>$_POST['telefono_1'],
                                                                                                                                                    'telefono_2'=>$_POST['telefono_2'],
                                                                                                                                                 'descripcion'=>$_POST['descripcion'],
                                                                                                                                                 'email'=>$_POST['email']);

                                                                                                                        $_SESSION['session_pro']=$session_pro; }} ?>

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
                  <p>El <a class="alert-link" href="javascript:void(0)">Proveedor</a> fue registrado!</p>
              </div>
      <?php }elseif(isset($existe_registro)){ ?>
            <div class="alert alert-warning alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h3 class="font-w300 push-15">Ya existe el registro</h3>
                <p>El proveedor ya esta registrado</p>
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
                    <h3 class="block-title">Registrar Proveedor</h3><small> Los campos con <span class="text-danger">*</span> son obligatorios</small>
                </div>
                <div class="block-content block-content-narrow">
                    <!-- jQuery Validation (.js-validation-bootstrap class is initialized in js/pages/base_forms_validation.js) -->
                    <!-- For more examples you can check out https://github.com/jzaefferer/jquery-validation -->


                    <form class="js-validation-bootstrap form-horizontal" action="" method="post">
                      <div class="form-group">
                          <label class="col-md-4 control-label" for="val-username">El proveedor Existe ?<span class="text-danger"></span></label>
                          <div class="col-md-7">
                            <select class="js-select2 form-control" id="val-select2" style="width: 100%;" data-placeholder="Verificar si el proveedor existe">
                                <option></option>
                                <?php $sql_proveedores = todos_proveedores($conexion2); ?>
                                <?php while($lista_proveedores = $sql_proveedores -> fetch_array()){ ?>
                                <option value="<?php echo $lista_proveedores['id_proveedores']; ?>"
                                               <?php if(isset($_SESSION['partida_documento'])){ if($_SESSION['partida_documento']['id_proveedor'] == $lista_proveedores['id_proveedores']){ echo 'selected'; }} ?>
                                 ><?php echo utf8_encode($lista_proveedores['pro_nombre_comercial']); ?></option>
                                <?php } ?>
                            </select>
                          </div>
                      </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-username">Pais<span class="text-danger">*</span></label>
                            <div class="col-md-7">

                                <select class="js-select2 form-control" name="id_pais" style="width: 100%;" data-placeholder="Seleccionar un pais" required="required">
                                    <option value=""> Selecciona un pais</option>
                                    <?php
                                            $strConsulta = "select id_paises, ps_nombre_pais from maestro_paises";
                                            $result = $conexion2->query($strConsulta);
                                            $opciones = '<option value="0"> Elige un pais </option>';
                                            while($fila = $result->fetch_array()){ ?>
                                                    <option value="<?php echo $fila['id_paises']; ?>" <?php if(isset( $_SESSION['session_pro'])){ if($_SESSION['session_pro']['id_pais'] == $fila['id_paises']){ echo 'selected';}} ?> ><?php echo $fila['ps_nombre_pais']; ?></option>
                                    <?php  } ?>

                                </select>

                            </div>

                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-username">Nombre comercial <span class="text-danger">*</span></label>
                            <div class="col-md-7">
                               <input class="form-control" type="text" autocomplete="off" name="nombre_comercial" placeholder="Nombre comercial" required="required" value="<?php if(isset( $_SESSION['session_pro'])){ echo  $_SESSION['session_pro']['nombre_comercial'];} ?>">

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-email">Razon social<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                 <input class="form-control" autocomplete="off" type="text" name="razon_social" placeholder="Razon social" required="required" value="<?php if(isset( $_SESSION['session_pro'])){ echo  $_SESSION['session_pro']['razon_social'];} ?>">

                            </div>

                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-password">Ruc<span class="text-danger">*</span></label>
                            <div class="col-md-7">

                                <input class="form-control" autocomplete="off" type="text" name="ruc" placeholder="Ruc" required="required" value="<?php if(isset( $_SESSION['session_pro'])){ echo  $_SESSION['session_pro']['ruc'];} ?>">

                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-password">Telefono 1<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <input class="form-control" type="number" autocomplete="off" name="telefono_1" placeholder="Telefono 1" required="required" value="<?php if(isset( $_SESSION['session_pro'])){ echo  $_SESSION['session_pro']['telefono_1'];} ?>">

                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-password">Telefono 2</label>
                            <div class="col-md-7">
                                <input class="form-control" type="number" autocomplete="off" name="telefono_2" placeholder="Telefono 2" value="<?php if(isset( $_SESSION['session_pro'])){ echo  $_SESSION['session_pro']['telefono_2'];} ?>">

                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-password">Email<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <input autocomplete="off" class="form-control" type="email" required="required" name="email" placeholder="Email" value="<?php if(isset( $_SESSION['session_pro'])){ echo $_SESSION['session_pro']['email'];} ?>">

                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-password">Descripcion</label>
                            <div class="col-md-7">
                                <textarea class="form-control"  name="descripcion" placeholder="Descripcion"><?php if(isset( $_SESSION['session_pro'])){ echo $_SESSION['session_pro']['descripcion'];} ?></textarea>

                            </div>
                        </div>
                        <?php /* ?>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-password">Estado del proveedor<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <label class="rad-inline" for="example-inline-checkbox1">
                                    <input type="radio" id="example-inline-checkbox1" name="estado" value="1" <?php if(isset( $_SESSION['session_pro'])){ if($_SESSION['session_pro']['estado'] == 1){ echo 'checked';} } ?> > Activa
                                </label>
                                <label class="rad-inline" for="example-inline-checkbox1">
                                    <input type="radio" id="example-inline-checkbox2" name="estado" value="0" <?php if(isset( $_SESSION['session_pro'])){ if($_SESSION['session_pro']['estado'] == 0){ echo 'checked';} } ?> > Inactiva
                                </label>

                            </div>
                        </div>
                        <?php */ ?>
                        <?php if(isset( $_SESSION['session_pro'])){?> <input type="hidden" name="confirmacion" value="1"> <?php } ?>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <?php if(isset($sql_insertar)){ ?> El registro fue realizado, usted sera redirecionado <?php }elseif(isset( $_SESSION['session_pro'])){?> <button class="btn btn-sm btn-primary" type="submit">Confirmar Registro</button> <?php }else{ ?> <button class="btn btn-sm btn-primary" type="submit">Registrar</button> <?php } ?>
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

        unset($_SESSION['session_pro']); ?>
<!--
        <script type="text/javascript">
            function redireccionarPagina() {
              window.location = "gc_principal.php";
            }
            setTimeout("redireccionarPagina()", 5000);
        </script>
-->

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
