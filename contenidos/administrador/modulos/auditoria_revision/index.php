<?php
header("Content-Type: text/html;charset=latin");
	?>

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
	function cambia(valor){
	if(valor=="null"){
		document.getElementById('id_cliente').readOnly=true;
		document.getElementById('id_cliente').value="";
		document.getElementById('imag').style.display="none";
		document.getElementById('nom').style.display="none";
	}else{
		document.getElementById('id_cliente').readOnly=false;
		document.getElementById('id_cliente').value="";
		document.getElementById('imag').style.display="block";
		document.getElementById('nom').style.display="block";
	}	
	}

	function reporte(){
		var checado="no";
		for(var j = 1; j<document.datagrid.elements.length; j++)
		{
			if(document.datagrid.elements[j].checked)
			{

				checado = "si";
			}
		}
		if(checado=="si"){
		var aux_action = document.datagrid.action;
		var aux_target = document.datagrid.target;
		document.datagrid.action = "reporte/reporte_auditoria_excel.php";
		document.datagrid.target = "_blank";
		document.datagrid.submit();
		document.datagrid.action = aux_action;
		document.datagrid.target = aux_target;
		/*var aux_action = document.datagrid.action;
		var aux_target = document.datagrid.target;
		document.datagrid.action = "reporte/reporte_taps.php";
		document.datagrid.target = "_blank";
		document.datagrid.submit();
		document.datagrid.action = aux_action;
		document.datagrid.target = aux_target;
		*/
		}else{
			alert("Seleccione al menos un TAP");
		}
		
	}

	function _Ajax(id,valor,valor2)
	{
		
		bandera_numeros = false;
		var div_numero = document.getElementById(id);
		if(valor!="null")
		{	
			
			//div_numero.innerHTML = "<img src='imagenes/loading.gif' /> <span style='font-size:10px;'>Cargando ...</span>";
			var cdata = "id="+id+"&valor1="+valor;

			$.ajax({
					type: "POST",
					url: "ajaxProcess/reporte_servicio.php",
					data: cdata,
					success: function(datos)
					{
						//alert(datos);
						div_numero.innerHTML = datos;	
						
					}
			});
		}else{
			div_numero.innerHTML ="";
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
                <td width="70px" background="imagenes/module_center.png" height="80"  valign="middle"><img src="imagenes/maps.png" /></td>
                <td align="left" background="imagenes/module_center.png" height="80" valign="middle" class="titulo"><b>&nbsp;&nbsp;Auditorias y Revisiones de Red&nbsp;&nbsp;</b></td>
                <td align="right" background="imagenes/module_center.png" height="80" >
                	 <button class="boton2" onclick="createWindow('Filtro',450,150 ,13,false,true);" ><img src="imagenes/filter.png" /><br/>Filtro</button>
                	 <button class="boton2" onclick="reporte()" ><img src="imagenes/imprimir.png" /><br/>Reporte</button>
                    
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
					
					$query = "update tap set id_sucursal='".addslashes(strtoupper($_POST['sucursal']))."', id_tap='".addslashes(strtoupper($_POST['id_tap']))."',calle='".addslashes(strtoupper($_POST['calle']))."',poste='".addslashes(strtoupper($_POST['poste']))."',tipoposte='".addslashes(strtoupper($_POST['tipoposte']))."',trayectoria='".addslashes(strtoupper($_POST['trayectoria']))."',fibracoaxial='".addslashes(strtoupper($_POST['fibracoaxial']))."',especificacioncable='".addslashes(strtoupper($_POST['especificacion']))."',delposte='".addslashes(strtoupper($_POST['delposte']))."',alposte='".addslashes(strtoupper($_POST['alposte']))."',distancia='".addslashes(strtoupper($_POST['distancia']))."',peso='".addslashes(strtoupper($_POST['peso']))."',latitud='".addslashes(strtoupper($_POST['latitud']))."',longitud='".addslashes(strtoupper($_POST['longitud']))."',pesofabrica='".addslashes(strtoupper($_POST['pesofabrica']))."'  where id_tap='".addslashes($_POST['id'])."'";
					
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
					
					$query = "insert into tap (id_tap,calle,poste,id_sucursal,tipoposte,trayectoria,fibracoaxial,especificacioncable,delposte,alposte,distancia,peso,latitud,longitud,pesofabrica) values ('".addslashes(strtoupper($_POST['id_tap']))."','".addslashes(strtoupper($_POST['calle']))."','".addslashes(strtoupper($_POST['poste']))."','".addslashes(strtoupper($_POST['sucursal']))."','".addslashes(strtoupper($_POST['tipoposte']))."','".addslashes(strtoupper($_POST['trayectoria']))."','".addslashes(strtoupper($_POST['fibracoaxial']))."','".addslashes(strtoupper($_POST['especificacion']))."','".addslashes(strtoupper($_POST['delposte']))."','".addslashes(strtoupper($_POST['alposte']))."','".addslashes(strtoupper($_POST['distancia']))."','".addslashes(strtoupper($_POST['peso']))."','".addslashes(strtoupper($_POST['latitud']))."','".addslashes(strtoupper($_POST['longitud']))."','".addslashes(strtoupper($_POST['pesofabrica']))."')";
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
				<tr><td colspan="22" height="3px" class="separador"></td></tr>
				<tr class="tabla_columns">
                    <td>ID TAP</td>
                    <td>Sucursal</td>
                    <td>Fecha</td>
                    <td>DB Canal bajo</td>
                    <td>DB Canal alto</td>
                    <td>DB Canal bajo Terminal</td>
                    <td>DB Canal alto Terminal</td>
                    <td>Varilla</td>
                    <td>Conector</td>
                    <td>Cable tierra</td>
                    <td>Poste</td>
                    <td>Edo. Poste</td>
                    <td>Loop</td>
                    <td>Tendido</td>
                    <td>Protectores</td>
                    <td>Cinta</td>
                    <td>CMT</td>
                    <td>Tensado</td>
                    <td>Hilado</td>
                    <td>Altura</td>
                    <td>Libre de rama</td>
                    
					<td align="center" width="50px"><input type="checkbox" name="selector" onclick="seleccionar()" /><input type='hidden'name='accion'/></td>
				</tr>
				<?php
						$add="";
						
					if(isset($_POST['id_suc'])&&$_POST['id_suc']!="null" && $_POST['id_suc']!=""){
						
						$add=" and t.id_sucursal='".$_POST['id_suc']."'";
					}
					if(isset($_POST['id_tap'])&&$_POST['id_tap']!="null" && $_POST['id_tap']!=""){
						
						$add=$add." and t.id_tap='".$_POST['id_tap']."'";
					}


					$query = "select a.id,a.id_tap,t.id_sucursal,a.fechaRegistro,a.niveldbBajo,a.niveldbAlto,a.tapdbCanalBajo,a.tapdbCanalAlto,a.varillaTierra,a.conectorTierra,a.cableTierra,r.poste,r.estadoPoste,r.loop,r.tendido,r.protectores,r.cinta,r.cmt,r.tensado,r.hilado,r.altura,r.libreRamas from auditoria a, tap t,revision_red r 
where a.id_tap=t.id_tap and a.id_tap=r.id_tap and a.fechaRegistro=r.fechaRegistro and t.id_tap=r.id_tap and a.id=r.id ".$add." order by a.fechaRegistro desc";
					$tabla = mysqli_query($conexion,$query);
					while($registro=mysqli_fetch_array($tabla))
					{
						$bandera = true;
						?>
							<tr class="tabla_row">
								<td><a href="index.php?menu=20&accion=editar&id=<?php echo $registro[0];  ?>"><?php echo $registro[1]; ?></a></td>
                                <td><?php echo $registro[2]; ?></td>
                                <td><?php echo $registro[3]; ?></td>
                                <td><?php echo $registro[4]; ?></td>
                                <td><?php echo $registro[5]; ?></td>
                                <td><?php echo $registro[6]; ?></td>
                                <td><?php echo $registro[7]; ?></td>
                                <td><?php echo $registro[8]; ?></td>
                                <td><?php echo $registro[9]; ?></td>
                                <td><?php echo $registro[10]; ?></td>
                                <td><?php echo $registro[11]; ?></td>
                                <td><?php echo $registro[12]; ?></td>
                                <td><?php echo $registro[13]; ?></td>
                                <td><?php echo $registro[14]; ?></td>
                                <td><?php echo $registro[15]; ?></td>
                                <td><?php echo $registro[16]; ?></td>
                                <td><?php echo $registro[17]; ?></td>
                                <td><?php echo $registro[18]; ?></td>
                                <td><?php echo $registro[19]; ?></td>
                                <td><?php echo $registro[20]; ?></td>
                                <td><?php echo $registro[21]; ?></td>
								<td align="center"><input type="checkbox" name="select[<?php echo $registro[0];  ?>]" /></td>
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
				<tr><td colspan="22"  height="3px" class="separador"></td></tr>
			</table>
			</form>
		</td>
	</tr>
</table>