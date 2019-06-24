
<form action="" method="post">
<div class="block block-themed block-transparent remove-margin-b">
    <div class="block-header bg-primary-dark">
        <ul class="block-options">
            <li>
                <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
            </li>
        </ul>
        <h3 class="block-title">Pagar Factura</h3>
    </div>
    <div class="block-content">
              <!-- Bootstrap Register -->
        <div class="block block-themed">
            <div class="block-content">
                <div class="form-group">
                    <label class="col-xs-12" for="register1-username">Monto</label>
                    <div class="col-xs-12">
                    <input type="number" max="<?php echo $_GET['monto_max']; ?>" class="form-control" name="monto" value="">
                </div>
                <div class="form-group">
                    <label class="col-xs-12" for="register1-username"></label>
                    <div class="col-xs-12">
                    </div>
                </div>
          <div class="modal-footer">
              <button class="btn btn-sm btn-default" type="button" data-dismiss="modal">Cancelar</button>
              <button class="btn btn-sm btn-primary" name="pagar_factura" type="submit" >Guardar</button>
              <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
          </div>
        </div>
    </div>
  </div>
</div>
</form>
