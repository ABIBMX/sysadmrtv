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
			document.datagrid.action = "index.php?menu=10&accion=editar"
			document.datagrid.submit();
		} else {
			if (contador == 0)
				window.alert("No ha seleccionado nada.");
			else
				window.alert("Solo puede seleccionar 1 registro");
		}
	}

	function internet() {

		// Selecciona todos los checkboxes con el id "check"
		let checkboxes = document.querySelectorAll('input[type="checkbox"][id="check"]');

		// Variable para contar los checkboxes seleccionados
		let seleccionados = [];

		// Recorre los checkboxes para verificar los seleccionados
		checkboxes.forEach(function(checkbox) {
			if (checkbox.checked) {
				seleccionados.push(checkbox.value); // Guarda el nombre del checkbox seleccionado
			}
		});

		// Verifica cuántos checkboxes están seleccionados
		if (seleccionados.length >= 2) {
			window.alert("No puedes seleccionar más de dos.");
		} else if (seleccionados.length === 1) {
		    
		    console.log(seleccionados[0]);

			if (seleccionados[0] == 'SERVICIO TV + INTERNET' || seleccionados[0] == 'INSTALACION SOLO INTERNET' || seleccionados[0] == 'CAMBIO DE TV + INTERNET POR INTERNET') {
				document.datagrid.action = "index.php?menu=10&accion=configurar"
				document.datagrid.submit();
				// Si solo hay uno seleccionado, muestra el alert con su valor
				// alert("Seleccionaste: " + seleccionados[0]);
			} else {
				// Si no es ninguno de los valores anteriores, muestra el siguiente alert
				window.alert("No puedes configurar datos de internet, por que el servicio no lo requiere.");

			}
		} else {
			window.alert("No ha seleccionado nada.");
		}
	}

	function imprimir_pdf() {
		var aux_action = document.datagrid.action;
		var aux_target = document.datagrid.target;
		document.datagrid.action = "reporte/clientes_pdf.php";
		document.datagrid.target = "_blank";
		document.datagrid.submit();
		document.datagrid.action = aux_action;
		document.datagrid.target = aux_target;

	}

	function imprimir_excel() {
		var aux_action = document.datagrid.action;
		var aux_target = document.datagrid.target;
		document.datagrid.action = "reporte/clientes_excel.php";
		document.datagrid.target = "_blank";
		document.datagrid.submit();
		document.datagrid.action = aux_action;
		document.datagrid.target = aux_target;
	}

	function contrato() {
		var contador = 0;
		for (var j = 1; j < document.datagrid.elements.length; j++) {
			if (document.datagrid.elements[j].checked) {
				contador++;
			}
		}
		if (contador == 1) {
			var aux_action = document.datagrid.action;
			var aux_target = document.datagrid.target;
			document.datagrid.action = "reporte/imprimir_contrato.php";
			document.datagrid.target = "_blank";
			document.datagrid.submit();
			document.datagrid.action = aux_action;
			document.datagrid.target = aux_target;

		} else {
			if (contador == 0)
				window.alert("No ha seleccionado nada.");
			else
				window.alert("Solo puede seleccionar 1 registro");
		}
	}

	function caratula() {
		var contador = 0;
		for (var j = 1; j < document.datagrid.elements.length; j++) {
			if (document.datagrid.elements[j].checked) {
				contador++;
				document.getElementById('id_cliente').value = document.datagrid.elements[j].name;
			}
		}
		if (contador == 1) {
			var aux_action = document.datagrid.action;
			var aux_target = document.datagrid.target;
			document.datagrid.action = "reporte/imprimir_nota_ingreso_caratula.php";
			document.datagrid.target = "_blank";
			document.datagrid.submit();
			document.datagrid.action = aux_action;
			document.datagrid.target = aux_target;

		} else {
			if (contador == 0)
				window.alert("No ha seleccionado nada.");
			else
				window.alert("Solo puede seleccionar 1 registro");
		}
	}

	//Se han agregado estas dos variables obligatorias 
	var contenedor_cliente = ""; //Se actualiza para saber en que input se coloca la llave del cliente
	var parametro_sucursal_cliente = "<?php echo $_SESSION['tuvision_id_sucursal']; ?>"; // Se utiliza en caso de que queramos la lista de clientes de una sucursal en especifica
	function cambio_id_cliente(id) {}
	/*
	function eliminar()
	{
		document.datagrid.accion.value = "eliminar";
		var checado="no";
		for(var j = 1; j<document.datagrid.elements.length; j++)
		{
			if(document.datagrid.elements[j].checked)
			{
				checado = "si";
			}
		}
		if(checado=="si")
		{
			if(window.confirm("¿Estás seguro de ELIMINAR los registros seleccionados?"))
				document.datagrid.submit();
		}
		else
		{
			window.alert("No ha seleccionado ningun registro");
		}
	}
	*/
