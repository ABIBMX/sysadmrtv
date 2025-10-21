<script language="javascript" type="text/javascript">
	function imprimir(valor) {
		if (valor == null) {
			document.datagrid.accion.value = "imprimir";
			var checado = "no";
			var contador = 0;
			for (var j = 1; j < document.datagrid.elements.length; j++) {
				if (document.datagrid.elements[j].checked) {
					checado = "si";
					contador++;

					document.getElementById('id_ingreso').value = document.datagrid.elements[j].name;


				}
			}
			if (checado == "si") {
				if (contador == 1) {
					var aux = document.datagrid.action;
					document.datagrid.action = "reporte/imprimir_nota_ingreso.php";
					document.datagrid.target = "_blank";
					document.datagrid.submit();
					document.datagrid.action = aux;
					document.datagrid.target = "_self";
				} else {
					alert("Solo puede seleccionar un registro");
				}
			} else {
				window.alert("No ha seleccionado ningun registro");
			}
		} else {
			document.getElementById('id_ingreso').value = valor;
			var aux = document.datagrid.action;
			document.datagrid.action = "reporte/imprimir_nota_ingreso.php";
			document.datagrid.target = "_blank";
			document.datagrid.submit();
			document.datagrid.action = aux;
			document.datagrid.target = "_self";
		}
	}

	function imprimir_pdf() {
		var aux_action = document.datagrid.action;
		var aux_target = document.datagrid.target;
		document.datagrid.action = "reporte/ingresos_pdf.php";
		document.datagrid.target = "_blank";
		document.datagrid.submit();
		document.datagrid.action = aux_action;
		document.datagrid.target = aux_target;

	}

	function imprimir_excel() {
		var aux_action = document.datagrid.action;
		var aux_target = document.datagrid.target;
		document.datagrid.action = "reporte/ingresos_excel.php";
		document.datagrid.target = "_blank";
		document.datagrid.submit();
		document.datagrid.action = aux_action;
		document.datagrid.target = aux_target;
	}

	//Se han agregado estas dos variables obligatorias 
	var contenedor_cliente = ""; //Se actualiza para saber en que input se coloca la llave del cliente
	var parametro_sucursal_cliente = ""; // Se utiliza en caso de que queramos la lista de clientes de una sucursal en especifica
	function cambio_id_cliente(id) {}

	function solo_numeros_decimales(texto) {
		var expresion = /[0-9]*\.?[0-9]{0,2}/;
		texto.value = texto.value.match(expresion);

	}
