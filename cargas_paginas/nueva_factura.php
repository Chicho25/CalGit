<?php include('../conexion/conexion2.php'); ?>
<?php include('../funciones/funciones.php'); ?>
<form action="" method="post">

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
                    <label class="col-xs-12" for="register1-username">Cliente</label>
                    <div class="col-xs-12">
                      <select class="js-select2 form-control" name="id_cliente" style="width: 100%;" require="require" data-placeholder="Seleccionar un Cliente">
                          <option value=""> Selecciona un Cliente</option>
                          <?php
                                  $result = todos_clientes_activos($conexion2);
                                  $opciones = '<option value=""> Elige un Cliente </option>';
                                  while($fila = $result->fetch_array()){ ?>
                                    <option value="<?php echo $fila['id_cliente']; ?>"><?php echo $fila['cl_nombre'].' '.$fila['cl_apellido']; ?></option>
                          <?php  } ?>
                      </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12" for="register1-username">Fecha</label>
                    <div class="col-xs-12">
                        <input class="form-control" type="date" name="fecha" required value="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12" for="register1-username"></label>
                    <div class="col-xs-12">
                    </div>
                </div>
          <div class="modal-footer">
              <button class="btn btn-sm btn-default" type="button" data-dismiss="modal">Cancelar</button>
              <button class="btn btn-sm btn-primary" name="reg_factura" type="submit" >Guardar</button>
          </div>
        </div>
    </div>
  </div>
</div>
</form>
