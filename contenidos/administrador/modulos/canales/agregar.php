<script type="text/javascript" src="jshash-2.2/md5-min.js"></script>

<script language="javascript" type="text/javascript">
	function guardar() {
		var cadena = "";
		if (document.formulario.nombre.value == '')
			cadena += "\n* Debe ingresar un Nombre.";

		if (document.formulario.estado.value == 'null')
			cadena += "\n* Debe ingresar un estado valido.";

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
					<td width="70px" background="imagenes/module_center.png" height="80" valign="middle"><img src="imagenes/proveedor.png" /></td>
					<td align="left" background="imagenes/module_center.png" height="80" valign="middle" class="titulo"><b>&nbsp;&nbsp;AGREGAR CANAL</b></td>
					<td align="right" background="imagenes/module_center.png" height="80">
						<button class="boton2" onclick="guardar()"><img src="imagenes/guardar.png" /><br />Guardar</button>
						<button class="boton2" onclick="location.href='index.php?menu=36'"><img src="imagenes/cancelar.png" /><br />Cancelar</button>
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
						<form name="formulario" method="post" onsubmit="return false;" action="index.php?menu=36">
							<table style="color:#000000" cellpadding="5">
								<tr>
									<td>Proveedor:</td>
									<td>
										<select name="proveedor" style="width:350px;font-size:12px;">

											<?php
											$query = "select id_proveedor,nombre from f_cat_proveedor";
											$consulta = mysqli_query($conexion, $query);
											while (list($id, $sucursal) = mysqli_fetch_array($consulta)) {
												echo "<option value='$id'>$sucursal</option>";
											}
											?>
										</select>
									</td>
								</tr>

								<tr>
									<td>Nombre:</td>
									<td><input name="nombre" style="width:350px;font-size:12px;" type="text" maxlength="255" /></td>
								</tr>


								<tr>
									<td>Estado:</td>
									<td>
										<select name="estado" id="estado" style="width:350px;font-size:12px;">
											<option value="null">Elige un estado</option>
											<option value="Activo">Activo</option>
											<option value="Cancelado">Cancelado</option>
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