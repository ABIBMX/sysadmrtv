<?php
header("content-type: application/x-javascript; charset=iso-8859-1");

include("../config.php");
include("../conexion.php");

////////////////////////////////////////////////////////////////////////////////////////////////////////////	 	

$data = addslashes($_POST['id']);
$val1 = addslashes($_POST['valor1']);
$val2 = addslashes($_POST['valor2']);
$val3 = addslashes($_POST['valor3']);
$val4 = addslashes($_POST['valor4']);


/*if($data=="empleados"){
		
		?>
		<input name="empleado" id="autorizox" readonly="readonly" style="width:110px;font-size:12px;" type="text" maxlength="12" />&nbsp;<img style="cursor:pointer;position:relative; top:4px;" onclick="contenedor_empleado='autorizox';parametro_sucursal_empleado=document.formulario.sucursal[document.formulario.sucursal.selectedIndex].value;createWindow('Buscar Empleado',450,310 ,2,false,true);" src="imagenes/popup.png" />
        <?php
	}else */

if ($data == "clientes") {

?>

	<input name="id_cliente" id="id_cliente" readonly="readonly" style="width:110px;font-size:12px;" type="text" maxlength="12" />&nbsp;<img style="cursor:pointer;position:relative; top:4px;" onclick="contenedor_cliente='id_cliente';parametro_sucursal_cliente=document.formulario.sucursal[document.formulario.sucursal.selectedIndex].value;createWindow('Buscar Cliente',450,310 ,1,false,true);" src="imagenes/popup.png" />

<?php

} else if ($data == "ingreso") {
	echo "<select name='ingreso'  style='width:300px; font-size:12px;' >";
	echo "<option value='null'>Seleccione un folio</option>";
	$query = "select distinct(id_ingreso),folio_nota from ingresos where id_cliente like '%$val1%'";
	$result = mysqli_query($conexion, $query);
	while (list($id, $nombre) = mysqli_fetch_array($result)) {
		if ($id == $val2)
			echo "<option value='$id' selected>$nombre</option>";
		else
			echo "<option value='$id'>$nombre</option>";
	}
	echo "</select>";
} else if ($data == "t_atencion") {
	echo "<select name='t_atencion'\" style='width:300px; font-size:12px;'>";
	echo "<option value='null'>Seleccione un tipo de atencion</option>";
	$query = "select id_tipo_atencion,descripcion from cat_tipo_atencion";
	$result = mysqli_query($conexion, $query);
	while (list($id, $nombre) = mysqli_fetch_array($result)) {
		if ($id == $val1)
			echo "<option value='$id' selected>$nombre</option>";
		else
			echo "<option value='$id'>$nombre</option>";
	}
	echo "</select>";
} else if ($data == "taps") {
	$query = "select 
		(select id_tap from tap where id_tap=c.id_tap),
		(select valor from tap where id_tap=c.id_tap),
		(select salidas from tap where id_tap=c.id_tap)
		from clientes c where id_cliente='$val1'";
	$result = mysqli_query($conexion, $query);
	list($id, $valor, $salidas) = mysqli_fetch_array($result);

	$select = "select id_tap, valor, salidas from tap where id_sucursal = (select id_sucursal from clientes where id_cliente='$val1')";
	$ext = mysqli_query($conexion, $select);

?>

	<table border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td>Id Tap:</td>
			<td>
				<?php
				echo "<select name='id_tap' onchange=\"cambios(this.value)\">";
				while (list($taps, $val, $sal) = mysqli_fetch_array($ext)) {
					if ($taps == $id)
						echo "<option value='$taps $val $sal' selected >$taps</option>";
					else
						echo "<option value='$taps $val $sal'>$taps</option>";
				}
				echo "</select>";
				?>

			<td width="30"></td>


			<td>Valor:</td>
			<td><input type="text" name="valor" value="<?php echo $valor; ?>" readonly="readonly" /></td>
			<td width="30"></td>
			<td>Salida:</td>
			<td><input type="text" name="salida" value="<?php echo $salidas; ?>" readonly="readonly" /></td>

		</tr>
	</table>


<?php
} else if ($data == "servicio") {

	if ($val1 == 'nota' || $val1 == 1) {
		$query = "select id_tipo_servicio,descripcion from cat_tipo_servicios where id_tipo_servicio in (select id_tipo_servicio from rel_tipo_ingreso_servicio where id_tipo_ingreso in (select id_tipo_ingreso from montos where id_ingreso = '$val2'))";
		echo "<table border='0' cellspacing='0' cellsppadding=0><tr><td>";

		echo "<table id='services' width='100%' border='0' cellspacing='0'>";

		$result = mysqli_query($conexion, $query);
		while (list($id, $nombre) = mysqli_fetch_array($result)) {
			echo "<tr><td>";
			echo "<select name='servicio[]' id='serviciox' style='width:300px; font-size:12px;'>";
			echo "<option value='$id'>$nombre</option>";
			echo "</select>";
			echo "</td></tr>";
		}

		if (mysqli_num_rows($result) == 0) {
			echo "No asignado";
		}

		echo "</table></td></tr>";

		echo "</table>";
	} else if ($val1 == 2 || $val1 == 3) {
		$query = "select id_tipo_servicio,descripcion from cat_tipo_servicios where id_peticion='$val1'";
		echo "<table border='0' cellspacing='0' cellsppadding=0><tr><td>";

		echo "<table id='services' width='100%' border='0' cellspacing='0'>";
		echo "<tr><td>";

		echo "<select name='servicio[]' id='serviciox' style='width:300px; font-size:12px;' onchange=\"if (this.value == 36) { DatosInternet(this.value); }\">";
		echo "<option value='null'>Seleccione un servicio</option>";

		$result = mysqli_query($conexion, $query);
		while (list($id, $nombre) = mysqli_fetch_array($result)) {
			if ($id == $val2)
				echo "<option value='$id' selected>$nombre</option>";
			else
				echo "<option value='$id'>$nombre</option>";
		}

		if (mysqli_num_rows($result) == 0) {
			echo "No asignado";
		}
		echo "</select>";
		echo "</td></tr></table></td></tr>";
		echo "<tr><td><input type='button' value='Agregar servicio' onclick='agregar();'></td></tr>";
		echo "</table>";
	} else {
		echo "No asignado";
	}
} else if ($data == "serv_aux") {
	$query = "select id_tipo_servicio,descripcion from cat_tipo_servicios where id_peticion='$val1'";

	echo "<select name='servicio[]' id='serviciox' style='width:300px; font-size:12px;'>";
	echo "<option value='null'>Seleccione un servicio</option>";

	$result = mysqli_query($conexion, $query);
	while (list($id, $nombre) = mysqli_fetch_array($result)) {
		if ($id == $val2)
			echo "<option value='$id' selected>$nombre</option>";
		else
			echo "<option value='$id'>$nombre</option>";
	}
	echo "</select>";
} else if ($data == "nota") {

	if ($val1 != "undefined") {
		$query = "select id_ingreso,folio_nota from ingresos where id_cliente='$val1'";

		echo "<select name='folio' style='width:300px; font-size:12px;' onchange=\"_Ajax('servicio','nota',this.value);\">";
		echo "<option value='null'>Seleccione un folio</option>";

		$result = mysqli_query($conexion, $query);
		while (list($id, $nombre) = mysqli_fetch_array($result)) {
			if ($id == $val2)
				echo "<option value='$id' selected>$nombre</option>";
			else
				echo "<option value='$id'>$nombre</option>";
		}
		echo "</select>";
	} else {
		echo "Seleccione \"nota\" en tipo de servicio y un cliente";
	}
} else if ($data == "material") {
	echo "<select name='nombre[]'>";
	echo "<option value='null'>Seleccione un material</option>";
	$query = "select id_equipo_inventario, descripcion from cat_equipos_inventario";
	$res = mysqli_query($conexion, $query);
	while (list($id, $des) = mysqli_fetch_array($res)) {
		echo "<option value='$id'>$des</option>";
	}
	echo "</option>";
} else if ($data == "material2") {
	echo "<select name='nombre2[]'>";
	echo "<option value='null'>Seleccione un material</option>";
	$query = "select id_equipo_inventario, descripcion from cat_equipos_inventario";
	$res = mysqli_query($conexion, $query);
	while (list($id, $des) = mysqli_fetch_array($res)) {
		echo "<option value='$id'>$des</option>";
	}
	echo "</option>";
} else if ($data == "campos") {
	$query = "select valor ,salidas
		from tap where id_tap='$val1'";
	$result = mysqli_query($conexion, $query);
	list($valor, $salidas) = mysqli_fetch_array($result);
?>
	<td>Valor:</td>
	<td><input type="text" name="valor" value="<?php echo $valor; ?>" readonly="readonly" /></td>
	<td width="30"></td>
	<td>Salida:</td>
	<td><input type="text" name="salida" value="<?php echo $salidas; ?>" readonly="readonly" /></td>
<?php
} else if ($data == "div_calle") {

	$query = "select id_calle,nombre from cat_calles where id_sucursal = '$val1'";

	$result = mysqli_query($conexion, $query);
	if ($result) {
		echo "<select name='calle' id='calle' style='width:300px; font-size:12px;'>";
		while (list($id, $nombre) = mysqli_fetch_array($result)) {
			echo "<option value='$id'>$nombre</option>";
		}
		echo "</select>";
	}

	if (mysqli_num_rows($result) == 0) {
		echo "No asignado";
	}
} else if ($data == "div_calletap") {

	$query = "select id_calle,nombre from cat_calles where id_sucursal = '$val1'";

	$result = mysqli_query($conexion, $query);
	if ($result) {
		echo " &nbsp;Calle : ";
		echo "<select name='calle' id='calle' style='width:250px; font-size:12px;'>";
		echo "<option value='null'>Todas</option>";
		while (list($id, $nombre) = mysqli_fetch_array($result)) {
			echo "<option value='$id'>$nombre</option>";
		}
		echo "</select><br>";
	}

	if (mysqli_num_rows($result) == 0) {

		echo "No asignado";
	}
} else if ($data == "div_tap") {
	$query = "select id_tap from tap where id_sucursal = '$val1'";

	$result = mysqli_query($conexion, $query);
	if ($result) {
		echo " &nbsp;TAP : ";
		echo "<select name='tap' id='tap' style='width:250px; font-size:12px;'>";
		echo "<option value='null'>Todas</option>";
		while (list($id_tap) = mysqli_fetch_array($result)) {
			echo "<option value='$id_tap'>$id_tap</option>";
		}
		echo "</select><br>";
	}

	if (mysqli_num_rows($result) == 0) {

		echo "No asignado";
	}
}

