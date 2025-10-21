<?php
	session_start();
	header("Content-Type: application/vnd.ms-excel");
	header("Content-disposition: attachment;filename=Caja".date("Y/m/d").".xls");
	header("Pragma: no-cache");
	header("Expires: 0");

	require_once('../config.php');
	require_once('../conexion.php');

		if(isset($_SESSION['general_desde_contrato'])&&isset($_SESSION['general_hasta_contrato']))
		{
			$cadena_fechas1 = "<br/> Fecha contrato del ".$_SESSION['general_desde_contrato']." al ".$_SESSION['general_hasta_contrato'];
		}
		if(isset($_SESSION['general_desde_activacion'])&&isset($_SESSION['general_hasta_activacion']))
		{
			$cadena_fechas2 = "<br/> Fecha activacion del ".$_SESSION['general_desde_activacion']." al ".$_SESSION['general_hasta_activacion'];
		}	
		?>
        <table border="0" cellspacing="0" cellpadding="0">
        	<tr>
            	<td colspan="7"><b>Reporte General de Clientes</b><?php echo $cadena_fechas1.$cadena_fechas2; ?><br/>Generado:&nbsp;<?php echo date("Y/m/d"); ?></td>
           	</tr>            
        </table>
         <br />
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
        	<tr bgcolor="#CCCCCC">
            	<td>Sucursal</td>
                    <td>Activos</td>
                    <td>Cancelados</td>
                    <td>Pendientes de Instalar</td>
                    <td>Total</td>         
            </tr>
       
        
<?php
		$contador=0;
		$total_activos = 0;
		$total_cancelados = 0;
		$total_pendientes = 0;
		$total_total = 0;
		$consulta = mysqli_query($conexion,$_SESSION['tuvision_general_clientes']);
		while(list($sucursal,$activos,$cancelados,$pendientes,$total) = mysqli_fetch_array($consulta)){
			
			$total_activos += $activos;
			$total_cancelados += $cancelados;
			$total_pendientes += $pendientes;
			$total = $activos + $cancelados + $pendientes;
			$total_total += $total;
			
			if($contador%2==0)
				$color = "";
			else
				$color = "bgcolor='#EEEEEE'";
			
			echo "<tr $color>";
				echo "<td align='left'>".$sucursal."</td>";
				echo "<td align='left'>".$activos."</td>";
				echo "<td align='left'>".$cancelados."</td>";
				echo "<td align='left'>".$pendientes."</td>";
				echo "<td align='left'>".$total."</td>";
			echo "</tr>";
			$contador++;
		}
		echo "<tr $color>";
				echo "<td align='left'><b>TOTALES</b></td>";
				echo "<td align='left'><b>".$total_activos."</b></td>";
				echo "<td align='left'><b>".$total_cancelados."</b></td>";
				echo "<td align='left'><b>".$total_pendientes."</b></td>";
				echo "<td align='left'><b>".$total_total."</b></td>";
			echo "</tr>";
?>
 </table>