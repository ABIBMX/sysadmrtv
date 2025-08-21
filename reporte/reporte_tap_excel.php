<?php
	session_start();
	header("Content-Type: application/vnd.ms-excel");
	header("Content-disposition: attachment;filename=Reporte_tap_".date("Y/m/d").".xls");
	header("Pragma: no-cache");
	header("Expires: 0");

	require_once('../config.php');
	require_once('../conexion.php');

	
		?>
        <table border="0" cellspacing="0" cellpadding="0">
        	<tr>
            	<td colspan="7"><b>Reporte de TAP</b> Generado:&nbsp;<?php echo date("Y/m/d"); ?></td>
           	</tr>            
        </table>
         <br />
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
        	<tr bgcolor="#CCCCCC">
            	 <td>ID TAP</td>               
                <td>Sucursal</td>
                <td>Calle</td>
                <td>Poste #</td>
                <td>Tipo de Poste</td>
                <td>Trayectoria</td>
            	<td>Fibra / Coaxial</td>
            	<td>Especificacion del cable</td>
            	<td>Del Poste</td>
            	<td>Al poste</td>
            	<td>Distancia entre postes</td>
            	<td>Peso Kg/Km de trayectoria</td>
            	<td>Kg/Km de fabrica</td>
            	<td>Latitud - Longitud</td>
            	<td>Zona</td>
            	<td>Clientes</td>
            	
            </tr>
       
        
<?php
		if(isset($_POST['select'])){
			$identif = array_keys($_POST['select']);
			$query="select t.id_tap,s.nombre,c.nombre,t.poste,t.tipoposte,t.trayectoria,t.fibracoaxial,t.especificacioncable,t.delposte,t.alposte,t.distancia,t.peso,t.pesofabrica,t.latitud,t.longitud,t.zona from tap t,sucursales s,cat_calles c where t.id_sucursal=s.id_sucursal and t.calle=c.id_calle and t.id_tap in ('".implode("','",$identif)."')";
			$res=mysqli_query($conexion,$query);
			$conta=0;
			$contador=0;
			while($registro=mysqli_fetch_array($res)){

			
	
			if($contador%2==0)
				$color = "";
			else
				$color = "bgcolor='#EEEEEE'";
			
			echo "<tr ".$color.">";
				echo "<td align='left'>".$registro[0]."</td>";
				echo "<td align='left'>".$registro[1]."</td>";
				echo "<td align='left'>".$registro[2]."</td>";
				echo "<td align='left'>".$registro[3]."</td>";
				echo "<td align='left'>".$registro[4]."</td>";
				echo "<td align='left'>".$registro[5]."</td>";
				echo "<td align='left'>".$registro[6]."</td>";
				echo "<td align='left'>".$registro[7]."</td>";
				echo "<td align='left'>".$registro[8]."</td>";
				echo "<td align='left'>".$registro[9]."</td>";
				echo "<td align='left'>".$registro[10]."</td>";
				echo "<td align='left'>".$registro[11]."</td>";
				echo "<td align='left'>".$registro[12]."</td>";
				echo "<td align='left'>".$registro[13]." - ".$registro[14]."</td>";
				echo "<td align='left'>".$registro[15]."</td>";

				$query_t_u = "select * from clientes where id_tap='".$registro[0]."' and id_tipo_status not in (4,5,7,8,9,10,11)";
					$tabla_t_u = mysqli_query($conexion,$query_t_u);
					$cli="";
					while($registro_t_u = mysqli_fetch_array($tabla_t_u))
					{
						$cli=$cli.$registro_t_u[0]." - ".$registro_t_u[4]." ".$registro_t_u[5]." ".$registro_t_u[6]."<br>";
						
					}
				echo "<td>".$cli."</td>";
			echo "</tr>";
			$contador++;

			}
		}

		
		
?>
 </table>