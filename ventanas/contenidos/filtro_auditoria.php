<?php
session_start();
include("../config.php");
include("../conexion.php");

?>
<script>

	</script>
<form onsubmit="return false;">
	<div id="modulo" style="display:none;">13</div>
	<table width="100%" cellpadding="2px">
    
    <?php 
		if(!isset($_SESSION['tuvision_id_sucursal'])){
			?>
	    <tr> 
        	<td>Sucursal:</td><td>
            <?php
				echo "<select name='sucursal' id='sucursal' onchange='parametro_sucursal_cliente=this.value;_Ajax( \"div_tap\" ,this.value)'>";
				echo "<option value='null'>TODOS</option>";
				$query = "select id_sucursal, nombre from sucursales";
				$res = mysqli_query($conexion,$query);
				while(list($id,$servicio) = mysqli_fetch_array($res)){
					echo "<option value='$id'>$servicio</option>";
				}
				echo "</select>";
			?>
            </td></tr>
        <tr>
        	
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
        
    
       
      
        </tr>
    </table>
		<div id="div_tap"></div>
    <table>
        <tr><td></td><td align="right"><input type="button" name="enviar_filtro" id="enviar_filtro" value="Aceptar" /></td></tr>       	
    </table>
</form>