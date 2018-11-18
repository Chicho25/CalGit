<?php require_once('../lib_pdf/mpdf.php'); ?>
<?php require_once('funciones_reportes.php'); ?>
<?php require_once('../conexion/conexion.php'); ?>
<?php $mpdf = new mPDF('c', 'A4-L'); ?>
<?php $css = file_get_contents('css/style.css'); ?>
<?php $mpdf->writeHTML($css, 1); ?>
<?php $resultados2 = servicios($conexion2, $_POST['status_service'], $_POST['fecha1'], $_POST['fecha2']);
       while($lg[] = $resultados2->fetch_array());
      } ?>

<?php $html='
<header class="clearfix">
  <div id="logo">

  </div>
  <h1>LISTADO DE SERVICIOS</h1>

  <div id="project" style="font-size:18px;">
    Servicios
  </div>
</header>
<main><div style="text-align: right"><b>Fecha del Reporte: '.date('d/m/Y').'</b></div>';

  $html .= '<table >
    <thead>
      <tr>
        <th>'.(count($li) - 1).'</th>
      </tr>
      <tr>
      <th class="text-center">CLIENTE</th>
      <th class="text-center">SLIP</th>
      <th class="hidden-xs" >FECHA REGISTRO</th>
      <th class="hidden-xs" >FECHA PAGO</th>
      <th class="hidden-xs" >DESCRIPCION</th>
      <th class="hidden-xs" >MONTO A PAGAR</th>
      <th class="hidden-xs" >MONTO PAGADO</th>
      <th class="hidden-xs" >STATUS</th>
      </tr>
    </thead>
    <tbody>';

    foreach($li as $l){

      if($l['stat']==1){
          $por_pagar=$l['monto'];
          $pagado=0;
          $total_monto_a_pagar += $l['monto'];
        }elseif($l['stat']==3){
          $pagado=$l['monto'];
          $por_pagar=0;
          $total_monto_pago += $l['monto'];
        }


      $html .='<tr>
                  <td style="padding: 0" class="desc">'.$l['cl_nombre'].' '.$l['cl_apellido'].'</td>
                  <td style="padding: 0" class="desc">'.$l['mi_codigo_imueble'].'</td>
                  <td style="padding: 0" class="desc">'.$l['date_time'].'</td>
                  <td style="padding: 0" class="desc">'.$l['fecha_pago'].'</td>
                  <td style="padding: 0" class="desc">'.$l['descripcion'].'</td>
                  <td style="padding: 0" class="desc">'.number_format($por_pagar, 2, ".", ",").'</td>
                  <td style="padding: 0" class="desc">'.number_format($pagado, 2, ".", ",").'</td>
                  <td style="padding: 0" class="desc">'.$l['status_des'].'</td>
                </tr>';

              }

      $html .='<tr>
                  <td style="padding: 0" colspan="3" class="desc"><b>Totales</b></td>
                  <td style="padding: 0" class="desc"><b>'.number_format($vendido, 2, ".", ",").'</b></td>
                  <td style="padding: 0" class="desc"><b>'.number_format($reservado, 2, ".", ",").'</b></td>
                  <td style="padding: 0" class="desc"><b>'.number_format($por_vender, 2, ".", ",").'</b></td>
                  <td style="padding: 0" class="desc"><b>'.number_format($monto_cobrado, 2, ".", ",").'</b></td>
                  <td style="padding: 0" class="desc"><b>'.number_format($monto_restante, 2, ".", ",").'</b></td>
                  <td style="padding: 0" class="desc"><b>'.number_format($monto_vencido, 2, ".", ",").'</b></td>
                </tr>';

$html .= '

    </tbody>
  </table>';


$html .='
</main>
<footer>
  Grupo Calpe 1.0 © 2015-16.
</footer>'; ?>
<?php $mpdf->writeHTML($html); ?>
<?php $mpdf->Output('Servicios_Marina.pdf', 'I'); ?>
