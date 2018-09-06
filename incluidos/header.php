 <?php include('../Connections/conexion.php'); ?>
<?php include('../include/funciones.php'); ?>
<?php include('../include/_funciones.php'); ?>
<?php

@session_start();

if (isset($_SESSION['u']) && !empty($_SESSION['u']))
{
$usuario=$_SESSION['u'];
$nombre=$_SESSION['n']. " " .$_SESSION['a'];
$apellido=$_SESSION['a'];
$usuario_activo=$_SESSION['i'];

?>


<?php 
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
//Inserta el registro al momento de reservar=======OJO========
/*if ((isset($_GET["MM_insert"])) && ($_GET["MM_insert"] == "form_reserva")) {
 $insertSQL = sprintf("INSERT INTO inmuebles_mov (ID_INMUEBLES_MASTER, ID_PRO_CLI_MASTER, DESCRIPCION, BROKER, VENDEDOR,PRECIO_VENTA, FECHA, ID_TIPO) VALUES (%s, %s, %s, %s, %s, %s, %s, 2)",
                       GetSQLValueString(strtoupper ( $_GET['CODIGO_INMUEBLE_MASTER']), "int"),
                       GetSQLValueString(strtoupper ( $_GET['clientes']), "int"),
                       GetSQLValueString(strtoupper ( $_GET['descripcion']), "text"),
					   GetSQLValueString(strtoupper ( $_GET['broker']), "text"),
					   GetSQLValueString(strtoupper ( $_GET['vendedor']), "text"),
                       GetSQLValueString(strtoupper ( $_GET['precio']), "double"),
					   GetSQLValueString(DMAtoAMD( $_GET['fecha1']), "date"));
					   aud($usuario_activo,$_GET['CODIGO_INMUEBLE_MASTER'],'Reservando el inmueble ID. '.$_GET['CODIGO_INMUEBLE_MASTER'],15);
//echo $insertSQL;
  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion);
   errores(mysql_errno($conexion),"list.php",$usuario_activo,$_GET['CODIGO_INMUEBLE_MASTER'],'Reservando el inmueble ID. '.$_GET['CODIGO_INMUEBLE_MASTER'],15);

}
*/?>
<?php include('../include/css_js.php'); ?>


<body style="background-image:url(../img/Body1.jpg); background-repeat:repeat-x; font-family: 'Segoe UI'; font-size: 14px; color: #000; font-weight: bold;">
 <div align="center" id="header">
<table width="990" border="0" align="center" cellspacing="0" cellpadding="0">
  <tr>
    <td align="right"><a href="../include/salir.php" class="ui-widget-header" style="text-decoration:none">Cerrar Sesion de <?php echo $nombre;?></a><a href="../include/ayudas.php"><img src="../img/Ayuda.jpg" width="32" height="32"></a></td>
  </tr>
  <tr>
<!--    <td align="center"><img src="../img/Fondo_Header1.jpg" width="990" height="140"></td>
-->  
<td align="center"><img src="../img/Fondo_menus.png" width="990" height="5"></td></tr>
</table> 
<table width="990" border="0" align="center" cellpadding="0" cellspacing="0" class="MenuBarHorizontal">
  <tr>
    <td align="center" valign="top" bgcolor="#71A2CF">
   <?php include('dinamic_menu.php'); ?>
    </td>
  </tr>
   <tr>
    <td align="center" valign="top">
    </td>
    
  </tr>
</table>
<td align="center"><img src="../img/Fondo_menus.png" width="990" height="5"></td>
</div>
<?php
}
else
	{
	echo  '<script language="javascript">alert("Usted está entrando a un área restringida. Por favor utilice un usuario y una clave válidos para ingresar al Sistema.");location.href="../index.php";</script>';	
	}

?>

