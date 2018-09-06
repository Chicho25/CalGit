<?php if(!isset($_SESSION)){session_start();}?>
<?php require("conexion/conexion.php"); ?>
<?php require("funciones/funciones.php"); ?>
<?php if(isset($_SESSION['session_gc'])){ ?>
<?php $header_bar = 'base_header.php'; ?>
<?php $menu = true; ?>
<?php /* ################ AUDITORIA DE SEGUIMIENTO ############## */ ?>
<?php require("funciones/funciones_auditorias.php"); ?>
<?php $lugar_mapa = 36; ?>
<?php $dispositivo_acceso = obtener_dispositivo(); ?>
<?php insertar_log_seguimiento($conexion2, ObtenerIP(), $dispositivo_acceso, $lugar_mapa, $_SESSION['session_gc']['usua_id']); ?>
<?php /* ######################################################## */ ?>
<?php require 'inc/config.php'; ?>
<?php require 'inc/views/template_head_start.php'; ?>
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/datatables/jquery.dataTables.min.css">
<?php require 'inc/views/template_head_end.php'; ?>
<?php require 'inc/views/base_head.php'; ?>
<!-- Page Header -->
<div class="content bg-gray-lighter">
    <div class="row items-push">
        <div class="col-sm-7">
            <h1 class="page-heading">
                Ver auditoria de proyectos.
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
            <h3 class="block-title">Tabla de auditoria de proyectos <small></small></h3>
        </div>
        <div class="block-content">
            <!-- DataTables init on table by adding .js-dataTable-full class, functionality initialized in js/pages/base_tables_datatables.js -->
            <table class="table table-bordered table-striped js-dataTable-full">
                <thead>
                    <tr>
                        <th class="text-center">Imagen</th>
                        <th>Nombre</th>
                        <th class="hidden-xs">Fecha/Hora</th>
                        <th class="hidden-xs" style="width: 15%;">Evento</th>
                        <th class="text-center" style="width: 10%;">Detalles del evento</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $auditoria_proyecto = auditoria_proyecto($conexion2); ?>
                    <?php while($lista_auditoria_proyecto = mysqli_fetch_array($auditoria_proyecto)){ ?>
                    <tr>
                        <td class="text-center"><img src="<?php echo $lista_auditoria_proyecto['usua_imagen_usuario']; ?>" width = "40"/></td>
                        <td class="font-w600"><?php echo $lista_auditoria_proyecto['usua_nombre'].' '.$lista_auditoria_proyecto['usua_apellido']; ?></td>
                        <td class="hidden-xs"><?php echo $lista_auditoria_proyecto['aup_fecha_operacion']; ?></td>
                        <td class="hidden-xs"><?php echo $lista_auditoria_proyecto['aup_comentario']; ?></td>
                        <td class="text-center">
                            <div class="btn-group">
                                <button class="btn btn-default" data-toggle="modal" data-target="#modal-popin<?php echo $lista_auditoria_proyecto['id_auditoria_proyecto']; ?>" type="button"><i class="fa fa-pencil"></i></button>
                            </div>
                        </td>
                    </tr>
                            <div class="modal fade" id="modal-popin<?php echo $lista_auditoria_proyecto['id_auditoria_proyecto']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-popin">
                                    <div class="modal-content">
                                        <div class="block block-themed block-transparent remove-margin-b">
                                            <div class="block-header bg-primary-dark">
                                                <ul class="block-options">
                                                    <li>
                                                        <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                                                    </li>
                                                </ul>
                                                <h3 class="block-title">Datos de la auditoria</h3>
                                            </div>
                                            <div class="block-content">
                                            <!-- Bootstrap Register -->
                                                <div class="block block-themed">
                                                    <div class="block-content">
                                                        <div class="form-group">
                                                            <label class="col-xs-12" for="register1-username">ID</label>
                                                            <div class="col-xs-12">
                                                                <input class="form-control" type="text" id="register1-username" readonly="readonly" value="<?php echo $lista_auditoria_proyecto['aup_id_proyecto']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-xs-12" for="register1-username">NOMBRE DE EMPRESA</label>
                                                            <div class="col-xs-12">
                                                                <select class="js-select2 form-control" id="val-select2" readonly="readonly" style="width: 100%;" data-placeholder="Seleccionar empresa" required="required">
                                                                    <option></option>
                                                                    <?php $sql_empresas = todas_empresas_activas($conexion2); ?>
                                                                    <?php   while($lista_empresas = mysqli_fetch_array($sql_empresas)){ ?>
                                                                    <option value="<?php echo $lista_empresas['id_empresa']; ?>"
                                                                                   <?php if($lista_auditoria_proyecto['aup_id_empresa'] == $lista_empresas['id_empresa']){ echo 'selected'; } ?>
                                                                     ><?php echo $lista_empresas['empre_nombre_comercial']; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-xs-12" for="register1-username">NOMBRE PROYECTO</label>
                                                            <div class="col-xs-12">
                                                                <input class="form-control" type="text" id="register1-username" readonly="readonly" value="<?php echo $lista_auditoria_proyecto['aup_nombre_proyecto']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-xs-12" for="register1-email">TIPO PROYECTO</label>
                                                            <div class="col-xs-12">
                                                                <input class="form-control" type="text" id="register1-email" readonly="readonly" value="<?php echo $lista_auditoria_proyecto['aup_tipo_proyecto']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-xs-12" for="register1-email">PROMOTOR</label>
                                                            <div class="col-xs-12">
                                                                <input class="form-control" type="text" id="register1-email" readonly="readonly" value="<?php echo $lista_auditoria_proyecto['aup_promotor']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-xs-12" > AREA</label>
                                                            <div class="col-xs-12">
                                                                <input class="form-control" type="text" id="register1-email" readonly="readonly" value="<?php echo $lista_auditoria_proyecto['aup_area']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-xs-12" for="register1-email">RESOLUCION AMBIENTAL</label>
                                                            <div class="col-xs-12">
                                                                <input class="form-control" type="email" readonly="readonly" value="<?php echo $lista_auditoria_proyecto['aup_resolucion_ambiental']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-4 control-label" ></label>
                                                            <div class="col-md-7">
                                                                <label class="rad-inline" for="example-inline-checkbox1"></label>
                                                                <label class="rad-inline" for="example-inline-checkbox1"></label>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-4 control-label" >ESTADO</label>
                                                            <div class="col-md-7">
                                                                <label class="rad-inline" for="example-inline-checkbox1">
                                                                    <?php if($lista_auditoria_proyecto['aup_estado'] == 1){ ?>  Activa <?php } ?>
                                                                </label>
                                                                <label class="rad-inline" for="example-inline-checkbox1">
                                                                <?php if($lista_auditoria_proyecto['aup_estado'] == 0){ ?> Inactiva <?php } ?>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php } ?>
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
<script type="text/javascript" src="bootstrap-filestyle.min.js"> </script>
<script src="<?php echo $one->assets_folder; ?>/js/plugins/datatables/jquery.dataTables.min.js"></script>
<!-- Page JS Code -->
<script src="<?php echo $one->assets_folder; ?>/js/pages/base_tables_datatables.js"></script>
<?php require 'inc/views/template_footer_end.php'; ?>
<?php }else{ ?>
        <script type="text/javascript">
            window.location="index.php";
        </script>
<?php } ?>
