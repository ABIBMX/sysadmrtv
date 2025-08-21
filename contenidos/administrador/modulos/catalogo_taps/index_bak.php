<script language="javascript" type="text/javascript">
	function seleccionar()
	{
		if(document.datagrid.selector.checked)
		{
			for(var i = 1; i<document.datagrid.elements.length; i++)
			{
				document.datagrid.elements[i].checked = true;
			
			}
		}
		else
		{
			for(var i = 1; i<document.datagrid.elements.length; i++)
			{
				document.datagrid.elements[i].checked = false;
			
			}
		}
	}
	function editar()
	{
		var contador=0;
		for(var j = 1; j<document.datagrid.elements.length; j++)
		{
			if(document.datagrid.elements[j].checked)
			{
				contador++;
			}
		}
		if(contador==1)
		{
			document.datagrid.action = "index.php?menu=20&accion=editar"
			document.datagrid.submit();
		}
		else
		{
			if(contador==0)
				window.alert("No ha seleccionado nada.");
			else
				window.alert("Solo puede seleccionar 1 registro");
		}
	}
	function eliminar()
	{
		document.datagrid.accion.value = "eliminar";
		var checado="no";
		for(var j = 1; j<document.datagrid.elements.length; j++)
		{
			if(document.datagrid.elements[j].checked)
			{
				checado = "si";
			}
		}
		if(checado=="si")
		{
			if(window.confirm("Est\u00e1s seguro de ELIMINAR los registros seleccionados?"))
				document.datagrid.submit();
		}
		else
		{
			window.alert("No ha seleccionado ningun registro");
		}
	}
