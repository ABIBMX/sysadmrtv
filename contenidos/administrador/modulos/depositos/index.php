

<script language="javascript" type="text/javascript">

function solo_numeros_decimales(texto)
	{
		var expresion = /[0-9]*\.?[0-9]{0,2}/;
		texto.value = texto.value.match(expresion);
	}

var contenedor_empleado = ""; //Se actualiza para saber en que input se coloca la llave del cliente
	var contenedor_cliente = ""; //Se actualiza para saber en que input se coloca la llave del cliente
	var parametro_sucursal_empleado = "";// Se utiliza en caso de que queramos la lista de clientes de una sucursal en especifica
	var parametro_sucursal_cliente = "";// Se utiliza en caso de que queramos la lista de clientes de una sucursal en especifica
	function cambio_id_empleado(id){
		
		}
		
	function cambio_id_cliente(id){	
		
	}

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
			document.datagrid.action = "index.php?menu=16&accion=editar";
			document.datagrid.target="";
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
			if(window.confirm("Est\u00e1s seguro de ELIMINAR los registros seleccionados?"));
				document.datagrid.target="";
				document.datagrid.submit();
		}
		else
		{
			window.alert("No ha seleccionado ningun registro");
		}
	}
	
	function imprimir_pdf()
	{		
		var aux_action = document.datagrid.action;
		var aux_target = document.datagrid.target;
		document.datagrid.action = "reporte/deposito_pdf.php";
		document.datagrid.target = "_blank";
		document.datagrid.submit();
		document.datagrid.action = aux_action;
		document.datagrid.target = aux_target;
			
	}
	function imprimir_excel()
	{
		var aux_action = document.datagrid.action;
		var aux_target = document.datagrid.target;
		document.datagrid.action = "reporte/deposito_excel.php";
		document.datagrid.target = "_blank";
		document.datagrid.submit();
		document.datagrid.action = aux_action;
		document.datagrid.target = aux_target;
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

<?php

?>
<table border="0px"  width="100%" style="color:#000000;font-size:12px">
	<tr>    
    	<td align="right">
        	<table border="0" width="100%" cellpadding="0" cellspacing="0" >
            	<tr>
            	<td width="5px" background="imagenes/module_left.png"></td>
                <td width="70px" background="imagenes/module_center.png" height="80"  valign="middle"><img src="imagenes/depositos.png" /></td>
                <td align="left" background="imagenes/module_center.png" height="80" valign="middle" class="titulo"><b>&nbsp;DEPOSITOS</b></td>
                <td align="right" background="imagenes/module_center.png" height="80" >
                <button class="boton2" onclick="createWindow('Filtro',450,310 ,4,false,true);" ><img src="imagenes/filter.png" /><br/>Filtro</button>
                <?php
                if(isset($_POST['banco'])){
					?>
				    <button class="boton2" onclick="imprimir_pdf()" ><img src="imagenes/imprimir.png" /><br/>PDF</button>
                    <button class="boton2" onclick="imprimir_excel()" ><img src="imagenes/imprimir.png" /><br/>EXCEL</button>
                    <?php
				}
				?>
                    <button class="boton2" onclick="location.href='index.php?menu=16&accion=agregar'" ><img src="imagenes/agregar.png" /><br/>Agregar</button>
			<button class="boton2" onclick="editar()"><img src="imagenes/editar.png" /><br />Ver</button>
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
					
					//$query = "update depositos set id_banco='".addslashes(strtoupper($_POST['banco']))."',monto='".addslashes(strtoupper($_POST['monto']))."',fecha='".addslashes(strtoupper($_POST['fecha']))."'  where id_deposito='".addslashes($_POST['id'])."'";
					
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
					$candado = true;	
					$id=0;
					
					mysqli_query($conexion,"start transaction");
					if(addslashes($_POST['comision'])==1){
						 $egreso = "insert into  egresos (id_egreso,id_tipo_egreso,id_empleado,id_estado_transaccion,id_comprobante,monto,fecha,referencia) 
							values (0,'".addslashes($_POST['t_egreso'])."'
									,'".addslashes($_POST['autorizo'])."'
									,'1'
									,'".addslashes($_POST['comprobante'])."'
									,'".addslashes($_POST['monto'])."'
									,'".addslashes($_POST['fecha'])."'
									,'".addslashes($_POST['r_comprobante'])."')";
							
							if(mysqli_query($conexion,$egreso)){
								$id=mysqli_insert_id($conexion);	
								$candado=true;
								/* la variable es $_POST['monto'];  la que se debe de ver reflejado en la caja*/
								
								$concepto_caja = devolverValorQuery("select descripcion from cat_tipo_egreso where id_tipo_egreso='".addslashes($_POST['t_egreso'])."'");
								
								$sucursal = devolverValorQuery("select id_sucursal from empleados where id_empleado='".addslashes($_POST['autorizo'])."'");						
								insertarCaja($sucursal[0],addslashes($_POST['monto']),2, 0,$concepto_caja[0],NULL,strtoupper($_POST['r_comprobante']));
								
							}else{
								mysqli_query($conexion,"rollback");	
								$candado=false;
							}
							
					}
					
					if($candado==true){
						if($id==0)
							$id='NULL';
					$query = "insert into depositos (id_deposito,id_banco , id_empleado_deposita, id_estado_transaccion, monto, fecha, referencia,comision_id_egreso) values (0,'".addslashes(strtoupper($_POST['banco']))."',
														'".addslashes(strtoupper($_POST['autorizo_dep']))."','1',
														'".addslashes(strtoupper($_POST['monto_dep']))."',
														'".addslashes(strtoupper($_POST['fechas']))."',
														'".addslashes(strtoupper($_POST['id_ref_dep']))."',
														$id)";
					}
						
					if(mysqli_query($conexion,$query))
					{
						mysqli_query($conexion,"commit");	
						$concepto_caja = devolverValorQuery("select descripcion from cat_bancos where id_banco='".addslashes($_POST['banco'])."'");
						
						$sucursal = devolverValorQuery("select id_sucursal from empleados where id_empleado='".addslashes($_POST['autorizo_dep'])."'");						
						insertarCaja($sucursal[0],addslashes($_POST['monto_dep']),3, 0,$concepto_caja[0],NULL,strtoupper($_POST['id_ref_dep']));
						
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
						mysqli_query($conexion,"rollback");	
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
								
								mysqli_query($conexion,"start transaction");
								
								$query_cancelar = "UPDATE depositos set id_estado_transaccion='2' WHERE id_deposito='".addslashes($variable)."'";
								if(mysqli_query($conexion,$query_cancelar)){
									$bandera = true;
									$query_cancelar2 = "UPDATE egresos set id_estado_transaccion='2' where id_egreso=(select comision_id_egreso from depositos where id_deposito='".addslashes($variable)."')";
									if(mysqli_query($conexion,$query_cancelar2)){
										/* tambien aqui se debe de ver reflejado no se como pero se esta cancelando  la que se debe de ver reflejado en la caja*/
									}else{
										$bandera=false;	
										mysqli_query($conexion,"rollback");
									}
								}else{
									$bandera=false;							
									mysqli_query($conexion,"rollback");
								}
							} 
						}
					}
					if($bandera)
					{
						mysqli_query($conexion,"commit");
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
				<tr><td colspan="7" height="3px" class="separador"></td></tr>
				<tr class="tabla_columns">
	                <td>ID</td>	
                    <td>Banco</td>
                    <td>Empleado que Deposit&oacute;</td>
                    <!--<td>Empleado Autorizado</td>-->
                    <td>Monto</td>
                    <td>Fecha</td>
					<td align="center" width="50px"><input type="checkbox" name="selector" onclick="seleccionar()" /><input type='hidden'name='accion'/></td>
				</tr>
				<?php
					if(isset($_POST['banco'])){
						
						$add_query="";
						if($_POST['sucursal']!="")
						{
							$add_query .= " and id_empleado_deposita in (select id_empleado from empleados where id_sucursal='".addslashes($_POST['sucursal'])."') ";
						}
						
						if($_POST['id_empleado']!="")
						{
							$add_query .= " and id_empleado_deposita='".addslashes($_POST['id_empleado'])."' ";
						}
						
						if($_POST['desde']!=""&& $_POST['hasta']!="")
						{
							$add_query .= " and fecha between '".addslashes($_POST['desde'])."' and '".addslashes($_POST['hasta'])."' ";
						}
						
						if($_POST['monto']!="")
						{
							$add_query .= " and monto='".addslashes($_POST['monto'])."' ";
						}
						
						if($_POST['banco']!="null")
						{
							$add_query .= " and id_banco='".addslashes($_POST['banco'])."' ";
						}
						
												
						
						$query = "select id_deposito,
						(select descripcion from cat_bancos where id_banco=d.id_banco),
						(select concat(nombre,' ',apellido_paterno,' ',apellido_materno) from empleados where id_empleado=d.id_empleado_deposita),
						monto,
						fecha from depositos d where d.id_estado_transaccion!='null' ".$add_query;
						
						$_SESSION['filtro_deposito'] = $query;
						$tabla = mysqli_query($conexion,$query);
						while(list($id, $banco,$deposita,$monto,$fecha)=mysqli_fetch_array($tabla))
						{
							$bandera = true;
							?>
								<tr class="tabla_row">
									<td><a href="index.php?menu=16&accion=editar&id=<?php echo $id;  ?>"><?php echo $id; ?></a></td>
									<td><a href="index.php?menu=16&accion=editar&id=<?php echo $id;  ?>"><?php echo $banco; ?></a></td>
									<td><a href="index.php?menu=16&accion=editar&id=<?php echo $id;  ?>"><?php echo $deposita; ?></a></td>
									<td><a href="index.php?menu=16&accion=editar&id=<?php echo $id;  ?>"><?php echo $monto; ?></a></td>
									<td><a href="index.php?menu=16&accion=editar&id=<?php echo $id;  ?>"><?php echo $fecha; ?></a></td>
									
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
							<tr><td colspan="7">No hay Registros</td></tr>
							<?php
						}
					
					
				?>
				<tr><td colspan="7" height="3px" class="separador"></td></tr>
			</table>
			</form>
		</td>
	</tr>
</table>

