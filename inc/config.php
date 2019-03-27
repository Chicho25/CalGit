<?php if(isset($_SESSION['session_gc']['usua_id'])){ ?>
<?php $permisos = permisos($conexion2, $_SESSION['session_gc']['usua_id']) ?>
<?php while($lista_permiso = mysqli_fetch_array($permisos)){

            $roll = $lista_permiso['id_roll_acceso'];


            }

            $session_gc = array('usua_id'=>$_SESSION['session_gc']['usua_id'],
                                'usua_nombre'=>$_SESSION['session_gc']['usua_nombre'],
                                'usua_apellido'=>$_SESSION['session_gc']['usua_apellido'],
                                'usua_imagen_usuario' =>$_SESSION['session_gc']['usua_imagen_usuario'],
                                'usua_usuario' =>$_SESSION['session_gc']['usua_usuario'],
                                'roll'=>$roll);

            $_SESSION['session_gc']=$session_gc;

    }?>

<?php
/**
 * config.php
 *
 * Author: pixelcave
 *
 * Global configuration file
 *
 */

// Include Template class
require 'classes/Template.php';

// Create a new Template Object
$one                               = new Template('Grupo Calpe', '1.0', 'assets'); // Name, version and assets folder's name

// Global Meta Data
$one->author                       = 'Calpe';
$one->robots                       = 'noindex, nofollow';
$one->title                        = 'Grupo Calpe';
$one->description                  = 'Grupo Calpe';

// Global Included Files (eg useful for adding different sidebars or headers per page)
$one->inc_side_overlay             = ''; /* lo que estaba -> base_side_overlay.php */
$one->inc_sidebar                  = 'base_sidebar.php';
$one->inc_header                   = $header_bar;  /* lo que estaba por defauld --> 'base_header.php'; */

// Global Color Theme
$one->theme                        = '';       // '' for default theme or 'amethyst', 'city', 'flat', 'modern', 'smooth'

// Global Cookies
$one->cookies                      = false;    // True: Remembers active color theme between pages (when set through color theme list), False: Disables cookies

// Global Body Background Image
$one->body_bg                      = '';       // eg 'assets/img/photos/photo10@2x.jpg' Useful for login/lockscreen pages

// Global Header Options
$one->l_header_fixed               = true;     // True: Fixed Header, False: Static Header

// Global Sidebar Options
$one->l_sidebar_position           = 'left';   // 'left': Left Sidebar and right Side Overlay, 'right;: Flipped position
$one->l_sidebar_mini               = false;    // True: Mini Sidebar Mode (> 991px), False: Disable mini mode
$one->l_sidebar_visible_desktop    = $menu;     // por defauld estaba true --> True: Visible Sidebar (> 991px), False: Hidden Sidebar (> 991px)
$one->l_sidebar_visible_mobile     = false;    // True: Visible Sidebar (< 992px), False: Hidden Sidebar (< 992px)

// Global Side Overlay Options
$one->l_side_overlay_hoverable     = false;    // True: Side Overlay hover mode (> 991px), False: Disable hover mode
$one->l_side_overlay_visible       = false;    // True: Visible Side Overlay, False: Hidden Side Overlay

// Global Sidebar and Side Overlay Custom Scrolling
$one->l_side_scroll                = true;     // True: Enable custom scrolling (> 991px), False: Disable it (native scrolling)

// Global Active Page (it will get compared with the url of each menu link to make the link active and set up main menu accordingly)
$one->main_nav_active              = basename($_SERVER['PHP_SELF']);

