<script language="javascript" type="text/javascript">
	function seleccionar() {
		if (document.datagrid.selector.checked) {
			for (var i = 1; i < document.datagrid.elements.length; i++) {
				document.datagrid.elements[i].checked = true;

			}
		} else {
			for (var i = 1; i < document.datagrid.elements.length; i++) {
				document.datagrid.elements[i].checked = false;

			}
		}
	}

	function editar() {
		var contador = 0;
		for (var j = 1; j < document.datagrid.elements.length; j++) {
			if (document.datagrid.elements[j].checked) {
				contador++;
			}
		}
		if (contador == 1) {
			document.datagrid.action = "index.php?menu=37&accion=editar"
			document.datagrid.submit();
		} else {
			if (contador == 0)
				window.alert("No ha seleccionado nada.");
			else
				window.alert("Solo puede seleccionar 1 registro");
		}
	}

	function eliminar() {
		document.datagrid.accion.value = "eliminar";
		var checado = "no";
		for (var j = 1; j < document.datagrid.elements.length; j++) {
			if (document.datagrid.elements[j].checked) {
				checado = "si";
			}
		}
		if (checado == "si") {
			if (window.confirm("Est\u00e1s seguro de ELIMINAR los registros seleccionados?"))
				document.datagrid.submit();
		} else {
			window.alert("No ha seleccionado ningun registro");
		}
	}