if (isset($_POST['servicio']) && isset($_POST['cliente'])) {

	$datos_internet = "SELECT no_caja, no_pon, no_olt FROM conf_internet WHERE  estatus = 'ACTUAL' AND id_cliente = '" . $_POST['cliente'] . "'";
	$resultado = mysqli_query($conexion, $datos_internet);

	while ($resultado_datos = mysqli_fetch_array($resultado)) {

		echo "<table border='0' cellpadding='0' cellspacing='0'>";
		echo "<tr>";
		echo "<td>No. Caja</td>
		<td><input type='text' style='margin-top: 4px;margin-bottom: 2px' name='no_caja' value='" . $resultado_datos['no_caja'] . "' readonly='readonly' /></td>";
		echo "</tr>";

		echo "<tr>";
		echo "<td>No. PON</td>
		<td><input type='text' style='margin-bottom: 2px' name='no_pon' value='" . $resultado_datos['no_pon'] . "' readonly='readonly' /></td>";
		echo "</tr>";


		echo "<tr>";
		echo "<td>No. OLT</td>
		<td><input type='text' name='no_olt' value='" . $resultado_datos['no_olt'] . "' readonly='readonly' /></td>";
		echo "</tr>";

		echo "</table>";
	}
}

// if (isset($_POST['id_confInternet']) && isset($_POST['id_cliente_confInternet']) && isset($_POST['no_olt']) && isset($_POST['no_caja']) && isset($_POST['no_pon']) && isset($_POST['marca_onu']) && isset($_POST['modelo_onu']) && isset($_POST['serie']) && isset($_POST['mac_address']) && isset($_POST['encapsulamiento']) && isset($_POST['registro_winbox']) && isset($_POST['mac_winbox']) && isset($_POST['plan_datos']) && isset($_POST['vlan']) && isset($_POST['resguardo'])) {

