<script type="text/javascript" src="jshash-2.2/md5-min.js"></script>

<script language="javascript" type="text/javascript">
	function guardar()
	{
		var cadena = "";
		if(document.formulario.id_empleado.value=='')
			cadena+= "\n* Debe elegir un empleado";
		
		if(document.formulario.id_usuario.value=='')
			cadena+= "\n* Debe asignar un ID Usuario";
			
		if(document.formulario.changepassword.checked==true)
		{
			if(document.formulario.password1.value=='')
				cadena+= "\n* Debe asignar una contraseña.";
			if(document.formulario.password1.value!=document.formulario.password2.value)
				cadena+= "\n* Las contraseñas no coinciden.";
		}
		
		if(cadena == "")
		{
			document.formulario.md5password.value = hex_md5(document.formulario.password1.value);
			document.formulario.password1.value = "";
			document.formulario.password2.value = "";
			document.formulario.submit();
		}
		else
			alert("Por favor verifique lo siguiente:"+cadena);
	}
	function desbloquear(caja)
	{
		var div_pass = document.getElementById("div_passwords");
		if(caja.checked==true)
		{
			div_pass.style.display = "block";
			document.formulario.password1.disabled = false;
			document.formulario.password2.disabled = false;
		}
		else
		{
			
			div_pass.style.display = "none";
			document.formulario.password1.disabled = true;
			document.formulario.password2.disabled = true;			
		}
	}
	//Se han agregado estas dos variables obligatorias 
	var contenedor_empleado = ""; //Se actualiza para saber en que input se coloca la llave del cliente
	var parametro_sucursal_empleado = "";// Se utiliza en caso de que queramos la lista de clientes de una sucursal en especifica
	function cambio_id_empleado(id){}
</script>

<table border="0px"  width="100%" style="color:#000000;font-size:12px">
	<tr>
    	<td align="right">
        	<table border="0" width="100%" cellpadding="0" cellspacing="0" >
            	<tr>
            	<td width="5px" background="imagenes/module_left.png"></td>
                <td width="70px" background="imagenes/module_center.png" height="80"  valign="middle"><img src="imagenes/editar_usuario.png" /></td>
                <td align="left" background="imagenes/module_center.png" height="80" valign="middle" class="titulo"><b>&nbsp;&nbsp;EDITAR USUARIO&nbsp;&nbsp;</b></td>
                <td align="right" background="imagenes/module_center.png" height="80" >
                    <button class="boton2" id="guardar" onclick="guardar()" ><img src="imagenes/guardar.png" /><br/>Guardar</button>
					<button class="boton2" onclick="location.href='index.php?menu=2'"><img src="imagenes/cancelar.png" /><br />Cancelar</button>
                </td>
                <td width="5px" background="imagenes/module_right.png"></td>
                </tr>
            </table>
        </td>
	</tr>	
    <?php
		if(isset($_GET['id']))
			$id=$_GET['id'];
		else
		{
		
			
			foreach($_POST as $variable => $valor)
			{
				if($variable != "selector")
				{
					if($variable != "accion")
					{
						$id = $variable;
					}
				}
			}
		}
		if(isset($id))
		{
			
			$query = "select * from usuario where id_usuario='".addslashes($id)."'";
			$registro = devolverValorQuery($query);
			if($registro[0]!='')
			{
	?>
    <tr><td height="10px"></td></tr>
	<tr>
		<td colspan="3">
        	<form name="formulario" method="post" action="index.php?menu=2">
            <table class="datagrid" width="100%" border="0" cellspacing="0">
				<tr><td  height="3px" class="separador"></td></tr>
				<tr class="tabla_columns">
					<td>Persona Relacionada</td>
				</tr>
				<tr>
					<td>
						
						<table style="color:#000000">
							<tr><td>Clave del Empleado</td><td valign="middle"><input name="id_empleado" id="id_empleado"  value="<?php echo $registro[1]; ?>" readonly="readonly" style="width:110px;font-size:12px;" type="text" maxlength="12" />&nbsp;<img style="cursor:pointer;position:relative; top:4px;" onclick="contenedor_empleado='id_empleado';createWindow('Buscar Empleado',450,310 ,2,false,true);" src="imagenes/popup.png" /></td></tr>             
						</table>
						<input name="accion"  type="hidden" value="agregar" />
						
					</td>
				</tr>
				<tr><td  height="3px" class="separador"></td></tr>
			</table>
			<table class="datagrid" width="100%" border="0" cellspacing="0">
				<tr><td  height="3px" class="separador"></td></tr>
				<tr class="tabla_columns">
					<td >Detalles del Usuario</td>
				</tr>
				<tr>
					<td>					
						<table style="color:#000000">
							<tr><td>ID Usuario</td><td><input name="id_usuario" style="width:200px" type="text" value="<?php echo $registro[0]; ?>" maxlength="12" /></td></tr>
                            <tr>
                            	<td>Tipo Usuario</td>
                                <td>
                                	<select name="tipo_usuario" onchange="verificaTipo(this.value)">
                                    	<?php
											$query_t_u = "select * from cat_tipo_usuario order by id_tipo_usuario desc";
											$tabla_t_u = mysqli_query($conexion,$query_t_u);
											while($registro_t_u = mysqli_fetch_array($tabla_t_u))
											{
												if($registro[2]==$registro_t_u[0])
													echo "<option value=\"$registro_t_u[0]\" selected=\"selected\">$registro_t_u[1]</option>";
												else
													echo "<option value=\"$registro_t_u[0]\">$registro_t_u[1]</option>";
											}
                                        ?>
                                    </select>
                                </td>
                            </tr>          
                            <tr>
                            	<td colspan="2">
                            	<input type="checkbox" onclick="desbloquear(this)" id="changepassword" name="changepassword" /> <label  for="changepassword">Cambiar contrase&ntilde;a tambi&eacute;n.</label>
                           		<div id="div_passwords" style="display:none">
                                	<br />
                                	<table style="color:#000" >
                                        <tr><td>Contrase&ntilde;a</td><td><input name="password1" style="width:150px" type="password" maxlength="12" disabled="disabled" /><input type="hidden" name="md5password" /></td></tr>
                                		<tr><td>Repertir Contrase&ntilde;a</td><td><input name="password2" style="width:150px" disabled="disabled" type="password" maxlength="12" /></td></tr>
                                    </table>
                                </div>
                                </td>
                           </tr>
                           
							
						</table>
						<input name="accion"  type="hidden" value="editar" />
						<input name="id"  type="hidden" value="<?php echo $id; ?>" />
											
					</td>
				</tr>
				<tr><td  height="3px" class="separador"></td></tr>
			</table>
            </form>	
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
