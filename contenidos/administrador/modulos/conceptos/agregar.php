<script type="text/javascript" src="jshash-2.2/md5-min.js"></script>

<script language="javascript" type="text/javascript">
	function guardar() {
		var cadena = "";
		if (document.formulario.nombre.value == '')
			cadena += "\n* Debe asignar un nombre.";

		if (document.formulario.peticion.value == '')
			cadena += "\n* Debe seleccionar el tipo de petición.";

		if (document.formulario.tipoI.value == '')
			cadena += "\n* Debe seleccionar un tipo de ingresoo en caso de no estar relacionado seleccionar NO RELACIONADO.";

		if(document.formulario.estado.value == '')
			cadena += "\n* Debe seleccionar un estado.";

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
</script>

<table border="0px" width="100%" style="color:#000000;font-size:12px">
	<tr>
		<td align="right">
			<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="5px" background="imagenes/module_left.png"></td>
					<td width="70px" background="imagenes/module_center.png" height="80" valign="middle"><img src="imagenes/ingresos.png" /></td>
					<td align="left" background="imagenes/module_center.png" height="80" valign="middle" class="titulo"><b>&nbsp;&nbsp;AGREGAR TIPO DE SERVICIO (REPORTE DE SERVICIO)</b></td>
					<td align="right" background="imagenes/module_center.png" height="80">
						<button class="boton2" onclick="guardar()"><img src="imagenes/guardar.png" /><br />Guardar</button>
						<button class="boton2" onclick="location.href='index.php?menu=37'"><img src="imagenes/cancelar.png" /><br />Cancelar</button>
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
						<form name="formulario" method="post" onsubmit="return false;" action="index.php?menu=37">
							<table style="color:#000000" cellpadding="5">
								<tr>
									<td>Descripcion del Servicio</td>
									<td><input name="nombre" style="width:400px;font-size:12px;" type="text" maxlength="255" /></td>
								</tr>
								<tr>
									<td>Petición</td>
									<td>
										<select name="peticion" style="width:350px;font-size:12px;">
											<option value="">Selecciona una opción</option>
											<option value="1">POR PAGO REALIZADO POR EL CLIENTE</option>
											<option value="2">CLIENTE ACUDE A SUCURSAL A SOLICITAR ALGUN SERVICIO</option>
											<option value="3">POR PERSONAL DE TU VISION TELECABLE</option>
											<option value="4">PARA TECNICOS DE TUVISON TELECABLE</option>
										</select>
									</td>
								</tr>
								<tr>
									<td>Tipo de Servicio con el que se relacionara en Ingresos</td>
									<td>
										<select name="tipoI" style="width:350px; font-size:12px;">
											<option value="null">Elige una tipo de servicio de Ingreso</option>
											<?php
											$query_t_u = "SELECT * FROM cat_tipo_ingreso WHERE estado = 'Activo' AND id_tipo_ingreso NOT IN (SELECT id_tipo_ingreso FROM rel_tipo_ingreso_servicio) ORDER BY id_tipo_ingreso ASC;";
											$tabla_t_u = mysqli_query($conexion, $query_t_u);
											while ($registro_t_u = mysqli_fetch_array($tabla_t_u)) {
												echo "<option value=\"$registro_t_u[0]\">$registro_t_u[3]</option>";
											}
											?>
											<option value="otro">NO RELACIONADO</option>
										</select>
									</td>
								</tr>

								<tr>
									<td>Estado</td>
									<td>
										<select name="estado" style="width:350px;font-size:12px;">
											<option value="">Selecciona una opción</option>
											<option value="Activo">Activo</option>
											<option value="Inactivo">Inactivo</option>
										</select>
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