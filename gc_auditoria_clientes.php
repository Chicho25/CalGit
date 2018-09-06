<?php if(!isset($_SESSION)){session_start();}?>
<?php require("conexion/conexion.php"); ?>
<?php require("funciones/funciones.php"); ?>
<?php if(isset($_SESSION['session_gc'])){ ?>
<?php $header_bar = 'base_header.php'; ?>
<?php $menu = true; ?>
<?php /* ################ AUDITORIA DE SEGUIMIENTO ############## */ ?>
<?php require("funciones/funciones_auditorias.php"); ?>
<?php $lugar_mapa = 39; ?>
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
                Ver auditoria de clientes.
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
            <h3 class="block-title">Tabla de auditoria de clientes <small></small></h3>
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
                    <?php $auditoria_clientes = auditoria_clienets($conexion2); ?>
                    <?php while($lista_auditoria_clientes = mysqli_fetch_array($auditoria_clientes)){ ?>
                    <tr>
                        <td class="text-center"><img src="<?php echo $lista_auditoria_clientes['usua_imagen_usuario']; ?>" width = "40"/></td>
                        <td class="font-w600"><?php echo $lista_auditoria_clientes['usua_nombre'].' '.$lista_auditoria_clientes['usua_apellido']; ?></td>
                        <td class="hidden-xs"><?php echo $lista_auditoria_clientes['auc_fecha_hora']; ?></td>
                        <td class="hidden-xs"><?php echo $lista_auditoria_clientes['auc_comentario']; ?></td>
                        <td class="text-center">
                            <div class="btn-group">
                                <button class="btn btn-default" data-toggle="modal" data-target="#modal-popin<?php echo $lista_auditoria_clientes['id_auditoria_clientes']; ?>" type="button"><i class="fa fa-pencil"></i></button>
                            </div>
                        </td>
                    </tr>
                            <div class="modal fade" id="modal-popin<?php echo $lista_auditoria_clientes['id_auditoria_clientes']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
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
                                                                <input class="form-control" type="text" id="register1-username" readonly="readonly" value="<?php echo $lista_auditoria_clientes['auc_id_cliente']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-xs-12" for="register1-username">NOMBRE </label>
                                                            <div class="col-xs-12">
                                                                <input class="form-control" type="text" id="register1-username" readonly="readonly" value="<?php echo $lista_auditoria_clientes['auc_nombre']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-xs-12" for="register1-username">APELLIDO </label>
                                                            <div class="col-xs-12">
                                                                <input class="form-control" type="text" id="register1-username" readonly="readonly" value="<?php echo $lista_auditoria_clientes['auc_apellido']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-xs-12" for="register1-username">TELEFONO 1 </label>
                                                            <div class="col-xs-12">
                                                                <input class="form-control" type="text" id="register1-username" readonly="readonly" value="<?php echo $lista_auditoria_clientes['auc_telefono_1']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-xs-12" for="register1-username">TELEFONO 2 </label>
                                                            <div class="col-xs-12">
                                                                <input class="form-control" type="text" id="register1-username" readonly="readonly" value="<?php echo $lista_auditoria_clientes['auc_telefono_2']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-xs-12" for="register1-username">IDENTIFICACION </label>
                                                            <div class="col-xs-12">
                                                                <input class="form-control" type="text" id="register1-username" readonly="readonly" value="<?php echo $lista_auditoria_clientes['auc_identificacion']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-xs-12" for="register1-username">PAIS </label>
                                                            <div class="col-xs-12">
                                                                <input class="form-control" type="text" id="register1-username" readonly="readonly" value="<?php echo $lista_auditoria_clientes['ps_nombre_pais']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-xs-12" for="register1-username">DIRECCION </label>
                                                            <div class="col-xs-12">
                                                                <input class="form-control" type="text" id="register1-username" readonly="readonly" value="<?php echo $lista_auditoria_clientes['auc_direccion']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-xs-12" for="register1-username">EMAIL </label>
                                                            <div class="col-xs-12">
                                                                <input class="form-control" type="text" id="register1-username" readonly="readonly" value="<?php echo $lista_auditoria_clientes['auc_email']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-xs-12" for="register1-username">REFERENCIA </label>
                                                            <div class="col-xs-12">
                                                                <textarea class="form-control" id="register1-username" readonly="readonly"><?php echo $lista_auditoria_clientes['auc_referencia']; ?></textarea>
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
                                                                    <?php if($lista_auditoria_clientes['auc_status'] == 1){ ?>  Activa <?php } ?>
                                                                </label>
                                                                <label class="rad-inline" for="example-inline-checkbox1">
                                                                <?php if($lista_auditoria_clientes['auc_status'] == 0){ ?> Inactiva <?php } ?>
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
