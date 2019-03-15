<?php
    require("conexion/conexion.php");
    require("funciones/funciones.php");

if(!isset($_SESSION)) session_start();
if(isset($_SESSION['session_gc'])){
    $header_bar = 'base_header.php';
    $menu = true;
    /* ################ AUDITORIA DE SEGUIMIENTO ############## */
    require("funciones/funciones_auditorias.php");
    $lugar_mapa = 57;
    $dispositivo_acceso = obtener_dispositivo();
    insertar_log_seguimiento($conexion2, ObtenerIP(), $dispositivo_acceso, $lugar_mapa, $_SESSION['session_gc']['usua_id']);
    /* ######################################################## */
    require 'inc/config.php';
    require 'inc/views/template_head_start.php';

    $res = mysqli_query($conexion2, "SELECT * FROM maestro_proyectos WHERE id_proyecto = 13");
    $proyectos = mysqli_fetch_all($res, MYSQLI_ASSOC);

    $res = mysqli_query($conexion2, "SELECT id_cliente, CONCAT_WS(' ', cl_nombre, cl_apellido) AS nombre FROM maestro_clientes");
    $clientes = mysqli_fetch_all($res, MYSQLI_ASSOC);

    $res = mysqli_query($conexion2, "SELECT * FROM maestro_ventas");
    $ventas = mysqli_fetch_all($res, MYSQLI_ASSOC);

    $res = mysqli_query($conexion2, "SELECT * FROM grupo_inmuebles WHERE gi_id_proyecto = 13");
    $gin = mysqli_fetch_all($res, MYSQLI_ASSOC);

    $res = mysqli_query($conexion2, "SELECT * FROM maestro_inmuebles");
    $in = mysqli_fetch_all($res, MYSQLI_ASSOC);


?>
<!-- Page JS Plugins CSS -->
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/bootstrap-datepicker/bootstrap-datepicker3.min.css">
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/select2/select2.min.css">
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/select2/select2-bootstrap.min.css">
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/sweetalert/sweetalert.min.css">
<?php require 'inc/views/template_head_end.php'; ?>
<script>
    function buscarInmuebles(el)
    {
        $.ajax({
            type: 'POST',
            url: 'funciones/op_inmuebles.php',
            data: {id_grupo_inmueble:  $(el).val()},
            success: function(data){
                data += "<option selected value=''></option>" + data;
                $("select[name='id_inmueble']").empty().append(data);
            },
            error: function(xhr, type, exception) {
                // if ajax fails display error alert
            }
        });

    }

    function buscarGrupoInmuebles(el)
    {
        $.ajax({
            type: 'POST',
            url: 'funciones/op_grupo_inmuebles.php',
            data: {id_proyecto:  $(el).val()},
            success: function(data){
                data += "<option selected value=''></option>" + data;
                $("select[name='id_ginmueble']").empty().append(data);
            },
            error: function(xhr, type, exception) {
                // if ajax fails display error alert
            }
        });

    }

    function buscarClientes(el)
    {
        $.ajax({
            type: 'POST',
            url: 'funciones/op_clientes_por_proyectos.php',
            data: {id_proyecto:  $(el).val()},
            success: function(data){
                //data += "<option selected value=''></option>" + data;
                $("select[name='id_cliente']").empty().append(data);
                buscarGrupoInmuebles(el);
            },
            error: function(xhr, type, exception) {
                // if ajax fails display error alert
            }
        });

    }

</script>

<?php require 'inc/views/base_head.php'; ?>

<div class="content content-narrow">
    <div class="row">
        <div class="col-lg-12">
            <div class="block">
                <div class="block-header">
                    <h3 class="block-title">seleccione un proyecto</h3>

                </div>
                <div class="block-content block-content-narrow">
                    <form class="js-validation-bootstrap form-horizontal" action="gc_ver_tabla_cuotas_filtro.php" method="post">
                        <div class="form-group">
                            <div class="col-md-12">

                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="id_cuota">ID de Cuota</label>
                                    <div class="col-md-7">
                                      <input class="form-control" type="number" autocomplete="off" name="id_cuota" placeholder="ID de Cuota" value="">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="id_proyecto">Proyectos</label>
                                    <div class="col-md-7">
                                      <select class="js-select2 form-control" data-placeholder="Seleccionar Proyecto" name="id_proyecto" onchange="buscarClientes(this)">
                                        <option></option>
                                        <?php
                                            foreach($proyectos as $p)
                                            {
                                                ?><option value="<?php echo $p['id_proyecto'] ?>"><?php echo $p['proy_nombre_proyecto']?></option><?php
                                            }
                                        ?>
                                      </select>
                                    </div>
                                </div>

                                 <div class="form-group">
                                    <label class="col-md-4 control-label" for="id_cliente">Cliente</label>
                                    <div class="col-md-7">
                                        <select class="js-select2 form-control" data-placeholder="Seleccionar un Cliente" name="id_cliente">
                                            <option></option>
                                            <?php
                                                foreach($clientes as $c)
                                                {
                                                    ?><option value="<?php echo $c['id_cliente'] ?>"><?php echo $c['nombre']?></option><?php
                                                }
                                            ?>
                                      </select>
                                    </div>
                                </div>

                                <div class="form-group" style="display: none">
                                    <label class="col-md-4 control-label" for="id_contrato">Contrato</label>
                                    <div class="col-md-7">
                                        <select class="js-select2 form-control" data-placeholder="Seleccionar un Contrato de Venta" name="id_contrato">
                                            <option></option>
                                            <?php
                                                foreach($ventas as $v)
                                                {
                                                    ?><option value="<?php echo $v['id_venta'] ?>"><?php echo $v['mv_descripcion']?></option><?php
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="id_ginmueble">Grupo de Inmueble</label>
                                    <div class="col-md-7">
                                      <select class="js-select2 form-control" data-placeholder="Seleccionar un Grupo de Inmueble" name="id_ginmueble" onchange="buscarInmuebles(this)">
                                          <option></option>
                                            <?php
                                                foreach($gin as $g)
                                                { if($g['id_grupo_inmuebles'] == 81){ continue; }
                                                    ?><option value="<?php echo $g['id_grupo_inmuebles'] ?>"><?php echo $g['gi_nombre_grupo_inmueble']?></option><?php
                                                }
                                            ?>
                                      </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="id_inmueble">Inmueble</label>
                                    <div class="col-md-7">
                                      <select class="js-select2 form-control" data-placeholder="Seleccionar Inmueble" name="id_inmueble">
                                           <option></option>
                                            <?php
                                                /*foreach($in as $i)
                                                //{
                                                //    ?><option value="<?php echo $i['id_inmueble'] ?>"><?php echo $i['mi_nombre']?></option><?php
                                              / } */
                                            ?>
                                      </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="val-password">Fecha Doc.</label>
                                    <div class="col-md-7">
                                        <div class="input-group input-daterange doc">
                                            <input type="text" class="js-datepicker form-control fechas1" name="fdoc_inicio" placeholder="Desde">
                                            <div style="min-width: 0px" class="input-group-addon"></div>
                                            <input type="text" class="js-datepicker form-control fechas1" name="fdoc_fin" placeholder="Hasta">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="val-password">Fecha Vencimiento</label>
                                    <div class="col-md-7">
                                        <div class="input-group input-daterange venc">
                                            <input type="text" class="js-datepicker form-control fechas2" name="fven_inicio" placeholder="Desde">
                                            <div style="min-width: 0px" class="input-group-addon"></div>
                                            <input type="text" class="js-datepicker form-control fechas2" name="fven_fin" placeholder="Hasta">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="val-username">Estatus</label>
                                    <div class="col-md-7">
                                        <select class="js-select2 form-control" id="val-select2" name="status" style="width: 100%;" data-placeholder="Seleccionar tipo de movimiento">
                                            <option value="">Seleccionar</option>
                                            <option value="0">PAGADO</option>
                                            <option value="1">ABONADO</option>
                                            <option value="2">PENDIENTE / SIN ABONAR</option>
                                            <option value="4">ABONADO / PENDIENTE / SIN ABONAR</option>
                                            <option value="3">TODOS</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-8 col-md-offset-4">
                                        <button class="btn btn-sm btn-primary" type="submit" name="submitFilters">Buscar</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require 'inc/views/base_footer.php'; ?>
<?php require 'inc/views/template_footer_start.php'; ?>
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
<script src="<?php echo $one->assets_folder; ?>/js/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<script src="<?php echo $one->assets_folder; ?>/js/plugins/jquery-auto-complete/jquery.auto-complete.min.js"></script>
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
