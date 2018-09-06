<?php 
    require("conexion/conexion.php"); 
    require("funciones/funciones.php"); 
    require("funciones/clases.php"); 
    require("funciones/funciones_auditorias.php");

    if(!isset($_SESSION)) session_start();

    if(isset($_SESSION['session_gc'])){ 
        ############## Destruir variables de session ############## 
        if(isset($_SESSION['session_empresa'])) 
            unset($_SESSION['session_empresa']);
        elseif(isset($_SESSION['session_proyecto']))
          unset($_SESSION['session_proyecto']);
        elseif(isset($_SESSION['session_bancos']))
          unset($_SESSION['session_bancos']);
        elseif(isset($_SESSION['session_cta']))
          unset($_SESSION['session_cta']);
        elseif(isset($_SESSION['session_chq']))
          unset($_SESSION['session_chq']);
        elseif(isset($_SESSION['session_mb']))
          unset($_SESSION['session_mb']);
        elseif(isset($_SESSION['session_ch']))
          unset($_SESSION['session_ch']);
        elseif(isset($_SESSION['session_ven']))
          unset($_SESSION['session_ven']);
        elseif(isset($_SESSION['session_cl']))
          unset($_SESSION['session_cl']);
        elseif(isset($_SESSION['session_mi']))
          unset($_SESSION['session_mi']);
        elseif(isset($_SESSION['session_grupo_inmueble']))
          unset($_SESSION['session_grupo_inmueble']);
        elseif(isset($_SESSION['session_inmueble']))
          unset($_SESSION['session_inmueble']);
        elseif(isset($_SESSION['reserva']))
          unset($_SESSION['reserva']);
        elseif(isset($_SESSION['session_ventas_reserva']))
          unset($_SESSION['session_ventas_reserva']);
        elseif(isset($_SESSION['session_ventas']))
          unset($_SESSION['session_ventas']);
        elseif(isset($_SESSION['session_contrato']))
          unset($_SESSION['session_contrato']);
        elseif(isset($_SESSION['session_documentos']))
          unset($_SESSION['session_documentos']);
        elseif(isset($_SESSION['session_pro']))
          unset($_SESSION['session_pro']);
        elseif(isset($_SESSION['partida_documento']))
          unset($_SESSION['partida_documento']);
    } 

    $header_bar = 'base_header.php'; 
    $menu = true;
    $lugar_mapa = 61;
    $dispositivo_acceso = obtener_dispositivo(); 
    insertar_log_seguimiento($conexion2, ObtenerIP(), $dispositivo_acceso, $lugar_mapa, $_SESSION['session_gc']['usua_id']);

    require 'inc/config.php'; 
    require 'inc/views/template_head_start.php';
    require 'inc/views/template_head_end.php'; 
    require 'inc/views/base_head.php'; 
?>
<!-- Page Header -->
<div class="content bg-image overflow-hidden" style="background-image: url('<?php echo $one->assets_folder; ?>/img/photos/photo3@2x.jpg');">
    <div class="push-50-t push-15">
        <h1 class="h2 text-white animated zoomIn">Grupo Calpes || Dashboard Generales</h1>

    </div>
</div>
<!-- END Page Header -->

<div class="content border-b" style="background-image: url('Imagenfondocalpe.jpg'); background-repeat: no-repeat; background-size: cover; height: 500px; min-height: 650px">
    
</div>


<!-- END Page Content -->
<?php 
    require 'inc/views/base_footer.php'; 
    require 'inc/views/template_footer_start.php';
    require 'inc/views/template_footer_end.php'; 
?>


