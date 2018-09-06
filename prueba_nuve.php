<?php $host = "calp.000webhostapp.com"; ?>
<?php $user = "id5636475_tayron"; ?>
<?php $pass = "Calpe2018"; ?>
<?php $base_datos = "id5636475_admin_1"; ?>
<?php $conexion2 = mysqli_connect($host,$user,$pass,$base_datos) or die("Error " . mysqli_error($conexion2));?>
<?php $usuarios = $conexion2 -> query("SELECT * FROM usuarios"); ?>
<?php while ($u = $usuarios -> fetch_array()) {
            echo $u['id'].'<br>';
} ?>