// 	date_default_timezone_set('America/Mexico_City');
// 	$fecha = date('Y-m-d');
// 	$hora = date('H:i:s');

// 	$query = "UPDATE conf_internet SET no_olt = '" . addslashes($_POST['no_olt']) . "', no_caja = '" . addslashes($_POST['no_caja']) . "', no_pon = '" . addslashes($_POST['no_pon']) . "', marca_onu = '" . addslashes($_POST['marca_onu']) . "', modelo = '" . addslashes($_POST['modelo_onu']) . "', serie = '" . addslashes($_POST['serie']) . "', mac_address = '" . addslashes($_POST['mac_address']) . "', encapsulamiento = '" . addslashes($_POST['encapsulamiento']) . "', winbox = '" . addslashes($_POST['registro_winbox']) . "', mac_winbox = '" . addslashes($_POST['mac_winbox']) . "', plan_datos = '" . addslashes($_POST['plan_datos']) . "', vlan = '" . addslashes($_POST['vlan']) . "', resguardo = '" . addslashes($_POST['resguardo']) . "', fecha_registro = '" . $fecha . "', hora_registro = '" . $hora . "', estatus = 'PROCESO' , pasos = 'Reporte_modificacion'  WHERE id_cliente = '" . addslashes($_POST['id_cliente_confInternet']) . "' AND id = '" . addslashes($_POST['id_confInternet']) . "'";
// 	devolverValorQuery($query);
// }

