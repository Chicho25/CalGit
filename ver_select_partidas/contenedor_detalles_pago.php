<?php require("../conexion/conexion.php"); ?>

<?php $sql = $conexion2 -> query("select *, case pd.pd_stat
                                   when 13 then 'Sin pagar'
                                   when 15 then 'Abonado'
                                   when 14 then 'Pagado'
                                  end as estado,
                                  pd.id as otro_id,
                                  (select pro_nombre_comercial from maestro_proveedores where id_proveedores = pd.id_proveedor) as proveedor,
                                  (select ven_nombre from maestro_vendedores where id_vendedor = pd.id_vendedor) as vendedor
                                  from
                                  partida_documento pd
                                  inner join
                                  tipo_documentos td on pd.tipo_documento = td.id
                                  where
                                  pd.id_partida = '".$_GET['id']."'"); ?>

<table border="1" class="table table-striped js-dataTable-full" style="font-size: 10px">
    <tr>
      <td><b>Proveedor/Vendedor</b></td>
      <td><b>Forma de Pago</b></td>
      <td><b>N° de Pago</b></td>
      <td><b>Fecha</b></td>
      <td><b>Estado del Documento</b></td>
      <td><b>Detalles de Pago</b></td>
      <td><b>Monto</b></td>
    </tr>
    <?php $monto_total = 0; ?>
    <?php while($q=$sql->fetch_array()){ ?>
    <tr>
      <td><?php if($q['proveedor']!=''){ echo $q['proveedor'];}elseif($q['vendedor']!=''){ echo $q['vendedor'];} ?></td>
      <td><?php echo $q['nombre']; ?></td>
      <td><?php echo $q['id']; ?></td>
      <td><?php echo date("d-m-Y", strtotime($q['pd_fecha_emision'])); ?></td>
      <td><?php echo $q['estado']; ?></td>
      <td><?php echo $q['pd_descripcion']; ?></td>
      <td><?php echo number_format($q['pd_monto_abonado'], 2, ',','.'); ?></td>
    </tr>
    <?php $monto_total = $monto_total + $q['pd_monto_abonado']; ?>
    <?php } ?>
    <td colspan="6" style="text-align:right;"><b>Total</b></td>
    <td><b><?php echo number_format($monto_total, 2, ',', '.'); ?></b></td>
</table>
