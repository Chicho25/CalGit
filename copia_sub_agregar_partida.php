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
<!-- Page JS Plugins CSS -->
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/select2/select2.min.css">
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/select2/select2-bootstrap.min.css">
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/sweetalert/sweetalert.min.css">
<?php require 'inc/views/template_head_end.php'; ?>
<?php require 'inc/views/base_head.php'; ?>
<div class="content content-narrow">
    <!-- Forms Row -->
      <div class="row">
            <div class="col-lg-12">
                <!-- Bootstrap Forms Validation -->
                <div class="block">
                    <div class="block-header">
                        <ul class="block-options">
                            <li>
                            </li>
                        </ul>
                        <h3 class="block-title">Crear sub Partida</h3>
                    </div>
                    <div class="block-content block-content-narrow">
                      <?php include "modulo_partidas/php/conexion.php"; ?>
                      <?php include "modulo_partidas/php/functions.php"; ?>
                      <?php /*include "modulo_partidas/php/navbar.php";*/ ?>
                      <?php $cat = get_cat_by_id($_GET["id"]); ?>
                      <?php $categories = get_base_categories();?>
                      <?php if($cat!=null):?>
                        	<h1>CREAR SUB-PARTIDA </h1>
                            	<form role="form" method="post" action="modulo_partidas_copia/php/actions.php?do=new">
                            	  <div class="form-group">
                            	    <label for="name">Partida</label>
                            	    <input type="text" name="name" value="<?php echo $cat["p_nombre"]; ?>" required class="form-control" id="name" placeholder="Titulo" readonly>
                            	  </div>
                            	  <div class="form-group">
                            	    <label for="category_id">Nombre de la sub-partida</label>
                            	    <input type="text" name="nombre_partida" class="form-control" required="required" autocomplete="off">
                                  <label for="category_id">Monto asignado </label> // <small style="color:red;"> Monto disponible:<?php echo $_GET['monto_restante']-$_GET['distribuido']; ?> </small><?php $total_maximo = $_GET['monto_restante'] - $_GET['distribuido']; ?>
                            	    <input type="number" autocomplete="off" max="<?php echo $total_maximo; ?>" min="0" step="0.01" name="monto_asignado" required="required" class="form-control">
                            	  </div>
                            	  <input type="hidden" name="id" value="<?php echo $cat["id"]; ?>">
                                <input type="hidden" name="distribuido" value="<?php echo $_GET['distribuido']; ?>">
                                <input type="hidden" name="user" value="<?php echo $_SESSION['session_gc']['usua_id']; ?>">
                            	  <button type="submit" class="btn btn-success">CREAR SUB-PARTIDA</button>
                            	</form>
                      <?php endif;?>
                    </div>
                </div>
          </div>
    </div>
</div>
<?php if(isset($sql_insertar)){

        unset($_SESSION['session_pro']); ?>

        <script type="text/javascript">
            function redireccionarPagina() {
              window.location = "gc_principal.php";
            }
            setTimeout("redireccionarPagina()", 5000);
        </script>

<?php } ?>
<?php require 'inc/views/base_footer.php'; ?>
<?php require 'inc/views/template_footer_start.php'; ?>
<!-- Page JS Plugins -->
<script src="<?php echo $one->assets_folder; ?>/js/plugins/select2/select2.full.min.js"></script>
<script src="<?php echo $one->assets_folder; ?>/js/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="<?php echo $one->assets_folder; ?>/js/plugins/jquery-validation/additional-methods.min.js"></script>
<!-- Page JS Code -->
<script>
    jQuery(function(){
        // Init page helpers (Select2 plugin)
        App.initHelpers('select2');
    });
</script>
<script src="<?php echo $one->assets_folder; ?>/js/pages/base_forms_validation.js"></script>
<!-- Page JS Plugins -->
<script src="<?php echo $one->assets_folder; ?>/js/plugins/bootstrap-notify/bootstrap-notify.min.js"></script>
<script src="<?php echo $one->assets_folder; ?>/js/plugins/sweetalert/sweetalert.min.js"></script>
<!-- Page JS Code -->
<script src="<?php echo $one->assets_folder; ?>/js/pages/base_ui_activity.js"></script>
<script>
    jQuery(function(){
        // Init page helpers (BS Notify Plugin)
        App.initHelpers('notify');
    });
</script>
<?php require 'inc/views/template_footer_end.php'; ?>
<?php }else{ ?>
        <script type="text/javascript">
            window.location="salir.php";
        </script>
<?php } ?>
