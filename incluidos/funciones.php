<?php
function miip() {
	return $ips = $_SERVER['REMOTE_ADDR'];
}
function aud($usuario,$accion,$descripcion,$modulo) {
$fecha=date("d-m-Y H:i:s");
$ip=miip();
$descripciones=$descripcion. " ". $accion;
$insertar = mysql_query("INSERT INTO auditoria (ID_USUARIO, DESCRIPCION, MODULO, IP_CONEXION) VALUES ('$usuario', '$descripciones','$modulo','$ip')") or die(mysql_error());
}
function errores($numero, $link, $usuario,$accion,$descripcion,$modulo){
	  if($numero=='1451'){echo '<script language="javascript">alert("No puede Eliminar este registro ya que tiene dependencia con uno o mas datos.");location.href="'.$link.'"</script>';}
	  if($numero=='1452'){echo '<script language="javascript">alert("No puede Editar este registro ya que tiene dependencia con uno o mas datos.");location.href="'.$link.'"</script>';}
	   aud($usuario,$accion,$descripcion,$modulo);};
   
/*function DMAtoAMD($cdate){
	list($day,$month,$year)=explode("/",$cdate);
	return $year."-".$month."-".$day;
}
function AMDtoDMA($cdate){
	list($year,$month,$day)=explode("-",$cdate);
	return $day."/".$month."/".$year;
}
*/function esta($var)
{
return isset_or(stripslashes($_GET[$var]),isset_or(stripslashes($_POST[$var])," "));
}
function isset_or(&$check, $alternate = NULL)
{//stripslashes es para quitar los slash del codigo
	$check=stripslashes($check);
return (isset($check)) ? (empty($check) ? $alternate : $check) : $alternate;
}

function validar_objeto($modulo,$objeto)
{
	include('../Connections/conexion.php');
	$query_rst_acceso = "SELECT campos_requerido FROM tesoreria_tipo_mov WHERE modulo= ".$modul;
	$rst_acceso = mysql_query($query_rst_acceso, $conexion) or die(mysql_error());
	$row_rst_acceso = mysql_fetch_assoc($rst_acceso);
	$totalRows_rst_acceso = mysql_num_rows($rst_acceso);
	$puede=0;
	switch ($objeto) {
    case "fecha":
        $puede=substr($row_rst_acceso['CAMPOS_REQUERIDO'],0,1);
        break;
    case "descripcion":
       $puede=substr($row_rst_acceso['CAMPOS_REQUERIDO'],1,1);
        break;
    case "cuenta":
        $puede=substr($row_rst_acceso['CAMPOS_REQUERIDO'],2,1);
        break;
	case "numero":
        $puede=substr($row_rst_acceso['CAMPOS_REQUERIDO'],3,1);
        break;
	case "numeromanual":
        $puede=substr($row_rst_acceso['CAMPOS_REQUERIDO'],4,1);
        break;
	case "lib":
        $puede=substr($row_rst_acceso['CAMPOS_REQUERIDO'],5,1);
        break;
	case "th1":
        $puede=substr($row_rst_acceso['CAMPOS_REQUERIDO'],6,1);
        break;
	case "th2":
        $puede=substr($row_rst_acceso['CAMPOS_REQUERIDO'],7,1);
        break;
	case "th3":
        $puede=substr($row_rst_acceso['CAMPOS_REQUERIDO'],8,1);
        break;
	case "th4":
        $puede=substr($row_rst_acceso['CAMPOS_REQUERIDO'],9,1);
        break;
}
return $puede;

	}
	
