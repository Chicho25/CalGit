<?php require_once('../lib_pdf/mpdf.php'); ?>
<?php require_once('funciones_reportes.php'); ?>
<?php require_once('../conexion/conexion.php'); ?>
<?php $mpdf = new mPDF('c', 'A4-L'); ?>
<?php $css = file_get_contents('css/style.css'); ?>
<?php $mpdf->writeHTML($css, 1); ?>
<?php $resultados = reporte_4($conexion2, $_POST['id_proyecto']); ?>
<?php while($li[] = $resultados->fetch_array()); ?>

<?php $html='
<header class="clearfix">
  <div id="logo">

  </div>
  <h1>Cobranza</h1>
  
  <div id="project">

    <div><span>PROYECTO</span> '.$_POST["nombre_proyecto"].'</div>
    <div><span>CLIENTE</span> '.$_POST["cliente"].'</div>

  </div>
</header>
<main>
  <table>
    <thead>
      <tr>
        <th class="service">TIPO DE PAGO</th>
        <th class="desc">MONTO </th>
        <th class="desc">MONTO ABONADO</th>
        <th class="desc">FECHA</th>
        <th class="desc">FECHA VENCIMIENTO</th>
      </tr>
    </thead>
    <tbody>';

    /* <div id="company" class="clearfix">
    <div>Grupo Calpe</div>
    <div>Av. Aquilino de la Guardia, Torre,<br />
         Ocean Business Plaza. Piso 15,<br />
         Ofic. 1504. Panamá.</div>
    <div>(+507) 340 6390</div>
    <div><a href="mailto:ventas@grupocalpe.com.pa">ventas@grupocalpe.com.pa</a></div>
  </div> */

      $monto = 0;
      $abonado = 0;

    foreach($li as $l){
      if($l['mc_monto'] == 0 && $l['mc_monto_abonado'] == 0){
      $html .='';
      }else{
      $html .='<tr>
                  <td style="padding: 0" class="desc">'.$l['tc_nombre_tipo_cuenta'].'</td>
                  <td style="padding: 0" class="desc">'.number_format($l['mc_monto'], 2).'</td>
                  <td style="padding: 0" class="desc">'.number_format($l['mc_monto_abonado'], 2).'</td>
                  <td style="padding: 0" class="desc">'.$l['mc_fecha_creacion_contrato'].'</td>
                  <td style="padding: 0" class="desc">'.$l['mc_fecha_vencimiento'].'</td>
                </tr>';
                $monto += $l['mc_monto'];
                $abonado += $l['mc_monto_abonado'];
              }}

$html .= '
          <tr>
            <td style="padding: 0" class="desc"></td>
            <td style="padding: 0" class="desc"></td>
            <td style="padding: 0" class="desc"></td>
            <td style="padding: 0" class="desc"></td>
            <td style="padding: 0" class="desc"></td>
          </tr>
          <tr>
            <td style="padding: 0" class="desc">Totales</td>
            <td style="padding: 0" class="desc"><b>'.number_format($monto, 2).'</b></td>
            <td style="padding: 0" class="desc"><b>'.number_format($abonado, 2).'</b></td>
            <td style="padding: 0" class="desc">Total por pagar</td>
            <td style="padding: 0" class="desc"><b>'.number_format($monto-$abonado, 2).'</b></td>
          </tr>
    </tbody>
  </table>

</main>
<footer>
  Grupo Calpe 1.0 © 2016-17.
</footer>'; ?>
<?php $mpdf->writeHTML($html); ?>
<?php $mpdf->Output('reporte_3.pdf', 'I'); ?>
