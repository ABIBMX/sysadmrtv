<?php
session_start();
include("../config.php");
include("../conexion.php");

?>
<form onsubmit="return false;">
	<div id="modulo" style="display:none;">9</div>
	<table width="100%" cellpadding="2px">
    
 
	    <tr> 
        	<td>Sucursal:</td><td>
            <?php
				echo "<select name='sucursal' id='sucursal' onchange='parametro_sucursal_empleado=this.value; cambia(this.value);'>";
				echo "<option value='null'>TODOS</option>";
				$query = "select id_sucursal, nombre from sucursales";
				$res = mysqli_query($conexion,$query);
				while(list($id,$servicio) = mysqli_fetch_array($res)){
					echo "<option value='$id'>$servicio</option>";
				}
				echo "</select>";
			?>
            </td></tr>
        </tr> 
	
         <TR>
            
    	<td><span id="nom" style="display:none">Empleado:</span></td><td><span id="imag" style="display:none"><input name="id_empleado" id="id_empleado" readonly="readonly" style="width:110px;font-size:12px;" type="text" maxlength="12" />&nbsp;<img style="cursor:pointer;position:relative; top:4px;" onclick="contenedor_empleado='id_empleado';createWindow('Buscar Empleado',450,310 ,2,false,true,1);" src="imagenes/popup.png" /></span></td>
        </TR>
        
         <tr> 
        	<td>Clave:</td><td><input name="clave" id="clave" type="text" maxlength="10"/></td></tr>
        </tr>
        
        </tr>
        <tr><td colspan="2" align="right"><input type="button" name="enviar_filtro" id="enviar_filtro" value="Aceptar" /></td></tr>       	
    </table>
</form>