</script>
<div style="display:none" id="filtro_div"></div>
<table border="0px" width="100%" style="color:#000000;font-size:12px">
	<tr>
		<td align="right">
			<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="5px" background="imagenes/module_left.png"></td>
					<td width="70px" background="imagenes/module_center.png" height="80" valign="middle"><img src="imagenes/usuarios.png" /></td>
					<td align="left" background="imagenes/module_center.png" height="80" valign="middle" class="titulo"><b>&nbsp;&nbsp;CLIENTES&nbsp;&nbsp;</b></td>
					<td align="right" background="imagenes/module_center.png" height="80">
						<button class="boton2" onclick="createWindow('Filtro',480,300 ,7,false,true);"><img src="imagenes/filter.png" /><br />Filtro</button>
						<button class="boton2" onclick="contrato();"><img src="imagenes/imprimir.png" /><br />Contrato</button>
						<button class="boton2" onclick="caratula();"><img src="imagenes/imprimir.png" /><br />Caratula</button>
						<?php
						if (isset($_POST['aplicar_filtro'])) {
						?>
							<button class="boton2" onclick="imprimir_pdf()"><img src="imagenes/imprimir.png" /><br />PDF</button>
							<button class="boton2" onclick="imprimir_excel()"><img src="imagenes/imprimir.png" /><br />EXCEL</button>
						<?php
						}
						?>
						<button class="boton2" onclick="location.href='index.php?menu=10&accion=agregar'"><img src="imagenes/agregar.png" /><br />Agregar</button>
						<button class="boton2" onclick="editar()"><img src="imagenes/editar.png" /><br />Editar</button>
						<button class="boton2" onclick="internet()"><img src="imagenes/configuracion.png" /><br />Internet</button>
						<!--<button class="boton2" onclick="eliminar()"><img src="imagenes/eliminar.png" /><br />Eliminar</button>-->
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
				$_POST['calle'] = addslashes($_POST['calle']);
				$_POST['nombre'] = addslashes(strtoupper($_POST['nombre']));
				$_POST['apellido_paterno'] = addslashes(strtoupper($_POST['apellido_paterno']));
				$_POST['apellido_materno'] = addslashes(strtoupper($_POST['apellido_materno']));
				$_POST['numero'] = addslashes(strtoupper($_POST['numero']));
				// $_POST['tarifa'] = addslashes(strtoupper($_POST['tarifa']));
				$_POST['num_contrato'] = addslashes(strtoupper($_POST['num_contrato']));
				$_POST['fecha_contrato'] = addslashes(strtoupper($_POST['fecha_contrato']));
				$_POST['referencia_casa'] = addslashes(strtoupper($_POST['referencia_casa']));

				if (isset($_POST['tap'])) {
					if ($_POST['tap'] == 'null') {
						$tap = "NULL";
					} else {
						$tap = "'" . addslashes($_POST['tap']) . "'";
					}
				} else {
					$tap = "NULL";
				}

				$query = "update clientes set nombre='" . $_POST['nombre'] . "',apellido_paterno='" . $_POST['apellido_paterno'] . "', apellido_materno='" . $_POST['apellido_materno'] . "', numero='" . $_POST['numero'] . "', id_calle=" . $_POST['calle'] . ",  num_contrato='" . $_POST['num_contrato'] . "', fecha_contrato='" . $_POST['fecha_contrato'] . "', referencia_casa='" . $_POST['referencia_casa'] . "', id_tap=" . $tap . ", colonia='" . $_POST['colonia'] . "',numero_interior='" . $_POST['numero_interior'] . "',cp='" . $_POST['cp'] . "',telefono='" . $_POST['telefono'] . "',rfc='" . $_POST['rfc'] . "',correo='" . $_POST['email'] . "' , tipo_contratacion = '".$_POST['tipo_contratacion'] ."'  where id_cliente='" . addslashes($_POST['id']) . "'";

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

				$_POST['calle'] = addslashes($_POST['calle']);
				$_POST['nombre'] = addslashes(strtoupper($_POST['nombre']));
				$_POST['apellido_paterno'] = addslashes(strtoupper($_POST['apellido_paterno']));
				$_POST['apellido_materno'] = addslashes(strtoupper($_POST['apellido_materno']));
				$_POST['numero'] = addslashes(strtoupper($_POST['numero']));
				$_POST['tarifa'] = addslashes(strtoupper($_POST['tarifa']));
				$_POST['num_contrato'] = addslashes(strtoupper($_POST['num_contrato']));
				$_POST['fecha_contrato'] = addslashes(strtoupper($_POST['fecha_contrato']));
				$_POST['referencia_casa'] = addslashes(strtoupper($_POST['referencia_casa']));

				if (isset($_POST['tap'])) {
					if ($_POST['tap'] == 'null') {
						$tap = "NULL";
					} else {
						$tap = "'" . addslashes($_POST['tap']) . "'";
					}
				} else {
					$tap = "NULL";
				}


				//Calcular la siguiente clave del cliente
				$siguiente_subclave_query = "select MAX(SUBSTR(id_cliente,4))+ 1 AS SIGUIENTE from clientes where id_sucursal='" . $_SESSION['tuvision_id_sucursal'] . "'";
				$subclave_generada = devolverValorQuery($siguiente_subclave_query);
				if ($subclave_generada[0] == "") {
					$subclave_generada[0] = '1';
				}

				$total_digitos =  strlen($subclave_generada[0]);

				//Agregamos 0 a la derecha del digito hasta completar el formato XXX00000

				for ($i = $total_digitos; $i < 5; $i++) {
					$subclave_generada[0] = '0' . $subclave_generada[0];
				}

				$clave = $_SESSION['tuvision_id_sucursal'] . $subclave_generada[0];

				$query = "insert into clientes (id_cliente,id_sucursal, id_tipo_status, id_calle, nombre, apellido_paterno, apellido_materno, numero, tarifa, num_contrato, fecha_contrato, referencia_casa,fecha_registro,id_tap ,colonia,numero_interior,cp,telefono,rfc,correo) values ('" . $clave . "','" . $_SESSION['tuvision_id_sucursal'] . "',11,'" . $_POST['calle'] . "','" . $_POST['nombre'] . "','" . $_POST['apellido_paterno'] . "','" . $_POST['apellido_materno'] . "','" . $_POST['numero'] . "'," . $_POST['tarifa'] . ",'" . $_POST['num_contrato'] . "','" . $_POST['fecha_contrato'] . "','" . $_POST['referencia_casa'] . "','" . date('Y-m-d') . "'," . $tap . ",'" . $_POST['colonia'] . "','" . $_POST['numero_interior'] . "','" . $_POST['cp'] . "','" . $_POST['telefono'] . "','" . $_POST['rfc'] . "','" . $_POST['email'] . "')";

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

					<!-- Redirigir usando JavaScript después de mostrar el mensaje -->
					<script>
						setTimeout(function() {
							window.location.href = "https://sysadmrtv.tuvisiontelecable.com.mx/index.php?menu=12&accion=agregar";
						}, 3000); // Redirige después de 3 segundos
					</script>
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
				/*
				case 'eliminar':
					foreach($_POST as $variable => $valor)
					{
						if($variable != "selector")
						{
							if($variable != "accion")
							{
								$query_eliminar = "DELETE FROM sucursales WHERE id_sucursal='".addslashes($variable)."'";
								if(mysqli_query($conexion,$query_eliminar))
									$bandera = true;
									
								else
									$bandera=false;											
							} 
						}
					}
					if($bandera)
					{
						?>
						<tr>
                        	<td colspan="3" align="center">
                            	<table border="0" width="100%" cellpadding="0" cellspacing="0" >
                                    <tr>                                    	
                                        <td width="5px" background="imagenes/message_left.png"></td>
                                        <td align="center" background="imagenes/message_center.png" height="30" valign="middle" class="fine">Los registros fueron eliminados.</td>
                                        <td width="5px" background="imagenes/message_right.png"></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
						<?php
					}
					else
					{
						?>
						 <tr>
                        	<td colspan="3" align="center">
                            	<table border="0" width="100%" cellpadding="0" cellspacing="0" >
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
				*/
		}
	}
	?>
	<tr>
		<td height="10px"></td>
	</tr>
	<tr>
		<td colspan="3">
			<form name="datagrid" method="post">
				<input type="hidden" name="id_cliente" id="id_cliente">
				<table class="datagrid" width="100%" border="0" cellspacing="0">
					<tr>
						<td colspan="9" height="3px" class="separador"></td>
					</tr>
					<tr class="tabla_columns">
						<td>Clave</td>
						<td>Nombre</td>
						<td>Sucursal</td>
						<td>Estatus</td>
						<td>Tipo Estatus</td>
						<td>Tipo de Servicio</td>
						<td>Estatus Servicio Internet</td>
						<td>Fecha Activacion</td>
						<td>Fecha Ultimo Reporte</td>
						<td>Estatus Servicio</td>
						<td>Ultimo Servicio</td>
						<td>Ultimo Ingreso</td>
						<td align="center" width="50px"><input type="checkbox" name="selector" onclick="seleccionar()" /><input type='hidden' name='accion' /></td>
					</tr>

					<?php

					if (isset($_POST['aplicar_filtro'])) {
						$add_query = "";

						if ($_POST['id_cliente'] != "") {
							$add_query .= " and c.id_cliente='" . addslashes($_POST['id_cliente']) . "' ";
						}



						if ($_POST['status'] != "") {
							$add_query .= " and sc.id_status='" . addslashes($_POST['status']) . "' ";
						}


						if ($_POST['fecha_registro_desde'] != "" && $_POST['fecha_registro_hasta'] != "") {
							$add_query .= " and c.fecha_registro between '" . addslashes($_POST['fecha_registro_desde']) . "' and '" . addslashes($_POST['fecha_registro_hasta']) . "' ";
						}

						if ($_POST['fecha_contrato_desde'] != "" && $_POST['fecha_contrato_hasta'] != "") {
							$add_query .= " and c.fecha_contrato between '" . addslashes($_POST['fecha_contrato_desde']) . "' and '" . addslashes($_POST['fecha_contrato_hasta']) . "' ";
						}

						if ($_POST['fecha_activacion_desde'] != "" && $_POST['fecha_activacion_hasta'] != "") {
							$add_query .= " and c.fecha_activacion between '" . addslashes($_POST['fecha_activacion_desde']) . "' and '" . addslashes($_POST['fecha_activacion_hasta']) . "' ";
						}

						//Primer consulta para la table de clientes
						//$query = "select c.id_cliente, concat(c.nombre,' ',c.apellido_paterno,' ',c.apellido_materno), s.nombre, sc.descripcion, tsc.descripcion, c.tipo_contratacion, c.fecha_contrato, c.fecha_activacion, c.tipo_contratacion, c.configuracion_internet from clientes c, sucursales s, estatus_cliente sc, tipo_status_cliente tsc where c.id_sucursal= s.id_sucursal and c.id_tipo_status = tsc.id_tipo_status and tsc.id_status= sc.id_status and c.id_sucursal='" . $_SESSION['tuvision_id_sucursal'] . "'  " . $add_query . " order by c.id_sucursal asc, c.id_cliente asc";


						//Segunda consulta para la table de clientes trayendo el ultimo reporte de servicios
// 						$query = "SELECT
//     c.id_cliente,
//     CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) AS nombre_completo,
//     s.nombre AS nombre_sucursal,
//     sc.descripcion AS estatus_cliente,
//     tsc.descripcion AS tipo_estatus_cliente,
//     c.tipo_contratacion,
//     c.fecha_contrato,
//     c.fecha_activacion,
//     c.configuracion_internet,
//     MAX(rs.fecha_reporte) AS ultimo_fecha_reporte,
//     MAX(ess.descripcion) AS ultimo_estatus_servicio,
//     COALESCE(MAX(cts.descripcion), 'Sin reporte') AS ultimo_tipo_servicio
// FROM
//     clientes c
// JOIN
//     sucursales s ON c.id_sucursal = s.id_sucursal
// JOIN
//     tipo_status_cliente tsc ON c.id_tipo_status = tsc.id_tipo_status
// JOIN
//     estatus_cliente sc ON tsc.id_status = sc.id_status
// LEFT JOIN (
//     SELECT
//         id_cliente,
//         MAX(fecha_reporte) AS max_fecha_reporte
//     FROM
//         reporte_servicios
//     GROUP BY
//         id_cliente
// ) AS ultimo_reporte ON c.id_cliente = ultimo_reporte.id_cliente
// LEFT JOIN
//     reporte_servicios rs ON c.id_cliente = rs.id_cliente AND ultimo_reporte.max_fecha_reporte = rs.fecha_reporte
// LEFT JOIN
//     estatus_servicio ess ON rs.id_estatus_servicio = ess.id_estatus_servicio
// LEFT JOIN
//     cat_tipo_servicios cts ON
//         CASE
//             WHEN rs.id_peticion = 1 THEN cts.id_tipo_servicio IN (
//                 SELECT
//                     id_tipo_servicio
//                 FROM
//                     rel_tipo_ingreso_servicio
//                 WHERE
//                     id_tipo_ingreso IN (
//                         SELECT
//                             id_tipo_ingreso
//                         FROM
//                             montos
//                         WHERE
//                             id_ingreso = rs.id_ingreso
//                     )
//             )
//             ELSE cts.id_peticion = rs.id_peticion AND cts.id_tipo_servicio = (
//                 SELECT
//                     id_tipo_servicio
//                 FROM
//                     cliente_servicios
//                 WHERE
//                     id_reporte = rs.id_reporte
//                 LIMIT 1
//             )
//         END
// WHERE
//     c.id_sucursal = '" . $_SESSION['tuvision_id_sucursal'] . "'
//     " . $add_query . "
// GROUP BY
//     c.id_cliente,
//     nombre_completo,
//     nombre_sucursal,
//     estatus_cliente,
//     tipo_estatus_cliente,
//     c.tipo_contratacion,
//     c.fecha_contrato,
//     c.fecha_activacion,
//     c.configuracion_internet
// ORDER BY
//     c.id_sucursal ASC,
//     c.id_cliente ASC";

//Tercer consulta para la table de clientes trayendo el ultimo reporte de servicios con estado atendido
// $query = "SELECT
//     c.id_cliente,
//     CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) AS nombre_completo,
//     s.nombre AS nombre_sucursal,
//     sc.descripcion AS estatus_cliente,
//     tsc.descripcion AS tipo_estatus_cliente,
//     c.tipo_contratacion,
//     c.fecha_contrato,
//     c.fecha_activacion,
//     c.configuracion_internet,
//     rs.fecha_reporte AS ultimo_fecha_reporte,
//     ess.descripcion AS ultimo_estatus_servicio,
//     COALESCE(cts.descripcion, 'Sin reporte') AS ultimo_tipo_servicio
// FROM
//     clientes c
// JOIN
//     sucursales s ON c.id_sucursal = s.id_sucursal
// JOIN
//     tipo_status_cliente tsc ON c.id_tipo_status = tsc.id_tipo_status
// JOIN
//     estatus_cliente sc ON tsc.id_status = sc.id_status
// LEFT JOIN (
//     SELECT
//         id_cliente,
//         MAX(fecha_reporte) AS max_fecha_reporte
//     FROM
//         reporte_servicios
//     WHERE
//         id_estatus_servicio = 2 
//     GROUP BY
//         id_cliente
// ) AS ultimo_reporte ON c.id_cliente = ultimo_reporte.id_cliente
// LEFT JOIN
//     reporte_servicios rs ON c.id_cliente = rs.id_cliente 
//     AND ultimo_reporte.max_fecha_reporte = rs.fecha_reporte
// LEFT JOIN
//     estatus_servicio ess ON rs.id_estatus_servicio = ess.id_estatus_servicio
// LEFT JOIN
//     cat_tipo_servicios cts ON
//         CASE
//             WHEN rs.id_peticion = 1 THEN cts.id_tipo_servicio IN (
//                 SELECT
//                     id_tipo_servicio
//                 FROM
//                     rel_tipo_ingreso_servicio
//                 WHERE
//                     id_tipo_ingreso IN (
//                         SELECT
//                             id_tipo_ingreso
//                         FROM
//                             montos
//                         WHERE
//                             id_ingreso = rs.id_ingreso
//                     )
//             )
//             ELSE cts.id_peticion = rs.id_peticion AND cts.id_tipo_servicio = (
//                 SELECT
//                     id_tipo_servicio
//                 FROM
//                     cliente_servicios
//                 WHERE
//                     id_reporte = rs.id_reporte
//                 LIMIT 1
//             )
//         END
// WHERE
//     c.id_sucursal = '" . $_SESSION['tuvision_id_sucursal'] . "'
//     " . $add_query . "
// ORDER BY
//     c.id_sucursal ASC,
//     c.id_cliente ASC";

	//Cuarta consulta para la table de clientes trayendo el ultimo reporte de servicios con estado atendido y el ultimo ingreso de inscripcion

	$query = "
SELECT 
    c.id_cliente, 
    CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) AS Cliente, 
    s.nombre AS Sucursal, 
    ec.descripcion AS Estatus, 
    tec.descripcion AS TipoEstatus, 
    c.tipo_contratacion AS TipoServicio, 
    c.configuracion_internet AS EstatusServicioInternet, 
    c.fecha_activacion AS FechaActivacion, 
    rs.fecha_reporte AS FechaReporte, 
    es.descripcion AS EstadoReporte, 
    
    -- Último servicio (traído con una subconsulta)
    (SELECT cts.descripcion 
     FROM cliente_servicios cs 
     INNER JOIN cat_tipo_servicios cts ON cs.id_tipo_servicio = cts.id_tipo_servicio 
     WHERE cs.id_reporte = rs.id_reporte 
     ORDER BY cs.id_cliente_servicio DESC LIMIT 1) AS UltimoServicio,  

    -- Último ingreso (traído con una subconsulta)
    (SELECT cti.descripcion 
     FROM ingresos ingaux 
     INNER JOIN montos mon ON ingaux.id_ingreso = mon.id_ingreso 
     INNER JOIN cat_tipo_ingreso cti ON mon.id_tipo_ingreso = cti.id_tipo_ingreso 
     WHERE ingaux.id_cliente = c.id_cliente 
     ORDER BY ingaux.id_ingreso DESC LIMIT 1) AS UltimoIngreso  

