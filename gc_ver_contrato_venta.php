<?php if(!isset($_SESSION)){session_start();}?>
<?php require("conexion/conexion.php"); ?>
<?php require("funciones/funciones.php"); ?>
<?php if(isset($_SESSION['session_gc'])){ ?>
<?php $header_bar = 'base_header.php'; ?>
<?php $menu = true; ?>
<?php /* ################ AUDITORIA DE SEGUIMIENTO ############## */ ?>
<?php require("funciones/funciones_auditorias.php"); ?>
<?php $lugar_mapa = 29; ?>
<?php $dispositivo_acceso = obtener_dispositivo(); ?>
<?php insertar_log_seguimiento($conexion2, ObtenerIP(), $dispositivo_acceso, $lugar_mapa, $_SESSION['session_gc']['usua_id']); ?>
<?php /* ######################################################## */ ?>

<?php if(isset($_POST['eliminar'])){

        $eliminar_movimiento_bancario = $conexion2 -> query("delete from movimiento_bancario where id_contrato_venta = '".$_POST['eliminar']."'");
        $eliminar_cuotas_hijas = $conexion2 ->query("delete from maestro_cuota_abono where mca_id_documento_venta = '".$_POST['eliminar']."'");
        $eliminar_facturas_cuotas = $conexion2 ->query("delete from maestro_cuotas where id_contrato_venta = '".$_POST['eliminar']."'");
        $eliminar_comisiones = $conexion2 ->query("delete from comisiones_vendedores where id_contrato_venta = '".$_POST['eliminar']."'");
        $eliminar_contrato = $conexion2 ->query("delete from maestro_ventas where id_venta = '".$_POST['eliminar']."'");
        $update_inmueble = $conexion2 -> query("update maestro_inmuebles set mi_status = 1 where id_inmueble = '".$_POST['id_inmueble']."'");
} ?>

<?php if(isset($_POST['liberar'])){

        //$update1_cuotas_hijas = $conexion2 ->query("update maestro_cuota_abono set where mca_id_documento_venta = '".$_POST['liberar']."'");
        /*$select_cliente = $conexion2 ->query("SELECT * FROM maestro_ventas WHERE id_venta = '".$_POST['liberar']."'");
        while($cli[] = $select_cliente->fetch_array());
        foreach ($cli as $key => $value) {
          $id_cliente = $value['id_cliente'];

          $insertar_inmueble = $conexion2 -> query("INSERT INTO maestro_clientes(cl_nombre,
                                                                                  cl_apellido,
                                                                                  cl_identificacion,
                                                                                  cl_pais,
                                                                                  cl_direccion,
                                                                                  cl_telefono_1,
                                                                                  cl_telefono_2,
                                                                                  cl_status,
                                                                                  cl_email,
                                                                                  cl_referencia
                                                                                   )VALUES(
                                                                                   '".$value['cl_nombre']."',
                                                                                   '".$value['cl_apellido']."',
                                                                                   '".$value['cl_identificacion']."',
                                                                                   '".$value['cl_pais']."',
                                                                                   '".$value['cl_direccion']."',
                                                                                   '".$value['cl_telefono_1']."',
                                                                                   '".$value['cl_telefono_2']."',
                                                                                   1,
                                                                                   '".$value['cl_email']."',
                                                                                   '".$value['cl_referencia']."')");


          $update1_facturas_cuotas = $conexion2 ->query("update maestro_clientes set cl_status = 17 where id_cliente = '".$id_cliente."'");

          break;*/


        $update1_facturas_cuotas = $conexion2 ->query("update maestro_cuotas set mc_status = 17 where id_contrato_venta = '".$_POST['liberar']."'");
        //$update1_comisiones = $conexion2 ->query("update comisiones_vendedores set where id_contrato_venta = '".$_POST['liberar']."'");
        $update1_contrato = $conexion2 ->query("update maestro_ventas set mv_status = 17 where id_venta = '".$_POST['liberar']."'");
        $update1_inmueble = $conexion2 -> query("update maestro_inmuebles set mi_status = 17 where id_inmueble = '".$_POST['id_inmueble']."'");
        $select_inmueble = $conexion2 -> query("SELECT * FROM maestro_inmuebles WHERE id_inmueble = '".$_POST['id_inmueble']."'");
        while($li[] = $select_inmueble->fetch_array());
        foreach ($li as $key => $value) {
        $insertar_inmueble = $conexion2 -> query("INSERT INTO maestro_inmuebles(id_proyecto,
                                                                                 id_grupo_inmuebles,
                                                                                 id_tipo_inmuebles,
                                                                                 mi_nombre,
                                                                                 mi_modelo,
                                                                                 mi_area,
                                                                                 mi_habitaciones,
                                                                                 mi_sanitarios,
                                                                                 mi_depositos,
                                                                                 mi_estacionamientos,
                                                                                 mi_observaciones,
                                                                                 mi_precio_real,
                                                                                 mi_disponible,
                                                                                 mi_id_partida_comision,
                                                                                 mi_porcentaje_comision,
                                                                                 mi_fecha_registro,
                                                                                 mi_status,
                                                                                 mi_log_user,
                                                                                 mi_codigo_imueble
                                                                                 )VALUES(
                                                                                 '".$value['id_proyecto']."',
                                                                                 '".$value['id_grupo_inmuebles']."',
                                                                                 '".$value['id_tipo_inmuebles']."',
                                                                                 '".$value['mi_nombre']."',
                                                                                 '".$value['mi_modelo']."',
                                                                                 '".$value['mi_area']."',
                                                                                 '".$value['mi_habitaciones']."',
                                                                                 '".$value['mi_sanitarios']."',
                                                                                 '".$value['mi_depositos']."',
                                                                                 '".$value['mi_estacionamientos']."',
                                                                                 '".$value['mi_observaciones']."',
                                                                                 '".$value['mi_precio_real']."',
                                                                                 '".$value['mi_disponible']."',
                                                                                 '".$value['mi_id_partida_comision']."',
                                                                                 '".$value['mi_porcentaje_comision']."',
                                                                                 '".$value['mi_fecha_registro']."',
                                                                                 1,
                                                                                 '".$value['mi_log_user']."',
                                                                                 '".$value['mi_codigo_imueble']."')");

                                                                                 break;
              }

        } ?>

<?php $nombre_pagina = "Contrato de venta"; ?>
<?php if(isset($_POST['precio'],
                    $_POST['estado'],
                        $_POST['id_reserva'])){ ?>
<?php /*$sql_update_inmueble = mysqli_query($conexion2, "update inmueble_rv set rv_precio_venta = '".$_POST['precio']."',
                                                                              rv_precio_reserva = '".$_POST['precio_reserva']."',
                                                                              rv_status = '".$_POST['estado']."'
                                                                              where
                                                                              id_rv_inmueble = '".$_POST['id_reserva']."'");
                            if($_POST['estado'] == 0){
                                $sql_devolver_inmueble = $conexion2 -> query("update maestro_inmuebles set mi_status = 1 where id_inmueble = '".$_POST['id_inmueble']."'");
                            }*/
                         } ?>

<?php if(isset($_POST['precio'],
                       $_POST['id_venta'])){ ?>
<?php $sql_update_inmueble = mysqli_query($conexion2, "update maestro_ventas set mv_precio_venta = '".$_POST['precio']."'
                                                                                 where
                                                                                 id_venta = '".$_POST['id_venta']."'");
                           /*if($_POST['estado'] == 5555){
                               $sql_devolver_inmueble = $conexion2 -> query("update maestro_inmuebles set mi_status = 1 where id_inmueble = '".$_POST['id_inmueble']."'");
                           }*/
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
                Ver todos los <?php echo $nombre_pagina; ?> <small>ver o editar <?php echo $nombre_pagina; ?>.</small>
            </h1>
        </div>
        <?php if(isset($sql_update_inmueble)){ ?>
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
            <h3 class="block-title">Tabla de <?php echo $nombre_pagina; ?> del sistema <small>todos los <?php echo $nombre_pagina; ?></small></h3>
        </div>
        <div class="block-content">
            <!-- DataTables init on table by adding .js-dataTable-full class, functionality initialized in js/pages/base_tables_datatables.js -->
            <table class="table table-bordered table-striped js-dataTable-full">
                <thead>
                    <tr>
                        <th class="text-center">ID</th>
                        <th>CODIGO INMUEBLE</th>
                        <th class="text-center">PROYECTO</th>
                        <th class="text-center">GRUPO</th>
                        <th class="text-center">FECHA</th>
                        <th class="text-center">CLIENTE</th>
                        <th class="hidden-xs" style="width: 15%;">MONTO VENTA</th>
                        <th class="text-center" style="width: 10%;">EDITAR</th>
                        <th class="text-center" style="width: 10%;">ELIMINAR</th>
                        <th class="text-center" style="width: 10%;">LIBERAR</th>
                        <th class="text-center" style="width: 10%;">VER CUOTAS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php //$todos_contratos_ventas = ver_contratos_ventas($conexion2); ?>
                    <?php $todos_contratos_ventas = $conexion2 -> query("select
            																													  mp.proy_nombre_proyecto,
            																												    mv.id_proyecto,
            																												    gi.gi_nombre_grupo_inmueble,
            																												    mv.id_grupo_inmueble,
            																												    mi.mi_nombre,
            																														mi.mi_codigo_imueble,
            																												    mv.id_inmueble,
            																												    mv.mv_precio_venta,
            																												    mv.mv_descripcion,
            																												    mv.mv_reserva,
            																												    mv.mv_id_reserva,
            																												    mv.mv_status,
            																												    mc.cl_nombre,
            																												    mc.cl_apellido,
            																												    mv.id_cliente,
            																														mv.id_venta,
            																														mv.fecha_venta
            																												from
            																													maestro_ventas mv inner join maestro_proyectos mp on mv.id_proyecto = mp.id_proyecto
            																																	          inner join grupo_inmuebles gi on mv.id_grupo_inmueble = gi.id_grupo_inmuebles
            																											                      inner join maestro_inmuebles mi on mv.id_inmueble = mi.id_inmueble
            																											                      inner join maestro_clientes mc on mv.id_cliente = mc.id_cliente
                                                                    where
                                                                      mp.id_proyecto not in (13)"); ?>
                    <?php while($lista_todos_contratos_ventas = mysqli_fetch_array($todos_contratos_ventas)){ ?>
                    <tr <?php if ($lista_todos_contratos_ventas['mv_status']==17) { echo "style='Background-color:#D50434; color:white;'"; } ?>>
                        <td class="text-center"><?php echo $lista_todos_contratos_ventas['id_venta']; ?></td>
                        <td class="font-w600"><?php echo $lista_todos_contratos_ventas['mi_codigo_imueble']; ?></td>
                        <td class="font-w600"><?php echo $lista_todos_contratos_ventas['proy_nombre_proyecto']; ?></td>
                        <td class="font-w600"><?php echo $lista_todos_contratos_ventas['gi_nombre_grupo_inmueble']; ?></td>
                        <td class="font-w600"><?php echo date("d-m-Y", strtotime($lista_todos_contratos_ventas['fecha_venta'])); ?></td>
                        <td class="font-w600"><?php echo $lista_todos_contratos_ventas['cl_nombre'].' '.$lista_todos_contratos_ventas['cl_apellido']; ?></td>
                        <td class="hidden-xs"><?php echo number_format($lista_todos_contratos_ventas['mv_precio_venta'], 2, '.',','); ?></td>
                        <td class="text-center">
                            <div class="btn-group">
                              <?php if($_SESSION['session_gc']['roll'] == 1 || $_SESSION['session_gc']['roll'] == 3){
                                if ($lista_todos_contratos_ventas['mv_status']==17) { }else{ ?>
                                <button class="btn btn-default" data-toggle="modal" data-target="#modal-popin<?php echo $lista_todos_contratos_ventas['id_venta']; ?>" type="button"><i class="fa fa-pencil"></i></button>
                              <?php } } ?>
                            </div>
                        </td>
                        <td class="text-center">
                          <div class="btn-group">
                            <?php if($_SESSION['session_gc']['roll'] == 1 || $_SESSION['session_gc']['roll'] == 3){
                              if ($lista_todos_contratos_ventas['mv_status']==17) { }else{ ?>
                               <button class="btn btn-default" data-toggle="modal" data-target="#modal-popina<?php echo $lista_todos_contratos_ventas['id_venta']; ?>" type="button"><i class="fa fa-trash-o"></i></button>
                            <?php } } ?>

                               <div class="modal fade" id="modal-popina<?php echo $lista_todos_contratos_ventas['id_venta']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                   <div class="modal-dialog modal-dialog-popin">
                                       <div class="modal-content">
                                           <div class="block block-themed block-transparent remove-margin-b">
                                               <div class="block-header bg-primary-dark">
                                                   <ul class="block-options">
                                                       <li>
                                                           <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                                                       </li>
                                                   </ul>
                                                   <h3 class="block-title">Eliminar el contrato de venta</h3>
                                               </div>
                                               <div class="block-content">
                                                   <span style="color:red;">
                                                   Esta seguro que desea eliminar el contrato de venta ?
                                                   Recuerde que si elimina el contrato de venta se eliminaran, todas las cuotas y sub cuotas asociadas al mismo,
                                                   tambien se eliminaran las comisiones de vendedores, regitradas a este contrato de venta.
                                                   </span>
                                                   <br>
                                                   Al eliminar el contrato de venta el inmueble quedara disponible nuevamente para su venta.
                                                   <br>
                                                   <span style="color:red;">
                                                     Recuerde que tambien de borraran todos los movimientos bancarios asociado a este contrato de venta
                                                   </span>
                                               </div>
                                           </div>
                                           <div class="modal-footer">
                                             <form class="" action="" method="post">
                                               <button class="btn btn-sm btn-default" type="button" data-dismiss="modal">Cerrar</button>
                                               <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-check"></i> Ok</button>
                                               <input type="hidden" name="eliminar" value="<?php echo $lista_todos_contratos_ventas['id_venta']; ?>">
                                               <input type="hidden" name="id_inmueble" value="<?php echo $lista_todos_contratos_ventas['id_inmueble']; ?>">
                                             </form>
                                           </div>
                                       </div>
                                   </div>
                               </div>

                          </div>
                        </td>
                        <td class="text-center">
                          <div class="btn-group">
                            <?php if($_SESSION['session_gc']['roll'] == 1 || $_SESSION['session_gc']['roll'] == 3){
                              if ($lista_todos_contratos_ventas['mv_status']==17) { }else{ ?>
                               <button class="btn btn-default" data-toggle="modal" data-target="#modal-popina_alquiler<?php echo $lista_todos_contratos_ventas['id_venta']; ?>" type="button"><i class="si si-paper-plane"></i></button>
                            <?php } } ?>

                               <div class="modal fade" id="modal-popina_alquiler<?php echo $lista_todos_contratos_ventas['id_venta']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                   <div class="modal-dialog modal-dialog-popin">
                                       <div class="modal-content">
                                           <div class="block block-themed block-transparent remove-margin-b">
                                               <div class="block-header bg-primary-dark">
                                                   <ul class="block-options">
                                                       <li>
                                                           <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                                                       </li>
                                                   </ul>
                                                   <h3 class="block-title">Liberar Inmueble</h3>
                                               </div>
                                               <div class="block-content">
                                                   <span style="color:red;">
                                                   Esta guro que quiere liberar el inmueble ?
                                                   </span>
                                               </div>
                                           </div>
                                           <div class="modal-footer">
                                             <form class="" action="" method="post">
                                               <button class="btn btn-sm btn-default" type="button" data-dismiss="modal">Cerrar</button>
                                               <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-check"></i> Ok</button>
                                               <input type="hidden" name="liberar" value="<?php echo $lista_todos_contratos_ventas['id_venta']; ?>">
                                               <input type="hidden" name="id_inmueble" value="<?php echo $lista_todos_contratos_ventas['id_inmueble']; ?>">
                                             </form>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                          </div>
                        </td>
                        <td class="text-center">
                            <div class="btn-group">
                            <?php if(contar_cuotas($conexion2, $lista_todos_contratos_ventas['id_venta']) >= 1){ ?>
                              <form action="gc_ver_documentos_contrato.php" method="post">
                                <button class="btn btn-default" type="submit"><i class="si si-eye"></i></button>
                                <input type="hidden" name="id_venta_contrato" value="<?php echo $lista_todos_contratos_ventas['id_venta']; ?>" >
                              </form>
                            <?php } ?>
                            </div>
                        </td>
                    </tr>
                    <input class="form-control" type="hidden" id="register1-username" name="id_inmueble" readonly="readonly" value="<?php echo $lista_todos_contratos_ventas['id_venta']; ?>">
                            <div class="modal fade" id="modal-popin<?php echo $lista_todos_contratos_ventas['id_venta']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
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
                                                                    <input class="form-control" type="text" id="register1-username" name="id_venta" readonly="readonly" value="<?php echo $lista_todos_contratos_ventas['id_venta']; ?>"></input>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-xs-12" for="register1-username">Reservado ?</label>
                                                                <div class="col-xs-12">
                                                                    <input class="form-control" type="text" id="register1-username" readonly="readonly" value="<?php echo $lista_todos_contratos_ventas['mv_reserva']; ?>"></input>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-xs-12" for="register1-username">Fecha de creacion del contrato</label>
                                                                <div class="col-xs-12">
                                                                     <input class="form-control" type="text" id="register1-username" name="fecha_contrato" readonly="readonly" value="<?php echo $lista_todos_contratos_ventas['fecha_venta']; ?>">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-xs-12" for="register1-username">Descripcion del contrato</label>
                                                                <div class="col-xs-12">
                                                                    <textarea class="form-control" type="text" name="observaciones"><?php echo $lista_todos_contratos_ventas['mv_descripcion']; ?></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-xs-12" for="register1-username">Precio</label>
                                                                <div class="col-xs-12">
                                                                     <input class="form-control" type="text" name="precio" placeholder="Precio" required="required" value="<?php echo $lista_todos_contratos_ventas['mv_precio_venta']; ?>"></input>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-xs-12" for="register1-username">Nombre del cliente</label>
                                                                <div class="col-xs-12">
                                                                     <input class="form-control" type="text" name="modelo" placeholder="Modelo" readonly="readonly" value="<?php echo $lista_todos_contratos_ventas['cl_nombre'].' '.$lista_todos_contratos_ventas['cl_apellido']; ?>"></input>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-xs-12" for="register1-username">Proyecto</label>
                                                                <div class="col-xs-12">
                                                                    <input class="form-control" type="text" name="area" placeholder="Area" readonly="readonly" value="<?php echo $lista_todos_contratos_ventas['proy_nombre_proyecto']; ?>"></input>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-xs-12" for="register1-username">Grupo inmueble</label>
                                                                <div class="col-xs-12">
                                                                    <input class="form-control" type="text" name="area" placeholder="Area" readonly="readonly" value="<?php echo $lista_todos_contratos_ventas['gi_nombre_grupo_inmueble']; ?>"></input>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-xs-12" for="register1-username">Inmueble</label>
                                                                <div class="col-xs-12">
                                                                    <input class="form-control" type="text" name="area" placeholder="Area" readonly="readonly" value="<?php echo $lista_todos_contratos_ventas['mi_nombre']; ?>"></input>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-md-4 control-label" >ESTADO</label>
                                                                <div class="col-md-7">
                                                                    <label class="rad-inline" for="example-inline-checkbox1">
                                                                        <input type="radio" id="example-inline-checkbox1" name="estado" value="1" <?php if($lista_todos_contratos_ventas['mv_status'] == 1){ echo 'checked';}  ?> ></input> Activa
                                                                    </label>
                                                                    <label class="rad-inline" for="example-inline-checkbox1">
                                                                        <input type="radio" id="example-inline-checkbox2" name="estado" value="0" <?php if($lista_todos_contratos_ventas['mv_status'] == 0){ echo 'checked';}  ?> ></input> Inactiva
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
