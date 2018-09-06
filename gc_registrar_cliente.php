<?php if(!isset($_SESSION)){session_start();}?>
<?php require("conexion/conexion.php"); ?>
<?php require("funciones/funciones.php"); ?>
<?php if(isset($_SESSION['session_gc'])){ ?>
<?php $header_bar = 'base_header.php'; ?>
<?php $menu = true; ?>
<?php /* ################ AUDITORIA DE SEGUIMIENTO ############## */ ?>
<?php require("funciones/funciones_auditorias.php"); ?>
<?php $lugar_mapa = 16; ?>
<?php $dispositivo_acceso = obtener_dispositivo(); ?>
<?php insertar_log_seguimiento($conexion2, ObtenerIP(), $dispositivo_acceso, $lugar_mapa, $_SESSION['session_gc']['usua_id']); ?>
<?php /* ######################################################## */ ?>

<?php 
    $error =  false;
    if(isset($_POST['confirmacion'])){ 
        $res = mysqli_query($conexion2, "select * from maestro_clientes where cl_identificacion = '".strtoupper($_POST['identificacion'])."'");
        if(count(mysqli_fetch_array($res)) == 0){

            $sql_insertar = mysqli_query($conexion2, "insert into maestro_clientes(cl_nombre,
                                                                                   cl_apellido,
                                                                                   cl_telefono_1,
                                                                                   cl_telefono_2,
                                                                                   cl_identificacion,
                                                                                   cl_pais,
                                                                                   cl_direccion,
                                                                                   cl_status,
                                                                                   cl_email,
                                                                                   cl_referencia
                                                                                   )values(
                                                                                   '".strtoupper($_POST['nombre'])."',
                                                                                   '".strtoupper($_POST['apellido'])."',
                                                                                   '".$_POST['telefono_1']."',
                                                                                   '".$_POST['telefono_2']."',
                                                                                   '".strtoupper($_POST['identificacion'])."',
                                                                                   '".$_POST['id_pais']."',
                                                                                   '".strtoupper($_POST['direccion'])."',
                                                                                   1,
                                                                                   '".strtoupper($_POST['email'])."',
                                                                                   '".strtoupper($_POST['referencia'])."')");

            ############################# Auditoria ##############################
            $recuperar_id_cliente = $conexion2 -> query("SELECT MAX(id_cliente) AS id FROM maestro_clientes");
            while($id_cliente = $recuperar_id_cliente -> fetch_array()){
                $id_cliente_recuperado = $id_cliente['id'];
            }

            $tipo_operacion = 1;
            $comentario = "Registro de cliente";
            $sql_insertar_auditoria = $conexion2 -> query("insert into auditoria_clientes(auc_tipo_operacion,
                                                                                          auc_usua_log,
                                                                                          auc_comentario,
                                                                                          auc_id_cliente,
                                                                                          auc_nombre,
                                                                                          auc_apellido,
                                                                                          auc_telefono_1,
                                                                                          auc_telefono_2,
                                                                                          auc_identificacion,
                                                                                          auc_pais,
                                                                                          auc_direccion,
                                                                                          auc_status,
                                                                                          auc_email,
                                                                                          auc_referencia
                                                                                          )values(
                                                                                          '".$tipo_operacion."',
                                                                                          '".$_SESSION['session_gc']['usua_id']."',
                                                                                          '".$comentario."',
                                                                                          '".$id_cliente_recuperado."',
                                                                                          '".$_POST['nombre']."',
                                                                                          '".$_POST['apellido']."',
                                                                                          '".$_POST['telefono_1']."',
                                                                                          '".$_POST['telefono_2']."',
                                                                                          '".$_POST['identificacion']."',
                                                                                          '".$_POST['id_pais']."',
                                                                                          '".$_POST['direccion']."',
                                                                                          1,
                                                                                          '".$_POST['email']."',
                                                                                          '".$_POST['referencia']."')");
        }else{
            $error = true;
        }          
        #######################################################################
    }elseif(isset($_POST['nombre'], $_POST['apellido'], $_POST['telefono_1'], $_POST['telefono_2'], $_POST['identificacion'])){
        $sql_comprobar = $conexion2->query("select count(*) as contar from maestro_clientes where cl_identificacion = '".$_POST['identificacion']."'");
        while($c=$sql_comprobar->fetch_array()){
            $r=$c['contar'];
        }
        if($r>0){
            $existe_registro = true; 
        }else{
            $session_cl = array('nombre'=>$_POST['nombre'],
                                'apellido'=>$_POST['apellido'],
                                'telefono_1'=>$_POST['telefono_1'],
                                'telefono_2' =>$_POST['telefono_2'],
                                'identificacion' =>$_POST['identificacion'],
                                'id_pais'=>$_POST['id_pais'],
                                'direccion'=>$_POST['direccion'],
                                'email'=>$_POST['email'],
                                'referencia'=>$_POST['referencia']);
                                $_SESSION['session_cl']=$session_cl; 
        }
    } 
?>

<?php require 'inc/config.php'; ?>
<?php require 'inc/views/template_head_start.php'; ?>
<!-- Page JS Plugins CSS -->
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/select2/select2.min.css">
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/select2/select2-bootstrap.min.css">
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/sweetalert/sweetalert.min.css">
<?php require 'inc/views/template_head_end.php'; ?>
<?php require 'inc/views/base_head.php'; ?>
<?php if($error) : ?>
  <script>alert("Cliente existente."); </script>
<?php endif; ?>


<div class="content content-narrow">
    <!-- Forms Row -->
    <div class="row">

      <?php if(isset($sql_insertar)){ ?>
              <div class="alert alert-success alert-dismissable">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <h3 class="font-w300 push-15">Registrado</h3>
                  <p>El <a class="alert-link" href="javascript:void(0)">Cliente</a> fue registrado!</p>
              </div>
      <?php }elseif(isset($existe_registro)){ ?>
            <div class="alert alert-warning alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h3 class="font-w300 push-15">Ya existe el registro</h3>
                <p>El cliente ya esta registrado</p>
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
                    <h3 class="block-title">Registrar cliente</h3><small> Los campos con <span class="text-danger">*</span> son obligatorios</small>
                </div>
                <div class="block-content block-content-narrow">
                    <!-- jQuery Validation (.js-validation-bootstrap class is initialized in js/pages/base_forms_validation.js) -->
                    <!-- For more examples you can check out https://github.com/jzaefferer/jquery-validation -->

                    <form class="js-validation-bootstrap form-horizontal" action="" method="post">
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-username">Nombre <span class="text-danger">*</span></label>
                            <div class="col-md-7">
                               <input autocomplete="off" class="form-control" type="text" name="nombre" placeholder="Nombre" required="required" value="<?php if(isset($nombre_comercial)){ echo $nombre_comercial;}else{ if(isset( $_SESSION['session_cl'])){ echo  $_SESSION['session_cl']['nombre'];}} ?>">

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-email">Apellido<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                 <input autocomplete="off" class="form-control" type="text"  name="apellido" placeholder="Apellido" required="required" value="<?php if(isset($razon_social)){ echo $razon_social;}else{ if(isset( $_SESSION['session_cl'])){ echo  $_SESSION['session_cl']['apellido'];}} ?>">

                            </div>

                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-password">Identificacion<span class="text-danger">*</span></label>
                            <div class="col-md-7">

                                <input autocomplete="off" class="form-control" type="text"  name="identificacion" placeholder="Identificacion" required="required" value="<?php if(isset($ruc)){ echo $ruc;}else{ if(isset( $_SESSION['session_cl'])){ echo  $_SESSION['session_cl']['identificacion'];}} ?>">

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
                                                    <option value="<?php echo $fila['id_paises']; ?>" <?php if(isset( $_SESSION['session_cl'])){ if($_SESSION['session_cl']['id_pais'] == $fila['id_paises']){ echo 'selected';}} ?> ><?php echo $fila['ps_nombre_pais']; ?></option>
                                    <?php  } ?>

                                </select>

                            </div>

                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-password">Direccion</label>
                            <div class="col-md-7">
                                <textarea class="form-control"  name="direccion" placeholder="Direccion"><?php if(isset( $_SESSION['session_cl'])){ echo $_SESSION['session_cl']['direccion'];} ?></textarea>

                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-password">Telefono 1<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <input autocomplete="off" class="form-control" type="number"  name="telefono_1" placeholder="Telefono 1" required="required" value="<?php if(isset($telefono_1)){ echo $telefono_1;}else{ if(isset( $_SESSION['session_cl'])){ echo  $_SESSION['session_cl']['telefono_1'];}} ?>">

                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-password">Telefono 2</label>
                            <div class="col-md-7">
                                <input autocomplete="off" class="form-control" type="number"  name="telefono_2" placeholder="Telefono 2" value="<?php if(isset($telefono_2)){ echo $telefono_2;}else{ if(isset( $_SESSION['session_cl'])){ echo  $_SESSION['session_cl']['telefono_2'];}} ?>">

                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-password">Email<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <input autocomplete="off" class="form-control" type="email"  name="email" placeholder="Email" required="required" value="<?php if(isset($email)){ echo $email;}else{ if(isset( $_SESSION['session_cl'])){ echo  $_SESSION['session_cl']['email'];}} ?>">

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-password">Referencia<span class="text-danger"></span></label>
                            <div class="col-md-7">
                                <textarea  class="form-control"  name="referencia" placeholder="Referencia"><?php if(isset($email)){ echo $email;}else{ if(isset( $_SESSION['session_cl'])){ echo  $_SESSION['session_cl']['referencia'];}} ?></textarea>

                            </div>
                        </div>
                        <?php /* ?>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-password">Estado del cliente<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <label class="rad-inline" for="example-inline-checkbox1">
                                    <input type="radio" id="example-inline-checkbox1" name="estado" value="1" <?php if(isset( $_SESSION['session_cl'])){ if($_SESSION['session_cl']['estado'] == 1){ echo 'checked';} } ?> > Activa
                                </label>
                                <label class="rad-inline" for="example-inline-checkbox1">
                                    <input type="radio" id="example-inline-checkbox2" name="estado" value="0" <?php if(isset( $_SESSION['session_cl'])){ if($_SESSION['session_cl']['estado'] == 0){ echo 'checked';} } ?> > Inactiva
                                </label>

                            </div>
                        </div>
                        <?php */ ?>

                        <?php if(isset( $_SESSION['session_cl'])){?> <input type="hidden" name="confirmacion" value="1"> <?php } ?>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <?php if(isset($sql_insertar)){ ?> El registro fue realizado, usted sera redirecionado <?php }elseif(isset( $_SESSION['session_cl'])){?> <button class="btn btn-sm btn-primary" type="submit">Confirmar Registro</button> <?php }else{ ?> <button class="btn btn-sm btn-primary" type="submit">Registrar</button> <?php } ?>
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

        unset($_SESSION['session_cl']); ?>
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
