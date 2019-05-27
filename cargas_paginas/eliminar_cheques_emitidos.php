  <form action="" method="post" enctype="multipart/form-data">
      <div class="block block-themed block-transparent remove-margin-b">
          <div class="block-header bg-primary-dark">
              <ul class="block-options">
                  <li>
                      <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                  </li>
              </ul>
              <h3 class="block-title">Eliminar Cheque</h3>
          </div>
          <div class="block-content">
              <!-- Bootstrap Register -->
              <div class="block block-themed">
                  <div class="block-content">
                      <div class="form-group">
                          <label class="col-xs-12" for="register1-username">ID</label>
                          <div class="col-xs-12">
                              <input class="form-control" type="text" id="register1-username" name="eliminar" readonly="readonly" value="<?php echo $_GET['id']; ?>">
                          </div>
                      </div>
                      <h4 style="color:red;">Esta Seguro que desea Eliminar el cheque</h4>

                      <div class="modal-footer">
                          <button class="btn btn-sm btn-default" type="button" data-dismiss="modal">Cancelar</button>
                          <button class="btn btn-sm btn-primary" type="submit" >Eliminar</button>
                      </div>
                  </div>
              </div>
            </div>
        </div>
    </form>
