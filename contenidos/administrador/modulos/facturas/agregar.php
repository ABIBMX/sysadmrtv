
<script language="javascript" type="text/javascript">
	
	function guardar()
	{
		var cadena = "";
		/*if(document.formulario.nombre.value=='')
			cadena+= "\n* Debe ingresar un Nombre.";
		*/
		
		if(document.formulario.proveedor.value=='-1')
			cadena+= "\n* Debe seleccionar un Proveedor.";

		if(document.formulario.canal.value=='-1')
			cadena+= "\n* Debe seleccionar un Canal.";
		
		if(cadena == "")
		{
			document.formulario.submit();
		}
		else
			alert("Por favor verifique lo siguiente:"+cadena);
	}
	function solo_numeros(texto)
	{
		var expresion = /[0-9]*/;
		texto.value = texto.value.match(expresion);
	}
	function solo_numeros_decimales(texto)
	{
		var expresion = /[0-9]*\.?[0-9]{0,2}/;
		texto.value = texto.value.match(expresion);
	}

	$(document).ready(function(){


		// Funciones inicializadoras
		$(".decimal").change(function(){

			var expresion = /[0-9]*\.?[0-9]{0,2}/;
			var valor = $(this).val();
			$(this).val(valor.match(expresion));
		});
		$(".decimal").blur(function(){

			var expresion = /[0-9]*\.?[0-9]{0,2}/;
			var valor = $(this).val();
			$(this).val(valor.match(expresion));
		})
		$(".decimal").live("keydown",function(){

			var expresion = /[0-9]*\.?[0-9]{0,2}/;
			var valor = $(this).val();
			$(this).val(valor.match(expresion));
		});
		

		$("#tiene_iva").change(function(){
			if($(this).val()=="0"){
				$("#iva").attr("disabled",true);
				$("#iva").val("0");

			}
			else
				$("#iva").attr("disabled",false);

			calcularIVA();
			calcularTOTAL();
			calcularImporteAPagar();
			calcularSaldo();
		});
		$("#iva_automatico").click(function(){
			if($(this).attr("checked")){
				$("#iva").attr("readonly",true);
			}else{
				$("#iva").attr("readonly",false);
			}
			
		});

		$("#tipo_moneda").change(function(){
			if($(this).val()=="1"){
				$("#tipo_cambio").attr("disabled",true);
				$("#tipo_cambio").val("");
			}
			else{
				$("#tipo_cambio").attr("disabled",false);
			}
			calcularImporteAPagar();
			calcularSaldo();
		});

		$("#subtotal").change(function(){

			calcularIVA();
			calcularTOTAL();
			calcularImporteAPagar();
			calcularSaldo();

		});
		$("#subtotal").blur(function(){
			calcularIVA();
			calcularTOTAL();
			calcularImporteAPagar();
			calcularSaldo();

		});

		$("#iva").change(function(){

			calcularTOTAL();
			calcularImporteAPagar();
			calcularSaldo();

		});
		$("#iva").blur(function(){
			calcularTOTAL();
			calcularImporteAPagar();
			calcularSaldo();

		});

		$("#total").change(function(){

			calcularImporteAPagar();
			calcularSaldo();

		});
		$("#total").blur(function(){
			calcularImporteAPagar();
			calcularSaldo();

		});

		$("#valor_iva").change(function(){
			calcularIVA();
			calcularTOTAL();
			calcularImporteAPagar();
			calcularSaldo();

		});
		$("#valor_iva").blur(function(){
			calcularIVA();
			calcularTOTAL();
			calcularImporteAPagar();
			calcularSaldo();

		});

		$("#total_pagado").change(function(){
			calcularSaldo();

		});
		$("#total_pagado").blur(function(){
			calcularSaldo();
		});

		$("#tipo_cambio").change(function(){

			calcularImporteAPagar();
			calcularSaldo();
		});
		$("#tipo_cambio").blur(function(){
			calcularImporteAPagar();
			calcularSaldo();
		});
		
		$("#status").change(function(){
			verificarFechaPago();

		});
		$("#tipo_factura").change(function(){
			verificarFechaPago();

		});

		$("#proveedor").change(function(){
			$("#div_canal").html('<select name="canal" id="canal"   style="width:270px; font-size:12px;"><option value="-1">Cargando...</option></select> ');
			$.ajax({
					type: "POST",
					url: "ajaxProcess/canales_modulo.php",
					data: "id="+$('#proveedor').val(),
					contentType: "application/x-www-form-urlencoded; charset=iso-8859-1",
					success: function(datos)
					{
						$('#div_canal').html(datos);								
					}
			});
		});

		//Funciones Especiales
		function calcularIVA(){
			if($("#iva_automatico").attr("checked") && $("#tiene_iva").val()=="1"){
				$("#iva").val($("#valor_iva").val()*$("#subtotal").val());
			}
			
		}
		function calcularTOTAL(){
			
			if(!$("#iva").attr("disabled")){
				var total = parseFloat($("#subtotal").val())+parseFloat($("#iva").val());
				if(!isNaN(total))
					$("#total").val(total);
				else
					$("#total").val(0);
			}
			else{
				$("#total").val($("#subtotal").val());
			}
			
		}
		function calcularImporteAPagar(){
			if($("#tipo_moneda").val()=="1"){
				$("#importe_pagar").val($("#total").val());
			}
			else{
				$("#importe_pagar").val($("#total").val()*$("#tipo_cambio").val());	
			}
		}
		function calcularSaldo(){
			var saldo = parseFloat(parseFloat($("#importe_pagar").val()-$("#total_pagado").val()));
			if(!isNaN(saldo))
				$("#saldo").val(saldo);
			else
				$("#saldo").val(0);
		}
		function verificarFechaPago(){
			if($("#tipo_factura").val()=="2" || $("#status").val()=="2"|| $("#status").val()=="3"){
				$("#fecha_pago").attr("disabled",false);

			}
			else{
				$("#fecha_pago").val("");
				$("#fecha_pago").attr("disabled",true);
			}
				
		}
	});