</script>
<table border="0px" width="100%" style="color:#000000;font-size:12px">
	<tr>
		<td align="right">
			<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="5px" background="imagenes/module_left.png"></td>
					<td width="70px" background="imagenes/module_center.png" height="80" valign="middle"><img src="imagenes/ingresos.png" /></td>
					<td align="left" background="imagenes/module_center.png" height="80" valign="middle" class="titulo"><b>&nbsp;&nbsp;Servicios Reporte Servicio (Relacion con Ingresos)</b></td>
					<td align="right" background="imagenes/module_center.png" height="80">
						<button class="boton2" onclick="location.href='index.php?menu=37&accion=agregar'"><img src="imagenes/agregar.png" /><br />Agregar</button>
						<button class="boton2" onclick="editar()"><img src="imagenes/editar.png" /><br />Editar</button>
						<button class="boton2" onclick="eliminar()"><img src="imagenes/eliminar.png" /><br />Eliminar</button>
					</td>
					<td width="5px" background="imagenes/module_right.png"></td>
				</tr>
			</table>
		</td>
	</tr>
	<?php
	if (isset($_POST['accion'])) {
		switch ($_POST['accion']) {
			case 'editar':

				$query = "update cat_tipo_servicios set descripcion='" . addslashes(strtoupper($_POST['nombre'])) . " ', id_peticion='" . addslashes($_POST['peticion']) . "', estado='" . addslashes($_POST['estado']) . "' where id_tipo_servicio='" . addslashes($_POST['id']) . "'";
				mysqli_query($conexion, $query);

				if ($_POST['tipoI'] == "otro") {
					$banderaupdate = true;
				}
				if ($_POST['tipoI'] == "desvincular") {
					$query2 = "DELETE FROM rel_tipo_ingreso_servicio WHERE id_tipo_servicio = '" . addslashes($_POST['id']) . "'";
					mysqli_query($conexion, $query2);
					$banderaupdate = true;
				} else {

					//verificando si hay una relacion
					$queryValidacion = "SELECT COUNT(*) AS total FROM rel_tipo_ingreso_servicio WHERE id_tipo_servicio='" . addslashes($_POST['id']) . "'";
					$result = mysqli_query($conexion, $queryValidacion);
					$row = mysqli_fetch_assoc($result);

					if ($row['total'] > 0) {

						//Si ya existe, actualiza el tipo de ingreso
						$query2 = "UPDATE rel_tipo_ingreso_servicio 
                   					SET id_tipo_ingreso = '" . addslashes($_POST['tipoI']) . "'
                   					WHERE id_tipo_servicio = '" . addslashes($_POST['id']) . "'";
					} else {
						// si no existe crea uno nuevo
						$query2 = "INSERT INTO rel_tipo_ingreso_servicio (id_relacion, id_tipo_ingreso, id_tipo_servicio) 
		   							VALUES (0, '" . addslashes($_POST['tipoI']) . "', '" . addslashes($_POST['id']) . "')";
					}
					mysqli_query($conexion, $query2);
					$banderaupdate = true;
				}

				if ($banderaupdate) {
	?>
					<tr>
						<td colspan="3" align="center">
							<table border="0" width="100%" cellpadding="0" cellspacing="0">
								<tr>
									<td width="5px" background="imagenes/message_left.png"></td>
									<td align="center" background="imagenes/message_center.png" height="30" valign="middle" class="fine">Los datos fueron editados correctamente</td>
									<td width="5px" background="imagenes/message_right.png"></td>
								</tr>
							</table>
						</td>
					</tr>
				<?php

				} else {
				?>
					<tr>
						<td colspan="3" align="center">
							<table border="0" width="100%" cellpadding="0" cellspacing="0">
								<tr>
									<td width="5px" background="imagenes/message_error_left.png"></td>
									<td align="center" background="imagenes/message_error_center.png" height="30" valign="middle" class="warning">Hubo un problema al editar los datos.</td>
									<td width="5px" background="imagenes/message_error_right.png"></td>
								</tr>
							</table>
						</td>
					</tr>
				<?php
				}
				break;

			case 'agregar':

				if ($_POST['tipoI'] == "otro") {

					// Insertamos un nuevo tipo de servicio
					$query = "INSERT INTO cat_tipo_servicios (id_tipo_servicio, descripcion, id_peticion, estado) 
              VALUES (0, '" . addslashes(strtoupper($_POST['nombre'])) . "', '" . addslashes($_POST['peticion']) . "', '" . addslashes($_POST['estado']) . "')";
					mysqli_query($conexion, $query);
					$banderaInsert = true;
				} else {

					// Verificamos si ya existe la relación con el tipo de ingreso
					$query = "SELECT * FROM rel_tipo_ingreso_servicio WHERE id_tipo_ingreso = '" . addslashes($_POST['tipoI']) . "'";
					$consulta = mysqli_query($conexion, $query);

					if ($registro = mysqli_fetch_assoc($consulta)) {
						// La relación ya existe
						$banderaInsert = false;
					} else {
						// Insertamos el nuevo tipo de servicio
						$query = "INSERT INTO cat_tipo_servicios (id_tipo_servicio, descripcion, id_peticion, estado)
                  VALUES (0, '" . addslashes(strtoupper($_POST['nombre'])) . "', '" . addslashes($_POST['peticion']) . "', '" . addslashes($_POST['estado']) . "')";
						mysqli_query($conexion, $query);

						// Obtenemos el id del servicio recién insertado
						$idServicio = mysqli_insert_id($conexion);

						// Insertamos la relación con el tipo de ingreso
						$query3 = "INSERT INTO rel_tipo_ingreso_servicio (id_relacion, id_tipo_ingreso, id_tipo_servicio) 
                   VALUES (0, '" . addslashes($_POST['tipoI']) . "', '" . $idServicio . "')";
						mysqli_query($conexion, $query3);

						$banderaInsert = true;
					}
				}


				if ($banderaInsert) {
				?>
					<tr>
						<td colspan="3" align="center">
							<table border="0" width="100%" cellpadding="0" cellspacing="0">
								<tr>
									<td width="5px" background="imagenes/message_left.png"></td>
									<td align="center" background="imagenes/message_center.png" height="30" valign="middle" class="fine">Los datos fueron agregados correctamente</td>
									<td width="5px" background="imagenes/message_right.png"></td>
								</tr>
							</table>
						</td>
					</tr>
				<?php
				} else {
				?>
					<tr>
						<td colspan="3" align="center">
							<table border="0" width="100%" cellpadding="0" cellspacing="0">
								<tr>
									<td width="5px" background="imagenes/message_error_left.png"></td>
									<td align="center" background="imagenes/message_error_center.png" height="30" valign="middle" class="warning">Hubo un problema al agregar los datos. Revisan las relaciones por que ya hay una existente.</td>
									<td width="5px" background="imagenes/message_error_right.png"></td>
								</tr>
							</table>
						</td>
					</tr>
				<?php
				}
				break;
			case 'eliminar':
				foreach ($_POST as $variable => $valor) {
					if ($variable != "selector") {
						if ($variable != "accion") {
							$query_eliminar = "DELETE FROM cat_tipo_servicios WHERE id_tipo_servicio='" . addslashes($variable) . "'";
							if (mysqli_query($conexion, $query_eliminar))
								$bandera = true;

							else
								$bandera = false;
						}
					}
				}
				if ($bandera) {
				?>
					<tr>
						<td colspan="3" align="center">
							<table border="0" width="100%" cellpadding="0" cellspacing="0">
								<tr>
									<td width="5px" background="imagenes/message_left.png"></td>
									<td align="center" background="imagenes/message_center.png" height="30" valign="middle" class="fine">Los registros fueron eliminados.</td>
									<td width="5px" background="imagenes/message_right.png"></td>
								</tr>
							</table>
						</td>
					</tr>
				<?php
				} else {
				?>
					<tr>
						<td colspan="3" align="center">
							<table border="0" width="100%" cellpadding="0" cellspacing="0">
								<tr>
									<td width="5px" background="imagenes/message_error_left.png"></td>
									<td align="center" background="imagenes/message_error_center.png" height="30" valign="middle" class="warning">Hubo un problema al eliminar los registros.</td>
									<td width="5px" background="imagenes/message_error_right.png"></td>
								</tr>
							</table>
						</td>
					</tr>
	<?php
				}
				break;
		}
	}
	?>
	<tr>
		<td height="10px"></td>
	</tr>
	<tr>
		<td colspan="3">
			<form name="datagrid" method="post">
				<table class="datagrid" width="100%" border="0" cellspacing="0">
					<tr>
						<td colspan="2" height="3px" class="separador"></td>
					</tr>
					<tr class="tabla_columns">
						<td>Descripción del Servicio</td>
						<td>Tipo de Ingreso (Relacionado)</td>
						<td>Peticion</td>
						<td>Activo</td>
						<td align="center" width="50px"><input type="checkbox" name="selector" onclick="seleccionar()" /><input type='hidden' name='accion' /></td>
					</tr>
					<?php
					$query = "SELECT
								CTS.id_tipo_servicio AS id,
    							CTS.descripcion AS servicio,
    							COALESCE(CTI.descripcion, 'NO RELACION') AS tipo_ingreso,
   								COALESCE(CPS.descripcion, 'NO RELACION') AS peticion_servicio,
								CTS.estado AS estado
								FROM cat_tipo_servicios AS CTS
								LEFT JOIN rel_tipo_ingreso_servicio rel 
    							ON rel.id_tipo_servicio = CTS.id_tipo_servicio
								LEFT JOIN cat_tipo_ingreso AS CTI 
    							ON rel.id_tipo_ingreso = CTI.id_tipo_ingreso
								LEFT JOIN cat_peticion_servicio AS CPS 
    							ON CTS.id_peticion = CPS.id_peticion
								WHERE CTS.estado = 'Activo'
								ORDER BY CTS.id_peticion ASC, CTS.id_tipo_servicio ASC;
							";
					$tabla = mysqli_query($conexion, $query);
					while ($registro = mysqli_fetch_array($tabla)) {
						$bandera = true;
					?>
						<tr class="tabla_row">
							<td><a href="index.php?menu=37&accion=editar&id=<?php echo $registro[0];  ?>"><?php echo $registro[1]; ?></a></td>
							<td><?php echo $registro[2]; ?></a></td>
							<td><?php echo $registro[3]; ?></a></td>
							<td><?php echo $registro[4]; ?></a></td>
							<td align="center"><input type="checkbox" name="<?php echo $registro[0];  ?>" /></td>
						</tr>
					<?php
					}
					if (!$bandera) {
					?>
						<tr>
							<td colspan="2">No hay Registros</td>
						</tr>
					<?php
					}
					?>
					<tr>
						<td colspan="2" height="3px" class="separador"></td>
					</tr>
				</table>
			</form>
		</td>
	</tr>
</table>