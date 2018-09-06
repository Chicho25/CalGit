<?php include("../conexion/conexion.php"); ?>
<?php $sql_cheque_numeracion = $conexion2 -> query("select
                                                    id_tipo_movimiento_bancario,
                                                    tmb_nombre,
                                                    if ((id_tipo_movimiento_bancario = 8),
                                                       (select chq_ultimo_emitido+1
                                                       from chequeras
                                                       where
                                                       chq_id_cuenta_banco = '".$_GET['cuenta_banco']."'), (0)) as ultimo_cheque
                                                    from
                                                    tipo_movimiento_bancario
                                                    where
                                                    id_tipo_movimiento_bancario in(8, 9, 4, 10, 11, 6,12)"); ?>

<div class="form-group">
    <label class="col-md-4 control-label" for="val-skill">Tipo de pago
      <span class="text-danger">*</span></label>
    <div class="col-md-7">
      <select id="tipo_movimiento" class="form-control" required="required" name="id_tipo_movimiento_bancario" style="width: 100%;" data-placeholder="Seleccionar tipo de movimiento">
          <option value="0">Seleccionar</option>
          <?php while($lista_tipo_movimiento = $sql_cheque_numeracion -> fetch_array()){ ?>
          <option value="<?php echo $lista_tipo_movimiento['id_tipo_movimiento_bancario']; ?>"><?php if($lista_tipo_movimiento['id_tipo_movimiento_bancario'] == 8){ echo $lista_tipo_movimiento['tmb_nombre'].' -> '.$lista_tipo_movimiento['ultimo_cheque'];
          }else{ echo $lista_tipo_movimiento['tmb_nombre']; } ?></option>
          <?php } ?>
      </select>
    </div>
</div>

<?php function obtener_id_ch($conexion, $id_cuenta){

      $sql_che = $conexion -> query("select
                                      id_chequeras
                                     from chequeras
                                     where
                                     chq_id_cuenta_banco = '".$id_cuenta."'");
      while($list = $sql_che -> fetch_array()){
        return $list['id_chequeras'];
      }
    }
?>

<input type="hidden" name="id_chequera" value="<?php echo obtener_id_ch($conexion2, $_GET['cuenta_banco']);?>">
