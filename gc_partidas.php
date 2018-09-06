<?php if(!isset($_SESSION)){session_start();}?>
<?php require("conexion/conexion.php"); ?>
<?php require("funciones/funciones.php"); ?>
<?php if(isset($_SESSION['session_gc'])){ ?>
<?php $header_bar = 'base_header.php'; ?>
<?php $menu = true; ?>
<?php /* ################ AUDITORIA DE SEGUIMIENTO ############## */ ?>
<?php require("funciones/funciones_auditorias.php"); ?>
<?php $lugar_mapa = 55; ?>
<?php $dispositivo_acceso = obtener_dispositivo(); ?>
<?php insertar_log_seguimiento($conexion2, ObtenerIP(), $dispositivo_acceso, $lugar_mapa, $_SESSION['session_gc']['usua_id']); ?>
<?php /* ######################################################## */ ?>
<?php require 'inc/config.php'; ?>
<?php require 'inc/views/template_head_start.php'; ?>
<link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="css_partida_documento/vmenuModule.css" />
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/sweetalert/sweetalert.min.css">
<?php require 'inc/views/template_head_end.php'; ?>
<?php require 'inc/views/base_head.php'; ?>
<?php function ver_si_existen_registros($con, $id){

      $conprobar = $con ->query("select * from partida_documento where id_partida =".$id);
      $row_cnt = $conprobar->num_rows;
      if($row_cnt>0){
        return 1;
      }else{
        return 2;
      }

} ?>
<?php function sub_partidas($id, $conexion){

        echo '<ul>';

        $sql_partida = $conexion -> query("select * from maestro_partidas where id_padre = '".$id."'");
        while($l=$sql_partida->fetch_array()){
              $ar[]=$l;
        }
        if(isset($ar)){

        foreach($ar as $ll){ ?>

        <?php $conmp = ver_si_existen_registros($conexion, $ll['id']); ?>

             <script type="text/javascript">
                  $(document).ready(function() {
                      $('#gallery<?php echo $ll['id']; ?>').click(function(){
                          $("#central").load('arbol_documento.php?id=<?php echo $ll['id']; ?>');
                      });
                  });
             </script>
<?php
        echo '<li><a>'. substr($ll['p_nombre'], 0, 25).'</a>
              '.(($conmp == 1)?'<div id="gallery'.$ll['id'].'">Ver</div>': " ").'';
        sub_partidas($ll['id'], $conexion);
        echo '</li>';
      }}
        echo '</ul>';

} ?>
<div class="content content-narrow">
    <!-- Forms Row -->
      <div class="row">
            <div class="col-lg-12">
                <!-- Bootstrap Forms Validation -->
                <div class="block">
                    <div class="block-header">
                        <!--<ul class="block-options">
                            <li>
                            </li>
                        </ul>-->
                        <h3 class="block-title">Consulta de documentos</h3>
                        <h1> Arbol de Partidas</h1>
                    </div>
                    <!--<div class="block-content block-content-narrow">-->
                    	<!--<div class="container">-->
                        	<div class="row">
                            	<div class="col-md-12">
                              <?php /* Arbol de documentos */ ?>
                              <div id="content" style="float:left; position:relative;">
                                <div class="u-vmenu">
                                  <ul>
                                    <li><a href="#">Partidas</a>
                                      <ul>
                                        <?php $sql=$conexion2->query("select * from maestro_partidas where id_padre is null"); ?>
                                        <?php while($l=$sql->fetch_array()){ ?>
                                        <li><a href="#"><?php echo  substr($l['p_nombre'], 0, 25); ?></a>
                                          <?php sub_partidas($l['id'], $conexion2); ?>
                                        </li>
                                        <?php } ?>
                                      </ul>
                                    </li>
                                  </ul>
                                </div>
                              </div>
                              <div id="central" style="float:left; position:relative;"> </div>
                              <?php /* fin arbol */ ?>
                            	</div>
                        	</div>
                    	<!--</div>-->
                    <!--</div>-->
                </div>
          </div>
    </div>
</div>
<script type="text/javascript" src="js_partida_documento/vmenuModule.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $(".u-vmenu").vmenuModule({
      Speed: 200,
      autostart: false,
      autohide: true
    });
  });
</script>
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-36251023-1']);
  _gaq.push(['_setDomainName', 'jqueryscript.net']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
<?php require 'inc/views/base_footer.php'; ?>
<?php require 'inc/views/template_footer_start_partida_documento.php'; ?>
<?php require 'inc/views/template_footer_end.php'; ?>
<?php }else{ ?>
        <script type="text/javascript">
            window.location="salir.php";
        </script>
<?php } ?>
