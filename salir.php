<?php require("conexion/conexion.php"); ?>
<?php session_start(); ?>
<?php /* ################ AUDITORIA DE SEGUIMIENTO ############## */ ?>
<?php require("funciones/funciones_auditorias.php"); ?>
<?php if(isset($_SESSION['session_gc'])){ ?>
<?php $lugar_mapa = 32; ?>
<?php $dispositivo_acceso = obtener_dispositivo(); ?>
<?php insertar_log_seguimiento($conexion2, ObtenerIP(), $dispositivo_acceso, $lugar_mapa, $_SESSION['session_gc']['usua_id']); }else{ ?>
<?php $lugar_mapa = 30; ?>
<?php $dispositivo_acceso = obtener_dispositivo(); ?>
<?php insertar_log_seguimiento($conexion2, ObtenerIP(), $dispositivo_acceso, $lugar_mapa, 0); } ?>
<?php /* ######################################################## */ ?>
<?php session_start(); ?>
<?php session_unset(); ?>
<?php session_destroy(); ?>
<?php /* header('Location: index.php'); */ ?>
<?php /* exit();*/ ?>
<script type="text/javascript">
	window.location="index.php";
</script>

<?php 										#
											   ##
											   ##
											   ##
											  ####
											# ######
										   ### ######
										  ##### ######
										 ####### ######
										  ####### ####
										   ####### ##
										    ####### #
										   # #######
										  ### #######
										 ##### #######
										####### #######
										 ####### #######
										  ####### #####
										    ###### ###
										   # ###### #
										  ### ######
										 ##### #######
										####### #######
										 ####### #######
										  ####### #####
										    ###### ###
										   # ###### #
										  ### ######
										 ##### ######
										  ##### ######
									#######################
									#######################
									#######################
									#######################
									#######################
									#######################
									#######################
									#######################
								################################
								#							   #
								#	Programadores Web 		   #
								#							   #
								#	Pedro Arrieta - Senior PHP #
								#							   #
								#	dChain					   #
								#							   #
								#	Un Chamo en Panama!		   #
								#							   #
								################################ ?>
