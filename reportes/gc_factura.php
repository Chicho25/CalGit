<?php require_once('../lib_pdf/mpdf.php'); ?>
<?php require_once('../conexion/conexion.php'); ?>
<?php $mpdf = new mPDF('c', 'A4-L'); ?>
<?php $css = file_get_contents('css/style.css'); ?>
<?php $mpdf->writeHTML($css, 1); ?>
<?php $resultados = $conexion2 -> query("SELECT
factura.id,
factura.id_cliente,
factura.monto,
factura.fecha,
factura.stat,
factura.itbms,
factura.monto_pagado,
maestro_clientes.cl_nombre,
maestro_clientes.cl_apellido,
(select count(*)
from
factura_detalle
where
id_factura = factura.id) as contar
FROM factura inner join maestro_clientes on factura.id_cliente = maestro_clientes.id_cliente
where
factura.id='".$_GET['id']."'"); ?>
<?php while($l = $resultados->fetch_array()){
        $id_factura = $l['id'];
        $fecha = $l['fecha'];
        $cliente = $l['cl_nombre'].' '.$l['cl_apellido'];

      }
      $imagen = '1.jpg';
?>

<?php $html='
 <table border="0">
 	<tr>
		<td style="text-align: center;">
      <header class="clearfix">
        <div id="logo">
          <img src="../logos/'.$imagen.'" width="250">
        </div>
        <h1>Factura</h1>
        <div id="project" style="font-size:18px;">
          Vista Mar Marina
        </div>
        <div style="text-align: right">
             Fecha: '.$fecha.'
        </div>
      </header>
      <main>';

      $html .='
          <div style="font-size:28px; text-align: center; padding:10px;">
            N. Recibo: 00'.$id_factura.'
          </div>
          <div style="font-size:28px; text-align: center; padding:10px;">
            Cliente: '.$cliente.'
          </div>
      </main>';


$html .='<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th class="text-center">DETALLE</th>
            <th class="text-center">CANTIDAD</th>
            <th class="text-center">ITBMS</th>
            <th class="hidden-xs" >MONTO</th>
            <th class="hidden-xs" >TOTAL</th>
        </tr>
    </thead>
    <tbody>';
         $totalon = 0;
         $todos_contratos_ventas = $conexion2 -> query("SELECT * FROM factura_detalle WHERE id_factura = '".$_GET['id']."'");
         while($lista_todos_contratos_ventas = $todos_contratos_ventas -> fetch_array()){
        $html .='<tr>
            <td class="font-w600">'.$lista_todos_contratos_ventas['descripcion'].'</td>
            <td class="text-center">'.$lista_todos_contratos_ventas['cantidad'].'</td>
            <td class="text-center">'.number_format($lista_todos_contratos_ventas['itbms'], 2, '.',',').'</td>
            <td class="font-w600">'.number_format($lista_todos_contratos_ventas['monto'], 2, '.',',').'</td>
            <td class="font-w600">'.number_format($lista_todos_contratos_ventas['total'], 2, '.',',').'</td>
        </tr>';
        $totalon += $lista_todos_contratos_ventas['total'];
       }
        $html .='<tr>
          <td class="font-w600"></td>
          <td class="text-center"></td>
          <td class="text-center"></td>
          <td class="font-w600">Total</td>
          <td class="font-w600">'.number_format($totalon, 2, '.',',').'</td>
        </tr>
    </tbody>
</table>
</td>
</tr>
</table>
'; ?>
<?php $mpdf->writeHTML($html); ?>
<?php $mpdf->Output('reporte_2.pdf', 'I'); ?>
