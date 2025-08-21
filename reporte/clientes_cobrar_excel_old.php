<?php
	session_start();
	header("Content-Type: application/vnd.ms-excel");
	header("Content-disposition: attachment;filename=Ingresos_".date("Y/m/d").".xls");
	header("Pragma: no-cache");
	header("Expires: 0");

	require_once('../config.php');
	require_once('../conexion.php');

	
		?>
        <table border="0" cellspacing="0" cellpadding="0">
        	<tr>
            	<td colspan="7"><b>Reporte de Clientes a Cobrar</b> Generado:&nbsp;<?php echo date("Y/m/d"); ?></td>
           	</tr>            
        </table>
         <br />
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
        	<tr bgcolor="#CCCCCC">
            	 <td>ID Cliente</td>
                <td>Nombre</td>
				<td>Telefono</td>
                <td>Sucursal</td>
                <td>Calle</td>
                <td>Numero</td>
                <td>ID Tap</td>
                <td>Referencia</td>
                <td>Saldo Actual</td>
                <td>Status</td>
                
            </tr>
       
        
<?php
		$contador=0;
		
		$consulta = mysqli_query($conexion,$_SESSION['tuvision_filtro_clientes_cobrar']);
		while(list($id,$nombre,$telefono,$sucursal,$calle,$numero,$tap,$referencia, $saldo, $status) = mysqli_fetch_array($consulta)){
			if($contador%2==0)
				$color = "";
			else
				$color = "bgcolor='#EEEEEE'";
			
			echo "<tr $color>";
				echo "<td align='left'>".$id."</td>";
				echo "<td align='left'>".$nombre."</td>";
				echo "<td align='left'>".$telefono."</td>";
				echo "<td align='left'>".$sucursal."</td>";
				echo "<td align='left'>".$calle."</td>";
				echo "<td align='left'>".$numero."</td>";
				echo "<td align='left'>".$tap."</td>";
				echo "<td align='left'>".$referencia."</td>";
				echo "<td align='left'>".$saldo."</td>";
				echo "<td align='left'>".$status."</td>";
			echo "</tr>";
			$contador++;
		}
?>
 </table>