<?php session_start(); include("../config.php"); include("../conexion.php");  ?>
<form onsubmit="return false;">
	<div id="modulo" style="display:none;">12</div>
	<table width="100%" cellpadding="2px">
    	<tr> 
            <td>Proveedor</td>
            <td colspan="3">
                <select name="filtro_proveedor" id="filtro_proveedor"   style="width:300px; font-size:12px;">
                    <option value="-1">Todos</option>
                    <?php
                        $query_t_u = "select * from f_cat_proveedor";
                        $tabla_t_u = mysqli_query($conexion,$query_t_u);
                        while($registro_t_u = mysqli_fetch_array($tabla_t_u))
                        {
                            echo "<option value=\"$registro_t_u[0]\">$registro_t_u[1]</option>";
                        }
                    ?>
                </select>
            </td>
        </tr>
        <tr> 
            <td>Nombre</td><td><input name="filtro_nombre" id="filtro_nombre"  style="width:300px;font-size:12px;" type="text" maxlength="12" /></td></tr>
        </tr>
        <tr>
            <td height="10"></td>
        </tr>
        <tr><td colspan="4" align="right"><input type="button" name="enviar_filtro" id="enviar_filtro" value="Aceptar" /></td></tr>
       	
    </table>
</form>