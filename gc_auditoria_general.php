<?php if(!isset($_SESSION)){session_start();}?>
<?php require("conexion/conexion.php"); ?>
<?php require("funciones/funciones.php"); ?>
<?php if(isset($_SESSION['session_gc'])){ ?>
<?php $header_bar = 'base_header.php'; ?>
<?php $menu = true; ?>
<?php /* ################ AUDITORIA DE SEGUIMIENTO ############## */ ?>
<?php require("funciones/funciones_auditorias.php"); ?>
<?php $lugar_mapa = 33; ?>
<?php $dispositivo_acceso = obtener_dispositivo(); ?>
<?php insertar_log_seguimiento($conexion2, ObtenerIP(), $dispositivo_acceso, $lugar_mapa, $_SESSION['session_gc']['usua_id']); ?>
<?php /* ######################################################## */ ?>
<?php require 'inc/config.php'; ?>
<?php require 'inc/views/template_head_start.php'; ?>
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/datatables/jquery.dataTables.min.css">
<?php require 'inc/views/template_head_end.php'; ?>
<?php require 'inc/views/base_head.php'; ?>
<div class="content bg-gray-lighter">
    <div class="row items-push">
        <div class="col-sm-7">
            <h1 class="page-heading">
                Auditoria General
            </h1>
        </div>
    </div>
</div>
<div class="content">
    <div class="block">
        <div class="block-header">
            <h3 class="block-title">Auditoria del sistema <small>seguimiento de usuario</small></h3>
        </div>
        <div class="block-content">
            <table class="table table-bordered table-striped js-dataTable-full">
                <thead>
                    <tr>
                        <th class="text-center">Imagen</th>
                        <th>Nombre</th>
                        <th class="hidden-xs">Dispositivo</th>
                        <th class="hidden-xs" style="width: 15%;">Modulo</th>
                        <th class="text-center" style="width: 10%;">IP</th>
                        <th class="text-center" style="width: 10%;">Fecha/Hora</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $auditoria_general = auditoria_general($conexion2); ?>
                    <?php while($lista_auditoria_general = mysqli_fetch_array($auditoria_general)){ ?>
                    <tr>
                        <td class="text-center"><img src="<?php echo $lista_auditoria_general['usua_imagen_usuario']; ?>" width = "40"/></td>
                        <td class="font-w600"><?php echo $lista_auditoria_general['usua_nombre'].' '.$lista_auditoria_general['usua_apellido']; ?></td>
                        <td class="hidden-xs"><?php echo $lista_auditoria_general['aums_dispositivo_acceso']; ?></td>
                        <td class="hidden-xs"><?php echo $lista_auditoria_general['ams_nombre']; ?></td>
                        <td class="hidden-xs"><?php echo $lista_auditoria_general['aums_ip']; ?></td>
                        <td class="text-center"><?php echo $lista_auditoria_general['aums_fecha_hora']; ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php require 'inc/views/base_footer.php'; ?>
<?php require 'inc/views/template_footer_start.php'; ?>
<script type="text/javascript" src="bootstrap-filestyle.min.js"> </script>
<script src="<?php echo $one->assets_folder; ?>/js/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo $one->assets_folder; ?>/js/pages/base_tables_datatables.js"></script>
<?php require 'inc/views/template_footer_end.php'; ?>
<?php }else{ ?>
        <script type="text/javascript">
            window.location="index.php";
        </script>
<?php } ?>
