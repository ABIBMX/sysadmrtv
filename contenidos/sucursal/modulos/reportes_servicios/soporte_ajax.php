<?php

	session_start();
	//set IE read from page only not read from cache
	header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	header ("Cache-Control: no-cache, must-revalidate");
	header ("Pragma: no-cache");
    header("content-type: application/x-javascript; charset=iso-8859-1");
//	header("content-type: application/x-javascript; charset=tis-620");	
     
////////////////////////////////////////////////////////////////////////////////////////////////////////////	 
	$seguro = true;
	include("../../../config.php");
	include("../../../conexion.php");
	
////////////////////////////////////////////////////////////////////////////////////////////////////////////	 	
     
	$data = addslashes($_GET['data']);
	$val1 = addslashes($_GET['val1']);
	$val2 = addslashes($_GET['val2']);
	$val3 = addslashes($_GET['val3']);
	$val4 = addslashes($_GET['val4']);
	$diag = addslashes($_GET['diag']);
	$fecha = addslashes($_GET['fecha']);
	
	if($data=="sucursal"){
		echo "<select name='sucursal' onchange=\"dochange('empleado',this.value);dochange('cliente',this.value);\">";
		echo "<option value=0>== SUCURSAL ==</option>";
		$query="select id_sucursal,nombre from sucursales";
		$result=mysqli_query($conexion,$query);
		while(list($id,$tipo)=mysqli_fetch_array($result)){
				if($id==$val1)
				echo "<option value='$id' selected>$tipo</option>";
				else
				echo "<option value='$id'>$tipo</option>";
		}	
		echo "</select>";
	}else if($data=="empleado"){
		echo "<select name='empleado'>";
		echo "<option value=0>== EMPLEADOS ==</option>";
		$query="select id_empleado,concat(nombre,' ',apellido_paterno,' ',apellido_materno) from empleados where id_empleado like '%$val1%'";
		$result=mysqli_query($conexion,$query);
		while(list($id,$tipo)=mysqli_fetch_array($result)){
			if($id==$val2)
				echo "<option value='$id' selected>$tipo</option>";
				else
				echo "<option value='$id'>$tipo</option>";
		}	
		echo "</select>";
	}else if($data=="cliente"){
		echo "<select name='cliente' onchange=\"dochange('ingreso',this.value);\">";
		echo "<option value=0>== CLIENTES ==</option>";
		$query = "select id_cliente,concat(nombre,' ',apellido_paterno,' ',apellido_materno) from clientes where id_sucursal='$val1'";
		$result = mysqli_query($conexion,$query);
		while(list($id,$nombre)=mysqli_fetch_array($result)){
			if($id==$val2)
				echo "<option value='$id' selected>$nombre</option>";
				else
				echo "<option value='$id'>$nombre</option>";
		}
	echo "</select>";
	}else if($data=="ingreso"){
		echo "<select name='ingreso' onchange=\"dochange('tabla',this.value);\">";
		echo "<option value=0>== FOLIOS ==</option>";
		$query = "select distinct(id_ingreso),folio_nota from ingresos where id_cliente like '%$val1%'";
		$result = mysqli_query($conexion,$query);
		while(list($id,$nombre)=mysqli_fetch_array($result)){
			if($id==$val2)
				echo "<option value='$id' selected>$nombre</option>";
				else
				echo "<option value='$id'>$nombre</option>";
		}
	echo "</select>";
	}else if($data=="t_atencion"){
		echo "<select name='t_atencion'\">";
		echo "<option value=0>== TIPO DE ATENCION ==</option>";
		$query = "select id_tipo_atencion,descripcion from cat_tipo_atencion";
		$result = mysqli_query($conexion,$query);
		while(list($id,$nombre)=mysqli_fetch_array($result)){
			if($id==$val1)
				echo "<option value='$id' selected>$nombre</option>";
				else
				echo "<option value='$id'>$nombre</option>";
		}
	echo "</select>";
	}else if($data=="tabla"){
		echo "<table>";
		echo "<tr><td>INGRESO</td><td>MONTO</td></tr>";
		$query = "select (select descripcion from cat_tipo_ingreso where id_tipo_ingreso=mo.id_tipo_ingreso),monto from montos mo where id_ingreso='$val1'";
		$result = mysqli_query($conexion,$query);
		while(list($des,$monto)=mysqli_fetch_array($result)){
			echo "<tr><td>$des</td><td>$monto</td></tr>";
		}
		echo "</table>";
	
	}
	
	
	
	
?>