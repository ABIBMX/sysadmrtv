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
			document.datagrid.action = "index.php?menu=11&accion=editar"
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
	
	var contenedor_empleado = ""; //Se actualiza para saber en que input se coloca la llave del cliente
	var contenedor_cliente = ""; //Se actualiza para saber en que input se coloca la llave del cliente
	var parametro_sucursal_empleado = "";// Se utiliza en caso de que queramos la lista de clientes de una sucursal en especifica
	var parametro_sucursal_cliente = "";// Se utiliza en caso de que queramos la lista de clientes de una sucursal en especifica
	function cambio_id_empleado(id){
		
		}
		
	function cambio_id_cliente(id){	
		
	}
		
	function cambia(valor){
	if(valor=="null"){
		document.getElementById('id_empleado').readOnly=true;
		document.getElementById('id_empleado').value="";
		document.getElementById('imag').style.display="none";
		document.getElementById('nom').style.display="none";
	}else{
		document.getElementById('id_empleado').readOnly=false;
		document.getElementById('id_empleado').value="";
		document.getElementById('imag').style.display="block";
		document.getElementById('nom').style.display="block";
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
                <td width="70px" background="imagenes/module_center.png" height="80"  valign="middle"><img src="imagenes/egresos.png" /></td>
                <td align="left" background="imagenes/module_center.png" height="80" valign="middle" class="titulo"><b>&nbsp;EGRESOS</b></td>
                <td align="right" background="imagenes/module_center.png" height="80" >
                <button class="boton2" onclick="createWindow('Filtro',450,310 ,8,false,true);" ><img src="imagenes/filter.png" /><br/>Filtro</button>
                    <button class="boton2" onclick="location.href='index.php?menu=11&accion=agregar'" ><img src="imagenes/agregar.png" /><br/>Agregar</button>
			<button class="boton2" onclick="editar()"><img src="imagenes/editar.png" /><br />Ver</button>
			<button class="boton2" onclick="eliminar()"><img src="imagenes/eliminar.png" /><br />Cancelar</button>
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
					
					//$query = "update egresos set id_tipo_egreso='".addslashes(strtoupper($_POST['t_egreso']))."',id_empleado_autorizo='".addslashes(strtoupper($_POST['autorizo']))."',id_empleado='".addslashes(strtoupper($_POST['autorizado']))."',monto='".addslashes(strtoupper($_POST['monto']))."',fecha='".addslashes(strtoupper($_POST['fecha']))."',referencia='".addslashes(strtoupper($_POST['r_comprobante']))."',id_comprobante='".addslashes(strtoupper($_POST['comprobante']))."' where id_egreso='".addslashes($_POST['id'])."'";
					
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
					
					if(isset($_POST['id_cliente'])&&$_POST['id_cliente']!="")
						$_POST['id_cliente'] = "'".addslashes(strtoupper($_POST['id_cliente']))."'";
					else
						$_POST['id_cliente']="null";
					
					 $query = "insert into egresos (id_egreso,id_tipo_egreso , id_empleado, monto, fecha,referencia, id_comprobante,id_estado_transaccion, id_cliente) values (0,'".addslashes(strtoupper($_POST['t_egreso']))."','".addslashes(strtoupper($_POST['autorizado']))."','".addslashes(strtoupper($_POST['monto']))."','".addslashes(strtoupper($_POST['fecha']))."','".addslashes(strtoupper($_POST['r_comprobante']))."','".addslashes(strtoupper($_POST['comprobante']))."','1',".$_POST['id_cliente'].")";
					if(mysqli_query($conexion,$query))
					{
						/* la variable es $_POST['monto'];  la que se debe de ver reflejado en la caja*/
						//$concepto_caja = devolverValorQuery("select descripcion from cat_tipo_egreso where id_tipo_egreso='".addslashes($_POST['t_egreso'])."'");
						
						//$sucursal = devolverValorQuery("select id_sucursal from empleados where id_empleado='".addslashes($_POST['autorizado'])."'");						
						//insertarCaja(addslashes($_POST['sucursal']),addslashes($_POST['monto']),2, 0,$concepto_caja[0],NULL,strtoupper($_POST['r_comprobante']));
						
						$concepto_caja = devolverValorQuery("select descripcion from cat_tipo_egreso where id_tipo_egreso='".addslashes($_POST['t_egreso'])."'");
						
						$sucursal = devolverValorQuery("select id_sucursal from empleados where id_empleado='".addslashes($_POST['autorizado'])."'");						
						insertarCaja(addslashes($_POST['sucursal']),addslashes($_POST['monto']),2, 0,$concepto_caja[0],NULL,strtoupper($_POST['r_comprobante']));
						
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
								//$query_eliminar = "DELETE FROM egresos WHERE id_egreso='".addslashes($variable)."'";
								$query_consulta = "select * from depositos where comision_id_egreso='".addslashes($variable)."' and id_estado_transaccion='1'";
								$res = mysqli_query($conexion,$query_consulta);
								$num = mysqli_num_rows($res);
								
								if($num ==0)
								$query_eliminar = "UPDATE egresos SET id_estado_transaccion='2' where id_egreso ='".addslashes($variable)."'";
								if(mysqli_query($conexion,$query_eliminar)){
									$bandera = true;
									/* tambien aqui se debe de ver reflejado no se como pero se esta cancelando  la que se debe de ver reflejado en la caja*/
									
								}else
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
                                        <td align="center" background="imagenes/message_center.png" height="30" valign="middle" class="fine">Los registros fueron cancelados.</td>
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
                                        <td align="center" background="imagenes/message_error_center.png" height="30" valign="middle" class="warning">Hubo un problema al eliminar los registros. (verifique que no se encuentra relacionado con un  deposito)</td>
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
				<tr><td colspan="7" height="3px" class="separador"></td></tr>
				<tr class="tabla_columns">
	                <td>Id Egreso</td>
                    <td>Tipo de Egreso</td>
                    <td>Empleado</td>
                    <td>Monto</td>
                    <td>Fecha</td>
                     <td>Estado</td>
					<td align="center" width="50px"><input type="checkbox" name="selector" onclick="seleccionar()" /><input type='hidden'name='accion'/></td>
				</tr>
				<?php
				
				
				if(addslashes($_POST['egre'])){
					
					$add_query="";
						if($_POST['suc']!="null")
						{
							$add_query .= " and id_empleado in (select id_empleado from empleados where id_sucursal='".addslashes($_POST['suc'])."') ";
						}
						
						if($_POST['desde']!=""&& $_POST['hasta']!="")
						{
							$add_query .= " and fecha between '".addslashes($_POST['desde'])."' and '".addslashes($_POST['hasta'])."' ";
						}
						
						if($_POST['emp']!="")
						{
							$add_query .= " and id_empleado='".addslashes($_POST['emp'])."' ";
						}
						
						if($_POST['edo']!="null")
						{
							$add_query .= " and id_estado_transaccion='".addslashes($_POST['edo'])."' ";
						}
						if($_POST['egre']!="null")
						{
							$add_query .= " and id_tipo_egreso='".addslashes($_POST['egre'])."' ";
						}
					
				
				
					$query = "select id_egreso,(select descripcion from cat_tipo_egreso where id_tipo_egreso=e.id_tipo_egreso),(select concat(nombre,' ',apellido_paterno,' ',apellido_materno) from empleados where id_empleado=e.id_empleado),monto,fecha,(select descripcion from estado_transaccion where id_estado_transaccion = e.id_estado_transaccion) from egresos e where id_estado_transaccion!='null' ".$add_query;
					$tabla = mysqli_query($conexion,$query);
					
					while(list($id, $egreso,$empleado,$monto,$fecha,$estado)=mysqli_fetch_array($tabla))
					{
						$bandera = true;
						?>
							<tr class="tabla_row">
	                            <td><a href="index.php?menu=11&accion=editar&id=<?php echo $id;  ?>"><?php echo $id; ?></a></td>
								<td><a href="index.php?menu=11&accion=editar&id=<?php echo $id;  ?>"><?php echo $egreso; ?></a></td>
                                <td><a href="index.php?menu=11&accion=editar&id=<?php echo $id;  ?>"><?php echo $empleado; ?></a></td>
                                <td><a href="index.php?menu=11&accion=editar&id=<?php echo $id;  ?>"><?php echo $monto; ?></a></td>
                                <td><a href="index.php?menu=11&accion=editar&id=<?php echo $id;  ?>"><?php echo $fecha; ?></a></td>
                                <td><a href="index.php?menu=11&accion=editar&id=<?php echo $id;  ?>"><?php echo $estado; ?></a></td>
								<td align="center"><input type="checkbox" name="<?php echo $id;  ?>" /></td>
							</tr>
						<?php
					}
					if(!$bandera)
					{
						?>
                        <tr><td colspan="7">No hay Registros</td></tr>
                        <?php
					}
				}else{
					
				?>
                <tr><td colspan=7>No se han encontrado registros...</td></tr>
                <?php 
				}
				?>
                
				<tr><td colspan="7" height="3px" class="separador"></td></tr>
			</table>
			</form>
		</td>
	</tr>
</table>