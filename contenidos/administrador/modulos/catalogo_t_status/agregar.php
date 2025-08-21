<script type="text/javascript" src="jshash-2.2/md5-min.js"></script>

<script language="javascript" type="text/javascript">
	
	function guardar()
	{
		var cadena = "";
		if(document.formulario.des.value=='')
			cadena+= "\n* Debe asignar una descripcion.";
			
		
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
</script>

<table border="0px"  width="100%" style="color:#000000;font-size:12px">
	<tr>    
    	<td align="right">
        	<table border="0" width="100%" cellpadding="0" cellspacing="0" >
            	<tr>
            	<td width="5px" background="imagenes/module_left.png"></td>
                <td width="70px" background="imagenes/module_center.png" height="80"  valign="middle"><img src="imagenes/bancos.png" /></td>
                <td align="left" background="imagenes/module_center.png" height="80" valign="middle" class="titulo"><b>&nbsp;&nbsp;AGREGAR TIPO DE STATUS</b></td>
                <td align="right" background="imagenes/module_center.png" height="80" >
                    <button class="boton2" onclick="guardar()" ><img src="imagenes/guardar.png" /><br/>Guardar</button>
					<button class="boton2" onclick="location.href='index.php?menu=8'"><img src="imagenes/cancelar.png" /><br />Cancelar</button>
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
						<form name="formulario" method="post" onsubmit="return false;" action="index.php?menu=8">
						<table style="color:#000000" cellpadding="5">
                        	<tr>
                        	  <td>Status</td><td>
                              <?php
                                echo "<select name='status'>";
								//echo "<option value=0>SELECCIONAR...</option>";
								$query="select id_status,descripcion from status";
								$result=mysqli_query($conexion,$query);
								while(list($id,$tipo)=mysqli_fetch_array($result)){
									echo "<option value='$id'>$tipo</option>";
								}	
								echo "</select>";
								?>
                              </td></tr>                 
                              
                              <tr>
                              <td>
                              Descripcion:</td>
                              <td>
                              <input name="des" style="width:200px;font-size:12px;" type="text" maxlength="255" />
                              </td>
                              </tr>                                                   
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

<script language="javascript">
function Inint_AJAX()
	{
	   try { return new ActiveXObject("Msxml2.XMLHTTP");  } catch(e) {} //IE
	   try { return new ActiveXObject("Microsoft.XMLHTTP"); } catch(e) {} //IE
	   try { return new XMLHttpRequest();          } catch(e) {} //Native Javascript
	   alert("XMLHttpRequest no es soportado");
	   return null;
	};
													
	function dochange(src,val1,val2,val3,val4,val5,val6,val7,val8) {	//alert("entra"+src+" "+val+" "+val2);
					
		 var req = Inint_AJAX();
		 req.onreadystatechange = function () { 
			  if (req.readyState==4) {
				   if (req.status==200) {
				   		if(document.getElementById(src)){
						document.getElementById(src).innerHTML=req.responseText; //retuen value
						
						}else if(document.getElementById(src+val1)){
							document.getElementById(src+val1).innerHTML=req.responseText; //retuen value
							
						}
				   } 
			  }
		 };
		 req.open("GET", "contenidos/modulos/catalogo_t_status/soporte_ajax.php?data="+src+"&val1="+val1+"&val2="+val2+"&val3="+val3+"&val4="+val4+"&val5="+val5+"&val6="+val6+"&val7="+val7+"&val8="+val8); //make connection					
		 req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=tis-620"); // set Header
		 req.send(null); //send value
	}
	
	window.onLoad=dochange('status');
		
</script>
