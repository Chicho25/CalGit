<?php include_once("../conexion/conexion.php"); ?>
<?php include_once("../funciones/funciones.php"); ?>
<?php $sql_proveedores = $conexion2->query("select
                                                pd.*,
                                                mproy.proy_nombre_proyecto,
                                                mp.p_nombre,
                                                mpr.pro_nombre_comercial,
                                                td.nombre
                                             from partida_documento pd inner join maestro_partidas mp on pd.id_partida = mp.id
                                                                       inner join maestro_proveedores mpr on pd.id_proveedor = mpr.id_proveedores
                                                                       inner join tipo_documentos td on pd.tipo_documento = td.id
                                                                       inner join maestro_proyectos mproy on mproy.id_proyecto = mp.id_proyecto
                                                                       where pd.id ='".$_GET['id']."'"); ?>
<script>
  function suma_campos()
  {
    elem_1 = (isNaN(document.getElementById("text1").value) || document.getElementById("text1").value == "") ? "0" : document.getElementById("text1").value;
    elem_2 = (isNaN(document.getElementById("text2").value) || document.getElementById("text2").value == "") ? "0" : document.getElementById("text2").value;

    document.getElementById("text3").value = parseFloat(Math.round(elem_1*100)/100 + Math.round(elem_2*100)/100 + (Math.round(elem_2) * 7 / 100)).toFixed(2);
    /*parseFloat(Math.round(x * 100) / 100).toFixed(2);*/
    document.getElementById("text4").value = parseFloat(Math.round(elem_2) * 7 / 100).toFixed(2);
  }
</script>

<?php while($lista_documento_partida = $sql_proveedores -> fetch_array()){ ?>

  <form action="" method="post" enctype="multipart/form-data">
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
                              <input class="form-control" type="text" name="id" readonly="readonly" value="<?php echo $lista_documento_partida['id']; ?>">
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-xs-12" for="register1-email">PARTIDA</label>
                          <div class="col-xs-12">
                              <input class="form-control" type="text" readonly value="<?php echo $lista_documento_partida['p_nombre']; ?>">
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-xs-12" for="register1-username">PROVEEDOR</label>
                          <div class="col-xs-12">
                              <select class="js-select2 form-control" name="proveedor" style="width: 100%;" data-placeholder="Seleccionar un pais" required="required">
                                  <option value="0"> Seleccionar</option>
                                  <?php
                                  $result = todos_proveedores($conexion2);
                                  while($fila = $result->fetch_array()){ ?>
                                          <option value="<?php echo $fila['id_proveedores']; ?>" <?php if($lista_documento_partida['id_proveedor'] == $fila['id_proveedores']){ echo 'selected';} ?> ><?php echo $fila['pro_nombre_comercial']; ?></option>
                                  <?php  } ?>
                              </select>
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-xs-12" for="register1-username">TIPO</label>
                          <div class="col-xs-12">
                              <select class="js-select2 form-control" id="val-select2" name="tipo_documento" style="width: 100%;" data-placeholder="Seleccionar tipo de movimiento" required="required">
                                  <option></option>
                                  <?php   $sql_tipo_documentos = tipo_documentos($conexion2); ?>
                                  <?php   while($lista_tipo_documentos = $sql_tipo_documentos -> fetch_array()){ ?>
                                  <option value="<?php echo $lista_tipo_documentos['id']; ?>"
                                                 <?php if($lista_documento_partida['tipo_documento'] == $lista_tipo_documentos['id']){ echo 'selected'; } ?>
                                   ><?php echo $lista_tipo_documentos['nombre']; ?></option>
                                  <?php } ?>
                              </select>
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-xs-12" for="register1-username">FECHA EMISION</label>
                          <div class="col-xs-12">
                              <input class="js-datepicker form-control" type="text" id="example-datepicker1" name="fecha_emision" data-date-format="dd-mm-yyyy" value="<?php echo date("d-m-Y", strtotime($lista_documento_partida['pd_fecha_emision'])); ?>">
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-xs-12" for="register1-email">FECHA VENCIMIENTO</label>
                          <div class="col-xs-12">
                              <input class="js-datepicker form-control" type="text" id="example-datepicker1" name="fecha_vencimiento" data-date-format="dd-mm-yyyy" value="<?php echo date("d-m-Y", strtotime($lista_documento_partida['pd_fecha_vencimiento'])); ?>">
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-xs-12" for="register1-email">DESCRIPCION</label>
                          <div class="col-xs-12">
                              <textarea class="form-control" name="descripcion"><?php echo $lista_documento_partida['pd_descripcion']; ?></textarea>
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-xs-12" >MONTO EXENTO</label>
                          <div class="col-xs-12">
                              <input class="form-control" type="text" id="text1" onkeyup="suma_campos()" name="monto_exento" value="<?php echo $lista_documento_partida['pd_monto_exento']; ?>">
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-xs-12">MONTO GRAVABLE</label>
                          <div class="col-xs-12">
                              <input class="form-control" type="text" id="text2" onkeyup="suma_campos()" name="monto_gravable" value="<?php echo $lista_documento_partida['pd_monto_gravable']; ?>">
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-xs-12">IMPUESTO</label>
                          <div class="col-xs-12">
                              <input class="form-control" readonly type="text" id="text4" name="impuesto" value="<?php echo $lista_documento_partida['pd_impuesto']; ?>">
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-xs-12" for="register1-email">TOTAL</label>
                          <div class="col-xs-12">
                              <input class="form-control" readonly name="total" id="text3" value="<?php echo $lista_documento_partida['pd_monto_total']; ?>">
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-md-4 control-label" ></label>
                          <div class="col-md-7">
                              <label class="rad-inline" for="example-inline-checkbox1"></label>
                              <label class="rad-inline" for="example-inline-checkbox1"></label>
                          </div>
                      </div>
                      <?php /* ?><div class="form-group">
                          <label class="col-md-4 control-label" >ESTADO DEL DOCUMENTO</label>
                          <div class="col-md-7">
                              <label class="rad-inline" for="example-inline-checkbox1">
                                  <input type="radio" id="example-inline-checkbox1" name="estado_documento" value="1" <?php if($lista_documento_partida['pd_stat'] == 1){ echo 'checked';} ?> > Activa
                              </label>
                              <label class="rad-inline" for="example-inline-checkbox1">
                                  <input type="radio" id="example-inline-checkbox2" name="estado_documento" value="0" <?php if($lista_documento_partida['pd_stat'] == 0){ echo 'checked';} ?> > Inactiva
                              </label>
                          </div>
                      </div><?php */ ?>
                      <div class="modal-footer">
                          <button class="btn btn-sm btn-default" type="button" data-dismiss="modal">Cancelar</button>
                          <button class="btn btn-sm btn-primary" type="submit" >Guardar cambios</button>
                          <input type="hidden" name="id_partida" value="<?php echo $lista_documento_partida['id_partida']; ?>">
                          <input type="hidden" name="m_total_anterior" value="<?php echo $lista_documento_partida['pd_monto_total']; ?>">
                      </div>
                  </div>
              </div>
            </div>
        </div>
    </form>
<?php } ?>
