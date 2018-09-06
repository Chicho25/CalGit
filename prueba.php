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
                              $porcentaje_venta = $lista_contrato_ventas['mi_porcentaje_comision'];}

                    $session_contrato = array('id_venta'=>$id_contrato_venta,
                                                    'mv_precio_venta'=>$precio_final,
                                                        'mi_porcentaje_comision' =>$porcentaje_venta);

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
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-username">Precio de cierre<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <input class="form-control" type="text" id="val-username" readonly="readonly" value="<?php if(isset($_SESSION['session_contrato'])){ echo $_SESSION['session_contrato']['mv_precio_venta'];} ?>">
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
																	<option value=""> Selecciona tipo de inmueble</option>
                                    <?php  $sql_vendedores = todos_vendedores($conexion2); ?>
                                    <?php  while($lista_vendedores = mysqli_fetch_array($sql_vendedores)){ ?>
                                    <option value="<?php echo $lista_vendedores['id_vendedor']; ?>"
                                                   <?php if(isset($_SESSION['session_contratos'])){ if($_SESSION['session_proyecto']['id_empresa'] == $lista_contratos['id_empresa']){ echo 'selected'; }} ?>
                                     ><?php echo $lista_vendedores['ven_nombre'].' '.$lista_vendedores['ven_apellido']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-email">porcentaje comision <span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <input id="val-range" required="required" class="form-control" type="number" name="porcentaje_comision" placeholder="porcentaje de comision" value="<?php if(isset( $_SESSION['session_proyecto'])){ echo  $_SESSION['session_proyecto']['promotor'];} ?>">
                                <!--<input required="required" type="text" name="" value="">-->
                            </div>
                        </div>

                        <?php if(isset( $_SESSION['session_proyecto'])){?> <input type="hidden" name="confirmacion" value="1"> <?php } ?>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <?php if(isset($sql_insertar)){ ?> El registro fue realizado, usted sera redirecionado <?php }elseif(isset( $_SESSION['session_proyecto'])){?> <button class="btn btn-sm btn-primary" type="submit">Confirmar Registro</button> <?php }else{ ?> <button class="btn btn-sm btn-primary" type="submit">Agregar comision</button> <?php } ?>
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
		                                            <input class="form-control" type="text" id="val-username" name="porcentaje_restante" placeholder="Porcentaje restante" readonly="readonly" value="<?php echo $lista_comision_asignada['ven_nombre'].' '.$lista_comision_asignada['ven_apellido'].' '.$lista_comision_asignada['cv_porcentaje_comision'].'%'; ?>" >

		                                        </div>
		                                        <div class="col-md-1">
		                                        	<a class="btn btn-danger push-5-r push-10" href="prueba.php?eliminar=<?php echo $lista_comision_asignada['id_comision_vendedor']; ?>"><i class="fa fa-times"></i></a>
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
<?php  ?>
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
