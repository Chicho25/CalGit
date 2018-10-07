<?php

include("include/functions_tayron.php");

if (isset($_POST['t1uno'], $_POST['t2tres'], $_POST['t3tres'])) {
  // code...

if (isset($_POST['finalizar'])) {

  $ingreso = array("t1" => 3,
                   "t2" => 3,
                   "t3" => 3,
                   "descriptions"=>"",
                   "date_time" => date("Y-m-d H:i:s"),
                    "stat" => 1);

  $insert = InsertRec("events", $ingreso);
}

if ($_POST['t1uno'] == 1 && $_POST['t2tres'] == 1 && $_POST['t3tres'] == 1) {

    $ingreso = array("t1" => 0,
                     "t2" => 92,
                     "t3" => 92,
                     "descriptions"=>"44,0 m",
                     "date_time" => date("Y-m-d H:i:s"),
                      "stat" => 1);

    $insert = InsertRec("events", $ingreso);

    $claset1_0 = " btn btn-warning boton";
    $claset2_92 = " btn btn-warning boton";
    $claset3_92 = " btn btn-warning boton";
    $detalle_m = "44,0 m";

}else if ($_POST['t1dos'] == 1 && $_POST['t2cuatro'] == 1 && $_POST['t3cuatro'] == 1) {

    $ingreso = array("t1" => 50,
                     "t2" => 100,
                     "t3" => 100,
                     "descriptions"=>"52,9 m",
                     "date_time" => date("Y-m-d H:i:s"),
                     "stat" => 1);

    $insert = InsertRec("events", $ingreso);

    $claset1_50 = " btn btn-warning boton";
    $claset2_100 = " btn btn-warning boton";
    $claset3_100 = " btn btn-warning boton";
    $detalle_m = "52,9 m";

}else if ($_POST['t1tres'] == 1 && $_POST['t2tres'] == 1 && $_POST['t3tres'] == 1) {

    $ingreso = array("t1" => 92,
                     "t2" => 92,
                     "t3" => 92,
                     "descriptions"=>"56,4 m",
                     "date_time" => date("Y-m-d H:i:s"),
                     "stat" => 1);

    $insert = InsertRec("events", $ingreso);

    $claset1_92 = " btn btn-warning boton";
    $claset2_92 = " btn btn-warning boton";
    $claset3_92 = " btn btn-warning boton";
    $detalle_m = "56,4 m";

}else if ($_POST['t1cuatro'] == 1 && $_POST['t2cuatro'] == 1 && $_POST['t3cuatro'] == 1) {

    $ingreso = array("t1" => 100,
                     "t2" => 100,
                     "t3" => 100,
                     "descriptions"=>"60 m",
                     "date_time" => date("Y-m-d H:i:s"),
                     "stat" => 1);

    $insert = InsertRec("events", $ingreso);

    $claset1_100 = " btn btn-warning boton";
    $claset2_100 = " btn btn-warning boton";
    $claset3_100 = " btn btn-warning boton";
    $detalle_m = "60 m";

}else if ($_POST['t1tres'] == 1 && $_POST['t2tres'] == 1 && $_POST['t3uno'] == 1) {

    $ingreso = array("t1" => 92,
                     "t2" => 92,
                     "t3" => 0,
                     "descriptions"=>"44,0 m",
                     "date_time" => date("Y-m-d H:i:s"));

    $insert = InsertRec("events", $ingreso);

    $claset1_92 = " btn btn-warning boton";
    $claset2_92 = " btn btn-warning boton";
    $claset3_0 = " btn btn-warning boton";
    $detalle_m = "44,0 m";

}else if ($_POST['t1tres'] == 1 && $_POST['t2tres'] == 1 && $_POST['t3dos'] == 1) {

  $ingreso = array("t1" => 92,
                   "t2" => 92,
                   "t3" => 50,
                   "descriptions"=>"50,7 m",
                   "date_time" => date("Y-m-d H:i:s"));

  $insert = InsertRec("events", $ingreso);

  $claset1_92 = " btn btn-warning boton";
  $claset2_92 = " btn btn-warning boton";
  $claset3_50 = " btn btn-warning boton";
  $detalle_m = "50,7 m";

}else if ($_POST['t1tres'] == 1 && $_POST['t2tres'] == 1 && $_POST['t3tres'] == 1) {

  $ingreso = array("t1" => 92,
                   "t2" => 92,
                   "t3" => 50,
                   "descriptions"=>"56,4 m",
                   "date_time" => date("Y-m-d H:i:s"));

  $insert = InsertRec("events", $ingreso);

  $claset1_92 = " btn btn-warning boton";
  $claset2_92 = " btn btn-warning boton";
  $claset3_92 = " btn btn-warning boton";
  $detalle_m = "56,4 m";

}else if ($_POST['t1cuatro'] == 1 && $_POST['t2cuatro'] == 1 && $_POST['t3cuatro'] == 1) {

  $ingreso = array("t1" => 100,
                   "t2" => 100,
                   "t3" => 100,
                   "descriptions"=>"60 m",
                   "date_time" => date("Y-m-d H:i:s"));

  $insert = InsertRec("events", $ingreso);

  $claset1_100 = " btn btn-warning boton";
  $claset2_100 = " btn btn-warning boton";
  $claset3_100 = " btn btn-warning boton";
  $detalle_m = "60 m";

}else if ($_POST['t1uno'] == 1 && $_POST['t2uno'] == 1 && $_POST['t3uno'] == 1) {

  $ingreso = array("t1" => 0,
                   "t2" => 0,
                   "t3" => 0,
                   "descriptions"=>"19,3 m",
                   "date_time" => date("Y-m-d H:i:s"));

  $insert = InsertRec("events", $ingreso);

  $claset1_0 = " btn btn-warning boton";
  $claset2_0 = " btn btn-warning boton";
  $claset3_0 = " btn btn-warning boton";
  $detalle_m = "19,3 m";

}else if ($_POST['t1dos'] == 1 && $_POST['t2uno'] == 1 && $_POST['t3uno'] == 1) {

  $ingreso = array("t1" => 50,
                   "t2" => 0,
                   "t3" => 0,
                   "descriptions"=>"26,0 m",
                   "date_time" => date("Y-m-d H:i:s"));

  $insert = InsertRec("events", $ingreso);

  $claset1_50 = " btn btn-warning boton";
  $claset2_0 = " btn btn-warning boton";
  $claset3_0 = " btn btn-warning boton";
  $detalle_m = "26,0 m";

}else if ($_POST['t1tres'] == 1 && $_POST['t2uno'] == 1 && $_POST['t3uno'] == 1) {

  $ingreso = array("t1" => 92,
                   "t2" => 0,
                   "t3" => 0,
                   "descriptions"=>"31,6 m",
                   "date_time" => date("Y-m-d H:i:s"));

  $insert = InsertRec("events", $ingreso);

  $claset1_92 = " btn btn-warning boton";
  $claset2_0 = " btn btn-warning boton";
  $claset3_0 = " btn btn-warning boton";
  $detalle_m = "31,6 m";

}else if ($_POST['t1tres'] == 1 && $_POST['t2dos'] == 1 && $_POST['t3uno'] == 1) {

  $ingreso = array("t1" => 92,
                   "t2" => 50,
                   "t3" => 0,
                   "descriptions"=>"38,4 m",
                   "date_time" => date("Y-m-d H:i:s"));

  $insert = InsertRec("events", $ingreso);

  $claset1_92 = " btn btn-warning boton";
  $claset2_50 = " btn btn-warning boton";
  $claset3_0 = " btn btn-warning boton";
  $detalle_m = "38,4 m";

  }

}else{

$currently = Getrecords("SELECT * FROM events WHERE id = (SELECT max(id) FROM events)");

  foreach ($currently as $key => $value) {
      $t1 = $value['t1'];
      $t2 = $value['t2'];
      $t3 = $value['t3'];
      $detalle_m = $value['descriptions'];
  }
    if ($t1 == 0) {
       $claset1_0 = " btn btn-warning boton";
    }elseif ($t1 == 50) {
       $claset1_50 = " btn btn-warning boton";
    }elseif ($t1 == 92) {
       $claset1_92 = " btn btn-warning boton";
    }else{
       $claset1_100 = " btn btn-warning boton";
    }

    if ($t2 == 0) {
       $claset2_0 = " btn btn-warning boton";
    }elseif ($t2 == 50) {
       $claset2_50 = " btn btn-warning boton";
    }elseif ($t2 == 92) {
       $claset2_92 = " btn btn-warning boton";
    }else{
       $claset2_100 = " btn btn-warning boton";
    }

    if ($t3 == 0) {
       $claset3_0 = " btn btn-warning boton";
    }elseif ($t3 == 50) {
       $claset3_50 = " btn btn-warning boton";
    }elseif ($t3 == 92) {
       $claset3_92 = " btn btn-warning boton";
    }else{
       $claset3_100 = " btn btn-warning boton";
    }

}
 ?>
