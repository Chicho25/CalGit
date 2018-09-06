
<style>
.ui-button { margin-left: -1px; }
.ui-button-icon-only .ui-button-text { padding: 0.35em; } 
.ui-autocomplete-input { margin: 0; padding: 0.48em 0 0.47em 0.45em; width:<?php echo $ancho; ?>px; font-family:Arial, Helvetica, sans-serif; font-size:13px; font-weight:bolder }
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
		$( "#<?php echo $nombre_campo_form; ?>").combobox();
		$( "#toggle" ).click(function() {
			$( "#<?php echo $nombre_campo_form; ?>" ).toggle();
		});
	});
	</script>
<?php 

//echo $_POST['STRINGER'];


mysql_select_db($database_conexion, $conexion);
$query_proveeedor = "SELECT * FROM ".$tabla." ".$where;  
$proveeedor = mysql_query($query_proveeedor, $conexion) or die(mysql_error());
$row_proveeedor = mysql_fetch_assoc($proveeedor);
$totalRows_proveeedor = mysql_num_rows($proveeedor);
?>
<!--<table width="990" border="0" align="center" class="Campos">-->
<tr align="left" valign="middle" class="Campos">
	<td width="229" align="right"><?php echo $label; ?>:</td>
	<td width="751">
	  <select name="<?php echo $nombre_campo_form; ?>" id="<?php echo $nombre_campo_form; ?>"  align="absmiddle">
	    <option value="" <?php if (!(strcmp("", 0))) {echo "selected=\"selected\"";} ?>></option>
	    <?php
		do {  
	?>
	    <option value="<?php echo $parametro; ?><?php echo $row_proveeedor[$nombre_campo_value]?>"<?php echo $parametro; ?><?php if (!(strcmp($row_proveeedor[$nombre_campo_value], 0))) {echo "selected=\"selected\"";} ?>><?php echo $row_proveeedor[$nombre_campo_mostrar]?></option>
	    <?php
	} while ($row_proveeedor = mysql_fetch_assoc($proveeedor));
	$rows = mysql_num_rows($proveeedor);
	if($rows > 0) {
		mysql_data_seek($proveeedor, 0);
		$row_proveeedor = mysql_fetch_assoc($proveeedor);
	}
?>
	    </select>
    <?php if($boton==1) {
	  ?><img src="../img/search.png" alt="search_" width="28" height="28"  title="Buscar" align="absmiddle" onclick="javascript:<?php echo $accion; ?>"/><?php }elseif($boton==4){ ?><a href="../clientes/list.php?RESERV=<?php echo $_GET['ID_INMUEBLE_MASTER_RESERVA']; ?>&titulo_formulario=Clientes"><?php if (validador(18,$_SESSION['i'],"inc")==1) {?><img src="../img/folder_new.png" width="24" height="24" title="Crear Clientes"/><?php } ?></a><?php } ?></td>
	</tr>
   <!-- </table>-->

