<?php include("../config.php"); include("../conexion.php");  ?>
<form onsubmit="return false;">
	<div id="modulo" style="display:none;">3</div>
	<table width="100%" cellpadding="2px">
    	<tr> 
        	<td>Cliente</td><td><input name="id_cliente" id="id_cliente" readonly="readonly" style="width:150px;font-size:12px;" type="text" maxlength="12" />&nbsp;<img style="cursor:pointer;position:relative; top:4px;" onclick="contenedor_cliente='id_cliente';createWindow('Buscar Cliente',450,310 ,1,false,true,1);" src="imagenes/popup.png" /></td></tr>
        </tr>       
        <tr> 
        	<td>Tipo Ingreso</td><td><select name="tipo_ingreso" id="tipo_ingreso"   style="width:170px; font-size:12px;">
                                    	<option value="-1">Elige un Tipo de Ingreso</option>
										<?php
											$query_t_u = "select * from cat_tipo_ingreso";
											$tabla_t_u = mysqli_query($conexion,$query_t_u);
											while($registro_t_u = mysqli_fetch_array($tabla_t_u))
											{
												echo "<option value=\"$registro_t_u[0]\">$registro_t_u[1]</option>";
											}
                                        ?>
                                    </select></td></tr>
        </tr>
        <tr> 
        	<td>Monto</td><td><input name="monto" id="monto"  style="width:90px;font-size:12px;" type="text" maxlength="12" /></td></tr>
        </tr>
         <tr> 
        	<td>Desde</td><td><input name="desde" id="desde"  style="width:90px;font-size:12px; background-image:url(calendario/imgs/icon_minicalendar.gif); background-position:right center; background-repeat:no-repeat;" type="text" maxlength="10" readonly="readonly" /></td></tr>
        </tr>
        <tr> 
        	<td>Hasta</td><td><input name="hasta" id="hasta"  style="width:90px;font-size:12px; background-image:url(calendario/imgs/icon_minicalendar.gif); background-position:right center; background-repeat:no-repeat;" type="text" maxlength="10" readonly="readonly" /></td></tr>
        </tr>
        <tr><td colspan="2" align="right"><input type="button" name="enviar_filtro" id="enviar_filtro" value="Aceptar" /></td></tr>
       	
    </table>
</form>