<?php
/**
* @author evilnapsis
* @website http://evilnapsis.com/
**/

function get_base_categories(){
	$data= array();
	$con = Db::connect();
	$query = $con->query("select * from maestro_partidas where id_categoria is NULL ");
	if($query->num_rows>0){
		while ($r=$query->fetch_array()) {
			$data[]=$r;
		}
	}
	return $data;
}

function get_cat_by_id($id){
	$data= array();
	$con = Db::connect();
	$query = $con->query("select * from maestro_partidas where id = $id ");
	if($query->num_rows>0){
		while ($r=$query->fetch_array()) {
			$data=$r;
		}
	}
	return $data;
}

function edit_btn($id){
	return "<a href=\"gc_editar_partida.php?id=$id\"><i class='glyphicon glyphicon-pencil'></i></a>";
}

function del_btn($id){
	return "<a href=\"modulo_partidas/php/actions.php?do=delete&id=$id\"><i class='glyphicon glyphicon-trash'></i></a>";
}

function get_cats_by_cat_id($id){
	$data= array();
	$con = Db::connect();
	$query = $con->query("select * from maestro_partidas where id_categoria = $id ");
	if($query->num_rows>0){
		while ($r=$query->fetch_array()) {
			$data[]=$r;
		}
	}
	return $data;
}

function list_tree_cat_id($id){
	$subs = get_cats_by_cat_id($id);
	if(count($subs)>0){
		echo "<ul>";
		foreach($subs as $s){
			echo "<li> $s[p_nombre] "." Monto (".number_format(($s['p_monto']), 2, ',', '.').") </li>";
			list_tree_cat_id($s["id"]);
		}
		echo "</ul>";
	}
}

function select_tree_cat_id($id,$level){
	$subs = get_cats_by_cat_id($id);
	if(count($subs)>0){
		foreach($subs as $s){
			echo "<option value=\"$s[id]\" > ".str_repeat("-", $level)."$s[p_nombre] </option>";
			select_tree_cat_id($s["id"],$level+1);
		}
	}
}
function selected_tree_cat_id($id,$level,$curr_id,$selected_id){
	//echo $selected_id;
	$subs = get_cats_by_cat_id($id);
	if(count($subs)>0){
		foreach($subs as $s){
			if($s["id"]!=$curr_id){
				$selected = "";
				if($s["id"]==$selected_id){ $selected= "selected"; }
				echo "<option value=\"$s[id]\" $selected>".str_repeat("-", $level)."$s[p_nombre] </option>";
				selected_tree_cat_id($s["id"],$level+1,$curr_id,$selected_id);
			}
		}
	}
}
function obtener_id($id){
	$data= array();
	$con = Db::connect();
	$sql_obtener_id = $con -> query("select id_proyecto from maestro_partidas where id = '".$id."'");
	while($lista_id = $sql_obtener_id -> fetch_array()){
				$id_obtenido = $lista_id['id_proyecto'];
	}
	return $id_obtenido;
}
function obtener_id_padre($id){
	$data= array();
	$con = Db::connect();
	$sql_obtener_id = $con -> query("select id from maestro_partidas where id = '".$id."'");
	while($lista_id = $sql_obtener_id -> fetch_array()){
				$id_obtenido = $lista_id['id'];
	}
	return $id_obtenido;

}
function suma_total($id_proyecto){
	$data= array();
  $con = Db::connect();
	$sql_obtener_suma = $con -> query("select sum(p_monto) as suma from maestro_partidas where id_proyecto = '".$id_proyecto."'");
	while($lista_suma = $sql_obtener_suma -> fetch_array()){
				$suma = $lista_suma['suma'];
	}
	return $suma;
}
?>
