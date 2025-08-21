<?php
	include("../config.php");
	include("../conexion.php");
	
	if(isset($_POST['cliente']))
	{
		$query = "select id_ingreso,folio_nota from ingresos where id_cliente='".addslashes($_POST['cliente'])."'";
		$tabla = mysqli_query($conexion,$query);
		echo "<select name='ingreso' style='width:140px;font-size:12px;'><option value='null'>Seleccione una Nota</option>";
		while($registro=mysqli_fetch_array($tabla))
		{
			echo "<option value=\"".$registro[0]."\">".$registro[1]."</option>";
		}
		echo "</select>";
		
	}
?>