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
      /*  alert("Error"); */
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
    /*  alert("Error"); */
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
    <div class="row">
        <?php if(isset($sql_insertar)){ ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h3 class="font-w300 push-15">Contrato de venta</h3>
                    <p>El <a class="alert-link" href="javascript:void(0)">Contrato de venta</a> registrado!</p>
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
                    <h3 class="block-title">Filtros Buscar Inmuebles</h3>
                </div>
                <div class="block-content block-content-narrow">
                    <form class="js-validation-bootstrap form-horizontal" action="gc_ver_inmuebles.php" method="post">
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-username">Proyecto<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                  <select id="pais" name="id_proyecto" class="js-select2 form-control" style="width: 100%;">
                                    <option value="">Selecciona Uno...</option>
                                  </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-username">Grupo de inmueble <span class="text-danger">*</span></label>
                            <div class="col-md-7">
                               <select id="estado" name="id_grupo_inmueble" class="js-select2 form-control" style="width: 100%;">
                                  <option value="">Selecciona Uno...</option>
                               </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-username">Inmueble<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                               <select id="ciudad" name="id_inmueble" class="js-select2 form-control" style="width: 100%;">
                                    <option value="">Selecciona Uno...</option>
                               </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-username">Area mts2<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                               <input class="form-control" type="number" name="area" placeholder="Area mts2" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-username">N°. de Habitaciones</label>
                            <div class="col-md-7">
                                <select class="js-select2 form-control" name="n_habitaciones" style="width: 100%;" data-placeholder="Seleccione el numero de Habitaciones">
                                    <option value=""> Seleccione el numero de Habitaciones</option>
                                    <option value="0">0</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-username">N°. de Sanitarios</label>
                            <div class="col-md-7">
                                <select class="js-select2 form-control" name="n_sanitarios" style="width: 100%;" data-placeholder="Seleccione el numero de Sanitarios">
                                    <option value=""> Seleccione el numero de Sanitarios</option>
                                    <option value="0">0</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-username">N°. de Despositos</label>
                            <div class="col-md-7">
                                <select class="js-select2 form-control" name="n_depositos" style="width: 100%;" data-placeholder="N°. de Despositos">
                                    <option value=""> Seleccione el numero de Despositos</option>
                                    <option value="0">0</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-username">N°. de Estacionamientos</label>
                            <div class="col-md-7">
                                <select class="js-select2 form-control" name="n_estacionamientos" style="width: 100%;" data-placeholder="Seleccionar un Cliente">
                                    <option value=""> Seleccione el numero de Estacionamientos</option>
                                    <option value="0">0</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-username">Status</label>
                            <div class="col-md-7">
                                <select class="js-select2 form-control" name="status" style="width: 100%;" data-placeholder="Status">
                                    <option value=""> Seleccione el status</option>
                                    <?php $sql_status = $conexion2-> query("Select * from maestro_status where st_numero in(1, 2, 3)");
                                          foreach ($sql_status as $key => $value) {?>
                                    <option value="<?php echo $value['st_numero']; ?>"><?php echo $value['st_nombre']; ?></option>
                                  <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button class="btn btn-sm btn-primary" type="submit">Buscar</button>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>

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
