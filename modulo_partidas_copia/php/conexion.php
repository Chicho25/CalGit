<?php
/**
* @author Pedro Arrieta
* @website http://evilnapsis.com
* @date 2015-11-09
**/
class Db{
	public static function connect(){

		include "conexion/conexion.php";
		return new mysqli($host,$user,$pass,$base_datos);
	}
}
?>
