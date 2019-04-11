<?php require_once('../lib_pdf/mpdf.php'); ?>
<?php require_once('../conexion/conexion.php'); ?>
<?php $mpdf = new mPDF('c', 'A4-L'); ?>
<?php $css = file_get_contents('css/style.css'); ?>
<?php $mpdf->writeHTML($css, 1); ?>
<?php $where =" where (1=1) "; ?>
<?php
$resultados = $conexion2 -> query("select
mca.monto_abonado,
mca.id,
mca.descripcion,
mca.fecha,
mca.referencia_abono_cuota,
mca.mca_id_proyecto,
gi.gi_nombre_grupo_inmueble,
gi.id_grupo_inmuebles,
mi.mi_nombre,
mc.cl_nombre,
mc.cl_apellido
from maestro_cuota_abono mca inner join grupo_inmuebles gi on mca.mca_id_grupo_inmueble = gi.id_grupo_inmuebles
							               inner join maestro_inmuebles mi on mi.id_inmueble = mca.mca_id_inmueble
                             inner join maestro_clientes mc on mc.id_cliente = mca.mca_id_cliente
where
mca.id = ".$_GET['id']);?>
<?php while($l = $resultados->fetch_array()){
        $id_recibo = $l['id'];
        $monto = $l['monto_abonado'];
        $descrip = $l['descripcion'];
        $fecha = $l['fecha'];
        $referencia = $l['referencia_abono_cuota'];
        $nombre_grupo = $l['gi_nombre_grupo_inmueble'];
        $id_grupo = $l['id_grupo_inmuebles'];
        $inmueble = $l['mi_nombre'];
        $cliente = $l['cl_nombre'].' '.$l['cl_apellido'];
        $id_proyecto = $l['mca_id_proyecto'];
      }
      if ($id_proyecto==8) {
        $imagen = '8.jpg';
      }elseif ($id_proyecto == 11) {
        $imagen = '11.jpg';
      }elseif ($id_proyecto == 14) {
        $imagen = '14.jpg';
      }elseif ($id_proyecto == 22) {
        $imagen = '22.jpg';
      }elseif ($id_proyecto == 23) {
        $imagen = '23.jpg';
      }elseif ($id_proyecto == 24) {
        $imagen = '24.jpg';
      }elseif ($id_proyecto == 27) {
        $imagen = '27.jpg';
      }elseif ($id_proyecto == 28) {
        $imagen = '28.jpg';
      }elseif ($id_proyecto == 29) {
        $imagen = '29.jpg';
      }elseif ($id_proyecto == 30) {
        $imagen = '30.jpg';
      }elseif ($id_proyecto == 31) {
        $imagen = '31.jpg';
      }
?>

<?php $html='
 <table>
 	<tr>
		<td style="text-align: center;">
<header class="clearfix">
  <div id="logo">
    <img src="../logos/'.$imagen.'" width="250">
  </div>
  <h1>RECIBO</h1>
  <div id="project" style="font-size:18px;">
    '.$nombre_grupo.'
  </div>
  <div style="text-align: right">
    <b>Fecha del Recibo: '.date('d/m/Y').'</b><br>
       Fecha de Pago: '.$fecha.'
  </div>
</header>
<main>';

$html .='
    <div style="font-size:28px; text-align: center; padding:10px;">
      N. Recibo: '.$_GET['id'].'
    </div>
    <div style="font-size:28px; text-align: center; center; padding:10px;">
      Descripcion: '.$descrip.'
    </div>
    <div style="font-size:28px; text-align: center; padding:10px;">
      Monto: '.$monto.'
    </div>
    <div style="font-size:28px; text-align: center; padding:10px;">
      Inmueble: '.$inmueble.'
    </div>
    <div style="font-size:28px; text-align: center; padding:10px;">
      Cliente: '.$cliente.'
    </div>
  </main>
<footer>
  Grupo Calpe 1.0 © 2015-19.
</footer>
</td>
<td style="text-align: center;">
<header class="clearfix">
  <div id="logo">
    <img src="../logos/'.$imagen.'" width="250">
  </div>
  <h1>RECIBO</h1>
  <div id="project" style="font-size:18px;">
    '.$nombre_grupo.'
  </div>
  <div style="text-align: right">
    <b>Fecha del Recibo: '.date('d/m/Y').'</b><br>
       Fecha de Pago: '.$fecha.'
  </div>
</header>
<main>';

$html .='
    <div style="font-size:28px; text-align: center; padding:10px;">
      N. Recibo: '.$_GET['id'].'
    </div>
    <div style="font-size:28px; text-align: center; center; padding:10px;">
      Descripcion: '.$descrip.'
    </div>
    <div style="font-size:28px; text-align: center; padding:10px;">
      Monto: '.$monto.'
    </div>
    <div style="font-size:28px; text-align: center; padding:10px;">
      Inmueble: '.$inmueble.'
    </div>
    <div style="font-size:28px; text-align: center; padding:10px;">
      Cliente: '.$cliente.'
    </div>
  </main>
<footer>
  Grupo Calpe 1.0 © 2015-19.
</footer>
</td>
</tr>
</table>
'; ?>
<?php $mpdf->writeHTML($html); ?>
<?php $mpdf->Output('reporte_2.pdf', 'I'); ?>
