<!-- .aside -->
        <aside class="bg-black aside-md hidden-print hidden-xs" id="nav">
          <section class="vbox">
            <section class="w-f scrollable">
              <div class="slim-scroll" data-height="auto" data-disable-fade-out="true" data-distance="0" data-size="10px" data-railOpacity="0.2">
                <div class="clearfix wrapper dk nav-user hidden-xs">
                  <div class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                      <span class="thumb avatar pull-left m-r">
                        <?php
                          $getuserDetail = GetRecord("users", "id =".$_SESSION['USER_ID']);

                          if(isset($getuserDetail['image']) && $getuserDetail['image'] != '')
                            $uimage = $getuserDetail['image'];
                          else
                            $uimage = "images/p0.jpg";
                        ?>
                        <img src="<?php echo $uimage;?>" class="dker" alt="...">
                        <i class="on md b-black"></i>
                      </span>
                      <span class="hidden-nav-xs clear">
                        <span class="block m-t-xs">
                          <strong class="font-bold text-lt"><?php echo $_SESSION['USER_NAME']?></strong>
                          <b class="caret"></b>
                        </span>
                        <span class="text-muted text-xs block"></span>
                      </span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                      <!-- <li>
                        <span class="arrow top hidden-nav-xs"></span>
                        <a href="#">Settings</a>
                      </li>
                      <li>
                        <a href="profile.html">Profile</a>
                      </li>
                      <li>
                        <a href="docs.html">Help</a>
                      </li>
                      <li class="divider"></li> -->
                      <li>
                        <a href="salir.php"  >Salir</a>
                      </li>
                    </ul>
                  </div>
                </div>
                <!-- nav -->
                <nav class="nav-primary hidden-xs">
                  <div class="text-muted text-sm hidden-nav-xs padder m-t-sm m-b-sm"><a href="main.php">Principal</a></div>
                  <ul class="nav nav-main" data-ride="collapse">
                    <?php if($_SESSION['USER_ROLE'] == 1) : ?>
                    <li <?php if(isset($userclass)) echo $userclass;?>>
                      <a href="#" class="auto">
                        <span class="pull-right text-muted">
                          <i class="i i-circle-sm-o text"></i>
                          <i class="i i-circle-sm text-active"></i>
                        </span>
                        <i class="i i-dot"></i>
                        <span>Usuarios</span>
                      </a>
                      <ul class="nav dker">
                        <li <?php if(isset($registerclass)) echo $registerclass;?>>
                          <a href="register.php"><i class="i i-dot"></i>
                            <span>Registrar Usuarios</span>
                          </a>
                        </li>
                        <li <?php if(isset($userlistclass)) echo $userlistclass;?>>
                          <a href="users.php"><i class="i i-dot"></i>
                            <span>Ver Usuarios</span>
                          </a>
                        </li>
                      </ul>
                    </li>

                    <?php /////////////////////////////////////////////////////////////////////// ?>
                    <li <?php if(isset($mantenimientoclass)) echo $mantenimientoclass;?>>
                      <a href="#" class="auto">
                        <span class="pull-right text-muted">
                          <i class="i i-circle-sm-o text"></i>
                          <i class="i i-circle-sm text-active"></i>
                        </span>
                        <i class="i i-dot"></i>
                        <span>Mantenimiento</span>
                      </a>
                      <ul class="nav dker">

                        <li <?php if(isset($classcountry)) echo $classcountry;?>>
                          <a href="update_cost_currently.php"><i class="i i-dot"></i>
                            <span>Taza Diaria</span>
                          </a>
                        </li>

                        <li <?php if(isset($classcountry)) echo $classcountry;?>>
                          <a href="add_country.php"><i class="i i-dot"></i>
                            <span>Registrar Pais</span>
                          </a>
                        </li>

                        <li <?php if(isset($editCountry)) echo $editCountry;?>>
                          <a href="view_country.php"><i class="i i-dot"></i>
                            <span>Ver Paises</span>
                          </a>
                        </li>
                        <li <?php if(isset($bankclass)) echo $bankclass;?>>
                          <a href="register_bank.php"><i class="i i-dot"></i>
                            <span>Registrar Banco</span>
                          </a>
                        </li>
                        <li <?php if(isset($viewback)) echo $viewback;?>>
                          <a href="view_bank.php"><i class="i i-dot"></i>
                            <span>Ver Bancos</span>
                          </a>
                        </li>
                        <li <?php if(isset($addAcount)) echo $addAcount;?>>
                          <a href="add_acount.php"><i class="i i-dot"></i>
                            <span>Registrar Cuenta</span>
                          </a>
                        </li>
                        <li <?php if(isset($editAcount)) echo $editAcount;?>>
                          <a href="view_acount.php"><i class="i i-dot"></i>
                            <span>Ver Cuenta</span>
                          </a>
                        </li>
                      </ul>
                    </li>

                    <li <?php if(isset($bankclass)) echo $bankclass;?>>
                      <a href="#" class="auto">
                        <span class="pull-right text-muted">
                          <i class="i i-circle-sm-o text"></i>
                          <i class="i i-circle-sm text-active"></i>
                        </span>
                        <i class="i i-dot"></i>
                        <span>Bancos</span>
                      </a>
                      <ul class="nav dker">
                        <li <?php if(isset($addMov)) echo $addMov;?>>
                          <a href="register_mov_bank.php"><i class="i i-dot"></i>
                            <span>Registro Movimiento</span>
                          </a>
                        </li>
                      </ul>
                      <ul class="nav dker">
                        <li <?php if(isset($viewMov)) echo $viewMov;?>>
                          <a href="mov_view.php"><i class="i i-dot"></i>
                            <span>Ver Movimientos</span>
                          </a>
                        </li>
                      </ul>
                      <ul class="nav dker">
                        <li <?php if(isset($registerPay)) echo $registerPay;?>>
                          <a href="#"><i class="i i-dot"></i>
                            <span>Saldos</span>
                          </a>
                        </li>
                      </ul>
                      <ul class="nav dker">
                        <li <?php if(isset($registerPay)) echo $registerPay;?>>
                          <a href="#"><i class="i i-dot"></i>
                            <span>Estado de cuenta</span>
                          </a>
                        </li>
                      </ul>
                    </li>
                    <?php endif;?>
                     <?php if($_SESSION['USER_ROLE'] == 1 || $_SESSION['USER_ROLE'] == 4 ) : ?>
                    <li <?php if(isset($pay)) echo $pay;?>>
                      <a href="#" class="auto">
                        <span class="pull-right text-muted">
                          <i class="i i-circle-sm-o text"></i>
                          <i class="i i-circle-sm text-active"></i>
                        </span>
                        <i class="i i-dot"></i>
                        <span>Ventas</span>
                      </a>
                      <ul class="nav dker">
                        <li <?php if(isset($payusers)) echo $payusers;?>>
                          <a href="averages_users.php"><i class="i i-dot"></i>
                            <span>Pago Usuario / Central</span>
                          </a>
                        </li>
                      </ul>
                      <ul class="nav dker">
                        <li <?php if(isset($historicalPay)) echo $historicalPay;?>>
                          <a href="historical_payment.php"><i class="i i-dot"></i>
                            <span>Historial de Pagos</span>
                          </a>
                        </li>
                      </ul>
                      <ul class="nav dker">
                        <li <?php if(isset($historychangepay)) echo $historychangepay;?>>
                          <a href="view_total_amount_users.php"><i class="i i-dot"></i>
                            <span>Historial de Cambio</span>
                          </a>
                        </li>
                      </ul>
                      <ul class="nav dker">
                        <li <?php if(isset($editpay)) echo $editpay;?>>
                          <a href="pay_customers_transactions.php"><i class="i i-dot"></i>
                            <span>Pago a Clientes</span>
                          </a>
                        </li>
                      </ul>
                    </li>
                    <?php endif;?>
                    <?php if($_SESSION['USER_ROLE'] == 1 || $_SESSION['USER_ROLE'] == 3 ) : ?>
                    <li <?php if(isset($custclass)) echo $custclass;?>>
                      <a href="#" class="auto">
                        <span class="pull-right text-muted">
                          <i class="i i-circle-sm-o text"></i>
                          <i class="i i-circle-sm text-active"></i>
                        </span>
                        <i class="i i-dot"></i>
                        <span>Alquileres</span>
                      </a>
                      <ul class="nav dker">
                        <li <?php if(isset($registerCntclass)) echo $registerCntclass;?>>
                          <a href="register_customer.php"><i class="i i-dot"></i>
                            <span>Registrar Cliente</span>
                          </a>
                        </li>
                        <li <?php if(isset($editCntclass)) echo $editCntclass;?>>
                          <a href="customers.php"><i class="i i-dot"></i>
                            <span>Ver Clientes</span>
                          </a>
                        </li>
                      </ul>
                    </li>
                    <li <?php if(isset($transaction)) echo $transaction;?>>
                      <a href="#" class="auto">
                        <span class="pull-right text-muted">
                          <i class="i i-circle-sm-o text"></i>
                          <i class="i i-circle-sm text-active"></i>
                        </span>
                        <i class="i i-dot"></i>
                        <span>Costos</span>
                      </a>
                      <ul class="nav dker">
                        <li <?php if(isset($registertransaction)) echo $registertransaction;?>>
                          <a href="transaction.php"><i class="i i-dot"></i>
                            <span>Registrar Transacción</span>
                          </a>
                        </li>
                        <li <?php if(isset($edittransaction)) echo $edittransaction;?>>
                          <a href="view_transaction.php"><i class="i i-dot"></i>
                            <span>Ver Transacciones</span>
                          </a>
                        </li>
                      </ul>
                    </li>
                    <?php endif;?>
                    <li <?php if(isset($transaction)) echo $transaction;?>>
                      <a href="#" class="auto">
                        <span class="pull-right text-muted">
                          <i class="i i-circle-sm-o text"></i>
                          <i class="i i-circle-sm text-active"></i>
                        </span>
                        <i class="i i-dot"></i>
                        <span>Reportes</span>
                      </a>
                      <ul class="nav dker">
                        <li <?php if(isset($registertransaction)) echo $registertransaction;?>>
                          <a href="transaction.php"><i class="i i-dot"></i>
                            <span>Registrar Transacción</span>
                          </a>
                        </li>
                        <li <?php if(isset($edittransaction)) echo $edittransaction;?>>
                          <a href="view_transaction.php"><i class="i i-dot"></i>
                            <span>Ver Transacciones</span>
                          </a>
                        </li>
                      </ul>
                    </li>

                    <li <?php if(isset($transaction)) echo $transaction;?>>
                      <a href="#" class="auto">
                        <span class="pull-right text-muted">
                          <i class="i i-circle-sm-o text"></i>
                          <i class="i i-circle-sm text-active"></i>
                        </span>
                        <i class="i i-dot"></i>
                        <span>Auditoria</span>
                      </a>
                      <ul class="nav dker">
                        <li <?php if(isset($registertransaction)) echo $registertransaction;?>>
                          <a href="transaction.php"><i class="i i-dot"></i>
                            <span>Registrar Transacción</span>
                          </a>
                        </li>
                        <li <?php if(isset($edittransaction)) echo $edittransaction;?>>
                          <a href="view_transaction.php"><i class="i i-dot"></i>
                            <span>Ver Transacciones</span>
                          </a>
                        </li>
                      </ul>
                    </li>


              </ul>
            </nav>
          </div>
        </section>
        <footer class="footer hidden-xs no-padder text-center-nav-xs">
          <a href="modal.lockme.html" data-toggle="ajaxModal" class="btn btn-icon icon-muted btn-inactive pull-right m-l-xs m-r-xs hidden-nav-xs">
            <i class="i i-logout"></i>
          </a>
          <a href="#nav" data-toggle="class:nav-xs" class="btn btn-icon icon-muted btn-inactive m-l-xs m-r-xs">
            <i class="i i-circleleft text"></i>
            <i class="i i-circleright text-active"></i>
          </a>
        </footer>
      </section>
    </aside>
