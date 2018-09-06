<?php if(!isset($_SESSION)){session_start();}?>
<?php require("conexion/conexion.php"); ?>
<?php require("funciones/funciones.php"); ?>
<?php if(isset($_SESSION['session_gc'])){ ?>
<?php $header_bar = 'base_header.php'; ?>
<?php $menu = true; ?>
<?php /* ################ AUDITORIA DE SEGUIMIENTO ############## */ ?>
<?php require("funciones/funciones_auditorias.php"); ?>
<?php $lugar_mapa = 26; ?>
<?php $dispositivo_acceso = obtener_dispositivo(); ?>
<?php insertar_log_seguimiento($conexion2, ObtenerIP(), $dispositivo_acceso, $lugar_mapa, $_SESSION['session_gc']['usua_id']); ?>
<?php /* ######################################################## */ ?>

<?php if(isset($_POST['confirmacion'])){ $sql_insertar = mysqli_query($conexion2, "update
                                                                                     maestro_inmuebles
                                                                                     set
                                                                                     mi_status = '".$_POST['estado']."'
                                                                                     where
                                                                                     id_inmueble = '".$_POST['id_inmueble']."'");

                                         $sql_insert_2 = mysqli_query($conexion2, "insert into inmueble_rv(id_tipo_rv,
                                                                                                          id_inmueble_maestro,
                                                                                                          id_cliente,
                                                                                                          rv_fecha,
                                                                                                          rv_observaciones,
                                                                                                          rv_precio_venta,
                                                                                                          rv_precio_reserva,
                                                                                                          id_vendedor,
                                                                                                          rv_status,
                                                                                                          rv_user_id
                                                                                                          )values(
                                                                                                          1,
                                                                                                          '".$_POST['id_inmueble']."',
                                                                                                          '".$_POST['id_cliente']."',
                                                                                                          NOW(),
                                                                                                          '".$_POST['observaciones_reserva']."',
                                                                                                          '".$_POST['precio_inmueble']."',
                                                                                                          '".$_POST['precio_reserva']."',
                                                                                                          '".$_POST['id_vendedor']."',
                                                                                                          1,
                                                                                                          '".$_SESSION['session_gc']['usua_id']."')");

                                                                                                                            }elseif(isset(
                                                                                                                        $_POST['id_inmueble'],
                                                                                                                            $_POST['grupo_inmueble'],
                                                                                                                        $_POST['tipo_inmueble'],
                                                                                                                    $_POST['modelo'],
                                                                                                                        $_POST['area'],
                                                                                                                            $_POST['habitaciones'],
                                                                                                                        $_POST['sanitarios'],
                                                                                                                    $_POST['depositos'])){

                                                                                             $session_reser = array('id_proyecto'=>$_POST['id_proyecto'],
                                                                                                                    'id_grupo_inmueble'=>$_POST['id_grupo_inmueble'],
                                                                                                                    'id_inmueble'=>$_POST['id_inmueble'],
                                                                                                                    'tipo_inmueble' => $_POST['tipo_inmueble'],
                                                                                                                    'modelo' =>$_POST['modelo'],
                                                                                                                    'area' => $_POST['area'],
                                                                                                                    'habitaciones' =>$_POST['habitaciones'],
                                                                                                                    'sanitarios' => $_POST['sanitarios'],
                                                                                                                    'depositos' =>$_POST['depositos'],
                                                                                                                    'observaciones' => $_POST['observaciones'],
                                                                                                                    'estacionamientos' =>$_POST['estacionamientos'],
                                                                                                                    'precio_inmueble' => $_POST['precio_inmueble'],
                                                                                                                    'partida_comision' =>$_POST['partida_comision'],
                                                                                                                    'porcentaje_comision' => $_POST['porcentaje_comision'],
                                                                                                                    'fecha_registro' =>$_POST['fecha_registro'],
                                                                                                                    'precio_reserva'=>$_POST['precio_reserva'],
                                                                                                                    'id_cliente' => $_POST['id_cliente'],
                                                                                                                    'id_vendedor' =>$_POST['id_vendedor'],
                                                                                                                    'observaciones_reserva' => $_POST['observaciones_reserva'],
                                                                                                                    'estado' =>$_POST['estado']);

                                                                                            $_SESSION['reserva'] = $session_reser;

                                 }elseif(isset($_POST['id_proyecto'],
                                                  $_POST['id_grupo_inmueble'],
                                                      $_POST['id_inmueble'])){

                                                        echo $_POST['id_proyecto'].'</br>';
                                                        echo $_POST['id_grupo_inmueble'].'</br>';
                                                        echo $_POST['id_inmueble'].'</br>';

                                  $session_inmueble = array('id_proyecto'=>$_POST['id_proyecto'],
                                                            'id_grupo_inmueble'=>$_POST['id_grupo_inmueble'],
                                                            'id_inmueble'=>$_POST['id_inmueble']);

                                  $_SESSION['session_inmueble'] = $session_inmueble;} ?>

<?php require 'inc/config.php'; ?>
<?php require 'inc/views/template_head_start.php'; ?>

<!-- Page JS Plugins CSS -->
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/select2/select2.min.css">
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/select2/select2-bootstrap.min.css">
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/sweetalert/sweetalert.min.css">
<script type="text/javascript" src="select_anidado3/js/jquery-1.3.2.min.js"></script>
<script type="text/javascript">

$(document).ready(function(){
  cargar_paises();
  $("#pais").change(function(){dependencia_estado();});
  $("#estado").change(function(){dependencia_ciudad();});
  $("#estado").attr("disabled",true);
  $("#ciudad").attr("disabled",true);
});

function cargar_paises()
{
  $.get("select_anidado3/scripts/cargar-paises.php", function(resultado){
    if(resultado == false)
    {
      alert("Error");
    }
    else
    {
      $('#pais').append(resultado);
    }
  });
}
function dependencia_estado()
{
  var code = $("#pais").val();
  $.get("select_anidado3/scripts/dependencia-estado.php", { code: code },
    function(resultado)
    {
      if(resultado == false)
      {
        alert("Error");
      }
      else
      {
        $("#estado").attr("disabled",false);
        document.getElementById("estado").options.length=1;
        $('#estado').append(resultado);
      }
    }
  );
}

function dependencia_ciudad()
{
  var code = $("#estado").val();
  $.get("select_anidado3/scripts/dependencia-ciudades.php?", { code: code }, function(resultado){
    if(resultado == false)
    {
      alert("Error");
    }
    else
    {
      $("#ciudad").attr("disabled",false);
      document.getElementById("ciudad").options.length=1;
      $('#ciudad').append(resultado);
    }
  });

}
</script>
<?php require 'inc/views/template_head_end.php'; ?>
<?php require 'inc/views/base_head.php'; ?>

<div class="content content-narrow">
    <!-- Forms Row -->
    <div class="row">

            <?php if(isset($sql_insertar)){ ?>
                    <!-- Success Alert -->
                    <div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h3 class="font-w300 push-15">Reservado</h3>
                        <p>El <a class="alert-link" href="javascript:void(0)">Inmueble</a> fue Reservado!</p>
                    </div>
                    <!-- END Success Alert -->
            <?php } ?>

        <div class="col-lg-12">
            <!-- Bootstrap Forms Validation -->
            <div class="block">
                <div class="block-header">
                    <ul class="block-options">
                        <li>

                        </li>
                    </ul>
                    <h3 class="block-title">Reservar Inmueble</h3><small> Los campos con <span class="text-danger">*</span> son obligatorios</small>
                </div>
                <div class="block-content block-content-narrow">
                    <!-- jQuery Validation (.js-validation-bootstrap class is initialized in js/pages/base_forms_validation.js) -->
                    <!-- For more examples you can check out https://github.com/jzaefferer/jquery-validation -->
                    <form class="js-validation-bootstrap form-horizontal" action="" method="post">
                      <div class="form-group">
                          <label class="col-md-4 control-label" for="val-username">Proyecto<span class="text-danger">*</span></label>
                          <div class="col-md-7">

                             <?php if(isset($_SESSION['session_inmueble'])){ ?>

                               <select name="id_proyecto" class="js-select2 form-control">
                                  <?php $sql_id_proyecto = $conexion2 -> query("select id_proyecto, proy_nombre_proyecto from maestro_proyectos where id_proyecto = '".$_SESSION['session_inmueble']['id_proyecto']."'");
                                        while($lista_proyectos = $sql_id_proyecto -> fetch_array()){
                                              $id_proyecto = $lista_proyectos['id_proyecto'];
                                              $nombre_proyecto = $lista_proyectos['proy_nombre_proyecto'];} ?>
                                  <option value="<?php echo $id_proyecto; ?>"><?php echo $nombre_proyecto; ?></option>
                               </select>
                              <?php }elseif(isset($_SESSION['reserva'])){ ?>
                              <select name="id_proyecto" class="js-select2 form-control">
                                 <?php $sql_id_proyecto = $conexion2 -> query("select id_proyecto, proy_nombre_proyecto from maestro_proyectos where id_proyecto = '".$_SESSION['reserva']['id_proyecto']."'");
                                       while($lista_proyectos = $sql_id_proyecto -> fetch_array()){
                                             $id_proyecto = $lista_proyectos['id_proyecto'];
                                             $nombre_proyecto = $lista_proyectos['proy_nombre_proyecto'];} ?>
                                 <option value="<?php echo $id_proyecto; ?>"><?php echo $nombre_proyecto; ?></option>
                              </select>
                              <?php }else{ ?>
                                <select id="pais" name="id_proyecto" class="js-select2 form-control" style="width: 100%;">
                                             <option value="0">Selecciona Uno...</option>
                                </select>
                              <?php } ?>
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-md-4 control-label" for="val-username">Grupo de inmueble <span class="text-danger">*</span></label>
                          <div class="col-md-7">

                            <?php if(isset($_SESSION['session_inmueble'])){ ?>

                              <select name="id_grupo_inmueble" class="js-select2 form-control">
                                  <?php $sql_grupo_inmueble = $conexion2 -> query("select id_grupo_inmuebles, gi_nombre_grupo_inmueble from grupo_inmuebles where id_grupo_inmuebles = '".$_SESSION['session_inmueble']['id_grupo_inmueble']."'");
                                        while($lista_grupo_inmueble = $sql_grupo_inmueble -> fetch_array()){
                                          $id_grupo = $lista_grupo_inmueble['id_grupo_inmuebles'];
                                          $nombre_grupo = $lista_grupo_inmueble['gi_nombre_grupo_inmueble'];} ?>
                              <option value="<?php echo $id_grupo; ?>"><?php echo $nombre_grupo; ?></option>
                              </select>
                              <?php }elseif(isset($_SESSION['reserva'])){ ?>
                              <select name="id_grupo_inmueble" class="js-select2 form-control">
                                  <?php $sql_grupo_inmueble = $conexion2 -> query("select id_grupo_inmuebles, gi_nombre_grupo_inmueble from grupo_inmuebles where id_grupo_inmuebles = '".$_SESSION['reserva']['id_grupo_inmueble']."'");
                                        while($lista_grupo_inmueble = $sql_grupo_inmueble -> fetch_array()){
                                          $id_grupo = $lista_grupo_inmueble['id_grupo_inmuebles'];
                                          $nombre_grupo = $lista_grupo_inmueble['gi_nombre_grupo_inmueble'];} ?>
                              <option value="<?php echo $id_grupo; ?>"><?php echo $nombre_grupo; ?></option>
                              </select>
                              <?php }else{ ?>
                             <select id="estado" name="id_grupo_inmueble" class="js-select2 form-control" style="width: 100%;">
                                <option value="0">Selecciona Uno...</option>
                             </select>
                             <?php } ?>
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-md-4 control-label" for="val-username">Inmueble<span class="text-danger">*</span></label>
                          <div class="col-md-7">

                            <?php if(isset($_SESSION['session_inmueble'])){ ?>

                              <select name="id_inmueble" class="js-select2 form-control">
                                  <?php $sql_inmueble = $conexion2 -> query("select id_inmueble, mi_nombre from maestro_inmuebles where id_inmueble = '".$_SESSION['session_inmueble']['id_inmueble']."'");
                                        while($lista_inmueble = $sql_inmueble -> fetch_array()){
                                          $id_inmueble = $lista_inmueble['id_inmueble'];
                                          $nombre_inmueble = $lista_inmueble['mi_nombre'];} ?>
                              <option value="<?php echo $id_inmueble; ?>"><?php echo $nombre_inmueble; ?></option>
                              </select>
                              <?php }elseif(isset($_SESSION['reserva'])){ ?>
                                <select name="id_inmueble" class="js-select2 form-control">
                                    <?php $sql_inmueble = $conexion2 -> query("select id_inmueble, mi_nombre from maestro_inmuebles where id_inmueble = '".$_SESSION['reserva']['id_inmueble']."'");
                                          while($lista_inmueble = $sql_inmueble -> fetch_array()){
                                            $id_inmueble = $lista_inmueble['id_inmueble'];
                                            $nombre_inmueble = $lista_inmueble['mi_nombre'];} ?>
                                <option value="<?php echo $id_inmueble; ?>"><?php echo $nombre_inmueble; ?></option>
                                </select>
                              <?php }else{ ?>
                             <select id="ciudad" name="id_inmueble" class="js-select2 form-control" style="width: 100%;" onchange="this.form.submit()">
                                  <option value="0">Selecciona Uno...</option>
                             </select>
                             <?php } ?>
                          </div>
                      </div>
                    </form>

                    <?php if(isset($_POST['id_inmueble'])){

                                $result_inmuebles = inmuebles_id($conexion2, $_POST['id_inmueble']);

                                    while($fila_inmuebles = $result_inmuebles->fetch_array()){

                                            $id_inmuble = $fila_inmuebles['id_inmueble'];
                                            $nombre_inmueble = $fila_inmuebles['mi_nombre'];
                                            $modelo_inmueble = $fila_inmuebles['mi_modelo'];
                                            $area_inmueble = $fila_inmuebles['mi_area'];
                                            $habitaciones_inmuebles = $fila_inmuebles['mi_habitaciones'];
                                            $sanitarios_inmuebles = $fila_inmuebles['mi_sanitarios'];
                                            $depositos_inmuebles = $fila_inmuebles['mi_depositos'];
                                            $estacionamientos_inmuebles = $fila_inmuebles['mi_estacionamientos'];
                                            $observaciones_inmmuebles = $fila_inmuebles['mi_observaciones'];
                                            $precio_inmuebles = $fila_inmuebles['mi_precio_real'];
                                            $partida_comision_inmuebles = $fila_inmuebles['mi_id_partida_comision'];
                                            $porcentaje_comision_inmuebles = $fila_inmuebles['mi_porcentaje_comision'];
                                            $fecha_registro_inmuebles = $fila_inmuebles['mi_fecha_registro'];
                                            $estatus_nombre_inmuebles = $fila_inmuebles['st_nombre'];
                                            $nombre_grupo_inmuebles = $fila_inmuebles['gi_nombre_grupo_inmueble'];
                                            $tipo_nombre_inmuebles = $fila_inmuebles['im_nombre_inmueble'];
                                            $status_inmuebles = $fila_inmuebles['mi_status'];

                                            }

                    } ?>

                    <form class="js-validation-bootstrap form-horizontal" action="" method="post">

                      <?php /* ################################ input hidden de las variables ################################ */ ?>

                      <input type="hidden" name="id_proyecto" value="<?php echo $_POST['id_proyecto']; ?>" >
                      <input type="hidden" name="id_grupo_inmueble" value="<?php echo $_POST['id_grupo_inmueble']; ?>" >
                      <input type="hidden" name="id_inmueble" value="<?php echo $_POST['id_inmueble']; ?>" >

                      <?php unset($_SESSION['session_inmueble']); ?>

                      <?php /* ############################################################################################### */ ?>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-username">Id<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                               <input class="form-control" type="text" name="id_inmueble" placeholder="Id inmueble" readonly="readonly" value="<?php if(isset($id_inmuble)){ echo $id_inmuble;}elseif(isset($_SESSION['reserva']['id_inmueble'])){ echo $_SESSION['reserva']['id_inmueble'];} ?>">
                            </div>
                        </div>
                        <div class="form-group" style="display: none">
                            <label class="col-md-4 control-label" for="val-username">Grupo de inmueble<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                               <input class="form-control" type="text"  name="grupo_inmueble" placeholder="Nombre" readonly="readonly" value="<?php if(isset($nombre_grupo_inmuebles)){ echo $nombre_grupo_inmuebles;}elseif(isset($_SESSION['reserva']['grupo_inmueble'])){ echo $_SESSION['reserva']['grupo_inmueble'];} ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-username">Tipo de inmueble<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                               <input class="form-control" type="text"  name="tipo_inmueble" placeholder="Nombre" readonly="readonly" value="<?php if(isset($tipo_nombre_inmuebles)){ echo $tipo_nombre_inmuebles;}elseif(isset($_SESSION['reserva']['tipo_inmueble'])){ echo $_SESSION['reserva']['tipo_inmueble'];} ?>">
                            </div>
                        </div>
                        <div class="form-group" style="display: none">
                            <label class="col-md-4 control-label" for="val-username">Nombre inmueble<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                               <input class="form-control" type="text"  name="nombre_inmueble" placeholder="Nombre Inmueble" readonly="readonly" value="<?php if(isset($nombre_inmueble)){ echo $nombre_inmueble;}elseif(isset($_SESSION['reserva']['nombre_inmueble'])){ echo $_SESSION['reserva']['nombre_inmueble']; } ?>">

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-email">Modelo<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                 <input class="form-control" type="text"  name="modelo" placeholder="Modelo" readonly="readonly" value="<?php if(isset($modelo_inmueble)){ echo $modelo_inmueble;}elseif(isset($_SESSION['reserva']['modelo'])){} ?>">

                            </div>

                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-password">Area<span class="text-danger">*</span></label>
                            <div class="col-md-7">

                                <input class="form-control" type="text"  name="area" placeholder="Area" readonly="readonly" value="<?php if(isset($area_inmueble)){ echo $area_inmueble;}elseif(isset($_SESSION['reserva']['area'])){ echo $_SESSION['reserva']['area'];} ?>">

                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-password">Habitaciones<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <input class="form-control" type="text"  name="habitaciones" placeholder="Habitaciones" readonly="readonly" value="<?php if(isset($habitaciones_inmuebles)){ echo $habitaciones_inmuebles;}elseif(isset($_SESSION['reserva']['habitaciones'])){ echo $_SESSION['reserva']['habitaciones'];} ?>">

                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-password">Sanitarios</label>
                            <div class="col-md-7">
                                <input class="form-control" type="text"  name="sanitarios" placeholder="Saniitarios" readonly="readonly" value="<?php if(isset($sanitarios_inmuebles)){ echo $sanitarios_inmuebles;}elseif(isset($_SESSION['reserva']['sanitarios'])){ echo $_SESSION['reserva']['sanitarios'];} ?>">

                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-password">Depositos<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <input class="form-control" type="text"  name="depositos" placeholder="Depositos" readonly="readonly" value="<?php if(isset($depositos_inmuebles)){ echo $depositos_inmuebles;}elseif(isset($_SESSION['reserva']['depositos'])){ $_SESSION['reserva']['depositos']; } ?>">

                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-password">Estacionamientos<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <input class="form-control" type="text"  name="estacionamientos" placeholder="Estacionamientos" readonly="readonly" value="<?php if(isset($estacionamientos_inmuebles)){ echo $estacionamientos_inmuebles;}elseif(isset($_SESSION['reserva']['estacionamientos'])){ echo $_SESSION['reserva']['estacionamientos'];} ?>">

                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-password">Observaciones<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <textarea class="form-control" type="text"  name="observaciones" placeholder="Observaciones" readonly="readonly"><?php if(isset($observaciones_inmmuebles)){ echo $observaciones_inmmuebles;}elseif(isset($_SESSION['reserva']['observaciones'])){ echo $_SESSION['reserva']['observaciones'];} ?></textarea>

                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-password">Precio<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <input class="form-control" type="text"  name="precio_inmueble" placeholder="Precio" readonly="readonly" value="<?php if(isset($precio_inmuebles)){ echo $precio_inmuebles;}elseif(isset($_SESSION['reserva']['precio_inmueble'])){ echo $_SESSION['reserva']['precio_inmueble'];} ?>">

                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-password">Partida Comision</label>
                            <div class="col-md-7">
                                <input class="form-control" type="text"  name="partida_comision" placeholder="Partida Comision" readonly="readonly" value="<?php if(isset($partida_comision_inmuebles)){ echo $partida_comision_inmuebles;}elseif(isset($_SESSION['reserva']['partida_comision'])){ echo $_SESSION['reserva']['partida_comision'];} ?>">

                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-password">Porcentaje Comision</label>
                            <div class="col-md-7">
                                <input class="form-control" type="text"  name="porcentaje_comision" placeholder="Porcentaje Comision" readonly="readonly" value="<?php if(isset($porcentaje_comision_inmuebles)){ echo $porcentaje_comision_inmuebles;}elseif(isset($_SESSION['reserva']['porcentaje_comision'])){ echo $_SESSION['reserva']['porcentaje_comision'];} ?>">

                            </div>
                        </div>

                       <div class="form-group">
                            <label class="col-md-4 control-label" for="val-password">Fecha de registro del inmueble<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <input class="form-control" type="text"  name="fecha_registro" placeholder="Fecha Registro" readonly="readonly" value="<?php if(isset($fecha_registro_inmuebles)){ echo $fecha_registro_inmuebles;}elseif(isset($_SESSION['reserva']['fecha_registro'])){ echo $_SESSION['reserva']['fecha_registro'];} ?>">

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-password">Precio de reserva<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <input class="form-control" type="number" max="<?php if(isset($precio_inmuebles)){ echo $precio_inmuebles;}elseif(isset($_SESSION['reserva']['precio_inmueble'])){ echo $_SESSION['reserva']['precio_inmueble'];} ?> " name="precio_reserva" placeholder="Precio reserva" require="require" value="<?php if(isset($_SESSION['reserva']['precio_reserva'])){ echo $_SESSION['reserva']['precio_reserva'];} ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-username">Cliente</label>
                            <div class="col-md-7">
                                <select class="js-select2 form-control" name="id_cliente" style="width: 100%;" require="require" data-placeholder="Seleccionar un Cliente">
                                    <option value=""> Selecciona un Cliente</option>
                                    <?php
                                            $result = todos_clientes_activos($conexion2);
                                            $opciones = '<option value=""> Elige un Cliente </option>';
                                            while($fila = $result->fetch_array()){ ?>
                                                    <option value="<?php echo $fila['id_cliente']; ?>" <?php if(isset($_SESSION['reserva']['id_cliente'])){
                                                                                                                    if($_SESSION['reserva']['id_cliente'] == $fila['id_cliente']){
                                                                                                                        echo 'selected';}} ?> ><?php echo $fila['cl_nombre'].' '.$fila['cl_apellido']; ?></option>
                                    <?php  } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-username">Vendedor</label>
                            <div class="col-md-7">
                                <select class="js-select2 form-control" name="id_vendedor" style="width: 100%;" require="require" data-placeholder="Seleccionar un Vendedor">
                                    <option value=""> Selecciona un Vendedor</option>
                                    <?php
                                            $result = todos_vendedores($conexion2);
                                            $opciones = '<option value=""> Elige un Vendedor </option>';
                                            while($fila = $result->fetch_array()){ ?>
                                                    <option value="<?php echo $fila['id_vendedor']; ?>" <?php if(isset($_SESSION['reserva']['id_vendedor'])){
                                                                                                                    if($_SESSION['reserva']['id_vendedor'] == $fila['id_vendedor']){
                                                                                                                        echo 'selected';}} ?> ><?php echo $fila['ven_nombre'].' '.$fila['ven_apellido']; ?></option>
                                    <?php  } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-password">Observaciones de reserva<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <textarea class="form-control" type="text"  name="observaciones_reserva" placeholder="Observaciones de reserva"><?php if(isset($_SESSION['reserva']['observaciones_reserva'])){ echo $_SESSION['reserva']['observaciones_reserva'];} ?></textarea>

                            </div>
                        </div>
                            <input type="hidden" name="estado" value="2">

                        <?php if(isset( $_SESSION['reserva'])){?> <input type="hidden" name="confirmacion" value="1"> <?php } ?>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <?php if(isset($sql_insertar)){ ?> El registro fue realizado, usted sera redirecionado <?php }elseif(isset( $_SESSION['reserva'])){?> <button class="btn btn-sm btn-primary" type="submit">Confirmar Registro</button> <?php }else{ ?> <button class="btn btn-sm btn-primary" type="submit">Registrar</button> <?php } ?>
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

        unset($_SESSION['reserva']); ?>

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
