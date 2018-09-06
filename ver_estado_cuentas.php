<?php if(!isset($_SESSION)){session_start();}?>
<?php if(isset($_POST['cuenta'])){

         $_SESSION['nombre_banco'] = $_POST['nombre_banco'];
         $_SESSION['id_cuenta'] = $_POST['cuenta'];
         $_SESSION['fdoc_inicio'] = $_POST['fdoc_inicio'];
         $_SESSION['fdoc_fin'] = $_POST['fdoc_fin'];

        } ?>
<?php require("conexion/conexion.php"); ?>
<?php require("funciones/funciones.php"); ?>

<?php $nombre_pagina = "Estado de cuentas"; ?>
<?php if(isset($_SESSION['session_gc'])){ ?>
<?php $header_bar = 'base_header.php'; ?>
<?php $menu = true; ?>
<?php /* ################ AUDITORIA DE SEGUIMIENTO ############## */ ?>
<?php require("funciones/funciones_auditorias.php"); ?>
<?php $lugar_mapa = 53; ?>
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
                Ver todos los <?php echo $nombre_pagina; ?> <small>ver <?php echo $nombre_pagina; ?>.</small>
            </h1>
        </div>
    </div>
</div>
<!-- END Page Header -->

<!-- Page Content -->

<div class="content" style="margin-top:-40px;">
    <!-- Dynamic Table Full -->
    <div class="block">
        <div class="block-header">
          <div class="block-options">
            <form class="" action="reporteExcel.php" method="post" target="_blank">
                <button class="btn btn-primary" name="excel">Excel</button>
            </form>
          </div>
            <h3 class="block-title"><?php if(isset($_SESSION['nombre_banco'])){ echo $_SESSION['nombre_banco']; } ?></h3>
        </div>

        <div class="block-content">
            <!-- DataTables init on table by adding .js-dataTable-full class, functionality initialized in js/pages/base_tables_datatables.js -->
            <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <!--<th class="text-center" style="width: 5%;" >ID</th>-->
                        <th class="hidden-xs" style="width: 10%;">DÍA</th>
                        <th class="hidden-xs" style="width: 10%;">TIPO</th>
                        <th class="hidden-xs" style="width: 10%;">REFERENCIA</th>
                        <th class="hidden-xs" style="width: 3%;">NUMERO</th>
                        <th class="text-center" style="width: 50px;">DESCRIPCION</th>
                        <th class="hidden-xs" style="width: 15%;">CLIENTE/PROVEEDOR</th>
                        <th class="hidden-xs" style="width: 5%;">DEBITO</th>
                        <th class="hidden-xs" style="width:5%;">CREDITO</th>
                        <th class="text-center" style="width: 5%;">SALDO</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $estado_cuenta = estado_cuenta_bancario($conexion2, $_SESSION['id_cuenta'], $_SESSION['fdoc_inicio'], $_SESSION['fdoc_fin']); ?>
                    <?php //$_numeros = $estado_cuenta->num_rows; ?>
                    <?php //$lista  = $estado_cuenta->fetch_all(MYSQLI_ASSOC);
                            // js-dataTable-full
                            /*$debito=0;
                            $credito=0;
                            $saldo=0;*/
                        while ($lista_estado_cuenta = $estado_cuenta->fetch_array()) { ?>
                         <tr>
                            <!--<td class="text-center"><?php echo $lista_estado_cuenta['id_movimiento_bancario']; ?></td>-->
                            <td class="hidden-xs"><?php echo $lista_estado_cuenta['mb_fecha']; ?></td>
                            <td class="hidden-xs"><?php echo $lista_estado_cuenta['nombre_tipo']; ?></td>
                            <td class="text-center"><?php echo $lista_estado_cuenta['id_movimiento_bancario']; ?></td>
                            <td class="hidden-xs"><?php echo ($lista_estado_cuenta['tmb_nombre'] != 'CHEQUE') ? "---" : ($lista_estado_cuenta['mb_numero_cheque'] == 0) ? $lista_estado_cuenta['mb_referencia_numero'] : $lista_estado_cuenta['mb_numero_cheque']; ?></td>
                            <td class="font-w600"><?php echo $lista_estado_cuenta['mb_descripcion']; ?></td>
                            <td class="hidden-xs"><?php echo $lista_estado_cuenta['pro_nombre_comercial'].' '.$lista_estado_cuenta['cl_nombre'].' '.$lista_estado_cuenta['cl_apellido']; ?></td>
                            <td class="hidden-xs"><?php echo number_format($lista_estado_cuenta['debito'], 2, '.',','); ?></td>
                            <td class="hidden-xs"><?php echo number_format($lista_estado_cuenta['credito'], 2, '.',','); ?></td>
                            <td class="text-center"><?php echo number_format($lista_estado_cuenta['saldo'], 2, '.',','); ?></td>
                        </tr>
                    <?php
                    /*$debito += $lista_estado_cuenta['debito'];
                    $credito += $lista_estado_cuenta['credito'];
                    $saldo += $lista_estado_cuenta['saldo'];*/
                  } ?>
                </tbody>
            </table>
            <?php //echo 'Debito: '.$debito.'Credito: '.$credito.'Saldo: '.$saldo; ?>
          </div>
        </div>
    </div>
</div>
<script>
</script>

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