FROM clientes AS c
INNER JOIN sucursales AS s ON c.id_sucursal = s.id_sucursal
INNER JOIN tipo_status_cliente AS tec ON c.id_tipo_status = tec.id_tipo_status
INNER JOIN estatus_cliente AS ec ON tec.id_status = ec.id_status
LEFT JOIN reporte_servicios AS rs 
    ON rs.id_reporte = (
        SELECT MAX(rsub.id_reporte) 
        FROM reporte_servicios AS rsub 
        WHERE rsub.id_cliente = c.id_cliente
    )
LEFT JOIN estatus_servicio AS es ON rs.id_estatus_servicio = es.id_estatus_servicio

WHERE c.id_sucursal = '" . $_SESSION['tuvision_id_sucursal'] . "'  
" . $add_query . " 

ORDER BY c.id_sucursal ASC, c.id_cliente ASC";




						//primer consulta para el pdf de clientes
						//$query2 = "select c.id_cliente, concat(c.nombre,' ',c.apellido_paterno,' ',c.apellido_materno),c.telefono, s.nombre, sc.descripcion, tsc.descripcion, c.tipo_contratacion, c.fecha_contrato, c.fecha_activacion, concat(tap.id_tap,'-',tap.valor,'-',tap.salidas), cc.nombre, c.numero, c.referencia_casa  from clientes c, sucursales s, estatus_cliente sc, tipo_status_cliente tsc, tap, cat_calles cc where cc.id_calle=c.id_calle and tap.id_tap=c.id_tap and c.id_sucursal= s.id_sucursal and c.id_tipo_status = tsc.id_tipo_status and tsc.id_status= sc.id_status and c.id_sucursal='" . $_SESSION['tuvision_id_sucursal'] . "' " . $add_query . " order by c.id_sucursal asc, c.id_cliente asc";

						// $query2 = "SELECT 
        				// 			c.id_cliente, 
        				// 			CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) AS nombre_completo, 
        				// 			c.telefono, 
        				// 			s.nombre AS sucursal, 
        				// 			sc.descripcion AS estatus_cliente, 
        				// 			tsc.descripcion AS tipo_status, 
        				// 			c.tipo_contratacion, 
        				// 			c.fecha_contrato, 
        				// 			c.fecha_activacion, 
        				// 			CONCAT(tap.id_tap, '-', tap.valor, '-', tap.salidas) AS tap_info, 
        				// 			cc.nombre AS calle, 
        				// 			c.numero, 
        				// 			c.referencia_casa, 
        				// 			COALESCE(
            			// 				(SELECT t2.saldo_actual 
             			// 				FROM transacciones t2 
             			// 				WHERE t2.id_cliente = c.id_cliente 
             			// 				ORDER BY t2.id_transaccion DESC 
             			// 				LIMIT 1), 
            			// 				0
        				// 			) AS saldo_actual, 
        				// 			COALESCE(ci.winbox, '---') AS winbox,
        				// 			COALESCE(ci.mac_winbox, '---') AS mac_winbox,
        				// 			COALESCE(ci.plan_datos, '---') AS plan_datos,
        				// 			COALESCE(ci.ip_asignada_instalacion, '---') AS ip_asignada_instalacion
    					// 		FROM clientes c
    					// 		LEFT JOIN sucursales s ON c.id_sucursal = s.id_sucursal
    					// 		LEFT JOIN estatus_cliente sc ON sc.id_status = (SELECT tsc.id_status FROM tipo_status_cliente tsc WHERE tsc.id_tipo_status = c.id_tipo_status)
    					// 		LEFT JOIN tipo_status_cliente tsc ON c.id_tipo_status = tsc.id_tipo_status
    					// 		LEFT JOIN tap ON tap.id_tap = c.id_tap
    					// 		LEFT JOIN cat_calles cc ON cc.id_calle = c.id_calle
    					// 		LEFT JOIN conf_internet ci ON ci.id_cliente = c.id_cliente
   						// 	 	WHERE 1=1 
    					// 		AND c.id_sucursal = '" . $_SESSION['tuvision_id_sucursal'] . "' 
    					// 		$add_query
    					// 		ORDER BY c.id_sucursal ASC, c.id_cliente ASC";

						//Segunda consulta para el pdf de clientes con el ultimo reporte de servicios
