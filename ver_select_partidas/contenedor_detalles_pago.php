<?php require("../conexion/conexion.php"); ?>

<?php $sql = $conexion2 -> query("select
mp.p_nombre as nombre_partida,
pda.fecha as fecha_creacion_abono,
pda.monto as monto_abono,
pda.descricion as descripcion_abono,
pda.id_sup_padre,
pda.numero_cheque,
(select tmb_nombre from tipo_movimiento_bancario where id_tipo_movimiento_bancario = pda.id_tipo_movimiento) as forma_pago,
pda.numero,
(select pro_nombre_comercial from maestro_proveedores where id_proveedores = pda.id_proveedor) as nombre_proveedor
from partida_documento_abono pda
inner join maestro_partidas mp on pda.id_partida = mp.id
where
pda.id_partida = '".$_GET['id']."'
order by mp.id, pda.id_sup_padre"); ?>

<table border="1" class="table table-responsive" style="font-size: 10px;">
    <tr>
      <td ><b>Proveedor/Vendedor</b></td>
      <td ><b>Forma de Pago</b></td>
      <td ><b>Detalles de Pago</b></td>
      <td ><b>Fecha</b></td>
      <td ><b>N° de Pago</b></td>
      <?php /* ?><td><b>Monto</b></td> */ ?>
      <td ><b>Monto Abono</b></td>
    </tr>
    <?php $monto_total = 0; ?>
    <?php $monto_total_abono = 0; ?>
    <?php while($q=$sql->fetch_array()){ ?>
    <tr>
      <td><?php echo $q['nombre_proveedor']; ?></td>
      <td><?php echo $q['forma_pago']; ?></td>
      <td><?php echo $q['descripcion_abono']; ?></td>
      <td><?php echo date("d-m-Y", strtotime($q['fecha_creacion_abono'])); ?></td>
      <td><?php echo $q['numero']; ?></td>
      <?php /* ?><td><?php echo number_format($q['pd_monto_abonado'], 2, ',','.'); ?></td> */ ?>
      <td><?php echo number_format($q['monto_abono'], 2, ',','.'); ?></td>
    </tr>
    <?php $monto_total = $monto_total + $q['monto_abono']; ?>
    <?php $monto_total_abono += $q['monto_abono']; ?>
    <?php } ?>
    <td colspan="5" style="text-align:right;"><b>Total -></b></td>
    <?php /* ?><td><b><?php echo number_format($monto_total, 2, ',', '.'); ?></b></td> */ ?>
    <td><b><?php echo number_format($monto_total_abono, 2, ',', '.'); ?></b></td>
</table>
