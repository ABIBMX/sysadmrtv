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
                    <td width="100px" align="right">Cliente</td>
                    <td align="center">Fecha de Reporte</td>
                    <td align="center">Fecha de Atencion</td>
                	<td align="center">Estado</td>
            </tr>
       
        
<?php
		$contador=0;
		$_SESSION['filtro_reporte_servicio'];
		$consulta = mysqli_query($conexion,$_SESSION['filtro_reporte_servicio']);
		while(list($id,$sucursal,$n_cliente,$cliente, $fecha_r, $fecha_a,$fol,$estado) = mysqli_fetch_array($consulta)){
			if($contador%2==0)
				$color = "";
			else
				$color = "bgcolor='#EEEEEE'";
			
			echo "<tr $color>";
				echo "<td align='left'>".$id."</td>";
				echo "<td align='left'>".$sucursal."</td>";
				echo "<td align='left'>".$n_cliente."</td>";
				echo "<td align='left'>".$cliente."</td>";
				echo "<td align='left'>".$fecha_r."</td>";
				echo "<td align='left'>".$fecha_a."</td>";
				echo "<td align='left'>".$estado."</td>";
			echo "</tr>";
			$contador++;
		}
?>
 </table>