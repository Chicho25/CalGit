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
<?php if (isset($_POST['slipt_position'])) {

      $update_slip = $conexion2 -> query("update maestro_ventas set id_inmueble = '".$_POST['slipt_position']."' where id_venta = '".$_POST['id_ventas']."'");
      $update_slip1 = $conexion2 -> query("update maestro_cuotas set id_inmueble = '".$_POST['slipt_position']."' where id_contrato_venta = '".$_POST['id_ventas']."'");
      $update_slip2 = $conexion2 -> query("update maestro_cuota_abono set mca_id_inmueble = '".$_POST['slipt_position']."' where mca_id_documento_venta = '".$_POST['id_ventas']."'");
      $update_slip3 = $conexion2 -> query("update maestro_inmuebles set mi_status = 3 where id_inmueble = '".$_POST['slipt_position']."'");
      $update_slip4 = $conexion2 -> query("update maestro_inmuebles set mi_status = 1 where id_inmueble = '".$_POST['slipt_old']."'");

} ?> 

<?php require 'inc/config.php'; ?>
<?php require 'inc/views/template_head_start.php'; ?>
<!-- Page JS Plugins CSS -->
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/select2/select2.min.css">
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/select2/select2-bootstrap.min.css">
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/sweetalert/sweetalert.min.css">

<style media="screen">
  .slipM1{
    height: 20px;
    border-top: 2px black solid;
  }

  .descriptionSlip{
    position: absolute;
    display: none;
    width: 300px;
    height: 300px;
    background-color: green;
    border: 2px black solid;
    float: left;
    margin-left: 150px;
    margin-top: -20px;

  }
  /*.slipM1:hover + .descriptionSlip{
    display: block;
  }*/
  .muelle1{
    position: relative;
    margin-left: 0px;
    border: 2px black solid;
    width: 150px;
    height: 100%;
    text-align: center;
    float: left;
  }

  .muelle2{
    position: relative;
    margin-left: 110px;
    border: 2px black solid;
    width: 150px;
    height: 100%;
    text-align: center;
    float: left;
    margin-top:450px;
  }
  .muelle3{
    position: relative;
    margin-left: 110px;
    border: 2px black solid;
    width: 150px;
    height: 100%;
    text-align: center;
    float: left;
    margin-top:450px;
  }

  .leftmuelle3{
    position: relative;
    width: 73px;
    height: 100%;
    text-align: center;
    float: left;
    border: 1px black solid;
  }

  .slipM3{
    height: 20px;
    border-top: 2px black solid;
  }

  .muelle4{
    position: relative;
    margin-left: 110px;
    border: 2px black solid;
    width: 150px;
    height: 100%;
    text-align: center;
    float: left;
  }

    .slipM4{
    height: 150px;
    border-top: 2px black solid;
  }
