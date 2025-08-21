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
			document.datagrid.action = "index.php?menu=36&accion=editar"
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

<div style="display:none" id="filtro_div"></div>
<table border="0px"  width="100%" style="color:#000000;font-size:12px">
	<tr>    
    	<td align="right">
        	<table border="0" width="100%" cellpadding="0" cellspacing="0" >
            	<tr>
            	<td width="5px" background="imagenes/module_left.png"></td>
                <td width="70px" background="imagenes/module_center.png" height="80"  valign="middle"><img src="imagenes/proveedor.png" /></td>
                <td align="left" background="imagenes/module_center.png" height="80" valign="middle" class="titulo"><b>&nbsp;&nbsp;CATALOGO DE CANALES</b></td>
                <td align="right" background="imagenes/module_center.png" height="80" >
                <!-- <button class="boton2" onclick="createWindow('Filtro',400,160 ,12,false,true);" ><img src="imagenes/filter.png" /><br/>Filtro</button> -->
                 <button class="boton2" onclick="location.href='index.php?menu=36&accion=agregar'" ><img src="imagenes/agregar.png" /><br/>Agregar</button>
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
					$id = filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT);
					$proveedor = filter_input(INPUT_POST,'proveedor',FILTER_SANITIZE_NUMBER_INT);
					$query = "update f_canales set id_proveedor = ".$proveedor." , nombre = '".addslashes(strtoupper($_POST['nombre']))."', estado = '".addslashes(strtoupper($_POST['estado']))."' where id_canal = ".$id;
					
					
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
					

					$proveedor = filter_input(INPUT_POST,'proveedor',FILTER_SANITIZE_NUMBER_INT);
					
					$query = "insert into f_canales (id_canal,id_proveedor,nombre,estado) values (0,".$proveedor.",'".addslashes(strtoupper($_POST['nombre']))."','".addslashes(strtoupper($_POST['estado']))."')";
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
								$query_eliminar = "DELETE FROM f_canales WHERE id_canal='".addslashes($variable)."'";
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
				<tr><td colspan="6" height="3px" class="separador"></td></tr>
				<tr class="tabla_columns">
	                <td>ID</td>
                    <td>Nombre</td>
                    <td>Proveedor</td>
					<td>Estado</td>
					<td align="center" width="50px"><input type="checkbox" name="selector" onclick="seleccionar()" /><input type='hidden'name='accion'/></td>
				</tr>
				<?php
								
					if(!isset($_POST['filtro_nombre'])){
						
						// if($_POST['filtro_nombre']!="")
						// {
						// 	$_POST['filtro_nombre'] = filter_input(INPUT_POST, 'filtro_nombre', FILTER_SANITIZE_MAGIC_QUOTES);
						// 	$add_query .= " and c.nombre like'%".$_POST['filtro_nombre']."%' ";
						// }

						// if($_POST['filtro_proveedor']!="-1")
						// {
						// 	$_POST['filtro_proveedor'] = filter_input(INPUT_POST,'filtro_proveedor',FILTER_SANITIZE_NUMBER_INT);
						// 	$add_query .= " and c.id_proveedor = ".$_POST['filtro_proveedor'];
						// }
							
							
						$query = "select c.id_canal, c.nombre,p.nombre, c.estado from f_canales as c INNER JOIN f_cat_proveedor  as p where c.id_proveedor = p.id_proveedor  order by case when c.estado = 'Activo' then 1 else 2 end , c.nombre asc";
						$tabla = mysqli_query($conexion,$query);
						while(list($id,$nombre,$proveedor,$estado)=mysqli_fetch_array($tabla))
						{
							$bandera = true;
							?>
								<tr class="tabla_row">
		                            <td><a href="index.php?menu=36&accion=editar&id=<?php echo $id;  ?>"><?php echo $id; ?></a></td>
									<td><a href="index.php?menu=36&accion=editar&id=<?php echo $id;  ?>"><?php echo $nombre; ?></a></td>
									<td><a href="index.php?menu=36&accion=editar&id=<?php echo $id;  ?>"><?php echo $proveedor; ?></a></td>
									<td><a href="index.php?menu=36&accion=editar&id=<?php echo $id;  ?>"><?php echo $estado; ?></a></td>
									<td align="center"><input type="checkbox" name="<?php echo $id;  ?>" /></td>
								</tr>
							<?php
						}
						if(!$bandera)
						{
							?>
	                        <tr><td colspan="6">No hay Registros</td></tr>
	                        <?php
						}
					}else{
						?>
	                        <tr><td colspan="6">Aplique un Filtro para ver los Registros</td></tr>
	                    <?php
					}
				
				?>
				
				<tr><td colspan="6" height="3px" class="separador"></td></tr>
			</table>
			</form>
		</td>
	</tr>
</table>