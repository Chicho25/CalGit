<?php if(!isset($_SESSION)){session_start();}?>
<?php require("conexion/conexion.php"); ?>
<?php require("funciones/funciones.php"); ?>
<?php if(isset($_SESSION['session_gc'])){ ?>
<?php $header_bar = 'base_header.php'; ?>
<?php $menu = true; ?>
<?php /* ################ AUDITORIA DE SEGUIMIENTO ############## */ ?>
<?php require("funciones/funciones_auditorias.php"); ?>
<?php $lugar_mapa = 13; ?>
<?php $dispositivo_acceso = obtener_dispositivo(); ?>
<?php insertar_log_seguimiento($conexion2, ObtenerIP(), $dispositivo_acceso, $lugar_mapa, $_SESSION['session_gc']['usua_id']); ?>
<?php /* ######################################################## */ ?>
<?php if(isset($_POST['id_chequeras'],
                    $_POST['nombre_banco'],
                        $_POST['numero_cuenta'],
                            $_POST['chequera_inicial'],
                                $_POST['chequera_final'],
                            $_POST['ultimo_cheque_emitido'])){ ?>
<?php $sql_update_chequeras = mysqli_query($conexion2, "update chequeras set chq_estado_chequera = '".strtoupper($_POST['estado'])."',
                                                                             chq_chequera_inicial = '".strtoupper($_POST['chequera_inicial'])."',
                                                                             chq_chequera_final = '".strtoupper($_POST['chequera_final'])."',
                                                                             chq_ultimo_emitido = '".strtoupper($_POST['ultimo_cheque_emitido'])."' where id_chequeras = '".$_POST['id_chequeras']."'"); } ?>

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
                Ver todas las chequeras <small>ver o editar chequeras.</small>

            </h1>
        </div>
                    <?php if(isset($sql_update_chequeras)){ ?>
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
            <h3 class="block-title">Tabla de Chequeras del sistema <small>todos los usuarios</small></h3>
        </div>
        <div class="block-content">
            <!-- DataTables init on table by adding .js-dataTable-full class, functionality initialized in js/pages/base_tables_datatables.js -->
            <table class="table table-bordered table-striped js-dataTable-full">
                <thead>
                    <tr>
                        <th class="text-center">ID</th>
                        <th>EMPRESA</th>
                        <th>PROYECTO</th>
                        <th>BANCO</th>
                        <th class="hidden-xs">CUENTA</th>
                        <th class="hidden-xs" style="width: 15%;">ESTATUS</th>
                        <th class="text-center" style="width: 10%;">EDITAR</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $todas_chequeras = todas_chequeras($conexion2); ?>
                    <?php while($lista_todas_chequeras = mysqli_fetch_array($todas_chequeras)){ ?>
                    <tr>
                        <td class="text-center"><?php echo $lista_todas_chequeras['id_chequeras']; ?></td>
                        <td class="text-center"><?php echo $lista_todas_chequeras['empre_nombre_comercial']; ?></td>
                        <td class="font-w600"><?php echo $lista_todas_chequeras['proy_nombre_proyecto']; ?></td>
                        <td class="font-w600"><?php echo $lista_todas_chequeras['banc_nombre_banco']; ?></td>
                        <td class="hidden-xs"><?php echo $lista_todas_chequeras['cta_numero_cuenta']; ?></td>
                        <td class="hidden-xs"><?php echo $lista_todas_chequeras['estado']; ?></td>
                        <td class="text-center">
                            <div class="btn-group">
                                <button class="btn btn-default" data-toggle="modal" data-target="#modal-popin<?php echo $lista_todas_chequeras['id_chequeras']; ?>" type="button"><i class="fa fa-pencil"></i></button>
                            </div>
                        </td>
                    </tr>

                            <div class="modal fade" id="modal-popin<?php echo  $lista_todas_chequeras['id_chequeras']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
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
                                                                                    <input class="form-control" type="text" id="register1-username" name="id_chequeras" readonly="readonly" value="<?php echo $lista_todas_chequeras['id_chequeras']; ?>">
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="col-xs-12" for="register1-username">BANCO</label>
                                                                                <div class="col-xs-12">

                                                                                    <input class="form-control" type="text" id="register1-email" name="nombre_banco" readonly="readonly" value="<?php echo $lista_todas_chequeras['banc_nombre_banco']; ?>">

                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="col-xs-12" for="register1-email">NUMERO DE CUENTA</label>
                                                                                <div class="col-xs-12">

                                                                                    <input class="form-control" type="text" id="register1-email" name="numero_cuenta" readonly="readonly" value="<?php echo $lista_todas_chequeras['cta_numero_cuenta']; ?>">

                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="col-xs-12" for="register1-email">CHEQUERA INICIAL</label>
                                                                                <div class="col-xs-12">
                                                                                    <input class="form-control" type="text" id="register1-email" name="chequera_inicial" value="<?php echo $lista_todas_chequeras['chq_chequera_inicial']; ?>">
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="col-xs-12" for="register1-email">CHEQUERA FINAL</label>
                                                                                <div class="col-xs-12">
                                                                                    <input class="form-control" type="text" id="register1-email" name="chequera_final" value="<?php echo $lista_todas_chequeras['chq_chequera_final']; ?>">
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="col-xs-12" for="register1-email">ULTIMO CHEQUE EMITIDO</label>
                                                                                <div class="col-xs-12">
                                                                                    <input class="form-control" type="text" id="register1-email" name="ultimo_cheque_emitido" value="<?php echo $lista_todas_chequeras['chq_ultimo_emitido']; ?>">
                                                                                </div>
                                                                            </div>

                                                                            <div class="form-group">
                                                                                <label class="col-xs-12" for="register1-email" >ESTATUS DE LA CHEQUERA</label>
                                                                                <div class="col-xs-12">
                                                                                    <label class="rad-inline" for="example-inline-checkbox1">
                                                                                        <input type="radio" id="example-inline-checkbox1" name="estado" value="1" <?php if($lista_todas_chequeras['chq_estado_chequera'] == 1){ echo 'checked';}  ?> > Activa
                                                                                    </label>
                                                                                    <label class="rad-inline" for="example-inline-checkbox1">
                                                                                        <input type="radio" id="example-inline-checkbox2" name="estado" value="0" <?php if($lista_todas_chequeras['chq_estado_chequera'] == 0){ echo 'checked';}  ?> > Inactiva
                                                                                    </label>
                                                                                </div>
                                                                            </div>

                                                                            <div class="form-group">
                                                                                <label class="col-md-4 control-label" ></label>
                                                                                <div class="col-md-7">
                                                                                    <label class="rad-inline" for="example-inline-checkbox1"></label>
                                                                                    <label class="rad-inline" for="example-inline-checkbox1"></label>
                                                                                </div>
                                                                            </div>

                                                                    </div>

                                                                    <div class="modal-footer">
                                                                        <button class="btn btn-sm btn-default" type="button" data-dismiss="modal">Cancelar</button>
                                                                        <button class="btn btn-sm btn-primary" type="submit" >Guardar cambios</button>
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