function validador($menu,$usuario,$acceso)
{
	    
	include('../Connections/conexion.php');
	$query_rst_acceso = "SELECT DETALLE_ACCESO FROM vista_usuarios_acceso WHERE ID_USUARIO= ".$usuario." AND ID_MENU= ".$menu;
	$rst_acceso = mysql_query($query_rst_acceso, $conexion) or die(mysql_error());
	$row_rst_acceso = mysql_fetch_assoc($rst_acceso);
	$totalRows_rst_acceso = mysql_num_rows($rst_acceso);
	$puede=0;
	switch ($acceso) {
    case "view":
        $puede=substr($row_rst_acceso['DETALLE_ACCESO'],0,1);
        break;
    case "inc":
       $puede=substr($row_rst_acceso['DETALLE_ACCESO'],1,1);
        break;
    case "edi":
        $puede=substr($row_rst_acceso['DETALLE_ACCESO'],2,1);
        break;
	case "eli":
        $puede=substr($row_rst_acceso['DETALLE_ACCESO'],3,1);
        break;

}
return $puede;

	}
	
	function validador1($menu,$usuario,$acceso)
{
	    
	include('../Connections/conexion.php');
	$query_rst_acceso = "SELECT DETALLE_ACCESO FROM vista_usuarios_acceso WHERE ID_USUARIO= ".$usuario." AND ID_MENU= ".$menu;
	
	//echo $query_rst_acceso;
	$rst_acceso = mysql_query($query_rst_acceso, $conexion) or die(mysql_error());
	$row_rst_acceso = mysql_fetch_assoc($rst_acceso);
	$totalRows_rst_acceso = mysql_num_rows($rst_acceso);
	$puede=0;
	switch ($acceso) {
    case "view":
        $puede=substr($row_rst_acceso['DETALLE_ACCESO'],0,1);
        break;
    case "inc":
       $puede=substr($row_rst_acceso['DETALLE_ACCESO'],1,1);
        break;
    case "edi":
        $puede=substr($row_rst_acceso['DETALLE_ACCESO'],2,1);
        break;
	case "eli":
        $puede=substr($row_rst_acceso['DETALLE_ACCESO'],3,1);
        break;
	case "oth":
        $puede=substr($row_rst_acceso['DETALLE_ACCESO'],4,1);
        break;
	case "lib":
        $puede=substr($row_rst_acceso['DETALLE_ACCESO'],5,1);
        break;
	case "th2":
        $puede=substr($row_rst_acceso['DETALLE_ACCESO'],6,1);
        break;
	case "th2":
        $puede=substr($row_rst_acceso['DETALLE_ACCESO'],7,1);
        break;
	case "th3":
        $puede=substr($row_rst_acceso['DETALLE_ACCESO'],8,1);
        break;
	case "th4":
        $puede=substr($row_rst_acceso['DETALLE_ACCESO'],9,1);
        break;
	case "th5":
        $puede=substr($row_rst_acceso['DETALLE_ACCESO'],10,1);
        break;
	case "tr6":
        $puede=substr($row_rst_acceso['DETALLE_ACCESO'],11,1);
        break;
	case "th7":
        $puede=substr($row_rst_acceso['DETALLE_ACCESO'],12,1);
        break;
	case "th8":
        $puede=substr($row_rst_acceso['DETALLE_ACCESO'],13,1);
        break;
	case "th9":
        $puede=substr($row_rst_acceso['DETALLE_ACCESO'],14,1);
        break;
	case "th10":
        $puede=substr($row_rst_acceso['DETALLE_ACCESO'],15,1);
        break;
	case "th11":
        $puede=substr($row_rst_acceso['DETALLE_ACCESO'],16,1);
        break;
	case "tr12":
        $puede=substr($row_rst_acceso['DETALLE_ACCESO'],17,1);
        break;
	case "th13":
        $puede=substr($row_rst_acceso['DETALLE_ACCESO'],18,1);
        break;
	case "th14":
        $puede=substr($row_rst_acceso['DETALLE_ACCESO'],19,1);
        break;
	case "tr15":
        $puede=substr($row_rst_acceso['DETALLE_ACCESO'],20,1);
        break;

}
return $puede;

	}

	
	function cheking($rol, $acceso)
{
	    
	include('../Connections/conexion.php');
	$query_rst_acceso = "SELECT DISTINCT DETALLE_ACCESO FROM vista_usuarios_roles WHERE ID_ROLE=".$rol;
	$rst_acceso = mysql_query($query_rst_acceso, $conexion) or die(mysql_error());
	$row_rst_acceso = mysql_fetch_assoc($rst_acceso);
	$totalRows_rst_acceso = mysql_num_rows($rst_acceso);
	$puede=0;
	switch ($acceso) {
    case "view":
        $puede=substr($row_rst_acceso['DETALLE_ACCESO'],0,1);
        break;
    case "inc":
       $puede=substr($row_rst_acceso['DETALLE_ACCESO'],1,1);
        break;
    case "edi":
        $puede=substr($row_rst_acceso['DETALLE_ACCESO'],2,1);
        break;
	case "eli":
        $puede=substr($row_rst_acceso['DETALLE_ACCESO'],3,1);
        break;
	case "oth":
        $puede=substr($row_rst_acceso['DETALLE_ACCESO'],4,1);
        break;
	case "lib":
        $puede=substr($row_rst_acceso['DETALLE_ACCESO'],5,1);
        break;
	case "th1":
        $puede=substr($row_rst_acceso['DETALLE_ACCESO'],6,1);
        break;
	case "th2":
        $puede=substr($row_rst_acceso['DETALLE_ACCESO'],7,1);
        break;
	case "th3":
        $puede=substr($row_rst_acceso['DETALLE_ACCESO'],8,1);
        break;
	case "th4":
        $puede=substr($row_rst_acceso['DETALLE_ACCESO'],9,1);
        break;
	case "th5":
        $puede=substr($row_rst_acceso['DETALLE_ACCESO'],10,1);
        break;
	case "tr6":
        $puede=substr($row_rst_acceso['DETALLE_ACCESO'],11,1);
        break;
	case "th7":
        $puede=substr($row_rst_acceso['DETALLE_ACCESO'],12,1);
        break;
	case "th8":
        $puede=substr($row_rst_acceso['DETALLE_ACCESO'],13,1);
        break;
	case "th9":
        $puede=substr($row_rst_acceso['DETALLE_ACCESO'],14,1);
        break;
	case "th10":
        $puede=substr($row_rst_acceso['DETALLE_ACCESO'],15,1);
        break;
	case "th11":
        $puede=substr($row_rst_acceso['DETALLE_ACCESO'],16,1);
        break;
	case "tr12":
        $puede=substr($row_rst_acceso['DETALLE_ACCESO'],17,1);
        break;
	case "th13":
        $puede=substr($row_rst_acceso['DETALLE_ACCESO'],18,1);
        break;
	case "th14":
        $puede=substr($row_rst_acceso['DETALLE_ACCESO'],19,1);
        break;
	case "tr15":
        $puede=substr($row_rst_acceso['DETALLE_ACCESO'],20,1);
        break;

}
return $puede;

	}
	
		function existe_cheque($cuenta,$cheque)
{
	    
	include('../Connections/conexion.php');
	mysql_select_db($database_conexion, $conexion);
$query_rst_validador = "SELECT IF(COUNT(*)>0,'Verdadero','Falso') AS EXISTE
FROM mov_banco_caja
WHERE id_cuenta_bancaria=".$cuenta."
AND tipo_pago IN (2,11)
AND numero_pago='".$cheque."'";
$rst_validador = mysql_query($query_rst_validador, $conexion) or die(mysql_error());
$row_rst_validador = mysql_fetch_assoc($rst_validador);
$totalRows_rst_validador = mysql_num_rows($rst_validador);
	
        $valor=$row_rst_validador['EXISTE'];
       
return $valor;

	}

  ?>  