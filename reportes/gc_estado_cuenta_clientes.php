<?php require_once('../lib_pdf/mpdf.php'); ?>
<?php require_once('funciones_reportes.php'); ?>
<?php require_once('../conexion/conexion.php'); ?>
<?php $mpdf = new mPDF('c', 'A4-L'); ?>
<?php $css = file_get_contents('css/style.css'); ?>
<?php $mpdf->writeHTML($css, 1); ?>
<?php $resultados_madre = estado_cuentas_cliente_cuotas_madre($conexion2, $_POST['id_cliente'], $_POST['fcreacion_inicio'], $_POST['fcreacion_fin'], $_POST['fvencimiento_inicio'], $_POST['fvencimiento_fin']); ?>
<?php $resultados_hija = estado_cuentas_cliente_cuotas_hija($conexion2, $_POST['id_cliente'], $_POST['fcreacion_inicio'], $_POST['fcreacion_fin']); ?>
<?php $nombre_cliente = cliente($conexion2, $_POST['id_cliente']); ?>
<?php while($cl=$nombre_cliente->fetch_array()){

            $cliente = $cl['cl_nombre'].' '.$cl['cl_apellido'];

} ?>
<?php $valor = 1; ?>
<?php while($li[] = $resultados_madre->fetch_array()); ?>

<?php while($lih[] = $resultados_hija->fetch_array()); ?>

<?php $html='
<header class="clearfix">
  <div id="logo">

  </div>
  <h1>ESTADO DE CUENTA CLIENTE</h1>
  <div id="company" class="clearfix">
    <div><img src="img/marina.jpg" width="150"></div>
    <div>Email: gerencia@vistamarmarina.com</div>
    <div>Fecha: '.date("d-m-Y").'</div>
    <div></div>
  </div>
  <div id="project" style="margin-top:-100px">
    <div><span>CLIENTE</span> '.$cliente.'</div>
  </div>
</header>
<main>
  <table>
    <thead>
      <tr>
        <th class="service">ID</th>
        <th class="service">CONCEPTO</th>
        <th class="service">TIPO</th>
        <th class="desc">NUMERO</th>
        <th>INMUEBLE</th>
        <th>EMISION</th>
        <th>VENCIMIENTO</th>
        <th>REFERENCIA</th>
        <th class="desc">DESCRIPCION</th>
        <th>DEBITO</th>
        <th>CREDITO</th>
        <th>SALDO</th>
      </tr>
    </thead>
    <tbody>';

    foreach($li as $l){
      if($l['debito'] == 0 && $l['credito'] == 0 && $l['saldo'] == 0){
      $html .='';
      }else{
      $html .='<tr>
                  <td class="desc">'.$l['id'].'</td>
                  <td class="desc">'.$l['concepto'].'</td>
                  <td class="desc">'.$l['tipo'].'</td>
                  <td class="desc">'.$l['numero'].'</td>
                  <td class="desc">'.$l['inmueble'].'</td>
                  <td class="desc">'.$l['emision'].'</td>
                  <td class="desc">'.$l['vencimiento'].'</td>
                  <td class="desc">'.$l['referencia_abono_cuota'].'</td>
                  <td class="desc">'.$l['descripcion'].'</td>
                  <td class="desc">'.number_format($l['debito'], 2).'</td>
                  <td class="desc">'.number_format($l['credito'], 2).'</td>
                  <td class="desc">'.number_format($l['saldo'], 2).'</td>
                </tr>';
                $total_debito +=$l['debito'];
                $total_credito +=$l['credito'];
                $total_cuotas += $l['saldo'];
              }
  }

  foreach($lih as $l){
      if($l['debito'] == 0 && $l['credito'] == 0 && $l['saldo'] == 0){
      $html .='';
      }else{

    $html .='<tr>
                <td class="desc">'.$l['id'].'</td>
                <td class="desc">'.$l['concepto'].'</td>
                <td class="desc">'.$l['tipo'].'</td>
                <td class="desc">'.$l['numero'].'</td>
                <td class="desc">'.$l['inmueble'].'</td>
                <td class="desc">'.$l['emision'].'</td>
                <td class="desc">'.$l['vencimiento'].'</td>
                <td class="desc">'.$l['referencia_abono_cuota'].'</td>
                <td class="desc">'.$l['descripcion'].'</td>
                <td class="desc">'.number_format($l['debito'], 2).'</td>
                <td class="desc">'.number_format($l['credito'], 2).'</td>
                <td class="desc">'.number_format($l['saldo'], 2).'</td>
              </tr>';
              $total_debito_sub +=$l['debito'];
              $total_credito_sub +=$l['credito'];
              $total_cuotas_sub += $l['saldo'];
            }

}

$debito_tt = $total_debito + $total_debito_sub;
$credito_tt = $total_credito + $total_credito_sub;
$total_tt = $debito_tt - $credito_tt;

$html .='<tr>
            <td class="service"></td>
            <td class="service"></td>
            <td class="desc"></td>
            <td class="desc"></td>
            <td class="service"></td>
            <td class="service"></td>
            <td class="desc"></td>
            <td class="desc"></td>
            <td class="total">TOTALES</td>
            <td class="total">'.number_format($total_debito + $total_debito_sub, 2).'</td>
            <td class="total">'.number_format($total_credito + $total_credito_sub, 2).'</td>
            <td class="total">'.number_format($total_tt, 2).'</td>
          </tr>';
    $html .= '</tbody>
              </table>
          </main>
          <footer>
            Grupo Calpe 1.0 © 2016-17.
          </footer>'; ?>
<?php $mpdf->writeHTML($html); ?>
<?php $mpdf->Output('reporte_1.pdf', 'I'); ?>
