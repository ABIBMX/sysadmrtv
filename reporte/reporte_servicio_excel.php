<?php
	session_start();
	header("Content-Type: application/vnd.ms-excel");
	header("Content-disposition: attachment;filename=Reporte_servicio_".date("Y/m/d").".xls");
	header("Pragma: no-cache");
	header("Expires: 0");

	require_once('../config.php');
	require_once('../conexion.php');

	
		?>
        <table border="0" cellspacing="0" cellpadding="0">
        	<tr>
            	<td colspan="7"><b>Reporte de Servicios</b> Generado:&nbsp;<?php echo date("Y/m/d"); ?></td>
           	</tr>            
        </table>
         <br />
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
        	<tr bgcolor="#CCCCCC">
            	 <td>Folio</td>               
                    <td>Sucursal</td>
                    <td>N. de Cliente</td>
                    <td width="100px" align="center">Cliente</td>
                    <td align="center">Fecha de Reporte</td>
                    <td align="center">Fecha de Atencion</td>
					<td align="center">Servicio</td>
                	<td align="center">Estado</td>
            </tr>
       
        
<?php
		$contador=0;
		$_SESSION['filtro_reporte_servicio2'];
		$consulta = mysqli_query($conexion,$_SESSION['filtro_reporte_servicio2']);
		while(list($id, $sucur, $num_cliente, $cliente, $f_reporte, $f_atencion, $folio, $estado, $id_estatus, $servicio) = mysqli_fetch_array($consulta)){
			if($contador%2==0)
				$color = "";
			else
				$color = "bgcolor='#EEEEEE'";
			
			echo "<tr $color>";
				echo "<td align='left'>".$folio."</td>";
				echo "<td align='left'>".$sucur."</td>";
				echo "<td align='left'>".$num_cliente."</td>";
				echo "<td align='left'>".$cliente."</td>";
				echo "<td align='left'>".$f_reporte."</td>";
				echo "<td align='left'>".$f_atencion."</td>";
				echo "<td align='left'>".$servicio."</td>";
				echo "<td align='left'>".$estado."</td>";
			echo "</tr>";
			$contador++;
		}
?>
 </table>