<script language="javascript" type="text/javascript">
	function solo_numeros_decimales(texto) {
		var expresion = /[0-9]*\.?[0-9]{0,2}/;
		texto.value = texto.value.match(expresion);
	}

	function solo_numeros(texto) {
		var expresion = /[0-9]*/;
		texto.value = texto.value.match(expresion);
	}

	function guardar() {

		var cadena = "";

		if (document.formulario2.no_olt.value == '')
			cadena += "\n* Debe asignar un No. OLT.";

		if (document.formulario2.no_caja.value == '')
			cadena += "\n* Debe asignar un No. Caja.";

		if (document.formulario2.no_pon.value == '')
			cadena += "\n* Debe asignar un No. PON.";

		if (document.formulario2.marca_onu.value == '')
			cadena += "\n* Debe asignar una Marca ONU.";

		if (document.formulario2.modelo_onu.value == '')
			cadena += "\n* Debe ingresar el Modelo ONU.";

		if (document.formulario2.serie.value == '')
			cadena += "\n* Debe asignar una Serie.";

		if (document.formulario2.mac_address.value == '')
			cadena += "\n* Debe asignar una Mac Address.";

		if (document.formulario2.encapsulamiento.value == 'null')
			cadena += "\n* Debe asignar un tipo de Encapsulamiento.";

		if (document.formulario2.registro_winbox.value == 'null')
			cadena += "\n* Debe indicar si realizo el Registro en WINBOX.";

		if (document.formulario2.mac_winbox.value == '')
			cadena += "\n* Debe asignar una MAC de WINBOX.";

		if (document.formulario2.plan_datos.value == 'null')
			cadena += "\n* Debe indicar si cuenta con un Plan de Datos.";

		if (document.formulario2.vlan.value == '')
			cadena += "\n* Debe asignar una VLAN.";

		if (document.formulario2.ip_instaalcion.value == '')
			cadena += "\n* Debe asignar una IP de Instalación.";

		if (document.formulario2.resguardo.value == 'null')
			cadena += "\n* Debe indicar si cuenta con un Resguardo.";

		if (document.formulario2.snap.value == '')
			cadena += "\n* Debe ingresar una Salida NAP.";

		if (document.formulario2.psdivisor.value == '')
			cadena += "\n* Debe ingresar la Potencia de Salida del Divisor.";

		if (document.formulario2.plldomicilio.value == '')
			cadena += "\n* Debe ingresar la Potencia de llegada a Domicilio.";

		if (cadena == "") {

			alerta = false;

			// const optionsFecha = {
			// 	timeZone: 'America/Mexico_City',
			// 	year: 'numeric',
			// 	month: '2-digit',
			// 	day: '2-digit'
			// };

			// const optionsHora = {
			// 	timeZone: 'America/Mexico_City',
			// 	hour: 'numeric',
			// 	minute: 'numeric',
			// 	second: 'numeric',
			// 	hour12: false // Formato de 24 horas
			// };

			// // Formatear la fecha y la hora
			// const formatterFecha = new Intl.DateTimeFormat([], optionsFecha);
			// const formatterHora = new Intl.DateTimeFormat([], optionsHora);

			var cliente = "cliente=" + document.formulario2.cliente.value;
			var no_olt = "no_olt=" + document.formulario2.no_olt.value;
			var no_caja = "no_caja=" + document.formulario2.no_caja.value;
			var no_pon = "no_pon=" + document.formulario2.no_pon.value;
			var marca_onu = "marca_onu=" + document.formulario2.marca_onu.value;
			var modelo_onu = "modelo_onu=" + document.formulario2.modelo_onu.value;
			var serie = "serie=" + document.formulario2.serie.value;
			var mac_address = "mac_address=" + document.formulario2.mac_address.value;
			var encapsulamiento = "encapsulamiento=" + document.formulario2.encapsulamiento.value;
			var registro_winbox = "registro_winbox=" + document.formulario2.registro_winbox.value;
			var mac_winbox = "mac_winbox=" + document.formulario2.mac_winbox.value;
			var plan_datos = "plan_datos=" + document.formulario2.plan_datos.value;
			var vlan = "vlan=" + document.formulario2.vlan.value;
			var ip_instalacion = "ip_instalacion=" + document.formulario2.ip_instaalcion.value;
			var resguardo = "resguardo=" + document.formulario2.resguardo.value;
			var snap = "snap=" + document.formulario2.snap.value;
			var psdivisor = "psdivisor=" + document.formulario2.psdivisor.value;
			var plldomicilio = "plldomicilio=" + document.formulario2.plldomicilio.value;
			// var fecha = "fecha=" + formatterFecha.format(new Date());
			// var hora = "hora=" + formatterHora.format(new Date());

			$.ajax({
				type: "POST",
				url: "ajaxProcess/clientes.php",
				data: cliente + "&" + no_olt + "&" + no_caja + "&" + no_pon + "&" + marca_onu + "&" + modelo_onu + "&" + serie + "&" + mac_address + "&" + encapsulamiento + "&" + registro_winbox + "&" + mac_winbox + "&" + plan_datos + "&" + vlan + "&" + ip_instalacion + "&" + resguardo + "&" + snap + "&" + psdivisor + "&" + plldomicilio,
				success: alerta = true,
			});

			if (alerta) {
				alert("Datos Guardados Correctamente");
				location.reload();
			} else {
				alert("Error al guardar los datos");
			}

		} else {
			alert("Por favor verifique lo siguiente:" + cadena);
		}
	}
