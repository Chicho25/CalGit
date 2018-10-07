<?php

include("include/functions_tayron.php");

/*function conexion(){

$enlace = mysqli_connect("localhost", "root", "Gamble7910", "panalock");

if (!$enlace) {
    echo "Error: No se pudo conectar a MySQL." . PHP_EOL;
    echo "errno de depuración: " . mysqli_connect_errno() . PHP_EOL;
    echo "error de depuración: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

echo "Éxito: Se realizó una conexión apropiada a MySQL! La base de datos mi_bd es genial." . PHP_EOL;
echo "Información del host: " . mysqli_get_host_info($enlace) . PHP_EOL;

return $enlace;
}*/



$ingreso = array("t1" => 3,
                 "t2" => 3,
                 "t3" => 3,
                 "descriptions"=>"3",
                 "date_time" => date("Y-m-d H:i:s"),
                  "stat" => 3);

$insert = InsertRec("events", $ingreso);

echo 'El ultimo id '.$insert;

$consulta = conexion() -> query("SELECT * FROM events");
while ($lista = $consulta -> fetch_array()) {
       echo $lista['descriptions'].'<br>';
}


mysqli_close(conexion());
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <h1>Esto es una prueba</h1>
  </body>
</html>