<!DOCTYPE html>
<html>
  <head>
    <title>SHL Panel</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <style media="screen">
       .boton{
         width: 150px;
         height: 70px;
       }
    </style>
  </head>
<body>
      <div class="container">
        <div class="row">
          <div class="col-md-4 "></div>
          <div class="col-md-4 " style="font-size:52px;"><img class="center-block" style="float:left;" src="images/1.png" width="40"> PANALOCK</div>
          <div class="col-md-4 "></div>
        </div>
        <form class="" action="#" method="post" name="formulario_panel">
        <div class="row">
          <div class="col-md-1">
           </div>
          <div class="col-md-2 well">
            <h1> T1 </h1>
           </div>
          <div class="col-md-2 well">
            <input type="button" name="cero" value="0 %" class=" <?php if(isset($claset1_0)){ echo $claset1_0; }else{ ?> btn btn-primary boton <?php } ?>" id="t1uno" onclick="cambiarFondo('t1uno')">
            <input type="hidden" name="t1uno" value="" id="textt1_0">
          </div>
          <div class="col-md-2 well">
            <input type="button" name="cincuenta" value="50 %" class=" <?php if(isset($claset1_50)){ echo $claset1_50; }else{ ?> btn btn-primary boton <?php } ?>" id="t1dos" onclick="cambiarFondo('t1dos')">
            <input type="hidden" name="t1dos" value="" id="textt1_50">
          </div>
          <div class="col-md-2 well">
            <input type="button" name="cincuenta" value="92 %" class=" <?php if(isset($claset1_92)){ echo $claset1_92; }else{ ?> btn btn-primary boton <?php } ?>" id="t1tres" onclick="cambiarFondo('t1tres')">
            <input type="hidden" name="t1tres" value="" id="textt1_92">
          </div>
          <div class="col-md-2 well">
            <input type="button" name="cincuenta" value="100 %" class=" <?php if(isset($claset1_100)){ echo $claset1_100; }else{ ?> btn btn-primary boton <?php } ?>" id="t1cuatro" onclick="cambiarFondo('t1cuatro')">
            <input type="hidden" name="t1cuatro" value="" id="textt1_100">
          </div>
          <div class="col-md-1">
           </div>
        </div>
        <div class="row">
          <div class="col-md-1">
           </div>
          <div class="col-md-2 well">
            <h1> T2</h1>
           </div>
          <div class="col-md-2 well">
            <input type="button" name="cero" value="0 %" class=" <?php if(isset($claset2_0)){ echo $claset2_0; }else{ ?> btn btn-primary boton <?php } ?>" id="t2uno" onclick="cambiarFondo('t2uno')">
            <input type="hidden" name="t2uno" value="" id="textt2_0">
          </div>
          <div class="col-md-2 well">
            <input type="button" name="cincuenta" value="50 %" class=" <?php if(isset($claset2_50)){ echo $claset2_50; }else{ ?> btn btn-primary boton <?php } ?>" id="t2dos" onclick="cambiarFondo('t2dos')">
            <input type="hidden" name="t2dos" value="" id="textt2_50">
          </div>
          <div class="col-md-2 well">
            <input type="button" name="cincuenta" value="92 %" class=" <?php if(isset($claset2_92)){ echo $claset2_92; }else{ ?> btn btn-primary boton <?php } ?>" id="t2tres" onclick="cambiarFondo('t2tres')">
            <input type="hidden" name="t2tres" value="" id="textt2_92">
          </div>
          <div class="col-md-2 well">
            <input type="button" name="cincuenta" value="100 %" class=" <?php if(isset($claset2_100)){ echo $claset2_100; }else{ ?> btn btn-primary boton <?php } ?>" id="t2cuatro" onclick="cambiarFondo('t2cuatro')">
            <input type="hidden" name="t2cuatro" value="" id="textt2_100">
          </div>
          <div class="col-md-1">
           </div>
        </div>
        <div class="row">
          <div class="col-md-1">
           </div>
          <div class="col-md-2 well">
            <h1> T3</h1>
           </div>
          <div class="col-md-2 well">
            <input type="button" name="cero" value="0 %" class=" <?php if(isset($claset3_0)){ echo $claset3_0; }else{ ?> btn btn-primary boton <?php } ?>" id="t3uno" onclick="cambiarFondo('t3uno')">
            <input type="hidden" name="t3uno" value="" id="textt3_0">
          </div>
          <div class="col-md-2 well">
            <input type="button" name="cincuenta" value="50 %" class=" <?php if(isset($claset3_50)){ echo $claset3_50; }else{ ?> btn btn-primary boton <?php } ?>" id="t3dos" onclick="cambiarFondo('t3dos')">
            <input type="hidden" name="t3dos" value="" id="textt3_50">
          </div>
          <div class="col-md-2 well">
            <input type="button" name="cincuenta" value="92 %" class=" <?php if(isset($claset3_92)){ echo $claset3_92; }else{ ?> btn btn-primary boton <?php } ?>" id="t3tres" onclick="cambiarFondo('t3tres')">
            <input type="hidden" name="t3tres" value="" id="textt3_92">
          </div>
          <div class="col-md-2 well">
            <input type="button" name="cincuenta" value="100 %" class=" <?php if(isset($claset3_100)){ echo $claset3_100; }else{ ?> btn btn-primary boton <?php } ?>" id="t3cuatro" onclick="cambiarFondo('t3cuatro')">
            <input type="hidden" name="t3cuatro" value="" id="textt3_100">
          </div>
          <div class="col-md-1">
           </div>
        </div>
        <div class="row">
          <div class="col-md-8 well" style="font-size:52px;" id="pie">
            <?php if (isset($detalle_m)) { ?>
            <span style="color:green;">
            <?php echo $detalle_m; ?>
            </span>
            <?php }else{ ?>
            <span>0 m</span>
            <?php } ?>
          </div>
          <div class="col-md-2 well">
            <input onclick="finalizar_qq()" name="finalizar" value="Finalizar" class="btn btn-success boton">
          </div>
          <div class="col-md-2 well">
            <input type="submit" name="" value="Confirma" class="btn btn-success boton" onclick="confirmar()">
          </div>
        </div>
        </form>
      </div>
        <script type="text/javascript">
            function finalizar_qq(){
              var confirmacion = confirm("Esta seguro que desea finalizar la aperacion");
              if (confirmacion == true) {
                document.formulario_panel.submit();
              }
            }

            function confirmar(){
              var confirmacion = confirm("Esta seguro que desea conformar la aperacion");
              if (confirmacion == true) {
                document.formulario_panel.submit();
              }
            }

            function cambiarFondo(valor){

              if (valor == "t1uno" || valor == "t1dos" || valor == "t1tres" || valor == "t1cuatro") {

                var idtrue = "#"+valor;
                var idfalse = "#t1";
                var t = "t1";

                document.querySelector('#textt1_0').value = 0;
                document.querySelector('#textt1_50').value = 0;
                document.querySelector('#textt1_92').value = 0;
                document.querySelector('#textt1_100').value = 0;

                if (valor == "t1uno") {
                  document.querySelector('#textt1_0').value = 1;
                }else if (valor == "t1dos") {
                  document.querySelector('#textt1_50').value = 1;
                }else if (valor == "t1tres") {
                  document.querySelector('#textt1_92').value = 1;
                }else if (valor == "t1cuatro") {
                  document.querySelector('#textt1_100').value = 1;
                }

              }else if(valor == "t2uno" || valor == "t2dos" || valor == "t2tres" || valor == "t2cuatro"){

                var idtrue = "#"+valor;
                var idfalse = "#t2";
                var t = "t2";

                document.querySelector('#textt2_0').value = 0;
                document.querySelector('#textt2_50').value = 0;
                document.querySelector('#textt2_92').value = 0;
                document.querySelector('#textt2_100').value = 0;

                if (valor == "t2uno") {
                  document.querySelector('#textt2_0').value = 1;
                }else if (valor == "t2dos") {
                  document.querySelector('#textt2_50').value = 1;
                }else if (valor == "t2tres") {
                  document.querySelector('#textt2_92').value = 1;
                }else if (valor == "t2cuatro") {
                  document.querySelector('#textt2_100').value = 1;
                }

              }else if (valor == "t3uno" || valor == "t3dos" || valor == "t3tres" || valor == "t3cuatro") {

                var idtrue = "#"+valor;
                var idfalse = "#t3";
                var t = "t3";

                document.querySelector('#textt3_0').value = 0;
                document.querySelector('#textt3_50').value = 0;
                document.querySelector('#textt3_92').value = 0;
                document.querySelector('#textt3_100').value = 0;

                if (valor == "t3uno") {
                  document.querySelector('#textt3_0').value = 1;
                }else if (valor == "t3dos") {
                  document.querySelector('#textt3_50').value = 1;
                }else if (valor == "t3tres") {
                  document.querySelector('#textt3_92').value = 1;
                }else if (valor == "t3cuatro") {
                  document.querySelector('#textt3_100').value = 1;
                }

              }

              //uno = 0%
              //dos = 50%
              //tres = 92%
              //cuatro = 100%

              if (t == "t1") {
                document.querySelector(idfalse+"uno").className =" btn btn-primary boton";
                document.querySelector(idfalse+"dos").className =" btn btn-primary boton";
                document.querySelector(idfalse+"tres").className =" btn btn-primary boton";
                document.querySelector(idfalse+"cuatro").className =" btn btn-primary boton";
                document.querySelector(idtrue).className=" btn btn-basic boton";
                  //document.querySelector(".t3uno").className=" btn btn-basic";
                  //document.querySelector(".t3dos").className=" btn btn-primary";
              }else if (t == "t2") {
                document.querySelector(idfalse+"uno").className =" btn btn-primary boton";
                document.querySelector(idfalse+"dos").className =" btn btn-primary boton";
                document.querySelector(idfalse+"tres").className =" btn btn-primary boton";
                document.querySelector(idfalse+"cuatro").className =" btn btn-primary boton";
                document.querySelector(idtrue).className=" btn btn-basic boton";
              }else if (t == "t3") {
                document.querySelector(idfalse+"uno").className =" btn btn-primary boton";
                document.querySelector(idfalse+"dos").className =" btn btn-primary boton";
                document.querySelector(idfalse+"tres").className =" btn btn-primary boton";
                document.querySelector(idfalse+"cuatro").className =" btn btn-primary boton";
                document.querySelector(idtrue).className=" btn btn-basic boton";
              }

              var t1_0 = document.querySelector('#textt1_0').value;
              var t1_50 = document.querySelector('#textt1_50').value;
              var t1_92 = document.querySelector('#textt1_92').value;
              var t1_100 = document.querySelector('#textt1_100').value;

              var t2_0 = document.querySelector('#textt2_0').value;
              var t2_50 = document.querySelector('#textt2_50').value;
              var t2_92 = document.querySelector('#textt2_92').value;
              var t2_100 = document.querySelector('#textt2_100').value;

              var t3_0 = document.querySelector('#textt3_0').value;
              var t3_50 = document.querySelector('#textt3_50').value;
              var t3_92 = document.querySelector('#textt3_92').value;
              var t3_100 = document.querySelector('#textt3_100').value;

              if (t1_0 == 1 && t2_92 == 1 && t3_92 == 1) {
                  document.querySelector("#pie").innerHTML = "44,0 m";
              }else if (t1_50 == 1 && t2_100 == 1 && t3_100 == 1) {
                  document.querySelector("#pie").innerHTML = "52,9 m";
              }else if (t1_92 == 1 && t2_92 == 1 && t3_92 == 1) {
                  document.querySelector("#pie").innerHTML = "56,4 m";
              }else if (t1_100 == 1 && t2_100 == 1 && t3_100 == 1) {
                  document.querySelector("#pie").innerHTML = "60 m";
              }else if (t1_92 == 1 && t2_92 == 1 && t3_0 == 1) {
                  document.querySelector("#pie").innerHTML = "44,0 m";
              }else if (t1_92 == 1 && t2_92 == 1 && t3_50 == 1) {
                  document.querySelector("#pie").innerHTML = "50,7 m";
              }else if (t1_92 == 1 && t2_92 == 1 && t3_92 == 1) {
                  document.querySelector("#pie").innerHTML = "56,4";
              }else if (t1_100 == 1 && t2_100 == 1 && t3_100 == 1) {
                  document.querySelector("#pie").innerHTML = "60 m";
              }else if (t1_0 == 1 && t2_0 == 1 && t3_0 == 1) {
                  document.querySelector("#pie").innerHTML = "19,3 m";
              }else if (t1_50 == 1 && t2_0 == 1 && t3_0 == 1) {
                  document.querySelector("#pie").innerHTML = "26,0 m";
              }else if (t1_92 == 1 && t2_0 == 1 && t3_0 == 1) {
                  document.querySelector("#pie").innerHTML = "31,6 m";
              }else if (t1_92 == 1 && t2_50 == 1 && t3_0 == 1) {
                  document.querySelector("#pie").innerHTML = "38,4 m";
              }

              //z.className=" btn btn-basic";
            }
        </script>
  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
</body>
</html>
<?php mysqli_close($enlace); ?>
