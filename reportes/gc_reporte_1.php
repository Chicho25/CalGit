<?php require_once('../lib_pdf/mpdf.php'); ?>
<?php require_once('funciones_reportes.php'); ?>
<?php require_once('../conexion/conexion.php'); ?>
<?php $mpdf = new mPDF('c', 'A4'); ?>
<?php $css = file_get_contents('css/style.css'); ?>
<?php $mpdf->writeHTML($css, 1); ?>
<?php $resultados = todos_cuotas_id_contrato($conexion2, $_POST['id_contrato_ventas'], $_POST['fcreacion_inicio'], $_POST['fcreacion_fin'], $_POST['fvenc_inicio'], $_POST['fvenc_fin']); ?>
<?php $valor = 1; ?>
<?php while($li[] = $resultados->fetch_array()); ?>
<?php $html='
<header class="clearfix">
  <div id="logo">
  
  </div>
  <h1>ESTADO DE CUENTA CLIENTE</h1>
  


  <div id="project">
    <div><span>INMUEBLE</span> '.$_POST['inmueble'].'</div>
    <div><span>CLIENTE</span> '.$_POST['cliente'].'</div>
    <div><span>MODELO</span> '.$_POST['modelo'].'</div>
  </div>
</header>
<main>
  <table>
    <thead>
      <tr>
        <th class="service">TIPO DE CUOTA</th>
        <th class="service">N# CUOTA</th>
        <th class="desc">FECHA DE EMISION</th>
        <th>FECHA DE VENCIMIENTO</th>
        <th>MONTO</th>
        <th>MONTO ABONADO</th>
      </tr>
    </thead>
    <tbody>';

 /*<div id="company" class="clearfix">
    <div>Grupo Calpe</div>
    <div>Av. Aquilino de la Guardia, Torre,<br />
         Ocean Business Plaza. Piso 15,<br />
         Ofic. 1504. Panamá.</div>
    <div>(+507) 340 6390</div>
    <div><a href="mailto:ventas@grupocalpe.com.pa">ventas@grupocalpe.com.pa</a></div>
  </div>*/
    foreach($li as $l){
      if($l['mc_monto'] == 0 && $l['mc_monto_abonado'] == 0){
      $html .='';
      }else{
      $html .='<tr>
                  <td style="padding: 0" class="service">'.$l['tc_nombre_tipo_cuenta'].'</td>
                  <td style="padding: 0" class="desc">'.($valor++).'</td>
                  <td style="padding: 0" class="desc">'.$l['mc_fecha_creacion_contrato'].'</td>
                  <td style="padding: 0" class="desc">'.$l['mc_fecha_vencimiento'].'</td>
                  <td style="padding: 0" class="desc">'.number_format($l['mc_monto'], 2).'</td>
                  <td style="padding: 0" class="total">'.number_format($l['mc_monto_abonado'], 2).'</td>
                </tr>';

    }}

    $html .= '<tr>
            <td colspan="5">Costo del Inmueble</td>
            <td class="total">'.number_format(obtener_precio_contrato_venta($conexion2, $_POST['id_contrato_ventas']), 2).'</td>
          </tr>
          <tr>
            <td colspan="5">Numero de cuotas</td>
            <td class="total">'.numero_cuotas($conexion2, $_POST['id_contrato_ventas']).'</td>
          </tr>
          <tr>
            <td colspan="5">Monto Pagado</td>
            <td class="total">'.number_format(suma_cuota($conexion2, $_POST['id_contrato_ventas']), 2).'</td>
          </tr>
          <tr>
            <td colspan="5">Monto por pagar</td>
            <td class="total">'.number_format(resta_reporte_1($conexion2, $_POST['id_contrato_ventas']), 2).'</td>
          </tr>
          <tr>
            <td colspan="5" class="grand total"></td>
            <td class="grand total"></td>
          </tr>
        </tbody>
      </table>

</main>
<footer>
  Grupo Calpe 1.0 © 2015-16.
</footer>'; ?>
<?php $mpdf->writeHTML($html); ?>
<?php $mpdf->Output('reporte_1.pdf', 'I'); ?>
