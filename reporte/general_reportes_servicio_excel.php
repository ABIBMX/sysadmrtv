<?php
	session_start();
	header("Content-Type: application/vnd.ms-excel");
	header("Content-disposition: attachment;filename=Reporte".date("Y/m/d").".xls");
	header("Pragma: no-cache");
	header("Expires: 0");

	require_once('../config.php');
	require_once('../conexion.php');
		
		if(isset($_SESSION['general_desde_reporte'])&&isset($_SESSION['general_hasta_reporte']))
		{
			$cadena_fechas1 = "<br/> Fecha de reporte del ".$_SESSION['general_desde_reporte']." al ".$_SESSION['general_hasta_reporte'];
		}
		if(isset($_SESSION['general_desde_atencion'])&&isset($_SESSION['general_hasta_atencion']))
		{
			$cadena_fechas2 = "<br/> Fecha atencion del ".$_SESSION['general_desde_atencion']." al ".$_SESSION['general_hasta_atencion'];
		}	
		
		
		?>
        <table border="0" cellspacing="0" cellpadding="0">
        	<tr>
            	<td colspan="7"><b>Reporte General de Reportes de Servicio</b><?php echo $cadena_fechas1.$cadena_fechas2; ?><br/>Generado:&nbsp;<?php echo date("Y/m/d"); ?></td>
           	</tr>            
        </table>
         <br />
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
        	<tr bgcolor="#CCCCCC">
            	  <td>Sucursal</td>
                    <td>En Proceso</td>
                    <td>Atendidos</td>
                    <td>Cancelados</td>
                    <td>Total</td>         
            </tr>
       
        
<?php
		$contador=0;
		$total_proceso = 0;
		$total_atendidos = 0;
		$total_cancelados = 0;
		$total_total = 0;
		$consulta = mysqli_query($conexion,$_SESSION['tuvision_general_reportes_servicio']);
		while(list($sucursal,$proceso,$atendidos,$cancelados,$total) = mysqli_fetch_array($consulta)){
			
			$total_proceso += $proceso;
			$total_atendidos += $atendidos;
			$total_cancelados += $cancelados;
			$total = $proceso + $atendidos + $cancelados;
			$total_total += $total;
			
			if($contador%2==0)
				$color = "";
			else
				$color = "bgcolor='#EEEEEE'";
			
			echo "<tr $color>";
				echo "<td align='left'>".$sucursal."</td>";
				echo "<td align='left'>".$proceso."</td>";
				echo "<td align='left'>".$atendidos."</td>";
				echo "<td align='left'>".$cancelados."</td>";
				echo "<td align='left'>".$total."</td>";
			echo "</tr>";
			$contador++;
		}
		echo "<tr $color>";
				echo "<td align='left'><b>TOTALES</b></td>";
				echo "<td align='left'><b>".$total_proceso."</b></td>";
				echo "<td align='left'><b>".$total_atendidos."</b></td>";
				echo "<td align='left'><b>".$total_cancelados."</b></td>";
				echo "<td align='left'><b>".$total_total."</b></td>";
			echo "</tr>";
?>
 </table>