<?php if(!isset($_SESSION)){session_start();}?>
<?php require("conexion/conexion.php"); ?>
<?php require("funciones/funciones.php"); ?>
<?php if(isset($_SESSION['session_gc'])){ ?>
<?php $header_bar = 'base_header.php'; ?>
<?php $menu = true; ?>
<?php /* ################ AUDITORIA DE SEGUIMIENTO ############## */ ?>
<?php require("funciones/funciones_auditorias.php"); ?>
<?php $lugar_mapa = 34; ?>
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
                Ver auditoria de los usuarios.
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
            <h3 class="block-title">Tabla de auditoria de usuarios <small></small></h3>
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
                    <?php $todos_usuarios = auditoria_usuarios($conexion2); ?>
                    <?php while($lista_todos_usuarios = mysqli_fetch_array($todos_usuarios)){ ?>
                    <tr>
                        <td class="text-center"><img src="<?php echo $lista_todos_usuarios['usua_imagen_usuario']; ?>" width = "40"/></td>
                        <td class="font-w600"><?php echo $lista_todos_usuarios['usua_nombre'].' '.$lista_todos_usuarios['usua_apellido']; ?></td>
                        <td class="hidden-xs"><?php echo $lista_todos_usuarios['auu_fecha_operacion']; ?></td>
                        <td class="hidden-xs"><?php echo $lista_todos_usuarios['auu_comentario']; ?></td>
                        <td class="text-center">
                            <div class="btn-group">
                                <button class="btn btn-default" data-toggle="modal" data-target="#modal-popin<?php echo $lista_todos_usuarios['id_auditoria_usuario']; ?>" type="button"><i class="fa fa-pencil"></i></button>
                            </div>
                        </td>
                    </tr>
                            <div class="modal fade" id="modal-popin<?php echo $lista_todos_usuarios['id_auditoria_usuario']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
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
                                                <div class="block block-themed">
                                                    <div class="block-content">
                                                        <div class="form-group">
                                                            <label class="col-xs-12" for="register1-username">Nombre</label>
                                                            <div class="col-xs-12">
                                                                <input class="form-control" type="text" id="register1-username" readonly="readonly" value="<?php echo $lista_todos_usuarios['auu_usua_nombre']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-xs-12" for="register1-username">Apellido</label>
                                                            <div class="col-xs-12">
                                                                <input class="form-control" type="text" id="register1-username" readonly="readonly" value="<?php echo $lista_todos_usuarios['auu_usua_apellido']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-xs-12" for="register1-email">Email</label>
                                                            <div class="col-xs-12">
                                                                <input class="form-control" type="text" id="register1-email" readonly="readonly" value="<?php echo $lista_todos_usuarios['auu_usua_usuario']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-xs-12" for="register1-email">Fecha de registro</label>
                                                            <div class="col-xs-12">
                                                                <input class="form-control" readonly="readonly" type="text" id="register1-email" value="<?php echo $lista_todos_usuarios['auu_fecha_operacion']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-xs-12" for="register1-email">Password</label>
                                                            <div class="col-xs-12">
                                                                <input class="form-control" readonly="readonly" type="text" id="register1-email" value="<?php echo $lista_todos_usuarios['auu_usua_pass']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-xs-12" for="register1-email">Imagen</label>
                                                            <div class="col-xs-12">
                                                                <img width="200" height="200" style="padding-bottom: 5px;" src="<?php echo $lista_todos_usuarios['auu_usua_imagen_usuario']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-xs-12" for="register1-password2">Roll</label>
                                                            <div class="col-xs-12">
                                                                <select class="form-control" id="contact1-subject" name="roll" size="1" readonly="readonly">
                                                                    <option value="">Seleccionar</option>
                                                                    <?php $listado_roles = listado_roll($conexion2); ?>
                                                                    <?php while($lisa_roles = mysqli_fetch_array($listado_roles)){ ?>
                                                                    <option value="<?php echo $lisa_roles['id_roll']; ?>"
                                                                    <?php if($lista_todos_usuarios['auu_roll_acceso'] == $lisa_roles['id_roll'])
                                                                    { echo 'selected';}?> > <?php echo $lisa_roles['roll_nombre']; ?></option> <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-xs-12" for="register1-email" >Status</label>
                                                            <div class="col-xs-12">
                                                              <div class="form-group">
                                                                  <div class="col-md-8">
                                                                    <label class="css-input css-checkbox css-checkbox-primary">
                                                                      <?php if($lista_todos_usuarios['auu_usua_stat'] == 1){ echo 'Activo';}  ?>
                                                                    </label>
                                                                    <label class="rad-inline" for="example-inline-checkbox1">
                                                                      <?php if($lista_todos_usuarios['auu_usua_stat'] == 0){ echo 'Inactivo';}  ?>
                                                                    </label>
                                                                  </div>
                                                              </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-xs-12" for="register1-email">Accesos permitidos</label>
                                                            <div class="col-xs-12">
                                                            <?php $sql_accesos = auditoria_accesos($conexion2, $lista_todos_usuarios['auu_id_user'], $lista_todos_usuarios['auu_fecha_operacion']); ?>
                                                            <?php while($lista_accesos = mysqli_fetch_array($sql_accesos)){?>
                                                            <div class="form-group">
                                                                <div class="col-md-8">
                                                                    <label class="css-input css-checkbox css-checkbox-primary">
                                                                       <?php echo $lista_accesos['modulo_nombre']; ?>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <?php } ?>
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
