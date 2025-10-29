<script language="javascript" type="text/javascript">
	function guardar() {
		var cadena = "";

		if (document.formulario.tipo_ingreso.value == 'null')
			cadena += "\n* Debe elegir un tipo de ingreso.";
		if (document.formulario.descripcion.value == '')
			cadena += "\n* Debe asignar un nombre.";

		// Validar monto fijo si se seleccionó "Sí"
		const montoFijoSi = document.querySelector('input[name="monto_fijo"][value="1"]');
		if (montoFijoSi && montoFijoSi.checked) {
			const inputMonto = document.getElementById("input_monto_fijo");
			if (!inputMonto || inputMonto.value.trim() === "") {
				cadena += "\n* Debe asignar un monto fijo.";
			}
		}

		// Validar porcentaje si se seleccionó "Sí"
		const porcentajeSi = document.querySelector('input[name="porcentaje"][value="1"]');
		if (porcentajeSi && porcentajeSi.checked) {
			const inputPorcentaje = document.getElementById("input_porcentaje");
			if (!inputPorcentaje || inputPorcentaje.value.trim() === "") {
				cadena += "\n* Debe asignar un porcentaje.";
			}
		}

		if (cadena == "") {
			document.formulario.submit();
		} else {
			alert("Por favor verifique lo siguiente:" + cadena);
		}
	}

	function solo_numeros(texto) {
		texto.value = texto.value.replace(/[^0-9]/g, '');
	}

	function solo_numeros_decimales(texto) {
		texto.value = texto.value.replace(/[^0-9\.]/g, '');
	}
</script>

