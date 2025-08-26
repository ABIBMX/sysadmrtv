<script language="javascript" type="text/javascript">
	
	function consultar()
	{
		var cadena="";
		if((document.formulario.desde_contrato.value=="" && document.formulario.hasta_contrato.value!="")|| (document.formulario.desde_contrato.value!="" && document.formulario.hasta_contrato.value==""))
			cadena += "\n - Fechas de contrato";
		
		if((document.formulario.desde_activacion.value=="" && document.formulario.hasta_activacion.value!="")|| (document.formulario.desde_activacion.value!="" && document.formulario.hasta_activacion.value==""))
			cadena += "\n - Fechas de activaci\u00f3n";
		
		if(cadena=="")
		{
			document.formulario.submit();
		}
		else
		{
			alert("Verifica lo siguiente:"+cadena);
		}
		
	}
	function imprimir_pdf()
	{
		var aux_action = document.formulario.action;
		var aux_target = document.formulario.target;
		document.formulario.action = "reporte/general_clientes_pdf.php";
		document.formulario.target = "_blank";
		document.formulario.submit();
		document.formulario.action = aux_action;
		document.formulario.target = aux_target;
	}
	function imprimir_excel()
	{
		var aux_action = document.formulario.action;
		var aux_target = document.formulario.target;
		document.formulario.action = "reporte/general_clientes_excel.php";
		document.formulario.target = "_blank";
		document.formulario.submit();
		document.formulario.action = aux_action;
		document.formulario.target = aux_target;		
		
	}
	function resetearCampo(id)
	{
		document.getElementById(id).value= "";
	}
