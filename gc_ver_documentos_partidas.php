<?php if(!isset($_SESSION)){session_start();}?>
<?php if(isset($_POST['cuenta'])){$_SESSION['id_cuenta'] = $_POST['cuenta'];}  ?>
<?php require("conexion/conexion.php"); ?>
<?php require("funciones/funciones.php"); ?>
<?php $nombre_pagina = "Documentos partidas"; ?>
<?php if(isset($_SESSION['session_gc'])){ ?>
<?php $header_bar = 'base_header.php'; ?>
<?php $menu = true; ?>

<?php if(isset($_POST['eliminar'])){

/* Borrarel monto de la factura en el arbol */

  function recorer_arbol_factura_resta($conexion, $id_partida, $monto_anterior){


          $resta = $monto_anterior;

          $sql_datos_partida = $conexion -> query("select * from maestro_partidas where id = '".$id_partida."'");
          while($ld = $sql_datos_partida -> fetch_array()){
                $id=$ld['id'];
                $id_categoria=$ld['id_categoria'];
                $reservado=$ld['p_reservado'];
                $monto_con = $ld['p_monto'];
          }


          $total_reservado = $reservado - $resta;

          $sql_insert = $conexion ->query("UPDATE maestro_partidas SET p_reservado = '".$total_reservado."' WHERE id = '".$id."'");
          /* comprovar si llego a su totalidad de monto */
          if($monto_con == $total_reservado){
              $sql_up = $conexion ->query("UPDATE maestro_partidas SET tiene_pagos = 1 WHERE id = '".$id."'");
          }

          if($id_categoria == ''){

          }else{
          recorer_arbol_factura_resta($conexion, $id_categoria, $monto_anterior);
        }


  }

  recorer_arbol_factura_resta($conexion2, $_POST['id_partida'], $_POST['m_total_anterior']);


        /*$eliminar_movimiento = $conexion2 ->query("delete from partida_documento_abono where id_partida_documento = '".$_POST['eliminar']."'");*/
        $eliminar_movimiento = $conexion2 ->query("delete from partida_documento where id = '".$_POST['eliminar']."'");
        $eliminar_movimiento = $conexion2 ->query("delete from movimiento_bancario where id_partida_documento = '".$_POST['eliminar']."'");


} ?>

<?php /* funcion para comprobar sitiene pagos emitidos  */ ?>

<?php function comprobar_documentos_pagos($conexion, $id){ ?>
<?php $sql_comprobar_pago = $conexion -> query("select count(*) as contar from partida_documento_abono where id_partida_documento = '".$id."'"); ?>
<?php while($lcp = $sql_comprobar_pago -> fetch_array()){
            $contador = $lcp['contar'];
        } ?>
<?php if($contador>0){
        return true;
      }else{
        return false;
            } ?>
<?php } ?>


<?php /* ################### update del registro ################ */
      if(isset($_POST['id'],
                $_POST['proveedor'],
                  $_POST['tipo_documento'],
                    $_POST['fecha_emision'],
                      $_POST['fecha_vencimiento'],
                        $_POST['descripcion'],
                          $_POST['monto_exento'],
                            $_POST['monto_gravable'],
                              $_POST['impuesto'],
                                $_POST['total'])){

                                  $update_documento_partida = $conexion2 -> query("update partida_documento set id_proveedor = '".$_POST['proveedor']."',
                                                                                                                tipo_documento = '".$_POST['tipo_documento']."',
                                                                                                                pd_fecha_emision = '".date("Y-m-d", strtotime($_POST['fecha_emision']))."',
                                                                                                                pd_fecha_vencimiento = '".date("Y-m-d", strtotime($_POST['fecha_vencimiento']))."',
                                                                                                                pd_descripcion = '".$_POST['descripcion']."',
                                                                                                                pd_monto_exento = '".$_POST['monto_exento']."',
                                                                                                                pd_monto_gravable = '".$_POST['monto_gravable']."',
                                                                                                                pd_impuesto = '".$_POST['impuesto']."',
                                                                                                                pd_monto_total = '".$_POST['total']."' where id = '".$_POST['id']."'");



                        function recorer_arbol_factura($conexion, $id_partida, $monto, $monto_anterior){

                                $resta = $monto - $monto_anterior;

                                $sql_datos_partida = $conexion -> query("select * from maestro_partidas where id = '".$id_partida."'");
                                while($ld = $sql_datos_partida -> fetch_array()){
                                      $id=$ld['id'];
                                      $id_categoria=$ld['id_categoria'];
                                      $reservado=$ld['p_reservado'];
                                      $monto_con = $ld['p_monto'];
                                }


                                $total_reservado = $reservado + $resta;

                                $sql_insert = $conexion ->query("UPDATE maestro_partidas SET p_reservado = '".$total_reservado."' WHERE id = '".$id."'");
                                /* comprovar si llego a su totalidad de monto */
                                if($monto_con == $total_reservado){
                                    /*$sql_up = $conexion ->query("UPDATE maestro_partidas SET tiene_pagos = 1 WHERE id = '".$id."'");*/
                                }

                                if($id_categoria == ''){

                                }else{
                                recorer_arbol_factura($conexion, $id_categoria, $monto, $monto_anterior);
                              }


                        }

                        function recorer_arbol_factura_resta($conexion, $id_partida, $monto, $monto_anterior){

                                $resta = $monto_anterior - $monto ;

                                $sql_datos_partida = $conexion -> query("select * from maestro_partidas where id = '".$id_partida."'");
                                while($ld = $sql_datos_partida -> fetch_array()){
                                      $id=$ld['id'];
                                      $id_categoria=$ld['id_categoria'];
                                      $reservado=$ld['p_reservado'];
                                      $monto_con = $ld['p_monto'];
                                }


                                $total_reservado = $reservado - $resta;

                                $sql_insert = $conexion ->query("UPDATE maestro_partidas SET p_reservado = '".$total_reservado."' WHERE id = '".$id."'");
                                /* comprovar si llego a su totalidad de monto */
                                if($monto_con == $total_reservado){
                                  /*  $sql_up = $conexion ->query("UPDATE maestro_partidas SET tiene_pagos = 1 WHERE id = '".$id."'"); */
                                }

                                if($id_categoria == ''){

                                }else{
                                recorer_arbol_factura_resta($conexion, $id_categoria, $monto, $monto_anterior);
                              }


                        }

                        if($_POST['m_total_anterior'] < $_POST['total']){

                        recorer_arbol_factura($conexion2, $_POST['id_partida'], $_POST['total'], $_POST['m_total_anterior']);

                        $update_documento_partida_stat = $conexion2 -> query("update partida_documento set pd_stat = 15 where id = '".$_POST['id']."'");

                        }elseif($_POST['m_total_anterior'] > $_POST['total']){

                        recorer_arbol_factura_resta($conexion2, $_POST['id_partida'], $_POST['total'], $_POST['m_total_anterior']);

                      }

                    }
?>
<?php /* ################ AUDITORIA DE SEGUIMIENTO ############## */ ?>
<?php require("funciones/funciones_auditorias.php"); ?>
<?php $lugar_mapa = 53; ?>
<?php $dispositivo_acceso = obtener_dispositivo(); ?>
<?php insertar_log_seguimiento($conexion2, ObtenerIP(), $dispositivo_acceso, $lugar_mapa, $_SESSION['session_gc']['usua_id']); ?>
<?php /* ######################################################## */ ?>

<?php require 'inc/config.php'; ?>
<?php require 'inc/views/template_head_start.php'; ?>
<!-- Page JS Plugins CSS -->
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/bootstrap-datepicker/bootstrap-datepicker3.min.css">
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/datatables/jquery.dataTables.min.css">
<?php require 'inc/views/template_head_end.php'; ?>
<?php require 'inc/views/base_head.php'; ?>

<script type="text/javascript">
  function suma_campos()
  {
    elem_1 = (isNaN(document.getElementById("text1").value) || document.getElementById("text1").value == "") ? "0" : document.getElementById("text1").value;
    elem_2 = (isNaN(document.getElementById("text2").value) || document.getElementById("text2").value == "") ? "0" : document.getElementById("text2").value;
    document.getElementById("text3").value = parseInt(elem_1) + parseInt(elem_2) + (parseInt(elem_2) * 7 / 100);
    document.getElementById("text4").value = parseInt(elem_2) * 7 / 100;
  }
</script>
<!-- Page Header -->
<div class="content bg-gray-lighter">
    <div class="row items-push">
        <div class="col-sm-7">
            <h1 class="page-heading">
                Ver todos los <?php echo $nombre_pagina; ?> <small>ver <?php echo $nombre_pagina; ?>.</small>
            </h1>
        </div>
    </div>
</div>
<!-- END Page Header -->
<?php if(isset($update_documento_partida)){ ?>
    <div class="col-sm-3 col-lg-3" style="position: absolute; right: 0px;">
        <!-- Success Alert -->
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h3 class="font-w300 push-15">Registrado</h3>
            <p><a class="alert-link" href="javascript:void(0)">Documento</a> registrado!</p>
        </div>
        <!-- END Success Alert -->
    </div>
<?php } ?>
<!-- Page Content -->

<div class="content">
    <!-- Dynamic Table Full -->

    <div class="block">
        <div class="block-header">
            <h3 class="block-title">Tabla de <?php echo $nombre_pagina; ?> del sistema <small>todos los <?php echo $nombre_pagina; ?></small></h3>
        </div>
        <div class="block-content">
            <!-- DataTables init on table by adding .js-dataTable-full class, functionality initialized in js/pages/base_tables_datatables.js -->
            <div class="table-responsive">
              <?php /*echo $_POST['id'].'<br>';
                    echo $_POST['partida'].'<br>';
                    echo $_POST['id_proveedor'].'<br>';
                    echo $_POST['tipo_documento'].'<br>';
                    echo $_POST['fecha_emision'].'<br>';
                    echo $_POST['fecha_vencimiento'].'<br>'; */ ?>
            <table class="table table-bordered table-striped js-dataTable-full">
                <thead>
                    <tr>
                        <th class="hidden-xs" style="width: 5%;">ID</th>
                        <th class="hidden-xs" style="width: 10%;">PROYECTO</th>
                        <th class="hidden-xs" style="width: 10%;">PARTIDA</th>
                        <th class="hidden-xs" style="width: 10%;">PROVEEDOR</th>
                        <th class="hidden-xs" style="width: 10%;">TIPO</th>
                        <th class="hidden-xs" style="width: 10%;">FECHA VENCIMIENTO</th>
                        <th class="hidden-xs" style="width: 10%;">STATUS</th>
                        <th class="hidden-xs" style="width: 10%;">DESCRIPCION</th>
                        <th class="text-center" style="width: 10%;">MONTO TOTAL</th>
                        <th class="hidden-xs" style="width: 5%;">EDITAR</th>
                        <th class="hidden-xs" style="width: 5%;">VER</th>
                        <th class="hidden-xs" style="width: 5%;">ELIMINAR</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(isset($_POST['id'],
                                    $_POST['partida'],
                                      $_POST['id_proveedor'],
                                       $_POST['tipo_documento'],
                                        $_POST['fdoc_inicio'],
                                          $_POST['fdoc_fin'],
                                            $_POST['fven_inicio'],
                                              $_POST['fven_fin'])){

                     
                    $documento_partida = ver_facturas($conexion2,
                                                          $_POST['id'],
                                                              $_POST['partida'],
                                                                  $_POST['id_proveedor'],
                                                                      $_POST['tipo_documento'],
                                                                          $_POST['fdoc_inicio'],
                                                                              $_POST['fdoc_fin'],
                                                                                  $_POST['fven_inicio'],
                                                                                      $_POST['fven_fin'],                                                                                         
                                                                                          $_POST['status']);
                  
                      
                    
                            }else{

                    $documento_partida = ver_documentos_partidas($conexion2);



                      } ?>

                    <?php while($lista_documento_partida = $documento_partida -> fetch_array()){ ?>
                    <tr>
                        <td class="text-center"><?php echo $lista_documento_partida['id']; ?></td>
                        <td class="font-w600"><?php echo $lista_documento_partida['proy_nombre_proyecto']; ?></td>
                        <td class="hidden-xs"><?php echo utf8_decode($lista_documento_partida['p_nombre']); ?></td>
                        <td class="hidden-xs"><?php echo $lista_documento_partida['pro_nombre_comercial']; ?></td>
                        <td class="font-w600"><?php echo $lista_documento_partida['nombre']; ?></td>
                        <td class="hidden-xs"><?php echo date("d-m-Y", strtotime($lista_documento_partida['pd_fecha_vencimiento'])); ?></td>
                        <td class="text-center"
                            <?php if($lista_documento_partida['pd_stat']==13){ echo 'style="background-color:red; color:white;"';}
                                    elseif($lista_documento_partida['pd_stat']==15){ echo 'style="background-color:orange;"';}
                                      elseif($lista_documento_partida['pd_stat']==14){ echo 'style="background-color:green; color:white;"';}
                                        elseif($lista_documento_partida['pd_stat']==16){ echo 'style="background-color:black; color:white;"';}?>
                        ><?php if($lista_documento_partida['pd_stat']==13){ echo 'Pendiente por pagar';}
                                elseif($lista_documento_partida['pd_stat']==15){ echo 'Abonada';}
                                  elseif($lista_documento_partida['pd_stat']==14){ echo 'Pagada';}
                                    elseif($lista_documento_partida['pd_stat']==16){ echo 'Anulada';}?></td>
                        <td class="hidden-xs"><?php echo $lista_documento_partida['pd_descripcion']; ?></td>
                        <td class="hidden-xs"><?php echo number_format($lista_documento_partida['pd_monto_total'], 2, ',','.'); ?></td>

                        <!-- Modal script -->
                        <script type="text/javascript">
                          $(document).ready(function() {
                            $("#boton<?php echo $lista_documento_partida['id']; ?>").click(function(event) {
                            $("#capa<?php echo $lista_documento_partida['id']; ?>").load('cargas_paginas/ver_facturas_detalle.php?id=<?php echo $lista_documento_partida['id']; ?>');
                            });
                          });
                        </script>

                        <td class="text-center">
                            <div class="btn-group">
                              <button id="boton<?php echo $lista_documento_partida['id']; ?>" class="btn btn-default" data-toggle="modal" data-target="#modal-popin<?php echo $lista_documento_partida['id']; ?>" type="button"><i class="fa fa-pencil"></i></button>
                                <?php /* ?><button class="btn btn-default" data-toggle="modal" data-target="#modal-popin<?php echo $lista_documento_partida['id']; ?>" type="button"><i class="fa fa-pencil"></i></button><?php */ ?>
                            </div>
                        </td>



                        <td class="text-center">

                        </td>
                        <td class="text-center">

                            <div class="btn-group">

                                 <?php if(comprobar_documentos_pagos($conexion2, $lista_documento_partida['id'])==false){ ?>
                                 <button class="btn btn-default" data-toggle="modal" data-target="#modal-popina<?php echo $lista_documento_partida['id']; ?>" type="button"><i class="fa fa-trash-o"></i></button>
                                 <?php }else {

                                 } ?>

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
                                                     <h3 class="block-title">Eliminar &amp; el documento</h3>
                                                 </div>
                                                 <div class="block-content">
                                                     Esta seguro que desea eliminar el documento ?
                                                 </div>
                                             </div>
                                             <div class="modal-footer">
                                               <form class="" action="" method="post">
                                                 <button class="btn btn-sm btn-default" type="button" data-dismiss="modal">Cerrar</button>
                                                 <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-check"></i> Ok</button>
                                                 <input type="hidden" name="eliminar" value="<?php echo $lista_documento_partida['id']; ?>">
                                                 <input type="hidden" name="id_partida" value="<?php echo $lista_documento_partida['id_partida']; ?>">
                                                 <input type="hidden" name="m_total_anterior" value="<?php echo $lista_documento_partida['pd_monto_total']; ?>">
                                               </form>
                                             </div>
                                         </div>
                                     </div>
                                 </div>

                            </div>
                        </td>

                    </tr>

                    <div class="modal fade" id="modal-popin<?php echo $lista_documento_partida['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-popin">
                          <div id="capa<?php echo $lista_documento_partida['id']; ?>" class="modal-content">

                          </div>
                        </div>
                    </div>
                      <?php /*  ?><div class="modal fade" id="modal-popin<?php echo $lista_documento_partida['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-popin">
                              <div class="modal-content">

                              </div>
                          </div>
                      </div><?php */ ?>

                    <?php } ?>
                </tbody>
            </table>
          </div>
        </div>
    </div>
    <!-- END Dynamic Table Full -->

    <!-- Dynamic Table Simple -->

    <!-- END Dynamic Table Simple -->
</div>
<!-- END Page Content -->

<?php require 'inc/views/base_footer.php'; ?>
<?php require 'inc/views/template_footer_start.php'; ?>
<!-- Page JS Plugins -->
<script src="<?php echo $one->assets_folder; ?>/js/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<script src="<?php echo $one->assets_folder; ?>/js/plugins/jquery-auto-complete/jquery.auto-complete.min.js"></script>
<script type="text/javascript" src="bootstrap-filestyle.min.js"></script>
<script src="<?php echo $one->assets_folder; ?>/js/plugins/datatables/jquery.dataTables.min.js"></script>
<!-- Page JS Code -->
<script src="<?php echo $one->assets_folder; ?>/js/pages/base_tables_datatables.js"></script>
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
