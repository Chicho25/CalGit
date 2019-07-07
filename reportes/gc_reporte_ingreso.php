<?php require_once('../lib_pdf/mpdf.php'); ?>
<?php require_once('../conexion/conexion.php'); ?>
<?php $mpdf = new mPDF('c', 'A4-L'); ?>
<?php $css = file_get_contents('css/style.css'); ?>
<?php $mpdf->writeHTML($css, 1); ?>
<?php $where =" where (1=1) "; ?>
<?php $whereCombus =" where (1=1) "; ?>
<?php $whereServi  =" where (1=1) ";?>
<?php
    function dias_pasados($fecha_inicial,$fecha_final)
    {
    $dias = (strtotime($fecha_inicial)-strtotime($fecha_final))/86400;
    $dias = abs($dias); $dias = floor($dias);
    return $dias;
    }

    $contar_dias = dias_pasados($_POST['fvencimiento_inicio'],$_POST['fvencimiento_fin']);

    if (isset($_POST['fvencimiento_inicio']) && $_POST['fvencimiento_inicio'] != '') {
        $where .= " and mca.fecha >= '".date('Y-m-d',strtotime($_POST['fvencimiento_inicio']))."'";
        $whereCombus .= " and mb.mb_fecha >= '".date('Y-m-d',strtotime($_POST['fvencimiento_inicio']))."'";
        $whereServi .= " and fecha_pago >= '".date('Y-m-d',strtotime($_POST['fvencimiento_inicio']))."'";
    }else{}
    if (isset($_POST['fvencimiento_fin']) && $_POST['fvencimiento_fin'] != '') {
        $where .= " and mca.fecha <= '".date('Y-m-d',strtotime($_POST['fvencimiento_fin']))."'";
        $whereCombus .= " and mb.mb_fecha <= '".date('Y-m-d',strtotime($_POST['fvencimiento_fin']))."'";
        $whereServi .= " and fecha_pago <= '".date('Y-m-d',strtotime($_POST['fvencimiento_fin']))."'";
    }else{}?>
