<?php if(!isset($_SESSION)){session_start();}?>
<?php require("conexion/conexion.php"); ?>
<?php require("funciones/funciones.php"); ?>
<?php if(isset($_SESSION['session_gc'])){ ?>
<?php $header_bar = 'base_header.php'; ?>
<?php $menu = true; ?>

<?php if(isset($_POST['eliminar'])){
$eliminar_servicio = $conexion2 -> query("delete from servicios where id = '".$_POST['eliminar']."'");
 } ?>

<?php $nombre_pagina = "Servicios"; ?>

<?php if(isset($_POST['id_venta_contrato'])){
               $_SESSION['id_venta_contrato']=$_POST['id_venta_contrato'];
        }elseif(isset($_GET['id_venta'])){
          $_SESSION['id_venta_contrato']=$_GET['id_venta'];
        } ?>

<?php if(isset($_POST['monto'],
                    $_POST['regService'])){ ?>
<?php $sql_insert_cuota = mysqli_query($conexion2, "INSERT INTO servicios(id_ventas,
                                                                          descripcion,
                                                                          monto,
                                                                          stat,
                                                                          date_time,
                                                                          id_user_reg
                                                                        )VALUES(
                                                                          '".$_POST['id_contrato_venta']."',
                                                                          '".$_POST['descripcion']."',
                                                                          '".$_POST['monto']."',
                                                                          1,
                                                                          '".date("Y-m-d H:i:s")."',
                                                                          '".$_SESSION['session_gc']['usua_id']."')");

}

if (isset($_POST['update'])) {
   $actualizar_servicio = $conexion2 -> query("UPDATE servicios SET monto = '".$_POST['monto']."',
                                                                    descripcion = '".$_POST['descripcion']."'
                                                                WHERE
                                                                    id = '".$_POST['update']."'");
}

?>

<?php require 'inc/config.php'; ?>
<?php require 'inc/views/template_head_start.php'; ?>
<!-- Page JS Plugins CSS -->
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/bootstrap-datepicker/bootstrap-datepicker3.min.css">
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/datatables/jquery.dataTables.min.css">
<?php require 'inc/views/template_head_end.php'; ?>
<?php require 'inc/views/base_head.php'; ?>

<!-- Page Header -->
<div class="content bg-gray-lighter">
    <div class="row items-push">

      <?php if(isset($sql_insert_cuota)){ ?>
              <!-- Success Alert -->
              <div class="alert alert-success alert-dismissable">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <h3 class="font-w300 push-15">Servicio  Registrado</h3>
                  <p><a class="alert-link" href="javascript:void(0)">El Servicio</a> Fue Registrado!</p>
              </div>
              <!-- END Success Alert -->
      <?php } ?>
      <?php if(isset($eliminar_servicio)){ ?>
      <div class="alert alert-danger alert-dismissable">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <h3 class="font-w300 push-15">Servicio  Eliminado</h3>
          <p><a class="alert-link" href="javascript:void(0)">El Servicio</a> Fue Eliminado!</p>
      </div>
      <?php } ?>
      <?php if(isset($actualizar_servicio)){ ?>
              <!-- Success Alert -->
              <div class="alert alert-success alert-dismissable">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <h3 class="font-w300 push-15">Servicio  Actualizado</h3>
                  <p><a class="alert-link" href="javascript:void(0)">El Servicio</a> Fue Actualizado!</p>
              </div>
              <!-- END Success Alert -->
      <?php } ?>

        <div class="col-sm-7">
            <h1 class="page-heading">
                Ver todos los <?php echo $nombre_pagina; ?> por contrato de alquiler <small>ver o editar <?php echo $nombre_pagina; ?>.</small>
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
            <h3 class="block-title">Tabla de <?php echo $nombre_pagina; ?> por contrato de alquileres del sistema <small>todos los <?php echo $nombre_pagina; ?> por contrato de Alquiler</small></h3>
        </div>
        <div class="block-content">
            <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-popinReg" type="submit" name="registrar_cliente">Agregar Pago Servicio</button>


            <div class="modal fade" id="modal-popinReg" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-popin">
                    <div class="modal-content">
                        <form action="" method="post" enctype="multipart/form-data">
                          <input type="hidden" name="id_contrato_venta" value="<?php echo $_SESSION['id_venta_contrato']; ?>">
                            <div class="block block-themed block-transparent remove-margin-b">
                                <div class="block-header bg-primary-dark">
                                    <ul class="block-options">
                                        <li>
                                            <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                                        </li>
                                    </ul>
                                    <h3 class="block-title">Registrar Servicio</h3>
                                </div>
                                <div class="block-content">
                                    <!-- Bootstrap Register -->
                                    <div class="block block-themed">
                                        <div class="block-content">
                                            <div class="form-group">
                                                <label class="col-xs-12" for="register1-username">Monto </label>
                                                <div class="col-xs-12">
                                                    <input class="form-control" type="text" autocomplete="off" name="monto" placeholder="Precio" required="required" value=""></input>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-xs-12" for="register1-username">Descripcion</label>
                                                <div class="col-xs-12">
                                                    <textarea class="form-control" name="descripcion" placeholder="Descripcion"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-xs-12" for="register1-username"></label>
                                                <div class="col-xs-12">
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button class="btn btn-sm btn-default" type="button" data-dismiss="modal">Cancelar</button>
                                                <button class="btn btn-sm btn-primary" name="regService" type="submit" >Registrar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

          <a class="btn btn-sm btn-primary" style="float:left; padding-left: 10px;" href="gc_ver_contratos_alquileres.php?id_contrato=<?php echo $_SESSION['id_venta_contrato']; ?>">Vorver a Contratos</a>

            <!-- DataTables init on table by adding .js-dataTable-full class, functionality initialized in js/pages/base_tables_datatables.js -->
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th class="text-center">ID</th>
                        <th class="text-center">CLIENTE</th>
                        <th class="text-center">SLIP</th>
                        <th class="hidden-xs" >FECHA PAGO</th>
                        <th class="hidden-xs" >DESCRIPCION</th>
                        <th class="hidden-xs" >MONTO PAGADO</th>
                        <th class="text-center" >EDITAR</th>
                        <th class="text-center" >ELIMINAR</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $total_monto = 0; ?>
                    <?php $total_cuotas = 0; ?>
                    <?php $todos_contratos_ventas = $conexion2 -> query("SELECT
                                                                          s.id,
                                                                          mv.id_venta,
                                                                          mc.cl_nombre,
                                                                          mc.cl_apellido,
                                                                          mi.mi_nombre,
                                                                          s.date_time,
                                                                          s.descripcion,
                                                                          s.monto
                                                                          FROM servicios s inner join maestro_ventas mv on s.id_ventas = mv.id_venta
                                                                          				         inner join maestro_inmuebles mi on mv.id_inmueble = mi.id_inmueble
                                                                                           inner join maestro_clientes mc on mv.id_cliente = mc.id_cliente
                                                                          where s.stat = 1 and s.id_ventas ='".$_SESSION['id_venta_contrato']."'"); ?>
                    <?php while($lista_todos_contratos_ventas = $todos_contratos_ventas -> fetch_array()){ ?>
                    <tr>
                        <td class="text-center"><?php echo $lista_todos_contratos_ventas['id']; ?></td>
                        <td class="font-w600"><?php echo $lista_todos_contratos_ventas['cl_nombre'].' '.$lista_todos_contratos_ventas['cl_apellido']; ?></td>
                        <td class="text-center"><?php echo $lista_todos_contratos_ventas['mi_nombre']; ?></td>
                        <td class="font-w600"><?php echo date("d-m-Y", strtotime($lista_todos_contratos_ventas['date_time'])); ?></td>
                        <td class="hidden-xs"><?php echo $lista_todos_contratos_ventas['descripcion']; ?></td>
                        <td class="hidden-xs"><?php echo number_format($lista_todos_contratos_ventas['monto'], 2, '.',','); ?></td>

                        <td class="text-center">
                            <div class="btn-group">
                              <?php if($_SESSION['session_gc']['roll'] == 1 || $_SESSION['session_gc']['roll'] == 3){ ?>
                                <button class="btn btn-default" data-toggle="modal" data-target="#modal-popin<?php echo $lista_todos_contratos_ventas['id']; ?>" type="button"><i class="fa fa-pencil"></i></button>
                              <?php } ?>
                            </div>
                        </td>
                        <td class="text-center">
                          <div class="btn-group">
                            <?php if($_SESSION['session_gc']['roll'] == 1 || $_SESSION['session_gc']['roll'] == 3){ ?>
                              <button class="btn btn-default" data-toggle="modal" data-target="#modal-popina<?php echo $lista_todos_contratos_ventas['id']; ?>" type="submit"><i class="fa fa-trash-o"></i></button>
                            <?php } ?>
                              <div class="modal fade" id="modal-popina<?php echo $lista_todos_contratos_ventas['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                  <div class="modal-dialog modal-dialog-popin">
                                      <div class="modal-content">
                                          <div class="block block-themed block-transparent remove-margin-b">
                                              <div class="block-header bg-primary-dark">
                                                  <ul class="block-options">
                                                      <li>
                                                          <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                                                      </li>
                                                  </ul>
                                                  <h3 class="block-title">Eliminar la cuota de Servicio</h3>
                                              </div>
                                              <div class="block-content">
                                                  <div style="color:red;">Esta seguro que desea eliminar la cuota de Servicio? <br>

                                              </div>
                                          </div>
                                          <div class="modal-footer">
                                            <form class="" action="" method="post">
                                              <button class="btn btn-sm btn-default" type="button" data-dismiss="modal">Cerrar</button>
                                              <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-check"></i> Ok</button>
                                              <input type="hidden" name="eliminar" value="<?php echo $lista_todos_contratos_ventas['id']; ?>">
                                            </form>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                        </td>
                    </tr>

                    <input class="form-control" type="hidden" id="register1-username" name="id_cuota" readonly="readonly" value="<?php echo $lista_todos_contratos_ventas['id']; ?>">

                            <div class="modal fade" id="modal-popin<?php echo $lista_todos_contratos_ventas['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
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
                                                              <label class="col-xs-12" for="register1-username">Monto </label>
                                                              <div class="col-xs-12">
                                                                  <input class="form-control" autocomplete="off" type="text" name="monto" placeholder="Precio" required="required" value="<?php echo number_format($lista_todos_contratos_ventas['monto'], 2, '.',','); ?>"></input>
                                                              </div>
                                                          </div>
                                                          <div class="form-group">
                                                              <label class="col-xs-12" for="register1-username">Descripcion</label>
                                                              <div class="col-xs-12">
                                                                  <textarea class="form-control" name="descripcion" placeholder="Descripcion"><?php echo $lista_todos_contratos_ventas['descripcion']; ?></textarea>
                                                              </div>
                                                          </div>
                                                            <div class="modal-footer">
                                                                <button class="btn btn-sm btn-default" type="button" data-dismiss="modal">Cancelar</button>
                                                                <button class="btn btn-sm btn-primary" type="submit" name="updateServ">Guardar cambios</button>
                                                                <input type="hidden" name="update" value="<?php echo $lista_todos_contratos_ventas['id']; ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php $total_cuotas++;
                              $total_monto +=$lista_todos_contratos_ventas['monto'];
                      } ?>
                        <tr>
                          <td class="text-center font-w600" colspan="3">Total Numero de cuotas: <?php echo $total_cuotas; ?></td>
                          <td class="text-center font-w600" colspan="3">Total Monto Pagado: <?php echo number_format($total_monto, 2, '.',','); ?> </td>
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
