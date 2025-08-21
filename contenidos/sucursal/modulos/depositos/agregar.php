
<script language="javascript" type="text/javascript">
	
	var contenedor_empleado = ""; //Se actualiza para saber en que input se coloca la llave del cliente
	var parametro_sucursal_empleado = "";// Se utiliza en caso de que queramos la lista de clientes de una sucursal en especifica
	function cambio_id_empleado(id){
		
		}
	
	function guardar()
	{
		var cadena = "";
		if(document.formulario.banco.value=='null')
			cadena+= "\n* Debe seleccionar un Banco.";
		
		
		if(document.formulario.autorizo_dep)	
		if(document.formulario.autorizo_dep.value=='')
			cadena+= "\n* Debe ingresar el empleado que autorizo del deposito.";
		
		if(document.formulario.autorizado_dep)
		if(document.formulario.autorizado_dep.value=='')
			cadena+= "\n* Debe ingresar el empleado que fue autorizado del deposito.";
			
		if(document.formulario.monto_dep.value=='')
			cadena+= "\n* Debe ingresar un Monto del deposito.";
		
		if(document.formulario.fechas.value=='')
			cadena+= "\n* Debe ingresar la Fecha del deposito.";	
			
		if(document.formulario.id_ref_dep.value=='')
			cadena+= "\n* Debe ingresar la Referencia del deposito.";	
		
		
		if(document.formulario.comision[0].checked){
			if(document.formulario.t_egreso.value=='null')
			cadena+= "\n* Debe seleccionar un tipo de egreso.";
		
		if(document.formulario.autorizo){
		if(document.formulario.autorizo.value=='')
			cadena+= "\n* Debe seleccionar la persona que autorizo el egreso.";
		}
		
		if(document.formulario.autorizado){
		if(document.formulario.autorizado.value=='')
			cadena+= "\n* Debe seleccionar la persona que fue autorizada a realizar el egreso.";
		}
			
		if(document.formulario.monto.value=='')
			cadena+= "\n* Debe ingresar un Monto del egreso.";
			
		if(document.formulario.fecha.value=='')
			cadena+= "\n* Debe ingresar la Fecha del egreso.";	
		
		if(document.formulario.comprobante.value=='null')
			cadena+= "\n* Debe seleccionar un tipo de comprobante del egreso";
			
		if(document.formulario.r_comprobante.value=='')
			cadena+= "\n* Debe ingresar una referencia del comprobante del egreso.";
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
	
	function verificar(valor){
		if(valor==10){
			document.getElementById('text_cli').style.display="block";		
			document.getElementById('campo_cli').style.display="block";		
		}else{
			document.getElementById('text_cli').style.display="none";		
			document.getElementById('campo_cli').style.display="none";		
		}
	}
</script>

<form name="formulario" method="post" onsubmit="return false;" action="index.php?menu=16">
<table border="0px"  width="100%" style="color:#000000;font-size:12px">
	<tr>    
    	<td align="right">
        	<table border="0" width="100%" cellpadding="0" cellspacing="0" >
            	<tr>
            	<td width="5px" background="imagenes/module_left.png"></td>
                <td width="70px" background="imagenes/module_center.png" height="80"  valign="middle"><img src="imagenes/depositos.png" /></td>
                <td align="left" background="imagenes/module_center.png" height="80" valign="middle" class="titulo"><b>&nbsp;&nbsp;AGREGAR DEPOSITO</b></td>
                <td align="right" background="imagenes/module_center.png" height="80" >
                    <button class="boton2" type="button" onclick="guardar()" ><img src="imagenes/guardar.png" /><br/>Guardar</button>
					<button class="boton2" type="button" onclick="location.href='index.php?menu=16'"><img src="imagenes/cancelar.png" /><br />Cancelar</button>
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
						
						<table style="color:#000000" cellpadding="5">
                        	<tr>
                        	  <td>Banco:</td><td>
                              <?php
                              echo "<select name='banco' style='width:300px;font-size:12px;'>";
								echo "<option value='null'>== BANCOS ==</option>";
								$query="select id_banco,descripcion from cat_bancos";
								$result=mysqli_query($conexion,$query);
								while(list($id,$tipo)=mysqli_fetch_array($result)){
										echo "<option value='$id'>$tipo</option>";
								}	
								echo "</select>";
								?>
                              </td>
                              </tr>
                              
                              
                              <tr>
                        	  <td>Quien Deposita:</td><td>
                             <input name="autorizo_dep" id="autorizo_depx" readonly="readonly" style="width:110px;font-size:12px;" type="text" maxlength="12" />&nbsp;<img style="cursor:pointer;position:relative; top:4px;" onclick="contenedor_empleado='autorizo_depx';parametro_sucursal_empleado='<?php echo $_SESSION['tuvision_id_sucursal']; ?>';createWindow('Buscar Empleado',450,310 ,2,false,true);" src="imagenes/popup.png" />
                              
                              </td></tr>

                              <!--<tr>
                        	  <td>Responsable Autorizado:</td><td>
                             <input name="autorizado_dep" id="autorizado_depx" readonly="readonly" style="width:110px;font-size:12px;" type="text" maxlength="12" />&nbsp;<img style="cursor:pointer;position:relative; top:4px;" onclick="contenedor_empleado='autorizado_depx';parametro_sucursal_empleado='<?php //echo $_SESSION['tuvision_id_sucursal'] ?>';createWindow('Buscar Empleado',450,310 ,2,false,true);" src="imagenes/popup.png" />
                              </td></tr>-->
                                <!--  -->                                                          
                              <tr>
                        	  <td>Monto:</td><td><input name="monto_dep" onchange="solo_numeros_decimales(this)" onkeyup="solo_numeros_decimales(this)" style="width:70px;font-size:12px;" type="text" maxlength="255" onblur="solo_numeros_decimales(this);"/></td></tr>
                              
                              <tr>
                        	  <td>Fecha:</td><td><input name="fechas" id="fechas"  style="width:90px;font-size:12px; background-image:url(calendario/imgs/icon_minicalendar.gif); background-position:right center; background-repeat:no-repeat;" type="text" maxlength="10" readonly="readonly" onfocus="calendario(this.id);" />
                          </td></tr>
                              
                              <tr>
                          		<td>Ficha  de deposito:</td><td>
                          			<input name="id_ref_dep" id="id_ref_dep" style="width:70px;font-size:12px;" type="text" maxlength="10" />
                            	</td>
                             </tr>                                                             
                             
                              <tr>
                        	  <td>Comisi&oacute;n por transacci&oacute;n:</td><td>
                              Si<input type="radio" name="comision" id="com" value="1" onclick="egreso(this.value);"/>
                              No<input type="radio" name="comision" id="com" value="2" checked="checked" onclick="egreso(this.value);" />
                              </td></tr>                                                            
                             
                             </table>
                   <input name="accion"  type="hidden" value="agregar" />
                                                   
                           </td>
                         </tr>
                     		<tr><td  height="3px" class="separador"></td></tr>                                       
						</table>
					</td>
				</tr>
			</table>
		
<div id="tabla_egreso" style="display:none;">
<table border="0px"  width="100%" style="color:#000000;font-size:12px">
	   
	<tr>
		<td colspan="3">
			<table class="datagrid" width="100%" border="0" cellspacing="0">
				<tr><td  height="3px" class="separador"></td></tr>
				<tr class="tabla_columns">
					<td >Agregar Egreso</td>
				</tr>
				<tr>
					<td>
						
						<table style="color:#000000" cellpadding="5">
                        
                             
                        	<tr>
                        	  <td>Tipo Egreso:</td><td>
                              <select name="t_egreso" style='width:300px;font-size:12px;' onchange="verificar(this.value);">
                              <option value="null">Seleccione un tipo de egreso</option>
                              	<?php
									$query = "select id_tipo_egreso,descripcion from cat_tipo_egreso where id_tipo_egreso='9'";
									$result = mysqli_query($conexion,$query);
									while(list($id,$des)=mysqli_fetch_array($result)){
										echo "<option value='$id' selected>$des</option>";	
									}
								?>
                              </select>
                              </td></tr>                                                            
                                                           
                             

                              <tr>
                        	  <td>Quien Solicita el Gasto:</td><td>
                              <input name="autorizado" id="autorizadox" readonly="readonly" style="width:110px;font-size:12px;" type="text" maxlength="12" />&nbsp;<img style="cursor:pointer;position:relative; top:4px;" onclick="contenedor_empleado='autorizadox';parametro_sucursal_empleado='<?php echo $_SESSION['tuvision_id_sucursal']; ?>';createWindow('Buscar Empleado',450,310 ,2,false,true);" src="imagenes/popup.png" />
                              
                              </td></tr>
                              
                              <tr>
                              	<td>
                              	<div style="display:none" id="text_cli">
                                A quien se reembolsara:
                                </div>
                              </td>
                              <td>
                              <div style="display:none" id="campo_cli">
                              <input name="id_cliente" id="id_cliente" readonly="readonly" style="width:110px;font-size:12px;" type="text" maxlength="12" />&nbsp;<img style="cursor:pointer;position:relative; top:4px;" onclick="contenedor_cliente='id_cliente';parametro_sucursal_cliente='<?php echo $_SESSION['tuvision_id_sucursal'] ?>';createWindow('Buscar Cliente',450,310 ,1,false,true);" src="imagenes/popup.png" />
                                </div>
                              </td>
                              </tr>
                              
                              <tr>
                        	  <td>Monto:</td><td><input name="monto" onchange="solo_numeros_decimales(this)" onkeyup="solo_numeros_decimales(this)" style="width:70px;font-size:12px;" type="text" maxlength="255" /></td></tr>                                                            
                              <tr>
                        	  <td>Fecha:</td><td><input name="fecha" id="fecha"  style="width:90px;font-size:12px; background-image:url(calendario/imgs/icon_minicalendar.gif); background-position:right center; background-repeat:no-repeat;" type="text" maxlength="10" readonly="readonly" onfocus="calendario(this.id);" /></td></tr>
                              
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
                        	  <td>N&oacute;umero de Autorizaci&oacute;n &oacute; Transacci&oacute;n:</td><td><input name="r_comprobante" style="width:200px;font-size:12px;" type="text" maxlength="255" /></td></tr>                                                            					
                                                                        
						</table>
						
					</td>
				</tr>
				<tr><td  height="3px" class="separador"></td></tr>
			</table>
		</td>
	</tr>
</table>

</div>
</form>
<script language="javascript">
var bandera_calles;
var bandera_numeros;
function _Ajax(id,valor,valor2)
	{
		
		bandera_numeros = false;
		var div_numero = document.getElementById(id);
		if(valor!="null")
		{			
			div_numero.innerHTML = "<img src='imagenes/loading.gif' /> <span style='font-size:10px;'>Cargando ...</span>";
			var cdata = "id="+id+"&valor1="+valor+"&valor2="+valor2;
			$.ajax({
					type: "POST",
					url: "ajaxProcess/deposito.php",
					data: cdata,
					success: function(datos)
					{
						div_numero.innerHTML = datos;	
						bandera_calles = true;
						bandera_numeros = true;
					}
			});
		}
		else
		{
			div_numero.innerHTML = "No Asignado";
		}
	}
	
	function _Ajax_egreso(id,valor1,valor2,valor3,valor4,valor5,valor6,valor7,valor8)
	{
		
		bandera_numeros = false;
		var div_numero = document.getElementById(id);
		if(valor1!="null")
		{			
			div_numero.innerHTML = "<img src='imagenes/loading.gif' /> <span style='font-size:10px;'>Cargando ...</span>";
			var cdata = "id="+id+"&valor1="+valor1+"&valor2="+valor2+"&valor3="+valor3+"&valor4="+valor4+"&valor5="+valor5+"&valor6="+valor6+"&valor7="+valor7+"&valor8="+valor8;
			$.ajax({
					type: "POST",
					url: "ajaxProcess/egresos.php",
					data: cdata,
					success: function(datos)
					{
						
						if(datos!=0){					
								div_numero.innerHTML = datos;	
								document.getElementById('complemento').style.display='block';
								document.getElementById('tabla_egreso').style.display='none';
						}else{
								
						}
						
						bandera_calles = true;
						bandera_numeros = true;
					}
			});
		}
		else
		{
			div_numero.innerHTML = "No Asignado";
		}
	}

function egreso(valor){
	
	switch(valor){
		case '1':
		document.getElementById('tabla_egreso').style.display="block";
		break;
		case '2':
		document.getElementById('tabla_egreso').style.display="none";
		document.formulario.comision[1].checked=true;
		break;
	}
	
	
}

function guardar_egreso(){
	var cadena = "";
		if(document.formulario2.t_egreso.value=='null')
			cadena+= "\n* Debe seleccionar un tipo de egreso.";
		
		if(document.formulario2.sucursal.value=='null')
			cadena+= "\n* Debe seleccionar una sucursal.";
		
		if(document.formulario2.autorizo){
		if(document.formulario2.autorizo.value=='null')
			cadena+= "\n* Debe seleccionar la persona que autorizo el egreso.";
		}else{
			cadena+= "\n* Debe seleccionar la persona que autorizo el egreso.";
		}
		
		if(document.formulario2.autorizado){
		if(document.formulario2.autorizado.value=='null')
			cadena+= "\n* Debe seleccionar la persona que fue autorizada.";
		}else{
			cadena+= "\n* Debe seleccionar la persona que fue autorizada.";
		}
			
		if(document.formulario2.monto.value=='')
			cadena+= "\n* Debe ingresar un Monto.";
			
		if(document.formulario2.fecha.value=='')
			cadena+= "\n* Debe ingresar la Fecha.";	
		
		if(document.formulario2.comprobante.value=='null')
			cadena+= "\n* Debe seleccionar un tipo de comprobante";
			
		if(document.formulario2.r_comprobante.value=='')
			cadena+= "\n* Debe ingresar una referencia del comprobante.";
			
				
		if(cadena == "")
		{
		var t_egreso = document.formulario2.t_egreso.value;
		var sucursal = document.formulario2.sucursal.value;
		var autorizo = document.formulario2.autorizo.value;
		var autorizado = document.formulario2.autorizado.value;
		var monto = document.formulario2.monto.value;
		var fecha = document.formulario2.fecha.value;
		var comprobante = document.formulario2.comprobante.value;
		var r_comprobante = document.formulario2.r_comprobante.value;
		
		_Ajax_egreso('aux_egreso',t_egreso,sucursal,autorizo,autorizado,monto,fecha,comprobante,r_comprobante);
		//_Ajax_egreso('aux_egreso');
		}
		else
			alert("Por favor verifique lo siguiente:"+cadena);
}

</script>

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

