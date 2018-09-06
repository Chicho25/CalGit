<style>
	.ui-button { margin-left: -1px; }
	.ui-button-icon-only .ui-button-text { padding: 0.35em; } 
	.ui-autocomplete-input { margin: 0; padding: 0.48em 0 0.47em 0.45em; width:500px; font-family:Arial, Helvetica, sans-serif; font-size:13px; font-weight:bolder }
</style>
<script>
	(function( $ ) {
		$.widget( "ui.combobox", {
			_create: function() {
				var self = this,
					select = this.element.hide(),
					selected = select.children( ":selected" ),
					value = selected.val() ? selected.text() : "";
				var input = this.input = $( "<input>" )
					.insertAfter( select )
					.val( value )
					.autocomplete({
						delay: 0,
						minLength: 0,
						source: function( request, response ) {
							var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
							response( select.children( "option" ).map(function() {
								var text = $( this ).text();
								if ( this.value && ( !request.term || matcher.test(text) ) )
									return {
										label: text.replace(
											new RegExp(
												"(?![^&;]+;)(?!<[^<>]*)(" +
												$.ui.autocomplete.escapeRegex(request.term) +
												")(?![^<>]*>)(?![^&;]+;)", "gi"
											), "<strong>$1</strong>" ),
										value: text,
										option: this
									};
							}) );
						},
						select: function( event, ui ) {
							ui.item.option.selected = true;
							self._trigger( "selected", event, {
								item: ui.item.option
							});
						},
						change: function( event, ui ) {
							if ( !ui.item ) {
								var matcher = new RegExp( "^" + $.ui.autocomplete.escapeRegex( $(this).val() ) + "$", "i" ),
									valid = false;
								select.children( "option" ).each(function() {
									if ( $( this ).text().match( matcher ) ) {
										this.selected = valid = true;
										return false;
									}
								});
								if ( !valid ) {
									// remove invalid value, as it didn't match anything
									$( this ).val( "" );
									select.val( "" );
									input.data( "autocomplete" ).term = "";
									return false;
								}
							}
						}
					})
				

				input.data( "autocomplete" )._renderItem = function( ul, item ) {
					return $( "<li></li>" )
						.data( "item.autocomplete", item )
						.append( "<a>" + item.label + "</a>" )
						.appendTo( ul );
				};

				
			},

			destroy: function() {
				this.input.remove();
				this.button.remove();
				this.element.show();
				$.Widget.prototype.destroy.call( this );
			}
		});
	})( jQuery );

	$(function() {
		$( "#combobox" ).combobox();
		$( "#toggle" ).click(function() {
			$( "#combobox" ).toggle();
		});
	});
</script>
<?php 
mysql_select_db($database_conexion, $conexion);
$query_PARTIDA = "SELECT ID, DESCRIPCION_COMPLETA FROM partidas ".$where;
$PARTIDA = mysql_query($query_PARTIDA, $conexion) or die(mysql_error());
$row_PARTIDA = mysql_fetch_assoc($PARTIDA);
$totalRows_PARTIDA = mysql_num_rows($PARTIDA);
?>
<tr>
	<td align="right" bgcolor="#F3F3F3" class="textos_form_derecha" ><?php echo $nombre_campo ?>
	<td align="left" bgcolor="#F3F3F3" >
		<select id="combobox" name="ID_PARTIDA" width="300" style="width: 300px; font-size:10px">
			<option value="" <?php if (!(strcmp(" ", 0))) {echo "selected=\"selected\"";} ?>></option>
			<?php
			do {  
			?>
			<option value="<?php echo $row_PARTIDA['ID']?>"<?php if (!(strcmp($row_PARTIDA['ID'], 0))) {echo "selected=\"selected\"";} ?>>[ID:<?php echo $row_PARTIDA['ID']?>] <?php echo $row_PARTIDA['DESCRIPCION_COMPLETA']?></option>
			<?php
			} while ($row_PARTIDA = mysql_fetch_assoc($PARTIDA));
  			$rows = mysql_num_rows($PARTIDA);
  			if($rows > 0) {
      			mysql_data_seek($PARTIDA, 0);
	  			$row_PARTIDA = mysql_fetch_assoc($PARTIDA);
  			}
			?>
		</select>
		<?php
		mysql_free_result($PARTIDA);
		?>
</td>
</tr>
