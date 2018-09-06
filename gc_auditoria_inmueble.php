<?php if(!isset($_SESSION)){session_start();}?>
<?php require("conexion/conexion.php"); ?>
<?php require("funciones/funciones.php"); ?>
<?php if(isset($_SESSION['session_gc'])){ ?>
<?php $header_bar = 'base_header.php'; ?>
<?php $menu = true; ?>
<?php /* ################ AUDITORIA DE SEGUIMIENTO ############## */ ?>
<?php require("funciones/funciones_auditorias.php"); ?>
<?php $lugar_mapa = 40; ?>
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
                    <?php $auditoria_inmuebles = auditoria_inmuebles($conexion2); ?>
                    <?php while($lista_auditoria_inmuebles = mysqli_fetch_array($auditoria_inmuebles)){ ?>
                    <tr>
                        <td class="text-center"><img src="<?php echo $lista_auditoria_inmuebles['usua_imagen_usuario']; ?>" width = "40"/></td>
                        <td class="font-w600"><?php echo $lista_auditoria_inmuebles['usua_nombre'].' '.$lista_auditoria_inmuebles['usua_apellido']; ?></td>
                        <td class="hidden-xs"><?php echo $lista_auditoria_inmuebles['aui_fecha_hora']; ?></td>
                        <td class="hidden-xs"><?php echo $lista_auditoria_inmuebles['aui_comentario']; ?></td>
                        <td class="text-center">
                            <div class="btn-group">
                                <button class="btn btn-default" data-toggle="modal" data-target="#modal-popin<?php echo $lista_auditoria_inmuebles['id_auditoria_inmueble']; ?>" type="button"><i class="fa fa-pencil"></i></button>
                            </div>
                        </td>
                    </tr>
                      <div class="modal fade" id="modal-popin<?php echo $lista_auditoria_inmuebles['id_auditoria_inmueble']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
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
                                                          <input class="form-control" type="text" id="register1-username" readonly="readonly" value="<?php echo $lista_auditoria_inmuebles['aui_id_inmueble']; ?>">
                                                      </div>
                                                  </div>
                                                  <div class="form-group">
                                                      <label class="col-xs-12" for="register1-username">GRUPO DE INMUEBLE </label>
                                                      <div class="col-xs-12">
                                                          <input class="form-control" type="text" id="register1-username" readonly="readonly" value="<?php echo $lista_auditoria_inmuebles['aui_id_grupo_inmuebles']; ?>">
                                                      </div>
                                                  </div>
                                                  <div class="form-group">
                                                      <label class="col-xs-12" for="register1-username">TIPO DE INMUEBLE </label>
                                                      <div class="col-xs-12">
                                                          <input class="form-control" type="text" id="register1-username" readonly="readonly" value="<?php echo $lista_auditoria_inmuebles['aui_id_tipo_inmuebles']; ?>">
                                                      </div>
                                                  </div>
                                                  <div class="form-group">
                                                      <label class="col-xs-12" for="register1-username">NOMBRE DE INMUEBLE </label>
                                                      <div class="col-xs-12">
                                                          <input class="form-control" type="text" id="register1-username" readonly="readonly" value="<?php echo $lista_auditoria_inmuebles['aui_mi_nombre']; ?>">
                                                      </div>
                                                  </div>
                                                  <div class="form-group">
                                                      <label class="col-xs-12" for="register1-username">MODELO </label>
                                                      <div class="col-xs-12">
                                                          <input class="form-control" type="text" id="register1-username" readonly="readonly" value="<?php echo $lista_auditoria_inmuebles['aui_mi_modelo']; ?>">
                                                      </div>
                                                  </div>
                                                  <div class="form-group">
                                                      <label class="col-xs-12" for="register1-username">AREA </label>
                                                      <div class="col-xs-12">
                                                          <input class="form-control" type="text" id="register1-username" readonly="readonly" value="<?php echo $lista_auditoria_inmuebles['aui_mi_area']; ?>">
                                                      </div>
                                                  </div>
                                                  <div class="form-group">
                                                      <label class="col-xs-12" for="register1-username">HABITACIONES </label>
                                                      <div class="col-xs-12">
                                                          <input class="form-control" type="text" id="register1-username" readonly="readonly" value="<?php echo $lista_auditoria_inmuebles['aui_mi_habitaciones']; ?>">
                                                      </div>
                                                  </div>
                                                  <div class="form-group">
                                                      <label class="col-xs-12" for="register1-username">SANITARIOS </label>
                                                      <div class="col-xs-12">
                                                          <input class="form-control" type="text" id="register1-username" readonly="readonly" value="<?php echo $lista_auditoria_inmuebles['aui_mi_sanitarios']; ?>">
                                                      </div>
                                                  </div>
                                                  <div class="form-group">
                                                      <label class="col-xs-12" for="register1-username">DEPOSITOS </label>
                                                      <div class="col-xs-12">
                                                          <input class="form-control" type="text" id="register1-username" readonly="readonly" value="<?php echo $lista_auditoria_inmuebles['aui_mi_depositos']; ?>">
                                                      </div>
                                                  </div>
                                                  <div class="form-group">
                                                      <label class="col-xs-12" for="register1-username">ESTACIONAMIENTOS </label>
                                                      <div class="col-xs-12">
                                                          <input class="form-control" type="text" id="register1-username" readonly="readonly" value="<?php echo $lista_auditoria_inmuebles['aui_mi_estacionamientos']; ?>">
                                                      </div>
                                                  </div>
                                                  <div class="form-group">
                                                      <label class="col-xs-12" for="register1-username">OBSERVACIONES </label>
                                                      <div class="col-xs-12">
                                                          <input class="form-control" type="text" id="register1-username" readonly="readonly" value="<?php echo $lista_auditoria_inmuebles['aui_mi_observaciones']; ?>">
                                                      </div>
                                                  </div>
                                                  <div class="form-group">
                                                      <label class="col-xs-12" for="register1-username">PRECIO REAL </label>
                                                      <div class="col-xs-12">
                                                          <input class="form-control" type="text" id="register1-username" readonly="readonly" value="<?php echo $lista_auditoria_inmuebles['aui_mi_precio_real']; ?>">
                                                      </div>
                                                  </div>
                                                  <div class="form-group">
                                                      <label class="col-xs-12" for="register1-username">PARTIDA / COMISION </label>
                                                      <div class="col-xs-12">
                                                          <input class="form-control" type="text" id="register1-username" readonly="readonly" value="<?php echo $lista_auditoria_inmuebles['aui_mi_id_partida_comision']; ?>">
                                                      </div>
                                                  </div>
                                                  <div class="form-group">
                                                      <label class="col-xs-12" for="register1-username">PORCENTAJE COMISION </label>
                                                      <div class="col-xs-12">
                                                          <input class="form-control" type="text" id="register1-username" readonly="readonly" value="<?php echo $lista_auditoria_inmuebles['aui_mi_porcentaje_comision']; ?>">
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
                                                      <label class="col-md-4 control-label" >DISPONIBLE</label>
                                                      <div class="col-md-7">
                                                          <label class="rad-inline" for="example-inline-checkbox1">
                                                              <?php if($lista_auditoria_inmuebles['aui_mi_disponible'] == 1){ ?>  Disponible <?php } ?>
                                                          </label>
                                                          <label class="rad-inline" for="example-inline-checkbox1">
                                                          <?php if($lista_auditoria_inmuebles['aui_mi_disponible'] == 0){ ?> No disponible <?php } ?>
                                                          </label>
                                                      </div>
                                                  </div>
                                                  <div class="form-group">
                                                      <label class="col-md-4 control-label" >ESTADO</label>
                                                      <div class="col-md-7">
                                                          <label class="rad-inline" for="example-inline-checkbox1">
                                                              <?php if($lista_auditoria_inmuebles['aui_mi_status'] == 1){ ?>  Activa <?php } ?>
                                                          </label>
                                                          <label class="rad-inline" for="example-inline-checkbox1">
                                                          <?php if($lista_auditoria_inmuebles['aui_mi_status'] == 0){ ?> Inactiva <?php } ?>
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
