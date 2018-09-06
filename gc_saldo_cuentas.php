<?php if(!isset($_SESSION)){session_start();}?>
<?php require("conexion/conexion.php"); ?>
<?php require("funciones/funciones.php"); ?>
<?php if(isset($_SESSION['session_gc'])){ ?>
<?php $header_bar = 'base_header.php'; ?>
<?php $menu = true; ?>
<?php /* ################ AUDITORIA DE SEGUIMIENTO ############## */ ?>
<?php require("funciones/funciones_auditorias.php"); ?>
<?php $lugar_mapa = 52; ?>
<?php $dispositivo_acceso = obtener_dispositivo(); ?>
<?php insertar_log_seguimiento($conexion2, ObtenerIP(), $dispositivo_acceso, $lugar_mapa, $_SESSION['session_gc']['usua_id']); ?>
<?php /* ######################################################## */ ?>
<?php require 'inc/config.php'; ?>
<?php require 'inc/views/template_head_start.php'; ?>
<!-- Page JS Plugins CSS -->
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/datatables/jquery.dataTables.min.css">
<?php require 'inc/views/template_head_end.php'; ?>
<?php require 'inc/views/base_head.php'; ?>

<!-- Page Content -->
<div class="content">
    <div class="block">
      <div class="block">
          <div class="block-header">
              <div class="block-options">
                  <code> Este reporte solo muestra las cuentas con algun movimiento bancario.</code>
              </div>
              <h3 class="block-title">Saldo de las cuentas Bancarias</h3>
          </div>
          <div class="block-content">
              <table class="table table-striped">
                  <thead>
                      <tr>
                          <th class="text-center" style="width: 100px;">ID Cuenta</th>
                          <th class="hidden-xs" style="width: 50%;">Cuenta</th>
                          <th class="hidden-xs" style="width: 15%;">Debito</th>
                          <th class="hidden-xs" style="width: 15%;">Credito</th>
                          <th class="hidden-xs" style="width: 15%;">Saldo</th>
                      </tr>
                  </thead>
                  <tbody>
                      <?php $sql_saldo = saldo_cuentas($conexion2);
                            while($lista_saldo = $sql_saldo ->fetch_array()){ ?>
                      <tr>
                          <td class="text-center"><?php echo $lista_saldo['id_cuenta_bancaria']; ?></td>
                          <td><?php echo $lista_saldo['proy_nombre_proyecto']. ' // ' .$lista_saldo['banc_nombre_banco']. ' // ' .$lista_saldo['cta_numero_cuenta']; ?></td>
                          <td class="hidden-xs">
                              <?php echo number_format($lista_saldo['total_debito'], 2, '.', ','); ?>
                          </td>
                          <td class="hidden-xs">
                              <?php echo number_format($lista_saldo['total_credito'], 2, '.', ','); ?>
                          </td>
                          <td class="hidden-xs">
                              <?php echo number_format($lista_saldo['total'], 2, '.', ','); ?>
                          </td>
                      </tr>
                      <?php } ?>
                  </tbody>
              </table>
          </div>
      </div>
    </div>
</div>
<!-- END Page Content -->

<?php require 'inc/views/base_footer.php'; ?>
<?php require 'inc/views/template_footer_start.php'; ?>
<!-- Page JS Plugins -->
<script type="text/javascript" src="bootstrap-filestyle.min.js"> </script>
<script src="<?php echo $one->assets_folder; ?>/js/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo $one->assets_folder; ?>/js/pages/base_tables_datatables.js"></script>

<!-- Page JS Code -->
<script>
    jQuery(function(){
        // Init page helpers (BS Notify Plugin)
        App.initHelpers('notify');
    });
</script>


<?php require 'inc/views/template_footer_end.php'; ?>
<?php }else{ ?>

        <script type="text/javascript">
            window.location="salir.php";
        </script>

<?php } ?>
