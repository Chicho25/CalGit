<?php
/**
* @author pedro arrieta
*
**/
function proyectos_partidas(){

	$con = Db::connect();
	$query = $con->query("select * from maestro_partidas where id_categoria is NULL");
	if($query->num_rows>0){
		return $query;
	}

}

function get_base_categories($id_proyecto){
	$data= array();
	$con = Db::connect();
	$query = $con->query("select * from maestro_partidas where id_categoria is NULL and id = '".$id_proyecto."'");
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

function edit_btn($id, $monto, $monto_restante, $id_padre){
	return "<a href=\"copia_editar_partida.php?id=$id&monto=$monto&monto_restante=$monto_restante&id_padre=$id_padre\"><i class='glyphicon glyphicon-pencil'></i></a>";
}

function del_btn($id, $monto, $id_padre){
	return "<a href=\"modulo_partidas_copia/php/actions.php?do=delete&id=$id&monto=$monto&id_padre=$id_padre\"><i class='glyphicon glyphicon-trash'></i></a>";
}

function add_btn($id, $monto_restante){
	return "<a href=\"copia__editar_partida.php?id=$id&monto_restante=$monto_restante\"><i class='glyphicon glyphicon-plus'></i></a>";
}
function add_btn_sub($id, $monto_restante, $distribuido){
	return "<a href=\"copia_sub_agregar_partida.php?monto_restante=$monto_restante&id=$id&distribuido=$distribuido\"><i class='glyphicon glyphicon-plus'></i></a>";
}
function pagar_btn($id, $monto_restante){
	return "<a href=\"copia_registrar_documento.php?monto_restante=$monto_restante&id_partida=$id\"><i class='glyphicon glyphicon-usd'></i></a>";
}
function ver_fact_btn($id, $id_proyecto){

	$con = Db::connect();/* query principal */

	$sql = $con -> query("select
												pd.pd_fecha_emision,
												(select pro_nombre_comercial from maestro_proveedores where id_proveedores = pd.id_proveedor) as pro_nombre_comercial,
												(select ven_nombre from maestro_vendedores where id_vendedor = pd.id_vendedor) as vendedor,
												pd.pd_descripcion,
												pd.pd_monto_total,
												pd.pd_monto_abonado,
												ms.st_nombre,
												ms.st_numero,
												(select count(*) from partida_documento_abono pda where pd.id_partida = pda.id_partida) as contar,
												case pd.pd_stat
												when 13 then 'Sin pagar'
												when 14 then 'Pagado'
												when 15 then 'Abonado'
												when 16 then 'Anulado'
												end as estado,
												pd.id_proveedor,
												pd.id_partida
												from
												partida_documento pd
												inner join
												maestro_status ms on ms.st_numero = pd.pd_stat
												where
												pd.id_partida = '".$id."'");
	?>
		<!--<div style=" z-index:99; display: inline-block; float:right; position:relative; margin-right:100px; margin-top:5px;">-->

			<ul class="glyphicon glyphicon-eye-open palanca" style="color:#5c90d2;
																															margin-left:-50px;"> Ver documentos
				<li class="muestra">
					<table style="width:100%" border="1">
						<tr>
							<th>Fecha de emicion</th>
							<th>Proveedor/Vendedor</th>
							<th>Descripcion</th>
							<th>Monto asignado</th>
							<th>Monto abonado</th>
							<th>Estado</th>
							<th>Ver</th>
							<th>Pagar</th>
						</tr>
						<?php while($p=$sql->fetch_array()){ /* mostrar este contenido de bajo de la indicacion de la partida */?>
						<tr>
							<td><?php echo date("d-m-Y", strtotime($p['pd_fecha_emision'])); ?></td>
							<td><?php if($p['pro_nombre_comercial'] != ''){ echo $p['pro_nombre_comercial']; }elseif($p['vendedor']!=''){ echo $p['vendedor']; } ?></td>
							<td><?php echo $p['pd_descripcion']; ?></td>
							<td><?php echo number_format($p['pd_monto_total'], 2, ',','.'); ?></td>
							<td><?php echo number_format($p['pd_monto_abonado'], 2, ',','.'); ?></td>
							<td><?php echo $p['estado']; ?></td>
							<td><?php  if($p['contar']!=0){?>
								<a class="glyphicon glyphicon-eye-open" style="font-size:18px;" href="gc_emitir_pago_2.php?id_proyecto=<?php echo $id_proyecto; ?>&id_proveedor=<?php echo $p['id_proveedor']; ?>"></a> <?php } ?>
							</td>
							<td><?php  if($p['st_numero']==13 || $p['st_numero']==15){?>
								<a class="fa fa-money" style="font-size:18px;" href="gc_emitir_pago_2.php?id_proyecto=<?php echo $id_proyecto; ?>&id_proveedor=<?php echo $p['id_proveedor']; ?>"></a> <?php } ?>
							</td>
						</tr>
						<?php } ?>
					</table>
				</li>
			</ul>

		<!--</div>-->
<?php }

function desplegar_datos($sql){

  while($p=$sql->fetch_array()){
	 return "<tr>
						<td>".$p['nombre']."</td>
						<td>".$p['pd_fecha_emision']."</td>
						<td>".$p['pd_fecha_vencimiento']."</td>
						<td>".$p['pd_monto_total']."</td>
						<td>".$p['estado']."</td>
					</tr>";
	 }

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

function validacion_boton($id){
		$con = Db::connect();
		$sql = $con -> query("select count(*) as contar from maestro_partidas where id_categoria = '".$id."'");
		while($l = $sql -> fetch_array()){
			if($l['contar']>=1){
				return true;
			}else{
				return false;
			}
		}
}
/* #################### funcion principal del arbol de partidas#################### */
/* #################### Validaciones, botones, llamado a subfunciones ############# */
function list_tree_cat_id_desabilitado($id){
	$subs = get_cats_by_cat_id($id);
	if(count($subs)>0){
		echo "<ul>";
		foreach($subs as $s){

			$monto = $s["p_monto"];
			$suma_pagada = suma_reservada($s['id']);
			$monto_restante_padre = monto_restante_padre($s['id']);

			switch ($suma_pagada){
					case 0:
						$suma_pagada = suma_documento_partida($s['id']);
					break;
			}

			$monto_restante = $monto - $suma_pagada;
      /* Proceso del arbolde partida, validacion, botones habilitar y deshabilitar */
			echo "<li> $s[p_nombre] "." || ".number_format($monto, 2, '.', ',')."
																	|| ".number_format($suma_pagada, 2, '.', ',')."
																	|| ".number_format($monto_restante, 2, '.', ',')."
																	|| ".number_format((($suma_pagada*100)/$monto), 2, '.', ',')."
																		 ".(($monto_restante !=0 && validacion_facturas($s['id'])==true)? add_btn_sub($s['id'], $monto_restante): " ")."
																		 ".edit_btn($s['id'], $monto, $monto_restante_padre)."
																		 ".((validacion_boton($s['id'])==false && validacion_facturas($s['id'])==true)? del_btn($s['id']):" ")."
																		 ".((validacion_boton($s['id'])==false && $monto_restante!=0)? pagar_btn($s['id'], $monto_restante):" ")."
																		 "./*((validacion_facturas($s['id'])==false)? ver_fact_btn($s['id']): " ")*/" "."</li>";


			list_tree_cat_id($s["id"]);
			echo "".((validacion_facturas($s['id'])==false)? ver_fact_btn($s['id'], $s['id_proyecto']): " ")."</li>";
		}
		echo "</ul>";
	}
}

function list_tree_cat_id($id){
	$subs = get_cats_by_cat_id($id);
	if(count($subs)>0){
		echo "<ul>";
		foreach($subs as $s){

			$monto_restante_padre = monto_restante_padre($s['id_padre']);

			$monto_restante_factura = $s['p_monto'] - ($s['p_reservado'] + $s['p_ejecutado']);

			echo "<li> $s[p_nombre] "." || ".number_format($s['p_monto'], 2, '.', ',')."
																	|| ".number_format($s['p_distribuido'], 2, '.', ',')."
																	|| ".number_format($s['p_reservado'], 2, '.', ',')."
																	|| ".number_format($s['p_ejecutado'], 2, '.', ',')."
																		 ".(($s['tiene_facturas'] == 0)? add_btn_sub($s['id'], $s['p_monto'], $s['p_distribuido']): " ")."
																		 ".edit_btn($s['id'], $s['p_monto'], $monto_restante_padre, $s['id_padre'])."
																		 ".((validacion_boton($s['id'])==false && validacion_facturas($s['id'])==true)? del_btn($s['id'], $s['p_monto'], $s['id_padre']):" ")."
																		 ".((validacion_boton($s['id'])==false &&
													 					   $s['p_distribuido'] == 0 &&
																			 $s['p_monto'] != $s['p_reservado'] &&
																			 $s['tiene_pagos']==0)? pagar_btn($s['id'], $monto_restante_factura):" ")."

																		 "."</li>";


			list_tree_cat_id($s["id"]);
			echo "".((validacion_facturas($s['id'])==false)? ver_fact_btn($s['id'], $s['id_proyecto']): " ")."</li>";
		}
		echo "</ul>";
	}
}

/* ################################## fin de la funcion principal del arbol de partidas ##################################### */
function monto_restante_padre($id){
	$con = Db::connect();
	$sql = $con -> query("select
													p_monto
												from
													maestro_partidas
												where
												  id = '".$id."'");
	while($monto = $sql -> fetch_array()){
		return $monto['p_monto'];
	}

}

function suma_documento_partida($id){
	$con = Db::connect();
	$sql = $con -> query("select sum(pd_monto_total) as sumar from partida_documento where id_partida = '".$id."'");
	while($suma = $sql -> fetch_array()){
		return $suma['sumar'];
	}
}

function validacion_facturas($id){

	$con = Db::connect();
	$sql = $con -> query("select count(*) as contar from partida_documento where id_partida = '".$id."'");
			while ($a=$sql->fetch_array()){
				$conteo = $a['contar'];
			}
			  switch ($conteo) {
			  	case 0:
			  		return true;
			  		break;

			  	default:
			  		return false;
			  		break;
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
  $con = Db::connect();
	$sql_obtener_suma = $con -> query("select sum(p_monto) as suma from maestro_partidas where id_padre = '".$id_proyecto."'");
	while($lista_suma = $sql_obtener_suma -> fetch_array()){
				$suma = $lista_suma['suma'];
	}
	return $suma;
}

function suma_pagada($id_proyecto){
	$data= array();
  $con = Db::connect();
	$sql_obtener_suma = $con -> query("select sum(mb_monto) as suma from movimiento_bancario where id_proyecto = '".$id_proyecto."'");
	while($lista_suma = $sql_obtener_suma -> fetch_array()){
				$suma = $lista_suma['suma'];
	}
	return $suma;
}

function suma_pagada_partida($id_partida){
  $con = Db::connect();
	$sql_obtener_suma = $con -> query("select sum(mb_monto) as suma from movimiento_bancario where id_partida = '".$id_partida."'");
	while($lista_suma = $sql_obtener_suma -> fetch_array()){
				$suma = $lista_suma['suma'];
	}
	return $suma;
}

function suma_reservada($id_padre){
  $con = Db::connect();
	$sql_obtener_suma = $con -> query("select sum(p_monto) as suma from maestro_partidas where id_padre = '".$id_padre."'");
	while($lista_suma = $sql_obtener_suma -> fetch_array()){
				$suma = $lista_suma['suma'];
	}
	return $suma;
}

?>

<?php /* ######################## cuando el usuario no sea de genencia #############################*/ ?>
<?php function list_tree_cat_id_admin($id){

	$subs = get_cats_by_cat_id($id);
	if(count($subs)>0){
		echo "<ul>";
		foreach($subs as $s){

			$monto_restante_padre = monto_restante_padre($s['id_padre']);

			$monto_restante_factura = $s['p_monto'] - ($s['p_reservado'] + $s['p_ejecutado']);

			echo "<li> $s[p_nombre] "." || ".number_format($s['p_monto'], 2, ',', '.')."
																	|| ".number_format($s['p_distribuido'], 2, ',', '.')."
																	|| ".number_format($s['p_reservado'], 2, ',', '.')."
																	|| ".number_format($s['p_ejecutado'], 2, ',', ' ')."
																		 ".(($s['tiene_facturas'] == 0)? add_btn_sub_admin($s['id'], $s['p_monto'], $s['p_distribuido']): " ")."
																		 ".edit_btn_admin($s['id'], $s['p_monto'], $monto_restante_padre, $s['id_padre'])."
																		 ".((validacion_boton($s['id'])==false && validacion_facturas($s['id'])==true)? del_btn_admin($s['id'], $s['p_monto'], $s['id_padre']):" ")."
																		 ".((validacion_boton($s['id'])==false &&
																			 $s['p_distribuido'] == 0 &&
																			 $s['p_monto'] != $s['p_reservado'] &&
																			 $s['tiene_pagos']==0)? pagar_btn($s['id'], $monto_restante_factura):" ")."

																		 "."</li>";


			list_tree_cat_id_admin($s["id"]);
			echo "".((validacion_facturas($s['id'])==false)? ver_fact_btn($s['id'], $s['id_proyecto']): " ")."</li>";
		}
		echo "</ul>";
	}
} ?>
<?php

function add_btn_sub_admin($id, $monto_restante, $otro){
	return " ";

}

function del_btn_admin($id, $otro, $otro2){
	return " ";
}

function edit_btn_admin($s, $s2, $monto_restante_padre, $s3){
	return " ";
}
