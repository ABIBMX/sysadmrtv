<?php
include("../config.php");
include("../conexion.php");

if (isset($_POST['sucursal'])) {
	if (isset($_POST['tap'])) {
		$query = "select id_tap, valor, salidas from tap where eliminado = 0 AND id_sucursal='" . addslashes($_POST['sucursal']) . "'";
		$tabla = mysqli_query($conexion, $query);
		echo "<select name='tap' style='width:300px;font-size:12px;'><option value='null'>Sin asignar</option>";
		while ($registro = mysqli_fetch_array($tabla)) {
			echo "<option value=\"" . $registro[0] . "\">" . $registro[0] . " - " . $registro[1] . " - " . $registro[2] . "</option>";
		}

		echo "</select>";
	} else {
		$query = "select id_calle,nombre from cat_calles where id_sucursal='" . addslashes($_POST['sucursal']) . "'";
		$tabla = mysqli_query($conexion, $query);
		echo "<select name='calle' style='width:300px;font-size:12px;'><option value='null'>Seleccione una Calle</option>";
		while ($registro = mysqli_fetch_array($tabla)) {
			echo "<option value=\"" . $registro[0] . "\">" . $registro[1] . "</option>";
		}

		echo "</select>";
	}
}

if (isset($_POST['cliente'])) {
	$bandera_si_nombre = false;
	$_POST['cliente'] = addslashes($_POST['cliente']);

	if (isset($_POST['s']))
		$add_query = " and id_sucursal='" . addslashes($_POST['s']) . "'";

	$query = "select id_cliente,id_sucursal, concat(nombre,' ',apellido_paterno,' ',apellido_materno) from clientes where (concat(nombre,' ',apellido_paterno,' ',apellido_materno) like '%" . addslashes($_POST['cliente']) . "%' or id_cliente like '%" . addslashes($_POST['cliente']) . "%') " . $add_query;
	$tabla = mysqli_query($conexion, $query);

	while ($registro = mysqli_fetch_array($tabla)) {
		$bandera = true;
?>
		<div>
			<div class="id"><?php echo $registro[0]; ?></div>
			<div class="sucursal"><?php echo $registro[1]; ?></div>
			<div class="nombre"><?php echo $registro[2]; ?></div>
		</div>
	<?php
	}
	if (!$bandera) {
	?>
		<div>
			<center>No hay resultados para esta b&uacute;squeda.</center>
		</div>
<?php
	}
}

if (isset($_POST['cliente']) && isset($_POST['no_olt']) && isset($_POST['no_caja']) && isset($_POST['no_pon']) && isset($_POST['marca_onu']) && isset($_POST['modelo_onu']) && isset($_POST['serie']) && isset($_POST['mac_address']) && isset($_POST['encapsulamiento']) && isset($_POST['registro_winbox']) && isset($_POST['mac_winbox']) && isset($_POST['plan_datos']) && isset($_POST['vlan']) && isset($_POST['ip_instalacion'])  && isset($_POST['resguardo']) && isset($_POST['snap']) && isset($_POST['psdivisor']) && isset($_POST['plldomicilio']) ) {

	//verificar si tiene otro registro de datos de internet

	$queryCI = "select * from conf_internet where estatus = 'ACTUAL' AND pasos = 'Finalizado' AND id_cliente='" . addslashes($_POST['cliente']) . "'";

	$registroCI = devolverValorQuery($queryCI);

	if ($registroCI) {

		// $query = "update conf_internet set no_olt='".addslashes($_POST['no_olt'])."', no_caja='".addslashes($_POST['no_caja'])."', no_pon='".addslashes($_POST['no_pon'])."', marca_onu='".addslashes($_POST['marca_onu'])."', serie='".addslashes($_POST['serie'])."', mac_address='".addslashes($_POST['mac_address'])."', encapsulamiento='".addslashes($_POST['encapsulamiento'])."', registro_winbox='".addslashes($_POST['registro_winbox'])."', mac_winbox='".addslashes($_POST['mac_winbox'])."', plan_datos='".addslashes($_POST['plan_datos'])."', ip_instalacion='".addslashes($_POST['ip_instaalcion'])."' where id_cliente='".addslashes($_POST['cliente'])."'";

		$queryOld = "UPDATE conf_internet SET estatus = 'ANTERIOR', pasos = 'Finalizado'  WHERE id_cliente='" . addslashes($_POST['cliente']) . "' AND id = '" . $registroCI['id'] . "'";
		devolverValorQuery($queryOld);
	}

	date_default_timezone_set('America/Mexico_City');
	$fecha = date('Y-m-d');
	$hora = date('H:i:s');

	$query = "INSERT INTO conf_internet (id,id_cliente,no_olt,no_caja,no_pon,marca_onu,modelo,serie,mac_address,encapsulamiento,winbox,mac_winbox,plan_datos,vlan,ip_asignada_instalacion,resguardo,salida_nap,potencia_salida_divisor,potencia_llegada_casa,fecha_registro,hora_registro,estatus,pasos)
	 values 
	 (0,'" . addslashes($_POST['cliente']) . "','" . addslashes($_POST['no_olt']) . "','" . addslashes($_POST['no_caja']) . "','" . addslashes($_POST['no_pon']) . "','" . addslashes($_POST['marca_onu']) . "','" . addslashes($_POST['modelo_onu']) . "','" . addslashes($_POST['serie']) . "','" . addslashes($_POST['mac_address']) . "',
	 '" . addslashes($_POST['encapsulamiento']) . "','" . addslashes($_POST['registro_winbox']) . "','" . addslashes($_POST['mac_winbox']) . "','" . addslashes($_POST['plan_datos']) . "','" . addslashes($_POST['vlan']) . "','" . addslashes($_POST['ip_instalacion']) . "','" . addslashes($_POST['resguardo']) . "','" . addslashes($_POST['snap']) . "',
	 '" . addslashes($_POST['psdivisor']) . "','" . addslashes($_POST['plldomicilio']) . "', '" . $fecha . "','" . $hora . "','ACTUAL', 'Finalizado')";

	devolverValorQuery($query);

	$query2 = "UPDATE clientes SET configuracion_internet = 'SI' WHERE id_cliente='" . addslashes($_POST['cliente']) . "'";
	devolverValorQuery($query2);
}

?>