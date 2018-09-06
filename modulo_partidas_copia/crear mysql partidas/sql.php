<?php
include_once "conexion/conexion.php";
$tabla = $conexion2 -> query("create table maestro_partidas(
                                id int not null auto_increment primary key,
                                p_nombre varchar(255),
                                id_categoria int,
                                p_monto decimal(11.2),
                                p_fecha TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                                p_status int,
                                foreign key(id_categoria) references maestro_partidas(id)
                              )");


                    if($tabla){ echo 'tabla creada';}else{ echo 'tabla no creada';}

?>
