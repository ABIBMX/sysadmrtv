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
		$cadena .= "<option value=\"" . $registro[0] . "\">" . $registro[1] . " - $ " . $registro[2] . "</option>";
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
			echo "<option value=\"$registro_t_u[0]\">$registro_t_u[2]</option>";
		}
		?>
	</select>
<?php
}


//===================== Esto es para traer el telefono , tarifa y curp del cliente 

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

			echo "<td>Tarifa: </td><td><input type='text' disabled style='margin-top:4px;margin-bottom:2px;width:100px' name='tarifa_cliente' value='" . $resultado_datos['tarifa'] . "' oninput=\"this.value=this.value.replace(/[^0-9.]/g,'')\"/></td>";
		} else {
			echo "<td>Tarifa: </td><td><input type='text' disabled style='margin-top:4px;margin-bottom:2px;width:300px' name='tarifa_cliente' value='' placeholder='El cliente no cuenta con una tarifa' oninput=\"this.value=this.value.replace(/[^0-9.]/g,'')\"/></td>";
		}
	}
}

if (isset($_POST['cliente_curp'])) {

	$consulta_tarifa = "SELECT rfc FROM clientes WHERE id_cliente = '" . $_POST['cliente_curp'] . "'";
	$resultado = mysqli_query($conexion, $consulta_tarifa);

	while ($resultado_datos = mysqli_fetch_array($resultado)) {

		if ($resultado_datos['rfc'] != "" || $resultado_datos['rfc'] != null) {

			echo "<td>Curp: </td><td><input type='text'  style='margin-top:4px;margin-bottom:2px;width:200px;text-transform:uppercase;' name='curp_cliente' value='" . $resultado_datos['rfc'] . "' minlength='18' maxlength='18' placeholder='CURP de 18 caracteres'/></td>";
		} else {
			echo "<td>Curp: </td><td><input type='text'  style='margin-top:4px;margin-bottom:2px;width:200px;text-transform:uppercase;' name='curp_cliente' value='' minlength='18' maxlength='18' placeholder='El cliente no cuenta con su CURP'/></td>";
		}
	}
}


//===================== Esto es para traer las categorias deacuerdo al tipo de servicio

if (isset($_POST['categoria_concepto']) && isset($_POST['fila']) && isset($_POST['cliente'])) {

	$tipoServicio = $_POST['categoria_concepto'];
	$fila = $_POST['fila'];
	$cliente = $_POST['cliente'];

	//validando que es un cliente nuevo 

	$queryClienteIngreso = "SELECT id_ingreso FROM ingresos WHERE id_cliente = '$cliente'";
	$resultIngreso = mysqli_query($conexion, $queryClienteIngreso);

	$queryClienteReporte = "SELECT id_reporte FROM reporte_servicios WHERE id_cliente = '$cliente'";
	$resultReporte = mysqli_query($conexion, $queryClienteReporte);

	if (mysqli_num_rows($resultIngreso) > 0 || mysqli_num_rows($resultReporte) > 0) {
		echo "<td>Categorias: </td><td>
        <select name='Categorias_$fila' style='width:300px; font-size:12px;' onchange=\"cargarConcepto(this.value,'" . $tipoServicio  . "','" . $fila  . "');\">
            <option value='' selected>Selecciona una opción</option>";

		if ($tipoServicio !== 'INTERNET') {
			echo "<option value='CONTRATACION DE ADICIONALES'>CONTRATACION DE ADICIONALES</option>";
		}

		if ($tipoServicio !== 'COBRE') {
			echo "<option value='CAMBIO DE SERVICIO'>CAMBIO DE SERVICIO</option>";
		}

		echo "<option value='SUSPENSIONES'>SUSPENSIONES</option>
          <option value='RECONEXIONES'>RECONEXIONES</option>
          <option value='CANCELACIONES'>CANCELACIONES</option>
          <option value='CAMBIO DE DOMICILIO'>CAMBIO DE DOMICILIO</option>
          <option value='PAGO DE MENSUALIDADES'>PAGO DE MENSUALIDADES</option>
        </select>
      </td>";
	} else {
		echo "<td>Categorias: </td>
          <td>
            <select name='Categorias_$fila' style='width:300px; font-size:12px;' onchange=\"cargarConcepto(this.value, '$tipoServicio', '$fila');\">
                <option value='' selected>Selecciona una opción</option>
                <option value='INSCRIPCIONES'>INSCRIPCIONES</option>";

		if ($tipoServicio !== 'INTERNET') {
			echo "<option value='CONTRATACION DE ADICIONALES'>CONTRATACION DE ADICIONALES</option>";
		}

		// Cierre siempre fuera del if
		echo "</select>
          </td>";
	}
}


//===================== Esto es para traer el concepto basado en el tipo de servicio y categoria

if (isset($_POST['categoria']) && isset($_POST['servicio']) && isset($_POST['fila'])) {

	$categoria = $_POST['categoria'];
	$servicio  = $_POST['servicio'];
	$fila      = $_POST['fila'];

	$query = "SELECT id_tipo_ingreso, descripcion 
              FROM cat_tipo_ingreso 
              WHERE tipo_Servicio = '$servicio' 
              AND categoria = '$categoria' 
              AND estado = 'Activo'";

	$result = mysqli_query($conexion, $query);
	if ($result) {
		echo " &nbsp;Concepto : ";
		echo "<select name='conceptoIngreso_$fila' id='conceptoIngreso_$fila' style='width:250px; font-size:12px;' onchange=\"cargarMontoConcepto(this.value, $fila);\">";
		echo "<option value='null'>Seleccione un concepto</option>";
		while (list($id, $concepto) = mysqli_fetch_array($result)) {
			echo "<option value='$id'>$concepto</option>";
		}
		echo "</select><br>";
	}
}


//===================== Esto es para traer el tipo de monto , basado en el concepto seleccionado

//comentarios a resolver

