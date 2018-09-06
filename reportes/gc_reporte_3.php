<?php require_once('../lib_pdf/mpdf.php'); ?>
<?php require_once('funciones_reportes.php'); ?>
<?php require_once('../conexion/conexion.php'); ?>
<?php $mpdf = new mPDF('c', 'A4-L'); ?>
<?php $css = file_get_contents('css/style.css'); ?>
<?php $mpdf->writeHTML($css, 1); ?>
<?php if($_POST['id_proyecto']=="" && $_POST['vendedor'] ==""){
      $sql_todos_resumen = $conexion2->query("select
                                              mp.id_proyecto,
                                              mpy.proy_nombre_proyecto,
                                              sum(pd.pd_monto_total) as suma_factura,
                                              sum(pd.pd_monto_abonado) as suma_pagada,
                                              (sum(pd.pd_monto_total) - sum(pd.pd_monto_abonado)) as restante
                                              from partida_documento pd
                                              inner join maestro_partidas mp on pd.id_partida = mp.id
                                              inner join maestro_proyectos mpy on mp.id_proyecto = mpy.id_proyecto
                                              where
                                              pd.comision = 1
                                              group by
                                              mp.id_proyecto,
                                              mpy.proy_nombre_proyecto");

       while($li[] = $sql_todos_resumen->fetch_array());


     }elseif($_POST['id_proyecto'] !="" && $_POST['vendedor'] ==""){

       $sql_por_proyecto = $conexion2 -> query("select
                                                cv.id_comision_vendedor,
                                                mp.proy_nombre_proyecto,
                                                (select
                                                	gi_nombre_grupo_inmueble
                                                 from maestro_inmuebles mi inner join grupo_inmuebles gi on mi.id_grupo_inmuebles = gi.id_grupo_inmuebles
                                                 where
                                                	mi.id_inmueble = mv.id_inmueble) as grupo_inmueble,
                                                	DATE_FORMAT(cv.cv_fecha_hora, '%d - %m - %Y') as cv_fecha_hora,
                                                mc.cl_nombre,
                                                mc.cl_apellido,
                                                mvv.pro_nombre_comercial,
                                                cv_porcentaje_comision,
                                                mv.mv_precio_venta,
                                                ((cv_porcentaje_comision * mv.mv_precio_venta) / 100) as monto_comision
                                                from comisiones_vendedores cv
                                                inner join maestro_ventas mv on mv.id_venta = cv.id_contrato_venta
                                                inner join maestro_proyectos mp on mp.id_proyecto = mv.id_proyecto
                                                inner join maestro_clientes mc on mv.id_cliente = mc.id_cliente
                                                inner join maestro_proveedores mvv on mvv.id_proveedores = cv.id_vendedor
                                                where
                                                mp.id_proyecto = '".$_POST['id_proyecto']."'");


       while($li[] = $sql_por_proyecto->fetch_array());

     }elseif($_POST['vendedor'] !="" && $_POST['id_proyecto']==""){


       $sql_por_vendedor = $conexion2 -> query("select
                                                cv.id_comision_vendedor,
                                                mp.proy_nombre_proyecto,
                                                (select
                                                 gi_nombre_grupo_inmueble
                                                 from maestro_inmuebles mi inner join grupo_inmuebles gi on mi.id_grupo_inmuebles = gi.id_grupo_inmuebles
                                                 where
                                                 mi.id_inmueble = mv.id_inmueble) as grupo_inmueble,
                                                 DATE_FORMAT(cv.cv_fecha_hora, '%d - %m - %Y') as cv_fecha_hora,
                                                mc.cl_nombre,
                                                mc.cl_apellido,
                                                mvv.pro_nombre_comercial,
                                                cv_porcentaje_comision,
                                                mv.mv_precio_venta,
                                                ((cv_porcentaje_comision * mv.mv_precio_venta) / 100) as monto_comision
                                                from comisiones_vendedores cv
                                                inner join maestro_ventas mv on mv.id_venta = cv.id_contrato_venta
                                                inner join maestro_proyectos mp on mp.id_proyecto = mv.id_proyecto
                                                inner join maestro_clientes mc on mv.id_cliente = mc.id_cliente
                                                inner join maestro_proveedores mvv on mvv.id_proveedores = cv.id_vendedor
                                                where
                                                mvv.id_proveedores = '".$_POST['vendedor']."'");

          while($li[] = $sql_por_vendedor->fetch_array());

     } ?>

<?php $html='
<header class="clearfix">
  <div id="logo">

  </div>
  <h1>Contrato y comisiones</h1>
  
  <div id="project">

  </div>
</header>
<main>';

/* <div id="company" class="clearfix">
    <div>Grupo Calpe</div>
    <div>Av. Aquilino de la Guardia, Torre,<br />
         Ocean Business Plaza. Piso 15,<br />
         Ofic. 1504. Panamá.</div>
    <div>(+507) 340 6390</div>
    <div><a href="mailto:ventas@grupocalpe.com.pa">ventas@grupocalpe.com.pa</a></div>
  </div>*/

if(isset($sql_todos_resumen)){

  $html .='<table>
            <thead>
              <tr>
                <th style="padding: 0" class="service">ID</th>
                <th style="padding: 0" class="desc">PROYECTO</th>
                <th style="padding: 0" class="desc">TOTAL FACTURADO</th>
                <th style="padding: 0" class="desc">TOTAL PAGADO</th>
                <th style="padding: 0" class="desc">RESTANTE</th>
              </tr>
            </thead>
            <tbody>';

    $suma_1=0;
    $suma_2=0;
    $suma_3=0;

    foreach($li as $l){
      if($l['suma_factura']==0){ continue;}
      $html .='<tr>
                  <td style="padding: 0" class="service">'.$l['id_proyecto'].'</td>
                  <td style="padding: 0" class="desc">'.$l['proy_nombre_proyecto'].'</td>
                  <td style="padding: 0" class="desc">'.number_format($l['suma_factura'], 2).'</td>
                  <td style="padding: 0" class="desc">'.number_format($l['suma_pagada'], 2).'</td>
                  <td style="padding: 0" class="desc">'.number_format($l['restante'], 2).'</td>
                </tr>';

                $suma_1 += $l['suma_factura'];
                $suma_2 += $l['suma_pagada'];
                $suma_3 += $l['restante'];

                }

$html .= '

          <tr>
            <td style="padding: 0" class="service"></td>
            <td style="padding: 0" class="desc"><b>TOTALES</b></td>
            <td style="padding: 0" class="desc"><b>'.number_format($suma_1, 2).'</b></td>
            <td style="padding: 0" class="desc"><b>'.number_format($suma_2, 2).'</b></td>
            <td style="padding: 0" class="desc"><b>'.number_format($suma_3, 2).'</b></td>
          </tr>

    </tbody>
  </table>';

}elseif($sql_por_proyecto){

  $html .='<table>
            <thead>
              <tr>
                <th style="padding: 0" class="service">ID</th>
                <th style="padding: 0" class="desc">PROYECTO</th>
                <th style="padding: 0" class="desc">GRUPO</th>
                <th style="padding: 0" class="desc">FECHA</th>
                <th style="padding: 0" class="desc">MONTO VENTA</th>
                <th style="padding: 0" class="desc">CLIENTE</th>
                <th style="padding: 0" class="desc">VENDEDOR</th>
                <th style="padding: 0" class="desc">PORCENTAJE</th>
                <th style="padding: 0" class="desc">COMISION</th>
              </tr>
            </thead>
            <tbody>';

    $suma_1=0;
    $suma_2=0;

    foreach($li as $l){
      if($l['mv_precio_venta']==0){ continue;}
      $html .='<tr>
                  <td style="padding: 0" class="service">'.$l['id_comision_vendedor'].'</td>
                  <td style="padding: 0" class="desc">'.$l['proy_nombre_proyecto'].'</td>
                  <td style="padding: 0" class="desc">'.$l['grupo_inmueble'].'</td>
                  <td style="padding: 0" class="desc">'.$l['cv_fecha_hora'].'</td>
                  <td style="padding: 0" class="desc">'.number_format($l['mv_precio_venta'], 2).'</td>
                  <td style="padding: 0" class="desc">'.$l['cl_nombre'].' '.$l['cl_apellido'].'</td>
                  <td style="padding: 0" class="desc">'.$l['pro_nombre_comercial'].'</td>
                  <td style="padding: 0" class="desc">'.number_format($l['cv_porcentaje_comision'], 2).'</td>
                  <td style="padding: 0" class="desc">'.number_format($l['monto_comision'], 2).'</td>
                </tr>';

                $suma_1 += $l['mv_precio_venta'];
                $suma_2 += $l['monto_comision'];

                }

$html .= '

          <tr>
            <td style="padding: 0" class="service"></td>
            <td style="padding: 0" class="desc"><b>TOTALES</b></td>
            <td style="padding: 0" class="desc"><b>'.number_format($suma_1, 2).'</b></td>
            <td style="padding: 0" class="desc"><b>'.number_format($suma_2, 2).'</b></td>
          </tr>

    </tbody>
  </table>';

}elseif($sql_por_vendedor){

  $html .='<table>
            <thead>
              <tr>
                <th style="padding: 0" class="service">ID</th>
                <th style="padding: 0" class="desc">PROYECTO</th>
                <th style="padding: 0" class="desc">GRUPO</th>
                <th style="padding: 0" class="desc">FECHA</th>
                <th style="padding: 0" class="desc">MONTO VENTA</th>
                <th style="padding: 0" class="desc">CLIENTE</th>
                <th style="padding: 0" class="desc">VENDEDOR</th>
                <th style="padding: 0" class="desc">PORCENTAJE</th>
                <th style="padding: 0" class="desc">COMISION</th>
              </tr>
            </thead>
            <tbody>';

    $suma_1=0;
    $suma_2=0;

    foreach($li as $l){
      if($l['mv_precio_venta']==0){ continue;}
      $html .='<tr>
                  <td style="padding: 0" class="service">'.$l['id_comision_vendedor'].'</td>
                  <td style="padding: 0" class="desc">'.$l['proy_nombre_proyecto'].'</td>
                  <td style="padding: 0" class="desc">'.$l['grupo_inmueble'].'</td>
                  <td style="padding: 0" class="desc">'.$l['cv_fecha_hora'].'</td>
                  <td style="padding: 0" class="desc">'.number_format($l['mv_precio_venta'], 2).'</td>
                  <td style="padding: 0" class="desc">'.$l['cl_nombre'].' '.$l['cl_apellido'].'</td>
                  <td style="padding: 0" class="desc">'.$l['pro_nombre_comercial'].'</td>
                  <td style="padding: 0" class="desc">'.number_format($l['cv_porcentaje_comision'], 2).'</td>
                  <td style="padding: 0" class="desc">'.number_format($l['monto_comision'], 2).'</td>
                </tr>';

                $suma_1 += $l['mv_precio_venta'];
                $suma_2 += $l['monto_comision'];

                }

$html .= '

          <tr>
            <td style="padding: 0" class="service"></td>
            <td style="padding: 0" class="desc"><b>TOTALES</b></td>
            <td style="padding: 0" class="desc"><b>'.number_format($suma_1, 2).'</b></td>
            <td style="padding: 0" class="desc"><b>'.number_format($suma_2, 2).'</b></td>
          </tr>

    </tbody>
  </table>';

}

$html .='</main>
<footer>
  Grupo Calpe 1.0 © 2015-16.
</footer>'; ?>
<?php $mpdf->writeHTML($html); ?>
<?php $mpdf->Output('reporte_3.pdf', 'I'); ?>