</script>
<div style="display:none" id="filtro_div"></div>
<table border="0" width="100%" style="color:#000000;font-size:12px">
	<tr>
		<td align="right">
			<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="5px" background="imagenes/module_left.png"></td>
					<td width="70px" background="imagenes/module_center.png" height="80" valign="middle"><img src="imagenes/ingresos.png" /></td>
					<td align="left" background="imagenes/module_center.png" height="80" valign="middle" class="titulo"><b>&nbsp;&nbsp;INGRESOS&nbsp;&nbsp;</b></td>
					<td align="right" background="imagenes/module_center.png" height="80">


						<button class="boton2" id="imprimir_recibo"><img src="imagenes/paper.png" /><br />Imprimir</button>

						<?php

						if (isset($_POST['aplicar_filtro'])) {
						?>
							<button class="boton2" onclick="imprimir()"><img src="imagenes/paper.png" /><br />Recibo</button>
							<button class="boton2" onclick="imprimir_pdf()"><img src="imagenes/imprimir.png" /><br />PDF</button>
							<button class="boton2" onclick="imprimir_excel()"><img src="imagenes/imprimir.png" /><br />EXCEL</button>
						<?php
						}
						?>
						<button class="boton2" onclick="createWindow('Filtro',350,250 ,3,false,true);"><img src="imagenes/filter.png" /><br />Filtro</button>
						<button class="boton2" onclick="location.href='index.php?menu=12&accion=agregar'"><img src="imagenes/agregar.png" /><br />Agregar</button>
					</td>
					<td width="5px" background="imagenes/module_right.png"></td>
				</tr>

			</table>
		</td>
	</tr>
	<?php
	// Establecer la zona horaria de Ciudad de México
	date_default_timezone_set('America/Mexico_City');
	$fecha = date('Y-m-d');
	$hora = date('H:i:s');
	if (isset($_POST['accion'])) {
		switch ($_POST['accion']) {
			case 'agregar':

				//procesar los conceptos
				$conceptos = [];

				foreach ($_POST as $key => $value) {
					if (preg_match('/tipoServicio_(\d+)/', $key, $matches)) {
						$i = $matches[1]; // número del concepto
						$conceptos[] = [
							'tipoServicio' => $_POST["tipoServicio_$i"] ?? null,
							'categoria'    => $_POST["Categorias_$i"] ?? null,
							'concepto'     => $_POST["conceptoIngreso_$i"] ?? null,
							'monto'        => $_POST["montoIngreso_$i"] ?? null,
							'promocion'	   => $_POST["promocion_$i"] ?? null,
							'subtotal'     => $_POST["subtotal_$i"] ?? null,
						];
					}
				}

				//obtener todas las variables necesarias

				$id_cliente = $_POST['id_cliente'];
				$pagoTotal = $_POST['total2'];
				$HayPagoParcial = $_POST['pago_parcial'];
				$pagoParcial = $_POST['pago_final'];
				$telefono_cliente = $_POST['telefono_cliente'];
				$tarifa_cliente = $_POST['tarifa_cliente'];
				$curp_cliente = $_POST['curp_cliente'];
				$notaImpresa = $_POST['nota_impresa'];
				$observaciones = $_POST['observaciones'];

				//Calcular el siguiente folio de ingreso

				$query_next_folio = "select MAX(i.folio_nota)+ 1 AS SIGUIENTE from ingresos i, clientes c, sucursales s where i.id_cliente = c.id_cliente and c.id_sucursal=s.id_sucursal and s.id_sucursal=(select id_sucursal from clientes where id_cliente='$id_cliente')";

				$next_folio = devolverValorQuery($query_next_folio);

				$query_next_folio_nuevo = "select MAX(i.folio_nuevo)+ 1 AS SIGUIENTENUEVO,s.id_sucursal from ingresos i, clientes c, sucursales s where i.id_cliente = c.id_cliente and c.id_sucursal=s.id_sucursal and s.id_sucursal=(select id_sucursal from clientes where id_cliente='$id_cliente')";

				$next_folio_nuevo = devolverValorQuery($query_next_folio_nuevo);

				if ($next_folio[0] == '') {
					$next_folio[0] = '1';
				}

				if ($next_folio_nuevo[0] == '') {
					$next_folio_nuevo[0] = '1';
				}

				if ($_POST['nota_impresa'] == "") {
					$_POST['nota_impresa'] = "NULL";
				}

				//Agregar el ingreso

				//-Validamos si hay un pago parcial 
				if ($HayPagoParcial == true) {
					$monto_total = $pagoParcial;
				} else {
					$monto_total = $pagoTotal;
				}
				//Agregamos el ingreso
				$query = "insert into ingresos (id_ingreso,id_cliente,monto_total,fecha,observaciones, folio_nota,nota_impresa,folio_nuevo,recibo_fiscal) values (0,'$id_cliente','$monto_total','" . date('Y-m-d') . "','$observaciones','" . $next_folio[0] . "','$notaImpresa','" . $next_folio_nuevo[0] . "','" . $next_folio_nuevo[1] . "-" . $next_folio_nuevo[0] . "')";

				if (mysqli_query($conexion, $query)) {
					//obtenemos el id del ingreso
					$id_ingreso = mysqli_insert_id($conexion);
					//Obteniemos el concepto principal
					$primerConcepto = $conceptos[0];
					//Obtenemos la descripcion del concepto
					$concepto_caja = devolverValorQuery("select descripcion from cat_tipo_ingreso where id_tipo_ingreso='" . $primerConcepto['concepto'] . "'");
					//Obtenemos la sucursal del cliente
					$sucursal = devolverValorQuery("select id_sucursal from clientes where id_cliente='$id_cliente'");
					//Insertamos el registro en caja
					insertarCaja($sucursal[0], $monto_total, 1, 1, $concepto_caja[0], $id_cliente, $next_folio[0]);

					//validar si el cliente tiene una configuracion de internet en proceso sin culminar
					$queryeliminar = "DELETE FROM conf_internet WHERE estatus = 'PROCESO' AND pasos = 'Alta_ingreso' AND  id_cliente='$id_cliente'";
					devolverValorQuery($queryeliminar);

					//Validar cada concepto
					foreach ($conceptos as $index => $concepto) {

						//Validando el tipo de servicio y la categoria
						$tipoServicio = $concepto['tipoServicio'];
						$categoria = $concepto['categoria'];
						$concepto = $concepto['concepto'];
						$total_original = $concepto['subtotal'];
						$promocionConcepto = $concepto['promocion'];

						switch ($tipoServicio) {
							case 'COBRE':

								switch ($categoria) {

									case 'INSCRIPCIONES':
										if ($concepto == '22') {
											$query_transaccion = "UPDATE clientes SET tipo_contratacion = 'SERVICIO TV COBRE' , configuracion_internet = 'NO NECESARIO' WHERE id_cliente = '$id_cliente'";
											mysqli_query($conexion, $query_transaccion);
										}
										break;

									case 'CONTRATACION DE ADICIONALES':
										if ($concepto == '35') {
											$query_transaccion = "UPDATE clientes SET tipo_contratacion = 'SERVICIO TV COBRE' , configuracion_internet = 'NO NECESARIO' WHERE id_cliente = '$id_cliente'";
											mysqli_query($conexion, $query_transaccion);
										}
										break;

									case 'SUSPENSIONES':
										if ($concepto == '56') {
											$query_transaccion = "UPDATE clientes SET tipo_contratacion = 'SERVICIO TV COBRE' , configuracion_internet = 'NO NECESARIO' WHERE id_cliente = '$id_cliente'";
											mysqli_query($conexion, $query_transaccion);

											//Si fue un pago parcial, registramos el saldo restante en transacciones
											if ($HayPagoParcial == true) {

												$saldo_restante = $pagoTotal - $pagoParcial;

												//Obtener la ultima transaccion del cliente
												$ultima_transaccion = devolverValorQuery("select id_transaccion,id_cliente,id_concepto,cargo,saldo_anterior,saldo_actual,fecha_transaccion,hora_transaccion from transacciones where id_cliente='$id_cliente' order by id_transaccion desc limit 1");
												//Preguntamos si ul ultima transaccion es 1 ( es un por pagar) o 2 (es un pago)
												if ($ultima_transaccion[2] == 1) {
													//Si es un por pagar, sumamos el saldo restante al saldo actual
													$saldo_anterior = $ultima_transaccion[5];
													$saldo_actual = $ultima_transaccion[5] + $saldo_restante;
												} else {
													//Si es un pago, restamos el saldo restante al saldo actual
													$saldo_anterior = $ultima_transaccion[5];
													//esto es para que si hay un saldo le sume el saldo restante y si no le sume 0
													$saldo_actual = $ultima_transaccion[5] + $saldo_restante;
												}

												//Insertamos la nueva transaccion
												$queryTransacciones = "insert into transacciones (id_transaccion,id_cliente,id_concepto,cargo,saldo_anterior,saldo_actual,fecha_transaccion,fecha_limite,hora_transaccion,origen) values (0,'$id_cliente',1,'$saldo_restante','$saldo_anterior','$saldo_actual','$fecha',NULL,'$hora','INGRESO PAGO PARCIAL')";
												mysqli_query($conexion, $queryTransacciones);
											}
										}
										break;

									case 'RECONEXIONES':
										if ($concepto == '36') {
											$query_transaccion = "UPDATE clientes SET tipo_contratacion = 'SERVICIO TV COBRE' , configuracion_internet = 'NO NECESARIO' WHERE id_cliente = '$id_cliente'";
											mysqli_query($conexion, $query_transaccion);

											//Si fue un pago parcial, registramos el saldo restante en transacciones
											if ($HayPagoParcial == true) {

												$saldo_restante = $pagoTotal - $pagoParcial;

												//Obtener la ultima transaccion del cliente
												$ultima_transaccion = devolverValorQuery("select id_transaccion,id_cliente,id_concepto,cargo,saldo_anterior,saldo_actual,fecha_transaccion,hora_transaccion from transacciones where id_cliente='$id_cliente' order by id_transaccion desc limit 1");
												//Preguntamos si ul ultima transaccion es 1 ( es un por pagar) o 2 (es un pago)
												if ($ultima_transaccion[2] == 1) {
													//Si es un por pagar, sumamos el saldo restante al saldo actual
													$saldo_anterior = $ultima_transaccion[5];
													$saldo_actual = $ultima_transaccion[5] + $saldo_restante;
												} else {
													//Si es un pago, restamos el saldo restante al saldo actual
													$saldo_anterior = $ultima_transaccion[5];
													//esto es para que si hay un saldo le sume el saldo restante y si no le sume 0
													$saldo_actual = $ultima_transaccion[5] + $saldo_restante;
												}

												//Insertamos la nueva transaccion
												$queryTransacciones = "insert into transacciones (id_transaccion,id_cliente,id_concepto,cargo,saldo_anterior,saldo_actual,fecha_transaccion,fecha_limite,hora_transaccion,origen) values (0,'$id_cliente',1,'$saldo_restante','$saldo_anterior','$saldo_actual','$fecha',NULL,'$hora','INGRESO PAGO PARCIAL')";
												mysqli_query($conexion, $queryTransacciones);
											}
										}
										break;

									case 'CANCELACIONES':
										if ($concepto == '31') {
											$query_transaccion = "UPDATE clientes SET configuracion_internet = 'NO NECESARIO' WHERE id_cliente = '$id_cliente'";
											mysqli_query($conexion, $query_transaccion);

											//Si fue un pago parcial, registramos el saldo restante en transacciones
											if ($HayPagoParcial == true) {

												$saldo_restante = $pagoTotal - $pagoParcial;

												//Obtener la ultima transaccion del cliente
												$ultima_transaccion = devolverValorQuery("select id_transaccion,id_cliente,id_concepto,cargo,saldo_anterior,saldo_actual,fecha_transaccion,hora_transaccion from transacciones where id_cliente='$id_cliente' order by id_transaccion desc limit 1");
												//Preguntamos si ul ultima transaccion es 1 ( es un por pagar) o 2 (es un pago)
												if ($ultima_transaccion[2] == 1) {
													//Si es un por pagar, sumamos el saldo restante al saldo actual
													$saldo_anterior = $ultima_transaccion[5];
													$saldo_actual = $ultima_transaccion[5] + $saldo_restante;
												} else {
													//Si es un pago, restamos el saldo restante al saldo actual
													$saldo_anterior = $ultima_transaccion[5];
													//esto es para que si hay un saldo le sume el saldo restante y si no le sume 0
													$saldo_actual = $ultima_transaccion[5] + $saldo_restante;
												}

												//Insertamos la nueva transaccion
												$queryTransacciones = "insert into transacciones (id_transaccion,id_cliente,id_concepto,cargo,saldo_anterior,saldo_actual,fecha_transaccion,fecha_limite,hora_transaccion,origen) values (0,'$id_cliente',1,'$saldo_restante','$saldo_anterior','$saldo_actual','$fecha',NULL,'$hora','INGRESO PAGO PARCIAL')";
												mysqli_query($conexion, $queryTransacciones);
											}
										}
										break;

									case 'CAMBIO DE DOMICILIO':
										if ($concepto == '39') {
											$query_transaccion = "UPDATE clientes SET tipo_contratacion = 'SERVICIO TV COBRE' , configuracion_internet = 'NO NECESARIO' WHERE id_cliente = '$id_cliente'";
											mysqli_query($conexion, $query_transaccion);
										}
										break;

									case 'PAGO DE MENSUALIDADES':
										if ($concepto == '40') {
											// Actualizar cliente
											$query_transaccion = "UPDATE clientes SET tipo_contratacion = 'SERVICIO TV COBRE', configuracion_internet = 'NO NECESARIO' WHERE id_cliente = '$id_cliente'";
											mysqli_query($conexion, $query_transaccion);

											$query_transaccion = "insert into transacciones (id_transaccion,id_cliente,id_concepto,cargo,saldo_anterior,saldo_actual,fecha_transaccion,hora_transaccion) select 0,'$id_cliente',2,'$monto_total',(select saldo_actual from transacciones where id_cliente='$id_cliente' order by fecha_transaccion desc, id_transaccion desc limit 1) , (select saldo_actual-" . $monto_total . "  from transacciones where id_cliente='$id_cliente' order by fecha_transaccion desc, id_transaccion desc limit 1) , '$fecha' as fecha, '$hora' as hora";
											mysqli_query($conexion, $query_transaccion);
										}
										break;
								}
								break;
							case 'TV CON FIBRA':
								switch ($categoria) {

									case 'INSCRIPCIONES':
										if ($concepto == '43') {
											$query_transaccion = "UPDATE clientes SET tipo_contratacion = 'SERVICIO TV FIBRA' , configuracion_internet = 'NO NECESARIO' WHERE id_cliente = '$id_cliente'";
											mysqli_query($conexion, $query_transaccion);
										}
										break;

									case 'CONTRATACION DE ADICIONALES':
										if ($concepto == '46') {
											$query_transaccion = "UPDATE clientes SET tipo_contratacion = 'SERVICIO TV FIBRA' , configuracion_internet = 'NO NECESARIO' WHERE id_cliente = '$id_cliente'";
											mysqli_query($conexion, $query_transaccion);
										}
										break;

									case 'SUSPENSIONES':
										if ($concepto == '57') {
											$query_transaccion = "UPDATE clientes SET tipo_contratacion = 'SERVICIO TV FIBRA' , configuracion_internet = 'NO NECESARIO' WHERE id_cliente = '$id_cliente'";
											mysqli_query($conexion, $query_transaccion);

											//Si fue un pago parcial, registramos el saldo restante en transacciones
											if ($HayPagoParcial == true) {

												$saldo_restante = $pagoTotal - $pagoParcial;

												//Obtener la ultima transaccion del cliente
												$ultima_transaccion = devolverValorQuery("select id_transaccion,id_cliente,id_concepto,cargo,saldo_anterior,saldo_actual,fecha_transaccion,hora_transaccion from transacciones where id_cliente='$id_cliente' order by id_transaccion desc limit 1");
												//Preguntamos si ul ultima transaccion es 1 ( es un por pagar) o 2 (es un pago)
												if ($ultima_transaccion[2] == 1) {
													//Si es un por pagar, sumamos el saldo restante al saldo actual
													$saldo_anterior = $ultima_transaccion[5];
													$saldo_actual = $ultima_transaccion[5] + $saldo_restante;
												} else {
													//Si es un pago, restamos el saldo restante al saldo actual
													$saldo_anterior = $ultima_transaccion[5];
													//esto es para que si hay un saldo le sume el saldo restante y si no le sume 0
													$saldo_actual = $ultima_transaccion[5] + $saldo_restante;
												}

												//Insertamos la nueva transaccion
												$queryTransacciones = "insert into transacciones (id_transaccion,id_cliente,id_concepto,cargo,saldo_anterior,saldo_actual,fecha_transaccion,fecha_limite,hora_transaccion,origen) values (0,'$id_cliente',1,'$saldo_restante','$saldo_anterior','$saldo_actual','$fecha',NULL,'$hora','INGRESO PAGO PARCIAL')";
												mysqli_query($conexion, $queryTransacciones);
											}
										}
										break;

									case 'RECONEXIONES':
										if ($concepto == '49') {
											$query_transaccion = "UPDATE clientes SET tipo_contratacion = 'SERVICIO TV FIBRA' , configuracion_internet = 'NO NECESARIO' WHERE id_cliente = '$id_cliente'";
											mysqli_query($conexion, $query_transaccion);

											//Si fue un pago parcial, registramos el saldo restante en transacciones
											if ($HayPagoParcial == true) {

												$saldo_restante = $pagoTotal - $pagoParcial;

												//Obtener la ultima transaccion del cliente
												$ultima_transaccion = devolverValorQuery("select id_transaccion,id_cliente,id_concepto,cargo,saldo_anterior,saldo_actual,fecha_transaccion,hora_transaccion from transacciones where id_cliente='$id_cliente' order by id_transaccion desc limit 1");
												//Preguntamos si ul ultima transaccion es 1 ( es un por pagar) o 2 (es un pago)
												if ($ultima_transaccion[2] == 1) {
													//Si es un por pagar, sumamos el saldo restante al saldo actual
													$saldo_anterior = $ultima_transaccion[5];
													$saldo_actual = $ultima_transaccion[5] + $saldo_restante;
												} else {
													//Si es un pago, restamos el saldo restante al saldo actual
													$saldo_anterior = $ultima_transaccion[5];
													//esto es para que si hay un saldo le sume el saldo restante y si no le sume 0
													$saldo_actual = $ultima_transaccion[5] + $saldo_restante;
												}

												//Insertamos la nueva transaccion
												$queryTransacciones = "insert into transacciones (id_transaccion,id_cliente,id_concepto,cargo,saldo_anterior,saldo_actual,fecha_transaccion,fecha_limite,hora_transaccion,origen) values (0,'$id_cliente',1,'$saldo_restante','$saldo_anterior','$saldo_actual','$fecha',NULL,'$hora','INGRESO PAGO PARCIAL')";
												mysqli_query($conexion, $queryTransacciones);
											}
										}
										break;

									case 'CANCELACIONES':
										if ($concepto == '32') {
											$query_transaccion = "UPDATE clientes SET  configuracion_internet = 'NO NECESARIO' WHERE id_cliente = '$id_cliente'";
											mysqli_query($conexion, $query_transaccion);

											//Si fue un pago parcial, registramos el saldo restante en transacciones
											if ($HayPagoParcial == true) {

												$saldo_restante = $pagoTotal - $pagoParcial;

												//Obtener la ultima transaccion del cliente
												$ultima_transaccion = devolverValorQuery("select id_transaccion,id_cliente,id_concepto,cargo,saldo_anterior,saldo_actual,fecha_transaccion,hora_transaccion from transacciones where id_cliente='$id_cliente' order by id_transaccion desc limit 1");
												//Preguntamos si ul ultima transaccion es 1 ( es un por pagar) o 2 (es un pago)
												if ($ultima_transaccion[2] == 1) {
													//Si es un por pagar, sumamos el saldo restante al saldo actual
													$saldo_anterior = $ultima_transaccion[5];
													$saldo_actual = $ultima_transaccion[5] + $saldo_restante;
												} else {
													//Si es un pago, restamos el saldo restante al saldo actual
													$saldo_anterior = $ultima_transaccion[5];
													//esto es para que si hay un saldo le sume el saldo restante y si no le sume 0
													$saldo_actual = $ultima_transaccion[5] + $saldo_restante;
												}

												//Insertamos la nueva transaccion
												$queryTransacciones = "insert into transacciones (id_transaccion,id_cliente,id_concepto,cargo,saldo_anterior,saldo_actual,fecha_transaccion,fecha_limite,hora_transaccion,origen) values (0,'$id_cliente',1,'$saldo_restante','$saldo_anterior','$saldo_actual','$fecha',NULL,'$hora','INGRESO PAGO PARCIAL')";
												mysqli_query($conexion, $queryTransacciones);
											}
										}
										break;

									case 'CAMBIO DE DOMICILIO':
										if ($concepto == '53') {
											$query_transaccion = "UPDATE clientes SET tipo_contratacion = 'SERVICIO TV FIBRA' , configuracion_internet = 'NO NECESARIO' WHERE id_cliente = '$id_cliente'";
											mysqli_query($conexion, $query_transaccion);
										}
										break;

									case 'PAGO DE MENSUALIDADES':
										if ($concepto == '51') {
											// Actualizar cliente
											$query_transaccion = "UPDATE clientes SET tipo_contratacion = 'SERVICIO TV FIBRA', configuracion_internet = 'NO NECESARIO' WHERE id_cliente = '$id_cliente'";
											mysqli_query($conexion, $query_transaccion);

											$query_transaccion = "insert into transacciones (id_transaccion,id_cliente,id_concepto,cargo,saldo_anterior,saldo_actual,fecha_transaccion,hora_transaccion) select 0,'$id_cliente',2,'$monto_total',(select saldo_actual from transacciones where id_cliente='$id_cliente' order by fecha_transaccion desc, id_transaccion desc limit 1) , (select saldo_actual-" . $monto_total . "  from transacciones where id_cliente='$id_cliente' order by fecha_transaccion desc, id_transaccion desc limit 1) , '$fecha' as fecha, '$hora' as hora";
											mysqli_query($conexion, $query_transaccion);
										}
										break;
									case 'CAMBIO DE SERVICIO':
										if ($concepto == '28') {
											//CLIENTE CON INTERNET (QUITA INTERNET Y AGREGA TV)
											$query_transaccion = "UPDATE clientes SET tipo_contratacion = 'SERVICIO TV FIBRA' , configuracion_internet = 'NO NECESARIO' WHERE id_cliente = '$id_cliente'";
											mysqli_query($conexion, $query_transaccion);
										}

										if ($concepto == '30') {
											//CLIENTE CON TV E INTERNET (QUITA INTERNET Y DEJA SOLO TV)
											$query_transaccion = "UPDATE clientes SET tipo_contratacion = 'SERVICIO TV FIBRA' , configuracion_internet = 'NO NECESARIO' WHERE id_cliente = '$id_cliente'";
											mysqli_query($conexion, $query_transaccion);
										}

										if ($concepto == '48') {
											//CLIENTE CON TV X COBRE CAMBIA A TV X FIBRA
											$query_transaccion = "UPDATE clientes SET tipo_contratacion = 'SERVICIO TV FIBRA' , configuracion_internet = 'NO NECESARIO' WHERE id_cliente = '$id_cliente'";
											mysqli_query($conexion, $query_transaccion);
										}

										break;
								}
								break;
							case 'TVINTERNET':
								switch ($categoria) {

									case 'INSCRIPCIONES':
										if ($concepto == '24') {

											$query_transaccion = "UPDATE clientes SET tipo_contratacion = 'SERVICIO TV CON INTERNET' , configuracion_internet = 'SI' WHERE id_cliente = '$id_cliente'";
											mysqli_query($conexion, $query_transaccion);

											//Actualizacion de la configuracion de internet
											$queryCI = "select * from conf_internet where estatus = 'ACTUAL' AND pasos = 'Finalizado' AND  id_cliente='$id_cliente'";
											$registroCI = devolverValorQuery($queryCI);

											if ($registroCI) {
												$queryOld = "UPDATE conf_internet SET estatus = 'ANTERIOR', pasos = 'Finalizado' WHERE id_cliente='$id_cliente' AND id = '" . $registroCI['id'] . "'";
												devolverValorQuery($queryOld);
											}

											date_default_timezone_set('America/Mexico_City');
											$fecha = date('Y-m-d');
											$hora = date('H:i:s');

											$query = "INSERT INTO conf_internet (id,id_cliente,fecha_registro,hora_registro,estatus,pasos) values (0,'$id_cliente','" . $fecha . "','" . $hora . "','PROCESO','Alta_ingreso')";

											devolverValorQuery($query);
										}

										break;

									case 'CONTRATACION DE ADICIONALES':
										if ($concepto == '24') {

											$query_transaccion = "UPDATE clientes SET tipo_contratacion = 'SERVICIO TV CON INTERNET' , configuracion_internet = 'SI' WHERE id_cliente = '$id_cliente'";
											mysqli_query($conexion, $query_transaccion);

											//Actualizacion de la configuracion de internet
											$queryCI = "select * from conf_internet where estatus = 'ACTUAL' AND pasos = 'Finalizado' AND  id_cliente='$id_cliente'";
											$registroCI = devolverValorQuery($queryCI);

											if (!$registroCI) {

												//si no tiene registro actual, preguntamos si tiene uno en proceso.
												$queryCIProceso = "select * from conf_internet where estatus = 'PROCESO' AND  id_cliente='$id_cliente'";
												$registroCIProceso = devolverValorQuery($queryCIProceso);

												if (!$registroCIProceso) {
													//si no tiene registro en proceso, entonces insertamos uno nuevo
													date_default_timezone_set('America/Mexico_City');
													$fecha = date('Y-m-d');
													$hora = date('H:i:s');

													$query = "INSERT INTO conf_internet (id,id_cliente,fecha_registro,hora_registro,estatus,pasos) values (0,'$id_cliente','" . $fecha . "','" . $hora . "','PROCESO','Alta_ingreso')";

													devolverValorQuery($query);
												}
											} else {

												$queryOld = "UPDATE conf_internet SET estatus = 'ANTERIOR', pasos = 'Finalizado' WHERE id_cliente='$id_cliente' AND id = '" . $registroCI['id'] . "'";
												devolverValorQuery($queryOld);

												date_default_timezone_set('America/Mexico_City');
												$fecha = date('Y-m-d');
												$hora = date('H:i:s');

												$query = "INSERT INTO conf_internet (id,id_cliente,fecha_registro,hora_registro,estatus,pasos) values (0,'$id_cliente','" . $fecha . "','" . $hora . "','PROCESO','Alta_ingreso')";

												devolverValorQuery($query);
											}
										}

										break;

									case 'SUSPENSIONES':
										if ($concepto == '58') {

											$query_transaccion = "UPDATE clientes SET tipo_contratacion = 'SERVICIO TV CON INTERNET' , configuracion_internet = 'SI' WHERE id_cliente = '$id_cliente'";
											mysqli_query($conexion, $query_transaccion);

											//Si fue un pago parcial, registramos el saldo restante en transacciones
											if ($HayPagoParcial == true) {

												$saldo_restante = $pagoTotal - $pagoParcial;

												//Obtener la ultima transaccion del cliente
												$ultima_transaccion = devolverValorQuery("select id_transaccion,id_cliente,id_concepto,cargo,saldo_anterior,saldo_actual,fecha_transaccion,hora_transaccion from transacciones where id_cliente='$id_cliente' order by id_transaccion desc limit 1");
												//Preguntamos si ul ultima transaccion es 1 ( es un por pagar) o 2 (es un pago)
												if ($ultima_transaccion[2] == 1) {
													//Si es un por pagar, sumamos el saldo restante al saldo actual
													$saldo_anterior = $ultima_transaccion[5];
													$saldo_actual = $ultima_transaccion[5] + $saldo_restante;
												} else {
													//Si es un pago, restamos el saldo restante al saldo actual
													$saldo_anterior = $ultima_transaccion[5];
													//esto es para que si hay un saldo le sume el saldo restante y si no le sume 0
													$saldo_actual = $ultima_transaccion[5] + $saldo_restante;
												}

												//Insertamos la nueva transaccion
												$queryTransacciones = "insert into transacciones (id_transaccion,id_cliente,id_concepto,cargo,saldo_anterior,saldo_actual,fecha_transaccion,fecha_limite,hora_transaccion,origen) values (0,'$id_cliente',1,'$saldo_restante','$saldo_anterior','$saldo_actual','$fecha',NULL,'$hora','INGRESO PAGO PARCIAL')";
												mysqli_query($conexion, $queryTransacciones);
											}

											//Actualizacion de la configuracion de internet
											$queryCI = "select * from conf_internet where estatus = 'ACTUAL' AND pasos = 'Finalizado' AND  id_cliente='$id_cliente'";
											$registroCI = devolverValorQuery($queryCI);

											if ($registroCI) {
												$queryOld = "UPDATE conf_internet SET estatus = 'ANTERIOR', pasos = 'Finalizado' WHERE id_cliente='$id_cliente' AND id = '" . $registroCI['id'] . "'";
												devolverValorQuery($queryOld);
											} else {
												//si no tiene registro actual, preguntamos si tiene uno en proceso.
												$queryCIProceso = "select * from conf_internet where estatus = 'PROCESO' AND  id_cliente='$id_cliente'";
												$registroCIProceso = devolverValorQuery($queryCIProceso);

												if ($registroCIProceso) {
													$queryOld = "UPDATE conf_internet SET estatus = 'ANTERIOR', pasos = 'Finalizado' WHERE id_cliente='$id_cliente' AND id = '" . $registroCI['id'] . "'";
													devolverValorQuery($queryOld);
												}
											}
										}
										break;

									case 'RECONEXIONES':
										if ($concepto == '37') {

											$query_transaccion = "UPDATE clientes SET tipo_contratacion = 'SERVICIO TV CON INTERNET' , configuracion_internet = 'SI' WHERE id_cliente = '$id_cliente'";
											mysqli_query($conexion, $query_transaccion);

											//Si fue un pago parcial, registramos el saldo restante en transacciones
											if ($HayPagoParcial == true) {

												$saldo_restante = $pagoTotal - $pagoParcial;

												//Obtener la ultima transaccion del cliente
												$ultima_transaccion = devolverValorQuery("select id_transaccion,id_cliente,id_concepto,cargo,saldo_anterior,saldo_actual,fecha_transaccion,hora_transaccion from transacciones where id_cliente='$id_cliente' order by id_transaccion desc limit 1");
												//Preguntamos si ul ultima transaccion es 1 ( es un por pagar) o 2 (es un pago)
												if ($ultima_transaccion[2] == 1) {
													//Si es un por pagar, sumamos el saldo restante al saldo actual
													$saldo_anterior = $ultima_transaccion[5];
													$saldo_actual = $ultima_transaccion[5] + $saldo_restante;
												} else {
													//Si es un pago, restamos el saldo restante al saldo actual
													$saldo_anterior = $ultima_transaccion[5];
													//esto es para que si hay un saldo le sume el saldo restante y si no le sume 0
													$saldo_actual = $ultima_transaccion[5] + $saldo_restante;
												}

												//Insertamos la nueva transaccion
												$queryTransacciones = "insert into transacciones (id_transaccion,id_cliente,id_concepto,cargo,saldo_anterior,saldo_actual,fecha_transaccion,fecha_limite,hora_transaccion,origen) values (0,'$id_cliente',1,'$saldo_restante','$saldo_anterior','$saldo_actual','$fecha',NULL,'$hora','INGRESO PAGO PARCIAL')";
												mysqli_query($conexion, $queryTransacciones);
											}

											//Actualizacion de la configuracion de internet
											$queryCI = "select * from conf_internet where estatus = 'ACTUAL' AND pasos = 'Finalizado' AND  id_cliente='$id_cliente'";
											$registroCI = devolverValorQuery($queryCI);

											if ($registroCI) {
												$queryOld = "UPDATE conf_internet SET estatus = 'ANTERIOR', pasos = 'Finalizado' WHERE id_cliente='$id_cliente' AND id = '" . $registroCI['id'] . "'";
												devolverValorQuery($queryOld);
											}

											date_default_timezone_set('America/Mexico_City');
											$fecha = date('Y-m-d');
											$hora = date('H:i:s');

											$query = "INSERT INTO conf_internet (id,id_cliente,fecha_registro,hora_registro,estatus,pasos) values (0,'$id_cliente','" . $fecha . "','" . $hora . "','PROCESO','Alta_ingreso')";

											devolverValorQuery($query);
										}
										break;

									case 'CANCELACIONES':
										if ($concepto == '33') {

											$query_transaccion = "UPDATE clientes SET tipo_contratacion = 'SERVICIO TV CON INTERNET' , configuracion_internet = 'SI' WHERE id_cliente = '$id_cliente'";
											mysqli_query($conexion, $query_transaccion);

											//Si fue un pago parcial, registramos el saldo restante en transacciones
											if ($HayPagoParcial == true) {

												$saldo_restante = $pagoTotal - $pagoParcial;

												//Obtener la ultima transaccion del cliente
												$ultima_transaccion = devolverValorQuery("select id_transaccion,id_cliente,id_concepto,cargo,saldo_anterior,saldo_actual,fecha_transaccion,hora_transaccion from transacciones where id_cliente='$id_cliente' order by id_transaccion desc limit 1");
												//Preguntamos si ul ultima transaccion es 1 ( es un por pagar) o 2 (es un pago)
												if ($ultima_transaccion[2] == 1) {
													//Si es un por pagar, sumamos el saldo restante al saldo actual
													$saldo_anterior = $ultima_transaccion[5];
													$saldo_actual = $ultima_transaccion[5] + $saldo_restante;
												} else {
													//Si es un pago, restamos el saldo restante al saldo actual
													$saldo_anterior = $ultima_transaccion[5];
													//esto es para que si hay un saldo le sume el saldo restante y si no le sume 0
													$saldo_actual = $ultima_transaccion[5] + $saldo_restante;
												}

												//Insertamos la nueva transaccion
												$queryTransacciones = "insert into transacciones (id_transaccion,id_cliente,id_concepto,cargo,saldo_anterior,saldo_actual,fecha_transaccion,fecha_limite,hora_transaccion,origen) values (0,'$id_cliente',1,'$saldo_restante','$saldo_anterior','$saldo_actual','$fecha',NULL,'$hora','INGRESO PAGO PARCIAL')";
												mysqli_query($conexion, $queryTransacciones);
											}

											//Actualizacion de la configuracion de internet
											$queryCI = "select * from conf_internet where estatus = 'ACTUAL' AND pasos = 'Finalizado' AND  id_cliente='$id_cliente'";
											$registroCI = devolverValorQuery($queryCI);

											if ($registroCI) {
												$queryOld = "UPDATE conf_internet SET estatus = 'ANTERIOR', pasos = 'Finalizado' WHERE id_cliente='$id_cliente' AND id = '" . $registroCI['id'] . "'";
												devolverValorQuery($queryOld);
											} else {
												//si no tiene registro actual, preguntamos si tiene uno en proceso.
												$queryCIProceso = "select * from conf_internet where estatus = 'PROCESO' AND  id_cliente='$id_cliente'";
												$registroCIProceso = devolverValorQuery($queryCIProceso);

												if ($registroCIProceso) {
													$queryOld = "UPDATE conf_internet SET estatus = 'ANTERIOR', pasos = 'Finalizado' WHERE id_cliente='$id_cliente' AND id = '" . $registroCI['id'] . "'";
													devolverValorQuery($queryOld);
												}
											}
										}
										break;

									case 'CAMBIO DE DOMICILIO':
										if ($concepto == '54') {

											$query_transaccion = "UPDATE clientes SET tipo_contratacion = 'SERVICIO TV CON INTERNET' , configuracion_internet = 'SI' WHERE id_cliente = '$id_cliente'";
											mysqli_query($conexion, $query_transaccion);

											//Actualizacion de la configuracion de internet
											$queryCI = "select * from conf_internet where estatus = 'ACTUAL' AND pasos = 'Finalizado' AND  id_cliente='$id_cliente'";
											$registroCI = devolverValorQuery($queryCI);

											if ($registroCI) {
												$queryOld = "UPDATE conf_internet SET estatus = 'ANTERIOR', pasos = 'Finalizado' WHERE id_cliente='$id_cliente' AND id = '" . $registroCI['id'] . "'";
												devolverValorQuery($queryOld);
											}

											date_default_timezone_set('America/Mexico_City');
											$fecha = date('Y-m-d');
											$hora = date('H:i:s');

											$query = "INSERT INTO conf_internet (id,id_cliente,fecha_registro,hora_registro,estatus,pasos) values (0,'$id_cliente','" . $fecha . "','" . $hora . "','PROCESO','Alta_ingreso')";

											devolverValorQuery($query);
										}
										break;

									case 'PAGO DE MENSUALIDADES':
										if ($concepto == '45') {
											// Actualizar cliente
											$query_transaccion = "UPDATE clientes SET  tipo_contratacion = 'SERVICIO TV CON INTERNET' , configuracion_internet = 'SI' WHERE id_cliente = '$id_cliente'";
											mysqli_query($conexion, $query_transaccion);

											$query_transaccion = "insert into transacciones (id_transaccion,id_cliente,id_concepto,cargo,saldo_anterior,saldo_actual,fecha_transaccion,hora_transaccion) select 0,'$id_cliente',2,'$monto_total',(select saldo_actual from transacciones where id_cliente='$id_cliente' order by fecha_transaccion desc, id_transaccion desc limit 1) , (select saldo_actual-" . $monto_total . "  from transacciones where id_cliente='$id_cliente' order by fecha_transaccion desc, id_transaccion desc limit 1) , '$fecha' as fecha, '$hora' as hora";
											mysqli_query($conexion, $query_transaccion);
										}
										break;
									case 'CAMBIO DE SERVICIO':
										if ($concepto == '25') {
											//CLIENTE CON TV (AGREGA INTERNET)
											$query_transaccion = "UPDATE clientes SET tipo_contratacion = 'SERVICIO TV CON INTERNET' , configuracion_internet = 'SI' WHERE id_cliente = '$id_cliente'";
											mysqli_query($conexion, $query_transaccion);

											//Actualizacion de la configuracion de internet
											$queryCI = "select * from conf_internet where estatus = 'ACTUAL' AND pasos = 'Finalizado' AND  id_cliente='$id_cliente'";
											$registroCI = devolverValorQuery($queryCI);

											if ($registroCI) {
												$queryOld = "UPDATE conf_internet SET estatus = 'ANTERIOR', pasos = 'Finalizado' WHERE id_cliente='$id_cliente' AND id = '" . $registroCI['id'] . "'";
												devolverValorQuery($queryOld);
											}

											date_default_timezone_set('America/Mexico_City');
											$fecha = date('Y-m-d');
											$hora = date('H:i:s');

											$query = "INSERT INTO conf_internet (id,id_cliente,fecha_registro,hora_registro,estatus,pasos) values (0,'$id_cliente','" . $fecha . "','" . $hora . "','PROCESO','Alta_ingreso')";

											devolverValorQuery($query);
										}

										if ($concepto == '26') {
											//CLIENTE CON INTERNET (AGREGA TV)
											$query_transaccion = "UPDATE clientes SET tipo_contratacion = 'SERVICIO TV CON INTERNET' , configuracion_internet = 'SI' WHERE id_cliente = '$id_cliente'";
											mysqli_query($conexion, $query_transaccion);

											//Actualizacion de la configuracion de internet
											$queryCI = "select * from conf_internet where estatus = 'ACTUAL' AND pasos = 'Finalizado' AND  id_cliente='$id_cliente'";
											$registroCI = devolverValorQuery($queryCI);

											if ($registroCI) {
												$queryOld = "UPDATE conf_internet SET estatus = 'ANTERIOR', pasos = 'Finalizado' WHERE id_cliente='$id_cliente' AND id = '" . $registroCI['id'] . "'";
												devolverValorQuery($queryOld);
											}

											date_default_timezone_set('America/Mexico_City');
											$fecha = date('Y-m-d');
											$hora = date('H:i:s');

											$query = "INSERT INTO conf_internet (id,id_cliente,fecha_registro,hora_registro,estatus,pasos) values (0,'$id_cliente','" . $fecha . "','" . $hora . "','PROCESO','Alta_ingreso')";

											devolverValorQuery($query);
										}

										break;
								}
								break;
							case 'INTERNET':
								switch ($categoria) {

									case 'INSCRIPCIONES':
										if ($concepto == '23') {

											$query_transaccion = "UPDATE clientes SET tipo_contratacion = 'SERVICIO INTERNET' , configuracion_internet = 'SI' WHERE id_cliente = '$id_cliente'";
											mysqli_query($conexion, $query_transaccion);

											//Actualizacion de la configuracion de internet
											$queryCI = "select * from conf_internet where estatus = 'ACTUAL' AND pasos = 'Finalizado' AND  id_cliente='$id_cliente'";
											$registroCI = devolverValorQuery($queryCI);

											if ($registroCI) {
												$queryOld = "UPDATE conf_internet SET estatus = 'ANTERIOR', pasos = 'Finalizado' WHERE id_cliente='$id_cliente' AND id = '" . $registroCI['id'] . "'";
												devolverValorQuery($queryOld);
											}

											date_default_timezone_set('America/Mexico_City');
											$fecha = date('Y-m-d');
											$hora = date('H:i:s');

											$query = "INSERT INTO conf_internet (id,id_cliente,fecha_registro,hora_registro,estatus,pasos) values (0,'$id_cliente','" . $fecha . "','" . $hora . "','PROCESO','Alta_ingreso')";

											devolverValorQuery($query);
										}
										break;

									case 'SUSPENSIONES':
										if ($concepto == '59') {

											$query_transaccion = "UPDATE clientes SET tipo_contratacion = 'SERVICIO INTERNET' , configuracion_internet = 'SI' WHERE id_cliente = '$id_cliente'";
											mysqli_query($conexion, $query_transaccion);

											//Si fue un pago parcial, registramos el saldo restante en transacciones
											if ($HayPagoParcial == true) {

												$saldo_restante = $pagoTotal - $pagoParcial;

												//Obtener la ultima transaccion del cliente
												$ultima_transaccion = devolverValorQuery("select id_transaccion,id_cliente,id_concepto,cargo,saldo_anterior,saldo_actual,fecha_transaccion,hora_transaccion from transacciones where id_cliente='$id_cliente' order by id_transaccion desc limit 1");
												//Preguntamos si ul ultima transaccion es 1 ( es un por pagar) o 2 (es un pago)
												if ($ultima_transaccion[2] == 1) {
													//Si es un por pagar, sumamos el saldo restante al saldo actual
													$saldo_anterior = $ultima_transaccion[5];
													$saldo_actual = $ultima_transaccion[5] + $saldo_restante;
												} else {
													//Si es un pago, restamos el saldo restante al saldo actual
													$saldo_anterior = $ultima_transaccion[5];
													//esto es para que si hay un saldo le sume el saldo restante y si no le sume 0
													$saldo_actual = $ultima_transaccion[5] + $saldo_restante;
												}

												//Insertamos la nueva transaccion
												$queryTransacciones = "insert into transacciones (id_transaccion,id_cliente,id_concepto,cargo,saldo_anterior,saldo_actual,fecha_transaccion,fecha_limite,hora_transaccion,origen) values (0,'$id_cliente',1,'$saldo_restante','$saldo_anterior','$saldo_actual','$fecha',NULL,'$hora','INGRESO PAGO PARCIAL')";
												mysqli_query($conexion, $queryTransacciones);
											}

											//Actualizacion de la configuracion de internet
											$queryCI = "select * from conf_internet where estatus = 'ACTUAL' AND pasos = 'Finalizado' AND  id_cliente='$id_cliente'";
											$registroCI = devolverValorQuery($queryCI);

											if ($registroCI) {
												$queryOld = "UPDATE conf_internet SET estatus = 'ANTERIOR', pasos = 'Finalizado' WHERE id_cliente='$id_cliente' AND id = '" . $registroCI['id'] . "'";
												devolverValorQuery($queryOld);
											} else {
												//si no tiene registro actual, preguntamos si tiene uno en proceso.
												$queryCIProceso = "select * from conf_internet where estatus = 'PROCESO' AND  id_cliente='$id_cliente'";
												$registroCIProceso = devolverValorQuery($queryCIProceso);

												if ($registroCIProceso) {
													$queryOld = "UPDATE conf_internet SET estatus = 'ANTERIOR', pasos = 'Finalizado' WHERE id_cliente='$id_cliente' AND id = '" . $registroCI['id'] . "'";
													devolverValorQuery($queryOld);
												}
											}
										}
										break;

									case 'RECONEXIONES':
										if ($concepto == '38') {

											$query_transaccion = "UPDATE clientes SET tipo_contratacion = 'SERVICIO INTERNET' , configuracion_internet = 'SI' WHERE id_cliente = '$id_cliente'";
											mysqli_query($conexion, $query_transaccion);

											//Si fue un pago parcial, registramos el saldo restante en transacciones
											if ($HayPagoParcial == true) {

												$saldo_restante = $pagoTotal - $pagoParcial;

												//Obtener la ultima transaccion del cliente
												$ultima_transaccion = devolverValorQuery("select id_transaccion,id_cliente,id_concepto,cargo,saldo_anterior,saldo_actual,fecha_transaccion,hora_transaccion from transacciones where id_cliente='$id_cliente' order by id_transaccion desc limit 1");
												//Preguntamos si ul ultima transaccion es 1 ( es un por pagar) o 2 (es un pago)
												if ($ultima_transaccion[2] == 1) {
													//Si es un por pagar, sumamos el saldo restante al saldo actual
													$saldo_anterior = $ultima_transaccion[5];
													$saldo_actual = $ultima_transaccion[5] + $saldo_restante;
												} else {
													//Si es un pago, restamos el saldo restante al saldo actual
													$saldo_anterior = $ultima_transaccion[5];
													//esto es para que si hay un saldo le sume el saldo restante y si no le sume 0
													$saldo_actual = $ultima_transaccion[5] + $saldo_restante;
												}

												//Insertamos la nueva transaccion
												$queryTransacciones = "insert into transacciones (id_transaccion,id_cliente,id_concepto,cargo,saldo_anterior,saldo_actual,fecha_transaccion,fecha_limite,hora_transaccion,origen) values (0,'$id_cliente',1,'$saldo_restante','$saldo_anterior','$saldo_actual','$fecha',NULL,'$hora','INGRESO PAGO PARCIAL')";
												mysqli_query($conexion, $queryTransacciones);
											}

											//Actualizacion de la configuracion de internet
											$queryCI = "select * from conf_internet where estatus = 'ACTUAL' AND pasos = 'Finalizado' AND  id_cliente='$id_cliente'";
											$registroCI = devolverValorQuery($queryCI);

											if ($registroCI) {
												$queryOld = "UPDATE conf_internet SET estatus = 'ANTERIOR', pasos = 'Finalizado' WHERE id_cliente='$id_cliente' AND id = '" . $registroCI['id'] . "'";
												devolverValorQuery($queryOld);
											}

											date_default_timezone_set('America/Mexico_City');
											$fecha = date('Y-m-d');
											$hora = date('H:i:s');

											$query = "INSERT INTO conf_internet (id,id_cliente,fecha_registro,hora_registro,estatus,pasos) values (0,'$id_cliente','" . $fecha . "','" . $hora . "','PROCESO','Alta_ingreso')";

											devolverValorQuery($query);
										}
										break;

									case 'CANCELACIONES':
										if ($concepto == '34') {

											$query_transaccion = "UPDATE clientes SET tipo_contratacion = 'SERVICIO INTERNET' , configuracion_internet = 'SI' WHERE id_cliente = '$id_cliente'";
											mysqli_query($conexion, $query_transaccion);

											//Si fue un pago parcial, registramos el saldo restante en transacciones
											if ($HayPagoParcial == true) {

												$saldo_restante = $pagoTotal - $pagoParcial;

												//Obtener la ultima transaccion del cliente
												$ultima_transaccion = devolverValorQuery("select id_transaccion,id_cliente,id_concepto,cargo,saldo_anterior,saldo_actual,fecha_transaccion,hora_transaccion from transacciones where id_cliente='$id_cliente' order by id_transaccion desc limit 1");
												//Preguntamos si ul ultima transaccion es 1 ( es un por pagar) o 2 (es un pago)
												if ($ultima_transaccion[2] == 1) {
													//Si es un por pagar, sumamos el saldo restante al saldo actual
													$saldo_anterior = $ultima_transaccion[5];
													$saldo_actual = $ultima_transaccion[5] + $saldo_restante;
												} else {
													//Si es un pago, restamos el saldo restante al saldo actual
													$saldo_anterior = $ultima_transaccion[5];
													//esto es para que si hay un saldo le sume el saldo restante y si no le sume 0
													$saldo_actual = $ultima_transaccion[5] + $saldo_restante;
												}

												//Insertamos la nueva transaccion
												$queryTransacciones = "insert into transacciones (id_transaccion,id_cliente,id_concepto,cargo,saldo_anterior,saldo_actual,fecha_transaccion,fecha_limite,hora_transaccion,origen) values (0,'$id_cliente',1,'$saldo_restante','$saldo_anterior','$saldo_actual','$fecha',NULL,'$hora','INGRESO PAGO PARCIAL')";
												mysqli_query($conexion, $queryTransacciones);
											}

											//Actualizacion de la configuracion de internet
											$queryCI = "select * from conf_internet where estatus = 'ACTUAL' AND pasos = 'Finalizado' AND  id_cliente='$id_cliente'";
											$registroCI = devolverValorQuery($queryCI);

											if ($registroCI) {
												$queryOld = "UPDATE conf_internet SET estatus = 'ANTERIOR', pasos = 'Finalizado' WHERE id_cliente='$id_cliente' AND id = '" . $registroCI['id'] . "'";
												devolverValorQuery($queryOld);
											} else {
												//si no tiene registro actual, preguntamos si tiene uno en proceso.
												$queryCIProceso = "select * from conf_internet where estatus = 'PROCESO' AND  id_cliente='$id_cliente'";
												$registroCIProceso = devolverValorQuery($queryCIProceso);

												if ($registroCIProceso) {
													$queryOld = "UPDATE conf_internet SET estatus = 'ANTERIOR', pasos = 'Finalizado' WHERE id_cliente='$id_cliente' AND id = '" . $registroCI['id'] . "'";
													devolverValorQuery($queryOld);
												}
											}
										}
										break;

									case 'CAMBIO DE DOMICILIO':
										if ($concepto == '55') {

											$query_transaccion = "UPDATE clientes SET tipo_contratacion = 'SERVICIO INTERNET' , configuracion_internet = 'SI' WHERE id_cliente = '$id_cliente'";
											mysqli_query($conexion, $query_transaccion);

											//Actualizacion de la configuracion de internet
											$queryCI = "select * from conf_internet where estatus = 'ACTUAL' AND pasos = 'Finalizado' AND  id_cliente='$id_cliente'";
											$registroCI = devolverValorQuery($queryCI);

											if ($registroCI) {
												$queryOld = "UPDATE conf_internet SET estatus = 'ANTERIOR', pasos = 'Finalizado' WHERE id_cliente='$id_cliente' AND id = '" . $registroCI['id'] . "'";
												devolverValorQuery($queryOld);
											}

											date_default_timezone_set('America/Mexico_City');
											$fecha = date('Y-m-d');
											$hora = date('H:i:s');

											$query = "INSERT INTO conf_internet (id,id_cliente,fecha_registro,hora_registro,estatus,pasos) values (0,'$id_cliente','" . $fecha . "','" . $hora . "','PROCESO','Alta_ingreso')";

											devolverValorQuery($query);
										}
										break;

									case 'PAGO DE MENSUALIDADES':
										if ($concepto == '44') {
											// Actualizar cliente
											$query_transaccion = "UPDATE clientes SET  tipo_contratacion = 'SERVICIO INTERNET' , configuracion_internet = 'SI' WHERE id_cliente = '$id_cliente'";
											mysqli_query($conexion, $query_transaccion);

											$query_transaccion = "insert into transacciones (id_transaccion,id_cliente,id_concepto,cargo,saldo_anterior,saldo_actual,fecha_transaccion,hora_transaccion) select 0,'$id_cliente',2,'$monto_total',(select saldo_actual from transacciones where id_cliente='$id_cliente' order by fecha_transaccion desc, id_transaccion desc limit 1) , (select saldo_actual-" . $monto_total . "  from transacciones where id_cliente='$id_cliente' order by fecha_transaccion desc, id_transaccion desc limit 1) , '$fecha' as fecha, '$hora' as hora";
											mysqli_query($conexion, $query_transaccion);
										}
										break;
									case 'CAMBIO DE SERVICIO':
										if ($concepto == '27') {
											//CLIENTE CON TV (QUITA TV Y AGREGA INTERNET)
											$query_transaccion = "UPDATE clientes SET tipo_contratacion = 'SERVICIO INTERNET' , configuracion_internet = 'SI' WHERE id_cliente = '$id_cliente'";
											mysqli_query($conexion, $query_transaccion);

											//Actualizacion de la configuracion de internet
											$queryCI = "select * from conf_internet where estatus = 'ACTUAL' AND pasos = 'Finalizado' AND  id_cliente='$id_cliente'";
											$registroCI = devolverValorQuery($queryCI);

											if ($registroCI) {
												$queryOld = "UPDATE conf_internet SET estatus = 'ANTERIOR', pasos = 'Finalizado' WHERE id_cliente='$id_cliente' AND id = '" . $registroCI['id'] . "'";
												devolverValorQuery($queryOld);
											}

											date_default_timezone_set('America/Mexico_City');
											$fecha = date('Y-m-d');
											$hora = date('H:i:s');

											$query = "INSERT INTO conf_internet (id,id_cliente,fecha_registro,hora_registro,estatus,pasos) values (0,'$id_cliente','" . $fecha . "','" . $hora . "','PROCESO','Alta_ingreso')";

											devolverValorQuery($query);
										}

										if ($concepto == '29') {
											//CLIENTE DE TV CON INTERNET (QUITA TV Y DEJA SOLO INTERNET)
											$query_transaccion = "UPDATE clientes SET tipo_contratacion = 'SERVICIO INTERNET' , configuracion_internet = 'SI' WHERE id_cliente = '$id_cliente'";
											mysqli_query($conexion, $query_transaccion);

											//Actualizacion de la configuracion de internet
											$queryCI = "select * from conf_internet where estatus = 'ACTUAL' AND pasos = 'Finalizado' AND  id_cliente='$id_cliente'";
											$registroCI = devolverValorQuery($queryCI);

											if ($registroCI) {
												$queryOld = "UPDATE conf_internet SET estatus = 'ANTERIOR', pasos = 'Finalizado' WHERE id_cliente='$id_cliente' AND id = '" . $registroCI['id'] . "'";
												devolverValorQuery($queryOld);
											}

											date_default_timezone_set('America/Mexico_City');
											$fecha = date('Y-m-d');
											$hora = date('H:i:s');

											$query = "INSERT INTO conf_internet (id,id_cliente,fecha_registro,hora_registro,estatus,pasos) values (0,'$id_cliente','" . $fecha . "','" . $hora . "','PROCESO','Alta_ingreso')";

											devolverValorQuery($query);
										}
										break;
								}
								break;
						}

						if ($index === 0) {
							//Insertamos el monto principal
							$query_montos = " insert into montos (id_monto,id_ingreso,id_tipo_ingreso,monto,es_adicional) values (0,'" . $id_ingreso . "','$concepto','$total_original',0)";
						} else {
							//Insertamos los montos adicionales
							$query_montos = " insert into montos (id_monto,id_ingreso,id_tipo_ingreso,monto,es_adicional) values (0,'" . $id_ingreso . "','$concepto','$total_original',1)";
						}

						mysqli_query($conexion, $query_montos);

						//obteniendo el id del monto
						$id_monto = mysqli_insert_id($conexion);

						//insertamos la promocion si es que tiene
						if ($promocionConcepto != '' && $promocionConcepto != null) {
							$query_promocion = "insert into monto_promocion (id_monto,id_promocion) values ('" . $id_monto . "','$promocionConcepto')";
							mysqli_query($conexion, $query_promocion);
						}
					}

					$bandera_imprimir_folio = true;

					//actualizar el numero de telefono del cliente

					if ($_POST['telefono_cliente'] != "" || $_POST['telefono_cliente'] != null) {
						$update_celular = "UPDATE clientes SET telefono = '" . addslashes($_POST['telefono_cliente']) . "' WHERE id_cliente = '" . addslashes($_POST['id_cliente']) . "'";
						mysqli_query($conexion, $update_celular);
					}

					//actualizar la tarifa del cliente

					if ($_POST['tarifa_cliente'] != "" || $_POST['tarifa_cliente'] != null) {
						$update_tarifa = "UPDATE clientes SET tarifa = '" . addslashes($_POST['tarifa_cliente']) . "' WHERE id_cliente = '" . addslashes($_POST['id_cliente']) . "'";
						mysqli_query($conexion, $update_tarifa);
					}

					//actualizar la curp del cliente
					if ($_POST['curp_cliente'] != "" || $_POST['curp_cliente'] != null) {
						$update_tarifa = "UPDATE clientes SET rfc = '" . addslashes($_POST['curp_cliente']) . "' WHERE id_cliente = '" . addslashes($_POST['id_cliente']) . "'";
						mysqli_query($conexion, $update_tarifa);
					}

					//Alerta de exito con redireccionamiento a reporte de servicio
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
							window.location.href = "https://sysadmrtv.tuvisiontelecable.com.mx/index.php?menu=18&accion=agregar";
						}, 3000); // Redirige después de 3 segundos
					</script>
				<?php

				} else {
					//en caso de error mostrar mensaje de error
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








				$total = count($_POST['conceptos_add']);
				$totales_add = array();
				$conceptos_add = array();
				$promociones_add = array();
				$montos_add = array();
				$monto_total = 0;

				//Este proceso es para montos adicionales
				for ($i = 0; $i < $total; $i++) {
					$query_promocion =  "select porcentaje from promociones where id_promocion=" . addslashes($_POST['promociones'][$i]);
					$promocion = devolverValorQuery($query_promocion);

					if ($promocion[0] == '')
						$promocion[0] = 0;

					$promociones_add[] = $_POST['promociones'][$i];
					$conceptos_add[] = $_POST['conceptos_add'][$i];
					$totales_add[]  = $_POST['monto_a'][$i] - $promocion[0];
					$montos_add[] = $_POST['monto_a'][$i];
				}

				for ($j = 0; $j < $total; $j++) {
					$monto_total += $totales_add[$j];
				}

				//Este proceso es para el monto del concepto original
				$query_promocion =  "select porcentaje from promociones where id_promocion=" . addslashes($_POST['promocion']);
				$promocion = devolverValorQuery($query_promocion);
				if ($promocion[0] == '')
					$promocion[0] = 0;

				$total_original = $_POST['monto'] - $promocion[0];

				$monto_total += $total_original;

				$query_next_folio = "select MAX(i.folio_nota)+ 1 AS SIGUIENTE from ingresos i, clientes c, sucursales s where i.id_cliente = c.id_cliente and c.id_sucursal=s.id_sucursal and s.id_sucursal=(select id_sucursal from clientes where id_cliente='" . addslashes($_POST['id_cliente']) . "')";

				$next_folio = devolverValorQuery($query_next_folio);

				$query_next_folio_nuevo = "select MAX(i.folio_nuevo)+ 1 AS SIGUIENTENUEVO,s.id_sucursal from ingresos i, clientes c, sucursales s where i.id_cliente = c.id_cliente and c.id_sucursal=s.id_sucursal and s.id_sucursal=(select id_sucursal from clientes where id_cliente='" . addslashes($_POST['id_cliente']) . "')";

				$next_folio_nuevo = devolverValorQuery($query_next_folio_nuevo);

				if ($next_folio[0] == '') {
					$next_folio[0] = '1';
				}

				if ($next_folio_nuevo[0] == '') {
					$next_folio_nuevo[0] = '1';
				}

				if ($_POST['nota_impresa'] == "") {
					$_POST['nota_impresa'] = "NULL";
				}

				$query = "insert into ingresos (id_ingreso,id_cliente,monto_total,fecha,observaciones, folio_nota,nota_impresa,folio_nuevo,recibo_fiscal) values (0,'" . addslashes($_POST['id_cliente']) . "','" . $monto_total . "','" . date('Y-m-d') . "','" . addslashes($_POST['observaciones']) . "','" . $next_folio[0] . "'," . addslashes($_POST['nota_impresa']) . "," . $next_folio_nuevo[0] . ",'" . $next_folio_nuevo[1] . "-" . $next_folio_nuevo[0] . "')";


				if (mysqli_query($conexion, $query)) {
					$id_ingreso = mysqli_insert_id($conexion);
					$concepto_caja = devolverValorQuery("select descripcion from cat_tipo_ingreso where id_tipo_ingreso='" . addslashes($_POST['concepto']) . "'");
					$sucursal = devolverValorQuery("select id_sucursal from clientes where id_cliente='" . addslashes($_POST['id_cliente']) . "'");
					insertarCaja($sucursal[0], $monto_total, 1, 1, $concepto_caja[0], $_POST['id_cliente'], $next_folio[0]);

					if ($_POST['concepto'] == '5') {
						$query_transaccion = "insert into transacciones (id_transaccion,id_cliente,id_concepto,cargo,saldo_anterior,saldo_actual,fecha_transaccion,hora_transaccion) select 0,'" . addslashes($_POST['id_cliente']) . "',2,'" . addslashes($_POST['monto']) . "',(select saldo_actual from transacciones where id_cliente='" . addslashes($_POST['id_cliente']) . "' order by fecha_transaccion desc, id_transaccion desc limit 1) , (select saldo_actual-" . addslashes($_POST['monto']) . "  from transacciones where id_cliente='" . addslashes($_POST['id_cliente']) . "' order by fecha_transaccion desc, id_transaccion desc limit 1) , '$fecha' as fecha, '$hora' as hora";
						mysqli_query($conexion, $query_transaccion);
					}

					//validar si el cliente tiene una configuracion de internet en proceso sin culminar
					$queryeliminar = "DELETE FROM conf_internet WHERE estatus = 'PROCESO' AND pasos = 'Alta_ingreso' AND  id_cliente='" . addslashes($_POST['id_cliente']) . "'";
					devolverValorQuery($queryeliminar);

					//Servicio TV
					if ($_POST['concepto'] == '1') {

						$query_transaccion = "UPDATE clientes SET tipo_contratacion = 'SERVICIO TV' , configuracion_internet = 'NO NECESARIO' WHERE id_cliente = '" . addslashes($_POST['id_cliente']) . "'";
						mysqli_query($conexion, $query_transaccion);
					}

					//Servicio TV + Internet

					if ($_POST['concepto'] == '9' || $_POST['concepto'] == '15') {

						//actualizacion de los datos de internet 

						$queryCI = "select * from conf_internet where estatus = 'ACTUAL' AND pasos = 'Finalizado' AND  id_cliente='" . addslashes($_POST['id_cliente']) . "'";

						$registroCI = devolverValorQuery($queryCI);

						if ($registroCI) {

							// $query = "update conf_internet set no_olt='".addslashes($_POST['no_olt'])."', no_caja='".addslashes($_POST['no_caja'])."', no_pon='".addslashes($_POST['no_pon'])."', marca_onu='".addslashes($_POST['marca_onu'])."', serie='".addslashes($_POST['serie'])."', mac_address='".addslashes($_POST['mac_address'])."', encapsulamiento='".addslashes($_POST['encapsulamiento'])."', registro_winbox='".addslashes($_POST['registro_winbox'])."', mac_winbox='".addslashes($_POST['mac_winbox'])."', plan_datos='".addslashes($_POST['plan_datos'])."', ip_instalacion='".addslashes($_POST['ip_instaalcion'])."' where id_cliente='".addslashes($_POST['cliente'])."'";

							$queryOld = "UPDATE conf_internet SET estatus = 'ANTERIOR', pasos = 'Finalizado' WHERE id_cliente='" . addslashes($_POST['id_cliente']) . "' AND id = '" . $registroCI['id'] . "'";
							devolverValorQuery($queryOld);
						}

						date_default_timezone_set('America/Mexico_City');
						$fecha = date('Y-m-d');
						$hora = date('H:i:s');

						$query = "INSERT INTO conf_internet (id,id_cliente,no_olt,no_caja,no_pon,fecha_registro,hora_registro,estatus,pasos)
						values 
						(0,'" . addslashes($_POST['id_cliente']) . "','" . addslashes($_POST['no_olt']) . "','" . addslashes($_POST['no_caja']) . "','" . addslashes($_POST['no_pon']) . "','" . $fecha . "','" . $hora . "','PROCESO','Alta_ingreso')";

						devolverValorQuery($query);

						//actualizacion de clientes 
						$query_transaccion = "UPDATE clientes SET tipo_contratacion = 'SERVICIO TV + INTERNET' , configuracion_internet = 'EN PROCESO' WHERE id_cliente = '" . addslashes($_POST['id_cliente']) . "'";
						mysqli_query($conexion, $query_transaccion);
					}

					//Instalacion solo internet

					if ($_POST['concepto'] == '8' || $_POST['concepto'] == '13' || $_POST['concepto'] == '14') {

						//actualizacion de los datos de internet 

						$queryCI = "select * from conf_internet where estatus = 'ACTUAL' AND pasos = 'Finalizado' AND  id_cliente='" . addslashes($_POST['id_cliente']) . "'";

						$registroCI = devolverValorQuery($queryCI);

						if ($registroCI) {

							// $query = "update conf_internet set no_olt='".addslashes($_POST['no_olt'])."', no_caja='".addslashes($_POST['no_caja'])."', no_pon='".addslashes($_POST['no_pon'])."', marca_onu='".addslashes($_POST['marca_onu'])."', serie='".addslashes($_POST['serie'])."', mac_address='".addslashes($_POST['mac_address'])."', encapsulamiento='".addslashes($_POST['encapsulamiento'])."', registro_winbox='".addslashes($_POST['registro_winbox'])."', mac_winbox='".addslashes($_POST['mac_winbox'])."', plan_datos='".addslashes($_POST['plan_datos'])."', ip_instalacion='".addslashes($_POST['ip_instaalcion'])."' where id_cliente='".addslashes($_POST['cliente'])."'";

							$queryOld = "UPDATE conf_internet SET estatus = 'ANTERIOR', pasos = 'Finalizado' WHERE id_cliente='" . addslashes($_POST['id_cliente']) . "' AND id = '" . $registroCI['id'] . "'";
							devolverValorQuery($queryOld);
						}

						date_default_timezone_set('America/Mexico_City');
						$fecha = date('Y-m-d');
						$hora = date('H:i:s');

						$query = "INSERT INTO conf_internet (id,id_cliente,no_olt,no_caja,no_pon,fecha_registro,hora_registro,estatus,pasos)
						values 
						(0,'" . addslashes($_POST['id_cliente']) . "','" . addslashes($_POST['no_olt']) . "','" . addslashes($_POST['no_caja']) . "','" . addslashes($_POST['no_pon']) . "','" . $fecha . "','" . $hora . "','PROCESO','Alta_ingreso')";

						devolverValorQuery($query);

						$query_transaccion = "UPDATE clientes SET tipo_contratacion = 'INSTALACION SOLO INTERNET' , configuracion_internet = 'EN PROCESO' WHERE id_cliente = '" . addslashes($_POST['id_cliente']) . "'";
						mysqli_query($conexion, $query_transaccion);
					}

					//cambio de TV + Internet por Internet

					if ($_POST['concepto'] == '16') {

						//actualizacion de los datos de internet 

						$queryCI = "select * from conf_internet where estatus = 'ACTUAL' AND pasos = 'Finalizado' AND  id_cliente='" . addslashes($_POST['id_cliente']) . "'";

						$registroCI = devolverValorQuery($queryCI);

						if ($registroCI) {

							// $query = "update conf_internet set no_olt='".addslashes($_POST['no_olt'])."', no_caja='".addslashes($_POST['no_caja'])."', no_pon='".addslashes($_POST['no_pon'])."', marca_onu='".addslashes($_POST['marca_onu'])."', serie='".addslashes($_POST['serie'])."', mac_address='".addslashes($_POST['mac_address'])."', encapsulamiento='".addslashes($_POST['encapsulamiento'])."', registro_winbox='".addslashes($_POST['registro_winbox'])."', mac_winbox='".addslashes($_POST['mac_winbox'])."', plan_datos='".addslashes($_POST['plan_datos'])."', ip_instalacion='".addslashes($_POST['ip_instaalcion'])."' where id_cliente='".addslashes($_POST['cliente'])."'";

							$queryOld = "UPDATE conf_internet SET estatus = 'ANTERIOR', pasos = 'Finalizado' WHERE id_cliente='" . addslashes($_POST['id_cliente']) . "' AND id = '" . $registroCI['id'] . "'";
							devolverValorQuery($queryOld);
						}

						date_default_timezone_set('America/Mexico_City');
						$fecha = date('Y-m-d');
						$hora = date('H:i:s');

						$query = "INSERT INTO conf_internet (id,id_cliente,no_olt,no_caja,no_pon,fecha_registro,hora_registro,estatus,pasos)
						values 
						(0,'" . addslashes($_POST['id_cliente']) . "','" . addslashes($_POST['no_olt']) . "','" . addslashes($_POST['no_caja']) . "','" . addslashes($_POST['no_pon']) . "','" . $fecha . "','" . $hora . "','PROCESO','Alta_ingreso')";

						devolverValorQuery($query);

						$query_transaccion = "UPDATE clientes SET tipo_contratacion = 'CAMBIO DE TV + INTERNET POR INTERNET' , configuracion_internet = 'EN PROCESO' WHERE id_cliente = '" . addslashes($_POST['id_cliente']) . "'";
						mysqli_query($conexion, $query_transaccion);
					}

					//cancelado

					// if ($_POST['concepto'] == '9') {

					// 	$query_transaccion = "UPDATE clientes SET tipo_contratacion = 'SERVICIO CANCELADO' , configuracion_internet = 'NO NECESARIO' WHERE id_cliente = '" . addslashes($_POST['id_cliente']) . "'";
					// 	mysqli_query($conexion, $query_transaccion);

					// 	print_r('cancelado');
					// }


					$query_montos = " insert into montos (id_monto,id_ingreso,id_tipo_ingreso,monto,es_adicional) values (0,'" . $id_ingreso . "','" . addslashes($_POST['concepto']) . "','" . addslashes($total_original) . "',0)";

					if ($total > 0) {
						for ($i = 0; $i < $total; $i++) {
							$query_montos .= ",(0,'" . $id_ingreso . "','" . addslashes($conceptos_add[$i]) . "','" . addslashes($totales_add[$i]) . "',1)";

							if ($conceptos_add[$i] == '5') {
								$query_transaccion_add = "insert into transacciones (id_transaccion,id_cliente,id_concepto,cargo,saldo_anterior,saldo_actual,fecha_transaccion,hora_transaccion) select 0,'" . addslashes($_POST['id_cliente']) . "',2,'" . addslashes($montos_add[$i]) . "',(select saldo_actual from transacciones where id_cliente='" . addslashes($_POST['id_cliente']) . "' order by fecha_transaccion desc, id_transaccion desc limit 1) , (select saldo_actual-" . addslashes($montos_add[$i]) . "  from transacciones where id_cliente='" . addslashes($_POST['id_cliente']) . "' order by fecha_transaccion desc, id_transaccion desc limit 1) , '$fecha' as fecha, '$hora' as hora";
								mysqli_query($conexion, $query_transaccion_add);
							}

							//validar si el cliente tiene una configuracion de internet en proceso sin culminar
							// $queryeliminar = "DELETE FROM conf_internet WHERE estatus = 'PROCESO' AND pasos = 'Alta_ingreso' AND  id_cliente='" . addslashes($_POST['id_cliente']) . "'";
							// devolverValorQuery($queryeliminar);

							//Servicio TV
							if ($conceptos_add[$i] == '1') {

								$query_transaccion = "UPDATE clientes SET tipo_contratacion = 'SERVICIO TV' , configuracion_internet = 'NO NECESARIO' WHERE id_cliente = '" . addslashes($_POST['id_cliente']) . "'";
								mysqli_query($conexion, $query_transaccion);
							}

							//Servicio TV + Internet

							if ($conceptos_add[$i] == '9' || $conceptos_add[$i] == '15') {

								//actualizacion de los datos de internet 

								$queryCI = "select * from conf_internet where estatus = 'ACTUAL' AND pasos = 'Finalizado' AND  id_cliente='" . addslashes($_POST['id_cliente']) . "'";

								$registroCI = devolverValorQuery($queryCI);

								if ($registroCI) {

									// $query = "update conf_internet set no_olt='".addslashes($_POST['no_olt'])."', no_caja='".addslashes($_POST['no_caja'])."', no_pon='".addslashes($_POST['no_pon'])."', marca_onu='".addslashes($_POST['marca_onu'])."', serie='".addslashes($_POST['serie'])."', mac_address='".addslashes($_POST['mac_address'])."', encapsulamiento='".addslashes($_POST['encapsulamiento'])."', registro_winbox='".addslashes($_POST['registro_winbox'])."', mac_winbox='".addslashes($_POST['mac_winbox'])."', plan_datos='".addslashes($_POST['plan_datos'])."', ip_instalacion='".addslashes($_POST['ip_instaalcion'])."' where id_cliente='".addslashes($_POST['cliente'])."'";

									$queryOld = "UPDATE conf_internet SET estatus = 'ANTERIOR', pasos = 'Finalizado' WHERE id_cliente='" . addslashes($_POST['id_cliente']) . "' AND id = '" . $registroCI['id'] . "'";
									devolverValorQuery($queryOld);
								}

								date_default_timezone_set('America/Mexico_City');
								$fecha = date('Y-m-d');
								$hora = date('H:i:s');

								$query = "INSERT INTO conf_internet (id,id_cliente,no_olt,no_caja,no_pon,fecha_registro,hora_registro,estatus,pasos)
								values 
								(0,'" . addslashes($_POST['id_cliente']) . "','" . addslashes($_POST['no_olt']) . "','" . addslashes($_POST['no_caja']) . "','" . addslashes($_POST['no_pon']) . "','" . $fecha . "','" . $hora . "','PROCESO','Alta_ingreso')";

								devolverValorQuery($query);

								$query_transaccion = "UPDATE clientes SET tipo_contratacion = 'SERVICIO TV + INTERNET' , configuracion_internet = 'EN PROCESO' WHERE id_cliente = '" . addslashes($_POST['id_cliente']) . "'";
								mysqli_query($conexion, $query_transaccion);
							}

							//Instalacion solo internet

							if ($conceptos_add[$i] == '8' || $conceptos_add[$i] == '13' || $conceptos_add[$i] == '14') {

								//actualizacion de los datos de internet 

								$queryCI = "select * from conf_internet where estatus = 'ACTUAL' AND pasos = 'Finalizado' AND  id_cliente='" . addslashes($_POST['id_cliente']) . "'";

								$registroCI = devolverValorQuery($queryCI);

								if ($registroCI) {

									// $query = "update conf_internet set no_olt='".addslashes($_POST['no_olt'])."', no_caja='".addslashes($_POST['no_caja'])."', no_pon='".addslashes($_POST['no_pon'])."', marca_onu='".addslashes($_POST['marca_onu'])."', serie='".addslashes($_POST['serie'])."', mac_address='".addslashes($_POST['mac_address'])."', encapsulamiento='".addslashes($_POST['encapsulamiento'])."', registro_winbox='".addslashes($_POST['registro_winbox'])."', mac_winbox='".addslashes($_POST['mac_winbox'])."', plan_datos='".addslashes($_POST['plan_datos'])."', ip_instalacion='".addslashes($_POST['ip_instaalcion'])."' where id_cliente='".addslashes($_POST['cliente'])."'";

									$queryOld = "UPDATE conf_internet SET estatus = 'ANTERIOR', pasos = 'Finalizado' WHERE id_cliente='" . addslashes($_POST['id_cliente']) . "' AND id = '" . $registroCI['id'] . "'";
									devolverValorQuery($queryOld);
								}

								date_default_timezone_set('America/Mexico_City');
								$fecha = date('Y-m-d');
								$hora = date('H:i:s');

								$query = "INSERT INTO conf_internet (id,id_cliente,no_olt,no_caja,no_pon,fecha_registro,hora_registro,estatus,pasos)
								values 
								(0,'" . addslashes($_POST['id_cliente']) . "','" . addslashes($_POST['no_olt']) . "','" . addslashes($_POST['no_caja']) . "','" . addslashes($_POST['no_pon']) . "','" . $fecha . "','" . $hora . "','PROCESO','Alta_ingreso')";

								devolverValorQuery($query);

								$query_transaccion = "UPDATE clientes SET tipo_contratacion = 'INSTALACION SOLO INTERNET' , configuracion_internet = 'EN PROCESO' WHERE id_cliente = '" . addslashes($_POST['id_cliente']) . "'";
								mysqli_query($conexion, $query_transaccion);
							}

							//cambio de TV + Internet por Internet

							if ($conceptos_add[$i] == '16') {

								//actualizacion de los datos de internet 

								$queryCI = "select * from conf_internet where estatus = 'ACTUAL' AND pasos = 'Finalizado' AND  id_cliente='" . addslashes($_POST['id_cliente']) . "'";

								$registroCI = devolverValorQuery($queryCI);

								if ($registroCI) {

									// $query = "update conf_internet set no_olt='".addslashes($_POST['no_olt'])."', no_caja='".addslashes($_POST['no_caja'])."', no_pon='".addslashes($_POST['no_pon'])."', marca_onu='".addslashes($_POST['marca_onu'])."', serie='".addslashes($_POST['serie'])."', mac_address='".addslashes($_POST['mac_address'])."', encapsulamiento='".addslashes($_POST['encapsulamiento'])."', registro_winbox='".addslashes($_POST['registro_winbox'])."', mac_winbox='".addslashes($_POST['mac_winbox'])."', plan_datos='".addslashes($_POST['plan_datos'])."', ip_instalacion='".addslashes($_POST['ip_instaalcion'])."' where id_cliente='".addslashes($_POST['cliente'])."'";

									$queryOld = "UPDATE conf_internet SET estatus = 'ANTERIOR' , pasos = 'Finalizado' WHERE id_cliente='" . addslashes($_POST['id_cliente']) . "' AND id = '" . $registroCI['id'] . "'";
									devolverValorQuery($queryOld);
								}

								date_default_timezone_set('America/Mexico_City');
								$fecha = date('Y-m-d');
								$hora = date('H:i:s');

								$query = "INSERT INTO conf_internet (id,id_cliente,no_olt,no_caja,no_pon,fecha_registro,hora_registro,estatus,pasos)
								values 
								(0,'" . addslashes($_POST['id_cliente']) . "','" . addslashes($_POST['no_olt']) . "','" . addslashes($_POST['no_caja']) . "','" . addslashes($_POST['no_pon']) . "','" . $fecha . "','" . $hora . "','PROCESO','Alta_ingreso')";

								devolverValorQuery($query);

								$query_transaccion = "UPDATE clientes SET tipo_contratacion = 'CAMBIO DE TV + INTERNET POR INTERNET' , configuracion_internet = 'EN PROCESO' WHERE id_cliente = '" . addslashes($_POST['id_cliente']) . "'";
								mysqli_query($conexion, $query_transaccion);
							}

							//cancelado

							// if ($conceptos_add[$i] == '9') {

							// 	$query_transaccion = "UPDATE clientes SET tipo_contratacion = 'SERVICIO CANCELADO' , configuracion_internet = 'NO NECESARIO' WHERE id_cliente = '" . addslashes($_POST['id_cliente']) . "'";
							// 	mysqli_query($conexion, $query_transaccion);
							// }
						}
					}
					if (mysqli_query($conexion, $query_montos)) {
						$lista_montos = "select id_monto, es_adicional from montos where id_ingreso='" . $id_ingreso . "'";
						$tabla_montos = mysqli_query($conexion, $lista_montos);
						$insert_monto_promocion = "insert into monto_promocion (id_monto,id_promocion) values ";
						$add_query_promo = "";
						$bandera_promo = false;
						$n = 0;
						$j = 0;
						while ($registro_montos = mysqli_fetch_array($tabla_montos)) {
							$bandera_promo = true;



							if ($registro_montos[1] == '1') {
								if ($promociones_add[$j] != "null") {

									if ($n > 0)
										$add_query_promo .= ",";


									$add_query_promo .= "(" . $registro_montos[0] . "," . addslashes($promociones_add[$j]) . ")";
								}

								$j++;
							} else {
								if ($_POST['promocion'] != "null") {
									if ($n > 0)
										$add_query_promo .= ",";
									$add_query_promo .= "(" . $registro_montos[0] . "," . addslashes($_POST['promocion']) . ")";
								}
							}
							$n++;
						}
						$insert_monto_promocion = $insert_monto_promocion . $add_query_promo;
						if ($bandera_promo) {
							mysqli_query($conexion, $insert_monto_promocion);
						}
						$bandera_imprimir_folio = true;

						//actualizar el numero de telefono del cliente

						if ($_POST['telefono_cliente'] != "" || $_POST['telefono_cliente'] != null) {
							$update_celular = "UPDATE clientes SET telefono = '" . addslashes($_POST['telefono_cliente']) . "' WHERE id_cliente = '" . addslashes($_POST['id_cliente']) . "'";
							mysqli_query($conexion, $update_celular);
						}

						//actualizar la tarifa del cliente

						if ($_POST['tarifa_cliente'] != "" || $_POST['tarifa_cliente'] != null) {
							$update_tarifa = "UPDATE clientes SET tarifa = '" . addslashes($_POST['tarifa_cliente']) . "' WHERE id_cliente = '" . addslashes($_POST['id_cliente']) . "'";
							mysqli_query($conexion, $update_tarifa);
						}

						//actualizar la curp del cliente
						if ($_POST['curp_cliente'] != "" || $_POST['curp_cliente'] != null) {
							$update_tarifa = "UPDATE clientes SET rfc = '" . addslashes($_POST['curp_cliente']) . "' WHERE id_cliente = '" . addslashes($_POST['id_cliente']) . "'";
							mysqli_query($conexion, $update_tarifa);
						}


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
								window.location.href = "https://sysadmrtv.tuvisiontelecable.com.mx/index.php?menu=18&accion=agregar";
							}, 3000); // Redirige después de 3 segundos
						</script>
					<?php
					} else {
					?>
						<tr>
							<td colspan="3" align="center">
								<table border="0" width="100%" cellpadding="0" cellspacing="0">
									<tr>
										<td width="5px" background="imagenes/message_left.png"></td>
										<td align="center" background="imagenes/message_center.png" height="30" valign="middle" class="fine">Algunos datos fueron agregados, correctamente otros no</td>
										<td width="5px" background="imagenes/message_right.png"></td>
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
									<td align="center" background="imagenes/message_error_center.png" height="30" valign="middle" class="warning">Hubo un problema al agregar los datos.</td>
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
			<form name="datagrid" method="post"><input name="id_ingreso" id="id_ingreso" type="hidden" />
				<table class="datagrid" width="100%" border="0" cellspacing="0">
					<tr>
						<td colspan="10" height="3px" class="separador"></td>
					</tr>
					<tr class="tabla_columns">
						<td>Folio</td>
						<td>Recibo Fiscal</td>
						<td>Sucursal</td>
						<td>Cliente</td>
						<td>Nota Impresa</td>
						<td width="100px" align="right">Monto</td>
						<td width="10px">&nbsp;</td>
						<td width="300px" align="center">Observaciones</td>
						<td width="10px">&nbsp;</td>
						<td align="center">Fecha</td>
						<td align="center" width="50px">Seleccionar&nbsp;<!--<input type="checkbox" name="selector" onclick="seleccionar()" />--><input type='hidden' name='accion' /></td>
					</tr>
					<?php
					if (isset($_POST['aplicar_filtro'])) {
						$add_query = "";
						if ($_POST['id_cliente'] != "") {
							$add_query .= " and i.id_cliente='" . addslashes($_POST['id_cliente']) . "' ";
						}

						if ($_POST['desde'] != "" && $_POST['hasta'] != "") {
							$add_query .= " and i.fecha between '" . addslashes($_POST['desde']) . "' and '" . addslashes($_POST['hasta']) . "' ";
						}

						if ($_POST['monto'] != "") {
							$add_query .= " and i.monto_total='" . addslashes($_POST['monto']) . "' ";
						}

						if ($_POST['tipo_ingreso'] != "-1") {
							$add_table = ", montos m ";
							$add_query .= " and m.id_ingreso=i.id_ingreso and m.id_tipo_ingreso='" . addslashes($_POST['tipo_ingreso']) . "' ";
						}


						$query = "select distinct i.id_ingreso,i.folio_nota, c.id_sucursal, i.id_cliente,c.nombre,c.apellido_paterno,c.apellido_materno,nota_impresa, i.monto_total,substring(i.observaciones,1,100), i.fecha,i.recibo_fiscal from ingresos i, clientes c " . $add_table . " where i.id_cliente= c.id_cliente " . $add_query . " order by c.id_sucursal, i.fecha desc, i.id_ingreso desc";

						$_SESSION['filtro_ingresos'] = $query;

						$tabla = mysqli_query($conexion, $query);
						while ($registro = mysqli_fetch_array($tabla)) {
							$bandera = true;
					?>
							<tr class="tabla_row">
								<td><?php echo $registro[1]; ?></td>
								<td><?php echo $registro[8]; ?></td>
								<td><?php echo $registro[2]; ?></td>
								<td><?php echo $registro[3] . " " . $registro[4] . " " . $registro[5] . " " . $registro[6]; ?></td>
								<td><?php echo $registro[7]; ?></td>
								<td align="right"><?php echo $registro[8]; ?></td>
								<td width="10px">&nbsp;</td>
								<td align="center"><?php echo $registro[9]; ?></td>
								<td width="10px">&nbsp;</td>
								<td align="center"><?php echo $registro[10]; ?></td>
								<td align="center"><input type="checkbox" name="<?php echo $registro[0];  ?>" /></td>
							</tr>
						<?php
						}
						if (!$bandera) {
						?>
							<tr>
								<td colspan="10">No hay Resultados.</td>
							</tr>
						<?php
						}
					} else {
						?>
						<tr>
							<td colspan="10">Ultilice el bot&oacute;n <b>"Filtro"</b> para hacer una b&uacute;squeda de registros</td>
						</tr>
					<?php
					}
					?>
					<tr>
						<td colspan="10" height="3px" class="separador"></td>
					</tr>
				</table>
			</form>
		</td>
	</tr>
</table>
<?php
if ($bandera_imprimir_folio) {
?>
	<script>
		$(function() {
			document.getElementById('imprimir_recibo').onclick = function() {
				if (confirm("Imprimir Recibo de Pago?"))
					imprimir(<?php echo $id_ingreso;  ?>);
			}
		});
	</script>
<?php
} else {
?>
	<script>
		document.getElementById('imprimir_recibo').style.display = "none";
	</script>
<?php
}
?>