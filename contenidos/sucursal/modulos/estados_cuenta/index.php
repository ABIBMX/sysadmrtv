<script language="javascript" type="text/javascript">
	var contenedor_cliente = ""; //Se actualiza para saber en que input se coloca la llave del cliente
	var parametro_sucursal_cliente = "<?php echo $_SESSION['tuvision_id_sucursal']; ?>";// Se utiliza en caso de que queramos la lista de clientes de una sucursal en especifica
	
	function cambio_id_cliente(id){	
	}
	function consultar()
	{
		if(document.formulario.id_cliente.value!="")
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
		else
		{
			alert("No ha seleccionado ningun cliente");
		}
	}
	function imprimir_pdf()
	{
		if(document.formulario.id_cliente.value!="")
		{
			if(document.formulario.desde.value!="" && document.formulario.hasta.value!="")
			{
				var aux_action = document.formulario.action;
				var aux_target = document.formulario.target;
				document.formulario.action = "reporte/estado_cuenta_pdf.php";
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
		else
		{
			alert("No ha seleccionado ningun cliente");
		}
	}
	function imprimir_excel()
	{
		if(document.formulario.id_cliente.value!="")
		{
			if(document.formulario.desde.value!="" && document.formulario.hasta.value!="")
			{
				var aux_action = document.formulario.action;
				var aux_target = document.formulario.target;
				document.formulario.action = "reporte/estado_cuenta_excel.php";
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
                <td width="70px" background="imagenes/module_center.png" height="80"  valign="middle"><img src="imagenes/invoice.png" /></td>
                <td align="left" background="imagenes/module_center.png" height="80" valign="middle" class="titulo"><b>&nbsp;&nbsp;ESTADOS DE CUENTA&nbsp;&nbsp;</b></td>
                <td align="right" background="imagenes/module_center.png" height="80" >
                	
                    <button class="boton2" onclick="consultar()"><img src="imagenes/habilitar.png" /><br />Consultar</button>
                    <button class="boton2" onclick="imprimir_pdf()"><img src="imagenes/imprimir.png" /><br />PDF</button>
                    <button class="boton2" onclick="imprimir_excel()"><img src="imagenes/imprimir.png" /><br />EXCEL</button>
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
						<form name="formulario" method="post" onsubmit="return false;" action="index.php?menu=25">
						<table style="color:#000000" cellpadding="5">
                        	
                            <tr><td>Clave del Cliente</td><td valign="middle"><input name="id_cliente" id="id_cliente" value="<?php echo $_POST['id_cliente']; ?>" readonly="readonly" style="width:110px;font-size:12px;" type="text" maxlength="12" />&nbsp;<img style="cursor:pointer;position:relative; top:4px;" onclick="contenedor_cliente='id_cliente';createWindow('Buscar Cliente',450,310 ,1,false,true);" src="imagenes/popup.png" /></td></tr>
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
				<tr><td  height="3px" class="separador"></td></tr>
				<tr class="tabla_columns">
					<td >Cliente</td>
				</tr>
				<tr>
					<td>
                    	<?php
							if(isset($_POST['id_cliente']))
							{
								$cliente = devolverValorQuery("select concat(nombre,' ',apellido_paterno,' ',apellido_materno), fecha_activacion from clientes where id_cliente='".addslashes($_POST['id_cliente'])."'");
								
								echo "<b>".$cliente[0]."</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Del <b>".$_POST['desde']."</b> al <b>".$_POST['hasta']."</b> &nbsp; &nbsp; Fecha de Activaci&oacute;n: <b>".$cliente[1]."</b>";
							}
							else
							{
								echo "No Asignado";
							}
						?>
					</td>
				</tr>
				<tr><td  height="3px" class="separador"></td></tr>
			</table>
            <br/>
			<table class="datagrid" width="100%" border="0" cellspacing="0">
				<tr><td colspan="7" height="3px" class="separador"></td></tr>
				<tr class="tabla_columns">
                    <td>ID Transacci&oacute;n</td>
                    <td>Concepto</td>
                    <td>Cargo</td>
                    <td>Saldo Anterior</td>
                    <td>Saldo Actual</td>
                    <td>Fecha Transacci&oacute;n</td>
                    <td>Hora Transacci&oacute;n</td>
				</tr>
				<?php
					if(isset($_POST['id_cliente']))
					{
					$query = "select id_transaccion,ct.descripcion,cargo,t.saldo_anterior,t.saldo_actual, fecha_transaccion, hora_transaccion from transacciones t, clientes c, cat_concepto_transaccion ct where c.id_cliente=t.id_cliente and ct.id_concepto=t.id_concepto and t.id_cliente='".addslashes($_POST['id_cliente'])."' and fecha_transaccion between '".addslashes($_POST['desde'])."' and '".addslashes($_POST['hasta'])."' order by fecha_transaccion asc ";
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
							</tr>
						<?php
					}
					if(!$bandera)
					{
						?>
                        <tr><td colspan="7">No hay Resultados</td></tr>
                        <?php
					}
					}
					else
					{
						?>
                        <tr><td colspan="7">Para ver un Estado de Cuenta, seleccione un cliente</td></tr>
                        <?php
					}
				?>
				<tr><td colspan="7"  height="3px" class="separador"></td></tr>
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
