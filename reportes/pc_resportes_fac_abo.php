<?php require_once('../lib_pdf/mpdf.php'); ?>
<?php require_once('funciones_reportes.php'); ?>
<?php require_once('../conexion/conexion.php'); ?>
<?php $mpdf = new mPDF('c', 'A4-L'); ?>
<?php $css = file_get_contents('css/style.css'); ?>
<?php $mpdf->writeHTML($css, 1); ?>

<?php $nombre_proy = $conexion2 -> query("SELECT * FROM maestro_proyectos WHERE id_proyecto =".$_POST['id_proyecto']); ?>
<?php while ($py = $nombre_proy -> fetch_array()) {
        $nombre_proyecto = $py['proy_nombre_proyecto'];
      }

      $where = "where (1=1) ";
      if ($_POST['id_proyecto'] != "") {
        $where .= " and pda.id_proyecto = ".$_POST['id_proyecto']."";
      }else{ }
      if ($_POST['fecha_v_ini'] != '') {
        $where .= " and pd.pd_fecha_vencimiento >= '".$_POST['fecha_v_ini']."' ";
      }else{ }
      if ($_POST['fecha_v_fin'] != '') {
        $where .= " and pd.pd_fecha_vencimiento <= '".$_POST['fecha_v_fin']."' ";
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

$html='
<header class="clearfix">
  <div id="logo">

  </div>
  <h1>REPORTE DE PAGOS / DOCUMENTOS</h1>

  <div id="project" style="font-size:18px;">
    '.$nombre_proyecto.'
  </div>
</header>
<main><div style="text-align: right"><b>Fecha del Reporte: '.date('d/m/Y').'</b></div>';

/*<div id="company" class="clearfix">
    <div>Grupo Calpe</div>
    <div>Av. Aquilino de la Guardia, Torre,<br />
         Ocean Business Plaza. Piso 15,<br />
         Ofic. 1504. Panamá.</div>
    <div>(+507) 340 6390</div>
    <div><a href="mailto:ventas@grupocalpe.com.pa">ventas@grupocalpe.com.pa</a></div>
  </div>*/


  $html .= '<table >
    <thead>
      <tr>
        <th>'.(count($li) - 1).'</th>
      </tr>
      <tr>
        <th class="service">NOMBRE PARTIDA</th>
        <th class="desc">PROVEEDOR</th>
        <th class="desc">FECHA VENCIMIENTO</th>
        <th class="desc">DESC. FACTURA</th>
        <th class="desc">FECHA ABONO</th>
        <th class="desc">MONOTO ABONO</th>
        <th class="desc">DESC. ABONO</th>
      </tr>
    </thead>
    <tbody>';

    $monto_abono = 0;

    foreach($li as $l){

      $html .='<tr>
                  <td style="padding: 0" class="desc">'.utf8_encode($l['nombre_partida']).'</td>
                  <td style="padding: 0" class="desc">'.utf8_encode($l['nombre_proveedor']).'</td>
                  <td style="padding: 0" class="desc">'.$l['fecha_vencimiento_factura'].'</td>
                  <td style="padding: 0" class="desc">'.utf8_encode($l['descripcion_factura']).'</td>
                  <td style="padding: 0" class="desc">'.$l['fecha_creacion_abono'].'</td>
                  <td style="padding: 0" class="desc">'.number_format($l['monto_abono'], 2, ".", ",").'</td>
                  <td style="padding: 0" class="desc">'.utf8_encode($l['descripcion_abono']).'</td>
                </tr>';

                $monto_abono += $l['monto_abono'];
              }

      $html .='<tr>
                  <td style="padding: 0" colspan="5" class="desc"><b>Totales</b></td>
                  <td style="padding: 0" class="desc"><b>'.number_format($monto_abono, 2, ".", ",").'</b></td>
                  <td style="padding: 0" class="desc"><b></b></td>
                </tr>';

$html .= '

    </tbody>
  </table>';
$html .= '</main>
<footer>
  Grupo Calpe 1.0 © 2015-16.
</footer>'; ?>
<?php $mpdf->writeHTML($html); ?>
<?php $mpdf->Output('reporte_2.pdf', 'I'); ?>
