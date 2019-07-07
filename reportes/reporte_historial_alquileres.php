<?php require_once('../lib_pdf/mpdf.php'); ?>
<?php require_once('funciones_reportes.php'); ?>
<?php require_once('../conexion/conexion.php'); ?>
<?php $mpdf = new mPDF('c', 'A4-L'); ?>
<?php $css = file_get_contents('css/style.css'); ?>
<?php $mpdf->writeHTML($css, 1); ?>

<?php $nombre_proy = $conexion2 -> query("SELECT * FROM maestro_proyectos WHERE id_proyecto =".$_POST['id_proyecto']); ?>
<?php while ($py = $nombre_proy -> fetch_array()) {
        $nombre_proyecto = $py['proy_nombre_proyecto'];
      } ?>
<?php if($_POST['tipo_reporte'] == 2 and $_POST['grupo_inmueble'] ==""){
       $resultados2 = reporte_alquileres_2($conexion2, $_POST['id_proyecto']);
       while($lg[] = $resultados2->fetch_array());
      }else{ ?>
<?php $resultados = reporte_alquileres($conexion2, $_POST['id_proyecto'], $_POST['tipo_reporte'], $_POST['grupo_inmueble']); ?>
<?php while($li[] = $resultados->fetch_array()); ?>
<?php $resultados2 = reporte_alquileres_2($conexion2, $_POST['id_proyecto']); ?>
<?php while($lg[] = $resultados2->fetch_array()); ?>

<?php } ?>

<?php $html='
<header class="clearfix">
  <div id="logo">

  </div>
  <h1>HISTORIAL DE ALQUILERES INMUEBLES</h1>

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

if($_POST['tipo_reporte'] == 2 and $_POST['grupo_inmueble'] ==""){}else{

  $html .= '<table >
    <thead>
      <tr>
        <th>'.(count($li) - 1).'</th>
      </tr>
      <tr>
        <th  class="service">INMUEBLE</th>
        <th  class="desc">NOMBRE</th>
        <th  class="desc">NOMBRE DEL CLIENTE</th>
        <th  class="desc">VENDIDO</th>
        <th  class="desc">RESERVADO</th>
        <th  class="desc">POR VENDER</th>
        <th  class="desc">COBRADO</th>
        <th  class="desc">POR COBRAR</th>
        <th class="desc">VENCIDO</th>
      </tr>
    </thead>
    <tbody>';

    foreach($li as $l){
      if($l['mi_codigo_imueble']==''){continue;}
      if($l['nombre']==''){continue;}
      /*if($l['monto_vendido'] == 0 && $l['monto_restante'] == 0 && $l['monto_cobrado'] == 0 && $l['monto_restante'] == 0 && $l['monto_vencido'] == 0){
      $html .='';
    }else{*/
      $html .='<tr>
                  <td style="padding: 0" class="desc">'.$l['mi_codigo_imueble'].'</td>
                  <td style="padding: 0" class="desc">'.$l['mi_nombre'].'</td>
                  <td style="padding: 0" class="desc">'.$l['nombre'].'</td>
                  <td style="padding: 0" class="desc">'.number_format($l['monto_cobrado'], 2, ".", ",").'</td>
                  <td style="padding: 0" class="desc">'.number_format($l['monto_reservado'], 2, ".", ",").'</td>
                  <td style="padding: 0" class="desc">'.number_format($l['por_vender'], 2, ".", ",").'</td>
                  <td style="padding: 0" class="desc">'.number_format($l['monto_cobrado'], 2, ".", ",").'</td>
                  <td style="padding: 0" class="desc">'.number_format($l['monto_restante'], 2, ".", ",").'</td>
                  <td style="padding: 0" class="desc">'.number_format($l['monto_vencido'], 2, ".", ",").'</td>
                </tr>';

                $vendido += $l['monto_vendido'];
                $reservado += $l['monto_reservado'];
                $por_vender += $l['por_vender'];
                $monto_cobrado += $l['monto_cobrado'];
                $monto_restante += $l['monto_restante'];
                $monto_vencido += $l['monto_vencido'];
              }

      $html .='<tr>
                  <td style="padding: 0" colspan="3" class="desc"><b>Totales</b></td>
                  <td style="padding: 0" class="desc"><b>'.number_format($monto_cobrado, 2, ".", ",").'</b></td>
                  <td style="padding: 0" class="desc"><b>'.number_format($reservado, 2, ".", ",").'</b></td>
                  <td style="padding: 0" class="desc"><b>'.number_format($por_vender, 2, ".", ",").'</b></td>
                  <td style="padding: 0" class="desc"><b>'.number_format($monto_cobrado, 2, ".", ",").'</b></td>
                  <td style="padding: 0" class="desc"><b>'.number_format($monto_restante, 2, ".", ",").'</b></td>
                  <td style="padding: 0" class="desc"><b>'.number_format($monto_vencido, 2, ".", ",").'</b></td>
                </tr>';

$html .= '

    </tbody>
  </table>';

}
$vendido = 0; $reservado = 0; $por_vender = 0; $monto_cobrado = 0; $monto_restante = 0; $monto_vencido = 0;