if (isset($_POST['id_confInternet']) && isset($_POST['id_cliente_confInternet']) && isset($_POST['no_olt']) && isset($_POST['no_caja']) && isset($_POST['no_pon']) && isset($_POST['marca_onu']) && isset($_POST['modelo_onu']) && isset($_POST['serie']) && isset($_POST['mac_address']) && isset($_POST['encapsulamiento']) &&  isset($_POST['vlan'])) {

	date_default_timezone_set('America/Mexico_City');
	$fecha = date('Y-m-d');
	$hora = date('H:i:s');

	$query = "UPDATE conf_internet SET no_olt = '" . addslashes($_POST['no_olt']) . "', no_caja = '" . addslashes($_POST['no_caja']) . "', no_pon = '" . addslashes($_POST['no_pon']) . "', marca_onu = '" . addslashes($_POST['marca_onu']) . "', modelo = '" . addslashes($_POST['modelo_onu']) . "', serie = '" . addslashes($_POST['serie']) . "', mac_address = '" . addslashes($_POST['mac_address']) . "', encapsulamiento = '" . addslashes($_POST['encapsulamiento']) . "', vlan = '" . addslashes($_POST['vlan']) . "', fecha_registro = '" . $fecha . "', hora_registro = '" . $hora . "', estatus = 'PROCESO' , pasos = 'Reporte_modificacion'  WHERE id_cliente = '" . addslashes($_POST['id_cliente_confInternet']) . "' AND id = '" . addslashes($_POST['id_confInternet']) . "'";
	devolverValorQuery($query);
}

// if (isset($_POST['id_confInternet']) && isset($_POST['id_cliente_confInternet']) && isset($_POST['no_olt']) && isset($_POST['no_caja']) && isset($_POST['no_pon']) && isset($_POST['marca_onu']) && isset($_POST['modelo_onu']) && isset($_POST['serie']) && isset($_POST['mac_address']) && isset($_POST['encapsulamiento']) && isset($_POST['registro_winbox']) && isset($_POST['mac_winbox']) && isset($_POST['plan_datos']) && isset($_POST['vlan']) && isset($_POST['resguardo']) && isset($_POST['salida_nap']) && isset($_POST['potencia_SDivisor']) && isset($_POST['potencia_llCasa']) && isset($_POST['ip_instalacion'])) {

// 	date_default_timezone_set('America/Mexico_City');
// 	$fecha = date('Y-m-d');
// 	$hora = date('H:i:s');

