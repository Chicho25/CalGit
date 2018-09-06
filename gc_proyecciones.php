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
<?php $catidad_alquileres = $conexion2 -> query("
select (select count(*) from maestro_ventas where mv_status not in(17) and id_proyecto = 13 and MONTH(fecha_venta) = 01 and YEAR(NOW())) as enero,
       (select count(*) from maestro_ventas where mv_status not in(17) and id_proyecto = 13 and MONTH(fecha_venta) = 02 and YEAR(NOW())) as febrero,
       (select count(*) from maestro_ventas where mv_status not in(17) and id_proyecto = 13 and MONTH(fecha_venta) = 03 and YEAR(NOW())) as marzo,
       (select count(*) from maestro_ventas where mv_status not in(17) and id_proyecto = 13 and MONTH(fecha_venta) = 04 and YEAR(NOW())) as abril,
       (select count(*) from maestro_ventas where mv_status not in(17) and id_proyecto = 13 and MONTH(fecha_venta) = 05 and YEAR(NOW())) as mayo,
       (select count(*) from maestro_ventas where mv_status not in(17) and id_proyecto = 13 and MONTH(fecha_venta) = 06 and YEAR(NOW())) as junio,
       (select count(*) from maestro_ventas where mv_status not in(17) and id_proyecto = 13 and MONTH(fecha_venta) = 07 and YEAR(NOW())) as julio,
       (select count(*) from maestro_ventas where mv_status not in(17) and id_proyecto = 13 and MONTH(fecha_venta) = 08 and YEAR(NOW())) as agosto,
       (select count(*) from maestro_ventas where mv_status not in(17) and id_proyecto = 13 and MONTH(fecha_venta) = 09 and YEAR(NOW())) as septiembre,
       (select count(*) from maestro_ventas where mv_status not in(17) and id_proyecto = 13 and MONTH(fecha_venta) = 10 and YEAR(NOW())) as octubre,
       (select count(*) from maestro_ventas where mv_status not in(17) and id_proyecto = 13 and MONTH(fecha_venta) = 11 and YEAR(NOW())) as noviembre,
       (select count(*) from maestro_ventas where mv_status not in(17) and id_proyecto = 13 and MONTH(fecha_venta) = 12 and YEAR(NOW())) as diciembre ");
while ($list_alquileres = $catidad_alquileres -> fetch_array()) {
       $enero = $list_alquileres['enero'];
       $febrero = $list_alquileres['febrero'];
       $marzo = $list_alquileres['marzo'];
       $abril = $list_alquileres['abril'];
       $mayo = $list_alquileres['mayo'];
       $junio = $list_alquileres['junio'];
       $julio = $list_alquileres['julio'];
       $agosto = $list_alquileres['agosto'];
       $septiembre = $list_alquileres['septiembre'];
       $octubre = $list_alquileres['octubre'];
       $noviembre = $list_alquileres['noviembre'];
       $diciembre = $list_alquileres['diciembre'];
} ?>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script type="text/javascript">
$(function () {
$('#lineas').highcharts({
    title: {
        text: 'Contratos de Alquileres',
        x: -20 //center
    },
    subtitle: {
        text: '',
        x: -20
    },
    xAxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
            'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
    },
    yAxis: {
        title: {
            text: 'Cantidades'
        },
        plotLines: [{
            value: 0,
            width: 1,
            color: '#808080'
        }]
    },
    tooltip: {
        valueSuffix: ''
    },
    legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'middle',
        borderWidth: 0
    },
    series: [{
        name: 'Recaudado',
        data: [<?php echo $enero; ?>, <?php echo $febrero; ?>, <?php echo $marzo; ?>, <?php echo $abril; ?>, <?php echo $mayo; ?>,
               <?php echo $junio; ?>, <?php echo $julio; ?>, <?php echo $agosto; ?>, <?php echo $septiembre; ?>, <?php echo $octubre; ?>,
               <?php echo $noviembre; ?>, <?php echo $diciembre; ?>]
    }]
});
});
</script>
<?php

      $ocupado_disponible = $conexion2 -> query("select(
                                                  select
                                                  count(*) as contar
                                                  from
                                                  maestro_inmuebles mi left join maestro_ventas mv on mi.id_inmueble = mv.id_inmueble
                                                  where
                                                  mi.mi_status not in(17)
                                                  and
                                                  mi.id_grupo_inmuebles in(23,25,26)
                                                  and
                                                  mi.id_proyecto = 13
                                                  and
                                                  mv.mv_status not in(17)) as ocupado,
                                                  (select
                                                  count(*) as contar
                                                  from
                                                  maestro_inmuebles mi left join maestro_ventas mv on mi.id_inmueble = mv.id_inmueble
                                                  where
                                                  mi.mi_status not in(17)
                                                  and
                                                  mi.id_grupo_inmuebles in(23,25,26)
                                                  and
                                                  mi.id_proyecto = 13) as total");
      while($list_ocu_disp = $ocupado_disponible -> fetch_array()){
            $ocupado = $list_ocu_disp['ocupado'];
            $total = $list_ocu_disp['total'];
      }
            $disponible = $total - $ocupado;

 ?>
