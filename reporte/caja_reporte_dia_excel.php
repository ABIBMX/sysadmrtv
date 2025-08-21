<?php
	session_start();
	header("Content-Type: application/vnd.ms-excel");
	header("Content-disposition: attachment;filename=Cajas_Reporte_Dia_".date("Y/m/d").".xls");
	header("Pragma: no-cache");
	header("Expires: 0");

	require_once('../config.php');
	require_once('../conexion.php');

	
		?>
        <table border="0" cellspacing="0" cellpadding="0">
        	<tr>
            	<td colspan="7"><b>Reporte del Dia de Caja</b> Generado:&nbsp;<?php echo date("Y/m/d"); ?></td>
           	</tr>            
        </table>
         <br />
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
        	<tr bgcolor="#CCCCCC">
            	<td>Sucursal</td>
                <td>Ingresos del D&iacute;a</td>
                <td>Egresos del D&iacute;a</td>
                <td>Depositos del D&iacute;a</td>
                <td>Caja Anterior</td>
                <th>Caja Actual</th>               
            </tr>
       
        
<?php
		$contador=0;
		
		if(isset($_SESSION['tuvision_id_sucursal']))
			$add_query = " where id_sucursal='".$_SESSION['tuvision_id_sucursal']."'";
		else
		{
			$total_ingresos = $total_egresos = $total_depositos = $total_caja = 0.0;
		}
		
		$tabla = mysqli_query($conexion,"select * from sucursales ".$add_query);
		while(list($id,$sucursal) = mysqli_fetch_array($tabla))
		{
			echo "<tr $color><td>$sucursal</td>";
			
			$query =  "select  (select sum(cantidad) from cajas where id_sucursal=c.id_sucursal and id_tipo_operacion=1 and fecha_operacion=current_date()), (select sum(cantidad) from cajas where id_sucursal=c.id_sucursal and id_tipo_operacion=2 and fecha_operacion=current_date()),(select sum(cantidad) from cajas where id_sucursal=c.id_sucursal and id_tipo_operacion=3 and fecha_operacion=current_date()),c.caja_anterior, c.caja_actual from cajas c where c.id_sucursal='".addslashes($id)."' order by fecha_operacion desc, id_caja desc limit 1";
			
			$caja = devolverValorQuery($query);
			
			if($contador%2==0)
				$color = "";
			else
				$color = "bgcolor='#EEEEEE'";
			if($caja[0]=="")
				$caja[0] = "0.00";
			if($caja[1]=="")
				$caja[1] = "0.00";
			if($caja[2]=="")
				$caja[2] = "0.00";
			
			if($caja[3]=="")
			{
				$caja[3]="0.00";$caja[4]="0.00";
			}		
			
			$total_ingresos += $caja[0];
			$total_egresos += $caja[1];
			$total_depositos += $caja[2];
			$total_caja += $caja[4];
			
			echo "<td align='left'>".number_format($caja[0],2, '.', ',')."</td>";
			echo "<td align='left'>".number_format($caja[1],2, '.', ',')."</td>";
			echo "<td align='left'>".number_format($caja[2],2, '.', ',')."</td>";
			echo "<td align='left'>".number_format($caja[3],2, '.', ',')."</td>";
			echo "<td align='left'>".number_format($caja[4],2, '.', ',')."</td>";
			
			
		
			echo "</tr>";
			$contador++;
		}
		
		if(!isset($_SESSION['tuvision_id_sucursal']))
		{
			echo "<tr><td><b>TOTALES</b></td><td align='left'><b>".number_format($total_ingresos,2, '.', ',')."</b></td><td align='left'><b>".number_format($total_egresos,2, '.', ',')."</b></td><td align='left'><b>".number_format($total_depositos,2, '.', ',')."</b></td><td></td><td align='left'><b>".number_format($total_caja,2, '.', ',')."</b></td></tr>";
			
		}
?>
 </table>