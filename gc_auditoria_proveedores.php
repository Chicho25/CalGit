<?php if(!isset($_SESSION)){session_start();}?>
<?php require("conexion/conexion.php"); ?>
<?php require("funciones/funciones.php"); ?>
<?php if(isset($_SESSION['session_gc'])){ ?>
<?php $header_bar = 'base_header.php'; ?>
<?php $menu = true; ?>
<?php /* ################ AUDITORIA DE SEGUIMIENTO ############## */ ?>
<?php require("funciones/funciones_auditorias.php"); ?>
<?php $lugar_mapa = 41; ?>
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
                Ver auditoria de Proveedores.
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
            <h3 class="block-title">Tabla de auditoria de Proveedores <small></small></h3>
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
                    <?php $auditoria_proveedores = auditoria_proveedores($conexion2); ?>
                    <?php while($lista_auditoria_proveedores = mysqli_fetch_array($auditoria_proveedores)){ ?>
                    <tr>
                        <td class="text-center"><img src="<?php echo $lista_auditoria_proveedores['usua_imagen_usuario']; ?>" width = "40"/></td>
                        <td class="font-w600"><?php echo $lista_auditoria_proveedores['usua_nombre'].' '.$lista_auditoria_proveedores['usua_apellido']; ?></td>
                        <td class="hidden-xs"><?php echo $lista_auditoria_proveedores['aup_fecha_hora']; ?></td>
                        <td class="hidden-xs"><?php echo $lista_auditoria_proveedores['aup_comentario']; ?></td>
                        <td class="text-center">
                            <div class="btn-group">
                                <button class="btn btn-default" data-toggle="modal" data-target="#modal-popin<?php echo $lista_auditoria_proveedores['id_auditoria_proveedores']; ?>" type="button"><i class="fa fa-pencil"></i></button>
                            </div>
                        </td>
                    </tr>
                            <div class="modal fade" id="modal-popin<?php echo $lista_auditoria_proveedores['id_auditoria_proveedores']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
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
                                                                <input class="form-control" type="text" id="register1-username" readonly="readonly" value="<?php echo $lista_auditoria_proveedores['aup_id_proveedores']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-xs-12" for="register1-username">NOMBRE COMERCIAL</label>
                                                            <div class="col-xs-12">
                                                                <input class="form-control" type="text" id="register1-username" readonly="readonly" value="<?php echo $lista_auditoria_proveedores['aup_pro_nombre_comercial']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-xs-12" for="register1-username">RAZON SOCIAL </label>
                                                            <div class="col-xs-12">
                                                                <input class="form-control" type="text" id="register1-username" readonly="readonly" value="<?php echo $lista_auditoria_proveedores['aup_pro_razon_social']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-xs-12" for="register1-username">RUC</label>
                                                            <div class="col-xs-12">
                                                                <input class="form-control" type="text" id="register1-username" readonly="readonly" value="<?php echo $lista_auditoria_proveedores['aup_pro_ruc']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-xs-12" for="register1-username">PAIS </label>
                                                            <div class="col-xs-12">
                                                                <input class="form-control" type="text" id="register1-username" readonly="readonly" value="<?php echo $lista_auditoria_proveedores['aup_pro_pais']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-xs-12" for="register1-username">TELEFONO 1 </label>
                                                            <div class="col-xs-12">
                                                                <input class="form-control" type="text" id="register1-username" readonly="readonly" value="<?php echo $lista_auditoria_proveedores['aup_pro_telefono_1']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-xs-12" for="register1-username">TELEFONO 2 </label>
                                                            <div class="col-xs-12">
                                                                <input class="form-control" type="text" id="register1-username" readonly="readonly" value="<?php echo $lista_auditoria_proveedores['aup_pro_telefono_2']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-xs-12" for="register1-username">DESCRIPCION </label>
                                                            <div class="col-xs-12">
                                                                <input class="form-control" type="text" id="register1-username" readonly="readonly" value="<?php echo $lista_auditoria_proveedores['aup_pro_descripcion']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-xs-12" for="register1-username">EMAIL </label>
                                                            <div class="col-xs-12">
                                                                <input class="form-control" type="text" id="register1-username" readonly="readonly" value="<?php echo $lista_auditoria_proveedores['aup_pro_email']; ?>">
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
                                                                    <?php if($lista_auditoria_proveedores['aup_pro_status'] == 1){ ?>  Activa <?php } ?>
                                                                </label>
                                                                <label class="rad-inline" for="example-inline-checkbox1">
                                                                <?php if($lista_auditoria_proveedores['aup_pro_status'] == 0){ ?> Inactiva <?php } ?>
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
