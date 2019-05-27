<?php if(!isset($_SESSION)){session_start();}?>
<?php require("conexion/conexion.php"); ?>
<?php require("funciones/funciones.php"); ?>
<?php $nombre_pagina = "Cheque emitidos"; ?>
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
<?php $sql_update_movimiento = $conexion2 -> query("update movimiento_bancario set mb_fecha = '".$_POST['fecha']."',
                                                                                   mb_monto = '".$_POST['monto']."',
                                                                                   mb_referencia_numero = '".$_POST['referencia']."',
                                                                                   mb_descripcion = '".strtoupper($_POST['descripcion'])."',
                                                                                   mb_stat = '".$_POST['stat']."'
                                                                                where
                                                                                   id_movimiento_bancario = '".$_POST['id_movimiento']."'"); } ?>
<?php require 'inc/config.php'; ?>
<?php require 'inc/views/template_head_start.php'; ?>
<!-- Page JS Plugins CSS -->
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/datatables/jquery.dataTables.min.css">
<?php require 'inc/views/template_head_end.php'; ?>

<script type='text/javascript' src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>


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
            <table class="table table-bordered table-striped js-dataTable-full block">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 5%;">ID</th>
                        <th class="text-center" style="width: 10%;">PROYECTO</th>
                        <th class="text-center" style="width: 10%;">BANCO</th>
                        <th class="hidden-xs" style="width: 10%;">CUENTA</th>
                        <th class="hidden-xs" style="width: 10%;">MONTO</th>
                        <th class="hidden-xs" style="width: 10%;">REFERENCIA</th>
                        <th class="hidden-xs" style="width: 10%;">N# CH</th>
                        <th class="hidden-xs" style="width: 10%;">ESTADO</th>
                        <th class="hidden-xs" style="width: 10%;">TIPO DE MOVIMIENTO</th>
                        <th class="hidden-xs" style="width: 10%;">FECHA</th>
                        <th class="text-center" style="width: 10%;">EDITAR</th>
                        <th class="text-center" style="width: 10%;">ELIMINAR</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $todos_movimeintos = ver_cheques_emitidos($conexion2); ?>
                    <?php while($lista_movimiento = $todos_movimeintos -> fetch_array()){ ?>
                    <tr>
                        <td class="text-center"><?php echo $lista_movimiento['id_movimiento_bancario']; ?></td>
                        <td class="font-w600"><?php echo $lista_movimiento['proy_nombre_proyecto']; ?></td>
                        <td class="text-center"><?php echo $lista_movimiento['banc_nombre_banco']; ?></td>
                        <td class="hidden-xs"><?php echo $lista_movimiento['cta_numero_cuenta']; ?></td>
                        <td class="hidden-xs"><?php echo $lista_movimiento['mb_monto']; ?></td>
                        <td class="hidden-xs"><?php echo $lista_movimiento['mb_referencia_numero']; ?></td>
                        <td class="hidden-xs"><?php echo $lista_movimiento['numero_cheque']; ?></td>
                        <td class="hidden-xs"><?php echo $lista_movimiento['st_nombre']; ?></td>
                        <td class="hidden-xs"><?php echo $lista_movimiento['tmb_nombre']; ?></td>
                        <td class="hidden-xs"><?php echo $lista_movimiento['mb_fecha']; ?></td>

                        <script type="text/javascript">
                          $(document).ready(function() {
                            $("#boton<?php echo $lista_movimiento['id_movimiento_bancario']; ?>").click(function(event) {
                              $("#capa<?php echo $lista_movimiento['id_movimiento_bancario']; ?>").load('cargas_paginas/ver_cheques_emitidos_detalle.php?id=<?php echo $lista_movimiento['id_movimiento_bancario']; ?>');
                            });
                          });
                        </script>

                        <script type="text/javascript">
                          $(document).ready(function() {
                            $("#eliminar<?php echo $lista_movimiento['id_movimiento_bancario']; ?>").click(function(event) {
                              $("#capa<?php echo $lista_movimiento['id_movimiento_bancario'].'eli'; ?>").load('cargas_paginas/eliminar_cheques_emitidos.php?id=<?php echo $lista_movimiento['id_movimiento_bancario']; ?>');
                            });
                          });
                        </script>

                        <td class="text-center">
                            <div class="btn-group">
                                <?php /* ?><button id="boton<?php echo $lista_movimiento['id_movimiento_bancario']; ?>" class="btn btn-default" data-toggle="modal" data-target="#modal-popin<?php echo $lista_movimiento['id_movimiento_bancario']; ?>" type="button"><i class="fa fa-pencil"></i></button> */ ?>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="btn-group">
                                <button id="eliminar<?php echo $lista_movimiento['id_movimiento_bancario']; ?>" class="btn btn-default" data-toggle="modal" data-target="#modal-popin<?php echo $lista_movimiento['id_movimiento_bancario'].'eli'; ?>" type="button"><i class="fa fa-trash"></i></button>
                            </div>
                        </td>

                    </tr>

                            <div>
                            <div class="modal fade" id="modal-popin<?php echo $lista_movimiento['id_movimiento_bancario']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-popin">
                                    <div id="capa<?php echo $lista_movimiento['id_movimiento_bancario']; ?>" class="modal-content">

                                    </div>
                                </div>
                            </div>
                            </div>
                            <div>
                            <div class="modal fade" id="modal-popin<?php echo $lista_movimiento['id_movimiento_bancario'].'eli'; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-popin">
                                    <div id="capa<?php echo $lista_movimiento['id_movimiento_bancario'].'eli'; ?>" class="modal-content">

                                    </div>
                                </div>
                            </div>
                            </div>


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
