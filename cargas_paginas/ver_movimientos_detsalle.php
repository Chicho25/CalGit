<?php include_once("../conexion/conexion.php"); ?>
<?php 	function tipo_movimiento_bancario($conexion){

				$sql_tipo_movimiento = $conexion ->query("select * from tipo_movimiento_bancario where tmb_stat = 1 AND id_tipo_movimiento_bancario not in(8, 12)");

				return $sql_tipo_movimiento;

} ?>
<?php $todos_movimeintos = $conexion2 -> query("select
                                                mb.id_movimiento_bancario,
                                                tmb.id_tipo_movimiento_bancario,
                                                tmb.tmb_nombre,
                                                (select
                                                	mb2.banc_nombre_banco
                                                 from maestro_bancos mb2 inner join cuentas_bancarias cb2 on mb2.id_bancos = cb2.cta_id_banco
                                                 where
                                                 cb2.id_cuenta_bancaria = mb.id_cuenta group by mb2.banc_nombre_banco) as banco,
                                                 cb.cta_numero_cuenta,
                                                 mb.mb_numero_cheque,
                                                 mb.mb_beneficiario,
                                                case mb.cheque_directo
                                                 when 1 then 'si'
                                                 when 0 then 'no'
                                                 end as cheque_directo,
                                                 mb.mb_fecha,
                                                 mb.mb_referencia_numero,
                                                 mb.mb_monto,
                                                 mb.mb_descripcion,
                                                 mb.movimiento_directo,
                                                (select mp2.pro_nombre_comercial from maestro_proveedores mp2 where mp2.id_proveedores = mb.id_proveedor) as proveedor,
                                                (select mcl2.cl_nombre+' '+mcl2.cl_apellido from maestro_clientes mcl2 where mcl2.id_cliente = mb.id_cliente) as cliente,
                                                (select mp1.proy_nombre_proyecto from maestro_proyectos mp1 where mp1.id_proyecto = mb.id_proyecto) as proyecto,
                                                (select mps.p_nombre from maestro_partidas mps where mps.id = mb.id_partida) as partida
                                                from
                                                movimiento_bancario mb
                                                inner join
                                                tipo_movimiento_bancario tmb on mb.id_tipo_movimiento = tmb.id_tipo_movimiento_bancario
                                                inner join
                                                cuentas_bancarias cb on mb.id_cuenta = cb.id_cuenta_bancaria
                                                where
                                                id_movimiento_bancario ='".$_GET['id']."'"); ?>
<?php while($lista_movimiento = $todos_movimeintos -> fetch_array()){ ?>

  <form action="" method="post" >

  <div class="block block-themed block-transparent remove-margin-b">
      <div class="block-header bg-primary-dark">
          <ul class="block-options">
              <li>
                  <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
              </li>
          </ul>
          <h3 class="block-title">Actualizar Datos</h3>
      </div>
      <div class="block-content">
                <!-- Bootstrap Register -->
          <div class="block block-themed">
              <div class="block-content">
                      <div class="form-group">
                          <label class="col-xs-12" for="register1-username">ID</label>
                          <div class="col-xs-12">
                              <input class="form-control" type="text" id="register1-username" name="id_movimiento" readonly="readonly" value="<?php echo $lista_movimiento['id_movimiento_bancario']; ?>">
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-xs-12" for="register1-username">TIPO DE MOVIMIENTO</label>
                          <div class="col-xs-12">
                              <?php if($lista_movimiento['movimiento_directo']==0){ ?>
                              <input class="form-control" type="text" id="register1-username" readonly="readonly" value="<?php echo $lista_movimiento['tmb_nombre']; ?>">
                              <?php }else{ ?>
                              <?php /* Si es directo */ ?>
                              <select class="js-select2 form-control" id="val-select2" name="id_tipo_movimiento_bancario" style="width: 100%;" data-placeholder="Seleccionar tipo de movimiento" required="required">
                                  <option></option>
                                  <?php   $sql_tipo_movimiento = tipo_movimiento_bancario($conexion2); ?>
                                  <?php   while($lista_tipo_movimiento = $sql_tipo_movimiento -> fetch_array()){ ?>
                                  <option value="<?php echo $lista_tipo_movimiento['id_tipo_movimiento_bancario']; ?>"
                                                 <?php if($lista_movimiento['id_tipo_movimiento_bancario'] == $lista_tipo_movimiento['id_tipo_movimiento_bancario']){ echo 'selected'; } ?>
                                   ><?php echo $lista_tipo_movimiento['tmb_nombre']; ?></option>
                                  <?php } ?>
                              </select>
                              <?php } ?>
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-xs-12" for="register1-username">BANCO</label>
                          <div class="col-xs-12">
                              <input class="form-control" type="text" id="register1-username" readonly="readonly" value="<?php echo $lista_movimiento['banco']; ?>">
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-xs-12" for="register1-username">CUENTA</label>
                          <div class="col-xs-12">
                              <input class="form-control" type="text" id="register1-username" readonly="readonly" value="<?php echo $lista_movimiento['cta_numero_cuenta']; ?>">
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-xs-12" for="register1-username">NUMERO DE CHEQUE</label>
                          <div class="col-xs-12">
                              <input class="js-datepicker form-control" type="text" readonly="readonly" id="example-datepicker1" data-date-format="yy-mm-dd" name="fecha" value="<?php echo $lista_movimiento['mb_numero_cheque']; ?>">
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-xs-12" for="register1-username">BENEFICIARIO</label>
                          <div class="col-xs-12">
                              <input class="form-control" type="text" id="register1-username" <?php if($lista_movimiento['movimiento_directo']==0){ ?> readonly="readonly" <?php } ?> name="beneficiario" value="<?php echo $lista_movimiento['mb_beneficiario']; ?>">
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-xs-12" for="register1-username">DIRECTO?</label>
                          <div class="col-xs-12">
                              <input class="form-control" type="text" id="register1-username" readonly="readonly" name="monto" value="<?php echo $lista_movimiento['cheque_directo']; ?>">
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-xs-12" for="register1-username">FECHA</label>
                          <div class="col-xs-12">
                              <input class="form-control" type="text" id="register1-username" name="fecha_movimiento" <?php if($lista_movimiento['movimiento_directo']==0){ ?> readonly="readonly" <?php } ?> value="<?php echo date("d-m-Y", strtotime($lista_movimiento['mb_fecha'])); ?>">
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-xs-12" for="register1-username">REFERENCIA</label>
                          <div class="col-xs-12">
                              <input class="form-control" type="text" name="referencia" id="register1-username" <?php if($lista_movimiento['movimiento_directo']==0){ ?> readonly="readonly" <?php } ?> value="<?php echo $lista_movimiento['mb_referencia_numero']; ?>">
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-xs-12" for="register1-username">MONTO</label>
                          <div class="col-xs-12">
                              <input class="form-control" name="monto" type="text" id="register1-username" <?php if($lista_movimiento['movimiento_directo']==0){ ?> readonly="readonly" <?php } ?> value="<?php echo $lista_movimiento['mb_monto']; ?>">
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-xs-12" for="register1-username">DESCRIPCION</label>
                          <div class="col-xs-12">
                              <textarea class="form-control" name="descripcion" type="text" id="register1-username" <?php if($lista_movimiento['movimiento_directo']==0){ ?> readonly="readonly" <?php } ?> name="descripcion"><?php echo $lista_movimiento['mb_descripcion']; ?></textarea>
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-xs-12" for="register1-username">PROYECTO</label>
                          <div class="col-xs-12">
                              <input class="form-control" type="text" id="register1-username" readonly="readonly" value="<?php echo $lista_movimiento['proyecto']; ?>">
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-xs-12" for="register1-username">PARTIDA</label>
                          <div class="col-xs-12">
                              <input class="form-control" type="text" id="register1-username" readonly="readonly" value="<?php echo $lista_movimiento['partida']; ?>">
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-xs-12" for="register1-username">PROVEEDOR</label>
                          <div class="col-xs-12">
                              <input class="form-control" type="text" id="register1-username" readonly="readonly" value="<?php echo $lista_movimiento['proveedor']; ?>">
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-xs-12" for="register1-username">CLIENTE</label>
                          <div class="col-xs-12">
                              <input class="form-control" type="text" id="register1-username" readonly="readonly" value="<?php echo $lista_movimiento['cliente']; ?>">
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-xs-12" for="register1-username"></label>
                          <div class="col-xs-12">

                          </div>
                      </div>

                <div class="modal-footer">
                    <button class="btn btn-sm btn-default" type="button" data-dismiss="modal">Salir</button>
                    <?php if($lista_movimiento['movimiento_directo']==1){ ?>
                    <button class="btn btn-sm btn-primary" type="submit" >Guardar cambios</button>
                    <?php } ?>
                </div>
          </div>
      </div>
  </form>

  <?php } ?>
