<?php if(!isset($_SESSION)){session_start();}?>
<?php require("conexion/conexion.php"); ?>
<?php require("funciones/funciones.php"); ?>
<?php if(isset($_SESSION['session_gc'])){ ?>
<?php $header_bar = 'base_header.php'; ?>
<?php $menu = true; ?>
<?php /* ################ AUDITORIA DE SEGUIMIENTO ############## */ ?>
<?php require("funciones/funciones_auditorias.php"); ?>
<?php $lugar_mapa = 43; ?>
<?php $dispositivo_acceso = obtener_dispositivo(); ?>
<?php insertar_log_seguimiento($conexion2, ObtenerIP(), $dispositivo_acceso, $lugar_mapa, $_SESSION['session_gc']['usua_id']); ?>
<?php /* ######################################################## */ ?>
<?php if(isset($_POST['nombre_comercial'], $_POST['razon_social'],
                                                $_POST['ruc'],
                                                    $_POST['telefono_1'],
                                                        $_POST['telefono_2'],
                                                            $_POST['descripcion'],
                                                        $_POST['estado'],
                                                    $_POST['id_pais'],
                                                $_POST['id_proveedor'])){ ?>
<?php $sql_update_proveedor = mysqli_query($conexion2, "update maestro_proveedores set pro_nombre_comercial = '".strtoupper($_POST['nombre_comercial'])."',
                                                                                       pro_razon_social = '".strtoupper($_POST['razon_social'])."',
                                                                                       pro_ruc = '".strtoupper($_POST['ruc'])."',
                                                                                       pro_telefono_1 = '".strtoupper($_POST['telefono_1'])."',
                                                                                       pro_telefono_2 = '".strtoupper($_POST['telefono_2'])."',
                                                                                       pro_descripcion = '".strtoupper($_POST['descripcion'])."',
                                                                                       pro_status = '".strtoupper($_POST['estado'])."',
                                                                                       pro_email = '".strtoupper($_POST['email'])."',
                                                                                       pro_pais = '".strtoupper($_POST['id_pais'])."' where id_proveedores = '".$_POST['id_proveedor']."'");

############################# Auditoria ##############################

                                   $tipo_operacion = 2;
                                   $comentario = "Actualizacion de Proveedor";
                                   $sql_insertar_auditoria = $conexion2 -> query("insert into auditoria_proveedores(aup_tipo_operacion,
                                                                                                                    aup_usua_log,
                                                                                                                    aup_comentario,
                                                                                                                    aup_id_proveedores,
                                                                                                                    aup_pro_nombre_comercial,
                                                                                                                    aup_pro_razon_social,
                                                                                                                    aup_pro_ruc,
                                                                                                                    aup_pro_pais,
                                                                                                                    aup_pro_status,
                                                                                                                    aup_pro_telefono_1,
                                                                                                                    aup_pro_telefono_2,
                                                                                                                    aup_pro_descripcion,
                                                                                                                    aup_pro_email
                                                                                                                    )values(
                                                                                                                    '".$tipo_operacion."',
                                                                                                                    '".$_SESSION['session_gc']['usua_id']."',
                                                                                                                    '".$comentario."',
                                                                                                                    '".$_POST['id_proveedor']."',
                                                                                                                    '".$_POST['nombre_comercial']."',
                                                                                                                    '".$_POST['razon_social']."',
                                                                                                                    '".$_POST['ruc']."',
                                                                                                                    '".$_POST['id_pais']."',
                                                                                                                    '".$_POST['estado']."',
                                                                                                                    '".$_POST['telefono_1']."',
                                                                                                                    '".$_POST['telefono_2']."',
                                                                                                                    '".$_POST['descripcion']."',
                                                                                                                    '".$_POST['email']."')");
#######################################################################
} ?>
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
              Ver todos los proveedores <small>ver o editar proveedores.</small>
            </h1>
        </div>
        <?php if(isset($sql_update_proveedor)){ ?>
    <div class="col-sm-3 col-lg-3" style="position: absolute; right: 0px;">
      <!-- Success Alert -->
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h3 class="font-w300 push-15">Datos Actualizados</h3>
            <p><a class="alert-link" href="javascript:void(0)">Los datos</a> fueron actualizados!</p>
        </div>
      <!-- END Success Alert -->
    </div>
    <?php } ?>
    </div>
</div>
<!-- END Page Header -->
<!-- Page Content -->
<div class="content">
<!-- Dynamic Table Full -->
    <div class="block">
        <div class="block-header">
            <h3 class="block-title">Tabla de proveedores del sistema <small>todos los proveedores</small></h3>
        </div>
        <div class="block-content">
            <!-- DataTables init on table by adding .js-dataTable-full class, functionality initialized in js/pages/base_tables_datatables.js -->
            <table class="table table-bordered table-striped js-dataTable-full">
                <thead>
                    <tr>
                        <th class="text-center">ID</th>
                        <th>NOMBRE COMERCIAL</th>
                        <th class="hidden-xs">PAIS</th>
                        <th class="hidden-xs" style="width: 15%;">ESTATUS</th>
                        <th class="text-center" style="width: 10%;">EDITAR</th>
                    </tr>
                </thead>
            <tbody>
            <?php $todos_proveedores = todos_proveedores($conexion2); ?>
            <?php while($lista_todos_proveedores = mysqli_fetch_array($todos_proveedores)){ ?>
                        <tr>
                            <td class="text-center"><?php echo $lista_todos_proveedores['id_proveedores']; ?></td>
                            <td class="font-w600"><?php echo utf8_encode($lista_todos_proveedores['pro_nombre_comercial']); ?></td>
                            <td class="hidden-xs"><?php echo utf8_encode($lista_todos_proveedores['ps_nombre_pais']); ?></td>
                            <td class="hidden-xs"><?php echo $lista_todos_proveedores['estado']; ?></td>

                            <script type="text/javascript">
                              $(document).ready(function() {
                                $("#boton<?php echo $lista_todos_proveedores['id_proveedores']; ?>").click(function(event) {
                                $("#capa<?php echo $lista_todos_proveedores['id_proveedores']; ?>").load('cargas_paginas/ver_proveedores_detsalle.php?id=<?php echo $lista_todos_proveedores['id_proveedores']; ?>');
                                });
                              });
                            </script>

                            <td class="text-center">
                                <div class="btn-group">
                                    <button id="boton<?php echo $lista_todos_proveedores['id_proveedores']; ?>" class="btn btn-default" data-toggle="modal" data-target="#modal-popin<?php echo $lista_todos_proveedores['id_proveedores']; ?>" type="button"><i class="fa fa-pencil"></i></button>
                                </div>
                            </td>
                        </tr>
                        <div class="modal fade" id="modal-popin<?php echo $lista_todos_proveedores['id_proveedores']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-popin">
                              <div id="capa<?php echo $lista_todos_proveedores['id_proveedores']; ?>" class="modal-content">

                              </div>
                            </div>
                        </div>
                          <?php } ?>
                          </tbody>
                  </table>
            <!-- END Dynamic Table Full -->
            <!-- Dynamic Table Simple -->
            <!-- END Dynamic Table Simple -->
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
            window.location="salir.php";
        </script>
<?php } ?>
