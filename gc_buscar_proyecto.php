<?php if(!isset($_SESSION)){session_start();}?>
<?php require("conexion/conexion.php"); ?>
<?php require("funciones/funciones.php"); ?>
<?php if(isset($_SESSION['session_gc'])){ ?>
<?php $header_bar = 'base_header.php'; ?>
<?php $menu = true; ?>
<?php /* ################ AUDITORIA DE SEGUIMIENTO ############## */ ?>
<?php require("funciones/funciones_auditorias.php"); ?>
<?php $lugar_mapa = 56; ?>
<?php $dispositivo_acceso = obtener_dispositivo(); ?>
<?php insertar_log_seguimiento($conexion2, ObtenerIP(), $dispositivo_acceso, $lugar_mapa, $_SESSION['session_gc']['usua_id']); ?>
<?php /* ######################################################## */ ?>

<?php require 'inc/config.php'; ?>
<?php require 'inc/views/template_head_start.php'; ?>
<!-- Page JS Plugins CSS -->
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/select2/select2.min.css">
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/select2/select2-bootstrap.min.css">
<?php require 'inc/views/template_head_end.php'; ?>
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
                      <h3 class="block-title">seleccione un proyecto</h3><small> Seleccione un proyecto para proceder con la consulta</small>
                  </div>
                  <div class="block-content block-content-narrow">
                      <form class="js-validation-bootstrap form-horizontal" action="gc_registrar_documnto.php" method="post">
                          <div class="form-group">
                              <div class="col-md-12">
                                  <select style="width: 100%; display: none" data-placeholder="Seleccionar Proyecto">
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
                                                  <option value="<?php echo $l['id']; ?>"> <?php echo recorer($conexion2, $l['id_categoria']).' // '.$l['p_nombre']; ?> </option>
                                          <?php      }
                                            } ?>

                                      <?php /*echo $lista_proyecto['proyecto'].' // '.$lista_proyecto['p_nombre'];  */ ?>

                                      <?php /*} */ ?>
                                  </select>
                              </div>
                          </div>

                          <div class="form-group">
                              <div class="col-md-12">
                                  <select class="js-select2 form-control" 
                                          id="val-select2" 
                                          name="id_proyecto" 
                                          style="width: 100%;" data-placeholder="Seleccionar Proyecto">
                                    <option></option>
                                    <?php 
                                      $res = $conexion2 -> query("select * from maestro_proyectos"); 
                                      while($fila = $res->fetch_array())
                                      {
                                        ?><option value="<?php echo $fila['id_proyecto']?>"><?php echo $fila['proy_nombre_proyecto']?></option><?php
                                      }
                                    ?>
                                  </select>                                 
                              </div>
                          </div>
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
