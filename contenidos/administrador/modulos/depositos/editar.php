

<script language="javascript" type="text/javascript">
	
	function guardar()
	{
		var cadena = "";
		if(document.formulario.banco.value=='')
			cadena+= "\n* Debe ingresar un Banco.";
		
		if(document.formulario.monto.value=='')
			cadena+= "\n* Debe ingresar un Monto.";
		
		if(document.formulario.fecha.value=='')
			cadena+= "\n* Debe ingresar la Fecha.";	
		
		
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
					  borrar = ''; // Año no viciesto y es febrero y el dia es mayor a 28
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
</script>


<table border="0px"  width="100%" style="color:#000000;font-size:12px">
	<tr>    
    	<td align="right">
        	<table border="0" width="100%" cellpadding="0" cellspacing="0" >
            	<tr>
            	<td width="5px" background="imagenes/module_left.png"></td>
                <td width="70px" background="imagenes/module_center.png" height="80"  valign="middle"><img src="imagenes/depositos.png" /></td>
                <td align="left" background="imagenes/module_center.png" height="80" valign="middle" class="titulo"><b>&nbsp;&nbsp;VER DEPOSITO</b></td>
                <td align="right" background="imagenes/module_center.png" height="80" >
                    <!--<button class="boton2" id="guardar" onclick="guardar()" ><img src="imagenes/guardar.png" /><br/>Guardar</button>-->
					<button class="boton2" onclick="location.href='index.php?menu=16'"><img src="imagenes/back.png" /><br />Regresar</button>
                </td>
                <td width="5px" background="imagenes/module_right.png"></td>
                </tr>
            </table>
        </td>
	</tr>	
    <?php
		if(isset($_GET['id']))
			$id=$_GET['id'];
		else
		{
		
			
			foreach($_POST as $variable => $valor)
			{
				if($variable != "selector")
				{
					if($variable != "accion")
					{
						$id = $variable;
					}
				}
			}
		}
		if(isset($id))
		{
			
			$query = "select id_deposito,
			(select descripcion from cat_bancos where id_banco=d.id_banco),
			(select nombre from sucursales where id_sucursal=(select id_sucursal from empleados where id_empleado=d.id_empleado_deposita)),
			(select concat(nombre,' ',apellido_paterno,' ',apellido_materno) from empleados where id_empleado=d.id_empleado_deposita),
			(select descripcion from estado_transaccion where id_estado_transaccion=d.id_estado_transaccion),
			monto,
			fecha,
			referencia,
			comision_id_egreso
			from depositos d where id_deposito='".addslashes($id)."'";
			$registro = devolverValorQuery($query);
			if($registro[8]!='')
			{
			$query2 = "select id_egreso,
			(select descripcion from cat_tipo_egreso where id_tipo_egreso=e.id_tipo_egreso),
			(select nombre from sucursales where id_sucursal=(select id_sucursal from empleados where id_empleado=e.id_empleado)),
			(select concat(nombre,' ',apellido_paterno,' ',apellido_materno) from empleados where id_empleado=e.id_empleado),
			(select concat(nombre,' ',apellido_paterno,' ',apellido_materno) from clientes where id_cliente=e.id_cliente),
			(select descripcion from estado_transaccion where id_estado_transaccion=e.id_estado_transaccion),
			monto,
			fecha,
			(select descripcion from cat_comprobante where id_comprobante=e.id_comprobante),
			referencia
			id_tipo_egreso
			from egresos e where id_egreso='".addslashes($registro[8])."'";
			$registro2 = devolverValorQuery($query2);
			}
			

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
						
						<table style="color:#000000" cellpadding="5">
                        
                        	<tr>
                        	  <td>Banco:</td><td>
                              <?php
                              echo $registro[1];
								?>
                              </td>
                              </tr>
                              <tr>
                              <td>Sucursal:</td><td>
                              <?php
                              echo $registro[2];
								?>
                              </td></tr>
                              
                              <tr>
                        	  <td>Quien Deposita:</td><td>
                              <?php
                              echo $registro[3];
								?>
                              
                              </td></tr>

                              <tr>
                        	  <!--<td>Responsable Autorizado:</td><td>
                              <?php
                              //echo $registro[4];
								?>
                              </td>--></tr>
                                <!--  -->                                                          
                              <tr>
                        	  <td>Monto:</td><td>
                              <?php
                              echo $registro[5];
								?>
                              </td></tr>
                              
                              <tr>
                        	  <td>Fecha:</td><td>
                              <?php
                              echo $registro[6];
								?> 
                                </td></tr>
                              
                              <tr>
                          		<td>Ficha de deposito:</td><td>
                          			<?php
                              echo $registro[7];
								?>
                            	</td>
                             </tr>                                                             
                             
                             </table>
                   
                                                   
                           </td>
                         </tr>
                     		<tr><td  height="3px" class="separador"></td></tr>                                       
						</table>
					</td>
				</tr>
			</table>
		
<?php
if($registro[8]!=''){
?>

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
                        	  <td>Id del Egreso:</td><td>
                              <?php
                              echo $registro2[0];
								?>
                              </td></tr>
                               
                        	<tr>
                        	  <td>Tipo Egreso:</td><td>
                              <?php
                              echo $registro2[1];
								?>
                              </td></tr>                                                            
                              <tr>
                        	  <td>Sucursal:</td><td>
                              <?php
                              echo $registro2[2];
								?>
                              </td></tr>
                              
                              <tr>
                        	  <td>Quien Solicita el Gasto:</td><td>
                              <?php
                              echo $registro2[3];
								?>
                              </td></tr>
								
                              <?php
							  if($registro2[10]==10){
							  ?>
                              <tr>
                        	  <td>A Quien se le Reembolsara:</td><td>
                              <?php
                              echo $registro2[4];
								?>
                              
                              </td></tr>
                              <?php
							  }
							  ?>
                              <tr>
                        	  <td>Monto:</td><td>
                              <?php
                              echo $registro2[6];
								?>
                              </td></tr>                                                            
                              <tr>
                        	  <td>Fecha:</td><td>
                              <?php
                              echo $registro2[7];
								?>
                              </td></tr>
                              
                              <tr>
                        	  <td>Tipo de comprobante:</td><td>
                              <?php
                              echo $registro2[8];
								?>
                              </td></tr>
                              
                              <tr>
                        	  <td>Referencia de comprobante:</td><td>
                              <?php
                              echo $registro2[9];
								?>
                              </td></tr>                                                            					
                                                                        
						</table>
						
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