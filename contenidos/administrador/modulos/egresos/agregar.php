
<script language="javascript" type="text/javascript">
	
	var contenedor_empleado = ""; //Se actualiza para saber en que input se coloca la llave del cliente
	var contenedor_cliente = ""; //Se actualiza para saber en que input se coloca la llave del cliente
	var parametro_sucursal_empleado = "";// Se utiliza en caso de que queramos la lista de clientes de una sucursal en especifica
	var parametro_sucursal_cliente = "";// Se utiliza en caso de que queramos la lista de clientes de una sucursal en especifica
	function cambio_id_empleado(id){
		
		}
		
		function cambio_id_cliente(id){
		
		}
	
	function guardar()
	{
		var cadena = "";
		if(document.formulario.t_egreso.value=='null')
			cadena+= "\n* Debe seleccionar un tipo de egreso.";
		
		if(document.formulario.sucursal.value=='null')
			cadena+= "\n* Debe seleccionar una sucursal.";
		
			if(document.formulario.autorizado.value=='')
			cadena+= "\n* Debe seleccionar la persona que fue autorizada.";
		
		
		if(document.formulario.id_cliente && document.formulario.t_egreso.value==10)
		if(document.formulario.id_cliente.value=='')
			cadena+= "\n* Debe seleccionar la persona que se le reembolsara su dinero.";
			
		if(document.formulario.monto.value=='')
			cadena+= "\n* Debe ingresar un Monto.";
			
		if(document.formulario.fecha.value=='')
			cadena+= "\n* Debe ingresar la Fecha.";	
		
		if(document.formulario.comprobante.value=='null')
			cadena+= "\n* Debe seleccionar un tipo de comprobante";
			
		if(document.formulario.r_comprobante.value=='')
			cadena+= "\n* Debe ingresar una referencia del comprobante.";
			
				
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
	function fechas(caja)
	{ 
		
	   if (caja.value)
	   {  
		  borrar = caja.value;
		  if ((caja.value.substr(4,1) == "-") && (caja.value.substr(7,1) == "-"))
		  {    			
			 if (borrar)
			 { 
				a = caja.value.substr(0,4);
				m = caja.value.substr(5,2);
				d = caja.value.substr(8,2);
				if((a < 1900) || (a > 2050) || (m < 1) || (m > 12) || (d < 1) || (d > 31))
				   borrar = '';
				else
				{
				   if((a%4 != 0) && (m == 2) && (d > 28))	   
					  borrar = ''; // A�o no viciesto y es febrero y el dia es mayor a 28
				   else	
				   {
					  if ((((m == 4) || (m == 6) || (m == 9) || (m==11)) && (d>30)) || ((m==2) && (d>29)))
						 borrar = '';	      				  	 
				   }
				}
			 }
		  }		    			
		  else
			 borrar = '';
		  if (borrar == '')
		  {
			 alert('Fecha erronea');
			 caja.value = borrar;
		   }
	   }  
	}
	
	function _Ajax(id,valor,valor2)
	{
		//alert(id+ " "+valor+" "+valor2 );
		
		bandera_numeros = false;
		var div_numero = document.getElementById(id);
		if(valor)
		{			
			div_numero.innerHTML = "<img src='imagenes/loading.gif' /> <span style='font-size:10px;'>Cargando ...</span>";
			var cdata = "id="+id+"&valor1="+valor+"&valor2="+valor2;
			$.ajax({
					type: "POST",
					url: "ajaxProcess/egresos.php",
					data: cdata,
					success: function(datos)
					{
						div_numero.innerHTML = datos;	
						bandera_calles = true;
						bandera_numeros = true;
					}
			});
		}
		
	}
	
	
	function cambiar(valor1, valor2){
		//alert("valor 1 "+valor1+" valor 2 "+valor2);
		_Ajax('text_cli',valor1,valor2);
		_Ajax('campo_cli',valor1,valor2);
	}
	/*function verificar(valor){
		if(valor==10){
			document.getElementById('text_cli').style.display="block";		
			document.getElementById('campo_cli').style.display="block";		
		}else{
			document.getElementById('text_cli').style.display="none";		
			document.getElementById('campo_cli').style.display="none";		
		}
	}*/
</script>

<table border="0px"  width="100%" style="color:#000000;font-size:12px">
	<tr>    
    	<td align="right">
        	<table border="0" width="100%" cellpadding="0" cellspacing="0" >
            	<tr>
            	<td width="5px" background="imagenes/module_left.png"></td>
                <td width="70px" background="imagenes/module_center.png" height="80"  valign="middle"><img src="imagenes/egresos.png" /></td>
                <td align="left" background="imagenes/module_center.png" height="80" valign="middle" class="titulo"><b>&nbsp;&nbsp;AGREGAR EGRESO</b></td>
                <td align="right" background="imagenes/module_center.png" height="80" >
                    <button class="boton2" onclick="guardar()" ><img src="imagenes/guardar.png" /><br/>Guardar</button>
					<button class="boton2" onclick="location.href='index.php?menu=11'"><img src="imagenes/cancelar.png" /><br />Cancelar</button>
                </td>
                <td width="5px" background="imagenes/module_right.png"></td>
                </tr>
            </table>
        </td>
	</tr>
    <tr><td height="10px"></td></tr>
	<tr>
		<td colspan="3">
			<table class="datagrid" width="100%" border="0" cellspacing="0">
				<tr><td  height="3px" class="separador"></td></tr>
				<tr class="tabla_columns">
					<td >Detalles</td>
				</tr>
				<tr>
					<td>
						<form name="formulario" method="post" onsubmit="return false;" action="index.php?menu=11">
						<table style="color:#000000" cellpadding="5">
                        	<tr>
                        	  <td>Tipo Egreso:</td><td>
                              <select name="t_egreso" id="t_egreso" style='width:300px;font-size:12px;' onchange="cambiar(this.value, document.getElementById('id_sucur').value);">
                              <option value="null">Seleccione un tipo de egreso</option>
                              	<?php
									$query = "select id_tipo_egreso,descripcion from cat_tipo_egreso";
									$result = mysqli_query($conexion,$query);
									while(list($id,$des)=mysqli_fetch_array($result)){
										echo "<option value='$id'>$des</option>";	
									}
								?>
                              </select>
                              </td></tr>                                                            
                              <tr>
                        	  <td>Sucursal:</td><td>
                              <select name="sucursal" id="id_sucur" onchange="_Ajax('autorizado',this.value);cambiar(document.getElementById('t_egreso').value,this.value);" style='width:300px;font-size:12px;'>
                              <option value="null">Seleccione una sucursal</option>
                              	<?php
									$query = "select id_sucursal,nombre from sucursales";
									$result = mysqli_query($conexion,$query);
									while(list($id,$nombre)=mysqli_fetch_array($result)){
										echo "<option value='$id'>$nombre</option>";	
									}
								?>
                              </select>
                              </td></tr>
                              
                              

                              <tr>
                        	  <td>Quien Solicita el Gasto:</td><td>
                              <div id="autorizado">
                              	<span>Debe de seleccionar una sucursal</span>
                              </div>
                              
                              </td></tr>
                              <tr>
                              	<td>
                              	<div id="text_cli">
                                
                                </div>
                              </td>
                              <td>
                              <div id="campo_cli">
                              
                                </div>
                              </td>
                              </tr>
                              <tr>
                        	  <td>Monto:</td><td><input name="monto" onchange="solo_numeros_decimales(this)" onkeyup="solo_numeros_decimales(this)" style="width:70px;font-size:12px;" type="text" maxlength="255" /></td></tr>                                                            
                              <tr>
                        	  <td>Fecha:</td><td>
                              <input name="fecha" id="fecha"  style="width:90px;font-size:12px; background-image:url(calendario/imgs/icon_minicalendar.gif); background-position:right center; background-repeat:no-repeat;" type="text" maxlength="10" readonly="readonly" />
                             
                              
                              <tr>
                        	  <td>Tipo de comprobante:</td><td>
                              <select name="comprobante" style='width:300px;font-size:12px;'>
                              <option value="null">Seleccione un tipo de comprobante</option>
                              	<?php
									$query = "select id_comprobante,descripcion from cat_comprobante";
									$result = mysqli_query($conexion,$query);
									while(list($id,$des)=mysqli_fetch_array($result)){
										echo "<option value='$id'>$des</option>";	
									}
								?>
                              </select>
                              </td></tr>
                              
                              <tr>
                        	  <td>N&uacute;mero de Autorizaci&oacute;n &oacute; Transacci&oacute;n:</td><td><input name="r_comprobante" style="width:200px;font-size:12px;" type="text" maxlength="255" /></td></tr>                                                            					
                                                                        
						</table>
						<input name="accion"  type="hidden" value="agregar" />
						</form>
					</td>
				</tr>
				<tr><td  height="3px" class="separador"></td></tr>
			</table>
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
	
    cal1 = new dhtmlxCalendarObject('fecha');
	cal1.setSkin('dhx_skyblue');
	
}
</script>