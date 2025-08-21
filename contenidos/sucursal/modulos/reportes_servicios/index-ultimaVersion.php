<script language="javascript" type="text/javascript">
	function solo_numeros_decimales(texto) {
		var expresion = /[0-9]*\.?[0-9]{0,2}/;
		texto.value = texto.value.match(expresion);
	}

	var contenedor_empleado = ""; //Se actualiza para saber en que input se coloca la llave del cliente
	var contenedor_cliente = ""; //Se actualiza para saber en que input se coloca la llave del cliente
	var parametro_sucursal_empleado = ""; // Se utiliza en caso de que queramos la lista de clientes de una sucursal en especifica
	var parametro_sucursal_cliente = ""; // Se utiliza en caso de que queramos la lista de clientes de una sucursal en especifica

	function cambio_id_empleado(id) {

	}

	function cambio_id_cliente(id) {

	}

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
			document.datagrid.action = "index.php?menu=18&accion=editar"
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
			if (window.confirm("¿Estás seguro de ELIMINAR los registros seleccionados?")) {
				document.datagrid.target = "";
				document.forms[0].action = "index.php?menu=18";
				document.datagrid.submit();
			}
		} else {
			window.alert("No ha seleccionado ningun registro");
		}
	}

	function imprimir_pdf() {
		var aux_action = document.datagrid.action;
		var aux_target = document.datagrid.target;
		document.datagrid.action = "reporte/reporte_servicio_pdf.php";
		document.datagrid.target = "_blank";
		document.datagrid.submit();
		document.datagrid.action = aux_action;
		document.datagrid.target = aux_target;

	}

	function imprimir_excel() {
		var aux_action = document.datagrid.action;
		var aux_target = document.datagrid.target;
		document.datagrid.action = "reporte/reporte_servicio_excel.php";
		document.datagrid.target = "_blank";
		document.datagrid.submit();
		document.datagrid.action = aux_action;
		document.datagrid.target = aux_target;
	}

	function reporte() {
		var aux_action = document.datagrid.action;
		var aux_target = document.datagrid.target;
		document.datagrid.action = "reporte/reporte_servicio.php";
		document.datagrid.target = "_blank";
		document.datagrid.submit();
		document.datagrid.action = aux_action;
		document.datagrid.target = aux_target;

	}
</script>

<div style="display:none" id="filtro_div"></div>

