<?php
$_SESSION['id_factura_multi'] = $_POST['id_pago_multi'];
foreach ($_SESSION['id_factura_multi'] as $key => $value) {
      echo $value."<br>";
}

 ?>
