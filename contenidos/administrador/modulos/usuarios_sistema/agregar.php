<script type="text/javascript" src="jshash-2.2/md5-min.js"></script>


<script language="javascript" type="text/javascript">
	function guardar()
	{
		var cadena = "";
		
		if(document.formulario.id_empleado.value=='')
			cadena+= "\n* Debe elegir un empleado";
		
		if(document.formulario.id_usuario.value=='')
			cadena+= "\n* Debe asignar un ID Usuario";
		if(document.formulario.password1.value=='')
			cadena+= "\n* Debe asignar una contrase\u00f1a.";
		if(document.formulario.password1.value!=document.formulario.password2.value)
			cadena+= "\n* Las contrase\u00f1as no coinciden.";
			
		
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
                <td width="70px" background="imagenes/module_center.png" height="80"  valign="middle"><img src="imagenes/agregar_usuario.png" /></td>
                <td align="left" background="imagenes/module_center.png" height="80" valign="middle" class="titulo"><b>&nbsp;&nbsp;AGREGAR USUARIO&nbsp;&nbsp;</b></td>
                <td align="right" background="imagenes/module_center.png" height="80" >
                    <button class="boton2" onclick="guardar()" ><img src="imagenes/guardar.png" /><br/>Guardar</button>
					<button class="boton2" onclick="location.href='index.php?menu=2'"><img src="imagenes/cancelar.png" /><br />Cancelar</button>
                </td>
                <td width="5px" background="imagenes/module_right.png"></td>
                </tr>
            </table>
        </td>
	</tr>
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
							<tr><td>Clave del Empleado</td><td valign="middle"><input name="id_empleado" id="id_empleado" readonly="readonly" style="width:110px;font-size:12px;" type="text" maxlength="12" />&nbsp;<img style="cursor:pointer;position:relative; top:4px;" onclick="contenedor_empleado='id_empleado';createWindow('Buscar Empleado',450,310 ,2,false,true);" src="imagenes/popup.png" /></td></tr>
                                         
						</table>
						<input name="accion"  type="hidden" value="agregar" />
						
					</td>
				</tr>
				<tr><td  height="3px" class="separador"></td></tr>
			</table>
            <table class="datagrid" width="100%" border="0" cellspacing="0">
				<tr><td  height="3px" class="separador"></td></tr>
				<tr class="tabla_columns">
					<td>Detalles del Usuario</td>
				</tr>
				<tr>
					<td>
						
						<table style="color:#000000">
							<tr><td>ID Usuario</td><td><input name="id_usuario" style="width:200px;font-size:12px;" type="text" maxlength="12" /></td></tr>
                            <tr><td>Contrase&ntilde;a</td><td><input name="password1" style="width:200px;font-size:12px;" type="password" maxlength="12" /><input type="hidden" name="md5password" /></td></tr>
							<tr><td>Repertir Contrase&ntilde;a</td><td><input name="password2" style="width:200px" type="password" maxlength="12" /></td></tr>
                            <tr>
                            	<td>Tipo Usuario</td>
                                <td>
                                	<select name="tipo_usuario" style="width:200px;font-size:12px;" onchange="verificaTipo(this.value)">
                                    	<?php
											$query_t_u = "select * from cat_tipo_usuario order by id_tipo_usuario desc";
											$tabla_t_u = mysqli_query($conexion,$query_t_u);
											while($registro_t_u = mysqli_fetch_array($tabla_t_u))
											{
												echo "<option value=\"$registro_t_u[0]\">$registro_t_u[1]</option>";
											}
                                        ?>
                                    </select>
                                </td>
                            </tr>               
						</table>
						<input name="accion"  type="hidden" value="agregar" />
						
					</td>
				</tr>
				<tr><td  height="3px" class="separador"></td></tr>
			</table>
            </form>
		</td>
	</tr>
</table>