// 	$query = "UPDATE conf_internet SET no_olt = '" . addslashes($_POST['no_olt']) . "', no_caja = '" . addslashes($_POST['no_caja']) . "', no_pon = '" . addslashes($_POST['no_pon']) . "', marca_onu = '" . addslashes($_POST['marca_onu']) . "', modelo = '" . addslashes($_POST['modelo_onu']) . "', serie = '" . addslashes($_POST['serie']) . "', mac_address = '" . addslashes($_POST['mac_address']) . "', encapsulamiento = '" . addslashes($_POST['encapsulamiento']) . "', winbox = '" . addslashes($_POST['registro_winbox']) . "', mac_winbox = '" . addslashes($_POST['mac_winbox']) . "', plan_datos = '" . addslashes($_POST['plan_datos']) . "', vlan = '" . addslashes($_POST['vlan']) . "', ip_asignada_instalacion =  '" . addslashes($_POST['ip_instalacion']) . "', resguardo = '" . addslashes($_POST['resguardo']) . "', salida_nap = '" . addslashes($_POST['salida_nap']) . "', potencia_salida_divisor = '" . addslashes($_POST['potencia_SDivisor']) . "', potencia_llegada_casa = '" . addslashes($_POST['potencia_llCasa']) . "', fecha_registro = '" . $fecha . "', hora_registro = '" . $hora . "', estatus = 'PROCESO' , pasos = 'Cierre_reporte'  WHERE id_cliente = '" . addslashes($_POST['id_cliente_confInternet']) . "' AND id = '" . addslashes($_POST['id_confInternet']) . "'";
// 	devolverValorQuery($query);
// }

if (isset($_POST['id_confInternet']) && isset($_POST['id_cliente_confInternet']) && isset($_POST['no_olt']) && isset($_POST['no_caja']) && isset($_POST['no_pon']) && isset($_POST['marca_onu']) && isset($_POST['modelo_onu']) && isset($_POST['serie']) && isset($_POST['mac_address']) && isset($_POST['encapsulamiento']) && isset($_POST['registro_winbox']) && isset($_POST['mac_winbox']) && isset($_POST['plan_datos']) && isset($_POST['vlan']) && isset($_POST['resguardo']) && isset($_POST['salida_nap']) && isset($_POST['potencia_SDivisor']) && isset($_POST['potencia_llCasa']) && isset($_POST['ip_instalacion'])) {

	date_default_timezone_set('America/Mexico_City');
	$fecha = date('Y-m-d');
	$hora = date('H:i:s');

	$query = "UPDATE conf_internet SET no_olt = '" . addslashes($_POST['no_olt']) . "', no_caja = '" . addslashes($_POST['no_caja']) . "', no_pon = '" . addslashes($_POST['no_pon']) . "', marca_onu = '" . addslashes($_POST['marca_onu']) . "', modelo = '" . addslashes($_POST['modelo_onu']) . "', serie = '" . addslashes($_POST['serie']) . "', mac_address = '" . addslashes($_POST['mac_address']) . "', encapsulamiento = '" . addslashes($_POST['encapsulamiento']) . "', winbox = '" . addslashes($_POST['registro_winbox']) . "', mac_winbox = '" . addslashes($_POST['mac_winbox']) . "', plan_datos = '" . addslashes($_POST['plan_datos']) . "', vlan = '" . addslashes($_POST['vlan']) . "', ip_asignada_instalacion =  '" . addslashes($_POST['ip_instalacion']) . "', resguardo = '" . addslashes($_POST['resguardo']) . "', salida_nap = '" . addslashes($_POST['salida_nap']) . "', potencia_salida_divisor = '" . addslashes($_POST['potencia_SDivisor']) . "', potencia_llegada_casa = '" . addslashes($_POST['potencia_llCasa']) . "', fecha_registro = '" . $fecha . "', hora_registro = '" . $hora . "', estatus = 'PROCESO' , pasos = 'Cierre_reporte'  WHERE id_cliente = '" . addslashes($_POST['id_cliente_confInternet']) . "' AND id = '" . addslashes($_POST['id_confInternet']) . "'";
	devolverValorQuery($query);
}
?>