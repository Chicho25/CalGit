<?php require_once('../lib_pdf/mpdf.php'); ?>
<?php require_once('funciones_reportes.php'); ?>
<?php require_once('../conexion/conexion.php'); ?>
<?php $mpdf = new mPDF('c', 'A4-L'); ?>
<?php $css = file_get_contents('css/style.css'); ?>
<?php $mpdf->writeHTML($css, 1); ?>
<?php $resultados = reporte_5($conexion2, $_POST['id_inmueble']); ?>
<?php while($li[] = $resultados->fetch_array()); ?>
<?php $html='
<header class="clearfix">
  <div id="logo">
    
  </div>
  <h1>VENTAS DE INMUEBLES</h1>

</header>
<main>
  <table>
    <thead>
      <tr>
        <th class="service">ID</th>
        <th class="desc">GRUPO</th>
        <th>INMUEBLE</th>
        <th>FECHA VENTA</th>
        <th>PRECIO</th>
        <th>CLIENTE</th>
        <th>VENDEDOR</th>
        <th>PORCENTAJE</th>
        <th>MONTO PORCENTAJE</th>
      </tr>
    </thead>
    <tbody>';

    /*   <div id="company" class="clearfix">
    <div>Grupo Calpe</div>
    <div>Av. Aquilino de la Guardia, Torre,<br />
         Ocean Business Plaza. Piso 15,<br />
         Ofic. 1504. Panamá.</div>
    <div>(+507) 340 6390</div>
    <div><a href="mailto:ventas@grupocalpe.com.pa">ventas@grupocalpe.com.pa</a></div>
  </div> */

    foreach($li as $l){
      if($l['mv_precio_venta'] == 0 && $l['monto_porcentaje'] == 0){
      $html .='';
      }else{
      $html .='<tr>
                  <td style="padding: 0" class="service">'.$l['id_inmueble'].'</td>
                  <td style="padding: 0" class="desc">'.$l['gi_nombre_grupo_inmueble'].'</td>
                  <td style="padding: 0" class="desc">'.$l['mi_nombre'].'</td>
                  <td style="padding: 0" class="desc">'.$l['fecha_venta'].'</td>
                  <td style="padding: 0" class="desc">'.number_format($l['mv_precio_venta'], 2).'</td>
                  <td style="padding: 0" class="desc">'.$l['cl_nombre'].' '.$l['cl_nombre'].'</td>
                  <td style="padding: 0" class="desc">'.$l['ven_nombre'].' '.$l['ven_apellido'].'</td>
                  <td style="padding: 0" class="desc">'.$l['cv_porcentaje_comision'].' %</td>
                  <td style="padding: 0" class="total">'.number_format($l['monto_porcentaje'], 2).'</td>
                </tr>';}}

$html .= '

    </tbody>
  </table>

</main>
<footer>
  Grupo Calpe 1.0 © 2015-16.
</footer>'; ?>
<?php $mpdf->writeHTML($html); ?>
<?php $mpdf->Output('reporte_3.pdf', 'I'); ?>