//1. Para las suspensiones, no es necesario registrar un ingreso cuando no tiene adeudo , ahi se le indicaria con una leyenda? manejar un centavo
//2. Ver el tema de reconexion cuando tiene adeudo esta bien como sume ambos conceptos? 
//3. Mismo caso para cancelacion basado en suspension que pasa cuando no tiene adeudo ? manejar un centavo
//4. Para el tema de audos comentaba que luego no ceseariamente van a tomar el adeudo total puede ser parcial, cuando es asi como se comportaria, solo es suspension, pago de mensualidad, reconexion
//idea mia, poner un campo para que pongan la cantidad a cobrar y un check que se marque indicando que es pago parcial, dejando la cuenta del cliente en ceros y afectando a caja.

if (isset($_POST['Monto']) && isset($_POST['cliente']) && isset($_POST['fila'])) {

	$idConcepto = $_POST['Monto'];
	$cliente = $_POST['cliente'];
	$fila = $_POST['fila'];

	$query = "SELECT id_tipo_ingreso,tipo_Servicio,categoria,descripcion,Tarifa_Inscripcion,Tarifa_Mensualidad
              FROM cat_tipo_ingreso 
              WHERE id_tipo_ingreso = '$idConcepto'";

	$result = mysqli_query($conexion, $query);



	if ($result && $row = mysqli_fetch_assoc($result)) {

		// switch case para clasificar deacuerdo al tipo de servicio y categoria

		$tipoServicio = $row['tipo_Servicio'];
		$categoria    = $row['categoria'];
		$descripcion = $row['descripcion'];
		$Tarifa_Inscripcion = $row['Tarifa_Inscripcion'];
		$Tarifa_Mensualidad = $row['Tarifa_Mensualidad'];

		switch ($tipoServicio) {

			case 'COBRE':

				switch ($categoria) {

					case 'INSCRIPCIONES':

						echo " &nbsp;Monto de Inscripción : ";
						echo "<input type='text' readonly style='margin-top:4px;margin-bottom:2px;width:200px;text-transform:uppercase;' id='montoIngreso_$fila' name='montoIngreso_$fila' value='" . $Tarifa_Inscripcion . "'/>";
						break;

					case 'CONTRATACION DE ADICIONALES':
						echo " &nbsp;Monto de Adicional : ";
						echo "<input type='text' readonly style='margin-top:4px;margin-bottom:2px;width:200px;text-transform:uppercase;' id='montoIngreso_$fila' name='montoIngreso_$fila' value='" . $Tarifa_Inscripcion . "'/>";
						break;

					case 'SUSPENSIONES':

						//obtener el adeudo del cliente
						$query = "SELECT id_transaccion,id_cliente,id_concepto,cargo,saldo_anterior,saldo_actual,fecha_transaccion
              			FROM transacciones 
              			WHERE id_cliente = '$cliente' ORDER BY id_transaccion DESC LIMIT 1";

						$result = mysqli_query($conexion, $query);

						if ($result && $row = mysqli_fetch_assoc($result)) {

							$idTransaccion = $row['id_transaccion'];
							$idCliente    = $row['id_cliente'];
							$concepto = $row['id_concepto'];
							$cargo = $row['cargo'];
							$saldoAnterior = $row['saldo_anterior'];
							$saldoActual = $row['saldo_actual'];
							$fechaTransaccion = $row['fecha_transaccion'];

							if ($concepto == 1) {

								echo " &nbsp;Monto de Adeudo : ";
								echo "<input type='text' readonly style='margin-top:4px;margin-bottom:2px;width:200px;text-transform:uppercase;' id='montoIngreso_$fila' name='montoIngreso_$fila' value='" . $saldoActual . "'/>";
							} else {
								echo " &nbsp;Monto de Adeudo : ";
								echo "<input type='text' readonly  style='margin-top:4px;margin-bottom:2px;width:200px;text-transform:uppercase;' id='montoIngreso_$fila' name='montoIngreso_$fila' value='" . $saldoActual . "'/>";
							}
						}
						break;

					case 'RECONEXIONES':

						//obtener el adeudo del cliente
						$query = "SELECT id_transaccion,id_cliente,id_concepto,cargo,saldo_anterior,saldo_actual,fecha_transaccion
              			FROM transacciones 
              			WHERE id_cliente = '$cliente' ORDER BY id_transaccion DESC LIMIT 1";

						$result = mysqli_query($conexion, $query);

						if ($result && $row = mysqli_fetch_assoc($result)) {

							$idTransaccion = $row['id_transaccion'];
							$idCliente    = $row['id_cliente'];
							$concepto = $row['id_concepto'];
							$cargo = $row['cargo'];
							$saldoAnterior = $row['saldo_anterior'];
							$saldoActual = $row['saldo_actual'];
							$fechaTransaccion = $row['fecha_transaccion'];

							if ($concepto == 1) {

								echo "<div style='margin-bottom:12px;'>
        								<label for='montoAdeudo_$fila'>Monto de Adeudo:</label><br>
        								<input type='text' id='montoAdeudo_$fila' readonly style='margin-top:4px;width:200px;text-transform:uppercase;' name='montoAdeudo_$fila' value='" . $saldoActual . "'/>
									</div>";

								echo "<div style='margin-bottom:12px;'>
        								<label for='montoReconexion_$fila'>Monto Reconexion:</label><br>
        								<input type='text' id='montoReconexion_$fila' readonly style='margin-top:4px;width:200px;text-transform:uppercase;' name='montoReconexion_$fila' value='" . $Tarifa_Inscripcion . "'/>
									</div>";

								$subtotal = $saldoActual + $Tarifa_Inscripcion;

								echo "<div style='margin-bottom:12px;'>
										<label for='montoIngreso_$fila'>Total Ambos Conceptos:</label><br>
        								<input type='text' readonly style='margin-top:4px;width:200px;text-transform:uppercase;' id='montoIngreso_$fila' name='montoIngreso_$fila' value='" . $subtotal . "'/>
									</div>";
							} else {

								echo "<div style='margin-bottom:12px;'>
        								<label for='adeudo_$fila'>Cliente NO CUENTA CON ADEUDO, SOLO SE COBRARA LA RECONEXION</label><br>
									</div>";

								echo "<div style='margin-bottom:12px;'>
										<label for='montoIngreso_$fila'>Monto  Reconexion: </label><br>
        								<input type='text' readonly style='margin-top:4px;width:200px;text-transform:uppercase;' id='montoIngreso_$fila' name='montoIngreso_$fila' value='" . $Tarifa_Inscripcion . "'/>
									</div>";
							}
						}

						break;

					case 'CANCELACIONES':

						//obtener el adeudo del cliente
						$query = "SELECT id_transaccion,id_cliente,id_concepto,cargo,saldo_anterior,saldo_actual,fecha_transaccion
              			FROM transacciones 
              			WHERE id_cliente = '$cliente' ORDER BY id_transaccion DESC LIMIT 1";

						$result = mysqli_query($conexion, $query);

						if ($result && $row = mysqli_fetch_assoc($result)) {

							$idTransaccion = $row['id_transaccion'];
							$idCliente    = $row['id_cliente'];
							$concepto = $row['id_concepto'];
							$cargo = $row['cargo'];
							$saldoAnterior = $row['saldo_anterior'];
							$saldoActual = $row['saldo_actual'];
							$fechaTransaccion = $row['fecha_transaccion'];

							if ($concepto == 1) {
								echo "<div style='margin-bottom:12px;'>
										<label for='montoIngreso_$fila'>Saldo Pendiente:</label><br>
        								<input type='text' readonly style='margin-top:4px;width:200px;text-transform:uppercase;' id='montoIngreso_$fila' name='montoIngreso_$fila' value='" . $saldoActual . "'/>
									</div>";
							} else {

								echo "<div style='margin-bottom:12px;'>
										<label for='montoIngreso_$fila'>Saldo Pendiente:</label><br>
        								<input type='text' readonly style='margin-top:4px;width:200px;text-transform:uppercase;' id='montoIngreso_$fila' name='montoIngreso_$fila' value='" . $saldoActual . "'/>
									</div>";
							}
						}
						break;

					case 'CAMBIO DE DOMICILIO':
						echo " &nbsp;Monto de Cambio de domicilio : ";
						echo "<input type='text' readonly  style='margin-top:4px;margin-bottom:2px;width:200px;text-transform:uppercase;' id='montoIngreso_$fila' name='montoIngreso_$fila' value='" . $Tarifa_Inscripcion . "'/>";
						break;

					case 'PAGO DE MENSUALIDADES':

						//obtener el adeudo del cliente
						$query = "SELECT id_transaccion,id_cliente,id_concepto,cargo,saldo_anterior,saldo_actual,fecha_transaccion
              			FROM transacciones 
              			WHERE id_cliente = '$cliente' ORDER BY id_transaccion DESC LIMIT 1";

						$result = mysqli_query($conexion, $query);

						if ($result && $row = mysqli_fetch_assoc($result)) {

							$idTransaccion = $row['id_transaccion'];
							$idCliente    = $row['id_cliente'];
							$concepto = $row['id_concepto'];
							$cargo = $row['cargo'];
							$saldoAnterior = $row['saldo_anterior'];
							$saldoActual = $row['saldo_actual'];
							$fechaTransaccion = $row['fecha_transaccion'];

							if ($concepto == 1) {
								echo "<div style='margin-bottom:12px;'>
										<label for='montoIngreso_$fila'>Mensualidad del cliente:</label><br>
        								<input type='text' readonly style='margin-top:4px;width:200px;text-transform:uppercase;' id='montoIngreso_$fila' name='montoIngreso_$fila' value='" . $saldoActual . "'/>
									</div>";
							} else {

								if ($saldoActual > 0) {
									echo "<div style='margin-bottom:12px;'>
										<label for='montoIngreso_$fila'>Adeudo del Cliente:</label><br>
										<input type='text' readonly style='margin-top:4px;width:200px;text-transform:uppercase;' id='montoIngreso_$fila' name='montoIngreso_$fila' value='" . $saldoActual . "'/>
									</div>";
								} else {
									echo "<div style='margin-bottom:12px;'>
        								<label for=''>Cliente NO CUENTA CON ADEUDO, Valida si se ha generado su corte</label><br>
									</div>";
								}
							}
						}
						break;

					default:
						echo " &nbsp;Valida tu seleccion ";
						break;
				}

				break;

			case 'TV CON FIBRA':

				switch ($categoria) {

					case 'INSCRIPCIONES':
						echo " &nbsp;Monto de Inscripción : ";
						echo "<input type='text' readonly  style='margin-top:4px;margin-bottom:2px;width:200px;text-transform:uppercase;' id='montoIngreso_$fila' name='montoIngreso_$fila' value='" . $Tarifa_Inscripcion . "'/>";
						break;

					case 'CONTRATACION DE ADICIONALES':
						echo " &nbsp;Monto de Adicional : ";
						echo "<input type='text' readonly style='margin-top:4px;margin-bottom:2px;width:200px;text-transform:uppercase;' id='montoIngreso_$fila' name='montoIngreso_$fila' value='" . $Tarifa_Inscripcion . "'/>";
						break;

					case 'SUSPENSIONES':

						//obtener el adeudo del cliente
						$query = "SELECT id_transaccion,id_cliente,id_concepto,cargo,saldo_anterior,saldo_actual,fecha_transaccion
              			FROM transacciones 
              			WHERE id_cliente = '$cliente' ORDER BY id_transaccion DESC LIMIT 1";

						$result = mysqli_query($conexion, $query);

						if ($result && $row = mysqli_fetch_assoc($result)) {

							$idTransaccion = $row['id_transaccion'];
							$idCliente    = $row['id_cliente'];
							$concepto = $row['id_concepto'];
							$cargo = $row['cargo'];
							$saldoAnterior = $row['saldo_anterior'];
							$saldoActual = $row['saldo_actual'];
							$fechaTransaccion = $row['fecha_transaccion'];

							if ($concepto == 1) {

								echo " &nbsp;Monto de Adeudo : ";
								echo "<input type='text' readonly  style='margin-top:4px;margin-bottom:2px;width:200px;text-transform:uppercase;' id='montoIngreso_$fila' name='montoIngreso_$fila' value='" . $saldoActual . "'/>";
							} else {
								echo " &nbsp;Monto de Adeudo : ";
								echo "<input type='text' readonly  style='margin-top:4px;margin-bottom:2px;width:200px;text-transform:uppercase;' id='montoIngreso_$fila'  name='montoIngreso_$fila' value='" . $saldoActual . "'/>";
							}
						}
						break;

					case 'RECONEXIONES':
						//obtener el adeudo del cliente
						$query = "SELECT id_transaccion,id_cliente,id_concepto,cargo,saldo_anterior,saldo_actual,fecha_transaccion
              			FROM transacciones 
              			WHERE id_cliente = '$cliente' ORDER BY id_transaccion DESC LIMIT 1";

						$result = mysqli_query($conexion, $query);

						if ($result && $row = mysqli_fetch_assoc($result)) {

							$idTransaccion = $row['id_transaccion'];
							$idCliente    = $row['id_cliente'];
							$concepto = $row['id_concepto'];
							$cargo = $row['cargo'];
							$saldoAnterior = $row['saldo_anterior'];
							$saldoActual = $row['saldo_actual'];
							$fechaTransaccion = $row['fecha_transaccion'];

							if ($concepto == 1) {

								echo "<div style='margin-bottom:12px;'>
        								<label for='montoAdeudo_$fila'>Monto de Adeudo:</label><br>
        								<input type='text' id='montoAdeudo_$fila' readonly='readonly' style='margin-top:4px;width:200px;text-transform:uppercase;' name='montoAdeudo_$fila' value='" . $saldoActual . "'/>
									</div>";

								echo "<div style='margin-bottom:12px;'>
        								<label for='montoReconexion_$fila'>Monto Reconexion:</label><br>
        								<input type='text' id='montoReconexion_$fila' readonly='readonly' style='margin-top:4px;width:200px;text-transform:uppercase;' name='montoReconexion_$fila' value='" . $Tarifa_Inscripcion . "'/>
									</div>";

								$subtotal = $saldoActual + $Tarifa_Inscripcion;

								echo "<div style='margin-bottom:12px;'>
										<label for='montoIngreso_$fila'>Total Ambos Conceptos:</label><br>
        								<input type='text' readonly id='montoIngreso_$fila' style='margin-top:4px;width:200px;text-transform:uppercase;' name='montoIngreso_$fila' value='" . $subtotal . "'/>
									</div>";
							} else {

								echo "<div style='margin-bottom:12px;'>
        								<label for='adeudo_$fila'>Cliente NO CUENTA CON ADEUDO, SOLO SE COBRARA LA RECONEXION</label><br>
									</div>";

								echo "<div style='margin-bottom:12px;'>
										<label for='montoIngreso_$fila'>Monto  Reconexion: </label><br>
        								<input type='text' readonly id='montoIngreso_$fila' readonly='readonly' style='margin-top:4px;width:200px;text-transform:uppercase;' name='montoIngreso_$fila' value='" . $Tarifa_Inscripcion . "'/>
									</div>";
							}
						}
						break;

					case 'CANCELACIONES':

						//obtener el adeudo del cliente
						$query = "SELECT id_transaccion,id_cliente,id_concepto,cargo,saldo_anterior,saldo_actual,fecha_transaccion
              			FROM transacciones 
              			WHERE id_cliente = '$cliente' ORDER BY id_transaccion DESC LIMIT 1";

						$result = mysqli_query($conexion, $query);

						if ($result && $row = mysqli_fetch_assoc($result)) {

							$idTransaccion = $row['id_transaccion'];
							$idCliente    = $row['id_cliente'];
							$concepto = $row['id_concepto'];
							$cargo = $row['cargo'];
							$saldoAnterior = $row['saldo_anterior'];
							$saldoActual = $row['saldo_actual'];
							$fechaTransaccion = $row['fecha_transaccion'];

							if ($concepto == 1) {
								echo "<div style='margin-bottom:12px;'>
										<label for='montoIngreso_$fila'>Saldo Pendiente:</label><br>
        								<input type='text' readonly id='montoIngreso_$fila' style='margin-top:4px;width:200px;text-transform:uppercase;' name='montoIngreso_$fila' value='" . $saldoActual . "'/>
									</div>";
							} else {

								echo "<div style='margin-bottom:12px;'>
										<label for='montoIngreso_$fila'>Saldo Pendiente:</label><br>
        								<input type='text' readonly id='montoIngreso_$fila' style='margin-top:4px;width:200px;text-transform:uppercase;' name='montoIngreso_$fila' value='" . $saldoActual . "'/>
									</div>";
							}
						}
						break;

					case 'CAMBIO DE DOMICILIO':
						echo " &nbsp;Monto de Cambio de domicilio : ";
						echo "<input type='text' readonly  style='margin-top:4px;margin-bottom:2px;width:200px;text-transform:uppercase;' id='montoIngreso_$fila'  name='montoIngreso_$fila' value='" . $Tarifa_Inscripcion . "'/>";
						break;

					case 'PAGO DE MENSUALIDADES':
						//obtener el adeudo del cliente
						$query = "SELECT id_transaccion,id_cliente,id_concepto,cargo,saldo_anterior,saldo_actual,fecha_transaccion
              			FROM transacciones 
              			WHERE id_cliente = '$cliente' ORDER BY id_transaccion DESC LIMIT 1";

						$result = mysqli_query($conexion, $query);

						if ($result && $row = mysqli_fetch_assoc($result)) {

							$idTransaccion = $row['id_transaccion'];
							$idCliente    = $row['id_cliente'];
							$concepto = $row['id_concepto'];
							$cargo = $row['cargo'];
							$saldoAnterior = $row['saldo_anterior'];
							$saldoActual = $row['saldo_actual'];
							$fechaTransaccion = $row['fecha_transaccion'];

							if ($concepto == 1) {
								echo "<div style='margin-bottom:12px;'>
										<label for='montoIngreso_$fila'>Mensualidad del cliente:</label><br>
        								<input type='text' readonly id='montoIngreso_$fila' style='margin-top:4px;width:200px;text-transform:uppercase;' name='montoIngreso_$fila' value='" . $saldoActual . "'/>
									</div>";
							} else {

								if ($saldoActual > 0) {
									echo "<div style='margin-bottom:12px;'>
										<label for='montoIngreso_$fila'>Adeudo del Cliente:</label><br>
										<input type='text' readonly id='montoIngreso_$fila' style='margin-top:4px;width:200px;text-transform:uppercase;' name='montoIngreso_$fila' value='" . $saldoActual . "'/>
									</div>";
								} else {
									echo "<div style='margin-bottom:12px;'>
										<label for=''>Cliente NO CUENTA CON ADEUDO, Valida si se ha generado su corte</label><br>
									</div>";
								}
							}
						}
						break;

					case 'CAMBIO DE SERVICIO':

						switch ($descripcion) {

							case 'CLIENTE CON INTERNET (QUITA INTERNET Y AGREGA TV)':
								echo " &nbsp;Monto por cambio de Servicio : ";
								echo "<input type='text' readonly  style='margin-top:4px;margin-bottom:2px;width:200px;text-transform:uppercase;' id='montoIngreso_$fila' name='montoIngreso_$fila' value='" . $Tarifa_Inscripcion . "'/>";
								break;

							case 'CLIENTE CON TV E INTERNET (QUITA INTERNET Y DEJA SOLO TV)':
								echo " &nbsp;Monto por cambio de Servicio : ";
								echo "<input type='text' readonly style='margin-top:4px;margin-bottom:2px;width:200px;text-transform:uppercase;' id='montoIngreso_$fila'  name='montoIngreso_$fila' value='" . $Tarifa_Inscripcion . "'/>";
								break;

							case 'CLIENTE CON TV X COBRE CAMBIA A TV X FIBRA':
								echo " &nbsp;Monto por cambio de Servicio : ";
								echo "<input type='text' readonly style='margin-top:4px;margin-bottom:2px;width:200px;text-transform:uppercase;' id='montoIngreso_$fila' name='montoIngreso_$fila' value='" . $Tarifa_Inscripcion . "'/>";
								break;

							default:
								echo " &nbsp;Valida tu seleccion ";
								break;
						}

						break;

					default:
						echo " &nbsp;Valida tu seleccion ";
						break;
				}
				break;

			case 'TVINTERNET':

				switch ($categoria) {

					case 'INSCRIPCIONES':
						echo " &nbsp;Monto de Inscripción : ";
						echo "<input type='text' readonly  style='margin-top:4px;margin-bottom:2px;width:200px;text-transform:uppercase;' id='montoIngreso_$fila'  name='montoIngreso_$fila' value='" . $Tarifa_Inscripcion . "'/>";
						break;

					case 'CONTRATACION DE ADICIONALES':
						echo " &nbsp;Monto de Adicional : ";
						echo "<input type='text' readonly style='margin-top:4px;margin-bottom:2px;width:200px;text-transform:uppercase;' id='montoIngreso_$fila'  name='montoIngreso_$fila' value='" . $Tarifa_Inscripcion . "'/>";
						break;

					case 'SUSPENSIONES':
						//obtener el adeudo del cliente
						$query = "SELECT id_transaccion,id_cliente,id_concepto,cargo,saldo_anterior,saldo_actual,fecha_transaccion
              			FROM transacciones 
              			WHERE id_cliente = '$cliente' ORDER BY id_transaccion DESC LIMIT 1";

						$result = mysqli_query($conexion, $query);

						if ($result && $row = mysqli_fetch_assoc($result)) {

							$idTransaccion = $row['id_transaccion'];
							$idCliente    = $row['id_cliente'];
							$concepto = $row['id_concepto'];
							$cargo = $row['cargo'];
							$saldoAnterior = $row['saldo_anterior'];
							$saldoActual = $row['saldo_actual'];
							$fechaTransaccion = $row['fecha_transaccion'];

							if ($concepto == 1) {

								echo " &nbsp;Monto de Adeudo : ";
								echo "<input type='text' readonly  style='margin-top:4px;margin-bottom:2px;width:200px;text-transform:uppercase;' id='montoIngreso_$fila' name='montoIngreso_$fila' value='" . $saldoActual . "'/>";
							} else {
								echo " &nbsp;Monto de Adeudo : ";
								echo "<input type='text' readonly  style='margin-top:4px;margin-bottom:2px;width:200px;text-transform:uppercase;' id='montoIngreso_$fila'  name='montoIngreso_$fila' value='" . $saldoActual . "'/>";
							}
						}
						break;

					case 'RECONEXIONES':
						//obtener el adeudo del cliente
						$query = "SELECT id_transaccion,id_cliente,id_concepto,cargo,saldo_anterior,saldo_actual,fecha_transaccion
              			FROM transacciones 
              			WHERE id_cliente = '$cliente' ORDER BY id_transaccion DESC LIMIT 1";

						$result = mysqli_query($conexion, $query);

						if ($result && $row = mysqli_fetch_assoc($result)) {

							$idTransaccion = $row['id_transaccion'];
							$idCliente    = $row['id_cliente'];
							$concepto = $row['id_concepto'];
							$cargo = $row['cargo'];
							$saldoAnterior = $row['saldo_anterior'];
							$saldoActual = $row['saldo_actual'];
							$fechaTransaccion = $row['fecha_transaccion'];

							if ($concepto == 1) {

								echo "<div style='margin-bottom:12px;'>
        								<label for='montoAdeudo_$fila'>Monto de Adeudo:</label><br>
        								<input type='text' id='montoAdeudo_$fila' readonly style='margin-top:4px;width:200px;text-transform:uppercase;' name='montoAdeudo_$fila' value='" . $saldoActual . "'/>
									</div>";

								echo "<div style='margin-bottom:12px;'>
        								<label for='montoReconexion_$fila'>Monto Reconexion:</label><br>
        								<input type='text' id='montoReconexion_$fila' readonly style='margin-top:4px;width:200px;text-transform:uppercase;' name='montoReconexion_$fila' value='" . $Tarifa_Inscripcion . "'/>
									</div>";

								$subtotal = $saldoActual + $Tarifa_Inscripcion;

								echo "<div style='margin-bottom:12px;'>
										<label for='montoIngreso_$fila'>Total Ambos Conceptos:</label><br>
        								<input type='text' readonly id='montoIngreso_$fila' style='margin-top:4px;width:200px;text-transform:uppercase;' name='montoIngreso_$fila' value='" . $subtotal . "'/>
									</div>";
							} else {

								echo "<div style='margin-bottom:12px;'>
        								<label for='adeudo_$fila'>Cliente NO CUENTA CON ADEUDO, SOLO SE COBRARA LA RECONEXION</label><br>
									</div>";

								echo "<div style='margin-bottom:12px;'>
										<label for='montoIngreso_$fila'>Monto  Reconexion: </label><br>
        								<input type='text' id='montoIngreso_$fila' readonly style='margin-top:4px;width:200px;text-transform:uppercase;' name='montoIngreso_$fila' value='" . $Tarifa_Inscripcion . "'/>
									</div>";
							}
						}
						break;

					case 'CANCELACIONES':
						//obtener el adeudo del cliente
						$query = "SELECT id_transaccion,id_cliente,id_concepto,cargo,saldo_anterior,saldo_actual,fecha_transaccion
              			FROM transacciones 
              			WHERE id_cliente = '$cliente' ORDER BY id_transaccion DESC LIMIT 1";

						$result = mysqli_query($conexion, $query);

						if ($result && $row = mysqli_fetch_assoc($result)) {

							$idTransaccion = $row['id_transaccion'];
							$idCliente    = $row['id_cliente'];
							$concepto = $row['id_concepto'];
							$cargo = $row['cargo'];
							$saldoAnterior = $row['saldo_anterior'];
							$saldoActual = $row['saldo_actual'];
							$fechaTransaccion = $row['fecha_transaccion'];

							if ($concepto == 1) {
								echo "<div style='margin-bottom:12px;'>
										<label for='montoIngreso_$fila'>Saldo Pendiente:</label><br>
        								<input type='text' readonly id='montoIngreso_$fila' style='margin-top:4px;width:200px;text-transform:uppercase;' name='montoIngreso_$fila' value='" . $saldoActual . "'/>
									</div>";
							} else {

								echo "<div style='margin-bottom:12px;'>
										<label for='montoIngreso_$fila'>Saldo Pendiente:</label><br>
        								<input type='text' readonly id='montoIngreso_$fila' style='margin-top:4px;width:200px;text-transform:uppercase;' name='montoIngreso_$fila' value='" . $saldoActual . "'/>
									</div>";
							}
						}
						break;

					case 'CAMBIO DE DOMICILIO':
						echo " &nbsp;Monto de Cambio de domicilio : ";
						echo "<input type='text' readonly  style='margin-top:4px;margin-bottom:2px;width:200px;text-transform:uppercase;' id='montoIngreso_$fila' name='montoIngreso_$fila' value='" . $Tarifa_Inscripcion . "'/>";
						break;

					case 'PAGO DE MENSUALIDADES':
						//obtener el adeudo del cliente
						$query = "SELECT id_transaccion,id_cliente,id_concepto,cargo,saldo_anterior,saldo_actual,fecha_transaccion
              			FROM transacciones 
              			WHERE id_cliente = '$cliente' ORDER BY id_transaccion DESC LIMIT 1";

						$result = mysqli_query($conexion, $query);

						if ($result && $row = mysqli_fetch_assoc($result)) {

							$idTransaccion = $row['id_transaccion'];
							$idCliente    = $row['id_cliente'];
							$concepto = $row['id_concepto'];
							$cargo = $row['cargo'];
							$saldoAnterior = $row['saldo_anterior'];
							$saldoActual = $row['saldo_actual'];
							$fechaTransaccion = $row['fecha_transaccion'];

							if ($concepto == 1) {
								echo "<div style='margin-bottom:12px;'>
										<label for='montoIngreso_$fila'>Mensualidad del cliente:</label><br>
        								<input type='text' readonly  id='montoIngreso_$fila' style='margin-top:4px;width:200px;text-transform:uppercase;' name='montoIngreso_$fila' value='" . $saldoActual . "'/>
									</div>";
							} else {

								if ($saldoActual > 0) {
									echo "<div style='margin-bottom:12px;'>
										<label for='montoIngreso_$fila'>Adeudo del cliente:</label><br>
        								<input type='text' readonly  id='montoIngreso_$fila' style='margin-top:4px;width:200px;text-transform:uppercase;' name='montoIngreso_$fila' value='" . $saldoActual . "'/>
									</div>";
								} else {
									echo "<div style='margin-bottom:12px;'>
        								<label for=''>Cliente NO CUENTA CON ADEUDO, Valida si se ha generado su corte</label><br>
									</div>";
								}
							}
						}
						break;

					case 'CAMBIO DE SERVICIO':

						switch ($descripcion) {

							case 'CLIENTE CON TV (AGREGA INTERNET)':
								echo " &nbsp;Monto por cambio de Servicio : ";
								echo "<input type='text' readonly  style='margin-top:4px;margin-bottom:2px;width:200px;text-transform:uppercase;' id='montoIngreso_$fila' name='montoIngreso_$fila' value='" . $Tarifa_Inscripcion . "'/>";
								break;

							case 'CLIENTE CON INTERNET (AGREGA TV)':
								echo " &nbsp;Monto por cambio de Servicio : ";
								echo "<input type='text' readonly  style='margin-top:4px;margin-bottom:2px;width:200px;text-transform:uppercase;' id='montoIngreso_$fila' name='montoIngreso_$fila' value='" . $Tarifa_Inscripcion . "'/>";
								break;

							default:
								echo " &nbsp;Valida tu seleccion ";
								break;
						}

						break;

					default:
						echo " &nbsp;Valida tu seleccion ";
						break;
				}

				break;

			case 'INTERNET':

				switch ($categoria) {

					case 'INSCRIPCIONES':
						echo " &nbsp;Monto de Inscripción : ";
						echo "<input type='text' readonly  style='margin-top:4px;margin-bottom:2px;width:200px;text-transform:uppercase;' id='montoIngreso_$fila'  name='montoIngreso_$fila' value='" . $Tarifa_Inscripcion . "'/>";
						break;

					case 'SUSPENSIONES':
						//obtener el adeudo del cliente
						$query = "SELECT id_transaccion,id_cliente,id_concepto,cargo,saldo_anterior,saldo_actual,fecha_transaccion
              			FROM transacciones 
              			WHERE id_cliente = '$cliente' ORDER BY id_transaccion DESC LIMIT 1";

						$result = mysqli_query($conexion, $query);

						if ($result && $row = mysqli_fetch_assoc($result)) {

							$idTransaccion = $row['id_transaccion'];
							$idCliente    = $row['id_cliente'];
							$concepto = $row['id_concepto'];
							$cargo = $row['cargo'];
							$saldoAnterior = $row['saldo_anterior'];
							$saldoActual = $row['saldo_actual'];
							$fechaTransaccion = $row['fecha_transaccion'];

							if ($concepto == 1) {

								echo " &nbsp;Monto de Adeudo : ";
								echo "<input type='text' readonly  style='margin-top:4px;margin-bottom:2px;width:200px;text-transform:uppercase;' id='montoIngreso_$fila'  name='montoIngreso_$fila' value='" . $saldoActual . "'/>";
							} else {
								echo " &nbsp;Monto de Adeudo : ";
								echo "<input type='text' readonly  style='margin-top:4px;margin-bottom:2px;width:200px;text-transform:uppercase;' id='montoIngreso_$fila'  name='montoIngreso_$fila' value='" . $saldoActual . "'/>";
							}
						}
						break;

					case 'RECONEXIONES':
						//obtener el adeudo del cliente
						$query = "SELECT id_transaccion,id_cliente,id_concepto,cargo,saldo_anterior,saldo_actual,fecha_transaccion
              			FROM transacciones 
              			WHERE id_cliente = '$cliente' ORDER BY id_transaccion DESC LIMIT 1";

						$result = mysqli_query($conexion, $query);

						if ($result && $row = mysqli_fetch_assoc($result)) {

							$idTransaccion = $row['id_transaccion'];
							$idCliente    = $row['id_cliente'];
							$concepto = $row['id_concepto'];
							$cargo = $row['cargo'];
							$saldoAnterior = $row['saldo_anterior'];
							$saldoActual = $row['saldo_actual'];
							$fechaTransaccion = $row['fecha_transaccion'];

							if ($concepto == 1) {

								echo "<div style='margin-bottom:12px;'>
        								<label for='montoAdeudo_$fila'>Monto de Adeudo:</label><br>
        								<input type='text' id='montoAdeudo_$fila' readonly='readonly' style='margin-top:4px;width:200px;text-transform:uppercase;' name='montoAdeudo_$fila' value='" . $saldoActual . "'/>
									</div>";

								echo "<div style='margin-bottom:12px;'>
        								<label for='montoReconexion_$fila'>Monto Reconexion:</label><br>
        								<input type='text' id='montoReconexion_$fila' readonly='readonly' style='margin-top:4px;width:200px;text-transform:uppercase;' name='montoReconexion_$fila' value='" . $Tarifa_Inscripcion . "'/>
									</div>";

								$subtotal = $saldoActual + $Tarifa_Inscripcion;

								echo "<div style='margin-bottom:12px;'>
										<label for='montoIngreso_$fila'>Total Ambos Conceptos:</label><br>
        								<input type='text' readonly id='montoIngreso_$fila' style='margin-top:4px;width:200px;text-transform:uppercase;' name='montoIngreso_$fila' value='" . $subtotal . "'/>
									</div>";
							} else {

								echo "<div style='margin-bottom:12px;'>
        								<label for=''>Cliente NO CUENTA CON ADEUDO, SOLO SE COBRARA LA RECONEXION</label><br>
									</div>";

								echo "<div style='margin-bottom:12px;'>
										<label for='montoIngreso_$fila'>Monto  Reconexion: </label><br>
        								<input type='text' id='montoIngreso_$fila' readonly style='margin-top:4px;width:200px;text-transform:uppercase;' name='montoIngreso_$fila' value='" . $Tarifa_Inscripcion . "'/>
									</div>";
							}
						}
						break;

					case 'CANCELACIONES':
						//obtener el adeudo del cliente
						$query = "SELECT id_transaccion,id_cliente,id_concepto,cargo,saldo_anterior,saldo_actual,fecha_transaccion
              			FROM transacciones 
              			WHERE id_cliente = '$cliente' ORDER BY id_transaccion DESC LIMIT 1";

						$result = mysqli_query($conexion, $query);

						if ($result && $row = mysqli_fetch_assoc($result)) {

							$idTransaccion = $row['id_transaccion'];
							$idCliente    = $row['id_cliente'];
							$concepto = $row['id_concepto'];
							$cargo = $row['cargo'];
							$saldoAnterior = $row['saldo_anterior'];
							$saldoActual = $row['saldo_actual'];
							$fechaTransaccion = $row['fecha_transaccion'];

							if ($concepto == 1) {
								echo "<div style='margin-bottom:12px;'>
										<label for='montoIngreso_$fila'>Saldo Pendiente:</label><br>
        								<input type='text' readonly id='montoIngreso_$fila' style='margin-top:4px;width:200px;text-transform:uppercase;' name='montoIngreso_$fila' value='" . $saldoActual . "'/>
									</div>";
							} else {

								echo "<div style='margin-bottom:12px;'>
										<label for='montoIngreso_$fila'>Saldo Pendiente:</label><br>
        								<input type='text' readonly id='montoIngreso_$fila' style='margin-top:4px;width:200px;text-transform:uppercase;' name='montoIngreso_$fila' value='" . $saldoActual . "'/>
									</div>";
							}
						}
						break;

					case 'CAMBIO DE DOMICILIO':
						echo " &nbsp;Monto de Cambio de domicilio : ";
						echo "<input type='text' readonly style='margin-top:4px;margin-bottom:2px;width:200px;text-transform:uppercase;' id='montoIngreso_$fila'  name='montoIngreso_$fila' value='" . $Tarifa_Inscripcion . "'/>";
						break;

					case 'PAGO DE MENSUALIDADES':
						//obtener el adeudo del cliente
						$query = "SELECT id_transaccion,id_cliente,id_concepto,cargo,saldo_anterior,saldo_actual,fecha_transaccion
              			FROM transacciones 
              			WHERE id_cliente = '$cliente' ORDER BY id_transaccion DESC LIMIT 1";

						$result = mysqli_query($conexion, $query);

						if ($result && $row = mysqli_fetch_assoc($result)) {

							$idTransaccion = $row['id_transaccion'];
							$idCliente    = $row['id_cliente'];
							$concepto = $row['id_concepto'];
							$cargo = $row['cargo'];
							$saldoAnterior = $row['saldo_anterior'];
							$saldoActual = $row['saldo_actual'];
							$fechaTransaccion = $row['fecha_transaccion'];

							if ($concepto == 1) {
								echo "<div style='margin-bottom:12px;'>
										<label for='montoIngreso_$fila'>Mensualidad del cliente:</label><br>
        								<input type='text' readonly id='montoIngreso_$fila' style='margin-top:4px;width:200px;text-transform:uppercase;' name='montoIngreso_$fila' value='" . $saldoActual . "'/>
									</div>";
							} else {

								if ($saldoActual > 0) {
									echo "<div style='margin-bottom:12px;'>
										<label for='montoIngreso_$fila'>Adeudo Cliente:</label><br>
        								<input type='text' readonly id='montoIngreso_$fila' style='margin-top:4px;width:200px;text-transform:uppercase;' name='montoIngreso_$fila' value='" . $saldoActual . "'/>
									</div>";
								} else {
									echo "<div style='margin-bottom:12px;'>
        								<label for=''>Cliente NO CUENTA CON ADEUDO, Valida si se ha generado su corte</label><br>
									</div>";
								}
							}
						}
						break;

					case 'CAMBIO DE SERVICIO':

						switch ($descripcion) {

							case 'CLIENTE CON TV (QUITA TV Y AGREGA INTERNET)':
								echo " &nbsp;Monto por cambio de Servicio : ";
								echo "<input type='text' readonly  style='margin-top:4px;margin-bottom:2px;width:200px;text-transform:uppercase;' id='montoIngreso_$fila'  name='montoIngreso_$fila' value='" . $Tarifa_Inscripcion . "'/>";
								break;

							case 'CLIENTE DE TV CON INTERNET (QUITA TV Y DEJA SOLO INTERNET)':
								echo " &nbsp;Monto por cambio de Servicio : ";
								echo "<input type='text' readonly  style='margin-top:4px;margin-bottom:2px;width:200px;text-transform:uppercase;' id='montoIngreso_$fila'   name='montoIngreso_$fila' value='" . $Tarifa_Inscripcion . "'/>";
								break;

							default:
								echo " &nbsp;Valida tu seleccion ";
								break;
						}

						break;

					default:
						echo " &nbsp;Valida tu seleccion ";
						break;
				}
				break;

			default:
				echo " &nbsp;Valida tu seleccion ";
				break;
		}
	}
}


