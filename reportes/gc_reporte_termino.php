<?php require_once('../lib_pdf/mpdf.php'); ?>
<?php require_once('../conexion/conexion.php'); ?>
<?php $mpdf = new mPDF('c', 'A4-L'); ?>
<?php $css = file_get_contents('css/style.css'); ?>
<?php $mpdf->writeHTML($css, 1); ?>
<?php $where =" where (1=1) "; ?>
<?php

    if (isset($_POST['id_termino']) && $_POST['id_termino'] != '') {
        $where .= " and mv.termino =".$_POST['id_termino'];
    }else{}
    if (isset($_POST['fvencimiento_inicio']) && $_POST['fvencimiento_inicio'] != '') {
        $where .= " and mv.fecha_venta >= '".date('Y-m-d',strtotime($_POST['fvencimiento_inicio']))."'";
    }else{}
    if (isset($_POST['fvencimiento_fin']) && $_POST['fvencimiento_fin'] != '') {
        $where .= " and mv.fecha_venta <= '".date('Y-m-d',strtotime($_POST['fvencimiento_fin']))."'";
    }else{}

 ?>

<?php $resultados = $conexion2 -> query('select
                                          	mi.mi_codigo_imueble,
                                              mi.mi_nombre,
                                              mc.cl_nombre,
                                              mc.cl_apellido,
                                              mv.mv_precio_venta,
                                              sum(mcu.mc_monto) as cuota,
                                              sum(mcu.mc_monto_abonado) as cobrado,
                                              (sum(mcu.mc_monto) - sum(mcu.mc_monto_abonado)) as por_cobrar,
                                              mv.fecha_venta,
                                              (select sum(mc_monto) from maestro_cuotas where mv.id_venta = id_contrato_venta and mc_fecha_vencimiento > CURDATE() and mc_monto_abonado = 0) as monto_vencido
                                          from
                                          maestro_ventas mv inner join maestro_inmuebles mi on mv.id_inmueble = mi.id_inmueble
                                          				          inner join maestro_clientes mc on mv.id_cliente = mc.id_cliente
                                                            inner join maestro_cuotas mcu on mv.id_venta = mcu.id_contrato_venta
                                            '.$where.'
                                          group by
                                          	mi.mi_codigo_imueble,
                                            mi.mi_nombre,
                                            mc.cl_nombre,
                                            mc.cl_apellido,
                                            mv.mv_precio_venta,
                                            mv.fecha_venta'); ?>
<?php while($li[] = $resultados->fetch_array()); ?>


<?php $html='
<header class="clearfix">
  <div id="logo">

  </div>
  <h1>LISTADO DE VENTAS DE INMUEBLES POR TERMINO</h1>

  <div id="project" style="font-size:18px;">
    MARINA VISTA MAR
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
        <th  class="service">INMUEBLE</th>
        <th  class="desc">CODIGO</th>
        <th  class="desc">NOMBRE DEL CLIENTE</th>
        <th  class="desc">COSTO DE VENTA</th>
        <th  class="desc">TOTAL CUOTAS</th>
        <th  class="desc">COBRADO</th>
        <th  class="desc">POR COBRAR</th>
        <th  class="desc">VENCIDO</th>
        <th  class="desc">FECHA</th>
      </tr>
    </thead>
    <tbody>';

    $mv_precio_venta = 0;
    $cuota = 0;
    $cobrado = 0;
    $por_cobrar = 0;
    $monto_vencido =0;

    foreach($li as $l){
      $html .='<tr>
                  <td style="padding: 0" class="desc">'.$l['mi_nombre'].'</td>
                  <td style="padding: 0" class="desc">'.$l['mi_codigo_imueble'].'</td>
                  <td style="padding: 0" class="desc">'.$l['cl_nombre'].' '.$l['cl_apellido'].'</td>
                  <td style="padding: 0" class="desc">'.number_format($l['mv_precio_venta'], 2, ".", ",").'</td>
                  <td style="padding: 0" class="desc">'.number_format($l['cuota'], 2, ".", ",").'</td>
                  <td style="padding: 0" class="desc">'.number_format($l['cobrado'], 2, ".", ",").'</td>
                  <td style="padding: 0" class="desc">'.number_format($l['por_cobrar'], 2, ".", ",").'</td>
                  <td style="padding: 0" class="desc">'.number_format($l['monto_vencido'], 2, ".", ",").'</td>
                  <td style="padding: 0" class="desc">'.$l['fecha_venta'].'</td>
                </tr>';

                $mv_precio_venta += $l['mv_precio_venta'];
                $cuota += $l['cuota'];
                $cobrado += $l['cobrado'];
                $por_cobrar += $l['por_cobrar'];
                $monto_vencido += $l['monto_vencido'];
              }

      $html .='<tr>
                  <td style="padding: 0" colspan="3" class="desc"><b>Totales</b></td>
                  <td style="padding: 0" class="desc"><b>'.number_format($mv_precio_venta, 2, ".", ",").'</b></td>
                  <td style="padding: 0" class="desc"><b>'.number_format($cuota, 2, ".", ",").'</b></td>
                  <td style="padding: 0" class="desc"><b>'.number_format($cobrado, 2, ".", ",").'</b></td>
                  <td style="padding: 0" class="desc"><b>'.number_format($por_cobrar, 2, ".", ",").'</b></td>
                  <td style="padding: 0" class="desc"><b>'.number_format($monto_vencido, 2, ".", ",").'</b></td>
                  <td style="padding: 0" class="desc"></td>
                </tr>';

$html .= '

    </tbody>
  </table>';

$html .='
</tbody>
</table>
</main>
<footer>
  Grupo Calpe 1.0 © 2015-16.
</footer>'; ?>
<?php $mpdf->writeHTML($html); ?>
<?php $mpdf->Output('reporte_2.pdf', 'I'); ?>