if(isset($_SESSION['session_gc']['usua_id'])){
if($_SESSION['session_gc']['roll'] == 1 || $_SESSION['session_gc']['roll'] == 3){
// Global Main Menu
$one->main_nav                     = array(

  array(
      'name'  => '<span class="sidebar-mini-hide">Dashboard General</span>',
      'icon'  => 'si si-speedometer',
      'url'   => 'gc_principal.php'
    ),
    /*array(
        'name'  => '<span class="sidebar-mini-hide">Dashboard Partidas</span>',
        'icon'  => 'si si-speedometer',
        'url'   => 'gc_principal_2.php'
    ),*/
    array(
        'name'  => '<span class="sidebar-mini-hide">Menu Administrador</span>',
        'type'  => 'heading'
    ),
    array(
        'name'  => '<span class="sidebar-mini-hide">Mantenimiento</span>',
        'icon'  => 'si si-equalizer',
        'sub'   => array(
             array(
                'name'  => 'Usuarios',
                'icon'  => 'si si-user',
                'sub'   => array(
                    array(
                      'name'  => 'Crear usuario',
                      'url'   => 'gc_crear_usuario.php'
                    ),
                    array(
                        'name'  => 'Ver usuarios',
                        'url'   => 'gc_ver_usuarios.php'
                    ),
                )
            ),
            array(
                'name'  => 'Empresa',
                'icon'  => 'si si-grid',
                'sub'   => array(
                    array(
                        'name'  => 'Crear Empresa',
                        'url'   => 'gc_registrar_empresa.php'
                    ),
                    array(
                        'name'  => 'Ver Empresas',
                        'url'   => 'gc_ver_empresas.php'
                    )
                )
            ),
             array(
                'name'  => 'Proyecto',
                'icon'  => 'si si-layers',
                'sub'   => array(
                    array(
                        'name'  => 'Crear Proyecto',
                        'url'   => 'gc_crear_proyecto.php'
                    ),
                    array(
                        'name'  => 'Ver Proyectos',
                        'url'   => 'gc_ver_proyectos.php'
                    )
                )
            ),
            array(
                'name'  => 'Bancos',
                'icon'  => 'fa fa-bank',
                'sub'   => array(
                    array(
                        'name'  => 'Registrar Banco',
                        'url'   => 'gc_crer_banco.php'
                    ),
                    array(
                        'name'  => 'Ver Bancos',
                        'url'   => 'gc_ver_bancos.php'
                    ),
                    array(
                        'name'  => '-------------------------------'
                    ),
                    array(
                        'name'  => 'Registrar Cuenta Bancaria',
                        'url'   => 'gc_crear_cuenta_bancaria.php'
                    ),
                    array(
                        'name'  => 'Ver Cuentas Bancarias',
                        'url'   => 'gc_ver_cuentas_bancarias.php'
                    ),
                    array(
                        'name'  => '--------------------------------'
                    ),
                    array(
                        'name'  => 'Registrar Chequera',
                        'url'   => 'gc_registrar_chequera.php'
                    ),
                    array(
                        'name'  => 'Ver Chequeras',
                        'url'   => 'gc_ver_chequeras.php'
                    )

                )
            ),
            array(
                'name'  => 'Inmueble',
                'icon'  => 'fa fa-building-o',
                'sub'   => array(
                    array(
                        'name'  => 'Registrar Grupos Inmueble',
                        'url'   => 'gc_registrar_grupo_inmuebles.php'
                    ),
                    array(
                        'name'  => 'Ver Grupo inmuebles',
                        'url'   => 'gc_ver_grupo_inmueble.php'
                    ),
                    array(
                        'name'  => 'Registrar Tipo Inmueble',
                        'url'   => 'gc_registrar_tipo_inmueble.php'
                    ),
                    array(
                        'name'  => 'Ver Tipo Inmueble',
                        'url'   => 'gc_ver_tipo_inmuebles.php'
                    )
                )
            )
      )

    ),
    array(
        'name'  => '<span class="sidebar-mini-hide">Bancos</span>',
        'icon'  => 'fa fa-bank',
        'sub'   => array(
            array(
                'name'  => 'Movimientos',
                'icon'  => 'si si-cursor-move',
                'sub'   => array(
                    array(
                        'name'  => 'Registrar Movimiento',
                        'url'   => 'gc_registrar_movimiento_bancario.php'
                    ),
                    array(
                        'name'  => 'Ver movimientos',
                        'url'   => 'gc_ver_movimiento_bancario.php'
                    ),
                    array(
                        'name'  => 'Ver movimientos Filtrados',
                        'url'   => 'gc_moviento_bancario_filtro.php'
                    )

                )
            ),
            array(
                'name'  => 'Saldos Bancos',
                'icon'  => 'fa fa-money',
                'sub'   => array(
                    array(
                        'name'  => 'Saldos cuentas Bancarias',
                        'url'   => 'gc_saldo_cuentas.php'
                    ),

                )
            ),
            array(
                'name'  => 'Estado de cuenta',
                'icon'  => 'fa fa-money',
                'sub'   => array(
                    array(
                        'name'  => 'Estado de cuenta Bancaria',
                        'url'   => 'gc_buscar_estado_banco.php'
                    ),

                )
            ),

        )

    ),
    array(
        'name'  => '<span class="sidebar-mini-hide">Ventas</span>',
        'icon'  => 'si si-graph',
        'sub'   => array(
            array(
                'name'  => 'Vendedores',
                'icon'  => 'fa fa-suitcase',
                'sub'   => array(
                    array(
                        'name'  => 'Registrar Vendedor',
                        'url'   => 'gc_registrar_vendedor.php'
                    ),
                    array(
                        'name'  => 'Ver Vendedor',
                        'url'   => 'gc_ver_vendedores.php'
                    ),
                    array(
                        'name'  => 'Asignar Comision',
                        'url'   => 'gc_asignar_comision.php'
                    ),
                    array(
                        'name'  => 'Ver Comisiones',
                        'url'   => 'gc_ver_comisiones.php'
                    )
                )
            ),
            array(
                'name'  => 'Clientes',
                'icon'  => 'fa fa-group',
                'sub'   => array(
                    array(
                        'name'  => 'Registrar Cliente',
                        'url'   => 'gc_registrar_cliente.php'
                    ),
                    array(
                        'name'  => 'Ver Clientes',
                        'url'   => 'gc_ver_cliente.php'
                    )
                )
            ),
            array(
                'name'  => 'Inmuebles',
                'icon'  => 'fa fa-building-o',
                'sub'   => array(
                    array(
                        'name'  => 'Registrar Inmueble',
                        'url'   => 'gc_registrar_inmueble.php'
                    ),
                    array(
                        'name'  => 'Ver Inmuebles',
                        'url'   => 'gc_busqueda_inmueble.php'
                    ),
                    array(
                        'name'  => '--------------------------------'
                    ),
                    array(
                        'name'  => 'Reservar Inmueble',
                        'url'   => 'gc_reservar_inmueble.php'
                    ),
                    array(
                        'name'  => 'Ver Reservaciones',
                        'url'   => 'gc_ver_reservas_inmuebles.php'
                    ),
                    array(
                        'name'  => '--------------------------------'
                    ),
                    array(
                        'name'  => 'Registrar Contrato de Venta',
                        'url'   => 'gc_registrar_contrato_ventas.php'
                    ),
                    array(
                        'name'  => 'Ver Contrato de Venta Alquileres',
                        'url'   => 'gc_ver_contrato_venta.php'
                    ),
                    array(
                        'name'  => 'Registrar Cuotas',
                        'url'   => 'gc_registrar_documento.php'
                    ),
                    array(
                        'name'  => 'Ver Cuotas',
                        'url'   => 'gc_ver_documentos.php'
                    ),
                    array(
                        'name'  => 'Ver Cuotas Filtro',
                        'url'   => 'gc_ver_cuotas_filtro.php'
                    ),
                    array(
                        'name'  => '--------------------------------'
                    ),
                    array(
                        'name'  => 'Edo. cuenta cliente',
                        'url'   => 'gc_estado_cuenta_cliente_1.php'
                    )
                )
            )
        )
    ),
    array(
        'name'  => '<span class="sidebar-mini-hide">Alquileres</span>',
        'icon'  => 'fa fa-ship',
        'sub'   => array(
            array(
                'name'  => 'Marina',
                'icon'  => 'fa fa-anchor',
                'sub'   => array(
                    array(
                        'name'  => 'Mapeado',
                        'url'   => 'gc_mapeado_marina.php'
                    ),
                    array(
                        'name'  => 'Proyecciones',
                        'url'   => 'gc_proyecciones.php'
                    ),
                    array(
                        'name'  => 'Inmuebles/Slips',
                        'url'   => 'gc_ver_slips.php'
                    )
                )
            ),
            array(
                'name'  => 'Contrato de alquiler',
                'icon'  => 'fa fa-files-o',
                'sub'   => array(
                    array(
                        'name'  => 'Registrar Contrato Alquiler',
                        'url'   => 'gc_registrar_alquileres.php'
                    ),
                    array(
                        'name'  => 'Ver Contrato Alquiler',
                        'url'   => 'gc_ver_contratos_alquileres.php'
                    ),
                    array(
                        'name'  => 'Registrar cuota de alquileres',
                        'url'   => 'gc_registrar_cuota_alquiler.php'
                    ),
                    array(
                        'name'  => 'Ver cuotas alquileres',
                        'url'   => 'gc_ver_cuotas_alquileres.php'
                    ),
                    array(
                        'name'  => 'Edo. Cuenta Cliente',
                        'url'   => 'gc_estado_cuenta_cliente_1_copy.php'
                    ),
                    array(
                        'name'  => 'Edo. Servicios',
                        'url'   => 'gc_estado_servicios.php'
                    ),
                    array(
                        'name'  => 'Rep. Termino',
                        'url'   => 'gc_reporte_termino.php'
                    )
                )
            ),

            )
        ),
    array(
        'name'  => '<span class="sidebar-mini-hide">Costos</span>',
        'icon'  => 'fa fa-bar-chart',
        'sub'   => array(
                array(
                    'name'  => 'Proveedores',
                    'icon'  => 'fa fa-truck',
                    'sub'   => array(
                        array(
                            'name'  => 'Registrar Proveedor',
                            'url'   => 'gc_registrar_proveedor.php'
                        ),
                        array(
                            'name'  => 'Ver Proveedor',
                            'url'   => 'gc_ver_proveedores.php'
                        )
                    )
                ),
                array(
                    'name'  => 'Partidas',
                    'icon'  => 'fa fa-list-ol',
                    'sub'   => array(
                        array(
                            'name'  => 'Informe Anual',
                            'url'   => 'gc_busqueda_informe_anual.php'
                        ),
                        array(
                            'name'  => 'Consulta de Proyectos',
                            'url'   => 'gc_consulta_partidas_prin.php'
                        ),
                        array(
                            'name'  => 'Partidas Documentos',
                            'url'   => 'gc_partidas.php'
                        ),
                        array(
                            'name'  => 'Partidas',
                            'url'   => 'gc_partidas_copia.php'
                        ),
                        array(
                            'name'  => 'Partidas Print',
                            'url'   => 'gc_partidas_copia_2.php'
                        )
                    )
                ),
                array(
                    'name'  => 'Facturas',
                    'icon'  => 'si si-docs',
                    'sub'   => array(
                        array(
                            'name'  => 'Crear Factura',
                            'url'   => 'gc_buscar_proyecto.php'
                        ),
                        array(
                            'name'  => 'Ver Facturas',
                            'url'   => 'gc_ver_documentos_partidas.php'
                        ),
                        array(
                            'name'  => 'Ver Facturas filtro',
                            'url'   => 'gc_ver_facturas_emitidas.php'
                        )
                    )
                ),
                array(
                    'name'  => 'Emision de Pagos',
                    'icon'  => 'fa fa-money',
                    'sub'   => array(
                        array(
                            'name'  => 'Emitir Pago',
                            'url'   => 'gc_buscar_documento_partida.php'
                        ),
                        array(
                            'name'  => 'Ver Pagos Emitidos',
                            'url'   => 'gc_ver_documentos_pagos.php'
                        ),
                        array(
                            'name'  => 'Ver Pagos Emitidos Filtros',
                            'url'   => 'gc_ver_pagos_emitidos_filtros.php'
                        ),
                        array(
                          'name'  => 'Emitir cheque directo',
                          'url'   => 'gc_emitir_cheque_directo.php'
                          ),
                          array(
                              'name'  => 'Ver cheques Emitidos',
                              'url'   => 'gc_ver_cheques_emitidos.php'
                          )
                    )
                ),
                array(
                    'name'  => '--------------------------------'
                ),
                array(
                    'name'  => 'Edo. cuenta Proveedor',
                    'url'   => 'gc_busqueda_estado_cuenta_proveedor.php'
                )

            )

    ),
    array(
        'name'  => '<span class="sidebar-mini-hide">Reportes</span>',
        'icon'  => 'si si-book-open',
        'sub'   => array(
                array(
                    'name'  => 'Reportes',
                    'icon'  => 'fa fa-files-o',
                    'sub'   => array(
                        /*array(
                            'name'  => 'Estado de cuenta de los clientes',
                            'url'   => 'gc_reporte_estado_cuenta_usuario_1.php'
                        ),*/
                        array(
                            'name'  => 'Ventas de inmuebles',
                            'url'   => 'gc_reporte_2_ventas_inmuebles.php'
                        ),
                        array(
                            'name'  => 'Reporte de Egresos',
                            'url'   => 'gc_report_partidas_por_mes.php'
                        ),
                        array(
                            'name'  => 'Reporte de Egresos Excel',
                            'url'   => 'gc_report_partidas_por_mes_excel.php'
                        ),
                        array(
                            'name'  => 'Rep. Ingresos',
                            'url'   => 'gc_reporte_ingresos.php'
                        ),
                        array(
                            'name'  => 'Rep. Ingresos Excel',
                            'url'   => 'gc_reporte_ingresos_excel.php'
                        ),
                        array(
                            'name'  => 'Rep. Combustible',
                            'url'   => 'gc_reporte_combustible.php'
                        ),
                        array(
                            'name'  => 'Rep. Combustible Excel',
                            'url'   => 'gc_report_combustible_excel_busqueda.php'
                        ),
                        array(
                            'name'  => 'Historial de Alquileres',
                            'url'   => 'gc_reporte_alquileres.php'
                        )
                    )
                ),
          )
    ),
    array(
        'name'  => '<span class="sidebar-mini-hide">Auditoria</span>',
        'icon'  => 'glyphicon glyphicon-folder-open',
        'sub'   => array(
                array(
                    'name'  => 'Auditoria',
                    'icon'  => 'glyphicon glyphicon-eye-open',
                    'sub'   => array(
                        array(
                            'name'  => 'Auditoria Log General',
                            'url'   => 'gc_auditoria_general.php'
                        ),
                        array(
                            'name'  => 'Auditoria Log Usuarios',
                            'url'   => 'gc_auditoria_modulos.php'
                        ),
                        array(
                            'name'  => 'Auditoria Log Empresa',
                            'url'   => 'gc_auditoria_empresa.php'
                        ),
                        array(
                            'name'  => 'Auditoria Log Proyecto',
                            'url'   => 'gc_auditoria_proyecto.php'
                        ),
                        array(
                            'name'  => 'Auditoria Log Bancos',
                            'url'   => 'gc_auditoria_bancos.php'
                        ),
                        array(
                            'name'  => 'Auditoria Log Cuentas Bancarias',
                            'url'   => 'gc_auditoria_cuenta_bancaria.php'
                        ),
                        array(
                            'name'  => 'Auditoria Log Cheques Directos',
                            'url'   => 'gc_auditoria_emitir_cheque_directo.php'
                        ),
                        array(
                            'name'  => 'Auditoria Log Partidas',
                            'url'   => 'gc_auditoria_partidas.php'
                        ),
                        array(
                            'name'  => 'Auditoria Log Documentos',
                            'url'   => 'gc_auditoria_facturas.php'
                        ),
                        array(
                            'name'  => 'Auditoria Log Pagos de Documentos',
                            'url'   => 'gc_auditoria_emision_pagos.php'
                        ),
                        array(
                            'name'  => 'Auditoria Log Movimientos Bancarios',
                            'url'   => 'gc_auditoria_movimientos_bancarios.php'
                        ),
                        array(
                            'name'  => 'Auditoria Log Vendedores',
                            'url'   => 'gc_auditoria_vendedores.php'
                        ),
                        array(
                            'name'  => 'Auditoria Log Clientes',
                            'url'   => 'gc_auditoria_clientes.php'
                        ),
                        array(
                            'name'  => 'Auditoria Log Inmuebles',
                            'url'   => 'gc_auditoria_inmueble.php'
                        ),
                        array(
                            'name'  => 'Auditoria Log Proveedores',
                            'url'   => 'gc_auditoria_proveedores.php'
                        )
                    )
                )/*,
                array(
                    'name'  => 'Estadisticas',
                    'icon'  => 'fa fa-gears',
                    'sub'   => array(
                        array(
                            'name'  => 'Auditoria a tiempo real',
                            'url'   => ''
                        )
                    )
                )*/
            )

    ));  }elseif($_SESSION['session_gc']['roll'] == 2){
            if(permisos_accesos($conexion2, $_SESSION['session_gc']['usua_id'] , 2, $_SESSION['session_gc']['roll']) == 2){

$one->main_nav                     = array(

    array(
        'name'  => '<span class="sidebar-mini-hide">Menu</span>',
        'type'  => 'heading'
    ),

    array(
        'name'  => 'Inmuebles',
        'icon'  => 'fa fa-building-o',
        'sub'   => array(
            array(
                'name'  => 'Registrar Grupos Inmueble',
                'url'   => 'gc_registrar_grupo_inmuebles.php'
            ),
            array(
                'name'  => 'Ver Grupo inmuebles',
                'url'   => 'gc_ver_grupo_inmueble.php'
            ),
            array(
                'name'  => '--------------------------------'
            ),
            array(
                'name'  => 'Registrar Inmueble',
                'url'   => 'gc_registrar_inmueble.php'
            ),
            array(
                'name'  => 'Ver Inmuebles',
                'url'   => 'gc_busqueda_inmueble.php'
            ),
            array(
                'name'  => '--------------------------------'
            ),
            array(
                'name'  => 'Registrar Tipo Inmueble',
                'url'   => 'gc_registrar_tipo_inmueble.php'
            ),
            array(
                'name'  => 'Ver Tipo Inmueble',
                'url'   => 'gc_ver_tipo_inmuebles.php'
            ),
            array(
                'name'  => '--------------------------------'
            ),
            array(
                'name'  => 'Reservar Inmueble',
                'url'   => 'gc_reservar_inmueble.php'
            ),
            array(
                'name'  => 'Ver Reservaciones',
                'url'   => 'gc_ver_reservas_inmuebles.php'
            ),
            array(
                'name'  => '--------------------------------'
            ),
            array(
                'name'  => 'Registrar Contrato de Venta',
                'url'   => 'gc_registrar_contrato_ventas.php'
            ),
            array(
                'name'  => 'Asignar Comision',
                'url'   => 'gc_asignar_comision.php'
            ),
            array(
                'name'  => 'Ver Comisiones',
                'url'   => 'gc_ver_comisiones.php'
            ),
            array(
                'name'  => 'Ver Contrato de Venta',
                'url'   => 'gc_ver_contrato_venta.php'
            ),
            array(
                'name'  => 'Registrar Facturas',
                'url'   => 'gc_registrar_documento.php'
            ),
            array(
                'name'  => 'Ver Facturas',
                'url'   => 'gc_ver_documentos.php'
            )
        )
    )

); }elseif(permisos_accesos($conexion2, $_SESSION['session_gc']['usua_id'] , 3, $_SESSION['session_gc']['roll']) == 3){

    $one->main_nav                     = array(

    array(
        'name'  => '<span class="sidebar-mini-hide">Menu</span>',
        'type'  => 'heading'),
        array(
            'name'  => '<span class="sidebar-mini-hide">Costos</span>',
            'icon'  => 'fa fa-bar-chart',
            'sub'   => array(
                    array(
                        'name'  => 'Proveedores',
                        'icon'  => 'fa fa-truck',
                        'sub'   => array(
                            array(
                                'name'  => 'Registrar Proveedor',
                                'url'   => 'gc_registrar_proveedor.php'
                            ),
                            array(
                                'name'  => 'Ver Proveedor',
                                'url'   => 'gc_ver_proveedores.php'
                            )
                        )
                    ),
                    array(
                        'name'  => 'Partidas',
                        'icon'  => 'fa fa-list-ol',
                        'sub'   => array(
                            array(
                                'name'  => 'Consulta de Partidas',
                                'url'   => 'gc_consulta_partidas_prin.php'
                            ),
                            array(
                                'name'  => 'Estructura Completa',
                                'url'   => 'gc_partidas.php'
                            ),
                            array(
                                'name'  => 'Arbol de Partidas',
                                'url'   => 'gc_partidas_copia.php'
                            ),
                            array(
                                'name'  => 'Partidas Print',
                                'url'   => 'gc_partidas_copia_2.php'
                            )
                        )
                    ),
                    array(
                        'name'  => 'Facturas',
                        'icon'  => 'si si-docs',
                        'sub'   => array(
                            /*array(
                                'name'  => 'Crear Factura',
                                'url'   => 'gc_buscar_proyecto.php'
                            ),*/
                            array(
                                'name'  => 'Ver Facturas',
                                'url'   => 'gc_ver_documentos_partidas.php'
                            )
                        )
                    ),
                    array(
                        'name'  => 'Emision de Pagos',
                        'icon'  => 'fa fa-money',
                        'sub'   => array(
                            array(
                                'name'  => 'Emitir Pago',
                                'url'   => 'gc_buscar_documento_partida.php'
                            ),
                            array(
                                'name'  => 'Ver Pagos Emitidos',
                                'url'   => 'gc_ver_documentos_pagos.php'
                            ),
                        )
                    )

                )

        )); }elseif(permisos_accesos($conexion2, $_SESSION['session_gc']['usua_id'] , 4, $_SESSION['session_gc']['roll']) == 4){

    $one->main_nav                     = array(

    array(
        'name'  => '<span class="sidebar-mini-hide">Menu</span>',
        'type'  => 'heading'
    ),

    array(
        'name'  => '<span class="sidebar-mini-hide">Bancos</span>',
        'icon'  => 'fa fa-bank',
        'sub'   => array(
            array(
                'name'  => 'Movimientos',
                'icon'  => 'si si-cursor-move',
                'sub'   => array(
                    array(
                        'name'  => 'Registrar Movimiento',
                        'url'   => 'gc_registrar_movimiento_bancario.php'
                    ),
                    array(
                        'name'  => 'Ver movimientos',
                        'url'   => 'gc_ver_movimiento_bancario.php'
                    )
                )
            ),
            array(
                'name'  => 'Saldos Bancos',
                'icon'  => 'fa fa-money',
                'sub'   => array(
                    array(
                        'name'  => 'Saldos cuentas Bancarias',
                        'url'   => 'gc_saldo_cuentas.php'
                    ),

                )
            ),
            array(
                'name'  => 'Estado de cuenta',
                'icon'  => 'fa fa-money',
                'sub'   => array(
                    array(
                        'name'  => 'Estado de cuenta Bancaria',
                        'url'   => 'gc_buscar_estado_banco.php'
                    ),

                )
            ),

        )

    ));

    }elseif(permisos_accesos($conexion2, $_SESSION['session_gc']['usua_id'] , 5, $_SESSION['session_gc']['roll']) == 5){

    $one->main_nav                     = array(

    array(
        'name'  => '<span class="sidebar-mini-hide">Menu</span>',
        'type'  => 'heading'
    ),

    array(
        'name'  => '<span class="sidebar-mini-hide">Reportes y Consultas</span>',
        'icon'  => 'si si-book-open',
        'sub'   => array(
                array(
                    'name'  => 'Reportes',
                    'icon'  => 'fa fa-files-o',
                    'sub'   => array(
                        array(
                            'name'  => 'Estado de cuenta de los clientes',
                            'url'   => 'gc_reporte_estado_cuenta_usuario_1.php'
                        ),
                        array(
                            'name'  => 'Ventas de inmuebles',
                            'url'   => 'gc_reporte_2_ventas_inmuebles.php'
                        ),
                        array(
                            'name'  => 'Ventas',
                            'url'   => 'gc_reporte_5_ventas.php'
                        ),
                        array(
                            'name'  => 'Contrato y comisione',
                            'url'   => 'gc_reporte_3_contrato_comisiones.php'
                        ),
                        array(
                            'name'  => 'Cobranza',
                            'url'   => 'gc_reporte_4_cobranza.php'
                        )
                    )
                ),
                array(
                    'name'  => 'Consulta Partida',
                    'icon'  => 'fa fa-files-o',
                    'sub'   => array(
                        array(
                            'name'  => 'Partidas',
                            'url'   => 'gc_consulta_partidas_prin.php'
                        )
                      )
                    ),
          )
    ),

  );

} }elseif($_SESSION['session_gc']['roll'] == 4){


      $one->main_nav                     = array(

      array(
          'name'  => '<span class="sidebar-mini-hide">Menu</span>',
          'type'  => 'heading'
      ),

      array(
          'name'  => '<span class="sidebar-mini-hide">Bancos</span>',
          'icon'  => 'fa fa-bank',
          'sub'   => array(
              array(
                  'name'  => 'Movimientos',
                  'icon'  => 'si si-cursor-move',
                  'sub'   => array(
                      array(
                          'name'  => 'Registrar Movimiento',
                          'url'   => 'gc_registrar_movimiento_bancario.php'
                      ),
                      array(
                          'name'  => 'Ver movimientos',
                          'url'   => 'gc_ver_movimiento_bancario.php'
                      ),
                      array(
                          'name'  => 'Emitir cheque directo',
                          'url'   => 'gc_emitir_cheque_directo.php'
                      ),
                      array(
                          'name'  => 'Ver cheques Emitidos',
                          'url'   => 'gc_ver_cheques_emitidos.php'
                      )
                  )
              ),
              array(
                  'name'  => 'Saldos Bancos',
                  'icon'  => 'fa fa-money',
                  'sub'   => array(
                      array(
                          'name'  => 'Saldos cuentas Bancarias',
                          'url'   => 'gc_saldo_cuentas.php'
                      ),

                  )
              ),
              array(
                  'name'  => 'Estado de cuenta',
                  'icon'  => 'fa fa-money',
                  'sub'   => array(
                      array(
                          'name'  => 'Estado de cuenta Bancaria',
                          'url'   => 'gc_buscar_estado_banco.php'
                      ),

                  )
              ),

          )

      ),
      array(
          'name'  => '<span class="sidebar-mini-hide">Costos</span>',
          'icon'  => 'fa fa-bar-chart',
          'sub'   => array(
                  array(
                      'name'  => 'Proveedores',
                      'icon'  => 'fa fa-truck',
                      'sub'   => array(
                          array(
                              'name'  => 'Registrar Proveedor',
                              'url'   => 'gc_registrar_proveedor.php'
                          ),
                          array(
                              'name'  => 'Ver Proveedor',
                              'url'   => 'gc_ver_proveedores.php'
                          )
                      )
                  ),
                  array(
                      'name'  => 'Partidas',
                      'icon'  => 'fa fa-list-ol',
                      'sub'   => array(
                          array(
                              'name'  => 'Consulta de Partidas',
                              'url'   => 'gc_consulta_partidas_prin.php'
                          ),
                          array(
                              'name'  => 'Partidas Documentos',
                              'url'   => 'gc_partidas.php'
                          ),
                          array(
                              'name'  => 'Arbol de Partidas',
                              'url'   => 'gc_partidas_copia.php'
                          ),
                          array(
                              'name'  => 'Partidas Print',
                              'url'   => 'gc_partidas_copia_2.php'
                          )
                      )
                  ),
                  array(
                      'name'  => 'Facturas',
                      'icon'  => 'si si-docs',
                      'sub'   => array(
                          array(
                              'name'  => 'Crear Factura',
                              'url'   => 'gc_buscar_proyecto.php'
                          ),
                          array(
                              'name'  => 'Ver Facturas',
                              'url'   => 'gc_ver_documentos_partidas.php'
                          )
                      )
                  ),
                  array(
                      'name'  => 'Emision de Pagos',
                      'icon'  => 'fa fa-money',
                      'sub'   => array(
                          array(
                              'name'  => 'Emitir Pago',
                              'url'   => 'gc_buscar_documento_partida.php'
                          ),
                          array(
                              'name'  => 'Ver Pagos Emitidos',
                              'url'   => 'gc_ver_documentos_pagos.php'
                          ),
                           array(
                                'name'  => 'Emitir cheque directo',
                                'url'   => 'gc_emitir_cheque_directo.php'
                            ),
                            array(
                                'name'  => 'Ver cheques Emitidos',
                                'url'   => 'gc_ver_cheques_emitidos.php'
                            )
                      )
                  ),
                  array(
                      'name'  => '--------------------------------'
                  ),
                  array(
                      'name'  => 'Edo. cuenta Proveedor',
                      'url'   => ''
                  )

              )

      ),
      array(
          'name'  => '<span class="sidebar-mini-hide">Ventas</span>',
          'icon'  => 'si si-graph',
          'sub'   => array(
              array(
                  'name'  => 'Vendedores',
                  'icon'  => 'fa fa-suitcase',
                  'sub'   => array(
                      array(
                          'name'  => 'Registrar Vendedor',
                          'url'   => 'gc_registrar_vendedor.php'
                      ),
                      array(
                          'name'  => 'Ver Vendedor',
                          'url'   => 'gc_ver_vendedores.php'
                      )
                  )
              ),
              array(
                  'name'  => 'Clientes',
                  'icon'  => 'fa fa-group',
                  'sub'   => array(
                      array(
                          'name'  => 'Registrar Cliente',
                          'url'   => 'gc_registrar_cliente.php'
                      ),
                      array(
                          'name'  => 'Ver Clientes',
                          'url'   => 'gc_ver_cliente.php'
                      )
                  )
              ),
              array(
                  'name'  => 'Inmuebles',
                  'icon'  => 'fa fa-building-o',
                  'sub'   => array(
                      array(
                          'name'  => 'Registrar Grupos Inmueble',
                          'url'   => 'gc_registrar_grupo_inmuebles.php'
                      ),
                      array(
                          'name'  => 'Ver Grupo inmuebles',
                          'url'   => 'gc_ver_grupo_inmueble.php'
                      ),
                      array(
                          'name'  => '--------------------------------'
                      ),
                      array(
                          'name'  => 'Registrar Inmueble',
                          'url'   => 'gc_registrar_inmueble.php'
                      ),
                      array(
                          'name'  => 'Ver Inmuebles',
                          'url'   => 'gc_busqueda_inmueble.php'
                      ),
                      array(
                          'name'  => '--------------------------------'
                      ),
                      array(
                          'name'  => 'Registrar Tipo Inmueble',
                          'url'   => 'gc_registrar_tipo_inmueble.php'
                      ),
                      array(
                          'name'  => 'Ver Tipo Inmueble',
                          'url'   => 'gc_ver_tipo_inmuebles.php'
                      ),
                      array(
                          'name'  => '--------------------------------'
                      ),
                      array(
                          'name'  => 'Reservar Inmueble',
                          'url'   => 'gc_reservar_inmueble.php'
                      ),
                      array(
                          'name'  => 'Ver Reservaciones',
                          'url'   => 'gc_ver_reservas_inmuebles.php'
                      ),
                      array(
                          'name'  => '--------------------------------'
                      ),
                      array(
                          'name'  => 'Registrar Contrato de Venta',
                          'url'   => 'gc_registrar_contrato_ventas.php'
                      ),
                      array(
                          'name'  => 'Asignar Comision',
                          'url'   => 'gc_asignar_comision.php'
                      ),
                      array(
                          'name'  => 'Ver Comisiones',
                          'url'   => 'gc_ver_comisiones.php'
                      ),
                      array(
                          'name'  => 'Ver Contrato de Venta',
                          'url'   => 'gc_ver_contrato_venta.php'
                      ),
                      array(
                          'name'  => 'Registrar Facturas',
                          'url'   => 'gc_registrar_documento.php'
                      ),
                      array(
                          'name'  => 'Ver Facturas',
                          'url'   => 'gc_ver_documentos.php'
                      ),
                      array(
                          'name'  => '--------------------------------'
                      ),
                      array(
                          'name'  => 'Edo. cuenta cliente',
                          'url'   => 'gc_estado_cuenta_cliente_1.php'
                      )
                  )
              )
          )
      ),

      array(
          'name'  => '<span class="sidebar-mini-hide">Reportes y Consultas</span>',
          'icon'  => 'si si-book-open',
          'sub'   => array(
                  array(
                      'name'  => 'Reportes',
                      'icon'  => 'fa fa-files-o',
                      'sub'   => array(
                          array(
                              'name'  => 'Estado de cuenta de los clientes',
                              'url'   => 'gc_reporte_estado_cuenta_usuario_1.php'
                          ),
                          array(
                              'name'  => 'Ventas de inmuebles',
                              'url'   => 'gc_reporte_2_ventas_inmuebles.php'
                          ),
                          array(
                              'name'  => 'Ventas',
                              'url'   => 'gc_reporte_5_ventas.php'
                          ),
                          array(
                              'name'  => 'Contrato y comisione',
                              'url'   => 'gc_reporte_3_contrato_comisiones.php'
                          ),
                          array(
                              'name'  => 'Cobranza',
                              'url'   => 'gc_reporte_4_cobranza.php'
                          )
                      )
                  ),
            )
      ),

    );


  }elseif($_SESSION['session_gc']['roll'] == 5){


        $one->main_nav                     = array(

        array(
            'name'  => '<span class="sidebar-mini-hide">Menu</span>',
            'type'  => 'heading'
        ),
        array(
            'name'  => '<span class="sidebar-mini-hide">Costos</span>',
            'icon'  => 'fa fa-bar-chart',
            'sub'   => array(
                    array(
                        'name'  => 'Proveedores',
                        'icon'  => 'fa fa-truck',
                        'sub'   => array(
                            array(
                                'name'  => 'Registrar Proveedor',
                                'url'   => 'gc_registrar_proveedor.php'
                            ),
                            array(
                                'name'  => 'Ver Proveedor',
                                'url'   => 'gc_ver_proveedores.php'
                            )
                        )
                    ),
                    array(
                        'name'  => 'Partidas',
                        'icon'  => 'fa fa-list-ol',
                        'sub'   => array(
                            array(
                                'name'  => 'Consulta de Partidas',
                                'url'   => 'gc_consulta_partidas_prin.php'
                            ),
                            array(
                                'name'  => 'Partidas Documentos',
                                'url'   => 'gc_partidas.php'
                            ),
                            array(
                                'name'  => 'Arbol de Partidas',
                                'url'   => 'gc_partidas_copia.php'
                            ),
                            array(
                                'name'  => 'Partidas Print',
                                'url'   => 'gc_partidas_copia_2.php'
                            )
                        )
                    ),
                    array(
                        'name'  => 'Facturas',
                        'icon'  => 'si si-docs',
                        'sub'   => array(
                            array(
                                'name'  => 'Crear Factura',
                                'url'   => 'gc_buscar_proyecto.php'
                            ),
                            array(
                                'name'  => 'Ver Facturas',
                                'url'   => 'gc_ver_documentos_partidas.php'
                            )
                        )
                    ),
                    array(
                        'name'  => 'Emision de Pagos',
                        'icon'  => 'fa fa-money',
                        'sub'   => array(
                            array(
                                'name'  => 'Emitir Pago',
                                'url'   => 'gc_buscar_documento_partida.php'
                            ),
                            array(
                                'name'  => 'Ver Pagos Emitidos',
                                'url'   => 'gc_ver_documentos_pagos.php'
                            ),
                        )
                    ),
                    array(
                        'name'  => '--------------------------------'
                    ),
                    array(
                        'name'  => 'Edo. cuenta Proveedor',
                        'url'   => ''
                    )

                )

        ),
        array(
            'name'  => '<span class="sidebar-mini-hide">Ventas</span>',
            'icon'  => 'si si-graph',
            'sub'   => array(
                array(
                    'name'  => 'Vendedores',
                    'icon'  => 'fa fa-suitcase',
                    'sub'   => array(
                        array(
                            'name'  => 'Registrar Vendedor',
                            'url'   => 'gc_registrar_vendedor.php'
                        ),
                        array(
                            'name'  => 'Ver Vendedor',
                            'url'   => 'gc_ver_vendedores.php'
                        )
                    )
                ),
                array(
                    'name'  => 'Clientes',
                    'icon'  => 'fa fa-group',
                    'sub'   => array(
                        array(
                            'name'  => 'Registrar Cliente',
                            'url'   => 'gc_registrar_cliente.php'
                        ),
                        array(
                            'name'  => 'Ver Clientes',
                            'url'   => 'gc_ver_cliente.php'
                        )
                    )
                ),
                array(
                    'name'  => 'Inmuebles',
                    'icon'  => 'fa fa-building-o',
                    'sub'   => array(
                        array(
                            'name'  => 'Registrar Grupos Inmueble',
                            'url'   => 'gc_registrar_grupo_inmuebles.php'
                        ),
                        array(
                            'name'  => 'Ver Grupo inmuebles',
                            'url'   => 'gc_ver_grupo_inmueble.php'
                        ),
                        array(
                            'name'  => '--------------------------------'
                        ),
                        array(
                            'name'  => 'Registrar Inmueble',
                            'url'   => 'gc_registrar_inmueble.php'
                        ),
                        array(
                            'name'  => 'Ver Inmuebles',
                            'url'   => 'gc_busqueda_inmueble.php'
                        ),
                        array(
                            'name'  => '--------------------------------'
                        ),
                        array(
                            'name'  => 'Registrar Tipo Inmueble',
                            'url'   => 'gc_registrar_tipo_inmueble.php'
                        ),
                        array(
                            'name'  => 'Ver Tipo Inmueble',
                            'url'   => 'gc_ver_tipo_inmuebles.php'
                        ),
                        array(
                            'name'  => '--------------------------------'
                        ),
                        array(
                            'name'  => 'Reservar Inmueble',
                            'url'   => 'gc_reservar_inmueble.php'
                        ),
                        array(
                            'name'  => 'Ver Reservaciones',
                            'url'   => 'gc_ver_reservas_inmuebles.php'
                        ),
                        array(
                            'name'  => '--------------------------------'
                        ),
                        array(
                            'name'  => 'Registrar Contrato de Venta',
                            'url'   => 'gc_registrar_contrato_ventas.php'
                        ),
                        array(
                            'name'  => 'Asignar Comision',
                            'url'   => 'gc_asignar_comision.php'
                        ),
                        array(
                            'name'  => 'Ver Comisiones',
                            'url'   => 'gc_ver_comisiones.php'
                        ),
                        array(
                            'name'  => 'Ver Contrato de Venta',
                            'url'   => 'gc_ver_contrato_venta.php'
                        ),
                        array(
                            'name'  => 'Registrar Facturas',
                            'url'   => 'gc_registrar_documento.php'
                        ),
                        array(
                            'name'  => 'Ver Facturas',
                            'url'   => 'gc_ver_documentos.php'
                        ),
                        array(
                            'name'  => '--------------------------------'
                        ),
                        array(
                            'name'  => 'Edo. cuenta cliente',
                            'url'   => 'gc_estado_cuenta_cliente_1.php'
                        )
                    )
                )
            )
        )

      );


    }
}
