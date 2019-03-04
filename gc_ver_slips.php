<?php if(!isset($_SESSION)){session_start();}?>
<?php require("conexion/conexion.php"); ?>
<?php require("funciones/funciones.php"); ?>
<?php if(isset($_SESSION['session_gc'])){ ?>
<?php $header_bar = 'base_header.php'; ?>
<?php $menu = true; ?>
<?php /* ################ AUDITORIA DE SEGUIMIENTO ############## */ ?>
<?php require("funciones/funciones_auditorias.php"); ?>
<?php $lugar_mapa = 18; ?>
<?php $dispositivo_acceso = obtener_dispositivo(); ?>
<?php insertar_log_seguimiento($conexion2, ObtenerIP(), $dispositivo_acceso, $lugar_mapa, $_SESSION['session_gc']['usua_id']); ?>
<?php /* ######################################################## */ ?>
<?php /* Eliminar Inmueble */ ?>
<?php if(isset($_POST['eliminar'])){

        $eliminar_inmueble = $conexion2 ->query("delete from maestro_inmuebles where id_inmueble = '".$_POST['eliminar']."'");

} ?>
<?php $nombre_pagina = "Inmuebles"; ?>
<?php if(isset($_POST['id_grupo_inmuebles'],
                    $_POST['tipo_inmuebles'],
                        $_POST['nombre'])){ ?>
<?php $sql_update_inmueble = mysqli_query($conexion2, "update maestro_inmuebles set id_proyecto = '".$_POST['id_proyecto']."',
                                                        id_grupo_inmuebles = '".$_POST['id_grupo_inmuebles']."',
                                                        id_tipo_inmuebles = '".$_POST['tipo_inmuebles']."',
                                                        mi_nombre = '".$_POST['nombre']."',
                                                        mi_modelo = '".$_POST['modelo']."',
                                                        mi_area = '".$_POST['area']."',
                                                        mi_habitaciones = '".$_POST['habitaciones']."',
                                                        mi_sanitarios = '".$_POST['banios']."',
                                                        mi_depositos = '".$_POST['depositos']."',
                                                        mi_estacionamientos = '".$_POST['estacionamientos']."',
                                                        mi_observaciones = '".$_POST['observaciones']."',
                                                        mi_precio_real = '".$_POST['precio']."',
                                                        mi_disponible = '".$_POST['disponible']."',
                                                        mi_id_partida_comision = '".$_POST['partida_comision']."',
                                                        mi_porcentaje_comision = '".$_POST['porcentaje_comision']."',
                                                        mi_log_user = '".$_SESSION['session_gc']['usua_id']."',
                                                        mi_status = '".$_POST['estado']."'
                                                        where
                                                        id_inmueble = '".$_POST['id_inmueble']."'");
            //mi_status = '".$_POST['estado']."',
############################# Auditoria ##############################

                     $tipo_operacion = 2;
                     $comentario = "Actualizacion de Inmueble";
                     $sql_insertar_auditoria = $conexion2 -> query("insert into auditoria_inmueble(aui_tipo_operacion,
                                                                   aui_usua_log,
                                                                   aui_comentario,
                                                                   id_auditoria_proyecto,
                                                                   aui_id_inmueble,
                                                                   aui_id_grupo_inmuebles,
                                                                   aui_id_tipo_inmuebles,
                                                                   aui_mi_nombre,
                                                                   aui_mi_modelo,
                                                                   aui_mi_area,
                                                                   aui_mi_habitaciones,
                                                                   aui_mi_sanitarios,
                                                                   aui_mi_depositos,
                                                                   aui_mi_estacionamientos,
                                                                   aui_mi_observaciones,
                                                                   aui_mi_precio_real,
                                                                   aui_mi_disponible,
                                                                   aui_mi_id_partida_comision,
                                                                   aui_mi_porcentaje_comision,
                                                                   aui_mi_status
                                                                   )values(
                                                                   '".$tipo_operacion."',
                                                                   '".$_SESSION['session_gc']['usua_id']."',
                                                                   '".$comentario."',
                                                                   '".$_POST['id_proyecto']."',
                                                                   '".$_POST['id_inmueble']."',
                                                                   '".$_POST['id_grupo_inmuebles']."',
                                                                   '".$_POST['tipo_inmuebles']."',
                                                                   '".$_POST['nombre']."',
                                                                   '".$_POST['modelo']."',
                                                                   '".$_POST['area']."',
                                                                   '".$_POST['habitaciones']."',
                                                                   '".$_POST['banios']."',
                                                                   '".$_POST['depositos']."',
                                                                   '".$_POST['estacionamientos']."',
                                                                   '".$_POST['observaciones']."',
                                                                   '".$_POST['precio']."',
                                                                   '".$_POST['disponible']."',
                                                                   '".$_POST['partida_comision']."',
                                                                   '".$_POST['porcentaje_comision']."',
                                                                   '1')");
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
                Ver todos los <?php echo $nombre_pagina.' / Slip'; ?> <small>ver o editar <?php echo $nombre_pagina; ?>.</small>
            </h1>
        </div>

    </div>
    <?php if(isset($sql_update_inmueble)){ ?>
            <!-- Success Alert -->
            <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h3 class="font-w300 push-15">Datos Actualizados</h3>
                <p><a class="alert-link" href="javascript:void(0)">Los datos</a> fueron actualizados!</p>
            </div>
            <!-- END Success Alert -->
    <?php }elseif(isset($eliminar_inmueble)){ ?>
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h3 class="font-w300 push-15">Inmueble eliminado</h3>
                <p><a class="alert-link" href="javascript:void(0)">Los datos</a> del inmueble fueron elimimados!</p>
            </div>
    <?php } ?>
</div>

<!-- END Page Header -->
<!-- Page Content -->
<div class="content">
    <!-- Dynamic Table Full -->
    <div class="block">
        <div class="block-header">
            <h2 class="block-title" style="font-size:18px;">
              Proyecto:
              <?php
              if(isset($_POST['id_proyecto'],
                              $_POST['id_grupo_inmueble'],
                                $_POST['id_inmueble'],
                                  $_POST['area'],
                                    $_POST['n_sanitarios'],
                                      $_POST['n_depositos'],
                                        $_POST['n_estacionamientos'],
                                          $_POST['status'])){
                    $todos_inmuebles = todos_inmuebles_filtros($conexion2, $_POST['id_proyecto'], $_POST['id_grupo_inmueble'], $_POST['id_inmueble'], $_POST['area'], $_POST['n_sanitarios'], $_POST['n_depositos'], $_POST['n_estacionamientos'], $_POST['status']);

                    while($lista_todos_inmuebles = $todos_inmuebles -> fetch_array()){

                      $nombre_proyecto = $lista_todos_inmuebles['proy_nombre_proyecto'];
                      $_SESSION["proye"] = $nombre_proyecto;
                    }
                }

                echo 'VISTA MAR MARINA'; ?>
            </h2>
        </div>
        <div class="block-content">
            <!-- DataTables init on table by adding .js-dataTable-full class, functionality initialized in js/pages/base_tables_datatables.js -->
            <table class="table table-bordered table-striped js-dataTable-full">
                <thead>
                    <tr>
                        <th class="text-center">ID</th>
                        <th text-center>GRUPO </th>
                        <th class="text-center">CODIGO</th>
                        <th text-center>NOMBRE INMUEBLE</th>
                        <th class="text-center">MODELO</th>
                        <th class="hidden-xs" style="width: 15%;">ESTATUS DE INMUEBLE</th>
                        <th class="text-center" style="width: 10%;">TIPO</th>
                        <th class="text-center" style="width: 10%;">PRECIO</th>
                        <th class="text-center" style="width: 10%;">EDITAR</th>
                        <th class="text-center" style="width: 10%;">ELIMINAR</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(isset($_POST['id_proyecto'],
                                    $_POST['id_grupo_inmueble'],
                                      $_POST['id_inmueble'],
                                        $_POST['area'],
                                          $_POST['n_sanitarios'],
                                            $_POST['n_depositos'],
                                              $_POST['n_estacionamientos'],
                                                $_POST['status'])){
                          $todos_inmuebles = todos_inmuebles_filtros($conexion2, $_POST['id_proyecto'], $_POST['id_grupo_inmueble'], $_POST['id_inmueble'], $_POST['area'], $_POST['n_sanitarios'], $_POST['n_depositos'], $_POST['n_estacionamientos'], $_POST['status']);
                            }else{ ?>
                    <?php $todos_inmuebles = $conexion2 -> query("select
                                                                  *
                                                                  from
                                                                  maestro_inmuebles mi inner join maestro_proyectos mp on mp.id_proyecto = mi.id_proyecto
                                                                                       inner join grupo_inmuebles gi on mi.id_grupo_inmuebles = gi.id_grupo_inmuebles
                                                                                       inner join maestro_status ms on ms.id_status = mi.mi_status
                                                                  where
                                                                  mi.id_proyecto = 13
                                                                  and
                                                                  mi.mi_status not in(17)");} ?>
                    <?php while($lista_todos_inmuebles = $todos_inmuebles -> fetch_array()){ ?>
                    <tr>
                        <td class="text-center"><?php echo $lista_todos_inmuebles['id_inmueble']; ?></td>
                        <td class="text-center"><?php echo $lista_todos_inmuebles['gi_nombre_grupo_inmueble']; ?></td>
                        <td class="text-center"><?php echo $lista_todos_inmuebles['mi_codigo_imueble']; ?></td>
                        <td class="font-w600"><?php echo $lista_todos_inmuebles['mi_nombre']; ?></td>
                        <td class="font-w600"><?php echo $lista_todos_inmuebles['mi_modelo']; ?></td>
                        <td class="hidden-xs"><?php echo $lista_todos_inmuebles['st_nombre']; ?></td>
                        <td class="text-center"><?php echo $lista_todos_inmuebles['mi_nombre']; ?></td>
                        <td class="text-center"><?php echo number_format($lista_todos_inmuebles['mi_precio_real'], 2, '.',','); ?></td>
                        <script type="text/javascript">
                          $(document).ready(function() {
                            $("#boton<?php echo $lista_todos_inmuebles['id_inmueble']; ?>").click(function(event) {
                            $("#capa<?php echo $lista_todos_inmuebles['id_inmueble']; ?>").load('cargas_paginas/ver_inmuebles_detalle.php?id=<?php echo $lista_todos_inmuebles['id_inmueble']; ?>');
                            });
                          });
                        </script>
                        <td class="text-center">
                            <div class="btn-group">
                                <button id="boton<?php echo $lista_todos_inmuebles['id_inmueble']; ?>" class="btn btn-default" data-toggle="modal" data-target="#modal-popin<?php echo $lista_todos_inmuebles['id_inmueble']; ?>" type="button"><i class="fa fa-pencil"></i></button>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="btn-group">
                              <script type="text/javascript">
                                $(document).ready(function() {
                                  $("#boton_e<?php echo $lista_todos_inmuebles['id_inmueble']; ?>").click(function(event) {
                                  $("#capa_e<?php echo $lista_todos_inmuebles['id_inmueble']; ?>").load('cargas_paginas/elininar_inmueble.php?id=<?php echo $lista_todos_inmuebles['id_inmueble']; ?>');
                                  });
                                });
                              </script>
                                 <button id="boton_e<?php echo $lista_todos_inmuebles['id_inmueble']; ?>" class="btn btn-default" data-toggle="modal" data-target="#modal-popina<?php echo $lista_todos_inmuebles['id_inmueble']; ?>" type="button"><i class="fa fa-trash-o"></i></button>

                            </div>

                        </td>
                    </tr>

                            <div class="modal fade" id="modal-popina<?php echo $lista_todos_inmuebles['id_inmueble']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-popin">
                                <div id="capa_e<?php echo $lista_todos_inmuebles['id_inmueble']; ?>" class="modal-content">

                                </div>
                             </div>
                           </div>

                            <div class="modal fade" id="modal-popin<?php echo $lista_todos_inmuebles['id_inmueble']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-popin">
                                    <div id="capa<?php echo $lista_todos_inmuebles['id_inmueble']; ?>" class="modal-content">

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
<script type="text/javascript" src="bootstrap-filestyle.min.js"></script>
<script src="<?php echo $one->assets_folder; ?>/js/plugins/datatables/jquery.dataTables.min.js"></script>
<!-- Page JS Code -->
<script src="<?php echo $one->assets_folder; ?>/js/pages/base_tables_datatables.js"></script>
<?php require 'inc/views/template_footer_end.php'; ?>
<?php }else{ ?>
        <script type="text/javascript">
            window.location="salir.php";
        </script>
<?php } ?>
