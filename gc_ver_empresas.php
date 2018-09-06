<?php if(!isset($_SESSION)){session_start();}?>
<?php require("conexion/conexion.php"); ?>
<?php require("funciones/funciones.php"); ?>
<?php if(isset($_SESSION['session_gc'])){ ?>
<?php $header_bar = 'base_header.php'; ?>
<?php $menu = true; ?>
<?php /* ################ AUDITORIA DE SEGUIMIENTO ############## */ ?>
<?php require("funciones/funciones_auditorias.php"); ?>
<?php $lugar_mapa = 5; ?>
<?php $dispositivo_acceso = obtener_dispositivo(); ?>
<?php insertar_log_seguimiento($conexion2, ObtenerIP(), $dispositivo_acceso, $lugar_mapa, $_SESSION['session_gc']['usua_id']); ?>
<?php /* ######################################################## */ ?>
<?php if(isset($_POST['nombre_comercial'], $_POST['razon_social'], 
                                                $_POST['ruc'], 
                                                    $_POST['dv'], 
                                                        $_POST['estado_empresa'], 
                                                            $_POST['empresa_principal'], 
                                                        $_POST['excenta_itbms'], 
                                                    $_POST['email'], 
                                                $_POST['telefono'])){ ?>
<?php $sql_update_empresa = mysqli_query($conexion2, "update maestro_empresa set empre_nombre_comercial = '".strtoupper($_POST['nombre_comercial'])."', 
                                                                                 empre_razon_social = '".strtoupper($_POST['razon_social'])."', 
                                                                                 empre_ruc = '".strtoupper($_POST['ruc'])."', 
                                                                                 empre_dv = '".strtoupper($_POST['dv'])."',
                                                                                 empre_estado_empresa = '".strtoupper($_POST['estado_empresa'])."', 
                                                                                 empre_empresa_principal = '".strtoupper($_POST['empresa_principal'])."',
                                                                                 empre_excenta_itbms = '".strtoupper($_POST['excenta_itbms'])."',
                                                                                 empre_email = '".strtoupper($_POST['email'])."',
                                                                                 empre_telefono = '".strtoupper($_POST['telefono'])."' where id_empresa = '".$_POST['id_empresa']."'");  

############################# Auditoria ##############################
                      

                                            $tipo_operacion = 2; 
                                            $comentario = "Actualizacion de empresa";

                                            $sql_insertar_auditoria = $conexion2 -> query("insert into auditoria_empresa(aue_tipo_operacion, 
                                                                                                                         aue_usua_log, 
                                                                                                                         aue_comentario, 
                                                                                                                         aue_id_empresa, 
                                                                                                                         aue_empre_nombre_comercial, 
                                                                                                                         aue_empre_razon_social, 
                                                                                                                         aue_empre_ruc, 
                                                                                                                         aue_empre_dv, 
                                                                                                                         aue_empre_estado_empresa, 
                                                                                                                         aue_empre_empresa_principal, 
                                                                                                                         aue_empre_excenta_itbms, 
                                                                                                                         aue_empre_email, 
                                                                                                                         aue_empre_telefono
                                                                                                                         )values(
                                                                                                                         '".$tipo_operacion."',
                                                                                                                         '".$_SESSION['session_gc']['usua_id']."', 
                                                                                                                         '".$comentario."', 
                                                                                                                         '".$_POST['id_empresa']."', 
                                                                                                                         '".$_POST['nombre_comercial']."', 
                                                                                                                         '".$_POST['razon_social']."',
                                                                                                                         '".$_POST['ruc']."', 
                                                                                                                         '".$_POST['dv']."',
                                                                                                                         '".$_POST['estado_empresa']."', 
                                                                                                                         '".$_POST['empresa_principal']."', 
                                                                                                                         '".$_POST['excenta_itbms']."', 
                                                                                                                         '".$_POST['email']."', 
                                                                                                                         '".$_POST['telefono']."')");}
###################################################################### ?>

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
                Ver todos las empresas <small>ver o editar empresas.</small>

            </h1>
        </div>
                    <?php if(isset($sql_update_empresa)){ ?>
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
            <h3 class="block-title">Tabla de empresas del sistema <small>todas los empresas</small></h3>
        </div>
        <div class="block-content">
            <!-- DataTables init on table by adding .js-dataTable-full class, functionality initialized in js/pages/base_tables_datatables.js -->
            <table class="table table-bordered table-striped js-dataTable-full">
                <thead>
                    <tr>
                        <th class="text-center">ID</th>
                        <th>NOMBRE COMERCIAL</th>
                        <th class="hidden-xs">RAZON SOCIAL</th>
                        <th class="hidden-xs" style="width: 15%;">ESTATUS</th>
                        <th class="text-center" style="width: 10%;">EDITAR</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $todas_empresas = todas_empresas($conexion2); ?>
                    <?php while($lista_todas_empresas = mysqli_fetch_array($todas_empresas)){ ?>
                    <tr>
                        <td class="text-center"><?php echo $lista_todas_empresas['id_empresa']; ?></td>
                        <td class="font-w600"><?php echo $lista_todas_empresas['empre_nombre_comercial']; ?></td>
                        <td class="hidden-xs"><?php echo $lista_todas_empresas['empre_razon_social']; ?></td>
                        <td class="hidden-xs"><?php echo $lista_todas_empresas['estado']; ?></td>
                        <td class="text-center">
                            <div class="btn-group">
                                <button class="btn btn-default" data-toggle="modal" data-target="#modal-popin<?php echo $lista_todas_empresas['id_empresa']; ?>" type="button"><i class="fa fa-pencil"></i></button>
                            </div>
                        </td>
                    </tr>
                            
                            <div class="modal fade" id="modal-popin<?php echo $lista_todas_empresas['id_empresa']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
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
                                                                                    <input class="form-control" type="text" id="register1-username" name="id_empresa" readonly="readonly" value="<?php echo $lista_todas_empresas['id_empresa']; ?>">
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="col-xs-12" for="register1-username">NOMBRE COMERCIAL</label>
                                                                                <div class="col-xs-12">
                                                                                    <input class="form-control" type="text" id="register1-username" name="nombre_comercial" value="<?php echo $lista_todas_empresas['empre_nombre_comercial']; ?>">
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="col-xs-12" for="register1-email">RAZON SOCIAL</label>
                                                                                <div class="col-xs-12">
                                                                                    <input class="form-control" type="text" id="register1-email" name="razon_social" value="<?php echo $lista_todas_empresas['empre_razon_social']; ?>">
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="col-xs-12" for="register1-email">RUC</label>
                                                                                <div class="col-xs-12">
                                                                                    <input class="form-control" type="text" id="register1-email" name="ruc" value="<?php echo $lista_todas_empresas['empre_ruc']; ?>">
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="col-xs-12" >DV</label>
                                                                                <div class="col-xs-12">
                                                                                    <input class="form-control" type="text" id="register1-email" name="dv" value="<?php echo $lista_todas_empresas['empre_dv']; ?>">
                                                                                </div>
                                                                            </div>

                                                                            <div class="form-group">
                                                                                <label class="col-xs-12" for="register1-email">EMAIL</label>
                                                                                <div class="col-xs-12">
                                                                                    <input class="form-control" type="email" name="email" value="<?php echo $lista_todas_empresas['empre_email']; ?>">
                                                                                </div>    
                                                                            </div>

                                                                            <div class="form-group">
                                                                                <label class="col-xs-12" for="register1-email">TELEFONO</label>
                                                                                <div class="col-xs-12">
                                                                                    <input class="form-control" type="text" name="telefono" value="<?php echo $lista_todas_empresas['empre_telefono']; ?>" />
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
                                                                                    <label class="col-md-4 control-label" >Estado de empresa</label>
                                                                                    <div class="col-md-7">
                                                                                        <label class="rad-inline" for="example-inline-checkbox1">
                                                                                            <input type="radio" id="example-inline-checkbox1" name="estado_empresa" value="1" <?php if($lista_todas_empresas['empre_estado_empresa'] == 1){ echo 'checked';}  ?> > Activa
                                                                                        </label>
                                                                                        <label class="rad-inline" for="example-inline-checkbox1">
                                                                                            <input type="radio" id="example-inline-checkbox2" name="estado_empresa" value="0" <?php if($lista_todas_empresas['empre_estado_empresa'] == 0){ echo 'checked';}  ?> > Inactiva
                                                                                        </label>
                                                                                        
                                                                                    </div>
                                                                                </div>

                                                                                <div class="form-group">
                                                                                    <label class="col-md-4 control-label" >Empresa princpal ?</label>
                                                                                    <div class="col-md-7">
                                                                                        <label class="rad-inline" for="example-inline-checkbox1">
                                                                                            <input type="radio" id="example-inline-checkbox1" name="empresa_principal" value="1" <?php if($lista_todas_empresas['empre_empresa_principal'] == 1){ echo 'checked';}  ?> > Si
                                                                                        </label>
                                                                                        <label class="rad-inline" for="example-inline-checkbox1">
                                                                                            <input type="radio" id="example-inline-checkbox2" name="empresa_principal" value="0"<?php if($lista_todas_empresas['empre_empresa_principal'] == 0){ echo 'checked';}  ?> > No
                                                                                        </label>
                                                                                        
                                                                                    </div>
                                                                                </div>

                                                                                <div class="form-group">
                                                                                    <label class="col-md-4 control-label" >Excenta ITBMS ?</label>
                                                                                    <div class="col-md-7">
                                                                                        <label class="rad-inline" for="example-inline-checkbox1">
                                                                                            <input type="radio" id="example-inline-checkbox1" name="excenta_itbms" value="1" <?php if($lista_todas_empresas['empre_excenta_itbms'] == 1){ echo 'checked';}  ?> > Si
                                                                                        </label>
                                                                                        <label class="rad-inline" for="example-inline-checkbox1">
                                                                                            <input type="radio" id="example-inline-checkbox2" name="excenta_itbms" value="0" <?php if($lista_todas_empresas['empre_excenta_itbms'] == 0){ echo 'checked';}  ?> > No
                                                                                        </label>
                                                                                        
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