<?php
if(isset($_POST['id_termino']) && $_POST['id_termino'] == 1){
$resultados = $conexion2 -> query('select
                                    gi.gi_nombre_grupo_inmueble,
                                    sum(mc.mc_monto) as total_cuota,
                                    sum(mca.monto_abonado) as total_abonado,
                                    (sum(mc.mc_monto) - sum(mca.monto_abonado)) as total_por_cobrar
                                    from
                                    maestro_cuotas mc inner join maestro_cuota_abono mca on mc.id_cuota = mca.mca_id_cuota_madre
                                    				          inner join grupo_inmuebles gi on gi.id_grupo_inmuebles = mc.id_grupo
                                                      inner join maestro_inmuebles mi on mc.id_inmueble = mi.id_inmueble
                                    '.$where.'
                                    and
                                    mc.id_proyecto = 13
                                    group by
                                    gi.gi_nombre_grupo_inmueble');

$combustibles = $conexion2 -> query('select
                                      tmb.tmb_nombre,
                                      sum(mb.mb_monto) as total,
                                      tmb.id_tipo_movimiento_bancario
                                      from movimiento_bancario mb inner join tipo_movimiento_bancario tmb on mb.id_tipo_movimiento = tmb.id_tipo_movimiento_bancario
                                      '.$whereCombus.'
                                      and
                                      tmb.id_tipo_movimiento_bancario in(19, 24, 27, 28)
                                      and
                                      mb.mb_stat in(1)
                                      group by
                                      tmb.tmb_nombre
                                      order by 1');

$servicios = $conexion2 -> query('select
                                  "Electricidad" as nombre,
                                  sum(monto) as total
                                  from servicios
                                  '.$whereServi.'
                                  and
                                  stat = 3');
}else{
$resultados = $conexion2 -> query('select
                                    gi.gi_nombre_grupo_inmueble,
                                    mi.mi_nombre,
                                    sum(mc.mc_monto) as total_cuota,
                                    sum(mca.monto_abonado) as total_abonado,
                                    (sum(mc.mc_monto) - sum(mca.monto_abonado)) as total_por_cobrar
                                    from
                                    maestro_cuotas mc inner join maestro_cuota_abono mca on mc.id_cuota = mca.mca_id_cuota_madre
                                    				          inner join grupo_inmuebles gi on gi.id_grupo_inmuebles = mc.id_grupo
                                                      inner join maestro_inmuebles mi on mc.id_inmueble = mi.id_inmueble
                                    '.$where.'
                                    and
                                    mc.id_proyecto = 13
                                    group by
                                    mi.mi_nombre
                                    order by 1,2 desc');

$combustibles = $conexion2 -> query('select
                                      tmb.tmb_nombre,
                                      mb.mb_fecha,
                                      mb.mb_monto,
                                      mb.mb_descripcion,
                                      mb.id_movimiento_bancario
                                      from movimiento_bancario mb inner join tipo_movimiento_bancario tmb on mb.id_tipo_movimiento = tmb.id_tipo_movimiento_bancario
                                      '.$whereCombus.'
                                      and
                                      tmb.id_tipo_movimiento_bancario in(19, 24, 27, 28)
                                      and
                                      mb.mb_stat in(1)
                                      order by 1');

$servicios = $conexion2 -> query('select
                                  *
                                  from servicios
                                  '.$whereServi.'
                                  and
                                  stat = 3');

} ?>
<?php while($li[] = $resultados->fetch_array()); ?>
<?php while($co[] = $combustibles->fetch_array()); ?>
<?php while($se[] = $servicios->fetch_array()); ?>

<?php $html='
<header class="clearfix">
  <div id="logo">

  </div>
  <h1>REPORTE DE INGRESOS</h1>

  <div id="project" style="font-size:18px;">
    VISTA MAR MARINA
  </div>
  <div id="project" style="font-size:18px;">';

  if($_POST['id_termino'] == 1){  $html .='Resumen'; }
    elseif($_POST['id_termino'] == 2){ $html .='Detallado'; }
      else{ echo '-'; }

  $html .='</div>
</header>
<main>
<div style="text-align: right">
  <b>Fecha del Reporte: '.date('d/m/Y').'</b><br>
  Rango de Fecha: '.$_POST['fvencimiento_inicio'].' - '.$_POST['fvencimiento_fin'].'
</div>';

  if(isset($_POST['id_termino']) && $_POST['id_termino'] == 1){
  $html .= '<h2>Marina</h2>
             <table border="1">
              <thead>
                <tr>
                  <th class="service">GRUPO INMUEBLE</th>
                  <th class="desc">TOTAL </th>
                </tr>
              </thead>
              <tbody>';

    $t_cuotas = 0;
    $t_abonado = 0;
    $t_por_cobrar = 0;
    $t_diario = 0;
    $gran_total = 0;

    foreach($li as $l){
      if($l['total_abonado'] == 0){ continue; }
      $html .='<tr>
                  <td style="padding: 0" class="desc">'.$l['gi_nombre_grupo_inmueble'].'</td>
                  <td style="padding: 0" class="desc">'.number_format($l['total_abonado'], 2, ".", ",").'</td>
                </tr>';
                $t_cuotas += $l['total_cuota'];
                $t_abonado += $l['total_abonado'];
                $t_por_cobrar += $l['total_por_cobrar'];
                $t_diario += $l['total_abonado']/$contar_dias;
                $gran_total += $l['total_abonado'];
              }
###########


$t_combus = 0;
$t_diario_combus = 0;
foreach($co as $l){
$html .='<tr>
          <td style="padding: 0" class="desc">'.$l['tmb_nombre'].'</td>
          <td style="padding: 0" class="desc">'.number_format($l['total'], 2, ".", ",").'</td>
        </tr>';
    $t_combus += $l['total'];
    $t_diario_combus += $l['total']/$contar_dias;
  }
    $t_servi = 0;
    $t_diario_s = 0;
    foreach($se as $l){
      $html .='<tr>
                  <td style="padding: 0" class="desc">'.$l['nombre'].'</td>
                  <td style="padding: 0" class="desc">'.number_format($l['total'], 2, ".", ",").'</td>
                </tr>';
                $t_servi += $l['total'];
                $gran_total += $l['total'];
                $t_diario_s += $l['total']/$contar_dias;
              }


      $t_cintillo = 0;
      $t_diario_cintillo = 0;
      foreach($co as $l){
        if ($l['id_tipo_movimiento_bancario'] != 27) {
          continue;
        }
        $html .='<tr>
                    <td style="padding: 0" class="desc">'.$l['tmb_nombre'].'</td>
                    <td style="padding: 0" class="desc">'.number_format($l['total'], 2, ".", ",").'</td>
                  </tr>';
                  $t_cintillo += $l['total'];
                  $gran_total += $l['total'];
                  $t_diario_cintillo += $l['total']/$contar_dias;
                }

        $t_ele = 0;
        $t_diario_ele = 0;
        foreach($co as $l){
          if ($l['id_tipo_movimiento_bancario'] != 28) {
            continue;
          }
          $html .='<tr>
                      <td style="padding: 0" class="desc">'.$l['tmb_nombre'].'</td>
                      <td style="padding: 0" class="desc">'.number_format($l['total'], 2, ".", ",").'</td>
                    </tr>';
                    $t_ele += $l['total'];
                    $gran_total += $l['total'];
                    $t_diario_ele += $l['total']/$contar_dias;
                  }

###########
      $html .='<tr>
                  <td style="padding: 0" class="desc"><b>Totales</b></td>
                  <td style="padding: 0" class="desc"><b>'.number_format($gran_total, 2, ".", ",").'</b></td>
                </tr>';
      $html .= '
    </tbody>
  </table>';

}else{

  $html .= '<h2>Marina</h2>
  <table border="1">
    <thead>
      <tr>
        <th>'.(count($li) - 1).'</th>
      </tr>
      <tr>
        <th class="service">GRUPO INMUEBLE</th>
        <th class="desc">INMUEBLE</th>
        <th class="desc">TOTAL COBRADO</th>
      </tr>
    </thead>
    <tbody>';

    $t_cuotas = 0;
    $t_abonado = 0;
    $t_por_cobrar = 0;
    $t_diario = 0;

    foreach($li as $l){
      $html .='<tr>
                  <td style="padding: 0" class="desc">'.$l['gi_nombre_grupo_inmueble'].'</td>
                  <td style="padding: 0" class="desc">'.$l['mi_nombre'].'</td>
                  <td style="padding: 0" class="desc">'.number_format($l['total_abonado'], 2, ".", ",").'</td>
                </tr>';
                $t_cuotas += $l['total_cuota'];
                $t_abonado += $l['total_abonado'];
                $t_por_cobrar += $l['total_por_cobrar'];
                $t_diario += $l['total_abonado']/$contar_dias;
              }
      $html .='<tr>
                  <td style="padding: 0" class="desc"></td>
                  <td style="padding: 0" class="desc"><b>Totales</b></td>
                  <td style="padding: 0" class="desc"><b>'.number_format($t_abonado, 2, ".", ",").'</b></td>
                </tr>';
      $html .= '
    </tbody>
  </table>';

  $html .= '<h2>Rampa & Muelle</h2>
            <table border="1">
              <thead>
                <tr>
                  <th>'.(count($co) - 1).'</th>
                </tr>
                <tr>
                  <th class="service" style="width:360px;">GRUPO</th>
                  <th class="desc" style="width:360px;">DESCRIPCION</th>
                  <th class="desc" style="width:360px;">TOTAL</th>
                </tr>
              </thead>
              <tbody>';

    $t_combus = 0;
    $t_diario_combus = 0;
    foreach($co as $l){

      $html .='<tr>
                  <td style="padding: 0" class="desc">'.$l['tmb_nombre'].'</td>
                  <td style="padding: 0" class="desc">'.$l['mb_descripcion'].'</td>
                  <td style="padding: 0" class="desc">'.number_format($l['mb_monto'], 2, ".", ",").'</td>
                </tr>';
                $t_combus += $l['mb_monto'];
                $t_diario_combus += $l['mb_monto']/$contar_dias;
              }
      $html .='<tr>
                  <td style="padding: 0" class="desc" colspan="2"><b>Totales</b></td>
                  <td style="padding: 0" class="desc"><b>'.number_format($t_combus, 2, ".", ",").'</b></td>
                </tr>';
      $html .= '
    </tbody>
  </table>';

  $html .= '<h2>Cintillo</h2>
            <table border="1">
              <thead>
                <tr>
                  <th>'.(count($co) - 1).'</th>
                </tr>
                <tr>
                  <th class="desc" style="width:360px;">GRUPO</th>
                  <th class="service" style="width:360px;">DESCRIPCION</th>
                  <th class="desc" style="width:360px;">TOTAL</th>
                </tr>
              </thead>
              <tbody>';

    $t_cintillo = 0;
    $t_diario_cintillo = 0;
    foreach($co as $l){
        if ($l['id_tipo_movimiento_bancario'] != 28) {
          continue;
        }

      $html .='<tr>
                  <td style="padding: 0" class="desc">'.$l['tmb_nombre'].'</td>
                  <td style="padding: 0" class="desc">'.$l['mb_descripcion'].'</td>
                  <td style="padding: 0" class="desc">'.number_format($l['mb_monto'], 2, ".", ",").'</td>
                </tr>';
                $t_cintillo += $l['mb_monto'];
                $t_diario_cintillo += $l['mb_monto']/$contar_dias;
              }
      $html .='<tr>
                  <td style="padding: 0" class="desc" colspan="2"><b>Totales</b></td>
                  <td style="padding: 0" class="desc"><b>'.number_format($t_cintillo, 2, ".", ",").'</b></td>
                </tr>';
      $html .= '
    </tbody>
  </table>';

  $html .= '<h2>Electricidad</h2>
            <table border="1">
              <thead>
                <tr>
                  <th>'.(count($co) - 1).'</th>
                </tr>
                <tr>
                  <th class="desc" style="width:360px;">GRUPO</th>
                  <th class="service" style="width:360px;">DESCRIPCION</th>
                  <th class="desc" style="width:360px;">TOTAL</th>
                </tr>
              </thead>
              <tbody>';

    $t_elec = 0;
    $t_diario_elec = 0;
    foreach($co as $l){
        if ($l['id_tipo_movimiento_bancario'] != 28) {
          continue;
        }

      $html .='<tr>
                  <td style="padding: 0" class="desc">'.$l['tmb_nombre'].'</td>
                  <td style="padding: 0" class="desc">'.$l['mb_descripcion'].'</td>
                  <td style="padding: 0" class="desc">'.number_format($l['mb_monto'], 2, ".", ",").'</td>
                </tr>';
                $t_elec += $l['mb_monto'];
                $t_diario_elec += $l['mb_monto']/$contar_dias;
              }
      $html .='<tr>
                  <td style="padding: 0" class="desc" colspan="2"><b>Totales</b></td>
                  <td style="padding: 0" class="desc"><b>'.number_format($t_elec, 2, ".", ",").'</b></td>
                </tr>';
      $html .= '
    </tbody>
  </table>';

  $html .= '<h2>Servicios</h2>
            <table border="1">
              <thead>
                <tr>
                  <th>'.(count($co) - 1).'</th>
                </tr>
                <tr>
                  <th class="service" style="width:360px;">GRUPO</th>
                  <th class="desc" style="width:360px;">DESCRIPCION</th>
                  <th class="desc" style="width:360px;">TOTAL</th>
                </tr>
              </thead>
              <tbody>';

    $t_servi = 0;
    $t_diario_s = 0;
    foreach($se as $l){
      $html .='<tr>
                  <td style="padding: 0" class="desc">Electricidad</td>
                  <td style="padding: 0" class="desc">'.$l['descripcion'].'</td>
                  <td style="padding: 0" class="desc">'.number_format($l['monto'], 2, ".", ",").'</td>
                </tr>';
                $t_servi += $l['monto'];
                $t_diario_s += $l['monto']/$contar_dias;
              }
      $html .='<tr>
                  <td style="padding: 0" class="desc"></td>
                  <td style="padding: 0" class="desc"><b>Totales</b></td>
                  <td style="padding: 0" class="desc"><b>'.number_format($t_servi, 2, ".", ",").'</b></td>
                </tr>';
      $html .= '
    </tbody>
  </table>';

  $total_global = $t_servi + $t_abonado + $t_combus + $t_cintillo + $t_elec;
  $total_global_diario = $t_diario_s + $t_diario + $t_diario_combus + $t_diario_cintillo + $t_diario_elec;

  $html .= '<h2>Total Global</h2>
            <table border="1">
              <thead>
                <tr>
                  <th>1</th>
                </tr>
                <tr>
                  <th class="desc">TOTAL</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="padding: 0" class="desc">'.number_format($total_global, 2, ".", ",").'</td>
                </tr>
            </tbody>
          </table>';

}

$html .='
</main>
<footer>
  Grupo Calpe 1.0 © 2015-16.
</footer>';

if($_POST['id_formato'] == 1 ){
 $mpdf->writeHTML($html);
 $mpdf->Output('reporte_2.pdf', 'I');

}else{

header('Content-Type: application/xls');
header('Content-Disposition: attachment; filename='.date('d-m-Y').'-ReporteIngreso.xls');
echo $html;

 } ?>
