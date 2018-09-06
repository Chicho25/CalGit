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
<?php /* stylos hover para el eje btn */ ?>
<script src="https://code.jquery.com/jquery-3.1.1.min.js" type="text/javascript"></script>
<script type="text/javascript">
  $(document).ready(function () {
    $(".muestra").hide();
    $(".palanca").click(function (evt) {
        if(evt.target.tagName != 'UL')
            return;
        $(".muestra", this).toggle();
    });
  });
</script>
<style>
#caja{
    display: none;
    background-color: #ddd;
    /*padding: 5px;*/
    position: absolute;
    z-index: 99;
    float:right;
    right: 0px;
    margin-right: 20%;
    border: solid 1px #000;
}

#caja_mostar:hover #caja {
    display: block;
    z-index: 10;
}
.algo{
float:right;
}

table {
    border-collapse: collapse;
    width: 100%;
}

th, td {
    text-align: left;
    padding: 8px;
}

tr:nth-child(even){background-color: #f2f2f2}

th {
    background-color: #87ceeb;
    color: white;
}

</style>
<!-- Page JS Plugins CSS -->
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/select2/select2.min.css">
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/select2/select2-bootstrap.min.css">
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/sweetalert/sweetalert.min.css">

<style>
#lista2 {
    /*counter-reset: none;*/
    list-style: none;
    *list-style: decimal;
    font: 15px 'trebuchet MS', 'lucida sans';
    padding: 0;
    margin-bottom: 4em;
    text-shadow: 0 1px 0 rgba(255,255,255,.5);
}

#lista2 ul {
    margin: 0 0 0 2em;
}

#lista2 li{
    position: relative;
    display: block;
    padding: .4em .4em .4em 2em;
    *padding: .4em;
    margin: .5em 0;
    background: #ddd;
    color: #444;
    text-decoration: none;
    border-radius: .3em;
    transition: all .3s ease-out;
}

#lista2 li:hover{
    background: #eee;
}

#lista2 li:hover:before{
    transform: rotate(360deg);
}

#lista2 li:before{
    content: counter(li);
    /* counter-increment: li; */
    position: absolute;
    left: -1.3em;
    top: 50%;
    margin-top: -1.3em;
    background: #87ceeb;
    height: 2em;
    width: 2em;
    line-height: 2em;
    border: .3em solid #fff;
    text-align: center;
    font-weight: bold;
    border-radius: 2em;
    transition: all .3s ease-out;
}
</style>
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
                        <h3 class="block-title">Partidas</h3>

                    </div>
                    <div class="block-content block-content-narrow">
                      <?php include "modulo_partidas_copia/php/conexion.php"; ?>
                      <?php include "modulo_partidas_copia/php/functions2.php"; ?>
                      <?php if(isset($_POST['id_proyecto'])){$_SESSION['id_proyecto']=$_POST['id_proyecto'];

                                }else{$proyecto = 0;} ?>
                      <?php @$categories = get_base_categories($_SESSION['id_proyecto']);?>
                    	<!--<div class="container">
                        	<div class="row">
                            	<div class="col-md-12">-->
                            	<h1>Partidas</h1>
                              <form action="" method="post">
                                <select class="js-select2 form-control" id="val-select2" name="id_proyecto" style="width: 100%;" data-placeholder="Seleccionar Proyecto " onChange="this.form.submit()">
                                    <option value="0">Seleccione un Proyecto</option>
                                    <?php $sql_proyecto = proyectos_partidas(); ?>

                                    <?php while($lista_proyecto = $sql_proyecto -> fetch_array()){ ?>
                                    <option value="<?php echo $lista_proyecto['id']; ?>" <?php if(isset($_SESSION['id_proyecto'])){
                                                                                                  if($_SESSION['id_proyecto'] == $lista_proyecto['id']){ echo "selected";}
                                    } ?> ><?php echo $lista_proyecto['p_nombre']; ?></option>
                                    <?php } ?>
                                </select>
                              </form>

                              <ul id="lista2">
                                <li> Nombre de la Partida || Asignado || Distribuido || Reservado || Ejecutado</li>
                              </ul>

                                <?php if($_SESSION['session_gc']['roll'] == 3){  /* ################  Cuando el usuario sea de gerencia  ################## */ ?>

                                 <?php if(count($categories)>0):?>
                                	<ul id="lista2">
                                	<?php foreach($categories as $cat):?>
                                		<li><?php echo $cat["p_nombre"]." <b>Asignado ".number_format($cat["p_monto"], 2, '.', ',')." ||
                                                                         Distribuido ".number_format($cat["p_distribuido"], 2, '.', ',')." ||
                                                                         Reservado ".number_format($cat["p_reservado"], 2, '.', ',')." ||
                                                                         Ejecutado ".number_format($cat["p_ejecutado"], 2, '.', ',')."</b>"; ?> </li>
                                		<?php
                                		list_tree_cat_id($cat["id"]);
                                		?>
                                	<?php endforeach;?>
                                	</ul>
                                <?php else:?>
                                	<p class="alert alert-danger">Seleccione un proyecto</p>
                                <?php endif;?>

                              <?php } ?>

                            <!--	</div>
                        	</div>
                    	</div>-->
                    </div>
                </div>
          </div>
    </div>
</div>

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
