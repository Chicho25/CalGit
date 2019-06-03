<?php if(!isset($_SESSION)){session_start();}?>
<?php require("conexion/conexion.php"); ?>
<?php require("funciones/funciones.php"); ?>
<?php if(isset($_SESSION['session_gc'])){ ?>
<?php if(isset($_POST['id_cuota'])){

      $_SESSION['id_cuota'] = $_POST['id_cuota'];

} ?>
<?php $header_bar = 'base_header.php'; ?>
<?php $menu = true; ?>
<?php /* ################ AUDITORIA DE SEGUIMIENTO ############## */ ?>
<?php require("funciones/funciones_auditorias.php"); ?>
<?php $lugar_mapa = 2; ?>
<?php $dispositivo_acceso = obtener_dispositivo(); ?>
<?php insertar_log_seguimiento($conexion2, ObtenerIP(), $dispositivo_acceso, $lugar_mapa, $_SESSION['session_gc']['usua_id']); ?>
<?php /* ######################################################## */ ?>

<?php if(isset($_POST['confirmacion'])){
         $sql_insert = $conexion2 -> query("INSERT INTO
                                            maestro_cuota_abono(
                                            mca_id_proyecto,
                                            mca_id_grupo_inmueble,
                                            mca_id_inmueble,
                                            mca_codigo,
                                            mca_id_cliente,
                                            mca_id_tipo_abono,
                                            mca_numero,
                                            monto_abonado,
                                            mca_id_documento_venta,
                                            mca_id_cuota_madre,
                                            monto_pendiente,
                                            monto_pagado,
                                            monto_documento,
                                            descripcion,
                                            fecha,
                                            cuenta_receptora,
                                            referencia_abono_cuota
                                            )VALUES(
                                            '".$_POST['id_proyecto']."',
                                            '".$_POST['id_grupo_inmuebles']."',
                                            '".$_POST['id_inmueble']."',
                                            '".$_POST['id_codigo_inmueble']."',
                                            '".$_POST['id_cliente']."',
                                            '".$_POST['tipo_pago']."',
                                            '".$_POST['numero_abono']."',
                                            '".$_POST['monto_pagar']."',
                                            '".$_POST['id_contrato_venta']."',
                                            '".$_POST['id_cuota']."',
                                            '".$_POST['monto_pendiente']."',
                                            '".$_POST['monto_pagado']."',
                                            '".$_POST['monto_documento']."',
                                            '".$_POST['descripcion']."',
                                            '".date("Y-m-d", strtotime($_POST['fecha']))."',
                                            '".$_POST['val-skill']."',
                                            '".$_POST['referencia_abono']."')");
       /* ############## Insertar Movimiento bancario ############ */
       if($_POST['tipo_pago']== 14 ||
          $_POST['tipo_pago']== 13 ||
          $_POST['tipo_pago']== 17 ||
          $_POST['tipo_pago']== 10 ||
          $_POST['tipo_pago']== 22){

       /* optener el ultimo id del abono insertado */

       $sql_ultimo_id = $conexion2 -> query("SELECT max(id) as id
                                              from
                                              maestro_cuota_abono
                                              WHERE
                                              mca_id_cuota_madre = '".$_POST['id_cuota']."'");

        while ($u = $sql_ultimo_id -> fetch_array()){
               $ultimo_id_sub_cuota = $u['id'];
        }

       $sql_insert = $conexion2 -> query("INSERT INTO
                                          movimiento_bancario(
                                          id_cuenta,
                                          id_tipo_movimiento,
                                          mb_fecha,
                                          mb_referencia_numero,
                                          mb_monto,
                                          mb_descripcion,
                                          mb_stat,
                                          id_cliente,
                                          id_proyecto,
                                          id_contrato_venta,
                                          id_cuota,
                                          id_sub_cuota,
                                          referencia_abono_cuota
                                          )VALUES(
                                          '".$_POST['val-skill']."',
                                          '".$_POST['tipo_pago']."',
                                          '".date("Y-m-d", strtotime($_POST['fecha']))."',
                                          '".$_POST['numero_abono']."',
                                          '".$_POST['monto_pagar']."',
                                          '".$_POST['descripcion']."',
                                          1,
                                          '".$_POST['id_cliente']."',
                                          '".$_POST['id_proyecto']."',
                                          '".$_POST['id_contrato_venta']."',
                                          '".$_POST['id_cuota']."',
                                          '".$ultimo_id_sub_cuota."',
                                          '".$_POST['referencia_abono']."')");}

       /* Actrualizar el monto de la cuota */
       $traer_monto_actual = $conexion2 -> query("SELECT mc_monto_abonado FROM maestro_cuotas WHERE id_cuota = '".$_POST['id_cuota']."'");
       while($ll = $traer_monto_actual ->fetch_array()){
             $monto_actual = $ll['mc_monto_abonado'];}
       $total_abnonado = $monto_actual + $_POST['monto_pagar'];
       $sql_actualizar_monto = $conexion2 -> query("UPDATE maestro_cuotas SET mc_monto_abonado = '".$total_abnonado."' WHERE id_cuota = '".$_POST['id_cuota']."'");

       /* fin de las variables de session */
       $id_venta_pase = $_POST['id_contrato_venta'];/* pasar la variable de al listado anterior */
       unset($_SESSION['abono_cuota']);
       /*unset($_SESSION['id_cuota']);*/
       /* ······························ */

       }elseif(isset($_POST['monto_pagar'],
                     $_POST['monto_pendiente'],
                     $_POST['monto_pagado'],
                     $_POST['monto_documento'],
                     $_POST['descripcion'],
                     $_POST['fecha'],
                     $_POST['val-skill'],
                     $_POST['tipo_pago'],
                     $_POST['numero_abono'])){
                       $abono_cuota = array('monto_pagar'=>$_POST['monto_pagar'],
                                            'monto_pendiente'=>$_POST['monto_pendiente'],
                                            'referencia_abono'=>$_POST['referencia_abono'],
                                            'monto_pagado'=>$_POST['monto_pagado'],
                                            'monto_documento'=>$_POST['monto_documento'],
                                            'descripcion'=>$_POST['descripcion'],
                                            'fecha'=>$_POST['fecha'],
                                            'val-skill'=>$_POST['val-skill'],
                                            'tipo_pago'=>$_POST['tipo_pago'],
                                            'numero_abono'=>$_POST['numero_abono']);
                        $_SESSION['abono_cuota']=$abono_cuota;
                     } ?>

<?php require 'inc/config.php'; ?>
<?php require 'inc/views/template_head_start.php'; ?>
<!-- Page JS Plugins CSS -->
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/select2/select2.min.css">
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/select2/select2-bootstrap.min.css">
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/sweetalert/sweetalert.min.css">
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/bootstrap-datepicker/bootstrap-datepicker3.min.css">

<?php require 'inc/views/template_head_end.php'; ?>

<script type="text/javascript">
$(document).ready(function() {
   $("#datepicker").datepicker();
});
</script>

<?php require 'inc/views/base_head.php'; ?>

<div class="content content-narrow">
    <!-- Forms Row -->
    <?php if(isset($sql_insert)){ ?>
        <div class="col-lg-12">
            <!-- Success Alert -->
            <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h3 class="font-w300 push-15">Registrado</h3>
                <p>El <a class="alert-link" href="javascript:void(0)">pago</a> fue registrado!</p>
            </div>
            <!-- END Success Alert -->
        </div>
    <?php } ?>
    <div class="row">

        <div class="col-lg-12">
            <!-- Bootstrap Forms Validation -->
            <div class="block">
                <div class="block-header">
                    <ul class="block-options">
                        <li>

                        </li>
                    </ul>
                    <h2 class="block-title">Registrar pago de cuota o abono de inmueble</h2>
                    <?php $sql = cuota_id_cuota($conexion2, $_SESSION['id_cuota']); ?>
                    <?php while($lc=$sql->fetch_array()){ ?>
                      <table class="table table-bordered">
                          <thead>
                              <tr>
                                  <th class="text-center">ID DOCUMENTO</th>
                                  <th class="text-center">PROYECTO</th>
                                  <th>GRUPO</th>
                                  <th class="hidden-xs">NOMBRE</th>
                                  <th class="text-center">CODIGO</th>
                                  <th class="text-center">CLIENTE</th>
                                  <th class="text-center">TIPO</th>
                                  <th class="text-center">NUMERO</th>
                              </tr>
                          </thead>
                          <tbody>
                            <tr>
                                <th class="text-center"><?php echo $lc['id_cuota']; ?></th>
                                <th class="text-center"><?php echo $lc['proy_nombre_proyecto']; ?></th>
                                <th><?php echo $lc['gi_nombre_grupo_inmueble']; ?></th>
                                <th class="hidden-xs"><?php echo $lc['mi_nombre']; ?></th>
                                <th class="text-center"><?php echo $lc['mi_codigo_imueble']; ?></th>
                                <th class="text-center"><?php echo $lc['cl_nombre'].' '.$lc['cl_apellido']; ?></th>
                                <th class="text-center"><?php echo $lc['tc_nombre_tipo_cuenta']; ?></th>
                                <th class="text-center"><?php echo $lc['mc_numero_cuota']; ?></th>
                            </tr>
                          </tbody>
                        </table>
                        <?php /* ################ variables para el insert ################### */ ?>
                        <?php $monto_cuota = $lc['mc_monto']; ?>
                        <?php $monto_cuota_abonado = $lc['mc_monto_abonado']; ?>
                        <?php $id_proyecto = $lc['id_proyecto']; ?>
                        <?php $id_codigo_inmueble = $lc['mi_codigo_imueble']; ?>
                        <?php $id_grupo_inmuebles = $lc['id_grupo_inmuebles']; ?>
                        <?php $id_inmueble = $lc['id_inmueble']; ?>
                        <?php $id_cliente = $lc['id_cliente']; ?>
                        <?php $id_contrato_venta = $lc['id_contrato_venta']; ?>
                        <?php $id_cuota = $lc['id_cuota']; ?>


                    <?php } ?>
                </div>
                <div class="block-content block-content-narrow">
                    <!-- jQuery Validation (.js-validation-bootstrap class is initialized in js/pages/base_forms_validation.js) -->
                    <!-- For more examples you can check out https://github.com/jzaefferer/jquery-validation -->
                    <form class="js-validation-bootstrap form-horizontal" action="" method="post" enctype="multipart/form-data">
                      <div class="form-group">
                          <label class="col-md-4 control-label" for="val-email">Numero de Abono <span class="text-danger">*</span>

                          </label>
                          <div class="col-md-7">
                              <?php $numero_cuota_abono = numero_abono($conexion2, $id_cuota); ?>
                              <input class="form-control" value="<?php echo $numero_cuota_abono; ?>" type="text" name="numero_abono" placeholder="Monto documento" readonly="readonly">
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-md-4 control-label" for="val-select2">Tipo de pago</label>
                          <div class="col-md-7">
                              <select class="js-select2 form-control" id="val-select2" data-placeholder="Tipo de pago" name="tipo_pago" style="width: 100%;" required="required">
                                  <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                                  <?php   $sql_rolles = listado_tipo_pago_abono($conexion2); ?>
                                  <?php   while($lista_rolles = $sql_rolles ->fetch_array()){ ?>
                                  <option value="<?php echo $lista_rolles['id_tipo_movimiento_bancario']; ?>"
                                            <?php if(isset($_SESSION['abono_cuota']['tipo_pago'])){
                                                    if($_SESSION['abono_cuota']['tipo_pago']==$lista_rolles['id_tipo_movimiento_bancario']){echo 'selected';}
                                            } ?> ><?php echo $lista_rolles['tmb_nombre']; ?></option>
                                  <?php } ?>
                              </select>
                          </div>
                      </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-skill">Cuenta Receptora
                              <span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <select class="form-control" id="val-skill" name="val-skill">
                                    <option value="">Cuenta Receptora <?php echo $id_proyecto; ?></option>
                                    <?php   $sql_cuenta_receptora = cuenta_receptora($conexion2, $id_proyecto); ?>
                                    <?php   while($lista_cuenta_receptora = $sql_cuenta_receptora ->fetch_array()){ ?>
                                    <option value="<?php echo $lista_cuenta_receptora['id_cuenta_bancaria']; ?>"
                                      <?php if(isset($_SESSION['abono_cuota']['val-skill'])){
                                              if($_SESSION['abono_cuota']['val-skill']==$lista_cuenta_receptora['id_cuenta_bancaria']){ ?> selected <?php }
                                      } ?> > <?php echo $lista_cuenta_receptora['proy_nombre_proyecto']. " // " .$lista_cuenta_receptora['banc_nombre_banco']. " // " .$lista_cuenta_receptora['cta_numero_cuenta']; ?></option>
                                    <?php } ?>
                                    <option value="100">INTERCAMBIO</option>
                                    <option value="101">AJUSTE</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-email">Fecha <span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <input class="js-datepicker form-control" value="<?php if(isset($_SESSION['abono_cuota']['fecha'])){
                                  echo $_SESSION['abono_cuota']['fecha'];
                                } ?>" type="text" id="example-datepicker1" data-date-format="dd-mm-yyyy" name="fecha" placeholder="Fecha" required="required">

                            </div>

                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-email">Referencia <span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <input class="form-control" value="<?php if(isset($_SESSION['abono_cuota']['referencia_abono'])){
                                                                            echo $_SESSION['abono_cuota']['referencia_abono'];} ?>" type="text" name="referencia_abono" placeholder="Referencia">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-suggestions">Descripcion <span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <textarea class="form-control" id="val-suggestions" name="descripcion" rows="3" placeholder="Descripcion" required="required"><?php if(isset($_SESSION['abono_cuota']['descripcion'])){ echo $_SESSION['abono_cuota']['descripcion'];} ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-email">Monto documento <span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <input class="form-control" value="<?php echo $monto_cuota; ?>" type="text" name="monto_documento" placeholder="Monto documento" readonly="readonly">

                            </div>

                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-email">Monto Pagado <span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <?php $monto_cuota_abonado = suma_monto_cuota_abonado($conexion2, $id_cuota); ?>
                                <input class="form-control" type="text" value="<?php if($monto_cuota_abonado==''){ echo '0'; }else{ echo $monto_cuota_abonado; } ?>" name="monto_pagado" placeholder="Monto pagado" readonly="readonly">

                            </div>

                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-email">Monto Pendiente <span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <input class="form-control" type="text" value="<?php echo $monto_cuota - $monto_cuota_abonado; ?>" name="monto_pendiente" placeholder="Monto pendiente" readonly="readonly">

                            </div>

                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-password">Monto a pagar <span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <input class="form-control" type="number" max="<?php echo $monto_cuota - $monto_cuota_abonado; ?>" value="<?php if(isset($_SESSION['abono_cuota']['monto_pagar'])){
                                  echo $_SESSION['abono_cuota']['monto_pagar'];
                                } ?>" id="val-password" name="monto_pagar" placeholder="Ingrese el monto" required="required">
                            </div>
                        </div>
                        <?php if(isset($_SESSION['abono_cuota'])){ ?>
                                 <input type="hidden" name="confirmacion" value="1">
                        <?php } ?>
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <?php if(isset($_POST['confirmacion'])){ ?> Registro Realizado, usted sera redireccionado.

                                  <?php  if(isset($_POST['confirmacion'])){?>

                                          <script type="text/javascript">
                                              function redireccionarPagina() {
                                                window.location = "gc_ver_documentos_contrato.php?id_venta=<?php echo $id_venta_pase; ?>";
                                              }
                                              setTimeout("redireccionarPagina()", 5000);
                                          </script>

                                  <?php }  ?>

                                <?php }elseif(isset($_SESSION['abono_cuota']['monto_pagar'])){ ?>
                                <button class="btn btn-sm btn-primary" type="submit">Confirmar Registro</button>
                                <?php }else{ ?>
                                <button class="btn btn-sm btn-primary" type="submit">Registrar</button>
                                <?php } ?>
                            </div>

                        </div>
                        <input type="hidden" name="id_proyecto" value="<?php echo $id_proyecto; ?>">
                        <input type="hidden" name="id_grupo_inmuebles" value="<?php echo $id_grupo_inmuebles; ?>">
                        <input type="hidden" name="id_inmueble" value="<?php echo $id_inmueble; ?>">
                        <input type="hidden" name="id_codigo_inmueble" value="<?php echo $id_codigo_inmueble; ?>">
                        <input type="hidden" name="id_cliente" value="<?php echo $id_cliente; ?>">
                        <input type="hidden" name="id_contrato_venta" value="<?php echo $id_contrato_venta; ?>">
                        <input type="hidden" name="id_cuota" value="<?php echo $id_cuota; ?>">
                    </form>
            </div>
            <!-- Bootstrap Forms Validation -->
        </div>
    </div>
</div>
</div>
<?php require 'inc/views/base_footer.php'; ?>
<?php require 'inc/views/template_footer_start.php'; ?>
<script type="text/javascript" src="bootstrap-filestyle.min.js"> </script>

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
        App.initHelpers(['datepicker', 'datetimepicker', 'colorpicker', 'maxlength', 'select2', 'masked-inputs', 'rangeslider', 'tags-inputs']);
    });
</script>

<?php require 'inc/views/template_footer_end.php'; ?>
<?php }else{ ?>
        <script type="text/javascript">
            window.location="index.php";
        </script>
<?php } ?>
