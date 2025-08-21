<script language="javascript" type="text/javascript">
	
	function imprimir_pdf()
	{
		var aux_action = document.datagrid.action;
		var aux_target = document.datagrid.target;
		document.datagrid.action = "reporte/clientes_cobrar_pdf.php";
		document.datagrid.target = "_blank";
		document.datagrid.submit();
		document.datagrid.action = aux_action;
		document.datagrid.target = aux_target;
	}
	function imprimir_excel()
	{
		var aux_action = document.datagrid.action;
		var aux_target = document.datagrid.target;
		document.datagrid.action = "reporte/clientes_cobrar_excel.php";
		document.datagrid.target = "_blank";
		document.datagrid.submit();
		document.datagrid.action = aux_action;
		document.datagrid.target = aux_target;
	}
	function consultar()
	{
		document.datagrid.submit();
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
    <tr><td height="10px"></td></tr>
	<tr>
		<td colspan="3">
			<form name="datagrid" method="post">
            <input type="hidden" name="sucursal" id="sucursal" value="<?php echo $_SESSION['tuvision_id_sucursal']; ?>" />
			<table class="datagrid" width="100%" border="0" cellspacing="0">
				<tr><td colspan="9" height="3px" class="separador"></td></tr>
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
						
					$add_sucursal = " and c.id_sucursal='".$_SESSION['tuvision_id_sucursal']."'";
						
					$query = "select c.id_cliente, concat(c.nombre,' ',c.apellido_paterno,' ',c.apellido_materno) as nombre,s.nombre, cc.nombre, c.numero, c.id_tap, c.referencia_casa, t.saldo_actual, ec.descripcion, c.tipo_contratacion from clientes c, cat_calles cc, sucursales s, transacciones t, tipo_status_cliente tsc, estatus_cliente ec where c.id_tipo_status=tsc.id_tipo_status and tsc.id_status=ec.id_status and c.id_sucursal=s.id_sucursal and c.id_calle=cc.id_calle and t.id_cliente=c.id_cliente and t.saldo_actual>0.0 and t.id_transaccion = (select max(t2.id_transaccion) from transacciones t2 where  t2.id_cliente = c.id_cliente ) ".$add_sucursal." order by c.id_sucursal asc, c.id_cliente asc, t.id_transaccion desc, t.fecha_transaccion desc";
					$query2 = "select c.id_cliente, concat(c.nombre,' ',c.apellido_paterno,' ',c.apellido_materno) as nombre,c.telefono,s.nombre, cc.nombre, c.numero, c.id_tap, c.referencia_casa, t.saldo_actual, ec.descripcion, c.tipo_contratacion from clientes c, cat_calles cc, sucursales s, transacciones t, tipo_status_cliente tsc, estatus_cliente ec where c.id_tipo_status=tsc.id_tipo_status and tsc.id_status=ec.id_status and c.id_sucursal=s.id_sucursal and c.id_calle=cc.id_calle and t.id_cliente=c.id_cliente and t.saldo_actual>0.0 and t.id_transaccion = (select max(t2.id_transaccion) from transacciones t2 where  t2.id_cliente = c.id_cliente ) ".$add_sucursal." order by c.id_sucursal asc, c.id_cliente asc, t.id_transaccion desc, t.fecha_transaccion desc";

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
                        <tr><td colspan="9">Presione el boton consultar</td></tr>
                        <?php
					}
				?>
				<tr><td colspan="9"  height="3px" class="separador"></td></tr>
			</table>
			</form>
		</td>
	</tr>
</table>