</script>
<table border="0px"  width="100%" style="color:#000000;font-size:12px">
	<tr>    
    	<td align="right">
        	<table border="0" width="100%" cellpadding="0" cellspacing="0" >
            	<tr>
            	<td width="5px" background="imagenes/module_left.png"></td>
                <td width="70px" background="imagenes/module_center.png" height="80"  valign="middle"><img src="imagenes/maps.png" /></td>
                <td align="left" background="imagenes/module_center.png" height="80" valign="middle" class="titulo"><b>&nbsp;&nbsp;TAPS&nbsp;&nbsp;</b></td>
                <td align="right" background="imagenes/module_center.png" height="80" >
                    <button class="boton2" onclick="location.href='index.php?menu=20&accion=agregar'" ><img src="imagenes/agregar.png" /><br/>Agregar</button>
                    <button class="boton2" onclick="editar()"><img src="imagenes/editar.png" /><br />Editar</button>
                    <button class="boton2" onclick="eliminar()"><img src="imagenes/eliminar.png" /><br />Eliminar</button>
                </td>
                <td width="5px" background="imagenes/module_right.png"></td>
                </tr>
            </table>
        </td>
	</tr>
	<?php
		if(isset($_POST['accion']))
		{
			switch($_POST['accion'])
			{
				case 'editar':
					
					$query = "update tap set id_sucursal='".addslashes(strtoupper($_POST['sucursal']))."', id_tap='".addslashes(strtoupper($_POST['id_tap']))."',valor='".addslashes(strtoupper($_POST['valor']))."',salidas='".addslashes(strtoupper($_POST['salidas']))."'  where id_tap='".addslashes($_POST['id'])."'";
					
					if(mysqli_query($conexion,$query))
					{
						?>
							<tr>
                            	<td colspan="3" align="center" >
                                	<table border="0" width="100%" cellpadding="0" cellspacing="0" >
                                		<tr>                                    	
                                        	<td width="5px" background="imagenes/message_left.png"></td>
	                                        <td align="center" background="imagenes/message_center.png" height="30" valign="middle" class="fine">Los datos fueron editados correctamente</td>
    	                                    <td width="5px" background="imagenes/message_right.png"></td>
                                        </tr>
                                    </table>                           
                            	</td>
                           </tr>
						<?php
							
					}
					else
					{
						?>
						<tr>
                        	<td colspan="3" align="center">
                            	<table border="0" width="100%" cellpadding="0" cellspacing="0" >
                                    <tr>                                    	
                                        <td width="5px" background="imagenes/message_error_left.png"></td>
                                        <td align="center" background="imagenes/message_error_center.png" height="30" valign="middle" class="warning">Hubo un problema al editar los datos.</td>
                                        <td width="5px" background="imagenes/message_error_right.png"></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
						<?php
					}
					break;
					
				case 'agregar':
				
					$query = "insert into tap (id_tap,valor,salidas,id_sucursal) values ('".addslashes(strtoupper($_POST['id_tap']))."','".addslashes(strtoupper($_POST['valor']))."','".addslashes(strtoupper($_POST['salidas']))."','".addslashes(strtoupper($_POST['sucursal']))."')";
					if(mysqli_query($conexion,$query))
					{
						?>
							<tr>
                            	<td colspan="3" align="center" >
                                	<table border="0" width="100%" cellpadding="0" cellspacing="0" >
                                		<tr>                                    	
                                        	<td width="5px" background="imagenes/message_left.png"></td>
	                                        <td align="center" background="imagenes/message_center.png" height="30" valign="middle" class="fine">Los datos fueron agregados correctamente</td>
    	                                    <td width="5px" background="imagenes/message_right.png"></td>
                                        </tr>
                                    </table>                           
                            	</td>
                           </tr>
						<?php
					}
					else
					{
						?>
						<tr>
                        	<td colspan="3" align="center">
                            	<table border="0" width="100%" cellpadding="0" cellspacing="0" >
                                    <tr>                                    	
                                        <td width="5px" background="imagenes/message_error_left.png"></td>
                                        <td align="center" background="imagenes/message_error_center.png" height="30" valign="middle" class="warning">Hubo un problema al agregar los datos.</td>
                                        <td width="5px" background="imagenes/message_error_right.png"></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
						<?php
					}
					break;
				case 'eliminar':
					foreach($_POST as $variable => $valor)
					{
						if($variable != "selector")
						{
							if($variable != "accion")
							{
								$query_eliminar = "DELETE FROM tap WHERE id_tap='".addslashes($variable)."'";
								if(mysqli_query($conexion,$query_eliminar))
									$bandera = true;
									
								else
									$bandera=false;											
							} 
						}
					}
					if($bandera)
					{
						?>
						<tr>
                        	<td colspan="3" align="center">
                            	<table border="0" width="100%" cellpadding="0" cellspacing="0" >
                                    <tr>                                    	
                                        <td width="5px" background="imagenes/message_left.png"></td>
                                        <td align="center" background="imagenes/message_center.png" height="30" valign="middle" class="fine">Los registros fueron eliminados.</td>
                                        <td width="5px" background="imagenes/message_right.png"></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
						<?php
					}
					else
					{
						?>
						 <tr>
                        	<td colspan="3" align="center">
                            	<table border="0" width="100%" cellpadding="0" cellspacing="0" >
                                    <tr>                                    	
                                        <td width="5px" background="imagenes/message_error_left.png"></td>
                                        <td align="center" background="imagenes/message_error_center.png" height="30" valign="middle" class="warning">Hubo un problema al eliminar los registros.</td>
                                        <td width="5px" background="imagenes/message_error_right.png"></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
						<?php
					}
					break;
			}
		}
	?>
    <tr><td height="10px"></td></tr>
	<tr>
		<td colspan="3">
			<form name="datagrid" method="post">
			<table class="datagrid" width="100%" border="0" cellspacing="0">
				<tr><td colspan="5" height="3px" class="separador"></td></tr>
				<tr class="tabla_columns">
                    <td>ID TAP</td>
                    <td>Valor</td>
                    <td>Salidas</td>
                    <td>Sucursal</td>                    
					<td align="center" width="50px"><input type="checkbox" name="selector" onclick="seleccionar()" /><input type='hidden'name='accion'/></td>
				</tr>
				<?php
					$query = "select * from tap order by id_sucursal asc";
					$tabla = mysqli_query($conexion,$query);
					while($registro=mysqli_fetch_array($tabla))
					{
						$bandera = true;
						?>
							<tr class="tabla_row">
								<td><a href="index.php?menu=20&accion=editar&id=<?php echo $registro[0];  ?>"><?php echo $registro[0]; ?></a></td>
                                <td><?php echo $registro[1]; ?></td>
                                <td><?php echo $registro[2]; ?></td>
                                <td><?php echo $registro[3]; ?></td>
								<td align="center"><input type="checkbox" name="<?php echo $registro[0];  ?>" /></td>
							</tr>
						<?php
					}
					if(!$bandera)
					{
						?>
                        <tr><td colspan="5">No hay Registros</td></tr>
                        <?php
					}
				?>
				<tr><td colspan="5"  height="3px" class="separador"></td></tr>
			</table>
			</form>
		</td>
	</tr>
</table>