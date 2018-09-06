<?php if(!isset($_SESSION)){session_start();}?>
<?php require("conexion/conexion.php"); ?>
<?php require("funciones/funciones.php"); ?>
<?php if(isset($_SESSION['session_gc'])){ ?>
<?php $header_bar = 'base_header.php'; ?>
<?php $menu = true; ?>
<?php /* ################ AUDITORIA DE SEGUIMIENTO ############## */ ?>
<?php require("funciones/funciones_auditorias.php"); ?>
<?php $lugar_mapa = 11; ?>
<?php $dispositivo_acceso = obtener_dispositivo(); ?>
<?php insertar_log_seguimiento($conexion2, ObtenerIP(), $dispositivo_acceso, $lugar_mapa, $_SESSION['session_gc']['usua_id']); ?>
<?php /* ######################################################## */ ?>
<?php if(isset($_POST['id_cuenta'],
                    $_POST['id_empresa'],
                        $_POST['id_banco'],
                            $_POST['numero_cuenta'],
                                $_POST['tipo_cuenta'],
                                   $_POST['predeterminada'],
                            $_POST['estado'])){ ?>
<?php $sql_update_cuenta = mysqli_query($conexion2, "update cuentas_bancarias set cta_estado = '".$_POST['estado']."',
                                                                                  cta_id_banco = '".$_POST['id_banco']."',
                                                                                  cta_id_empresa = '".$_POST['id_empresa']."',
                                                                                  cta_numero_cuenta = '".$_POST['numero_cuenta']."',
                                                                                  cta_predeterminada = '".$_POST['predeterminada']."',
                                                                                  cta_tipo_cuenta = '".$_POST['tipo_cuenta']."' where id_cuenta_bancaria = '".$_POST['id_cuenta']."'");
/* Aunditoria */
$tipo_operacion = 2;
$comentario = "Modificacion de Cuenta bancaria";
$sql_insertar_auditoria = $conexion2 -> query("INSERT INTO auditoria_cuenta_bancaria(aucb_tipo_operacion,
                                                                                     aucb_usua_log,
                                                                                     aucb_comentarios,
                                                                                     aucb_cta_id_banco,
                                                                                     aucb_cta_numero_cuenta,
                                                                                     aucb_cta_estado,
                                                                                     aucb_cta_predeterminada,
                                                                                     aucb_cta_tipo_cuenta,
                                                                                     aucb_cta_id_empresa
                                                                                    )VALUES(
                                                                                     '".$tipo_operacion."',
                                                                                     '".$_SESSION['session_gc']['usua_id']."',
                                                                                     '".$comentario."',
                                                                                     '".$_POST['id_banco']."',
                                                                                     '".$_POST['numero_cuenta']."',
                                                                                     '".$_POST['estado']."',
                                                                                     '".$_POST['predeterminada']."',
                                                                                     '".$_POST['tipo_cuenta']."',
                                                                                     '".$_POST['id_empresa']."')");} ?>

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
                Ver todos las cuentas <small>ver o editar cuentas.</small>

            </h1>
        </div>
                    <?php if(isset($sql_update_cuenta)){ ?>
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
            <h3 class="block-title">Cuentas Bancarias</h3>
        </div>
        <div class="block-content">
            <!-- DataTables init on table by adding .js-dataTable-full class, functionality initialized in js/pages/base_tables_datatables.js -->
            <table class="table table-bordered table-striped js-dataTable-full">
                <thead>
                    <tr>
                        <th class="text-center">ID</th>
                        <th>NOMBRE DE LA EMPRESA</th>
                        <th class="hidden-xs">NOMBRE DEL BANCO</th>
                        <th class="hidden-xs" style="width: 15%;">NUMERO DE CUENTA</th>
                        <th class="text-center" style="width: 10%;">EDITAR</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $todas_cuentas = todas_cuentas($conexion2); ?>
                    <?php while($lista_todas_cuentas = mysqli_fetch_array($todas_cuentas)){ ?>
                    <tr>
                        <td class="text-center"><?php echo $lista_todas_cuentas['id_cuenta_bancaria']; ?></td>
                        <td class="font-w600"><?php echo $lista_todas_cuentas['empre_nombre_comercial']; ?></td>
                        <td class="hidden-xs"><?php echo $lista_todas_cuentas['banc_nombre_banco']; ?></td>
                        <td class="hidden-xs"><?php echo $lista_todas_cuentas['cta_numero_cuenta']; ?></td>
                        <td class="text-center">
                            <div class="btn-group">
                                <button class="btn btn-default" data-toggle="modal" data-target="#modal-popin<?php echo $lista_todas_cuentas['id_cuenta_bancaria']; ?>" type="button"><i class="fa fa-pencil"></i></button>
                            </div>
                        </td>
                    </tr>

                            <div class="modal fade" id="modal-popin<?php echo  $lista_todas_cuentas['id_cuenta_bancaria']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
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
                                                                                    <input class="form-control" type="text" id="register1-username" name="id_cuenta" readonly="readonly" value="<?php echo $lista_todas_cuentas['id_cuenta_bancaria']; ?>">
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="col-xs-12" for="register1-username">NOMBRE DE LA EMPRESA</label>
                                                                                <div class="col-xs-12">

                                                                                    <select class="js-select2 form-control" id="val-select2" name="id_empresa" style="width: 100%;" data-placeholder="Seleccionar empresa" required="required">
                                                                                        <option></option>
                                                                                        <?php   $sql_empresas = todas_empresas_activas($conexion2); ?>
                                                                                        <?php   while($lista_empresas = mysqli_fetch_array($sql_empresas)){ ?>
                                                                                        <option value="<?php echo $lista_empresas['id_empresa']; ?>"
                                                                                                       <?php if($lista_todas_cuentas['cta_id_empresa'] == $lista_empresas['id_empresa']){ echo 'selected'; } ?>
                                                                                         ><?php echo $lista_empresas['empre_nombre_comercial']; ?></option>
                                                                                        <?php } ?>
                                                                                    </select>

                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="col-xs-12" for="register1-email">NOMBRE DEL BANCO</label>
                                                                                <div class="col-xs-12">

                                                                                    <select class="js-select2 form-control" id="val-select2" name="id_banco" style="width: 100%;" data-placeholder="Seleccionar empresa" required="required">
                                                                                        <option></option>
                                                                                        <?php   $sql_bancos = todos_bancos_activos($conexion2); ?>
                                                                                        <?php   while($lista_bancos = mysqli_fetch_array($sql_bancos)){ ?>
                                                                                        <option value="<?php echo $lista_bancos['id_bancos']; ?>"
                                                                                                       <?php if($lista_todas_cuentas['cta_id_banco'] == $lista_bancos['id_bancos']){ echo 'selected'; } ?>
                                                                                         ><?php echo $lista_bancos['banc_nombre_banco']; ?></option>
                                                                                        <?php } ?>
                                                                                    </select>

                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="col-xs-12" for="register1-email">NUMERO DE CUENTA</label>
                                                                                <div class="col-xs-12">
                                                                                    <input class="form-control" type="text" id="register1-email" name="numero_cuenta" value="<?php echo $lista_todas_cuentas['cta_numero_cuenta']; ?>">
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="col-xs-12" >TIPO DE CUENTA</label>
                                                                                <div class="col-xs-12">


                                                                                    <select class="js-select2 form-control" id="val-select2" name="tipo_cuenta" style="width: 100%;" data-placeholder="Seleccionar empresa" required="required">
                                                                                        <option></option>
                                                                                        <?php   $sql_tipo_cuenta = tipo_cuenta($conexion2); ?>
                                                                                        <?php   while($lista_tipo_cuenta = mysqli_fetch_array($sql_tipo_cuenta)){ ?>
                                                                                        <option value="<?php echo $lista_tipo_cuenta['id_tipo_cuenta']; ?>"
                                                                                                       <?php if($lista_todas_cuentas['cta_tipo_cuenta'] == $lista_tipo_cuenta['id_tipo_cuenta']){ echo 'selected'; } ?>
                                                                                         ><?php echo $lista_tipo_cuenta['tdc_nombre']; ?></option>
                                                                                        <?php } ?>
                                                                                    </select>


                                                                                </div>
                                                                            </div>

                                                                            <div class="form-group">
                                                                                <label class="col-xs-12" for="register1-email">PREDETERMINADA ?</label>
                                                                                <div class="col-xs-12">
                                                                                    <label class="rad-inline" for="example-inline-checkbox1">
                                                                                        <input type="radio" id="example-inline-checkbox1" name="predeterminada" value="1" <?php if($lista_todas_cuentas['cta_predeterminada'] == 1){ echo 'checked';}  ?> > Si
                                                                                    </label>
                                                                                    <label class="rad-inline" for="example-inline-checkbox1">
                                                                                        <input type="radio" id="example-inline-checkbox2" name="predeterminada" value="0" <?php if($lista_todas_cuentas['cta_predeterminada'] == 0){ echo 'checked';}  ?> > No
                                                                                    </label>
                                                                                </div>
                                                                            </div>

                                                                            <div class="form-group">
                                                                                <label class="col-xs-12" for="register1-email" >Estado DE LA CUENTA</label>
                                                                                <div class="col-xs-12">
                                                                                    <label class="rad-inline" for="example-inline-checkbox1">
                                                                                        <input type="radio" id="example-inline-checkbox1" name="estado" value="1" <?php if($lista_todas_cuentas['cta_estado'] == 1){ echo 'checked';}  ?> > Activa
                                                                                    </label>
                                                                                    <label class="rad-inline" for="example-inline-checkbox1">
                                                                                        <input type="radio" id="example-inline-checkbox2" name="estado" value="0" <?php if($lista_todas_cuentas['cta_estado'] == 0){ echo 'checked';}  ?> > Inactiva
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
