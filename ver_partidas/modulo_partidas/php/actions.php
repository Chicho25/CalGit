<?php

if(isset($_GET["do"]) && $_GET["do"]!=""){
	include "conexion.php";
	include "functions.php";
		$action = $_GET["do"];
		if($action=="new"){
			if(!empty($_POST)){
				$con = Db::connect();
				$name = $_POST["name"];
				$category_id = $_POST["id_categoria"]!=""? $_POST["id_categoria"]:"NULL";
				$id_proyecto = obtener_id($category_id);
				$id_padre = obtener_id_padre($category_id);
				$monto = $_POST["monto"]!=""? $_POST["monto"]:"NULL";
				$sql = "insert into maestro_partidas(p_nombre,id_categoria,p_monto,p_status, id_proyecto, id_padre) value (\"$name\",$category_id, $monto, 1, $id_proyecto, $id_padre)";
				$con->query($sql);
			}
			header("Location: ../../gc_partidas.php");
		}else if($action=="delete"){
			$con = Db::connect();
			$sql = "delete from maestro_partidas where id=$_GET[id]";
			$con->query($sql);
			header("Location: ../../gc_partidas.php");
		}else if($action=="update"){
			if(!empty($_POST)){
				$con = Db::connect();
				$id = $_POST["id"];
				$name = $_POST["name"];
				$category_id = $_POST["category_id"]!=""? $_POST["category_id"]:"NULL";
				$sql = "update maestro_partidas set p_nombre=\"$name\", id_categoria=$category_id where id=$id";
				$con->query($sql);
			}
			header("Location: ../../gc_partidas.php");
		}

}


?>