</script>

<table border="0px" width="100%" style="color:#000000;font-size:12px">
	<tr>
		<td align="right">
			<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="5px" background="imagenes/module_left.png"></td>
					<td width="70px" background="imagenes/module_center.png" height="80" valign="middle"><img src="imagenes/satelite.png" /></td>
					<td align="left" background="imagenes/module_center.png" height="80" valign="middle" class="titulo"><b>&nbsp;&nbsp;Datos Servicio de Internet&nbsp;&nbsp;</b></td>
					<td align="right" background="imagenes/module_center.png" height="80">
						<!-- <button class="boton2" id="guardar" onclick="guardar()"><img src="imagenes/guardar.png" /><br />Guardar</button> -->
						<button class="boton2" onclick="location.href='index.php?menu=10'"><img src="imagenes/cancelar.png" /><br />Regresar</button>
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

		$query = "select * from conf_internet where id_cliente='" . addslashes($id) . "'";
		$confInter = devolverValorQuery($query);
		if (true) {
	?>

			<!-- Formulario de informacion -->
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
							<td>Datos del Servicio de Internet</td>
						</tr>
						<tr>
							<td>
								<form name="formulario2" method="post" onsubmit="return false;" action="">
									<table style="color:#000000" cellpadding="5">

										<tr>
											<td style="font-size:10px;">Cliente:</td>
											<td style="font-size:10px;"><input name="cliente" type="text" value="<?php echo $id; ?>" readonly></td>

											<td style="font-size:10px;">No. OLT:</td>
											<td style="font-size:10px;"><input name="no_olt" type="text"></td>

											<td style="font-size:10px;">No. Caja:</td>
											<td style="font-size:10px;"><input name="no_caja" type="text"></td>

											<td style="font-size:10px;">No. PON:</td>
											<td style="font-size:10px;"><input name="no_pon" type="text"></td>

											<td style="font-size:10px;">Marca ONU:</td>
											<td style="font-size:10px;"><input name="marca_onu" type="text"></td>

										</tr>

										<tr>
											<td style="font-size:10px;">Modelo ONU:</td>
											<td style="font-size:10px;"><input name="modelo_onu" type="text"></td>

											<td style="font-size:10px;">Serie:</td>
											<td style="font-size:10px;"><input name="serie" type="text"></td>

											<td style="font-size:10px;">Mac Address:</td>
											<td style="font-size:10px;"><input name="mac_address" type="text"></td>

											<td style="font-size:10px;">Encapsulamiento:</td>
											<td style="font-size:10px;">
												<select name="encapsulamiento" style="width:170px;font-size:12px;">
													<option value="null">Elige una opción</option>
													<option value="DHCP">DHCP</option>
													<option value="PPOE">PPOE</option>
												</select>
											</td>

											<td style="font-size:10px;">Registro en WINBOX:</td>
											<td style="font-size:10px;">
												<select name="registro_winbox" style="width:170px;font-size:12px;">
													<option value="null">Elige una opción</option>
													<option value="SI">SI</option>
													<option value="NO">NO</option>
												</select>
											</td>
										</tr>

										<tr>
											<td style="font-size:10px;">MAC DE WINBOX</td>
											<td style="font-size:10px;"><input name="mac_winbox" type="text"></td>

											<td style="font-size:10px;">Plan de Datos:</td>
											<td style="font-size:10px;">
												<select name="plan_datos" style="width:170px;font-size:12px;">
													<option value="null">Elige una opción</option>
													<option value="SI">SI</option>
													<option value="NO">NO</option>
												</select>
											</td>

											<td style="font-size:10px;">VLAN:</td>
											<td style="font-size:10px;"><input name="vlan" type="text"></td>

											<td style="font-size:10px;">IP de Instalación:</td>
											<td style="font-size:10px;"><input name="ip_instaalcion" type="text"></td>

											<td style="font-size:10px;">Resguardo:</td>
											<td style="font-size:10px;">
												<select name="resguardo" style="width:170px;font-size:12px;">
													<option value="null">Elige una opción</option>
													<option value="SI">SI</option>
													<option value="NO">NO</option>
												</select>
											</td>
										</tr>

										<tr>

											<td style="font-size:10px;">Salida NAP</td>
											<td style="font-size:10px;"><input name="snap" type="text"></td>

											<td style="font-size:10px;">Potencia de Salida del Divisor:</td>
											<td style="font-size:10px;"><input name="psdivisor" type="text"></td>

											<td style="font-size:10px;">Potencia de llegada a Domicilio:</td>
											<td style="font-size:10px;"><input name="plldomicilio" type="text"></td>

											<td><button onclick='guardar()' style="background-color:#88DC65 ;">Guardar Información</button></td>

										</tr>


									</table>
								</form>
							</td>
						</tr>
						<tr>
							<td height="3px" class="separador"></td>
						</tr>
					</table>
				</td>
			</tr>


			<!-- TABLA DE CONFIGURACIONES -->
			<tr>
				<td height="10px" style="padding-top:20px;text-align: center;font-size: larger;font-weight: bold;">Configuraciones Realizadas</td>
			</tr>

			<tr>
				<td colspan="3">
					<form name="formulario4" method="post" onsubmit="return false;" action="">
						<table class="datagrid" width="100%" border="0" cellspacing="0">
							<tr class="tabla_columns">
								<td style="text-align: center; font-size: 10px">CLIENTE</td>
								<td style="text-align: center; font-size: 10px">OLT </td>
								<td style="text-align: center; font-size: 10px">CAJA</td>
								<td style="text-align: center; font-size: 10px">GPON SN</td>
								<td style="text-align: center; font-size: 10px">MARCA DE ONU</td>
								<td style="text-align: center; font-size: 10px">MODELO DE ONU</td>
								<td style="text-align: center; font-size: 10px">SERIE</td>
								<td style="text-align: center; font-size: 10px">MAC ADDRESS</td>
								<td style="text-align: center; font-size: 10px">ENCAPSULAMIENTO</td>
								<td style="text-align: center; font-size: 10px">WINBOX</td>
								<td style="text-align: center; font-size: 10px">MAC WINBOX</td>
								<td style="text-align: center; font-size: 10px">PLAN DATOS</td>
								<td style="text-align: center; font-size: 10px">VLAN</td>
								<td style="text-align: center; font-size: 10px">IP ASIGNADA EN INSTALACION</td>
								<td style="text-align: center; font-size: 10px">RESGUARDO</td>
								<td style="text-align: center; font-size: 10px">SALIDA_NAP</td>
								<td style="text-align: center; font-size: 10px">POTENCIA DE SALIDA DEL DIVISOR</td>
								<td style="text-align: center; font-size: 10px">POTENCIA DE LLEGADA A CASA</td>
								<td style="text-align: center; font-size: 10px">FECHA Y HORA </td>
								<td style="text-align: center; font-size: 10px">ESTADO</td>
							</tr>
							<?php
							$query = "SELECT * FROM conf_internet WHERE id_cliente='" . $id . "' ORDER BY id DESC";

							$tabla = mysqli_query($conexion, $query);
							while ($registro = mysqli_fetch_array($tabla)) {
								$bandera = true;
							?>
								<tr class="tabla_row">
									<td style="text-align: center;"><?php echo   $registro[1];  ?></td>
									<td style="text-align: center;"><?php echo   $registro[2];  ?></td>
									<td style="text-align: center;"><?php echo   $registro[3];  ?></td>
									<td style="text-align: center;"><?php echo   $registro[4];  ?></td>
									<td style="text-align: center;"><?php echo   $registro[5];  ?></td>
									<td style="text-align: center;"><?php echo   $registro[6];  ?></td>
									<td style="text-align: center;"><?php echo   $registro[7];  ?></td>
									<td style="text-align: center;"><?php echo   $registro[8];  ?></td>
									<td style="text-align: center;"><?php echo   $registro[9];  ?></td>
									<td style="text-align: center;"><?php echo   $registro[10];  ?></td>
									<td style="text-align: center;"><?php echo   $registro[11];  ?></td>
									<td style="text-align: center;"><?php echo   $registro[12];  ?></td>
									<td style="text-align: center;"><?php echo   $registro[13];  ?></td>
									<td style="text-align: center;"><?php echo   $registro[14];  ?></td>
									<td style="text-align: center;"><?php echo   $registro[15];  ?></td>
									<td style="text-align: center;"><?php echo   $registro[16];  ?></td>
									<td style="text-align: center;"><?php echo   $registro[17];  ?></td>
									<td style="text-align: center;"><?php echo   $registro[18];  ?></td>
									<td style="text-align: center;"><?php echo   $registro[19] . ' ' . $registro[20];  ?></td>
									<td style="text-align: center;"><?php echo   $registro[21];  ?></td>
								</tr>
							<?php
							}
							if (!$bandera) {
							?>
								<tr>
									<td colspan="6">No hay Registros</td>
								</tr>
							<?php
							}

							?>

							<tr>
								<td colspan="14" height="3px" class="separador"></td>
							</tr>
						</table>
					</form>
				</td>
			</tr>
	<?php
		}
	}
	?>