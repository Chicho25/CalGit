<?php if(!isset($_SESSION)){session_start();}?>
<?php require("conexion/conexion.php"); ?>
<?php require("funciones/funciones.php"); ?>
<?php if(isset($_SESSION['session_gc'])){ ?>
<?php $header_bar = 'base_header.php'; ?>
<?php $menu = true; ?>
<?php /* ################ AUDITORIA DE SEGUIMIENTO ############## */ ?>
<?php require("funciones/funciones_auditorias.php"); ?>
<?php $lugar_mapa = 44; ?>
<?php $dispositivo_acceso = obtener_dispositivo(); ?>
<?php insertar_log_seguimiento($conexion2, ObtenerIP(), $dispositivo_acceso, $lugar_mapa, $_SESSION['session_gc']['usua_id']); ?>
<?php /* ######################################################## */ ?>
<?php /* ################### funcion borrar asignacion ##################################### */ ?>
<?php if(isset($_GET['eliminar'])){
          eliminar_comision($conexion2, $_GET['eliminar']);} ?>
<?php /* ################################################################################### */ ?>
<?php /* ######################## segundo bloque de sessiones ############################## */ ?>
<?php if(isset($_SESSION['session_contrato']['id_venta'],
                    $_SESSION['session_contrato']['mi_porcentaje_comision'],
                            $_POST['id_vendedor'],
                                $_POST['porcentaje_comision'])){

                                  $sql_inser_comision = $conexion2 -> query("insert into comisiones_vendedores(id_contrato_venta,
                                                                                                               id_vendedor,
                                                                                                               cv_porcentaje_comision,
                                                                                                               cv_status)
                                                                                                               values
                                                                                                               ('".$_SESSION['session_contrato']['id_venta']."',
                                                                                                                '".$_POST['id_vendedor']."',
                                                                                                                '".$_POST['porcentaje_comision']."',
                                                                                                                1)");

/* registro de partida comision */

/* Monto comision */
$monto_comision = ($_POST['precio']*$_POST['porcentaje_comision'])/100;

/*$sql_vendedor = $conexion2 -> query("select ven_nombre, ven_apellido from maestro_vendedores where id_vendedor = '".$_POST['id_vendedor']."'");
while($lv = $sql_vendedor -> fetch_array()){
      $v_nombre = $lv['ven_nombre'];
      $v_apellido = $lv['ven_apellido'];
}*/

$sql_vendedor = $conexion2 -> query("select pro_nombre_comercial from maestro_proveedores where id_proveedores = '".$_POST['id_vendedor']."'");
while($lv = $sql_vendedor -> fetch_array()){
      $v_nombre = $lv['pro_nombre_comercial'];
      /*$v_apellido = $lv['ven_apellido'];*/
}

  $nombre_vendedor = $v_nombre;
  $nombre_partida = $nombre_vendedor.": Comision por venta del ".$_POST["porcentaje_comision"]." % por el inmueble ".$_POST["codigo_inmueble"]."";


  $sql_insertar = $conexion2 -> query("insert into partida_documento(id_partida,
                                                                     id_proveedor,
                                                                     tipo_documento,
                                                                     pd_descripcion,
                                                                     pd_monto_exento,
                                                                     pd_monto_total,
                                                                     pd_stat,
                                                                     comision)
                                                                     values
                                                                     ('".$_POST['mi_id_partida_comision']."',
                                                                      '".$_POST['id_vendedor']."',
                                                                      2,
                                                                      '".$nombre_partida."',
                                                                      '".$monto_comision."',
                                                                      '".$monto_comision."',
                                                                      13,
                                                                      1)");


/* Indicar a la partida que esta en factura 1 = hay facturas 0 = no hay */

$sql_indicar = $conexion2 -> query("UPDATE maestro_partidas SET tiene_facturas = 1 WHERE id = '".$_POST['mi_id_partida_comision']."'");

/* Funcion Para Recorrer el arbol */

  function recorer_arbol_factura($conexion, $id_partida, $monto){

          $sql_datos_partida = $conexion -> query("select * from maestro_partidas where id = '".$id_partida."'");
          while($ld = $sql_datos_partida -> fetch_array()){
                $id=$ld['id'];
                $id_categoria=$ld['id_categoria'];
                $reservado=$ld['p_reservado'];
                $monto_con = $ld['p_monto'];
          }

          $total_reservado = $reservado +  $monto;

          $sql_insert = $conexion ->query("UPDATE maestro_partidas SET p_reservado = '".$total_reservado."' WHERE id = '".$id."'");
          /* comprovar si llego a su totalidad de monto */
          if($monto_con == $total_reservado){
              $sql_up = $conexion ->query("UPDATE maestro_partidas SET tiene_pagos = 1 WHERE id = '".$id."'");
          }

          if($id_categoria == ''){

          }else{
          recorer_arbol_factura($conexion, $id_categoria, $monto);
        }

  }

  recorer_arbol_factura($conexion2, $_POST['mi_id_partida_comision'], $monto_comision);


/* insertar la partida */

/* $sql_inser = $conexion2 -> query("insert into maestro_partidas(p_nombre,
                                                              id_categoria,
                                                              p_monto,
                                                              p_status,
                                                              id_proyecto,
                                                              id_padre,
                                                              id_inmueble_reservas)
                                                              values
                                                             ('".$nombre_partida."',
                                                              '".$_POST['mi_id_partida_comision']."',
                                                              '".$monto_comision."',
                                                              1,
                                                              '".$_POST['id_proyecto']."',
                                                              '".$_POST['mi_id_partida_comision']."',
                                                              '".$_POST['id_inmueble']."')"); */

/* obtener el monto actual distribuido de la partida */

/*
$sql_actualizar_partida = $conexion2 -> query("select sum(p_distribuido) as suma from maestro_partidas where id = '".$_POST['mi_id_partida_comision']."'");
while($s=$sql_actualizar_partida->fetch_array()){
      $p_suma = $s['suma'];
}*/
/*
$total = $p_suma + $monto_comision;

/* Actualizar la partida padre */
/*
$update = $conexion2 -> query("update maestro_partidas set p_distribuido = '".$total."' where id = '".$_POST['mi_id_partida_comision']."'");

/* fin de registro partida comision */


/* ###################### comprobar el porcentaje restante ###################### */

                              $obtener_suma_porcentaje = suma_porcentaje($conexion2, $_SESSION['session_contrato']['id_venta']);
                              while($lista_porcentaje=$obtener_suma_porcentaje->fetch_array()){
                                    $suma = $lista_porcentaje['suma'];}

                              $porcentaje_restante = $_SESSION['session_contrato']['mi_porcentaje_comision'] - $suma;

                              if($porcentaje_restante == 0){

                                $sql_update_inmueble = $conexion2 -> query("update maestro_ventas set mv_status = 4 where id_venta = '".$_SESSION['session_contrato']['id_venta']."'");
                              }


/* ############################################################################## */

                        }

 /* ######################## Primer bloque de sessiones ############################## */
           elseif(isset($_POST['id_contrato_ventas'])){

                    $sql_contrato_ventas = ver_contratos_ventas_activos_id($conexion2, $_POST['id_contrato_ventas']);
                      while($lista_contrato_ventas = $sql_contrato_ventas->fetch_array()){

                              $id_contrato_venta = $lista_contrato_ventas['id_venta'];
                              $precio_final = $lista_contrato_ventas['mv_precio_venta'];
                              $porcentaje_venta = $lista_contrato_ventas['mi_porcentaje_comision'];
                              $id_inmueble = $lista_contrato_ventas['id_inmueble'];
                              $codigo_inmueble = $lista_contrato_ventas['mi_codigo_imueble'];
                              $id_partda = $lista_contrato_ventas['mi_id_partida_comision'];
                              $id_proyeco = $lista_contrato_ventas['id_proyecto'];
                            }

                    $session_contrato = array('id_venta'=>$id_contrato_venta,
                                                 'mv_precio_venta'=>$precio_final,
                                                     'mi_porcentaje_comision'=>$porcentaje_venta,
                                                         'id_inmueble'=>$id_inmueble,
                                                           'codigo_inmueble'=>$codigo_inmueble,
                                                            'mi_id_partida_comision'=>$id_partda,
                                                                'id_proyecto'=>$id_proyeco);

                    $_SESSION['session_contrato']=$session_contrato; }  ?>

<?php /* ################################################################################ */ ?>

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
      <?php if(isset($sql_update_inmueble)){ ?>

              <div class="alert alert-success alert-dismissable">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <h3 class="font-w300 push-15">Registrados</h3>
                  <p>Las <a class="alert-link" href="javascript:void(0)">comisiones</a> fueron registradas!</p>
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
                    <h3 class="block-title">Asignar comision</h3><small> Los campos con <span class="text-danger">*</span> son obligatorios</small>
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
                                    <?php   $sql_contratos = ver_contratos_ventas_activos($conexion2); ?>
                                    <?php   while($lista_contratos = mysqli_fetch_array($sql_contratos)){ ?>
                                    <option value="<?php echo $lista_contratos['id_venta']; ?>"
                                                   <?php if(isset($_SESSION['session_contrato'])){ if($_SESSION['session_contrato']['id_venta'] == $lista_contratos['id_venta']){ echo 'selected'; }} ?>
                                     ><?php echo $lista_contratos['id_venta'].' // '.$lista_contratos['gi_nombre_grupo_inmueble'].' // '.$lista_contratos['mi_nombre'].' // '.$lista_contratos['cl_nombre'].' '.$lista_contratos['cl_apellido']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </form>

                    <form class="js-validation-bootstrap form-horizontal" action="" method="post">
                      <!-- Variables hidden -->
                      <input type="hidden" name="id_inmueble" value="<?php if(isset($_SESSION['session_contrato'])){ echo $_SESSION['session_contrato']['id_inmueble'];} ?>">
                      <input type="hidden" name="mi_id_partida_comision" value="<?php if(isset($_SESSION['session_contrato'])){ echo $_SESSION['session_contrato']['mi_id_partida_comision'];} ?>">
                      <input type="hidden" name="id_proyecto" value="<?php if(isset($_SESSION['session_contrato'])){ echo $_SESSION['session_contrato']['id_proyecto'];} ?>">
                      <input type="hidden" name="codigo_inmueble" value="<?php if(isset($_SESSION['session_contrato'])){ echo $_SESSION['session_contrato']['codigo_inmueble'];} ?>">
                      <!-- Fin -->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-username">Precio de cierre<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <input class="form-control" name="precio" type="text" id="val-username" readonly="readonly" value="<?php if(isset($_SESSION['session_contrato'])){ echo $_SESSION['session_contrato']['mv_precio_venta'];} ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-username">Porcentaje restante<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                              <?php /* ##################### campo porcentaje restante ################## */ ?>
                              <?php if(isset($_SESSION['session_contrato'])){ ?>
                              <?php $obtener_suma_porcentaje = suma_porcentaje($conexion2, $_SESSION['session_contrato']['id_venta']);
                                    while($lista_porcentaje=$obtener_suma_porcentaje->fetch_array()){
                                    $suma = $lista_porcentaje['suma'];}

                                    $porcentaje_restante = $_SESSION['session_contrato']['mi_porcentaje_comision'] - $suma; ?>
                                <input class="form-control"
                                          type="text" id="val-username"
                                              name="porcentaje_restante"
                                                  placeholder="Porcentaje restante"
                                                      readonly="readonly"
                                                          value="<?php echo $porcentaje_restante.' %'; ?>">
                              <?php } ?>
                              <?php /* ####################################################################### */ ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-username">Vendedores<span class="text-danger">*</span></label>
                            <div class="col-md-7">
															<select class="js-select2 form-control" name="id_vendedor" style="width: 100%;" data-placeholder="Seleccionar un tipo de inmueble" required="required">
																	<option value=""> Seleccionar vendedor</option>
                                    <?php  $sql_vendedores = todos_proveedores($conexion2); ?>
                                    <?php  while($lista_vendedores = mysqli_fetch_array($sql_vendedores)){ ?>
                                    <option value="<?php echo $lista_vendedores['id_proveedores']; ?>"
                                     ><?php echo $lista_vendedores['pro_nombre_comercial'].' '.$lista_vendedores['pro_razon_social']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-email">porcentaje comision <?php if(isset($porcentaje_restante)){ echo $porcentaje_restante;} ?><span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <input id="val-range" autocomplete="off" max="<?php if(isset($porcentaje_restante)){ echo $porcentaje_restante;} ?>" min="0" required="required" class="form-control" type="number" name="porcentaje_comision" placeholder="porcentaje de comision" value="<?php if(isset( $_SESSION['session_proyecto'])){ echo  $_SESSION['session_proyecto']['promotor'];} ?>">
                                <!--<input required="required" type="text" name="" value="">-->
                            </div>
                        </div>

                        <?php if(isset( $_SESSION['session_proyecto'])){?> <input type="hidden" name="confirmacion" value="1"> <?php } ?>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <?php if(isset($sql_update_inmueble)){ ?> El registro fue realizado, usted sera redirecionado <?php }elseif(isset( $_SESSION['session_proyecto'])){?> <button class="btn btn-sm btn-primary" type="submit">Confirmar Registro</button> <?php }else{ ?> <button class="btn btn-sm btn-primary" type="submit">Agregar comision</button> <?php } ?>
                            </div>
                        </div>
												<div class="form-group">
		                        <label class="col-md-4 control-label" for="val-email">Comision asignada</label>
														<?php /* comisiones asignadas a y borrarlas */ ?>
														<div class="col-md-7">
		                            <?php if(isset($_SESSION['session_contrato'])){ ?>
		                            <?php $comision_asignada = vendedores_asignados($conexion2, $_SESSION['session_contrato']['id_venta']);
		                                  while($lista_comision_asignada = $comision_asignada -> fetch_array()){ ?>

		                                        <div class="col-md-10">
		                                            <input class="form-control" type="text" id="val-username" name="porcentaje_restante" placeholder="Porcentaje restante" readonly="readonly" value="<?php echo $lista_comision_asignada['pro_nombre_comercial'].' '.$lista_comision_asignada['pro_razon_social'].' '.$lista_comision_asignada['cv_porcentaje_comision'].'%'; ?>" >

		                                        </div>
		                                        <div class="col-md-1">
		                                        	<a class="btn btn-danger push-5-r push-10" href="gc_asignar_comision.php?eliminar=<?php echo $lista_comision_asignada['id_comision_vendedor']; ?>"><i class="fa fa-times"></i></a>
																						</div>
		                            <?php } ?>
		                            <?php } ?>
		                        </div>
		                    </div>
                    </form>
            </div>
            <!-- Bootstrap Forms Validation -->
        </div>
    </div>
</div>
</div>


<?php if(isset($sql_update_inmueble)){

         unset($_SESSION['session_contrato']); ?>

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
