<?php if(!isset($_SESSION)){session_start();}?>
<?php require("conexion/conexion.php"); ?>
<?php require("funciones/funciones.php");

  $excelPrint = '<table border="1">
                  <thead>
                      <tr>
                        <th colspan="8">'.$_SESSION['nombre_banco'].'</th>
                      </tr>
                      <tr>
                          <th class="hidden-xs" style="width: 5%;">DIA</th>
                          <th class="hidden-xs" style="width: 5%;">TIPO</th>
                          <th class="hidden-xs" style="width: 5%;">NUMERO</th>
                          <th class="text-center" style="width: 20%;">DESCRIPCION</th>
                          <th class="hidden-xs" style="width: 20%;">CLIENTE/PROVEEDOR</th>
                          <th class="hidden-xs" style="width: 5%;">DEBITO</th>
                          <th class="hidden-xs" style="width:5%;">CREDITO</th>
                          <th class="text-center" style="width: 5%;">SALDO</th>
                      </tr>
                  </thead>
                  <tbody>';
                   $estado_cuenta = estado_cuenta_bancario($conexion2, $_SESSION['id_cuenta'], $_SESSION['fdoc_inicio'], $_SESSION['fdoc_fin']);
                   //$_numeros = $estado_cuenta->num_rows;
                   //$lista  = $estado_cuenta->fetch_all(MYSQLI_ASSOC);
                          // js-dataTable-full
                      while ($lista_estado_cuenta = $estado_cuenta->fetch_array()) {
                      $tipo = ($lista_estado_cuenta['tmb_nombre'] != 'CHEQUE') ? '---' : $lista_estado_cuenta['mb_numero_cheque'];
          $excelPrint .= '<tr>
                              <td class="hidden-xs">'.$lista_estado_cuenta['fecha_completa'].'</td>
                              <td class="hidden-xs">'.$lista_estado_cuenta['nombre_tipo'].'</td>
                              <td class="hidden-xs">'.$tipo.'</td>
                              <td class="font-w600">'.$lista_estado_cuenta['mb_descripcion'].'</td>
                              <td class="hidden-xs">'.$lista_estado_cuenta['pro_nombre_comercial'].' '.$lista_estado_cuenta['cl_nombre'].' '.$lista_estado_cuenta['cl_apellido'].'</td>
                              <td class="hidden-xs">'.number_format($lista_estado_cuenta['debito'], 2, '.',',').'</td>
                              <td class="hidden-xs">'.number_format($lista_estado_cuenta['credito'], 2, '.',',').'</td>
                              <td class="text-center">'.number_format($lista_estado_cuenta['saldo'], 2, '.',',').'</td>
                          </tr>';
                       }
      $excelPrint .='</tbody>
  </table>';
  header('Content-Type: application/xls');
  header('Content-Disposition: attachment; filename='.$_SESSION['nombre_banco'].'.xls');
  echo $excelPrint;