<table border="0px" width="100%" style="color:#000000;font-size:12px">

	<?php

	if (isset($_POST['accion'])) {
		switch ($_POST['accion']) {
			case 'editar':



				if (!isset($_POST['folio'])) {
					$_POST['folio'] = 'null';
				}
				$conta = 0;

				$cons_tap = "update clientes set id_tap='" . addslashes($_POST['tap']) . "' where id_cliente='" . addslashes($_POST['id_cliente']) . "'";
				mysqli_query($conexion, $cons_tap);


				$query = "update reporte_servicios set id_empleado='" . addslashes(strtoupper($_POST['empleado'])) . "',id_cliente='" . addslashes(strtoupper($_POST['id_cliente'])) . "',id_estatus_servicio='" . addslashes(strtoupper($_POST['estado'])) . "',id_tipo_atencion=" . addslashes(strtoupper($_POST['t_atencion'])) . ",id_peticion='" . addslashes(strtoupper($_POST['tipo_servicio'])) . "',id_ingreso=" . addslashes($_POST['folio']) . ",fecha_atencion='" . addslashes(strtoupper($_POST['fecha_atencion'])) . "',descripcion_atencion='" . addslashes(strtoupper($_POST['descripcion_atencion'])) . "',importe_inputable='" . addslashes(strtoupper($_POST['importe_imputable'])) . "',nota_inputable='" . addslashes(strtoupper($_POST['nota_imputable'])) . "' where id_reporte='" . addslashes($_POST['id']) . "'";


				if (mysqli_query($conexion, $query)) {

					mysqli_query($conexion, "start transaction");

					$id_rep = addslashes($_POST['id']);

					$query2 = "delete from material where id_reporte='" . addslashes($_POST['id']) . "'";
					mysqli_query($conexion, $query2);
					for ($i = 0; $i < count($_POST['nombre']); $i++) {

						$query3 = "insert into material (id_material,id_reporte,nom_bueno,cantidad_bueno,nom_reemplazo,cantidad_reemplazo,comentario) values (0,'" . addslashes(strtoupper($_POST['id'])) . "','" . addslashes(strtoupper($_POST['nombre'][$i])) . "','" . addslashes(strtoupper($_POST['cantidad'][$i])) . "','" . addslashes(strtoupper($_POST['nombre2'][$i])) . "','" . addslashes(strtoupper($_POST['cantidad2'][$i])) . "','" . addslashes(strtoupper($_POST['comentario'][$i])) . "')";
						if (mysqli_query($conexion, $query3)) {
							////////////////////
							if (addslashes(strtoupper($_POST['estado'])) == 2) {
								$query_mat1 = "update inventario set cantidad = ((cantidad)-" . addslashes(strtoupper($_POST['cantidad'][$i])) . ") where id_sucursal='" . $_SESSION['tuvision_id_sucursal'] . "' and id_equipo_inventario='" . addslashes(strtoupper($_POST['nombre'][$i])) . "'";

								$query_mat2 = "update inventario set cantidad = ((cantidad)-" . addslashes(strtoupper($_POST['cantidad2'][$i])) . ")   where id_sucursal='" . $_SESSION['tuvision_id_sucursal'] . "' and id_equipo_inventario='" . addslashes(strtoupper($_POST['nombre2'][$i])) . "'";

								if (mysqli_query($conexion, $query_mat1) && mysqli_query($conexion, $query_mat2)) {
								} else {
									mysqli_query($conexion, "rollback");
								}
							}
							////////////////////
						} else {
							$conta++;
							mysqli_query($conexion, "rollback");
	?>
							<tr>
								<td colspan="3" align="center">
									<table border="0" width="100%" cellpadding="0" cellspacing="0">
										<tr>
											<td width="5px" background="imagenes/message_error_left.png"></td>
											<td align="center" background="imagenes/message_error_center.png" height="30" valign="middle" class="warning">Hubo un problema al editar los datos .</td>
											<td width="5px" background="imagenes/message_error_right.png"></td>
										</tr>
									</table>
								</td>
							</tr>
						<?php
						}
					}

					$querydel = "delete from cliente_servicios where id_reporte='" . addslashes($_POST['id']) . "'";
					if (mysqli_query($conexion, $querydel)) {
					} else {
						$conta++;
						mysqli_query($conexion, "rollback");
					}

					if (isset($_POST['servicio']))
						foreach ($_POST['servicio'] as $valor) {
							$queryc_s = "insert into cliente_servicios (id_cliente_servicio,id_reporte, id_tipo_servicio) values (0,'" . addslashes($_POST['id']) . "','$valor')";
							if (mysqli_query($conexion, $queryc_s)) {
								/////////////////////////

								if (addslashes(strtoupper($_POST['estado'])) == 2) {
									$update_status = "";

									if (addslashes(strtoupper($_POST['tipo_servicio'])) == 1) {
										switch ($valor) {
											case 1:
												$update_status = "update clientes set fecha_activacion='" . addslashes($_POST['fecha_atencion']) . "',id_tipo_status='1' where id_cliente='" . addslashes(strtoupper($_POST['id_cliente'])) . "'";
												break;
											case 3:
												$update_status = "update clientes set id_tipo_status='1' where id_cliente='" . addslashes(strtoupper($_POST['id_cliente'])) . "'";
												break;
											case 4:
												$update_status = "update clientes set id_tipo_status='6' where id_cliente='" . addslashes(strtoupper($_POST['id_cliente'])) . "'";
												break;
											case 33:
												//Instalacion nueva internet + tv
												$update_status = "update clientes set fecha_activacion='" . addslashes($_POST['fecha_atencion']) . "', id_tipo_status='1' where id_cliente='" . addslashes(strtoupper($_POST['id_cliente'])) . "'";
												break;

											case 34:
												//Instalacion solo internet
												$update_status = "update clientes set fecha_activacion='" . addslashes($_POST['fecha_atencion']) . "', id_tipo_status='1' where id_cliente='" . addslashes(strtoupper($_POST['id_cliente'])) . "'";
												break;

											case 35:
												//Reconexion de servicio solo internet
												$update_status = "update clientes set id_tipo_status='1' where id_cliente='" . addslashes(strtoupper($_POST['id_cliente'])) . "'";
												break;

											case 44:
												//reconexion de servicio internet + tv
												$update_status = "update clientes set id_tipo_status='1' where id_cliente='" . addslashes(strtoupper($_POST['id_cliente'])) . "'";
												break;
											default:
												break;
										}
									} else if (addslashes(strtoupper($_POST['tipo_servicio'])) == 2) {
										switch ($valor) {
											case 5:
												$update_status = "update clientes set id_tipo_status='6' where id_cliente='" . addslashes(strtoupper($_POST['id_cliente'])) . "'";
												break;

											case 8:

												$update_status = "update clientes set id_tipo_status='1' where id_cliente='" . addslashes(strtoupper($_POST['id_cliente'])) . "'";

												break;

											case 9:
												$update_status = "update clientes set id_tipo_status='4' where id_cliente='" . addslashes(strtoupper($_POST['id_cliente'])) . "'";
												break;

											case 12:
												$update_status = "update clientes set id_tipo_status='1' where id_cliente='" . addslashes(strtoupper($_POST['id_cliente'])) . "'";

												break;

											case 36:
												$update_status = "update clientes set id_tipo_status='1' where id_cliente='" . addslashes(strtoupper($_POST['id_cliente'])) . "'";

												break;

											case 40:

												$update_status = "update clientes set id_tipo_status='4' where id_cliente='" . addslashes(strtoupper($_POST['id_cliente'])) . "'";

												break;

											case 41:

												$update_status = "update clientes set id_tipo_status='4' where id_cliente='" . addslashes(strtoupper($_POST['id_cliente'])) . "'";

												break;
											default:
												break;
										}
									} else if (addslashes(strtoupper($_POST['tipo_servicio'])) == 3) {

										switch ($valor) {
											case 4:
												$update_status = "update clientes set id_tipo_status='5' where id_cliente='" . addslashes(strtoupper($_POST['id_cliente'])) . "'";
												break;
											case 10:
												$update_status = "update clientes set id_tipo_status='3' where id_cliente='" . addslashes(strtoupper($_POST['id_cliente'])) . "'";
												break;

											case 42:

												$update_status = "update clientes set id_tipo_status='5' where id_cliente='" . addslashes(strtoupper($_POST['id_cliente'])) . "'";

												break;

											case 43:

												$update_status = "update clientes set id_tipo_status='5' where id_cliente='" . addslashes(strtoupper($_POST['id_cliente'])) . "'";

												break;


											default:
												break;
										}
									}

									mysqli_query($conexion, $update_status);
								}
								///////////////////		
							} else {
								$conta++;
								mysqli_query($conexion, "rollback");
							}
						}



					if ($conta == 0) {
						mysqli_query($conexion, "commit");


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

				$contador = 0;
				mysqli_query($conexion, "start transaction");

				$folio = "select (count(*)+1) from reporte_servicios where id_empleado like '%" . addslashes(strtoupper(substr($_POST['empleado'], 2, 3))) . "%'";
				$result = mysqli_query($conexion, $folio);
				$row = mysqli_fetch_array($result);

				if (addslashes(strtoupper($_POST['folio'])) == '')
					$_POST['folio'] = "null";

				$query = "insert into reporte_servicios (id_reporte,id_empleado, id_estatus_servicio, folio, fecha_reporte,id_cliente,id_peticion,id_ingreso) values (0,'" . addslashes(strtoupper($_POST['empleado'])) . "','1','" . $row[0] . "','" . date("Y/m/d") . "','" . addslashes(strtoupper($_POST['id_cliente'])) . "','" . addslashes(strtoupper($_POST['tipo_servicio'])) . "'," . addslashes(strtoupper($_POST['folio'])) . ")";
				if (mysqli_query($conexion, $query)) {
					$reporte = mysqli_insert_id($conexion);

					$id_rep = $reporte;

					if (isset($_POST['servicio']))
						foreach ($_POST['servicio'] as $valor) {
							$query2 = "insert into cliente_servicios (id_cliente_servicio,id_reporte, id_tipo_servicio) values (0,'$reporte','$valor')";
							if (mysqli_query($conexion, $query2)) {
							} else {
								$contador++;
								mysqli_query($conexion, "rollback");
							}
						}



					if ($contador == 0) {
						mysqli_query($conexion, "commit");
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
				}
				break;
			case 'eliminar':
				$bandera = true;
				if ($_POST['select']) {
					$variable = array_keys($_POST['select']);
					$query_eliminar = "update reporte_servicios set id_estatus_servicio='3' WHERE id_reporte in (" . addslashes(implode(',', $variable)) . ")";
					if (mysqli_query($conexion, $query_eliminar)) {
					} else {
						$bandera = false;
					}
				} else {
					$bandera = false;
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
		<td align="right">
			<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="5px" background="imagenes/module_left.png"></td>
					<td width="70px" background="imagenes/module_center.png" height="80" valign="middle"><img src="imagenes/reportes_servicios.png" /></td>
					<td align="left" background="imagenes/module_center.png" height="80" valign="middle" class="titulo"><b>&nbsp;REPORTE DE SERVICIO</b></td>
					<td align="right" background="imagenes/module_center.png" height="80">
						<?php

						if ($id_rep != "null" && $id_rep != "") {
						?>
							<button class="boton2" id="imprimir_recibo" onclick="reporte2(<?php echo $id_rep; ?>)"><img src="imagenes/paper.png" /><br />Imprimir</button>
						<?php
						}
						?>
						<button class="boton2" onclick="createWindow('Filtro',450,310 ,5,false,true);"><img src="imagenes/filter.png" /><br />Filtro</button>
						<?php
						if (isset($_POST['servicio'])) {
						?>
							<button class="boton2" onclick="imprimir_pdf()"><img src="imagenes/imprimir.png" /><br />PDF</button>
							<button class="boton2" onclick="imprimir_excel()"><img src="imagenes/imprimir.png" /><br />EXCEL</button>
						<?php
						}
						?>
						<button class="boton2" onclick="reporte()"><img src="imagenes/imprimir.png" /><br />Reporte</button>


						<button class="boton2" onclick="location.href='index.php?menu=18&accion=agregar'"><img src="imagenes/agregar.png" /><br />Agregar</button>
						<!--<button class="boton2" onclick="editar()"><img src="imagenes/editar.png" /><br />Editar</button>-->
						<button class="boton2" onclick="eliminar()"><img src="imagenes/eliminar.png" /><br />Eliminar</button>
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
			<form name="datagrid" method="post">
				<table class="datagrid" width="100%" border="0" cellspacing="0">
					<tr>
						<td colspan="9" height="3px" class="separador"></td>
					</tr>
					<tr class="tabla_columns">
						<td>Folio</td>
						<td>Sucursal</td>
						<td>Numero de Cliente</td>
						<td>Cliente</td>
						<td>Fecha Reporte</td>
						<td>Fecha de Atencion</td>
						<td>Servicio</td>
						<td>Estado</td>
						<td align="center" width="50px"><input type="checkbox" name="selector" onclick="seleccionar()" /><input type='hidden' name='accion' /></td>
					</tr>
					<?php
					if (isset($_POST['servicio']) || $_SESSION['filtro_reporte_servicio'] != "") {

						$add_query = "";

						if ($_POST['id_suc'] != "null" && $_POST['id_suc'] != "") {
							$add_query .= " and id_cliente in (select id_cliente from clientes where id_sucursal='" . $_SESSION['tuvision_id_sucursal'] . "') ";
						}

						if ($_POST['id_cliente'] != "") {
							$add_query .= " and id_cliente='" . addslashes($_POST['id_cliente']) . "' ";
						}

						if ($_POST['desde_r'] != "" && $_POST['hasta_r'] != "") {
							$add_query .= " and fecha_reporte between '" . addslashes($_POST['desde_r']) . "' and '" . addslashes($_POST['hasta_r']) . "' ";
						}

						if ($_POST['desde_a'] != "" && $_POST['hasta_a'] != "") {
							$add_query .= " and fecha_atencion between '" . addslashes($_POST['desde_a']) . "' and '" . addslashes($_POST['hasta_a']) . "' ";
						}


						if ($_POST['servicio'] != "null" && isset($_POST['servicio']) and !is_array($_POST['servicio'])) {
							$add_query .= " and id_estatus_servicio='" . addslashes($_POST['servicio']) . "' ";
						}

						$query = "select id_reporte, 
					(select nombre from sucursales where id_sucursal =(select id_sucursal from empleados where id_empleado=re.id_empleado)),
					id_cliente,
					(select concat(nombre,' ',apellido_paterno,' ',apellido_materno) from clientes where id_cliente=re.id_cliente), 
					fecha_reporte, 
					fecha_atencion,
					folio,
					(select descripcion from estatus_servicio where id_estatus_servicio=re.id_estatus_servicio),
					id_estatus_servicio,
					(SELECT if (rep.id_peticion=1,(select descripcion from cat_tipo_servicios where id_tipo_servicio in 
(select id_tipo_servicio from rel_tipo_ingreso_servicio where id_tipo_ingreso in 
(select id_tipo_ingreso from montos where id_ingreso=rep.id_ingreso)) limit 1), 
(select descripcion from cat_tipo_servicios where id_peticion=rep.id_peticion and id_tipo_servicio = 
(SELECT id_tipo_servicio from cliente_servicios where id_reporte=rep.id_reporte limit 1)))
 from reporte_servicios rep where rep.id_reporte=re.id_reporte)
					from reporte_servicios re where id_estatus_servicio!=3 and id_empleado in 
					(select id_empleado from empleados where id_sucursal='" . $_SESSION['tuvision_id_sucursal'] . "')" . $add_query . " ORDER BY fecha_reporte DESC";




						if ($add_query == "")
							$query = $_SESSION['filtro_reporte_servicio'];
						else
							$_SESSION['filtro_reporte_servicio'] = $query;


						$tabla = mysqli_query($conexion, $query);
						while (list($id, $sucur, $num_cliente, $cliente, $f_reporte, $f_atencion, $folio, $servicio, $estado, $serv) = mysqli_fetch_array($tabla)) {
							$bandera = true;
							if ($estado == 3) {
								$color = "style='color:#FF0000'";
							} else
								$color = "";

					?>
							<tr class="tabla_row">
								<td><a href="index.php?menu=18&accion=editar&id=<?php echo $id;  ?>"><?php echo $folio; ?></a></td>
								<td><a href="index.php?menu=18&accion=editar&id=<?php echo $id;  ?>"><?php echo $sucur; ?></a></td>
								<td><a href="index.php?menu=18&accion=editar&id=<?php echo $id;  ?>"><?php echo $num_cliente; ?></a></td>
								<td><a href="index.php?menu=18&accion=editar&id=<?php echo $id;  ?>"><?php echo $cliente; ?></a></td>
								<td><a href="index.php?menu=18&accion=editar&id=<?php echo $id;  ?>"><?php echo $f_reporte; ?></a></td>
								<td><a href="index.php?menu=18&accion=editar&id=<?php echo $id;  ?>"><?php echo $f_atencion; ?></a></td>
								<td><a href="index.php?menu=18&accion=editar&id=<?php echo $id;  ?>"><?php echo $serv; ?></a></td>

								<td><a <?php echo $color; ?> href="index.php?menu=18&accion=editar&id=<?php echo $id;  ?>"><?php echo $servicio; ?></a></td>
								<td align="center"><input type="checkbox" name="select[<?php echo $id;  ?>]" /></td>
							</tr>
						<?php
						}
						if (!$bandera) {
						?>
							<tr>
								<td colspan="9">No hay Registros</td>
							</tr>
						<?php
						}
					} else {
						?>
						<tr>
							<td colspan="9">No hay Registros</td>
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