<script type="text/javascript">
$(function () {
$('#pie').highcharts({
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false
    },
    title: {
        text: 'Slip Disponibles & Ocupados'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                style: {
                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                }
            }
        }
    },
    series: [{
        type: 'pie',
        name: 'Marina',
        data: [
            ['Ocupados: <?php echo $ocupado; ?> Slip ',   <?php echo $ocupado; ?>],
            {
                name: 'Disponibles: <?php echo $disponible; ?> Slip ',
                y: <?php echo $disponible; ?>,
                sliced: true,
                selected: true
            }
        ]
    }]
});
});


</script>

<?php

  $montos = $conexion2 -> query("select (select sum(mc_monto) from maestro_cuotas where id_grupo in(23,25,26) and id_proyecto = 13 and MONTH(mc_fecha_vencimiento) = 01 and YEAR(NOW())) as enero,
       (select sum(mc_monto) from maestro_cuotas where id_grupo in(23,25,26) and id_proyecto = 13 and MONTH(mc_fecha_vencimiento) = 02 and YEAR(NOW())) as febrero,
       (select sum(mc_monto) from maestro_cuotas where id_grupo in(23,25,26) and id_proyecto = 13 and MONTH(mc_fecha_vencimiento) = 03 and YEAR(NOW())) as marzo,
       (select sum(mc_monto) from maestro_cuotas where id_grupo in(23,25,26) and id_proyecto = 13 and MONTH(mc_fecha_vencimiento) = 04 and YEAR(NOW())) as abril,
       (select sum(mc_monto) from maestro_cuotas where id_grupo in(23,25,26) and id_proyecto = 13 and MONTH(mc_fecha_vencimiento) = 05 and YEAR(NOW())) as mayo,
       (select sum(mc_monto) from maestro_cuotas where id_grupo in(23,25,26) and id_proyecto = 13 and MONTH(mc_fecha_vencimiento) = 06 and YEAR(NOW())) as junio,
       (select sum(mc_monto) from maestro_cuotas where id_grupo in(23,25,26) and id_proyecto = 13 and MONTH(mc_fecha_vencimiento) = 07 and YEAR(NOW())) as julio,
       (select sum(mc_monto) from maestro_cuotas where id_grupo in(23,25,26) and id_proyecto = 13 and MONTH(mc_fecha_vencimiento) = 08 and YEAR(NOW())) as agosto,
       (select sum(mc_monto) from maestro_cuotas where id_grupo in(23,25,26) and id_proyecto = 13 and MONTH(mc_fecha_vencimiento) = 09 and YEAR(NOW())) as septiembre,
       (select sum(mc_monto) from maestro_cuotas where id_grupo in(23,25,26) and id_proyecto = 13 and MONTH(mc_fecha_vencimiento) = 10 and YEAR(NOW())) as octubre,
       (select sum(mc_monto) from maestro_cuotas where id_grupo in(23,25,26) and id_proyecto = 13 and MONTH(mc_fecha_vencimiento) = 11 and YEAR(NOW())) as noviembre,
       (select sum(mc_monto) from maestro_cuotas where id_grupo in(23,25,26) and id_proyecto = 13 and MONTH(mc_fecha_vencimiento) = 12 and YEAR(NOW())) as diciembre,
       (select sum(mc_monto) from maestro_cuotas where id_grupo in(23,25,26) and id_proyecto = 13 and MONTH(mc_fecha_vencimiento) = 01 and YEAR(NOW())) as enero2,
            (select sum(mc_monto_abonado) from maestro_cuotas where id_grupo in(23,25,26) and id_proyecto = 13 and MONTH(mc_fecha_vencimiento) = 02 and YEAR(NOW())) as febrero2,
            (select sum(mc_monto_abonado) from maestro_cuotas where id_grupo in(23,25,26) and id_proyecto = 13 and MONTH(mc_fecha_vencimiento) = 03 and YEAR(NOW())) as marzo2,
            (select sum(mc_monto_abonado) from maestro_cuotas where id_grupo in(23,25,26) and id_proyecto = 13 and MONTH(mc_fecha_vencimiento) = 04 and YEAR(NOW())) as abril2,
            (select sum(mc_monto_abonado) from maestro_cuotas where id_grupo in(23,25,26) and id_proyecto = 13 and MONTH(mc_fecha_vencimiento) = 06 and YEAR(NOW())) as junio2,
            (select sum(mc_monto_abonado) from maestro_cuotas where id_grupo in(23,25,26) and id_proyecto = 13 and MONTH(mc_fecha_vencimiento) = 05 and YEAR(NOW())) as mayo2,
            (select sum(mc_monto_abonado) from maestro_cuotas where id_grupo in(23,25,26) and id_proyecto = 13 and MONTH(mc_fecha_vencimiento) = 07 and YEAR(NOW())) as julio2,
            (select sum(mc_monto_abonado) from maestro_cuotas where id_grupo in(23,25,26) and id_proyecto = 13 and MONTH(mc_fecha_vencimiento) = 08 and YEAR(NOW())) as agosto2,
            (select sum(mc_monto_abonado) from maestro_cuotas where id_grupo in(23,25,26) and id_proyecto = 13 and MONTH(mc_fecha_vencimiento) = 09 and YEAR(NOW())) as septiembre2,
            (select sum(mc_monto_abonado) from maestro_cuotas where id_grupo in(23,25,26) and id_proyecto = 13 and MONTH(mc_fecha_vencimiento) = 10 and YEAR(NOW())) as octubre2,
            (select sum(mc_monto_abonado) from maestro_cuotas where id_grupo in(23,25,26) and id_proyecto = 13 and MONTH(mc_fecha_vencimiento) = 11 and YEAR(NOW())) as noviembre2,
            (select sum(mc_monto_abonado) from maestro_cuotas where id_grupo in(23,25,26) and id_proyecto = 13 and MONTH(mc_fecha_vencimiento) = 12 and YEAR(NOW())) as diciembre2");

       while ($list_alquileres = $montos -> fetch_array()) {
              $enero = $list_alquileres['enero'];
              $febrero = $list_alquileres['febrero'];
              $marzo = $list_alquileres['marzo'];
              $abril = $list_alquileres['abril'];
              $mayo = $list_alquileres['mayo'];
              $junio = $list_alquileres['junio'];
              $julio = $list_alquileres['julio'];
              $agosto = $list_alquileres['agosto'];
              $septiembre = $list_alquileres['septiembre'];
              $octubre = $list_alquileres['octubre'];
              $noviembre = $list_alquileres['noviembre'];
              $diciembre = $list_alquileres['diciembre'];
              $enero2 = $list_alquileres['enero2'];
              $febrero2 = $list_alquileres['febrero2'];
              $marzo2 = $list_alquileres['marzo2'];
              $abril2 = $list_alquileres['abril2'];
              $mayo2 = $list_alquileres['mayo2'];
              $junio2 = $list_alquileres['junio2'];
              $julio2 = $list_alquileres['julio2'];
              $agosto2 = $list_alquileres['agosto2'];
              $septiembre2 = $list_alquileres['septiembre2'];
              $octubre2 = $list_alquileres['octubre2'];
              $noviembre2 = $list_alquileres['noviembre2'];
              $diciembre2 = $list_alquileres['diciembre2'];

 } ?>

<script type="text/javascript">
$(function () {
$('#lineas2').highcharts({
    title: {
        text: 'Recaudado & Fijado Cuotas',
        x: -20 //center
    },
    subtitle: {
        text: '',
        x: -20
    },
    xAxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
            'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
    },
    yAxis: {
        title: {
            text: 'Cantidades'
        },
        plotLines: [{
            value: 0,
            width: 1,
            color: '#808080'
        }]
    },
    tooltip: {
        valueSuffix: ''
    },
    legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'middle',
        borderWidth: 0
    },
    series: [{
        name: 'Recaudado',
        data: [<?php echo $enero2; ?>, <?php echo $febrero2; ?>, <?php echo $marzo2; ?>, <?php echo $abril2; ?>, <?php echo $mayo2; ?>,
               <?php echo $junio2; ?>, <?php echo $julio2; ?>, <?php echo $agosto2; ?>, <?php echo $septiembre2; ?>, <?php echo $octubre2; ?>,
               <?php echo $noviembre2; ?>, <?php echo $diciembre2; ?>]
    }, {
        name: 'Fijado Cuotas',
        data: [<?php echo $enero; ?>, <?php echo $febrero; ?>, <?php echo $marzo; ?>, <?php echo $abril; ?>, <?php echo $mayo; ?>,
               <?php echo $junio; ?>, <?php echo $julio; ?>, <?php echo $agosto; ?>, <?php echo $septiembre; ?>, <?php echo $octubre; ?>,
               <?php echo $noviembre; ?>, <?php echo $diciembre; ?>]
    }]
});
});
</script>

