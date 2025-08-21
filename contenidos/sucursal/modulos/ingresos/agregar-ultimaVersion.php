<style>
	#div_total
	{
		font-size:18px;
		font-weight:bold;
		font-family:Arial, Helvetica, sans-serif;
		display:inline;
	}
	.monto
	{
		width:100px;
		font-size:12px;
		text-align:right;
	}
	.total
	{
		display:inline;
		font-weight:bold;
		font-size:12px;
	}
	.del_concepto
	{
		display:inline-block;
		background:url(imagenes/del.png);
		width:16px;
		height:16px;
		cursor:pointer;
	}
</style>
<script language="javascript" type="text/javascript">
	
	function guardar()
	{
		var cadena = "";
		
		if(document.formulario.id_cliente.value=='')
			cadena+= "\n* Debe elegir el id del cliente.";
		
		if(!bandera_total)
			cadena+= "\n* Por favor espere a que se calcule el total.";
		
		if(document.formulario.concepto.value=='null')
		{
			cadena+= "\n* No ha seleccionado del concepto de ingreso.";
		}
		
		var contador_conceptos=0;
		$(function(){
			$('.conceptos').each(function(){
				if($(this).val() == 'null')
					contador_conceptos++;						 
			});
		});
		
		if(contador_conceptos>0)
		{
			cadena+= "\n* Hay algunos conceptos adicionales que no ha seleccionado.";
		}
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
	function reestableceZero(texto)
	{
		if(texto.value=="")
			texto.value="0.00";
	}
	function solo_numeros_decimales(texto)
	{		
		var expresion = /[0-9]*\.?[0-9]{0,2}/;
		texto.value = texto.value.match(expresion);
		
	}
	
	//Se han agregado estas dos variables obligatorias 
	var contenedor_cliente = ""; //Se actualiza para saber en que input se coloca la llave del cliente
	var parametro_sucursal_cliente = "<?php echo $_SESSION['tuvision_id_sucursal']; ?>";// Se utiliza en caso de que queramos la lista de clientes de una sucursal en especifica
	function cambio_id_cliente(id){	}
	
	function cargarPromocion(valor, div_promocion, id_total, id_monto,id_promocion,adicional)
	{
		//Bloqueamos para que no guarden
		bandera_total = false;
		
		var contenedor = document.getElementById(div_promocion);
		if(valor!="null")
		{			
			contenedor.innerHTML = "<img src='imagenes/loading.gif' /> <span style='font-size:10px;'>Cargando Promociones...</span>";
			var cdata = "tipo_ingreso="+valor+"&id_total="+id_total+"&id_monto="+id_monto+"&id_promocion="+id_promocion+"&adicional="+adicional;
			$.ajax({
					type: "POST",
					url: "ajaxProcess/ingreso_promociones.php",
					data: cdata,
					success: function(datos)
					{
						contenedor.innerHTML = datos;
						calcularTotal(id_total,id_monto, id_promocion);
					}
			});
		}
		else
		{
			contenedor.innerHTML = "No Asignado";
		}
	}
	function calcularTotal(id_total,id_monto, id_promocion)
	{
		$('#div_total').html("<img src='imagenes/loading.gif' /> <span style='font-size:10px;'>Calculando Total...</span>");
		
		//Bloqueamos para que no guarden
		bandera_total = false;
		
		//Hay que calcular el procentaje de descuento
		
		var monto = document.getElementById(id_monto);
		var total = document.getElementById(id_total);		
		var promocion = document.getElementById(id_promocion);
		
		total.innerHTML = "<img src='imagenes/loading.gif' /> <span style='font-size:10px;'>Calculando Total...</span>";
		if(promocion ==null)
		{
			total.innerHTML = monto.value;
			sumarTotales();
		}
		else
		{
			var cdata = "promocion="+promocion.value;
			
			$.ajax({
						type: "POST",
						url: "ajaxProcess/ingreso_promociones.php",
						data: cdata,
						success: function(datos)
						{	
							
							var calculo = monto.value - ((monto.value * datos)/100);
							total.innerHTML = calculo;
							sumarTotales();
						}
				});
		}
	}
	var contadorConceptosAdd = 0;
	
	function agregarConceptoAdicional()
	{
		
		
		contadorConceptosAdd++;
		var contenedor = document.getElementById('div_contenedor_adicionales');
		
		var div_concepto = document.createElement('div');
		div_concepto.id ="div_concepto_adicional_"+contadorConceptosAdd;
		
		div_concepto.innerHTML = "<table style='color:#000000' border='0' cellpadding='5'><tr><td><div id='concepto_"+contadorConceptosAdd+"'><img src='imagenes/loading.gif' /> <span style='font-size:10px;'>Cargando conceptos...</span></div></td><td><input type='text' onchange=\"solo_numeros_decimales(this);calcularTotal('div_total_a_"+contadorConceptosAdd+"','monto_"+contadorConceptosAdd+"','promocion_"+contadorConceptosAdd+"');reestableceZero(this);\" onkeyup='solo_numeros_decimales(this)' value='0.00' class='monto' id='monto_"+contadorConceptosAdd+"' name='monto_a[]' maxlength='13'/></td><td width='200px'><div id='div_promocion_"+contadorConceptosAdd+"' ><select name='promociones[]' id='' style='width:200px;font-size:12px;'><option value='null'>No hay promociones</option></select></div></td><td width='30px' align='right'>$</td><td  align='right' width='200px'><div class='total' id='div_total_a_"+contadorConceptosAdd+"'>0.00</div></td><td><span class='del_concepto'></span></td></table>";
		
		var cdata = "concepto_add=1&div_promocion=div_promocion_"+contadorConceptosAdd+"&div_total=div_total_a_"+contadorConceptosAdd+"&div_monto=monto_"+contadorConceptosAdd+"&id_promocion=promocion_"+contadorConceptosAdd+"&adicional=1";
		
		contenedor.appendChild(div_concepto);
		var concepto_adicional = document.getElementById('concepto_'+contadorConceptosAdd);
		
		$.ajax({
					type: "POST",
					url: "ajaxProcess/ingreso_promociones.php",
					data: cdata,
					success: function(datos)
					{	
						concepto_adicional.innerHTML = datos;						
					}
			});
		
		
		
	}
	var total_sumado = 0;
	var bandera_total = true;
	function sumarTotales()
	{
		total_sumado = 0;		
		
		$('.total').each(function(){
			total_sumado += parseFloat($(this).text());
							
		});
		
		$('#div_total').text(total_sumado);
		
		bandera_total = true;
	}
	$(function(){
		$('.del_concepto').live('click',function(){
				$(this).parent().parent().parent().parent().parent().remove();
				sumarTotales();
			});
							 
	});
</script>

<table border="0px"  width="100%" style="color:#000000;font-size:12px">
	<tr>    
    	<td align="right">
        	<table border="0" width="100%" cellpadding="0" cellspacing="0" >
            	<tr>
            	<td width="5px" background="imagenes/module_left.png"></td>
                <td width="70px" background="imagenes/module_center.png" height="80"  valign="middle"><img src="imagenes/ingresos.png" /></td>
                <td align="left" background="imagenes/module_center.png" height="80" valign="middle" class="titulo"><b>&nbsp;&nbsp;AGREGAR INGRESO&nbsp;&nbsp;</b></td>
                <td align="right" background="imagenes/module_center.png" height="80" >
                    <button class="boton2" onclick="guardar()" ><img src="imagenes/guardar.png" /><br/>Guardar</button>
					<button class="boton2" onclick="location.href='index.php?menu=12'"><img src="imagenes/cancelar.png" /><br />Cancelar</button>
                </td>
                <td width="5px" background="imagenes/module_right.png"></td>
                </tr>
            </table>
        </td>
	</tr>
    <tr><td height="10px"></td></tr>
	<tr>
		<td colspan="3">
        	<form name="formulario" method="post"  onsubmit="return false;" action="index.php?menu=12">
			<table class="datagrid" width="100%" border="0" cellspacing="0">
				<tr><td  height="3px" class="separador"></td></tr>
				<tr class="tabla_columns">
					<td >&nbsp;Cliente</td>
				</tr>
				<tr>
					<td>						
						<table style="color:#000000" cellpadding="5">
                        	 <tr><td>Clave del Cliente</td><td valign="middle"><input name="id_cliente" id="id_cliente" readonly="readonly" style="width:110px;font-size:12px;" type="text" maxlength="12" value="<?php echo $_GET['id_cliente'] ?>" />&nbsp;<img style="cursor:pointer;position:relative; top:4px;" onclick="contenedor_cliente='id_cliente';createWindow('Buscar Cliente',450,310 ,1,false,true);" src="imagenes/popup.png" /></td></tr>                                                           
						</table>
						
					</td>
				</tr>
				<tr><td  height="3px" class="separador"></td></tr>
			</table>
            <br/>
            <table class="datagrid" width="100%" border="0" cellspacing="0">
				<tr><td  height="3px" class="separador"></td></tr>
				<tr class="tabla_columns">
					<td >&nbsp;Total</td>
				</tr>
				<tr>
					<td bgcolor="#FFFFFF">						
						<span style="font-size:18px; font-weight:bold;">$</span><div id="div_total">0.00</div>						
					</td>
				</tr>
				<tr><td  height="3px" class="separador"></td></tr>
			</table>
            <br/>
            <table class="datagrid" width="100%" border="0" cellspacing="0">
				<tr><td  height="3px" class="separador"></td></tr>
				<tr class="tabla_columns">
					<td >&nbsp;Concepto de Cobro</td>
				</tr>
				<tr>
					<td>						
						<table style="color:#000000" border="0" cellpadding="5">
                        	 <tr>
                             	<td width="200px">Concepto</td>
                                <td width="100px">Monto</td>
                                <td width="200px">Promocion</td>
                                <td></td>
                                <td width="200px" align="right">Total</td>
                             </tr>
                             <tr>                             	
                                <td>
                                	<select name="concepto"  onchange="cargarPromocion(this.value,'div_concepto_promocion','div_total_a_0','monto','promocion',0);" style="width:200px; font-size:12px;">
                                    	<option value="null">Elige un Tipo de Ingreso</option>
										<?php
											$query_t_u = "select * from cat_tipo_ingreso";
											$tabla_t_u = mysqli_query($conexion,$query_t_u);
											while($registro_t_u = mysqli_fetch_array($tabla_t_u))
											{
												echo "<option value=\"$registro_t_u[0]\">$registro_t_u[1]</option>";
											}
                                        ?>
                                    </select>
                                </td>                               
                                <td><input type="text" onchange="solo_numeros_decimales(this);calcularTotal('div_total_a_0','monto','promocion');reestableceZero(this);" onkeyup="solo_numeros_decimales(this)" value="0.00" class="monto" id="monto" name="monto" maxlength="13" /></td>
                                <td><div id="div_concepto_promocion">No asignado.</div></td>     
                                <td width='30px' align='right'><span style="font-size:12px; font-weight:bold;">$</span></td>                           
                                <td align="right"><div class="total" id="div_total_a_0">0.00</div></td>                                
                             </tr> 
                             <tr>
                              	<td colspan="7" style="border-bottom:1px solid #DDD;">
                               		<table>
                                    	<tr><td>Nota Impresa (Opcional):</td><td><input type="text" name="nota_impresa" onblur="solo_numeros(this)" onkeyup="solo_numeros(this)" size="10" maxlength="10" /></td></tr>
                                    </table>
                                </td>
                             </tr>                                                          
                             <tr><th colspan="7" align="left">Conceptos Adicionales:</th></tr> 
                             <tr>
                             	<td colspan="7">
                                <div id="div_contenedor_adicionales"></div>
                                <input type="button" value="Agregar Concepto Adicional" style="font-size:12px;" id="agregar_concepto" onclick="agregarConceptoAdicional();"  />
                                </td>
                             </tr>                                                         
						</table>
						
					</td>
				</tr>
				<tr><td  height="3px" class="separador"></td></tr>
			</table>
            <br/>
            <table class="datagrid" width="100%" border="0" cellspacing="0">
				<tr><td  height="3px" class="separador"></td></tr>
				<tr class="tabla_columns">
					<td >&nbsp;Observaciones</td>
				</tr>
				<tr>
					<td align="center">						
						<textarea name="observaciones" cols="50" rows="5" style="width:99%;font-family:Arial, Helvetica, sans-serif; font-size:12px"></textarea>						
					</td>
				</tr>
				<tr><td  height="3px" class="separador"></td></tr>
			</table>
            <input name="accion"  type="hidden" value="agregar" />
			</form>
		</td>
	</tr>
</table>