</style>
<script type="text/javascript">
</script>
<?php $m1 = $conexion2 -> query("SELECT
                                  *,
                                  count(*)
                                  FROM
                                  maestro_inmuebles mi left join maestro_ventas mv on mi.id_inmueble = mv.id_inmueble
                                  WHERE
                                  mi_nombre like '%M1%'
                                  and
                                  mi_status not in(17)
                                  group by mi_nombre
                                  order by mi_nombre desc"); ?>
<?php $m2 = $conexion2 -> query("SELECT
                                  *,
                                  count(*)
                                  FROM
                                  maestro_inmuebles mi left join maestro_ventas mv on mi.id_inmueble = mv.id_inmueble
                                  WHERE
                                  mi_nombre like '%M2%'
                                  and
                                  mi_status not in(17)
                                  group by mi_nombre"); ?>
<?php $m3l = $conexion2 -> query("SELECT
                                  *,
                                  count(*)
                                  FROM
                                  maestro_inmuebles mi left join maestro_ventas mv on mi.id_inmueble = mv.id_inmueble
                                  WHERE
                                  mi_nombre like 'M3-N%'
                                  and
                                  mi_status not in(17)
                                  group by mi_nombre
                                  order by mi_nombre desc
                                  LIMIT 0, 29"); ?>

<?php $m3r = $conexion2 -> query("SELECT
                                  *,
                                  count(*)
                                  FROM
                                  maestro_inmuebles mi left join maestro_ventas mv on mi.id_inmueble = mv.id_inmueble
                                  WHERE
                                  mi_nombre like 'M3-S%'
                                  and
                                  mi_status not in(17)
                                  group by mi_nombre
                                  order by mi_nombre desc
                                  LIMIT 0, 29"); ?>

<?php $m4 = $conexion2 -> query("SELECT
                                  *,
                                  count(*)
                                  FROM
                                  maestro_inmuebles mi left join maestro_ventas mv on mi.id_inmueble = mv.id_inmueble
                                  WHERE
                                  mi_nombre like '%M4%'
                                  and
                                  mi_status not in(17)
                                  group by mi_nombre
                                  order by mi_nombre desc"); ?>

<?php /*  Graficas */ ?>

<?php $m1_estadisticas = $conexion2 -> query("select (SELECT
                                                count(*)
                                                FROM
                                                maestro_inmuebles mi left join maestro_ventas mv on mi.id_inmueble = mv.id_inmueble
                                                WHERE
                                                mi.id_proyecto=13
                                                and
                                                mi_status not in(17)
                                                and 
                                                mi.id_grupo_inmuebles = 23
                                                and 
                                                isnull(mv.id_inmueble)) as total, 
                                              (SELECT
                                                count(*)
                                                FROM
                                                maestro_inmuebles mi left join maestro_ventas mv on mi.id_inmueble = mv.id_inmueble
                                                WHERE
                                                mi.id_proyecto=13
                                                and
                                                mi_status not in(17)
                                                and 
                                                mi.id_grupo_inmuebles = 23
                                                and 
                                                mv.id_inmueble <> '') as ocupado"); 
                                                      
  while ($grafica_mi = $m1_estadisticas -> fetch_array()) {
    $disponible = $grafica_mi['total'];
    $ocupado = $grafica_mi['ocupado'];
  }  ?>

  <?php $m3_estadisticas = $conexion2 -> query("select (SELECT
                                                count(*)
                                                FROM
                                                maestro_inmuebles mi left join maestro_ventas mv on mi.id_inmueble = mv.id_inmueble
                                                WHERE
                                                mi.id_proyecto=13
                                                and
                                                mi_status not in(17)
                                                and 
                                                mi.id_grupo_inmuebles = 25
                                                and 
                                                isnull(mv.id_inmueble)) as total, 
                                              (SELECT
                                                count(*)
                                                FROM
                                                maestro_inmuebles mi left join maestro_ventas mv on mi.id_inmueble = mv.id_inmueble
                                                WHERE
                                                mi.id_proyecto=13
                                                and
                                                mi_status not in(17)
                                                and 
                                                mi.id_grupo_inmuebles = 25
                                                and 
                                                mv.id_inmueble <> '') as ocupado"); 
                                                      
  while ($grafica_m3 = $m3_estadisticas -> fetch_array()) {
    $disponible3 = $grafica_m3['total'];
    $ocupado3 = $grafica_m3['ocupado'];
  }  ?>

    <?php $m4_estadisticas = $conexion2 -> query("select (SELECT
                                                count(*)
                                                FROM
                                                maestro_inmuebles mi left join maestro_ventas mv on mi.id_inmueble = mv.id_inmueble
                                                WHERE
                                                mi.id_proyecto=13
                                                and
                                                mi_status not in(17)
                                                and 
                                                mi.id_grupo_inmuebles = 26
                                                and 
                                                isnull(mv.id_inmueble)) as total, 
                                              (SELECT
                                                count(*)
                                                FROM
                                                maestro_inmuebles mi left join maestro_ventas mv on mi.id_inmueble = mv.id_inmueble
                                                WHERE
                                                mi.id_proyecto=13
                                                and
                                                mi_status not in(17)
                                                and 
                                                mi.id_grupo_inmuebles = 26
                                                and 
                                                mv.id_inmueble <> '') as ocupado"); 
                                                      
  while ($grafica_m4 = $m4_estadisticas -> fetch_array()) {
    $disponible4 = $grafica_m4['total'];
    $ocupado4 = $grafica_m4['ocupado'];
  }  
  
  
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
$ocupadoT = $list_ocu_disp['ocupado'];
$totalT = $list_ocu_disp['total'];
}
$disponibleT = $totalT - $ocupadoT;
  
  
  ?>


<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script type="text/javascript">
$(function () {
$('#pie').highcharts({
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false
    },
    title: {
        text: 'Slip Disponibles & Ocupados General'
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
        name: 'Marina General',
        data: [
            ['Ocupados: <?php echo $ocupadoT; ?> Slip ',   <?php echo $ocupadoT; ?>],
            {
                name: 'Disponibles: <?php echo $disponibleT; ?> Slip ',
                y: <?php echo $disponibleT; ?>,
                sliced: true,
                selected: true
            }
        ]
    }]
});
});


</script>


<script type="text/javascript">
$(function () {
$('#pieM1').highcharts({
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false
    },
    title: {
        text: 'Estadisticas M1'
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
        name: 'M1',
        data: [
            ['Ocupados M1: <?php echo $ocupado; ?> Slip ',   <?php echo $ocupado; ?>],
            {
                name: 'Disponibles M1: <?php echo $disponible; ?> Slip ',
                y: <?php echo $disponible; ?>,
                sliced: true,
                selected: true
            }
        ]
    }]
});
});


