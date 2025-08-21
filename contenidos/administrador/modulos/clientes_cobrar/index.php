<script language="javascript" type="text/javascript">
	
	function imprimir_pdf()
	{
		var aux_action = document.formulario.action;
		var aux_target = document.formulario.target;
		document.formulario.action = "reporte/clientes_cobrar_pdf.php";
		document.formulario.target = "_blank";
		document.formulario.submit();
		document.formulario.action = aux_action;
		document.formulario.target = aux_target;
	}
	function imprimir_excel()
	{
		var aux_action = document.formulario.action;
		var aux_target = document.formulario.target;
		document.formulario.action = "reporte/clientes_cobrar_excel.php";
		document.formulario.target = "_blank";
		document.formulario.submit();
		document.formulario.action = aux_action;
		document.formulario.target = aux_target;
	}
	function consultar()
	{
		document.formulario.submit();
	}
</script>
<table border="0px"  width="100%" style="color:#000000;font-size:12px">
	<tr>    
    	<td align="right">
        	<table border="0" width="100%" cellpadding="0" cellspacing="0" >
            	<tr>
            	<td width="5px" background="imagenes/module_left.png"></td>
                <td width="70px" background="imagenes/module_center.png" height="80"  valign="middle"><img src="imagenes/coins.png" /></td>
                <td align="left" background="imagenes/module_center.png" height="80" valign="middle" class="titulo"><b>&nbsp;&nbsp;CLIENTES A COBRAR&nbsp;&nbsp;</b></td>
                <td align="right" background="imagenes/module_center.png" height="80" >
                	<button class="boton2" onclick="consultar()"><img src="imagenes/habilitar.png" /><br />Consultar</button>
                     <?php
						if(isset($_POST['sucursal']))
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
						<form name="formulario" method="post" onsubmit="return false;" action="index.php?menu=28">
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
			<form name="datagrid" method="post">
            <input type="hidden" name="id_cliente" id="id_cliente" value="<?php echo addslashes($_POST['id_cliente']); ?>" />
			<table class="datagrid" width="100%" border="0" cellspacing="0">
				<tr><td colspan="12" height="3px" class="separador"></td></tr>
				<tr class="tabla_columns">
                    <td>ID Cliente</td>
                    <td>Nombre</td>
                    <td>Sucursal</td>
                    <td>Calle</td>
                    <td>Numero</td>
                    <td>ID Tap</td>
                    <td>Referencia</td>
                    <td>Saldo Actual</td>
                    <td>Status</td>
					<td>Tipo de Servicio</td>
				</tr>
				<?php
					if(isset($_POST['sucursal']))
					{
						if($_POST['sucursal']!="-1")
							$add_sucursal = " and c.id_sucursal='".addslashes($_POST['sucursal'])."'";
						
					//$query = "select c.id_cliente, concat(c.nombre,' ',c.apellido_paterno,' ',c.apellido_materno) as nombre,s.nombre, cc.nombre, c.numero, c.id_tap, c.referencia_casa, t.saldo_actual, ec.descripcion, c.tipo_contratacion from clientes c, cat_calles cc, sucursales s, transacciones t, tipo_status_cliente tsc, estatus_cliente ec where c.id_tipo_status=tsc.id_tipo_status and tsc.id_status=ec.id_status and  c.id_sucursal=s.id_sucursal and c.id_calle=cc.id_calle and t.id_cliente=c.id_cliente and t.saldo_actual>0.0 and t.id_transaccion = (select max(t2.id_transaccion) from transacciones t2 where  t2.id_cliente = c.id_cliente ) ".$add_sucursal." order by c.id_sucursal asc, c.id_cliente asc, t.id_transaccion desc, t.fecha_transaccion desc";
					//$query2 = "select c.id_cliente, concat(c.nombre,' ',c.apellido_paterno,' ',c.apellido_materno) as nombre, c.telefono ,s.nombre, cc.nombre, c.numero, c.id_tap, c.referencia_casa, t.saldo_actual, ec.descripcion, c.tipo_contratacion from clientes c, cat_calles cc, sucursales s, transacciones t, tipo_status_cliente tsc, estatus_cliente ec where c.id_tipo_status=tsc.id_tipo_status and tsc.id_status=ec.id_status and  c.id_sucursal=s.id_sucursal and c.id_calle=cc.id_calle and t.id_cliente=c.id_cliente and t.saldo_actual>0.0 and t.id_transaccion = (select max(t2.id_transaccion) from transacciones t2 where  t2.id_cliente = c.id_cliente ) ".$add_sucursal." order by c.id_sucursal asc, c.id_cliente asc, t.id_transaccion desc, t.fecha_transaccion desc";

					$query = "SELECT 
    c.id_cliente, 
    CONCAT(c.nombre, ' ',c.apellido_paterno, ' ',c.apellido_materno) AS Cliente,
    s.nombre AS Sucursal,
    cc.nombre AS Calle,
    c.numero AS Numero,
    c.id_tap AS TAP,
    c.referencia_casa AS Referencia,
     -- saldo actual (traído con una subconsulta)
    COALESCE((SELECT t2.saldo_actual
     FROM transacciones AS t2
     WHERE t2.id_cliente = c.id_cliente
     ORDER BY t2.id_transaccion DESC LIMIT 1),0) AS Saldo_Actual,
    ec.descripcion AS Estatus,  
    c.tipo_contratacion AS TipoServicio

FROM clientes AS c
INNER JOIN sucursales AS s ON c.id_sucursal = s.id_sucursal
INNER JOIN tipo_status_cliente AS tec ON c.id_tipo_status = tec.id_tipo_status
INNER JOIN estatus_cliente AS ec ON tec.id_status = ec.id_status
INNER JOIN cat_calles AS cc ON cc.id_calle = c.id_calle
WHERE 1=1
".$add_sucursal."
ORDER BY c.id_sucursal ASC, c.id_cliente ASC";

$query2 = "SELECT 
    c.id_cliente, 
    CONCAT(c.nombre, ' ',c.apellido_paterno, ' ',c.apellido_materno) AS Cliente,
	c.telefono,
    s.nombre AS Sucursal,
    cc.nombre AS Calle,
    c.numero AS Numero,
    c.id_tap AS TAP,
    c.referencia_casa AS Referencia,
     -- saldo actual (traído con una subconsulta)
    COALESCE((SELECT t2.saldo_actual
     FROM transacciones AS t2
     WHERE t2.id_cliente = c.id_cliente
     ORDER BY t2.id_transaccion DESC LIMIT 1),0) AS Saldo_Actual,
    ec.descripcion AS Estatus,  
    c.tipo_contratacion AS TipoServicio

FROM clientes AS c
INNER JOIN sucursales AS s ON c.id_sucursal = s.id_sucursal
INNER JOIN tipo_status_cliente AS tec ON c.id_tipo_status = tec.id_tipo_status
INNER JOIN estatus_cliente AS ec ON tec.id_status = ec.id_status
INNER JOIN cat_calles AS cc ON cc.id_calle = c.id_calle
WHERE 1=1
".$add_sucursal."
ORDER BY c.id_sucursal ASC, c.id_cliente ASC";
					
					$_SESSION['tuvision_filtro_clientes_cobrar'] = $query2;
					
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
                                <td><?php echo $registro[4]; ?></td>
                                <td><?php echo $registro[5]; ?></td>
                                <td><?php echo $registro[6]; ?></td>
                                <td><?php echo $registro[7]; ?></td>
                                <td><?php echo $registro[8]; ?></td>
								<td style="text-align: center;"><?php echo $registro[9]; ?></td>
							</tr>
						<?php
					}
					if(!$bandera)
					{
						?>
                        <tr><td colspan="9">No hay Registros</td></tr>
                        <?php
					}
					}
					else
					{
						?>
                        <tr><td colspan="9">Seleccione una sucursal y presione el boton consultar</td></tr>
                        <?php
					}
				?>
				<tr><td colspan="9"  height="3px" class="separador"></td></tr>
			</table>
			</form>
		</td>
	</tr>
</table>