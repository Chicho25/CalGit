<?php require_once('../lib_pdf/mpdf.php'); ?>
<?php require_once('../conexion/conexion.php'); ?>
<?php $mpdf = new mPDF('c', 'A4-L'); ?>
<?php $css = file_get_contents('css/style.css'); ?>
<?php $mpdf->writeHTML($css, 1); ?>
<?php $where =" where (1=1) "; ?>
<?php
    function dias_pasados($fecha_inicial,$fecha_final)
    {
    $dias = (strtotime($fecha_inicial)-strtotime($fecha_final))/86400;
    $dias = abs($dias); $dias = floor($dias);
    return $dias;
    }

    $contar_dias = dias_pasados($_POST['fvencimiento_inicio'],$_POST['fvencimiento_fin']);

    if (isset($_POST['fvencimiento_inicio']) && $_POST['fvencimiento_inicio'] != '') {
        $where .= " and mc.mc_fecha_vencimiento >= '".date('Y-m-d',strtotime($_POST['fvencimiento_inicio']))."'";
    }else{}
    if (isset($_POST['fvencimiento_fin']) && $_POST['fvencimiento_fin'] != '') {
        $where .= " and mc.mc_fecha_vencimiento <= '".date('Y-m-d',strtotime($_POST['fvencimiento_fin']))."'";
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
                                    '.$where.'
                                    and
                                    mc.id_proyecto = 13
                                    group by
                                    gi.gi_nombre_grupo_inmueble');
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
                                    and
                                    mi.mi_status not in(17)
                                    group by
                                    mi.mi_nombre
                                    order by 1,2 desc');
} ?>
<?php while($li[] = $resultados->fetch_array()); ?>

<?php $html='
<header class="clearfix">
  <div id="logo">

  </div>
  <h1>REPORTE DE INGRESOS</h1>

  <div id="project" style="font-size:18px;">
    MARINA VISTA MAR
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
  $html .= '<table >
    <thead>
      <tr>
        <th>'.(count($li) - 1).'</th>
      </tr>
      <tr>
        <th class="service">GRUPO INMUEBLE</th>
        <th class="desc">TOTAL CUOTAS</th>
        <th class="desc">TOTAL COBRADO</th>
        <th class="desc">POR COBRAR</th>
        <th class="desc">DIARIO</th>
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
                  <td style="padding: 0" class="desc">'.number_format($l['total_cuota'], 2, ".", ",").'</td>
                  <td style="padding: 0" class="desc">'.number_format($l['total_abonado'], 2, ".", ",").'</td>
                  <td style="padding: 0" class="desc">'.number_format($l['total_por_cobrar'], 2, ".", ",").'</td>
                  <td style="padding: 0" class="desc">'.number_format(($l['total_abonado']/$contar_dias), 2, ".", ",").'</td>
                </tr>';
                $t_cuotas += $l['total_cuota'];
                $t_abonado += $l['total_abonado'];
                $t_por_cobrar += $l['total_por_cobrar'];
                $t_diario += $l['total_abonado']/$contar_dias;
              }
      $html .='<tr>
                  <td style="padding: 0" class="desc"><b>Totales</b></td>
                  <td style="padding: 0" class="desc"><b>'.number_format($t_cuotas, 2, ".", ",").'</b></td>
                  <td style="padding: 0" class="desc"><b>'.number_format($t_abonado, 2, ".", ",").'</b></td>
                  <td style="padding: 0" class="desc"><b>'.number_format($t_por_cobrar, 2, ".", ",").'</b></td>
                  <td style="padding: 0" class="desc"><b>'.number_format($t_diario, 2, ".", ",").'</b></td>
                </tr>';
      $html .= '
    </tbody>
  </table>';
}else{

  $html .= '<table >
    <thead>
      <tr>
        <th>'.(count($li) - 1).'</th>
      </tr>
      <tr>
        <th class="service">GRUPO INMUEBLE</th>
        <th class="desc">INMUEBLE</th>
        <th class="desc">TOTAL CUOTAS</th>
        <th class="desc">TOTAL COBRADO</th>
        <th class="desc">POR COBRAR</th>
        <th class="desc">DIARIO</th>
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
                  <td style="padding: 0" class="desc">'.number_format($l['total_cuota'], 2, ".", ",").'</td>
                  <td style="padding: 0" class="desc">'.number_format($l['total_abonado'], 2, ".", ",").'</td>
                  <td style="padding: 0" class="desc">'.number_format($l['total_por_cobrar'], 2, ".", ",").'</td>
                  <td style="padding: 0" class="desc">'.number_format(($l['total_abonado']/$contar_dias), 2, ".", ",").'</td>
                </tr>';
                $t_cuotas += $l['total_cuota'];
                $t_abonado += $l['total_abonado'];
                $t_por_cobrar += $l['total_por_cobrar'];
                $t_diario += $l['total_abonado']/$contar_dias;
              }
      $html .='<tr>
                  <td style="padding: 0" class="desc"></td>
                  <td style="padding: 0" class="desc"><b>Totales</b></td>
                  <td style="padding: 0" class="desc"><b>'.number_format($t_cuotas, 2, ".", ",").'</b></td>
                  <td style="padding: 0" class="desc"><b>'.number_format($t_abonado, 2, ".", ",").'</b></td>
                  <td style="padding: 0" class="desc"><b>'.number_format($t_por_cobrar, 2, ".", ",").'</b></td>
                  <td style="padding: 0" class="desc"><b>'.number_format($t_diario, 2, ".", ",").'</b></td>
                </tr>';
      $html .= '
    </tbody>
  </table>';

}

$html .='
</tbody>
</table>
</main>
<footer>
  Grupo Calpe 1.0 © 2015-16.
</footer>'; ?>
<?php $mpdf->writeHTML($html); ?>
<?php $mpdf->Output('reporte_2.pdf', 'I'); ?>
