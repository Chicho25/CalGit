<?php 
if(isset($_GET['col'])){
	$ordenar=$_GET['col'];	
}
else
{
	$ordenar='col1';
}

if(isset($_GET['orden'])){
	if($_GET['orden']==1)
	{
		//$ordenar=$ordenar." ASC";
		$orden=2;
	}
	else
	{
		//$ordenar=$ordenar." DESC";
		$orden=1;
	}
}
else
{
	$orden=1;
}

/*for ($i = 1; $i <= $NUMERO_COLUMNAS; $i++) {
  ${'valor_col'.$i} = $i;
} */
/*$valor_col1=1;
$valor_col2=2;
$valor_col3=3;
$valor_col4=4;
$valor_col5=5;
$valor_col6=$_GET[$col6];
$valor_col7=$_GET[$col7];
$valor_col8=$_GET[$col8];
$valor_col9=$_GET[$col9];
$valor_col10=$_GET[$col10];
$valor_col11=$_GET[$col11];
$valor_col12=$_GET[$col12];*/

$img_orden=' <img src="../image/azbw.png" width="12" height="13" border="0" />';
$str_col='';
for ($z = 1; $z <= $NUMERO_COLUMNAS; $z++) {
	${'col'.$z} = 'col'.$z;
	//${'titulo_col'.$z} = 'titulo'.$z;
	${'valor_col'.$z} = 'valor'.$z;
	$str_col=$str_col.${'col'.$z}.'='.${'valor_col'.$z}.'&';
}

for ($i = 1; $i <= $NUMERO_COLUMNAS; $i++) {
	${'url_col'.$i}='<a title="Ordenar" href="'.$pagina.'?'.$str_col.'col='.${'col'.$i}.'&orden='.$orden.'" ';
  	${'url_col'.$i.'_1'}=' class="textos_ordenar">'.${'titulo_col'.$i}.$img_orden."</a>";
	if($ordenar=='col'.$i){
		if ($orden==2){
			$img_orden=' <img src="../image/za.png" width="12" height="13" border="0" />';
		}else{
			$img_orden=' <img src="../image/az.png" width="12" height="13" border="0" />';
		}
		${'url_col'.$i.'_1'}=' class="textos_ordenar_rojo">'.${'titulo_col'.$i}.$img_orden."</a>";
	}
	
	${'url_col'.$i}=${'url_col'.$i}.${'url_col'.$i.'_1'};
} 
//$str_col=$col1.'='.$valor_col1.'&'.$col2.'='.$valor_col2.'&'.$col3.'='.$valor_col3.'&'.$col4.'='.$valor_col4.'&'.$col5.'='.$valor_col5.'&'.$col6.'='.$valor_col6.'&'.$col7.'='.$valor_col7.'&'.$col8.'='.$valor_col8.'&'.$col9.'='.$valor_col9.'&'.$col10.'='.$valor_col10.'&'.$col11.'='.$valor_col11.'&'.$col12.'='.$valor_col12;

/*$url_col1='<a title="Ordenar" href="listado.php?'.$str_col.'&col='.$col1.'&orden='.$orden.'" ';
$url_col2='<a title="Ordenar" href="listado.php?'.$str_col.'&col='.$col2.'&orden='.$orden.'" ';
$url_col3='<a title="Ordenar" href="listado.php?'.$str_col.'&col='.$col3.'&orden='.$orden.'" ';
$url_col4='<a title="Ordenar" href="listado.php?'.$str_col.'&col='.$col4.'&orden='.$orden.'" ';
$url_col5='<a title="Ordenar" href="listado.php?'.$str_col.'&col='.$col5.'&orden='.$orden.'" ';
$url_col6='<a title="Ordenar" href="listado.php?'.$str_col.'&col='.$col6.'&orden='.$orden.'" ';
$url_col9='<a title="Ordenar" href="listado.php?'.$str_col.'&col='.$col9.'&orden='.$orden.'" ';
$url_col10='<a title="Ordenar" href="listado.php?'.$str_col.'&col='.$col10.'&orden='.$orden.'" ';
$url_col11='<a title="Ordenar" href="listado.php?'.$str_col.'&col='.$col11.'&orden='.$orden.'" ';
$url_col12='<a title="Ordenar" href="listado.php?'.$str_col.'&col='.$col12.'&orden='.$orden.'" ';*/

