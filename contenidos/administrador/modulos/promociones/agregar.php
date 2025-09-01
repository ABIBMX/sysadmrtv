<script language="javascript" type="text/javascript">
	
	function guardar()
	{
		var cadena = "";
		
		if(document.formulario.tipo_ingreso.value=='null')
			cadena+= "\n* Debe elegir un tipo de ingreso.";	
		if(document.formulario.descripcion.value=='')
			cadena+= "\n* Debe asignar una nombre.";
		if(document.formulario.porcentaje.value=='')
			cadena+= "\n* Debe asignar un porcentaje.";			
		
		if(cadena == "")
		{
			document.formulario.submit();
		}
		else
			alert("Por favor verifique lo siguiente:"+cadena);
	}
	function solo_numeros(texto)
	{
		var expresion = /[0-9]*/;
		texto.value = texto.value.match(expresion);
	}
	function solo_numeros_decimales(texto)
	{
		var expresion = /[0-9]*\.?[0-9]{0,2}/;
		texto.value = texto.value.match(expresion);
	}
</script>

<table border="0px"  width="100%" style="color:#000000;font-size:12px">
	<tr>    
    	<td align="right">
        	<table border="0" width="100%" cellpadding="0" cellspacing="0" >
            	<tr>
            	<td width="5px" background="imagenes/module_left.png"></td>
                <td width="70px" background="imagenes/module_center.png" height="80"  valign="middle"><img src="imagenes/promociones.png" /></td>
                <td align="left" background="imagenes/module_center.png" height="80" valign="middle" class="titulo"><b>&nbsp;&nbsp;AGREGAR PROMOCI&Oacute;N&nbsp;&nbsp;</b></td>
                <td align="right" background="imagenes/module_center.png" height="80" >
                    <button class="boton2" onclick="guardar()" ><img src="imagenes/guardar.png" /><br/>Guardar</button>
					<button class="boton2" onclick="location.href='index.php?menu=26'"><img src="imagenes/cancelar.png" /><br />Cancelar</button>
                </td>
                <td width="5px" background="imagenes/module_right.png"></td>
                </tr>
            </table>
        </td>
	</tr>
    <tr><td height="10px"></td></tr>
	<tr>
		<td colspan="3">
			<table class="datagrid" width="100%" border="0" cellspacing="0">
				<tr><td  height="3px" class="separador"></td></tr>
				<tr class="tabla_columns">
					<td >Detalles</td>
				</tr>
				<tr>
					<td>
						<form name="formulario" method="post" onsubmit="return false;" action="index.php?menu=26">
						<table style="color:#000000" cellpadding="5">  
                        	<tr>
                            	<td>Tipo Ingreso</td>
                                <td>
                                	<select name="tipo_ingreso"  style="width:300px; font-size:12px;">
                                    	<option value="null">Elige un tipo de ingreso</option>
										<?php
											$query_t_u = "select * from cat_tipo_ingreso";
											$tabla_t_u = mysqli_query($conexion,$query_t_u);
											while($registro_t_u = mysqli_fetch_array($tabla_t_u))
											{
												echo "<option value=\"$registro_t_u[0]\">$registro_t_u[1]</option>";
											}
                                        ?>
                                    </select>
                                </td>
                            </tr>                      	
                            <tr><td>Nombre</td><td><input name="descripcion" style="width:300px;font-size:12px;" type="text" maxlength="255" /></td></tr> 
                            <tr><td>Descuento </td><td>$ <input name="porcentaje" style="width:50px;font-size:12px;" onblur="solo_numeros(this)" onkeyup="solo_numeros(this)" type="text" maxlength="255" /></td></tr>
                            <tr>
                            	<td>
                                	Estado
                                </td>
                                <td>
                                	<input type="radio" name="activo" id="activo_1" value="1" checked="checked" /><label for="activo_1">&nbsp;Activo</label>&nbsp;&nbsp;
                                    <input type="radio" name="activo" id="activo_2" value="0" /><label for="activo_2">&nbsp;No Activo</label>
                                </td>
                            </tr>                                                         
						</table>
						<input name="accion"  type="hidden" value="agregar" />
						</form>
					</td>
				</tr>
				<tr><td  height="3px" class="separador"></td></tr>
			</table>
		</td>
	</tr>
</table>
