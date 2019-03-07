<?php if(!isset($_SESSION)){session_start();}?>
<?php require("conexion/conexion.php"); ?>
<?php require("funciones/funciones.php"); ?>
<?php $nombre_pagina = "Movimientos bancarios"; ?>
<?php if(isset($_SESSION['session_gc'])){ ?>
<?php $header_bar = 'base_header.php'; ?>
<?php $menu = true; ?>
<?php /* ################ AUDITORIA DE SEGUIMIENTO ############## */ ?>
<?php require("funciones/funciones_auditorias.php"); ?>
<?php $lugar_mapa = 49; ?>
<?php $dispositivo_acceso = obtener_dispositivo(); ?>
<?php insertar_log_seguimiento($conexion2, ObtenerIP(), $dispositivo_acceso, $lugar_mapa, $_SESSION['session_gc']['usua_id']); ?>
<?php /* ######################################################## */ ?>
<?php /* ################### borrar movimiento bancario ######### */ ?>
<?php if(isset($_POST['eliminar'])){

        $eliminar_movimiento = $conexion2 ->query("delete from movimiento_bancario where id_movimiento_bancario = '".$_POST['eliminar']."'");

} ?>
<?php /* ######################################################## */ ?>
<?php if(isset($_POST['fecha'],
                    $_POST['monto'],
                        $_POST['id_movimiento'])){ ?>
<?php $sql_update_movimiento = $conexion2 -> query("update movimiento_bancario set id_tipo_movimiento = '".$_POST['id_tipo_movimiento_bancario']."',
                                                                                   mb_fecha = '".date("Y-m-d", strtotime($_POST['fecha_movimiento']))."',
                                                                                   mb_monto = '".$_POST['monto']."',
                                                                                   mb_referencia_numero = '".$_POST['referencia']."',
                                                                                   mb_descripcion = '".strtoupper($_POST['descripcion'])."'
                                                                                where
                                                                                   id_movimiento_bancario = '".$_POST['id_movimiento']."'"); } ?>
<?php require 'inc/config.php'; ?>
<?php require 'inc/views/template_head_start.php'; ?>
<!-- Page JS Plugins CSS -->
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/datatables/jquery.dataTables.min.css">
<?php require 'inc/views/template_head_end.php'; ?>
<?php require 'inc/views/base_head.php'; ?>

<!-- Page Header -->
<div class="content bg-gray-lighter">
    <div class="row items-push">
        <?php if(isset($sql_update_movimiento)){ ?>
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
        <div class="col-sm-7">
            <h1 class="page-heading">
                Ver todos los <?php echo $nombre_pagina; ?> <small>ver o editar <?php echo $nombre_pagina; ?>.</small>
            </h1>
        </div>
    </div>
</div>
<!-- END Page Header -->

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
              <?php $total = 0; ?>
            <table class="table table-bordered table-striped js-dataTable-full block">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 5%;">ID</th>
                        <!--<th class="text-center" style="width: 10%;">PROYECTO</th>
                        <th class="text-center" style="width: 10%;">BANCO</th>
                        <th class="hidden-xs" style="width: 10%;">CUENTA</th>
                        <th class="hidden-xs" style="width: 10%;">NUMERO</th>-->
                        <th class="hidden-xs" style="width: 10%;">TIPO DE MOVIMIENTO</th>
                        <th class="hidden-xs" style="width: 10%;">FECHA</th>
                        <th class="hidden-xs" style="width: 10%;">MONTO</th>
                        <th class="text-center" style="width: 10%;">EDITAR</th>
                        <th class="text-center" style="width: 10%;">ELIMINAR</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(isset($_POST['anulado'])){$anulado = $_POST['anulado'];}else{$anulado=0;} ?>
                    <?php if(isset($_POST['cheque_directo'])){$cheque_directo = $_POST['cheque_directo'];}else{$cheque_directo=0;} ?>
                    <?php if(isset($_POST['id_cuenta'],
                                    $_POST['tipo'],
                                         $_POST['numero'],
                                          $_POST['desde'],
                                            $_POST['hasta'],
                                              $anulado,
                                                $cheque_directo)){
                                                  /*echo $_POST['desde'].' | '.$_POST['hasta'];
                                                  echo " Esta pasando<br>";
                                                  echo $_POST['id_cuenta'].'<br>';
                                                  echo $_POST['tipo'].'<br>';
                                                  echo $_POST['id_tipo_movimiento_bancario'].'<br>';
                                                  echo $_POST['numero'].'<br>';
                                                  echo $_POST['desde'].'<br>';
                                                  echo $_POST['hasta'].'<br>';
                                                  echo $anulado.'<br>';
                                                  echo $cheque_directo.'<br>';*/

                          if(!isset($_POST['id_tipo_movimiento_bancario'])){ $tipo_movimiento = "";}else{$tipo_movimiento =$_POST['id_tipo_movimiento_bancario'];}

                          $todos_movimeintos = ver_movimientos_bancarios_filtrados($conexion2,
                                                                                      $_POST['id_cuenta'],
                                                                                        $_POST['tipo'],
                                                                                          $tipo_movimiento,
                                                                                            $_POST['numero'],
                                                                                              $_POST['desde'],
                                                                                                $_POST['hasta'],
                                                                                                  $anulado,
                                                                                                    $cheque_directo,
                                                                                                      $_POST['referencia']);
                          }else{ ?>
                    <?php $todos_movimeintos = ver_movimientos_bancarios($conexion2);} ?>
                    <?php while($lista_movimiento = $todos_movimeintos -> fetch_array()){ ?>
                    <tr>
                        <td class="text-center"><?php echo $lista_movimiento['id_movimiento_bancario']; ?></td>
                      <?php /* ?>  <td class="font-w600"><?php echo $lista_movimiento['proy_nombre_proyecto']; ?></td>
                        <td class="text-center"><?php echo $lista_movimiento['banc_nombre_banco']; ?></td>
                        <td class="hidden-xs"><?php echo $lista_movimiento['cta_numero_cuenta']; ?></td>
                        <td class="hidden-xs"><?php echo $lista_movimiento['cta_numero_cuenta']; ?></td> <?php */ ?>

                        <td class="hidden-xs"><?php echo $lista_movimiento['tmb_nombre']; ?></td>
                        <td class="hidden-xs"><?php echo date("d-m-Y", strtotime($lista_movimiento['mb_fecha'])); ?></td>
                        <td class="hidden-xs"><?php echo number_format($lista_movimiento['mb_monto'], 2, ',','.'); ?></td>
                        <script type="text/javascript">
                          $(document).ready(function() {
                            $("#boton<?php echo $lista_movimiento['id_movimiento_bancario']; ?>").click(function(event) {
                            $("#capa<?php echo $lista_movimiento['id_movimiento_bancario']; ?>").load('cargas_paginas/ver_movimientos_detsalle.php?id=<?php echo $lista_movimiento['id_movimiento_bancario']; ?>');
                            });
                          });
                        </script>
                        <td class="text-center">
                          <?php  ?>
                            <div class="btn-group">
                                <button id="boton<?php echo $lista_movimiento['id_movimiento_bancario']; ?>" class="btn btn-default" data-toggle="modal" data-target="#modal-popin<?php echo $lista_movimiento['id_movimiento_bancario']; ?>" type="button"><i class="fa fa-pencil"></i></button>
                            </div>
                            <?php  ?>
                        </td>


                        <div class="modal fade" id="modal-popin<?php echo $lista_movimiento['id_movimiento_bancario']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-popin">
                              <div id="capa<?php echo $lista_movimiento['id_movimiento_bancario']; ?>" class="modal-content">

                              </div>
                            </div>
                        </div>

                        <td class="text-center">
                          <?php ?>
                            <div class="btn-group">

                                <?php if($lista_movimiento['id_tipo_movimiento']==13 || $lista_movimiento['id_tipo_movimiento']==3 || $lista_movimiento['id_tipo_movimiento']==4 || $lista_movimiento['id_tipo_movimiento']==1|| $lista_movimiento['id_tipo_movimiento']==2|| $lista_movimiento['id_tipo_movimiento']==5|| $lista_movimiento['id_tipo_movimiento']==6){ ?>
                                 <button class="btn btn-default" data-toggle="modal" data-target="#modal-popina<?php echo $lista_movimiento['id_movimiento_bancario']; ?>" type="button"><i class="fa fa-trash-o"></i></button>
                                 <div class="modal fade" id="modal-popina<?php echo $lista_movimiento['id_movimiento_bancario']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                     <div class="modal-dialog modal-dialog-popin">
                                         <div class="modal-content">
                                             <div class="block block-themed block-transparent remove-margin-b">
                                                 <div class="block-header bg-primary-dark">
                                                     <ul class="block-options">
                                                         <li>
                                                             <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                                                         </li>
                                                     </ul>
                                                     <h3 class="block-title">Eliminar &amp; Movimiento Bancario</h3>
                                                 </div>
                                                 <div class="block-content">
                                                     Esta seguro que desea eliminar el movimiento bancario ?
                                                 </div>
                                             </div>
                                             <div class="modal-footer">
                                               <form class="" action="" method="post">
                                                 <button class="btn btn-sm btn-default" type="button" data-dismiss="modal">Cerrar</button>
                                                 <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-check"></i> Ok</button>
                                                 <input type="hidden" name="eliminar" value="<?php echo $lista_movimiento['id_movimiento_bancario']; ?>">
                                               </form>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                                 <?php
                                 $total += $lista_movimiento['mb_monto'];
                               } ?>
                            </div>
                          <?php  ?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
                <tr>
                  <td></td>
                  <td></td>
                  <td><b>Total</b></td>
                  <td><?php echo number_format($total, 2, ',','.');; ?></td>
                  <td></td>
                  <td></td>
                </tr>
            </table>
          </div>
        </div>
    </div>
    <!-- END Dynamic Table Full -->
    <!-- Dynamic Table Simple -->
    <!-- END Dynamic Table Simple -->
</div>

<?php require 'inc/views/base_footer.php'; ?>
<?php require 'inc/views/template_footer_start.php'; ?>
<!-- Page JS Plugins -->
<script type="text/javascript" src="bootstrap-filestyle.min.js"> </script>
<script src="<?php echo $one->assets_folder; ?>/js/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo $one->assets_folder; ?>/js/pages/base_tables_datatables.js"></script>

<!-- Page JS Code -->
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
