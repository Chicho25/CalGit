<?php

      class generales{

            function contar($conexion, $tabla, $columna_stat, $stat){
              $sql_contar = $conexion -> query("SELECT COUNT(*) AS CONTAR FROM $tabla WHERE $columna_stat = $stat");
              while($r = $sql_contar -> fetch_array()){
                    return $r['CONTAR'];
              }
            }

            function contar_inmuebles($conexion, $tabla, $columna, $stat_1, $stat_2, $stat_3){
              $sql_contar = $conexion -> query("SELECT
                                                  COUNT(*) AS CONTAR
                                                FROM
                                                  $tabla
                                                WHERE
                                                  $columna IN($stat_1, $stat_2, $stat_3)");
                while($z = $sql_contar -> fetch_array()){
                      return $z['CONTAR'];
                }
            }

            function contar_inmuebles_tipo($conexion, $tabla, $columna_1, $columna_2, $tipo, $stat_1, $stat_2, $stat_3){
              $sql_contar = $conexion -> query("SELECT
                                                  COUNT(*) AS CONTAR
                                                FROM
                                                  $tabla
                                                WHERE
                                                  $columna_1 IN($stat_1, $stat_2, $stat_3)
                                                  AND
                                                  $columna_2 = $tipo");
                while($z = $sql_contar -> fetch_array()){
                      return $z['CONTAR'];
                }
            }

      }

?>
