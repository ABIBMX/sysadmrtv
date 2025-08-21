<?php
session_start();
include("../config.php");
include("../conexion.php");

?>
<form onsubmit="return false;">
	<div id="modulo" style="display:none;">5</div>
	<table width="100%" cellpadding="2px">
    
    <?php 
		if(!isset($_SESSION['tuvision_id_sucursal'])){
			?>
	    <tr> 
        	<td>Sucursal:</td><td>
            <?php
				echo "<select name='sucursal' id='sucursal' onchange='parametro_sucursal_cliente=this.value; cambia(this.value);'>";
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
            
    	<td><span id="nom" style="display:none">Cliente:</span></td><td><span id="imag" style="display:none"><input name="id_cliente" id="id_cliente" readonly="readonly" style="width:110px;font-size:12px;" type="text" maxlength="12" />&nbsp;<img style="cursor:pointer;position:relative; top:4px;" onclick="contenedor_cliente='id_cliente';createWindow('Buscar Cliente',450,310 ,1,false,true,1);" src="imagenes/popup.png" /></span></td>
        </TR>
        <?php
		}else{
		?>
        <tr>
        	<td><input type="hidden" name="sucursal" id="sucursal" value="<?php echo $_SESSION['tuvision_id_sucursal'] ?> ?>" /></td>
        </tr>
        <TR>
            
    	<tr> 
        	<td>Cliente:</td><td><input name="id_cliente" id="id_cliente" readonly="readonly" style="width:110px;font-size:12px;" type="text" maxlength="12" />&nbsp;<img style="cursor:pointer;position:relative; top:4px;" onclick="contenedor_cliente='id_cliente';parametro_sucursal_cliente='<?php echo $_SESSION['tuvision_id_sucursal']; ?>';createWindow('Buscar Cliente',450,310 ,1,false,true,1);" src="imagenes/popup.png" /></td>

            </tr>
        
        <?php
		
		}
		?>
        
    	
        
        <tr>
        	<td colspan="2">Fecha de Reporte:</td>
        </tr>
         <tr> 
        	<td>Desde</td><td><input name="desde_r" id="desde_r"  style="width:90px;font-size:12px; background-image:url(calendario/imgs/icon_minicalendar.gif); background-position:right center; background-repeat:no-repeat;" type="text" maxlength="10" readonly="readonly"/></td></tr>
        </tr>
        <tr> 
        	<td>Hasta</td><td><input name="hasta_r" id="hasta_r"  style="width:90px;font-size:12px; background-image:url(calendario/imgs/icon_minicalendar.gif); background-position:right center; background-repeat:no-repeat;" type="text" maxlength="10" readonly="readonly"/></td></tr>
        </tr>

		<tr>
        	<td colspan="2">Fecha de Atencion:</td>
        </tr>
         <tr> 
        	<td>Desde</td><td><input name="desde_a" id="desde_a"  style="width:90px;font-size:12px; background-image:url(calendario/imgs/icon_minicalendar.gif); background-position:right center; background-repeat:no-repeat;" type="text" maxlength="10" readonly="readonly"/></td></tr>
        </tr>
        <tr> 
        	<td>Hasta</td><td><input name="hasta_a" id="hasta_a"  style="width:90px;font-size:12px; background-image:url(calendario/imgs/icon_minicalendar.gif); background-position:right center; background-repeat:no-repeat;" type="text" maxlength="10" readonly="readonly"/></td></tr>
        </tr>

        
        <tr> 
        	<td>Estado del Reporte:</td><td>
            <?php
				echo "<select name='servicio' id='servicio'>";
				echo "<option value='null'>TODOS</option>";
				$query = "select id_estatus_servicio, descripcion from estatus_servicio";
				$res = mysqli_query($conexion,$query);
				while(list($id,$servicio) = mysqli_fetch_array($res)){
					echo "<option value='$id'>$servicio</option>";
				}
				echo "</select>";
			?>
            </td></tr>
        </tr>
		<tr> 
        	<td>Tipo de Servicio:</td><td>
            <?php
				echo "<select name='tservicio' id='tservicio'>";
				echo "<option value='null'>TODOS</option>";
				$query = "select id_tipo_servicio, descripcion from cat_tipo_servicios";
				$res = mysqli_query($conexion,$query);
				while(list($idtservicio,$tservicio) = mysqli_fetch_array($res)){
					echo "<option value='$idtservicio'>$tservicio</option>";
				}
				echo "</select>";
			?>
            </td></tr>
        </tr>
        <tr><td colspan="2" align="right"><input type="button" name="enviar_filtro" id="enviar_filtro" value="Aceptar" /></td></tr>       	
    </table>
</form>