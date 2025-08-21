<?php
	include("../config.php");
	include("../conexion.php");
	
	if(isset($_POST['tipo_ingreso']))
	{
		$query = "select id_promocion,descripcion, porcentaje from promociones where activo=1 and id_tipo_ingreso='".addslashes($_POST['tipo_ingreso'])."'";
		$tabla = mysqli_query($conexion,$query);
		
		if($_POST['adicional']==1)
		{
			$name = "promociones[]";
			$id = $_POST['id_promocion'];
		}
		else
		{
			$name = "promocion";
			$id = "promocion";
		}
		
		$cadena = "<select name='".$name."' id='".$id."' onchange=\"calcularTotal('".$_POST['id_total']."','".$_POST['id_monto']."','".$id."');\" style='width:200px;font-size:12px;'><option value='null'>Seleccione una Promocion</option>";
		$bandera=false;
		while($registro=mysqli_fetch_array($tabla))
		{
			$bandera = true;
			$cadena.= "<option value=\"".$registro[0]."\">".$registro[1]." ".$registro[2]."%</option>";
		}
		$cadena.= "</select>";
		
		if(!$bandera)
			echo "<select name='".$name."' id='".$id."' style='width:200px;font-size:12px;'><option value='null'>No hay promociones</option></select>";
		else
			echo $cadena;
		
	}
	if(isset($_POST['promocion']))
	{
		$query =  "select porcentaje from promociones where id_promocion=".addslashes($_POST['promocion']);
		$registro = devolverValorQuery($query);
		echo $registro[0];
	}
	if(isset($_POST['concepto_add']))
	{
		?>
		<select name="conceptos_add[]" onchange="cargarPromocion(this.value,'<?php echo $_POST['div_promocion']; ?>','<?php echo $_POST['div_total']; ?>','<?php echo $_POST['div_monto']; ?>','<?php echo $_POST['id_promocion']; ?>','<?php echo $_POST['adicional']; ?>');calcularTotal('<?php echo $_POST['div_total']; ?>','<?php echo $_POST['div_monto']; ?>','<?php echo $_POST['id_promocion']; ?>')" style="width:200px; font-size:12px;">
            <option value="null">Elige un Tipo de Ingreso</option>
            <?php
                $query_t_u = "select * from cat_tipo_ingreso";
                $tabla_t_u = mysqli_query($conexion,$query_t_u);
                while($registro_t_u = mysqli_fetch_array($tabla_t_u))
                {
                    echo "<option value=\"$registro_t_u[0]\">$registro_t_u[1]</option>";
                }
            ?>
        </select>
        <?php
	}
?>