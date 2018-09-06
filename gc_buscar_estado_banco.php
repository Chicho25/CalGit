<?php if(!isset($_SESSION)){session_start();}?>
<?php /* if (isset($_SESSION['nombre_banco'])) { ?>
<?php unset($_SESSION['nombre_banco']); ?>
  <script type="text/javascript">
    window.location="gc_buscar_estado_banco.php";
  </script>
<?php } */ ?>
<?php require("conexion/conexion.php"); ?>
<?php require("funciones/funciones.php"); ?>
<?php if(isset($_SESSION['session_gc'])){ ?>
<?php $header_bar = 'base_header.php'; ?>
<?php $menu = true; ?>
<?php /* ################ AUDITORIA DE SEGUIMIENTO ############## */ ?>
<?php require("funciones/funciones_auditorias.php"); ?>
<?php $lugar_mapa = 54; ?>
<?php $dispositivo_acceso = obtener_dispositivo(); ?>
<?php insertar_log_seguimiento($conexion2, ObtenerIP(), $dispositivo_acceso, $lugar_mapa, $_SESSION['session_gc']['usua_id']); ?>
<?php /* ######################################################## */ ?>

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

<?php require 'inc/views/base_head.php'; ?>

<div class="content content-narrow">
      <div class="row">

          <div class="col-lg-12">
              <div class="block">
                  <div class="block-header">
                      <ul class="block-options">
                          <li>

                          </li>
                      </ul>
                      <h3 class="block-title">seleccione una cuenta</h3><small> Seleccione una cuenta para proceder con la consulta</small>
                  </div>
                  <div class="block-content block-content-narrow">
                      <form class="js-validation-bootstrap form-horizontal" action="ver_estado_cuentas.php" method="post">
                          <div class="form-group">

                              <div class="col-md-12">
                                  <select onchange="mostrarValor(this.options[this.selectedIndex].innerHTML);" class="js-select2 form-control" id="val-select2" name="cuenta" style="width: 100%;" data-placeholder="Seleccionar cuenta" required="required">
                                      <option></option>
                                      <?php $sql_cuenta = selecionar_estado_cuenta($conexion2); ?>
                                      <?php while($lista_cuentas = $sql_cuenta -> fetch_array()){ ?>
                                      <option value="<?php echo $lista_cuentas['id_cuenta_bancaria']; ?>"
                                      ><?php echo $lista_cuentas['proy_nombre_proyecto']. ' // ' .$lista_cuentas['banc_nombre_banco']. ' // ' .$lista_cuentas['cta_numero_cuenta']; ?></option>
                                      <?php } ?>
                                  </select>
                              </div>
                          </div>

                          <script type="text/javascript">
                            var mostrarValor = function(x){
                                    document.getElementById('banco').value=x;
                                    }
                          </script>
                          <input type="hidden" name="nombre_banco" id="banco" value="<?php if(isset($_SESSION['nombre_banco'])){ echo $_SESSION['nombre_banco']; } ?>" />

                          <!--<div class="form-group">
                              <div class="col-md-12">
                                  <select class="js-select2 form-control" name="mes" style="width: 100%;" data-placeholder="Seleccionar Mes">
                                      <option></option>
                                      <option value="01">Enero</option>
                                      <option value="02">Febrero</option>
                                      <option value="03">Marzo</option>
                                      <option value="04">Abril</option>
                                      <option value="05">Mayo</option>
                                      <option value="06">Junio</option>
                                      <option value="07">Julio</option>
                                      <option value="08">Agosto</option>
                                      <option value="09">Septiembre</option>
                                      <option value="10">Octubre</option>
                                      <option value="11">Noviembre</option>
                                      <option value="12">Diciembre</option>
                                  </select>
                              </div>
                          </div>

                          <div class="form-group">
                              <div class="col-md-12">
                                  <select class="js-select2 form-control" name="anio" style="width: 100%;" data-placeholder="Seleccionar Año">
                                      <option></option>
                                      <option value="2016">2016</option>
                                      <option value="2017">2017</option>
                                      <option value="2018">2018</option>
                                  </select>
                              </div>
                          </div> -->

                          <div class="form-group">
                              <label class="col-md-4 control-label" for="val-password">Rango de Fecha</label>
                              <div class="col-md-7">
                                  <div class="input-group input-daterange doc">
                                      <input type="text" autocomplete="off" class="js-datepicker form-control fechas1" name="fdoc_inicio" placeholder="Desde">
                                      <div style="min-width: 0px" class="input-group-addon"></div>
                                      <input type="text" autocomplete="off" class="js-datepicker form-control fechas1" name="fdoc_fin" placeholder="Hasta">
                                  </div>
                              </div>
                          </div>

                      <?php if(isset($_SESSION['session_mb'])){?> <input type="hidden" name="confirmacion" value="1"> <?php } ?>
                      <div class="form-group">
                          <div class="col-md-6 col-md-offset-3">
                            <button class="btn btn-sm btn-primary" type="submit" style="width: 100%;">Buscar</button>
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
