<?php

include('../Connections/conexion.php');
mysql_select_db($database_conexion, $conexion);
$tabla='usuarios_menu';
$tabla1='vista_usuarios_menu';
$usuario_activo=$_SESSION['i'];

//$usuario_activo=1;
?>
<ul id="MenuBar1" class="MenuBarHorizontal">
			<?php $buscar=mysql_query('SELECT * FROM '.$tabla1.' where NIVEL_MENU = 1 AND ID_USUARIO =' .$usuario_activo); ?>
            <?php while($clave_bd=mysql_fetch_array($buscar)) { $grupo = $clave_bd['ID_MENU'];
			if ($clave_bd['NIVEL_MENU']==1){ ?>  
            <li><a href="<?php echo $clave_bd['LINK_MENU']; ?>"<?php if ($clave_bd['LINK_MENU']=='pdf.php'){ ?> target="_blank" <?php }?> class="MenuBarItemSubmenu"><?php echo $clave_bd['DESCRIPCION_MENU']; ?></a>
            <ul>
            <?php $buscar1=mysql_query('SELECT * FROM '.$tabla1.' where ID_USUARIO =' .$usuario_activo. ' and ID_GRUPO_MENU=' .$grupo); ?>
            <?php while($clave_bd1=mysql_fetch_array($buscar1)) { $grupo1 = $clave_bd1['ID_MENU'];
			if (substr($clave_bd1['DETALLE_ACCESO'],0,1)==1){ ?>   
            <li><a href="<?php echo $clave_bd1['LINK_MENU']; ?>"<?php if ($clave_bd1['LINK_MENU']=='pdf.php'){ ?> target="_blank" <?php }?> class="MenuBarItemSubmenu"><?php echo $clave_bd1['DESCRIPCION_MENU']; ?></a>
            <ul>
            <?php $buscar2=mysql_query('SELECT * FROM '.$tabla1.' where ID_USUARIO =' .$usuario_activo. ' and ID_GRUPO_MENU=' .$grupo1); ?>
            <?php while($clave_bd2=mysql_fetch_array($buscar2)) { $grupo2 = $clave_bd2['ID_MENU'];
			if (substr($clave_bd2['DETALLE_ACCESO'],0,1)==1){ ?>  
            <li><a href="<?php echo $clave_bd2['LINK_MENU']; ?>"<?php if ($clave_bd2['LINK_MENU']=='pdf.php'){ ?> target="_blank" <?php }?> class="MenuBarItemSubmenu"><?php echo $clave_bd2['DESCRIPCION_MENU']; ?></a>
			<ul>
            <?php $buscar3=mysql_query('SELECT * FROM '.$tabla1.' where ID_USUARIO =' .$usuario_activo. ' and ID_GRUPO_MENU=' .$grupo2); ?>
            <?php while($clave_bd3=mysql_fetch_array($buscar3)) { $grupo3 = $clave_bd3['ID_MENU'];
			if (substr($clave_bd3['DETALLE_ACCESO'],0,1)==1){ ?>    
            <li><a href="<?php echo $clave_bd3['LINK_MENU']; ?>"<?php if ($clave_bd3['LINK_MENU']=='pdf.php'){ ?> target="_blank" <?php }?> class="MenuBarItemSubmenu"><?php echo $clave_bd3['DESCRIPCION_MENU']; ?></a>
            <ul>
            <?php $buscar4=mysql_query('SELECT * FROM '.$tabla1.' where ID_USUARIO =' .$usuario_activo. ' and ID_GRUPO_MENU=' .$grupo3); ?>
            <?php while($clave_bd4=mysql_fetch_array($buscar4)) { $grupo4 = $clave_bd4['ID_MENU'];
			if (substr($clave_bd4['DETALLE_ACCESO'],0,1)==1){ ?>    
            <li><a href="<?php echo $clave_bd4['LINK_MENU']; ?>"<?php if ($clave_bd4['LINK_MENU']=='pdf.php'){ ?> target="_blank" <?php }?> class="MenuBarItemSubmenu"><?php echo $clave_bd4['DESCRIPCION_MENU']; ?></a>
            <ul>
            <?php $buscar5=mysql_query('SELECT * FROM '.$tabla1.' where ID_USUARIO =' .$usuario_activo. ' and ID_GRUPO_MENU=' .$grupo4); ?>
            <?php while($clave_bd5=mysql_fetch_array($buscar5)) { $grupo5 = $clave_bd5['ID_MENU'];
			if (substr($clave_bd5['DETALLE_ACCESO'],0,1)==1){ ?>            
            <li><a href="<?php echo $clave_bd5['LINK_MENU']; ?>"<?php if ($clave_bd5['LINK_MENU']=='pdf.php'){ ?> target="_blank" <?php }?> class="MenuBarItemSubmenu"><?php echo $clave_bd5['DESCRIPCION_MENU']; ?></a>
                </li><?php } } ?></ul>
                </li><?php } } ?></ul>
                </li><?php } } ?></ul>
                </li><?php } } ?></ul>
                </li><?php } } ?></ul>
        		</li><?php } } ?></ul>
                <script type="text/javascript">
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"SpryAssets/SpryMenuBarDownHover.gif", imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
</script>