// 						$query2 = "SELECT
//     c.id_cliente,
//     CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) AS nombre_completo,
//     c.telefono,
//     s.nombre AS sucursal,
//     sc.descripcion AS estatus_cliente,
//     tsc.descripcion AS tipo_status,
//     c.tipo_contratacion,
//     c.fecha_contrato,
//     c.fecha_activacion,
//     CONCAT(tap.id_tap, '-', tap.valor, '-', tap.salidas) AS tap_info,
//     cc.nombre AS calle,
//     c.numero,
//     c.referencia_casa,
//     COALESCE(
//         (
//             SELECT
//                 t2.saldo_actual
//             FROM
//                 transacciones t2
//             WHERE
//                 t2.id_cliente = c.id_cliente
//             ORDER BY
//                 t2.id_transaccion DESC
//             LIMIT 1
//         ),
//         0
//     ) AS saldo_actual,
//     COALESCE(ci.winbox, '---') AS winbox,
//     COALESCE(ci.mac_winbox, '---') AS mac_winbox,
//     COALESCE(ci.plan_datos, '---') AS plan_datos,
//     COALESCE(ci.ip_asignada_instalacion, '---') AS ip_asignada_instalacion,
//     MAX(rs.fecha_reporte) AS ultimo_fecha_reporte,
//     MAX(ess.descripcion) AS ultimo_estatus_servicio,
//     COALESCE(MAX(cts.descripcion), 'Sin reporte') AS ultimo_tipo_servicio
// FROM
//     clientes c
// LEFT JOIN
//     sucursales s ON c.id_sucursal = s.id_sucursal
// LEFT JOIN
//     estatus_cliente sc ON sc.id_status = (
//         SELECT
//             tsc.id_status
//         FROM
//             tipo_status_cliente tsc
//         WHERE
//             tsc.id_tipo_status = c.id_tipo_status
//     )
// LEFT JOIN
//     tipo_status_cliente tsc ON c.id_tipo_status = tsc.id_tipo_status
// LEFT JOIN
//     tap ON tap.id_tap = c.id_tap
// LEFT JOIN
//     cat_calles cc ON cc.id_calle = c.id_calle
// LEFT JOIN
//     conf_internet ci ON ci.id_cliente = c.id_cliente
// LEFT JOIN (
//     SELECT
//         id_cliente,
//         MAX(fecha_reporte) AS max_fecha_reporte
//     FROM
//         reporte_servicios
//     GROUP BY
//         id_cliente
//     ) AS ultimo_reporte ON c.id_cliente = ultimo_reporte.id_cliente
// LEFT JOIN
//     reporte_servicios rs ON c.id_cliente = rs.id_cliente AND ultimo_reporte.max_fecha_reporte = rs.fecha_reporte
// LEFT JOIN
//     estatus_servicio ess ON rs.id_estatus_servicio = ess.id_estatus_servicio
// LEFT JOIN
//     cat_tipo_servicios cts ON
//         CASE
//             WHEN rs.id_peticion = 1 THEN cts.id_tipo_servicio IN (
//                 SELECT
//                     id_tipo_servicio
//                 FROM
//                     rel_tipo_ingreso_servicio
//                 WHERE
//                     id_tipo_ingreso IN (
//                         SELECT
//                             id_tipo_ingreso
//                         FROM
//                             montos
//                         WHERE
//                             id_ingreso = rs.id_ingreso
//                     )
//             )
//             ELSE cts.id_peticion = rs.id_peticion AND cts.id_tipo_servicio = (
//                 SELECT
//                     id_tipo_servicio
//                 FROM
//                     cliente_servicios
//                 WHERE
//                     id_reporte = rs.id_reporte
//                 LIMIT 1
//             )
//         END
// WHERE
//     c.id_sucursal = '" . $_SESSION['tuvision_id_sucursal'] . "'
//     " . $add_query . "
// GROUP BY
//     c.id_cliente,
//     nombre_completo,
//     c.telefono,
//     sucursal,
//     estatus_cliente,
//     tipo_status,
//     c.tipo_contratacion,
//     c.fecha_contrato,
//     c.fecha_activacion,
//     tap_info,
//     calle,
//     c.numero,
//     c.referencia_casa,
//     winbox,
//     mac_winbox,
//     plan_datos,
//     ip_asignada_instalacion
// ORDER BY
//     c.id_sucursal ASC,
//     c.id_cliente ASC";

