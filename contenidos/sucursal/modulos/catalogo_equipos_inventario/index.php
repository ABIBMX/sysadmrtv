<script language="javascript" type="text/javascript">
	
</script>
<table border="0px"  width="100%" style="color:#000000;font-size:12px">
	<tr>    
    	<td align="right">
        	<table border="0" width="100%" cellpadding="0" cellspacing="0" >
            	<tr>
                    <td width="5px" background="imagenes/module_left.png"></td>
                    <td width="70px" background="imagenes/module_center.png" height="80"  valign="middle"><img src="imagenes/equipos_inventario.png" /></td>
                    <td align="left" background="imagenes/module_center.png" height="80" valign="middle" class="titulo"><b>&nbsp;&nbsp;CATALOGO EQUIPOS INVENTARIO&nbsp;&nbsp;</b></td>
                    <td width="5px" background="imagenes/module_right.png"></td>
                </tr>
            </table>
        </td>
	</tr>
    <tr><td height="10px"></td></tr>
	<tr>
		<td colspan="3">
			<table class="datagrid" width="100%" border="0" cellspacing="0">
				<tr><td colspan="2" height="3px" class="separador"></td></tr>
				<tr class="tabla_columns">
                    <td>ID</td>
                    <td>Descripci&oacute;n</td>
				</tr>
				<?php
					$query = "select * from cat_equipos_inventario";
					$tabla = mysqli_query($conexion,$query);
					while($registro=mysqli_fetch_array($tabla))
					{
						$bandera = true;
						?>
							<tr class="tabla_row">
								<td><?php echo $registro[0]; ?></td>
                                <td><?php echo $registro[1]; ?></td>
							</tr>
						<?php
					}
					if(!$bandera)
					{
						?>
                        <tr><td colspan="2">No hay Registros</td></tr>
                        <?php
					}
				?>
				<tr><td colspan="2"  height="3px" class="separador"></td></tr>
			</table>
		</td>
	</tr>
</table>