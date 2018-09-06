<?php require_once('../Connections/conexion.php'); ?>
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
if (!isset($_SESSION)) {
  @session_start();
}


if (isset($_SESSION['MM_Username']) && !empty($_SESSION['MM_Username']))
{
?>
<table width="1100" border="0" align="center" cellspacing="0" cellpadding="0">
  <tr>
    <td align="right"><a href="../include/salir.php" class="ui-widget-header" style="text-decoration:none">Cerrar Sesion de <?php echo $_SESSION['n']." ".$_SESSION['a'];
?></a><a href="../include/ayudas.php"><img src="../img/Ayuda.jpg" width="32" height="32"></a></td>
  </tr>
  <tr>
<!--    <td align="center"><img src="../img/Fondo_Header1.jpg" width="990" height="140"></td>
-->  
<td align="center"  bgcolor="#71A2CF"><img src="../img/Fondo_Headernew.jpg" width="1100" height="140"></td></tr>
</table> 
<table width="1100" border="0" align="center" cellpadding="0" cellspacing="0">
</tr>	
	<tr>
		<td align="center" valign="top" bgcolor="#71A2CF">
        <?php include('css_js.php'); ?>
        <?php include('dinamic_menu.php'); ?>
        </td>
	</tr>
</table>

<?php
}
else
	{
	echo  '<script language="javascript">alert("Usted está entrando a un área restringida. Por favor utilice un usuario y una clave válidos para ingresar al Sistema.");location.href="../index.php";</script>';	
	}

?>

