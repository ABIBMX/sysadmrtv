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
            	<td colspan="7"><b>Reporte General de Clientes por Tap</b> Generado:&nbsp;<?php echo date("Y/m/d"); ?></td>
           	</tr>            
        </table>
         <br />
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
        	<tr bgcolor="#CCCCCC">
            	 <td>ID TAP</td>
                    <td>Valor</td>
                    <td>Salidas</td>
                    <td>Sucursal</td>
                    <td>Cantidad Clientes</td>               
            </tr>
       
        
<?php
		$contador=0;
		
		$consulta = mysqli_query($conexion,$_SESSION['tuvision_general_clientes_tap']);
		while(list($id,$valor,$salidas,$sucursal,$cantidad) = mysqli_fetch_array($consulta)){
			if($contador%2==0)
				$color = "";
			else
				$color = "bgcolor='#EEEEEE'";
			
			echo "<tr $color>";
				echo "<td align='left'>".$id."</td>";
				echo "<td align='left'>".$valor."</td>";
				echo "<td align='left'>".$salidas."</td>";
				echo "<td align='left'>".$sucursal."</td>";
				echo "<td align='left'>".$cantidad."</td>";
			echo "</tr>";
			$contador++;
		}
?>
 </table>