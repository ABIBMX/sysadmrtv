<?php
	session_start();
	header("Content-Type: application/vnd.ms-excel");
	header("Content-disposition: attachment;filename=Caja".date("Y/m/d").".xls");
	header("Pragma: no-cache");
	header("Expires: 0");

	require_once('../config.php');
	require_once('../conexion.php');

	
		?>
        <table border="0" cellspacing="0" cellpadding="0">
        	<tr>
            	<td colspan="7"><b>Reporte de Caja</b> Generado:&nbsp;<?php echo date("Y/m/d"); ?></td>
           	</tr>            
        </table>
         <br />
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
        	<tr bgcolor="#CCCCCC">
            	<td>ID Operaci&oacute;n</td>
                <td>Sucursal</td>
                <td>Tipo Operacion</td>
                <td>Cantidad</td>
                <td>Concepto</td>
                <td>ID Cliente</td>
                <td>Referencia</td>
                <td>Caja Anterior</td>
                <td>Caja Actual</td>
                <td>Fecha Operaci&oacute;n</td>
                <td>Hora Operaci&oacute;n</td>                 
            </tr>
       
        
<?php
		$contador=0;
		
		$consulta = mysqli_query($conexion,$_SESSION['filtro_caja']);
		while(list($id,$sucursal,$tipo_operacion,$cantidad,$caja_anterior,$caja_actual,$fecha_operacion,$hora_operacion,$concepto,$id_cliente,$referencia) = mysqli_fetch_array($consulta)){
			if($contador%2==0)
				$color = "";
			else
				$color = "bgcolor='#EEEEEE'";
			
			echo "<tr $color>";
				echo "<td align='left'>".$id."</td>";
				echo "<td align='left'>".$sucursal."</td>";
				echo "<td align='left'>".$tipo_operacion."</td>";
				echo "<td align='left'>".$cantidad."</td>";
				echo "<td align='left'>".$concepto."</td>";
				echo "<td align='left'>".$id_cliente."</td>";
				echo "<td align='left'>".$referencia."</td>";
				echo "<td align='left'>".$caja_anterior."</td>";
				echo "<td align='left'>".$caja_actual."</td>";
				echo "<td align='left'>".$fecha_operacion."</td>";
				echo "<td align='left'>".$hora_operacion."</td>";
			echo "</tr>";
			$contador++;
		}
?>
 </table>