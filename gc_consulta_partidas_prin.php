<?php if(!isset($_SESSION)){session_start();}?>
<?php require("conexion/conexion.php"); ?>
<?php require("funciones/funciones.php"); ?>
<?php if(isset($_SESSION['session_gc'])){ ?>
<?php $header_bar = 'base_header.php'; ?>
<?php $menu = true; ?>
<?php /* ################ AUDITORIA DE SEGUIMIENTO ############## */ ?>
<?php require("funciones/funciones_auditorias.php"); ?>
<?php $lugar_mapa = 68; ?>
<?php $dispositivo_acceso = obtener_dispositivo(); ?>
<?php insertar_log_seguimiento($conexion2, ObtenerIP(), $dispositivo_acceso, $lugar_mapa, $_SESSION['session_gc']['usua_id']); ?>
<?php /* ######################################################## */ ?>

<?php require 'inc/config.php'; ?>
<?php require 'inc/views/template_head_start.php'; ?>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function(){
          $('#partida').change(function(){
            var id=$('#partida').val();

            /* Contenedor */
            $('#contenedor').load('ver_select_partidas/contenedor.php?id='+id);
            $('#contenedor_pago').load('ver_select_partidas/contenedor_detalles_pago.php?id='+id);
            /* ########## */

            /* Select jq */
            $('#partida2').load('ver_select_partidas/prueba2.php?id='+id);
            $('#partida3').load('ver_select_partidas/prueba3.php?id='+0);
            $('#partida4').load('ver_select_partidas/prueba4.php?id='+0);
            $('#partida5').load('ver_select_partidas/prueba5.php?id='+0);
            $('#partida6').load('ver_select_partidas/prueba6.php?id='+0);
            $('#partida7').load('ver_select_partidas/prueba7.php?id='+0);
            /* ######### */
          });
          $('#partida2').change(function(){
            var id2=$('#partida2').val();

            /* Contenedor */
            $('#contenedor').load('ver_select_partidas/contenedor.php?id='+id2);
            $('#contenedor_pago').load('ver_select_partidas/contenedor_detalles_pago.php?id='+id2);
            /* ########## */

            $('#partida3').load('ver_select_partidas/prueba3.php?id='+id2);
            $('#partida4').load('ver_select_partidas/prueba4.php?id='+0);
            $('#partida5').load('ver_select_partidas/prueba5.php?id='+0);
            $('#partida6').load('ver_select_partidas/prueba6.php?id='+0);
            $('#partida7').load('ver_select_partidas/prueba7.php?id='+0);
          });
          $('#partida3').change(function(){
            var id3=$('#partida3').val();

            /* Contenedor */
            $('#contenedor').load('ver_select_partidas/contenedor.php?id='+id3);
            $('#contenedor_pago').load('ver_select_partidas/contenedor_detalles_pago.php?id='+id3);
            /* ########## */

            $('#partida4').load('ver_select_partidas/prueba4.php?id='+id3);
            $('#partida5').load('ver_select_partidas/prueba5.php?id='+0);
            $('#partida6').load('ver_select_partidas/prueba6.php?id='+0);
            $('#partida7').load('ver_select_partidas/prueba7.php?id='+0);
          });
          $('#partida4').change(function(){
            var id4=$('#partida4').val();

            /* Contenedor */
            $('#contenedor').load('ver_select_partidas/contenedor.php?id='+id4);
            $('#contenedor_pago').load('ver_select_partidas/contenedor_detalles_pago.php?id='+id4);
            /* ########## */

            $('#partida5').load('ver_select_partidas/prueba5.php?id='+id4);
            $('#partida6').load('ver_select_partidas/prueba6.php?id='+0);
            $('#partida7').load('ver_select_partidas/prueba7.php?id='+0);
          });

          $('#partida5').change(function(){
            var id5=$('#partida5').val();

            /* Contenedor */
            $('#contenedor').load('ver_select_partidas/contenedor.php?id='+id5);
            $('#contenedor_pago').load('ver_select_partidas/contenedor_detalles_pago.php?id='+id5);
            /* ########## */

            $('#partida6').load('ver_select_partidas/prueba6.php?id='+id5);
            $('#partida7').load('ver_select_partidas/prueba7.php?id='+0);
          });

          $('#partida6').change(function(){
            var id6=$('#partida6').val();

            /* Contenedor */
            $('#contenedor').load('ver_select_partidas/contenedor.php?id='+id6);
            $('#contenedor_pago').load('ver_select_partidas/contenedor_detalles_pago.php?id='+id6);
            /* ########## */

            $('#partida7').load('ver_select_partidas/prueba7.php?id='+id6);
          });
      });
    </script>
    <style>
    table{
      border: 2px solid black;
    }
    tr, td{
       width: 25%;
       text-align: left;
       vertical-align: top;
       border-collapse: collapse;
       border: 2px solid black;
    }
    body{
      font-weight:bold;
    }
    option{
      font-weight:bold;
    }
    button.accordion {
        background-color: #eee;
        color: #444;
        cursor: pointer;
        padding: 18px;
        width: 100%;
        border: none;
        text-align: left;
        outline: none;
        font-size: 15px;
        transition: 0.4s;
    }

    button.accordion.active, button.accordion:hover {
        background-color: #ddd;
    }

    button.accordion:after {
        content: '\002B';
        color: #777;
        font-weight: bold;
        float: right;
        margin-left: 5px;
    }

    button.accordion.active:after {
        content: "\2212";
    }

    div.panel {
        padding: 0 18px;
        background-color: white;
        max-height: 0;
        overflow: hidden;
        transition: 0.6s ease-in-out;
        opacity: 0;
    }

    div.panel.show {
        opacity: 1;
        max-height: 100%;
    }
    </style>
    <link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/select2/select2.min.css">
    <link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/select2/select2-bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/sweetalert/sweetalert.min.css">
    <link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/datatables/jquery.dataTables.min.css">
    <?php require 'inc/views/template_head_end.php'; ?>
    <?php require 'inc/views/base_head.php'; ?>
    <div class="content content-narrow">
          <div class="row">
                <div class="col-lg-12">
                    <div class="block">
                    <?php $sql = $conexion2 -> query("select * from maestro_partidas where id_categoria is null"); ?>
                    <select id="partida" class="form-control" style="width: 100%; font-size: 10px">
                        <option value="">Seleccionar proyecto</option>
                        <?php while($q=$sql->fetch_array()){ ?>

                        <option value="<?php echo $q['id']; ?>"><?php echo $q['p_nombre']; ?></option>
                        <?php } ?>
                    </select>


                    <div class="col-lg-2">
                      <select id="partida2" class="form-control" name="" multiple="multiple" style="width:250px; height:200px; font-size: 10px">

                      </select>
                    </div>
                    <div class="col-lg-2">
                      <select id="partida3" class="form-control" name="" multiple="multiple" style="width:250px; height:200px; font-size: 10px">

                      </select>
                    </div>
                    <div class="col-lg-2">
                      <select id="partida4" class="form-control" name="" multiple="multiple" style="width:250px; height:200px; font-size: 10px">

                      </select>
                    </div>
                    <div class="col-lg-2">
                      <select id="partida5" class="form-control" name="" multiple="multiple" style="width:250px; height:200px; font-size: 10px">

                      </select>
                    </div>
                    <div class="col-lg-2">
                      <select id="partida6" class="form-control" name="" multiple="multiple" style="width:250px; height:200px; font-size: 10px">

                      </select>
                    </div>
                    <div class="col-lg-2">
                      <select id="partida7" class="form-control" name="" multiple="multiple" style="width:250px; height:200px; font-size: 10px">

                      </select>
                    </div>

                   <button class="accordion" style="margin-top:40px;">Totales de partidas</button>
                    <div class="panel">
                        <div id="contenedor"></div>
                    </div>

                    <button class="accordion">Detalles de pago</button>
                    <div class="panel">
                        <div id="contenedor_pago"></div>
                    </div>

                    <!--<button class="accordion">Graficas</button>
                    <div id="foo" class="panel">

                    </div>-->

                </div>
            </div>
        </div>
    </div>

    <script>
      var acc = document.getElementsByClassName("accordion");
      var i;

      for (i = 0; i < acc.length; i++) {
          acc[i].onclick = function(){
              this.classList.toggle("active");
              this.nextElementSibling.classList.toggle("show");
        }
      }
      </script>
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
    <script src="<?php echo $one->assets_folder; ?>/js/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo $one->assets_folder; ?>/js/pages/base_tables_datatables.js"></script>
    <?php require 'inc/views/template_footer_end.php'; ?>
    <?php }else{ ?>

            <script type="text/javascript">
                window.location="salir.php";
            </script>

    <?php } ?>
