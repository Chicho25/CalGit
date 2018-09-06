<?php include_once("../conexion/conexion.php"); ?>

<?php 	function crear_facturas($conexion){

				$sql_crear_facturas = $conexion -> query("SELECT
																										mp.id,
																									(select
																										mpy.proy_nombre_proyecto
																									 from
																										maestro_proyectos mpy
																									 where
																										mpy.id_proyecto = mp.id_proyecto) AS proyecto,
																										mp.p_nombre
																									 FROM
																										maestro_partidas mp
																									 WHERE
																										mp.p_monto <> mp.p_ejecutado
																									 AND
																										mp.p_monto <> mp.p_reservado
																									 AND
																										mp.id_padre is not null");

				return $sql_crear_facturas;

}  ?>

<?php $sql_inmuebles = $conexion2->query("select * from maestro_inmuebles where id_inmueble ='".$_GET['id']."'"); ?>
<?php while($lista_todos_inmuebles = $sql_inmuebles -> fetch_array()){ ?>

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
                              <input class="form-control" type="text" id="register1-username" name="id_inmueble" readonly="readonly" value="<?php echo $lista_todos_inmuebles['id_inmueble']; ?>"></input>
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-xs-12" for="register1-username">Proyecto</label>
                          <div class="col-xs-12">
                              <?php
                              $strConsulta = "select * from maestro_proyectos where id_proyecto = '".$lista_todos_inmuebles['id_proyecto']."' and proy_estado = 1";
                              $result = $conexion2->query($strConsulta);
                              while($fila = $result->fetch_array()){ ?>
                                      <input type="hidden" name="id_proyecto" value="<?php echo $fila['id_proyecto']; ?>">
                                      <input class="form-control" type="text" id="register1-username" readonly="readonly" value="<?php echo $fila['proy_nombre_proyecto']; ?>">
                              <?php } ?>
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-xs-12" for="register1-username">Grupo</label>
                          <div class="col-xs-12">
                              <select class="js-select2 form-control" name="id_grupo_inmuebles" style="width: 100%;" data-placeholder="Seleccionar Grupo de inmueble" required="required">
                                  <option value="0"> Selecciona Grupo de inmueble</option>
                                  <?php
                                  $strConsulta = "select * from grupo_inmuebles where gi_status = 1";
                                  $result = $conexion2->query($strConsulta);
                                  $opciones = '<option value="0"> Elige un grupo de inmueble </option>';
                                  while($fila = $result->fetch_array()){ ?>
                                          <option value="<?php echo $fila['id_grupo_inmuebles']; ?>" <?php if($lista_todos_inmuebles['id_grupo_inmuebles'] == $fila['id_grupo_inmuebles']){ echo 'selected';} ?> ><?php echo $fila['gi_nombre_grupo_inmueble']; ?></option>
                                  <?php } ?>
                              </select>
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-xs-12" for="register1-username">Nombre</label>
                          <div class="col-xs-12">
                              <input class="form-control" type="text" name="nombre" placeholder="Nombre" required="required" value="<?php echo $lista_todos_inmuebles['mi_nombre']; ?>"></input>
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-xs-12" for="register1-username">Precio</label>
                          <div class="col-xs-12">
                               <input class="form-control" type="text" name="precio" placeholder="Precio" required="required" value="<?php echo $lista_todos_inmuebles['mi_precio_real']; ?>"></input>
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-xs-12" for="register1-username">Modelo</label>
                          <div class="col-xs-12">
                               <input class="form-control" type="text" name="modelo" placeholder="Modelo" required="required" value="<?php echo $lista_todos_inmuebles['mi_modelo']; ?>"></input>
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-xs-12" for="register1-username">Area</label>
                          <div class="col-xs-12">
                              <input class="form-control" type="text" name="area" placeholder="Area" required="required" value="<?php echo $lista_todos_inmuebles['mi_area']; ?>"></input>
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-xs-12" for="register1-username">Tipo Inmuebles</label>
                          <div class="col-xs-12">
                              <select class="js-select2 form-control" name="tipo_inmuebles" style="width: 100%;" data-placeholder="Seleccionar un tipo de inmueble" required="required">
                                  <option value="0"> Selecciona tipo de inmueble</option>
                                  <?php
                                          $strConsulta = "select * from tipo_inmuebles where im_status = 1";
                                          $result = $conexion2->query($strConsulta);
                                          $opciones = '<option value="0"> Elige tipo de inmueble </option>';
                                          while($fila = $result->fetch_array()){ ?>
                                                  <option value="<?php echo $fila['id_inmuebles']; ?>" <?php if($lista_todos_inmuebles['id_tipo_inmuebles'] == $fila['id_inmuebles']){ echo 'selected';} ?> ><?php echo $fila['im_nombre_inmueble']; ?></option>
                                  <?php } ?>
                              </select>
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-xs-12" for="register1-username">Habitaciones</label>
                          <div class="col-xs-12">
                              <select name="habitaciones" class="js-select2 form-control" required="required" style="width: 100%;">
                                  <option value="">Selecciona un numero</option>
                                  <?php for($i=0 ; $i <= 10; $i++){ ?>
                                  <option value="<?php echo $i; ?>" <?php if($lista_todos_inmuebles['mi_habitaciones'] == $i){ echo 'selected';} ?> ><?php echo $i; ?></option>
                                  <?php }  ?>
                              </select>
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-xs-12" for="register1-username">Sanitarios</label>
                          <div class="col-xs-12">
                              <select name="banios" class="js-select2 form-control" required="required" style="width: 100%;">
                                  <option value="">Selecciona un numero</option>
                                  <?php  for($i=0 ; $i <= 10; $i++){ ?>
                                      <option value="<?php echo $i; ?>" <?php if($lista_todos_inmuebles['mi_sanitarios'] == $i){ echo 'selected';} ?> ><?php echo $i; ?></option>
                                  <?php } ?>
                              </select>
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-xs-12" for="register1-username">Depositos</label>
                          <div class="col-xs-12">
                              <select name="depositos" class="js-select2 form-control" required="required" style="width: 100%;">
                                  <option value="">Selecciona un numero</option>
                                  <?php  for($i=0 ; $i <= 10; $i++){ ?>
                                      <option value="<?php echo $i; ?>" <?php if($lista_todos_inmuebles['mi_depositos'] == $i){ echo 'selected';} ?> ><?php echo $i; ?></option>
                                  <?php } ?>
                              </select>
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-xs-12" for="register1-username">Estacionamientos</label>
                          <div class="col-xs-12">
                              <select name="estacionamientos" class="js-select2 form-control" required="required" style="width: 100%;">
                                  <option value="">Selecciona un numero</option>
                                  <?php  for($i=0 ; $i <= 10; $i++){ ?>
                                      <option value="<?php echo $i; ?>" <?php if($lista_todos_inmuebles['mi_estacionamientos'] == $i){ echo 'selected';} ?> ><?php echo $i; ?></option>
                                  <?php }  ?>
                              </select>
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-xs-12" for="register1-username">Porc. Comision</label>
                          <div class="col-xs-12">
                              <input class="form-control" type="text"  name="porcentaje_comision" placeholder="Porcentaje Comision" required="required" value="<?php echo $lista_todos_inmuebles['mi_porcentaje_comision']; ?>"></input>
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-xs-12" for="register1-username">Partida Comision</label>
                          <div class="col-xs-12">
                              <?php /* ?><input class="form-control" type="text"  name="partida_comision" placeholder="Partida Comision" required="required" value="<?php echo $lista_todos_inmuebles['mi_id_partida_comision']; ?>"></input>
                              */ ?><select class="js-select2 form-control" id="val-select2" name="partida_comision" style="width: 100%;" data-placeholder="Partida Comision" required="required">
                                  <option></option>
                                  <?php $sql_proyecto = crear_facturas($conexion2); ?>
                                  <?php while($lista_proyecto = $sql_proyecto -> fetch_array()){ ?>
                                  <?php $suma = $lista_partida['p_reservado'] + $lista_partida['p_ejecutado']; ?>
                                  <?php if($lista_partida['p_reservado'] != 0 && $lista_partida['p_ejecutado'] !=0 && $suma == $lista_partida['p_monto']){ continue; } ?>
                                  <option value="<?php echo $lista_proyecto['id']; ?>"
                                  <?php if($lista_todos_inmuebles['mi_id_partida_comision']==$lista_proyecto['id']){echo 'selected';} ?>
                                  ><?php echo $lista_proyecto['proyecto'].' // '.$lista_proyecto['p_nombre']; ?></option>
                                  <?php } ?>
                              </select>
                          </div>
                      </div>

                      <div class="form-group">
                          <label class="col-xs-12" for="register1-username">Observaciones</label>
                          <div class="col-xs-12">
                              <textarea class="form-control" name="observaciones" placeholder="Observaciones"><?php echo $lista_todos_inmuebles['mi_observaciones']; ?></textarea>
                          </div>
                      </div>

											<div class="form-group">
                          <label class="col-xs-12" for="register1-username">ESTADO</label>
													<div class="col-xs-12">
														<select class="js-select2 form-control" id="val-select2" name="estado" style="width: 100%;">
																<option></option>
																<?php $sql_proyecto = $conexion2 -> query("SELECT * FROM maestro_status WHERE id_status in(1,2,3,4)"); ?>
																<?php while($lista_proyecto = $sql_proyecto -> fetch_array()){ ?>
																<option value="<?php echo $lista_proyecto['st_numero']; ?>" <?php if($lista_todos_inmuebles['mi_status']==$lista_proyecto['st_numero']){ echo "selected";} ?>><?php echo $lista_proyecto['st_nombre']; ?></option>
																<?php } ?>
														</select>
													</div>
											</div>

                      <div class="form-group">
                          <label class="col-md-4 control-label" >DISPONIBLE</label>
                          <div class="col-md-7">
                              <label class="rad-inline" for="example-inline-checkbox1">
                                  <input type="radio" id="example-inline-checkbox1" name="disponible" value="1" <?php if($lista_todos_inmuebles['mi_disponible'] == 1){ echo 'checked';}  ?> ></input> Activa
                              </label>
                              <label class="rad-inline" for="example-inline-checkbox1">
                                  <input type="radio" id="example-inline-checkbox2" name="disponible" value="0" <?php if($lista_todos_inmuebles['mi_disponible'] == 0){ echo 'checked';}  ?> ></input> Inactiva
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
