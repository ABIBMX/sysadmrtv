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

		if (document.formulario.estado.value == '')
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
					<td align="left" background="imagenes/module_center.png" height="80" valign="middle" class="titulo"><b>&nbsp;&nbsp;EDITAR TIPO DE INGRESO&nbsp;</b></td>
					<td align="right" background="imagenes/module_center.png" height="80">
						<button class="boton2" id="guardar" onclick="guardar()"><img src="imagenes/guardar.png" /><br />Guardar</button>
						<button class="boton2" onclick="location.href='index.php?menu=37'"><img src="imagenes/cancelar.png" /><br />Cancelar</button>
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

		$query = "SELECT
				CTS.id_tipo_servicio AS id_tipo_servicio,
    			CTS.descripcion AS servicio,
				CPS.id_peticion AS id_peticion,
				CTI.id_tipo_ingreso AS id_tipo_ingreso,
				CTS.estado AS estado
				FROM cat_tipo_servicios AS CTS
				LEFT JOIN rel_tipo_ingreso_servicio rel 
    			ON rel.id_tipo_servicio = CTS.id_tipo_servicio
				LEFT JOIN cat_tipo_ingreso AS CTI 
    			ON rel.id_tipo_ingreso = CTI.id_tipo_ingreso
				LEFT JOIN cat_peticion_servicio AS CPS 
    			ON CTS.id_peticion = CPS.id_peticion where CTS.id_tipo_servicio='" . addslashes($id) . "'";
		// $query = "select * from cat_tipo_ingreso where id_tipo_ingreso='" . addslashes($id) . "'";
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
								<form name="formulario" method="post" onsubmit="return false;" action="index.php?menu=37">
									<table style="color:#000000" cellpadding="5">
										<tr>
											<td>Descripcion del Servicio</td>
											<td><input name="nombre" style="width:400px;font-size:12px;" type="text" maxlength="255" value="<?php echo $registro[1]; ?>" /></td>
										</tr>

										<tr>
											<td>Petición</td>
											<td>
												<select name="peticion" style="width:350px;font-size:12px;">
													<option value="">Selecciona una opción</option>
													<option value="1" <?php echo ($registro[2] == 1 ? 'selected' : ''); ?>>
														POR PAGO REALIZADO POR EL CLIENTE
													</option>
													<option value="2" <?php echo ($registro[2] == 2 ? 'selected' : ''); ?>>
														CLIENTE ACUDE A SUCURSAL A SOLICITAR ALGUN SERVICIO
													</option>
													<option value="3" <?php echo ($registro[2] == 3 ? 'selected' : ''); ?>>
														POR PERSONAL DE TU VISION TELECABLE
													</option>
													<option value="4" <?php echo ($registro[2] == 4 ? 'selected' : ''); ?>>
														PARA TECNICOS DE TUVISON TELECABLE
													</option>
												</select>
											</td>
										</tr>


										<tr>
											<td>Tipo de Servicio con el que se relacionara en Ingresos</td>
											<td>
												<select name="tipoI" style="width:350px; font-size:12px;">
													<option value="null">Elige una tipo de servicio de Ingreso</option>
													<?php
													$query_t_u = "SELECT * FROM cat_tipo_ingreso WHERE estado = 'Activo' AND ( id_tipo_ingreso NOT IN (SELECT id_tipo_ingreso FROM rel_tipo_ingreso_servicio)
																	OR id_tipo_ingreso = (SELECT id_tipo_ingreso FROM rel_tipo_ingreso_servicio WHERE id_tipo_servicio = '" . addslashes($id) . "'
																	))ORDER BY id_tipo_ingreso ASC;";
													$tabla_t_u = mysqli_query($conexion, $query_t_u);
													while ($registro_t_u = mysqli_fetch_array($tabla_t_u)) {
														if ($registro[3] == $registro_t_u[0])
															echo "<option value=\"$registro_t_u[0]\" selected=\"selected\">$registro_t_u[3]</option>";
														else
															echo "<option value=\"$registro_t_u[0]\">$registro_t_u[3]</option>";
													}
													?>
													<option value="otro">NO RELACIONADO</option>
													<option value="desvincular">QUITAR INGRESO</option>
												</select>
											</td>
										</tr>

										<tr>
											<td>Estado</td>
											<td>
												<select name="estado" style="width:200px;font-size:12px;">
													<option value="">Selecciona una opción</option>
													<option value="Activo" <?php echo ($registro['estado'] == 'Activo' ? 'selected' : ''); ?>>Activo</option>
													<option value="Inactivo" <?php echo ($registro['estado'] == 'Inactivo' ? 'selected' : ''); ?>>Inactivo</option>
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