<?php if(!isset($_SESSION)){session_start();}?>
<?php require("conexion/conexion.php"); ?>
<?php require("funciones/funciones.php"); ?>
<?php if(isset($_SESSION['session_gc'])){ ?>
<?php $header_bar = 'base_header.php'; ?>
<?php $menu = true; ?>
<?php /* ################ AUDITORIA DE SEGUIMIENTO ############## */ ?>
<?php require("funciones/funciones_auditorias.php"); ?>
<?php $lugar_mapa = 18; ?>
<?php $dispositivo_acceso = obtener_dispositivo(); ?>
<?php insertar_log_seguimiento($conexion2, ObtenerIP(), $dispositivo_acceso, $lugar_mapa, $_SESSION['session_gc']['usua_id']); ?>
<?php /* ######################################################## */ ?>

<?php if(isset($_POST['confirmacion'])){ $sql_insertar = mysqli_query($conexion2, "insert into maestro_inmuebles(id_proyecto,
                                                                                                                 id_grupo_inmuebles,
                                                                                                                 id_tipo_inmuebles,
                                                                                                                 mi_nombre,
                                                                                                                 mi_modelo,
                                                                                                                 mi_area,
                                                                                                                 mi_habitaciones,
                                                                                                                 mi_sanitarios,
                                                                                                                 mi_depositos,
                                                                                                                 mi_estacionamientos,
                                                                                                                 mi_observaciones,
                                                                                                                 mi_precio_real,
                                                                                                                 mi_disponible,
                                                                                                                 mi_id_partida_comision,
                                                                                                                 mi_porcentaje_comision,
                                                                                                                 mi_fecha_registro,
                                                                                                                 mi_status,
                                                                                                                 mi_log_user,
                                                                                                                 mi_codigo_imueble
                                                                                                                  )values(
                                                                                                                  '".$_POST['id_proyecto']."',
                                                                                                                  '".strtoupper($_POST['id_grupo_inmuebles'])."',
                                                                                                                  '".strtoupper($_POST['tipo_inmuebles'])."',
                                                                                                                  '".strtoupper($_POST['nombre'])."',
                                                                                                                  '".strtoupper($_POST['modelo'])."',
                                                                                                                  '".strtoupper($_POST['area'])."',
                                                                                                                  '".strtoupper($_POST['habitaciones'])."',
                                                                                                                  '".strtoupper($_POST['banios'])."',
                                                                                                                  '".strtoupper($_POST['depositos'])."',
                                                                                                                  '".strtoupper($_POST['estacionamientos'])."',
                                                                                                                  '".strtoupper($_POST['observaciones'])."',
                                                                                                                  '".strtoupper($_POST['precio'])."',
                                                                                                                  1,
                                                                                                                  '".strtoupper($_POST['partida_comision'])."',
                                                                                                                  '".strtoupper($_POST['porcentaje_comision'])."',
                                                                                                                  NOW(),
                                                                                                                  1,
                                                                                                                  '".$_SESSION['session_gc']['usua_id']."',
                                                                                                                  '".$_POST['codigo_inmueble']."')");

############################# Auditoria ##############################

                     $recuperar_id_inmueble = $conexion2 -> query("SELECT MAX(id_inmueble) AS id FROM maestro_inmuebles");
                             while($id_inmueble = $recuperar_id_inmueble -> fetch_array()){
                                     $id_inmueble_recuperado = $id_inmueble['id'];}

                     $tipo_operacion = 1;
                     $comentario = "Registro de Inmueble";
                     $sql_insertar_auditoria = $conexion2 -> query("insert into auditoria_inmueble(id_auditoria_proyecto,
                                                                                                   aui_tipo_operacion,
                                                                                                   aui_usua_log,
                                                                                                   aui_comentario,
                                                                                                   aui_id_inmueble,
                                                                                                   aui_id_grupo_inmuebles,
                                                                                                   aui_id_tipo_inmuebles,
                                                                                                   aui_mi_nombre,
                                                                                                   aui_mi_modelo,
                                                                                                   aui_mi_area,
                                                                                                   aui_mi_habitaciones,
                                                                                                   aui_mi_sanitarios,
                                                                                                   aui_mi_depositos,
                                                                                                   aui_mi_estacionamientos,
                                                                                                   aui_mi_observaciones,
                                                                                                   aui_mi_precio_real,
                                                                                                   aui_mi_disponible,
                                                                                                   aui_mi_id_partida_comision,
                                                                                                   aui_mi_porcentaje_comision,
                                                                                                   aui_mi_status
                                                                                                   )values(
                                                                                                   '".$_POST['id_proyecto']."',
                                                                                                   '".$tipo_operacion."',
                                                                                                   '".$_SESSION['session_gc']['usua_id']."',
                                                                                                   '".$comentario."',
                                                                                                   '".$id_inmueble_recuperado."',
                                                                                                   '".$_POST['id_grupo_inmuebles']."',
                                                                                                   '".$_POST['tipo_inmuebles']."',
                                                                                                   '".$_POST['nombre']."',
                                                                                                   '".$_POST['modelo']."',
                                                                                                   '".$_POST['area']."',
                                                                                                   '".$_POST['habitaciones']."',
                                                                                                   '".$_POST['banios']."',
                                                                                                   '".$_POST['depositos']."',
                                                                                                   '".$_POST['estacionamientos']."',
                                                                                                   '".$_POST['observaciones']."',
                                                                                                   '".$_POST['precio']."',
                                                                                                   1,
                                                                                                   '".$_POST['partida_comision']."',
                                                                                                   '".$_POST['porcentaje_comision']."',
                                                                                                   1)");
#######################################################################

}elseif(isset($_POST['id_grupo_inmuebles'],
                    $_POST['tipo_inmuebles'],
                        $_POST['nombre'],
                        $_POST['modelo'],
                    $_POST['area'],
                $_POST['habitaciones'])){

                $session_mi = array('id_grupo_inmuebles'=>$_POST['id_grupo_inmuebles'],
                                      'id_proyecto'=>$_POST['id_proyecto'],
                                        'tipo_inmuebles'=>$_POST['tipo_inmuebles'],
                                            'nombre'=>$_POST['nombre'],
                                                'modelo'=>$_POST['modelo'],
                                                    'area'=>$_POST['area'],
                                                'habitaciones'=>$_POST['habitaciones'],
                                            'banios'=>$_POST['banios'],
                                        'depositos'=>$_POST['depositos'],
                                    'estacionamientos'=>$_POST['estacionamientos'],
                                'observaciones'=>$_POST['observaciones'],
                                    'precio'=>$_POST['precio'],
                                        'partida_comision'=>$_POST['partida_comision'],
                                            'porcentaje_comision'=>$_POST['porcentaje_comision'],
                                          'codigo_inmueble' =>$_POST['codigo_inmueble']);

                $_SESSION['session_mi']=$session_mi; } ?>

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
                    url:"select_anidado_inmueble/procesa_grupo_inmueble.php",
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
                        <p>El <a class="alert-link" href="javascript:void(0)">Inmueble</a> fue registrado!</p>
                    </div>

            <?php } ?>
    <!--<div class="col-lg-3"></div>-->
        <div class="col-lg-12">
            <!-- Bootstrap Forms Validation -->
            <div class="block">
                <div class="block-header">
                    <ul class="block-options">
                        <li>
                        </li>
                    </ul>
                    <h3 class="block-title">Registrar Inmueble</h3><small> Los campos con <span class="text-danger">*</span> son obligatorios</small>
                </div>
                <div class="block-content block-content-narrow">
                    <!-- jQuery Validation (.js-validation-bootstrap class is initialized in js/pages/base_forms_validation.js) -->
                    <!-- For more examples you can check out https://github.com/jzaefferer/jquery-validation -->
                    <form class="js-validation-bootstrap form-horizontal" action="" method="post">
                      <div class="form-group">
                          <label class="col-md-4 control-label" for="val-username">Proyecto<span class="text-danger">*</span></label>
                          <div class="col-md-7">
                              <select id="marca" class="js-select2 form-control" name="id_proyecto" style="width: 100%;" required="required">
                                  <option value=""> Selecciona un proyecto</option>
                                  <?php
                                          $strConsulta = "select id_proyecto, proy_nombre_proyecto from maestro_proyectos where proy_estado = 1";
                                          $result = $conexion2->query($strConsulta);
                                          $opciones = '<option value="0"> Elige un proyecto</option>';
                                          while($fila = $result->fetch_array()){ ?>
                                                  <option value="<?php echo $fila['id_proyecto']; ?>" <?php if(isset( $_SESSION['session_mi'])){ if($_SESSION['session_mi']['id_proyecto'] == $fila['id_proyecto']){ echo 'selected';}} ?> ><?php echo $fila['proy_nombre_proyecto']; ?></option>
                                  <?php  } ?>
                              </select>
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-md-4 control-label" for="val-username">Grupo de inmueble  <span class="text-danger">*</span></label>
                          <div class="col-md-7">
                            <?php if(isset($_SESSION['session_mi'])){ ?>
                               <select id="modelo" class="js-select2 form-control" name="id_grupo_inmuebles" style="width: 100%;" data-placeholder="Seleccionar grupo inmueble" required="required">
                               <?php
                                      $opciones = '<option value=""> Elige un grupo de inmueble</option>';
                                      $strConsulta = "select id_grupo_inmuebles, gi_nombre_grupo_inmueble from grupo_inmuebles where id_grupo_inmuebles ='".$_SESSION['session_mi']['id_grupo_inmuebles']."'";
                                      $result = $conexion2->query($strConsulta);
                                      while( $fila = $result->fetch_array()){ ?>
                                      <option value="<?php echo $fila['id_grupo_inmuebles']; ?>" ><?php echo $fila['gi_nombre_grupo_inmueble']; ?></option>
                                      <?php } ?>
                              </select>
                              <?php }else{ ?>
                               <select id="modelo" class="js-select2 form-control" name="id_grupo_inmuebles" style="width: 100%;" data-placeholder="Seleccionar cuenta" required="required">
                                  <option value="0"></option>
                               </select>
                              <?php } ?>
                          </div>
                      </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-username">Codigo Inmueble <span class="text-danger">*</span></label>
                            <div class="col-md-7">
                               <input autocomplete="off" class="form-control" type="text"  name="codigo_inmueble" placeholder="Codigo inmueble" required="required" value="<?php if(isset($_SESSION['session_mi'])){ echo $_SESSION['session_mi']['codigo_inmueble'];} ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-username">Nombre <span class="text-danger">*</span></label>
                            <div class="col-md-7">
                               <input autocomplete="off" class="form-control" type="text"  name="nombre" placeholder="Nombre" required="required" value="<?php if(isset($nombre_comercial)){ echo $nombre_comercial;}else{ if(isset( $_SESSION['session_mi'])){ echo  $_SESSION['session_mi']['nombre'];}} ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-email">Precio<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                 <input autocomplete="off" class="form-control" type="number"  name="precio" placeholder="Precio" required="required" value="<?php if(isset($razon_social)){ echo $razon_social;}else{ if(isset( $_SESSION['session_mi'])){ echo  $_SESSION['session_mi']['precio'];}} ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-email">Modelo<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                 <input autocomplete="off" class="form-control" type="text"  name="modelo" placeholder="Modelo" required="required" value="<?php if(isset($razon_social)){ echo $razon_social;}else{ if(isset( $_SESSION['session_mi'])){ echo  $_SESSION['session_mi']['modelo'];}} ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-password">Area<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <input autocomplete="off" class="form-control" type="text" name="area" placeholder="Area" required="required" value="<?php if(isset($ruc)){ echo $ruc;}else{ if(isset( $_SESSION['session_mi'])){ echo  $_SESSION['session_mi']['area'];}} ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-username">Tipo<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <select class="js-select2 form-control" name="tipo_inmuebles" style="width: 100%;" data-placeholder="Seleccionar un tipo de inmueble" required="required">
                                    <option value=""> Selecciona tipo de inmueble</option>
                                    <?php
                                            $strConsulta = "select * from tipo_inmuebles where im_status = 1";
                                            $result = $conexion2->query($strConsulta);
                                            $opciones = '<option value="0"> Elige tipo de inmueble </option>';
                                            while($fila = $result->fetch_array()){ ?>
                                                    <option value="<?php echo $fila['id_inmuebles']; ?>" <?php if(isset( $_SESSION['session_mi'])){ if($_SESSION['session_mi']['tipo_inmuebles'] == $fila['id_inmuebles']){ echo 'selected';}} ?> ><?php echo $fila['im_nombre_inmueble']; ?></option>
                                    <?php  } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-password">Habitaciones</label>
                            <div class="col-md-7">
                                <select name="habitaciones" class="js-select2 form-control" required="required" style="width: 100%;">
                                    <option value="">Selecciona un numero</option>
                                    <?php for($i=0 ; $i <= 10; $i++){ ?>
                                    <option value="<?php echo $i; ?>" <?php if(isset($_SESSION['session_mi'])){ if($_SESSION['session_mi']['habitaciones'] == $i){ echo 'selected';}} ?> ><?php echo $i; ?></option>
                                    <?php }  ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-password">Baños</label>
                            <div class="col-md-7">
                                <select name="banios" class="js-select2 form-control" required="required" style="width: 100%;">
                                    <option value="">Selecciona un numero</option>
                                    <?php  for($i=0 ; $i <= 10; $i++){ ?>
                                        <option value="<?php echo $i; ?>" <?php if(isset($_SESSION['session_mi'])){ if($_SESSION['session_mi']['banios'] == $i){ echo 'selected';}} ?> ><?php echo $i; ?></option>
                                    <?php }  ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-password">Depositos</label>
                            <div class="col-md-7">
                                <select name="depositos" class="js-select2 form-control" required="required" style="width: 100%;">
                                    <option value="">Selecciona un numero</option>
                                    <?php  for($i=0 ; $i <= 10; $i++){ ?>
                                        <option value="<?php echo $i; ?>" <?php if(isset($_SESSION['session_mi'])){ if($_SESSION['session_mi']['depositos'] == $i){ echo 'selected';}} ?> ><?php echo $i; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-password">Estacionamientos</label>
                            <div class="col-md-7">
                                <select name="estacionamientos" class="js-select2 form-control" required="required" style="width: 100%;">
                                    <option value="">Selecciona un numero</option>
                                    <?php  for($i=0 ; $i <= 10; $i++){ ?>
                                        <option value="<?php echo $i; ?>" <?php if(isset($_SESSION['session_mi'])){ if($_SESSION['session_mi']['estacionamientos'] == $i){ echo 'selected';}} ?> ><?php echo $i; ?></option>
                                    <?php }  ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-password">Porc. Comision<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <input autocomplete="off" class="form-control" type="number" name="porcentaje_comision" placeholder="Porcentaje Comision" required="required" value="<?php if(isset($_SESSION['session_mi'])){ echo $_SESSION['session_mi']['porcentaje_comision'];}else{echo 5;} ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-password">Partida Comision<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                              <select class="js-select2 form-control" id="val-select2" name="partida_comision" style="width: 100%;" data-placeholder="Partida Comision" required="required">
                                  <option></option>
                                  <?php /* ############################################################# */ ?>

                                  <?php $sql = $conexion2 -> query("select * from maestro_partidas"); ?>

                                  <?php function recorer($conexion, $id_categoria){

                                   $sql_inter = $conexion -> query("select * from maestro_partidas where id = '".$id_categoria."'");
                                     while($l2=$sql_inter->fetch_array()){
                                            echo recorer($conexion, $l2['id_categoria']).' '.$l2['p_nombre'].' // ';
                                    }

                                  } ?>

                                  <?php function inter($conexion, $id){ ?>
                                  <?php $sql_inter = $conexion -> query("select * from maestro_partidas where id_categoria = '".$id."'"); ?>
                                  <?php $contar=$sql_inter->num_rows; ?>

                                  <?php if($contar==0){ return true; }else{ return false; } }?>


                                  <?php /* ############################################################# */ ?>
                                  <?php /*$sql_proyecto = crear_facturas($conexion2); ?>
                                  <?php while($lista_proyecto = $sql_proyecto -> fetch_array()){ ?>
                                  <?php $suma = $lista_partida['p_reservado'] + $lista_partida['p_ejecutado']; ?>
                                  <?php if($lista_partida['p_reservado'] != 0 && $lista_partida['p_ejecutado'] !=0 && $suma == $lista_partida['p_monto']){ continue; }*/ ?>

                                  <?php while($l=$sql->fetch_array()){
                                              $var = inter($conexion2, $l['id']);
                                              if($var==true){ ?>
                                              <option value="<?php echo $l['id']; ?>"
                                                <?php if(isset($_SESSION['session_mi'])){ if($_SESSION['session_mi']['partida_comision'] == $l['id']){echo 'selected';}} ?>
                                                > <?php echo recorer($conexion2, $l['id_categoria']).' // '.$l['p_nombre']; ?> </option>
                                      <?php      }
                                        } ?>

                                  <?php /*echo $lista_proyecto['proyecto'].' // '.$lista_proyecto['p_nombre'];  */ ?>

                                  <?php /*} */ ?>
                                  <?php /* $sql_proyecto = crear_facturas($conexion2); ?>
                                  <?php while($lista_proyecto = $sql_proyecto -> fetch_array()){ ?>
                                  <?php /*$suma = $lista_partida['p_reservado'] + $lista_partida['p_ejecutado']; ?>
                                  <?php if($lista_partida['p_reservado'] != 0 && $lista_partida['p_ejecutado'] !=0 && $suma == $lista_partida['p_monto']){ continue; }  ?>
                                  <option value="<?php echo $lista_proyecto['id']; ?>"
                                  <?php if(isset($_SESSION['session_mi'])){ if($_SESSION['session_mi']['partida_comision']==$lista_proyecto['id']){echo 'selected';}} ?>
                                  ><?php echo $lista_proyecto['proyecto'].' // '.$lista_proyecto['p_nombre']; ?></option>
                                  <?php } */?>
                              </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-password">Observaciones</label>
                            <div class="col-md-7">
                                <textarea class="form-control" name="observaciones" placeholder="Observaciones"><?php if(isset( $_SESSION['session_mi'])){ echo $_SESSION['session_mi']['observaciones'];} ?></textarea>
                            </div>
                        </div>

                        <?php if(isset( $_SESSION['session_mi'])){?> <input type="hidden" name="confirmacion" value="1"> <?php } ?>
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <?php if(isset($sql_insertar)){ ?> El registro fue realizado, usted sera redirecionado <?php }elseif(isset( $_SESSION['session_mi'])){?> <button class="btn btn-sm btn-primary" type="submit">Confirmar Registro</button> <?php }else{ ?> <button class="btn btn-sm btn-primary" type="submit">Registrar</button> <?php } ?>
                            </div>
                        </div>
                    </form>
            </div>
            <!-- Bootstrap Forms Validation -->
        </div>
    </div>
</div>

<?php if(isset($sql_insertar)){

        unset($_SESSION['session_mi']); ?>

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
