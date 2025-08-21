<?php session_start(); include("../config.php"); include("../conexion.php");  ?>
<form onsubmit="return false;">
	<div id="modulo" style="display:none;">11</div>
	<table width="100%" cellpadding="2px">
    	<tr> 
            <td>Proveedor</td>
            <td colspan="3">
                <select name="proveedor" id="proveedor"   style="width:285px; font-size:12px;">
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
            <td>Canal</td>
            <td colspan="3">
                <div id="div_canal">
                    <select name="canal" id="canal"   style="width:285px; font-size:12px;">
                        <option value="-1">Todos</option>
                        <?php
                            /*$query_t_u = "select * from f_canales";
                            $tabla_t_u = mysqli_query($conexion,$query_t_u);
                            while($registro_t_u = mysqli_fetch_array($tabla_t_u))
                            {
                                echo "<option value=\"$registro_t_u[0]\">$registro_t_u[1]</option>";
                            }*/
                        ?>
                    </select>
                </div>
            </td>
        </tr>
        <tr> 
            <td>Status</td>
            <td >
                <select name="status" id="status"   style="width:100px; font-size:12px;">
                    <option value="-1">Todos</option>
                    <?php
                        $query_t_u = "select * from f_status_factura";
                        $tabla_t_u = mysqli_query($conexion,$query_t_u);
                        while($registro_t_u = mysqli_fetch_array($tabla_t_u))
                        {
                            echo "<option value=\"$registro_t_u[0]\">$registro_t_u[1]</option>";
                        }
                    ?>
                </select>
            </td>
            <td>No. Factura:</td><td ><input name="filtro_no_factura" id="filtro_no_factura"  style="width:90px;font-size:12px;" type="text" maxlength="12" /></td></tr>
        </tr>
        <tr> 
            <td>Descripcion:</td><td colspan="3"><input name="filtro_descripcion" id="filtro_descripcion"  style="width:285px;font-size:12px;" type="text" maxlength="12" /></td></tr>
        </tr>
        <tr> 
            <td>Importe a Pagar:</td><td colspan="3"><input name="filtro_importe" id="filtro_importe"  style="width:115px;font-size:12px;" type="text" maxlength="12" /> (Pesos Mexicanos)</td></tr>
        </tr>
        <tr> 
            <td>Saldo:</td><td colspan="3"><input name="filtro_saldo" id="filtro_saldo"  style="width:115px;font-size:12px;" type="text" maxlength="12" /></td></tr>
        </tr>
        <tr>
            <td height="5"></td>
        </tr>
        <tr>
            <td colspan="4"><b>Fecha Recepcion</b></td>
        </tr>
        <tr>
            <td>Desde:</td>
            <td>
                <input name="fecha_recepcion_desde" id="fecha_recepcion_desde"  style="width:90px;font-size:12px; background-image:url(calendario/imgs/icon_minicalendar.gif); background-position:right center; background-repeat:no-repeat;" type="text" maxlength="10" readonly="readonly" />
            </td>
            <td align="right">Hasta:&nbsp;</td>
            <td>
                <input name="fecha_recepcion_hasta" id="fecha_recepcion_hasta"  style="width:90px;font-size:12px; background-image:url(calendario/imgs/icon_minicalendar.gif); background-position:right center; background-repeat:no-repeat;" type="text" maxlength="10" readonly="readonly" />
            </td>
        </tr>
        <tr>
            <td colspan="4"><b>Fecha Pago</b></td>
        </tr>
        <tr>
            <td>Desde:</td>
            <td>
                <input name="fecha_pago_desde" id="fecha_pago_desde"  style="width:90px;font-size:12px; background-image:url(calendario/imgs/icon_minicalendar.gif); background-position:right center; background-repeat:no-repeat;" type="text" maxlength="10" readonly="readonly" />
            </td>
            <td align="right">Hasta:&nbsp;</td>
            <td>
                <input name="fecha_pago_hasta" id="fecha_pago_hasta"  style="width:90px;font-size:12px; background-image:url(calendario/imgs/icon_minicalendar.gif); background-position:right center; background-repeat:no-repeat;" type="text" maxlength="10" readonly="readonly" />
            </td>
        </tr>
        <tr><td colspan="4" align="right"><input type="button" name="enviar_filtro" id="enviar_filtro" value="Aceptar" /></td></tr>
       	
    </table>
</form>