</script>

<table border="0px"  width="100%" style="color:#000000;font-size:12px">
	<tr>    
    	<td align="right">
        	<table border="0" width="100%" cellpadding="0" cellspacing="0" >
            	<tr>
            	<td width="5px" background="imagenes/module_left.png"></td>
                <td width="70px" background="imagenes/module_center.png" height="80"  valign="middle"><img src="imagenes/invoice.png" /></td>
                <td align="left" background="imagenes/module_center.png" height="80" valign="middle" class="titulo"><b>&nbsp;&nbsp;AGREGAR FACTURA</b></td>
                <td align="right" background="imagenes/module_center.png" height="80" >
                    <button class="boton2" onclick="guardar()" ><img src="imagenes/guardar.png" /><br/>Guardar</button>
					<button class="boton2" onclick="location.href='index.php?menu=33'"><img src="imagenes/cancelar.png" /><br />Cancelar</button>
                </td>
                <td width="5px" background="imagenes/module_right.png"></td>
                </tr>
            </table>
        </td>
	</tr>
    <tr><td height="10px"></td></tr>
	<tr>
		<td colspan="3">
			<form name="formulario" method="post" onsubmit="return false;" action="index.php?menu=33" autocomplete="off">
				<table class="datagrid" width="100%" border="0" cellspacing="0">
					<tr><td  height="3px" class="separador"></td></tr>
					<tr class="tabla_columns">
						<td > Informaci&oacute;n General</td>
					</tr>
					<tr>
						<td>
							
							<table style="color:#000000" cellpadding="5">
	                            <tr>
	                        	  	<td>Proveedor:</td>
	                        	  	<td colspan="3">
		                              <select name="proveedor" id="proveedor" style="width:350px;font-size:12px;">
		                              	<option value="-1">Seleccione un Proveedor</option>
		                              	<?php
											$query="select id_proveedor,nombre from f_cat_proveedor where estado = 'Activo'";
											$consulta=mysqli_query($conexion,$query);
											while(list($id,$sucursal)=mysqli_fetch_array($consulta)){
												echo "<option value='$id'>$sucursal</option>";
											}
										?>
		                              </select>
	                             	 </td>
	                          	</tr>  
	                          	<tr>
	                        	  	<td>Canal:</td>
	                        	  	<td colspan="3">
	                        	  		<div id="div_canal">
				                            <select name="canal" id="canal" style="width:350px;font-size:12px;">
				                        	   	<option value="-1">Seleccione un Proveedor</option>		                              	
				                            </select>
				                        </div>
	                             	 </td>
	                          	</tr>                           	                                                          
	                           
	                            <tr>
	                        	  	<td>Tipo:</td><td>
		                              <select name="tipo_factura" id="tipo_factura" style="width:150px;font-size:12px;">
		                              
		                              	<?php
											$query="select id_tipo,nombre from f_cat_tipo_factura";
											$consulta=mysqli_query($conexion,$query);
											while(list($id,$sucursal)=mysqli_fetch_array($consulta)){
												echo "<option value='$id'>$sucursal</option>";
											}
										?>
		                              </select>
	                             	 </td>
	                             	 <td>Tipo Moneda:</td><td>
				                            <select name="tipo_moneda" id="tipo_moneda" style="width:100px;font-size:12px;">
				                              
				                              	<?php
													$query="select id_tipo,nombre from f_cat_tipo_moneda";
													$consulta=mysqli_query($conexion,$query);
													while(list($id,$sucursal)=mysqli_fetch_array($consulta)){
														echo "<option value='$id'>$sucursal</option>";
													}
												?>
				                            </select>
	                             	 </td>
	                          	</tr>
	                          	<tr>
	                        	  	<td>No. Factura:</td>
	                        	  	<td colspan="3"><input name="no_factura" style="width:350px;font-size:12px;" type="text" maxlength="50" /></td>
	                        	</tr>                  
	                        	<tr>
	                        	  	<td>Descripcion:</td>
	                        	  	<td colspan="3"><input name="descripcion" style="width:350px;font-size:12px;" type="text" maxlength="500" /></td>
	                        	</tr>  
	                          	<tr>
	                        	  	<td>Status:</td>
	                        	  	<td colspan="3">
		                              <select name="status" id="status" style="width:350px;font-size:12px;">
		                              
		                              	<?php
											$query="select id_status,nombre from f_status_factura";
											$consulta=mysqli_query($conexion,$query);
											while(list($id,$sucursal)=mysqli_fetch_array($consulta)){
												echo "<option value='$id'>$sucursal</option>";
											}
										?>
		                              </select>
	                             	 </td>
	                          	</tr> 
	                          	<tr>
		                        	<td>Fecha Recepcion:</td>
		                        	<td>
		                            	<input name="fecha_recepcion" id="fecha_recepcion"  style="width:90px;font-size:12px; background-image:url(calendario/imgs/icon_minicalendar.gif); background-position:right center; background-repeat:no-repeat;" type="text" maxlength="10" readonly="readonly" />
		                            </td>
		                        </tr>
		                        <tr>
		                        	<td>Fecha de Pago:</td>
		                        	<td>
		                            	<input name="fecha_pago" id="fecha_pago" disabled  style="width:90px;font-size:12px; background-image:url(calendario/imgs/icon_minicalendar.gif); background-position:right center; background-repeat:no-repeat;" type="text" maxlength="10" readonly="readonly" />
		                            </td>
		                        </tr>
	                        	                                                            
							</table>
							
						</td>
					</tr>
					<tr><td  height="3px" class="separador"></td></tr>
				</table>
				<br>
				<table class="datagrid" width="100%" border="0" cellspacing="0">
					<tr><td  height="3px" class="separador"></td></tr>
					<tr class="tabla_columns">
						<td > Montos</td>
					</tr>
					<tr>
						<td>
							
							<table style="color:#000000" cellpadding="5">
	                            
	                          	<tr>
	                          		<td>Tiene IVA</td>
	                          		<td>&nbsp;&nbsp;
	                          			<select name="tiene_iva" id="tiene_iva" style="width:100px;font-size:12px;">
				                         	<option value="1">SI</option>
				                         	<option value="0">NO</option>
				                        </select>
	                          		</td>
	                          		<td>VALOR IVA:</td>
	                          		<td><input name="valor_iva" id="valor_iva" class="decimal" style="width:50px;font-size:12px; text-align:right;" type="text" maxlength="13" value="0.16" /></td>

	                          	</tr>
	                          	<tr>
	                        	  	<td>Subtotal:</td>
	                        	  	<td colspan="3">$ <input name="subtotal" id="subtotal" class="decimal" style="width:100px;font-size:12px;text-align:right;" type="text" maxlength="13" /></td>
	                        	</tr> 
	                        	<tr>
	                        	  	<td>IVA:</td>
	                        	  	<td >$ <input name="iva" id="iva" class="decimal" readOnly style="width:100px;font-size:12px;text-align:right;" type="text" maxlength="13" /></td>
	                        	  	<td colspan="2"><input type="checkbox" name="iva_automatico" checked id="iva_automatico"><label for="iva_automatico"> Autom&aacute;tico</label></td>
	                        	</tr> 
	                        	<tr>
	                        	  	<td><b>Total:</b></td>
	                        	  	<td colspan="3">$ <input name="total" id="total" class="decimal" style="width:100px;font-size:12px;text-align:right;" type="text" maxlength="13" /></td>
	                        	</tr>
	                        	<tr>
	                        		<td height="10px"></td>
	                        	</tr>
	                        	<tr>
	                        	  	<td>Tipo de Cambio:</td>
	                        	  	<td colspan="3">$ <input name="tipo_cambio" id="tipo_cambio" disabled="disabled" class="decimal" style="width:100px;font-size:12px;text-align:right;" type="text" maxlength="13" /></td>
	                        	</tr>
	                        	<tr>
	                        	  	<td><b>Importe a Pagar:</b></td>
	                        	  	<td colspan="3">$ <input name="importe_pagar" id="importe_pagar" readOnly class="decimal" style="width:100px;font-size:12px;text-align:right;" type="text" maxlength="13" /> (Pesos Mexicanos)</td>
	                        	</tr>
	                        	
	                        	<tr>
	                        	  	<td>Total Pagado:</td>
	                        	  	<td colspan="3">$ <input name="total_pagado" id="total_pagado" class="decimal" style="width:100px;font-size:12px;text-align:right;" type="text" maxlength="13" /></td>
	                        	</tr>
	                        	<tr>
	                        	  	<td> <b>Saldo:</b> </td>
	                        	  	<td colspan="3">$ <input name="saldo" id="saldo" class="decimal" readOnly style="width:100px;font-size:12px;text-align:right;" type="text" maxlength="13" /></td>
	                        	</tr>    
	                        	                                                            
							</table>
							
						</td>
					</tr>
					<tr><td  height="3px" class="separador"></td></tr>
				</table>
				<input name="accion"  type="hidden" value="agregar" />
			</form>
		</td>
	</tr>
</table>
<script>
var cal1,
cal2,
mCal,
mDCal,
newStyleSheet;
var dateFrom = null;
var dateTo = null;
window.onload = function() {
	
    cal1 = new dhtmlxCalendarObject('fecha_recepcion');
	cal1.setSkin('dhx_skyblue');
	cal2 = new dhtmlxCalendarObject('fecha_pago');
	cal2.setSkin('dhx_skyblue');
	

}
</script>
