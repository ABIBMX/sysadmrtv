<?php session_start(); include("../config.php"); include("../conexion.php");  ?>
<form onsubmit="return false;">
	<div id="modulo" style="display:none;">6</div>
	<table width="100%" cellpadding="2px">
    	<?php 
			if(!isset($_SESSION['tuvision_id_sucursal']))
			{
		?>      
        <tr> 
        	<td>Sucursal</td>
            <td>
            	<select name="sucursal" id="sucursal"   style="width:170px; font-size:12px;">
                    <option value="-1">Todas</option>
                    <?php
                        $query_t_u = "select * from sucursales";
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
        	<td>Cantidad</td><td><input name="cantidad" id="cantidad"  style="width:170px;font-size:12px;" type="text" maxlength="12" /></td></tr>
        </tr>
        <tr> 
        	<td valign="top">Material o Equipo</td>
            <td>
            	<select name="material" id="material" multiple="multiple" size="5"   style="width:300px; font-size:12px;">           
                    <?php
                        $query_t_u = "select * from cat_equipos_inventario";
                        $tabla_t_u = mysqli_query($conexion,$query_t_u);
                        while($registro_t_u = mysqli_fetch_array($tabla_t_u))
                        {
                            echo "<option value=\"$registro_t_u[0]\">$registro_t_u[1]</option>";
                        }
                    ?>
                </select>
            </td>
        </tr>
        </tr>
        
        <tr><td colspan="2" align="right"><input type="button" name="enviar_filtro" id="enviar_filtro" value="Aceptar" /></td></tr>
       	
    </table>
</form>