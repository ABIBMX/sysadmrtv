<?php
session_start();
include("../config.php");
include("../conexion.php");

?>

<form name="formulario" onsubmit="return false;">
<script language="javascript">

</script>

	<div id="modulo" style="display:none;">8</div>
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
            
    	<td>Empleado</td><td><input name="id_empleado" id="id_empleado"  style="width:110px;font-size:12px;" type="text" maxlength="12" readonly="readonly" /><img style="cursor:pointer;position:relative; top:4px;" onclick="contenedor_empleado='id_empleado';parametro_sucursal_empleado='<?php echo $_SESSION['tuvision_id_sucursal'] ?>';createWindow('Buscar Empleado',450,310 ,2,false,true,1);" src="imagenes/popup.png" /></td>
        <?php
		
		}
		?>
        </TR>
        <tr> 
        	<td>Tipo de Egreso:</td><td>
            <?php
				echo "<select name='t_egreso' id='t_egreso'>";
				echo "<option value='null'>TODOS</option>";
				$query = "select id_tipo_egreso, descripcion from cat_tipo_egreso";
				$res = mysqli_query($conexion,$query);
				while(list($id,$servicio) = mysqli_fetch_array($res)){
					echo "<option value='$id'>$servicio</option>";
				}
				echo "</select>";
			?>
            </td></tr>
        </tr>      
        
        <tr> 
        	<td>Estado de Egreso:</td><td>
            <?php
				echo "<select name='estado' id='estado'>";
				echo "<option value='null'>TODOS</option>";
				$query = "select id_estado_transaccion, descripcion from estado_transaccion";
				$res = mysqli_query($conexion,$query);
				while(list($id,$servicio) = mysqli_fetch_array($res)){
					echo "<option value='$id'>$servicio</option>";
				}
				echo "</select>";
			?>
            </td></tr>
            
		<tr>
        	<td colspan="2">Fecha de Egreso:</td>
        </tr>
         <tr> 
        	<td>Desde</td><td><input name="desde_a" id="desde_a"  style="width:90px;font-size:12px; background-image:url(calendario/imgs/icon_minicalendar.gif); background-position:right center; background-repeat:no-repeat;" type="text" maxlength="10" readonly="readonly"/></td></tr>
        </tr>
        <tr> 
        	<td>Hasta</td><td><input name="hasta_a" id="hasta_a"  style="width:90px;font-size:12px; background-image:url(calendario/imgs/icon_minicalendar.gif); background-position:right center; background-repeat:no-repeat;" type="text" maxlength="10" readonly="readonly"/></td></tr>
        </tr>

        
        
        </tr>
        <tr><td colspan="2" align="right"><input type="button" name="enviar_filtro" id="enviar_filtro" value="Aceptar" /></td></tr>       	
    </table>
</form>