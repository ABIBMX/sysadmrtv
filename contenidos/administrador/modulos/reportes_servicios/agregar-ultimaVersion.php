<style>
.table{
	border-color:#CCC;
	border-right:solid;
	border-width:1px;
	}
.titulo_izq{
	border-color:#CCC;
	border-right:solid;
	border-bottom:solid;
	border-width:1px;
	font-size:15x;
	font:bold;
}

.titulo_der{
	border-color:#CCC;
	border-right:solid;
	border-bottom:solid;
	border-width:1px;
	font-size:15x;
	font:bold;
}
.resultado{
	
	font-size:18px;
	font:bold;
	
}
.montos{
	border-color:#CCC;
	border-right:solid;
	border-width:1px;
	
	font-size:15x;
	font:bold;
}

</style>

<script language="javascript" type="text/javascript">
	var bandera_numeros=true;
	var count=0;
	function guardar()
	{
		var cadena = "";
		var errores = 0;
		var x = 0;
		
		if(document.formulario.sucursal.value=='null'){
			cadena +="\n Debe de elegir una sucursal";
		}
		
		if(document.formulario.tipo_servicio.value=='null'){
			cadena +="\n Debe de elegir un tipo de servicio";
		}
		
		
		if(document.formulario.id_cliente)
		if(document.formulario.id_cliente.value==''){
			cadena +="\n Debe de elegir un cliente";
		}
		
		if(document.formulario.empleado)
		if(document.formulario.empleado.value=='null'){
			cadena +="\n Debe de elegir un empleado";
		}
		
		if(document.formulario.folio)
		if(document.formulario.folio.value=='null'){
			cadena +="\n Debe de elegir un folio";
		}
		
		
		if(validar_arreglos("servicio[]",1)){
			cadena +="\n Debe de ingresar todos los servicios";
		}
		
		if(document.formulario.ingreso)
		if(document.formulario.ingreso.value=='null'){
			cadena +="\n Debe de elegir un folio";
		}
		
		if(document.getElementById('t_serv')[document.getElementById('t_serv').selectedIndex].value==1){
			if(document.formulario.folio.value!='null'){
				if(!document.getElementById('serviciox')){
					cadena +="\n Este folio no contiene servicio favor de elegir otra nota";	
				}	
			}
		}
		
		if(bandera_numeros==false && cadena==""){
			cadena +="\n Faltan campos por cargar por favor espere un momento";
		}
				
		if(cadena == "" )
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
					url: "ajaxProcess/reporte_servicio.php",
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
	
	function _Ajax2(id,numero,valor)
	{
		bandera_numeros = false;
		var div_numero = document.getElementById(id+numero);
		if(valor!="null")
		{			
			div_numero.innerHTML = "<img src='imagenes/loading.gif' /> <span style='font-size:10px;'>Cargando ...</span>";
			var cdata = "id="+id+"&valor1="+valor;
			$.ajax({
					type: "POST",
					url: "ajaxProcess/reporte_servicio.php",
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
	
	function agregar(){

		if(document.getElementById('services')){

			var tabla_mayor=document.getElementById('services');
			var tbody=document.createElement('tbody');
			var fila=document.createElement('tr');
			fila.id = 'dinamic_' + (++count);
			
			
			var campo1=document.createElement('div');
			var campo2=document.createElement('img');
			
			campo2.src='imagenes/del.png';
			campo2.name = fila.id;
			campo2.onclick = elimCamp;
			
			campo1.id="serv_aux"+count;
			
			var celda=document.createElement('td');
			var celda2=document.createElement('td');
			
			celda.appendChild(campo1);
			celda2.appendChild(campo2);
			
			
			fila.appendChild(celda);
			fila.appendChild(celda2);
	   
		   tbody.appendChild(fila);	
		   tabla_mayor.appendChild(tbody);
		   _Ajax2('serv_aux',count,document.getElementById('t_serv')[document.getElementById('t_serv').selectedIndex].value);
		}
	   
	}
	
	evento = function (evt)
	{ //esta funcion nos devuelve el tipo de evento disparado
	   return (!evt) ? event : evt;
	}

	elimCamp = function(evt)
	{
		evt = evento(evt);
	   nCampo = rObj(evt);
	  

	   div_eliminar = document.getElementById(nCampo.name);
	   div_eliminar.parentNode.removeChild(div_eliminar);
	}
	
	rObj = function (evt)
	{ 
		return evt.srcElement ?  evt.srcElement : evt.target;
	}
	
	function crea_nota(){
		if(document.getElementById('id_cliente')){
			if(document.getElementById('t_serv')[document.getElementById('t_serv').selectedIndex].value==1){
				_Ajax('nota',document.getElementById('id_cliente').value);	
			}else{
				_Ajax('nota');	
			}	
		}else{
			document.getElementById('nota').innerHTML = "<span>Seleccione 'nota' en tipo de servicio y un cliente</span>";	
		}		
	}
	
	var contenedor_empleado = ""; //Se actualiza para saber en que input se coloca la llave del cliente
	var contenedor_cliente = ""; //Se actualiza para saber en que input se coloca la llave del cliente
	var parametro_sucursal_empleado = "";// Se utiliza en caso de que queramos la lista de clientes de una sucursal en especifica
	var parametro_sucursal_cliente = "";// Se utiliza en caso de que queramos la lista de clientes de una sucursal en especifica
	function cambio_id_empleado(id){
		
		}
		
	function cambio_id_cliente(id){	
		crea_nota();
		if(document.getElementById('t_serv')[document.getElementById('t_serv').selectedIndex].value){
			_Ajax('servicio',document.getElementById('t_serv')[document.getElementById('t_serv').selectedIndex].value);	
		}
		
	}
	
	function validar_arreglos(id,tipo){

	var campo = document.getElementsByName(id);
	var counter = 0;
	if(campo){
		for (var i = 0; i < campo.length; i++) {
			if(tipo==1){
				if (campo[i][campo[i].selectedIndex].value=='null') {
					counter++;
				}
			}else if(tipo==2){
				if (campo[i].value=='') {
					counter++;
				}
			}
		}

		
		if(counter==0)
			return false;
		else if(counter!=0)
			return true;
			
	}else{
		return false;
	}
}
</script>

<table border="0px"  width="100%" style="color:#000000;font-size:12px">
	<tr>    
    	<td align="right">
        	<table border="0" width="100%" cellpadding="0" cellspacing="0" >
            	<tr>
            	<td width="5px" background="imagenes/module_left.png"></td>
                <td width="70px" background="imagenes/module_center.png" height="80"  valign="middle"><img src="imagenes/reportes_servicios.png" /></td>
                <td align="left" background="imagenes/module_center.png" height="80" valign="middle" class="titulo"><b>&nbsp;&nbsp;AGREGAR REPORTE DE SERVICIO</b></td>
                <td align="right" background="imagenes/module_center.png" height="80" >
                    <button class="boton2" onclick="guardar()" ><img src="imagenes/guardar.png" /><br/>Guardar</button>
					<button class="boton2" onclick="location.href='index.php?menu=18'"><img src="imagenes/cancelar.png" /><br />Cancelar</button>
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
						<form name="formulario" method="post" onsubmit="return false;" action="index.php?menu=18">
						<table style="color:#000000" cellpadding="5">
                        	
                            <tr>
                        	  <td>Fecha de reporte:</td><td><input name="fecha" style="width:200px;font-size:12px;" type="text" maxlength="255" value="<?php echo date("Y-m-d"); ?>" readonly="readonly"/></td></tr>					
                              
                            <tr>
                        	  <td >Sucursal:</td><td>
                              <select name="sucursal" onchange="_Ajax('clientes',this.value);crea_nota(document.getElementById('t_serv').value,this.value);_Ajax('servicio',document.getElementById('t_serv')[document.getElementById('t_serv').selectedIndex].value);" style="width:300px; font-size:12px;">
                                    	<option value="null">Elige una Sucursal</option>
										<?php
											$query_t_u = "select * from sucursales order by id_sucursal asc";
											$tabla_t_u = mysqli_query($conexion,$query_t_u);
											while($registro_t_u = mysqli_fetch_array($tabla_t_u))
											{
												echo "<option value=\"$registro_t_u[0]\">$registro_t_u[0] - $registro_t_u[1]</option>";
											}
                                        ?>
                                    </select>
                              </td></tr>
                              
                              <tr>
                        	  <td>Responsable:</td><td>
                              <input name="empleado" id="autorizox" readonly="readonly" style="width:110px;font-size:12px;" type="text" maxlength="12" value="<?php echo $_SESSION['tuvision_id_empleado']; ?>" />
                              </td></tr>
                               
                               <tr>
                        	  <td>Cliente:</td><td>
                              <div id="clientes">Seleccione una sucursal</div>
                              
                              </td></tr>
                              
                              <tr>
                              	<td>Tipo de servicio:</td>
                                	<td>
                                        <select name="tipo_servicio" id="t_serv" style="width:300px; font-size:12px;" onchange="_Ajax('servicio',this.value);crea_nota();">
                                            <option value="null">Tipo de servicio</option>
                                            <?php
                                                $query_t_u = "select * from cat_peticion_servicio order by id_peticion asc";
                                                $tabla_t_u = mysqli_query($conexion,$query_t_u);
                                                while($registro_t_u = mysqli_fetch_array($tabla_t_u))
                                                {
                                                    echo "<option value=\"$registro_t_u[0]\">$registro_t_u[1]</option>";
                                                }
                                            ?>
                                        </select>
                                 	</td>
                              </tr>
                                                            
                              <tr>
                        	  <td>N&uacute;mero de nota:</td><td>
                              <div id="nota">Seleccione "nota" en tipo de servicio y un cliente</div>
                              
                              </td></tr>
                                
						</table>
						<input name="accion" type="hidden" value="agregar" />
                        
                        <table class="datagrid" width="100%" border="0" cellspacing="0">
                        	<tr>
                            	<td  height="3px" class="separador"></td></tr>
                            <tr class="tabla_columns">
                            	<td >SERVICIOS</td>
                            </tr>
                        	<tr>
                            	<td>
                                	<div id="servicio">
                                    No asigado
                                    </div>
                                    
									
                                </td>
                             </tr>
                             <tr><td  height="3px" class="separador"></td></tr>
                        </table>    
			
						</form>
					</td>
				</tr>
				<tr><td  height="3px" class="separador"></td></tr>
			</table>
		</td>
	</tr>
</table>



