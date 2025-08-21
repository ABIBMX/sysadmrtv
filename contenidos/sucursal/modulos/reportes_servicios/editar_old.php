    <script>
    	var cal1,
    		cal2,
    		mCal,
    		mDCal,
    		newStyleSheet;
    	var dateFrom = null;
    	var dateTo = null;

    	function calendario(obj) {

    		cal1 = new dhtmlxCalendarObject(obj);
    		cal1.setSkin('dhx_skyblue');

    	}
    </script>
    <script language="javascript" type="text/javascript">
    	function _Ajax(id, valor, valor2) {

    		bandera_numeros = false;
    		var div_numero = document.getElementById(id);
    		if (valor != "null") {
    			div_numero.innerHTML = "<img src='imagenes/loading.gif' /> <span style='font-size:10px;'>Cargando ...</span>";
    			var cdata = "id=" + id + "&valor1=" + valor + "&valor2=" + valor2;
    			$.ajax({
    				type: "POST",
    				url: "ajaxProcess/reporte_servicio.php",
    				data: cdata,
    				success: function(datos) {
    					div_numero.innerHTML = datos;
    					bandera_calles = true;
    					bandera_numeros = true;
    				}
    			});
    		} else {
    			div_numero.innerHTML = "No Asignado";
    		}
    	}

    	function _Ajax2(id, numero, valor) {
    		bandera_numeros = false;
    		var div_numero = document.getElementById(id + numero);
    		if (valor != "null") {
    			div_numero.innerHTML = "<img src='imagenes/loading.gif' /> <span style='font-size:10px;'>Cargando ...</span>";
    			var cdata = "id=" + id + "&valor1=" + valor;
    			$.ajax({
    				type: "POST",
    				url: "ajaxProcess/reporte_servicio.php",
    				data: cdata,
    				success: function(datos) {
    					div_numero.innerHTML = datos;
    					bandera_calles = true;
    					bandera_numeros = true;
    				}
    			});
    		} else {
    			div_numero.innerHTML = "No Asignado";
    		}
    	}

    	function agregar() {

    		if (document.getElementById('services')) {

    			var tabla_mayor = document.getElementById('services');
    			var tbody = document.createElement('tbody');
    			var fila = document.createElement('tr');
    			fila.id = 'dinamico_' + (++count);


    			var campo1 = document.createElement('div');
    			var campo2 = document.createElement('img');

    			campo2.src = 'imagenes/del.png';
    			campo2.name = fila.id;
    			campo2.onclick = elimCamp;

    			campo1.id = "serv_aux" + count;

    			var celda = document.createElement('td');
    			var celda2 = document.createElement('td');

    			celda.appendChild(campo1);
    			celda2.appendChild(campo2);


    			fila.appendChild(celda);
    			fila.appendChild(celda2);

    			tbody.appendChild(fila);
    			tabla_mayor.appendChild(tbody);
    			_Ajax2('serv_aux', count, document.getElementById('t_serv')[document.getElementById('t_serv').selectedIndex].value);
    		}

    	}

    	evento = function(evt) { //esta funcion nos devuelve el tipo de evento disparado
    		return (!evt) ? event : evt;
    	}

    	elimCamp = function(evt) {
    		evt = evento(evt);
    		nCampo = rObj(evt);


    		div_eliminar = document.getElementById(nCampo.name);
    		div_eliminar.parentNode.removeChild(div_eliminar);
    	}

    	rObj = function(evt) {
    		return evt.srcElement ? evt.srcElement : evt.target;
    	}

    	function crea_nota() {
    		if (document.getElementById('id_cliente')) {
    			if (document.getElementById('t_serv')[document.getElementById('t_serv').selectedIndex].value == 1) {
    				_Ajax('nota', document.getElementById('id_cliente').value);
    			} else {
    				_Ajax('nota');
    			}
    		} else {
    			document.getElementById('nota').innerHTML = "<span>Seleccione 'nota' en tipo de servicio y un cliente</span>";
    		}
    	}

    	var contenedor_empleado = ""; //Se actualiza para saber en que input se coloca la llave del cliente
    	var contenedor_cliente = ""; //Se actualiza para saber en que input se coloca la llave del cliente
    	var parametro_sucursal_empleado = ""; // Se utiliza en caso de que queramos la lista de clientes de una sucursal en especifica
    	var parametro_sucursal_cliente = ""; // Se utiliza en caso de que queramos la lista de clientes de una sucursal en especifica
    	function cambio_id_empleado(id) {

    	}

    	function cambio_id_cliente(id) {
    		crea_nota();
    		if (document.getElementById('t_serv')[document.getElementById('t_serv').selectedIndex].value) {
    			_Ajax('servicio', document.getElementById('t_serv')[document.getElementById('t_serv').selectedIndex].value);
    		}

    		_Ajax('taps', id);

    	}

    	function fechas(caja) {

    		if (caja.value) {
    			borrar = caja.value;
    			if ((caja.value.substr(4, 1) == "-") && (caja.value.substr(7, 1) == "-")) {
    				if (borrar) {
    					a = caja.value.substr(0, 4);
    					m = caja.value.substr(5, 2);
    					d = caja.value.substr(8, 2);
    					if ((a < 1900) || (a > 2050) || (m < 1) || (m > 12) || (d < 1) || (d > 31))
    						borrar = '';
    					else {
    						if ((a % 4 != 0) && (m == 2) && (d > 28))
    							borrar = ''; // A�o no viciesto y es febrero y el dia es mayor a 28
    						else {
    							if ((((m == 4) || (m == 6) || (m == 9) || (m == 11)) && (d > 30)) || ((m == 2) && (d > 29)))
    								borrar = '';
    						}
    					}
    				}
    			} else
    				borrar = '';
    			if (borrar == '') {
    				alert('Fecha erronea');
    				caja.value = borrar;
    			}
    		}
    	}

    	function cambios(val1) {

    		valores = val1.split(" ");
    		document.formulario.tap.value = valores[0];
    		document.formulario.valor.value = valores[1];
    		document.formulario.salida.value = valores[2];
    	}

    	function guardarConfInternet() {

    		var cadena = "";

    		if (document.formulario.id_confInternet.value == '')
    			cadena += "\n*";

    		if (document.formulario.id_cliente_confInternet.value == '')
    			cadena += "\n* Debe seleccionar un cliente.";

    		if (document.formulario.no_olt.value == '')
    			cadena += "\n* El No. de OLT no debe estar vacio.";

    		if (document.formulario.no_caja.value == '')
    			cadena += "\n* El No. de CAJA no debe estar vacio.";

    		if (document.formulario.no_pon.value == '')
    			cadena += "\n* El No. de PON no debe estar vacio.";

    		if (document.formulario.marca_onu.value == '')
    			cadena += "\n* Debe ingresar la marca de la ONU.";

    		if (document.formulario.modelo_onu.value == '')
    			cadena += "\n* Debe ingresar el modelo de la ONU.";

    		if (document.formulario.serie.value == '')
    			cadena += "\n* Debe ingresar la serie de la ONU.";

    		if (document.formulario.mac_address.value == '')
    			cadena += "\n* Debe ingresar la MAC Address de la caja.";

    		if (document.formulario.encapsulamiento.value == 'null')
    			cadena += "\n* Debe seleccionar un tipo de encapsulamiento.";

    		// if (document.formulario.registro_winbox.value == 'null')
    		// 	cadena += "\n* Debe seleccionar si esta registrado en WINBOX.";

    		// if (document.formulario.mac_winbox.value == '')
    		// 	cadena += "\n* Debe ingresar la MAC de WINBOX.";

    		// if (document.formulario.plan_datos.value == 'null')
    		// 	cadena += "\n* Debe seleccionar si tiene plan de datos.";

    		if (document.formulario.vlan.value == '')
    			cadena += "\n* Debe ingresar la VLAN.";

    		// if (document.formulario.resguardo.value == 'null')
    		// 	cadena += "\n* Debe seleccionar si tiene resguardo.";

    		if (cadena == "") {

    			alerta = false;

    			var id_confInternet = "id_confInternet=" + document.formulario.id_confInternet.value;
    			var id_cliente_confInternet = "id_cliente_confInternet=" + document.formulario.id_cliente_confInternet.value;
    			var no_olt = "no_olt=" + document.formulario.no_olt.value;
    			var no_caja = "no_caja=" + document.formulario.no_caja.value;
    			var no_pon = "no_pon=" + document.formulario.no_pon.value;
    			var marca_onu = "marca_onu=" + document.formulario.marca_onu.value;
    			var modelo_onu = "modelo_onu=" + document.formulario.modelo_onu.value;
    			var serie = "serie=" + document.formulario.serie.value;
    			var mac_address = "mac_address=" + document.formulario.mac_address.value;
    			var encapsulamiento = "encapsulamiento=" + document.formulario.encapsulamiento.value;
    			// var registro_winbox = "registro_winbox=" + document.formulario.registro_winbox.value;
    			// var mac_winbox = "mac_winbox=" + document.formulario.mac_winbox.value;
    			// var plan_datos = "plan_datos=" + document.formulario.plan_datos.value;
    			var vlan = "vlan=" + document.formulario.vlan.value;
    			// var resguardo = "resguardo=" + document.formulario.resguardo.value;

    			//alert(id_confInternet+ "&" + id_cliente_confInternet + "&" + no_olt + "&" + no_caja + "&" + no_pon + "&" + marca_onu + "&" + modelo_onu + "&" + serie + "&" + mac_address + "&" + encapsulamiento + "&" + registro_winbox + "&" + mac_winbox + "&" + plan_datos + "&" + vlan + "&" + resguardo);


    			$.ajax({
    				type: "POST",
    				url: "ajaxProcess/reporte_servicio.php",
    				// data: id_confInternet + "&" + id_cliente_confInternet + "&" + no_olt + "&" + no_caja + "&" + no_pon + "&" + marca_onu + "&" + modelo_onu + "&" + serie + "&" + mac_address + "&" + encapsulamiento + "&" + registro_winbox + "&" + mac_winbox + "&" + plan_datos + "&" + vlan + "&" + resguardo,
    				data: id_confInternet + "&" + id_cliente_confInternet + "&" + no_olt + "&" + no_caja + "&" + no_pon + "&" + marca_onu + "&" + modelo_onu + "&" + serie + "&" + mac_address + "&" + encapsulamiento + "&" + vlan,
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

    	function guardarConfInternet2() {

    		var cadena = "";

    		if (document.formulario.id_confInternet.value == '')
    			cadena += "\n*";

    		if (document.formulario.id_cliente_confInternet.value == '')
    			cadena += "\n* Debe seleccionar un cliente.";

    		if (document.formulario.no_olt.value == '')
    			cadena += "\n* El No. de OLT no debe estar vacio.";

    		if (document.formulario.no_caja.value == '')
    			cadena += "\n* El No. de CAJA no debe estar vacio.";

    		if (document.formulario.no_pon.value == '')
    			cadena += "\n* El No. de PON no debe estar vacio.";

    		if (document.formulario.marca_onu.value == '')
    			cadena += "\n* Debe ingresar la marca de la ONU.";

    		if (document.formulario.modelo_onu.value == '')
    			cadena += "\n* Debe ingresar el modelo de la ONU.";

    		if (document.formulario.serie.value == '')
    			cadena += "\n* Debe ingresar la serie de la ONU.";

    		if (document.formulario.mac_address.value == '')
    			cadena += "\n* Debe ingresar la MAC Address de la caja.";

    		if (document.formulario.encapsulamiento.value == 'null')
    			cadena += "\n* Debe seleccionar un tipo de encapsulamiento.";

    		if (document.formulario.registro_winbox.value == 'null')
    			cadena += "\n* Debe seleccionar si esta registrado en WINBOX.";

    		if (document.formulario.mac_winbox.value == '')
    			cadena += "\n* Debe ingresar la MAC de WINBOX.";

    		if (document.formulario.plan_datos.value == 'null')
    			cadena += "\n* Debe seleccionar si tiene plan de datos.";

    		if (document.formulario.vlan.value == '')
    			cadena += "\n* Debe ingresar la VLAN.";

    		if (document.formulario.resguardo.value == 'null')
    			cadena += "\n* Debe seleccionar si tiene resguardo.";

    		if (document.formulario.salida_nap.value == '')
    			cadena += "\n* Debe ingresar la salida NAP.";

    		if (document.formulario.potencia_SDivisor.value == '')
    			cadena += "\n* Debe ingresar la potencia de salida divisor.";

    		if (document.formulario.potencia_llCasa.value == '')
    			cadena += "\n* Debe ingresar la potencia de llegada a casa.";

    		if (document.formulario.ip_instalacion.value == '')
    			cadena += "\n* Debe ingresar la IP de instalacion asignada.";


    		if (cadena == "") {

    			alerta = false;

    			var id_confInternet = "id_confInternet=" + document.formulario.id_confInternet.value;
    			var id_cliente_confInternet = "id_cliente_confInternet=" + document.formulario.id_cliente_confInternet.value;
    			var no_olt = "no_olt=" + document.formulario.no_olt.value;
    			var no_caja = "no_caja=" + document.formulario.no_caja.value;
    			var no_pon = "no_pon=" + document.formulario.no_pon.value;
    			var marca_onu = "marca_onu=" + document.formulario.marca_onu.value;
    			var modelo_onu = "modelo_onu=" + document.formulario.modelo_onu.value;
    			var serie = "serie=" + document.formulario.serie.value;
    			var mac_address = "mac_address=" + document.formulario.mac_address.value;
    			var encapsulamiento = "encapsulamiento=" + document.formulario.encapsulamiento.value;
    			var registro_winbox = "registro_winbox=" + document.formulario.registro_winbox.value;
    			var mac_winbox = "mac_winbox=" + document.formulario.mac_winbox.value;
    			var plan_datos = "plan_datos=" + document.formulario.plan_datos.value;
    			var vlan = "vlan=" + document.formulario.vlan.value;
    			var resguardo = "resguardo=" + document.formulario.resguardo.value;
    			var salida_nap = "salida_nap=" + document.formulario.salida_nap.value;
    			var potencia_SDivisor = "potencia_SDivisor=" + document.formulario.potencia_SDivisor.value;
    			var potencia_llCasa = "potencia_llCasa=" + document.formulario.potencia_llCasa.value;
    			var ip_instalacion = "ip_instalacion=" + document.formulario.ip_instalacion.value;

    			//alert(id_confInternet + "&" + id_cliente_confInternet + "&" + no_olt + "&" + no_caja + "&" + no_pon + "&" + marca_onu + "&" + modelo_onu + "&" + serie + "&" + mac_address + "&" + encapsulamiento + "&" + registro_winbox + "&" + mac_winbox + "&" + plan_datos + "&" + vlan + "&" + resguardo + "&" + salida_nap + "&" + potencia_SDivisor + "&" + potencia_llCasa + "&" + ip_instalacion);


    			$.ajax({
    				type: "POST",
    				url: "ajaxProcess/reporte_servicio.php",
    				data: id_confInternet + "&" + id_cliente_confInternet + "&" + no_olt + "&" + no_caja + "&" + no_pon + "&" + marca_onu + "&" + modelo_onu + "&" + serie + "&" + mac_address + "&" + encapsulamiento + "&" + registro_winbox + "&" + mac_winbox + "&" + plan_datos + "&" + vlan + "&" + resguardo + "&" + salida_nap + "&" + potencia_SDivisor + "&" + potencia_llCasa + "&" + ip_instalacion,
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
    <?php

	if (isset($_GET['id']))
		$id = $_GET['id'];

	if (isset($_POST['select'])) {
		$aux = array_keys($_POST['select']);
		$id = $aux[0];
	} else {


		foreach ($_POST as $variable => $valor) {
			if ($variable != "selector") {
				if ($variable != "accion") {
					$id = $variable;
				}
			}
		}
	}
	if (isset($id)) {

		$lista = array();
		$query_serv = "select 
			id_tipo_servicio
			from cliente_servicios  where id_reporte='" . addslashes($id) . "'";
		$res = mysqli_query($conexion, $query_serv);
		while (list($valor) = mysqli_fetch_array($res)) {
			array_push($lista, $valor);
		}




		$query = "select 
			substr(id_empleado,3,3),
			id_empleado,
			id_cliente,
			folio,
			fecha_reporte,
			id_tipo_atencion,
			fecha_atencion,
			descripcion_atencion,
			importe_inputable,
			nota_inputable,
			id_peticion,
			id_ingreso,
			id_estatus_servicio,
			descripcion_falla
			from reporte_servicios rs where id_reporte='" . addslashes($id) . "'";
		$registro = devolverValorQuery($query);
		if ($registro[0] != '') {
			if ($registro[12] == 1) {


	?>






    			<form name="formulario" method="post" onsubmit="return false;" action="index.php?menu=18">



    				<input type="hidden" name="id" value="<?php echo addslashes($_GET['id']) ?>" />
    				<table border="0px" width="100%" style="color:#000000;font-size:12px">
    					<tr>
    						<td align="right">
    							<table border="0" width="100%" cellpadding="0" cellspacing="0">
    								<tr>
    									<td width="5px" background="imagenes/module_left.png"></td>
    									<td width="70px" background="imagenes/module_center.png" height="80" valign="middle"><img src="imagenes/reportes_servicios.png" /></td>
    									<td align="left" background="imagenes/module_center.png" height="80" valign="middle" class="titulo"><b>&nbsp;&nbsp;EDITAR REPORTE</b></td>
    									<td align="right" background="imagenes/module_center.png" height="80">
    										<!-- <button class="boton2" id="guardar" onclick="save();" ><img src="imagenes/guardar.png" /><br/>Guardar</button>-->
    										<?php

											// $servicio = "SELECT id_tipo_servicio from cat_tipo_servicios where id_tipo_servicio in (select id_tipo_servicio from rel_tipo_ingreso_servicio where id_tipo_ingreso in (select id_tipo_ingreso from montos where id_ingreso='$registro[11]'))";
											// $result_servicio = devolverValorQuery($servicio);

											$banderaInternet = 0;
											$banderaNoInternet = 0;

											$servicio = "SELECT id_tipo_servicio from cat_tipo_servicios where id_tipo_servicio in (select id_tipo_servicio from rel_tipo_ingreso_servicio where id_tipo_ingreso in (select id_tipo_ingreso from montos where id_ingreso='$registro[11]'))";
											$result_servicio = mysqli_query($conexion, $servicio);
											while ($result = mysqli_fetch_array($result_servicio)) {

												$id_tipo_servicio = $result['id_tipo_servicio'];

												if ($id_tipo_servicio == 34 || $id_tipo_servicio == 33 || $id_tipo_servicio == 45 || $id_tipo_servicio == 46 || $id_tipo_servicio == 53) {
													$banderaInternet = 1;
												} else {
													$banderaNoInternet = 1;
												}
											}



											//combinaciones
											//banderaInternet = 1 y banderaNoInternet = 0 tiene solo un servicio de internet
											//banderaInternet = 1 y banderaNoInternet = 1 tiene un servicio de internet con algo mas
											//banderaInternet = 0 y banderaNoInternet = 1 tiene un servicio que no es de internet
											//banderaInternet = 0 y banderaNoInternet = 0 no tiene ningun servicio



											// if ($result_servicio[0] == 34 || $result_servicio[0] == 33 || $result_servicio[0] == 45 || $result_servicio[0] == 46 || $result_servicio[0] == 53) {
											if ($banderaInternet == 1 && $banderaNoInternet == 0 || $banderaInternet == 1 && $banderaNoInternet == 1) {

												//para el paso de agregar la ONU

												$datos_internet_btn = "SELECT id  FROM conf_internet WHERE  estatus = 'PROCESO' AND pasos = 'Alta_ingreso' AND id_cliente = '$registro[2]'";
												$result = mysqli_query($conexion, $datos_internet_btn);

												if (mysqli_num_rows($result) > 0) {

													echo "<button class='boton2' id='guardar' style='font-size: 8px;' onclick='guardarConfInternet()';'><img src='imagenes/guardar.png' /><br />Información de ONU</button>";
												}

												//Para agregar la informacion del como dato
												$datos_internet_btn_modi = "SELECT id FROM conf_internet WHERE  estatus = 'PROCESO' AND pasos = 'Reporte_modificacion' AND id_cliente = '$registro[2]'";
												$result = mysqli_query($conexion, $datos_internet_btn_modi);

												if (mysqli_num_rows($result) > 0) {
													echo "<button class='boton2' id='guardar' style='font-size: 8px;' onclick='guardarConfInternet2()' ;'><img src='imagenes/guardar.png' /><br />Información del COMODATO</button>";
												}

												//ATENDER EL REPORTE DE SERVICIO 
												$datos_internet = "SELECT id FROM conf_internet WHERE  estatus = 'PROCESO' AND pasos = 'Cierre_reporte' AND id_cliente = '$registro[2]'";
												$result = mysqli_query($conexion, $datos_internet);

												if (mysqli_num_rows($result) > 0) {

													echo "<button class='boton2' id='guardar' onclick='atender();'><img src='imagenes/Ok.png' /><br />Atendido</button>";
												}
											} else {
												echo "<button class='boton2' id='guardar' onclick='atender();'><img src='imagenes/Ok.png' /><br />Atendido</button>";
											}
											?>
    										<!-- <button class="boton2" id="guardar" onclick="atender();"><img src="imagenes/Ok.png" /><br />Atendido</button> -->
    										<button class="boton2" onclick="location.href='index.php?menu=18'"><img src="imagenes/cancelar.png" /><br />Regresar</button>
    									</td>
    									<td width="5px" background="imagenes/module_right.png"></td>
    								</tr>
    							</table>
    						</td>
    					</tr>

    					<tr>

    						<?php

							// $servicio = "SELECT id_tipo_servicio from cat_tipo_servicios where id_tipo_servicio in (select id_tipo_servicio from rel_tipo_ingreso_servicio where id_tipo_ingreso in (select id_tipo_ingreso from montos where id_ingreso='$registro[11]'))";
							// $result_servicio = devolverValorQuery($servicio);

							$banderaInternet = 0;
							$banderaNoInternet = 0;

							$servicio = "SELECT id_tipo_servicio from cat_tipo_servicios where id_tipo_servicio in (select id_tipo_servicio from rel_tipo_ingreso_servicio where id_tipo_ingreso in (select id_tipo_ingreso from montos where id_ingreso='$registro[11]'))";
							$result_servicio = mysqli_query($conexion, $servicio);
							while ($result = mysqli_fetch_array($result_servicio)) {

								$id_tipo_servicio = $result['id_tipo_servicio'];

								if ($id_tipo_servicio == 34 || $id_tipo_servicio == 33 || $id_tipo_servicio == 45 || $id_tipo_servicio == 46 || $id_tipo_servicio == 53) {
									$banderaInternet = 1;
								} else {
									$banderaNoInternet = 1;
								}
							}

							//combinaciones
							//banderaInternet = 1 y banderaNoInternet = 0 tiene solo un servicio de internet
							//banderaInternet = 1 y banderaNoInternet = 1 tiene un servicio de internet con algo mas
							//banderaInternet = 0 y banderaNoInternet = 1 tiene un servicio que no es de internet
							//banderaInternet = 0 y banderaNoInternet = 0 no tiene ningun servicio


							// if ($result_servicio[0] == 34 || $result_servicio[0] == 33 || $result_servicio[0] == 45 || $result_servicio[0] == 46 || $result_servicio[0] == 53) {
							if ($banderaInternet == 1 && $banderaNoInternet == 0 || $banderaInternet == 1 && $banderaNoInternet == 1) {

								//para el paso de agregar la ONU

								$datos_internet_btn = "SELECT id  FROM conf_internet WHERE  estatus = 'PROCESO' AND pasos = 'Alta_ingreso' AND id_cliente = '$registro[2]'";
								$result = mysqli_query($conexion, $datos_internet_btn);

								if (mysqli_num_rows($result) > 0) {

									echo "<td style='color: red; font-size: large; text-align: center; margin-bottom: 10px;'>
									Solo deberas registrar la información de la ONU en la sección de Servicios</td>";
								}

								//Para agregar la informacion del como dato
								$datos_internet_btn_modi = "SELECT id FROM conf_internet WHERE  estatus = 'PROCESO' AND pasos = 'Reporte_modificacion' AND id_cliente = '$registro[2]'";
								$result = mysqli_query($conexion, $datos_internet_btn_modi);

								if (mysqli_num_rows($result) > 0) {
									echo "<td style='color: red; font-size: large; text-align: center; margin-bottom: 10px;'>
									Deberas ingresar la información del COMODATO en la seccion de Servicios </td>";
								}

								//ATENDER EL REPORTE DE SERVICIO 
								$datos_internet = "SELECT id FROM conf_internet WHERE  estatus = 'PROCESO' AND pasos = 'Cierre_reporte' AND id_cliente = '$registro[2]'";
								$result = mysqli_query($conexion, $datos_internet);

								if (mysqli_num_rows($result) > 0) {

									echo "<td style='color: red; font-size: large; text-align: center; margin-bottom: 10px;'>
									Completa la demas información antes de cerrar el reporte de servicio
									</td>";
								}
							}
							?>
    						<!-- <td style="color: red; font-size: large; text-align: center; margin-bottom: 10px;">
    							Solo deberas registrar la información de la ONU en la sección de Servicios
    						</td> -->
    						<!-- <td style="color: red; font-size: large; text-align: center; margin-bottom: 10px;">
    							Deberas ingresar la información del COMODATO antes de cerrar el reporte de servicio
    						</td> -->
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
    										<table style="color:#000000" cellpadding="5">
    											<tr>
    												<td>Folio:</td>
    												<td><input style="width:200px;font-size:12px;" type="text" value="<?php echo $registro[3]; ?>" readonly="readonly" />
    												</td>
    												<td>Fecha de Reporte:</td>
    												<td><input name="fecha" style="width:200px;font-size:12px;" type="text" maxlength="255" value="<?php echo $registro[4]; ?>" readonly="readonly" /></td>
    											</tr>

    											<tr>
    												<td>Responsable:</td>
    												<td>
    													<input name="empleado" id="autorizox" readonly="readonly" style="width:110px;font-size:12px;" type="text" maxlength="12" value="<?php echo $_SESSION['tuvision_id_empleado']; ?>" />
    												</td>
    											</tr>

    											<tr>
    												<td>Cliente:</td>
    												<td>
    													<div id="clientes">
    														<input name="id_cliente" id="id_cliente" readonly="readonly" style="width:110px;font-size:12px;" type="text" maxlength="12" value="<?php echo $registro[2]; ?>" />&nbsp;<img style="cursor:pointer;position:relative; top:4px;" onclick="contenedor_cliente='id_cliente';parametro_sucursal_cliente='<?php echo $_SESSION['tuvision_id_sucursal']; ?>';createWindow('Buscar Cliente',450,310 ,1,false,true);" src="imagenes/popup.png" />
    													</div>
    												</td>
    											</tr>

    											<tr>
    												<td>Fecha de Atencion:</td>
    												<td>
    													<input name="fecha_atencion" id="fecha_atecion" style="width:90px;font-size:12px; background-image:url(calendario/imgs/icon_minicalendar.gif); background-position:right center; background-repeat:no-repeat;" type="text" maxlength="10" readonly="readonly" onfocus="calendario(this.id);" value="<?php echo $registro[6]; ?>" />
    												</td>
    											</tr>

    											<tr>
    												<td>Descripci&oacute;n de Servicio:</td>
    												<td><textarea name="descripcion_falla" cols="50" readonly><?php echo $registro[13]; ?></textarea></td>
    											</tr>

    											<tr>
    												<td>Descripci&oacute;n de Atencion:</td>
    												<td><textarea name="descripcion_atencion" cols="50"><?php echo $registro[7]; ?></textarea></td>
    											</tr>

    											<tr>
    												<td>Importe Imputable:</td>
    												<td><input name="importe_imputable" style="width:200px;font-size:12px;" type="text" maxlength="255" value="<?php echo $registro[8]; ?>" onkeyup="solo_numeros_decimales(this);" onblur="solo_numeros_decimales(this)" /></td>
    											</tr>


    											<tr>
    												<td height="51">Numero de Nota (Imputable):</td>
    												<td><input type="text" name="nota_imputable" cols="50" value="<?php echo $registro[9]; ?>" style="width:70px;font-size:12px;" onblur="solo_numeros(this)" onkeyup="solo_numeros(this)"></td>
    											</tr>
    											<tr>
    												<td>Tipo de Atencion:</td>
    												<td>
    													<div id="t_atencion">
    														<select name="t_atencion" style="width:300px; font-size:12px;">
    															<option value="null">Seleccione un tipo de atencion</option>
    															<?php
																$query = "select id_tipo_atencion,descripcion from cat_tipo_atencion";
																$result = mysqli_query($conexion, $query);
																while (list($id, $nombre) = mysqli_fetch_array($result)) {
																	if ($id == $registro[5])
																		echo "<option value='$id' selected>$nombre</option>";
																	else
																		echo "<option value='$id'>$nombre</option>";
																}
																?>
    														</select>
    													</div>
    												</td>
    											</tr>
    											<tr>
    												<td colspan="4">
    													<div id="taps">
    														<?php
															$query = "select 
									(select id_tap from tap where id_tap=c.id_tap),
									(select valor from tap where id_tap=c.id_tap),
									(select salidas from tap where id_tap=c.id_tap)
									from clientes c where id_cliente='" . $registro[2] . "'";
															$result = mysqli_query($conexion, $query);
															list($id, $valor, $salidas) = mysqli_fetch_array($result);

															$select = "select id_tap, valor, salidas from tap where id_sucursal = (select id_sucursal from clientes where id_cliente='" . $registro[2] . "')";
															$ext = mysqli_query($conexion, $select);

															?>

    														<table border="0" cellpadding="0" cellspacing="0">
    															<tr>
    																<td>Id Tap:</td>
    																<td>
    																	<?php
																		echo "<select name='id_tap' onchange=\"cambios(this.value)\">";
																		while (list($taps, $val, $sal) = mysqli_fetch_array($ext)) {
																			if ($taps == $id)
																				echo "<option value='$taps $val $sal' selected >$taps</option>";
																			else
																				echo "<option value='$taps $val $sal'>$taps</option>";
																		}
																		echo "</select>";
																		?>

    																<td width="30"></td>


    																<td>Valor:</td>
    																<td><input type="text" name="valor" value="<?php echo $valor; ?>" readonly="readonly" /></td>
    																<td width="30"></td>
    																<td>Salida:</td>
    																<td><input type="text" name="salida" value="<?php echo $salidas; ?>" readonly="readonly" /></td>

    															</tr>
    														</table>

    													</div>
    												</td>
    											</tr>
    											<input type="hidden" name="tap" />


    											<tr>
    												<td>Tipo de servicio:</td>
    												<td>
    													<select name="tipo_servicio" id="t_serv" style="width:300px; font-size:12px;" onchange="_Ajax('servicio',this.value);crea_nota();">

    														<?php
															$query_t_u = "select * from cat_peticion_servicio order by id_peticion asc";
															$tabla_t_u = mysqli_query($conexion, $query_t_u);
															while ($registro_t_u = mysqli_fetch_array($tabla_t_u)) {
																if ($registro[10] == $registro_t_u[0])
																	echo "<option value=\"$registro_t_u[0]\" selected>$registro_t_u[1]</option>";
															}
															?>
    													</select>
    												</td>
    											</tr>

    											<tr>
    												<td>N&uacute;mero de nota:</td>
    												<td>
    													<div id="nota">
    														<?php

															if ($registro[10] == 1) {
																$query = "select id_ingreso,folio_nota from ingresos where id_cliente='" . $registro[2] . "'";

																echo "<select name='folio' style='width:300px; font-size:12px;' onchange=\"_Ajax('servicio','nota',this.value);\">";



																$result = mysqli_query($conexion, $query);
																while (list($id, $nombre) = mysqli_fetch_array($result)) {
																	if ($id == $registro[11])
																		echo "<option value='$id' selected>$nombre</option>";
																}
																echo "</select>";
															} else {
																echo "Seleccione \"nota\" en tipo de servicio y un cliente";
															}
															?>
    													</div>

    												</td>
    											</tr>


    										</table>
    										<input name="accion" type="hidden" value="editar" />
    									</td>
    								</tr>
    								<tr>
    									<td height="3px" class="separador"></td>
    								</tr>
    							</table>
    						</td>
    					</tr>

    				</table>

    				<table width="100%">
    					<tr>
    						<td>
    							<table class="datagrid" width="100%" border="0" cellspacing="0">
    								<tr>
    									<td height="3px" class="separador"></td>
    								</tr>
    								<tr class="tabla_columns">
    									<td>SERVICIOS</td>
    								</tr>
    								<tr>
    									<td>
    										<table border='0' cellspacing='0' cellsppadding='0'>
    											<tr>
    												<td>
    													<div id="servicio">
    														<?php
															if ($registro[10] == 1) {
																$query = "select id_tipo_servicio,descripcion from cat_tipo_servicios where id_tipo_servicio in (select id_tipo_servicio from rel_tipo_ingreso_servicio where id_tipo_ingreso in (select id_tipo_ingreso from montos where id_ingreso='$registro[11]'))";
																echo "<table border='0' cellspacing='0' cellsppadding=0><tr><td>";

																echo "<table id='services' width='100%' border='0' cellspacing='0'>";

																$result = mysqli_query($conexion, $query);
																if (mysqli_num_rows($result))
																	while (list($id, $nombre) = mysqli_fetch_array($result)) {
																		echo "<tr><td>";
																		echo "<select name='servicio[]' id='serviciox' style='width:300px; font-size:12px;'>";
																		echo "<option value='$id'>$nombre</option>";
																		echo "</select>";
																		echo "</td>";
																		echo "<td><img src=''></td>";
																		echo "</tr>";
																	}
																else {
																	echo "<tr><td>No asignado</td></tr>";
																}

																echo "</table></td></tr>";

																echo "</table>";
															} else {

																$conta = 0;

																$query = "select id_tipo_servicio,descripcion from cat_tipo_servicios where id_peticion='$registro[10]'";
																echo "<table border='0' cellspacing='0' cellsppadding=0><tr><td>";

																echo "<table id='services' width='100%' border='0' cellspacing='0'>";

																foreach ($lista as $valores) {
																	$conta++;
																	echo "<tr id='dinamicon_$conta'><td>";

																	echo "<select name='servicio[]' style='width:300px; font-size:12px;'>";


																	$result = mysqli_query($conexion, $query);
																	while (list($id, $nombre) = mysqli_fetch_array($result)) {
																		if ($id == $valores)
																			echo "<option value='$id' selected>$nombre</option>";
																	}
																	echo "</select>";


																	echo "</tr>";
																}
																echo "</table></td></tr>";

																echo "</table>";
															}
															?>
    														<table id='services' width='100%' border='0' cellspacing='0'>
    														</table>

    														<!--pasos para la configuracion del internet-->

    														<?php

															// $servicio = "SELECT id_tipo_servicio from cat_tipo_servicios where id_tipo_servicio in (select id_tipo_servicio from rel_tipo_ingreso_servicio where id_tipo_ingreso in (select id_tipo_ingreso from montos where id_ingreso='$registro[11]'))";
															// $result_servicio = devolverValorQuery($servicio);

															$banderaInternet = 0;
															$banderaNoInternet = 0;

															$servicio = "SELECT id_tipo_servicio from cat_tipo_servicios where id_tipo_servicio in (select id_tipo_servicio from rel_tipo_ingreso_servicio where id_tipo_ingreso in (select id_tipo_ingreso from montos where id_ingreso='$registro[11]'))";
															$result_servicio = mysqli_query($conexion, $servicio);
															while ($result = mysqli_fetch_array($result_servicio)) {

																$id_tipo_servicio = $result['id_tipo_servicio'];

																if ($id_tipo_servicio == 34 || $id_tipo_servicio == 33 || $id_tipo_servicio == 45 || $id_tipo_servicio == 46 || $id_tipo_servicio == 53) {
																	$banderaInternet = 1;
																} else {
																	$banderaNoInternet = 1;
																}
															}

															//combinaciones
															//banderaInternet = 1 y banderaNoInternet = 0 tiene solo un servicio de internet
															//banderaInternet = 1 y banderaNoInternet = 1 tiene un servicio de internet con algo mas
															//banderaInternet = 0 y banderaNoInternet = 1 tiene un servicio que no es de internet
															//banderaInternet = 0 y banderaNoInternet = 0 no tiene ningun servicio

															// if ($result_servicio[0] == 34 || $result_servicio[0] == 33 || $result_servicio[0] == 45 || $result_servicio[0] == 46 || $result_servicio[0] == 53) {
															if ($banderaInternet == 1 && $banderaNoInternet == 0 || $banderaInternet == 1 && $banderaNoInternet == 1) {
																$datos_internet = "SELECT no_caja, no_pon, no_olt, id_cliente, id  FROM conf_internet WHERE  estatus = 'PROCESO' AND pasos = 'Alta_ingreso' AND id_cliente = '$registro[2]'";
																$result = mysqli_query($conexion, $datos_internet);

																if (mysqli_num_rows($result) > 0) {

																	while ($resultado_datos = mysqli_fetch_array($result)) {

																		echo "<table id='confInternet' style='color:#000000' cellpadding='5'>";

																		echo "<tr>";

																		echo "<td style='font-size:10px;'>No. OLT:</td>";
																		echo "<td style='font-size:10px;'><input name='no_olt' type='text'  value='" . $resultado_datos['no_olt'] . "'></td>";

																		echo "<td style='font-size:10px;'>No. Caja:</td>";
																		echo "<td style='font-size:10px;'><input name='no_caja' type='text' value='" . $resultado_datos['no_caja'] . "' ></td>";

																		echo "<td style='font-size:10px;'>No. PON:</td>";
																		echo "<td style='font-size:10px;'><input name='no_pon' type='text' value='" . $resultado_datos['no_pon'] . "'></td>";

																		echo "<td style='font-size:10px;'><input name='id_cliente_confInternet' type='hidden'  value='" . $resultado_datos['id_cliente'] . "'></td>";

																		echo "<td style='font-size:10px;'><input name='id_confInternet' type='hidden'  value='" . $resultado_datos['id'] . "'></td>";

																		echo "<td style='font-size:10px;'><input name='banderaConf' type='hidden'   value='0'></td>";



																		echo "</tr>";

																		//mensaje

																		echo "<tr>";
																		echo "<td colspan='10' style='font-size:10px; padding:10px; font-weight:bold; color: red'>INGRESA LA SIGUIENTE INFORMACIÓN DE LA ONU:</td>";
																		echo "</tr>";



																		//datos de la onu

																		echo "<tr>";

																		echo "<td style='font-size:10px;'>Marca ONU:</td>";
																		echo "<td style='font-size:10px;'><input name='marca_onu' type='text' ></td>";

																		echo "<td style='font-size:10px;'>Modelo de la ONU:</td>";
																		echo "<td style='font-size:10px;'><input name='modelo_onu' type='text' ></td>";

																		echo "<td style='font-size:10px;'>Serie ONU:</td>";
																		echo "<td style='font-size:10px;'><input name='serie' type='text' ></td>";

																		echo "<td style='font-size:10px;'>Mac Adress de la caja:</td>";
																		echo "<td style='font-size:10px;'><input name='mac_address' type='text' ></td>";

																		echo "<td style='font-size:10px;'>Encapsulamiento:</td>";
																		echo " <td style='font-size:10px;'>
																				<select name='encapsulamiento' style='width:170px;font-size:12px;'>
																				<option value='null'>Elige una opción</option>
																				<option value='DHCP'>DHCP</option>
																				<option value='PPOE'>PPOE</option>
																				</select>
																			</td>";

																		echo "</tr>";

																		echo "<tr>";

																		// echo "<td style='font-size:10px;'>Registro en WINBOX:</td>";
																		// echo "<td style='font-size:10px;'>
																		// 		<select name='registro_winbox' style='width:170px;font-size:12px;'>
																		// 		<option value='null'>Elige una opción</option>
																		// 		<option value='SI'>SI</option>
																		// 		<option value='NO'>NO</option>
																		// 		</select>
																		// 	</td>";

																		// echo "<td style='font-size:10px;'>MAC DE WINBOX:</td>";
																		// echo "<td style='font-size:10px;'><input name='mac_winbox' type='text' ></td>";

																		// echo "<td style='font-size:10px;'>Plan de Datos:</td>";
																		// echo "<td style='font-size:10px;'>
																		// 		<select name='plan_datos' style='width:170px;font-size:12px;'>
																		// 		<option value='null'>Elige una opción</option>
																		// 		<option value='SI'>SI</option>
																		// 		<option value='NO'>NO</option>
																		// 		</select>
																		// 	</td>";

																		echo "<td style='font-size:10px;'>VLAN:</td>";
																		echo "<td style='font-size:10px;'><input name='vlan' type='text' ></td>";

																		// echo "<td style='font-size:10px;'>Resguardo:</td>";
																		// echo "<td style='font-size:10px;'>
																		// 		<select name='resguardo' style='width:170px;font-size:12px;'>
																		// 		<option value='null'>Elige una opción</option>
																		// 		<option value='SI'>SI</option>
																		// 		<option value='NO'>NO</option>
																		// 		</select>
																		// 	</td>";

																		echo "</tr>";



																		// echo "<tr>";

																		// echo "<td colspan='10' ><button onclick='guardarConfInternet()' style='background-color:#88DC65; width: 150px'>Guardar Información</button></td>";

																		// echo "</tr>";

																		echo "</table>";
																	}
																}


																//consulta para agregar el cierre del reporte

																$datos_internet = "SELECT id,id_cliente,no_olt,no_caja,no_pon,marca_onu,modelo,serie,mac_address,encapsulamiento,vlan FROM conf_internet WHERE  estatus = 'PROCESO' AND pasos = 'Reporte_modificacion' AND id_cliente = '$registro[2]'";
																$result = mysqli_query($conexion, $datos_internet);

																if (mysqli_num_rows($result) > 0) {
																	while ($resultado_datos = mysqli_fetch_array($result)) {

																		echo "<table id='confInternet' style='color:#000000' cellpadding='5'>";

																		echo "<tr>";

																		echo "<td style='font-size:10px;'>No. OLT:</td>";
																		echo "<td style='font-size:10px;'><input name='no_olt' type='text'  value='" . $resultado_datos['no_olt'] . "'></td>";

																		echo "<td style='font-size:10px;'>No. Caja:</td>";
																		echo "<td style='font-size:10px;'><input name='no_caja' type='text' value='" . $resultado_datos['no_caja'] . "' ></td>";

																		echo "<td style='font-size:10px;'>No. PON:</td>";
																		echo "<td style='font-size:10px;'><input name='no_pon' type='text' value='" . $resultado_datos['no_pon'] . "'></td>";

																		echo "<td style='font-size:10px;'><input name='id_cliente_confInternet' type='hidden'  value='" . $resultado_datos['id_cliente'] . "'></td>";

																		echo "<td style='font-size:10px;'><input name='id_confInternet' type='hidden'  value='" . $resultado_datos['id'] . "'></td>";
																		echo "<td style='font-size:10px;'><input name='banderaConf' type='hidden'   value='0'></td>";



																		echo "</tr>";

																		//datos de la onu

																		echo "<tr>";

																		echo "<td style='font-size:10px;'>Marca ONU:</td>";
																		echo "<td style='font-size:10px;'><input name='marca_onu' type='text' value='" . $resultado_datos['marca_onu'] . "' ></td>";

																		echo "<td style='font-size:10px;'>Modelo de la ONU:</td>";
																		echo "<td style='font-size:10px;'><input name='modelo_onu' type='text' value='" . $resultado_datos['modelo'] . "'></td>";

																		echo "<td style='font-size:10px;'>Serie ONU:</td>";
																		echo "<td style='font-size:10px;'><input name='serie' type='text' value='" . $resultado_datos['serie'] . "' ></td>";

																		echo "<td style='font-size:10px;'>Mac Adress de la caja:</td>";
																		echo "<td style='font-size:10px;'><input name='mac_address' type='text' value='" . $resultado_datos['mac_address'] . "'></td>";

																		echo "<td style='font-size:10px;'>Encapsulamiento:</td>";
																		echo "<td style='font-size:10px;'>
																				<select name='encapsulamiento' style='width:170px;font-size:12px;'>
																				<option value='null'>Elige una opción</option>
																				<option value='DHCP'" . ($resultado_datos['encapsulamiento'] == 'DHCP' ? ' selected' : '') . ">DHCP</option>
						   														<option value='PPOE'" . ($resultado_datos['encapsulamiento'] == 'PPOE' ? ' selected' : '') . ">PPOE</option>
																				</select>
																			</td>";

																		echo "</tr>";


																		echo "<tr>";
																		echo "<td style='font-size:10px;'>VLAN:</td>";
																		echo "<td style='font-size:10px;'><input name='vlan' type='text' value='" . $resultado_datos['vlan'] . "'></td>";
																		echo "</tr>";

																		//mensaje

																		echo "<tr>";
																		echo "<td colspan='10' style='font-size:10px; padding:10px; font-weight:bold; color: red'>INGRESA LA SIGUIENTE INFORMACIÓN ANTES DE CERRAR EL REPORTE DE SERVICIO:</td>";
																		echo "</tr>";



																		echo "<tr>";

																		echo "<td style='font-size:10px;'>Registro en WINBOX:</td>";
																		echo "<td style='font-size:10px;'>
																				<select name='registro_winbox' style='width:170px;font-size:12px;'>
																				<option value='null'>Elige una opción</option>
																				<option value='SI'>SI</option>
																				<option value='NO'>NO</option>
																				</select>
																			</td>";

																		echo "<td style='font-size:10px;'>MAC DE WINBOX:</td>";
																		echo "<td style='font-size:10px;'><input name='mac_winbox' type='text' ></td>";

																		echo "<td style='font-size:10px;'>Plan de Datos:</td>";
																		echo "<td style='font-size:10px;'>
																				<select name='plan_datos' style='width:170px;font-size:12px;'>
																				<option value='null'>Elige una opción</option>
																				<option value='SI'>SI</option>
																				<option value='NO'>NO</option>
																				</select>
																			</td>";

																		echo "<td style='font-size:10px;'>Resguardo:</td>";
																		echo "<td style='font-size:10px;'>
																				<select name='resguardo' style='width:170px;font-size:12px;'>
																				<option value='null'>Elige una opción</option>
																				<option value='SI'>SI</option>
																				<option value='NO'>NO</option>
																				</select>
																			</td>";

																		// echo "<td style='font-size:10px;'>Registro en WINBOX:</td>";
																		// echo "<td style='font-size:10px;'>
																		// 		<select name='registro_winbox' style='width:170px;font-size:12px;'>
																		// 		<option value='null'>Elige una opción</option>
																		// 		<option value='SI'" . ($resultado_datos['winbox'] == 'SI' ? ' selected' : '') . ">SI</option>
																		// 		<option value='NO'" . ($resultado_datos['winbox'] == 'NO' ? ' selected' : '') . ">NO</option>
																		// 		</select>
																		// 	</td>";

																		// echo "<td style='font-size:10px;'>MAC DE WINBOX:</td>";
																		// echo "<td style='font-size:10px;'><input name='mac_winbox' type='text' value='" . $resultado_datos['mac_winbox'] . "' ></td>";

																		// echo "<td style='font-size:10px;'>Plan de Datos:</td>";
																		// echo "<td style='font-size:10px;'>
																		// 		<select name='plan_datos' style='width:170px;font-size:12px;'>
																		// 		<option value='null'>Elige una opción</option>
																		// 		<option value='SI'" . ($resultado_datos['plan_datos'] == 'SI' ? ' selected' : '') . ">SI</option>
																		// 		<option value='NO'" . ($resultado_datos['plan_datos'] == 'NO' ? ' selected' : '') . ">NO</option>
																		// 		</select>
																		// 	</td>";



																		// echo "<td style='font-size:10px;'>Resguardo:</td>";
																		// echo "<td style='font-size:10px;'>
																		// 		<select name='resguardo' style='width:170px;font-size:12px;'>
																		// 		<option value='null'>Elige una opción</option>
																		// 		<option value='SI'" . ($resultado_datos['resguardo'] == 'SI' ? ' selected' : '') . ">SI</option>
																		// 		<option value='NO'" . ($resultado_datos['resguardo'] == 'NO' ? ' selected' : '') . ">NO</option>
																		// 		</select>
																		// 	</td>";

																		echo "</tr>";



																		//DATOS DE LA INSTALACION

																		echo "<tr>";

																		echo "<td style='font-size:10px;'># Salida en NAP:</td>";
																		echo "<td style='font-size:10px;'><input name='salida_nap' type='text' ></td>";

																		echo "<td style='font-size:10px;'>Potencia Salida Divisor:</td>";
																		echo "<td style='font-size:10px;'><input name='potencia_SDivisor' type='text' ></td>";

																		echo "<td style='font-size:10px;'>Potencia Llegada a Casa:</td>";
																		echo "<td style='font-size:10px;'><input name='potencia_llCasa' type='text' ></td>";

																		echo "<td style='font-size:10px;'>IP Asignada en Instalacion:</td>";
																		echo "<td style='font-size:10px;'><input name='ip_instalacion' type='text' ></td>";

																		//echo "<td colspan='10' ><button onclick='guardarConfInternet2()' style='background-color:#88DC65; width: 150px'>Guardar Información</button></td>";

																		echo "</tr>";

																		echo "</table>";
																	}
																}


																//consulta para mostrar la informacion de toda la configuracion de internet

																$datos_internet = "SELECT id,id_cliente,no_olt,no_caja,no_pon,marca_onu,modelo,serie,mac_address,encapsulamiento,winbox,mac_winbox,plan_datos,vlan,resguardo,salida_nap,potencia_salida_divisor,potencia_llegada_casa,ip_asignada_instalacion FROM conf_internet WHERE  estatus = 'PROCESO' AND pasos = 'Cierre_reporte' AND id_cliente = '$registro[2]'";
																$result = mysqli_query($conexion, $datos_internet);

																if (mysqli_num_rows($result) > 0) {
																	while ($resultado_datos = mysqli_fetch_array($result)) {

																		echo "<table id='confInternet' style='color:#000000' cellpadding='5'>";

																		echo "<tr>";

																		echo "<td style='font-size:10px;'>No. OLT:</td>";
																		echo "<td style='font-size:10px;'><input name='no_olt' type='text'  value='" . $resultado_datos['no_olt'] . "'></td>";

																		echo "<td style='font-size:10px;'>No. Caja:</td>";
																		echo "<td style='font-size:10px;'><input name='no_caja' type='text' value='" . $resultado_datos['no_caja'] . "' ></td>";

																		echo "<td style='font-size:10px;'>No. PON:</td>";
																		echo "<td style='font-size:10px;'><input name='no_pon' type='text' value='" . $resultado_datos['no_pon'] . "'></td>";

																		echo "<td style='font-size:10px;'><input name='id_cliente_confInternet' type='hidden'  value='" . $resultado_datos['id_cliente'] . "'></td>";

																		echo "<td style='font-size:10px;'><input name='id_confInternet' type='hidden'  value='" . $resultado_datos['id'] . "'></td>";
																		echo "<td style='font-size:10px;'><input name='banderaConf' type='hidden'  value='1'></td>";

																		echo "</tr>";

																		//datos de la onu

																		echo "<tr>";

																		echo "<td style='font-size:10px;'>Marca ONU:</td>";
																		echo "<td style='font-size:10px;'><input name='marca_onu' type='text' value='" . $resultado_datos['marca_onu'] . "' ></td>";

																		echo "<td style='font-size:10px;'>Modelo de la ONU:</td>";
																		echo "<td style='font-size:10px;'><input name='modelo_onu' type='text' value='" . $resultado_datos['modelo'] . "'></td>";

																		echo "<td style='font-size:10px;'>Serie ONU:</td>";
																		echo "<td style='font-size:10px;'><input name='serie' type='text' value='" . $resultado_datos['serie'] . "' ></td>";

																		echo "<td style='font-size:10px;'>Mac Adress de la caja:</td>";
																		echo "<td style='font-size:10px;'><input name='mac_address' type='text' value='" . $resultado_datos['mac_address'] . "'></td>";

																		echo "<td style='font-size:10px;'>Encapsulamiento:</td>";
																		echo "<td style='font-size:10px;'>
																				<select name='encapsulamiento' style='width:170px;font-size:12px;'>
																					<option value='null'>Elige una opción</option>
																					<option value='DHCP'" . ($resultado_datos['encapsulamiento'] == 'DHCP' ? ' selected' : '') . ">DHCP</option>
						   															<option value='PPOE'" . ($resultado_datos['encapsulamiento'] == 'PPOE' ? ' selected' : '') . ">PPOE</option>
																				</select>
																			</td>";

																		echo "</tr>";

																		echo "<tr>";

																		echo "<td style='font-size:10px;'>Registro en WINBOX:</td>";
																		echo "<td style='font-size:10px;'>
																				<select name='registro_winbox' style='width:170px;font-size:12px;'>
																				<option value='null'>Elige una opción</option>
																				<option value='SI'" . ($resultado_datos['winbox'] == 'SI' ? ' selected' : '') . ">SI</option>
																				<option value='NO'" . ($resultado_datos['winbox'] == 'NO' ? ' selected' : '') . ">NO</option>
																				</select>
																			</td>";

																		echo "<td style='font-size:10px;'>MAC DE WINBOX:</td>";
																		echo "<td style='font-size:10px;'><input name='mac_winbox' type='text' value='" . $resultado_datos['mac_winbox'] . "' ></td>";

																		echo "<td style='font-size:10px;'>Plan de Datos:</td>";
																		echo "<td style='font-size:10px;'>
																				<select name='plan_datos' style='width:170px;font-size:12px;'>
																																			<option value='null'>Elige una opción</option>
																				<option value='SI'" . ($resultado_datos['plan_datos'] == 'SI' ? ' selected' : '') . ">SI</option>
																				<option value='NO'" . ($resultado_datos['plan_datos'] == 'NO' ? ' selected' : '') . ">NO</option>
																				</select>
																			</td>";

																		echo "<td style='font-size:10px;'>VLAN:</td>";
																		echo "<td style='font-size:10px;'><input name='vlan' type='text' value='" . $resultado_datos['vlan'] . "'></td>";

																		echo "<td style='font-size:10px;'>Resguardo:</td>";
																		echo "<td style='font-size:10px;'>
																				<select name='resguardo' style='width:170px;font-size:12px;'>
																				<option value='null'>Elige una opción</option>
																				<option value='SI'" . ($resultado_datos['resguardo'] == 'SI' ? ' selected' : '') . ">SI</option>
																				<option value='NO'" . ($resultado_datos['resguardo'] == 'NO' ? ' selected' : '') . ">NO</option>
																				</select>
																			</td>";

																		echo "</tr>";

																		//mensaje

																		// echo "<tr>";
																		// echo "<td colspan='10' style='font-size:10px; padding:10px; font-weight:bold; color: red'>INGRESA LA SIGUIENTE INFORMACIÓN ANTES DE CERRAR EL REPORTE DE SERVICIO:</td>";
																		// echo "</tr>";

																		//DATOS DE LA INSTALACION

																		echo "<tr>";

																		echo "<td style='font-size:10px;'># Salida en NAP:</td>";
																		echo "<td style='font-size:10px;'><input name='salida_nap' type='text' value='" . $resultado_datos['salida_nap'] . "'></td>";

																		echo "<td style='font-size:10px;'>Potencia Salida Divisor:</td>";
																		echo "<td style='font-size:10px;'><input name='potencia_SDivisor' type='text' value='" . $resultado_datos['potencia_salida_divisor'] . "'></td>";

																		echo "<td style='font-size:10px;'>Potencia Llegada a Casa:</td>";
																		echo "<td style='font-size:10px;'><input name='potencia_llCasa' type='text' value='" . $resultado_datos['potencia_llegada_casa'] . "' ></td>";

																		echo "<td style='font-size:10px;'>IP Asignada en Instalacion:</td>";
																		echo "<td style='font-size:10px;'><input name='ip_instalacion' type='text' value='" . $resultado_datos['ip_asignada_instalacion'] . "' ></td>";

																		// echo "<td colspan='10' ><button onclick='guardarConfInternet2()' style='background-color:#88DC65; width: 150px'>Guardar Información</button></td>";

																		echo "</tr>";

																		echo "</table>";
																	}
																}
															} else {
																echo "<input name='banderaConf' type='hidden'   value='1'>";
															}

															?>


    													</div>

    												</td>
    											</tr>

    										</table>
    									</td>
    								</tr>
    								<tr>
    									<td height="3px" class="separador"></td>
    								</tr>
    							</table>
    						</td>
    					</tr>
    				</table>

    				<table border="0px" width="100%" style="color:#000000;font-size:12px">
    					<tr>
    						<td>
    							<table border="0px" width="100%" cellspacing="0" cellpadding="0" style="color:#000000;font-size:12px">
    								<tr>
    									<td height="10px"></td>
    								</tr>
    								<tr>
    									<td colspan="3">
    										<table class="datagrid" id="materiales" width="100%" border="0" cellspacing="0">
    											<tr>
    												<td colspan="6" height="3px" class="separador"></td>
    											</tr>
    											<tr class="tabla_columns">
    												<td colspan="2">Lista de Materiales en Buen Estado</td>
    												<td colspan="3">Lista de Materiales de Reemplazo</td>
    												<td></td>
    											</tr>
    											<tr>
    												<td>Nombre</td>
    												<td>Cantidad</td>
    												<td>Nombre</td>
    												<td>Cantidad</td>
    												<td>Comentario</td>
    												<td></td>
    											</tr>
    											<?php
												if (isset($_GET['id']))
													$id = $_GET['id'];

												if (isset($_POST['select'])) {
													$aux = array_keys($_POST['select']);
													$id = $aux[0];
												}
												$material = "select id_material,nom_bueno,cantidad_bueno,nom_reemplazo,cantidad_reemplazo,comentario from material where id_reporte='" . addslashes($id) . "'";
												$resultado = mysqli_query($conexion, $material);
												$row = mysqli_num_rows($resultado);

												$contador = 0;
												while (list($id, $bueno, $can_bueno, $reemplazo, $can_reemplazo, $comentario) = mysqli_fetch_array($resultado)) {
													echo "<tr id='" . (++$contador) . "'>";
													echo "<td><select name='nombre[]'>";
													echo "<option value='null'>Seleccione un material</option>";
													$query = "select id_equipo_inventario, descripcion from cat_equipos_inventario";
													$res = mysqli_query($conexion, $query);
													while (list($id, $des) = mysqli_fetch_array($res)) {
														if ($id == $bueno)
															echo "<option value='$id' selected>$des</option>";
														else
															echo "<option value='$id'>$des</option>";
													}
													echo "</option>";
													echo "</select>";
													echo "</td>";
													echo "<td><input type='text' name='cantidad[]' value='" . $can_bueno . "' style='width:50px;font-size:12px;'   onkeyup='solo_numeros(this);'  onblur='solo_numeros(this);'></td>";

													echo "<td><select name='nombre2[]'>";
													echo "<option value='null'>Seleccione un material</option>";
													$query = "select id_equipo_inventario, descripcion from cat_equipos_inventario";
													$res = mysqli_query($conexion, $query);
													while (list($id, $des) = mysqli_fetch_array($res)) {
														if ($id == $reemplazo)
															echo "<option value='$id' selected>$des</option>";
														else
															echo "<option value='$id'>$des</option>";
													}
													echo "</option>";
													echo "</select>";
													echo "</td>";


													echo "<td><input type='text' name='cantidad2[]' value='" . $can_reemplazo . "' style='width:50px;font-size:12px;'   onkeyup='solo_numeros(this);'  onblur='solo_numeros(this); size='5'></td>";
													echo "<td><input type='text' name='comentario[]' value='" . $comentario . "' style='width:50px;font-size:12px;'></td>";

													echo "<td><img src='imagenes/del.png' onclick=\"elimCamp2('$contador')\">";

													echo "<input type='hidden' name='ids[$id]' />
                            </td></tr>";
												}
												?>

    										</table>

    									</td>
    								</tr>
    								<tr>
    									<td colspan="6" height="3px" class="separador"></td>
    								</tr>
    								<tr>
    									<td><input type="button" value="Agregar nuevo material" onclick="crea_fila()" /></td>
    								</tr>


    							</table>
    						</td>
    					</tr>
    				</table>

    				<input type="hidden" name="estado" id="estado" />

    				<script language="javascript">
    					var count = 10000;
    					var bandera_numeros = true;


    					function validar_arreglos(id, tipo) {

    						var campo = document.getElementsByName(id);
    						var counter = 0;
    						if (campo) {
    							for (var i = 0; i < campo.length; i++) {
    								if (tipo == 1) {
    									if (campo[i][campo[i].selectedIndex].value == 'null') {
    										counter++;
    									}
    								} else if (tipo == 2) {
    									if (campo[i].value == '') {
    										counter++;
    									}
    								}
    							}


    							if (counter == 0)
    								return false;
    							else if (counter != 0)
    								return true;

    						} else {
    							return false;
    						}
    					}

    					function atender() {

    						var banderaConf = document.formulario.banderaConf.value;

    						if (banderaConf == 1) {

    							var cadena = "";

    							if (document.formulario.id_cliente)
    								if (document.formulario.id_cliente.value == '') {
    									cadena += "\n Debe de elegir un cliente";
    								}

    							if (document.formulario.empleado)
    								if (document.formulario.empleado.value == '') {
    									cadena += "\n Debe de elegir un empleado";
    								}

    							if (document.formulario.ingreso)
    								if (document.formulario.ingreso.value == 'null') {
    									cadena += "\n Debe de elegir un folio";
    								}

    							if (document.formulario.fecha_atencion.value == '') {
    								cadena += "\n Debe de ingresar una fecha de atencion";
    							}

    							if (document.formulario.descripcion_atencion.value == '') {
    								cadena += "\n Debe de ingresar la descripcion de la atencion";
    							}

    							/*if(document.formulario.importe_imputable.value==''){
    								cadena +="\n Debe de ingresar el importe imputable";
    							}
    							
    							if(document.formulario.nota_imputable.value==''){
    								cadena +="\n Debe de ingresar la nota imputable";
    							}*/

    							if (document.formulario.t_atencion)
    								if (document.formulario.t_atencion.value == 'null') {
    									cadena += "\n Debe de elegir el tipo de atencion";
    								}

    							if (validar_arreglos("servicio[]", 1)) {
    								cadena += "\n Debe de ingresar todos los servicios";
    							}

    							if (validar_arreglos("nombre[]", 1)) {
    								cadena += "\n Debe de ingresar todos los nombres de los materiales en buen estado";
    							}

    							if (validar_arreglos("cantidad[]", 2)) {
    								cadena += "\n Debe de ingresar todas las cantidades de los materiales en buen estado";
    							}

    							if (validar_arreglos("nombre2[]", 1)) {
    								cadena += "\n Debe de ingresar todos los nombres de los materiales de reemplazo";
    							}
    							if (validar_arreglos("cantidad2[]", 2)) {
    								cadena += "\n Debe de ingresar todas las cantidades de los materiales de reemplazo";
    							}
    							if (validar_arreglos("comentario[]", 2)) {
    								cadena += "\n Debe de ingresar todos los comentarios";
    							}

    							if (document.getElementById('t_serv')[document.getElementById('t_serv').selectedIndex].value == 1) {
    								if (document.formulario.folio.value != 'null') {
    									if (!document.getElementById('serviciox')) {
    										cadena += "\n Este folio no contiene servicio favor de elegir otra nota";
    									}
    								}
    							}

    							if (bandera_numeros == false && cadena == "") {
    								cadena += "\n Faltan campos por cargar por favor espere un momento";
    							}



    							if (cadena == "") {
    								document.getElementById('estado').value = "2";
    								document.formulario.submit();
    							} else
    								alert("Por favor verifique lo siguiente:" + cadena);

    						} else {

    							alert("Por favor ingrese la información de la configuración de internet antes de cerrar el reporte");

    						}

    					}

    					function save() {

    						var cadena = "";
    						document.getElementById('estado').value = '1';




    						if (document.formulario.id_cliente)
    							if (document.formulario.id_cliente.value == '') {
    								cadena += "\n Debe de elegir un cliente";
    							}

    						if (document.formulario.empleado)
    							if (document.formulario.empleado.value == '') {
    								cadena += "\n Debe de elegir un empleado";
    							}

    						if (document.formulario.ingreso)
    							if (document.formulario.ingreso.value == 'null') {
    								cadena += "\n Debe de elegir un folio";
    							}

    						if (document.formulario.fecha_atencion.value == '') {
    							cadena += "\n Debe de ingresar una fecha de atencion";
    						}

    						if (document.formulario.descripcion_atencion.value == '') {
    							cadena += "\n Debe de ingresar la descripcion de la atencion";
    						}

    						/*if(document.formulario.importe_imputable.value==''){
    							cadena +="\n Debe de ingresar el importe imputable";
    						}
    						
    						if(document.formulario.nota_imputable.value==''){
    							cadena +="\n Debe de ingresar la nota imputable";
    						}*/

    						if (document.formulario.t_atencion)
    							if (document.formulario.t_atencion.value == 'null') {
    								cadena += "\n Debe de elegir el tipo de atencion";
    							}

    						if (validar_arreglos("servicio[]", 1)) {
    							cadena += "\n Debe de ingresar todos los servicios";
    						}

    						if (validar_arreglos("nombre[]", 1)) {
    							cadena += "\n Debe de ingresar todos los nombres de los materiales en buen estado";
    						}

    						if (validar_arreglos("cantidad[]", 2)) {
    							cadena += "\n Debe de ingresar todas las cantidades de los materiales en buen estado";
    						}

    						if (validar_arreglos("nombre2[]", 1)) {
    							cadena += "\n Debe de ingresar todos los nombres de los materiales de reemplazo";
    						}
    						if (validar_arreglos("cantidad2[]", 2)) {
    							cadena += "\n Debe de ingresar todas las cantidades de los materiales de reemplazo";
    						}
    						if (validar_arreglos("comentario[]", 2)) {
    							cadena += "\n Debe de ingresar todos los comentarios";
    						}


    						if (document.getElementById('t_serv')[document.getElementById('t_serv').selectedIndex].value == 1) {

    							if (document.formulario.folio.value != 'null') {

    								if (!document.getElementById('serviciox')) {
    									cadena += "\n Este folio no contiene servicio favor de elegir otra nota";
    								}
    							}
    						}

    						if (bandera_numeros == false && cadena == "") {
    							cadena += "\n Faltan campos por cargar por favor espere un momento";
    						}



    						if (cadena == "") {

    							document.formulario.submit();
    						} else
    							alert("Por favor verifique lo siguiente:" + cadena);
    					}

    					function elimCamp2(nCampo) {

    						div_eliminar = document.getElementById(nCampo);

    						div_eliminar.parentNode.removeChild(div_eliminar);
    					}
    					evento = function(evt) { //esta funcion nos devuelve el tipo de evento disparado
    						return (!evt) ? event : evt;
    					}

    					elimCamp = function(evt) {
    						evt = evento(evt);
    						nCampo = rObj(evt);


    						div_eliminar = document.getElementById(nCampo.name);
    						div_eliminar.parentNode.removeChild(div_eliminar);
    					}
    					rObj = function(evt) {
    						return evt.srcElement ? evt.srcElement : evt.target;
    					}

    					function crea_fila() {

    						var tbody = document.createElement('tbody');
    						var fila = document.createElement('tr');
    						fila.id = 'dinamic_' + (++count);

    						var celda1 = document.createElement('td');
    						var celda2 = document.createElement('td');
    						var celda3 = document.createElement('td');
    						var celda4 = document.createElement('td');
    						var celda5 = document.createElement('td');
    						var celda6 = document.createElement('td');

    						var campox = document.createElement('div');
    						var campox2 = document.createElement('div');
    						var campo1 = document.createElement('select');
    						var campo2 = document.createElement('input');
    						var campo3 = document.createElement('select');
    						var campo4 = document.createElement('input');
    						var campo5 = document.createElement('input');
    						var campo6 = document.createElement('img');

    						campox.id = 'material' + count;
    						campox2.id = 'material2' + count;
    						campo1.name = "nombre[]";
    						campo2.name = "cantidad[]";
    						campo2.id = "cantidad_" + count;
    						campo3.name = "nombre2[]";
    						campo4.name = "cantidad2[]";
    						campo4.id = "cantidad2_" + count;
    						campo5.name = "comentario[]";

    						campo2.onblur = function() {
    							solo_numeros2(this.id);
    						}

    						campo2.onkeyup = function() {
    							solo_numeros2(this.id);
    						}

    						campo4.onblur = function() {
    							solo_numeros2(this.id);
    						}

    						campo4.onkeyup = function() {
    							solo_numeros2(this.id);
    						}

    						campo6.src = 'imagenes/del.png';

    						campo6.name = fila.id;
    						campo6.onclick = elimCamp;


    						campo2.style.fontSize = "12px";
    						campo2.style.width = "50px";
    						campo4.style.fontSize = "12px";
    						campo4.style.width = "50px";
    						campo5.style.fontSize = "12px";
    						campo5.style.width = "200px";

    						campox.appendChild(campo1);
    						campox2.appendChild(campo3);
    						celda1.appendChild(campox);
    						celda2.appendChild(campo2);
    						celda3.appendChild(campox2);
    						celda4.appendChild(campo4);
    						celda5.appendChild(campo5);
    						celda6.appendChild(campo6);

    						fila.appendChild(celda1);
    						fila.appendChild(celda2);
    						fila.appendChild(celda3);
    						fila.appendChild(celda4);
    						fila.appendChild(celda5);
    						fila.appendChild(celda6);

    						tbody.appendChild(fila);

    						document.getElementById('materiales').appendChild(fila);
    						_Ajax2('material', count);
    						_Ajax2('material2', count);

    					}

    					function solo_numeros(texto) {
    						var expresion = /[0-9]*/;
    						texto.value = texto.value.match(expresion);
    					}

    					function solo_numeros_decimales(texto) {
    						var expresion = /[0-9]*\.?[0-9]{0,2}/;
    						texto.value = texto.value.match(expresion);
    					}

    					function solo_numeros2(texto) {
    						var expresion = /[0-9]*/;
    						document.getElementById(texto).value = document.getElementById(texto).value.match(expresion);
    					}

    					function solo_numeros_decimales2(texto) {
    						var expresion = /[0-9]*\.?[0-9]{0,2}/;
    						document.getElementById(texto).value = document.getElementById(texto).value.match(expresion);
    					}
    				</script>



    			</form>


    		<?php
			} else {

				$query2 = "select 
			id_empleado,
			id_cliente,
			folio,
			fecha_reporte,
			(select descripcion from cat_tipo_atencion where id_tipo_atencion=rs.id_tipo_atencion),
			fecha_atencion,
			descripcion_falla,
			descripcion_atencion,
			importe_inputable,
			nota_inputable,
			id_peticion,
			id_ingreso,
			id_estatus_servicio,
			(select nombre from sucursales where id_sucursal = (select id_sucursal from empleados where id_empleado=rs.id_empleado))
			from reporte_servicios rs where id_reporte='" . addslashes($id) . "'";

				$resx = mysqli_query($conexion, $query2);
				list($emp, $cli, $folio, $f_rep, $falla, $atencion, $f_aten, $des_aten, $imp_inp, $nota_imp, $peticion, $ingreso, $servicio, $sucur) = mysqli_fetch_array($resx);
			?>


    			<table border="0px" width="100%" style="color:#000000;font-size:12px">
    				<tr>
    					<td align="right">
    						<table border="0" width="100%" cellpadding="0" cellspacing="0">
    							<tr>
    								<td width="5px" background="imagenes/module_left.png"></td>
    								<td width="70px" background="imagenes/module_center.png" height="80" valign="middle"><img src="imagenes/reportes_servicios.png" /></td>
    								<td align="left" background="imagenes/module_center.png" height="80" valign="middle" class="titulo"><b>&nbsp;&nbsp;REPORTE
    										<?php if ($registro[12] == 2)
												echo "ATENDIDO";
											else
												echo "CANCELADO";
											?>
    									</b></td>
    								<td align="right" background="imagenes/module_center.png" height="80">
    									<button class="boton2" onclick="location.href='index.php?menu=18'"><img src="imagenes/back.png" /><br />Regresar</button>
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
    									<table style="color:#000000" cellpadding="5">
    										<tr>
    											<td>Folio:</td>
    											<td><?php echo $folio; ?>
    											</td>
    											<td>Fecha de Reporte:</td>
    											<td><?php echo $f_rep; ?></td>
    										</tr>
    										<tr>
    											<td>Sucursal:</td>
    											<td>
    												<?php echo $sucur; ?>
    											</td>
    										</tr>

    										<tr>
    											<td>Responsable:</td>
    											<td>
    												<?php echo $emp; ?>
    											</td>
    										</tr>

    										<tr>
    											<td>Cliente:</td>
    											<td>
    												<?php echo $cli; ?>
    											</td>
    										</tr>

    										<tr>
    											<td>Fecha de Atencion:</td>
    											<td><?php echo $f_aten; ?></td>
    										</tr>

    										<tr>
    											<td>Descripci&oacute;n de Servicio:</td>
    											<td style="max-width:300px"><?php echo $falla; ?></td>
    										</tr>

    										<tr>
    											<td>Descripci&oacute;n de Atencion:</td>
    											<td><?php echo $des_aten; ?></td>
    										</tr>

    										<tr>
    											<td>Importe Imputable:</td>
    											<td><?php echo $imp_inp; ?></td>
    										</tr>

    										<tr>
    											<td height="51">Nota Imputable:</td>
    											<td><?php echo $nota_imp; ?></td>
    										</tr>
    										<tr>
    											<td>Tipo de Atencion:</td>
    											<td>
    												<?php echo $atencion; ?>

    											</td>
    										</tr>

    										<tr>
    											<td>Tipo de servicio:</td>
    											<td>
    												<?php echo $peticion; ?>
    											</td>
    										</tr>

    										<tr>
    											<td>N&uacute;mero de nota:</td>
    											<td>
    												<div id="nota">
    													<?php

														if ($ingreso != 'null') {
															$query = "select folio_nota from ingresos where id_ingreso='" . $ingreso . "'";

															$result = mysqli_query($conexion, $query);
															list($id) = mysqli_fetch_array($result);
															echo $id;
														} else {
															echo "Seleccione \"nota\" en tipo de servicio y un cliente";
														}
														?>
    												</div>

    											</td>
    										</tr>


    									</table>
    									<input name="accion" type="hidden" value="editar" />
    								</td>
    							</tr>
    							<tr>
    								<td height="3px" class="separador"></td>
    							</tr>
    						</table>
    					</td>
    				</tr>

    			</table>

    			<table width="100%">
    				<tr>
    					<td>
    						<table class="datagrid" width="100%" border="0" cellspacing="0">
    							<tr>
    								<td height="3px" class="separador"></td>
    							</tr>
    							<tr class="tabla_columns">
    								<td>SERVICIOS</td>
    							</tr>
    							<tr>
    								<td>
    									<table border='0' cellspacing='0' cellsppadding='0'>
    										<tr>
    											<td>

    												<?php

													if ($ingreso != 'null' && $ingreso != "") {
														$query = "select id_tipo_servicio,descripcion from cat_tipo_servicios where id_tipo_servicio in (select id_tipo_servicio from rel_tipo_ingreso_servicio where id_tipo_ingreso in (select id_tipo_ingreso from montos where id_ingreso='$ingreso'))";
														echo "<table border='0' cellspacing='0' cellsppadding=0><tr><td>";

														echo "<table id='services' width='100%' border='0' cellspacing='0'>";

														$result = mysqli_query($conexion, $query);
														if (mysqli_num_rows($result))
															while (list($id, $nombre) = mysqli_fetch_array($result)) {
																echo "<tr><td>";
																echo "$nombre";
																echo "</td></tr>";
															}
														else {
															echo "<tr><td>No asignado</td></tr>";
														}

														echo "</table></td></tr>";

														echo "</table>";
													} else {

														$conta = 0;


														echo "<table border='0' cellspacing='0' cellsppadding=0><tr><td>";

														echo "<table id='services' width='100%' border='0' cellspacing='0'>";

														foreach ($lista as $valores) {
															$conta++;
															echo "<tr id='dinamicon_$conta'><td>";
															$query = "select descripcion from cat_tipo_servicios where id_peticion='$peticion' and id_tipo_servicio='$valores'";

															$result = mysqli_query($conexion, $query);
															list($nombre) = mysqli_fetch_array($result);
															echo "$nombre";

															echo "</tr>";
														}
														echo "</table></td></tr>";
														echo "</table>";
													}
													?>
    												<table id='services' width='100%' border='0' cellspacing='0'>
    												</table>

    												<?php

													// $querycliente = "select id_cliente from reporte_servicios where id_reporte='" . addslashes($id) . "'";
													// $resultado = devolverValorQuery($querycliente);


													$datos_internet = "SELECT id,id_cliente,no_olt,no_caja,no_pon,marca_onu,modelo,serie,mac_address,encapsulamiento,winbox,mac_winbox,plan_datos,vlan,resguardo,salida_nap,potencia_salida_divisor,potencia_llegada_casa,ip_asignada_instalacion FROM conf_internet WHERE  estatus = 'ACTUAL' AND pasos = 'Finalizado' AND id_cliente = '$cli'";
													$result = mysqli_query($conexion, $datos_internet);

													if (mysqli_num_rows($result) > 0) {
														while ($resultado_datos = mysqli_fetch_array($result)) {

															echo "<table id='confInternet' style='color:#000000' cellpadding='5'>";

															echo "<tr>";

															echo "<td style='font-size:10px;'>No. OLT:</td>";
															echo "<td style='font-size:10px;'><input name='no_olt' type='text'  value='" . $resultado_datos['no_olt'] . "'></td>";

															echo "<td style='font-size:10px;'>No. Caja:</td>";
															echo "<td style='font-size:10px;'><input name='no_caja' type='text' value='" . $resultado_datos['no_caja'] . "' ></td>";

															echo "<td style='font-size:10px;'>No. PON:</td>";
															echo "<td style='font-size:10px;'><input name='no_pon' type='text' value='" . $resultado_datos['no_pon'] . "'></td>";

															echo "<td style='font-size:10px;'><input name='id_cliente_confInternet' type='hidden'  value='" . $resultado_datos['id_cliente'] . "'></td>";

															echo "<td style='font-size:10px;'><input name='id_confInternet' type='hidden'  value='" . $resultado_datos['id'] . "'></td>";
															echo "<td style='font-size:10px;'><input name='banderaConf' type='hidden'  value='1'></td>";

															echo "</tr>";

															//datos de la onu

															echo "<tr>";

															echo "<td style='font-size:10px;'>Marca ONU:</td>";
															echo "<td style='font-size:10px;'><input name='marca_onu' type='text' value='" . $resultado_datos['marca_onu'] . "' ></td>";

															echo "<td style='font-size:10px;'>Modelo de la ONU:</td>";
															echo "<td style='font-size:10px;'><input name='modelo_onu' type='text' value='" . $resultado_datos['modelo'] . "'></td>";

															echo "<td style='font-size:10px;'>Serie ONU:</td>";
															echo "<td style='font-size:10px;'><input name='serie' type='text' value='" . $resultado_datos['serie'] . "' ></td>";

															echo "<td style='font-size:10px;'>Mac Adress de la caja:</td>";
															echo "<td style='font-size:10px;'><input name='mac_address' type='text' value='" . $resultado_datos['mac_address'] . "'></td>";

															echo "<td style='font-size:10px;'>Encapsulamiento:</td>";
															echo "<td style='font-size:10px;'>
																	<select name='encapsulamiento' style='width:170px;font-size:12px;'>
																		<option value='null'>Elige una opción</option>
																		<option value='DHCP'" . ($resultado_datos['encapsulamiento'] == 'DHCP' ? ' selected' : '') . ">DHCP</option>
																		   <option value='PPOE'" . ($resultado_datos['encapsulamiento'] == 'PPOE' ? ' selected' : '') . ">PPOE</option>
																	</select>
																</td>";

															echo "</tr>";

															echo "<tr>";

															echo "<td style='font-size:10px;'>Registro en WINBOX:</td>";
															echo "<td style='font-size:10px;'>
																	<select name='registro_winbox' style='width:170px;font-size:12px;'>
																	<option value='null'>Elige una opción</option>
																	<option value='SI'" . ($resultado_datos['winbox'] == 'SI' ? ' selected' : '') . ">SI</option>
																	<option value='NO'" . ($resultado_datos['winbox'] == 'NO' ? ' selected' : '') . ">NO</option>
																	</select>
																</td>";

															echo "<td style='font-size:10px;'>MAC DE WINBOX:</td>";
															echo "<td style='font-size:10px;'><input name='mac_winbox' type='text' value='" . $resultado_datos['mac_winbox'] . "' ></td>";

															echo "<td style='font-size:10px;'>Plan de Datos:</td>";
															echo "<td style='font-size:10px;'>
																	<select name='plan_datos' style='width:170px;font-size:12px;'>
																	<option value='null'>Elige una opción</option>
																	<option value='SI'" . ($resultado_datos['plan_datos'] == 'SI' ? ' selected' : '') . ">SI</option>
																	<option value='NO'" . ($resultado_datos['plan_datos'] == 'NO' ? ' selected' : '') . ">NO</option>
																	</select>
																</td>";

															echo "<td style='font-size:10px;'>VLAN:</td>";
															echo "<td style='font-size:10px;'><input name='vlan' type='text' value='" . $resultado_datos['vlan'] . "'></td>";

															echo "<td style='font-size:10px;'>Resguardo:</td>";
															echo "<td style='font-size:10px;'>
																	<select name='resguardo' style='width:170px;font-size:12px;'>
																	<option value='null'>Elige una opción</option>
																	<option value='SI'" . ($resultado_datos['resguardo'] == 'SI' ? ' selected' : '') . ">SI</option>
																	<option value='NO'" . ($resultado_datos['resguardo'] == 'NO' ? ' selected' : '') . ">NO</option>
																	</select>
																</td>";

															echo "</tr>";

															//mensaje

															// echo "<tr>";
															// echo "<td colspan='10' style='font-size:10px; padding:10px; font-weight:bold; color: red'>INGRESA LA SIGUIENTE INFORMACIÓN ANTES DE CERRAR EL REPORTE DE SERVICIO:</td>";
															// echo "</tr>";

															//DATOS DE LA INSTALACION

															echo "<tr>";

															echo "<td style='font-size:10px;'># Salida en NAP:</td>";
															echo "<td style='font-size:10px;'><input name='salida_nap' type='text' value='" . $resultado_datos['salida_nap'] . "'></td>";

															echo "<td style='font-size:10px;'>Potencia Salida Divisor:</td>";
															echo "<td style='font-size:10px;'><input name='potencia_SDivisor' type='text' value='" . $resultado_datos['potencia_salida_divisor'] . "'></td>";

															echo "<td style='font-size:10px;'>Potencia Llegada a Casa:</td>";
															echo "<td style='font-size:10px;'><input name='potencia_llCasa' type='text' value='" . $resultado_datos['potencia_llegada_casa'] . "' ></td>";

															echo "<td style='font-size:10px;'>IP Asignada en Instalacion:</td>";
															echo "<td style='font-size:10px;'><input name='ip_instalacion' type='text' value='" . $resultado_datos['ip_asignada_instalacion'] . "' ></td>";

															// echo "<td colspan='10' ><button onclick='guardarConfInternet2()' style='background-color:#88DC65; width: 150px'>Guardar Información</button></td>";

															echo "</tr>";

															echo "</table>";
														}
													}

													?>



    											</td>
    										</tr>

    									</table>
    								</td>
    							</tr>
    							<tr>
    								<td height="3px" class="separador"></td>
    							</tr>
    						</table>
    					</td>
    				</tr>
    			</table>

    			<table border="0px" width="100%" style="color:#000000;font-size:12px">
    				<tr>
    					<td>
    						<table border="0px" width="100%" cellspacing="0" cellpadding="0" style="color:#000000;font-size:12px">
    							<tr>
    								<td height="10px"></td>
    							</tr>
    							<tr>
    								<td colspan="3">
    									<table class="datagrid" id="materiales" width="100%" border="0" cellspacing="0">
    										<tr>
    											<td colspan="6" height="3px" class="separador"></td>
    										</tr>
    										<tr class="tabla_columns">
    											<td colspan="2">Lista de Materiales en Buen Estado</td>
    											<td colspan="3">Lista de Materiales de Reemplazo</td>
    											<td></td>
    										</tr>
    										<tr>
    											<td>Nombre</td>
    											<td>Cantidad</td>
    											<td>Nombre</td>
    											<td>Cantidad</td>
    											<td>Comentario</td>
    											<td></td>
    										</tr>
    										<?php
											$id = addslashes($_GET['id']);
											$material = "select id_material,nom_bueno,cantidad_bueno,nom_reemplazo,cantidad_reemplazo,comentario from material where id_reporte='" . addslashes($id) . "'";
											$resultado = mysqli_query($conexion, $material);
											$row = mysqli_num_rows($resultado);

											$contador = 0;
											while (list($id, $bueno, $can_bueno, $reemplazo, $can_reemplazo, $comentario) = mysqli_fetch_array($resultado)) {
												echo "<tr id='" . (++$contador) . "'>";
												echo "<td>";
												$query = "select descripcion from cat_equipos_inventario where id_equipo_inventario='$bueno'";
												$res = mysqli_query($conexion, $query);
												list($des) = mysqli_fetch_array($res);
												echo "$des";
												echo "</td>";
												echo "<td>$can_bueno</td>";
												echo "<td>";
												$query2 = "select descripcion from cat_equipos_inventario where id_equipo_inventario='$reemplazo'";
												$res2 = mysqli_query($conexion, $query2);
												list($des2) = mysqli_fetch_array($res2);
												echo $des2;
												echo "</td>";
												echo "<td>$can_reemplazo</td>";
												echo "<td>$comentario</td>";
												echo "<input type='hidden' name='ids[$id]' />
                                    </td></tr>";
											}
											?>

    									</table>

    								</td>
    							</tr>
    							<tr>
    								<td colspan="6" height="3px" class="separador"></td>
    							</tr>
    							<tr>
    								<td></td>
    							</tr>


    						</table>
    					</td>
    				</tr>
    			</table>



    <?php
			}
		}
	}
	?>