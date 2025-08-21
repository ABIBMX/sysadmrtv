<?php
header("content-type: application/x-javascript; charset=iso-8859-1");

include("../config.php");
include("../conexion.php");

	$data = addslashes($_POST['id']);
	$val1 = addslashes($_POST['valor1']);
	$val2 = addslashes($_POST['valor2']);
	$val3 = addslashes($_POST['valor3']);
	$val4 = addslashes($_POST['valor4']);
	
	if($data=="autorizo"){
		
		?>
        
		<input name="autorizo" id="autorizox" readonly="readonly" style="width:110px;font-size:12px;" type="text" maxlength="12" />&nbsp;<img style="cursor:pointer;position:relative; top:4px;" onclick="contenedor_empleado='autorizox';parametro_sucursal_empleado=document.formulario.sucursal[document.formulario.sucursal.selectedIndex].value;createWindow('Buscar Empleado',450,310 ,2,false,true);" src="imagenes/popup.png" />
        <?php
		
	}else if($data=="autorizado"){
		
	?>
        
		<input name="autorizado" id="autorizadox" readonly="readonly" style="width:110px;font-size:12px;" type="text" maxlength="12" />&nbsp;<img style="cursor:pointer;position:relative; top:4px;" onclick="contenedor_empleado='autorizadox';parametro_sucursal_empleado=document.formulario.sucursal[document.formulario.sucursal.selectedIndex].value;createWindow('Buscar Empleado',450,310 ,2,false,true);" src="imagenes/popup.png" />
        <?php
		}else if($data=="campo_cli"){
			
		if($val1==10 && $val2!='null'){
	?>
        
		<input name="id_cliente" id="id_cliente" readonly="readonly" style="width:110px;font-size:12px;" type="text" maxlength="12" />&nbsp;<img style="cursor:pointer;position:relative; top:4px;" onclick="contenedor_cliente='id_cliente';parametro_sucursal_cliente=document.formulario.sucursal[document.formulario.sucursal.selectedIndex].value;createWindow('Buscar cliente',450,310 ,1,false,true);" src="imagenes/popup.png" />
        <?php
		}
		}
		else if($data=="text_cli"){
			if($val1==10 && $val2!='null'){
			echo "A quien se reembolsara:";
			}
		
		}
		
		
?>