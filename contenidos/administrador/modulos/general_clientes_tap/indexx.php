<script language="javascript" type="text/javascript">

	function consultar()
	{
		document.formulario.submit();		
	}
	
	function solo_numeros_decimales(texto)
	{		
		var expresion = /[0-9]*\.?[0-9]{0,2}/;
		texto.value = texto.value.match(expresion);
		
	}
	function imprimir_pdf()
	{
		var aux_action = document.formulario.action;
		var aux_target = document.formulario.target;
		document.formulario.action = "reporte/general_clientes_tap_pdf.php";
		document.formulario.target = "_blank";
		document.formulario.submit();
		document.formulario.action = aux_action;
		document.formulario.target = aux_target;
	}
	function imprimir_excel()
	{
		var aux_action = document.formulario.action;
		var aux_target = document.formulario.target;
		document.formulario.action = "reporte/general_clientes_tap_excel.php";
		document.formulario.target = "_blank";
		document.formulario.submit();
		document.formulario.action = aux_action;
		document.formulario.target = aux_target;		
		
	}
</script>
<table border="0px"  width="100%" style="color:#000000;font-size:12px">
	<tr>    
    	<td align="right">
        	<table border="0" width="100%" cellpadding="0" cellspacing="0" >
            	<tr>
            	<td width="5px" background="imagenes/module_left.png"></td>
                <td width="70px" background="imagenes/module_center.png" height="80"  valign="middle"><img src="imagenes/maps.png" /></td>
                <td align="left" background="imagenes/module_center.png" height="80" valign="middle" class="titulo"><b>&nbsp;&nbsp;REPORTE DE CLIENTES POR TAP&nbsp;&nbsp;</b></td>
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
						<form name="formulario" method="post" onsubmit="return false;" action="index.php?menu=32">
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
                    <td>ID TAP</td>
                    <td>Valor</td>
                    <td>Salidas</td>
                    <td>Sucursal</td>
                    <td>Cantidad Clientes</td>
				</tr>
				<?php
					if(isset($_POST['filtro']))
					{						
						if($_POST['sucursal']!="-1")
							$add_query = "  and s.id_sucursal='".addslashes($_POST['sucursal'])."'";
					
					$query = "select t.id_tap, t.valor, t.salidas, s.nombre, (select count(id_cliente) from clientes where id_tap=t.id_tap) from tap t, sucursales s where t.id_sucursal=s.id_sucursal ".$add_query." order by s.id_sucursal asc, t.id_tap asc";
					
					$_SESSION['tuvision_general_clientes_tap'] = $query;
					
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
							</tr>
						<?php
					}
					if(!$bandera)
					{
						?>
                        <tr><td colspan="5">No hay Resultados</td></tr>
                        <?php
					}
					}
					else
					{
						?>
                        <tr><td colspan="5">Para generar el reporte, seleccione una sucursal</td></tr>
                        <?php
					}
				?>
				<tr><td colspan="11"  height="3px" class="separador"></td></tr>
			</table>
		</td>
	</tr>
</table>
