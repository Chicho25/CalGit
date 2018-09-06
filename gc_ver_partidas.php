<?php if(!isset($_SESSION)){session_start();}?>
<?php if(isset($_POST['cuenta'])){$_SESSION['id_cuenta'] = $_POST['cuenta'];}  ?>
<?php require("conexion/conexion.php"); ?>
<?php require("funciones/funciones.php"); ?>
<?php $nombre_pagina = "Partidas"; ?>
<?php if(isset($_SESSION['session_gc'])){ ?>
<?php $header_bar = 'base_header.php'; ?>
<?php $menu = true; ?>
<?php /* ################ AUDITORIA DE SEGUIMIENTO ############## */ ?>
<?php require("funciones/funciones_auditorias.php"); ?>
<?php $lugar_mapa = 58; ?>
<?php $dispositivo_acceso = obtener_dispositivo(); ?>
<?php insertar_log_seguimiento($conexion2, ObtenerIP(), $dispositivo_acceso, $lugar_mapa, $_SESSION['session_gc']['usua_id']); ?>
<?php /* ######################################################## */ ?>
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
                Ver todas las <?php echo $nombre_pagina; ?> <small>ver <?php echo $nombre_pagina; ?>.</small>
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
            <h3 class="block-title">Tabla de <?php echo $nombre_pagina; ?> del sistema <small>todos las <?php echo $nombre_pagina; ?></small></h3>
        </div>
        <div class="block-content">
          Zona en consrtuccion
            <!-- DataTables init on table by adding .js-dataTable-full class, functionality initialized in js/pages/base_tables_datatables.js -->
            <?php /* ?><table class="table table-bordered table-striped js-dataTable-full">
                <thead>
                    <tr>
                        <th class="hidden-xs" style="width: 6%;">ID</th>
                        <th class="hidden-xs" style="width: 26%;">NOMBRE</th>
                        <th class="hidden-xs" style="width: 26%;">MONTO ESTIMADO</th>
                        <th class="hidden-xs" style="width: 26%;">MONTO PAGADO</th>
                        <th class="hidden-xs" style="width: 26%;">SALDO</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $estado_cuenta = estado_cuenta_bancario($conexion2, $_SESSION['id_cuenta']); ?>
                    <?php while($lista_estado_cuenta = $estado_cuenta -> fetch_array()){ ?>
                    <tr>
                        <td class="text-center"><?php echo $lista_estado_cuenta['id_movimiento_bancario']; ?></td>
                        <td class="font-w600"><?php echo $lista_estado_cuenta['mb_fecha']; ?></td>
                        <td class="hidden-xs"><?php echo $lista_estado_cuenta['tmb_nombre']; ?></td>
                        <td class="hidden-xs"><?php  ?></td>
                        <td class="font-w600"><?php echo $lista_estado_cuenta['mb_descripcion']; ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <?php */ ?>
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
