<?php include_once("../conexion/conexion.php"); ?>
<?php include_once("../funciones/funciones.php"); ?>
<?php $datos_contrato = $conexion2 -> query("select
                                                mp.proy_nombre_proyecto,
                                                mv.id_proyecto,
                                                gi.gi_nombre_grupo_inmueble,
                                                mv.id_grupo_inmueble,
                                                mi.mi_nombre,
                                                mi.mi_codigo_imueble,
                                                mv.id_inmueble,
                                                mv.mv_precio_venta,
                                                mv.mv_descripcion,
                                                mv.mv_reserva,
                                                mv.mv_id_reserva,
                                                mv.mv_status,
                                                mc.cl_nombre,
                                                mc.cl_apellido,
                                                mv.id_cliente,
                                                mv.id_venta,
                                                mv.fecha_venta,
                                                mv.termino
                                                from
                                                maestro_ventas mv inner join maestro_proyectos mp on mv.id_proyecto = mp.id_proyecto
                                                inner join grupo_inmuebles gi on mv.id_grupo_inmueble = gi.id_grupo_inmuebles
                                                inner join maestro_inmuebles mi on mv.id_inmueble = mi.id_inmueble
                                                inner join maestro_clientes mc on mv.id_cliente = mc.id_cliente
                                                where
                                                mp.id_proyecto = 13
                                                and
                                                mi.id_inmueble = '".$_GET['id']."' "); ?>
<?php while($datos_inmueble = $datos_contrato -> fetch_array()){
              $id_contrato = $datos_inmueble['id_venta'];
              $id_inmueble = $datos_inmueble['id_inmueble'];
              $nombre_inmueble = $datos_inmueble['mi_nombre'];
              $nombre_cliente = $datos_inmueble['cl_nombre'].' '.$datos_inmueble['cl_apellido'];
              $codigo = $datos_inmueble['mi_codigo_imueble'];
              $precio_venta = $datos_inmueble['mv_precio_venta'];
              $descripcion = $datos_inmueble['mv_descripcion'];
              $fecha = $datos_inmueble['fecha_venta'];
              $termino = $datos_inmueble['termino'];
} ?>

<form action="" method="post" enctype="multipart/form-data">
      <div class="block block-themed block-transparent remove-margin-b">
          <div class="block-header bg-primary-dark">
              <ul class="block-options">
                  <li>
                      <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                  </li>
              </ul>
              <h3 class="block-title">Detalle del Slip <?php echo $nombre_inmueble; ?></h3>
          </div>
          <div class="block-content">
              <!-- Bootstrap Register -->
              <div class="block block-themed">
                  <div class="block-content">
                      <div class="form-group">
                          <label class="col-xs-12" for="register1-username" style="text-align: left;">Cliente: <?php echo $nombre_cliente; ?></label>
                          <div class="col-xs-12">
                          <label class="col-xs-12" for="register1-username" style="text-align: left;">Slip: <?php echo $nombre_inmueble; ?></label>
                          <div class="col-xs-12">
                          </div>
                          <label class="col-xs-12" for="register1-username" style="text-align: left;">Codigo: <?php echo $codigo; ?></label>
                          <div class="col-xs-12">
                          </div>
                          <label class="col-xs-12" for="register1-username" style="text-align: left;">Precio de venta: <?php echo number_format($precio_venta, 2, '.',','); ?></label>
                          <div class="col-xs-12">
                          </div>
                          <label class="col-xs-12" for="register1-username" style="text-align: left;">Fecha: <?php echo $fecha; ?></label>
                          <div class="col-xs-12">
                          </div>
                          <label class="col-xs-12" for="register1-username" style="text-align: left;">Descripcion: <?php echo $descripcion; ?></label>
                          <div class="col-xs-12">
                          </div>
                          <label class="col-xs-12" for="register1-username" style="text-align: left;">Termino: <?php if($termino ==1){ echo 'Transito';}elseif($termino == 2){ echo 'Permanente'; }else{ echo '-'; } ; ?></label>
                          <div class="col-xs-12">
                            <input type="hidden" name="id_venta_contrato" value="<?php echo $id_contrato; ?>">
                          </div>
                          <label class="col-xs-12" for="register1-username" style="text-align: left;">Cambiar Slip:

                            <?php

                            $puestos = $conexion2 -> query("SELECT
                                                            *,
                                                            mi.id_inmueble as id_inm,
                                                            count(*)
                                                            FROM
                                                            maestro_inmuebles mi left join maestro_ventas mv on mi.id_inmueble = mv.id_inmueble
                                                            WHERE
                                                            mi.id_grupo_inmuebles in(23,26,24,25)
                                                            and
                                                            mi.mi_status not in(17)
                                                            group by mi_nombre
                                                            order by mi_nombre desc");

                             ?>
                               <select name="slipt_position" class="form-control" style="width:400px;">
                                 <option value="">Seleccionar</option>
                                 <?php while ($lista = $puestos -> fetch_array()) {
                                   if($lista['id_inmueble'] != ''){ continue; }else{  } ?>
                                   <option value="<?php echo $lista['id_inm']; ?>"><?php echo $lista['mi_nombre'] ?></option>
                                 <?php } ?>
                               </select>
                               <input type="hidden" name="slipt_old" value="<?php echo $id_inmueble; ?>">
                               <input type="hidden" name="id_ventas" value="<?php echo $id_contrato; ?>">
                          </label>
                          <div class="col-xs-12">
                          </div>
                          <!--<hr>
                         <label class="col-xs-12" for="register1-username" style="text-align: left;">ESLORA (pies): </label>
                         <label class="col-xs-12" for="register1-username" style="text-align: left;">ESLORA (m): </label>
                         <label class="col-xs-12" for="register1-username" style="text-align: left;">MANGA (m): </label>
                         <label class="col-xs-12" for="register1-username" style="text-align: left;">PLAZAS: </label>
                         <hr>-->
                      </div>

            <div class="form-group">
                <div class="col-xs-12">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>NUMERO</th>
                                <th class="hidden-xs" >FECHA VENCIMIENTO</th>
                                <th class="hidden-xs" >DESCRIPCION</th>
                                <th class="hidden-xs" >ESTATUS DE LA CUOTA</th>
                                <th class="hidden-xs" >MONTO DOCUMENTO</th>
                                <th class="hidden-xs" >MONTO PAGADO</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $todos_contratos_ventas = todos_cuotas_id_contrato($conexion2, $id_contrato); ?>
                            <?php while($lista_todos_contratos_ventas = mysqli_fetch_array($todos_contratos_ventas)){

                                        $precio = $lista_todos_contratos_ventas['mv_precio_venta'];
                            ?>
                            <tr>
                                <td class="text-center"><?php echo $lista_todos_contratos_ventas['mc_numero_cuota']; ?></td>
                                <td class="hidden-xs"><?php echo date("d-m-Y", strtotime($lista_todos_contratos_ventas['mc_fecha_vencimiento'])); ?></td>
                                <td class="hidden-xs"><?php echo $lista_todos_contratos_ventas['mc_descripcion']; ?></td>
                                <td class="hidden-xs" <?php if($lista_todos_contratos_ventas['mc_monto'] == $lista_todos_contratos_ventas['mc_monto_abonado']){?> style="background-color:#00B812"
                                                    <?php }elseif($lista_todos_contratos_ventas['mc_monto'] > $lista_todos_contratos_ventas['mc_monto_abonado'] &&
                                                                    $lista_todos_contratos_ventas['mc_monto_abonado'] > 0 ){?> style="background-color:#FAD401"
                                                    <?php }elseif($lista_todos_contratos_ventas['mc_monto_abonado'] == 0){?> style="background-color:#FF0000; color:white;" <?php } ?> >

                                    <?php if($lista_todos_contratos_ventas['mc_monto'] == $lista_todos_contratos_ventas['mc_monto_abonado']){?> PAGADA
                                    <?php }elseif($lista_todos_contratos_ventas['mc_monto'] > $lista_todos_contratos_ventas['mc_monto_abonado'] &&
                                                $lista_todos_contratos_ventas['mc_monto_abonado'] > 0 ){?> ABONADA
                                    <?php }elseif($lista_todos_contratos_ventas['mc_monto_abonado'] == 0){?> PENDIENTE/ SIN ABONAR <?php } ?>
                                </tb>
                                <td class="text-center"><?php echo number_format($lista_todos_contratos_ventas['mc_monto'], 2, '.',','); ?></td>
                                <td class="text-center"><?php echo number_format($lista_todos_contratos_ventas['mc_monto_abonado'], 2, '.',','); ?></td>
                            </tr>
                            <?php } ?>
                            <tr>
                                <td class="text-center font-w600" colspan="1">Numero de cuotas: <?php echo numero_cuotas($conexion2, $id_contrato); ?></td>
                                <td class="text-center font-w600" colspan="2">Monto por pagar: <?php echo number_format($precio - suma_cuota($conexion2, $id_contrato), 2, '.',','); ?></td>
                                <td class="text-center font-w600" colspan="2">Monto Pagado: <?php  echo number_format(suma_cuota($conexion2, $id_contrato), 2, '.',',');?> </td>
                                <td class="text-center font-w600" colspan="3">Costo Inmueble: <?php echo number_format($precio, 2, '.',','); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

                      <div class="modal-footer">
                          <button class="btn btn-sm btn-default" type="button" data-dismiss="modal">Cerrar</button>
                          <button class="btn btn-sm btn-primary" type="submit" >Cambiar Slip</button>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </form>
