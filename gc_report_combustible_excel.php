<?php //require_once('../lib_pdf/mpdf.php'); ?>
<?php require_once('conexion/conexion.php'); ?>
<?php //$mpdf = new mPDF('c', 'A4-L'); ?>
<?php //$css = file_get_contents('css/style.css'); ?>
<?php //$mpdf->writeHTML($css, 1); ?>
<?php $whereCombus =" where (1=1) "; ?>
<?php
    function dias_pasados($fecha_inicial,$fecha_final)
    {
    $dias = (strtotime($fecha_inicial)-strtotime($fecha_final))/86400;
    $dias = abs($dias); $dias = floor($dias);
    return $dias;
    }

    $contar_dias = dias_pasados($_POST['fvencimiento_inicio'],$_POST['fvencimiento_fin']);

    if (isset($_POST['fvencimiento_inicio']) && $_POST['fvencimiento_inicio'] != '') {
        $whereCombus .= " and mb.mb_fecha >= '".date('Y-m-d',strtotime($_POST['fvencimiento_inicio']))."'";
    }else{}
    if (isset($_POST['fvencimiento_fin']) && $_POST['fvencimiento_fin'] != '') {
        $whereCombus .= " and mb.mb_fecha <= '".date('Y-m-d',strtotime($_POST['fvencimiento_fin']))."'";
    }else{}?>
<?php
if(isset($_POST['id_termino']) && $_POST['id_termino'] == 1){

$combustibles = $conexion2 -> query('select
                                      tmb.tmb_nombre,
                                      sum(mb.mb_monto) as total
                                      from movimiento_bancario mb inner join tipo_movimiento_bancario tmb on mb.id_tipo_movimiento = tmb.id_tipo_movimiento_bancario
                                      '.$whereCombus.'
                                      and
                                      tmb.id_tipo_movimiento_bancario in(19, 20, 21, 24)
                                      and
                                      mb.mb_stat in(1)
                                      group by
                                      tmb.tmb_nombre
                                      order by 1');
}else{

$combustibles = $conexion2 -> query('select
                                      tmb.tmb_nombre,
                                      mb.mb_fecha,
                                      mb.mb_monto,
                                      mb.mb_descripcion,
                                      mb.id_movimiento_bancario
                                      from movimiento_bancario mb inner join tipo_movimiento_bancario tmb on mb.id_tipo_movimiento = tmb.id_tipo_movimiento_bancario
                                      '.$whereCombus.'
                                      and
                                      tmb.id_tipo_movimiento_bancario in(19, 20, 21, 24)
                                      and
                                      mb.mb_stat in(1)
                                      order by 1');

} ?>
<?php while($co[] = $combustibles->fetch_array()); ?>

<?php $excelPrint='';

  if(isset($_POST['id_termino']) && $_POST['id_termino'] == 1){

  $excelPrint .= '<h2>Combustibles</h2>
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
                </tr>';
      $excelPrint .= '
    </tbody>
  </table>';
}else{

  $excelPrint .= '<h2>Combustibles</h2>
            <table border="1">
              <thead>
                <tr>
                  <th class="service">ID</th>
                  <th class="desc">GRUPO</th>
                  <th class="desc">FECHA</th>
                  <th class="service">DESCRIPCION</th>
                  <th class="desc">TOTAL</th>
                  <th class="desc">DIARIO</th>
                </tr>
              </thead>
              <tbody>';

    $t_combus = 0;
    $t_diario_combus = 0;
    foreach($co as $l){

      $excelPrint .='<tr>
                  <td style="padding: 0" class="desc">'.$l['id_movimiento_bancario'].'</td>
                  <td style="padding: 0" class="desc">'.$l['tmb_nombre'].'</td>
                  <td style="padding: 0" class="desc">'.$l['mb_fecha'].'</td>
                  <td style="padding: 0" class="desc">'.$l['mb_descripcion'].'</td>
                  <td style="padding: 0" class="desc">'.number_format($l['mb_monto'], 2, ".", ",").'</td>
                  <td style="padding: 0" class="desc">'.number_format($l['mb_monto'], 2, ".", ",").'</td>
                </tr>';
                $t_combus += $l['mb_monto'];
                $t_diario_combus += $l['mb_monto']/$contar_dias;
              }
      $excelPrint .='<tr>
                  <td style="padding: 0" class="desc" colspan="4"><b>Totales</b></td>
                  <td style="padding: 0" class="desc"><b>'.number_format($t_combus, 2, ".", ",").'</b></td>
                  <td style="padding: 0" class="desc"><b>'.number_format($t_diario_combus, 2, ".", ",").'</b></td>
                </tr>';
      $excelPrint .= '
    </tbody>
  </table>';

}

header('Content-Type: application/xls');
header('Content-Disposition: attachment; filename='.date('d-m-Y').'-ReporteIngreso.xls');
echo $excelPrint;