//===================== Esto es para traer las promociones

if (isset($_POST['conceptoPromo']) && isset($_POST['fila'])) {

	$concepto = $_POST['conceptoPromo'];
	$fila = $_POST['fila'];
	$tipo = $_POST['tipoPromo'];

	if ($tipo == 'porcentaje') {
		$query = "SELECT id_promocion, id_tipo_ingreso, porcentaje, descripcion 
              FROM promociones 
              WHERE id_tipo_ingreso = '$concepto'
              AND porcentaje IS NOT NULL
              AND porcentaje > 0
              AND activo = '1'";
	} elseif ($tipo == 'monto') {
		$query = "SELECT id_promocion, id_tipo_ingreso, monto, descripcion 
              FROM promociones 
              WHERE id_tipo_ingreso = '$concepto'
              AND monto IS NOT NULL
              AND monto > 0
              AND activo = '1'";
	}

	$result = mysqli_query($conexion, $query);
	if ($result) {

		if ($tipo == 'porcentaje') {

			echo " &nbsp;Promociones Disponibles : ";
			echo "<select name='promocion_$fila' id='promocion_$fila' style='width:250px; font-size:12px;'  onchange=\"cargarNuevoTotal(this.options[this.selectedIndex].dataset.porcentaje, '$fila', 'porcentaje');\">";
			echo "<option value='null'>Seleccione una promoción</option>";
			while (list($id, $tipoIngreso, $porcentaje, $descripcion) = mysqli_fetch_array($result)) {
				echo "<option value='$id' data-porcentaje='$porcentaje'>$descripcion - $porcentaje.%</option>";
			}
			echo "</select><br>";
		} elseif ($tipo == 'monto') {
			echo " &nbsp;Promociones Disponibles : ";
			echo "<select name='promocion_$fila' id='promocion_$fila' style='width:250px; font-size:12px;'  onchange=\"cargarNuevoTotal(this.options[this.selectedIndex].dataset.monto, '$fila', 'monto');\">";
			echo "<option value='null'>Seleccione una promoción</option>";
			while (list($id, $tipoIngreso, $monto, $descripcion) = mysqli_fetch_array($result)) {
				echo "<option value='$id' data-monto='$monto'>$descripcion - $$monto</option>";
			}
			echo "</select><br>";
		}
	}
}





if (isset($_POST['servicio_internet'])) {

	if (
		$_POST['servicio_internet'] == 9 || $_POST['servicio_internet'] == 15 || $_POST['servicio_internet'] == 8 || $_POST['servicio_internet'] == 13 ||
		$_POST['servicio_internet'] == 14 || $_POST['servicio_internet'] == 16
	) {
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