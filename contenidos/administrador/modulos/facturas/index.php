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
			document.datagrid.action = "index.php?menu=33&accion=editar"
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

	function imprimir_excel() {
		var aux_action = document.datagrid.action;
		var aux_target = document.datagrid.target;
		document.datagrid.action = "reporte/facturas_excel.php";
		document.datagrid.target = "_blank";
		document.datagrid.submit();
		document.datagrid.action = aux_action;
		document.datagrid.target = aux_target;

	}
</script>

<div style="display:none" id="filtro_div"></div>
<table border="0px" width="100%" style="color:#000000;font-size:12px">
	<tr>
		<td align="right">
			<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="5px" background="imagenes/module_left.png"></td>
					<td width="70px" background="imagenes/module_center.png" height="80" valign="middle"><img src="imagenes/invoice.png" /></td>
					<td align="left" background="imagenes/module_center.png" height="80" valign="middle" class="titulo"><b>&nbsp;&nbsp;FACTURAS</b></td>
					<td align="right" background="imagenes/module_center.png" height="80">
						<button class="boton2" onclick="createWindow('Filtro',390,390 ,11,false,true);"><img src="imagenes/filter.png" /><br />Filtro</button>
						<?php
						if (isset($_POST['filtro_proveedor'])) {
						?>
							<button class="boton2" onclick="imprimir_excel()"><img src="imagenes/imprimir.png" /><br />F. EXCEL</button>
						<?php
						}
						?>
						<button class="boton2" onclick="location.href='index.php?menu=33&accion=agregar'"><img src="imagenes/agregar.png" /><br />Agregar</button>
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
				$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
				$id_proveedor = filter_input(INPUT_POST, 'proveedor', FILTER_SANITIZE_NUMBER_INT);
				$canal = filter_input(INPUT_POST, 'canal', FILTER_SANITIZE_NUMBER_INT);
				$factura = filter_input(INPUT_POST, 'no_factura', FILTER_SANITIZE_NUMBER_INT);
				$descripcion = filter_input(INPUT_POST, 'descripcion', FILTER_SANITIZE_MAGIC_QUOTES);
				$id_tipo = filter_input(INPUT_POST, 'tipo_factura', FILTER_SANITIZE_NUMBER_INT);
				$id_tipo_moneda = filter_input(INPUT_POST, 'tipo_moneda', FILTER_SANITIZE_NUMBER_INT);
				$tiene_iva = filter_input(INPUT_POST, 'tiene_iva', FILTER_SANITIZE_NUMBER_INT);
				$id_status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_NUMBER_INT);

				if (isset($_POST['subtotal']) && $_POST['subtotal'] != "")
					$subtotal = filter_input(INPUT_POST, 'subtotal', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
				else
					$subtotal = 0;

				if (isset($_POST['iva']) && $_POST['iva'] != "")
					$iva = filter_input(INPUT_POST, 'iva', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
				else
					$iva = 0;


				if (isset($_POST['total']) && $_POST['total'] != "")
					$total = filter_input(INPUT_POST, 'total', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
				else
					$total = 0;

				if (isset($_POST['tipo_cambio']) && $_POST['tipo_cambio'] != "")
					$tipo_cambio = filter_input(INPUT_POST, 'tipo_cambio', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
				else
					$tipo_cambio = 0;

				if (isset($_POST['importe_pagar']) && $_POST['importe_pagar'] != "")
					$importe_a_pagar_mxn = filter_input(INPUT_POST, 'importe_pagar', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
				else
					$importe_a_pagar_mxn = 0;

				if (isset($_POST['total_pagado']) && $_POST['total_pagado'] != "")
					$total_pagado = filter_input(INPUT_POST, 'total_pagado', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
				else
					$total_pagado = 0;

				if (isset($_POST['saldo']) && $_POST['saldo'] != "")
					$saldo_factura = filter_input(INPUT_POST, 'saldo', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
				else
					$saldo_factura = 0;

				if (isset($_POST['valor_iva']) && $_POST['valor_iva'] != "")
					$valor_iva = filter_input(INPUT_POST, 'valor_iva', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
				else
					$valor_iva = 0;

				if ($_POST['fecha_recepcion'] != "")
					$fecha_recepcion = "'" . filter_input(INPUT_POST, 'fecha_recepcion', FILTER_SANITIZE_MAGIC_QUOTES) . "'";
				else
					$fecha_recepcion = "NULL";

				if (isset($_POST['fecha_pago']) && $_POST['fecha_pago'] != "")
					$fecha_pago = "'" . filter_input(INPUT_POST, 'fecha_pago', FILTER_SANITIZE_MAGIC_QUOTES) . "'";
				else
					$fecha_pago = "NULL";


				$query = "update f_facturas set
								
									id_proveedor = " . $id_proveedor . ",
									id_canal = " . $canal . ",
									no_factura = " . $factura . ",
									descripcion = '" . $descripcion . "',
									id_tipo = " . $id_tipo . ",
									id_tipo_moneda = " . $id_tipo_moneda . ",
									tiene_iva = " . $tiene_iva . ",
									valor_iva = " . $valor_iva . ",
									subtotal = " . $subtotal . ",
									iva = " . $iva . ",
									total = " . $total . ",
									tipo_cambio = " . $tipo_cambio . ",
									importe_a_pagar_mxn = " . $importe_a_pagar_mxn . ",
									total_pagado = " . $total_pagado . ",
									saldo_factura = " . $saldo_factura . ",
									id_status = " . $id_status . ",
									fecha_recepcion = " . $fecha_recepcion . ",
									fecha_pago = " . $fecha_pago . ",
									id_usuario = '" . $_SESSION['tuvision_usuario'] . "'
								 where id_factura = " . $id;


				if (mysqli_query($conexion, $query)) {
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

				$id_proveedor = filter_input(INPUT_POST, 'proveedor', FILTER_SANITIZE_NUMBER_INT);
				$canal = filter_input(INPUT_POST, 'canal', FILTER_SANITIZE_NUMBER_INT);
				$factura = filter_input(INPUT_POST, 'no_factura', FILTER_SANITIZE_NUMBER_INT);
				$descripcion = filter_input(INPUT_POST, 'descripcion', FILTER_SANITIZE_MAGIC_QUOTES);
				$id_tipo = filter_input(INPUT_POST, 'tipo_factura', FILTER_SANITIZE_NUMBER_INT);
				$id_tipo_moneda = filter_input(INPUT_POST, 'tipo_moneda', FILTER_SANITIZE_NUMBER_INT);
				$tiene_iva = filter_input(INPUT_POST, 'tiene_iva', FILTER_SANITIZE_NUMBER_INT);
				$id_status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_NUMBER_INT);

				if (isset($_POST['subtotal']) && $_POST['subtotal'] != "")
					$subtotal = filter_input(INPUT_POST, 'subtotal', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
				else
					$subtotal = 0;

				if (isset($_POST['iva']) && $_POST['iva'] != "")
					$iva = filter_input(INPUT_POST, 'iva', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
				else
					$iva = 0;

				if (isset($_POST['total']) && $_POST['total'] != "")
					$total = filter_input(INPUT_POST, 'total', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
				else
					$total = 0;

				if (isset($_POST['tipo_cambio']) && $_POST['tipo_cambio'] != "")
					$tipo_cambio = filter_input(INPUT_POST, 'tipo_cambio', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
				else
					$tipo_cambio = 0;

				if (isset($_POST['importe_pagar']) && $_POST['importe_pagar'] != "")
					$importe_a_pagar_mxn = filter_input(INPUT_POST, 'importe_pagar', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
				else
					$importe_a_pagar_mxn = 0;

				if (isset($_POST['total_pagado']) && $_POST['total_pagado'] != "")
					$total_pagado = filter_input(INPUT_POST, 'total_pagado', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
				else
					$total_pagado = 0;

				if (isset($_POST['saldo']) && $_POST['saldo'] != "")
					$saldo_factura = filter_input(INPUT_POST, 'saldo', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
				else
					$saldo_factura = 0;

				if (isset($_POST['valor_iva']) && $_POST['valor_iva'] != "")
					$valor_iva = filter_input(INPUT_POST, 'valor_iva', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
				else
					$valor_iva = 0;

				if ($_POST['fecha_recepcion'] != "")
					$fecha_recepcion = "'" . filter_input(INPUT_POST, 'fecha_recepcion', FILTER_SANITIZE_MAGIC_QUOTES) . "'";
				else
					$fecha_recepcion = "NULL";

				if (isset($_POST['fecha_pago']) && $_POST['fecha_pago'] != "")
					$fecha_pago = "'" . filter_input(INPUT_POST, 'fecha_pago', FILTER_SANITIZE_MAGIC_QUOTES) . "'";
				else
					$fecha_pago = "NULL";


				$query = "insert into f_facturas 
								(
									id_factura,
									id_proveedor,
									id_canal,
									no_factura,
									descripcion,
									id_tipo,
									id_tipo_moneda,
									tiene_iva,
									valor_iva,
									subtotal,
									iva,
									total,
									tipo_cambio,
									importe_a_pagar_mxn,
									total_pagado,
									saldo_factura,
									id_status,
									fecha_recepcion,
									fecha_pago,
									fecha_captura,
									id_usuario
								) values 
								(
									0,
									" . $id_proveedor . ",
									" . $canal . ",
									" . $factura . ",
									'" . $descripcion . "',
									" . $id_tipo . ",
									" . $id_tipo_moneda . ",
									" . $tiene_iva . ",
									" . $valor_iva . ",
									" . $subtotal . ",
									" . $iva . ",
									" . $total . ",
									" . $tipo_cambio . ",
									" . $importe_a_pagar_mxn . ",
									" . $total_pagado . ",
									" . $saldo_factura . ",
									" . $id_status . ",
									" . $fecha_recepcion . ",
									" . $fecha_pago . ",
									CURRENT_DATE(),
									'" . $_SESSION['tuvision_usuario'] . "'
								)";
				if (mysqli_query($conexion, $query)) {
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
									<td align="center" background="imagenes/message_error_center.png" height="30" valign="middle" class="warning">Hubo un problema al agregar los datos.</td>
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
							$query_eliminar = "DELETE FROM f_facturas WHERE id_factura='" . addslashes($variable) . "'";
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
			<form name="datagrid" method="post" action="index.php?menu=33">
				<table class="datagrid" width="100%" border="0" cellspacing="0">
					<tr>
						<td colspan="12" height="3px" class="separador"></td>
					</tr>
					<tr class="tabla_columns">
						<td>ID</td>
						<td>No. Factura</td>
						<td>Proveedor</td>
						<td>Importe a Pagar</td>
						<td>Status</td>
						<td>Fecha Recepcion</td>
						<td>Fecha Pago</td>
						<td align="center" width="50px"><input type="checkbox" name="selector" onclick="seleccionar()" /><input type='hidden' name='accion' /></td>
					</tr>
					<?php

					$add_query = "";


					if (isset($_POST['filtro_proveedor'])) {
						if ($_POST['filtro_proveedor'] != "-1") {
							$_POST['filtro_proveedor'] = filter_input(INPUT_POST, 'filtro_proveedor', FILTER_SANITIZE_NUMBER_INT);
							$add_query .= " and p.id_proveedor=" . $_POST['filtro_proveedor'];
						}
						if ($_POST['filtro_status'] != "-1") {
							$_POST['filtro_status'] = filter_input(INPUT_POST, 'filtro_status', FILTER_SANITIZE_NUMBER_INT);
							$add_query .= " and f.id_status=" . $_POST['filtro_status'];
						}

						if ($_POST['filtro_fecha_recepcion_desde'] != "" && $_POST['filtro_fecha_recepcion_hasta'] != "") {
							$_POST['filtro_fecha_recepcion_desde'] = filter_input(INPUT_POST, 'filtro_fecha_recepcion_desde', FILTER_SANITIZE_MAGIC_QUOTES);
							$_POST['filtro_fecha_recepcion_hasta'] = filter_input(INPUT_POST, 'filtro_fecha_recepcion_hasta', FILTER_SANITIZE_MAGIC_QUOTES);
							$add_query .= " and fecha_recepcion between '" . $_POST['filtro_fecha_recepcion_desde'] . "' and '" . $_POST['filtro_fecha_recepcion_hasta'] . "'";
						}

						if ($_POST['filtro_fecha_pago_desde'] != "" && $_POST['filtro_fecha_pago_hasta'] != "") {
							$_POST['filtro_fecha_pago_desde'] = filter_input(INPUT_POST, 'filtro_fecha_pago_desde', FILTER_SANITIZE_MAGIC_QUOTES);
							$_POST['filtro_fecha_pago_hasta'] = filter_input(INPUT_POST, 'filtro_fecha_pago_hasta', FILTER_SANITIZE_MAGIC_QUOTES);
							$add_query .= " and fecha_pago between '" . $_POST['filtro_fecha_pago_desde'] . "' and '" . $_POST['filtro_fecha_pago_hasta'] . "'";
						}




						$query = "select f.id_factura, f.no_factura, p.nombre, f.importe_a_pagar_mxn ,s.nombre,f.fecha_recepcion, f.fecha_pago from f_facturas f, f_cat_proveedor p, f_status_factura s where p.id_proveedor=f.id_proveedor and f.id_status=s.id_status" . $add_query;

						$_SESSION['filtro_tuvision_facturas_addquery'] = $add_query;

						$tabla = mysqli_query($conexion, $query);
						while (list($id, $no_factura, $proveedor, $importe, $status, $fecha_r, $fecha_pago) = mysqli_fetch_array($tabla)) {
							$bandera = true;
					?>
							<tr class="tabla_row">
								<td><a href="index.php?menu=33&accion=editar&id=<?php echo $id;  ?>"><?php echo $id; ?></a></td>
								<td><a href="index.php?menu=33&accion=editar&id=<?php echo $id;  ?>"><?php echo $no_factura; ?></a></td>
								<td><a href="index.php?menu=33&accion=editar&id=<?php echo $id;  ?>"><?php echo $proveedor; ?></a></td>
								<td><a href="index.php?menu=33&accion=editar&id=<?php echo $id;  ?>"><?php echo $importe; ?></a></td>
								<td><a href="index.php?menu=33&accion=editar&id=<?php echo $id;  ?>"><?php echo $status; ?></a></td>
								<td><a href="index.php?menu=33&accion=editar&id=<?php echo $id;  ?>"><?php echo $fecha_r; ?></a></td>
								<td><a href="index.php?menu=33&accion=editar&id=<?php echo $id;  ?>"><?php echo $fecha_pago; ?></a></td>
								<td align="center"><input type="checkbox" name="<?php echo $id;  ?>" /></td>
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
					} else {
						$query = "SELECT f.id_factura, f.no_factura, p.nombre, f.importe_a_pagar_mxn , f_status_factura.nombre, f.fecha_recepcion, f.fecha_pago FROM f_facturas f 
						INNER JOIN f_cat_proveedor AS p ON f.id_proveedor = p.id_proveedor 
						INNER JOIN f_canales ON f.id_canal = f_canales.id_canal 
						INNER JOIN f_status_factura ON f.id_status = f_status_factura.id_status 
						WHERE f_status_factura.id_status = 1 ORDER BY f.fecha_captura DESC";

						$tabla = mysqli_query($conexion, $query);
						while (list($id, $no_factura, $proveedor, $importe, $status, $fecha_r, $fecha_pago) = mysqli_fetch_array($tabla)) {
							$bandera = true;
						?>
							<tr class="tabla_row">
								<td><a href="index.php?menu=33&accion=editar&id=<?php echo $id;  ?>"><?php echo $id; ?></a></td>
								<td><a href="index.php?menu=33&accion=editar&id=<?php echo $id;  ?>"><?php echo $no_factura; ?></a></td>
								<td><a href="index.php?menu=33&accion=editar&id=<?php echo $id;  ?>"><?php echo $proveedor; ?></a></td>
								<td><a href="index.php?menu=33&accion=editar&id=<?php echo $id;  ?>"><?php echo $importe; ?></a></td>
								<td><a href="index.php?menu=33&accion=editar&id=<?php echo $id;  ?>"><?php echo $status; ?></a></td>
								<td><a href="index.php?menu=33&accion=editar&id=<?php echo $id;  ?>"><?php echo $fecha_r; ?></a></td>
								<td><a href="index.php?menu=33&accion=editar&id=<?php echo $id;  ?>"><?php echo $fecha_pago; ?></a></td>
								<td align="center"><input type="checkbox" name="<?php echo $id;  ?>" /></td>
							</tr>
					<?php
						}
					}

					?>

					<tr>
						<td colspan="12" height="3px" class="separador"></td>
					</tr>
				</table>
			</form>
		</td>
	</tr>
</table>