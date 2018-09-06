<?php if(!isset($_SESSION)){session_start();}?>
<?php require("conexion/conexion.php"); ?>
<?php require("funciones/funciones.php"); ?>
<?php $nombre_pagina = "Emitir Pagos"; ?>
<?php if(isset($_SESSION['session_gc'])){ ?>
<?php $header_bar = 'base_header.php'; ?>
<?php $menu = true; ?>
<?php if(isset($_POST['id_proyecto'])){
      $_SESSION['id_proyecto_pago'] = $_POST['id_proyecto'];
      $_SESSION['id_proveedor'] = $_POST['id_proveedor'];
    }elseif(isset($_GET['id_proveedor'], $_GET['id_proyecto'])){
      $_SESSION['id_proyecto_pago'] = $_GET['id_proyecto'];
      $_SESSION['id_proveedor'] = $_GET['id_proveedor'];
    } ?>
<?php /* ################ AUDITORIA DE SEGUIMIENTO ############## */ ?>
<?php require("funciones/funciones_auditorias.php"); ?>
<?php $lugar_mapa = 59; ?>
<?php $dispositivo_acceso = obtener_dispositivo(); ?>
<?php insertar_log_seguimiento($conexion2, ObtenerIP(), $dispositivo_acceso, $lugar_mapa, $_SESSION['session_gc']['usua_id']); ?>
<?php /* ######################################################## */ ?>
<?php /* ################# Anular documento ##################### */ ?>
<?php if(isset($_POST['anular'])){

        $anular_sub_documentos = $conexion2 -> query("UPDATE partida_documento_abono SET stat = 16 where id_partida_documento = '".$_POST['anular']."'");
        $anular_documentos = $conexion2 -> query("UPDATE partida_documento SET pd_stat = 16 where id = '".$_POST['anular']."'");

} ?>
<?php /* ######################################################## */ ?>
<?php require 'inc/config.php'; ?>
<?php require 'inc/views/template_head_start.php'; ?>
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/bootstrap-datepicker/bootstrap-datepicker3.min.css">
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/select2/select2.min.css">
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/select2/select2-bootstrap.min.css">
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/sweetalert/sweetalert.min.css">
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/datatables/jquery.dataTables.min.css">
<?php require 'inc/views/template_head_end.php'; ?>
<?php require 'inc/views/base_head.php'; ?>


<div class="content">
    <div class="block">
        <div class="block-header">
            <h3 class="block-title"><?php echo $nombre_pagina; ?> Proveedores <small><?php echo $nombre_pagina; ?></small></h3>
            <ul class="block-options">
                <li>

                </li>
            </ul>
          <?php $detalles_documentos = ver_documentos_emision_pago_detalles($conexion2, $_SESSION['id_proyecto_pago'], $_SESSION['id_proveedor']); ?>
          <?php while($lista_detalles_documento = $detalles_documentos -> fetch_array()){ ?>
          <b>Proyecto:</b> <?php echo $lista_detalles_documento['proy_nombre_proyecto']; ?></br>
          <b>Proveedor:</b> <?php echo $lista_detalles_documento['pro_nombre_comercial']; ?></br>
          <?php
            $proveedor = $lista_detalles_documento['pro_nombre_comercial'];
         } ?>
        </div>
        <div class="block-content">
            <!-- DataTables init on table by adding .js-dataTable-full class, functionality initialized in js/pages/base_tables_datatables.js -->

            <div class="table-responsive">
              <input class="btn btn-primary" type="submit" value="Pagar los Seleccionados" name="seleccionados">
            <table class="table table-bordered table-striped js-dataTable-full">
                <thead>
                    <tr>
                        <th class="text-center" >SEL</th>
                        <th class="text-center" >ID</th>
                        <th class="text-center" >PARTIDA</th>
                        <th class="text-center" >TIPO</th>
                        <th class="text-center" >FECHA</th>
                        <th class="text-center" >FECHA VENCIMIENTO</th>
                        <th class="text-center" >STATUS</th>
                        <th class="text-center" >MONTO TOTAL</th>
                        <th class="text-center" >MONTO ABONADO</th>
                        <th class="text-center" >MONTO RESTANTE</th>
                        <th class="text-center" >PAGAR</th>
                        <th class="text-center" >VER PAGOS</th>
                        <th class="text-center" >ANULAR</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $documento_partida = ver_documentos_emision_pago_pro($conexion2, $_SESSION['id_proyecto_pago'], $_SESSION['id_proveedor']); ?>
                    <?php while($lista_documento_partida = $documento_partida -> fetch_array()){ ?>

                    <tr>
                        <td class="text-center"><?php if($lista_documento_partida['pd_stat']==14 || $lista_documento_partida['pd_stat']==16){}else{  ?><input class="form-control" onchange="javascript:showContent()" style="width:25px;" type="checkbox" name="id_pago[]" value="<?php echo $lista_documento_partida['id']; ?>"><?php } ?></td>
                        <td class="text-center"><?php echo $lista_documento_partida['id']; ?></td>
                        <td class="text-center"><?php echo $lista_documento_partida['p_nombre']; ?></td>
                        <td class="text-center"><?php echo $lista_documento_partida['nombre']; ?></td>
                        <td class="text-center"><?php echo $lista_documento_partida['pd_fecha_emision']; ?></td>
                        <td class="text-center"><?php echo $lista_documento_partida['pd_fecha_vencimiento']; ?></td>
                        <td class="text-center"
                            <?php if($lista_documento_partida['pd_stat']==13){ echo 'style="background-color:red; color:white;"';}
                                    elseif($lista_documento_partida['pd_stat']==15){ echo 'style="background-color:orange;"';}
                                      elseif($lista_documento_partida['pd_stat']==14){ echo 'style="background-color:green; color:white;"';}
                                        elseif($lista_documento_partida['pd_stat']==16){ echo 'style="background-color:black; color:white;"';}?>
                        ><?php if($lista_documento_partida['pd_stat']==13){ echo 'Pendiente por pagar';}
                                elseif($lista_documento_partida['pd_stat']==15){ echo 'Abonada';}
                                  elseif($lista_documento_partida['pd_stat']==14){ echo 'Pagada';}
                                    elseif($lista_documento_partida['pd_stat']==16){ echo 'Anulada';}?></td>
                        <td class="text-center"><?php echo $lista_documento_partida['pd_monto_total']; ?></td>
                        <td class="text-center"><?php echo $lista_documento_partida['pd_monto_abonado']; ?></td>
                        <td class="text-center">

                          <?php echo $lista_documento_partida['pd_monto_total'] - $lista_documento_partida['pd_monto_abonado']; ?>

                        </td>
                        <td class="text-center">
                          <div class="form-group">
                            <?php if($lista_documento_partida['pd_stat']!=14){ ?>
                            <form action="gc_emitir_pago_3.php" method="post">
                              <button class="btn btn-default" type="submit"><i class="fa fa-dollar"></i></button>
                              <input type="hidden" name="id_factura" value="<?php echo $lista_documento_partida['id']; ?>" >
                              <input type="hidden" name="id_proveedor" value="<?php echo $_SESSION['id_proveedor']; ?>">
                              <input type="hidden" name="nombre_proveedor" value="<?php echo $proveedor; ?>">
                            </form>
                            <?php } ?>
                          </div>
                        </td>
                        <td class="text-center">
                          <div class="form-group">
                            <form action="gc_ver_abonos_factura.php" method="post">
                              <button class="btn btn-default" type="submit"><i class="si si-eye"></i></button>
                              <input type="hidden" name="id_factura" value="<?php echo $lista_documento_partida['id']; ?>" >
                              <input type="hidden" name="id_proveedor" value="<?php echo $_SESSION['id_proveedor']; ?>">
                              <input type="hidden" name="nombre_proveedor" value="<?php echo $proveedor; ?>">
                            </form>
                          </div>
                        </td>
                        <td class="text-center">
                          <div class="btn-group">
                            <?php if($_SESSION['session_gc']['roll'] == 1 || $_SESSION['session_gc']['roll'] == 3){ ?>
                              <button class="btn btn-default" data-toggle="modal" data-target="#modal-popina<?php echo $lista_documento_partida['id']; ?>" type="submit"><i class="fa fa-trash-o"></i></button>
                            <?php } ?>
                              <div class="modal fade" id="modal-popina<?php echo $lista_documento_partida['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                  <div class="modal-dialog modal-dialog-popin">
                                      <div class="modal-content">
                                          <div class="block block-themed block-transparent remove-margin-b">
                                              <div class="block-header bg-primary-dark">
                                                  <ul class="block-options">
                                                      <li>
                                                          <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                                                      </li>
                                                  </ul>
                                                  <h3 class="block-title">Anular la Factura</h3>
                                              </div>
                                              <div class="block-content">
                                                  <div style="color:red;">Esta seguro que desea Anular la Factura? <br>
                                                  Recuerde que si elimina esta factura se Anularan los abonos dependientes a la misma!</div>
                                                  <br>

                                              </div>
                                          </div>
                                          <div class="modal-footer">
                                            <form class="" action="" method="post">
                                              <button class="btn btn-sm btn-default" type="button" data-dismiss="modal">Cerrar</button>
                                              <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-check"></i> Ok</button>
                                              <input type="hidden" name="anular" value="<?php echo $lista_documento_partida['id']; ?>">
                                            </form>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                        </td>
                    </tr>
                    <?php if($lista_documento_partida['pd_stat'] == 13 || $lista_documento_partida['pd_stat'] == 15){ ?>
                    <?php @$suma+= ($lista_documento_partida['pd_monto_total']); ?>
                    <?php @$abonado+=($lista_documento_partida['pd_monto_abonado']); ?>
                    <?php   } ?>
                    <?php } ?>
               </tbody>
                    <tr>
                        <th class="text-right" colspan="7">Total</th>
                        <th class="text-center"><?php if(isset($suma)){echo $suma;}else{ echo '0';} ?></th>
                        <th class="text-center"><?php if(isset($abonado)){echo $abonado;}else{ echo '0';} ?></th>
                        <th class="text-center"><?php if(isset($suma, $abonado)){ echo $suma - $abonado;}else{ echo '0';} ?></th>
                        <th class="text-right" colspan="3"></th>
                    </tr>
             </table>
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

<script type="text/javascript" src="bootstrap-filestyle.min.js"></script>
<script src="<?php echo $one->assets_folder; ?>/js/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo $one->assets_folder; ?>/js/pages/base_tables_datatables.js"></script>

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
        // Init page helpers (Select2 plugin)
        App.initHelpers('select2');
    });
</script>
<script src="<?php echo $one->assets_folder; ?>/js/pages/base_forms_validation.js"></script>
<!-- Page JS Code -->
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
