<script language="javascript" type="text/javascript">
	
	function consultar()
	{
		
		if(document.formulario.desde.value!="" && document.formulario.hasta.value!="")
		{
			document.formulario.submit();
		}
		else
		{
			alert("Debes seleccionar las fechas");
		}
		
	}
	function solo_numeros_decimales(texto)
	{		
		var expresion = /[0-9]*\.?[0-9]{0,2}/;
		texto.value = texto.value.match(expresion);
		
	}
	function imprimir_reporte_dia_pdf()
	{
		var aux_action = document.formulario.action;
		var aux_target = document.formulario.target;
		document.formulario.action = "reporte/caja_reporte_dia_pdf.php";
		document.formulario.target = "_blank";
		document.formulario.submit();
		document.formulario.action = aux_action;
		document.formulario.target = aux_target;
	}
	function imprimir_reporte_dia_excel()
	{
		var aux_action = document.formulario.action;
		var aux_target = document.formulario.target;
		document.formulario.action = "reporte/caja_reporte_dia_excel.php";
		document.formulario.target = "_blank";
		document.formulario.submit();
		document.formulario.action = aux_action;
		document.formulario.target = aux_target;		
		
	}
	function imprimir_pdf()
	{
		
			if(document.formulario.desde.value!="" && document.formulario.hasta.value!="")
			{
				var aux_action = document.formulario.action;
				var aux_target = document.formulario.target;
				document.formulario.action = "reporte/caja_admin_pdf.php";
				document.formulario.target = "_blank";
				document.formulario.submit();
				document.formulario.action = aux_action;
				document.formulario.target = aux_target;
			}
			else
			{
				alert("Debes seleccionar las fechas");
			}
	}
	function imprimir_excel()
	{
		
			if(document.formulario.desde.value!="" && document.formulario.hasta.value!="")
			{
				var aux_action = document.formulario.action;
				var aux_target = document.formulario.target;
				document.formulario.action = "reporte/caja_admin_excel.php";
				document.formulario.target = "_blank";
				document.formulario.submit();
				document.formulario.action = aux_action;
				document.formulario.target = aux_target;
			}
			else
			{
				alert("Debes seleccionar las fechas");
			}
	}
