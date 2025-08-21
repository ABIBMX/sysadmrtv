<?php session_start(); include("../config.php"); include("../conexion.php");  ?>
<form onsubmit="return false;">
	<div id="modulo" style="display:none;">7</div>
	<table width="100%" cellpadding="2px">
    	<?php 
			if(!isset($_SESSION['tuvision_id_sucursal']))
			{
		?>
    	<tr> 
        	<td>Sucursal</td>
            <td><select name="sucursal" id="sucursal" onchange="parametro_sucursal_cliente=this.value"   style="width:170px; font-size:12px;">
                    <option value="">Elige una Sucursal</option>
                    <?php
                        $query_t_u = "select * from sucursales order by id_sucursal asc";
                        $tabla_t_u = mysqli_query($conexion,$query_t_u);
                        while($registro_t_u = mysqli_fetch_array($tabla_t_u))
                        {
                            echo "<option value=\"$registro_t_u[0]\">$registro_t_u[0] - $registro_t_u[1]</option>";
                        }
                    ?>
                </select>
             </td>
        </tr>
        <?php
			}
		?>
    	<tr> 
        	<td>Cliente</td><td><input name="id_cliente" id="id_cliente" readonly="readonly" style="width:150px;font-size:12px;" type="text" maxlength="12" />&nbsp;<img style="cursor:pointer;position:relative; top:4px;" onclick="contenedor_cliente='id_cliente';createWindow('Buscar Cliente',450,310 ,1,false,true,1);" src="imagenes/popup.png" /></td></tr>
        </tr>
        <tr> 
        	<td>Estatus</td>
            <td><select name="status" id="status"   style="width:170px; font-size:12px;">
                    <option value="">Elige una Estatus</option>
                    <?php
                        $query_t_u = "select * from estatus_cliente";
                        $tabla_t_u = mysqli_query($conexion,$query_t_u);
                        while($registro_t_u = mysqli_fetch_array($tabla_t_u))
                        {
                            echo "<option value=\"$registro_t_u[0]\">$registro_t_u[1]</option>";
                        }
                    ?>
                </select>
             </td>
        </tr>
        <tr > 
        	<td>Fecha de Registro</td>
         	<td style="border-bottom:1px solid #CCC"> Desde <input name="fecha_registro_desde" id="fecha_registro_desde"  style="width:90px;font-size:12px; background-image:url(calendario/imgs/icon_minicalendar.gif); background-position:right center; background-repeat:no-repeat;" type="text" maxlength="10" readonly="readonly" /> Hasta <input name="fecha_registro_hasta" id="fecha_registro_hasta"  style="width:90px;font-size:12px; background-image:url(calendario/imgs/icon_minicalendar.gif); background-position:right center; background-repeat:no-repeat;" type="text" maxlength="10" readonly="readonly" /> <input type="button" name="limpiar_fecha_registro" id="limpiar_fecha_registro" value="Limpiar" />
            </td>
        
        </tr>
        <tr> 
        	<td>Fecha Activaci&oacute;n</td>
            <td style="border-bottom:1px solid #CCC"> Desde <input name="fecha_activacion_desde" id="fecha_activacion_desde"  style="width:90px;font-size:12px; background-image:url(calendario/imgs/icon_minicalendar.gif); background-position:right center; background-repeat:no-repeat;" type="text" maxlength="10" readonly="readonly" /> Hasta <input name="fecha_activacion_hasta" id="fecha_activacion_hasta"  style="width:90px;font-size:12px; background-image:url(calendario/imgs/icon_minicalendar.gif); background-position:right center; background-repeat:no-repeat;" type="text" maxlength="10" readonly="readonly" /> <input type="button" name="limpiar_fecha_activacion" id="limpiar_fecha_activacion" value="Limpiar" />
            </td>
        </tr>
         <tr> 
        	<td>Fecha Contrato</td>
            <td style="border-bottom:1px solid #CCC"> Desde <input name="fecha_contrato_desde" id="fecha_contrato_desde"  style="width:90px;font-size:12px; background-image:url(calendario/imgs/icon_minicalendar.gif); background-position:right center; background-repeat:no-repeat;" type="text" maxlength="10" readonly="readonly" /> Hasta <input name="fecha_contrato_hasta" id="fecha_contrato_hasta"  style="width:90px;font-size:12px; background-image:url(calendario/imgs/icon_minicalendar.gif); background-position:right center; background-repeat:no-repeat;" type="text" maxlength="10" readonly="readonly" /> <input type="button" name="limpiar_fecha_contrato" id="limpiar_fecha_contrato" value="Limpiar" />
            </td>
        </tr>
        <tr><td colspan="2" align="right"><input type="button" name="enviar_filtro" id="enviar_filtro" value="Aceptar" /></td></tr>
       	
    </table>
</form>