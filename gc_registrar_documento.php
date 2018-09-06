<?php if(!isset($_SESSION)){session_start();}?>
<?php require("conexion/conexion.php"); ?>
<?php require("funciones/funciones.php"); ?>
<?php if(isset($_SESSION['session_gc'])){ ?>
<?php $header_bar = 'base_header.php'; ?>
<?php $menu = true; ?>
<?php /* ################ AUDITORIA DE SEGUIMIENTO ############## */ ?>
<?php require("funciones/funciones_auditorias.php"); ?>
<?php $lugar_mapa = 45; ?>
<?php $dispositivo_acceso = obtener_dispositivo(); ?>
<?php insertar_log_seguimiento($conexion2, ObtenerIP(), $dispositivo_acceso, $lugar_mapa, $_SESSION['session_gc']['usua_id']); ?>
<?php /* ######################################################## */ ?>
<?php /* ######################## update contrato de venta ################ */ ?>
<?php if(isset($_POST['cerrar_documento'])){update_contrato_venta($conexion2, $_SESSION['session_documentos']['id_venta'], $_POST['cerrar_documento']);
         unset($_SESSION['session_documentos']);
         $proceso_finalizado = true;
    } ?>
<?php /* ######################## eliminar cuota ################ */ ?>
<?php if(isset($_POST['id_eliminar_documento'])){eliminar_documento($conexion2, $_POST['id_eliminar_documento']);} ?>
<?php /* ######################## Insert de las cuotas ##################################### */ ?>
<?php if(isset($_POST['confirmacion'])){$sql_insertar = $conexion2 -> query("insert into maestro_cuotas(id_contrato_venta,
                                                                                                        id_proyecto,
                                                                                                        id_grupo,
                                                                                                        id_inmueble,
                                                                                                        mc_precio_cerrado,
                                                                                                        mc_fecha_creacion_contrato,
                                                                                                        mc_fecha_vencimiento,
                                                                                                        mc_descripcion,
                                                                                                        id_tipo_cuota,
                                                                                                        id_banco,
                                                                                                        mc_aprobada,
                                                                                                        mc_monto,
                                                                                                        mc_monto_abonado,
                                                                                                        mc_status
                                                                                                        )values(
                                                                                                        '".$_SESSION['session_documentos']['id_venta']."',
                                                                                                        '".$_SESSION['session_documentos']['id_proyecto']."',
                                                                                                        '".$_SESSION['session_documentos']['id_grupo_inmueble']."',
                                                                                                        '".$_SESSION['session_documentos']['id_inmueble']."',
                                                                                                        '".$_SESSION['session_documentos']['mv_precio_venta']."',
                                                                                                        '".date_format(date_create($_SESSION['session_documentos']['fecha_venta']), "Y-m-d")."',
                                                                                                        '".date_format(date_create($_SESSION['session_documentos']['fecha_vencimiento']), "Y-m-d")."',
                                                                                                        '".$_SESSION['session_documentos']['descripcion']."',
                                                                                                        '".$_SESSION['session_documentos']['tipo_cuota']."',
                                                                                                        '".$_SESSION['session_documentos']['banco_emisor']."',
                                                                                                        '".$_SESSION['session_documentos']['aprobada']."',
                                                                                                        '".$_SESSION['session_documentos']['monto_cuota']."',
                                                                                                        0,
                                                                                                        1)");
/* Funcion para enumerar las cuotas  */
function recuperar_id_cuota($conexion){
  $sql_r = $conexion -> query("SELECT MAX(id_cuota) AS id FROM maestro_cuotas");
  while($lista_r = $sql_r->fetch_array()){
         return $lista_r['id'];
  }
}

function insertar_numero_cuota($conexion, $id_contrato, $id_cuota){

      /* Comprobar el numero de cuota */

      /* Comproba si existe cuotas para asignarle el unicial */
      $contar_numero_cuota = $conexion -> query("SELECT COUNT(*) AS contar FROM maestro_cuotas WHERE id_contrato_venta = '".$id_contrato."'");
      while($lista_contar = $contar_numero_cuota->fetch_array()){
            $total = $lista_contar['contar'];
      }

      /* Fin de comprobar */

            if($total == 1){
              $insertar_primer_numero_cuota = $conexion -> query("UPDATE maestro_cuotas SET mc_numero_cuota = '".$total."' WHERE id_cuota = '".$id_cuota."'");
            }else{

              $sql_r = $conexion -> query("SELECT MAX(mc_numero_cuota)+1 AS id FROM maestro_cuotas WHERE id_contrato_venta = $id_contrato");
              while($lista_r = $sql_r->fetch_array()){
                     $ultimo_numero_cuota = $lista_r['id'];
              }

              $insertar_numero_cuota = $conexion -> query("UPDATE maestro_cuotas SET mc_numero_cuota = '".$ultimo_numero_cuota."' WHERE id_cuota = '".$id_cuota."'");

            }

}
$id_recuperado = recuperar_id_cuota($conexion2);
insertar_numero_cuota($conexion2, $_SESSION['session_documentos']['id_venta'], $id_recuperado);
                                                                                                  } ?>

<?php   /* ######################## destruin variables para registrar nuevo document ####################### */
        if(isset($sql_insertar)){
        if(isset($_SESSION['session_documentos']['fecha_vencimiento'])){unset($_SESSION['session_documentos']['fecha_vencimiento']);}
        if(isset($_SESSION['session_documentos']['descripcion'])){unset($_SESSION['session_documentos']['descripcion']);}
        if(isset($_SESSION['session_documentos']['tipo_cuota'])){unset($_SESSION['session_documentos']['tipo_cuota']);}
        if(isset($_SESSION['session_documentos']['banco_emisor'])){unset($_SESSION['session_documentos']['banco_emisor']);}
        if(isset($_SESSION['session_documentos']['aprobada'])){unset($_SESSION['session_documentos']['aprobada']);}
        if(isset($_SESSION['session_documentos']['monto_cuota'])){unset($_SESSION['session_documentos']['monto_cuota']);}
        if(isset($_SESSION['session_documentos']['monto_cuota_abonado'])){unset($_SESSION['session_documentos']['monto_cuota_abonado']);}
        if(isset($_POST['fecha_vencimiento'])){unset($_POST['fecha_vencimiento']);}
        if(isset($_POST['descripcion'])){unset($_POST['descripcion']);}
        if(isset($_POST['tipo_cuota'])){unset($_POST['tipo_cuota']);}
        if(isset($_POST['banco_emisor'])){unset($_POST['banco_emisor']);}
        if(isset($_POST['aprobada'])){unset($_POST['aprobada']);}
        if(isset($_POST['monto_cuota'])){unset($_POST['monto_cuota']);}
        if(isset($_POST['monto_cuota_abonado'])){unset($_POST['monto_cuota_abonado']);}}

 /* ######################## segundo bloque de sessiones ############################## */ ?>
<?php if(isset($_SESSION['session_documentos']['id_venta'],
                    $_SESSION['session_documentos']['id_proyecto'],
                            $_POST['fecha_vencimiento'],
                                $_POST['descripcion'],
                                    $_POST['tipo_cuota'])){

                                      $session_documentos = array('id_venta'=>$_SESSION['session_documentos']['id_venta'],
                                                                      'id_proyecto'=>$_SESSION['session_documentos']['id_proyecto'],
                                                                          'proy_nombre_proyecto' =>$_SESSION['session_documentos']['proy_nombre_proyecto'],
                                                                              'id_grupo_inmueble'=>$_SESSION['session_documentos']['id_grupo_inmueble'],
                                                                                  'gi_nombre_grupo_inmueble'=>$_SESSION['session_documentos']['gi_nombre_grupo_inmueble'],
                                                                                      'id_inmueble' =>$_SESSION['session_documentos']['id_inmueble'],
                                                                                      'mi_nombre'=>$_SESSION['session_documentos']['mi_nombre'],
                                                                                  'cl_nombre'=>$_SESSION['session_documentos']['cl_nombre'],
                                                                              'cl_apellido' =>$_SESSION['session_documentos']['cl_apellido'],
                                                                          'fecha_venta' =>$_SESSION['session_documentos']['fecha_venta'],
                                                                      'mv_precio_venta'=>$_SESSION['session_documentos']['mv_precio_venta'],
                                                                          'fecha_vencimiento'=>$_POST['fecha_vencimiento'],
                                                                              'descripcion'=>$_POST['descripcion'],
                                                                                  'tipo_cuota'=>$_POST['tipo_cuota'],
                                                                                      'banco_emisor'=>$_POST['banco_emisor'],
                                                                                          'aprobada'=>$_POST['aprobada'],
                                                                                              'monto_cuota'=> $_POST['monto_cuota']);

                                      $_SESSION['session_documentos']=$session_documentos; }

 /* ######################## Primer bloque de sessiones ############################## */
           elseif(isset($_POST['id_contrato_ventas'])){

                    $sql_contrato_ventas = ver_contratos_ventas_activos_id($conexion2, $_POST['id_contrato_ventas']);
                      while($lista_contrato_ventas = $sql_contrato_ventas->fetch_array()){

                              $id_contrato_venta = $lista_contrato_ventas['id_venta'];
                              $id_proyecto = $lista_contrato_ventas['id_proyecto'];
                              $proyecto = $lista_contrato_ventas['proy_nombre_proyecto'];
                              $id_grupo = $lista_contrato_ventas['id_grupo_inmueble'];
                              $grupo = $lista_contrato_ventas['gi_nombre_grupo_inmueble'];
                              $id_inmueble = $lista_contrato_ventas['id_inmueble'];
                              $nombre_inmueble = $lista_contrato_ventas['mi_nombre'];
                              $nombre_cliente = $lista_contrato_ventas['cl_nombre'];
                              $apellido_cliente = $lista_contrato_ventas['cl_apellido'];
                              $fecha_venta = $lista_contrato_ventas['fecha_venta'];
                              $precio_final = $lista_contrato_ventas['mv_precio_venta'];}

                    $session_documentos = array('id_venta'=>$id_contrato_venta,
                                                    'id_proyecto'=>$id_proyecto,
                                                        'proy_nombre_proyecto' =>$proyecto,
                                                            'id_grupo_inmueble'=>$id_grupo,
                                                                'gi_nombre_grupo_inmueble'=>$grupo,
                                                                    'id_inmueble' =>$id_inmueble,
                                                                    'mi_nombre'=>$nombre_inmueble,
                                                                'cl_nombre'=>$nombre_cliente,
                                                            'cl_apellido' =>$apellido_cliente,
                                                        'fecha_venta' =>$fecha_venta,
                                                    'mv_precio_venta'=>$precio_final);

                    $_SESSION['session_documentos']=$session_documentos; }  ?>

<?php /* ################################################################################ */ ?>

<?php require 'inc/config.php'; ?>
<?php require 'inc/views/template_head_start.php'; ?>
<!-- Page JS Plugins CSS -->
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/bootstrap-datepicker/bootstrap-datepicker3.min.css">
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/select2/select2.min.css">
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/select2/select2-bootstrap.min.css">
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/sweetalert/sweetalert.min.css">
<?php require 'inc/views/template_head_end.php'; ?>
<script language="javascript" type="text/javascript">
    $(document).ready(function(){
        $(".contenido").hide();
        $("#combito").change(function(){
        $(".contenido").hide();
            $("#div_" + $(this).val()).show();
        });
    });
</script>
<script type="text/javascript">
$(document).ready(function() {
   $("#datepicker").datepicker();
});
</script>
<?php require 'inc/views/base_head.php'; ?>
<div class="content content-narrow">
    <!-- Forms Row -->
    <div class="row">
      <?php if(isset($sql_insertar)){ ?>

              <div class="alert alert-success alert-dismissable">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <h3 class="font-w300 push-15">Registrados</h3>
                  <p>La <a class="alert-link" href="javascript:void(0)">Cuota</a> fue registrada!</p>
              </div>

      <?php } ?>
      <?php if(isset($proceso_finalizado)){ ?>
          <div class="col-sm-3 col-lg-3" style="position: absolute; right: 0px;">
              <!-- Success Alert -->
              <div class="alert alert-success alert-dismissable">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <h3 class="font-w300 push-15">Proceso finalizado</h3>
                  <p>Las <a class="alert-link" href="javascript:void(0)">Cuotas</a> fueron registradas!</p>
              </div>
              <!-- END Success Alert -->
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
                    <h3 class="block-title">Cuotas de pago</h3><small> Los campos con <span class="text-danger">*</span> son obligatorios</small>
                </div>
                <div class="block-content block-content-narrow">
                    <!-- jQuery Validation (.js-validation-bootstrap class is initialized in js/pages/base_forms_validation.js) -->
                    <!-- For more examples you can check out https://github.com/jzaefferer/jquery-validation -->
                    <form class="form-horizontal" action="" method="post">
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-username">Contrato de Venta<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <select class="js-select2 form-control" name="id_contrato_ventas" style="width: 100%;" data-placeholder="Seleccionar empresa" required="required" onchange="this.form.submit()">
                                    <option></option>
                                    <?php //$sql_contratos = ver_contratos_ventas_activos($conexion2); ?>
                                    <?php $sql_contratos = $conexion2 -> query("select
                        																													  mp.proy_nombre_proyecto,
                        																												    mv.id_proyecto,
                        																												    gi.gi_nombre_grupo_inmueble,
                        																												    mv.id_grupo_inmueble,
                        																												    mi.mi_nombre,
                        																														mi.mi_codigo_imueble,
                        																												    mv.id_inmueble,
                        																												    mv.mv_precio_venta,
                        																												    mv.mv_descripcion,
                        																												    mv.mv_reserva,
                        																												    mv.mv_id_reserva,
                        																												    mv.mv_status,
                        																												    mc.cl_nombre,
                        																												    mc.cl_apellido,
                        																												    mv.id_cliente,
                        																														mv.id_venta,
                        																														mv.fecha_venta,
                        																														mi_porcentaje_comision
                        																												from
                        																													maestro_ventas mv inner join maestro_proyectos mp on mv.id_proyecto = mp.id_proyecto
                        																																	          inner join grupo_inmuebles gi on mv.id_grupo_inmueble = gi.id_grupo_inmuebles
                        																											                      inner join maestro_inmuebles mi on mv.id_inmueble = mi.id_inmueble
                        																											                      inner join maestro_clientes mc on mv.id_cliente = mc.id_cliente
                        																													where
                        																													mv.mv_status in(1, 4)
                                                                                  and
                                                                                  mp.id_proyecto not in(13)"); ?>
                                    <?php while($lista_contratos = mysqli_fetch_array($sql_contratos)){ ?>
                                    <option value="<?php echo $lista_contratos['id_venta']; ?>"
                                                   <?php if(isset($_SESSION['session_documentos'])){ if($_SESSION['session_documentos']['id_venta'] == $lista_contratos['id_venta']){ echo 'selected'; }} ?>
                                     ><?php echo $lista_contratos['id_venta'].' // '.$lista_contratos['gi_nombre_grupo_inmueble'].' // '.$lista_contratos['mi_nombre'].' // '.$lista_contratos['cl_nombre'].' '.$lista_contratos['cl_apellido']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </form>
                    <form class="js-validation-bootstrap form-horizontal" action="" method="post">
                      <div class="form-group">
                          <label class="col-md-4 control-label" for="val-username">Proyecto<span class="text-danger">*</span></label>
                          <div class="col-md-7">
                              <input class="form-control" type="text" id="val-username" placeholder="Proyecto" value="<?php if(isset($_SESSION['session_documentos'])){
                                                                                                                                        echo $_SESSION['session_documentos']['proy_nombre_proyecto'];} ?>" readonly="readonly">
                          </div>
                      </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-username">Grupo<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <input class="form-control" type="text" id="val-username" placeholder="Grupo" value="<?php if(isset($_SESSION['session_documentos'])){
                                                                                                                                          echo $_SESSION['session_documentos']['gi_nombre_grupo_inmueble'];} ?>" readonly="readonly">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-username">Nombre Inmueble<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <input class="form-control" type="text" id="val-username" placeholder="Nombre Inmueble" value="<?php if(isset($_SESSION['session_documentos'])){
                                                                                                                                          echo $_SESSION['session_documentos']['mi_nombre'];} ?>" readonly="readonly">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-username">Precio de venta<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <input class="form-control" type="text" id="val-username" placeholder="Precio de venta" value="<?php if(isset($_SESSION['session_documentos'])){
                                                                                                                                          echo number_format($_SESSION['session_documentos']['mv_precio_venta'], 2, '.',',');} ?>" readonly="readonly">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-username">Nombre Cliente<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <input class="form-control" type="text" id="val-username" placeholder="Nombre Cliente" value="<?php if(isset($_SESSION['session_documentos'])){
                                                                                                                                          echo $_SESSION['session_documentos']['cl_nombre'].' '.$_SESSION['session_documentos']['cl_apellido'];} ?>" readonly="readonly">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-username">Fecha de creacion del contrato de venta<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <input class="form-control" type="text" id="val-username" name="Fecha de creacion" placeholder="Fecha contrato" value="<?php if(isset($_SESSION['session_documentos'])){
                                                                                                                                                                    echo date("d-m-Y", strtotime($_SESSION['session_documentos']['fecha_venta']));} ?>" readonly="readonly">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-username">Fecha de Vencimiento<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <input autocomplete="off" class="js-datepicker form-control" type="text" id="example-datepicker1" name="fecha_vencimiento" data-date-format="dd-mm-yyyy" placeholder="Fecha de vencimiento" value="<?php if(isset($_SESSION['session_documentos']['fecha_vencimiento'])){
                                                                                                                                                                              echo $_SESSION['session_documentos']['fecha_vencimiento'];} ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-username">Descripcion<span class="text-danger"></span></label>
                            <div class="col-md-7">
                                <textarea class="form-control" name="descripcion" placeholder="Descripcion"><?php if(isset($_SESSION['session_documentos']['descripcion'])){
                                                                                                                      echo $_SESSION['session_documentos']['descripcion'];} ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-username">Seguimiento de cobro<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                              <select id="combito" name="tipo_cuota" class="js-select2 form-control" data-placeholder="Tipo Cuota" require="require">
                                  <?php $sql_tipo_cuota = $conexion2->query("select * from tipo_cuota where tc_stat = 1"); ?>
                                  <?php while($lista_tipo_cuota = $sql_tipo_cuota -> fetch_array()){ ?>
                                  <option value="<?php echo $lista_tipo_cuota['id_tipo_cuota']; ?>" <?php if(isset($_SESSION['session_documentos']['tipo_cuota'])){
                                                                                                            if($_SESSION['session_documentos']['tipo_cuota'] == $lista_tipo_cuota['id_tipo_cuota']){
                                                                                                                  echo 'selected';}} ?> ><?php echo $lista_tipo_cuota['tc_nombre_tipo_cuenta']; ?></option>
                                  <?php } ?>
                              </select>
                            </div>
                        </div>
                        <div id="div_2" class="contenido">
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="val-username">Banco emisor <span class="text-danger">*</span></label>
                                <div class="col-md-8">
                                    <select class="js-select2 form-control" name="banco_emisor" style="width:90%;">
                                      <option>Seleccionar Banco</option>
                                      <?php $sql_bancos = $conexion2->query("select * from maestro_bancos where banc_stado = 1"); ?>
                                      <?php while($lista_bancos = $sql_bancos -> fetch_array()){ ?>
                                      <option value="<?php echo $lista_bancos['id_bancos']; ?>" <?php if(isset($_SESSION['session_documentos']['banco_emisor'])){
                                                                                                                if($_SESSION['session_documentos']['banco_emisor'] == $lista_bancos['id_bancos']){
                                                                                                                      echo 'selected';}} ?>><?php echo $lista_bancos['banc_nombre_banco']; ?></option>
                                      <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div id="div_3" class="contenido">
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="val-username">Aprobada ?<span class="text-danger">*</span></label>
                                <div class="col-md-1">
                                    <input class="form-control" type="checkbox" id="val-username" name="aprobada" <?php if(isset($_SESSION['session_documentos']['aprobada'])){
                                                                                                                                  if($_SESSION['session_documentos']['aprobada'] == 1){ ?> checked="checked" <?php } } ?>>
                                </div>
                            </div>
                       </div>
                        <div class="form-group">

                          <!-- Suma y resta de l que queda -->
                          <?php if(isset($_SESSION['session_documentos'])){ ?>
                          <?php  $suma_documento_actual = suma_documento($conexion2, $_SESSION['session_documentos']['id_venta']); ?>
                          <?php $total_inmueble = $_SESSION['session_documentos']['mv_precio_venta']; ?>
                          <?php $resta = $total_inmueble-$suma_documento_actual;} ?>

                            <label class="col-md-4 control-label" for="val-username">Monto<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                              <input id="val-range" max="<?php if(isset($resta)){echo $resta;} ?>" min="0" required="required" class="form-control" type="text" name="monto_cuota" placeholder="Monto" value="<?php if(isset($_SESSION['session_documentos']['monto_cuota'])){
                                                                                                                                                                                                                    echo $_SESSION['session_documentos']['monto_cuota'];} ?>">
                                <!--<input class="form-control" type="number" id="val-username" name="monto_cuota" require="require" placeholder="Monto" value="">-->

                            </div>
                        </div>
                        <?php /* ?>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-username">Monto Abonado<span class="text-danger"></span></label>
                            <div class="col-md-7">
                                <input class="form-control" type="number" id="val-username" name="monto_cuota_abonado" placeholder="Monto Abonado" value="<?php if(isset($_SESSION['session_documentos']['monto_cuota_abonado'])){
                                                                                                                                                                     echo $_SESSION['session_documentos']['monto_cuota_abonado'];} ?>">
                            </div>
                        </div>
                        <?php */ ?>
                        <?php if(isset($_SESSION['session_documentos']['monto_cuota'])){?> <input type="hidden" name="confirmacion" value="1"> <?php } ?>
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                              <?php if(isset($_SESSION['session_documentos']['id_venta'])){ ?>
                              <?php $suma = suma_documento_retornado($conexion2, $_SESSION['session_documentos']['id_venta']); ?>
                              <?php if($suma == $_SESSION['session_documentos']['mv_precio_venta']){$suma_igual = 'listo';}} ?>

                                <?php if(isset($suma_igual)){ ?> Los documentosregistrados han llegado a la totalidad del costo del inmueble, por favor precione el boton "cerrar documento" si desea proseguir <?php }
                                        elseif(isset( $_SESSION['session_documentos']['monto_cuota'])){?>
                                            <button class="btn btn-sm btn-primary" type="submit">Confirmar Registro</button> <?php
                                                }else{ ?>
                                                    <button class="btn btn-sm btn-primary" type="submit">Agregar</button> <?php } ?>
                            </div>
                        </div>
                    </form>
                      <div class="block-content">
                          <table class="table table-bordered">
                              <thead>
                                  <tr>
                                      <th class="text-center" style="width: 50px;">ID</th>
                                      <th>TIPO</th>
                                      <th class="hidden-xs" style="width: 15%;">NUMERO</th>
                                      <th class="text-center" style="width: 100px;">FECHA VENCIMIENTO</th>
                                      <th class="text-center" style="width: 100px;">MONTO DOCUMENTO</th>
                                      <th class="text-center" style="width: 100px;">MONTO PAGADO</th>
                                      <th class="text-center" style="width: 100px;">ELIMINAR</th>
                                  </tr>
                              </thead>
                              <tbody>
                                <?php if(isset($_SESSION['session_documentos']['id_venta'])){ ?>
                                <?php $cuota_contrato = cuotas_contrato($conexion2, $_SESSION['session_documentos']['id_venta']); ?>
                                <?php while($lista_cuota_contrato = $cuota_contrato -> fetch_array()){ ?>
                                  <tr>
                                      <td class="text-center"><?php echo $lista_cuota_contrato['id_cuota']; ?></td>
                                      <td><?php echo $lista_cuota_contrato['tc_nombre_tipo_cuenta']; ?></td>
                                      <td class="hidden-xs"><?php echo $lista_cuota_contrato['mc_numero_cuota']; ?></td>
                                      <td class="text-center"><?php echo date("d-m-Y", strtotime($lista_cuota_contrato['mc_fecha_vencimiento'])); ?></td>
                                      <th class="text-center" style="width: 100px;"><?php echo number_format($lista_cuota_contrato['mc_monto'], 2, '.',','); ?></th>
                                      <th class="text-center" style="width: 100px;"><?php echo number_format($lista_cuota_contrato['mc_monto_abonado'], 2, '.',','); ?></th>
                                      <th class="text-center" style="width: 100px;">
                                        <form class="form-horizontal" action="" method="post">
                                          <button class="btn btn-xs btn-default" type="submit" data-toggle="tooltip" title="Eliminar Cuota"><i class="fa fa-times"></i></button>
                                          <input type="hidden" name="id_eliminar_documento" value="<?php echo $lista_cuota_contrato['id_cuota']; ?>">
                                        </form>
                                      </th>
                                  </tr>
                                <?php } ?>
                                  <tr>
                                      <th class="text-right" style="width: 90%;" colspan="6">
                                        TOTAL MONTO DOCUMENTOS
                                      </th>
                                      <th class="text-center"  style="width: 100px;">
                                        <?php echo number_format(suma_documento($conexion2, $_SESSION['session_documentos']['id_venta']), 2, '.',',');
                                              $suma = suma_documento_retornado($conexion2, $_SESSION['session_documentos']['id_venta']);
                                         ?>
                                      </th>
                                  </tr>

                                  <tr>
                                      <th class="text-right" style="width: 90%;" colspan="6">
                                        MONTO RESTANTE
                                      </th>
                                      <th class="text-center" style="width: 100px;">
                                        <?php echo number_format($resta, 2, '.',','); ?>
                                      </th>
                                  </tr>
                                  <?php /* ?>
                                  <tr>
                                      <th class="text-right" style="width: 90%;" colspan="6">
                                        TOTAL MONTO PAGADO
                                      </th>
                                      <th class="text-center" style="width: 100px;">
                                        <?php suma_documento_abonado($conexion2, $_SESSION['session_documentos']['id_venta']); ?>
                                      </th>
                                  </tr>
                                  <?php */ ?>
                                <?php } ?>
                              </tbody>
                          </table>
                      </div>
                      <?php if(isset($_SESSION['session_documentos']['mv_precio_venta'])){
                              if($_SESSION['session_documentos']['mv_precio_venta'] == $suma){ ?>
                                  <div class="block-content"  style="text-align:right;">
                                      <form action="" method="post">
                                          <input type="hidden" value="5" name="cerrar_documento">
                                          <button class="btn btn-sm btn-primary" type="submit">Cerrar Documento</button>
                                      </form>
                                  </div>
                      <?php }
                    } ?>
            </div>
            <!-- Bootstrap Forms Validation -->
        </div>
    </div>
</div>
</div>


<?php if(isset($proceso_finalizado)){?>

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
<script src="<?php echo $one->assets_folder; ?>/js/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<script src="<?php echo $one->assets_folder; ?>/js/plugins/jquery-auto-complete/jquery.auto-complete.min.js"></script>
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
<script src="<?php echo $one->assets_folder; ?>/js/pages/base_forms_pickers_more.js"></script>
<script>
    jQuery(function(){
        // Init page helpers (BS Datepicker + BS Datetimepicker + BS Colorpicker + BS Maxlength + Select2 + Masked Input + Range Sliders + Tags Inputs plugins)
        App.initHelpers(['datetimepicker', 'colorpicker', 'maxlength', 'select2', 'masked-inputs', 'rangeslider', 'tags-inputs']);
    });
    function init()
    {
      $(".js-datepicker").datepicker({
        startDate: "<?php echo date("d-m-Y") ?>",
        format: "dd-mm-yyyy"
      });

    }
    window.onload = init;
</script>
<?php require 'inc/views/template_footer_end.php'; ?>
<?php }else{ ?>

        <script type="text/javascript">
            window.location="salir.php";
        </script>

<?php } ?>