</script>
<table border="0px"  width="100%" style="color:#000000;font-size:12px">
	<tr>    
    	<td align="right">
        	<table border="0" width="100%" cellpadding="0" cellspacing="0" >
            	<tr>
            	<td width="5px" background="imagenes/module_left.png"></td>
                <td width="70px" background="imagenes/module_center.png" height="80"  valign="middle"><img src="imagenes/caja.png" /></td>
                <td align="left" background="imagenes/module_center.png" height="80" valign="middle" class="titulo"><b>&nbsp;&nbsp;CAJAS&nbsp;&nbsp;</b></td>
                <td align="right" background="imagenes/module_center.png" height="80" >
                	
                    <button class="boton2" onclick="consultar()"><img src="imagenes/habilitar.png" /><br />Consultar</button>
                    <button class="boton2" onclick="imprimir_reporte_dia_pdf()"><img src="imagenes/imprimir.png" /><br />R.D.PDF</button>
                    <button class="boton2" onclick="imprimir_reporte_dia_excel()"><img src="imagenes/imprimir.png" /><br />R.D.EXCEL</button>
                    <?php
						if(isset($_POST['filtro']))
						{
							?>
                            <button style="margin-left:30px;" class="boton2" onclick="imprimir_pdf()"><img src="imagenes/imprimir.png" /><br />F. PDF</button>
		                    <button class="boton2" onclick="imprimir_excel()"><img src="imagenes/imprimir.png" /><br />F. EXCEL</button>
                            <?php
						}
					?>
                    
                </td>
                <td width="5px" background="imagenes/module_right.png"></td>
                </tr>
            </table>
        </td>
	</tr>
    <tr>
		<td colspan="3">
			<table class="datagrid" width="100%" border="0" cellspacing="0">
				<tr><td  height="3px" colspan="7" class="separador"></td></tr>
				<tr class="tabla_columns">
					<td width="150px">Sucursal</td><td width="100px" align="right" >Ingresos del D&iacute;a</td><td width="100px" align="right" >Egresos del D&iacute;a</td><td width="100px" align="right" >Depositos del D&iacute;a</td><td width="100px" align="right" >Caja Anterior</td><th width="100px" align="right">Caja Actual</th><td>&nbsp;</td>
				</tr>
						<?php
							$tabla = mysqli_query($conexion,"select * from sucursales where id_sucursal='".$_SESSION['tuvision_id_sucursal']."'");
							while($registro=mysqli_fetch_array($tabla))
							{
								echo "<tr class=\"tabla_row\"><td>".$registro[1].": </td>";
								
								$query = "select  (select sum(cantidad) from cajas where id_sucursal=c.id_sucursal and id_tipo_operacion=1 and fecha_operacion=current_date()), (select sum(cantidad) from cajas where id_sucursal=c.id_sucursal and id_tipo_operacion=2 and fecha_operacion=current_date()),(select sum(cantidad) from cajas where id_sucursal=c.id_sucursal and id_tipo_operacion=3 and fecha_operacion=current_date()),c.caja_anterior, c.caja_actual from cajas c where c.id_sucursal='".addslashes($registro[0])."' order by fecha_operacion desc, id_caja desc limit 1";
								
								$caja = devolverValorQuery($query);
								
								if($caja[0]=="")
									$caja[0] = "0.00";
								if($caja[1]=="")
									$caja[1] = "0.00";
								if($caja[2]=="")
									$caja[2] = "0.00";
								
								if($caja[3]=="")
								{
									$caja[3]="0.00";$caja[4]="0.00";
								}									
								
								echo "<td align=\"right\">".$caja[0]."</td><td align=\"right\">".$caja[1]."</td><td align=\"right\">".$caja[2]."</td><td align=\"right\">".$caja[3]."</td><td align=\"right\"><b>".$caja[4]."</b></td><td>&nbsp;</td></tr>";
								
							}							
                        ?>
                       
				<tr><td  height="3px" colspan="7" class="separador"></td></tr>
			</table>
		</td>
	</tr>
    <tr><td height="10px"></td></tr>
    <tr>
    	<td colspan="3">
        	           
        	<table class="datagrid" width="100%" border="0" cellspacing="0">
				<tr><td  height="3px" class="separador"></td></tr>
				<tr class="tabla_columns">
					<td >Datos de la Busqueda</td>
				</tr>
				<tr>
					<td>
						<form name="formulario" method="post" onsubmit="return false;" action="index.php?menu=27">
                        <input type="hidden" name="filtro" />
						<table style="color:#000000" cellpadding="5">
                        	 <tr>
                            	<td>Tipo Operacion</td>
                                <td>
                                	<select name="tipo_operacion" style="width:300px; font-size:12px;">
                                    	<option value="-1">Todas</option>
										<?php
											$query_t_u = "select * from cat_tipo_operacion";
											$tabla_t_u = mysqli_query($conexion,$query_t_u);
											while($registro_t_u = mysqli_fetch_array($tabla_t_u))
											{
												if($_POST['tipo_operacion']==$registro_t_u[0])
													echo "<option value=\"$registro_t_u[0]\" selected=\"selected\">$registro_t_u[1]</option>";
												else
													echo "<option value=\"$registro_t_u[0]\">$registro_t_u[1]</option>";
											}
                                        ?>
                                    </select>
                                </td>
                            </tr>                     
                            <tr><td>Desde</td><td><input name="desde" id="desde"  style="width:90px;font-size:12px; background-image:url(calendario/imgs/icon_minicalendar.gif); background-position:right center; background-repeat:no-repeat;" type="text" maxlength="10" readonly="readonly" /></td></tr>
                            <tr><td>Hasta</td><td><input name="hasta" id="hasta"  style="width:90px;font-size:12px; background-image:url(calendario/imgs/icon_minicalendar.gif); background-position:right center; background-repeat:no-repeat;" type="text" maxlength="10" readonly="readonly" /></td></tr>                            <tr><td>Cantidad</td><td><input name="cantidad" id="cantidad" style="width:90px;font-size:12px;" onkeyup="solo_numeros_decimales(this)" onblur="solo_numeros_decimales(this)"  type="text" maxlength="12"/></td></tr>                                                                                      
						</table>
						</form>
					</td>
				</tr>
				<tr><td  height="3px" class="separador"></td></tr>
			</table>
        </td>
    </tr>
    <tr><td height="10px"></td></tr>

	<tr>
		<td colspan="3">        	
			<table class="datagrid" width="100%" border="0" cellspacing="0">
				<tr><td colspan="11" height="3px" class="separador"></td></tr>
				<tr class="tabla_columns">
                   <td>ID Operaci&oacute;n</td>
                    <td>Sucursal</td>
                    <td>Tipo Operacion</td>
                    <td>Cantidad</td>
                    <td>Concepto</td>
                    <td>ID Cliente</td>
                    <td>Referencia</td>
                    <td>Caja Anterior</td>
                    <td>Caja Actual</td>
                    <td>Fecha Operaci&oacute;n</td>
                    <td>Hora Operaci&oacute;n</td>
				</tr>
				<?php
					if(isset($_POST['filtro']))
					{
						if($_POST['cantidad']!="")
							$add_query = " and c.cantidad='".addslashes($_POST['cantidad'])."'";
						
						if($_POST['tipo_operacion']!="-1")
							$add_query = " and c.id_tipo_operacion='".addslashes($_POST['tipo_operacion'])."'";
					
						$query = "select c.id_caja, c.id_sucursal, cto.descripcion,c.cantidad, c.caja_anterior, c.caja_actual, c.fecha_operacion, c.hora_operacion,  c.concepto, c.id_cliente, c.referencia   from cajas c, cat_tipo_operacion cto where cto.id_tipo_operacion=c.id_tipo_operacion and c.id_sucursal='".$_SESSION['tuvision_id_sucursal']."' ".$add_query." and fecha_operacion BETWEEN '".addslashes($_POST['desde'])."' and '".addslashes($_POST['hasta'])."' order by c.fecha_operacion asc, c.id_caja asc";
					
						$_SESSION['filtro_caja'] = $query;
						
						$tabla = mysqli_query($conexion,$query);
						while($registro=mysqli_fetch_array($tabla))
						{
							$bandera = true;
							?>
								<tr class="tabla_row">
									<td><?php echo $registro[0]; ?></td>
                                    <td><?php echo $registro[1]; ?></td>
                                    <td><?php echo $registro[2]; ?></td>
                                    <td><?php echo $registro[3]; ?></td>
                                    <td><?php echo $registro[8]; ?></td>
                                    <td><?php echo $registro[9]; ?></td>
                                    <td><?php echo $registro[10]; ?></td>
                                    <td><?php echo $registro[4]; ?></td>
                                    <td><?php echo $registro[5]; ?></td>
                                    <td><?php echo $registro[6]; ?></td>
                                    <td><?php echo $registro[7]; ?></td>
								</tr>
							<?php
						}
						if(!$bandera)
						{
							?>
							<tr><td colspan="11">No hay Resultados</td></tr>
							<?php
						}
					}
					else
					{
						?>
                        <tr><td colspan="11">Para ver el historial de Cajas, seleccione una sucursal</td></tr>
                        <?php
					}
				?>
				<tr><td colspan="11"  height="3px" class="separador"></td></tr>
			</table>
		</td>
	</tr>
</table>
<script>
var cal1,
cal2,
mCal,
mDCal,
newStyleSheet;
var dateFrom = null;
var dateTo = null;
window.onload = function() {
	
    cal1 = new dhtmlxCalendarObject('desde');
	cal1.setSkin('dhx_skyblue');
	<?php
		if(isset($_POST['desde']))
		{
			?>
			cal1.setDate('<?php echo $_POST['desde']; ?>');
			<?php
		}
	?>
	
	cal2 = new dhtmlxCalendarObject('hasta');
	cal2.setSkin('dhx_skyblue');
	
	<?php
		if(isset($_POST['hasta']))
		{
			?>
			cal2.setDate('<?php echo $_POST['hasta']; ?>');
			<?php
		}
	?>
	
}
</script>
