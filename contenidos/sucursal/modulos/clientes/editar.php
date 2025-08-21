<script language="javascript" type="text/javascript">
	var bandera_calles = true;
	var bandera_tap = false;

	function guardar() {
		var cadena = "";


		if (document.formulario.nombre.value == '')
			cadena += "\n* Debe asignar un Nombre.";

		if (document.formulario.apellido_paterno.value == '')
			cadena += "\n* Debe asignar un Apellido Paterno.";

		if (document.formulario.apellido_materno.value == '')
			cadena += "\n* Debe asignar un Apellido Materno.";

		if (bandera_calles) {
			if (document.formulario.calle.value == 'null')
				cadena += "\n* Debe elegir una Calle.";
		} else {
			cadena += "\n* Debe elegir una Calle.";
		}

		if (document.formulario.numero.value == '')
			cadena += "\n* Debe asignar un N\u00famero.";

		if (document.formulario.referencia_casa.value == '')
			cadena += "\n* Debe asignar una Referencia de la Casa.";

		if (document.formulario.tap.value == 'null')
			cadena += "\n* Debe asignar un ID TAP.";

		if (document.formulario.tarifa.value == '')
			cadena += "\n* Debe asignar una Tarifa.";

		if (document.formulario.num_contrato.value == '')
			cadena += "\n* Debe asignar un Numero de Contrato.";

		if (document.formulario.fecha_contrato.value == '')
			cadena += "\n* Debe asignar una Fecha de Contrato.";

		if(document.formulario.telefono.value=='' || document.formulario.telefono.value.length<10)
			cadena+= "\n* El Telefono debe tener 10 digitos Y no debe estar vacio.";

		if (cadena == "") {
			document.formulario.submit();
		} else
			alert("Por favor verifique lo siguiente:" + cadena);
	}

	function solo_numeros_decimales(texto) {
		var expresion = /[0-9]*\.?[0-9]{0,2}/;
		texto.value = texto.value.match(expresion);
	}

	function solo_numeros(texto) {
		var expresion = /[0-9]*/;
		texto.value = texto.value.match(expresion);
	}

	function cargarCalle(valor) {
		bandera_numeros = false;
		var div_numero = document.getElementById("div_calle");
		if (valor != "null") {
			div_numero.innerHTML = "<img src='imagenes/loading.gif' /> <span style='font-size:10px;'>Cargando Calles...</span>";
			var cdata = "sucursal=" + valor;
			$.ajax({
				type: "POST",
				url: "ajaxProcess/clientes.php",
				data: cdata,
				success: function(datos) {
					div_numero.innerHTML = datos;
					bandera_calles = true;
				}
			});
		} else {
			div_numero.innerHTML = "No Asignado";
		}
	}

	function cargarTap(valor) {
		bandera_tap = false;
		var div_numero = document.getElementById("div_tap");
		if (valor != "null") {
			div_numero.innerHTML = "<img src='imagenes/loading.gif' /> <span style='font-size:10px;'>Cargando TAPS...</span>";
			var cdata = "sucursal=" + valor + "&tap=1";
			$.ajax({
				type: "POST",
				url: "ajaxProcess/clientes.php",
				data: cdata,
				success: function(datos) {
					div_numero.innerHTML = datos;
					bandera_tap = true;
				}
			});
		} else {
			div_numero.innerHTML = "No Asignado";
		}
	}
</script>

