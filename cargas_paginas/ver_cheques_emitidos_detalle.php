<?php include_once("../conexion/conexion.php"); ?>
<?php $todos_movimeintos = $conexion2 -> query("select * from cheques_emitidos where id_movimiento_bancario ='".$_GET['id']."'"); ?>
<?php while($lista_movimiento = $todos_movimeintos -> fetch_array()){ ?>

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
                                        <label class="col-xs-12" for="register1-username">ID</label>
                                        <div class="col-xs-12">
                                            <input class="form-control" type="text" id="register1-username" name="id_movimiento" readonly="readonly" value="<?php echo $lista_movimiento['id_movimiento_bancario']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-xs-12" for="register1-username">NOMBRE DEL PROYECTO</label>
                                        <div class="col-xs-12">
                                            <input class="form-control" type="text" id="register1-username" readonly="readonly" value="<?php echo $lista_movimiento['proy_nombre_proyecto']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-xs-12" for="register1-username">BANCO</label>
                                        <div class="col-xs-12">
                                            <input class="form-control" type="text" id="register1-username" readonly="readonly" value="<?php echo $lista_movimiento['banc_nombre_banco']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-xs-12" for="register1-username">CUENTA</label>
                                        <div class="col-xs-12">
                                            <input class="form-control" type="text" id="register1-username" readonly="readonly" value="<?php echo $lista_movimiento['cta_numero_cuenta']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-xs-12" for="register1-username">FECHA</label>
                                        <div class="col-xs-12">
                                            <input class="js-datepicker form-control" readonly="readonly" type="text" id="example-datepicker1" data-date-format="yy-mm-dd" name="fecha" value="<?php echo $lista_movimiento['mb_fecha']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-xs-12" for="register1-username">REFERENCIA</label>
                                        <div class="col-xs-12">
                                            <input class="form-control" type="text" readonly="readonly" id="register1-username" name="referencia" value="<?php echo $lista_movimiento['mb_referencia_numero']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-xs-12" for="register1-username">MONTO</label>
                                        <div class="col-xs-12">
                                            <input class="form-control" type="text" readonly="readonly" id="register1-username" name="monto" value="<?php echo $lista_movimiento['mb_monto']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-xs-12" for="register1-username">DESCRIPCION</label>
                                        <div class="col-xs-12">
                                            <textarea class="form-control" readonly="readonly" type="text" id="register1-username" name="descripcion"><?php echo $lista_movimiento['mb_descripcion']; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-xs-12" for="register1-username">TIPO TRANSFERENCIA</label>
                                        <div class="col-xs-12">
                                            <input class="form-control" type="text" id="register1-username" readonly="readonly" value="<?php echo $lista_movimiento['tmb_nombre']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-xs-12" for="register1-username"></label>
                                        <div class="col-xs-12">

                                        </div>
                                    </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label" >ANULAR CHEQUE</label>
                                            <div class="col-md-7">
                                                <label class="rad-inline" for="example-inline-checkbox1">
                                                    <input type="radio" id="example-inline-checkbox1" name="stat" value="12" <?php if($lista_movimiento['mb_stat'] == 1){ echo 'checked';}  ?> > SI
                                                </label>
                                                <label class="rad-inline" for="example-inline-checkbox1">
                                                    <input type="radio" id="example-inline-checkbox2" name="stat" value="11" <?php if($lista_movimiento['mb_stat'] == 0){ echo 'checked';}  ?> > NO
                                                </label>
                                            </div>
                                        </div>
                    <div class="modal-footer">
                        <button class="btn btn-sm btn-default" type="button" data-dismiss="modal">Cancelar</button>
                        <button class="btn btn-sm btn-primary" type="submit" >Guardar cambios</button>
                    </div>
        </div>
    </div>
</form>
<?php } ?>
