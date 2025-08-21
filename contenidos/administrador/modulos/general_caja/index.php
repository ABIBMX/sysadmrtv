<script language="javascript" type="text/javascript">
	
	function consultar()
	{
		var cadena="";
		if((document.formulario.desde.value=="" && document.formulario.hasta.value!="")|| (document.formulario.desde.value!="" && document.formulario.hasta.value==""))
			cadena += "\n - Fechas";
		
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
		document.formulario.action = "reporte/general_caja_pdf.php";
		document.formulario.target = "_blank";
		document.formulario.submit();
		document.formulario.action = aux_action;
		document.formulario.target = aux_target;
	}
	function imprimir_excel()
	{
		var aux_action = document.formulario.action;
		var aux_target = document.formulario.target;
		document.formulario.action = "reporte/general_caja_excel.php";
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
                <td width="70px" background="imagenes/module_center.png" height="80"  valign="middle"><img src="imagenes/caja.png" /></td>
                <td align="left" background="imagenes/module_center.png" height="80" valign="middle" class="titulo"><b>&nbsp;&nbsp;REPORTE GENERAL DE CAJA&nbsp;&nbsp;</b></td>
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
						<form name="formulario" method="post" onsubmit="return false;" action="index.php?menu=30">
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
                            <tr><td colspan="2" style="border-top:1px solid #CCC;"><input type="button" onclick="resetearCampo('desde');resetearCampo('hasta');" value="Resetear Fechas" /></td></tr>                         
                            <tr><td>Desde</td><td><input name="desde" id="desde"  style="width:90px;font-size:12px; background-image:url(calendario/imgs/icon_minicalendar.gif); background-position:right center; background-repeat:no-repeat;" type="text" maxlength="10" readonly="readonly" /></td></tr>
                            <tr><td>Hasta</td><td><input name="hasta" id="hasta"  style="width:90px;font-size:12px; background-image:url(calendario/imgs/icon_minicalendar.gif); background-position:right center; background-repeat:no-repeat;" type="text" maxlength="10" readonly="readonly" /></td></tr>                    
                                                     
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
				<tr><td colspan="6" height="3px" class="separador"></td></tr>
				<tr class="tabla_columns">
                    <td>Sucursal</td>
                    <td align="right">Ingresos</td>
                    <td align="right">Egresos</td>
                    <td align="right">Depositos</td>
                    <td align="right">Total</td>
                    <td width="10px"></td>
				</tr>
				<?php
					if(isset($_POST['filtro']))
					{		
						$fechas = 0;
						unset($_SESSION['general_desde_caja']);
						unset($_SESSION['general_hasta_caja']);
						
						if($_POST['desde']!=""&&$_POST['hasta']!="")
						{
							$fechas++;
							$add_fecha = " and fecha_operacion between '".addslashes($_POST['desde'])."' and '".addslashes($_POST['hasta'])."' ";
							
							$_SESSION['general_desde_caja']= addslashes($_POST['desde']);
							$_SESSION['general_hasta_caja']= addslashes($_POST['hasta']);
						}
						
						
						
						
						if($_POST['sucursal']!="-1")
							$add_sucursal = "  where s.id_sucursal='".addslashes($_POST['sucursal'])."'";
					
						$query = "select distinct s.nombre,
		(select ifnull(sum(cantidad),0.0) from cajas where id_tipo_operacion=1 and  id_sucursal=s.id_sucursal ".$add_fecha."), 
		(select ifnull(sum(cantidad),0.0) from cajas where id_tipo_operacion=2 and  id_sucursal=s.id_sucursal ".$add_fecha."),
		(select ifnull(sum(cantidad),0.0) from cajas where id_tipo_operacion=3 and  id_sucursal=s.id_sucursal ".$add_fecha.") 
	from sucursales s".$add_sucursal;
						
						$_SESSION['tuvision_general_caja'] = $query;
						
						$tabla = mysqli_query($conexion,$query);
						
						$total_ingresos = 0;
						$total_egresos = 0;
						$total_depositos = 0;
						$total_total = 0;
						while($registro=mysqli_fetch_array($tabla))
						{
							$bandera = true;
							$total_ingresos += $registro[1];
							$total_egresos += $registro[2];
							$total_depositos += $registro[3];
							$total = $registro[1] - $registro[2] - $registro[3];
							$total_total += $total;
							
							?>
								<tr class="tabla_row">
									<td><?php echo $registro[0]; ?></td>
									<td align="right">$ <?php echo convertirNumero($registro[1]); ?></td>
									<td align="right">$ <?php echo convertirNumero($registro[2]); ?></td>
									<td align="right">$ <?php echo convertirNumero($registro[3]); ?></td>
                                    <td align="right">$ <?php echo convertirNumero($total); ?></td>
                                    <td></td>
								</tr>
							<?php
						}
						if(!$bandera)
						{
							?>
							<tr><td colspan="6">No hay Resultados</td></tr>
							<?php
						}
						else
						{
							?>
								<tr class="tabla_row">
									<td><b>TOTALES</b></td>
									<td align="right"><b>$ <?php echo convertirNumero($total_ingresos); ?></b></td>
									<td align="right"><b>$ <?php echo convertirNumero($total_egresos); ?></b></td>
									<td align="right"><b>$ <?php echo convertirNumero($total_depositos); ?></b></td>
                                    <td align="right"><b>$ <?php echo convertirNumero($total_total); ?></b></td>
                                    <td></td>
								</tr>
							<?php
						}
					}
					else
					{
						?>
                        <tr><td colspan="6">Para ver el Reporte utilize el filtro y presione el bot&oacute;n <b>Consultar</b></td></tr>
                        <?php
					}
				?>
				<tr><td colspan="6"  height="3px" class="separador"></td></tr>
			</table>
		</td>
	</tr>
</table>
<script>
var cal1,cal2,
mCal,
mDCal,
newStyleSheet;
var dateFrom = null;
var dateTo = null;
window.onload = function() {
	
    cal1 = new dhtmlxCalendarObject('desde');
	cal1.setSkin('dhx_skyblue');
	<?php
		if(isset($_POST['desde'])&&$_POST['desde']!="")
		{
			?>
			cal1.setDate('<?php echo $_POST['desde']; ?>');
			<?php
		}
	?>
	
	cal2 = new dhtmlxCalendarObject('hasta');
	cal2.setSkin('dhx_skyblue');
	
	<?php
		if(isset($_POST['hasta'])&&$_POST['hasta']!="")
		{
			?>
			cal2.setDate('<?php echo $_POST['hasta']; ?>');
			<?php
		}
	?>
	
}
</script>
