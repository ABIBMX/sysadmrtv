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
			document.datagrid.action = "index.php?menu=22&accion=editar"
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
	function solo_numeros(texto)
	{
		var expresion = /[0-9]*/;
		texto.value = texto.value.match(expresion);
	}
	
	function imprimir_pdf()
	{		
		var aux_action = document.datagrid.action;
		var aux_target = document.datagrid.target;
		document.datagrid.action = "reporte/inventarios_admin_pdf.php";
		document.datagrid.target = "_blank";
		document.datagrid.submit();
		document.datagrid.action = aux_action;
		document.datagrid.target = aux_target;
			
	}
	function imprimir_excel()
	{
		var aux_action = document.datagrid.action;
		var aux_target = document.datagrid.target;
		document.datagrid.action = "reporte/inventarios_admin_excel.php";
		document.datagrid.target = "_blank";
		document.datagrid.submit();
		document.datagrid.action = aux_action;
		document.datagrid.target = aux_target;
	}
</script>
<div style="display:none" id="filtro_div"></div>
<table border="0"  width="100%" style="color:#000000;font-size:12px">
	<tr>    
    	<td align="right">
        	<table border="0" width="100%" cellpadding="0" cellspacing="0" >
            	<tr>
            	<td width="5px" background="imagenes/module_left.png"></td>
                <td width="70px" background="imagenes/module_center.png" height="80"  valign="middle"><img src="imagenes/inventario.png" /></td>
                <td align="left" background="imagenes/module_center.png" height="80" valign="middle" class="titulo"><b>&nbsp;&nbsp;INVENTARIO&nbsp;&nbsp;</b></td>
                <td align="right" background="imagenes/module_center.png" height="80" >
                	<?php
				   		if(isset($_POST['aplicar_filtro']))
						{
				   ?>
                    		<button class="boton2" onclick="imprimir_pdf()" ><img src="imagenes/imprimir.png" /><br/>PDF</button>
                            <button class="boton2" onclick="imprimir_excel()" ><img src="imagenes/imprimir.png" /><br/>EXCEL</button>
                    <?php
						}
					?>
                    <button class="boton2" onclick="createWindow('Filtro',450,250 ,6,false,true);" ><img src="imagenes/filter.png" /><br/>Filtro</button>
                    <button class="boton2" onclick="location.href='index.php?menu=22&accion=agregar'" ><img src="imagenes/agregar.png" /><br/>Agregar</button>
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
					
					$query = "update inventario set cantidad='".addslashes(strtoupper($_POST['cantidad']))."', id_equipo_inventario='".addslashes($_POST['equipo'])."', id_sucursal='".addslashes($_POST['sucursal'])."'  where id_sucursal='".addslashes($_POST['s'])."' and  id_equipo_inventario='".addslashes($_POST['e'])."'";
					
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
				
					$query = "insert into inventario (id_sucursal,id_equipo_inventario , cantidad) values ('".addslashes(strtoupper($_POST['sucursal']))."','".addslashes(strtoupper($_POST['equipo']))."','".addslashes(strtoupper($_POST['cantidad']))."')";
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
								$array_delete = explode("_", $variable);
								$query_eliminar = "DELETE FROM inventario WHERE id_sucursal='".addslashes($array_delete[0])."' and id_equipo_inventario='".addslashes($array_delete[1])."'";
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
				<tr><td colspan="4" height="3px" class="separador"></td></tr>
				<tr class="tabla_columns">
                    <td>Equipo</td>
                    <td>Sucursal</td>
                    <td>Cantidad</td>
					<td align="center" width="50px"><input type="checkbox" name="selector" onclick="seleccionar()" /><input type='hidden'name='accion'/></td>
				</tr>
				<?php
					if(isset($_POST['aplicar_filtro']))
					{
						$add_query="";
						if($_POST['cantidad']!="")
						{
							$add_query .= " and i.cantidad='".addslashes($_POST['cantidad'])."' ";
						}
						
						if(count($_POST['material'])>0)
						{
							$add_query .= " and (";
							for($i=0; $i< count($_POST['material']);$i++)
							{
								if($i>0)
									$add_query .= " or ";
								
								$add_query .= " i.id_equipo_inventario='".addslashes($_POST['material'][$i])."' ";
							}
							$add_query .= ") ";
						}
						if($_POST['sucursal']!="-1" && isset($_POST['sucursal']))
						{
							$add_query .= " and i.id_sucursal='".addslashes($_POST['sucursal'])."' ";
						}
						
						$query = "select cei.descripcion,i.id_sucursal, i.cantidad, i.id_equipo_inventario from inventario i, cat_equipos_inventario cei where cei.id_equipo_inventario=i.id_equipo_inventario ".$add_query." order by id_sucursal asc, i.id_equipo_inventario asc";
						
						$_SESSION['filtro_inventario'] = $query;
						$tabla = mysqli_query($conexion,$query);
						while($registro=mysqli_fetch_array($tabla))
						{
							$bandera = true;
							?>
								<tr class="tabla_row">
									<td><a href="index.php?menu=22&accion=editar&s=<?php echo $registro[1];  ?>&e=<?php echo $registro[3] ?>"><?php echo $registro[0]; ?></a></td>
									<td><a href="index.php?menu=22&accion=editar&s=<?php echo $registro[1];  ?>&e=<?php echo $registro[3] ?>"><?php echo $registro[1]; ?></a></td>
									<td><a href="index.php?menu=22&accion=editar&s=<?php echo $registro[1];  ?>&e=<?php echo $registro[3] ?>"><?php echo $registro[2]; ?></a></td>                                
									<td align="center"><input type="checkbox" name="<?php echo $registro[1]."_".$registro[3];  ?>" /></td>
								</tr>
							<?php
						}
						if(!$bandera)
						{
							?>
							<tr><td colspan="4">No hay Registros</td></tr>
							<?php
						}
					}
					else
					{
						?>
							<tr><td colspan="10">Ultilice el bot&oacute;n <b>"Filtro"</b> para hacer una b&uacute;squeda de registros</td></tr>
						<?php
					}
				?>
				<tr><td colspan="4"  height="3px" class="separador"></td></tr>
			</table>
			</form>
		</td>
	</tr>
</table>