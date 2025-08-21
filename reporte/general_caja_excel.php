<?php
	session_start();
	header("Content-Type: application/vnd.ms-excel");
	header("Content-disposition: attachment;filename=Reporte".date("Y/m/d").".xls");
	header("Pragma: no-cache");
	header("Expires: 0");

	require_once('../config.php');
	require_once('../conexion.php');
	require_once('../funciones.php');
		
		if(isset($_SESSION['general_desde_caja'])&&isset($_SESSION['general_hasta_caja']))
		{
			$cadena_fechas = "<br/> Del ".$_SESSION['general_desde_caja']." al ".$_SESSION['general_hasta_caja'];
		}
		
		
		?>
        <table border="0" cellspacing="0" cellpadding="0">
        	<tr>
            	<td colspan="7"><b>Reporte General de Caja</b><?php echo $cadena_fechas; ?><br/>Generado:&nbsp;<?php echo date("Y/m/d"); ?></td>
           	</tr>            
        </table>
         <br />
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
        	<tr bgcolor="#CCCCCC">
            	 <td>Sucursal</td>
                    <td align="right">Ingresos</td>
                    <td align="right">Egresos</td>
                    <td align="right">Depositos</td>
                    <td align="right">Total</td>        
            </tr>
       
        
<?php
		$contador=0;
		$total_ingresos = 0;
		$total_egresos = 0;
		$total_depositos = 0;
		$total_total = 0;
		
		$consulta = mysqli_query($conexion,$_SESSION['tuvision_general_caja']);
		while(list($sucursal,$ingresos,$egresos,$depositos,$total) = mysqli_fetch_array($consulta)){
			
			$total_ingresos += $ingresos;
			$total_egresos += $egresos;
			$total_depositos += $depositos;
			$total = $ingresos - $egresos - $depositos;
			$total_total += $total;
			
			if($contador%2==0)
				$color = "";
			else
				$color = "bgcolor='#EEEEEE'";
			
			echo "<tr $color>";
				echo "<td align='left'>".$sucursal."</td>";
				echo "<td align='left'>".convertirNumero($ingresos)."</td>";
				echo "<td align='left'>".convertirNumero($egresos)."</td>";
				echo "<td align='left'>".convertirNumero($depositos)."</td>";
				echo "<td align='left'>".convertirNumero($total)."</td>";
			echo "</tr>";
			$contador++;
		}
		echo "<tr $color>";
				echo "<td align='left'><b>TOTALES</b></td>";
				echo "<td align='left'><b>".convertirNumero($total_ingresos)."</b></td>";
				echo "<td align='left'><b>".convertirNumero($total_egresos)."</b></td>";
				echo "<td align='left'><b>".convertirNumero($total_depositos)."</b></td>";
				echo "<td align='left'><b>".convertirNumero($total_total)."</b></td>";
			echo "</tr>";
?>
 </table>