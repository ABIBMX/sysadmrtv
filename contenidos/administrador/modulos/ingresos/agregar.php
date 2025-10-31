<style>
	#div_total {
		font-size: 18px;
		font-weight: bold;
		font-family: Arial, Helvetica, sans-serif;
		display: inline;
	}

	.monto {
		width: 100px;
		font-size: 12px;
		text-align: right;
	}

	.total {
		display: inline;
		font-weight: bold;
		font-size: 12px;
	}

	.del_concepto {
		display: inline-block;
		background: url(imagenes/del.png);
		width: 16px;
		height: 16px;
		cursor: pointer;
	}
</style>
<script language="javascript" type="text/javascript">
	// function guardar() {
	// 	var cadena = "";

	// 	if (document.formulario.id_cliente.value == '')
	// 		cadena += "\n* Debe elegir el id del cliente.";

	// 	//validar los conceptos bases 

	// 	// if (document.formulario.tipoServicio_0.value == 'null')
	// 	// 	cadena += "\n* Debe seleccionar el tipo de servicio.";


	// 	// if (document.formulario.Categorias_0.value == 'null')
	// 	// 	cadena += "\n* Debe seleccionar una categoria.";


	// 	// if (document.formulario.conceptoIngreso_0.value == 'null')
	// 	// 	cadena += "\n* Debe seleccionar una categoria.";


	// 	// if (document.formulario.montoIngreso_0.value == 'null')
	// 	// 	cadena += "\n* Debe contar con un monto.";

	// 	// if (document.formulario.subtotal_0.value == 'null')
	// 	// 	cadena += "\n* Debe contar con un subtotal.";

	// 	for (let i = 0; i <= contadorConceptosAdd; i++) {
	// 		// Verificar si el elemento existe (por si alguno fue eliminado)
	// 		if (document.getElementById("concepto_" + i)) {

	// 			let tipoServicio = document.formulario["tipoServicio_" + i]?.value;
	// 			let categoria = document.formulario["Categorias_" + i]?.value;
	// 			let concepto = document.formulario["conceptoIngreso_" + i]?.value;
	// 			let monto = document.formulario["montoIngreso_" + i]?.value;
	// 			let subtotal = document.formulario["subtotal_" + i]?.value;

	// 			if (tipoServicio === "null")
	// 				cadena += "\n* Debe seleccionar el tipo de servicio en el concepto " + (i + 1);

	// 			if (categoria === "null")
	// 				cadena += "\n* Debe seleccionar una categoría en el concepto " + (i + 1);

	// 			if (concepto === "null")
	// 				cadena += "\n* Debe seleccionar un concepto en el concepto " + (i + 1);

	// 			if (!monto || monto === "0.00")
	// 				cadena += "\n* Debe ingresar un monto en el concepto " + (i + 1);

	// 			if (!subtotal || subtotal === "0.00")
	// 				cadena += "\n* Debe ingresar un subtotal en el concepto " + (i + 1);
	// 		}
	// 	}

	// 	if (!bandera_total)
	// 		cadena += "\n* Por favor espere a que se calcule el total.";

	// 	if (document.formulario.total2.value == '0' || document.formulario.total2.value == '')
	// 		cadena += "\n* El total no puede ser 0.";

	// 	//validar si hay un pago parcial

	// 	if (document.getElementById('pago_parcial').checked) {

	// 		if (document.formulario.pago_final.value == '0' || document.formulario.pago_final.value == '')
	// 			cadena += "\n* El pago parcial final no puede ser 0.";
	// 	}

	// 	if (cadena == "") {
	// 		document.formulario.submit();
	// 	} else
	// 		alert("Por favor verifique lo siguiente:" + cadena);
	// }
	function guardar() {
		let cadena = "";

		// 🧩 BLOQUE DE DEPURACIÓN (solo para pruebas)
		let debugInfo = "=== DEPURACIÓN DE GUARDAR() ===\n";

		debugInfo += "\nID Cliente: " + document.formulario.id_cliente.value;

		// 🔍 Detectar dinámicamente todos los conceptos existentes
		let conceptos = document.querySelectorAll("[name^='tipoServicio_']");
		debugInfo += "\nConceptos detectados: " + conceptos.length;

		conceptos.forEach((el, index) => {
			let i = el.name.split("_")[1]; // obtiene el número después del guion bajo

			let tipoServicio = document.formulario["tipoServicio_" + i]?.value || "(vacío)";
			let categoria = document.formulario["Categorias_" + i]?.value || "(vacío)";
			let concepto = document.formulario["conceptoIngreso_" + i]?.value || "(vacío)";
			let monto = document.formulario["montoIngreso_" + i]?.value || "(vacío)";
			let promocion = document.formulario["promocion_" + i]?.value || "(vacío)";
			let subtotal = document.formulario["subtotal_" + i]?.value || "(vacío)";

			debugInfo += `\n\n--- Concepto ${index + 1} ---`;
			debugInfo += `\nTipo servicio: ${tipoServicio}`;
			debugInfo += `\nCategoría: ${categoria}`;
			debugInfo += `\nConcepto: ${concepto}`;
			debugInfo += `\nMonto: ${monto}`;
			debugInfo += `\nPromoción: ${promocion}`;
			debugInfo += `\nSubtotal: ${subtotal}`;
		});

		let chkPagoParcial = document.getElementById('pago_parcial');
		if (chkPagoParcial.checked == true) {
			debugInfo += "\n\nPago parcial activo: " + chkPagoParcial.checked;
			debugInfo += "\nMonto parcial: " + document.formulario.pago_final.value;
		}

		debugInfo += "\n\nTotal general (total2): " + document.getElementById("total2").value;
		debugInfo += "\nBandera total: " + (typeof bandera_total !== "undefined" ? bandera_total : "no definida");

		alert(debugInfo);
		// 🔹 FIN BLOQUE DE DEPURACIÓN


		// 🔻 VALIDACIONES REALES
		if (!document.formulario.id_cliente.value)
			cadena += "\n* Debe elegir el ID del cliente.";

		conceptos.forEach((el, index) => {
			let i = el.name.split("_")[1];

			let tipoServicio = document.formulario["tipoServicio_" + i]?.value;
			let categoria = document.formulario["Categorias_" + i]?.value;
			let concepto = document.formulario["conceptoIngreso_" + i]?.value;
			let monto = document.formulario["montoIngreso_" + i]?.value;
			let promocion = document.formulario["promocion_" + i]?.value;
			let subtotal = document.formulario["subtotal_" + i]?.value;

			if (!tipoServicio || tipoServicio === "null")
				cadena += `\n* Debe seleccionar el tipo de servicio en el concepto ${index + 1}.`;

			if (!categoria || categoria === "null")
				cadena += `\n* Debe seleccionar una categoría en el concepto ${index + 1}.`;

			if (!concepto || concepto === "null")
				cadena += `\n* Debe seleccionar un concepto en el concepto ${index + 1}.`;

			if (!monto || monto === "0.00")
				cadena += `\n* Debe ingresar un monto en el concepto ${index + 1}.`;

			if (!subtotal || subtotal === "0.00")
				cadena += `\n* Debe ingresar un subtotal en el concepto ${index + 1}.`;
		});

		if (typeof bandera_total === 'undefined' || !bandera_total)
			cadena += "\n* Por favor espere a que se calcule el total.";

		if (!document.formulario.total2.value || document.formulario.total2.value === '0')
			cadena += "\n* El total no puede ser 0.";

		if (chkPagoParcial && chkPagoParcial.checked) {
			let pagoFinal = parseFloat(document.formulario.pago_final.value) || 0;
			let totalGeneral = parseFloat(document.formulario.total2.value) || 0;

			if (pagoFinal <= 0)
				cadena += "\n* El pago parcial no puede ser 0 o vacío.";
			else if (pagoFinal > totalGeneral)
				cadena += "\n* El pago parcial no puede ser mayor al total general.";
		}

		if (cadena === "") {
			document.formulario.submit();
		} else {
			alert("⚠️ Por favor verifique lo siguiente:\n" + cadena);
		}
	}

	function solo_numeros(texto) {
		var expresion = /[0-9]*/;
		texto.value = texto.value.match(expresion);
	}

	function reestableceZero(texto) {
		if (texto.value == "")
			texto.value = "0.00";
	}

	function solo_numeros_decimales(texto) {
		var expresion = /[0-9]*\.?[0-9]{0,2}/;
		texto.value = texto.value.match(expresion);

	}

	bandera_total = false;

	//Se han agregado estas dos variables obligatorias 
	var contenedor_cliente = ""; //Se actualiza para saber en que input se coloca la llave del cliente
	var parametro_sucursal_cliente = ""; // Se utiliza en caso de que queramos la lista de clientes de una sucursal en especifica
	function cambio_id_cliente(id) {}

	function cargarPromocion(valor, div_promocion, id_total, id_monto, id_promocion, adicional) {
		//Bloqueamos para que no guarden
		bandera_total = false;

		var contenedor = document.getElementById(div_promocion);
		if (valor != "null") {
			contenedor.innerHTML = "<img src='imagenes/loading.gif' /> <span style='font-size:10px;'>Cargando Promociones...</span>";
			var cdata = "tipo_ingreso=" + valor + "&id_total=" + id_total + "&id_monto=" + id_monto + "&id_promocion=" + id_promocion + "&adicional=" + adicional;
			$.ajax({
				type: "POST",
				url: "ajaxProcess/ingreso_promociones.php",
				data: cdata,
				success: function(datos) {
					contenedor.innerHTML = datos;
					calcularTotal(id_total, id_monto, id_promocion);
				}
			});
		} else {
			contenedor.innerHTML = "No Asignado";
		}
	}

	function calcularTotal(id_total, id_monto, id_promocion) {
		$('#div_total').html("<img src='imagenes/loading.gif' /> <span style='font-size:10px;'>Calculando Total...</span>");

		//Bloqueamos para que no guarden
		bandera_total = false;

		//Hay que calcular el procentaje de descuento

		var monto = document.getElementById(id_monto);
		var total = document.getElementById(id_total);
		var promocion = document.getElementById(id_promocion);

		total.innerHTML = "<img src='imagenes/loading.gif' /> <span style='font-size:10px;'>Calculando Total...</span>";
		if (promocion == null) {
			total.innerHTML = monto.value;
			sumarTotales();
		} else {
			var cdata = "promocion=" + promocion.value;

			$.ajax({
				type: "POST",
				url: "ajaxProcess/ingreso_promociones.php",
				data: cdata,
				success: function(datos) {

					//var calculo = monto.value - ((monto.value * datos) / 100);
					var calculo = monto.value - datos;
					total.innerHTML = calculo;
					sumarTotales();
				}
			});
		}
	}
	var contadorConceptosAdd = 0;

	function agregarConceptoAdicional() {


		contadorConceptosAdd++;
		var contenedor = document.getElementById('div_contenedor_adicionales');

		var div_concepto = document.createElement('div');
		div_concepto.id = "div_concepto_adicional_" + contadorConceptosAdd;

		div_concepto.innerHTML = "<table style='color:#000000' border='0' cellpadding='5'><tr><td><div id='concepto_" + contadorConceptosAdd + "'><img src='imagenes/loading.gif' /> <span style='font-size:10px;'>Cargando conceptos...</span></div></td><td><input type='text' onchange=\"solo_numeros_decimales(this);calcularTotal('div_total_a_" + contadorConceptosAdd + "','monto_" + contadorConceptosAdd + "','promocion_" + contadorConceptosAdd + "');reestableceZero(this);\" onkeyup='solo_numeros_decimales(this)' value='0.00' class='monto' id='monto_" + contadorConceptosAdd + "' name='monto_a[]' maxlength='13'/></td><td width='200px'><div id='div_promocion_" + contadorConceptosAdd + "' ><select name='promociones[]' id='' style='width:200px;font-size:12px;'><option value='null'>No hay promociones</option></select></div></td><td width='30px' align='right'>$</td><td  align='right' width='200px'><div class='total' id='div_total_a_" + contadorConceptosAdd + "'>0.00</div></td><td><span class='del_concepto'></span></td></table>";

		var cdata = "concepto_add=1&div_promocion=div_promocion_" + contadorConceptosAdd + "&div_total=div_total_a_" + contadorConceptosAdd + "&div_monto=monto_" + contadorConceptosAdd + "&id_promocion=promocion_" + contadorConceptosAdd + "&adicional=1";

		contenedor.appendChild(div_concepto);
		var concepto_adicional = document.getElementById('concepto_' + contadorConceptosAdd);

		$.ajax({
			type: "POST",
			url: "ajaxProcess/ingreso_promociones.php",
			data: cdata,
			success: function(datos) {
				concepto_adicional.innerHTML = datos;
			}
		});



	}
	var total_sumado = 0;
	// var bandera_total = true;

	function sumarTotales() {
		total_sumado = 0;

		$('.total').each(function() {
			total_sumado += parseFloat($(this).text());

		});

		$('#div_total').text(total_sumado);

		bandera_total = true;
	}
	$(function() {
		$('.del_concepto').live('click', function() {
			$(this).parent().parent().parent().parent().parent().remove();
			sumarTotales();
		});

	});

	//===================== Esto es para la nueva version

	function clienteSelect() {

		bandera_cliente = false;
		var div_client = document.getElementById('telefono');
		var id_cliente = document.getElementById('id_cliente').value;
		if (id_cliente != '' || id_cliente != null) {

			clienteSelectTarifa(id_cliente);
			clienteSelectCurp(id_cliente);

			div_client.innerHTML = "<img src='imagenes/loading.gif' /> <span style='font-size:10px;'>Cargando Telefono...</span>";
			var cliente_telefono = "cliente_telefono=" + id_cliente;

			$.ajax({
				type: "POST",
				url: "ajaxProcess/ingreso_promociones.php",
				data: cliente_telefono,
				success: function(datos) {
					div_client.innerHTML = datos;
					bandera_cliente = true;
				}
			});
		} else {
			div_client.innerHTML = "Es necesario seleccionar un cliente";
		}
	}

	function clienteSelectTarifa(id_cliente) {

		bandera_tarifa = false;
		var div_tarifa = document.getElementById('tarifa');
		var id_cliente = id_cliente;
		if (id_cliente != '' || id_cliente != null) {

			div_tarifa.innerHTML = "<img src='imagenes/loading.gif' /> <span style='font-size:10px;'>Cargando Telefono...</span>";
			var cliente_tarifa = "cliente_tarifa=" + id_cliente;

			$.ajax({
				type: "POST",
				url: "ajaxProcess/ingreso_promociones.php",
				data: cliente_tarifa,
				success: function(datos) {
					div_tarifa.innerHTML = datos;
					bandera_tarifa = true;
				}
			});
		} else {
			div_tarifa.innerHTML = "Es necesario seleccionar un cliente";
		}
	}

	function clienteSelectCurp(id_cliente) {

		bandera_curp = false;
		var div_curp = document.getElementById('curp');
		var id_cliente = id_cliente;
		if (id_cliente != '' || id_cliente != null) {

			div_curp.innerHTML = "<img src='imagenes/loading.gif' /> <span style='font-size:10px;'>Cargando CURP...</span>";
			var cliente_curp = "cliente_curp=" + id_cliente;

			$.ajax({
				type: "POST",
				url: "ajaxProcess/ingreso_promociones.php",
				data: cliente_curp,
				success: function(datos) {
					div_curp.innerHTML = datos;
					bandera_curp = true;
				}
			});
		} else {
			div_curp.innerHTML = "Es necesario seleccionar un cliente";
		}
	}


	// function cargarcategoria(categoriaSelect) {

	// 	// alert(categoriaSelect);
	// 	bandera_categoria = false;
	// 	var div_categoria = document.getElementById('div_categoria');
	// 	var categoriaSelect = categoriaSelect;
	// 	if (categoriaSelect != '' || categoriaSelect != null) {

	// 		div_categoria.innerHTML = "<img src='imagenes/loading.gif' /> <span style='font-size:10px;'>Cargando Categorias...</span>";
	// 		var categoria_concepto = "categoria_concepto=" + categoriaSelect;

	// 		$.ajax({
	// 			type: "POST",
	// 			url: "ajaxProcess/ingreso_promociones.php",
	// 			data: categoria_concepto,
	// 			success: function(datos) {
	// 				div_categoria.innerHTML = datos;
	// 				bandera_categoria = true;
	// 			}
	// 		});
	// 	} else {
	// 		div_categoria.innerHTML = "Es necesario seleccionar una categoria";
	// 	}

	// }

	function cargarcategoria(categoriaSelect, idFila) {
		let div_categoria = document.getElementById('div_categoria_' + idFila);
		let id_cliente = document.getElementById('id_cliente').value;

		if (categoriaSelect != '' && categoriaSelect != null) {
			div_categoria.innerHTML = "<img src='imagenes/loading.gif' /> <span style='font-size:10px;'>Cargando Categorias...</span>";

			let categoria_concepto = "categoria_concepto=" + categoriaSelect + "&fila=" + idFila + "&cliente=" + id_cliente;

			$.ajax({
				type: "POST",
				url: "ajaxProcess/ingreso_promociones.php",
				data: categoria_concepto,
				success: function(datos) {
					div_categoria.innerHTML = datos;
				}
			});
		} else {
			div_categoria.innerHTML = "Es necesario seleccionar una categoria";
		}
	}


	// function cargarConcepto(categoria, servicio) {

	// 	// alert("Categoría: " + categoria + "\nServicio: " + servicio);


	// 	bandera_concepto = false;
	// 	var div_conceptos = document.getElementById('div_conceptos');
	// 	var concepto = concepto;
	// 	if (concepto != '' || concepto != null) {

	// 		div_conceptos.innerHTML = "<img src='imagenes/loading.gif' /> <span style='font-size:10px;'>Cargando Conceptos...</span>";
	// 		var categoriaServicio = "categoria=" + categoria + "&servicio=" + servicio;

	// 		$.ajax({
	// 			type: "POST",
	// 			url: "ajaxProcess/ingreso_promociones.php",
	// 			data: categoriaServicio,
	// 			success: function(datos) {
	// 				div_conceptos.innerHTML = datos;
	// 				bandera_concepto = true;
	// 			}
	// 		});
	// 	} else {
	// 		bandera_concepto.innerHTML = "Es necesario seleccionar un concepto";
	// 	}

	// }

	function cargarConcepto(categoria, servicio, idFila) {
		let div_conceptos = document.getElementById('div_conceptos_' + idFila);

		mostrarBotonAdicionales(categoria);

		if (categoria != '' && servicio != '') {
			div_conceptos.innerHTML = "<img src='imagenes/loading.gif' /> <span style='font-size:10px;'>Cargando Conceptos...</span>";

			let categoriaServicio = "categoria=" + categoria + "&servicio=" + servicio + "&fila=" + idFila;

			$.ajax({
				type: "POST",
				url: "ajaxProcess/ingreso_promociones.php",
				data: categoriaServicio,
				success: function(datos) {
					div_conceptos.innerHTML = datos;
				}
			});
		} else {
			div_conceptos.innerHTML = "Es necesario seleccionar un concepto";
		}
	}

	function mostrarBotonAdicionales(categoria) {
		let boton_adicionales = document.getElementById('agregar_concepto'); // <-- ID corregido
		console.log("Categoría seleccionada: " + categoria);

		if (!boton_adicionales) return; // por si el botón aún no existe

		if (categoria === "PAGO DE MENSUALIDADES") {
			boton_adicionales.disabled = true;
			boton_adicionales.style.opacity = '0.5'; // se ve desactivado
			boton_adicionales.style.cursor = 'not-allowed';
			console.log("Botón desactivado");
		} else {
			boton_adicionales.disabled = false;
			boton_adicionales.style.opacity = '1';
			boton_adicionales.style.cursor = 'pointer';
			console.log("Botón activado");
		}
	}




	// function cargarMontoConcepto(conceptoMonto) {

	// 	// alert("conceptoMonto: " + conceptoMonto);

	// 	bandera_Monto = false;

	// 	var div_monto = document.getElementById('div_monto');
	// 	var conceptoMonto = conceptoMonto;
	// 	var id_cliente = document.getElementById('id_cliente').value;
	// 	if (conceptoMonto != '' || conceptoMonto != null) {

	// 		promociones(conceptoMonto);

	// 		div_monto.innerHTML = "<img src='imagenes/loading.gif' /> <span style='font-size:10px;'>Cargando Monto...</span>";
	// 		// var Monto = "Monto=" + conceptoMonto;
	// 		var Monto = "Monto=" + conceptoMonto + "&cliente=" + id_cliente;

	// 		$.ajax({
	// 			type: "POST",
	// 			url: "ajaxProcess/ingreso_promociones.php",
	// 			data: Monto,
	// 			success: function(datos) {
	// 				div_monto.innerHTML = datos;
	// 				bandera_Monto = true;
	// 				calcularTotal();
	// 			}
	// 		});
	// 	} else {
	// 		bandera_Monto.innerHTML = "Es necesario seleccionar un concepto";
	// 	}
	// }

	function cargarMontoConcepto(conceptoMonto, idFila) {
		let div_monto = document.getElementById('div_monto_' + idFila);
		let div_tipopromo = document.getElementById('div_tipopromo_' + idFila);
		let id_cliente = document.getElementById('id_cliente').value;

		if (conceptoMonto != '' && conceptoMonto != null) {

			//detectando los servicios que son de pago parcial validar los ID

			if (conceptoMonto === "31" || conceptoMonto === "36" || conceptoMonto === "56" || conceptoMonto === "40" || conceptoMonto === "32" || conceptoMonto === "49" || conceptoMonto === "57" || conceptoMonto === "51" || conceptoMonto === "33" || conceptoMonto === "37" || conceptoMonto === "58" || conceptoMonto === "45" || conceptoMonto === "34" || conceptoMonto === "38" || conceptoMonto === "59" || conceptoMonto === "44") {
				document.getElementById('label_pago_parcial').style.display = 'flex';
			} else {
				document.getElementById('label_pago_parcial').style.display = 'none';
			}

			// Crear select de tipo de promoción
			let selectHTML = `
			<select id="tipo_promo_${idFila}" class="form-control" onchange="ejecutarPromocion('${conceptoMonto}', ${idFila}, this.value)">
				<option value="">-- Seleccionar tipo de promoción --</option>
				<option value="porcentaje">Por porcentaje</option>
				<option value="monto">Por Monto</option>
			</select>
		`;
			div_tipopromo.innerHTML = selectHTML;


			// promociones(conceptoMonto, idFila);

			div_monto.innerHTML = "<img src='imagenes/loading.gif' /> <span style='font-size:10px;'>Cargando Monto...</span>";

			let Monto = "Monto=" + conceptoMonto + "&cliente=" + id_cliente + "&fila=" + idFila;

			$.ajax({
				type: "POST",
				url: "ajaxProcess/ingreso_promociones.php",
				data: Monto,
				success: function(datos) {
					div_monto.innerHTML = datos;
					calcularTotal(idFila);
				}
			});
		} else {
			div_monto.innerHTML = "Es necesario seleccionar un concepto";
		}
	}

	// Nueva función para ejecutar promociones con tipo
	function ejecutarPromocion(conceptoMonto, idFila, tipoPromo) {
		if (tipoPromo !== "") {
			// Ejecuta la función original pasando el tipo
			promociones(conceptoMonto, idFila, tipoPromo);
		}
	}


	// function calcularTotal() {

	// 	// alert(precios);

	// 	// Tomar el valor del input
	// 	let precios = document.getElementById("montoIngreso")?.value || 0;

	// 	// Asegurar que sea número
	// 	let total = parseFloat(precios) || 0;

	// 	// Pintar en el div
	// 	document.getElementById("div_subtotal").innerHTML =
	// 		"<strong>Subtotal: </strong> <input type='text' id='subtotal' readonly style='width:200px;text-transform:uppercase;' value='" + total + "' />";

	// 	$('#div_total').text(total);

	// 	//a los de respaldo 

	// 	document.getElementById('subtotal2').value = total;

	// 	document.getElementById('total2').value = total;
	// }

	function calcularTotal(idFila) {
		let precios = document.getElementById("montoIngreso_" + idFila)?.value || 0;
		let total = parseFloat(precios) || 0;

		document.getElementById("div_subtotal_" + idFila).innerHTML =
			"<strong>Subtotal: </strong> <input type='text' id='subtotal_" + idFila + "' name='subtotal_" + idFila + "' readonly style='width:200px;text-transform:uppercase;' value='" + total + "' />";

		document.getElementById("subtotal2_" + idFila).value = total;

		// Calcular el total general sumando todos los subtotales
		let totalGeneral = 0;
		document.querySelectorAll("input[id^='subtotal_']").forEach(input => {
			let valor = parseFloat(input.value) || 0;
			totalGeneral += valor;
		});

		// Actualizar el total general
		$('#div_total').text(totalGeneral.toFixed(2));
		document.getElementById('total2').value = totalGeneral.toFixed(2);

		bandera_total = true;
		mostrarBotonGuardar();

	}


	// function promociones(conceptoMonto) {

	// 	bandera_promocion = false;

	// 	var div_promociones = document.getElementById('div_promociones');
	// 	var conceptoPromo = conceptoMonto;
	// 	if (conceptoPromo != '' || conceptoPromo != null) {

	// 		div_promociones.innerHTML = "<img src='imagenes/loading.gif' /> <span style='font-size:10px;'>Cargando Promociones...</span>";
	// 		var conceptoPromo = "conceptoPromo=" + conceptoPromo;
	// 		$.ajax({
	// 			type: "POST",
	// 			url: "ajaxProcess/ingreso_promociones.php",
	// 			data: conceptoPromo,
	// 			success: function(datos) {
	// 				div_promociones.innerHTML = datos;
	// 				bandera_promocion = true;
	// 			}
	// 		});
	// 	} else {
	// 		bandera_promocion.innerHTML = "Es necesario seleccionar un concepto";
	// 	}

	// }

	function promociones(conceptoMonto, idFila, tipoPromo) {
		let div_promociones = document.getElementById('div_promociones_' + idFila);

		if (conceptoMonto != '' && conceptoMonto != null) {
			div_promociones.innerHTML = "<img src='imagenes/loading.gif' /> <span style='font-size:10px;'>Cargando Promociones...</span>";

			let conceptoPromo = "conceptoPromo=" + conceptoMonto + "&fila=" + idFila + "&tipoPromo=" + tipoPromo;

			$.ajax({
				type: "POST",
				url: "ajaxProcess/ingreso_promociones.php",
				data: conceptoPromo,
				success: function(datos) {
					div_promociones.innerHTML = datos;
				}
			});
		} else {
			div_promociones.innerHTML = "Es necesario seleccionar un concepto";
		}
	}


	// function cargarNuevoTotal(promocion) {


	// 	// alert(promocion);

	// 	var subtotalrespaldo = document.getElementById('subtotal2').value;
	// 	var totalrespaldo = document.getElementById('total2').value;

	// 	let descuento = promocion;
	// 	var subtotal = document.getElementById('subtotal').value;
	// 	var total = document.getElementById('div_total').value;

	// 	if (promocion != null) {

	// 		let nuevoprecio = subtotal - descuento;
	// 		// Actualizar el input directamente
	// 		document.getElementById('subtotal').value = nuevoprecio.toFixed(2);

	// 		// Si quieres actualizar también el div total
	// 		document.getElementById('div_total').innerText = nuevoprecio.toFixed(2);

	// 	} else {

	// 		document.getElementById("div_subtotal").innerHTML =
	// 			"<strong>Subtotal: </strong> <input type='text' id='subtotal' readonly style='width:200px;text-transform:uppercase;' value='" + subtotalrespaldo + "' />";

	// 		$('#div_total').text(totalrespaldo);
	// 	}
	// }

	// function cargarNuevoTotal(promocion, idFila) {
	// 	let subtotalInput = document.getElementById('subtotal_' + idFila);
	// 	let respaldo = document.getElementById('subtotal2_' + idFila).value;

	// 	if (promocion != null) {
	// 		let subtotal = parseFloat(subtotalInput.value) || 0;
	// 		let nuevoprecio = subtotal - parseFloat(promocion);

	// 		subtotalInput.value = nuevoprecio.toFixed(2);
	// 		document.getElementById("div_subtotal_" + idFila).innerHTML =
	// 			"<strong>Subtotal: </strong> <input type='text' id='subtotal_" + idFila + "' readonly style='width:200px;text-transform:uppercase;' value='" + nuevoprecio.toFixed(2) + "' />";
	// 	} else {
	// 		subtotalInput.value = respaldo;
	// 	}
	// }

	//este es el anterior
	// function cargarNuevoTotal(promocion, idFila) {
	// 	let subtotalInput = document.getElementById('subtotal_' + idFila);
	// 	let respaldoInput = document.getElementById('subtotal2_' + idFila); // respaldo de la fila

	// 	// Si no hay respaldo, lo inicializamos con el valor actual
	// 	if (!respaldoInput.value) {
	// 		respaldoInput.value = subtotalInput.value;
	// 	}

	// 	let base = parseFloat(respaldoInput.value) || 0;
	// 	let nuevoPrecio = base;

	// 	if (promocion != null && promocion !== '') {
	// 		let descuento = parseFloat(promocion) || 0;
	// 		nuevoPrecio = base - descuento;
	// 	}

	// 	// Actualizamos el input de la fila
	// 	subtotalInput.value = nuevoPrecio.toFixed(2);

	// 	// Actualizamos el div de la fila (si lo tienes)
	// 	let divSubtotal = document.getElementById("div_subtotal_" + idFila);
	// 	if (divSubtotal) {
	// 		divSubtotal.innerHTML = "<strong>Subtotal: </strong> <input type='text' name='subtotal_" + idFila + "' id='subtotal_" + idFila + "' readonly style='width:200px;text-transform:uppercase;' value='" + nuevoPrecio.toFixed(2) + "' />";
	// 	}

	// 	// Finalmente, actualizamos el total general sumando todos los subtotales
	// 	actualizarTotalGeneral();
	// }

	function cargarNuevoTotal(promocion, idFila, tipo) {
		let subtotalInput = document.getElementById('subtotal_' + idFila);
		let respaldoInput = document.getElementById('subtotal2_' + idFila);

		if (!respaldoInput.value) {
			respaldoInput.value = subtotalInput.value;
		}

		let base = parseFloat(respaldoInput.value) || 0;
		let nuevoPrecio = base;

		if (promocion != null && promocion !== '') {
			let descuento = parseFloat(promocion) || 0;

			if (tipo === 'porcentaje') {
				descuento = (base * descuento) / 100;
				nuevoPrecio = base - descuento;
			} else if (tipo === 'monto') {
				nuevoPrecio = base - descuento;
			}
		}

		// 🔹 Redondeo clásico (>= .5 sube, < .5 baja)
		nuevoPrecio = Math.round(nuevoPrecio);

		// ✅ Solo actualizamos el valor, sin recrear el input
		subtotalInput.value = nuevoPrecio.toFixed(2);

		actualizarTotalGeneral();
	}


	// Función que suma todos los subtotales y actualiza div_total y total2
	function actualizarTotalGeneral() {
		let total = 0;
		document.querySelectorAll("input[id^='subtotal_']").forEach(input => {
			let valor = parseFloat(input.value) || 0;
			total += valor;
		});

		document.getElementById("div_total").innerText = total.toFixed(2);
		document.getElementById("total2").value = total.toFixed(2);
		bandera_total = true;
		mostrarBotonGuardar();
	}

	function mostrarBotonGuardar() {
		const boton = document.getElementById("btn_guardar");
		if (bandera_total) {
			boton.style.display = "inline-block"; // lo muestra
		} else {
			boton.style.display = "none"; // lo oculta
		}
	}

	var contadorConceptosAdd2 = 0;

	function agregarConceptoAdicional2() {
		contadorConceptosAdd2++;

		// Obtenemos la tabla donde van las filas
		var contenedor = document.getElementById('div_contenedor_adicionales');

		// Creamos la fila <tr>
		var fila = document.createElement('tr');
		fila.id = "fila_concepto_" + contadorConceptosAdd2;

		// Construimos el contenido de la fila con ids dinámicos
		fila.innerHTML = `
        <td>
            <select name="tipoServicio_${contadorConceptosAdd2}" 
                    onchange="cargarcategoria(this.value, ${contadorConceptosAdd2});" 
                    style="width:150px; font-size:12px;">
                <option value="null">Elige un Tipo de Servicio</option>
                <option value="COBRE">COBRE</option>
                <option value="TV CON FIBRA">TV CON FIBRA</option>
                <option value="TVINTERNET">TV + INTERNET</option>
                <option value="INTERNET">INTERNET</option>
            </select>
        </td>

        <!-- Categorías -->
        <td>
            <div id="div_categoria_${contadorConceptosAdd2}"></div>
        </td>

        <!-- Conceptos -->
        <td>
            <div id="div_conceptos_${contadorConceptosAdd2}"></div>
        </td>

        <!-- Montos -->
        <td>
            <div id="div_monto_${contadorConceptosAdd2}"></div>
        </td>

		<!-- Tipo Promocion -->
        <td>
            <div id="div_tipopromo_${contadorConceptosAdd2}"></div>
        </td>
		
        <!-- Promociones -->
        <td>
            <div id="div_promociones_${contadorConceptosAdd2}"></div>
        </td>

        <!-- Total -->
        <td>
            <div id="div_subtotal_${contadorConceptosAdd2}"></div>
        </td>

        <td>
            <input type="text" id="subtotal2_${contadorConceptosAdd2}" name="subtotal2_${contadorConceptosAdd2}" 
                   style="margin-top: 4px;margin-bottom: 2px; width:150px; visibility: hidden;" />
        </td>
    `;

		// Insertamos la fila en el contenedor
		contenedor.appendChild(fila);
	}

	function pagoparcial(checkbox) {

		const divPago = document.getElementById('div_pago_parcial');

		if (checkbox.checked) {
			divPago.style.display = 'flex'; // Mostrar div
			console.log('Div mostrado'); // Para verificar
		} else {
			divPago.style.display = 'none'; // Ocultar div
			console.log('Div oculto'); // Para verificar
		}
	}


	function formDatosInternet($value) {
		bandera_form_internet = false;
		var div_internet = document.getElementById('Datos_internet');

		if ($value == '9' || $value == '15' || $value == '8' || $value == '13' || $value == '14' || $value == '16') { //aca agregar los id que son de internet

			div_internet.innerHTML = "<img src='imagenes/loading.gif' /> <span style='font-size:10px;'>Cargando Datos...</span>";
			var servicio_internet = "servicio_internet=" + $value;

			$.ajax({
				type: "POST",
				url: "ajaxProcess/ingreso_promociones.php",
				data: servicio_internet,
				success: function(datos) {
					div_internet.innerHTML = datos;
					bandera_form_internet = true;
				}
			});
		} else {
			div_internet.innerHTML = "";
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
					<td align="left" background="imagenes/module_center.png" height="80" valign="middle" class="titulo"><b>&nbsp;&nbsp;AGREGAR INGRESO&nbsp;&nbsp;</b></td>
					<td align="right" background="imagenes/module_center.png" height="80">
						<!-- <button class="boton2" onclick="guardar()"><img src="imagenes/guardar.png" /><br />Guardar</button> -->
						<!-- Botón -->
						<button id="btn_guardar" class="boton2" onclick="guardar()" style="display:none;">
							<img src="imagenes/guardar.png" /><br />Guardar
						</button>
						<button class="boton2" onclick="location.href='index.php?menu=12'"><img src="imagenes/cancelar.png" /><br />Cancelar</button>
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
			<form name="formulario" method="post" onsubmit="return false;" action="index.php?menu=12">
				<table class="datagrid" width="100%" border="0" cellspacing="0">
					<tr>
						<td height="3px" class="separador"></td>
					</tr>

					<tr>
						<td>
							<p style="color:red; font-weight:bold;">Para Iniciar debes seleccionar un cliente</p>
						</td>
					</tr>

					<tr class="tabla_columns">
						<td>&nbsp;Cliente</td>
					</tr>
					<tr>
						<td>
							<table style="color:#000000" cellpadding="5">
								<tr>
									<td>Clave del Cliente</td>
									<td valign="middle"><input name="id_cliente" id="id_cliente" readonly="readonly" style="width:110px;font-size:12px;" type="text" maxlength="12" value="<?php echo $_GET['id_cliente'] ?>" />&nbsp;<img style="cursor:pointer;position:relative; top:4px;" onclick="contenedor_cliente='id_cliente';createWindow('Buscar Cliente',450,310 ,1,false,true);" src="imagenes/popup.png" /></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td>
							<input type="button" value="Mostrar Numero Celular, Curp y Tarifa" style="font-size:12px;margin-left:6px" id="datos" onclick="clienteSelect();" />
						</td>
					</tr>

					<tr>
						<!-- div para mostrar el telefono -->
						<td>
							<div id="telefono">
							</div>
						</td>

					</tr>

					<tr>
						<!-- div para mostrar la tarifa -->
						<td>
							<div id="tarifa">
							</div>
						</td>
					</tr>
					<tr>
						<!-- div para mostrar la tarifa -->
						<td>
							<div id="curp">
							</div>
						</td>
					</tr>
					<tr>
						<td height="3px" class="separador"></td>
					</tr>
				</table>
				<br />
				<table class="datagrid" width="100%" border="0" cellspacing="0">
					<tr>
						<td height="3px" class="separador"></td>
					</tr>
					<tr class="tabla_columns">
						<td>&nbsp;Total</td>
					</tr>
					<!-- <tr>
						<td bgcolor="#FFFFFF">
							<span style="font-size:18px; font-weight:bold;">$</span>
							<div id="div_total">0.00</div>
						</td>
					</tr> -->
					<tr>
						<td bgcolor="#FFFFFF" style="display: flex; align-items: center; gap: 30px;">
							<!-- Bloque 1: Total + Pago Parcial -->
							<div style="display: flex; align-items: center; gap: 10px;">
								<span style="font-size:18px; font-weight:bold;">$</span>
								<div id="div_total" style="font-size:18px; font-weight:bold;">0.00</div>
								<label id="label_pago_parcial" style="display: none; align-items: center; gap: 5px; font-size:14px;">
									<input type="checkbox" id="pago_parcial" name="pago_parcial" onchange="pagoparcial(this)">
									Pago parcial
								</label>
							</div>

							<!-- Bloque 2: Pago Final + Input -->
							<div id="div_pago_parcial" style="display: none; flex-direction: column; gap: 5px; margin-top: 5px;">
								<label for="pago_final" style="font-size:14px;">Por favor, ingresa el pago parcial del cliente</label>
								<input type="number" id="pago_final" name="pago_final"
									style="width:200px;"
									step="0.01"
									min="0"
									placeholder="0.00">
							</div>
						</td>
					</tr>
					<tr>
						<td bgcolor="#FFFFFF">
							<input type="text" id="total2" name="total2" style="margin-top: 4px;margin-bottom: 2px; width:150px; visibility: hidden;" />
						</td>
					</tr>
					<tr>
						<td height="3px" class="separador"></td>
					</tr>
				</table>
				<br />
				<table class="datagrid" width="100%" border="0" cellspacing="0">
					<tr>
						<td height="3px" class="separador"></td>
					</tr>
					<tr class="tabla_columns">
						<td>&nbsp;Concepto de Cobro</td>
					</tr>
					<tr>
						<td>
							<table style="color:#000000" border="0" cellpadding="5">
								<tr>
									<td width="200px">Tipo de Servicio</td>
									<td width="200px">Categorias</td>
									<td width="200px">Concepto</td>
									<td width="100px">Monto</td>
									<td width="200px">Tipo Promocion</td>
									<td width="200px">Promocion</td>
									<td></td>
									<td width="200px" align="right">SubTotal</td>
								</tr>
								<tr>
									<td>
										<select name="tipoServicio_0" onchange="cargarcategoria(this.value,0);" style="width:150px; font-size:12px;">
											<option value="null">Elige un Tipo de Servicio</option>
											<option value="COBRE">COBRE</option>
											<option value="TV CON FIBRA">TV CON FIBRA</option>
											<option value="TVINTERNET">TV + INTERNET</option>
											<option value="INTERNET">INTERNET</option>
											?>
										</select>
									</td>

									<!-- categorias del servicio -->
									<td>
										<div id="div_categoria_0"></div>
									</td>

									<!-- conceptos -->
									<td>
										<div id="div_conceptos_0"></div>
									</td>

									<!-- Montos -->
									<td>
										<div id="div_monto_0"></div>
									</td>

									<!-- Tipo Promocion -->
									<td>
										<div id="div_tipopromo_0"></div>
									</td>

									<!-- Promociones -->
									<td>
										<div id="div_promociones_0"></div>
									</td>

									<!-- Total -->
									<td>
										<div id="div_subtotal_0"></div>
									</td>

									<td>
										<input type="text" id="subtotal2_0" name="subtotal2_0" style="margin-top: 4px;margin-bottom: 2px; width:150px; visibility: hidden;" />
									</td>


									<!-- Conceptos  -->

									<!-- <td>
										<select name="concepto" onchange="cargarPromocion(this.value,'div_concepto_promocion','div_total_a_0','monto','promocion',0); formDatosInternet(this.value);" style="width:200px; font-size:12px;">
											<option value="null">Elige un Tipo de Ingreso</option>
											<?php
											$query_t_u = "select * from cat_tipo_ingreso where estado = 'Activo'";
											$tabla_t_u = mysqli_query($conexion, $query_t_u);
											while ($registro_t_u = mysqli_fetch_array($tabla_t_u)) {
												echo "<option value=\"$registro_t_u[0]\">$registro_t_u[2]</option>";
											}
											?>
										</select>
									</td> -->


									<!-- <td><input type="text" onchange="solo_numeros_decimales(this);calcularTotal('div_total_a_0','monto','promocion');reestableceZero(this);" onkeyup="solo_numeros_decimales(this)" value="0.00" class="monto" id="monto" name="monto" maxlength="13" /></td> -->

									<!-- <td>
										<div id="div_concepto_promocion">No asignado.</div>
									</td>

									<td width='30px' align='right'><span style="font-size:12px; font-weight:bold;">$</span></td>



									<td align="right">
										<div class="total" id="div_total_a_0">0.00</div>
									</td> -->



								</tr>
								<tr>
									<th colspan="7" align="left">Conceptos Adicionales:</th>
								</tr>
								<tr>
									<td colspan="7">
										<div id="div_contenedor_adicionales"></div>
										<input type="button" value="Agregar Concepto Adicional" style="font-size:12px;" id="agregar_concepto" onclick="agregarConceptoAdicional2();" />
									</td>
								</tr>
								<tr>
									<td colspan="7" style="border-bottom:1px solid #DDD;">
										<table>
											<tr>
												<td>Nota Impresa (Opcional):</td>
												<td><input type="text" name="nota_impresa" onblur="solo_numeros(this)" onkeyup="solo_numeros(this)" size="10" maxlength="10" /></td>
											</tr>
										</table>
									</td>
								</tr>
							</table>

						</td>
					</tr>
					<tr>
						<td height="3px" class="separador"></td>
					</tr>
				</table>

				<div id="Datos_internet"></div>

				<br>
				<table class="datagrid" width="100%" border="0" cellspacing="0">
					<tr>
						<td height="3px" class="separador"></td>
					</tr>
					<tr class="tabla_columns">
						<td>&nbsp;Observaciones</td>
					</tr>
					<tr>
						<td align="center">
							<textarea name="observaciones" cols="50" rows="5" style="width:99%;font-family:Arial, Helvetica, sans-serif; font-size:12px"></textarea>
						</td>
					</tr>
					<tr>
						<td height="3px" class="separador"></td>
					</tr>
				</table>
				<input name="accion" type="hidden" value="agregar" />
			</form>
		</td>
	</tr>
</table>