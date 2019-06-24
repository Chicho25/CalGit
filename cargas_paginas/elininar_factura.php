<div class="modal-content">
    <div class="block block-themed block-transparent remove-margin-b">
        <div class="block-header bg-primary-dark">
            <ul class="block-options">
                <li>
                    <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                </li>
            </ul>
            <h3 class="block-title">Eliminar &amp; La factura</h3>
        </div>
        <div class="block-content">
            Esta seguro que desea eliminar La factura ?
        </div>
    </div>
    <div class="modal-footer">
      <form class="" action="" method="post">
        <button class="btn btn-sm btn-default" type="button" data-dismiss="modal">Cerrar</button>
        <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-check"></i> Ok</button>
        <input type="hidden" name="eliminar" value="<?php echo $_GET['id']; ?>">
      </form>
    </div>
</div>
