<?php if(!isset($_SESSION)){session_start();}?>
<?php require("conexion/conexion.php"); ?>
<?php require("funciones/funciones.php"); ?>
<?php if(isset($_SESSION['session_gc'])){ ?>
<?php $header_bar = 'base_header.php'; ?>
<?php $menu = true; ?>
<?php if(isset($_POST['id_proyecto'])){ $_SESSION['id_proyecto'] = $_POST['id_proyecto'];} ?>
<?php /* ################ insercion a la base de datos ############### */ ?>

<?php if (isset($_POST['registrar_proveedor'])):

$sql_insertar_pro = mysqli_query($conexion2, "insert into maestro_proveedores(pro_nombre_comercial,
                                                                         pro_razon_social,
                                                                         pro_ruc,
                                                                         pro_pais,
                                                                         pro_status,
                                                                         pro_telefono_1
                                                                         )values(
                                                                         '".strtoupper($_POST['nombre_comercial'])."',
                                                                         '".strtoupper($_POST['razon_social'])."',
                                                                         '".strtoupper($_POST['ruc'])."',
                                                                         '".strtoupper($_POST['id_pais'])."',
                                                                         1,
                                                                         '".strtoupper($_POST['telefono_1'])."')");

      endif;

      if(isset($_POST['confirmacion'])){

            $sql_insertar = $conexion2 -> query("insert into partida_documento(id_partida,
                                                                               id_proveedor,
                                                                               tipo_documento,
                                                                               pd_fecha_emision,
                                                                               pd_fecha_vencimiento,
                                                                               pd_descripcion,
                                                                               pd_monto_exento,
                                                                               pd_monto_gravable,
                                                                               pd_impuesto,
                                                                               pd_monto_total,
                                                                               pd_stat)
                                                                               values
                                                                               ('".$_POST['id_partida']."',
                                                                                '".$_POST['id_proveedor']."',
                                                                                '".$_POST['tipo_documento']."',
                                                                                '".date("Y-m-d", strtotime($_POST['fecha_emision']))."',
                                                                                '".date("Y-m-d", strtotime($_POST['fecha_vencimiento']))."',
                                                                                '".$_POST['descripcion']."',
                                                                                '".$_POST['monto_exento']."',
                                                                                '".$_POST['monto_gravable']."',
                                                                                '".$_POST['impuesto']."',
                                                                                '".$_POST['monto_total']."',
                                                                                13)");

function recorer_arbol_factura($conexion, $id_partida, $monto){

        $sql_datos_partida = $conexion -> query("select * from maestro_partidas where id = '".$id_partida."'");
        while($ld = $sql_datos_partida -> fetch_array()){
              $id=$ld['id'];
              $id_categoria=$ld['id_categoria'];
              $reservado=$ld['p_reservado'];
              $monto_con = $ld['p_monto'];
        }

        $total_reservado = $reservado + $_POST['monto_total'];

        $sql_insert = $conexion ->query("UPDATE maestro_partidas SET p_reservado = '".$total_reservado."' WHERE id = '".$id."'");
        /* comprovar si llego a su totalidad de monto */
        if($monto_con == $total_reservado){
            $sql_up = $conexion ->query("UPDATE maestro_partidas SET tiene_pagos = 1 WHERE id = '".$id."'");
        }

        if($id_categoria == ''){

        }else{
        recorer_arbol_factura($conexion, $id_categoria, $total_reservado);
      }

}

recorer_arbol_factura($conexion2, $_POST['id_partida'], $_POST['monto_total']);

unset($_SESSION['partida_documento']);

}elseif(isset($_POST['id_partida'],
              $_POST['id_proveedor'],
              $_POST['tipo_documento'],
              $_POST['fecha_emision'],
              $_POST['fecha_vencimiento'],
              $_POST['descripcion'],
              $_POST['monto_exento'],
              $_POST['monto_gravable'],
              $_POST['impuesto'],
              $_POST['monto_total'])){

                $documento = array("id_partida"=>$_POST['id_partida'],
                                   "id_proveedor"=>$_POST['id_proveedor'],
                                   "tipo_documento"=>$_POST['tipo_documento'],
                                   "fecha_emision"=> date_format(date_create($_POST['fecha_emision']), "Y-m-d"),
                                   "fecha_vencimiento"=> date_format(date_create($_POST['fecha_vencimiento']), "Y-m-d"),
                                   "monto_maximo" => $_POST['monto_maximo'],
                                   "descripcion"=>$_POST['descripcion'],
                                   "monto_exento"=>$_POST['monto_exento'],
                                   "monto_gravable"=>$_POST['monto_gravable'],
                                   "impuesto"=>$_POST['impuesto'],
                                   "monto_total"=>$_POST['monto_total']);


                $_SESSION['partida_documento'] = $documento;
              } ?>
<?php /* ############################################################# */ ?>
<?php /* ################ AUDITORIA DE SEGUIMIENTO ############## */ ?>
<?php require("funciones/funciones_auditorias.php"); ?>
<?php $lugar_mapa = 56; ?>
<?php $dispositivo_acceso = obtener_dispositivo(); ?>
<?php insertar_log_seguimiento($conexion2, ObtenerIP(), $dispositivo_acceso, $lugar_mapa, $_SESSION['session_gc']['usua_id']); ?>
<?php /* ######################################################## */ ?>
<?php require 'inc/config.php'; ?>
<?php require 'inc/views/template_head_start.php'; ?>
<!-- Page JS Plugins CSS -->
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/bootstrap-datepicker/bootstrap-datepicker3.min.css">
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/select2/select2.min.css">
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/select2/select2-bootstrap.min.css">
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/sweetalert/sweetalert.min.css">

<?php require 'inc/views/template_head_end.php'; ?>

<script type="text/javascript">
$(document).ready(function() {
   $("#datepicker").datepicker();
});
</script>

<?php require 'inc/views/base_head.php'; ?>
<script type="text/javascript">/*
  function suma_campos()
  {
    elem_1 = (isNaN(document.getElementById("text1").value) || document.getElementById("text1").value == "") ? "0" : document.getElementById("text1").value;
    elem_2 = (isNaN(document.getElementById("text2").value) || document.getElementById("text2").value == "") ? "0" : document.getElementById("text2").value;
    document.getElementById("text3").value = parseInt(elem_1) + parseInt(elem_2) + (parseInt(elem_2) * 7 / 100);
    document.getElementById("text4").value = parseInt(elem_2) * 7 / 100;
  }*/
</script>
<script type="text/javascript">
  function suma_campos()
  {
    elem_1 = (isNaN(document.getElementById("text1").value) || document.getElementById("text1").value == "") ? "0" : document.getElementById("text1").value;
    elem_2 = (isNaN(document.getElementById("text2").value) || document.getElementById("text2").value == "") ? "0" : document.getElementById("text2").value;

    document.getElementById("text3").value = parseFloat(Math.round(elem_1*100)/100 + Math.round(elem_2*100)/100 + (Math.round(elem_2) * 7 / 100)).toFixed(2);
    /*parseFloat(Math.round(x * 100) / 100).toFixed(2);*/
    document.getElementById("text4").value = parseFloat(Math.round(elem_2) * 7 / 100).toFixed(2);
  }
</script>
<div class="content content-narrow">

    <!-- Forms Row -->
    <div class="row">

            <?php if(isset($sql_insertar)){ ?>

                    <!-- Success Alert -->
                    <div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h3 class="font-w300 push-15">Registrado</h3>
                        <p><a class="alert-link" href="javascript:void(0)">Registro</a> Con Exito!</p>
                    </div>
                    <!-- END Success Alert -->

            <?php } ?>
            <?php if(isset($sql_insertar_pro)){ ?>

                    <!-- Success Alert -->
                    <div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h3 class="font-w300 push-15">Registrado</h3>
                        <p><a class="alert-link" href="javascript:void(0)">Registro</a> Con Exito!</p>
                    </div>
                    <!-- END Success Alert -->

            <?php } ?>

    <div class="col-lg-2"></div>
        <div class="col-lg-7">
            <!-- Bootstrap Forms Validation -->
            <div class="block">
                <div class="block-header">
                    <ul class="block-options">
                        <li>

                        </li>
                    </ul>
                    <h3 class="block-title">Registrar Factura </h3><small> Los campos con <span class="text-danger">*</span> son obligatorios</small>
                </div>
                <div class="block-content block-content-narrow">
                    <!-- jQuery Validation (.js-validation-bootstrap class is initialized in js/pages/base_forms_validation.js) -->
                    <!-- For more examples you can check out https://github.com/jzaefferer/jquery-validation -->
                    <form class="js-validation-bootstrap form-horizontal" action="" method="post">
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-username">Partida <span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <?php /* ?><select class="js-select2 form-control" id="val-select2" name="id_partida" style="width: 100%;" data-placeholder="Seleccionar cuenta" required="required">
                                    <option></option>
                                    <?php $sql_partida = seleccionar_partida_factura($conexion2, $_SESSION['id_proyecto']); ?>
                                    <?php while($lista_partida = $sql_partida -> fetch_array()){ ?>
                                    <option value="<?php echo $lista_partida['id']; ?>"
                                                   <?php if(isset($_SESSION['partida_documento'])){ if($_SESSION['partida_documento']['id_partida'] == $lista_partida['id']){ echo 'selected'; }}
                                                         elseif(isset($_SESSION['id_proyecto'])){ if($_SESSION['id_proyecto'] == $lista_partida['id']){ echo 'selected'; }} ?>
                                     ><?php echo $lista_partida['p_nombre']; ?></option>
                                    <?php } ?>
                                </select> */ ?>
                                <!-- select antiguo -->
                                <select class="form-control" style="width: 100%; display: none" data-placeholder="Seleccionar Proyecto">
                                    <option></option>
                                    <?php /* ############################################################# */ ?>

                                    <?php $sql = $conexion2 -> query("select * from maestro_partidas where id = '".$_SESSION['id_proyecto']."'"); ?>

                                    <?php function recorer($conexion, $id_categoria){

                                     $sql_inter = $conexion -> query("select * from maestro_partidas where id = '".$id_categoria."'");
                                       while($l2=$sql_inter->fetch_array()){
                                              echo recorer($conexion, $l2['id_categoria']).' '.$l2['p_nombre'].' // ';
                                      }

                                    } ?>

                                    <?php function inter($conexion, $id){ ?>
                                    <?php $sql_inter = $conexion -> query("select * from maestro_partidas where id_categoria = '".$id."'"); ?>
                                    <?php $contar=$sql_inter->num_rows; ?>

                                    <?php if($contar==0){ return true; }else{ return false; } }?>

                                    <?php while($l=$sql->fetch_array()){
                                                $var = inter($conexion2, $l['id']);
                                                if($var==true){ ?>
                                                <option value="<?php echo $l['id']; ?>" <?php if(isset($_SESSION['partida_documento'])){ if($_SESSION['partida_documento']['id_partida'] == $l['id']){ echo 'selected'; }}
                                                      elseif(isset($_SESSION['id_partida'])){ if($_SESSION['id_partida'] == $l['id']){ echo 'selected'; }} ?> > <?php echo recorer($conexion2, $l['id_categoria']).' // '.$l['p_nombre']; ?> </option>
                                        <?php      }
                                          } ?>
                                </select>

                                <select class="js-select2 form-control"
                                        id="val-select2"
                                        name="id_partida"
                                        style="width: 100%;"
                                        onchange="traerMonto(event)"
                                        data-placeholder="Seleccionar Proyecto" required="required">
                                    <option></option>

                                           <?php $sql = $conexion2 -> query("select * from maestro_partidas where id_proyecto = '".$_SESSION['id_proyecto']."'"); ?>

                                    <?php function recorer2($conexion, $id_categoria){

                                     $sql_inter = $conexion -> query("select * from maestro_partidas where id = '".$id_categoria."'");
                                       while($l2=$sql_inter->fetch_array()){
                                              echo recorer($conexion, $l2['id_categoria']).' '.$l2['p_nombre'].' // ';
                                      }

                                    } ?>

                                    <?php function inter2($conexion, $id){ ?>
                                    <?php $sql_inter = $conexion -> query("select * from maestro_partidas where id_categoria = '".$id."'"); ?>
                                    <?php $contar=$sql_inter->num_rows; ?>

                                    <?php if($contar==0){ return true; }else{ return false; } }?>

                                    <?php while($l=$sql->fetch_array()){
                                                $var = inter2($conexion2, $l['id']);
                                                if($var==true){ ?>
                                                <option value="<?php echo $l['id']; ?>" <?php if(isset($_SESSION['partida_documento'])){ if($_SESSION['partida_documento']['id_partida'] == $l['id']){ echo 'selected'; }}
                                                      elseif(isset($_SESSION['id_partida'])){ if($_SESSION['id_partida'] == $l['id']){ echo 'selected'; }} ?> > <?php echo recorer2($conexion2, $l['id_categoria']).' // '.$l['p_nombre']; ?> </option>
                                        <?php      }
                                          } ?>





                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-username">Proveedor <span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <select class="js-select2 form-control" id="val-select2" name="id_proveedor" style="width: 100%;" data-placeholder="Seleccionar tipo de movimiento" required="required">
                                    <option></option>
                                    <?php $sql_proveedores = todos_proveedores($conexion2); ?>
                                    <?php while($lista_proveedores = $sql_proveedores -> fetch_array()){ ?>
                                    <option value="<?php echo $lista_proveedores['id_proveedores']; ?>"
                                                   <?php if(isset($_SESSION['partida_documento'])){ if($_SESSION['partida_documento']['id_proveedor'] == $lista_proveedores['id_proveedores']){ echo 'selected'; }} ?>
                                     ><?php echo utf8_encode($lista_proveedores['pro_nombre_comercial']); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <button class="btn btn-default" style="float:left;" data-toggle="modal" data-target="#modal-popin" type="button"><i class="fa fa-user-plus"></i></button>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-username">Tipo <span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <select class="js-select2 form-control" id="val-select2" name="tipo_documento" style="width: 100%;" data-placeholder="Seleccionar tipo de movimiento" required="required">
                                    <option></option>
                                    <?php $sql_tipo_documentos = tipo_documentos($conexion2); ?>
                                    <?php while($lista_tipo_documentos = $sql_tipo_documentos -> fetch_array()){ ?>
                                    <option value="<?php echo $lista_tipo_documentos['id']; ?>"
                                                   <?php if(isset($_SESSION['partida_documento'])){ if($_SESSION['partida_documento']['tipo_documento'] == $lista_tipo_documentos['id']){ echo 'selected'; }} ?>
                                     ><?php echo $lista_tipo_documentos['nombre']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-email">Fecha Emision<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <input class="js-datepicker form-control" type="text" autocomplete="off" name="fecha_emision" id="example-datepicker1" data-date-format="dd-mm-yyyy" required="required" placeholder="Fecha" value="<?php if(isset($_SESSION['partida_documento'])){ echo $_SESSION['partida_documento']['fecha_emision'];} ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-email">Fecha Vencimiento<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <input class="js-datepicker form-control" type="text" autocomplete="off" name="fecha_vencimiento" id="example-datepicker1" data-date-format="dd-mm-yyyy" required="required" placeholder="Fecha" value="<?php if(isset($_SESSION['partida_documento'])){ echo $_SESSION['partida_documento']['fecha_vencimiento'];} ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-email">Descripcion <span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <textarea class="form-control" name="descripcion" required="required" placeholder="Descripcion" ><?php if(isset($_SESSION['partida_documento'])){ echo $_SESSION['partida_documento']['descripcion'];} ?></textarea>
                            </div>
                        </div>
                        <?php $total =0; ?>
                        <?php if(isset($_POST['id_partida'])){ ?>
                        <?php $sql_monto = seleccionar_partida($conexion2, $_POST['id_partida']); ?>
                        <?php while($lm = $sql_monto -> fetch_array()){
                                    $monto_asignado = $lm['p_monto'];
                                    $monto_reservado = $lm['p_reservado'];
                                    $monto_ejecutado = $lm['p_ejecutado'];
                              }
                                $total = $monto_asignado - ($monto_reservado + $monto_ejecutado);
                          }
                        ?>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-email"> </label>
                            <div class="col-md-7">
                                <input type="hidden" id="monto_maximo" name="monto_maximo" value="<?php if(isset($_SESSION['partida_documento']['monto_maximo'])) echo
                                  $_SESSION['partida_documento']['monto_maximo'] ?>" />
                                <small style="color:red;"> Monto maximo : <span class="monto-maximo">
                                  <?php echo (isset($_SESSION['partida_documento']['monto_maximo'])) ? $_SESSION['partida_documento']['monto_maximo'] : $total; ?></span> </small>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-password">Monto Exento<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                              <input class="form-control" type="text" id="text1" onkeyup="suma_campos()" name="monto_exento" value="<?php if(isset($_SESSION['partida_documento'])){ echo $_SESSION['partida_documento']['monto_exento'];} ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-password">Monto Gravable<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                              <input id="text2" onkeyup="suma_campos()" class="form-control" type="text" name="monto_gravable" value="<?php if(isset($_SESSION['partida_documento'])){ echo $_SESSION['partida_documento']['monto_gravable'];} ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-password">Impuesto<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                              <input class="form-control" type="number" id="text4" name="impuesto" readonly value="<?php if(isset($_SESSION['partida_documento'])){ echo $_SESSION['partida_documento']['impuesto'];} ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="val-password">Total<span class="text-danger">*</span></label>
                            <div class="col-md-7">
                              <input id="text3" class="form-control" <?php /* ?>max="echo $total; ?>" */ ?> type="number" name="monto_total" readonly value="<?php if(isset($_SESSION['partida_documento'])){ echo $_SESSION['partida_documento']['monto_total'];} ?>">
                            </div>
                        </div>
                        <?php if(isset($_SESSION['partida_documento'])){?> <input type="hidden" name="confirmacion" value="1"> <?php } ?>
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <?php if(isset($sql_insertar)){ ?> El registro fue realizado, usted sera redirecionado <?php }elseif(isset($_SESSION['partida_documento'])){ ?> <button class="btn btn-sm btn-primary" type="submit">Confirmar Registro</button> <?php }else{ ?> <button class="btn btn-sm btn-primary" type="submit">Registrar</button> <?php } ?>
                            </div>
                        </div>
                    </form>
            </div>
            <!-- Bootstrap Forms Validation -->
        </div>
    </div>
</div>

<div class="modal fade" id="modal-popin" role="dialog" aria-hidden="true">
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
                            <label class="col-xs-12" for="register1-username">PAIS</label>
                                <div class="col-xs-12">
                                   <select class="js-select2 form-control" name="id_pais" style="width: 100%;" data-placeholder="Seleccionar un pais" required="required">
                                        <option value="0"> Selecciona un pais</option>
                                        <?php
                                                $strConsulta = "select id_paises, ps_nombre_pais from maestro_paises";
                                                $result = $conexion2->query($strConsulta);
                                                $opciones = '<option value="0"> Elige un pais </option>';
                                                while($fila = $result->fetch_array()){ ?>
                                                        <option value="<?php echo $fila['id_paises']; ?>"><?php echo $fila['ps_nombre_pais']; ?></option>
                                        <?php  } ?>

                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12" for="register1-username">NOMBRE COMERCIAL</label>
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" id="register1-username" name="nombre_comercial" value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12" for="register1-email">RAZON SOCIAL</label>
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" id="register1-email" name="razon_social" value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12" for="register1-email">RUC</label>
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" id="register1-email" name="ruc" value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12" >TELEFONO 1</label>
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" id="register1-email" name="telefono_1" value="">
                                </div>
                            </div>
                        <div class="form-group">
                            <label class="col-xs-12" ></label>
                            <div class="col-xs-12">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-sm btn-default" type="button" data-dismiss="modal">Cancelar</button>
                            <button class="btn btn-sm btn-primary" type="submit" name="registrar_proveedor">Registrar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
</div>
</div>


<?php /*if(isset($sql_insertar)){

        unset($_SESSION['partida_documento']); ?>

<?php }*/ ?>

<?php require 'inc/views/base_footer.php'; ?>
<?php require 'inc/views/template_footer_start.php'; ?>
<!-- Page JS Plugins -->
<script src="<?php echo $one->assets_folder; ?>/js/plugins/select2/select2.full.min.js"></script>
<script src="<?php echo $one->assets_folder; ?>/js/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="<?php echo $one->assets_folder; ?>/js/plugins/jquery-validation/additional-methods.min.js"></script>
<!-- Page JS Code -->
<script>
      function validarTotal()
      {
        var total = parseFloat($("#text3").val());
        var max = parseFloat($("#monto-maximo").val());
        if(total > max){
            alert("El total no puede ser mayor al monto máximo.");
        }else{
          $("form").submit();
        }
      }
     function traerMonto(e)

        {


           $.ajax({
            type: 'POST',
            url: 'funciones/montos.php',
            data: { id_partida: e.target.value },
            success: function(data){
              $(".monto-maximo").html(data);
              $("#monto_maximo").val(data);
            },

          });

        }

    jQuery(function(){
        // Init page helpers (Select2 plugin)
        App.initHelpers('select2');
    });
</script>
<script src="<?php echo $one->assets_folder; ?>/js/pages/base_forms_validation.js"></script>
<!-- Page JS Plugins -->
<script src="<?php echo $one->assets_folder; ?>/js/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<script src="<?php echo $one->assets_folder; ?>/js/plugins/jquery-auto-complete/jquery.auto-complete.min.js"></script>
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