/*$url_col1_1=' class="textos_ordenar">'.$titulo_col1.$img_orden."</a>";
$url_col2_1=' class="textos_ordenar">'.$titulo_col2.$img_orden."</a>";
$url_col3_1=' class="textos_ordenar">'.$titulo_col3.$img_orden."</a>";
$url_col4_1=' class="textos_ordenar">'.$titulo_col4.$img_orden."</a>";
$url_col5_1=' class="textos_ordenar">'.$titulo_col5.$img_orden."</a>";
$url_col6_1=' class="textos_ordenar">'.$titulo_col6.$img_orden."</a>";
$url_col9_1=' class="textos_ordenar">'.$titulo_col9.$img_orden."</a>";
$url_col10_1=' class="textos_ordenar">'.$titulo_col10.$img_orden."</a>";
$url_col11_1=' class="textos_ordenar">'.$titulo_col11.$img_orden."</a>";
$url_col12_1=' class="textos_ordenar">'.$titulo_col12.$img_orden."</a>";*/

		
/*		if ($ordenar==2){
			 $img_orden=' <img src="../image/za.png" width="12" height="13" border="0" />';
		}else{
		
			 $img_orden=' <img src="../image/az.png" width="12" height="13" border="0" />';
		}
		$url_col1_1=' class="textos_ordenar_rojo">'.$titulo_col1.$img_orden."</a>";




switch ($ordenar) {
    case $col1:
		if ($ordenar==2){
			 $img_orden=' <img src="../image/za.png" width="12" height="13" border="0" />';
		}else{
		
			 $img_orden=' <img src="../image/az.png" width="12" height="13" border="0" />';
		}
		$url_col1_1=' class="textos_ordenar_rojo">'.$titulo_col1.$img_orden."</a>";
		
		
		
		
		
		
        break;
	case $col2:
		if ($_GET['orden']==2){
			 $img_orden=' <img src="../image/za.png" width="12" height="13" border="0" />';
		}
		if ($_GET['orden']==1){
			 $img_orden=' <img src="../image/az.png" width="12" height="13" border="0" />';
		}
		$url_col2_1=' class="textos_ordenar_rojo">'.$titulo_col2.$img_orden."</a>";
        break;
    case $col3:
		if ($_GET['orden']==2){
			 $img_orden=' <img src="../image/za.png" width="12" height="13" border="0" />';
		}
		if ($_GET['orden']==1){
			 $img_orden=' <img src="../image/az.png" width="12" height="13" border="0" />';
		}
		$url_col3_1=' class="textos_ordenar_rojo">'.$titulo_col3.$img_orden."</a>";
        break;
	case $col4:
		if ($_GET['orden']==2){
			 $img_orden=' <img src="../image/za.png" width="12" height="13" border="0" />';
		}
		if ($_GET['orden']==1){
			 $img_orden=' <img src="../image/az.png" width="12" height="13" border="0" />';
		}
		$url_col4_1=' class="textos_ordenar_rojo">'.$titulo_col4.$img_orden."</a>";
        break;
    case $col5:
		if ($_GET['orden']==2){
			 $img_orden=' <img src="../image/za.png" width="12" height="13" border="0" />';
		}
		if ($_GET['orden']==1){
			 $img_orden=' <img src="../image/az.png" width="12" height="13" border="0" />';
		}
		$url_col5_1=' class="textos_ordenar_rojo">'.$titulo_col5.$img_orden."</a>";
        break;
    case $col6:
		if ($_GET['orden']==2){
			 $img_orden=' <img src="../image/za.png" width="12" height="13" border="0" />';
		}
		if ($_GET['orden']==1){
			 $img_orden=' <img src="../image/az.png" width="12" height="13" border="0" />';
		}
		$url_col6_1=' class="textos_ordenar_rojo">'.$titulo_col6.$img_orden."</a>";
        break;
    case $col9:
		if ($_GET['orden']==2){
			 $img_orden=' <img src="../image/za.png" width="12" height="13" border="0" />';
		}
		if ($_GET['orden']==1){
			 $img_orden=' <img src="../image/az.png" width="12" height="13" border="0" />';
		}
		$url_col9_1=' class="textos_ordenar_rojo">'.$titulo_col9.$img_orden."</a>";
        break;
		    case $col10:
		if ($_GET['orden']==2){
			 $img_orden=' <img src="../image/za.png" width="12" height="13" border="0" />';
		}
		if ($_GET['orden']==1){
			 $img_orden=' <img src="../image/az.png" width="12" height="13" border="0" />';
		}
		$url_col10_1=' class="textos_ordenar_rojo">'.$titulo_col10.$img_orden."</a>";
        break;
		case $col11:
		if ($_GET['orden']==2){
			 $img_orden=' <img src="../image/za.png" width="12" height="13" border="0" />';
		}
		if ($_GET['orden']==1){
			 $img_orden=' <img src="../image/az.png" width="12" height="13" border="0" />';
		}
		$url_col11_1=' class="textos_ordenar_rojo">'.$titulo_col11.$img_orden."</a>";
        break;
		case $col12:
		if ($_GET['orden']==2){
			 $img_orden=' <img src="../image/za.png" width="12" height="13" border="0" />';
		}
		if ($_GET['orden']==1){
			 $img_orden=' <img src="../image/az.png" width="12" height="13" border="0" />';
		}
		$url_col12_1=' class="textos_ordenar_rojo">'.$titulo_col12.$img_orden."</a>";
        break;
}*/

/*$url_col1=$url_col1.$url_col1_1;
$url_col2=$url_col2.$url_col2_1;
$url_col3=$url_col3.$url_col3_1;
$url_col4=$url_col4.$url_col4_1;
$url_col5=$url_col5.$url_col5_1;
$url_col6=$url_col6.$url_col6_1;
$url_col9=$url_col9.$url_col9_1;
$url_col10=$url_col10.$url_col10_1;
$url_col11=$url_col11.$url_col11_1;
$url_col12=$url_col12.$url_col12_1;*/
?>