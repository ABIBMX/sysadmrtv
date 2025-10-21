<script type="text/javascript" src="jshash-2.2/md5-min.js"></script>

<script language="javascript" type="text/javascript">
	function guardar() {
		var cadena = "";
		if (document.formulario.nombre.value == '')
			cadena += "\n* Debe asignar un nombre.";

		if(document.formulario.es_servicio.value=='')
			cadena+= "\n* Debe seleccionar si es servicio o no.";

		if(document.formulario.tarifai.value == '')
			cadena += "\n* Debe asignar una tarifa de inscripción.";

		if(document.formulario.tarifam.value == '')
			cadena += "\n* Debe asignar una tarifa de mensualidad.";

		if(document.formulario.servicio.value == '')
			cadena += "\n* Debe seleccionar un servicio.";

		if(document.formulario.categoria.value == '')
			cadena += "\n* Debe seleccionar una categoría.";

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
					<td align="left" background="imagenes/module_center.png" height="80" valign="middle" class="titulo"><b>&nbsp;&nbsp;AGREGAR TIPO DE INGRESO</b></td>
					<td align="right" background="imagenes/module_center.png" height="80">
						<button class="boton2" onclick="guardar()"><img src="imagenes/guardar.png" /><br />Guardar</button>
						<button class="boton2" onclick="location.href='index.php?menu=5'"><img src="imagenes/cancelar.png" /><br />Cancelar</button>
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
						<form name="formulario" method="post" onsubmit="return false;" action="index.php?menu=5">
							<table style="color:#000000" cellpadding="5">
								<tr>
									<td>Descripcion del Tipo Ingreso</td>
									<td><input name="nombre" style="width:400px;font-size:12px;" type="text" maxlength="255" /></td>
								</tr>
								<tr>
									<td>¿Es servicio?</td>
									<td>
										<select name="es_servicio" style="width:200px;font-size:12px;">
											<option value="">Selecciona una opción</option>
											<option value="1">Sí</option>
											<option value="0">No</option>
										</select>
									</td>
								</tr>
								<tr>
									<td>Precio Inscripción</td>
									<td><input name="tarifai" style="width:200px;font-size:12px;" onblur="solo_numeros(this)" onkeyup="solo_numeros(this)" type="text" maxlength="255" /></td>
								</tr>
								<tr>
									<td>Tarifa Mensualidad</td>
									<td><input name="tarifam" style="width:200px;font-size:12px;" onblur="solo_numeros(this)" onkeyup="solo_numeros(this)" type="text" maxlength="255" /></td>
								</tr>
								<tr>
									<td>Servicio</td>
									<td>
										<select name="servicio" style="width:200px;font-size:12px;">
											<option value="">Selecciona una opción</option>
											<option value="COBRE">COBRE</option>
											<option value="TV CON FIBRA">TV CON FIBRA</option>
											<option value="TVINTERNET">TV + INTERNET</option>
											<option value="INTERNET">INTERNET</option>
										</select>
									</td>
								</tr>
								<tr>
									<td>Categoría</td>
									<td>
										<select name="categoria" style="width:200px;font-size:12px;">
											<option value="">Selecciona una opción</option>
											<option value="INSCRIPCIONES">INSCRIPCIONES</option>
											<option value="RECONEXIONES">RECONEXIONES</option>
											<option value="CAMBIO DE SERVICIO">CAMBIO DE SERVICIO</option>
											<option value="SUSPENSIONES">SUSPENSIONES</option>
											<option value="CANCELACIONES">CANCELACIONES</option>
											<option value="FALLAS DE SERVICIOS">FALLAS DE SERVICIOS</option>
											<option value="CONTRATACION DE ADICIONALES">CONTRATACION DE ADICIONALES</option>
											<option value="PAGO DE MENSUALIDADES">PAGO DE MENSUALIDADES</option>
											<option value="CAMBIO DE DOMICILIO">CAMBIO DE DOMICILIO</option>
										</select>
									</td>
								</tr>
								<tr>
									<td>Estado</td>
									<td>
										<select name="estado" style="width:200px;font-size:12px;">
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