//Tercera consulta para el pdf de clientes con el ultimo reporte de servicios con estado atendido
// $query2 = "SELECT
//     c.id_cliente,
//     CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) AS nombre_completo,
//     c.telefono,
//     s.nombre AS sucursal,
//     sc.descripcion AS estatus_cliente,
//     tsc.descripcion AS tipo_status,
//     c.tipo_contratacion,
//     c.fecha_contrato,
//     c.fecha_activacion,
//     CONCAT(tap.id_tap, '-', tap.valor, '-', tap.salidas) AS tap_info,
//     cc.nombre AS calle,
//     c.numero,
//     c.referencia_casa,
//     COALESCE(
//         (
//             SELECT
//                 t2.saldo_actual
//             FROM
//                 transacciones t2
//             WHERE
//                 t2.id_cliente = c.id_cliente
//             ORDER BY
//                 t2.id_transaccion DESC
//             LIMIT 1
//         ),
//         0
//     ) AS saldo_actual,
//     COALESCE(ci.winbox, '---') AS winbox,
//     COALESCE(ci.mac_winbox, '---') AS mac_winbox,
//     COALESCE(ci.plan_datos, '---') AS plan_datos,
//     COALESCE(ci.ip_asignada_instalacion, '---') AS ip_asignada_instalacion,
//     rs.fecha_reporte AS ultimo_fecha_reporte,
//     ess.descripcion AS ultimo_estatus_servicio,
//     COALESCE(cts.descripcion, 'Sin reporte') AS ultimo_tipo_servicio
// FROM
//     clientes c
// LEFT JOIN
//     sucursales s ON c.id_sucursal = s.id_sucursal
// LEFT JOIN
//     estatus_cliente sc ON sc.id_status = (
//         SELECT
//             tsc.id_status
//         FROM
//             tipo_status_cliente tsc
//         WHERE
//             tsc.id_tipo_status = c.id_tipo_status
//     )
// LEFT JOIN
//     tipo_status_cliente tsc ON c.id_tipo_status = tsc.id_tipo_status
// LEFT JOIN
//     tap ON tap.id_tap = c.id_tap
// LEFT JOIN
//     cat_calles cc ON cc.id_calle = c.id_calle
// LEFT JOIN
//     conf_internet ci ON ci.id_cliente = c.id_cliente
// LEFT JOIN (
//     SELECT
//         id_cliente,
//         MAX(fecha_reporte) AS max_fecha_reporte
//     FROM
//         reporte_servicios
//     WHERE
//         id_estatus_servicio = 2
//     GROUP BY
//         id_cliente
// ) AS ultimo_reporte ON c.id_cliente = ultimo_reporte.id_cliente
// LEFT JOIN
//     reporte_servicios rs ON c.id_cliente = rs.id_cliente 
//     AND ultimo_reporte.max_fecha_reporte = rs.fecha_reporte
// LEFT JOIN
//     estatus_servicio ess ON rs.id_estatus_servicio = ess.id_estatus_servicio
// LEFT JOIN
//     cat_tipo_servicios cts ON
//         CASE
//             WHEN rs.id_peticion = 1 THEN cts.id_tipo_servicio IN (
//                 SELECT
//                     id_tipo_servicio
//                 FROM
//                     rel_tipo_ingreso_servicio
//                 WHERE
//                     id_tipo_ingreso IN (
//                         SELECT
//                             id_tipo_ingreso
//                         FROM
//                             montos
//                         WHERE
//                             id_ingreso = rs.id_ingreso
//                     )
//             )
//             ELSE cts.id_peticion = rs.id_peticion AND cts.id_tipo_servicio = (
//                 SELECT
//                     id_tipo_servicio
//                 FROM
//                     cliente_servicios
//                 WHERE
//                     id_reporte = rs.id_reporte
//                 LIMIT 1
//             )
//         END
// WHERE
//     c.id_sucursal = '" . $_SESSION['tuvision_id_sucursal'] . "'
//     " . $add_query . "
// ORDER BY
//     c.id_sucursal ASC,
//     c.id_cliente ASC";

	//Cuarta consulta para la table de clientes trayendo el ultimo reporte de servicios con estado atendido y el ultimo ingreso de inscripcion

	$query2 = "
