<?php
header("content-type: application/x-javascript; charset=iso-8859-1");

include("../config.php");
include("../conexion.php");

	
	if(isset($_POST['id']))
	{
		$id = filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT);

		
		echo '<select name="canal" id="canal"   style="width:270px; font-size:12px;">
                <option value="-1">Todos</option>';
                
            $query_t_u = "select id_canal,nombre from f_canales where id_proveedor=".$id;
            $tabla_t_u = mysqli_query($conexion,$query_t_u);
            while($registro_t_u = mysqli_fetch_array($tabla_t_u))
            {
                echo "<option value=\"$registro_t_u[0]\">$registro_t_u[1]</option>";
            }
                
        echo '</select>';
		
	}
		
		
?>