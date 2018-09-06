<?php if(!isset($_SESSION)){session_start();}?>
<?php require("conexion/conexion.php"); ?>
<?php require("funciones/funciones.php"); ?>
<?php if(isset($_SESSION['session_gc'])){ ?>
<?php $header_bar = 'base_header.php'; ?>
<?php $menu = true; ?>
<?php /* ################ AUDITORIA DE SEGUIMIENTO ############## */ ?>
<?php require("funciones/funciones_auditorias.php"); ?>
<?php $lugar_mapa = 1; ?>
<?php $dispositivo_acceso = obtener_dispositivo(); ?>
<?php insertar_log_seguimiento($conexion2, ObtenerIP(), $dispositivo_acceso, $lugar_mapa, $_SESSION['session_gc']['usua_id']); ?>
<?php /* ######################################################## */ ?>
<?php require 'inc/config.php'; ?>
<?php require 'inc/views/template_head_start.php'; ?>

<!-- Page JS Plugins CSS -->
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/slick/slick.min.css">
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/slick/slick-theme.min.css">

<?php require 'inc/views/template_head_end.php'; ?>
<?php require 'inc/views/base_head.php'; ?>

<!-- Page Header -->
<div class="content bg-image overflow-hidden" style="background-image: url('<?php echo $one->assets_folder; ?>/img/photos/photo3@2x.jpg');">
    <div class="push-50-t push-15">
        <h1 class="h2 text-white animated zoomIn">Grupo Calpe</h1>
        
    </div>
</div>
<!-- END Page Header -->

<!-- Stats -->
<div class="content bg-white border-b">
    <div class="row items-push text-uppercase">
        <div class="col-xs-6 col-sm-3">
            <div class="font-w700 text-gray-darker animated fadeIn">Entrada de fondos</div>
            <div class="text-muted animated fadeIn"><small><i class="si si-calendar"></i> Hoy</small></div>
            <a class="h2 font-w300 text-primary animated flipInX" href="base_comp_charts.php"> $ 300,000</a>
        </div>
        <div class="col-xs-6 col-sm-3">
            <div class="font-w700 text-gray-darker animated fadeIn">Entrada de fondos</div>
            <div class="text-muted animated fadeIn"><small><i class="si si-calendar"></i> Este mes</small></div>
            <a class="h2 font-w300 text-primary animated flipInX" href="base_comp_charts.php">$ 8,790,900</a>
        </div>
        <div class="col-xs-6 col-sm-3">
            <div class="font-w700 text-gray-darker animated fadeIn">Salida de fondos</div>
            <div class="text-muted animated fadeIn"><small><i class="si si-calendar"></i> Este mes</small></div>
            <a class="h2 font-w300 text-primary animated flipInX" style="color: red;" href="base_comp_charts.php">$ -3,500,300</a>
        </div>
        <div class="col-xs-6 col-sm-3">
            <div class="font-w700 text-gray-darker animated fadeIn">Ganancia total</div>
            <div class="text-muted animated fadeIn"><small><i class="si si-calendar"></i> Este mes</small></div>
            <a class="h2 font-w300 text-primary animated flipInX" style="color: green;" href="base_comp_charts.php">$ 5,101,100</a>
        </div>
    </div>
</div>
<!-- END Stats -->

<!-- Page Content -->
<div class="content">
    <div class="row">
        <div class="col-lg-8">
            <!-- Main Dashboard Chart -->
            <div class="block">
                <div class="block-header">
                    <ul class="block-options">
                        <li>
                            <button type="button" data-toggle="block-option" data-action="refresh_toggle" data-action-mode="demo"><i class="si si-refresh"></i></button>
                        </li>
                    </ul>
                    <h3 class="block-title">Progreso Semanal</h3>
                </div>
                <div class="block-content block-content-full bg-gray-lighter text-center">
                    <!-- Chart.js Charts (initialized in js/pages/base_pages_dashboard.js), for more examples you can check out http://www.chartjs.org/docs/ -->
                    <div style="height: 374px;"><canvas class="js-dash-chartjs-lines"></canvas></div>
                </div>
                <div class="block-content text-center">
                    <div class="row items-push text-center">
                        <div class="col-xs-6 col-lg-3">
                            <div class="push-10"><i class="si si-graph fa-2x"></i></div>
                            <div class="h5 font-w300 text-muted">+ 205 Construcciones</div>
                        </div>
                        <div class="col-xs-6 col-lg-3">
                            <div class="push-10"><i class="si si-users fa-2x"></i></div>
                            <div class="h5 font-w300 text-muted">+ 25 Clientes</div>
                        </div>
                        <div class="col-xs-6 col-lg-3 visible-lg">
                            <div class="push-10"><i class="si si-star fa-2x"></i></div>
                            <div class="h5 font-w300 text-muted">+ 10 Trabajos terminados</div>
                        </div>
                        <div class="col-xs-6 col-lg-3 visible-lg">
                            <div class="push-10"><i class="si si-share fa-2x"></i></div>
                            <div class="h5 font-w300 text-muted">+ 5 Estaciones de trabajo</div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END Main Dashboard Chart -->
        </div>
        <div class="col-lg-4">
            <!-- Latest Sales Widget -->
            <div class="block">
                <div class="block-header">
                    <ul class="block-options">
                        <li>
                            <button type="button" data-toggle="block-option" data-action="refresh_toggle" data-action-mode="demo"><i class="si si-refresh"></i></button>
                        </li>
                    </ul>
                    <h3 class="block-title">Estado de cuentas</h3>
                </div>
                <div class="block-content bg-gray-lighter">
                    <div class="row items-push">
                        <div class="col-xs-4">
                            <div class="text-muted"><small><i class="si si-calendar"></i> 24 horas</small></div>
                            <div class="font-w600">18 Depositos</div>
                        </div>
                        <div class="col-xs-4">
                            <div class="text-muted"><small><i class="si si-calendar"></i> 7 Dias</small></div>
                            <div class="font-w600">31 Retiros</div>
                        </div>
                        <div class="col-xs-4 h1 font-w300 text-right">$769</div>
                    </div>
                </div>
                <div class="block-content">
                    <div class="pull-t pull-r-l">
                        <!-- Slick slider (.js-slider class is initialized in App() -> uiHelperSlick()) -->
                        <!-- For more info and examples you can check out http://kenwheeler.github.io/slick/ -->
                        <div class="js-slider remove-margin-b" data-slider-autoplay="true" data-slider-autoplay-speed="2500">
                            <div>
                                <table class="table remove-margin-b font-s13">
                                    <tbody>
                                        <tr>
                                            <td class="font-w600">
                                                <a href="javascript:void(0)">Banco General</a>
                                            </td>
                                            <td class="hidden-xs text-muted text-right" style="width: 70px;">23:01</td>
                                            <td class="font-w600 text-success text-right" style="width: 70px;">+ $21</td>
                                        </tr>
                                        <tr>
                                            <td class="font-w600"><a href="javascript:void(0)">Banco General</a></td>
                                            <td class="hidden-xs text-muted text-right">22:15</td>
                                            <td class="font-w600 text-success text-right">+ $5200</td>
                                        </tr>
                                        <tr>
                                            <td class="font-w600"><a href="javascript:void(0)">Banistmo</a></td>
                                            <td class="hidden-xs text-muted text-right">22:01</td>
                                            <td class="font-w600 text-success text-right">+ $1600</td>
                                        </tr>
                                        <tr>
                                            <td class="font-w600"><a href="javascript:void(0)">Pichincha</a></td>
                                            <td class="hidden-xs text-muted text-right">21:45</td>
                                            <td class="font-w600 text-success text-right">+ $2300</td>
                                        </tr>
                                        <tr>
                                            <td class="font-w600"><a href="javascript:void(0)">Banco de Panama</a></td>
                                            <td class="hidden-xs text-muted text-right">21:15</td>
                                            <td class="font-w600 text-success text-right">+ $4800</td>
                                        </tr>
                                        <tr>
                                            <td class="font-w600"><a href="javascript:void(0)">Banesco</a></td>
                                            <td class="hidden-xs text-muted text-right">20:11</td>
                                            <td class="font-w600 text-success text-right">+ $2300</td>
                                        </tr>
                                        <tr>
                                            <td class="font-w600"><a href="javascript:void(0)">Global Bank</a></td>
                                            <td class="hidden-xs text-muted text-right">20:01</td>
                                            <td class="font-w600 text-success text-right">+ $5000</td>
                                        </tr>
                                        <tr>
                                            <td class="font-w600"><a href="javascript:void(0)">Banesco</a></td>
                                            <td class="hidden-xs text-muted text-right">19:35</td>
                                            <td class="font-w600 text-success text-right">+ $1600</td>
                                        </tr>
                                        <tr>
                                            <td class="font-w600"><a href="javascript:void(0)">Banco General</a></td>
                                            <td class="hidden-xs text-muted text-right">19:17</td>
                                            <td class="font-w600 text-success text-right">+ $6000</td>
                                        </tr>
                                        <tr>
                                            <td class="font-w600"><a href="javascript:void(0)">Banco General</a></td>
                                            <td class="hidden-xs text-muted text-right">17:49</td>
                                            <td class="font-w600 text-success text-right">+ $5900</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div>
                                <table class="table remove-margin-b font-s13">
                                    <tbody>
                                        <tr>
                                            <td class="font-w600">
                                                <a href="javascript:void(0)">Banco General</a>
                                            </td>
                                            <td class="hidden-xs text-muted text-right" style="width: 70px;">23:01</td>
                                            <td class="font-w600 text-success text-right" style="width: 70px;">+ $3000</td>
                                        </tr>
                                        <tr>
                                            <td class="font-w600"><a href="javascript:void(0)">Global Bank</a></td>
                                            <td class="hidden-xs text-muted text-right">20:01</td>
                                            <td class="font-w600 text-success text-right">+ $5000</td>
                                        </tr>
                                        <tr>
                                            <td class="font-w600"><a href="javascript:void(0)">Banesco</a></td>
                                            <td class="hidden-xs text-muted text-right">19:35</td>
                                            <td class="font-w600 text-success text-right">+ $1600</td>
                                        </tr>
                                        <tr>
                                            <td class="font-w600"><a href="javascript:void(0)">Banco General</a></td>
                                            <td class="hidden-xs text-muted text-right">19:17</td>
                                            <td class="font-w600 text-success text-right">+ $6000</td>
                                        </tr>
                                        <tr>
                                            <td class="font-w600"><a href="javascript:void(0)">Banco General</a></td>
                                            <td class="hidden-xs text-muted text-right">17:49</td>
                                            <td class="font-w600 text-success text-right">+ $5900</td>
                                        </tr>
                                        <tr>
                                            <td class="font-w600"><a href="javascript:void(0)">Banco General</a></td>
                                            <td class="hidden-xs text-muted text-right">22:15</td>
                                            <td class="font-w600 text-success text-right">+ $5200</td>
                                        </tr>
                                        <tr>
                                            <td class="font-w600"><a href="javascript:void(0)">Banistmo</a></td>
                                            <td class="hidden-xs text-muted text-right">22:01</td>
                                            <td class="font-w600 text-success text-right">+ $1600</td>
                                        </tr>
                                        <tr>
                                            <td class="font-w600"><a href="javascript:void(0)">Pichincha</a></td>
                                            <td class="hidden-xs text-muted text-right">21:45</td>
                                            <td class="font-w600 text-success text-right">+ $2300</td>
                                        </tr>
                                        <tr>
                                            <td class="font-w600"><a href="javascript:void(0)">Banco de Panama</a></td>
                                            <td class="hidden-xs text-muted text-right">21:15</td>
                                            <td class="font-w600 text-success text-right">+ $4800</td>
                                        </tr>
                                        <tr>
                                            <td class="font-w600"><a href="javascript:void(0)">Banesco</a></td>
                                            <td class="hidden-xs text-muted text-right">20:11</td>
                                            <td class="font-w600 text-success text-right">+ $2300</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- END Slick slider -->
                    </div>
                </div>
            </div>
            <!-- END Latest Sales Widget -->
        </div>
    </div>
<!-- END Page Header -->

<!-- Page Content -->
<div class="content content-narrow">
    <!-- Chart.js Charts (initialized in js/pages/base_comp_charts.js), for more examples you can check out http://www.chartjs.org/docs/ -->
    
    <div class="row">
        <div class="col-lg-6">
            <!-- Lines Chart -->
            <div class="block">
                <div class="block-header">
                    <ul class="block-options">
                        <li>
                            <button type="button" data-toggle="block-option" data-action="refresh_toggle" data-action-mode="demo"><i class="si si-refresh"></i></button>
                        </li>
                    </ul>
                    <h3 class="block-title">Comparacion semanal</h3>
                </div>
                <div class="block-content block-content-full text-center">
                    <!-- Lines Chart Container -->
                    <div style="height: 330px;"><canvas class="js-chartjs-lines"></canvas></div>
                </div>
            </div>
            <!-- END Lines Chart -->
        </div>
        <div class="col-lg-6">
            <!-- Bars Chart -->
            <div class="block">
                <div class="block-header">
                    <ul class="block-options">
                        <li>
                            <button type="button" data-toggle="block-option" data-action="refresh_toggle" data-action-mode="demo"><i class="si si-refresh"></i></button>
                        </li>
                    </ul>
                    <h3 class="block-title">Comparacion semanal</h3>
                </div>
                <div class="block-content block-content-full text-center">
                    <!-- Bars Chart Container -->
                    <div style="height: 330px;"><canvas class="js-chartjs-bars"></canvas></div>
                </div>
            </div>
            <!-- END Bars Chart -->
        </div>
        <div class="col-lg-6">
            <!-- Radar Chart -->
            <div class="block">
                <div class="block-header">
                    <ul class="block-options">
                        <li>
                            <button type="button" data-toggle="block-option" data-action="refresh_toggle" data-action-mode="demo"><i class="si si-refresh"></i></button>
                        </li>
                    </ul>
                    <h3 class="block-title">Desempeño</h3>
                </div>
                <div class="block-content block-content-full text-center">
                    <!-- Radar Chart Container -->
                    <div style="height: 330px;"><canvas class="js-chartjs-radar"></canvas></div>
                </div>
            </div>
            <!-- END Radar Chart -->
        </div>
        <div class="col-lg-6">
            <!-- Polar Area Chart -->
            <div class="block">
                <div class="block-header">
                    <ul class="block-options">
                        <li>
                            <button type="button" data-toggle="block-option" data-action="refresh_toggle" data-action-mode="demo"><i class="si si-refresh"></i></button>
                        </li>
                    </ul>
                    <h3 class="block-title">Resaltos en areas</h3>
                </div>
                <div class="block-content block-content-full text-center">
                    <!-- Polar Area Chart Container -->
                    <div style="height: 330px;"><canvas class="js-chartjs-polar"></canvas></div>
                </div>
            </div>
            <!-- END Polar Area Chart -->
        </div>
        <div class="col-lg-6">
            <!-- Pie Chart -->
            <div class="block">
                <div class="block-header">
                    <ul class="block-options">
                        <li>
                            <button type="button" data-toggle="block-option" data-action="refresh_toggle" data-action-mode="demo"><i class="si si-refresh"></i></button>
                        </li>
                    </ul>
                    <h3 class="block-title">Contratos concretados</h3>
                </div>
                <div class="block-content block-content-full text-center">
                    <!-- Pie Chart Container -->
                    <div style="height: 330px;"><canvas class="js-chartjs-pie"></canvas></div>
                </div>
            </div>
            <!-- END Pie Chart -->
        </div>
        <div class="col-lg-6">
            <!-- Donut Chart -->
            <div class="block">
                <div class="block-header">
                    <ul class="block-options">
                        <li>
                            <button type="button" data-toggle="block-option" data-action="refresh_toggle" data-action-mode="demo"><i class="si si-refresh"></i></button>
                        </li>
                    </ul>
                    <h3 class="block-title">Contratos concretados</h3>
                </div>
                <div class="block-content block-content-full text-center">
                    <!-- Donut Chart Container -->
                    <div style="height: 330px;"><canvas class="js-chartjs-donut"></canvas></div>
                </div>
            </div>
            <!-- END Donut Chart -->
        </div>
    </div>
    <!-- END Chart.js Charts -->

    <!-- Jquery Sparkline (initialized in js/pages/base_comp_charts.js), for more examples you can check out http://omnipotent.net/jquery.sparkline/#s-about -->
    
    <!-- END Sparkline Charts -->

    <!-- Easy Pie Chart (.js-pie-chart class is initialized in App() -> uiHelperEasyPieChart()) -->
    <!-- For more info and examples you can check out http://rendro.github.io/easy-pie-chart/ -->
    <!-- Randomize Values Buttons functionality initialized in js/pages/base_comp_charts.js -->
    <div class="row">
        <div class="col-lg-6">
            <!-- Simple -->
            <div class="block">
                <div class="block-header">
                    <ul class="block-options">
                        <li>
                            <button class="js-pie-randomize" type="button" data-toggle="tooltip" title="Randomize"><i class="fa fa-random"></i></button>
                        </li>
                        <li>
                            <button type="button" data-toggle="block-option" data-action="refresh_toggle" data-action-mode="demo"><i class="si si-refresh"></i></button>
                        </li>
                    </ul>
                    <h3 class="block-title">Progrsos</h3>
                </div>
                <div class="block-content">
                    <div class="row items-push-2x text-center">
                        <div class="col-xs-6 col-sm-4">
                            <!-- Pie Chart Container -->
                            <div class="js-pie-chart pie-chart" data-percent="80" data-line-width="3" data-size="100" data-bar-color="#abe37d" data-track-color="#eeeeee" data-scale-color="#dddddd">
                                <span>8 <br><small class="text-muted">/100</small></span>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-4">
                            <!-- Pie Chart Container -->
                            <div class="js-pie-chart pie-chart" data-percent="45" data-line-width="3" data-size="100" data-bar-color="#fadb7d" data-track-color="#eeeeee" data-scale-color="#dddddd">
                                <span>45%</span>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-4">
                            <!-- Pie Chart Container -->
                            <div class="js-pie-chart pie-chart" data-percent="25" data-line-width="3" data-size="100" data-bar-color="#faad7d" data-track-color="#eeeeee" data-scale-color="#dddddd">
                                <span>25.00 <br><small class="text-muted">/100mb</small></span>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-4">
                            <!-- Pie Chart Container -->
                            <div class="js-pie-chart pie-chart" data-percent="80" data-line-width="3" data-size="100" data-bar-color="#abe37d" data-track-color="#eeeeee">
                                <span>8 <br><small class="text-muted">/100</small></span>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-4">
                            <!-- Pie Chart Container -->
                            <div class="js-pie-chart pie-chart" data-percent="45" data-line-width="3" data-size="100" data-bar-color="#fadb7d" data-track-color="#eeeeee">
                                <span>45%</span>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-4">
                            <!-- Pie Chart Container -->
                            <div class="js-pie-chart pie-chart" data-percent="25" data-line-width="3" data-size="100" data-bar-color="#faad7d" data-track-color="#eeeeee">
                                <span>25.00 <br><small class="text-muted">/100mb</small></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END Simple -->
        </div>
        <div class="col-lg-6">
            <!-- Avatar -->
            <div class="block">
                <div class="block-header">
                    <ul class="block-options">
                        <li>
                            <button class="js-pie-randomize" type="button" data-toggle="tooltip" title="Randomize"><i class="fa fa-random"></i></button>
                        </li>
                        <li>
                            <button type="button" data-toggle="block-option" data-action="refresh_toggle" data-action-mode="demo"><i class="si si-refresh"></i></button>
                        </li>
                    </ul>
                    <h3 class="block-title">Pago de comisiones</h3>
                </div>
                <div class="block-content">
                    <div class="row items-push-2x text-center">
                        <div class="col-xs-6 col-sm-4">
                            <!-- Pie Chart Container -->
                            <div class="js-pie-chart pie-chart" data-percent="80" data-line-width="3" data-size="100" data-bar-color="#abe37d" data-track-color="#eeeeee" data-scale-color="#dddddd">
                                <span>
                                    <?php $one->get_avatar(); ?>
                                </span>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-4">
                            <!-- Pie Chart Container -->
                            <div class="js-pie-chart pie-chart" data-percent="45" data-line-width="3" data-size="100" data-bar-color="#fadb7d" data-track-color="#eeeeee" data-scale-color="#dddddd">
                                <span>
                                    <?php $one->get_avatar(); ?>
                                </span>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-4">
                            <!-- Pie Chart Container -->
                            <div class="js-pie-chart pie-chart" data-percent="25" data-line-width="3" data-size="100" data-bar-color="#faad7d" data-track-color="#eeeeee" data-scale-color="#dddddd">
                                <span>
                                    <?php $one->get_avatar(); ?>
                                </span>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-4">
                            <!-- Pie Chart Container -->
                            <div class="js-pie-chart pie-chart" data-percent="80" data-line-width="3" data-size="100" data-bar-color="#abe37d" data-track-color="#eeeeee">
                                <span>
                                    <?php $one->get_avatar(); ?>
                                </span>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-4">
                            <!-- Pie Chart Container -->
                            <div class="js-pie-chart pie-chart" data-percent="45" data-line-width="3" data-size="100" data-bar-color="#fadb7d" data-track-color="#eeeeee">
                                <span>
                                    <?php $one->get_avatar(); ?>
                                </span>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-4">
                            <!-- Pie Chart Container -->
                            <div class="js-pie-chart pie-chart" data-percent="25" data-line-width="3" data-size="100" data-bar-color="#faad7d" data-track-color="#eeeeee">
                                <span>
                                    <?php $one->get_avatar(); ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END Avatar -->
        </div>
    </div>
    <!-- END Easy Pie Chart -->

    <!-- Flot Charts (initialized in js/pages/base_comp_charts.js), for more examples you can check out http://www.flotcharts.org/flot/examples -->
    
    <div class="row">
        <div class="col-lg-6">
            <!-- Lines Chart -->
            <div class="block">
                <div class="block-header">
                    <ul class="block-options">
                        <li>
                            <button type="button" data-toggle="block-option" data-action="refresh_toggle" data-action-mode="demo"><i class="si si-refresh"></i></button>
                        </li>
                    </ul>
                    <h3 class="block-title">Comparacion anual</h3>
                </div>
                <div class="block-content block-content-full">
                    <!-- Lines Chart Container -->
                    <div class="js-flot-lines" style="height: 330px;"></div>
                </div>
            </div>
            <!-- END Lines Chart -->
        </div>
        <div class="col-lg-6">
            <!-- Stacked Chart -->
            <div class="block">
                <div class="block-header">
                    <ul class="block-options">
                        <li>
                            <button type="button" data-toggle="block-option" data-action="refresh_toggle" data-action-mode="demo"><i class="si si-refresh"></i></button>
                        </li>
                    </ul>
                    <h3 class="block-title">Intereses anuales</h3>
                </div>
                <div class="block-content block-content-full">
                    <!-- Stacked Chart Container -->
                    <div class="js-flot-stacked" style="height: 330px;"></div>
                </div>
            </div>
            <!-- END Stacked Chart -->
        </div>
        <div class="col-lg-12">
            <!-- Live Chart -->
            <div class="block">
                <div class="block-header">
                    <ul class="block-options">
                        <li>
                            <span class="js-flot-live-info text-info font-w700"></span>
                        </li>
                        <li>
                            <span><i class="fa fa-refresh fa-spin text-muted"></i></span>
                        </li>
                    </ul>
                    <h3 class="block-title">Usuarios en el sistema</h3>
                </div>
                <div class="block-content block-content-full">
                    <!-- Live Chart Container -->
                    <div class="js-flot-live" style="height: 360px;"></div>
                </div>
            </div>
            <!-- END Live Chart -->
        </div>
        <div class="col-lg-6">
            <!-- Bars Chart -->
            <div class="block">
                <div class="block-header">
                    <ul class="block-options">
                        <li>
                            <button type="button" data-toggle="block-option" data-action="refresh_toggle" data-action-mode="demo"><i class="si si-refresh"></i></button>
                        </li>
                    </ul>
                    <h3 class="block-title">Grafica anual</h3>
                </div>
                <div class="block-content block-content-full">
                    <!-- Bars Chart Container -->
                    <div class="js-flot-bars" style="height: 330px;"></div>
                </div>
            </div>
            <!-- END Bars Chart -->
        </div>
        <div class="col-lg-6">
            <!-- Pie Chart -->
            <div class="block">
                <div class="block-header">
                    <ul class="block-options">
                        <li>
                            <button type="button" data-toggle="block-option" data-action="refresh_toggle" data-action-mode="demo"><i class="si si-refresh"></i></button>
                        </li>
                    </ul>
                    <h3 class="block-title">Grafica total</h3>
                </div>
                <div class="block-content block-content-full">
                    <!-- Pie Chart Container -->
                    <div class="js-flot-pie" style="height: 330px;"></div>
                </div>
            </div>
            <!-- END Pie Chart -->
        </div>
    </div>
    <!-- END Flot Charts -->
</div>
</div>
<!-- END Page Content -->

<?php require 'inc/views/base_footer.php'; ?>
<?php require 'inc/views/template_footer_start.php'; ?>

<!-- Page Plugins -->
<script src="<?php echo $one->assets_folder; ?>/js/plugins/slick/slick.min.js"></script>
<script src="<?php echo $one->assets_folder; ?>/js/plugins/chartjs/Chart.min.js"></script>
<script src="<?php echo $one->assets_folder; ?>/js/plugins/sparkline/jquery.sparkline.min.js"></script>
<script src="<?php echo $one->assets_folder; ?>/js/plugins/easy-pie-chart/jquery.easypiechart.min.js"></script>
<script src="<?php echo $one->assets_folder; ?>/js/plugins/flot/jquery.flot.min.js"></script>
<script src="<?php echo $one->assets_folder; ?>/js/plugins/flot/jquery.flot.pie.min.js"></script>
<script src="<?php echo $one->assets_folder; ?>/js/plugins/flot/jquery.flot.stack.min.js"></script>
<script src="<?php echo $one->assets_folder; ?>/js/plugins/flot/jquery.flot.resize.min.js"></script>

<!-- Page JS Code -->
<script src="<?php echo $one->assets_folder; ?>/js/pages/base_pages_dashboard.js"></script>
<script>
    jQuery(function(){
        // Init page helpers (Slick Slider plugin)
        App.initHelpers('slick');
    });
</script>
<script src="<?php echo $one->assets_folder; ?>/js/pages/base_comp_charts.js"></script>
<script>
    jQuery(function(){
        // Init page helpers (Easy Pie Chart plugin)
        App.initHelpers('easy-pie-chart');
    });
</script>

<?php require 'inc/views/template_footer_end.php'; ?>

<?php }else{ ?> 

        <script type="text/javascript">
            window.location="index.php";
        </script>

<?php } ?>