SELECT 
    c.id_cliente, 
    CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) AS Cliente,
    c.telefono AS Telefono,
    s.nombre AS Sucursal, 
    ec.descripcion AS Estatus, 
    tec.descripcion AS TipoEstatus, 
    c.tipo_contratacion AS TipoServicio, 
    c.id_tap AS TAP,
    cc.nombre AS Calle,
    c.numero AS Numero,
    c.referencia_casa AS Referencia,
    c.fecha_activacion AS FechaActivacion,
    c.tarifa AS Tarifa, 
    
    -- Saldo actual (traído con una subconsulta)
    COALESCE((SELECT t2.saldo_actual
     FROM transacciones AS t2
     WHERE t2.id_cliente = c.id_cliente
     ORDER BY t2.id_transaccion DESC LIMIT 1), 0) AS Saldo_Actual,
     
    COALESCE(confi.winbox, '---') AS Winbox,
    COALESCE(confi.mac_winbox, '---') AS MACWinbox,
    COALESCE(confi.plan_datos, '---') AS PlanDatos,
    COALESCE(confi.ip_asignada_instalacion, '---') AS IPAsignada,
    
    rs.fecha_reporte AS FechaReporte, 
    es.descripcion AS EstadoReporte, 
    
    -- Último servicio (traído con una subconsulta)
    (SELECT cts.descripcion 
     FROM cliente_servicios cs 
     INNER JOIN cat_tipo_servicios cts ON cs.id_tipo_servicio = cts.id_tipo_servicio 
     WHERE cs.id_reporte = rs.id_reporte 
     ORDER BY cs.id_cliente_servicio DESC LIMIT 1) AS UltimoServicio,  

    c.onu_recuperada AS ONURecuperada,

    -- Último ingreso (traído con una subconsulta)
    (SELECT cti.descripcion 
     FROM ingresos ingaux 
     INNER JOIN montos mon ON ingaux.id_ingreso = mon.id_ingreso 
     INNER JOIN cat_tipo_ingreso cti ON mon.id_tipo_ingreso = cti.id_tipo_ingreso 
     WHERE ingaux.id_cliente = c.id_cliente 
     ORDER BY ingaux.id_ingreso DESC LIMIT 1) AS UltimoIngreso  

