<?php if(!isset($_SESSION)){session_start();}?>
<?php require("conexion/conexion.php"); ?>
<?php require("funciones/funciones.php"); ?>
<?php if(isset($_SESSION['session_gc'])){ ?>
<?php $header_bar = 'base_header.php'; ?>
<?php $menu = true; ?>
<?php /* ################ AUDITORIA DE SEGUIMIENTO ############## */ ?>
<?php require("funciones/funciones_auditorias.php"); ?>
<?php $lugar_mapa = 28; ?>
<?php $dispositivo_acceso = obtener_dispositivo(); ?>
<?php insertar_log_seguimiento($conexion2, ObtenerIP(), $dispositivo_acceso, $lugar_mapa, $_SESSION['session_gc']['usua_id']); ?>
<?php /* ######################################################## */ ?>

<?php if (isset($_POST['registrar_cliente'])) {
    $registrar_cl = $conexion2 -> query("INSERT INTO maestro_clientes(cl_pais,
                                                                      cl_nombre,
                                                                      cl_apellido,
                                                                      cl_identificacion,
                                                                      cl_telefono_1,
                                                                      cl_status
                                                                      )VALUES('".$_POST['id_pais']."',
                                                                              '".$_POST['nombre']."',
                                                                              '".$_POST['apellido']."',
                                                                              '".$_POST['identificacion']."',
                                                                              '".$_POST['telefono_1']."',
                                                                              1)");
} ?>

<?php    if(isset($_POST['confirmacion'])){
            if($_POST['reserva']==1){
      /* ################ INSERT CUANDO EL INMUEBLE ESTE RESERVADO ############## */
                $sql_insertar = $conexion2 -> query("insert into maestro_ventas(id_proyecto,
                                                                                id_grupo_inmueble,
                                                                                id_inmueble,
                                                                                mv_precio_venta,
                                                                                id_cliente,
                                                                                mv_descripcion,
                                                                                mv_reserva,
                                                                                mv_id_reserva,
                                                                                mv_status
                                                                                )values(
                                                                                '".$_POST['id_proyecto']."',
                                                                                '".$_POST['id_grupo_inmueble']."',
                                                                                '".$_POST['id_inmueble']."',
                                                                                '".$_POST['precio_venta']."',
                                                                                '".$_POST['id_cliente']."',
                                                                                '".$_POST['descripcion']."',
                                                                                '".$_POST['reserva']."',
                                                                                '".$_POST['id_reserva']."',
                                                                                1)");
      /* ################ CAMBIO DE ESTATUS DEL INMUEBLE ############## */
            if($sql_insertar){

              $sql_update_inmuebles = $conexion2 -> query("update maestro_inmuebles set mi_status = 3 where id_inmueble = '".$_POST['id_inmueble']."'");

            }

              if(isset($_SESSION['session_ventas_reserva'])){

                $obtener_id_insertado = $conexion2->query("select max(id_venta) as id from maestro_ventas");
                  while($lista_id = $obtener_id_insertado->fetch_array()){

                        $id=$lista_id['id'];

                  }

                    $insertar_cuota_reserva = $conexion2 ->query("insert into maestro_cuotas(id_contrato_venta,
                                                                                             id_proyecto,
                                                                                             id_grupo,
                                                                                             id_inmueble,
                                                                                             mc_descripcion,
                                                                                             id_tipo_cuota,
                                                                                             mc_monto,
                                                                                             mc_status
                                                                                             )values(
                                                                                             '".$id."',
                                                                                             '".$_POST['id_proyecto']."',
                                                                                             '".$_POST['id_grupo_inmueble']."',
                                                                                             '".$_POST['id_inmueble']."',
                                                                                             '".$_POST['descripcion']."',
                                                                                             1,
                                                                                             '".$_POST['precio_reserva']."',
                                                                                             1)");

              }

            }elseif($_POST['reserva']==0){
      /* ################ INSERT CUANDO EL INMUEBLE NO ESTA RESERVADO ############## */
                $sql_insertar = $conexion2 -> query("insert into maestro_ventas(id_proyecto,
                                                                                id_grupo_inmueble,
                                                                                id_inmueble,
                                                                                mv_precio_venta,
                                                                                id_cliente,
                                                                                mv_descripcion,
                                                                                mv_reserva,
                                                                                mv_status
                                                                                )values(
                                                                                '".$_POST['id_proyecto']."',
                                                                                '".$_POST['id_grupo_inmueble']."',
                                                                                '".$_POST['id_inmueble']."',
                                                                                '".$_POST['precio_venta']."',
                                                                                '".$_POST['id_cliente']."',
                                                                                '".$_POST['descripcion']."',
                                                                                '".$_POST['reserva']."',
                                                                                1)");


      /* ################ CAMBIO DE PRECIO DE INMUEBLE ############## */
      if($_POST['id_proyecto'] == 13){
              $sql_update_inmuebles_costo = $conexion2 -> query("update maestro_inmuebles set mi_precio_venta = '".$_POST['precio_venta']."', mi_precio_real = '".$_POST['precio_venta']."' where id_inmueble = '".$_POST['id_inmueble']."'");}
      /* ################ CAMBIO DE ESTATUS DEL INMUEBLE ############## */
              $sql_update_inmuebles = $conexion2 -> query("update maestro_inmuebles set mi_status = 3 where id_inmueble = '".$_POST['id_inmueble']."'");}
      /* ################ VARIABLES DE SESSION PARA 2 ESTATUS DISTINTOS, SI ESTA RESERVADO EL INMUEBLE O NO ESTA RESERVADO ############## */
      /* ################ RESERVA = 1 -> RSERVADO #### RESERVA = 0 -> NO RESERVADO ############## */
           }elseif(isset($_POST['id_proyecto'],
                              $_POST['id_grupo_inmueble'],
                                  $_POST['id_inmueble'],
                                      $_POST['precio_venta'],
                                          $_POST['id_cliente'],
                                              $_POST['descripcion'],
                                                  $_POST['reserva'])){

                  if($_POST['reserva']==1){

                  $session_ventas_reserva = array('id_proyecto'=>$_POST['id_proyecto'],
                                                  'id_grupo_inmueble'=>$_POST['id_grupo_inmueble'],
                                                  'id_inmueble'=>$_POST['id_inmueble'],
                                                  'precio_venta'=>$_POST['precio_venta'],
                                                  'id_cliente'=>$_POST['id_cliente'],
                                                  'descripcion'=>$_POST['descripcion'],
                                                  'reserva'=>$_POST['reserva']);

                    $_SESSION['session_ventas_reserva'] = $session_ventas_reserva; }

                    elseif($_POST['reserva']==0){

                            $session_ventas = array('id_proyecto'=>$_POST['id_proyecto'],
                                                    'id_grupo_inmueble'=>$_POST['id_grupo_inmueble'],
                                                    'id_inmueble'=>$_POST['id_inmueble'],
                                                    'precio_venta'=>$_POST['precio_venta'],
                                                    'id_cliente'=>$_POST['id_cliente'],
                                                    'descripcion'=>$_POST['descripcion'],
                                                    'reserva'=>$_POST['reserva']);

                               $_SESSION['session_ventas'] = $session_ventas;

                             }

} ?>
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

                    <div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h3 class="font-w300 push-15">Contrato de venta</h3>
                        <p>El <a class="alert-link" href="javascript:void(0)">Contrato de venta</a> registrado!</p>
                    </div>

            <?php } ?>
            <?php if(isset($registrar_cl)){ ?>

                    <div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h3 class="font-w300 push-15">Registro de Cliente</h3>
                        <p>El <a class="alert-link" href="javascript:void(0)">Cliente</a> se ha registrado!</p>
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
                    <h3 class="block-title">Registrar contrato de venta</h3><small> Los campos con <span class="text-danger">*</span> son obligatorios</small>
                </div>
                <div class="block-content block-content-narrow">
                    <!-- jQuery Validation (.js-validation-bootstrap class is initialized in js/pages/base_forms_validation.js) -->
                    <!-- For more examples you can check out https://github.com/jzaefferer/jquery-validation -->
                    <?php if(isset($_SESSION['session_ventas'])){
                            if($_SESSION['session_ventas']['reserva']==0){}}else{ ?>

                    <form class="js-validation-bootstrap form-horizontal" action="" method="post">
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-username">Reservado ?</label>
                            <div class="col-md-7">
                                <select class="js-select2 form-control" name="id_reserva" style="width: 100%;" require="require" data-placeholder="Seleccionar un inmueble reservado" onchange="this.form.submit()">
                                    <option value=""> Selecciona un inmueble reservado</option>
                                    <?php
                                            $result = reservas_inmuebles($conexion2);
                                            $opciones = '<option value=""> Elige un Inmueble </option>';
                                            while($fila = $result->fetch_array()){ ?>
                                                    <option value="<?php echo $fila['id_rv_inmueble']; ?>"
                                                    <?php if(isset($_POST['id_reserva'])){
                                                            if($_POST['id_reserva'] == $fila['id_rv_inmueble']){ echo 'selected';}
                                                    }elseif(isset($_SESSION['reserva']['id_reserva'])){
                                                        if($_SESSION['reserva']['id_reserva']== $fila['id_rv_inmueble']){ echo 'selected';}} ?>
                                                     ><?php echo $fila['mi_nombre'].' // '.$fila['cl_nombre'].' '.$fila['cl_apellido']; ?></option>
                                    <?php  } ?>
                                </select>
                            </div>
                        </div>
                    </form>
                    <?php } ?>
                    <?php if(isset($_POST['id_reserva'])){

                                $result_inmuebles = reservas_inmuebles_id($conexion2, $_POST['id_reserva']);

                                    while($fila_inmuebles = $result_inmuebles->fetch_array()){

                                            $id_proyecto = $fila_inmuebles['id_proyecto'];
                                            $id_grupo_inmuebles = $fila_inmuebles['id_grupo_inmuebles'];
                                            $id_reserva = $fila_inmuebles['id_rv_inmueble'];
                                            $rv_observaciones = $fila_inmuebles['rv_observaciones'];
                                            if(isset($_SESSION['session_ventas_reserva'])){}else{
                                            $rv_precio_venta = $fila_inmuebles['rv_precio_venta'];}
                                            $rv_precio_reserva = $fila_inmuebles['rv_precio_reserva'];
                                            $id_cliente = $fila_inmuebles['id_cliente'];
                                            $id_vendedor = $fila_inmuebles['id_vendedor'];
                                            $mi_nombre = $fila_inmuebles['mi_nombre'];
                                            $gi_nombre_grupo_inmueble = $fila_inmuebles['gi_nombre_grupo_inmueble'];
                                            $proy_nombre_proyecto = $fila_inmuebles['proy_nombre_proyecto'];
                                            $id_inmueble = $fila_inmuebles['id_inmueble'];

                                            }

                    } ?>

                    <form class="js-validation-bootstrap form-horizontal" action="" method="post">
                    <?php if(isset($_POST['id_reserva'])){ ?>

                        <input type="hidden" value="<?php echo $id_reserva; ?>" name="id_reserva">
                        <input type="hidden" value="1" name="reserva">
                        <input type="hidden" value="<?php echo $id_inmueble; ?>" name="id_inmueble">

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-username">Proyecto<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                               <input class="form-control" type="text" placeholder="Nombre proyecto" readonly="readonly"  value="<?php if(isset($proy_nombre_proyecto)){ echo $proy_nombre_proyecto;}elseif(isset($_SESSION['session_ventas_reserva'])){ echo $_SESSION['session_ventas_reserva']['id_proyecto'];} ?>">
                               <input type="hidden"  name="id_proyecto" value="<?php if(isset($id_proyecto)){ echo $id_proyecto;}elseif(isset($_SESSION['session_ventas_reserva']['id_proyecto'])){ echo $_SESSION['session_ventas_reserva']['id_proyecto'];} ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-username">Grupo de inmueble<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                               <input class="form-control" type="text" placeholder="Grupo inmuebles" readonly="readonly" value="<?php if(isset($gi_nombre_grupo_inmueble)){ echo $gi_nombre_grupo_inmueble;}elseif(isset($_SESSION['session_ventas_reserva']['id_grupo_inmueble'])){ echo $_SESSION['session_ventas_reserva']['id_grupo_inmueble'];} ?>">
                               <input type="hidden"  name="id_grupo_inmueble" value="<?php if(isset($id_grupo_inmuebles)){ echo $id_grupo_inmuebles;}elseif(isset($_SESSION['session_ventas_reserva']['id_grupo_inmueble'])){ echo $_SESSION['session_ventas_reserva']['id_grupo_inmueble'];} ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-username">Inmueble<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                               <input class="form-control" type="text" placeholder="Inmueble" readonly="readonly" value="<?php if(isset($mi_nombre)){ echo $mi_nombre;}elseif(isset($_SESSION['session_ventas_reserva']['id_inmueble'])){ echo $_SESSION['session_ventas_reserva']['id_inmueble'];} ?>">
                               <input type="hidden"  name="id_inmueble" value="<?php if(isset($id_inmueble)){ echo $id_inmueble;}elseif(isset($_SESSION['session_ventas_reserva']['id_inmueble'])){ echo $_SESSION['session_ventas_reserva']['id_inmueble'];} ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-username">Precio de Reserva<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                               <input class="form-control" type="number"  name="precio_reserva" placeholder="Nombre" require="require" value="<?php if(isset($rv_precio_reserva)){ echo $rv_precio_reserva;}elseif(isset($_SESSION['session_ventas_reserva']['precio_venta'])){ echo $_SESSION['session_ventas_reserva']['precio_venta'];} ?>">
                            </div>
                        </div>

                    <?php }else{ ?>

                        <input type="hidden" value="0" name="reserva">
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-username">Cliente</label>
                            <div class="col-md-6">
                                <select class="js-select2 form-control" name="id_cliente" style="width: 100%;" require="require" data-placeholder="Seleccionar un Cliente">
                                    <option value=""> Selecciona un Cliente</option>
                                    <?php
                                            $result = todos_clientes_activos($conexion2);
                                            $opciones = '<option value=""> Elige un Cliente </option>';
                                            while($fila = $result->fetch_array()){ ?>
                                                    <option value="<?php echo $fila['id_cliente']; ?>" <?php if(isset($_SESSION['session_ventas_reserva']['id_cliente'])){
                                                                                                                    if($_SESSION['session_ventas_reserva']['id_cliente'] == $fila['id_cliente']){
                                                                                                                        echo 'selected';}}
                                                                                                                elseif(isset($_SESSION['session_ventas']['id_cliente'])){
                                                                                                                    if($_SESSION['session_ventas']['id_cliente'] == $fila['id_cliente']){
                                                                                                                        echo 'selected';}} ?> ><?php echo $fila['cl_nombre'].' '.$fila['cl_apellido']; ?></option>
                                    <?php  } ?>
                                </select>
                            </div>
                            <button class="btn btn-default" style="float:left;" data-toggle="modal" data-target="#modal-popin" type="button"><i class="fa fa-user-plus"></i></button>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-username">Proyecto<span class="text-danger">*</span></label>
                            <div class="col-md-7">

                               <?php if(isset($_SESSION['session_ventas'])){ ?>

                                 <select name="id_proyecto" class="js-select2 form-control">
                                    <?php $sql_id_proyecto = $conexion2 -> query("select id_proyecto, proy_nombre_proyecto from maestro_proyectos where id_proyecto = '".$_SESSION['session_ventas']['id_proyecto']."' and id_proyecto not in(13)");
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

                              <?php if(isset($_SESSION['session_ventas'])){ ?>

                                <select name="id_grupo_inmueble" class="js-select2 form-control">
                                    <?php $sql_grupo_inmueble = $conexion2 -> query("select id_grupo_inmuebles, gi_nombre_grupo_inmueble from grupo_inmuebles where id_grupo_inmuebles = '".$_SESSION['session_ventas']['id_grupo_inmueble']."'");
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

                              <?php if(isset($_SESSION['session_ventas'])){ ?>

                                <select name="id_inmueble" class="js-select2 form-control">
                                    <?php $sql_inmueble = $conexion2 -> query("select id_inmueble, mi_nombre from maestro_inmuebles where id_inmueble = '".$_SESSION['session_ventas']['id_inmueble']."'");
                                          while($lista_inmueble = $sql_inmueble -> fetch_array()){
                                            $id_inmueble = $lista_inmueble['id_inmueble'];
                                            $nombre_inmueble = $lista_inmueble['mi_nombre'];} ?>
                                <option value="<?php echo $id_inmueble; ?>"><?php echo $nombre_inmueble; ?></option>
                                </select>
                                <?php }else{ ?>

                               <select id="ciudad" name="id_inmueble" class="js-select2 form-control" style="width: 100%;">
                                    <option value="0">Selecciona Uno...</option>
                               </select>
                               <?php } ?>
                            </div>
                        </div>
                        <?php } ?>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-username">Precio de venta<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                               <input class="form-control" type="number" name="precio_venta" placeholder="Precio de venta" require="require"
                                      value="<?php if(isset($rv_precio_venta)){ echo $rv_precio_venta;}
                                                   elseif(isset($_SESSION['session_ventas_reserva']['precio_venta'])){ echo $_SESSION['session_ventas_reserva']['precio_venta'];}
                                                   elseif(isset($_SESSION['session_ventas']['precio_venta'])){ echo $_SESSION['session_ventas']['precio_venta']; } ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-password">Descripcion <span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <textarea class="form-control" type="text" name="descripcion" placeholder="Observaciones de venta"><?php if(isset($_SESSION['session_ventas_reserva']['descripcion'])){ echo $_SESSION['session_ventas_reserva']['descripcion'];}
                                                                                                                                         elseif(isset($_SESSION['session_ventas']['descripcion'])){ echo $_SESSION['session_ventas']['descripcion']; }?></textarea>
                            </div>
                        </div>

                        <?php if(isset($_SESSION['session_ventas_reserva'])){ ?> <input type="hidden" name="confirmacion" value="1"> <?php } ?>
                        <?php if(isset($_SESSION['session_ventas'])){ ?> <input type="hidden" name="confirmacion" value="1"> <?php } ?>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <?php if(isset($sql_insertar)){ ?> El registro fue realizado, usted sera redirecionado <?php }
                                      elseif(isset($_SESSION['session_ventas_reserva'])){?> <button class="btn btn-sm btn-primary" type="submit">Confirmar Registro</button> <?php }
                                      elseif(isset($_SESSION['session_ventas'])){?> <button class="btn btn-sm btn-primary" type="submit">Confirmar Registro</button> <?php }
                                      else{ ?> <button class="btn btn-sm btn-primary" type="submit">Registrar</button> <?php } ?>
                            </div>
                        </div>
                </form>
            </div>
            <!-- Bootstrap Forms Validation -->
            <div class="modal fade" id="modal-popin" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-popin">
                    <div class="modal-content">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="block block-themed block-transparent remove-margin-b">
                                <div class="block-header bg-primary-dark">
                                    <ul class="block-options">
                                        <li>
                                            <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                                        </li>
                                    </ul>
                                    <h3 class="block-title">Actualizar Datos</h3>
                                </div>
                                <div class="block-content">
                                    <!-- Bootstrap Register -->
                                    <div class="block block-themed">
                                        <div class="block-content">
                                        <div class="form-group">
                                        <label class="col-xs-12" for="register1-username">PAIS</label>
                                            <div class="col-xs-12">
                                               <select class="js-select2 form-control" name="id_pais" style="width: 100%;" data-placeholder="Seleccionar un pais" required="required">
                                                    <option value="0"> Selecciona un pais</option>
                                                    <?php
                                                            $strConsulta = "select id_paises, ps_nombre_pais from maestro_paises";
                                                            $result = $conexion2->query($strConsulta);
                                                            $opciones = '<option value="0"> Elige un pais </option>';
                                                            while($fila = $result->fetch_array()){ ?>
                                                                    <option value="<?php echo $fila['id_paises']; ?>"><?php echo $fila['ps_nombre_pais']; ?></option>
                                                    <?php  } ?>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-xs-12" for="register1-username">NOMBRE</label>
                                            <div class="col-xs-12">
                                                <input class="form-control" type="text" id="register1-username" name="nombre" value="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-xs-12" for="register1-email">APELLIDO</label>
                                            <div class="col-xs-12">
                                                <input class="form-control" type="text" id="register1-email" name="apellido" value="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-xs-12" for="register1-email">IDENTIFICACION</label>
                                            <div class="col-xs-12">
                                                <input class="form-control" type="text" id="register1-email" name="identificacion" value="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-xs-12" >TELEFONO 1</label>
                                            <div class="col-xs-12">
                                                <input class="form-control" type="text" id="register1-email" name="telefono_1" value="">
                                            </div>
                                        </div>
                                    <div class="form-group">
                                        <label class="col-xs-12" ></label>
                                        <div class="col-xs-12">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-sm btn-default" type="button" data-dismiss="modal">Cancelar</button>
                                        <button class="btn btn-sm btn-primary" type="submit" name="registrar_cliente">Registrar</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<script language="javascript">
$(document).ready(function(){
   $("#proyecto").change(function () {
           $("#proyecto option:selected").each(function () {
            elegido=$(this).val();
            $.post("select_movimientos.php", { elegido: elegido }, function(data){
            $("#grupo").html(data);
            });
        });
   })
});
</script>

<script language="javascript">
$(document).ready(function(){
   $("#marca").change(function () {
           $("#marca option:selected").each(function () {
            elegido=$(this).val();
            $.post("select_movimientos.php", { elegido: elegido }, function(data){
            $("#modelo").html(data);
            });
        });
   })
});
</script>

<?php if(isset($sql_insertar)){
        unset($_SESSION['session_ventas_reserva']);
        unset($_SESSION['session_ventas']); ?>
        <script type="text/javascript">
            function redireccionarPagina() {
              window.location = "gc_asignar_comision.php";
            }
            setTimeout("redireccionarPagina()", 5000);
        </script>
<?php  } ?>

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
