<?php
    require("conexion/conexion.php");
    require("funciones/funciones.php");
    require("funciones/funciones_auditorias.php");

    if(!isset($_SESSION)) session_start();

    if(isset($_SESSION['session_gc'])){
        $header_bar = 'base_header.php';
        $menu = true;
        /* ################ AUDITORIA DE SEGUIMIENTO ############## */
        $lugar_mapa = 46;
        $dispositivo_acceso = obtener_dispositivo();
        insertar_log_seguimiento($conexion2, ObtenerIP(), $dispositivo_acceso, $lugar_mapa, $_SESSION['session_gc']['usua_id']);
        /* ######################################################## */
        if(isset($_POST['eliminar'])){
            $eliminar_movimiento_bancario = $conexion2 -> query("delete from movimiento_bancario where id_cuota = '".$_POST['eliminar']."'");
            $eliminar_cuota = $conexion2 -> query("delete from maestro_cuotas where id_cuota = '".$_POST['eliminar']."'");
            $aperturar_cuotas = $conexion2 -> query("UPDATE maestro_ventas SET mv_status = 4 WHERE id_venta = '".$_POST['id_contrato']."'");
        }

        $nombre_pagina = "Cuotas";
        if(isset($_POST['id_venta_contrato'])){
            $_SESSION['id_venta_contrato'] = $_POST['id_venta_contrato'];
        }elseif(isset($_GET['id_venta'])){
            $_SESSION['id_venta_contrato']  = $_GET['id_venta'];
        }

        if(isset($_POST['id_cuota'])) {
            $_SESSION['id_cuota']=$_POST['id_cuota'];
        }
        if(isset($_POST['id_proyecto'])) {
            $_SESSION['id_proyecto']=$_POST['id_proyecto'];
        }
        if(isset($_POST['id_cliente'])) {
            $_SESSION['id_cliente']=$_POST['id_cliente'];
        }
        if(isset($_POST['id_contrato'])) {
            $_SESSION['id_contrato']=$_POST['id_contrato'];
        }
        if(isset($_POST['id_ginmueble'])) {
            $_SESSION['id_ginmueble']=$_POST['id_ginmueble'];
        }
        if(isset($_POST['id_inmueble'])) {
            $_SESSION['id_inmueble']=$_POST['id_inmueble'];
        }
        if(isset($_POST['fdoc_inicio'])) {
            $_SESSION['fdoc_inicio']=$_POST['fdoc_inicio'];
        }
        if(isset($_POST['fdoc_fin'])) {
            $_SESSION['fdoc_fin']=$_POST['fdoc_fin'];
        }
        if(isset($_POST['fven_inicio'])) {
            $_SESSION['fven_inicio']=$_POST['fven_inicio'];
        }
        if(isset($_POST['fven_fin'])) {
            $_SESSION['fven_fin']=$_POST['fven_fin'];
        }
        if(isset($_POST['status'])) {
            $_SESSION['status']=$_POST['status'];
        }
        if (isset($_POST['submitFilters'])) {
            $_SESSION['submitFilters'] = $_POST['submitFilters'];
        }


        if(isset($_POST['monto'], $_POST['estado'], $_POST['id_cuota'], $_POST['monto_abonado'], $_POST['fecha_vencimiento'])){
            $sql_update_cuota = mysqli_query($conexion2, "UPDATE maestro_cuotas
                                                          SET mc_fecha_vencimiento = '".$_POST['fecha_vencimiento']."',
                                                              mc_monto = '".$_POST['monto']."',
                                                              mc_monto_abonado = '".$_POST['monto_abonado']."',
                                                              mc_status = '".$_POST['estado']."'
                                                           WHERE id_cuota = '".$_POST['id_cuota']."'");
        }

       //$comprobar_suma_cuotas = comprobar_suma_cuotas($conexion2, $_SESSION['id_venta_contrato']);

        require 'inc/config.php';
        require 'inc/views/template_head_start.php';

        $wh = "";

        if(isset($_POST['submitFilters']))
        {
            //si el id de cuota existe, negar todos los otros filtros
            if($_POST['id_cuota'] != ""){
                $wh .= "AND mc.id_cuota = " . mysqli_real_escape_string($conexion2, $_POST['id_cuota']);
            }else{
                if($_POST['id_proyecto'] != "") $wh .= "AND mc.id_proyecto = " .  mysqli_real_escape_string($conexion2, $_POST['id_proyecto']) ." ";
                if($_POST['id_ginmueble'] != "") $wh .= "AND mc.id_grupo = " . mysqli_real_escape_string($conexion2, $_POST['id_ginmueble']) . " ";
                if($_POST['id_inmueble'] != "") $wh .= "AND mc.id_inmueble = " . mysqli_real_escape_string($conexion2, $_POST['id_inmueble']) . " ";
                if($_POST['id_cliente'] != "") $wh .= "AND mv.id_cliente = " . mysqli_real_escape_string($conexion2, $_POST['id_cliente']) . " ";
                if($_POST['status'] != ""){
                  $s = $_POST['status'];
                  echo $s;
                  if($s == 0) $wh .= "AND mc.mc_monto = mc.mc_monto_abonado ";
                  elseif($s == 1) $wh .= "AND mc.mc_monto_abonado < mc.mc_monto AND mc.mc_monto_abonado > 0 ";
                  elseif($s == 2) $wh .= "AND mc.mc_monto_abonado = 0 ";
                  elseif($s == 3) $wh .= "";
                  elseif($s == 4) $wh .= " AND mc.mc_monto_abonado < mc.mc_monto AND mc.mc_monto_abonado >= 0";
                }
                if($_POST['fdoc_inicio'] != "" && $_POST['fdoc_fin'] != ""){
                    $wh .= " AND mc.mc_fecha_creacion_contrato >= STR_TO_DATE('".mysqli_real_escape_string($conexion2, $_POST['fdoc_inicio'])."','%m/%d/%Y')
                            AND mc.mc_fecha_creacion_contrato <= STR_TO_DATE('".mysqli_real_escape_string($conexion2, $_POST['fdoc_fin'])."','%m/%d/%Y')" . " ";

                }
                if($_POST['fven_inicio'] != "" && $_POST['fven_fin'] != ""){
                    $wh .= " AND mc.mc_fecha_vencimiento >= STR_TO_DATE('".mysqli_real_escape_string($conexion2, $_POST['fven_inicio'])."','%m/%d/%Y')
                            AND mc.mc_fecha_vencimiento <= STR_TO_DATE('".mysqli_real_escape_string($conexion2, $_POST['fven_fin'])."','%m/%d/%Y')" . " ";

                }

            }

        }

        $tb_sql = "SELECT mc.id_cuota,
                          mc.id_contrato_venta,
                          tc.tc_nombre_tipo_cuenta,
                          tc.id_tipo_cuota,
                          mc.mc_numero_cuota,
                          mc.mc_fecha_vencimiento,
                          mc.mc_monto,
                          mc.mc_monto_abonado,
                          mc.mc_fecha_creacion_contrato,
                          mc.mc_descripcion,
                          mc.mc_numero_cuota,
                          mcl.cl_nombre,
                          mcl.cl_apellido,
                          mi.mi_nombre,
                          mc_status,
                          mv.mv_precio_venta,
                          mc.id_proyecto,
                          mp.proy_nombre_proyecto,
                          gi.id_grupo_inmuebles,
                          gi.gi_nombre_grupo_inmueble,
                          mi.mi_codigo_imueble
                   FROM maestro_cuotas mc INNER JOIN tipo_cuota tc ON mc.id_tipo_cuota = tc.id_tipo_cuota
                   INNER JOIN maestro_ventas mv ON mc.id_contrato_venta = mv.id_venta
                   INNER JOIN maestro_clientes mcl ON mv.id_cliente = mcl.id_cliente
                   INNER JOIN maestro_inmuebles mi ON mc.id_inmueble = mi.id_inmueble
                   INNER JOIN maestro_proyectos mp ON mp.id_proyecto = mc.id_proyecto
                   INNER JOIN grupo_inmuebles gi ON gi.id_grupo_inmuebles = mc.id_grupo
                   WHERE 1 $wh";


?>
<!-- Page JS Plugins CSS -->
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/bootstrap-datepicker/bootstrap-datepicker3.min.css">
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/datatables/jquery.dataTables.min.css">
<?php require 'inc/views/template_head_end.php'; require 'inc/views/base_head.php'; ?>

<!-- Page Header -->
<div class="content bg-gray-lighter">
    <div class="row items-push">
        <?php /*if($comprobar_suma_cuotas == true){ ?>
            <!-- Success Alert -->
            <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h3 class="font-w300 push-15">Todas las cuotas estan pagadas</h3>
                <p><a class="alert-link" href="javascript:void(0)">el contrato de venta esta finalizado!</a></p>
            </div>
            <!-- END Success Alert -->
        <?php }*/ ?>

        <?php if(isset($sql_update_cuota)){ ?>
            <!-- Success Alert -->
            <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h3 class="font-w300 push-15">Datos Actualizados</h3>
                <p><a class="alert-link" href="javascript:void(0)">Los datos</a> fueron actualizados!</p>
            </div>
            <!-- END Success Alert -->
        <?php } ?>
        <div class="col-sm-7">
            <h1 class="page-heading">Ver Cuotas Filtro</h1>
        </div>
    </div>
</div>
<!-- END Page Header -->

<!-- Page Content -->
<div class="content">
    <!-- Dynamic Table Full -->
    <div class="block">
        <div class="block-header">
            <h3 class="block-title">Tabla de <?php echo $nombre_pagina; ?> por contrato de venta del sistema <small>todos las <?php echo $nombre_pagina; ?> por contrato de venta</small></h3>
            <div class="block-options">
              <form class="" action="reporteExcelCuotas.php" method="post" target="_blank">
                  <button class="btn btn-primary" name="excel">Excel</button>
              </form>
            </div>
        </div>
        <div class="block-content">
            <!-- DataTables init on table by adding .js-dataTable-full class, functionality initialized in js/pages/base_tables_datatables.js -->
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th class="text-center">ID</th>
                        <th>TIPO</th>
                        <th>NUMERO</th>
                        <th class="text-center">CLIENTE</th>
                        <th class="hidden-xs" >FECHA VENCIMIENTO</th>
                        <th class="hidden-xs" >DESCRIPCION</th>
                        <th class="hidden-xs" >ESTATUS DE LA CUOTA</th>
                        <th class="hidden-xs" >MONTO DOCUMENTO</th>
                        <th class="hidden-xs" >MONTO PAGADO</th>
                        <th class="text-center" >PAGAR</th>
                        <th class="text-center" >VER PAGOS</th>
                        <th class="text-center" >EDITAR</th>
                        <th class="text-center" >ELIMINAR</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $res = mysqli_query($conexion2, $tb_sql);
                        while($lista_todos_contratos_ventas = mysqli_fetch_array($res)){
                            $precio = $lista_todos_contratos_ventas['mv_precio_venta'];
                    ?>
                    <tr>
                        <td class="text-center"><?php echo $lista_todos_contratos_ventas['id_cuota']; ?></td>
                        <td class="font-w600"><?php echo $lista_todos_contratos_ventas['tc_nombre_tipo_cuenta']; ?></td>
                        <td class="text-center"><?php echo $lista_todos_contratos_ventas['mc_numero_cuota']; ?></td>
                        <td class="font-w600"><?php echo $lista_todos_contratos_ventas['cl_nombre'].' '.$lista_todos_contratos_ventas['cl_apellido']; ?></td>
                        <td class="hidden-xs"><?php echo date("d-m-Y", strtotime($lista_todos_contratos_ventas['mc_fecha_vencimiento'])); ?></td>
                        <td class="hidden-xs"><?php echo $lista_todos_contratos_ventas['mc_descripcion']; ?></td>
                        <td class="hidden-xs" <?php if($lista_todos_contratos_ventas['mc_monto'] == $lista_todos_contratos_ventas['mc_monto_abonado']){?> style="background-color:#00B812"
                                              <?php }elseif($lista_todos_contratos_ventas['mc_monto'] > $lista_todos_contratos_ventas['mc_monto_abonado'] &&
                                                            $lista_todos_contratos_ventas['mc_monto_abonado'] > 0 ){?> style="background-color:#FAD401"
                                              <?php }elseif($lista_todos_contratos_ventas['mc_monto_abonado'] == 0){?> style="background-color:#FF0000; color:white;" <?php } ?>>

                            <?php if($lista_todos_contratos_ventas['mc_monto'] == $lista_todos_contratos_ventas['mc_monto_abonado']){?> PAGADA
                            <?php }elseif($lista_todos_contratos_ventas['mc_monto'] > $lista_todos_contratos_ventas['mc_monto_abonado'] &&
                                          $lista_todos_contratos_ventas['mc_monto_abonado'] > 0 ){?> ABONADA
                            <?php }elseif($lista_todos_contratos_ventas['mc_monto_abonado'] == 0){?> PENDIENTE/ SIN ABONAR <?php } ?>
                        </tb>
                        <td class="text-center"><?php echo number_format($lista_todos_contratos_ventas['mc_monto'], 2, ',','.'); ?></td>
                        <td class="text-center"><?php echo number_format($lista_todos_contratos_ventas['mc_monto_abonado'], 2, ',','.'); ?></td>
                        <td class="text-center">
                            <div class="btn-group">
                              <form class="" action="gc_abono_pago_cuota_inmueble.php" method="post">
                                <button class="btn btn-default" type="submit"><i class="fa fa-dollar"></i></button>
                                <input type="hidden" name="id_cuota" value="<?php echo $lista_todos_contratos_ventas['id_cuota']; ?>">
                              </form>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="btn-group">
                                <form class="" action="gc_ver_cuotas_anonadas_hija.php" method="post">
                                  <button class="btn btn-default" type="submit"><i class="si si-eye"></i></button>
                                  <input type="hidden" name="id_cuota" value="<?php echo $lista_todos_contratos_ventas['id_cuota']; ?>">
                                </form>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="btn-group">
                              <?php if($_SESSION['session_gc']['roll'] == 1 || $_SESSION['session_gc']['roll'] == 3){ ?>
                                <button class="btn btn-default" data-toggle="modal" data-target="#modal-popin<?php echo $lista_todos_contratos_ventas['id_cuota']; ?>" type="button"><i class="fa fa-pencil"></i></button>
                              <?php } ?>
                            </div>
                        </td>
                        <td class="text-center">
                          <div class="btn-group">
                            <?php if($_SESSION['session_gc']['roll'] == 1 || $_SESSION['session_gc']['roll'] == 3){ ?>
                              <button class="btn btn-default" data-toggle="modal" data-target="#modal-popina<?php echo $lista_todos_contratos_ventas['id_cuota']; ?>" type="submit"><i class="fa fa-trash-o"></i></button>
                            <?php } ?>
                              <div class="modal fade" id="modal-popina<?php echo $lista_todos_contratos_ventas['id_cuota']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                  <div class="modal-dialog modal-dialog-popin">
                                      <div class="modal-content">
                                          <div class="block block-themed block-transparent remove-margin-b">
                                              <div class="block-header bg-primary-dark">
                                                  <ul class="block-options">
                                                      <li>
                                                          <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                                                      </li>
                                                  </ul>
                                                  <h3 class="block-title">Eliminar la cuota</h3>
                                              </div>
                                              <div class="block-content">
                                                  <div style="color:red;">Esta seguro que desea eliminar la cuota? <br>
                                                  Recuerde que si elimina esta cuota se eliminaran los abonos dependientes a la misma!</div>
                                                  Tambien recuerde que al eliminar una cuota el contrato se abrira de nuevo para asi asignarle
                                                  una nueva cuota.
                                                  <br>
                                                  <span style="color:red;">Los movimientos bancarios asociados a esta cuota tambien se borraran.</span>
                                              </div>
                                          </div>
                                          <div class="modal-footer">
                                            <form class="" action="" method="post">
                                              <button class="btn btn-sm btn-default" type="button" data-dismiss="modal">Cerrar</button>
                                              <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-check"></i> Ok</button>
                                              <input type="hidden" name="eliminar" value="<?php echo $lista_todos_contratos_ventas['id_cuota']; ?>">
                                              <input type="hidden" name="id_contrato" value="<?php echo $_SESSION['id_venta_contrato']; ?>">
                                            </form>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                        </td>
                    </tr>

                    <input class="form-control" type="hidden" id="register1-username" name="id_cuota" readonly="readonly" value="<?php echo $lista_todos_contratos_ventas['id_cuota']; ?>">

                            <div class="modal fade" id="modal-popin<?php echo $lista_todos_contratos_ventas['id_cuota']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-popin">
                                    <div class="modal-content">
                                        <form action="" method="post" enctype="multipart/form-data">
                                            <div class="block block-themed block-transparent remove-margin-b">
                                                <div class="block-header bg-primary-dark">
                                                    <ul class="block-options">
                                                        <li>
                                                            <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                                                        </li>
                                                    </ul>
                                                    <h3 class="block-title">Actualizar Datos</h3>
                                                </div>
                                                <div class="block-content">
                                                    <!-- Bootstrap Register -->
                                                    <div class="block block-themed">
                                                        <div class="block-content">
                                                            <div class="form-group">
                                                                <label class="col-xs-12" for="register1-username">ID</label>
                                                                <div class="col-xs-12">
                                                                    <input class="form-control" type="text" id="register1-username" name="id_cuota" readonly="readonly" value="<?php echo $lista_todos_contratos_ventas['id_cuota']; ?>"></input>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-xs-12" for="register1-username">Fecha de creacion</label>
                                                                <div class="col-xs-12">
                                                                    <input class="form-control" type="text" id="register1-username" readonly="readonly" value="<?php echo $lista_todos_contratos_ventas['mc_fecha_creacion_contrato']; ?>"></input>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-xs-12" for="register1-username">Fecha de vencimiento</label>
                                                                <div class="col-xs-12">
                                                                     <input class="js-datepicker form-control" type="text" id="example-datepicker1" name="fecha_vencimiento" data-date-format="yy-mm-dd" value="<?php echo $lista_todos_contratos_ventas['mc_fecha_vencimiento']; ?>">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-xs-12" for="register1-username">Monto </label>
                                                                <div class="col-xs-12">
                                                                    <input class="form-control" type="number" name="monto" placeholder="Precio" required="required" value="<?php echo $lista_todos_contratos_ventas['mc_monto']; ?>"></input>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-xs-12" for="register1-username">Monto abonado</label>
                                                                <div class="col-xs-12">
                                                                     <input class="form-control" readonly="readonly" type="number" name="monto_abonado" placeholder="Precio" required="required" value="<?php echo $lista_todos_contratos_ventas['mc_monto_abonado']; ?>"></input>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-xs-12" for="register1-username">Nombre del cliente</label>
                                                                <div class="col-xs-12">
                                                                     <input class="form-control" type="text" placeholder="Modelo" readonly="readonly" value="<?php echo $lista_todos_contratos_ventas['cl_nombre'].' '.$lista_todos_contratos_ventas['cl_apellido']; ?>"></input>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-xs-12" for="register1-username">Inmueble</label>
                                                                <div class="col-xs-12">
                                                                    <input class="form-control" type="text" placeholder="Area" readonly="readonly" value="<?php echo $lista_todos_contratos_ventas['mi_nombre']; ?>"></input>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-xs-12" for="register1-username"></label>
                                                                <div class="col-xs-12">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-md-4 control-label" >ESTADO</label>
                                                                <div class="col-md-7">
                                                                    <label class="rad-inline" for="example-inline-checkbox1">
                                                                        <input type="radio" id="example-inline-checkbox1" name="estado" value="1" <?php if($lista_todos_contratos_ventas['mc_status'] == 1){ echo 'checked';}  ?> ></input> Activa
                                                                    </label>
                                                                    <label class="rad-inline" for="example-inline-checkbox1">
                                                                        <input type="radio" id="example-inline-checkbox2" name="estado" value="0" <?php if($lista_todos_contratos_ventas['mc_status'] == 0){ echo 'checked';}  ?> ></input> Inactiva
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button class="btn btn-sm btn-default" type="button" data-dismiss="modal">Cancelar</button>
                                                                <button class="btn btn-sm btn-primary" type="submit" >Guardar cambios</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <tr style="display: none">
                          <td class="text-center font-w600" colspan="4">Numero de cuotas: <?php echo numero_cuotas($conexion2, $_SESSION['id_venta_contrato']); ?></td>
                          <td class="text-center font-w600" colspan="3">Monto por pagar: <?php echo number_format($precio - suma_cuota($conexion2, $_SESSION['id_venta_contrato']), 2, ',','.'); ?></td>
                          <td class="text-center font-w600" colspan="3">Monto Pagado: <?php  echo number_format(suma_cuota($conexion2, $_SESSION['id_venta_contrato']), 2, ',','.');?> </td>
                          <td class="text-center font-w600" colspan="3">Costo Inmueble: <?php echo number_format($precio, 2, ',','.'); ?></td>
                        </tr>
                </tbody>
            </table>
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
