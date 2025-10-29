<script language="javascript" type="text/javascript">
	function guardar() {
		var cadena = "";

		if (document.formulario.tipo_ingreso.value == 'null')
			cadena += "\n* Debe elegir un tipo de ingreso.";
		if (document.formulario.descripcion.value == '')
			cadena += "\n* Debe asignar una nombre.";

		// Validar monto fijo
		const montoFijoSi = document.querySelector('input[name="monto_fijo"][value="1"]');
		if (montoFijoSi && montoFijoSi.checked) {
			const inputMonto = document.getElementById("input_monto_fijo");
			if (!inputMonto || inputMonto.value.trim() === "") {
				cadena += "\n* Debe asignar un monto fijo.";
			}
		}

		// Validar porcentaje
		const porcentajeSi = document.querySelector('input[name="porcentaje"][value="1"]');
		if (porcentajeSi && porcentajeSi.checked) {
			const inputPorcentaje = document.getElementById("input_porcentaje");
			if (!inputPorcentaje || inputPorcentaje.value.trim() === "") {
				cadena += "\n* Debe asignar un porcentaje.";
			}
		}

		if (cadena == "") {
			document.formulario.submit();
		} else
			alert("Por favor verifique lo siguiente:" + cadena);
	}

	function solo_numeros(texto) {
		var expresion = /[0-9]*/;
		texto.value = texto.value.match(expresion);
	}

	function solo_numeros_decimales(texto) {
		var expresion = /[0-9]*\.?[0-9]{0,2}/;
		texto.value = texto.value.match(expresion);
	}

	function mostrarMontoFijo() {
		let contenedor = document.getElementById("contenedor_monto");
		if (!document.getElementById("input_monto_fijo")) {
			contenedor.innerHTML = `
            <tr id="fila_monto_fijo">
                <td>Descuento Monto: </td>
                <td>
                    $ <input id="input_monto_fijo" name="monto_valor" 
                             style="width:50px;font-size:12px;" 
                             onblur="solo_numeros(this)" 
                             onkeyup="solo_numeros(this)" 
                             type="text" maxlength="255" />
                </td>
            </tr>
        `;
		}
	}

	function ocultarMontoFijo() {
		let fila = document.getElementById("fila_monto_fijo");
		if (fila) fila.remove();
	}

	function mostrarPorcentaje() {
		let contenedor = document.getElementById("contenedor_porcentaje");
		if (!document.getElementById("input_porcentaje")) {
			contenedor.innerHTML = `
            <tr id="fila_porcentaje">
                <td>Descuento Porcentaje: </td>
                <td>
                    <input id="input_porcentaje" name="porcentaje_valor" 
                           style="width:50px;font-size:12px;" 
                           onblur="solo_numeros(this)" 
                           onkeyup="solo_numeros(this)" 
                           type="text" maxlength="255" /> %
                </td>
            </tr>
        `;
		}
	}

	function ocultarPorcentaje() {
		let fila = document.getElementById("fila_porcentaje");
		if (fila) fila.remove();
	}
</script>

<table border="0px" width="100%" style="color:#000000;font-size:12px">
	<tr>
		<td align="right">
			<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="5px" background="imagenes/module_left.png"></td>
					<td width="70px" background="imagenes/module_center.png" height="80" valign="middle"><img src="imagenes/promociones.png" /></td>
					<td align="left" background="imagenes/module_center.png" height="80" valign="middle" class="titulo"><b>&nbsp;&nbsp;AGREGAR PROMOCI&Oacute;N&nbsp;&nbsp;</b></td>
					<td align="right" background="imagenes/module_center.png" height="80">
						<button class="boton2" onclick="guardar()"><img src="imagenes/guardar.png" /><br />Guardar</button>
						<button class="boton2" onclick="location.href='index.php?menu=26'"><img src="imagenes/cancelar.png" /><br />Cancelar</button>
					</td>
					<td width="5px" background="imagenes/module_right.png"></td>
				</tr>
			</table>
		</td>
	</tr>
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
								<tr>
									<td>Tipo Ingreso</td>
									<td>
										<select name="tipo_ingreso" style="width:550px; font-size:12px;">
											<option value="null">Elige un tipo de ingreso</option>
											<?php
											$query_t_u = "select * from cat_tipo_ingreso where estado = 'Activo' ORDER BY tipo_Servicio asc, categoria ASC";
											$tabla_t_u = mysqli_query($conexion, $query_t_u);
											while ($registro_t_u = mysqli_fetch_array($tabla_t_u)) {
												echo "<option value=\"$registro_t_u[0]\">$registro_t_u[2]-$registro_t_u[3]</option>";
											}
											?>
										</select>
									</td>
								</tr>
								<tr>
									<td>Nombre</td>
									<td><input name="descripcion" style="width:300px;font-size:12px;" type="text" maxlength="255" /></td>
								</tr>

								<tr>
									<td>¿Descuento en Monto Fijo?</td>
									<td>
										<input type="radio" name="monto_fijo" id="monto_fijo" value="1" onchange="mostrarMontoFijo()" /><label for="monto_fijo">&nbsp;Si</label>&nbsp;&nbsp;
										<input type="radio" name="monto_fijo" id="monto_fijo" value="0" checked="checked" onchange="ocultarMontoFijo()" /><label for="monto_fijo">&nbsp;No</label>
									</td>
								</tr>

								<tr id="fila_contenedor_monto">
									<td colspan="2">
										<table id="contenedor_monto"></table>
									</td>
								</tr>

								<tr>
									<td>¿Descuento en Porcentaje?</td>
									<td>
										<input type="radio" name="porcentaje" id="porcentaje" value="1" onchange="mostrarPorcentaje()" /><label for="porcentaje">&nbsp;Si</label>&nbsp;&nbsp;
										<input type="radio" name="porcentaje" id="porcentaje" value="0" checked="checked" onchange="ocultarPorcentaje()" /><label for="porcentaje">&nbsp;No</label>
									</td>
								</tr>

								<tr id="fila_contenedor_porcentaje">
									<td colspan="2">
										<table id="contenedor_porcentaje"></table>
									</td>
								</tr>

								<!-- <tr><td>Descuento</td><td>$ <input name="porcentaje" style="width:50px;font-size:12px;" onblur="solo_numeros(this)" onkeyup="solo_numeros(this)" type="text" maxlength="255" /></td></tr> -->
								<tr>
									<td>
										Estado
									</td>
									<td>
										<input type="radio" name="activo" id="activo_1" value="1" /><label for="activo_1">&nbsp;Activo</label>&nbsp;&nbsp;
										<input type="radio" name="activo" id="activo_2" value="0" checked="checked" /><label for="activo_2">&nbsp;No Activo</label>
									</td>
								</tr>
							</table>
							<input name="accion" type="hidden" value="agregar" />
						</form>
					</td>
				</tr>
				<tr>
					<td height="3px" class="separador"></td>
				</tr>
			</table>
		</td>
	</tr>
</table>