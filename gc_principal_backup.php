<?php if(!isset($_SESSION)){session_start();}?>
<?php require("conexion/conexion.php"); ?>
<?php require("funciones/funciones.php"); ?>
<?php require("funciones/clases.php"); ?>
<?php if(isset($_SESSION['session_gc'])){ ?>
<?php ############## Destruir variables de session ############## ?>
<?php if(isset($_SESSION['session_empresa'])){
          unset($_SESSION['session_empresa']);}
          elseif(isset($_SESSION['session_proyecto'])){
          unset($_SESSION['session_proyecto']);}
          elseif(isset($_SESSION['session_bancos'])){
          unset($_SESSION['session_bancos']);}
          elseif(isset($_SESSION['session_cta'])){
          unset($_SESSION['session_cta']);}
          elseif(isset($_SESSION['session_chq'])){
          unset($_SESSION['session_chq']);}
          elseif(isset($_SESSION['session_mb'])){
          unset($_SESSION['session_mb']);}
          elseif(isset($_SESSION['session_ch'])){
          unset($_SESSION['session_ch']);}
          elseif(isset($_SESSION['session_ven'])){
          unset($_SESSION['session_ven']);}
          elseif(isset($_SESSION['session_cl'])){
          unset($_SESSION['session_cl']);}
          elseif(isset($_SESSION['session_mi'])){
          unset($_SESSION['session_mi']);}
          elseif(isset($_SESSION['session_grupo_inmueble'])){
          unset($_SESSION['session_grupo_inmueble']);}
          elseif(isset($_SESSION['session_inmueble'])){
          unset($_SESSION['session_inmueble']);}
          elseif(isset($_SESSION['reserva'])){
          unset($_SESSION['reserva']);}
          elseif(isset($_SESSION['session_ventas_reserva'])){
          unset($_SESSION['session_ventas_reserva']);}
          elseif(isset($_SESSION['session_ventas'])){
          unset($_SESSION['session_ventas']);}
          elseif(isset($_SESSION['session_contrato'])){
          unset($_SESSION['session_contrato']);}
          elseif(isset($_SESSION['session_documentos'])){
          unset($_SESSION['session_documentos']);}
          elseif(isset($_SESSION['session_pro'])){
          unset($_SESSION['session_pro']);}
          elseif(isset($_SESSION['partida_documento'])){
          unset($_SESSION['partida_documento']);}  ?>
<?php ########################################################### ?>
<?php $header_bar = 'base_header.php'; ?>
<?php $menu = true; ?>
<?php /* ################ AUDITORIA DE SEGUIMIENTO ############## */ ?>
<?php require("funciones/funciones_auditorias.php"); ?>
<?php $lugar_mapa = 61; ?>
<?php $dispositivo_acceso = obtener_dispositivo(); ?>
<?php insertar_log_seguimiento($conexion2, ObtenerIP(), $dispositivo_acceso, $lugar_mapa, $_SESSION['session_gc']['usua_id']); ?>
<?php /* ######################################################## */ ?>
<?php require 'inc/config.php'; ?>
<?php require 'inc/views/template_head_start.php'; ?>

<?php require 'inc/views/template_head_end.php'; ?>
<?php require 'inc/views/base_head.php'; ?>

<!-- Page Header -->
<div class="content bg-image overflow-hidden" style="background-image: url('<?php echo $one->assets_folder; ?>/img/photos/photo3@2x.jpg');">
    <div class="push-50-t push-15">
        <h1 class="h2 text-white animated zoomIn">Grupo Calpe || Dashboard Generales</h1>

    </div>
</div>
<!-- END Page Header -->

<!-- Stats -->
<?php if($_SESSION['session_gc']['roll'] == 1 || $_SESSION['session_gc']['roll'] == 3){ ?>
<div class="content bg-white border-b">
    <div class="row items-push text-uppercase">
        <div class="col-xs-6 col-sm-3">
            <div class="font-w700 text-gray-darker animated fadeIn">Total Usuarios</div>
            <div class="text-muted animated fadeIn">
              <small>No Activos: <?php $generales = new generales(); ?>
                                 <?php echo $generales -> contar($conexion2, "usuarios", "usua_stat", 0); ?>
              </small></div>
            <a class="h2 font-w300 text-primary animated flipInX" href="gc_ver_usuarios.php"> <?php echo $generales -> contar($conexion2, "usuarios", "usua_stat", 1); ?></a>
        </div>
        <div class="col-xs-6 col-sm-3">
            <div class="font-w700 text-gray-darker animated fadeIn">Total Empresas</div>
            <div class="text-muted animated fadeIn"><small> No Activas <?php echo $generales -> contar($conexion2, "maestro_empresa", "empre_estado_empresa", 0); ?></small></div>
            <a class="h2 font-w300 text-primary animated flipInX" href="gc_ver_empresas.php"><?php echo $generales -> contar($conexion2, "maestro_empresa", "empre_estado_empresa", 1); ?></a>
        </div>
        <div class="col-xs-6 col-sm-3">
            <div class="font-w700 text-gray-darker animated fadeIn">Total Proyectos</div>
            <div class="text-muted animated fadeIn"> No Activos <?php echo $generales -> contar($conexion2, "maestro_proyectos", "proy_estado", 0); ?></small></div>
            <a class="h2 font-w300 text-primary animated flipInX"  href="gc_ver_proyectos.php"><?php echo $generales -> contar($conexion2, "maestro_proyectos", "proy_estado", 1); ?></a>
        </div>
        <div class="col-xs-6 col-sm-3">
            <div class="font-w700 text-gray-darker animated fadeIn">Total Bancos</div>
            <div class="text-muted animated fadeIn"><small> No Activos <?php echo $generales -> contar($conexion2, "maestro_bancos", "banc_stado", 0); ?></small></div>
            <a class="h2 font-w300 text-primary animated flipInX" style="color: green;" href="gc_ver_bancos.php"><?php echo $generales -> contar($conexion2, "maestro_bancos", "banc_stado", 1); ?></a>
        </div>
        <div class="col-xs-6 col-sm-3">
            <div class="font-w700 text-gray-darker animated fadeIn">Total Cuentas</div>
            <div class="text-muted animated fadeIn">
              <small>No Activos: <?php echo $generales -> contar($conexion2, "cuentas_bancarias", "cta_estado", 0); ?>
              </small></div>
            <a class="h2 font-w300 text-primary animated flipInX" href="gc_ver_cuentas_bancarias.php"> <?php echo $generales -> contar($conexion2, "cuentas_bancarias", "cta_estado", 1); ?></a>
        </div>

        <div class="col-xs-6 col-sm-3">
            <div class="font-w700 text-gray-darker animated fadeIn">Total chequeras</div>
            <div class="text-muted animated fadeIn"> No Activos <?php echo $generales -> contar($conexion2, "chequeras", "chq_estado_chequera", 0); ?></small></div>
            <a class="h2 font-w300 text-primary animated flipInX"  href="gc_ver_chequeras.php"><?php echo $generales -> contar($conexion2, "chequeras", "chq_estado_chequera", 1); ?></a>
        </div>
        <div class="col-xs-6 col-sm-3">
            <div class="font-w700 text-gray-darker animated fadeIn">Total Movimientos</div>
            <div class="text-muted animated fadeIn"><small> No Activos <?php echo $generales -> contar($conexion2, "movimiento_bancario", "mb_stat", 0); ?></small></div>
            <a class="h2 font-w300 text-primary animated flipInX" style="color: green;" href="gc_ver_movimiento_bancario.php"><?php echo $generales -> contar($conexion2, "movimiento_bancario", "mb_stat", 1); ?></a>
        </div>
        <div class="col-xs-6 col-sm-3">
            <div class="font-w700 text-gray-darker animated fadeIn">Cuentas/movimientos</div>
            <div class="text-muted animated fadeIn">
              <small>
                Cuentas
              </small></div>
            <a class="h2 font-w300 text-primary animated flipInX" href="gc_saldo_cuentas.php">
              <?php $sql_reg = saldo_cuentas($conexion2); ?>
              <?php $contar = $sql_reg->num_rows; ?>
              <?php echo $contar; ?>
            </a>
        </div>
        <div class="col-xs-6 col-sm-3">
            <div class="font-w700 text-gray-darker animated fadeIn">Total vendedores</div>
            <div class="text-muted animated fadeIn"><small> No Activos <?php echo $generales -> contar($conexion2, "maestro_vendedores", "ven_status", 0); ?></small></div>
            <a class="h2 font-w300 text-primary animated flipInX" href="gc_ver_vendedores.php"><?php echo $generales -> contar($conexion2, "maestro_vendedores", "ven_status", 1); ?></a>
        </div>
        <div class="col-xs-6 col-sm-3">
            <div class="font-w700 text-gray-darker animated fadeIn">Total clientes</div>
            <div class="text-muted animated fadeIn"> No Activos <?php echo $generales -> contar($conexion2, "maestro_clientes", "cl_status", 0); ?></small></div>
            <a class="h2 font-w300 text-primary animated flipInX"  href="gc_ver_cliente.php"><?php echo $generales -> contar($conexion2, "maestro_clientes", "cl_status", 1); ?></a>
        </div>
        <div class="col-xs-6 col-sm-3">
            <div class="font-w700 text-gray-darker animated fadeIn">Total inmuebles</div>
            <div class="text-muted animated fadeIn"><small> No Activos <?php echo $generales -> contar($conexion2, "maestro_inmuebles", "mi_status", 0); ?></small></div>
            <a class="h2 font-w300 text-primary animated flipInX" style="color: green;" href="gc_ver_inmuebles.php"><?php echo $generales -> contar_inmuebles($conexion2, "maestro_inmuebles", "mi_status", 1, 2, 3); ?></a>
        </div>
        <div class="col-xs-6 col-sm-3">
            <div class="font-w700 text-gray-darker animated fadeIn">Grupos Inmuebles</div>
            <div class="text-muted animated fadeIn">
              <small>No Activos: <?php echo $generales -> contar($conexion2, "grupo_inmuebles", "gi_status", 0); ?>
              </small></div>
            <a class="h2 font-w300 text-primary animated flipInX" href="gc_ver_grupo_inmueble.php"> <?php echo $generales -> contar($conexion2, "grupo_inmuebles", "gi_status", 1); ?></a>
        </div>
        <div class="col-xs-6 col-sm-3">
            <div class="font-w700 text-gray-darker animated fadeIn">Total Casa</div>
            <div class="text-muted animated fadeIn"><small> No Activos <?php echo $generales -> contar_inmuebles_tipo($conexion2, "maestro_inmuebles", "mi_status", "id_tipo_inmuebles", 1, 0, 0, 0); ?></small></div>
            <a class="h2 font-w300 text-primary animated flipInX" href="gc_ver_inmuebles.php"><?php echo $generales -> contar_inmuebles_tipo($conexion2, "maestro_inmuebles", "mi_status", "id_tipo_inmuebles", 1, 1, 2, 3); ?></a>
        </div>
        <div class="col-xs-6 col-sm-3">
            <div class="font-w700 text-gray-darker animated fadeIn">Total apartamento</div>
            <div class="text-muted animated fadeIn"> No Activos <?php echo $generales -> contar_inmuebles_tipo($conexion2, "maestro_inmuebles", "mi_status", "id_tipo_inmuebles", 2, 0, 0, 0); ?></small></div>
            <a class="h2 font-w300 text-primary animated flipInX"  href="gc_ver_inmuebles.php"><?php echo $generales -> contar_inmuebles_tipo($conexion2, "maestro_inmuebles", "mi_status", "id_tipo_inmuebles", 2, 1, 2, 3); ?></a>
        </div>
        <div class="col-xs-6 col-sm-3">
            <div class="font-w700 text-gray-darker animated fadeIn">Total galera</div>
            <div class="text-muted animated fadeIn"><small> No Activos <?php echo $generales -> contar_inmuebles_tipo($conexion2, "maestro_inmuebles", "mi_status", "id_tipo_inmuebles", 3, 0, 0, 0); ?></small></div>
            <a class="h2 font-w300 text-primary animated flipInX" style="color: green;" href="gc_ver_inmuebles.php"><?php echo $generales -> contar_inmuebles_tipo($conexion2, "maestro_inmuebles", "mi_status", "id_tipo_inmuebles", 3, 1, 2, 3); ?></a>
        </div>
        <div class="col-xs-6 col-sm-3">
            <div class="font-w700 text-gray-darker animated fadeIn">Total local comercial</div>
            <div class="text-muted animated fadeIn">
              <small>No Activos: <?php echo $generales -> contar_inmuebles_tipo($conexion2, "maestro_inmuebles", "mi_status", "id_tipo_inmuebles", 4, 0, 0, 0); ?>
              </small></div>
            <a class="h2 font-w300 text-primary animated flipInX" href="gc_ver_inmuebles.php"> <?php echo $generales -> contar_inmuebles_tipo($conexion2, "maestro_inmuebles", "mi_status", "id_tipo_inmuebles", 4, 1, 2, 3); ?></a>
        </div>
        <div class="col-xs-6 col-sm-3">
            <div class="font-w700 text-gray-darker animated fadeIn">Total reservas</div>
            <div class="text-muted animated fadeIn"><small> Solo reservas</small> </div>
            <a class="h2 font-w300 text-primary animated flipInX" href="gc_ver_reservas_inmuebles.php"><?php echo $generales -> contar($conexion2, "maestro_inmuebles", "mi_status", 2); ?></a>
        </div>
        <div class="col-xs-6 col-sm-3">
            <div class="font-w700 text-gray-darker animated fadeIn">Contratos/ventas</div>
            <div class="text-muted animated fadeIn"> Cancelados </small></div>
            <a class="h2 font-w300 text-primary animated flipInX"  href="gc_ver_contrato_venta.php"><?php $sql_reg = ver_contratos_ventas($conexion2); ?>
                                                                                                                    <?php $contar = $sql_reg -> num_rows; ?>
                                                                                                                    <?php echo $contar; ?></a></a>
        </div>
        <div class="col-xs-6 col-sm-3">
            <div class="font-w700 text-gray-darker animated fadeIn">Total documentos</div>
            <div class="text-muted animated fadeIn"><small> No Activos <?php echo $generales -> contar($conexion2, "maestro_cuotas", "mc_status", 0); ?></small></div>
            <a class="h2 font-w300 text-primary animated flipInX" style="color: green;" href="gc_ver_documentos.php"><?php echo $generales -> contar($conexion2, "maestro_cuotas", "mc_status", 1); ?></a>
        </div>
        <div class="col-xs-6 col-sm-3">
            <div class="font-w700 text-gray-darker animated fadeIn">Total proveedores</div>
            <div class="text-muted animated fadeIn">
              <small>No Activos: <?php echo $generales -> contar($conexion2, "maestro_proveedores", "pro_status", 0); ?>
              </small></div>
            <a class="h2 font-w300 text-primary animated flipInX" href="gc_ver_proveedores.php"> <?php echo $generales -> contar($conexion2, "maestro_proveedores", "pro_status", 1); ?></a>
        </div>
        <div class="col-xs-6 col-sm-3">
            <div class="font-w700 text-gray-darker animated fadeIn">Total partidas</div>
            <div class="text-muted animated fadeIn"><small> No Activos <?php echo $generales -> contar($conexion2, "maestro_partidas", "p_status", 0); ?></small></div>
            <a class="h2 font-w300 text-primary animated flipInX" href="gc_partidas.php"><?php echo $generales -> contar($conexion2, "maestro_partidas", "p_status", 1); ?></a>
        </div>
        <div class="col-xs-6 col-sm-3">
            <div class="font-w700 text-gray-darker animated fadeIn">Documentos costos</div>
            <div class="text-muted animated fadeIn"> Cancelados</small></div>
            <a class="h2 font-w300 text-primary animated flipInX"  href="gc_ver_documentos_partidas.php"><?php $sql_reg = ver_documentos_partidas($conexion2); ?>
                                                                                                                    <?php $contar = $sql_reg -> num_rows; ?>
                                                                                                                    <?php echo $contar; ?></a>
        </div>
        <div class="col-xs-6 col-sm-3">
            <div class="font-w700 text-gray-darker animated fadeIn">Total pagos emitidos</div>
            <div class="text-muted animated fadeIn"><small> Cancelados: </small></div>
            <a class="h2 font-w300 text-primary animated flipInX" style="color: green;" href="gc_ver_documentos_pagos.php"><?php $sql_reg = ver_documentos_pagos($conexion2); ?>
                                                                                                                    <?php $contar = $sql_reg -> num_rows; ?>
                                                                                                                    <?php echo $contar; ?></a>
        </div>
    </div>
</div>
<?php }else{ ?>

<!--<div class="content bg-white border-b">
    <div class="row items-push text-uppercase">

    </div>

</div>-->
<div class="font-w700 text-gray-darker animated fadeIn"><h1>Bienvenido al sistema Calpes.</h1></div>


<?php } ?>
<!-- END Stats -->

<!-- Page Content -->
<div class="content">
    <div class="row">

    </div>

</div>
<!-- END Page Content -->

<?php require 'inc/views/base_footer.php'; ?>
<?php require 'inc/views/template_footer_start.php'; ?>

<?php require 'inc/views/template_footer_end.php'; ?>

<?php }else{ ?>

        <script type="text/javascript">
            window.location="index.php";
        </script>

<?php } ?>
