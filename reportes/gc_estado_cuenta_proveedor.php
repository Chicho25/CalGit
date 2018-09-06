<?php require_once('../lib_pdf/mpdf.php'); ?>
<?php require_once('funciones_reportes.php'); ?>
<?php require_once('../conexion/conexion.php'); ?>
<?php /*$nombre_proveedor = todos_proveedores($conexon2, $_POST['proveeedor']); ?>
<?php $nombre_proyecto = todos_proyectos($conexon2, $_POST['proyecto']);*/ ?>
<?php $mpdf = new mPDF('c', 'A4-L'); ?>
<?php $css = file_get_contents('css/style.css'); ?>
<?php $mpdf->writeHTML($css, 1); ?>
<?php if ($_POST['proveeedor'] == "todos") {
  $where = "";
}else{
  $where = " and pd.id_proveedor = '".$_POST['proveeedor']."'";
} ?>
<?php $sql = $conexion2 -> query("select
                                  'Docuemento' as conceptop,
                                  'Factura' as tipo,
                                  pd.pd_n_referencia as referencia,
                                  mp.p_nombre as partida,
                                  DATE_FORMAT(pd.pd_fecha_emision, '%d-%m-%Y') as emision,
                                  DATE_FORMAT(pd.pd_fecha_vencimiento, '%d-%m-%Y') as vencimiento,
                                  pd.pd_descripcion as descripcion,
                                  pd.pd_monto_total as devito,
                                  '0.00' as credito,
                                  pd.pd_monto_total as total,
                                  mpp.pro_nombre_comercial
                                  from partida_documento pd inner join maestro_partidas mp on pd.id_partida = mp.id
                                                            inner join maestro_proveedores mpp on mpp.id_proveedores = pd.id_proveedor
                                  where
                                  mp.id_proyecto = '".$_POST['proyecto']."'
                                  $where

                                  Union

                                  select
                                  'Pago' as conceptop,
                                  tmb.tmb_nombre as tipo,
                                  pda.referencia as referencia,
                                  mp.p_nombre as partida,
                                  DATE_FORMAT(pd.pd_fecha_emision,'%d-%m-%Y') as emision,
                                  DATE_FORMAT(pd.pd_fecha_vencimiento,'%d-%m-%Y') as vencimiento,
                                  pda.descricion as descripcion,
                                  '0.00' as devito,
                                  pda.monto as credito,
                                  (pd.pd_monto_total - pda.monto) as total,
                                  mpp.pro_nombre_comercial
                                  from
                                  partida_documento_abono pda inner join partida_documento pd on pda.id_partida_documento = pd.id
                                  							inner join maestro_partidas mp on pda.id_partida = mp.id
                                  							inner join tipo_movimiento_bancario tmb on tmb.id_tipo_movimiento_bancario = pda.id_tipo_movimiento
                                                inner join maestro_proveedores mpp on mpp.id_proveedores = pd.id_proveedor
                                  where
                                  mp.id_proyecto = '".$_POST['proyecto']."'
                                  $where"); ?>

<?php /* while($proveedor = $nombre_proveedor ->fetch_array()){
            $pro = $proveedor['pro_nombre_comercial'];
} ?>
<?php while($proyecto = $nombre_proyecto ->fetch_array()){
            $proy = $proyecto['proy_nombre_proyecto'];
} */ ?>
<?php while($li[] = $sql->fetch_array()); ?>
<?php $html='
<header class="clearfix">
  <div id="logo">
      <img src="img/calpe/logo.png">
  </div>
  <h1>ESTADO DE CUENTA PROVEEDOR</h1>
  <div id="company" class="clearfix">
    <div>Grupo Calpe</div>
    <div>Av. Aquilino de la Guardia, Torre,<br />
         Ocean Business Plaza. Piso 15,<br />
         Ofic. 1504. Panamá.</div>
    <div>(+507) 340 6390</div>
    <div><a href="mailto:ventas@grupocalpe.com.pa">ventas@grupocalpe.com.pa</a></div>
  </div>
  <div id="project">
    <div><span>Proveedor:'.$pro.'</span> </div>
    <div><span>Proyecto:'.$proy.'</span> </div>
    <div><span>Fecha</span>'.date("d-m-Y H:i:s").'</div>
  </div>
</header>
<main>
  <table>
    <thead>
      <tr>
        <th>PROVEEDOR</th>
        <th>CONCEPTO</th>
        <th>TIPO</th>
        <th>NUMERO</th>
        <th>PARTIDA</th>
        <th>EMISION</th>
        <th>VENCIMIENTO</th>
        <th>DESCRIPCION</th>
        <th>DEBITO</th>
        <th>CREDITO</th>
        <th>SALDO</th>
      </tr>
    </thead>
    <tbody>';

    foreach($li as $l){

      $html .='<tr>
                  <td>'.$l['pro_nombre_comercial'].'</td>
                  <td>'.$l['conceptop'].'</td>
                  <td>'.$l['tipo'].'</td>
                  <td>'.$l['referencia'].'</td>
                  <td>'.$l['partida'].'</td>
                  <td>'.$l['emision'].'</td>
                  <td>'.$l['vencimiento'].'</td>
                  <td>'.$l['descripcion'].'</td>
                  <td>'.number_format($l['devito'], 2).'</td>
                  <td>'.number_format($l['credito'], 2).'</td>
                  <td>'.$l['total'].'</td>
                </tr>';
    $total_debito += $l['devito'];
    $total_credito += $l['credito'];
    }

    $html .= '<tr>
            <td colspan="10">Total debito</td>
            <td class="total">'.number_format($total_debito, 2).'</td>
          </tr>
          <tr>
            <td colspan="10">Total Credito</td>
            <td class="total">'.number_format($total_credito, 2).'</td>
          </tr>
          <tr>
            <td colspan="10">Saldo Total</td>
            <td class="total">'.number_format(($total_debito-$total_credito), 2).'</td>
          </tr>

        </tbody>
      </table>

</main>
<footer>
  Grupo Calpe 1.0 © 2015-16.
</footer>'; ?>
<?php $mpdf->writeHTML($html); ?>
<?php $mpdf->Output('reporte_1.pdf', 'I'); ?>
