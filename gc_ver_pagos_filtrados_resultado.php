<?php if(!isset($_SESSION)){session_start();}?>
<?php require("conexion/conexion.php"); ?>
<?php require("funciones/funciones.php"); ?>
<?php if(isset($_SESSION['session_gc'])){ ?>
<?php $header_bar = 'base_header.php'; ?>
<?php $menu = true; ?>
<?php /* ################ AUDITORIA DE SEGUIMIENTO ############## */ ?>
<?php require("funciones/funciones_auditorias.php"); ?>
<?php $lugar_mapa = 60; ?>
<?php $dispositivo_acceso = obtener_dispositivo(); ?>
<?php insertar_log_seguimiento($conexion2, ObtenerIP(), $dispositivo_acceso, $lugar_mapa, $_SESSION['session_gc']['usua_id']); ?>
<?php /* ######################################################## */ ?>
<?php if(isset($_POST['eliminar'])){

        $eliminar_movimiento = $conexion2 ->query("delete from movimiento_bancario where id_unico_insert = '".$_POST['eliminar']."'");

} ?>
<?php if(isset($_POST['nombre_comercial'], $_POST['razon_social'],
                                                $_POST['ruc'],
                                                    $_POST['telefono_1'],
                                                        $_POST['telefono_2'],
                                                            $_POST['descripcion'],
                                                        $_POST['estado'],
                                                    $_POST['id_pais'],
                                                $_POST['id_proveedor'])){ ?>
<?php $sql_update_proveedor = mysqli_query($conexion2, "update maestro_proveedores set pro_nombre_comercial = '".strtoupper($_POST['nombre_comercial'])."',
                                                                                       pro_razon_social = '".strtoupper($_POST['razon_social'])."',
                                                                                       pro_ruc = '".strtoupper($_POST['ruc'])."',
                                                                                       pro_telefono_1 = '".strtoupper($_POST['telefono_1'])."',
                                                                                       pro_telefono_2 = '".strtoupper($_POST['telefono_2'])."',
                                                                                       pro_descripcion = '".strtoupper($_POST['descripcion'])."',
                                                                                       pro_status = '".strtoupper($_POST['estado'])."',
                                                                                       pro_email = '".strtoupper($_POST['email'])."',
                                                                                       pro_pais = '".strtoupper($_POST['id_pais'])."' where id_proveedores = '".$_POST['id_proveedor']."'");

############################# Auditoria ##############################


#######################################################################
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
<?php require 'inc/config.php'; ?>
<?php require 'inc/views/template_head_start.php'; ?>
<!-- Page JS Plugins CSS -->
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/datatables/jquery.dataTables.min.css">
<?php require 'inc/views/template_head_end.php'; ?>
<?php require 'inc/views/base_head.php'; ?>
<!-- Page Header -->
<div class="content bg-gray-lighter">
    <div class="row items-push">
        <div class="col-sm-7">
            <h1 class="page-heading">
              Ver todos los documentos pagados <small>ver o editar documentos pagados.</small>
            </h1>
        </div>
        <?php if(isset($sql_update_proveedor)){ ?>
    <div class="col-sm-3 col-lg-3" style="position: absolute; right: 0px;">
      <!-- Success Alert -->
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h3 class="font-w300 push-15">Datos Actualizados</h3>
            <p><a class="alert-link" href="javascript:void(0)">Los datos</a> fueron actualizados!</p>
        </div>
      <!-- END Success Alert -->
    </div>
    <?php } ?>
    </div>
</div>
<!-- END Page Header -->
<!-- Page Content -->
<div class="content">
<!-- Dynamic Table Full -->
    <div class="block">
        <div class="block-header">
            <h3 class="block-title">Tabla de documentos pagos <small>todos los documentos pagos</small></h3>
        </div>
        <div class="block-content">
            <!-- DataTables init on table by adding .js-dataTable-full class, functionality initialized in js/pages/base_tables_datatables.js -->
            <table class="table table-bordered table-striped js-dataTable-full">
                <thead>
                    <tr>
                        <th class="text-center" >ID</th>
                        <th class="text-center" >PARTIDA</th>
                        <th class="text-center" >TIPO</th>
                        <th class="text-center" >PROVEEDOR</th>
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

                    <?php if(isset($_POST['id_factura'],
                                    $_POST['id_pago'],
                                      $_POST['proyecto'],
                                        $_POST['id_proveedor'],
                                          $_POST['tipo_movimiento'],
                                            $_POST['desde'],
                                              $_POST['hasta'],
                                                $_POST['numero_cheque'],
                                                  $_POST['status'])){

                        /*  echo $_POST['id_factura'].'<br>';
                                        echo  $_POST['id_pago'].'<br>';
                                          echo  $_POST['proyecto'].'<br>';
                                            echo  $_POST['id_proveedor'].'<br>';
                                              echo  $_POST['tipo_movimiento'].'<br>';
                                                echo  $_POST['desde'].'<br>';
                                                  echo  $_POST['hasta'].'<br>';
                                                    echo  $_POST['numero_cheque'].'<br>';
                                                      echo  $_POST['status'].'<br>';*/

                          $documento_partida = ver_pagos_emitidos_filtros($conexion2,
                                                                             $_POST['id_factura'],
                                                                                $_POST['id_pago'],
                                                                                  $_POST['proyecto'],
                                                                                    $_POST['id_proveedor'],
                                                                                      $_POST['tipo_movimiento'],
                                                                                        $_POST['desde'],
                                                                                          $_POST['hasta'],
                                                                                            $_POST['numero_cheque'],
                                                                                              $_POST['status']);

                          }else{ ?>

                    <?php $documento_partida = ver_documentos_emision_pago_pro_formulario($conexion2);} ?>
                    <?php while($lista_documento_partida = $documento_partida -> fetch_array()){ ?>

                    <tr>
                        <td class="text-center"><?php echo $lista_documento_partida['id']; ?></td>
                        <td class="text-center"><?php echo $lista_documento_partida['p_nombre']; ?></td>
                        <td class="text-center"><?php echo $lista_documento_partida['nombre']; ?></td>
                        <td class="text-center"><?php echo $lista_documento_partida['pro_nombre_comercial']; ?></td>
                        <td class="text-center"><?php echo date("d-m-Y", strtotime($lista_documento_partida['pd_fecha_vencimiento'])); ?></td>
                        <td class="text-center"
                            <?php if($lista_documento_partida['pd_stat']==13){ echo 'style="background-color:red; color:white;"';}
                                    elseif($lista_documento_partida['pd_stat']==15){ echo 'style="background-color:orange;"';}
                                      elseif($lista_documento_partida['pd_stat']==14){ echo 'style="background-color:green; color:white;"';}
                                        elseif($lista_documento_partida['pd_stat']==16){ echo 'style="background-color:black; color:white;"';}?>
                        ><?php if($lista_documento_partida['pd_stat']==13){ echo 'Pendiente por pagar';}
                                elseif($lista_documento_partida['pd_stat']==15){ echo 'Abonada';}
                                  elseif($lista_documento_partida['pd_stat']==14){ echo 'Pagada';}
                                    elseif($lista_documento_partida['pd_stat']==16){ echo 'Anulada';}?></td>
                        <td class="text-center"><?php echo number_format($lista_documento_partida['pd_monto_total'], 2, ',','.'); ?></td>
                        <td class="text-center"><?php echo number_format($lista_documento_partida['pd_monto_abonado'], 2, ',','.'); ?></td>
                        <td class="text-center">

                          <?php echo number_format($lista_documento_partida['pd_monto_total'] - $lista_documento_partida['pd_monto_abonado'], 2, ',','.'); ?>

                        </td>
                        <td class="text-center">
                          <div class="form-group">
                            <?php if($lista_documento_partida['pd_stat']!=14){ ?>
                            <form action="gc_emitir_pago_3.php" method="post">
                              <button class="btn btn-default" type="submit"><i class="fa fa-dollar"></i></button>
                              <input type="hidden" name="id_factura" value="<?php echo $lista_documento_partida['id']; ?>" >
                              <input type="hidden" name="id_proveedor" value="<?php echo $_SESSION['id_proveedor']; ?>">
                              <input type="hidden" name="nombre_proveedor" value="<?php echo $lista_documento_partida['pro_nombre_comercial']; ?>">
                            </form>
                            <?php } ?>
                          </div>
                        </td>
                        <td class="text-center">
                          <div class="form-group">
                            <form action="gc_ver_abonos_factura.php" method="post">
                              <button class="btn btn-default" type="submit"><i class="si si-eye"></i></button>
                              <input type="hidden" name="id_factura" value="<?php echo $lista_documento_partida['id']; ?>" >
                              <input type="hidden" name="id_proveedor" value="<?php echo $lista_documento_partida['id_proveedor']; ?>">
                              <input type="hidden" name="nombre_proveedor" value="<?php echo $lista_documento_partida['pro_nombre_comercial']; ?>">
                            </form>
                          </div>
                        </td>
                        <td class="text-center">
                          <div class="btn-group">
                            <?php if($_SESSION['session_gc']['roll'] == 1 || $_SESSION['session_gc']['roll'] == 3){ ?>
                              <?php if(comprobar_documentos_pagos($conexion2, $lista_documento_partida['id'])==false){ ?>
                              <button class="btn btn-default" data-toggle="modal" data-target="#modal-popina<?php echo $lista_documento_partida['id']; ?>" type="submit"><i class="fa fa-trash-o"></i></button>
                              <?php }else {

                              } ?>
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
                        <th class="text-right" colspan="6">Total</th>
                        <th class="text-center"><?php if(isset($suma)){echo number_format($suma, 2, ',','.');}else{ echo '0';} ?></th>
                        <th class="text-center"><?php if(isset($abonado)){echo number_format($abonado, 2, ',','.');}else{ echo '0';} ?></th>
                        <th class="text-center"><?php if(isset($suma, $abonado)){ echo number_format($suma - $abonado, 2, ',','.');}else{ echo '0';} ?></th>
                        <th class="text-right" colspan="3"></th>
                    </tr>
             </table>

            </div>
      </div>
</div>
<!-- END Page Content -->
<?php require 'inc/views/base_footer.php'; ?>
<?php require 'inc/views/template_footer_start.php'; ?>
<!-- Page JS Plugins -->
<script type="text/javascript" src="bootstrap-filestyle.min.js"> </script>
<script src="<?php echo $one->assets_folder; ?>/js/plugins/datatables/jquery.dataTables.min.js"></script>
<!-- Page JS Code -->
<script src="<?php echo $one->assets_folder; ?>/js/pages/base_tables_datatables.js"></script>
<?php require 'inc/views/template_footer_end.php'; ?>
<?php }else{ ?>
        <script type="text/javascript">
            window.location="salir.php";
        </script>
<?php } ?>
