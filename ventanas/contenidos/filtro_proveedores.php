<?php session_start(); include("../config.php"); include("../conexion.php");  ?>
<form onsubmit="return false;">
	<div id="modulo" style="display:none;">10</div>
	<table width="100%" cellpadding="2px">
    	
    	<tr> 
        	<td>Nombre</td><td><input name="filtro_nombre" id="filtro_nombre"  style="width:300px;font-size:12px;" type="text" maxlength="12" /></td></tr>
        </tr>
        
        <tr><td colspan="2" align="right"><input type="button" name="enviar_filtro" id="enviar_filtro" value="Aceptar" /></td></tr>
       	
    </table>
</form>