</script>
<table border="0px"  width="100%" style="color:#000000;font-size:12px">
	<tr>    
    	<td align="right">
        	<table border="0" width="100%" cellpadding="0" cellspacing="0" >
            	<tr>
            	<td width="5px" background="imagenes/module_left.png"></td>
                <td width="70px" background="imagenes/module_center.png" height="80"  valign="middle"><img src="imagenes/usuarios.png" /></td>
                <td align="left" background="imagenes/module_center.png" height="80" valign="middle" class="titulo"><b>&nbsp;&nbsp;REPORTE GENERAL DE CLIENTES&nbsp;&nbsp;</b></td>
                <td align="right" background="imagenes/module_center.png" height="80" >
                	
                    <button class="boton2" onclick="consultar()"><img src="imagenes/habilitar.png" /><br />Consultar</button>
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
				<tr><td  height="3px" class="separador"></td></tr>
				<tr class="tabla_columns">
					<td >Datos de la Busqueda</td>
				</tr>
				<tr>
					<td>
						<form name="formulario" method="post" onsubmit="return false;" action="index.php?menu=29">
                        <input type="hidden" name="filtro" />
						<table style="color:#000000" cellpadding="5">
                        	<tr>
                            	<td>Sucursal</td>
                                <td>
                                	<select name="sucursal" style="width:300px; font-size:12px;">
                                    	<option value="-1">Todas</option>
										<?php
											$query_t_u = "select * from sucursales order by id_sucursal asc";
											$tabla_t_u = mysqli_query($conexion,$query_t_u);
											while($registro_t_u = mysqli_fetch_array($tabla_t_u))
											{
												if($_POST['sucursal']==$registro_t_u[0])
													echo "<option value=\"$registro_t_u[0]\" selected=\"selected\">$registro_t_u[0] - $registro_t_u[1]</option>";
												else
													echo "<option value=\"$registro_t_u[0]\">$registro_t_u[0] - $registro_t_u[1]</option>";
											}
                                        ?>
                                    </select>
                                </td>
                            </tr> 
                            <tr><td colspan="2" style="border-top:1px solid #CCC;"><b>Fecha Contrato</b> <input type="button" onclick="resetearCampo('desde_contrato');resetearCampo('hasta_contrato');" value="Resetear" /></td></tr>                         
                            <tr><td>Desde</td><td><input name="desde_contrato" id="desde_contrato"  style="width:90px;font-size:12px; background-image:url(calendario/imgs/icon_minicalendar.gif); background-position:right center; background-repeat:no-repeat;" type="text" maxlength="10" readonly="readonly" /></td></tr>
                            <tr><td>Hasta</td><td><input name="hasta_contrato" id="hasta_contrato"  style="width:90px;font-size:12px; background-image:url(calendario/imgs/icon_minicalendar.gif); background-position:right center; background-repeat:no-repeat;" type="text" maxlength="10" readonly="readonly" /></td></tr>
                           <tr><td colspan="2" style="border-top:1px solid #CCC;"><b>Fecha Activacion</b> <input type="button" onclick="resetearCampo('desde_activacion');resetearCampo('hasta_activacion');" value="Resetear" /></td></tr>                         
                            <tr><td>Desde</td><td><input name="desde_activacion" id="desde_activacion"  style="width:90px;font-size:12px; background-image:url(calendario/imgs/icon_minicalendar.gif); background-position:right center; background-repeat:no-repeat;" type="text" maxlength="10" readonly="readonly" /></td></tr>
                            <tr><td>Hasta</td><td><input name="hasta_activacion" id="hasta_activacion"  style="width:90px;font-size:12px; background-image:url(calendario/imgs/icon_minicalendar.gif); background-position:right center; background-repeat:no-repeat;" type="text" maxlength="10" readonly="readonly" /></td></tr>                           
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
				<tr><td colspan="5" height="3px" class="separador"></td></tr>
				<tr class="tabla_columns">
                    <td>Sucursal</td>
                    <td>Activos</td>
					<td>Activos con TV</td>
					<td>Activos con TV + INTERNET</td>
					<td>Activos con INTERNET</td>
                    <td>Cancelados</td>
                    <td>Pendientes de Instalar</td>
                    <td>Total</td>
				</tr>
				<?php
					if(isset($_POST['filtro']))
					{		
						$fechas = 0;
						unset($_SESSION['general_desde_contrato']);
						unset($_SESSION['general_hasta_contrato']);
						unset($_SESSION['general_desde_activacion']);
						unset($_SESSION['general_hasta_activacion']);
						
						if($_POST['desde_contrato']!=""&&$_POST['hasta_contrato']!="")
						{
							$fechas++;
							$add_contrato = " c.fecha_contrato between '".addslashes($_POST['desde_contrato'])."' and '".addslashes($_POST['hasta_contrato'])."' ";
							
							$_SESSION['general_desde_contrato']= addslashes($_POST['desde_contrato']);
							$_SESSION['general_hasta_contrato']= addslashes($_POST['hasta_contrato']);
						}
						if($_POST['desde_activacion']!=""&&$_POST['hasta_activacion']!="")
						{
							$fechas++;
							$add_activacion = " c.fecha_activacion between '".addslashes($_POST['desde_activacion'])."' and '".addslashes($_POST['hasta_activacion'])."' ";
							$_SESSION['general_desde_activacion']= addslashes($_POST['desde_activacion']);
							$_SESSION['general_hasta_activacion']= addslashes($_POST['hasta_activacion']);
						}
						
						switch($fechas)
						{
							case 1:
									$add_fecha = " and ".$add_contrato.$add_activacion;
									break;
							case 2: $add_fecha = " and ((".$add_contrato.") and (".$add_activacion."))";
									break;
						}
						
						if($_POST['sucursal']!="-1")
							$add_sucursal = "  where s.id_sucursal='".addslashes($_POST['sucursal'])."'";
					
						$query = "select distinct s.nombre,
		(select count(id_cliente) from clientes c, tipo_status_cliente t1 where t1.id_status=1 and  c.id_tipo_status=t1.id_tipo_status and c.id_sucursal=s.id_sucursal ".$add_fecha.") as activos, 
		(select count(id_cliente) from clientes c, tipo_status_cliente t1 where t1.id_status=1 and  c.id_tipo_status=t1.id_tipo_status and c.tipo_contratacion = 'SERVICIO TV' and c.id_sucursal=s.id_sucursal ".$add_fecha.") as activos_TV,
		(select count(id_cliente) from clientes c, tipo_status_cliente t1 where t1.id_status=1 and  c.id_tipo_status=t1.id_tipo_status and c.tipo_contratacion = 'SERVICIO TV + INTERNET' and c.id_sucursal=s.id_sucursal ".$add_fecha.") as activos_TV_Internet, 
		(select count(id_cliente) from clientes c, tipo_status_cliente t1 where t1.id_status=1 and  c.id_tipo_status=t1.id_tipo_status and c.tipo_contratacion in ('INSTALACION SOLO INTERNET', 'CAMBIO DE TV + INTERNET POR INTERNET') and c.id_sucursal=s.id_sucursal ".$add_fecha.") as activos_Internet,  
		(select count(id_cliente) from clientes c, tipo_status_cliente t1 where t1.id_status=2 and  c.id_tipo_status=t1.id_tipo_status and c.id_sucursal=s.id_sucursal ".$add_fecha.") as cancelados,
		(select count(id_cliente) from clientes c, tipo_status_cliente t1 where t1.id_status=3 and  c.id_tipo_status=t1.id_tipo_status and c.id_sucursal=s.id_sucursal ".$add_fecha.") as pendientes  
	from sucursales s".$add_sucursal;
						
						$_SESSION['tuvision_general_clientes'] = $query;
						
						$tabla = mysqli_query($conexion,$query);
						
						$total_activos = 0;
						$total_activos_TV = 0;
						$total_activos_TV_Internet = 0;
						$total_activos_Internet = 0;
						$total_cancelados = 0;
						$total_pendientes = 0;
						$total_total = 0;
						while($registro=mysqli_fetch_array($tabla))
						{
							$bandera = true;
							$total_activos += $registro[1];
							$total_activos_TV += $registro[2];
							$total_activos_TV_Internet += $registro[3];
							$total_activos_Internet += $registro[4];
							$total_cancelados += $registro[5];
							$total_pendientes += $registro[6];

							$total = $registro[1] + $registro[5] + $registro[6];
							$total_total += $total;
							?>
								<tr class="tabla_row">
									<td><?php echo $registro[0]; ?></td>
									<td><?php echo $registro[1]; ?></td>
									<td><?php echo $registro[2]; ?></td>
									<td><?php echo $registro[3]; ?></td>
									<td><?php echo $registro[4]; ?></td>
									<td><?php echo $registro[5]; ?></td>
									<td><?php echo $registro[6]; ?></td>
                                    <td><?php echo $total; ?></td>
								</tr>
							<?php
						}
						if(!$bandera)
						{
							?>
							<tr><td colspan="5">No hay Resultados</td></tr>
							<?php
						}
						else
						{
							?>
								<tr class="tabla_row">
									<td><b>TOTALES</b></td>
									<td><b><?php echo $total_activos; ?></b></td>
									<td><b><?php echo $total_activos_TV; ?></b></td>
									<td><b><?php echo $total_activos_TV_Internet; ?></b></td>
									<td><b><?php echo $total_activos_Internet; ?></b></td>
									<td><b><?php echo $total_cancelados; ?></b></td>
									<td><b><?php echo $total_pendientes; ?></b></td>
                                    <td><b><?php echo $total_total; ?></b></td>
								</tr>
							<?php
						}
					}
					else
					{
						?>
                        <tr><td colspan="5">Para ver el Reporte utilize el filtro y presione el bot&oacute;n <b>Consultar</b></td></tr>
                        <?php
					}
				?>
				<tr><td colspan="5"  height="3px" class="separador"></td></tr>
			</table>
		</td>
	</tr>
