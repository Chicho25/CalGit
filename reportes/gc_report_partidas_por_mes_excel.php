<?php //require_once('../lib_pdf/mpdf.php'); ?>
<?php require_once('funciones_reportes.php'); ?>
<?php require_once('../conexion/conexion.php'); ?>
<?php //$mpdf = new mPDF('c', 'A4-L'); ?>
<?php //$css = file_get_contents('css/style.css'); ?>
<?php //$mpdf->writeHTML($css, 1); ?>

<?php $nombre_proy = $conexion2 -> query("SELECT * FROM maestro_proyectos WHERE id_proyecto =".$_POST['id_proyecto']); ?>
<?php while ($py = $nombre_proy -> fetch_array()) {
        $nombre_proyecto = $py['proy_nombre_proyecto'];
      }

      $where = "where (1=1) ";
      if ($_POST['id_proyecto'] != "") {
        $where .= " and pda.id_proyecto = ".$_POST['id_proyecto']."";
      }else{ }
      if ($_POST['fecha_a_ini'] != '') {
        $where .= " and pda.fecha >= '".$_POST['fecha_a_ini']."' ";
      }else{ }
      if ($_POST['fecha_a_fin'] != '') {
        $where .= " and pda.fecha <= '".$_POST['fecha_a_fin']."' ";
      }else{ }
      if ($_POST['id_partida'] == 'todos') {

      }elseif($_POST['id_partida'] != ''){
        $where .= " and pda.id_partida = '".$_POST['id_partida']."' ";
      }

      $sql_report_fac_abo = $conexion2 -> query("select
                                                  mp.p_nombre as nombre_partida,
                                                  pd.pd_fecha_vencimiento as fecha_vencimiento_factura,
                                                  pd.pd_descripcion as descripcion_factura,
                                                  pda.fecha as fecha_creacion_abono,
                                                  pda.monto as monto_abono,
                                                  pda.descricion as descripcion_abono,
                                                  (select pro_nombre_comercial from maestro_proveedores where id_proveedores = pda.id_proveedor) as nombre_proveedor
                                                from partida_documento pd inner join partida_documento_abono pda on pd.id = pda.id_partida_documento
                                                              inner join maestro_partidas mp on pd.id_partida = mp.id
                                                  $where");

while($li[] = $sql_report_fac_abo -> fetch_array());

/*<div id="company" class="clearfix">
    <div>Grupo Calpe</div>
    <div>Av. Aquilino de la Guardia, Torre,<br />
         Ocean Business Plaza. Piso 15,<br />
         Ofic. 1504. Panamá.</div>
    <div>(+507) 340 6390</div>
    <div><a href="mailto:ventas@grupocalpe.com.pa">ventas@grupocalpe.com.pa</a></div>
  </div>*/


$excelPrint = '<table border="1">
    <thead>
      <tr>
        <th>'.(count($li) - 1).'</th>
      </tr>
      <tr>
        <th class="service"><b>NOMBRE PARTIDA</b></th>
        <th class="desc"><b>PROVEEDOR</b></th>
        <th class="desc"><b>FECHA ABONO</b></th>
        <th class="desc"><b>MONOTO ABONO</b></th>
        <th class="desc"><b>DESCRIPCION ABONO</b></th>
      </tr>
    </thead>
    <tbody>';

    $monto_abono = 0;

    foreach($li as $l){

$excelPrint .='<tr>
                  <td style="padding: 0" class="desc">'.utf8_encode($l['nombre_partida']).'</td>
                  <td style="padding: 0" class="desc">'.utf8_encode($l['nombre_proveedor']).'</td>
                  <td style="padding: 0" class="desc">'.$l['fecha_vencimiento_factura'].'</td>
                  <td style="padding: 0" class="desc">'.number_format($l['monto_abono'], 2, ".", ",").'</td>
                  <td style="padding: 0" class="desc">'.utf8_encode($l['descripcion_abono']).'</td>
                </tr>';

                $monto_abono += $l['monto_abono'];
              }

$excelPrint .='<tr>
                  <td style="padding: 0" colspan="3" class="desc"><b>Totales</b></td>
                  <td style="padding: 0" class="desc"><b>'.number_format($monto_abono, 2, ".", ",").'</b></td>
                  <td style="padding: 0" class="desc"><b></b></td>
                </tr>
              </tbody>
            </table>';

header('Content-Type: application/xls');
header('Content-Disposition: attachment; filename='.date('d-m-Y').'-ReporteIngreso.xls');
echo $excelPrint;
