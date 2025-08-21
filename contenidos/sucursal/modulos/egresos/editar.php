<style>
.letras{
	font-size:16px;
	font:bold;
}
		
</style>

<script language="javascript" type="text/javascript">
	
	function guardar()
	{
		var cadena = "";
		if(document.formulario.t_egreso.value=='null')
			cadena+= "\n* Debe seleccionar un tipo de egreso.";
		
			
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
		
		bandera_numeros = false;
		var div_numero = document.getElementById(id);
		if(valor!="null")
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
		else
		{
			div_numero.innerHTML = "No Asignado";
		}
	}
</script>

<table border="0px"  width="100%" style="color:#000000;font-size:12px">
	<tr>    
    	<td align="right">
        	<table border="0" width="100%" cellpadding="0" cellspacing="0" >
            	<tr>
            	<td width="5px" background="imagenes/module_left.png"></td>
                <td width="70px" background="imagenes/module_center.png" height="80"  valign="middle"><img src="imagenes/egresos.png" /></td>
                <td align="left" background="imagenes/module_center.png" height="80" valign="middle" class="titulo"><b>&nbsp;&nbsp;EDITAR EGRESO</b></td>
                <td align="right" background="imagenes/module_center.png" height="80" >
                    <!--<button class="boton2" id="guardar" onclick="guardar()" ><img src="imagenes/guardar.png" /><br/>Guardar</button>-->
					<!--<button class="boton2" onclick="location.href='index.php?menu=11'"><img src="imagenes/cancelar.png" /><br />Cancelar</button>-->
                    <button class="boton2" onclick="location.href='index.php?menu=11'"><img src="imagenes/back.png" /><br />Regresar</button>
                </td>
                <td width="5px" background="imagenes/module_right.png"></td>
                </tr>
            </table>
        </td>
	</tr>	
    <?php
		if(isset($_GET['id']))
			$id=$_GET['id'];
			
			
		foreach($_POST as $variable => $valor)
					{
						if(is_numeric($variable))
						$id = $variable;
					}
				
			
		
		if(isset($id))
		{
			$query = "select 
			id_egreso,
			(select descripcion from cat_tipo_egreso where id_tipo_egreso=e.id_tipo_egreso),
			(select nombre from sucursales where id_sucursal = (select id_sucursal from empleados where id_empleado=e.id_empleado)),
			(select nombre from empleados where id_empleado=e.id_empleado),
			(select concat(nombre,' ',apellido_paterno,' ',apellido_materno) from empleados where id_empleado=e.id_empleado),
			(select concat(nombre,' ',apellido_paterno,' ',apellido_materno) from clientes where id_cliente=e.id_cliente),
			monto,
			fecha,
			(select descripcion from cat_comprobante where id_comprobante=e.id_comprobante),
			referencia,
			id_tipo_egreso
			from egresos e where id_egreso='".addslashes($id)."' and id_empleado in (select id_empleado from empleados where id_sucursal='".$_SESSION['tuvision_id_sucursal']."')";
			//$query = "select 	id_tipo_egreso,(select id_sucursal from empleados where id_empleado=e.id_empleado),id_empleado_autorizo,id_empleado,monto,fecha,id_comprobante,referencia from egresos e where id_egreso='".addslashes($id)."'";
			$registro = devolverValorQuery($query);
			if($registro[0]!='')
			{

	?>
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
                        <input type="hidden" name="id" value="<?php echo addslashes($id); ?>" />
						<table style="color:#000000" cellpadding="5">
                        <tr>
                        	  <td>Id Egreso:</td><td class="letras">
                               <?php 
							  echo $registro[0];
							  ?>
                              </td>
                        </tr>
                        <tr>
                        	  <td>Tipo Egreso:</td><td class="letras">
                              <?php 
							  echo $registro[1];
							  ?>
                             <!-- <select name="t_egreso" style='width:300px;font-size:12px;'>
                              <option value="null">Seleccione un tipo de egreso</option>
                              	<?php
									/*$query = "select id_tipo_egreso,descripcion from cat_tipo_egreso";
									$result = mysqli_query($conexion,$query);
									while(list($id,$des)=mysqli_fetch_array($result)){
										if($id==$registro[0])
										echo "<option value='$id' selected>$des</option>";	
										else
										echo "<option value='$id'>$des</option>";	
									}*/
								?>
                              </select>-->
                              </td></tr>
                              
                               
                              <!--<select name="sucursal" onchange="_Ajax('autorizo',this.value);_Ajax('autorizado',this.value);"  style='width:300px;font-size:12px;'>
                              <option value="null">Seleccione una sucursal</option>
                              	<?php
							/*		$query = "select id_sucursal,nombre from sucursales";
									$result = mysqli_query($conexion,$query);
									while(list($id,$nombre)=mysqli_fetch_array($result)){
										if($id==$registro[1])
										echo "<option value='$id' selected>$nombre</option>";	
										else
										echo "<option value='$id'>$nombre</option>";	
									}*/
								?>
                              </select>-->
                              
                                                                                          
                              <tr>
                        	  <td>Quien Autoriza:</td><td  class="letras">
                               <?php 
							  echo $registro[4];
							  ?>
                              <div id="autorizo">
                              
                              <!--<select name="autorizo"  style='width:300px;font-size:12px;'>
                              <option value="null">Seleccione un empleado</option>
                              	<?php
                                /*
								
									$query = "select id_empleado,concat(nombre,' ',apellido_paterno,' ',apellido_materno) from empleados where id_sucursal ='".$registro[1]."'";
									$result = mysqli_query($conexion,$query);
									while(list($id,$nombre)=mysqli_fetch_array($result)){
										if($id==$registro[2])
										echo "<option value='$id' selected>$nombre</option>";	
										else
										echo "<option value='$id'>$nombre</option>";		
									}*/
								?>
                              </select>-->
                              </div>
                              </td></tr>
							<?php
							if($registro[10]==10){
							?>
                            
                            <tr>
                              	<td>
                            
                                A quien se reembolsara:
                            
                              </td>
                              <td class="letras">
                              
                              <?php
							  echo $registro[5];
							  ?>
                              </td>
                              </tr>
                            <?php
							}
							?>
                              
                              
                              <tr>
                        	  <td>Monto:</td><td  class="letras">
                               <?php 
								echo $registro[6];
							  ?>
                              <!--<input name="monto" onchange="solo_numeros_decimales(this)" onkeyup="solo_numeros_decimales(this)" style="width:70px;font-size:12px;" type="text" maxlength="255" value="<?php // echo $registro[4]; ?>" />--></td></tr>                                                            
                              <tr>
                        	  <td>Fecha:</td><td class="letras">
                               <?php 
							  echo $registro[7];
							  ?>
                              <!--<input name="fecha" onchange="fechas(this)"style="width:70px;font-size:12px;" type="text" maxlength="10"  value="<?php //echo $registro[5]; ?>" /> <span style="font-size: 10px;">AAAA-MM-DD</span>--></td></tr>
                              
                              <tr>
                        	  <td>Tipo de comprobante:</td><td class="letras">
                               <?php 
							  echo $registro[8];
							  ?>
                              <!--<select name="comprobante"  style='width:300px;font-size:12px;'>
                              <option value="null">Seleccione un tipo de comprobante</option>
                              	<?php
									/*$query = "select id_comprobante,descripcion from cat_comprobante";
									$result = mysqli_query($conexion,$query);
									while(list($id,$des)=mysqli_fetch_array($result)){
										if($id==$registro[6])
										echo "<option value='$id' selected>$des</option>";	
										else
										echo "<option value='$id'>$des</option>";		
									}*/
								?>
                              </select>-->
                              </td></tr>
                              
                              <tr>
                        	  <td>N&uacute;mero de Autorizaci&oacute;n &oacute; Transacci&oacute;n:</td><td class="letras">
                               <?php 
							  echo $registro[9];
							  ?>
                              <!--<input name="r_comprobante" style="width:200px;font-size:12px;" type="text" maxlength="255"  value="<?php //echo $registro[7]; ?>" />--></td></tr>                                                 
						</table>
						<input name="accion"  type="hidden" value="editar" />
						</form>
					</td>
				</tr>
				<tr><td  height="3px" class="separador"></td></tr>
			</table>
		</td>
	</tr>
</table>
<?php
	}
}
?>