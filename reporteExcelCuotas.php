<?php if(!isset($_SESSION)){session_start();}?>
<?php require("conexion/conexion.php"); ?>
<?php require("funciones/funciones.php");

$_SESSION['id_cuota'];
$_SESSION['id_proyecto'];
$_SESSION['id_cliente'];
$_SESSION['id_contrato'];
$_SESSION['id_ginmueble'];
$_SESSION['id_inmueble'];
$_SESSION['fdoc_inicio'];
$_SESSION['fdoc_fin'];
$_SESSION['fven_inicio'];
$_SESSION['fven_fin'];
$_SESSION['status'];

$wh = "";

if(isset($_SESSION['submitFilters']))
{
    //si el id de cuota existe, negar todos los otros filtros
    if($_SESSION['id_cuota'] != ""){
        $wh .= "AND mc.id_cuota = " . mysqli_real_escape_string($conexion2, $_SESSION['id_cuota']);
    }else{
        if($_SESSION['id_proyecto'] != "") $wh .= "AND mc.id_proyecto = " .  mysqli_real_escape_string($conexion2, $_SESSION['id_proyecto']) ." ";
        if($_SESSION['id_ginmueble'] != "") $wh .= "AND mc.id_grupo = " . mysqli_real_escape_string($conexion2, $_SESSION['id_ginmueble']) . " ";
        if($_SESSION['id_inmueble'] != "") $wh .= "AND mc.id_inmueble = " . mysqli_real_escape_string($conexion2, $_SESSION['id_inmueble']) . " ";
        if($_SESSION['id_cliente'] != "") $wh .= "AND mv.id_cliente = " . mysqli_real_escape_string($conexion2, $_SESSION['id_cliente']) . " ";
        if($_SESSION['status'] != ""){
          $s = $_SESSION['status'];
          echo $s;
          if($s == 0) $wh .= "AND mc.mc_monto = mc.mc_monto_abonado ";
          elseif($s == 1) $wh .= "AND mc.mc_monto_abonado < mc.mc_monto AND mc.mc_monto_abonado > 0 ";
          elseif($s == 2) $wh .= "AND mc.mc_monto_abonado = 0 ";
          elseif($s == 3) $wh .= "";
          elseif($s == 4) $wh .= " AND mc.mc_monto_abonado < mc.mc_monto AND mc.mc_monto_abonado >= 0";
        }
        if($_SESSION['fdoc_inicio'] != "" && $_SESSION['fdoc_fin'] != ""){
            $wh .= "AND mc.mc_fecha_creacion_contrato >= STR_TO_DATE('".mysqli_real_escape_string($conexion2, $_SESSION['fdoc_inicio'])."','%m/%d/%Y')
                    AND mc.mc_fecha_creacion_contrato <= STR_TO_DATE('".mysqli_real_escape_string($conexion2, $_SESSION['fdoc_fin'])."','%m/%d/%Y')" . " ";

        }
        if($_SESSION['fven_inicio'] != "" && $_SESSION['fven_fin'] != ""){
            $wh .= "AND mc.mc_fecha_vencimiento >= STR_TO_DATE('".mysqli_real_escape_string($conexion2, $_SESSION['fven_inicio'])."','%m/%d/%Y')
                    AND mc.mc_fecha_vencimiento <= STR_TO_DATE('".mysqli_real_escape_string($conexion2, $_SESSION['fven_fin'])."','%m/%d/%Y')" . " ";

        }

    }

}