<!-- Page JS Plugins CSS -->
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/select2/select2.min.css">
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/select2/select2-bootstrap.min.css">
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/sweetalert/sweetalert.min.css">

<?php require 'inc/views/template_head_end.php'; ?>
<?php require 'inc/views/base_head.php'; ?>
<div class="content content-narrow">
  <script src="graficas/js/highcharts.js"></script>
  <script src="graficas/js/modules/exporting.js"></script>
    <!-- Forms Row -->
    <div class="row">
        <div class="col-lg-12">
            <!-- Bootstrap Forms Validation -->
            <div class="block">
                <div class="block-header">
                    <ul class="block-options">
                        <li>
                        </li>
                    </ul>
                    <h3 class="block-title">Estadisticas y Proyecciones</h3><small> Alquileres</small>
                </div>
                <div class="block-content block-content-narrow">
                  <div id="lineas" style="min-width: 600px; height: 400px; margin: 0 auto"></div>
                  <hr>
                  <div id="pie" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
                  <hr>
                  <div id="lineas2" style="min-width: 600px; height: 400px; margin: 0 auto"></div>

                </div>
            <!-- Bootstrap Forms Validation -->
            </div>
          </div>
        </div>
<?php   require 'inc/views/base_footer.php'; ?>
<!--<script src="<?php echo $one->assets_folder; ?>/js/core/jquery.min.js"></script>-->
<script src="<?php echo $one->assets_folder; ?>/js/core/bootstrap.min.js"></script>
<script src="<?php echo $one->assets_folder; ?>/js/core/jquery.slimscroll.min.js"></script>
<script src="<?php echo $one->assets_folder; ?>/js/core/jquery.scrollLock.min.js"></script>
<script src="<?php echo $one->assets_folder; ?>/js/core/jquery.appear.min.js"></script>
<script src="<?php echo $one->assets_folder; ?>/js/core/jquery.countTo.min.js"></script>
<script src="<?php echo $one->assets_folder; ?>/js/core/jquery.placeholder.min.js"></script>
<script src="<?php echo $one->assets_folder; ?>/js/core/js.cookie.min.js"></script>
<script src="<?php echo $one->assets_folder; ?>/js/app.js"></script>
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
