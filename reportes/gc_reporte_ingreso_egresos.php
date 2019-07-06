<?php //require_once('../lib_pdf/mpdf.php'); ?>
<?php require_once('funciones_reportes.php'); ?>
<?php require_once('../conexion/conexion.php'); ?>
<?php //$mpdf = new mPDF('c', 'A4-L'); ?>
<?php //$css = file_get_contents('css/style.css'); ?>
<?php //$mpdf->writeHTML($css, 1);

      $where = "where (1=1) ";
      if ($_POST['fecha_a_ini'] != '') {
        $where .= " and pda.fecha >= '".date('Y-m-d',strtotime($_POST['fecha_a_ini']))."'";
      }else{ }
      if ($_POST['fecha_a_fin'] != '') {
        $where .= " and pda.fecha <= '".date('Y-m-d',strtotime($_POST['fecha_a_fin']))."'";
      }else{ }

      $sql_report_fac_abo0 = $conexion2 -> query("select
                                                  mp.p_nombre as nombre_partida,
                                                  SUM(pda.monto) as suma
                                                  from partida_documento pd inner join partida_documento_abono pda on pd.id = pda.id_partida_documento
                                                  inner join maestro_partidas mp on pd.id_partida = mp.id
                                                  $where
                                                  group by
                                                  mp.p_nombre
                                                  order by 1");


while($li0[] = $sql_report_fac_abo0 -> fetch_array());

$excelPrint = '
<h2>Egresos Agrupados</h2>
<table border="1">
    <thead>
      <tr>
        <th class="service"><b>NOMBRE PARTIDA</b></th>
        <th class="desc"><b>MONTO ABONO</b></th>
      </tr>
    </thead>
    <tbody>';

    $monto_abono = 0;

    foreach($li0 as $l){

$excelPrint .='<tr>
                  <td style="padding: 0" class="desc">'.utf8_encode($l['nombre_partida']).'</td>
                  <td style="padding: 0" class="desc">'.number_format($l['suma'], 2, ".", ",").'</td>
                </tr>';

                $monto_abono += $l['suma'];
              }

$excelPrint .='<tr>
                  <td style="padding: 0" class="desc"><b>Totales</b></td>
                  <td style="padding: 0" class="desc"><b>'.number_format($monto_abono, 2, ".", ",").'</b></td>
                </tr>
              </tbody>
            </table>';

function dias_pasados($fecha_inicial,$fecha_final)
{
$dias = (strtotime($fecha_inicial)-strtotime($fecha_final))/86400;
$dias = abs($dias); $dias = floor($dias);
return $dias;
}
$where = "where (1=1) ";
$whereServi = "where (1=1) ";
$whereCombus = " where (1=1) ";

$contar_dias = dias_pasados($_POST['fecha_a_ini'],$_POST['fecha_a_fin']);

if (isset($_POST['fecha_a_ini']) && $_POST['fecha_a_ini'] != '') {
    $where .= " and mca.fecha >= '".date('Y-m-d',strtotime($_POST['fecha_a_ini']))."'";
    $whereServi .= " and fecha_pago >= '".date('Y-m-d',strtotime($_POST['fecha_a_ini']))."'";
    $whereCombus .= " and mb.mb_fecha >= '".date('Y-m-d',strtotime($_POST['fecha_a_ini']))."'";
}else{}
if (isset($_POST['fecha_a_fin']) && $_POST['fecha_a_fin'] != '') {
    $where .= " and mca.fecha <= '".date('Y-m-d',strtotime($_POST['fecha_a_fin']))."'";
    $whereServi .= " and fecha_pago <= '".date('Y-m-d',strtotime($_POST['fecha_a_fin']))."'";
    $whereCombus .= " and mb.mb_fecha <= '".date('Y-m-d',strtotime($_POST['fecha_a_fin']))."'";
}else{}


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
                                      sum(mb.mb_monto) as total
                                      from movimiento_bancario mb inner join tipo_movimiento_bancario tmb on mb.id_tipo_movimiento = tmb.id_tipo_movimiento_bancario
                                      '.$whereCombus.'
                                      and
                                      tmb.id_tipo_movimiento_bancario in(19, 24)
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

while($li[] = $resultados->fetch_array());
while($co[] = $combustibles->fetch_array());
while($se[] = $servicios->fetch_array());

                                  $excelPrint .= '<h2>Ingresos Agrupados</h2>
                                                <table border="1">
                                                  <thead>
                                                      <tr>
                                                        <th colspan="5">Reporte Marina</th>
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
                                                    $excelPrint .='<tr>
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
                                                $excelPrint .='<tr>
                                                                <td style="padding: 0" class="desc"><b>Totales</b></td>
                                                                <td style="padding: 0" class="desc"><b>'.number_format($t_cuotas, 2, ".", ",").'</b></td>
                                                                <td style="padding: 0" class="desc"><b>'.number_format($t_abonado, 2, ".", ",").'</b></td>
                                                                <td style="padding: 0" class="desc"><b>'.number_format($t_por_cobrar, 2, ".", ",").'</b></td>
                                                                <td style="padding: 0" class="desc"><b>'.number_format($t_diario, 2, ".", ",").'</b></td>
                                                              </tr>
                                                            </tbody>
                                                        </table>

                                                      <h2>Rampa & Muelle</h2>
                                                        <table border="1">
                                                          <thead>
                                                            <tr>
                                                              <th class="service">GRUPO</th>
                                                              <th class="desc">TOTAL</th>
                                                              <th class="desc">DIARIO</th>
                                                            </tr>
                                                          </thead>
                                                          <tbody>';

                                              $t_combus = 0;
                                              $t_diario_combus = 0;
                                              foreach($co as $l){
                                                $excelPrint .='<tr>
                                                            <td style="padding: 0" class="desc">'.$l['tmb_nombre'].'</td>
                                                            <td style="padding: 0" class="desc">'.number_format($l['total'], 2, ".", ",").'</td>
                                                            <td style="padding: 0" class="desc">'.number_format($l['total']/$contar_dias, 2, ".", ",").'</td>
                                                          </tr>';
                                                          $t_combus += $l['total'];
                                                          $t_diario_combus += $l['total']/$contar_dias;
                                                        }
                                         $excelPrint .='<tr>
                                                          <td style="padding: 0" class="desc"><b>Totales</b></td>
                                                          <td style="padding: 0" class="desc"><b>'.number_format($t_combus, 2, ".", ",").'</b></td>
                                                          <td style="padding: 0" class="desc"><b>'.number_format($t_diario_combus, 2, ".", ",").'</b></td>
                                                        </tr>
                                                      </tbody>
                                                    </table>

                                              <table border="1">
                                                  <thead>
                                                      <tr>
                                                        <th colspan="3">Reporte Electricidad</th>
                                                      </tr>
                                                      <tr>
                                                      <th class="service">GRUPO</th>
                                                      <th class="desc">TOTAL</th>
                                                      <th class="desc">DIARIO</th>
                                                      </tr>
                                                  </thead>
                                                  <tbody>';

                                                  $t_servi = 0;
                                                  $t_diario_s = 0;

                                                  foreach($se as $l){
                                  $excelPrint .='<td style="padding: 0" class="desc">'.$l['nombre'].'</td>
                                                    <td style="padding: 0" class="desc">'.number_format($l['total'], 2, ".", ",").'</td>
                                                    <td style="padding: 0" class="desc">'.number_format($l['total']/$contar_dias, 2, ".", ",").'</td>
                                                  </tr>';
                                                  $t_servi += $l['total'];
                                                  $t_diario_s += $l['total']/$contar_dias;
                                                }
                                   $excelPrint .='<tr>
                                                    <td style="padding: 0" class="desc"><b>Totales</b></td>
                                                    <td style="padding: 0" class="desc"><b>'.number_format($t_servi, 2, ".", ",").'</b></td>
                                                    <td style="padding: 0" class="desc"><b>'.number_format($t_diario_s, 2, ".", ",").'</b></td>
                                                  </tr>
                                              </tbody>
                                          </table>';

header('Content-Type: application/xls');
header('Content-Disposition: attachment; filename='.date('d-m-Y').'-ReporteIngreso.xls');
echo $excelPrint;
