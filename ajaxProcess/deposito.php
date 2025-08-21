<?php
header("content-type: application/x-javascript; charset=iso-8859-1");

include("../config.php");
include("../conexion.php");

	$data = addslashes($_POST['id']);
	$val1 = addslashes($_POST['valor1']);
	$val2 = addslashes($_POST['valor2']);
	$val3 = addslashes($_POST['valor3']);
	$val4 = addslashes($_POST['valor4']);
	$val5 = addslashes($_POST['valor5']);
	$val6 = addslashes($_POST['valor6']);
	$val7 = addslashes($_POST['valor7']);
	$val8 = addslashes($_POST['valor8']);
	
	if($data=="autorizo_dep"){
		/*$query="select id_empleado,concat(nombre,' ',apellido_paterno,' ',apellido_materno) from empleados where id_sucursal='$val1'";
		echo "<select name='autorizo_dep' style='width:300px; font-size:12px;'>";
		echo "<option value='null'> Seleccione un empleado </option>";
		
		$result=mysqli_query($conexion,$query);
		while(list($id,$tipo)=mysqli_fetch_array($result)){
			if($id==$val2)
				echo "<option value='$id' selected>$tipo</option>";
				else
				echo "<option value='$id'>$tipo</option>";
		}	
		echo "</select>";*/
		
		?>
        
		<input name="autorizo_dep" id="autorizo_depx" readonly="readonly" style="width:110px;font-size:12px;" type="text" maxlength="12" />&nbsp;<img style="cursor:pointer;position:relative; top:4px;" onclick="contenedor_empleado='autorizo_depx';parametro_sucursal_empleado=document.formulario.sucursal_dep[document.formulario.sucursal_dep.selectedIndex].value;createWindow('Buscar Empleado',450,310 ,2,false,true);" src="imagenes/popup.png" />
        <?php
		
	}else if($data=="autorizado_dep"){
		/*$query="select id_empleado,concat(nombre,' ',apellido_paterno,' ',apellido_materno) from empleados where id_sucursal='$val1'";
		echo "<select name='autorizado_dep' style='width:300px; font-size:12px;'>";
		echo "<option value='null'> Seleccione un empleado </option>";
		
		$result=mysqli_query($conexion,$query);
		while(list($id,$tipo)=mysqli_fetch_array($result)){
			if($id==$val2)
				echo "<option value='$id' selected>$tipo</option>";
				else
				echo "<option value='$id'>$tipo</option>";
		}	
		echo "</select>";*/
		?>
        
		<input name="autorizado_dep" id="autorizado_depx" readonly="readonly" style="width:110px;font-size:12px;" type="text" maxlength="12" />&nbsp;<img style="cursor:pointer;position:relative; top:4px;" onclick="contenedor_empleado='autorizado_depx';parametro_sucursal_empleado=document.formulario.sucursal_dep[document.formulario.sucursal_dep.selectedIndex].value;createWindow('Buscar Empleado',450,310 ,2,false,true);" src="imagenes/popup.png" />
        <?php
	}
?>