<table border="0px" width="100%" style="color:#000000;font-size:12px">
	<tr>
		<td align="right">
			<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="5px" background="imagenes/module_left.png"></td>
					<td width="70px" background="imagenes/module_center.png" height="80" valign="middle"><img src="imagenes/usuarios.png" /></td>
					<td align="left" background="imagenes/module_center.png" height="80" valign="middle" class="titulo"><b>&nbsp;&nbsp;EDITAR CLIENTE&nbsp;&nbsp;</b></td>
					<td align="right" background="imagenes/module_center.png" height="80">
						<button class="boton2" id="guardar" onclick="guardar()"><img src="imagenes/guardar.png" /><br />Guardar</button>
						<button class="boton2" onclick="location.href='index.php?menu=10'"><img src="imagenes/cancelar.png" /><br />Cancelar</button>
					</td>
					<td width="5px" background="imagenes/module_right.png"></td>
				</tr>
			</table>
		</td>
	</tr>
	<?php
	if (isset($_GET['id']))
		$id = $_GET['id'];
	else {


		foreach ($_POST as $variable => $valor) {
			if ($variable != "selector") {
				if ($variable != "accion") {
					$id = $variable;
				}
			}
		}
	}
	if (isset($id)) {

		$query = "select * from clientes where id_cliente='" . addslashes($id) . "'";
		$registro = devolverValorQuery($query);
		if ($registro[0] != '') {
	?>
			<tr>
				<td height="10px"></td>
			</tr>
			<tr>
				<td colspan="3">
					<table class="datagrid" width="100%" border="0" cellspacing="0">
						<tr>
							<td height="3px" class="separador"></td>
						</tr>
						<tr class="tabla_columns">
							<td>Detalles</td>
						</tr>
						<tr>
							<td>
								<form name="formulario" method="post" onsubmit="return false;" action="index.php?menu=10">
									<table style="color:#000000" cellpadding="5">
										<tr>
											<td>Nombre</td>
											<td><input name="nombre" style="width:300px;font-size:12px;" type="text" value="<?php echo $registro[4]; ?>" maxlength="255" /></td>
										</tr>
										<tr>
											<td>Apellido Paterno</td>
											<td><input name="apellido_paterno" style="width:300px;font-size:12px;" value="<?php echo $registro[5]; ?>" type="text" maxlength="255" /></td>
										</tr>
										<tr>
											<td>Apellido Materno</td>
											<td><input name="apellido_materno" style="width:300px;font-size:12px;" value="<?php echo $registro[6]; ?>" type="text" maxlength="255" /></td>
										</tr>
										<tr>
											<td>Telefono</td>
											<td><input name="telefono" style="width:300px;font-size:12px;" type="text" maxlength="10" minlength="10" onchange="solo_numeros(this)" onkeyup="solo_numeros(this)" value="<?php echo $registro[18]; ?>" /></td>
										</tr>
										<tr>
											<td>R.F.C.</td>
											<td><input name="rfc" style="width:300px;font-size:12px;" type="text" value="<?php echo $registro[19]; ?>" maxlength="13" /></td>
										</tr>
										<tr>
											<td>EMAIL</td>
											<td><input name="email" style="width:300px;font-size:12px;" value="<?php echo $registro[20]; ?>" type="text" maxlength="255" /></td>
										</tr>
										<tr>
											<td colspan="2">
												<hr />
											</td>
										</tr>
										<tr>
											<td>Calle</td>
											<td>
												<div id="div_calle">
													<?php
													$query = "select id_calle,nombre from cat_calles where id_sucursal='" . $registro[1] . "'";
													$tabla = mysqli_query($conexion, $query);
													echo "<select name='calle' style='width:300px;font-size:12px;'><option value='null'>Seleccione una Calle</option>";
													while ($registro_combo = mysqli_fetch_array($tabla)) {
														if ($registro[3] == $registro_combo[0])
															echo "<option value=\"" . $registro_combo[0] . "\" selected=\"selected\">" . $registro_combo[1] . "</option>";
														else
															echo "<option value=\"" . $registro_combo[0] . "\">" . $registro_combo[1] . "</option>";
													}
													echo "</select>";
													?>
												</div>
											</td>
										</tr>
										<tr>
											<td>Colonia</td>
											<td><input name="colonia" style="width:300px;font-size:12px;" type="text" maxlength="150" value="<?php echo $registro[15]; ?>" /></td>
										</tr>
										<tr>
											<td>Numero Exterior</td>
											<td><input name="numero" style="width:50px;font-size:12px;" value="<?php echo $registro[7]; ?>" type="text" maxlength="12" /></td>
										</tr>
										<tr>
											<td>Numero Interior</td>
											<td><input name="numero_interior" style="width:50px;font-size:12px;" type="text" maxlength="11" value="<?php echo $registro[16]; ?>" /></td>
										</tr>
										<tr>
											<td>CP</td>
											<td><input name="cp" style="width:50px;font-size:12px;" type="text" maxlength="8" value="<?php echo $registro[17]; ?>" /></td>
										</tr>
										<tr>
											<td>Referencia de la Casa</td>
											<td><input name="referencia_casa" style="width:300px;font-size:12px;" value="<?php echo $registro[12]; ?>" type="text" maxlength="255" /></td>
										</tr>
										<tr>
											<td>ID TAP</td>
											<td>
												<div id="div_tap">
													<?php
													$query = "select id_tap, valor, salidas from tap where id_sucursal='" . $registro[1] . "'";
													$tabla = mysqli_query($conexion, $query);
													echo "<select name='tap' style='width:300px;font-size:12px;'><option value='null'>No asignado</option>";
													while ($registro_combo = mysqli_fetch_array($tabla)) {
														if ($registro[9] == $registro_combo[0])
															echo "<option value=\"" . $registro_combo[0] . "\" selected=\"selected\">" . $registro_combo[0] . " - " . $registro_combo[1] . " - " . $registro_combo[2] . "</option>";
														else
															echo "<option value=\"" . $registro_combo[0] . "\">" . $registro_combo[0] . " - " . $registro_combo[1] . " - " . $registro_combo[2] . "</option>";
													}
													echo "</select>";
													?>
												</div>
											</td>
										</tr>
										<tr>
											<td colspan="2">
												<hr />
											</td>
										</tr>
										<tr>
											<td>Tarifa $</td>
											<td><input name="tarifa" onchange="solo_numeros_decimales(this)" onkeyup="solo_numeros_decimales(this)" value="<?php echo $registro[8]; ?>" style="width:50px;font-size:12px;" type="text" maxlength="7" /></td>
										</tr>
										<tr>
											<td>No. Contrato</td>
											<td><input name="num_contrato" onchange="solo_numeros(this)" onkeyup="solo_numeros(this)" value="<?php echo $registro[10]; ?>" style="width:50px;font-size:12px;" type="text" maxlength="10" /></td>
										</tr>
										<tr>
											<td>Fecha Contrato</td>
											<td><input name="fecha_contrato" id="fecha_contrato" value="<?php echo $registro[11]; ?>" style="width:90px;font-size:12px; background-image:url(calendario/imgs/icon_minicalendar.gif); background-position:right center; background-repeat:no-repeat;" type="text" maxlength="10" readonly /></td>
										</tr>

										<tr>
											<td>Tipo de Contratacion</td>
											<td>
												<select name="tipo_contratacion" style="width:300px;font-size:12px;">
													<option value="DESCONOCIDO">Seleccione un Tipo de Contratacion</option>
													<option value="SERVICIO TV" <?php if ($registro[21] == 'SERVICIO TV') echo "selected"; ?>>SERVICIO TV</option>
													<option value="SERVICIO TV + INTERNET" <?php if ($registro[21] == 'SERVICIO TV + INTERNET') echo "selected"; ?>>SERVICIO TV + INTERNET</option>
													<option value="INSTALACION SOLO INTERNET" <?php if ($registro[21] == 'INSTALACION SOLO INTERNET') echo "selected"; ?>>INSTALACION SOLO INTERNET</option>
													<option value="CAMBIO DE TV + INTERNET POR INTERNET" <?php if ($registro[21] == 'CAMBIO DE TV + INTERNET POR INTERNET') echo "selected"; ?>>CAMBIO DE TV + INTERNET POR INTERNET</option>
													<option value="SERVICIO CANCELADO" <?php if ($registro[21] == 'SERVICIO CANCELADO') echo "selected"; ?>>SERVICIO CANCELADO</option>
												</select>
											</td>
										</tr>

									</table>
									<input name="accion" type="hidden" value="editar" />
									<input name="id" type="hidden" value="<?php echo $id; ?>" />
								</form>
							</td>
						</tr>
						<tr>
							<td height="3px" class="separador"></td>
						</tr>
					</table>
				</td>
			</tr>
		<?php
		} else {
		?>
			<script>
				var variable = document.getElementById("guardar");
				variable.disabled = true;
				variable.style.display = "none";
			</script>
			<tr>
				<td colspan="3" align="center">
					<table border="0" width="100%" cellpadding="0" cellspacing="0">
						<tr>
							<td width="5px" background="imagenes/message_error_left.png"></td>
							<td align="center" background="imagenes/message_error_center.png" height="30" valign="middle" class="warning">El registro que desea editar no existe.</td>
							<td width="5px" background="imagenes/message_error_right.png"></td>
						</tr>
					</table>
				</td>
			</tr>
		<?php
		}
	} else {
		?>
		<script>
			var variable = document.getElementById("guardar");
			variable.disabled = true;
			variable.style.display = "none";
		</script>
		<tr>
			<td colspan="3" align="center">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
					<tr>
						<td width="5px" background="imagenes/message_error_left.png"></td>
						<td align="center" background="imagenes/message_error_center.png" height="30" valign="middle" class="warning">No se puede editar este registro.</td>
						<td width="5px" background="imagenes/message_error_right.png"></td>
					</tr>
				</table>
			</td>
		</tr>
	<?php
	}
	?>
</table>
<script>
	var cal1,
		cal2,
		mCal,
		mDCal,
		newStyleSheet;
	var dateFrom = null;
	var dateTo = null;
	window.onload = function() {

		cal1 = new dhtmlxCalendarObject('fecha_contrato');
		cal1.setSkin('dhx_skyblue');
		cal1.setDate('<?php echo $registro[11]; ?>');
	}
</script>