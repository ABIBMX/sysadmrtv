<?php
	include("../config.php");
	include("../conexion.php");
	
	if(isset($_POST['sucursal']))
	{
		if(isset($_POST['tap']))
		{
			$query = "select id_tap, valor, salidas from tap where eliminado = 0 AND id_sucursal='".addslashes($_POST['sucursal'])."'";
			$tabla = mysqli_query($conexion,$query);
			echo "<select name='tap' style='width:300px;font-size:12px;'><option value='null'>Sin asignar</option>";
			while($registro=mysqli_fetch_array($tabla))
			{
				echo "<option value=\"".$registro[0]."\">".$registro[0]." - ".$registro[1]." - ".$registro[2]."</option>";
			}
			
			echo "</select>";

		}
		else
		{
			$query = "select id_calle,nombre from cat_calles where id_sucursal='".addslashes($_POST['sucursal'])."'";
			$tabla = mysqli_query($conexion,$query);
			echo "<select name='calle' style='width:300px;font-size:12px;'><option value='null'>Seleccione una Calle</option>";
			while($registro=mysqli_fetch_array($tabla))
			{
				echo "<option value=\"".$registro[0]."\">".$registro[1]."</option>";
			}
			
			echo "</select>";
		}
		
	}
	
	if(isset($_POST['cliente']))
	{
		$bandera_si_nombre = false;
		$_POST['cliente'] = addslashes($_POST['cliente']);
		
		if(isset($_POST['s']))
			$add_query = " and id_sucursal='".addslashes($_POST['s'])."'";
		
		$query = "select id_cliente,id_sucursal, concat(nombre,' ',apellido_paterno,' ',apellido_materno) from clientes where (concat(nombre,' ',apellido_paterno,' ',apellido_materno) like '%".addslashes($_POST['cliente'])."%' or id_cliente like '%".addslashes($_POST['cliente'])."%') ".$add_query;
		$tabla = mysqli_query($conexion,$query);
		
		while($registro=mysqli_fetch_array($tabla))
		{
			$bandera = true;
			?>
            	<div><div class="id"><?php echo $registro[0]; ?></div><div class="sucursal"><?php echo $registro[1]; ?></div><div class="nombre"><?php echo $registro[2]; ?></div></div>
            <?php
		}
		if(!$bandera)
		{
			?>
            <div><center>No hay resultados para esta b&uacute;squeda.</center></div>
            <?php
		}
	}
?>