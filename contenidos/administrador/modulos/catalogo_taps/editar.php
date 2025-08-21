<?php
header("Content-Type: text/html;charset=latin");
?>
<script type="text/javascript" src="jshash-2.2/md5-min.js"></script>
<script language="javascript" type="text/javascript">
	function guardar() {
		var cadena = "";

		if (document.formulario.sucursal.value == 'null')
			cadena += "\n* Debe elegir una Sucursal.";

		if (document.formulario.id_tap.value == '')
			cadena += "\n* Debe asignar un ID Tap.";

		if (document.formulario.calle.value == '')
			cadena += "\n* Debe asignar una calle.";

		if (document.formulario.poste.value == '')
			cadena += "\n* Debe asignar un poste.";

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

	function calcular() {
		var distancia, peso;
		distancia = document.getElementById("distancia").value;
		peso = document.getElementById("pesofabrica").value;
		var tmp = peso / 1000;
		tmp = tmp * distancia;
		document.getElementById("peso").value = tmp;
		//alert("el valor "+tmp);
	}

	function _Ajax(id, valor, valor2) {
		bandera_numeros = false;
		var div_numero = document.getElementById(id);
		var select = document.getElementById("calle");
		if (valor != "null") {
			div_numero.innerHTML = "<img src='imagenes/loading.gif' /> <span style='font-size:10px;'>Cargando ...</span>";
			var cdata = "id=" + id + "&valor1=" + valor;
			$.ajax({
				type: "POST",
				url: "ajaxProcess/reporte_servicio.php",
				data: cdata,
				success: function(datos) {
					div_numero.innerHTML = datos;

				}
			});
		}

	}
</script>

<table border="0px" width="100%" style="color:#000000;font-size:12px">
	<tr>
		<td align="right">
			<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="5px" background="imagenes/module_left.png"></td>
					<td width="70px" background="imagenes/module_center.png" height="80" valign="middle"><img src="imagenes/maps.png" /></td>
					<td align="left" background="imagenes/module_center.png" height="80" valign="middle" class="titulo"><b>&nbsp;&nbsp;EDITAR TAP&nbsp;&nbsp;</b></td>
					<td align="right" background="imagenes/module_center.png" height="80">
						<button class="boton2" id="guardar" onclick="guardar()"><img src="imagenes/guardar.png" /><br />Guardar</button>
						<button class="boton2" onclick="location.href='index.php?menu=20'"><img src="imagenes/cancelar.png" /><br />Cancelar</button>
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

		$query = "select * from tap where id_tap='" . addslashes($id) . "'";
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
								<form name="formulario" method="post" onsubmit="return false;" action="index.php?menu=20">
									<table style="color:#000000" cellpadding="5">
										<tr>
											<td>Sucursal</td>
											<td>
												<select name="sucursal" style="width:300px; font-size:12px;" onchange="_Ajax('div_calle',this.value)" on>
													<option value="null">Elige una Sucursal</option>
													<?php
													$query_t_u = "select * from sucursales order by id_sucursal asc";
													$tabla_t_u = mysqli_query($conexion, $query_t_u);
													while ($registro_t_u = mysqli_fetch_array($tabla_t_u)) {
														if ($registro_t_u[0] == $registro[13]) {
															echo "<option value=\"$registro_t_u[0]\" selected>$registro_t_u[0] - $registro_t_u[1]</option>";
														} else {
															echo "<option value=\"$registro_t_u[0]\">$registro_t_u[0] - $registro_t_u[1]</option>";
														}
													}
													?>
												</select>
											</td>
										</tr>

										<tr>
											<td>ID Tap</td>
											<td><input name="id_tap" style="width:100px;font-size:12px;" value="<?php echo $registro[0]; ?>" type="text" maxlength="20" /></td>
										</tr>

										<tr>
											<td>Calle</td>
											<td>
												<div id="div_calle">
													<select name="calle" div="calle">
														<?php
														$query_t_u = "select * from cat_calles where id_sucursal='" . $registro[13] . "'";
														$tabla_t_u = mysqli_query($conexion, $query_t_u);
														while ($registro_t_u = mysqli_fetch_array($tabla_t_u)) {
															if ($registro_t_u[0] == $registro[1]) {
																echo "<option value=\"$registro_t_u[0]\" selected>$registro_t_u[2]</option>";
															} else {
																echo "<option value=\"$registro_t_u[0]\">$registro_t_u[2]</option>";
															}
														}

														?>
													</select>
												</div>
											</td>
										</tr>

										<tr>
											<td>Poste #</td>
											<td><input name="poste" style="width:100px;font-size:12px;" type="text" maxlength="15" value="<?php echo $registro[2]; ?>" /></td>
										</tr>
										<tr>
											<td>Tipo de Poste (CFE/PROPIO/OTRO)</td>
											<td><input name="tipoposte" style="width:100px;font-size:12px;" type="text" maxlength="15" value="<?php echo $registro[3]; ?>" /></td>
										</tr>
										<tr>
											<td>Trayectoria</td>
											<td><input onchange="solo_numeros(this)" onkeyup="solo_numeros(this)" name="trayectoria" style="width:100px;font-size:12px;" type="text" maxlength="15" value="<?php echo $registro[4]; ?>" /></td>
										</tr>
										<tr>
											<td>Fibra/Coaxial</td>
											<td><input name="fibracoaxial" style="width:100px;font-size:12px;" type="text" maxlength="255" value="<?php echo $registro[5]; ?>" /></td>
										</tr>
										<tr>
											<td>Especificacion de cable</td>
											<td><input name="especificacion" style="width:100px;font-size:12px;" type="text" maxlength="255" value="<?php echo $registro[6]; ?>" /></td>
										</tr>
										<tr>
											<td>Ingrese KG/KM de fabrica</td>
											<td><input name="pesofabrica" id="pesofabrica" onchange="calcular();solo_numeros_decimales(this)" style="width:100px;font-size:12px;" type="text" maxlength="15" value="<?php echo $registro[16]; ?>" /></td>
										</tr>
										<tr>
											<td>Del poste</td>
											<td><input name="delposte" onchange="solo_numeros(this)" onkeyup="solo_numeros(this)" style="width:100px;font-size:12px;" type="text" maxlength="11" value="<?php echo $registro[7]; ?>" /></td>
										</tr>
										<tr>
											<td>Al poste</td>
											<td><input name="alposte" onchange="solo_numeros(this)" onkeyup="solo_numeros(this)" style="width:100px;font-size:12px;" type="text" maxlength="11" value="<?php echo $registro[8]; ?>" /></td>
										</tr>
										<tr>
											<td>Distancia entre postes</td>
											<td><input name="distancia" id="distancia" onchange="solo_numeros_decimales(this);calcular()" onkeyup="solo_numeros_decimales(this);calcular()" style="width:100px;font-size:12px;" type="text" maxlength="11" value="<?php echo $registro[9]; ?>" /></td>
										</tr>
										<tr>
											<td>Peso Kg/Km de trayectoria</td>
											<td><input name="peso" id="peso" style="width:100px;font-size:12px;" type="text" maxlength="255" value="<?php echo $registro[10]; ?>" readonly="readonly" /></td>
										</tr>
										<tr>
											<td>Latitud (UTM)</td>
											<td><input name="latitud" style="width:100px;font-size:12px;" type="text" maxlength="255" value="<?php echo $registro[11]; ?>" /></td>
										</tr>
										<tr>
											<td>Longitud (UTM)</td>
											<td><input name="longitud" style="width:100px;font-size:12px;" type="text" maxlength="255" value="<?php echo $registro[12]; ?>" /></td>
										</tr>
										<tr>
											<td>Latitud (GRADOS)</td>
											<td><input name="latitudG" style="width:100px;font-size:12px;" type="text" maxlength="255" value="<?php echo $registro[19]; ?>" /></td>
										</tr>
										<tr>
											<td>Longitud (GRADOS)</td>
											<td><input name="longitudG" style="width:100px;font-size:12px;" type="text" maxlength="255" value="<?php echo $registro[20]; ?>" /></td>
										</tr>
										<tr>
											<td>Zona</td>
											<td><input name="zona" style="width:100px;font-size:12px;" type="text" maxlength="255" value="<?php echo $registro[17]; ?>" /></td>
										</tr>
										<tr>
											<td>
												<center>Clientes en TAP</center>
											</td>
										</tr>
										<?php
										$query_t_u = "select * from clientes where id_tap='" . $registro[0] . "' and id_tipo_status not in (4,5,7,8,9,10,11)";
										$tabla_t_u = mysqli_query($conexion, $query_t_u);

										while ($registro_t_u = mysqli_fetch_array($tabla_t_u)) {
											echo "<tr><td>" . $registro_t_u[0] . " - " . $registro_t_u[4] . " " . $registro_t_u[5] . " " . $registro_t_u[6] . "</td></tr>";
										}

										?>
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