<table border="0" width="100%" style="color:#000000;font-size:12px">
	<tr>
		<td align="right">
			<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="5px" background="imagenes/module_left.png"></td>
					<td width="70px" background="imagenes/module_center.png" height="80" valign="middle">
						<img src="imagenes/promociones.png" />
					</td>
					<td align="left" background="imagenes/module_center.png" height="80" valign="middle" class="titulo">
						<b>&nbsp;&nbsp;EDITAR PROMOCI&Oacute;N&nbsp;&nbsp;</b>
					</td>
					<td align="right" background="imagenes/module_center.png" height="80">
						<button class="boton2" id="guardar" onclick="guardar()">
							<img src="imagenes/guardar.png" /><br />Guardar
						</button>
						<button class="boton2" onclick="location.href='index.php?menu=26'">
							<img src="imagenes/cancelar.png" /><br />Cancelar
						</button>
					</td>
					<td width="5px" background="imagenes/module_right.png"></td>
				</tr>
			</table>
		</td>
	</tr>

	<?php
	if (isset($_GET['id'])) $id = $_GET['id'];
	else {
		foreach ($_POST as $variable => $valor) {
			if ($variable != "selector" && $variable != "accion") $id = $variable;
		}
	}

	if (isset($id)) {
		$query = "select * from promociones where id_promocion='" . addslashes($id) . "'";
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
								<form name="formulario" method="post" onsubmit="return false;" action="index.php?menu=26">
									<table style="color:#000000" cellpadding="5">

										<!-- Tipo Ingreso -->
										<tr>
											<td>Tipo Ingreso</td>
											<td>
												<select name="tipo_ingreso" style="width:550px; font-size:12px;">
													<option value="null">Elige un tipo de ingreso</option>
													<?php
													$query_t_u = "select * from cat_tipo_ingreso where estado = 'Activo' ORDER BY tipo_Servicio asc, categoria ASC";
													$tabla_t_u = mysqli_query($conexion, $query_t_u);
													while ($registro_t_u = mysqli_fetch_array($tabla_t_u)) {
														$sel = ($registro[1] == $registro_t_u[0]) ? 'selected' : '';
														echo "<option value=\"$registro_t_u[0]\" $sel>$registro_t_u[2]-$registro_t_u[3]</option>";
													}
													?>
												</select>
											</td>
										</tr>

										<!-- Nombre -->
										<tr>
											<td>Nombre</td>
											<td>
												<input value="<?php echo $registro[4]; ?>" name="descripcion" style="width:300px;font-size:12px;" type="text" maxlength="255" />
											</td>
										</tr>

										<!-- Monto Fijo -->
										<tr>
											<td>¿Descuento en Monto Fijo?</td>
											<td>
												<?php
												$montoValor = (!empty($registro[3]) && $registro[3] > 0) ? $registro[3] : '';
												$checkedMontoSi = ($montoValor != '') ? 'checked' : '';
												$checkedMontoNo = ($montoValor == '') ? 'checked' : '';
												?>
												<input type="radio" name="monto_fijo" value="1" <?php echo $checkedMontoSi; ?>
													onchange="document.getElementById('input_monto_fijo').style.display='inline-block'; document.getElementById('input_monto_fijo').value='<?php echo $montoValor; ?>'"> Sí
												<input type="radio" name="monto_fijo" value="0" <?php echo $checkedMontoNo; ?>
													onchange="document.getElementById('input_monto_fijo').style.display='none'; document.getElementById('input_monto_fijo').value=''"> No

											</td>
										</tr>
										<tr>
											<td>Descuento Monto: </td>
											<td colspan="2">
												$ <input id="input_monto_fijo" name="monto_valor" type="text" maxlength="255"
													style="width:50px;font-size:12px;<?php echo ($montoValor == '' ? 'display:none;' : ''); ?>"
													onblur="solo_numeros(this)" onkeyup="solo_numeros(this)"
													value="<?php echo $montoValor; ?>" />
											</td>
										</tr>

										<!-- Porcentaje -->
										<tr>
											<td>¿Descuento en Porcentaje?</td>
											<td>
												<?php
												$porcValor = (!empty($registro[2]) && $registro[2] > 0) ? $registro[2] : '';
												$checkedPorcSi = ($porcValor != '') ? 'checked' : '';
												$checkedPorcNo = ($porcValor == '') ? 'checked' : '';
												?>
												<input type="radio" name="porcentaje" value="1" <?php echo $checkedPorcSi; ?>
													onchange="document.getElementById('input_porcentaje').style.display='inline-block'; document.getElementById('input_porcentaje').value='<?php echo $porcValor; ?>'"> Sí
												<input type="radio" name="porcentaje" value="0" <?php echo $checkedPorcNo; ?>
													onchange="document.getElementById('input_porcentaje').style.display='none'; document.getElementById('input_porcentaje').value=''"> No

											</td>
										</tr>
										<tr>
											<td>Descuento Porcentaje: </td>
											<td colspan="2">
												<input id="input_porcentaje" name="porcentaje_valor" type="text" maxlength="255"
													style="width:50px;font-size:12px;<?php echo ($porcValor == '' ? 'display:none;' : ''); ?>"
													onblur="solo_numeros(this)" onkeyup="solo_numeros(this)"
													value="<?php echo $porcValor; ?>" /> %
											</td>
										</tr>

										<!-- Estado -->
										<tr>
											<td>Estado</td>
											<td>
												<?php
												$checked1 = ($registro[5] == '1') ? 'checked' : '';
												$checked2 = ($registro[5] == '0') ? 'checked' : '';
												?>
												<input type="radio" name="activo" value="1" <?php echo $checked1; ?>> Activo
												<input type="radio" name="activo" value="0" <?php echo $checked2; ?>> No Activo
											</td>
										</tr>

									</table>

									<input name="accion" type="hidden" value="editar" />
									<input name="id" type="hidden" value="<?php echo $id; ?>" />
								</form>
							</td>
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
						<td align="center" background="imagenes/message_error_center.png" height="30" valign="middle" class="warning">
							No se puede editar este registro.
						</td>
						<td width="5px" background="imagenes/message_error_right.png"></td>
					</tr>
				</table>
			</td>
		</tr>
	<?php
	}
	?>
</table>