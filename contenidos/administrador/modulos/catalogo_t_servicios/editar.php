<script type="text/javascript" src="jshash-2.2/md5-min.js"></script>
<script language="javascript" type="text/javascript">
	
	function guardar()
	{
		var cadena = "";
		if(document.formulario.nombre.value=='')
			cadena+= "\n* Debe asignar un nombre.";
			
		
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
                <td align="left" background="imagenes/module_center.png" height="80" valign="middle" class="titulo"><b>&nbsp;&nbsp;EDITAR TIPO DE SERVICIO</b></td>
                <td align="right" background="imagenes/module_center.png" height="80" >
                    <button class="boton2" id="guardar" onclick="guardar()" ><img src="imagenes/guardar.png" /><br/>Guardar</button>
					<button class="boton2" onclick="location.href='index.php?menu=7'"><img src="imagenes/cancelar.png" /><br />Cancelar</button>
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
			
			$query = "select * from cat_tipo_servicio where id_tipo_servicio='".addslashes($id)."'";
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
						<form name="formulario" method="post" onsubmit="return false;"  action="index.php?menu=7">
						<table style="color:#000000" cellpadding="5">
                        	<tr>
                        	  <td>Tipo de Servicio</td><td><input name="nombre" style="width:200px" type="text" maxlength="255" value="<?php echo $registro[1]; ?>" /></td></tr>                        </table>
						<input name="accion"  type="hidden" value="editar" />
						<input name="id"  type="hidden" value="<?php echo $id; ?>" />
						</form>						
					</td>
				</tr>
				<tr><td  height="3px" class="separador"></td></tr>
			</table>
		</td>
	</tr>
    <?php
			}
			else
			{
				?>
				<script>
					var variable = document.getElementById("guardar");
					variable.disabled=true;
					variable.style.display= "none";
				</script>
                <tr>
                    <td colspan="3" align="center">
                        <table border="0" width="100%" cellpadding="0" cellspacing="0" >
                            <tr>                                    	
                                <td width="5px" background="imagenes/message_error_left.png"></td>
                                <td align="center" background="imagenes/message_error_center.png" height="30" valign="middle" class="warning">El registro que desea editar no existe.</td>
                                <td width="5px" background="imagenes/message_error_right.png"></td>
                            </tr>
                        </table>
                    </td>
                </tr>
				<?php
			}
		}
		else
		{
			?>
			<script>
					var variable = document.getElementById("guardar");
					variable.disabled=true;
					variable.style.display= "none";
			</script>
			<tr>
                    <td colspan="3" align="center">
                        <table border="0" width="100%" cellpadding="0" cellspacing="0" >
                            <tr>                                    	
                                <td width="5px" background="imagenes/message_error_left.png"></td>
                                <td align="center" background="imagenes/message_error_center.png" height="30" valign="middle" class="warning">No se puede editar este registro.</td>
                                <td width="5px" background="imagenes/message_error_right.png"></td>
                            </tr>
                        </table>
                    </td>
                </tr>
			<?php
		}
	?>
</table>
