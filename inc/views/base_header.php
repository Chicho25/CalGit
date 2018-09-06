<?php
/**
 * base_header.php
 *
 * Author: pixelcave
 *
 * The header of each page (Backend)
 *
 */
?>

<!-- Header -->
<header id="header-navbar" class="content-mini content-mini-full">
    <!-- Header Navigation Right -->
    <ul class="nav-header pull-right">
        <li>
            <div class="btn-group">
                <button class="btn btn-default btn-image dropdown-toggle" data-toggle="dropdown" type="button">
                    <img src="<?php echo $_SESSION['session_gc']['usua_imagen_usuario']; ?>" class="img-avatar img-avatar10" alt="Avatar" />
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu dropdown-menu-right">
                    <li class="dropdown-header">Profile</li>
                    <li>
                        <a tabindex="-1" href="salir.php">
                            <i class="si si-logout pull-right"></i>Log out
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        <li>
            <!-- Layout API, functionality initialized in App() -> uiLayoutApi() -->
            <button class="btn btn-default" data-toggle="layout" data-action="side_overlay_toggle" type="button">
                <i class="fa fa-tasks"></i>
            </button>
        </li>
    </ul>
    <!-- END Header Navigation Right -->

    <!-- Header Navigation Left -->
    <ul class="nav-header pull-left">
        <li class="hidden-md hidden-lg">
            <!-- Layout API, functionality initialized in App() -> uiLayoutApi() -->
            <button class="btn btn-default" data-toggle="layout" data-action="sidebar_toggle" type="button">
                <i class="fa fa-navicon"></i>
            </button>
        </li>
        <li class="hidden-xs hidden-sm">
            <!-- Layout API, functionality initialized in App() -> uiLayoutApi() -->
            <button class="btn btn-default" data-toggle="layout" data-action="sidebar_mini_toggle" type="button">
                <i class="fa fa-ellipsis-v"></i>
            </button>
        </li><?php /*
        <li>
            <!-- Opens the Apps modal found at the bottom of the page, before including JS code -->
            <button class="btn btn-default pull-right" data-toggle="modal" data-target="#apps-modal" type="button">
                <i class="si si-grid"></i>
            </button>
        </li>
        <li class="visible-xs">
            <!-- Toggle class helper (for .js-header-search below), functionality initialized in App() -> uiToggleClass() -->
            <button class="btn btn-default" data-toggle="class-toggle" data-target=".js-header-search" data-class="header-search-xs-visible" type="button">
                <i class="fa fa-search"></i>
            </button>
        </li>
        
        <li class="js-header-search header-search">
            <form class="form-horizontal" action="base_pages_search.php" method="post">
                <div class="form-material form-material-primary input-group remove-margin-t remove-margin-b">
                    <input class="form-control" type="text" id="base-material-text" name="base-material-text" placeholder="Search..">
                    <span class="input-group-addon"><i class="si si-magnifier"></i></span>
                </div>
            </form>
        </li>*/ ?>
    </ul>
    <!-- END Header Navigation Left -->
</header>
<!-- END Header -->
