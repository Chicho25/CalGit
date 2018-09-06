<?php $host = "localhost"; ?>
<?php $user = "admin_1"; ?>
<?php $pass = "DTzcHw1HLH"; ?>
<?php $base_datos = "admin_1"; ?>
<?php $conexion2 = mysqli_connect($host,$user,$pass,$base_datos) or die("Error " . mysqli_error($conexion2));?>

<?php

function ver_fact_btn($id, $con){

	$sql = $con -> query("select
												pd.pd_fecha_emision,
												mp.pro_nombre_comercial,
												pd.pd_descripcion,
												pd.pd_monto_total,
												pd.pd_monto_abonado,
												ms.st_nombre,
												ms.st_numero,
												(select count(*) from partida_documento_abono pda where pd.id_partida = pda.id_partida) as contar,
												case pd.pd_stat
												when 13 then 'Sin pagar'
												when 14 then 'Pagado'
												when 15 then 'Abonado'
												when 16 then 'Anulado'
												end as estado,
												mp.id_proveedores,
												pd.id_partida
												from
												maestro_proveedores mp
												inner join
												partida_documento pd on pd.id_proveedor =  mp.id_proveedores
												inner join
												maestro_status ms on ms.st_numero = pd.pd_stat
												where
												pd.id_partida = '".$id."'");?>

					<table style="width:100%" border="1" class="table">
						<tr>
							<th>Fecha de emicion</th>
							<th>Proveedor</th>
							<th>Descripcion</th>
              <th>Estado</th>
							<th>Monto del documento</th>
							<th>Monto Pagado</th>
							<th>Monto Pendiente</th>
						</tr>
            <?php $monto_documento =0; ?>
            <?php $monto_abonado =0; ?>
            <?php $monto_pendiente =0; ?>
						<?php while($p=$sql->fetch_array()){ /* mostrar este contenido de bajo de la indicacion de la partida */?>
						<tr>
							<td><?php echo $p['pd_fecha_emision']; ?></td>
							<td><?php echo $p['pro_nombre_comercial']; ?></td>
							<td><?php echo $p['pd_descripcion']; ?></td>
              <td><?php echo $p['estado']; ?></td>
							<td><?php echo number_format($p['pd_monto_total'], 2, ',','.'); ?></td>
							<td><?php echo number_format($p['pd_monto_abonado'], 2, ',','.'); ?></td>
							<td><?php echo number_format($p['pd_monto_total'] - $p['pd_monto_abonado'], 2, ',','.'); ?></td>
						</tr>
            <?php $monto_documento += $p['pd_monto_total']; ?>
            <?php $monto_abonado += $p['pd_monto_abonado']; ?>
            <?php $monto_pendiente += $p['pd_monto_total'] - $p['pd_monto_abonado']; ?>
						<?php } ?>
            <tr>
							<td colspan="4">Total</td>
							<td><?php echo number_format($monto_documento, 2, ',','.'); ?></td>
							<td><?php echo number_format($monto_abonado, 2, ',','.'); ?></td>
							<td><?php echo number_format($monto_pendiente, 2, ',','.'); ?></td>
						</tr>
					</table>
<?php }

      ver_fact_btn($_GET['id'], $conexion2); ?>
