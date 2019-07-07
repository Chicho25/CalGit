<?php require_once('../lib_pdf/mpdf.php'); ?>
<?php require_once('funciones_reportes.php'); ?>
<?php require_once('../conexion/conexion.php'); ?>
<?php $mpdf = new mPDF('c', 'A4-L'); ?>
<?php $css = file_get_contents('css/style.css'); ?>
<?php $mpdf->writeHTML($css, 1);

      $where = "where";
      if ($_POST['id_proyecto'] != "") {
        $where .= " pda.id_proyecto = ".$_POST['id_proyecto']."";
      }else{ }
      if ($_POST['fecha_a_ini'] != '') {
        $where .= " and pda.fecha >= '".$_POST['fecha_a_ini']."' ";

      }else{ }
      if ($_POST['fecha_a_fin'] != '') {
        $where .= " and pda.fecha <= '".$_POST['fecha_a_fin']."' ";
      }else{ }

      if($_POST['id_proyecto']== 13){
        $id_partida_padre = 1455;
      }else{
        $id_partida_padre = 2424;
      }

      if ($_POST['id_partida'] == 'resumen') {

        //eliminar_partidas($conexion2);

        $where = "";

        if ($_POST['fecha_a_ini'] != '') {
          $where .= " and fecha >= '".$_POST['fecha_a_ini']."' ";

        }else{ }
        if ($_POST['fecha_a_fin'] != '') {
          $where .= " and fecha <= '".$_POST['fecha_a_fin']."' ";
        }else{ }

      $sql_report_fac_abo = $conexion2 -> query("select
												 mp.p_nombre,
						(select sum(monto) from partida_documento_abono where id_sup_padre = mp.id $where ) as monto
from maestro_partidas mp
where
mp.id_padre = $id_partida_padre");


while($li[] = $sql_report_fac_abo -> fetch_array());

$excelPrint = '<table border="1">
    <thead>
      <tr>
        <th>'.(count($li) - 1).'</th>
      </tr>
      <tr>
        <th class="service"><b>NOMBRE PARTIDA</b></th>
        <th class="desc"><b>MONTO</b></th>
      </tr>
    </thead>
    <tbody>';

    $monto_abono = 0;

    foreach($li as $l){
$excelPrint .='<tr>
                  <td style="padding: 0" class="desc">'.utf8_encode($l['p_nombre']).'</td>
                  <td style="padding: 0" class="desc">'.number_format($l['monto'], 2, ".", ",").'</td>
                </tr>';

                $monto_abono += $l['monto'];
              }

$excelPrint .='<tr>
                  <td style="padding: 0" class="desc"><b>Totales</b></td>
                  <td style="padding: 0" class="desc"><b>'.number_format($monto_abono, 2, ".", ",").'</b></td>
                </tr>
              </tbody>
            </table>';

          }else{

$sql_report_fac_abo = $conexion2 -> query("select
mp.p_nombre as nombre_partida,
pd.pd_fecha_vencimiento as fecha_vencimiento_factura,
pd.pd_descripcion as descripcion_factura,
pda.fecha as fecha_creacion_abono,
pda.monto as monto_abono,
pda.descricion as descripcion_abono,
pda.id_sup_padre,
(select pro_nombre_comercial from maestro_proveedores where id_proveedores = pda.id_proveedor) as nombre_proveedor
from partida_documento pd inner join partida_documento_abono pda on pd.id = pda.id_partida_documento
inner join maestro_partidas mp on pd.id_partida = mp.id
$where
order by mp.id, pda.id_sup_padre");

        while($li[] = $sql_report_fac_abo -> fetch_array());

        $excelPrint = '<table border="1">
            <thead>
              <tr>
                <th>'.(count($li) - 1).'</th>
              </tr>
              <tr>
                <th class="service"><b>NOMBRE PARTIDA</b></th>
                <th class="desc"><b>PROVEEDOR</b></th>
                <th class="desc"><b>FECHA ABONO</b></th>
                <th class="desc"><b>MONTO ABONO</b></th>
                <th class="desc"><b>DESCRIPCION ABONO</b></th>
              </tr>
            </thead>
            <tbody>';

            $monto_abono = 0;

            foreach($li as $l){

        $excelPrint .='<tr>
                          <td style="padding: 0" class="desc">'.utf8_encode($l['nombre_partida']).'</td>
                          <td style="padding: 0" class="desc">'.utf8_encode($l['nombre_proveedor']).'</td>
                          <td style="padding: 0" class="desc">'.$l['fecha_creacion_abono'].'</td>
                          <td style="padding: 0" class="desc">'.number_format($l['monto_abono'], 2, ".", ",").'</td>
                          <td style="padding: 0" class="desc">'.utf8_encode($l['descripcion_abono']).'</td>
                        </tr>';

                        $monto_abono += $l['monto_abono'];
                      }

        $excelPrint .='<tr>
                          <td style="padding: 0" colspan="3" class="desc"><b>Totales</b></td>
                          <td style="padding: 0" class="desc"><b>'.number_format($monto_abono, 2, ".", ",").'</b></td>
                          <td style="padding: 0" class="desc"><b></b></td>
                        </tr>
                      </tbody>
                    </table>';

            }

if($_POST['id_formato'] == 1 ){
$mpdf->writeHTML($excelPrint);
$mpdf->Output('reporte_egresos.pdf', 'I');

}else{

header('Content-Type: application/xls');
header('Content-Disposition: attachment; filename='.date('d-m-Y').'-ReporteEngreso.xls');
echo $excelPrint;

} ?>
