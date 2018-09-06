<?php if(!isset($_SESSION)){session_start();}?>
<?php /*unset($_SESSION['session_mb']); ?>
<?php unset($_SESSION['session_ch']);*/ ?>
<?php require("conexion/conexion.php"); ?>
<?php require("funciones/funciones.php"); ?>
<?php if(isset($_SESSION['session_gc'])){ ?>
<?php $header_bar = 'base_header.php'; ?>
<?php $menu = true; ?>
<?php /* ################ AUDITORIA DE SEGUIMIENTO ############## */ ?>
<?php require("funciones/funciones_auditorias.php"); ?>
<?php $lugar_mapa = 50; ?>
<?php $dispositivo_acceso = obtener_dispositivo(); ?>
<?php insertar_log_seguimiento($conexion2, ObtenerIP(), $dispositivo_acceso, $lugar_mapa, $_SESSION['session_gc']['usua_id']); ?>
<?php /* ######################################################## */ ?>

<?php if(isset($_POST['confirmacion'])){}elseif(isset($_POST['id_cuenta_hidden'],
                                                          $_POST['cheque'],
                                                              $_POST['fecha'],
                                                              $_POST['cheque'],
                                                          $_POST['monto'],
                                                      $_POST['descripcion'])){


                            $session_mb = array('id_chequeras'=>$_SESSION['session_ch']['id_chequeras'],
                                                'id_cuenta_hidden'=>$_POST['id_cuenta_hidden'],
                                                    'cheque'=>$_POST['cheque'],
                                                        'fecha'=>$_POST['fecha'],
                                                            'cheque' =>$_POST['cheque'],
                                                        'beneficiario'=>$_POST['beneficiario'],
                                                    'monto'=>$_POST['monto'],
                                                'descripcion'=>$_POST['descripcion'],
                                              'MONTO_LETRAS'=>$_POST['MONTO_LETRAS']);

                                            $_SESSION['session_mb']=$session_mb;

                                            $id_cuenta_obtener = obtenert_id_cuenta_cheque($conexion2, $_SESSION['session_mb']['id_chequeras']);

                                            $sql_insertar = $conexion2 -> query("insert into movimiento_bancario(id_cuenta,
                                                                                                                 id_chequera,
                                                                                                                 id_tipo_movimiento,
                                                                                                                 mb_fecha,
                                                                                                                 mb_referencia_numero,
                                                                                                                 mb_monto,
                                                                                                                 mb_descripcion,
                                                                                                                 mb_stat,
                                                                                                                 cheque_directo
                                                                                                                 )values(
                                                                                                                 '".$id_cuenta_obtener."',
                                                                                                                 '".$_SESSION['session_ch']['id_chequeras']."',
                                                                                                                 8,
                                                                                                                 '".date("Y-m-d", strtotime($_POST['fecha']))."',
                                                                                                                 '".$_POST['cheque']."',
                                                                                                                 '".$_POST['monto']."',
                                                                                                                 '".strtoupper($_POST['descripcion'])."',
                                                                                                                 11,
                                                                                                                 1)");
                                             /* Auditoria */

                                             $tipo_operacion = 1;
                                             $comentario = "Emision de Cheque directo";

                                             $sql_auditoria = $conexion2 -> query("INSERT INTO auditoria_cheques_directos(auchd_tipo_operacion,
                                                                                                                          auchd_usua_log,
                                                                                                                          auchd_comentario,
                                                                                                                          auchd_id_cuenta,
                                                                                                                          auchd_id_chequera,
                                                                                                                          auchd_id_tipo_movimiento,
                                                                                                                          auchd_mb_fecha,
                                                                                                                          auchd_mb_referencia_numero,
                                                                                                                          auchd_mb_monto,
                                                                                                                          auchd_mb_descripcion,
                                                                                                                          auchd_mb_stat,
                                                                                                                          cheque_directo)
                                                                                                                          VALUES
                                                                                                                          ('".$tipo_operacion."',
                                                                                                                           '".$_SESSION['session_gc']['usua_id']."',
                                                                                                                           '".$comentario."',
                                                                                                                           '".$id_cuenta_obtener."',
                                                                                                                           '".$_SESSION['session_ch']['id_chequeras']."',
                                                                                                                           8,
                                                                                                                           '".date("Y-m-d", strtotime($_POST['fecha']))."',
                                                                                                                           '".$_POST['cheque']."',
                                                                                                                           '".$_POST['monto']."',
                                                                                                                           '".strtoupper($_POST['descripcion'])."',
                                                                                                                           11,
                                                                                                                           1)");

                                             /*  Actualizar cheques */
                                             $ctualizar_secuencia_cheque = $conexion2 -> query("update
                                     																													chequeras
                                     																													set
                                     																													chq_ultimo_emitido = '".$_POST['cheque']."'
                                     																													where
                                      																												id_chequeras = '".$_SESSION['session_ch']['id_chequeras']."'");

                                             }elseif(isset($_POST['id_chequeras'])){

                                                $session_ch = array('id_chequeras'=>$_POST['id_chequeras']);

                                              $_SESSION['session_ch']=$session_ch;

                                              } ?>

<?php require 'inc/config.php'; ?>
<?php require 'inc/views/template_head_start.php'; ?>

<!-- Page JS Plugins CSS -->
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/bootstrap-datepicker/bootstrap-datepicker3.min.css">
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/select2/select2.min.css">
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/select2/select2-bootstrap.min.css">
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/sweetalert/sweetalert.min.css">

<?php require 'inc/views/template_head_end.php'; ?>

<script type="text/javascript">
$(document).ready(function() {
   $("#datepicker").datepicker();
});
</script>

<script type="text/javascript">
$("document").ready
	(function()
		//////////////funcion de numeros a letras
		{$("#MONTO").change(function () {

		if($(this).val()!=' '){//alert($(this).val());
						$("#MONTO").each(
								function () {
								//alert($(this).val());
									$.post("incluidos/letras.php",
									{NUM: $(this).val()}, function(data)
									{
										//$(".letra").val(data);
										$(".letra").html(data);
										$("#MONTO_LETRAS").val(data);
				          });
        	    });}
   	        })
          })
</script>

<?php require 'inc/views/base_head.php'; ?>

<div class="content content-narrow">
    <!-- Forms Row -->
    <div class="row">

            <?php if(isset($sql_insertar)){ ?>

                    <!-- Success Alert -->
                    <div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h3 class="font-w300 push-15">Registrado</h3>
                        <p><a class="alert-link" href="javascript:void(0)">Cheque Directo</a> registrado!</p>
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
                    <h3 class="block-title">Registrar movimiento bancario</h3><small> Los campos con <span class="text-danger">*</span> son obligatorios</small>
                </div>
                <div class="block-content block-content-narrow">
                    <!-- jQuery Validation (.js-validation-bootstrap class is initialized in js/pages/base_forms_validation.js) -->
                    <!-- For more examples you can check out https://github.com/jzaefferer/jquery-validation -->

                    <form class="js-validation-bootstrap form-horizontal" action="" method="post">
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-username">Chequera<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <select class="js-select2 form-control" id="val-select2" name="id_chequeras" style="width: 100%;" data-placeholder="Seleccionar cuenta" required="required" onchange="this.form.submit()">
                                    <option></option>
                                    <?php $sql_cuenta = emitir_cheque($conexion2); ?>
                                    <?php while($lista_cuentas = $sql_cuenta -> fetch_array()){ ?>
                                    <option value="<?php echo $lista_cuentas['id_chequeras']; ?>"
                                                   <?php if(isset($_SESSION['session_ch'])){ if($_SESSION['session_ch']['id_chequeras'] == $lista_cuentas['id_chequeras']){ echo 'selected'; }}
                                                            elseif(isset($_SESSION['session_mb'])){ if($_SESSION['session_mb']['id_chequeras'] == $lista_cuentas['id_chequeras']){ echo 'selected'; }}
                                                    ?>
                                     ><?php echo $lista_cuentas['proy_nombre_proyecto']. ' // ' .$lista_cuentas['banc_nombre_banco']. ' // ' .$lista_cuentas['cta_numero_cuenta'].' /Rango/ Desde -> '.$lista_cuentas['chq_chequera_inicial'].' /Hasta/ '.$lista_cuentas['chq_chequera_final']; ?></option>
                                     <?php } ?>
                                </select>
                            </div>
                        </div>
                    </form>

                    <form class="js-validation-bootstrap form-horizontal" action="" method="post">
                      <input class="form-control" type="hidden" id="val-username" name="id_cuenta_hidden" value="<?php echo obtenert_id_cuenta_cheque($conexion2, $_SESSION['session_mb']['id_chequeras']); ?>">
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-username">Cheque <span class="text-danger">*</span></label>
                            <div class="col-md-7">
                              <input class="form-control" type="text" id="val-username" name="cheque" readonly placeholder="Cheque" value="<?php if(isset($_SESSION['session_mb'])){
                                                                                                                                            echo $_SESSION['session_mb']['cheque'];}elseif(isset($_SESSION['session_ch']['id_chequeras'])){
                                                                                                                                              $sql_contar_cheques = contar_cheques($conexion2, $_SESSION['session_ch']['id_chequeras']);
                                                                                                                                              while($lista_contar_cheque = $sql_contar_cheques-> fetch_array()){
                                                                                                                                                    echo $lista_contar_cheque['suma_cheque'];
                                                                                                                                              } } ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-password">Monto<span class="text-danger">*</span></label>
                            <div class="col-md-7">

                              <input class="form-control" type="number" id="MONTO" name="monto" require="require" placeholder="Monto" value="<?php if(isset($_SESSION['session_mb'])){ echo $_SESSION['session_mb']['monto'];} ?>">
                              <div class="letra" id="letra"></div><input name="MONTO_LETRAS" id="MONTO_LETRAS" type="hidden"/>
                            </div>
                        </div>

                        <?php /* ?><span id="sprytextfield1">
                        <input type="text" name="MONTO" id="MONTO" />
                        <span class="textfieldRequiredMsg">Informacion requerida.</span><span class="textfieldInvalidFormatMsg">El formato de monto debe ser expresado en numeros, los decimales separados por punto.</span></span><?php */ ?>


                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-password">Beneficiario<span class="text-danger">*</span></label>
                            <div class="col-md-7">

                              <input class="form-control" autocomplete="off" type="text" id="val-username" name="beneficiario" placeholder="Beneficiario" value="<?php if(isset($_SESSION['session_mb'])){ echo $_SESSION['session_mb']['beneficiario'];} ?>">

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-email">Fecha <span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <input class="js-datepicker form-control" autocomplete="off" type="text" name="fecha" id="example-datepicker1" data-date-format="dd-mm-yyyy" required="required" placeholder="Fecha" value="<?php if(isset($_SESSION['session_mb'])){ echo $_SESSION['session_mb']['fecha'];} ?>">

                            </div>

                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-email">Descripcion <span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <textarea class="form-control" name="descripcion" required="required" placeholder="Descripcion" ><?php if(isset($_SESSION['session_mb'])){ echo $_SESSION['session_mb']['descripcion'];} ?></textarea>
                            </div>

                        </div>

                        <?php if(isset($_SESSION['session_mb'])){?> <input type="hidden" name="confirmacion" value="1"> <?php } ?>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <?php if(isset($_POST['documento_cerrado'])){ ?> Proceso Terminado, usted sera redireccionado <?php }
                                        elseif(isset($_SESSION['session_mb'])){?>
                                            <button class="btn btn-sm btn-primary" type="submit">Cerrar documento</button>
                                            <input type="hidden" name="documento_cerrado" value="1">

                                 <?php }else{ ?> <button class="btn btn-sm btn-primary" type="submit">Imprimir cheque</button> <?php } ?>
                            </div>

                        </div>

                        <?php if(isset($_SESSION['session_mb'])){
                                if(isset($_POST['documento_cerrado'])){}else{
                                    unset($_SESSION['session_ch']);?>

                          <center>
                          <?php /* ?><!--<iframe height="400" width="1000" src="print.php?ID_PAGO=<?php echo $_GET['ID_PAGO'] ?>&BENEFICIARIO=<?php echo $_GET['BENEFICIARIO'] ?>&DESCRIPCION=<?php echo $_GET['DESCRIPCION'] ?>&MONTO=<?php echo $_GET['MONTO'] ?>&MONTO_LETRAS=<?php echo $_GET['MONTO_LETRAS'] ?>"></iframe>--> */ ?>
                          <?php /* ?><iframe height="400" width="1000" src="incluidos/print.php?ID_PAGO=<?php echo $_SESSION['session_mb']['cheque']; ?>&BENEFICIARIO=<?php echo $_SESSION['session_mb']['beneficiario']; ?>&DESCRIPCION=<?php echo $_SESSION['session_mb']['descripcion']; ?>&MONTO=<?php echo $_SESSION['session_mb']['monto']; ?>&MONTO_LETRAS=<?php echo $_SESSION['session_mb']['MONTO_LETRAS']; ?>"></iframe> */?>
                          <?php

                          /* cheque */

                          $fecha = date("d/m/Y");

                          $dia1 = $fecha[0];
                          $dia2 = $fecha[1];
                          $mes1 = $fecha[3];
                          $mes2 = $fecha[4];
                          $ano1 = $fecha[6];
                          $ano2 = $fecha[7];
                          $ano3 = $fecha[8];
                          $ano4 = $fecha[9];

                          $fecha_total = $dia1.' '.$dia2.' '.' '.$mes1.' '.' '.$mes2.' '.' '.' '.$ano1.' '.$ano2.' '.' '.$ano3.' '.' '.$ano4;

                              $archivo= "cheque.txt";
                              $l1 = "C2".chr(27)."!".chr(8);
                              $l2 = "";
                              $l3 = "";
                              $l4 = "";
                              /* $l5 = "M                                                                    ".$fecha_total; */
							  $l5 = "".chr(27)."!".chr(8)."M                                                                    ".$fecha_total;
                              $l6 = "";
                              $l7 = "";
                              $l8 = "M                     ".$_SESSION['session_mb']['beneficiario']."";
                              $l9 = "M                                                                           "."**".number_format($_SESSION['session_mb']['monto'],2)."**";
                              $l10 = "M                   "."**".$_SESSION['session_mb']['MONTO_LETRAS']."**";
                              $l11 = "";
                              $l12 = "";
                              $l13 = "";
                              $l14 = "";
                              $l15 = "";
                              $l16 = "";
                              $l17 = "";
                              $l18 = "";
                              $l19 = "";
                              $l20 = "";
                              $l21 = "";
                              $l22 = "";
                              $l23 = "";
                              $l24 = "";
                              $l25 = "";
                              $l26 = "";
                              $l27 = "M      BENEFICIARIO: ".$_SESSION['session_mb']['beneficiario'];
                              $l28 = "";
                              $l29 = "M            DETALLE                                            MONTO";
                              $l30 = "M   _____________________________________________________________________________________________";
                              $l31 = "M      ".$_SESSION['session_mb']['descripcion']."                         **".number_format($_SESSION['session_mb']['monto'],2)."**";
                              $l32 = "M                                         Total----->  **".number_format($_SESSION['session_mb']['monto'],2)."**";
                              $l33 = "";
                              $l34 = "M   Preparado por: _____________________________    Aprobado por: ___________________________";
                              $l35 = "";
                              $l36 = "M   Recibido por: ___________________    Nombre:___________________  Cedula:_________________";
                              $l37 = "";
                              $l38 = "";
                              $l39 = "";
                              $l40 = "";
                              $l41 = "";
                              $l42 = "";
                              $l43 = "";
                              $l44 = "";
                              $l45 = "";
                              $l46 = "";
                              $l47 = "";
                              $l48 = "";
                              $l49 = "";
                              $l50 = "";
                              $l51 = "";
                              $l52 = "";
                              $l53 = "M                                                                             ";
                              $l54 ="";


                              /*$contenido13 = $_POST['n_fact'];*/

                              $fch= fopen($archivo, "w");
                             /* fwrite($fch, $l1.PHP_EOL); */
                              fwrite($fch, $l2.PHP_EOL);
                              fwrite($fch, $l3.PHP_EOL);
                              fwrite($fch, $l4.PHP_EOL);
                              fwrite($fch, $l5.PHP_EOL);
                              fwrite($fch, $l6.PHP_EOL);
                              fwrite($fch, $l7.PHP_EOL);
                              fwrite($fch, $l8.PHP_EOL);
                              fwrite($fch, $l9.PHP_EOL);
                              fwrite($fch, $l10.PHP_EOL);
                              fwrite($fch, $l11.PHP_EOL);
                              fwrite($fch, $l12.PHP_EOL);
                              fwrite($fch, $l13.PHP_EOL);
                              fwrite($fch, $l14.PHP_EOL);
                              fwrite($fch, $l15.PHP_EOL);
                              fwrite($fch, $l16.PHP_EOL);
                              fwrite($fch, $l17.PHP_EOL);
                              fwrite($fch, $l18.PHP_EOL);
                              fwrite($fch, $l19.PHP_EOL);
                              fwrite($fch, $l20.PHP_EOL);
                              fwrite($fch, $l21.PHP_EOL);
                              fwrite($fch, $l22.PHP_EOL);
                              fwrite($fch, $l23.PHP_EOL);
                              fwrite($fch, $l24.PHP_EOL);
                              fwrite($fch, $l25.PHP_EOL);
                              fwrite($fch, $l26.PHP_EOL);
                              fwrite($fch, $l27.PHP_EOL);
                              fwrite($fch, $l28.PHP_EOL);
                              fwrite($fch, $l29.PHP_EOL);
                              fwrite($fch, $l30.PHP_EOL);
                              fwrite($fch, $l31.PHP_EOL);
                              fwrite($fch, $l32.PHP_EOL);
                              fwrite($fch, $l33.PHP_EOL);
                              fwrite($fch, $l37.PHP_EOL);
                              fwrite($fch, $l38.PHP_EOL);
                              fwrite($fch, $l39.PHP_EOL);
                              fwrite($fch, $l34.PHP_EOL);
                              fwrite($fch, $l35.PHP_EOL);
                              fwrite($fch, $l36.PHP_EOL);
                              fwrite($fch, $l40.PHP_EOL);
                              fwrite($fch, $l41.PHP_EOL);
                              fwrite($fch, $l42.PHP_EOL);
                              fwrite($fch, $l43.PHP_EOL);
                              /*fwrite($fch, $l44.PHP_EOL);
                              fwrite($fch, $l45.PHP_EOL);
                              fwrite($fch, $l46.PHP_EOL);
                              fwrite($fch, $l47.PHP_EOL);
                              fwrite($fch, $l48.PHP_EOL);
                              fwrite($fch, $l49.PHP_EOL);
                              fwrite($fch, $l50.PHP_EOL);
                              fwrite($fch, $l51.PHP_EOL);
                              fwrite($fch, $l52.PHP_EOL);
                              fwrite($fch, $l53.PHP_EOL);*/
                              fwrite($fch, $l54.PHP_EOL);

                              fclose($fch);

                              system('cheques.bat');

                           ?>
                          </center>


                        <?php }} ?>

                    </form>
            </div>
            <!-- Bootstrap Forms Validation -->
        </div>
    </div>
</div>
</div>


<?php if(isset($_POST['documento_cerrado'])){

        unset($_SESSION['session_mb']); ?>

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
        App.initHelpers(['datepicker', 'datetimepicker', 'colorpicker', 'maxlength', 'select2', 'masked-inputs', 'rangeslider', 'tags-inputs']);
    });
</script>
<?php require 'inc/views/template_footer_end.php'; ?>
<?php }else{ ?>

        <script type="text/javascript">
            window.location="salir.php";
        </script>

<?php } ?>
