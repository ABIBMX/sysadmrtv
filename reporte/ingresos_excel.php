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
            	<td colspan="7"><b>Reporte de Ingresos</b> Generado:&nbsp;<?php echo date("Y/m/d"); ?></td>
           	</tr>            
        </table>
         <br />
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
        	<tr bgcolor="#CCCCCC">
            	 <td>Folio</td>               
                    <td>Sucursal</td>
                    <td>Cliente</td>
                    <td>Nota Impresa</td>                  
                    <td width="100px" align="right">Monto</td>
                    <td  width="300px" align="center">Observaciones</td>
                    <td align="center">Fecha</td>
                
            </tr>
       
        
<?php
		$contador=0;
		
		$consulta = mysqli_query($conexion,$_SESSION['filtro_ingresos']);
		while(list($id,$folio,$sucursal,$cliente,$nombre,$apellidop,$apellidom,$nota,$monto,$observaciones, $fecha) = mysqli_fetch_array($consulta)){
			if($contador%2==0)
				$color = "";
			else
				$color = "bgcolor='#EEEEEE'";
			
			echo "<tr $color>";
				echo "<td align='left'>".$folio."</td>";
				echo "<td align='left'>".$sucursal."</td>";
				echo "<td align='left'>".$cliente." ".$nombre." ".$apellidop." ".$apellidom."</td>";
				echo "<td align='left'>".$nota."</td>";
				echo "<td align='left'>".$monto."</td>";
				echo "<td align='left'>".$observaciones."</td>";
				echo "<td align='left'>".$fecha."</td>";
			echo "</tr>";
			$contador++;
		}
?>
 </table>