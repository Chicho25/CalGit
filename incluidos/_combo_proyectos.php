
<tr>
	<td width="398" align="right" bgcolor="#F3F3F3" class="textos_form_derecha" > Proyecto:
	<td align="left" bgcolor="#F3F3F3" ><label for="CODIGO_PROYECTO"></label>
		<select name="CODIGO_PROYECTO" id="CODIGO_PROYECTO">
			<?php
			mysql_select_db($database_conexion, $conexion);
			$query_PROYECTOS = "SELECT * FROM proyectos ORDER BY NOMBRE ASC";
			$PROYECTOS = mysql_query($query_PROYECTOS, $conexion) or die(mysql_error());
			$row_PROYECTOS = mysql_fetch_assoc($PROYECTOS);
			$totalRows_PROYECTOS = mysql_num_rows($PROYECTOS);
			do {  
			?>
			
			<option value="<?php echo $row_PROYECTOS['CODIGO']?>"><?php echo $row_PROYECTOS['NOMBRE']?></option>
			
			<?php
			} while ($row_PROYECTOS = mysql_fetch_assoc($PROYECTOS));
			  $rows = mysql_num_rows($PROYECTOS);
			  if($rows > 0) {
				  mysql_data_seek($PROYECTOS, 0);
				  $row_PROYECTOS = mysql_fetch_assoc($PROYECTOS);
			}
			?>
		</select>
</tr>
