<?php
include("../config.php");
include("../conexion.php");

if (isset($_POST['tipo_ingreso'])) {
	$query = "select id_promocion,descripcion, porcentaje from promociones where activo=1 and id_tipo_ingreso='" . addslashes($_POST['tipo_ingreso']) . "'";
	$tabla = mysqli_query($conexion, $query);

	if ($_POST['adicional'] == 1) {
		$name = "promociones[]";
		$id = $_POST['id_promocion'];
	} else {
		$name = "promocion";
		$id = "promocion";
	}

	$cadena = "<select name='" . $name . "' class='promociones' id='" . $id . "' onchange=\"calcularTotal('" . $_POST['id_total'] . "','" . $_POST['id_monto'] . "','" . $id . "');\" style='width:200px;font-size:12px;'><option value='null'>Seleccione una Promocion</option>";
	$bandera = false;
	while ($registro = mysqli_fetch_array($tabla)) {
		$bandera = true;
		$cadena .= "<option value=\"" . $registro[0] . "\">" . $registro[1] . " " . $registro[2] . "%</option>";
	}
	$cadena .= "</select>";

	if (!$bandera)
		echo "<select name='" . $name . "' id='" . $id . "' style='width:200px;font-size:12px;'><option value='null'>No hay promociones</option></select>";
	else
		echo $cadena;
}
if (isset($_POST['promocion'])) {
	$query =  "select porcentaje from promociones where id_promocion=" . addslashes($_POST['promocion']);
	$registro = devolverValorQuery($query);
	echo $registro[0];
}
if (isset($_POST['concepto_add'])) {
?>
	<select name="conceptos_add[]" class="conceptos" onchange="cargarPromocion(this.value,'<?php echo $_POST['div_promocion']; ?>','<?php echo $_POST['div_total']; ?>','<?php echo $_POST['div_monto']; ?>','<?php echo $_POST['id_promocion']; ?>','<?php echo $_POST['adicional']; ?>');" style="width:200px; font-size:12px;">
		<option value="null">Elige un Tipo de Ingreso</option>
		<?php
		$query_t_u = "select * from cat_tipo_ingreso where estado = 'Activo'";
		$tabla_t_u = mysqli_query($conexion, $query_t_u);
		while ($registro_t_u = mysqli_fetch_array($tabla_t_u)) {
			echo "<option value=\"$registro_t_u[0]\">$registro_t_u[1]</option>";
		}
		?>
	</select>
<?php
}

if (isset($_POST['cliente_telefono'])) {

	$consulta_telefono = "SELECT telefono FROM clientes WHERE id_cliente = '" . $_POST['cliente_telefono'] . "'";
	$resultado = mysqli_query($conexion, $consulta_telefono);

	while ($resultado_datos = mysqli_fetch_array($resultado)) {

		if ($resultado_datos['telefono'] != "" || $resultado_datos['telefono'] != null) {
			echo "<td>Telefono: </td><td><input type='text' style='margin-top:4px;margin-bottom:2px;width:100px' name='telefono_cliente' value='" . $resultado_datos['telefono'] . "' maxlength='10' pattern='[0-9]{10}' oninput=\"this.value=this.value.replace(/[^0-9]/g,'')\" title='Debe contener exactamente 10 dígitos'/></td>";
		} else {
			echo "<td>Telefono: </td><td><input type='text' style='margin-top:4px;margin-bottom:2px;width:300px' name='telefono_cliente' value='' placeholder='El cliente no cuenta con un telefono, ingrese uno' maxlength='10' pattern='[0-9]{10}' oninput=\"this.value=this.value.replace(/[^0-9]/g,'')\" title='Debe contener exactamente 10 dígitos'/></td>";
		}
	}
}

if (isset($_POST['cliente_tarifa'])) {

	$consulta_tarifa = "SELECT tarifa FROM clientes WHERE id_cliente = '" . $_POST['cliente_tarifa'] . "'";
	$resultado = mysqli_query($conexion, $consulta_tarifa);

	while ($resultado_datos = mysqli_fetch_array($resultado)) {

		if ($resultado_datos['tarifa'] != "" || $resultado_datos['tarifa'] != null) {

			echo "<td>Tarifa: </td><td><input type='text' style='margin-top:4px;margin-bottom:2px;width:100px' name='tarifa_cliente' value='" . $resultado_datos['tarifa'] . "' oninput=\"this.value=this.value.replace(/[^0-9.]/g,'')\"/></td>";
		} else {
			echo "<td>Tarifa: </td><td><input type='text' style='margin-top:4px;margin-bottom:2px;width:300px' name='tarifa_cliente' value='' placeholder='El cliente no cuenta con una tarifa, ingrese una' oninput=\"this.value=this.value.replace(/[^0-9.]/g,'')\"/></td>";
		}
	}
}

if (isset($_POST['servicio_internet'])) {

	if ($_POST['servicio_internet'] == 9 || $_POST['servicio_internet'] == 15 || $_POST['servicio_internet'] == 8 || $_POST['servicio_internet'] == 13 ||
	$_POST['servicio_internet'] == 14 || $_POST['servicio_internet'] == 16) {
		echo '
	<table class="datagrid" width="100%" border="0" cellspacing="0">
		<tr>
        	<td height="3px" class="separador"></td>
    	</tr>
    	<tr class="tabla_columns">
        	<td>&nbsp;Datos de Internet</td>
    	</tr>
    	<tr>
        	<td>
            	<table width="100%" border="0" cellspacing="0">
					<tr>
						<td width="100px">No OLT:</td>
						<td><input type="text" name="no_olt" style="margin-top: 4px;margin-bottom: 2px; width:150px" required/></td>
					</tr>

					<tr>
						<td width="100px">No. CAJA:</td>
						<td><input type="text" name="no_caja" style="margin-top: 4px;margin-bottom: 2px; width:150px" required/></td>
					</tr>

					<tr>
						<td width="100px">GPON SN:</td>
						<td><input type="text" name="no_pon" style="margin-top: 4px;margin-bottom: 2px; width:150px" required/></td>
					</tr>
				</table>
        	</td>
    	</tr>
    	<tr>
        	<td height="3px" class="separador"></td>
    	</tr>
	</table>
	';
	} else {
		echo '';
	}
}

?>