</table>
<script>
var cal1,cal2,cal3,cal4,
mCal,
mDCal,
newStyleSheet;
var dateFrom = null;
var dateTo = null;
window.onload = function() {
	
    cal1 = new dhtmlxCalendarObject('desde_contrato');
	cal1.setSkin('dhx_skyblue');
	<?php
		if(isset($_POST['desde_contrato'])&&$_POST['desde_contrato']!="")
		{
			?>
			cal1.setDate('<?php echo $_POST['desde_contrato']; ?>');
			<?php
		}
	?>
	
	cal2 = new dhtmlxCalendarObject('hasta_contrato');
	cal2.setSkin('dhx_skyblue');
	
	<?php
		if(isset($_POST['hasta_contrato'])&&$_POST['hasta_contrato']!="")
		{
			?>
			cal2.setDate('<?php echo $_POST['hasta_contrato']; ?>');
			<?php
		}
	?>
	
	 cal3 = new dhtmlxCalendarObject('desde_activacion');
	cal3.setSkin('dhx_skyblue');
	<?php
		if(isset($_POST['desde_activacion'])&&$_POST['desde_activacion']!="")
		{
			?>
			cal3.setDate('<?php echo $_POST['desde_activacion']; ?>');
			<?php
		}
	?>
	
	cal4 = new dhtmlxCalendarObject('hasta_activacion');
	cal4.setSkin('dhx_skyblue');
	
	<?php
		if(isset($_POST['hasta_activacion'])&&$_POST['hasta_activacion']!="")
		{
			?>
			cal4.setDate('<?php echo $_POST['hasta_activacion']; ?>');
			<?php
		}
	?>
	
}
</script>
