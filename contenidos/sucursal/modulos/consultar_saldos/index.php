<script language="javascript" type="text/javascript">
	var contenedor_cliente = ""; //Se actualiza para saber en que input se coloca la llave del cliente
	var parametro_sucursal_cliente = "<?php echo $_SESSION['tuvision_id_sucursal']; ?>";// Se utiliza en caso de que queramos la lista de clientes de una sucursal en especifica
	
	function cambio_id_cliente(id){	
		document.datagrid.submit();
	}
	function imprimir()
	{
		if(document.datagrid.id_cliente.value!="")
		{
			var aux_action = document.datagrid.action;
			var aux_target = document.datagrid.target;
			document.datagrid.action = "reporte/imprimir_saldo.php";
			document.datagrid.target = "_blank";
			document.datagrid.submit();
			document.datagrid.action = aux_action;
			document.datagrid.target = aux_target;
			
		}
		else
		{
			alert("No ha seleccionado ningun cliente");
		}
	}
</script>
<table border="0px"  width="100%" style="color:#000000;font-size:12px">
	<tr>    
    	<td align="right">
        	<table border="0" width="100%" cellpadding="0" cellspacing="0" >
            	<tr>
            	<td width="5px" background="imagenes/module_left.png"></td>
                <td width="70px" background="imagenes/module_center.png" height="80"  valign="middle"><img src="imagenes/coins.png" /></td>
                <td align="left" background="imagenes/module_center.png" height="80" valign="middle" class="titulo"><b>&nbsp;&nbsp;CONSULTAR SALDOS&nbsp;&nbsp;</b></td>
                <td align="right" background="imagenes/module_center.png" height="80" >
                	<?php 
						if(isset($_POST['id_cliente']))
						{
							?>
                             <button class="boton2" onclick="window.location = 'index.php?menu=12&accion=agregar&id_cliente=<?php echo $_POST['id_cliente']?>'"><img src="imagenes/habilitar.png" /><br />Pagar</button>
                            <?php
						}
					?>
                    <button class="boton2" onclick="contenedor_cliente='id_cliente';createWindow('Buscar Cliente',450,310 ,1,false,true);"><img src="imagenes/cliente.png" /><br />Cliente</button>
                    <button class="boton2" onclick="imprimir()"><img src="imagenes/imprimir.png" /><br />imprimir</button>
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
            <input type="hidden" name="id_cliente" id="id_cliente" value="<?php echo addslashes($_POST['id_cliente']); ?>" />
			<table class="datagrid" width="100%" border="0" cellspacing="0">
				<tr><td colspan="5" height="3px" class="separador"></td></tr>
				<tr class="tabla_columns">
                    <td>ID Cliente</td>
                    <td>Nombre</td>
                    <td>Saldo Anterior</td>
                    <td>Saldo Actual</td>
                    <td>Fecha Activaci&oacute;n</td>
				</tr>
				<?php
					if(isset($_POST['id_cliente']))
					{
					$query = "select t.id_cliente,concat(c.nombre,' ',c.apellido_paterno,' ',c.apellido_materno),t.saldo_anterior,t.saldo_actual, c.fecha_activacion from transacciones t, clientes c where c.id_cliente=t.id_cliente and t.id_cliente='".addslashes($_POST['id_cliente'])."' order by fecha_transaccion desc, id_transaccion desc limit 1";
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
                        <tr><td colspan="5">No hay Registros</td></tr>
                        <?php
					}
					}
					else
					{
						?>
                        <tr><td colspan="5">Para consultar saldo seleccione un cliente</td></tr>
                        <?php
					}
				?>
				<tr><td colspan="5"  height="3px" class="separador"></td></tr>
			</table>
			</form>
		</td>
	</tr>
</table>