</script>
<script type="text/javascript">
$(function () {
$('#pieM3').highcharts({
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false
    },
    title: {
        text: 'Estadisticas M3'
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
        name: 'M3',
        data: [
            ['Ocupados M3: <?php echo $ocupado3; ?> Slip ',   <?php echo $ocupado3; ?>],
            {
                name: 'Disponibles M3: <?php echo $disponible3; ?> Slip ',
                y: <?php echo $disponible3; ?>,
                sliced: true,
                selected: true
            }
        ]
    }]
});
});


</script>

<script type="text/javascript">
$(function () {
$('#pieM4').highcharts({
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false
    },
    title: {
        text: 'Estadisticas M4'
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
        name: 'M4',
        data: [
            ['Ocupados M4: <?php echo $ocupado4; ?> Slip ',   <?php echo $ocupado4; ?>],
            {
                name: 'Disponibles M4: <?php echo $disponible4; ?> Slip ',
                y: <?php echo $disponible4; ?>,
                sliced: true,
                selected: true
            }
        ]
    }]
});
});


</script>

<?php require 'inc/views/template_head_end.php'; ?>
<?php require 'inc/views/base_head.php'; ?>

<div class="content content-narrow">
<script src="graficas/js/highcharts.js"></script>
<script src="graficas/js/modules/exporting.js"></script>
    <!-- Forms Row -->
    <div class="row">

        <div class="col-lg-12">
        <?php if(isset($update_slip)){ ?>

                    <div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h3 class="font-w300 push-15">Slip Cambiado</h3>
                        <p>El <a class="alert-link" href="javascript:void(0)">Slip</a> fue cambiado!</p>
                    </div>

        <?php } ?>
            <!-- Bootstrap Forms Validation -->
            <div class="block">
                <div class="block-header">
                    <ul class="block-options">
                        <li>
                        </li>
                    </ul>
                    <h3 class="block-title">Mapeado de la Marina</h3>
                    <div id="pie" style="min-width: 310px; height: 300px; max-width: 400px; margin: 0 auto; float:left;"></div>
                    <div id="pieM1" style="min-width: 310px; height: 300px; max-width: 400px; margin: 0 auto; float:left;"></div>
                    <div id="pieM3" style="min-width: 310px; height: 300px; max-width: 400px; margin: 0 auto; float:left;"></div>
                    <div id="pieM4" style="min-width: 310px; height: 300px; max-width: 400px; margin: 0 auto; float:left;"></div>
                </div>
                <div class="block-content block-content-narrow" style="background-color:white;">
                
                  <div class="muelle1">
                    M1 <br>
                    54 Plazas
                    <?php while ($slips = $m1 -> fetch_array()) { ?>
                      <script type="text/javascript">
                        $(document).ready(function() {
                          $("#slipm1<?php echo $slips['id_inmueble']; ?>").click(function(event) {
                          $("#descripcionslipm1<?php echo $slips['id_inmueble']; ?>").load('cargas_paginas/ver_marina_detalle.php?id=<?php echo $slips['id_inmueble']; ?>');
                          });
                        });
                      </script>
                    <div class="slipM1" <?php if($slips['id_inmueble'] != ''){ echo 'style="background-color:#5EAB3B; color:white; text-decoration: none;"';} ?> >
                      <a <?php if($slips['id_inmueble'] != ''){ ?> id="slipm1<?php echo $slips['id_inmueble']; ?>" style="text-decoration: none;" data-toggle="modal" data-target="#modal-popin<?php echo $slips['id_inmueble']; ?>" <?php } ?> > <?php echo $slips['mi_nombre']; ?></a>
                    </div>
                    <div class="modal fade" id="modal-popin<?php echo $slips['id_inmueble']; ?>" tabindex="-1" role="dialog" aria-hidden="true" >
                        <div class="modal-dialog modal-dialog-popin">
                            <div id="descripcionslipm1<?php echo $slips['id_inmueble']; ?>" class="modal-content" style="width:800px;">

                            </div>
                        </div>
                    </div>
                    <?php } ?>
                  </div>

                  <div class="muelle2">
                    M2 <br>
                    49 Plazas | 42 Plazas
                    <?php while ($slips2 = $m2 -> fetch_array()) { ?>
                    <div class="slipM1">
                      <?php echo $slips2['mi_nombre']; ?>
                    </div>
                    <div class="descriptionSlip">
                    </div>
                    <?php } ?>
                  </div>

                  <div class="muelle3">
                    <div style="height:20px; width:100%;">M3 - 180 Pies</div>
                    <div class="leftmuelle3">
                    <?php while ($slips3 = $m3l -> fetch_array()) { ?>
                      <script type="text/javascript">
                        $(document).ready(function() {
                          $("#slipm1<?php echo $slips3['id_inmueble']; ?>").click(function(event) {
                          $("#descripcionslipm1<?php echo $slips3['id_inmueble']; ?>").load('cargas_paginas/ver_marina_detalle.php?id=<?php echo $slips3['id_inmueble']; ?>');
                          });
                        });
                      </script>
                    <div class="slipM3" <?php if($slips3['id_inmueble'] != ''){ echo 'style="background-color:#5EAB3B; color:white; text-decoration: none;"';} ?> >
                      <a <?php if($slips3['id_inmueble'] != ''){ ?> id="slipm1<?php echo $slips3['id_inmueble']; ?>" style="text-decoration: none;" data-toggle="modal" data-target="#modal-popin<?php echo $slips3['id_inmueble']; ?>" <?php } ?> > <?php echo $slips3['mi_nombre']; ?></a>
                    </div>
                    <div class="modal fade" id="modal-popin<?php echo $slips3['id_inmueble']; ?>" tabindex="-1" role="dialog" aria-hidden="true" >
                        <div class="modal-dialog modal-dialog-popin">
                            <div id="descripcionslipm1<?php echo $slips3['id_inmueble']; ?>" class="modal-content" style="width:800px;">

                            </div>
                        </div>
                    </div>
                    <?php } ?>
                    </div>
                    <div class="leftmuelle3">
                    <?php while ($slips3 = $m3r -> fetch_array()) { ?>
                      <script type="text/javascript">
                        $(document).ready(function() {
                          $("#slipm1<?php echo $slips3['id_inmueble']; ?>").click(function(event) {
                          $("#descripcionslipm1<?php echo $slips3['id_inmueble']; ?>").load('cargas_paginas/ver_marina_detalle.php?id=<?php echo $slips3['id_inmueble']; ?>');
                          });
                        });
                      </script>
                    <div class="slipM3" <?php if($slips3['id_inmueble'] != ''){ echo 'style="background-color:#5EAB3B; color:white; text-decoration: none;"';} ?> >
                      <a <?php if($slips3['id_inmueble'] != ''){ ?> id="slipm1<?php echo $slips3['id_inmueble']; ?>" style="text-decoration: none;" data-toggle="modal" data-target="#modal-popin<?php echo $slips3['id_inmueble']; ?>" <?php } ?> > <?php echo $slips3['mi_nombre']; ?></a>
                    </div>
                    <div class="modal fade" id="modal-popin<?php echo $slips3['id_inmueble']; ?>" tabindex="-1" role="dialog" aria-hidden="true" >
                        <div class="modal-dialog modal-dialog-popin">
                            <div id="descripcionslipm1<?php echo $slips3['id_inmueble']; ?>" class="modal-content" style="width:800px;">

                            </div>
                        </div>
                    </div>
                    <?php } ?>
                    </div>
                  </div>

                  <div class="muelle4">
                    M4 <br>
                    <?php while ($slips4 = $m4 -> fetch_array()) { ?>
                      <script type="text/javascript">
                        $(document).ready(function() {
                          $("#slipm1<?php echo $slips4['id_inmueble']; ?>").click(function(event) {
                          $("#descripcionslipm1<?php echo $slips4['id_inmueble']; ?>").load('cargas_paginas/ver_marina_detalle.php?id=<?php echo $slips4['id_inmueble']; ?>');
                          });
                        });
                      </script>

                    <div class="slipM4" <?php if($slips4['id_inmueble'] != ''){ echo 'style="background-color:#5EAB3B; color:white; text-decoration: none;"';} ?> >
                      <a <?php if($slips4['id_inmueble'] != ''){ ?> id="slipm1<?php echo $slips4['id_inmueble']; ?>" style="text-decoration: none;" data-toggle="modal" data-target="#modal-popin<?php echo $slips4['id_inmueble']; ?>" <?php } ?> > <?php echo $slips4['mi_nombre']; ?></a>
                    </div>

                    <div class="modal fade" id="modal-popin<?php echo $slips4['id_inmueble']; ?>" tabindex="-1" role="dialog" aria-hidden="true" >
                        <div class="modal-dialog modal-dialog-popin">
                            <div id="descripcionslipm1<?php echo $slips4['id_inmueble']; ?>" class="modal-content" style="width:800px;">

                            </div>
                        </div>
                    </div>
                    <?php } ?>
                  </div>


                </div>
            <!-- Bootstrap Forms Validation -->
            </div>
          </div>
<?php require 'inc/views/base_footer.php'; ?>
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
