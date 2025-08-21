<?php
session_start();
include("../config.php");
include("../conexion.php");

?>
<form onsubmit="return false;">
	<div id="modulo" style="display:none;">4</div>
    
    
	<table width="100%" cellpadding="2px">
    
    <?php 
		if(!isset($_SESSION['tuvision_id_sucursal'])){
			?>
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
            
    	<td><span id="nom" style="display:none">Empleado</span></td><td><span id="imag" style="display:none"><input name="id_empleado" id="id_empleado"  style="width:110px;font-size:12px;" type="text" maxlength="12" readonly="readonly" /><img style="cursor:pointer;position:relative; top:4px;" onclick="contenedor_empleado='id_empleado';createWindow('Buscar Empleado',450,310 ,2,false,true,1);" src="imagenes/popup.png" /></span></td>
        </TR>
        <?php
		}else{
		?>
        <tr>
        	<td><input type="hidden" name="sucursal" id="sucursal" value="<?php echo $_SESSION['tuvision_id_sucursal'] ?> ?>" /></td>
        </tr>
        <TR>
            
    	<tr> 
        	<td>Quien Deposita</td><td><input name="id_empleado" id="id_empleado" readonly="readonly" style="width:110px;font-size:12px;" type="text" maxlength="12" />&nbsp;<img style="cursor:pointer;position:relative; top:4px;" onclick="contenedor_empleado='id_empleado';parametro_sucursal_empleado='<?php echo $_SESSION['tuvision_id_sucursal']; ?>';createWindow('Buscar Empleado',450,310 ,2,false,true,1);" src="imagenes/popup.png" /></td>

            </tr>
        
        <?php
		
		}
		?>
        
    	
        <tr> 
        	<td>Monto</td><td><input name="monto" id="monto"  style="width:90px;font-size:12px;" type="text" maxlength="12" onblur="solo_numeros_decimales(this);"/></td></tr>
        </tr>
         <tr> 
        	<td>Desde</td><td><input name="desde" id="desde"  style="width:90px;font-size:12px; background-image:url(calendario/imgs/icon_minicalendar.gif); background-position:right center; background-repeat:no-repeat;" type="text" maxlength="10" readonly="readonly"/></td></tr>
        </tr>
        <tr> 
        	<td>Hasta</td><td><input name="hasta" id="hasta"  style="width:90px;font-size:12px; background-image:url(calendario/imgs/icon_minicalendar.gif); background-position:right center; background-repeat:no-repeat;" type="text" maxlength="10" readonly="readonly"/></td></tr>
        </tr>

        
        <tr> 
        	<td>Banco</td><td>
            <?php
				echo "<select name='banco' id='banco'>";
				echo "<option value='null'>TODOS</option>";
				$query = "select id_banco, descripcion from cat_bancos";
				$res = mysqli_query($conexion,$query);
				while(list($id,$banco) = mysqli_fetch_array($res)){
					echo "<option value='$id'>$banco</option>";
				}
				echo "</select>";
			?>
            </td></tr>
        </tr>
        <tr><td colspan="2" align="right"><input type="button" name="enviar_filtro" id="enviar_filtro" value="Aceptar" /></td></tr>       	
    </table>
</form>