$html .= '  <table>
    <thead>
      <tr>
        <th style="padding: 0" class="service">GRUPO</th>
        <th style="padding: 0" class="desc">VENDIDO</th>
        <th style="padding: 0" class="desc">RESERVADO</th>
        <th style="padding: 0" class="desc">POR VENDER</th>
        <th style="padding: 0" class="desc">COBRADO</th>
        <th style="padding: 0" class="desc">POR COBRAR</th>
        <th style="padding: 0" class="desc">VENCIDO</th>
      </tr>
    </thead>
    <tbody>';
    $cobrado = 0;
    $reservado = 0;
    $por_vender = 0;
    $restante = 0;
    $vencido = 0;
    foreach($lg as $lgg){
      if($lgg['gi_nombre_grupo_inmueble']=='' || $lgg['gi_nombre_grupo_inmueble'] == 'DIQUE SECO'){continue;}
      if($lgg['monto_cobrado']==''){continue;}
      /*if($l['monto_vendido'] == 0 && $l['monto_restante'] == 0 && $l['monto_cobrado'] == 0 && $l['monto_restante'] == 0 && $l['monto_vencido'] == 0){
      $html .='';
    }else{*/

      $html .='<tr>
                  <td style="padding: 0" class="desc">'.$lgg['gi_nombre_grupo_inmueble'].'</td>
                  <td style="padding: 0" class="desc">'.$lgg['monto_cobrado'].'</td>
                  <td style="padding: 0" class="desc">'.$lgg['monto_reservado'].'</td>
                  <td style="padding: 0" class="desc">'.$lgg['por_vender'].'</td>
                  <td style="padding: 0" class="desc">'.$lgg['monto_cobrado'].'</td>
                  <td style="padding: 0" class="desc">'.$lgg['monto_restante'].'</td>
                  <td style="padding: 0" class="desc">'.$lgg['monto_vencido'].'</td>
                </tr>';
                $cobrado += $lgg['monto_cobrado'];
                $reservado += $lgg['monto_reservado'];
                $por_vender += $lgg['por_vender'];
                $restante += $lgg['monto_restante'];
                $vencido += $lgg['monto_vencido'];
              }

      $html .='<tr>
                  <td style="padding: 0" class="desc"><b>Totales</b></td>
                  <td style="padding: 0" class="desc"><b>'.number_format($cobrado, 2, ".", ",").'</b></td>
                  <td style="padding: 0" class="desc"><b>'.$reservado.'</b></td>
                  <td style="padding: 0" class="desc"><b>'.$por_vender.'</b></td>
                  <td style="padding: 0" class="desc"><b>'.number_format($cobrado, 2, ".", ",").'</b></td>
                  <td style="padding: 0" class="desc"><b>'.$restante.'</b></td>
                  <td style="padding: 0" class="desc"><b>'.$vencido.'</b></td>
                </tr>';

$html .='
</tbody>
</table>
</main>
<footer>
  Grupo Calpe 1.0 © 2015-16.
</footer>'; ?>
<?php $mpdf->writeHTML($html); ?>
<?php $mpdf->Output('reporte_2.pdf', 'I'); ?>