FROM clientes AS c
INNER JOIN sucursales AS s ON c.id_sucursal = s.id_sucursal
INNER JOIN tipo_status_cliente AS tec ON c.id_tipo_status = tec.id_tipo_status
INNER JOIN estatus_cliente AS ec ON tec.id_status = ec.id_status
INNER JOIN cat_calles AS cc ON cc.id_calle = c.id_calle
LEFT JOIN conf_internet AS confi 
    ON confi.id = (
        SELECT MAX(confi2.id) 
        FROM conf_internet confi2
        WHERE confi2.id_cliente = c.id_cliente
    )
LEFT JOIN reporte_servicios AS rs 
    ON rs.id_reporte = (
        SELECT MAX(rsub.id_reporte) 
        FROM reporte_servicios AS rsub 
        WHERE rsub.id_cliente = c.id_cliente
    )
LEFT JOIN estatus_servicio AS es ON rs.id_estatus_servicio = es.id_estatus_servicio

WHERE c.id_sucursal = '" . $_SESSION['tuvision_id_sucursal'] . "'  
" . $add_query . " 

ORDER BY c.id_sucursal ASC, c.id_cliente ASC";





						
						$_SESSION['tuvision_filtro_clientes'] = $query;
						$_SESSION['tuvision_filtro_clientes2'] = $query2;

						$tabla = mysqli_query($conexion, $query);
						while ($registro = mysqli_fetch_array($tabla)) {
							$bandera = true;
					?>
							<tr class="tabla_row">
								<td><a href="index.php?menu=10&accion=editar&id=<?php echo $registro[0];  ?>"><?php echo $registro[0]; ?></a></td>
								<td><a href="index.php?menu=10&accion=editar&id=<?php echo $registro[0];  ?>"><?php echo $registro[1]; ?></a></td>
								<td><a href="index.php?menu=10&accion=editar&id=<?php echo $registro[0];  ?>"><?php echo $registro[2]; ?></a></td>
								<td><a href="index.php?menu=10&accion=editar&id=<?php echo $registro[0];  ?>"><?php echo $registro[3]; ?></a></td>
								<td><a href="index.php?menu=10&accion=editar&id=<?php echo $registro[0];  ?>"><?php echo $registro[4]; ?></a></td>
								<td><a href="index.php?menu=10&accion=editar&id=<?php echo $registro[0];  ?>"><?php echo $registro[5]; ?></a></td>
								<td><a href="index.php?menu=10&accion=editar&id=<?php echo $registro[0];  ?>"><?php echo $registro[6]; ?></a></td>
								<td><a href="index.php?menu=10&accion=editar&id=<?php echo $registro[0];  ?>"><?php echo $registro[7]; ?></a></td>
								<td><a href="index.php?menu=10&accion=editar&id=<?php echo $registro[0];  ?>"><?php echo $registro[8]; ?></a></td>
								<td><a href="index.php?menu=10&accion=editar&id=<?php echo $registro[0];  ?>"><?php echo $registro[9]; ?></a></td>
								<td><a href="index.php?menu=10&accion=editar&id=<?php echo $registro[0];  ?>"><?php echo $registro[10]; ?></a></td>
								<td><a href="index.php?menu=10&accion=editar&id=<?php echo $registro[0];  ?>"><?php echo $registro[11]; ?></a></td>
								<td align="center"><input type="checkbox" id="check" name="<?php echo $registro[0];  ?>" value="<?php echo $registro[5];  ?>" /></td>
							</tr>
						<?php
						}
						if (!$bandera) {
						?>
							<tr>
								<td colspan="7">No hay Registros</td>
							</tr>
						<?php
						}
					} else {
						?>
						<tr>
							<td colspan="7">Ultilice el bot&oacute;n <b>"Filtro"</b> para hacer una b&uacute;squeda de registros</td>
						</tr>
					<?php
					}
					?>
					<tr>
						<td colspan="9" height="3px" class="separador"></td>
					</tr>
				</table>
			</form>
		</td>
	</tr>
</table>