$tb_sql = "SELECT mc.id_cuota,
                  mc.id_contrato_venta,
                  tc.tc_nombre_tipo_cuenta,
                  tc.id_tipo_cuota,
                  mc.mc_numero_cuota,
                  mc.mc_fecha_vencimiento,
                  mc.mc_monto,
                  mc.mc_monto_abonado,
                  mc.mc_fecha_creacion_contrato,
                  mc.mc_descripcion,
                  mc.mc_numero_cuota,
                  mcl.cl_nombre,
                  mcl.cl_apellido,
                  mi.mi_nombre,
                  mc_status,
                  mv.mv_precio_venta,
                  mc.id_proyecto,
                  mp.proy_nombre_proyecto,
                  gi.id_grupo_inmuebles,
                  gi.gi_nombre_grupo_inmueble,
                  mi.mi_codigo_imueble
           FROM maestro_cuotas mc INNER JOIN tipo_cuota tc ON mc.id_tipo_cuota = tc.id_tipo_cuota
           INNER JOIN maestro_ventas mv ON mc.id_contrato_venta = mv.id_venta
           INNER JOIN maestro_clientes mcl ON mv.id_cliente = mcl.id_cliente
           INNER JOIN maestro_inmuebles mi ON mc.id_inmueble = mi.id_inmueble
           INNER JOIN maestro_proyectos mp ON mp.id_proyecto = mc.id_proyecto
           INNER JOIN grupo_inmuebles gi ON gi.id_grupo_inmuebles = mc.id_grupo
           WHERE 1 $wh
           and
           mc.mc_status not in(17)";

  $excelPrint = '<table border="1">
                  <thead>
                  <tr>
                      <th class="text-center">ID</th>
                      <th>TIPO</th>
                      <th>NUMERO</th>
                      <th class="text-center">CLIENTE</th>
                      <th class="hidden-xs" >FECHA VENCIMIENTO</th>
                      <th class="hidden-xs" >DESCRIPCION</th>
                      <th class="hidden-xs" >ESTATUS DE LA CUOTA</th>
                      <th class="hidden-xs" >MONTO DOCUMENTO</th>
                      <th class="hidden-xs" >MONTO PAGADO</th>
                  </tr>
                  </thead>
                  <tbody>';

                      $res = mysqli_query($conexion2, $tb_sql);
                      while($lista_todos_contratos_ventas = mysqli_fetch_array($res)){
                          $precio = $lista_todos_contratos_ventas['mv_precio_venta'];

                $excelPrint .= '<tr>
                      <td class="text-center">'.$lista_todos_contratos_ventas['id_cuota'].'</td>
                      <td class="font-w600">'.$lista_todos_contratos_ventas['tc_nombre_tipo_cuenta'].'</td>
                      <td class="text-center">'.$lista_todos_contratos_ventas['mc_numero_cuota'].'</td>
                      <td class="font-w600">'.$lista_todos_contratos_ventas['cl_nombre'].' '.$lista_todos_contratos_ventas['cl_apellido'].'</td>
                      <td class="hidden-xs">'.date("d-m-Y", strtotime($lista_todos_contratos_ventas['mc_fecha_vencimiento'])).'</td>
                      <td class="hidden-xs">'.$lista_todos_contratos_ventas['mc_descripcion'].'</td>
                      <td class="hidden-xs">';
                       if($lista_todos_contratos_ventas['mc_monto'] == $lista_todos_contratos_ventas['mc_monto_abonado']){ $excelPrint .=' PAGADA';
                       }elseif($lista_todos_contratos_ventas['mc_monto'] > $lista_todos_contratos_ventas['mc_monto_abonado'] &&
                                    $lista_todos_contratos_ventas['mc_monto_abonado'] > 0 ){ $excelPrint .= 'ABONADA';
                       }elseif($lista_todos_contratos_ventas['mc_monto_abonado'] == 0){  $excelPrint .='PENDIENTE/ SIN ABONAR'; }
                      $excelPrint .='</tb>
                      <td class="text-center">'.number_format($lista_todos_contratos_ventas['mc_monto'], 2, ',','.').'</td>
                      <td class="text-center">'.number_format($lista_todos_contratos_ventas['mc_monto_abonado'], 2, ',','.').'</td>';
                    }
      $excelPrint .='</tbody>
  </table>';
  header('Content-Type: application/xls');
  header('Content-Disposition: attachment; filename=cuotasReportExcel.xls');
  echo $excelPrint;
