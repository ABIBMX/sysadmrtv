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
	
	if($data=="status"){
		echo "<select name='status' onchange=\"dochange('t_status',(this.value));\">";
		echo "<option value=0>SELECCIONAR...</option>";
		$query="select id_status,descripcion from status";
		$result=mysqli_query($conexion,$query);
		while(list($id,$tipo)=mysqli_fetch_array($result)){
			if($val1==$id)
				echo "<option value='$id' selected>$tipo</option>";
			else	
			echo "<option value='$id'>$tipo</option>";
		}	
		echo "</select>";
	}else if($data=="t_status"){
		echo "<select name='t_status' >";
		echo "<option value=0>SELECCIONAR...</option>";
		$query="select id_tipo_status,descripcion from tipo_status where id_status=$val1 order by id_tipo_status";
		$result=mysqli_query($conexion,$query);
		while(list($id,$tipo)=mysqli_fetch_array($result)){
				if($val2==$id)
				echo "<option value='$id' selected>$tipo</option>";
			else	
			echo "<option value='$id'>$tipo</option>";
		}	
		echo "</select>";
	}
	
?>