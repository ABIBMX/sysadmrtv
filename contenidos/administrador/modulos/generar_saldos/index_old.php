<script type="text/javascript" src="jshash-2.2/md5-min.js"></script>

<script language="javascript" type="text/javascript">
	
	function guardar()
	{
		var cadena = "";
		
		if(document.formulario.sucursal.value=='null')
			cadena+= "\n* Debe seleccionar una sucursal.";			
		
		if(cadena == "")
		{		
			if(confirm("Est\u00e1s seguro que quiere hacer un corte?. La operaci\u00f3n puede tardar algunos minutos"))
				document.formulario.submit();
		}
		else
			alert("Por favor verifique lo siguiente:"+cadena);
	}
</script>

<table border="0px"  width="100%" style="color:#000000;font-size:12px">
	<tr>    
    	<td align="right">
        	<table border="0" width="100%" cellpadding="0" cellspacing="0" >
            	<tr>
            	<td width="5px" background="imagenes/module_left.png"></td>
                <td width="70px" background="imagenes/module_center.png" height="80"  valign="middle"><img src="imagenes/calculator.png" /></td>
                <td align="left" background="imagenes/module_center.png" height="80" valign="middle" class="titulo"><b>&nbsp;&nbsp;GENERAR SALDOS&nbsp;&nbsp;</b></td>
                <td align="right" background="imagenes/module_center.png" height="80" >
                    <button class="boton2" onclick="guardar()" ><img src="imagenes/Ok.png" /><br/>Generar</button>
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
				case 1: 
					
					$query = "select if((select date_format(current_date(),'%c'))=(date_format((select max(fecha_transaccion) from transacciones t, clientes c where id_concepto=1 and t.id_cliente=c.id_cliente and c.id_sucursal='".addslashes($_POST['sucursal'])."'),'%c')),1,0) as corte_realizado";
								
					$corte_realizado = devolverValorQuery($query);
					
					if($corte_realizado[0] == '1')
					{
						?>
							<tr>
								<td colspan="3" align="center">
									<table border="0" width="100%" cellpadding="0" cellspacing="0" >
										<tr>                                    	
											<td width="5px" background="imagenes/message_error_left.png"></td>
											<td align="center" background="imagenes/message_error_center.png" height="30" valign="middle" class="warning">Ya ha generado saldos para este mes de la sucursal con clave: <b><?php echo $_POST['sucursal']; ?></b>.</td>
											<td width="5px" background="imagenes/message_error_right.png"></td>
										</tr>
									</table>
								</td>
							</tr>
						<?php
					}
					else
					{				
						$query = "insert into transacciones (id_transaccion,id_cliente,id_concepto, cargo,saldo_anterior,saldo_actual,fecha_transaccion, hora_transaccion)  
	select 0, c.id_cliente,1,
		(c.tarifa*(select ifnull((select if((select datediff(current_date(),(select fecha_activacion from clientes where id_cliente=c.id_cliente)))>30,30,(select datediff(current_date(),(select fecha_activacion from clientes where id_cliente=c.id_cliente))))),0.0))) as cargo,
		(select ifnull((select saldo_actual from transacciones where id_cliente=c.id_cliente ORDER BY fecha_transaccion desc, hora_transaccion desc, id_transaccion desc LIMIT 1),0.0)) as saldo_anterior,
		(c.tarifa*(select ifnull((select if((select datediff(current_date(),(select fecha_activacion from clientes where id_cliente=c.id_cliente)))>30,30,(select datediff(current_date(),(select fecha_activacion from clientes where id_cliente=c.id_cliente))))),0.0))) +(select ifnull((select saldo_actual from transacciones where id_cliente=c.id_cliente ORDER BY fecha_transaccion desc, hora_transaccion desc, id_transaccion desc LIMIT 1),0.0)) as saldo_actual,
		current_date() as fecha_transaccion,
		current_time() as hora_transaccion
	from clientes c, tipo_status_cliente ts, estatus_cliente ec 
	where c.id_sucursal='".addslashes($_POST['sucursal'])."' and c.id_tipo_status=ts.id_tipo_status and ec.id_status=ts.id_status and ec.id_status=1";
	
						if(@mysqli_query($conexion,$query))
						{
							?>
								<tr>
									<td colspan="3" align="center" >
										<table border="0" width="100%" cellpadding="0" cellspacing="0" >
											<tr>                                    	
												<td width="5px" background="imagenes/message_left.png"></td>
												<td align="center" background="imagenes/message_center.png" height="30" valign="middle" class="fine">Los saldos se han generado satisfactoriamente</td>
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
											<td align="center" background="imagenes/message_error_center.png" height="30" valign="middle" class="warning">Hubo un problema al generar saldos.</td>
											<td width="5px" background="imagenes/message_error_right.png"></td>
										</tr>
									</table>
								</td>
							</tr>
							<?php
						}
					}
								   
					break;
			}
		}
		
		$mes = date('m');
		
		switch($mes)
		{
			case '01': $mes= "ENERO"; break;
			case '02': $mes= "FEBRERO"; break;
			case '03': $mes= "MARZO"; break;
			case '04': $mes= "ABRIL"; break;
			case '05': $mes= "MAYO"; break;
			case '06': $mes= "JUNIO"; break;
			case '07': $mes= "JULIO"; break;
			case '08': $mes= "AGOSTO"; break;
			case '09': $mes= "SEPTIEMBRE"; break;
			case '10': $mes= "OCTUBRE"; break;
			case '11': $mes= "NOVIEMBRE"; break;
			case '12': $mes= "DICIEMBRE"; break;
		}
	?>
    <tr><td height="10px"></td></tr>
    <tr>
		<td colspan="3">
			<table class="datagrid" width="100%" border="0" cellspacing="0">
				<tr><td  height="3px" class="separador"></td></tr>
				<tr class="tabla_columns">
					<td >&nbsp;Mes de Corte: <b><?php echo $mes; ?></b></td>
				</tr>
				<tr>
					<td>
                    	<table border="0">
						<?php
							$tabla = mysqli_query($conexion,"select * from sucursales");
							while($registro=mysqli_fetch_array($tabla))
							{
								echo "<tr><td>".$registro[1].": </td>";
								
								$query = "select if((select date_format(current_date(),'%c'))=(date_format((select max(fecha_transaccion) from transacciones t, clientes c where id_concepto=1 and t.id_cliente=c.id_cliente and c.id_sucursal='".addslashes($registro[0])."'),'%c')),1,0) as corte_realizado";
								
								$corte_realizado = devolverValorQuery($query);
								
								if($corte_realizado[0]=='1')
								{
									$imagen="habilitar.png";
									$alt = "Corte Realizado";
								}
								else
								{
									$imagen="deshabilitar.png";
									$alt = "Corte Sin Realizar";
								}
								echo "<td><img alt='".$alt."' title='".$alt."' src='imagenes/".$imagen."' /><td></tr>";
								
							}							
                        ?>
                        </table>
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
				<tr><td  height="3px" class="separador"></td></tr>
				<tr class="tabla_columns">
					<td >&nbsp;Seleccione una Sucursal para hacer el Corte</td>
				</tr>
				<tr>
					<td>
						<form name="formulario" method="post" onsubmit="return false;" action="index.php?menu=23">&nbsp;
						
                                	<select name="sucursal" style="width:300px; font-size:12px;">
                                    	<option value="null">Elige una Sucursal</option>
										<?php
											$query_t_u = "select * from sucursales order by id_sucursal asc";
											$tabla_t_u = mysqli_query($conexion,$query_t_u);
											while($registro_t_u = mysqli_fetch_array($tabla_t_u))
											{
												echo "<option value=\"$registro_t_u[0]\">$registro_t_u[0] - $registro_t_u[1]</option>";
											}
                                        ?>
                                    </select>                                                           
						
						<input name="accion"  type="hidden" value="1" />
						</form>
					</td>
				</tr>
				<tr><td  height="3px" class="separador"></td></tr>
			</table>
		</td>
	</tr>
</table>
