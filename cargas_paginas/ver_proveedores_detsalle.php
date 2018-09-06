<?php include_once("../conexion/conexion.php"); ?>
<?php $sql_proveedores = $conexion2->query("select * from todos_proveedores where id_proveedores ='".$_GET['id']."'"); ?>
<?php while($lista_todos_proveedores = $sql_proveedores -> fetch_array()){ ?>

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
                              <input class="form-control" type="text" id="register1-username" name="id_proveedor" readonly="readonly" value="<?php echo $lista_todos_proveedores['id_proveedores']; ?>">
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-xs-12" for="register1-username">PAIS</label>
                          <div class="col-xs-12">
                              <select class="js-select2 form-control" name="id_pais" style="width: 100%;" data-placeholder="Seleccionar un pais" required="required">
                                  <option value="0"> Selecciona un pais</option>
                                  <?php
                                  $strConsulta = "select id_paises, ps_nombre_pais from maestro_paises";
                                  $result = $conexion2->query($strConsulta);
                                  $opciones = '<option value="0"> Elige un pais </option>';
                                  while($fila = $result->fetch_array()){ ?>
                                          <option value="<?php echo $fila['id_paises']; ?>" <?php if($lista_todos_proveedores['pro_pais'] == $fila['id_paises']){ echo 'selected';} ?> ><?php echo $fila['ps_nombre_pais']; ?></option>
                                  <?php  } ?>
                              </select>
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-xs-12" for="register1-username">NOMBRE COMERCIAL</label>
                          <div class="col-xs-12">
                              <input class="form-control" type="text" id="register1-username" name="nombre_comercial" value="<?php echo utf8_encode($lista_todos_proveedores['pro_nombre_comercial']); ?>">
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-xs-12" for="register1-email">RAZON SOCIAL</label>
                          <div class="col-xs-12">
                              <input class="form-control" type="text" id="register1-email" name="razon_social" value="<?php echo utf8_encode($lista_todos_proveedores['pro_razon_social']); ?>">
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-xs-12" for="register1-email">RUC</label>
                          <div class="col-xs-12">
                              <input class="form-control" type="text" id="register1-email" name="ruc" value="<?php echo $lista_todos_proveedores['pro_ruc']; ?>">
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-xs-12" >TELEFONO 1</label>
                          <div class="col-xs-12">
                              <input class="form-control" type="text" id="register1-email" name="telefono_1" value="<?php echo $lista_todos_proveedores['pro_telefono_1']; ?>">
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-xs-12">TELEFONO 2</label>
                          <div class="col-xs-12">
                              <input class="form-control" type="text" name="telefono_2" value="<?php echo $lista_todos_proveedores['pro_telefono_2']; ?>">
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-xs-12">EMAIL</label>
                          <div class="col-xs-12">
                              <input class="form-control" type="text" name="email" value="<?php echo $lista_todos_proveedores['pro_email']; ?>">
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-xs-12" for="register1-email">DESCRIPCION</label>
                          <div class="col-xs-12">
                              <textarea class="form-control" name="descripcion"><?php echo utf8_encode($lista_todos_proveedores['pro_descripcion']); ?></textarea>
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-md-4 control-label" ></label>
                          <div class="col-md-7">
                              <label class="rad-inline" for="example-inline-checkbox1"></label>
                              <label class="rad-inline" for="example-inline-checkbox1"></label>
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-md-4 control-label" >Estado de proveedor</label>
                          <div class="col-md-7">
                              <label class="rad-inline" for="example-inline-checkbox1">
                                  <input type="radio" id="example-inline-checkbox1" name="estado" value="1" <?php if($lista_todos_proveedores['pro_status'] == 1){ echo 'checked';}  ?> > Activa
                              </label>
                              <label class="rad-inline" for="example-inline-checkbox1">
                                  <input type="radio" id="example-inline-checkbox2" name="estado" value="0" <?php if($lista_todos_proveedores['pro_status'] == 0){ echo 'checked';}  ?> > Inactiva
                              </label>
                          </div>
                      </div>
                      <div class="modal-footer">
                          <button class="btn btn-sm btn-default" type="button" data-dismiss="modal">Cancelar</button>
                          <button class="btn btn-sm btn-primary" type="submit" >Guardar cambios</button>
                      </div>
                  </div>
              </div>
            </div>
        </div>
    </form>
<?php } ?>
