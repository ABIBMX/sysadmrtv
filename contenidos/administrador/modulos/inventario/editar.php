<script type="text/javascript" src="jshash-2.2/md5-min.js"></script>
<script language="javascript" type="text/javascript">
	
	function guardar()
	{
		var cadena = "";
		if(document.formulario.sucursal.value=='null')
			cadena+= "\n* Debe asignar una sucursal.";
		
		if(document.formulario.equipo.value=='null')
			cadena+= "\n* Debe asignar un equipo.";
			
		if(document.formulario.cantidad.value=='')
			cadena+= "\n* Debe asignar una cantidad.";
			
		
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

<table border="0"  width="100%" style="color:#000000;font-size:12px">
	<tr>    
    	<td align="right">
        	<table border="0" width="100%" cellpadding="0" cellspacing="0" >
            	<tr>
            	<td width="5px" background="imagenes/module_left.png"></td>
                <td width="70px" background="imagenes/module_center.png" height="80"  valign="middle"><img src="imagenes/inventario.png" /></td>
                <td align="left" background="imagenes/module_center.png" height="80" valign="middle" class="titulo"><b>&nbsp;&nbsp;EDITAR EQUIPO-INVENTARIO</b></td>
                <td align="right" background="imagenes/module_center.png" height="80" >
                    <button class="boton2" id="guardar" onclick="guardar()" ><img src="imagenes/guardar.png" /><br/>Guardar</button>
					<button class="boton2" onclick="location.href='index.php?menu=22'"><img src="imagenes/cancelar.png" /><br />Cancelar</button>
                </td>
                <td width="5px" background="imagenes/module_right.png"></td>
                </tr>
            </table>
        </td>
	</tr>	
    <?php
	
		if(isset($_GET['s'])&&isset($_GET['e']))
		{
			$s=$_GET['s'];
			$e=$_GET['e'];
		}
		else
		{
		
			
			foreach($_POST as $variable => $valor)
			{
				if($variable != "selector")
				{
					if($variable != "accion")
					{
						list($s, $e) = explode("_", $variable);
						
					}
				}
			}
		}
		if(isset($s)&&isset($e))
		{
			
			$query = "select * from inventario where id_sucursal='".addslashes($s)."' and id_equipo_inventario='".addslashes($e)."'";
			$registro = devolverValorQuery($query);
			if($registro[0]!='')
			{
	?>
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
						<form name="formulario" method="post" onsubmit="return false;"  action="index.php?menu=22">
						<table style="color:#000000" cellpadding="5">
                            <tr>
                            	<td>Sucursal</td>
                                <td>
                                	<select name="sucursal" style="width:300px; font-size:12px;">
                                    	<option value="null">Elige una Sucursal</option>
										<?php
											$query_t_u = "select * from sucursales order by id_sucursal asc";
											$tabla_t_u = mysqli_query($conexion,$query_t_u);
											while($registro_t_u = mysqli_fetch_array($tabla_t_u))
											{
												if($registro[0]==$registro_t_u[0])
													echo "<option value=\"$registro_t_u[0]\" selected=\"selected\">$registro_t_u[1]</option>";						   
												else
													echo "<option value=\"$registro_t_u[0]\">$registro_t_u[1]</option>";
											}
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                            	<td>Equipo</td>
                                <td>
                                	<select name="equipo"  style="width:300px; font-size:12px;">
                                    	<option value="null">Elige un Equipo</option>
										<?php
											$query_t_u = "select * from cat_equipos_inventario order by id_equipo_inventario asc";
											$tabla_t_u = mysqli_query($conexion,$query_t_u);
											while($registro_t_u = mysqli_fetch_array($tabla_t_u))
											{
												if($registro[1]==$registro_t_u[0])
													echo "<option value=\"$registro_t_u[0]\" selected=\"selected\">$registro_t_u[1]</option>";						   
												else
													echo "<option value=\"$registro_t_u[0]\">$registro_t_u[1]</option>";
											}
                                        ?>
                                    </select>
                                </td>
                            </tr>
                        	<tr><td>Cantidad</td><td><input name="cantidad" onchange="solo_numeros(this)"  value="<?php echo $registro[2]; ?>"onkeyup="solo_numeros(this)" style="width:50px;font-size:12px;" type="text" maxlength="255" /></td></tr>                                                            
                        
                        </table>
						<input name="accion"  type="hidden" value="editar" />
						<input name="s"  type="hidden" value="<?php echo $s; ?>" />
                        <input name="e"  type="hidden" value="<?php echo $e; ?>" />
						</form>						
					</td>
				</tr>
				<tr><td  height="3px" class="separador"></td></tr>
			</table>
		</td>
	</tr>
    <?php
			}
			else
			{
				?>
				<script>
					var variable = document.getElementById("guardar");
					variable.disabled=true;
					variable.style.display= "none";
				</script>
                <tr>
                    <td colspan="3" align="center">
                        <table border="0" width="100%" cellpadding="0" cellspacing="0" >
                            <tr>                                    	
                                <td width="5px" background="imagenes/message_error_left.png"></td>
                                <td align="center" background="imagenes/message_error_center.png" height="30" valign="middle" class="warning">El registro que desea editar no existe.</td>
                                <td width="5px" background="imagenes/message_error_right.png"></td>
                            </tr>
                        </table>
                    </td>
                </tr>
				<?php
			}
		}
		else
		{
			?>
			<script>
					var variable = document.getElementById("guardar");
					variable.disabled=true;
					variable.style.display= "none";
			</script>
			<tr>
                    <td colspan="3" align="center">
                        <table border="0" width="100%" cellpadding="0" cellspacing="0" >
                            <tr>                                    	
                                <td width="5px" background="imagenes/message_error_left.png"></td>
                                <td align="center" background="imagenes/message_error_center.png" height="30" valign="middle" class="warning">No se puede editar este registro.</td>
                                <td width="5px" background="imagenes/message_error_right.png"></td>
                            </tr>
                        </table>
                    </td>
                </tr>
			<?php
		}
	?>
</table>
